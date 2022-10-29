<div class="custom-scroll appendAjaxTbl data-background" id="tablegh">
    <table class="table table-striped jambo_table bulk_action" id="example" style="width:100%;">
        <thead>
            <thead>
                <tr class="headings">
                    <th class="">S.No.</th>
                    <th class="">Event Name</th>
                    <th class="">Market</th>
                    <th class="">P_L</th>
                    <th class="">Commission</th>
                    <th class="">Created On</th>
                    <th class="">Action</th>
                </tr>
            </thead>
        <tbody>
            <?php
            $total_pl = $total_commission = 0;
            $i = 1;

             if (!empty($reports)) {


                foreach ($reports as $report) {

                    if ($report['match_id'] != $event_id) {
                        continue;
                    }

                    $user_type = $_SESSION['my_userdata']['user_type'];
                    if ($user_type == 'User') {
                        // $comm= get_commission($report['master_id'],'Master');
                        $comm = 0;
                    }
                    if ($user_type == 'Master') {
                        // $comm= get_commission($report['master_id'],'Super Master');
                        $comm = 0;
                    }
                    if ($user_type == 'Super Master') {
                        // $comm=  get_commission($report['master_id'],'Hyper Super Master');
                        $comm = 0;
                    }
                    if ($user_type == 'Hyper Super Master') {
                        // $comm=  get_commission($report['master_id'],'Admin');
                        $comm = 0;
                    }
                    if ($user_type == 'Admin') {
                        // $comm=  get_commission($report['master_id'],'Operator');
                        $comm = 0;
                    }
                    if ($user_type == 'Operator') {
                        // $comm=  get_commission($report['master_id'],'Operator');
                        $comm = 0;
                    }
                    if ($user_type == 'Super Admin') {
                        // $comm=  get_commission($report['master_id'],'Super Admin');
                        $comm = 0;
                    }
                    //    $commission=(($comm->master_commision)*$report['p_l'])/100;
                    // $commission = 0;

                     $commission =  $report['comm_pl'];

 
            ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php echo  base_url() ?>profitloss/bethistory/<?php echo $report['match_id']; ?>/<?php echo !empty($report['market_id']) ? $report['market_id'] : 'F'; ?>/<?php echo $user_id; ?>/<?php if ($report['market_name'] == 'Fancy') {
                                                                                                                                                                                        echo 'Yes';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo 'No';
                                                                                                                                                                                    }; ?>"><?php echo $report['event_name'] ?></a></td>
                        <td><?php echo $report['market_name']; ?></td>
                        <td><?php echo $report['p_l']; ?></td>
                        <td><?php echo $commission ?></td>
                        <td><?php echo $report['created_at']; ?></td>
                        <td><a href="<?php echo  base_url() ?>profitloss/bethistory/<?php echo $report['match_id']; ?>/<?php echo !empty($report['market_id']) ? $report['market_id'] : 'F'; ?>/<?php echo $user_id; ?>/<?php if ($report['market_name'] == 'Fancy') {
                                                                                                                                                                                        echo 'Yes';
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo 'No';
                                                                                                                                                                                    }; ?>">Show Bet</a></td>

                    </tr>
            <?php

                    $total_pl += $report['p_l'];
                    $total_commission += $commission;
                }
            }
            ?>
        </tbody>
    </table>
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class=" ">
                <th class="">(Total P &amp; L ) <?php echo $total_pl; ?></th>
                <th class="">(Total Commition) <?php echo $total_commission; ?></th>
            </tr>

        </thead>
    </table>
    <p>Showing <?php echo $i - 1; ?> of <?php echo $i - 1; ?> entries </p>
</div>