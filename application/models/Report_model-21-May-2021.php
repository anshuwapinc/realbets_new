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
            $this->db->select('b.*,le.*,mt.*,ru.*');
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
            $this->db->select('b.*,le.*,mt.*,ru.*');
            $this->db->from('betting as b');
            $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
            $this->db->join('market_types as mt', 'mt.event_id=b.match_id', 'left');
            $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
            $this->db->where('b.user_id', $dataValues['user_id']);

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

        $this->db->select('b.*,sum(b.stake) as total_stake,ru.name');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');

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

    public function get_client_pl($dataValues)
    {
        $user_id = $this->get_user_id_by_masters();
        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        if (!empty($user_id->master_id)) {
            $this->db->where('ru.master_id', $user_id->master_id);
        }
        //        $this->db->where('b.status','Settled');
        $this->db->group_by('b.user_id');


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
    public function get_market_pl($dataValues)
    {
        $user_id = $this->get_user_id_by_masters();
        //        p($user_id);
        $return = null;

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss ,ru.*,et.*,le.*,lc.*,mt.*');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->join('list_events as le', 'le.event_id=b.match_id', 'left');
        $this->db->join('event_types as et', 'et.event_type=le.event_type', 'left');
        $this->db->join('list_competitions as lc', 'lc.event_type=et.event_type', 'left');
        $this->db->join('market_types as mt', 'mt.event_id=le.event_id', 'left');
        if (!empty($user_id->master_id)) {
            $this->db->where('ru.master_id', $user_id->master_id);
        }
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

        $this->db->select('b.*,ru.*,le.*,et.event_type_id');
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

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,le.*');
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

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*,le.*');
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

        $this->db->select('b.*,sum(b.profit) as sumprofit,sum(b.loss) as sumloss,ru.*');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.is_fancy', 1);
        $this->db->where('ru.user_id', $user_id);
        $query = $this->db->get()->result_array();
        return $query;
    }



    public  function get_settled_accont_by_users($user_id)
    {
        $this->db->select('b.* ,ru.*');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.user_id', $user_id);
        $this->db->where('b.status', 'Settled');
 
        $query = $this->db->get()->result_array();
        return $query;
    }

    public  function get_minus_accont_by_users($user_id)
    {
        $this->db->select('b.* ,ru.*');
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
        $this->db->select('b.*,SUM(b.profit) as plus_amount ,ru.*');
        $this->db->from('betting as b');
        $this->db->join('registered_users as ru', 'ru.user_id=b.user_id', 'left');
        $this->db->where('b.user_id', $user_id);
        $this->db->where('b.status', 'Settled');
        $this->db->where('b.bet_result', 'Plus');
        $this->db->group_by('b.user_id');

        $query = $this->db->get()->row();
         return $query;
    }
}
