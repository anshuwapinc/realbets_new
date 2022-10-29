<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manual_model extends My_Model
{
    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_event_types()
    {

        $query = $this->db->query("select event_type_id,event_type,name,shortname from `event_types` where is_casino = 'No'  UNION ALL  SELECT event_type_id,event_type,NAME,shortname FROM `manual_event_types` where is_casino = 'No'  ");
        $result = $query->result_array();
        return $result;
    }


    public function get_all_events_lists($dataArray = array())
    {


        $query = $this->db->query("select list_event_id,event_type,event_id,event_name,status,'API_MATCH' AS data_type,created_at,open_date FROM `list_events` WHERE `event_type` = '" . $dataArray['event_type'] . "' AND `created_at` >= '" . date("Y-m-d H:i:s", strtotime("-1 days")) . "'   UNION ALL SELECT list_event_id,event_type,event_id,event_name,status,'MANUAL_MATCH' AS data_type,created_at,open_date FROM `manual_list_events` WHERE `event_type` = '" . $dataArray['event_type'] . "' and `site_code` = '" . $dataArray['site_code'] . "'    
        and `is_unlist` = '" . $dataArray['is_unlist'] . "'");
        $result = $query->result_array();
        return $result;
    }


    public function addManualEvent($dataValues)
    {
        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('list_event_id', $dataValues) && !empty($dataValues['list_event_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('list_event_id', $dataValues['list_event_id']);
                $this->db->update('manual_list_events', $dataValues);
                $e_id = $dataValues['list_event_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('manual_list_events', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }


    public function get_all_market_types($dataArray = array())
    {



        $query = $this->db->query("select market_book_odd_id,STATUS,id,mt.event_id,market_name,mt.market_id,market_start_time,'API_MARKET' AS data_type,mt.created_at FROM `market_types` AS mt LEFT JOIN `market_book_odds` AS mbs ON mbs.market_id = mt.market_id WHERE mt.event_id = '" . $dataArray['event_id'] . "' 
        UNION ALL 
        SELECT market_book_odd_id,STATUS,id,mmt.event_id,market_name,mmt.market_id,market_start_time,'MANUAL_MARKET' AS data_type,mmt.created_at FROM `manual_market_types` AS mmt LEFT JOIN `manual_market_book_odds` AS mmbo ON mmbo.market_id = mmt.market_id 
         WHERE mmt.event_id = '" . $dataArray['event_id'] . "' and mmt.site_code = '" . $dataArray['site_code'] . "' ");



        //  $query = $this->db->query("select id,event_id,market_name,market_id,market_start_time,'API_MARKET' AS data_type,created_at FROM `market_types` WHERE `event_id` = '".$dataArray['event_id']."' UNION ALL SELECT id,event_id,market_name,market_id,market_start_time,'MANUAL_MARKET' AS data_type,created_at FROM `manual_market_types` WHERE `event_id` = '".$dataArray['event_id']."'  ");


        $result = $query->result_array();

        // p($this->db->last_query());
        return $result;
    }


    public function addManualMarketTypes($dataValues)
    {
        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('id', $dataValues['id']);
                $this->db->update('manual_market_types', $dataValues);
                $e_id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('manual_market_types', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }

    public function addManualMarketBookOdds($dataValues)
    {
        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('market_book_odd_id', $dataValues) && !empty($dataValues['market_book_odd_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('market_book_odd_id', $dataValues['market_book_odd_id']);
                $this->db->update('manual_market_book_odds', $dataValues);
                $e_id = $dataValues['market_book_odd_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('manual_market_book_odds', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }


    public function get_manual_market_book_odds($dataArray = array())
    {

        $query = $this->db->query("select market_book_odd_id,market_id,'API_MARKET' AS data_type,created_at FROM `manual_market_book_odds` WHERE `market_id` = '" . $dataArray['market_id'] . "' UNION ALL SELECT  market_book_odd_id,market_id,'API_MARKET' AS data_type,created_at  FROM `manual_market_book_odds` WHERE `market_id` = '" . $dataArray['market_id'] . "'  ");
        $result = $query->row_array();

        return $result;
    }


    public function get_manual_market_runners($dataArray = array())
    {


        $query = $this->db->query("select * from manual_market_book_odds_runner WHERE `market_id` = '" . $dataArray['market_id'] . "' and `site_code` = '" . $dataArray['site_code'] . "'  ORDER BY runner_name ASC,CONVERT(runner_name, DECIMAL)  ASC");
        $result = $query->result_array();

        return $result;
    }


    public function addManualMarketRunners($dataValues)
    {
        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('id', $dataValues) && !empty($dataValues['id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('id', $dataValues['id']);
                $this->db->update('manual_market_book_odds_runner', $dataValues);
                $e_id = $dataValues['id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('manual_market_book_odds_runner', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }


    public function get_active_market_events($dataArray = array())
    {


        if (!empty($dataArray['event_id'])) {
            $query = $this->db->query("select competition_id,event_id,event_name,open_date,is_inplay,is_fancy,is_bm,is_tv,event_type from manual_list_events WHERE status = 'OPEN' and event_id = '" . $dataArray['event_id'] . "' and is_unlist = 'No' ");
            $result = $query->result_array();
        } else {
            $query = $this->db->query("select competition_id,event_id,event_name,open_date,is_inplay,is_fancy,is_bm,is_tv,event_type from manual_list_events WHERE status = 'OPEN' and is_unlist = 'No' ");
            $result = $query->result_array();
        }


        return $result;
    }


    public function get_active_market_types($dataArray = array())
    {

        $query = $this->db->query("select mmt.market_id,market_name,market_start_time,status,inplay,complete from manual_market_types as mmt 
        left join `manual_market_book_odds` as mmbo on mmbo.market_id = mmt.market_id 
        WHERE status = '" . $dataArray['status'] . "' and mmt.event_id = '" . $dataArray['event_id'] . "'");
        $result = $query->result_array();

 
        return $result;
    }


    public function get_market_runners($dataArray = array())
    {

        $query = $this->db->query("select * from manual_market_book_odds_runner where event_id = '" . $dataArray['event_id'] . "' and market_id = '" . $dataArray['market_id'] . "' and runner_name IS NOT NULL ORDER BY runner_name ASC,CONVERT(runner_name, DECIMAL)  ASC");
        $result = $query->result_array();

        // p($this->db->last_query());

        return $result;
    }


    public function get_event_by_event_id_for_betting($event_id)
    {
        $site_code = getCustomConfigItem('site_code');
        $this->db->select('le.event_name,le.event_type,le.competition_id');
        $this->db->from('manual_list_events as le');
        // $this->db->join('list_competitions as lc', 'lc.competition_id = le.competition_id');
        $this->db->where('event_id', $event_id);
        $this->db->where('site_code', $site_code);

        $return = $this->db->get()->row();
        return $return;
    }

    public function get_market_type_by_market_id($dataValues = array())
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('*');
        $this->db->from('manual_market_types');
        // $this->db->where('event_id', $event_id);
        $this->db->where($dataValues);
        $this->db->where('site_code', $site_code);

        $return = $this->db->get()->row();

        return $return;
    }


    public function get_runner($dataValues  = array())
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('*');
        $this->db->from('manual_market_book_odds_runner');
        $this->db->where($dataValues);
        $this->db->where('site_code', $site_code);

        $return = $this->db->get()->row();
        return $return;
    }


    public function get_market_book_odds_by_market_id($market_id)
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('*');
        $this->db->from('manual_market_book_odds');
        $this->db->where('market_id', $market_id);
        $this->db->where('site_code', $site_code);

        $return = $this->db->get()->row();
        return $return;
    }

    public function check_active_odds($dataValues)
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('*');
        $this->db->from('manual_market_book_odds_runner');
        $this->db->where($dataValues);
        $this->db->where('site_code', $site_code);


        $return = $this->db->get()->row();
        return $return;
    }

    public function get_market_types($dataArray = array())
    {



        $query = $this->db->query("select winner_selection_id,market_book_odd_id,STATUS,id,mmt.event_id,market_name,mmt.market_id,market_start_time,'MANUAL_MARKET' AS data_type,mmt.created_at FROM `manual_market_types` AS mmt LEFT JOIN `manual_market_book_odds` AS mmbo ON mmbo.market_id = mmt.market_id 
         WHERE mmt.event_id = '" . $dataArray['event_id'] . "' and mmt.site_code = '" . $dataArray['site_code'] . "' and  mmt.market_id = '" . $dataArray['market_id'] . "' ");



        //  $query = $this->db->query("select id,event_id,market_name,market_id,market_start_time,'API_MARKET' AS data_type,created_at FROM `market_types` WHERE `event_id` = '".$dataArray['event_id']."' UNION ALL SELECT id,event_id,market_name,market_id,market_start_time,'MANUAL_MARKET' AS data_type,created_at FROM `manual_market_types` WHERE `event_id` = '".$dataArray['event_id']."'  ");


        $result = $query->row_array();

        // p($this->db->last_query());
        return $result;
    }
    public function update_manual_market_book_odds_runner($dataValues = array())
    {
        if ($dataValues) {
            $dataValues["updated_at"] = date("Y-m-d H:i:s");
            $this->db->where('market_id', $dataValues['market_id']);

            if (!empty($dataValues['event_id'])) {
                $this->db->where('event_id', $dataValues['event_id']);
            }

            if (!empty($dataValues['selection_id'])) {
                $this->db->where('selection_id', $dataValues['selection_id']);
            }
            $this->db->update('manual_market_book_odds_runner', $dataValues);


         }
    }
    public function updateStatusRecordAll($dataValues = array())
    {
        if ($dataValues) {
            $dataValues["updated_at"] = date("Y-m-d H:i:s");
            $this->db->where('market_id', $dataValues['market_id']);
            $this->db->where('event_id', $dataValues['event_id']);
            $this->db->update('manual_market_book_odds_runner', $dataValues);
        }
    }
    public function update_manual_market_book_odds($dataValues = array())
    {
        if ($dataValues) {
            $dataValues["updated_at"] = date("Y-m-d H:i:s");
            $this->db->where('market_id', $dataValues['market_id']);
            $this->db->update('manual_market_book_odds', $dataValues);
        }
    }
    public function unlist_manual_events($dataValues = array())
    {
        if ($dataValues) {
            $dataValues["updated_at"] = date("Y-m-d H:i:s");
            $this->db->where('list_event_id', $dataValues['list_event_id']);
            $this->db->update('manual_list_events', $dataValues);
        }
    }
}
