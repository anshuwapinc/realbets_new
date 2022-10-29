<main id="main" class="main-content">

    <div class="row" style="background:#fff;padding:10px">
        <div class=" col-sm-12">
            <div class="add-account">
                <h2 class="m-b-20">Welcome Banner Message</h2>
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
                <?php if (!empty($welcome_note_banner_name)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo base_url('assets/welcome_note_banner/' . $welcome_note_banner_name) ?>" style="    height: auto; width: -webkit-fill-available;">
                            <a href="<?php echo base_url('delete-welcome-note-banner/'.$id) ?>" class="btn btn-danger" style="float: right; margin-top: 13px;">Delete</a>
                        </div>
                    </div>
                <?php } ?>
                <form id="deposit-request-form" name="deposit-request-form" method="post" enctype='multipart/form-data' action="<?php echo current_url() ?>">
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                        <div class="col-md-12 account-detail">

                            <div class="form-group">
                                <label for="welcome_note_banner" class="col-form-label">Upload Welcome Banner</label>
                                <?php
                                $data = array(
                                    'type' => 'file',

                                    'name' => 'welcome_note_banner',
                                    'id' => 'welcome_note_banner',
                                    'value' => set_value('welcome_note_banner', empty($welcome_note_banner) ? NULL : $welcome_note_banner),
                                    'class' => ' form-control input-block-level',
                                    'placeholder' => 'Upload banner',
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