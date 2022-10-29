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

                        <div class="alert alert-danger">
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
                        $attributes = array('name' => 'employee-form', 'id' => 'employee-form', 'class' => 'employee-form form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>
                        <input type="hidden" name="employee_id" id="employee_id" value="<?php echo !empty($employee_id) ? $employee_id : '' ?>">

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 validate-required">
                                    <label for="employee_name" class=" col-form-label">Employee Name</label>
                                    <?php
                                    $data = array(
                                        'name' => 'employee_name',
                                        'id' => 'employee_name',
                                        'value' => set_value('employee_name', empty($employee_name) ? NULL : $employee_name),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Employee Name',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group col-md-6 validate-required">
                                    <label for="father_name" class="col-form-label">Father/Husband</label>

                                    <?php
                                    $data = array(
                                        'name' => 'father_name',
                                        'id' => 'father_name',
                                        'value' => set_value('father_name', empty($father_name) ? NULL : $father_name),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Father/Husband Name',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 validate-required">
                                    <label for="contact_no" class="col-form-label">Contact No.</label>
                                    <?php
                                    $data = array(
                                        'type' => 'number',
                                        'name' => 'contact_no',
                                        'id' => 'contact_no',
                                        'value' => set_value('contact_no', empty($contact_no) ? NULL : $contact_no),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Contact No',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>


                                <div class="form-group col-md-6 validate-required">
                                    <label for="whatsapp_no" class="col-form-label">Whatsapp No.</label>

                                    <?php
                                    $data = array(
                                        'type' => 'number',
                                        'name' => 'whatsapp_no',
                                        'id' => 'whatsapp_no',
                                        'value' => set_value('whatsapp_no', empty($whatsapp_no) ? NULL : $whatsapp_no),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Whatsapp No.',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 validate-required">

                                    <label for="guardian_contact_no" class="col-form-label">G. Contact No.</label>
                                    <?php
                                    $data = array(
                                        'type' => 'number',

                                        'name' => 'guardian_contact_no',
                                        'id' => 'guardian_contact_no',
                                        'value' => set_value('guardian_contact_no', empty($guardian_contact_no) ? NULL : $guardian_contact_no),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Guardian Contact No.',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                                <div class="form-group col-md-6 validate-required">
                                    <label for="employee_image" class=" col-form-label">Image</label>

                                    <?php
                                    $data = array(
                                        'name' => 'employee_image',
                                        'id' => 'employee_image',
                                        'value' => set_value('employee_image', empty($employee_image) ? NULL : $employee_image),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => '',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_upload($data);
                                    ?>
                                </div>


                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 validate-required">
                                    <label for="email" class="col-form-label">Email</label>
                                    <?php
                                    $data = array(
                                        'type' => 'email',
                                        'name' => 'email',
                                        'id' => 'email',
                                        'value' => set_value('email', empty($email) ? NULL : $email),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Email Address',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                                <div class="form-group col-md-6 validate-required">
                                    <label for="experience" class="col-form-label">Experience</label>
                                    <?php
                                    $data = array(
                                        'name' => 'experience',
                                        'id' => 'experience',
                                        'value' => set_value('experience', empty($experience) ? NULL : $experience),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Working Experience',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 validate-required">
                                    <label for="last_company" class="col-form-label">Last Company</label>
                                    <?php
                                    $data = array(
                                        'name' => 'last_company',
                                        'id' => 'last_company',
                                        'value' => set_value('last_company', empty($last_company) ? NULL : $last_company),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Last Compnay Address',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                                <div class="form-group col-md-6 validate-required">
                                    <label for="monthly_salary" class=" col-form-label">Monthly
                                        Salary</label>
                                    <?php
                                    $data = array(
                                        'name' => 'monthly_salary',
                                        'id' => 'monthly_salary',
                                        'value' => set_value('monthly_salary', empty($monthly_salary) ? NULL : $monthly_salary),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Monthly Salary',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 validate-required">
                                    <label for="username" class="col-form-label">Username</label>
                                    <?php

                                    if (!empty($employee_id)) {
                                        $data = array(
                                            'name' => 'username',
                                            'id' => 'username',
                                            'value' => set_value('username', empty($username) ? NULL : $username),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Employee Username',
                                            'autofocus' => 'autofocus',
                                            'readonly' => true
                                        );
                                        echo form_input($data);
                                    } else {
                                        $data = array(
                                            'name' => 'username',
                                            'id' => 'username',
                                            'value' => set_value('username', empty($username) ? NULL : $username),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Employee Username',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                    }

                                    ?>
                                </div>

                                <div class="form-group col-md-6 validate-required">
                                    <label for="password" class=" col-form-label">Password</label>
                                    <?php
                                    $data = array(
                                        'name' => 'password',
                                        'id' => 'password',
                                        'value' => set_value('password', empty($password) ? NULL : $password),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Password',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 validate-required">
                                    <label for="username" class="col-form-label">Address</label>
                                    <?php
                                    $data = array(
                                        'name' => 'address',
                                        'id' => 'address',
                                        'value' => set_value('address', empty($address) ? NULL : $address),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Employee Address',
                                        'autofocus' => 'autofocus',
                                        'style' => 'height:125px;'
                                    );
                                    echo form_textarea($data);
                                    ?>
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
    $(document).ready(function() {
        var base_url = "<?php echo base_url(); ?>";
        $("#employee-form").validate({
            ignore: [],
            rules: {
                "employee_name": "required",
                "father_name": "required",
                "contact_no": "required",
                "whatsapp_no": "required",
                "guardian_contact_no": "required",
                "email": "required",
                "experience": "required",
                "username": {
                    "required": true,

                    remote: {
                        url: base_url + "admin/employee/check_username_exists",
                        type: "post",
                        data: {
                            email: function() {
                                return $("#username").val();
                            }

                        }
                    }
                },

                "address": "required",
            },
            messages: {
                "username": {
                    // "required": "Please enter  Customer" ,
                    // "email": "Please enter valid Email",
                    remote: 'Username already in use.',
                },

            }
        });
    });

    function getSubCategoryArray(category_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/getsubcategory",
            method: "POST",
            dataType: "json",
            data: {
                category_id: category_id
            },
            success: function(response) {
                console.log(response);
                $('#sub_category_id').html(response);
            }
        })
    }
</script>