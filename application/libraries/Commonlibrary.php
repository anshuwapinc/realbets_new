<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /**
     * Common library function goes here
     */
    class Commonlibrary
    {

        private $_CI;    // CodeIgniter instance

        public function __construct()
        {
            $this->_CI = & get_instance();
        }

        public function generatePassword($length = 9, $strength = 0)
        {
            $vowels = 'aeuy';
            $consonants = 'bdghjmnpqrstvz';
            if ($strength & 1)
            {
                $consonants .= 'BDGHJLMNPQRSTVWXZ';
            }
            if ($strength & 2)
            {
                $vowels .= "AEUY";
            }
            if ($strength & 4)
            {
                $consonants .= '23456789';
            }
            if ($strength & 8)
            {
                $consonants .= '@#$%';
            }

            $password = '';
            $alt = time() % 2;
            for ($i = 0; $i < $length; $i++)
            {
                if ($alt == 1)
                {
                    $password .= $consonants[(rand() % strlen($consonants))];
                    $alt = 0;
                }
                else
                {
                    $password .= $vowels[(rand() % strlen($vowels))];
                    $alt = 1;
                }
            }
            return $password;
        }

        public function deleteFile($fileName)
        {
            if (file_exists($fileName))
                unlink($fileName);
        }

        public function CreateDirectory($dirname)
        {
            if (!file_exists($dirname))
            {
                mkdir($dirname, 0755);
            }
        }

        public function parseFilePath($fileType, $fileId, $module)
        {
            switch ($module)
            {
                default:
                    $fileName = $fileId . '.' . $fileType;
            }

            $this->_CI->load->config('report_config');
            $arr = $this->_CI->config->item($module);

            $fileDir = $arr['upload_path'];

            return $fileDir . $fileName;
        }

        public function is_file_uploaded($user_field = '')
        {
            $return = FALSE;

            if (isset($_FILES[$user_field]) && $_FILES[$user_field]['size'] > 0)
            {
                $return = TRUE;
            }
            return $return;
        }

        public function sendmail($to_email, $to_name, $subject, $body, $mailtype = "html", $from_name = EMAIL_FROM_NAME, $from_email = EMAIL_FROM_EMAIL, $bcc = "")
        {
            $this->_CI->load->library('email');

//            $this->_CI->email->set_protocol('sendmail');
            $this->_CI->email->from($from_email, $from_name);
            $this->_CI->email->to($to_email);

            if (!empty($bcc))
            {
                $this->_CI->email->bcc($bcc);
            }

            $this->_CI->email->set_mailtype($mailtype);
            $this->_CI->email->subject($subject);
            $this->_CI->email->message($body);
            $serverList = array('localhost', '127.0.0.1');
            if (!in_array($_SERVER['HTTP_HOST'], $serverList))
            {
                $this->_CI->email->send();
            }

//            $this->email->attach()
//            if ($this->_CI->email->send())
//            {
//                echo 'Your email was sent, successfully.';
//            }
//            else
//            {
//                show_error($this->_CI->email->print_debugger());
//            }
        }

        public function rrmdir($dir)
        {
            if (is_dir($dir))
            {
                $objects = scandir($dir);
                foreach ($objects as $object)
                {
                    if ($object != "." && $object != "..")
                    {
                        if (filetype($dir . "/" . $object) == "dir")
                            rrmdir($dir . "/" . $object);
                        else
                            unlink($dir . "/" . $object);
                    }
                }
                reset($objects);
                rmdir($dir);
            }
        }

        
        public function getdrodownoption($arr_tmp)
        {
            $return = $this->_CI->load->viewPartial("dropdown", $arr_tmp);
            return $return;
        }

        public function gettagsjson($query)
        {
            $this->_CI->load->model('Tag_model');
            $arr_tags = $this->_CI->Tag_model->getalltagsjson($query);
            $arr = array();

            $i = 0;
            foreach ($arr_tags as $tagsRecord)
            {
                $arr[$i]["value"] = $tagsRecord["tag_name"];
                $arr[$i]["data"] = $tagsRecord["tag_id"];

                $i++;
            }

            return json_encode($arr);
        }

        public function getpreviewlink($file_name, $base_url = '')
        {

            $preview_link = '';
            $tmp_base_url = '';
            if (!isset($base_url) || $base_url == '')
            {
                $tmp_base_url = base_url();
            }
            else
            {
                $tmp_base_url = $base_url;
            }
            
            if (file_exists($file_name))
            {
                
                $preview_link = '<a rel="' . $tmp_base_url . $file_name . '" href="' . $tmp_base_url . $file_name . '" class="preview">Click here to preview <i class="action-icon fa fa-image"></i></a>';
            }

//                $preview_link = '<a href="' . $tmp_base_url . $file_name . '" class="preview"><img src="assets/admin-images/icons/preview.png" alt="Preview" title="Preview" /></a>';
//        
            return $preview_link;
        }

        public function getbusinessimagefilepath($imagename = NULL)
        {


            $arr = getCustomConfigItem('business_pic');
            $fileDir = $arr['upload_path'];
            $filepath = $fileDir . $imagename;
            return $filepath;
        }

        public function unlinkFile($file_name, $file_path)
        {
            $this->_CI->load->helper('path_helper');
            $path_system = set_realpath($file_path);
            $unlink_file_name = $path_system . $file_name;

            if (file_exists($unlink_file_name))
            {
                unlink($unlink_file_name);
            }
        }

        /// $arr : config item of file
        public function upload_files($arr, $file_name, $file_type)
        {
            $return = array();
            $filename = $file_name;
            $exts = pathinfo($filename, PATHINFO_EXTENSION);
            $randimg = generateRandomString();
            $arr_doc_type = explode("/", $file_type);
            $ext = "." . $arr_doc_type[1];
            $return['location_doc'] = strtolower($randimg . "." . $exts);
            $return['tmp_upload_path'] = $arr['upload_path'];
            return $return;
        }

        public function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL)
        {
            $t = & get_instance();
            $slug = url_title($string);
            $slug = strtolower($slug);
            $i = 0;
            $params = array();
            $params[$field] = $slug;

            if ($key)
                $params["$key !="] = $value;

            while ($t->db->where($params)->get($table)->num_rows())
            {
                if (!preg_match('/-{1}[0-9]+$/', $slug))
                    $slug .= '-' . ++$i;
                else
                    $slug = preg_replace('/[0-9]+$/', ++$i, $slug);

                $params [$field] = $slug;
            }
            return $slug;
        }

        public function get_subcategory_json($query)
        {
            $this->_CI->load->model('Subcategory_model');
            $arr_subcategory = $this->_CI->Subcategory_model->getallsubcategoryjson($query);
            $arr = array();

            $i = 0;
            foreach ($arr_subcategory as $subcategoryRecord)
            {
                $arr[$i]["id"] = $subcategoryRecord["subcategory_name"];
                $arr[$i]["text"] = $subcategoryRecord["subcategory_name"];

                $i++;
            }

            return json_encode($arr);
        }

        public function get_city_json($query)
        {
            $this->_CI->load->model('City_model');
            $arr_city = $this->_CI->City_model->getallcityjson($query);
            $arr = array();

            $i = 0;
            foreach ($arr_city as $cityRecord)
            {
                $arr[$i]["id"] = $cityRecord["city_name"];
                $arr[$i]["text"] = $cityRecord["city_name"];

                $i++;
            }

            return json_encode($arr);
        }

        public function get_city_json_2($query)
        {
            $this->_CI->load->model('City_model');
            $arr_city = $this->_CI->City_model->getallcityjson($query);
            $arr = array();

            $i = 0;
            foreach ($arr_city as $cityRecord)
            {
                $arr[$i]["id"] = $cityRecord["city_id"];
                $arr[$i]["text"] = $cityRecord["city_name"] . "(" . $cityRecord['state_name'] . ")";

                $i++;
            }

            return json_encode($arr);
        }

        public function get_business_owner_json($query)
        {
            $this->_CI->load->model('Businessowner_model');
            $arr_businessowner = $this->_CI->Businessowner_model->getallbusinessownerjson($query);
            $arr = array();

            $i = 0;
            foreach ($arr_businessowner as $businessownerRecord)
            {
                $arr[$i]["id"] = $businessownerRecord["first_name"] . " " . $businessownerRecord['last_name'];
                $arr[$i]["text"] = $businessownerRecord["first_name"] . " " . $businessownerRecord['last_name'];

                $i++;
            }

            return json_encode($arr);
        }

        public function paginate_function_owner_filter($item_per_page, $current_page, $total_records, $total_pages, $inputUrl)
        {
            $pagination = '';

            if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages)
            { //verify total pages and current page number
                $pagination = "<div class='text-center'>";
                $pagination .= '<ul class="pagination-custom list-unstyled list-inline">';

                $right_links = $current_page + 3;
                $previous = $current_page - 3; //previous link 
                $next = $current_page + 1; //next link
                $first_link = true; //boolean var to decide our first link

                if ($current_page > 1)
                {
                    $previous_link = ($previous == 0) ? 1 : $previous;
                    $first_link_url = empty($inputUrl) ? base_url() . "search?page=1" : base_url() . "search?page=1&" . http_build_query($inputUrl);
                    $previous_link_url = empty($inputUrl) ? base_url() . "search?page=" . $previous_link : base_url() . "search?page=" . $previous_link . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $first_link_url . '" data-page="1" title="First">&laquo;</a></li>'; //first link
                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $previous_link_url . '" data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link

                    for ($i = ($current_page - 2); $i < $current_page; $i++)
                    { //Create left-hand side links
                        if ($i > 0)
                        {
                            $link_url = empty($inputUrl) ? base_url() . "search?page=" . $i : base_url() . "search?page=" . $i . '&' . http_build_query($inputUrl);

                            $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $link_url . '" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    $first_link = false; //set first link to false
                }

                $current_url = empty($inputUrl) ? base_url() . "search?page=" . $current_page : base_url() . "search?page=" . $current_page . '&' . http_build_query($inputUrl);

                if ($first_link)
                { //if current active page is first link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }
                elseif ($current_page == $total_pages)
                { //if it's the last active link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }
                else
                { //regular current link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }

                for ($i = $current_page + 1; $i < $right_links; $i++)
                { //create right-hand side links
                    if ($i <= $total_pages)
                    {
                        $right_links_url = empty($inputUrl) ? base_url() . "search?page=" . $i : base_url() . "search?page=" . $i . '&' . http_build_query($inputUrl);

                        $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $right_links_url . '" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($current_page < $total_pages)
                {
                    $next_link = ($i > $total_pages) ? $total_pages : $i;

                    $next_link_url = empty($inputUrl) ? base_url() . "search?page=" . $next_link : base_url() . "search?page=" . $next_link . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $next_link_url . '" data-page="' . $next_link . '" title="Next">&gt;</a></li>'; //next link

                    $total_pages_url = empty($inputUrl) ? base_url() . "search?page=" . $total_pages : base_url() . "search?page=" . $total_pages . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $total_pages_url . '" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>'; //last link
                }

                $pagination .= '</ul></div>';
            }

            return $pagination; //return pagination links
        }
         public function paginate_function_owner_detail($item_per_page, $current_page, $total_records, $total_pages, $inputUrl,$category_name)
        {
            $pagination = '';

            if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages)
            { //verify total pages and current page number
                $pagination = "<div class='text-center'>";
                $pagination .= '<ul class="pagination-custom list-unstyled list-inline">';

                $right_links = $current_page + 3;
                $previous = $current_page - 3; //previous link 
                $next = $current_page + 1; //next link
                $first_link = true; //boolean var to decide our first link

                if ($current_page > 1)
                {
                    $previous_link = ($previous == 0) ? 1 : $previous;
                    $first_link_url = empty($inputUrl) ? base_url().'owner-category/'.$category_name."?page=1" : base_url() . "search?page=1&" . http_build_query($inputUrl);
                    $previous_link_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $previous_link : base_url() ."owner-category/".$category_name."?page=" . $previous_link . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $first_link_url . '" data-page="1" title="First">&laquo;</a></li>'; //first link
                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $previous_link_url . '" data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link

                    for ($i = ($current_page - 2); $i < $current_page; $i++)
                    { //Create left-hand side links
                        if ($i > 0)
                        {
                            $link_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $i : base_url() ."owner-category/".$category_name."?page=" . $i . '&' . http_build_query($inputUrl);

                            $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $link_url . '" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    $first_link = false; //set first link to false
                }

                $current_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $current_page : base_url() ."owner-category/".$category_name."?page=" . $current_page . '&' . http_build_query($inputUrl);

                if ($first_link)
                { //if current active page is first link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }
                elseif ($current_page == $total_pages)
                { //if it's the last active link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }
                else
                { //regular current link
                    $pagination .= '<li><a class="btn btn-sm btn-primary" href="' . $current_url . '">' . $current_page . '</a></li>';
                }

                for ($i = $current_page + 1; $i < $right_links; $i++)
                { //create right-hand side links
                    if ($i <= $total_pages)
                    {
                        $right_links_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $i : base_url() ."owner-category/".$category_name."?page=" . $i . '&' . http_build_query($inputUrl);

                        $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $right_links_url . '" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($current_page < $total_pages)
                {
                    $next_link = ($i > $total_pages) ? $total_pages : $i;

                    $next_link_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $next_link : base_url() ."owner-category/".$category_name."?page=" . $next_link . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $next_link_url . '" data-page="' . $next_link . '" title="Next">&gt;</a></li>'; //next link

                    $total_pages_url = empty($inputUrl) ? base_url() ."owner-category/".$category_name."?page=" . $total_pages : base_url() ."owner-category/".$category_name."?page=" . $total_pages . '&' . http_build_query($inputUrl);

                    $pagination .= '<li><a class="btn btn-sm btn-default" href="' . $total_pages_url . '" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>'; //last link
                }

                $pagination .= '</ul></div>';
            }

            return $pagination; //return pagination links
        }
        function GetCaptcha()
        {
            $this->_CI->load->helper('captcha');
            $vals = array(
                'img_path' => 'assets/images/captcha/',
                'img_url' => base_url() . 'assets/images/captcha/',
                'img_width' => '225',
                'img_height' => 75,
                'expiration' => 7200,
                'word_length' => 5,
                'font_path' => FCPATH.'assets/consola.ttf',
                'pool'		=> '0123456789abcdefghijklmnopqrstuvwxyz'
            );
            $img_path = 'assets/images/captcha/';
            $img_url = base_url();
            /* Generate the captcha */
            $captcha = create_captcha($vals, $img_path, $img_url);
            return $captcha;
        }

    }
    