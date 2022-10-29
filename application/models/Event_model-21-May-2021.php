<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_events()
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('is_active', 'Yes');
        // $this->db->limit('0,1');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_event_by_event_id($event_id)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('event_id', $event_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function disable_events()
    {
        $this->db->update('events', array("is_active" => 'No'));
    }


    public function check_event_exists($evend_id)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('event_id', $evend_id);
        $return = $this->db->get()->row();
        return $return;
    }
    public function addEvent($dataValues)
    {
        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('e_id', $dataValues) && !empty($dataValues['e_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('e_id', $dataValues['e_id']);
                $this->db->update('events', $dataValues);
                $e_id = $dataValues['e_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('events', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }

    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);
            $this->db->delete('chips');
        }
    }


    public function add_event_types($dataValues)
    {

        $e_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('e_id', $dataValues) && !empty($dataValues['e_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");

                $this->db->where('e_id', $dataValues['e_id']);
                $this->db->update('events', $dataValues);
                $e_id = $dataValues['e_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('events', $dataValues);
                $e_id = $this->db->insert_id();
            }
        }

        return $e_id;
    }

    public function addEventType($dataValues)
    {

        $event_type_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('event_type', $dataValues) && !empty($dataValues['event_type'])) {

                $this->db->select('*');
                $this->db->from('event_types');
                $this->db->where('event_type', $dataValues['event_type']);
                $return = $this->db->get()->row();

                if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");

                    $this->db->where('event_type', $dataValues['event_type']);
                    $this->db->update('event_types', $dataValues);
                    $event_type_id = $dataValues['event_type'];
                } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('event_types', $dataValues);
                    $event_type_id = $this->db->insert_id();
                }
            }
        }

        return $event_type_id;
    }

    public function getEventTypes()
    {
        $this->db->select('*');
        $this->db->from('event_types');
        $return = $this->db->get()->result_array();
        return $return;
    }


    public function addCompetition($dataValues)
    {

        $competition_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('competition_id', $dataValues) && !empty($dataValues['competition_id'])) {
                $this->db->select('*');
                $this->db->from('list_competitions');
                $this->db->where('competition_id', $dataValues['competition_id']);
                $return = $this->db->get()->row();

                if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");
                    $this->db->where('competition_id', $dataValues['competition_id']);
                    $this->db->update('list_competitions', $dataValues);
                    $competition_id = $dataValues['competition_id'];
                } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('list_competitions', $dataValues);
                    $competition_id = $this->db->insert_id();
                }
            }
        }

        return $competition_id;
    }

    public function getCompetitions()
    {
        $this->db->select('*');
        $this->db->from('list_competitions');
        $return = $this->db->get()->result_array();
        return $return;
    }


    public function addEvents($dataValues)
    {

        $event_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('event_id', $dataValues) && !empty($dataValues['event_id'])) {
                $this->db->select('*');
                $this->db->from('list_events');
                $this->db->where('event_id', $dataValues['event_id']);
                $return = $this->db->get()->row();

                if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");

                    $this->db->where('event_id', $dataValues['event_id']);
                    $this->db->update('list_events', $dataValues);
                    $event_id = $dataValues['event_id'];
                } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('list_events', $dataValues);
                    $event_id = $this->db->insert_id();
                }
            }
        }

        return $event_id;
    }


    public function getEvents()
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function addMarketTypes($dataValues)
    {
        $id = null;
        if (count($dataValues) > 0) {
            if ((array_key_exists('event_id', $dataValues) && !empty($dataValues['event_id'])) && (array_key_exists('market_id', $dataValues) && !empty($dataValues['market_id']))) {

                $this->db->select('*');
                $this->db->from('market_types');
                $this->db->where('market_id', $dataValues['market_id']);
                $this->db->where('event_id', $dataValues['event_id']);
                $return = $this->db->get()->row();
                if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");

                    $this->db->where('market_id', $dataValues['market_id']);
                    $this->db->where('event_id', $dataValues['event_id']);
                    $this->db->update('market_types', $dataValues);

                    $id = $dataValues['market_id'];
                } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('market_types', $dataValues);
                    $id = $this->db->insert_id();
                }
            } else {
            }
        }
        return $id;
    }

    public function getMarketTypes()
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function addMarketBookOdds($dataValues)
    {
        $market_id = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('market_id', $dataValues) && !empty($dataValues['market_id'])) {

                $this->db->select('*');
                $this->db->from('market_book_odds');
                $this->db->where('market_id', $dataValues['market_id']);
                $return = $this->db->get()->row();
                 if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");
                    $this->db->where('market_id', $dataValues['market_id']);
                    $this->db->update('market_book_odds', $dataValues);
                    $market_id = $dataValues['market_id'];

                 } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('market_book_odds', $dataValues);
                    $market_id = $this->db->insert_id();
                }
            }
        }

        return $market_id;
    }


    public function addMarketBookOddsRunners($dataValues)
    {
        $id = null;
        if (count($dataValues) > 0) {
            if ((array_key_exists('market_id', $dataValues) && !empty($dataValues['market_id'])) && (array_key_exists('selection_id', $dataValues) && !empty($dataValues['selection_id']))) {

                $this->db->select('*');
                $this->db->from('market_book_odds_runner');
                $this->db->where('market_id', $dataValues['market_id']);
                $this->db->where('selection_id', $dataValues['selection_id']);

                $return = $this->db->get()->row();
                 if (!empty($return)) {
                    $dataValues["updated_at"] = date("Y-m-d H:i:s");
                    $this->db->where('market_id', $dataValues['market_id']);
                    $this->db->where('selection_id', $dataValues['selection_id']);
                    $this->db->update('market_book_odds_runner', $dataValues);
                    $id = $dataValues['market_id'];
                } else {
                    $dataValues["created_at"] = date("Y-m-d H:i:s");
                    $this->db->insert('market_book_odds_runner', $dataValues);
                    $id = $this->db->insert_id();
                }
            }
        }

         return $id;
    }

    public function addMarketBookOddsFancy($dataValues)
    {
        $id = null;
        if ((array_key_exists('match_id', $dataValues) && !empty($dataValues['match_id'])) && (array_key_exists('selection_id', $dataValues) && !empty($dataValues['selection_id']))) {
            $this->db->select('*');
            $this->db->from('market_book_odds_fancy');
            $this->db->where('match_id', $dataValues['match_id']);
            $this->db->where('selection_id', $dataValues['selection_id']);
            $return = $this->db->get()->row();

            if (!empty($return)) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('match_id', $dataValues['match_id']);
                $this->db->where('selection_id', $dataValues['selection_id']);
                unset($dataValues['match_id']);


                $this->db->update('market_book_odds_fancy', $dataValues);
                $id = $dataValues['selection_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('market_book_odds_fancy', $dataValues);
                $id = $this->db->insert_id();
            }
        }

        return $id;
    }


    public function list_events($dataArray = array())
    {
        $this->db->select('le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date');
        $this->db->from('list_events as le');
        if (isset($dataArray['event_id'])) {
            $this->db->where('le.event_id', $dataArray['event_id']);
        }

        // if (isset($dataArray['inplay'])) {
        //     $this->db->where('mbo.inplay', $dataArray['inplay']);
        // }

        $return = $this->db->get()->result_array();

        // p($return);
        return $return;
    }

    public function list_market_types($dataArray = array())
    {
        $this->db->select('mt.market_id,mt.market_name,mt.market_start_time,mt.runner_1_selection_id,mt.runner_1_runner_name,mt.runner_2_selection_id,mt.runner_2_runner_name,mbo.status,mbo.inplay,mbo.complete');
        $this->db->from('market_types as mt');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = mt.market_id');
        if (isset($dataArray['event_id'])) {
            $this->db->where('mt.event_id', $dataArray['event_id']);
        }

        // $this->db->where('mbo.status', 'OPEN');
        // $this->db->where('mt.market_name <>', 'Bookmaker');

        // $this->db->where('mt.winner_selection_id', '');
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function list_market_book_odds_runner($dataArray = array())
    {
        $return  = NULL;
        if (!empty($dataArray)) {
            $this->db->select('*');
            $this->db->from('market_book_odds_runner');

            if (isset($dataArray['market_id']) && !empty($dataArray['market_id'])) {
                $this->db->where('market_id', $dataArray['market_id']);
            }

            if (isset($dataArray['event_id']) && !empty($dataArray['event_id'])) {
                $this->db->where('event_id', $dataArray['event_id']);
            }

            $this->db->order_by('id', 'asc');

            $return = $this->db->get()->result_array();
        }

        return $return;
    }



    public function get_all_fancy_data($event_id = null)
    {
        $this->db->select('id,match_id,selection_id,runner_name,lay_price1,lay_size1,back_price1,back_size1,game_status,mark_status,is_active');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('match_id', $event_id);
        $this->db->where('is_active', 'Yes');
        $this->db->where('game_status<>', 'SUSPENDED');
        // $this->db->where('result', '');



        $return = $this->db->get()->result_array();

        // p($this->db->last_query());

        return $return;
    }

    public function get_fancy_data($event_id = null)
    {
        $this->db->select('id,match_id,selection_id,runner_name,lay_price1,lay_size1,back_price1,back_size1,game_status,mark_status,is_active');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('match_id', $event_id);
        $this->db->where('is_active', 'Yes');
        $this->db->where('game_status<>', 'SUSPENDED');


        $return = $this->db->get()->result_array();

        return $return;
    }

    public function checkCompetitionExists($competition_id = null)
    {
        $this->db->select('*');
        $this->db->from('list_competitions');
        $this->db->where('competition_id', $competition_id);
        $return = $this->db->get()->row();
        return $return;
    }


    public function checkEventsExists($event_id = null)
    {
        $this->db->select('*');
        $this->db->from('list_events');
        $this->db->where('event_id', $event_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function checkEventsRunnerExists($market_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where('market_id', $market_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function bookOddExists($market_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds');
        $this->db->where('market_id', $market_id);
        $return = $this->db->get()->row();
        return $return;
    }


    public function bookOddsFancyExists($selection_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('selection_id', $selection_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function checkMarketBookOddsRunners($selection_id = null, $market_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where('selection_id', $selection_id);
        $this->db->where('market_id', $market_id);

        $return = $this->db->get()->row();
        return $return;
    }

    public function checkMarketTypesExists($market_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('market_id', $market_id);
        $return = $this->db->get()->row();
        return $return;
    }



    public function disable_all_fancy()
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        // $dataValues["is_active"] =  'No';
        $this->db->update('market_book_odds_fancy', $dataValues);
    }

    public function disable_all_events()
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        // $dataValues["is_active"] =  'No';
        $this->db->update('list_events', $dataValues);
    }


    public function disable_all_odds()
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        // $dataValues["is_active"] =  'No';
        $this->db->update('market_book_odds', $dataValues);
    }

    public function disable_all_odds_runner()
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        // $dataValues["is_active"] =  'No';
        $this->db->update('market_book_odds_runner', $dataValues);
    }

    public function disable_all_market_types()
    {
        $dataValues["updated_at"] = date("Y-m-d H:i:s");
        // $dataValues["is_active"] =  'No';
        $this->db->update('market_types', $dataValues);
    }

    public function check_current_odds($data1, $data2)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where($data1);
        $this->db->group_start();
        $this->db->or_where($data2);
        $this->db->group_end();
        $return = $this->db->get()->row();

        return $return;
    }

    public function get_market_book_odds_runner($dataArray = array())
    {
        $return  = NULL;
        if (!empty($dataArray)) {
            $this->db->select('selection_id');
            $this->db->from('market_book_odds_runner');
            $this->db->where('market_id', $dataArray['market_id']);
            $this->db->order_by('sort_priority', 'asc');
            $return = $this->db->get()->result_array();
        }

        return $return;
    }


    public function getMarketTypeIds()
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('is_casino','No');

        $return = $this->db->get()->result_array();

         return $return;
    }


    public function check_active_odds($dataValues)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_runner');
        $this->db->where($dataValues);

        $return = $this->db->get()->row();
        return $return;
    }

    public function get_ball_running_fancy()
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('game_status', 'Ball Running');
        $return = $this->db->get()->result_array();

        return $return;
    }


    public function get_all_fancy($dataValues = array())
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');

        if(!empty($dataValues))
        {
            $this->db->where($dataValues);
        }
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_fancy_by_selection_id($selection_id = null)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('cron_disable', 'Yes');
        $this->db->where('selection_id', $selection_id);
        $return = $this->db->get()->row_array();

        return $return;
    }

    public function list_all_market_types($dataArray = array())
    {
        $this->db->select('mt.market_id,mt.market_name,mt.market_start_time,mt.runner_1_selection_id,mt.runner_1_runner_name,mt.runner_2_selection_id,mt.runner_2_runner_name,mbo.status,mbo.inplay,mbo.complete');
        $this->db->from('market_types as mt');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = mt.market_id');
        if (isset($dataArray['event_id'])) {
            $this->db->where('mt.event_id', $dataArray['event_id']);
        }

        // $this->db->where('mt.market_name <>', 'Bookmaker');

        // $this->db->where('mt.winner_selection_id', '');
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function get_active_market_events($dataArray = array())
    {
        // $this->db->select('le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date');
        // $this->db->from('list_events as le');
        // if (isset($dataArray['event_id'])) {
        //     $this->db->where('le.event_id', $dataArray['event_id']);
        // }

        // // if (isset($dataArray['inplay'])) {
        // //     $this->db->where('mbo.inplay', $dataArray['inplay']);
        // // }

        // $return = $this->db->get()->result_array();

        // p($this->db->last_query());
        $this->db->select('le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date');
        $this->db->from('market_book_odds as mb');
        $this->db->join('list_events as le', 'le.event_id = mb.event_id', 'left');

        $this->db->where($dataArray);
        $this->db->where('mb.status', 'OPEN');
        $this->db->group_by('mb.event_id');
        $return = $this->db->get()->result_array();

         return $return;
    }

    public function get_market_book_odds_runner_by_id($dataArray = array())
    {
        $return  = NULL;
        if (!empty($dataArray)) {
            $this->db->select('*');
            $this->db->from('market_book_odds_runner');
            $this->db->where('market_id', $dataArray['market_id']);
            $this->db->where('selection_id', $dataArray['selection_id']);

            $this->db->order_by('sort_priority', 'asc');
            $return = $this->db->get()->row();
        }

        return $return;
    }
}
