<main id="main" class="main-content">

    <div class="row" style="background:#fff;padding:10px">
        <div class=" col-sm-12">
            <div class="add-account">
                <div style="border-bottom:1px solid ;margin-bottom:5px">
                <h2 class="m-b-20">Bonus Settings</h2>
                </div>
                <?php

                if (!empty($this->session->flashdata('operation_msg'))) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('operation_msg'); ?>
                            </div>
                        </div>
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
                        <input type="hidden" name="id" id="id" value="<?php echo !empty($id)?$id:""; ?>" />
                        <div class="col-md-12 account-detail">
                         
                        <div class="form-group">
                                <label for="signup_bonus" class="col-form-label">Sign-Up Bonus</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'signup_bonus',
                                    'id' => 'signup_bonus',
                                    'value' => set_value('signup_bonus', empty($signup_bonus) ? NULL : $signup_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Amount',
                                );
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="signup_referer_bonus" class="col-form-label">Referral Sign-Up Bonus</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'signup_referer_bonus',
                                    'id' => 'signup_referer_bonus',
                                    'value' => set_value('signup_referer_bonus', empty($signup_referer_bonus) ? NULL : $signup_referer_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Amount',
                                );
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="client_first_deposit_bonus" class="col-form-label">Bonus % for First Deposit Of Client</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'client_first_deposit_bonus',
                                    'id' => 'client_first_deposit_bonus',
                                    'value' => set_value('client_first_deposit_bonus', empty($client_first_deposit_bonus) ? NULL : $client_first_deposit_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Bonus % for First Deposit Of Client ',
                                );

                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="client_other_deposit_bonus" class="col-form-label">Bonus % for Other Deposit Of Client</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'client_other_deposit_bonus',
                                    'id' => 'client_other_deposit_bonus',
                                    'value' => set_value('client_other_deposit_bonus', empty($client_other_deposit_bonus) ? NULL : $client_other_deposit_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Bonus % for Other Deposit Of Client ',
                                );
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="referer_first_deposit_bonus" class="col-form-label">Bonus % for First Deposit Of Referer</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'referer_first_deposit_bonus',
                                    'id' => 'referer_first_deposit_bonus',
                                    'value' => set_value('referer_first_deposit_bonus', empty($referer_first_deposit_bonus) ? NULL : $referer_first_deposit_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Bonus % for First Deposit Of Referer ',
                                );

                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="referer_other_deposit_bonus" class="col-form-label">Bonus % for Other Deposit Of Referer</label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'referer_other_deposit_bonus',
                                    'id' => 'referer_other_deposit_bonus',
                                    'value' => set_value('referer_other_deposit_bonus', empty($referer_other_deposit_bonus) ? NULL : $referer_other_deposit_bonus),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter The Bonus % for Other Deposit Of Referer ',
                                );
                                echo form_input($data);
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="bonus_use_for_betting" class="col-form-label">Bonus % Use For Betting </label>
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'bonus_use_for_betting',
                                    'id' => 'bonus_use_for_betting',
                                    'value' => set_value('bonus_use_for_betting', empty($bonus_use_for_betting) ? NULL : $bonus_use_for_betting),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Enter Bonus % Use For Betting',
                                );
                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-12">
                            <div class="float-right">

                                <button class="btn btn-submit" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- 
<script type="text/javascript">
    $(document).ready(function() {



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

       
    });
</script> -->