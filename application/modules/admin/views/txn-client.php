<div class="right_col" role="main">


    <div class="card" style="background:#fff;">
        <form id="settlement-form" method="POST">
            <div class="card-header">
                <div class="title_new_at"> Client Transactions
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="client">Client</label>
                            <select class="form-control" id="client" name="client" onchange="getClientTransaction(this.value)">

                                <?php

                                if (!empty($users)) { ?>
                                    <option value="">Select Client</option>

                                    <?php
                                    foreach ($users as $user) { ?>
                                        <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . '(' . $user->name . ")"; ?></option>

                                <?php }
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collection">Collection</label>
                            <select class="form-control" id="collection" name="collection">
                                <option value="">CASH A/C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collection_date">Date</label>
                            <input type="date" class="form-control" id="collection_date" name="collection_date" value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collection_amt">Amount</label>
                            <input type="numer" class="form-control" id="collection_amt" name="collection_amt" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collection_type">Payment Type</label>
                            <select class="form-control" id="collection_type" name="collection_type">
                                <option value="">Payment Type</option>
                                <option value="DIYA">PAYMENT - DIYA</option>
                                <option value="LIYA">RECEIPT - LIYA</option>


                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="collection_remark">Remark</label>
                            <input type="text" class="form-control" id="collection_remark" name="collection_remark" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom:5px;">
                        <button type="submit" class="btn btn-info btn-sm pull-right">Submit</button>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card" id="transaction_data" style="background:#fff;display:none;">

    </div>


</div>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    function getClientTransaction(user_id) {
        var validator = $("#settlement-form").validate();
        validator.resetForm();
        $.ajax({
            url: base_url + "admin/Reports/getClientTransaction",
            method: "POST",
            data: {
                user_id: user_id,
            },
            dataType: "json",
            beforeSend: function() {
                blockUI();
            },
            complete: function() {
                $.unblockUI();
            },
            success: function(data) {


                $('#transaction_data').html(data).show();
            },
        });
    }


    $(document).ready(function() {
        $("#settlement-form").validate({
            rules: {
                client: {
                    required: true,
                },
                collection_date: {
                    required: true,
                },
                collection_amt: {
                    required: true,

                },
                collection_type: {
                    required: true,

                },
                collection_remark: {
                    required: true,

                }
            },

            submitHandler: function(form, event) {
                $(this).off(event);
                event.preventDefault();

                var chips = $('#collection_amt').val();
                var narration = $('#collection_remark').val();
                var userId = $('#client').val();
                var CrDr = $('#collection_type').val();



                console.log('data', {
                    chips: chips,
                    narration: narration,
                    userId: userId,
                    CrDr: CrDr
                });
                // return false;
                // $("#settlement-form").modal("hide");
                // $("#settlement-form").trigger("reset");


                $.ajax({
                    url: base_url + "admin/Reports/addsettlementNew",
                    method: "POST",
                    data: {
                        chips: chips,
                        narration: narration,
                        userId: userId,
                        CrDr: CrDr
                    },
                    dataType: "json",
                    beforeSend: function() {
                        blockUI();
                    },
                    complete: function() {
                        $.unblockUI();
                    },
                    success: function(data) {

                        getClientTransaction(userId);
                        if (data.success) {

                            new PNotify({
                                title: "Success",
                                text: "settlement successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });

                            // setTimeout(function() {
                            //     window.location.reload(1);
                            // }, 2000);
                        } else {
                            new PNotify({
                                title: "Error",
                                text: data.message,
                                styling: "bootstrap3",
                                type: "error",

                                delay: 3000,
                            });
                            // setTimeout(function() {
                            //     window.location.reload(1);
                            // }, 2000);
                        }
                    },
                });
                return false;
            },
        });
    })


    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function deleteSettlementEntry(ref_id){
        var conf = confirm('Are you sure you want to delete this Settlement entry?');
        var userId = $('#client').val();

        if(conf)
        {
            $.ajax({
                    url: base_url + "admin/Reports/deleteSettlementEntry",
                    method: "POST",
                    data: {
                        ref_id: ref_id,
                      
                    },
                    dataType: "json",
                    beforeSend: function() {
                        blockUI();
                    },
                    complete: function() {
                        $.unblockUI();
                    },
                    success: function(data) {

                        getClientTransaction(userId);
                        if (data.success) {

                            new PNotify({
                                title: "Success",
                                text: "settlement entry deleted successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });

                            // setTimeout(function() {
                            //     window.location.reload(1);
                            // }, 2000);
                        } else {
                            new PNotify({
                                title: "Error",
                                text: data.message,
                                styling: "bootstrap3",
                                type: "error",

                                delay: 3000,
                            });
                            // setTimeout(function() {
                            //     window.location.reload(1);
                            // }, 2000);
                        }
                    },
                })
        }
    }
</script>