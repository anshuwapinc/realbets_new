<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';
    private $_masters_listing_headers = 'masters_listing_headers';
    private $_masters_listing_headers_1 = 'masters_listing_headers_1';

    private $_users_listing_headers = 'users_listing_headers';
    private $_users_listing_headers_1 = 'users_listing_headers_1';

    private $_users_closed_user_listing_headers = 'users_closed_user_listing_headers';
    private $_masters_closed_user_listing_headers = 'masters_closed_user_listing_headers';



    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_model');
        $this->load->model('Admin_model');
        $this->load->model('Chip_model');
        $this->load->model('User_chip_model');
        $this->load->model('User_info_model');
        $this->load->model('Ledger_model');
        $this->load->model('View_info_model');
        $this->load->model('Withdraw_request_model');
        $this->load->model('Deposit_request_model');
        $this->load->model('Refer_model');


        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");

        // $userdata = $_SESSION['my_userdata'];

        // if (empty($userdata)) {
        //     // redirect('/');
        // }
    }

    public function addUser($user_id = null)
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $userdata = $_SESSION['my_userdata'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_name', 'User ID', 'required|trim');
        $this->form_validation->set_rules('registration_date', 'Registration Date', 'required|trim');

        $dataArray = array();

        if ($this->form_validation->run()) {

            $user_id = $this->input->post('user_id');
            $master_id = $this->input->post('master_id');
            $master_id_tmp = $this->input->post('master_id_tmp');



            if (empty($master_id)) {
                $master_id = $master_id_tmp;
            }
            $user_name = $this->input->post('user_name');
            $password = $this->input->post('password');
            $registration_date = $this->input->post('registration_date');
            $user_type = $this->input->post('user_type');
            $master_commision = $this->input->post('master_commision');
            $sessional_commision = $this->input->post('session_commision');

            $name = $this->input->post('name');
            $partnership = $this->input->post('partnership');
            $casino_partnership = $this->input->post('casino_partnership');
            $teenpati_partnership = $this->input->post('teenpati_partnership');
            $balance = $this->input->post('deposite_bal');


            if (empty($user_id)) {
                $checkUsernameExist = $this->User_model->check_username_exists($user_name);

                if (!empty($checkUsernameExist)) {
                    $array = array(
                        'success' => false,
                        'errorMessage' => 'Username already exists'
                    );

                    echo json_encode($array);
                    exit;
                }
            }


            if (empty($master_id)) {
                $master_id = $_SESSION['my_userdata']['user_id'];
            }


            $site_code = getCustomConfigItem('site_code');
            $dataArray = array(
                "user_id" => $user_id,
                "user_name" => $user_name,
                "registration_date" =>  date('Y-m-d', strtotime($registration_date)),
                "user_type" => $user_type,
                "master_commision" => $master_commision,
                "sessional_commision" => $sessional_commision,


                "master_id" => $master_id,
                "name" => $name,
                "partnership" => $partnership,
                "casino_partnership" => $casino_partnership,
                'teenpati_partnership' => $teenpati_partnership,
                'site_code' => $site_code,
                'balance' => $balance,
            );



            if (!empty($password)) {
                $dataArray['password'] = md5($password);
            }


            $return_user_id = $this->User_model->addUser($dataArray);



            if (empty($this->input->post('user_id'))) {
                /************************Chip Insert*******************/
                $site_code = getCustomConfigItem('site_code');

                $chips = $this->Chip_model->get_all_chips($site_code);
                if (!empty($chips)) {
                    foreach ($chips as $chip) {
                        $dataArray = array(
                            'user_id' => $return_user_id,
                            'chip_id' => $chip['chip_id'],
                            'chip_name' => $chip['chip_name'],
                            'chip_value' => $chip['chip_value'],
                        );

                        $this->User_chip_model->addUserChip($dataArray);
                    }
                }
                /************************Chip Insert*******************/


                /************************User Info Insert*******************/
                if ($user_type === 'Admin') {
                    $settings = $this->User_info_model->get_general_setting();
                } else {
                    $settings = $this->User_info_model->get_general_setting_by_user_id($master_id);
                }
                if (!empty($settings)) {
                    foreach ($settings as $setting) {

                        $dataArray = array(
                            'setting_id' => $setting['setting_id'],
                            'user_id' => $return_user_id,
                            'sport_id' => $setting['sport_id'],
                            'sport_name' => $setting['sport_name'],
                            'min_stake' => $setting['min_stake'],
                            'max_stake' => $setting['max_stake'],
                            'max_profit' => $setting['max_profit'],
                            'max_loss' => $setting['max_loss'],
                            'bet_delay' => $setting['bet_delay'],
                            'pre_inplay_profit' => $setting['pre_inplay_profit'],
                            'pre_inplay_stake' => $setting['pre_inplay_stake'],
                            'min_odds' => $setting['min_odds'],
                            'max_odds' => $setting['max_odds'],
                            'unmatch_bet' => $setting['unmatch_bet'],
                            'lock_bet' => $setting['lock_bet'],
                            'is_odds_active' => $setting['is_odds_active'],
                            'is_fancy_active' => $setting['is_fancy_active'],
                            'is_bookmaker_active' => $setting['is_bookmaker_active'],
                        );

                        $this->User_info_model->addUserInfo($dataArray);
                    }
                }
                /************************User Info Insert*******************/
            }


            if (!empty($balance)) {
                /************************Chip leger create*******************/
                $data = array(
                    'user_id' => $return_user_id,
                    'type' => 'D',
                    'ChipsValue' => $balance,
                    'chip_master_id' => $master_id,
                );

                $this->chip_update_new($data);
            }


            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
            );
        }
        echo json_encode($array);
    }


    public function changePassword($user_id = null)
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $userdata = $_SESSION['my_userdata'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $dataArray = array();

        if ($this->form_validation->run()) {

            $user_id = $this->input->post('user_id');
            $password = $this->input->post('password');

            $dataArray = array(
                "user_id" => $user_id,
            );

            if (!empty($password)) {
                $dataArray['password'] = md5($password);
            }
            $result = $this->User_model->addUser($dataArray);

            $postdata = json_encode(array('user_id' => $user_id));


            $url = 'http://localhost:3000/change-password';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
            );
        }
        echo json_encode($array);
    }



    public function listUsers($type)
    {

        $user_types = get_user_type();
        if (get_user_type() == 'User') {
            redirect('/');
        }


        $user_type = '';
        $next_user = '';


        if ($type == 'hypersupermaster') {
            $user_type = 'Hyper Super Master';
            $next_user = 'Super Master';

            if ($user_types != 'Admin' && $user_types != 'Super Admin') {
                redirect('/');
            }
        } else if ($type == 'supermaster') {
            $user_type = 'Super Master';
            $next_user = 'Master';
            if ($user_types != 'Hyper Super Master' && $user_types != 'Admin'  && $user_types != 'Super Admin') {
                redirect('/');
            }
        } else if ($type == 'master') {
            $user_type = 'Master';
            $next_user = 'User';
            if ($user_types != 'Super Master' && $user_types != 'Hyper Super Master' && $user_types != 'Admin'  && $user_types != 'Super Admin') {
                redirect('/');
            }
        } else if ($type == 'user') {

            $user_type = 'User';

            if ($user_types != 'Master' && $user_types != 'Super Master' && $user_types != 'Hyper Super Master' && $user_types != 'Admin'  && $user_types != 'Super Admin') {
                redirect('/');
            }
        } else if ($type == 'admin') {
            $user_type = 'Admin';
            $next_user = 'Hyper Super Master';
            if ($user_types != 'Super Admin') {
                redirect('/');
            }
        }


        $this->load->library('Datatable');
        $message = $this->session->flashdata('add_admin_operation_message');




        // $this->load->library('Datatable');
        // $message = $this->session->flashdata('message');

        // $table_config = array(
        //     'source' => site_url('admin/User/listUserdata'),
        //     'datatable_class' => $this->config->config["datatable_class"],
        // );

        // $dataArray = array(
        //     'table' => $this->datatable->make_table($this->_user_listing_headers, $table_config),
        //     'message' => $message
        // );



        // $dataArray['local_css'] = array(
        //     'dataTables.bootstrap4',
        //     'responsive.bootstrap4'
        // );

        // $dataArray['local_js'] = array(
        //     'dataTables.min',
        //     'jquery.dataTables.bootstrap',
        //     'dataTables.fnFilterOnReturn',
        //     'dataTables.bootstrap4',
        //     'dataTables.responsive',
        //     'responsive.bootstrap4'
        // );

        $master_id = $_SESSION['my_userdata']['user_id'];

        $dataArray = array(
            'master_id' => $master_id,
            'user_type' => $user_type
        );


        $master_user_detail = $this->User_model->getUserById($master_id);

        // p($master_id);
        $table_config = array(
            'source' => site_url('admin/user/listUsersData/0/' . $user_type),
            'table_id' => 'masters_association_list',
            'datatable_class' => $this->config->config["datatable_class"]
        );


        if (get_user_type() == 'Super Admin' || get_user_type() == 'Admin') {
            if ($user_type == 'User') {
                $dataArray['table'] = $this->datatable->make_table($this->_users_listing_headers_1, $table_config);
            } else {
                $dataArray['table'] = $this->datatable->make_table($this->_masters_listing_headers_1, $table_config);
            }
        } else {
            if ($user_type == 'User') {
                $dataArray['table'] = $this->datatable->make_table($this->_users_listing_headers, $table_config);
            } else {
                $dataArray['table'] = $this->datatable->make_table($this->_masters_listing_headers, $table_config);
            }
        }


        $dataArray['message'] = $message;



        $dataArray['local_css'] = array(
            'jquery.dataTables.bootstrap',
            'jquery-ui'
        );

        $dataArray['local_js'] = array(
            'jquery.dataTables',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'moment',
            'jquery.validate',
            'jquery-ui'
        );

        $dataArray['master_user_detail'] = $master_user_detail;

        $dataArray['type'] = $type;
        $dataArray['next_user'] = $next_user;


        // p($type);
        // p($type);
        if ($master_user_detail->user_type == 'Super Admin') {



            if ($type == 'user') {
                $masterUserIdList = array();
                $adminsLists = $this->User_model->getInnerUserIdsById($master_id);
                if (!empty($adminsLists)) {

                    foreach ($adminsLists as $admin) {

                        $hypersLists = $this->User_model->getInnerUserIdsById($admin->user_id);


                        if (!empty($hypersLists)) {
                            foreach ($hypersLists as $hyper) {
                                $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);


                                if (!empty($supersLists)) {
                                    foreach ($supersLists as $super) {
                                        $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                        if (!empty($mastersLists)) {
                                            foreach ($mastersLists as $master) {




                                                $masterUserIdList[]  = array(
                                                    'user_id' => $master->user_id,
                                                    'user_name' => $master->name . '(' . $master->user_name . ')',

                                                );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'master') {
                $masterUserIdList = array();


                $adminsLists = $this->User_model->getInnerUserIdsById($master_id);


                if (!empty($adminsLists)) {
                    foreach ($adminsLists as $admin) {


                        $hypersLists = $this->User_model->getInnerUserIdsById($admin->user_id);
                        if (!empty($hypersLists)) {
                            foreach ($hypersLists as $hyper) {
                                $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                                if (!empty($supersLists)) {
                                    foreach ($supersLists as $super) {

                                        $masterUserIdList[]  = array(
                                            'user_id' => $super->user_id,
                                            'user_name' => $super->name . '(' . $super->user_name . ')',

                                        );
                                    }
                                }
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'supermaster') {
                $masterUserIdList = array();



                $adminsLists = $this->User_model->getInnerUserIdsById($master_id);


                if (!empty($adminsLists)) {
                    foreach ($adminsLists as $admin) {


                        $hypersLists = $this->User_model->getInnerUserIdsById($admin->user_id);

                        if (!empty($hypersLists)) {
                            foreach ($hypersLists as $hyper) {

                                $masterUserIdList[]  = array(
                                    'user_id' => $hyper->user_id,
                                    'user_name' => $hyper->name . '(' . $hyper->user_name . ')',

                                );
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'hypersupermaster') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {

                        $masterUserIdList[]  = array(
                            'user_id' => $hyper->user_id,
                            'user_name' => $hyper->name . '(' . $hyper->user_name . ')',

                        );
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            }
        } else if ($master_user_detail->user_type == 'Admin') {
            if ($type == 'user') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {
                        $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                        if (!empty($supersLists)) {
                            foreach ($supersLists as $super) {
                                $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                if (!empty($mastersLists)) {
                                    foreach ($mastersLists as $master) {
                                        $masterUserIdList[]  = array(
                                            'user_id' => $master->user_id,
                                            'user_name' => $master->name . '(' . $master->user_name . ')',

                                        );
                                    }
                                }
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'master') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {
                        $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                        if (!empty($supersLists)) {
                            foreach ($supersLists as $super) {

                                $masterUserIdList[]  = array(
                                    'user_id' => $super->user_id,
                                    'user_name' => $super->name . '(' . $super->user_name . ')',

                                );
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'supermaster') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {

                        $masterUserIdList[]  = array(
                            'user_id' => $hyper->user_id,
                            'user_name' => $hyper->name . '(' . $hyper->user_name . ')',

                        );
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            }
        } else if ($master_user_detail->user_type == 'Hyper Super Master') {
            if ($type == 'user') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {
                        $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                        if (!empty($supersLists)) {
                            foreach ($supersLists as $super) {
                                // $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                // if (!empty($mastersLists)) {
                                //     foreach ($mastersLists as $master) {
                                $masterUserIdList[]  = array(
                                    'user_id' => $super->user_id,
                                    'user_name' => $super->name . '(' . $super->user_name . ')',

                                );
                                //     }
                                // }
                            }
                        }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            } else if ($type == 'master') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {
                        // $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                        // if (!empty($supersLists)) {
                        //     foreach ($supersLists as $super) {

                        $masterUserIdList[]  = array(
                            'user_id' => $hyper->user_id,
                            'user_name' => $hyper->name . '(' . $hyper->user_name . ')',

                        );
                        //     }
                        // }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            }
        } else if ($master_user_detail->user_type == 'Super Master') {
            if ($type == 'user') {
                $masterUserIdList = array();
                $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                if (!empty($hypersLists)) {
                    foreach ($hypersLists as $hyper) {
                        //   $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                        //   if (!empty($supersLists)) {
                        //       foreach ($supersLists as $super) {
                        // $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                        // if (!empty($mastersLists)) {
                        //     foreach ($mastersLists as $master) {
                        $masterUserIdList[]  = array(
                            'user_id' => $hyper->user_id,
                            'user_name' => $hyper->name . '(' . $hyper->user_name . ')',

                        );
                        //     }
                        // }
                        //       }
                        //   }
                    }
                }

                $dataArray['masters'] = $masterUserIdList;
            }
        }
        // p($dataArray);

        $this->load->view('/user-list', $dataArray);
    }

    public function free_chip_in_out()
    {
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        $master_id = $this->input->post('master_id');
        $master_id = $master_id != '' ? $master_id : $_SESSION['my_userdata']['user_id'];
        $admin_chip = count_total_balance($master_id);
        $user_chip = count_total_balance($user_id);

        $dataArray['admin_chip'] = $admin_chip;
        $dataArray['user_chip'] = $user_chip;

        echo json_encode($dataArray);
    }


    public function chip_update_new($data_arr = null)
    {

        if (empty($data_arr)) {
            $user_id = $this->input->post('user_id');
            $type = $this->input->post('type');
            $ChipsValue = $this->input->post('ChipsValue');
            $chip_master_id = $this->input->post('chip_master_id');
        } else {
            $user_id = $data_arr['user_id'];
            $type = $data_arr['type'];
            $ChipsValue = $data_arr['ChipsValue'];
            $chip_master_id = $data_arr['chip_master_id'];
        }

        $user = $this->User_model->getUserById($user_id);
        $user_name = $user->user_name;
        $chip_master_id = $chip_master_id != '' ? $chip_master_id : $_SESSION['my_userdata']['user_id'];


        if ($ChipsValue < 0) {
            echo json_encode(array('errorMessage' => 'Invalid amount enter', 'success' => false));
            exit;
        }


        $admin_chip = count_total_balance_without_exposure($chip_master_id);
        $user_chip = count_total_balance_without_exposure($user_id);


        if ($type == 'D') {
            $admin_new_chip = $admin_chip - $ChipsValue;
            $user_new_chip = $user_chip + $ChipsValue;
        } else {
            $admin_new_chip = $admin_chip + $ChipsValue;
            $user_new_chip = $user_chip - $ChipsValue;
        }


        $userDetail = $this->User_model->getUserById($user_id);


        $masterDetail = $this->User_model->getUserById($chip_master_id);


        // if ($userDetail->is_balance_update == 'Yes') {
        //     echo json_encode(array('success' => false));
        //     exit;
        // }

        // if ($masterDetail->is_balance_update == 'Yes') {
        //     echo json_encode(array('success' => false));
        //     exit;
        // }


        if ($type == 'D') {

            if ($admin_chip <= 0) {
                echo json_encode(array('errorMessage' => 'Insufficient Balance in master', 'success' => false));
                exit;
            }

            if ($admin_new_chip <= 0) {
                echo json_encode(array('errorMessage' => 'Insufficient new Balance in master', 'success' => false));
                exit;
            }
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Deposit By ' . $_SESSION['my_userdata']['user_name'],
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' =>  $user_new_chip,
                'role' => 'Parent'
            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($user_id);

            if (empty($data_arr)) {
                if (!empty($userDetail)) {
                    $balance = $userDetail->balance + $ChipsValue;
                    $credit_limit = $userDetail->credit_limit + $ChipsValue;

                    $data = array(
                        'user_id' => $user_id,
                        'is_balance_update' =>  'Yes',
                        'is_credit_limit_update' => 'Yes',
                    );
                    $user_id = $this->User_model->addUser($data);
                }
            }

            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Deposit To ' . $user_name,
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' =>  $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($chip_master_id);

            if (!empty($userDetail)) {
                $balance = $userDetail->balance - $ChipsValue;
                $credit_limit = $userDetail->credit_limit - $ChipsValue;


                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        } else {

            if ($user_chip < 0) {
                echo json_encode(array('errorMessage' => 'Insufficient Balance in user', 'success' => false));
                exit;
            }

            if ($user_new_chip < 0) {
                echo json_encode(array('errorMessage' => 'Insufficient new Balance in user', 'success' => false));
                exit;
            }
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Withdrawl By ' . $_SESSION['my_userdata']['user_name'],
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' =>  $user_new_chip,
                'role' => 'Parent'
            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($user_id);

            if (!empty($userDetail)) {
                $balance = $userDetail->balance - $ChipsValue;
                $credit_limit = $userDetail->credit_limit - $ChipsValue;

                $data = array(
                    'user_id' => $user_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }


            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Withdrawl from ' . $user_name,
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' =>  $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);


            $userDetail = $this->User_model->getUserById($chip_master_id);

            if (!empty($userDetail)) {
                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        }

        if (empty($data_arr)) {
            echo json_encode(array('success' => true));
        }
    }

    public function chip_update()
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $remarks = $this->input->post('remarks');
        $user_id = $this->input->post('user_id');
        $user = $this->User_model->getUserById($user_id);

        $user_name = $user->user_name;

        $type = $this->input->post('type');
        $ChipsValue = $this->input->post('ChipsValue');
        $chip_master_id = $this->input->post('chip_master_id');
        $chip_master_id = $chip_master_id != '' ? $chip_master_id : $_SESSION['my_userdata']['user_id'];

        if ($ChipsValue < 0) {
            echo json_encode(array('success' => false));
            exit;
        }
        $admin_chip = count_total_balance_without_exposure($chip_master_id);
        $user_chip = count_total_balance_without_exposure($user_id);

        if ($type == 'D') {
            $admin_new_chip = $admin_chip - $ChipsValue;
            $user_new_chip = $user_chip + $ChipsValue;
        } else {
            $admin_new_chip = $admin_chip + $ChipsValue;
            $user_new_chip = $user_chip - $ChipsValue;
        }


        $userDetail = $this->User_model->getUserById($user_id);


        $masterDetail = $this->User_model->getUserById($chip_master_id);


        // if ($userDetail->is_balance_update == 'Yes') {
        //     echo json_encode(array('success' => false));
        //     exit;
        // }

        // if ($masterDetail->is_balance_update == 'Yes') {
        //     echo json_encode(array('success' => false));
        //     exit;
        // }


        if ($type == 'D') {

            if ($admin_chip < 0) {
                echo json_encode(array('success' => false));
                exit;
            }

            if ($admin_new_chip < 0) {
                echo json_encode(array('success' => false));
                exit;
            }
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Deposit By ' . $_SESSION['my_userdata']['user_name'] . ' / ' . $remarks,
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' =>  $user_new_chip,
                'role' => 'Parent'
            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($user_id);

            if (!empty($userDetail)) {
                $balance = $userDetail->balance + $ChipsValue;
                $credit_limit = $userDetail->credit_limit + $ChipsValue;

                $data = array(
                    'user_id' => $user_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }


            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Deposit To ' . $user_name . ' / ' . $remarks,
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' =>  $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($chip_master_id);

            if (!empty($userDetail)) {
                $balance = $userDetail->balance - $ChipsValue;
                $credit_limit = $userDetail->credit_limit - $ChipsValue;


                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        } else {

            if ($user_chip < 0) {
                echo json_encode(array('success' => false));
                exit;
            }

            if ($user_new_chip < 0) {
                echo json_encode(array('success' => false));
                exit;
            }
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Withdrawl By ' . $_SESSION['my_userdata']['user_name'] . ' / ' . $remarks,
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' =>  $user_new_chip,
                'role' => 'Parent'

            );
            $this->Ledger_model->addLedger($dataArray);

            $userDetail = $this->User_model->getUserById($user_id);

            if (!empty($userDetail)) {
                $balance = $userDetail->balance - $ChipsValue;
                $credit_limit = $userDetail->credit_limit - $ChipsValue;

                $data = array(
                    'user_id' => $user_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }


            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Withdrawl from ' . $user_name . ' / ' . $remarks,
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' =>  $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);


            $userDetail = $this->User_model->getUserById($chip_master_id);

            if (!empty($userDetail)) {
                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' =>  'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        }

        echo json_encode(array('success' => true));
    }

    public function viewinfo($user_id = null)
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('father_name', 'Father Name', 'required|trim');
        $this->form_validation->set_rules('contact_no', 'Contact No.', 'required|trim');
        $this->form_validation->set_rules('guardian_contact_no', 'Guardian Contact No.', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim');
        $this->form_validation->set_rules('experience', 'Working Experience', 'required|trim');
        // $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');

        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'Add Employee';
            $dataArray['form_action'] = current_url();
            if (!empty($user_id)) {
                $viewUserRecords = $this->User_model->getUserById($user_id);

                $viewInfoRecords = $this->View_info_model->getViewInfoByUserId($user_id);


                $viewInfoMasterRecords = $this->View_info_model->getViewInfoByUserId($viewUserRecords->master_id);


                if (!empty($viewInfoRecords)) {
                    $dataArray['form_caption'] = 'Edit User Info';
                    $dataArray['viewInfoRecords'] = $viewInfoRecords;
                    $dataArray['viewInfoMasterRecords'] = $viewInfoMasterRecords;

                    $dataArray['viewUserRecords'] = $viewUserRecords;
                }
            } else {
                $postdata = $this->input->post();
                if (!empty($postdata)) {
                    $dataArray = $postdata;
                }
            }

            $dataArray['local_js'] = array(
                'jquery.validate',
                // 'moment',
                // 'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );

            $dataArray['user_id'] = $user_id;


            $this->load->view('/view-info-form', $dataArray);
        } else {

            $dataValues = array(
                'employee_name' => $this->input->post('employee_name'),
                'father_name' => $this->input->post('father_name'),
                'contact_no' => $this->input->post('contact_no'),
                'whatsapp_no' => $this->input->post('whatsapp_no'),
                'guardian_contact_no' => $this->input->post('guardian_contact_no'),
                'email' => $this->input->post('email'),
                'experience' => $this->input->post('experience'),
                'last_company' => $this->input->post('last_company'),
                'monthly_salary' => $this->input->post('monthly_salary'),
                'address' => $this->input->post('address'),
            );

            if (!empty($this->input->post('employee_id'))) {
                $dataValues['employee_id'] = $this->input->post('employee_id');
            }

            $employee_picture_config = getCustomConfigItem('employee_image');

            if (!empty($_FILES['employee_image']['name'])) {
                if ($this->commonlibrary->is_file_uploaded('employee_image')) {
                    $new_client_image = $this->upload->upload_file("employee_image", $employee_picture_config['upload_path'], $employee_picture_config);
                    $dataValues['employee_image'] = $new_client_image;
                }
            }

            $employee_id = $this->Employee_model->saveEmployee($dataValues);


            if (!empty($employee_id) && !empty($this->input->post('username')) && !empty($this->input->post('password'))) {
                $userDataValues = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'employee_id' => $employee_id,
                    'type' => 'employee',
                    'status' => 'active',
                );


                if (!empty($new_client_image) && isset($new_client_image)) {
                    $userDataValues['image'] = $new_client_image;
                }

                $userDetails = $this->Admin_model->getadminbyusername($this->input->post('username'));

                if (isset($userDetails) && !empty($userDetails)) {
                    $userDataValues['userid'] = $userDetails->userid;
                }
                $user_id = $this->Admin_model->saveadmin($userDataValues);
            }


            if (!empty($dataValues['employee_id'])) {
                $this->session->set_flashdata('message', 'Employee Updated successfully.');
            } else {
                $this->session->set_flashdata('message', 'Employee saved successfully.');
            }
            redirect('admin/employees');
        }
    }

    // public function updateviewinfo()
    // {


    //     $dataValues = array(
    //         'info_id' => $this->input->post('info_id'),
    //         'sport_id' => $this->input->post('sport_id'),
    //         'min_stake' => $this->input->post('min_stake'),
    //         'max_stake' => $this->input->post('max_stake'),
    //         'max_profit' => $this->input->post('max_profit'),
    //         'max_loss' => $this->input->post('max_loss'),
    //         'bet_delay' => $this->input->post('bet_delay'),
    //         'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //         'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //         'min_odds' => $this->input->post('min_odds'),
    //         'max_odds' => $this->input->post('max_odds'),
    //         'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //         'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //         'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //         'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //         'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',



    //     );
    //     $info_id = $this->View_info_model->saveUserInfo($dataValues);


    //     $user_id = $this->input->post('user_id');


    //     $userDetail = $this->User_model->getUserById($user_id);
    //     $user_type = $userDetail->user_type;
    //     $user_id = $userDetail->user_id;



    //     if ($user_type == 'Admin') {
    //         $hyperUsers =  $this->User_model->getInnerUserById($user_id);


    //         if (!empty($hyperUsers)) {
    //             foreach ($hyperUsers as $hyperUser) {
    //                 $user_id = $hyperUser->user_id;

    //                 $dataValues = array(
    //                     'setting_id' => $this->input->post('setting_id'),
    //                     'user_id' => $user_id,
    //                     'sport_id' => $this->input->post('sport_id'),
    //                     'min_stake' => $this->input->post('min_stake'),
    //                     'max_stake' => $this->input->post('max_stake'),
    //                     'max_profit' => $this->input->post('max_profit'),
    //                     'max_loss' => $this->input->post('max_loss'),
    //                     'bet_delay' => $this->input->post('bet_delay'),
    //                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                     'min_odds' => $this->input->post('min_odds'),
    //                     'max_odds' => $this->input->post('max_odds'),
    //                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                 );
    //                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



    //                 $superUsers =  $this->User_model->getInnerUserById($user_id);


    //                 if (!empty($superUsers)) {
    //                     foreach ($superUsers as $superUser) {

    //                         $user_id = $superUser->user_id;

    //                         $dataValues = array(
    //                             'setting_id' => $this->input->post('setting_id'),
    //                             'user_id' => $user_id,
    //                             'sport_id' => $this->input->post('sport_id'),
    //                             'min_stake' => $this->input->post('min_stake'),
    //                             'max_stake' => $this->input->post('max_stake'),
    //                             'max_profit' => $this->input->post('max_profit'),
    //                             'max_loss' => $this->input->post('max_loss'),
    //                             'bet_delay' => $this->input->post('bet_delay'),
    //                             'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                             'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                             'min_odds' => $this->input->post('min_odds'),
    //                             'max_odds' => $this->input->post('max_odds'),
    //                             'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                             'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                             'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',

    //                         );
    //                         $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

    //                         $masterUsers =  $this->User_model->getInnerUserById($user_id);
    //                         if (!empty($masterUsers)) {
    //                             foreach ($masterUsers as $masterUser) {
    //                                 $user_id = $masterUser->user_id;

    //                                 $dataValues = array(
    //                                     'setting_id' => $this->input->post('setting_id'),
    //                                     'user_id' => $user_id,
    //                                     'sport_id' => $this->input->post('sport_id'),
    //                                     'min_stake' => $this->input->post('min_stake'),
    //                                     'max_stake' => $this->input->post('max_stake'),
    //                                     'max_profit' => $this->input->post('max_profit'),
    //                                     'max_loss' => $this->input->post('max_loss'),
    //                                     'bet_delay' => $this->input->post('bet_delay'),
    //                                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                                     'min_odds' => $this->input->post('min_odds'),
    //                                     'max_odds' => $this->input->post('max_odds'),
    //                                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                                 );
    //                                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



    //                                 $users =  $this->User_model->getInnerUserById($user_id);
    //                                 if (!empty($users)) {
    //                                     foreach ($users as $user) {
    //                                         $user_id = $user->user_id;


    //                                         $dataValues = array(
    //                                             'setting_id' => $this->input->post('setting_id'),
    //                                             'user_id' => $user_id,
    //                                             'sport_id' => $this->input->post('sport_id'),
    //                                             'min_stake' => $this->input->post('min_stake'),
    //                                             'max_stake' => $this->input->post('max_stake'),
    //                                             'max_profit' => $this->input->post('max_profit'),
    //                                             'max_loss' => $this->input->post('max_loss'),
    //                                             'bet_delay' => $this->input->post('bet_delay'),
    //                                             'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                                             'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                                             'min_odds' => $this->input->post('min_odds'),
    //                                             'max_odds' => $this->input->post('max_odds'),
    //                                             'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                                             'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                                             'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                                             'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                                             'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                                         );
    //                                         $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else if ($user_type == 'Hyper Super Master') {
    //         $superUsers =  $this->User_model->getInnerUserById($user_id);


    //         if (!empty($superUsers)) {
    //             foreach ($superUsers as $superUser) {
    //                 $user_id = $superUser->user_id;

    //                 $dataValues = array(
    //                     'setting_id' => $this->input->post('setting_id'),
    //                     'user_id' => $user_id,
    //                     'sport_id' => $this->input->post('sport_id'),
    //                     'min_stake' => $this->input->post('min_stake'),
    //                     'max_stake' => $this->input->post('max_stake'),
    //                     'max_profit' => $this->input->post('max_profit'),
    //                     'max_loss' => $this->input->post('max_loss'),
    //                     'bet_delay' => $this->input->post('bet_delay'),
    //                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                     'min_odds' => $this->input->post('min_odds'),
    //                     'max_odds' => $this->input->post('max_odds'),
    //                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                 );
    //                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


    //                 $masterUsers =  $this->User_model->getInnerUserById($user_id);
    //                 if (!empty($masterUsers)) {
    //                     foreach ($masterUsers as $masterUser) {
    //                         $user_id = $masterUser->user_id;

    //                         $dataValues = array(
    //                             'setting_id' => $this->input->post('setting_id'),
    //                             'user_id' => $user_id,
    //                             'sport_id' => $this->input->post('sport_id'),
    //                             'min_stake' => $this->input->post('min_stake'),
    //                             'max_stake' => $this->input->post('max_stake'),
    //                             'max_profit' => $this->input->post('max_profit'),
    //                             'max_loss' => $this->input->post('max_loss'),
    //                             'bet_delay' => $this->input->post('bet_delay'),
    //                             'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                             'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                             'min_odds' => $this->input->post('min_odds'),
    //                             'max_odds' => $this->input->post('max_odds'),
    //                             'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                             'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                             'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                         );
    //                         $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


    //                         $users =  $this->User_model->getInnerUserById($user_id);
    //                         if (!empty($users)) {
    //                             foreach ($users as $user) {
    //                                 $user_id = $user->user_id;


    //                                 $dataValues = array(
    //                                     'setting_id' => $this->input->post('setting_id'),
    //                                     'user_id' => $user_id,
    //                                     'sport_id' => $this->input->post('sport_id'),
    //                                     'min_stake' => $this->input->post('min_stake'),
    //                                     'max_stake' => $this->input->post('max_stake'),
    //                                     'max_profit' => $this->input->post('max_profit'),
    //                                     'max_loss' => $this->input->post('max_loss'),
    //                                     'bet_delay' => $this->input->post('bet_delay'),
    //                                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                                     'min_odds' => $this->input->post('min_odds'),
    //                                     'max_odds' => $this->input->post('max_odds'),
    //                                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                                 );
    //                                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else if ($user_type == 'Super Master') {
    //         $superUsers =  $this->User_model->getInnerUserById($user_id);


    //         $masterUsers =  $this->User_model->getInnerUserById($user_id);
    //         if (!empty($masterUsers)) {
    //             foreach ($masterUsers as $masterUser) {
    //                 $user_id = $masterUser->user_id;

    //                 $dataValues = array(
    //                     'setting_id' => $this->input->post('setting_id'),
    //                     'user_id' => $user_id,
    //                     'sport_id' => $this->input->post('sport_id'),
    //                     'min_stake' => $this->input->post('min_stake'),
    //                     'max_stake' => $this->input->post('max_stake'),
    //                     'max_profit' => $this->input->post('max_profit'),
    //                     'max_loss' => $this->input->post('max_loss'),
    //                     'bet_delay' => $this->input->post('bet_delay'),
    //                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                     'min_odds' => $this->input->post('min_odds'),
    //                     'max_odds' => $this->input->post('max_odds'),
    //                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                 );
    //                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

    //                 $users =  $this->User_model->getInnerUserById($user_id);
    //                 if (!empty($users)) {
    //                     foreach ($users as $user) {
    //                         $user_id = $user->user_id;

    //                         $dataValues = array(
    //                             'setting_id' => $this->input->post('setting_id'),
    //                             'user_id' => $user_id,
    //                             'sport_id' => $this->input->post('sport_id'),
    //                             'min_stake' => $this->input->post('min_stake'),
    //                             'max_stake' => $this->input->post('max_stake'),
    //                             'max_profit' => $this->input->post('max_profit'),
    //                             'max_loss' => $this->input->post('max_loss'),
    //                             'bet_delay' => $this->input->post('bet_delay'),
    //                             'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                             'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                             'min_odds' => $this->input->post('min_odds'),
    //                             'max_odds' => $this->input->post('max_odds'),
    //                             'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                             'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                             'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                             'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                         );
    //                         $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
    //                     }
    //                 }
    //             }
    //         }
    //     } else if ($user_type == 'Master') {

    //         $users =  $this->User_model->getInnerUserById($user_id);
    //         if (!empty($users)) {
    //             foreach ($users as $user) {
    //                 $user_id = $user->user_id;

    //                 $dataValues = array(
    //                     'setting_id' => $this->input->post('setting_id'),
    //                     'user_id' => $user_id,
    //                     'sport_id' => $this->input->post('sport_id'),
    //                     'min_stake' => $this->input->post('min_stake'),
    //                     'max_stake' => $this->input->post('max_stake'),
    //                     'max_profit' => $this->input->post('max_profit'),
    //                     'max_loss' => $this->input->post('max_loss'),
    //                     'bet_delay' => $this->input->post('bet_delay'),
    //                     'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
    //                     'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
    //                     'min_odds' => $this->input->post('min_odds'),
    //                     'max_odds' => $this->input->post('max_odds'),
    //                     'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
    //                     'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
    //                     'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
    //                     'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
    //                 );


    //                 $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
    //             }
    //         }
    //     }




    //     $data = array(
    //         'success' => true,
    //         'message' => 'Setting update successfuly'
    //     );
    //     echo json_encode($data);
    // }



    public function updateviewinfo()
    {
        $sport_name = '';
        $sport_id = $this->input->post('sport_id');



        if ($sport_id == 2) {
            $sport_name = 'Tennis';
        } else   if ($sport_id == 1) {
            $sport_name = 'Soccer';
        } else if ($sport_id == 999) {
            $sport_name = 'Fancy';
        } else if ($sport_id == 1000) {
            $sport_name = 'Casino';
        } else if ($sport_id == 2000) {
            $sport_name = 'Bookmaker';
        } else if ($sport_id == 7) {
            $sport_name = 'Horse Racing';
        } else if ($sport_id == 4) {
            $sport_name = 'Cricket';
        }

        $dataValues = array(
            'info_id' => $this->input->post('info_id'),
            'sport_id' => $this->input->post('sport_id'),
            'min_stake' => $this->input->post('min_stake'),
            'sport_name' => $sport_name,
            'max_stake' => $this->input->post('max_stake'),
            'max_profit' => $this->input->post('max_profit'),
            'max_loss' => $this->input->post('max_loss'),
            'bet_delay' => $this->input->post('bet_delay'),
            'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
            'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
            'min_odds' => $this->input->post('min_odds'),
            'max_odds' => $this->input->post('max_odds'),
            'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
            'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
            'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
            'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
            'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',



        );
        $info_id = $this->View_info_model->saveUserInfo($dataValues);


        $user_id = $this->input->post('user_id');


        $userDetail = $this->User_model->getUserById($user_id);
        $user_type = $userDetail->user_type;
        $user_id = $userDetail->user_id;


        $updateArr = array();
        $insertArr = array();

        if ($user_type == 'Admin') {
            $hyperUsers =  $this->User_model->getInnerUserById($user_id);


            if (!empty($hyperUsers)) {
                foreach ($hyperUsers as $hyperUser) {
                    $user_id = $hyperUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'sport_name' => $sport_name,


                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



                    $superUsers =  $this->User_model->getInnerUserById($user_id);


                    if (!empty($superUsers)) {
                        foreach ($superUsers as $superUser) {

                            $user_id = $superUser->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'sport_name' => $sport_name,


                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',

                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $user_id = $masterUser->user_id;

                                    $dataValues = array(
                                        'setting_id' => $this->input->post('setting_id'),
                                        'user_id' => $user_id,
                                        'sport_id' => $this->input->post('sport_id'),
                                        'sport_name' => $sport_name,


                                        'min_stake' => $this->input->post('min_stake'),
                                        'max_stake' => $this->input->post('max_stake'),
                                        'max_profit' => $this->input->post('max_profit'),
                                        'max_loss' => $this->input->post('max_loss'),
                                        'bet_delay' => $this->input->post('bet_delay'),
                                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                        'min_odds' => $this->input->post('min_odds'),
                                        'max_odds' => $this->input->post('max_odds'),
                                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                    );
                                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



                                    $users =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $user_id = $user->user_id;


                                            $dataValues = array(
                                                'setting_id' => $this->input->post('setting_id'),
                                                'user_id' => $user_id,
                                                'sport_id' => $this->input->post('sport_id'),
                                                'sport_name' => $sport_name,


                                                'min_stake' => $this->input->post('min_stake'),
                                                'max_stake' => $this->input->post('max_stake'),
                                                'max_profit' => $this->input->post('max_profit'),
                                                'max_loss' => $this->input->post('max_loss'),
                                                'bet_delay' => $this->input->post('bet_delay'),
                                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                                'min_odds' => $this->input->post('min_odds'),
                                                'max_odds' => $this->input->post('max_odds'),
                                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                            );
                                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $superUsers =  $this->User_model->getInnerUserById($user_id);


            if (!empty($superUsers)) {
                foreach ($superUsers as $superUser) {
                    $user_id = $superUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'sport_name' => $sport_name,


                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


                    $masterUsers =  $this->User_model->getInnerUserById($user_id);
                    if (!empty($masterUsers)) {
                        foreach ($masterUsers as $masterUser) {
                            $user_id = $masterUser->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'sport_name' => $sport_name,


                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


                            $users =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $user_id = $user->user_id;


                                    $dataValues = array(
                                        'setting_id' => $this->input->post('setting_id'),
                                        'user_id' => $user_id,
                                        'sport_id' => $this->input->post('sport_id'),
                                        'sport_name' => $sport_name,


                                        'min_stake' => $this->input->post('min_stake'),
                                        'max_stake' => $this->input->post('max_stake'),
                                        'max_profit' => $this->input->post('max_profit'),
                                        'max_loss' => $this->input->post('max_loss'),
                                        'bet_delay' => $this->input->post('bet_delay'),
                                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                        'min_odds' => $this->input->post('min_odds'),
                                        'max_odds' => $this->input->post('max_odds'),
                                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                    );
                                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $superUsers =  $this->User_model->getInnerUserById($user_id);


            $masterUsers =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masterUsers)) {
                foreach ($masterUsers as $masterUser) {
                    $user_id = $masterUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'sport_name' => $sport_name,


                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

                    $users =  $this->User_model->getInnerUserById($user_id);
                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $user_id = $user->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'sport_name' => $sport_name,


                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                        }
                    }
                }
            }
        } else if ($user_type == 'Master') {

            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $user_id = $user->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'sport_name' => $sport_name,


                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );


                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                }
            }
        }




        $data = array(
            'success' => true,
            'message' => 'Setting update successfuly'
        );
        echo json_encode($data);
    }


    public function downline($master_id, $type)
    {

        $user_types = get_user_type();
        if (get_user_type() == 'User') {
            redirect('/');
        }

        $user_type = '';
        $next_user = '';



        if ($type == 'hypersupermaster') {
            $user_type = 'Super Master';
            $next_user = 'Master';
            if ($user_types != 'Super Admin' && $user_types != 'Admin') {
                redirect('/');
            }
        } else if ($type == 'supermaster') {
            $user_type = 'Master';
            $next_user = 'User';
            if ($user_types != 'Super Admin' && $user_types != 'Admin' && $user_types != 'Hyper Super Master') {
                redirect('/');
            }
        } else if ($type == 'master') {
            $user_type = 'User';
            $next_user = 'User';

            if ($user_types != 'Super Admin' && $user_types != 'Admin' && $user_types != 'Hyper Super Master' && $user_types != 'Super Master') {
                redirect('/');
            }
        } else if ($type == 'admin') {
            $user_type = 'Hyper Super Master';
            $next_user = 'Super Master';
            if ($user_types != 'Super Admin') {
                redirect('/');
            }
        }

        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');



        $dataArray = array(
            'master_id' => $master_id,
            // 'user_type' => $user_type
        );

        $users = $this->User_model->get_all_users($dataArray);


        $table_config = array(
            'source' => site_url('admin/user/listUsersData/' . $master_id . '/' . $user_type),
            'table_id' => 'masters_association_list',
            'datatable_class' => $this->config->config["datatable_class"]
        );

        if (get_user_type() == 'Super Admin' || get_user_type() == 'Admin') {
            if ($user_type == 'User') {
                $dataArray['table'] = $this->datatable->make_table($this->_users_listing_headers_1, $table_config);
            } else {
                $dataArray['table'] = $this->datatable->make_table($this->_masters_listing_headers_1, $table_config);
            }
        } else {
            if ($user_type == 'User') {
                $dataArray['table'] = $this->datatable->make_table($this->_users_listing_headers, $table_config);
            } else {
                $dataArray['table'] = $this->datatable->make_table($this->_masters_listing_headers, $table_config);
            }
        }

        $dataArray['message'] = $message;



        $dataArray['local_css'] = array(
            'jquery.dataTables.bootstrap',
            'jquery-ui'
        );

        $dataArray['local_js'] = array(
            'jquery.dataTables',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'moment',
            'jquery.validate',
            'jquery-ui'
        );

        $dataArray['users'] = $users;

        $master_user_detail = $this->User_model->getUserById($master_id);

        $dataArray['master_user_detail'] = $master_user_detail;
        $dataArray['user_type'] = $user_type;
        $dataArray['type'] = $type;
        $dataArray['next_user'] = $next_user;
        $dataArray['master_id']  = $master_id;

        $this->load->view('/user-list', $dataArray);
    }

    public function set_action()
    {
        $useraction = $this->input->post('useraction');
        $users = $this->input->post('users');

        $dataArray = array();
        if ($useraction === 'lock_betting') {
            $dataArray['is_betting_open'] = 'No';
        }

        if ($useraction === 'open_betting') {
            $dataArray['is_betting_open'] = 'Yes';
        }

        if ($useraction === 'lock_user') {
            $dataArray['is_locked'] = 'Yes';
        }

        if ($useraction === 'unlock_user') {
            $dataArray['is_locked'] = 'No';
        }

        if ($useraction === 'close_user') {
            $dataArray['is_closed'] = 'Yes';
        }

        if ($useraction === 'open_user') {
            $dataArray['is_closed'] = 'No';
        }


        if (!empty($users)) {
            foreach ($users as $user) {
                if ($useraction === 'delete_user') {
                    $user_id = $user;


                    $this->User_model->deleteUser($user_id);
                    $userDetail = $this->User_model->getUserById($user_id);
                    $user_type = $userDetail->user_type;


                    if ($useraction === 'lock_user' || $useraction === 'close_user' || $useraction === 'lock_betting') {
                        if ($user_type == 'Admin') {
                            $hyperUsers =  $this->User_model->getInnerUserById($user_id);


                            if (!empty($hyperUsers)) {
                                foreach ($hyperUsers as $hyperUser) {
                                    $user_id = $hyperUser->user_id;

                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->deleteUser($user_id);


                                    $superUsers =  $this->User_model->getInnerUserById($user_id);


                                    if (!empty($superUsers)) {
                                        foreach ($superUsers as $superUser) {
                                            $user_id = $superUser->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->deleteUser($user_id);


                                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                                            if (!empty($masterUsers)) {
                                                foreach ($masterUsers as $masterUser) {
                                                    $user_id = $masterUser->user_id;
                                                    $dataArray['user_id'] = $user_id;
                                                    $this->User_model->deleteUser($user_id);

                                                    $users =  $this->User_model->getInnerUserById($user_id);
                                                    if (!empty($users)) {
                                                        foreach ($users as $user) {
                                                            $user_id = $user->user_id;
                                                            $dataArray['user_id'] = $user_id;
                                                            $this->User_model->deleteUser($user_id);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Hyper Super Master') {
                            $superUsers =  $this->User_model->getInnerUserById($user_id);


                            if (!empty($superUsers)) {
                                foreach ($superUsers as $superUser) {
                                    $user_id = $superUser->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->deleteUser($user_id);


                                    $masterUsers =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($masterUsers)) {
                                        foreach ($masterUsers as $masterUser) {
                                            $user_id = $masterUser->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->deleteUser($user_id);

                                            $users =  $this->User_model->getInnerUserById($user_id);
                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $user_id = $user->user_id;
                                                    $dataArray['user_id'] = $user_id;
                                                    $this->User_model->deleteUser($user_id);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Super Master') {
                            $superUsers =  $this->User_model->getInnerUserById($user_id);


                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $user_id = $masterUser->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->deleteUser($user_id);

                                    $users =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $user_id = $user->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->deleteUser($user_id);
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Master') {

                            $users =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $user_id = $user->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->deleteUser($user_id);
                                }
                            }
                        }
                    }
                } else {
                    $dataArray['user_id'] = $user;
                    $this->User_model->addUser($dataArray);
                    $user_id = $user;
                    $userDetail = $this->User_model->getUserById($user_id);
                    $user_type = $userDetail->user_type;


                    if ($useraction === 'lock_user' || $useraction === 'close_user' || $useraction === 'lock_betting') {
                        if ($user_type == 'Admin') {
                            $hyperUsers =  $this->User_model->getInnerUserById($user_id);


                            if (!empty($hyperUsers)) {
                                foreach ($hyperUsers as $hyperUser) {
                                    $user_id = $hyperUser->user_id;

                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->addUser($dataArray);

                                    $superUsers =  $this->User_model->getInnerUserById($user_id);


                                    if (!empty($superUsers)) {
                                        foreach ($superUsers as $superUser) {
                                            $user_id = $superUser->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->addUser($dataArray);

                                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                                            if (!empty($masterUsers)) {
                                                foreach ($masterUsers as $masterUser) {
                                                    $user_id = $masterUser->user_id;
                                                    $dataArray['user_id'] = $user_id;
                                                    $this->User_model->addUser($dataArray);
                                                    $users =  $this->User_model->getInnerUserById($user_id);
                                                    if (!empty($users)) {
                                                        foreach ($users as $user) {
                                                            $user_id = $user->user_id;
                                                            $dataArray['user_id'] = $user_id;
                                                            $this->User_model->addUser($dataArray);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Hyper Super Master') {
                            $superUsers =  $this->User_model->getInnerUserById($user_id);


                            if (!empty($superUsers)) {
                                foreach ($superUsers as $superUser) {
                                    $user_id = $superUser->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->addUser($dataArray);

                                    $masterUsers =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($masterUsers)) {
                                        foreach ($masterUsers as $masterUser) {
                                            $user_id = $masterUser->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->addUser($dataArray);
                                            $users =  $this->User_model->getInnerUserById($user_id);
                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $user_id = $user->user_id;
                                                    $dataArray['user_id'] = $user_id;
                                                    $this->User_model->addUser($dataArray);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Super Master') {
                            $superUsers =  $this->User_model->getInnerUserById($user_id);


                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $user_id = $masterUser->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->addUser($dataArray);
                                    $users =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $user_id = $user->user_id;
                                            $dataArray['user_id'] = $user_id;
                                            $this->User_model->addUser($dataArray);
                                        }
                                    }
                                }
                            }
                        } else if ($user_type == 'Master') {

                            $users =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $user_id = $user->user_id;
                                    $dataArray['user_id'] = $user_id;
                                    $this->User_model->addUser($dataArray);
                                }
                            }
                        }
                    }
                }
            }
        }

        $data = array(
            'success' => true,
            'message' => 'User action applied successfully'
        );
        echo json_encode($data);
    }


    public function closedUsersList($type)
    {

        $user_types = get_user_type();
        if (get_user_type() == 'User') {
            redirect('/');
        }

        $user_type = '';
        $next_user = '';


        if ($type == 'hypersupermaster') {
            $user_type = 'Hyper Super Master';
            $next_user = 'Super Master';

            if ($user_types != 'Super Admin' && $user_types != 'Admin') {
                redirect('/');
            }
        } else if ($type == 'supermaster') {
            $user_type = 'Super Master';
            $next_user = 'Master';
            if ($user_types != 'Super Admin' && $user_types != 'Admin' && $user_types != 'Hyper Super Master') {
                redirect('/');
            }
        } else if ($type == 'master') {
            $user_type = 'Master';
            $next_user = 'User';
            if ($user_types != 'Super Admin' && $user_types != 'Admin' && $user_types != 'Hyper Super Master' && $user_types != 'Super Master') {
                redirect('/');
            }
        } else if ($type == 'user') {

            $user_type = 'User';

            if ($user_types != 'Super Admin' && $user_types != 'Admin' && $user_types != 'Hyper Super Master' && $user_types != 'Super Master' && $user_types != 'Master') {
                redirect('/');
            }
        } else if ($type == 'admin') {
            $user_type = 'Admin';
            $next_user = 'Hyper Super Master';
            if ($user_types != 'Super Admin') {
                redirect('/');
            }
        }



        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');

        $table_config = array(
            'source' => site_url('admin/User/listUserdata'),
            'datatable_class' => $this->config->config["datatable_class"],
        );

        $dataArray = array(
            'table' => $this->datatable->make_table($this->_user_listing_headers, $table_config),
            'message' => $message
        );







        $master_id = $_SESSION['my_userdata']['user_id'];

        $dataArray = array(
            'master_id' => $master_id,
            'user_type' => $user_type
        );

        $users = array();
        // if ($user_type == 'Admin') {
        //     $users = $this->User_model->get_all_closed_users();
        // } else {
        //     $users = $this->User_model->get_closed_users($dataArray);
        // }

        $master_user_detail = $this->User_model->getUserById($master_id);

        $dataArray['users'] = $users;
        $dataArray['master_user_detail'] = $master_user_detail;

        $dataArray['type'] = $type;
        $dataArray['next_user'] = $next_user;

        $table_config = array(
            'source' => site_url('admin/user/listClosedUsersData/' . $master_id . '/' . $user_type),
            'table_id' => 'masters_association_list',
            'datatable_class' => $this->config->config["datatable_class"]
        );

        if ($user_type == 'User') {
            $dataArray['table'] = $this->datatable->make_table($this->_users_closed_user_listing_headers, $table_config);
        } else {
            $dataArray['table'] = $this->datatable->make_table($this->_masters_closed_user_listing_headers, $table_config);
        }

        $dataArray['message'] = $message;



        $dataArray['local_css'] = array(
            'jquery.dataTables.bootstrap',
            'jquery-ui'
        );

        $dataArray['local_js'] = array(
            'jquery.dataTables',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'moment',
            'jquery.validate',
            'jquery-ui'
        );

        $this->load->view('/closed-user-list', $dataArray);
    }


    public function userViewInfoUpdate()
    {
        $users = $this->User_model->get_all_registered_users();


        p($users, 0);
        if (!empty($users)) {
            foreach ($users as $user) {
                $settings = $this->User_info_model->get_general_setting();

                if (!empty($settings)) {
                    foreach ($settings as $setting) {

                        $dataArray = array(
                            'setting_id' => $setting['setting_id'],
                            'user_id' => $user['user_id'],
                            'sport_id' => $setting['sport_id'],
                            'sport_name' => $setting['sport_name'],
                            'min_stake' => $setting['min_stake'],
                            'max_stake' => $setting['max_stake'],
                            'max_profit' => $setting['max_profit'],
                            'max_loss' => $setting['max_loss'],
                            'bet_delay' => $setting['bet_delay'],
                            'pre_inplay_profit' => $setting['pre_inplay_profit'],
                            'pre_inplay_stake' => $setting['pre_inplay_stake'],
                            'min_odds' => $setting['min_odds'],
                            'max_odds' => $setting['max_odds'],
                            'unmatch_bet' => $setting['unmatch_bet'],
                            'lock_bet' => $setting['lock_bet'],
                        );

                        $this->User_info_model->addRegisteredUserInfo($dataArray);
                    }
                }
            }
        }
        /************************User Info Insert*******************/


        /************************User Info Insert*******************/




        $array = array(
            'success' => true,
            'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
        );

        echo json_encode($array);
    }

    public function userDetail()
    {
        $user_type = '';
        $next_user = '';



        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');

        $table_config = array(
            'source' => site_url('admin/User/listUserdata'),
            'datatable_class' => $this->config->config["datatable_class"],
        );

        $dataArray = array(
            'table' => $this->datatable->make_table($this->_user_listing_headers, $table_config),
            'message' => $message
        );



        $dataArray['local_css'] = array(
            'dataTables.bootstrap4',
            'responsive.bootstrap4'
        );

        $dataArray['local_js'] = array(
            'dataTables.min',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'dataTables.bootstrap4',
            'dataTables.responsive',
            'responsive.bootstrap4'
        );

        $master_id = $_SESSION['my_userdata']['user_id'];

        $dataArray = array(
            'master_id' => $master_id,
            'user_type' => $user_type
        );


        $users = $this->User_model->get_all_users($dataArray);
        $master_user_detail = $this->User_model->getUserById($master_id);

        $dataArray['users'] = $users;
        $dataArray['master_user_detail'] = $master_user_detail;




        $this->load->view('/user-details', $dataArray);
    }


    public function search_user()
    {
        $user_id = $this->input->post('userId');

        $user_detail = $this->User_model->searchUserByUserName($user_id);

        $users_arr = array();
        if (!empty($user_detail)) {

            if ($user_detail['user_type'] == 'User') {
                $users_arr[] = array(
                    'sort_priority' => 6,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );

                $user_detail = (array) $this->User_model->getUserById($user_detail['master_id']);

                if (!empty($user_detail)) {
                    $users_arr[] = array(
                        'sort_priority' => 5,
                        'type' => $user_detail['user_type'],
                        'user_name' => $user_detail['user_name'],
                    );

                    $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);

                    if (!empty($user_detail)) {
                        $users_arr[] = array(
                            'sort_priority' => 4,
                            'type' => $user_detail['user_type'],
                            'user_name' => $user_detail['user_name'],
                        );

                        $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);
                        if (!empty($user_detail)) {
                            $users_arr[] = array(
                                'sort_priority' => 3,
                                'type' => $user_detail['user_type'],
                                'user_name' => $user_detail['user_name'],
                            );

                            $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);
                            if (!empty($user_detail)) {
                                $users_arr[] = array(
                                    'sort_priority' => 2,
                                    'type' => $user_detail['user_type'],
                                    'user_name' => $user_detail['user_name'],
                                );

                                $user_detail =  (array)  $this->User_model->getUserById($user_detail['master_id']);
                                if (!empty($user_detail)) {
                                    $users_arr[] = array(
                                        'sort_priority' => 1,
                                        'type' => $user_detail['user_type'],
                                        'user_name' => $user_detail['user_name'],
                                    );
                                }
                            }
                        }
                    }
                }
            } else if ($user_detail['user_type'] == 'Master') {
                $users_arr[] = array(
                    'sort_priority' => 5,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );

                $user_detail = (array) $this->User_model->getUserById($user_detail['master_id']);

                if (!empty($user_detail)) {
                    $users_arr[] = array(
                        'sort_priority' => 4,
                        'type' => $user_detail['user_type'],
                        'user_name' => $user_detail['user_name'],
                    );

                    $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);

                    if (!empty($user_detail)) {
                        $users_arr[] = array(
                            'sort_priority' => 3,
                            'type' => $user_detail['user_type'],
                            'user_name' => $user_detail['user_name'],
                        );

                        $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);
                        if (!empty($user_detail)) {
                            $users_arr[] = array(
                                'sort_priority' => 2,
                                'type' => $user_detail['user_type'],
                                'user_name' => $user_detail['user_name'],
                            );

                            $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);
                            if (!empty($user_detail)) {
                                $users_arr[] = array(
                                    'sort_priority' => 1,
                                    'type' => $user_detail['user_type'],
                                    'user_name' => $user_detail['user_name'],
                                );
                            }
                        }
                    }
                }
            } else if ($user_detail['user_type'] == 'Super Master') {
                $users_arr[] = array(
                    'sort_priority' => 4,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );

                $user_detail = (array) $this->User_model->getUserById($user_detail['master_id']);

                if (!empty($user_detail)) {
                    $users_arr[] = array(
                        'sort_priority' => 3,
                        'type' => $user_detail['user_type'],
                        'user_name' => $user_detail['user_name'],
                    );

                    $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);

                    if (!empty($user_detail)) {
                        $users_arr[] = array(
                            'sort_priority' => 2,
                            'type' => $user_detail['user_type'],
                            'user_name' => $user_detail['user_name'],
                        );

                        $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);
                        if (!empty($user_detail)) {
                            $users_arr[] = array(
                                'sort_priority' => 1,
                                'type' => $user_detail['user_type'],
                                'user_name' => $user_detail['user_name'],
                            );
                        }
                    }
                }
            } else if ($user_detail['user_type'] == 'Hyper Super Master') {
                $users_arr[] = array(
                    'sort_priority' => 3,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );

                $user_detail = (array) $this->User_model->getUserById($user_detail['master_id']);

                if (!empty($user_detail)) {
                    $users_arr[] = array(
                        'sort_priority' => 2,
                        'type' => $user_detail['user_type'],
                        'user_name' => $user_detail['user_name'],
                    );

                    $user_detail = (array)  $this->User_model->getUserById($user_detail['master_id']);

                    if (!empty($user_detail)) {
                        $users_arr[] = array(
                            'sort_priority' => 1,
                            'type' => $user_detail['user_type'],
                            'user_name' => $user_detail['user_name'],
                        );
                    }
                }
            } else if ($user_detail['user_type'] == 'Admin') {
                $users_arr[] = array(
                    'sort_priority' => 2,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );

                $user_detail = (array) $this->User_model->getUserById($user_detail['master_id']);

                if (!empty($user_detail)) {
                    $users_arr[] = array(
                        'sort_priority' => 1,
                        'type' => $user_detail['user_type'],
                        'user_name' => $user_detail['user_name'],
                    );
                }
            } else if ($user_detail['user_type'] == 'Super Admin') {
                $users_arr[] = array(
                    'sort_priority' => 2,
                    'type' => $user_detail['user_type'],
                    'user_name' => $user_detail['user_name'],
                );
            }
        }


        $htmlData = $this->load->viewPartial('/user-details-html', array(
            'users_arr' => $users_arr
        ));

        $dataArray['htmlData'] = $htmlData;

        echo json_encode($dataArray);
    }


    public function usersWinningsSet()
    {
        $users = $this->User_model->get_all_registered_users();

        $date = '2021-03-25 23:59:00';

        if (!empty($users)) {
            foreach ($users as $user) {
                $user_id = $user['user_id'];

                $total_winnings = count_total_winnings($user_id, $date);


                $dataArray = array(
                    "user_id" => $user_id,
                    "scheduler_date" => $date,
                    "total_winnings" => $total_winnings
                );


                $return_user_id = $this->User_model->addUser($dataArray);
            }
        }
        /************************User Info Insert*******************/


        /************************User Info Insert*******************/
    }

    public function listUsersData($master_id, $user_type)
    {

        $this->load->library('Datatable');


        if (get_user_type() == 'Super Admin' || get_user_type() == 'Admin') {
            if ($user_type == 'User') {
                $arr = $this->config->config[$this->_users_listing_headers_1];
            } else {
                $arr = $this->config->config[$this->_masters_listing_headers_1];
            }
        } else {
            if ($user_type == 'User') {
                $arr = $this->config->config[$this->_users_listing_headers];
            } else {
                $arr = $this->config->config[$this->_masters_listing_headers];
            }
        }


        $cols = array_keys($arr);

        $pagingParams = $this->datatable->get_paging_params($cols);





        $pagingParams['user_type'] = urldecode($user_type);
        if (empty($master_id)) {
            $master_id = $_SESSION['my_userdata']['user_id'];


            $user_type = urldecode($user_type);
            if (get_user_type() == 'Super Admin') {

                if ($user_type == 'Admin') {
                    $pagingParams['master_id'] = $master_id;
                }

                if ($user_type == 'Hyper Super Master') {
                    $mastersLists = $this->User_model->getInnerUserIdsById($master_id);
                    $pagingParams['masters'] = $mastersLists;
                    unset($pagingParams['master_id']);
                }
                if ($user_type == 'Super Master') {
                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {

                                    $masterUserIdList[]  = array(
                                        'user_id' => $super->user_id
                                    );
                                }
                            }
                        }
                    }


                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                } else if ($user_type == 'Master') {
                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {
                                    $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                    if (!empty($mastersLists)) {
                                        foreach ($mastersLists as $master) {
                                            $masterUserIdList[]  = array(
                                                'user_id' => $master->user_id
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                } else if ($user_type == 'User') {

                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {
                                    $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                    if (!empty($mastersLists)) {
                                        foreach ($mastersLists as $master) {

                                            $usersLists = $this->User_model->getInnerUserIdsById($master->user_id);

                                            if (!empty($usersLists)) {
                                                foreach ($usersLists as $user) {

                                                    $masterUserIdList[]  = array(
                                                        'user_id' => $user->user_id
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                }
            } else if (get_user_type() == 'Admin') {
                if ($user_type == 'Hyper Super Master') {
                    $pagingParams['master_id'] = $master_id;
                }
                if ($user_type == 'Super Master') {
                    $mastersLists = $this->User_model->getInnerUserIdsById($master_id);
                    $pagingParams['masters'] = $mastersLists;
                    unset($pagingParams['master_id']);
                } else if ($user_type == 'Master') {
                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);


                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);


                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {
                                    // $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                    // if(!empty($mastersLists))
                                    // {
                                    //    foreach($mastersLists as $master)
                                    //    {
                                    $masterUserIdList[]  = array(
                                        'user_id' => $super->user_id
                                    );
                                    //    }
                                    // }

                                }
                            }
                        }
                    }

                    // p($masterUserIdList);
                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                } else if ($user_type == 'User') {

                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {
                                    $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                    if (!empty($mastersLists)) {
                                        foreach ($mastersLists as $master) {
                                            $masterUserIdList[]  = array(
                                                'user_id' => $master->user_id
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                }
            } else if (get_user_type() == 'Hyper Super Master') {
                if ($user_type == 'Super Master') {
                    $pagingParams['master_id'] = $master_id;
                } else if ($user_type == 'Master') {
                    $mastersLists = $this->User_model->getInnerUserIdsById($master_id);
                    $pagingParams['masters'] = $mastersLists;
                    unset($pagingParams['master_id']);
                } else if ($user_type == 'User') {
                    $masterUserIdList = array();
                    $hypersLists = $this->User_model->getInnerUserIdsById($master_id);

                    if (!empty($hypersLists)) {
                        foreach ($hypersLists as $hyper) {
                            $supersLists = $this->User_model->getInnerUserIdsById($hyper->user_id);

                            if (!empty($supersLists)) {
                                foreach ($supersLists as $super) {
                                    // $mastersLists = $this->User_model->getInnerUserIdsById($super->user_id);

                                    // if(!empty($mastersLists))
                                    // {
                                    //    foreach($mastersLists as $master)
                                    //    {
                                    $masterUserIdList[]  = array(
                                        'user_id' => $super->user_id
                                    );
                                    //    }
                                    // }

                                }
                            }
                        }
                    }


                    $pagingParams['masters'] = $masterUserIdList;
                    unset($pagingParams['master_id']);
                }
            } else if (get_user_type() == 'Super Master') {
                if ($user_type == 'Master') {
                    $pagingParams['master_id'] = $master_id;
                } else if ($user_type == 'User') {
                    $mastersLists = $this->User_model->getInnerUserIdsById($master_id);
                    $pagingParams['masters'] = $mastersLists;
                    unset($pagingParams['master_id']);
                }
            } else if (get_user_type() == 'Master') {
                if ($user_type == 'User') {
                    $pagingParams['master_id'] = $master_id;
                }
            } else {
                $pagingParams['master_id'] = $master_id;
            }




            if (!empty($pagingParams['masters']) || !empty($pagingParams['master_id'])) {
                $users = $this->User_model->getAllUsers($pagingParams);
            } else {
                $users = array();
            }
        } else {

            $pagingParams['master_id'] = $master_id;

            $users = $this->User_model->getAllUsers($pagingParams);
        }

        if (get_user_type() == 'Super Admin' || get_user_type() == 'Admin') {

            if ($user_type == 'User') {

                $json_output = $this->datatable->get_json_output($users, $this->_users_listing_headers_1);
            } else {
                $json_output = $this->datatable->get_json_output($users, $this->_masters_listing_headers_1);
            }
        } else {
            if ($user_type == 'User') {

                $json_output = $this->datatable->get_json_output($users, $this->_users_listing_headers);
            } else {
                $json_output = $this->datatable->get_json_output($users, $this->_masters_listing_headers);
            }
        }
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }

    public function listClosedUsersData($master_id, $user_type)
    {
        $this->load->library('Datatable');

        if ($user_type == 'User') {
            $arr = $this->config->config[$this->_users_closed_user_listing_headers];
        } else {
            $arr = $this->config->config[$this->_masters_closed_user_listing_headers];
        }
        $cols = array_keys($arr);

        $pagingParams = $this->datatable->get_paging_params($cols);

        // p($master_id);
        if (empty($master_id)) {
            $master_id = $_SESSION['my_userdata']['user_id'];
        }

        if ($user_type != 'Admin') {
            $pagingParams['master_id'] = $master_id;
            $pagingParams['user_type'] = urldecode($user_type);
        }



        $users = $this->User_model->getAllClosedUsers($pagingParams);


        if ($user_type == 'User') {

            $json_output = $this->datatable->get_json_output($users, $this->_users_closed_user_listing_headers);
        } else {
            $json_output = $this->datatable->get_json_output($users, $this->_masters_closed_user_listing_headers);
        }
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }


    public function updateUserBEW()
    {
        $users = $this->User_model->getAllUserRecords();

        if (!empty($users)) {
            foreach ($users as $user) {
                $user_id = $user['user_id'];
                $data = array(
                    'user_id' => $user['user_id'],
                    'exposure' => count_total_exposure($user_id),
                    'balance' => count_total_balance($user_id),
                    'winings' => count_total_winnings($user_id),

                );
                $user_id = $this->User_model->addUser($data);
            }
        }
    }

    public function addFunds()
    {
        $dataArray = array();
        $this->load->view('/add-funds', $dataArray);
    }


    public function add_balance()
    {
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');
        $user_id = get_user_id();
        $user_type = get_user_type();

        if (!empty($user_id) && !empty($user_type) && !empty($amount)) {
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => $remark,
                'transaction_type' => 'credit',
                'amount' => $amount,
                'is_self_fund' => 'Yes'
            );
            $this->Ledger_model->addLedger($dataArray);



            $data = array(
                'user_id' => $user_id,
                'is_balance_update' =>  'Yes',
                'is_credit_limit_update' => 'Yes',
            );
            $user_id = $this->User_model->addUser($data);


            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    public function setUserNewInfo()
    {
        $info = $this->View_info_model->getDefaultSettingBySportId('2000');

        $users = $this->User_model->get_all_users_by_site_code('P11');

        if (!empty($users)) {
            foreach ($users as $user) {
                $dataValues = array(
                    'setting_id' => $info['setting_id'],
                    'user_id' => $user['user_id'],
                    'sport_name' => $info['sport_name'],


                    'sport_id' => $info['sport_id'],
                    'min_stake' => $info['min_stake'],
                    'max_stake' => $info['max_stake'],
                    'max_profit' => $info['max_profit'],
                    'max_loss' => $info['max_loss'],
                    'bet_delay' => $info['bet_delay'],
                    'pre_inplay_profit' => $info['pre_inplay_profit'],
                    'pre_inplay_stake' => $info['pre_inplay_stake'],
                    'min_odds' => $info['min_odds'],
                    'max_odds' => $info['max_odds'],
                    'unmatch_bet' => $info['unmatch_bet'],
                    'lock_bet' => $info['lock_bet'],
                    'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                    'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                    'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',

                );


                $info_id = $this->View_info_model->saveUserInfo($dataValues);
            }
        }


        exit;



        $user_id = $this->input->post('user_id');


        $userDetail = $this->User_model->getUserById($user_id);
        $user_type = $userDetail->user_type;
        $user_id = $userDetail->user_id;



        if ($user_type == 'Admin') {
            $hyperUsers =  $this->User_model->getInnerUserById($user_id);


            if (!empty($hyperUsers)) {
                foreach ($hyperUsers as $hyperUser) {
                    $user_id = $hyperUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



                    $superUsers =  $this->User_model->getInnerUserById($user_id);


                    if (!empty($superUsers)) {
                        foreach ($superUsers as $superUser) {

                            $user_id = $superUser->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

                            $masterUsers =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($masterUsers)) {
                                foreach ($masterUsers as $masterUser) {
                                    $user_id = $masterUser->user_id;

                                    $dataValues = array(
                                        'setting_id' => $this->input->post('setting_id'),
                                        'user_id' => $user_id,
                                        'sport_id' => $this->input->post('sport_id'),
                                        'min_stake' => $this->input->post('min_stake'),
                                        'max_stake' => $this->input->post('max_stake'),
                                        'max_profit' => $this->input->post('max_profit'),
                                        'max_loss' => $this->input->post('max_loss'),
                                        'bet_delay' => $this->input->post('bet_delay'),
                                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                        'min_odds' => $this->input->post('min_odds'),
                                        'max_odds' => $this->input->post('max_odds'),
                                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                    );
                                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);



                                    $users =  $this->User_model->getInnerUserById($user_id);
                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $user_id = $user->user_id;


                                            $dataValues = array(
                                                'setting_id' => $this->input->post('setting_id'),
                                                'user_id' => $user_id,
                                                'sport_id' => $this->input->post('sport_id'),
                                                'min_stake' => $this->input->post('min_stake'),
                                                'max_stake' => $this->input->post('max_stake'),
                                                'max_profit' => $this->input->post('max_profit'),
                                                'max_loss' => $this->input->post('max_loss'),
                                                'bet_delay' => $this->input->post('bet_delay'),
                                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                                'min_odds' => $this->input->post('min_odds'),
                                                'max_odds' => $this->input->post('max_odds'),
                                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                            );
                                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $superUsers =  $this->User_model->getInnerUserById($user_id);


            if (!empty($superUsers)) {
                foreach ($superUsers as $superUser) {
                    $user_id = $superUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


                    $masterUsers =  $this->User_model->getInnerUserById($user_id);
                    if (!empty($masterUsers)) {
                        foreach ($masterUsers as $masterUser) {
                            $user_id = $masterUser->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);


                            $users =  $this->User_model->getInnerUserById($user_id);
                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $user_id = $user->user_id;


                                    $dataValues = array(
                                        'setting_id' => $this->input->post('setting_id'),
                                        'user_id' => $user_id,
                                        'sport_id' => $this->input->post('sport_id'),
                                        'min_stake' => $this->input->post('min_stake'),
                                        'max_stake' => $this->input->post('max_stake'),
                                        'max_profit' => $this->input->post('max_profit'),
                                        'max_loss' => $this->input->post('max_loss'),
                                        'bet_delay' => $this->input->post('bet_delay'),
                                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                        'min_odds' => $this->input->post('min_odds'),
                                        'max_odds' => $this->input->post('max_odds'),
                                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                                    );
                                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $superUsers =  $this->User_model->getInnerUserById($user_id);


            $masterUsers =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masterUsers)) {
                foreach ($masterUsers as $masterUser) {
                    $user_id = $masterUser->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);

                    $users =  $this->User_model->getInnerUserById($user_id);
                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $user_id = $user->user_id;

                            $dataValues = array(
                                'setting_id' => $this->input->post('setting_id'),
                                'user_id' => $user_id,
                                'sport_id' => $this->input->post('sport_id'),
                                'min_stake' => $this->input->post('min_stake'),
                                'max_stake' => $this->input->post('max_stake'),
                                'max_profit' => $this->input->post('max_profit'),
                                'max_loss' => $this->input->post('max_loss'),
                                'bet_delay' => $this->input->post('bet_delay'),
                                'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                                'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                                'min_odds' => $this->input->post('min_odds'),
                                'max_odds' => $this->input->post('max_odds'),
                                'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                                'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                                'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                                'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                                'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                            );
                            $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                        }
                    }
                }
            }
        } else if ($user_type == 'Master') {

            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $user_id = $user->user_id;

                    $dataValues = array(
                        'setting_id' => $this->input->post('setting_id'),
                        'user_id' => $user_id,
                        'sport_id' => $this->input->post('sport_id'),
                        'min_stake' => $this->input->post('min_stake'),
                        'max_stake' => $this->input->post('max_stake'),
                        'max_profit' => $this->input->post('max_profit'),
                        'max_loss' => $this->input->post('max_loss'),
                        'bet_delay' => $this->input->post('bet_delay'),
                        'pre_inplay_profit' => $this->input->post('pre_inplay_profit'),
                        'pre_inplay_stake' => $this->input->post('pre_inplay_stake'),
                        'min_odds' => $this->input->post('min_odds'),
                        'max_odds' => $this->input->post('max_odds'),
                        'unmatch_bet' => $this->input->post('unmatch_bet')  == 'Yes' ? 'Yes' : 'No',
                        'lock_bet' => $this->input->post('lock_bet') == 'Yes' ? 'Yes' : 'No',
                        'is_odds_active' => $this->input->post('is_odds_active') == 'Yes' ? 'Yes' : 'No',
                        'is_fancy_active' => $this->input->post('is_fancy_active') == 'Yes' ? 'Yes' : 'No',
                        'is_bookmaker_active' => $this->input->post('is_bookmaker_active') == 'Yes' ? 'Yes' : 'No',
                    );
                    $info_id = $this->View_info_model->saveUserInfoAccrdingUpline($dataValues);
                }
            }
        }




        $data = array(
            'success' => true,
            'message' => 'Setting update successfuly'
        );
        echo json_encode($data);
    }


    public function get_user()
    {
        $user_id = $this->input->post('user_id');
        $userDetail = $this->User_model->getUserById($user_id);
        echo json_encode($userDetail);
    }



    public function updateuser()
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $user_id = $this->input->post('user_id');
        $master_commision = $this->input->post('master_commision');
        $sessional_commision = $this->input->post('session_commision');
        $partnership = $this->input->post('partnership');
        // $casino_partnership = $this->input->post('casino_partnership');
        // $teenpati_partnership = $this->input->post('teenpati_partnership');
        $dataArray = array(
            "user_id" => $user_id,
            "master_commision" => $master_commision,
            "sessional_commision" => $sessional_commision,
            "partnership" => $partnership,
            "casino_partnership" => $partnership,
            'teenpati_partnership' => $partnership,
        );


        $return_user_id = $this->User_model->addUser($dataArray);


        $array = array(
            'success' => true,
            'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
        );

        echo json_encode($array);
    }


    public function changeMasterPassword($user_id = null)
    {


        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $userdata = $_SESSION['my_userdata'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        $dataArray = array();

        if ($this->form_validation->run()) {

            $user_id = $this->input->post('user_id');
            $password = $this->input->post('password');

            $dataArray = array(
                "user_id" => $user_id,
            );

            if (!empty($password)) {
                $dataArray['seperate_password'] = $password;
            }
            $result = $this->User_model->addUser($dataArray);

            $postdata = json_encode(array('user_id' => $user_id));


            $url = 'http://localhost:3000/change-password';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
            );
        }
        echo json_encode($array);
    }

    function changePasswordForm()
    {
        $is_demo =  $_SESSION['is_demo'];
        // p($is_demo);

        if ($is_demo == "Yes") {
            redirect('/dashboard');
        }

        $message = $this->session->flashdata('login_error_message');
        $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
        $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

        $dataArray['message'] = $message;



        $userdata = $_SESSION['my_userdata'];




        $this->load->view('change-password-form', $dataArray);
    }

    public function themeUpdate()
    {
        $theme_id = $this->input->post('theme_id');
        $dataArray = array(
            'user_id' => get_user_id(),
            'theme_id' => $theme_id,
        );

        $return_user_id = $this->User_model->addUser($dataArray);

        echo json_encode(array('success' => true));
    }

    function getUserBalance()
    {
        $user_id = $this->input->post('user_id');
        echo get_user_balance($user_id);
    }

    function register_username_exists()
    {
        $user_name = $this->input->post('user_name');
        if (!empty($user_name)) {
            if (!empty($this->User_model->check_username_exists($user_name))) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }
    }


    public function confirm_deposit($id, $user_id, $ChipsValue)
    {

        $type = "D";
        $user_id = $user_id;
        $user = $this->User_model->getUserById($user_id);
        $user_name = $user->name;
        $chip_master_id = $user->master_id;
        $ChipsValue = $ChipsValue;

        if ($ChipsValue <= 0) {
            $this->session->set_flashdata('operation_msg', 'Amount can not be less than zero');
            redirect(base_url('deposit-requests'));
            exit;
        }
        $admin_chip = count_total_balance_without_exposure($chip_master_id);


        $user_chip = count_total_balance_without_exposure($user_id);


        if ($type == 'D') {
            $admin_new_chip = $admin_chip - $ChipsValue;
            $user_new_chip = $user_chip + $ChipsValue;
        } else {
            $admin_new_chip = $admin_chip + $ChipsValue;
            $user_new_chip = $user_chip - $ChipsValue;
        }

        if ($type == 'D') {
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Deposit By ' . $_SESSION['my_userdata']['user_name'],
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' => $user_new_chip,
                'role' => 'Parent'
            );
            $this->Ledger_model->addLedger($dataArray);
            $userDetail = $this->User_model->getUserById($user_id);
            if (!empty($userDetail)) {

                $data = array(
                    'user_id' => $user_id,
                    'is_balance_update' => 'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $x = $this->User_model->addUser($data);
            }
            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Deposit To ' . $user_name,
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' => $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);
            $userDetail = $this->User_model->getUserById($chip_master_id);
            if (!empty($userDetail)) {

                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' => 'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $x = $this->User_model->addUser($data);
            }

            //bonus start
            $this->load->library('Bonus_lib');
            $dataArray = array(
                'user_id' => $user_id,
                'deposit_amount' => $ChipsValue,
            );
            $this->bonus_lib->give_deposit_bonus($dataArray);
            //bonus end
        } else {
            $dataArray = array(
                'user_id' => $user_id,
                'remarks' => 'Free Chip Withdrawl By ' . $_SESSION['my_userdata']['user_name'],
                'transaction_type' => 'debit',
                'amount' => $ChipsValue,
                'balance' => $user_new_chip,
                'role' => 'Parent'

            );
            $this->Ledger_model->addLedger($dataArray);
            $userDetail = $this->User_model->getUserById($user_id);
            if (!empty($userDetail)) {

                $data = array(
                    'user_id' => $user_id,
                    'is_balance_update' => 'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
            $dataArray = array(
                'user_id' => $chip_master_id,
                'remarks' => 'Free Chip Withdrawl from ' . $user_name,
                'transaction_type' => 'credit',
                'amount' => $ChipsValue,
                'balance' => $admin_new_chip
            );
            $this->Ledger_model->addLedger($dataArray);
            $userDetail = $this->User_model->getUserById($chip_master_id);
            if (!empty($userDetail)) {
                $data = array(
                    'user_id' => $chip_master_id,
                    'is_balance_update' => 'Yes',
                    'is_credit_limit_update' => 'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        }

        $dataArray = array(
            'id' => $id,
            'status' => "Confirm"
        );
        $user_id = $this->Deposit_request_model->addDepositRequest($dataArray);

        $this->session->set_flashdata('operation_msg', 'Request Confimed successfully');
        redirect(base_url('deposit-requests'));
    }

    public function confirm_withdraw($id, $user_id, $ChipsValue)
    {


        $user_id = $user_id;
        $user = $this->User_model->getUserById($user_id);
        $user_name = $user->name;
        $master_id = $user->master_id;
        $withdraw = $ChipsValue;

        if ($withdraw > count_total_balance($user_id)) {
            $this->session->set_flashdata('operation_error_msg', 'Withdraw amount can not be greater than user balance');
            redirect(base_url('withdraw-requests'));
        }
        $dataArray = array(
            'user_id' => $user_id,

            'transaction_type' => 'debit',
            'amount' => $withdraw,
            'sender_id' => $user_id,
            'receiver_id' => $master_id
        );
        $this->Ledger_model->addLedger($dataArray);

        $dataArray = array(
            'user_id' => $master_id,
            'transaction_type' => 'credit',
            'amount' => $withdraw,
            'sender_id' => $master_id,
            'receiver_id' => $user_id
        );
        $this->Ledger_model->addLedger($dataArray);

        $dataArray = array(
            'id' => $id,
            'status' => 'Confirm'
        );

        $user_id = $this->Withdraw_request_model->addWithdrawRequest($dataArray);

        $this->session->set_flashdata('operation_msg', 'Request Confimed successfully');
        redirect(base_url('withdraw-requests'));
    }

    public function get_user_detail($user_id = null)
    {
        $dataArray['local_css'] = array(
            'jquery.dataTables.bootstrap',
            'jquery-ui'
        );

        $dataArray['local_js'] = array(
            'jquery.dataTables',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'moment',
            'jquery.validate',
            'jquery-ui'
        );
        $user_detail = $this->User_model->getUserById($user_id);
        $master_id = $user_detail->master_id;
        $master_detail = $this->User_model->getUserById($master_id);

        $dataArray['refered_data'] = $this->Refer_model->get_refered_users_list($user_id);
        $dataArray['master_detail'] = $master_detail;
        $this->load->view('/user-detail-page', $dataArray);
    }
}
