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
            <?php
            $attributes = array('name' => 'match-form', 'id' => 'match-form', 'class' => 'form-horizontal registration-form"', 'role' => 'form');
            echo form_open_multipart($form_action, $attributes);
            ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reports</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-6 validate-required">
                                <label for="inputEmail3">Match</label>
                                <?php
                                echo form_dropdown('match_id', empty($matches_arr) ? array() : $matches_arr, empty($match_id) ? NULL : $match_id, ' id = "match_id"  class="form-control select2bs4" ');

                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right btn-sm">Submit</button>

                    </div>
                    <!-- /.card-footer -->
                    <?php
                    echo form_close();
                    ?>
                </div>

            </div>
            <?php
            if (isset($reports) && !empty($reports)) { ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive " width="100%">
                                    <tbody>
                                        <?php
                                        $reportData = array();
                                        foreach ($reports as $report) {
                                            if (isset($reportData[$report['username']])) {

                                                $reportData[$report['username']][] = $report;
                                            } else {
                                                $reportData[$report['username']][] = $report;
                                            }
                                        }

                                        // p($reportData, 2);
                                        foreach ($reportData as $key => $entrys) {   ?>
                                            <tr>
                                                <th colspan="8">User Name: <?php echo $key; ?></th>
                                            </tr>
                                            <tr>
                                                <th width="20%">Title</th>
                                                <th width="10%">Points</th>
                                                <th width="10%">Variation</th>

                                                <th width="10%">Marking Type</th>
                                                <th width="10%">Admin Entry</th>
                                                <th width="10%">User Entry</th>
                                                <th width="10%">P/L</th>





                                            </tr>
                                            <?php
                                            foreach ($entrys as $entry) { ?>
                                                <tr>
                                                    <th><?php echo $entry['title']; ?></th>
                                                    <td><?php echo $entry['points']; ?></td>
                                                    <td>+/-&nbsp; <?php echo $entry['differance_variation']; ?></td>
                                                    <td><?php echo $entry['marking_type']; ?></td>

                                                    <td><?php
  if(!empty($entry['admin_field_value']))
  {
                                                        if ($entry['field_type'] == 1) {
                                                            echo $team_arr[$entry['admin_field_value']];
                                                        } else if ($entry['field_type'] == 2) {
                                                            $players = explode(',',$entry['admin_field_value']);
                                                           
                                                            if(sizeof($players) > 0)
                                                            {   
                                                                $players_str = '';
                                                                for($i=0;$i<sizeof($players);$i++)
                                                                {
                                                                    $players_str .= $player_arr[$players[$i]].', ';

                                                                }
                                                                echo $players_str;
                                                            }
                                                            else
                                                            {
                                                                echo $player_arr[$entry['admin_field_value']];
                                                            }
                                                            
                                                            
                                                        } else {
                                                            echo $entry['admin_field_value'];
                                                        }

                                                    }
                                                        ?></td>
                                                    <td><?php
                                                    if(!empty($entry['field_value']))
                                                    {
                                                        if ($entry['field_type'] == 1) {
                                                            echo $team_arr[$entry['field_value']];
                                                        } else if ($entry['field_type'] == 2) {
                                                            echo $player_arr[$entry['field_value']];
                                                        } else {
                                                            echo $entry['field_value'];
                                                        }
                                                    }
                                                      
                                                        ?></td>
                                                    <td><?php
                                                        if (!empty($entry['field_value'])) {


                                                            if ($entry['field_type'] == 3) {
                                                                if ($entry['admin_field_value'] - $entry['field_value'] < $entry['differance_variation']) {
                                                                    if ($entry['marking_type'] == 'Plus') { ?>
                                                                        <span class="badge badge-success">+&nbsp; <?php echo $entry['points']; ?></span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-danger">-&nbsp; <?php echo $entry['points']; ?></span>
                                                                    <?php }
                                                                    ?>

                                                                <?php } else { ?>
                                                                    <span class="badge badge-danger">-&nbsp; <?php echo $entry['points']; ?></span>
                                                                <?php }
                                                            } else if ($entry['field_type'] == 1) {

                                                                if ($entry['field_value'] == $entry['admin_field_value']) { ?>
                                                                    <span class="badge badge-success">+&nbsp; <?php echo $entry['points']; ?></span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-danger">-&nbsp; <?php echo $entry['points']; ?></span>
                                                                <?php }
                                                                ?>

                                                        <?php   } else if ($entry['field_type'] == 2)
                                                        {   
                                                            $players = explode(',',$entry['admin_field_value'] );

                                                             if (in_array($entry['field_value'],$players)) {
                                                                if ($entry['marking_type'] == 'Plus') { ?>
                                                                    <span class="badge badge-success">+&nbsp; <?php echo $entry['points']; ?></span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-danger">-&nbsp; <?php echo $entry['points']; ?></span>
                                                                <?php }
                                                                ?>

                                                            <?php } else { ?>
                                                                <span class="badge badge-danger">-&nbsp; <?php echo $entry['points']; ?></span>
                                                            <?php }
                                                        }
                                                    }
                                                        ?></td>


                                                </tr>
                                            <?php   }
                                            ?>


                                        <?php                                    }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <h4>No Data Found</h4>
                            </center>
                        </div>
                    </div>
                </div>
            <?php }
            ?>


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