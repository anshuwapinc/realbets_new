<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_token_model extends My_Model
{
    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function addToken($dataValues)
    {
        $id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {
                $this->db->where('id', $dataValues['id']);
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->update('user_token', $dataValues);
                $id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('user_token', $dataValues);
                $id = $this->db->insert_id();
            }
        }
        return $id;
    }


    public function getTokeById($username)
    {
        $return = NULL;
        if (!empty($username)) {
            $this->db->select('*');
            $this->db->from('user_token');
            $this->db->where('username', $username);
            $return = $this->db->get()->row();
        }
        return $return;
    }
}
