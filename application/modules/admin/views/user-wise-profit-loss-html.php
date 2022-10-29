<table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th style="width:30%;">Account</th>
                                        <?php
                                        if (!empty($runners)) {
                                            foreach ($runners as $runner) { ?>
                                                <th class="text-center">
                                                    <span id="ContentPlaceHolder1_team01"><?php echo $runner['runner_name']; ?></span>
                                                </th>

                                        <?php }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody >

                               
<input name="profit_loss_user_id" type="hidden" id="profit_loss_user_id" value="<?php echo $user_id; ?>" />


<?php
$i = 1;

if (!empty($profitLossDatas)) {
?>


    <?php
    foreach ($profitLossDatas as $data) { ?>
        <tr>

            <td style="font-weight:600;">
                <?php
                if ($data['user_type'] == 'User') { ?>
                    <?php echo $data['user_name']; ?> (<?php echo $data['name'] ?>)</td>

        <?php } else { ?>
            <a href="javascript:void(0);" onclick="fetchMatchOddsPositionList('<?php echo $match_id; ?>','<?php echo $market_id; ?>','<?php echo $data['user_id']; ?>')"><?php echo $data['user_name']; ?> (<?php echo $data['name'] ?>)</a></td>

        <?php }
        ?>

        <?php
        $exposures = $data['exposure'];
        $k = 0;
        foreach ($exposures as $exposure) {

            $runners = $data['runners'];
            if (!empty($runners)) {

                $selectionId   = $runners[$k]['selection_id'];

                $exposure = $exposures[$selectionId];
                $k++;
            }
            if ($exposure < 0) { ?>
                <td class="minus" style="text-align:center;"><?php echo abs($exposure); ?></td>

            <?php } else { ?>
                <td class="plus" style="text-align:center;"><?php echo abs($exposure); ?></td>

            <?php }
            ?>

        <?php       }


        if (sizeof($exposures) == 2) { ?>
            <td></td>

        <?php }
        ?>
        </tr>
<?php
        $i++;
    }
}

$i = 1;

// p($bookmakerProfitLossDatas);

?>

<tr>
    <td colspan="">Parent</td>
    <?php
    $k = 0;
    foreach ($upline_pls as $exposure) {


        $runners = $runners;
        if (!empty($runners)) {

            $selectionId   = $runners[$k]['selection_id'];

            $exposure = $upline_pls[$selectionId];
            $k++;
        }
        if ($exposure < 0) { ?>
            <td class="minus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php } else { ?>
            <td class="plus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php }
        ?>

    <?php       } ?>


</tr>

<?php
if ($user_type != 'Super Admin') { ?>
    <!-- <tr>
            <td colspan=""><?php
                            if ($user_type == 'Admin') {
                                echo "Super Admin";
                            } else if ($user_type == 'Hyper Super Master') {
                                echo "Admin";
                            } else if ($user_type == 'Super Master') {
                                echo "SMDL";
                            } else if ($user_type == 'Master') {
                                echo "MDL";
                            }
                            ?> P&L</td>
            <?php
            $k = 0;
            foreach ($upline_pls as $exposure) {


                $runners = $runners;
                if (!empty($runners)) {

                    $selectionId   = $runners[$k]['selection_id'];

                    $exposure = $upline_pls[$selectionId];
                    $k++;
                }
                if ($exposure < 0) { ?>
                    <td class="minus"><?php echo abs($exposure); ?></td>

                <?php } else { ?>
                    <td class="plus"><?php echo abs($exposure); ?></td>

                <?php }
                ?>

            <?php       } ?>


        </tr> -->
<?php }
?>

<!-- <tr>
        <td colspan=""><?php
                        if ($user_type == 'Super Admin') {
                            echo "Super Admin";
                        } else if ($user_type == 'Admin') {
                            echo "Admin";
                        } else if ($user_type == 'Hyper Super Master') {
                            echo "SMDL";
                        } else if ($user_type == 'Super Master') {
                            echo "MDL";
                        } else if ($user_type == 'Master') {
                            echo "DL";
                        }
                        ?> P&L</td>
        <?php
        $k = 0;
        foreach ($self_pls as $exposure) {


            $runners = $runners;
            if (!empty($runners)) {

                $selectionId   = $runners[$k]['selection_id'];

                $exposure = $self_pls[$selectionId];
                $k++;
            }
            if ($exposure < 0) { ?>
                <td class="minus"><?php echo abs($exposure); ?></td>

            <?php } else { ?>
                <td class="plus"><?php echo abs($exposure); ?></td>

            <?php }
            ?>

        <?php       } ?>


    </tr> -->
<tr>
    <td colspan="">Own</td>
    <?php
    $k = 0;
    foreach ($self_pls as $exposure) {


        $runners = $runners;
        if (!empty($runners)) {

            $selectionId   = $runners[$k]['selection_id'];

            $exposure = $self_pls[$selectionId];
            $k++;
        }
        if ($exposure < 0) { ?>
            <td class="minus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php } else { ?>
            <td class="plus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php }
        ?>

    <?php       } ?>


</tr>


<tr>
    <td colspan="">Total</td>
    <?php
    $k = 0;

    $total_0 = 0;
    $total_1 = 0;
    $total_2 = 0;

    foreach ($self_pls as $exposure) {


        $runners = $runners;
        if (!empty($runners)) {

            $selectionId   = $runners[$k]['selection_id'];

            $exposure = $self_pls[$selectionId] + $upline_pls[$selectionId];

            
            $k++;
        }
        if ($exposure < 0) { ?>
            <td class="minus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php } else { ?>
            <td class="plus" style="text-align:center;"><?php echo abs($exposure); ?></td>

        <?php }
        ?>

    <?php       } ?>


</tr>
</tbody>
                            </table>