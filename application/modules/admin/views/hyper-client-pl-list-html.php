<style>
    .user {
        color: #4083A9;
    }

    .postive {
        color: #3c763d;
    }

    .negative {
        color: #a94442;
    }
</style>

<div class="custom-scroll appendAjaxTbl table-responsive">
    <table class="table table-striped jambo_table bulk_action" id="example">
        <thead>
            <tr class="headings">
                <th class="">Username</th>
                <th class="">Super Admin</th>

                <th class="">Admin</th>

                <th class="">Super Master</th>
                <th class="">Master</th>
                <th class="">Total</th>
                <th class="">Amount</th>
                <th class="">M-comm</th>
                <th class="">S-comm</th>
                <th class="">Net-Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $total_hsp = 0;

            $total_super_admin  = 0;

            $total_sub_admin  = 0;
           $total_master_agent  = 0;
           $total_super_agent  = 0;
           $total_agent  = 0;
           $total_amount  = 0;

            if (!empty($reports)) {



                foreach ($reports as $report) {

                    $admin_pl = $report['admin_pl'];

                    $hyper_super_master_pl = $report['hyper_super_master_pl'];

                    $super_master_pl = $report['super_master_pl'];

                    $master_pl = $report['master_pl'];
                    $user_pl = $report['user_pl'];

                    $total_sub_admin  += $admin_pl;
                    $total_master_agent  += $hyper_super_master_pl;
                    $total_super_agent  += $super_master_pl;
                    $total_agent  += $master_pl;
                    $total_amount  += $user_pl;

            ?>

                    <tr class=" content_user_table ">
                        <td><a href="<?php echo base_url(); ?>clientpl/<?php echo $report['user_id'] ?>"><?php echo $report['user_name'] ?></a></td>
                        <td>
                            <span><?php echo $admin_pl; ?></span>
                        </td>
                        <td>
                            <span><?php echo $hyper_super_master_pl; ?></span>
                        </td>
                        <td>
                            <span><?php echo $super_master_pl; ?></span>
                        </td>
                        <td>
                            <span><?php echo $master_pl ?></span>
                        </td>

                        <td>
                            <span><?php echo $user_pl ?></span>
                        </td>
                        <td>
                            <span>0.00</span>
                        </td>
                        <td>
                            <span>0.00</span>

                        </td>
                        <td>
                            <span>0.00</span>

                        </td>
                        <td>
                            <span>0.00</span>

                        </td>


                    </tr>


                <?php } ?>
        </tbody>
        <tfoot>
            <tr class=" content_user_table ">
                <th><strong>Total</strong></th>
                 
                <th>
                    <?php echo number_format($total_sub_admin, 2); ?>
                </th>
                <th>
                    <?php echo number_format($total_master_agent, 2); ?>
                </th>
                <th>
                    <?php echo number_format($total_super_agent, 2); ?>
                </th>
                <th>
                    <?php echo number_format($total_agent, 2); ?>

                </th>

                <th>
                    <?php echo number_format($total_amount, 2); ?>

                </th>
                <th>
                    0.00
                </th>
                <th>
                    0.00

                </th>
                <th>
                    0.00
                </th>
                <th>
                    0.00

                </th>


            </tr>
        </tfoot>
    <?php
            } ?>
</div>

<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>