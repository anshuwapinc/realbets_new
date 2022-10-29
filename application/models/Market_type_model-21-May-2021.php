<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Market_type_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_market_type_by_event_id($event_id)
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('event_id', $event_id);
        $return = $this->db->get()->result();
        return $return;
    }

    public function add_markets_winner_entry($dataValues = array())
    {
        if (!empty($dataValues)) {
            if (array_key_exists('market_id', $dataValues) && !empty($dataValues['market_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('market_id', $dataValues['market_id']);
                $this->db->where('event_id', $dataValues['event_id']);
                $this->db->update('market_types', $dataValues);
            }
        }
    }

    public function get_match_odds_mark_event_id($event_id)
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('event_id', $event_id);
        $this->db->where('market_name', 'Match Odds');

        $return = $this->db->get()->row();
        return $return;
    }
}
