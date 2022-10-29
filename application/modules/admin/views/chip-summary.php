<style>
    #settlementpopup {
        background: rgba(0, 0, 0, 0.5);
    }

    .green_table .widget .widget-header,
    .green_table .widget .table-striped tfoot {
        background: linear-gradient(to bottom, #29b010, #8bbb35) !important;
    }

    .red_table .widget .widget-header,
    .red_table .widget .table-striped tfoot {
        background: linear-gradient(to bottom, #df2015, #af3c10e3);
    }

    .balance_sheet_user_name {
        font-size: 15px;
        font-weight: bold;
    }
</style>
<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Chip Summary Of <?php echo $user_name; ?>
                </span>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="clearfix data-background">

                        <div id="divLoading"></div>
                        <!--Loading class -->
                        <div id="chip-summary-data">

                            <?php








                            ?>

                            <div class="col-md-6 col-sm-6 green_table">
                                <div class="widget stacked widget-table action-table">
                                    <div class="widget-header">
                                        <h3><img style="" src="<?php echo base_url(); ?>assets/images/plus-img.png" alt=""> Plus Account</h3>
                                    </div>
                                    <div class="widget-content">
                                        <table class="table table-striped jambo_table bulk_action" id="">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="">User Detail </th>
                                                    <th class="">Account</th>

                                                    <th class="">Balance</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $total_plus_amount = 0;
                                                if (!empty($plus_acc)) {
                                                    foreach ($plus_acc as $pc) {


                                                        if ($pc['amount'] >= 0) {
                                                            $total_plus_amount += abs($pc['amount']);

                                                ?>
                                                            <tr id="user_row_47978">
                                                                <td class="balance_sheet_user_name ">
                                                                    <?php

                                                                    if ($pc['type'] == 'User') { ?>
                                                                        <?php echo $pc['name'] ?>
                                                                    <?php } else { ?>

                                                                        <?php

                                                                        if ($pc['type'] != 'Parent') { ?>
                                                                            <a href="<?php echo base_url(); ?>new_chipsummary/<?php echo $pc['user_id']; ?>"><?php echo $pc['name'] ?></a>
                                                                        <?php } else { ?>
                                                                            <?php echo $pc['name'] ?>
                                                                        <?php } ?>
                                                                    <?php  }

                                                                    ?>
                                                                </td>
                                                                <td>


                                                                    <?php

                                                                    if ($pc['type'] != 'Parent') { ?>
                                                                        <?php echo $pc['user_name'] ?> A/c
                                                                    <?php } else { ?>
                                                                        <strong>Cash</strong>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class=" " style="color:green;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format(abs($pc['amount']), 2) ?></td>
                                                                <td class=" ">

                                                                    <?php

                                                                    if ($pc['type'] != 'Parent') { ?>
                                                                        <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>admin/acStatement/7/<?php echo $pc['user_id']; ?>"><i aria-hidden="true">History</i></a>

                                                                        <a class="btn btn-xs btn-success btn-submitClearChip" href="javascript:;" title="Close Settlement" onclick="settlement('Plus', '<?php echo $pc['user_id']; ?>', '<?php echo $pc['user_name']; ?>',<?php echo $pc['amount']; ?>);"><i aria-hidden="true">Settlement</i></a>
                                                                    <?php } ?>

                                                                </td>

                                                            </tr>
                                                <?php
                                                        }
                                                    }
                                                } ?>


                                                <?php

                                                if ($self_profit_and_loss > 0) {



                                                    $total_plus_amount += abs($self_profit_and_loss);

                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            My sharing
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format(abs($self_profit_and_loss), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($upline_profit_and_loss > 0) {

                                                    $total_plus_amount += abs($upline_profit_and_loss);


                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Upline sharing
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format(abs($upline_profit_and_loss), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($cash_from_clients < 0) {


                                                    $total_plus_amount += abs($cash_from_clients);


                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Cash to downline
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $cash_from_clients ?>"><?php echo number_format(abs($cash_from_clients), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($cash_from_upline > 0) {


                                                    $total_plus_amount += abs($cash_from_upline);


                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Cash to upline
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $cash_from_upline ?>"><?php echo number_format(abs($cash_from_upline), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total</td>
                                                    <td></td>

                                                    <td> <?php echo number_format(abs($total_plus_amount), 2); ?></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-6 col-sm-6 red_table">
                                <div class="widget stacked widget-table action-table">
                                    <div class="widget-header">
                                        <h3><img style="" src="<?php echo base_url(); ?>assets/images/minus-img.png" alt=""> Minus Account</h3>
                                    </div>
                                    <div class="widget-content">
                                        <table class="table table-striped jambo_table bulk_action" id="">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="">User Detail</th>
                                                    <th class="">Account</th>

                                                    <th class="">Balance</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>



                                                <?php

                                                $total_minus_amount = 0;

                                                if (!empty($minus_acc)) {
                                                    foreach ($minus_acc as $pc) {



                                                        if ($pc['type'] == 'User') {

                                                            if ($pc['amount'] < 0) {

                                                                $total_minus_amount += abs($pc['amount']);
                                                ?>
                                                                <tr id="user_row_47978">
                                                                    <td class="balance_sheet_user_name ">
                                                                        <?php

                                                                        if ($pc['type']  == 'User') { ?>
                                                                            <?php echo $pc['name'] ?>
                                                                        <?php } else { ?>

                                                                            <?php

                                                                            if ($pc['type'] != 'Parent') { ?>
                                                                                <a href="<?php echo base_url(); ?>new_chipsummary/<?php echo $pc['user_id']; ?>"><?php echo $pc['name'] ?></a>
                                                                            <?php } else { ?>
                                                                                <?php echo $pc['name'] ?>
                                                                            <?php } ?>
                                                                        <?php  }

                                                                        ?>
                                                                    </td>

                                                                    <td>


                                                                        <?php

                                                                        if ($pc['type'] != 'Parent') { ?>
                                                                            <?php echo $pc['user_name'] ?> A/c
                                                                        <?php } else { ?>
                                                                            <strong>Cash</strong>
                                                                        <?php } ?>
                                                                    </td>

                                                                    <td class=" " style="color:red;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format($pc['amount'], 2) ?></td>

                                                                    <td class=" ">
                                                                        <?php

                                                                        if ($pc['type'] != 'Parent') { ?>
                                                                            <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>admin/acStatement/7/<?php echo $pc['user_id']; ?>"><i aria-hidden="true">History</i></a>

                                                                            <a class="btn btn-xs btn-danger btn-submitClearChip" href="javascript:;" title="Close Settlement" onclick="settlement('Minus', '<?php echo $pc['user_id']; ?>', '<?php echo $pc['user_name']; ?>',<?php echo $pc['amount']; ?>);"><i aria-hidden="true">Settlement</i></a>

                                                                        <?php } ?>
                                                                    </td>

                                                                </tr>
                                                            <?php
                                                            }
                                                        } else {

                                                            $total_minus_amount += abs($pc['amount']);
                                                            ?>

                                                            <tr id="user_row_47978">
                                                                <td class="balance_sheet_user_name">
                                                                    <?php

                                                                    if ($pc['type']  == 'User') { ?>
                                                                        <?php echo $pc['name'] ?>
                                                                    <?php } else { ?>

                                                                        <?php

                                                                        if ($pc['type'] != 'Parent') { ?>
                                                                            <a href="<?php echo base_url(); ?>new_chipsummary/<?php echo $pc['user_id']; ?>"><?php echo $pc['name'] ?></a>
                                                                        <?php } else { ?>
                                                                            <?php echo $pc['name'] ?>
                                                                        <?php } ?>
                                                                    <?php  }

                                                                    ?>
                                                                </td>
                                                                <td>

                                                                    <?php

                                                                    if ($pc['type'] != 'Parent') { ?>
                                                                        <?php echo $pc['user_name'] ?> A/c
                                                                    <?php } else { ?>
                                                                        <strong>Cash</strong>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class=" " style="color:red;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format($pc['amount'], 2) ?></td>

                                                                <td class=" ">
                                                                    <?php

                                                                    if ($pc['type'] != 'Parent') { ?>
                                                                        <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>admin/acStatement/7/<?php echo $pc['user_id']; ?>"><i aria-hidden="true">History</i></a>

                                                                        <a class="btn btn-xs btn-danger btn-submitClearChip" href="javascript:;" title="Close Settlement" onclick="settlement('Plus', '<?php echo $pc['user_id']; ?>', '<?php echo $pc['user_name']; ?>',<?php echo $pc['amount']; ?>);"><i aria-hidden="true">Settlement</i></a>

                                                                    <?php } ?>
                                                                </td>

                                                            </tr>

                                                <?php
                                                        }
                                                    }
                                                } ?>



                                                <?php

                                                if ($self_profit_and_loss < 0) {
                                                    $total_minus_amount += abs($self_profit_and_loss);
                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            My sharing
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format(abs($self_profit_and_loss), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($upline_profit_and_loss < 0) {
                                                    $total_minus_amount += abs($upline_profit_and_loss);
                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Upline sharing
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:green;" data-value="<?php echo $pc['amount'] ?>"><?php echo number_format(abs($upline_profit_and_loss), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($cash_from_clients > 0) {
                                                    // p($total_minus_amount);;
                                                    $total_minus_amount += abs($cash_from_clients);
                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Cash from downline
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:red;" data-value="<?php echo $cash_from_clients ?>"><?php echo number_format(abs($cash_from_clients), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                                <?php

                                                if ($cash_from_upline > 0) {


                                                    $total_plus_amount += abs($cash_from_upline);


                                                ?>
                                                    <tr>
                                                        <td class="balance_sheet_user_name ">
                                                            Cash to upline
                                                        </td>
                                                        <td>
                                                            P/L
                                                        </td>
                                                        <td class=" " style="color:red;" data-value="<?php echo $cash_from_upline ?>"><?php echo number_format(abs($cash_from_upline), 2) ?></td>

                                                        <td class=" ">

                                                        </td>

                                                    </tr>
                                                <?php }

                                                ?>


                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td>Total</td>
                                                    <td></td>

                                                    <td><?php echo number_format(abs($total_minus_amount), 2); ?></td>
                                                    <td></td>

                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " id="settlementpopup" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <form id="settlement-form">
            <div class="modal-content ">
                <div class="popup_form">
                    <div class="title_popup "><span id="tital_change">User Name <?php echo $pc['name'] ?> A/c || <?php echo count_free_chip($pc['user_id']) ?></span>
                        <button type="button" class="close" data-dismiss="modal">
                            <div class="close_new"><i class="fa fa-times-circle"></i></div>
                        </button>
                    </div>
                    <div class="content_popup">
                        <input type="hidden" name="UserID" id="UserID" value="">
                        <input type="hidden" name="MaxAmt" id="MaxAmt" value="">
                        <input type="hidden" name="CrDr" class="form-control" id="CrDr" value="">

                        <div class="popup_form_row">
                            <div class="popup_col_6">
                                <label for="email">Chips :</label>
                                <input type="text" name="Name1" class="form-control" id="Chips">
                                <span id="Name1N" class="errmsg"></span>
                            </div>
                            <div class="popup_col_6">
                                <label for="pwd">Remark:</label>
                                <input type="text" name="Value1" class="form-control" id="Narration">
                                <span id="Value1N" class="errmsg"></span>
                            </div>

                        </div>
                        <div class="popup_form_row">
                            <div class="popup_col_6">
                                <button type="submit" class="red_button" id="saveSettelment">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                searchTerm: searchTerm


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


    function settlement(type, user_id, user_name, max_amount) {
        $('#tital_change').text('User Name ' + user_name + ' A/c || ' + max_amount);
        $('#UserID').val(user_id);
        $('#MaxAmt').val(max_amount);
        $('#Chips').attr('max', Math.abs(max_amount));
        $('#Chips').val(Math.abs(max_amount));

        // $('#Chips').val('');
        $('#Narration').val('');
        $('#CrDr').val(type);
        $('#settlementpopup').modal('show');
    }


    $(document).ready(function() {
        $("#settlement-form").validate({
            rules: {
                Chips: {
                    required: true,
                },
                Narration: {
                    required: true,
                },
            },

            submitHandler: function(form, event) {
                $(this).off(event);
                event.preventDefault();

                var chips = $('#Chips').val();
                var narration = $('#Narration').val();
                var userId = $('#UserID').val();
                var MaxAmt = $('#MaxAmt').val();
                var CrDr = $('#CrDr').val();



                $("#settlement-form").modal("hide");
                $("#settlement-form").trigger("reset");


                $.ajax({
                    url: base_url + "admin/Reports/addsettlement",
                    method: "POST",
                    data: {
                        chips: chips,
                        narration: narration,
                        userId: userId,
                        MaxAmt: MaxAmt,
                        CrDr: CrDr
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.success) {

                            new PNotify({
                                title: "Success",
                                text: "settlement successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });

                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        } else {
                            new PNotify({
                                title: "Error",
                                text: data.message,
                                styling: "bootstrap3",
                                type: "error",

                                delay: 3000,
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        }
                    },
                });
                return false;
            },
        });

        function blockUI() {
            $.blockUI({
                message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
            });
        }

        $('#FilterData').click(function() {
            var searchTerm = $('#searchTerm').val();
            if (searchTerm.trim()) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/Reports/filterChipSummary',
                    data: {
                        searchTerm: searchTerm,
                        user_type: '<?php echo $user_type; ?>',
                        user_id: '<?php echo $user_id; ?>',
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
                        $('#chip-summary-data').html(res);
                    }
                });
            }

        })
    })

    function formReset() {
        location.reload();
    }
</script>