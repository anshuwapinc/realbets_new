<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_market_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_running_markets()
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('is_active', 'Yes');
        // $this->db->limit('0,1');
        $return = $this->db->get()->result_array();
        p($return);
        return $return;

    }
}
