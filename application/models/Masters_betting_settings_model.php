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

    public function get_betting_settings($dataValues)
    {
        $return = array();
        if (count($dataValues) > 0) {

            $this->db->select('*');
            $this->db->from('masters_betting_settings');
            $this->db->where($dataValues);
            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function count_winnings($dataValues)
    {
        $return = array();
        if (count($dataValues) > 0) {
            $this->db->select('SUM(profit) as profit');
            $this->db->from('masters_betting_settings');
            $this->db->where($dataValues);
            $this->db->where('status', 'Settled');
            $this->db->where('bet_result', 'Plus');


            $return = $this->db->get()->row();
        }
        return $return->profit;
    }

    public function get_open_bettings_list($dataValues = array())
    {
        
        $return = array();

        $this->db->select('*,mbs.profit as profit,mbs.loss as loss,b.created_at,b.profit as client_profit,b.loss as client_loss');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');

        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }

        $this->db->where('b.status', 'Open');
        $this->db->where('b.is_delete', 'No');



        $return = $this->db->get()->result();

        return $return;
    }

    public function get_event_open_bettings_list($dataValues = array())
    {
        $return = array();

        $this->db->select('*,ru.user_name as client_name,ru.name as client_user_name,b.created_at');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id');


        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }

        $this->db->where('b.status', 'Open');
        $this->db->where('b.is_delete', 'No');



        $return = $this->db->get()->result_array();


        return $return;
    }



    public function get_user_position_open_bettings_list($dataValues = array())
    {
        $return = array();

        $this->db->select('*,mbs.profit as profit,mbs.loss as loss,b.created_at');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');

        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('b.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }


        $this->db->where('b.status', 'Open');
        $this->db->where('b.is_delete', 'No');

        $this->db->where('mbs.user_type', 'Master');


        $return = $this->db->get()->result();


        return $return;
    }


    // public function get_master_position_open_bettings_list($dataValues = array())
    // {
    //     $return = array();

    //     $this->db->select('*,mbs.profit as profit,mbs.loss as loss,b.created_at');
    //     $this->db->from('masters_betting_settings as mbs');
    //     $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');

    //     if (isset($dataValues['market_id'])) {
    //         $this->db->where('b.market_id', $dataValues['market_id']);
    //     }

    //     if (isset($dataValues['user_id'])) {
    //         $this->db->where('mbs.user_id', $dataValues['user_id']);
    //     }

    //     if (isset($dataValues['match_id'])) {
    //         $this->db->where('b.match_id', $dataValues['match_id']);
    //     }

    //     $this->db->where('b.status', 'Open');
    //     $this->db->where('b.is_delete', 'No');



    //     $return = $this->db->get()->result();

    //      return $return;
    // }
    public function get_master_position_open_bettings_list($dataValues = array())
    {
        $query = $this->db->query("select  b1.*,mbs1.profit as profit,mbs1.loss as loss,b1.created_at,b1.profit as client_profit,b1.loss as client_loss,mbs1.partnership,mbs1.user_type
        FROM  masters_betting_settings AS `mbs1`
        JOIN `betting` AS `b1` ON `b1`.`betting_id` = `mbs1`.`betting_id`
        WHERE mbs1.betting_id IN
        (SELECT mbs.betting_id
        FROM `masters_betting_settings` AS `mbs`
        JOIN `betting` AS `b` ON `b`.`betting_id` = `mbs`.`betting_id`
        WHERE `b`.`market_id` = '" . $dataValues['market_id'] . "'
        AND `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
        AND `b`.`status` = 'Open'
        AND `b`.`is_delete` = 'No') AND user_type = '" . $dataValues['user_type'] . "';");
        $result = $query->result();



        return $result;
    }


    public function get_event_open_bettings_list1($dataValues = array())
    {
        $return = array();

        $this->db->select('*,ru.user_name as client_name,ru.name as client_user_name,b.created_at');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id');



        //  if (isset($dataValues['type'])) {
        //     if ($dataValues['type'] == 'Match') {
        //         if (isset($dataValues['selection_id'])) {
        //             $this->db->where('b.market_id', $dataValues['selection_id']);
        //         }
        //     } else if ($dataValues['type'] == 'Fancy') {

                
        //         if (isset($dataValues['selection_id'])) {
        //             $this->db->where('b.selection_id', $dataValues['selection_id']);
        //         }
        //     }

            
        //         $this->db->where('b.betting_type', $dataValues['type']);
           
        // }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }

        $this->db->where('b.status', 'Open');
        $this->db->where('b.is_delete', 'No');
        $this->db->where('b.unmatch_bet', $dataValues['unmatch_bet']);




        $return = $this->db->get()->result_array();
        return $return;
    }
}
