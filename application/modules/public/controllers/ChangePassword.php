<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ChangePassword extends My_Controller
{

    private $_user_log_activity = 'user_log_activity';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->model('Useraccount_model');
    }


    public function changepassword()
    {
        $dataArray = array();

        $this->load->library('commonlib');
        $this->load->library('commonlibrary');

        $this->load->library('form_validation');


        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        //     $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('repeat_password', 'Password Confirmation', 'required|trim|matches[password]');


        $dataArray['bannercontent'] = "Change Password";
        $password = $this->input->post('password');
        $repassword = $this->input->post('repeat_password');

        if ($this->form_validation->run($this) == false) {
            $message = $this->session->flashdata('message');
            $errors = validation_errors();
            //  p($errors);
            $dataArray["errors"] = $errors;
            $dataArray["message"] = $message;
            $dataArray['form_caption'] = 'Change Password';
            $dataArray['form_action'] = current_url();

            $dataArray['local_css'] = array(
                'icheck',
            );
            $dataArray['local_js'] = array(
                'jquery.validate',
                'icheck',
            );

            $this->load->view('change-password-form', $dataArray);
        } else {

            $user_data = GetLoggedinUserData();
            // p($user_data);
            $dataValues = array();
            $table = '';
            if (!empty($user_data)) {
                $table = "users";
                $fillter_Array['userid'] = $user_data['userid'];
            } else {
                redirect('/');
            }

            $dataValues['password'] = md5($password);
            $userid = $this->Useraccount_model->common_changepassword($table, $fillter_Array, $dataValues);
            $this->session->set_flashdata('message', 'Password changed successfully');
            redirect("changepassword");
        }
    }
}
