<main id="main" class="main-content">
    <div class="row" style="background:#fff;padding:10px">
        <div class=" col-sm-12">
            <div class="add-account">
                <h2 class="m-b-20"><?php echo $request_type ?> Request</h2>
                <?php

                if (!empty($this->session->flashdata('user_add_msg'))) {
                ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('user_add_msg'); ?>
                    </div>
                <?php
                }


                if (!empty($this->session->flashdata('user_add_error'))) {
                ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('user_add_error'); ?>
                    </div>
                <?php
                }



                $errors = validation_errors();


                if (!empty($errors)) {
                ?>
                    <div class="alert alert-danger ">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $errors; ?>
                    </div>
                <?php
                } ?>

                <form id="deposit-request-form" name="deposit-request-form" method="post" action="<?php echo current_url() ?>">
                    <div class="row">
                        <input type="hidden" name="request_type" id="request_type" value="<?php echo $request_type; ?>" />
                        <div class="col-md-12 account-detail">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="type" class="col-form-label">Payment Type</label>
                                        <input type="hidden" id="id" name="id" value="<?php echo empty($id) ? "" : $id ?>" />
                                        <?php
                                        echo form_dropdown('type', empty($type_arr) ? array() : $type_arr, empty($type) ? NULL : $type, ' id = "type" class="form-control input-block-level select2bs4" autofocus="autofocus" required');
                                        ?>
                                    </div>

                                    <div id="bank_method" style="display: none;">

                                        <div class="form-group">
                                            <label for="bank_account_no" class="col-form-label">Account No.</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'bank_account_no',
                                                'id' => 'bank_account_no',
                                                'value' => set_value('bank_account_no', empty($bank_account_no) ? NULL : $bank_account_no),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Account Number',

                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="bank_account_holder_name" class="col-form-label">Account Holder Name</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'bank_account_holder_name',
                                                'id' => 'bank_account_holder_name',
                                                'value' => set_value('bank_account_holder_name', empty($bank_account_holder_name) ? NULL : $bank_account_holder_name),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Account Holder Name ',

                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="ifsc" class="col-form-label">IFSC Code</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'ifsc',
                                                'id' => 'ifsc',
                                                'value' => set_value('ifsc', empty($ifsc) ? NULL : $ifsc),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter IFSC Code',

                                            );
                                            echo form_input($data);
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="bank_name" class="col-form-label">Bank Name</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'bank_name',
                                                'id' => 'bank_name',
                                                'value' => set_value('bank_name', empty($bank_name) ? NULL : $bank_name),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Bank Name',

                                            );
                                            echo form_input($data);
                                            ?>
                                        </div>
                                    </div>
                                    <div id="other_method" style="display: none;">

                                        <div class="form-group">
                                            <label for="account_no" class="col-form-label"><span class="other_payment_mode"></span></label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'account_no',
                                                'id' => 'account_no',
                                                'value' => set_value('account_no', empty($account_no) ? NULL : $account_no),
                                                'class' => ' form-control input-block-level account_no',
                                                'placeholder' => 'Enter Account Number',
                                                'maxlength' => '10',
                                                                                        );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <?php if ($withdraw_type == "No") { ?>
                                            <div class="form-group" id="otpBox">
                                                <div class="d-flex">
                                                    <div style="width:68%">
                                                        <label class="text-success" id="otp_status"></label>
                                                    </div>
                                                    <div style="width:32%">
                                                        <span id="resend_text"><button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" id="send_otp_btn" style="float:right">Send OTP</button></span>
                                                        <!-- <label class='text-info text-center' id="resend_text">resend in 30sec</label> -->
                                                        <!-- <label class="text-success">Verified</label> -->
                                                    </div>
                                                </div>
                                                <!-- <label><span class="text-success">Otp send,Please verify!</span><span style="padding-left:44px">resend in 30sec</span></label> -->
                                                <input type="tel" maxlength="5" minlength="5" name="otp" id="otp" placeholder="Enter 5 Digit OTP" class="form-control user_input">
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="account_holder_name" class="col-form-label"><span class="other_payment_mode"></span> Holder Name</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'account_holder_name',
                                                'id' => 'account_holder_name',
                                                'value' => set_value('account_holder_name', empty($account_holder_name) ? NULL : $account_holder_name),
                                                'class' => ' form-control input-block-level account_holder_name',
                                                'placeholder' => 'Enter Account Holder Name ',

                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                    </div>
                                    <div id="user_fill_detail" style="display: none;">
                                        <hr />
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-form-label">Amount</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',

                                                'name' => 'amount',
                                                'id' => 'amount',
                                                'value' => set_value('amount', empty($amount) ? NULL : $amount),
                                                'class' => ' form-control input-block-level ',
                                                'placeholder' => 'Enter Amount',

                                            );
                                            echo form_input($data);
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-12">
                            <div class="float-right">

                                <button class="btn btn-submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div style="padding-top:15px;padding-left:5px">
        <p><strong>Note :-</strong><br />
            <span style="padding-left:10px">Withdrawal Time -- 12:00 pm to 12:00 am</span><br />
            <span style="padding-left:10px">Withdraw will be given according to king level </span>
        </p>
    </div>
    <div class="row" style="background:#fff;padding:10px">
        <div class=" col-sm-12">
            <div class="table-responsive data-table" id="transaction_history">

            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    $(document).ready(function() {

        get_direct_transaction_history();

        $("#deposit-request-form").validate({
            ignore: [],
            errorContainer: $('#errorContainer'),
            errorLabelContainer: $('#errorContainer ul'),
            wrapper: 'li',
            onfocusout: false,
            rules: {

                amount: {
                    required: true,

                    range: [300, 1000000000000000000000000000000000]

                },

                preffered_method: {
                    required: true,

                },

            },
            messages: {

                amount: {
                    required: "Amount is required",
                    range: "Minimum Withdrawal is 300",


                },
                preffered_method: {
                    required: "Preffered method is required",
                },
            },
        });

        $("#type").on('change', function(e) {
            var type = $("#type").val();
            console.log(type);
            if (type == 'Bank') {

                $("#other_method").hide();
                $("#bank_method").show();
                $("#user_fill_detail").show();
            } else {

                $(".other_payment_mode").text(type);

                $(".account_holder_name").attr('placeholder', 'Enter ' + type + ' Holder Name');
                $(".account_no").attr('placeholder', 'Enter ' + type + ' number');

                $("#bank_method").hide();
                $("#other_method").show();
                $("#user_fill_detail").show();
            }
        });
    });

    function get_direct_transaction_history() {
        var payment_type = 'Withdraw';

        // showLoading();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Transactions/get_direct_transaction_history',
            data: {
                payment_type: payment_type,
            },
            type: "POST",
            success: function(res) {
                console.log(res);
                $('#transaction_history').html(res);
            }
        });
    }
</script>


<script>
    var resend_function;

    // $('#account_no').keyup(function(e) {
    //     var ac = $('#account_no').val();
    //     var length = ac.length;
    //     if (length == 10) {
    //         alert('ji');
    //         getOtp();
    //     }
    // })

    function getOtp() {
        $("#otp_status").text('Otp send,Please verify!');
        $("#send_otp_btn").prop('disabled', 'true');
        resend_otp_timer_function();
        var number = $('#account_no').val();
        $.ajax({
            url: "<?php echo base_url(); ?>login/Admin/sendOtp",
            data: {
                number: number
            },
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function(output) {

            }
        });
    }


    function resend_otp_timer_function() {
        var sec_count = "30";

        resend_function = setInterval(function() {
            if (sec_count == "0") {
                $("#resend_text").html('<button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" style="float:right">Resend OTP</button>');
                $("#otp_status").text('');
                clearInterval(resend_function);
            } else {
                $("#resend_text").text('resend in ' + sec_count + 'sec');
                sec_count--;
            }
        }, 1000);
    }
</script>