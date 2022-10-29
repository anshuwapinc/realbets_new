<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PaymentMethods_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_payment_detail($master_id,$type)
    {

        $this->db->select('*');
        $this->db->from('user_payment_methods');
        $this->db->where('user_id', $master_id);
        $this->db->where('type', $type);        
          $this->db->where('status', 'Active');
        $return = $this->db->get()->row();
        return $return;
    }

    public function get_payment_methods($user_id)
    {
        $this->db->select('*');
        $this->db->from('user_payment_methods');
        $this->db->where('user_id', $user_id);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_payment_method($payment_id)
    {
        $this->db->select('*');
        $this->db->from('user_payment_methods');
        $this->db->where('id', $payment_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function addPaymentMethod($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('id', $dataValues['id']);
                $this->db->update('user_payment_methods', $dataValues);
                $id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('user_payment_methods', $dataValues);
                $info_id = $this->db->insert_id();
            }
            return $info_id;
        }
    }

    public function deletePaymentMethod($payment_id)
    {
        $this->db->where('id',$payment_id);
        $this->db->delete('user_payment_methods');
    }

    public function get_request_counts($master_id)
    {
        return   $this->db->query("SELECT COUNT(id) AS count_withdraw,
        (SELECT COUNT(id)  FROM `deposit_request` LEFT JOIN registered_users ON `registered_users`.`user_id` = `deposit_request`.`user_id` WHERE `registered_users`.`master_id`= ".$master_id." AND `deposit_request`.`status` = 'Request' ) AS count_deposit 
        FROM `withdraw_request` LEFT JOIN registered_users ON `withdraw_request`.`user_id` = `registered_users`.`user_id`   WHERE `registered_users`.`master_id`= ".$master_id." AND `withdraw_request`.`status` = 'Request'")->row();

    }
}
