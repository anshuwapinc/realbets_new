<div class="custom-scroll appendAjaxTbl data-background" id="tablegh">
    <table class="table table-striped jambo_table bulk_action" id="example" style="width:100%;">
        <thead>
            <thead>
                <tr class="headings">
                    <th class="">Date </th>
                    <th class="">Title </th>
                    <th class="">Win  </th>
                    <th class="">Loss </th>
                    <th class=""> </th>

                </tr>
            </thead>
        <tbody>
            <?php
            $total_pl = $total_commission = 0;
            $i = 1;

            if (!empty($reports)) {

                

            
                // p($reports);
                $tmpReport = $reports;
                // p($reports);
                // foreach ($reports as $report) {

                //     $event_id = $report['match_id'];

                //     if (isset($tmpReport[$event_id])) {
                //         $tmpReport[$event_id]['p_l'] += $report["p_l"];
                //     } else {
                //         $tmpReport[$event_id] = $report;
                //     }
                // }

                // p($tmpReport);

                foreach ($tmpReport as $report) {


                    if($report['is_casino'] == 'Yes')
                    {
                        $user_id_url =  $user_id != $_SESSION['my_userdata']['user_id'] ? '/' . $user_id : '/'.$_SESSION['my_userdata']['user_id'];

                        $user_id_url .= '/'.$report['market_id'];

                    }
                    else{
                        $user_id_url =  $user_id != $_SESSION['my_userdata']['user_id'] ? '/' . $user_id : '/'.$_SESSION['my_userdata']['user_id'];

                    }
                  
                    $user_type = $_SESSION['my_userdata']['user_type'];
                    if ($user_type == 'User') {
                        // $comm= get_commission($report['master_id'],'Master');
                        $comm = 0;
                    }
                    if ($user_type == 'Master') {
                        $comm = get_commission($report['master_id'], 'Super Master');
                    }
                    if ($user_type == 'Super Master') {
                        $comm =  get_commission($report['master_id'], 'Hyper Super Master');
                    }
                    if ($user_type == 'Hyper Super Master') {
                        $comm =  get_commission($report['master_id'], 'Admin');
                    }
                    if ($user_type == 'Admin') {
                        $comm =  get_commission($report['master_id'], 'Operator');
                    }
                    if ($user_type == 'Operator') {
                        $comm =  get_commission($report['master_id'], 'Operator');
                    }
                    if ($user_type == 'Super Admin') {
                        $comm =  get_commission($report['master_id'], 'Super Admin');
                    }

                    // $commission=(($comm->master_commision)*$report['p_l'])/100;
                    $commission =  $report['comm_pl'];
            ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($report['created_at'])); ?></td>

                        <td>

                        
 <a href="<?php echo  base_url() ?>admin/Reports/profitLossDetail/<?php echo $report['match_id'] . $user_id_url; ?>">
                            <?php echo $report['event_name'] ?>
                            </a>
                           
                           

                        </td>
                        <?php
                        if ($report['p_l'] > 0) { ?>
                            <td class="text-green"><?php
                                                    echo $report['p_l']; ?></td>
                        <?php  } else { ?>
                            <td class="text-green"><?php
                                                    echo 0; ?></td>
                        <?php }; ?>

                        <?php
                        if ($report['p_l'] < 0) { ?>
                            <td class="text-red"><?php
                                                    echo $report['p_l']; ?></td>
                        <?php  } else { ?>
                            <td class="text-red"><?php
                                                    echo 0; ?></td>
                        <?php }; ?>

                        <td><a href="<?php echo  base_url() ?>admin/Reports/profitLossDetail/<?php echo $report['match_id'] . $user_id_url; ?>">Show</a></td>

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
        <!-- <thead>
            <tr class=" ">
                <th class="">(Total P &amp; L ) <?php echo $total_pl; ?></th>
                <th class="">(Total Commition) <?php echo $total_commission; ?></th>
            </tr>

        </thead> -->
        <thead>
            <tr class=" ">
                <th colspan="4" style="text-align:right;font-weight:bold;">Total: <?php
                                                                                    if ($total_pl > 0) { ?>
                        <span class="text-green"><?php echo $total_pl; ?></span>
                    <?php } else { ?>
                        <span class="text-red"><?php echo $total_pl; ?></span>

                    <?php } ?>
                </th>
            </tr>

        </thead>
    </table>
 </div>