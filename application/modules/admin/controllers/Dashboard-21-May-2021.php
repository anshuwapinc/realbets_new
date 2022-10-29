<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->model('Event_model');
        $this->load->model('Favourite_event_model');

        $this->load->model('User_chip_model');
        $this->load->model('User_info_model');
        $this->load->model('Betting_model');
        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    function index($type = null, $event_type = null)
    {
        log_message("MY_INFO", 'Dashboard Page Load Start');

        $message = $this->session->flashdata('login_error_message');
        $dataArray['message'] = $message;

        $userdata = $_SESSION['my_userdata'];
        $user_id = $userdata['user_id'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );


        if ($type == 'inplay') {
            $data['inplay'] = '1';
            $list_events = $this->Event_model->get_active_market_events($data);
        } else {
            $data = array();

            if (get_user_type() == 'Operator') {
                $list_events = $this->Betting_model->get_unsettled_bets_events($data);
            } else {
                $list_events = $this->Event_model->get_active_market_events($data);
            }
        }

        $exchangeData = array();
        $fantacyData = array();

        $cricektData = array();
        $tennisData = array();
        $soccerData = array();

        if (get_user_type() == 'User') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Admin') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Hyper Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));

            $block_markets_1 = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));

            $block_markets = array_merge($block_markets, $block_markets_1);
        }




        if (get_user_type() == 'User') {
            /*************** Type = 1 is Market and event */
            $block_markets_events = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));
        } else if (get_user_type() == 'Admin') {
            /*************** Type = 1 is Market and event */
            $block_markets_events = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));
        } else if (get_user_type() == 'Hyper Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets_events = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));
        } else if (get_user_type() == 'Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets_events = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));
        } else if (get_user_type() == 'Master') {
            /*************** Type = 1 is Market and event */
            $block_markets_events = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Event'));
        }

        $casino_events= getCustomConfigItem('casino_event_type');

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                $count_fancy_bets = $this->Betting_model->count_fancy(array('match_id' => $list_event['event_id']));
                $count_match_bets = $this->Betting_model->count_match_bets(array('match_id' => $list_event['event_id']));





                $bettings = $this->Betting_model->operator_bettings_list(array('match_id' => $list_event['event_id']));

                $list_event['fancy_bets'] = $count_fancy_bets->total_fancy_bets;
                $list_event['match_bets'] = $count_match_bets->total_match_bets;
                $list_event['bettings'] = $bettings;

                if (!empty($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['type'] == 'Sport') {
                            if ($block_market['event_type_id'] == $list_event['event_type']) {
                                unset($list_events[$key]);
                            }

                            $casino_search = array_search($block_market['event_type_id'],$casino_events);

                            unset($casino_events[$casino_search]);
                        }
                    }
                }

                if (!isset($list_events[$key])) {
                    continue;
                }

                if (!empty($block_markets_events)) {
                    foreach ($block_markets_events as $block_markets_event) {



                        if ($block_markets_event['type'] == 'Event') {
                            if ($list_event['event_id'] == $block_markets_event['event_id']) {

                                unset($list_events[$key]);
                            }
                        }
                    }
                }

                if (!isset($list_events[$key])) {
                    continue;
                }


                $user_id = $_SESSION['my_userdata']['user_id'];


                $event_id = $list_event['event_id'];

                if ($list_event['event_type'] == 4) {
                    $cricektData[$event_id] = $list_event;
                } else if ($list_event['event_type'] == 2) {
                    $tennisData[$event_id] = $list_event;
                } else if ($list_event['event_type'] == 1) {
                    $soccerData[$event_id] = $list_event;
                }

                if (get_user_type() == 'Operator') {
                    $market_types = $this->Event_model->list_all_market_types(array('event_id' => $list_event['event_id']));
                } else {
                    $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));
                }



                $check_favourite = $this->Favourite_event_model->get_favourite_event(array('event_id' => $list_event['event_id'], 'user_id' =>  $user_id));

                if ($type == 'favourite') {
                    if (empty($check_favourite)) {
                        if ($list_event['event_type'] == 4) {
                            unset($cricektData[$event_id]);
                        } else if ($list_event['event_type'] == 2) {
                            unset($tennisData[$event_id]);
                        } else if ($list_event['event_type'] == 1) {
                            unset($soccerData[$event_id]);
                        }
                        continue;
                    }
                }

                if (!empty($check_favourite)) {
                    if ($list_event['event_type'] == 4) {
                        $cricektData[$event_id]['is_favourite'] = true;
                    } else if ($list_event['event_type'] == 2) {
                        $tennisData[$event_id]['is_favourite'] = true;
                    } else if ($list_event['event_type'] == 1) {
                        $soccerData[$event_id]['is_favourite'] = true;
                    }
                } else {
                    if ($list_event['event_type'] == 4) {
                        $cricektData[$event_id]['is_favourite'] = false;
                    } else if ($list_event['event_type'] == 2) {
                        $tennisData[$event_id]['is_favourite'] = false;
                    } else if ($list_event['event_type'] == 1) {
                        $soccerData[$event_id]['is_favourite'] = false;
                    }
                }

                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {

                        if ($type == 'inplay') {
                            if ($market_type['inplay'] != 1) {
                                continue;
                            }
                        }

                        // $market_id = str_replace('.','',$market_type['market_id']);
                        $market_id = $market_type['market_id'];
                        // p($market_id);
                        if ($list_event['event_type'] == 4) {

                            $cricektData[$event_id]['market_types'][$market_id] = $market_type;
                        } else if ($list_event['event_type'] == 2) {
                            $tennisData[$event_id]['market_types'][$market_id] = $market_type;
                        } else if ($list_event['event_type'] == 1) {
                            $soccerData[$event_id]['market_types'][$market_id] = $market_type;
                        }
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        if ($list_event['event_type'] == 4) {
                            $cricektData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                        } else if ($list_event['event_type'] == 2) {
                            $tennisData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                        } else if ($list_event['event_type'] == 1) {
                            $soccerData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                        }
                    }
                }
            }
        }



        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['type'] = $type;

        if (get_user_type() == 'Operator') {
            $dataArray['type'] = 'inplay';
        }

        // p($exchangeData);
        array_multisort(array_map('strtotime', array_column($cricektData, 'open_date')), SORT_ASC, $cricektData);
        array_multisort(array_map('strtotime', array_column($tennisData, 'open_date')), SORT_ASC, $tennisData);
        array_multisort(array_map('strtotime', array_column($soccerData, 'open_date')), SORT_ASC, $soccerData);

        $cricketListingHtml = $this->load->viewPartial('dashboardMatchListing', array("crickets" => $cricektData, "type" => "Cricket"));

        $dataArray['cricketListingHtml'] = $cricketListingHtml;


        $tennisListingHtml = $this->load->viewPartial('dashboardMatchListing', array("crickets" => $tennisData, "type" => "Tennis"));

        $dataArray['tennisListingHtml'] = $tennisListingHtml;

        $soccerListingHtml = $this->load->viewPartial('dashboardMatchListing', array("crickets" => $soccerData, "type" => "Soccer"));

        $dataArray['soccerListingHtml'] = $soccerListingHtml;

        $dataArray["event_type"] = $event_type;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);
        $dataArray['casino_events'] = $casino_events;
        $this->load->view('dashboard', $dataArray);
        log_message("MY_INFO", 'Dashboard Page Load End');
    }




    function inplay()
    {

        $message = $this->session->flashdata('login_error_message');
        $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
        $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

        $dataArray['message'] = $message;

        $userdata = $_SESSION['my_userdata'];
        $user_id = $userdata['user_id'];



        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );


        $events = $this->Event_model->get_all_events();

        $eventsArr = array();
        if (!empty($events)) {
            foreach ($events as $event) {
                $eventsArr = $event;
                //  $exchange = get_event_by_id($event['event_id']);
                //  $eventsArr['exchange'] = $exchange;
            }
        }

        // p($eventsArr);

        $dataArray['crickets'] = $events;

        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $this->load->view('inplay-dashboard', $dataArray);
    }

    function info($event_id)
    {

        $userdata = $_SESSION['my_userdata'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );


        $info = get_exchange_event_info($event_id);

        $dataArray['response'] = $info;
        // p($dataArray);
        $this->load->view('event_info', $dataArray);
    }



    function eventDetail($match_id)
    {


        $userdata = $_SESSION['my_userdata'];
        $user_id = $userdata['user_id'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );

        $event_id = $match_id;
        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);
        $event_type = isset($list_events[0]['event_type']) ? $list_events[0]['event_type'] : 0;

        $exchangeData = array();
        $fantacyData = array();
        if (get_user_type() == 'User') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Market'));
        } else if (get_user_type() == 'Admin') {

            /*************** Type = 1 is Market and event */
            $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Market'));
        } else if (get_user_type() == 'Hyper Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Market'));
        } else if (get_user_type() == 'Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Market'));
        } else if (get_user_type() == 'Master') {

            /*************** Type = 1 is Market and event */
            $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Market'));
        }


        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {
                if (get_user_type() == 'User') {
                    if (!empty($block_markets)) {
                        foreach ($block_markets as $block_market) {
                            if ($block_market['type'] == 'Sport') {
                                if ($block_market['event_type_id'] == $list_event['event_type']) {
                                    unset($list_events[$key]);
                                }
                            }

                            if ($block_market['type'] == 'Event') {
                                if ($block_market['event_id'] == $list_event['event_id']) {
                                    unset($list_events[$key]);
                                }
                            }
                        }
                    }


                    if (!isset($list_events[$key])) {
                        continue;
                    }
                }

                $event_id = $list_event['event_id'];
                $exchangeData[$event_id] = $list_event;
                $user_id = $_SESSION['my_userdata']['user_id'];
                $check_favourite = $this->Favourite_event_model->get_favourite_event(array('event_id' => $list_event['event_id'], 'user_id' =>  $user_id));


                if (!empty($check_favourite)) {
                    $exchangeData[$event_id]['is_favourite'] = true;
                } else {
                    $exchangeData[$event_id]['is_favourite'] = false;
                }

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));



                if (!empty($market_types)) {

                    foreach ($market_types as $key2 => $market_type) {
                        if (!empty($block_markets)) {

                            foreach ($block_markets as $block_market) {
                                if ($block_market['type'] == 'Market') {

                                    if ($block_market['market_id'] == $market_type['market_id']) {

                                        $market_type['is_block']  = true;
                                    }
                                }
                            }
                        }

                        // $market_id = str_replace('.','',$market_type['market_id']);
                        $market_id = $market_type['market_id'];
                        // p($market_id);
                        $exchangeData[$event_id]['market_types'][$market_id] = $market_type;
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        $exchangeData[$event_id]['market_types'][$market_id]['runners'] = $runners;

                        if (!empty($runners)) {

                            foreach ($exchangeData[$event_id]['market_types'][$market_id]['runners'] as $runnerKey => $runner) {

                                $exchangeData[$event_id]['market_types'][$market_id]['runners'][$runnerKey]['exposure'] = 0;
                            }
                        }




                        $user_id = $_SESSION['my_userdata']['user_id'];
                        $event_type = $list_event['event_type'];
                        $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $event_type);

                        $exchangeData[$event_id]['market_types'][$market_id]['user_info'] = $user_info;



                        $bettings = $this->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $market_id));

                        if (get_user_type() == 'User') {
                            if (!empty($bettings)) {
                                $exposure = get_user_market_exposure_by_marketid($market_id);


                                $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                                if (!empty($runners)) {
                                    foreach ($runners as $key => $runner) {

                                        if (!empty($runner)) {
                                            $selection_id = $runner['selection_id'];


                                            $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] = isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                        }
                                    }
                                }
                                $exchangeData[$event_id]['view_info'] = array();

                                // $exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'] = $bettings->exposure_1;

                                // $exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'] = $bettings->exposure_2;
                            }
                        } else if (get_user_type() == 'Master') {
                            $exposure = get_master_market_exposure_by_marketid($market_id);

                            $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                            if (!empty($runners)) {
                                foreach ($runners as $key => $runner) {

                                    if (!empty($runner)) {
                                        $selection_id = $runner['selection_id'];


                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] = isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                    }
                                    $exchangeData[$event_id]['view_info'] = array();
                                }
                            }
                        } else if (get_user_type() == 'Super Master') {
                            $exposure = get_super_master_market_exposure_by_marketid($market_id);

                            $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                            if (!empty($runners)) {
                                foreach ($runners as $key => $runner) {

                                    if (!empty($runner)) {
                                        $selection_id = $runner['selection_id'];


                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] =  isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                        $exchangeData[$event_id]['view_info'] = array();
                                    }
                                }
                            }
                        } else if (get_user_type() == 'Hyper Super Master') {
                            $exposure = get_hyper_super_master_market_exposure_by_marketid($market_id);

                            $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                            if (!empty($runners)) {
                                foreach ($runners as $key => $runner) {

                                    if (!empty($runner)) {
                                        $selection_id = $runner['selection_id'];


                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] =  isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                        $exchangeData[$event_id]['view_info'] = array();
                                    }
                                }
                            }
                        } else if (get_user_type() == 'Admin') {
                            $exposure = get_admin_market_exposure_by_marketid($market_id);

                            $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                            if (!empty($runners)) {
                                foreach ($runners as $key => $runner) {

                                    if (!empty($runner)) {
                                        $selection_id = $runner['selection_id'];


                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] =  isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                    }
                                }
                            }
                        } else if (get_user_type() == 'Super Admin') {
                            $exposure = get_super_admin_market_exposure_by_marketid($market_id);

                            $runners = $exchangeData[$event_id]['market_types'][$market_id]['runners'];

                            if (!empty($runners)) {
                                foreach ($runners as $key => $runner) {

                                    if (!empty($runner)) {
                                        $selection_id = $runner['selection_id'];


                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][$key]['exposure'] =  isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;

                                        $exchangeData[$event_id]['view_info'] = array();
                                    }
                                }
                            }
                        }
                    }
                    // $fancy_data = $this->Event_model->get_all_fancy_data($list_event['event_id']);
                    // $fantacyData[$list_event['event_id']] =  $fancy_data;
                }
            }
        }


        $dataArray['events'] = $exchangeData;

        if (get_user_type() == 'User') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        } else if (get_user_type() == 'Admin') {

            /*************** Type = 1 is Market and event */
            $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        } else if (get_user_type() == 'Hyper Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        } else if (get_user_type() == 'Super Master') {
            /*************** Type = 1 is Market and event */
            $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        } else if (get_user_type() == 'Master') {

            /*************** Type = 1 is Market and event */
            $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        }




        $fancy_data = $this->Event_model->get_all_fancy_data($event_id);


        if (!empty($block_markets)) {
            foreach ($block_markets as $block_market) {
                if ($block_market['event_id'] == $event_id) {
                    $fancy_data = array();
                }
            }
        }

        if (!empty($fancy_data)) {

            if (get_user_type() == 'User') {
                /*************** Type = 1 is Market and event */
                $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
            } else if (get_user_type() == 'Admin') {

                /*************** Type = 1 is Market and event */
                $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
            } else if (get_user_type() == 'Hyper Super Master') {
                /*************** Type = 1 is Market and event */
                $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
            } else if (get_user_type() == 'Super Master') {
                /*************** Type = 1 is Market and event */
                $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
            } else if (get_user_type() == 'Master') {

                /*************** Type = 1 is Market and event */
                $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
            }



            foreach ($fancy_data as $key => $fancy) {
                if (isset($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['event_id'] == $event_id && $block_market['fancy_id'] == $fancy['selection_id']) {
                            unset($fancy_data[$key]);
                        }
                    }
                }

                // p($fancy);
            }
        }


        $dataArray['fancy_data'] = $fancy_data;

        $marketExchangeHtml = $this->load->viewPartial('exchangeHtml', $dataArray);
        $fancyExchangeHtml = $this->load->viewPartial('fancy-list-html', $dataArray);


        $dataArray['marketExchangeHtml'] = $marketExchangeHtml;
        $dataArray['fancyExchangeHtml'] = $fancyExchangeHtml;


        // echo json_encode($dataArray);

        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['event_id'] = $match_id;
        $dataArray['event_type'] = $event_type;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);


        $this->load->view('dashboardEventDetail', $dataArray);
    }
}
