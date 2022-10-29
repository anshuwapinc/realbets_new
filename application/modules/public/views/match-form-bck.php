<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding-top:15px;">


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12  ">
                    <!-- <form role="form" class="registration-form" action="javascript:void(0);"> -->
                    <?php
                    $attributes = array('name' => 'player-form', 'id' => 'player-form', 'class' => 'form-horizontal registration-form"', 'role' => 'form');
                    echo form_open_multipart($form_action, $attributes);
                    ?>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Add Match</h3>

                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12">


                                    <?php
                                    $data = array(
                                        'name' => 'prediction_title',
                                        'value' => set_value('prediction_title', empty($prediction_title) ? NULL : $prediction_title),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Match Title',
                                        'autofocus' => 'autofocus',
                                    );

                                    echo form_input($data);
                                    ?>
                                </div>

                                <div class="form-group col-md-5 col-sm-5">
                                    <?php
                                    echo form_dropdown('first_team_id', empty($first_team_arr) ? array() : $first_team_arr, empty($first_team_id) ? NULL : $first_team_id, ' id = "first_team_id"  class="form-control select2bs4" style="width:100% !important;"');
                                    ?> </div>
                                <div class="form-group col-md-2 col-sm-2" style="text-align:center;vertical-align:middle;">
                                    <strong>V/S</strong>
                                </div>
                                <div class="form-group col-md-5 col-sm-5">
                                    <?php
                                    echo form_dropdown('second_team_id', empty($second_team_arr) ? array() : $second_team_arr, empty($second_team_id) ? NULL : $second_team_id, ' id = "second_team_id"  class="form-control select2bs4" style="width:100% !important; ');

                                    ?> </div>

                            </div>
                            <div class="form-group" style="margin-bottom:3px;">
                                <div class="row" style="padding-left:8px;">
                                    <div class="form-group col-md-6 col-sm-6">
                                        <div class="form-group row">

                                            <?php
                                            $data = array(
                                                'name' => 'prediction_entry_from',
                                                'value' => set_value('prediction_entry_from', empty($prediction_entry_from) ? NULL : date('d-m-Y H:i:s', strtotime($prediction_entry_from))),
                                                'class' => ' form-control input-block-level datetimepicker',
                                                'placeholder' => 'MatchEntry Start',
                                                'autofocus' => 'autofocus',
                                            );

                                            echo form_input($data);
                                            ?>


                                            <!-- <input type="text" class="form-control datetimepicker" name="prediction_entry_from" id="prediction_entry_from" required> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <?php
                                        $data = array(
                                            'name' => 'prediction_entry_to',
                                            'value' => set_value('prediction_entry_to', empty($prediction_entry_to) ? NULL : date('d-m-Y H:i:s', strtotime($prediction_entry_to))),
                                            'class' => ' form-control input-block-level datetimepicker',
                                            'placeholder' => 'MatchEntry End',
                                            'autofocus' => 'autofocus',
                                        );

                                        echo form_input($data);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <?php

                                $data = array(
                                    'name' => 'description',
                                    'id' => 'description',
                                    'value' => htmlspecialchars_decode(set_value('description', empty($description) ? NULL : $description)),
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Description',
                                );
                                echo form_textarea($data);
                                ?>

                            </div>


                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3></span>Add Match</h3>

                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group" style="margin-bottom:3px;">
                                <div class="field-container">
                                    <?php

                                    if (!empty($prediction_master_field_record)) {
                                        foreach ($prediction_master_field_record as $record) {

                                    ?>

                                            <div class="row">
                                                <input type="hidden" name="prediction_master_field_id[]" value="<?php echo $record['prediction_master_field_id']; ?>" />
                                                <div class="form-group col-md-3 col-sm-3">
                                                    <select name="field_type[]" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="1" <?php if ($record['field_type'] == 1) {
                                                                                echo "selected";
                                                                            } ?>>Team</option>
                                                        <option value="2" <?php if ($record['field_type'] == 2) {
                                                                                echo "selected";
                                                                            } ?>>Player</option>
                                                        <option value="3" <?php if ($record['field_type'] == 3) {
                                                                                echo "selected";
                                                                            } ?>>Run/Balls</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 col-sm-3">

                                                    <?php
                                                    $data = array(
                                                        'name' => 'prediction_field_title[]',
                                                        'value' => set_value('prediction_field_title', empty($record['prediction_field_title']) ? NULL : $record['prediction_field_title']),
                                                        'class' => ' form-control input-block-level',
                                                        'placeholder' => 'Field Title',
                                                        'autofocus' => 'autofocus',
                                                    );

                                                    echo form_input($data);
                                                    ?>


                                                    <!-- <input type="text" class="form-control" name="prediction_field_title[]" required placeholder="Field Title"> -->
                                                </div>


                                                <div class="form-group col-md-5 col-sm-5">

                                                    <?php
                                                    $data = array(
                                                        'name' => 'variation[]',
                                                        'value' => set_value('variation', empty($record['variation']) ? NULL : $record['variation']),
                                                        'class' => ' form-control input-block-level',
                                                        'placeholder' => 'Field Title',
                                                        'autofocus' => 'autofocus',
                                                    );

                                                    echo form_input($data);
                                                    ?>



                                                    <!-- <input type="text" class="form-control" name="variation[]" required placeholder="Field Variation Value"> -->
                                                </div>
                                                <div class="form-group col-md-1 col-sm-1">
                                                    <a href="#" class="btn btn-danger deleterow" data-id="<?php echo $record['prediction_master_field_id']; ?>  "><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="row">
                                            <div class="form-group col-md-3 col-sm-3">
                                                <select name="field_type[]" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="1">Team</option>
                                                    <option value="2">Player</option>
                                                    <option value="3">Run/Balls</option>

                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 col-sm-3">
                                                <input type="text" class="form-control" name="prediction_field_title[]" required placeholder="Field Title">
                                            </div>
                                            <div class="form-group col-md-5 col-sm-5">
                                                <input type="text" class="form-control" name="variation[]" required placeholder="Field Variation Value">
                                            </div>
                                            <div class="form-group col-md-1 col-sm-1">
                                                <a href="#" class="btn btn-danger deleterow"><i class="fa fa-trash" data-id=""></i></a>
                                            </div>
                                        </div>
                                    <?php }

                                    ?>


                                </div>

                                <dic class="col-md-12">
                                    <center><button type="button" id="addmore" class="btn btn-success">Add More</button></center>
                                </dic>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </fieldset>
                    <?php
                    echo form_close();
                    ?>
                    </form>
                </div>
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
        });
    });

    $(document).ready(function() {
        $('.registration-form fieldset:first-child').fadeIn('slow');

        $('.registration-form input[type="text"]').on('focus', function() {
            $(this).removeClass('input-error');
        });

        // next step
        $('.registration-form .btn-next').on('click', function() {
            var parent_fieldset = $(this).parents('fieldset');
            var next_step = true;

            // parent_fieldset.find('input[type="text"],input[type="email"]').each(function() {
            //     if ($(this).val() == "") {
            //         $(this).addClass('input-error');
            //         next_step = false;
            //     } else {
            //         $(this).removeClass('input-error');
            //     }
            // });

            if (next_step) {
                parent_fieldset.fadeOut(400, function() {
                    $(this).next().fadeIn();
                });
            }

        });

        // previous step
        $('.registration-form .btn-previous').on('click', function() {
            $(this).parents('fieldset').fadeOut(400, function() {
                $(this).prev().fadeIn();
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
        html += '<select name="field_type[]" class="form-control">';
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