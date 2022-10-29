<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bonus_lib
{

    private $_CI;
    private $bonus_setting;
    private $_systemOperations = array('VIEW', 'VIEW_ICON', 'EDIT', 'EDIT_ICON', 'COPY_ICON', 'DELETE', 'DELETE_ICON', 'OTHER_ICON', 'OTHER_TEXT', 'STATUS_ON_ICON', 'STATUS_OFF_ICON', 'SORT_ICON', 'VERIFY_ICON');

    public function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->model('Bonus_model');
        $this->_CI->load->model('Ledger_model');
        $this->_CI->load->model('User_model');
        $this->bonus_setting =  $this->_CI->Bonus_model->get_bonusSetting();
    }

    public function give_sign_up_all_bonus($user_id,$refer_id = null)
    {
        
        if (!empty($this->bonus_setting)) {
            $bonus_amount = $this->bonus_setting['signup_bonus'];
            $referer_bonus_amount = $this->bonus_setting['signup_referer_bonus'];
            $refered_user_name = "";

            // signup bonus amount to client
            if ($bonus_amount != 0 && $bonus_amount != "") {

                $user_id = $user_id;
                $user_detail = $this->_CI->User_model->getUserById($user_id);
                $user_name = $user_detail->name;
                $refered_user_name = $user_name;
                $master_id = $user_detail->master_id;

                $master_detail = $this->_CI->User_model->getUserById($master_id);
                $master_name = $master_detail->user_name;

                $dataArray = array(
                    'user_id' => $user_id,
                    'remarks' => 'Sign Up Bonus Deposited By ' . $master_name,
                    'transaction_type' => 'credit',
                    'amount' => $bonus_amount,
                    'type' => 'Bonus',
                    'sender_id' => $master_id,
                    'receiver_id' => $user_id
                );
                $this->_CI->Ledger_model->addLedger($dataArray);


                $dataArray = array(
                    'user_id' => $master_id,
                    'remarks' => 'Sign Up Bonus Deposited To ' . $user_name,
                    'transaction_type' => 'debit',
                    'amount' => $bonus_amount,
                    'type' => 'Bonus',
                    'sender_id' => $master_id,
                    'receiver_id' => $user_id
                );
                $this->_CI->Ledger_model->addLedger($dataArray);
            }

            // referral sign up  bonus
            if(!empty($refer_id))
            {
                if ($referer_bonus_amount != 0 && $referer_bonus_amount != "") {

                    $user_id = $refer_id;
                    $user_detail = $this->_CI->User_model->getUserById($user_id);
                    $user_name = $user_detail->name;
                    $master_id = $user_detail->master_id;
    
                    $master_detail = $this->_CI->User_model->getUserById($master_id);
                    $master_name = $master_detail->user_name;
    
                    $dataArray = array(
                        'user_id' => $user_id,
                        'remarks' => 'Referer Sign Up Bonus Deposited By ' . $master_name .'refered user ' . $refered_user_name,
                        'transaction_type' => 'credit',
                        'amount' => $referer_bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
    
    
                    $dataArray = array(
                        'user_id' => $master_id,
                        'remarks' => 'Referer Sign Up Bonus Deposited To ' . $user_name,
                        'transaction_type' => 'debit',
                        'amount' => $referer_bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
                }
            }
        }
    }

    public function give_deposit_bonus($dataValue)
    {
        if (!empty($this->bonus_setting)) {
            $client_first_deposit_bonus = $this->bonus_setting['client_first_deposit_bonus'];
            $client_other_deposit_bonus = $this->bonus_setting['client_other_deposit_bonus'];
            $referer_first_deposit_bonus = $this->bonus_setting['referer_first_deposit_bonus'];
            $referer_other_deposit_bonus = $this->bonus_setting['referer_other_deposit_bonus'];
            

            $user_id = $dataValue['user_id'];
            $deposit_amount = $dataValue['deposit_amount'];

                                  
            $user_detail = $this->_CI->User_model->getUserById($user_id);
            $user_name = $user_detail->name;
            $refered_user_name = $user_name;
            $master_id = $user_detail->master_id;

            $master_detail = $this->_CI->User_model->getUserById($master_id);
            $master_name = $master_detail->user_name;

            $deposit_count = $this->_CI->Ledger_model->count_deposit_by_user_id($user_id);
            if($deposit_count == 0)
            {
                // first deposit

                if ($client_first_deposit_bonus != 0 && $client_first_deposit_bonus != "") {
        
                    $bonus_amount = $deposit_amount * $client_first_deposit_bonus/100;

                    $dataArray = array(
                        'user_id' => $user_id,
                        'remarks' => 'First Deposit Bonus Deposited By ' . $master_name,
                        'transaction_type' => 'credit',
                        'amount' => $bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
    
    
                    $dataArray = array(
                        'user_id' => $master_id,
                        'remarks' => 'First Deposit Bonus Deposited To ' . $user_name,
                        'transaction_type' => 'debit',
                        'amount' => $bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
                }    
                
                $referral_code =   $user_detail->referral_code;

                if(!empty($referral_code))
                {
                    if ($referer_first_deposit_bonus != 0 && $referer_first_deposit_bonus != "") {
        
                        $user_detail = $this->_CI->User_model->getUserById($referral_code);
                        $user_name = $user_detail->name;
                        $refered_user_name = $user_name;
                        $master_id = $user_detail->master_id;
            
                        $master_detail = $this->_CI->User_model->getUserById($master_id);
                        $master_name = $master_detail->user_name;
                        $bonus_amount = $deposit_amount * $referer_first_deposit_bonus/100;
    
                        $dataArray = array(
                            'user_id' => $user_id,
                            'remarks' => 'Referer First Deposit Bonus Deposited By ' . $master_name .'for '.$refered_user_name ,
                            'transaction_type' => 'credit',
                            'amount' => $bonus_amount,
                            'type' => 'Bonus',
                            'sender_id' => $master_id,
                            'receiver_id' => $user_id
                        );
                        $this->_CI->Ledger_model->addLedger($dataArray);
        
        
                        $dataArray = array(
                            'user_id' => $master_id,
                            'remarks' => 'Referer First Deposit Bonus Deposited To ' . $user_name,
                            'transaction_type' => 'debit',
                            'amount' => $bonus_amount,
                            'type' => 'Bonus',
                            'sender_id' => $master_id,
                            'receiver_id' => $user_id
                        );
                        $this->_CI->Ledger_model->addLedger($dataArray);
                    }    
                }


            }else{
                // other deposits
                if ($client_other_deposit_bonus != 0 && $client_other_deposit_bonus != "") {
        
                    $bonus_amount = $deposit_amount * $client_other_deposit_bonus/100;

                    $dataArray = array(
                        'user_id' => $user_id,
                        'remarks' => 'Other Deposit Bonus Deposited By ' . $master_name,
                        'transaction_type' => 'credit',
                        'amount' => $bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
    
    
                    $dataArray = array(
                        'user_id' => $master_id,
                        'remarks' => 'Other Deposit Bonus Deposited To ' . $user_name,
                        'transaction_type' => 'debit',
                        'amount' => $bonus_amount,
                        'type' => 'Bonus',
                        'sender_id' => $master_id,
                        'receiver_id' => $user_id
                    );
                    $this->_CI->Ledger_model->addLedger($dataArray);
                }    
                
                $referral_code =   $user_detail->referral_code;

                if(!empty($referral_code))
                {
                    if ($referer_other_deposit_bonus != 0 && $referer_other_deposit_bonus != "") {
        
                        $user_detail = $this->_CI->User_model->getUserById($referral_code);
                        $user_name = $user_detail->name;
                        $refered_user_name = $user_name;
                        $master_id = $user_detail->master_id;
            
                        $master_detail = $this->_CI->User_model->getUserById($master_id);
                        $master_name = $master_detail->user_name;
                        $bonus_amount = $deposit_amount * $referer_other_deposit_bonus/100;
    
                        $dataArray = array(
                            'user_id' => $user_id,
                            'remarks' => 'Referer Other Deposit Bonus Deposited By ' . $master_name .'for '.$refered_user_name ,
                            'transaction_type' => 'credit',
                            'amount' => $bonus_amount,
                            'type' => 'Bonus',
                            'sender_id' => $master_id,
                            'receiver_id' => $user_id
                        );
                        $this->_CI->Ledger_model->addLedger($dataArray);
        
        
                        $dataArray = array(
                            'user_id' => $master_id,
                            'remarks' => 'Referer Other Deposit Bonus Deposited To ' . $user_name,
                            'transaction_type' => 'debit',
                            'amount' => $bonus_amount,
                            'type' => 'Bonus',
                            'sender_id' => $master_id,
                            'receiver_id' => $user_id
                        );
                        $this->_CI->Ledger_model->addLedger($dataArray);
                    }    
                }


            }
            // signup bonus amount to client
          
        } 
    }
}
