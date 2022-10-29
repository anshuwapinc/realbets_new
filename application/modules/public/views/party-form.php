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
                        $attributes = array('name' => 'party-form', 'id' => 'party-form', 'class' => 'sub-category-form form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>
                        <input type="hidden" name="party_id" id="party_id" value="<?php echo !empty($party_id) ? $party_id : '' ?>">

                        <div class="card-body">
                            <fieldset class="border p-2" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Party Details</legend>
                                <div class="row">
                                    <!-- <div class="form-group col-md-6 validate-required"> <label for="customer_code" class=" col-form-label">Customer Code</label>
                                        <?php

                                        // if (!empty($party_id)) {
                                        //     $data = array(
                                        //         'name' => 'customer_code',
                                        //         'id' => 'customer_code',
                                        //         'value' => set_value('customer_code', empty($customer_code) ? NULL : $customer_code),
                                        //         'class' => ' form-control input-block-level',
                                        //         'placeholder' => 'Enter Customer Code',
                                        //         'autofocus' => 'autofocus',
                                        //         'readonly' => true
                                        //     );
                                        // } else {
                                        //     $data = array(
                                        //         'name' => 'customer_code',
                                        //         'id' => 'customer_code',
                                        //         'value' => set_value('customer_code', empty($customer_code) ? NULL : $customer_code),
                                        //         'class' => ' form-control input-block-level',
                                        //         'placeholder' => 'Enter Customer Code',
                                        //         'autofocus' => 'autofocus',
                                        //     );
                                        // }

                                        // echo form_input($data);
                                        ?>
                                    </div> -->

                                    <div class="form-group col-md-12 validate-required">
                                        <label for="company_name" class=" col-form-label">Company Name</label>
                                        <?php
                                        $data = array(
                                            'name' => 'company_name',
                                            'id' => 'company_name',
                                            'value' => set_value('company_name', empty($company_name) ? NULL : $company_name),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Company Name',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6 validate-required"> <label for="owner_name" class="col-form-label">Owner Name</label>
                                        <?php
                                        $data = array(
                                            'name' => 'owner_name',
                                            'id' => 'owner_name',
                                            'value' => set_value('owner_name', empty($owner_name) ? NULL : $owner_name),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Owner Name',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>

                                    <div class="form-group col-md-6 validate-required">
                                        <label for="mobile_number" class=" col-form-label">Mobile No.</label>
                                        <?php
                                        $data = array(
                                            'type' => 'number',

                                            'name' => 'mobile_number',
                                            'id' => 'mobile_number',
                                            'value' => set_value('mobile_number', empty($mobile_number) ? NULL : $mobile_number),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Mobile No.',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>

                                </div>

                                <div class=" row">
                                    <div class="form-group col-md-6 validate-required">
                                        <label for="gstin_num" class=" col-form-label">GSTIN No.</label>
                                        <?php
                                        $data = array(
                                            'name' => 'gstin_num',
                                            'id' => 'gstin_num',
                                            'value' => set_value('gstin_num', empty($gstin_num) ? NULL : $gstin_num),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter GSTIN No.',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>

                                    <div class="form-group col-md-6 validate-required">
                                        <label for="pan_num" class="col-form-label">PAN No.</label>
                                        <?php
                                        $data = array(
                                            'name' => 'pan_num',
                                            'id' => 'pan_num',
                                            'value' => set_value('pan_num', empty($pan_num) ? NULL : $pan_num),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter PAN No.',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-6 validate-required">
                                        <label for="email" class=" col-form-label">Email</label>

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
                                        <label for="whatsapp_number" class=" col-form-label">Whatsapp No.</label>

                                        <?php
                                        $data = array(
                                            'type' => 'number',
                                            'name' => 'whatsapp_number',
                                            'id' => 'whatsapp_number',
                                            'value' => set_value('whatsapp_number', empty($whatsapp_number) ? NULL : $whatsapp_number),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Whatsapp No.',
                                            'autofocus' => 'autofocus',
                                        );
                                        echo form_input($data);
                                        ?>
                                    </div>

                                </div>
                            </fieldset>
                            <fieldset class="border p-2" id="extra_contact_items" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Additional Contact Details</legend>
                                <input type="hidden" name="count" id="count" value='1' />
                                <div class="contact-details">
                                    <?php echo $extra_contact; ?>

                                </div>
                                <!-- <div clsas="row">

                                    <center><button type="button" class="btn btn-success btn-sm" id="add-contact"><i class="fa fa-plus"></i> Add More</button></center>
                                </div> -->
                            </fieldset>
                            <fieldset class="border p-2" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Company Address Details</legend>
                                <div class="row">

                                    <div class="form-group col-md-6 validate-required">
                                        <label for="company_city" class=" col-form-label">State</label>
                                        <?php
                                        echo form_dropdown('company_state', empty($company_state_arr) ? array() : $company_state_arr, empty($company_state) ? NULL : $company_state, ' id = "company_state" class="form-control select2bs4" onchange="getCompanyCityArray(this.value)" ');
                                        ?>
                                    </div>

                                    <div class="form-group col-md-6 validate-required">
                                        <label for="company_city" class=" col-form-label">City</label>
                                        <?php
                                        echo form_dropdown('company_city', empty($company_city_arr) ? array() : $company_city_arr, empty($company_city) ? NULL : $company_city, ' id = "company_city" class="form-control select2bs4"');
                                        ?>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 validate-required">
                                        <label for="username" class="col-form-label">Address</label>
                                        <?php
                                        $data = array(
                                            'name' => 'company_address',
                                            'id' => 'company_address',
                                            'value' => set_value('company_address', empty($company_address) ? NULL : $company_address),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Company Address',
                                            'autofocus' => 'autofocus',
                                            'style' => 'height:115px;'
                                        );
                                        echo form_textarea($data);
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="border p-2" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Shipping Details</legend>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label style="cursor:pointer;"><input type="checkbox" name="same_as" id="same_as" /> Same As Company Address</label>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 validate-required">
                                        <label for="shipping_state" class="col-form-label">State</label>
                                        <?php
                                        echo form_dropdown('shipping_state', empty($shipping_state_arr) ? array() : $shipping_state_arr, empty($shipping_state) ? NULL : $shipping_state, ' id = "shipping_state" class="form-control select2bs4" onchange="getShippingCityArray(this.value)" ');
                                        ?>
                                    </div>
                                    <div class="form-group col-md-6 validate-required">
                                        <label for="shipping_city" class=" col-form-label">City</label>
                                        <?php
                                        echo form_dropdown('shipping_city', empty($shipping_city_arr) ? array() : $shipping_city_arr, empty($shipping_city) ? NULL : $shipping_city, ' id = "shipping_city" class="form-control select2bs4" ');
                                        ?>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 validate-required">
                                        <label for="username" class=" col-form-label">Address</label>

                                        <?php
                                        $data = array(
                                            'name' => 'shipping_address',
                                            'id' => 'shipping_address',
                                            'value' => set_value('shipping_address', empty($shipping_address) ? NULL : $shipping_address),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Shipping Address',
                                            'autofocus' => 'autofocus',
                                            'style' => 'height:115px;'
                                        );
                                        echo form_textarea($data);
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
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

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    $(document).ready(function() {

        // $('.select2').select2();

        //Initialize Select2 Elements


        var base_url = "<?php echo base_url(); ?>";
        $("#party-form").validate({
            ignore: [],
            rules: {
                // "customer_code": {
                //     "required": true,

                //     remote: {
                //         url: base_url + "admin/party/check_party_exists",
                //         type: "post",
                //         data: {
                //             email: function() {
                //                 return $("#customer_code").val();
                //             }

                //         }
                //     }
                // },

                "owner_name": "required",
                "mobile_number": "required",
                // "gstin_num": "required",
                // "pan_num": "required",
                "email": "required",
                "whatsapp_number": "required",
                "company_city": "required",
                "company_address": "required",
                "company_state": "required",
                "shipping_city": "required",
                "shipping_address": "required",
                "shipping_state": "required",
            },
            messages: {
                // "customer_code": {
                //     // "required": "Please enter  Customer" ,
                //     // "email": "Please enter valid Email",
                //     remote: 'Customer Code already in use.',
                // },
                "title": "Sub Category Title is required",
                "tax_id": "Category is required"
            }
        });
    });

    function getCompanyCityArray(state_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/getCity",
            method: "POST",
            dataType: "json",
            data: {
                state_id: state_id
            },
            success: function(response) {
                console.log(response);
                $('#company_city').html(response);
            }
        })
    }

    function getShippingCityArray(state_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/getCity",
            method: "POST",
            dataType: "json",
            data: {
                state_id: state_id
            },
            success: function(response) {
                console.log(response);
                $('#shipping_city').html(response);
            }
        })
    }

    $(".remove-contact").click(function(event) {
        event.preventDefault();
        $(this).parent().parent().remove();

    });

    $("#add-contact").click(function(event) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/addExtraContact",
            success: function(response) {
                console.log(response);
                $('.contact-details').append(response);
                console.log($('.contact-details').html());

                $(".remove-contact").click(function(event) {
                    event.preventDefault();
                    $(this).parent().parent().remove();
                });

            }
        })
    })


    $(document).on('keydown', "input[name='contact_address[]']", function(e) {
        var check_last = $(this).parent().parent().parent().is(':last-child');
        // console.log("HERE" + parent);
        // var check_last = $('.' + parent).is(':last-child');
        var count = $('#count').val();
        if (check_last) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 9) {
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/addExtraContact",
                    success: function(response) {
                        console.log(response);
                        $('.contact-details').append(response);
                        console.log($('.contact-details').html());
                        $('#count').val(parseInt(count) + parseInt(1));
                        $('#contact-details div:last-child').find("input[name='person_name[]']").focus()
                        console.log('HEREEE;' + JSON.stringify($('#contact-details div:last-child').find("input[name='person_name[]']").focus()));
                        $(".remove-contact").click(function(event) {
                            event.preventDefault();
                            $(this).parent().parent().remove();
                        });

                    }
                })
            }
        }
    });

    $('input[name="same_as"]').click(function() {
        if ($(this).is(":checked")) {
            var company_state = $('#company_state').val();
            var company_city = $('#company_city').val();
            var company_address = $('#company_address').val();

            var company_city_html = $('#company_city').html();


            $('#shipping_state').val(company_state);
            $('#shipping_city').html(company_city_html);
            $('#shipping_city').val(company_city);
            $('#shipping_address').val(company_address);


            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

        } else if ($(this).is(":not(:checked)")) {
            $('#shipping_state').val('');
            $('#shipping_city').html('');
            $('#shipping_city').val('');
            $('#shipping_address').val('');


            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

        }
    });
</script>