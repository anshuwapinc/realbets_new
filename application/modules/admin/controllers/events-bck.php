<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('User_model');
        $this->load->model('Event_model');
        $this->load->model('Fancy_data_model');

        $this->load->model('Betting_model');
        $this->load->model('User_info_model');
        $this->load->model('Event_exchange_entry_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
    }


    public function getevents($type = null)
    {
        if ($type == 'inplay') {
            $data['inplay'] = '1';
            $list_events = $this->Event_model->list_events($data);
        } else {
            $data = array();
            $list_events = $this->Event_model->list_events($data);
        }


        $exchangeData = array();
        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {
                $exchangeData[$key] = $list_event;


                $market_book_odds_runner = $this->Event_model->list_market_book_odds_runner($list_event['event_id']);

                $exchangeData[$key]['runners'] = $market_book_odds_runner;
            }
        }
        $dataArray['crickets'] = $exchangeData;
        $matchListingHtml = $this->load->viewPartial('dashboardMatchListing', $dataArray);
        echo json_encode(array('matchListingHtml' => $matchListingHtml));
    }






    public function backlays()
    {
        $event_id = $this->input->post('matchId');
        $market_id = $this->input->post('MarketId');

        $data['event_id'] = $event_id;
        $list_events = $this->Event_model->list_events($data);




        $exchangeData = array();
        $fantacyData = array();
        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {

                $event_id = $list_event['event_id'];
                $exchangeData[$event_id] = $list_event;
                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));


                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {
                        // $market_id = str_replace('.','',$market_type['market_id']);
                        $market_id = $market_type['market_id'];
                        // p($market_id);
                        $exchangeData[$event_id]['market_types'][$market_id] = $market_type;
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'] = $runners;
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'] = 0;
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'] = 0;


                        $user_id = $_SESSION['my_userdata']['user_id'];

                        $events = $this->Betting_model->get_bettings_markets($user_id);

                        $totalRiskAmt = 0;
                        if (!empty($events)) {
                            foreach ($events as $event) {
                                if ($market_id !==  $event->market_id) {
                                    continue;
                                }

                                $bettings = $this->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $event->market_id));

                                if (!empty($bettings)) {
                                    if ($bettings->exposure_1 < 0) {
                                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'] = $bettings->exposure_1;
                        $exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'] = $totalLoss;
                                        $totalRiskAmt += $bettings->exposure_1;
                                    }

                                    if ($bettings->exposure_2 < 0) {
                                        $totalRiskAmt += $bettings->exposure_2;
                                    }
                                }
                            }
                        }

                        return $totalRiskAmt;
                        // $bettings = $this->Betting_model->count_total_exposure($user_id);
                        // $matches = array();


                        // if (!empty($bettings)) {
                        //     foreach ($bettings as $value) {

                        //         if($market_id !==  $value->market_id)
                        //         {
                        //             continue;
                        //         }
                        //         $mId = str_replace('.', '', $value->market_id);
                        //         $selectionId = $value->selection_id;

                        //         if ($value->is_back) {

                        //             $tmpProfit = isset($matches[$mId][$selectionId]['back']['profit']) ? $matches[$mId][$selectionId]['back']['profit'] : 0;

                        //             $tmpLoss = isset($matches[$mId][$selectionId]['back']['loss']) ? $matches[$mId][$selectionId]['back']['loss'] : 0;

                        //             $matches[$mId][$selectionId]['back'] = array(
                        //                 'profit' => $value->profit + $tmpProfit,
                        //                 'loss' => $value->loss  + $tmpLoss
                        //             );
                        //         } else {

                        //             $tmpProfit = isset($matches[$mId][$selectionId]['lay']['profit']) ? $matches[$mId][$selectionId]['lay']['profit'] : 0;

                        //             $tmpLoss = isset($matches[$mId][$selectionId]['lay']['loss']) ? $matches[$mId][$selectionId]['lay']['loss'] : 0;

                        //             $matches[$mId][$selectionId]['lay'] =  array(
                        //                 'profit' => $value->profit + $tmpProfit,
                        //                 'loss' => $value->loss  + $tmpLoss
                        //             );
                        //         }
                        //     }
                        // }

                        $totalProfit = 0;
                        $totalLoss = 0;

                        // foreach ($matches as $match) {
                        //     $i = 0;
                        //     foreach ($match as $key => $types) {
                        //         $i++;

                        //         if ($i == 1) {
                        //             foreach ($types as $k => $type) {

                        //                 if ($k == 'back') {
                        //                     $totalLoss -= $type['loss'];
                        //                     $totalProfit += $type['profit'];
                        //                 } else {
                        //                     //  p($totalProfit);

                        //                     // p($type['profit']);
                        //                     $totalLoss += $type['profit'];
                        //                     $totalProfit -= $type['loss'];

                        //                     // p('P'.$type['profit'],0);
                        //                     // p('L'.$type['loss'],0);

                        //                     // p($totalLoss,0);
                        //                     // p($totalProfit,0);
                        //                 }
                        //             }
                        //         } else {
                        //             foreach ($types as $k => $type) {

                        //                 if ($k == 'back') {
                        //                     $totalLoss += $type['profit'];
                        //                     $totalProfit -= $type['loss'];
                        //                 } else {
                        //                     //  p($totalProfit);

                        //                     // p($type['profit']);
                        //                     $totalLoss -= $type['profit'];
                        //                     $totalProfit += $type['loss'];

                        //                     // p('P'.$type['profit'],0);
                        //                     // p('L'.$type['loss'],0);

                        //                     // p($totalLoss,0);
                        //                     // p($totalProfit,0);

                        //                 }
                        //             }
                        //         }

                        //         // $totalProfit += $value
                        //     }
                        // }    

                        // $bettings = $this->Betting_model->get_last_bet(array('user_id'=> $user_id,'market_id'=> $event->market_id));

                        // if(!empty($bettings))
                        // {
                        //     if($bettings->exposure_1 < 0)
                        //     {
                        //         $totalRiskAmt += $bettings->exposure_1;
                        //     }

                        //     if($bettings->exposure_2 < 0)
                        //     {
                        //         $totalRiskAmt += $bettings->exposure_2;
                        //     }
                        // }

                        // $exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'] = $totalProfit;
                        // $exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'] = $totalLoss;

                        // p($exchangeData[$event_id]['market_types'][$market_id]['runners'][0]['exposure'],0);
                        // p($exchangeData[$event_id]['market_types'][$market_id]['runners'][1]['exposure'],0);


                    }



                    $fancy_data = $this->Event_model->get_fancy_data($list_event['event_id']);
                    $fantacyData[$list_event['event_id']] =  $fancy_data;
                }
            }
        }

        // p($exchangeData);

        $dataArray['events'] = $exchangeData;

        $fancy_data = $this->Event_model->get_fancy_data($event_id);
        $dataArray['fancy_data'] = $fancy_data;
        $dataArray['exchange_response'] = array();
        $exhangeHtml = compress_htmlcode($this->load->viewPartial('exchangeHtml', $dataArray));
        $data['exchangeHtml'] = $exhangeHtml;

        $data['fancyHtml'] =  compress_htmlcode($this->load->viewPartial('fancy-list-html', $dataArray));
        echo json_encode($data);
    }

    public function bettingList()
    {
        $market_id = $this->input->post('MarketId');
        $user_id = $_SESSION['my_userdata']['user_id'];
        $match_id = $this->input->post('matchId');


        $dataValues = array(
            'user_id' => $user_id,
            'match_id' => $match_id
        );


        $bettings = $this->Betting_model->get_bettings($dataValues);

        $dataArray['bettings'] = $bettings;
        $exhangeHtml = $this->load->viewPartial('betting-list-html', $dataArray);
        $data['bettingHtml'] = $exhangeHtml;

        $exposure = number_format(count_total_exposure($user_id), 2);
        $balance = number_format(count_total_balance($user_id), 2);

        $data['balance'] = $balance;
        $data['exposure'] = $exposure;

        echo json_encode($data);
    }


    public function savebet()
    {
        $user_id = $_SESSION['my_userdata']['user_id'];
        $balance = count_total_balance($user_id);
        $stake = $this->input->post('stake');

        if ($stake > $balance) {
            $dataArray = array(
                'success' => false,
                'message' => 'Insufficient Balance'
            );

            echo json_encode($dataArray);
            exit;
        }

        $user_details = $this->User_model->getUserById($user_id);

        if (!empty($user_details)) {
            if ($user_details->is_betting_open == 'No') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Betting Rights is closed'
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_details->is_locked == 'Yes') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Your account is locked by your superior.'
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_details->is_closed == 'Yes') {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Your account is closed by your superior.'
                );
                echo json_encode($dataArray);
                exit;
            }
        }

        $user_info = $this->User_info_model->get_user_info_by_userid($user_id);

        if (!empty($user_info)) {
            if ($user_info->min_stake > $stake) {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Min Stake allowed is: ' . $user_info->min_stake
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_info->max_stake < $stake) {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Max Stake allowed is: ' . $user_info->max_stake
                );
                echo json_encode($dataArray);
                exit;
            }

            if ($user_info->lock_bet ==  "Yes") {
                $dataArray = array(
                    'success' => false,
                    'message' => 'Betting Rights is locked'
                );

                echo json_encode($dataArray);
                exit;
            }
        }


        $dataArray = array(
            'match_id' => $this->input->post('matchId'),
            'selection_id' => $this->input->post('selectionId'),
            'is_back' => $this->input->post('isback'),
            'place_name' => $this->input->post('placeName'),
            'stake' => $this->input->post('stake'),
            'price_val' => $this->input->post('priceVal'),
            'p_l' => $this->input->post('p_l'),
            'market_id' => $this->input->post('MarketId'),
            'user_id' => $_SESSION['my_userdata']['user_id'],
            'betting_type' => $this->input->post('betting_type'),
            'profit' => $this->input->post('profit'),
            'loss' => $this->input->post('loss'),
            'exposure_1' => $this->input->post('exposure1'),
            'exposure_2' => $this->input->post('exposure2'),

        );

        // p($dataArray['exchange_response']);
        $betting_id =  $this->load->Betting_model->addBetting($dataArray);
        $stake = $this->input->post('stake');
        $new_amount = count_total_balance($_SESSION['my_userdata']['user_id']) - $stake = $this->input->post('stake');
        $type = $this->input->post('isback') == 1 ? 'Yes' : 'Not';
        $dataArray = array(
            'user_id' => $_SESSION['my_userdata']['user_id'],
            'remarks' => $this->input->post('placeName') . ' ' . $type,
            'transaction_type' => 'Hold',
            'type' => 'Betting',
            'amount' =>  $stake,
            'balance' => $new_amount
        );

        $this->load->Ledger_model->addLedger($dataArray);
        if ($betting_id) {
            $dataArray = array(
                'success' => true,
                'message' => 'Bet Placed Successfully'
            );
        } else {
            $dataArray = array(
                'success' => true,
                'message' => 'Something went wrong please try again.'
            );
        }
        echo json_encode($dataArray);
    }

    public function getfancydata1()
    {
        $fancy_data = get_fancy_by_id();
        $marketId = '1.172980694';

        $dataValues = array(
            'market_id' => $marketId,
            'response' => $fancy_data
        );

        $this->Fancy_data_model->addFancyData($dataValues);
    }

    public function getfancydata($bfid = null)
    {
        if ($bfid === null) {
            $bfid = 1.172980694;
        }

        $dataValues = array(
            'market_id' => $bfid
        );


        $fancyData = $this->Fancy_data_model->get_fancy_data($dataValues);

        $html = '';
        if (!empty($fancyData->response)) {
            $fancyData =  json_decode($fancyData->response);


            $dataArray['fancyData'] = $fancyData->LambiData;
            $html .= $this->load->viewPartial('fancy-list-html', $dataArray);
        }

        // echo $html;
        echo json_encode(array('fancyData' => $html));
    }


    public function addEventTypes()
    {
        $event_types =  json_decode(listEventTypes());

        if (!empty($event_types)) {
            foreach ($event_types as $event_type) {
                $dataArray = array(
                    'event_type' => $event_type->eventType,
                    'name' => $event_type->name,
                    'market_count' => $event_type->marketCount,
                );
                $this->Event_model->addEventType($dataArray);
            }
        }
    }

    public function getEventTypes()
    {
        return listEventTypes();
    }


    public function listCompetitions($sport_id = null)
    {
        $event_types = $this->Event_model->getEventTypes();

        if (!empty($event_types)) {
            foreach ($event_types as $event_type) {

                if ($event_type['event_type'] == 4) {
                    $competitions = json_decode(listCompetitions($event_type['event_type']));


                    if (!empty($competitions)) {
                        foreach ($competitions as $competition) {


                            $dataArray = array(
                                'event_type' => $event_type['event_type'],
                                'competition_id' => $competition->competition->id,
                                'competition_name' => $competition->competition->name,
                                'market_count' => $competition->marketCount,
                                'competition_region' => $competition->competitionRegion,
                            );

                            $this->Event_model->addCompetition($dataArray);
                        }
                    }
                }
            }
        }

        return listCompetitions($sport_id);
    }

    public function addEvents($sport_id = null)
    {
        $competitions = $this->Event_model->getCompetitions();


        if (!empty($competitions)) {
            foreach ($competitions as $competition) {

                if ($competition['event_type'] == 4) {
                    $events = json_decode(listEvents($competition['event_type'], $competition['competition_id']));

                    if (!empty($events)) {
                        foreach ($events as $event) {
                            $dataArray = array(
                                'competition_id' => $competition['competition_id'],
                                'event_type' => $competition['event_type'],
                                'event_id' => $event->event->id,
                                'event_name' => $event->event->name,
                                'country_code' => $event->event->countryCode,
                                'timezone' => $event->event->timezone,
                                'open_date' => $event->event->openDate,
                                'market_count' => $event->marketCount,
                                'scoreboard_id' => $event->scoreboard_id,
                                'selections' => $event->selections,
                                'liability_type' => $event->liability_type,
                                'undeclared_markets' => $event->undeclared_markets,
                            );
                            $this->Event_model->addEvents($dataArray);
                        }
                    }
                }
            }
        }
    }

    public function addMarketTypes($sport_id = null)
    {
        $events = $this->Event_model->getEvents();

        if (!empty($events)) {
            foreach ($events as $event) {

                $listMarketTypes = json_decode(listMarketTypes($event['event_id']));


                if (!empty($listMarketTypes)) {
                    foreach ($listMarketTypes as $market) {
                        $dataArray = array(
                            'event_id' => $event['event_id'],
                            'market_id' => $market->marketId,
                            'market_start_time' => $market->marketStartTime,
                            'total_matched' => $market->totalMatched,
                            'runner_1_selection_id' => $market->runners[0]->selectionId,
                            'runner_1_runner_name' => $market->runners[0]->runnerName,
                            'runner_1_handicap' => $market->runners[0]->handicap,
                            'runner_1_sort_priority' => $market->runners[0]->sortPriority,
                            'runner_2_selection_id' => $market->runners[0]->selectionId,
                            'runner_2_runner_name' => $market->runners[0]->runnerName,
                            'runner_2_handicap' => $market->runners[0]->handicap,
                            'runner_2_sort_priority' => $market->runners[0]->sortPriority,
                        );


                        $this->Event_model->addMarketTypes($dataArray);
                    }
                }
            }
        }
    }

    public function addMarketBookOdds($sport_id = null)
    {
        $market_types = $this->Event_model->getMarketTypes();
        if (!empty($market_types)) {
            foreach ($market_types as $market_type) {



                $listMarketBookOdds = json_decode(listMarketBookOdds($market_type['market_id']));

                // p($listMarketBookOdds,0);
                if (!empty($listMarketBookOdds)) {
                    foreach ($listMarketBookOdds as $listMarketBookOdd) {


                        $dataArray = array(
                            'market_id' => $market_type['market_id'],
                            'is_market_data_delayed' => $listMarketBookOdd->isMarketDataDelayed,
                            'status' => $listMarketBookOdd->status,
                            'bet_delay' => $listMarketBookOdd->betDelay,
                            'bsp_reconciled' => $listMarketBookOdd->bspReconciled,
                            'complete' => $listMarketBookOdd->complete,
                            'inplay' => $listMarketBookOdd->inplay,
                            'number_of_winners' => $listMarketBookOdd->numberOfWinners,
                            'number_of_runners' => $listMarketBookOdd->numberOfRunners,
                            'number_of_active_runners' => $listMarketBookOdd->numberOfActiveRunners,
                            'last_match_time' => $listMarketBookOdd->lastMatchTime,
                            'total_matched' => $listMarketBookOdd->totalMatched,
                            'total_available' => $listMarketBookOdd->totalAvailable,
                            'cross_matching' => $listMarketBookOdd->crossMatching,
                            'runners_voidable' => $listMarketBookOdd->runnersVoidable,
                            'version' => $listMarketBookOdd->version,

                        );




                        $market_book_odd_id =  $this->Event_model->addMarketBookOdds($dataArray);

                        if ($market_book_odd_id) {
                            if (!empty($listMarketBookOdd->runners)) {
                                foreach ($listMarketBookOdd->runners as $runner) {
                                    $dataArray = array(
                                        'market_book_odd_id' => $market_book_odd_id,
                                        'market_id' => $market_type['market_id'],
                                        'event_id' => $market_type['event_id'],
                                        'selection_id' => $runner->selectionId,
                                        'handicap' => $runner->handicap,
                                        'status' => $runner->status,
                                        'last_price_traded' => $runner->lastPriceTraded,
                                        'total_matched' => $runner->totalMatched,
                                        'back_1_price' => isset($runner->ex->availableToBack[0]->price) ? $runner->ex->availableToBack[0]->price : '',
                                        'back_2_price' => isset($runner->ex->availableToBack[1]->price) ? $runner->ex->availableToBack[1]->price : '',
                                        'back_3_price' => isset($runner->ex->availableToBack[2]->price) ? $runner->ex->availableToBack[2]->price : '',
                                        'back_1_size' => isset($runner->ex->availableToBack[0]->size) ? $runner->ex->availableToBack[0]->size : '',
                                        'back_2_size' => isset($runner->ex->availableToBack[1]->size) ? $runner->ex->availableToBack[1]->size : '',
                                        'back_3_size' => isset($runner->ex->availableToBack[2]->size) ? $runner->ex->availableToBack[2]->size : '',
                                        'lay_1_price' => isset($runner->ex->availableToLay[0]->price) ? $runner->ex->availableToLay[0]->price : '',
                                        'lay_2_price' => isset($runner->ex->availableToLay[1]->price) ? $runner->ex->availableToLay[1]->price : '',
                                        'lay_3_price' => isset($runner->ex->availableToLay[2]->price) ? $runner->ex->availableToLay[2]->price : '',
                                        'lay_1_size' => isset($runner->ex->availableToLay[0]->size) ? $runner->ex->availableToLay[0]->size : '',
                                        'lay_2_size' => isset($runner->ex->availableToLay[1]->size) ? $runner->ex->availableToLay[1]->size : '',
                                        'lay_3_size' => isset($runner->ex->availableToLay[2]->size) ? $runner->ex->availableToLay[2]->size : '',
                                    );

                                    $this->Event_model->addMarketBookOddsRunners($dataArray);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function addMarketBookSession($match_id = null)
    {
        $market_types = $this->Event_model->getMarketTypes();


        if (!empty($market_types)) {
            foreach ($market_types as $market_type) {

                $listMarketBookSession = json_decode(listMarketBookSession($market_type['event_id']));


                if (!empty($listMarketBookSession)) {

                    if (!isset($listMarketBookSession->message)) {
                        foreach ($listMarketBookSession as $session) {
                            $dataArray = array(
                                'match_id' => $market_type['event_id'],
                                'selection_id' => $session->SelectionId,
                                'runner_name' => $session->RunnerName,
                                'lay_price1' => $session->LayPrice1,
                                'lay_size1' => $session->LaySize1,
                                'back_price1' => $session->BackPrice1,
                                'back_size1' => $session->BackSize1,
                                'game_status' => $session->GameStatus,
                                'mark_status' => $session->MarkStatus,

                            );
                            $this->Event_model->addMarketBookOddsFancy($dataArray);
                        }
                    }
                }
            }
        }
    }


    public function listEvents($EventTypeID = null, $CompetitionID = null)
    {
        return listEvents($EventTypeID, $CompetitionID);
    }

    public function listMarketTypes($EventID = null)
    {
        return listMarketTypes($EventID);
    }

    public function listMarketRunner($MarketID = null)
    {
        return listMarketRunner($MarketID);
    }

    public function listMarketBookOdds($market_id = null)
    {
        return listMarketBookOdds($market_id);
    }

    public function listMarketBookSession($match_id = null)
    {
        return listMarketBookSession($match_id);
    }

    public function getAllData()
    {
        // p('Hello');
        $event_types = $this->Event_model->getEventTypes();
        $this->sendresponse();


        if (!empty($event_types)) {
            foreach ($event_types as $event_type) {
                if ($event_type['event_type'] == 4) {
                    $competitions = json_decode(listCompetitions($event_type['event_type']));
                    if (!empty($competitions)) {
                        foreach ($competitions as $competition) {
                            $dataArray = array(
                                'event_type' => $event_type['event_type'],
                                'competition_id' => $competition->competition->id,
                                'competition_name' => $competition->competition->name,
                                'market_count' => $competition->marketCount,
                                'competition_region' => $competition->competitionRegion,
                                'is_active' => 'Yes'
                            );


                            $competitionExists = $this->Event_model->checkCompetitionExists($competition->competition->id);

                            if (!empty($competitionExists)) {
                                $dataArray['list_competition_id'] = $competitionExists->list_competition_id;
                            }




                            $competition_id = $competition->competition->id;
                            $list_competition_id = $this->Event_model->addCompetition($dataArray);

                            if ($list_competition_id) {
                                if ($event_type['event_type'] == 4) {
                                    $events = json_decode(listEvents($event_type['event_type'], $competition_id));


                                    if (!empty($events)) {

                                        foreach ($events as $event) {

                                            $dataArray = array(
                                                'competition_id' => $competition_id,
                                                'event_type' => $event_type['event_type'],
                                                'event_id' => $event->event->id,
                                                'event_name' => $event->event->name,
                                                'country_code' => $event->event->countryCode,
                                                'timezone' => $event->event->timezone,
                                                'open_date' => $event->event->openDate,
                                                'market_count' => $event->marketCount,
                                                'scoreboard_id' => $event->scoreboard_id,
                                                'selections' => $event->selections,
                                                'liability_type' => $event->liability_type,
                                                'undeclared_markets' => $event->undeclared_markets,
                                                'is_active' => 'Yes'

                                            );


                                            $eventExists = $this->Event_model->checkEventsExists($event->event->id);



                                            if (!empty($eventExists)) {
                                                $dataArray['list_event_id'] = $eventExists->list_event_id;
                                            }




                                            $list_event_id = $this->Event_model->addEvents($dataArray);


                                            if ($list_event_id) {
                                                $listMarketTypes = json_decode(listMarketTypes($event->event->id));


                                                if (!empty($listMarketTypes)) {
                                                    foreach ($listMarketTypes as $market) {
                                                        $dataArray = array(
                                                            'event_id' => $event->event->id,
                                                            'market_id' => $market->marketId,
                                                            'market_name' => $market->marketName,

                                                            'market_start_time' => $market->marketStartTime,
                                                            'total_matched' => $market->totalMatched,
                                                            'runner_1_selection_id' => $market->runners[0]->selectionId,
                                                            'runner_1_runner_name' => $market->runners[0]->runnerName,
                                                            'runner_1_handicap' => $market->runners[0]->handicap,
                                                            'runner_1_sort_priority' => $market->runners[0]->sortPriority,
                                                            'runner_2_selection_id' => $market->runners[1]->selectionId,
                                                            'runner_2_runner_name' => $market->runners[1]->runnerName,
                                                            'runner_2_handicap' => $market->runners[1]->handicap,
                                                            'runner_2_sort_priority' => $market->runners[1]->sortPriority,
                                                            'is_active' => 'Yes'

                                                        );


                                                        $checkMarketTypesExists = $this->Event_model->checkMarketTypesExists($market->marketId);
                                                        if (!empty($checkMarketTypesExists)) {
                                                            $dataArray['id'] = $checkMarketTypesExists->id;
                                                        }




                                                        $id = $this->Event_model->addMarketTypes($dataArray);

                                                        if ($id) {

                                                            $listMarketBookOdds = json_decode(listMarketBookOdds($market->marketId));




                                                            if (!empty($listMarketBookOdds)) {
                                                                foreach ($listMarketBookOdds as $listMarketBookOdd) {
                                                                    $dataArray = array(
                                                                        'market_id' => $market->marketId,
                                                                        'is_market_data_delayed' => $listMarketBookOdd->isMarketDataDelayed,
                                                                        'status' => $listMarketBookOdd->status,
                                                                        'bet_delay' => isset($listMarketBookOdd->betDelay) ? $listMarketBookOdd->betDelay : 0,
                                                                        'bsp_reconciled' => isset($listMarketBookOdd->bspReconciled) ? $listMarketBookOdd->bspReconciled : 0,
                                                                        'complete' => isset($listMarketBookOdd->complete) ? $listMarketBookOdd->complete : 0,
                                                                        'inplay' => isset($listMarketBookOdd->inplay) ? $listMarketBookOdd->inplay : 0,
                                                                        'number_of_winners' => isset($listMarketBookOdd->numberOfWinners) ? $listMarketBookOdd->numberOfWinners : 0,
                                                                        'number_of_runners' => isset($listMarketBookOdd->numberOfRunners) ? $listMarketBookOdd->numberOfRunners : 0,
                                                                        'number_of_active_runners' => $listMarketBookOdd->numberOfActiveRunners,
                                                                        'last_match_time' => $listMarketBookOdd->lastMatchTime,
                                                                        'total_matched' => $listMarketBookOdd->totalMatched,
                                                                        'total_available' => isset($listMarketBookOdd->totalAvailable) ? $listMarketBookOdd->totalAvailable : 0,
                                                                        'cross_matching' => isset($listMarketBookOdd->crossMatching) ? $listMarketBookOdd->crossMatching : 0,
                                                                        'runners_voidable' => isset($listMarketBookOdd->runnersVoidable) ? $listMarketBookOdd->runnersVoidable : 0,
                                                                        'version' => isset($listMarketBookOdd->version) ? $listMarketBookOdd->version : 0,
                                                                        'is_active' => 'Yes'

                                                                    );

                                                                    $bookOddExists = $this->Event_model->bookOddExists($market->marketId);

                                                                    if (!empty($bookOddExists)) {
                                                                        $dataArray['market_book_odd_id'] = $bookOddExists->market_book_odd_id;
                                                                    }




                                                                    $market_book_odd_id =  $this->Event_model->addMarketBookOdds($dataArray);



                                                                    if ($market_book_odd_id) {
                                                                        if (!empty($listMarketBookOdd->runners)) {
                                                                            foreach ($listMarketBookOdd->runners as $runner) {
                                                                                $dataArray = array(
                                                                                    'market_book_odd_id' => $market_book_odd_id,
                                                                                    'market_id' => $market->marketId,
                                                                                    'event_id' => $event->event->id,
                                                                                    'selection_id' => $runner->selectionId,
                                                                                    'handicap' => isset($runner->handicap) ? $runner->handicap : 0,
                                                                                    'status' => $runner->status,
                                                                                    'last_price_traded' => $runner->lastPriceTraded,
                                                                                    'total_matched' => $runner->totalMatched,
                                                                                    'back_1_price' => isset($runner->ex->availableToBack[0]->price) ? $runner->ex->availableToBack[0]->price : '',
                                                                                    'back_2_price' => isset($runner->ex->availableToBack[1]->price) ? $runner->ex->availableToBack[1]->price : '',
                                                                                    'back_3_price' => isset($runner->ex->availableToBack[2]->price) ? $runner->ex->availableToBack[2]->price : '',
                                                                                    'back_1_size' => isset($runner->ex->availableToBack[0]->size) ? $runner->ex->availableToBack[0]->size : '',
                                                                                    'back_2_size' => isset($runner->ex->availableToBack[1]->size) ? $runner->ex->availableToBack[1]->size : '',
                                                                                    'back_3_size' => isset($runner->ex->availableToBack[2]->size) ? $runner->ex->availableToBack[2]->size : '',
                                                                                    'lay_1_price' => isset($runner->ex->availableToLay[0]->price) ? $runner->ex->availableToLay[0]->price : '',
                                                                                    'lay_2_price' => isset($runner->ex->availableToLay[1]->price) ? $runner->ex->availableToLay[1]->price : '',
                                                                                    'lay_3_price' => isset($runner->ex->availableToLay[2]->price) ? $runner->ex->availableToLay[2]->price : '',
                                                                                    'lay_1_size' => isset($runner->ex->availableToLay[0]->size) ? $runner->ex->availableToLay[0]->size : '',
                                                                                    'lay_2_size' => isset($runner->ex->availableToLay[1]->size) ? $runner->ex->availableToLay[1]->size : '',
                                                                                    'lay_3_size' => isset($runner->ex->availableToLay[2]->size) ? $runner->ex->availableToLay[2]->size : '',
                                                                                    'is_active' => 'Yes'

                                                                                );






                                                                                $checkMarketBookOddsRunners = $this->Event_model->checkMarketBookOddsRunners($runner->selectionId, $market->marketId);

                                                                                if (!empty($checkMarketBookOddsRunners)) {
                                                                                    $dataArray['id'] = $checkMarketBookOddsRunners->id;
                                                                                }

                                                                                echo $event->event->id;
                                                                                if ($event->event->id == '30043111') {
                                                                                    // p($checkMarketBookOddsRunners,0);

                                                                                    // p($runner->selectionId,0);

                                                                                    // p($dataArray,0);

                                                                                    if ($event->event->id != '30043111') {
                                                                                        exit;
                                                                                    }



                                                                                    // echo $event->event->id;
                                                                                    // p($listMarketBookOdds);
                                                                                    // exit;
                                                                                }


                                                                                $exchange_id = $this->Event_model->addMarketBookOddsRunners($dataArray);
                                                                                // if($event->event->id == '30035332')
                                                                                // {   
                                                                                //     p($dataArray);
                                                                                //     echo $event->event->id;
                                                                                //     p($listMarketBookOdds);
                                                                                //     exit;
                                                                                // }
                                                                                if ($exchange_id) {
                                                                                    $listMarketBookSession = json_decode(listMarketBookSession($event->event->id));


                                                                                    if (!empty($listMarketBookSession)) {

                                                                                        if (!isset($listMarketBookSession->message)) {

                                                                                            foreach ($listMarketBookSession as $session) {


                                                                                                if (isset($session->SelectionId) && isset($session->RunnerName) && isset($session->LayPrice1)) {

                                                                                                    $dataArray = array(
                                                                                                        'match_id' => $event->event->id,
                                                                                                        'selection_id' => $session->SelectionId,
                                                                                                        'runner_name' => $session->RunnerName,
                                                                                                        'lay_price1' => $session->LayPrice1,
                                                                                                        'lay_size1' => $session->LaySize1,
                                                                                                        'back_price1' => $session->BackPrice1,
                                                                                                        'back_size1' => $session->BackSize1,
                                                                                                        'game_status' => $session->GameStatus,
                                                                                                        'mark_status' => $session->MarkStatus,
                                                                                                        'is_active' => 'Yes'

                                                                                                    );




                                                                                                    $bookOddsFancyExists = $this->Event_model->bookOddsFancyExists($session->SelectionId);

                                                                                                    if (!empty($bookOddsFancyExists)) {
                                                                                                        $dataArray['id'] = $bookOddsFancyExists->id;
                                                                                                    }


                                                                                                    $this->Event_model->addMarketBookOddsFancy($dataArray);
                                                                                                }


                                                                                                // $this->sendresponse();
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
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function sendresponse()
    {
        $data = array();
        $list_events = $this->Event_model->list_events($data);




        $exchangeData = array();
        $fantacyData = array();
        if (!empty($list_events)) {

            foreach ($list_events as $key => $list_event) {
                $event_id = $list_event['event_id'];
                $exchangeData[$event_id] = $list_event;
                $market_types = $this->Event_model->list_market_types(array('event_id' => $list_event['event_id']));

                if (!empty($market_types)) {

                    foreach ($market_types as $market_type) {
                        $market_id = $market_type['market_id'];
                        $exchangeData[$event_id]['market_types'][$market_id] = $market_type;
                        $runners = $this->Event_model->list_market_book_odds_runner(array(
                            'event_id' => $list_event['event_id'],
                            'market_id' => $market_type['market_id'],
                        ));
                        $exchangeData[$event_id]['market_types'][$market_id]['runner'] = $runners;
                    }
                }

                $fancy_data = $this->Event_model->get_fancy_data($list_event['event_id']);
                $fantacyData[$list_event['event_id']] =  $fancy_data;
            }
        }


        $postdata = json_encode($exchangeData);

        $url = 'http://365exchange.vip:3000/';
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

        sendfancyresponse($fantacyData);
        print_r($result);
    }
}
