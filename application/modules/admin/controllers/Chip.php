<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chip extends My_Controller
{

    private $_user_log_activity = 'user_log_activity';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        //            $this->load->model('Admin_model');
        $this->load->model('Admin_model');
        // $this->load->model('Player_model');
        // $this->load->model('Prediction_master_model');
        $this->load->model('Chip_model');
        $this->load->model('User_chip_model');


        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");


        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    function index()
    {
        $message = $this->session->flashdata('login_error_message');
        $resend_activation_success_message = $this->session->flashdata('resend_activation_success_message');
        $resend_activation_error_message = $this->session->flashdata('resend_activation_error_message');

        $dataArray['message'] = $message;



        $userdata = $_SESSION['my_userdata'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );

        $site_code = getCustomConfigItem('site_code');



        $data = $this->Chip_model->get_all_chips($site_code);
        $dataArray['chips'] = $data;


        $this->load->view('chip-list', $dataArray);
    }

    function addchip()
    {
        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('chip_name', 'Chip Name', 'required|trim');
        $this->form_validation->set_rules('chip_value', 'Chip Value', 'required|trim');
        if ($this->form_validation->run()) {

            $chip_name = $this->input->post('chip_name');
            $chip_value = $this->input->post('chip_value');
            $chip_id = $this->input->post('chip_id');
            $site_code = getCustomConfigItem('site_code');


            $dataArray = array(
                "chip_name" => $chip_name,
                "chip_value" => $chip_value,
                "chip_id" => $chip_id,
                "site_code" => $site_code
            );
            $result = $this->Chip_model->addChip($dataArray);
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
                'chip_name' => form_error('chip_name'),
                'chip_value' => form_error('chip_value'),

            );
        }
        echo json_encode($array);
    }

    function deletechip()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('chip_id', 'Chip Id', 'required|trim');


        if ($this->form_validation->run()) {

            $chip_id = $this->input->post('chip_id');



            $result = $this->Chip_model->deleteChip($chip_id);
            $array = array(
                'success' => true,
                'successMessage' => '<div class="alert alert-success">Thank you for Contact Us</div>'
            );
        } else {
            $array = array(
                'error'   => true,
                'chip_name' => form_error('chip_name'),
                'chip_value' => form_error('chip_value'),

            );
        }
        echo json_encode($array);
    }



    function info($event_id)
    {

        $userdata = $_SESSION['my_userdata'];
        $dataArray['local_css'] = array(
            'login-styles',
            'bootstrap',
        );

        $dataArray['local_js'] = array(
            'jquery.validate',
        );


        $info = get_exchange_event_info($event_id);

        $dataArray['response'] = $info;
        // p($dataArray);
        $this->load->view('event_info', $dataArray);
    }

    function update_user_chip()
    {
        $user_chip_id = $this->input->post('user_chip_id');
        $user_id = $this->input->post('user_id');

        $chip_name = $this->input->post('chip_name');
        $chip_value = $this->input->post('chip_value');


        // p($this->input->post());
        if (sizeof($user_chip_id) > 0  && sizeof($chip_value) > 0 && sizeof($chip_name) > 0) {
            $total = sizeof($user_chip_id);

            for ($i = 0; $i < $total; $i++) {
                $dataArray = array(
                    "user_chip_id" => $user_chip_id[$i],
                    "chip_name" => $chip_name[$i],
                    "chip_value" => $chip_value[$i],
                    "user_id" => $user_id
                );

                $result = $this->User_chip_model->addUserChip($dataArray);
            }
        }


        if ($result) {
            $array = array(
                'success' => true,
                'message' => 'Chips updated successfully.'
            );
        } else {
            $array = array(
                'error'   => true,
                'message' => 'Semething went wrong please try again later.',
            );
        }



        echo json_encode($array);
    }

    public function upadateChipsForAll()
    {
        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $user_id = get_user_id();
        $user_type = get_user_type();

        $site_code = getCustomConfigItem('site_code');
        $users = $this->User_model->getUserIdsBySiteCode($site_code);
        $chips = $this->Chip_model->get_all_chips($site_code);




        $deleteArr = array();
        $insertArr = array();





        if ($user_type == 'Admin' || $user_type == 'Super Admin') {


            if (!empty($users)) {
                foreach ($users as $user) {
                    $deleteArr[] = $user->user_id;
                }
            }


            if (!empty($users)) {
                foreach ($users as $user) {
                    if (!empty($chips)) {
                        foreach ($chips as $chip) {
                            $insertArr[] = array(
                                'user_id' => $user->user_id,
                                "chip_name" => $chip['chip_name'],
                                "chip_id" => $chip['chip_id'],
                                "chip_value" => $chip['chip_value'],
                                "created_at" => date("Y-m-d H:i:s")

                            );
                        }
                        // $result = $this->User_chip_model->addChipBatch($chipsData);
                    }
                }
            }

            $this->User_chip_model->delete_multiple_chips_entrys($deleteArr);

            $this->User_chip_model->addChipBatch($insertArr);
        }

        echo json_encode(array('success' => true));
    }
}
