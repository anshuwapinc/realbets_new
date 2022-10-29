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
<div class="custom-scroll appendAjaxTbl">
    <h5>Filter criteria : From <span
                class="span-from"><?php echo empty($fromDate) ? date('Y-m-d h:m:s') : $fromDate ?></span> To <span
                class="span-to"><?php echo empty($toDate) ? date('Y-m-d h:m:s') : $toDate ?></span>
        <table class="table table-striped jambo_table bulk_action" id="example">
            <thead>
            <tr class="headings">
            <tr class="headings">
                <th width="2%">S.No.</th>
                <th>
                    Dealer
                </th>
                <th>Cricket</th>
                <th>Tennis</th>
                <th>Soccer</th>
                <th>Fancy</th>
                <th>Total Userpl</th>
                <th>Live Teenpatti</th>
                <th>Casino</th>
                <th>Live game</th>
                <th>Casino</th>
            </tr>
            </tr>
            </thead>
            <tbody>
            <?php
            $totalc = 0;
            $totalt = 0;
            $totals = 0;
            $totalf = 0;
            $totalall = 0;
            $totalteen = 0;
            $totalg = 0;
            $totalcash = 0;
            $totalsport=0;
            $totaloutcount=0;
            $totalsportcount=0;
            $i = 1;
            if (!empty($reports[0]['betting_id'])) {

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
                
            $user_type= $_SESSION['my_userdata']['user_type'];
            if($user_type=='Master') {
                $outresult= $master_pl;
            }
            if($user_type=='Super Master') {
                $outresult=  $super_master_pl;
            }
            if($user_type=='Hyper Super Master') {
                $outresult=  $hyper_super_master_pl;
            }
                    $cricket = $fan['event_type'] == 4 ? $pl : '0:00';
                    $tenis = $fan['event_type'] == 2 ? $pl : '0:00';
                    $soccer = $fan['event_type'] == 1 ? $pl : '0:00';
                    $fancy = $fan['event_type'] == 8 ? $pl : '0:00';
                    $live_game = $fan['event_type'] == 5 ? $pl : '0:00';
                    $live_teenpatti = $fan['event_type'] == 6 ? $pl : '0:00';
                    $casino = $fan['event_type'] == 7 ? $pl : '0:00';
                    $totalsport += $cricket + $tenis + $soccer + $fancy;
                    $totaloutcount+=$outresult;
                    ?>


                    <tr class=" content_user_table ">
                        <td><?php echo $i ?></td>
                        <td class=" ">
                            <span class="user"><?php echo $fan['name'] . '-' . $fan['user_name'] ?></span></td>
                        <td class=" ">
                            <span class="<?php echo check_if_negative($cricket=='0:00'? '0:00': $outresult) ?>"><?php echo $cricket=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($cricket) ?>"><?php echo $cricket ?></span>)</td>
                        <td class=" ">
                             <span class="<?php echo check_if_negative($tenis=='0:00'? '0:00': $outresult) ?>"><?php echo $tenis=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($tenis) ?>"><?php echo '' ?></span>)</td>

                        <td class=" ">
                             <span class="<?php echo check_if_negative($soccer=='0:00'? '0:00': $outresult) ?>"><?php echo $soccer=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($soccer) ?>"><?php echo '' ?></span>)</td>
                        <td class=" ">
                           <span class="<?php echo check_if_negative($fancy=='0:00'? '0:00': $outresult) ?>"><?php echo $fancy=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($fancy) ?>"><?php echo '' ?></span>)</td>
                        <td class=" ">
                             <span class="<?php echo check_if_negative($totaloutcount=='0:00'? '0:00': $totaloutcount) ?>"><?php echo $totaloutcount=='0:00'? '0:00': $totaloutcount  ?></span>(
                            <span class="<?php echo check_if_negative($totalsport) ?>"><?php echo $totalsport ?></span>)</td>
                        <td class=" ">
                             <span class="<?php echo check_if_negative($live_teenpatti=='0:00'? '0:00': $outresult) ?>"><?php echo $live_teenpatti=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($live_teenpatti) ?>"><?php echo '' ?></span>)</td>
                        <td class=" ">
                              <span class="<?php echo check_if_negative($casino=='0:00'? '0:00': $outresult) ?>"><?php echo $casino=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($casino) ?>"><?php echo $casino ?></span>)</td>
                        <td class=" ">
                         <span class="<?php echo check_if_negative($live_game=='0:00'? '0:00': $outresult) ?>"><?php echo $live_game=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($live_game) ?>"><?php echo $live_game ?></span>)</td>
                        <td class=" ">
                           <span class="<?php echo check_if_negative($casino=='0:00'? '0:00': $outresult) ?>"><?php echo $casino=='0:00'? '0:00': $outresult  ?></span>(
                            <span class="<?php echo check_if_negative($casino) ?>"><?php echo $casino ?></span>)</td>


                    </tr>

                    <?php
                    $i++;
                    $totalc += $cricket;
                    $totalt += $tenis;
                    $totals += $soccer;
                    $totalf += $fancy;
                    $totalall += $totalsport;
                    $totalteen += $live_teenpatti;
                    $totalg += $live_game;
                    $totalcash += $casino;
                    $totalsportcount+=$totalsport;
                    
                }
            
            ?>

            </tbody>
            <tfoot>
            <tr class=" content_user_table ">
                <td colspan="2">Total</td>
                <td class=" ">
                    <span class="<?php echo check_if_negative($totaloutcount) ?>"><?php echo $totaloutcount ?></span>(
                    <span class="<?php echo check_if_negative($totalc) ?>"><?php echo $totalc ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalt) ?>"><?php echo $totalt  ?></span>(
                    <span class="<?php echo check_if_negative($totalt) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totals) ?>"><?php echo $totals  ?></span>(
                    <span class="<?php echo check_if_negative($totals) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalf) ?>"><?php echo $totalf  ?></span>(
                    <span class="<?php echo check_if_negative($totalf) ?>"><?php echo '' ?></span>)</td>


                <td class=" ">
                    <span class="<?php echo check_if_negative($totalall) ?>"><?php echo $totalall  ?></span>(
                    <span class="<?php echo check_if_negative($totalall) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalteen) ?>"><?php echo $totalteen . '' ?></span>(
                    <span class="<?php echo check_if_negative($totalteen) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalcash) ?>"><?php echo $totalcash  ?></span>(
                    <span class="<?php echo check_if_negative($totalcash) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalg) ?>"><?php echo $totalg  ?></span>(
                    <span class="<?php echo check_if_negative($totalg) ?>"><?php echo '' ?></span>)</td>

                <td class=" ">
                    <span class="<?php echo check_if_negative($totalcash) ?>"><?php echo $totalcash  ?></span>(
                    <span class="<?php echo check_if_negative($totalcash) ?>"><?php echo '' ?></span>)</td>

            </tr>
            </tfoot>
            <?php
        } ?>
        </table>
</div>

<script>
  $(document).ready(function () {
        $('#example').DataTable();
    });
</script>