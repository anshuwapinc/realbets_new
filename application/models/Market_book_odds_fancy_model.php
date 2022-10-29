<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Market_book_odds_fancy_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_fancy_by_match_id($match_id, $settled = false)
    {
        $this->db->select('f.*');
        $this->db->from('betting as b');
        $this->db->join('market_book_odds_fancy as f', 'f.selection_id = b.selection_id', 'left');
        
        $this->db->where('f.match_id', $match_id);
        $this->db->where('b.match_id', $match_id);
        $this->db->where('b.betting_type','Fancy');

        if (!$settled) {

        $this->db->where('b.status','Open');

        }
        else
        {
        $this->db->where('b.status','Setlled');

        }
        $this->db->group_by('f.selection_id');



        if (!$settled) {
            $this->db->where('result IS NULL');
        } else {
            $this->db->where('result IS NOT NULL');
        }
        $this->db->order_by('created_at', 'DESC');
        

        $return = $this->db->get()->result();
        return $return;
    }


    public function addFancyResult($dataValues)
    {
        $selection_id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('selection_id', $dataValues) && !empty($dataValues['selection_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('selection_id', $dataValues['selection_id']);
                $this->db->where('match_id', $dataValues['match_id']);
                $this->db->update('market_book_odds_fancy', $dataValues);
                $selection_id = $dataValues['selection_id'];
            }
            return $selection_id;
        }
    }

    public function get_fancy_by_selection_id($selection_id)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('selection_id', $selection_id);
        $return = $this->db->get()->row_array();
        return $return;
    }

    public function get_fancy_detail($dataValues = array())
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('selection_id', $dataValues['selection_id']);
        $this->db->where('match_id', $dataValues['match_id']);

        $return = $this->db->get()->row_array();
        return $return;
    }


  
}
