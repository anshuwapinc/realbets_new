<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends My_Model
{
    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function getAllUsers($pagingParams = array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('registered_users.*,CONCAT(user_name,"(", name,")" ) as user_name');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');


        if ($pagingParams['order_by'] == 'user_checkbox') {
            unset($pagingParams['order_by']);
        }

        if (!empty($pagingParams['order_by'])) {
            if (empty($pagingParams['order_direction'])) {
                $pagingParams['order_direction'] = '';
            }

            switch ($pagingParams['order_by']) {
                default:
                    $this->db->order_by($pagingParams['order_by'], $pagingParams['order_direction']);
                    break;
            }
        }

        $this->db->where('is_closed', 'No');

        if (isset($pagingParams['masters']) && !empty($pagingParams['masters'])) {
            $this->db->group_start();
            foreach ($pagingParams['masters'] as $master) {

                $master = (object) $master;
                // p($master);

                $this->db->or_where('master_id', $master->user_id);
            }

            $this->db->group_end();
        }
        if (isset($pagingParams['master_id']) && !empty($pagingParams['master_id'])) {

            $this->db->where('master_id', $pagingParams['master_id']);
        }
        if (isset($pagingParams['user_type']) && !empty($pagingParams['user_type'])) {
            $this->db->where('user_type', $pagingParams['user_type']);
        }

        $site_code = getCustomConfigItem('site_code');
        $this->db->where('site_code', $site_code);


        $search = $pagingParams['search'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('user_name', $search);
            $this->db->group_end();
        }

        $return = $this->get_with_count(null, $pagingParams['records_per_page'], $pagingParams['offset']);


        return $return;
    }


    public function getAllClosedUsers($pagingParams = array())
    {

        $site_code = getCustomConfigItem('site_code');
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('registered_users.*,CONCAT(user_name,"(", name,")" ) as user_name');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');
        $this->db->where('site_code', $site_code);



        if ($pagingParams['order_by'] == 'user_checkbox') {
            unset($pagingParams['order_by']);
        }

        if (!empty($pagingParams['order_by'])) {
            if (empty($pagingParams['order_direction'])) {
                $pagingParams['order_direction'] = '';
            }

            switch ($pagingParams['order_by']) {
                default:
                    $this->db->order_by($pagingParams['order_by'], $pagingParams['order_direction']);
                    break;
            }
        }

        $this->db->where('is_closed', 'Yes');

        if (isset($pagingParams['master_id']) && !empty($pagingParams['master_id'])) {

            $this->db->where('master_id', $pagingParams['master_id']);
        }
        if (isset($pagingParams['user_type']) && !empty($pagingParams['user_type'])) {
            $this->db->where('user_type', $pagingParams['user_type']);
        }

        $search = $pagingParams['search'];
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('user_name', $search);
            $this->db->group_end();
        }

        $return = $this->get_with_count(null, $pagingParams['records_per_page'], $pagingParams['offset']);

        return $return;
    }


    public function get_all_users($dataValues)
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_closed', 'No');
        $this->db->where('is_delete', 'No');

        if (isset($dataValues['master_id']) && !empty($dataValues['master_id'])) {

            $this->db->where('master_id', $dataValues['master_id']);
        }
        if (isset($dataValues['user_type']) && !empty($dataValues['user_type'])) {
            $this->db->where('user_type', $dataValues['user_type']);
        }

        $return = $this->db->get()->result_array();

        return $return;
    }


    public function addUser($dataValues)
    {
        $user_id = NULL;
        if (count($dataValues) > 0) {
            if (array_key_exists('user_id', $dataValues) && !empty($dataValues['user_id'])) {
                $this->db->where('user_id', $dataValues['user_id']);

                $dataValues["updated_at"] = date("Y-m-d H:i:s");
                $this->db->where('is_delete', 'No');
                $dataValues['last_update_ip'] = $_SERVER['REMOTE_ADDR'];
                $this->db->update('registered_users', $dataValues);
                $user_id = $dataValues['user_id'];
            } else {
                $dataValues["created_at"] = date("Y-m-d H:i:s");
                $this->db->insert('registered_users', $dataValues);
                $user_id = $this->db->insert_id();
            }
        }


        return $user_id;
    }

    public function update_password($where_arr, $update_arr)
    {
        $this->db->where($where_arr);
        $this->db->update('registered_users', $update_arr);
    }


    public function getUserById($user_id)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('e.*');
            $this->db->from('registered_users as e');
            $this->db->where('e.user_id', $user_id);
            $this->db->where('is_delete', 'No');

            $return = $this->db->get()->row();
        }
        return $return;
    }





    public function getAllUserRecords()
    {
        $return = NULL;
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');

        $return = $this->db->get()->result_array();
        return $return;
    }

    public function check_username_exists($username)
    {
        $data = array();

        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('user_name', $username);
        $this->db->where('is_delete', 'No');
        $this->db->where('site_code', getCustomConfigItem('site_code'));
        $query = $this->db->get()->row();

        return $query;
    }

    public function check_username_exists_for_forgot_password($where)
    {
        $data = array();

        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where($where);
        $this->db->where('is_delete', 'No');

        $query = $this->db->get()->row();

        return $query;
    }

    public function get_closed_users($dataValues)
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');

        $this->db->where('is_closed', 'Yes');
        $this->db->where('master_id', $dataValues['master_id']);

        if (isset($dataValues['user_type']) && !empty($dataValues['user_type'])) {
            $this->db->where('user_type', $dataValues['user_type']);
        }

        $return = $this->db->get()->result_array();

        return $return;
    }



    public function getInnerUserById($user_id, $userName = null)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('e.*');
            $this->db->from('registered_users as e');
            $this->db->where('is_delete', 'No');

            $this->db->where('e.master_id', $user_id);
            if ($userName != null) {
                $this->db->group_start();
                $this->db->like('e.user_name', $userName);
                $this->db->or_like('e.name', $userName);


                $this->db->group_end();
            }
            $return = $this->db->get()->result();
        }


        return $return;
    }

    public function getSuperAdmin()
    {
        $return = NULL;
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');

        $this->db->where('user_type', 'Super Admin');

        $return = $this->db->get()->row();


        return $return;
    }

    public function deleteUser($user_id)
    {

        if (!empty($user_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->where('is_delete', 'No');

            $dataValues["updated_at"] = date("Y-m-d H:i:s");
            $dataValues["is_delete"] = "Yes";
            $dataValues['last_update_ip'] = $_SERVER['REMOTE_ADDR'];
            $this->db->update('registered_users', $dataValues);

            $user_id = $dataValues['user_id'];
        }
    }

    public function get_all_closed_users()
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_closed', 'Yes');
        $this->db->where('is_delete', 'No');




        $return = $this->db->get()->result_array();

        return $return;
    }

    public function get_all_registered_users()
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('user_type', 'User');
        $this->db->where('is_delete', 'No');



        // $this->db->limit(50,1);

        $return = $this->db->get()->result_array();

        return $return;
    }

    public function getUserByUserName($user_name)
    {
        $return = NULL;
        if (!empty($user_name)) {
            $this->db->select('e.*');
            $this->db->from('registered_users as e');
            $this->db->where('e.user_name', $user_name);
            $this->db->where('is_delete', 'No');
            $this->db->where('site_code', getCustomConfigItem('site_code'));
            $return = $this->db->get()->row_array();
        }
        return $return;
    }

    public function getUserByIdForBetting($user_id)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('is_betting_open,is_locked,is_closed');
            $this->db->from('registered_users as e');
            $this->db->where('e.user_id', $user_id);
            $this->db->where('is_delete', 'No');

            $return = $this->db->get()->row();
        }
        return $return;
    }


    public function get_registered_users($dataValues)
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_delete', 'No');

        if (!empty($dataValues)) {
            $this->db->where($dataValues);
        }
        // $this->db->limit(50,1);

        $return = $this->db->get()->result_array();

        return $return;
    }


    public function getInnerUserByEventId($dataValues)
    {
        $return = NULL;
        if (!empty($dataValues)) {
            $this->db->select('e.user_id,e.user_name,e.master_id,e.name');
            $this->db->from('registered_users as e');
            $this->db->join('masters_betting_settings as mbs', 'mbs.user_id = e.user_id', 'inner');
            $this->db->join('betting as b', 'b.betting_id = mbs.betting_id', 'inner');



            $this->db->where('e.is_delete', 'No');

            $this->db->where('e.master_id', $dataValues['user_id']);
            $this->db->where('b.match_id', $dataValues['match_id']);
            $this->db->group_by('e.user_id');



            $return = $this->db->get()->result();
        }


        return $return;
    }

    public function getInnerUserIdsById($user_id, $userName = null)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('user_id,user_name,name');
            $this->db->from('registered_users as e');
            $this->db->where('is_delete', 'No');
            $this->db->where('site_code', getCustomConfigItem('site_code'));

            $this->db->where('e.master_id', $user_id);
            if ($userName != null) {
                $this->db->group_start();
                $this->db->like('e.user_name', $userName);
                $this->db->or_like('e.name', $userName);


                $this->db->group_end();
            }
            $return = $this->db->get()->result();
        }


        return $return;
    }

    public function searchUserByUserName($user_id)
    {
        $return = NULL;
        if (!empty($user_id)) {
            $this->db->select('e.*');
            $this->db->from('registered_users as e');
            $this->db->where('e.user_name', $user_id);
            $this->db->where('is_delete', 'No');
            $this->db->where('site_code', 'P11');

            $return = $this->db->get()->row_array();
        }
        return $return;
    }


    public function get_all_users_by_site_code($site_code)
    {
        $this->db->select('*');
        $this->db->from('registered_users');
        $this->db->where('is_closed', 'No');
        $this->db->where('is_delete', 'No');
        $this->db->where('site_code', $site_code);



        $return = $this->db->get()->result_array();

        return $return;
    }

    public function getUserBySiteCode($site_code)
    {
        $return = NULL;
        if (!empty($site_code)) {
            $this->db->select('e.*');
            $this->db->from('registered_users as e');
            $this->db->where('is_delete', 'No');

            $this->db->where('e.site_code', $site_code);

            $return = $this->db->get()->result();
        }


        return $return;
    }


    public function getUserIdsBySiteCode($site_code)
    {
        $return = NULL;
        if (!empty($site_code)) {
            $this->db->select('e.user_id');
            $this->db->from('registered_users as e');
            $this->db->where('is_delete', 'No');

            $this->db->where('e.site_code', $site_code);

            $return = $this->db->get()->result();
        }


        return $return;
    }

    public function get_referred_user_count($dataArray)
    {
        $this->db->select('registered_users.*');
        $this->db->from('registered_users ');
        $this->db->join('deposit_request d', 'd.user_id = registered_users.user_id', 'left');
        $this->db->where('is_delete', 'No');
        // $this->db->where('d.status', 'Confirm');
        $this->db->where('registered_users.referral_code', $dataArray['referral_code']);
        $this->db->group_by('registered_users.user_id');
        $query = $this->db->get();
        $return = $query->num_rows();

        return $return;
    }
}
