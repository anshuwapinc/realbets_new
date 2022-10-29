<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Block_market_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function checkBlockMarketExists($dataValues)
    {
        $this->db->select('*');
        $this->db->from('block_markets');
        $this->db->where($dataValues);
        $return = $this->db->get()->row();
        return $return;
    }

    public function addBlockMarket($dataValues)
    {

        $block_market_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('block_market_id', $dataValues) && !empty($dataValues['block_market_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('block_market_id', $dataValues['block_market_id']);
                $this->db->delete('block_markets');
                $block_market_id = $dataValues['block_market_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('block_markets', $dataValues);
                $block_market_id = $this->db->insert_id();
            }
        }

        return $block_market_id;
    }

    public function getBlockMarketsByUserId($dataValues)
    {
        $this->db->select('*');
        $this->db->from('block_markets');
        $this->db->where($dataValues);
        $return = $this->db->get()->result_array();
        

         return $return;
    }

    public function getBlockMarket($dataValues)
    {
        $this->db->select('*');
        $this->db->from('block_markets');
        $this->db->where($dataValues);
        $return = $this->db->get()->result_array();
        return $return;
    }
}
