<style>

    table td,th{
        font-size: 21px;
    }
</style>
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="title_new_at">Settlement sport </div>
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
                                    <td style="font-weight:bold;"><a href="<?php echo base_url(); ?>admin/settlement/events/<?php echo $event_type['event_type']; ?>"><?php echo $event_type['name']; ?></a></td>

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