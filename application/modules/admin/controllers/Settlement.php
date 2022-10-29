<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settlement extends My_Controller
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
        $this->load->model('Market_book_odds_runner_model');

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
        if (get_user_type() != 'Operator') {
            redirect('/');
        }
        $dataArray = array();
        $event_types = $this->Event_type_model->get_event_types(array(4));
        $dataArray['event_types'] = $event_types;
        $this->load->view('/event-type-list', $dataArray);
    }

    public function listevents($event_type = null)
    {
        if (get_user_type() != 'Operator') {
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


        if ($event_type == 4) {
            $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);
            $dataArray['event_name'] = $event_type_result->name;
            $dataArray['event_type'] = $event_type_result->event_type;
            $dataArray['event_type_id'] = $event_type_result->event_type_id;

            $data = array('event_type' => $event_type);
            $list_events = $this->Betting_model->get_unsettled_settlement_bets_events($data);
            $dataArray['list_events'] = $list_events;
            $this->load->view('/settlement-event-list', $dataArray);
        }
    }

    public function settlemenEventEntry($list_event_id = null)
    {
        if (get_user_type() != 'Operator') {
            redirect('/');
        }
        $dataArray = array();
        $list_event = $this->List_event_model->get_list_event_by_id($list_event_id);
        $event_type = $list_event->event_type;

        if ($event_type != 4) {
            exit;
        }
        $dataArray['event_name'] = $list_event->event_name;
        $dataArray['is_tie'] = $list_event->is_tie;

        $dataArray['winner_selection_id'] = $list_event->winner_selection_id;

        $event_id = $list_event->event_id;
        $event_type = $list_event->event_type;



        $market_types = $this->Market_type_model->get_market_type_by_event_id($event_id);

        if (!empty($market_types)) {
            foreach ($market_types as $key => $market_type) {
                $market_book_odds_runner = $this->Event_model->list_market_book_odds_runner(array('market_id' => $market_type->market_id));

                $market_types[$key]->runners = $market_book_odds_runner;
            }
        }
        $dataArray['market_types'] = $market_types;


        $market_book_odds_fancy = $this->Market_book_odds_fancy_model->get_fancy_by_match_id($event_id, false);


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
        $dataArray['event_type'] = $event_type;
        $match_odds_market = $this->Market_type_model->get_match_odds_mark_event_id($event_id);
        $match_odds_market_id = isset($match_odds_market->market_id) ? $match_odds_market->market_id : '';
        $dataArray['match_odds_market_id'] = $match_odds_market_id;

        $this->load->view('/settlement-event-form', $dataArray);
    }

    public function entrySubmit()
    {
        if (get_user_type() != 'Operator') {
            redirect('/');
        }

        $event_id = $this->input->post('event_id');
        $market_id = $this->input->post('market_id');
        $bet_type = $this->input->post('bet_type');
        $entry = $this->input->post('entry');
        $selection_id = $this->input->post('selection_id');

        $tmpArray = array();

        if ($bet_type === 'Match') {

            $runner_detail = $this->Market_book_odds_runner_model->get_runner(array(
                'event_id' => $event_id,
                'market_id' => $market_id,
                'selection_id' => $entry,

            ));

            $market_detail =  $this->Market_type_model->get_market_type_by_market_id(array(
                'event_id' => $event_id,
                'market_id' => $market_id,
            ));


            if(!empty($market_detail))
            {
                if($market_detail->settlement_status == 'Pending')
                {
                    echo json_encode(array('success' => false, 'htmlData' => '', 'message' => 'Already settling in progress'));
                    exit;
                }
            }



            $dataArray = array(
                'market_id' => $market_id,
                'event_id' => $event_id,
                'winner_selection_id' => $entry,
                'settlement_status' => 'Pending'
            );

            $this->Market_type_model->add_markets_winner_entry($dataArray);


            $dataArray = array(
                'market_id' => $market_id,
                'betting_type' => $bet_type,
            );
            $bettings = $this->Betting_model->get_all_bettings($dataArray);

            $total_profit = 0;
            $total_loss = 0;



            if (!empty($bettings)) {
                foreach ($bettings as $betting) {
                    $betting_id = $betting->betting_id;
                    $dataArray = array(
                        'betting_id' => $betting_id
                    );
                    $this->Ledger_model->disable_existing_bet($dataArray);

                    //If Selected team win then add profit
                    if ($betting->is_back == 1 && $betting->selection_id == $entry) {
                        $total_profit = $betting->profit;
                        $getUserDetail = $this->User_model->getUserById($betting->user_id);

                        $user_amt = $total_profit;


                        if($betting->is_tie == 'Yes')
                        {   

                            $profit = 0;
                            $loss = 0;

                            if($betting->is_back == 1)
                            {
                                    $profit = $betting->p_l;
                                    $loss = $betting->stake;

                            }
                            else
                            {
                                $profit = $betting->stake;
                                $loss = $betting->p_l;
                            }

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus',
                                'result_id' => $entry,
                                'profit' => $profit,
                                'loss' => $loss,
                                'is_tie' => 'No',
                                'result_name' => $runner_detail->runner_name,
                            );
                        }
                        else
                        {
                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus',
                                'result_id' => $entry,
                                'result_name' => $runner_detail->runner_name,
                            );
                        }
                     
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $ledger_id   =    betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);


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


                        if($betting->is_tie == 'Yes')
                        {   

                            $profit = 0;
                            $loss = 0;

                            if($betting->is_back == 1)
                            {
                                    $profit = $betting->p_l;
                                    $loss = $betting->stake;

                            }
                            else
                            {
                                $profit = $betting->stake;
                                $loss = $betting->p_l;
                            }

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus',

                                'result_id' => $entry,
                                'profit' => $profit,
                                'loss' => $loss,
                                'is_tie' => 'No',
                                'result_name' => $runner_detail->runner_name,

                            );
                        }
                        else
                        {
                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Minus',
                            'result_id' => $entry,
                            'result_name' => $runner_detail->runner_name,


                        );
                    }
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $ledger_id  = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);

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
                        

                        if($betting->is_tie == 'Yes')
                        {   

                            $profit = 0;
                            $loss = 0;

                            if($betting->is_back == 1)
                            {
                                    $profit = $betting->p_l;
                                    $loss = $betting->stake;

                            }
                            else
                            {
                                $profit = $betting->stake;
                                $loss = $betting->p_l;
                            }

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus',

                                'result_id' => $entry,
                                'profit' => $profit,
                                'loss' => $loss,
                                'is_tie' => 'No',
                                'result_name' => $runner_detail->runner_name,

                            );
                        }
                        else
                        {
                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Minus',
                            'result_id' => $entry,
                            'result_name' => $runner_detail->runner_name,


                        );
                    }
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $ledger_id  = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);


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



                        if($betting->is_tie == 'Yes')
                        {   

                            $profit = 0;
                            $loss = 0;

                            if($betting->is_back == 1)
                            {
                                    $profit = $betting->p_l;
                                    $loss = $betting->stake;

                            }
                            else
                            {
                                $profit = $betting->stake;
                                $loss = $betting->p_l;
                            }

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus',

                                'result_id' => $entry,
                                'profit' => $profit,
                                'loss' => $loss,
                                'is_tie' => 'No',
                                'result_name' => $runner_detail->runner_name,

                            );
                        }
                        else
                        {
                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Plus',
                            'result_id' => $entry,
                            'result_name' => $runner_detail->runner_name,
                        );
                    }
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $ledger_id  = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);


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



                    $tmpArray[] = array(
                        'betting_id' => $betting->betting_id,
                        'ledger_id' => $ledger_id,

                    );
                }
            }

            $dataArray = array(
                'market_id' => $market_id,
                'event_id' => $event_id,
                 'settlement_status' => 'Complete'
            );

            $this->Market_type_model->add_markets_winner_entry($dataArray);

        } else if ($bet_type === 'Fancy') {


            $dataArray = array(
                'match_id' => $event_id,
                'selection_id' => $selection_id
            );

            $fancy_detail = $this->Market_book_odds_fancy_model->get_fancy_detail($dataArray);


            if (!empty($fancy_detail)) {

                if ($fancy_detail['settlement_status'] == 'Pending') {
                    echo json_encode(array('success' => false, 'htmlData' => '', 'message' => 'Already settling in progress'));
                    exit;
                }
            }

            $dataArray = array(
                'match_id' => $event_id,
                'selection_id' => $selection_id,
                'result' => $entry,
                'settlement_status' => 'Pending'
            );
            $this->Market_book_odds_fancy_model->addFancyResult($dataArray);

            $dataArray = array(
                'match_id' => $event_id,
                'betting_type' => 'Fancy',
                'selection_id' => $selection_id,
                // 'status' => 'Open'
            );

            $bettings = $this->Betting_model->get_all_bettings($dataArray);

            if (!empty($bettings)) {
                foreach ($bettings as $betting) {
                    $betting_id = $betting->betting_id;
                    $dataArray = array(
                        'betting_id' => $betting_id
                    );
                    $this->Ledger_model->disable_existing_bet($dataArray);

                    if ($betting->is_back == 1) {
                        if ($betting->price_val <= $entry) {
                            //plus
                            $total_profit = $betting->profit;
                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus',
                                'result_id' => $entry,
                                'result_name' => $entry,
                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $ledger_id  = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $selection_id);


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

                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus',
                                'result_id' => $entry,
                                'result_name' => $entry,

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $ledger_id  = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $selection_id);

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
                    } else {
                        if ($betting->price_val > $entry) {
                            //Plus
                            //plus
                            $total_profit = $betting->profit;
                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus',
                                'result_id' => $entry,
                                'result_name' => $entry,

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $ledger_id  = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $selection_id);

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
                            //Minus
                            $total_profit = $betting->loss;
                            // $total_profit = $betting->profit;
                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus',
                                'result_id' => $entry,
                                'result_name' => $entry,

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $ledger_id  = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $selection_id);

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

                    $tmpArray[] = array(
                        'betting_id' => $betting->betting_id,
                        'ledger_id' => $ledger_id,

                    );
                }
            }


            $dataArray = array(
                'match_id' => $event_id,
                'selection_id' => $selection_id,
                'settlement_status' => 'Complete'
            );
            $this->Market_book_odds_fancy_model->addFancyResult($dataArray);
        }

        $htmlData = $this->load->viewPartial('/settlement-status-html', array('settledBets' => $tmpArray));


        echo json_encode(array('success' => true, 'htmlData' => $htmlData, 'message' => 'Bet Settled Successfully'));
    }



    // public function eventTieToggle()
    // {
    //     $event_id = $this->input->post('event_id');
    //     $is_tie = $this->input->post('is_tie');
    //     $market_id = $this->input->post('market_id');

    //     $event_detail = $this->Event_model->get_event_by_event_id($event_id);

    //     if(!empty($event_detail))
    //     {
    //         if ($event_detail->settlement_status == 'Pending') {
    //             echo json_encode(array('success' => false, 'htmlData' => '', 'message' => 'Already settling in progress'));
    //             exit;
    //         }
    //     }


    //     if ($is_tie == 'Yes') {
    //         $is_tie = 'No';
    //     } else {
    //         $is_tie = 'Yes';
    //     }
    //     $dataArray = array(
    //         'is_tie' => $is_tie,
    //         'event_id' => $event_id,
    //         'settlement_status' => 'Pending'

    //     );
    //     $this->Event_model->addEvents($dataArray);

    //     $this->Betting_model->tie_bets_update(array(
    //         'match_id' => $event_id,
    //         'market_id' => $market_id,
    //     ));

    //     $bettings = $this->Betting_model->get_bettings_by_marketid($market_id);

    //     if (!empty($bettings)) {
    //         foreach ($bettings as $betting) {
    //             $this->Ledger_model->disable_existing_bet(array(
    //                 'betting_id' => $betting['betting_id'],
    //             ));


    //             if ($betting['status'] == 'Settled') {

    //                 if ($betting['bet_result'] == 'Plus') {

    //                     $user_details = $this->User_model->getUserById($betting['user_id']);

    //                     if (!empty($user_details)) {

    //                         $winnings = $user_details->winings - $betting['profit'];
    //                         $balance = $user_details->balance  - $betting['profit'];

    //                         $data = array(
    //                             'user_id' => $betting['user_id'],
    //                             'is_balance_update' =>  'Yes',
    //                             'is_exposure_update' =>  'Yes',
    //                             'is_winnings_update' =>  'Yes',

    //                         );
    //                         $user_id = $this->User_model->addUser($data);
    //                     }
    //                 } else  if ($betting->bet_result == 'Minus') {
    //                     $user_details = $this->User_model->getUserById($betting['user_id']);

    //                     if (!empty($user_details)) {

    //                         $winnings = $user_details->winings + $betting['loss'];
    //                         $balance = $user_details->balance  + $betting['loss'];

    //                         $data = array(
    //                             'user_id' => $betting['user_id'],
    //                             'is_balance_update' =>  'Yes',
    //                             'is_exposure_update' =>  'Yes',
    //                             'is_winnings_update' =>  'Yes',

    //                         );
    //                         $user_id = $this->User_model->addUser($data);
    //                     }
    //                 } else {
    //                     $user_details = $this->User_model->getUserById($betting['user_id']);

    //                     if (!empty($user_details)) {

    //                         $data = array(
    //                             'user_id' => $betting['user_id'],
    //                             'is_balance_update' =>  'Yes',
    //                             'is_exposure_update' =>  'Yes',
    //                             'is_winnings_update' =>  'Yes',
    //                         );
    //                         $user_id = $this->User_model->addUser($data);
    //                     }
    //                 }
    //             } else if ($betting->status == 'Open') {
    //                 $user_details = $this->User_model->getUserById($betting->user_id);

    //                 if (!empty($user_details)) {

    //                     $data = array(
    //                         'user_id' => $betting->user_id,
    //                         'is_balance_update' =>  'Yes',
    //                         'is_exposure_update' =>  'Yes',
    //                         'is_winnings_update' =>  'Yes',
    //                     );
    //                     $user_id = $this->User_model->addUser($data);
    //                 }
    //             }
    //         }
    //     }

    //     $dataArray = array(
    //          'event_id' => $event_id,
    //         'settlement_status' => 'Success'

    //     );
    //     $this->Event_model->addEvents($dataArray);

    // }

    public function eventUnlist()
    {
        if (get_user_type() != 'Operator') {
            redirect('/');
        }
        $event_id = $this->input->post('event_id');
        $is_tie = $this->input->post('is_tie');

        if ($is_tie == 'Yes') {
            $is_tie = 'No';
        } else {
            $is_tie = 'Yes';
        }
        $dataArray = array(
            'is_unlist' => $is_tie,
            'event_id' => $event_id,
        );
        $this->Event_model->addEvents($dataArray);
    }
}
