<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class MY_Upload extends CI_Upload
    {

        protected $_CI = '';

        public function __construct($props = array())
        {
            parent::__construct($props);

            $this->_CI = & get_instance();
        }

        // --------------------------------------------------------------------

        public function dryRunUpload($field = 'userfile')
        {
            // Is $_FILES[$field] set? If not, no reason to continue.
            if (!isset($_FILES[$field]))
            {
                $this->set_error('upload_no_file_selected');
                return FALSE;
            }

            // Is the upload path valid?
            if (!$this->validate_upload_path())
            {
                // errors will already be set by validate_upload_path() so just return FALSE
                return FALSE;
            }

            // Was the file able to be uploaded? If not, determine the reason why.
            if (!is_uploaded_file($_FILES[$field]['tmp_name']))
            {
                $error = (!isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];

                switch ($error)
                {
                    case 1: // UPLOAD_ERR_INI_SIZE
                        $this->set_error('upload_file_exceeds_limit');
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        $this->set_error('upload_file_exceeds_form_limit');
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                        $this->set_error('upload_file_partial');
                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                        $this->set_error('upload_no_file_selected');
                        break;
                    case 6: // UPLOAD_ERR_NO_TMP_DIR
                        $this->set_error('upload_no_temp_directory');
                        break;
                    case 7: // UPLOAD_ERR_CANT_WRITE
                        $this->set_error('upload_unable_to_write_file');
                        break;
                    case 8: // UPLOAD_ERR_EXTENSION
                        $this->set_error('upload_stopped_by_extension');
                        break;
                    default : $this->set_error('upload_no_file_selected');
                        break;
                }

                return FALSE;
            }


            // Set the uploaded data as class variables
            $this->file_temp = $_FILES[$field]['tmp_name'];
            $this->file_size = $_FILES[$field]['size'];
            $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
            $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
            $this->file_name = $this->_prep_filename($_FILES[$field]['name']);
            $this->file_ext = $this->get_extension($this->file_name);
            $this->client_name = $this->file_name;


            // Is the file type allowed to be uploaded?
            if (!$this->is_allowed_filetype())
            {
                $this->set_error('upload_invalid_filetype');
                return FALSE;
            }

            // if we're overriding, let's now make sure the new name and type is allowed
            if ($this->_file_name_override != '')
            {
                $this->file_name = $this->_prep_filename($this->_file_name_override);

                // If no extension was provided in the file_name config item, use the uploaded one
                if (strpos($this->_file_name_override, '.') === FALSE)
                {
                    $this->file_name .= $this->file_ext;
                }

                // An extension was provided, lets have it!
                else
                {
                    $this->file_ext = $this->get_extension($this->_file_name_override);
                }

                if (!$this->is_allowed_filetype(TRUE))
                {
                   
                    $this->set_error('upload_invalid_filetype');
                    return FALSE;
                }
            }

            // Convert the file size to kilobytes
            if ($this->file_size > 0)
            {
                $this->file_size = round($this->file_size / 1024, 2);
            }

            // Is the file size within the allowed maximum?
            if (!$this->is_allowed_filesize())
            {
                $this->set_error('upload_invalid_filesize');
                return FALSE;
            }

            // Are the image dimensions within the allowed size?
            // Note: This can fail if the server has an open_basdir restriction.
            if (!$this->is_allowed_dimensions())
            {
                $this->set_error('upload_invalid_dimensions');
                return FALSE;
            }

            // Sanitize the file name for security
//            $this->file_name = $this->clean_file_name($this->file_name);
            // Truncate the file name if it's too long
            if ($this->max_filename > 0)
            {
                $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
            }

            // Remove white spaces in the name
            if ($this->remove_spaces == TRUE)
            {
                $this->file_name = preg_replace("/\s+/", "_", $this->file_name);
            }

            /*
             * Validate the file name
             * This function appends an number onto the end of
             * the file if one with the same name already exists.
             * If it returns false there was a problem.
             */
            $this->orig_name = $this->file_name;

            if ($this->overwrite == FALSE)
            {
                $this->file_name = $this->set_filename($this->upload_path, $this->file_name);

                if ($this->file_name === FALSE)
                {
                    return FALSE;
                }
            }

            /*
             * Run the file through the XSS hacking filter
             * This helps prevent malicious code from being
             * embedded within a file.  Scripts can easily
             * be disguised as images or other file types.
             */
            if ($this->xss_clean)
            {
                if ($this->do_xss_clean() === FALSE)
                {
                    $this->set_error('upload_unable_to_write_file');
                    return FALSE;
                }
            }

            return TRUE;
        }

        public function dryRunUpload_Move($field, $file_name = '', $upload_path = null)
        {
            /*
             * Move the file to the final destination
             * To deal with different server configurations
             * we'll attempt to use copy() first.  If that fails
             * we'll use move_uploaded_file().  One of the two should
             * reliably work in most environments
             */

            $this->file_temp = $_FILES[$field]['tmp_name'];
            $this->file_size = $_FILES[$field]['size'];
            $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
            $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
            $this->file_name = $this->_prep_filename($_FILES[$field]['name']);
            $this->file_ext = $this->get_extension($this->file_name);
            $this->client_name = $this->file_name;

            if (isset($file_name))
            {
                $this->file_name = $file_name;
            }

            if (empty($upload_path))
            {
                $tmp_upload_path = $this->upload_path;
            }
            else
            {
                $tmp_upload_path = $upload_path;
            }


            if (!@copy($this->file_temp, $tmp_upload_path . $this->file_name))
            {
                if (!@move_uploaded_file($this->file_temp, $tmp_upload_path . $this->file_name))
                {
                    $this->set_error('upload_destination_error');
                    return FALSE;
                }
            }
        }

        // --------------------------------------------------------------------

        /**
         * Finalized Data Array
         *
         * Returns an associative array containing all of the information
         * related to the upload, allowing the developer easy access in one array.
         *
         * @return	array
         */
        public function data($index = null)
        {
            $return = array(
                'file_name' => $this->file_name,
                'file_type' => $this->file_type,
                'file_path' => $this->upload_path,
                'full_path' => $this->upload_path . $this->file_name,
                'raw_name' => str_replace($this->file_ext, '', $this->file_name),
                'orig_name' => $this->orig_name,
                'client_name' => $this->client_name,
                'file_ext' => $this->file_ext,
                'file_size' => $this->file_size,
                'is_image' => $this->is_image(),
                'image_width' => $this->image_width,
                'image_height' => $this->image_height,
                'image_type' => $this->image_type,
                'image_size_str' => $this->image_size_str,
            );

            if (!empty($index) && array_key_exists($index, $return))
            {
                $return = $return[$index];
            }

            return $return;
        }

        public function validate_upload($functionname, $field = 'userfile')
        {

            // Is $_FILES[$field] set? If not, no reason to continue.
            if (!isset($_FILES[$field]))
            {
                $this->_CI->form_validation->set_message($functionname, lang('upload_no_file_selected'));
                return FALSE;
            }

            // Is the upload path valid?
            if (!$this->customvalidate_upload_path($functionname))
            {
                $this->_CI->form_validation->set_message($functionname, lang('imglib_vaild_path'));
                return FALSE;
            }


            // retrieve the number of images uploaded;
            $number_of_files = sizeof($_FILES[$field]['tmp_name']);
            // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
            $errors = array();


            if (is_array($_FILES[$field]['tmp_name']))
            {
                // first make sure that there is no error in uploading the files
                for ($i = 0; $i < $number_of_files; $i++)
                {
                    if (!empty($_FILES[$field]['tmp_name'][$i]))
                    {

                        // Set the uploaded data as class variables
                        $this->file_temp = $_FILES[$field]['tmp_name'][$i];
                        $this->file_size = $_FILES[$field]['size'][$i];
                        $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type'][$i]);
                        $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
                        $this->file_name = $this->_prep_filename($_FILES[$field]['name'][$i]);
                        $this->file_ext = $this->get_extension($this->file_name);
                        $this->client_name = $this->file_name;

                        // Is the file type allowed to be uploaded?
                        if (!$this->is_allowed_filetype())
                        {

                            $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filetype'));
                            return FALSE;
                        }

                        // if we're overriding, let's now make sure the new name and type is allowed
                        if ($this->_file_name_override != '')
                        {
                            $this->file_name = $this->_prep_filename($this->_file_name_override);

                            // If no extension was provided in the file_name config item, use the uploaded one
                            if (strpos($this->_file_name_override, '.') === FALSE)
                            {
                                $this->file_name .= $this->file_ext;
                            }

                            // An extension was provided, lets have it!
                            else
                            {
                                $this->file_ext = $this->get_extension($this->_file_name_override);
                            }

                            if (!$this->is_allowed_filetype(TRUE))
                            {
                                // $this->set_error('upload_invalid_filetype');
                                $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filetype'));
                                return FALSE;
                            }
                        }

                        // Convert the file size to kilobytes
                        if ($this->file_size > 0)
                        {
                            $this->file_size = round($this->file_size / 1024, 2);
                        }

                        // Is the file size within the allowed maximum?
                        if (!$this->is_allowed_filesize())
                        {
                            // $this->set_error('upload_invalid_filesize');
                            $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filesize'));
                            return FALSE;
                        }

                        // Are the image dimensions within the allowed size?
                        // Note: This can fail if the server has an open_basdir restriction.
                        if (!$this->is_allowed_dimensions())
                        {
                            // $this->set_error('upload_invalid_dimensions');
                            $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_dimensions'));
                            return FALSE;
                        }

                        // Sanitize the file name for security
//            $this->file_name = $this->clean_file_name($this->file_name);
                        // Truncate the file name if it's too long
                        if ($this->max_filename > 0)
                        {
                            $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
                        }

                        // Remove white spaces in the name
                        if ($this->remove_spaces == TRUE)
                        {
                            $this->file_name = preg_replace("/\s+/", "_", $this->file_name);
                        }

                        /*
                         * Validate the file name
                         * This function appends an number onto the end of
                         * the file if one with the same name already exists.
                         * If it returns false there was a problem.
                         */
                        $this->orig_name = $this->file_name;

                        if ($this->overwrite == FALSE)
                        {
                            $this->file_name = $this->set_filename($this->upload_path, $this->file_name);

                            if ($this->file_name === FALSE)
                            {
                                return FALSE;
                            }
                        }

                        /*
                         * Run the file through the XSS hacking filter
                         * This helps prevent malicious code from being
                         * embedded within a file.  Scripts can easily
                         * be disguised as images or other file types.
                         */
                        if ($this->xss_clean)
                        {
                            if ($this->do_xss_clean() === FALSE)
                            {
                                //$this->set_error('upload_unable_to_write_file');
                                $this->_CI->form_validation->set_message($functionname, lang('upload_unable_to_write_file'));
                                return FALSE;
                            }
                        }
                    }
                } //end for 
            }
            else  //  For Single File
            {
                if (!empty($_FILES[$field]['tmp_name']))
                {

                    // Set the uploaded data as class variables
                    $this->file_temp = $_FILES[$field]['tmp_name'];
                    $this->file_size = $_FILES[$field]['size'];
                    $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
                    $this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
                    $this->file_name = $this->_prep_filename($_FILES[$field]['name']);
                    $this->file_ext = $this->get_extension($this->file_name);
                    $this->client_name = $this->file_name;

                    // Is the file type allowed to be uploaded?
                    if (!$this->is_allowed_filetype())
                    {
                        $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filetype'));
                        return FALSE;
                    }

                    // if we're overriding, let's now make sure the new name and type is allowed
                    if ($this->_file_name_override != '')
                    {
                        $this->file_name = $this->_prep_filename($this->_file_name_override);

                        // If no extension was provided in the file_name config item, use the uploaded one
                        if (strpos($this->_file_name_override, '.') === FALSE)
                        {
                            $this->file_name .= $this->file_ext;
                        }

                        // An extension was provided, lets have it!
                        else
                        {
                            $this->file_ext = $this->get_extension($this->_file_name_override);
                        }

                        if (!$this->is_allowed_filetype(TRUE))
                        {
                            // $this->set_error('upload_invalid_filetype');
                            $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filetype'));
                            return FALSE;
                        }
                    }

                    // Convert the file size to kilobytes
                    if ($this->file_size > 0)
                    {
                        $this->file_size = round($this->file_size / 1024, 2);
                    }

                    // Is the file size within the allowed maximum?
                    if (!$this->is_allowed_filesize())
                    {
                        // $this->set_error('upload_invalid_filesize');
                        $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_filesize'));
                        return FALSE;
                    }

                    // Are the image dimensions within the allowed size?
                    // Note: This can fail if the server has an open_basdir restriction.
                    if (!$this->is_allowed_dimensions())
                    {
                        // $this->set_error('upload_invalid_dimensions');
                        $this->_CI->form_validation->set_message($functionname, lang('upload_invalid_dimensions'));
                        return FALSE;
                    }

                    // Sanitize the file name for security
//            $this->file_name = $this->clean_file_name($this->file_name);
                    // Truncate the file name if it's too long
                    if ($this->max_filename > 0)
                    {
                        $this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
                    }

                    // Remove white spaces in the name
                    if ($this->remove_spaces == TRUE)
                    {
                        $this->file_name = preg_replace("/\s+/", "_", $this->file_name);
                    }

                    /*
                     * Validate the file name
                     * This function appends an number onto the end of
                     * the file if one with the same name already exists.
                     * If it returns false there was a problem.
                     */
                    $this->orig_name = $this->file_name;

                    if ($this->overwrite == FALSE)
                    {
                        $this->file_name = $this->set_filename($this->upload_path, $this->file_name);

                        if ($this->file_name === FALSE)
                        {
                            return FALSE;
                        }
                    }

                    /*
                     * Run the file through the XSS hacking filter
                     * This helps prevent malicious code from being
                     * embedded within a file.  Scripts can easily
                     * be disguised as images or other file types.
                     */
                    if ($this->xss_clean)
                    {
                        if ($this->do_xss_clean() === FALSE)
                        {
                            //$this->set_error('upload_unable_to_write_file');
                            $this->_CI->form_validation->set_message($functionname, lang('upload_unable_to_write_file'));
                            return FALSE;
                        }
                    }
                }
            }
            return TRUE;
        }

        public function customvalidate_upload_path($functionname = "userfile")
        {
            if ($this->upload_path === '')
            {
                $this->_CI->form_validation->set_message($functionname, lang('upload_no_filepath'));
                return FALSE;
            }

            if (realpath($this->upload_path) !== FALSE)
            {
                $this->upload_path = str_replace('\\', '/', realpath($this->upload_path));
            }

            if (!is_dir($this->upload_path))
            {

                $this->_CI->form_validation->set_message($functionname, lang('upload_no_filepath'));
                return FALSE;
            }

            if (!is_really_writable($this->upload_path))
            {


                $this->_CI->form_validation->set_message($functionname, lang('upload_not_writable'));
                return FALSE;
            }

            $this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/', $this->upload_path);
            return TRUE;
        }

        public function init_config(array $config = array(), $reset = TRUE)
        {
            $reflection = new ReflectionClass($this);

            if ($reset === TRUE)
            {
                $defaults = $reflection->getDefaultProperties();
                foreach (array_keys($defaults) as $key)
                {
                    if ($key[0] === '_')
                    {
                        continue;
                    }

                    if (isset($config[$key]))
                    {
                        if ($reflection->hasMethod('set_' . $key))
                        {
                            $this->{'set_' . $key}($config[$key]);
                        }
                        else
                        {
                            $this->$key = $config[$key];
                        }
                    }
                    else
                    {
                        $this->$key = $defaults[$key];
                    }
                }
            }
            else
            {
                foreach ($config as $key => &$value)
                {
                    if ($key[0] !== '_' && $reflection->hasProperty($key))
                    {
                        if ($reflection->hasMethod('set_' . $key))
                        {
                            $this->{'set_' . $key}($value);
                        }
                        else
                        {
                            $this->$key = $value;
                        }
                    }
                }
            }

            // if a file_name was provided in the config, use it instead of the user input
            // supplied file name for all uploads until initialized again
            $this->_file_name_override = $this->file_name;
            return $this;
        }

        function upload_file($fileinputname, $uploadpath, $fileconfig)
        {
            $return = "";
            // retrieve the number of images uploaded;
            $number_of_files = sizeof($_FILES[$fileinputname]['tmp_name']);
            // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
            $files = $_FILES[$fileinputname];
            $errors = array();
            if (is_array($_FILES[$fileinputname]['tmp_name']))
            { // For Multiple Files
                // first make sure that there is no error in uploading the files
                for ($i = 0; $i < $number_of_files; $i++)
                {
                    if ($_FILES[$fileinputname]['error'][$i] == 0)
                        $errors[$i][] = 'upload file ' . $_FILES[$fileinputname]['name'][$i];
                }

                if (sizeof($errors) != 0)
                {
                    // now, taking into account that there can be more than one file, for each file we will have to do the upload
                    // we first load the upload library
                    $this->_CI->load->library('Upload');
                    for ($i = 0; $i < $number_of_files; $i++)
                    {

                        if (!empty($files['tmp_name'][$i]))
                        {
                            $exts = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                            $randimg = generateRandomString();
                            $new_file_name = strtolower($randimg . "." . $exts);

                            $_FILES['uploadedfile']['name'] = $new_file_name;
                            $_FILES['uploadedfile']['type'] = $files['type'][$i];
                            $_FILES['uploadedfile']['tmp_name'] = $files['tmp_name'][$i];
                            $_FILES['uploadedfile']['error'] = $files['error'][$i];
                            $_FILES['uploadedfile']['size'] = $files['size'][$i];
                            //now we initialize the upload library
                            $this->_CI->upload->initialize($fileconfig);
                            // we retrieve the number of files that were uploaded
                            if ($this->_CI->upload->do_upload('uploadedfile'))
                            {
                                $data['uploads'][$i] = $this->_CI->upload->data();
                                $return[] = $new_file_name;
                            }
                            else
                            {
                                $data['upload_errors'][$i] = $this->_CI->upload->display_errors();
                            }
                        }
                    }
                }
            }
            else
            {  // For single file
                //now we initialize the upload library
                $exts = pathinfo($_FILES[$fileinputname]['name'], PATHINFO_EXTENSION);
                $randimg = generateRandomString();
                $new_file_name = strtolower($randimg . "." . $exts);

                $_FILES[$fileinputname]['name'] = $new_file_name;

                $this->_CI->upload->initialize($fileconfig);
                // we retrieve the number of files that were uploaded
                if ($this->_CI->upload->do_upload($fileinputname))
                {
                    $data['uploads'] = $this->_CI->upload->data();
                    $return = $new_file_name;
                }
                else
                {
                    $data['upload_errors'] = $this->_CI->upload->display_errors();
                }
            }
            return $return;
        }

    }

?>
