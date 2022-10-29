<div class="right_col" role="main">
    <div class="fullrow tile_count">
        <div class="col-md-7">
            <div id="videoContainer">
                <!-- <iframe src="<?php echo $videoLink; ?>" style="border-radius: 1px;border: 4px solid #fbc832;width:100%;height:300px;"></iframe> -->
            </div>
            <div id="MatchOddInfo">
                <!------------------Exchange Response Show here----------------->
                <?php echo $marketExchangeHtml; ?>
                <!------------------Exchange Response Show here----------------->
            </div>

            <!-----------------Fancy API Response show here------------------->
            <div class="fullrow margin_bottom fancybox" id="fancyM_4310">
                <!------------------Fancy Exchange Response Show here----------------->

                <?php echo $fancyExchangeHtml; ?>
                <!------------------Fancy Exchange Response Show here----------------->


                <!-- <div class="fancy-table" id="fbox4310">
                    <div class="fancy-heads">
                        <div class="event-sports">&nbsp;&nbsp; </div>
                        <div class="fancy_buttons">
                            <div class="fancy-backs head-no">
                                <strong>NO</strong>
                            </div>
                        </div>
                        <div class="fancy_buttons">
                            <div class="fancy-lays head-yes">
                                <strong>YES</strong>
                            </div>
                        </div>

                    </div>

                    <div class="fancyAPI"></div>
                    <div class="fancyLM"></div>
                </div> -->
            </div>
            <!-----------------Fancy API Response show here------------------->
        </div>
        <div class="col-md-5 col-xs-12 matchBox">



            <div class="betSlipBox">
                <div class="betslip-head">
                    <span id="tital_change" style="display:contain;" class="item">Bet Slip</span>
                    <a href="javascript:;" class="UserChipData" onclick="showEditStakeModel()">
                        Edit Stake
                    </a>
                </div>
                <div>
                    <div class="betBox border-box" style="display: none;">
                        <div class="block_box">
                            <span id="msg_error"></span><span id="errmsg"></span>
                            <div class="loader" style="display:none">
                                <div class="spinner">
                                    <div class="loader-inner box1"></div>
                                    <div class="loader-inner box2"></div>
                                    <div class="loader-inner box3"></div>
                                </div>
                            </div>
                            <form method="POST" id="placeBetSilp"><input type="hidden" name="compute" value="27d9014d9b40e1c51e6fe35468def2aa">
                                <label class="control-label m-t-xs BetFor"> Yet (Bet For)</label>
                                <div class="liabilityprofit" id=" ">
                                    <span class="stake_label">Profit</span>
                                    <div class="stack_input_field">
                                        <span id="profitData" style="color:rgb(0, 124, 14);font-weight:bold"> 0.00</span>
                                    </div>
                                </div>
                                <div class="liabilityprofit" id=" ">
                                    <span class="stake_label">Loss</span>
                                    <div class="stack_input_field">
                                        <span id="LossData" style="color:rgb(255, 0, 0);font-weight:bold"> 0.00</span>
                                    </div>
                                </div>
                                <div id="ShowRunnderName" class="match_runner_name">
                                </div>
                                <div class="odds-stake">
                                    <div class="item form-group full_rowOdd">
                                        <span class="stake_label">Odd</span>
                                        <div class="stack_input_field numbers-row">
                                            <input type="number" step=0.01 id="ShowBetPrice" class="calProfitLoss odds-input form-control  CommanBtn">
                                            <input type="hidden" id="TempShowBetPrice" class="calProfitLoss odds-input form-control  CommanBtn">
                                        </div>
                                    </div>
                                    <div class="item form-group" id=" ">
                                        <span class="stake_label">Stake</span>
                                        <div class="stack_input_field numbers-row">
                                            <input type="number" pattern="[0-9]*" step=1 id="stakeValue" class="calProfitLoss stake-input form-control  CommanBtn">
                                            <input type="hidden" name="selectionId" id="selectionId" value="" class="form-control">
                                            <input type="hidden" name="matchId" id="matchId" value="" class="form-control">
                                            <input type="hidden" name="isback" id="isback" value="" class="form-control">
                                            <input type="hidden" name="MarketId" id="MarketId" value="" class="form-control">
                                            <input type="hidden" name="round_id" id="round_id" value="" class="form-control">
                                            <input type="hidden" name="betting_type" id="betting_type" value="" class="form-control">
                                            <input type="hidden" name="event_type" id="event_type" value="<?php echo $event_type; ?>" class="form-control">
                                            <input type="hidden" name="placeName" id="placeName" value="" class="form-control">
                                            <input type="hidden" name="text" id="stackcount" value="0" class="form-control">
                                            <input type="hidden" name="text" id="isfancy" value="0" class="form-control">


                                        </div>
                                    </div>
                                </div>
                                <div class=" betPriceBox row" style="display:block;">
                                    <?php

                                    if (!empty($chips)) {
                                        foreach ($chips as $key => $chip) { ?>
                                            <div class="col-md-2 col-sm-3 col-xs-3" style="padding:5px;">
                                                <button class="btn  btn-success CommanBtn  chipName1 " style="width:100%;" type="button" value="<?php echo $chip['chip_value']; ?>" onclick="StaKeAmount(this);"><?php echo $chip['chip_name']; ?></button>
                                            </div>
                                    <?php }
                                    }
                                    ?>
                                    <div class="col-md-2 col-sm-3 col-xs-3" style="padding:5px;">


                                        <button class="btn  btn-success CommanBtn " type="button" onclick="ClearStack( );">Clear</button>
                                    </div>
                                </div>
                                <div class="betFooter">
                                    <button class="btn btn-danger CommanBtn" type="button" onclick="ClearAllSelection();">Clear All</button>
                                    <button class="btn btn-success  CommanBtn placebet" type="button" onclick="PlaceBet();">Place Bet</button>
                                    <button class="btn btn-success CommanBtn placefancy" type="button" onclick="PlaceBet();" style="display:none">Place Bet</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab_bets">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item betdata active-all active" id="all-bet-slip">
                                <a class="allbet" href="javascript:void(0);" onclick="getDataByType('all','all-bet-slip');"><span class="bet-label">All Bet</span> <span id="cnt_row">( )</span></a>
                            </li>
                            <li class="nav-item betdata active-unmatch" id="match-odds-bet-slip">
                                <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('match','match-odds-bet-slip');"><span class="bet-label">Match Odds</span> <span id="cnt_row1">( ) </span></span> </a>
                            </li>
                            <li class="nav-item betdata" id="fancy-bet-slip">
                                <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('fancy','fancy-bet-slip');"><span class="bet-label">Fancy Bet</span> <span id="cnt_row3">( ) </span></span> </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <!--- Match UnMatch data --->
            <div class="" id="MatchUnMatchBetaData">
                <style>
                    .searchbtnn {
                        margin-right: 20px;
                    }
                </style>
                <script>
                    $(document).ready(function() {
                        // $('.UnMachShowHide').hide();
                        //  $('.MachShowHide').hide();
                    });
                    $(".MatchBetHide").click(function() {
                        $(".MachShowHide").slideToggle("fast");
                        $(this).find(".matchbetupdown").toggleClass("down up");
                    });
                    $(".UnMatchBetHide").click(function() {
                        $(".UnMachShowHide").slideToggle("fast");
                        $(this).find(".unmatchbetupdown").toggleClass("down up");
                    });
                    $("#cnt_row").text("(" + 0 + ")");
                    $("#cnt_row1").text("(" + 0 + ")");
                    $("#cnt_row3").text("(" + 0 + ")");
                </script>



                <div class="border-box" id="bettingView" role="main">
                    <div class="fullrow">
                        <div class="modal-dialog-staff">
                            <div class="modal-content">

                                <div class="modal-body"><span id="msg_error"></span><span id="errmsg"></span>

                                    <div class="match_bets MachShowHide">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <td>No.</td>

                                                    <?php
                                                    $user_type = $_SESSION['my_userdata']['user_type'];
                                                    if ($user_type != 'User') { ?>
                                                        <td>User</td>
                                                    <?php }
                                                    ?>
                                                    <td>Runner</td>
                                                    <td>Bhaw</td>
                                                    <td>Amount</td>
                                                    <td>P_L</td>

                                                    <td>Bet Type</td>
                                                    <!--td>P&L</td-->
                                                    <td>Time</td>
                                                    <td>ID</td>
                                                    <td> IP</td>
                                                </tr>
                                            </thead>
                                            <tbody id="all-betting-data">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--- User Current Position  --->
            <div class="" id="getUserPosition">
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
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
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.panel-heading span.clickable', function(e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.balance-box').find('.balance-panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('fa fa-chevron-down').addClass('fa fa-chevron-up');

        } else {
            $this.parents('.balance-box').find('.balance-panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('fa fa-chevron-up').addClass('fa fa-chevron-down');

        }
    })
</script>



<!--commanpopup-->
<div id="commonpopup" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="popup_form">
                <div class="title_popup">
                    <span>Title Popup</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <div class="close_new"><i class="fa fa-times-circle"></i></div>
                    </button>
                </div>
                <div class="content_popup">
                    <div class="popup_form_row">
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addUser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mod-header"><button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Chip Setting</h4>
            </div>
            <div class="modal-body">
                <div id="addUserMsg"></div>
                <form id="stockez_add" method="post" class="form-inline">
                    <input type="hidden" name="user_id" class="form-control" required value="<?php echo get_user_id(); ?>" />
                    <div class="modal-body" id="chip-moddal-body">
                        <?php
                        if (!empty($chips)) {
                            $i = 0;
                            foreach ($chips as $chip) {
                                $i++;
                        ?>
                                <div class="fullrow">
                                    <input type="hidden" name="user_chip_id[]" class="form-control" required value="<?php echo $chip['user_chip_id']; ?>" />
                                    <div class="col-md-6 col-sm-6col-xs-6">
                                        <div class="form-group"><label for="email">Chips Name <?php echo $i; ?>:</label><input type="text" name="chip_name[]" class="form-control" required value="<?php echo $chip['chip_name']; ?>"></div>
                                    </div>
                                    <div class=" col-md-6 col-sm-6col-xs-6">
                                        <div class="form-group"><label for="pwd">Chip Value <?php echo $i; ?>:</label><input type="number" name="chip_value[]" class="form-control" required value="<?php echo $chip['chip_value']; ?>"></div>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>

                    </div>
                    <div class="modal-footer">
                        <div class="text-center" id="button_change">
                            <div class="text-center" id="button_change">
                                <button type="button" class="btn btn-success" id="updateUserChip" onclick="add_new_chip()" style="margin-bottom:10px;">Add New Chip </button>
                                <button type="button" style="margin-bottom:10px;" class="btn btn-success" id="updateUserChip" onclick="submit_update_chip()"> Update Chip Setting </button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--commanpopup-->
<!-- </div>
</div> -->




</body>

</html>


<script>
    var a = 0;
    var b = 0;
    var betSlip;
    var isMarketSelected;
    var active_event_id;
    var superiors = <?php echo $superiors; ?>;



    function MarketSelection(MarketId, matchId, eventType) {

        /*********************** */
        window.location.assign("<?php echo base_url(); ?>dashboard/eventDetail/" + matchId);



        /*********************** */
        return false;



        isMarketSelected = true;
        $('#betting_type').val('Match');
        $('#event_type').val(eventType);

        $("#UpCommingData").hide();
        $("#UpCommingData").html('');
        var formData = {
            MarketId: MarketId,
            matchId: matchId
        };


        // $.blockUI();
        $.ajax({
            url: "<?php echo base_url(); ?>admin/Events/backlays",
            data: formData,
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function success(output) {
                if (output != '') {
                    //  active_event_id = MarketId;
                    $('#MarketId').val(MarketId);
                    $('#matchId').val(matchId);

                    $(".matchBox").show();
                    $("#UpCommingData").hide();
                    $("#MatchOddInfo").show();
                    $('#bettingView').show();
                    $(".betSlipBox").show();
                    $(".other-items").hide();
                    // $("#MatchOddInfo").html(output.exchangeHtml);
                    $('.fancybox').show();
                    // $('.fancybox').html(output.fancyHtml);

                    generateMarketStructure(output)

                } else {
                    closeBetBox(matchId, MarketId);
                }
                // $.unblockUI();

            }
        });
        fetchBttingList();
    }

    function generateMarketStructure(data) {
        var exchangeHtml = '';



        if (data.events) {
            $.each(data.events, function(index, event) {
                if (event.market_types) {
                    $.each(event.market_types, function(index, market_type) {

                        if (market_type.is_block) {
                            return;
                        }

                        var view_info = market_type.user_info;

                        if (view_info) {
                            if (market_type.inplay == 1) {
                                var min_stake = view_info.min_stake;
                                var max_stake = view_info.max_stake;

                            } else {
                                var max_stake = view_info.pre_inplay_stake;
                            }

                        }


                        exchangeHtml += '<div class="fullrow matchBoxMain  matchBox_' + event.event_id + ' matchBoxs_' + event.event_id + ' style="display:block;">';

                        exchangeHtml += '<div class="modal-dialog-staff">';
                        exchangeHtml += '<div class="match_score_box">';
                        exchangeHtml += '<div class="modal-header mod-header">';
                        exchangeHtml += '<div class="block_box" style="display:flow-root;">';
                        exchangeHtml += '<span id="tital_change">';


                        if (event.is_favourite) {
                            exchangeHtml += '<span id="fav' + event.event_id + '"><i class="fa fa-star" aria-hidden="true" onclick="favouriteSport(' + event.event_id + ')" ></i></span>';
                        } else {
                            exchangeHtml += '<span id="fav' + event.event_id + '"><i class="fa fa-star-o" aria-hidden="true" onclick="favouriteSport(' + event.event_id + ')" ></i></span>'
                        }

                        exchangeHtml += event.event_name + '<input type="hidden" value="' + event.event_name + '" id="sportName_4310"></span>';

                        exchangeHtml += '<div class="block_box_btn">';
                        exchangeHtml += '<button class="btn btn-primary btn-xs" onclick="getCurrentBets(' + event.event_id + ')">Bets</button>';
                        exchangeHtml += '<button class="btn btn-primary btn-xs" onclick="closeBetBox(' + event.event_id + ')">X</button>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '<div class="score_area"><span class="matchScore" id="matchScore_4310"> </span> </div>';

                        exchangeHtml += '</div>';
                        exchangeHtml += '<div class="matchClosedBox_214310" style="display:none">';
                        exchangeHtml += '<div class="fullrow fullrownew">';
                        exchangeHtml += '<div class="pre-text">' + market_type.market_name + '<br>';

                        exchangeHtml += '</div>';
                        exchangeHtml += '<div class="matchTime">' + event.open_date + '</div></div>';
                        exchangeHtml += '<div>';
                        exchangeHtml += '<div class="closedBox">';
                        exchangeHtml += '<h1>Closed</h1>';
                        exchangeHtml += ' </div>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '<div class="sportrow-4 matchOpenBox_' + market_type.market_id.replace('.', '') + '">';
                        exchangeHtml += '<div class="match-odds-sec">';
                        exchangeHtml += '<div class="item match-status">';
                        exchangeHtml += market_type.market_name + '</div>';
                        exchangeHtml += '<div class="item match-status-odds">';

                        if (market_type.inplay == 1) {
                            exchangeHtml += '<span class="inplay_txt"> In-play </span>';
                        } else {
                            exchangeHtml += '<span class="going_inplay"> Going In-play </span>';
                        }

                        exchangeHtml += '</div>';
                        exchangeHtml += '</div>';
                        exchangeHtml += '<div class="fullrow MatchIndentB" style="position:relative;">';

                        exchangeHtml += '<table class="table table-striped  bulk_actions matchTable214310" id="matchTable4310">';
                        exchangeHtml += '<tbody>';
                        exchangeHtml += '<tr class="headings mobile_heading">';
                        exchangeHtml += '<th class="fix_heading color_red">';

                        if (view_info) {
                            if (market_type.inplay == 1) {
                                exchangeHtml += 'Min stake:' + min_stake + ' Max stake:' + max_stake + ' </th>';

                            } else {
                                exchangeHtml += 'Max stake:' + max_stake + ' </th>';
                            }
                        }

                        exchangeHtml += '<th> </th>';
                        exchangeHtml += '<th> </th>';
                        exchangeHtml += '<th class="back_heading_color">Back</th>';
                        exchangeHtml += '<th class="lay_heading_color">Lay</th>';
                        exchangeHtml += '<th> </th>';
                        exchangeHtml += '<th> </th>';
                        exchangeHtml += '</tr>'
                        exchangeHtml += '<tr id="user_row0" class="back_lay_color runner-row-1">';
                        exchangeHtml += '<td>';
                        exchangeHtml += '<p class="runner_text" id="runnderName1">' + market_type.runner_1_runner_name + '</p>';
                        exchangeHtml += '<p class="blue-odds" id="Val1-' + event.event_id + '">0</p>';

                        var exposure = market_type.runners[0].exposure;
                        if (exposure < 0) {
                            exchangeHtml += '<span class="runner_amount" style="color:red;" id="' + market_type.runners[0].selection_id + '_maxprofit_loss_runner_' + market_type.market_id.replace('.', '') + '">' + Math.abs(exposure) + '</span>';
                        } else {
                            exchangeHtml += '<span class="runner_amount" style="color:green" id="' + market_type.runners[0].selection_id + '_maxprofit_loss_runner_' + market_type.market_id.replace('.', '') + '">' + Math.abs(exposure) + '</span>';
                        }


                        exchangeHtml += '<input type="hidden" class="position_' + market_type.market_id.replace('.', '') + '" id="selection_0" data-id="' + market_type.runners[0].selection_id + '" value="' + exposure + '">';
                        exchangeHtml += '</td>';

                        //availableToBack


                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`' + 1 + '`,' + '`' + market_type.runner_1_runner_name + '`,`availableToBack3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`, `' + market_type.runners[0].selection_id + '`,`B`,`this`)">';

                        exchangeHtml += '<span class="priceRate" id="availableToBack3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].back_3_price;

                        exchangeHtml += '</span>';

                        exchangeHtml += '<span id="availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].back_3_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';


                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`' + 1 + '`,`' +
                            market_type.runner_1_runner_name + '`,`availableToBack2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`,`' +
                            market_type.runners[0].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToBack2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';



                        exchangeHtml += market_type.runners[0].back_2_price;


                        exchangeHtml += '</span>';


                        exchangeHtml += '<span id="availableToBack2_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';


                        exchangeHtml += market_type.runners[0].back_2_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';


                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`1`,`' +
                            market_type.runner_1_runner_name + '`,`availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`,`' + market_type.runners[0].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].back_1_price;
                        exchangeHtml += '</span>';

                        exchangeHtml += '<span id="availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].back_1_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';


                        // availableToLay


                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`,`' + market_type.runner_1_runner_name + '`,`availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`,`' + market_type.runners[0].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';


                        exchangeHtml += market_type.runners[0].lay_1_price;
                        exchangeHtml += '</span>';
                        exchangeHtml += '<span id="availableToLay1_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].lay_1_size;

                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`,`' + market_type.runner_1_runner_name + '`,`availableToLay2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`,`' + market_type.runners[0].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type['runners'][0]['lay_2_price'];

                        exchangeHtml += '</span>';

                        exchangeHtml += '<span class="priceRate" id="availableToLay2_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';


                        exchangeHtml += market_type.runners[0].lay_2_size;

                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`,`' + market_type.runner_1_runner_name + '`,`availableToLay3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '`,`' + market_type.runners[0].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';

                        exchangeHtml += market_type.runners[0].lay_3_price;

                        exchangeHtml += '</span>';
                        exchangeHtml += '<span id="availableToLay3_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[0].selection_id + '">';


                        exchangeHtml += market_type.runners[0].lay_3_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';
                        exchangeHtml += '</tr>';



                        // TD FOR RUNNER VALUE ONE
                        exchangeHtml += '<tr id="user_row1" class="back_lay_color runner-row-2">';
                        exchangeHtml += '<td>';
                        exchangeHtml += '<p class="runner_text" id="runnderName1">' + market_type.runner_2_runner_name + '</p>';
                        exchangeHtml += '<p class="blue-odds" id="Val1-' + event.event_id + '">0</p>';

                        var exposure = market_type.runners[1].exposure;

                        if (exposure < 0) {
                            exchangeHtml += '<span class="runner_amount" style="color:red;" id="' + market_type.runners[1].selection_id + '_maxprofit_loss_runner_' + market_type.market_id.replace('.', '') + '">' + Math.abs(exposure) + '</span>';
                        } else {
                            exchangeHtml += '<span class="runner_amount" style="color:green" id="' + market_type.runners[1].selection_id + '_maxprofit_loss_runner_' + market_type.market_id.replace('.', '') + '">' + Math.abs(exposure) + '</span>';
                        }



                        exchangeHtml += '<input type="hidden" class="position_' + market_type.market_id.replace('.', '') + '" id="selection_0" data-id="' + market_type.runners[1].selection_id + '" value="' + exposure + '">';
                        exchangeHtml += '</td>';

                        //availableToBack


                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`1`, `' + market_type.runner_2_runner_name + '`,`availableToBack3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`)">';

                        exchangeHtml += '<span class="priceRate" id="availableToBack3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].back_3_price;
                        exchangeHtml += '</span>';


                        exchangeHtml += '<span id="availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';


                        exchangeHtml += market_type.runners[1].back_3_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`1`,`' + market_type.runner_2_runner_name + '`,`availableToBack2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToBack2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';


                        exchangeHtml += market_type.runners[1].back_2_price;
                        exchangeHtml += '</span>';


                        exchangeHtml += '<span id="availableToBack2_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';


                        exchangeHtml += market_type.runners[1].back_2_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToBack2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`1`, `' + market_type.runner_2_runner_name + '`,`availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';



                        exchangeHtml += market_type.runners[1].back_1_price;
                        exchangeHtml += '</span>';


                        exchangeHtml += '<span id="availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';


                        exchangeHtml += market_type.runners[1].back_1_size;
                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        //availableToLay


                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`, `' + market_type.runner_2_runner_name + '`,`availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].lay_1_price;
                        exchangeHtml += '</span>';
                        exchangeHtml += '<span id="availableToLay1_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].lay_1_size;

                        exchangeHtml += '</span>';

                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`,`' + market_type.runner_2_runner_name + '`,`availableToLay2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay2_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';


                        exchangeHtml += market_type.runners[1].lay_2_price;

                        exchangeHtml += '</span>';
                        exchangeHtml += '<span id="availableToLay2_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].lay_2_size;

                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';

                        exchangeHtml += '<td class="1_0availableToLay2_price_214310" onclick="getOddValue(`' + event.event_id + '`,`' + market_type.market_id + '`,`0`, `' + market_type.runner_2_runner_name + '`,`availableToLay3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '`,`' + market_type.runners[1].selection_id + '`,`B`,`this`);">';


                        exchangeHtml += '<span class="priceRate" id="availableToLay3_price_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].lay_3_price;
                        exchangeHtml += '</span>';


                        exchangeHtml += '<span id="availableToLay3_size_' + market_type.market_id.replace('.', '') + '_' + market_type.runners[1].selection_id + '">';

                        exchangeHtml += market_type.runners[1].lay_3_size;

                        exchangeHtml += '</span>';
                        exchangeHtml += '</td>';


                        exchangeHtml += '</tr>';
                        //TD FOR RUNNER VALUE ONE
                        exchangeHtml += '</tbody>';
                        exchangeHtml += '</table>';
                        exchangeHtml += '</div></div></div></div>';

                    })
                }
            });
        }
        $("#MatchOddInfo").html(exchangeHtml);


        var fancyHtml = '';


        if (data.fancy_data) {
            fancyHtml += '<div style="" class="fancy-table" id="fbox30026040"><div class="fancy-heads"><div class="event-sports">Fancy&nbsp;&nbsp; </div><div class="fancy_buttons"><div class="fancy-backs head-no"><strong>NO</strong></div></div><div class="fancy_buttons"><div class="fancy-lays head-yes"><strong>YES</strong></div></div></div>';

            fancyHtml += '<div class="fancyAPI">';
            $.each(data.fancy_data, function(index, fancy) {

                fancyHtml += '<div class="block_box f_m_' + fancy.match_id + ' fancy_' + fancy.selection_id + ' f_m_31236" data-id="31236">';

                fancyHtml += '<ul class="sport-high fancyListDiv">';
                fancyHtml += '<li>';
                fancyHtml += '<div class="ses-fan-box">';
                fancyHtml += '<table class="table table-striped  bulk_actions">';
                fancyHtml += '<tbody>';
                fancyHtml += '<tr class="session_content">';
                fancyHtml += '<td><span class="fancyhead' + fancy.selection_id + '" id="fancy_name' + fancy.selection_id + '">' + fancy.runner_name + '</span><b class="fancyLia' + fancy.selection_id + '"></b><p class="position_btn"><button class="btn btn-xs btn-danger" onclick="getPosition(' + fancy.selection_id + ')">Book</button></td>';


                fancyHtml += '<td></td>';
                fancyHtml += '<td></td>';

                fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancy.selection_id + '" onclick="betfancy(`' + fancy.match_id + '`,`' + fancy.selection_id + '`,`' + 0 + '`);">';

                fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancy.selection_id + '" id="LayNO_' + fancy.selection_id + '">' + fancy.lay_price1 + '</button>';

                fancyHtml += '<button id="NoValume_' + fancy.selection_id + '" class="disab-btn fancy_lay_size_' + fancy.selection_id + '">' + fancy.lay_size1 + '</button></td>';

                fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancy.match_id + '`,`' + fancy.selection_id + '`,`' + 1 + '`);">';

                fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancy.selection_id + '" id="BackYes_' + fancy.selection_id + '">' + fancy.back_price1 + '</button>';

                fancyHtml += '<button id="YesValume_' + fancy.selection_id + '" class="disab-btn fancy_back_size_' + fancy.selection_id + '">' + fancy.back_size1 + '</button>';
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
            });
            fancyHtml += '</div>';


            $('.fancybox').html(fancyHtml);


        }


    }

    $(function() {
        fetchBttingList();
    })

    function fetchBttingList() {

        var formData = {

            matchId: "<?php echo $event_id; ?>"
        }
        $.ajax({
            url: "<?php echo base_url(); ?>admin/Events/bettingList",
            data: formData,
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function(output) {

                <?php
                if (get_user_type() != 'Operator') { ?>
                    $('.mWallet').html(output.balance);
                    $('.liability').html(output.exposure);
                <?php   }

                ?>

                $('#all-betting-data').html(output.bettingHtml);


                var allLength = $('.all-bet-slip').length;

                $('#cnt_row').text('(' + allLength + ')');

                var matchLength = $('.match-bet-slip').length;
                $('#cnt_row1').text('(' + matchLength + ')');

                var fancyLength = $('.fancy-bet-slip').length;

                $('#cnt_row3').text('(' + fancyLength + ')');

            }
        });
    }


    function getOddValue(matchId, marketId, round_id, back_layStatus, placeName, elementId, selectionId, MarketTypes = '', target) {

        var priceVal = $('#' + elementId).text();

        $('#betting_type').val('Match');
        <?php
        $user_type = $_SESSION['my_userdata']['user_type'];

        if ($user_type != 'User') { ?>
            return false;
        <?php }
        ?>
        $("#stakeValue").blur();
        if (back_layStatus == 0) {
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

        // var check_price_value = setInterval(function() {
        //     var real_priceVal = parseFloat($('#' + elementId).text());

        //     if (priceVal != real_priceVal) {
        //         clearInterval(check_price_value);

        //         ClearAllSelection(1);
        //     }
        // }, 1000);

        // var priceVal = $.trim($("#" + className).text());
        var MId = marketId.toString().replace('.', '');
        if (active_event_id) {
            matchId = active_event_id;
            marketId = active_event_id;
        }
        MatchMarketTypes = MarketTypes;

        // if (priceVal != '' && matchId != '' && back_layStatus != '' && placeName != '') {
        if ($(window).width() < 780) {
            $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
            $(".betSlipBox .mod-header").show();
            $(".betBox").insertAfter('.matchOpenBox_' + MId);
            // if (gameType != 'market') {
            //    $("#betslip").insertAfter('.teenpatti-row');
            // } else {
            $(".betBox").insertAfter('.matchOpenBox_' + MId);
            // $(".betBox").insertAfter('#MatchOddInfo');

            // }
        } else {
            $(".betSlipBox .mod-header").show();
            $(".betSlipBox").show();
        }

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
        $("#round_id").val(round_id);

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

        var stake = parseFloat($("#stakeValue").val());
        var priceVal = parseFloat($("#ShowBetPrice").val());
        var MarketId = $("#MarketId").val();
        var matchId = $("#matchId").val();
        var betting_type = $("#betting_type").val();
        var event_type = $("#event_type").val();
        var round_id = $("#round_id").val();


        if (!$.isNumeric(priceVal) || priceVal < 1) {
            new PNotify({
                title: 'Error',
                text: 'Invalid stake/odds.',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
            $("#stakeValue").val(0);
            $("#profitData").text('');
            $("#LossData").text('');
        } else if (matchId != '') {
            $(".loader").show();

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
                round_id: round_id,
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
                    url: '<?php echo base_url(); ?>admin/Casino/savebet',
                    data: formData,
                    dataType: 'json',
                    async: false,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    beforeSend: function() {
                        // $(".loader").css("display", "");
                    },
                    success: function(data) {
                        $(".loader").hide();
                        var selectionId = $("#selectionId").val();

                        $(".CommanBtn").attr("disabled", false);
                        if (!data.success) {
                            ClearAllSelection(1);

                            new PNotify({
                                title: 'Error',
                                text: data.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 3000
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
                            fetchBttingList();
                            var betting_details = {
                                'bet_details': {},
                                'users': ['140', "138"]
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
                                delay: 3000
                            });
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
                delay: 3000
            });
            $("#stakeValue").val(0);
            $("#profitData").text('');
            $("#LossData").text('');
        }
    }




    function betfancy(matchid, fancyid, isback) {
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

            console.clear();
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
            if ($(window).width() < 780) {
                $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
                $(".betSlipBox .mod-header").show();
                $(".betBox").show();
                $(".betBox").insertAfter('.fancy_' + fancyid);
            } else {
                $(".betBox").show();
                $(".betSlipBox .mod-header").show();
            }
        }
    }


    function PlaceFancy() {
        var amount = parseFloat($("#stakeValue").val());
        var OddValue = $('#isback').val();
        var betOddValue = $("#ShowBetPrice").val();
        var fancyid = $("#isfancy").val();
        var YesValume = parseFloat($("#YesValume_" + fancyid).text());
        var NoValume = parseFloat($("#NoValume_" + fancyid).text());
        if (!$.isNumeric(amount) || amount < 1 || !$.isNumeric(betOddValue) || betOddValue < 1) {
            new PNotify({
                title: 'Error',
                text: 'Invalid stake/odd',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
        } else if (!$.isNumeric(NoValume) || NoValume < 1 || !$.isNumeric(YesValume) || YesValume < 1) {
            new PNotify({
                title: 'Error',
                text: 'Invalid session Volume',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
        } else {
            $(".CommanBtn").attr("disabled", true);
            $(".loader").show();
            var sessionData = {
                betValue: amount,
                betOddValue: betOddValue,
                FancyID: $("#isfancy").val(),
                matchId: $("#matchId").val(),
                OddValue: $('#isback').val(),
                HeadName: $('#placeName').val()
            };
            setTimeout(function() {
                $.ajax({
                    url: 'fancybet',
                    type: "POST",
                    data: setFormData(sessionData),
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        $(".CommanBtn").attr("disabled", false);
                        $(".loader").hide();
                        ClearAllSelection(1);
                        getBets(0);
                        if (data.error == 0) {
                            //$("#UserLiability").text(data.cipsData[0].Liability);
                            $(".liability").text(data.cipsData[0].Liability);
                            //$("#Wallet").text(data.cipsData[0].Balance);
                            $(".mWallet").text(data.cipsData[0].Balance);
                            new PNotify({
                                title: 'Success',
                                text: 'Place Bet Successfully...',
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 3000
                            });
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: data.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 3000
                            });
                        }
                    }
                });
            }, 0);
        }
    }


    function showEditStakeModel() {
        $('#addUser').modal('show');
    }

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
                        delay: 2000
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
                        delay: 2000
                    });
                }
            }
        });
    }

    function ClearStack(hide = 1) {
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
    }
</script>

<script>
    $(document).ready(function() {

        <?php


        if (isset($_GET['match_id']) && isset($_GET['market_id'])) { ?>
            MarketSelection(<?php echo $_GET['market_id']; ?>, <?php echo $_GET['match_id']; ?>, "<?php echo isset($_GET['event_type']) ? $_GET['event_type'] : null; ?>");
        <?php } ?>



        socket.on('casino_market_update', function(data) {

            var MarketId = $('#MarketId').val();
            var matchId = "<?php echo $event_id; ?>";

            // if (MarketId) {

            // var market = data.marketodds[matchId]

            var market = data.marketodds.find(o => o.event_id == matchId);


            if (market.market_types.length > 0) {
                $.each(market.market_types, function(index, market_type) {
                    console.log('market_type', market_type);
                    console.log('market_type', market_type);

                    $.each(market_type.runners, function(index, runner) {

                        console.log('status', market_type.status);
                        console.log('market_id', market_type.market_id);
                        console.log('box', '.overlay_matchBoxs_' + market_type.market_id.replace('.', ''));
                        $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                        console.log('button get' + market_type.timer, $('#market_countdown_' + market_type.market_id.replace('.', '')));
                        if (market_type.status == 'OPEN') {
                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                            $('.matchOpenBox_603c760cd580f84f8a59c2bb')
                        } else if (market_type.status == 'SUSPENDED') {
                            console.log('Market Suspended');
                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();

                            $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                        } else if (market_type.status == 'CLOSED') {
                            console.log('Market Closed');
                            $('.market_box_' + market_type.market_id).remove();

                        }

                        //  if (j == 0) {

                        ///*************Available To Bck */

                        if (parseFloat($('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_3_price)) {
                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_price);

                        } else {
                            $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_price);
                        }


                        if (parseFloat($('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_2_price)) {
                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_price);

                        } else {
                            $('#availableToBack2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_price);
                        }

                        if (parseFloat($('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_1_price)) {
                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_price);

                        } else {
                            $('#availableToBack1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_price);
                        }


                        if (parseFloat($('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_1_price)) {
                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_price);

                        } else {
                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_price);
                        }

                        if (parseFloat($('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_2_price)) {
                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_price);

                        } else {
                            $('#availableToLay2_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_price);
                        }

                        if (parseFloat($('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_3_price)) {
                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_price);

                        } else {
                            $('#availableToLay3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_price);
                        }


                        /************************Size */

                        if (parseFloat($('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_3_size)) {
                            $('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_size).parent().addClass('yellow');

                        } else {
                            $('#availableToBack3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_3_size).parent().removeClass('yellow');
                        }


                        if (parseFloat($('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_2_size)) {
                            $('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_size).parent().addClass('yellow');

                        } else {
                            $('#availableToBack2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_2_size).parent().removeClass('yellow');
                        }

                        if (parseFloat($('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.back_1_size)) {
                            $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_size).parent().addClass('yellow');

                        } else {
                            $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.back_1_size).parent().removeClass('yellow');
                        }


                        if (parseFloat($('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_1_size)) {
                            $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_size).parent().addClass('yellow');

                        } else {
                            $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_1_size).parent().removeClass('yellow');
                        }

                        if (parseFloat($('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_2_size)) {
                            $('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_size).parent().addClass('yellow');

                        } else {
                            $('#availableToLay2_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_2_size).parent().removeClass('yellow');
                        }

                        if (parseFloat($('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(runner.lay_3_size)) {
                            $('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_size).parent().addClass('yellow');

                        } else {
                            $('#availableToLay3_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(runner.lay_3_size).parent().removeClass('yellow');
                        }


                    });
                });
            }

            // }

        });

        socket.on('fancy_update', function(data) {
            var MarketId = $('#MarketId').val();
            var matchId = "<?php echo $event_id; ?>";


            if (matchId) {

                var fancys = data.fantacy.find(o => o.event_id == matchId).fancy_data;

                if (fancys.length) {
                    for (var j = 0; j < fancys.length; j++) {
                        if (fancys[j].cron_disable == 'Yes') {
                            $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().fadeOut();
                        } else {
                            if (fancys[j]) {
                                var block_market_fancys = fancys[j].block_market;
                                var block_all_market_fancys = fancys[j].block_all_market;

                                var find_fancy_all_block = block_all_market_fancys.filter(element => {

                                    return superiors.includes(element.user_id.toString())
                                });

                                if (find_fancy_all_block.length > 0) {
                                    $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().fadeOut();
                                } else {

                                    var find_fancy_block = block_market_fancys.filter(element => {

                                        return superiors.includes(element.user_id.toString())
                                    });

                                    if (find_fancy_block.length > 0) {
                                        $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().fadeOut();
                                    } else {
                                        $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().fadeIn();
                                        var fancyHtml = '';

                                        if (!$('.fancy_' + fancys[j].selection_id).length) {
                                            fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236" data-id="31236">';

                                            fancyHtml += '<ul class="sport-high fancyListDiv">';
                                            fancyHtml += '<li>';
                                            fancyHtml += '<div class="ses-fan-box">';
                                            fancyHtml += '<table class="table table-striped  bulk_actions">';
                                            fancyHtml += '<tbody>';
                                            fancyHtml += '<tr class="session_content">';
                                            fancyHtml += '<td><span class="fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name + '</span><b class="fancyLia' + fancys[j].selection_id + '"></b><p class="position_btn"><button class="btn btn-xs btn-danger" onclick="getPosition(' + fancys[j].selection_id + ')">Book</button></td>';


                                            fancyHtml += '<td></td>';
                                            fancyHtml += '<td></td>';

                                            fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';

                                            fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancys[j].selection_id + '" id="LayNO_' + fancys[j].selection_id + '">' + fancys[j].lay_price1 + '</button>';

                                            fancyHtml += '<button id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</button></td>';

                                            fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';

                                            fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancys[j].selection_id + '" id="BackYes_' + fancys[j].selection_id + '">' + fancys[j].back_price1 + '</button>';

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

                                            console.log('ADD NEW FANCY', fancyHtml);
                                            $('.fancyAPI').append(fancyHtml);
                                        }

                                        if (fancys[j].back_price1 == 'Ball') {
                                            $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                            $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                            $('.fancy_lay_price_' + fancys[j].selection_id).text(fancys[j].lay_price1);
                                            $('.fancy_back_price_' + fancys[j].selection_id).text(fancys[j].back_price1);
                                            $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                            $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
                                        } else if (fancys[j].back_price1 == 0) {
                                            $('.fancy_lay_price_' + fancys[j].selection_id).text('-');
                                            $('.fancy_back_price_' + fancys[j].selection_id).text('-');
                                            $('.fancy_lay_size_' + fancys[j].selection_id).text('SUSPENDED');
                                            $('.fancy_back_size_' + fancys[j].selection_id).text('SUSPENDED');
                                        } else {
                                            $('.fancy_lay_price_' + fancys[j].selection_id).text(fancys[j].lay_price1);
                                            $('.fancy_back_price_' + fancys[j].selection_id).text(fancys[j].back_price1);
                                            $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                            $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
                                        }
                                    }
                                }




                            } else {
                                $('.fancy_lay_price_' + fancys[j].selection_id).parent().parent().fadeIn();
                                var fancyHtml = '';

                                if (!$('.fancy_' + fancys[j].selection_id).length) {
                                    fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236" data-id="31236">';

                                    fancyHtml += '<ul class="sport-high fancyListDiv">';
                                    fancyHtml += '<li>';
                                    fancyHtml += '<div class="ses-fan-box">';
                                    fancyHtml += '<table class="table table-striped  bulk_actions">';
                                    fancyHtml += '<tbody>';
                                    fancyHtml += '<tr class="session_content">';
                                    fancyHtml += '<td><span class="fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name + '</span><b class="fancyLia' + fancys[j].selection_id + '"></b><p class="position_btn"><button class="btn btn-xs btn-danger" onclick="getPosition(' + fancys[j].selection_id + ')">Book</button></td>';


                                    fancyHtml += '<td></td>';
                                    fancyHtml += '<td></td>';

                                    fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';

                                    fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancys[j].selection_id + '" id="LayNO_' + fancys[j].selection_id + '">' + fancys[j].lay_price1 + '</button>';

                                    fancyHtml += '<button id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</button></td>';

                                    fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';

                                    fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancys[j].selection_id + '" id="BackYes_' + fancys[j].selection_id + '">' + fancys[j].back_price1 + '</button>';

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

                                if (fancys[j].back_price1 == 'Ball') {
                                    $('.fancy_lay_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                    $('.fancy_back_price_' + fancys[j].selection_id).parent().attr('disabled', 'disabled');
                                } else {
                                    $('.fancy_lay_price_' + fancys[j].selection_id).text(fancys[j].lay_price1);
                                    $('.fancy_back_price_' + fancys[j].selection_id).text(fancys[j].back_price1);
                                    $('.fancy_lay_size_' + fancys[j].selection_id).text(fancys[j].lay_size1);
                                    $('.fancy_back_size_' + fancys[j].selection_id).text(fancys[j].back_size1);
                                }
                            }




                        }
                    }
                }
            }
        });


        socket.on('betting_placed', function(data) {
            fetchBttingList();
        });

        socket.on('betting_settle', function(data) {
            fetchBttingList();
        });
    });

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

    function add_new_chip() {
        var html = '';
        html += '<div class="fullrow">'
        html += '<input type="hidden" name="user_chip_id[]" class="form-control" required />';
        html += '<div class="col-md-6 col-sm-6col-xs-6">';
        html += '<div class="form-group"><label for="email">Chips Name :</label><input type="text" name="chip_name[]" class="form-control" required value=""></div>';
        html += '</div>';
        html += '<div class=" col-md-6 col-sm-6col-xs-6">';
        html += '<div class="form-group"><label for="pwd">Chip Value :</label><input type="number" name="chip_value[]" class="form-control" required value=""></div>';
        html += '</div>';
        html += '</div>';

        $('#chip-moddal-body').append(html);
    }


    $(function() {
        socket.on('block_markets', function(data) {
            console.clear();
            console.log('block_markets', data)
            console.log('superiors', superiors);
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
                console.log('superior_id', superior_id);
                if (checkSuperiorUser) {
                    console.log('Master Found');
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

                } else {
                    console.log('Master Not Found');
                }
            }
        });
    })

    $(function() {
        // $(".market_countdown").each(function() {
        //     var timer_id = $(this).attr("id");
        //     var timer_data_id = $(this).attr("data-id");


        //     var timeleft = $(this).text();
        //     var a = setInterval(function() {
        //         timeleft -= 1;

        //         if (timeleft <= 0) {
        //             // clearInterval(a);
        //             $('.overlay_matchBoxs_' + timer_data_id).fadeIn();

        //             $(this).text(0);

        //         } else {
        //             console.log(timeleft);
        //             // document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
        //             console.log($('#' + timer_id));
        //             $('#' + timer_id).html(timeleft);
        //         }
        //     }, 1000);
        // })
    })
</script>

<script src="<?php echo base_url(); ?>assets/js/player.min.js"></script>
<script>
    var player;
    var config = {
        "source": {
            "bintu": {
                "apiurl": "https://bintu.nanocosmos.de",
                "streamid": "3b90fd17-a1fc-402c-84ee-20740c1dc097"
            },
            "entries": [],
            "options": {
                "adaption": {},
                "switch": {}
            },
            "startIndex": 0
        },
        "playback": {
            "autoplay": true,
            "automute": true,
            "muted": true,
            "flashplayer": "//demo.nanocosmos.de/nanoplayer/nano.player.swf"
        },
        "style": {
            "displayMutedAutoplay": false,
            width: '100%',
            height: "100%",
            aspectratio: '16/9',
            controls: false,
            scaling: 'letterbox'
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
        player = new NanoPlayer("playerDiv");
        player.setup(config).then(function(config) {

        }, function(error) {
            alert(error.message);
        });
    });
</script>