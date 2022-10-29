<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competition_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

     

    public function get_competition_by_competition_id($competition_id)
    {
        $this->db->select('*');
        $this->db->from('list_competitions');
        $this->db->where('competition_id', $competition_id);
        $return = $this->db->get()->row();
        return $return;
    }

}
