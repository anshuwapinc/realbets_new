<style>
    .block_box_btn button {
        margin-right: 3px;
    }
</style>

<?php
// p($event,0);

if (!empty($events)) {
    foreach ($events as $event) {

        if (!empty($event['market_types'])) {
            foreach ($event['market_types'] as $market_type) {


                if (isset($market_type['is_block'])) {
                    continue;
                }

                if (empty($market_type['runners'])) {
                    continue;
                }


                if ($market_type['market_name'] == 'Bookmaker') {
                    if ($market_type['bookmaker_user_info']->is_bookmaker_active == 'No') {
                        continue;
                    }
                }

                if ($market_type['market_name'] != 'Bookmaker') {
                    if ($market_type['user_info']->is_odds_active == 'No') {
                        continue;
                    }
                }

?>

                <?php
                if ($market_type['market_name'] == 'Bookmaker') { ?>
                    <input type="hidden" value="<?php echo $market_type['market_id']; ?>" name="bookmaker_id" id="bookmaker_id" />
                <?php } ?>


                <!-- <div class="matchClosedBox_1190470587" style="display:none">
                    <div class="fullrow fullrownew">
                        <div class="pre-text">
                            Match Odds <br>
                            <span class="match-colsed"> Closed </span>
                        </div>
                        <div class="matchTime">
                            10/11/2021 07:30 PM </div>
                    </div>
                    <div>
                        <div class="closedBox">
                            <h1>Closed</h1>
                        </div>
                    </div>
                </div> -->
                <div class="tabel-scroll-4 matchOpenBox_1190470587">
                    <div class="market-listing-table 1190470587  matchTable1190470587    " id="matchTable31057636">

                        <button class="btn btn-primary btn-xs dismiss_btn" onclick="closeBetBox(31057636, '1.190470587')">X</button>

                        <div class="game-head">
                            <ul class="match-btn">

                                <li>
                                    <a class="btn-pin 31057636"><?php echo $market_type['market_name']; ?></a>
                                </li>
                                <li> <a class="btn-refresh" onclick="getUserPosition(31057636,'1.190470587')"><i class="fas fa-boxes"></i> Position</a>
                                </li>

                            </ul>
                        </div>
                        <div class="bet_mob">
                            <div class="maxminstake">

                                <?php
                                if ($market_type['market_name'] != 'Bookmaker') { ?>
                                    Min :<?php echo $market_type['user_info']->min_stake; ?>Max :<?php echo $market_type['user_info']->max_stake; ?> <?php echo $market_type['bookmaker_user_info']->bet_delay; ?> sec </div>
                        <?php  } else if ($market_type['market_name'] == 'Bookmaker') { ?>
                            Min :<?php echo $market_type['bookmaker_user_info']->min_stake; ?>Max :<?php echo $market_type['bookmaker_user_info']->max_stake; ?> <?php echo $market_type['bookmaker_user_info']->bet_delay; ?> sec
                        </div>

                    <?php } ?>



                    <div class="w-56"></div>
                    <div class="w-56"></div>
                    <div class="player-draw w-56 ">Back </div>
                    <div class="player-draw w-56">Lay </div>
                    <div class="w-56"></div>
                    <div class="w-56"></div>
                    </div>

                    <div>

                        <?php
                        if (!empty($market_type['runners'])) {
                            $runners = $market_type['runners'];

                            foreach ($runners as $runner) {
                        ?>

                                <div id="user_row " class="odds_rows runner-row-10301">
                                    <div class="events_odds">
                                        <div class="event-name" id="runnderName0">

                                            <div class="team-details">
                                                <div class="horce-pop-team"> <i class="fas fa-chart-bar"></i><?php echo $runner['runner_name']; ?></div>
                                            </div>
                                            <small class="ng-scope odds_value" style="color:#333" id="10301_maxprofit_loss_runner_1190470587">
                                                <i class="fas fa-caret-right"></i> 0 </small>
                                        </div>
                                        <div class="valuename">
                                        <?php
                                                        $exposure = $runner['exposure'];
                                                        if ($exposure < 0) { ?>
                                                            <span class="runner_amount" style="color:red;" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo  str_replace('-', '', $exposure); ?></span>
                                                        <?php } else { ?>
                                                            <span class="runner_amount" style="color:green" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo abs($exposure); ?></span>
                                                        <?php  }

                                                        ?>
                                                        <input type="hidden" class="position_<?php echo  str_replace('.', '', $runner['market_id']); ?>" id="selection_<?php echo $runner['sort_priority']; ?>" data-id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>" value="<?php echo $exposure; ?>">



                                        </div>
                                    </div>

                                    <div class="odds_group">
                                        <div class="backbattingbox" onclick="getOddValue(<?php echo $event['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class="back betting-blue   10301_0availableToBack2_price_1190470587 ">
                                                <strong class=" priceRate odds ng-binding" id="availableToBack3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">  <?php echo floatVal($runner['back_3_price']); ?></strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack3_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['back_3_size']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="backbattingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class="priceRate back betting-blue   10301_0availableToBack1_price_1190470587 ">
                                                <strong class="odds ng-binding" id="availableToBack2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"> <?php echo floatVal($runner['back_2_price']); ?></strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack2_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['back_2_size']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="backbattingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class=" back betting-blue mark-back 10301_0availableToBack0_price_1190470587 ">
                                                <strong class="priceRate odds ng-binding" id="availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['back_1_price']); ?></strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToBack1_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['back_1_size']); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--- availableToLay -->
                                      
                                        <div class="laybettingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class="lay betting-pink mark-lay ">
                                                <strong class="priceRate odds ng-binding" id="availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['lay_1_price']); ?></strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToLay1_size_<?php echo isset($market_type['market_id']) ? str_replace('.', '', $market_type['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['lay_1_size']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="laybettingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class="lay betting-pink   10301_0availableToLay2_price_1190470587">
                                                <strong class="priceRate odds ng-binding" id="availableToLay2_price_<?php echo isset($market_type['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo floatVal($runner['lay_2_price']); ?></strong>
                                                <div class="size">
                                                    <span class="priceRate ng-binding" id="availableToLay2_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['lay_2_size']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="laybettingbox" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                            <div class="lay betting-pink  10301_0availableToLay0_price_1190470587 ">
                                                <strong class="odds ng-binding" id="availableToLay3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"> <?php echo floatVal($runner['lay_3_price']); ?></strong>
                                                <div class="size">
                                                    <span class="ng-binding" id="availableToLay3_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>"><?php echo $runner['lay_3_size']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php }
                        } ?>



                    </div>
                    <div class="market-msg" style="color:red"></div>
                </div>
                </div>
        <?php  }
        }
        ?>

<?php  }
}
?>