<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding-top:15px;">


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
            if (!empty($message)) {
            ?>
                <div class="col-md-12 ">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        <p><?php echo $message; ?></p>

                    </div>
                </div>
            <?php
            }
            ?>
            <div class="row">
                <?php
                if (!empty($matchesData)) {
                    foreach ($matchesData as $match) {
                        // p($match);
                ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <span><?php echo empty($match['prediction_title']) ? '' : $match['prediction_title']; ?></span>


                                </div>
                                <div class="card-body">
                                    <center><img src="<?php echo base_url() . 'assets/teams_images/' . $match['first_team_logo']; ?>" style="height:85px;width:85px;border-radius:50%;border:5px solid #efefef;" />
                                        <span style="padding:20px;font-size:25px; font-weight:700;">V/S</span>

                                        <span><img src="<?php echo base_url() . 'assets/teams_images/' . $match['second_team_logo']; ?>" style="height:85px;width:85px; border-radius:50%;border:5px solid #efefef;" />
                                    </center>
                                    <center>
                                        <span class="badge badge-success"><?php echo  date('d-M-Y h:i:s', strtotime($match['prediction_entry_from'])); ?></span>
                                        <span class="badge badge-danger"><?php echo date('d-M-Y h:i:s', strtotime($match['prediction_entry_to'])); ?></span>
                                    </center>

                                    <center>
                                        <p><?php echo $match['description']; ?></p>
                                    </center>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo base_url() . 'matches/entry/' . $match['prediction_master_id']; ?>" style="float:right; border:2px solid #26A69A; border-radius:50%; padding:7px 14px;" title="Match Entry"><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                        </div>

                    <?php }
                } else { ?>
                    <div class="col-md-12">
                        <center>
                            <h3 style="margin-top:150px;">No Matches</h3</center> </div> <?php }

                                                                ?> </div> <!-- /.card -->
                    </div>

    </section>
    <!-- /.content -->
</div>

<script>
    // $(function() {
    //     $('#tax-list').DataTable({
    //         "paging": true,
    //         "lengthChange": false,
    //         "searching": false,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": false,
    //         "responsive": true,
    //         stateSave: true,
    //         "bDestroy": true
    //     });
    // });

    $(function() {
        setTimeout(function() {
            location.reload();
        }, 10000);
    })
</script>