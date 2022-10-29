<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends My_Controller
{

    private $_user_log_activity = 'user_log_activity';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        //            $this->load->model('Admin_model');
        $this->load->model('Admin_model');
        // $this->load->model('Player_model');
        // $this->load->model('Prediction_master_model');
        $this->load->model('Chip_model');
        $this->load->model('News_model');

        $this->load->model('User_chip_model');


        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");


        $userdata = $_SESSION['my_userdata'];

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

        $site_code = getCustomConfigItem('site_code');
        
        $data = $this->News_model->get_all_news($site_code);
        $dataArray['news'] = $data;


        $this->load->view('news-list', $dataArray);
    }

    function addnews()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        if ($this->form_validation->run()) {

            $description = $this->input->post('description');
            $news_id = $this->input->post('news_id');
            $site_code = getCustomConfigItem('site_code');

            $dataArray = array(
                "description" => $description,
                'site_code' => $site_code
             );

            if(!empty($news_id))
            {
                $dataArray['news_id'] = $news_id;
            }
            $result = $this->News_model->addNews($dataArray);

             $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
                'description' => form_error('description'),
            );
        }
        echo json_encode($array);
    }

    function deletenews()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('news_id', 'News Id', 'required|trim');

         if ($this->form_validation->run()) {

            $news_id = $this->input->post('news_id');
            $result = $this->News_model->deleteNews($news_id);
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
                'news_id' => form_error('news_id'),
            );
        }
        echo json_encode($array);
    }
}
