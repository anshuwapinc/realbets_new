<table class="table bets-table">
    <thead>
        <tr class="box-heading fancy-head">
            <th style="text-align: center;">Score</th>
            <th style="text-align: center;">Amount</th>
        </tr>
    </thead>
    <tbody align="center">
        <?php
        if (!empty($scores)) {
            foreach ($scores as $key => $score) {
                if ($score < 0) { ?>
                    <tr>
                        <td class="back-txt ng-binding" style="color:#000"><?php echo $key; ?></td>
                        <td class="amou_no amt-txt ng-binding text-danger"><b><?php echo $score; ?></b></td>
                    </tr>
                <?php } else if ($score >= 0) { ?>
                    <tr>
                        <td class="back-txt ng-binding"  style="color:#000"><?php echo $key; ?></td>
                        <td class="amou_no amt-txt ng-binding text-success"><b><?php echo $score; ?></b></td>
                    </tr>
        <?php }
            }
        }
        ?>


    </tbody>
</table>