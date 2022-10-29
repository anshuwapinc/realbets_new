<main id="main" class="main-content">
    <div class="container-fluid right_col" role="main">
        <div class="card" style="background:#fff; margin-top:15px">
            <div class="card-body" style="overflow-x: scroll;min-height:500px;">
            <div class="row">
                <div class="col-md-12">
                <h3>Master Detail</h3>
                    <table class="table table-bordered">
                        <tr>
                            <td>Master Name</td>
                            <td><?php echo $master_detail->user_name ?></td>
                        </tr>
                        <tr>
                            <td>Master Role</td>
                            <td><?php echo $master_detail->user_type ?></td>
                        </tr>
                    </table>                    
                </div>
            </div>
            <h3>Refered Users</h3>
                <table class="table table-striped jambo_table bulk_action text-center">
                    <thead>
                        <tr class="headings">
                            <td>Serial No.</td>
                            <td>Mobile Number</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($refered_data)) {

                            if ($refered_data[0]['user_id'] != null) {
                                $i = 1;
                                foreach ($refered_data as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td>
                                            <!-- <a href="<?php echo base_url('refered-users/' . $row['user_id']) ?>"><?php echo substr_replace($row['user_name'], '******', 1, 6) ?></a> -->
                                            <?php echo $row['user_name'] ?>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                            else{
                                ?>
                                          <tr>                                        
                                            <td colspan="2">
                                              No Record Found!
                                            </td>
                                        </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>