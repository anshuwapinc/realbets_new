<style>
    table td,
    th {
        font-size: 21px;
    }
</style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="title_new_at">Settled sport </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="table-responsive sports-tabel" id="contentreplace">
                <table class="table tabelcolor tabelborder">
                    <thead>
                        <tr>
                            <th scope="col">So.</th>
                            <th scope="col">Name</th>
                            <!-- <th scope="col">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        if (!empty($event_types)) {
                            $i = 1;
                            foreach ($event_types as $event_type) { ?>

                                <tr>
                                    <td scope="row"><?php echo $i++; ?></td>
                                    <td style="font-weight:bold;"><a href="<?php echo base_url(); ?>admin/settled/events/<?php echo $event_type['event_type']; ?>"><?php echo $event_type['name']; ?></a></td>
                                    <!-- <td>
                                            <label class="toggle-label">
                                                <input type="checkbox" onclick="blockMarket(<?php echo isset($event_type['event_type']) ? $event_type['event_type'] : 0; ?>, <?php echo isset($event_type['user_id']) ? $event_type['user_id'] : 0; ?>,  <?php echo isset($event_type['event_id']) ? $event_type['event_id'] : 0; ?>,  <?php echo isset($event_type['market_id']) ? $event_type['market_id'] : 0; ?>,  <?php echo isset($event_type['fancy_id']) ? $event_type['fancy_id'] : 0; ?>,<?php echo isset($event_type['user_type']) ? $event_type['user_type'] : 0; ?>, '0');" class="ng-pristine ng-valid ng-touched">
                                                <span class="back">
                                                    <span class="toggle"></span>
                                                    <span class="label off">OFF</span>
                                                    <span class="label on">ON</span>
                                                </span>
                                            </label>
                                        </td> -->
                                </tr>
                        <?php     }
                        }

                        ?>




                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>