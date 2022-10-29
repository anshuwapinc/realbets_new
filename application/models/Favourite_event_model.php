<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favourite_event_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function addFavouriteEvent($dataValues)
    {
        $id = null;
        if ((array_key_exists('event_id', $dataValues) && !empty($dataValues['event_id'])) && (array_key_exists('user_id', $dataValues) && !empty($dataValues['user_id']))) {
            $this->db->select('*');
            $this->db->from('favorite_events');
            $this->db->where('user_id', $dataValues['user_id']);
            $this->db->where('event_id', $dataValues['event_id']);
            $return = $this->db->get()->row();

            if (!empty($return)) {
                $this->db->where($dataValues);
                $this->db->delete('favorite_events');
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('favorite_events', $dataValues);
                $id = $this->db->insert_id();
            }
        }

        return $id;
    }

    public function get_favourite_event($dataValues)
    {
        $this->db->select('*');
        $this->db->from('favorite_events');
        $this->db->where($dataValues);
        $return = $this->db->get()->row();


        return $return;
    }
}
