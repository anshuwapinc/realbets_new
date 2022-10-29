<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                Bettings Sport
                </span>
            </div>
            <div class="row">
             

                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="tabel_content">
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
                                                <td style="font-size:15px;" scope="row"><?php echo $i++; ?></td>
                                                <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/bettings/events/<?php echo $event_type['event_type']; ?>"><?php echo $event_type['name']; ?></a></td>

                                            </tr>
                                    <?php     }
                                    }

                                    ?>

                                    <?php
                                    if ($show_casino == 'Yes') { ?>
                                        <tr>
                                            <td style="font-size:15px;" scope="row"><?php echo $i++; ?></td>
                                            <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/casinobettings/listmarkets">Casino</a></td>

                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>