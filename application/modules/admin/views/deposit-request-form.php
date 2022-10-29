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

                <form id="deposit-request-form" name="deposit-request-form" method="post" enctype='multipart/form-data' action="<?php echo current_url() ?>">
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
                                            <label for="account_no" class="col-form-label">Account No.</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'account_no',
                                                'id' => 'account_no',
                                                'value' => set_value('account_no', empty($account_no) ? NULL : $account_no),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Account Number',
                                                'readonly' => "readonly"
                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_holder_name" class="col-form-label">Account Holder Name</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'account_holder_name',
                                                'id' => 'account_holder_name',
                                                'value' => set_value('account_holder_name', empty($account_holder_name) ? NULL : $account_holder_name),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Account Holder Name ',
                                                'readonly' => "readonly"
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
                                                'readonly' => "readonly"
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
                                                'readonly' => "readonly"
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
                                                'name' => 'other_account_no',
                                                'id' => 'account_no_other',
                                                'value' => set_value('account_no', empty($other_account_no) ? NULL : $other_account_no),
                                                'class' => ' form-control input-block-level account_no',
                                                'placeholder' => 'Enter Account Number',
                                                'readonly' => "readonly"
                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="account_holder_name" class="col-form-label"><span class="other_payment_mode"></span> Holder Name</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',
                                                'name' => 'other_account_holder_name',
                                                'id' => 'account_holder_name_other',
                                                'value' => set_value('account_holder_name', empty($other_account_holder_name) ? NULL : $other_account_holder_name),
                                                'class' => ' form-control input-block-level account_holder_name',
                                                'placeholder' => 'Enter Account Holder Name ',
                                                'readonly' => "readonly"
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
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Amount',

                                            );
                                            echo form_input($data);
                                            ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="reference_code" class="col-form-label">Referance Code</label>
                                            <?php
                                            $data = array(
                                                'type' => 'text',

                                                'name' => 'reference_code',
                                                'id' => 'reference_code',
                                                'value' => set_value('reference_code', empty($reference_code) ? NULL : $reference_code),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Reference code ',
                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-form-label">Upload Screenshot Of Payment</label>
                                            <?php
                                            $data = array(
                                                'type' => 'file',

                                                'name' => 'screenshot',
                                                'id' => 'screenshot',
                                                'value' => set_value('screenshot', empty($screenshot) ? NULL : $screenshot),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Upload screenshot',
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
                    range: [100, 1000000000000000000000000000000000]
                },

                reference_code: {
                    required: true,

                },
                screenshot: {
                    required: true,
                },

            },
            messages: {

                amount: {
                    required: "Amount is required",
                    range: "Minimum Deposit is 100",

                },
                reference_code: {
                    required: "Preffered method is required",
                },
                screenshot: {
                    required: "upload screenshot",
                }
            },
        });

        $("#type").on('change', function(e) {
            var type = $("#type").val();
            console.log(type);
            $.ajax({
                url: base_url + "get-payment-detail",
                type: 'POST',
                data: {
                    'type': type
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    console.log(result);
                    if (result != null) {
                        if (type == 'Bank') {

                            $("#account_no").val(result['account_number']);
                            $("#account_holder_name").val(result['account_holder_name']);
                            $("#bank_name").val(result['vendor']);
                            $("#ifsc").val(result['ifsc_code']);
                            $("#other_method").hide();
                            $("#bank_method").show();
                            $("#user_fill_detail").show();
                        } else {

                            $("#account_no_other").val(result['account_number']);
                            $("#account_holder_name_other").val(result['account_holder_name']);



                            $(".other_payment_mode").text(type);
                            $(".account_holder_name").attr('placeholder', 'Enter ' + type + ' Holder Name');
                            $(".account_no").attr('placeholder', 'Enter ' + type + ' number');

                            $("#bank_method").hide();
                            $("#other_method").show();
                            $("#user_fill_detail").show();
                        }
               
                    } else {
                        alert("sorry for inconvient we are not accepting this mode of payment please try another payment mode");
                    }
                }

            })

        });
    });

    function get_direct_transaction_history() {
        var payment_type = 'Deposit';
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