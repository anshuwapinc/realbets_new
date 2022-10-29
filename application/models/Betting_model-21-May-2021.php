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
        if (!empty($dataValues)) {
            $this->db->select('*,rs.user_name,rs.user_name as client_name,mt.market_name as market_name,et.name as game, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type = le.event_type', 'left');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');
            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.match_id', $dataValues['match_id']);
            $this->db->where('b.status', 'Open');

            $this->db->order_by('b.created_at', 'asc');


            $return = $this->db->get()->result_array();


            return $return;
        }
    }

    public function get_bettings($dataValues)
    {

        $user_id = $this->get_user_id_by_masters();
        if (!empty($dataValues)) {
            $this->db->select('b.*,le.*,lc.*,mt.*,et.*,ru.user_name as client_name,et.name as game,b.status betting_status, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
            $this->db->join('list_competitions as lc', 'lc.competition_id=le.competition_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id=b.market_id', 'left');
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
            $this->db->select('b.*,le.*,lc.*,mt.*,et.*,ru.user_name as client_name,et.name as game, b.created_at created_at');
            $this->db->from('betting as b');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
            $this->db->join('list_competitions as lc', 'lc.competition_id=le.competition_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id=b.market_id', 'left');
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
            $this->db->where($dataValues);
            $return = $this->db->get()->result();
            return $return;
        }
    }

    public function get_bettings_markets($user_id)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name,mt.market_name market_name');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');


        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');

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

    public function get_bettings_by_event_id($event_id)
    {

        if (!empty($event_id)) {
            $this->db->select('*,rs.user_name');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id');
            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id');
            $this->db->where('b.match_id', $event_id);
            // $this->db->where('b.status', 'Open');

            $this->db->order_by('betting_id', 'desc');


            $return = $this->db->get()->result_array();


            return $return;
        }
    }

    public function delete_bet_by_id($betting_id)
    {
        if (!empty($betting_id)) {
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

            if (!empty($usersArr)) {
                $this->db->group_start();

                foreach ($usersArr as $user) {
                    $this->db->or_where('user_id', $user);
                }
                $this->db->group_end();
            }
            $this->db->order_by('betting_id', 'asc');
            $return = $this->db->get()->result();

            return $return;
        }
    }


    public function get_bettings_markets1($user_id)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');


        $this->db->where('user_id', $user_id);
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');

        $this->db->group_by('market_id');

        $return = $this->db->get()->result();
        return $return;
    }


    public function get_open_markets($dataValues)
    {
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name, mt.market_name market_name');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id');
        $this->db->join('market_book_odds as mbo', 'mbo.market_id = b.market_id');
        $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
        $this->db->join('event_types as et', 'et.event_type = le.event_type');

        // if(!empty($dataValues))
        // {
        //     if(isset())
        // $this->db->where($dataValues);

        // }
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');

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

            if (isset($dataValues['users'])) {
                $this->db->group_start();
                foreach ($dataValues['users'] as $user) {
                    $this->db->or_where('user_id', $user);
                }

                $this->db->group_end();
            }

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
        $this->db->select('b.*,le.event_name,mbo.status as market_status,mt.market_start_time,et.name as sport_name');
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
        $this->db->where('betting_type', 'Match');
        $this->db->where('b.status', 'Open');
        $return = $this->db->get()->result();
        return $return;
    }

    public  function get_fancy_group_list($dataValues)
    {
        if (!empty($dataValues)) {
            // $this->db->select('*,rs.user_name,mt.market_name as market_name,et.name as game');
            $this->db->select('*,rs.user_name,et.name as game');
            
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id');
            $this->db->join('event_types as et', 'et.event_type = le.event_type');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id');
            // $this->db->join('market_types as mt', 'mt.market_id = b.market_id');
            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.status', 'Open');
            $this->db->where('b.betting_type', 'Fancy');


            $this->db->order_by('betting_id', 'desc');
            $this->db->group_by('b.selection_id', 'desc');



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
        $this->db->where('market_id', $dataValues['market_id']);
        $this->db->where('match_id', $dataValues['match_id']);

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
        $return = $this->db->get()->result_array();
        return $return;
    }

    public function get_all_betts($dataValues)
    {
        $this->db->select('*');
        $this->db->from('betting');
        $this->db->where($dataValues);
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


        $return = $this->db->get()->row();
        return $return;
    }

    public function operator_bettings_list($dataValues)
    {
        if (!empty($dataValues)) {
            $this->db->select('*,rs.user_name,rs.user_name as client_name,mt.market_name as market_name,et.name as game, b.created_at as created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');
            $this->db->join('event_types as et', 'et.event_type = le.event_type', 'left');

            $this->db->join('registered_users as rs', 'rs.user_id = b.user_id', 'left');
            $this->db->join('market_types as mt', 'mt.market_id = b.market_id', 'left');
            $this->db->where('b.match_id', $dataValues['match_id']);
            $this->db->where('b.status', 'Open');

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
        $this->db->select('le.competition_id,le.event_type,le.event_id,le.event_name,le.open_date');
        $this->db->from('betting as b');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');

        $this->db->where($dataValues);
        $this->db->where('b.status', 'Open');
        $this->db->group_by('b.match_id');
        $return = $this->db->get()->result_array();
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
        $this->db->where('b.status', 'Open');
        $return = $this->db->get()->result();
          return $return;
    }

    public function count_total_winnings($user_id)
    {
        $this->db->select('SUM(profit) as profit');
        $this->db->from('betting');
        $this->db->where('status', 'Settled');
        $this->db->where('bet_result', 'Plus');
        $this->db->where('user_id', $user_id);
        $profit = $this->db->get()->row()->profit;


        $this->db->select('SUM(loss) as loss');
        $this->db->from('betting');
        $this->db->where('status', 'Settled');
        $this->db->where('bet_result', 'Minus');
        $this->db->where('user_id', $user_id);
        $loss = $this->db->get()->row()->loss;
         return $profit - $loss;
    }
}
