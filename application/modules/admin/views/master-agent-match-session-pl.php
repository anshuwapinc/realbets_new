<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="title_new_at">
                Match & Session Plus Minus Report Selection Match Code : <?php echo $event->event_id; ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12" style="overflow-x:scroll;">

            <table style="margin-bottom:30px;" class="table table-striped table-bordered">

                <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                    <tbody>
                        <tr class="yellow-bg">
                            <td width="60"><strong>MASTER AGENT </strong></td>
                            <td><strong><?php echo $reports->user_name; ?>(<?php
                                                                            echo $reports->name; ?>)</strong></td>
                        </tr>
                        <?php

                        $hyper = $reports;

                        $grand_total_agent_match_amt_2 = 0;
                        $grand_total_agent_sess_amt_2 = 0;
                        $grand_total_agent_total_amt_2 = 0;
                        $grand_total_agent_match_comm_2  = 0;
                        $grand_total_agent_sess_comm_2 = 0;
                        $grand_total_agent_total_comm_2 = 0;
                        $grand_total_agent_net_amt_2  = 0;
                        $grand_total_agent_share_amt_2  = 0;
                        $grand_total_agent_final_amt_2 = 0;


                        $grand_total_super_agent_match_comm_1   = 0;
                        $grand_total_super_agent_sess_comm_1 = 0;
                        $grand_total_super_agent_total_comm_1  = 0;
                        $grand_total_super_agent_net_amt_1   = 0;
                        $grand_total_super_agent_share_amt_1  = 0;
                        $grand_total_super_agent_final_amt_1  = 0;



                        $grand_total_master_agent_match_comm_1 = 0;
                        $grand_total_master_agent_sess_comm_1 = 0;
                        $grand_total_master_agent_total_comm_1 = 0;
                        $grand_total_master_agent_net_amt_1 = 0;
                        $grand_total_master_agent_share_amt_1 = 0;
                        $grand_total_master_agent_final_amt_1 = 0;
                        
                        if (!empty($hyper->supers)) {
                            $supers = $hyper->supers;
                            foreach ($supers as $super) { ?>
                                <tr>
                                    <td colspan="2" height="25">

                                        <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                            <tbody>
                                                <tr class="sky-blue-bg">
                                                    <td width="60"><strong>SUPER AGENT </strong></td>
                                                    <td><strong><?php echo $super->user_name; ?>(<?php
                                                                                                    echo $super->name; ?>)</strong></td>
                                                </tr>
                                                <?php if (!empty($super->masters)) {
                                                    $masters = $super->masters;

                                                    $sub_total_master_agent_match_comm_1 = 0;
                                                    $sub_total_master_agent_sess_comm_1 = 0;
                                                    $sub_total_master_agent_total_comm_1 = 0;
                                                    $sub_total_master_agent_net_amt_1 = 0;
                                                    $sub_total_master_agent_share_amt_1 = 0;
                                                    $sub_total_master_agent_final_amt_1 = 0;




                                                
                                

                                                    foreach ($masters as $master) {
                                                        
                                                        $agent_match_amt_6 = 0;
                                                        $agent_sess_amt_6 = 0;
                                                        $agent_total_match_amt_6 = 0;

                                                        $agent_match_comm_amt_6 = 0;
                                                        $agent_sess_comm_amt_6 = 0;
                                                        $agent_total_comm_amt_6 = 0;


                                                        $agent_net_amt_6 = 0;
                                                        $agent_share_amt_6 = 0;
                                                        $agent_final_amt_6 = 0;




                                                     

                                                        $super_agent_match_comm_amt_6 = 0;
                                                        $super_agent_sess_comm_amt_6 = 0;
                                                        $super_agent_total_comm_amt_6 = 0;
                                                        $super_agent_net_amt_6 = 0;
                                                        $super_agent_share_amt_6 = 0;
                                                        $super_agent_final_amt_6 = 0;



                                                        $master_agent_match_comm_amt_6 = 0;
                                                        $master_agent_sess_comm_amt_6 = 0;
                                                        $master_agent_total_comm_amt_6 = 0;
                                                        $master_agent_net_amt_6 = 0;
                                                        $master_agent_share_amt_6 = 0;
                                                        $master_agent_final_amt_6 = 0;


                                                        $sub_admin_match_comm_amt_6 = 0;
                                                        $sub_admin_sess_comm_amt_6 = 0;
                                                        $sub_admin_total_comm_amt_6 = 0;
                                                        $sub_admin_net_amt_6 = 0;
                                                        $sub_admin_share_amt_6 = 0;
                                                        $sub_admin_final_amt_6 = 0;
                                                        ?>
                                                        <tr>
                                                            <td colspan="2" height="25">

                                                                <table style="margin-bottom:30px;" class="table table-striped table-bordered">
                                                                    <tbody>
                                                                        <tr class="blue-bg">
                                                                            <td width="60"><strong>AGENT </strong></td>
                                                                            <td><strong><?php echo $master->user_name; ?>(<?php
                                                                                                                            echo $master->name; ?>)</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" height="25">

                                                                                <!--CLIENT START HERE-->
                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="table table-striped table-bordered" style="padding-bottom:100px;">
                                                                                    <tbody>
                                                                                        <tr>


                                                                                            <td colspan="11" align="right" valign="middle" style="text-align:center;"><strong>AGENT PLUS MINUS</strong></td>
                                                                                            <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>SUPER AGENT PLUS MINUS</strong></td>
                                                                                            <td colspan="7" align="right" valign="middle" style="text-align:center;"><strong>MASTER AGENT PLUS MINUS</strong></td>


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
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>M. COM</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>S. COM</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>TOL. COM</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>NET AMT</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>SHR AMT</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>MOB. APP</strong></td>
                                                                                            <td width="100" align="right" valign="middle" style="text-align:right;"><strong>FINAL</strong></td>


                                                                                        </tr>

                                                                                        <?php

                                                                                        $grand_total_agent_match_amt = 0;
                                                                                        $grand_total_agent_sess_amt = 0;
                                                                                        $grand_total_agent_total_amt = 0;
                                                                                        $grand_total_agent_match_comm = 0;
                                                                                        $grand_total_agent_sess_comm = 0;
                                                                                        $grand_total_agent_total_comm = 0;
                                                                                        $grand_total_agent_net_amt = 0;
                                                                                        $grand_total_agent_share_amt = 0;
                                                                                        $grand_total_agent_mob_app = 0;
                                                                                        $grand_total_agent_final_amt = 0;


                                                                                        $sub_total_super_agent_match_amt = 0;
                                                                                        $sub_total_super_agent_sess_amt = 0;
                                                                                        $sub_total_super_agent_total_amt = 0;
                                                                                        $sub_total_super_agent_match_comm = 0;
                                                                                        $sub_total_super_agent_sess_comm = 0;
                                                                                        $sub_total_super_agent_total_comm = 0;
                                                                                        $sub_total_super_agent_net_amt = 0;
                                                                                        $sub_total_super_agent_share_amt = 0;
                                                                                        $sub_total_super_agent_mob_app = 0;
                                                                                        $sub_total_super_agent_final_amt = 0;




                                                                                        $sub_total_master_agent_match_comm = 0;
                                                                                        $sub_total_master_agent_sess_comm = 0;
                                                                                        $sub_total_master_agent_total_comm = 0;
                                                                                        $sub_total_master_agent_net_amt = 0;
                                                                                        $sub_total_master_agent_share_amt = 0;
                                                                                        $sub_total_master_agent_final_amt = 0;



                                                                                        $grand_total_agent_match_amt_1 = 0;
                                                                                        $grand_total_agent_sess_amt_1 = 0;
                                                                                        $grand_total_agent_total_amt_1 = 0;
                                                                                        $grand_total_agent_match_comm_1 = 0;
                                                                                        $grand_total_agent_sess_comm_1 = 0;
                                                                                        $grand_total_agent_total_comm_1 = 0;
                                                                                        $grand_total_agent_net_amt_1 = 0;
                                                                                        $grand_total_agent_share_amt_1 = 0;
                                                                                        $grand_total_agent_mob_app_1 = 0;
                                                                                        $grand_total_agent_final_amt_1 = 0;



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
                                                                                                $total_session_stake = $user->user['total_session_stake'];

                                                                                                $agent_session_comm_per =  $user->master['sessional_commission'];




                                                                                                if ($total_session_stake > 0) {
                                                                                                    $agent_session_comm = (abs($total_session_stake) * $agent_session_comm_per) / 100;
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




                                                                                                if ($total_session_stake > 0) {
                                                                                                    $super_agent_session_comm = (abs($total_session_stake) * $super_agent_session_comm_per) / 100;
                                                                                                }


                                                                                                /**************SUPER AGENT SESSION COMM */


                                                                                                $total_super_agent_comm = $super_agent_match_comm + $super_agent_session_comm;

                                                                                                $total_super_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                $total_super_agent_amt_and_comm = $total_super_agent_amt - $total_super_agent_comm;
                                                                                                $total_super_agent_share_amt =  ($total_super_agent_amt_and_comm * $user->super_master['partnership']) / 100;

                                                                                                $total_super_agent_final_amt = $total_super_agent_amt_and_comm - $total_super_agent_share_amt;




                                                                                                /**************MASTER AGENT MATCH COMM */
                                                                                                $master_agent_match_comm = 0;
                                                                                                $match_amt = $user->user['match_pl'];
                                                                                                $master_agent_match_comm_per =  $user->hyper_super_master['match_comm'];


                                                                                                if ($match_amt > 0) {
                                                                                                    $master_agent_match_comm = (abs($match_amt) * $master_agent_match_comm_per) / 100;
                                                                                                }

                                                                                                // p($agent_match_comm);
                                                                                                /**************MASTER AGENT MATCH COMM */

                                                                                                /**************MASTER AGENT SESSION COMM */
                                                                                                $master_agent_session_comm = 0;
                                                                                                $session_amt = $user->user['session_pl'];
                                                                                                $master_agent_session_comm_per =  $user->hyper_super_master['sessional_commission'];


                                                                                                if ($total_session_stake > 0) {
                                                                                                    $master_agent_session_comm = (abs($total_session_stake) * $master_agent_session_comm_per) / 100;
                                                                                                }
                                                                                                /**************MASTER AGENT SESSION COMM */


                                                                                                $total_master_agent_comm = $master_agent_match_comm + $master_agent_session_comm;

                                                                                                $total_master_agent_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                $total_master_agent_amt_and_comm = $total_master_agent_amt - $total_master_agent_comm;
                                                                                                $total_master_agent_share_amt =  ($total_master_agent_amt_and_comm * $user->hyper_super_master['partnership']) / 100;
                                                                                                $total_master_agent_final_amt = $total_master_agent_amt_and_comm - $total_master_agent_share_amt;




                                                                                                /**************SUB ADMIN MATCH COMM */
                                                                                                $sub_admin_match_comm = 0;
                                                                                                $match_amt = $user->user['match_pl'];
                                                                                                $sub_admin_match_comm_per =  $user->admin['match_comm'];


                                                                                                if ($match_amt > 0) {
                                                                                                    $sub_admin_match_comm = (abs($match_amt) * $sub_admin_match_comm_per) / 100;
                                                                                                }

                                                                                                // p($agent_match_comm);
                                                                                                /**************SUB ADMIN MATCH COMM */

                                                                                                /**************SUB ADMIN SESSION COMM */
                                                                                                $sub_admin_session_comm = 0;
                                                                                                $session_amt = $user->user['session_pl'];
                                                                                                $sub_admin_session_comm_per =  $user->admin['sessional_commission'];


                                                                                                if ($total_session_stake > 0) {
                                                                                                    $sub_admin_session_comm = (abs($total_session_stake) * $sub_admin_session_comm_per) / 100;
                                                                                                }

                                                                                                /**************SUB ADMIN SESSION COMM */


                                                                                                $total_sub_admin_comm = $sub_admin_match_comm + $sub_admin_session_comm;

                                                                                                $total_sub_admin_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                $total_sub_admin_amt_and_comm = $total_sub_admin_amt - $total_sub_admin_comm;
                                                                                                $total_sub_admin_share_amt =  ($total_sub_admin_amt_and_comm * $user->admin['partnership']) / 100;
                                                                                                $total_sub_admin_final_amt = $total_sub_admin_amt_and_comm - $total_sub_admin_share_amt;



                                                                                                /************** ADMIN MATCH COMM */
                                                                                                $sub_admin_match_comm = 0;
                                                                                                $match_amt = $user->user['match_pl'];
                                                                                                $sub_admin_match_comm_per =  $user->admin['match_comm'];


                                                                                                if ($match_amt > 0) {
                                                                                                    $sub_admin_match_comm = (abs($match_amt) * $sub_admin_match_comm_per) / 100;
                                                                                                }

                                                                                                // p($agent_match_comm);
                                                                                                /************** ADMIN MATCH COMM */

                                                                                                /************** ADMIN SESSION COMM */
                                                                                                $admin_session_comm = 0;
                                                                                                $session_amt = $user->user['session_pl'];
                                                                                                $admin_session_comm_per =  $user->super_admin['sessional_commission'];


                                                                                                if ($total_session_stake > 0) {
                                                                                                    $admin_session_comm_per = (abs($total_session_stake) * $admin_session_comm_per) / 100;
                                                                                                }
                                                                                                /************** ADMIN SESSION COMM */


                                                                                                $total_admin_comm = $admin_match_comm + $admin_session_comm;

                                                                                                $total_admin_amt =  $user->user['match_pl'] + $user->user['session_pl'];

                                                                                                $total_admin_amt_and_comm = $total_admin_amt - $total_admin_comm;
                                                                                                $total_admin_share_amt =  ($total_admin_amt_and_comm * $user->super_admin['partnership']) / 100;
                                                                                                $total_admin_final_amt = $total_admin_amt_and_comm - $total_admin_share_amt;


                                                                                                $grand_total_agent_match_amt += $user->user['match_pl'];
                                                                                                $grand_total_agent_sess_amt += $user->user['session_pl'];
                                                                                                $grand_total_agent_total_amt += $total_agent_amt;
                                                                                                $grand_total_agent_match_comm += $agent_match_comm;
                                                                                                $grand_total_agent_sess_comm += $agent_session_comm;
                                                                                                $grand_total_agent_total_comm += $total_agent_comm;
                                                                                                $grand_total_agent_net_amt += $total_agent_amt_and_comm;
                                                                                                $grand_total_agent_share_amt += $total_agent_share_amt;
                                                                                                $grand_total_agent_final_amt += $agent_final_amt;



                                                                                                $sub_total_super_agent_match_amt += $user->user['match_pl'];
                                                                                                $sub_total_super_agent_sess_amt  += $user->user['session_pl'];
                                                                                                $sub_total_super_agent_total_amt += $total_agent_amt;
                                                                                                $sub_total_super_agent_match_comm += $super_agent_match_comm;
                                                                                                $sub_total_super_agent_sess_comm += $super_agent_session_comm;
                                                                                                $sub_total_super_agent_total_comm += $total_super_agent_comm;
                                                                                                $sub_total_super_agent_net_amt += $total_super_agent_amt_and_comm;
                                                                                                $sub_total_super_agent_share_amt  += $total_super_agent_share_amt;
                                                                                                $sub_total_super_agent_final_amt  += $total_super_agent_final_amt;

                                                                                                $grand_total_agent_match_amt_1 += $user->user['match_pl'];
                                                                                                $grand_total_agent_sess_amt_1 += $user->user['session_pl'];
                                                                                                $grand_total_agent_total_amt_1 += $total_agent_amt;
                                                                                                $grand_total_agent_match_comm_1 += $agent_match_comm;
                                                                                                $grand_total_agent_sess_comm_1 += $agent_session_comm;
                                                                                                $grand_total_agent_total_comm_1 += $total_agent_comm;
                                                                                                $grand_total_agent_net_amt_1 += $total_agent_amt_and_comm;
                                                                                                $grand_total_agent_share_amt_1 += $total_agent_share_amt;
                                                                                                $grand_total_agent_final_amt_1 += $agent_final_amt;



                                                                                                $grand_total_super_agent_match_comm  += $super_agent_match_comm;
                                                                                                $grand_total_super_agent_sess_comm += $super_agent_session_comm;
                                                                                                $grand_total_super_agent_total_comm += $total_super_agent_comm;
                                                                                                $grand_total_super_agent_net_amt  += $total_super_agent_amt_and_comm;
                                                                                                $grand_total_super_agent_share_amt += $total_super_agent_share_amt;
                                                                                                $grand_total_super_agent_final_amt += $total_super_agent_final_amt;


                                                                                                $sub_total_master_agent_match_comm += $master_agent_match_comm;
                                                                                                $sub_total_master_agent_sess_comm += $master_agent_session_comm;
                                                                                                $sub_total_master_agent_total_comm += $total_master_agent_comm;
                                                                                                $sub_total_master_agent_net_amt += $total_master_agent_amt_and_comm;
                                                                                                $sub_total_master_agent_share_amt += $total_master_agent_share_amt;
                                                                                                $sub_total_master_agent_final_amt += $total_master_agent_final_amt;


                                                                                                $sub_total_master_agent_match_comm_1 += $master_agent_match_comm;
                                                                                                $sub_total_master_agent_sess_comm_1 += $master_agent_session_comm;
                                                                                                $sub_total_master_agent_total_comm_1 += $total_master_agent_comm;
                                                                                                $sub_total_master_agent_net_amt_1 += $total_master_agent_amt_and_comm;
                                                                                                $sub_total_master_agent_share_amt_1 += $total_master_agent_share_amt;
                                                                                                $sub_total_master_agent_final_amt_1 += $total_master_agent_final_amt;


                                                                                                $grand_total_agent_match_amt_2 += $user->user['match_pl'];
                                                                                                $grand_total_agent_sess_amt_2 += $user->user['session_pl'];
                                                                                                $grand_total_agent_total_amt_2 += $total_agent_amt;
                                                                                                $grand_total_agent_match_comm_2 += $agent_match_comm;
                                                                                                $grand_total_agent_sess_comm_2 += $agent_session_comm;
                                                                                                $grand_total_agent_total_comm_2 += $total_agent_comm;
                                                                                                $grand_total_agent_net_amt_2 += $total_agent_amt_and_comm;
                                                                                                $grand_total_agent_share_amt_2 += $total_agent_share_amt;
                                                                                                $grand_total_agent_final_amt_2 += $agent_final_amt;


                                                                                                $grand_total_super_agent_match_comm_1  += $super_agent_match_comm;
                                                                                                $grand_total_super_agent_sess_comm_1 += $super_agent_session_comm;
                                                                                                $grand_total_super_agent_total_comm_1 += $total_super_agent_comm;
                                                                                                $grand_total_super_agent_net_amt_1  += $total_super_agent_amt_and_comm;
                                                                                                $grand_total_super_agent_share_amt_1 += $total_super_agent_share_amt;
                                                                                                $grand_total_super_agent_final_amt_1 += $total_super_agent_final_amt;
                                                                                       
                                                                                                
                                                                                                $grand_total_master_agent_match_comm_1 += $master_agent_match_comm;
                                                                                                $grand_total_master_agent_sess_comm_1 += $master_agent_session_comm;
                                                                                                $grand_total_master_agent_total_comm_1 += $total_master_agent_comm;
                                                                                                $grand_total_master_agent_net_amt_1 += $total_master_agent_amt_and_comm;
                                                                                                $grand_total_master_agent_share_amt_1 += $total_master_agent_share_amt;
                                                                                                $grand_total_master_agent_final_amt_1 += $total_master_agent_final_amt;
                                                                                            

                                                                                                $agent_match_amt_6 += $user->user['match_pl'];
                                                                                                $agent_sess_amt_6 += $user->user['session_pl'];
                                                                                                $agent_total_match_amt_6 += $total_agent_amt;

                                                                                                $agent_match_comm_amt_6 += $agent_match_comm;
                                                                                                $agent_sess_comm_amt_6 += $agent_session_comm;
                                                                                                $agent_total_comm_amt_6 += $total_agent_comm;


                                                                                                $agent_net_amt_6 += $total_agent_amt_and_comm;
                                                                                                $agent_share_amt_6 += $total_agent_share_amt;
                                                                                                $agent_final_amt_6 += $agent_final_amt;



                                                                                                $super_agent_match_comm_amt_6 += $super_agent_match_comm;
                                                                                                $super_agent_sess_comm_amt_6 += $super_agent_session_comm;
                                                                                                $super_agent_total_comm_amt_6 += $total_super_agent_comm;
                                                                                                $super_agent_net_amt_6 += $total_super_agent_amt_and_comm;
                                                                                                $super_agent_share_amt_6 += $total_super_agent_share_amt;
                                                                                                $super_agent_final_amt_6 += $total_super_agent_final_amt;




                                                                                                $master_agent_match_comm_amt_6 += $master_agent_match_comm;
                                                                                                $master_agent_sess_comm_amt_6 += $master_agent_session_comm;
                                                                                                $master_agent_total_comm_amt_6 += $total_master_agent_comm;
                                                                                                $master_agent_net_amt_6 += $total_master_agent_amt_and_comm;
                                                                                                $master_agent_share_amt_6 += $total_master_agent_share_amt;
                                                                                                $master_agent_final_amt_6 += $total_master_agent_final_amt;

 
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
                                                                                                    <td style="text-align:right;"><?php echo number_format($master_agent_match_comm, 2); ?></td>
                                                                                                    <td style="text-align:right;"><?php echo number_format($master_agent_session_comm, 2); ?></td>
                                                                                                    <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_comm, 2); ?></strong></td>
                                                                                                    <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_amt_and_comm, 2); ?></strong></td>
                                                                                                    <td style="text-align:right;"><?php echo number_format($total_master_agent_share_amt, 2); ?></td>
                                                                                                    <td style="text-align:right;">0.00</td>
                                                                                                    <td style="text-align:right;"><strong><?php echo number_format($total_master_agent_final_amt, 2); ?></strong></td>




                                                                                                </tr>

                                                                                        <?php }
                                                                                        } ?>
                                                                                           <tr>
                                                                                                                                <td width="250" height="25" align="left" valign="middle"><strong>AGENT TOTAL</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_match_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_total_match_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_sess_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_share_amt_6, 2); ?> </strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($agent_final_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_sess_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_total_comm_amt_6); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($super_agent_final_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_match_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_match_sess_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_total_comm_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_net_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_share_amt_6, 2); ?></strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong>0.00</strong></td>
                                                                                                                                <td valign="middle" style="text-align:right;"><strong><?php echo number_format($master_agent_final_amt_6, 2); ?></strong></td>

                                                                                                                                

                                                                                                                            </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            <?php }

                            ?>

                            
                        <?php } ?>
                    </tbody>
                </table>
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