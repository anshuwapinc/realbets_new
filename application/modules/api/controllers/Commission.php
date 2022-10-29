<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Commission extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Masters_betting_settings_model');
        $this->load->model('Betting_model');
        $this->load->model('Ledger_model');

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
    }





    public function sessionCommissionUpdate()
    {
        $site_code = getCustomConfigItem('site_code');
        $events = $this->Betting_model->get_open_fancy_betting_events();


        if (!empty($events)) {
            foreach ($events as $event) {

                $userDetail = $this->User_model->getUserById($event['user_id']);


                if ($userDetail->site_code == $site_code) {
                    $dataArray = array(
                        'user_id' => $event['user_id'],
                        'match_id' => $event['match_id'],

                    );
                    $bettings = $this->Betting_model->get_fancy_bettings_by_event_id($dataArray);


                    $total_profit = 0;
                    $total_loss = 0;
                    $total_amt = 0;


                    if (!empty($bettings)) {
                        foreach ($bettings as $betting) {

                            if (!empty($betting['sessional_commission']) && $betting['sessional_commission'] != 0) {


                                $sessional_commision = $userDetail->sessional_commision;
                                $commission_amt = abs($betting['stake']) * $sessional_commision / 100;



                                $checkBettings = $this->Betting_model->get_fancy_bettings(array(
                                    'betting_id' =>  $betting['betting_id'],
                                    'is_fancy_commission_update' => 'No'
                                ));



                                if (!empty($checkBettings)) {
                                    $remarks = '';

                                    if ($betting['bet_result'] == 'Plus') {
                                        $remarks = 'Commission for Round ID: ' . $betting['betting_id'] . '/' . $betting['place_name'] . ' (Profit)';
                                    } else {
                                        $remarks = 'Commission for Round ID: ' . $betting['betting_id'] . ' / ' . $betting['place_name'] . ' (Loss)';
                                    }
                                    $dataArray = array(
                                        'user_id' => $betting['user_id'],
                                        'remarks' => $remarks,
                                        'transaction_type' => 'Credit',
                                        'amount' => $commission_amt,
                                        'balance' => '',
                                        'type' => 'Betting',
                                        'betting_id' => $betting['betting_id'],
                                        'selection_id' => $betting['selection_id'],
                                        'is_commission' => 'Yes'
                                    );
                                    $this->Ledger_model->addLedger($dataArray);


                                    $this->Betting_model->addBetting(
                                        array(
                                            'betting_id' => $betting['betting_id'],
                                            'is_fancy_commission_update' => 'Yes',
                                        )
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    public function matchCommissionUpdate()
    {

        $site_code = getCustomConfigItem('site_code');

        $events = $this->Betting_model->get_open_match_betting_events();

          if (!empty($events)) {
            foreach ($events as $event) {

                $checkEvents = $this->Betting_model->check_open_bets_total_by_marketid(array('market_id' => $event['market_id']));

 
                if ($checkEvents == 0) {
                    $userDetail = $this->User_model->getUserById($event['user_id']);

                    if ($userDetail->site_code == $site_code) {

                         if (!empty($event['master_commission']) && $event['master_commission'] != 0) {
 
                            $master_commission = $event['master_commission'];
                            $dataArray = array(
                                'user_id' => $event['user_id'],
                                'match_id' => $event['match_id'],

                            );
                            $bettings = $this->Betting_model->get_match_odds_bettings_by_event_id($dataArray);



 



                            if (!empty($bettings)) {

                                $total_profit = 0;
                                $total_loss = 0;
                                $total_amt = 0;

                                foreach ($bettings as $betting) {


                                    if ($betting['bet_result'] == 'Plus') {
                                        $total_profit += $betting['profit'];
                                    } else if ($betting['bet_result'] == 'Minus') {
                                        $total_loss += $betting['loss'];
                                    }

                                    $this->Betting_model->addBetting(
                                        array(
                                            'betting_id' => $betting['betting_id'],
                                            'is_match_commission_update' => 'Yes',
                                        )
                                    );
                                }

                                $total_amt = $total_profit - $total_loss;


 
                                if ($total_amt > 0) {

                                    $commission_amt = (abs($total_amt) * $master_commission) / 100;




                                    $remarks = '';


                                    $remarks = 'Commission for - ' . $betting['event_name'] . '(' . $betting['market_name'] . ')';

                                    $dataArray = array(
                                        'user_id' => $betting['user_id'],
                                        'remarks' => $remarks,
                                        'transaction_type' => 'Debit',
                                        'amount' => $commission_amt,
                                        'balance' => '',
                                        'type' => 'Betting',
                                        'betting_id' => $event['betting_id'],
                                        'selection_id' => $event['selection_id'],
                                        'is_commission' => 'Yes'
                                    );



                                    $this->Ledger_model->addLedger($dataArray);
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    // public function bookmakerCommissionUpdate()
    // {

    //     $events = $this->Betting_model->get_bookmaker_betting_events();

    //      if (!empty($events)) {
    //         foreach ($events as $event) {

    //             $userDetail = $this->User_model->getUserById($event['user_id']);

    //             if ($userDetail->site_code == 'P11') {
    //                 if (!empty($event['master_commission']) && $event['master_commission'] != 0) {

    //                     $master_commission = $event['master_commission'];
    //                     $dataArray = array(
    //                         'user_id' => $event['user_id'],
    //                         'match_id' => $event['match_id'],

    //                     );
    //                     $bettings = $this->Betting_model->get_bookmaker_bettings_by_event_id($dataArray);








    //                     if (!empty($bettings)) {

    //                         $total_profit = 0;
    //                         $total_loss = 0;
    //                         $total_amt = 0;

    //                         foreach ($bettings as $betting) {


    //                             if ($betting['bet_result'] == 'Plus') {
    //                                 $total_profit += $betting['profit'];
    //                             } else if ($betting['bet_result'] == 'Minus') {
    //                                 $total_loss += $betting['loss'];
    //                             }

    //                             $this->Betting_model->addBetting(
    //                                 array(
    //                                     'betting_id' => $betting['betting_id'],
    //                                     'is_bookmaker_commission_update' => 'Yes',
    //                                 )
    //                             );
    //                         }

    //                         $total_amt = $total_profit - $total_loss;


    //                         if ($total_amt < 0) {

    //                             $commission_amt = (abs($total_amt) * $master_commission) / 100;



    //                             $remarks = '';


    //                             $remarks = 'Commission for - ' . $betting['event_name'] . '(' . $betting['market_name'] . ')';

    //                             $dataArray = array(
    //                                 'user_id' => $betting['user_id'],
    //                                 'remarks' => $remarks,
    //                                 'transaction_type' => 'Credit',
    //                                 'amount' => $commission_amt,
    //                                 'balance' => '',
    //                                 'type' => 'Betting',
    //                                 'betting_id' => $event['betting_id'],
    //                                 'selection_id' => $event['selection_id'],
    //                                 'is_commission' => 'Yes'
    //                             );



    //                             $this->Ledger_model->addLedger($dataArray);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
}
