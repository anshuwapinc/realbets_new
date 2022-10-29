<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class List_event_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_list_event_by_event_type($event_type)
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $this->db->where('event_type',$event_type);
        $this->db->order_by('open_date','DESC');

        $return = $this->db->get()->result();
        return $return;
    }

    public function get_list_event_by_event_type1($event_type)
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $this->db->where('event_type',$event_type);
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_list_event_by_id($list_event_id)
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $this->db->where('list_event_id',$list_event_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function add_list_events_winner($dataValues)
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        $this->db->where('event_id', $dataValues['event_id']);
        $this->db->update('list_events', $dataValues);
    }


    public function get_latest_event_by_event_type($event_type)
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $this->db->where('event_type',$event_type);
        $this->db->where('updated_at >= ', date("Y-m-d H:i:s", strtotime("-1 days")));
        $this->db->order_by('created_at','DESC');

        $return = $this->db->get()->result();

        return $return;
    }
}
