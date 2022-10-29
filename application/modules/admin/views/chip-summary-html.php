<div class="col-md-6 col-sm-6 green_table">
    <div class="link">PLUS ACCOUNT</div>
    <div class="main_gre-red">
        <table class="table table-striped jambo_table bulk_action" id="">
            <thead>
                <tr class="headings">
                    <th class="">Name</th>
                    <th class="">Account</th>
                    <th class="">Chips</th>
                    <th class=""></th>
                </tr>
            </thead>
            <tbody>


                <?php

                $total_master_commision = 0;
                $total_parent_master_commision = 0;

                $total_minus_amount = 0;


                if (!empty($plus_acc)) {
                    // p($plus_acc);
                    foreach ($plus_acc as $pc) {
                        $master_commision = $pc['master_comission'];
                        $total_parent_master_commision += $pc['parent_comission'];
                        $total_master_commision += $master_commision;

                        if ($pc['type'] == 'User') {
                            $total_minus_amount += $pc['amount'];
                        }
                    }
                } ?>
                <tr id="user_row_47969">
                    <td class=""><?php echo $_SESSION['my_userdata']['name'] ?></td>
                    <td class="acco ">Own Commission</td>
                    <td class=" "><?php echo $total_master_commision - $total_parent_master_commision; ?> </td>
                    <td class=" ">
                    </td>
                </tr>
                <tr id="user_row_47969">
                    <td class=""><?php echo $parent_name ?></td>
                    <td class="acco ">Parent Commission</td>
                    <td class=" "><?php echo abs($total_parent_master_commision); ?></td>
                    <td class=" ">
                    </td>
                </tr>
                <?php
                $total_master_commision = 0;
                $total_parent_master_commision = 0;

                $total_minus_amount = 0;

                $total_parent_partership_amt = 0;
                if (!empty($plus_acc)) {
                    foreach ($plus_acc as $pc) {
                        $master_commision = $pc['master_comission'];

                        $total_parent_master_commision += $pc['parent_comission'];
                        $total_master_commision += $master_commision;

                        if ($pc['type'] == 'User') {
                            $total_minus_amount += $pc['amount'];
                        }
                        $master_partership_amt = $pc['amount'] * ($pc["partnership"] / 100);
                        $total_parent_partership_amt += $pc['amount'] - $master_partership_amt;

                        if ($pc['type'] == 'User') {
                ?>
                            <tr id="user_row_47978">
                                <td class=" ">
                                    <?php

                                    if ($user_type == 'Master') { ?>
                                        <?php echo $pc['user_name'] ?>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url(); ?>new_chipsummary/<?php echo $pc['user_id']; ?>"><?php echo $pc['user_name'] ?></a>
                                    <?php  }

                                    ?>
                                </td>

                                <td class=" acco"><?php echo $pc['name'] ?> A/c</td>
                                <td class=" " style="color:green;"><?php echo abs($pc['amount']) ?></td>
                                <td class=" ">
                                    <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>admin/acStatement/4/<?php echo $pc['user_id'] ?>"><i aria-hidden="true">History</i></a>
                                    <a class="btn btn-xs btn-success" onclick="settlement('Plus','<?php echo $pc['user_id']; ?>','<?php echo $pc['user_name']; ?>','<?php echo $pc['amount']; ?>')">Settlement</i></a>
                                </td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr id="user_row_47978">
                                <td class=" "><?php echo $pc['user_name'] ?></td>
                                <td class=" acco">Parent Partnership </td>
                                <td class=" " style="color:green;"><?php echo abs($pc['amount']) ?></td>
                                <td class=" ">

                                </td>
                            </tr>
                <?php
                        }
                    }
                } ?>



            </tbody>
            <tfoot>
                <tr>
                    <td> Total</td>
                    <td></td>
                    <td> <?php echo $total_minus_amount; ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="col-md-6 col-sm-6 red_table">
    <div class="link minus">MINUS ACCOUNT</div>
    <div class="main_gre-red">
        <table class="table table-striped jambo_table bulk_action" id="">
            <thead>
                <tr class="headings">
                    <th class="">Name</th>
                    <th class="">Account</th>
                    <th class="">Chips</th>
                    <th class=""></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_master_commision = 0;
                $total_minus_amount = 0;
                $total_parent_partership_amt = 0;

                if (!empty($minus_acc)) {
                    foreach ($minus_acc as $pc) {
                        $master_comission =  $pc['master_comission'];
                        $total_master_commision += $master_comission;

                        if ($pc['type'] == 'User') {
                            $total_minus_amount += $pc['amount'];
                        }

                        $master_partership_amt = $pc['amount'] * ($pc["partnership"] / 100);

                        // p($master_partership_amt);
                        $total_parent_partership_amt += $pc['amount'] - $master_partership_amt;

                        if ($pc['type'] == 'User') {
                ?>
                            <tr id="user_row_47978">
                                <td class=" ">
                                    <?php

                                    if ($user_type == 'Master') { ?>
                                        <?php echo $pc['user_name'] ?>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url(); ?>new_chipsummary/<?php echo $pc['user_id']; ?>"><?php echo $pc['user_name'] ?></a>
                                    <?php  }

                                    ?>
                                </td>
                                <td class=" acco"><?php echo $pc['name'] ?> A/c</td>
                                <td class=" " style="color:red;"><?php echo abs($pc['amount']) ?></td>
                                <td class=" ">
                                    <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>admin/acStatement/4/<?php echo $pc['user_id'] ?>"><i aria-hidden="true">History</i></a>
                                    <a class="btn btn-xs btn-danger" onclick="settlement('Minus','<?php echo $pc['user_id']; ?>','<?php echo $pc['user_name']; ?>','<?php echo $pc['amount']; ?>')">Settlement</i></a>
                                </td>
                            </tr>
                        <?php
                        } else if ($pc['type'] == 'Parent') {
                        ?>
                            <tr id="user_row_47978">
                                <td class=" ">Parent Partnership <?php echo $pc['user_name'] ?></td>
                                <td class=" acco"><?php echo $pc['name'] ?> A/c</td>
                                <td class=" " style="color:red;"><?php echo abs($pc['amount']) ?></td>
                                <td class=" ">

                                </td>
                            </tr>
                <?php
                        }
                    }
                } ?>
                <tr id="user_row_47969">
                    <td class=" "><?php echo $_SESSION['my_userdata']['name'] ?></td>
                    <td class=" acco">Own Commission</td>
                    <td class=" " style="color:green;"><?php echo abs($total_master_commision); ?></td>
                    <td class=" ">
                    </td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td> Total</td>
                    <td></td>
                    <td style="color:green;"><?php echo abs($total_minus_amount + $total_master_commision); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>