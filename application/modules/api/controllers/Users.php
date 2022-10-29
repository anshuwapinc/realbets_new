<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_model');
        $this->load->model('Betting_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
    }

    // Run In every 1 Sec
    public function userBalanceUpdate()
    {
        $users = $this->User_model->get_registered_users(array('is_balance_update' => 'Yes'));
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user['is_balance_update'] === 'Yes') {
                    $balance = count_user_balance($user['user_id']);
                    $dataArray = array(
                        'user_id' => $user['user_id'],
                        'balance' => $balance,
                        'is_balance_update' => 'No'
                    );
                    $this->User_model->addUser($dataArray);
                }
            }
        }
    }


    // Run In every 1 Sec
    public function userExposureUpdate()
    {
        $users = $this->User_model->get_registered_users(
            array('is_exposure_update' => 'Yes')
        );
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user['is_exposure_update'] === 'Yes' && $user['user_type'] === 'User') {
                    $exposure = count_user_exposure($user['user_id']);
                    $dataArray = array(
                        'user_id' => $user['user_id'],
                        'exposure' => $exposure,
                        'is_exposure_update' => 'No'
                    );
                    $this->User_model->addUser($dataArray);
                }
            }
        }
    }

    // Run In every 1 Sec
    public function userWinningsUpdate()
    {
        $users = $this->User_model->get_registered_users(array('is_winnings_update' => 'Yes'));
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user['is_winnings_update'] === 'Yes' && $user['user_type'] === 'User') {
                    $winnings = count_user_winnings($user['user_id']);
                    $dataArray = array(
                        'user_id' => $user['user_id'],
                        'winnings' => $winnings,
                        'is_winnings_update' => 'No'
                    );
                    $this->User_model->addUser($dataArray);
                }
            }
        }
    }


    // Run In every 1 Sec
    public function userCreditLimitUpdate()
    {
        $users = $this->User_model->get_registered_users(array('is_credit_limit_update' => 'Yes'));
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user['is_credit_limit_update'] === 'Yes') {
                    $credit_limit = count_user_credit_limit($user['user_id']);
                    $dataArray = array(
                        'user_id' => $user['user_id'],
                        'credit_limit' => $credit_limit,
                        'is_credit_limit_update' => 'No'
                    );
                    $this->User_model->addUser($dataArray);
                }
            }
        }
    }
}
