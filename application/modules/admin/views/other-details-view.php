<div class="right_col" role="main">
    <div class="fullrow tile_count">
        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>sports" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/sports.png" />
                    <span class="font-weight-200 font-size-26">Sports</span>


                </a>
            </div>
        </div>


        <?php
        if (get_user_type() == 'Super Admin' || get_user_type() == 'Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/blockmarket" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/block_market.png" />
                        <span class="font-weight-200 font-size-26">Block Market</span>


                    </a>
                </div>
            </div>
        <?php } ?>

        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>admin/my_market" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/running_market.png" />
                    <span class="font-weight-200 font-size-26">Running Market</span>


                </a>
            </div>
        </div>

        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>reports" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/report.png" />
                    <span class="font-weight-200 font-size-26">Report</span>


                </a>
            </div>
        </div>


        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>casinos" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/casino.png" />
                    <span class="font-weight-200 font-size-26">Casinos</span>


                </a>
            </div>
        </div>

        <?php
        if (get_user_type() == 'Super Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/bettings/listmarkets" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/bettings.png" />
                        <span class="font-weight-200 font-size-26">Bettings</span>


                    </a>
                </div>
            </div>
        <?php } ?>

        <?php
        if (get_user_type() == 'Super Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>addfunds" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/add_funds.png" />
                        <span class="font-weight-200 font-size-26">Add Funds</span>


                    </a>
                </div>
            </div>
        <?php }
        ?>

        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>dashboard/inplay" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/inplay.png" />
                    <span class="font-weight-200 font-size-26">In Play</span>


                </a>
            </div>
        </div>
        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>dashboard/favourite" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/favourite.png" />
                    <span class="font-weight-200 font-size-26">Favourite</span>


                </a>
            </div>
        </div>




        <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
            <div class="bg-white">
                <a href="<?php echo base_url(); ?>admin/chip" style="width:100%; height:100%">

                    <img src="<?php echo base_url(); ?>assets/images/chip.png" />
                    <span class="font-weight-200 font-size-26">Chip</span>


                </a>
            </div>
        </div>
        <?php
        if (get_user_type() == 'Super Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>news" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/inplay.png" />
                        <span class="font-weight-200 font-size-26">News</span>


                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>