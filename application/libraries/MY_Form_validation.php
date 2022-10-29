<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class MY_Form_validation extends CI_Form_validation
    {

        private $_CI;

        public function __construct()
        {
            parent::__construct();

            $this->_CI = & get_instance();
        }

        function run($module = '', $group = '')
        {
            (is_object($module)) AND $this->CI = &$module;
            return parent::run($group);
        }

//        public function validate_file_upload($controlName, $module)
//        {
//            $this->_CI->load->config('report_config');
//            $myconfig = $this->_CI->config->item($module);
//
//            $this->_CI->load->library('upload', $myconfig);
//
//            $message = '';
//
//            if (!$this->_CI->upload->dryRunUpload($controlName))
//            {
//                $message = $this->_CI->upload->display_errors();
//                $this->_error_array[] = $message;
//            }
//
//            return empty($message);
//        }

        public function validate_file_upload($controlName, $module)
        {
            $myconfig = getCustomConfigItem($module);

            $this->_CI->load->library('upload', $myconfig);

            $message = '';

            if (!$this->_CI->upload->dryRunUpload($controlName))
            {
                $message = $this->_CI->upload->display_errors();
                $this->_error_array[] = $message;
            }

            return empty($message);
        }

        // --------------------------------------------------------------------
//        public function unique($str, $field)
//        {
//            $arr = explode('.', $field);
//
//            $table = $arr[0];
//            $column = $arr[1];
//
//            $exclusionField = $exclusionFieldValue = $extraCondition = '';
//
//            if (count($arr) == 4)
//            {
//                $exclusionField = $arr[2];
//                $exclusionFieldValue = $arr[3];
//            }
//
//            $this->_CI->form_validation->set_message('unique', '%s already exists.');
//
//            if (!empty($exclusionField) && !empty($exclusionFieldValue))
//            {
//                $extraCondition = " AND $exclusionField <> '$exclusionFieldValue'";
//            }
//
//            $query = $this->_CI->db->query("SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' $extraCondition");
//            $row = $query->row();
//            return ($row->duplicate > 0) ? FALSE : TRUE;
//        }

        public function unique($str, $field)
        {
            $str=  addslashes($str);
            $arr = explode('.', $field);
            $count_field = count($arr);
            if ($count_field > 9)
            {

                $table = $arr[0];
                $column = $arr[1];
                $columnn = $arr[2];
                $columnnvalue = $arr[6];
                $exclusionField1 = $exclusionFieldValue1 = $extraCondition = '';
                $exclusionField2 = $exclusionFieldValue2 = '';
                $exclusionField3 = $exclusionFieldValue3 = '';

                if (count($arr) == 10) //count($arr) == 4
                {

                    $exclusionField1 = $arr[3];
                    $exclusionFieldValue1 = $arr[7];
                    $exclusionField2 = $arr[4];
                    $exclusionFieldValue2 = $arr[8];
                    $exclusionField3 = $arr[5];
                    $exclusionFieldValue3 = $arr[9];
                }

                $this->_CI->form_validation->set_message('unique', '%s already exists.');

                if (!empty($exclusionField1) && !empty($exclusionFieldValue1) && !empty($exclusionField2) && !empty($exclusionFieldValue2) && !empty($exclusionField3) && !empty($exclusionFieldValue3))
                {
                    $extraCondition = " AND $exclusionField1 = '$exclusionFieldValue1' AND $exclusionField2 = '$exclusionFieldValue2' AND $exclusionField3 = '$exclusionFieldValue3'";
                }

                $sql = "SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' And $columnn <> '$columnnvalue' $extraCondition";

                $query = $this->_CI->db->query($sql);

                $row = $query->row();
                return ($row->duplicate > 0) ? FALSE : TRUE;
            }
            elseif ($count_field > 7)
            {

                $table = $arr[0];
                $column = $arr[1];
                $columnn = $arr[2];
                $columnnvalue = $arr[5];
                $exclusionField1 = $exclusionFieldValue1 = $extraCondition = '';
                $exclusionField2 = $exclusionFieldValue2 = '';

                if (count($arr) == 8) //count($arr) == 4
                {

                    $exclusionField1 = $arr[3];
                    $exclusionFieldValue1 = $arr[6];
                    $exclusionField2 = $arr[4];
                    $exclusionFieldValue2 = $arr[7];
                }
                $this->_CI->form_validation->set_message('unique', '%s already exists.');

                if (!empty($exclusionField1) && !empty($exclusionFieldValue1) && !empty($exclusionField2) && !empty($exclusionFieldValue2))
                {

                    $extraCondition = " AND $exclusionField1 = '$exclusionFieldValue1' AND $exclusionField2 = '$exclusionFieldValue2'";
                }

                //$sql = "SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' And $columnn <> '$columnnvalue' $extraCondition";
                $sql = "SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' And $columnn <> '$columnnvalue' $extraCondition";
                $query = $this->_CI->db->query($sql);

                $row = $query->row();
                return ($row->duplicate > 0) ? FALSE : TRUE;
            }
            elseif ($count_field > 5)
            {
                $str = strtolower($str);
                $table = $arr[0];
                $column = $arr[1];
                $columnn = $arr[2];
                $columnnvalue = $arr[4];
                $exclusionField1 = $exclusionFieldValue1 = $extraCondition = '';
                $exclusionField2 = $exclusionFieldValue2 = '';

                if (count($arr) == 6) //count($arr) == 4
                {

                    $exclusionField1 = $arr[3];
                    $exclusionFieldValue1 = $arr[5];
                }
                $this->_CI->form_validation->set_message('unique', '%s already exists.');

                if (!empty($exclusionField1) && !empty($exclusionFieldValue1))
                {

                    $extraCondition = " AND $exclusionField1 = '$exclusionFieldValue1'";
                }

                $sql = "SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' And $columnn <> '$columnnvalue' $extraCondition";

                $query = $this->_CI->db->query($sql);
                //p($this->_CI->db->last_query());
                $row = $query->row();

                return ($row->duplicate > 0) ? FALSE : TRUE;
            }
            else
            {
                $table = $arr[0];
                $column = $arr[1];
                $exclusionField = $exclusionFieldValue = $extraCondition = '';
                if (count($arr) == 4)
                {
                    $exclusionField = $arr[2];
                    $exclusionFieldValue = $arr[3];
                }
                $this->_CI->form_validation->set_message('unique', '%s already exists.');
                if (!empty($exclusionField) && !empty($exclusionFieldValue))
                {
                    $extraCondition = " AND $exclusionField <> '$exclusionFieldValue'";
                }
                $sql = "SELECT COUNT(*) AS duplicate FROM $table WHERE $column = '$str' $extraCondition";
                $query = $this->_CI->db->query($sql);

                $row = $query->row();
                return ($row->duplicate > 0) ? FALSE : TRUE;
            }
        }

    }
    