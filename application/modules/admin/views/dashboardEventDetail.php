<script>
    var socket = io.connect('<?php echo get_ws_endpoint(); ?>', {
        transports: ['websocket'],
        rememberUpgrade: false
    });
    let BLOCKED = false;
</script>

<style>
    #toTop {
        display: none;
        text-decoration: none;
        position: fixed;
        bottom: 20px;
        right: 2%;
        overflow: hidden;
        z-index: 999;
        width: 32px;
        height: 32px;
        border: none;
        text-indent: 100%;
        background: url(<?php echo base_url() . 'assets/images/arr.png'; ?>) no-repeat 0px 0px;
        background-size: 32px;
    }

    html {
        scroll-behavior: smooth;
    }

    iframe {
        width: 1px;
        min-width: 100%;
    }

    .float {
        position: fixed;
        width: 51px;
        height: 42px;
        bottom: 44%;
        right: 6px;
        background-color: #0C9;
        color: #000;
        border-radius: 50px;
        text-align: center;
        text-decoration: none;
        box-shadow: 2px 2px 3px #999;
        z-index: 99999;
        display: grid;
        place-items: center;
        font-size: 19px;
    }

    .my-float {
        margin-top: 22px;
    }
</style>


<main id="main" class="main-content">
    <div class="main-inner">
        <section class="match-content">
            <?php if (isMobile()) { ?>
                <a href="#allbet" class="float">
                    Bets
                </a>

            <?php } ?>
            <div id="UpCommingData" style="display: none;"></div>
            <div id="MatchOddInfo">

                <div class="match-tabs_31057636 matchBoxs_1190470587" style="">
                    <div class="match-box">



                        <div class="match-odds-tittle match-tittle">


                            <?php
                            if (get_user_type() == 'Admin') { ?>
                                <div class="marketTitle">


                                    <?php

                                    // p($is_ball_running);
                                    if ($is_ball_running == 'Yes') { ?>
                                        <button class="btn btn-success btn-sm pull-right" style="float:right;font-weight:bold;" onclick="changeBallRunningStatus()" id="changeStatus" data-event-id="<?php echo $event_id; ?>" data-status="Yes">Un-Block</button>

                                    <?php } else { ?>
                                        <button class="btn btn-success btn-sm pull-right" style="float:right;font-weight:bold;" onclick="changeBallRunningStatus()" id="changeStatus" data-event-id="<?php echo $event_id; ?>" data-status="No">Block</button>

                                    <?php } ?>



                                </div>
                            <?php }
                            ?>


                            <div class="marketTitle">


                                <svg onclick="showTv(31057636,'112.196.188.58',1038);" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 445.44 445.44" style="enable-background:new 0 0 445.44 445.44;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M404.48,108.288H247.808l79.36-78.336l-14.336-14.336L230.4,96.512l-82.432-81.408L133.632,29.44l79.36,78.336H40.96
c-22.528,0-40.96,18.432-40.96,40.96v240.64c0,22.528,18.432,40.96,40.96,40.96h363.52c22.528,0,40.96-18.432,40.96-40.96v-240.64
C445.44,126.72,427.008,108.288,404.48,108.288z M276.48,336.64c0,16.896-13.824,30.72-30.72,30.72H87.04
c-16.896,0-30.72-13.824-30.72-30.72V203.52c0-16.896,13.824-30.72,30.72-30.72h158.72c16.896,0,30.72,13.824,30.72,30.72V336.64z
M353.28,355.072c-19.968,0-35.84-15.872-35.84-35.84c0-19.968,15.872-35.84,35.84-35.84s35.84,15.872,35.84,35.84
C389.12,339.2,373.248,355.072,353.28,355.072z M394.24,251.136h-81.92v-20.48h81.92V251.136z M394.24,199.936h-81.92v-20.48
h81.92V199.936z"></path>
                                        </g>
                                    </g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                </svg>
                                <br />
                                <span style="color:white;font-weight:bold;position: absolute;margin: 32px 0 0 -5px;">Live Tv</span>
                                <span class="match-name-team"><?php echo $event_name; ?>
                                </span>


                                <!--?php// } ?-->


                                <!-- <div class="hidden-lg">                             -->
                                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <time><img src="<?php echo base_url(); ?>assets/app/live-tv.png"></time><span style="color:white;font-weight:bold">Scorecard</span>
                                </a>
                                <!-- <div class="mobile-tv-show">
                                        <span id="close" class="cls-btn " onclick="showAnimated()">x</span>
                                        <div id="Moblivetv" class="MatchLiveTvHideShow">
                                            <iframe class="animated_scoreboard" id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="" style="overflow: scroll; width: 100%; max-width:100% ; max-height: 247px;" height="188"></iframe>
                                        </div>
                                    </div>
                                </div> -->

                            </div>

                            <div class="panel-collapse collapse" id="collapseExample">
                                <!-- <div class="panel-body animated_scoreboard_div" style="padding:0px;position:relative;">
                                    <iframe class="animated_scoreboard" style="height:100%;width:100%" id="mobilePlayer"></iframe>
                                </div> -->
                                <div data-v-581c39a4="" id="scoreboard-box" style="display:none;">
                                    <div data-v-581c39a4="" class="scorecard scorecard-mobile">
                                        <div data-v-581c39a4="" class="score-inner">
                                            <div data-v-581c39a4="" class="container-fluid container-fluid-5">
                                                <p data-v-581c39a4="" class="team-1 row row5"><span data-v-581c39a4="" class="team-name col-6" id="team_1"></span> <span data-v-581c39a4="" class="team-name col-6 text-right" style="float:right;" id="team_2"></span></p>
                                            </div>
                                            <div data-v-581c39a4="" class="container-fluid container-fluid-5">
                                                <p data-v-581c39a4="" class="match-status row row5"><span data-v-581c39a4="" class="col-9">
                                                    </span></p>
                                                <div data-v-581c39a4="" class="match-status row row5" style="width:100%;margin-left:1px;"><span data-v-581c39a4="" class="col-3"><span data-v-581c39a4="" id="current_rr">
                                                        </span>
                                                    </span> <span data-v-581c39a4="" class="col-3">
                                                    </span> <span data-v-581c39a4="" id="last_balls" class="text-right col-6" style="float:right;"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (!empty($live_tv_url)) { ?>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body" style="padding:0px;position:relative;">

                                        <span onclick="goToFull()" style="position:absolute;right:15px;top:15px;"><i class="fa fa-expand" style="color:#000;font-size:21px;" aria-hidden="true"></i></span>
                                        <iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" frameborder="0" scrolling="auto"></iframe>
                                    </div>
                                </div>
                            <?php }

                            ?>

                            <div class="strt-time">
                                <div class="strt-timematch">
                                    <span class="lable-item">Market Start Time</span>
                                    <span class="ng-binding"> <?php

                                                                echo date('d M Y H:i:s', strtotime($events_data['open_date']));
                                                                ?></span>
                                </div>


                                <div class="strt-timeGame">
                                    <span class="lable-item">Game Start Time</span>
                                    <span id="demo_31057636">00</span>

                                    <?php

                                    if ($events_data['is_inplay'] == 'No') { ?>
                                        <span class="going_inplay"> Going In-play </span>
                                    <?php                } else { ?>
                                        <span class="inplay_txt"> In-play </span>
                                    <?php }

                                    ?>

                                </div>


                            </div>


                        </div>
                        <div class="score_area"><span style="" class="matchScore" id="matchScore_31057636">
                                <div class="score_main">
                                    <?php if ($event_type == 4) { ?>
                                        <!-- <div class="cricket-score">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-4 col">
                                                    <div class="teamtype"> <img id="team_1_status" class="" src="<?php echo base_url(); ?>assets/images/cricket-bat.svg">
                                                        <p class="matchName" id="team_1_name"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-4 col">
                                                    <div class="target-score"> <span class="currunt_sc">0-0</span> <span class="currunt_over">(0.)</span> <span class="score-btn" onclick="showScoreBoard(31057636)">Scoreboard</span></div>
                                                </div>
                                                <div class="col-md-4 col-xs-4 col">
                                                    <div class="teamtype"> <img id="team_2_status" class="active" src="<?php echo base_url(); ?>assets/images/cricket-bat.svg">
                                                        <p class="matchName" id="team_2_name"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="score-footer">
                                                <div class="item-score batsman">
                                                    <ul>
                                                        <li class="active"> <img src="<?php echo base_url(); ?>assets/images/cricket-icons.svg"> <span id="score_player_1"></span></li>
                                                        <li class=""><img src="<?php echo base_url(); ?>assets/images/cricket-icons.svg"> <span id="score_player_2"></span></li>

                                                        <li class=""><img src="<?php echo base_url(); ?>assets/images/cricket-ball.svg"> <span id="score_player_3"></span></li>
                                                    </ul>
                                                </div>
                                                <div class="item-score score-over-fter">
                                                    <div class="over-status">
                                                        <div class="score-over">
                                                            <ul id="score-over">
                                                                <li>
                                                                    <p>Over </p>
                                                                </li>
                                                                <li class="-color six-balls"><span></span></li>
                                                                <li class="-color six-balls"><span></span></li>
                                                                <li class="-color six-balls"><span></span></li>
                                                                <li class="-color six-balls"><span></span></li>
                                                                <li class="-color six-balls"><span></span></li>
                                                                <li class="-color six-balls"><span></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="commantry-status"><span class="commantry"></span></div>
                                                </div>
                                            </div>
                                        </div> -->
                                </div>
                            <?php } ?>
                            </span>
                        </div>



                        <?php echo $marketExchangeHtml; ?>

                    </div>
                </div>


                <?php
                if (get_user_type() != 'Super Admin') {
                    if ($fancy_user_info->is_fancy_active == 'Yes') {
                        echo $fancyExchangeHtml;
                    }
                } else {
                    echo $fancyExchangeHtml;
                } ?>











                <div id="tv-box-popup">

                </div>

                <script>
                    dragElement(document.getElementById("tv-box-popup"));
                    matchInterval('31057636', '07:30:11 PM', "Nov 10,2021");
                </script>

            </div>
            <?php if (isMobile()) { ?>
                <div class="mod-header tab_bets betsheading" style="">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item betdata active all-bet-tab-menu">
                            <a class="allbet" id="allbet" href="javascript:void(0);" onclick="getDataByType('all','all-bet-tab-menu');"><span class="bet-label">All Bet</span>
                                <span class="bat_counter" id="cnt_row">(0)</span></a>
                        </li>
                        <!-- <li class="nav-item betdata">
                            <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType(this,'2');"><span class="bet-label">UnMatch Bet</span>
                                <span class="bat_counter" id="cnt_row1">(0)</span> </a>
                        </li> -->
                        <li class="nav-item betdata fancy-bet-tab-menu">
                            <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('fancy','fancy-bet-tab-menu');"><span class="bet-label">Fancy Bet</span>
                                <span class="bat_counter" id="cnt_row3">(0)</span> </a>
                        </li>

                        <li class="nav-item betdata unmatch-bet-tab-menu">
                            <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('unmatch','unmatch-bet-tab-menu');"><span class="bet-label">Unmatch Bet</span>
                                <span class="bat_counter" id="cnt_row4">(0)</span> </a>
                        </li>

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
                                            <?php
                                            if (get_user_type() == 'User') { ?>
                                                <td>Delete</td>

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
                                            <td>Unmatch</td>



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

                                    $("#MatchUnMatchBetaData").show();
                                    $("#MatchUnMatchBetaData").html(output);

                                }
                            });
                        }
                    </script>
                </div>


                <a href="#" id="toTop" style="display: inline;"><span id="toTopHover"></span><span id="toTopHover"></span></a>

            <?php } ?>
        </section>
        <div id="betSidenav" class="betsidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="betcloseNav()">×</a>
            <section class="right-bet-content">
                <div id="livetv">
                    <!-- <div class="mod-header">
                        <div class="select-tv-ico">
                            <time><img onclick="showAnimated();" src="<?php echo base_url(); ?>assets/app/live-tv.png"></time> <span>Live Tv</span>
                        </div>
                        <span id="close" class="cls-btn">x</span>
                    </div> -->
                    <!-- <div class="MatchLiveTvHideShow animated_scoreboard"><iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling=""></iframe></div> -->
                </div>
                <div id="tv-box-popup"></div>

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
                                        <!-- <button class="btn btn-success CommanBtn placefancy" type="button" onclick="PlaceBet();" style="display:none"> Place Bet</button> -->
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>




                <div class="side-bar-thumb" style="display: none;">
                    <div class="slider vertical-slider">
                        <div class="slick slick-initialized slick-slider slick-vertical"><button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Previous" role="button" style="display: inline-block;">Previous</button>

                            <div aria-live="polite" class="slick-list draggable" style="height: 0px;">
                                <div class="slick-track" role="listbox" style="opacity: 1; height: 0px; transform: translate3d(0px, 0px, 0px);">
                                    <div class="item slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/horse-racing-Recovered-copy.gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/soccer (1).gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/Cricket0001.gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/tennis (1).gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="0" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide00" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/CASINO.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide01" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/eZUGI.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="2" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide02" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/horse-racing.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="3" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide03" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/super-spade.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="4" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide04" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/soccer.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="5" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide05" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/tennis.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="6" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide06" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/ONE-TOUCH.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="7" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide07" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/PRAGMATIC-PLAY-LIVE.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="8" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide08" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/ASIA-GAMING.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="9" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide09" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/soccer003.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="10" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide010" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/Cricket0003.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="11" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide011" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/horse-racing02.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="12" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide012" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/tennis003.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="13" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide013" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/soccer002.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="14" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide014" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/tennis002.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="15" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide015" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/Cricket0002.gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="16" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide016" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/CASINO (1).gif">
                                    </div>
                                    <div class="item slick-slide" data-slick-index="17" aria-hidden="true" tabindex="-1" role="option" aria-describedby="slick-slide017" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/horse-racing-Recovered-copy.gif">
                                    </div>
                                    <div class="item slick-slide slick-current slick-active" data-slick-index="18" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide018" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/soccer (1).gif">
                                    </div>
                                    <div class="item slick-slide slick-active" data-slick-index="19" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide019" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/Cricket0001.gif">
                                    </div>
                                    <div class="item slick-slide slick-active" data-slick-index="20" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide020" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/tennis (1).gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned slick-active" data-slick-index="21" aria-hidden="false" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/CASINO.gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="22" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/eZUGI.gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="23" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/horse-racing.gif">
                                    </div>
                                    <div class="item slick-slide slick-cloned" data-slick-index="24" aria-hidden="true" tabindex="-1" style="width: 0px;">

                                        <img src="<?php echo base_url(); ?>assets/app/super-spade.gif">
                                    </div>
                                </div>
                            </div>
                            <button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button" style="display: inline-block;">Next</button>
                        </div>
                    </div>
                </div>
                <div class="overlay_mobile in"></div>
                <?php if (!isMobile()) { ?>
                    <div class="mod-header tab_bets betsheading" style="">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item betdata active all-bet-tab-menu">
                                <a class="allbet" href="javascript:void(0);" onclick="getDataByType('all','all-bet-tab-menu');"><span class="bet-label">All Bet</span>
                                    <span class="bat_counter" id="cnt_row">(0)</span></a>
                            </li>
                            <!-- <li class="nav-item betdata">
                            <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType(this,'2');"><span class="bet-label">UnMatch Bet</span>
                                <span class="bat_counter" id="cnt_row1">(0)</span> </a>
                        </li> -->
                            <li class="nav-item betdata fancy-bet-tab-menu">
                                <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('fancy','fancy-bet-tab-menu');"><span class="bet-label">Fancy Bet</span>
                                    <span class="bat_counter" id="cnt_row3">(0)</span> </a>
                            </li>
                            <li class="nav-item betdata unmatch-bet-tab-menu">
                                <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType('unmatch','unmatch-bet-tab-menu');"><span class="bet-label">Unmatch Bet</span>
                                    <span class="bat_counter" id="cnt_row4">(0)</span> </a>
                            </li>
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
                                                <?php
                                                if (get_user_type() == 'User') { ?>
                                                    <td>Delete</td>

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
                                                <td>Unmatch</td>


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

                                        $("#MatchUnMatchBetaData").show();
                                        $("#MatchUnMatchBetaData").html(output);

                                    }
                                });
                            }
                        </script>
                    </div>
                <?php } ?>
            </section>
        </div>

    </div>
</main>
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
        // return false;



        // isMarketSelected = true;
        // $('#betting_type').val('Match');
        // $('#event_type').val(eventType);

        // $("#UpCommingData").hide();
        // $("#UpCommingData").html('');
        // var formData = {
        //     MarketId: MarketId,
        //     matchId: matchId
        // };


        // // $.blockUI();
        // $.ajax({
        //     url: "<?php echo base_url(); ?>admin/Events/backlays",
        //     data: formData,
        //     type: 'POST',
        //     dataType: 'json',
        //     async: false,
        //     success: function success(output) {
        //         if (output != '') {
        //             //  active_event_id = MarketId;
        //             $('#MarketId').val(MarketId);
        //             $('#matchId').val(matchId);

        //             $(".matchBox").show();
        //             $("#UpCommingData").hide();
        //             $("#MatchOddInfo").show();
        //             $('#bettingView').show();
        //             $(".betSlipBox").show();
        //             $(".other-items").hide();
        //             // $("#MatchOddInfo").html(output.exchangeHtml);
        //             $('.fancybox').show();
        //             // $('.fancybox').html(output.fancyHtml);

        //             generateMarketStructure(output)

        //         } else {
        //             closeBetBox(matchId, MarketId);
        //         }
        //         // $.unblockUI();

        //     }
        // });
        // fetchBttingList();

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

                fancyHtml += '<div class="block_box f_m_' + fancy.match_id + ' fancy_' + fancy.selection_id + ' f_m_31236 fancy-rows" data-id="' + fancy.selection_id + '">';

                fancyHtml += '<ul class="sport-high fancyListDiv">';
                fancyHtml += '<li>';
                fancyHtml += '<div class="ses-fan-box">';
                fancyHtml += '<table class="table table-striped  bulk_actions">';
                fancyHtml += '<tbody>';
                fancyHtml += '<tr class="session_content">';
                fancyHtml += '<td><span class="fancyhead' + fancy.selection_id + '" id="fancy_name' + fancy.selection_id + '">' + fancy.runner_name + '</span><b class="fancyLia' + fancy.selection_id + '"></b><p class="position_btn"></td>';


                fancyHtml += '<td></td>';
                fancyHtml += '<td></td>';

                fancyHtml += '<td class="fancy_lay" id="fancy_lay_' + fancy.selection_id + '" onclick="betfancy(`' + fancy.match_id + '`,`' + fancy.selection_id + '`,`' + 0 + '`);">';

                fancyHtml += '<button class="lay-cell cell-btn fancy_lay_price_' + fancy.selection_id + '" id="LayNO_' + fancy.selection_id + '">' + parseFloat(fancy.lay_price1) + '</button>';

                fancyHtml += '<button id="NoValume_' + fancy.selection_id + '" class="disab-btn fancy_lay_size_' + fancy.selection_id + '">' + fancy.lay_size1 + '</button></td>';

                fancyHtml += '<td class="fancy_back" onclick="betfancy(`' + fancy.match_id + '`,`' + fancy.selection_id + '`,`' + 1 + '`);">';

                fancyHtml += '<button class="back-cell cell-btn fancy_back_price_' + fancy.selection_id + '" id="BackYes_' + fancy.selection_id + '" >' + parseFloat(fancy.back_price1) + '</button>';

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
        setTimeout(function() {
            fetchBttingList()

        }, 1000);

        // fetchBttingList();



        // fetchMatchOddsPositionList();

    })

    // function fetchProfitLossList() {

    //     var formData = {
    //         matchId: "<?php echo $event_id; ?>"
    //     }
    //     $.ajax({
    //         url: "<?php echo base_url(); ?>admin/Events/userWiseLossProfit",
    //         data: formData,
    //         type: 'POST',
    //         dataType: 'json',
    //         async: false,
    //         success: function(output) {
    //             $('#all-profit-loss-data').html(output.htmlData);
    //         }
    //     });
    // }


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

                var unmatchLength = $('.unmatch-bet-slip').length;



                $('#cnt_row3').text('(' + fancyLength + ')');

                $('#cnt_row4').text('(' + unmatchLength + ')');

                $("#pills-tab").find(".active").find("a").click();

            }
        });
    }


    function getOddValue(matchId, marketId, back_layStatus, placeName, elementId, selectionId, MarketTypes = '', target) {
        $("#ShowBetPrice.odds-input").attr("style", "color:#000 !important")
        var priceVal = $('#' + elementId).text();
        if (priceVal <= 0) {
            ClearAllSelection();
            return false;
        }
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
        if ($(window).width() < 780) {
            $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
            $(".betSlipBox .mod-header").show();
            $(".betBox").insertAfter('.matchOpenBox_' + MId + '_' + selectionId);
            // if (gameType != 'market') {
            //    $("#betslip").insertAfter('.teenpatti-row');
            // } else {
            $(".betBox").insertAfter('.matchOpenBox_' + MId + '_' + selectionId);
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
                delay: 1000
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
                    url: '<?php echo base_url(); ?>admin/Events/savebet',
                    data: formData,
                    dataType: 'json',
                    async: false,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    beforeSend: function() {

                        // $(".loader").show();
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

                            if (data.message == 'Unmatch Bet Placed Successfully') {
                                new PNotify({
                                    title: 'Success',
                                    text: data.message,
                                    type: 'notice',
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




                            setIntervalX(function() {
                                fetchBttingList();
                                getFancysExposure();
                                getEventsMarketExpsure(<?php echo $event_id; ?>);
                            }, 5000, 2);


                            // setTimeout(function() {

                            //     getFancysExposure();
                            // }, 2000);
                            // fetchBttingList();

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
                delay: 1000
            });
        } else if (!$.isNumeric(NoValume) || NoValume < 1 || !$.isNumeric(YesValume) || YesValume < 1) {
            new PNotify({
                title: 'Error',
                text: 'Invalid session Volume',
                type: 'error',
                styling: 'bootstrap3',
                delay: 1000
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
                                delay: 1000
                            });
                        } else {
                            new PNotify({
                                title: 'Error',
                                text: data.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 1000
                            });
                        }
                    }
                });
            }, 0);
        }
    }


    // function showEditStakeModel() {
    //     $('#addUser').modal('show');
    // }

    // function submit_update_chip() {

    //     var datastring = $("#stockez_add").serializeJSON();

    //     $.ajax({
    //         type: "post",
    //         url: '<?php echo base_url(); ?>admin/Chip/update_user_chip',
    //         data: datastring,
    //         cache: false,
    //         dataType: "json",
    //         success: function success(output) {

    //             if (output.success) {
    //                 $("#divLoading").show();
    //                 $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
    //                 $("#divLoading").fadeOut(3000);
    //                 new PNotify({
    //                     title: 'Success',
    //                     text: output.message,
    //                     type: 'success',
    //                     styling: 'bootstrap3',
    //                     delay: 1000
    //                 });
    //                 location.reload();
    //             } else {
    //                 $("#divLoading").show();
    //                 $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
    //                 $("#divLoading").fadeOut(3000);
    //                 new PNotify({
    //                     title: 'Error',
    //                     text: output.message,
    //                     type: 'error',
    //                     styling: 'bootstrap3',
    //                     delay: 1000
    //                 });
    //             }
    //         }
    //     });
    // }

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
        let userName = "<?php echo get_user_name(); ?>";
        let room = "<?php echo $event_id; ?>";
        let ID = "";
        //send event that user has joined room
        socket.emit("join_room", {
            username: userName,
            roomName: room
        });




        socket.on("connect", () => {
            console.log('socket connecteds ::::::::::::::::::::::' + new Date(), socket);
            console.log(socket.connected); // true

            socket.emit("join_room", {
                username: userName,
                roomName: room
            });
        });



        socket.on("disconnect", (reason) => {
            console.log('SOCKET DISCONNECTING REASON ::::::::::::::::::::::' + new Date(), reason);
            if (reason === "io server disconnect") {
                // the disconnection was initiated by the server, you need to reconnect manually
                socket.connect();


            } else {

                console.log('SOCKET CONNECTING REQUEST SEND ::::::::::::::::::::::' + new Date());


                // socket.connect();


            }
            // else the socket will automatically try to reconnect
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
            // console.log(matchId);
            // if (MarketId) {
            // var market = data.marketodds[matchId]

            if (data.marketodds.length > 0) {

                var market = data.marketodds.find(o => o.event_id == matchId);


                // console.log('SOCKET UPDATE', new Date());
                if (market) {
                    market.is_ball_running = BLOCKED ? 'Yes' : market.is_ball_running;
                    // console.log('market',market);
                    if (market.market_types.length > 0) {
                        $.each(market.market_types, function(index, market_type) {
                            $.each(market_type.runners, function(index, runner) {

                                if (market_type.market_name == 'Toss') {
                                    if (runner.back_1_price == 1.95) {
                                        runner.back_1_price = 1.97;
                                    }
                                }


                                if (runner.status == "CLOSE") {
                                    $('#availableToLay1_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent().append("<h6>CLOSED</h6>");

                                    $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                } else {
                                    if (runner.status == 'OPEN' || runner.status == 'ACTIVE') {
                                        $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();
                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeOut();

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().removeClass('overlay');
                                    } else {

                                        $(`#availableToLay1_price_${runner.market_id.replace('.', '')}_${runner.selection_id}`).parent().find('h6').remove();
                                        // $('.overlay_matchBoxs_' + market_type.market_id.replace('.', '')).fadeIn();

                                        $('#availableToBack3_size_' + market_type.market_id.replace('.', '') + '_' + runner.selection_id).parent().parent().addClass('overlay');

                                        $('.status_matchBoxs_' + market_type.market_id.replace('.', '')).text(market_type.status);
                                    }

                                    //  if (j == 0) {

                                    ///*************Available To Bck */
                                    // $('#availableToBack3_price_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).parent()[0].closest( "h6" ).remove();


                                    if (runner.status == 'SUSPENDED' || market.is_ball_running == 'Yes') {


                                        if (market.is_ball_running == 'Yes') {
                                            ClearAllSelection(1);

                                        }

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

                                if (parseFloat($('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(kFormatter(runner.back_1_size))) {
                                    $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(kFormatter(runner.back_1_size)).parent().parent().addClass('yellow');

                                } else {
                                    $('#availableToBack1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(kFormatter(runner.back_1_size)).parent().parent().removeClass('yellow');
                                }


                                if (parseFloat($('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text()) !== parseFloat(kFormatter(runner.lay_1_size))) {
                                    $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(kFormatter(runner.lay_1_size)).parent().parent().addClass('yellow');

                                } else {
                                    $('#availableToLay1_size_' + runner.market_id.replace('.', '') + '_' + runner.selection_id).text(kFormatter(runner.lay_1_size)).parent().parent().removeClass('yellow');
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
                            filterRemoveFancy(fancys);
                            for (var j = 0; j < fancys.length; j++) {
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

                                                    fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' f_m_31236 fullrow margin_bottom fancybox fancy-rows" data-id="' + fancys[j].selection_id + '">';

                                                    fancyHtml += '<div class=" list-item fancy_220239 f_m_31057636 f_m_undefined" data-id="220239">';
                                                    fancyHtml += '<div class="event-sports event-sports-name"><input type="hidden" value="LM" class="fancyType220239"><input type="hidden" value="1.190470637" class="fancyMID220239">';
                                                    fancyHtml += '<span  onclick="getPosition(' + fancys[j].selection_id + ')"  class="event-name fancyhead' + fancys[j].selection_id + '" id="fancy_name' + fancys[j].selection_id + '">' + fancys[j].runner_name + '</span>';

                                                    fancyHtml += '<div class="match_odds-top-left min-max-mobile dropdown">';

                                                    fancyHtml += '<span class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo base_url(); ?>assets/images/matchodds-info-icon.png" class="fancy-info-btn"></span>';
                                                    fancyHtml += '<ul class="dropdown-menu">';
                                                    fancyHtml += '<li> Min:undefined </li>';
                                                    fancyHtml += '<li>Max:undefined</li>';
                                                    fancyHtml += '</ul>';
                                                    fancyHtml += '</div>';



                                                    fancyHtml += '<span class="fancy-exp dot fancy_exposure_' + fancys[j].selection_id + ' ">0</span>';
                                                    fancyHtml += '<button class="btn btn-xs btn-info" onclick="getPosition(' + fancys[j].selection_id + ')">Bets</button><span class="fancy_exposure" id="fancy_lib220239"></span>';
                                                    fancyHtml += '</div>';
                                                    fancyHtml += '<div class="fancy_div">';
                                                    fancyHtml += '<div class="fancy_buttone">';
                                                    fancyHtml += '<div class="fancy-lays bet-button lay mark-lay" id="fancy_lay_' + fancys[j].selection_id + '" onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 0 + '`);">';
                                                    fancyHtml += '<strong id="LayNO_' + fancys[j].selection_id + '" class=" fancy_lay_price_' + fancys[j].selection_id + '" >' + parseFloat(fancys[j].lay_price1) + '</strong>';
                                                    fancyHtml += '<div class="size">';
                                                    fancyHtml += '<span id="NoValume_' + fancys[j].selection_id + '" class="disab-btn fancy_lay_size_' + fancys[j].selection_id + '">' + fancys[j].lay_size1 + '</span>';
                                                    fancyHtml += '</div>';
                                                    fancyHtml += '</div>';
                                                    fancyHtml += '<div class="fancy-backs bet-button back mark-back"   onclick="betfancy(`' + fancys[j].match_id + '`,`' + fancys[j].selection_id + '`,`' + 1 + '`);">';
                                                    fancyHtml += '<strong id="BackYes_' + fancys[j].selection_id + '" class=" fancy_back_price_' + fancys[j].selection_id + '">' + parseFloat(fancys[j].back_price1) + '</strong>';
                                                    fancyHtml += '<div class="size">';
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
                                            fancyHtml += '<div class="block_box f_m_' + fancys[j].match_id + ' fancy_' + fancys[j].selection_id + ' fancy-rows" data-id="' + fancys[j].selection_id + '">';

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
        });



        socket.on('betting_placed', function(data) {

            let usersArr = data.betting_details.users;
            let user_id = <?php echo get_user_id(); ?>;

            if (usersArr.length > 0) {
                if (usersArr.includes(user_id.toString())) {


                    setIntervalX(function() {
                        fetchBttingList();
                        getFancysExposure();
                        getEventsMarketExpsure(<?php echo $event_id; ?>);
                    }, 2000, 2);




                    // setTimeout(function() {
                    //     fetchBttingList();
                    //     getFancysExposure();
                    //     getEventsMarketExpsure(<?php echo $event_id; ?>);
                    // }, 2500);



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

            var bet_len = $('#user_row_' + data.betting_detail.betting_id);

            if (bet_len.length) {

                fetchBttingList();
                getFancysExposure();
                getEventsMarketExpsure(<?php echo $event_id; ?>);
                // fetchMatchOddsPositionList();
            }



            // fetchBttingList();
            // getFancysExposure();
            // fetchMatchOddsPositionList();
        });
    });

    function getValColor(val) {
        if (val == '' || val == null || val == 0) return '#000000';
        else if (val > 0) return '#007c0e';
        else return '#ff0000';
    }


    // function getPosition(fancyid) {
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>admin/Events/getPosition',
    //         data: {
    //             // userId1: userId1,
    //             fancyid: fancyid,
    //             typeid: 2,
    //             event_id: <?php echo $event_id; ?>,
    //             yesval: $("#BackYes_" + fancyid).text(),
    //             noval: $("#LayNO_" + fancyid).text(),
    //             // usertype: userType1,
    //             // 'compute': Cookies.get('_compute')
    //         },
    //         type: "POST",
    //         success: function success(output) {
    //             $("#fancy_book_body_" + fancyid).html(output);
    //         }
    //     });
    // }

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


    // function add_new_chip() {
    //     var html = '';
    //     html += '<div class="fullrow">'
    //     html += '<input type="hidden" name="user_chip_id[]" class="form-control" required />';
    //     html += '<div class="col-md-6 col-sm-6col-xs-6">';
    //     html += '<div class="form-group"><label for="email">Chips Name :</label><input type="text" name="chip_name[]" class="form-control" required value=""></div>';
    //     html += '</div>';
    //     html += '<div class=" col-md-6 col-sm-6col-xs-6">';
    //     html += '<div class="form-group"><label for="pwd">Chip Value :</label><input type="number" name="chip_value[]" class="form-control" required value=""></div>';
    //     html += '</div>';
    //     html += '</div>';

    //     $('#chip-moddal-body').append(html);
    // }


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

            var event_type = '<?php echo $event_type ?>';
            if (event_type == "4") {
                if (data.score.event_id == '<?php echo $event_id; ?>') {

                    if (data.score.message != "Not Found!") {


                        $('#scoreboard-box').show();


                    }


                    $('#team_1').html(data.score.data.spnnation1 + ' ' + data.score.data.score1);
                    $('#team_2').html(data.score.data.spnnation2 + ' ' + data.score.data.score2);



                    if (data.score.data.activenation1 == 1) {
                        $('#current_rr').html('CRR ' + data.score.data.spnrunrate1);

                    } else if (data.score.data.activenation2 == 1) {
                        $('#current_rr').html('CRR ' + data.score.data.spnrunrate2);

                    }




                    var pb = data.score.data.balls;


                    var balls_html = '';
                    if (pb.length > 0) {
                        for (let i = pb.length - 6; i < pb.length; i++) {


                            // text += cars[i] + "<br>";
                            if (i > 0) {
                                balls_html += '<span class="ball-runs mr-1 four">' + pb[i] + '</span>';

                            }
                        }
                        // text += cars[i] + "<br>";
                    }
                    $('#last_balls').html(balls_html);

                    return false;
                }
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




    setInterval(function() {
        getFancysExposure();

    }, 15000);


    function getFancysExposure() {

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

            // var tvHtml = '<iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" style="border-radius: 1px;width:100%;height:100%;overflow:hidden !important;position:relative; display: block; width: 100vh; height: 100vw; border: none;transform: translateY(100vh) rotate(-90deg); transform-origin: top left;"  frameBorder="0" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen  msallowfullscreen></iframe>';

        } else {

            // alert("Here");



            var tvHtml = '<iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" style="border-radius: 1px;width:100%;height:100%;overflow:hidden !important;position:relative; display: block; "  frameBorder="0" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen  msallowfullscreen></iframe>';

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


                        marketKey = marketKey.replace('.', '');

                        if (runner_value < 0) {


                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "red");

                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).attr('data-val', runner_value);

                            $('.loss_profit_' + marketKey + '_' + runner_key).val(runner_value);

                        } else {

                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).text(Math.abs(runner_value)).css("color", "green");

                            $('#' + runner_key + '_maxprofit_loss_runner_' + marketKey).attr('data-val', runner_value);



                            $('.loss_profit_' + marketKey + '_' + runner_key).val(runner_value);
                        }


                    });
                })


            }
        });
    }


    function openFullscreen() {
        var iframe = document.getElementById("tvPlayer");
        var elem = iframe.contentWindow.document.getElementsByTagName("video")[0];

        // document.getElementById("h5live-playerDiv");

        return false;

        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE11 */
            elem.msRequestFullscreen();
        }
    }

    function goToFull() {
        if ($(window).width() < 780) {

            var tvHtml = '<iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" style="border-radius: 1px;width:100%;height:100%;overflow:hidden !important;position:relative; display: block; width: 100vh; height: 100vw; border: none;transform: translateY(100vh) rotate(-90deg); transform-origin: top left;"  frameBorder="0" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen  msallowfullscreen></iframe>';
            var myWindow = window.open("", "<?php echo $event_name; ?>", "width=100%,height=calc(100vh)");


            myWindow.document.write(tvHtml);
        } else {

            // alert("Here");



            var tvHtml = '<iframe id="tvPlayer" src="<?php echo $live_tv_url; ?>" style="border-radius: 1px;width:100%;height:100%;overflow:hidden !important;position:relative; display: block; "  frameBorder="0" allowtransparency="true" frameborder="0" scrolling="no" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen  msallowfullscreen></iframe>';

            var myWindow = window.open("", "<?php echo $event_name; ?>", "width=100%,height=calc(100vh)");


            myWindow.document.write(tvHtml);
        }
    }

    function changeBallRunningStatus() {
        var event_id = $('#changeStatus').attr('data-event-id');
        var status = $('#changeStatus').attr('data-status');
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
                if (output.success) {
                    if (status == 'Yes') {
                        $('#changeStatus').attr('data-status', 'No')
                        $('#changeStatus').html('Block');
                    } else {
                        $('#changeStatus').attr('data-status', 'Yes')
                        $('#changeStatus').html('Un-Block');


                    }
                } else {
                    new PNotify({
                        title: 'Error',
                        text: output.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 1000
                    });
                }
            }
        })

    }

    function deleteBet(betting_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/events/deleteBet',
            data: {
                betting_id: betting_id,
            },
            type: 'post',
            dataType: 'json',
            success: function(data) {
                fetchBttingList();
                getFancysExposure();
                getEventsMarketExpsure(<?php echo $event_id; ?>);
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

                fetchBttingList();

            }
        })
    }

    setInterval(function() {
        fetchBttingList();
        getEventsMarketExpsure(<?php echo $event_id; ?>);
    }, 30000);


    function checkUnmatchBetStatusChange() {

        $(".unmatch-bet-slip").each(function(i) {
            var selection_id = $(this).attr('data-selection-id');
            var bet_id = $(this).attr('id');

            var market_id = $(this).attr('data-market-id');
            var match_id = $(this).attr('data-match-id');
            var is_back = $(this).attr('data-is-back');
            var bet_price_val = $(this).attr('data-price-val');
            var market_name = $(this).attr('data-market-name');



            if (is_back == 1) {



                var p_v = $('#availableToBack1_price_' + market_id.replace('.', '') + '_' + selection_id).text();

                if (market_name == 'Bookmaker') {
                    p_v = (p_v / 100) + 1;

                }
                if (parseFloat(bet_price_val) <= parseFloat(p_v)) {
                    console.log("BET MATCHED", bet_id)
                    console.log(p_v + "  --bbb-- " + bet_price_val)


                    fetchBttingList();
                    getEventsMarketExpsure(<?php echo $event_id; ?>);
                }
            } else {


                var p_v = $('#availableToLay1_price_' + market_id.replace('.', '') + '_' + selection_id).text();
                if (market_name == 'Bookmaker') {
                    p_v = (p_v / 100) + 1

                }

                if (parseFloat(bet_price_val) >= parseFloat(p_v)) {
                    console.log("BET MATCHED", bet_id)
                    console.log(p_v + "  --bbb-- " + bet_price_val)

                    fetchBttingList();
                    getEventsMarketExpsure(<?php echo $event_id; ?>);
                }



            }



        });

    }
    setInterval(function() {
        checkUnmatchBetStatusChange();
    }, 2000)

    function filterRemoveFancy(fancys) {
        $(".fancy-rows").each(function(i) {
            var selection_id = $(this).attr('data-id');

            var check_fancy_exists = fancys.filter((x) => {
                return x.selection_id == selection_id;
            })


            if (!check_fancy_exists.length) {
                // console.log('fancys', check_fancy_exists);

                $('.fancy_' + selection_id).remove();
                // console.log('selection_id', selection_id);
            }



        })
    }


    function kFormatter(num) {
        return num;
        // return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(num) * Math.abs(num)
    }

    $('.close-score').click(function() {
        $('.mobile-tv-show').hide();
    })

    function get_live_animation_scoreboard() {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/events/get_live_animation_scoreboard',
            data: {
                event_id: <?php echo $event_id ?>,
            },
            type: 'post',
            // dataType: 'json',
            success: function(animated_scoreboard_link) {
                console.log("hii");
                console.log(animated_scoreboard_link);
                $('.animated_scoreboard').attr('src', animated_scoreboard_link);
            }
        })
    }


    $(document).ready(function() {

        // get_live_animation_scoreboard();

    });
    window.addEventListener("message", (event) => {
        if (event.origin == "https://central.satsport247.com'")
            console.log("dont remove", "socre width")
        setScoreIframeHeight(event.data.scoreWidgetHeight)
    }, false);

    function setScoreIframeHeight(height) {
        // console.log('hii', height);
        // document.getElementsByClassName("animated_scoreboard").style.height = height;
        $('.animated_scoreboard').css('height', height + 2);
        $('.animated_scoreboard_div').css('height', height);

    }
</script>