<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Withdraw_request_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function addWithdrawRequest($dataValues)
    {

        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {

                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('id', $dataValues['id']);
                $this->db->update('withdraw_request', $dataValues);
                // p($this->db->last_query());
                $info_id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('withdraw_request', $dataValues);
                $info_id = $this->db->insert_id();
            }
         
            return $info_id;
        }
        // p($this->db->last_query());
    }
    public function get_withdraw_requests($master_id)
    {

        $this->db->select('w.*');
        $this->db->from('registered_users r');

        $this->db->join('withdraw_request w', 'r.user_id = w.user_id ', 'left');
        $this->db->where('r.master_id', $master_id);
        $this->db->where('w.status', 'Request');

        $return = $this->db->get()->result_array();
        // p($this->db->last_query());
        return $return;
    }
}
