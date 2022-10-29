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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo empty($table_heading) ? '' : $table_heading; ?></h3>

                        <div class="pull-right" style="float:right;">
                            <a href="<?php echo empty($new_entry_link) ? '' : $new_entry_link; ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"> <?php echo $new_entry_caption; ?></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <?php echo $table; ?>
                    </div>
                </div>

            </div>

            <!-- /.card -->
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
</script>