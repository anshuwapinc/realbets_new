<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Masters_betting_settings_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function addBettingSetting($dataValues)
    {
        $setting_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('setting_id', $dataValues) && !empty($dataValues['setting_id'])) {
                $this->db->where('setting_id', $dataValues['setting_id']);
                $this->db->update('masters_betting_settings', $dataValues);
                $setting_id = $dataValues['setting_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('masters_betting_settings', $dataValues);
                $setting_id = $this->db->insert_id();
            }
        }
        return $setting_id;
    }

    public function get_betting_setting($dataValues)
    {
        $return = array();
        if (count($dataValues) > 0) {

            $this->db->select('*');
            $this->db->from('masters_betting_settings');
            $this->db->where($dataValues);
            $return = $this->db->get()->row();
        }
        return $return;
    }
}
