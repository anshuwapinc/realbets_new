<div class="right_col" role="main">


    <div class="card" style="background:#fff;">
        <div class="card-header" style="border-bottom:1px solid #efefef; padding:10px;">
            <h4 style="display:inline-block;">Score</h4>

        </div>
        <div class="card-body">
            <table class="table table-bordered" id="example" style="width:100%;">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Event</th>
                        <th>Date</th>

                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($list_events) && !empty($list_events)) {
                        $i = 1;
                        foreach ($list_events as $list_event) {

                    ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $list_event['event_name']; ?></td>
                                <td><?php echo date('d-M-Y H:i:s', strtotime($list_event['open_date'])); ?></td>

                                <td>
                                    <?php
                                    if ($list_event['is_score'] == 'Yes') { ?>
                                        <img  src="<?php echo base_url(); ?>assets/images/pause_icon.png" height="25" style="margin-top:0px;" onclick="scoreToggle('<?php echo $list_event['event_id']; ?>','No')" />
                                    <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>assets/images/resume_icon.png" height="25" style="margin-top:0px;" onclick="scoreToggle('<?php echo $list_event['event_id']; ?>','Yes')" />

                                    <?php }
                                    ?>



                                </td>

                            </tr>

                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
 
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "searching": true,
            "paging": true,
        });
    });

    function scoreToggle(event_id, is_score) {
        var request = {
            event_id: event_id,
            is_score: is_score,

        };
        jQuery.ajax({
            url: base_url + "admin/Score/score_toggle",
            data: request,
            type: "post",
            dataType: "json",
            success: function success(data) {
                if (data.success) {
                    new PNotify({
                        title: "Success",
                        text: "Success",
                        type: "success",
                        styling: "bootstrap3",
                        delay: 3000,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                } else {
                    new PNotify({
                        title: "403 Error",
                        text: data.message,
                        type: "error",
                        styling: "bootstrap3",
                        delay: 3000,
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
        });

    }
</script>