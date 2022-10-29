<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_deposit_transaction_history($user_id, $status = null, $where = null)
    {
        $this->db->select(' *,"Deposit" as payment_type');
        if (!empty($status) and $status != 'All') {
            $this->db->where('status', $status);
        }

        if (!empty($where)) {
            $this->db->where($where);
        } else {
            $this->db->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 month')));
            $this->db->where('created_at <=', date('Y-m-d H:i:s'));
        }

        $this->db->where('user_id', $user_id);
        return $this->db->get('deposit_request')->result_array();
        //    p($this->db->last_query());
    }

    public function get_deposit_transaction_history_admin($user_id, $status = null, $where = null,$client_id =null)
    {
        
        $this->db->select(' d.*,"Deposit" as payment_type ,r.name');
    

        $this->db->from('registered_users r');
        $this->db->join('deposit_request d', ' d.user_id = r.user_id', 'left');

        $this->db->where('r.master_id',$user_id);

        if (!empty($status) and $status != 'All') {
            $this->db->where('d.status', $status);
        }

        if (!empty($client_id)) {
            $this->db->where('d.user_id', $client_id);
        }

        if (!empty($where)) {
            $this->db->where($where);
        } else {
            $this->db->where('d.created_at >', date('Y-m-d H:i:s', strtotime('-1 month')));
            $this->db->where('d.created_at <=', date('Y-m-d H:i:s'));
        }
        return $this->db->get()->result_array();
           
    }

    public function get_withdraw_transaction_history($user_id, $status = null, $where = null)
    {
        $this->db->select(' *,"Withdraw" as payment_type');

        if (!empty($status and $status != 'All')) {
            $this->db->where('status', $status);
        }

        if (!empty($where)) {
            $this->db->where($where);
        } else {
            $this->db->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 month')));
            $this->db->where('created_at <=', date('Y-m-d H:i:s'));
        }

        $this->db->where('user_id', $user_id);
        return   $this->db->get('withdraw_request')->result_array();
    }
    public function get_withdraw_transaction_history_admin($user_id, $status = null, $where = null,$client_id = null)
    {
        $this->db->select(' w.*,"Withdraw" as payment_type ,r.name');

        if (!empty($status and $status != 'All')) {
            $this->db->where('w.status', $status);
        }


        if (!empty($client_id)) {
            $this->db->where('w.user_id', $client_id);
        }

        if (!empty($where)) {
            $this->db->where($where);
        } else {
            $this->db->where('w.created_at >', date('Y-m-d H:i:s', strtotime('-1 month')));
            $this->db->where('w.created_at <=', date('Y-m-d H:i:s'));
        }
        $this->db->from('registered_users r');        
        $this->db->join('withdraw_request w', ' r.user_id = w.user_id ', 'left');
        $this->db->where('r.master_id',$user_id);

        return   $this->db->get()->result_array();
    }

    public function get_all_admin_clients($user_id)
    {
        $this->db->select('user_id,name');
        $this->db->where('master_id', $user_id);
        return $this->db->get('registered_users')->result();
    }
}
