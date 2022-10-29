<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Market_book_odds_runner_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_runner($dataValues  = array())
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where($dataValues);
        $return = $this->db->get()->row();
        return $return;
    }
    public function get_runners($dataValues  = array())
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where($dataValues);
        $return = $this->db->get()->result();
        return $return;
    }

    public function get_manual_runner($dataValues  = array())
    {
        $this->db->select('*');
        $this->db->from('manual_market_book_odds_runner');
        $this->db->where($dataValues);
        $return = $this->db->get()->row();
        return $return;
    }
}
