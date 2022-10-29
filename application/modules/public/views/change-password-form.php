<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding-top:15px;">


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <?php
                $errors = validation_errors();
                if (!empty($errors)) {
                ?>
                    <div class="col-md-12 ">

                        <div class="alert alert-danger  ">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <?php echo $errors; ?>
                        </div>
                    </div>
                <?php
                }
                // p($_SESSION['message'], 0);
                if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                ?>
                    <div class="col-md-12 ">

                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <?php echo $_SESSION['message']; ?>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $form_caption ?></h3>
                        </div>
                        <?php
                        $attributes = array('name' => 'change-password-form', 'id' => 'change-password-form', 'class' => 'form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>

                        <div class="card-body">
                            <div class="row">
                                <div class=" col-sm-4 ">

                                    <div class="form-group validate-required ">

                                        <label for="inputEmail3" class="col-form-label">Current Password</label>
                                        <?php
                                        $data = array(
                                            'type' => 'password',

                                            'name' => 'current_password',
                                            'id' => 'current_password',
                                            'value' => set_value('current_password', empty($current_password) ? NULL : $title),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Current Password',
                                            'autofocus' => 'autofocus',
                                        );

                                        echo form_input($data);

                                        ?>
                                    </div>
                                </div>

                                <div class=" col-sm-4 ">

                                    <div class="form-group validate-required ">

                                        <label for="inputEmail3" class=" col-form-label">Password</label>

                                        <?php
                                        $data = array(
                                            'type' => 'password',
                                            'name' => 'password',
                                            'id' => 'password',
                                            'value' => set_value('password', empty($password) ? NULL : $password),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter New Password',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);

                                        ?>
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">

                                    <div class="form-group validate-required ">

                                        <label for="inputEmail3" class=" col-form-label">Confirm Password</label>

                                        <?php
                                        $data = array(
                                            'type' => 'password',

                                            'name' => 'repeat_password',
                                            'id' => 'repeat_password',
                                            'value' => set_value('repeat_password', empty($repeat_password) ? NULL : $repeat_password),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Confirm Password',
                                            'autofocus' => 'autofocus',
                                        );

                                        echo form_input($data);

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Submit</button>

                        </div>
                        <!-- /.card-footer -->
                        <?php
                        echo form_close();
                        ?>
                    </div>
                    <!-- /.card -->

                </div>

            </div>
            <!-- /.card -->
        </div>

    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    function tax_calculate(value) {
        $('#igst').val(value);
        $('#sgst').val(parseFloat(value) / 2);
        $('#cgst').val(parseFloat(value) / 2);
    }
    $(document).ready(function() {



        var base_url = "<?php echo base_url(); ?>";



        $("#change-password-form").validate({
            rules: {
                "current_password": {
                    "required": true,

                    remote: {
                        url: base_url + "login/Admin/check_user_password",
                        type: "post",
                        data: {
                            email: function() {
                                return $("#current_password").val();
                            }

                        }
                    }
                },
                "password": "required",
                "repeat_password": {
                    "required": true,
                    "equalTo": '#password'
                }
            },
            messages: {
                "current_password": {
                    "required": "Enter Current Password" ,
                       remote: 'Current password not valid.',
                },
                "password": "Enter New Password",
                "repeat_password": {
                    "required": "re-enter your password",
                    "equalTo": 'Password and confirm password not match'
                }
            }
        });
    });
</script>