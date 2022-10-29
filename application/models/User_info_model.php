<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_info_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_general_setting()
    {
        $this->db->select('*');
        $this->db->from('default_general_setting');
        // $this->db->where('is_active', 'Yes');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function addUserInfo($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('info_id', $dataValues) && !empty($dataValues['info_id'])) {
                $this->db->where('info_id', $dataValues['info_id']);
                $this->db->update('user_info', $dataValues);
                $info_id = $dataValues['info_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('user_info', $dataValues);
                $info_id = $this->db->insert_id();
            }
            return $info_id;
        }
    }

    public function get_user_info_by_userid($user_id,$sport_id)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('e.*');
            $this->db->from('user_info as e');
            $this->db->where('e.user_id', $user_id);
            $this->db->where('e.sport_id', $sport_id);


            $return = $this->db->get()->row();
        }
        return $return;
    }


    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);

            $this->db->delete('chips');
        }
    }

    public function addRegisteredUserInfo($dataValues)
    {

        if (count($dataValues) > 0) {        
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('registered_users', $dataValues);
                $info_id = $this->db->insert_id();            
            return $info_id;
        }
    }

    public function get_casino_default_general_setting()
    {
        $return = NULL;
        // if (!empty($user_id)) {
            $this->db->select('*');
            $this->db->from('default_general_setting');
            $this->db->where('sport_id', 1000);
            

            $return = $this->db->get()->row_array();
        // }
        return $return;
    }

    public function get_general_setting_by_user_id($user_id)
    {
        $this->db->select('*');
        $this->db->from('user_info');
        $this->db->where('user_id', $user_id);
        $return = $this->db->get()->result_array();
        return $return;
    }
}
