<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Betting_model extends My_Model
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

    public function get_event_entry_by_event_id($event_id)
    {
        $this->db->select('*');
        $this->db->from('event_exchange_entrys');
        $this->db->where('event_id', $event_id);
        $return = $this->db->get()->row();
        return $return;
    }


    public function check_event_entry_exists($evend_id)
    {
        $this->db->select('*');
        $this->db->from('event_exchange_entrys');
        $this->db->where('event_id', $evend_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function addBetting($dataValues)
    {
        $betting_id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('betting_id', $dataValues) && !empty($dataValues['betting_id'])) {
                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('betting_id', $dataValues['betting_id']);
                $this->db->where('is_delete', 'No');

                $this->db->update('betting', $dataValues);
                $betting_id = $dataValues['betting_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('betting', $dataValues);
                $betting_id = $this->db->insert_id();
            }
        }

        return $betting_id;
    }

    public function deleteChip($chip_id)
    {
        if (!empty($chip_id)) {
            $this->db->where('chip_id', $chip_id);

            $this->db->delete('chips');
        }
    }



    public function count_total_exposure($user_id)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('is_delete', 'No');

        $this->db->where('user_id', $user_id);
        $return = $this->db->get()->result();

        return $return;
    }


    // public function count_total_balance($user_id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('ledger');
    //     $this->db->where('user_id', $user_id);
    //     $this->db->where('is_delete', 'No');

    //     $this->db->limit('0,1');

    //     $this->db->order_by("ledger_id", "asc");

    //     $return = $this->db->get()->row();
    //     return $return;
    // }

    public function get_bettings_list($dataValues)
    {

        $match_id = $dataValues['match_id'];
        if (!empty($dataValues)) {
            $this->db->select('*,rs.user_name,rs.user_name as client_name,rs.name as client_user_name,mt.market_name as market_name,et.name as game, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type = le.event_type', 'left');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');

            if ($match_id == '98790' || $match_id == '56767' || $match_id == '56967' || $match_id == '87564' || $match_id == '56768' || $match_id == '98791') {
                $this->db->join('market_book_odds as mbs', 'mt.market_id = mbs.market_id', 'left');
            }



            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.match_id', $dataValues['match_id']);
            $this->db->where('b.status', 'Open');



            if ($match_id == '98790' || $match_id == '56767' || $match_id == '56967' || $match_id == '87564' || $match_id == '56768' || $match_id == '98791') {
                $this->db->where('mbs.status', 'OPEN');
            }

            $this->db->order_by('b.created_at', 'asc');


            $return = $this->db->get()->result_array();


            return $return;
        }
    }

    public function get_bettings($dataValues)
    {

        $user_id = $this->get_user_id_by_masters();
        if (!empty($dataValues)) {
            $this->db->select('b.*,le.*,lc.*,mt.*,et.*,ru.user_name as client_name,ru.name as client_user_name,et.name as game,b.status betting_status, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
            $this->db->join('list_competitions as lc', 'lc.competition_id=le.competition_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id=b.market_id', 'left');
            // $this->db->where('b.is_delete', 'No');


            if ($_SESSION['my_userdata']['user_type'] != 'User') {

                if (!empty($dataValues['user_id'])) {
                    $this->db->where('ru.user_id', $dataValues['user_id']);
                } else if (!empty($user_id->master_id)) {
                    $this->db->where('ru.master_id', $user_id->master_id);
                }

                if (isset($dataValues['match_id'])) {
                    $this->db->where('b.match_id', $dataValues['match_id']);
                }
            } else {
                $this->db->where('ru.user_id', $_SESSION['my_userdata']['user_id']);
                if (isset($dataValues['match_id'])) {
                    $this->db->where('b.match_id', $dataValues['match_id']);
                }
            }

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }

            if (!empty($dataValues['betting_type'])) {
                $this->db->where('b.betting_type', $dataValues['betting_type']);
            }

            if (!empty($dataValues['market_id'])) {
                $this->db->where('b.market_id', $dataValues['market_id']);
            }

            if (!empty($dataValues['selection_id'])) {
                $this->db->where('b.selection_id', $dataValues['selection_id']);
            }

            if (!empty($dataValues['status'])) {
                $this->db->where('b.status', $dataValues['status']);
            }

            if (!empty($dataValues['search'])) {
                $this->db->group_start();
                $this->db->like('et.name', $dataValues['search']);
                $this->db->or_like('lc.competition_name', $dataValues['search']);
                $this->db->or_like('le.event_name', $dataValues['search']);
                $this->db->or_like('mt.market_name', $dataValues['search']);
                $this->db->or_like('mt.runner_1_runner_name', $dataValues['search']);
                $this->db->or_like('ru.user_name', $dataValues['search']);

                if ($dataValues['search'] == 'Khai') {
                    $this->db->or_like('b.is_back', 0);
                } else if ($dataValues['search'] == 'Lagai') {
                    $this->db->or_like('b.is_back', 1);
                }

                $this->db->or_like('b.price_val',  $dataValues['search']);
                $this->db->or_like('b.stake',  $dataValues['search']);
                $this->db->or_like('b.created_at',  $dataValues['search']);
                $this->db->or_like('b.profit',  $dataValues['search']);
                $this->db->or_like('b.loss',  $dataValues['search']);
                $this->db->or_like('b.status',  $dataValues['search']);
                $this->db->or_like('b.betting_type',  $dataValues['search']);
                $this->db->or_like('b.betting_id',  $dataValues['search']);
                $this->db->or_like('b.ip_address',  $dataValues['search']);

                $this->db->group_end();
            }

            if (!empty($dataValues['search_p_l'])) {
                $this->db->like('le.event_name', $dataValues['search_p_l']);
            }
            if (!empty($dataValues['sportid'])) {
                if ($dataValues['sportid'] != 5 && $dataValues['sportid'] != 10) {
                    $this->db->where('et.event_type', $dataValues['sportid']);
                } else if ($dataValues['sportid'] == 10) {
                    $this->db->where('b.betting_type', 'Fancy');
                }
            }


            if (!empty($dataValues['pstatus'])) {
                $this->db->where('b.status', $dataValues['pstatus']);
            }

            if (!empty($dataValues['bstatus'])) {
                if ($dataValues['bstatus'] == 'Unmatch') {
                    $this->db->where('b.unmatch_bet', 'Yes');
                } else if ($dataValues['bstatus'] == 'Match') {
                    $this->db->where('b.unmatch_bet', 'No');
                }
            }

            if (!empty($dataValues['status'])) {
                // $this->db->where('b.status', $dataValues['status']);
            }
            $this->db->order_by('b.created_at', 'asc');

            $this->db->group_by('b.betting_id');



            $return = $this->db->get()->result_array();
            return $return;
        }
    }


    public function get_live_bettings($dataValues)
    {

        $user_id = $this->get_user_id_by_masters();
        if (!empty($dataValues)) {
            $this->db->select('b.*,le.*,lc.*,mt.*,et.*,ru.user_name as client_name,ru.name as client_user_name,et.name as game, b.created_at created_at');
            $this->db->from('betting as b');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
            $this->db->join('list_competitions as lc', 'lc.competition_id=le.competition_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id=b.market_id', 'left');
            // $this->db->where('b.is_delete', 'No');

            if ($_SESSION['my_userdata']['user_type'] != 'User') {
                if (!empty($dataValues['user_id'])) {
                    $this->db->where('ru.user_id', $dataValues['user_id']);
                } else if (!empty($user_id->master_id)) {
                    $this->db->where('ru.master_id', $user_id->master_id);
                }
            } else {
                $this->db->where('ru.user_id', $dataValues['user_id']);
                if (isset($dataValues['match_id'])) {
                    $this->db->where('b.match_id', $dataValues['match_id']);
                }
            }

            if (!empty($dataValues['fdate']) && !empty($dataValues['tdate'])) {
                $this->db->where('b.created_at >=', $dataValues['fdate']);
                $this->db->where('b.created_at <=', $dataValues['tdate']);
            }

            if (!empty($dataValues['roundid'])) {
                $this->db->where('b.betting_id', $dataValues['roundid']);
            }

            // p($dataValues);
            if (!empty($dataValues['userName'])) {

                $this->db->group_start();
                $this->db->like('b.created_at', $dataValues['userName']);
                $this->db->or_like('ru.name', $dataValues['userName']);
                $this->db->or_like('ru.user_name', $dataValues['userName']);

                $this->db->or_like('et.name', $dataValues['userName']);
                $this->db->or_like('b.betting_id', $dataValues['userName']);
                $this->db->or_like('b.place_name', $dataValues['userName']);
                $this->db->or_like('mt.market_name', $dataValues['userName']);
                $this->db->or_like('le.event_name', $dataValues['userName']);
                $this->db->or_like('b.betting_type', $dataValues['userName']);
                $this->db->or_like('b.stake', $dataValues['userName']);
                $this->db->or_like('b.p_l', $dataValues['userName']);


                $this->db->group_end();
            }
            if (!empty($dataValues['betStatus'])) {
                $this->db->where('b.status', $dataValues['betStatus']);
            }

            if (!empty($dataValues['searchType'])) {
                $this->db->where('et.event_type', $dataValues['searchType']);
            }
            $this->db->order_by('b.created_at', 'asc');
            $this->db->group_by('b.betting_id');


            $return = $this->db->get()->result_array();

            return $return;
        }
    }



    public function get_all_bettings($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');

            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();
            return $return;
        }
    }

    public function count_event_exposure($dataValues)
    {
        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('betting');
            $this->db->where('is_delete', 'No');

            $this->db->where($dataValues);
            $return = $this->db->get()->result();
            return $return;
        }
    }

    public function get_bettings_markets($user_id)
    {
        $this->db->select('b.*');
        $this->db->from('betting as b');
        // $this->db->join('list_events as le', 'le.event_id = b.match_id');
        // $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        // $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        // $this->db->join('event_types as et', 'et.event_type = le.event_type');


        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        // $this->db->where('b.is_delete', 'No');

        $this->db->group_by('market_id');

        $return = $this->db->get()->result();
        return $return;
    }

    public function get_last_bet($data)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('market_id', $data['market_id']);
        $this->db->where('betting_type', 'Match');
        $this->db->where('status', 'Open');
        $this->db->where('is_delete', 'No');


        $this->db->limit(1);

        $this->db->order_by('betting_id', 'desc');


        // p($this->db->last_query());
        $return = $this->db->get()->row();
        return $return;
    }

    public function get_fancy_bettings_markets($user_id)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Fancy');
        $this->db->where('status', 'Open');
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->result();
        return $return;
    }

    public function get_fancy_last_bet($data)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('selection_id', $data['selection_id']);
        $this->db->where('match_id', $data['match_id']);

        $this->db->where('betting_type', 'Fancy');
        $this->db->where('is_delete', 'No');


        $this->db->order_by('betting_id', 'desc');
        $this->db->group_by('is_back');



        $return = $this->db->get()->result();

        return $return;
    }

    public function get_user_id_by_super_masters()
    {
        $this->db->where('master_id', $_SESSION['my_userdata']['user_id']);
        $master_id = $this->db->get('registered_users')->row();
        return $master_id;
    }

    //
    public function get_user_id_by_masters()
    {
        //        p($this->session);

        if ($_SESSION['my_userdata']['user_id'] == 'Master') {
            $this->db->where('master_id', $_SESSION['my_userdata']['user_id']);
        } elseif ($_SESSION['my_userdata']['user_id'] == 'Super Master') {
            $master = $this->get_user_id_by_super_masters($_SESSION['my_userdata']['user_id']);
            $this->db->where('master_id', $master->user_id);
        }
        $this->db->where('user_type', 'User');
        $query = $this->db->get('registered_users')->row();

        return $query;
    }

    public function get_bettings_by_event_id($paging_params = array())
    {
        if (!empty($paging_params["event_id"])) {
            $query = 'SET @cnt:=0;';
            $this->db->query($query);
            $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
            $this->db->select("b.*,CONCAT(ru.user_name,' (',ru.name,')') as user_name,le.list_event_id,DATE_FORMAT(b.created_at,'%d/%m/%Y %H:%i:%s %a') AS bat_dt, (@cnt := @cnt + 1) AS sn");
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

            $this->db->join('registered_users as rs', 'rs.user_id = mbs.user_id', 'left');
            $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');

            $this->db->where('b.match_id', $paging_params["event_id"]);
            $this->db->where('b.is_delete', 'No');


            if ($paging_params['user_id']) {
                $this->db->where('mbs.user_id', $paging_params["user_id"]);
            }

            // p($paging_params['order_by']);


            if ($paging_params['order_by'] == 'betting_check_box') {
                unset($paging_params['order_by']);
            }
            if (!empty($paging_params['order_by'])) {
                if (empty($paging_params['order_direction'])) {
                    $paging_params['order_direction'] = '';
                }
                switch ($paging_params['order_by']) {
                    default:
                        $this->db->order_by($paging_params['order_by'], $paging_params['order_direction']);
                        break;
                }
            }
            $search = $paging_params['search'];
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('b.betting_id', $search);
                $this->db->or_like('b.place_name', $search);
                $this->db->or_like('rs.user_name', $search);
                $this->db->or_like('b.price_val', $search);
                $this->db->or_like('b.bet_result', $search);
                $this->db->group_end();
            }
            $return = $this->get_with_count(null, $paging_params['records_per_page'], $paging_params['offset']);
            //    p($this->db->last_query());
            return $return;
        }
    }

    public function delete_bet_by_id($betting_id)
    {
        if (!empty($betting_id)) {
            $this->db->where('betting_id', $betting_id);
            $this->db->delete('masters_betting_settings');
            $this->db->where('betting_id', $betting_id);
            $this->db->delete('betting');
        }
    }

    public function get_fancy_bettings($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');




            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();
            return $return;
        }
    }

    public function get_max_fancy_bettings($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MAX(price_val) as max');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');

            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->row();
            return $return->max;
        }
    }

    public function get_min_fancy_bettings($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MIN(price_val) as min');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');

            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->row();
            return $return->min;
        }
    }

    public function get_bettings_by_market_id($dataValues, $usersArr = array())
    {
        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');


            if (!empty($usersArr)) {
                $this->db->group_start();

                foreach ($usersArr as $user) {
                    $this->db->or_where('user_id', $user);
                }
                $this->db->group_end();
            }


            if (!empty($usersArr)) {
                $this->db->group_start();

                foreach ($usersArr as $user) {
                    $this->db->or_where('user_id', $user);
                }
                $this->db->group_end();
            }

            // $this->db->or_where('unmatch_bet', 'No');



            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();

            return $return;
        }
    }


    public function get_bettings_markets1($user_id)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');


        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        // $this->db->where('b.is_delete', 'No');

        $this->db->group_by('market_id');

        $return = $this->db->get()->result();
        return $return;
    }


    public function get_open_markets($dataValues)
    {    
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name, mt.market_name market_name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');

        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $this->db->group_start();
        $this->db->where('mt.market_name', 'Match Odds');
        $this->db->or_where('mt.market_name', 'Toss');
        $this->db->group_end();
        // $this->db->where('b.is_delete', 'No');


        $this->db->group_by('market_id');
        $return = $this->db->get()->result();

        return $return;
    }

    public function get_max_fancy_bettings_by_users($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MAX(price_val) as max');
            $this->db->from('betting');
            $this->db->where('selection_id', $dataValues['selection_id']);
            $this->db->where('match_id', $dataValues['match_id']);


            if (isset($dataValues['users'])) {
                $this->db->group_start();
                foreach ($dataValues['users'] as $user) {
                    $this->db->or_where('user_id', $user);
                }

                $this->db->group_end();
            }
            $this->db->where('is_delete', 'No');


            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->row();

            return $return->max;
        }
    }

    public function get_min_fancy_bettings_by_users($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MIN(price_val) as min');
            $this->db->from('betting');
            $this->db->where('selection_id', $dataValues['selection_id']);

            if (isset($dataValues['users'])) {
                $this->db->group_start();
                foreach ($dataValues['users'] as $user) {
                    $this->db->or_where('user_id', $user);
                }

                $this->db->group_end();
            }

            // $this->db->where('b.is_delete', 'No');

            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->row();
            return $return->min;
        }
    }

    public function get_fancy_bettings_by_users($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('*');
            $this->db->from('betting');
            $this->db->where('selection_id', $dataValues['selection_id']);

            $this->db->where('match_id', $dataValues['match_id']);
            // $this->db->where('b.is_delete', 'No');

            if (isset($dataValues['users'])) {
                $this->db->group_start();
                foreach ($dataValues['users'] as $user) {
                    $this->db->or_where('user_id', $user);
                }

                $this->db->group_end();
            }
            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();

            return $return;
        }
    }


    public function get_open_bets_by_marketid($dataValues)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');

        if (!empty($dataValues)) {
            if (isset($dataValues['market_id'])) {
                $this->db->where('b.market_id', $dataValues['market_id']);
            }
        }
        // $this->db->where('b.is_delete', 'No');

        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $return = $this->db->get()->result();
        return $return;
    }

    public  function get_fancy_group_list($dataValues)
    {
        if (!empty($dataValues)) {
            // $this->db->select('*,rs.user_name,mt.market_name as market_name,et.name as game');
            $this->db->select('*,rs.user_name,et.name as game,b.created_at');

            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id');
            $this->db->join('event_types as et', 'et.event_type = le.event_type');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id');
            // $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.status', 'Open');
            $this->db->where('b.betting_type', 'Fancy');
            // $this->db->where('b.is_delete', 'No');


            $this->db->order_by('betting_id', 'desc');
            $this->db->group_by('b.match_id');

            $this->db->group_by('b.selection_id');



            $return = $this->db->get()->result_array();


            return $return;
        }
    }


    public function get_fancy_by_selectionid($selection_id)
    {
        $this->db->select('*');
        $this->db->from('market_book_odds_fancy');
        $this->db->where('selection_id', $selection_id);
        $return = $this->db->get()->row();
        return $return;
    }

    public function get_market_type_by_marketid($market_id)
    {
        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('market_id', $market_id);
        $return = $this->db->get()->row();
        return $return;
    }


    public function tie_bets_update($dataValues)
    {

        $dataValues["updated_at"] = date("Y-m-d H:i:s");

        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('is_delete', 'No');
        $this->db->where('betting_type', 'Match');
        $this->db->where('market_name', 'Match Odds');
        $this->db->or_where('market_name', 'Bookmaker');




        $this->db->update('betting', array(
            'profit' => '0',
            'loss' => '0',
            'exposure_1' => '0',
            'exposure_2' => '0',
            'status' => 'Settled',
            'is_tie' => 'Yes',
        ));
    }

    public function get_bettings_by_marketid($market_id)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('market_id', $market_id);
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_all_betts($dataValues)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where($dataValues);
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function count_fancy($dataValues)
    {
        $this->db->select('COUNT(*) as total_fancy_bets');
        $this->db->from('betting');
        $this->db->where($dataValues);
        $this->db->where('betting_type', 'Fancy');
        $this->db->where('status', 'Open');
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->row();
        return $return;
    }

    public function count_match_bets($dataValues)
    {
        $this->db->select('COUNT(*) as total_match_bets');
        $this->db->from('betting');
        $this->db->where($dataValues);
        $this->db->where('betting_type', 'Match');
        $this->db->where('status', 'Open');
        $this->db->where('is_delete', 'No');


        $return = $this->db->get()->row();
        return $return;
    }

    public function operator_bettings_list($dataValues)
    {
        if (!empty($dataValues)) {
            $this->db->select('*,rs.user_name,rs.user_name as client_name,rs.name as client_user_name,mt.market_name as market_name,et.name as game, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type = le.event_type', 'left');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');
            $this->db->where('b.match_id', $dataValues['match_id']);
            $this->db->where('b.status', 'Open');
            // $this->db->where('b.is_delete', 'No');

            $this->db->order_by('b.created_at', 'asc');


            $return = $this->db->get()->result_array();


            return $return;
        }
    }

    public function count_fancy_bets($dataValues)
    {
        $this->db->select('COUNT(*) as total_match_bets');
        $this->db->from('betting');
        $this->db->where($dataValues);
        $this->db->where('betting_type', 'Fancy');
        $this->db->where('status', 'Open');


        $return = $this->db->get()->row();
        return $return->total_match_bets;
    }

    public function get_unsettled_bets_events($dataValues)
    {
        $this->db->select('le.list_event_id,le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date,b.created_at');
        $this->db->from('list_events as le');
        $this->db->join('betting as b', 'b.match_id = le.event_id', 'left');


        $this->db->where($dataValues);
        $this->db->where('b.status', 'Open');
        $this->db->group_by('b.match_id');
        $return = $this->db->get()->result_array();

        return $return;
    }

    public function get_settled_betts_by_multiple_users($dataValues)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('status', 'Settled');
        $this->db->where('is_delete', 'No');

        if ($dataValues['user_arr']) {
            $usersArr = $dataValues['user_arr'];
            $this->db->group_start();
            foreach ($usersArr as $user) {
                $this->db->or_where('user_id', $user);
            }
            $this->db->group_end();
        }

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_all_bets()
    {

        $this->db->select('*');
        $this->db->from('betting');
        $this->db->order_by('betting_id', 'asc');
        $this->db->where('is_delete', 'No');

        $this->db->limit(200, 5400);

        $return = $this->db->get()->result();
        return $return;
    }

    public function get_casino_open_bets_by_marketid($dataValues)
    {
        $this->db->select('b.*');
        $this->db->from('betting as b');


        if (!empty($dataValues)) {
            if (isset($dataValues['market_id'])) {
                $this->db->where('b.market_id', $dataValues['market_id']);
            }
        }
        $this->db->where('betting_type', 'Match');
        // $this->db->where('b.is_delete', 'No');

        $this->db->where('b.status', 'Open');
        $return = $this->db->get()->result();
        return $return;
    }

    public function count_total_winnings($user_id = null, $winningsDate = null)
    {
        $this->db->select('SUM(profit) as profit');
        $this->db->from('betting');
        $this->db->where('status', 'Settled');
        $this->db->where('bet_result', 'Plus');
        $this->db->where('user_id', $user_id);


        if (!empty($winningsDate)) {
            $this->db->where('created_at <=', $winningsDate);
        }
        $profit = $this->db->get()->row()->profit;



        $this->db->select('SUM(loss) as loss');
        $this->db->from('betting');
        $this->db->where('status', 'Settled');
        $this->db->where('bet_result', 'Minus');
        $this->db->where('is_delete', 'No');
        if (!empty($winningsDate)) {
            $this->db->where('created_at <=', $winningsDate);
        }
        $this->db->where('user_id', $user_id);
        $loss = $this->db->get()->row()->loss;
        return $profit - $loss;
    }

    public function get_running_markets($dataValues)
    {
        $this->db->select('mbs.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name, mt.market_name market_name,b.created_at');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');

        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');
        $this->db->where('b.betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $this->db->where('mt.market_name', 'Match Odds');
        $this->db->where('b.market_id', $dataValues['market_id']);
        $this->db->where('b.match_id', $dataValues['match_id']);
        $this->db->where('mbs.user_id', $dataValues['user_id']);
        // $this->db->where('b.is_delete', 'No');


        $return = $this->db->get()->result();

        return $return;
    }

    public function get_failed_bettings()
    {
        $this->db->select('b.*,l.ledger_id,rs.user_name as client_name,et.name as game,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('ledger as l', 'b.betting_id=l.betting_id', 'left');
        $this->db->join('registered_users as rs', 'rs.user_id = b.user_id', 'left');
        $this->db->join('event_types as et', 'et.event_type = b.event_type', 'left');


        $this->db->where('l.ledger_id IS NULL', null, false);
        $this->db->where('b.status', 'Settled');
        // $this->db->where('b.is_delete', 'No');


        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_unsettled_bettings_market()
    {

        $this->db->select('*');
        $this->db->from('betting');
        $this->db->order_by('betting_id', 'asc');
        $this->db->where('is_delete', 'No');
        $this->db->where('status', 'Open');
        $this->db->group_start();
        $this->db->where('event_type', '1001');
        $this->db->or_where('event_type', '1002');

        $this->db->or_where('event_type', '1003');
        $this->db->or_where('event_type', '1004');
        $this->db->or_where('event_type', '1005');
        $this->db->or_where('event_type', '1006');
        $this->db->or_where('event_type', '1007');
        $this->db->group_end();
        $this->db->group_by('market_id');

        $return = $this->db->get()->result_array();

        return $return;
    }

    public function getMarketRoundId($market_id)
    {

        $this->db->select('*');
        $this->db->from('market_types');
        $this->db->where('market_id', $market_id);


        $return = $this->db->get()->row_array();


        return $return;
    }

    public function get_betting_by_betting_id($betting_id)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('betting_id', $betting_id);
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->row_array();
        return $return;
    }

    public function get_betting_by_runner_id($dataArray)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('match_id', $dataArray['match_id']);
        $this->db->where('market_id', $dataArray['market_id']);
        $this->db->where('selection_id', $dataArray['selection_id']);
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->result_array();
        return $return;
    }


    public function get_open_bets()
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where('status', 'Open');
        $this->db->where('is_master_update', 'No');



        $return = $this->db->get()->result_array();
        return $return;
    }


    public function get_fancy_betting_events()
    {
        $this->db->select('mbs.master_commission,mbs.sessional_commission,b.*');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');
        $this->db->where('betting_type', 'Fancy');
        $this->db->where('is_fancy_commission_update', 'No');
        $this->db->where('status', 'Settled');

        $this->db->order_by('betting_id', 'DESC');
        $this->db->group_by('match_id');
        $this->db->group_by('user_id');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_fancy_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Fancy');
        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('mbs.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_match_betting_events()
    {
        $this->db->select('mbs.master_commission,mbs.sessional_commission,b.*');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('mt.market_name', 'Match Odds');
        $this->db->where('mbs.user_type', 'User');


        // $this->db->where('match_id', '30700455');
        $this->db->where('is_match_commission_update', 'No');
        $this->db->where('b.status', 'Settled');
        $this->db->where('ru.site_code', 'P11');
        $this->db->where('le.is_casino', 'No');



        $this->db->order_by('betting_id', 'DESC');
        $this->db->group_by('match_id');
        $this->db->group_by('user_id');

        $return = $this->db->get()->result_array();

        return $return;
    }


    public function get_match_odds_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('mt.market_name', 'Match Odds');

        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('mbs.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');

        $return = $this->db->get()->result_array();


        return $return;
    }


    public function count_total_match_profit_loss($user_id, $event_id)
    {


        $query1 = $this->db->query("select s.*,s.credit - s.debit AS Balance
        FROM (SELECT MIN(betting_id) betting_id,b.user_id,SUM(CASE WHEN bet_result = 'Minus' THEN loss ELSE 0 END) AS Debit,
         SUM(CASE WHEN bet_result = 'Plus' THEN profit ELSE 0 END) AS Credit FROM  betting  AS b WHERE  b.user_id = '" . $user_id . "' AND b.match_id = '" . $event_id . "' AND b.betting_type = 'Match'  AND b.market_name = 'Match Odds' and  b.status = 'Settled'  ORDER BY betting_id ) s,
        (SELECT @Balance:=0) rb ORDER BY s.betting_id");

        $resul1 = $query1->row();



        $query2 = $this->db->query("select s.*,s.credit - s.debit AS Balance
        FROM (SELECT MIN(betting_id) betting_id,b.user_id,SUM(CASE WHEN bet_result = 'Minus' THEN loss ELSE 0 END) AS Debit,
         SUM(CASE WHEN bet_result = 'Plus' THEN profit ELSE 0 END) AS Credit FROM  betting  AS b WHERE  b.user_id = '" . $user_id . "' AND b.match_id = '" . $event_id . "' AND b.betting_type = 'Match'  AND b.market_name = 'Bookmaker' and  b.status = 'Settled'  ORDER BY betting_id ) s,
        (SELECT @Balance:=0) rb ORDER BY s.betting_id");
        $resul2 = $query2->row();


        // if($event_id == '30857685')
        // {
        //     p($resul2);
        // }
        return $resul1->Balance + $resul2->Balance;
    }

    public function count_total_session_profit_loss($user_id, $event_id)
    {


        $query = $this->db->query("select s.*,s.credit - s.debit AS Balance
        FROM (SELECT MIN(betting_id) betting_id,b.user_id,SUM(CASE WHEN bet_result = 'Minus' THEN loss ELSE 0 END) AS Debit,
         SUM(CASE WHEN bet_result = 'Plus' THEN profit ELSE 0 END) AS Credit FROM  betting  AS b WHERE  b.user_id = '" . $user_id . "' AND b.match_id = '" . $event_id . "' AND b.betting_type = 'Fancy'  AND b.status = 'Settled'  ORDER BY betting_id ) s,
        (SELECT @Balance:=0) rb ORDER BY s.betting_id");
        $result = $query->row();



        return $result->Balance;
    }

    public function count_total_session_comm($user_id, $event_id)
    {
        $query = $this->db->query("select s.*,s.credit - s.debit AS Balance
        FROM (SELECT MIN(b.betting_id) betting_id,b.user_id,SUM(CASE WHEN bet_result = 'Minus' THEN b.loss * mbs.sessional_commission / 100 ELSE 0 END) AS Debit,
         SUM(CASE WHEN bet_result = 'Plus' THEN b.profit * mbs.sessional_commission / 100 ELSE 0 END) AS Credit FROM  betting  AS b LEFT JOIN `masters_betting_settings` 
         AS mbs ON mbs.betting_id = b.betting_id WHERE   mbs.user_id = '" . $user_id . "' AND b.match_id = '" . $event_id . "' AND b.betting_type = 'Fancy'  AND b.status = 'Settled'  ORDER BY betting_id ) s,
        (SELECT @Balance:=0) rb ORDER BY s.betting_id");
        $result = $query->row();

        // p($this->db->last_query());
        return abs($result->Balance);
    }

    public function count_total_match_comm($user_id, $event_id)
    {
        // $query = $this->db->query("select s.*,s.credit - s.debit AS Balance, s.match_commission AS match_commission
        // FROM (SELECT MIN(b.betting_id) betting_id,b.user_id,SUM(CASE WHEN bet_result = 'Minus' THEN b.loss ELSE 0 END) AS Debit,
        //  SUM(CASE WHEN bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS Credit,mbs.master_commission AS match_commission FROM  betting  AS b LEFT JOIN `masters_betting_settings` 
        //  AS mbs ON mbs.betting_id = b.betting_id WHERE  b.user_id = '".$user_id."' AND mbs.user_id = '".$user_id."' AND b.match_id = '".$event_id."' AND b.betting_type = 'Match'  AND b.status = 'Settled'  ORDER BY betting_id ) s,
        // (SELECT @Balance:=0) rb ORDER BY s.betting_id");
        // $result = $query->row();

        $this->db->select('sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Match');

        $this->db->where('match_id', $event_id);
        $this->db->where('mbs.user_id', $user_id);
        $this->db->where('status', 'Settled');

        $return = $this->db->get()->row();


        return $return;
    }

    public function get_betting_info($user_id, $event_id)
    {


        $this->db->select('sessional_commission,master_commission,partnership');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');


        $this->db->where('match_id', $event_id);
        $this->db->where('mbs.user_id', $user_id);
        $this->db->where('status', 'Settled');

        $return = $this->db->get()->row();

        return $return;
    }

    public function check_user_bet_exists($dataValues = array())
    {

        $this->db->select('count(*) as total_bets');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');


        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('mbs.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');
        $return = $this->db->get()->row();
        return $return;
    }


    public function count_total_master_session_comm($user_id, $event_id)
    {
        $query = $this->db->query("select SUM(b.stake * mbs.`sessional_commission` / 100) AS amount, sessional_commission FROM  registered_users AS ru LEFT JOIN masters_betting_settings  AS mbs ON mbs.user_id = ru.user_id 
        LEFT JOIN betting  AS b ON b.betting_id = mbs.betting_id WHERE (master_id = '" . $user_id . "'  OR ru.user_id = '" . $user_id . "')  AND b.match_id = '" . $event_id . "'
         AND b.betting_type = 'Fancy'  GROUP BY mbs.user_type");
        $results = $query->result_array();

        // p($this->db->last_query());

        $total_comm = 0;

        if (!empty($results)) {
            $total_comm = $results[1]['amount'] - $results[0]['amount'];
        }

        return $total_comm;
    }

    public function count_total_master_match_comm($user_id, $event_id)
    {
        $query = $this->db->query("select s.*,s.credit - s.debit AS Balance
        FROM(SELECT MIN(b.betting_id) betting_id,mbs.user_id,mbs.master_commission,SUM(CASE WHEN bet_result = 'Minus' THEN b.loss * mbs.partnership / 100 ELSE 0 END) AS Debit,
         SUM(CASE WHEN bet_result = 'Plus' THEN b.profit * mbs.partnership / 100 ELSE 0 END) AS Credit  FROM  registered_users AS ru LEFT JOIN masters_betting_settings  AS mbs ON mbs.user_id = ru.user_id 
         LEFT JOIN betting  AS b ON b.betting_id = mbs.betting_id WHERE (master_id = '" . $user_id . "'  OR ru.user_id = '" . $user_id . "')  AND b.match_id = '" . $event_id . "'
          AND b.betting_type = 'Match' AND  b.market_name = 'Match Odds'  GROUP BY mbs.user_type) s,
        (SELECT @Balance:=0) rb ORDER BY s.betting_id");
        $results = $query->result_array();

        // p($this->db->last_query());
        // p($results);
        $total_comm = 0;

        //  if(!empty($results)){
        //     $total_comm = $results[1]['amount'] - $results[0]['amount']; 
        // }

        return $total_comm;
    }


    public function get_transaction_details($user_id)
    {


        $query = $this->db->query("select b.match_id, b.event_name,
        (
        SUM(CASE WHEN b.bet_result = 'Plus' THEN (b.profit - b.profit * mbs.partnership/100)  ELSE 0 END) - 
        SUM(CASE WHEN b.bet_result = 'Minus' THEN (b.loss - b.loss * mbs.partnership/100)  ELSE 0 END))
          AS profit ,mbs.`partnership` FROM `masters_betting_settings` AS mbs LEFT JOIN  betting AS b ON b.`betting_id` = mbs.`betting_id` WHERE mbs.user_id = '" . $user_id . "'     and b.status = 'Settled' GROUP BY b.match_id");
        $result = $query->result_array();


        return $result;
    }


    public function get_master_transaction_details($user_id)
    {


        $query = $this->db->query("select b.match_id, b.event_name,
        (
        SUM(CASE WHEN b.bet_result = 'Minus' THEN (b.profit - b.profit * mbs.partnership/100)  ELSE 0 END) - 
        SUM(CASE WHEN b.bet_result = 'Plus' THEN (b.loss - b.loss * mbs.partnership/100)  ELSE 0 END))
          AS profit ,mbs.`partnership` FROM `masters_betting_settings` AS mbs LEFT JOIN  betting AS b ON b.`betting_id` = mbs.`betting_id` WHERE mbs.user_id = '" . $user_id . "'     and b.status = 'Settled' GROUP BY b.match_id");
        $result = $query->result_array();


        return $result;
    }


    public function get_bookmaker_betting_events()
    {
        $this->db->select('mbs.master_commission,mbs.sessional_commission,b.*');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('market_name', 'Bookmaker');
        $this->db->where('mbs.user_type', 'User');


        // $this->db->where('match_id', '30700455');
        $this->db->where('is_bookmaker_commission_update', 'No');
        $this->db->where('b.status', 'Settled');
        $this->db->where('ru.site_code', 'P11');
        $this->db->where('le.is_casino', 'No');



        $this->db->order_by('betting_id', 'DESC');
        $this->db->group_by('match_id');
        $this->db->group_by('user_id');

        $return = $this->db->get()->result_array();
        return $return;
    }


    public function get_bookmaker_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('market_name', 'Bookmaker');

        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('mbs.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');

        $return = $this->db->get()->result_array();
        return $return;
    }



    public function get_betting_events_user($dataValues = array())
    {
        $this->db->select('*,b.user_id as client_user_id');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        if (!empty($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (!empty($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }

        $this->db->group_by('b.user_id');

        $return = $this->db->get()->result();


        return $return;
    }


    public function get_masters_wise_match_odds_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('mt.market_name', 'Match Odds');

        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('b.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');
        $this->db->where('user_type', $dataValues['user_type']);


        $this->db->group_by('b.betting_id');


        $return = $this->db->get()->result_array();


        return $return;
    }


    public function get_masters_wise_bookmaker_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Match');
        $this->db->where('market_name', 'Bookmaker');

        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('b.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');
        $this->db->where('user_type', $dataValues['user_type']);


        $this->db->group_by('b.betting_id');
        $return = $this->db->get()->result_array();
        return $return;
    }


    public function get_masters_wise_fancy_bettings_by_event_id($dataValues)
    {
        $this->db->select('b.*,mbs.sessional_commission,master_commission');
        $this->db->from('betting as b');

        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Fancy');
        $this->db->where('match_id', $dataValues['match_id']);
        $this->db->where('b.user_id', $dataValues['user_id']);
        $this->db->where('status', 'Settled');
        $this->db->where('user_type', $dataValues['user_type']);


        $this->db->group_by('b.betting_id');

        $return = $this->db->get()->result_array();
        return $return;
    }


    public function count_total_session_stake($user_id, $event_id)
    {
        $this->db->select('SUM(stake) as total_stake');
        $this->db->from('betting as b');
        $this->db->where('betting_type', 'Fancy');
        $this->db->where('user_id', $user_id);
        $this->db->where('match_id', $event_id);
        $this->db->where('status', 'Settled');
        $return = $this->db->get()->row();
        return $return->total_stake;
    }

    public function get_unsettled_settlement_bets_events($dataValues)
    {
        $this->db->select('le.list_event_id,le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date,b.created_at');
        $this->db->from('list_events as le');
        $this->db->join('betting as b', 'b.match_id = le.event_id', 'left');

        if (!empty($dataValues['event_type'])) {
            $this->db->where('le.event_type', $dataValues['event_type']);
        }
        $this->db->where('b.status', 'Open');
        $this->db->group_by('b.match_id');
        $return = $this->db->get()->result();

        return $return;
    }


    public function get_settled_bets_events($dataValues)
    {
        $this->db->select('le.list_event_id,le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date,b.created_at');
        $this->db->from('list_events as le');
        $this->db->join('betting as b', 'b.match_id = le.event_id', 'left');

        if (!empty($dataValues['event_type'])) {
            $this->db->where('le.event_type', $dataValues['event_type']);
        }
        $this->db->where('b.status', 'Settled');
        $this->db->group_by('b.match_id');
        $return = $this->db->get()->result();

        return $return;
    }


    public function count_total_masters_session_stake($user_id, $event_id)
    {
        $this->db->select('SUM(stake) as total_stake');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'mbs.betting_id = b.betting_id', 'left');

        $this->db->where('betting_type', 'Fancy');
        $this->db->where('mbs.user_id', $user_id);
        $this->db->where('match_id', $event_id);
        $this->db->where('status', 'Settled');
        $return = $this->db->get()->row();
        return $return->total_stake;
    }


    // public function count_total_masters_session_stake($user_id, $event_id)
    // {
    //     $this->db->select('SUM(stake) as total_stake');
    //     $this->db->from('masters_betting_settings as mbs');
    //     $this->db->join('betting as b', 'mbs.betting_id = b.betting_id', 'left');

    //     $this->db->where('betting_type', 'Fancy');
    //     $this->db->where('mbs.user_id', $user_id);
    //     $this->db->where('match_id', $event_id);
    //     $this->db->where('status', 'Settled');
    //     $return = $this->db->get()->row();
    //     return $return->total_stake;
    // }


    public function get_unique_fancy_betting_by_event_id($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('b.*');
            $this->db->from('betting as b');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');
            $this->db->where('b.match_id', $dataValues['event_id']);
            // $this->db->where('b.status', 'Open');
            $this->db->where('mbs.user_id',  $dataValues['user_id']);
            $this->db->where('b.betting_type', 'Fancy');


            $this->db->order_by('betting_id', 'desc');
            $this->db->group_by('place_name');



            $return = $this->db->get()->result_array();


            return $return;
        }
    }


    public  function get_all_fancy_group_list($dataValues)
    {
        if (!empty($dataValues)) {
            // $this->db->select('*,rs.user_name,mt.market_name as market_name,et.name as game');
            $this->db->select('b.*');

            $this->db->from('betting as b');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');
            $this->db->where('mbs.user_id', $dataValues['user_id']);
            $this->db->where('b.status', 'Open');
            $this->db->where('b.match_id', $dataValues['match_id']);

            $this->db->where('b.betting_type', 'Fancy');
            $this->db->order_by('betting_id', 'desc');
            $this->db->group_by('b.match_id');
            $this->db->group_by('b.selection_id');



            $return = $this->db->get()->result_array();


            return $return;
        }
    }


    public function get_max_fancy_bettings_by_users_new($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MAX(price_val) as max');
            $this->db->from('betting as b');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');

            $this->db->where('selection_id', $dataValues['selection_id']);
            $this->db->where('match_id', $dataValues['match_id']);
            $this->db->where('mbs.user_id', $dataValues['user_id']);



            // if (isset($dataValues['users'])) {
            //     $this->db->group_start();
            //     foreach ($dataValues['users'] as $user) {
            //         $this->db->or_where('user_id', $user);
            //     }

            //     $this->db->group_end();
            // }
            // $this->db->where('is_delete', 'No');


            $this->db->order_by('b.betting_id', 'asc');
            $return = $this->db->get()->row();

            return $return->max;
        }
    }


    public function get_min_fancy_bettings_by_users_new($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('MIN(price_val) as max');
            $this->db->from('betting as b');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');

            $this->db->where('selection_id', $dataValues['selection_id']);
            $this->db->where('match_id', $dataValues['match_id']);
            $this->db->where('mbs.user_id', $dataValues['user_id']);



            // if (isset($dataValues['users'])) {
            //     $this->db->group_start();
            //     foreach ($dataValues['users'] as $user) {
            //         $this->db->or_where('user_id', $user);
            //     }

            //     $this->db->group_end();
            // }
            // $this->db->where('is_delete', 'No');


            $this->db->order_by('b.betting_id', 'asc');
            $return = $this->db->get()->row();

            return $return->max;
        }
    }

    public function get_fancy_bettings_by_users_new($dataValues)
    {

        if (!empty($dataValues)) {
            $this->db->select('b.*');
            $this->db->from('betting as b');
            $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');


            $this->db->where('selection_id', $dataValues['selection_id']);

            $this->db->where('match_id', $dataValues['match_id']);

            // $this->db->where('b.is_delete', 'No');

            $this->db->where('mbs.user_id', $dataValues['user_id']);

            $this->db->order_by('b.betting_id', 'asc');
            $return = $this->db->get()->result();

            return $return;
        }
    }

    public function get_open_fancy_betting_events()
    {

        $site_code = getCustomConfigItem('site_code');

        // p($site_code);
        $this->db->select('mbs.master_commission,mbs.sessional_commission,b.*,ru.site_code');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');

        $this->db->where('betting_type', 'Fancy');
        $this->db->where('is_fancy_commission_update', 'No');
        $this->db->where('status', 'Settled');
        $this->db->where('ru.site_code', $site_code);


        $this->db->order_by('betting_id', 'DESC');
        $this->db->group_by('match_id');
        $this->db->group_by('user_id');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_open_match_betting_events()
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('mbs.master_commission,mbs.sessional_commission,b.*');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id', 'left');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');


        $this->db->where('betting_type', 'Match');
        $this->db->where('b.market_name', 'Match Odds');
        $this->db->where('mbs.user_type', 'User');
        $this->db->where('ru.site_code', $site_code);


        // $this->db->where('match_id', '30700455');
        $this->db->where('is_match_commission_update', 'No');
        $this->db->where('b.status', 'Settled');
        $this->db->where('le.is_casino', 'No');



        $this->db->order_by('betting_id', 'DESC');
        $this->db->group_by('match_id');
        $this->db->group_by('user_id');

        $return = $this->db->get()->result_array();


        return $return;
    }


    public function check_open_bets_total_by_marketid($dataValues)
    {
        $site_code = getCustomConfigItem('site_code');

        $this->db->select('COUNT(*) as total_open_bets');
        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');

        $this->db->from('betting as b');

        if (!empty($dataValues)) {
            if (isset($dataValues['market_id'])) {
                $this->db->where('b.market_id', $dataValues['market_id']);
            }
        }
        $this->db->where('b.is_delete', 'No');

        $this->db->where('betting_type', 'Match');
        $this->db->where('ru.site_code', $site_code);

        $this->db->where('b.status', 'Open');
        $return = $this->db->get()->row();
        return $return->total_open_bets;
    }

    public function get_event_wise_profit_loss($dataValues)
    {

        if(empty($dataValues['market_id']))
        {
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,(CASE WHEN b.betting_type = 'Fancy' THEN 'Fancy'  ELSE b.market_name END) AS market_name,
            SUM(CASE WHEN l.`is_commission` = 'No'  AND b.bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS profit,
            SUM(CASE WHEN l.`is_commission` = 'No' AND b.bet_result = 'Minus' THEN b.loss  ELSE 0 END) AS loss,SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Credit' THEN l.amount  ELSE 0 END) AS plus_commission,
            SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Debit'  THEN l.amount   ELSE 0 END) AS minus_commission,b.created_at FROM `betting` AS b LEFT JOIN `ledger`
             AS l ON l.betting_id = b.`betting_id`  WHERE b.user_id = '" . $dataValues['user_id'] . "' AND b.match_id = '" . $dataValues['event_id'] . "' and b.status = 'Settled' GROUP BY b.market_name,b.betting_type");
    
            $results = $query->result_array();
        }
        else
        {
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,(CASE WHEN b.betting_type = 'Fancy' THEN 'Fancy'  ELSE b.market_name END) AS market_name,
            SUM(CASE WHEN l.`is_commission` = 'No'  AND b.bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS profit,
            SUM(CASE WHEN l.`is_commission` = 'No' AND b.bet_result = 'Minus' THEN b.loss  ELSE 0 END) AS loss,SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Credit' THEN l.amount  ELSE 0 END) AS plus_commission,
            SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Debit'  THEN l.amount   ELSE 0 END) AS minus_commission,b.created_at FROM `betting` AS b LEFT JOIN `ledger`
             AS l ON l.betting_id = b.`betting_id`  WHERE b.user_id = '" . $dataValues['user_id'] . "' AND b.match_id = '" . $dataValues['event_id'] . "' and b.status = 'Settled' and b.market_id = '".$dataValues['market_id']."'  GROUP BY b.market_name,b.betting_type");
    
            $results = $query->result_array();
        }
       

        return $results;
    }


    public function get_user_profit_loss($dataValues)
    {


    

        $query = $this->db->query("select * from 
        
        (
        select 'No' AS is_casino,market_id,market_name,match_id,event_name,created_at , SUM(profit - loss) AS total_p_l ,SUM(plus_commission - minus_commission) AS total_commission_pl FROM (
        
        SELECT b.match_id,b.market_id,b.event_name,(CASE WHEN b.betting_type = 'Fancy' THEN 'Fancy'  ELSE b.market_name END) AS market_name,
        SUM(CASE WHEN l.`is_commission` = 'No'  AND b.bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS profit,
        SUM(CASE WHEN l.`is_commission` = 'No' AND b.bet_result = 'Minus' THEN b.loss  ELSE 0 END) AS loss,
        
        SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Credit' THEN l.amount  ELSE 0 END) AS plus_commission,
        SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Debit'  THEN l.amount  ELSE 0 END) AS minus_commission,
        b.`created_at`
        FROM `betting` AS b LEFT JOIN `ledger`
        AS l ON l.betting_id = b.`betting_id`  WHERE b.user_id = '" . $dataValues['user_id'] . "'    and b.status = 'Settled' and b.event_type IN (4,2,1,7) AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "'  GROUP BY b.match_id, b.market_name,b.betting_type ) AS ut  GROUP BY match_id
        

        union all


        select 'Yes' AS is_casino,market_id,market_name,match_id,event_name,created_at , SUM(profit - loss) AS total_p_l ,SUM(plus_commission - minus_commission) AS total_commission_pl FROM (
        
            SELECT b.match_id,b.market_id,b.event_name,(CASE WHEN b.betting_type = 'Fancy' THEN 'Fancy'  ELSE b.market_name END) AS market_name,
            SUM(CASE WHEN l.`is_commission` = 'No'  AND b.bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS profit,
            SUM(CASE WHEN l.`is_commission` = 'No' AND b.bet_result = 'Minus' THEN b.loss  ELSE 0 END) AS loss,
            
            SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Credit' THEN l.amount  ELSE 0 END) AS plus_commission,
            SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Debit'  THEN l.amount  ELSE 0 END) AS minus_commission,
            b.`created_at`
            FROM `betting` AS b LEFT JOIN `ledger`
            AS l ON l.betting_id = b.`betting_id`  WHERE b.user_id = '" . $dataValues['user_id'] . "'    and b.status = 'Settled' and b.event_type NOT IN (4,2,1,7)  AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "'  GROUP BY b.match_id,b.market_id, b.market_name,b.betting_type ) AS ut  GROUP BY match_id,market_id
        
        ) as lis ORDER BY created_at ASC");

        $results = $query->result_array();

            // p($this->db->last_query());
        return $results;
    }


    public function get_masters_event_wise_profit_loss($dataValues)
    {


        $query = $this->db->query("select b.match_id,b.market_id,b.event_name,(CASE WHEN b.betting_type = 'Fancy' THEN 'Fancy'  ELSE b.market_name END) AS market_name,
        SUM(CASE WHEN l.`is_commission` = 'No'  AND b.bet_result = 'Plus' THEN b.profit  ELSE 0 END) AS profit,
        SUM(CASE WHEN l.`is_commission` = 'No' AND b.bet_result = 'Minus' THEN b.loss  ELSE 0 END) AS loss,SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Credit' THEN l.amount  ELSE 0 END) AS plus_commission,
        SUM(CASE WHEN l.`is_commission` = 'Yes'  AND l.`transaction_type` = 'Debit'  THEN l.amount   ELSE 0 END) AS minus_commission,b.created_at FROM `betting` AS b LEFT JOIN `ledger`
         AS l ON l.betting_id = b.`betting_id`  WHERE b.user_id = '" . $dataValues['user_id'] . "' AND b.match_id = '" . $dataValues['event_id'] . "' and b.status = 'Settled' GROUP BY b.market_name,b.betting_type");

        $results = $query->result_array();


         return $results;
    }


    public function get_manual_bettings_markets($user_id)
    {
        $site_code = getCustomConfigItem('site_code');
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name,mt.market_name market_name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('manual_list_events as le', 'le.event_id = b.match_id');
        $this->db->join('manual_market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('manual_market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');


        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $this->db->where('le.site_code', $site_code);

        $this->db->group_by('market_id');

        $return = $this->db->get()->result();
        return $return;
    }


    public function get_manual_open_markets($dataValues)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name, mt.market_name market_name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('manual_list_events as le', 'le.event_id = b.match_id');
        $this->db->join('manual_market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('manual_market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');

        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $this->db->where('mt.market_name', 'Match Odds');
        // $this->db->where('b.is_delete', 'No');


        $this->db->group_by('market_id');
        $return = $this->db->get()->result();

        return $return;
    }

    public function cancel_bet_by_id($betting_id)
    {
        if (!empty($betting_id)) {



            $dataValues = array(
                'is_cancel' => 'Yes',

                'profit' => '0',
                'loss' => '0',
                'updated_at' => date("Y-m-d H:i:s")

            );

            $this->db->where('betting_id', $betting_id);
            $this->db->update('masters_betting_settings', $dataValues);



            $dataValues = array(
                'is_cancel' => 'Yes',
                'status' => 'Settled',

                'profit' => '0',
                'loss' => '0',
                'bet_cancel_by' => $_SESSION['my_userdata']['user_name'],
                'updated_at' => date("Y-m-d H:i:s")

            );

            $this->db->where('betting_id', $betting_id);
            $this->db->update('betting', $dataValues);
        }
    }


    public function count_match_wise_masters_commission($dataValues = array())
    {


        $query = $this->db->query("select  ut.total_pl,ut.master_commission ,SUM(CASE WHEN ut.total_pl > 0 THEN ((ut.total_pl * ut.master_commission) / 100)  ELSE 0 END) AS total_commission FROM  (
            SELECT b1.user_id,b1.event_name,b1.market_id,mbs1.master_commission,
            SUM(CASE WHEN b1.bet_result = 'Plus' THEN b1.profit ELSE b1.loss * -1 END) AS total_pl 
            FROM `masters_betting_settings`  AS mbs1 LEFT JOIN betting AS b1 ON b1.betting_id = mbs1.betting_id WHERE  (b1.betting_id IN (
            SELECT b.betting_id FROM `masters_betting_settings` as mbs left join betting as b on b.betting_id = mbs.betting_id  WHERE   mbs.user_id = '".$dataValues['user_id']."'  and b.match_id = '".$dataValues['match_id']."' and b.betting_type = 'Match'    
            )) AND mbs1.user_type  = '".$dataValues['user_type']."' GROUP BY b1.user_id,b1.match_id,b1.market_id
            ) AS ut");
        $result = $query->row();


        // p($this->db->last_query());
        return $result;
    }

    public function count_masters_commission($dataValues = array())
    {


        $query = $this->db->query("select  ut.total_pl,ut.master_commission ,SUM(CASE WHEN ut.total_pl > 0 THEN ((ut.total_pl * ut.master_commission) / 100)  ELSE 0 END) AS total_commission FROM  (
            SELECT b1.user_id,b1.event_name,b1.market_id,mbs1.master_commission,
            SUM(CASE WHEN b1.bet_result = 'Plus' THEN b1.profit ELSE b1.loss * -1 END) AS total_pl 
            FROM `masters_betting_settings`  AS mbs1 LEFT JOIN betting AS b1 ON b1.betting_id = mbs1.betting_id WHERE  (b1.betting_id IN (
            SELECT b.betting_id FROM `masters_betting_settings` as mbs left join betting as b on b.betting_id = mbs.betting_id  WHERE   mbs.user_id = '".$dataValues['user_id']."'and  b.event_type IN (1,4,2) and betting_type = 'Match' 
            )) AND mbs1.user_type  = '".$dataValues['user_type']."' and b1.betting_type = 'Match' GROUP BY b1.user_id,b1.match_id,b1.market_id
            ) AS ut");
        $result = $query->row();


         return $result;
    }



    public function count_total_unmatch_exposure($user_id)
    {
        $query = $this->db->query("select SUM(loss * -1) AS total_exposure  FROM `betting` WHERE user_id = '".$user_id."' AND STATUS = 'Open' AND unmatch_bet = 'Yes'");
        $result = $query->row();


        // p($this->db->last_query());
        return $result;
    }

    public function count_total_unmatch_market_exposure($dataArray = array())
    {
        $query = $this->db->query("select SUM(loss * -1) AS total_exposure  FROM `betting` WHERE user_id = '".$dataArray['user_id']."' and match_id = '".$dataArray['match_id']."' and market_id = '".$dataArray['market_id']."'   AND STATUS = 'Open' AND unmatch_bet = 'Yes'");
        $result = $query->row();


        // p($this->db->last_query());
        return $result;
    }

    public function count_masters_market_exposure($dataValues = array())
    {

        // p("select selection_id,runner_name,(SELECT SUM( 
        //     CASE WHEN is_back = 1 AND selection_id = mbos.`selection_id` THEN mbs.loss * -1  
        //     WHEN is_back = 1 AND selection_id <> mbos.`selection_id` THEN mbs.profit
        //     WHEN is_back = 0 AND selection_id = mbos.`selection_id` THEN mbs.loss 
        //     WHEN is_back = 0 AND selection_id <> mbos.`selection_id` THEN mbs.profit * -1
        //     ELSE 0 END
        //     ) FROM masters_betting_settings AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id 
        //     WHERE mbs.user_id = '".$dataValues['user_id']."' AND b.market_id = '".$dataValues['market_id']."' and b.match_id = '".$dataValues['match_id']."' AND b.status = 'Open' AND b.is_cancel = 'No' AND b.unmatch_bet = 'No') 
        //      AS exposure  
        //      FROM  `market_book_odds_runner`  AS mbos WHERE market_id = '".$dataValues['market_id']."' and event_id = '".$dataValues['match_id']."'
        //     ",0);
        $query1 = $this->db->query("select selection_id,runner_name,(SELECT SUM( 
        CASE WHEN is_back = 1 AND selection_id = mbos.`selection_id` THEN mbs.loss * -1  
        WHEN is_back = 1 AND selection_id <> mbos.`selection_id` THEN mbs.profit
        WHEN is_back = 0 AND selection_id = mbos.`selection_id` THEN mbs.loss 
        WHEN is_back = 0 AND selection_id <> mbos.`selection_id` THEN mbs.profit * -1
        ELSE 0 END
        ) FROM masters_betting_settings AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id 
        WHERE mbs.user_id = '".$dataValues['user_id']."' AND b.market_id = '".$dataValues['market_id']."' and b.match_id = '".$dataValues['match_id']."' AND b.status = 'Open' AND b.is_cancel = 'No' AND b.unmatch_bet = 'No') 
         AS exposure  
         FROM  `market_book_odds_runner`  AS mbos WHERE market_id = '".$dataValues['market_id']."' and event_id = '".$dataValues['match_id']."'
        ");

        $return = $query1->result_array();
        return $return;
    }


    public function get_open_markets_new($dataValues)
    {    

 
        $this->db->select('b.*');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mbs', 'mbs.betting_id = b.betting_id');
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $this->db->where('mbs.user_id', $dataValues['user_id']);

        $this->db->group_start();
        $this->db->where('b.market_name', 'Match Odds');
        $this->db->or_where('b.market_name', 'Toss');
        $this->db->group_end();
        // $this->db->where('b.is_delete', 'No');

        $this->db->group_by('match_id');
        $this->db->group_by('market_id');
        $return = $this->db->get()->result();


 

        return $return;
    }


    public function count_match_market_wise_masters_commission($dataValues = array())
    {
        $query = $this->db->query("select  ut.total_pl,ut.master_commission ,SUM(CASE WHEN ut.total_pl > 0 THEN ((ut.total_pl * ut.master_commission) / 100)  ELSE 0 END) AS total_commission FROM  (
            SELECT b1.user_id,b1.event_name,b1.market_id,mbs1.master_commission,
            SUM(CASE WHEN b1.bet_result = 'Plus' THEN b1.profit ELSE b1.loss * -1 END) AS total_pl 
            FROM `masters_betting_settings`  AS mbs1 LEFT JOIN betting AS b1 ON b1.betting_id = mbs1.betting_id WHERE  (b1.betting_id IN (
            SELECT b.betting_id FROM `masters_betting_settings` as mbs left join betting as b on b.betting_id = mbs.betting_id  WHERE   mbs.user_id = '".$dataValues['user_id']."'  and b.match_id = '".$dataValues['match_id']."' and b.market_id = '".$dataValues['market_id']."'  AND b.`betting_type` = 'Match'    
            )) AND mbs1.user_type  = '".$dataValues['user_type']."'  GROUP BY b1.user_id,b1.match_id,b1.market_id
            ) AS ut");
        $result = $query->row();


        // p($this->db->last_query());
        return $result;
    }


    public function get_unmatch_bettings_by_market_id($dataValues, $usersArr = array())
    {
        if (!empty($dataValues)) {

             $this->db->select('*');
            $this->db->from('betting');
            $this->db->where($dataValues);
            $this->db->where('is_delete', 'No');


         
            $this->db->where('unmatch_bet', 'Yes');



            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();

            return $return;
        }
    }
}
