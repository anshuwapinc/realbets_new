<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class   Reports extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

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
        $this->load->model('Betting_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");
        $this->load->model('Report_model');
        $this->load->model('Masters_betting_settings_model');
        $this->load->model('Event_type_model');
        $this->load->model('Event_model');
        $this->load->model('Masters_betting_settings_model');



        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }


    public function accountinfo()
    {
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

        $dataArray['user_id']  = $_SESSION['my_userdata']['user_id'];
        // p($dataArray);
        $this->load->view('/account-info', $dataArray);
    }




    public function acStatement($fltrselct = null, $user_id = null)
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
            'dataTables.responsive',
            'responsive.bootstrap4',
            'blockUI'
        );

        $master_id = $_SESSION['my_userdata']['user_id'];

        if (empty($fltrselct)) {
            $fltrselct = 1;
        }


        $reports = array();
        if (!$user_id) {
            $user_id = get_user_id();
        }

        $user = $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;

        $dataArray = array(
            'fltrselct' => $fltrselct,
            'user_id' => $user_id,
            'fromDate' => get_yesterday_datetime(),
            'toDate' => get_today_end_datetime(),
        );

        $newopen_bal = $this->Ledger_model->count_total_balance_by_date($dataArray);

        if ($user_type == 'User') {



            $reports = $this->Ledger_model->get_client_ledger_new($dataArray);


            // p($reports);

            $balance = (float)$newopen_bal;

            if (!empty($reports)) {
                foreach ($reports as $key => $report) {


                    if ($report['type']  == 'Free Chip' || $report['type']  == 'Settlement') {

                        if ($report['transaction_type'] == 'Credit') {
                            $balance += abs($report['amount']);
                            $reports[$key]['transaction_type'] = 'Credit';
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    } else if ($report['type']  == 'Betting') {
                        if ($report['amount'] > 0) {
                            $reports[$key]['transaction_type'] = 'Credit';

                            $balance += abs($report['amount']);
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    }
                    $reports[$key]['available_balance'] = $balance;
                }
            }


            if ($reports) {
                $reports = add_openning_bal_row($newopen_bal, $reports);
            }

            // p($reports);
            array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        } else {
            // $dataArray = array(
            //     'fltrselct' => $fltrselct,
            //     'user_id' => $user_id
            // );

            // $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime("-1 days"));
            // $dataArray['toDate'] = date('Y-m-d H:i:s');



            $reports = $this->Ledger_model->get_admin_ledger_new($dataArray);


            $balance = (float)$newopen_bal;

            if (!empty($reports)) {
                foreach ($reports as $key => $report) {


                    if ($report['type']  == 'Free Chip' || $report['type']  == 'Settlement') {

                        if ($report['transaction_type'] == 'Credit') {
                            $balance += abs($report['amount']);
                            $reports[$key]['transaction_type'] = 'Credit';
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    } else if ($report['type']  == 'Betting') {
                        if ($report['amount'] > 0) {
                            $reports[$key]['transaction_type'] = 'Credit';

                            $balance += abs($report['amount']);
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    }
                    $reports[$key]['available_balance'] = $balance;
                }
            }


            if ($reports) {
                $reports = add_openning_bal_row($newopen_bal, $reports);
            }

            // p($reports);
            array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        }


        $dataArray['reports'] = $reports;
        $dataArray['fltrselct'] = $fltrselct;
        $dataArray['opening_balance'] = 0;
        $dataArray['user_id'] = $user_id;


        $accountStmt = $this->load->viewPartial('/account-statement-list-html', $dataArray);




        $dataArray['accountStmt'] = $accountStmt;
        $dataArray['user_type'] = $user_type;


        $this->load->view('/account-statement', $dataArray);
    }



    public function filterAcStatement()
    {

        $search = $this->input->post('searchTerm');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $fltrselct = $this->input->post('fltrselct');
        $user_id =  $this->input->post('user_id');
        $user_type =  $this->input->post('user_type');


        $reports = array();
        if (!$user_id) {
            $user_id = get_user_id();
        }

        $user = $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;
        $dataArray = array(
            'fltrselct' => $fltrselct,
            'user_id' => $user_id,
            'fromDate' => $fdate,
            'toDate' => $tdate,
        );

        $newopen_bal = $this->Ledger_model->count_total_balance_by_date($dataArray);


        if ($user_type == 'User') {


            // p($dataArray);
            $reports = $this->Ledger_model->get_client_ledger_new($dataArray);


            // p($reports);

            $balance = (float)$newopen_bal;

            if (!empty($reports)) {
                foreach ($reports as $key => $report) {


                    if ($report['type']  == 'Free Chip' || $report['type']  == 'Settlement') {

                        if ($report['transaction_type'] == 'Credit') {
                            $balance += abs($report['amount']);
                            $reports[$key]['transaction_type'] = 'Credit';
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    } else if ($report['type']  == 'Betting') {
                        if ($report['amount'] > 0) {
                            $reports[$key]['transaction_type'] = 'Credit';

                            $balance += abs($report['amount']);
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    }
                    $reports[$key]['available_balance'] = $balance;
                }
            }


            if ($reports) {
                $reports = add_openning_bal_row($newopen_bal, $reports);
            }

            array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        } else {
            // $dataArray = array(
            //     'search' => $search,
            //     'fltrselct' => $fltrselct,
            //     'user_id' => $user_id
            // );


            // if (!empty($fdate) && !empty($tdate)) {
            //     $dataArray['toDate'] = date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            //     $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime($fdate));
            // }

            $reports = $this->Ledger_model->get_admin_ledger_new($dataArray);





            $balance = (float)$newopen_bal;

            if (!empty($reports)) {
                foreach ($reports as $key => $report) {


                    if ($report['type']  == 'Free Chip' || $report['type']  == 'Settlement') {

                        if ($report['transaction_type'] == 'Credit') {
                            $balance += abs($report['amount']);
                            $reports[$key]['transaction_type'] = 'Credit';
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    } else if ($report['type']  == 'Betting') {

                        if ($report['amount'] > 0) {
                            $reports[$key]['transaction_type'] = 'Credit';

                            $balance += abs($report['amount']);
                        } else {
                            $reports[$key]['transaction_type'] = 'Debit';

                            $balance -= abs($report['amount']);
                        }
                    }
                    $reports[$key]['available_balance'] = $balance;
                }
            }

            if ($reports) {
                $reports = add_openning_bal_row($newopen_bal, $reports);
            }
            // p($reports);
            array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        }






        $dataArray['reports'] = $reports;
        $dataArray['fltrselct'] = $fltrselct;
        $dataArray['opening_balance'] = 0;


        $accountStmt = $this->load->viewPartial('/account-statement-list-html', $dataArray);


        $dataArray['accountStmt'] = $accountStmt;
        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;


        echo json_encode($accountStmt);
    }

    public function bethistory($user_id = null)
    {

        if (empty($user_id)) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['pstatus'] = 'Settled';
        $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime("-1 days"));
        $dataArray['toDate'] = date('Y-m-d H:i:s');
        $user_type = get_user_type();
        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);

        if ($user_type == 'Operator') {
            $user_id = getSuperAdminID();
        }


        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }


        $dataArray['user_type'] = $user_type;

        // p($this->db->last_query());
        $event_types = $this->Event_type_model->get_all_event_types();
        $dataArray['event_types'] = $event_types;
        $dataArray['user_id'] = $user_id;
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
            'responsive.bootstrap4',
            'blockUI'
        );
        if (!empty($user_id)) {
            $dataArray['onload_url'] = base_url() . 'admin/Reports/on_load_bethistory/' . $user_id;
        }
        $this->load->view('/bet-history', $dataArray);
    }

    public function on_load_bethistory($user_id = null)
    {

        if (empty($user_id)) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $pegination = $this->input->post('pegination');




        $dataArray['pstatus'] = 'Settled';
        $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime("-1 days"));
        $dataArray['toDate'] = date('Y-m-d H:i:s');
        $user_type = get_user_type();
        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);

        if ($user_type == 'Operator') {
            $user_id = getSuperAdminID();
        }


        $reportsData = array();

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }

        $dataArray['pegination'] = $pegination;
        if ($user_type == 'User') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Hyper Super Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Admin') {
            $dataArray['user_id'] = $user_id;

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Admin') {
            $dataArray['user_id'] = $user_id;


            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Operator') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        }
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);

        $dataArray['bettings'] = $reportsData;
        $dataArray['user_type'] = $user_type;
        // $dataArray['betting'] = $this->load->viewPartial('/betting-history-html', $dataArray);
        // p($this->db->last_query());
        $event_types = $this->Event_type_model->get_all_event_types();
        $dataArray['event_types'] = $event_types;
        $dataArray['user_id'] = $user_id;
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
            'responsive.bootstrap4',
            'blockUI'
        );
        $bethistory = $this->load->viewPartial('/betting-history-html', $dataArray);
        echo json_encode($bethistory);
    }
    public function filterbethistory()
    {
        if (isset($_POST['user_id'])) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }
        $dataArray['user_id']  = $user_id;
        $search = $this->input->post('searchterm');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $sportid = $this->input->post('sportstype') == 5 ? 5 : $this->input->post('sportstype');
        $bstatus = $this->input->post('bstatus');
        $pstatus = $this->input->post('pstatus');

        $dataArray = array(
            'search' => $search,
            'sportid' => $sportid,
            'bstatus' => $bstatus,
            'pstatus' => $pstatus,
        );


        if (!empty($tdate) && !empty($fdate)) {
            $dataArray['fdate'] = date("Y-m-d H:i:s", strtotime($fdate));

            $tdate   =  date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            $dataArray['tdate'] = $tdate;
        }

        $user_type = get_user_type();
        $user_id = get_user_id();

        if ($user_type == 'Operator') {
            $user_id = getSuperAdminID();
        }

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }

        $reportsData = array();
        if ($user_type == 'User') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Hyper Super Master') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Admin') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Admin') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Operator') {
            $dataArray['user_id'] = $user_id;
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        }

        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);
        $dataArray['bettings'] = $reportsData;
        $dataArray['user_type'] = $user_type;

        $bethistory = $this->load->viewPartial('/betting-history-html', $dataArray);
        echo json_encode($bethistory);
    }

    public function profitLossTest($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;



        if ($user_type != 'User') {


            $dataArray['pstatus'] = 'Settled';
            $reportsData = $this->Report_model->get_profit_loss_events_list($dataArray);





            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $match_id = $report['match_id'];
                    $event_name = $report['event_name'];
                    $loss = $report['loss'];
                    $profit = $report['profit'];
                    $total_fancy_profit = $report['total_fancy_profit'];
                    $total_fancy_loss = $report['total_fancy_loss'];
                    $total_fancy_stake = $report['total_fancy_stake'];
                    $partnership = $report['partnership'];
                    $master_commission = $report['master_commission'];
                    $sessional_commission = $report['sessional_commission'];
                    $created_at = $report['created_at'];
                    $event_type = $report['event_type'];

                    // p($report);

                    $match_comm = 0;
                    $session_comm = 0;

                    $match_pl = $profit - $loss;
                    $session_pl = $total_fancy_profit - $total_fancy_loss;




                    if ($match_pl < 0) {
                        $match_comm = abs($match_pl * $master_commission / 100);
                    }


                    if ($total_fancy_stake > 0) {
                        $session_comm = abs($total_fancy_stake * $sessional_commission / 100);
                    }



                    $p_l = 0;


                    $p_l = ($match_pl + $match_comm) + ($session_pl + $session_comm);


                    // p($p_l);
                    $reports[$report['match_id']] = array(
                        'match_id' => $match_id,
                        'event_name' => $event_name,

                        'p_l' => $p_l,
                        'commission' => 0,
                        'created_at' => $created_at
                    );
                }
            }
        } else {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);





            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {


                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }



                        $p_l =  $reports[$report['match_id']]['p_l'];


                        if ($report['betting_is_tie'] == 'No') {
                            if ($report['bet_result'] == 'Plus') {
                                $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                            } else if ($report['bet_result'] == 'Minus') {
                                $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                            }
                        }





                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['betting_is_tie'] == 'No') {
                            if ($report['bet_result'] == 'Plus') {
                                $p_l = $report['profit'];
                            } else if ($report['bet_result'] == 'Minus') {
                                $p_l = $report['loss'] * -1;
                            }
                        }

                        $getCommssion = $this->Ledger_model->get_commission_amt_by_event_id(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));


                        // p($getCommssion);


                        if (!empty($getCommssion)) {
                            $p_l += $getCommssion->total_commission;
                        }

                        // p($p_l);
                        // p($report);
                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

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

        $dataArray['profit_loss']  = $this->load->viewPartial('/profit-loss-list-html', $dataArray);
        $this->load->view('/profit-loss', $dataArray);
    }

    public function gameclientbet($user_id = null)
    {
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

        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }

        $user = $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;
        $dataArray['user_id']  = $user_id;

        if ($user_type == 'Operator') {
            $user_id = getSuperAdminID();
        }
        $dataArray['pstatus'] = 'Open';



        if ($user_type == 'User') {
            $reportsData = $this->Betting_model->get_bettings($dataArray);
        } else if ($user_type == 'Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        } else if ($user_type == 'Super Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        } else if ($user_type == 'Admin') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        } else if ($user_type == 'Super Admin') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        } else if ($user_type == 'Operator') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list(array('user_id' => $user->user_id));
        }

        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);
        $event_types = $this->Event_type_model->get_all_event_types();
        $dataArray['event_types'] = $event_types;
        $dataArray['reports'] = $reportsData;
        $this->load->view('/live-bet-history', $dataArray);
    }


    public function filterProfiltLoss()
    {

        $search = $this->input->post('searchTerm');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $sportid = $this->input->post('sportId');
        $user_id = $this->input->post('user_id');

        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }
        $user_detail = $this->User_model->getUserById($user_id);

        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        // if (!empty($fdate) && !empty($tdate)) {

        //     $dataArray['fdate'] = date('Y-m-d H:i:s', strtotime($fdate));
        //     $dataArray['tdate'] = date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
        // }

        $user_type = $user_detail->user_type;

        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d H:i:s', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';




        if ($user_type != 'User') {


            $dataArray['pstatus'] = 'Settled';


            if ($user_type == 'Master') {
                $reportsData = $this->Report_model->get_profit_loss_events_list($dataArray);
            } else {

                $parent_user_type = '';
                $self_user_type = '';

                if ($user_type == 'Super Master') {
                    $parent_user_type = 'Hyper Super Master';
                    $self_user_type = $user_type;
                } else if ($user_type == 'Hyper Super Master') {
                    $parent_user_type = 'Admin';
                    $self_user_type = $user_type;
                } else if ($user_type == 'Admin') {
                    $parent_user_type = 'Super Admin';
                    $self_user_type = $user_type;
                }

                $dataArray['parent_user_type'] = $parent_user_type;
                $dataArray['self_user_type'] = $self_user_type;


                $reportsData = $this->Report_model->get_profit_loss_events_list_new($dataArray);
            }







            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $match_id = $report['match_id'];
                    $event_name = $report['event_name'];
                    $loss = $report['loss'];
                    $profit = $report['profit'];
                    $total_fancy_profit = $report['total_fancy_profit'];
                    $total_fancy_loss = $report['total_fancy_loss'];
                    $total_fancy_stake = $report['total_fancy_stake'];
                    $partnership = $report['partnership'];
                    $master_commission = $report['master_commission'];
                    $sessional_commission = $report['sessional_commission'];
                    $created_at = $report['created_at'];
                    $event_type = $report['event_type'];

                    // p($report);

                    // $match_comm = 0;
                    // $session_comm = 0;

                    $match_pl = $profit - $loss;
                    $session_pl = $total_fancy_profit - $total_fancy_loss;





                    // if ($match_pl < 0) {
                    //     $match_comm = abs($match_pl * $master_commission / 100);
                    // }


                    // if ($total_fancy_stake > 0) {
                    //     $session_comm = abs($total_fancy_stake * $sessional_commission / 100);
                    // }

                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }


                    if ($report['is_casino'] == 'Yes') {

                        $total_commission = $this->Betting_model->count_match_market_wise_masters_commission(array(
                            'match_id' => $report['match_id'],
                            'user_id' => $user_id,
                            'user_type' => $filter_user_type,
                            'market_id' => $report['market_id'],

                        ));
                    } else {
                        $total_commission = $this->Betting_model->count_match_wise_masters_commission(array(
                            'match_id' => $report['match_id'],
                            'user_id' => $user_id,
                            'user_type' => $filter_user_type

                        ));
                    }




                    $p_l = 0;


                    $p_l = (($match_pl + $total_commission->total_commission) * $report['total_share'] / 100) + ($session_pl  * $report['total_share'] / 100);



                    if ($report['is_casino'] == 'Yes') {

                        $market_id = explode('__', $report['market_id']);


                        if (!empty($market_id)) {
                            $market_id = $market_id[1];
                            $market_id = explode('_', $market_id);

                            if (!empty($market_id)) {

                                $market_id  = $market_id[0];
                            }
                        }

                        $event_name = $event_name . ' / ' . $report['market_name'] . ' / ' . $market_id;
                    }

                    // p($p_l);
                    $reports[] = array(
                        'match_id' => $match_id,
                        'event_name' => $event_name,
                        'is_casino' => $report['is_casino'],
                        'market_id' => $report['market_id'],


                        'p_l' => $p_l,
                        'commission' => 0,
                        'created_at' => $created_at
                    );
                }
            }
        } else {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();
            $reportsData = $this->Betting_model->get_user_profit_loss($dataArray);


            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {

                    $event_name = $report['event_name'];
                    if ($report['is_casino'] == 'Yes') {

                        $market_id = explode('__', $report['market_id']);


                        if (!empty($market_id)) {
                            $market_id = $market_id[1];
                            $market_id = explode('_', $market_id);

                            if (!empty($market_id)) {

                                $market_id  = $market_id[0];
                            }
                        }

                        $event_name = $event_name . ' / ' . $report['market_name'] . ' / ' . $market_id;
                    }


                    $reports[] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $event_name,
                        'is_casino' => $report['is_casino'],
                        'market_id' => $report['market_id'],
                        'p_l' => $report['total_p_l'] + $report['total_commission_pl'],
                        // 'p_l' => $report['total_p_l'],

                        'commission' => 0,
                        'created_at' => $report['created_at']
                    );

                    // if (isset($reports[$report['match_id']])) {
                    //     if ($betting_type == 'fancy') {
                    //         $market_name = 'Fancy';
                    //     } else {
                    //         $market_name = $report['market_name'];
                    //     }



                    //     $p_l =  $reports[$report['match_id']]['p_l'];


                    //     if ($report['betting_is_tie'] == 'No') {
                    //         if ($report['bet_result'] == 'Plus') {
                    //             $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                    //         } else if ($report['bet_result'] == 'Minus') {
                    //             $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                    //         }
                    //     }





                    //     $reports[$report['match_id']] = array(
                    //         'match_id' => $report['match_id'],
                    //         'event_name' => $report['event_name'],
                    //         'market_name' => $market_name,
                    //         'market_id' => $marketId,

                    //         'p_l' => $p_l,
                    //         'commission' => 0,
                    //         'created_at' => $report['created_at']
                    //     );
                    // } else {
                    //     if ($betting_type == 'fancy') {
                    //         $market_name = 'Fancy';
                    //     } else {
                    //         $market_name = $report['market_name'];
                    //     }


                    //     $p_l = 0;

                    //     if ($report['betting_is_tie'] == 'No') {
                    //         if ($report['bet_result'] == 'Plus') {
                    //             $p_l = $report['profit'];
                    //         } else if ($report['bet_result'] == 'Minus') {
                    //             $p_l = $report['loss'] * -1;
                    //         }
                    //     }

                    //     $getCommssion = $this->Ledger_model->get_commission_amt_by_event_id(array(
                    //         'user_id' => $user_id,
                    //         'match_id' => $report['match_id']
                    //     ));


                    //     // p($getCommssion);


                    //     if (!empty($getCommssion)) {
                    //         $p_l += $getCommssion->total_commission;
                    //     }

                    //     // p($p_l);
                    //     // p($report);
                    //     $reports[$report['match_id']] = array(
                    //         'match_id' => $report['match_id'],
                    //         'event_name' => $report['event_name'],
                    //         'market_name' => $market_name,
                    //         'market_id' => $marketId,

                    //         'p_l' => $p_l,
                    //         'commission' => 0,
                    //         'created_at' => $report['created_at']
                    //     );
                    // }
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;
        $profit_loss = $this->load->viewPartial('/profit-loss-list-html', $dataArray);

        echo json_encode($profit_loss);
    }


    public function fancyStack()
    {
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
        $user_id =  $_SESSION['my_userdata']['user_id'];
        $dataArray['sportid']  = 5;

        if (get_user_type() == 'Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;
                    $reports = $this->Report_model->get_fancy_stack($dataArray);

                    if (!empty($reports[0]['name'])) {
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if (get_user_type() == 'Super Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);

            $masters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($masters)) {
                foreach ($masters as  $master) {
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        $total_stake = 0;
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;
                            $reports = $this->Report_model->get_fancy_stack($dataArray);

                            if (!empty($reports)) {
                                if (!empty($reports[0]['total_stake'])) {
                                    $total_stake += $reports[0]['total_stake'];
                                }
                            }
                        }

                        if ($total_stake) {
                            $result[] = array('name' => $master->name, 'total_stake' => $total_stake);

                            $reportsData = array_merge($reportsData, $result);
                        }

                        // p($reports);
                    }
                }
            }
        } else if (get_user_type() == 'Hyper Super Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);


            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as  $superMaster) {
                    $total_stake = 0;
                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                    if (!empty($masters)) {

                        foreach ($masters as  $master) {
                            $total_stake_master = 0;

                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Report_model->get_fancy_stack($dataArray);

                                    if (!empty($reports)) {
                                        if (!empty($reports[0]['total_stake'])) {
                                            $total_stake_master += $reports[0]['total_stake'];
                                        }
                                    }
                                }

                                $total_stake += $total_stake_master;



                                // p($reports);
                            }
                        }
                        if ($total_stake) {
                            $result[] = array('name' => $superMaster->name, 'total_stake' => $total_stake);
                            $reportsData = array_merge($reportsData, $result);
                        }
                    }
                }
            }
        } else if (get_user_type() == 'Admin') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);


            $HyperSuperMasterUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($HyperSuperMasterUsers)) {
                foreach ($HyperSuperMasterUsers as  $HyperSuperMasterUser) {
                    $total_stake = 0;
                    $total_stake_super_master = 0;

                    $superMasters =  $this->User_model->getInnerUserById($HyperSuperMasterUser->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as  $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                            if (!empty($masters)) {

                                foreach ($masters as  $master) {
                                    $total_stake_master = 0;

                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;
                                            $reports = $this->Report_model->get_fancy_stack($dataArray);

                                            if (!empty($reports)) {
                                                if (!empty($reports[0]['total_stake'])) {
                                                    $total_stake_master += $reports[0]['total_stake'];
                                                }
                                            }
                                        }

                                        $total_stake_super_master += $total_stake_master;

                                        // p($reports);
                                    }
                                }
                            }
                        }
                    }
                    // p($total_stake_super_master);
                    $total_stake += $total_stake_super_master;

                    if ($total_stake) {
                        $result[] = array('name' => $HyperSuperMasterUser->name, 'total_stake' => $total_stake);
                        $reportsData = array_merge($reportsData, $result);
                    }
                }
            }
        } else if (get_user_type() == 'Super Admin') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as  $adminUser) {
                    $total_stake_super_master = 0;
                    $total_stake_hyper_super_master = 0;

                    $HyperSuperMasterUsers =  $this->User_model->getInnerUserById($adminUser->user_id);
                    $total_stake = 0;

                    if (!empty($HyperSuperMasterUsers)) {
                        foreach ($HyperSuperMasterUsers as  $HyperSuperMasterUser) {

                            $superMasters =  $this->User_model->getInnerUserById($HyperSuperMasterUser->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as  $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                                    if (!empty($masters)) {

                                        foreach ($masters as  $master) {
                                            $total_stake_master = 0;

                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;
                                                    $reports = $this->Report_model->get_fancy_stack($dataArray);
                                                    if (!empty($reports)) {
                                                        if (!empty($reports[0]['total_stake'])) {
                                                            $total_stake_master += $reports[0]['total_stake'];
                                                        }
                                                    }
                                                }


                                                $total_stake_super_master += $total_stake_master;

                                                // p($reports);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $total_stake += $total_stake_super_master;

                    if (!empty($total_stake)) {
                        $result[] = array('name' => $adminUser->name, 'total_stake' => $total_stake);
                        $reportsData = array_merge($reportsData, $result);
                    }
                }
            }
        }

        $dataArray['user_id']  = $user_id;

        //        p($reports);
        $dataArray['reports'] = $reportsData;
        //        p($reports);
        $dataArray['fancy']  = $this->load->viewPartial('/fancy-stack-html', $dataArray);
        $this->load->view('/fancy-stack', $dataArray);
    }

    public function filterFanctyStack()
    {


        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d H:i:s', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime($fdate));
        }



        if (get_user_type() == 'Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;
                    $reports = $this->Report_model->get_fancy_stack($dataArray);
                    if (!empty($reports[0]['name'])) {
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if (get_user_type() == 'Super Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);

            $masters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($masters)) {
                foreach ($masters as  $master) {
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        $total_stake = 0;
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;
                            $reports = $this->Report_model->get_fancy_stack($dataArray);

                            if (!empty($reports)) {
                                if (!empty($reports[0]['total_stake'])) {
                                    $total_stake += $reports[0]['total_stake'];
                                }
                            }
                        }

                        if ($total_stake) {
                            $result[] = array('name' => $master->name, 'total_stake' => $total_stake);

                            $reportsData = array_merge($reportsData, $result);
                        }
                    }
                }
            }
        } else if (get_user_type() == 'Hyper Super Master') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);


            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as  $superMaster) {
                    $total_stake = 0;
                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                    if (!empty($masters)) {

                        foreach ($masters as  $master) {
                            $total_stake_master = 0;

                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Report_model->get_fancy_stack($dataArray);
                                    if (!empty($reports)) {
                                        if (!empty($reports[0]['total_stake'])) {
                                            $total_stake_master += $reports[0]['total_stake'];
                                        }
                                    }
                                }

                                $total_stake += $total_stake_master;

                                // p($reports);
                            }
                        }
                        if (!empty($total_stake)) {

                            $result[] = array('name' => $superMaster->name, 'total_stake' => $total_stake);
                            $reportsData = array_merge($reportsData, $result);
                        }
                    }
                }
            }
        } else if (get_user_type() == 'Admin') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);


            $HyperSuperMasterUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($HyperSuperMasterUsers)) {
                foreach ($HyperSuperMasterUsers as  $HyperSuperMasterUser) {
                    $total_stake = 0;
                    $total_stake_super_master = 0;

                    $superMasters =  $this->User_model->getInnerUserById($HyperSuperMasterUser->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as  $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                            if (!empty($masters)) {

                                foreach ($masters as  $master) {
                                    $total_stake_master = 0;

                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;
                                            $reports = $this->Report_model->get_fancy_stack($dataArray);

                                            if (!empty($reports)) {
                                                if (!empty($reports[0]['total_stake'])) {
                                                    $total_stake_master += $reports[0]['total_stake'];
                                                }
                                            }
                                        }

                                        $total_stake_super_master += $total_stake_master;

                                        // p($reports);
                                    }
                                }
                            }
                        }
                    }
                    // p($total_stake_super_master);
                    $total_stake += $total_stake_super_master;

                    if ($total_stake) {
                        $result[] = array('name' => $HyperSuperMasterUser->name, 'total_stake' => $total_stake);
                        $reportsData = array_merge($reportsData, $result);
                    }
                }
            }
        } else if (get_user_type() == 'Super Admin') {
            $reportsData = array();
            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as  $adminUser) {
                    $total_stake_super_master = 0;
                    $total_stake_hyper_super_master = 0;

                    $HyperSuperMasterUsers =  $this->User_model->getInnerUserById($adminUser->user_id);
                    $total_stake = 0;

                    if (!empty($HyperSuperMasterUsers)) {
                        foreach ($HyperSuperMasterUsers as  $HyperSuperMasterUser) {

                            $superMasters =  $this->User_model->getInnerUserById($HyperSuperMasterUser->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as  $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);

                                    if (!empty($masters)) {

                                        foreach ($masters as  $master) {
                                            $total_stake_master = 0;

                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;
                                                    $reports = $this->Report_model->get_fancy_stack($dataArray);
                                                    if (!empty($reports)) {
                                                        if (!empty($reports[0]['total_stake'])) {
                                                            $total_stake_master += $reports[0]['total_stake'];
                                                        }
                                                    }
                                                }


                                                $total_stake_super_master += $total_stake_master;

                                                // p($reports);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }


                    $total_stake += $total_stake_super_master;

                    if (!empty($total_stake)) {
                        $result[] = array('name' => $adminUser->name, 'total_stake' => $total_stake);
                        $reportsData = array_merge($reportsData, $result);
                    }
                }
            }
        }


        $dataArray['user_id']  = $user_id;

        //        p($reports);
        // p($reportsData);
        $dataArray['reports'] = $reportsData;
        $fancy_stack =  $this->load->viewPartial('/fancy-stack-html', $dataArray);
        echo json_encode($fancy_stack);
    }

    public function client_pl($userId = null)
    {
        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');


        if (!$userId) {
            $userId = get_user_id();
        }

        $user_detail = $this->User_model->getUserById($userId);


        $user_id = $user_detail->user_id;



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
        $dataArray['master_id']  = $user_id;
        $dataArray['sportid']  = 5;

        $fromDate = date('Y-m-d H:i:s', strtotime("-1 days"));
        $toDate = date('Y-m-d H:i:s');



        $dataArray['toDate'] = $toDate;
        $dataArray['fromDate'] = $fromDate;
        $reports = array();

        $self_user_type  = $user_detail->user_type;
        if ($user_detail->user_type == 'Super Admin') {
            $super_user_type = 'Hyper Super Master';
            $client_user_type = 'Admin';
        } else if ($user_detail->user_type == 'Admin') {
            $super_user_type = 'Super Admin';
            $client_user_type = 'Hyper Super Master';
        } else if ($user_detail->user_type == 'Hyper Super Master') {
            $super_user_type = 'Admin';
            $client_user_type = 'Super Master';
        } else if ($user_detail->user_type == 'Super Master') {
            $super_user_type = 'Hyper Super Master';
            $client_user_type = 'Master';
        } else if ($user_detail->user_type == 'Master') {
            $super_user_type = 'Super Master';
            $client_user_type = 'User';
        }


        $reportsData = $this->Report_model->get_client_pl(array(
            'user_id' => $user_id,
            'user_type' => $client_user_type,
            'fromDate' => $fromDate,
            'toDate' => $toDate,

        ));





        if (!empty($reportsData)) {
            foreach ($reportsData as $data) {

                $super_admin_pl = 0;
                $admin_pl = 0;
                $hyper_super_master_pl = 0;
                $super_master_pl = 0;
                $master_pl = 0;
                $user_pl = 0;



                if ($user_detail->user_type == 'Master') {

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => 0,

                        'hyper_super_master_pl' => 0,

                        'super_master_pl' => ($user_pl + $master_pl) * -1,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );
                } else if ($user_detail->user_type == 'Super Master') {

                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => 0,

                        'hyper_super_master_pl' => ($user_pl + $master_pl + $super_master_pl) * -1,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Hyper Super Master') {

                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => ($user_pl + $master_pl + $super_master_pl + $hyper_super_master_pl) * -1,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Admin') {

                    $admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => ($user_pl + $master_pl + $super_master_pl + $hyper_super_master_pl) * -1,
                        'admin_pl' => $admin_pl,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Super Admin') {

                    $super_admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => $super_admin_pl,
                        'admin_pl' => $admin_pl,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                }
            }
        }

        $dataArray['reports'] = $reports;
        //        p($reports);


        if ($user_detail->user_type == 'Super Admin') {
            $dataArray['fancy']  = $this->load->viewPartial('/super-admin-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Admin') {
            $dataArray['fancy']  = $this->load->viewPartial('/admin-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Hyper Super Master') {
            $dataArray['fancy']  = $this->load->viewPartial('/hyper-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Super Master') {

            $dataArray['fancy']  = $this->load->viewPartial('/super-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Master') {

            // p("Here")
            $dataArray['fancy']  = $this->load->viewPartial('/client-pl-list-html', $dataArray);
        } else {

            $dataArray['fancy']  = $this->load->viewPartial('/client-pl-list-html', $dataArray);
        }

        $dataArray['userId'] = $userId;
        $this->load->view('/client-pl', $dataArray);
    }

    public function filter_client_pl()
    {


        $fromDate = $this->input->post('fdate');
        $toDate = $this->input->post('tdate');
        $user_id =  $this->input->post('user_id');



        if (!$user_id) {
            $user_id = get_user_id();
        }


        $user_detail = $this->User_model->getUserById($user_id);


        $dataArray['master_id']  = $user_id;

        $reports = array();

        $self_user_type  = $user_detail->user_type;
        if ($user_detail->user_type == 'Super Admin') {
            $super_user_type = 'Hyper Super Master';
            $client_user_type = 'Admin';
        } else if ($user_detail->user_type == 'Admin') {
            $super_user_type = 'Super Admin';
            $client_user_type = 'Hyper Super Master';
        } else if ($user_detail->user_type == 'Hyper Super Master') {
            $super_user_type = 'Admin';
            $client_user_type = 'Super Master';
        } else if ($user_detail->user_type == 'Super Master') {
            $super_user_type = 'Hyper Super Master';
            $client_user_type = 'Master';
        } else if ($user_detail->user_type == 'Master') {
            $super_user_type = 'Super Master';
            $client_user_type = 'User';
        }


        $reportsData = $this->Report_model->get_client_pl(array(
            'user_id' => $user_id,
            'user_type' => $client_user_type,
            'fromDate' => $fromDate,
            'toDate' => $toDate,

        ));

        if (!empty($reportsData)) {
            foreach ($reportsData as $data) {

                $super_admin_pl = 0;
                $admin_pl = 0;
                $hyper_super_master_pl = 0;
                $super_master_pl = 0;
                $master_pl = 0;
                $user_pl = 0;



                if ($user_detail->user_type == 'Master') {

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => 0,

                        'hyper_super_master_pl' => 0,

                        'super_master_pl' => ($user_pl + $master_pl) * -1,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );
                } else if ($user_detail->user_type == 'Super Master') {

                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => 0,

                        'hyper_super_master_pl' => ($user_pl + $master_pl + $super_master_pl) * -1,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Hyper Super Master') {

                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => 0,

                        'admin_pl' => ($user_pl + $master_pl + $super_master_pl + $hyper_super_master_pl) * -1,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Admin') {

                    $admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => ($user_pl + $master_pl + $super_master_pl + $hyper_super_master_pl) * -1,
                        'admin_pl' => $admin_pl,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                } else if ($user_detail->user_type == 'Super Admin') {

                    $super_admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $admin_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Admin',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $hyper_super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Hyper Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));


                    $super_master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Super Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));

                    $master_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'Master',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));



                    $user_pl = $this->Report_model->get_super_pl(array(
                        'user_id' => $data['user_id'],
                        'user_type' => 'User',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                    ));





                    $reports[] = array(
                        'user_name' => $data['user_name'],
                        'user_id' => $data['user_id'],
                        'super_admin_pl' => $super_admin_pl,
                        'admin_pl' => $admin_pl,

                        'hyper_super_master_pl' => $hyper_super_master_pl,

                        'super_master_pl' =>  $super_master_pl,
                        'master_pl' => $master_pl,
                        'user_pl' => $user_pl,
                    );

                    // p($reports);
                }
            }
        }
        $dataArray['reports'] = $reports;
        //        p($reports);


        if ($user_detail->user_type == 'Super Admin') {
            $dataArray['fancy']  = $this->load->viewPartial('/super-admin-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Admin') {
            $dataArray['fancy']  = $this->load->viewPartial('/admin-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Hyper Super Master') {
            $dataArray['fancy']  = $this->load->viewPartial('/hyper-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Super Master') {

            $dataArray['fancy']  = $this->load->viewPartial('/super-client-pl-list-html', $dataArray);
        } else if ($user_detail->user_type == 'Master') {

            // p("Here")
            $dataArray['fancy']  = $this->load->viewPartial('/client-pl-list-html', $dataArray);
        } else {
            $dataArray['fancy']  = $this->load->viewPartial('/client-pl-list-html', $dataArray);
        }

        echo json_encode($dataArray['fancy']);
    }

    public function filter_market_pl()
    {


        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $reports = $this->Report_model->get_market_pl($dataArray);
        $dataArray['reports'] = $reports;

        $fancy_stack =  $this->load->viewPartial('/market-pl-list-html', $dataArray);
        echo json_encode($fancy_stack);
    }


    public function user_pl()
    {
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
        $user_id =  $_SESSION['my_userdata']['user_id'];
        $dataArray['user_id']  = $user_id;

        $dataArray['event_type']  = 4;
        $dataArray['orderby']  = 'ASC';
        $dataArray['row_no']  = 10;
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $reports = $this->Report_model->get_user_pl($dataArray);

        $dataArray['reports'] = $reports;
        //        p($reports);
        $dataArray['fancy']  = $this->load->viewPartial('/user-pl-list-html', $dataArray);
        $this->load->view('/user-pl', $dataArray);
    }

    public function filter_userpl()
    {

        $dataArray['event_type']  = $this->input->post('eventType');
        $dataArray['orderby']  = $this->input->post('orderBy');
        $dataArray['row_no']  = $this->input->post('rowNo');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $reports = $this->Report_model->get_user_pl($dataArray);
        $dataArray['reports'] = $reports;

        $fancy_stack =  $this->load->viewPartial('/user-pl-list-html', $dataArray);
        echo json_encode($fancy_stack);
    }

    public function sports_pl()
    {
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
        $user_id =  $_SESSION['my_userdata']['user_id'];
        $dataArray['user_id']  = $user_id;

        $dataArray['event_type']  = 4;
        $dataArray['orderby']  = 'ASC';
        $dataArray['row_no']  = 10;

        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');
        $reports = $this->Report_model->get_sports_pl($dataArray);

        $dataArray['reports'] = $reports;
        //        p($reports);
        $dataArray['fancy']  = $this->load->viewPartial('/sports-pl-list-html', $dataArray);
        $this->load->view('/sports-pl', $dataArray);
    }

    public function filter_sportspl()
    {

        $dataArray['event_type']  = $this->input->post('eventType');
        $dataArray['orderby']  = $this->input->post('orderBy');
        $dataArray['row_no']  = $this->input->post('rowNo');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $reports = $this->Report_model->get_sports_pl($dataArray);

        $dataArray['reports'] = $reports;

        $fancy_stack =  $this->load->viewPartial('/sports-pl-list-html', $dataArray);
        echo json_encode($fancy_stack);
    }

    public function filterlivebethistory()
    {
        $master_id = $_SESSION['my_userdata']['user_id'];

        if (isset($_POST['user_id'])) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }
        $user = $this->User_model->getUserById($user_id);

        $user_type = $user->user_type;


        $searchType = $this->input->post('searchType');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $searchType = $this->input->post('searchType');
        $betStatus = $this->input->post('betStatus');
        $roundid = $this->input->post('roundid');
        $userName = $this->input->post('userName');


        if ($betStatus == 'Settle') {
            $betStatus = 'Settled';
        }

        if (!empty($fdate)) {
            $fdate = date('Y-m-d H:i:s', strtotime($fdate));
        }

        if (!empty($tdate)) {
            $tdate   =  date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
        }

        //p($sportid);
        $dataArray = array(
            'searchType' => $searchType,
            'fdate' => $fdate,
            'tdate' => $tdate,
            'betStatus' => $betStatus,
            'roundid' => $roundid,
            'userName' => $userName
        );

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }


        if ($user_type == 'User') {
            $reportsData = $this->Betting_model->get_bettings($dataArray);
        } else if ($user_type == 'Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Admin') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Admin') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Operator') {
            $reportsData = $this->Report_model->get_live_bet_history_bettings_list($dataArray);
        }


        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);
        $dataArray['reports'] = $reportsData;

        $bethistory = $this->load->viewPartial('/live-betting-history-html', $dataArray);
        echo json_encode($bethistory);
    }








    public function addsettlement()
    {

        $chips = $this->input->post('chips');
        $narration = $this->input->post('narration');
        $userId = $this->input->post('userId');
        $MaxAmt = $this->input->post('MaxAmt');
        $CrDr = $this->input->post('CrDr');

        $user_detail = $this->User_model->getUserById($userId);

        $masterId =  $user_detail->master_id;

        $master_detail = $this->User_model->getUserById($masterId);



        $user_chip = count_total_balance($userId);
        $master_chip = count_total_balance($masterId);

        $user_naration = '';
        $master_naration = '';

        if ($CrDr == 'Plus') {
            $user_new_chip = $user_chip - $chips;
            $master_new_chip = $master_chip + $chips;
            $user_naration = 'Cash Received By Parent';
            $master_naration = 'Cash Paid to ' . $user_detail->user_name;

            if ($user_chip < $chips) {
                echo json_encode(array('success' => false, 'message' => 'Insufficient balance!!'));
                exit;
            }
        } else {

            if ($master_chip < $chips) {
                echo json_encode(array('success' => false, 'message' => 'Insufficient balance!!'));
                exit;
            }
            $user_new_chip = $user_chip + $chips;
            $master_new_chip = $master_chip - $chips;
            $master_naration = 'Cash Received By ' . $user_detail->user_name;
            $user_naration = 'Cash Paid to Parent';
        }

        $dataArray = array(
            'user_id' => $userId,
            'remarks' => $user_naration,
            'transaction_type' => $CrDr == 'Plus' ? 'debit' : 'credit',
            'amount' => $chips,
            'balance' =>  $user_new_chip,
            'type' =>  'Settlement',
            'role' => 'Parent'

        );

        $ledger_id  = $this->Ledger_model->addLedger($dataArray);


        $dataArray = array(
            'user_id' => $masterId,
            'remarks' => $master_naration,
            'transaction_type' => $CrDr == 'Plus' ? 'credit' : 'debit',
            'amount' => $chips,
            'balance' =>  $master_new_chip,
            'type' =>  'Settlement'

        );

        $ledger_id  = $this->Ledger_model->addLedger($dataArray);

        if ($CrDr == 'Plus') {
            $user_details = $this->User_model->getUserById($userId);
            if (!empty($user_details)) {
                $balance = $user_details->balance  - $chips;
                $data = array(
                    'user_id' => $userId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }



            $master_details = $this->User_model->getUserById($masterId);
            if (!empty($master_details)) {
                $balance = $master_details->balance  + $chips;
                $data = array(
                    'user_id' => $masterId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        } else {

            $user_details = $this->User_model->getUserById($userId);
            if (!empty($user_details)) {
                $balance = $user_details->balance  + $chips;
                $data = array(
                    'user_id' => $userId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }



            $master_details = $this->User_model->getUserById($masterId);
            if (!empty($master_details)) {
                $balance = $master_details->balance  - $chips;
                $data = array(
                    'user_id' => $masterId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        }


        if ($ledger_id) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    public function filterChipSummary()
    {

        $searchTerm = $this->input->post('searchTerm');
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');


        $minusArr = array();
        $plusArr = array();

        $minusArr = array();
        $plusArr = array();

        if (!$user_id) {
            $user_id = get_user_id();
        }

        $user =  $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;
        $user_name = $user->user_name;

        if ($user_type === 'Master') {

            $partnership = $user->partnership;
            $master_id = $user->master_id;

            $master_commision = $user->master_commision;

            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision = $master_user->master_commision;
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;


            $users =  $this->User_model->getInnerUserById($user_id, $searchTerm);

            $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;



            $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;
            $parent_total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;
            $parentBettingArr = array(
                'user_id' => $user->user_id,
                'user_name' => $parent_user_name,
                'name' => $parent_name,
                'amount' => 0,
                'master_comission' => 0,
                'partnership' => 0,
                'type' => 'Parent',

                'parent_comission' => 0,
            );

            $totalAmt = 0;
            if (!empty($users)) {
                foreach ($users as $user) {


                    $bettings = (array) $this->Report_model->get_settled_accont_by_users($user->user_id);

                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user->user_id, 'role' => 'Parent'))->settlement_amount;


                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user->user_id, 'role' => 'Parent'))->settlement_amount;
                    $total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;



                    if (!empty($bettings)) {
                        foreach ($bettings as $betting) {
                            if ($betting['bet_result'] == 'Plus') {
                                $totalAmt += $betting['profit'];
                            } else if ($betting['bet_result'] == 'Minus') {
                                $totalAmt -= $betting['loss'];
                            }
                        }
                    }




                    $minus_acc_bettings = array();
                    if (!empty($bettings)) {
                        $bettingArr = array(
                            'user_id' => $user->user_id,
                            'user_name' => $user->user_name,
                            'name' => $user->name,
                            'amount' => 0,
                            'master_comission' => 0,
                            'partnership' => 0,
                            'type' => 'User',

                            'parent_comission' => 0,
                        );


                        foreach ($bettings as $betting) {
                            if ($betting['bet_result'] == 'Minus') {
                                $bettingArr['amount'] -= $betting['loss'];

                                $parnet_loss = $betting['loss'] - (($betting['loss']) * ($partnership / 100));

                                $parentBettingArr["amount"] -= $parnet_loss;
                            } else if ($betting['bet_result'] == 'Plus') {
                                $master_comission = 0;
                                $parent_comission = 0;
                                $profit_amt = $betting['profit'] - $master_comission;
                                $bettingArr['amount'] += $profit_amt;

                                $parnet_loss = $profit_amt - (($profit_amt) * ($partnership / 100));
                                $parentBettingArr["amount"] += $parnet_loss;



                                $bettingArr['master_comission'] += $master_comission;
                                $bettingArr['parent_comission'] += $parent_comission;
                            }
                            $bettingArr['partnership']  =  $partnership;
                        }






                        if ($bettingArr['amount'] < 0) {

                            $bettingArr['amount'] +=   $total_settle_amount;
                        } else {
                            $bettingArr['amount'] -=  $total_settle_amount;
                        }


                        if ($bettingArr['amount'] < 0) {
                            array_push($minusArr, $bettingArr);
                        } else {
                            array_push($plusArr, $bettingArr);
                        }
                    }
                }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] +=   ($parent_total_settle_amount);
                } else {
                    $parentBettingArr['amount'] -=    ($parent_total_settle_amount);
                }

                $parentBettingArr['amount'] = round($parentBettingArr['amount']);


                if ($parentBettingArr['amount'] > 0) {
                    array_push($minusArr, $parentBettingArr);
                } else if ($parentBettingArr['amount'] < 0) {
                    array_push($plusArr, $parentBettingArr);
                }
            }
            //  exit;


        } else if ($user_type === 'Super Master') {
            $partnership = $user->partnership;
            $master_id = $user->master_id;


            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision_pr = $master_user->master_commision;
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;


            $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;


            $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;
            $parent_total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;


            // p($parent_total_settle_amount);

            $parentBettingArr = array(
                'user_id' => $user->user_id,
                'user_name' => $parent_user_name,
                'name' => $parent_name,
                'amount' => 0,
                'master_comission' => 0,
                'partnership' => 0,
                'type' => 'Parent',

                'parent_comission' => 0,
            );

            // p($parentBettingArr);

            $masters =  $this->User_model->getInnerUserById($user_id, $searchTerm);




            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $chid_partnership_pr = $master->partnership;
                    // $child_commission_pr = $master->master_commision;
                    $child_commission_pr = 0;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $master->user_id, 'role' => 'Parent'))->settlement_amount;


                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;


                    $users =  $this->User_model->getInnerUserById($master->user_id);
                    $bettingArr = array(
                        'user_id' => $master->user_id,
                        'user_name' => $master->user_name,
                        'name' => $master->name,
                        'amount' => 0,
                        'master_comission' => 0,
                        'partnership' => 0,
                        'type' => 'User',
                        'parent_comission' => 0,
                    );



                    if (!empty($users)) {
                        foreach ($users as $user) {

                            $bettings = (array) $this->Report_model->get_settled_accont_by_users($user->user_id);

                            if (!empty($bettings)) {

                                foreach ($bettings as $betting) {
                                    if ($betting['bet_result'] == 'Minus') {
                                        $child_loss = ($betting['loss']) * ($chid_partnership_pr / 100);


                                        $profit_amt = $betting['loss']  - $child_loss;

                                        // p($profit_amt);
                                        $bettingArr['amount'] -= $profit_amt;


                                        $parent_loss =  $betting['loss'] - ($betting['loss'] * ($partnership / 100));


                                        $parentBettingArr["amount"] -= $parent_loss;
                                    } else if ($betting['bet_result'] == 'Plus') {

                                        $child_comission  =  0;
                                        $superior_comission  =  0;
                                        $parent_comission  =  0;


                                        $child_profit = ($betting['profit'] - $child_comission) * ($chid_partnership_pr / 100);



                                        $profit_amt = $betting['profit'] - $child_comission - $child_profit;



                                        $bettingArr['amount'] += $profit_amt;

                                        $parent_profit =  $betting['profit'] - ($betting['profit'] * ($partnership / 100));
                                        $parentBettingArr["amount"] += $parent_profit;

                                        $bettingArr['master_comission'] += $superior_comission;
                                        $bettingArr['parent_comission'] += $parent_comission;
                                    }

                                    $bettingArr['partnership']  =  $partnership;
                                }
                            }
                        }
                    }


                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] +=   abs($total_settle_amount);
                    } else {
                        $bettingArr['amount'] -=  abs($total_settle_amount);
                    }

                    $bettingArr['amount'] = round($bettingArr['amount']);
                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else {
                        array_push($plusArr, $bettingArr);
                    }
                }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] +=   $parent_total_settle_amount;
                } else {
                    $parentBettingArr['amount'] -=  $parent_total_settle_amount;
                }


                $parentBettingArr['amount'] = round($parentBettingArr['amount']);
                if ($parentBettingArr['amount'] > 0) {
                    array_push($minusArr, $parentBettingArr);
                } else if ($parentBettingArr['amount'] < 0) {
                    array_push($plusArr, $parentBettingArr);
                }
            }

            // p($plusArr);
            // exit;
        } else if ($user_type === 'Hyper Super Master') {
            $hyper_super_master_partnership = $user->partnership;
            $master_id = $user->master_id;

            $hyper_super_master_comission_pr = $user->master_commision;

            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision_pr = $master_user->master_commision;
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;


            $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;


            $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;
            $parent_total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;

            $parentBettingArr = array(
                'user_id' => $user->user_id,
                'user_name' => $parent_user_name,
                'name' => $parent_name,
                'amount' => 0,
                'master_comission' => 0,
                'partnership' => 0,
                'type' => 'Parent',

                'parent_comission' => 0,
            );


            $super_masters =  $this->User_model->getInnerUserById($user_id, $searchTerm);

            if (!empty($super_masters)) {
                foreach ($super_masters as $super_master) {
                    $smaster_partnership_pr = $super_master->partnership;
                    $super_master_commission_pr = $super_master->master_commision;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $super_master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $super_master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;
                    $bettingArr = array(
                        'user_id' => $super_master->user_id,
                        'user_name' => $super_master->user_name,
                        'name' => $super_master->name,
                        'amount' => 0,
                        'master_comission' => 0,
                        'partnership' => 0,
                        'type' => 'User',
                        'parent_comission' => 0,
                    );


                    $masters =  $this->User_model->getInnerUserById($super_master->user_id);

                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $master_commission_pr = $master->master_commision;
                            $master_partnership_pr = $master->partnership;


                            $users =  $this->User_model->getInnerUserById($master->user_id);
                            if (!empty($users)) {
                                foreach ($users as $user) {

                                    $bettings = (array) $this->Report_model->get_settled_accont_by_users($user->user_id);

                                    foreach ($bettings as $betting) {
                                        if ($betting['bet_result'] == 'Minus') {


                                            $master_loss = ($betting['loss']) * ($master_partnership_pr / 100);


                                            $profit_amt = $betting['loss'] - $master_loss;


                                            $smaster_loss = ($betting['loss']) * ($smaster_partnership_pr / 100);
                                            $profit_amt = $betting['loss'] - $smaster_loss;



                                            $bettingArr['amount'] -= $profit_amt;

                                            $parent_loss = $betting['loss'] - ($betting['loss'] * ($hyper_super_master_partnership / 100));


                                            $parentBettingArr["amount"] -= $parent_loss;
                                        } else if ($betting['bet_result'] == 'Plus') {

                                            $master_profit = ($betting['profit']) * ($master_partnership_pr / 100);

                                            $profit_amt = $betting['profit'];

                                            $smaster_profit = ($profit_amt) * ($smaster_partnership_pr / 100);



                                            $profit_amt =  $betting['profit'] - $smaster_profit;

                                            $bettingArr['amount'] += $profit_amt;
                                            $parent_loss = $betting['profit'] - ($betting['profit'] * ($hyper_super_master_partnership / 100));
                                            $parentBettingArr["amount"] += $parent_loss;

                                            $bettingArr['master_comission'] += 0;
                                            $bettingArr['parent_comission'] += 0;
                                        }
                                        $bettingArr['partnership']  =  $hyper_super_master_partnership;
                                    }
                                }
                            }
                        }
                    }


                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] +=   abs($total_settle_amount);
                    } else {
                        $bettingArr['amount'] -=  abs($total_settle_amount);
                    }

                    $bettingArr['amount'] =   round($bettingArr['amount']);

                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else {
                        array_push($plusArr, $bettingArr);
                    }
                }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] +=   $parent_total_settle_amount;
                } else {
                    $parentBettingArr['amount'] -=  $parent_total_settle_amount;
                }

                $parentBettingArr['amount'] =   round($parentBettingArr['amount']);


                if ($parentBettingArr['amount'] > 0) {
                    array_push($minusArr, $parentBettingArr);
                } else if ($parentBettingArr['amount'] < 0) {
                    array_push($plusArr, $parentBettingArr);
                }
            }
            // exit;
        } else if ($user_type === 'Admin') {

            $admin_partnership = $user->partnership;
            $master_id = $user->master_id;

            $hyper_super_master_comission_pr = $user->master_commision;

            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision_pr = $master_user->master_commision;
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;



            $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;


            $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;
            $parent_total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;

            $parentBettingArr = array(
                'user_id' => $user->user_id,
                'user_name' => $parent_user_name,
                'name' => $parent_name,
                'amount' => 0,
                'master_comission' => 0,
                'partnership' => 0,
                'type' => 'Parent',

                'parent_comission' => 0,
            );

            $hyper_super_master_users =  $this->User_model->getInnerUserById($user_id, $searchTerm);

            if (!empty($hyper_super_master_users)) {
                foreach ($hyper_super_master_users as $hyper_super_master_user) {

                    $chid_partnership_pr = $hyper_super_master_user->partnership;
                    $hmaster_partnership_pr = $hyper_super_master_user->partnership;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $hyper_super_master_user->user_id, 'role' => 'Parent'))->settlement_amount;




                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $hyper_super_master_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;
                    $bettingArr = array(
                        'user_id' => $hyper_super_master_user->user_id,
                        'user_name' => $hyper_super_master_user->user_name,
                        'name' => $hyper_super_master_user->name,
                        'amount' => 0,
                        'master_comission' => 0,
                        'partnership' => 0,
                        'type' => 'User',
                        'parent_comission' => 0,
                    );

                    // p($bettingArr);



                    $super_masters =  $this->User_model->getInnerUserById($hyper_super_master_user->user_id);

                    if (!empty($super_masters)) {
                        foreach ($super_masters as $super_master) {
                            $smaster_partnership_pr = $super_master->partnership;



                            $masters =  $this->User_model->getInnerUserById($super_master->user_id);

                            if (!empty($masters)) {
                                foreach ($masters as $master) {

                                    $master_partnership_pr = $master->partnership;
                                    $users =  $this->User_model->getInnerUserById($master->user_id);
                                    if (!empty($users)) {
                                        foreach ($users as $user) {

                                            $bettings = (array) $this->Report_model->get_settled_accont_by_users($user->user_id);

                                            if (!empty($bettings)) {

                                                foreach ($bettings as $betting) {
                                                    if ($betting['bet_result'] == 'Minus') {
                                                        $master_loss = ($betting['loss']) * ($master_partnership_pr / 100);



                                                        $profit_amt = $betting['loss'] - $master_loss;




                                                        $hmaster_loss = ($betting['loss']) * ($hmaster_partnership_pr / 100);


                                                        $profit_amt = $betting['loss'] - $hmaster_loss;


                                                        $bettingArr['amount'] -= $profit_amt;


                                                        $parent_loss = $betting['loss'] - ($betting['loss'] * ($admin_partnership / 100));
                                                        $parentBettingArr["amount"] -= $parent_loss;
                                                    } else if ($betting['bet_result'] == 'Plus') {

                                                        $master_profit = ($betting['profit']) * ($master_partnership_pr / 100);

                                                        $profit_amt = $betting['profit'] - $master_profit;

                                                        $smaster_profit = ($profit_amt) * ($smaster_partnership_pr / 100);
                                                        $profit_amt = $profit_amt - $smaster_profit;

                                                        $hmaster_profit = ($betting['profit']) * ($hmaster_partnership_pr / 100);
                                                        $profit_amt = $betting['profit'] - $hmaster_profit;

                                                        $bettingArr['amount'] += $profit_amt;

                                                        $parent_loss =  $betting['profit'] - ($betting['profit'] * ($admin_partnership / 100));
                                                        $parentBettingArr["amount"] += $parent_loss;

                                                        $bettingArr['master_comission'] += 0;
                                                        $bettingArr['parent_comission'] += 0;
                                                    }
                                                    $bettingArr['partnership']  =  $admin_partnership;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }


                    // if ($bettingArr['amount'] < 0) {
                    //     $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) + number_format($total_settle_amount, 2);
                    // } else {
                    //     $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) - number_format($total_settle_amount, 2);
                    // }
                    // $bettingArr['amount'] =   round($bettingArr['amount']);

                    // if ($bettingArr['amount'] < 0) {
                    //     array_push($minusArr, $bettingArr);
                    // }  else {
                    //     array_push($plusArr, $bettingArr);
                    // }
                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] +=   abs($total_settle_amount);
                    } else {
                        $bettingArr['amount'] -=  abs($total_settle_amount);
                    }

                    $bettingArr['amount'] =   round($bettingArr['amount']);

                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else {
                        array_push($plusArr, $bettingArr);
                    }
                }

                // if ($parentBettingArr['amount'] < 0) {

                //     $parentBettingArr['amount'] = round($parentBettingArr['amount']) +   $parent_total_settle_amount;
                // } else {
                //     $parentBettingArr['amount'] =   round($parentBettingArr['amount']) - $parent_total_settle_amount;
                // }

                // $parentBettingArr['amount'] =   round($parentBettingArr['amount']);

                // if ($parentBettingArr['amount'] > 0) {
                //     array_push($minusArr, $parentBettingArr);
                // } else if ($parentBettingArr['amount'] < 0) {
                //     array_push($plusArr, $parentBettingArr);
                // }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] +=   $parent_total_settle_amount;
                } else {
                    $parentBettingArr['amount'] -=  $parent_total_settle_amount;
                }

                $parentBettingArr['amount'] =   round($parentBettingArr['amount']);


                if ($parentBettingArr['amount'] > 0) {
                    array_push($minusArr, $parentBettingArr);
                } else if ($parentBettingArr['amount'] < 0) {
                    array_push($plusArr, $parentBettingArr);
                }
            }
        } else if (get_user_type() === 'Super Admin') {

            $user_id = get_user_id();
            $user =  $this->User_model->getUserById($user_id);
            $hyper_super_master_partnership = $user->partnership;
            $master_id = $user->master_id;

            $hyper_super_master_comission_pr = $user->master_commision;

            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision_pr = 0;
            $parent_name = '';



            $admin_users =  $this->User_model->getInnerUserById($user_id, $searchTerm);

            if (!empty($admin_users)) {
                foreach ($admin_users as $admin_user) {
                    $chid_partnership_pr = $admin_user->partnership;
                    $super_master_commission_pr = $admin_user->master_commision;
                    $admin_partnership_pr =  $admin_user->partnership;

                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $admin_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $admin_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt - $ledger_minus_settle_amt;
                    $bettingArr = array(
                        'user_id' => $admin_user->user_id,
                        'user_name' => $admin_user->user_name,
                        'name' => $admin_user->name,
                        'amount' => 0,
                        'master_comission' => 0,
                        'partnership' => 0,
                        'type' => 'User',

                        'parent_comission' => 0,
                    );


                    $hyper_super_master_users =  $this->User_model->getInnerUserById($admin_user->user_id);

                    if (!empty($hyper_super_master_users)) {
                        foreach ($hyper_super_master_users as $hyper_super_master_user) {
                            $hmaster_partnership_pr =  $hyper_super_master_user->partnership;



                            $super_masters =  $this->User_model->getInnerUserById($hyper_super_master_user->user_id);

                            if (!empty($super_masters)) {
                                foreach ($super_masters as $super_master) {

                                    $smaster_partnership_pr =  $super_master->partnership;



                                    $masters =  $this->User_model->getInnerUserById($super_master->user_id);

                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $master_commission_pr = $master->master_commision;
                                            $master_partnership_pr =  $master->partnership;
                                            $users =  $this->User_model->getInnerUserById($master->user_id);
                                            if (!empty($users)) {
                                                foreach ($users as $user) {

                                                    $bettings = (array) $this->Report_model->get_settled_accont_by_users($user->user_id);

                                                    if (!empty($bettings)) {

                                                        foreach ($bettings as $betting) {
                                                            if ($betting['bet_result'] == 'Minus') {
                                                                $master_loss = ($betting['loss']) * ($master_partnership_pr / 100);




                                                                $profit_amt = $betting['loss'] - $master_loss;
                                                                $smaster_loss = ($profit_amt) * ($smaster_partnership_pr / 100);
                                                                $profit_amt = $profit_amt - $smaster_loss;


                                                                $hmaster_loss = ($profit_amt) * ($hmaster_partnership_pr / 100);
                                                                $profit_amt = $profit_amt - $hmaster_loss;


                                                                $admin_loss = ($betting['loss']) * ($admin_partnership_pr / 100);
                                                                $profit_amt = $betting['loss'] - $admin_loss;



                                                                $bettingArr['amount'] -= $profit_amt;
                                                            } else if ($betting['bet_result'] == 'Plus') {

                                                                $master_profit = ($betting['profit']) * ($master_partnership_pr / 100);

                                                                $profit_amt = $betting['profit'] - $master_profit;

                                                                $smaster_profit = ($profit_amt) * ($smaster_partnership_pr / 100);
                                                                $profit_amt = $profit_amt - $smaster_profit;
                                                                //  p($profit_amt);

                                                                $hmaster_profit = ($profit_amt) * ($hmaster_partnership_pr / 100);
                                                                $profit_amt = $profit_amt - $hmaster_profit;

                                                                $admin_profit = ($betting['profit']) * ($admin_partnership_pr / 100);
                                                                $profit_amt = $betting['profit'] - $admin_profit;



                                                                $bettingArr['amount'] += $profit_amt;
                                                                $bettingArr['master_comission'] += 0;
                                                                $bettingArr['parent_comission'] += 0;
                                                            }
                                                            $bettingArr['partnership']  =  $hyper_super_master_partnership;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) + number_format($total_settle_amount, 2);
                    } else {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) - number_format($total_settle_amount, 2);
                    }


                    $bettingArr['amount'] = round($bettingArr['amount']);
                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else {
                        array_push($plusArr, $bettingArr);
                    }
                }
            }
        }


        $dataArray['minus_acc'] = $minusArr;
        $dataArray['plus_acc'] = $plusArr;
        $dataArray['parent_name'] = $parent_name;
        $dataArray['user_type'] = $user_type;
        $dataArray['user_id'] = $user_id;
        $dataArray['user_name'] = $user_name;

        $chip_smmary_html = $this->load->viewPartial('chip-summary-html', $dataArray);
        echo json_encode($chip_smmary_html);
    }




    public function profitLossbethistory($event_id = null, $market_id = null, $user_id = null, $is_fancy = null)
    {


        $master_id = $_SESSION['my_userdata']['user_id'];
        if (empty($user_id)) {

            $user_id =  $_SESSION['my_userdata']['user_id'];
        }



        $dataArray['pstatus'] = 'Settled';

        if ($is_fancy == 'Yes') {
            $dataArray['betting_type'] = 'Fancy';
        } else {
            $dataArray['betting_type'] = 'Match';
        }

        $dataArray['match_id'] = $event_id;



        // p($is_fancy);
        if ($is_fancy == 'Yes') {
            // $dataArray['selection_id'] = $market_id;
        } else {
            $dataArray['market_id'] = $market_id;
        }



        $user =  $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;
        $reportsData = array();


        $dataArray['user_id']  = $user_id;

        $dataArray['is_fancy'] = $is_fancy;



        if ($user_type == 'User') {


            // p($dataArray);
            $reports = $this->Betting_model->get_bettings($dataArray);


            // p($reports);
            foreach ($reports as $reportKey => $report) {


                if ($report['betting_type'] == 'Fancy') {
                    $selection_id = $report['selection_id'];
                    $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                    $settled_result = empty($fancy_info->result) ? null : $fancy_info->result;
                    // $settled_result = $fancy_info->result;
                    $reports[$reportKey]['settled_result'] = $settled_result;
                } else if ($report['betting_type'] == 'Match') {
                    $winner_selection_id = $report['winner_selection_id'];
                    $market_id = $report['market_id'];

                    $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                    $result = '';

                    $runner =  $this->Event_model->get_market_book_odds_runner_by_id(array('market_id' => $market_id, 'selection_id' => $winner_selection_id));
                    $result = $runner->runner_name;
                    // if (!empty($market_info)) {
                    //     if ($winner_selection_id == $market_info->runner_1_selection_id) {
                    //         $result = $market_info->runner_1_runner_name;
                    //     } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                    //         $result = $market_info->runner_2_runner_name;
                    //     }
                    // }

                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        }
        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);
        $dataArray['bettings'] = $reportsData;
        $dataArray['user_type'] = $user_type;

        $dataArray['betting'] = $this->load->viewPartial('/profit-loss-betting-list-html', $dataArray);

        $dataArray['match_id'] = $event_id;
        $dataArray['market_id'] = $market_id;
        $dataArray['is_fancy'] = $is_fancy;

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
            'responsive.bootstrap4',
            'blockUI'
        );
        //         p($reports);
        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        $this->load->view('/profit-loss-bet-history', $dataArray);
    }
    public function profitLossfilterbethistory($event_id = null, $market_id = null, $user_id = null, $is_fancy = null)
    {

        if (isset($_POST['user_id'])) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }

        $dataArray['user_id']  = $user_id;


        $search = $this->input->post('searchterm');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');
        $sportid = $this->input->post('sportstype') == 5 ? 5 : $this->input->post('sportstype');
        $bstatus = $this->input->post('bstatus');
        $pstatus = $this->input->post('pstatus');
        $market_id = $this->input->post('market_id');
        $match_id = $this->input->post('match_id');
        $is_fancy = $this->input->post('is_fancy');


        //p($sportid);
        $dataArray = array(
            'search' => $search,
            'sportid' => $sportid,
            'bstatus' => $bstatus,
            'pstatus' => $pstatus,
        );


        if ($is_fancy == 'Yes') {
            $dataArray['betting_type'] = 'Fancy';
        } else {
            $dataArray['betting_type'] = 'Match';
        }

        $dataArray['match_id'] = $match_id;


        if (!empty($tdate) && !empty($fdate)) {
            $dataArray['fromDate'] = date("Y-m-d H:i:s", strtotime($fdate));

            $tdate   =  date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            $dataArray['toDate'] = $tdate;
        }


        $user =  $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;

        $dataArray['user_id']  = $user_id;


        $reportsData = array();

        if ($user_type == 'User') {
            $reports = $this->Betting_model->get_bettings($dataArray);


            foreach ($reports as $reportKey => $report) {


                if ($report['betting_type'] == 'Fancy') {
                    $selection_id = $report['selection_id'];
                    $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                    $settled_result = $fancy_info->result;

                    $reports[$reportKey]['settled_result'] = $settled_result;
                } else if ($report['betting_type'] == 'Match') {
                    $winner_selection_id = $report['winner_selection_id'];
                    $market_id = $report['market_id'];

                    $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                    $result = '';
                    $runner =  $this->Event_model->get_market_book_odds_runner_by_id(array('market_id' => $market_id, 'selection_id' => $winner_selection_id));
                    $result = $runner->runner_name;


                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else if ($user_type == 'Master') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Master') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Admin') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        } else if ($user_type == 'Super Admin') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
        }


        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime', array_column($reportsData, 'created_at')), SORT_DESC, $reportsData);
        $dataArray['bettings'] = $reportsData;
        $dataArray['user_type'] = $user_type;
        $bethistory = $this->load->viewPartial('/profit-loss-betting-list-html', $dataArray);
        echo json_encode($bethistory);
    }



    public function chip_summarynew1($user_id = null)
    {


        if ($user_id == null) {
            $user_id = get_user_id();
        }
        $user = $this->User_model->getUserById($user_id);
        $login_user = $user;
        $user_type = $user->user_type;



        if ($user_type == 'Super Admin') {
            $list_user_type = 'sba';
        } else if ($user_type == 'Admin') {
            $list_user_type = 'master';
        } else if ($user_type == 'Hyper Super Master') {
            $list_user_type = 'super';
        } else if ($user_type == 'Super Master') {
            $list_user_type = 'agent';
        } else if ($user_type == 'Master') {
            $list_user_type = 'client';
        }

        $minusArr = array();
        $plusArr = array();
        $user_type = $user->user_type;
        $parent_user_type = $user->user_type;

        $user_name = $user->name;

        if ($user->master_id == 0) {
            $parent_name = '';
            $parent_user_name = '';
        } else {
            $master_id = $user->master_id;
            $master_user = $this->User_model->getUserById($master_id);
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;
        }

        $users = array();

        $users = $this->User_model->getInnerUserById($user_id);

        $parent_total_settle_amount = $this->Ledger_model->get_total_settlement($user->user_id, 'Y');
        $parentBettingArr = array(
            'user_id' => $user->user_id,
            'user_name' => $parent_user_name,
            'name' => $parent_name,
            'amount' => 0,
            'master_comission' => 0,
            'partnership' => 0,
            'type' => 'Parent',
            'parent_comission' => 0,
        );



        if (!empty($users)) {
            foreach ($users as $user) {

                // if ($user->user_type == 'User') {
                //     $total_settle_amount = $this->Ledger_model->get_total_settlement_for_user($user->user_id, 'N', $user->user_type);
                // } else {
                //     $total_settle_amount = $this->Ledger_model->count_supers_total_settlement($user->user_id);
                // }

                $total_settle_amount = get_total_settlement($user->user_id);

                if (!empty($total_settle_amount)) {
                    $total_settle_amount = $total_settle_amount['amount'];
                }

                $bettingArr = array(
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'name' => $user->name,
                    'amount' => $total_settle_amount,
                    'master_comission' => 0,
                    'partnership' => 0,
                    'type' => $user->user_type,
                    'parent_comission' => 0,
                );


                if ($total_settle_amount > 0) {
                    array_push($plusArr, $bettingArr);
                } else {
                    array_push($minusArr, $bettingArr);
                }
            }
        }



        if ($parentBettingArr['amount'] < 0) {
            $parentBettingArr['amount'] -= ($parent_total_settle_amount);
        } else {
            $parentBettingArr['amount'] += ($parent_total_settle_amount);
        }




        //Cash forom and Cash to (Donwline and upline)
        $parentBettingArr['amount'] =  ($parentBettingArr['amount']);

        if ($parent_user_type == 'Super Admin') {
            $cash_from_clients = $this->Ledger_model->cash_from_client_for_masters($user_id);
        } else {
            $cash_from_clients = $this->Ledger_model->cash_from_client($user_id);
        }


        $cash_from_upline = $this->Ledger_model->cash_from_upline($user_id);
        //Cash forom and Cash to (Donwline and upline)



        //Profit & Loss (self and upline)

        $upline_profit_and_loss_arr = get_upline_sharing($user_id);
        if (!empty($upline_profit_and_loss_arr)) {
            $upline_profit_and_loss = $upline_profit_and_loss_arr['amount'];
        }

        $self_profit_and_loss_arr = get_my_sharing($user_id);

        if (!empty($self_profit_and_loss_arr)) {
            $self_profit_and_loss = $self_profit_and_loss_arr['amount'];
        }


        $dataArray['minus_acc'] = $minusArr;
        $dataArray['plus_acc'] = $plusArr;
        $dataArray['parent_name'] = $parent_name;
        $dataArray['user_type'] = $user_type;
        $dataArray['user_id'] = $user_id;
        $dataArray['user_name'] = $user_name;
        $dataArray['cash_from_clients'] = $cash_from_clients;
        $dataArray['cash_from_upline'] = $cash_from_upline;
        $dataArray['self_profit_and_loss'] = $self_profit_and_loss;
        $dataArray['upline_profit_and_loss'] = $upline_profit_and_loss;


        $this->load->view('chip-summary', $dataArray);
    }

    public function myledgerold($sportid = null, $user_id = null)
    {

        // $user_id = get_user_id();
        // $user =  $this->User_model->getUserById($user_id);


        // if (!empty($user)) {
        //     if ($user->user_type == 'Master') {
        //         $usersDatas =  $this->User_model->getInnerUserByEventId(array(
        //             'user_id' => $user_id,
        //             'match_id' => $event_id
        //         ));


        //         if (!empty($usersDatas)) {
        //             foreach ($usersDatas as $key => $usersData) {



        //                 $usersDatas[$key]->master = array();
        //                 $usersDatas[$key]->super_master = array();
        //                 $usersDatas[$key]->hyper_super_master = array();
        //                 $usersDatas[$key]->admin = array();
        //                 $usersDatas[$key]->super_admin = array();

        //                 $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
        //                 $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

        //                 $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
        //                 $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


        //                 $get_user_partnership = $this->Betting_model->get_betting_info($usersData->user_id, $event_id);

        //                 $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



        //                 $user_match_comm = 0;

        //                 if ($user_match_pl < 0) {
        //                     $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
        //                 }

        //                 $usersDatas[$key]->user = array(
        //                     'match_pl' => $user_match_pl * -1,
        //                     'session_pl' => $user_session_pl * -1,
        //                     'match_comm' => $get_user_partnership->master_commission,
        //                     'sessional_commission' =>  $get_user_partnership->sessional_commission,
        //                 );

        //                 $usersDatas[$key]->master = array(
        //                     'partnership' => $get_master_partnership->partnership,
        //                     'match_comm' =>  $get_master_partnership->master_commission,
        //                     'sessional_commission' =>  $get_master_partnership->sessional_commission,
        //                 );
        //             }

        //             $user->users = $usersDatas;
        //         }
        //     }
        // }

        // $dataArray['reports'] = $user;



        // p($user);
        //////////exit
        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;


        $dataArray['pstatus'] = 'Settled';
        $reports = array();



        $reportsData = $this->Report_model->get_my_ledger_events_list($dataArray);

        p($reportsData);


        if (!empty($reportsData)) {
            foreach ($reportsData as $report) {
                // $report['partnership'] = 0;
                $marketId = $report['market_id'];
                $betting_type = strtolower($report['betting_type']);


                if (isset($reports[$report['match_id']])) {
                    if ($betting_type == 'fancy') {
                        $market_name = 'Fancy';
                    } else {
                        $market_name = $report['market_name'];
                    }

                    $p_l = 0;

                    if ($report['bet_result'] == 'Minus') {


                        $amt = $report['client_profit'] - (($report['client_profit']) * ($report['partnership'] / 100));

                        $p_l =  $reports[$report['match_id']]['p_l'] + $amt;
                    } else if ($report['bet_result'] == 'Plus') {

                        $amt = $report['client_loss'] - (($report['client_loss']) * ($report['partnership'] / 100));
                        $p_l = $reports[$report['match_id']]['p_l'] +  $amt * -1;
                    }


                    $reports[$report['match_id']] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'market_name' => $market_name,
                        'market_id' => $marketId,

                        'p_l' => $p_l,
                        'commission' => 0,
                        'created_at' => $report['created_at']
                    );
                } else {
                    if ($betting_type == 'fancy') {
                        $market_name = 'Fancy';
                    } else {
                        $market_name = $report['market_name'];
                    }


                    $p_l = 0;

                    if ($report['bet_result'] == 'Minus') {


                        $amt = $report['client_profit'] - (($report['client_profit']) * ($report['partnership'] / 100));

                        $p_l = $amt;
                    } else if ($report['bet_result'] == 'Plus') {
                        $amt = $report['client_loss'] - (($report['client_loss']) * ($report['partnership'] / 100));
                        $p_l = $amt * -1;
                    }


                    $reports[$report['match_id']] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'market_name' => $market_name,
                        'market_id' => $marketId,

                        'p_l' => $p_l,
                        'commission' => 0,
                        'created_at' => $report['created_at']
                    );
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

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

        $dataArray['profit_loss']  = $this->load->viewPartial('/my-ledger-list-html', $dataArray);
        $this->load->view('/my-ledger', $dataArray);
    }

    public function myledgerdata($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;


        $dataArray['pstatus'] = 'Settled';
        $reports = array();



        $reportsData = $this->Report_model->get_my_ledger_events_list($dataArray);
        $resultData = array();

        $ledgerData = $this->Ledger_model->get_ledger(array(
            'fltrselct' => 2,
            'user_id' => $user_id
        ));



        if ($user_type == 'Master') {


            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];
                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'market_name' => $report['market_name'],
                        'market_id' => $report['market_id'],
                        'user_type' => $user_type,
                        'commission' => 0,
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );


                    if (!empty($usersDatas)) {
                        foreach ($usersDatas as $key => $usersData) {



                            $usersDatas[$key]->master = array();
                            $usersDatas[$key]->super_master = array();
                            $usersDatas[$key]->hyper_super_master = array();
                            $usersDatas[$key]->admin = array();
                            $usersDatas[$key]->super_admin = array();

                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                            $user_match_comm = 0;
                            $user_session_comm = 0;


                            if ($user_match_pl < 0) {
                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                            }

                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                            if ($total_session_stake > 0) {
                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                            }

                            $total_pl = $user_match_pl + $user_session_pl;

                            $total_comm = $user_match_comm + $user_session_comm;

                            if ($total_pl < 0) {
                                $net_amt = ($total_pl + $total_comm);
                            } else {
                                $net_amt = ($total_pl + $total_comm);
                            }
                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                            $final_amt = $net_amt - $share_amt;


                            if ($final_amt < 0) {
                                $final_amt = $final_amt * -1;
                                $resultData[$event_id]['p_l'] += $final_amt;
                            } else {
                                $final_amt = $final_amt * -1;

                                $resultData[$event_id]['p_l'] += $final_amt;
                            }
                        }
                    }
                }
            }

            // p($resultData);
        } else if ($user_type == 'Super Master') {
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {



                    $event_id  = $report['match_id'];
                    $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );



                    if (!empty($mastersDatas)) {
                        foreach ($mastersDatas as $masterData) {
                            $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $masterData->user_id,
                                'match_id' => $report['match_id']
                            ));





                            if (!empty($usersDatas)) {
                                foreach ($usersDatas as $key => $usersData) {



                                    $usersDatas[$key]->master = array();
                                    $usersDatas[$key]->super_master = array();
                                    $usersDatas[$key]->hyper_super_master = array();
                                    $usersDatas[$key]->admin = array();
                                    $usersDatas[$key]->super_admin = array();

                                    $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);

                                    $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                    $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                    $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                    $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                    $user_match_comm = 0;
                                    $user_session_comm = 0;


                                    if ($user_match_pl < 0) {
                                        $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                    }

                                    $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                    if ($total_session_stake > 0) {
                                        $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                    }

                                    $total_pl = $user_match_pl + $user_session_pl;

                                    $total_comm = $user_match_comm + $user_session_comm;

                                    if ($total_pl < 0) {
                                        $net_amt = ($total_pl + $total_comm);
                                    } else {
                                        $net_amt = ($total_pl + $total_comm);
                                    }
                                    $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                    $final_amt = $net_amt - $share_amt;


                                    if ($final_amt < 0) {
                                        $final_amt = $final_amt * -1;
                                        $resultData[$event_id]['p_l'] += $final_amt;
                                    } else {
                                        $final_amt = $final_amt * -1;

                                        $resultData[$event_id]['p_l'] += $final_amt;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];


                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );


                    $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    if (!empty($supersDatas)) {
                        foreach ($supersDatas as $superData) {

                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $superData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($mastersDatas)) {
                                foreach ($mastersDatas as $masterData) {
                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $masterData->user_id,
                                        'match_id' => $report['match_id']
                                    ));




                                    if (!empty($usersDatas)) {
                                        foreach ($usersDatas as $key => $usersData) {



                                            $usersDatas[$key]->master = array();
                                            $usersDatas[$key]->super_master = array();
                                            $usersDatas[$key]->hyper_super_master = array();
                                            $usersDatas[$key]->admin = array();
                                            $usersDatas[$key]->super_admin = array();

                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                            $user_match_comm = 0;
                                            $user_session_comm = 0;


                                            if ($user_match_pl < 0) {
                                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                            }


                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                            if ($total_session_stake > 0) {
                                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                            }


                                            // if($event_id == '30837295')
                                            // {
                                            //     p($total_session_stake);

                                            // }

                                            $total_pl = $user_match_pl + $user_session_pl;

                                            $total_comm = $user_match_comm + $user_session_comm;

                                            if ($total_pl < 0) {
                                                $net_amt = ($total_pl + $total_comm);
                                            } else {
                                                $net_amt = ($total_pl + $total_comm);
                                            }
                                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                            $final_amt = $net_amt - $share_amt;


                                            if ($final_amt < 0) {
                                                $final_amt = $final_amt * -1;
                                                $resultData[$event_id]['p_l'] += $final_amt;
                                            } else {
                                                $final_amt = $final_amt * -1;

                                                $resultData[$event_id]['p_l'] += $final_amt;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {


            $dataArray['user_id']  = $user_id;
            $dataArray['pstatus'] = 'Settled';


            $reportsData = $this->Report_model->get_my_ledger_events_list($dataArray);

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];
                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );


                    $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    if (!empty($adminsDatas)) {
                        foreach ($adminsDatas as $adminData) {


                            $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $adminData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($supersDatas)) {
                                foreach ($supersDatas as $superData) {

                                    $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $superData->user_id,
                                        'match_id' => $report['match_id']
                                    ));


                                    if (!empty($mastersDatas)) {
                                        foreach ($mastersDatas as $masterData) {
                                            $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $masterData->user_id,
                                                'match_id' => $report['match_id']
                                            ));




                                            if (!empty($usersDatas)) {
                                                foreach ($usersDatas as $key => $usersData) {



                                                    $usersDatas[$key]->master = array();
                                                    $usersDatas[$key]->super_master = array();
                                                    $usersDatas[$key]->hyper_super_master = array();
                                                    $usersDatas[$key]->admin = array();
                                                    $usersDatas[$key]->super_admin = array();

                                                    $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                    $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                    $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                    $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                    $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                    $user_match_comm = 0;
                                                    $user_session_comm = 0;


                                                    if ($user_match_pl < 0) {
                                                        $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                    }

                                                    $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                    if ($total_session_stake > 0) {
                                                        $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                    }


                                                    $total_pl = $user_match_pl + $user_session_pl;

                                                    $total_comm = $user_match_comm + $user_session_comm;

                                                    if ($total_pl < 0) {
                                                        $net_amt = ($total_pl + $total_comm);
                                                    } else {
                                                        $net_amt = ($total_pl + $total_comm);
                                                    }
                                                    $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                    $final_amt = $net_amt - $share_amt;


                                                    if ($final_amt < 0) {
                                                        $final_amt = $final_amt * -1;
                                                        $resultData[$event_id]['p_l'] += $final_amt;
                                                    } else {
                                                        $final_amt = $final_amt * -1;

                                                        $resultData[$event_id]['p_l'] += $final_amt;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Admin') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];
                    $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));

                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );




                    if (!empty($adminsDatas)) {
                        foreach ($adminsDatas as $adminData) {

                            $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $adminData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($hypersDatas)) {
                                foreach ($hypersDatas as $hyperData) {


                                    $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $hyperData->user_id,
                                        'match_id' => $report['match_id']
                                    ));


                                    if (!empty($supersDatas)) {
                                        foreach ($supersDatas as $superData) {

                                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $superData->user_id,
                                                'match_id' => $report['match_id']
                                            ));


                                            if (!empty($mastersDatas)) {
                                                foreach ($mastersDatas as $masterData) {
                                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                        'user_id' => $masterData->user_id,
                                                        'match_id' => $report['match_id']
                                                    ));





                                                    if (!empty($usersDatas)) {
                                                        foreach ($usersDatas as $key => $usersData) {



                                                            $usersDatas[$key]->master = array();
                                                            $usersDatas[$key]->super_master = array();
                                                            $usersDatas[$key]->hyper_super_master = array();
                                                            $usersDatas[$key]->admin = array();
                                                            $usersDatas[$key]->super_admin = array();

                                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                            $user_match_comm = 0;
                                                            $user_session_comm = 0;


                                                            if ($user_match_pl < 0) {
                                                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                            }

                                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                            if ($total_session_stake > 0) {
                                                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                            }

                                                            $total_pl = $user_match_pl + $user_session_pl;

                                                            $total_comm = $user_match_comm + $user_session_comm;

                                                            if ($total_pl < 0) {
                                                                $net_amt = ($total_pl + $total_comm);
                                                            } else {
                                                                $net_amt = ($total_pl + $total_comm);
                                                            }
                                                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                            $final_amt = $net_amt - $share_amt;


                                                            if ($final_amt < 0) {
                                                                $final_amt = $final_amt * -1;
                                                                $resultData[$event_id]['p_l'] += $final_amt;
                                                            } else {
                                                                $final_amt = $final_amt * -1;

                                                                $resultData[$event_id]['p_l'] += $final_amt;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $reports = array_merge($reports, $ledgerData);
        $reports = array_merge($reports, $resultData);


        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

        $json_data = json_encode($reports);
        $file_name = get_user_id() . '_my_ledger.json';

        $file_path = './json_data/' . $file_name;

        write_chipsummary_data($file_path, $json_data);


        // $dataArray['profit_loss']  = $this->load->viewPartial('/my-ledger-list-html', $dataArray);
        // $this->load->view('/my-ledger', $dataArray);
    }

    public function myledger($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }






        $reports = array();


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

        $file_name = get_user_id() . '_my_ledger.json';

        $file_path = './json_data/' . $file_name;

        $reports = json_decode(read_chipsummary_data($file_path), true);

        $dataArray['reports'] = $reports;

        $dataArray['profit_loss']  = $this->load->viewPartial('/my-ledger-list-html', $dataArray);
        $this->load->view('/my-ledger', $dataArray);
    }

    public function myledgerx($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;


        $dataArray['pstatus'] = 'Settled';
        $reports = array();



        $reportsData = $this->Report_model->get_my_ledger_events_list($dataArray);
        $resultData = array();




        if ($user_type == 'Master') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {

                    // i


                    $event_id  = $report['match_id'];


                    // if($event_id != '30849966')
                    // {
                    //     continue;
                    // }

                    if (!$resultData[$event_id]) {
                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );
                    }


                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));




                    if (!empty($usersDatas)) {
                        foreach ($usersDatas as $key => $usersData) {



                            $usersDatas[$key]->master = array();
                            $usersDatas[$key]->super_master = array();
                            $usersDatas[$key]->hyper_super_master = array();
                            $usersDatas[$key]->admin = array();
                            $usersDatas[$key]->super_admin = array();

                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                            // if($event_id == '30857685')
                            // {
                            //     p($user_match_pl,0);
                            // }

                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);






                            $user_match_comm = 0;
                            $user_session_comm = 0;


                            if ($user_match_pl < 0) {
                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                            }


                            // p()
                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                            if ($total_session_stake > 0) {
                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                            }

                            $total_pl = $user_match_pl + $user_session_pl;

                            $total_comm = $user_match_comm + $user_session_comm;

                            if ($total_pl < 0) {
                                $net_amt = ($total_pl + $total_comm);
                            } else {
                                $net_amt = ($total_pl + $total_comm);
                            }
                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                            $final_amt = $net_amt - $share_amt;


                            if ($final_amt < 0) {
                                $final_amt = $final_amt * -1;
                                $resultData[$event_id]['p_l'] += $final_amt;
                            } else {
                                $final_amt = $final_amt * -1;

                                $resultData[$event_id]['p_l'] += $final_amt;
                            }
                        }
                    }
                }
            }


            // p($resultData);
        } else if ($user_type == 'Super Master') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];


                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );


                    $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    if (!empty($mastersDatas)) {
                        foreach ($mastersDatas as $masterData) {
                            $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $masterData->user_id,
                                'match_id' => $report['match_id']
                            ));



                            if (!empty($usersDatas)) {
                                foreach ($usersDatas as $key => $usersData) {



                                    $usersDatas[$key]->master = array();
                                    $usersDatas[$key]->super_master = array();
                                    $usersDatas[$key]->hyper_super_master = array();
                                    $usersDatas[$key]->admin = array();
                                    $usersDatas[$key]->super_admin = array();

                                    $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                    $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                    $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                    $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                    $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                    $user_match_comm = 0;
                                    $user_session_comm = 0;


                                    if ($user_match_pl < 0) {
                                        $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                    }


                                    $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                    if ($total_session_stake > 0) {
                                        $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                    }


                                    $total_pl = $user_match_pl + $user_session_pl;

                                    $total_comm = $user_match_comm + $user_session_comm;

                                    if ($total_pl < 0) {
                                        $net_amt = ($total_pl + $total_comm);
                                    } else {
                                        $net_amt = ($total_pl + $total_comm);
                                    }
                                    $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                    $final_amt = $net_amt - $share_amt;


                                    if ($final_amt < 0) {
                                        $final_amt = $final_amt * -1;
                                        $resultData[$event_id]['p_l'] += $final_amt;
                                    } else {
                                        $final_amt = $final_amt * -1;

                                        $resultData[$event_id]['p_l'] += $final_amt;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];

                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );

                    $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    if (!empty($supersDatas)) {
                        foreach ($supersDatas as $superData) {

                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $superData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($mastersDatas)) {
                                foreach ($mastersDatas as $masterData) {
                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $masterData->user_id,
                                        'match_id' => $report['match_id']
                                    ));





                                    if (!empty($usersDatas)) {
                                        foreach ($usersDatas as $key => $usersData) {



                                            $usersDatas[$key]->master = array();
                                            $usersDatas[$key]->super_master = array();
                                            $usersDatas[$key]->hyper_super_master = array();
                                            $usersDatas[$key]->admin = array();
                                            $usersDatas[$key]->super_admin = array();

                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                            $user_match_comm = 0;
                                            $user_session_comm = 0;


                                            if ($user_match_pl < 0) {
                                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                            }

                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                            if ($total_session_stake > 0) {
                                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                            }

                                            $total_pl = $user_match_pl + $user_session_pl;

                                            $total_comm = $user_match_comm + $user_session_comm;

                                            if ($total_pl < 0) {
                                                $net_amt = ($total_pl + $total_comm);
                                            } else {
                                                $net_amt = ($total_pl + $total_comm);
                                            }
                                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                            $final_amt = $net_amt - $share_amt;


                                            if ($final_amt < 0) {
                                                $final_amt = $final_amt * -1;
                                                $resultData[$event_id]['p_l'] += $final_amt;
                                            } else {
                                                $final_amt = $final_amt * -1;

                                                $resultData[$event_id]['p_l'] += $final_amt;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {


            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {

                    $event_id  = $report['match_id'];

                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );
                    $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    if (!empty($adminsDatas)) {
                        foreach ($adminsDatas as $adminData) {


                            $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $adminData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($supersDatas)) {
                                foreach ($supersDatas as $superData) {

                                    $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $superData->user_id,
                                        'match_id' => $report['match_id']
                                    ));


                                    if (!empty($mastersDatas)) {
                                        foreach ($mastersDatas as $masterData) {
                                            $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $masterData->user_id,
                                                'match_id' => $report['match_id']
                                            ));




                                            if (!empty($usersDatas)) {
                                                foreach ($usersDatas as $key => $usersData) {


                                                    $usersDatas[$key]->master = array();
                                                    $usersDatas[$key]->super_master = array();
                                                    $usersDatas[$key]->hyper_super_master = array();
                                                    $usersDatas[$key]->admin = array();
                                                    $usersDatas[$key]->super_admin = array();

                                                    $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                    $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                    $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                    $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                    $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                    $user_match_comm = 0;
                                                    $user_session_comm = 0;


                                                    if ($user_match_pl < 0) {
                                                        $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                    }

                                                    $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                    if ($total_session_stake > 0) {
                                                        $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                    }


                                                    //  


                                                    $total_pl = $user_match_pl + $user_session_pl;

                                                    $total_comm = $user_match_comm + $user_session_comm;

                                                    if ($total_pl < 0) {
                                                        $net_amt = ($total_pl + $total_comm);
                                                    } else {
                                                        $net_amt = ($total_pl + $total_comm);
                                                    }





                                                    // p($net_amt);
                                                    $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                    $final_amt = $net_amt - $share_amt;


                                                    if ($final_amt < 0) {
                                                        $final_amt = $final_amt * -1;
                                                        $resultData[$event_id]['p_l'] = $resultData[$event_id]['p_l'] + $final_amt;
                                                    } else {
                                                        $final_amt = $final_amt * -1;

                                                        $resultData[$event_id]['p_l'] += $final_amt;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Admin') {

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $event_id  = $report['match_id'];
                    $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                        'user_id' => $user_id,
                        'match_id' => $report['match_id']
                    ));


                    $resultData[$event_id] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'created_at' => $report['created_at'],
                        'p_l' => 0,
                    );



                    if (!empty($adminsDatas)) {
                        foreach ($adminsDatas as $adminData) {

                            $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $adminData->user_id,
                                'match_id' => $report['match_id']
                            ));


                            if (!empty($hypersDatas)) {
                                foreach ($hypersDatas as $hyperData) {


                                    $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $hyperData->user_id,
                                        'match_id' => $report['match_id']
                                    ));


                                    if (!empty($supersDatas)) {
                                        foreach ($supersDatas as $superData) {

                                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $superData->user_id,
                                                'match_id' => $report['match_id']
                                            ));


                                            if (!empty($mastersDatas)) {
                                                foreach ($mastersDatas as $masterData) {
                                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                        'user_id' => $masterData->user_id,
                                                        'match_id' => $report['match_id']
                                                    ));




                                                    if (!empty($usersDatas)) {
                                                        foreach ($usersDatas as $key => $usersData) {



                                                            $usersDatas[$key]->master = array();
                                                            $usersDatas[$key]->super_master = array();
                                                            $usersDatas[$key]->hyper_super_master = array();
                                                            $usersDatas[$key]->admin = array();
                                                            $usersDatas[$key]->super_admin = array();

                                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                            $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                            $user_match_comm = 0;
                                                            $user_session_comm = 0;


                                                            if ($user_match_pl < 0) {
                                                                $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                            }

                                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                            if ($total_session_stake > 0) {
                                                                $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                            }

                                                            $total_pl = $user_match_pl + $user_session_pl;

                                                            $total_comm = $user_match_comm + $user_session_comm;

                                                            if ($total_pl < 0) {
                                                                $net_amt = ($total_pl + $total_comm);
                                                            } else {
                                                                $net_amt = ($total_pl + $total_comm);
                                                            }
                                                            $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                            $final_amt = $net_amt - $share_amt;


                                                            if ($final_amt < 0) {
                                                                $final_amt = $final_amt * -1;
                                                                $resultData[$event_id]['p_l'] += $final_amt;
                                                            } else {
                                                                $final_amt = $final_amt * -1;

                                                                $resultData[$event_id]['p_l'] += $final_amt;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        array_multisort(array_map('strtotime', array_column($resultData, 'created_at')), SORT_DESC, $resultData);
        $dataArray['reports'] = $resultData;

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

        $dataArray['profit_loss']  = $this->load->viewPartial('/my-ledger-list-html', $dataArray);
        $this->load->view('/my-ledger', $dataArray);
    }



    public function getClientTransaction()
    {


        $this->load->library('Datatable');

        $user_id = $this->input->post('user_id');

        $dataArray['user_id']  = $user_id;
        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);

        $dataArray['pstatus'] = 'Settled';
        $reports = array();





        $ledgerData = $this->Ledger_model->get_ledger(array(
            'fltrselct' => 2,
            'user_id' => $user_id
        ));






        if ($user_detail->user_type == 'User') {
            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $amt = $report['client_loss'] * -1;
                            $p_l =  $reports[$report['match_id']]['p_l'] + $amt;
                        } else if ($report['bet_result'] == 'Plus') {

                            $amt = $report['client_profit'];
                            $p_l = $reports[$report['match_id']]['p_l'] +  $amt;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'user_type' => $user_detail->user_type,
                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;



                        if ($report['bet_result'] == 'Minus') {


                            $amt = $report['client_loss'] * -1;

                            $p_l = $amt;
                        } else if ($report['bet_result'] == 'Plus') {
                            $amt = $report['client_profit'];
                            $p_l = $amt;
                        }


                        $getCommssion = $this->Ledger_model->get_commission_amt_by_event_id(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));

                        // if($report['match_id'] == '30920971')
                        // {
                        //     p($p_l);
                        // }

                        if (!empty($getCommssion)) {

                            if ($p_l < 0) {
                                $p_l =  $p_l + $getCommssion->total_commission;
                            } else {
                                $p_l =  $p_l + $getCommssion->total_commission;
                            }
                        }




                        // p($getCommssion);

                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'user_type' => $user_detail->user_type,

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }


                $reports = array_merge($reports, $ledgerData);
            }
        } else {

            // $reportsData = $this->Betting_model->get_master_transaction_details($user_id);


            // if (!empty($reportsData)) {

            //     foreach ($reportsData as $report) {


            //         $reports[$report['match_id']] = array(
            //             'match_id' => $report['match_id'],
            //             'event_name' => $report['event_name'],
            //             // 'market_name' => $market_name,
            //             // 'market_id' => $marketId,
            //             'user_type' => $user_detail->user_type,

            //             'p_l' => $report['profit'],
            //             'commission' => 0,
            //             'created_at' => ''
            //         );
            //     }
            // }    


            // p($reports);

            $user_type = $user_detail->user_type;

            $resultData = array();
            $reportsData = $this->Report_model->get_my_ledger_events_list($dataArray);


            if ($user_type == 'Master') {
                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $event_id  = $report['match_id'];
                        $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));


                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $report['market_name'],
                            'market_id' => $report['market_id'],
                            'user_type' => $user_type,
                            'commission' => 0,
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );


                        if (!empty($usersDatas)) {
                            foreach ($usersDatas as $key => $usersData) {



                                $usersDatas[$key]->master = array();
                                $usersDatas[$key]->super_master = array();
                                $usersDatas[$key]->hyper_super_master = array();
                                $usersDatas[$key]->admin = array();
                                $usersDatas[$key]->super_admin = array();

                                $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                $user_match_comm = 0;
                                $user_session_comm = 0;


                                if ($user_match_pl < 0) {
                                    $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                }

                                $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                if ($total_session_stake > 0) {
                                    $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                }

                                $total_pl = $user_match_pl + $user_session_pl;

                                $total_comm = $user_match_comm + $user_session_comm;

                                if ($total_pl < 0) {
                                    $net_amt = ($total_pl + $total_comm);
                                } else {
                                    $net_amt = ($total_pl + $total_comm);
                                }
                                $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                $final_amt = $net_amt - $share_amt;


                                if ($final_amt < 0) {
                                    $final_amt = $final_amt * -1;
                                    $resultData[$event_id]['p_l'] += $final_amt;
                                } else {
                                    $final_amt = $final_amt * -1;

                                    $resultData[$event_id]['p_l'] += $final_amt;
                                }
                            }
                        }
                    }
                }
            } else if ($user_type == 'Super Master') {

                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $event_id  = $report['match_id'];
                        $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));

                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );


                        if (!empty($mastersDatas)) {
                            foreach ($mastersDatas as $masterData) {
                                $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                    'user_id' => $masterData->user_id,
                                    'match_id' => $report['match_id']
                                ));





                                if (!empty($usersDatas)) {
                                    foreach ($usersDatas as $key => $usersData) {



                                        $usersDatas[$key]->master = array();
                                        $usersDatas[$key]->super_master = array();
                                        $usersDatas[$key]->hyper_super_master = array();
                                        $usersDatas[$key]->admin = array();
                                        $usersDatas[$key]->super_admin = array();

                                        $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                        $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                        $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                        $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                        $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                        $user_match_comm = 0;
                                        $user_session_comm = 0;


                                        if ($user_match_pl < 0) {
                                            $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                        }

                                        $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                        if ($total_session_stake > 0) {
                                            $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                        }

                                        $total_pl = $user_match_pl + $user_session_pl;

                                        $total_comm = $user_match_comm + $user_session_comm;

                                        if ($total_pl < 0) {
                                            $net_amt = ($total_pl + $total_comm);
                                        } else {
                                            $net_amt = ($total_pl + $total_comm);
                                        }
                                        $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                        $final_amt = $net_amt - $share_amt;


                                        if ($final_amt < 0) {
                                            $final_amt = $final_amt * -1;
                                            $resultData[$event_id]['p_l'] += $final_amt;
                                        } else {
                                            $final_amt = $final_amt * -1;

                                            $resultData[$event_id]['p_l'] += $final_amt;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else if ($user_type == 'Hyper Super Master') {

                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $event_id  = $report['match_id'];

                        $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));

                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );


                        if (!empty($supersDatas)) {
                            foreach ($supersDatas as $superData) {

                                $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                    'user_id' => $superData->user_id,
                                    'match_id' => $report['match_id']
                                ));


                                if (!empty($mastersDatas)) {
                                    foreach ($mastersDatas as $masterData) {
                                        $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                            'user_id' => $masterData->user_id,
                                            'match_id' => $report['match_id']
                                        ));





                                        if (!empty($usersDatas)) {
                                            foreach ($usersDatas as $key => $usersData) {



                                                $usersDatas[$key]->master = array();
                                                $usersDatas[$key]->super_master = array();
                                                $usersDatas[$key]->hyper_super_master = array();
                                                $usersDatas[$key]->admin = array();
                                                $usersDatas[$key]->super_admin = array();

                                                $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                $user_match_comm = 0;
                                                $user_session_comm = 0;


                                                if ($user_match_pl < 0) {
                                                    $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                }


                                                $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                if ($total_session_stake > 0) {
                                                    $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                }


                                                // if($event_id == '30837295')
                                                // {
                                                //     p($total_session_stake);

                                                // }

                                                $total_pl = $user_match_pl + $user_session_pl;

                                                $total_comm = $user_match_comm + $user_session_comm;

                                                if ($total_pl < 0) {
                                                    $net_amt = ($total_pl + $total_comm);
                                                } else {
                                                    $net_amt = ($total_pl + $total_comm);
                                                }
                                                $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                $final_amt = $net_amt - $share_amt;


                                                if ($final_amt < 0) {
                                                    $final_amt = $final_amt * -1;
                                                    $resultData[$event_id]['p_l'] += $final_amt;
                                                } else {
                                                    $final_amt = $final_amt * -1;

                                                    $resultData[$event_id]['p_l'] += $final_amt;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else if ($user_type == 'Admin') {

                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $event_id  = $report['match_id'];


                        $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));

                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );


                        if (!empty($adminsDatas)) {
                            foreach ($adminsDatas as $adminData) {


                                $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                    'user_id' => $adminData->user_id,
                                    'match_id' => $report['match_id']
                                ));


                                if (!empty($supersDatas)) {
                                    foreach ($supersDatas as $superData) {

                                        $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                            'user_id' => $superData->user_id,
                                            'match_id' => $report['match_id']
                                        ));


                                        if (!empty($mastersDatas)) {
                                            foreach ($mastersDatas as $masterData) {
                                                $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                    'user_id' => $masterData->user_id,
                                                    'match_id' => $report['match_id']
                                                ));





                                                if (!empty($usersDatas)) {
                                                    foreach ($usersDatas as $key => $usersData) {



                                                        $usersDatas[$key]->master = array();
                                                        $usersDatas[$key]->super_master = array();
                                                        $usersDatas[$key]->hyper_super_master = array();
                                                        $usersDatas[$key]->admin = array();
                                                        $usersDatas[$key]->super_admin = array();

                                                        $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                        $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                        $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                        $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                        $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                        $user_match_comm = 0;
                                                        $user_session_comm = 0;


                                                        if ($user_match_pl < 0) {
                                                            $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                        }

                                                        $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                        if ($total_session_stake > 0) {
                                                            $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                        }


                                                        $total_pl = $user_match_pl + $user_session_pl;

                                                        $total_comm = $user_match_comm + $user_session_comm;

                                                        if ($total_pl < 0) {
                                                            $net_amt = ($total_pl + $total_comm);
                                                        } else {
                                                            $net_amt = ($total_pl + $total_comm);
                                                        }
                                                        $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                        $final_amt = $net_amt - $share_amt;


                                                        if ($final_amt < 0) {
                                                            $final_amt = $final_amt * -1;
                                                            $resultData[$event_id]['p_l'] += $final_amt;
                                                        } else {
                                                            $final_amt = $final_amt * -1;

                                                            $resultData[$event_id]['p_l'] += $final_amt;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else if ($user_type == 'Super Admin') {

                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $event_id  = $report['match_id'];
                        $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));


                        $resultData[$event_id] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'created_at' => $report['created_at'],
                            'p_l' => 0,
                        );




                        if (!empty($adminsDatas)) {
                            foreach ($adminsDatas as $adminData) {

                                $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
                                    'user_id' => $adminData->user_id,
                                    'match_id' => $report['match_id']
                                ));


                                if (!empty($hypersDatas)) {
                                    foreach ($hypersDatas as $hyperData) {


                                        $supersDatas =  $this->User_model->getInnerUserByEventId(array(
                                            'user_id' => $hyperData->user_id,
                                            'match_id' => $report['match_id']
                                        ));


                                        if (!empty($supersDatas)) {
                                            foreach ($supersDatas as $superData) {

                                                $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                    'user_id' => $superData->user_id,
                                                    'match_id' => $report['match_id']
                                                ));


                                                if (!empty($mastersDatas)) {
                                                    foreach ($mastersDatas as $masterData) {
                                                        $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                            'user_id' => $masterData->user_id,
                                                            'match_id' => $report['match_id']
                                                        ));




                                                        if (!empty($usersDatas)) {
                                                            foreach ($usersDatas as $key => $usersData) {



                                                                $usersDatas[$key]->master = array();
                                                                $usersDatas[$key]->super_master = array();
                                                                $usersDatas[$key]->hyper_super_master = array();
                                                                $usersDatas[$key]->admin = array();
                                                                $usersDatas[$key]->super_admin = array();

                                                                $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                                $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);


                                                                $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                                $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);




                                                                $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



                                                                $user_match_comm = 0;
                                                                $user_session_comm = 0;


                                                                if ($user_match_pl < 0) {
                                                                    $user_match_comm = abs($user_match_pl) * $get_master_partnership->master_commission / 100;
                                                                }

                                                                $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);
                                                                if ($total_session_stake > 0) {
                                                                    $user_session_comm = abs($total_session_stake) * $get_master_partnership->sessional_commission / 100;
                                                                }

                                                                $total_pl = $user_match_pl + $user_session_pl;

                                                                $total_comm = $user_match_comm + $user_session_comm;

                                                                if ($total_pl < 0) {
                                                                    $net_amt = ($total_pl + $total_comm);
                                                                } else {
                                                                    $net_amt = ($total_pl + $total_comm);
                                                                }
                                                                $share_amt = $net_amt *  $get_master_partnership->partnership / 100;



                                                                $final_amt = $net_amt - $share_amt;


                                                                if ($final_amt < 0) {
                                                                    $final_amt = $final_amt * -1;
                                                                    $resultData[$event_id]['p_l'] += $final_amt;
                                                                } else {
                                                                    $final_amt = $final_amt * -1;

                                                                    $resultData[$event_id]['p_l'] += $final_amt;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }



            $reports = array_merge($reports, $ledgerData);

            $reports = array_merge($reports, $resultData);

            // p($reports);
        }


        // p($reports);

        // p($reports);
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

        $total_dena = 0;
        $total_lena = 0;

        $html = $this->load->viewPartial('/client-account-txn-html', $dataArray);

        echo json_encode($html);
    }


    public function addsettlementNew()
    {

        $chips = $this->input->post('chips');
        $narration = $this->input->post('narration');
        $userId = $this->input->post('userId');
        $CrDr = $this->input->post('CrDr');
        $user_detail = $this->User_model->getUserById($userId);


        $masterId =  $user_detail->master_id;

        $master_detail = $this->User_model->getUserById($masterId);


        $user_chip = count_total_balance($userId);
        $master_chip = count_total_balance($masterId);

        $user_naration = '';
        $master_naration = '';
        if ($CrDr == 'DIYA') {
            $user_new_chip = $user_chip - $chips;
            $master_new_chip = $master_chip + $chips;
            $user_naration = 'Cash Received By Parent';
            $master_naration = 'Cash Paid to ' . $user_detail->user_name;

            if ($user_chip < $chips) {
                echo json_encode(array('success' => false, 'message' => 'Insufficient balance!!'));
                exit;
            }
        } else {

            if ($master_chip < $chips) {
                echo json_encode(array('success' => false, 'message' => 'Insufficient balance!!'));
                exit;
            }
            $user_new_chip = $user_chip + $chips;
            $master_new_chip = $master_chip - $chips;
            $master_naration = 'Cash Received By ' . $user_detail->user_name;
            $user_naration = 'Cash Paid to Parent';
        }


        $settlement_ref_id = rand(10, 100) . date('dmyhis');


        $dataArray = array(

            'settlemment_ref_id' => $settlement_ref_id,
            'user_id' => $userId,
            'remarks' => $user_naration,
            'transaction_type' => $CrDr == 'DIYA' ? 'debit' : 'credit',
            'amount' => $chips,
            'user_remarks' => $narration,

            'balance' =>  $user_new_chip,
            'type' =>  'Settlement',
            'role' => 'Parent',
            'user_name' => $user_detail->user_name,
            'done_by' => get_user_name()


        );

        $ledger_id  = $this->Ledger_model->addLedger($dataArray);


        $dataArray = array(
            'settlemment_ref_id' => $settlement_ref_id,

            'user_id' => $masterId,
            'remarks' => $master_naration,
            'user_remarks' => $narration,
            'transaction_type' => $CrDr == 'DIYA' ? 'credit' : 'debit',
            'amount' => $chips,
            'balance' =>  $master_new_chip,
            'type' =>  'Settlement',
            'user_name' => $user_detail->user_name,
            'done_by' => get_user_name()
        );

        $ledger_id  = $this->Ledger_model->addLedger($dataArray);


        $data = array(
            'user_id' => $userId,
            'is_balance_update' =>  'Yes',
            'is_exposure_update' =>  'Yes',
            'is_winnings_update' =>  'Yes',
        );
        $user_id = $this->User_model->addUser($data);



        $data = array(
            'user_id' => $masterId,
            'is_balance_update' =>  'Yes',
            'is_exposure_update' =>  'Yes',
            'is_winnings_update' =>  'Yes',
        );
        $user_id = $this->User_model->addUser($data);

        if ($CrDr == 'LIYA') {
            $user_details = $this->User_model->getUserById($userId);
            if (!empty($user_details)) {
                $balance = $user_details->balance  - $chips;
                $data = array(
                    'user_id' => $userId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }



            $master_details = $this->User_model->getUserById($masterId);
            if (!empty($master_details)) {
                $balance = $master_details->balance  + $chips;
                $data = array(
                    'user_id' => $masterId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        } else {

            $user_details = $this->User_model->getUserById($userId);
            if (!empty($user_details)) {
                $balance = $user_details->balance  + $chips;
                $data = array(
                    'user_id' => $userId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }



            $master_details = $this->User_model->getUserById($masterId);
            if (!empty($master_details)) {
                $balance = $master_details->balance  - $chips;
                $data = array(
                    'user_id' => $masterId,
                    'is_balance_update' =>  'Yes',
                    'is_exposure_update' =>  'Yes',
                    'is_winnings_update' =>  'Yes',
                );
                $user_id = $this->User_model->addUser($data);
            }
        }


        if ($ledger_id) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    public function txnclient()
    {
        $this->load->library('Datatable');

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

        $users = array();
        $user_type = get_user_type();
        $user_id  = get_user_id();
        //SUPER MASTERS

        if ($user_type == 'Master') {
            $usersData = $this->User_model->getInnerUserById($user_id);
            $users = array_merge($users, $usersData);
        } else if ($user_type == 'Super Master') {
            $masters = $this->User_model->getInnerUserById($user_id);

            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $usersData = $this->User_model->getInnerUserById($master->user_id);

                    $users = array_merge($users, $usersData);
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            $supers = $this->User_model->getInnerUserById($user_id);

            if (!empty($supers)) {
                foreach ($supers as $super) {
                    $masters = $this->User_model->getInnerUserById($super->user_id);

                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $usersData = $this->User_model->getInnerUserById($master->user_id);

                            $users = array_merge($users, $usersData);
                        }
                    }
                }
            }

            $dataArray['users'] = $users;
        } else if ($user_type == 'Admin') {
            $hypers = $this->User_model->getInnerUserById($user_id);

            if (!empty($hypers)) {
                foreach ($hypers as $hyper) {
                    $supers = $this->User_model->getInnerUserById($hyper->user_id);

                    if (!empty($supers)) {
                        foreach ($supers as $super) {
                            $masters = $this->User_model->getInnerUserById($super->user_id);

                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $usersData = $this->User_model->getInnerUserById($master->user_id);

                                    $users = array_merge($users, $usersData);
                                }
                            }
                        }
                    }
                }
            }
            $dataArray['users'] = $users;
        } else if ($user_type == 'Super Admin') {
            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hypers = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hypers)) {
                        foreach ($hypers as $hyper) {
                            $supers = $this->User_model->getInnerUserById($hyper->user_id);

                            if (!empty($supers)) {
                                foreach ($supers as $super) {
                                    $masters = $this->User_model->getInnerUserById($super->user_id);

                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $usersData = $this->User_model->getInnerUserById($master->user_id);

                                            $users = array_merge($users, $usersData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $dataArray['users'] = $users;
        }



        $dataArray['users'] = $users;



        // p($dataArray);
        $this->load->view('/txn-client', $dataArray);
    }

    public function txnagent()
    {
        $this->load->library('Datatable');

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

        $users = array();
        $user_type = get_user_type();
        $user_id  = get_user_id();
        //SUPER MASTERS

        if ($user_type == 'Super Master') {
            $users = $this->User_model->getInnerUserById($user_id);
            $dataArray['users'] = $users;
        } else if ($user_type == 'Hyper Super Master') {
            $supers = $this->User_model->getInnerUserById($user_id);

            if (!empty($supers)) {
                foreach ($supers as $super) {
                    $masters = $this->User_model->getInnerUserById($super->user_id);

                    $users = array_merge($users, $masters);
                }
            }
            $dataArray['users'] = $users;
        } else if ($user_type == 'Admin') {
            $hypers = $this->User_model->getInnerUserById($user_id);

            if (!empty($hypers)) {
                foreach ($hypers as $hyper) {
                    $supers = $this->User_model->getInnerUserById($hyper->user_id);

                    if (!empty($supers)) {
                        foreach ($supers as $super) {
                            $masters = $this->User_model->getInnerUserById($super->user_id);

                            $users = array_merge($users, $masters);
                        }
                    }
                }
            }
            $dataArray['users'] = $users;
        } else if ($user_type == 'Super Admin') {
            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hypers = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hypers)) {
                        foreach ($hypers as $hyper) {
                            $supers = $this->User_model->getInnerUserById($hyper->user_id);

                            if (!empty($supers)) {
                                foreach ($supers as $super) {
                                    $masters = $this->User_model->getInnerUserById($super->user_id);

                                    $users = array_merge($users, $masters);
                                }
                            }
                        }
                    }
                }
            }
            $dataArray['users'] = $users;
        }


        // p($dataArray);
        $this->load->view('/txn-client', $dataArray);
    }

    public function txnsuper()
    {
        $this->load->library('Datatable');

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

        $users = array();
        $user_type = get_user_type();
        $user_id  = get_user_id();
        if ($user_type == 'Hyper Super Master') {
            $users = $this->User_model->getInnerUserById($user_id);
            $dataArray['users'] = $users;
        } else if ($user_type == 'Admin') {
            $supers = $this->User_model->getInnerUserById($user_id);

            if (!empty($supers)) {
                foreach ($supers as $super) {
                    $masters = $this->User_model->getInnerUserById($super->user_id);

                    $users = array_merge($users, $masters);
                }
            }
            $dataArray['users'] = $users;
        } else if ($user_type == 'Super Admin') {
            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hypers = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hypers)) {
                        foreach ($hypers as $hyper) {
                            $supers = $this->User_model->getInnerUserById($hyper->user_id);

                            if (!empty($supers)) {
                                foreach ($supers as $super) {
                                    $supers = $this->User_model->getInnerUserById($hyper->user_id);
                                }
                            }
                            $users = array_merge($users, $supers);
                        }
                    }
                }
            }
            $dataArray['users'] = $users;
        }
        $this->load->view('/txn-client', $dataArray);
    }

    public function txnmaster()
    {
        $this->load->library('Datatable');

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

        $users = array();
        $user_type = get_user_type();
        $user_id  = get_user_id();
        //SUPER MASTERS

        if ($user_type == 'Admin') {
            $users = $this->User_model->getInnerUserById($user_id);
            $dataArray['users'] = $users;
        } else if ($user_type == 'Super Admin') {
            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hypers = $this->User_model->getInnerUserById($admin->user_id);

                    // if (!empty($hypers)) {
                    //     foreach ($hypers as $hyper) {
                    //         $supers = $this->User_model->getInnerUserById($hyper->user_id);

                    $users = array_merge($users, $hypers);
                    //     }
                    // }
                }
            }
            $dataArray['users'] = $users;
        }


        // p($dataArray);
        $this->load->view('/txn-client', $dataArray);
    }

    public function txnsba()
    {
        $this->load->library('Datatable');

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

        $users = array();
        $user_type = get_user_type();
        $user_id  = get_user_id();
        //SUPER MASTERS

        if ($user_type == 'Super Admin') {
            $users = $this->User_model->getInnerUserById($user_id);
            $dataArray['users'] = $users;
        }


        // p($dataArray);
        $this->load->view('/txn-client', $dataArray);
    }


    public function sportsdetails($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;


        if ($user_type == 'Master') {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );

                        $comm_pl = 0;
                        $sessional_commission = 2;

                        if ($betting_type == 'fancy') {
                            $tmp_comm_value =  abs($p_l) *  $sessional_commission / 100;
                        }
                        $comm_pl =  $reports[$report['match_id']]['comm_pl'] + $tmp_comm_value;
                        $reports[$report['match_id']]['comm_pl'] =  $comm_pl;
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );

                        $comm_pl = 0;
                        $sessional_commission = 2;

                        if ($betting_type == 'fancy') {
                            $tmp_comm_value =  abs($p_l) *  $sessional_commission / 100;
                        }
                        $comm_pl =  $reports[$report['match_id']]['comm_pl'] + $tmp_comm_value;
                        $reports[$report['match_id']]['comm_pl'] =  $comm_pl;
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);

            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],
                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['loss'] * -1;
                        }


                        $result_name = '';


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],
                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }


            // p($reportsData);
        } else if ($user_type == 'Super Admin') {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }
        } else {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $reportsData = $this->Report_model->get_bet_history_bettings_list($dataArray);



            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);


                    if (isset($reports[$report['match_id']])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Plus') {
                            $p_l =  $reports[$report['match_id']]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Minus') {
                            $p_l = $reports[$report['match_id']]['p_l'] +  $report['loss'] * -1;
                        }


                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    } else {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }


                        $p_l = 0;

                        if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Minus') {
                            $p_l = $report['loss'] * -1;
                        }

                        $getCommssion = $this->Ledger_model->get_commission_amt_by_event_id(array(
                            'user_id' => $user_id,
                            'match_id' => $report['match_id']
                        ));



                        if (!empty($getCommssion)) {
                            $p_l += $getCommssion->total_commission;
                        }
                        // p($report);
                        $reports[$report['match_id']] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'result_name' => $report['result_name'],

                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

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

        $dataArray['profit_loss']  = $this->load->viewPartial('/sports-details-list-html', $dataArray);
        $this->load->view('/sports-details', $dataArray);
    }


    public function agentMatchSessionPL($event_id)
    {
        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);



        if (!empty($user)) {
            if ($user->user_type == 'Master') {







                $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));



                if (!empty($usersDatas)) {
                    foreach ($usersDatas as $key => $usersData) {



                        $usersDatas[$key]->master = array();
                        $usersDatas[$key]->super_master = array();
                        $usersDatas[$key]->hyper_super_master = array();
                        $usersDatas[$key]->admin = array();
                        $usersDatas[$key]->super_admin = array();

                        $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                        $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                        $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                        $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);



                        $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);


                        $get_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);
                        $user_match_comm = 0;

                        if ($user_match_pl < 0) {
                            $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                        }

                        $usersDatas[$key]->user = array(
                            'match_pl' => $user_match_pl * -1,
                            'session_pl' => $user_session_pl * -1,
                            'user_match_comm' => $event->event_type == 4 ?  $user_match_comm : 0,
                            'user_session_comm' => $event->event_type == 4 ?  $user_session_comm : 0,
                            'total_session_stake' => $total_session_stake
                        );

                        $usersDatas[$key]->master = array(
                            'partnership' => $get_master_partnership->partnership,
                            'match_comm' =>  $event->event_type == 4 ? $get_master_partnership->master_commission : 0,
                            'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,

                        );






                        $user->users =  $usersDatas;
                    }
                }
            }
        }

        $dataArray['reports'] = $user;
        $dataArray['event'] = $event;


        $this->load->view('/agent-match-session-pl', $dataArray);
    }

    public function masterMatchSessionPL($event_id)
    {
        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);


        if (!empty($user)) {
            if ($user->user_type == 'Super Master') {
                $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));

                $user->masters = $mastersDatas;

                if (!empty($user->masters)) {
                    foreach ($user->masters as $masterKey => $master) {
                        $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $master->user_id,
                            'match_id' => $event_id
                        ));


                        if (!empty($usersDatas)) {
                            foreach ($usersDatas as $key => $usersData) {



                                $usersDatas[$key]->master = array();
                                $usersDatas[$key]->super_master = array();
                                $usersDatas[$key]->hyper_super_master = array();
                                $usersDatas[$key]->admin = array();
                                $usersDatas[$key]->super_admin = array();

                                $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                                $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


                                $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);
                                $get_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);




                                $user_match_comm = 0;

                                if ($user_match_pl < 0) {
                                    $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                                }

                                $usersDatas[$key]->user = array(
                                    'match_pl' => $user_match_pl * -1,
                                    'session_pl' => $user_session_pl * -1,
                                    'user_match_comm' => $event->event_type == 4 ?  $user_match_comm : 0,
                                    'user_session_comm' => $event->event_type == 4 ?  $user_session_comm : 0,
                                );

                                $usersDatas[$key]->master = array(
                                    'partnership' => $get_master_partnership->partnership,
                                    'match_comm' =>  $event->event_type == 4 ?  $get_master_partnership->master_commission : 0,
                                    'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,
                                );


                                $usersDatas[$key]->super_master = array(
                                    'partnership' => $get_super_master_partnership->partnership,

                                );
                            }

                            $user->masters[$masterKey]->users = $usersDatas;
                        }
                    }
                }
            }
        }


        $dataArray['reports'] = $user;

        // p($usersDatas);
        $this->load->view('/master-match-session-pl', $dataArray);
    }

    public function superMatchSessionPL($event_id)
    {


        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);



        if (!empty($user)) {
            if ($user->user_type == 'Super Master') {



                $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));

                $user->masters = $mastersDatas;

                if (!empty($user->masters)) {
                    $masters =  $user->masters;
                    foreach ($masters as $masterKey => $master) {




                        $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $master->user_id,
                            'match_id' => $event_id
                        ));



                        if (!empty($usersDatas)) {
                            foreach ($usersDatas as $key => $usersData) {



                                $usersDatas[$key]->master = array();
                                $usersDatas[$key]->super_master = array();
                                $usersDatas[$key]->hyper_super_master = array();
                                $usersDatas[$key]->admin = array();
                                $usersDatas[$key]->super_admin = array();

                                $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                                $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);



                                $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);


                                $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


                                $get_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);










                                $user_match_comm = 0;

                                if ($user_match_pl < 0) {
                                    $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                                }

                                $usersDatas[$key]->user = array(
                                    'match_pl' => $user_match_pl * -1,
                                    'session_pl' => $user_session_pl * -1,
                                    'user_match_comm' => $event->event_type == 4 ?  $user_match_comm : 0,
                                    'user_session_comm' => $event->event_type == 4 ?  $user_session_comm : 0,
                                    'total_session_stake' => $total_session_stake
                                );

                                $usersDatas[$key]->master = array(
                                    'partnership' => $get_master_partnership->partnership,
                                    'match_comm' =>  $event->event_type == 4 ?  $get_master_partnership->master_commission : 0,
                                    'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,

                                );

                                $usersDatas[$key]->super_master = array(
                                    'partnership' => $get_super_master_partnership->partnership,
                                    'match_comm' =>  $event->event_type == 4 ?  $get_super_master_partnership->master_commission : 0,
                                    'sessional_commission' =>  $event->event_type == 4 ?  $get_super_master_partnership->sessional_commission : 0,

                                );





                                $user->masters[$masterKey]->users =  $usersDatas;
                            }
                        }
                    }
                }
            }
        }

        $dataArray['reports'] = $user;
        $dataArray['event'] = $event;

        // P($user);
        // P($user);
        // p($usersDatas);
        $this->load->view('/super-agent-match-session', $dataArray);
    }

    // public function superMatchSessionPL($event_id)
    // {
    //     $user_id = get_user_id();
    //     $user =  $this->User_model->getUserById($user_id);


    //     if (!empty($user)) {
    //         if ($user->user_type == 'Super Master') {
    //             $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                 'user_id' => $user_id,
    //                 'match_id' => $event_id
    //             ));

    //             $user->masters = $mastersDatas;

    //             if (!empty($user->masters)) {
    //                 foreach ($user->masters as $masterKey => $master) {
    //                     $usersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                         'user_id' => $master->user_id,
    //                         'match_id' => $event_id
    //                     ));


    //                     if (!empty($usersDatas)) {
    //                         foreach ($usersDatas as $key => $usersData) {



    //                             $usersDatas[$key]->master = array();
    //                             $usersDatas[$key]->super_master = array();
    //                             $usersDatas[$key]->hyper_super_master = array();
    //                             $usersDatas[$key]->admin = array();
    //                             $usersDatas[$key]->super_admin = array();

    //                             $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
    //                             $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

    //                             $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
    //                             $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


    //                             $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);
    //                             $get_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);



    //                             $user_match_comm = 0;

    //                             if ($user_match_pl < 0) {
    //                                 $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
    //                             }

    //                             $usersDatas[$key]->user = array(
    //                                 'match_pl' => $user_match_pl * -1,
    //                                 'session_pl' => $user_session_pl * -1,
    //                                 'user_match_comm' => $user_match_comm,
    //                                 'user_session_comm' => $user_session_comm,
    //                             );

    //                             $usersDatas[$key]->master = array(
    //                                 'partnership' => $get_master_partnership->partnership,
    //                                 'match_comm' =>  $get_master_partnership->master_commission,
    //                                 'sessional_commission' =>  $get_master_partnership->sessional_commission,

    //                             );

    //                             $usersDatas[$key]->super_master = array(
    //                                 'partnership' => $get_super_master_partnership->partnership,
    //                                 'match_comm' =>  $get_super_master_partnership->master_commission,
    //                                 'sessional_commission' =>  $get_super_master_partnership->sessional_commission,
    //                             );
    //                         }

    //                         $user->masters[$masterKey]->users = $usersDatas;
    //                     }
    //                 }
    //             }
    //         }
    //     }


    //     $dataArray['reports'] = $user;

    //     // p($usersDatas);
    //     $this->load->view('/master-match-session-pl', $dataArray);
    // }


    // public function masterMatchSessionPL($event_id)
    // {
    //     $user_id = get_user_id();
    //     $user =  $this->User_model->getUserById($user_id);


    //     if (!empty($user)) {
    //         if ($user->user_type == 'Super Master') {

    //             $mastersDatas =  $this->User_model->getInnerUserById(
    //                 $user_id
    //                 // 'match_id' => $event_id
    //             );

    //              $user->masters = $mastersDatas;


    //             if (!empty($user->masters)) {
    //                 foreach ($user->masters as $masterKey => $master) {

    //                     $checkBetExists = $this->Betting_model->check_user_bet_exists(array(
    //                         'user_id' => $master->user_id,
    //                         'match_id' => $event_id,
    //                     ));


    //                     if(isset($checkBetExists->total_bets))
    //                     {




    //                     // $usersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                     //     'user_id' => $master->user_id,
    //                     //     'match_id' => $event_id
    //                     // ));

    //                     $usersDatas =  $this->User_model->getInnerUserById(
    //                         $master->user_id
    //                         // 'match_id' => $event_id
    //                     );



    //                     if (!empty($usersDatas)) {
    //                         foreach ($usersDatas as $key => $usersData) {


    //                             $checkBetExists = $this->Betting_model->check_user_bet_exists(array(
    //                                 'user_id' => $master->user_id,
    //                                 'match_id' => $event_id,
    //                             ));


    //                             if(isset($checkBetExists->total_bets))
    //                             {
    //                             $usersDatas[$key]->master = array();
    //                             $usersDatas[$key]->super_master = array();
    //                             $usersDatas[$key]->hyper_super_master = array();
    //                             $usersDatas[$key]->admin = array();
    //                             $usersDatas[$key]->super_admin = array();

    //                             $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
    //                             $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

    //                             $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
    //                             $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


    //                             $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);
    //                             $get_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);

    //                             $user_match_comm = 0;

    //                             if ($user_match_pl < 0) {
    //                                 $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
    //                             }

    //                             $usersDatas[$key]->user = array(
    //                                 'match_pl' => $user_match_pl * -1,
    //                                 'session_pl' => $user_session_pl * -1,
    //                                 'user_match_comm' => $user_match_comm,
    //                                 'user_session_comm' => $user_session_comm,
    //                             );

    //                             $usersDatas[$key]->master = array(
    //                                 'partnership' => $get_master_partnership->partnership,

    //                             );
    //                         }
    //                         }

    //                         $user->masters[$masterKey]->users = $usersDatas;
    //                     }
    //                 }
    //                 }
    //             }
    //         }
    //     }


    //     $dataArray['reports'] = $user;

    //     // p($usersDatas);
    //     $this->load->view('/master-match-session-pl', $dataArray);
    // }


    public function deleteSettlementEntry()
    {

        $ref_id = $this->input->post('ref_id');



        if (!empty($ref_id)) {

            $settlementData = $this->Ledger_model->getSettlementEntry($ref_id);

            $this->Ledger_model->deleteSettlementEntry($ref_id);


            if (!empty($settlementData)) {

                foreach ($settlementData as $data) {
                    $data = array(
                        'user_id' => $data['user_id'],
                        'is_balance_update' =>  'Yes',
                        'is_exposure_update' =>  'Yes',
                        'is_winnings_update' =>  'Yes',
                    );
                    $user_id = $this->User_model->addUser($data);
                }
            }



            echo json_encode(array('success' => true, 'message' => 'Success'));
            exit;
        } else {
            echo json_encode(array('success' => false, 'message' => 'Something went wrong'));
            exit;
        }
    }

    public function subAdminMatchSessionPL($event_id)
    {


        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);



        if (!empty($user)) {
            if ($user->user_type == 'Admin') {

                $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));

                $user->hypers = $hypersDatas;




                if (!empty($user->hypers)) {
                    foreach ($user->hypers as $hyperKey => $hyper) {

                        $superDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $hyper->user_id,
                            'match_id' => $event_id
                        ));


                        if (!empty($superDatas)) {
                            $user->hypers[$hyperKey]->supers = $superDatas;


                            if (!empty($user->hypers[$hyperKey]->supers)) {
                                $supers  = $user->hypers[$hyperKey]->supers;

                                foreach ($supers as $superKey => $super) {


                                    $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $super->user_id,
                                        'match_id' => $event_id
                                    ));

                                    $user->hypers[$hyperKey]->supers[$superKey]->masters = $mastersDatas;

                                    if (!empty($user->hypers[$hyperKey]->supers[$superKey]->masters)) {
                                        $masters =  $user->hypers[$hyperKey]->supers[$superKey]->masters;
                                        foreach ($masters as $masterKey => $master) {




                                            $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $master->user_id,
                                                'match_id' => $event_id
                                            ));



                                            if (!empty($usersDatas)) {
                                                foreach ($usersDatas as $key => $usersData) {



                                                    $usersDatas[$key]->master = array();
                                                    $usersDatas[$key]->super_master = array();
                                                    $usersDatas[$key]->hyper_super_master = array();
                                                    $usersDatas[$key]->admin = array();
                                                    $usersDatas[$key]->super_admin = array();

                                                    $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                    $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                                                    $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                    $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);



                                                    $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);

                                                    $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


                                                    $get_super_master_partnership = $this->Betting_model->get_betting_info($super->user_id, $event_id);


                                                    $get_hyper_super_master_partnership = $this->Betting_model->get_betting_info($hyper->user_id, $event_id);


                                                    $get_admin_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);





                                                    $user_match_comm = 0;

                                                    if ($user_match_pl < 0) {
                                                        $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                                                    }

                                                    $usersDatas[$key]->user = array(
                                                        'match_pl' => $user_match_pl * -1,
                                                        'session_pl' => $user_session_pl * -1,
                                                        'user_match_comm' => $event->event_type == 4 ?  $user_match_comm : 0,
                                                        'user_session_comm' => $event->event_type == 4 ?  $user_session_comm : 0,
                                                        'total_session_stake' => $total_session_stake
                                                    );

                                                    $usersDatas[$key]->master = array(
                                                        'partnership' => $get_master_partnership->partnership,
                                                        'match_comm' =>  $event->event_type == 4 ?  $get_master_partnership->master_commission : 0,
                                                        'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,

                                                    );

                                                    $usersDatas[$key]->super_master = array(
                                                        'partnership' => $get_super_master_partnership->partnership,
                                                        'match_comm' =>  $event->event_type == 4 ?  $get_super_master_partnership->master_commission : 0,
                                                        'sessional_commission' =>  $event->event_type == 4 ?  $get_super_master_partnership->sessional_commission : 0,

                                                    );



                                                    $usersDatas[$key]->hyper_super_master = array(
                                                        'partnership' => $get_hyper_super_master_partnership->partnership,
                                                        'match_comm' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->master_commission : 0,
                                                        'sessional_commission' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->sessional_commission : 0,


                                                    );

                                                    $usersDatas[$key]->admin = array(
                                                        'partnership' => $get_admin_partnership->partnership,
                                                        'match_comm' =>  $event->event_type == 4 ? $get_admin_partnership->master_commission : 0,
                                                        'sessional_commission' =>  $event->event_type == 4 ?  $get_admin_partnership->sessional_commission : 0,

                                                    );
                                                }
                                                $user->hypers[$hyperKey]->supers[$superKey]->masters[$masterKey]->users =  $usersDatas;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }



        $dataArray['reports'] = $user;
        $dataArray['event'] = $event;

        // P($user);
        // P($user);
        // p($usersDatas);
        $this->load->view('/sub-admin-match-session-pl', $dataArray);
    }

    // public function subAdminMatchSessionPL($event_id)
    // {


    //     $user_id = get_user_id();
    //     $user =  $this->User_model->getUserById($user_id);
    //     $event =  $this->Event_model->get_event_by_event_id($event_id);



    //     if (!empty($user)) {
    //         if ($user->user_type == 'Admin') {

    //             $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                 'user_id' => $user_id,
    //                 'match_id' => $event_id
    //             ));

    //             $user->hypers = $hypersDatas;




    //             if (!empty($user->hypers)) {
    //                 foreach ($user->hypers as $hyperKey => $hyper) {

    //                     $superDatas =  $this->User_model->getInnerUserByEventId(array(
    //                         'user_id' => $hyper->user_id,
    //                         'match_id' => $event_id
    //                     ));


    //                     if (!empty($superDatas)) {
    //                         $user->hypers[$hyperKey]->supers = $superDatas;


    //                         if (!empty($user->hypers[$hyperKey]->supers)) {
    //                             $supers  = $user->hypers[$hyperKey]->supers;

    //                             foreach ($supers as $superKey => $super) {


    //                                 $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                                     'user_id' => $super->user_id,
    //                                     'match_id' => $event_id
    //                                 ));

    //                                 $user->hypers[$hyperKey]->supers[$superKey]->masters = $mastersDatas;

    //                                 if (!empty($user->hypers[$hyperKey]->supers[$superKey]->masters)) {
    //                                     $masters =  $user->hypers[$hyperKey]->supers[$superKey]->masters;
    //                                     foreach ($masters as $masterKey => $master) {




    //                                         $usersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                                             'user_id' => $master->user_id,
    //                                             'match_id' => $event_id
    //                                         ));



    //                                         if (!empty($usersDatas)) {
    //                                             foreach ($usersDatas as $key => $usersData) {



    //                                                 $usersDatas[$key]->master = array();
    //                                                 $usersDatas[$key]->super_master = array();
    //                                                 $usersDatas[$key]->hyper_super_master = array();
    //                                                 $usersDatas[$key]->admin = array();
    //                                                 $usersDatas[$key]->super_admin = array();

    //                                                 $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
    //                                                 $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);
    //                                                  $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
    //                                                 $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


    //                                                 $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);

    //                                                 $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


    //                                                 $get_super_master_partnership = $this->Betting_model->get_betting_info($super->user_id, $event_id);


    //                                                 $get_hyper_super_master_partnership = $this->Betting_model->get_betting_info($hyper->user_id, $event_id);


    //                                                 $get_admin_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);





    //                                                 $user_match_comm = 0;

    //                                                 if ($user_match_pl < 0) {
    //                                                     $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
    //                                                 }

    //                                                 $usersDatas[$key]->user = array(
    //                                                     'match_pl' => $user_match_pl * -1,
    //                                                     'session_pl' => $user_session_pl * -1,
    //                                                     'user_match_comm' => $user_match_comm,
    //                                                     'user_session_comm' => $user_session_comm,
    //                                                     'total_session_stake' => $total_session_stake,
    //                                                 );

    //                                                 $usersDatas[$key]->master = array(
    //                                                     'partnership' => $get_master_partnership->partnership,

    //                                                 );

    //                                                 $usersDatas[$key]->super_master = array(
    //                                                     'partnership' => $get_super_master_partnership->partnership,

    //                                                 );

    //                                                 $usersDatas[$key]->hyper_super_master = array(
    //                                                     'partnership' => $get_hyper_super_master_partnership->partnership,

    //                                                 );


    //                                                 $usersDatas[$key]->admin = array(
    //                                                     'partnership' => $get_admin_partnership->partnership,

    //                                                 );
    //                                             }

    //                                             $user->hypers[$hyperKey]->supers[$superKey]->masters[$masterKey]->users =  $usersDatas;
    //                                         }
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }



    //     $dataArray['reports'] = $user;
    //     $dataArray['event'] = $event;

    //     // P($user);
    //     // P($user);
    //     // p($usersDatas);
    //     $this->load->view('/sub-admin-match-session-pl', $dataArray);
    // }

    public function masterAgentMatchSessionPL($event_id)
    {


        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);



        if (!empty($user)) {
            if ($user->user_type == 'Hyper Super Master') {



                $superDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));


                if (!empty($superDatas)) {
                    $user->supers = $superDatas;


                    if (!empty($user->supers)) {
                        $supers  = $user->supers;

                        foreach ($supers as $superKey => $super) {


                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                'user_id' => $super->user_id,
                                'match_id' => $event_id
                            ));

                            $user->supers[$superKey]->masters = $mastersDatas;

                            if (!empty($user->supers[$superKey]->masters)) {
                                $masters =  $user->supers[$superKey]->masters;
                                foreach ($masters as $masterKey => $master) {




                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                        'user_id' => $master->user_id,
                                        'match_id' => $event_id
                                    ));



                                    if (!empty($usersDatas)) {
                                        foreach ($usersDatas as $key => $usersData) {



                                            $usersDatas[$key]->master = array();
                                            $usersDatas[$key]->super_master = array();
                                            $usersDatas[$key]->hyper_super_master = array();
                                            $usersDatas[$key]->admin = array();
                                            $usersDatas[$key]->super_admin = array();

                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);



                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);


                                            $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


                                            $get_super_master_partnership = $this->Betting_model->get_betting_info($super->user_id, $event_id);


                                            $get_hyper_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);








                                            $user_match_comm = 0;

                                            if ($user_match_pl < 0) {
                                                $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                                            }

                                            $usersDatas[$key]->user = array(
                                                'match_pl' => $user_match_pl * -1,
                                                'session_pl' => $user_session_pl * -1,
                                                'user_match_comm' => $event->event_type == 4 ? $user_match_comm : 0,
                                                'user_session_comm' => $event->event_type == 4 ?  $user_session_comm : 0,
                                                'total_session_stake' => $total_session_stake
                                            );

                                            $usersDatas[$key]->master = array(
                                                'partnership' => $get_master_partnership->partnership,
                                                'match_comm' =>  $event->event_type == 4 ?  $get_master_partnership->master_commission : 0,
                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,

                                            );

                                            $usersDatas[$key]->super_master = array(
                                                'partnership' => $get_super_master_partnership->partnership,
                                                'match_comm' =>  $event->event_type == 4 ?  $get_super_master_partnership->master_commission : 0,
                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_super_master_partnership->sessional_commission : 0,

                                            );



                                            $usersDatas[$key]->hyper_super_master = array(
                                                'partnership' => $get_hyper_super_master_partnership->partnership,
                                                'match_comm' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->master_commission : 0,
                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->sessional_commission : 0,


                                            );


                                            $user->supers[$superKey]->masters[$masterKey]->users =  $usersDatas;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $dataArray['reports'] = $user;
        $dataArray['event'] = $event;

        // P($user);
        // P($user);
        // p($usersDatas);
        $this->load->view('/master-agent-match-session-pl', $dataArray);
    }
    // public function masterAgentMatchSessionPL($event_id)
    // {


    //     $user_id = get_user_id();
    //     $user =  $this->User_model->getUserById($user_id);
    //     $event =  $this->Event_model->get_event_by_event_id($event_id);



    //     if (!empty($user)) {
    //         if ($user->user_type == 'Hyper Super Master') {



    //             $superDatas =  $this->User_model->getInnerUserByEventId(array(
    //                 'user_id' => $user_id,
    //                 'match_id' => $event_id
    //             ));



    //             if (!empty($superDatas)) {
    //                 $user->supers = $superDatas;


    //                 if (!empty($user->supers)) {
    //                     $supers  = $user->supers;

    //                     foreach ($supers as $superKey => $super) {


    //                         $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                             'user_id' => $super->user_id,
    //                             'match_id' => $event_id
    //                         ));

    //                         $user->supers[$superKey]->masters = $mastersDatas;

    //                         if (!empty($user->supers[$superKey]->masters)) {
    //                             $masters =  $user->supers[$superKey]->masters;
    //                             foreach ($masters as $masterKey => $master) {




    //                                 $usersDatas =  $this->User_model->getInnerUserByEventId(array(
    //                                     'user_id' => $master->user_id,
    //                                     'match_id' => $event_id
    //                                 ));



    //                                 if (!empty($usersDatas)) {
    //                                     foreach ($usersDatas as $key => $usersData) {



    //                                         $usersDatas[$key]->master = array();
    //                                         $usersDatas[$key]->super_master = array();
    //                                         $usersDatas[$key]->hyper_super_master = array();
    //                                         $usersDatas[$key]->admin = array();
    //                                         $usersDatas[$key]->super_admin = array();

    //                                         $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
    //                                         $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

    //                                         $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
    //                                         $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


    //                                         $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


    //                                         $get_super_master_partnership = $this->Betting_model->get_betting_info($super->user_id, $event_id);


    //                                         $get_hyper_super_master_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);


    //                                         $get_admin_partnership = $this->Betting_model->get_betting_info($user_id, $event_id);




    //                                         $user_match_comm = 0;

    //                                         if ($user_match_pl < 0) {
    //                                             $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
    //                                         }

    //                                         $usersDatas[$key]->user = array(
    //                                             'match_pl' => $user_match_pl * -1,
    //                                             'session_pl' => $user_session_pl * -1,
    //                                             'user_match_comm' => $user_match_comm,
    //                                             'user_session_comm' => $user_session_comm,
    //                                         );

    //                                         $usersDatas[$key]->master = array(
    //                                             'partnership' => $get_master_partnership->partnership,

    //                                         );

    //                                         $usersDatas[$key]->super_master = array(
    //                                             'partnership' => $get_super_master_partnership->partnership,

    //                                         );

    //                                         $usersDatas[$key]->hyper_super_master = array(
    //                                             'partnership' => $get_hyper_super_master_partnership->partnership,

    //                                         );
    //                                     }
    //                                     $user->supers[$superKey]->masters[$masterKey]->users =  $usersDatas;
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }


    //     $dataArray['reports'] = $user;
    //     $dataArray['event'] = $event;

    //     // P($user);
    //     // P($user);
    //     // p($usersDatas);
    //     $this->load->view('/master-agent-match-session-pl', $dataArray);
    // }


    public function adminMatchSessionPL($event_id)
    {


        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);
        $event =  $this->Event_model->get_event_by_event_id($event_id);



        // p($event);



        if (!empty($user)) {
            if ($user->user_type == 'Super Admin') {

                $adminsDatas =  $this->User_model->getInnerUserByEventId(array(
                    'user_id' => $user_id,
                    'match_id' => $event_id
                ));


                if (!empty($adminsDatas)) {

                    $user->admins = $adminsDatas;
                    foreach ($user->admins as $adminKey => $admin) {
                        $hypersDatas =  $this->User_model->getInnerUserByEventId(array(
                            'user_id' => $admin->user_id,
                            'match_id' => $event_id
                        ));

                        $user->admins[$adminKey]->hypers = $hypersDatas;




                        if (!empty($user->admins[$adminKey]->hypers)) {
                            foreach ($user->admins[$adminKey]->hypers as $hyperKey => $hyper) {

                                $superDatas =  $this->User_model->getInnerUserByEventId(array(
                                    'user_id' => $hyper->user_id,
                                    'match_id' => $event_id
                                ));


                                if (!empty($superDatas)) {
                                    $user->admins[$adminKey]->hypers[$hyperKey]->supers = $superDatas;


                                    if (!empty($user->admins[$adminKey]->hypers[$hyperKey]->supers)) {
                                        $supers  = $user->admins[$adminKey]->hypers[$hyperKey]->supers;

                                        foreach ($supers as $superKey => $super) {


                                            $mastersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                'user_id' => $super->user_id,
                                                'match_id' => $event_id
                                            ));

                                            $user->admins[$adminKey]->hypers[$hyperKey]->supers[$superKey]->masters = $mastersDatas;

                                            if (!empty($user->admins[$adminKey]->hypers[$hyperKey]->supers[$superKey]->masters)) {
                                                $masters =  $user->admins[$adminKey]->hypers[$hyperKey]->supers[$superKey]->masters;
                                                foreach ($masters as $masterKey => $master) {




                                                    $usersDatas =  $this->User_model->getInnerUserByEventId(array(
                                                        'user_id' => $master->user_id,
                                                        'match_id' => $event_id
                                                    ));



                                                    if (!empty($usersDatas)) {
                                                        foreach ($usersDatas as $key => $usersData) {



                                                            $usersDatas[$key]->master = array();
                                                            $usersDatas[$key]->super_master = array();
                                                            $usersDatas[$key]->hyper_super_master = array();
                                                            $usersDatas[$key]->admin = array();
                                                            $usersDatas[$key]->super_admin = array();

                                                            $user_match_pl = $this->Betting_model->count_total_match_profit_loss($usersData->user_id, $event_id);
                                                            $user_session_pl = $this->Betting_model->count_total_session_profit_loss($usersData->user_id, $event_id);

                                                            $user_session_comm = $this->Betting_model->count_total_session_comm($usersData->user_id, $event_id);
                                                            $get_match_comm = $this->Betting_model->count_total_match_comm($usersData->user_id, $event_id);


                                                            $total_session_stake = $this->Betting_model->count_total_session_stake($usersData->user_id, $event_id);


                                                            $get_master_partnership = $this->Betting_model->get_betting_info($master->user_id, $event_id);


                                                            $get_super_master_partnership = $this->Betting_model->get_betting_info($super->user_id, $event_id);


                                                            $get_hyper_super_master_partnership = $this->Betting_model->get_betting_info($hyper->user_id, $event_id);


                                                            $get_admin_partnership = $this->Betting_model->get_betting_info($admin->user_id, $event_id);




                                                            $user_match_comm = 0;

                                                            if ($user_match_pl < 0) {
                                                                $user_match_comm = abs($user_match_pl) * $get_match_comm->master_commission / 100;
                                                            }

                                                            $usersDatas[$key]->user = array(
                                                                'match_pl' => $user_match_pl * -1,
                                                                'session_pl' => $user_session_pl * -1,
                                                                'user_match_comm' => $event->event_type == 4 ?  $user_match_comm : 0,
                                                                'user_session_comm' => $event->event_type == 4 ? $user_session_comm : 0,
                                                                'total_session_stake' => $total_session_stake
                                                            );

                                                            $usersDatas[$key]->master = array(
                                                                'partnership' => $get_master_partnership->partnership,
                                                                'match_comm' =>  $event->event_type == 4 ? $get_master_partnership->master_commission : 0,
                                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_master_partnership->sessional_commission : 0,

                                                            );

                                                            $usersDatas[$key]->super_master = array(
                                                                'partnership' => $get_super_master_partnership->partnership,
                                                                'match_comm' =>  $event->event_type == 4 ? $get_super_master_partnership->master_commission : 0,
                                                                'sessional_commission' =>  $event->event_type == 4 ? $get_super_master_partnership->sessional_commission : 0,

                                                            );



                                                            $usersDatas[$key]->hyper_super_master = array(
                                                                'partnership' => $get_hyper_super_master_partnership->partnership,
                                                                'match_comm' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->master_commission : 0,
                                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_hyper_super_master_partnership->sessional_commission : 0,


                                                            );

                                                            $usersDatas[$key]->admin = array(
                                                                'partnership' => $get_admin_partnership->partnership,
                                                                'match_comm' =>  $event->event_type == 4 ?  $get_admin_partnership->master_commission : 0,
                                                                'sessional_commission' =>  $event->event_type == 4 ?  $get_admin_partnership->sessional_commission : 0,

                                                            );
                                                        }
                                                        $user->admins[$adminKey]->hypers[$hyperKey]->supers[$superKey]->masters[$masterKey]->users =  $usersDatas;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }




        $dataArray['reports'] = $user;
        $dataArray['event'] = $event;

        // P($user);
        // P($user);
        // p($usersDatas);
        $this->load->view('/admin-match-session-pl', $dataArray);
    }









    public function myledger1($sportid = null, $user_id = null)
    {

        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }

        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;


        $dataArray['pstatus'] = 'Settled';
        $reports = array();




        $resultData = array();

        $ledgerData = $this->Ledger_model->get_ledger(array(
            'fltrselct' => 2,
            'user_id' => $user_id
        ));



        $reportsData = $this->Report_model->get_my_ledger_test(array(
            'user_id' => $user_id
        ));

        if (!empty($reportsData)) {
            foreach ($reportsData as $key => $report) {
                $event_id  = $report['match_id'];



                // p($report);

                $resultData[$event_id] = array(
                    'match_id' => $report['match_id'],
                    'event_name' => $report['event_name'],
                    'created_at' => $report['created_at'],
                    'p_l' => 0,
                );


                $user_match_pl = $report['profit'] - $report['loss'];

                $user_session_pl =  $report['total_fancy_profit'] - $report['total_fancy_loss'];



                $user_match_comm = 0;
                $user_session_comm = 0;


                if ($report['event_type'] == 4) {



                    if ($user_match_pl < 0) {
                        $user_match_comm = abs($user_match_pl) * $report['master_commission'] / 100;
                    }
                }

                $total_session_stake =  $report['total_fancy_stake'];

                if ($report['event_type'] == 4) {
                    if ($total_session_stake > 0) {
                        $user_session_comm = abs($total_session_stake) * $report['sessional_commission'] / 100;
                    }
                }

                $total_pl = $user_match_pl + $user_session_pl;


                $total_comm = $user_match_comm + $user_session_comm;

                if ($total_pl < 0) {
                    $net_amt = ($total_pl + $total_comm);
                } else {
                    $net_amt = ($total_pl + $total_comm);
                }

                $share_amt = $net_amt *  $report['partnership'] / 100;

                // p($report['partnership']);


                // $final_amt = $net_amt - $share_amt;
                $final_amt = $share_amt;

                // p($final_amt);

                if ($final_amt < 0) {
                    $final_amt = $final_amt * -1;
                    $resultData[$event_id]['p_l'] += $final_amt;
                } else {
                    $final_amt = $final_amt * -1;

                    $resultData[$event_id]['p_l'] += $final_amt;
                }
            }
        }

        $reports = array_merge($reports, $ledgerData);
        $reports = array_merge($reports, $resultData);


        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;



        $dataArray['profit_loss']  = $this->load->viewPartial('/my-ledger-list-html', $dataArray);
        $this->load->view('/my-ledger', $dataArray);
    }





    public function profitLossDetail($event_id = null, $user_id = null, $market_id = null)
    {
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


        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }
        $dataArray['user_id']  = $user_id;
        // $dataArray['sportid']  = isset($sportid;
        // if ($sportid != 0) {
        //     $dataArray['sportid']  = 5;
        // }
        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');
        $dataArray['match_id'] = $event_id;
        $dataArray['market_id'] = $market_id;
        $search = '';
        // $dataArray = array(
        //     'search_p_l' => $search,

        //     // 'sportid' => $sportid,

        //     'user_id' => $user_id
        // );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $user_detail = $this->User_model->getUserById($user_id);



        $user_type = $user_detail->user_type;




        if ($user_type == 'Master') {


            $dataArray['pstatus'] = 'Settled';

            $reports = array();
            $dataArray['market_id'] = $market_id;


            $parent_user_type = '';
            $self_user_type = '';

            if ($user_type == 'Super Master') {
                $parent_user_type = 'Hyper Super Master';
                $self_user_type = $user_type;
            } else if ($user_type == 'Hyper Super Master') {
                $parent_user_type = 'Admin';
                $self_user_type = $user_type;
            } else if ($user_type == 'Admin') {
                $parent_user_type = 'Super Admin';
                $self_user_type = $user_type;
            }

            $dataArray['parent_user_type'] = $parent_user_type;
            $dataArray['self_user_type'] = $self_user_type;


            $reportsData = $this->Report_model->get_profit_loss_masters_events_market_details($dataArray);



            if (!empty($reportsData)) {

                foreach ($reportsData as $reportData) {


                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }



                    $total_commission = $this->Betting_model->count_match_market_wise_masters_commission(array(
                        'match_id' => $reportData['match_id'],
                        'market_id' => $reportData['market_id'],

                        'user_id' => $user_id,
                        'user_type' => $filter_user_type

                    ));



                    $p_l = $reportData['total_pl'];
                    $p_l = $p_l * $reportData['total_share'] / 100;


                    // p($p_l );

                    $commission = $total_commission->total_commission * $reportData['total_share'] / 100;
                    $reports[] = array(
                        'match_id' => $reportData['match_id'],
                        'event_name' => $reportData['event_name'],
                        'market_name' => $reportData['market_name'],
                        'market_id' =>  $reportData['market_id'],
                        'p_l' => $p_l,
                        'comm_pl' => $commission,
                        'created_at' => $reportData['created_at']
                    );
                }
            }



            $reportsData = $this->Report_model->get_profit_loss_masters_events_fancy_details($dataArray);



            if (!empty($reportsData)) {

                foreach ($reportsData as $reportData) {


                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }






                    $p_l = $reportData['total_pl'];
                    $p_l = $p_l * $reportData['total_share'] / 100;


                    $commission = 0;
                    $reports[] = array(
                        'match_id' => $reportData['match_id'],
                        'event_name' => $reportData['event_name'],
                        'market_name' => 'Fancy',
                        'market_id' =>  $reportData['market_id'],
                        'p_l' => $p_l,
                        'comm_pl' => $commission,
                        'created_at' => $reportData['created_at']
                    );
                }
            }
        } else if ($user_type == 'Super Master' || $user_type == 'Hyper Super Master' || $user_type == 'Admin' || $user_type == 'Super Admin') {

            $dataArray['pstatus'] = 'Settled';
            $dataArray['market_id'] = $market_id;

            $reports = array();


            $parent_user_type = '';
            $self_user_type = '';

            if ($user_type == 'Super Master') {
                $parent_user_type = 'Hyper Super Master';
                $self_user_type = $user_type;
            } else if ($user_type == 'Hyper Super Master') {
                $parent_user_type = 'Admin';
                $self_user_type = $user_type;
            } else if ($user_type == 'Admin') {
                $parent_user_type = 'Super Admin';
                $self_user_type = $user_type;
            }

            $dataArray['parent_user_type'] = $parent_user_type;
            $dataArray['self_user_type'] = $self_user_type;




            $reportsData = $this->Report_model->get_profit_loss_events_market_details($dataArray);



            if (!empty($reportsData)) {

                foreach ($reportsData as $reportData) {


                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }



                    $total_commission = $this->Betting_model->count_match_market_wise_masters_commission(array(
                        'match_id' => $reportData['match_id'],
                        'market_id' => $reportData['market_id'],

                        'user_id' => $user_id,
                        'user_type' => $filter_user_type

                    ));


                    $p_l = $reportData['total_pl'];
                    $p_l = $p_l * $reportData['total_share'] / 100;


                    $commission = $total_commission->total_commission * $reportData['total_share'] / 100;






                    $reports[] = array(
                        'match_id' => $reportData['match_id'],
                        'event_name' => $reportData['event_name'],
                        'market_name' => $reportData['market_name'],
                        'market_id' =>  $reportData['market_id'],
                        'p_l' => $p_l,
                        'comm_pl' => $commission,
                        'created_at' => $reportData['created_at']
                    );
                }
            }



            $reportsData = $this->Report_model->get_profit_loss_events_fancy_details($dataArray);



            if (!empty($reportsData)) {

                foreach ($reportsData as $reportData) {


                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }






                    $p_l = $reportData['total_pl'];
                    $p_l = $p_l * $reportData['total_share'] / 100;


                    $commission = 0;
                    $reports[] = array(
                        'match_id' => $reportData['match_id'],
                        'event_name' => $reportData['event_name'],
                        'market_name' => 'Fancy',
                        'market_id' =>  $reportData['market_id'],
                        'p_l' => $p_l,
                        'comm_pl' => $commission,
                        'created_at' => $reportData['created_at']
                    );
                }
            }
        } else {
            $dataArray['pstatus'] = 'Settled';
            $dataArray['market_id'] = $market_id;

            $reports = array();
            $reportsData = $this->Betting_model->get_event_wise_profit_loss(array(
                'user_id' => $user_id,
                'event_id' => $event_id,
                'market_id' => $market_id
            ));


            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {


                    $reports[] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $report['event_name'],
                        'market_name' => $report['market_name'],
                        'market_id' => $report['market_id'],
                        'p_l' => $report['profit'] - $report['loss'],
                        'comm_pl' => $report['plus_commission'] - $report['minus_commission'],
                        'created_at' => $report['created_at']
                    );
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        $dataArray['event_id'] = $event_id;
        $dataArray['reports'] = $reports;

        $dataArray['profit_loss']  = $this->load->viewPartial('/profit-loss-detail-list-html', $dataArray);
        $this->load->view('/profit-loss-detail', $dataArray);
    }


    public function profitloss($sportid = null, $user_id = null)
    {


        $this->load->library('Datatable');
        if (!$user_id) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }


        $dataArray['user_id']  = $user_id;
        $dataArray['sportid']  = $sportid;
        if ($sportid != 0) {
            $dataArray['sportid']  = 5;
        }
        $dataArray['toDate'] = get_today_end_datetime();
        $dataArray['fromDate'] = get_yesterday_datetime();

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,
            'user_id' => $user_id
        );


        $dataArray['fromDate'] = get_yesterday_datetime();
        $dataArray['toDate'] = get_today_end_datetime();


        $dataArray['pstatus'] = 'Settled';


        $user_detail = $this->User_model->getUserById($user_id);
        $user_type = $user_detail->user_type;



        if ($user_type != 'User') {


            $dataArray['pstatus'] = 'Settled';


            if ($user_type == 'Master') {

                $reportsData = $this->Report_model->get_profit_loss_events_list($dataArray);
            } else {

                $parent_user_type = '';
                $self_user_type = '';

                if ($user_type == 'Super Master') {
                    $parent_user_type = 'Hyper Super Master';
                    $self_user_type = $user_type;
                } else if ($user_type == 'Hyper Super Master') {
                    $parent_user_type = 'Admin';
                    $self_user_type = $user_type;
                } else if ($user_type == 'Admin') {
                    $parent_user_type = 'Super Admin';
                    $self_user_type = $user_type;
                }

                $dataArray['parent_user_type'] = $parent_user_type;
                $dataArray['self_user_type'] = $self_user_type;

                $reportsData = $this->Report_model->get_profit_loss_events_list_new($dataArray);
            }







            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $match_id = $report['match_id'];
                    $event_name = $report['event_name'];
                    $loss = $report['loss'];
                    $profit = $report['profit'];
                    $total_fancy_profit = $report['total_fancy_profit'];
                    $total_fancy_loss = $report['total_fancy_loss'];
                    $total_fancy_stake = $report['total_fancy_stake'];
                    $partnership = $report['partnership'];
                    $master_commission = $report['master_commission'];
                    $sessional_commission = $report['sessional_commission'];
                    $created_at = $report['created_at'];
                    $event_type = $report['event_type'];

                    // p($report);

                    // $match_comm = 0;
                    // $session_comm = 0;

                    $match_pl = $profit - $loss;
                    $session_pl = $total_fancy_profit - $total_fancy_loss;





                    // if ($match_pl < 0) {
                    //     $match_comm = abs($match_pl * $master_commission / 100);
                    // }


                    // if ($total_fancy_stake > 0) {
                    //     $session_comm = abs($total_fancy_stake * $sessional_commission / 100);
                    // }

                    $filter_user_type = '';


                    if ($user_type == 'Master') {
                        $filter_user_type = 'User';
                    } else if ($user_type == 'Super Master') {
                        $filter_user_type = 'Master';
                    } else if ($user_type == 'Hyper Super Master') {
                        $filter_user_type = 'Super Master';
                    } else if ($user_type == 'Admin') {
                        $filter_user_type = 'Hyper Super Master';
                    } else if ($user_type == 'Super Admin') {
                        $filter_user_type = 'Admin';
                    }




                    if ($report['is_casino'] == 'Yes') {

                        $total_commission = $this->Betting_model->count_match_market_wise_masters_commission(array(
                            'match_id' => $report['match_id'],
                            'user_id' => $user_id,
                            'user_type' => $filter_user_type,
                            'market_id' => $report['market_id'],

                        ));
                    } else {
                        $total_commission = $this->Betting_model->count_match_wise_masters_commission(array(
                            'match_id' => $report['match_id'],
                            'user_id' => $user_id,
                            'user_type' => $filter_user_type

                        ));
                    }




                    $p_l = 0;


                    $p_l = (($match_pl + $total_commission->total_commission) * $report['total_share'] / 100) + ($session_pl  * $report['total_share'] / 100);



                    if ($report['is_casino'] == 'Yes') {

                        $market_id = explode('__', $report['market_id']);


                        if (!empty($market_id)) {
                            $market_id = $market_id[1];
                            $market_id = explode('_', $market_id);

                            if (!empty($market_id)) {

                                $market_id  = $market_id[0];
                            }
                        }

                        $event_name = $event_name . ' / ' . $report['market_name'] . ' / ' . $market_id;
                    }

                    // p($p_l);
                    $reports[] = array(
                        'match_id' => $match_id,
                        'event_name' => $event_name,
                        'is_casino' => $report['is_casino'],
                        'market_id' => $report['market_id'],


                        'p_l' => $p_l,
                        'commission' => 0,
                        'created_at' => $created_at
                    );
                }
            }
        } else {
            $dataArray['pstatus'] = 'Settled';
            $reports = array();



            $reportsData = $this->Betting_model->get_user_profit_loss($dataArray);


            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {

                    $event_name = $report['event_name'];
                    if ($report['is_casino'] == 'Yes') {

                        $market_id = explode('__', $report['market_id']);


                        if (!empty($market_id)) {
                            $market_id = $market_id[1];
                            $market_id = explode('_', $market_id);

                            if (!empty($market_id)) {

                                $market_id  = $market_id[0];
                            }
                        }

                        $event_name = $event_name . ' / ' . $report['market_name'] . ' / ' . $market_id;
                    }


                    $reports[] = array(
                        'match_id' => $report['match_id'],
                        'event_name' => $event_name,
                        'is_casino' => $report['is_casino'],
                        'market_id' => $report['market_id'],
                        'p_l' => $report['total_p_l'] + $report['total_commission_pl'],
                        // 'p_l' => $report['total_p_l'],

                        'commission' => 0,
                        'created_at' => $report['created_at']
                    );
                }
            }
        }


        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        array_multisort(array_map('strtotime', array_column($reports, 'created_at')), SORT_DESC, $reports);
        $dataArray['reports'] = $reports;

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

        $dataArray['profit_loss']  = $this->load->viewPartial('/profit-loss-list-html', $dataArray);
        $this->load->view('/profit-loss', $dataArray);
    }

    public function income_report()
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
        $user_id = get_user_id();
        $day_wise_income = $this->Ledger_model->get_all_deposit_withdraw_of_admin_by_day($user_id);
        $month_wise_income = $this->Ledger_model->get_all_deposit_withdraw_of_admin_by_month($user_id);
        $year_wise_income = $this->Ledger_model->get_all_deposit_withdraw_of_admin_by_year($user_id);
        // p($day_wise_income);
        $final_income_report_arr = array();
        foreach ($year_wise_income as $year_row) {
            $year_month_day_array = array();

            foreach ($month_wise_income as $month_row) {
                $month_day_array = array();


                foreach ($day_wise_income as $day_row) {
                    if ($month_row['year'] == $day_row['year'] and $month_row['month'] == $day_row['month']) {
                        $month_day_array[] = $day_row;
                    }
                }

                $month_row['month_day_array'] = $month_day_array;
                $year_month_day_array[] = $month_row;
            }

            $year_row['year_month_day_array'] = $year_month_day_array;
            $final_income_report_arr[] = $year_row;
        }

        $dataArray['final_income_report_arr'] = $final_income_report_arr;
        $this->load->view('/income-report', $dataArray);
    }
}
