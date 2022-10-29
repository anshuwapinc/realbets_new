<main id="main" class="main-content">  
<div class="container-fluid"> 
    <div class="add-account">
        <h2 class="m-b-20">Add Payment</h2>
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

        <div id="errorContainer">

            <p id="error-container-heading">Please correct the following errors and try again:</p>

            <ul></ul>

        </div>


        <form id="payment-method-form" name="payment-method-form" method="post" action="<?php echo current_url() ?>">
            <div class="row">

                <div class="col-md-12 account-detail">


                    <div class="form-group">
                        <label for="type" class="col-form-label">Payment Type</label>
                        <input type="hidden" id="id" name="id" value="<?php echo empty($id) ? "" : $id ?>" />
                        <?php
                        echo form_dropdown('type', empty($type_arr) ? array() : $type_arr, empty($type) ? NULL : $type, ' id = "type" class="form-control input-block-level select2bs4" autofocus="autofocus" required');
                        ?>
                    </div>

                    <div id="bank_method" style="display: none;">

                        <div class="form-group">
                            <label for="account_number" class="col-form-label">Account No.</label>
                            <?php
                            $data = array(
                                'type' => 'text',
                                'name' => 'account_number',
                                'id' => 'account_number',
                                'value' => set_value('account_number', empty($account_number) ? NULL : $account_number),
                                'class' => ' form-control input-block-level',
                                'placeholder' => 'Enter Account Number',

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
                            <label for="other_account_no" class="col-form-label"><span class="other_payment_mode"></span></label>
                            <?php
                            $data = array(
                                'type' => 'text',
                                'name' => 'other_account_no',
                                'id' => 'other_account_no',
                                'value' => set_value('other_account_no', empty($other_account_no) ? NULL : $other_account_no),
                                'class' => ' form-control input-block-level account_no',
                                'placeholder' => 'Enter Account Number',

                            );

                            echo form_input($data);

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="other_account_holder_name" class="col-form-label"><span class="other_payment_mode"></span> Holder Name</label>
                            <?php
                            $data = array(
                                'type' => 'text',
                                'name' => 'other_account_holder_name',
                                'id' => 'other_account_holder_name',
                                'value' => set_value('other_account_holder_name', empty($other_account_holder_name) ? NULL : $other_account_holder_name),
                                'class' => ' form-control input-block-level account_holder_name',
                                'placeholder' => 'Enter Account Holder Name ',

                            );

                            echo form_input($data);

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t-20">
                <div class="col-md-12">
                    <div class="float-right">

                        <button class="btn btn-submit" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
                        </main>

<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {

            if ($("#id").val() != "") {
                if ($("#type").val() == 'Bank') {
                    $("#bank_method").show();
                } else {
                    $("#other_method").show();
                }
            }
        }, 500)


        $("#payment-method-form").validate({

            ignore: [],
            errorContainer: $('#errorContainer'),
            errorLabelContainer: $('#errorContainer ul'),
            wrapper: 'li',
            onfocusout: false,
            rules: {
                type: {
                    required: true,
                },
                account_number: {
                    required: function() {
                        if ($("#type").val() == 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },
                account_holder_name: {
                    required: function() {
                        if ($("#type").val() == 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                ifsc: {
                    required: function() {
                        if ($("#type").val() == 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },
                bank_name: {
                    required: function() {
                        if ($("#type").val() == 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },
                other_account_no: {
                    required: function() {
                        if ($("#type").val() != 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },
                other_account_holder_name: {
                    required: function() {
                        if ($("#type").val() != 'Bank') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },

            },
            messages: {
                type: {
                    required: "Account type is required",
                },
                account_number: {
                    required: "Account number/realed Id is required",
                },
                account_holder_name: {
                    required: "Account holder name is required",
                },
                ifsc: {
                    required: "IFSC code is required",
                },
                bank_name: {
                    required: "Bank Name is required",
                },
                other_account_no: {
                    required: "Account number/realed Id is required",
                },
                other_account_holder_name: {
                    required: "Account holder name is required",
                },
            },
        });

        $("#type").on('change', function(e) {
            var type = $("#type").val();
            console.log(type);
            if (type == 'Bank') {

                $("#other_method").hide();
                $("#bank_method").show();
            } else {

                $(".other_payment_mode").text(type);

                $(".account_holder_name").attr('placeholder', 'Enter ' + type + ' Holder Name');
                $(".account_no").attr('placeholder', 'Enter ' + type + ' number');

                $("#bank_method").hide();
                $("#other_method").show();
            }
        });
    });
</script>