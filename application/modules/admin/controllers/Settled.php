<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settled extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Event_type_model');
        $this->load->model('List_event_model');
        $this->load->model('Event_model');

        $this->load->model('User_model');
        $this->load->model('Ledger_model');

        $this->load->model('Market_type_model');
        $this->load->model('Market_book_odds_fancy_model');
        $this->load->model('Betting_model');
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
        if(get_user_type() != 'Operator')
        {
            redirect('/');
        }
        $dataArray = array();
        $event_types = $this->Event_type_model->get_event_types(array(4));

        $dataArray['event_types'] = $event_types;
        $this->load->view('/settled-event-type-list', $dataArray);
    }

    public function listevents($event_type = null)
    {
        if(get_user_type() != 'Operator')
        {
            redirect('/');
        }
        $dataArray = array();
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
        $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);
        $dataArray['event_name'] = $event_type_result->name;
        $dataArray['event_type'] = $event_type_result->event_type;
        $dataArray['event_type_id'] = $event_type_result->event_type_id;

        $list_events = $this->List_event_model->get_list_event_by_event_type($event_type);
        $dataArray['list_events'] = $list_events;
        $this->load->view('/settled-event-list', $dataArray);
    }

    public function settledEventEntry($list_event_id = null)
    {

        if(get_user_type() != 'Operator')
        {
            redirect('/');
        }
        $dataArray = array();
        $list_event = $this->List_event_model->get_list_event_by_id($list_event_id);
       
         $dataArray['event_name'] = $list_event->event_name;
        $dataArray['is_tie'] = $list_event->is_tie;

        $dataArray['winner_selection_id'] = $list_event->winner_selection_id;

        $event_id = $list_event->event_id;

     

        $market_types = $this->Market_type_model->get_market_type_by_event_id($event_id);

        $match_odds_market = $this->Market_type_model->get_match_odds_mark_event_id($event_id);
        $match_odds_market_id = $match_odds_market->market_id;

        if (!empty($market_types)) {
            foreach ($market_types as $key => $market_type) {
         $market_book_odds_runner = $this->Event_model->list_market_book_odds_runner(array('market_id'=> $market_type->market_id));
                
                 $market_types[$key]->runners = $market_book_odds_runner;
            }
        }

        $dataArray['market_types'] = $market_types;

          if($list_event->is_unlist == 'Yes')
        {
        $market_book_odds_fancy = $this->Market_book_odds_fancy_model->get_fancy_by_match_id($event_id);

        }
        else
        {
        $market_book_odds_fancy = $this->Market_book_odds_fancy_model->get_fancy_by_match_id($event_id, true);

        }


        foreach ($market_book_odds_fancy as $key => $fancy) {


            $count_bets = $this->Betting_model->count_fancy_bets(array(
                'match_id' => $event_id,
                'selection_id' => $fancy->selection_id
            ));
            $market_book_odds_fancy[$key]->total_bets = $count_bets;

 
        }   

        usort($market_book_odds_fancy, 'total_bets_cmp');
        
 
 
         $dataArray['market_book_odds_fancy'] = $market_book_odds_fancy;
        $dataArray['event_id'] = $event_id;
        $dataArray['match_odds_market_id'] = $match_odds_market_id;

        $this->load->view('/settled-event-form', $dataArray);
    }
 


   

    // public function eventTieToggle()
    // {
    //     $event_id = $this->input->post('event_id');
    //     $is_tie = $this->input->post('is_tie');

    //     if ($is_tie == 'Yes') {
    //         $is_tie = 'No';
    //     } else {
    //         $is_tie = 'Yes';
    //     }
    //     $dataArray = array(
    //         'is_tie' => $is_tie,
    //         'event_id' => $event_id,
    //     );
    //     $this->Event_model->addEvents($dataArray);
    // }

    public function settled_failed()
    {
        if(get_user_type() != 'Operator')
        {
            redirect('/');
        }
        $dataArray = array();
        $bettings = $this->Betting_model->get_failed_bettings();
        $dataArray['bettings'] = $bettings;
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
            'responsive.bootstrap4',
            'blockUI'
        );
        $this->load->view('/settled-failed-list', $dataArray);
    }
}
