<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="title_new_at"> Sport Details <small>Display Sport Details Like Match & Session Position etc.</small>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:scroll;">
            <?php
            // p($reports);
            // if(!empty($reports))
            // {
            //     foreach($reports as $report)
            //     {

            //     }
            // }
            ?>
            <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td width="60"><strong>SUPER AGENT </strong></td>
                        <td><strong><?php echo $reports->user_name; ?></strong></td>
                    </tr>

                    <tr>

                        <?php

                        if (!empty($reports->masters)) {
                            $masters = $reports->masters;
                            foreach ($masters as $master) { ?>
                    <tr>
                        <td colspan="2" height="25">

                            <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="60"><strong>AGENT </strong></td>
                                        <td><strong><?php echo $master->user_name; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="25">

                                            <!--CLIENT START HERE-->
                                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="table table-striped table-bordered" style="padding-bottom:100px;">
                                                <tbody>
                                                    <tr>


                                                        <td colspan="11" align="right" valign="middle" style="text-align:center;"><strong>AGENT PLUS MINUS</strong></td>
                                                        <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>SUPER AGENT PLUS MINUS</strong></td>

                                                    </tr>
                                                    <tr>
                                                        <td width="180" height="25" align="left" valign="middle"><strong>CLIENT</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>M AMT</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>SESS.</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>TOT. AMT</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>M. COM</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>S. COM</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>TOL. COM</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>NET AMT</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>SHR AMT</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>MOB. APP</strong></td>
                                                        <td width="100" align="right" style="text-align:right;" valign="middle"><strong>FINAL</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                        <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>

                                                    </tr>

                                                    <?php
                                                    $users = $reports->users;
                                                    $total_agent_match_amt = 0;
                                                    $total_agent_sess_amt = 0;
                                                    $total_agent_user_amt_and_comm = 0;
                                                    $total_agent_match_comm = 0;
                                                    $total_agent_session_comm = 0;
                                                    $total_agent_match_session_comm = 0;
                                                    $total_agent_net_amt = 0;
                                                    $total_agent_share_net_amt = 0;
                                                    $total_agent_final_net_amt = 0;


                                                    if (!empty($master->users)) {
                                                        $users = $master->users;

                                                        foreach ($users as $user) {


                                                            /**************AGENT MATCH COMM */
                                                            $agent_match_comm = 0;
                                                            $match_amt = $user->user['match_pl'];
                                                            $agent_match_comm_per =  $user->master['match_comm'];


                                                             if ($match_amt > 0) {
                                                                $agent_match_comm = (abs($match_amt) * $agent_match_comm_per) / 100;
                                                            }


                                                            // p($agent_match_comm);
                                                            /**************AGENT MATCH COMM */

                                                            /**************AGENT SESSION COMM */
                                                            $agent_session_comm = 0;
                                                            $session_amt = $user->user['session_pl'];
                                                            $agent_session_comm_per =  $user->master['sessional_commission'];

                                                            


                                                            if ($session_amt > 0) {
                                                                $agent_session_comm = (abs($session_amt) * $agent_session_comm_per) / 100;
                                                            }
                                                            /**************AGENT SESSION COMM */

                                                            $total_agent_comm = $agent_match_comm + $agent_session_comm;


                                                            $total_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                            $total_agent_amt_and_comm = $total_agent_amt - $total_agent_comm;

                                                            $total_agent_share_amt =  ($total_agent_amt_and_comm * $user->master['partnership']) / 100;

                                                            $agent_final_amt = $total_agent_amt_and_comm - $total_agent_share_amt;


                                                            /**************SUPER AGENT MATCH COMM */
                                                            $super_agent_match_comm = 0;
                                                            $match_amt = $user->user['match_pl'];
                                                            $super_agent_match_comm_per =  $user->super_master['match_comm'];


                                                             if ($match_amt > 0) {
                                                                $super_agent_match_comm = (abs($match_amt) * $super_agent_match_comm_per) / 100;
                                                            }


                                                            

                                                            // p($agent_match_comm);
                                                            /**************SUPER MATCH COMM */

                                                            /**************SUPER AGENT SESSION COMM */
                                                            $super_agent_session_comm = 0;
                                                            $session_amt = $user->user['session_pl'];
                                                            $super_agent_session_comm_per =  $user->super_master['sessional_commission'];


                                                            if ($session_amt > 0) {
                                                                $super_agent_session_comm_per = (abs($session_amt) * $super_agent_session_comm_per) / 100;
                                                            }
                                                            /**************SUPER AGENT SESSION COMM */


                                                            $total_super_agent_comm = $super_agent_match_comm + $super_agent_session_comm;

                                                            $total_super_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                             $total_super_agent_amt_and_comm = $total_super_agent_amt - $total_super_agent_comm;



                                                             $total_super_agent_share_amt =  ($total_super_agent_amt_and_comm * $user->super_master['partnership']) / 100;

                                                             $total_super_agent_final_amt = $total_super_agent_amt_and_comm - $total_super_agent_share_amt;

                                                            

                                                            // $total_user_amt =  $user->user['match_pl'] + $user->user['session_pl'];
                                                            // $total_user_comm =  $user->user['user_match_comm'] + $user->user['user_session_comm'];

                                                         
                                                         
                                                            $total_agent_match_amt += $user->user['match_pl'];
                                                            $total_agent_sess_amt += $user->user['session_pl'];
                                                            $total_agent_user_amt_and_comm  += $total_user_amt_and_comm;
                                                            $total_agent_match_comm += $user->user['user_match_comm'];
                                                            $total_agent_session_comm += $user->user['user_session_comm'];
                                                            $total_agent_match_session_comm += $total_agent_match_comm + $total_agent_session_comm;

                                                            $total_agent_net_amt += $total_user_amt_and_comm;


                                                            $total_agent_share_net_amt += $total_agent_share_amt;
                                                            $total_agent_final_net_amt += ($total_user_amt_and_comm - $total_agent_share_amt);


                                                            // $super_agent_match_comm =  $user->user['user_match_comm'];
                                                            // $super_agent_session_comm = $user->user['user_session_comm'];

                                                         

                                                            $super_master_final_amt = $total_user_amt_and_comm - $super_master_share_amt;

                                                            $total_super_agent_match_comm += $super_agent_match_comm;
                                                            $total_super_agent_session_comm += $super_agent_session_comm;

                                                            $total_super_agent_match_session_comm += $super_agent_session_comm + $super_agent_match_comm;

                                                            $total_super_agent_net_amt = $total_user_amt_and_comm;

                                                            // $total_super_agent_share_amt += $super_master_share_amt;

                                                            $total_super_agent_final_amt += $super_master_final_amt;







                                                    ?>
                                                            <tr>
                                                                <td height="25" align="left" valign="middle" class="FontText"> <?php echo $user->user_name; ?>(<?php echo $user->name; ?>)</td>
                                                                <td style="text-align:right;"><?php echo number_format($user->user['match_pl'], 2); ?></td>
                                                                <td style="text-align:right;"><?php echo number_format($user->user['session_pl'], 2); ?></td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_agent_amt, 2); ?></strong></td>
                                                                <td style="text-align:right;"><?php echo number_format($agent_match_comm, 2); ?></td>
                                                                <td style="text-align:right;"><?php echo number_format($agent_session_comm, 2); ?></td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_agent_comm, 2); ?></strong></td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_agent_amt_and_comm, 2); ?></strong></td>
                                                                <td style="text-align:right;"><?php echo number_format($total_agent_share_amt, 2); ?></td>
                                                                <td style="text-align:right;">0.00</td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($agent_final_amt, 2); ?></strong></td>
                                                                <td style="text-align:right;"><?php echo number_format($super_agent_match_comm, 2); ?></td>
                                                                <td style="text-align:right;"><?php echo number_format($super_agent_session_comm, 2); ?></td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_comm, 2); ?></strong></td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_amt_and_comm, 2); ?></strong></td>
                                                                <td style="text-align:right;"><?php echo number_format($total_super_agent_share_amt, 2); ?></td>
                                                                <td style="text-align:right;">0.00</td>
                                                                <td style="text-align:right;"><strong><?php echo number_format($total_super_agent_final_amt, 2); ?></strong></td>

                                                            </tr>

                                                    <?php }
                                                    } ?>
                                                    <tr>
                                                        <td width="250" height="25" align="left" valign="middle"><strong>AGENT TOTAL</strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_match_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_sess_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_user_amt_and_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_match_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_session_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_match_session_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_net_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_share_net_amt, 2); ?> </strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_agent_final_net_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_match_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_session_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_match_session_comm, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_net_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_share_amt, 2); ?></strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                        <td valign="middle" style="text-align:right;"><strong><?php echo number_format($total_super_agent_final_amt, 2); ?></strong></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--CLIENT END HERE-->

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
            <?php }
                        }
            ?>

            </tr>
                </tbody>
            </table>


        </div>
    </div>
</div>


<script>
    $('#from-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD'
    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD'
    });

    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {

        var sportId = $("#sportid").val();
        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var searchTerm = $("input[name='searchTerm']").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterProfiltLoss',
            data: {
                sportId: sportId,
                tdate: tdate,
                fdate: fdate,
                searchTerm: searchTerm,
                user_id: "<?php echo $user_id; ?>"
            },
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            complete: function() {
                $.unblockUI();
            },
            success: function(res) {
                $('#tablegh').html('');
                $('#tablegh').html(res);
            }
        });
    }
</script>