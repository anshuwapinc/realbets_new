<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class View_info_model extends My_Model
{
    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function saveUserInfo($dataValues)
    {
        $info_id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('info_id', $dataValues) && !empty($dataValues['info_id'])) {
                $this->db->where('info_id', $dataValues['info_id']);
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->update('user_info', $dataValues);
                $info_id = $dataValues['info_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('user_info', $dataValues);
                $info_id = $this->db->insert_id();
            }
        }
        return $info_id;
    }


    public function getViewInfoByUserId($user_id)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('e.*,dgs.min_stake as default_min_stake,dgs.max_stake as default_max_stake,dgs.max_profit as default_max_profit,dgs.max_loss as default_max_loss,dgs.bet_delay as default_bet_delay,dgs.pre_inplay_profit as default_pre_inplay_profit,dgs.min_odds as default_min_odds,dgs.max_odds as default_max_odds,dgs.pre_inplay_stake as default_pre_inplay_stake');
            $this->db->from('user_info as e');
            $this->db->join('default_general_setting as dgs', 'dgs.setting_id = e.setting_id');

            $this->db->where('e.user_id', $user_id);
            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function saveUserInfoAccrdingUpline($dataValues)
    {
        $info_id = NULL;
        if (count($dataValues) > 0) {

            $this->db->where('user_id', $dataValues['user_id']);
            $this->db->where('setting_id', $dataValues['setting_id']);
            $this->db->delete('user_info');


            // if (array_key_exists('setting_id', $dataValues) && !empty($dataValues['setting_id']) && array_key_exists('user_id', $dataValues) && !empty($dataValues['user_id'])) {
            //     $this->db->where('user_id', $dataValues['user_id']);
            //     $this->db->where('setting_id', $dataValues['setting_id']);

            //     $dataValues["updated_at"] = date("Y-m-d H:i:s");
            //     $this->db->update('user_info', $dataValues);
            //     $info_id = $dataValues['info_id'];
            // } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('user_info', $dataValues);
                $info_id = $this->db->insert_id();
            // }


         }
        return $info_id;
    }

    public function getDefaultSettingBySportId($sport_id)
    {
        $return = NULL;
        if (!empty($sport_id)) {
            $this->db->select('*');
            $this->db->from('default_general_setting');
 
            $this->db->where('sport_id', $sport_id);
            $return = $this->db->get()->row_array();
        }
        return $return;
    }
}
