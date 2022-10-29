<table class="table table-striped">
    <thead>
        <tr>
            <th>S. No.</td>
            <td>Round Id</td>
            <td>Status</td>

        </tr>
    </thead>
    <tbody>


        <?php 
         if (!empty($settledBets)) {
            $i = 0;

            foreach ($settledBets as $value) {
                $status = '';

                if ($value['ledger_id']) {
                    $status = 'Success';
                } else {
                    $status = 'Failed';
                }
                $i++;
        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $value['betting_id']; ?></td>
                    <td><?php if ($status == 'Success') { ?>
                            <span class="badge badge-success" style="background-color:green;">Success</span>
                        <?php } else if ($status == 'Failed') { ?>
                            <span class="badge badge-danger" style="background-color:red;">Failed</span>
                        <?php } ?>
                    </td>

                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="3" style="text-align:center;color:red;font-weight:bold;">No Bets available for this entry.</td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>