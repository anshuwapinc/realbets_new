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
                        $attributes = array('name' => 'tax-form', 'id' => 'tax-form', 'class' => 'form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>

                        <div class="card-body">
                            <fieldset class="border p-2" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Match Details</legend>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Matches Title</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $data = array(
                                            'name' => 'prediction_title',
                                            'id' => 'prediction_title',
                                            'value' => set_value('prediction_title', empty($prediction_title) ? NULL : $prediction_title),
                                            'class' => ' form-control input-block-level',
                                            'placeholder' => 'Enter Match Title',
                                            'autofocus' => 'autofocus',
                                            'readonly' => true
                                        );

                                        echo form_input($data);

                                        ?>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Entry From</label>
                                    <div class="col-sm-4">
                                        <?php
                                        $data = array(
                                            'name' => 'prediction_entry_from',
                                            'id' => 'prediction_entry_from',
                                            'value' => set_value('prediction_entry_from', empty($prediction_entry_from) ? NULL : date('d/m/Y', strtotime($prediction_entry_from))),
                                            'class' => ' form-control input-block-level',
                                            'autofocus' => 'autofocus',
                                            'type' => 'date',
                                            'readonly' => true

                                        );

                                        echo form_input($data);

                                        ?>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Entry To</label>
                                    <div class="col-sm-4">
                                        <?php
                                        $data = array(
                                            'name' => 'prediction_entry_to',
                                            'id' => 'prediction_entry_to',
                                            'value' => set_value('prediction_entry_to', empty($prediction_entry_to) ? NULL : date('d/m/Y', strtotime($prediction_entry_to))),
                                            'class' => ' form-control input-block-level',
                                            'autofocus' => 'autofocus',
                                            'type' => 'date',
                                            'readonly' => true

                                        );

                                        echo form_input($data);

                                        ?>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="border p-2" style="border-radius:5px;">
                                <legend style="width:auto;font-size:18px;padding:10px;font-weight:100;">Match Bid Fields</legend>


                                <div id="betting-field-container">
                                    <?php
                                    $count = sizeof($prediction_master_field_record);
                                    foreach ($prediction_master_field_record as $record) { ?>
                                    
                                    <?php   }
                                    ?>
                                    <div class="form-group row">

                                        <div class="col-sm-6">
                                            <label for="inputEmail3">Field 1</label>
                                            <?php
                                            $data = array(
                                                'name' => 'prediction_field_title[]',
                                                'value' => set_value('prediction_field_title', empty($prediction_field_title) ? NULL : $prediction_field_title),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Field Title',
                                                'autofocus' => 'autofocus',

                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="inputEmail3">Total Entry Columns</label>
                                            <?php
                                            $data = array(
                                                'name' => 'prediction_field_total_column[]',
                                                'value' => set_value('prediction_field_total_column', empty($prediction_field_total_column) ? NULL : $prediction_field_total_column),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Total Entry Column',
                                                'autofocus' => 'autofocus',
                                                'onkeyup' => 'tax_calculate(this.value)'
                                            );

                                            echo form_input($data);

                                            ?>
                                        </div>

                                        <!-- <div class="col-sm-4">
                                            <label for="inputEmail3">Total Entry Columns</label>
                                            <?php
                                            $data = array(
                                                'name' => 'tax_slab',
                                                'id' => 'tax_slab',
                                                'value' => set_value('tax_slab', empty($tax_slab) ? NULL : $tax_slab),
                                                'class' => ' form-control input-block-level',
                                                'placeholder' => 'Enter Tax Slab %',
                                                'autofocus' => 'autofocus',
                                                'onkeyup' => 'tax_calculate(this.value)'
                                            );

                                            echo form_input($data);

                                            ?>

                                        </div> -->
                                        <button type="button" class="btn btn-danger" style="position:absolute;right:30px;margin-top:-20px;"><i class="fa fa-trash"></i></button>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center><button type="button" id="addmore" class="btn btn-success">Add More</button></center>
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
    $(document).ready(function() {
        var base_url = "<?php echo base_url(); ?>";


        $("#tax-form").validate({
            ignore: [],
            rules: {
                "title": "required",
                "tax_slab": "required",
                "igst": "required",
                "cgst": "required",
                "sgst": "required",
            },
            messages: {
                "title": {
                    "": "Please enter tax Title",
                    remote: 'Tax Title already in use.',
                },
                "tax_slab": "Please provide your Password",
                "igst": "Please enter your first name",
                "cgst": "Please enter contact",
                "sgst": "Please enter your address",

            }
        });
    });

    $(document).ready(function() {
        $(document).on("click", "#addmore", function() {
            var count = $('#count').val();
            var html = '<div class="form-group row" style="margin-top:20px;">';
            html += '<div class="col-sm-6">';
            html += '<label for="inputEmail3">Field</label>';
            html += "<input type='text'  class='form-control' name='prediction_field_title[]' placeholder='Total Entry Columns'/>";
            html += '</div>';
            html += '<div class="col-sm-6">';
            html += '<label for="inputEmail3">Total Entry Columns</label>';
            html += "<input type='text'  class='form-control'  name='prediction_field_total_column[]' placeholder='Total Entry Columns'/>";
            html += '</div>';
            // html += '<div class="col-sm-4">';
            // html += '<label for="inputEmail3">Variations</label>';
            // html += "<input type='text' class='form-control' placeholder='Total Entry Columns'/>";
            // html += '</div>';
            html += '<button type="button" class="btn btn-danger" style="position:absolute;right:30px;margin-top:-20px;"><i class="fa fa-trash"></i></button>';
            html += '</div>';
            $('#betting-field-container').append(html);
        });
    });
</script>