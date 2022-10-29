<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                Failed Bets
            </span>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>

            <div class="custom-scroll appendAjaxTbl">
                <table class="table table-striped jambo_table bulk_action" id="example">
                    <thead>
                        <tr class="headings">
                            <th>S. No </th>
                            <th>Round id</th>

                            <th>Datetime </th>

                            <th>User </th>


                            <th>Game</th>
                            <th>Bet details</th>
                            <th>Selection</th>
                            <th>Bet Type</th>
                            <th>Type</th>
                            <th>Match Odds</th>

                            <th>Stake</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($bettings)) {
                            $i = 1;
                            foreach ($bettings as $report) {


                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $report['betting_id']; ?></td>

                                    <td><?php echo date('d M Y H:i:s', strtotime($report['created_at'])); ?></td>


                                    <td><?php echo $report['client_name']; ?>(<?php echo $betting['client_user_name']; ?>) </td>

                                    <td><?php echo $report['game']; ?></td>
                                    <td><?php echo $report['event_name']; ?>
                                        <?php
                                        if ($report['betting_type'] != 'Fancy') {
                                            echo '/' . $report['market_name'];
                                        } ?>
                                        /<?php echo $report['place_name']; ?></td>
                                    <td class=""><?php
                                                    if ($report['betting_type'] == 'Fancy') {
                                                    } else {
                                                        echo $report['place_name'];
                                                    }

                                                    ?></td>
                                    <td><?php
                                        if ($report['is_back'] == 1) {
                                            echo "Back";
                                        } else {
                                            echo "Lay";
                                        }
                                        ?></td>
                                    <td><?php echo $report['betting_type']; ?></td>
                                    <td><?php echo $report['price_val']; ?></td>

                                    <td><?php
                                        if (get_user_type() == 'User') {
                                            echo $report['loss'];
                                        } else {
                                            echo $report['loss'];
                                        }
                                        ?></td>


                                </tr>
                        <?php   }
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "searching": true,
            "paging": true,
            "order": []

        });
    });
</script>