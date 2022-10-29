<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_type extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Event_type_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }




    public function listmarkets()
    {
        $dataArray = array();
        $event_types = $this->Event_type_model->get_all_market_types();
        $dataArray['event_types'] = $event_types;
         $this->load->view('/block-event-type-list', $dataArray);
    } 
}
