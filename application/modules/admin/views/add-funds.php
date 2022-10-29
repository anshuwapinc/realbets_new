<style>
    label {
        color: #000;
    }
</style>
<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Add Funds
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class="card" style="background:#fff; margin-top:15px;">

                <div class="card-body" style="padding:15px;">
                    <div class="row" style="padding-bottom:15px;">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" name="amount" id="amount" style="width:100%;display:inline-block;" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Remark</label>
                                <input type="text" name="remark" id="remark" style="width:100%;display:inline-block;" class="form-control">

                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:15px;">
                        <div class="col-md-12 col-xs-12">
                            <button type="button" class="blue_button submit_user_setting pull-right" onclick="add_balance();">Add Balance</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>





<!-----------Chip Deposit Model---------------------------->
<script>
    function add_balance() {
        var amount = $('#amount').val().trim();
        var remark = $('#remark').val().trim();




        if (amount == '') {
            alert("Please enter valid amount");
            return false;
        } else if (remark == '') {
            alert("Please enter valid amount");
            return false;
        } else {
            $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: "<?php echo base_url(); ?>admin/User/add_balance",
                method: "POST",
                dataType: "json",
                data: {
                    amount: amount,
                },
                dataType: "json",
                success: function(data) {
                    $.unblockUI

                    if (data.success) {
                        new PNotify({
                            title: "Success",
                            text: "Balance Added successfully",
                            // type: data.notifytype,
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });
                    } else {
                        new PNotify({
                            title: "Oops",
                            text: "Something went wrong",
                            // type: data.notifytype,
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });
                    }


                    setTimeout(function() {
                        window.location.reload(1);
                    }, 2000);
                }

            })
        }

    }
</script>