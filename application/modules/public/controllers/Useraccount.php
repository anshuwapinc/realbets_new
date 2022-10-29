<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Useraccount extends My_Controller
    {

        private $_user_listing_headers = 'user_listing_headers';

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('language');
            $this->load->helper('url');
            $this->load->model('useraccount_model');            
            
        }

        public function adduser($userid = null)
        {
            $this->load->library('form_validation');
            $this->load->library('Commonlibrary');


            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
            $required_if = empty($userid) ? '|required' : '';
            $this->form_validation->set_rules('password', 'Password', 'trim' . $required_if . '|matches[confirmpassword]');
            $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim');
            if ($this->form_validation->run() == FALSE)
            {

                $dataArray = array();

                $dataArray['form_caption'] = "Add User";
                $dataArray['form_action'] = current_url();                
                $dataArray['arr_accountstatus'] = add_blank_option(getCustomConfigItem('user_accountstatus'));
                

                if (!empty($userid))
                {
                    $userrecord = $this->useraccount_model->getuserbyid($userid);
                    $dataArray['form_caption'] = "Edit User";
                    $dataArray['userid'] = $userid;
                    $dataArray['firstname'] = $userrecord->first_name;
                    $dataArray['lastname'] = $userrecord->last_name;
                    $dataArray['email'] = $userrecord->user_email;
                    $dataArray['phone'] = $userrecord->user_phone;
                    $dataArray['pcode'] = $userrecord->user_postal_code;
                    $dataArray['accountstatus'] = $userrecord->accountstatus;
                }

                $dataArray['local_js'] = array(
                    'jquery.validate.min',
                );
                $dataArray['local_css'] = array(
                    'jquery.validate',                    
                );
                $this->load->view('/user-form', $dataArray);
            }
            else
            {
                $phone = $this->input->post('phone');
                $pcode = $this->input->post('pcode');
                $dataValues = array(
                    'first_name' => $this->input->post('firstname'),
                    'last_name' => $this->input->post('lastname'),
                    'user_email' => $this->input->post('email'),
                    'user_phone' => empty($phone) ? "" : $phone,
                    'user_postal_code' => empty($pcode) ? "" : $pcode,
                    'accountstatus' => $this->input->post('accountstatus')
                );

                $userid = $this->input->post('userid');
                $password = $this->input->post('password');
                if (!empty($userid))
                {
                    $dataValues['user_id'] = $userid;
                    $dataValues['updated_at'] = date("Y-m-d H:i:s");
                }                
                if (!empty($password))
                {
                    $dataValues['password'] = md5($password);
                }
                $last_id = $this->useraccount_model->saveuser($dataValues);

                $this->session->set_flashdata('user_operation_message', 'User saved successfully.');

                redirect('admin/useraccount/listuser');
            }
        }

        public function deleteuser($user_id)
        {
            $this->useraccount_model->deleteuserbyid($user_id);

            $this->session->set_flashdata('user_operation_message', 'User deleted successfully.');

            redirect('admin/Useraccount/listuser');
        }

        public function listuserdata()
        {
            $this->load->library('Datatable');

            $arr = $this->config->config[$this->_user_listing_headers];
            $cols = array_keys($arr);

            $pagingParams = $this->datatable->get_paging_params($cols);
            $resultdata = $this->useraccount_model->getalluser($pagingParams);

            $json_output = $this->datatable->get_json_output($resultdata, $this->_user_listing_headers);
            $this->load->setTemplate('json');
            $this->load->view('json', $json_output);
        }

        public function listuser()
        {
            $this->load->library('Datatable');

            $message = $this->session->flashdata('user_operation_message');

            $table_config = array(
                'source' => site_url('admin/useraccount/listuserdata'),
                'datatable_class' => $this->config->config["datatable_class"]
            );

            $dataArray = array(
                'table' => $this->datatable->make_table($this->_user_listing_headers, $table_config),
                'message' => $message
            );

            $dataArray['local_css'] = array(
                'jquery.dataTables.bootstrap',
            );

            $dataArray['local_js'] = array(
                'jquery.dataTables',
                'jquery.dataTables.bootstrap',
                'dataTables.fnFilterOnReturn',
            );

            $dataArray['table_heading'] = "List Users";
            $dataArray['new_entry_link'] = base_url() . 'admin/useraccount/adduser';
            $dataArray['new_entry_caption'] = "New User";

            $this->load->view('/user-list', $dataArray);
        }
        public function register_email_exists()
        {
            $this->load->library('commonlib');
            $mail = $this->input->post('email');
            $user_id = $this->input->post('user_id');

            if (empty($user_id))
            {
                if ($this->commonlib->emailexists($mail) == TRUE)
                {
                    echo json_encode(FALSE);
                }
                else
                {
                    echo json_encode(TRUE);
                }
            }
            else
            {
                if ($this->useraccount_model->edit_emailexists($mail, $user_id) == TRUE)
                {
                    echo json_encode(FALSE);
                }
                else
                {
                    echo json_encode(TRUE);
                }
            }
        }

    }
    