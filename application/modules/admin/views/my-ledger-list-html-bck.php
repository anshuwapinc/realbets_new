<?php
 $total_pl = $total_commission = 0;
 $i = 1;

 $total_dena = 0;
 $total_lena = 0;

 $total_dena_lena = 0;
 if (!empty($reports)) {

     $user_id_url =  $user_id != $_SESSION['my_userdata']['user_id'] ? '/' . $user_id : null;
     // p($reports);
     $tmpReport = array();
     // p($reports);
     foreach ($reports as $report) {

         $event_id = $report['match_id'];

         if (isset($tmpReport[$event_id])) {
             $tmpReport[$event_id]['p_l'] += $report["p_l"];
         } else {
             $tmpReport[$event_id] = $report;
         }
     }
    }


    foreach ($tmpReport as $report) {

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

        $total_balance = 0;
        // p($report['p_l']);
        if ($report['p_l'] > 0) {
            $total_dena += abs($report['p_l']);
        } else {
            $total_lena += abs($report['p_l']);

        }


    }


?>
<div class="custom-scroll appendAjaxTbl data-background" id="tablegh">
<form method="get" id="formSubmit" class="form-horizontal form-label-left input_mask">
                <div class="col-md-4 col-xs-12 text-center">
                    <!-- <input type="text" name="from_date" value="<?php echo date('Y-m-d') ?>" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="From date" autocomplete="off"> -->
                <span class="text-green lena-dena">Lena : <?php echo number_format($total_lena,2); ?></span>
                </div>
                <div class="col-md-4 col-xs-12 text-center ">
                <span class="text-red lena-dena">Dena : <?php echo number_format($total_dena,2); ?></span>

                    <!-- <input type="text" name="to_date" value="<?php echo date('Y-m-d') ?>" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="To date" autocomplete="off"> -->
                </div>
                <div class="col-md-4 col-xs-12 text-center">

                <?php

        if($total_lena >= $total_dena)
        { ?>
                <span class="text-green lena-dena">Balance: <?php echo number_format($total_lena - $total_dena,2); ?> ( Lena)</span>

       <?php }
       else
       { ?>
                <span class="text-red lena-dena">Balance: <?php echo number_format($total_dena - $total_lena,2); ?> ( Dena)</span>

      <?php }
?>

                    <!-- <input type="hidden" name="user_id" value="47978">
                    <input type="hidden" name="perpage" id="perpage" value="10">
                    <select class="form-control" name="sportid" id="sportid">
                        <option value="5" selected="">All</option>
                        <option value="4">Cricket</option>
                        <option value="1">Soccer</option>
                        <option value="2">Tennis</option>
                        <option value="11">Live teenpatti</option>
                        <option value="12">Live Casino</option>
                        <option value="13">Live Game</option>
                        <option value="0" <?php echo empty($sportid) ? null : ($sportid == 0 && $sportid != null ? 'selected' : NULL) ?>>Fancy</option>
                    </select> -->
                </div>

               
            </form>    
<table class="table table-striped jambo_table bulk_action" id="example" style="width:100%;">
        <thead>
            <thead>
                <tr class="headings">
                    <th class="">Date </th>
                    <th class="">Collection Name </th>
                    <th class="">Dena </th>
                    <th class="">Lena </th>
                    <th class="">Blanace </th>
                    <th class="">Payment Type </th>
                    <th class="">Remark </th>
                </tr>
            </thead>
        <tbody>
            <?php
           if(!empty($tmpReport)){

                // p($tmpReport);

                foreach ($tmpReport as $report) {

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

                    $total_balance = 0;
                   
                    if ($report['p_l'] > 0) {
                        $total_balance -= $report['p_l'];
                    } else {
                        $total_balance += $report['p_l'];

                    }

            ?>
                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($report['created_at'])); ?></td>
                        <td></td>

                        <td>
                            <?php

                            if ($report['p_l'] > 0) {
                                echo abs($report['p_l']);
                            } else {
                                echo 0;
                            }
                            ?>

                        </td>
                        <td>
                            <?php
                            if ($report['p_l'] < 0) {
                                echo abs($report['p_l']);
                            } else {
                                echo 0;
                            }
                            ?>
                        </td>
                        <td><?php echo abs($total_balance); ?></td>
                        <td>
                            <!-- <a href="<?php echo  base_url() ?>admin/Reports/profitLossDetail/<?php echo $report['match_id'] . $user_id_url; ?>"> -->
                            <?php echo $report['event_name'] ?>
                            <!-- </a> -->

                        </td>
                        <td>

                            <?php

                            if ($report['p_l'] > 0) {
                                echo 'Master minus';
                            } else {
                                echo 'Master plus';
                            }
                            ?>

                        </td>


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
                <th colspan="4" style="text-align:right;font-weight:bold;">Total: 
                <?php

if($total_lena >= $total_dena)
{ ?>
        <span class="text-green  "> <?php echo number_format($total_lena - $total_dena,2); ?> </span>

<?php }
else
{ ?>
        <span class="text-red  "> <?php echo number_format($total_dena - $total_lena,2); ?></span>

<?php }
?>
               
                </th>
            </tr>

        </thead>
    </table>
</div>