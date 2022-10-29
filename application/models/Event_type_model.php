<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_type_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_market_types($is_casino = null)
    {
        $this->db->select('*');
        $this->db->from('event_types');

        if(!empty($is_casino))
        {
            $this->db->where('is_casino', $is_casino);

        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_event_type_by_id($event_type)
    {
        $this->db->select('*');
        $this->db->from('event_types');
        $this->db->where('event_type', $event_type);
        $return = $this->db->get()->row();
        return $return;
    }

    public function get_all_event_types()
    {
        $this->db->select('*');
        $this->db->from('event_types');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_event_types($event_types = array())
    {
        $this->db->select('*');
        $this->db->from('event_types');
        
        if(!empty($event_types))
        {
            $this->db->group_start();
            foreach($event_types as $event_type)
            {
                $this->db->or_where('event_type', $event_type);

            }
            $this->db->group_end();


        }
        $return = $this->db->get()->result_array();
        return $return;
    }
}
