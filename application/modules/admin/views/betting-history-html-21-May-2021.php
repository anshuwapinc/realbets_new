<div class="custom-scroll appendAjaxTbl" style="padding:0px;">
    <table class="table table-striped jambo_table bulk_action" id="example">
        <thead>
            <tr class="headings">
                <th class="">S.No.</th>
                <?php
                if (get_user_type() != 'User') { ?>
                    <th class="">Client</th>

                <?php }
                ?>
                <th class="">Description</th>
                <th class="">Date</th>

                <th class="">Selection</th>
                <th class="">Type</th>
                <th class="">Bhaw</th>
                <th class="">Amount</th>
                <th class="">P_L</th>
                <th class="">Profit</th>
                <th class="">Loss</th>
                <th class="">Bet type</th>
                <th class="">Status</th>
                <th class="">IP</th>
                <th class="">Device</th>
                <th class="">ID</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 1;
            $pl = 0;
            $loss = 0;
            if (!empty($bettings)) {

                foreach ($bettings as $betting) {

                     if ($betting['bet_result'] == 'Plus') {
                        $pl = $betting['profit'];
                        $loss = 0;
                    } elseif ($betting['bet_result'] == 'Minus') {
                        $pl =  0;
                        $loss =   $betting['loss'];
                    }

            ?>


                    <?php
                    if ($betting['is_back'] == 1) {
                    ?>
                        <tr id="user_row_1262587" class="mark-back  content_user_table">

                            <td class="mark-back"><?php echo $i ?></td>
                            <?php
                            if (get_user_type() != 'User') { ?>
                                <td class="mark-back"><?php echo $betting['client_name']; ?>(<?php echo $betting['client_user_name']; ?>)</td>
                            <?php }
                            ?>
                            <td class="mark-back">
                                <?php echo $betting['name'] . '>' . $betting['competition_name'] . '>' . $betting['event_name'] . '>';

                                if ($betting['betting_type'] == 'Fancy') {
                                   echo  $betting['place_name'];
                                } else {
                                    echo  $betting['market_name'];
                                }


                                 if ($betting['betting_status'] == 'Settled') {

                                    if($betting['betting_type'] == 'Fancy' )
                                    {
                                        echo  '(Res: '.$betting['settled_result'].')';
                                    }
                                    else
                                    {
                                        echo  '(Win: '.$betting['settled_result'].')';
                                    }
                                 }
                                ?>
                            </td>
                            <td class="mark-back"><?php echo $betting['created_at']; ?></td>

                            <td class="runner-name mark-back"><?php
                             if ($betting['betting_type'] == 'Fancy') {
                               
                               
                             } else {
                                echo $betting['place_name'];
                             }

                            ?></td>
                            <td class="mark-back">  <?php
                                if ($betting['betting_type'] == 'Fancy') { ?>
                                Yes
                                <?php     } else { ?>
                                Lagai
                                <?php } ?></td>
                            <td class="mark-back"><?php echo $betting['price_val']; ?></td>
                            <td class="mark-back"><?php echo $betting['stake']; ?></td>
                            <td class="mark-back"><?php echo $betting['profit']; ?></td>

                            <?php
                            if (get_user_type() != 'User') { ?>
                                <td class="mark-back"><?php echo $loss; ?></td>
                                <td class="mark-back"><?php echo $pl; ?></td>
                            <?php } else { ?>

                                <td class="mark-back"><?php echo $pl; ?></td>
                                <td class="mark-back"><?php echo $loss; ?></td>
                            <?php }
                            ?>

                            <td class="mark-back"><?php echo $betting['betting_type']; ?></td>
                            <td class="mark-back"><?php echo $betting['betting_status']; ?></td>
                            <td class="mark-back"><?php echo $betting['ip_address']; ?></td>
                            <td class="mark-back"><span><i class="fa fa-mobile"></i></span></td>
                            <td class="mark-back"><?php echo $betting['betting_id']; ?></td>

                        </tr>
                    <?php } else {
                    ?>
                        <tr id="mark-lay content_user_table " class="mark-lay  content_user_table">
                            <td class="mark-lay"><?php echo $i ?></td>
                            <?php
                            if (get_user_type() != 'User') { ?>
                                <td class="mark-lay"><?php echo $betting['client_name']; ?>(<?php echo $betting['client_user_name']; ?>)</td>
                            <?php }
                            ?>
                            <td class="mark-lay">
                                <?php echo $betting['name'] . '>' . $betting['competition_name'] . '>' . $betting['event_name'] . '>';
                                if ($betting['betting_type'] == 'Fancy') {
                                    echo  $betting['place_name'];
                                } else {
                                    echo  $betting['market_name'];
                                }

                                if ($betting['betting_status'] == 'Settled') {

                                    if($betting['betting_type'] == 'Fancy' )
                                    {
                                        echo  '(Res: '.$betting['settled_result'].')';
                                    }
                                    else
                                    {
                                        echo  '(Win: '.$betting['settled_result'].')';
                                    }
                                 }
                                ?>
                            </td>
                            <td class="mark-lay"><?php echo $betting['created_at']; ?></td>

                            <td class="runner-name mark-lay"><?php
                             if ($betting['betting_type'] == 'Fancy') {
                              
                             } else {
                                echo $betting['place_name'];
                             }

                            ?></td>

                            <td class="mark-lay">
                            <?php
                                if ($betting['betting_type'] == 'Fancy') { ?>
                                Not
                                <?php     } else { ?>
                                Khai
                                <?php } ?>
                            </td>
                            <td class="mark-lay"><?php echo $betting['price_val']; ?></td>
                            <td class="mark-lay"><?php echo $betting['stake']; ?></td>
                            <td class="mark-lay"><?php echo $betting['profit']; ?></td>
                            <?php if (get_user_type() != 'User') { ?>
                                <td class="mark-lay"><?php echo $loss; ?></td>
                                <td class="mark-lay"><?php echo $pl; ?></td>
                            <?php } else { ?>

                                <td class="mark-lay"><?php echo $pl; ?></td>
                                <td class="mark-lay"><?php echo $loss; ?></td>
                            <?php }
                            ?>

                            <td class="mark-lay"><?php echo $betting['betting_type']; ?></td>
                            <td class="mark-lay"><?php echo $betting['betting_status']; ?></td>
                            <td class="mark-lay"><?php echo $betting['ip_address']; ?></td>
                            <td class="mark-lay"><span><i class="fa fa-mobile"></i></span></td>
                            <td class="mark-lay"><?php echo $betting['betting_id']; ?></td>
                        </tr>

                    <?php
                    }
                    ?>

            <?php $i++;
                }
            }
            ?>
        </tbody>
    </table>

</div>