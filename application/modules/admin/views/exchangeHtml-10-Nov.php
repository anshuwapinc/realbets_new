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


                <div class="fullrow matchBoxMain  matchBox_<?php echo $event['event_id']; ?> matchBoxs_<?php echo $event['event_id']; ?>" style="display:block; position:relative;">
                    <div id="overlay" class="overlay_matchBoxs_<?php echo  str_replace('.', '', $market_type['market_id']); ?>">
                        <div id="text" class="status_matchBoxs_<?php echo  str_replace('.', '', $market_type['market_id']); ?>">Open</div>
                    </div>
                    <div class="modal-dialog-staff">
                        <!-- dialog body -->
                        <div class="match_score_box">
                            <div class="modal-header mod-header">
                                <div class="block_box" style="display:flow-root;">
                                    <span id="tital_change">

                                        <?php
                                        if ($event['is_favourite']) { ?>
                                            <span id='fav<?php echo $event['event_id']; ?>'><i class='fa fa-star' aria-hidden='true' onclick="favouriteSport(<?php echo $event['event_id']; ?>)"></i></span>

                                        <?php } else { ?>
                                            <span id='fav<?php echo $event['event_id']; ?>'><i class='fa fa-star-o' aria-hidden='true' onclick="favouriteSport(<?php echo $event['event_id']; ?>)"></i></span>

                                        <?php }
                                        ?>
                                        <?php echo $event['event_name'] ?> <input type="hidden" value="<?php echo  $event['event_name']  ?>" id="sportName_4310">
                                    </span>
                                    <div class="block_box_btn">
                                        <button class="btn btn-primary btn-xs" onclick="getCurrentBets(<?php echo $event['event_id']; ?>)">Bets</button>
                                        <button class="btn btn-primary btn-xs" onclick="closeBetBox(<?php echo $event['event_id']; ?>)">X</button>
                                    </div>
                                </div>
                            </div>
                            <div class="score_area"><span class="matchScore" id="matchScore_4310"> </span> </div>

                        </div>
                        <div class="matchClosedBox_214310" style="display:none">
                            <div class="fullrow fullrownew">
                                <div class="pre-text">
                                    <?php echo $market_type['market_name']; ?><br>
                                    <!-- <span class="match-colsed"> Closed </span> -->
                                </div>
                                <div class="matchTime">
                                    <?php echo date('d/m/Y h:i:s a', strtotime($event['open_date'])); ?>)
                                </div>
                            </div>
                            <div>
                                <div class="closedBox">
                                    <h1>Closed</h1>
                                </div>
                            </div>
                        </div>
                        <div class="sportrow-4 matchOpenBox_<?php echo  str_replace('.', '', $market_type['market_id']); ?>">
                            <div class="match-odds-sec">
                                <div class="item match-status newbg">
                                    <?php echo $market_type['market_name']; ?> </div>
                                <div class="item match-status-odds newbg">
                                    <?php
                                    if ($market_type['inplay'] == 1) { ?>
                                        <span class="inplay_txt"> In-play </span>
                                    <?php } else { ?>
                                        <span class="going_inplay"> Going In-play </span>

                                    <?php }
                                    ?>

                                </div>
                                <?php
                                if ($market_type['inplay']) { ?>
                                    <!-- <span class="inplay_txt"> In-play </span> -->
                                <?php } else { ?>
                                    <!-- <div class="item match-shedule" id="demo_4310">0d 5h 35m 41s </div> -->

                                <?php }
                                ?>
                            </div>
                            <div class="fullrow MatchIndentB" style="position:relative;">

                                <table class="table table-striped  bulk_actions matchTable214310" id="matchTable4310">
                                    <tbody>
                                        <tr class="headings mobile_heading">

                                            <th class="fix_heading color_red">

                                                <?php
                                                if ($market_type['market_name'] != 'Bookmaker') { ?>
                                                    Min stake:<?php echo $market_type['user_info']->min_stake; ?> Max stake:<?php echo $market_type['user_info']->max_stake; ?>
                                                <?php  } else if ($market_type['market_name'] == 'Bookmaker') { ?>
                                                    Min stake:<?php echo $market_type['bookmaker_user_info']->min_stake; ?> Max stake:<?php echo $market_type['bookmaker_user_info']->max_stake; ?>

                                                <?php } ?>
                                            </th>
                                            <th> </th>
                                            <th> </th>
                                            <th class="back_heading_color">Lagai</th>
                                            <th class="lay_heading_color">Khai</th>
                                            <th> </th>
                                            <th> </th>
                                        </tr>

                                        <?php
                                        if (!empty($market_type['runners'])) {
                                            $runners = $market_type['runners'];

                                            foreach ($runners as $runner) {
                                        ?>
                                                <tr id="user_row_<?php echo $runner['sort_priority']; ?>" class="back_lay_color runner-row-<?php echo $runner['sort_priority']; ?>">
                                                    <td>
                                                        <p class="runner_text" id="runnderName<?php echo $runner['sort_priority']; ?>"><?php echo $runner['runner_name']; ?> </p>
                                                        <p class="blue-odds" id="Val<?php echo $runner['sort_priority']; ?>-<?php echo $event['event_id']; ?>">0</p>
                                                        <?php
                                                        $exposure = $runner['exposure'];
                                                        if ($exposure < 0) { ?>
                                                            <span class="runner_amount" style="color:red;" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo  str_replace('-', '', $exposure); ?></span>
                                                        <?php } else { ?>
                                                            <span class="runner_amount" style="color:green" id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>_maxprofit_loss_runner_<?php echo  str_replace('.', '', $runner['market_id']); ?>"><?php echo abs($exposure); ?></span>
                                                        <?php  }

                                                        ?>
                                                        <input type="hidden" class="position_<?php echo  str_replace('.', '', $runner['market_id']); ?>" id="selection_<?php echo $runner['sort_priority']; ?>" data-id="<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>" value="<?php echo $exposure; ?>">
                                                    </td>

                                                    <!--- availableToBack -->


                                                    <td class="1_0availableToBack2_price_214310" onclick="getOddValue(<?php echo $event['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                        <span class="priceRate" id="availableToBack3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['back_3_price']); ?>
                                                        </span>
                                                        <span id="availableToBack3_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo $runner['back_3_size']; ?>
                                                        </span>
                                                    </td>


                                                    <td class="1_0availableToBack2_price_214310" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                        <span class="priceRate" id="availableToBack2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['back_2_price']); ?>
                                                        </span>
                                                        <span id="availableToBack2_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo $runner['back_2_size']; ?>
                                                        </span>
                                                    </td>


                                                    <td class="1_0availableToBack2_price_214310" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,1,'<?php echo $runner['runner_name']; ?>','availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                        <span class="priceRate" id="availableToBack1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['back_1_price']); ?>
                                                        </span>
                                                        <span id="availableToBack1_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['back_1_size']); ?>
                                                        </span>
                                                    </td>


                                                    <!--- availableToLay -->


                                                    <td class="1_0availableToLay2_price_214310" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">

                                                        <span class="priceRate" id="availableToLay1_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['lay_1_price']); ?>
                                                        </span>
                                                        <span id="availableToLay1_size_<?php echo isset($market_type['market_id']) ? str_replace('.', '', $market_type['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo $runner['lay_1_size']; ?>

                                                        </span>
                                                    </td>

                                                    <td class="1_0availableToLay2_price_214310" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay2_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                        <span class="priceRate" id="availableToLay2_price_<?php echo isset($market_type['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['lay_2_price']); ?>

                                                        </span>
                                                        <span class="priceRate" id="availableToLay2_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo $runner['lay_2_size']; ?>
                                                        </span>
                                                    </td>

                                                    <td class="1_0availableToLay2_price_214310" onclick="getOddValue(<?php echo $runner['event_id']; ?>,`<?php echo $runner['market_id']; ?>`,0,'<?php echo $runner['runner_name']; ?>','availableToLay3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>','B',this);">
                                                        <span class="priceRate" id="availableToLay3_price_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo floatVal($runner['lay_3_price']); ?>

                                                        </span>
                                                        <span id="availableToLay3_size_<?php echo isset($runner['market_id']) ? str_replace('.', '', $runner['market_id']) : ''; ?>_<?php echo isset($runner['selection_id']) ? $runner['selection_id'] : ''; ?>">
                                                            <?php echo $runner['lay_3_size']; ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                        <?php  }
                                        }
                                        ?>





                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
        <?php  }
        }
        ?>

<?php  }
}
?>