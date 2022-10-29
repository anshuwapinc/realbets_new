<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_news($site_code)
    {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('is_active', 'Yes');
        $this->db->where('site_code', $site_code);



        $return = $this->db->get()->result_array();

        return $return;
    }

    public function addNews($dataValues)
    {
        if (count($dataValues) > 0) {
            if (array_key_exists('news_id', $dataValues) && !empty($dataValues['news_id'])) {
                $this->db->where('news_id', $dataValues['news_id']);
                $this->db->update('news', $dataValues);
                $news_id = $dataValues['news_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('news', $dataValues);
                $news_id = $this->db->insert_id();
            }
        }
    }

    public function deleteNews($news_id)
    {

        if (!empty($news_id)) {
            $this->db->where('news_id', $news_id);

            $this->db->delete('news');
        }
    }

    public function get_latest_news($site_code)
    {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('is_active', 'Yes');
        $this->db->where('site_code', $site_code);

        $this->db->order_by('news_id', 'asc');
        $this->db->limit(0, 2);
        $return = $this->db->get()->result_array();
        return $return;
    }
}
