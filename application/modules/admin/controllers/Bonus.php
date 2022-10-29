<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bonus extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Bonus_model');

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    public function bonus_setting()
    {

        if (!empty($this->input->post())) {

            $id = $this->input->post('id');

            $dataArray = array(
                'signup_bonus' => $this->input->post('signup_bonus'),
                'client_first_deposit_bonus' => $this->input->post('client_first_deposit_bonus'),
                'client_other_deposit_bonus' => $this->input->post('client_other_deposit_bonus'),
                'referer_first_deposit_bonus' => $this->input->post('referer_first_deposit_bonus'),
                'referer_other_deposit_bonus' => $this->input->post('referer_other_deposit_bonus'),
                'bonus_use_for_betting' => $this->input->post('bonus_use_for_betting'),
                'signup_referer_bonus' => $this->input->post('signup_referer_bonus'),
                  );

            if (empty($id)) {

                $dataArray['created_at'] = date('Y-m-d h:i:s');
                $dataArray['created_by'] = get_user_id();

                $this->session->set_flashdata('operation_msg', 'Bonus Setting Added Successfuly');
            } else {

                $dataArray['id'] = $id;
                $dataArray['updated_at'] = date('Y-m-d h:i:s');
                $dataArray['updated_by'] = get_user_id();

                $this->session->set_flashdata('operation_msg', 'Bonus Setting Updated Successfuly');
            }

            // p($dataArray);
            $this->Bonus_model->addBonusSetting($dataArray);

            redirect(base_url('bonus-settings'));
        } else {

            $dataArray = $this->Bonus_model->get_bonusSetting();
            // $dataArray = array();

            $this->load->view('bonus-setting', $dataArray);
        }
    }

    public function delete_welcome_note_banner($id)
    {
        $this->Bonus_model->delete_welcome_note_banner($id);
        $this->session->set_flashdata('operation_msg', 'Welcome Note Banner Deleted Successfuly');
        redirect('welcome-note-banner');
    }
}
