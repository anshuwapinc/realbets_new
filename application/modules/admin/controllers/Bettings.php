<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bettings extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';
    private $_betting_listing_headers = 'betting_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Event_type_model');
        $this->load->model('List_event_model');
        $this->load->model('Ledger_model');
        $this->load->model('Betting_model');
        $this->load->model('Manual_model');

        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }




    public function listmarkets()
    {
        if (get_user_type() != 'Super Admin' && get_user_type() != 'Admin') {
            redirect('/');
        }
        $dataArray = array();
        $event_types = $this->Event_type_model->get_all_market_types('No');
        $dataArray['event_types'] = $event_types;
        $dataArray['show_casino'] = 'Yes';

        $this->load->view('/betting-event-type-list', $dataArray);
    }

    public function casinolistmarkets()
    {
        if (get_user_type() != 'Super Admin' && get_user_type() != 'Admin') {
            redirect('/');
        }
        $dataArray = array();
        $event_types = $this->Event_type_model->get_all_market_types('Yes');
        $dataArray['event_types'] = $event_types;
        $dataArray['show_casino'] = 'No';

        $this->load->view('/betting-event-type-list', $dataArray);
    }

    public function listevents($event_type = null)
    {
        if (get_user_type() != 'Super Admin' && get_user_type() != 'Admin') {
            redirect('/');
        }
        $dataArray = array();

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

        $event_type_result = $this->Event_type_model->get_event_type_by_id($event_type);
        $dataArray['event_name'] = $event_type_result->name;
        $dataArray['event_type'] = $event_type_result->event_type;
        $dataArray['event_type_id'] = $event_type_result->event_type_id;

        $list_events = $this->List_event_model->get_list_event_by_event_type($event_type);
        $dataArray['list_events'] = $list_events;
        $this->load->view('/betting-event-list', $dataArray);
    }

    public function list_betting_data($event_id)
    {



        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_betting_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);
        $pagingParams["event_id"] = $event_id;
        $pagingParams["user_id"] = get_user_id();


        $resultdata = $this->Betting_model->get_bettings_by_event_id($pagingParams);
        $json_output = $this->datatable->get_json_output($resultdata, $this->_betting_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }


    public function bettinglists($list_event_id = null)
    {
        if (get_user_type() != 'Super Admin' && get_user_type() != 'Admin') {
            redirect('/');
        }
        $dataArray = array();
        $list_event = $this->List_event_model->get_list_event_by_id($list_event_id);

        $event_id = $list_event->event_id;

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

        //         p($dataArray);
        $this->load->view('/all-betting-list', $dataArray);
    }

    public function deletebet($event_id, $betting_id)
    {
        $betting =  $this->Betting_model->get_betting_by_betting_id($betting_id);

        if (!empty($betting)) {

            $this->Betting_model->delete_bet_by_id($betting_id);
            $this->Ledger_model->delete_ledget_by_betting_id($betting_id);

            if ($betting['status'] == 'Open') {
                $user_details = $this->User_model->getUserById($betting['user_id']);

                $data = array(
                    'user_id' => $betting['user_id'],
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',

                );
                $user_id = $this->User_model->addUser($data);
            } else  if ($betting['status'] == 'Settled') {


                if ($betting['bet_result'] == 'Plus') {

                    $user_details = $this->User_model->getUserById($betting['user_id']);

                    if (!empty($user_details)) {

                        $winnings = $user_details->winings - $betting['profit'];


                        $balance = $user_details->balance  - $betting['profit'];

                        $data = array(
                            'user_id' => $betting['user_id'],
                            'is_balance_update' =>  'Yes',
                            'is_exposure_update' =>  'Yes',
                            'is_winnings_update' =>  'Yes',

                        );
                        $user_id = $this->User_model->addUser($data);
                    }
                } else  if ($betting['bet_result'] == 'Minus') {
                    $user_details = $this->User_model->getUserById($betting['user_id']);

                    if (!empty($user_details)) {

                        $winnings = $user_details->winings + $betting['loss'];
                        $balance = $user_details->balance  + $betting['loss'];

                        $data = array(
                            'user_id' => $betting['user_id'],
                            'is_balance_update' =>  'Yes',
                            'is_exposure_update' =>  'Yes',
                            'is_winnings_update' =>  'Yes',
                        );
                        $user_id = $this->User_model->addUser($data);
                    }
                }
            }
        }


        redirect('admin/bettings/bettinglists/' . $event_id);
    }

    public function ajxdeletebet()
    {

        $bettings = $this->input->post('bettings');

        if (!empty($bettings)) {
            foreach ($bettings as $betting_id) {
                $betting =  $this->Betting_model->get_betting_by_betting_id($betting_id);

                $this->Betting_model->cancel_bet_by_id($betting_id);
                $this->Ledger_model->delete_ledget_by_betting_id($betting_id);

                if ($betting['status'] == 'Open') {
                    $user_details = $this->User_model->getUserById($betting['user_id']);

                    $data = array(
                        'user_id' => $betting['user_id'],
                        'is_balance_update' =>  'Yes',
                        'is_exposure_update' =>  'Yes',
                        'is_winnings_update' =>  'Yes',

                    );
                    $user_id = $this->User_model->addUser($data);
                } else  if ($betting['status'] == 'Settled') {
                    if ($betting['bet_result'] == 'Plus') {

                        $user_details = $this->User_model->getUserById($betting['user_id']);

                        if (!empty($user_details)) {

                            $winnings = $user_details->winings - $betting['profit'];
                            $balance = $user_details->balance  - $betting['profit'];

                            $data = array(
                                'user_id' => $betting['user_id'],
                                'is_balance_update' =>  'Yes',
                                'is_exposure_update' =>  'Yes',
                                'is_winnings_update' =>  'Yes',


                            );
                            $user_id = $this->User_model->addUser($data);
                        }
                    } else  if ($betting['bet_result'] == 'Minus') {
                        $user_details = $this->User_model->getUserById($betting['user_id']);

                        if (!empty($user_details)) {

                            $winnings = $user_details->winings + $betting['loss'];
                            $balance = $user_details->balance  + $betting['loss'];

                            $data = array(
                                'user_id' => $betting['user_id'],
                                'is_balance_update' =>  'Yes',
                                'is_exposure_update' =>  'Yes',
                                'is_winnings_update' =>  'Yes',


                            );
                            $user_id = $this->User_model->addUser($data);
                        }
                    }
                }
            }
        }
    }

    public function ajxdeletebetby_runner()
    {
        $postData = $this->input->post();

        $bettings = $this->Betting_model->get_betting_by_runner_id($postData);
        $this->Manual_model->update_manual_market_book_odds_runner(array(
            'event_id' => $postData['match_id'],
            'market_id' => $postData['market_id'],
            'selection_id' => $postData['selection_id'],
            'is_cancel' => 'Yes'
        ));

        if (!empty($bettings)) {

          


            foreach ($bettings as $betting) {
                $betting_id = $betting['betting_id'];
                $betting =  $this->Betting_model->get_betting_by_betting_id($betting_id);

                $this->Betting_model->cancel_bet_by_id($betting_id);
                $this->Ledger_model->delete_ledget_by_betting_id($betting_id);

                if ($betting['status'] == 'Open') {
                    $user_details = $this->User_model->getUserById($betting['user_id']);

                    $data = array(
                        'user_id' => $betting['user_id'],
                        'is_balance_update' =>  'Yes',
                        'is_exposure_update' =>  'Yes',
                        'is_winnings_update' =>  'Yes',

                    );
                    $user_id = $this->User_model->addUser($data);
                } else  if ($betting['status'] == 'Settled') {
                    if ($betting['bet_result'] == 'Plus') {

                        $user_details = $this->User_model->getUserById($betting['user_id']);

                        if (!empty($user_details)) {

                            $winnings = $user_details->winings - $betting['profit'];
                            $balance = $user_details->balance  - $betting['profit'];

                            $data = array(
                                'user_id' => $betting['user_id'],
                                'is_balance_update' =>  'Yes',
                                'is_exposure_update' =>  'Yes',
                                'is_winnings_update' =>  'Yes',


                            );
                            $user_id = $this->User_model->addUser($data);
                        }
                    } else  if ($betting['bet_result'] == 'Minus') {
                        $user_details = $this->User_model->getUserById($betting['user_id']);

                        if (!empty($user_details)) {

                            $winnings = $user_details->winings + $betting['loss'];
                            $balance = $user_details->balance  + $betting['loss'];

                            $data = array(
                                'user_id' => $betting['user_id'],
                                'is_balance_update' =>  'Yes',
                                'is_exposure_update' =>  'Yes',
                                'is_winnings_update' =>  'Yes',


                            );
                            $user_id = $this->User_model->addUser($data);
                        }
                    }
                }
            }
            $dataArrayRes = array(
                'success' => true,
                'message' => 'Bet Canceled Successfully'
            );
            echo json_encode($dataArrayRes);
        } else {
            $dataArrayRes = array(
                'success' => true,
                'message' => 'No Bets'
            );
            echo json_encode($dataArrayRes);
        }
    }
}
