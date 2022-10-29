<table class="table table-bordered" id="example" style="width:100%;">
    <thead>
        <tr>
            <th>S. No.</th>
            <th>Date</th>
            <th>Description</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($reports)) {
            $i = 1;
            foreach ($reports as $report) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo !isset($report['is_opening']) ? date('Y-m-d H:i:s', strtotime($report['created_at'])) : " "; ?></td>
                    <td><?php

                        if ($report['type'] == 'Betting') {

                            if ($report['match_id'] == '98789' || $report['match_id'] == '98791' || $report['match_id'] == '56768' || $report['match_id'] == '87564' || $report['match_id'] == '56967' || $report['match_id'] == '98790' || $report['match_id'] == '56767') {
                                $round_id = explode('__', $report['market_id']);


                                if (!empty($round_id)) {
                                    $round_id = $round_id[1];
                                    $round_id = explode('_', $round_id);

                                    if (!empty($round_id)) {

                                        $round_id  = $round_id[0];
                                    }
                                }

                        ?>
                                <a href="<?php echo base_url(); ?>admin/Reports/profitLossDetail/<?php echo $report['match_id']; ?>/<?php echo $user_id; ?>/<?php echo $report['market_id']; ?>"><?php echo $report['event_name']; ?> / <?php echo empty($report['market_name']) ? "Match Odds" : $report['market_name']; ?> / <?php echo $round_id; ?></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url(); ?>admin/Reports/profitLossDetail/<?php echo $report['match_id']; ?>/<?php echo $user_id; ?>"><?php echo $report['event_name']; ?> / <?php echo $report['market_name']; ?> </a>
                            <?php                                } ?>
                        <?php } else {
                            echo $report['remarks'];
                        }

                        ?>
                    </td>
                    <td><?php

                        if ($report['transaction_type'] == 'Credit') {
                            echo $report['amount'];
                            $opening_balance += $report['amount'];
                        } else {
                            echo "0.00";
                        }
                        ?></td>
                    <td><?php
                        if ($report['transaction_type'] == 'Debit') {
                            echo $report['amount'];
                            $opening_balance -= $report['amount'];
                        } else {
                            echo "0.00";
                        }
                        ?></td>
                    <td><?php echo number_format($report['available_balance'], 0); ?></td>

                </tr>
        <?php }
        }
        ?>
    </tbody>
</table>