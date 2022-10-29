<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matches extends My_Controller
{
    private $_prediction_listing_headers = 'prediction_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Player_model');

        $this->load->model('Prediction_master_model');
        $this->load->model('Prediction_master_field_model');
        $this->load->model('User_match_entry_model');
        $this->load->model('Admin_model');

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
    }

    public function addMatch($prediction_master_id = null)
    {
        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] != 'user') {
            redirect('/');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('prediction_master_id', 'Master Field', 'required|trim');


        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'Add Match';
            $dataArray['form_action'] = current_url();

            if (!empty($prediction_master_id)) {

                $prediction_master_record = $this->Prediction_master_model->get_prediction_master_by_id($prediction_master_id);

                $dataValues = array(
                    "user_id" => $_SESSION['my_userdata']['userid'],
                    "prediction_master_id" => $prediction_master_id,
                );

                $checkEntry = $this->User_match_entry_model->check_entry($dataValues);

                if (!empty($checkEntry)) {
                    $prediction_master_field_record = $this->Prediction_master_field_model->get_all_field_by_master_id($prediction_master_id, true);
                } else {
                    $prediction_master_field_record = $this->Prediction_master_field_model->get_all_field_by_master_id($prediction_master_id);
                }




                if (!empty($prediction_master_record)) {
                    if (!empty($checkEntry)) {
                        $dataArray['form_caption'] = 'Edit Match Entry';
                    } else {
                        $dataArray['form_caption'] = 'Add Match Entry';
                    }
                    $dataArray['prediction_master_id'] = $prediction_master_record->prediction_master_id;
                    $dataArray['prediction_title'] = $prediction_master_record->prediction_title;
                    $dataArray['first_team_id'] = $prediction_master_record->first_team_id;
                    $dataArray['second_team_id'] = $prediction_master_record->second_team_id;


                    $dataArray['prediction_entry_to'] = $prediction_master_record->prediction_entry_to;
                    $dataArray['prediction_entry_from'] = $prediction_master_record->prediction_entry_from;
                    $dataArray['description'] = $prediction_master_record->description;

                    $dataArray['prediction_master_field_record'] = $prediction_master_field_record;
                }
            } else {
                $postdata = $this->input->post();

                if (!empty($postdata)) {
                    $dataArray = $postdata;
                    $dataArray['form_caption'] = "Match Entry";
                    $dataArray['form_action'] = current_url();
                }
            }

            $dataArray['local_js'] = array(
                'jquery.validate',
                'moment',
                'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );



            $data = array(
                'first_team_id' =>  $dataArray['first_team_id'],
                'second_team_id' =>  $dataArray['second_team_id'],
            );

            $team_arr = $this->Player_model->team_array_by_team_id($data);
            $dataArray['first_team_arr'] = add_blank_option($team_arr, 'Select Team');
            $players_arr = $this->Player_model->all_players_by_team($data);
            $dataArray['players_arr'] = add_blank_option($players_arr, 'Select Player');
            $dataArray['add'] = empty($checkEntry) ? true : false;
            $this->load->view('/match-form', $dataArray);
        } else {

            $prediction_master_id = $this->input->post('prediction_master_id');
            $prediction_master_record = $this->Prediction_master_model->get_prediction_master_by_id($prediction_master_id);
            $currentDateTime = date('Y-m-d H:i:s');
            if($prediction_master_record->prediction_entry_from <= $currentDateTime && $prediction_master_record->prediction_entry_to >= $currentDateTime )
            {   
                $prediction_master_field_id = $this->input->post('prediction_master_field_id');
                $field_type = $this->input->post('field_type');
                $prediction_field_title = $this->input->post('prediction_field_title');
                $variation = $this->input->post('variation');
                $field_value = $this->input->post('field_value');
                $user_entry_id = $this->input->post('user_entry_id');
                $count = sizeof($prediction_master_field_id);
                for ($i = 0; $i < $count; $i++) {
                    $dataValues = array(
                        "user_id" => $_SESSION['my_userdata']['userid'],
                        "prediction_master_id" => $prediction_master_id,
                        "prediction_master_field_id" => $prediction_master_field_id[$i],
    
                    );
                    $checkEntry = $this->User_match_entry_model->check_entry($dataValues);
                    if (!empty($checkEntry)) {
                        $dataValues = array(
                            "user_id" => $_SESSION['my_userdata']['userid'],
                            "prediction_master_id" => $prediction_master_id,
                            "prediction_master_field_id" => $prediction_master_field_id[$i],
                            "field_type" => $field_type[$i],
                            "field_value" => $field_value[$i],
                            "user_entry_id" => $user_entry_id[$i]
                        );
    
                        $this->User_match_entry_model->save_record($dataValues);
                    } else {
                        $dataValues = array(
                            "user_id" => $_SESSION['my_userdata']['userid'],
                            "prediction_master_id" => $prediction_master_id,
                            "prediction_master_field_id" => $prediction_master_field_id[$i],
                            "field_type" => $field_type[$i],
                            "field_value" => $field_value[$i]
                        );
    
                        $this->User_match_entry_model->save_record($dataValues);
                    }
                }
    
    
                $this->session->set_flashdata('message', 'Match Entry successfully.');
                redirect('/matches');
            }
            else
            {

                $this->session->set_flashdata('message', 'Match Entry Timed Out.');
                redirect('/matches');
            }
            
          
        }
    }

 


    public function listmatchdata()
    {
        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_prediction_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);

        $resultdata = $this->Prediction_master_model->get_all_prediction($pagingParams);

        $json_output = $this->datatable->get_json_output($resultdata, $this->_prediction_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }

    public function listmatch()
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] != 'user') {
            redirect('/');
        }


        $message = $this->session->flashdata('message');
        $dataArray['message'] = $message;

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


        $matchesData = $this->Prediction_master_model->all_runinng_matches();


        $dataArray['matchesData'] = $matchesData;
        $dataArray['table_heading'] = 'Matches List';
        $dataArray['new_entry_link'] = base_url() . 'admin/addmatch';
        $dataArray['new_entry_caption'] = 'Add Match';
        $this->load->view('/match-list', $dataArray);
    }

    public function deletematch($prediction_master_id)
    {
        $this->Prediction_master_model->delete_match_by_id($prediction_master_id);
        $this->session->set_flashdata('add_lottery_operation_message', 'Matchdelete successfully');
        redirect('admin/matches');
    }


    public function gettaxbyid()
    {
        $tax_id = $this->input->post('tax_id');
        $result = $this->Tax_model->getTaxById($tax_id);
        echo json_encode($result);
    }


    public function viewTax($tax_id = null)
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] != 'admin') {
            redirect('/');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Tax Title', 'required|trim');
        $this->form_validation->set_rules('tax_slab', 'Tax Slab %', 'required|trim');
        $this->form_validation->set_rules('igst', 'IGST Tax', 'required|trim');
        $this->form_validation->set_rules('cgst', 'CGST Tax', 'required|trim');
        $this->form_validation->set_rules('sgst', 'SGST Tax', 'required|trim');

        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'View Tax';
            $dataArray['form_action'] = current_url();

            if (!empty($tax_id)) {

                $taxrecord = $this->Tax_model->getTaxById($tax_id);
                if (!empty($taxrecord)) {
                    $dataArray['form_caption'] = 'View Tax';
                    $dataArray['tax_id'] = $taxrecord->tax_id;
                    $dataArray['title'] = $taxrecord->title;
                    $dataArray['tax_slab'] = $taxrecord->tax_slab;
                    $dataArray['igst'] = $taxrecord->igst;
                    $dataArray['cgst'] = $taxrecord->cgst;
                    $dataArray['sgst'] = $taxrecord->sgst;
                }
            } else {
                $postdata = $this->input->post();

                if (!empty($postdata)) {
                    $dataArray = $postdata;
                    $dataArray['form_caption'] = $this->lang->line('add') . " " . $this->lang->line('lottery');
                    $dataArray['form_action'] = current_url();
                    $dataArray['lottery_draw_day'] = empty($postdata["lottery_draw_day"]) ? "" : $postdata["lottery_draw_day"];
                } else {
                    $dataArray["lottery_start_tickets_number"] = '';
                    $dataArray["total_tickets"] = '';
                }
            }

            $dataArray['local_js'] = array(
                'jquery.validate',
                'moment',
                'jquery-ui'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
            );

            $this->load->view('/view-tax-form', $dataArray);
        } else {

            $date_addded = date("Y-m-d h:i:s");

            $dataValues = array(
                'title' => $this->input->post('title'),
                'tax_slab' => $this->input->post('tax_slab'),
                'igst' => $this->input->post('igst'),
                'cgst' => $this->input->post('cgst'),
                'sgst' => $this->input->post('sgst'),
            );

            if (!empty($tax_id)) {
                $dataValues['tax_id'] = $tax_id;
            }
            $tax_id = $this->Tax_model->savetax($dataValues);
            $this->session->set_flashdata('message', 'Tax saved successfully.');
            redirect('admin/tax');
        }
    }

    public function deletemasterfield($prediction_master_field_id)
    {
        $this->Prediction_master_field_model->delete_field_by_id($prediction_master_field_id);
    }

    public function reports()
    {

        $userdata = $_SESSION['my_userdata'];
        if (empty($userdata) || $userdata['usertype'] != 'user') {
            redirect('/');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('match_id', 'Match', 'required|trim');


        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_action'] = current_url();

            $dataArray['local_js'] = array(
                'jquery.validate',
                'moment',
                'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );


            $users_arr = $this->Admin_model->users_array();
            $matches_arr = $this->Prediction_master_model->matches_array();

            $dataArray['users_arr'] = add_blank_option($users_arr, 'Select user');
            $dataArray['matches_arr'] = add_blank_option($matches_arr, 'Select Match');

            $this->load->view('/match-report-list', $dataArray);
        } else {
            $dataArray = $this->input->post();
            $dataArray['form_action'] = current_url();
            $dataArray['local_js'] = array(
                'jquery.validate',
                'moment',
                'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );  

            $users_arr = $this->Admin_model->users_array();
            $matches_arr = $this->Prediction_master_model->matches_array();
            $team_arr = $this->Player_model->allteam_array();
            $player_arr = $this->Player_model->allplayers_array();


            $dataArray['users_arr'] = add_blank_option($users_arr, 'Select user');
            $dataArray['matches_arr'] = add_blank_option($matches_arr, 'Select Match');
            $dataArray['team_arr'] = $team_arr;
            $dataArray['player_arr'] = $player_arr;


 
 
          
           
            $dataValues = array(
                'prediction_master_id' => $this->input->post('match_id'),
            );


            if (empty($userdata) || $userdata['usertype'] == 'user') {
                $dataValues['user_id'] = $userdata['userid'];
            }
            
            // p($dataValues);
            $get_report = $this->Prediction_master_model->get_report($dataValues);
            $dataArray['reports'] = $get_report;
            $this->load->view('/match-report-list', $dataArray);
        }
    }
}
