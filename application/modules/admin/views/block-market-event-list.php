<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Match Listing
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class="table-responsive sports-tabel" id="contentreplace">
                <table class="table tabelcolor tabelborder">
                    <thead>
                        <tr>
                            <th scope="col">S.No. </th>
                            <th scope="col">Match Name</th>
                            <th scope="col">Date </th>
                            <th scope="col">ON/OFF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($list_events)) {
                            $i = 1;
                            foreach ($list_events as $list_event) {
                                $list_event = (array) $list_event;

                        ?>
                                <tr id="user_row_">
                                    <td><?php echo $i++; ?>.</td>
                                    <td class=" ">
                                        <a <?php
                                            if (isset($list_event['block_status'])) {
                                                echo 'style="color:red;"';
                                            } else {
                                                echo 'style="color:green;"';
                                            }
                                            ?>  href="<?php echo base_url(); ?>admin/market_list_block/<?php echo $list_event['event_type']; ?>/<?php echo $list_event['event_id']; ?>"> <?php echo $list_event['event_name']; ?></a>
                                    </td>
                                    <td class=" ">
                                        <?php echo date('d M Y h:i:s a', strtotime($list_event['open_date'])); ?>
                                    </td>
                                    <td>


                                        <img src="<?php echo base_url(); ?>assets/images/<?php echo isset($list_event['block_status']) ?  'resume_icon.png' : 'pause_icon.png'; ?>" height="25" style="margin-top:0px;" onclick="blockMarket(<?php echo isset($list_event['event_type']) ? $list_event['event_type'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($list_event['event_id']) ? $list_event['event_id'] : 0; ?>,  <?php echo isset($list_event['market_id']) ? $list_event['market_id'] : 0; ?>,  <?php echo isset($list_event['fancy_id']) ? $list_event['fancy_id'] : 0; ?>,<?php echo isset($list_event['user_type']) ? $list_event['user_type'] : 0; ?>, <?php echo isset($list_event['block_status']) ? 1 : 0; ?> ,'Event');">
                                    </td>
                                </tr>
                        <?php }
                        } ?>


                    </tbody>
                </table>
            </div>
                    </section>
    </div>
</div>