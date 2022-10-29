<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends My_Model
{

    /**
     * initializes the class inheriting the methods of the class My_Model 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getalladmin($pagingParams = array())
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('id as id, CONCAT_WS(" ",first_name,last_name) as first_name,admin_email,admin_phone,admin_postal_code,accountstatus as status,DATE_FORMAT(created_at, "%d-%m-%Y") as create_date');
        $this->db->from('admin');

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

        $search = $pagingParams['search'];
        if (!empty($search)) {
            $this->db->like('CONCAT_WS(" ",first_name,last_name)', $search);
        }

        $return = $this->get_with_count(null, $pagingParams['records_per_page'], $pagingParams['offset']);
        return $return;
    }

    public function users_array()
    {
        $data = array();

        $this->db->select('userid, username');
        $this->db->from('users');
        $this->db->order_by('username');
        $this->db->where('type', 'user');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $data[$row['userid']] = $row['username'];
        }
        return $data;
    }

    public function saveadmin($dataValues)
    {
        $return = null;
        if (count($dataValues) > 0) {
            if (array_key_exists('userid', $dataValues)) {
                $this->db->where('userid', $dataValues['userid']);
                $this->db->update('users', $dataValues);
                $return = $dataValues['userid'];
            } else {
                $this->db->insert('users', $dataValues);
                $return = $this->db->insert_id();
            }
        }
        return $return;
    }

    public function getadminbyid($adminid)
    {
        $return = NULL;
        if (!empty($adminid)) {
            $this->db->select('admin.*');
            $this->db->from('admin');
            $this->db->where('id', $adminid);

            $return = $this->db->get()->row();
        }
        return $return;
    }

    public function getadminbyusername($username)
    {
        $return = NULL;
        if (!empty($username)) {
            $this->db->select('users.*');
            $this->db->from('users');
            $this->db->where('username', $username);

            $return = $this->db->get()->row();
        }
        return $return;
    }



    public function get_total_admin()
    {
        $count = $this->db->count_all_results('admin');
        return $count;
    }


    public function signin($username, $password)
    {
        $this->db->where('user_name', $username);
        $this->db->where('is_delete', "No");
        // $this->db->where('password', md5($password));

        $query = $this->db->get('registered_users');

        if ($query->num_rows() > 0) {

            $row = $query->row();
            if ($row->seperate_password == $password || $row->password == md5($password)) {

                return $row;
            } else {

                return FALSE;
            }
        } else {

            return FALSE;
        }
    }

    // public function signin($username, $password)
    // {

    //     $this->db->where('user_name', $username);
    //     $this->db->where('is_delete', "No");
    //     $this->db->where('site_code', getCustomConfigItem('site_code'));

    //     $query = $this->db->get('registered_users');



    //     if ($query->num_rows() > 0) {

    //         $row = $query->row();
    //         if ($row->seperate_password == $password || $row->password == md5($password)) {

    //             return $row;
    //         } else {

    //             return FALSE;
    //         }
    //     } else {

    //         return FALSE;
    //     }
    // }



    public function get_register_data($id)
    {
        $this->db->select('is_demo')
            ->from('registered_users')
            ->where('user_id', $id);
        $return = $this->db->get()->row_array();
        return $return;
    }


    public function deleteadminbyuser_id($employee_id)
    {
        $return = null;
        $dataValues = array(
            "is_delete" => "1"
        );
        $this->db->where('user_id', $employee_id);
        $this->db->update('users', $dataValues);

        $return = $dataValues['userid'];

        return $return;
    }

    public function changeStatusbyuser_id($dataValues)
    {
        $return = null;

        $this->db->where('user_id', $dataValues['user_id']);
        $this->db->update('users', $dataValues);

        $return = $dataValues['user_id'];

        return $return;
    }

    public function check_party_code_exists($username)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('p.*');
        $this->db->from('users as p');
        $this->db->where('p.is_delete', '0');
        $this->db->where('p.status', 'active');

        if (!empty($username)) {
            $this->db->where('p.username', $username);
        }
        $query = $this->db->get()->row();

        if (!empty($query)) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }

    public function check_user_password($username, $password)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 1', false);
        $this->db->select('p.*');
        $this->db->from('registered_users as p');
        $this->db->where('p.user_name', $username);
        $this->db->where('p.password',  $password);

        $query = $this->db->get()->row();

        return $query;
    }

    public function total_users()
    {
        $return = NULL;
        $this->db->select('COUNT(*) as total_user');
        $this->db->where('is_delete', '0');
        $this->db->where('type', 'user');

        $return = $this->db->get('users')->row();
        return $return->total_user;
    }

    public function saveOtp($dataValues)
    {
        $return = null;
        if (count($dataValues) > 0) {

            $this->db->insert('otp_verifyer', $dataValues);
            $return = $this->db->insert_id();
        }
        return $return;
    }
    public function updateOtp($dataValues)
    {
        $return = null;
        if (count($dataValues) > 0) {
            $this->db->where('number', $dataValues['number']);
            $this->db->update('otp_verifyer', $dataValues);
            $return = $this->db->insert_id();
        }
        return $return;
    }

    public function getSavedOtp($dataValues)
    {
        // p($dataValues);
        $return = null;
        if (count($dataValues) > 0) {
            $this->db->where('number', $dataValues['number']);
            $return = $this->db->get("otp_verifyer")->row();
        }

        return $return;
    }
}
