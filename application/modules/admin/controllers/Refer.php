<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refer extends My_Controller
{

    private $_refered_users_listing_headers = "refered_users_listing_headers";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');        
        $this->load->model('Refer_model');
        $this->load->model('Deposit_request_model');
    

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");


        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    public function refer_and_earn()
    {
        $userData = $_SESSION['my_userdata'];
        $dataArray = array(
            'referral_code' => $userData['user_id']
        );
        $totalReffered = $this->Refer_model->get_referred_user_count($dataArray);
        $totaldeposit_request = $this->Deposit_request_model->get_deposite_req_ref_user($dataArray);
        $dataArray['totalReffered'] = $totalReffered;
        $dataArray['totaldeposit_request'] = $totaldeposit_request;
     
        $this->load->view('/refer-and-earn', $dataArray);
    }
    
    function refered_users_list($referral_code = null)
    {

        if (empty($referral_code)) {
            $referral_code = $_SESSION['my_userdata']['user_id'];
        }

     

        $dataArray['local_css'] = array(
            'jquery.dataTables.bootstrap',
            'jquery-ui'
        );

        $dataArray['local_js'] = array(
            'jquery.dataTables',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'moment',
            'jquery.validate',
            'jquery-ui'
        );

        $dataArray['refered_data'] = $this->Refer_model->get_refered_users_list($referral_code);

        $this->load->view('/refered-user-list', $dataArray);
    }
}