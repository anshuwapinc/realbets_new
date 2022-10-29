<link rel="stylesheet" href="<?php echo base_url(); ?>assets/exchange/flipclock.css">
<script src="<?php echo base_url(); ?>assets/exchange/flipclock.js" type="text/javascript"></script>

<script>
    var socket = io.connect('<?php echo get_ws_endpoint(); ?>', {
        transports: ['websocket'],
        rememberUpgrade: false
    });
</script>
<div class="right_col" role="main" style="width:100vw">
    <div class="fullrow tile_count">
        <div class="col-md-7">
            <div id="videoContainer" style="position:relative;">
                <iframe src="<?php echo $videoLink; ?>" style="border-radius: 1px;width:100%;height:202px;overflow:hidden !important;"></iframe>
                <div data-v-91269fe6="" class="video-overlay">

                </div>
                <!-- <span class="timer_wrapper"><span id="timer" class="timer">
                    </span></span>
                </span> -->

                <div class="clock clock2digit">

                </div>
            </div>
            <div id="casino-detail-parent">
                <div id="casino-detail">
                    <span class="round_id_wrapper">Round Id: <span id="round_id" class="round_id">
                        </span></span>

                    <!-- 
                <span class="winner_wrapper">Winner: <span id="winner" class="winner">
                    </span></span> -->


                    <span class="winner_wrapper"><a style="float:right;color:white" href="javascript:void(0);" onclick="getLastResult()">View Result</a></span>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div id="MatchOddInfo">
                            <!------------------Exchange Response Show here----------------->
                            <?php // echo $marketExchangeHtml; 
                            ?>
                            <!------------------Exchange Response Show here----------------->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div data-v-3e1a64f3="" class="modal-header mod-header">


                            <h5 data-v-3e1a64f3="">Last Result
                                <!-- <a data-v-3e1a64f3="" href="/casinoresults/teen" class="result-view-all">View All</a> -->
                            </h5>
                        </div>
                        <div data-v-3e1a64f3="" class="m-b-10" style="    float: right;
">
                            <p data-v-3e1a64f3="" id="last-result" class="text-right">
                            </p>
                        </div>
                    </div>
                </div>
                <div id="card-result" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header mod-header"><button type="button" class="close" data-dismiss="modal">×</button>
                                <h4 class="modal-title" id="result-modal-header" >20-20 Teenpatti Result</h4>
                            </div>
                            <div class="modal-body card-result-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------Fancy API Response show here------------------->
        </div>
        <div class="col-md-5 col-xs-12 matchBox">



            <div class="betSlipBox" style="">
                <div class="betBox bet-slip-box" style="display: none;">
                    <span id="msg_error"></span><span id="errmsg"></span>
                    <div class="lds-dual-ring  loader" style="display:none"></div>
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
                                    <button class="btn btn-success CommanBtn placefancy" type="button" onclick="PlaceBet();" style="display:none"> Place Bet</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!--- Match UnMatch data --->


            <div class="mod-header tab_bets betsheading" style="">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item betdata all-bet-tab-menu active">
                        <a class="allbet" href="javascript:void(0);" onclick="getDataByType('all','all-bet-tab-menu');"><span class="bet-label">All Bet</span>
                            <span class="bat_counter" id="cnt_row">(0)</span></a>
                    </li>
                    <!-- <li class="nav-item betdata">
                            <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType(this,'2');"><span class="bet-label">UnMatch Bet</span>
                                <span class="bat_counter" id="cnt_row1">(0)</span> </a>
                        </li> -->

                    <li class="nav-item full-screen">

                        <a class="btn full-btn" onclick="viewAllMatch()" href="javascript:void(0);"><i class="fas fa-compress"></i></a>
                    </li>
                </ul>
            </div>



            <div class="" id="MatchUnMatchBetaData">
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
                </script>


                <div id="accountView" class="tableid2 accountViewcls" role="main" style="display: none;">
                    <span id="msg_error"></span><span id="errmsg"></span>
                    <div class="balance-panel-body">
                        <div class="table-responsive sports-tabel" id="UnMatchBets">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="heading_user_table">
                                        <td> Actions</td>
                                        <td>Runner </td>
                                        <td>Bet type</td>

                                        <td> Client</td>
                                        <td> Odds</td>
                                        <td> Stack</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="accountView" class="tableid3 accountViewcls" role="main" style="display: none;">
                    <span id="msg_error"></span><span id="errmsg"></span>
                    <div class="balance-panel-body">
                        <div class="table-responsive sports-tabel">
                            <table class="table table-bordered table-hover ">
                                <thead>
                                    <tr class="heading_user_table">

                                        <td>No.</td>
                                        <td>Runner</td>
                                        <td>Bet Type</td>

                                        <td> Client</td>
                                        <td>Odds</td>
                                        <td>Stack</td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="accountView" class="tableid4 accountViewcls" role="main" style="display: block;">
                    <span id="msg_error"></span><span id="errmsg"></span>
                    <div class="balance-panel-body">
                        <div class="table-responsive sports-tabel">
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




                <script>
                    function deleteAllMatchOdds(MstCode, UserId, code, remark) {
                        $.ajax({
                            url: site_url + 'useraction/deleteAllbettingMatch',
                            data: {
                                MstCode: MstCode,
                                UserId: UserId,
                                code: code,
                                remark: remark
                            },
                            type: 'get',
                            dataType: 'json',
                            success: function(output) {
                                if (output.error == '0') {
                                    var arrayMstCode = MstCode.split(',');
                                    $.each(arrayMstCode, function(keyNew, valueNew) {
                                        var mstID = valueNew;
                                        jQuery("#user_row_" + mstID).remove(); //Deleted Successfully ...											 
                                    });
                                    new PNotify({
                                        title: 'Success',
                                        text: output.message,
                                        type: 'success',
                                        styling: 'bootstrap3',
                                        delay: 3000
                                    });
                                    $('#fancyposition').modal('hide');
                                } else {

                                    new PNotify({
                                        title: 'Error',
                                        text: output.message,
                                        type: 'error',
                                        styling: 'bootstrap3',
                                        delay: 3000
                                    });
                                }
                            }
                        });

                    }

                    function filterBets(MatchId, MarketId) {
                        var searchId = $('#searchId').val();
                        $.ajax({
                            url: site_url + 'Application/GatBetData',
                            data: {
                                marketId: MarketId,
                                matchId: MatchId,
                                searchId: searchId
                            },
                            type: 'get',
                            dataType: 'html',
                            success: function(output) {
                                //console.log("viewMAtchUnMAtch"+output);
                                //alert("reset")
                                //console.log(output);
                                $("#MatchUnMatchBetaData").show();
                                $("#MatchUnMatchBetaData").html(output);
                            }
                        });
                    }

                    function filterReset(MatchId, MarketId) {
                        var searchId = '';
                        $.ajax({
                            url: site_url + 'Application/GatBetData',
                            data: {
                                marketId: MarketId,
                                matchId: MatchId,
                                searchId: searchId
                            },
                            type: 'get',
                            dataType: 'html',
                            success: function(output) {
                                //console.log(output);
                                //alert("reset")
                                $("#MatchUnMatchBetaData").show();
                                $("#MatchUnMatchBetaData").html(output);

                            }
                        });
                    }
                </script>
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





<div id="casinoResult" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header mod-header"><button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Casino Results</h4>
            </div>
            <div class="modal-body casino-result-body">

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

    // <li>
    //                                 <a class="btn-pin 31057636">Match Odds</a>
    //                             </li>
    function generateMarketStructure(market, market_type) {
        var exchangeHtml = '';
        var exposure = 0;
        if (market_type.runners) {
            exchangeHtml += `
        <div class="tabel-scroll-4 matchBoxMain matchOpenBox_1190470587 market_box_${market_type.market_id} matchBoxs_${market.event_id} matchBox_${market.event_id} ">
                    <div class="market-listing-table 1190470587  matchTable1190470587    " id="matchTable31057636">

                        <button class="btn btn-primary btn-xs dismiss_btn" onclick="closeBetBox(31057636, '1.190470587')">X</button>
                        <div class="game-head">
                        <ul class="match-btn">

                            
                                <li> <a class="btn-pin-user" onclick="getUserPosition(31057636,'1.190470587')"><i class="fas fa-boxes"></i> ${market.event_name}</a>
                                </li>

                            </ul>
                            </div>
                         <div class="bet_mob">
                            <div class="maxminstake">Min :10.00Max :5000.00 </div>
                            <div class="w-56"></div>
                            <div class="w-56"></div>
                            <div class="player-draw w-56 ">Back </div>
                            <div class="player-draw w-56">Lay </div>
                            <div class="w-56"></div>
                            <div class="w-56"></div>
                            </div>`;


            $.each(market_type.runners, function(index, runner) {


                exchangeHtml += `<div id="user_row" class="odds_rows back_lay_color runner-row-1 matchOpenBox_${market_type.market_id.replace('.', '')}_${runner.selection_id}">
                                    <div class="events_odds">
                                        <div class="event-name" id="runnderName0">

                                            <div class="team-details">
                                                <div class="horce-pop-team runner_text" id="runnderName1"> <i class="fas fa-chart-bar"></i>${runner.runner_name}</div>
                                            </div>
                                            <small class="ng-scope odds_value blue-odds" style="color:#333" id="Val1-${runner.event_id}">
                                                <i class="fas fa-caret-right"></i> 0 </small>
                                        </div>
                                        <div class="valuename">
                                        <span class="runner_amount" style="color:${exposure < 0?'tomato':'green'};" id="${runner.selection_id +'_maxprofit_loss_runner_'+market_type.market_id.replace('.', '')}">${Math.abs(exposure)}</span>
                                        <input type="hidden" class="position_${market_type.market_id.replace('.', '')}" id="selection_0" data-id="${runner.selection_id}" value="${exposure}">   
                                        

                                        </div>
                                    </div>

                                    <div class="odds_group">
                                        <div class="backbattingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${1}','${runner.runner_name}','availableToBack3_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="back betting-blue   ">
                                                <strong class=" priceRate odds ng-binding" id="availableToBack3_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_3_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack3_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_3_size}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="backbattingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${1}','${runner.runner_name}','availableToBack2_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="back betting-blue   ">
                                                <strong class=" priceRate odds ng-binding" id="availableToBack2_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_2_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack2_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_2_size}</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="backbattingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${1}','${runner.runner_name}','availableToBack1_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="back betting-blue  mark-back ">
                                                <strong class=" priceRate odds ng-binding" id="availableToBack1_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_1_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack1_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.back_1_size}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!--- availableToLay -->
                                        <div class="laybettingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${0}','${runner.runner_name}','availableToLay1_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="lay betting-pink mark-lay">
                                                <strong class=" priceRate odds ng-binding" id="availableToLay1_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_1_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToLay1_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_1_size}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="laybettingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${0}','${runner.runner_name}','availableToLay2_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="lay betting-pink ">
                                                <strong class=" priceRate odds ng-binding" id="availableToLay2_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_2_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToLay2_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_2_size}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="laybettingbox" onclick="getOddValue('${market.event_id}','${market_type.market_id}','${0}','${runner.runner_name}','availableToLay3_price_${market_type.market_id.replace('.', '')}_${runner.selection_id}',
                                        ${runner.selection_id},'B','this');">
                                            <div class="lay betting-pink ">
                                                <strong class=" priceRate odds ng-binding" id="availableToLay3_price_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_3_price}</strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToLay3_size_${market_type.market_id.replace('.', '') + '_' + runner.selection_id }">${runner.lay_3_size}</span>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>`;

            });

            exchangeHtml += `</div></div>`;
            //TD FOR RUNNER VALUE ONE
        }
        $("#MatchOddInfo").append(exchangeHtml);
    }

    $(function() {
        setTimeout(function() {
            fetchBttingList()
        }, 1000);
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


    function getOddValue(matchId, marketId, back_layStatus, placeName, elementId, selectionId, MarketTypes = '', target) {

        var priceVal = $('#' + elementId).text();
        // if (matchId == '56767') {
        //     priceVal = parseFloat(((priceVal / 100) + 1));

        // }
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
            $(".betBox").insertAfter('.matchBoxMain');
            // $(".betBox").insertAfter('.matchOpenBox_' + MId + '_' + selectionId);
            // if (gameType != 'market') {
            //    $("#betslip").insertAfter('.teenpatti-row');
            // } else {
            // $(".betBox").insertAfter('.matchOpenBox_' + MId + '_' + selectionId);
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
            var pl = ((priceVal * t_stake) / 100);

            //    } else {
            var pl = ((priceVal * t_stake) - t_stake);
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
            var currV = (curr);

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
    function showloader() {
        $(".loader").css('display', "");
    }

    function PlaceBet() {
        showloader();
        clearTimeout(betSlip);

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
                    url: '<?php echo base_url(); ?>admin/Events/saveCasinoBet',
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

                        getEventsMarketExpsure(<?php echo $event_id; ?>);

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
            if (isback != 1) {
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
    var clock = new FlipClock($(".clock"), {
        clockFace: "Counter"
    });


    $(document).ready(function() {


        // var clock = '';
        <?php


        if (isset($_GET['match_id']) && isset($_GET['market_id'])) { ?>
            MarketSelection(<?php echo $_GET['market_id']; ?>, <?php echo $_GET['match_id']; ?>, "<?php echo isset($_GET['event_type']) ? $_GET['event_type'] : null; ?>");
        <?php } ?>


        var casino_market_id = '';
        //Teenpati T20 Casino


        <?php
        if ($event_id == 56768) { ?>
            socket.on('casino_t20_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(marketTypeIndex, market_type) {


                            if (market_type.market_id == 0) {
                                return false;
                            }


                            if (market_type.market_name == 'Match Odds') {

                                let cardsInfo = market.additional_info;
                                showT20Cards(cardsInfo);

                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');

                                    clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);


                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().find("h6").remove();
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            showLastResult();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);

                                        $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                        
                                        if (cardsInfo.autotime >= 5) {
                                            if (runner.back_1_price == 0) {                                               
                                                $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().append('<h6 class="lock_back_overlay"><i class="fa fa-lock" aria-hidden="true"></i></h6>');
                                            } else {
                                                $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            }
                                            if (runner.lay_1_price == 0) {
                                               
                                                $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().append('<h6 class="lock_lay_overlay"><i class="fa fa-lock" aria-hidden="true"></i></h6>');
                                            } else {
                                                $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            }

                                        }
                                        
                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }



                                        if (!$('.market_box_' + market_type.market_id).length) {

                                            if (market_type.runners.length >= 2) {
                                                generateMarketStructure(market, market_type);

                                            }
                                        }
                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }



                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");

                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }

                                        // if (marketTypeIndex == 0) {
                                        //     if (!$('.market_box_' + market_type.market_id).length) {

                                        //         if (market_type.runners.length >= 2) {
                                        //             generateMarketStructure(market, market_type);

                                        //         }
                                        //     }
                                        // }


                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati T20 Casino



        //Teenpati LTP Casino
        <?php
        if ($event_id == 56767) { ?>
            socket.on('casino_ltp_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {
                            if (market_type.market_id == 0) {
                                return false;
                            }
                            if (market_type.market_name == 'Match Odds') {
                                let cardsInfo = market.additional_info;
                                showLiveTeenCards(cardsInfo);
                                $.each(market_type.runners, function(index, runner) {



                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    // clock.setValue(cardsInfo.autotime);



                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().find("h6").remove();
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            showLastResult();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);
                                        $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                        
                                        if (cardsInfo.autotime >= 5) {
                                            if (runner.back_1_price == 0) {                                               
                                                $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().append('<h6 class="lock_back_overlay"><i class="fa fa-lock" aria-hidden="true"></i></h6>');
                                            } else {
                                                $('#availableToBack1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            }
                                            if (runner.lay_1_price == 0) {
                                               
                                                $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().append('<h6 class="lock_lay_overlay"><i class="fa fa-lock" aria-hidden="true"></i></h6>');
                                            } else {
                                                $('#availableToLay1_price_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().parent().find('h6').remove();
                                            }

                                        }

                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }



                                        if (!$('.market_box_' + market_type.market_id).length) {
                                            if (market_type.runners.length >= 2) {
                                                generateMarketStructure(market, market_type);
                                            }
                                        }

                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }
                                        $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati LTP Casino

        //Teenpati DT20 Casino
        <?php
        if ($event_id == 98790) { ?> socket.on('casino_dt20_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {

                            if (market_type.market_name == 'Match Odds') {

                                let cardsInfo = market.additional_info;
                                dragonTigerCards(cardsInfo)
                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    // clock.setValue(cardsInfo.autotime);



                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)

                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().find("h6").remove();
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            showLastResult();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);


                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }


                                        if (market_type.runners.length == 3) {
                                            if (!$('.market_box_' + market_type.market_id).length) {
                                                generateMarketStructure(market, market_type);
                                            }
                                        }
                                    } else if (runner.status == 'SUSPENDED') {

                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }

                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati DT20 Casino


        //Teenpati 7ud Casino
        <?php
        if ($event_id == 98789) { ?> socket.on('casino_7ud_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);

                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {

                             if(market_type.market_id.substr(0, 1) == 0)
                            {
                                return false;
                            }
                            if (market_type.market_name == 'Match Odds') {
                                let cardsInfo = market.additional_info;
                                sevenUpDownCards(cardsInfo)
                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    // clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    clock.setValue(cardsInfo.autotime);


                                    $('#round_id').text(round_id[1]);



                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                  


                                    console.log('market_type.status', market_type.status);



                                    if (market_type.status == 'OPEN') {

                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            showLastResult();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);

                                        console.log('cardsInfo.autotime',cardsInfo.autotime);
                                        $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();
                                        if (cardsInfo.autotime < 2) {
                                            // ClearAllSelection(1);


                                            $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().append('<h6>SUSPENDED</h6>');
                                            $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                            $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();
                                        }



                                        if (!$('.market_box_' + market_type.market_id).length) {
                                            if (market_type.runners.length > 1) {
                                                generateMarketStructure(market, market_type);
                                            }

                                        }
                                    }

                                

                                    if (runner.status == 'OPEN') {

                                        console.log('classs :::::::::',`.matchOpenBox_${runner.market_id.replace('.', '')}_${runner.selection_id}`);

                                        $(`.matchOpenBox_${runner.market_id.replace('.', '')}_${runner.selection_id}`).find('h6').remove()
                                        // $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();

                                        console.log('RUnner is active');
                                        $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                        $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();


                                        // $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");


                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }

                                        if ($('.market_box_' + market_type.market_id).length) {
                                            // $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().append('<h6>SUSPENDED</h6>');


                                            // $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).closest('.betting-pink').append('<h6>SUSPENDED</h6>');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (runner.status == 'CLOSED') {
                                        $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>CLOSED</h6>");
                                        $('#availableToBack1_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati 7ud Casino

        //Teenpati 32c Casino
        <?php
        if ($event_id == 56967) { ?> socket.on('casino_32c_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {

                            if (market_type.market_name == 'Match Odds') {

                                let cardsInfo = market.additional_info;
                                // console.log("cardsInfo", cardsInfo);
                                ttCards(cardsInfo);

                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    // clock.setValue(cardsInfo.autotime);



                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().find("h6").remove();
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);


                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }


                                        if (market_type.runners.length == 4) {
                                            if (!$('.market_box_' + market_type.market_id).length) {
                                                generateMarketStructure(market, market_type);
                                            }
                                        }



                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }

                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati 32c Casino



        //Teenpati AAA Casino
        <?php
        if ($event_id == 98791) { ?> socket.on('casino_aaa_market_update', function(data) {


                // console.log('data', data);
                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {

                            if (market_type.market_name == 'Match Odds') {
                                let cardsInfo = market.additional_info;

                                amarAkbarAnthonyCards(cardsInfo);

                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    // clock.setValue(cardsInfo.autotime);



                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().find("h6").remove();
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            showLastResult();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);


                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }




                                        if (market_type.runners.length == 3) {
                                            if (!$('.market_box_' + market_type.market_id).length) {
                                                generateMarketStructure(market, market_type);
                                            }
                                        }

                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }

                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>SUSPENDED</h6>");
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati AAA Casino

        //Teenpati AB Casino
        <?php
        if ($event_id == 87564) { ?> socket.on('casino_ab_market_update', function(data) {

                var MarketId = $('#MarketId').val();
                var matchId = "<?php echo $event_id; ?>";

                var market = data.marketodds.find(o => o.event_id == matchId);
                if (market) {

                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {

                            if (market_type.market_name == 'Match Odds') {
                                $.each(market_type.runners, function(index, runner) {

                                    var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                    var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                    var round_id = tmp_round_id.split('.');


                                    // clock.setValue(cardsInfo.autotime);
                                    // $('#timer').text(market_type.timer);
                                    clock.setValue(cardsInfo.autotime);



                                    $('#round_id').text(round_id[1]);

                                    $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                    if (market_type.status == 'OPEN') {
                                        var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                        var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                        if (casino_market_id_1 != casino_market_id) {

                                            getLastResult(matchId, casino_market_id)
                                            $('.matchBoxMain').remove();
                                            fetchBttingList();
                                            casino_market_id = casino_market_id_1;


                                        }

                                        // $('#round_id').text(roundId);


                                        if (cardsInfo.autotime < 5) {
                                            // ClearAllSelection(1);

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                        } else {

                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                            $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                        }



                                        if (!$('.market_box_' + market_type.market_id).length) {
                                            generateMarketStructure(market, market_type);
                                        }
                                    } else if (runner.status == 'SUSPENDED') {
                                        // runner.status == 'SUSPENDED'
                                        // if (!$('.market_box_' + market_type.market_id).length) {
                                        //     generateMarketStructure(market, market_type);
                                        // }

                                        if ($('.market_box_' + market_type.market_id).length) {
                                            $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                            // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                            // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                        }
                                    } else if (market_type.status == 'CLOSED') {
                                        if ($('.market_box_' + market_type.market_id).length) {

                                            $('.market_box_' + market_type.market_id).remove();
                                        }
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
                            }

                        });
                    }
                }

            });
        <?php } ?>
        //Teenpati AB Casino



        socket.on('casino_market_update', function(data) {
            return false;
            var MarketId = $('#MarketId').val();
            var matchId = "<?php echo $event_id; ?>";
            // if (MarketId) {

            // var market = data.marketodds[matchId]

            var market = data.marketodds.find(o => o.event_id == matchId);
            if (market) {

                if (market.market_types.length > 0) {
                    $.each(market.market_types, function(index, market_type) {

                        if (market_type.market_name == 'Match Odds') {
                            $.each(market_type.runners, function(index, runner) {

                                var tmp_round_id = market_type.market_id.replace('__', '.').split('_')

                                var tmp_round_id = tmp_round_id[0] ? tmp_round_id[0] : '';

                                var round_id = tmp_round_id.split('.');


                                clock.setValue(cardsInfo.autotime);
                                // $('#timer').text(market_type.timer);


                                $('#round_id').text(round_id[1]);

                                $('#market_countdown_' + market_type.market_id.replace('.', '')).text(market_type.timer)
                                if (market_type.status == 'OPEN') {
                                    var tmp_casino_market_id = market_type.market_id.replace('__', '.').split('_')

                                    var casino_market_id_1 = tmp_casino_market_id[0] ? tmp_casino_market_id[0] : '';


                                    if (casino_market_id_1 != casino_market_id) {

                                        getLastResult(matchId, casino_market_id)
                                        $('.matchBoxMain').remove();
                                        fetchBttingList();
                                        casino_market_id = casino_market_id_1;


                                    }

                                    // $('#round_id').text(roundId);


                                    if (cardsInfo.autotime < 5) {
                                        // ClearAllSelection(1);

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();
                                    } else {

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                        $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();
                                    }



                                    if (!$('.market_box_' + market_type.market_id).length) {
                                        generateMarketStructure(market, market_type);
                                    }
                                } else if (runner.status == 'SUSPENDED') {
                                    // runner.status == 'SUSPENDED'
                                    // if (!$('.market_box_' + market_type.market_id).length) {
                                    //     generateMarketStructure(market, market_type);
                                    // }

                                    if ($('.market_box_' + market_type.market_id).length) {
                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');
                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();


                                        // $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                    }
                                } else if (market_type.status == 'CLOSED') {
                                    if ($('.market_box_' + market_type.market_id).length) {

                                        $('.market_box_' + market_type.market_id).remove();
                                    }
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
                        }

                    });
                }
            }

            // }

        });


        socket.on('betting_placed', function(data) {
            setTimeout(function() {
                getEventsMarketExpsure(<?php echo $event_id; ?>);

            }, 2000);
            fetchBttingList();
        });

        socket.on('betting_settle', function(data) {
            // fetchBttingList();
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
    showLastResult();
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


    function getLastResult(match_id) {
        showLastResult();
        return false;
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Events/getCasinoLastResult',
            data: {
                match_id: '<?php echo $event_id; ?>',
            },
            type: "POST",
            dataType: "json",
            success: function success(output) {
                $('.casino-result-body').html(output.resultHtml)
                $('#casinoResult').modal('show');
            }
        });
    }


    function showT20Cards(cardsInfo) {
        let html = `		<div data-v-91269fe6="" class="videoCards">
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">PLAYER A</h3>
                            <div data-v-91269fe6="" id="player-a-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C1}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C2}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C3}.png">
                            </div>
                        </div>
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">PLAYER B</h3>
                            <div data-v-91269fe6="" id="player-b-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C4}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C5}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C6}.png">
                            </div>
                        </div>
                    </div>`;

        $(".video-overlay").html(html);
    }

    function showLiveTeenCards(cardsInfo) {
        let html = `		<div data-v-91269fe6="" class="videoCards">
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">PLAYER A</h3>
                            <div data-v-91269fe6="" id="player-a-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C1}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C3}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C5}.png">
                            </div>
                        </div>
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">PLAYER B</h3>
                            <div data-v-91269fe6="" id="player-b-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C2}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C4}.png">
                                <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C6}.png">
                            </div>
                        </div>
                    </div>`;

        $(".video-overlay").html(html);
    }

    function sevenUpDownCards(cardsInfo) {
        console.log("cardsInfo",cardsInfo);
        let html = `		<div data-v-91269fe6="" class="videoCards">
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">CARD</h3>
                            <div data-v-91269fe6="" id="player-a-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C1}.png">
                    
                            </div>
                        </div>
             
                    </div>`;

        $(".video-overlay").html(html);
    }

    function amarAkbarAnthonyCards(cardsInfo) {
        let html = `		<div data-v-91269fe6="" class="videoCards">
                        <div data-v-91269fe6="">
                            <h3 data-v-91269fe6="" class="text-white">CARD</h3>
                            <div data-v-91269fe6="" id="player-a-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C1}.png">
                    
                            </div>
                        </div>
             
                    </div>`;

        $(".video-overlay").html(html);
    }

    function dragonTigerCards(cardsInfo) {
        let html = `		<div data-v-91269fe6="" class="videoCards">
                        <div data-v-91269fe6="">
                          
                            <div data-v-91269fe6="" id="player-a-cards">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C1}.png">
                               <img data-v-91269fe6="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardsInfo.C2}.png">
                    
                            </div>
                        </div>
             
                    </div>`;

        $(".video-overlay").html(html);
    }

    function ttCards(cardsInfo) {
        $(".videoCards p").css('font-size', '8px');
        // $(".video-overlay").css('background-color','#000');
        // $("#casino-detail-parent").css('top','76px');
        // $("#casino-detail-parent").css('position','relative');
        const myArrayname = cardsInfo.desc.split(",");
        const allEqual = myArrayname.every(v => v == 1);
        let html = `<div data-v-91269fe6="" class="videoCards">
                    
                                <div data-v-3bb6c088="">
                        <p data-v-3bb6c088="" class="m-b-0 text-white" style="font-size:10px">
                            <b data-v-3bb6c088="">
                            <span data-v-3bb6c088="" class="">Player 8</span>
                            : <span data-v-3bb6c088="" class="text-warning">${cardsInfo.C1}</span>
                            </b>
                        </p>
                        <div data-v-3bb6c088="">
                            <img data-v-3bb6c088="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${myArrayname[0]}.png" style="width:15px">
                        </div>
                        </div>


                        <div data-v-3bb6c088="">
                        <p data-v-3bb6c088="" class="m-b-0 text-white" style="font-size:10px">
                            <b data-v-3bb6c088="">
                            <span data-v-3bb6c088="" class="">Player 9</span>
                            : <span data-v-3bb6c088="" class="text-warning">${cardsInfo.C2}</span>
                            </b>
                        </p>
                        <div data-v-3bb6c088="" >
                            <img data-v-3bb6c088="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${myArrayname[1]}.png" style="width:15px">
                        </div>
                        </div>


                        <div data-v-3bb6c088="">
                        <p data-v-3bb6c088="" class="m-b-0 text-white" style="font-size:10px">
                            <b data-v-3bb6c088="">
                            <span data-v-3bb6c088="" class="">Player 10</span>
                            : <span data-v-3bb6c088="" class="text-warning">${cardsInfo.C3}</span>
                            </b>
                        </p>
                        <div data-v-3bb6c088="">
                            <img data-v-3bb6c088="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${myArrayname[2]}.png" style="width:15px">
                        </div>
                        </div>


                        <div data-v-3bb6c088="">
                        <p data-v-3bb6c088="" class="m-b-0 text-white" style="font-size:10px">
                            <b data-v-3bb6c088="">
                            <span data-v-3bb6c088="" class="">Player 11</span>
                            : <span data-v-3bb6c088="" class="text-warning">${cardsInfo.C4}</span>
                            </b>
                        </p>
                        <div data-v-3bb6c088="">
                            <img data-v-3bb6c088="" src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${myArrayname[3]}.png" style="width:15px">
                        </div>
                        </div>
             
                    </div>`;
        if (allEqual) {
            $(".video-overlay").html("");
        } else {
            $(".video-overlay").html(html);
        }

    }

    function showLastResult() {
        let rList = '';
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Events/getCasinoLastResult',
            data: {
                match_id: '<?php echo $event_id; ?>',
                type: "NOTHTML"
            },
            type: "POST",
            dataType: "json",
            success: function success(output) {
                // console.log("output.resultHtml", output.resultHtml);
                output.resultHtml.map((val, index) => {

                    if ("<?php echo $event_id ?>" == 98789) {
                        if (val.player == "LOW Card") {
                            // console.log(val.player);
                            rList += `<span onclick="showCardOfResult('24.${val.market_id}','','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">L</span>`;
                        } else {
                            rList += `<span onclick="showCardOfResult('24.${val.market_id}','','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playerb last-result">H</span>`;
                        }
                    } else if ("<?php echo $event_id ?>" == 98790) {
                        if (val.player == "Tiger") {
                            // console.log(val.player);
                            rList += `<span onclick="showCardOfResult('25.${val.market_id}','Tiger','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">T</span>`;
                        } else {
                            rList += `<span onclick="showCardOfResult('25.${val.market_id}','Dragon','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playerb last-result">D</span>`;
                        }
                    } else if ("<?php echo $event_id ?>" == 56967) {
                        if (val.player == "Player 8") {

                            rList += `<span onclick="showCardOfResult('29.${val.market_id}','Player 8','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">8</span>`;
                        }
                        if (val.player == "Player 9") {

                            rList += `<span onclick="showCardOfResult('29.${val.market_id}','Player 9','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">9</span>`;
                        }
                        if (val.player == "Player 10") {

                            rList += `<span onclick="showCardOfResult('29.${val.market_id}','Player 10','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">10</span>`;
                        }
                        if (val.player == "Player 11") {

                            rList += `<span onclick="showCardOfResult('29.${val.market_id}','Player 11','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">11</span>`;
                        }
                    } else if ("<?php echo $event_id ?>" == 56768) {
                        if (val.player == "Player A") {
                            // console.log(val.player);
                            rList += `<span onclick="showCardOfResult('${val.market_id}','Player A','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">A</span>`;
                        } else {
                            rList += `<span onclick="showCardOfResult('${val.market_id}','Player B','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playerb last-result">B</span>`;
                        }
                    } else if ("<?php echo $event_id ?>" == 56767) {
                        if (val.player == "Player A") {
                            // console.log(val.player);
                            rList += `<span onclick="showCardOfResult('${val.market_id}','Player A','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">A</span>`;
                        } else {
                            rList += `<span onclick="showCardOfResult('${val.market_id}','Player B','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playerb last-result">B</span>`;
                        }
                    } else if ("<?php echo $event_id ?>" == 98791) {

                        if (val.player == "Amar") {

                            rList += `<span onclick="showCardOfResult('27.${val.market_id}','Amar','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">A</span>`;
                        }
                        if (val.player == "Akbar") {

                            rList += `<span onclick="showCardOfResult('27.${val.market_id}','Akbar','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">B</span>`;

                        }
                        if (val.player == "Anthony") {

                            rList += `<span onclick="showCardOfResult('27.${val.market_id}','Anthony','${val.selection_id}')" data-v-3e1a64f3="" class="ball-runs playera last-result">C</span>`;
                        }

                    }
                })


                $("#last-result").html(rList);
            }
        });


    }

    function showCardOfResult(mid, pname, selection_id) {

        $.ajax({
            url: "<?php echo base_url(); ?>admin/events/showCardOfResult",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                market_id: mid,
            },
            success: function success(output) {
                cardResultHtml(output, mid, pname, selection_id)

            }
        });

    }

    function cardResultHtml(data, mid, pname, selection_id) {
        let html;
        if ("<?php echo $event_id ?>" == 56767 || "<?php echo $event_id ?>" == 56768) {
            var round_id = mid.split("_")[0];
            var cardArr = data.t1.card.split(",");
        } else {
            var round_id = mid.split(".")[1];
            var cardArr = data[0].cards.split(",");
            var sid = data[0].sid.split(",");
        }

        if ("<?php echo $event_id ?>" == 56767 || "<?php echo $event_id ?>" == 56768) {


            if ("<?php echo $event_id ?>" == 56767) {
                $("#result-modal-header").text("Teenpatti 1 Day  Result");
            }

            let onewinicon = "";
            let twowinicon = "";
            if (data.t1.win == selection_id) {


                if (pname == "Player A") {
                    onewinicon = `<div class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
                if (pname == "Player B") {
                    twowinicon = `<div class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
            }
            html = `<div>
                    <h6 class="text-right round-id"><b>Round Id:</b> ${round_id}
                    </h6>
                    <div class="nrow">
                        <div class="col-md-6 br1 text-center">
                            <h4>Player A</h4>
                            <div class="result-image">
                        
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[0]}.png" class="mr-2"> 
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[2]}.png" class="mr-2">
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[4]}.png" class="mr-2">
                            
                            </div>
                            ${onewinicon}
                            
                        </div>
                        <div class="col-md-6 text-center">
                            <h4>Player B</h4>
                            <div class="result-image">

                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[1]}.png" class="mr-2"> 
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[3]}.png" class="mr-2">
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[5]}.png" class="mr-2">
                            
                            </div>
                            ${twowinicon}
                        </div>
                    </div>
                    </div>`;
        }

        // low high
        else if ("<?php echo $event_id ?>" == 98789) {
            $("#result-modal-header").text("7 Up Down Result");
            html = `<div>
                <h6 class="text-right round-id">
                <b>Round Id:</b> ${round_id}
                </h6> 
                <div class="row">
                <div class="col-12 text-center">
                <div class="result-image">
                <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${data[0].cards}.png" class="mr-2">
                </div>
                </div>
                </div> 
                <div class="row mt-3">
                <div class="col-12 text-center">
                <div class="winner-board">
                <div class="mb-1">
                <span class="text-success">Result:</span> <span>${data[0].desc}</span></div></div></div></div></div>`;
        }

        // dragon tiger
        else if ("<?php echo $event_id ?>" == 98790) {
            $("#result-modal-header").text("Dragon Tiger T20 Result");

            let newdes = data[0].desc.split('*');
            html = `<div><h6 class="text-right round-id"><b>Round Id:</b> 210911172955
                </h6> <div class="row"><div class="col-12 text-center">
                <div class="result-image">
                <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[0]}.png" class="mr-2"> 
                <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[1]}.png" class="mr-2">
                </div>
                </div>
                </div> 
                <div class="row mt-3">
                <div class="col-12 text-center">
                <div class="winner-board">
                <div class="mb-1">
                <span class="text-success">Result: </span>
                              ${newdes[0]}
                            </div> 
                            <div class="mb-1">
                            <span class="text-success">Dragon: </span>
                            ${newdes[1]}
                            </div> <div class="mb-1"><span class="text-success">Tiger: </span>
                            ${newdes[2]}
                            </div></div></div></div></div>`;

        }
        // 32c
        else if ("<?php echo $event_id ?>" == 56967) {
            $("#result-modal-header").text("32 Cards Result");

            let p8 = "";
            let p9 = "";
            let p10 = "";
            let p11 = "";
            if (data[0].win == selection_id) {


                if (pname == "Player 8") {
                    p8 = `<div style="text-align: center;margin-top: -11%;margin-left: 68%;position: absolute;" class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
                if (pname == "Player 9") {
                    p9 = `<div style="text-align: center;margin-top: -11%;margin-left: 68%;position: absolute;" class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
                if (pname == "Player 10") {
                    p10 = `<div style="text-align: center;margin-top: -11%;margin-left: 68%;position: absolute;" class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
                if (pname == "Player 11") {
                    p11 = `<div style="text-align: center;margin-top: -11%;margin-left: 68%;position: absolute;" class="winner-icon mt-3"><i class="fa fa-trophy mr-2"></i></div>`;
                }
            }
            html = `<div>
                    <h6 class="text-right round-id"><b>Round Id:</b> 210911173904
                    </h6>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>Player 8</h4>
                            <div class="result-image">
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[0]}.png" class="mr-2">
                            </div>
                            ${p8}
                            <!---->
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <h4>Player 9</h4>
                            <div class="result-image">
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[1]}.png" class="mr-2">
                            </div>
                            ${p9}
                            <!---->
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <h4>Player 10</h4>
                            <div class="result-image">
                            <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[2]}.png" class="mr-2">
                            </div>
                            ${p10}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <h4>Player 11</h4>
                            <div class="result-image"><img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${cardArr[3]}.png" class="mr-2"></div>
                            ${p11}
                            <!---->
                        </div>
                    </div>
                    </div>`;
        }
        // aaa
        else if ("<?php echo $event_id ?>" == 98791) {
            $("#result-modal-header").text("Amar Akbar Anthony Result");
            html = `<div>
                <h6 class="text-right round-id">
                <b>Round Id:</b> ${round_id}
                </h6> 
                <div class="row">
                <div class="col-12 text-center">
                <div class="result-image">
                <img src="https://dzm0kbaskt4pv.cloudfront.net/v2/static/front/img/cards/${data[0].cards}.png" class="mr-2">
                </div>
                </div>
                </div> 
                <div class="row mt-3">
                <div class="col-12 text-center">
                <div class="winner-board">
                <div class="mb-1">
                <span class="text-success">Result:</span> <span>${data[0].desc}</span></div></div></div></div></div>`;
        }
        $(".card-result-body").html(html);
        $("#card-result").modal('show');
    }



    setTimeout(function() {
        getEventsMarketExpsure(<?php echo $event_id; ?>);

    }, 2000);

    function getEventsMarketExpsure(MatchId) {
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/getEventsMarketExpsure/' + MatchId,

            type: 'get',
            dataType: 'json',
            success: function(output) {

                var markets = output;
                $.each(markets, function(marketKey, marketsRunner) {
                    $.each(marketsRunner, function(runner_key, runner_value) {




                        if (runner_value < 0) {
                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "red");
                        } else {

                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "green");
                        }


                    });
                })


            }
        });
    }

    setInterval(function() {
        // getEventTimer();
    }, 900)






    // var clock = new FlipClock($(".clock"), {
    //         clockFace: "Counter"
    //     });


    function getEventTimer() {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Events/getEventTimer',
            data: {
                event_id: "<?php echo $event_id; ?>"
            },
            dataType: "json",
            type: "POST",
            success: function success(output) {

                clock.setValue(output.timer);

            }
        });
    }
</script>