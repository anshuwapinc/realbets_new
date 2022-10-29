<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function addHeaderBanner($dataValues)
    {
        $id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {

                $this->db->where('id', $dataValues['id']);
                $this->db->update('header-banners', $dataValues);
                $id = $dataValues['id'];
            } else {                
                $this->db->insert('header-banners', $dataValues);
                $id = $this->db->insert_id();
            }
        }

        return $id;
    }

    public function get_all_banners()
    {
        $this->db->where('site_code',getCustomConfigItem('site_code'));
        return $this->db->get('header-banners')->result();
    }

    public function delete_header_banner($id)
    {      
        $this->db->where('site_code',getCustomConfigItem('site_code'));
        $this->db->where('id',$id);                
        $this->db->delete('header-banners');
    }

    public function get_banner_by_id($id)
    {
        $this->db->where('site_code',getCustomConfigItem('site_code'));
        $this->db->where('id',$id);                
       return  $this->db->get('header-banners')->row_array();
    }

    public function get_active_header_banners()
    {
        $this->db->where('site_code',getCustomConfigItem('site_code'));
        $this->db->where('status','Active');
        return $this->db->get('header-banners')->result();
    }
}