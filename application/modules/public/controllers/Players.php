<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Players extends My_Controller
{
    private $_player_listing_headers = 'player_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
         $this->load->model('Team_model');
        $this->load->model('Player_model');
        $this->load->model('Prediction_master_model');
        $this->load->model('Prediction_master_field_model');

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
    }

    public function addplayer($player_id = null)
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] != 'admin') {
            redirect('/');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('team_id', 'Team', 'required|trim');
        $this->form_validation->set_rules('player_name', 'Player Name', 'required|trim');



        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'Add Team';
            $dataArray['form_action'] = current_url();

            if (!empty($player_id)) {
                $record = $this->Player_model->get_player_by_id($player_id);
                if (!empty($record)) {
                    $dataArray['form_caption'] = 'Edit Team';
                    $dataArray['team_id'] = $record->player_id;
                    $dataArray['player_name'] = $record->player_name;
                    $dataArray['team_id'] = $record->team_id;
                }
            } else {
                $postdata = $this->input->post();

                if (!empty($postdata)) {
                    $dataArray = $postdata;
                    $dataArray['form_caption'] = 'Add Team';
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

            $team_arr = $this->Player_model->allteam_array();
            $dataArray['team_arr'] = add_blank_option($team_arr, 'Select Team');


            $this->load->view('/player-form', $dataArray);
        } else {




            $dataValues = array(
                'team_id' => $this->input->post('team_id'),
                'player_name' => $this->input->post('player_name'),
            );


            if (!empty($player_id)) {
                $dataValues['player_id'] = $player_id;
            }

            $this->Player_model->save_player($dataValues);

            if ($player_id) {
                $this->session->set_flashdata('message', 'Player updated successfully.');
            } else {
                $this->session->set_flashdata('message', 'Player saved successfully.');
            }
            redirect('admin/players');
        }
    }


    public function listplayersdata()
    {
        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_player_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);

        $resultdata = $this->Player_model->get_all_players($pagingParams);

        $json_output = $this->datatable->get_json_output($resultdata, $this->_player_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }

    public function listplayers()
    {
        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] != 'admin') {
            redirect('/');
        }

        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');

        $table_config = array(
            'source' => site_url('admin/players/listplayersdata'),
            'datatable_class' => $this->config->config["datatable_class"],
        );

        $dataArray = array(
            'table' => $this->datatable->make_table($this->_player_listing_headers, $table_config),
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

        $dataArray['table_heading'] = 'Players List';
        $dataArray['new_entry_link'] = base_url() . 'admin/addplayer';
        $dataArray['new_entry_caption'] = 'Add Player';
        $this->load->view('/players-list', $dataArray);
    }

    public function deleteplayer($player_id)
    {
        $this->Player_model->delete_player_by_id($player_id);
        $this->session->set_flashdata('message', 'Player delete successfully');
        redirect('admin/players');
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
}
