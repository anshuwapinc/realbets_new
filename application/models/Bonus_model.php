<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bonus_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function addBonusSetting($dataValues)
    {
        $id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {

                $this->db->where('id', $dataValues['id']);
                $this->db->update('bonus-setting', $dataValues);
                $id = $dataValues['id'];
            } else {                
                $this->db->insert('bonus-setting', $dataValues);
                $id = $this->db->insert_id();
            }
        }

        return $id;
    }

    public function get_bonusSetting()
    {
        return $this->db->get('bonus-setting')->row_array();
    }

    public function count_total_bonus($user_id)
    {
        $this->db->select('(SUM(CASE WHEN transaction_type = "Credit" THEN amount ELSE 0 END) - SUM(CASE WHEN transaction_type = "Debit" THEN amount ELSE 0 END)) AS bonus_amount');
        $this->db->where('user_id',$user_id);        
        $this->db->where('type','Bonus');
        $return = $this->db->get('ledger')->row();
// p($return);
        // p($this->db->last_query());
        return $return->bonus_amount;
    }
}