<style>

    .user {
        color: #4083A9;
    }
    .postive{
        color: #3c763d;
    }
    .negative{
        color: #a94442;
    }
</style>

<div class="custom-scroll appendAjaxTbl">
    <table class="table table-striped jambo_table bulk_action" id="example">
        <thead>
        <tr class="headings">
            <th class="">Date</th>
            <th class="">Market</th>
            <th class="">Hyper</th>
            <th class="">Super Master</th>
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
        $total_supermaster = 0;
        $total = 0;
        $totalamount = 0;
        $netamount = 0;
        $user_pl = 0;
        $total_m_comm = 0;
        $total_s_comm = 0;
        if (!empty($reports[0]['master_id'])) {

        foreach ($reports as $fan) {
             $pl = get_betting_result_chips($fan['user_id']);
             $operator_count= count_operator_pl($fan['master_id'],$pl);
             $admin_count=count_hyper_master_pl($fan['master_id'],$operator_count);
             $hyper_master_count=count_hyper_master_pl($fan['master_id'],$admin_count);
             $super_master_count=count_super_master_pl($fan['master_id'],$hyper_master_count); 
             $master_count=count_master_pl($fan['master_id'],$super_master_count); 
             $usercount=($master_count*$fan['partnership'])/100;
             
             $hyper_super_master_pl=$hyper_master_count-$super_master_count;
             $super_master_pl=$super_master_count-$master_count;
             $master_pl  = $master_count-$usercount;
            ?>

            <tr class=" content_user_table ">
                <td><span class="user"><?php echo $fan['created_at'] ?></span></td>
                <td>
                    <span class="user"><?php echo $fan['name'] . '/' . $fan['competition_name'] . '/' . $fan['event_name'] . '/' . $fan['market_name'] ?></span><span><?php echo ', Winner: ' . $fan['winner_name'] ?></span>
                </td>
                 <td>
                    <span
                        class="<?php echo check_if_negative($hyper_super_master_pl) ?>"><?php echo $hyper_super_master_pl ?></span>
                </td>
                <td>
                    <span
                        class="<?php echo check_if_negative($super_master_pl) ?>"><?php echo $super_master_pl ?></span>
                </td>
                 <td>
                    <span
                        class="<?php echo check_if_negative($super_master_pl +$hyper_super_master_pl) ?>"><?php echo $super_master_pl +$hyper_super_master_pl ?></span>
                </td>
                <td>
                    <span
                        class="<?php echo check_if_negative($super_master_pl) ?>"><?php echo $super_master_pl ?></span>
                </td>
                <td>
                    <span style="<?php echo check_if_negative($fan['master_commision']) ?>"><?php echo $fan['master_commision'] ?></span>
                </td>
                <td>
                    <span style="<?php echo check_if_negative($fan['sessional_commision']) ?>"><?php echo $fan['sessional_commision'] ?></span>
                </td>

                <td>
                    <span
                        class="<?php echo check_if_negative($super_master_pl) ?>"><?php echo $super_master_pl ?></span>
                </td>


            </tr>


            <?php
            $total_supermaster += $super_master_pl;
            $total_hsp += $hyper_super_master_pl;
            $total += $super_master_pl + $hyper_super_master_pl;
            $totalamount += $super_master_pl;
            $netamount +=$super_master_pl;
            $user_pl += $pl - $super_master_pl + $hyper_super_master_pl;
            $total_m_comm += $fan['master_commision'];
            $total_s_comm += $fan['sessional_commision'];
        } ?>
        </tbody>
        <tfoot>
        <tr class=" content_user_table ">
            <td colspan="2">Total</td>
            <td>
                <span class="<?php echo check_if_negative($total_hsp) ?>"><?php echo $total_hsp ?></span>
            </td>
            <td>
                            <span class="<?php echo check_if_negative($total_supermaster) ?>">
            <?php echo $total_supermaster ?></span>
            </td>
            <td>
                <span class="<?php echo check_if_negative($total) ?>"><?php echo $total ?></span>
            </td>
            <td>
                <span class="<?php echo check_if_negative($totalamount) ?>"><?php echo $totalamount ?></span>
            </td>

            <td>
                <span class="<?php echo check_if_negative($total_m_comm) ?>"><?php echo $total_m_comm ?></span>
            </td>
            <td>
                <span class="<?php echo check_if_negative($total_s_comm) ?>"><?php echo $total_s_comm ?></span>
            </td>

            <td>
                <span class="<?php echo check_if_negative($netamount) ?>"><?php echo $netamount ?></span>
            </td>
        </tr>
        </tfoot>
        <?php
        } ?>
</div>

<script>
  $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
