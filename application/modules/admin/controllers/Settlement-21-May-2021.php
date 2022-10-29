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
        $dataArray = array();
        $event_types = $this->Event_type_model->get_all_market_types();
        $dataArray['event_types'] = $event_types;
        $this->load->view('/event-type-list', $dataArray);
    }

    public function listevents($event_type = null)
    {
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
        //  array_multisort(array_map('strtotime', array_column($list_events, 'created_at')), SORT_DESC, $list_events);

        $dataArray['list_events'] = $list_events;

        $this->load->view('/settlement-event-list', $dataArray);
    }

    public function settlemenEventEntry($list_event_id = null)
    {
        $dataArray = array();
        $list_event = $this->List_event_model->get_list_event_by_id($list_event_id);
        $dataArray['event_name'] = $list_event->event_name;
        $dataArray['is_tie'] = $list_event->is_tie;

        $dataArray['winner_selection_id'] = $list_event->winner_selection_id;

        $event_id = $list_event->event_id;
        $event_type = $list_event->event_type;



        $market_types = $this->Market_type_model->get_market_type_by_event_id($event_id);

        if (!empty($market_types)) {
            foreach ($market_types as $key => $market_type) {
         $market_book_odds_runner = $this->Event_model->list_market_book_odds_runner(array('market_id'=> $market_type->market_id));
                
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

        $event_id = $this->input->post('event_id');
        $market_id = $this->input->post('market_id');
        $bet_type = $this->input->post('bet_type');
        $entry = $this->input->post('entry');
        $selection_id = $this->input->post('selection_id');


        if ($bet_type === 'Match') {
            // $dataArray = array(
            //     'selection_id' => $market_id
            // );
            // $this->Ledger_model->disable_existing_bet($dataArray);

            $dataArray = array(
                'match_id' => $event_id,
                'market_id' => $market_id
            );
            $betts = $this->Betting_model->get_all_betts($dataArray);
 
            if (!empty($betts)) {
                foreach($betts as $bet)
                {
                    $betting_id = $bet['betting_id'];
                    $dataArray = array(
                        'betting_id' => $betting_id
                    );
                    $this->Ledger_model->disable_existing_bet($dataArray);
                }
            }



            $dataArray = array(
                'market_id' => $market_id,
                'event_id' => $event_id,
                'winner_selection_id' => $entry,
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
                    //If Selected team win then add profit
                    if ($betting->is_back == 1 && $betting->selection_id == $entry) {
                        $total_profit = $betting->profit;
                        $getUserDetail = $this->User_model->getUserById($betting->user_id);

                        $user_amt = $total_profit;

                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Plus'

                        );
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);
                    } else if ($betting->is_back == 0 && $betting->selection_id == $entry) {
                        $total_profit = $betting->loss;

                        // $total_profit = $betting->profit;
                        $getUserDetail = $this->User_model->getUserById($betting->user_id);

                        $user_amt = $total_profit;

                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Minus'

                        );
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);
                    } else if ($betting->is_back == 1 && $betting->selection_id != $entry) {
                        $total_profit = $betting->loss;

                        // $total_profit = $betting->profit;
                        $getUserDetail = $this->User_model->getUserById($betting->user_id);

                        $user_amt = $total_profit;

                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Minus'

                        );
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $market_id);
                    } else if ($betting->is_back == 0 && $betting->selection_id != $entry) {
                        $total_profit = $betting->profit;
                        $getUserDetail = $this->User_model->getUserById($betting->user_id);

                        $user_amt = $total_profit;

                        $dataArray = array(
                            'betting_id' => $betting->betting_id,
                            'status' => 'Settled',
                            'bet_result' => 'Plus'

                        );
                        $this->Betting_model->addBetting($dataArray);
                        remove_dashboard_betting($betting->betting_id);

                        $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $market_id);
                    }
                }
            }
        } else if ($bet_type === 'Fancy') {
          
            $dataArray = array(
                'match_id' => $event_id,
                'selection_id' => $selection_id
            );
            $betts = $this->Betting_model->get_all_betts($dataArray);

            if (!empty($betts)) {
                foreach($betts as $bet)
                {
                    $betting_id = $bet['betting_id'];
                    $dataArray = array(
                        'betting_id' => $betting_id
                    );
                    $this->Ledger_model->disable_existing_bet($dataArray);
                }
            }



            $dataArray = array(
                'match_id' => $event_id,
                'selection_id' => $selection_id,
                'result' => $entry,
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
                    if ($betting->is_back == 1) {
                        if ($betting->price_val <= $entry) {
                            //plus
                            $total_profit = $betting->profit;
                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Plus'
                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $selection_id);
                        } else {
                            $total_profit = $betting->loss;

                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus'

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $selection_id);
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
                                'bet_result' => 'Plus'

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $master_amt = betting_ledger_maintain($betting->user_id, 'Credit', $user_amt, 0, $betting->place_name . ' (Profit)', 'User', $betting->betting_id, $selection_id);
                        } else {
                            //Minus
                            $total_profit = $betting->loss;
                            // $total_profit = $betting->profit;
                            $getUserDetail = $this->User_model->getUserById($betting->user_id);

                            $user_amt = $total_profit;

                            $dataArray = array(
                                'betting_id' => $betting->betting_id,
                                'status' => 'Settled',
                                'bet_result' => 'Minus'

                            );
                            $this->Betting_model->addBetting($dataArray);
                            remove_dashboard_betting($betting->betting_id);

                            $master_amt = betting_ledger_maintain($betting->user_id, 'Debit', $user_amt, 0, $betting->place_name . ' (Loss)', 'User', $betting->betting_id, $selection_id);
                        }
                    }
                }
            }
        }

        // echo json_encode(array('success' => true, 'message' => 'Bet Settled Successfully'));
    }


    public function chip_update()
    {
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        $passwordChips = $this->input->post('passwordChips');
        $ChipsValue = $this->input->post('ChipsValue');
        $chip_master_id = $this->input->post('chip_master_id');
        $chip_master_id = $chip_master_id != '' ? $chip_master_id : $_SESSION['my_userdata']['user_id'];

        $admin_chip = count_total_balance($chip_master_id);
        $user_chip = count_total_balance($user_id);

        if ($type == 'D') {
            $admin_new_chip = $admin_chip - $ChipsValue;
            $user_new_chip = $user_chip + $ChipsValue;
        } else {
            $admin_new_chip = $admin_chip + $ChipsValue;
            $user_new_chip = $user_chip - $ChipsValue;
        }


        $checkPassword = check_user_password($_SESSION['my_userdata']['user_name'], $passwordChips);

        if (empty($checkPassword)) {
            echo json_encode(array('error' => 'Password Not Match'));
        } else {
            if ($type == 'D') {
                $dataArray = array(
                    'user_id' => $user_id,
                    'remarks' => 'Free Chip Deposit By ' . $_SESSION['my_userdata']['name'],
                    'transaction_type' => 'credit',
                    'amount' => $ChipsValue,
                    'balance' =>  $user_new_chip
                );
                $this->Ledger_model->addLedger($dataArray);

                $dataArray = array(
                    'user_id' => $chip_master_id,
                    'remarks' => 'Free Chip Deposit To ' . $_SESSION['my_userdata']['name'],
                    'transaction_type' => 'debit',
                    'amount' => $ChipsValue,
                    'balance' =>  $admin_new_chip
                );
                $this->Ledger_model->addLedger($dataArray);
            } else {
                $dataArray = array(
                    'user_id' => $user_id,
                    'remarks' => 'Free Chip Withdrawl By ' . $_SESSION['my_userdata']['name'],
                    'transaction_type' => 'debit',
                    'amount' => $ChipsValue,
                    'balance' =>  $user_new_chip
                );
                $this->Ledger_model->addLedger($dataArray);

                $dataArray = array(
                    'user_id' => $chip_master_id,
                    'remarks' => 'Free Chip Withdrawl From ' . $_SESSION['my_userdata']['name'],
                    'transaction_type' => 'credit',
                    'amount' => $ChipsValue,
                    'balance' =>  $admin_new_chip
                );
                $this->Ledger_model->addLedger($dataArray);
            }

            echo json_encode(array('success' => true));
        }
    }

    // public function eventTieToggle()
    // {
    //     $event_id = $this->input->post('event_id');
    //     $is_tie = $this->input->post('is_tie');
    //     $market_id = $this->input->post('market_id');


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
    //         }
    //     }
    //     // $this->Ledger_model->disable_existing_bet(array(
    //     //     'selection_id' => $market_id,
    //     // ));
    // }

    public function eventUnlist()
    {
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
