<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends My_Controller
{
    private $_user_log_activity = 'user_log_activity';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_info_model');
        $this->load->model('Admin_model');
        $this->load->model('User_model');
        $this->load->model('Chip_model');

        $this->load->model('User_token_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
        $this->load->model('User_chip_model');
    }

    function register_username_exists()
    {
        $user_name = $this->input->post('login_username');

        if (!empty($user_name)) {
            if (!empty($this->User_model->check_username_exists($user_name))) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }
    }

    function register_username_exists_for_forgot_password()
    {
        $user_name = $this->input->post('login_username');
        $site_code = getCustomConfigItem('site_code');
        if (!empty($user_name)) {
            $where = array(
                'user_name' => $user_name,
                'site_code' => $site_code
            );

            if (!empty($this->User_model->check_username_exists_for_forgot_password($where))) {
                echo json_encode(TRUE);
            } else {
                echo json_encode(FALSE);
            }
        }
    }

    public function login()
    {

        if (isset($_SESSION['my_userdata']) && !empty($_SESSION['my_userdata'])) {
            redirect('admin/dashboard');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_username', 'Email', 'required');
        $this->form_validation->set_rules('login_password', 'Password', 'required');
        $dataArray = array();
        $dataArray['template_title'] = USERLOGIN . ' | ' . SITENAME;
        $dataArray['template_heading'] = USERLOGIN;
        if ($this->form_validation->run() == false) {
            $message = $this->session->flashdata('login_error_message');
            $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
            $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

            $dataArray['message'] = $message;
            $dataArray['fb_aap_id'] = getCustomConfigItem('fb_app_id');
            $dataArray['resend_activation_success_message'] = $resend_activation_success_message;
            $dataArray['resend_activation_error_message'] = $resend_activation_error_message;
            $this->load->view('admin-login-form', $dataArray);
        } else {
            log_message("MY_INFO", "Login Start");



            $userRecord = $this->Admin_model->signin($this->input->post('login_username'), $this->input->post('login_password'));



            if (!empty($userRecord)) {

                // if ($userRecord->user_type != 'Super Admin') {
                $site_code = getCustomConfigItem('site_code');

                if ($userRecord->is_demo == 'No') {

                    $_SESSION['is_demo'] = $userRecord->is_demo;
                    if ($userRecord->site_code != $site_code) {
                        $this->session->set_flashdata('login_error_message', 'Invalid Username/Password');

                        redirect(base_url() . 'login');
                    }
                } else {

                    $_SESSION['is_demo'] = $userRecord->is_demo;
                }
                // }


                // if ($userRecord->user_type == 'User') {

                //     $this->session->set_flashdata('login_error_message', 'Invalid Username/Password');
                //     redirect(base_url() . 'login');
                // }




                if ($userRecord->is_locked == 'Yes') {
                    $this->session->set_flashdata('login_error_message', 'Your account is locked.');
                    redirect(base_url() . 'login');
                } else if ($userRecord->is_closed == 'Yes') {
                    $this->session->set_flashdata('login_error_message', 'Your account is closed.');
                    redirect(base_url() . 'login');
                } else {
                    // unset($userRecord->password);

                    $checkUserToken =  $this->User_token_model->getTokeById($userRecord->user_name);
                    $token = getToken(15);

                    if ($checkUserToken) {
                        $dataArray = array(
                            'id' => $checkUserToken->id,
                            'username' => $userRecord->user_name,
                            'token' => $token,
                        );
                        $this->User_token_model->addToken($dataArray);
                    } else {
                        $dataArray = array(
                            'username' => $userRecord->user_name,
                            'token' => $token,
                        );
                        $this->User_token_model->addToken($dataArray);
                    }



                    if (!empty($this->input->post("remember"))) {
                        setcookie("member_username", $userRecord->user_name, time() + (10 * 365 * 24 * 60 * 60));
                        setcookie("member_password", $this->input->post('login_password'), time() + (10 * 365 * 24 * 60 * 60));
                    } else {
                        if (isset($_COOKIE["member_username"]) && isset($_COOKIE["member_password"])) {
                            setcookie("member_username", "");
                            setcookie("member_password", "");
                        }
                    }
                    // p($userRecord->spectator_id);
                    $sessondata['token'] = $token;
                    $sessondata['master_id'] = $userRecord->master_id;
                    $sessondata['user_id'] = empty($userRecord->spectator_id) ? $userRecord->user_id : $userRecord->spectator_id;

                    $sessondata['name'] = $userRecord->name;
                    $sessondata['user_name'] = $userRecord->user_name;
                    $sessondata['logged_in'] = true;
                    $sessondata['user_type'] = $userRecord->user_type;
                    $sessondata['password'] = $userRecord->password;
                    $sessondata['is_spectator'] = empty($userRecord->spectator_id) ? "No" : "Yes";
                    $_SESSION['my_userdata'] = $sessondata;
                    $_SESSION['wcaudio'] = "";
                    log_message("MY_INFO", "Login End");
                    $this->session->set_flashdata('welcome_banner_show', 'show');
                    if ($userRecord->user_type == 'User') {
                        redirect('dashboard');
                    } else if ($userRecord->user_type == 'Super Admin') {
                        redirect('admin/dashboard');
                    } else if ($userRecord->user_type == 'Admin') {
                        redirect('admin/dashboard');
                    } else if ($userRecord->user_type == 'Hyper Super Master') {
                        redirect('admin/dashboard');
                    } else if ($userRecord->user_type == 'Super Master') {
                        redirect('admin/dashboard');
                    } else if ($userRecord->user_type == 'Master') {
                        redirect('admin/dashboard');
                    } else if ($userRecord->user_type == 'Operator') {
                        redirect('admin/dashboard');
                    }
                }
            } else {

                $this->session->set_flashdata('login_error_message', 'Invalid Username/Password');

                if (!empty($sponsor_id)) {

                    redirect(base_url() . 'login');
                } else {

                    redirect(base_url() . 'login');
                }
            }
        }
    }


    public function signUp()
    {
        if (isset($_SESSION['my_userdata']) && !empty($_SESSION['my_userdata'])) {
            redirect('admin/dashboard');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_username', 'Mobile No.', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        // $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        $dataArray = array();
        $dataArray['template_title'] = USERLOGIN . ' | ' . SITENAME;
        $dataArray['template_heading'] = USERLOGIN;
        if ($this->form_validation->run() == false) {

            $message = $this->session->flashdata('login_error_message');
            $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
            $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

            $dataArray['message'] = $message;
            $dataArray['fb_aap_id'] = getCustomConfigItem('fb_app_id');
            $dataArray['resend_activation_success_message'] = $resend_activation_success_message;
            $dataArray['resend_activation_error_message'] = $resend_activation_error_message;
            $this->load->view('admin-signup-form', $dataArray);
        } else {

            log_message("MY_INFO", "Signup Start");

            $master_id = getCustomConfigItem('super_admin');
            $site_code = getCustomConfigItem('site_code');

            $user_name =  $this->input->post('login_username');
            $name =  $this->input->post('login_username');
            $user_type = 'User';
            $phone = $this->input->post('login_username');
            $password = $this->input->post('password');
            $registration_date = date('d-m-Y');


            $check_username_exist = $this->User_model->check_username_exists($user_name);
            if (!empty($check_username_exist)) {
                $this->session->set_flashdata('login_error_message', ' User Name Already taken! ');
                redirect(base_url('sign-up'));
            } else {

                $dataArray = array(
                    "user_name" => $user_name,
                    "registration_date" => date('Y-m-d', strtotime($registration_date)),
                    "user_type" => $user_type,
                    "master_id" => $master_id,
                    "name" => $name,
                    'phone' => $phone,
                    'site_code' => $site_code,
                    'is_password_update' => 'Yes',
                    'is_password_reset' => 'No',

                );

                if (!empty($password)) {
                    $dataArray['password'] = md5($password);
                }

                if (!empty($tpassword)) {
                    // $dataArray['tpassword'] = md5($password);
                }
                if ($this->input->post('referral_code')) {
                    $dataArray['referral_code'] = $this->input->post('referral_code');
                }

                $user_id = $this->User_info_model->addRegisteredUserInfo($dataArray);


                $site_code = getCustomConfigItem('site_code');
                $chips = $this->Chip_model->get_all_chips($site_code);
                // p($chips);
                if (!empty($chips)) {
                    foreach ($chips as $chip) {
                        $dataArray = array(
                            'user_id' => $user_id,
                            'chip_id' => $chip['chip_id'],
                            'chip_name' => $chip['chip_name'],
                            'chip_value' => $chip['chip_value'],
                        );

                        $this->User_chip_model->addUserChip($dataArray);
                    }
                }

                /************************User Info Insert*******************/

                $settings = $this->User_info_model->get_general_setting_by_user_id($master_id);

                if (!empty($settings)) {
                    foreach ($settings as $setting) {

                        $min_stake = 0;
                        $max_stake = 0;
                        $bet_delay = 0;

                        if ($setting['sport_id'] == 4) {
                            $min_stake = $this->input->post('minbettext')[0];
                            $max_stake = $this->input->post('maxbettext')[0];
                            $bet_delay = $this->input->post('delaytext')[0];
                        } else 
                            if ($setting['sport_id'] == 2) {
                            $min_stake = $this->input->post('minbettext')[2];
                            $max_stake = $this->input->post('maxbettext')[2];
                            $bet_delay = $this->input->post('delaytext')[2];
                        } else    if ($setting['sport_id'] == 1) {
                            $min_stake = $this->input->post('minbettext')[1];
                            $max_stake = $this->input->post('maxbettext')[1];
                            $bet_delay = $this->input->post('delaytext')[1];
                        } else {
                            $min_stake = $setting['min_stake'];
                            $max_stake = $setting['max_stake'];
                            $bet_delay = $setting['bet_delay'];
                        }



                        $dataArray = array(
                            'setting_id' => $setting['setting_id'],
                            'user_id' => $user_id,
                            'sport_id' => $setting['sport_id'],
                            'sport_name' => $setting['sport_name'],
                            'min_stake' =>  $setting['min_stake'],
                            'max_stake' => $setting['max_stake'],
                            'max_profit' => $setting['max_profit'],
                            'max_loss' => $setting['max_loss'],
                            'bet_delay' =>  $setting['bet_delay'],
                            'pre_inplay_profit' => $setting['pre_inplay_profit'],
                            'pre_inplay_stake' => $setting['pre_inplay_stake'],
                            'min_odds' => $setting['min_odds'],
                            'max_odds' => $setting['max_odds'],
                            'unmatch_bet' => $setting['unmatch_bet'],
                            'lock_bet' => $setting['lock_bet'],
                        );

                        $this->User_info_model->addUserInfo($dataArray);
                    }
                }

                //bonus start
                $this->load->library('Bonus_lib');
                $this->bonus_lib->give_sign_up_all_bonus($user_id, $this->input->post('referral_code'));
                //bonus end

                $this->session->set_flashdata('signup_success', ' Account Created SUccessfully');
                redirect(base_url());
            }
        }
    }


    public function get_register_Data()
    {
        // p('hii');
        $id =  $_SESSION['my_userdata']['user_id'];
        // p($id);
        $userRecord = $this->Admin_model->get_register_data($id);

        $dataArray = array(
            'user_list' => $userRecord,
        );

        echo json_encode($dataArray);
    }


    public function logout()
    {
        $this->session->unset_userdata('my_userdata');
        redirect('/');
    }

    public function username_check($str)
    {
        if ($str == 'test') {
            $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
            return FALSE;
        } else {
            return TRUE;
        }
    }



    public function admin_dashboard()
    {
        $user_data = GetLoggedinUserData();

        $dataArray = array();
        $dataArray['email'] = $user_data['email'];

        // $dataArray['associationwithd'] = $this->Admin_model->associationwithdrawlNewrequest();


        // if (!empty($user_data) && $user_data['usertype'] == 'Admin') {
        //     $outstanding_amount = superjackpot_outstanding_amount();
        //     $dataArray['jackpot_outstanding_amount'] = my_currency_format($outstanding_amount);
        // }


        $dataArray['local_js'] = array();
        $dataArray['local_css'] = array(
            // 'select2'
        );
        //   p($dataArray);
        $this->load->view('admin_dashboard', $dataArray);
    }

    public function check_user_password()
    {
        $username = $_SESSION['my_userdata']['username'];
        $password = md5($this->input->post("current_password"));


        return $this->Admin_model->check_user_password($username, $password);
    }


    public function check_user_login()
    {
        $username = $_SESSION['my_userdata']['user_name'];
        $token = $_SESSION['my_userdata']['token'];
        $checkUserToken =  $this->User_token_model->getTokeById($username);

        if (!empty($checkUserToken)) {
            if ($token !== $checkUserToken->token) {
                $this->session->unset_userdata('my_userdata');
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    public function sendOtp()
    {
        $number = $this->input->post("number");
        $otp = generateNumericOTP();
        $dataArray["message"] = str_replace("otp_placeholder", $otp, getCustomConfigItem('sms_format'));
        $dataArray["number"] = $number;
        $res = sendOtp($dataArray);
        // if (count($res) > 0) {
        //     if ($res[0]->responseCode == "Message SuccessFully Submitted") {
        $dataValue['number'] = $number;
        $dataValue['otp'] = $otp;
        $data = $this->Admin_model->getSavedOtp($dataValue);
        if ($data) {
            $data = $this->Admin_model->updateOtp($dataValue);
        } else {
            $data = $this->Admin_model->saveOtp($dataValue);
        }
        echo "TRUE";
        //     }
        // } else {
        //     echo "FALSE";
        // }
    }
    public function checkOtp()
    {
        $number = $this->input->post("number");
        $otp = $this->input->post("otp");
        $dataValue['number'] = $number;
        $dataValue['otp'] = $otp;
        $data = $this->Admin_model->getSavedOtp($dataValue);
        // p(  $data);
        if ($data->otp == $otp) {
            echo json_encode(TRUE);
        } else {
            echo json_encode(FALSE);
        }
    }

    public function forgot_password()
    {
        if (isset($_SESSION['my_userdata']) && !empty($_SESSION['my_userdata'])) {
            redirect('admin/dashboard');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_username', 'Mobile No.', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        // $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        $dataArray = array();
        if ($this->form_validation->run() == false) {
            $this->load->view('admin-forgot-password-form');
        } else {

            $user_name =  $this->input->post('login_username');

            $password = $this->input->post('password');
            $encrypted_password = md5($password);



            $user_detail = $this->User_model->getUserByUserName($user_name);

            $user_id = $user_detail['user_id'];


            $update_Arr = array(
                'password' => $encrypted_password,
                'normal_password' => $password,
                "updated_at" => date("Y-m-d H:i:s"),
                'is_delete' => 'No',
                'last_update_ip' => $_SERVER['REMOTE_ADDR']
            );
            $where_arr = array(
                'user_id' => $user_id,
                'site_code' => getCustomConfigItem('site_code'),
            );
            $this->User_model->update_password($where_arr, $update_Arr);
            $this->session->set_flashdata('signup_success', 'Your password changed successfuly ,Login Now !');
            redirect(base_url());
        }
    }
}
