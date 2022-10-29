<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chip_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_chips($site_code)
    {
        $this->db->select('*');
        $this->db->from('chips');
        $this->db->where('is_active', 'Yes');
        $this->db->where('site_code', $site_code);

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function addChip($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('chip_id', $dataValues) && !empty($dataValues['chip_id'])) {
                $this->db->where('chip_id', $dataValues['chip_id']);
                $this->db->update('chips', $dataValues);
                $chip_id = $dataValues['chip_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('chips', $dataValues);
                $chip_id = $this->db->insert_id();
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
    
    public  function get_user_id_by_masters(){
//        p($this->session);
        $this->db->where('master_id',$_SESSION['my_userdata']['user_id']);
        $query= $this->db->get('registered_users')->row();
        return $query;
    }
    public function get_minus_account()
    {
       $user_id= $this->get_user_id_by_masters();
    
       $this->db->select('ru.*');
       $this->db->from('registered_users as ru');
       $this->db->where('ru.user_id',$user_id->user_id);
       $query=$this->db->get()->result_array();
       return $query;
    }
    
//     public function get_plus_account()
//    {
//    
//       $this->db->select('ru.*,b.*');
//       $this->db->from('registered_users as ru');
//       $this->db->join('betting as b ','b.user_id=ru.user_id','left');
//       $this->db->where('ru.user_id',$_SESSION['my_userdata']['user_id']);
//       $this->db->group_by('ru.user_id');
//       $query=$this->db->get()->result_array();
//        return $query;
//    }
     public function get_user_profit()
    {
       
        $this->db->where('user_id',$_SESSION['my_userdata']['user_id']);
        $query=$this->db->get('registered_users')->result_array();
        return $query;
    }
    
     public function get_smaster_profit()
    {
       
        $this->db->where('user_id',$_SESSION['my_userdata']['user_id']);
        $query=$this->db->get('registered_users')->result_array();
        return $query;
    }
    
     public function get_admin_profit()
    {
       
        $this->db->where('user_id',$_SESSION['my_userdata']['user_id']);
        $query=$this->db->get('registered_users')->result_array();
        return $query;
    }
    
}
