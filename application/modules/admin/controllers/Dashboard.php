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
        $this->load->model('Market_book_odds_model');
        $this->load->model('Banner_model');



        $this->load->model('Manual_model');


        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }


    function indexxxx($type = null, $event_type = null)
    {

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
                // $list_events = $this->Event_model->get_active_market_events($data);

            } else {
                $list_events = $this->Event_model->get_active_market_events($data);


                $manual_events = $this->Manual_model->get_active_market_events($data);

                $list_events =  array_merge($list_events, $manual_events);

                //  p($list_events);
            }
        }


        // p($list_events);



        $inplayData = array();

        $cricektData = array();
        $tennisData = array();
        $soccerData = array();
        $horseRacingData = array();

        $liveTvData = array();
        if (get_user_type() == 'Operator') {
            $block_markets = array();
            $block_markets_events = array();
        } else {
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
        }








        $casino_events = getCustomConfigItem('casino_event_type');

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                if (get_user_type() == 'Operator') {
                    // $count_fancy_bets = $this->Betting_model->count_fancy(array('match_id' => $list_event['event_id']));
                    // $count_match_bets = $this->Betting_model->count_match_bets(array('match_id' => $list_event['event_id']));
                    // $bettings = $this->Betting_model->operator_bettings_list(array('match_id' => $list_event['event_id']))
                    $count_fancy_bets = 0;
                    $count_match_bets = 0;
                    $bettings = array();
                    $list_event['fancy_bets'] = $count_fancy_bets;
                    $list_event['match_bets'] = $count_match_bets;
                    $list_event['bettings'] = $bettings;
                } else {
                    $list_event['fancy_bets'] = 0;
                    $list_event['match_bets'] = 0;
                    $list_event['bettings'] = 0;
                }

                if (!empty($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['type'] == 'Sport') {
                            if ($block_market['event_type_id'] == $list_event['event_type']) {
                                unset($list_events[$key]);
                            }

                            $casino_search = array_search($block_market['event_type_id'], $casino_events);

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



                // if ($list_event['is_inplay'] == 'Yes') {
                //     $inplayData[$event_id] = $list_event;
                // }

                if ($list_event['event_type'] == 4) {
                    $cricektData[$event_id] = $list_event;
                } else if ($list_event['event_type'] == 2) {
                    $tennisData[$event_id] = $list_event;
                } else if ($list_event['event_type'] == 1) {
                    $soccerData[$event_id] = $list_event;
                } else if ($list_event['event_type'] == 7) {
                    $horseRacingData[$event_id] = $list_event;
                }
                if (get_user_type() == 'Operator') {
                    $market_types = $this->Event_model->list_all_market_types(array('event_id' => $list_event['event_id']));
                } else {
                    $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));


                    $manual_market_types = $this->Manual_model->get_active_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));

                    $market_types = array_merge($market_types, $manual_market_types);
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
                        } else if ($list_event['event_type'] == 7) {
                            unset($horseRacingData[$event_id]);
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
                    } else if ($list_event['event_type'] == 7) {
                        $horseRacingData[$event_id]['is_favourite'] = true;
                    }
                } else {
                    if ($list_event['event_type'] == 4) {
                        $cricektData[$event_id]['is_favourite'] = false;
                    } else if ($list_event['event_type'] == 2) {
                        $tennisData[$event_id]['is_favourite'] = false;
                    } else if ($list_event['event_type'] == 1) {
                        $soccerData[$event_id]['is_favourite'] = false;
                    } else if ($list_event['event_type'] == 7) {
                        $horseRacingData[$event_id]['is_favourite'] = true;
                    }
                }




                if ($list_event['is_tv'] == 'Yes') {
                    // continue;

                    $liveTvData[$event_id] = $list_event;
                }


                // p($market_types);
                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {



                        // if ($type == 'inplay') {
                        if ($market_type['inplay'] == 1) {
                            // continue;
                            $inplayData[$event_id] = $list_event;
                        }


                        // }


                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));



                        $manual_runners = $this->Manual_model->get_market_runners(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        $runners = array_merge($runners, $manual_runners);
                        // if($list_event['event_id'] == '64134348')
                        // {
                        //     p($runners);
                        // }





                        if (empty($runners)) {
                            unset($list_events[$key]);
                            unset($list_event);
                            // p($list_event)
                            continue;
                        }

                        if ($list_events[$key]) {

                            // $market_id = str_replace('.','',$market_type['market_id']);
                            $market_id = $market_type['market_id'];
                            // p($market_id);

                            if (isset($inplayData[$event_id])) {
                                $inplayData[$event_id]['market_types'][$market_id] = $market_type;
                            }



                            if (isset($liveTvData[$event_id])) {
                                $liveTvData[$event_id]['market_types'][$market_id] = $market_type;
                            }
                            if ($list_event['event_type'] == 4) {

                                $cricektData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 2) {
                                $tennisData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 1) {
                                $soccerData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 7) {
                                $horseRacingData[$event_id]['market_types'][$market_id] = $market_type;
                            }

                            if (isset($inplayData[$event_id]['market_types'][$market_id])) {
                                $inplayData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            }




                            if (isset($liveTvData[$event_id]['market_types'][$market_id])) {
                                $liveTvData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            }


                            if ($list_event['event_type'] == 4) {
                                $cricektData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 2) {
                                $tennisData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 1) {
                                $soccerData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 7) {
                                $horseRacingData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            }
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


        // array_multisort(array_map('strtotime', array_column($inplayData, 'open_date')), SORT_ASC, $inplayData);

        array_multisort(array_map('strtotime', array_column($cricektData, 'open_date')), SORT_ASC, $cricektData);
        array_multisort(array_map('strtotime', array_column($tennisData, 'open_date')), SORT_ASC, $tennisData);
        array_multisort(array_map('strtotime', array_column($soccerData, 'open_date')), SORT_ASC, $soccerData);

        array_multisort(array_map('strtotime', array_column($horseRacingData, 'open_date')), SORT_ASC, $horseRacingData);



        $inplayListingHtml = $this->load->viewPartial('inplayMatchListing', array("crickets" => $inplayData, "type" => "Game"));


        // p($liveTvData);
        $liveTvListingHtml = $this->load->viewPartial('tvMatchListing', array("crickets" => $liveTvData, "type" => "Game"));
        $dataArray['liveTvListingHtml'] = $liveTvListingHtml;



        $dataArray['inplayListingHtml'] = $inplayListingHtml;



        $cricketListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $cricektData, "type" => "Cricket"));

        $dataArray['cricketListingHtml'] = $cricketListingHtml;


        $tennisListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $tennisData, "type" => "Tennis"));

        $dataArray['tennisListingHtml'] = $tennisListingHtml;

        $soccerListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $soccerData, "type" => "Soccer"));

        $dataArray['soccerListingHtml'] = $soccerListingHtml;


        $horseListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $horseRacingData, "type" => "Horse"));

        $dataArray['horseListingHtml'] = $horseListingHtml;


        $dataArray["event_type"] = $event_type;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);
        $dataArray['casino_events'] = $casino_events;
        // if($_SESSION["my_userdata"]["user_name"]=="Last031"){
        // p( $dataArray['casino_events']);
        // }


        $this->load->view('home-page', $dataArray);
    }

    function eventdashboard($type = null, $event_type = null)
    {

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
                // $list_events = $this->Event_model->get_active_market_events($data);

            } else {
                $list_events = $this->Event_model->get_active_market_events($data);
            }
        }




        $cricektData = array();
        $tennisData = array();
        $soccerData = array();

        if (get_user_type() == 'Operator') {
            $block_markets = array();
            $block_markets_events = array();
        } else {
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
        }








        $casino_events = getCustomConfigItem('casino_event_type');

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                if (get_user_type() == 'Operator') {
                    // $count_fancy_bets = $this->Betting_model->count_fancy(array('match_id' => $list_event['event_id']));
                    // $count_match_bets = $this->Betting_model->count_match_bets(array('match_id' => $list_event['event_id']));
                    // $bettings = $this->Betting_model->operator_bettings_list(array('match_id' => $list_event['event_id']))
                    $count_fancy_bets = 0;
                    $count_match_bets = 0;
                    $bettings = array();
                    $list_event['fancy_bets'] = $count_fancy_bets;
                    $list_event['match_bets'] = $count_match_bets;
                    $list_event['bettings'] = $bettings;
                } else {
                    $list_event['fancy_bets'] = 0;
                    $list_event['match_bets'] = 0;
                    $list_event['bettings'] = 0;
                }

                if (!empty($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['type'] == 'Sport') {
                            if ($block_market['event_type_id'] == $list_event['event_type']) {
                                unset($list_events[$key]);
                            }

                            $casino_search = array_search($block_market['event_type_id'], $casino_events);

                            // unset($casino_events[$casino_search]);
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
                    $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));
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


                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));






                        if (empty($runners)) {
                            unset($list_events[$key]);
                            unset($list_event);
                            // p($list_event)
                            continue;
                        }






                        if ($list_events[$key]) {

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
        }




        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['type'] = $type;

        if (get_user_type() == 'Operator') {
            $dataArray['type'] = 'inplay';
        }

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
    }

    function eventdashboard2($event_type = null)
    {

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



        $data = array(
            'event_type' => $event_type
        );

        if (get_user_type() == 'Operator') {
            $list_events = $this->Betting_model->get_unsettled_bets_events($data);
            // $list_events = $this->Event_model->get_active_market_events($data);

        } else {
            $list_events = $this->Event_model->get_active_market_events($data);
        }



        $cricektData = array();
        $tennisData = array();
        $soccerData = array();

        if (get_user_type() == 'Operator') {
            $block_markets = array();
            $block_markets_events = array();
        } else {
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
        }








        $casino_events = getCustomConfigItem('casino_event_type');

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                if (get_user_type() == 'Operator') {
                    // $count_fancy_bets = $this->Betting_model->count_fancy(array('match_id' => $list_event['event_id']));
                    // $count_match_bets = $this->Betting_model->count_match_bets(array('match_id' => $list_event['event_id']));
                    // $bettings = $this->Betting_model->operator_bettings_list(array('match_id' => $list_event['event_id']))
                    $count_fancy_bets = 0;
                    $count_match_bets = 0;
                    $bettings = array();
                    $list_event['fancy_bets'] = $count_fancy_bets;
                    $list_event['match_bets'] = $count_match_bets;
                    $list_event['bettings'] = $bettings;
                } else {
                    $list_event['fancy_bets'] = 0;
                    $list_event['match_bets'] = 0;
                    $list_event['bettings'] = 0;
                }

                if (!empty($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['type'] == 'Sport') {
                            if ($block_market['event_type_id'] == $list_event['event_type']) {
                                unset($list_events[$key]);
                            }

                            $casino_search = array_search($block_market['event_type_id'], $casino_events);

                            // unset($casino_events[$casino_search]);
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
                    $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));
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


                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));






                        if (empty($runners)) {
                            unset($list_events[$key]);
                            unset($list_event);
                            // p($list_event)
                            continue;
                        }






                        if ($list_events[$key]) {

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
        }




        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['type'] = $type;

        if (get_user_type() == 'Operator') {
            $dataArray['type'] = 'inplay';
        }

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
        $is_tv = 'No';
        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);

        $manual_events = $this->Manual_model->get_active_market_events($data);

        $list_events =  array_merge($list_events, $manual_events);



        $event_type = isset($list_events[0]['event_type']) ? $list_events[0]['event_type'] : 0;
        $event_name = isset($list_events[0]['event_name']) ? $list_events[0]['event_name'] : 0;
        $events_data = isset($list_events[0]['event_name']) ? $list_events[0] : array();
        $score_match_id = isset($list_events[0]['score_match_id']) ? $list_events[0]['score_match_id'] : 0;
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

        $is_ball_running = 'No';

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
                $is_ball_running = $list_event['is_ball_running'];
                $exchangeData[$event_id] = $list_event;
                $user_id = $_SESSION['my_userdata']['user_id'];
                $check_favourite = $this->Favourite_event_model->get_favourite_event(array('event_id' => $list_event['event_id'], 'user_id' =>  $user_id));


                if (!empty($check_favourite)) {
                    $exchangeData[$event_id]['is_favourite'] = true;
                } else {
                    $exchangeData[$event_id]['is_favourite'] = false;
                }

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));

                $manual_market_types = $this->Manual_model->get_active_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));

                $market_types = array_merge($market_types, $manual_market_types);



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


                        $manual_runners = $this->Manual_model->get_market_runners(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        $runners = array_merge($runners, $manual_runners);



                        $exchangeData[$event_id]['market_types'][$market_id]['runners'] = $runners;

                        if (!empty($runners)) {

                            foreach ($exchangeData[$event_id]['market_types'][$market_id]['runners'] as $runnerKey => $runner) {

                                $exchangeData[$event_id]['market_types'][$market_id]['runners'][$runnerKey]['exposure'] = 0;
                            }
                        }




                        $user_id = $_SESSION['my_userdata']['user_id'];
                        $event_type = $list_event['event_type'];
                        $is_tv = $list_event['is_tv'];

                        $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $event_type);
                        $bookmaker_user_info = $this->User_info_model->get_user_info_by_userid($user_id, '2000');

                        $exchangeData[$event_id]['market_types'][$market_id]['user_info'] = $user_info;
                        $exchangeData[$event_id]['market_types'][$market_id]['bookmaker_user_info'] = $bookmaker_user_info;



                        $bettings = $this->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $market_id));


                        // p($bettings);
                        if (get_user_type() == 'User') {
                            if (!empty($bettings)) {



                                $exposure = get_user_market_exposure_by_marketid($market_id, '', 'No');

                                // p($exposure);
                                // p($exposure);

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
                        } else {
                            $exposure = get_master_market_exposure_by_marketid($market_id, '', 'No');

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
                        }
                    }
                }
            }
        }




        $dataArray['events'] = $exchangeData;

        // p($exchangeData);

        // if (get_user_type() == 'User') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Admin') {

        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Hyper Super Master') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Super Master') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Master') {

        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // }




        // $fancy_data = $this->Event_model->get_all_fancy_data($event_id);


        // if (!empty($block_markets)) {
        //     foreach ($block_markets as $block_market) {
        //         if ($block_market['event_id'] == $event_id) {
        //             $fancy_data = array();
        //         }
        //     }
        // }

        // if (!empty($fancy_data)) {

        //     if (get_user_type() == 'User') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Admin') {

        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Hyper Super Master') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Super Master') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Master') {

        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     }



        //     foreach ($fancy_data as $key => $fancy) {
        //         if (isset($block_markets)) {
        //             foreach ($block_markets as $block_market) {
        //                 if ($block_market['event_id'] == $event_id && $block_market['fancy_id'] == $fancy['selection_id']) {
        //                     unset($fancy_data[$key]);
        //                 }
        //             }
        //         }

        //         // p($fancy);
        //     }
        // }


        // $dataArray['fancy_data'] = $fancy_data;

        $marketExchangeHtml = $this->load->viewPartial('exchangeHtml', $dataArray);
        $fancyExchangeHtml = $this->load->viewPartial('fancy-list-html', $dataArray);


        $dataArray['marketExchangeHtml'] = $marketExchangeHtml;
        $dataArray['fancyExchangeHtml'] = $fancyExchangeHtml;


        // echo json_encode($dataArray);

        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['event_id'] = $match_id;
        $dataArray['event_type'] = $event_type;
        $dataArray['score_match_id'] = $score_match_id;

        $dataArray['event_name'] = $event_name;
        $dataArray['events_data'] = $events_data;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);
        $dataArray['is_tv'] = $is_tv;
        $dataArray['runners'] = $runners;


        $fancy_user_info =  $this->User_info_model->get_user_info_by_userid($user_id, 999);


        $dataArray['fancy_user_info'] = $fancy_user_info;


        // $fancy_lists = $this->Betting_model->get_unique_fancy_betting_by_event_id(array(
        //     'user_id' => get_user_id(),
        //     'event_id' => $event_id
        // ));

        $channelArry = getchannel();
        if (is_array($channelArry['data']['getMatches'])) {
            foreach ($channelArry['data']['getMatches'] as $match) {
                if ($match['MatchID'] == $match_id) {
                    $channel_code = $match['Channel'];
                }
                
            }
        }
        // p( $channel_code );
        $live_tv_url  = "https://central.satsport247.com/stream_ss247_widget/" . $channel_code . "?aC=YmxhY2tqYWNrODg4";


        // $dataArray['fancy_lists'] = $fancy_lists;

        // $live_tv_url = json_decode(get_live_tv($match_id));


        // if(get_user_name() == 'Dm1')
        // {
        // $live_tv_url = $live_tv_url->livetv;
        // p($live_tv_url);
        $dataArray['live_tv_url'] = $live_tv_url;
        $dataArray['is_ball_running'] = $is_ball_running;

        $this->load->view('dashboardEventDetail', $dataArray);
    }

    function masterDetails($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('master-details', $dataArray);
    }

    function reports($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('reports', $dataArray);
    }

    function ledgers($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('ledgers-view', $dataArray);
    }


    function cashTransactions($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('cash-transactions', $dataArray);
    }

    function sportsBettings($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('sports-bettings', $dataArray);
    }

    function sports($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('sports', $dataArray);
    }

    function casinos($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('casinos', $dataArray);
    }

    function otherDetails($type = null, $event_type = null)
    {
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );
        $this->load->view('other-details-view', $dataArray);
    }



    function getEventsMarketExpsure($match_id)
    {
        $event_id = $match_id;
        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);
        $manual_events = $this->Manual_model->get_active_market_events($data);
        $list_events =  array_merge($list_events, $manual_events);

        $user_id = $_SESSION['my_userdata']['user_id'];

        $eventMarketExposureArr = array();

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                $event_id = $list_event['event_id'];

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));
                $manual_market_types = $this->Manual_model->get_active_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));
                $market_types = array_merge($market_types, $manual_market_types);

                if (!empty($market_types)) {
                    foreach ($market_types as $market_type) {
                        
                        $market_id = $market_type['market_id'];
                        $eventMarketExposureArr[$market_id] = array();
                                                
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        $manual_runners = $this->Manual_model->get_market_runners(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));

                        $runners = array_merge($runners, $manual_runners);

                        $bettings = $this->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $market_id));

                        if (get_user_type() == 'User') {
                            if (!empty($bettings)) {

                                $exposure = get_user_market_exposure_by_marketid($market_id, '', 'No');

                                if (!empty($runners)) {
                                    foreach ($runners as $runner) {

                                            $selection_id = $runner['selection_id'];

                                            $eventMarketExposureArr[$market_id][$selection_id] = isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;                                        
                                    }
                                }
                            }else{
                                if (!empty($runners)) {

                                    foreach ($runners as $runner) {
                                        $selection_id = $runner['selection_id'];
                                        $eventMarketExposureArr[$market_id][$selection_id] = 0;
                                    }
                                }
                            }
                        } else {
                            $exposure = get_master_market_exposure_by_marketid($market_id);

                            if (!empty($runners)) {
                                foreach ($runners as $runner) {

                                        $selection_id = $runner['selection_id'];

                                        $eventMarketExposureArr[$market_id][$selection_id] = isset($exposure[$selection_id]) ? $exposure[$selection_id] : 0;
                                    
                                }
                            }
                        }
                    }
                }
            }
        }

        echo json_encode($eventMarketExposureArr);
    }

    function tvEventDetail($match_id)
    {
        $this->load->setTemplate('blank');


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
        $is_tv = 'No';
        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);
        $event_type = isset($list_events[0]['event_type']) ? $list_events[0]['event_type'] : 0;
        $event_name = isset($list_events[0]['event_name']) ? $list_events[0]['event_name'] : 0;
        $events_data = isset($list_events[0]['event_name']) ? $list_events[0] : array();
        $score_match_id = isset($list_events[0]['score_match_id']) ? $list_events[0]['score_match_id'] : 0;
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


        $is_ball_running = 'No';

        $tmp_market_id = '';

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

                $is_ball_running = $list_event['is_ball_running'];
                $exchangeData[$event_id] = $list_event;
                $user_id = $_SESSION['my_userdata']['user_id'];
                $check_favourite = $this->Favourite_event_model->get_favourite_event(array('event_id' => $list_event['event_id'], 'user_id' =>  $user_id));


                if (!empty($check_favourite)) {
                    $exchangeData[$event_id]['is_favourite'] = true;
                } else {
                    $exchangeData[$event_id]['is_favourite'] = false;
                }

                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));


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

                        if ($market_type['market_name'] == 'Match Odds') {
                            $tmp_market_id = $market_id;
                        }
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
                        $is_tv = $list_event['is_tv'];

                        $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $event_type);
                        $bookmaker_user_info = $this->User_info_model->get_user_info_by_userid($user_id, '2000');

                        $exchangeData[$event_id]['market_types'][$market_id]['user_info'] = $user_info;
                        $exchangeData[$event_id]['market_types'][$market_id]['bookmaker_user_info'] = $bookmaker_user_info;



                        $bettings = $this->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $market_id));


                        // p($bettings);
                        if (get_user_type() == 'User') {
                            if (!empty($bettings)) {



                                $exposure = get_user_market_exposure_by_marketid($market_id, '', 'No');


                                // p($exposure);

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
                        } else {
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
                        }
                    }
                }
            }
        }




        $dataArray['events'] = $exchangeData;

        // if (get_user_type() == 'User') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Admin') {

        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Hyper Super Master') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Super Master') {
        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // } else if (get_user_type() == 'Master') {

        //     /*************** Type = 1 is Market and event */
        //     $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'AllFancy'));
        // }




        // $fancy_data = $this->Event_model->get_all_fancy_data($event_id);


        // if (!empty($block_markets)) {
        //     foreach ($block_markets as $block_market) {
        //         if ($block_market['event_id'] == $event_id) {
        //             $fancy_data = array();
        //         }
        //     }
        // }

        // if (!empty($fancy_data)) {

        //     if (get_user_type() == 'User') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Admin') {

        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Hyper Super Master') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Super Master') {
        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     } else if (get_user_type() == 'Master') {

        //         /*************** Type = 1 is Market and event */
        //         $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Fancy'));
        //     }



        //     foreach ($fancy_data as $key => $fancy) {
        //         if (isset($block_markets)) {
        //             foreach ($block_markets as $block_market) {
        //                 if ($block_market['event_id'] == $event_id && $block_market['fancy_id'] == $fancy['selection_id']) {
        //                     unset($fancy_data[$key]);
        //                 }
        //             }
        //         }

        //         // p($fancy);
        //     }
        // }


        // $dataArray['fancy_data'] = $fancy_data;

        $marketExchangeHtml = $this->load->viewPartial('exchangeHtml', $dataArray);
        $fancyExchangeHtml = $this->load->viewPartial('fancy-list-html', $dataArray);


        $dataArray['marketExchangeHtml'] = $marketExchangeHtml;
        $dataArray['fancyExchangeHtml'] = $fancyExchangeHtml;


        // echo json_encode($dataArray);

        $chips = $this->User_chip_model->getUserChips($user_id);
        $dataArray['chips'] = $chips;
        $dataArray['event_id'] = $match_id;
        $dataArray['event_type'] = $event_type;
        $dataArray['score_match_id'] = $score_match_id;

        $dataArray['event_name'] = $event_name;
        $dataArray['events_data'] = $events_data;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);
        $dataArray['is_tv'] = $is_tv;
        $dataArray['runners'] = $runners;


        $fancy_user_info =  $this->User_info_model->get_user_info_by_userid($user_id, 999);


        $dataArray['fancy_user_info'] = $fancy_user_info;


        $fancy_lists = $this->Betting_model->get_unique_fancy_betting_by_event_id(array(
            'user_id' => get_user_id(),
            'event_id' => $event_id
        ));


        // $dataArray['fancy_lists'] = $fancy_lists;

        $live_tv_url = json_decode(get_live_tv($match_id));


        // if(get_user_name() == 'Dm1')
        // {
        $live_tv_url = $live_tv_url->livetv;
        // p($live_tv_url);
        $dataArray['live_tv_url'] = $live_tv_url;
        $dataArray['tmp_market_id'] = $tmp_market_id;




        $dataArray['exchangeData'] = $exchangeData[$match_id];
        $dataArray['is_ball_running']  = $is_ball_running;

        $this->load->view('tvEventDetail', $dataArray);
    }



    function index($type = null, $event_type = null)
    {

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


        $list_events = getTodayAllEvents();



        $manual_events = $this->Manual_model->get_active_market_events();


        $list_events =  array_merge($list_events, $manual_events);


        $inplayData = array();

        $cricektData = array();
        $tennisData = array();
        $soccerData = array();
        $horseRacingData = array();

        $liveTvData = array();

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

        $casino_events = getCustomConfigItem('casino_event_type');

        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {



                // if($list_event['is_inplay'] == 'False')
                // {
                //     $check = $this->Market_book_odds_model->check_market_inplay($list_event['event_id']);



                //     if(!empty($check))
                //     {

                //         if($check['total_inplay'] > 0 )
                //         {
                //             $list_event['is_inplay'] = 'True';

                //         }
                //     }
                // }
                if (!empty($block_markets)) {
                    foreach ($block_markets as $block_market) {
                        if ($block_market['type'] == 'Sport') {

                            if ($block_market['event_type_id'] == $list_event['event_type']) {
                                unset($list_events[$key]);
                            }
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
                    $cricektData[$event_id] = array(
                        'competition_id' => 0,
                        'event_type' => $list_event['event_type'],
                        'event_id' => $list_event['event_id'],
                        'event_name' => $list_event['event_name'],
                        'open_date' => date('Y-m-d H:i:s', strtotime($list_event['open_date'])),
                        'event_type_name' => 'Cricket',
                        'is_bm' => $list_event['is_bookmaker'],
                        'is_tv' => $list_event['is_tv'],
                        'is_inplay' => $list_event['is_inplay'],
                        'is_fancy' => $list_event['is_fancy'],



                    );
                } else if ($list_event['event_type'] == 2) {
                    $tennisData[$event_id] = array(
                        'competition_id' => 0,
                        'event_type' => $list_event['event_type'],
                        'event_id' => $list_event['event_id'],
                        'event_name' => $list_event['event_name'],
                        'open_date' => date('Y-m-d H:i:s', strtotime($list_event['open_date'])),
                        'event_type_name' => 'Tennis',
                        'is_bm' => $list_event['is_bookmaker'],
                        'is_tv' => $list_event['is_tv'],
                        'is_inplay' => $list_event['is_inplay'],
                        'is_fancy' => $list_event['is_fancy'],

                    );;
                } else if ($list_event['event_type'] == 1) {
                    $soccerData[$event_id] = array(
                        'competition_id' => 0,
                        'event_type' => $list_event['event_type'],
                        'event_id' => $list_event['event_id'],
                        'event_name' => $list_event['event_name'],
                        'open_date' => date('Y-m-d H:i:s', strtotime($list_event['open_date'])),
                        'event_type_name' => 'Soccer',
                        'is_bm' => $list_event['is_bookmaker'],
                        'is_tv' => $list_event['is_tv'],
                        'is_inplay' => $list_event['is_inplay'],
                        'is_fancy' => $list_event['is_fancy'],


                    );;
                } else if ($list_event['event_type'] == 7) {

                    $horseRacingData[$event_id] = array(
                        'competition_id' => 0,
                        'event_type' => $list_event['event_type'],
                        'event_id' => $list_event['event_id'],
                        'event_name' => $list_event['event_name'],
                        'open_date' => date('Y-m-d H:i:s', strtotime($list_event['open_date'])),
                        'event_type_name' => 'Horse Racing',
                        'is_bm' => $list_event['is_bookmaker'],
                        'is_tv' => $list_event['is_tv'],
                        'is_inplay' => $list_event['is_inplay'],
                        'is_fancy' => $list_event['is_fancy'],


                    );;
                }

                if ($list_event['is_tv'] == 'True' && $list_event['is_inplay'] == 'True' && $list_event['event_type'] == '4') {

                    // $check = json_decode(get_live_tv($list_event['event_id']), 2);


                    // if (!empty($check['livetv'])) {
                    $liveTvData[$event_id] = array(
                        'competition_id' => 0,
                        'event_type' => $list_event['event_type'],
                        'event_id' => $list_event['event_id'],
                        'event_name' => $list_event['event_name'],
                        'open_date' => date('Y-m-d H:i:s', strtotime($list_event['open_date'])),
                        'event_type_name' => 'Soccer',
                        'is_bm' => $list_event['is_bookmaker'],
                        'is_tv' => $list_event['is_tv'],
                        'is_inplay' => $list_event['is_inplay'],
                        'is_fancy' => $list_event['is_fancy'],
                    );;
                    // }
                }






                if ($list_event['event_type'] == 7) {

                    $market_types = $this->Manual_model->get_active_market_types(array('event_id' => $list_event['event_id'], 'status' => 'OPEN'));
                } else {

                    $market_types = $list_event['marketTypes'];
                }










                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {

                        if ($list_event['is_inplay'] == 'True') {
                            $market_type['inplay'] = 1;
                        } else {
                            $market_type['inplay'] = 0;
                        }

                        $tmpRunners = $market_type['marketRunners'];

                        $runners = array();


                        if ($list_event['event_type'] == 7) {
                            $runners = $this->Manual_model->get_market_runners(array(
                                'event_id' => $list_event['event_id'],
                                'market_id' => $market_type['market_id'],
                            ));
                        }

                        if (!empty($tmpRunners)) {
                            foreach ($tmpRunners as $tmpRunner) {
                                $tmpRunner['id'] = $tmpRunner['selection_id'];
                                $runners[] = $tmpRunner;
                                // p($runners);
                            }
                        }






                        if (empty($runners)) {
                            unset($list_events[$key]);
                            unset($list_event);
                            // p($list_event)
                            continue;
                        }







                        if ($list_events[$key]) {
                            // $market_id = str_replace('.','',$market_type['market_id']);
                            $market_id = $market_type['market_id'];
                            // p($market_id);


                            if ($list_event['event_type'] == 4) {

                                $cricektData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 2) {
                                $tennisData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 1) {
                                $soccerData[$event_id]['market_types'][$market_id] = $market_type;
                            } else if ($list_event['event_type'] == 7) {



                                $horseRacingData[$event_id]['market_types'][$market_id] = $market_type;
                            }


                            if (!empty($liveTvData[$event_id])) {
                                $liveTvData[$event_id]['market_types'][$market_id] = $market_type;
                            }




                            if ($list_event['event_type'] == 4) {
                                $cricektData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 2) {
                                $tennisData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 1) {
                                $soccerData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            } else if ($list_event['event_type'] == 7) {
                                $horseRacingData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            }

                            if (!empty($liveTvData[$event_id])) {
                                $liveTvData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                            }
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




        // array_multisort(array_map('strtotime', array_column($inplayData, 'open_date')), SORT_ASC, $inplayData);

        array_multisort(array_map('strtotime', array_column($cricektData, 'open_date')), SORT_ASC, $cricektData);
        array_multisort(array_map('strtotime', array_column($tennisData, 'open_date')), SORT_ASC, $tennisData);
        array_multisort(array_map('strtotime', array_column($soccerData, 'open_date')), SORT_ASC, $soccerData);

        array_multisort(array_map('strtotime', array_column($horseRacingData, 'open_date')), SORT_ASC, $horseRacingData);



        $inplayListingHtml = $this->load->viewPartial('inplayMatchListing', array("crickets" => $inplayData, "type" => "Game"));


        $liveTvListingHtml = $this->load->viewPartial('tvMatchListing', array("crickets" => $liveTvData, "type" => "Game"));

        $dataArray['liveTvListingHtml'] = $liveTvListingHtml;



        $dataArray['inplayListingHtml'] = $inplayListingHtml;




        $cricketListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $cricektData, "type" => "Cricket"));

        $dataArray['cricketListingHtml'] = $cricketListingHtml;


        $tennisListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $tennisData, "type" => "Tennis"));

        $dataArray['tennisListingHtml'] = $tennisListingHtml;



        // p($soccerData);
        $soccerListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $soccerData, "type" => "Soccer"));

        $dataArray['soccerListingHtml'] = $soccerListingHtml;


        $horseListingHtml = $this->load->viewPartial('cricketMatchListing', array("crickets" => $horseRacingData, "type" => "Horse"));

        $dataArray['horseListingHtml'] = $horseListingHtml;


        $dataArray["event_type"] = $event_type;
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $dataArray['superiors']  = json_encode($superior);
        $dataArray['casino_events'] = $casino_events;
        // if($_SESSION["my_userdata"]["user_name"]=="Last031"){
        // p( $dataArray['casino_events']);
        // }
        $dataArray['welcome_banner'] = $this->Event_model->get_addWelcomeNoteBanner();
        $dataArray['header_banners'] = $this->Banner_model->get_active_header_banners();

        $this->load->view('home-page', $dataArray);
    }

    public function welcome_note_banner()
    {

        if (!empty($this->input->post())) {
          
            $id = $this->input->post('id');

            if ($_FILES['welcome_note_banner']['name']) {
                // p(APPPATH.'../assets/deposit_screenshot/');
                $config['upload_path']          = 'assets/welcome_note_banner/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 16000;
                $config['file_name']           = date('d-m-Y h:i:s');

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('welcome_note_banner')) {
                    $error = array('error' => $this->upload->display_errors());
                    p($error);
                    // $this->load->view('deposit-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type,'errors'=>$error['error']));
                    // $this->load->view('deposit-request-form', $error['error']);
                }
            }

            // p($this->input->post());
            if (empty($id)) {
                $dataArray = array(
                    'welcome_note_banner_name' => $this->upload->data('file_name'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'created_by' => get_user_id(),
                );
                $this->session->set_flashdata('operation_msg', 'Welcome Note Banner Added Successfuly');
            } else {
                $dataArray = array(
                    'id' => $id,
                    'welcome_note_banner_name' => $this->upload->data('file_name'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'updated_by' => get_user_id(),
                );
                $this->session->set_flashdata('operation_msg', 'Welcome Note Banner Updated Successfuly');
            }

            $this->Event_model->addWelcomeNoteBanner($dataArray);
            
            redirect(base_url('welcome-note-banner'));
        } else {

            $dataArray = $this->Event_model->get_addWelcomeNoteBanner();

          
            $this->load->view('welcome-note-banner',$dataArray);
        }
    }

    public function delete_welcome_note_banner($id)
    {
        $this->Event_model->delete_welcome_note_banner($id);
        $this->session->set_flashdata('operation_msg', 'Welcome Note Banner Deleted Successfuly');
        redirect('welcome-note-banner');
    }
}
