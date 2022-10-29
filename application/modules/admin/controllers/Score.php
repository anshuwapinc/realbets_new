<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Score extends My_Controller
{

    private $_user_log_activity = 'user_log_activity';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
                   $this->load->model('Event_model');
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
       $dataArray['message'] = $message;



        $userdata = $_SESSION['my_userdata'];
        $dataArray['local_css'] = array(
            'dataTables.bootstrap4',
            'responsive.bootstrap4'
        );

        $dataArray['local_js'] = array(
            'dataTables.min',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'dataTables.bootstrap4',
            'dataTables.responsive',
            'responsive.bootstrap4'
        );

         $list_events = $this->Event_model->list_events_by_event_type(array(
             'event_type' => 4
         ));

       $dataArray['list_events'] = $list_events;


        $this->load->view('score-list', $dataArray);
    }

    
    function score_toggle()
    {
        
        $event_id = $this->input->post('event_id');
        $is_score = $this->input->post('is_score');

        $event_id = $this->Event_model->toggle_score(array(
            'event_id' => $event_id,
            'is_score' => $is_score
        ));
         if ($event_id) {
 
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'success' => false,
                'successMessage' => 'Error'
            );
        }
        echo json_encode($array);
    }
}
