<main id="main" class="main-content">
    <div class="container-fluid right_col" role="main">
        <div class="card" style="background:#fff;">
            <div class="card-body" style="overflow-x: scroll;min-height:500px;">
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
                                            <a href="<?php echo base_url('refered-users/' . $row['user_id']) ?>"><?php echo substr_replace($row['user_name'], '******', 1, 6) ?></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>