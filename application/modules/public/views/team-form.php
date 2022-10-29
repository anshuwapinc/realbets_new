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
                        $attributes = array('name' => 'team-form', 'id' => 'team-form', 'class' => 'form-horizontal', 'role' => 'form');
                        echo form_open_multipart($form_action, $attributes);
                        ?>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-6 validate-required">
                                    <label for="inputEmail3">Team Name</label>
                                    <?php
                                    $data = array(
                                        'name' => 'team_name',
                                        'value' => set_value('team_name', empty($team_name) ? NULL : $team_name),
                                        'class' => ' form-control input-block-level',
                                        'placeholder' => 'Enter Team Name',
                                        'autofocus' => 'autofocus',
                                    );

                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="col-sm-6 validate-required">
                                    <label for="inputEmail3">Team Logo</label>
                                    <?php
                                    $data = array(
                                        'name' => 'team_logo',
                                        'value' => set_value('team_logo', empty($team_logo) ? NULL : $team_logo),
                                        'class' => ' form-control input-block-level',
                                        'autofocus' => 'autofocus',
                                    );
                                    echo form_upload($data);

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
        $("#team-form").validate({
            ignore: [],
            rules: {
                "team_name": "required",
            },

        });
    });
</script>