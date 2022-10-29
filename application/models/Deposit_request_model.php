<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deposit_request_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function addDepositRequest($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('id', $dataValues['id']);
                $this->db->update('deposit_request', $dataValues);
                $id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('deposit_request', $dataValues);
                $info_id = $this->db->insert_id();
            }

            return $info_id;
        }
    }

    public function get_deposite_req_ref_user($dataArray)
    {
        $return = NULL;
        $this->db->select('*');
        $this->db->from('deposit_request as e');
        $this->db->join('registered_users as u', 'u.user_id = e.user_id', 'left');
        $this->db->where('u.is_delete', 'No');
        $this->db->where('u.referral_code', $dataArray['referral_code']);
        $this->db->where('e.status', "Confirm");


        $query = $this->db->get();
        $return = $query->num_rows();
        return $return;
    }

    public function get_deposit_requests($master_id)
    {

        $this->db->select('d.*');
        $this->db->from('registered_users r');

        $this->db->join('deposit_request d', 'r.user_id = d.user_id ', 'left');
        $this->db->where('r.master_id', $master_id);
        $this->db->where('d.status', 'Request');

        $return = $this->db->get()->result_array();
        
        return $return;
    }

    public function get_pending_requests($dataArray)
    {
        $return = [];
        if ($dataArray['type'] == "Deposit") {
            $this->db->where('status', 'Request');
            $this->db->where('user_id', $dataArray['user_id']);
            $return = $this->db->get('deposit_request')->result_array();
        }
        if ($dataArray['type'] == "Withdraw") {
            $this->db->where('status', 'Request');
            $this->db->where('user_id', $dataArray['user_id']);
            $return = $this->db->get('withdraw_request')->result_array();
        }
        return $return;
    }

    public function checkReferenceIsUnique($dataArray)
    {

        $this->db->where('reference_code', $dataArray['reference_code']);
        $return = $this->db->get('deposit_request')->result_array();


        return $return;
    }
}
