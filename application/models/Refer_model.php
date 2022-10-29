<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refer_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model
     */
    public function __construct()
    {
        parent::__construct();
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


    public function getAllReferedUsers($pagingParams = array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('registered_users.*, count(d.id) as total_deposit_count');
        $this->db->from('registered_users ');
        $this->db->join('deposit_request d', 'd.user_id = registered_users.user_id and d.status = "Confirm"', 'left');
        $this->db->where('is_delete', 'No');
        // $this->db->where('d.status', 'Confirm');
        $this->db->where('site_code', getCustomConfigItem('site_code'));

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

        if (isset($pagingParams['referral_code']) && !empty($pagingParams['referral_code'])) {

            $this->db->where('referral_code', $pagingParams['referral_code']);
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
        $this->db->group_by('user_id');
        $return = $this->get_with_count(null, $pagingParams['records_per_page'], $pagingParams['offset']);

        return $return;
    }

    public function getAllReferedUsersDownline($pagingParams = array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('r.*');
        $this->db->from('registered_users r');
        // $this->db->join('registered_users d', 'd.user_id = r.referral_code', 'left');
        $this->db->where('is_delete', 'No');
        $this->db->where('site_code', getCustomConfigItem('site_code'));

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

        if (isset($pagingParams['referral_code']) && !empty($pagingParams['referral_code'])) {

            $this->db->where('referral_code', $pagingParams['referral_code']);
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
        $this->db->group_by('user_id');
        $return = $this->get_with_count(null, $pagingParams['records_per_page'], $pagingParams['offset']);

        return $return;
    }

    public function get_refered_users_list($referral_code)
    {
        $this->db->select('registered_users.user_name,registered_users.user_id, count(d.id) as total_deposit_count');
        $this->db->from('registered_users ');
        $this->db->join('deposit_request d', 'd.user_id = registered_users.user_id and d.status = "Confirm"', 'left');
        $this->db->where('is_delete', 'No');
        $this->db->where('registered_users.referral_code', $referral_code);
        $this->db->where('site_code', getCustomConfigItem('site_code'));
        return $this->db->get()->result_array();
    }
}
