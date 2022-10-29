<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manual extends My_Controller
{
    private $_betting_listing_headers = 'betting_listing_headers_new';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->model('Manual_model');
        $this->load->model('List_event_model');


        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");


        $this->site_code = getCustomConfigItem('site_code');
        $this->load->model('Market_book_odds_runner_model');
        $this->load->model('Market_type_model');


        // $userdata = $_SESSION['my_userdata'];

        // if (empty($userdata)) {
        //     // redirect('/');
        // }
    }

    public function eventTypes()
    {



        $event_types = $this->Manual_model->get_all_event_types();
        $dataArray['event_types'] =  $event_types;
        $this->load->view('/manual-event-types', $dataArray);
    }


    public function eventsLists($event_type = null)
    {

        $dataArray['local_css'] = array(
            'dataTables.bootstrap4',
            'responsive.bootstrap4'
        );

        $dataArray['local_js'] = array(
            'dataTables.min',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'dataTables.bootstrap4',
            // 'dataTables.responsive',
            'responsive.bootstrap4'
        );
        $list_events = (array) $this->Manual_model->get_all_events_lists(array(
            'event_type' => $event_type,
            'site_code' => $this->site_code,
            'is_unlist' => "No"
        ));




        $dataArray['list_events'] = $list_events;
        $dataArray['event_type'] = $event_type;

        $this->load->view('/manual-events-lists', $dataArray);
    }

    public function list_betting_data($event_id)
    {

        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_betting_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);
        $pagingParams["event_id"] = $event_id;
        // $pagingParams["user_id"] = get_user_id();


        $resultdata = $this->Betting_model->get_bettings_by_event_id($pagingParams);
        $json_output = $this->datatable->get_json_output($resultdata, $this->_betting_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }
    public function eventBets($list_event_id = null)
    {
        // p($list_event_id);

        $dataArray = array();
        $list_event = $this->List_event_model->get_list_event_by_id($list_event_id);

        $event_id = $list_event_id;

        $this->load->library('Datatable');
        $table_config = array(
            'source' => site_url('admin/bettings/list_betting_data/' . $event_id),
            'datatable_class' => $this->config->config["datatable_class"],
            'order_by' => '[[2, "desc"]]',
        );
        $dataArray = array(
            'table' => $this->datatable->make_table($this->_betting_listing_headers, $table_config),
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
            // 'dataTables.responsive',
            'responsive.bootstrap4'
        );
        $dataArray['event_name'] = $list_event->event_name;
        $dataArray['winner_selection_id'] = $list_event->winner_selection_id;
        $dataArray['list_event_id'] = $list_event_id;

        // print_r($dataArray);die;

        $this->load->view('/manual-betting-lists', $dataArray);
    }

    public function addEvents()
    {
        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $event_name = $this->input->post('event_name');
        $open_date = $this->input->post('open_date');
        $event_type = $this->input->post('event_type');
        $list_event_id = $this->input->post('list_event_id');

        $data = array(
            'event_name' => $event_name,
            'open_date' => $open_date,
            'event_type' => $event_type,
            'event_name' => $event_name,
            'site_code' => $this->site_code

        );

        if (empty($list_event_id)) {
            $event_id = generateRandomEventId(8);
            $data['event_id'] = $event_id;
        }

        if (!empty($list_event_id)) {
            $data['list_event_id'] = $list_event_id;
        }



        $this->Manual_model->addManualEvent($data);
        echo json_encode(array('success' => true, 'message' => 'Event Add Successfully!'));
    }


    public function marketTypes($list_event_id = null, $event_id = null)
    {


        $market_types = (array) $this->Manual_model->get_all_market_types(array(
            'event_id' => $event_id,
            'site_code' => $this->site_code

        ));



        $dataArray['market_types'] = $market_types;
        $dataArray['event_id'] = $event_id;

        $this->load->view('/manual-market-types', $dataArray);
    }

    public function addMarket()
    {


        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $event_id = $this->input->post('event_id');
        $market_name = $this->input->post('market_name');
        $open_date = $this->input->post('open_date');
        $market_id = $this->input->post('list_market_id');
        $list_id = $this->input->post('list_id');


        $data = array(
            'event_id' => $event_id,
            'market_start_time' => $open_date,
            'market_name' => $market_name,
            'site_code' => $this->site_code

        );

        if (empty($list_id)) {
            $market_id = '55.' . generateRandomEventId(8);
            $data['market_id'] = $market_id;
        }

        if (!empty($list_id)) {
            $data['id'] = $list_id;
        }


        $this->Manual_model->addManualMarketTypes($data);






        if (!empty($market_id)) {
            $data = array(
                'event_id' => $event_id,
                'market_id' => $market_id,
                'inplay' => 0,
                'site_code' => $this->site_code

            );

            $get_market_book_odds = $this->Manual_model->get_manual_market_book_odds(array(
                'market_id' => $market_id
            ));


            if (!empty($get_market_book_odds)) {
                $data['market_book_odd_id'] = $get_market_book_odds['market_book_odd_id'];
                $this->Manual_model->addManualMarketBookOdds($data);
            } else {
                $this->Manual_model->addManualMarketBookOdds($data);
            }
        }





        echo json_encode(array('success' => true, 'message' => 'Event Add Successfully!'));
    }


    public function marketBookRunners($event_id = null, $market_id = null)
    {


        $market_types = (array) $this->Manual_model->get_market_types(array(
            'event_id' => $event_id,
            'site_code' => $this->site_code,
            'market_id' => $market_id,

        ));



        $runners = (array) $this->Manual_model->get_manual_market_runners(array(
            'market_id' => $market_id,
            'site_code' => $this->site_code
        ));




        $dataArray['runners'] = $runners;
        $dataArray['event_id'] = $event_id;
        $dataArray['market_id'] = $market_id;
        $dataArray['market_type'] = $market_types;


        $this->load->view('/manual-market-runners', $dataArray);
    }

    public function updateStatusRecordAll()
    {
          if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $event_id = $this->input->post('event_id');
        $market_id = $this->input->post('market_id');
        $status = $this->input->post('status');


        $data = array(
            'event_id' => $event_id,
            'market_id' => $market_id,
            'status' => $status
        );
        $this->Manual_model->updateStatusRecordAll($data);
        echo json_encode(array('success' => true, 'message' => 'Event Add Successfully!'));
    }
    public function addRunners()
    {
         if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $event_id = $this->input->post('event_id');
        $market_id = $this->input->post('market_id');
        $runner_row_id = $this->input->post('runner_row_id');



        $runner_name = $this->input->post('team_name');
        $back_1_price = $this->input->post('back_1_price');
        $back_1_size = $this->input->post('back_1_size');

        $lay_1_price = $this->input->post('lay_1_price');
        $lay_1_size = $this->input->post('lay_1_size');

        $status = $this->input->post('status');


        $data = array(
            'event_id' => $event_id,
            'market_id' => $market_id,
            'runner_name' => $runner_name,
            'market_book_odd_id' => $market_id,
            'status' => $status,
            'back_1_price' => $back_1_price,
            'back_1_size' => $back_1_size,
            'lay_1_price' => $lay_1_price,
            'lay_1_size' => $lay_1_size,
            'site_code' => $this->site_code

        );


        if (empty($runner_row_id)) {
            $selection_id = generateRandomEventId(5);
            $data['selection_id'] = $selection_id;
        }

        if (!empty($runner_row_id)) {
            $data['id'] = $runner_row_id;
        }


        $this->Manual_model->addManualMarketRunners($data);
        echo json_encode(array('success' => true, 'message' => 'Event Add Successfully!'));
    }

    public function eventStatusChange()
    {
        $list_event_id = $this->input->post('list_event_id');
        $event_id = $this->input->post('event_id');

        $status = $this->input->post('status');

        $data = array(
            'event_id' => $event_id,
            'status' => $status,
            'list_event_id' => $list_event_id,

        );
        $this->Manual_model->addManualEvent($data);
        echo json_encode(array('success' => true, 'message' => 'Status Changed Successfully!'));
    }
    public function unlistManualEvent()
    {
        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }
        $list_event_id = $this->input->post('list_event_id');
        $data = array(
            'list_event_id' => $list_event_id,
            'is_unlist' => "Yes",
            "status" => "Closed",
        );
        $this->Manual_model->unlist_manual_events($data);
        echo json_encode(array('success' => true, 'message' => 'Unlisted Event Successfully!'));
    }

    public function marketStatusChange()
    {
        $market_book_odd_id = $this->input->post('market_book_odd_id');

        $status = $this->input->post('status');

        $data = array(
            'market_book_odd_id' => $market_book_odd_id,
            'status' => $status,

        );
        $this->Manual_model->addManualMarketBookOdds($data);
        echo json_encode(array('success' => true, 'message' => 'Status Changed Successfully!'));
    }


    public function resultEntrySubmit()
    {

        if ($_SESSION['my_userdata']['is_spectator'] == 'Yes') {
            $data = array(
                'success' => false,
                'message' => 'Sorry Spectator has no right'
            );
            echo json_encode($data);
            exit;
        }

        $event_id = $this->input->post('event_id');
        $market_id = $this->input->post('market_id');
        $bet_type = 'Match';
        $entry = $this->input->post('entry');
        $dataArray = array(
            'market_id' => $market_id,
            'is_active' => 'No',
            'status' => 'CLOSE',
            'back_1_price' => '0',
            'lay_1_price' => '0',
            'back_1_size' => '0',
            'lay_1_size' => '0',


        );
        $this->Manual_model->update_manual_market_book_odds_runner($dataArray);


        $dataArray = array(
            'market_id' => $market_id,
            'is_active' => 'No',
            'status' => 'CLOSE'
        );

        $this->Manual_model->update_manual_market_book_odds($dataArray);

        if ($bet_type === 'Match') {


            $market_detail =  $this->Market_type_model->get_manual_market_type_by_market_id(array(
                'event_id' => $event_id,
                'market_id' => $market_id,
            ));

            if (!empty($market_detail)) {
                if ($market_detail->settlement_status != 'Complete') {

                    echo json_encode(array('success' => false, 'htmlData' => '', 'message' => 'Already settling in progress'));
                    exit;
                } else {
                    $dataArray = array(
                        'market_id' => $market_id,
                        'event_id' => $event_id,
                        'winner_selection_id' => $entry,
                        'settlement_status' => 'Start',
                        'settled_by' => $_SESSION['my_userdata']['user_name'],


                    );

                    $this->Market_type_model->add_manual_markets_winner_entry($dataArray);

                    echo json_encode(array('success' => true, 'message' => 'Result Declared Successfully!'));
                }
            } else {
                $dataArray = array(
                    'market_id' => $market_id,
                    'event_id' => $event_id,
                    'winner_selection_id' => $entry,
                    'settlement_status' => 'Start'

                );

                $this->Market_type_model->add_manual_markets_winner_entry($dataArray);

                echo json_encode(array('success' => true, 'message' => 'Result Declared Successfully!'));
            }
        }
    }
}
