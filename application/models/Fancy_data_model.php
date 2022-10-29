<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fancy_data_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_events()
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('is_active', 'Yes');
        // $this->db->limit('0,1');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_event_entry_by_event_id($event_id)
    {
        $this->db->select('*');
        $this->db->from('event_exchange_entrys');
        $this->db->where('event_id', $event_id);
        $return = $this->db->get()->row();
        return $return;
    }


    public function check_event_entry_exists($evend_id)
    {
        $this->db->select('*');
        $this->db->from('event_exchange_entrys');
        $this->db->where('event_id', $evend_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function addFancyData($dataValues)
    {
        $fancy_id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('fancy_id', $dataValues) && !empty($dataValues['fancy_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('fancy_id', $dataValues['fancy_id']);
                $this->db->update('fancy_data', $dataValues);
                $fancy_id = $dataValues['fancy_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('fancy_data', $dataValues);
                $fancy_id = $this->db->insert_id();
            }
        }

        return $fancy_id;
    }

    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);

            $this->db->delete('chips');
        }
    }

    public function count_total_exposure($user_id)
    {
        $this->db->select('SUM(stake) as total_exposure');
        $this->db->from('betting');
        $this->db->where('is_delete', 'No');

        $this->db->where('user_id', $user_id);
        $return = $this->db->get()->row();
        return $return;
    }

    // public function count_total_balance($user_id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('ledger');
    //     $this->db->where('user_id', $user_id);
    //     $this->db->where('is_delete', 'No');

    //     $this->db->limit('0,1');

    //     $this->db->order_by("ledger_id", "asc");

    //     $return = $this->db->get()->row();
    //     return $return;
    // }

    public function get_fancy_data($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('fancy_data');
            $this->db->where('market_id', $dataValues['market_id']);
            $return = $this->db->get()->row();
             return $return;
        }
    }
}
