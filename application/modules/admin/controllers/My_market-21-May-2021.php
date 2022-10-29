<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_market extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_model');
        $this->load->model('Event_model');
        $this->load->model('Betting_model');
        $this->load->model('My_market_model');


        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
    }


    public function index($type = null)
    {

        $dataArray = array();

        if (get_user_type() == 'User') {
            $list_events = get_running_markets();
        } else if (get_user_type() == 'Master') {
            $list_events = get_running_markets_masters();

        }
        else if (get_user_type() == 'Super Master') {
            $list_events = get_running_markets_super_masters();
        }
        else if (get_user_type() == 'Hyper Super Master') {
            $list_events = get_running_markets_hyper_super_masters();
        }
        else if (get_user_type() == 'Admin') {
            $list_events = get_running_markets_admin();
        }
        else if (get_user_type() == 'Super Admin') {
            $list_events = get_running_markets_super_admin();
        }
        $dataArray['list_events'] = $list_events;

        $this->load->view('my_market', $dataArray);
    }
}
