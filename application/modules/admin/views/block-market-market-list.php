<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Market Listing
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
                        if (!empty($market_types)) {
                            $i = 1;
                            foreach ($market_types as $market_type) {
                                $market_type = (array) $market_type;


                                if ($market_type['market_name'] == 'Fancy') {
                        ?>
                                    <tr id="user_row_">
                                        <td><?php echo $i++; ?>.</td>
                                        <td class=" ">
                                            <a <?php

                                                if (isset($market_type['block_status'])) {
                                                    echo 'style="color:red;"';
                                                } else {
                                                    echo 'style="color:green;"';
                                                }
                                                ?> href="<?php echo base_url(); ?>admin/fancy_event_list_block/<?php echo $event_type; ?>/<?php echo $market_type['event_id']; ?>"><?php echo $market_type['market_name']; ?></a>
                                        </td>
                                        <td class=" ">
                                            -
                                        </td>
                                        <td>
                                            <img src="<?php echo base_url(); ?>assets/images/<?php echo isset($market_type['block_status']) ? 'resume_icon.png' : 'pause_icon.png'; ?>" style="margin-top:0px;" onclick="blockMarket(<?php echo isset($market_type['event_id']) ? $market_type['event_id'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($market_type['event_id']) ? $market_type['event_id'] : 0; ?>,  0,  <?php echo isset($market_type['fancy_id']) ? $market_type['fancy_id'] : 0; ?>,<?php echo isset($market_type['user_type']) ? $market_type['user_type'] : 0; ?>, <?php echo isset($market_type['block_status']) ? 1 : 0; ?> ,'AllFancy');" height="25">
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr id="user_row_">
                                        <td><?php echo $i++; ?>.</td>
                                        <td class=" " <?php

                                                        if (isset($market_type['block_status'])) {
                                                            echo 'style="color:red;"';
                                                        } else {
                                                            echo 'style="color:green;"';
                                                        }
                                                        ?>>
                                            <?php echo $market_type['market_name']; ?>
                                        </td>
                                        <td class=" ">
                                            <?php echo date('d M Y h:i:s a', strtotime($market_type['market_start_time'])); ?>
                                        </td>
                                        <td>
                                            <img src="<?php echo base_url(); ?>assets/images/<?php echo isset($market_type['block_status']) ? 'resume_icon.png' : 'pause_icon.png'; ?>" style="margin-top:0px;" onclick="blockMarket(<?php echo isset($market_type['event_id']) ? $market_type['event_id'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($market_type['event_id']) ? $market_type['event_id'] : 0; ?>,  `<?php echo isset($market_type['market_id']) ? $market_type['market_id'] : 0; ?>`,  <?php echo isset($market_type['fancy_id']) ? $market_type['fancy_id'] : 0; ?>,<?php echo isset($market_type['user_type']) ? $market_type['user_type'] : 0; ?>, <?php echo isset($market_type['block_status']) ? 1 : 0; ?> ,'Market');" height="25">
                                        </td>
                                    </tr>
                                <?php }
                                ?>

                        <?php }
                        } ?>


                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>