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
            'responsive.bootstrap4',
            'blockUI'
        );

        $master_id = $_SESSION['my_userdata']['user_id'];


        if (empty($fltrselct)) {

            $fltrselct = $this->input->post('fltrselct');
        }
        $reports = array();

        if (!$user_id) {
            $user_id = get_user_id();
        }


        $user = $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;

        if ($user_type == 'User') {
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );
            $reports = $this->Ledger_model->get_ledger($dataArray);
        } else if ($user_type == 'Master') {
            $reports = array();
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );

            $masterAllData = $this->Ledger_model->get_ledger($dataArray);

            if (!empty($masterAllData)) {
                $reports = array_merge($reports, $masterAllData);
            }

            $users = $this->User_model->getInnerUserById($user_id);

            if (!empty($users)) {
                // foreach($users as $user)
                // {
                //     $dataArray = array(
                //         'fltrselct' => 3,
                //         'user_id' => $user->user_id
                //     );
                //     $bettings = $this->Ledger_model->get_ledger($dataArray);

                //     if(!empty($bettings))
                //     {
                //         foreach($bettings as $bettingKey => $betting)
                //         {
                //             $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $betting['betting_id'], 'user_type' => 'Master'));

                //             $master_partnership = $get_master_parnership_pr->partnership;

                //          }
                //     }
                //  }
            }
        } else if ($user_type == 'Super Master') {
            $reports = array();
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );

            $masterAllData = $this->Ledger_model->get_ledger($dataArray);

            if (!empty($masterAllData)) {
                $reports = array_merge($reports, $masterAllData);
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reports = array();
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );

            $masterAllData = $this->Ledger_model->get_ledger($dataArray);

            if (!empty($masterAllData)) {
                $reports = array_merge($reports, $masterAllData);
            }
        } else if ($user_type == 'Admin') {
            $reports = array();
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );

            $masterAllData = $this->Ledger_model->get_ledger($dataArray);

            if (!empty($masterAllData)) {
                $reports = array_merge($reports, $masterAllData);
            }
        } else if ($user_type == 'Super Admin') {
            $reports = array();
            $dataArray = array(
                'fltrselct' => $fltrselct,
                'user_id' => $user_id
            );

            $masterAllData = $this->Ledger_model->get_ledger($dataArray);

            if (!empty($masterAllData)) {
                $reports = array_merge($reports, $masterAllData);
            }
        }


        $dataArray['reports'] = $reports;
        $dataArray['fltrselct'] = $fltrselct;
        $accountStmt = $this->load->viewPartial('/account-statement-list-html', $dataArray);
        $dataArray['accountStmt'] = $accountStmt;
        $dataArray['user_id'] = $user_id;
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


        $dataArray = array(
            'search' => $search,
            'fltrselct' => $fltrselct,
            'user_id' => $user_id
        );


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime($fdate));
        }


        if ($fltrselct == 3) {
            $dataArray = array(
                'search_p_l' => $search,
                'user_id' => $user_id
            );

            if (!empty($fdate) && !empty($tdate)) {
                $dataArray['toDate'] = date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
                $dataArray['fromDate'] = date('Y-m-d H:i:s', strtotime($fdate));
            }
            $dataArray['pstatus'] = 'Settled';
        }


        if ($user_type == 'User') {


            if ($fltrselct == 3) {
                $reportsData = $this->Betting_model->get_bettings($dataArray);

                $reports = array();
                if (!empty($reportsData)) {
                    foreach ($reportsData as $report) {
                        $marketId = $report['market_id'];
                        $betting_type = strtolower($report['betting_type']);
                        $market_id = str_replace('.', '_', $marketId);

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
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        } else if ($user_type == 'Master') {
            $reports = array();

            if ($fltrselct == 3) {
                $dataArray['pstatus'] = 'Settled';

                $users = $this->User_model->getInnerUserById($user_id);
                $reports = array();

                if (!empty($users)) {
                    foreach ($users as $user) {
                        $dataArray['user_id'] = $user->user_id;

                        $reportsData = $this->Betting_model->get_bettings($dataArray);
                        if (!empty($reportsData)) {
                            foreach ($reportsData as $report) {
                                $marketId = $report['market_id'];
                                $betting_type = strtolower($report['betting_type']);
                                $market_id = str_replace('.', '_', $marketId);


                                $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                                $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;



                                if (isset($reports[$report['match_id']])) {
                                    if ($betting_type == 'fancy') {
                                        $market_name = 'Fancy';
                                    } else {
                                        $market_name = $report['market_name'];
                                    }

                                    $p_l = 0;

                                    if ($report['bet_result'] == 'Plus') {

                                        $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                        $p_l = $mater_p_l;

                                        $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                    } else if ($report['bet_result'] == 'Minus') {

                                        $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
                                        $p_l = $mater_p_l;
                                        $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                    if ($report['bet_result'] == 'Plus') {
                                        $p_l = $report['profit'] * -1;
                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                        $p_l = $mater_p_l;
                                    } else if ($report['bet_result'] == 'Minus') {
                                        $p_l = $report['loss'];
                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                        $p_l = $mater_p_l;
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
                    }
                }
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        } else if ($user_type == 'Super Master') {
            $reports = array();

            if ($fltrselct == 3) {
                $dataArray['pstatus'] = 'Settled';
                $reports = array();

                $masters = $this->User_model->getInnerUserById($user_id);

                if (!empty($masters)) {
                    foreach ($masters as $master) {
                        $users = $this->User_model->getInnerUserById($master->user_id);

                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $dataArray['user_id'] = $user->user_id;

                                $reportsData = $this->Betting_model->get_bettings($dataArray);
                                if (!empty($reportsData)) {
                                    foreach ($reportsData as $report) {
                                        $marketId = $report['market_id'];
                                        $betting_type = strtolower($report['betting_type']);
                                        $market_id = str_replace('.', '_', $marketId);


                                        $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                                        $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                        $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                        $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;


                                        if (isset($reports[$report['match_id']])) {
                                            if ($betting_type == 'fancy') {
                                                $market_name = 'Fancy';
                                            } else {
                                                $market_name = $report['market_name'];
                                            }

                                            $p_l = 0;

                                            if ($report['bet_result'] == 'Plus') {

                                                $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                $p_l = $smater_p_l - $mater_p_l;

                                                $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                            } else if ($report['bet_result'] == 'Minus') {

                                                $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                $p_l = $smater_p_l - $mater_p_l;
                                                $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                            if ($report['bet_result'] == 'Plus') {
                                                $p_l = $report['profit'] * -1;
                                                $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                $p_l = $smater_p_l - $mater_p_l;
                                            } else if ($report['bet_result'] == 'Minus') {
                                                $p_l = $report['loss'];
                                                $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                $p_l = $smater_p_l - $mater_p_l;
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
                            }
                        }
                    }
                }
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reports = array();

            if ($fltrselct == 3) {
                $dataArray['pstatus'] = 'Settled';
                $reports = array();

                $smasters = $this->User_model->getInnerUserById($user_id);

                if (!empty($smasters)) {
                    foreach ($smasters as $smaster) {
                        $masters = $this->User_model->getInnerUserById($smaster->user_id);

                        if (!empty($masters)) {
                            foreach ($masters as $master) {
                                $users = $this->User_model->getInnerUserById($master->user_id);

                                if (!empty($users)) {
                                    foreach ($users as $user) {
                                        $dataArray['user_id'] = $user->user_id;

                                        $reportsData = $this->Betting_model->get_bettings($dataArray);
                                        if (!empty($reportsData)) {
                                            foreach ($reportsData as $report) {
                                                $marketId = $report['market_id'];
                                                $betting_type = strtolower($report['betting_type']);
                                                $market_id = str_replace('.', '_', $marketId);


                                                $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                                $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                                $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                if (isset($reports[$report['match_id']])) {
                                                    if ($betting_type == 'fancy') {
                                                        $market_name = 'Fancy';
                                                    } else {
                                                        $market_name = $report['market_name'];
                                                    }

                                                    $p_l = 0;

                                                    if ($report['bet_result'] == 'Plus') {

                                                        $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                        $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                        $p_l = $smater_p_l - $mater_p_l;

                                                        $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                    } else if ($report['bet_result'] == 'Minus') {

                                                        $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                        $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                        $p_l = $smater_p_l - $mater_p_l;
                                                        $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                    if ($report['bet_result'] == 'Plus') {
                                                        $p_l = $report['profit'] * -1;
                                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                        $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                        $p_l = $smater_p_l - $mater_p_l;
                                                    } else if ($report['bet_result'] == 'Minus') {
                                                        $p_l = $report['loss'];
                                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                        $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                        $p_l = $smater_p_l - $mater_p_l;
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
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        } else if ($user_type == 'Admin') {
            $reports = array();

            if ($fltrselct == 3) {
                $dataArray['pstatus'] = 'Settled';
                $reports = array();

                $hmasters = $this->User_model->getInnerUserById($user_id);

                if (!empty($hmasters)) {
                    foreach ($hmasters as $hmaster) {
                        $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                        if (!empty($smasters)) {
                            foreach ($smasters as $smaster) {
                                $masters = $this->User_model->getInnerUserById($smaster->user_id);

                                if (!empty($masters)) {
                                    foreach ($masters as $master) {
                                        $users = $this->User_model->getInnerUserById($master->user_id);

                                        if (!empty($users)) {
                                            foreach ($users as $user) {
                                                $dataArray['user_id'] = $user->user_id;

                                                $reportsData = $this->Betting_model->get_bettings($dataArray);
                                                if (!empty($reportsData)) {
                                                    foreach ($reportsData as $report) {
                                                        $marketId = $report['market_id'];
                                                        $betting_type = strtolower($report['betting_type']);
                                                        $market_id = str_replace('.', '_', $marketId);


                                                        $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                                        $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                        $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                        $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                        if (isset($reports[$report['match_id']])) {
                                                            if ($betting_type == 'fancy') {
                                                                $market_name = 'Fancy';
                                                            } else {
                                                                $market_name = $report['market_name'];
                                                            }

                                                            $p_l = 0;

                                                            if ($report['bet_result'] == 'Plus') {

                                                                $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                                $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                                $p_l = $smater_p_l - $mater_p_l;

                                                                $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                            } else if ($report['bet_result'] == 'Minus') {

                                                                $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                                $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                                $p_l = $smater_p_l - $mater_p_l;
                                                                $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                            if ($report['bet_result'] == 'Plus') {
                                                                $p_l = $report['profit'] * -1;
                                                                $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                $p_l = $smater_p_l - $mater_p_l;
                                                            } else if ($report['bet_result'] == 'Minus') {
                                                                $p_l = $report['loss'];
                                                                $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                $p_l = $smater_p_l - $mater_p_l;
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
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        } else if ($user_type == 'Super Admin') {
            $reports = array();

            if ($fltrselct == 3) {

                $dataArray['pstatus'] = 'Settled';
                $reports = array();

                $admins = $this->User_model->getInnerUserById($user_id);

                if (!empty($admins)) {
                    foreach ($admins as $admin) {
                        $hmasters = $this->User_model->getInnerUserById($admin->user_id);

                        if (!empty($hmasters)) {
                            foreach ($hmasters as $hmaster) {
                                $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                                if (!empty($smasters)) {
                                    foreach ($smasters as $smaster) {
                                        $masters = $this->User_model->getInnerUserById($smaster->user_id);

                                        if (!empty($masters)) {
                                            foreach ($masters as $master) {
                                                $users = $this->User_model->getInnerUserById($master->user_id);

                                                if (!empty($users)) {
                                                    foreach ($users as $user) {
                                                        $dataArray['user_id'] = $user->user_id;

                                                        $reportsData = $this->Betting_model->get_bettings($dataArray);
                                                        if (!empty($reportsData)) {
                                                            foreach ($reportsData as $report) {
                                                                $marketId = $report['market_id'];
                                                                $betting_type = strtolower($report['betting_type']);
                                                                $market_id = str_replace('.', '_', $marketId);


                                                                $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                                $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                                $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Admin'));

                                                                $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                                if (isset($reports[$report['match_id']])) {
                                                                    if ($betting_type == 'fancy') {
                                                                        $market_name = 'Fancy';
                                                                    } else {
                                                                        $market_name = $report['market_name'];
                                                                    }

                                                                    $p_l = 0;

                                                                    if ($report['bet_result'] == 'Plus') {

                                                                        $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                                        $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                                        $p_l = $smater_p_l - $mater_p_l;

                                                                        $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                                    } else if ($report['bet_result'] == 'Minus') {

                                                                        $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                                        $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                                        $p_l = $smater_p_l - $mater_p_l;
                                                                        $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                                    if ($report['bet_result'] == 'Plus') {
                                                                        $p_l = $report['profit'] * -1;
                                                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                        $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                        $p_l = $smater_p_l - $mater_p_l;
                                                                    } else if ($report['bet_result'] == 'Minus') {
                                                                        $p_l = $report['loss'];
                                                                        $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                        $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                        $p_l = $smater_p_l - $mater_p_l;
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
            } else {
                $reports = $this->Ledger_model->get_ledger($dataArray);
            }
        }



        array_multisort(array_map('strtotime',array_column($reports,'created_at')),SORT_DESC,$reports);
        $dataArray['reports'] = $reports;

        if ($fltrselct == 3) {
            $accountStmt  = $this->load->viewPartial('/profit-loss-list-html', $dataArray);
        } else {
            $accountStmt = $this->load->viewPartial('/account-statement-list-html', $dataArray);
        }

        echo json_encode($accountStmt);
    } 
    
    public function bethistory($user_id = null)
    {

        $master_id = $_SESSION['my_userdata']['user_id'];
        if (empty($user_id)) {
            $user_id =  $_SESSION['my_userdata']['user_id'];
        }
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

        $dataArray['pstatus'] = 'Settled';


        $date = date_create(date('Y-m-d'));


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
                    if (!empty($market_info)) {
                        if ($winner_selection_id == $market_info->runner_1_selection_id) {
                            $result = $market_info->runner_1_runner_name;
                        } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                            $result = $market_info->runner_2_runner_name;
                        }
                    }

                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else if ($user_type == 'Master') {
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reports = $this->Betting_model->get_bettings($dataArray);

                    if (!empty($reports)) {

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
                                if (!empty($market_info)) {
                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                        $result = $market_info->runner_1_runner_name;
                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                        $result = $market_info->runner_2_runner_name;
                                    }
                                }

                                $reports[$reportKey]['settled_result'] = $result;
                            }
                        }


                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reports = $this->Betting_model->get_bettings($dataArray);


                            if (!empty($reports)) {
                                $i = 0;

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
                                        if (!empty($market_info)) {
                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                $result = $market_info->runner_1_runner_name;
                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                $result = $market_info->runner_2_runner_name;
                                            }
                                        }

                                        $reports[$reportKey]['settled_result'] = $result;
                                    }
                                }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();

            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                    if (!empty($reports)) {
                                        $i = 0;

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
                                                if (!empty($market_info)) {
                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                        $result = $market_info->runner_1_runner_name;
                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                        $result = $market_info->runner_2_runner_name;
                                                    }
                                                }

                                                $reports[$reportKey]['settled_result'] = $result;
                                            }
                                        }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reports = $this->Betting_model->get_bettings($dataArray);


                                            if (!empty($reports)) {
                                                $i = 0;

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
                                                        if (!empty($market_info)) {
                                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                $result = $market_info->runner_1_runner_name;
                                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                $result = $market_info->runner_2_runner_name;
                                                            }
                                                        }

                                                        $reports[$reportKey]['settled_result'] = $result;
                                                    }
                                                }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;

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
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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
        } else if ($user_type == 'Operator') {
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;

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
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
        $dataArray['bettings'] = $reportsData;
        $dataArray['betting'] = $this->load->viewPartial('/betting-history-html', $dataArray);
                // p($this->db->last_query());
        $dataArray['user_id'] = $user_id;
        $event_types = $this->Event_type_model->get_all_event_types();
        $dataArray['event_types'] = $event_types;

        $this->load->view('/bet-history', $dataArray);
    }
    public function filterbethistory()
    {
        $master_id = $_SESSION['my_userdata']['user_id'];

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

        //p($sportid);
        $dataArray = array(
            'search' => $search,
            'sportid' => $sportid,
            'bstatus' => $bstatus,
            'pstatus' => $pstatus,
        );


        if (!empty($tdate) && !empty($fdate)) {
            $dataArray['fromDate'] = date("Y-m-d H:i:s", strtotime($fdate));

            $tdate   =  date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            $dataArray['toDate'] = $tdate;
        }

        $user_type = get_user_type();
        $user_id = get_user_id();
        $user =  $this->User_model->getUserById($user_id);

        if ($user_type == 'Operator') {
            $user_id = getSuperAdminID();
        }

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }

        $reportsData = array();
        if ($user_type == 'User') {
            $reports = $this->Betting_model->get_bettings($dataArray);


            foreach ($reports as $reportKey => $report) {


                if ($report['betting_type'] == 'Fancy') {
                    $selection_id = $report['selection_id'];
                    $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                    if (!empty($fancy_info)) {
                        $settled_result = $fancy_info->result;
                    } else {
                        $settled_result = '';
                    }


                    $reports[$reportKey]['settled_result'] = $settled_result;
                } else if ($report['betting_type'] == 'Match') {
                    $winner_selection_id = $report['winner_selection_id'];
                    $market_id = $report['market_id'];

                    $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                    $result = '';
                    if (!empty($market_info)) {
                        if ($winner_selection_id == $market_info->runner_1_selection_id) {
                            $result = $market_info->runner_1_runner_name;
                        } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                            $result = $market_info->runner_2_runner_name;
                        }
                    }

                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else if ($user_type == 'Master') {
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reports = $this->Betting_model->get_bettings($dataArray);
                    if (!empty($reports)) {


                        foreach ($reports as $reportKey => $report) {


                            if ($report['betting_type'] == 'Fancy') {
                                $selection_id = $report['selection_id'];
                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                if (!empty($fancy_info)) {
                                    $settled_result = $fancy_info->result;
                                } else {
                                    $settled_result = '';
                                }

                                $reports[$reportKey]['settled_result'] = $settled_result;
                            } else if ($report['betting_type'] == 'Match') {
                                $winner_selection_id = $report['winner_selection_id'];
                                $market_id = $report['market_id'];

                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                $result = '';
                                if (!empty($market_info)) {
                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                        $result = $market_info->runner_1_runner_name;
                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                        $result = $market_info->runner_2_runner_name;
                                    }
                                }

                                $reports[$reportKey]['settled_result'] = $result;
                            }
                        }
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reports = $this->Betting_model->get_bettings($dataArray);


                            if (!empty($reports)) {
                                $i = 0;

                                foreach ($reports as $reportKey => $report) {


                                    if ($report['betting_type'] == 'Fancy') {
                                        $selection_id = $report['selection_id'];
                                        $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                        if (!empty($fancy_info)) {
                                            $settled_result = $fancy_info->result;
                                        } else {
                                            $settled_result = '';
                                        }


                                        $reports[$reportKey]['settled_result'] = $settled_result;
                                    } else if ($report['betting_type'] == 'Match') {
                                        $winner_selection_id = $report['winner_selection_id'];
                                        $market_id = $report['market_id'];

                                        $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                        $result = '';
                                        if (!empty($market_info)) {
                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                $result = $market_info->runner_1_runner_name;
                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                $result = $market_info->runner_2_runner_name;
                                            }
                                        }

                                        $reports[$reportKey]['settled_result'] = $result;
                                    }
                                }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();

            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                    if (!empty($reports)) {
                                        $i = 0;

                                        foreach ($reports as $reportKey => $report) {


                                            if ($report['betting_type'] == 'Fancy') {
                                                $selection_id = $report['selection_id'];
                                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                if (!empty($fancy_info)) {
                                                    $settled_result = $fancy_info->result;
                                                } else {
                                                    $settled_result = '';
                                                }


                                                $reports[$reportKey]['settled_result'] = $settled_result;
                                            } else if ($report['betting_type'] == 'Match') {
                                                $winner_selection_id = $report['winner_selection_id'];
                                                $market_id = $report['market_id'];

                                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                $result = '';
                                                if (!empty($market_info)) {
                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                        $result = $market_info->runner_1_runner_name;
                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                        $result = $market_info->runner_2_runner_name;
                                                    }
                                                }

                                                $reports[$reportKey]['settled_result'] = $result;
                                            }
                                        }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reports = $this->Betting_model->get_bettings($dataArray);


                                            if (!empty($reports)) {
                                                $i = 0;

                                                foreach ($reports as $reportKey => $report) {


                                                    if ($report['betting_type'] == 'Fancy') {
                                                        $selection_id = $report['selection_id'];
                                                        $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                        if (!empty($fancy_info)) {
                                                            $settled_result = $fancy_info->result;
                                                        } else {
                                                            $settled_result = '';
                                                        }


                                                        $reports[$reportKey]['settled_result'] = $settled_result;
                                                    } else if ($report['betting_type'] == 'Match') {
                                                        $winner_selection_id = $report['winner_selection_id'];
                                                        $market_id = $report['market_id'];

                                                        $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                        $result = '';
                                                        if (!empty($market_info)) {
                                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                $result = $market_info->runner_1_runner_name;
                                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                $result = $market_info->runner_2_runner_name;
                                                            }
                                                        }

                                                        $reports[$reportKey]['settled_result'] = $result;
                                                    }
                                                }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;

                                                        foreach ($reports as $reportKey => $report) {


                                                            if ($report['betting_type'] == 'Fancy') {
                                                                $selection_id = $report['selection_id'];
                                                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                                if (!empty($fancy_info)) {
                                                                    $settled_result = $fancy_info->result;
                                                                } else {
                                                                    $settled_result = '';
                                                                }


                                                                $reports[$reportKey]['settled_result'] = $settled_result;
                                                            } else if ($report['betting_type'] == 'Match') {
                                                                $winner_selection_id = $report['winner_selection_id'];
                                                                $market_id = $report['market_id'];

                                                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                                $result = '';
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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
        } else if ($user_type == 'Operator') {
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;

                                                        foreach ($reports as $reportKey => $report) {


                                                            if ($report['betting_type'] == 'Fancy') {
                                                                $selection_id = $report['selection_id'];
                                                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                                if (!empty($fancy_info)) {
                                                                    $settled_result = $fancy_info->result;
                                                                } else {
                                                                    $settled_result = '';
                                                                }


                                                                $reports[$reportKey]['settled_result'] = $settled_result;
                                                            } else if ($report['betting_type'] == 'Match') {
                                                                $winner_selection_id = $report['winner_selection_id'];
                                                                $market_id = $report['market_id'];

                                                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                                $result = '';
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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

        // p($reportsData);
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
        $dataArray['bettings'] = $reportsData;

        $bethistory = $this->load->viewPartial('/betting-history-html', $dataArray);
        echo json_encode($bethistory);
    }

    public function profitloss($sportid = null, $user_id = null)
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

            // 'sportid' => $sportid,

            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $user_detail = $this->User_model->getUserById($user_id);



        $user_type = $user_detail->user_type;
    
         if ($user_type == 'Master') {

            $dataArray['pstatus'] = 'Settled';

            $users = $this->User_model->getInnerUserById($user_id);
            $reports = array();

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                    if (!empty($reportsData)) {
                        foreach ($reportsData as $report) {
                            $marketId = $report['market_id'];
                            $betting_type = strtolower($report['betting_type']);
                            $market_id = str_replace('.', '_', $marketId);


                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;



                            if (isset($reports[$report['match_id']])) {
                                if ($betting_type == 'fancy') {
                                    $market_name = 'Fancy';
                                } else {
                                    $market_name = $report['market_name'];
                                }

                                $p_l = 0;

                                if ($report['bet_result'] == 'Plus') {

                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;

                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                } else if ($report['bet_result'] == 'Minus') {

                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
                                    $p_l = $mater_p_l;
                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                if ($report['bet_result'] == 'Plus') {
                                    $p_l = $report['profit'] * -1;
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
                                } else if ($report['bet_result'] == 'Minus') {
                                    $p_l = $report['loss'];
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
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
                }
            }
        } else if ($user_type == 'Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $masters = $this->User_model->getInnerUserById($user_id);

            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $users = $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                            
                            if (!empty($reportsData)) {
                                foreach ($reportsData as $report) {
                                    $marketId = $report['market_id'];
                                    $betting_type = strtolower($report['betting_type']);
                                    $market_id = str_replace('.', '_', $marketId);


                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;



                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));



                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                    if (isset($reports[$report['match_id']])) {
                                        if ($betting_type == 'fancy') {
                                            $market_name = 'Fancy';
                                        } else {
                                            $market_name = $report['market_name'];
                                        }

                                        $p_l = 0;

                                        if ($report['bet_result'] == 'Plus') {

                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;

                                            $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                        } else if ($report['bet_result'] == 'Minus') {

                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;
                                            $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                        if ($report['bet_result'] == 'Plus') {
                                            $p_l = $report['profit'] * -1;
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
                                        } else if ($report['bet_result'] == 'Minus') {
                                            $p_l = $report['loss'];
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
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
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $smasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($smasters)) {
                foreach ($smasters as $smaster) {
                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users = $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                    if (!empty($reportsData)) {
                                        foreach ($reportsData as $report) {
                                            $marketId = $report['market_id'];
                                            $betting_type = strtolower($report['betting_type']);
                                            $market_id = str_replace('.', '_', $marketId);


                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                            if (isset($reports[$report['match_id']])) {
                                                if ($betting_type == 'fancy') {
                                                    $market_name = 'Fancy';
                                                } else {
                                                    $market_name = $report['market_name'];
                                                }

                                                $p_l = 0;

                                                if ($report['bet_result'] == 'Plus') {

                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;

                                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                } else if ($report['bet_result'] == 'Minus') {

                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;
                                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                if ($report['bet_result'] == 'Plus') {
                                                    $p_l = $report['profit'] * -1;
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
                                                } else if ($report['bet_result'] == 'Minus') {
                                                    $p_l = $report['loss'];
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
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
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $hmasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($hmasters)) {
                foreach ($hmasters as $hmaster) {
                    $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                    if (!empty($smasters)) {
                        foreach ($smasters as $smaster) {
                            $masters = $this->User_model->getInnerUserById($smaster->user_id);

                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users = $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                                            if (!empty($reportsData)) {
                                                foreach ($reportsData as $report) {
                                                    $marketId = $report['market_id'];
                                                    $betting_type = strtolower($report['betting_type']);
                                                    $market_id = str_replace('.', '_', $marketId);


                                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                    if (isset($reports[$report['match_id']])) {
                                                        if ($betting_type == 'fancy') {
                                                            $market_name = 'Fancy';
                                                        } else {
                                                            $market_name = $report['market_name'];
                                                        }
        
                                                        $p_l = 0;
        
                                                        if ($report['bet_result'] == 'Plus') {
        
                                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));
        
                                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));
        
        
                                                            $p_l = $smater_p_l - $mater_p_l;
        
                                                            $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {
        
                                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
        
                                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));
        
        
                                                            $p_l = $smater_p_l - $mater_p_l;
                                                            $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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
        
        
                                                        if ($report['bet_result'] == 'Plus') {
                                                            $p_l = $report['profit'] * -1;
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));
        
                                                            $p_l = $smater_p_l - $mater_p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {
                                                            $p_l = $report['loss'];
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));
        
                                                            $p_l = $smater_p_l - $mater_p_l;
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
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hmasters = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hmasters)) {
                        foreach ($hmasters as $hmaster) {
                            $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                            if (!empty($smasters)) {
                                foreach ($smasters as $smaster) {
                                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users = $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                                    if (!empty($reportsData)) {
                                                        foreach ($reportsData as $report) {
                                                            $marketId = $report['market_id'];
                                                            $betting_type = strtolower($report['betting_type']);
                                                            $market_id = str_replace('.', '_', $marketId);


                                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Admin'));

                                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                            if (isset($reports[$report['match_id']])) {
                                                                if ($betting_type == 'fancy') {
                                                                    $market_name = 'Fancy';
                                                                } else {
                                                                    $market_name = $report['market_name'];
                                                                }

                                                                $p_l = 0;

                                                                if ($report['bet_result'] == 'Plus') {

                                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;

                                                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {

                                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                                if ($report['bet_result'] == 'Plus') {
                                                                    $p_l = $report['profit'] * -1;
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {
                                                                    $p_l = $report['loss'];
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
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
        } else {

            $dataArray['user_id'] = $user_id;
            $dataArray['pstatus'] = 'Settled';

            // p($dataArray);
            $reportsData = $this->Betting_model->get_bettings($dataArray);

             $reports = array();
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);
                    $market_id = str_replace('.', '_', $marketId);

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
        array_multisort(array_map('strtotime',array_column($reports,'created_at')),SORT_DESC,$reports);
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
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);

            if (!empty($users)) {
                foreach ($users as $user) {

                    $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                    if (!empty($reports)) {
                        // foreach ($reports as $reportKey => $report) {
                        //     $loss =  $report['loss'] * ($partner_ship / 100);
                        //     $reports[$reportKey]['loss'] = $loss;

                        //     $profit =  $report['profit'] * ($partner_ship / 100);

                        //     $reports[$reportKey]['profit'] = $profit;
                        // }
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {

                            $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                            if (!empty($reports)) {
                                $i = 0;
                                // foreach ($reports as $reportKey => $report) {
                                //     $i++;

                                //     $loss =  $report['loss'] * ($partner_ship / 100);
                                //     $loss_master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                //     $reports[$reportKey]['loss'] = ($loss - $loss_master_partnership_amt);

                                //     $profit =  $report['profit'] * ($partner_ship / 100);
                                //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                // }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {

                                    $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                                    if (!empty($reports)) {
                                        $i = 0;
                                        // foreach ($reports as $reportKey => $report) {
                                        //     $i++;


                                        //     $loss =  $report['loss'] * ($partner_ship / 100);
                                        //     $loss_master_partnership_amt = $report['loss'] * ($master_partnership / 100);

                                        //     $reports[$reportKey]['loss'] = ($loss - $loss_master_partnership_amt);


                                        //     $profit =  $report['profit'] * ($partner_ship / 100);
                                        //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);

                                        //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                        // }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {

                                            $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                                            if (!empty($reports)) {
                                                $i = 0;
                                                // foreach ($reports as $reportKey => $report) {
                                                //     $i++;


                                                //     $loss =  $report['loss'] * ($partner_ship / 100);
                                                //     $loss_master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                                //     $reports[$reportKey]['loss'] = ($loss - $loss_master_partnership_amt);


                                                //     $profit =  $report['profit'] * ($partner_ship / 100);
                                                //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                                //     $reports[$reportKey]['profit'] = ($loss - $profit_master_partnership_amt);
                                                // }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;


            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {

                                                    $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                                                    if (!empty($reports)) {
                                                        $i = 0;
                                                        // foreach ($reports as $reportKey => $report) {
                                                        //     $i++;

                                                        //     $loss =  $report['loss'] * ($partner_ship / 100);

                                                        //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);


                                                        //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);



                                                        //     $profit =  $report['profit'] * ($partner_ship / 100);

                                                        //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);


                                                        //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                                        // }
                                                        $reportsData = array_merge($reportsData, $reports);
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
        } else if ($user_type == 'Operator') {
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;


            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {

                                                    $reports = $this->Betting_model->get_bettings(array('user_id' => $user->user_id,'pstatus'=>'Open'));


                                                    if (!empty($reports)) {
                                                        $i = 0;
                                                        // foreach ($reports as $reportKey => $report) {
                                                        //     $i++;

                                                        //     $loss =  $report['loss'] * ($partner_ship / 100);

                                                        //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);


                                                        //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);



                                                        //     $profit =  $report['profit'] * ($partner_ship / 100);

                                                        //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);


                                                        //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                                        // }
                                                        $reportsData = array_merge($reportsData, $reports);
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

        $dataArray['user_id'] = $user_id;
        $dataArray['user_type'] = $user_type;
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
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

            'sportid' => $sportid,

            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {

            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
            $dataArray['toDate'] = date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
        }

        $user_type = $user_detail->user_type;

         if ($user_type == 'Master') {

            $dataArray['pstatus'] = 'Settled';

            $users = $this->User_model->getInnerUserById($user_id);
            $reports = array();

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reportsData = $this->Betting_model->get_bettings($dataArray);


                    if (!empty($reportsData)) {
                        foreach ($reportsData as $report) {
                             $marketId = $report['market_id'];
                            $betting_type = strtolower($report['betting_type']);
                            $market_id = str_replace('.', '_', $marketId);


                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;



                            if (isset($reports[$report['match_id']])) {
                                if ($betting_type == 'fancy') {
                                    $market_name = 'Fancy';
                                } else {
                                    $market_name = $report['market_name'];
                                }

                                $p_l = 0;

                                if ($report['bet_result'] == 'Plus') {

                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;

                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                } else if ($report['bet_result'] == 'Minus') {

                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
                                    $p_l = $mater_p_l;
                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                if ($report['bet_result'] == 'Plus') {
                                    $p_l = $report['profit'] * -1;
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
                                } else if ($report['bet_result'] == 'Minus') {
                                    $p_l = $report['loss'];
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
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
                }
            }
        } else if ($user_type == 'Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $masters = $this->User_model->getInnerUserById($user_id);

            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $users = $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                            if (!empty($reportsData)) {
                                foreach ($reportsData as $report) {
                                    $marketId = $report['market_id'];
                                    $betting_type = strtolower($report['betting_type']);
                                    $market_id = str_replace('.', '_', $marketId);


                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;


                                    if (isset($reports[$report['match_id']])) {
                                        if ($betting_type == 'fancy') {
                                            $market_name = 'Fancy';
                                        } else {
                                            $market_name = $report['market_name'];
                                        }

                                        $p_l = 0;

                                        if ($report['bet_result'] == 'Plus') {

                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;

                                            $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                        } else if ($report['bet_result'] == 'Minus') {

                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;
                                            $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                        if ($report['bet_result'] == 'Plus') {
                                            $p_l = $report['profit'] * -1;
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
                                        } else if ($report['bet_result'] == 'Minus') {
                                            $p_l = $report['loss'];
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
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
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $smasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($smasters)) {
                foreach ($smasters as $smaster) {
                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users = $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                    if (!empty($reportsData)) {
                                        foreach ($reportsData as $report) {
                                            $marketId = $report['market_id'];
                                            $betting_type = strtolower($report['betting_type']);
                                            $market_id = str_replace('.', '_', $marketId);


                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                            if (isset($reports[$report['match_id']])) {
                                                if ($betting_type == 'fancy') {
                                                    $market_name = 'Fancy';
                                                } else {
                                                    $market_name = $report['market_name'];
                                                }

                                                $p_l = 0;

                                                if ($report['bet_result'] == 'Plus') {

                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;

                                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                } else if ($report['bet_result'] == 'Minus') {

                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;
                                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                if ($report['bet_result'] == 'Plus') {
                                                    $p_l = $report['profit'] * -1;
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
                                                } else if ($report['bet_result'] == 'Minus') {
                                                    $p_l = $report['loss'];
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
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
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $hmasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($hmasters)) {
                foreach ($hmasters as $hmaster) {
                    $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                    if (!empty($smasters)) {
                        foreach ($smasters as $smaster) {
                            $masters = $this->User_model->getInnerUserById($smaster->user_id);

                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users = $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                                            if (!empty($reportsData)) {
                                                foreach ($reportsData as $report) {
                                                    $marketId = $report['market_id'];
                                                    $betting_type = strtolower($report['betting_type']);
                                                    $market_id = str_replace('.', '_', $marketId);


                                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                    if (isset($reports[$report['match_id']])) {
                                                        if ($betting_type == 'fancy') {
                                                            $market_name = 'Fancy';
                                                        } else {
                                                            $market_name = $report['market_name'];
                                                        }

                                                        $p_l = 0;

                                                        if ($report['bet_result'] == 'Plus') {

                                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                            $p_l = $smater_p_l - $mater_p_l;

                                                            $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {

                                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                            $p_l = $smater_p_l - $mater_p_l;
                                                            $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                        if ($report['bet_result'] == 'Plus') {
                                                            $p_l = $report['profit'] * -1;
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                            $p_l = $smater_p_l - $mater_p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {
                                                            $p_l = $report['loss'];
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                            $p_l = $smater_p_l - $mater_p_l;
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
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hmasters = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hmasters)) {
                        foreach ($hmasters as $hmaster) {
                            $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                            if (!empty($smasters)) {
                                foreach ($smasters as $smaster) {
                                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users = $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                                    if (!empty($reportsData)) {
                                                        foreach ($reportsData as $report) {
                                                            $marketId = $report['market_id'];
                                                            $betting_type = strtolower($report['betting_type']);
                                                            $market_id = str_replace('.', '_', $marketId);


                                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Admin'));

                                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                            if (isset($reports[$report['match_id']])) {
                                                                if ($betting_type == 'fancy') {
                                                                    $market_name = 'Fancy';
                                                                } else {
                                                                    $market_name = $report['market_name'];
                                                                }

                                                                $p_l = 0;

                                                                if ($report['bet_result'] == 'Plus') {

                                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;

                                                                    $p_l = $reports[$report['match_id']]['p_l'] +  $p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {

                                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                    $p_l =  $reports[$report['match_id']]['p_l'] + $p_l;
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


                                                                if ($report['bet_result'] == 'Plus') {
                                                                    $p_l = $report['profit'] * -1;
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {
                                                                    $p_l = $report['loss'];
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
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
        } else {

            $dataArray['user_id'] = $user_id;
            $dataArray['pstatus'] = 'Settled';

            $reportsData = $this->Betting_model->get_bettings($dataArray);

            $reports = array();
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {
                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);
                    $market_id = str_replace('.', '_', $marketId);

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


        array_multisort(array_map('strtotime',array_column($reports,'created_at')),SORT_DESC,$reports);
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

    public function client_pl()
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
        $dataArray['sportid']  = 5;


        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');
        $reports = $this->Report_model->get_client_pl($dataArray);

        //        p($reports);
        $dataArray['reports'] = $reports;
        //        p($reports);
        $dataArray['fancy']  = $this->load->viewPartial('/client-pl-list-html', $dataArray);
        $this->load->view('/client-pl', $dataArray);
    }

    public function filter_client_pl()
    {


        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');


        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $reports = $this->Report_model->get_client_pl($dataArray);
        $dataArray['reports'] = $reports;

        $fancy_stack =  $this->load->viewPartial('/client-pl-list-html', $dataArray);
        echo json_encode($fancy_stack);
    }

    public function market_pl()
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

        $dataArray['toDate'] = date('Y-m-d');
        $dataArray['fromDate'] = date('Y-m-d');
        $reports = $this->Report_model->get_market_pl($dataArray);

        $dataArray['reports'] = $reports;
        //        p($reports);
        $dataArray['fancy']  = $this->load->viewPartial('/market-pl-list-html', $dataArray);
        $this->load->view('/market-pl', $dataArray);
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
            $reportsData = $this->Betting_model->get_live_bettings($dataArray);
        } else if ($user_type == 'Master') {
            $reportsData = array();

            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reports = $this->Betting_model->get_live_bettings($dataArray);


                    if (!empty($reports)) {
                        // foreach ($reports as $reportKey => $report) {
                        //     $loss =  $report['loss'] * ($partner_ship / 100);
                        //     $reports[$reportKey]['loss'] = $loss;


                        //     $profit =  $report['profit'] * ($partner_ship / 100);
                        //     $reports[$reportKey]['profit'] = $profit;
                        // }
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            // $user_id = get_user_id();
            // $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reports = $this->Betting_model->get_live_bettings($dataArray);


                            if (!empty($reports)) {
                                $i = 0;
                                // foreach ($reports as $reportKey => $report) {
                                //     $i++;

                                //     $loss =  $report['loss'] * ($partner_ship / 100);
                                //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);


                                //     $profit =  $report['profit'] * ($partner_ship / 100);
                                //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                // }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Betting_model->get_live_bettings($dataArray);


                                    if (!empty($reports)) {
                                        $i = 0;
                                        // foreach ($reports as $reportKey => $report) {
                                        //     $i++;


                                        //     $loss =  $report['loss'] * ($partner_ship / 100);
                                        //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                        //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);

                                        //     $profit =  $report['profit'] * ($partner_ship / 100);
                                        //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                        //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                        // }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reports = $this->Betting_model->get_live_bettings($dataArray);


                                            if (!empty($reports)) {
                                                $i = 0;
                                                // foreach ($reports as $reportKey => $report) {
                                                //     $i++;

                                                //     $loss =  $report['loss'] * ($partner_ship / 100);
                                                //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                                //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);


                                                //     $profit =  $report['profit'] * ($partner_ship / 100);
                                                //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                                //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                                // }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();

            $user =  $this->User_model->getUserById($user_id);
            $partner_ship = $user->partnership;


            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_live_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;
                                                        // foreach ($reports as $reportKey => $report) {
                                                        //     $i++;

                                                        //     $loss =  $report['loss'] * ($partner_ship / 100);
                                                        //     $master_partnership_amt = $report['loss'] * ($master_partnership / 100);
                                                        //     $reports[$reportKey]['loss'] = ($loss - $master_partnership_amt);

                                                        //     $profit =  $report['profit'] * ($partner_ship / 100);
                                                        //     $profit_master_partnership_amt = $report['profit'] * ($master_partnership / 100);
                                                        //     $reports[$reportKey]['profit'] = ($profit - $profit_master_partnership_amt);
                                                        // }
                                                        $reportsData = array_merge($reportsData, $reports);
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

        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
        $dataArray['reports'] = $reportsData;

        $bethistory = $this->load->viewPartial('/live-betting-history-html', $dataArray);
        echo json_encode($bethistory);
    }



    public function chip_summary($user_id = null)
    {
        $minusArr = array();
        $plusArr = array();

        if (!$user_id) {
            $user_id = get_user_id();
        }

        $user =  $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;
        $user_name = $user->name;

        if ($user_type === 'Master') {

            $partnership = $user->partnership;
            $master_id = $user->master_id;

            $master_commision = $user->master_commision;

            $master_user =  $this->User_model->getUserById($master_id);
            $parent_commision = $master_user->master_commision;
            $parent_name = $master_user->name;
            $parent_user_name = $master_user->user_name;


            $users =  $this->User_model->getInnerUserById($user_id);

            $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;



            $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $user_id, 'role' => 'Parent'))->settlement_amount;
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;



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
                        } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;


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

            $masters =  $this->User_model->getInnerUserById($user_id);




            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $chid_partnership_pr = $master->partnership;
                    // $child_commission_pr = $master->master_commision;
                    $child_commission_pr = 0;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $master->user_id, 'role' => 'Parent'))->settlement_amount;


                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;


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
                    } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;

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


            $super_masters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($super_masters)) {
                foreach ($super_masters as $super_master) {
                    $smaster_partnership_pr = $super_master->partnership;
                    $super_master_commission_pr = $super_master->master_commision;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $super_master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $super_master->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;

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

            $hyper_super_master_users =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyper_super_master_users)) {
                foreach ($hyper_super_master_users as $hyper_super_master_user) {
                    $chid_partnership_pr = $hyper_super_master_user->partnership;
                    $hmaster_partnership_pr = $hyper_super_master_user->partnership;


                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $hyper_super_master_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $hyper_super_master_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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


                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) + number_format($total_settle_amount, 2);
                    } else {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) - number_format($total_settle_amount, 2);
                    }
                    $bettingArr['amount'] =   round($bettingArr['amount']);

                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else if ($bettingArr['amount'] > 0) {
                        array_push($plusArr, $bettingArr);
                    }
                }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] = round($parentBettingArr['amount']) +   $parent_total_settle_amount;
                } else {
                    $parentBettingArr['amount'] =   round($parentBettingArr['amount']) - $parent_total_settle_amount;
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



            $admin_users =  $this->User_model->getInnerUserById($user_id);

            if (!empty($admin_users)) {
                foreach ($admin_users as $admin_user) {
                    $chid_partnership_pr = $admin_user->partnership;
                    $super_master_commission_pr = $admin_user->master_commision;
                    $admin_partnership_pr =  $admin_user->partnership;

                    $ledger_plus_settle_amt = $this->Ledger_model->get_total_plus_settlement(array('user_id' => $admin_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $ledger_minus_settle_amt = $this->Ledger_model->get_total_minus_settlement(array('user_id' => $admin_user->user_id, 'role' => 'Parent'))->settlement_amount;

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    } else if ($bettingArr['amount'] > 0) {
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



        $this->load->view('chip-summary', $dataArray);
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;



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
                        } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;


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

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;


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
                    } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;

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

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    } else if ($bettingArr['amount'] > 0) {
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
            $parent_total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;

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

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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


                    if ($bettingArr['amount'] < 0) {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) + number_format($total_settle_amount, 2);
                    } else {
                        $bettingArr['amount'] =  number_format($bettingArr['amount'], 2) - number_format($total_settle_amount, 2);
                    }
                    $bettingArr['amount'] =   round($bettingArr['amount']);

                    if ($bettingArr['amount'] < 0) {
                        array_push($minusArr, $bettingArr);
                    } else if ($bettingArr['amount'] > 0) {
                        array_push($plusArr, $bettingArr);
                    }
                }

                if ($parentBettingArr['amount'] < 0) {

                    $parentBettingArr['amount'] = round($parentBettingArr['amount']) +   $parent_total_settle_amount;
                } else {
                    $parentBettingArr['amount'] =   round($parentBettingArr['amount']) - $parent_total_settle_amount;
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

                    $total_settle_amount = $ledger_plus_settle_amt + $ledger_minus_settle_amt;
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
                    } else if ($bettingArr['amount'] > 0) {
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



    public function profitLossDetail($event_id = null, $user_id = null)
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

        $search = '';
        $dataArray = array(
            'search_p_l' => $search,

            // 'sportid' => $sportid,

            'user_id' => $user_id
        );

        if (!empty($fdate) && !empty($tdate)) {
            $dataArray['toDate'] = date('Y-m-d', strtotime($tdate));
            $dataArray['fromDate'] = date('Y-m-d', strtotime($fdate));
        }


        $user_detail = $this->User_model->getUserById($user_id);



        $user_type = $user_detail->user_type;

        if ($user_type == 'Master') {

            $dataArray['pstatus'] = 'Settled';

            $users = $this->User_model->getInnerUserById($user_id);
            $reports = array();

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                    if (!empty($reportsData)) {
                        foreach ($reportsData as $report) {

                            if ($report['match_id'] != $event_id) {
                                continue;
                            }
                            $marketId = $report['market_id'];
                            $betting_type = strtolower($report['betting_type']);
                            $market_id = str_replace('.', '_', $marketId);


                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;



                            if (isset($reports[$betting_type])) {
                                if ($betting_type == 'fancy') {
                                    $market_name = 'Fancy';
                                } else {
                                    $market_name = $report['market_name'];
                                }

                                $p_l = 0;

                                if ($report['bet_result'] == 'Plus') {

                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;

                                    $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                                } else if ($report['bet_result'] == 'Minus') {

                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
                                    $p_l = $mater_p_l;
                                    $p_l =  $reports[$betting_type]['p_l'] + $p_l;
                                }


                                $reports[$betting_type] = array(
                                    'match_id' => $report['match_id'],
                                    'event_name' => $report['event_name'],
                                    'market_name' => $market_name,
                                    'market_id' => $marketId,

                                    'p_l' => $p_l,
                                    'commission' => 0,
                                    'created_at' => $reports[$betting_type]['created_at']
                                );
                            } else {
                                if ($betting_type == 'fancy') {
                                    $market_name = 'Fancy';
                                } else {
                                    $market_name = $report['market_name'];
                                }


                                $p_l = 0;


                                if ($report['bet_result'] == 'Plus') {
                                    $p_l = $report['profit'] * -1;
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
                                } else if ($report['bet_result'] == 'Minus') {
                                    $p_l = $report['loss'];
                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));

                                    $p_l = $mater_p_l;
                                }



                                $reports[$betting_type] = array(
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
            }
        } else if ($user_type == 'Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $masters = $this->User_model->getInnerUserById($user_id);

            // p($masters);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    // if($master->user_id == '295')
                    // {
                    //     continue;
                    // }
                    $users = $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reportsData = $this->Betting_model->get_bettings($dataArray);


                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                            if (!empty($reportsData)) {
                                foreach ($reportsData as $report) {

                                    if ($report['match_id'] != $event_id) {
                                        continue;
                                    }
                                    $marketId = $report['market_id'];
                                    $betting_type = strtolower($report['betting_type']);
                                    $market_id = str_replace('.', '_', $marketId);


                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;
                                   
                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;


                                    if (isset($reports[$betting_type])) {
                                        if ($betting_type == 'fancy') {
                                            $market_name = 'Fancy';
                                        } else {
                                            $market_name = $report['market_name'];
                                        }

                                        $p_l = 0;

                                        if ($report['bet_result'] == 'Plus') {

                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;

                                            $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                                        } else if ($report['bet_result'] == 'Minus') {

                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                            $p_l = $smater_p_l - $mater_p_l;
                                            $p_l =  $reports[$betting_type]['p_l'] + $p_l;
                                        }


                                        $reports[$betting_type] = array(
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


                                        if ($report['bet_result'] == 'Plus') {
                                            $p_l = $report['profit'] * -1;
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
                                        } else if ($report['bet_result'] == 'Minus') {
                                            $p_l = $report['loss'];
                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                            $p_l = $smater_p_l - $mater_p_l;
                                        }



                                        $reports[$betting_type] = array(
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
                            // if (!empty($reportsData)) {
                            //     foreach ($reportsData as $report) {


                            // // if($report['match_id'] != $event_id)
                            // // {
                            // //     continue;
                            // // }

                            //         $marketId = $report['market_id'];
                            //         $betting_type = strtolower($report['betting_type']);
                            //         $market_id = str_replace('.', '_', $marketId);


                            //         $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Master'));

                            //         $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                            //         $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                            //         $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;


                            //         if (isset($reports[$betting_type])) {
                            //             if ($betting_type == 'fancy') {
                            //                 $market_name = 'Fancy';
                            //             } else {
                            //                 $market_name = $report['market_name'];
                            //             }

                            //             $p_l = 0;

                            //             if ($report['bet_result'] == 'Plus') {

                            //                 $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                            //                 $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                            //                 $p_l = $smater_p_l - $mater_p_l;

                            //                 $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                            //             } else if ($report['bet_result'] == 'Minus') {

                            //                 $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                            //                 $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                            //                 $p_l = $smater_p_l - $mater_p_l;
                            //                 $p_l =  $reports[$betting_type]['p_l'] + $p_l;
                            //             }


                            //             $reports[$betting_type] = array(
                            //                 'match_id' => $report['match_id'],
                            //                 'event_name' => $report['event_name'],
                            //                 'market_name' => $market_name,
                            //                 'market_id' => $marketId,

                            //                 'p_l' => $p_l,
                            //                 'commission' => 0,
                            //                 'created_at' => $report['created_at']
                            //             );
                            //         } else {
                            //             if ($betting_type == 'fancy') {
                            //                 $market_name = 'Fancy';
                            //             } else {
                            //                 $market_name = $report['market_name'];
                            //             }


                            //             $p_l = 0;


                            //             if ($report['bet_result'] == 'Plus') {
                            //                 $p_l = $report['profit'] * -1;
                            //                 $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                            //                 $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                            //                 $p_l = $smater_p_l - $mater_p_l;
                            //             } else if ($report['bet_result'] == 'Minus') {
                            //                 $p_l = $report['loss'];
                            //                 $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                            //                 $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                            //                 $p_l = $smater_p_l - $mater_p_l;
                            //             }



                            //             $reports[$betting_type] = array(
                            //                 'match_id' => $report['match_id'],
                            //                 'event_name' => $report['event_name'],
                            //                 'market_name' => $market_name,
                            //                 'market_id' => $marketId,

                            //                 'p_l' => $p_l,
                            //                 'commission' => 0,
                            //                 'created_at' => $report['created_at']
                            //             );
                            //         }
                            //     }
                            // }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $smasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($smasters)) {
                foreach ($smasters as $smaster) {
                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users = $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                    if (!empty($reportsData)) {
                                        foreach ($reportsData as $report) {

                                            if ($report['match_id'] != $event_id) {
                                                continue;
                                            }
                                            $marketId = $report['market_id'];
                                            $betting_type = strtolower($report['betting_type']);
                                            $market_id = str_replace('.', '_', $marketId);


                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Master'));

                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                            if (isset($reports[$betting_type])) {
                                                if ($betting_type == 'fancy') {
                                                    $market_name = 'Fancy';
                                                } else {
                                                    $market_name = $report['market_name'];
                                                }

                                                $p_l = 0;

                                                if ($report['bet_result'] == 'Plus') {

                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;

                                                    $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                                                } else if ($report['bet_result'] == 'Minus') {

                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                    $p_l = $smater_p_l - $mater_p_l;
                                                    $p_l =  $reports[$betting_type]['p_l'] + $p_l;
                                                }


                                                $reports[$betting_type] = array(
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


                                                if ($report['bet_result'] == 'Plus') {
                                                    $p_l = $report['profit'] * -1;
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
                                                } else if ($report['bet_result'] == 'Minus') {
                                                    $p_l = $report['loss'];
                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                    $p_l = $smater_p_l - $mater_p_l;
                                                }



                                                $reports[$betting_type] = array(
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
                            }
                        }
                    }
                }
            }
            // p($report,0);
        } else if ($user_type == 'Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $hmasters = $this->User_model->getInnerUserById($user_id);

            if (!empty($hmasters)) {
                foreach ($hmasters as $hmaster) {
                    $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                    if (!empty($smasters)) {
                        foreach ($smasters as $smaster) {
                            $masters = $this->User_model->getInnerUserById($smaster->user_id);

                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users = $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reportsData = $this->Betting_model->get_bettings($dataArray);
                                            if (!empty($reportsData)) {
                                                foreach ($reportsData as $report) {

                                                    if ($report['match_id'] != $event_id) {
                                                        continue;
                                                    }

                                                    $marketId = $report['market_id'];
                                                    $betting_type = strtolower($report['betting_type']);
                                                    $market_id = str_replace('.', '_', $marketId);


                                                    $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Hyper Super Master'));

                                                    $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                    $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                    $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                    if (isset($reports[$betting_type])) {
                                                        if ($betting_type == 'fancy') {
                                                            $market_name = 'Fancy';
                                                        } else {
                                                            $market_name = $report['market_name'];
                                                        }
        
                                                        $p_l = 0;
        
                                                        if ($report['bet_result'] == 'Plus') {
        
                                                            $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));
        
                                                            $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));
        
        
                                                            $p_l = $smater_p_l - $mater_p_l;
        
                                                            $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {
        
                                                            $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));
        
                                                            $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));
        
        
                                                            $p_l = $smater_p_l - $mater_p_l;
                                                            $p_l =  $reports[$betting_type]['p_l'] + $p_l;
                                                        }
        
        
                                                        $reports[$betting_type] = array(
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
        
        
                                                        if ($report['bet_result'] == 'Plus') {
                                                            $p_l = $report['profit'] * -1;
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));
        
                                                            $p_l = $smater_p_l - $mater_p_l;
                                                        } else if ($report['bet_result'] == 'Minus') {
                                                            $p_l = $report['loss'];
                                                            $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                            $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));
        
                                                            $p_l = $smater_p_l - $mater_p_l;
                                                        }
        
        
        
                                                        $reports[$betting_type] = array(
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
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Super Admin') {

            $dataArray['pstatus'] = 'Settled';
            $reports = array();

            $admins = $this->User_model->getInnerUserById($user_id);

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $hmasters = $this->User_model->getInnerUserById($admin->user_id);

                    if (!empty($hmasters)) {
                        foreach ($hmasters as $hmaster) {
                            $smasters = $this->User_model->getInnerUserById($hmaster->user_id);

                            if (!empty($smasters)) {
                                foreach ($smasters as $smaster) {
                                    $masters = $this->User_model->getInnerUserById($smaster->user_id);

                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users = $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reportsData = $this->Betting_model->get_bettings($dataArray);
                                                    if (!empty($reportsData)) {
                                                        foreach ($reportsData as $report) {


                                                            if ($report['match_id'] != $event_id) {
                                                                continue;
                                                            }

                                                            $marketId = $report['market_id'];
                                                            $betting_type = strtolower($report['betting_type']);
                                                            $market_id = str_replace('.', '_', $marketId);


                                                            $get_master_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Admin'));

                                                            $master_parnership_pr = isset($get_master_parnership_pr->partnership) ? $get_master_parnership_pr->partnership : 0;


                                                            $get_smaster_parnership_pr = $this->Masters_betting_settings_model->get_betting_setting(array('betting_id' => $report['betting_id'], 'user_type' => 'Super Admin'));

                                                            $smaster_parnership_pr = isset($get_smaster_parnership_pr->partnership) ? $get_smaster_parnership_pr->partnership : 0;



                                                            if (isset($reports[$betting_type])) {
                                                                if ($betting_type == 'fancy') {
                                                                    $market_name = 'Fancy';
                                                                } else {
                                                                    $market_name = $report['market_name'];
                                                                }

                                                                $p_l = 0;

                                                                if ($report['bet_result'] == 'Plus') {

                                                                    $mater_p_l = (($report['profit'] * -1) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['profit'] * -1) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;

                                                                    $p_l = $reports[$betting_type]['p_l'] +  $p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {

                                                                    $mater_p_l = (($report['loss']) * ($master_parnership_pr / 100));

                                                                    $smater_p_l = (($report['loss']) * ($smaster_parnership_pr / 100));


                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                    $p_l =  $reports[$$betting_type]['p_l'] + $p_l;
                                                                }


                                                                $reports[$betting_type] = array(
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


                                                                if ($report['bet_result'] == 'Plus') {
                                                                    $p_l = $report['profit'] * -1;
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                } else if ($report['bet_result'] == 'Minus') {
                                                                    $p_l = $report['loss'];
                                                                    $mater_p_l = (($p_l) * ($master_parnership_pr / 100));
                                                                    $smater_p_l = (($p_l) * ($smaster_parnership_pr / 100));

                                                                    $p_l = $smater_p_l - $mater_p_l;
                                                                }



                                                                $reports[$betting_type] = array(
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
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {

            $dataArray['user_id'] = $user_id;
            $dataArray['pstatus'] = 'Settled';

            $reportsData = $this->Betting_model->get_bettings($dataArray);


            $reports = array();
            if (!empty($reportsData)) {
                foreach ($reportsData as $report) {

                    if ($report['match_id'] != $event_id) {
                        continue;
                    }



                    $marketId = $report['market_id'];
                    $betting_type = strtolower($report['betting_type']);
                    $market_id = str_replace('.', '_', $marketId);

                    if (isset($reports[$betting_type])) {
                        if ($betting_type == 'fancy') {
                            $market_name = 'Fancy';
                        } else {
                            $market_name = $report['market_name'];
                        }

                        $p_l = 0;

                        if ($report['bet_result'] == 'Plus') {

                            $p_l =  $reports[$betting_type]['p_l'] + $report['profit'];
                        } else if ($report['bet_result'] == 'Minus') {

                            // p($reports[$betting_type]['p_l'] +  $report['loss'] * -1);
                            $p_l = $reports[$betting_type]['p_l'] +  $report['loss'] * -1;
                        }




                        $reports[$betting_type] = array(
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

                        if ($report['bet_result'] == 'Plus') {
                            $p_l = $report['profit'];
                        } else if ($report['bet_result'] == 'Minus') {


                            $p_l = $report['loss'] * -1;
                        }


                        $reports[$betting_type] = array(
                            'match_id' => $report['match_id'],
                            'event_name' => $report['event_name'],
                            'market_name' => $market_name,
                            'market_id' => $marketId,
                            'p_l' => $p_l,
                            'commission' => 0,
                            'created_at' => $report['created_at']
                        );
                    }

                    // p($reports,0);
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


    public function profitLossbethistory($event_id = null, $market_id = null, $user_id = null, $is_fancy = null)
    {

         $master_id = $_SESSION['my_userdata']['user_id'];
        if (empty($user_id)) {

             $user_id =  $_SESSION['my_userdata']['user_id'];
        }

 
        $dataArray['pstatus'] = 'Settled';


        $date = date_create(date('Y-m-d'));


        // $dataArray['fromDate'] = date_format($date, "Y-m-d  H:i:s");


        // $dataArray['toDate'] = date('Y-m-d H:i:s');


        if ($is_fancy == 'Yes') {
            $dataArray['betting_type'] = 'Fancy';
        } else {
            $dataArray['betting_type'] = 'Match';
            // $dataArray['market_id'] = $market_id;

        }

        $dataArray['match_id'] = $event_id;

 
         $user =  $this->User_model->getUserById($user_id);
         $user_type = $user->user_type;
         $reportsData = array();

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }


        if ($user_type == 'User') {

            $reports = $this->Betting_model->get_bettings($dataArray);

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
                    if (!empty($market_info)) {
                        if ($winner_selection_id == $market_info->runner_1_selection_id) {
                            $result = $market_info->runner_1_runner_name;
                        } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                            $result = $market_info->runner_2_runner_name;
                        }
                    }

                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else if ($user_type == 'Master') {
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reports = $this->Betting_model->get_bettings($dataArray);
                    if (!empty($reports)) {


                        foreach ($reports as $reportKey => $report) {


                            if ($report['betting_type'] == 'Fancy') {
                                $selection_id = $report['selection_id'];
                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                $settled_result = empty($fancy_info->result)?null:$fancy_info->result;

                                $reports[$reportKey]['settled_result'] = $settled_result;
                            } else if ($report['betting_type'] == 'Match') {
                                $winner_selection_id = $report['winner_selection_id'];
                                $market_id = $report['market_id'];

                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                $result = '';
                                if (!empty($market_info)) {
                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                        $result = $market_info->runner_1_runner_name;
                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                        $result = $market_info->runner_2_runner_name;
                                    }
                                }

                                $reports[$reportKey]['settled_result'] = $result;
                            }
                        }
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reports = $this->Betting_model->get_bettings($dataArray);


                            if (!empty($reports)) {
                                $i = 0;


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
                                        if (!empty($market_info)) {
                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                $result = $market_info->runner_1_runner_name;
                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                $result = $market_info->runner_2_runner_name;
                                            }
                                        }

                                        $reports[$reportKey]['settled_result'] = $result;
                                    }
                                }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();

            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                    if (!empty($reports)) {
                                        $i = 0;


                                        foreach ($reports as $reportKey => $report) {


                                            if ($report['betting_type'] == 'Fancy') {
                                                $selection_id = $report['selection_id'];
                                                $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                $settled_result = empty($fancy_info->result)? null: $fancy_info->result;

                                                $reports[$reportKey]['settled_result'] = $settled_result;
                                            } else if ($report['betting_type'] == 'Match') {
                                                $winner_selection_id = $report['winner_selection_id'];
                                                $market_id = $report['market_id'];

                                                $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                $result = '';
                                                if (!empty($market_info)) {
                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                        $result = $market_info->runner_1_runner_name;
                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                        $result = $market_info->runner_2_runner_name;
                                                    }
                                                }

                                                $reports[$reportKey]['settled_result'] = $result;
                                            }
                                        }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reports = $this->Betting_model->get_bettings($dataArray);


                                            if (!empty($reports)) {
                                                $i = 0;


                                                foreach ($reports as $reportKey => $report) {


                                                    if ($report['betting_type'] == 'Fancy') {
                                                        $selection_id = $report['selection_id'];
                                                        $fancy_info = $this->Betting_model->get_fancy_by_selectionid($selection_id);

                                                        $settled_result = empty($fancy_info->result)? null : $fancy_info->result;

                                                        $reports[$reportKey]['settled_result'] = $settled_result;
                                                    } else if ($report['betting_type'] == 'Match') {
                                                        $winner_selection_id = $report['winner_selection_id'];
                                                        $market_id = $report['market_id'];

                                                        $market_info =  $this->Betting_model->get_market_type_by_marketid($market_id);
                                                        $result = '';
                                                        if (!empty($market_info)) {
                                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                $result = $market_info->runner_1_runner_name;
                                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                $result = $market_info->runner_2_runner_name;
                                                            }
                                                        }

                                                        $reports[$reportKey]['settled_result'] = $result;
                                                    }
                                                }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;


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
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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
        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
        $dataArray['bettings'] = $reportsData;
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
        $this->load->view('/profit-loss-bet-history', $dataArray);
    }
    public function profitLossfilterbethistory($event_id = null, $market_id = null, $user_id = null, $is_fancy = null)
    {
        $master_id = $_SESSION['my_userdata']['user_id'];

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
            // $dataArray['market_id'] = $market_id;

        }

        $dataArray['match_id'] = $match_id;


        if (!empty($tdate) && !empty($fdate)) {
            $dataArray['fromDate'] = date("Y-m-d H:i:s", strtotime($fdate));

            $tdate   =  date('Y-m-d H:i:s', (strtotime("tomorrow", strtotime($tdate)) - 1));
            $dataArray['toDate'] = $tdate;
        }

      
         $user =  $this->User_model->getUserById($user_id);
        $user_type = $user->user_type;

        if ($user_type == 'User') {
            $dataArray['user_id']  = $user_id;
        }

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
                    if (!empty($market_info)) {
                        if ($winner_selection_id == $market_info->runner_1_selection_id) {
                            $result = $market_info->runner_1_runner_name;
                        } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                            $result = $market_info->runner_2_runner_name;
                        }
                    }

                    $reports[$reportKey]['settled_result'] = $result;
                }
            }
            $reportsData = array_merge($reportsData, $reports);
        } else if ($user_type == 'Master') {
            $partner_ship = $user->partnership;
            $users =  $this->User_model->getInnerUserById($user_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataArray['user_id'] = $user->user_id;

                    $reports = $this->Betting_model->get_bettings($dataArray);
                    if (!empty($reports)) {

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
                                if (!empty($market_info)) {
                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                        $result = $market_info->runner_1_runner_name;
                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                        $result = $market_info->runner_2_runner_name;
                                    }
                                }

                                $reports[$reportKey]['settled_result'] = $result;
                            }
                        }
                        $reportsData = array_merge($reportsData, $reports);
                    }
                }
            }
        } else if ($user_type == 'Super Master') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $masters =  $this->User_model->getInnerUserById($user_id);
            if (!empty($masters)) {
                foreach ($masters as $master) {
                    $master_partnership = $master->partnership;
                    $users =  $this->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataArray['user_id'] = $user->user_id;

                            $reports = $this->Betting_model->get_bettings($dataArray);


                            if (!empty($reports)) {
                                $i = 0;

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
                                        if (!empty($market_info)) {
                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                $result = $market_info->runner_1_runner_name;
                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                $result = $market_info->runner_2_runner_name;
                                            }
                                        }

                                        $reports[$reportKey]['settled_result'] = $result;
                                    }
                                }
                                $reportsData = array_merge($reportsData, $reports);
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Hyper Super Master') {
            $reportsData = array();

            $partner_ship = $user->partnership;

            $superMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $master_partnership = $superMaster->partnership;

                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                    if (!empty($masters)) {
                        foreach ($masters as $master) {
                            $users =  $this->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataArray['user_id'] = $user->user_id;

                                    $dataArray['user_id'] = $user->user_id;
                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                    if (!empty($reports)) {
                                        $i = 0;

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
                                                if (!empty($market_info)) {
                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                        $result = $market_info->runner_1_runner_name;
                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                        $result = $market_info->runner_2_runner_name;
                                                    }
                                                }

                                                $reports[$reportKey]['settled_result'] = $result;
                                            }
                                        }
                                        $reportsData = array_merge($reportsData, $reports);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($user_type == 'Admin') {
            $reportsData = array();
            $partner_ship = $user->partnership;

            $hyperSuperMasters =  $this->User_model->getInnerUserById($user_id);

            if (!empty($hyperSuperMasters)) {
                foreach ($hyperSuperMasters as $hyperSuperMaster) {
                    $master_partnership = $hyperSuperMaster->partnership;

                    $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {

                            $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                            if (!empty($masters)) {
                                foreach ($masters as $master) {
                                    $users =  $this->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataArray['user_id'] = $user->user_id;

                                            $reports = $this->Betting_model->get_bettings($dataArray);


                                            if (!empty($reports)) {
                                                $i = 0;

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
                                                        if (!empty($market_info)) {
                                                            if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                $result = $market_info->runner_1_runner_name;
                                                            } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                $result = $market_info->runner_2_runner_name;
                                                            }
                                                        }

                                                        $reports[$reportKey]['settled_result'] = $result;
                                                    }
                                                }
                                                $reportsData = array_merge($reportsData, $reports);
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
            $reportsData = array();
            $partner_ship = $user->partnership;
            $adminUsers =  $this->User_model->getInnerUserById($user_id);

            if (!empty($adminUsers)) {
                foreach ($adminUsers as $adminUser) {
                    $master_partnership = $adminUser->partnership;

                    $hyperSuperMasters =  $this->User_model->getInnerUserById($adminUser->user_id);

                    if (!empty($hyperSuperMasters)) {
                        foreach ($hyperSuperMasters as $hyperSuperMaster) {

                            $superMasters =  $this->User_model->getInnerUserById($hyperSuperMaster->user_id);

                            if (!empty($superMasters)) {
                                foreach ($superMasters as $superMaster) {

                                    $masters =  $this->User_model->getInnerUserById($superMaster->user_id);
                                    if (!empty($masters)) {
                                        foreach ($masters as $master) {
                                            $users =  $this->User_model->getInnerUserById($master->user_id);

                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $dataArray['user_id'] = $user->user_id;

                                                    $reports = $this->Betting_model->get_bettings($dataArray);


                                                    if (!empty($reports)) {
                                                        $i = 0;

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
                                                                if (!empty($market_info)) {
                                                                    if ($winner_selection_id == $market_info->runner_1_selection_id) {
                                                                        $result = $market_info->runner_1_runner_name;
                                                                    } else if ($winner_selection_id == $market_info->runner_2_selection_id) {
                                                                        $result = $market_info->runner_2_runner_name;
                                                                    }
                                                                }

                                                                $reports[$reportKey]['settled_result'] = $result;
                                                            }
                                                        }
                                                        $reportsData = array_merge($reportsData, $reports);
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

        // usort($reportsData, 'date_compare');
        array_multisort(array_map('strtotime',array_column($reportsData,'created_at')),SORT_DESC,$reportsData);
        $dataArray['bettings'] = $reportsData;

        $bethistory = $this->load->viewPartial('/profit-loss-betting-list-html', $dataArray);
        echo json_encode($bethistory);
    }
}
