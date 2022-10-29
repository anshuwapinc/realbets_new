<style>
    #nested_th {
        font-size: 10px;
    }
</style>
<table class="table table-striped table-bordered " style="text-align:center;width:100%" role="grid" aria-describedby="example_info" id="example" style="width:100%;">
    <thead>
        <tr>
            <th style="width: 126px;" rowspan="2">Sr no.</th>
            <?php

            if (get_user_type() != "User") {
            ?>
                <th style="width: 126px;" rowspan="2">User Id</th>
            <?php
            }
            ?>
            <?php
            if ($payment_type == 'All' || empty($payment_type)) {
            ?>
                <th style="width: 126px;" rowspan="2">Payment type</th>
            <?php
            }

            if ($payment_type == 'Withdraw') {
                $payment_via_colspan = "3";
            } else {
                $payment_via_colspan = "5";
            }
            ?>
            <th style="width: 126px;" colspan="<?php echo $payment_via_colspan ?>">Payment Via</th>
            <th style="width: 126px;" rowspan="2">Amount</th>
            <?php
            if ($payment_type != 'Withdraw') {
            ?>
                <th style="width: 126px;" rowspan="2">Reference Code</th>
            <?php
            }
            ?>
            <th style="width: 126px;" rowspan="2">Remark</th>
            <th style="width: 126px;" rowspan="2">Date</th>
            <?php
            if ($status == 'All') {
            ?>
                <th style="width: 592px;" rowspan="2">Status</th>
            <?php
            }
            ?>
        </tr>
        <tr id="nested_th">
            <th>Type</th>
            <?php
            if ($payment_type != 'Withdraw') {
            ?>
                <th>Bank Name</th>
            <?php
            }
            ?>
            <th>Account No./ID</th>

            <th>Account Holder Name</th>
            <?php
            if ($payment_type != 'Withdraw') {
            ?>
                <th>IFSC Code</th>
            <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php

        if (!empty($transaction_data)) {
            $i = 1;
            foreach ($transaction_data as $row) {
        ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <?php

                    if (get_user_type() != "User") {
                    ?>
                        <td>
                            <?php
                            echo  $row['user_id'];
                            ?>
                        </td>
                    <?php
                    }

                    ?>
                    <?php
                    if ($payment_type == 'All' || empty($payment_type)) {
                    ?>
                        <td><?php echo $row['payment_type'] ?></td>
                    <?php
                    }
                    ?>
                    <td><?php echo empty($row['type']) ? "-" : $row['type']  ?></td>
                    <?php
                    if ($payment_type != 'Withdraw') {
                    ?>
                        <td><?php echo empty($row['bank_name']) ? "-" : $row['bank_name']  ?></td>
                    <?php }
                    ?>

                    <td><?php echo empty($row['account_no']) ? "-" : $row['account_no']  ?> </td>

                    <td><?php

                        echo empty($row['account_holder_name']) ? "-" : $row['account_holder_name'];

                        ?></td>

                    <?php
                    if ($payment_type != 'Withdraw') {
                    ?>
                        <td><?php echo empty($row['ifsc_code']) ? "-" : $row['ifsc_code']  ?> </td>
                    <?php }
                    ?>
                    <td><?php echo $row['amount'] ?></td>
                    <?php
                    if ($payment_type != 'Withdraw') {
                    ?>
                        <td><?php echo empty($row['reference_code']) ? "-" : $row['reference_code'] ?></td>
                    <?php
                    }
                    ?>
                    <td><?php echo $row['remark'] ?></td>
                    <td><?php echo $row['created_at'] ?></td>
                    <?php
                    if ($status == 'All') {
                    ?>
                        <td>
                            <?php
                            if ($row['status'] == "Request" && $payment_type == 'Withdraw') {
                                echo $row['status']
                            ?>
                                <a class="btn btn-danger btn-xs" href="cancel-withdraw-request-status/<?php echo $row['id'] ?>" title="Reject" style="margin-left:15px">Cancel</a>
                            <?php
                            } else {
                                echo $row['status'];
                            }
                            ?>

                        <?php }
                        ?>
                </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="12" style="border:none">No record found! </td></tr>';
        }
        ?>
    </tbody>
</table>