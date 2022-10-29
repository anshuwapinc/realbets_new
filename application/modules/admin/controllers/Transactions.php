<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transactions extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Transaction_model');



        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    public function get_transaction_history($status = null)
    {

        $user_id = get_user_id();
        $transaction_data = array();
        $payment_type = "";

        if (!empty($this->input->post())) {
            $payment_type = $this->input->post('payment_type');
            $from_date = date('Y-m-d H:i:s', strtotime($this->input->post('fdate')));
            $end_date = date('Y-m-d ', strtotime($this->input->post('tdate'))) . date('H:i:s');
            $status = $this->input->post('status');

            $where = array(
                'created_at >' => $from_date,
                'created_at <=' => $end_date,
            );
            if ($payment_type == 'Deposit') {
                $transaction_data = $this->Transaction_model->get_deposit_transaction_history($user_id, $status, $where);
            } elseif ($payment_type == 'Withdraw') {

                $transaction_data = $this->Transaction_model->get_withdraw_transaction_history($user_id, $status, $where);
            } else {
                $deposit_data = $this->Transaction_model->get_deposit_transaction_history($user_id, $status, $where);
                $withdraw_data = $this->Transaction_model->get_withdraw_transaction_history($user_id, $status, $where);
                $transaction_data = array_merge($deposit_data, $withdraw_data);
            }
        } else {

            $deposit_data = $this->Transaction_model->get_deposit_transaction_history($user_id, $status);
            $withdraw_data = $this->Transaction_model->get_withdraw_transaction_history($user_id, $status);
            $transaction_data = array_merge($deposit_data, $withdraw_data);
        }

        array_multisort(array_map('strtotime', array_column($transaction_data, 'created_at')), SORT_DESC, $transaction_data);

        $dataArray['status'] = $status;
        $dataArray['payment_type'] = $payment_type;
        $dataArray['transaction_data'] = $transaction_data;
        $transaction_history_table = $this->load->viewPartial('/transaction-history-html', $dataArray);


        //final output
        if (!empty($this->input->post())) {

            echo $transaction_history_table;
        } else {

            $dataArray[$status] = "active";

            $dataArray['transaction_history_table'] = $transaction_history_table;
            $this->load->view('transaction-history', $dataArray);
        }
    }

    public function get_transaction_history_admin($status = null)
    {

        $user_id = get_user_id();
        $transaction_data = array();
        $payment_type = "";

        $clients = $this->Transaction_model->get_all_admin_clients($user_id);
        // p( $clients);
        if (!empty($this->input->post())) {
            $payment_type = $this->input->post('payment_type');
            $from_date = date('Y-m-d H:i:s', strtotime($this->input->post('fdate')));
            $end_date = date('Y-m-d ', strtotime($this->input->post('tdate'))) . date('H:i:s');
            $status = $this->input->post('status');
            $client_id = $this->input->post('client_id');

            if ($payment_type == 'Deposit') {

                $where = array(
                    'd.created_at >' => $from_date,
                    'd.created_at <=' => $end_date,
                );
                $transaction_data = $this->Transaction_model->get_deposit_transaction_history_admin($user_id, $status, $where, $client_id);
            } elseif ($payment_type == 'Withdraw') {

                $where = array(
                    'w.created_at >' => $from_date,
                    'w.created_at <=' => $end_date,
                );
                $transaction_data = $this->Transaction_model->get_withdraw_transaction_history_admin($user_id, $status, $where, $client_id);
            } else {

                $where = array(
                    'd.created_at >' => $from_date,
                    'd.created_at <=' => $end_date,
                );
                $deposit_data = $this->Transaction_model->get_deposit_transaction_history_admin($user_id, $status, $where, $client_id);

                $where = array(
                    'w.created_at >' => $from_date,
                    'w.created_at <=' => $end_date,
                );
                $withdraw_data = $this->Transaction_model->get_withdraw_transaction_history_admin($user_id, $status, $where, $client_id);
                $transaction_data = array_merge($deposit_data, $withdraw_data);
            }
        } else {

            $deposit_data = $this->Transaction_model->get_deposit_transaction_history_admin($user_id, $status);
            $withdraw_data = $this->Transaction_model->get_withdraw_transaction_history_admin($user_id, $status);
            $transaction_data = array_merge($deposit_data, $withdraw_data);
        }

        array_multisort(array_map('strtotime', array_column($transaction_data, 'created_at')), SORT_DESC, $transaction_data);

        $dataArray['status'] = $status;
        $dataArray['payment_type'] = $payment_type;
        $dataArray['transaction_data'] = $transaction_data;

        $transaction_history_table = $this->load->viewPartial('/transaction-history-html', $dataArray);


        //final output
        if (!empty($this->input->post())) {

            echo $transaction_history_table;
        } else {
            $dataArray['local_css'] = array('daterangepicker', 'select2');
            $dataArray['local_js'] = array('daterangepicker', 'select2');


            $dataArray[$status] = "active";
            $dataArray['clients'] = $clients;
            $dataArray['transaction_history_table'] = $transaction_history_table;
            $this->load->view('transaction-history-admin', $dataArray);
        }
    }

    function get_direct_transaction_history()
    {
        $payment_type = $this->input->post('payment_type');
        $user_id = get_user_id();

        if ($payment_type == "Deposit") {
            $transaction_data = $this->Transaction_model->get_deposit_transaction_history($user_id);
        } elseif ($payment_type == "Withdraw") {
            $transaction_data = $this->Transaction_model->get_withdraw_transaction_history($user_id);
        }

        // p($transaction_data);

        array_multisort(array_map('strtotime', array_column($transaction_data, 'created_at')), SORT_DESC, $transaction_data);
        $dataArray['status'] = "All";
        $dataArray['payment_type'] = $payment_type;
        $dataArray['transaction_data'] = $transaction_data;
        $transaction_history_table = $this->load->viewPartial('/transaction-history-html', $dataArray);

        echo $transaction_history_table;
    }

    public function get_direct_transaction_history_admins()
    {

        $user_id = get_user_id();
        $payment_type = $this->input->post('payment_type');
        $transaction_data = array();

        if ($payment_type == 'Deposit') {
            $transaction_data = $this->Transaction_model->get_deposit_transaction_history_admin($user_id);
        } elseif ($payment_type == 'Withdraw') {

            $transaction_data = $this->Transaction_model->get_withdraw_transaction_history_admin($user_id);
        }
        array_multisort(array_map('strtotime', array_column($transaction_data, 'updated_at')), SORT_DESC, $transaction_data);
        $dataArray['status'] = "All";
        $dataArray['payment_type'] = $payment_type;
        $dataArray['transaction_data'] = $transaction_data;
        
        // p($dataArray);
        
        $transaction_history_table = $this->load->viewPartial('/transaction-history-html', $dataArray);

        echo $transaction_history_table;
    }
}
