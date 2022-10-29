<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_exchange_entry_model extends My_Model
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

    public function addEventExchangeEntry($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('exchange_event_entry_id', $dataValues) && !empty($dataValues['exchange_event_entry_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('exchange_event_entry_id', $dataValues['exchange_event_entry_id']);
                $this->db->update('event_exchange_entrys', $dataValues);
                $exchange_event_entry_id = $dataValues['exchange_event_entry_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('event_exchange_entrys', $dataValues);
                $exchange_event_entry_id = $this->db->insert_id();
            }
        }
    }

    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);

            $this->db->delete('chips');
        }
    }
}
