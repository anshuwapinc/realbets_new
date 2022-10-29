<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BlockMarket extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Event_type_model');
        $this->load->model('Block_market_model');

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
        $this->load->model('List_event_model');
        $this->load->model('Market_type_model');
        $this->load->model('Market_book_odds_fancy_model');
        $this->load->model('User_model');
        $this->load->model('Event_model');
 
        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }




    public function listmarkets()
    {

         $dataArray = array();
        $user_type = get_user_type();
        $event_types = $this->Event_type_model->get_all_market_types();


         $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Sport'));
        $dataArray['block_markets'] = $block_markets;

        // p($block_markets, 0);
        if ($user_type == 'Super Admin') {

            foreach ($block_markets as $key1 => $block_market) {
                foreach ($event_types as $key2 => $event_type) {
                    if ($block_market['event_type_id'] == $event_type['event_type']) {

                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $super_admin_block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $super_admin_block_markets = get_hmaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $super_admin_block_markets = get_smaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Master') {
            $super_admin_block_markets = get_master_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        }
        $dataArray['event_types'] = $event_types;
        $dataArray['show_casino'] = 'Yes';

        $this->load->view('/block-event-type-list', $dataArray);
    }

    public function casinolistmarkets()
    {

         $dataArray = array();
        $user_type = get_user_type();
        $event_types = $this->Event_type_model->get_all_market_types('Yes');


         $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Sport'));
        $dataArray['block_markets'] = $block_markets;

        // p($block_markets, 0);
        if ($user_type == 'Super Admin') {

            foreach ($block_markets as $key1 => $block_market) {
                foreach ($event_types as $key2 => $event_type) {
                    if ($block_market['event_type_id'] == $event_type['event_type']) {

                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $super_admin_block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $super_admin_block_markets = get_hmaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $super_admin_block_markets = get_smaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Master') {
            $super_admin_block_markets = get_master_block_markets(array('user_id' => get_master_id(), 'type' => 'Sport'));


            foreach ($event_types as $key2 => $event_type) {

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_type_id'] == $event_type['event_type']) {
                        unset($event_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    }

                    if ($block_market['event_type_id'] == $event_type['event_type']) {
                        $event_types[$key2]['block_status'] = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        }
        $dataArray['event_types'] = $event_types;
        $dataArray['show_casino'] = 'No';
        $this->load->view('/block-event-type-list', $dataArray);
    }

 

    public function block_market_update()
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $sportId = $this->input->post('sportId');
        $userId = $this->input->post('userId');
        $matchId = $this->input->post('matchId');
        $marketId = $this->input->post('marketId');
        $fancyId = $this->input->post('fancyId');
        $usertype = $this->input->post('usertype');
        $IsPlay = $this->input->post('IsPlay');
        $type = $this->input->post('Type');
        $dataArray = array(
            'user_id' => $userId,
            'event_id' => $matchId,
            'market_id' => $marketId,
            'event_type_id' => $sportId,
            'user_id' => $userId,
            'fancy_id' => $fancyId,

            'type' => $type

        );


        $alreadyExists =  $this->Block_market_model->checkBlockMarketExists($dataArray);

        // if (!empty($alreadyExists)) {
        //     $dataArray['block_market_id'] = $alreadyExists->block_market_id;
        // }
        // $block_market_id = $this->Block_market_model->addBlockMarket($dataArray);

        if (!empty($alreadyExists)) {
            if ($type == 'Fancy') {
                $dataArray2 = $dataArray;


                $this->Block_market_model->addFancyBlockMarketAllow($dataArray2);

             }
            $dataArray['block_market_id'] = $alreadyExists->block_market_id;

          
        } else {
            if ($type == 'Fancy') {
                $dataArray2 = $dataArray;
                $fancyalreadyExists =  $this->Block_market_model->checkFancyBlockMarketAllowExists($dataArray);


                 if (!empty($fancyalreadyExists)) {
                    $dataArray2['block_market_id'] = $fancyalreadyExists->block_market_id;
                     $this->Block_market_model->addFancyBlockMarketAllow($dataArray2);
                }
            }
        }
        $block_market_id = $this->Block_market_model->addBlockMarket($dataArray);


        $return = array();
        if ($block_market_id) {
            $return = array("success" => true, "message" => 'Success');
        } else {
            $return = array("success" => false, "message" => 'Something went wrong.');
        }

        echo json_encode($return);
    }



    public function match_list_block($event_type = null)
    {
        $dataArray = array();
        $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);

        $dataArray['event_name'] = $event_type_result->name;
        $dataArray['event_type'] = $event_type_result->event_type;
        $dataArray['event_type_id'] = $event_type_result->event_type_id;

        $list_events = (array) $this->List_event_model->get_latest_event_by_event_type($event_type);


 
        $user_type = get_user_type();
        // p($block_markets, 0);
        if ($user_type == 'Super Admin') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Event'));

            foreach ($list_events as $key => $list_event) {
                $list_event = (array) $list_event;

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if(empty($market_types))
                {
                    unset($list_events[$key]);
                    continue;
                }

                foreach ($block_markets as $block_market) {
                    if ($block_market['event_id'] == $list_event['event_id']) {
                        $list_events[$key]->block_status = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Admin') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Event'));

            // p($block_markets);
            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_master_id(), 'type' => 'Event'));

            foreach ($list_events as $key2 => $list_event) {
                $list_event = (array) $list_event;


                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if(empty($market_types))
                {
                    unset($list_events[$key2]);
                    continue;
                }

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_id'] == $list_event['event_id']) {
                        unset($list_events[$key2]);
                        continue;
                    }
                }



                if (isset($list_events[$key2])) {

                    // p($block_markets);
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['event_id'] == $list_event['event_id']) {
                            $list_events[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }

            // p($list_events);

        } else if ($user_type == 'Hyper Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Event'));

            $super_admin_block_markets = get_hmaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Event'));


            foreach ($list_events as $key2 => $list_event) {
                $list_event = (array) $list_event;

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if(empty($market_types))
                {
                    unset($list_events[$key2]);
                    continue;
                }


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_id'] == $list_event['event_id']) {
                        unset($list_events[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {
                    if ($block_market['event_id'] == $list_event['event_id']) {
                        $list_events[$key2]->block_status = 'Yes';
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Event'));


            $super_admin_block_markets = get_smaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Event'));


            foreach ($list_events as $key2 => $list_event) {
                $list_event = (array) $list_event;

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if(empty($market_types))
                {
                    unset($list_events[$key2]);
                    continue;
                }


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_id'] == $list_event['event_id']) {
                        unset($list_events[$key2]);
                        continue;
                    }
                }

                if (isset($list_events[$key2])) {
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['event_id'] == $list_event['event_id']) {
                            $list_events[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        } else if ($user_type == 'Master') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Event'));

            $super_admin_block_markets = get_master_block_markets(array('user_id' => get_master_id(), 'type' => 'Event'));


            foreach ($list_events as $key2 => $list_event) {
                $list_event = (array) $list_event;

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if(empty($market_types))
                {
                    unset($list_events[$key2]);
                    continue;
                }

                
                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['event_id'] == $list_event['event_id']) {
                        unset($list_events[$key2]);
                        continue;
                    }
                }

                if (isset($list_events[$key2])) {
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['event_id'] == $list_event['event_id']) {
                            $list_events[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        }

        // p($list_events);
        $dataArray['list_events'] = $list_events;

        $this->load->view('/block-market-event-list', $dataArray);
    }


    public function market_list_block($event_type = null, $event_id = null)
    {
        // p("Here");
        $dataArray = array();
        $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);

        $dataArray['event_name'] = $event_type_result->name;
        $dataArray['event_type'] = $event_type_result->event_type;
        $dataArray['event_type_id'] = $event_type_result->event_type_id;

        $market_types = $this->Market_type_model->get_market_type_by_event_id($event_id);

      

        $check_fancy_exists = $this->Market_book_odds_fancy_model->get_fancy_by_match_id($event_id);

        $total_fancy = sizeof($check_fancy_exists);
             $market_types['fancy'] = array(
                'id' => 0,
                'event_id' => $event_id,
                'market_name' => 'Fancy',
                'market_id' => '',
                'market_start_time' => '',
                'total_matched' => '',
            );

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'AllFancy', 'event_id' => $event_id));


            if (!empty($block_markets)) {
                foreach ($block_markets as $block_market) {
                    if ($event_id == $block_market['event_id']) {
                        $market_types['fancy']['block_status'] = 'Yes';
                    }
                }
            }
 
        $user_type = get_user_type();
        // p($block_markets, 0);
        if ($user_type == 'Super Admin') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Market'));

            foreach ($market_types as $key => $list_event) {
                $list_event = (array) $list_event;
                foreach ($block_markets as $block_market) {
                    if ($block_market['market_id'] == $list_event['market_id']) {
                        $market_types[$key]->block_status = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }
        } else if ($user_type == 'Admin') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Market'));

            // p($block_markets);
            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_master_id(), 'type' => 'Market'));

            foreach ($market_types as $key2 => $list_event) {
                $list_event = (array) $list_event;

                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['market_id'] == $list_event['market_id']) {
                        unset($market_types[$key2]);
                        continue;
                    }
                }



                if (isset($market_types[$key2])) {

                    // p($block_markets);
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['market_id'] == $list_event['market_id']) {
                            $market_types[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }

            // p($market_types);

        } else if ($user_type == 'Hyper Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Market'));

            $super_admin_block_markets = get_hmaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Market'));


            foreach ($market_types as $key2 => $list_event) {
                $list_event = (array) $list_event;
                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['market_id'] == $list_event['market_id']) {
                        unset($market_types[$key2]);
                        continue;
                    }
                }

                foreach ($block_markets as $key1 => $block_market) {
                    if ($block_market['market_id'] == $list_event['market_id']) {
                        $market_types[$key2]->block_status = 'Yes';
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Market'));


            $super_admin_block_markets = get_smaster_block_markets(array('user_id' => get_master_id(), 'type' => 'Market'));


            foreach ($market_types as $key2 => $list_event) {
                $list_event = (array) $list_event;
                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['market_id'] == $list_event['market_id']) {
                        unset($market_types[$key2]);
                        continue;
                    }
                }

                if (isset($market_types[$key2])) {
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['market_id'] == $list_event['market_id']) {
                            $market_types[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        } else if ($user_type == 'Master') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Market'));

            $super_admin_block_markets = get_master_block_markets(array('user_id' => get_master_id(), 'type' => 'Market'));


            foreach ($market_types as $key2 => $list_event) {
                $list_event = (array) $list_event;
                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['market_id'] == $list_event['market_id']) {
                        unset($market_types[$key2]);
                        continue;
                    }
                }

                if (isset($market_types[$key2])) {
                    foreach ($block_markets as $key1 => $block_market) {

                        if ($block_market['market_id'] == $list_event['market_id']) {
                            $market_types[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        }

        $dataArray['market_types'] = $market_types;
        $this->load->view('/block-market-market-list', $dataArray);
    }



    public function fancy_event_list_block($event_type = null, $event_id = null)
    {
        // p("Here");
        $dataArray = array();
        $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);

        $dataArray['event_name'] = $event_type_result->name;
        $dataArray['event_type'] = $event_type_result->event_type;
        $dataArray['event_type_id'] = $event_type_result->event_type_id;
        $dataArray['event_id'] = $event_id;


        $fancy_results = $this->Market_book_odds_fancy_model->get_fancy_by_match_id($event_id);
 
     
 

        $user_type = get_user_type();
        // p($block_markets, 0);
        if ($user_type == 'Super Admin') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Fancy', 'event_id' => $event_id));

            foreach ($fancy_results as $key => $fancy_result) {
                $list_event = (array) $fancy_result;
                foreach ($block_markets as $block_market) {


                    if ($block_market['fancy_id'] == $list_event['selection_id']) {
                        $fancy_results[$key]->block_status = 'Yes';
                    } else {
                        // $event_types[$key2]['block_status'] = 'No';
                    }
                }
            }

            // p($fancy_results);
        } else if ($user_type == 'Admin') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Fancy', 'event_id' => $event_id));

            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_master_id(), 'type' => 'Fancy', 'event_id' => $event_id));

            foreach ($fancy_results as $key2 => $fancy_result) {

                $list_event = (array) $fancy_result;


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }



                if (isset($fancy_results[$key2])) {


                    foreach ($block_markets as $key1 => $block_market) {
                        if ($block_market['fancy_id'] == $list_event['selection_id']) {

                            $fancy_results[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Fancy', 'event_id' => $event_id));
            $user_id = get_master_id();

            $admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $user_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($user_id);
            $master_id = $user->master_id;

            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));


            foreach ($fancy_results as $key2 => $fancy_result) {

                $list_event = (array) $fancy_result;

                foreach ($admin_block_markets as $admin_block_market) {

                    if ($admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }



                if (isset($fancy_results[$key2])) {


                    foreach ($block_markets as $key1 => $block_market) {
                        if ($block_market['fancy_id'] == $list_event['selection_id']) {

                            $fancy_results[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Fancy', 'event_id' => $event_id));
            $user_id = get_master_id();


            $hyper_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $user_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($user_id);
            $master_id = $user->master_id;

 

            $admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($master_id);
            $master_id = $user->master_id;

            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));


            foreach ($fancy_results as $key2 => $fancy_result) {

                $list_event = (array) $fancy_result;

                foreach ($hyper_block_markets as $hyper_block_market) {

                    if ($hyper_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($admin_block_markets as $admin_block_market) {

                    if ($admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }



                if (isset($fancy_results[$key2])) {


                    foreach ($block_markets as $key1 => $block_market) {
                        if ($block_market['fancy_id'] == $list_event['selection_id']) {

                            $fancy_results[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        } else if ($user_type == 'Master') {

            $block_markets = $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => get_user_id(), 'type' => 'Fancy', 'event_id' => $event_id));
            $user_id = get_master_id();

            $super_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $user_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($user_id);
            $master_id = $user->master_id;


            $hyper_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($master_id);
            $master_id = $user->master_id;

 

            $admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));

            $user = $this->User_model->getUserById($master_id);
            $master_id = $user->master_id;

            $super_admin_block_markets = (array) $this->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => 'Fancy', 'event_id' => $event_id));


            foreach ($fancy_results as $key2 => $fancy_result) {

                $list_event = (array) $fancy_result;

                foreach ($super_block_markets as $super_block_market) {

                    if ($super_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($hyper_block_markets as $hyper_block_market) {

                    if ($hyper_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($admin_block_markets as $admin_block_market) {

                    if ($admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }


                foreach ($super_admin_block_markets as $super_admin_block_market) {

                    if ($super_admin_block_market['fancy_id'] == $list_event['selection_id']) {
                        unset($fancy_results[$key2]);
                        continue;
                    }
                }



                if (isset($fancy_results[$key2])) {


                    foreach ($block_markets as $key1 => $block_market) {
                        if ($block_market['fancy_id'] == $list_event['selection_id']) {

                            $fancy_results[$key2]->block_status = 'Yes';
                        }
                    }
                }
            }
        }

        $dataArray['fancy_results'] = $fancy_results;
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

         $this->load->view('/block-fancy-event-list', $dataArray);
    }

    public function pre_block_fancy()
    {

  
        $matchId = $this->input->post('matchId');
        $sportId = $this->input->post('sportId');
        $userId = get_user_id();
        $dataArray = array(
            'event_id' => $matchId,
            'market_id' => '',
            'event_type_id' => $sportId,
            'user_id' => $userId,
            'fancy_id' => '',
            'type' => 'PreBlockFancy'

        );




         $alreadyExists =  $this->Block_market_model->checkBlockMarketExists($dataArray);

        if (!empty($alreadyExists)) {
            $dataArray['block_market_id'] = $alreadyExists->block_market_id;
        }
        $block_market_id = $this->Block_market_model->addBlockMarket($dataArray);

        $return = array();
        if ($block_market_id) {
            $return = array("success" => true, "message" => 'Success');
        } else {
            $return = array("success" => false, "message" => 'Something went wrong.');
        }

        echo json_encode($return);
    }
}
