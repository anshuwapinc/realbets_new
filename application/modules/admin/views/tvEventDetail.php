<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?php echo base_url() ?>assets/app/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/app/font-awesome.min.css?version=1635691263" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <!-- Custom Theme Style -->

    <link href="<?php echo base_url() ?>assets/app/tvstyle.css?key=<?php echo time(); ?>" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="<?php echo base_url() ?>assets/app/pnotify.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/exchange/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/app/bootbox.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/exchange/aes.js"></script>
    <script src="<?php echo base_url(); ?>assets/exchange/aes-json-format.js"></script>
    <script src="<?php echo base_url(); ?>assets/exchange/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/exchange/serialize_json.js"></script>

    <link type="text/css" href="<?php echo base_url(); ?>assets/exchange/jquery.countdown.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/exchange/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>assets/app/jquery.dataTables.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/app/aes.js"></script>
    <script src="<?php echo base_url(); ?>assets/app/aes-json-format.js"></script>

    <script src="<?php echo base_url(); ?>assets/app/js.cookie.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="<?php echo base_url() ?>assets/plugins/validation/jquery.validate.min.js?1638536882"></script>

    <script src="<?php echo base_url() ?>assets/app/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/app/pnotify.js"></script>
    <script src="<?php echo base_url() ?>assets/app/menu.js"></script>
    <script src="<?php echo base_url() ?>assets/app/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/app/owl.carousel.js"></script>
    <script src="<?php echo base_url() ?>assets/app/slick.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/app/custom.js"></script> -->
    <script src="<?php echo base_url() ?>assets/exchange/custom.js"></script>

    <script>
        var base_url = '<?php echo base_url(); ?>';

        setInterval(function() {
            if (window.innerHeight > window.innerWidth) {
                $('#panel-body').hide();
                $('#landscapeErrorShow').show();
                $('#landscapeErrorShow1').show();
                $('#landscapeErrorShow2').show();

                // alert("Please use Landscape!");
            } else {
                $('#landscapeErrorShow').hide();
                $('#landscapeErrorShow1').hide();

                $('#landscapeErrorShow2').hide();


                $('#panel-body').show();
            }

        }, 400);
    </script>
    <script>
        let BLOCKED = false;
        var socket = io('<?php echo get_ws_endpoint(); ?>', {
            transports: ['websocket'],
            rememberUpgrade: false
        });
        var superior_arr = <?php echo json_encode(get_superior_arr(get_user_id(), get_user_type())); ?>;


        function submit_update_chip() {

            var datastring = $("#stockez_add").serializeJSON();

            $.ajax({
                type: "post",
                url: '<?php echo base_url(); ?>admin/Chip/update_user_chip',
                data: datastring,
                cache: false,
                dataType: "json",
                success: function success(output) {

                    if (output.success) {
                        $("#divLoading").show();
                        $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                        $("#divLoading").fadeOut(3000);
                        new PNotify({
                            title: 'Success',
                            text: output.message,
                            type: 'success',
                            styling: 'bootstrap3',
                            delay: 1000
                        });
                        location.reload();
                    } else {
                        $("#divLoading").show();
                        $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                        $("#divLoading").fadeOut(3000);
                        new PNotify({
                            title: 'Error',
                            text: output.message,
                            type: 'error',
                            styling: 'bootstrap3',
                            delay: 1000
                        });
                    }
                }
            });
        }

        console.log('socket', socket);
    </script>

</head>

<body id="windowBody">

    <?php
    // if (!empty($live_tv_url)) { 
    ?>

    <div id="landscapeErrorShow" style="display:none;font-size:15px;position: absolute;
    top: 40%;
    left: 0;
    right: 0;text-align:center;">Please change screen orientation to landscape mode</div>
    <div id="landscapeErrorShow1" style="display:none;font-size:15px;position: absolute;
    top: 50%;
    left: 0;
    right: 0;text-align:center;">कृपया अपने फोन को दाएं या बाएं घुमाये ।।।</div>
    <div id="landscapeErrorShow2" style="display:none;font-size:15px;position: absolute;
    top: 60%;
    left: 0;
    right: 0;text-align:center;">કૃપા ફોનને આડો કરો</div>

    <div class="panel-body" id="panel-body" style="padding:0px;display:none;">

        <div>

            <div class="mid-btn">

                <div class="dropdown">
                    <button class="btn btn-success btn-sm " href="#" style="margin-left:5px;" id="goToFull" onclick="goToFull()"><i class="fa fa-expand" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-success  btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <a class="dropdown-item" href="#" onclick="getBets('<?php echo $exchangeData['event_id']; ?>','Match',`<?php echo $tmp_market_id; ?>` )">Bets</a>


                        <a class="dropdown-item" href="#" onclick="getUnmatchBets('<?php echo $exchangeData['event_id']; ?>','Match',`<?php echo $tmp_market_id; ?>` )">Unmatch Bets</a>



                        <?php


                        if (get_user_type() != 'User') { ?>
                            <a class="dropdown-item" href="#" onclick="fetchMatchOddsPositionList('<?php echo $exchangeData['event_id']; ?>' ,`<?php echo $tmp_market_id; ?>`)" style="">Book</a>
                        <?php }
                        ?>

                    </div>
                </div>


                <?php

                if (get_user_type() == 'Admin') { ?>
                    <?php

                    // p($is_ball_running);
                    if ($is_ball_running == 'Yes') { ?>
                        <button class="btn btn-success btn-sm bu-btn " href="#" onclick="changeBallRunningStatus()" id="changeStatus" data-event-id="<?php echo $event_id; ?>" data-status="Yes">Un-Block</button>

                    <?php } else { ?>
                        <button class="btn btn-success btn-sm bu-btn" href="#" onclick="changeBallRunningStatus()" id="changeStatus" data-event-id="<?php echo $event_id; ?>" data-status="No">Block</button>

                    <?php } ?>
                <?php }

                ?>

            </div>

            <div class="match-odds-container" style="">



                <?php

                if (!empty($exchangeData)) {
                    $market_types = $exchangeData['market_types'];
                    if (!empty($market_types)) {
                        foreach ($market_types as $market_type) {
                            if ($market_type['market_name'] == 'Match Odds') { ?>




                                <div class="tabel-scroll-4 matchOpenBox_<?php echo str_replace('.', '', $market_type['market_id']); ?>" style="">


                                    <div class="market-listing-table   <?php echo str_replace('.', '', $market_type['market_id']); ?>  matchTable<?php echo str_replace('.', '', $market_type['market_id']); ?>    " id="matchTable<?php echo $exchangeData['event_id']; ?>" style="">




                                        <div class="matchoddsdiv">


                                            <?php

                                            $runners = $market_type['runners'];

                                            if (!empty($runners)) {
                                                foreach ($runners as $runner) {
                                                    // p($runner);
                                            ?>
                                                    <div id="user_row " class="odds_rows runner-row-<?php echo $runner['selection_id']; ?> matchOpenBox_<?php echo str_replace('.', '', $market_type['market_id']); ?>_<?php echo $runner['selection_id']; ?>">
                                                        <div class="events_odds">
                                                            <div class="event-name" id="runnderName0">

                                                                <div class="team-details">
                                                                    <div class="horce-pop-team"> <i class="fas fa-chart-bar"></i><?php echo substr($runner['runner_name'], 0, 7); ?>...</div>
                                                                </div>

                                                            </div>
                                                            <div class="valuename">
                                                                <?php

                                                                $exposure = $runner['exposure'];
                                                                if ($exposure < 0) { ?>
                                                                    <span class="runner_amount" style="color:#FF0088;" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo  str_replace('-', '', $exposure); ?></span>
                                                                <?php } else { ?>
                                                                    <span class="runner_amount" style="color:#97DC21" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo abs($exposure); ?></span>
                                                                <?php  }

                                                                ?>
                                                                <input type="hidden" class="position_<?php echo  str_replace('.', '', $runner['market_id']); ?>" id="selection_<?php echo $runner['sort_priority']; ?>" data-id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>" value="<?php echo $exposure; ?>">


                                                            </div>
                                                        </div>

                                                        <div class="odds_group">

                                                            <div class="backbattingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                                <div class=" back betting-blue mark-back 10301_0availableToBack0_price_1190470587 ">
                                                                    <strong class="priceRate odds ng-binding" id="availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['back_1_price']); ?></strong>
                                                                    <div style="display:none;" class="size">
                                                                        <span class="ng-binding" id="availableToBack1_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['back_1_size']); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--- availableToLay -->

                                                            <div class="laybettingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                                <div class="lay betting-pink mark-lay ">
                                                                    <strong class="priceRate odds ng-binding" id="availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['lay_1_price']); ?></strong>
                                                                    <div style="display:none;" class="size">
                                                                        <span class="ng-binding" id="availableToLay1_size_<?php echo isset($market_type['market_id']) ? str_replace('.', '', $market_type['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['lay_1_size']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }
                                            }
                                            ?>










                                        </div>
                                        <div class="market-msg" style="color:#FF0088;"></div>

                                        <div class="matchOpenBoxBet_<?php echo str_replace('.', '', $market_type['market_id']); ?>"></div>
                                    </div>
                                </div>
                <?php    }
                        }
                    }
                }
                ?>


                <div class="fancy-container fancyAPI">

                </div>
            </div>

            <div id="fancyposition" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="popup_form">
                            <div class="title_popup">
                                <span> Fancy Position</span>
                                <button type="button" class="close" data-dismiss="modal">
                                    <div class="close_new"><i class="fa fa-times-circle"></i> </div>
                                </button>
                            </div>
                            <div class="content_popup">
                                <div class="popup_form_row">
                                    <div class="modal-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="matchposition" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="popup_form">
                            <div class="title_popup">
                                <span> Match Position</span>
                                <button type="button" class="close" data-dismiss="modal">
                                    <div class="close_new"><i class="fa fa-times-circle"></i> </div>
                                </button>
                            </div>
                            <div class="content_popup">
                                <div class="popup_form_row">
                                    <div class="modal-body" id="all-profit-loss-data">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="openbets" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="popup_form">
                            <div class="title_popup" style="margin-bottom:0px;">
                                <span> Open Bets</span>
                                <button type="button" class="close" data-dismiss="modal">
                                    <div class="close_new"><i class="fa fa-times-circle"></i> </div>
                                </button>
                            </div>
                            <div class="content_popup">
                                <div class="popup_form_row">
                                    <div class="modal-body" style="overflow-x:auto;padding:0px;overflow-y:auto;padding:0px;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="betSlipBox" style="">
                <div class="betBox bet-slip-box" style="display: none;">
                    <span id="msg_error"></span><span id="errmsg"></span>
                    <div class="loaderback loadering" style="display: none;">
                        <div class="lds-dual-ring">
                        </div>
                    </div>
                    <audio id="myAudio">
                        <source src="<?php echo base_url(); ?>assets/images/beep.mp3" type="audio/mpeg">
                    </audio>
                    <form method="POST" id="placeBetSilp"><input type="hidden" name="compute" value="715c2e46276cee429d5de10eca9b3ccb">
                        <div class="bet-box_inner">
                            <div class="profit_loss-head">
                                <div class="items">
                                    <span class="stake_label">Bet for</span>
                                    <div id="ShowRunnderName" style="font-weight:bold;">
                                        <span class="close_btn"><i class="fas fa-times-circle"></i></span>
                                    </div>
                                </div>
                                <div class="items profit" id=" ">
                                    <span class="stake_label">Profit</span>
                                    <div class="stack_input_field">
                                        <span id="profitData" style="color:rgb(0, 124, 14);font-weight:bold"> 0.00</span>
                                    </div>
                                </div>
                                <div class="items profit" id=" ">
                                    <span class="stake_label">Loss</span>
                                    <div class="stack_input_field">
                                        <span id="LossData" style="color:rgb(255, 0, 0);font-weight:bold"> 0.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="inner-bet-section">
                                <div class="oddds-stake-box">
                                    <div class="items odds">
                                        <div class="stack_input_field numbers-row">
                                            <input type="number" step="0.01" id="ShowBetPrice" class="calProfitLoss odds-input form-control  CommanBtn">
                                        </div>
                                    </div>
                                    <div class="items stake" id=" ">
                                        <div class="stack_input_field numbers-row">
                                            <input type="number" pattern="[0-9]*" step=1 id="stakeValue" class="calProfitLoss stake-input form-control  CommanBtn">
                                            <input type="hidden" name="selectionId" id="selectionId" value="" class="form-control">
                                            <input type="hidden" name="matchId" id="matchId" value="" class="form-control">
                                            <input type="hidden" name="isback" id="isback" value="" class="form-control">
                                            <input type="hidden" name="MarketId" id="MarketId" value="" class="form-control">
                                            <input type="hidden" name="betting_type" id="betting_type" value="" class="form-control">
                                            <input type="hidden" name="event_type" id="event_type" value="<?php echo $event_type; ?>" class="form-control">
                                            <input type="hidden" name="placeName" id="placeName" value="" class="form-control">
                                            <input type="hidden" name="text" id="stackcount" value="0" class="form-control">
                                            <input type="hidden" name="text" id="isfancy" value="0" class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="bet-btns">
                                    <?php

                                    if (!empty($chips)) {
                                        foreach ($chips as $key => $chip) { ?>
                                            <div class="btn brt_btn"><button class=" chipName7" type="button" value="<?php echo $chip['chip_value']; ?>" onclick="StaKeAmount(this);"><?php echo $chip['chip_name']; ?></button></div>
                                    <?php }
                                    }
                                    ?>

                                    <div class="btn brt_btn"><button class=" " type="button" onclick="ClearStack( );">Clear</button></div>
                                </div>
                                <div class="bet-box-footer">
                                    <button class="btn cancle-bet" type="button" onclick="ClearAllSelection();"> Cancel</button>
                                    <button class="btn place-bet" type="button" onclick="PlaceBet();"> Place Bet</button>
                                    <!-- <button class="btn multi-bet" type="button" onclick="PlaceMultiBet();"> Place Multiple Bet</button> -->
                                    <!-- <button class="btn btn-success CommanBtn placefancy" type="button" onclick="PlaceBet();" style="display:none"> Place Bet</button> -->
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" frameborder="0" style="height: calc(100vh); width: calc(100vw);" scrolling="auto"></iframe>
        </div>
    </div>

    <?php //}

    ?>

    <script>
        var a = 0;
        var b = 0;
        var betSlip;
        var isMarketSelected;
        var active_event_id;
        var superiors = <?php echo $superiors; ?>;


        $(document).ready(function() {
            let userName = "<?php echo get_user_name(); ?>";
            let room = "<?php echo $event_id; ?>";
            let ID = "";
            //send event that user has joined room
            socket.emit("join_room", {
                username: userName,
                roomName: room
            });



            <?php


            if (isset($_GET['match_id']) && isset($_GET['market_id'])) { ?>
                MarketSelection(<?php echo $_GET['market_id']; ?>, <?php echo $_GET['match_id']; ?>, "<?php echo isset($_GET['event_type']) ? $_GET['event_type'] : null; ?>");
            <?php } ?>



            socket.on('<?php
                        if ($event_type == 4) {
                            echo "cricket_market_update";
                        } else if ($event_type == 2) {
                            echo "tennis_market_update";
                        } else if ($event_type == 1) {
                            echo "soccer_market_update";
                        }
                        ?>', function(data) {
                //events   
                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";
                // if (MarketId) {
                // var market = data.marketodds[matchId]

                // console.log('MARKET UPDATE',new Date());
                if (data.marketodds.length > 0) {

                    var market = data.marketodds.find(o => o.event_id == matchId);

                    if (market) {
                        market.is_ball_running = BLOCKED ? 'Yes' : market.is_ball_running;

                        if (market.market_types.length > 0) {

                            $.each(market.market_types, function(index, market_type) {
                                $.each(market_type.runners, function(index, runner) {
                                    if (runner.status == 'OPEN' || runner.status == 'ACTIVE') {

                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                    } else {


                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');

                                        $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                    }

                                    //  if (j == 0) {

                                    ///*************Available To Bck */
                                    // $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent()[0].closest( "h6" ).remove();

                                    $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();
                                    if (runner.status == 'SUSPENDED' || market.is_ball_running == 'Yes') {



                                        if (market.is_ball_running == 'Yes') {
                                            ClearAllSelection(1);

                                        }


                                        // $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");

                                        if (market.is_ball_running == 'Yes') {


                                            <?php
                                            if ($event_type == 4) { ?>
                                                $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>Ball Running</h6>");
                                            <?php  } else { ?>
                                                $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            <?php } ?>



                                        } else {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                        }


                                        if (parseFloat($('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_3_price)) {
                                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }


                                        if (parseFloat($('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_2_price)) {
                                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }

                                        if (parseFloat($('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_1_price)) {
                                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }


                                        if (parseFloat($('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_1_price)) {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }

                                        if (parseFloat($('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_2_price)) {
                                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }

                                        if (parseFloat($('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_3_price)) {
                                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);

                                        } else {
                                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(0);
                                        }

                                    } else {
                                        if (parseFloat($('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_3_price)) {
                                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_3_price));

                                        } else {
                                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_3_price));
                                        }


                                        if (parseFloat($('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_2_price)) {
                                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_2_price));

                                        } else {
                                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_2_price));
                                        }

                                        if (parseFloat($('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_1_price)) {
                                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_1_price));

                                        } else {
                                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.back_1_price));
                                        }


                                        if (parseFloat($('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_1_price)) {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_1_price));

                                        } else {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_1_price));
                                        }

                                        if (parseFloat($('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_2_price)) {
                                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_2_price));

                                        } else {
                                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_2_price));
                                        }

                                        if (parseFloat($('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_3_price)) {
                                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_3_price));

                                        } else {
                                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(parseFloat(runner.lay_3_price));
                                        }

                                    }


                                    /************************Size */

                                    if (parseFloat($('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_3_size)) {
                                        $('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_size).parent().parent().removeClass('yellow');
                                    }


                                    if (parseFloat($('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_2_size)) {
                                        $('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_size).parent().parent().removeClass('yellow');
                                    }

                                    if (parseFloat($('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_1_size)) {
                                        $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_size).parent().parent().removeClass('yellow');
                                    }


                                    if (parseFloat($('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_1_size)) {
                                        $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_size).parent().parent().removeClass('yellow');
                                    }

                                    if (parseFloat($('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_2_size)) {
                                        $('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_size).parent().parent().removeClass('yellow');
                                    }

                                    if (parseFloat($('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_3_size)) {
                                        $('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_size).parent().parent().addClass('yellow');

                                    } else {
                                        $('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_size).parent().parent().removeClass('yellow');
                                    }


                                });
                            });
                        }
                    }

                }

            });

            socket.on('fancy_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";
                <?php

                if ($fancy_user_info->is_fancy_active == 'No') { ?>
                    return false;
                <?php } ?>

                if (matchId) {

                    if (data.fantacy.length > 0) {
                        var fancys = data.fantacy.find(o => o.event_id == matchId);
                        if (fancys) {
                            fancy_event = fancys;
                            fancys = fancys.fancy_data;

                            fancy_event.is_ball_running = BLOCKED ? 'Yes' : fancy_event.is_ball_running;
                            if (fancys.length) {
                                for (var j = 0; j < fancys.length; j++) {


                                    if (fancys[j].runner_name.indexOf('6 ') == 0 || fancys[j].runner_name.indexOf('10 ') == 0 || fancys[j].runner_name.indexOf('20 ') == 0 || fancys[j].runner_name.indexOf('15 ') == 0 || fancys[j].runner_name.indexOf('50 ') == 0) {




                                        if (!fancys[j].runner_name.includes(' bhav ')) {

                                            if (!fancys[j].runner_name.includes(' 2')) {



                                                if (fancys[j].cron_disable == 'Yes') {
                                                    // ClearAllSelection(1);


                                                    $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().parent().parent().parent().fadeOut();
                                                } else {
                                                    if (fancys[j]) {
                                                        var block_market_fancys = fancys[j].block_market;
                                                        var block_all_market_fancys = fancys[j].block_all_market;
                                                        // var block_market_fancys = [];
                                                        // var block_all_market_fancys = [];

                                                        var find_fancy_all_block = block_all_market_fancys.filter(element => {

                                                            return superiors.includes(element.user_id.toString())
                                                        });

                                                        if (find_fancy_all_block.length > 0) {
                                                            // ClearAllSelection(1);
                                                            $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().parent().parent().parent().fadeOut();



                                                        } else {

                                                            var find_fancy_block = block_market_fancys.filter(element => {

                                                                return superiors.includes(element.user_id.toString())
                                                            });

                                                            if (find_fancy_block.length > 0) {
                                                                // ClearAllSelection(1);
                                                                $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().parent().parent().parent().fadeOut();



                                                            } else {
                                                                $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().parent().parent().parent().fadeIn();
                                                                var fancyHtml = '';

                                                                if (!$('.fancy_' + fancys[j].selection_id).length) {

                                                                    fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236 fullrow margin_bottom fancybox" id="fancyLM_31057636">';

                                                                    fancyHtml += '<div class="fancy-rows list-item fancy_220239 f_m_31057636 f_m_undefined" data-id="220239">';
                                                                    fancyHtml += '<div class="event-sports event-sports-name"><input type="hidden" value="LM" class="fancyType220239"><input type="hidden" value="1.190470637" class="fancyMID220239">';
                                                                    fancyHtml += '<span  onclick="getPosition(' + fancys[j].selection_id + ')"  class="event-name fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name.substr(0, 11) + '...</span>';

                                                                    fancyHtml += '<div class="match_odds-top-left min-max-mobile dropdown">';

                                                                    // fancyHtml += '<span class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo base_url(); ?>assets/images/matchodds-info-icon.png" class="fancy-info-btn"></span>';
                                                                    fancyHtml += '<ul class="dropdown-menu">';
                                                                    fancyHtml += '<li> Min:undefined </li>';
                                                                    fancyHtml += '<li>Max:undefined</li>';
                                                                    fancyHtml += '</ul>';
                                                                    fancyHtml += '</div>';



                                                                    fancyHtml += '<span class="fancy-exp dot fancy_exposure_' + fancys[j].selection_id + ' ">0</span>';

                                                                    // fancyHtml += '<button class="btn btn-xs btn-info" onclick="getBets(`<?php echo $event_id; ?>`,`Fancy`,`' + fancys[j].selection_id + '`)">Bets</button>';


                                                                    fancyHtml += '<span class="fancy_exposure" id="fancy_lib220239"></span>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '<div class="fancy_div">';
                                                                    fancyHtml += '<div class="fancy_buttone">';
                                                                    fancyHtml += '<div class="fancy-lays bet-button lay mark-lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';
                                                                    fancyHtml += '<strong id="LayNO_' + fancys[j].selection_id + '" class=" fancy_lay_price_' + fancys[j].selection_id + '" >' + parseFloat(fancys[j].lay_price1) + '</strong>';
                                                                    fancyHtml += '<div style="display:none;" class="size">';
                                                                    fancyHtml += '<span id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</span>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '<div class="fancy-backs bet-button back mark-back"   onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';
                                                                    fancyHtml += '<strong id="BackYes_' + fancys[j].selection_id + '" class=" fancy_back_price_' + fancys[j].selection_id + '">' + parseFloat(fancys[j].back_price1) + '</strong>';
                                                                    fancyHtml += '<div style="display:none;" class="size">';
                                                                    fancyHtml += '<span id="YesValume_' + fancys[j].selection_id + '" class="disab-btn fancy_back_size_' + fancys[j].selection_id + '">' + fancys[j].back_size1 + '</span>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '<div class="show_msg_box_220239"></div>';
                                                                    fancyHtml += '</div>';
                                                                    fancyHtml += '<p class="fancy_message f_message220239"></p>';
                                                                    fancyHtml += '</div>';

                                                                    fancyHtml += '</div>';



                                                                    ////////



                                                                    // fancyHtml += '<div class="fullrow margin_bottom fancybox" block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236" data-id="31236">';

                                                                    // fancyHtml += '<ul class="sport-high fancyListDiv">';
                                                                    // fancyHtml += '<li>';
                                                                    // fancyHtml += '<div class="ses-fan-box">';
                                                                    // fancyHtml += '<table class="table table-striped  bulk_actions">';
                                                                    // fancyHtml += '<tbody>';
                                                                    // fancyHtml += '<tr class="session_content">';
                                                                    // fancyHtml += '<td><span class="fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name + '</span><b class="fancyLia' + fancys[j].selection_id + '"></b><p class="position_btn"></td>';


                                                                    // fancyHtml += '<td></td>';
                                                                    // fancyHtml += '<td></td>';

                                                                    // fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';

                                                                    // fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancys[j].selection_id + '" id="LayNO_' + fancys[j].selection_id + '">' + parseFloat(fancys[j].lay_price1) + '</button>';

                                                                    // fancyHtml += '<button id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</button></td>';

                                                                    // fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';

                                                                    // fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancys[j].selection_id + '" id="BackYes_' + fancys[j].selection_id + '">' + parseFloat(fancys[j].back_price1) + '</button>';

                                                                    // fancyHtml += '<button id="YesValume_' + fancys[j].selection_id + '" class="disab-btn fancy_back_size_' + fancys[j].selection_id + '">' + fancys[j].back_size1 + '</button>';
                                                                    // fancyHtml += '</td>';

                                                                    // fancyHtml += '<td>';
                                                                    // fancyHtml += '</td>';
                                                                    // fancyHtml += '<td>';
                                                                    // fancyHtml += '</td>';
                                                                    // fancyHtml += '</tr>';
                                                                    // fancyHtml += '</tbody>';
                                                                    // fancyHtml += '</table>';
                                                                    // fancyHtml += '</div>';
                                                                    // fancyHtml += '</li>';
                                                                    // fancyHtml += '</ul></div>';


                                                                    $('.fancyAPI').append(fancyHtml);
                                                                }

                                                                // if (fancys[j].back_price1 == 'Ball') {
                                                                //     $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                                                //     $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                                                //     $('.fancy_lay_price_' + fancys[j].selection_id).text(fancys[j].lay_price1);
                                                                //     $('.fancy_back_price_' + fancys[j].selection_id).text(fancys[j].back_price1);
                                                                //     $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                                                //     $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
                                                                // }
                                                                $(`#fancy_lay_${fancys[j].selection_id}`).parent().find('h6').remove();
                                                                if (fancys[j].game_status == 'Ball Running' || fancy_event.is_ball_running == 'Yes') {

                                                                    $(`#fancy_lay_${fancys[j].selection_id}`).parent().append("<h6>Ball Running</h6>");

                                                                    // $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                                                    // $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');

                                                                    $('.fancy_lay_price_' + fancys[j].selection_id).text("-");
                                                                    $('.fancy_back_price_' + fancys[j].selection_id).text('-');
                                                                    $('.fancy_lay_size_' + fancys[j].selection_id).text('Ball Running');
                                                                    $('.fancy_back_size_' + fancys[j].selection_id).text('Ball Running');
                                                                } else if (fancys[j].game_status == 'SUSPENDED') {
                                                                    $(`#fancy_lay_${fancys[j].selection_id}`).parent().append("<h6>SUSPENDED</h6>");
                                                                    // $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                                                    // $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');

                                                                    $('.fancy_lay_price_' + fancys[j].selection_id).text("-");
                                                                    $('.fancy_back_price_' + fancys[j].selection_id).text('-');
                                                                    $('.fancy_lay_size_' + fancys[j].selection_id).text('SUSPENDED');
                                                                    $('.fancy_back_size_' + fancys[j].selection_id).text('SUSPENDED');
                                                                } else if (fancys[j].back_price1 == 0) {
                                                                    $(`#fancy_lay_${fancys[j].selection_id}`).parent().append("<h6>SUSPENDED</h6>");

                                                                    $('.fancy_lay_price_' + fancys[j].selection_id).text('-');
                                                                    $('.fancy_back_price_' + fancys[j].selection_id).text('-');
                                                                    $('.fancy_lay_size_' + fancys[j].selection_id).text('SUSPENDED');
                                                                    $('.fancy_back_size_' + fancys[j].selection_id).text('SUSPENDED');
                                                                } else {
                                                                    $('.fancy_lay_price_' + fancys[j].selection_id).text(parseFloat(fancys[j].lay_price1));
                                                                    $('.fancy_back_price_' + fancys[j].selection_id).text(parseFloat(fancys[j].back_price1));
                                                                    $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                                                    $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
                                                                }
                                                            }
                                                        }




                                                    } else {
                                                        $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().parent().parent().parent().fadeIn();
                                                        var fancyHtml = '';

                                                        if (!$('.fancy_' + fancys[j].selection_id).length) {
                                                            fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236" data-id="31236">';

                                                            fancyHtml += '<ul class="sport-high fancyListDiv">';
                                                            fancyHtml += '<li>';
                                                            fancyHtml += '<div class="ses-fan-box">';
                                                            fancyHtml += '<table class="table table-striped  bulk_actions">';
                                                            fancyHtml += '<tbody>';
                                                            fancyHtml += '<tr class="session_content">';
                                                            fancyHtml += '<td><span class="fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name + '</span><b class="fancyLia' + fancys[j].selection_id + '"></b><p class="position_btn"></td>';


                                                            fancyHtml += '<td></td>';
                                                            fancyHtml += '<td></td>';

                                                            fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';

                                                            fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancys[j].selection_id + '" id="LayNO_' + fancys[j].selection_id + '" >' + parseFloat(fancys[j].lay_price1) + '</button>';

                                                            fancyHtml += '<button id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</button></td>';

                                                            fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';

                                                            fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancys[j].selection_id + '" id="BackYes_' + fancys[j].selection_id + '">' + parseFloat(fancys[j].back_price1) + '</button>';

                                                            fancyHtml += '<button id="YesValume_' + fancys[j].selection_id + '" class="disab-btn fancy_back_size_' + fancys[j].selection_id + '">' + fancys[j].back_size1 + '</button>';
                                                            fancyHtml += '</td>';

                                                            fancyHtml += '<td>';
                                                            fancyHtml += '</td>';
                                                            fancyHtml += '<td>';
                                                            fancyHtml += '</td>';
                                                            fancyHtml += '</tr>';
                                                            fancyHtml += '</tbody>';
                                                            fancyHtml += '</table>';
                                                            fancyHtml += '</div>';
                                                            fancyHtml += '</li>';
                                                            fancyHtml += '</ul></div>';

                                                            $('.fancyAPI').append(fancyHtml);
                                                        }
                                                        $(`#fancy_lay_${fancys[j].selection_id}`).parent().find('h6').remove();
                                                        if (fancys[j].game_status == 'Ball Running') {
                                                            $(`#fancy_lay_${fancys[j].selection_id}`).parent().append("<h6>Ball Running</h6>");
                                                            // $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                                            // $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');

                                                            $('.fancy_lay_price_' + fancys[j].selection_id).text("-");
                                                            $('.fancy_back_price_' + fancys[j].selection_id).text('-');
                                                            $('.fancy_lay_size_' + fancys[j].selection_id).text('Ball Running');
                                                            $('.fancy_back_size_' + fancys[j].selection_id).text('Ball Running');
                                                        } else {
                                                            $('.fancy_lay_price_' + fancys[j].selection_id).text(parseFloat(fancys[j].lay_price1));
                                                            $('.fancy_back_price_' + fancys[j].selection_id).text(parseFloat(fancys[j].back_price1));
                                                            $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                                            $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
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
            });



            socket.on('betting_placed', function(data) {

                let usersArr = data.betting_details.users;
                let user_id = <?php echo get_user_id(); ?>;

                if (usersArr.length > 0) {
                    if (usersArr.includes(user_id.toString())) {


                        setIntervalX(function() {
                            // fetchBttingList();
                            getFancysExposure();
                            getEventsMarketExpsure(<?php echo $event_id; ?>);
                        }, 2000, 2);






                        <?php

                        if (get_user_type() == 'Master') { ?>
                            //  fetchProfitLossList();
                        <?php   }

                        ?>
                    } else {

                    }
                }

            });



            socket.on('betting_settle', function(data) {

            });
        });


        $(function() {
            setTimeout(function() {
                // fetchBttingList()

            }, 1000);

            // fetchBttingList();



            // fetchMatchOddsPositionList();

        })


        function getValColor(val) {
            if (val == '' || val == null || val == 0) return '#000000';
            else if (val > 0) return '#007c0e';
            else return '#ff0000';
        }

        function getPosition(fancyid) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/Events/getPosition',
                data: {
                    // userId1: userId1,
                    fancyid: fancyid,
                    typeid: 2,
                    yesval: $("#BackYes_" + fancyid).text(),
                    noval: $("#LayNO_" + fancyid).text(),
                    event_id: <?php echo $event_id; ?>
                    // usertype: userType1,
                    // 'compute': Cookies.get('_compute')
                },
                type: "POST",
                success: function success(output) {
                    $("#fancyposition .modal-body").html(output);
                    $('#fancyposition').modal('toggle');
                }
            });
        }




        $(function() {
            socket.on('block_markets', function(data) {

                if (data) {
                    var superior_id = data.data.userId;
                    var IsPlay = data.data.IsPlay;
                    var Type = data.data.Type;
                    var fancyId = data.data.fancyId;
                    var marketId = data.data.marketId;
                    var matchId = data.data.matchId;
                    var sportId = data.data.sportId;
                    var userId = data.data.userId;
                    var usertype = data.data.usertype;



                    var checkSuperiorUser = superiors.includes(superior_id.toString())
                    if (checkSuperiorUser) {
                        if (IsPlay == 0) {
                            if (Type == 'Event') {

                                if (matchId == '<?php echo $event_id; ?>') {
                                    window.location.href = '<?php echo base_url(); ?>dashboard';
                                }

                            } else if (Type == 'Sport') {
                                if (sportId == '<?php echo $event_type; ?>') {
                                    window.location.href = '<?php echo base_url(); ?>dashboard';
                                }
                            } else if (Type == "Market") {
                                var rmMarketId = marketId.toString().replace('.', '');
                                $('.matchOpenBox_' + rmMarketId).parent().fadeOut();
                            } else if (Type == "AllFancy") {
                                $('.fancyAPI').html('');
                            } else if (Type == "Fancy") {
                                $('#fancy_lay_' + fancyId).parent().remove();
                            }

                        }

                    } else {}
                }
            });


            socket.on('score_update', function(data) {


                // var match_id = '<?php echo $event_id; ?>';







                // if (data.scores.event_id === match_id) {
                //     var match_score = data.scores.doc[0];

                //     if (match_score) {
                //         var currentInningsNumber = match_score.data.score.currentInningsNumber;
                //         var innings = match_score.data.score.innings;


                //         if (innings) {
                //             var inning = innings.find(o => o.inningsNumber == currentInningsNumber);
                //             var batsemenDatas = inning.batsmen.filter(o => o.active == true);
                //             var bowler = inning.bowlers.find(o => o.isActiveBowler == true);

                //             if (bowler) {
                //                 $('#score_bowler_name').text(bowler.bowlerName);

                //                 $('#score_bowler_o').text(bowler.overs);
                //                 $('#score_bowler_m').text(bowler.maidens);
                //                 $('#score_bowler_r').text(bowler.runs);
                //                 $('#score_bowler_w').text(bowler.wickets);
                //                 $('#score_bowler_eco').text('');
                //             }
                //             if (batsemenDatas) {
                //                 $.each(batsemenDatas, function(index, batsemen) {

                //                     if (index == 0) {
                //                         $('#score_batsman_a_name').text(batsemen.batsmanName);

                //                         $('#score_batsman_a_r').text(batsemen.runs);
                //                         $('#score_batsman_a_b').text(batsemen.balls);
                //                         $('#score_batsman_a_4s').text(batsemen.fours);
                //                         $('#score_batsman_a_6s').text(batsemen.sixes);
                //                         $('#score_batsman_a_sr').text('');
                //                     } else {
                //                         $('#score_batsman_b_name').text(batsemen.batsmanName);
                //                         $('#score_batsman_b_r').text(batsemen.runs);
                //                         $('#score_batsman_b_b').text(batsemen.balls);
                //                         $('#score_batsman_b_4s').text(batsemen.fours);
                //                         $('#score_batsman_b_6s').text(batsemen.sixes);
                //                         $('#score_batsman_b_sr').text('');
                //                     }
                //                 });
                //             }

                //             $('#score_window').show();
                //             $('#score_msg').text(match_score.data.score.matchCommentary);


                //         }
                //     }
                // }
            });

            socket.on('line_guru_score', function(data) {

                // return false;
                if (data.score.event_id == '<?php echo $event_id; ?>') {



                    // if (data.score.message != "Not Found!") {
                    //     $('#scoreboard-box').show();

                    // }
                    // $('#scoreboard-box').show();


                    var home = JSON.parse(data.score.result.home);



                    var batsman_a_detail = home.b1s.split(',');
                    var batsman_b_detail = home.b2s.split(',');


                    $('#score_player_1').html(home.p1 + ' ' + batsman_a_detail[0] + '(' + batsman_a_detail[1] + ')');
                    $('#score_player_2').html(home.p2 + ' ' + batsman_b_detail[0] + '(' + batsman_b_detail[1] + ')');

                    $('#score_player_3').html(home.bw);

                    $('#team_1_name').html(home.t1.f);
                    $('#team_2_name').html(home.t2.f);

                    if (home.i == "i1") {
                        $('.currunt_sc').html(home.i1.sc + '-' + home.i1.wk);
                        $('.currunt_over').html('(' + home.i1.ov + ')');

                        $('#team_1_status').addClass('active');
                        $('#team_2_status').removeClass('active');



                    } else if (home.i == "i2") {
                        $('.currunt_sc').html(home.i2.sc + '-' + home.i2.wk);
                        $('.currunt_over').html('(' + home.i2.ov + ')');

                        $('#team_2_status').addClass('active');
                        $('#team_1_status').removeClass('active');

                    }




                    $('#score_batsman_a_r').html(batsman_a_detail[0]);
                    $('#score_batsman_a_b').html(batsman_a_detail[1]);
                    $('#score_batsman_a_4s').html(batsman_a_detail[2]);
                    $('#score_batsman_a_6s').html(batsman_a_detail[3]);

                    $('#score_batsman_b_r').html(batsman_b_detail[0]);
                    $('#score_batsman_b_b').html(batsman_b_detail[1]);
                    $('#score_batsman_b_4s').html(batsman_b_detail[2]);
                    $('#score_batsman_b_6s').html(batsman_b_detail[3]);
                    var msg = home.cs.msg;
                    var msg1 = home.cs.msg;


                    if (msg == 'BR') {
                        msg = 'Ball Running';
                    } else if (msg == 'B') {
                        msg = 'Ball Running';
                    } else if (msg == 'W') {
                        msg = 'Wicket';
                    } else if (msg == 'OC') {
                        msg = 'Over Complete';
                    } else {
                        msg = msg1 + '';
                    }


                    $('#ball-status').html(msg);
                    // console.clear();

                    var team_a = '';
                    var team_b = '';

                    team_a += home.t1.n + ' ' + home.i1.sc + '-' + home.i1.wk + " (" + home.i1.ov + ")";
                    team_b += home.t2.n + ' ' + home.i2.sc + '-' + home.i2.wk + " (" + home.i2.ov + ")";

                    $('#team_a').html(team_a);
                    $('#team_b').html(team_b);

                    $('.commantry').html(home.cs.msg);
                    var pb = home.pb.split(',');


                    var balls_html = '<li><p>Over </p></li>';
                    if (pb.length > 0) {
                        for (let i = pb.length - 6; i < pb.length; i++) {


                            // text += cars[i] + "<br>";
                            if (i > 0) {
                                balls_html += '<li class="' + pb[i].toLowerCase() + '-color six-balls"><span>' + pb[i] + '</span></li>';

                            }
                        }
                        // text += cars[i] + "<br>";
                    }



                    $('#score-over').html(balls_html);
                }



            });
        })

        function tvChange(tv) {
            var tvUrl = 'http://marketsarket.in/premium/ltv' + tv + '.html';
            $('#tvPlayer').attr('src', tvUrl);

        }




        function showPosition() {
            $('#bettingView').hide();
            $('#fancy-positionView').hide();
            // $('.fancy-positondata').removeClass('active');

            $('#positionView').show();
            // $('.betdata').removeClass('active');

            $('.positondata').addClass('active');

        }


        function showFancyPosition() {
            $('#bettingView').hide();
            $('#positionView').hide();


            $('#fancy-positionView').show();
            // $('.betdata').removeClass('active');
            // $('.positondata').removeClass('active');

            $('.fancy-positondata').addClass('active');

        }

        function fetchMatchOddsPositionList(event_id = null, market_id = null, user_id = null) {

            if (!user_id) {
                user_id = '<?php echo get_user_id(); ?>';

            }

            // user_id = '<?php echo get_user_id(); ?>';
            var formData = {
                user_id: user_id,
                matchId: event_id,
                market_id: market_id,
            }
            $.ajax({
                url: "<?php echo base_url(); ?>admin/Events/fetchMatchOddsPositionList",
                data: formData,
                type: 'POST',
                dataType: 'json',
                async: false,
                success: function(output) {
                    $('#matchposition').modal('show');
                    $('#all-profit-loss-data').html(output.htmlData);
                }
            });
        }





        function getFancysExposure() {

            // return true;
            // if (!user_id) {
            //     user_id = $('#profit_loss_user_id').val();
            // }

            user_id = '<?php echo get_user_id(); ?>';
            var formData = {
                event_id: '<?php echo $event_id; ?>',
            }
            $.ajax({
                url: "<?php echo base_url(); ?>admin/Events/getFancysExposure",
                data: formData,
                type: 'POST',
                dataType: 'json',
                async: false,
                success: function(output) {

                    if (output) {
                        $.each(output, function(index, fancy) {

                            $('.fancy_exposure_' + index).text(Math.abs(fancy));
                            $('.fancy_exposure_' + index).attr('data-value', fancy);

                        })

                    }
                }
            });
        }

        function showTv() {
            // openFullscreen();
            // openFullscreen();

            if ($(window).width() < 780) {
                $('#collapseTwo').toggle();

            } else {
                var tvHtml = '<iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" style=""  frameBorder="0"></iframe>';

                var myWindow = window.open("", "<?php echo $event_name; ?>", "width=100%,height=calc(100vh)");


                myWindow.document.write(tvHtml);
            }






        }

        // setInterval(function() {

        //     iFrameResize({ log: true   }, '#tvPlayer')
        // },1000)



        function resizeIFrameToFitContent(iFrame) {

            // iFrame.width  = iFrame.contentWindow.document.body.scrollWidth;
            // iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
        }

        window.addEventListener('DOMContentLoaded', function(e) {

            var iFrame = document.getElementById('tvPlayer');

            resizeIFrameToFitContent(iFrame);


            // or, to resize all iframes:
            // var iframes = document.querySelectorAll("iframe");
            // for( var i = 0; i < iframes.length; i++) {
            //     resizeIFrameToFitContent( iframes[i] );
            // }
        })


        window.addEventListener('message', event => {
            // IMPORTANT: check the origin of the data! 

            if (event.origin.startsWith('http://your-first-site.com')) {
                // The data was sent from your site.
                // Data sent with postMessage is stored in event.data:
            } else {
                // The data was NOT sent from your site! 
                // Be careful! Do not use it. This else branch is
                // here just for clarity, you usually shouldn't need it.
                return;
            }
        });


        setTimeout(function() {
            getEventsMarketExpsure(<?php echo $event_id; ?>);

        }, 10000);

        function getEventsMarketExpsure(MatchId) {
            $.ajax({
                url: '<?php echo base_url(); ?>dashboard/getEventsMarketExpsure/' + MatchId,

                type: 'get',
                dataType: 'json',
                success: function(output) {

                    var markets = output;
                    $.each(markets, function(marketKey, marketsRunner) {
                        $.each(marketsRunner, function(runner_key, runner_value) {


                            marketKey = marketKey.replace('.', '');

                            if (runner_value < 0) {



                                $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "#FF0088");
                            } else {


                                $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "#97DC21");
                            }


                        });
                    })


                }
            });
        }

        function getOddValue(matchId, marketId, back_layStatus, placeName, elementId, selectionId, MarketTypes = '', target) {




            $("#ShowBetPrice.odds-input").attr("style", "color:#000 !important")
            var priceVal = $('#' + elementId).text();



            $('#betting_type').val('Match');
            <?php
            $user_type = $_SESSION['my_userdata']['user_type'];

            if ($user_type != 'User') { ?>
                return false;
            <?php }
            ?>
            $("#stakeValue").blur();
            if (back_layStatus != 0) {
                $("#placeBetSilp").css("background-color", "#a7d8fd");
            } else {
                $("#placeBetSilp").css("background-color", "#f9c9d4");
            }

            if (betSlip) {
                clearTimeout(betSlip);
                betSlip = null;
            }
            betSlip = setTimeout(function() {
                ClearAllSelection()
            }, 15000);

            var priceVal = parseFloat(priceVal);

            var bookmaker_id = $("#bookmaker_id").val();

            if (bookmaker_id == marketId) {


                priceVal = ((priceVal / 100) + 1).toFixed(2);

            }

            var MId = marketId.toString().replace('.', '');
            if (active_event_id) {
                matchId = active_event_id;
                marketId = active_event_id;
            }
            MatchMarketTypes = MarketTypes;

            // if (priceVal != '' && matchId != '' && back_layStatus != '' && placeName != '') {
            // if ($(window).width() < 780) {
            $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
            $(".betSlipBox .mod-header").show();

            // $(".betBox").insertAfter('.matchOpenBoxBet_' + MId);
            $(".matchoddsdiv").append($(".betBox"));
            $(".betBox").css("width", "70%");
            $(".betBox").css("right", "-59px");

            // if (gameType != 'market') {
            //    $("#betslip").insertAfter('.teenpatti-row');
            // } else {
            // $(".betBox").insertAfter('.matchOpenBoxBet_' + MId);
            // $(".betBox").insertAfter('#MatchOddInfo');

            // }
            // } else {


            //     $(".betSlipBox .mod-header").show();
            //     $(".betSlipBox").show();
            // }

            $(".placebet").show();
            $(".placefancy").hide();
            $(".betSlipBox").show();
            $(".matchBox").show();
            $("#ShowRunnderName").text(placeName);
            $("#ShowBetPrice").val(priceVal);
            $("#TempShowBetPrice").val(priceVal);

            $("#chkValPrice").val(priceVal);
            $("#selectionId").val(selectionId);
            $("#matchId").val(matchId);
            $("#MarketId").val(marketId);
            $("#isback").val(back_layStatus);
            $("#placeName").val(placeName);
            $("#isfancy").val(0);
            $("#ShowBetPrice").prop('disabled', false);
            if (back_layStatus == 1) {
                $("#pandlosstitle").text('Profit');
                $(".BetFor").text('Back (Bet For)');
            } else {
                $(".BetFor").text('Lay (Bet For)');
                $("#ppandlosstitleandlosstitle").text('Liability');
            }

            if ($(window).width() < 780) {
                $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
                $(".betSlipBox .mod-header").show();
                $(".betBox").show();
                // $(".betBox").insertAfter('.fancy_' + fancyid);
            } else {
                $(".betBox").show();
                $(".betSlipBox .mod-header").show();
            }
            ClearAllSelection(0);
        }

        function betfancy(matchid, fancyid, isback) {
            $("#ShowBetPrice.odds-input").attr("style", "color:#000 !important")
            <?php
            $user_type = $_SESSION['my_userdata']['user_type'];

            if ($user_type != 'User') { ?>
                return false;
            <?php }
            ?>
            var userType1 = 4;

            if (userType1 == 4) {
                if (isback == 1) {
                    $("#placeBetSilp").css("background-color", "#a7d8fd");
                } else {
                    $("#placeBetSilp").css("background-color", "#f9c9d4");
                }
                var inputno = parseInt($('#LayNO_' + fancyid).text());


                var inputyes = parseInt($('#BackYes_' + fancyid).text());
                var headname = $(".fancyhead" + fancyid).text();
                $('#selectionId').val(fancyid);
                $('#betting_type').val('Fancy');

                $("#stakeValue").focus();
                $('#stakeValue').val(0);
                $("#profitData").text(0);
                $("#LossData").text(0);
                $('#matchId').val(matchid);
                $('#isback').val(isback);
                $('#placeName').val(headname);
                $("#isfancy").val(fancyid);
                $("#ShowBetPrice").prop('disabled', true);


                if (isback == 0) {
                    $(".BetFor").text('Lay (Bet for)');
                    $("#pandlosstitle").text('Liability');
                    $("#ShowBetPrice").val(inputno);

                    var check_no_value = setInterval(function() {
                        var real_inputno = parseInt($('#LayNO_' + fancyid).text());

                        if (inputno != real_inputno) {
                            clearInterval(check_no_value);

                            ClearAllSelection(1);
                        }
                    }, 1000);

                } else {

                    var check_yes_value = setInterval(function() {

                        var real_inputyes = parseInt($('#BackYes_' + fancyid).text());


                        if (inputyes != real_inputyes) {
                            clearInterval(check_yes_value);

                            ClearAllSelection(1);

                        }

                    }, 1000);
                    $(".BetFor").text('Back (Bet for)');
                    $("#pandlosstitle").text('Profit');
                    $("#ShowBetPrice").val(inputyes);
                }
                $(".placebet").hide();
                $(".placefancy").show();
                $("#ShowRunnderName").text(headname);
                // if ($(window).width() < 780) {
                $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
                $(".betSlipBox .mod-header").show();
                $(".betBox").show();
                $(".betBox").insertAfter('.fancy-container')
                $(".betBox").css("float", "left")
                $(".betBox").css("left", "8vw")
                $(".betBox").css("width", "28vw");
                // $(".betBox").insertAfter('.fancy_' + fancyid);
                // } else {


                //     $(".betBox").show();
                //     $(".betSlipBox .mod-header").show();
                // }
            }
        }


        function StaKeAmount(stakeVal) {
            var stakeValue = parseFloat(stakeVal.value);
            var stakeVal = parseFloat($("#stakeValue").val());
            var t_stake = parseFloat(stakeValue + stakeVal);
            $("#stakeValue").val(t_stake);
            calc();
        }

        $('#stakeValue').keyup(function() {
            calc();
        })



        function calc() {
            var isfancy = $("#isfancy").val();
            var priceVal = parseFloat($("#ShowBetPrice").val());
            var t_stake = parseFloat($("#stakeValue").val());
            var isback = $("#isback").val();




            if (isfancy == 0) {
                // if (gameType == 'market') {
                //    if (MatchMarketTypes == 'M') {
                var pl = Math.round((priceVal * t_stake) / 100);

                //    } else {
                var pl = Math.round((priceVal * t_stake) - t_stake);
                //    }
                // } else {
                // var pl = Math.round((priceVal * t_stake) / 100);
                // }
                pl = parseFloat(pl.toFixed(2));
                if (isback == 1) {
                    $("#profitData").text(pl);
                    $("#LossData").text(t_stake);
                } else {
                    $("#LossData").text(pl);
                    $("#profitData").text(t_stake);
                }
                SetPosition(priceVal);
            } else {

                var inputno = parseInt($('#LayNO_' + isfancy).text());
                var inputyes = parseInt($('#BackYes_' + isfancy).text());
                var YesValume = parseFloat($("#YesValume_" + isfancy).text());
                var NoValume = parseFloat($("#NoValume_" + isfancy).text());
                var pl = parseFloat(t_stake);
                if (inputno == inputyes) {
                    if (isback == 1) {
                        $("#profitData").text((YesValume * pl / 100).toFixed(2));
                        $("#LossData").text(pl.toFixed(2));
                    } else {
                        $("#LossData").text((NoValume * pl / 100).toFixed(2));
                        $("#profitData").text(pl.toFixed(2));
                    }
                } else {
                    $("#profitData").text(pl.toFixed(2));
                    $("#LossData").text(pl.toFixed(2));
                }
            }
        }


        function SetPosition(priceVal) {
            var MarketId = $("#MarketId").val();
            var MId = MarketId.replace('.', '');
            var selectionId = $("#selectionId").val();
            var isback = $("#isback").val();
            var stake = parseFloat($("#stakeValue").val());






            //  var MatchMarketTypes = 'M';
            $(".position_" + MId).each(function(i) {
                var selecid = $(this).attr('data-id');
                var winloss = parseFloat($(this).val());
                var curr = 0;



                if (selectionId == selecid) {
                    if (isback == 1) {
                        if (MatchMarketTypes == 'M') {
                            curr = winloss + ((priceVal * stake) / 100);


                        } else {
                            curr = winloss + ((priceVal * stake) - stake);


                        }
                    } else {
                        if (MatchMarketTypes == 'M') {
                            curr = winloss + (-1 * parseFloat((priceVal * stake) / 100));


                        } else {

                            curr = winloss + (-1 * parseFloat((priceVal * stake) - stake));


                        }
                    }
                } else {
                    if (isback == 1) {
                        curr = winloss + (-1 * (stake));
                    } else {
                        curr = winloss + stake;
                    }
                }
                var currV = Math.round(curr);

                $("#" + selecid + "_maxprofit_loss_runner_" + MId).attr('data-val', currV)

                $("#" + selecid + "_maxprofit_loss_runner_" + MId).text(Math.abs(currV)).css('color', getValColor(currV));
            });
        }

        function ClearAllSelection(hide = 1) {
            $("#stakeValue").val(0);
            var MarketId = $("#MarketId").val();

            var MId = MarketId.replace('.', '');
            $(".position_" + MId).each(function(i) {
                var selecid = $(this).attr('data-id');

                var winloss = parseFloat($(this).val());
                $("#" + selecid + "_maxprofit_loss_runner_" + MId).text(Math.abs(winloss)).css('color', getValColor(winloss));
            });
            $("#profitData").text(0);
            $("#LossData").text(0);
            if (hide == 1) {
                $(".betBox").hide();
            } else {
                $(".betBox").show();
            }
        }

        function PlaceBet() {
            clearTimeout(betSlip);
            $(".loadering").show();
            var stake = parseFloat($("#stakeValue").val());
            var priceVal = parseFloat($("#ShowBetPrice").val());
            var MarketId = $("#MarketId").val();
            var matchId = $("#matchId").val();
            var betting_type = $("#betting_type").val();
            var event_type = $("#event_type").val();


            if (!$.isNumeric(priceVal) || priceVal < 1) {
                new PNotify({
                    title: 'Error',
                    text: 'Invalid stake/odds.',
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 1000
                });
                $("#stakeValue").val(0);
                $("#profitData").text('');
                $("#LossData").text('');
            } else if (matchId != '') {
                $(".loadering").show();

                $(".CommanBtn").attr("disabled", true);

                var MarketType = $("#MarketType").val();
                var stakeValue = parseInt($("#stakeValue").val());
                var P_and_l = (priceVal * stake) - stake;
                var profit = parseFloat($('#profitData').text());
                var loss = parseFloat($('#LossData').text());
                var TempShowBetPrice = parseFloat($('#TempShowBetPrice').val());


                var exposure1 = 0;
                var exposure2 = 0;

                if (betting_type == 'Match') {

                }

                if (betting_type == 'Match') {
                    $(".position_" + MarketId.replace('.', '')).each(function(i) {
                        var selecid = $(this).attr('data-id');

                        var exposureCount = $("#" + selecid + "_maxprofit_loss_runner_" + MarketId.replace('.', '')).attr('data-val');
                        // var currV = Math.round(curr);

                        if (i == 0) {
                            exposure1 = exposureCount;
                        } else if (i == 1) {
                            exposure2 = exposureCount;

                        }

                    });

                } else {
                    exposure1 = profit;
                    exposure2 = loss * -1;

                }


                var formData = {
                    selectionId: $("#selectionId").val(),
                    matchId: $("#matchId").val(),
                    isback: $("#isback").val(),
                    placeName: $("#placeName").val(),
                    // MatchName: $("#MatchName").val(),
                    stake: stake,
                    priceVal: priceVal,
                    p_l: P_and_l,
                    MarketId: MarketId.toString(),
                    MarketType: MarketType,
                    betting_type: betting_type,
                    profit: profit,
                    loss: loss,
                    exposure1: exposure1,
                    exposure2: exposure2,
                    event_type: event_type
                };
                setTimeout(function() {


                    $.ajax({
                        method: 'POST',
                        url: '<?php echo base_url(); ?>admin/Events/savebet',
                        data: formData,
                        dataType: 'json',
                        async: false,
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        beforeSend: function() {

                            // $(".loadering").show();
                        },
                        success: function(data) {
                            $(".loadering").hide();
                            var selectionId = $("#selectionId").val();

                            $(".CommanBtn").attr("disabled", false);
                            if (!data.success) {
                                ClearAllSelection(1);

                                new PNotify({
                                    title: 'Error',
                                    text: data.message,
                                    type: 'error',
                                    styling: 'bootstrap3',
                                    delay: 1000
                                });
                            } else {
                                if (betting_type == 'Match') {
                                    $(".position_" + MarketId.replace('.', '')).each(function(i) {
                                        var selecid = $(this).attr('data-id');

                                        var exposureCount = $("#" + selecid + "_maxprofit_loss_runner_" + MarketId.replace('.', '')).attr('data-val');

                                        $(this).val(exposureCount);


                                    });
                                }
                                ClearAllSelection(1);

                                var betting_details = {
                                    'bet_details': {},
                                    'users': superior_arr
                                }
                                socket.emit('betting_placed', {
                                    betting_details: betting_details
                                });
                                //  getFancyData();
                                new PNotify({
                                    title: 'Success',
                                    text: data.message,
                                    type: 'success',
                                    styling: 'bootstrap3',
                                    delay: 1000
                                });



                                setIntervalX(function() {
                                    // fetchBttingList();
                                    getFancysExposure();
                                    getEventsMarketExpsure(<?php echo $event_id; ?>);
                                }, 2000, 2);




                            }
                        },
                        error: function(jqXHR) {
                            ClearAllSelection(1);

                        }
                    });
                }, 0);
            } else {
                ClearAllSelection(1);

                new PNotify({
                    title: ' Error',
                    text: 'Some Thing Went worng',
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 1000
                });
                $("#stakeValue").val(0);
                $("#profitData").text('');
                $("#LossData").text('');
            }
        }

        function fetchBttingList() {

            var formData = {

                matchId: "<?php echo $event_id; ?>"
            }
            $.ajax({
                url: "<?php echo base_url(); ?>admin/Events/bettingList",
                data: formData,
                type: 'POST',
                dataType: 'json',
                success: function(output) {

                    <?php
                    if (get_user_type() != 'Operator') { ?>
                        $('.mWallet').html(output.balance);
                        $('.liability').html(output.exposure);
                    <?php   }

                    ?>

                    $('#all-betting-data').html(output.bettingHtml);
                    // $('#fancy-betting-data').html(output.bettingHtml);


                    // $("#all-betting-data .all-bet-slip").hide();
                    // $("#all-betting-data .match-bet-slip").show();


                    // $("#fancy-betting-data .all-bet-slip").hide();
                    // $("#fancy-betting-data .fancy-bet-slip").show();


                    var allLength = $('.all-bet-slip').length;

                    $('#cnt_row').text('(' + allLength + ')');

                    var matchLength = $('.match-bet-slip').length;
                    $('#cnt_row1').text('(' + matchLength + ')');

                    var fancyLength = $('.fancy-bet-slip').length;


                    $('#cnt_row3').text('(' + fancyLength + ')');
                    $("#pills-tab").find(".active").find("a").click();

                }
            });
        }



        function getBets(event_id, type, selection_id) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/Events/getBets',
                data: {
                    event_id: event_id,
                    type: type,
                    selection_id: selection_id,

                },
                type: "POST",
                dataType: "json",
                success: function success(output) {
                    $("#openbets .modal-body").html(output.bettingHtml);
                    $('#openbets').modal('toggle');
                }
            });
        }


        function getUnmatchBets(event_id, type, selection_id) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/Events/getUnmatchBets',
                data: {
                    event_id: event_id,
                    type: type,
                    selection_id: selection_id,

                },
                type: "POST",
                dataType: "json",
                success: function success(output) {
                    $("#openbets .modal-body").html(output.bettingHtml);
                    $('#openbets').modal('toggle');
                }
            });
        }


        //         function openFullscreen() {
        //     var elem = document.getElementById("tvPlayer");

        //     // document.getElementById("h5live-playerDiv");


        //   if (elem.requestFullscreen) {
        //     elem.requestFullscreen();
        //   } else if (elem.webkitRequestFullscreen) { /* Safari */
        //     elem.webkitRequestFullscreen();
        //   } else if (elem.msRequestFullscreen) { /* IE11 */
        //     elem.msRequestFullscreen();
        //   }
        // }
        function goFullscreen(id) {
            // Get the element that we want to take into fullscreen mode
            var element = document.getElementById(id);


            // These function will not exist in the browsers that don't support fullscreen mode yet, 
            // so we'll have to check to see if they're available before calling them.

            if (element.mozRequestFullScreen) {
                // This is how to go into fullscren mode in Firefox
                // Note the "moz" prefix, which is short for Mozilla.
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullScreen) {
                // This is how to go into fullscreen mode in Chrome and Safari
                // Both of those browsers are based on the Webkit project, hence the same prefix.
                element.webkitRequestFullScreen();
            }
            // Hooray, now we're in fullscreen mode!
        }


        //   setTimeout(function({}))

        function toggleFullscreen() {
            let elem = document.getElementById("panel-body");

            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {



                    alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // toggleFullscreen();

        function mKeyF11() {
            var e = new Event('keypress');
            e.which = 122; // Character F11 equivalent.
            e.altKey = false;
            e.ctrlKey = false;
            e.shiftKey = false;
            e.metaKey = false;
            e.bubbles = true;
            document.dispatchEvent(e);
        }
        // mKeyF11();

        function goToFull() {
            let iOSDevice = !!navigator.platform.match(/iPhone|iPod|iPad/);
            if ($("#goToFull i").hasClass("fa-compress")) {
                if (iOSDevice) {
                    document.exitFullscreen();

                } else {
                    document.exitFullscreen();
                }

                $("#goToFull i").removeClass("fa-compress").addClass("fa-expand")
            } else {
                if (iOSDevice) {
                    if (document.requestFullScreen) {
                        document.requestFullScreen();
                    } else if (document.webkitRequestFullScreen) {
                        document.webkitRequestFullScreen();
                    } else if (document.mozRequestFullScreen) {
                        document.mozRequestFullScreen();
                    } else if (document.msRequestFullscreen) {
                        document.msRequestFullscreen();
                    } else if (document.webkitEnterFullscreen) {
                        document.webkitEnterFullscreen(); //for iphone this code worked
                    }
                } else {
                    document.documentElement.webkitRequestFullscreen();
                }



                $("#goToFull i").removeClass("fa-expand").addClass("fa-compress")
            }

        }




        function changeBallRunningStatus() {
            var event_id = $('#changeStatus').attr('data-event-id');
            var status = $('#changeStatus').attr('data-status');

            // var allfancyies = document.getElementsByClassName("lay");
            $('.lay').each(function(index, value) {
                if ($(this).hasClass('fancy-lays')) {
                    if (status == 'No') {
                        $(this).parent().append("<h6>Ball Running</h6>");
                    } else {
                        $(this).parent().find('h6').remove();
                    }

                } else {
                    if (status == 'No') {
                        $(this).append("<h6>Ball Running</h6>");
                    } else {
                        $(this).find('h6').remove()
                    }
                }
            });
            BLOCKED = status == 'Yes' ? false : true;
            $.ajax({
                url: '<?php echo base_url(); ?>admin/events/changeBallRunningStatus',
                data: {
                    event_id: event_id,
                    status: status == 'Yes' ? 'No' : 'Yes',
                },
                type: 'post',
                dataType: 'json',
                success: function(output) {

                    if (status == 'Yes') {
                        $('#changeStatus').attr('data-status', 'No')
                        $('#changeStatus').html('Block');
                    } else {
                        $('#changeStatus').attr('data-status', 'Yes')
                        $('#changeStatus').html('Un-Block');


                    }
                }
            })

        }

        setInterval(function() {
            // fetchBttingList();
            getFancysExposure();
            getEventsMarketExpsure(<?php echo $event_id; ?>);
        }, 30000);


        function deleteBet(betting_id) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/events/deleteBet',
                data: {
                    betting_id: betting_id,
                },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#openbets').modal('hide');

                    if (!data.success) {

                        new PNotify({
                            title: 'Error',
                            text: data.message,
                            type: 'error',
                            styling: 'bootstrap3',
                            delay: 1000
                        });
                    } else {
                        new PNotify({
                            title: 'Success',
                            text: data.message,
                            type: 'success',
                            styling: 'bootstrap3',
                            delay: 1000
                        });
                    }

                    // fetchBttingList();

                }
            })
        }
    </script>

</body>

</html>