<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends My_Controller
{

    private $_user_log_activity = 'user_log_activity';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        //            $this->load->model('Admin_model');
        $this->load->model('Admin_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
      

        $userdata = $_SESSION['my_userdata'];
        $this->load->model('Prediction_master_model');


        if (empty($userdata)) {
            redirect('/');
        }
    }

    function index()
    {

        $message = $this->session->flashdata('login_error_message');
        $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
        $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

        $dataArray['message'] = $message;


       

        $userdata = $_SESSION['my_userdata'];

      
        


        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );

        $todays_matches = $this->Prediction_master_model->todays_matches();
        $dataArray['todays_matches'] = $todays_matches;

        $this->load->view('dashboard', $dataArray);
    }
}
