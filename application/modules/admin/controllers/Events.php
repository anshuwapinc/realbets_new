<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_model');
        $this->load->model('Event_model');
        $this->load->model('Manual_model');

        $this->load->model('Fancy_data_model');

        $this->load->model('Betting_model');
        $this->load->model('User_info_model');
        $this->load->model('Favourite_event_model');
        $this->load->model('Masters_betting_settings_model');
        $this->load->model('Market_book_odds_model');
        $this->load->model('Market_book_odds_fancy_model');

        $this->load->model('Block_market_model');
        $this->load->model('Event_exchange_entry_model');

        $this->load->model('Competition_model');
        $this->load->model('Market_type_model');
        $this->load->model('Market_book_odds_runner_model');



        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
    }


    public function getevents($type = null)
    {
        if ($type == 'inplay') {
            $data['inplay'] = '1';
            $list_events = $this->Event_model->list_events($data);
        } else {
            $data = array();
            $list_events = $this->Event_model->list_events($data);
        }


        $exchangeData = array();
        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {
                $exchangeData[$key] = $list_event;


                $market_book_odds_runner = $this->Event_model->list_market_book_odds_runner($list_event['event_id']);

                $exchangeData[$key]['runners'] = $market_book_odds_runner;
            }
        }
        $dataArray['crickets'] = $exchangeData;
        $matchListingHtml = $this->load->viewPartial('dashboardMatchListing', $dataArray);
        echo json_encode(array('matchListingHtml' => $matchListingHtml));
    }

    public function backlays()
    {
        $event_id = $this->input->post('matchId');
        $market_id = $this->input->post('MarketId');

        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);


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



                // p($market_types);
                // p('block_markets',0);

                // p($block_markets,0);
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
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'] = 0;
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'] = 0;


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
                foreach ($block_markets as $block_market) {
                    if ($block_market['event_id'] == $event_id && $block_market['fancy_id'] == $fancy['selection_id']) {
                        unset($fancy_data[$key]);
                    }
                }
                // p($fancy);
            }
        }



        $dataArray['fancy_data'] = $fancy_data;

        echo json_encode($dataArray);
    }

    public function bettingList()
    {

        $user_id = $_SESSION['my_userdata']['user_id'];
        $match_id = $this->input->post('matchId');
        $user_type = $_SESSION['my_userdata']['user_type'];
        if ($user_type == 'Master') {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else if ($user_type == 'Super Master') {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else if ($user_type == 'Hyper Super Master') {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else if ($user_type == 'Admin') {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else if ($user_type == 'Super Admin') {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else if ($user_type == 'Operator') {
            $superadmin_details = $this->User_model->getSuperAdmin();

            $user_id = $superadmin_details->user_id;
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = get_master_betting_list($dataValues);
        } else {
            $dataValues = array(
                'user_id' => $user_id,
                'match_id' => $match_id
            );
            $bettings = $this->Betting_model->get_bettings_list($dataValues);
        }


        array_multisort(array_map('strtotime', array_column($bettings, 'created_at')), SORT_DESC, $bettings);

        $dataArray['bettings'] = $bettings;
        $exhangeHtml = $this->load->viewPartial('betting-list-html', $dataArray);
        $data['bettingHtml'] = $exhangeHtml;

        $exposure = number_format(count_total_exposure($user_id), 2);
        $balance = number_format(count_total_balance($user_id), 2);

        $data['balance'] = $balance;
        $data['exposure'] = $exposure;

        echo json_encode($data);
    }


    public function savebet()
    {
        try {
            // p($this->input->post());
            $user_id = $_SESSION['my_userdata']['user_id'];
            // $balance = count_total_balance($user_id);
            $stake = $this->input->post('stake');
            $loss = $this->input->post('loss');
            $profit = $this->input->post('profit');
            $price_val = $this->input->post('priceVal');
            $selection_id = $this->input->post('selectionId');
            $betting_type = $this->input->post('betting_type');
            $MarketId = $this->input->post('MarketId');
            $exposure1 = $this->input->post('exposure1');
            $exposure2 = $this->input->post('exposure2');
            $event_type = $this->input->post('event_type');

            $max_profit = max($exposure1, $exposure2);
            $max_loss = min($exposure1, $exposure2);
            $unmatch_bet = 'No';
            $p_l = $this->input->post('p_l');
            $matchId = $this->input->post('matchId');
            $user_type = get_user_type();
            $superior = get_superior_arr($user_id, $user_type);
            $is_back = $this->input->post('isback');
            $event_detail = $this->Event_model->get_event_by_event_id_for_betting($matchId);


            log_message("MY_INFO", get_user_id() . " ----- Match Bet Start Price " . $price_val);

            if ($betting_type == 'Fancy') {
                $sport_id = 999;
            } else {
                $sport_id = $event_type;
            }


            if ($betting_type == 'Match') {
                $market_detail = $this->Market_type_model->get_market_type_by_market_id(array(
                    'event_id' => $matchId,
                    'market_id' => $MarketId,
                ));
            }



            if ($sport_id == '1001' || $sport_id == '1002' || $sport_id == '1003' || $sport_id == '1004' || $sport_id == '1005' || $sport_id == '1006' || $sport_id == '1007') {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 1000);
            } else if ($market_detail->market_name == 'Bookmaker') {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 2000);

                if (!empty($user_info)) {



                    if ($user_info->is_bookmaker_active == 'No') {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Bookmaker Locked!'
                        );
                        echo json_encode($dataArray);
                        exit;
                    }
                }
            } else {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $sport_id);
                if ($market_detail->market_name == 'Toss') {
                    $user_info->max_stake = 50000;
                    $user_info->pre_inplay_stake = 50000;
                    $user_info->pre_inplay_profit = 50000;
                }
                // p($user_info);

            }


            if (!empty($user_info)) {
                sleep($user_info->bet_delay);
            }





            //  if ($_SESSION['my_userdata']['user_name'] == 'TA04') {
            if ($betting_type == 'Match') {


                if ($event_detail->event_type == 4 || $event_detail->event_type == 1 || $event_detail->event_type == 2) {


                    $check_odds = get_match_odds(array(
                        'market_id' => $MarketId,
                        'selection_id' => $selection_id,
                    ));


                    log_message("MY_INFO", get_user_id() . " ----- Match Bet Data  Price " . json_encode($check_odds));



                    if ($is_back == 1) {

                        if ($price_val < $check_odds['back_1_price']) {
                            $price_val = $check_odds['back_1_price'];
                        }
                    } else {
                        if ($price_val > $check_odds['lay_1_price']) {
                            $price_val = $check_odds['lay_1_price'];
                        }
                    }
                }


                log_message("MY_INFO", get_user_id() . " ----- Match Bet Data  Price val " . $price_val);

                // p('BEFORE . ---  '.$profit.' --- '.$loss,0);
                if ($is_back == 1) {

                    $profit = ($price_val * $stake) - $stake;
                    $loss = $stake;
                } else if ($is_back == 0) {

                    $loss = ($price_val * $stake) - $stake;
                    $profit = $stake;
                }

                // p('AFTER . ---  '.$profit.' --- '.$loss);

            }
            // }

            if ($stake == 0) {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Stake Ammout zero not allowed'
                );

                echo json_encode($dataArray);
                exit;
            }



            if (empty($event_detail)) {
                $event_detail = $this->Manual_model->get_event_by_event_id_for_betting($matchId);
            }
            $user_detail = $this->User_model->getUserById($user_id);


            // $balance = $user_detail->balance;
            $balance = count_total_balance($user_id);

            if ($betting_type === 'Match') {

                $market_detail = $this->Market_type_model->get_market_type_by_market_id(array(
                    'event_id' => $matchId,
                    'market_id' => $MarketId,
                ));


                if (empty($market_detail)) {
                    $market_detail = $this->Manual_model->get_market_type_by_market_id(array(
                        'event_id' => $matchId,
                        'market_id' => $MarketId,
                    ));
                }




                if ($market_detail->market_name == 'Match Odds') {
                    $market_start_time = $market_detail->market_start_time;

                    $date = new DateTime($market_start_time);
                    $date2 = new DateTime(date('Y-m-d H:i:s'));


                    $diff = $date->getTimestamp() - $date2->getTimestamp();


                    // if ($diff > 1800) {
                    //     $dataArray = array(
                    //         'success' => false,
                    //         'message' => 'Match Odds Bet Not Placed'
                    //     );

                    //     echo json_encode($dataArray);
                    //     exit;
                    // }
                }


                $runner_detail = $this->Market_book_odds_runner_model->get_runner(array(
                    'event_id' => $matchId,
                    'market_id' => $MarketId,
                    'selection_id' => $selection_id,

                ));



                if (empty($runner_detail)) {
                    $runner_detail = $this->Manual_model->get_runner(array(
                        'event_id' => $matchId,
                        'market_id' => $MarketId,
                        'selection_id' => $selection_id,

                    ));
                }




                $exposure = (array) get_user_market_exposure_by_marketid($MarketId);



                $newexposureArr_temp = (array) get_user_max_profit_by_marketid($MarketId, get_user_id(), 'Yes');


                $max_profit_arr = array();


                if (!empty($exposure)) {
                    foreach ($exposure as $key => $exp) {

                        if ($exp >= 0) {
                            $max_profit_arr[$key] += $exp;
                        } else {
                            $max_profit_arr[$key] += $exp;
                        }
                    }
                }


                if (!empty($newexposureArr_temp)) {
                    foreach ($newexposureArr_temp as $key => $exp) {

                        if ($exp >= 0) {
                            $max_profit_arr[$key] += $exp;
                        } else {
                            $max_profit_arr[$key] = 0;
                        }
                    }
                }



                if (empty($max_profit_arr)) {
                    $max_profit_arr = get_market_runners($MarketId);
                    // if (empty($exposure)) {
                    //     $exposure = $newexposureArr_temp;
                    // }
                }






                $tmp_unmatch_bet = 'No';


                if ($event_detail->event_type == 4 || $event_detail->event_type == 1 || $event_detail->event_type == 2) {
                    if ($market_detail->market_name == 'Match Odds' || $market_detail->market_name == 'Bookmaker') {
                        $check_odds = get_match_odds(array(
                            'market_id' => $MarketId,
                            'selection_id' => $selection_id,
                        ));
                    }
                } else {
                    $check_odds = "";
                }


                if (!empty($check_odds)) {
                    if ($is_back == 1) {
                        $c_odds = $check_odds['back_1_price'];

                        if ($price_val > $c_odds) {
                            $tmp_unmatch_bet = 'Yes';
                        }
                    } else {
                        $c_odds = $check_odds['lay_1_price'];
                        if ($price_val < $c_odds) {
                            $tmp_unmatch_bet = 'Yes';
                        }
                    }
                }



                // p($tmp_unmatch_bet);

                // $exposure = $user_detail->exposure;

                $newexposureArr = $exposure;



                if (!empty($max_profit_arr)) {


                    foreach ($max_profit_arr as $key => $exp) {
                        if ($is_back == 1) {
                            if ($selection_id == $key) {
                                $max_profit_arr[$key] += $profit;
                            } else {
                                // $max_profit_arr[$key] -= $loss;
                            }
                        } else {
                            if ($selection_id == $key) {
                                // $max_profit_arr[$key] -= $loss;
                            } else {
                                $max_profit_arr[$key] += $profit;
                            }
                        }
                    }
                }




                if ($tmp_unmatch_bet == 'Yes') {
                } else {
                    if (!empty($newexposureArr)) {
                        foreach ($newexposureArr as $key => $exp) {
                            if ($is_back == 1) {
                                if ($selection_id == $key) {
                                    $newexposureArr[$key] += $profit;
                                } else {
                                    $newexposureArr[$key] -= $loss;
                                }
                            } else {
                                if ($selection_id == $key) {
                                    $newexposureArr[$key] -= $loss;
                                } else {
                                    $newexposureArr[$key] += $profit;
                                }
                            }
                        }
                    }
                }






                if (!empty($exposure)) {



                    $minExposure = min($exposure) < 0 ? min($exposure) : 0;


                    if ($minExposure > 0) {
                        $minExposure = 0;
                    }
                    $newexposure = min($newexposureArr) < 0 ? min($newexposureArr) : 0;


                    $max_profit = max($max_profit_arr);


                    $max_loss = min($max_profit_arr);



                    $unmatch_exposure = $this->Betting_model->count_total_unmatch_market_exposure(
                        array(
                            'match_id' => $matchId,
                            'market_id' => $MarketId,
                            'user_id' => $user_id,
                        )
                    );



                    if ($newexposure >= 0) {
                        $newexposure = 0;

                        if (!empty($unmatch_exposure)) {
                            $newexposure += abs($unmatch_exposure->total_exposure);
                        }
                    } else {
                        $newexposure = abs($newexposure);


                        if (!empty($unmatch_exposure)) {
                            $newexposure += abs($unmatch_exposure->total_exposure);
                        }
                    }


                    if ($tmp_unmatch_bet == 'Yes') {

                        $newexposure += $loss;
                    }


                    $minExposure = abs($minExposure);



                    ///Unmatch exposure check



                    if (!empty($unmatch_exposure)) {
                        $minExposure += abs($unmatch_exposure->total_exposure);
                    }
                    // $balance = ($minExposure * -1) + $balance;
                    // $balance = ($minExposure * 1) + $balance;
                    $balance =  $balance + ($minExposure * 1);


                    $totalbalance = abs($newexposure);









                    // p($balance.'========'.$totalbalance);


                    if ($balance < $totalbalance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                } else {
                    if ($loss > $balance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                }

                // p('exit');
            } else {


                $dataArray = array(
                    'selection_id' => $selection_id,
                    'match_id' => $matchId,

                    'betting_type' => 'Fancy',
                    'user_id' => $user_id
                );

                $max = $this->Betting_model->get_max_fancy_bettings($dataArray);
                $min = $this->Betting_model->get_min_fancy_bettings($dataArray);

                $max_p = $max + 5;
                $min_p = $min - 5;

                $scores = array_reverse(range($min_p, $max_p));

                $bettings = $this->Betting_model->get_fancy_bettings($dataArray);



                if (!empty($bettings)) {


                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;


                        foreach ($scores as $score) {
                            if ($betting->is_back == 0) {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $total = $tmp_array[$score] + $loss * -1;


                                        $tmp_array[$score] = $total;
                                    } else {
                                        $total = $tmp_array[$score] + $profit * 1;
                                        $tmp_array[$score] = $total;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $tmp_array[$score] = $profit;
                                    } else {
                                        $tmp_array[$score] = $loss * -1;
                                    }
                                }
                            } else {

                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $total = $tmp_array[$score] + $profit * 1;
                                        $tmp_array[$score] = $total;
                                    } else {
                                        $total = $tmp_array[$score] + $loss * -1;
                                        $tmp_array[$score] = $total;
                                    }
                                } else {
                                    if ($score >= $price_val) {
                                        $tmp_array[$score] = $profit * 1;
                                    } else {
                                        $tmp_array[$score] = $loss * -1;
                                    }
                                }
                            }
                        }
                    }


                    $minExposure = abs(min($tmp_array) < 0 ? min($tmp_array) : 0);
                    $tmp_new_array = $tmp_array;


                    $loss = $this->input->post('loss');
                    $profit = $this->input->post('profit');

                    $stake =  $this->input->post('stake');
                    //  if($_SESSION['my_userdata']['user_name'] == 'Checkcl') 
                    // {


                    // $fancy_detail  = $this->Market_book_odds_fancy_model->get_fancy_detail(array(
                    //     'selection_id' => $selection_id,
                    //     'match_id' => $matchId,

                    // ));
                    $fancy_detail = (array) checkFancyCurrentOdds($matchId, $selection_id);

                    log_message("MY_INFO", "BEFORE PROFIT " . $profit . "   LOSS " . ($loss) . "  STAKE" . $stake);

                    log_message("MY_INFO", "FANCY DETAIL" . (json_encode($fancy_detail)));


                    $fancy_size = 0;

                    if (!empty($fancy_detail)) {
                        $lay_size = $fancy_detail['lay_size1'];
                        $back_size = $fancy_detail['back_size1'];

                        log_message("MY_INFO", "BEFORE LAYSIZE " . $lay_size . "   BACKSIZE " . ($back_size));

                        if ($is_back == 1) {

                            $fancy_size = $back_size;
                            $profit = ($back_size * $stake / 100);

                            $loss =  $stake;
                        } else {
                            $fancy_size = $lay_size;

                            $loss = ($lay_size * $stake / 100);
                            $profit =  $stake;
                        }
                    }


                    //  }

                    log_message("MY_INFO", "AFTER PROFIT " . $profit . "   LOSS " . ($loss));



                    $price_val = $this->input->post('priceVal');


                    foreach ($scores as $score) {
                        if ($is_back == 0) {
                            if (isset($tmp_new_array[$score])) {
                                if ($score >= $price_val) {
                                    $total = $tmp_new_array[$score] + $loss * -1;


                                    $tmp_new_array[$score] = $total;
                                } else {
                                    $total = $tmp_new_array[$score] + $profit * 1;
                                    $tmp_new_array[$score] = $total;
                                }
                            } else {
                                if ($score < $price_val) {
                                    $tmp_new_array[$score] = $profit;
                                } else {
                                    $tmp_new_array[$score] = $loss * -1;
                                }
                            }
                        } else {

                            if (isset($tmp_new_array[$score])) {
                                if ($score >= $price_val) {
                                    $total = $tmp_new_array[$score] + $profit * 1;
                                    $tmp_new_array[$score] = $total;
                                } else {
                                    $total = $tmp_new_array[$score] + $loss * -1;
                                    $tmp_new_array[$score] = $total;
                                }
                            } else {
                                if ($score >= $price_val) {
                                    $tmp_new_array[$score] = $profit * 1;
                                } else {
                                    $tmp_new_array[$score] = $loss * -1;
                                }
                            }
                        }
                    }



                    $newexposure = abs(min($tmp_new_array) < 0 ? min($tmp_new_array) : 0);

                    $balance =  $balance + ($minExposure * 1);




                    $totalbalance = abs($newexposure);







                    if ($balance < $totalbalance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                } else {
                    if ($loss > $balance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                }
            }




            $user_details = $this->User_model->getUserByIdForBetting($user_id);



            if (!empty($user_details)) {
                if ($user_details->is_betting_open == 'No') {
                    $dataArray = array(
                        'success' => false,
                        'message' => 'Betting Rights is closed'
                    );
                    echo json_encode($dataArray);
                    exit;
                }

                if ($user_details->is_locked == 'Yes') {
                    $dataArray = array(
                        'success' => false,
                        'message' => 'Your account is locked by your superior.'
                    );
                    echo json_encode($dataArray);
                    exit;
                }

                if ($user_details->is_closed == 'Yes') {
                    $dataArray = array(
                        'success' => false,
                        'message' => 'Your account is closed by your superior.'
                    );
                    echo json_encode($dataArray);
                    exit;
                }


                if ($betting_type == 'Fancy') {
                    $sport_id = 999;
                } else {
                    $sport_id = $event_type;
                }



                if ($sport_id == '1001' || $sport_id == '1002' || $sport_id == '1003' || $sport_id == '1004' || $sport_id == '1005' || $sport_id == '1006' || $sport_id == '1007') {
                    $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 1000);
                } else if ($market_detail->market_name == 'Bookmaker') {
                    $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 2000);

                    if (!empty($user_info)) {



                        if ($user_info->is_bookmaker_active == 'No') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Bookmaker Locked!'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }
                    }
                } else {
                    $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $sport_id);
                    if ($market_detail->market_name == 'Toss') {
                        $user_info->max_stake = 50000;
                        $user_info->pre_inplay_stake = 50000;
                        $user_info->pre_inplay_profit = 50000;
                    }
                    // p($user_info);

                }




                if (!empty($user_info)) {


                    if ($betting_type == 'Fancy') {


                        if ($user_info->is_fancy_active == 'No') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Fancy Locked!'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }


                        // $market_odds_detail = $this->Market_book_odds_fancy_model->get_fancy_detail(array(
                        //     'match_id' => $matchId,
                        //     'selection_id' => $selection_id,
                        // ));

                        $market_odds_detail = (array) checkFancyCurrentOdds($matchId, $selection_id);

                        if ($is_back == 1) {
                            if ($price_val != $market_odds_detail['back_price1']) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Fancy Suspended Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }
                        } else {

                            if ($price_val != $market_odds_detail['lay_price1']) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Fancy Suspended Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }
                        }
                    } else {
                        $market_odds_detail = $this->Market_book_odds_model->get_market_book_odds_by_market_id($MarketId);


                        if (empty($market_odds_detail)) {
                            $market_odds_detail = $this->Manual_model->get_market_book_odds_by_market_id($MarketId);
                        }
                        $market_odds_detail_tmp = (array) $market_odds_detail;
                    }





                    if ($betting_type == 'Fancy') {


                        if (!empty($market_odds_detail)) {
                            if ($market_odds_detail['game_status'] == 'SUSPENDED') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Fancy Suspended Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($market_odds_detail['game_status'] == 'Ball Running') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Fancy Suspended Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($market_odds_detail['cron_disable'] == 'Yes') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Fancy Suspended Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }
                        }




                        if ($user_info->min_stake > $stake) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Min Stake allowed is: ' . $user_info->min_stake
                            );
                            echo json_encode($dataArray);
                            exit;
                        }

                        if ($user_info->max_stake < $stake) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Max Stake allowed is: ' . $user_info->max_stake
                            );
                            echo json_encode($dataArray);
                            exit;
                        }

                        // $fancy_data = (array) $this->load->Market_book_odds_fancy_model->get_fancy_by_selection_id($selection_id);


                        //  if (empty($fancy_data)) {
                        //     $dataArray = array(
                        //         'success' => false,
                        //         'message' => 'Fancy suspended!'
                        //     );
                        //     echo json_encode($dataArray);
                        //     exit;
                        // }

                        // if (!empty($fancy_data)) {
                        // }



                        // $sportBlockMarket = $this->Block_market_model->getBlockMarket(array(
                        //     'type' => 'Sport',
                        //     'event_type_id' => $event_type
                        // ));


                        // if (!empty($sportBlockMarket)) {
                        //     foreach ($sportBlockMarket as $block) {
                        //         if (in_array($block['user_id'], $superior)) {
                        //             $dataArray = array(
                        //                 'success' => false,
                        //                 'message' => 'Sport Blocked Bet not placed!'
                        //             );
                        //             echo json_encode($dataArray);
                        //             exit;
                        //         }
                        //     }
                        // }



                        // $eventBlockMarket = $this->Block_market_model->getBlockMarket(array(
                        //     'type' => 'Event',
                        //     'event_id' => $matchId
                        // ));

                        // if (!empty($eventBlockMarket)) {
                        //     foreach ($eventBlockMarket as $block) {
                        //         if (in_array($block['user_id'], $superior)) {
                        //             $dataArray = array(
                        //                 'success' => false,
                        //                 'message' => 'Event Blocked Bet not placed!'
                        //             );
                        //             echo json_encode($dataArray);
                        //             exit;
                        //         }
                        //     }
                        // }



                        // $allFancyBlockMarket = $this->Block_market_model->getBlockMarket(array(
                        //     'type' => 'AllFancy',
                        //     'event_id' => $matchId
                        // ));

                        // if (!empty($allFancyBlockMarket)) {
                        //     foreach ($allFancyBlockMarket as $block) {
                        //         if (in_array($block['user_id'], $superior)) {
                        //             $dataArray = array(
                        //                 'success' => false,
                        //                 'message' => 'Fancy Blocked Bet not placed!'
                        //             );
                        //             echo json_encode($dataArray);
                        //             exit;
                        //         }
                        //     }
                        // }


                        // $fancyBlockMarket = $this->Block_market_model->getBlockMarket(array(
                        //     'type' => 'Fancy',
                        //     'fancy_id' => $this->input->post('selectionId'),
                        // ));


                        // if (!empty($fancyBlockMarket)) {

                        //     foreach ($fancyBlockMarket as $block) {
                        //         if (in_array($block['user_id'], $superior)) {
                        //             $dataArray = array(
                        //                 'success' => false,
                        //                 'message' => 'Fancy Blocked Bet not placed!'
                        //             );
                        //             echo json_encode($dataArray);
                        //             exit;
                        //         }
                        //     }
                        // }
                    } else if ($betting_type == 'Match') {




                        if ($market_detail->market_name != 'Bookmaker') {
                            if ($user_info->is_odds_active == 'No') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Match Odds Locked!'
                                );
                                echo json_encode($dataArray);
                                exit;
                            }
                        }


                        // if($market_detail->market_name == 'Bookmaker')
                        // {
                        //     $price_val = ($price_val/ 100) + 1;

                        //     $p_l = (round($price_val * $stake) - $stake);
                        //     $profit = (round($price_val * $stake) - $stake);
                        //     $loss = ($stake);
                        // }


                        if ($market_odds_detail->inplay == 1) {
                            if ($user_info->min_stake > $stake) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Min Stake allowed is: ' . $user_info->min_stake
                                );
                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($user_info->max_stake < $stake) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Max Stake allowed is: ' . $user_info->max_stake
                                );
                                echo json_encode($dataArray);
                                exit;
                            }



                            if ($user_info->max_profit <  $max_profit) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Max Profit allowed is: ' . $user_info->max_profit
                                );
                                echo json_encode($dataArray);
                                exit;
                            }


                            // if ($user_info->max_loss <  abs($max_loss)) {
                            //     $dataArray = array(
                            //         'success' => false,
                            //         'message' => 'Max Loss allowed is: ' . abs($user_info->max_loss)
                            //     );

                            //     echo json_encode($dataArray);
                            //     exit;
                            // }

                            if ($user_info->lock_bet ==  "Yes") {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Betting Rights is locked'
                                );

                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($user_info->min_odds > $price_val) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Minimum odds allowed is : ' . $user_info->min_odds
                                );

                                echo json_encode($dataArray);
                                exit;
                            }


                            if ($user_info->max_odds < $price_val) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Maximum odds allowed is : ' . $user_info->max_odds
                                );

                                echo json_encode($dataArray);
                                exit;
                            }


                            if (empty($market_odds_detail_tmp)) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Something went wrong Market not matched'
                                );

                                echo json_encode($dataArray);
                                exit;
                            }


                            if (!empty($market_odds_detail_tmp)) {
                                if ($market_odds_detail_tmp['status'] != 'OPEN') {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Something went wrong Bet Not placed'
                                    );

                                    echo json_encode($dataArray);
                                    exit;
                                }
                            }


                            $sportBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Sport',
                                'event_type_id' => $event_type
                            ));



                            if (!empty($sportBlockMarket)) {
                                $master_id = $sportBlockMarket[0]['user_id'];

                                foreach ($sportBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Sport Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }



                            $marketBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Market',
                                'market_id' => $MarketId
                            ));


                            if (!empty($marketBlockMarket)) {
                                $master_id = $sportBlockMarket[0]['user_id'];

                                foreach ($marketBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Market Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }




                            $eventBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Event',
                                'event_id' => $matchId
                            ));

                            if (!empty($eventBlockMarket)) {
                                $master_id = $eventBlockMarket[0]['user_id'];

                                foreach ($eventBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Event Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }
                        } else if ($market_odds_detail->inplay == 0) {


                            if ($market_detail->market_name == 'Bookmaker') {

                                // p()

                                if ($user_info->pre_inplay_stake < $stake) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Pre Inplay Stake allowed is: ' . $user_info->pre_inplay_stake
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }


                                if ($user_info->pre_inplay_profit <  $max_profit) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Pre Inplay Profit allowed is: ' . $user_info->pre_inplay_profit
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }


                                if ($user_info->max_profit <  $max_profit) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Profit allowed is: ' . $user_info->max_profit
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }


                                // if ($user_info->max_loss <  abs($max_loss)) {
                                //     $dataArray = array(
                                //         'success' => false,
                                //         'message' => 'Max Loss allowed is: ' . abs($user_info->max_loss)
                                //     );

                                //     echo json_encode($dataArray);
                                //     exit;
                                // }
                            } else {
                                if ($user_info->pre_inplay_stake < $stake) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Pre Inplay Stake allowed is: ' . $user_info->pre_inplay_stake
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }

                                if ($user_info->pre_inplay_profit <  $max_profit) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Pre Inplay Profit allowed is: ' . $user_info->pre_inplay_profit
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }


                                if ($user_info->max_profit <  $max_profit) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Max Profit allowed is: ' . $user_info->max_profit
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }

                                // if ($user_info->max_loss <  abs($max_loss)) {
                                //     $dataArray = array(
                                //         'success' => false,
                                //         'message' => 'Max Loss allowed is: ' . abs($user_info->max_loss)
                                //     );

                                //     echo json_encode($dataArray);
                                //     exit;
                                // }
                            }




                            if ($user_info->lock_bet ==  "Yes") {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Betting Rights is locked'
                                );

                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($user_info->min_odds > $price_val) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Minimum odds allowed is : ' . $user_info->min_odds
                                );

                                echo json_encode($dataArray);
                                exit;
                            }

                            if ($user_info->max_odds < $price_val) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Maximum odds allowed is : ' . $user_info->max_odds
                                );

                                echo json_encode($dataArray);
                                exit;
                            }

                            if (empty($market_odds_detail_tmp)) {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Something went wrong Market not matched'
                                );

                                echo json_encode($dataArray);
                                exit;
                            }


                            if (!empty($market_odds_detail_tmp)) {
                                if ($market_odds_detail_tmp['status'] != 'OPEN') {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Something went wrong Bet Not placed'
                                    );

                                    echo json_encode($dataArray);
                                    exit;
                                }
                            }


                            $sportBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Sport',
                                'event_type_id' => $event_type
                            ));



                            if (!empty($sportBlockMarket)) {
                                $master_id = $sportBlockMarket[0]['user_id'];

                                foreach ($sportBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Sport Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }



                            $marketBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Market',
                                'market_id' => $MarketId
                            ));


                            if (!empty($marketBlockMarket)) {
                                $master_id = $sportBlockMarket[0]['user_id'];

                                foreach ($marketBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Market Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }




                            $eventBlockMarket = $this->Block_market_model->getBlockMarket(array(
                                'type' => 'Event',
                                'event_id' => $matchId
                            ));

                            if (!empty($eventBlockMarket)) {
                                $master_id = $eventBlockMarket[0]['user_id'];

                                foreach ($eventBlockMarket as $block) {
                                    if (in_array($block['user_id'], $superior)) {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Event Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }
                        }
                    }






                    if ($betting_type == 'Match') {
                        $data1 = array(
                            'market_id' => $this->input->post('MarketId'),
                            'event_id' => $this->input->post('matchId'),
                            'selection_id' => $selection_id
                        );

                        $is_back = $this->input->post('isback');

                        if ($is_back == 1) {
                            $data2 = array(
                                'back_1_price' => (float) $price_val,
                                'back_2_price' => (float) $price_val,
                                'back_3_price' => (float) $price_val,
                            );
                        } else {
                            $data2 = array(
                                'lay_1_price' => (float) $price_val,
                                'lay_2_price' => (float) $price_val,
                                'lay_3_price' => (float) $price_val,
                            );
                        }

                        // $check_current_odds = check_current_odds($data1, $data2);

                        $check_current_odds = (object) get_match_odds($data1);
                        // $check_current_odds = $this->Event_model->check_active_odds($data1);




                        if (empty($check_current_odds)) {

                            $check_current_odds = $this->Manual_model->check_active_odds($data1);
                        }


                        if ($check_current_odds->status != 'ACTIVE' && $check_current_odds->status != 'OPEN') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Market Suspended'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }

                        if (!empty($check_current_odds)) {

                            if ($market_detail->market_name == 'Bookmaker') {
                                $p_l = (($price_val * $stake) - $stake);
                                $profit = (($price_val * $stake) - $stake);
                                $loss = ($stake);


                                $back_price = ($check_current_odds->back_1_price / 100) + 1;
                                $lay_price =  ($check_current_odds->lay_1_price / 100) + 1;
                            } else {
                                $back_price = $check_current_odds->back_1_price;
                                $lay_price = $check_current_odds->lay_1_price;
                            }
                            if ($is_back) {
                                //    if(get_user_id() )
                                if ($price_val > $back_price) {
                                    if ($market_detail->market_name != 'Toss') {

                                        $unmatch_bet = 'Yes';
                                        // $dataArray = array(
                                        //     'success' => false,
                                        //     'message' => 'Unmatched Bet not allowed'
                                        // );
                                        // echo json_encode($dataArray);
                                        // exit;
                                    } else {
                                        $price_val = 1.97;
                                    }
                                } else  if ($back_price >= $price_val) {
                                    if ($market_detail->market_name != 'Toss') {

                                        $price_val = $back_price;

                                        $p_l = (($price_val * $stake) - $stake);
                                        $profit = (($price_val * $stake) - $stake);
                                        $loss = ($stake);
                                    } else {
                                        $price_val = 1.97;

                                        $p_l = (($price_val * $stake) - $stake);
                                        $profit = (($price_val * $stake) - $stake);
                                        $loss = ($stake);
                                    }
                                }
                            }


                            // p($lay_price);
                            if ($is_back == 0) {
                                // $price_val = $lay_price;


                                if ($price_val < $lay_price) {
                                    // if ($market_detail->market_name != 'Bookmaker') {
                                    $unmatch_bet = 'Yes';
                                    // $dataArray = array(
                                    //     'success' => false,
                                    //     'message' => 'Unmatched Bet not allowed'
                                    // );
                                    // echo json_encode($dataArray);
                                    // exit;
                                    // }
                                    // $price_val = $lay_price;
                                } else {
                                    // if ($market_detail->market_name != 'Bookmaker') {
                                    $price_val = $lay_price;


                                    $p_l = (($price_val * $stake) - $stake);
                                    $profit = $stake;
                                    $loss = (($price_val * $stake) - $stake);
                                    // }
                                }
                            }
                        }




                        if (!empty($check_current_odds)) {
                        } else {
                            $unmatch_bet = 'Yes';
                            // if ($market_detail->market_name != 'Bookmaker') {
                            if ($user_info->unmatch_bet == 'No') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Unmatched Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;

                                $unmatch_bet = 'Yes';
                            }
                            // }
                        }
                    } else {
                    }
                }


                if (empty($price_val)) {
                    $dataArray = array(
                        'success' => false,
                        'message' => 'Invalid stake/odds.'
                    );
                    echo json_encode($dataArray);
                    exit;
                }

                if ($price_val <= 0) {
                    $dataArray = array(
                        'success' => false,
                        'message' => 'Invalid stake/odds.'
                    );
                    echo json_encode($dataArray);
                    exit;
                }


                // if ($market_detail->market_name == 'Bookmaker') {

                //     $price_val = ($price_val / 100) + 1;

                //     $p_l = (round($price_val * $stake) - $stake);
                //     $profit = (round($price_val * $stake) - $stake);
                //     $loss = ($stake);
                // }

                // $dataArray = array(
                //     'success' => false,
                //     'message' => $price_val
                // );

                // echo json_encode($dataArray);
                // exit;


                if ($betting_type == 'Fancy') {

                    $fancy_odds = get_fancy_odds(array(
                        'match_id' => $this->input->post('matchId'),
                        'selection_id' => $this->input->post('selectionId')
                    ));


                    if (empty($fancy_odds)) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Fancy Suspended Bet not allowed'
                        );
                        echo json_encode($dataArray);
                        exit;
                    } else {


                        if ($fancy_odds['game_status'] == 'SUSPENDED') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Fancy Suspended Bet not allowed'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }


                        if ($fancy_odds['game_status'] == 'Ball Running') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Fancy Ball Running Bet not allowed'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }

                        if ($fancy_odds['lay_price1'] == '0.00' && $fancy_odds['back_price1'] == '0.00') {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Fancy Suspended Bet not allowed'
                            );
                            echo json_encode($dataArray);
                            exit;
                        }
                    }
                }


                $betting_type = $this->input->post('betting_type');


                log_message("MY_INFO",  get_user_id() . " ----- Match Bet Price " . $price_val);




                $dataArray = array(
                    'match_id' => $this->input->post('matchId'),
                    'selection_id' => $this->input->post('selectionId'),
                    'is_back' => $this->input->post('isback'),
                    'place_name' => $this->input->post('placeName'),
                    'stake' => $this->input->post('stake'),
                    'price_val' => $price_val,
                    'p_l' => $p_l,
                    'market_id' => $this->input->post('MarketId'),
                    'user_id' => $_SESSION['my_userdata']['user_id'],
                    'betting_type' => $this->input->post('betting_type'),
                    'profit' => $profit,
                    'loss' => $loss,
                    'exposure_1' => $this->input->post('exposure1'),
                    'exposure_2' => $this->input->post('exposure2'),
                    'ip_address' =>  $_SERVER['REMOTE_ADDR'],
                    'unmatch_bet' => $unmatch_bet,
                    'competition_id' => !empty($event_detail->competition_id) ? $event_detail->competition_id : 0,
                    'competition_name' => $event_detail->competition_name,
                    'event_name' => $event_detail->event_name,
                    'market_name' => $betting_type == 'Fancy' ? 'Fancy' : $market_detail->market_name,
                    'runner_name' =>  $betting_type == 'Fancy' ? $price_val : $runner_detail->runner_name,
                    'event_type' => $event_detail->event_type,
                    'fancy_size' => $fancy_size,
                );


                if ($_SESSION['my_userdata']['user_name'] == 'kbm17') {
                    // p($dataArray);
                }


                // p($dataArray,0);

                if ($unmatch_bet == 'Yes') {
                    if (!in_array($event_detail->event_type, [4, 2, 1])) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Unmatch Bet not allowed for this sport'
                        );
                        echo json_encode($dataArray);
                    }


                    if ($market_detail->market_name == 'Bookmaker') {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Unmatch Bet not allowed for Bookmaker'
                        );
                        echo json_encode($dataArray);
                    }
                }




                $betting_id =  $this->load->Betting_model->addBetting($dataArray);


                if ($betting_type == 'Fancy') {
                    log_message("MY_INFO", "Fancy Bet Place " . $betting_id);
                    log_message("MY_INFO", "FANCY ODDS" . json_encode($fancy_odds));
                } else {
                    log_message("MY_INFO",  get_user_id() . " ----- Match Bet Place " . $betting_id);
                }


                if ($betting_id) {

                    if ($unmatch_bet == 'Yes') {
                        $dataArray = array(
                            'success' => true,
                            'message' => 'Unmatch Bet Placed Successfully'
                        );
                        echo json_encode($dataArray);
                    } else {
                        $dataArray = array(
                            'success' => true,
                            'message' => 'Bet Placed Successfully'
                        );
                        echo json_encode($dataArray);
                    }
                }


                if ($betting_id) {
                    $data = array(
                        'user_id' => get_user_id(),
                        'is_balance_update' =>  'Yes',
                        'is_exposure_update' =>  'Yes',
                    );
                    $user_id = $this->User_model->addUser($data);
                }

                exit;

                /**************************Get All Superior and save betting time settings*******  */
                $userDetail = $this->User_model->getUserById($user_id);
                $master_id = get_master_id();
                $masterDetail = $this->User_model->getUserById($master_id);
                $super_master_id = $masterDetail->master_id;
                $superMasterDetail = $this->User_model->getUserById($super_master_id);
                $hyper_super_master_id = $superMasterDetail->master_id;
                $hyperSuperMasterDetail = $this->User_model->getUserById($hyper_super_master_id);

                $admin_id = $hyperSuperMasterDetail->master_id;
                $adminDetail = $this->User_model->getUserById($admin_id);

                $super_admin_id = $adminDetail->master_id;
                $superAdminDetail = $this->User_model->getUserById($super_admin_id);

                if (!empty($userDetail)) {

                    /*************Users**************** */
                    $bettingSettingData = array(
                        'user_id' => $user_id,
                        'betting_id' => $betting_id,
                        'casino_partnership' => $userDetail->casino_partnership,
                        'partnership' => $userDetail->partnership,
                        'teenpati_partnership' => $userDetail->teenpati_partnership,
                        'master_commission' => $userDetail->master_commision,
                        'sessional_commission' => $userDetail->sessional_commision,
                        'user_type' => $userDetail->user_type,
                        'created_at' => date('Y-m-d H:i:s'),
                        'profit' => $profit,
                        'loss' => $loss,
                    );
                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);

                    /*************Users**************** */


                    if (!empty($setting_id)) {
                        /*************Masters**************** */
                        if (!empty($masterDetail)) {

                            $tmp_profit =  ($loss) * ($masterDetail->partnership / 100);
                            $tmp_loss =  ($profit) * ($masterDetail->partnership / 100);


                            $bettingSettingData = array(
                                'user_id' => $master_id,
                                'betting_id' => $betting_id,
                                'casino_partnership' => $masterDetail->casino_partnership,
                                'partnership' => $masterDetail->partnership,
                                'teenpati_partnership' => $masterDetail->teenpati_partnership,
                                'master_commission' => $masterDetail->master_commision,
                                'sessional_commission' => $masterDetail->sessional_commision,
                                'created_at' => date('Y-m-d H:i:s'),
                                'user_type' => $masterDetail->user_type,
                                'profit' => $tmp_profit,
                                'loss' => $tmp_loss,

                            );
                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);

                            /*************Masters**************** */

                            /*************Super Master**************** */

                            if (!empty($setting_id)) {
                                $master_partnership = $masterDetail->partnership;
                                $super_partnership = $superMasterDetail->partnership;

                                $master_profit =  $loss * ($master_partnership / 100);
                                $super_profit = $loss * ($super_partnership / 100);
                                $tmp_profit =  $super_profit - $master_profit;

                                $master_loss = $profit * ($master_partnership / 100);
                                $super_loss = $profit * ($super_partnership / 100);
                                $tmp_loss = $super_loss - $master_loss;

                                if (!empty($superMasterDetail)) {
                                    $bettingSettingData = array(
                                        'user_id' => $super_master_id,
                                        'betting_id' => $betting_id,
                                        'casino_partnership' => $superMasterDetail->casino_partnership,
                                        'partnership' => $superMasterDetail->partnership,
                                        'teenpati_partnership' => $superMasterDetail->teenpati_partnership,
                                        'master_commission' => $superMasterDetail->master_commision,
                                        'sessional_commission' => $superMasterDetail->sessional_commision,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'user_type' => $superMasterDetail->user_type,
                                        'profit' => $tmp_profit,
                                        'loss' => $tmp_loss,
                                    );
                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                    /*************Super Master**************** */

                                    /*************Hyper Super Master**************** */

                                    if (!empty($setting_id)) {

                                        if (!empty($hyperSuperMasterDetail)) {
                                            $master_partnership = $superMasterDetail->partnership;
                                            $super_partnership = $hyperSuperMasterDetail->partnership;

                                            $master_profit =  $loss * ($master_partnership / 100);
                                            $super_profit = $loss * ($super_partnership / 100);
                                            $tmp_profit =  $super_profit - $master_profit;

                                            $master_loss = $profit * ($master_partnership / 100);
                                            $super_loss = $profit * ($super_partnership / 100);
                                            $tmp_loss = $super_loss - $master_loss;
                                            $bettingSettingData = array(
                                                'user_id' => $hyper_super_master_id,
                                                'betting_id' => $betting_id,
                                                'casino_partnership' => $hyperSuperMasterDetail->casino_partnership,
                                                'partnership' => $hyperSuperMasterDetail->partnership,
                                                'teenpati_partnership' => $hyperSuperMasterDetail->teenpati_partnership,
                                                'master_commission' => $hyperSuperMasterDetail->master_commision,
                                                'sessional_commission' => $hyperSuperMasterDetail->sessional_commision,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'user_type' => $hyperSuperMasterDetail->user_type,
                                                'profit' => $tmp_profit,
                                                'loss' => $tmp_loss,

                                            );
                                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                            /*************Hyper Super Master**************** */

                                            /*************Admnin**************** */
                                            if (!empty($setting_id)) {

                                                if (!empty($adminDetail)) {

                                                    $master_partnership = $hyperSuperMasterDetail->partnership;
                                                    $super_partnership = $adminDetail->partnership;

                                                    $master_profit =  $loss * ($master_partnership / 100);
                                                    $super_profit = $loss * ($super_partnership / 100);
                                                    $tmp_profit =  $super_profit - $master_profit;

                                                    $master_loss = $profit * ($master_partnership / 100);
                                                    $super_loss = $profit * ($super_partnership / 100);
                                                    $tmp_loss = $super_loss - $master_loss;
                                                    $bettingSettingData = array(
                                                        'user_id' => $admin_id,
                                                        'betting_id' => $betting_id,
                                                        'casino_partnership' => $adminDetail->casino_partnership,
                                                        'partnership' => $adminDetail->partnership,
                                                        'teenpati_partnership' => $adminDetail->teenpati_partnership,
                                                        'master_commission' => $adminDetail->master_commision,
                                                        'sessional_commission' => $adminDetail->sessional_commision,
                                                        'created_at' => date('Y-m-d H:i:s'),
                                                        'user_type' => $adminDetail->user_type,
                                                        'profit' => $tmp_profit,
                                                        'loss' => $tmp_loss,
                                                    );
                                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                                    /*************Admnin**************** */

                                                    /*************Super Admin**************** */

                                                    if (!empty($setting_id)) {

                                                        if (!empty($adminDetail)) {

                                                            $master_partnership = $adminDetail->partnership;
                                                            $super_partnership = $superAdminDetail->partnership;

                                                            $master_profit =  $loss * ($master_partnership / 100);
                                                            $super_profit = $loss * ($super_partnership / 100);
                                                            $tmp_profit =  $super_profit - $master_profit;

                                                            $master_loss = $profit * ($master_partnership / 100);
                                                            $super_loss = $profit * ($super_partnership / 100);
                                                            $tmp_loss = $super_loss - $master_loss;
                                                            $bettingSettingData = array(
                                                                'user_id' => $super_admin_id,
                                                                'betting_id' => $betting_id,
                                                                'casino_partnership' => $superAdminDetail->casino_partnership,
                                                                'partnership' => $superAdminDetail->partnership,
                                                                'teenpati_partnership' => $superAdminDetail->teenpati_partnership,
                                                                'master_commission' => $superAdminDetail->master_commision,
                                                                'sessional_commission' => $superAdminDetail->sessional_commision,
                                                                'created_at' => date('Y-m-d H:i:s'),
                                                                'user_type' => $superAdminDetail->user_type,
                                                                'profit' => $tmp_profit,
                                                                'loss' => $tmp_loss,

                                                            );
                                                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                                        }
                                                    }
                                                    /*************Super Admin**************** */
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            /**************************Get All Superior and save betting time settings*******  */

            log_message("MY_INFO", "Bet Place End");
        }

        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function getfancydata1()
    {
        $fancy_data = get_fancy_by_id();
        $marketId = '1.172980694';

        $dataValues = array(
            'market_id' => $marketId,
            'response' => $fancy_data
        );

        $this->Fancy_data_model->addFancyData($dataValues);
    }

    public function getfancydata($bfid = null)
    {
        if ($bfid === null) {
            $bfid = 1.172980694;
        }

        $dataValues = array(
            'market_id' => $bfid
        );


        $fancyData = $this->Fancy_data_model->get_fancy_data($dataValues);

        $html = '';
        if (!empty($fancyData->response)) {
            $fancyData =  json_decode($fancyData->response);


            $dataArray['fancyData'] = $fancyData->LambiData;
            $html .= $this->load->viewPartial('fancy-list-html', $dataArray);
        }

        // echo $html;
        echo json_encode(array('fancyData' => $html));
    }

    //API Calling in 2 days
    public function addEventTypes()
    {

        $event_types =  json_decode(listEventTypes());
        if (!empty($event_types)) {
            foreach ($event_types as $event_type) {
                if ($event_type->eventType == 4 ||  $event_type->eventType == 1 ||  $event_type->eventType == 2) {
                    $dataArray = array(
                        'event_type' => $event_type->eventType,
                        'name' => $event_type->name,
                        'market_count' => $event_type->marketCount,
                    );

                    $this->Event_model->addEventType($dataArray);
                }
            }
        }
        return true;
    }

    public function getEventTypes()
    {
        return listEventTypes();
    }

    //API Calling in 2 days
    public function addCompetition()
    {

        log_message("MY_INFO", "ADD COMPETITION START");
        // return true;

        $event_types = $this->Event_model->getEventTypes();


        if (!empty($event_types)) {
            foreach ($event_types as $event_type) {
                if ($event_type['event_type'] == 4 || $event_type['event_type'] == 1 || $event_type['event_type'] == 2) {
                    // p($event_type);
                    $competitions = json_decode(listCompetitions($event_type['event_type']));

                    if (!empty($competitions)) {
                        foreach ($competitions as $competition) {
                            $dataArray = array(
                                'event_type' => $event_type['event_type'],
                                'competition_id' => $competition->competition->id,
                                'competition_name' => $competition->competition->name,
                                'market_count' => $competition->marketCount,
                                'competition_region' => $competition->competitionRegion,
                            );

                            $this->Event_model->addCompetition($dataArray);
                        }
                    }
                }
            }
        }
        log_message("MY_INFO", "ADD COMPETITION END");
        log_message("MY_INFO", "*******************");

        return true;
    }

    //API Calling in 1 days

    public function addEvents()
    {
        log_message("MY_INFO", "ADD EVENTS start");
        $competitions = $this->Event_model->getCompetitions();

        if (!empty($competitions)) {
            $countSoccer = 0;
            $countTennis = 0;


            foreach ($competitions as $competition) {
                // if ($competition['event_type'] == 4 || $competition['event_type'] == 4) {
                $events = json_decode(listEvents($competition['event_type'], $competition['competition_id']));


                if (!empty($events)) {
                    foreach ($events as $event) {

                        if ($event->event->id == '-1006') {
                            continue;
                        }



                        if ($competition['event_type'] == 2) {
                            if ($countTennis >= 15) {
                                continue;
                            }
                            $countTennis++;
                        }


                        if ($competition['event_type'] == 1) {
                            if ($countSoccer >= 15) {
                                continue;
                            }
                            $countSoccer++;
                        }


                        $dataArray = array(
                            'competition_id' => $competition['competition_id'],
                            'event_type' => $competition['event_type'],
                            'event_id' => $event->event->id,
                            'event_name' => $event->event->name,
                            'country_code' => $event->event->countryCode,
                            'timezone' => $event->event->timezone,
                            'open_date' => $event->event->openDate,
                            'market_count' => $event->marketCount,
                            'scoreboard_id' => $event->scoreboard_id,
                            'selections' => $event->selections,
                            'liability_type' => $event->liability_type,
                            'undeclared_markets' => $event->undeclared_markets,
                            'is_active' => 'Yes'
                        );
                        $this->Event_model->addEvents($dataArray);
                    }
                }
                // }
            }
        }

        log_message("MY_INFO", "ADD EVENT END");
        log_message("MY_INFO", "*******************");
        return true;
    }

    public function addMarketTypes($sport_id = null)
    {
        log_message("MY_INFO", "ADD MARKET TYPE START");
        $events = $this->Event_model->getEvents();
        if (!empty($events)) {
            $i = 0;
            foreach ($events as $event) {


                $date = new DateTime($event['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));


                $diff = $date2->getTimestamp() - $date->getTimestamp();


                if ($diff < 720) {

                    echo $i++;
                    $listMarketTypes = json_decode(listMarketTypes($event['event_id']));


                    if (!empty($listMarketTypes)) {

                        foreach ($listMarketTypes as $market) {

                            $dataArray = array(
                                'event_id' => $event['event_id'],
                                'market_name' => $market->marketName,
                                'market_id' => $market->marketId,
                                'market_start_time' => $market->marketStartTime,
                                'total_matched' => $market->totalMatched,
                                'runner_1_selection_id' => $market->runners[0]->selectionId,
                                'runner_1_runner_name' => $market->runners[0]->runnerName,
                                'runner_1_handicap' => $market->runners[0]->handicap,
                                'runner_1_sort_priority' => $market->runners[0]->sortPriority,
                                'runner_2_selection_id' => $market->runners[1]->selectionId,
                                'runner_2_runner_name' => $market->runners[1]->runnerName,
                                'runner_2_handicap' => $market->runners[1]->handicap,
                                'runner_2_sort_priority' => $market->runners[1]->sortPriority,
                            );

                            // p($dataArray, 0);

                            $this->Event_model->addMarketTypes($dataArray);
                        }
                    }
                }

                // echo $event['event_id']."<br/>";
                // if($event['event_id'] == '30214472')
                // {
                //     p($listMarketTypes);
                // }

            }
        }

        $this->listBookmakerMarket();
        log_message("MY_INFO", "ADD MARKET TYPE END");
        log_message("MY_INFO", "*******************");
        return true;
    }


    public function addMarketBookOdds($sport_id = null)
    {
        log_message("MY_INFO", "ADD MARKET BOOK ODDS START");
        $market_types = $this->Event_model->getMarketTypeIds();

        if (!empty($market_types)) {
            $market_ids = '';
            $event_ids = array();
            foreach ($market_types as $market_type) {

                $date = new DateTime($market_type['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));


                $diff = $date2->getTimestamp() - $date->getTimestamp();

                if ($diff < 320) {
                    $market_ids .= $market_type['market_id'] . ',';
                    $market_id = str_replace('.', '_', $market_type['market_id']);
                    $event_ids[$market_id] = array('event_id' => $market_type['event_id']);
                }
            }

            $market_ids = rtrim($market_ids, ',');


            $market_ids = explode(',', $market_ids);

            $lenght = 30;

            $totalLength = sizeof($market_ids);

            $totalRequest = ceil($totalLength / $lenght);


            $j = 1;
            for ($i = 0; $i < $totalRequest; $i++) {
                $marketid_reqs = array_slice($market_ids, $i * $lenght, $lenght);

                $j++;
                $marketid_reqs = implode(',', $marketid_reqs);
                // p($marketid_reqs);
                $listMarketBookOdds = json_decode(listMarketBookOdds($marketid_reqs));





                if (!empty($listMarketBookOdds)) {
                    foreach ($listMarketBookOdds as $listMarketBookOdd) {

                        $listMarketRunners = json_decode(listMarketRunners($listMarketBookOdd->marketId));



                        $runnersArr =  $listMarketRunners[0]->runners;


                        $marketId = str_replace('.', '_', $listMarketBookOdd->marketId);
                        $event_id = $event_ids[$marketId]['event_id'];
                        $dataArray = array(
                            'market_id' => $listMarketBookOdd->marketId,
                            'event_id' =>  $event_id,

                            'is_market_data_delayed' => $listMarketBookOdd->isMarketDataDelayed,
                            'status' => $listMarketBookOdd->status,
                            'bet_delay' => $listMarketBookOdd->betDelay,
                            'bsp_reconciled' => $listMarketBookOdd->bspReconciled,
                            'complete' => $listMarketBookOdd->complete,
                            'inplay' => $listMarketBookOdd->inplay,
                            'number_of_winners' => $listMarketBookOdd->numberOfWinners,
                            'number_of_runners' => $listMarketBookOdd->numberOfRunners,
                            'number_of_active_runners' => $listMarketBookOdd->numberOfActiveRunners,
                            'last_match_time' => $listMarketBookOdd->lastMatchTime,
                            'total_matched' => $listMarketBookOdd->totalMatched,
                            'total_available' => $listMarketBookOdd->totalAvailable,
                            'cross_matching' => $listMarketBookOdd->crossMatching,
                            'runners_voidable' => $listMarketBookOdd->runnersVoidable,
                            'version' => $listMarketBookOdd->version,

                        );


                        $market_book_odd_id =  $this->Event_model->addMarketBookOdds($dataArray);

                        if ($market_book_odd_id) {
                            if (!empty($listMarketBookOdd->runners)) {
                                foreach ($listMarketBookOdd->runners as $runner) {

                                    foreach ($runnersArr as $runnerArr) {
                                        if ($runner->selectionId == $runnerArr->selectionId) {
                                            $dataArray = array(
                                                'market_book_odd_id' => $market_book_odd_id,
                                                'market_id' => $listMarketBookOdd->marketId,
                                                'event_id' => $event_id,
                                                'selection_id' => $runner->selectionId,
                                                'runner_name' => $runnerArr->runnerName,
                                                'sort_priority' => $runnerArr->sortPriority,

                                                'handicap' => $runner->handicap,
                                                'status' => $runner->status,
                                                'last_price_traded' => $runner->lastPriceTraded,
                                                'total_matched' => $runner->totalMatched,
                                                'back_1_price' => isset($runner->ex->availableToBack[0]->price) ? $runner->ex->availableToBack[0]->price : '',
                                                'back_2_price' => isset($runner->ex->availableToBack[1]->price) ? $runner->ex->availableToBack[1]->price : '',
                                                'back_3_price' => isset($runner->ex->availableToBack[2]->price) ? $runner->ex->availableToBack[2]->price : '',
                                                'back_1_size' => isset($runner->ex->availableToBack[0]->size) ? $runner->ex->availableToBack[0]->size : '',
                                                'back_2_size' => isset($runner->ex->availableToBack[1]->size) ? $runner->ex->availableToBack[1]->size : '',
                                                'back_3_size' => isset($runner->ex->availableToBack[2]->size) ? $runner->ex->availableToBack[2]->size : '',
                                                'lay_1_price' => isset($runner->ex->availableToLay[0]->price) ? $runner->ex->availableToLay[0]->price : '',
                                                'lay_2_price' => isset($runner->ex->availableToLay[1]->price) ? $runner->ex->availableToLay[1]->price : '',
                                                'lay_3_price' => isset($runner->ex->availableToLay[2]->price) ? $runner->ex->availableToLay[2]->price : '',
                                                'lay_1_size' => isset($runner->ex->availableToLay[0]->size) ? $runner->ex->availableToLay[0]->size : '',
                                                'lay_2_size' => isset($runner->ex->availableToLay[1]->size) ? $runner->ex->availableToLay[1]->size : '',
                                                'lay_3_size' => isset($runner->ex->availableToLay[2]->size) ? $runner->ex->availableToLay[2]->size : '',
                                            );


                                            $this->Event_model->addMarketBookOddsRunners($dataArray);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        // 
        $this->addBookmakerMarketOdds();
        log_message("MY_INFO", "ADD MARKET BOOK ODDS END");
        log_message("MY_INFO", "*******************");
        return true;
    }

    public function addMarketBookSession($match_id = null)
    {
        log_message("MY_INFO", "ADD MARKET BOOK SESSION START");
        $market_types = $this->Event_model->getMarketTypeIds();
        $events = $this->Event_model->getEvents();

        $i = 0;
        if (!empty($events)) {
            foreach ($events as $event) {

                $date = new DateTime($event['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));


                $diff = $date2->getTimestamp() - $date->getTimestamp();


                if ($diff < 740) {

                    $listMarketBookSession = json_decode(listMarketBookSession($event['event_id']));

                    if (!empty($listMarketBookSession)) {

                        if (!isset($listMarketBookSession->message)) {
                            foreach ($listMarketBookSession as $session) {

                                $super_admin_id = getCustomConfigItem('super_admin_id');
                                $block_market = get_super_admin_pre_block_markets(array('user_id' => $super_admin_id, 'type' => 'PreBlockFancy', 'event_id' => $event['event_id']));

                                if (!empty($block_market)) {

                                    $dataArray2 = array(
                                        'user_id' => $block_market['user_id'],
                                        'event_id' =>  $block_market['event_id'],
                                        'market_id' => 0,
                                        'event_type_id' => $block_market['event_id'],
                                        'fancy_id' => $session->SelectionId,
                                        'type' => 'Fancy'
                                    );

                                    $alreadyExists1 =  $this->Block_market_model->checkFancyBlockMarketAllowExists($dataArray2);

                                    if (empty($alreadyExists1)) {
                                        $dataArray = array(
                                            'user_id' => $block_market['user_id'],
                                            'event_id' =>  $block_market['event_id'],
                                            'market_id' => 0,
                                            'event_type_id' => $block_market['event_id'],
                                            'fancy_id' => $session->SelectionId,
                                            'type' => 'Fancy'
                                        );


                                        $alreadyExists =  $this->Block_market_model->checkBlockMarketExists($dataArray);

                                        if (empty($alreadyExists)) {
                                            $block_market_id = $this->Block_market_model->addBlockMarket($dataArray);
                                        }
                                    }
                                }



                                $dataArray = array(
                                    'match_id' => $event['event_id'],
                                    'selection_id' => $session->SelectionId,
                                    'runner_name' => $session->RunnerName,
                                    'lay_price1' => $session->LayPrice1,
                                    'lay_size1' => $session->LaySize1,
                                    'back_price1' => $session->BackPrice1,
                                    'back_size1' => $session->BackSize1,
                                    'game_status' => $session->GameStatus,
                                    'mark_status' => $session->MarkStatus,
                                    'cron_disable' => 'No'

                                );
                                $this->Event_model->addMarketBookOddsFancy($dataArray);
                            }
                        }
                    }
                }
            }
        }
        log_message("MY_INFO", "ADD MARKET BOOK SESSION END");
        log_message("MY_INFO", "*******************");
        return true;
    }


    public function listEvents($EventTypeID = null, $CompetitionID = null)
    {
        return listEvents($EventTypeID, $CompetitionID);
    }

    public function listMarketTypes($EventID = null)
    {
        return listMarketTypes($EventID);
    }

    public function listMarketRunner($MarketID = null)
    {
        return listMarketRunner($MarketID);
    }

    public function listMarketBookOdds($market_id = null)
    {
        return listMarketBookOdds($market_id);
    }

    public function listMarketBookSession($match_id = null)
    {
        return listMarketBookSession($match_id);
    }

    public function getAllData()
    {

        $this->addMarketBookOdds();
        $list_events = $this->Event_model->getEvents();


        if (!empty($list_events)) {
            foreach ($list_events as $list_event) {

                $listMarketBookSession = json_decode(listMarketBookSession($list_event['event_id']));

                // p($listMarketBookSession,0);

                if (!empty($listMarketBookSession)) {
                    if (!isset($listMarketBookSession->message)) {

                        foreach ($listMarketBookSession as $session) {
                            if (isset($session->SelectionId) && isset($session->RunnerName) && isset($session->LayPrice1)) {

                                $sessionArray = array(
                                    'match_id' => $list_event['event_id'],
                                    'selection_id' => $session->SelectionId,
                                    'runner_name' => $session->RunnerName,
                                    'lay_price1' => $session->LayPrice1,
                                    'lay_size1' => $session->LaySize1,
                                    'back_price1' => $session->BackPrice1,
                                    'back_size1' => $session->BackSize1,
                                    'game_status' => $session->GameStatus,
                                    'mark_status' => $session->MarkStatus,
                                    'is_active' => 'Yes'
                                );

                                $this->Event_model->addMarketBookOddsFancy($sessionArray);
                            }
                        }



                        // $this->Event_model->addMarketBookOddsFancy($sessionArray);

                    }
                }
            }
        }
        $this->sendresponse();

        return true;
    }

    // public function getAllData()
    // {

    //     $this->addMarketBookOdds();
    //     $list_events = $this->Event_model->getEvents();


    //     if (!empty($list_events)) {
    //         foreach ($list_events as $list_event) {

    //             $listMarketBookSession = json_decode(listMarketBookSession($list_event['event_id']));

    //             // p($listMarketBookSession,0);

    //             if (!empty($listMarketBookSession)) {
    //                 if (!isset($listMarketBookSession->message)) {

    //                     foreach ($listMarketBookSession as $session) {
    //                         if (isset($session->SelectionId) && isset($session->RunnerName) && isset($session->LayPrice1)) {

    //                             $sessionArray = array(
    //                                 'match_id' => $list_event['event_id'],
    //                                 'selection_id' => $session->SelectionId,
    //                                 'runner_name' => $session->RunnerName,
    //                                 'lay_price1' => $session->LayPrice1,
    //                                 'lay_size1' => $session->LaySize1,
    //                                 'back_price1' => $session->BackPrice1,
    //                                 'back_size1' => $session->BackSize1,
    //                                 'game_status' => $session->GameStatus,
    //                                 'mark_status' => $session->MarkStatus,
    //                                 'is_active' => 'Yes'
    //                             );

    //                             $this->Event_model->addMarketBookOddsFancy($sessionArray);
    //                         }
    //                     }



    //                     // $this->Event_model->addMarketBookOddsFancy($sessionArray);

    //                 }
    //             }
    //         }
    //     }
    //     $this->sendresponse();

    //     return true;
    // }

    public function sendresponse()
    {
        $data = array();
        $list_events = $this->Event_model->list_events($data);
        $exchangeData = array();
        $fantacyData = array();
        if (!empty($list_events)) {


            foreach ($list_events as $key => $list_event) {

                $event_id = $list_event['event_id'];

                $exchangeData[$event_id] = $list_event;


                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));

                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {
                        $market_id = $market_type['market_id'];
                        $exchangeData[$event_id]['market_types'][$market_id] = $market_type;
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));
                        $exchangeData[$event_id]['market_types'][$market_id]['runner'] = $runners;
                    }
                }

                $fancy_data = $this->Event_model->get_fancy_data($list_event['event_id']);
                $fantacyData[$list_event['event_id']] =  $fancy_data;
            }
        }



        $postdata = json_encode($exchangeData);

        $url =  get_ws_endpoint();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);

        sendfancyresponse($fantacyData);
        print_r($result);
    }


    public function favouriteEvent()
    {
        $event_id = $this->input->post('event_id');
        $user_id = $_SESSION['my_userdata']['user_id'];

        $dataArray = array(
            'event_id' => $event_id,
            'user_id' => $user_id
        );

        $this->Favourite_event_model->addFavouriteEvent($dataArray);
    }

    public function check_exists()
    {
        $this->Event_model->check_exists(array());
    }
    public function getPosition()
    {
        $user_id = get_user_id();
        $fancy_id = $this->input->post('fancyid');
        $type_id = $this->input->post('typeid');
        $yes_val = $this->input->post('yesval');
        $no_val = $this->input->post('noval');
        $event_id = $this->input->post('event_id');



        if (get_user_type() == 'Master') {
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partnership = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);

            $userArray = array();

            foreach ($users as $user) {
                $userArray[] = $user->user_id;
            }

            $dataArray = array(
                'selection_id' => $fancy_id,
                'users' => $userArray,
                'match_id' => $event_id,

            );

            $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);

            $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
            $max_p = $max + 5;
            $min_p = $min - 5;

            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);


            $tmp_array = array();

            foreach ($bettings as $betting) {
                $price_val  = $betting->price_val;
                $stake  = $betting->stake;

                $profit  = $betting->profit;
                $loss  = $betting->loss;

                foreach ($scores as $score) {

                    if ($betting->is_back == 0) {


                        if (isset($tmp_array[$score])) {

                            if ($score >= $price_val) {
                                $loss_amt =  ($loss * 1) * $partnership / 100;

                                $total = $tmp_array[$score] + $loss_amt;

                                $tmp_array[$score] = $total;
                            } else {

                                $profit_amt =   ($profit * -1) * $partnership / 100;

                                $total = ($tmp_array[$score] + $profit_amt);
                                $tmp_array[$score] = $total;
                            }
                        } else {

                            if ($score >= $price_val) {
                                $tmp_array[$score] = ($loss * 1) * $partnership / 100;
                            } else {
                                $tmp_array[$score] = ($profit * -1) * $partnership / 100;
                            }
                        }
                    } else {

                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {

                                $profit_amt = ($profit * -1) * $partnership / 100;
                                $total = ($tmp_array[$score] + $profit_amt);
                                $tmp_array[$score] = $total;
                            } else {

                                $loss_amt = ($loss * 1) * $partnership / 100;

                                $total = ($tmp_array[$score] +  $loss_amt);
                                $tmp_array[$score] = $total;
                            }
                        } else {
                            if ($score < $price_val) {
                                $tmp_array[$score] = ($loss) * $partnership / 100;
                            } else {
                                $tmp_array[$score] = ($profit * -1) * $partnership / 100;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        } else if (get_user_type() == 'Super Master') {

            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partnership = $user->partnership;
            $masterUsers =  $this->User_model->getInnerUserById($user_id);
            $userArray = array();
            $partnerShipArray = array();


            if (!empty($masterUsers)) {
                foreach ($masterUsers as $masterUser) {
                    $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $userArray[] = $user->user_id;
                        }
                    }
                    $masterUserArray[] = $user->user_id;
                    $partnerShipArray[$user->user_id] = $user->partnership;
                }
            }


            $dataArray = array(
                'selection_id' => $fancy_id,
                'users' => $userArray,
                'match_id' => $event_id,

            );


            $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
            $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
            $max_p = $max + 5;
            $min_p = $min - 5;

            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

            $tmp_array = array();

            foreach ($bettings as $betting) {
                $user_id = get_user_id();
                $user =  $this->User_model->getUserById($betting->user_id);
                $masterUser =  $this->User_model->getUserById($user->master_id);

                $masterUserPartnership = $masterUser->partnership;


                $price_val  = $betting->price_val;
                $stake  = $betting->stake;
                $profit  = $betting->profit;
                $loss  = $betting->loss;

                foreach ($scores as $score) {

                    if ($betting->is_back == 0) {


                        if (isset($tmp_array[$score])) {


                            if ($score >= $price_val) {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);
                                $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $profit_amt =  ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {

                            if ($score >= $price_val) {

                                $total = ($loss * 1) * $partnership / 100;
                                $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    } else {
                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $profit_amt = ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);

                                $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {
                            if ($score < $price_val) {
                                $total = ($loss) * $partnership / 100;
                                $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        } else if (get_user_type() == 'Hyper Super Master') {

            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partnership = $user->partnership;
            $superMasterUsers =  $this->User_model->getInnerUserById($user_id);
            $userArray = array();
            $partnerShipArray = array();

            if (!empty($superMasterUsers)) {
                foreach ($superMasterUsers as $superMasterUser) {
                    $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                    if (!empty($masterUsers)) {
                        foreach ($masterUsers as $masterUser) {
                            $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $userArray[] = $user->user_id;
                                }
                            }
                            $masterUserArray[] = $user->user_id;
                            $partnerShipArray[$user->user_id] = $user->partnership;
                        }
                    }


                    $dataArray = array(
                        'selection_id' => $fancy_id,
                        'users' => $userArray,
                        'match_id' => $event_id,

                    );
                }
            }




            $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
            $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
            $max_p = $max + 5;
            $min_p = $min - 5;

            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

            $tmp_array = array();

            foreach ($bettings as $betting) {
                $user_id = get_user_id();
                $user =  $this->User_model->getUserById($betting->user_id);
                $masterUser =  $this->User_model->getUserById($user->master_id);
                $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);

                $masterUserPartnership = $superMasterUser->partnership;


                $price_val  = $betting->price_val;
                $stake  = $betting->stake;
                $profit  = $betting->profit;
                $loss  = $betting->loss;


                foreach ($scores as $score) {

                    if ($betting->is_back == 0) {


                        if (isset($tmp_array[$score])) {


                            if ($score >= $price_val) {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);
                                $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $profit_amt =  ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {

                            if ($score >= $price_val) {

                                $total = ($loss * 1) * $partnership / 100;
                                $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    } else {
                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $profit_amt = ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);

                                $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {
                            if ($score < $price_val) {
                                $total = ($loss) * $partnership / 100;
                                $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        } else if (get_user_type() == 'Admin') {

            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partnership = $user->partnership;
            $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($user_id);
            $userArray = array();
            $partnerShipArray = array();

            if (!empty($hyperSuperMasterUsers)) {
                foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
                    $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

                    if (!empty($superMasterUsers)) {
                        foreach ($superMasterUsers as $superMasterUser) {
                            $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $userArray[] = $user->user_id;
                                        }
                                    }
                                    $masterUserArray[] = $user->user_id;
                                    $partnerShipArray[$user->user_id] = $user->partnership;
                                }
                            }


                            $dataArray = array(
                                'selection_id' => $fancy_id,
                                'users' => $userArray,
                                'match_id' => $event_id,

                            );
                        }
                    }
                }
            }




            $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
            $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
            $max_p = $max + 5;
            $min_p = $min - 5;

            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

            $tmp_array = array();

            foreach ($bettings as $betting) {
                $user_id = get_user_id();
                $user =  $this->User_model->getUserById($betting->user_id);
                $masterUser =  $this->User_model->getUserById($user->master_id);
                $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
                $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);


                $masterUserPartnership = $hyperSuperMasterUser->partnership;


                $price_val  = $betting->price_val;
                $stake  = $betting->stake;
                $profit  = $betting->profit;
                $loss  = $betting->loss;


                foreach ($scores as $score) {

                    if ($betting->is_back == 0) {


                        if (isset($tmp_array[$score])) {


                            if ($score >= $price_val) {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);
                                $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $profit_amt =  ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {

                            if ($score >= $price_val) {

                                $total = ($loss * 1) * $partnership / 100;
                                $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    } else {
                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $profit_amt = ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);

                                $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {
                            if ($score < $price_val) {
                                $total = ($loss) * $partnership / 100;
                                $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        } else if (get_user_type() == 'Super Admin') {

            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partnership = $user->partnership;
            $admiUsers =  $this->User_model->getInnerUserById($user_id);
            $userArray = array();
            $partnerShipArray = array();

            if (!empty($admiUsers)) {
                foreach ($admiUsers as $adminUser) {
                    $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasterUsers)) {
                        foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
                            $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

                            if (!empty($superMasterUsers)) {
                                foreach ($superMasterUsers as $superMasterUser) {
                                    $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                                    if (!empty($masterUsers)) {
                                        foreach ($masterUsers as $masterUser) {
                                            $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $userArray[] = $user->user_id;
                                                }
                                            }
                                            $masterUserArray[] = $user->user_id;
                                            $partnerShipArray[$user->user_id] = $user->partnership;
                                        }
                                    }


                                    $dataArray = array(
                                        'selection_id' => $fancy_id,
                                        'users' => $userArray,
                                        'match_id' => $event_id,

                                    );
                                }
                            }
                        }
                    }
                }
            }






            $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);

            $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
            $max_p = $max + 5;
            $min_p = $min - 5;

            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);


            $tmp_array = array();

            foreach ($bettings as $betting) {
                $user_id = get_user_id();
                $user =  $this->User_model->getUserById($betting->user_id);
                $masterUser =  $this->User_model->getUserById($user->master_id);
                $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
                $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);
                $adminUser =  $this->User_model->getUserById($hyperSuperMasterUser->master_id);


                $masterUserPartnership = $adminUser->partnership;


                $price_val  = $betting->price_val;
                $stake  = $betting->stake;
                $profit  = $betting->profit;
                $loss  = $betting->loss;

                foreach ($scores as $score) {

                    if ($betting->is_back == 0) {


                        if (isset($tmp_array[$score])) {


                            if ($score >= $price_val) {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);
                                $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $profit_amt =  ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal = ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {

                            if ($score >= $price_val) {

                                $total = ($loss * 1) * $partnership / 100;
                                $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    } else {
                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $profit_amt = ($profit * -1) * $partnership / 100;
                                $total = ($profit_amt);
                                $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_profit_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            } else {
                                $loss_amt = ($loss * 1) * $partnership / 100;
                                $total = ($loss_amt);

                                $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                $masterUsertotal =  ($master_loss_amt);
                                $tmp_array[$score] += $total - $masterUsertotal;
                            }
                        } else {
                            if ($score < $price_val) {
                                $total = ($loss) * $partnership / 100;
                                $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                $tmp_array[$score] = $total - $masterUsertotal;
                            } else {
                                $total = ($profit * -1) * $partnership / 100;
                                $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                $tmp_array[$score] = $total - $masterUsertotal;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        } else {

            $dataArray = array(
                'selection_id' => $fancy_id,
                'user_id' => $user_id,
                'match_id' => $event_id,
                'betting_type' => 'Fancy'

            );

            $max = $this->Betting_model->get_max_fancy_bettings($dataArray);
            $min = $this->Betting_model->get_min_fancy_bettings($dataArray);

            $max_p = $max + 5;
            $min_p = $min - 5;


            if ($min_p < 0) {
                $min_p = 0;
            }
            $scores = array_reverse(range($min_p, $max_p));

            $bettings = $this->Betting_model->get_fancy_bettings($dataArray);

            $tmp_array = array();

            foreach ($bettings as $betting) {
                $price_val  = $betting->price_val;
                $stake  = $betting->stake;
                $profit  = $betting->profit;
                $loss  = $betting->loss;


                foreach ($scores as $score) {
                    if ($betting->is_back == 0) {
                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $total = $tmp_array[$score] + $loss * -1;


                                $tmp_array[$score] = $total;
                            } else {
                                $total = $tmp_array[$score] + $profit * 1;
                                $tmp_array[$score] = $total;
                            }
                        } else {
                            if ($score < $price_val) {
                                $tmp_array[$score] = $profit;
                            } else {
                                $tmp_array[$score] = $loss * -1;
                            }
                        }
                    } else {

                        if (isset($tmp_array[$score])) {
                            if ($score >= $price_val) {
                                $total = $tmp_array[$score] + $profit * 1;
                                $tmp_array[$score] = $total;
                            } else {
                                $total = $tmp_array[$score] + $loss * -1;
                                $tmp_array[$score] = $total;
                            }
                        } else {
                            if ($score >= $price_val) {
                                $tmp_array[$score] = $profit * 1;
                            } else {
                                $tmp_array[$score] = $loss * -1;
                            }
                        }
                    }
                }
            }

            $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

            echo $html;
        }
    }
    // public function getPosition()
    // {
    //     $user_id = get_user_id();
    //     $fancy_id = $this->input->post('fancyid');
    //     $type_id = $this->input->post('typeid');
    //     $yes_val = $this->input->post('yesval');
    //     $no_val = $this->input->post('noval');

    //     if (get_user_type() == 'Master') {
    //         $user_id = get_user_id();
    //         $user =  $this->User_model->getUserById($user_id);
    //         $partnership = $user->partnership;
    //         $users =  $this->User_model->getInnerUserById($user_id);

    //         $userArray = array();

    //         foreach ($users as $user) {
    //             $userArray[] = $user->user_id;
    //         }

    //         $dataArray = array(
    //             'selection_id' => $fancy_id,
    //             'users' => $userArray
    //         );

    //         $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;

    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;

    //             foreach ($scores as $score) {

    //                 if ($betting->is_back == 0) {


    //                     if (isset($tmp_array[$score])) {

    //                         if ($score >= $price_val) {
    //                             $loss_amt =  ($loss * 1) * $partnership / 100;

    //                             $total = $tmp_array[$score] + $loss_amt;

    //                             $tmp_array[$score] = $total;
    //                         } else {

    //                             $profit_amt =   ($profit * -1) * $partnership / 100;

    //                             $total = ($tmp_array[$score] + $profit_amt);
    //                             $tmp_array[$score] = $total;
    //                         }
    //                     } else {

    //                         if ($score >= $price_val) {
    //                             $tmp_array[$score] = ($loss * 1) * $partnership / 100;
    //                         } else {
    //                             $tmp_array[$score] = ($profit * -1) * $partnership / 100;
    //                         }
    //                     }
    //                 } else {

    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {

    //                             $profit_amt = ($profit * -1) * $partnership / 100;
    //                             $total = ($tmp_array[$score] + $profit_amt);
    //                             $tmp_array[$score] = $total;
    //                         } else {

    //                             $loss_amt = ($loss * 1) * $partnership / 100;

    //                             $total = ($tmp_array[$score] +  $loss_amt);
    //                             $tmp_array[$score] = $total;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $tmp_array[$score] = ($loss) * $partnership / 100;
    //                         } else {
    //                             $tmp_array[$score] = ($profit * -1) * $partnership / 100;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     } else if (get_user_type() == 'Super Master') {

    //         $user_id = get_user_id();
    //         $user =  $this->User_model->getUserById($user_id);
    //         $partnership = $user->partnership;
    //         $masterUsers =  $this->User_model->getInnerUserById($user_id);
    //         $userArray = array();
    //         $partnerShipArray = array();


    //         if (!empty($masterUsers)) {
    //             foreach ($masterUsers as $masterUser) {
    //                 $users =  $this->User_model->getInnerUserById($masterUser->user_id);

    //                 if (!empty($users)) {
    //                     foreach ($users as $user) {
    //                         $userArray[] = $user->user_id;
    //                     }
    //                 }
    //                 $masterUserArray[] = $user->user_id;
    //                 $partnerShipArray[$user->user_id] = $user->partnership;
    //             }
    //         }


    //         $dataArray = array(
    //             'selection_id' => $fancy_id,
    //             'users' => $userArray
    //         );


    //         $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $user_id = get_user_id();
    //             $user =  $this->User_model->getUserById($betting->user_id);
    //             $masterUser =  $this->User_model->getUserById($user->master_id);

    //             $masterUserPartnership = $masterUser->partnership;


    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;
    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;

    //             foreach ($scores as $score) {

    //                 if ($betting->is_back == 0) {


    //                     if (isset($tmp_array[$score])) {


    //                         if ($score >= $price_val) {
    //                             $loss_amt = ($loss * 1) * $partnership / 100;
    //                             $total = ($tmp_array[$score] + $loss_amt);
    //                             $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $master_loss_amt);

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $profit_amt =  ($profit * -1) * $partnership / 100;
    //                             $total = ($tmp_array[$score] + $profit_amt);

    //                             $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;

    //                             $masterUsertotal = ($tmp_array[$score] + $master_profit_amt);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {

    //                         if ($score >= $price_val) {

    //                             $total = ($loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 } else {
    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $profit_amt = ($profit * -1) * $partnership / 100;


    //                             $total = ($tmp_array[$score] + $profit_amt);

    //                             $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $master_profit_amt);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $loss_amt = ($loss * 1) * $partnership / 100;
    //                             $total = ($tmp_array[$score] + $loss_amt);

    //                             $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $master_loss_amt);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $total = ($loss) * $partnership / 100;
    //                             $masterUsertotal = ($loss) * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     } else if (get_user_type() == 'Hyper Super Master') {

    //         $user_id = get_user_id();
    //         $user =  $this->User_model->getUserById($user_id);
    //         $partnership = $user->partnership;
    //         $superMasterUsers =  $this->User_model->getInnerUserById($user_id);
    //         $userArray = array();
    //         $partnerShipArray = array();

    //         if (!empty($superMasterUsers)) {
    //             foreach ($superMasterUsers as $superMasterUser) {
    //                 $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
    //                 if (!empty($masterUsers)) {
    //                     foreach ($masterUsers as $masterUser) {
    //                         $users =  $this->User_model->getInnerUserById($masterUser->user_id);

    //                         if (!empty($users)) {
    //                             foreach ($users as $user) {
    //                                 $userArray[] = $user->user_id;
    //                             }
    //                         }
    //                         $masterUserArray[] = $user->user_id;
    //                         $partnerShipArray[$user->user_id] = $user->partnership;
    //                     }
    //                 }


    //                 $dataArray = array(
    //                     'selection_id' => $fancy_id,
    //                     'users' => $userArray
    //                 );
    //             }
    //         }




    //         $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $user_id = get_user_id();
    //             $user =  $this->User_model->getUserById($betting->user_id);
    //             $masterUser =  $this->User_model->getUserById($user->master_id);
    //             $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);

    //             $masterUserPartnership = $superMasterUser->partnership;


    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;
    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;


    //             foreach ($scores as $score) {
    //                 if ($betting->is_back == 0) {


    //                     if (isset($tmp_array[$score])) {

    //                         if ($score >= $price_val) {

    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $loss * 1) * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {

    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {

    //                         if ($score >= $price_val) {

    //                             $total = ($loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 } else {

    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             // p($tmp_array[$score].'---'.$profit);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $total = ($loss) * $partnership / 100;
    //                             $masterUsertotal = ($loss) * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     } else if (get_user_type() == 'Admin') {

    //         $user_id = get_user_id();
    //         $user =  $this->User_model->getUserById($user_id);
    //         $partnership = $user->partnership;
    //         $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($user_id);
    //         $userArray = array();
    //         $partnerShipArray = array();

    //         if (!empty($hyperSuperMasterUsers)) {
    //             foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
    //                 $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

    //                 if (!empty($superMasterUsers)) {
    //                     foreach ($superMasterUsers as $superMasterUser) {
    //                         $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
    //                         if (!empty($masterUsers)) {
    //                             foreach ($masterUsers as $masterUser) {
    //                                 $users =  $this->User_model->getInnerUserById($masterUser->user_id);

    //                                 if (!empty($users)) {
    //                                     foreach ($users as $user) {
    //                                         $userArray[] = $user->user_id;
    //                                     }
    //                                 }
    //                                 $masterUserArray[] = $user->user_id;
    //                                 $partnerShipArray[$user->user_id] = $user->partnership;
    //                             }
    //                         }


    //                         $dataArray = array(
    //                             'selection_id' => $fancy_id,
    //                             'users' => $userArray
    //                         );
    //                     }
    //                 }
    //             }
    //         }




    //         $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $user_id = get_user_id();
    //             $user =  $this->User_model->getUserById($betting->user_id);
    //             $masterUser =  $this->User_model->getUserById($user->master_id);
    //             $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
    //             $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);


    //             $masterUserPartnership = $hyperSuperMasterUser->partnership;


    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;
    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;


    //             foreach ($scores as $score) {
    //                 if ($betting->is_back == 0) {


    //                     if (isset($tmp_array[$score])) {

    //                         if ($score >= $price_val) {

    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $loss * 1) * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {

    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {

    //                         if ($score >= $price_val) {

    //                             $total = ($loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 } else {

    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             // p($tmp_array[$score].'---'.$profit);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $total = ($loss) * $partnership / 100;
    //                             $masterUsertotal = ($loss) * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     } else if (get_user_type() == 'Super Admin') {

    //         $user_id = get_user_id();
    //         $user =  $this->User_model->getUserById($user_id);
    //         $partnership = $user->partnership;
    //         $admiUsers =  $this->User_model->getInnerUserById($user_id);
    //         $userArray = array();
    //         $partnerShipArray = array();

    //         if (!empty($admiUsers)) {
    //             foreach ($admiUsers as $adminUser) {
    //                 $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($adminUser->user_id);

    //                 if (!empty($hyperSuperMasterUsers)) {
    //                     foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
    //                         $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

    //                         if (!empty($superMasterUsers)) {
    //                             foreach ($superMasterUsers as $superMasterUser) {
    //                                 $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
    //                                 if (!empty($masterUsers)) {
    //                                     foreach ($masterUsers as $masterUser) {
    //                                         $users =  $this->User_model->getInnerUserById($masterUser->user_id);

    //                                         if (!empty($users)) {
    //                                             foreach ($users as $user) {
    //                                                 $userArray[] = $user->user_id;
    //                                             }
    //                                         }
    //                                         $masterUserArray[] = $user->user_id;
    //                                         $partnerShipArray[$user->user_id] = $user->partnership;
    //                                     }
    //                                 }


    //                                 $dataArray = array(
    //                                     'selection_id' => $fancy_id,
    //                                     'users' => $userArray
    //                                 );
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }





    //         $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $user_id = get_user_id();
    //             $user =  $this->User_model->getUserById($betting->user_id);
    //             $masterUser =  $this->User_model->getUserById($user->master_id);
    //             $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
    //             $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);
    //             $adminUser =  $this->User_model->getUserById($hyperSuperMasterUser->master_id);


    //             $masterUserPartnership = $adminUser->partnership;


    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;
    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;

    //             foreach ($scores as $score) {
    //                 if ($betting->is_back == 0) {


    //                     if (isset($tmp_array[$score])) {

    //                         if ($score >= $price_val) {

    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $loss * 1) * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {

    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {

    //                         if ($score >= $price_val) {

    //                             $total = ($loss * 1) * $partnership / 100;
    //                             $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 } else {

    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $total = ($tmp_array[$score] + $profit * -1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $profit * -1)  * $masterUserPartnership / 100;
    //                             // p($tmp_array[$score].'---'.$profit);
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($tmp_array[$score] + $loss * 1) * $partnership / 100;
    //                             $masterUsertotal =  ($tmp_array[$score] + $loss * 1)  * $masterUserPartnership / 100;

    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $total = ($loss) * $partnership / 100;
    //                             $masterUsertotal = ($loss) * $masterUserPartnership / 100;
    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         } else {
    //                             $total = ($profit * -1) * $partnership / 100;
    //                             $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


    //                             $tmp_array[$score] = $total - $masterUsertotal;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     } else {

    //         $dataArray = array(
    //             'selection_id' => $fancy_id,
    //             'user_id' => $user_id
    //         );

    //         $max = $this->Betting_model->get_max_fancy_bettings($dataArray);
    //         $min = $this->Betting_model->get_min_fancy_bettings($dataArray);

    //         $max_p = $max + 5;
    //         $min_p = $min - 5;

    //         $scores = array_reverse(range($min_p, $max_p));

    //         $bettings = $this->Betting_model->get_fancy_bettings($dataArray);

    //         $tmp_array = array();

    //         foreach ($bettings as $betting) {
    //             $price_val  = $betting->price_val;
    //             $stake  = $betting->stake;
    //             $profit  = $betting->profit;
    //             $loss  = $betting->loss;


    //             foreach ($scores as $score) {
    //                 if ($betting->is_back == 0) {
    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $total = $tmp_array[$score] + $loss * -1;


    //                             $tmp_array[$score] = $total;
    //                         } else {
    //                             $total = $tmp_array[$score] + $profit * 1;
    //                             $tmp_array[$score] = $total;
    //                         }
    //                     } else {
    //                         if ($score < $price_val) {
    //                             $tmp_array[$score] = $profit;
    //                         } else {
    //                             $tmp_array[$score] = $loss * -1;
    //                         }
    //                     }
    //                 } else {

    //                     if (isset($tmp_array[$score])) {
    //                         if ($score >= $price_val) {
    //                             $total = $tmp_array[$score] + $profit * 1;
    //                             $tmp_array[$score] = $total;
    //                         } else {
    //                             $total = $tmp_array[$score] + $loss * -1;
    //                             $tmp_array[$score] = $total;
    //                         }
    //                     } else {
    //                         if ($score >= $price_val) {
    //                             $tmp_array[$score] = $profit * 1;
    //                         } else {
    //                             $tmp_array[$score] = $loss * -1;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $html = $this->load->viewPartial('get-positions', array('scores' => $tmp_array));

    //         echo $html;
    //     }
    // }

    public function getExposure()
    {
        $user_id = get_user_id();
        $event_id = '30082209';
        $market_id = '1.174677254';

        $runners = $this->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));

        $bettings = $this->Betting_model->get_bettings_by_market_id(array('market_id' => $market_id, 'user_id' => $user_id));

        if (!empty($runners)) {
            $selection_id_1 = $runners['0']['selection_id'];
            $selection_id_2 = $runners['1']['selection_id'];


            $tmp_betting = array(
                $selection_id_1 => array(
                    'profit' => 0,
                    'loss' => 0,

                ),
                $selection_id_2 => array(
                    'profit' => 0,
                    'loss' => 0,

                ),
            );
        }


        if (!empty($bettings)) {
            foreach ($bettings as $betting) {

                if (isset($tmp_betting[$betting->selection_id])) {
                    if ($betting->is_back == 1) {
                        $price = ($betting->price_val * $betting->stake * -1) + $betting->stake;;
                        $profit = $tmp_betting[$betting->selection_id]['profit']   += ($betting->stake);
                        $profit = $tmp_betting[$betting->selection_id]['loss']   += ($price);
                    } else {
                        $price = ($betting->price_val * $betting->stake * -1) + $betting->stake;;
                        $profit = $tmp_betting[$betting->selection_id]['profit']   += ($betting->stake);
                        $profit = $tmp_betting[$betting->selection_id]['loss']   += ($price);
                    }
                } else {

                    if ($betting->is_back == 1) {
                        $price = $betting->price_val * $betting->stake * -1;
                        $tmp_betting[$betting->selection_id] = $price;
                    } else {
                        $price = $betting->price_val * $betting->stake * 1;
                        $tmp_betting[$betting->selection_id] = $price;
                    }
                }
            }
        }

        $selection_id_1 = $runners['0']['selection_id'];
        $selection_id_2 = $runners['1']['selection_id'];

        $total_exposure = array(
            $selection_id_1 => 0,
            $selection_id_2 => 0,

        );

        $i = 0;

        foreach ($tmp_betting as $key => $tmp_bett) {

            if ($i == 0) {
                $total_exposure[$selection_id_1] += $tmp_bett['loss'] * -1;
                $total_exposure[$selection_id_2] += $tmp_bett['profit'] * -1;
            } else {
                $total_exposure[$selection_id_1] += $tmp_bett['profit'] * -1;
                $total_exposure[$selection_id_2] += $tmp_bett['loss'] * -1;
            }
            $i++;
        }
        echo json_encode($total_exposure);
    }

    public function getExpiredFancyData()
    {
        log_message("MY_INFO", "Expired Fancy Call");

        $get_ball_running_fancys = $this->Event_model->get_all_fancy(array('cron_disable' => 'No'));



        if (!empty($get_ball_running_fancys)) {
            foreach ($get_ball_running_fancys as $fancy) {
                $date = new DateTime($fancy['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));


                $diff = $date2->getTimestamp() - $date->getTimestamp();



                if ($diff > 10) {

                    $dataArray = array(
                        'selection_id' => $fancy['selection_id'],
                        'match_id' => $fancy['match_id'],
                        'is_active' => 'Yes',
                        'mark_status' => 0,
                        'game_status' => 'SUSPENDED',
                        'back_size1' => 'SUSPENDED',
                        'lay_size1' => 'SUSPENDED',
                        'back_price1' => '-',
                        'lay_price1' => '-',
                        'cron_disable' => 'Yes'
                    );
                    $this->Event_model->addMarketBookOddsFancy($dataArray);
                }
            }
        }




        $get_market_odds = $this->Market_book_odds_model->expired_all_market_book_odds();
    }


    public function setEventId()
    {
        $events =   $this->Event_model->list_events(array());

        if (!empty($events)) {
            foreach ($events as $event) {
                $market_types = $this->Event_model->list_market_types1(array('event_id' => $event['event_id']));

                if (!empty($market_types)) {
                    foreach ($market_types as $market_type) {
                        $set = $this->Event_model->addMarketBookOdds(array('event_id' => $event['event_id'], 'market_id' => $market_type['market_id']));
                    }
                }
            }
        }
    }

    public function setBettingSetting()
    {

        $bettings =   $this->Betting_model->get_all_bets();
        if (!empty($bettings)) {
            foreach ($bettings as $betting) {

                $bettingSettings = $this->Masters_betting_settings_model->get_betting_settings(array('betting_id' => $betting->betting_id));

                if (!empty($bettingSettings)) {
                    foreach ($bettingSettings as $setting) {
                        if ($setting['user_type'] == 'User') {
                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $betting->profit,
                                'loss' => $betting->loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        } else if ($setting['user_type'] == 'Master') {

                            $loss =  ($betting->profit) * ($setting['partnership'] / 100);
                            $profit =  ($betting->loss) * ($setting['partnership'] / 100);



                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $profit,
                                'loss' => $loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        } else if ($setting['user_type'] == 'Super Master') {



                            $bettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Master', 'betting_id' => $betting->betting_id));

                            $master_partnership = $bettingSetting->partnership;

                            $superBettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Super Master', 'betting_id' => $betting->betting_id));

                            $super_partnership = $superBettingSetting->partnership;

                            $master_loss = $betting->profit * ($master_partnership / 100);
                            $super_loss = $betting->profit * ($super_partnership / 100);

                            $loss = $super_loss - $master_loss;


                            $master_profit =  $betting->loss * ($master_partnership / 100);
                            $super_profit = $betting->loss * ($super_partnership / 100);
                            $profit =  $super_profit - $master_profit;

                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $profit,
                                'loss' => $loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        } else if ($setting['user_type'] == 'Hyper Super Master') {
                            $bettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Super Master', 'betting_id' => $betting->betting_id));

                            $master_partnership = $bettingSetting->partnership;

                            $superBettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Hyper Super Master', 'betting_id' => $betting->betting_id));

                            $super_partnership = $superBettingSetting->partnership;

                            $master_loss = $betting->profit * ($master_partnership / 100);
                            $super_loss = $betting->profit * ($super_partnership / 100);

                            $loss = $super_loss - $master_loss;


                            $master_profit =  $betting->loss * ($master_partnership / 100);
                            $super_profit = $betting->loss * ($super_partnership / 100);
                            $profit =  $super_profit - $master_profit;

                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $profit,
                                'loss' => $loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        } else if ($setting['user_type'] == 'Admin') {
                            $bettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Hyper Super Master', 'betting_id' => $betting->betting_id));

                            $master_partnership = $bettingSetting->partnership;

                            $superBettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Admin', 'betting_id' => $betting->betting_id));

                            $super_partnership = $superBettingSetting->partnership;

                            $master_loss = $betting->profit * ($master_partnership / 100);
                            $super_loss = $betting->profit * ($super_partnership / 100);

                            $loss = $super_loss - $master_loss;


                            $master_profit =  $betting->loss * ($master_partnership / 100);
                            $super_profit = $betting->loss * ($super_partnership / 100);
                            $profit =  $super_profit - $master_profit;

                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $profit,
                                'loss' => $loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        } else if ($setting['user_type'] == 'Super Admin') {
                            $bettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Admin', 'betting_id' => $betting->betting_id));

                            $master_partnership = $bettingSetting->partnership;

                            $superBettingSetting = $this->Masters_betting_settings_model->get_betting_setting(array('user_type' => 'Super Admin', 'betting_id' => $betting->betting_id));

                            $super_partnership = $superBettingSetting->partnership;

                            $master_loss = $betting->profit * ($master_partnership / 100);
                            $super_loss = $betting->profit * ($super_partnership / 100);

                            $loss = $super_loss - $master_loss;


                            $master_profit =  $betting->loss * ($master_partnership / 100);
                            $super_profit = $betting->loss * ($super_partnership / 100);
                            $profit =  $super_profit - $master_profit;

                            $bettingSettingData = array(
                                'setting_id' => $setting['setting_id'],
                                'user_id' => $setting['user_id'],
                                'betting_id' =>  $betting->betting_id,
                                'casino_partnership' => $setting['casino_partnership'],
                                'partnership' =>  $setting['partnership'],
                                'teenpati_partnership' =>  $setting['teenpati_partnership'],
                                'master_commission' =>  $setting['master_commission'],
                                'sessional_commission' =>  $setting['sessional_commission'],
                                'user_type' =>  $setting['user_type'],
                                'match_id' => $betting->match_id,
                                'selection_id' => $betting->selection_id,
                                'is_back' => $betting->is_back,
                                'place_name' => $betting->place_name,
                                'stake' => $betting->stake,
                                'price_val' => $betting->price_val,
                                'profit' => $profit,
                                'loss' => $loss,
                                'exposure_1' => $betting->exposure_1,
                                'exposure_2' => $betting->exposure_2,
                                'market_id' => $betting->market_id,
                                'betting_type' => $betting->betting_type,
                                'unmatch_bet' => $betting->unmatch_bet,
                                'status' => $betting->status,
                                'market_type' => $betting->market_type,
                                'is_fancy' => $betting->is_fancy,
                                'ip_address' => $betting->ip_address,
                                'is_tie' => $betting->is_tie,
                                'bet_result' => $betting->bet_result,
                                'ip_address' => $betting->ip_address,
                                'ip_address' => $betting->ip_address,
                            );

                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        }
                    }
                }
            }
        }
    }

    public function addCasinoEvents($game_type)
    {

        log_message("MY_INFO", "ADD COMPETITION START");



        if ($game_type == 't20') {
            $tmp_game_type = 'teen20';
        } else if ($game_type == 'ltp') {
            $tmp_game_type = 'livetp';
        } else if ($game_type == '7ud') {
            $tmp_game_type = '7updown';
        } else if ($game_type == '32c') {
            $tmp_game_type = '32cards';
        } else if ($game_type == 'dt20') {
            $tmp_game_type = 'dt20';
        } else {
            $tmp_game_type = $game_type;
        }




        $reponse = getCasinoData($tmp_game_type);



        log_message("MY_INFO", $reponse);

        if ($game_type == 't20' || $game_type == '7ud' || $game_type == 'dt20' || $game_type == 'ltp'  || $game_type == '32c') {


            $data = json_decode($reponse);
            if (!empty($data->data)) {
                $results = $data->data;


                foreach ($results as $result) {
                    $get_casino_event_type = getCustomConfigItem('casino_event_type');


                    $event_type = $get_casino_event_type[$game_type];
                    $dataArray = array(
                        'competition_id' => 0,
                        'event_type' => $event_type,
                        'event_short_name' => $game_type,
                        'is_casino' => 'Yes',
                        'event_id' => $result->gameId,
                        'event_name' => $result->matchName,
                        'country_code' => '',
                        'timezone' => '',
                        'open_date' => '',
                        'market_count' => '',
                        'scoreboard_id' => '',
                        'selections' => '',
                        'liability_type' => '',
                        'undeclared_markets' => '',
                        'is_active' => 'Yes',

                    );




                    $event_id = $this->Event_model->addEvents($dataArray);

                    $dataArray = array(
                        'event_id' => $result->gameId,
                        'market_name' => $result->marketHeader,
                        'round_id' => $result->roundId,
                        'market_id' => $result->_id,
                        'is_casino' => 'Yes',
                        'market_start_time' => '',
                        'total_matched' => '',
                        'timer' => $result->timer
                    );




                    $this->Event_model->addMarketTypes($dataArray);


                    $dataArray = array(
                        'market_id' => $result->_id,
                        'event_id' => $result->gameId,

                        'is_market_data_delayed' => 0,
                        'status' => $result->status,
                        'bet_delay' => 0,
                        'bsp_reconciled' => '',
                        'complete' => 0,
                        'inplay' => 0,
                        'number_of_winners' => 0,
                        'number_of_runners' => 0,
                        'number_of_active_runners' => 0,
                        'last_match_time' => 0,
                        'total_matched' => 0,
                        'total_available' => 0,
                        'cross_matching' => 0,
                        'runners_voidable' => 0,
                        'version' => 0,

                    );
                    $market_book_odd_id =   $this->Event_model->addMarketBookOdds($dataArray);

                    if (!empty($result->marketRunner)) {
                        $runners = $result->marketRunner;

                        foreach ($runners as $runner) {

                            $dataArray = array(
                                'market_book_odd_id' => $market_book_odd_id,
                                'market_id' => $result->_id,
                                'event_id' => $result->gameId,
                                'selection_id' => $runner->id,
                                'runner_name' => $runner->name,
                                'sort_priority' => $runner->sortPriority,
                                'handicap' => 0,
                                'status' => $runner->status,
                                'last_price_traded' => 0,
                                'total_matched' => 0,
                                'back_1_price' => isset($runner->back[0]->price) ? $runner->back[0]->price : '',
                                'back_2_price' => isset($runner->back[1]->price) ? $runner->back[1]->price : '',
                                'back_3_price' => isset($runner->back[2]->price) ? $runner->back[2]->price : '',
                                'back_1_size' => isset($runner->back[0]->size) ? $runner->back[0]->size : '',
                                'back_2_size' => isset($runner->back[1]->size) ? $runner->back[1]->size : '',
                                'back_3_size' => isset($runner->back[2]->size) ? $runner->back[2]->size : '',
                                'lay_1_price' => isset($runner->lay[0]->price) ? $runner->lay[0]->price : '',
                                'lay_2_price' => isset($runner->lay[1]->price) ? $runner->lay[1]->price : '',
                                'lay_3_price' => isset($runner->lay[2]->price) ? $runner->lay[2]->price : '',
                                'lay_1_size' => isset($runner->lay[0]->size) ? $runner->lay[0]->size : '',
                                'lay_2_size' => isset($runner->lay[1]->size) ? $runner->lay[1]->size : '',
                                'lay_3_size' => isset($runner->lay[2]->size) ? $runner->lay[2]->size : '',
                            );


                            $this->Event_model->addMarketBookOddsRunners($dataArray);
                        }
                    }
                }
            }
        }
    }


    // public function getScoreData()
    // {

    //     $list_events = $this->Event_model->list_events();

    //     if (!empty($list_events)) {
    //         foreach ($list_events as $list_event) {

    //             if ($list_event['event_type'] == 4) {

    //                 $response = json_decode($this->getScoreDataByEventId($list_event['event_id']));


    //                 if (!empty($response)) {
    //                     $postdata = json_encode($response);
    //                     $url = get_ws_endpoint() . 'casino-score-data';

    //                     $ch = curl_init($url);
    //                     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //                     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //                     curl_setopt($ch, CURLOPT_POST, 1);
    //                     curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    //                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //                     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //                     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    //                     $result = curl_exec($ch);
    //                     curl_close($ch);
    //                 }
    //             }
    //         }
    //     }
    //     // return $response;
    // }
    public function getScoreDataByEventId()
    {

        $matchesList = matchesList();
        $matchesList = json_decode($matchesList);


        $scores = array();

        if (!empty($matchesList->data)) {
            $matches = $matchesList->data;

            foreach ($matches as $match) {
                $match_id = $match->match_id;
                $scoreData = matchScore($match_id);
                // $scoreData = '{"message":"Match score fetched.","code":0,"error":false,"data":{"match_id":6706,"match_name":"IPL 2nd T20 Match","match_date":"10-Apr-2021 at 07:30PM-Sat","venue":"Wankhede Stadium Mumbai","msg":"Delhi Capitals Won by 7 Wickets","teams":[{"team_name":"Delhi Capitals","team_short_name":"Delhi Capitals","score":"190/3(18.4)"},{"team_name":"CSK","team_short_name":"CSK","score":"188/7 (20.0)"}],"currentRunRate":" 10.3","current_inning":"1st Inning","remaining_overs":0,"requireRunRate":"","runNeeded":"","ballsRemaining":0,"target":0,"current_over":"18.4","current_score":"190","current_wickets":"3","match_format":"T20","currentPlayersScore":{"Batsman":[{"id":0,"on_play":"*","player_id":0,"team_id":0,"match_id":"","inning":"first_inning","runs":"0","balls":"0","fours":"0","sixes":"0","is_out":"0","out_text":"","strike_rate":"NaN"},{"id":1,"on_play":"","player_id":0,"team_id":0,"match_id":"","inning":"first_inning","runs":"0","balls":"0","fours":"0","sixes":"0","is_out":"0","out_text":"","strike_rate":"NaN"}],"partnership":"","lastWicket":"","bowler":{"player_name":"0"}},"last24balls":[],"completed_message":"Delhi Capitals Won by 7 Wickets"},"token":null}';

                $scoreData = json_decode($scoreData);

                $scores[] = $scoreData->data;
            }
        }

        $scores = json_encode($scores);
        $url = get_ws_endpoint() . 'casino-score-data';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $scores);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        // return $response;
    }


    public function getScoreMatches()
    {

        $matchesList = matchesList();

        p($matchesList);
        // return $response;
    }


    public function listBookmakerMarket()
    {
        log_message("MY_INFO", "ADD LIST BPPKMAKER MARKET TYPE START");
        $events = $this->Event_model->getEvents();


        if (!empty($events)) {
            $i = 0;
            foreach ($events as $event) {


                $date = new DateTime($event['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));


                $diff = $date2->getTimestamp() - $date->getTimestamp();


                if ($diff < 720) {

                    echo $i++;
                    $listMarketTypes = json_decode(listBookmakerMarket($event['event_id']));

                    if (!empty($listMarketTypes)) {

                        foreach ($listMarketTypes as $market) {

                            $dataArray = array(
                                'event_id' => $event['event_id'],
                                'market_name' => $market->marketName,
                                'market_id' => $market->marketId,
                                'market_start_time' => $market->marketStartTime,
                                'total_matched' => $market->totalMatched,
                                'runner_1_selection_id' => $market->runners[0]->selectionId,
                                'runner_1_runner_name' => $market->runners[0]->runnerName,
                                'runner_1_handicap' => $market->runners[0]->handicap,
                                'runner_1_sort_priority' => $market->runners[0]->sortPriority,
                                'runner_2_selection_id' => $market->runners[1]->selectionId,
                                'runner_2_runner_name' => $market->runners[1]->runnerName,
                                'runner_2_handicap' => $market->runners[1]->handicap,
                                'runner_2_sort_priority' => $market->runners[1]->sortPriority,
                            );


                            $this->Event_model->addMarketTypes($dataArray);
                        }
                    }
                }
            }
        }
        log_message("MY_INFO", "ADD LIST BPPKMAKER MARKET TYPE START");

        log_message("MY_INFO", "*******************");
        return true;
    }

    public function addBookmakerMarketOdds($sport_id = null)
    {
        log_message("MY_INFO", "ADD Bookmakes MARKET BOOK ODDS START");
        $market_types = $this->Event_model->getMarketTypeIds();




        if (!empty($market_types)) {
            $market_ids = '';
            $event_ids = array();
            foreach ($market_types as $market_type) {

                $date = new DateTime($market_type['updated_at']);
                $date2 = new DateTime(date('Y-m-d H:i:s'));
                $diff = $date2->getTimestamp() - $date->getTimestamp();



                //  if ($diff < 1520) {
                if ($market_type['market_name'] == 'Bookmaker') {
                    $listMarketBookOdds = json_decode(listBookmakerMarketOdds($market_type['market_id']));
                    if (!empty($listMarketBookOdds)) {
                        foreach ($listMarketBookOdds as $listMarketBookOdd) {

                            $listMarketRunners = json_decode(listBookmakerMarketRunner($listMarketBookOdd->marketId));

                            $runnersArr =  $listMarketRunners[0]->runners;


                            $marketId = str_replace('.', '_', $listMarketBookOdd->marketId);
                            $event_id = $market_type['event_id'];
                            $dataArray = array(
                                'market_id' => $listMarketBookOdd->marketId,
                                'event_id' =>  $event_id,

                                'is_market_data_delayed' => $listMarketBookOdd->isMarketDataDelayed,
                                'status' => $listMarketBookOdd->status,
                                'bet_delay' => $listMarketBookOdd->betDelay,
                                'bsp_reconciled' => $listMarketBookOdd->bspReconciled,
                                'complete' => $listMarketBookOdd->complete,
                                'inplay' => $listMarketBookOdd->inplay,
                                'number_of_winners' => $listMarketBookOdd->numberOfWinners,
                                'number_of_runners' => $listMarketBookOdd->numberOfRunners,
                                'number_of_active_runners' => $listMarketBookOdd->numberOfActiveRunners,
                                'last_match_time' => $listMarketBookOdd->lastMatchTime,
                                'total_matched' => $listMarketBookOdd->totalMatched,
                                'total_available' => $listMarketBookOdd->totalAvailable,
                                'cross_matching' => $listMarketBookOdd->crossMatching,
                                'runners_voidable' => $listMarketBookOdd->runnersVoidable,
                                'version' => $listMarketBookOdd->version,

                            );



                            $market_book_odd_id =  $this->Event_model->addMarketBookOdds($dataArray);

                            if ($market_book_odd_id) {
                                if (!empty($listMarketBookOdd->runners)) {
                                    foreach ($listMarketBookOdd->runners as $runner) {

                                        foreach ($runnersArr as $runnerArr) {


                                            if ($runner->selectionId == $runnerArr->selectionId) {
                                                $dataArray = array(
                                                    'market_book_odd_id' => $market_book_odd_id,
                                                    'market_id' => $listMarketBookOdd->marketId,
                                                    'event_id' => $event_id,
                                                    'selection_id' => $runner->selectionId,
                                                    'runner_name' => $runnerArr->runnerName,
                                                    'sort_priority' => $runnerArr->sortPriority,

                                                    'handicap' => $runner->handicap,
                                                    'status' => $runner->status,
                                                    'last_price_traded' => $runner->lastPriceTraded,
                                                    'total_matched' => $runner->totalMatched,
                                                    'back_1_price' => isset($runner->ex->availableToBack[0]->price) ? $runner->ex->availableToBack[0]->price : '',
                                                    'back_2_price' => isset($runner->ex->availableToBack[1]->price) ? $runner->ex->availableToBack[1]->price : '',
                                                    'back_3_price' => isset($runner->ex->availableToBack[2]->price) ? $runner->ex->availableToBack[2]->price : '',
                                                    'back_1_size' => isset($runner->ex->availableToBack[0]->size) ? $runner->ex->availableToBack[0]->size : '',
                                                    'back_2_size' => isset($runner->ex->availableToBack[1]->size) ? $runner->ex->availableToBack[1]->size : '',
                                                    'back_3_size' => isset($runner->ex->availableToBack[2]->size) ? $runner->ex->availableToBack[2]->size : '',
                                                    'lay_1_price' => isset($runner->ex->availableToLay[0]->price) ? $runner->ex->availableToLay[0]->price : '',
                                                    'lay_2_price' => isset($runner->ex->availableToLay[1]->price) ? $runner->ex->availableToLay[1]->price : '',
                                                    'lay_3_price' => isset($runner->ex->availableToLay[2]->price) ? $runner->ex->availableToLay[2]->price : '',
                                                    'lay_1_size' => isset($runner->ex->availableToLay[0]->size) ? $runner->ex->availableToLay[0]->size : '',
                                                    'lay_2_size' => isset($runner->ex->availableToLay[1]->size) ? $runner->ex->availableToLay[1]->size : '',
                                                    'lay_3_size' => isset($runner->ex->availableToLay[2]->size) ? $runner->ex->availableToLay[2]->size : '',
                                                );

                                                $this->Event_model->addMarketBookOddsRunners($dataArray);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        log_message("MY_INFO", "ADD Bookmake MARKET BOOK ODDS END");
        log_message("MY_INFO", "*******************");
        return true;
    }



    public function user_info_update()
    {

        $setting = $this->User_info_model->get_casino_default_general_setting();

        $allUsers = $this->User_model->getAllUserRecords();

        if (!empty($allUsers)) {
            foreach ($allUsers as $user) {

                $dataArray = array(
                    'setting_id' => $setting['setting_id'],
                    'user_id' => $user['user_id'],
                    'sport_id' => $setting['sport_id'],
                    'sport_name' => $setting['sport_name'],
                    'min_stake' => $setting['min_stake'],
                    'max_stake' => $setting['max_stake'],
                    'max_profit' => $setting['max_profit'],
                    'max_loss' => $setting['max_loss'],
                    'bet_delay' => $setting['bet_delay'],
                    'pre_inplay_profit' => $setting['pre_inplay_profit'],
                    'pre_inplay_stake' => $setting['pre_inplay_stake'],
                    'min_odds' => $setting['min_odds'],
                    'max_odds' => $setting['max_odds'],
                    'unmatch_bet' => $setting['unmatch_bet'],
                    'lock_bet' => $setting['lock_bet'],
                );

                $this->User_info_model->addRegisteredUserInfo($dataArray);
            }
        }


        return true;
    }

    public function userWiseLossProfit()
    {
        $user_id = get_user_id();
        $user_detail  = $this->User_model->getUserById($user_id);
        $match_id =  $this->input->post('matchId');

        $markets = $this->Market_type_model->get_market_type_by_event_id($match_id);

        $profitLossDatas = array();
        if ($user_detail) {
            if ($user_detail->user_type == 'Master') {
                if ($markets) {
                    foreach ($markets as $market) {
                        if ($market->market_name !== 'Match Odds') {
                            continue;
                        }
                        $market_id = $market->market_id;

                        $users = $this->User_model->getInnerUserById($user_id);
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $user_id = $user->user_id;
                                $user_name = $user->user_name;

                                $exposure = get_user_market_exposure_by_marketid($market_id, $user_id);

                                if (!empty($exposure)) {
                                    $profitLossDatas[] = array(
                                        'user_name' => $user_name,
                                        'exposure' => $exposure
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }


        $dataArray['profitLossDatas'] = $profitLossDatas;
        //        p($reports);
        $html = $this->load->viewPartial('/user-wise-profit-loss-html', $dataArray);
        echo json_encode(array('htmlData' => $html));
    }

    // public function fetchMatchOddsPositionList()
    // {

    //     $user_id =  $this->input->post('user_id');
    //     if (empty($user_id)) {
    //         $user_id = get_user_id();
    //     }

    //     $master_user_id = $user_id;

    //     // $user_id = 7535;
    //     $user_detail  = $this->User_model->getUserById($user_id);


    //     $match_id =  $this->input->post('matchId');
    //     $market_id =  $this->input->post('market_id');


    //     // $match_id = 30896017;
    //     $markets = $this->Market_type_model->get_market_type_by_event_id($match_id, $market_id);

    //     $dataArray['user_id'] = $user_id;

    //     $profitLossDatas = array();
    //     if ($user_detail) {
    //         if ($markets) {
    //             foreach ($markets as $market) {

    //                 $market_id = $market->market_id;

    //                 $users = $this->User_model->getInnerUserById($user_id);

    //                 if (!empty($users)) {
    //                     foreach ($users as $user) {
    //                         $user_id = $user->user_id;
    //                         $user_name = $user->user_name;


    //                         if ($user->user_type == 'User') {
    //                             $exposure = get_user_position_by_marketid($market_id, $user_id);
    //                         } else {
    //                             $exposure = get_master_market_position_by_marketid($market_id, $user_id);
    //                         }

    //                         if (!empty($exposure)) {
    //                             $profitLossDatas[] = array(
    //                                 'user_name' => $user_name,
    //                                 'user_type' => $user->user_type,
    //                                 'name' => $user->name,
    //                                 'user_id' => $user_id,


    //                                 'exposure' => $exposure
    //                             );
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }



    //     $dataArray['profitLossDatas'] = $profitLossDatas;


    //     //        p($reports);
    //     $html = $this->load->viewPartial('/user-wise-profit-loss-html', $dataArray);

    //     echo json_encode(array('htmlData' => $html));
    // }


    public function getCasinoLastResult()
    {

        $event_id = $this->input->post('match_id');
        $event_detail = $this->Event_model->get_event_by_event_id($event_id);

        $returnResultData = array();

        if (!empty($event_detail)) {
            $game_link = '';
            if ($event_detail->event_short_name == 't20') {
                $game_link = 'http://45.79.120.59:3000/getresult/teen20';
            } else if ($event_detail->event_short_name == 'ab') {
                $game_link = 'http://3.6.167.21:3000/getab-result';
            } else if ($event_detail->event_short_name == 'aaa') {
                $game_link = 'http://3.6.94.71:3000/getresult/aaa';
            } else if ($event_detail->event_short_name == '7ud') {
                $game_link = 'http://3.6.167.21:3000/getl7b-result';
            } else if ($event_detail->event_short_name == 'dt20') {
                $game_link = 'http://3.6.167.21:3000/getdt-result';
            } else if ($event_detail->event_short_name == '32c') {
                $game_link = 'http://3.6.167.21:3000/get32b-result';
            } else if ($event_detail->event_short_name == 'ltp') {
                $game_link = 'http://45.79.120.59:3000/getresult/teen';
            }

            $results = json_decode(getDiamondCasinoResult($game_link));

            if (isset($results->data)) {
                if ($event_detail->event_short_name == 't20' || $event_detail->event_short_name == 'ltp') {
                    $results = $results->data->res;

                    if (!empty($results)) {
                        foreach ($results as $result) {
                            $market_id = $result->mid . '_match_odds';
                            

                            $runners = $this->Market_book_odds_runner_model->get_runners(array(
                                'event_id' => $event_detail->event_id,
                                'market_id' => $market_id
                            ));


                            if (!empty($runners)) {
                                foreach ($runners as $runner) {
                                    if ($runner->selection_id == $result->win) {
                                        $returnResultData[] = array(
                                            'market_id' => $market_id,
                                            'player' => $runner->runner_name,
                                            'selection_id' => $runner->selection_id
                                        );
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $results = $results->data;
                    if (!empty($results)) {
                        foreach ($results as $result) {
                            $market_id = str_replace('.', '__', $result->mid) . '_match_odds';
                            $round_id = explode('.', $result->mid);

                            $runners = $this->Market_book_odds_runner_model->get_runners(array(
                                'event_id' => $event_detail->event_id,
                                'market_id' => $market_id
                            ));


                            if (!empty($runners)) {
                                foreach ($runners as $runner) {
                                    if ($runner->selection_id == $result->result) {
                                        $returnResultData[] = array(
                                            'market_id' => $round_id[1],
                                            'player' => $runner->runner_name,
                                            'selection_id' => $runner->selection_id
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $dataArray['results'] = $returnResultData;
        if ($this->input->post('type')) {
            echo json_encode(array('resultHtml' => $returnResultData));
        } else {
            $resultHtml = $this->load->viewPartial('casino-result', $dataArray);
            echo json_encode(array('resultHtml' => $resultHtml));
        }
    }


    public function showCardOfResult()
    {
        $market_id = $this->input->post('market_id');        
        $market_id_arr = explode('_', $market_id);
        
        // $game_link = 'http://13.235.31.12:8040/result?mid=' . $market_id;
        $game_link = 'http://192.46.211.137:3000/getresult/'.$market_id_arr[0] ;

        $results = json_decode(showCardOfResult($game_link));

        echo json_encode($results->data);
    }



    public function getFancysExposure()
    {
        $user_id = get_user_id();
        $event_id = $this->input->post('event_id');
        // $event_id = 31058628;
        $user_type = get_user_type();
        $dataArray = array(
            "match_id" => $event_id,
            "user_id" => $user_id,
        );
        $open_fancy_bettings =  $this->Betting_model->get_all_fancy_group_list($dataArray);

        $fancyExposureArray = array();
        if (!empty($open_fancy_bettings)) {
            foreach ($open_fancy_bettings as $open_fancy_betting) {
                $fancy_id = $open_fancy_betting['selection_id'];

                if (get_user_type() == 'Master') {
                    $user_id = get_user_id();
                    $user =  $this->User_model->getUserById($user_id);
                    $partnership = $user->partnership;
                    $users =  $this->User_model->getInnerUserById($user_id);

                    $userArray = array();

                    foreach ($users as $user) {
                        $userArray[] = $user->user_id;
                    }

                    $dataArray = array(
                        'selection_id' => $fancy_id,
                        'users' => $userArray,
                        'match_id' => $event_id,

                    );

                    $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);

                    $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;

                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);


                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;

                        $profit  = $betting->profit;
                        $loss  = $betting->loss;

                        foreach ($scores as $score) {

                            if ($betting->is_back == 0) {


                                if (isset($tmp_array[$score])) {

                                    if ($score >= $price_val) {
                                        $loss_amt =  ($loss * 1) * $partnership / 100;

                                        $total = $tmp_array[$score] + $loss_amt;

                                        $tmp_array[$score] = $total;
                                    } else {

                                        $profit_amt =   ($profit * -1) * $partnership / 100;

                                        $total = ($tmp_array[$score] + $profit_amt);
                                        $tmp_array[$score] = $total;
                                    }
                                } else {

                                    if ($score >= $price_val) {
                                        $tmp_array[$score] = ($loss * 1) * $partnership / 100;
                                    } else {
                                        $tmp_array[$score] = ($profit * -1) * $partnership / 100;
                                    }
                                }
                            } else {

                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {

                                        $profit_amt = ($profit * -1) * $partnership / 100;
                                        $total = ($tmp_array[$score] + $profit_amt);
                                        $tmp_array[$score] = $total;
                                    } else {

                                        $loss_amt = ($loss * 1) * $partnership / 100;

                                        $total = ($tmp_array[$score] +  $loss_amt);
                                        $tmp_array[$score] = $total;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $tmp_array[$score] = ($loss) * $partnership / 100;
                                    } else {
                                        $tmp_array[$score] = ($profit * -1) * $partnership / 100;
                                    }
                                }
                            }
                        }
                    }

                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                } else if (get_user_type() == 'Super Master') {

                    $user_id = get_user_id();
                    $user =  $this->User_model->getUserById($user_id);
                    $partnership = $user->partnership;
                    $masterUsers =  $this->User_model->getInnerUserById($user_id);
                    $userArray = array();
                    $partnerShipArray = array();


                    if (!empty($masterUsers)) {
                        foreach ($masterUsers as $masterUser) {
                            $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $userArray[] = $user->user_id;
                                }
                            }
                            $masterUserArray[] = $user->user_id;
                            $partnerShipArray[$user->user_id] = $user->partnership;
                        }
                    }


                    $dataArray = array(
                        'selection_id' => $fancy_id,
                        'users' => $userArray,
                        'match_id' => $event_id,

                    );


                    $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
                    $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;

                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $user_id = get_user_id();
                        $user =  $this->User_model->getUserById($betting->user_id);
                        $masterUser =  $this->User_model->getUserById($user->master_id);

                        $masterUserPartnership = $masterUser->partnership;


                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;

                        foreach ($scores as $score) {

                            if ($betting->is_back == 0) {


                                if (isset($tmp_array[$score])) {


                                    if ($score >= $price_val) {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);
                                        $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $profit_amt =  ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {

                                    if ($score >= $price_val) {

                                        $total = ($loss * 1) * $partnership / 100;
                                        $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            } else {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $profit_amt = ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);

                                        $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $total = ($loss) * $partnership / 100;
                                        $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            }
                        }
                    }

                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                } else if (get_user_type() == 'Hyper Super Master') {

                    $user_id = get_user_id();
                    $user =  $this->User_model->getUserById($user_id);
                    $partnership = $user->partnership;
                    $superMasterUsers =  $this->User_model->getInnerUserById($user_id);
                    $userArray = array();
                    $partnerShipArray = array();

                    if (!empty($superMasterUsers)) {
                        foreach ($superMasterUsers as $superMasterUser) {
                            $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $userArray[] = $user->user_id;
                                        }
                                    }
                                    $masterUserArray[] = $user->user_id;
                                    $partnerShipArray[$user->user_id] = $user->partnership;
                                }
                            }


                            $dataArray = array(
                                'selection_id' => $fancy_id,
                                'users' => $userArray,
                                'match_id' => $event_id,

                            );
                        }
                    }




                    $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
                    $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;

                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $user_id = get_user_id();
                        $user =  $this->User_model->getUserById($betting->user_id);
                        $masterUser =  $this->User_model->getUserById($user->master_id);
                        $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);

                        $masterUserPartnership = $superMasterUser->partnership;


                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;


                        foreach ($scores as $score) {

                            if ($betting->is_back == 0) {


                                if (isset($tmp_array[$score])) {


                                    if ($score >= $price_val) {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);
                                        $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $profit_amt =  ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {

                                    if ($score >= $price_val) {

                                        $total = ($loss * 1) * $partnership / 100;
                                        $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            } else {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $profit_amt = ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);

                                        $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $total = ($loss) * $partnership / 100;
                                        $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            }
                        }
                    }

                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                } else if (get_user_type() == 'Admin') {

                    $user_id = get_user_id();
                    $user =  $this->User_model->getUserById($user_id);
                    $partnership = $user->partnership;
                    $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($user_id);
                    $userArray = array();
                    $partnerShipArray = array();

                    if (!empty($hyperSuperMasterUsers)) {
                        foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
                            $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

                            if (!empty($superMasterUsers)) {
                                foreach ($superMasterUsers as $superMasterUser) {
                                    $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                                    if (!empty($masterUsers)) {
                                        foreach ($masterUsers as $masterUser) {
                                            $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $userArray[] = $user->user_id;
                                                }
                                            }
                                            $masterUserArray[] = $user->user_id;
                                            $partnerShipArray[$user->user_id] = $user->partnership;
                                        }
                                    }


                                    $dataArray = array(
                                        'selection_id' => $fancy_id,
                                        'users' => $userArray,
                                        'match_id' => $event_id,

                                    );
                                }
                            }
                        }
                    }




                    $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);
                    $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;

                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);

                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $user_id = get_user_id();
                        $user =  $this->User_model->getUserById($betting->user_id);
                        $masterUser =  $this->User_model->getUserById($user->master_id);
                        $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
                        $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);


                        $masterUserPartnership = $hyperSuperMasterUser->partnership;


                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;


                        foreach ($scores as $score) {

                            if ($betting->is_back == 0) {


                                if (isset($tmp_array[$score])) {


                                    if ($score >= $price_val) {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);
                                        $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $profit_amt =  ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {

                                    if ($score >= $price_val) {

                                        $total = ($loss * 1) * $partnership / 100;
                                        $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            } else {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $profit_amt = ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);

                                        $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $total = ($loss) * $partnership / 100;
                                        $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            }
                        }
                    }
                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                } else if (get_user_type() == 'Super Admin') {



                    $user_id = get_user_id();
                    $user =  $this->User_model->getUserById($user_id);
                    $partnership = $user->partnership;
                    $admiUsers =  $this->User_model->getInnerUserById($user_id);
                    $userArray = array();
                    $partnerShipArray = array();

                    if (!empty($admiUsers)) {
                        foreach ($admiUsers as $adminUser) {
                            $hyperSuperMasterUsers =  $this->User_model->getInnerUserById($adminUser->user_id);

                            if (!empty($hyperSuperMasterUsers)) {
                                foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
                                    $superMasterUsers =  $this->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

                                    if (!empty($superMasterUsers)) {
                                        foreach ($superMasterUsers as $superMasterUser) {
                                            $masterUsers =  $this->User_model->getInnerUserById($superMasterUser->user_id);
                                            if (!empty($masterUsers)) {
                                                foreach ($masterUsers as $masterUser) {
                                                    $users =  $this->User_model->getInnerUserById($masterUser->user_id);

                                                    if (!empty($users)) {
                                                        foreach ($users as $user) {
                                                            $userArray[] = $user->user_id;
                                                        }
                                                    }
                                                    $masterUserArray[] = $user->user_id;
                                                    $partnerShipArray[$user->user_id] = $user->partnership;
                                                }
                                            }


                                            $dataArray = array(
                                                'selection_id' => $fancy_id,
                                                'users' => $userArray,
                                                'match_id' => $event_id,

                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }






                    $max = $this->Betting_model->get_max_fancy_bettings_by_users($dataArray);

                    $min = $this->Betting_model->get_min_fancy_bettings_by_users($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;

                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings_by_users($dataArray);


                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $user_id = get_user_id();
                        $user =  $this->User_model->getUserById($betting->user_id);
                        $masterUser =  $this->User_model->getUserById($user->master_id);
                        $superMasterUser =  $this->User_model->getUserById($masterUser->master_id);
                        $hyperSuperMasterUser =  $this->User_model->getUserById($superMasterUser->master_id);
                        $adminUser =  $this->User_model->getUserById($hyperSuperMasterUser->master_id);


                        $masterUserPartnership = $adminUser->partnership;


                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;

                        foreach ($scores as $score) {

                            if ($betting->is_back == 0) {


                                if (isset($tmp_array[$score])) {


                                    if ($score >= $price_val) {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);
                                        $master_loss_amt = ($loss * 1) * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $profit_amt =  ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal = ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {

                                    if ($score >= $price_val) {

                                        $total = ($loss * 1) * $partnership / 100;
                                        $masterUsertotal = ($loss * 1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;

                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            } else {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $profit_amt = ($profit * -1) * $partnership / 100;
                                        $total = ($profit_amt);
                                        $master_profit_amt =  ($profit * -1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_profit_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    } else {
                                        $loss_amt = ($loss * 1) * $partnership / 100;
                                        $total = ($loss_amt);

                                        $master_loss_amt = ($loss * 1)  * $masterUserPartnership / 100;
                                        $masterUsertotal =  ($master_loss_amt);
                                        $tmp_array[$score] += $total - $masterUsertotal;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $total = ($loss) * $partnership / 100;
                                        $masterUsertotal = ($loss) * $masterUserPartnership / 100;
                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    } else {
                                        $total = ($profit * -1) * $partnership / 100;
                                        $masterUsertotal = ($profit * -1)  * $masterUserPartnership / 100;


                                        $tmp_array[$score] = $total - $masterUsertotal;
                                    }
                                }
                            }
                        }
                    }

                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                } else {

                    $dataArray = array(
                        'selection_id' => $fancy_id,
                        'user_id' => $user_id,
                        'match_id' => $event_id,
                        'betting_type' => 'Fancy'

                    );

                    $max = $this->Betting_model->get_max_fancy_bettings($dataArray);


                    $min = $this->Betting_model->get_min_fancy_bettings($dataArray);
                    $max_p = $max + 5;
                    $min_p = $min - 5;


                    if ($min_p < 0) {
                        $min_p = 0;
                    }
                    $scores = array_reverse(range($min_p, $max_p));

                    $bettings = $this->Betting_model->get_fancy_bettings($dataArray);


                    $tmp_array = array();

                    foreach ($bettings as $betting) {
                        $price_val  = $betting->price_val;
                        $stake  = $betting->stake;
                        $profit  = $betting->profit;
                        $loss  = $betting->loss;


                        foreach ($scores as $score) {
                            if ($betting->is_back == 0) {
                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $total = $tmp_array[$score] + $loss * -1;


                                        $tmp_array[$score] = $total;
                                    } else {
                                        $total = $tmp_array[$score] + $profit * 1;
                                        $tmp_array[$score] = $total;
                                    }
                                } else {
                                    if ($score < $price_val) {
                                        $tmp_array[$score] = $profit;
                                    } else {
                                        $tmp_array[$score] = $loss * -1;
                                    }
                                }
                            } else {

                                if (isset($tmp_array[$score])) {
                                    if ($score >= $price_val) {
                                        $total = $tmp_array[$score] + $profit * 1;
                                        $tmp_array[$score] = $total;
                                    } else {
                                        $total = $tmp_array[$score] + $loss * -1;
                                        $tmp_array[$score] = $total;
                                    }
                                } else {
                                    if ($score >= $price_val) {
                                        $tmp_array[$score] = $profit * 1;
                                    } else {
                                        $tmp_array[$score] = $loss * -1;
                                    }
                                }
                            }
                        }
                    }

                    $fancyExposureArray[$fancy_id] = min($tmp_array) < 0 ? min($tmp_array) : 0;
                }
            }
        }



        echo json_encode($fancyExposureArray);
    }

    public function fetchMatchOddsPositionList()
    {
        $user_id =  $this->input->post('user_id');
        if (empty($user_id)) {
            $user_id = get_user_id();
        }

        // $user_id = '11344';
        // $match_id = '31062818';
        // $market_id = '1.190618276';


        $master_user_id = $user_id;

        // $user_id = 7535;
        $user_detail  = $this->User_model->getUserById($user_id);
        // p($user_detail);

        $match_id =  $this->input->post('matchId');
        $market_id =  $this->input->post('market_id');


        // $match_id = 30896017;
        $markets = $this->Market_type_model->get_market_type_by_event_id($match_id, $market_id);


        $dataArray['user_id'] = $user_id;

        $profitLossDatas = array();
        if ($user_detail) {
            if ($markets) {
                foreach ($markets as $market) {
                    // if ($market->market_name !== 'Match Odds') {
                    //     continue;
                    // }
                    $market_id = $market->market_id;

                    $users = $this->User_model->getInnerUserById($user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $user_id = $user->user_id;

                            $user_name = $user->user_name;

                            // p($user->user_type);
                            if ($user->user_type == 'User') {
                                $exposure = get_user_position_by_marketid($market_id, $user_id);
                            } else {
                                $exposure = get_master_market_position_by_marketid($market_id, $user_id);
                            }
                            // p($exposure);

                            $runners = $this->Event_model->list_market_book_odds_runner(array(
                                'event_id' => $match_id,
                                'market_id' => $market_id,
                            ));

                            // p($runners);



                            if (!empty($exposure)) {
                                $profitLossDatas[] = array(
                                    'user_name' => $user_name,
                                    'user_type' => $user->user_type,
                                    'name' => $user->name,
                                    'user_id' => $user_id,

                                    'runners' => $runners,
                                    'exposure' => $exposure
                                );
                            }
                        }
                    }
                }
            }
        }


        // p($runners);



        $dataArray['profitLossDatas'] = $profitLossDatas;
        // $dataArray['bookmakerProfitLossDatas'] = $bookmakerProfitLossDatas;
        $self_pls = get_master_market_exposure_by_marketid($market_id, $master_user_id);
        $upline_pls = get_master_upline_market_exposure_by_marketid($market_id, $master_user_id);

        // $upline_pls = get_t_upline_market_exposure_by_marketid($market_id, $master_user_id);



        $dataArray['self_pls'] = $self_pls;
        $dataArray['upline_pls'] = $upline_pls;

        $dataArray['runners'] = $runners;
        $user_type = $user_detail->user_type;



        $dataArray['user_type'] = $user_type;
        $dataArray['match_id'] = $match_id;
        $dataArray['market_id'] = $market_id;


        //        p($reports);
        $matchOddshtml = $this->load->viewPartial('/user-wise-profit-loss-html', $dataArray);



        // $user_id =  $this->input->post('user_id');
        // if (empty($user_id)) {
        //     $user_id = get_user_id();
        // }

        // $master_user_id = $user_id;

        // // $user_id = 7535;
        // $user_detail  = $this->User_model->getUserById($user_id);


        // $match_id =  $this->input->post('matchId');

        // // $match_id = 30896017;
        // $markets = $this->Market_type_model->get_market_type_by_event_id($match_id);


        // $dataArray['user_id'] = $user_id;

        // $profitLossDatas = array();
        // if ($user_detail) {
        //     if ($markets) {
        //         foreach ($markets as $market) {
        //             if ($market->market_name !== 'Bookmaker') {
        //                 continue;
        //             }
        //             $market_id = $market->market_id;

        //             $users = $this->User_model->getInnerUserById($user_id);

        //             if (!empty($users)) {
        //                 foreach ($users as $user) {
        //                     $user_id = $user->user_id;
        //                     $user_name = $user->user_name;


        //                     if ($user->user_type == 'User') {
        //                         $exposure = get_user_position_by_marketid($market_id, $user_id);
        //                     } else {
        //                         $exposure = get_master_market_position_by_marketid($market_id, $user_id);
        //                     }


        //                     $runners = $this->Event_model->list_market_book_odds_runner(array(
        //                         'event_id' => $match_id,
        //                         'market_id' => $market_id,
        //                     ));



        //                     if (!empty($exposure)) {
        //                         $profitLossDatas[] = array(
        //                             'user_name' => $user_name,
        //                             'user_type' => $user->user_type,
        //                             'name' => $user->name,
        //                             'user_id' => $user_id,

        //                             'runners' => $runners,
        //                             'exposure' => $exposure
        //                         );
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }


        // $dataArray['profitLossDatas'] = $profitLossDatas;
        // // $dataArray['bookmakerProfitLossDatas'] = $bookmakerProfitLossDatas;
        // $self_pls = get_master_market_exposure_by_marketid($market_id, $master_user_id);
        // $upline_pls = get_master_upline_market_exposure_by_marketid($market_id, $master_user_id);




        // $dataArray['self_pls'] = $self_pls;
        // $dataArray['upline_pls'] = $upline_pls;

        // $dataArray['runners'] = $runners;
        // $user_type = $user_detail->user_type;


        // $dataArray['user_type'] = $user_type;
        // $dataArray['match_id'] = $match_id;

        // //        p($reports);
        // $bookmakerOddshtml = $this->load->viewPartial('/user-wise-profit-loss-html', $dataArray);







        echo json_encode(array('htmlData' => $matchOddshtml));
    }

    public function getEventTimer()
    {
        $event_id = $this->input->post('event_id');




        $response = get_casino_timer($event_id);


        $timer = 0;



        if ($event_id == '56768') {
            if (!empty($response->data)) {
                $timer = $response->data->t1[0]->autotime;
            }
        } else if ($event_id == '56767') {
            if (!empty($response->data)) {
                $timer = $response->data->bf[0]->lasttime;
            }
        } else if ($event_id == '98791') {
            if (!empty($response->data)) {

                $timer = $response->data->t1[0]->autotime;


                // p($timer);
            }
        } else if ($event_id == '98790') {
            if (!empty($response->data)) {
                $timer = $response->data->t1[0]->autotime;

                // p($timer);
            }
        } else if ($event_id == '56967') {
            if (!empty($response->data)) {
                $timer = $response->data->t1[0]->autotime;

                // p($timer);
            }
        }
        echo json_encode(array('timer' => $timer));
    }


    public function getBets()
    {

        $user_id = $_SESSION['my_userdata']['user_id'];
        $match_id = $this->input->post('event_id');
        $type = $this->input->post('type');
        $selection_id = $this->input->post('selection_id');

        $user_type = $_SESSION['my_userdata']['user_type'];

        $dataValues = array(
            'user_id' => $user_id,
            'match_id' => $match_id,
            'unmatch_bet' => 'No'
            // 'type' => $type,
            // 'selection_id' => $selection_id
        );
        $bettings = get_master_open_bets_list($dataValues);




        array_multisort(array_map('strtotime', array_column($bettings, 'created_at')), SORT_DESC, $bettings);

        $dataArray['bettings'] = $bettings;
        $exhangeHtml = $this->load->viewPartial('tv-betting-list-html', $dataArray);
        $data['bettingHtml'] = $exhangeHtml;



        echo json_encode($data);
    }


    public function changeBallRunningStatus()
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $event_id = $this->input->post('event_id');
        $status = $this->input->post('status');


        $this->Event_model->addEvents(array(
            'event_id' => $event_id,
            'is_ball_running' => $status,

        ));


        $data = array(
            'success' => true
        );
        echo json_encode($data);
    }

    public function deleteBet()
    {

        $betting_id = $this->input->post('betting_id');


        $betting_detail  = $this->Betting_model->get_betting_by_betting_id($betting_id);



        if (!empty($betting_detail)) {
            if ($betting_detail['unmatch_bet'] == 'Yes') {
                $this->Betting_model->delete_bet_by_id($betting_detail['betting_id']);
                $data = array(
                    'success' => true,
                    'message' => 'Unmatch Bet deleted successfully'
                );
            } else {
                $data = array(
                    'success' => false,
                    'message' => 'Match Bet not deleted'
                );
            }
        }
        echo json_encode($data);
    }


    public function getUnmatchBets()
    {

        $user_id = $_SESSION['my_userdata']['user_id'];
        $match_id = $this->input->post('event_id');
        $type = $this->input->post('type');
        $selection_id = $this->input->post('selection_id');

        $user_type = $_SESSION['my_userdata']['user_type'];

        $dataValues = array(
            'user_id' => $user_id,
            'match_id' => $match_id,
            'unmatch_bet' => 'Yes'
            // 'type' => $type,
            // 'selection_id' => $selection_id
        );
        $bettings = get_master_open_bets_list($dataValues);




        array_multisort(array_map('strtotime', array_column($bettings, 'created_at')), SORT_DESC, $bettings);

        $dataArray['bettings'] = $bettings;
        $exhangeHtml = $this->load->viewPartial('tv-betting-list-html', $dataArray);
        $data['bettingHtml'] = $exhangeHtml;



        echo json_encode($data);
    }

    public function get_live_animation_scoreboard()
    {
        $event_id = $this->input->post('event_id');

        echo json_decode(matchScore($event_id))->animation;
    }



    public function saveCasinoBet()
    {
        $user_id = $_SESSION['my_userdata']['user_id'];
        $stake = $this->input->post('stake');
        $loss = $this->input->post('loss');
        $profit = $this->input->post('profit');
        $price_val = $this->input->post('priceVal');
        $selection_id = $this->input->post('selectionId');
        $betting_type = $this->input->post('betting_type');
        $MarketId = $this->input->post('MarketId');
        $exposure1 = $this->input->post('exposure1');
        $exposure2 = $this->input->post('exposure2');
        $event_type = $this->input->post('event_type');

        $max_profit = max($exposure1, $exposure2);
        $max_loss = min($exposure1, $exposure2);
        $unmatch_bet = 'No';
        $p_l = $this->input->post('p_l');
        $matchId = $this->input->post('matchId');
        $user_type = get_user_type();
        $superior = get_superior_arr($user_id, $user_type);
        $is_back = $this->input->post('isback');

        $event_detail = $this->Event_model->get_event_by_event_id_for_betting($matchId);
        $user_detail = $this->User_model->getUserById($user_id);

        $balance = count_total_balance($user_id);



        if ($betting_type === 'Match') {

            $market_details = get_market_type_by_market_id(array(
                'event_id' => $matchId,
                'market_id' => $MarketId,
                'selection_id' => $selection_id
            ));


            if (!empty($market_details)) {
                $market_detail = $market_details['market_detail'];
                $runner_detail = $market_details['runner_details'];


                $exposure = (array) get_user_market_exposure_by_marketid($MarketId);

                // $exposure = $user_detail->exposure;

                $newexposureArr = $exposure;
                if (!empty($newexposureArr)) {
                    foreach ($newexposureArr as $key => $exp) {
                        if ($is_back == 1) {
                            if ($selection_id == $key) {
                                $newexposureArr[$key] += $profit;
                            } else {
                                $newexposureArr[$key] -= $loss;
                            }
                        } else {
                            if ($selection_id == $key) {
                                $newexposureArr[$key] -= $loss;
                            } else {
                                $newexposureArr[$key] += $profit;
                            }
                        }
                    }
                }



                if (!empty($exposure)) {

                    $minExposure = min($exposure);
                    $newexposure = min($newexposureArr);



                    if ($newexposure >= 0) {
                        $newexposure = 0;
                    } else {
                        $newexposure = abs($newexposure);
                    }
                    $minExposure = abs($minExposure);

                    $balance =  $balance + ($minExposure * 1);
                    $totalbalance = abs($newexposure);

                    if ($balance < $totalbalance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                } else {
                    if ($loss > $balance) {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Insufficient Balance'
                        );

                        echo json_encode($dataArray);
                        exit;
                    }
                }
            } else {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Market not matched'
                );

                echo json_encode($dataArray);
                exit;
            }
        }




        $user_details = $this->User_model->getUserByIdForBetting($user_id);



        if (!empty($user_details)) {
            if ($user_details->is_betting_open == 'No') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Betting Rights is closed'
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_details->is_locked == 'Yes') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Your account is locked by your superior.'
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_details->is_closed == 'Yes') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Your account is closed by your superior.'
                );
                echo json_encode($dataArray);
                exit;
            }


            if ($betting_type == 'Fancy') {
                $sport_id = 999;
            } else {
                $sport_id = $event_type;
            }



            if ($sport_id == '1001' || $sport_id == '1002' || $sport_id == '1003' || $sport_id == '1004' || $sport_id == '1005' || $sport_id == '1006' || $sport_id == '1007') {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 1000);
            } else if ($market_detail->market_name == 'Bookmaker') {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, 2000);

                if (!empty($user_info)) {



                    if ($user_info->is_bookmaker_active == 'No') {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Bookmaker Locked!'
                        );
                        echo json_encode($dataArray);
                        exit;
                    }
                }
            } else {
                $user_info = $this->User_info_model->get_user_info_by_userid($user_id, $sport_id);
            }




            if (!empty($user_info)) {



                // $market_odds_detail = $this->Market_book_odds_model->get_market_book_odds_by_market_id($MarketId);

                $market_details = get_market_type_by_market_id(array(
                    'event_id' => $matchId,
                    'market_id' => $MarketId,
                    'selection_id' => $selection_id
                ));
                // p($market_details);

                $market_odds_detail = $market_details['market_detail'];
                $market_detail = $market_details['market_detail'];

                $runner_detail = $market_details['runner_details'];


                if (!empty($market_odds_detail)) {
                    $market_odds_detail['inplay'] = 1;
                }

                $market_odds_detail_tmp = (array) $market_odds_detail;




                if ($betting_type == 'Match') {

                    if ($market_odds_detail->inplay == 1) {
                        if ($user_info->min_stake > $stake) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Min Stake allowed is: ' . $user_info->min_stake
                            );
                            echo json_encode($dataArray);
                            exit;
                        }

                        if ($user_info->max_stake < $stake) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Max Stake allowed is: ' . $user_info->max_stake
                            );
                            echo json_encode($dataArray);
                            exit;
                        }


                        if ($user_info->max_profit <  $max_profit) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Max Profit allowed is: ' . $user_info->max_profit
                            );
                            echo json_encode($dataArray);
                            exit;
                        }


                        // if ($user_info->max_loss <  abs($max_loss)) {
                        //     $dataArray = array(
                        //         'success' => false,
                        //         'message' => 'Max Loss allowed is: ' . abs($user_info->max_loss)
                        //     );

                        //     echo json_encode($dataArray);
                        //     exit;
                        // }

                        if ($user_info->lock_bet ==  "Yes") {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Betting Rights is locked'
                            );

                            echo json_encode($dataArray);
                            exit;
                        }

                        if ($user_info->min_odds > $price_val) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Minimum odds allowed is : ' . $user_info->min_odds
                            );

                            echo json_encode($dataArray);
                            exit;
                        }


                        if ($user_info->max_odds < $price_val) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Maximum odds allowed is : ' . $user_info->max_odds
                            );

                            echo json_encode($dataArray);
                            exit;
                        }


                        if (empty($market_odds_detail_tmp)) {
                            $dataArray = array(
                                'success' => false,
                                'message' => 'Something went wrong Market not matched'
                            );

                            echo json_encode($dataArray);
                            exit;
                        }


                        if (!empty($market_odds_detail_tmp)) {
                            if ($market_odds_detail_tmp['status'] != 'OPEN') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Something went wrong Bet Not placed'
                                );

                                echo json_encode($dataArray);
                                exit;
                            }
                        }


                        $sportBlockMarket = $this->Block_market_model->getBlockMarket(array(
                            'type' => 'Sport',
                            'event_type_id' => $event_type
                        ));



                        if (!empty($sportBlockMarket)) {
                            $master_id = $sportBlockMarket[0]['user_id'];

                            foreach ($sportBlockMarket as $block) {
                                if (in_array($block['user_id'], $superior)) {


                                    if ($_SESSION['my_userdata']['user_name'] != 'TEAM') {
                                        $dataArray = array(
                                            'success' => false,
                                            'message' => 'Sport Blocked Bet not placed!'
                                        );
                                        echo json_encode($dataArray);
                                        exit;
                                    }
                                }
                            }
                        }



                        $marketBlockMarket = $this->Block_market_model->getBlockMarket(array(
                            'type' => 'Market',
                            'market_id' => $MarketId
                        ));


                        if (!empty($marketBlockMarket)) {
                            $master_id = $sportBlockMarket[0]['user_id'];

                            foreach ($marketBlockMarket as $block) {
                                if (in_array($block['user_id'], $superior)) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Market Blocked Bet not placed!'
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }
                            }
                        }




                        $eventBlockMarket = $this->Block_market_model->getBlockMarket(array(
                            'type' => 'Event',
                            'event_id' => $matchId
                        ));

                        if (!empty($eventBlockMarket)) {
                            $master_id = $eventBlockMarket[0]['user_id'];

                            foreach ($eventBlockMarket as $block) {
                                if (in_array($block['user_id'], $superior)) {
                                    $dataArray = array(
                                        'success' => false,
                                        'message' => 'Event Blocked Bet not placed!'
                                    );
                                    echo json_encode($dataArray);
                                    exit;
                                }
                            }
                        }
                    }
                }




                sleep($user_info->bet_delay);



                if ($betting_type == 'Match') {
                    $data1 = array(
                        'market_id' => $this->input->post('MarketId'),
                        'event_id' => $this->input->post('matchId'),
                        'selection_id' => $selection_id
                    );

                    $is_back = $this->input->post('isback');




                    // $check_current_odds = $this->Event_model->check_active_odds($data1);

                    $check_current_odds =   isset($runner_detail[0]) ? $runner_detail[0] : array();



                    if ($check_current_odds['status'] != 'ACTIVE' && $check_current_odds['status'] != 'OPEN') {

                        $dataArray = array(
                            'success' => false,
                            'message' => 'Market Suspended'
                        );
                        echo json_encode($dataArray);
                        exit;
                    }




                    if (!empty($check_current_odds)) {



                        // if ($matchId == '56767') {
                        //     $back_price = (($check_current_odds['back_1_price'] / 100) + 1);
                        //     $lay_price = (($check_current_odds['lay_1_price'] / 100) + 1);
                        // } else {
                        //     $back_price = $check_current_odds['back_1_price'];
                        //     $lay_price = $check_current_odds['lay_1_price'];
                        // }
                        $back_price = $check_current_odds['back_1_price'];
                        $lay_price = $check_current_odds['lay_1_price'];


                        if ($is_back) {
                            //    if(get_user_id() )
                            if ($price_val > $back_price) {
                                // if ($market_detail->market_name != 'Bookmaker') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Unmatched Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                                // }
                            } else  if ($back_price >= $price_val) {
                                // if ($market_detail->market_name != 'Bookmaker') {

                                $price_val = $back_price;

                                $p_l = (($price_val * $stake) - $stake);
                                $profit = (($price_val * $stake) - $stake);
                                $loss = ($stake);
                                // }
                            }
                        }


                        // p($lay_price);
                        if ($is_back == 0) {
                            // $price_val = $lay_price;


                            if ($price_val < $lay_price) {
                                // if ($market_detail->market_name != 'Bookmaker') {
                                $dataArray = array(
                                    'success' => false,
                                    'message' => 'Unmatched Bet not allowed'
                                );
                                echo json_encode($dataArray);
                                exit;
                                // }
                                // $price_val = $lay_price;
                            } else {
                                // if ($market_detail->market_name != 'Bookmaker') {
                                $price_val = $lay_price;


                                $p_l = (($price_val * $stake) - $stake);
                                $profit = $stake;
                                $loss = (($price_val * $stake) - $stake);
                                // }
                            }
                        }
                    }
                }



                if (!empty($check_current_odds)) {
                } else {
                    $unmatch_bet = 'Yes';
                    // if ($market_detail->market_name != 'Bookmaker') {
                    if ($user_info->unmatch_bet == 'No') {
                        $dataArray = array(
                            'success' => false,
                            'message' => 'Unmatched Bet not allowed'
                        );
                        echo json_encode($dataArray);
                        exit;
                    }
                    // }
                }
            } else {
            }
        }


        if (empty($price_val)) {
            $dataArray = array(
                'success' => false,
                'message' => 'Invalid stake/odds.'
            );
            echo json_encode($dataArray);
            exit;
        }

        if ($price_val <= 0) {
            $dataArray = array(
                'success' => false,
                'message' => 'Invalid stake/odds.'
            );
            echo json_encode($dataArray);
            exit;
        }



        $betting_type = $this->input->post('betting_type');
        $dataArray = array(
            'match_id' => $this->input->post('matchId'),
            'selection_id' => $this->input->post('selectionId'),
            'is_back' => $this->input->post('isback'),
            'place_name' => $this->input->post('placeName'),
            'stake' => $this->input->post('stake'),
            'price_val' => $price_val,
            'p_l' => $p_l,
            'market_id' => $this->input->post('MarketId'),
            'user_id' => $_SESSION['my_userdata']['user_id'],
            'betting_type' => $this->input->post('betting_type'),
            'profit' => $profit,
            'loss' => $loss,
            'exposure_1' => $this->input->post('exposure1'),
            'exposure_2' => $this->input->post('exposure2'),
            'ip_address' =>  $_SERVER['REMOTE_ADDR'],
            'unmatch_bet' => $unmatch_bet,
            'competition_id' => !empty($event_detail->competition_id) ? $event_detail->competition_id : 0,
            'competition_name' => $event_detail->competition_name,
            'event_name' => $event_detail->event_name,
            'market_name' => $betting_type == 'Fancy' ? 'Fancy' : $market_detail->market_name,
            'runner_name' =>  $betting_type == 'Fancy' ? $price_val : $runner_detail->runner_name,
            'event_type' => $event_detail->event_type,
        );


        // p($dataArray,0);




        $betting_id =  $this->load->Betting_model->addBetting($dataArray);





        if ($betting_id) {
            $dataArray = array(
                'success' => true,
                'message' => 'Bet Placed Successfully'
            );
            echo json_encode($dataArray);
        }


        if ($betting_id) {

            $exposure = count_user_exposure($user_id);
            $balance = count_user_balance($user_id);;
            $data = array(
                'user_id' => get_user_id(),
                'exposure' =>  $exposure,
                'balance' =>  $balance,

            );


            $user_id = $this->User_model->addUser($data);
        }



        /**************************Get All Superior and save betting time settings*******  */

        log_message("MY_INFO", "Bet Place End");
    }
}
