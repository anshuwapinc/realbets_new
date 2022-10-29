<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                <?php echo $event_name; ?> Settlement
            </span>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>

            <div class="custom-scroll appendAjaxTbl">
                <table class="table table-striped jambo_table " id="example">
                    <thead>
                        <tr class="headings">

                            <th>S.No.</th>
                            <th>Match Name</th>
                            <th>Date</th>
                            <th>Status</th>
                         </tr>
  </thead>
  <tbody>
                        <?php
                        if (!empty($list_events)) {
                            $i = 1;
                            foreach ($list_events as $list_event) {
                                if ($list_event->is_unlist == 'Yes') {
                                    continue;
                                }
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><a href="<?php echo base_url(); ?>admin/settlement/events/settlemenEventEntry/<?php echo $list_event->list_event_id; ?>"><?php echo $list_event->event_name; ?></a></td>
                                    <td><?php echo date('d M Y h:i:s a', strtotime($list_event->open_date)); ?></td>
                                    <td><span class="badge badge-success" style="background-color:forestgreen;"><?php echo $list_event->status; ?></span></td>


                                    <!-- <td align="center"><a href=""><i class="fa fa-edit" style="font-size:15px;"></i></a></td> -->

                                </tr>
                        <?php  }
                        }
                        ?>

                        </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "searching": false,
            "paging": true,
            "order": []

        });
    });
</script>