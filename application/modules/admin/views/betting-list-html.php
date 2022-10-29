<?php
if (!empty($bettings)) {
    $i = 1;
    foreach ($bettings as $betting) {



?>
        <?php
        if ($betting['is_back']) {
        ?>
            <tr id="user_row_<?php echo $betting['betting_id']; ?>" class="mark-back  content_user_table all-bet-slip <?php echo strtolower($betting['betting_type']); ?>-bet-slip <?php if ($betting['unmatch_bet'] == 'Yes') {
                                                                                                                                                                                        echo "unmatch-bet-slip";
                                                                                                                                                                                    } ?>" data-is-back="<?php echo $betting['is_back']; ?>" data-selection-id="<?php echo $betting['selection_id']; ?>" data-market-id="<?php echo $betting['market_id']; ?>" data-match-id="<?php echo $betting['match_id']; ?>" data-price-val="<?php echo $betting['price_val']; ?>" data-market-name="<?php echo $betting['market_name']; ?>">
                <td class="matchbetcolor mark-back"><?php echo $i++; ?></td>
                <?php
                $user_type = $_SESSION['my_userdata']['user_type'];
                if ($user_type != 'User') { ?>
                    <td class="matchbetcolor mark-back"><?php echo $betting['client_name']; ?>(<?php echo $betting['client_user_name']; ?>)</td>

                <?php }
                ?>

                <?php

                if (get_user_type() == 'User') {
                    if ($betting['unmatch_bet'] == 'Yes') { ?>
                        <td class="mark-back"><a href="javascript:void(0);" onclick="deleteBet(`<?php echo $betting['betting_id']; ?>`)"><i class="fa fa-trash"></i></a></td>

                    <?php } else { ?>
                        <td class="mark-back"></td>

                <?php }
                } ?>


                <td class="runner-name mark-back"><?php
                                                    if ($betting['betting_type'] === 'Match') {
                                                        echo $betting['market_name'] . ' / ';
                                                    }
                                                    ?> <?php echo $betting['place_name']; ?></td>

                <td class="mark-back"><?php echo $betting['price_val']; ?></td>
                <td class="mark-back"><?php echo $betting['loss']; ?></td>
                <td class="mark-back"><?php echo $betting['profit']; ?></td>

                <td class="mark-back">
                    <?php
                    if ($betting['betting_type'] == 'Fancy') { ?>
                        Yes
                    <?php  } else { ?>
                        Lagai
                    <?php }
                    ?>
                </td>
                <!--td class=""></td-->
                <td class="mark-back"><?php echo date('Y-m-d H:i:s', strtotime($betting['created_at'])); ?></td>
                <td class="mark-back"><?php echo $betting['betting_id']; ?></td>

                <td class="mark-back"><?php echo $betting['ip_address']; ?></td>

                <td class="mark-back"><?php echo $betting['unmatch_bet']; ?></td>




            </tr>
        <?php } else {
        ?>
            <tr id="user_row_<?php echo $betting['betting_id']; ?>" class="mark-lay  content_user_table  all-bet-slip <?php echo strtolower($betting['betting_type']); ?>-bet-slip <?php if ($betting['unmatch_bet'] == 'Yes') {
                                                                                                                                                                                        echo "unmatch-bet-slip";
                                                                                                                                                                                    } ?>" data-is-back="<?php echo $betting['is_back']; ?>" data-selection-id="<?php echo $betting['selection_id']; ?>" data-market-id="<?php echo $betting['market_id']; ?>" data-match-id="<?php echo $betting['match_id']; ?>" data-price-val="<?php echo $betting['price_val']; ?>" data-market-name="<?php echo $betting['market_name']; ?>">
                <td class="matchbetcolor mark-lay"><?php echo $i++; ?></td>
                <?php
                $user_type = $_SESSION['my_userdata']['user_type'];
                if ($user_type != 'User') { ?>
                    <td class="matchbetcolor mark-lay"><?php echo $betting['client_name']; ?>(<?php echo $betting['client_user_name']; ?>)</td>

                <?php }
                ?>

                <?php

                if (get_user_type() == 'User') {
                    if ($betting['unmatch_bet'] == 'Yes') { ?>
                        <td class="mark-lay"><a href="javascript:void(0);" onclick="deleteBet(`<?php echo $betting['betting_id']; ?>`)"><i class="fa fa-trash"></i></a></td>

                    <?php } else {
                    ?>
                        <td class="mark-lay"></td>

                <?php }
                }  ?>
                <td class="runner-name mark-lay"><?php
                                                    if ($betting['betting_type'] === 'Match') {
                                                        echo $betting['market_name'] . ' / ';
                                                    }
                                                    ?> <?php echo $betting['place_name']; ?></td>
                <td class="mark-lay"><?php echo $betting['price_val']; ?></td>
                <td class="mark-lay"><?php echo $betting['loss']; ?></td>
                <td class="mark-lay"><?php echo $betting['profit']; ?></td>
                <td class="mark-lay">
                    <?php
                    if ($betting['betting_type'] == 'Fancy') { ?>
                        Not
                    <?php  } else { ?>
                        Khai
                    <?php }
                    ?>
                </td>
                <!--td class=""></td-->
                <td class="mark-lay"><?php echo date('Y-m-d H:i:s', strtotime($betting['created_at'])); ?></td>
                <td class="mark-lay"><?php echo $betting['betting_id']; ?></td>

                <td class="mark-lay"><?php echo $betting['ip_address']; ?></td>
                <td class="mark-lay"><?php echo $betting['unmatch_bet']; ?></td>



            </tr>

        <?php
        }
        ?>

<?php }
}
?>