<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Sport Listing
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>

            <div class="tabel_content">
                <div class="table-responsive sports-tabel" id="contentreplace">
                    <table class="table tabelcolor tabelborder">
                        <thead>
                            <tr>
                                <th scope="col">So.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            if (!empty($event_types)) {
                                foreach ($event_types as $event_type) { ?>

                                    <tr>
                                        <td scope="row"><?php echo $i ?></td>
                                        <td><a <?php
                                                if (isset($event_type['block_status'])) {
                                                    echo 'style="color:red;"';
                                                } else {
                                                    echo 'style="color:green;"';
                                                }
                                                ?> href="<?php echo base_url(); ?>admin/match_list_block/<?php echo $event_type['event_type']; ?>">
                                                <?php
                                                if ($event_type['event_type'] == 4) { ?>
                                                    <img height="30" src="<?php echo base_url(); ?>assets/images/cricket-icon.png" alt="...">
                                                <?php } else if ($event_type['event_type'] == 2) { ?>
                                                    <img height="30" src="<?php echo base_url(); ?>assets/images/tenish-icon.png" alt="...">
                                                <?php } else if ($event_type['event_type'] == 1) { ?>
                                                    <img height="30" src="<?php echo base_url(); ?>assets/images/soccer-icon.png" alt="...">
                                                <?php } else { ?>
                                                    <img height="30" src="<?php echo base_url(); ?>assets/images/teenpatti.png" alt="...">
                                                <?php }
                                                ?>

                                                <?php echo $event_type['name']; ?></a></td>
                                        <td>
                                            <!-- <label class="toggle-label"> -->


                                            <label class="toggle-label">
                                                <input type="checkbox" onclick="blockMarket(<?php echo isset($event_type['event_type']) ? $event_type['event_type'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($event_type['event_id']) ? $event_type['event_id'] : 0; ?>,  <?php echo isset($event_type['market_id']) ? $event_type['market_id'] : 0; ?>,  <?php echo isset($event_type['fancy_id']) ? $event_type['fancy_id'] : 0; ?>,<?php echo isset($event_type['user_type']) ? $event_type['user_type'] : 0; ?>, <?php echo isset($event_type['block_status']) ? 1 : 0; ?> ,'Sport');" class="ng-pristine ng-valid ng-touched" <?php

                                                                                                                                                                                                                                                                                                                                                       if (!isset($event_type['block_status'])) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>>
                                                <span class="back">
                                                    <span class="toggle"></span>
                                                    <span class="label off ">OFF</span>
                                                    <span class="label on">ON</span>
                                                </span>
                                            </label>


                                            <!-- <img src="<?php echo base_url(); ?>assets/images/<?php echo isset($event_type['block_status']) ? 'resume_icon.png' : 'pause_icon.png'; ?>" style="margin-top:0px;" onclick="blockMarket(<?php echo isset($event_type['event_type']) ? $event_type['event_type'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($event_type['event_id']) ? $event_type['event_id'] : 0; ?>,  <?php echo isset($event_type['market_id']) ? $event_type['market_id'] : 0; ?>,  <?php echo isset($event_type['fancy_id']) ? $event_type['fancy_id'] : 0; ?>,<?php echo isset($event_type['user_type']) ? $event_type['user_type'] : 0; ?>, <?php echo isset($event_type['block_status']) ? 1 : 0; ?> ,'Sport');" height="25"> -->
                                            <!-- </label> -->
                                        </td>
                                    </tr>
                            <?php $i++;
                                }
                            }

                            ?>
                            <?php
                            if ($show_casino == 'Yes') { ?>
                               
                            <?php }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>
</div>