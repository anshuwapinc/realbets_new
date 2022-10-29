 

<div class="right_col" role="main">
   <div class="fullrow tile_count">
      <div class="col-md-7">
         <div id="UpCommingData" style="display:block;">
            <div class="sport-highlight-content tabs" id="accountView" role="main">
 
               <div class="casinobg"><span><a href="<?php echo base_url(); ?>admin/livegames" class="blinking"> Live games</a></span></div>
              


               <div class="modal-body tab-content matches-all" style="display:block;">
                  <span id="msg_error"></span><span id="errmsg"></span>
                  <div class="table table-striped jambo_table bulk_action" id="">
                     <div class="clearfix"></div>
                     <div id="cricket" class="tab-pane fade in active">
                        <div id="user_row_" class="lotus-title sportrow-4">
                           <div class="head-matchname">
                              <div class="match-head">Cricket</div>
                              <div class="match-odds-right">
                                 <div class="items-up-odds">1</div>
                                 <div class="items-up-odds">x</div>
                                 <div class="items-up-odds">2</div>
                              </div>
                           </div>
                        </div>
                        <?php

                        if (isset($crickets) && !empty($crickets)) {

                           foreach ($crickets as $cricket) {
                              $tomorrow = date("Y-m-d", time() + 86400);

                              if (date('Y-m-d', $cricket['time']) <= $tomorrow) {
                                 // continue;
                              } else {
                                 continue;
                              }
                        ?>
                              <div id="user_row_" class="sport_row sportrow-4  matchrow-4261" onclick="MarketSelection(<?php echo $cricket['event_id']; ?>,<?php echo $cricket['event_type']; ?>);" title="Match OODS">
                                 <div class="sport_name">
                                    <time><?php echo date('d M Y H:i:s', $cricket['time']); ?></time>
                                    <span id='fav4261'><i class='fa fa-star-o' aria-hidden='true'></i></span>
                                    <a href="javascript:;">
                                       <?php echo $cricket['home']; ?> v <?php echo $cricket['away']; ?> </a>
                                 </div>
                                 <div class="match_status">

                                    <?php
                                    if ($cricket['time_status']) { ?>
                                       <span class="inplay_txt">In-play </span>
                                    <?php     } else { ?>
                                       <span class="going_inplay">Going In-play</span>
                                    <?php }
                                    ?>
                                 </div>

                                 <div class="match_odds_front">


                                    <span class="back-cell"><?php echo $cricket['home_back_1']; ?></span>
                                    <span class="lay-cell"><?php echo $cricket['home_lay_1']; ?></span>


                                    <span class="back-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span class="lay-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                                    <span class="back-cell"><?php echo $cricket['away_back_1']; ?></span>
                                    <span class="lay-cell"><?php echo $cricket['away_lay_1']; ?></span>
                                 </div>
                              </div>
                        <?php }
                        }


                        ?>


                     </div>
                  </div>
               </div>



            </div>

            <script>
               $(document).ready(function() {
                  $(".match-buttons").click(function() {
                     $(this).addClass("actives");
                     $(".btn-back").addClass("aj-back");
                  });
                  $(".tbback").click(function() {
                     $('#cricket, #tennis, #soccer').removeClass("actives");
                     $(".match-buttons").removeClass("actives");
                     $(".btn-back").removeClass("aj-back");
                  });
                  $(".nav-tabs li").click(function() {
                     var dt = $(this).data('tabname');
                     $('#cricket, #tennis, #soccer').removeClass("actives");
                     $('#' + dt).addClass('actives')
                  });
               });
            </script>
         </div>
         <div id="MatchOddInfo" style="display:none;">

            <!------------------Exchange Response Show here----------------->


         </div>

         <!-----------------Fancy API Response show here------------------->
         <div class="fullrow margin_bottom fancybox" id="fancyM_4310" style="display:none;">
            <div style="" class="fancy-table" id="fbox4310">
               <div class="fancy-heads">
                  <div class="event-sports">Fancy&nbsp;&nbsp; </div>
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
            </div>
         </div>
         <!-----------------Fancy API Response show here------------------->
      </div>
      <div class="col-md-5 col-xs-12 matchBox">
         <div class="other-items">
            <div class="balance-box">
               <div class="panel-heading">
                  <h3 class="bal-tittle">Mini Games </h3>
                  <span class="pull-right clickable"><i class="fa fa-chevron-down"></i></span>
               </div>
               <div class="balance-panel-body">
                  <div class="game_wrapper">
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/live-teenpatti.jpg?v=1.5646">
                        <p>Live Teen Patti</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/livebaccarat.jpg">
                        <p>Live Baccarat</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/dragon-tiger.jpg">
                        <p>Dragon Tiger</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                  </div>
                  <div class="game_wrapper">
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/poker.jpg">
                        <p>Poker</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/ander-baher.jpg">
                        <p>Andar-bahar</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/7updown.jpg">
                        <p>7Up 7Down</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/play-now.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                  </div>
                  <div class="game_wrapper">

                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/warli-matka.jpg">
                        <p>Warli-Matka</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/comming-soon.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                     <a onclick="lobbylink()" href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/open-teen.jpg">
                        <p>Open teenpatti</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/comming-soon.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                  </div>
                  <div class="game_wrapper">
                     <a href="javascript:void(0)" class="item-games">
                        <img src="https://www.365exch.vip/assets/images/games-img/ezugi.jpg">
                        <p>Ezugi</p>
                        <span class="swing"><img src="https://www.365exch.vip/assets/images/games-img/comming-soon.png"></span>
                        <div id="play-video" class="video-play-button"> <span></span></div>
                     </a>
                  </div>

               </div>
            </div>
         </div>


         <div class="betSlipBox" style="display:none;">
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
                                 <input type="hidden" name="placeName" id="placeName" value="" class="form-control">
                                 <input type="hidden" name="text" id="stackcount" value="0" class="form-control">
                                 <input type="hidden" name="text" id="isfancy" value="0" class="form-control">
                              </div>
                           </div>
                        </div>
                        <div class="betPriceBox">
                           <?php
                           if (!empty($chips)) {
                              foreach ($chips as $chip) { ?>
                                 <button class="btn  btn-success CommanBtn  chipName1" type="button" value="<?php echo $chip['chip_value']; ?>" onclick="StaKeAmount(this);"><?php echo $chip['chip_name']; ?></button>
                           <?php }
                           }
                           ?>


                           <button class="btn  btn-success CommanBtn " type="button" onclick="ClearStack( );">Clear</button>
                        </div>
                        <div class="betFooter">
                           <button class="btn btn-danger CommanBtn" type="button" onclick="ClearAllSelection();">Clear All</button>
                           <button class="btn btn-success  CommanBtn placebet" type="button" onclick="PlaceBet();">Place Bet</button>
                           <button class="btn btn-success CommanBtn placefancy" type="button" onclick="PlaceFancy();" style="display:none">Place Bet</button>
                        </div>
                     </form>
                  </div>
               </div>

               <div class="tab_bets">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                     <li class="nav-item betdata active-all active">
                        <a class="allbet" href="javascript:void(0);" onclick="getDataByType(this,'4');"><span class="bet-label">All Bet</span> <span id="cnt_row">( )</span></a>
                     </li>
                     <li class="nav-item betdata active-unmatch">
                        <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType(this,'2');"><span class="bet-label">UnMatch Bet</span> <span id="cnt_row1">( ) </span></span> </a>
                     </li>
                     <li class="nav-item betdata">
                        <a class="unmatchbet" href="javascript:void(0);" onclick="getDataByType(this,'3');"><span class="bet-label">Fancy Bet</span> <span id="cnt_row3">( ) </span></span> </a>
                     </li>


                     <!-- <a class="btn full-btn" onclick="viewAllMatch()" href="javascript:void(0);"><img src="https://www.365exch.vip/assets/images/full-size-btn.png" alt="..."></a> -->
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



            <div class="border-box" id="bettingView" role="main" style="display:none;">
               <div class="fullrow">
                  <div class="modal-dialog-staff">
                     <div class="modal-content">

                        <div class="modal-body"><span id="msg_error"></span><span id="errmsg"></span>

                           <div class="match_bets MachShowHide">
                              <table class="table table-striped jambo_table bulk_action">
                                 <thead>
                                    <tr class="headings">
                                       <td>No.</td>
                                       <td>Runner</td>
                                       <td>Bhaw</td>
                                       <td>Amount</td>
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
<!--footerlinks-->
<!-- <footer>
   <ul class="menu-links">
      <li class="item"><a href="<?php echo base_url(); ?>admin/dashboard?inplay"><img src="https://www.365exch.vip/assets/images/games-img/inplay.png"><span>Inplay</span></a></li>
      <li class="item"><a href="javascript:;" class="UserChipData" onclick="showEditStakeModel()"><img src="https://www.365exch.vip/assets/images/games-img/edit-stake.png"><span>Edit stake</span></a></li>
      <li class="item"><a href="<?php echo base_url(); ?>admin/dashboard" class="site_title endcooki active"><img src="https://www.365exch.vip/assets/images/games-img/home.png"></a></li>
      <li class="item"><a href="<?php echo base_url(); ?>admin/bethistory"><img src="https://www.365exch.vip/assets/images/games-img/history.png"><span>Bet History</span></a></li>
      <li class="item"><a href="<?php echo base_url(); ?>logout"><img src="https://www.365exch.vip/assets/images/games-img/logout.png"><span>Logout</span></a></li>
   </ul>
</footer> -->

<!--footerlinks-->
<script src="https://www.365exch.vip/assets/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://www.365exch.vip/assets/js/bootbox.min.js"></script>
<script src="https://www.365exch.vip/assets/js/pnotify.js"></script>

<script src="https://www.365exch.vip/assets/js/custom.js?ver=1.2"></script>

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
<!--commanpopup-->
</div>
</div>


 

</body>

</html>


<script>
   // setInterval(function() {

   //    $.ajax({
   //       url: "<?php echo base_url(); ?>admin/Events/getevents",
   //       dataType: "json",
   //       success: function() {

   //       }
   //    })
   //    // alert("HEllo");
   // }, 10000);

   var active_event_id;

   function MarketSelection(MarketId,EventId) {


      // $("#UpCommingData").hide();
      // $("#UpCommingData").html('');
      fetchBttingList();
      getFancyData();

      var formData = {
         MarketId: MarketId,
      };
      $.ajax({
         url: "<?php echo base_url(); ?>admin/Events/backlays",
         data: formData,
         type: 'POST',
         dataType: 'json',
         async: false,
         success: function success(output) {
            if (output != '') {
               active_event_id = MarketId;
               $(".matchBox").show();
               $("#UpCommingData").hide();
               $("#MatchOddInfo").show();
               $('#bettingView').show();
               $(".betSlipBox").show();
               $(".other-items").hide();
               $("#MatchOddInfo").append(output.exchangeHtml);
               // currentBet = matchId;
               // currentBetMarketId = MarketId;
               // getMoreData(MarketId, matchId);
               // $('.betdata.active a').click();
            } else {
               closeBetBox(matchId, MarketId);
            }
         }
      });

   }

   setInterval(function() {

      if (active_event_id) {
         var formData = {
            MarketId: active_event_id
         }
         $.ajax({
            url: "<?php echo base_url(); ?>admin/Events/backlays",
            data: formData,
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function success(output) {


               if (output != '') {
                  active_event_id = active_event_id;
                  $(".matchBox").show();
                  $("#UpCommingData").hide();
                  $("#MatchOddInfo").show();

                  $(".betSlipBox").show();
                  $(".other-items").hide();
                  $("#MatchOddInfo").html(output.exchangeHtml);
                  // currentBet = matchId;
                  // currentBetMarketId = MarketId;
                  // getMoreData(MarketId, matchId);
                  // $('.betdata.active a').click();
               } else {
                  closeBetBox(matchId, MarketId);
               }
            }
         });


         fetchBttingList();
         getFancyData();


      }
   }, 5000);


   function fetchBttingList() {
      var formData = {
         MarketId: active_event_id
      }
      $.ajax({
         url: "<?php echo base_url(); ?>admin/Events/bettingList",
         data: formData,
         type: 'POST',
         dataType: 'json',
         async: false,
         success: function(output) {
            console.log("betting-data");
            console.log(output);
            $('.mWallet').html(output.balance);
            $('.liability').html(output.exposure);
            $('#all-betting-data').html(output.bettingHtml);
         }
      });
   }

   function getOddValue(priceVal, matchId, marketId, back_layStatus, placeName, selectionId, className, MarketTypes = '') {
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
      // if (betSlip) {
      //    clearTimeout(betSlip);
      //    betSlip = null;
      // }
      // betSlip = setTimeout(function() {
      //    ClearAllSelection()
      // }, 15000);
      var priceVal = parseFloat(priceVal);
      // var priceVal = $.trim($("#" + className).text());
      var MId = marketId;
      if (active_event_id) {
         matchId = active_event_id;
         marketId = active_event_id;
      }
      MatchMarketTypes = MarketTypes;

      console.log('HEllo' + priceVal + "  " + matchId + "   " + back_layStatus + "  " + placeName + "   " + selectionId);
      // if (priceVal != '' && matchId != '' && back_layStatus != '' && placeName != '') {
      if ($(window).width() < 780) {
         $('.betSlipBox .mod-header').insertBefore('#placeBetSilp');
         $(".betSlipBox .mod-header").show();
         //$(".betBox").insertAfter('.matchOpenBox_' + MId);
         // if (gameType != 'market') {
         //    $("#betslip").insertAfter('.teenpatti-row');
         // } else {
         //    $(".betBox").insertAfter('.matchOpenBox_' + MId);
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
      $("#chkValPrice").val(priceVal);
      $("#selectionId").val(selectionId);
      $("#matchId").val(matchId);
      $("#MarketId").val(marketId);
      $("#isback").val(back_layStatus);
      $("#placeName").val(placeName);
      $("#isfancy").val(0);
      $("#ShowBetPrice").prop('disabled', false);
      if (back_layStatus == 0) {
         $("#pandlosstitle").text('Profit');
         $(".BetFor").text('Back (Bet For)');
      } else {
         $(".BetFor").text('Lay (Bet For)');
         $("#ppandlosstitleandlosstitle").text('Liability');
      }
      ClearAllSelection(0);
      // } else {
      //    new PNotify({
      //       title: 'Erro',
      //       text: 'Invalid Match ID',
      //       type: 'error',
      //       styling: 'bootstrap3',
      //       delay: 3000
      //    });
      // }

   }

   function StaKeAmount(stakeVal) {
      var stakeValue = parseFloat(stakeVal.value);
      var stakeVal = parseFloat($("#stakeValue").val());
      var t_stake = parseFloat(stakeValue + stakeVal);
      $("#stakeValue").val(t_stake);
      calc();
   }

   function calc() {
      var isfancy = $("#isfancy").val();
      var priceVal = parseFloat($("#ShowBetPrice").val());
      var t_stake = parseFloat($("#stakeValue").val());
      var isback = $("#isback").val();

      if (isfancy == 0) {
         // if (gameType == 'market') {
         //    if (MatchMarketTypes == 'M') {
         // var pl = Math.round((priceVal * t_stake) / 100);

         //    } else {
         var pl = Math.round((priceVal * t_stake) - t_stake);
         //    }
         // } else {
         // var pl = Math.round((priceVal * t_stake) / 100);
         // }
         pl = parseFloat(pl.toFixed(2));
         if (isback == 0) {
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
            if (isback == 0) {
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
      $(".position_" + MId).each(function(i) {
         var selecid = $(this).attr('data-id');
         var winloss = parseFloat($(this).val());
         var curr = 0;
         if (selectionId == selecid) {
            if (isback == 0) {
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
            if (isback == 0) {
               curr = winloss + (-1 * (stake));
            } else {
               curr = winloss + stake;
            }
         }
         var currV = Math.round(curr);
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
      //  clearTimeout(betSlip);
      var stake = parseFloat($("#stakeValue").val());


      var priceVal = parseFloat($("#ShowBetPrice").val());
      var MarketId = $("#MarketId").val();
      var matchId = $("#matchId").val();
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
      } else if (MarketId != '' && matchId != '') {
         $(".loader").show();
         $(".CommanBtn").attr("disabled", true);
         var MarketType = $("#MarketType").val();
         var stakeValue = parseInt($("#stakeValue").val());
         var P_and_l = (priceVal * stake) - stake;
         var formData = {


            selectionId: $("#selectionId").val(),
            matchId: $("#matchId").val(),
            isback: $("#isback").val(),
            placeName: $("#placeName").val(),
            // MatchName: $("#MatchName").val(),
            stake: stake,
            priceVal: priceVal,
            p_l: P_and_l,
            MarketId: MarketId,
            MarketType: MarketType
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
                  // $(".loader").css("display", "");
               },
               success: function(data) {
                  $(".loader").hide();
                  ClearAllSelection(1);
                  $(".CommanBtn").attr("disabled", false);
                  if (data.error == 1) {
                     new PNotify({
                        title: 'Error',
                        text: data.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000
                     });
                  } else {
                     fetchBttingList();
                     getFancyData();
                     // var betdata = {
                     //    'btype': 'match',
                     //    'MatchId': formData.matchId,
                     //    'MarketId': formData.MarketId,
                     //    'type': 'bet',
                     //    'parents': data.parent_data,
                     //    'MstCode': data.MstCode,
                     //    'isMatched': data.isMatched,
                     //    'SelectionId': formData.selectionId,
                     //    'Odds': formData.priceVal,
                     //    'isBack': formData.isback,
                     //    'UserId': formData.userId
                     // }
                     // socket.emit('marketaction', betdata);
                     // //$("#UserLiability").text(data.ChipData[0].Liability);
                     // $(".liability").text(data.ChipData[0].Liability);
                     // //$("#Wallet").text(data.ChipData[0].Balance);
                     // $(".mWallet").text(data.ChipData[0].Balance);
                     // $.each(data.RunnerValue, function(keyNew, valueNew) {
                     //    var minvalue = parseFloat(valueNew.winValue);
                     //    var lossValue = parseFloat(valueNew.lossValue);
                     //    var selectionId = valueNew.SelectionId;
                     //    var newVal = minvalue + lossValue
                     //    var newVal = Math.round(newVal);
                     //    MId = formData.MarketId.replace('.', '');
                     //    /* $("#" + selectionId + "_maxprofit_loss_runner_" + MId).text(Math.abs(newVal)).css('color', getValColor(newVal));
                     //    $(".position_" + MId).each(function (i) {
                     //        var selecid = $(this).attr('data-id');
                     //        if (selectionId == selecid) {
                     //            $(this).val(newVal);
                     //        }
                     //    }); */
                     //    if (gameType == 'market') {
                     //       $("#" + selectionId + "_maxprofit_loss_runner_" + MId).text(Math.abs(newVal)).css('color', getValColor(newVal));
                     //       $(".position_" + MId).each(function(i) {
                     //          var selecid = $(this).attr('data-id');
                     //          //alert(selecid);
                     //          if (selectionId == selecid) {
                     //             $(this).val(newVal);
                     //          }
                     //       });
                     //    } else {
                     //       $("#maxprofit_loss_runner_" + keyNew).text(Math.abs(newVal)).css('color', getValColor(newVal));
                     //       $(".position_" + keyNew).val(newVal);
                     //    }
                     // });
                     // getBets(0);
                     new PNotify({
                        title: 'Success',
                        text: 'Bet placed successfully',
                        type: data.notifytype,
                        styling: 'bootstrap3',
                        delay: 3000
                     });
                  }
               },
               error: function(jqXHR) {
                  console.log(jqXHR);
               }
            });
         }, 0);
      } else {
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


   function getFancyData() {
      $.ajax({
         url: "<?php echo base_url(); ?>admin/Events/getfancydata",
         type: 'POST',
         dataType: 'json',
         async: false,
         success: function(output) {
            console.log("fancy-data");
            console.log(output.fancyData);
            // $('.fancybox').remove();
            $('.fancybox').html(output.fancyData);

         }
      });
   }
   // function sendMessage() {
   //    var socket = io.connect('http://' + window.location.hostname + ':3000');
   //    socket.emit('new_message', {
   //       message: "Hello",
   //    });
   // }



   // var socket = io.connect('http://' + window.location.hostname + ':3000');
   // socket.on('new_message', function(data) {
   //    console.log("Html receive");
   //    console.log(data);
   //    $("#cricket").html(data.matchListingHtml);
   // });

   function betfancy(matchid, fancyid, isback) {
      var userType1 = 4;
      if (userType1 == 4) {
         if (isback == 0) {
            $("#placeBetSilp").css("background-color", "#a7d8fd");
         } else {
            $("#placeBetSilp").css("background-color", "#f9c9d4");
         }
         var inputno = parseInt($('#LayNO_' + fancyid).text());
         var inputyes = parseInt($('#BackYes_' + fancyid).text());
         var headname = $(".fancyhead" + fancyid).text();
         $("#stakeValue").focus();
         $('#stakeValue').val(0);
         $("#profitData").text(0);
         $("#LossData").text(0);
         $('#matchId').val(matchid);
         $('#isback').val(isback);
         $('#placeName').val(headname);
         $("#isfancy").val(fancyid);
         $("#ShowBetPrice").prop('disabled', true);
         if (isback == 1) {
            $(".BetFor").text('Lay (Bet for)');
            $("#pandlosstitle").text('Liability');
            $("#ShowBetPrice").val(inputno);
         } else {
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
               url: site_url + 'fancybet',
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
         success: function success(output) {

            output = $.parseJSON(output);
            console.log(output);

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