<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_profit_loss($dataValues)
    {
        $return = null;
        if (!empty($dataValues)) {
            $this->db->select('b.*,le.*,mt.*,ru.*,b.created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('market_types as mt', 'mt.event_id=b.match_id', 'left');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');


            // if ($_SESSION['my_userdata']['user_type'] != 'User') {
            //     if (!empty($user_id->master_id)) {
            //         $this->db->where('ru.master_id', $user_id->master_id);
            //     }
            // } else {
            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.is_delete', 'No');

            // }


            if ($dataValues['sportid'] != '5' && $dataValues['sportid'] != null) {
                $this->db->where('le.event_type	', $dataValues['sportid']);
            }

            if (!empty($dataValues['search'])) {
                $this->db->like('le.event_name', $dataValues['search']);
            }

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }
            $this->db->where('b.status', 'Settled');
            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function get_chip_summary($dataValues)
    {
        $return = null;
        if (!empty($dataValues)) {
            $this->db->select('b.*,le.*,mt.*,ru.*,b.created_at');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('market_types as mt', 'mt.event_id=b.match_id', 'left');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->where('b.user_id', $dataValues['user_id']);
            $this->db->where('b.is_delete', 'No');

            if ($dataValues['sportid'] != 5) {
                $this->db->where('le.event_type	', $dataValues['sportid']);
            }


            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }

            $return = $this->db->get()->result_array();
        }

        return $return;
    }

    public  function get_user_id_by_super_masters($user)
    {
        $this->db->where('master_id', $user);
        $master_id = $this->db->get('registered_users')->row();
        return  $master_id;
    }
    //
    public  function get_user_id_by_masters()
    {
        //        p($this->session);

        if ($_SESSION['my_userdata']['user_type'] == 'Master') {
            $this->db->where('master_id', $_SESSION['my_userdata']['user_id']);
        } elseif ($_SESSION['my_userdata']['user_type'] == 'Super Master') {
            $master = $this->get_user_id_by_super_masters($_SESSION['my_userdata']['user_id']);
            $this->db->where('master_id', $master->user_id);
        } elseif ($_SESSION['my_userdata']['user_type'] == 'Hyper Super Master') {
            $master = $this->get_user_id_by_super_masters($_SESSION['my_userdata']['user_id']);
            $master1 = $this->get_user_id_by_super_masters($master->user_id);
            $this->db->where('master_id', $master1->user_id);
        }
        $this->db->where('user_type', 'User');
        $query = $this->db->get('registered_users')->row();

        return $query;
    }
    public function get_fancy_stack($dataValues)
    {
        //        p($user_id);
        $return = null;

        $this->db->select('b.*,sum(b.stake) as total_stake,ru.name,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.is_delete', 'No');

        // if (!empty($user_id->master_id)) {
        //     $this->db->where('ru.master_id', $user_id->master_id);
        // }

        if (!empty($dataValues['user_id'])) {
            $this->db->where('ru.user_id', $dataValues['user_id']);
        }
        $this->db->where('b.betting_type', 'Fancy');


        if (!empty($dataValues)) {

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }
        }

        $return = $this->db->get()->result_array();

        return $return;
    }

    // public function get_client_pl($dataValues)
    // {
    //     $user_id = $this->get_user_id_by_masters();
    //     $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,b.created_at');
    //     $this->db->from('betting as b');
    //     $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
    //     if (!empty($user_id->master_id)) {
    //         $this->db->where('ru.master_id', $user_id->master_id);
    //     }
    //     $this->db->where('b.is_delete', 'No');

    //     //        $this->db->where('b.status','Settled');
    //     $this->db->group_by('b.user_id');


    //     if (!empty($dataValues)) {

    //         if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
    //             $this->db->where('b.created_at >=', $dataValues['fromDate']);
    //             $this->db->where('b.created_at <=', $dataValues['toDate']);
    //         }
    //     }

    //     $return = $this->db->get()->result_array();
    //     //        p($this->db->last_query());
    //     return $return;
    // }
    public function get_market_pl($dataValues)
    {
        $user_id = $this->get_user_id_by_masters();
        //        p($user_id);
        $return = null;

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss ,ru.*,et.*,le.*,lc.*,mt.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
        $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
        $this->db->join('list_competitions as lc', 'lc.event_type=et.event_type', 'left');
        $this->db->join('market_types as mt', 'mt.event_id=le.event_id', 'left');
        if (!empty($user_id->master_id)) {
            $this->db->where('ru.master_id', $user_id->master_id);
        }
        $this->db->where('b.is_delete', 'No');

        //        $this->db->where('b.status','Settled');
        $this->db->group_by('lc.list_competition_id');


        if (!empty($dataValues)) {

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }
        }
        $return = $this->db->get()->result_array();
        //        p($this->db->last_query());
        return $return;
    }


    public function get_user_pl($dataValues)
    {
        $user_id = $this->get_user_id_by_masters();
        //        p($user_id);
        $return = null;

        $this->db->select('b.*,ru.*,le.*,et.event_type_id,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
        $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
        $this->db->where('et.event_type_id', $dataValues['event_type']);
        if (!empty($user_id->master_id)) {

            $this->db->where('ru.master_id', $user_id->master_id);
        }
        $this->db->order_by('b.betting_id', $dataValues['orderby']);
        $this->db->limit($dataValues['row_no']);
        $this->db->group_by('ru.user_id');

        if (!empty($dataValues)) {

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }
        }
        $return = $this->db->get()->result_array();
        //        p($this->db->last_query());
        return $return;
    }


    public function get_sports_pl($dataValues)
    {
        $user_id = $this->get_user_id_by_masters();
        //        p($user_id);
        $return = null;

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,le.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
        if (!empty($user_id->master_id)) {
            $this->db->where('ru.master_id', $user_id->master_id);
        }

        $this->db->order_by('b.betting_id', $dataValues['orderby']);
        $this->db->limit($dataValues['row_no']);
        $this->db->group_by('le.event_type');


        if (!empty($dataValues)) {

            if (!empty($dataValues['fromDate']) || !empty($dataValues['toDate'])) {
                $this->db->where('b.created_at >=', $dataValues['fromDate']);
                $this->db->where('b.created_at <=', $dataValues['toDate']);
            }
        }
        $return = $this->db->get()->result_array();
        //        p($this->db->last_query());
        return $return;
    }

    public function get_commission($master_id, $user_type)
    {
        if ($user_type == 'Master') {
            $this->db->where('user_id', $master_id);
            $query = $this->db->get('registered_users')->row();
            return $query;
        }
        if ($user_type == 'Super Master') {
            $this->db->where('user_id', $master_id);
            $query1 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query1->master_id);
            $query = $this->db->get('registered_users')->row();
            return $query;
        }
        if ($user_type == 'Hyper Super Master') {
            $this->db->where('user_id', $master_id);
            $query1 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query1->master_id);
            $query2 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query2->master_id);
            $query3 = $this->db->get('registered_users')->row();

            return $query3;
        }
        if ($user_type == 'Admin') {
            $this->db->where('user_id', $master_id);
            $query1 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query1->master_id);
            $query2 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query2->master_id);
            $query3 = $this->db->get('registered_users')->row();

            $this->db->where('user_id', $query3->master_id);
            $query4 = $this->db->get('registered_users')->row();
            return $query4;
        }

        if ($user_type == 'Operator' || $user_type == 'Super Admin') {

            $this->db->where('user_type', $user_type);
            $query5 = $this->db->get('registered_users')->row();
            return $query5;
        }
    }


    public function get_bet_result_chips($user_id)
    {


        $this->db->where('b.user_id', $user_id);
        $query = $this->db->get('betting as b')->result_array();
        return $query;
    }

    public function get_user_pl_by_events_type($user_id, $event_type_id)
    {

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,le.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
        $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
        $this->db->where('et.event_type_id', $event_type_id);
        $this->db->where('ru.user_id', $user_id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_fancy($user_id)
    {

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.is_fancy', 1);
        $this->db->where('ru.user_id', $user_id);
        $query = $this->db->get()->result_array();
        return $query;
    }



    public  function get_settled_accont_by_users($user_id)
    {
        $this->db->select('b.status,b.profit,b.loss,b.status,mb.partnership,mb.casino_partnership,mb.teenpati_partnership,b.bet_result');
        $this->db->from('betting as b');
        $this->db->join('masters_betting_settings as mb', 'mb.betting_id=b.betting_id', 'left');
        $this->db->where('mb.user_id', $user_id);
        $this->db->where('b.status', 'Settled');
        $this->db->group_by('b.betting_id');


        $query = $this->db->get()->result_array();


        return $query;
    }

    public  function get_minus_accont_by_users($user_id)
    {
        $this->db->select('b.* ,ru.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.user_id', $user_id);
        $this->db->where('b.status', 'Settled');
        $this->db->group_by('b.user_id');

        $query = $this->db->get()->result_array();
        return $query;
    }
    public  function get_plus_accont_by_users($user_id)
    {
        $this->db->select('b.*,SUM(b.profit) as plus_amount ,ru.*,b.created_at');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.user_id', $user_id);
        $this->db->where('b.status', 'Settled');
        $this->db->where('b.bet_result', 'Plus');
        $this->db->group_by('b.user_id');

        $query = $this->db->get()->row();
        return $query;
    }

    public function get_live_bet_history_bettings_list($dataValues = array())
    {

        $site_code = getCustomConfigItem('site_code');
        $return = array();

        $this->db->select('*,mbs.profit as profit,mbs.loss as loss,ru.user_name as client_name,ru.name as client_user_name,et.name as game,b.created_at');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id');
        $this->db->join('event_types as et', 'et.event_type = b.event_type');

        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id');

        $this->db->where('ru.site_code', $site_code);

        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
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

            $this->db->or_like('b.event_name', $dataValues['userName']);
            $this->db->or_like('b.betting_id', $dataValues['userName']);
            $this->db->or_like('b.place_name', $dataValues['userName']);
            $this->db->or_like('b.market_name', $dataValues['userName']);
            $this->db->or_like('b.event_name', $dataValues['userName']);
            $this->db->or_like('b.runner_name', $dataValues['userName']);
            $this->db->or_like('b.price_val', $dataValues['userName']);
            $this->db->or_like('b.runner_name', $dataValues['userName']);


            $this->db->or_like('b.betting_type', $dataValues['userName']);
            $this->db->or_like('b.stake', $dataValues['userName']);
            $this->db->or_like('b.p_l', $dataValues['userName']);


            $this->db->group_end();
        }
        if (!empty($dataValues['betStatus'])) {
            $this->db->where('b.status', $dataValues['betStatus']);
        }

        if (!empty($dataValues['searchType'])) {
            $this->db->where('b.event_type', $dataValues['searchType']);
        }
        $this->db->order_by('b.created_at', 'asc');
        $this->db->group_by('b.betting_id');
        $this->db->where('b.status', 'Open');



        $return = $this->db->get()->result_array();


        return $return;
    }

    public function get_bet_history_bettings_list($dataValues = array())
    {

        $return = array();


        $this->db->select('*,b.profit as profit,b.market_id,b.loss as loss,ru.user_name as client_name,ru.name as client_user_name,et.name as game,b.status betting_status,et.name as name,b.created_at,b.profit as client_profit,b.loss as client_loss,le.event_name as event_name,b.is_tie as betting_is_tie');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id', 'left');
        $this->db->join('event_types as et', 'et.event_type = b.event_type', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');


        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');


        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }


        if (isset($dataValues['is_fancy'])) {

            if($dataValues['is_fancy'] == 'Yes')
            {
                $this->db->where('b.betting_type', 'Fancy');

            }
            else{
            $this->db->where('b.betting_type', 'Match');
                
            }
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }



        if (!empty($dataValues['fdate']) && !empty($dataValues['tdate'])) {
            $this->db->where('b.created_at >=', $dataValues['fdate']);
            $this->db->where('b.created_at <=', $dataValues['tdate']);
        }

        if (!empty($dataValues['roundid'])) {
            $this->db->where('b.betting_id', $dataValues['roundid']);
        }

        // p($dataValues);
        if (!empty($dataValues['search'])) {

            $this->db->group_start();
            $this->db->like('b.created_at', $dataValues['search']);
            $this->db->or_like('ru.name', $dataValues['search']);
            $this->db->or_like('ru.user_name', $dataValues['search']);

            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.betting_id', $dataValues['search']);
            $this->db->or_like('b.place_name', $dataValues['search']);
            $this->db->or_like('b.market_name', $dataValues['search']);
            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('b.price_val', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('mbs.profit', $dataValues['search']);
            $this->db->or_like('mbs.loss', $dataValues['search']);
            $this->db->or_like('b.betting_type', $dataValues['search']);
            $this->db->or_like('b.stake', $dataValues['search']);
            $this->db->or_like('b.p_l', $dataValues['search']);
            $this->db->group_end();
        }

        if (!empty($dataValues['pstatus'])) {
            $this->db->where('b.status', $dataValues['pstatus']);
        }

        if (!empty($dataValues['searchType'])) {
            $this->db->where('b.event_type', $dataValues['searchType']);
        }

        if (!empty($dataValues['sportid'])) {
            if ($dataValues['sportid'] != 5) {
                $this->db->where('b.event_type', $dataValues['sportid']);
            }
        }



        $this->db->order_by('b.created_at', 'asc');
        $this->db->group_by('b.betting_id');


        $return = $this->db->get()->result_array();


        return $return;
    }


    public function get_profit_loss_events($dataValues)
    {
        $return = null;
        if (!empty($dataValues)) {
            $this->db->select('le.*');
            $this->db->from('masters_betting_settings as mb');
            $this->db->join('betting as b', 'b.betting_id=mb.betting_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->where('mb.user_id', $dataValues['user_id']);
            $this->db->where('b.status', 'Settled');
            $this->db->group_by('match_id');

            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function get_profit_loss_betting_by_event_id($dataValues)
    {
        $return = null;
        if (!empty($dataValues)) {
            $this->db->select('mb.*,b.*');
            $this->db->from('masters_betting_settings as mb');
            $this->db->join('betting as b', 'b.betting_id=mb.betting_id', 'left');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->where('mb.user_id', $dataValues['user_id']);
            $this->db->where('b.status', 'Settled');
            $this->db->group_by('match_id');

            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function get_my_ledger_events_list($dataValues = array())
    {

        $return = array();


        $this->db->select('*,mbs.profit as profit,mbs.loss as loss,ru.user_name as client_name,ru.name as client_user_name,et.name as game,b.status betting_status,et.name as name,b.created_at,b.profit as client_profit,b.loss as client_loss,le.event_name as event_name,mbs.partnership,mbs.casino_partnership,mbs.teenpati_partnership,mbs.master_commission,mbs.sessional_commission');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id', 'left');
        $this->db->join('event_types as et', 'et.event_type = b.event_type', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');


        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');


        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }



        if (!empty($dataValues['fdate']) && !empty($dataValues['tdate'])) {
            $this->db->where('b.created_at >=', $dataValues['fdate']);
            $this->db->where('b.created_at <=', $dataValues['tdate']);
        }

        if (!empty($dataValues['roundid'])) {
            $this->db->where('b.betting_id', $dataValues['roundid']);
        }

        // p($dataValues);
        if (!empty($dataValues['search'])) {

            $this->db->group_start();
            $this->db->like('b.created_at', $dataValues['search']);
            $this->db->or_like('ru.name', $dataValues['search']);
            $this->db->or_like('ru.user_name', $dataValues['search']);

            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.betting_id', $dataValues['search']);
            $this->db->or_like('b.place_name', $dataValues['search']);
            $this->db->or_like('b.market_name', $dataValues['search']);
            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('b.price_val', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('mbs.profit', $dataValues['search']);
            $this->db->or_like('mbs.loss', $dataValues['search']);
            $this->db->or_like('b.betting_type', $dataValues['search']);
            $this->db->or_like('b.stake', $dataValues['search']);
            $this->db->or_like('b.p_l', $dataValues['search']);
            $this->db->group_end();
        }

        if (!empty($dataValues['pstatus'])) {
            $this->db->where('b.status', $dataValues['pstatus']);
        }

        if (!empty($dataValues['searchType'])) {
            $this->db->where('b.event_type', $dataValues['searchType']);
        }

        if (!empty($dataValues['sportid'])) {
            if ($dataValues['sportid'] != 5) {
                $this->db->where('b.event_type', $dataValues['sportid']);
            }
        }



        $this->db->order_by('b.created_at', 'asc');
        $this->db->group_by('b.match_id');



        $return = $this->db->get()->result_array();


        return $return;
    }
    public function get_my_ledger_bettings_list($dataValues = array())
    {

        $return = array();


        $this->db->select('*,mbs.profit as profit,mbs.loss as loss,ru.user_name as client_name,ru.name as client_user_name,et.name as game,b.status betting_status,et.name as name,b.created_at,b.profit as client_profit,b.loss as client_loss,le.event_name as event_name,mbs.partnership,mbs.casino_partnership,mbs.teenpati_partnership,mbs.master_commission,mbs.sessional_commission');
        $this->db->from('masters_betting_settings as mbs');
        $this->db->join('betting as b', 'b.betting_id = mbs.betting_id', 'left');
        $this->db->join('event_types as et', 'et.event_type = b.event_type', 'left');
        $this->db->join('list_events as le', 'le.event_id = b.match_id', 'left');


        $this->db->join('registered_users as ru', 'ru.user_id = b.user_id', 'left');


        if (isset($dataValues['market_id'])) {
            $this->db->where('b.market_id', $dataValues['market_id']);
        }

        if (isset($dataValues['user_id'])) {
            $this->db->where('mbs.user_id', $dataValues['user_id']);
        }

        if (isset($dataValues['match_id'])) {
            $this->db->where('b.match_id', $dataValues['match_id']);
        }



        if (!empty($dataValues['fdate']) && !empty($dataValues['tdate'])) {
            $this->db->where('b.created_at >=', $dataValues['fdate']);
            $this->db->where('b.created_at <=', $dataValues['tdate']);
        }

        if (!empty($dataValues['roundid'])) {
            $this->db->where('b.betting_id', $dataValues['roundid']);
        }

        // p($dataValues);
        if (!empty($dataValues['search'])) {

            $this->db->group_start();
            $this->db->like('b.created_at', $dataValues['search']);
            $this->db->or_like('ru.name', $dataValues['search']);
            $this->db->or_like('ru.user_name', $dataValues['search']);

            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.betting_id', $dataValues['search']);
            $this->db->or_like('b.place_name', $dataValues['search']);
            $this->db->or_like('b.market_name', $dataValues['search']);
            $this->db->or_like('b.event_name', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('b.price_val', $dataValues['search']);
            $this->db->or_like('b.runner_name', $dataValues['search']);
            $this->db->or_like('mbs.profit', $dataValues['search']);
            $this->db->or_like('mbs.loss', $dataValues['search']);
            $this->db->or_like('b.betting_type', $dataValues['search']);
            $this->db->or_like('b.stake', $dataValues['search']);
            $this->db->or_like('b.p_l', $dataValues['search']);
            $this->db->group_end();
        }

        if (!empty($dataValues['pstatus'])) {
            $this->db->where('b.status', $dataValues['pstatus']);
        }

        if (!empty($dataValues['searchType'])) {
            $this->db->where('b.event_type', $dataValues['searchType']);
        }

        if (!empty($dataValues['sportid'])) {
            if ($dataValues['sportid'] != 5) {
                $this->db->where('b.event_type', $dataValues['sportid']);
            }
        }



        $this->db->order_by('b.created_at', 'asc');
        $this->db->group_by('b.betting_id');


        $return = $this->db->get()->result_array();


        return $return;
    }


    public function get_my_ledger_report_for_agent($dataValues = array())
    {

        $user_id = $dataValues['user_id'];
        //Calculate Total PL
        $query1 = $this->db->query("select b1.user_id ,b1.match_id,

        (
        SELECT SUM(CASE WHEN b2.bet_result = 'Plus' THEN b2.profit  ELSE 0 END) AS total_match_profit  FROM betting AS b2 WHERE b2.user_id = b1.user_id AND b2.match_id = b1.match_id
        AND betting_type = 'Match'  )  AS total_match_odds_profit,
        
        (
        SELECT SUM(CASE WHEN b2.bet_result = 'Minus' THEN b2.loss  ELSE 0 END) AS total_match_profit  FROM betting AS b2 WHERE b2.user_id = b1.user_id AND b2.match_id = b1.match_id
        AND betting_type = 'Match'   )  AS total_match_odds_loss,
        
       
        
        (
        SELECT SUM(CASE WHEN b2.bet_result = 'Plus' THEN b2.profit  ELSE 0 END) AS total_match_profit  FROM betting AS b2 WHERE b2.user_id = b1.user_id AND b2.match_id = b1.match_id
        AND betting_type = 'Fancy')  AS total_fancy_profit,
        
        (
        SELECT SUM(CASE WHEN b2.bet_result = 'Minus' THEN b2.loss  ELSE 0 END) AS total_match_profit  FROM betting AS b2 WHERE b2.user_id = b1.user_id AND b2.match_id = b1.match_id
        AND betting_type = 'Fancy'  )  AS total_fancy_loss,
        
        (
        SELECT SUM(stake) AS total_match_profit  FROM betting AS b2 WHERE b2.user_id = b1.user_id AND b2.match_id = b1.match_id AND betting_type = 'Fancy'
        )  AS total_fancy_stake,
        
        (
        SELECT master_commission FROM masters_betting_settings AS mbs3 LEFT JOIN betting AS b3 ON mbs3.betting_id = b3.betting_id  WHERE b3.match_id AND mbs3.user_id = '" . $user_id . "' GROUP BY mbs3.user_id
        )  AS master_commission,
        
        (
        SELECT sessional_commission FROM masters_betting_settings AS mbs3 LEFT JOIN betting AS b3 ON mbs3.betting_id = b3.betting_id  WHERE b3.match_id AND mbs3.user_id = '" . $user_id . "' GROUP BY mbs3.user_id
        )  AS sessional_commission,
        
        (
        SELECT partnership FROM masters_betting_settings AS mbs3 LEFT JOIN betting AS b3 ON mbs3.betting_id = b3.betting_id  WHERE b3.match_id AND mbs3.user_id = '" . $user_id . "' GROUP BY mbs3.user_id
        )  AS partnership
        
        
         FROM masters_betting_settings AS mbs1 LEFT JOIN betting AS b1 ON mbs1.betting_id = b1.betting_id  WHERE mbs1.betting_id IN 
        (SELECT betting_id FROM masters_betting_settings WHERE user_id = '" . $user_id . "' ) AND mbs1.user_type = 'User' GROUP BY b1.match_id,b1.user_id ");
        $return = $query1->result_array();



        return $return;
    }

    public function get_my_ledger_test($dataValues = array())
    {
        $query = $this->db->query("select b.match_id,b.event_name ,  SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Match' THEN b.profit ELSE 0  END ) profit, SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Match' THEN b.loss ELSE 0  END ) loss,
 
        SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Fancy' THEN b.profit ELSE 0  END ) total_fancy_profit,
         SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Fancy' THEN b.loss ELSE 0  END ) total_fancy_loss,
        
        SUM(CASE WHEN betting_type = 'Fancy' THEN stake ELSE 0  END ) total_fancy_stake, (100 - mbs.`partnership`) AS partnership,
        mbs.master_commission,mbs.sessional_commission,b.created_at,b.event_type
       FROM `betting` AS `b`
       LEFT JOIN `masters_betting_settings` AS `mbs` ON `mbs`.`betting_id` = `b`.`betting_id`
       LEFT JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `b`.`user_id`

       LEFT JOIN `event_types` AS `et` ON `et`.`event_type` = `b`.`event_type`
        WHERE `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
       AND `b`.`status` = 'Settled'
        GROUP BY `b`.`match_id`
       ORDER BY `b`.`created_at` DESC");
        $result = $query->result_array();

        // p($this->db->last_query());



        return $result;
    }


    public function get_profit_loss_events_list($dataValues = array())
    {
        $return = array();
        $query = $this->db->query("select * from (select 'No' AS is_casino,b.market_id,b.market_name,b.match_id,b.event_name , SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Match' THEN b.profit ELSE 0  END ) loss,
        SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Match' THEN b.loss ELSE 0  END ) profit,

        SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Fancy' THEN b.profit ELSE 0  END ) total_fancy_loss,
         SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Fancy' THEN b.loss ELSE 0  END ) total_fancy_profit,
        
        SUM(CASE WHEN betting_type = 'Fancy' THEN stake ELSE 0  END ) total_fancy_stake, (mbs.`partnership`) AS partnership,(mbs.`partnership`) AS total_share,
        mbs.master_commission,mbs.sessional_commission,b.created_at,b.event_type
       FROM `betting` AS `b`
       LEFT JOIN `masters_betting_settings` AS `mbs` ON `mbs`.`betting_id` = `b`.`betting_id`
       LEFT JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `b`.`user_id`

       LEFT JOIN `event_types` AS `et` ON `et`.`event_type` = `b`.`event_type`
        WHERE `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
       AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "' and `b`.`status` = 'Settled' AND b.event_type IN (4,2,1,7)
        GROUP BY `b`.`match_id` 
        
        
        
        union all



        select 'Yes' AS is_casino,b.market_id,b.market_name,b.match_id,b.event_name , SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Match' THEN b.profit ELSE 0  END ) loss,
        SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Match' THEN b.loss ELSE 0  END ) profit,

        SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Fancy' THEN b.profit ELSE 0  END ) total_fancy_loss,
         SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Fancy' THEN b.loss ELSE 0  END ) total_fancy_profit,
        
        SUM(CASE WHEN betting_type = 'Fancy' THEN stake ELSE 0  END ) total_fancy_stake, (mbs.`partnership`) AS partnership,(mbs.`partnership`) AS total_share,
        mbs.master_commission,mbs.sessional_commission,b.created_at,b.event_type
       FROM `betting` AS `b`
       LEFT JOIN `masters_betting_settings` AS `mbs` ON `mbs`.`betting_id` = `b`.`betting_id`
       LEFT JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `b`.`user_id`

       LEFT JOIN `event_types` AS `et` ON `et`.`event_type` = `b`.`event_type`
        WHERE `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
       AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "' and `b`.`status` = 'Settled' AND b.event_type NOT IN (4,2,1,7)
        GROUP BY `b`.`match_id` , `b`.`market_id`
        ) as ut
       ORDER BY `created_at` DESC");
        $result = $query->result_array();





        // p($this->db->last_query());
        return $result;
    }

    public function get_client_pl($dataValues)
    {
        $query = $this->db->query("select  ru.user_id,ru.user_name
        FROM  masters_betting_settings AS `mbs1`
        JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `mbs1`.`user_id`
        WHERE mbs1.betting_id IN
        (SELECT mbs.betting_id
        FROM `masters_betting_settings` AS `mbs`
        JOIN `betting` AS `b` ON `b`.`betting_id` = `mbs`.`betting_id`
        WHERE  
         `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
        AND `b`.`status` = 'Settled'
        AND `b`.`is_delete` = 'No') AND ru.user_type = '" . $dataValues['user_type'] . "'  and mbs1.created_at >= '" . $dataValues['fromDate'] . "' and  mbs1.created_at <= '" . $dataValues['toDate'] . "' GROUP BY user_id;");
        $return = $query->result_array();


        // p($this->db->last_query());



        return $return;
    }




    public function get_super_pl($dataValues)
    {

        if ($dataValues['user_type'] == 'User') {
            $query = $this->db->query("select  SUM(CASE WHEN b1.bet_result = 'Plus' THEN mbs1.profit ELSE 0 END) AS profit,SUM(CASE WHEN b1.bet_result = 'Minus' THEN mbs1.loss ELSE 0 END) AS loss,b1.created_at
            FROM  masters_betting_settings AS `mbs1`
            JOIN `betting` AS `b1` ON `b1`.`betting_id` = `mbs1`.`betting_id`
            WHERE mbs1.betting_id IN
            (SELECT mbs.betting_id
            FROM `masters_betting_settings` AS `mbs`
            JOIN `betting` AS `b` ON `b`.`betting_id` = `mbs`.`betting_id`
            WHERE  
             `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
            AND `b`.`status` = 'Settled'
            AND `b`.`is_delete` = 'No') AND user_type = '" . $dataValues['user_type'] . "' and b1.created_at >= '" . $dataValues['fromDate'] . "' and  b1.created_at <= '" . $dataValues['toDate'] . "';");
            $result = $query->row();
            return $result->profit - $result->loss;
        } else {

            //Comment for test 2 Dec 2021
            $query = $this->db->query("select  SUM(CASE WHEN b1.bet_result = 'Minus' THEN mbs1.profit ELSE 0 END) AS profit,SUM(CASE WHEN b1.bet_result = 'Plus' THEN mbs1.loss ELSE 0 END) AS loss,b1.created_at
            FROM  masters_betting_settings AS `mbs1`
            JOIN `betting` AS `b1` ON `b1`.`betting_id` = `mbs1`.`betting_id`
            WHERE mbs1.betting_id IN
            (SELECT mbs.betting_id
            FROM `masters_betting_settings` AS `mbs`
            JOIN `betting` AS `b` ON `b`.`betting_id` = `mbs`.`betting_id`
            WHERE  
             `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
            AND `b`.`status` = 'Settled'
            AND `b`.`is_delete` = 'No') AND user_type = '" . $dataValues['user_type'] . "' and b1.created_at >= '" . $dataValues['fromDate'] . "' and  b1.created_at <= '" . $dataValues['toDate'] . "';");
            $result = $query->row();
            //Comment for test 2 Dec 2021


            // $query = $this->db->query("select  SUM(CASE WHEN b1.bet_result = 'Plus' THEN mbs1.loss * -1 ELSE mbs1.profit END) AS profit,SUM(CASE WHEN b1.bet_result = 'Minus' THEN b1.profit ELSE 0 END) AS loss,b1.created_at
            // FROM  masters_betting_settings AS `mbs1`
            // JOIN `betting` AS `b1` ON `b1`.`betting_id` = `mbs1`.`betting_id`
            // WHERE mbs1.betting_id IN
            // (SELECT mbs.betting_id
            // FROM `masters_betting_settings` AS `mbs`
            // JOIN `betting` AS `b` ON `b`.`betting_id` = `mbs`.`betting_id`
            // WHERE  
            //  `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
            // AND `b`.`status` = 'Settled'
            // AND `b`.`is_delete` = 'No') AND user_type = '" . $dataValues['user_type'] . "' GROUP BY mbs1.user_id;");
            // $result = $query->row();

            return $result->profit - $result->loss;
        }



        // p($this->db->last_query());
        // p($result);
    }


    public function get_profit_loss_events_list_new($dataValues = array())
    {


        // p($dataValues);
        $return = array();
        $query = $this->db->query("select * FROM (
            
        select 'No' AS is_casino,b.market_id,b.market_name, (SELECT MAX(partnership) - MIN(partnership) AS total_share FROM masters_betting_settings AS mbs
        WHERE betting_id  = b.betting_id AND user_type  IN ('" . $dataValues['parent_user_type'] . "','" . $dataValues['self_user_type'] . "' ) GROUP BY betting_id) AS total_share ,


        b.match_id,b.event_name , SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Match' THEN b.profit ELSE 0  END ) loss,
        SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Match' THEN b.loss ELSE 0  END ) profit,

        SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Fancy' THEN b.profit ELSE 0  END ) total_fancy_loss,
         SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Fancy' THEN b.loss ELSE 0  END ) total_fancy_profit,
        
        SUM(CASE WHEN betting_type = 'Fancy' THEN stake ELSE 0  END ) total_fancy_stake, (mbs.`partnership`) AS partnership,
        mbs.master_commission,mbs.sessional_commission,b.created_at,b.event_type
       FROM `betting` AS `b`
       LEFT JOIN `masters_betting_settings` AS `mbs` ON `mbs`.`betting_id` = `b`.`betting_id`
       LEFT JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `b`.`user_id`

       LEFT JOIN `event_types` AS `et` ON `et`.`event_type` = `b`.`event_type`
        WHERE `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
       AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "' and `b`.`status` = 'Settled' AND b.event_type IN  (4,2,1,7)
        GROUP BY `b`.`match_id`


        union all 

        select 'Yes' AS is_casino,b.market_id,b.market_name, (SELECT MAX(partnership) - MIN(partnership) AS total_share FROM masters_betting_settings AS mbs
        WHERE betting_id  = b.betting_id AND user_type  IN ('" . $dataValues['parent_user_type'] . "','" . $dataValues['self_user_type'] . "' ) GROUP BY betting_id) AS total_share ,


        b.match_id,b.event_name , SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Match' THEN b.profit ELSE 0  END ) loss,
        SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Match' THEN b.loss ELSE 0  END ) profit,

        SUM(CASE WHEN bet_result = 'Plus' AND betting_type = 'Fancy' THEN b.profit ELSE 0  END ) total_fancy_loss,
         SUM(CASE WHEN bet_result = 'Minus'  AND betting_type = 'Fancy' THEN b.loss ELSE 0  END ) total_fancy_profit,
        
        SUM(CASE WHEN betting_type = 'Fancy' THEN stake ELSE 0  END ) total_fancy_stake, (mbs.`partnership`) AS partnership,
        mbs.master_commission,mbs.sessional_commission,b.created_at,b.event_type
       FROM `betting` AS `b`
       LEFT JOIN `masters_betting_settings` AS `mbs` ON `mbs`.`betting_id` = `b`.`betting_id`
       LEFT JOIN `registered_users` AS `ru` ON `ru`.`user_id` = `b`.`user_id`

       LEFT JOIN `event_types` AS `et` ON `et`.`event_type` = `b`.`event_type`
        WHERE `mbs`.`user_id` = '" . $dataValues['user_id'] . "'
       AND b.updated_at >= '" . $dataValues['fromDate'] . "' AND b.updated_at <= '" . $dataValues['toDate'] . "' and `b`.`status` = 'Settled' AND b.event_type NOT IN  (4,2,1,7)
        GROUP BY `b`.`match_id`,b.market_id

        ) as ut ORDER BY `created_at` DESC");
        $result = $query->result_array();



 
        return $result;
    }



    public function get_profit_loss_events_market_details($dataValues = array())
    {
        $return = array();

        if(empty($dataValues['market_id']))
        {
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,
            (SELECT MAX(partnership) - MIN(partnership) AS total_share FROM masters_betting_settings AS mbs WHERE betting_id  = b.betting_id AND user_type  IN ('" . $dataValues['parent_user_type'] . "','" . $dataValues['self_user_type'] . "' ) 
            GROUP BY betting_id) AS total_share,b.created_at 
            FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
             betting_type = 'Match'  AND STATUS = 'Settled'GROUP BY b.market_id");
            $result = $query->result_array();
        }
        else
        {
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,
            (SELECT MAX(partnership) - MIN(partnership) AS total_share FROM masters_betting_settings AS mbs WHERE betting_id  = b.betting_id AND user_type  IN ('" . $dataValues['parent_user_type'] . "','" . $dataValues['self_user_type'] . "' ) 
            GROUP BY betting_id) AS total_share,b.created_at 
            FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
             betting_type = 'Match'  AND STATUS = 'Settled'  AND b.market_id = '".$dataValues['market_id']."' GROUP BY b.market_id");
            $result = $query->result_array();
        }
       



        // p($this->db->last_query());


        return $result;
    }


    public function get_profit_loss_events_fancy_details($dataValues = array())
    {
        $return = array();
        $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,
        (SELECT MAX(partnership) - MIN(partnership) AS total_share FROM masters_betting_settings AS mbs WHERE betting_id  = b.betting_id AND user_type  IN ('" . $dataValues['parent_user_type'] . "','" . $dataValues['self_user_type'] . "' ) 
        GROUP BY betting_id) AS total_share,b.created_at 
        FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
         betting_type = 'Fancy'  AND STATUS = 'Settled'GROUP BY b.match_id");
        $result = $query->result_array();



        // p($this->db->last_query());


        return $result;
    }

    public function get_profit_loss_masters_events_market_details($dataValues = array())
    {

        if(empty($dataValues['market_id']))
        {
            $return = array();
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,mbs.partnership as total_share,b.created_at 
            FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
             betting_type = 'Match'  AND STATUS = 'Settled'GROUP BY b.market_id");
            $result = $query->result_array();
        }
        else
        {
            $return = array();
            $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,mbs.partnership as total_share,b.created_at 
            FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
             betting_type = 'Match'  AND STATUS = 'Settled' and b.market_id = '".$dataValues['market_id']."' GROUP BY b.market_id");
            $result = $query->result_array();
        }
       



        // p($this->db->last_query());


        return $result;
    }


    public function get_profit_loss_masters_events_fancy_details($dataValues = array())
    {
        $return = array();
        $query = $this->db->query("select b.match_id,b.market_id,b.event_name,b.market_name,b.betting_type,SUM(CASE WHEN b.`bet_result` = 'Plus' THEN b.profit * -1 ELSE b.loss END) AS total_pl,
        mbs.partnership as total_share,b.created_at 
        FROM `masters_betting_settings` AS mbs LEFT JOIN betting AS b ON b.betting_id = mbs.betting_id WHERE b.match_id = '".$dataValues['match_id']."' AND mbs.user_id = '".$dataValues['user_id']."'  AND
         betting_type = 'Fancy'  AND STATUS = 'Settled'GROUP BY b.match_id");
        $result = $query->result_array();



        // p($this->db->last_query());


        return $result;
    }




    
}
