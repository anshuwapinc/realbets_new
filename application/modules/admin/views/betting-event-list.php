<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    <?php echo $event_name; ?> Bettings
                </span>
            </div>




            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="divLoading"></div>
                    <div class="custom-scroll appendAjaxTbl">
                        <table class="table table-striped jambo_table bulk_action" id="example">
                            <thead>
                                <tr class="headings">
                                    <th>S.No.</th>
                                    <th>Match Name</th>
                                    <th>Date</th>
                                    <th style="text-align: center;">Entry</th>

                                    <!-- <th style="text-align: center;">Fancy Entry</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!empty($list_events)) {
                                    $i = 1;
                                    foreach ($list_events as $list_event) {
                                        // p($list_event);
                                ?>
                                        <tr>
                                            <td style="font-size:15px; "><?php echo $i++; ?></td>
                                            <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/bettings/bettinglists/<?php echo $list_event->list_event_id; ?>"><?php echo $list_event->event_name; ?></a></td>
                                            <td style="font-size:15px; "><?php echo date('d M Y h:i:s a', strtotime($list_event->open_date)); ?></td>
                                            <td align="center"><a href="<?php echo base_url(); ?>admin/bettings/bettinglists/<?php echo $list_event->list_event_id; ?>"><i class="fa fa-edit" style="font-size:15px;"></i></a></td>

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
        </section>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>