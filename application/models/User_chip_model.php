<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_chip_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_chips()
    {
        $this->db->select('*');
        $this->db->from('chips');
        $this->db->where('is_active', 'Yes');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function addUserChip($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('user_chip_id', $dataValues) && !empty($dataValues['user_chip_id'])) {
                $this->db->where('user_chip_id', $dataValues['user_chip_id']);
                $this->db->update('users_chips', $dataValues);
                $user_chip_id = $dataValues['user_chip_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('users_chips', $dataValues);
                $user_chip_id = $this->db->insert_id();
            }
            return $user_chip_id;
        }
    }

    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);

            $this->db->delete('chips');
        }
    }

    public function getUserChips($user_id)
    {
        $this->db->select('*');
        $this->db->from('users_chips');
        $this->db->where('is_active', 'Yes');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('user_chip_id', 'asc');
        
        $return = $this->db->get()->result_array();
        return $return;
    }


    public function deleteUserChips($user_id)
    {
        if (!empty($user_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->delete('users_chips');
        }
    }

    public function addChipBatch($dataValues)
    {
        $this->db->insert_batch('users_chips', $dataValues);
        return true;
    }


    public function delete_multiple_chips_entrys($user_ids = array())
    {
        $this->db->where_in('user_id', $user_ids);
        $results =  $this->db->delete('users_chips');
        return $results;
    }

     
}
