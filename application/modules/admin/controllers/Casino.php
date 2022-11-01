<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Casino extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->model('Casino_event_model');
        $this->load->model('Favourite_event_model');

        $this->load->model('User_chip_model');
        $this->load->model('User_info_model');
        $this->load->model('Betting_model');
        $this->load->model('Masters_betting_settings_model');
        $this->load->model('Market_type_model');
        $this->load->model('User_model');
        $this->load->model('Event_model');
        $this->load->model('Ledger_model');


        // if (empty($userdata)) {
        //     redirect('/');
        // }
    }

    function index($game_type = null)
    {
        
        $userdata = $_SESSION['my_userdata'];
        $user_id = $userdata['user_id'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );
     
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
        }
       
        $get_casino_event_type = getCustomConfigItem('casino_event_type');
        // p($block_markets);
        if (!empty($block_markets)) {

            foreach ($block_markets as $block_market) {
                if ($block_market['event_type_id'] == $get_casino_event_type[$game_type]) {
                    redirect('/');
                }
            }
        }



        $dataArray['local_js'] = array(
            'jquery.validate',
        );



        //  $data['event_id'] = $match_id;
        $data['event_short_name'] = $game_type;
        $list_event = $this->Casino_event_model->list_event($data);

        if (!empty($list_event)) {
            $match_id = $list_event['event_id'];
            $event_type = isset($list_event['event_type']) ? $list_event['event_type'] : 0;
            $event_id = $list_event['event_id'];

            $exchangeData = array();
            $exchangeData[$event_id] = $list_event;
            $user_id = $_SESSION['my_userdata']['user_id'];
            $market_types = $this->Casino_event_model->list_market_types(array('event_id' => $list_event['event_id']));

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
                    $runners = $this->Casino_event_model->list_market_book_odds_runner(array(
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
                        $exposure = get_master_market_exposure_by_marketid($market_id);

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
                        $exposure = get_master_market_exposure_by_marketid($market_id);

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
                        $exposure = get_master_market_exposure_by_marketid($market_id);

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
                        $exposure = get_master_market_exposure_by_marketid($market_id);

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
            }


            $dataArray['events'] = $exchangeData;

            $marketExchangeHtml = $this->load->viewPartial('casinoExchangeHtml', $dataArray);

            $fancyExchangeHtml = '';

            $dataArray['marketExchangeHtml'] = $marketExchangeHtml;
            $dataArray['fancyExchangeHtml'] = $fancyExchangeHtml;


            // echo json_encode($dataArray);

            $chips = $this->User_chip_model->getUserChips($user_id);
            $dataArray['chips'] = $chips;
            $dataArray['event_id'] = $match_id;

            $get_casino_event_type = getCustomConfigItem('casino_event_type');

            $dataArray['event_type'] = $get_casino_event_type[$game_type];
            $user_type = get_user_type();
            $superior = get_superior_arr($user_id, $user_type);
            $dataArray['superiors']  = json_encode($superior);
            $video_arr = getCustomConfigItem('casino_games_video');
            $dataArray['videoLink'] = $video_arr[$game_type];

            $this->load->view('casinoEventDetail', $dataArray);
        }
    }



    public function addEvents($game_type)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://128.199.232.246:3000/v1-api/demo/getCasino/ltp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);


        if (!empty($data->result)) {
            $results = $data->result;

            foreach ($results as $result) {

                $dataArray = array(
                    'competition_id' => 0,
                    'event_type' => $result->gameType,
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
                $this->Casino_event_model->addEvents($dataArray);


                $dataArray = array(
                    'event_id' => $result->gameId,
                    'market_name' => $result->marketHeader,
                    'market_id' => $result->_id,
                    'market_start_time' => '',
                    'total_matched' => '',
                );

                $this->Casino_event_model->addMarketTypes($dataArray);


                $dataArray = array(
                    'market_id' => $result->_id,
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
                $market_book_odd_id =   $this->Casino_event_model->addMarketBookOdds($dataArray);

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

                        $this->Casino_event_model->addMarketBookOddsRunners($dataArray);
                    }
                }
            }
        }
    }

    public function savebet()
    {
        $user_id = $_SESSION['my_userdata']['user_id'];
        $balance = count_total_balance($user_id);
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

        if ($betting_type === 'Match') {
            $exposure = get_user_market_exposure_by_marketid($MarketId);

            if (!empty($exposure)) {
                $newexposure = 0;
                if ($exposure1 < 0 && $exposure1 < $exposure2) {
                    $newexposure = $exposure1;
                } else if ($exposure2 < 0 && $exposure2 < $exposure1) {
                    $newexposure = $exposure2;
                }

                $minExposure = min($exposure);


                $newexposure = abs($newexposure);
                $minExposure = abs($minExposure);
                $balance = $minExposure + $balance;

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
            if ($loss > $balance) {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Insufficient Balance'
                );

                echo json_encode($dataArray);
                exit;
            }
        }




        $user_details = $this->User_model->getUserById($user_id);

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
        }






        $dataArray = array(
            'match_id' => $this->input->post('matchId'),
            'selection_id' => $this->input->post('selectionId'),
            'is_back' => $this->input->post('isback'),
            'place_name' => $this->input->post('placeName'),
            'stake' => $this->input->post('stake'),
            'price_val' => $price_val,
            'round_id' => $this->input->post('round_id'),
            'p_l' => $p_l,
            'market_id' => $this->input->post('MarketId'),
            'user_id' => $_SESSION['my_userdata']['user_id'],
            'betting_type' => $this->input->post('betting_type'),
            'profit' => $profit,
            'loss' => $loss,
            'exposure_1' => $this->input->post('exposure1'),
            'exposure_2' => $this->input->post('exposure2'),
            'ip_address' =>  $_SERVER['REMOTE_ADDR'],
            'unmatch_bet' => $unmatch_bet
        );
        // p($dataArray['exchange_response']);
        $betting_id =  $this->load->Betting_model->addBetting($dataArray);

        if ($betting_id) {
            $dataArray = array(
                'success' => true,
                'message' => 'Bet Placed Successfully'
            );
            echo json_encode($dataArray);
        }


        /**************************Get All Superior and save betting time settings*******  */
        $userDetail = $this->User_model->getUserById($user_id);

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
                'created_at' => date('Y-m-d H:i:s')
            );
            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
            /*************Users**************** */


            if (!empty($setting_id)) {
                /*************Masters**************** */

                $master_id = get_master_id();
                $masterDetail = $this->User_model->getUserById($master_id);
                if (!empty($masterDetail)) {
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

                    );
                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                    /*************Masters**************** */

                    /*************Super Master**************** */

                    if (!empty($setting_id)) {
                        $super_master_id = $masterDetail->master_id;
                        $superMasterDetail = $this->User_model->getUserById($super_master_id);
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

                            );
                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                            /*************Super Master**************** */

                            /*************Hyper Super Master**************** */

                            if (!empty($setting_id)) {
                                $hyper_super_master_id = $superMasterDetail->master_id;
                                $hyperSuperMasterDetail = $this->User_model->getUserById($hyper_super_master_id);
                                if (!empty($hyperSuperMasterDetail)) {
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

                                    );
                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                    /*************Hyper Super Master**************** */

                                    /*************Admnin**************** */
                                    if (!empty($setting_id)) {
                                        $admin_id = $hyperSuperMasterDetail->master_id;
                                        $adminDetail = $this->User_model->getUserById($admin_id);
                                        if (!empty($adminDetail)) {
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

                                            );
                                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                            /*************Admnin**************** */

                                            /*************Super Admin**************** */

                                            if (!empty($setting_id)) {
                                                $super_admin_id = $adminDetail->master_id;
                                                $superAdminDetail = $this->User_model->getUserById($super_admin_id);
                                                if (!empty($adminDetail)) {
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
        /**************************Get All Superior and save betting time settings*******  */
    }

    public function casinoBetSettle($game_type)
    {

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
        } else if ($game_type == 'ab') {
            $tmp_game_type = 'andarbahar';
        } else if ($game_type == 'aaa') {
            $tmp_game_type = 'amar';
        } else {
            $tmp_game_type = $game_type;
        }

        // $response = getCasinoResultData($tmp_game_type);

        $response = '{"type":"teen20","success":true,"data":[{"createdBy":"2sgamix","marketHeader":"Match odds","roundId":"10180071","indexCard":[],"hash":"ajidsfvli.uad","salt":"","_id":"60bd06cead111c7824bdfed4","gameId":"56768","marketRunner":[{"cards":["H4","C10","S2"],"type":"plain","back":[],"lay":[],"id":"76766","name":"Player A","sortPriority":1,"pl":0,"status":"LOSER","resDesc":""},{"cards":["C12","S10","H11"],"type":"plain","back":[],"lay":[],"id":"76767","name":"Player B","sortPriority":2,"pl":0,"status":"WINNER","resDesc":"STRAIGHT"}],"gameType":"teenpatti","gameSubType":"T20","runnerType":"plain","stage":0,"timer":4,"createdAt":"2021-06-06T17:33:02.894Z","updatedAt":"2021-06-06T17:34:17.052Z","__v":0,"marketValidity":1623000864,"status":"CLOSED","matchName":"Teenpatti T20"},{"createdBy":"2sgamix","marketHeader":"Pair Plus","roundId":"10180071","indexCard":[],"hash":"ajidsfvli.uad","salt":"","_id":"60bd06cead111c7824bdfed5","gameId":"56768","marketRunner":[{"cards":["H4","C10","S2"],"type":"plus","back":[],"lay":[],"id":"76768","name":"Player A+","sortPriority":1,"pl":0,"status":"LOSER","resDesc":""},{"cards":["C12","S10","H11"],"type":"plus","back":[],"lay":[],"id":"76769","name":"Player B+","sortPriority":2,"pl":0,"status":"WINNER","resDesc":"STRAIGHT"}],"gameType":"teenpatti","gameSubType":"T20","runnerType":"plus","stage":0,"timer":4,"createdAt":"2021-06-06T17:33:02.899Z","updatedAt":"2021-06-06T17:34:17.057Z","__v":0,"marketValidity":1623000864,"status":"CLOSED","matchName":"Teenpatti T20"}]}';


         $data = json_decode($response);
        $results = $data->data;

         foreach ($results as $result) {
            $market_id = $result->_id;
            $marketRunners = $result->marketRunner;
            $bettings = $this->Betting_model->get_casino_open_bets_by_marketid(array('market_id' => $market_id));

           
            foreach ($bettings as $betting) {

                $selection_id = $betting->selection_id;
                foreach ($marketRunners as $marketRunner) {



                    if ($betting->place_name == 'Player A+' || $betting->place_name == 'Player B+') {



                        if ($marketRunner->status == 'WINNER') {

                            $dataArray = array(
                                'market_id' => $market_id,
                                'event_id' => $betting->match_id,
                                'winner_selection_id' => $marketRunner->id,
                            );
                            $this->Market_type_model->add_markets_winner_entry($dataArray);
                        }

                        $entry = $marketRunner->id;


                        $total_profit = 0;
                        $total_loss = 0;

                        if ($entry == $betting->selection_id) {



                            if ($marketRunner->status == 'WINNER') {
                                $total_profit = $betting->profit;

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Plus',
                                    'result_id' => $entry,
                                    'result_name' => $marketRunner->name,


                                );

                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);

                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit + $user_amt;
                                            $balance = $user_details->balance  - $betting->profit + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss + $user_amt;
                                            $balance = $user_details->balance  + $betting->loss + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings + $user_amt;
                                        $balance = $user_details->balance + $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            } else {
                                $total_profit = $betting->loss;

                                // $total_profit = $betting->profit;
                                $getUserDetail = $this->User_model->getUserById($betting->user_id);

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Minus',



                                );
                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);
                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit - $user_amt;
                                            $balance = $user_details->balance  - $betting->profit - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
        
                                        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss - $user_amt;
                                            $balance = $user_details->balance  + $betting->loss - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
        
                                             $user_id = $this->User_model->addUser($data);
        
                                         }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings - $user_amt;
                                        $balance = $user_details->balance - $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            }
                        }
                    } else {

                         if ($marketRunner->status == 'WINNER') {

                            $dataArray = array(
                                'market_id' => $market_id,
                                'event_id' => $betting->match_id,
                                'winner_selection_id' => $marketRunner->id,
                            );
                            $this->Market_type_model->add_markets_winner_entry($dataArray);


                            $entry = $marketRunner->id;


                            $total_profit = 0;
                            $total_loss = 0;

                           
                            if ($betting->is_back == 1 && $betting->selection_id == $entry) {
                                $total_profit = $betting->profit;

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Plus',
                                    'result_id' => $entry,
                                    'result_name' => $marketRunner->name,


                                );

                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);

                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit + $user_amt;
                                            $balance = $user_details->balance  - $betting->profit + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss + $user_amt;
                                            $balance = $user_details->balance  + $betting->loss + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings + $user_amt;
                                        $balance = $user_details->balance + $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            } else if ($betting->is_back == 0 && $betting->selection_id == $entry) {
                                $total_profit = $betting->loss;

                                // $total_profit = $betting->profit;
                                $getUserDetail = $this->User_model->getUserById($betting->user_id);

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Minus',
                                    'result_id' => $entry,
                                    'result_name' => $marketRunner->name,


                                );
                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);
                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit - $user_amt;
                                            $balance = $user_details->balance  - $betting->profit - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
        
                                        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss - $user_amt;
                                            $balance = $user_details->balance  + $betting->loss - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
        
                                             $user_id = $this->User_model->addUser($data);
        
                                         }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings - $user_amt;
                                        $balance = $user_details->balance - $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            } else if ($betting->is_back == 1 && $betting->selection_id != $entry) {
                                $total_profit = $betting->loss;

                                // $total_profit = $betting->profit;
                                $getUserDetail = $this->User_model->getUserById($betting->user_id);

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Minus',
                                    'result_id' => $entry,
                                    'result_name' => $marketRunner->name,
                                );


                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);

                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit - $user_amt;
                                            $balance = $user_details->balance  - $betting->profit - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
        
                                        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss - $user_amt;
                                            $balance = $user_details->balance  + $betting->loss - $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
        
                                             $user_id = $this->User_model->addUser($data);
        
                                         }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings - $user_amt;
                                        $balance = $user_details->balance - $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            } else if ($betting->is_back == 0 && $betting->selection_id != $entry) {
                                $total_profit = $betting->profit;
                                $getUserDetail = $this->User_model->getUserById($betting->user_id);

                                $user_amt = $total_profit;

                                $dataArray = array(
                                    'betting_id' => $betting->betting_id,
                                    'status' => 'Settled',
                                    'bet_result' => 'Plus',
                                    'result_id' => $entry,
                                    'result_name' => $marketRunner->name,


                                );
                                $this->Betting_model->addBetting($dataArray);
                                remove_dashboard_betting($betting->betting_id);

                                $betting_id = $betting->betting_id;
                                $dataArray = array(
                                    'betting_id' => $betting_id
                                );
                                $this->Ledger_model->disable_existing_bet($dataArray);

                                $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);

                                if ($betting->status == 'Settled') {

                                    if ($betting->bet_result == 'Plus') {
        
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings - $betting->profit + $user_amt;
                                            $balance = $user_details->balance  - $betting->profit + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    } else  if ($betting->bet_result == 'Minus') {
                                        $user_details = $this->User_model->getUserById($betting->user_id);
        
                                        if (!empty($user_details)) {
        
                                            $winnings = $user_details->winings + $betting->loss + $user_amt;
                                            $balance = $user_details->balance  + $betting->loss + $user_amt;
        
                                            $data = array(
                                                'user_id' => $betting->user_id,
                                                'is_balance_update' =>  'Yes',
                                                'is_exposure_update' =>  'Yes',
                                                'is_winnings_update' =>  'Yes',
        
                                            );
                                            $user_id = $this->User_model->addUser($data);
                                        }
                                    }
                                } else if ($betting->status == 'Open') {
                                    $user_details = $this->User_model->getUserById($betting->user_id);
        
                                    if (!empty($user_details)) {
        
                                        $winnings = $user_details->winings + $user_amt;
                                        $balance = $user_details->balance + $user_amt;
        
                                        $data = array(
                                            'user_id' => $betting->user_id,
                                            'is_balance_update' =>  'Yes',
                                            'is_exposure_update' =>  'Yes',
                                            'is_winnings_update' =>  'Yes',
        
                                        );
                                        $user_id = $this->User_model->addUser($data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    public function deleteOldCasinoData()
    {

        $events  = $this->Event_model->get_casino_events();

        if (!empty($events)) {
            foreach ($events as $event) {
                $date = date('Y-m-d H:i:s', strtotime('-1 hour'));
                $data = array(
                    'event_id' => $event['event_id'],
                    'datetime' => $date,

                );
                $this->Event_model->delete_market_book_odds($data);
                $this->Event_model->delete_market_types($data);
                $this->Event_model->delete_market_book_odds_runners($data);
            }
        }
        // p($events);
    }

    public function CreateJwtAndLaunchCasino()
    {
        $game = $this->input->post('game');

        if ($game == "lucky7") {
            $game = "lucky7a";
        } else if ($game == "lucky7eu") {
            $game = "lucky7b";
        } else if ($game == "dt20") {
            $game = "getdt";
        } else if ($game == "teenpatti/t20") {
            $game = "teen20";
        } else if ($game == "card32a") {
            $game = "get32a";
        } else if ($game == "card32b") {
            $game = "get32b";
        } else if ($game == "teenpatti/oneday") {
            $game = "odtp";
        } else if ($game == "teenpatti/test") {
            $game = "ttp";
        }

        $event_type_arr = getCustomConfigItem('diamond_casino_event_type');

        $event_type = $event_type_arr[$game];

        if (get_user_type() == 'User') {

            $block_markets = get_users_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Admin') {

            $block_markets = get_admin_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Hyper Super Master') {

            $block_markets = get_hyper_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Super Master') {
            $block_markets = get_super_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        } else if (get_user_type() == 'Master') {
            $block_markets = get_master_block_markets(array('user_id' => get_user_id(), 'type' => 'Sport'));
        }

        $is_blocked = false;

        foreach ($block_markets as $block_market) {
            if ($block_market['event_type_id'] == $event_type) {
                $is_blocked = true;
            }
        }


        if ($is_blocked == true) {
            $result = array(
                'message' => "Casino Blocked",
                'status' => "200"
            );
            echo json_encode($result);
            exit;
        } else {
            $payload = array(
                'username' => get_user_id(),
                'sitename' => 'http://maxcric247.bet/',
                'balance' => count_total_balance(get_user_id()),
                'is_react' => "No"
            );
            $game = $this->input->post('game');
            $jwt_token =  get_jwt_casino_token($payload);

            // $casino_link = "http://allcasino.zone/casino/" . $game . "/" . $jwt_token;
            $casino_link = "http://allcasino.zone/casino/" . $game . "/" . $jwt_token;
            // p($casino_link);
            $result = array(
                'message' => "success",
                'casino_link' => $casino_link,
                'status' => "200"
            );
            echo json_encode($result);
            exit;
        }
    }
}
