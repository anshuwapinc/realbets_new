<?php
$total_pl = $total_commission = 0;
$i = 1;

if (!empty($reports)) {

    $user_id_url =  $user_id != $_SESSION['my_userdata']['user_id'] ? '/' . $user_id : null;
    // p($reports);
    $tmpReport = array();
    // p($reports);
    $total_balance = 0;
    $total_dena = 0;
    $total_lena = 0;

 
    
 

 
    foreach ($reports as $report) {
        $event_id = $report['match_id'];


        if(isset($report['type']) && $report['type'] == 'Settlement')
        {
            $tmpReport[] = array(
                'type' => $report['type'],
                'remarks' => $report['remarks'],
                'transaction_type' => $report['transaction_type'],
                'amount' => $report['amount'],
                'done_by' => $report['done_by'],
                'created_at' => $report['created_at'],
                'settlemment_ref_id' => $report['settlemment_ref_id'],
                'role' => $report['role'],
                'created_at' => $report['created_at']


            );


            // p($report);
            if($report['role'] == 'Parent')
            {
         
                 if($report['transaction_type'] == 'Debit')
                 {
                     $total_dena -= abs($report['amount']);
                 }
                 
                 else
                 {
                    $total_lena -= abs($report['amount']);
    
                 }
                }
           
        }
        else
        {   
            $pl =  $report['p_l'];

            if($report['user_type'] != 'User')
            {
                $pl = $pl * -1;
            }



            $tmpReport[] = array(
                'type' => '',
                'event_name' => $report['event_name'],
                'p_l' => $pl ,
                'created_at' => $report['created_at']

            );



            if($report['user_type'] == 'User')
            {

                  if($report['p_l'] > 0)
                 {
                     $total_dena += abs($report['p_l']);
                 }
                 
                 else
                 {
                    $total_lena += abs($report['p_l']);
    
                 }
            }
            else
            {
                if($report['p_l'] > 0)
                {
                    $total_lena += abs($report['p_l']);
                }
                else
                {
                   $total_dena += abs($report['p_l']);
    
                }
            }
        }
        

       


        // if (isset($report['type']) && $report['type'] == 'Settlement') {

        //     if ($report['role'] != 'Self') {
        //         if ($report['transaction_type'] == 'Credit') {

        //             if($total_lena > $total_dena)
        //             {
        //                 $total_lena -= abs($report['amount']);

        //             }
        //             else
        //             {
        //             $total_dena -= abs($report['amount']);

        //             }
  
        //         } else if ($report['transaction_type'] == 'Debit') {
                    
        //             $total_dena += abs($report['amount']);


                   
        //         }
        //     }
        // }
    }
}
?>

<div>
    <div class="row">
        <div class="col-md-3">
            <h3 style="padding: 20px; color: rgb(51, 181, 28);">Lena : <?php echo $total_lena; ?></h3>

        </div>

        <div class="col-md-3">
            <h3 style="padding: 20px; color: rgb(214, 75, 75);">Dena : <?php echo $total_dena; ?></h3>

        </div>

        <div class="col-md-4">

            <?php

            $total_amt = abs($total_lena) - abs($total_dena);
            if ($total_amt > 0) {
                echo '<h3 style="padding: 20px;color: green;">Balance:' . (abs($total_amt)) . " (Lena) </h3>";
            } else if ($total_amt < 0) {
                echo  '<h3 style="padding: 20px;color: red;">Balance:' . (abs($total_amt)) . " (Dena)  </h3>";
            } else {
                echo  '<h3 style="padding: 20px;color: green;">Balance:' . (abs($total_amt)) . " </h3>";
            }
            ?>

        </div>
        <div class="col-md-2" style="padding-top: 40px;">
            <!-- <button type="button" class="btn btn-info pull-right"><span>Deleted</span></button> -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="overflow-x:scroll;">
            <table class="table tbale-bordered">
                <thead>
                    <th>#</th>
                    <th>Date</th>
                    <th>Post Date</th>
                    <th>Collection Name </th>
                    <th>Debit </th>
                    <th>Credit </th>
                    <th>Balance </th>
                    <th>Payment Type </th>
                    <th>Remark </th>
                    <th>Done By </th>
                </thead>
                <tbody>
                    <?php





                    foreach ($tmpReport as $report) {

                        $user_type = $_SESSION['my_userdata']['user_type'];
                     
                        $commission = 0;


                        if (isset($report['type']) && $report['type'] == 'Settlement') {
                            if ($report['role'] == 'Self') {
                                continue;
                            }
                        }

                    ?>
                        <tr>
                            <td>

                                <?php

                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    if (!empty($report['settlemment_ref_id'])) {
                                        if ($report['role'] != 'Self') {
                                ?>
                                            <a href="javscript:void(0);" onclick="deleteSettlementEntry('<?php echo $report['settlemment_ref_id']; ?>')"><i class="fa fa-trash"></i></a>

                                <?php }
                                    }
                                } ?>
                            </td>
                            <td>
                             <?php echo date('d M h:i:s a', strtotime($report['created_at'])); ?></td>
                            <td><?php echo date('d M h:i:s a', strtotime($report['created_at'])); ?></td>
                            <td>

                                <?php
                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    echo 'CASH';
                                }
                                ?>
                            </td>
                            <td>
                                <?php

                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    if ($report['transaction_type'] == 'Debit') {
                                        echo abs($report['amount']);
                                    } else {
                                        echo 0;
                                    }
                                } else {
                                    if ($report['p_l'] < 0) {
                                        echo abs($report['p_l']);
                                    } else {
                                        echo 0;
                                    }
                                }

                                ?>

                            </td>
                            <td>
                                <?php
                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    if ($report['transaction_type'] == 'Credit') {
                                        echo abs($report['amount']);
                                    } else {
                                        echo 0;
                                    }
                                } else {
                                    if ($report['p_l'] > 0) {
                                        echo abs($report['p_l']);
                                    } else {
                                        echo 0;
                                    }
                                }

                                ?>
                            </td>
                            <td><?php
                                echo 0;

                              
                                ?></td>
                            <td>
                                <!-- <a href="<?php echo  base_url() ?>admin/Reports/profitLossDetail/<?php echo $report['match_id'] . $user_id_url; ?>"> -->
                                <?php echo $report['event_name'] ?>
                                <!-- </a> -->

                            </td>
                            <td>
                                <?php
                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    echo $report['remarks'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($report['type']) && $report['type'] == 'Settlement') {
                                    echo $report['done_by'];
                                }
                                ?>
                            </td>
                        </tr>
                    <?php

                        $total_pl += $report['p_l'];
                        $total_commission += $commission;
                    }

                    ?>

                </tbody>
            </table>
        </div>

    </div>


</div>