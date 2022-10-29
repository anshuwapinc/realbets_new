<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding-top:15px;">


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <!-- <div class="col-md-12  "> -->
                <!-- <form role="form" class="registration-form" action="javascript:void(0);"> -->
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $form_caption ?></h3>
                        </div>
                        <?php
                        $attributes = array('name' => 'team-form', 'id' => 'team-form', 'class' => 'form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>

                        <div class="card-body">
                            <input type="hidden" name="prediction_master_id" value="<?php echo $prediction_master_id; ?>" />
                            <?php
                            if ($prediction_master_field_record) {
                                foreach ($prediction_master_field_record as $record) {

                            ?>

                                    <div class="row">
                                        <input type="hidden" name="prediction_master_field_id[]" value="<?php echo $record['prediction_master_field_id']; ?>" />
                                        <input type="hidden" name="user_entry_id[]" value="<?php 
                                        if(isset($record['user_entry_id']))
                                        {
                                            echo $record['user_entry_id'];
                                        }
                                         ?>" />

                                        <input type="hidden" name="field_type[]" value="<?php echo $record['field_type']; ?>" />
                                        <div class="form-group col-md-4 col-sm-4">

                                            <?php
                                            $data = array(
                                                'name' => 'prediction_field_title[]',
                                                'value' => set_value('prediction_field_title', empty($record['prediction_field_title']) ? NULL : $record['prediction_field_title']),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Field Title',
                                                'autofocus' => 'autofocus',
                                                'readonly' => 'true'
                                            );

                                            echo form_input($data);
                                            ?>


                                            <!-- <input type="text" class="form-control" name="prediction_field_title[]" required placeholder="Field Title"> -->
                                        </div>


                                        <div class="form-group col-md-4 col-sm-4">

                                            <?php
                                            $data = array(
                                                'name' => 'variation[]',
                                                'value' => set_value('variation', empty($record['variation']) ? NULL : $record['variation']),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Field Title',
                                                'autofocus' => 'autofocus',
                                                'readonly' => 'true'

                                            );

                                            echo form_input($data);
                                            ?>



                                            <!-- <input type="text" class="form-control" name="variation[]" required placeholder="Field Variation Value"> -->
                                        </div>

                                        <div class="form-group col-md-4 col-sm-4">

                                            <?php
 ;
                                            if ($record['field_type'] === '1') {

                                                echo form_dropdown('field_value[]', empty($first_team_arr)  && $add ? array() : $first_team_arr, empty($record['user_field_value']) ? NULL : $record['user_field_value'], '  class="form-control select2bs4" style="width:100% !important;"');
                                            } else if ($record['field_type'] === '2') {
                                                echo form_dropdown('field_value[]', empty($players_arr)  && $add ? array() : $players_arr, empty($record['user_field_value']) ? NULL : $record['user_field_value'], '  class="form-control select2bs4" style="width:100% !important;"');
                                            } else if ($record['field_type'] === '3') {
                                                $data = array(
                                                    'name' => 'field_value[]',
                                                    'value' => set_value('field_value', empty($record['user_field_value']) && $add ? NULL : $record['user_field_value']),
                                                    'class' => ' form-control input-block-level',
                                                    'placeholder' => 'Run/Ball',
                                                    'autofocus' => 'autofocus',

                                                );
                                                echo form_input($data);
                                            }

                                            ?>



                                            <!-- <input type="text" class="form-control" name="variation[]" required placeholder="Field Variation Value"> -->
                                        </div>
                                    </div>
                            <?php }
                            }
                            ?>



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


        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        $("#team-form").validate({
            ignore: [],
            rules: {
                "team_name": "required",
                "team_logo": "required",
            },

        });

        $('body').bootstrapMaterialDesign();

        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            minDate: new Date(),
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        })

        // $("#prediction_entry_from").datetimepicker({
        //     // startDate: new Date(), 
        //     format: 'DD/MM/YYYY HH:mm',
        //     autoclose: true,
        //     todayHighlighted: true,
        // }).on('changeDate', function(selected) {
        //     var minDate = new Date(selected.date.valueOf());
        //     $('#prediction_entry_to').datetimepicker('setStartDate', minDate);
        // });

        // $("#prediction_entry_to").datetimepicker({
        //     format: 'DD/MM/YYYY HH:mm',
        //         // startDate: new Date(), 
        //         autoclose: true,
        //         todayHighlighted: true,
        //     })
        //     .on('changeDate', function(selected) {
        //         var maxDate = new Date(selected.date.valueOf());
        //         $('#prediction_entry_from').datetimepicker('setEndDate', maxDate);
        //     });
    });

    $(document).ready(function() {
        $('.form1').fadeIn('slow');

        $('.registration-form input[type="text"]').on('focus', function() {
            $(this).removeClass('input-error');
        });

        // next step
        $('.registration-form .btn-next').on('click', function(event) {
            // event.preventDefault();
            var parent_fieldset = $(this).parents('fieldset');
            var next_step = true;

            // $('.form1').find('input[type="text"],select,textarea').each(function() {
            //     if ($(this).val() == "") {
            //         $(this).addClass('input-error');
            //         next_step = false;
            //     } else {
            //         $(this).removeClass('input-error');
            //     }
            // });

            if (next_step) {
                $('.form1').fadeOut(400, function() {
                    $('.form2').fadeIn();
                });
            }

        });

        // previous step
        $('.registration-form .btn-previous').on('click', function() {
            $('.form2').fadeOut(400, function() {
                $('.form1').fadeIn();
            });
        });

        // submit
        $('.registration-form').on('submit', function(e) {

            $(this).find('input[type="text"],input[type="email"]').each(function() {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                } else {
                    $(this).removeClass('input-error');
                }
            });

        });


    });

    $(document).on('click', '#addmore', function() {
        var html = '<div class="row">';
        html += '<div class="form-group col-md-3 col-sm-3">';
        html += '<select name="field_type[]" class="form-control" required>';
        html += '<option value="">Select Type</option>';
        html += '<option value="1">Team</option>';
        html += '<option value="2">Player</option>';
        html += '<option value="3">Run/Balls</option>';

        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-md-3 col-sm-3">';
        html += ' <input type="text" class="form-control" name="prediction_field_title[]" required placeholder="Field Title">';
        html += ' </div>';
        html += '<div class="form-group col-md-5 col-sm-5">';
        html += '<input type="text" class="form-control" name="variation[]" required placeholder="Field Variation Value">';
        html += '</div>';
        html += '<div class="form-group col-md-1 col-sm-1">';
        html += '<a href="#" class="btn btn-danger deleterow" data-id=""><i class="fa fa-trash "></i></a>';
        html += '</div>';
        html += '</div>';

        $('.field-container').append(html);
    })


    $(document).on('click', '.deleterow', function(event) {
        event.preventDefault();

        var field_id = $(this).data("id");
        var base_url = "<?php echo base_url(); ?>";
        var a = $(this);
        if (field_id) {
            var con = confirm("Are you sure you want to delete this field?");
            if (con) {

                $.ajax({
                    url: base_url + "admin/deletemasterfield/" + field_id,
                    success: function(response) {
                        a.parent().parent().remove();

                    }
                })
            }
        } else {
            $(this).parent().parent().remove();
        }
    })
</script>