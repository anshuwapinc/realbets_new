<table class="table table-striped jambo_table bulk_action">
    <thead>
        <tr class="headings">
            <th>S.No. </th>
            <th>Match Name </th>
            <!-- <th>Date</th>
            <th>Sport Name</th>
            <th>Match Status </th> -->
            <th>Team A </th>
            <th>Team B </th>
            <th>Draw </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($list_events)) {
            $i = 1;
            foreach ($list_events as $list_event) {

                if (!isset($list_event->exposure)) {
                    continue;
                }
        ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td>
                        <?php if (check_is_casino($list_event->event_type)) { ?>
                            <a href="<?php echo base_url(); ?>casino/<?php echo getCustomConfigItem('casino_event_type_chk')[$list_event->event_type]; ?>"><?php echo $list_event->event_name; ?></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url(); ?>dashboard/eventDetail/<?php echo $list_event->match_id; ?>"><?php echo $list_event->event_name; ?></a>
                        <?php } ?>
                    </td>
                    <!-- <td><?php echo date('d/m/Y h:i:s a', strtotime($list_event->market_start_time)); ?></td>
                    <td><?php echo $list_event->sport_name; ?></td>
                    <td><?php echo $list_event->market_status; ?></td> -->
                    <?php
                    foreach ($list_event->exposure as $exp) { ?>
                        <td data-value="<?php echo isset($exp) ? number_format($exp, 2) : 0; ?>"><?php echo isset($exp) ? number_format($exp, 2) : 0; ?></td>

                    <?php }
                    ?>

                    <?php if (sizeof($list_event->exposure) < 3) { ?>
                        <td></td>

                    <?php } ?>




                </tr>
            <?php }
        } else { ?>
            <tr>
                <th colspan="7">No record found</th>
            </tr>

        <?php }
        ?>
    </tbody>
</table>