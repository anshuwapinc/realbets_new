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

        $data['list_events'] = get_running_markets_masters();
        $dataArray['my_market_table'] = $this->load->viewPartial('my_market-html', $data);

        $this->load->view('my_market', $dataArray);
    }

    function refreshMarketAnalysis()
    {
        
        $data['list_events'] = get_running_markets_masters();
        $my_market_table = $this->load->viewPartial('my_market-html', $data);
          
        echo  $my_market_table;
    }
}
