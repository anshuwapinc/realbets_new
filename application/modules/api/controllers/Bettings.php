<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bettings extends My_Controller
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




    public function addMastersBetting()
    {
        $bettings = $this->Betting_model->get_open_bets();


        if (!empty($bettings)) {
            foreach ($bettings as $betting) {
                $betting_id = $betting['betting_id'];
                $user_id = $betting['user_id'];
                $profit = $betting['profit'];
                $loss = $betting['loss'];

                $userDetail = $this->User_model->getUserById($user_id);


                if (!empty($userDetail)) {
                    $master_id = $userDetail->master_id;
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


                        $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                            'user_id' => $user_id,
                            'betting_id' => $betting_id,

                        ));

                        if (empty($check)) {
                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                        }

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

                                $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                                    'user_id' => $master_id,
                                    'betting_id' => $betting_id,

                                ));

                                if (empty($check)) {
                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                }
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

                                        $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                                            'user_id' => $super_master_id,
                                            'betting_id' => $betting_id,

                                        ));

                                        if (empty($check)) {
                                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                        }
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

                                                $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                                                    'user_id' => $hyper_super_master_id,
                                                    'betting_id' => $betting_id,

                                                ));

                                                if (empty($check)) {
                                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                                }
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

                                                        $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                                                            'user_id' => $admin_id,
                                                            'betting_id' => $betting_id,

                                                        ));

                                                        if (empty($check)) {
                                                            $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                                        }
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

                                                                $check = $this->Masters_betting_settings_model->get_betting_setting(array(
                                                                    'user_id' => $super_admin_id,
                                                                    'betting_id' => $betting_id,

                                                                ));

                                                                if (empty($check)) {

                                                                    $setting_id = $this->Masters_betting_settings_model->addBettingSetting($bettingSettingData);
                                                                }
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

                $dataArray = array(
                    "betting_id" => $betting_id,
                    "is_master_update" => "Yes",

                );
                $betting_id =  $this->load->Betting_model->addBetting($dataArray);
            }
        }
    }

    public function sessionCommissionUpdate()
    {

        $events = $this->Betting_model->get_fancy_betting_events();


        if (!empty($events)) {
            foreach ($events as $event) {

                $userDetail = $this->User_model->getUserById($event['user_id']);

                if ($userDetail->site_code == 'P11') {
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


    public function matchCommissionUpdate()
    {

        $events = $this->Betting_model->get_match_betting_events();

         if (!empty($events)) {
            foreach ($events as $event) {

                $userDetail = $this->User_model->getUserById($event['user_id']);

                if ($userDetail->site_code == 'P11') {
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


                            if ($total_amt < 0) {

                                $commission_amt = (abs($total_amt) * $master_commission) / 100;



                                $remarks = '';


                                $remarks = 'Commission for - ' . $betting['event_name'] . '(' . $betting['market_name'] . ')';

                                $dataArray = array(
                                    'user_id' => $betting['user_id'],
                                    'remarks' => $remarks,
                                    'transaction_type' => 'Credit',
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


    public function bookmakerCommissionUpdate()
    {

        $events = $this->Betting_model->get_bookmaker_betting_events();

         if (!empty($events)) {
            foreach ($events as $event) {

                $userDetail = $this->User_model->getUserById($event['user_id']);

                if ($userDetail->site_code == 'P11') {
                    if (!empty($event['master_commission']) && $event['master_commission'] != 0) {

                        $master_commission = $event['master_commission'];
                        $dataArray = array(
                            'user_id' => $event['user_id'],
                            'match_id' => $event['match_id'],

                        );
                        $bettings = $this->Betting_model->get_bookmaker_bettings_by_event_id($dataArray);


                       





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
                                        'is_bookmaker_commission_update' => 'Yes',
                                    )
                                );
                            }

                            $total_amt = $total_profit - $total_loss;


                            if ($total_amt < 0) {

                                $commission_amt = (abs($total_amt) * $master_commission) / 100;



                                $remarks = '';


                                $remarks = 'Commission for - ' . $betting['event_name'] . '(' . $betting['market_name'] . ')';

                                $dataArray = array(
                                    'user_id' => $betting['user_id'],
                                    'remarks' => $remarks,
                                    'transaction_type' => 'Credit',
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

    public function get_anim_url(){
        p(get_anim_url());
    }
}
