<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    /**
     * $ajaxRequest : this is the variable which contains the requested page is via ajax call or not. by default it is false and will be set as false and will be set as true in constructor after validating the request type.
     *
     */

    public $ajaxRequest = false;
    public $template = NULL;

    public function __construct()
    {
        parent::__construct();

        /**
         * validating the request type is ajax or not and setting up the $ajaxRequest variable as true/false.
         *
         */
     
        $requestType = $this->input->server('HTTP_X_REQUESTED_WITH');
        $this->ajaxRequest = strtolower($requestType) == 'xmlhttprequest';

        /**
         * set the default template as blank when the request type is ajax
         */
        if ($this->ajaxRequest === true) {
            $this->load->setTemplate('blank');
        }

        $module = $this->router->fetch_module();

        switch ($module) {
            case 'login':
                $this->load->setTemplate('blank');
                break;
            case 'admin':
                $this->load->setTemplate('admin');
                break;
            // case 'public':
            //     $this->load->setTemplate('public');
            //     break;
        }

        check_password_change();

    }

    public function _remap($method, $params = array())
    {
        $this->load->library('session');
        $this->load->helper('url');

        $module = $this->router->fetch_module();


        if ($module == 'login' || $module == 'public' || $module == 'admin') {
            $arr = array(
                'user_dashboard',
                'association_dashboard',
                'changepassword',
                'user_profile',
                'deleteuser',
                'listuser',
                'add_user_byadmin',
                'admin_dashboard',
                'deleteassociation',
                'listassociation',
                'add_association_byadmin',
                'association_profile',
                'addlottery',
                'listlottery',
                'deletelottery',
                'addlotterytype',
                'listlotterytype',
                'deletelotterytype',
            );
            $association_arr = array(
                'user_dashboard',
                'user_profile',
                'deleteuser',
                'listuser',
                'add_user_byadmin',
                'admin_dashboard',
                'deleteassociation',
                'listassociation',
                'add_association_byadmin',
                'addlotterytype',
                'listlotterytype',
                'deletelotterytype',

            );
            $user_arr = array(
                'association_dashboard',
                'deleteuser',
                'listuser',
                'add_user_byadmin',
                'admin_dashboard',
                'deleteassociation',
                'listassociation',
                'add_association_byadmin',
                'addlottery',
                'listlottery',
                'deletelottery',
                'addlotterytype',
                'listlotterytype',
                'deletelotterytype',
            );

            $admin_arr = array(
                'user_dashboard',
                'user_profile',
                'association_dashboard',
                'association_profile',
                'addlottery',
                'listlottery',
                'deletelottery',
            );

            $user_data = GetLoggedinUserData();
            $arr_userdata = "";
            if (!empty($user_data)) {
                $arr_userdata = $user_data;
            }

            if (isset($arr_userdata['usertype']) && $arr_userdata['usertype'] == "employee") {
                if (array_search($method, $user_arr) !== FALSE) {
                    $referrer = uri_string();
                    $this->session->set_userdata('login_referrer', $referrer); // $method
                    redirect('employee_dashboard');
                }
            } elseif (isset($arr_userdata['usertype']) && $arr_userdata['usertype'] == "admin") {

                if (array_search($method, $admin_arr) !== FALSE) {
                    $referrer = uri_string();
                    $this->session->set_userdata('login_referrer', $referrer); // $method
                    redirect('admin_dashboard');
                }
            }
        }

        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            echo "404";
            // show_404();
        }
    }
}
