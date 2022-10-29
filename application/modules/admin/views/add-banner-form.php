<main id="main" class="main-content">

    <div class="row" style="background:#fff;padding:10px">
        <div class=" col-sm-12">
            <div class="add-account">
                <h2 class="m-b-20"><?php echo !empty($form_heading)?$form_heading : "" ?></h2>
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
                <?php if (!empty($id)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo base_url('assets/banner/' . $header_banner_name) ?>" style="    height: auto; width: -webkit-fill-available;">                           
                        </div>
                    </div>
                <?php } ?>
                <form id="deposit-request-form" name="deposit-request-form" method="post" enctype='multipart/form-data' action="<?php echo current_url() ?>">
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                        <div class="col-md-12 account-detail">

                            <div class="form-group">
                                <label for="welcome_note_banner" class="col-form-label">Upload Header Banner</label>
                                <?php
                                $data = array(
                                    'type' => 'file',

                                    'name' => 'header_banner',
                                    'id' => 'header_banner',
                                    'value' => set_value('header_banner', empty($header_banner) ? NULL : $header_banner),
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
                            <a class="btn btn-danger" onclick="goBack();" >Back</a>
                            <?php if (!empty($id)) { ?>
                                <button class="btn btn-success" type="submit">Update</button>
                                <?php }else{
                                    ?>
                                    <button class="btn btn-success" type="submit">Add</button>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
