<div class="right_col" role="main">
    <div class="fullrow tile_count">
        <?php

        if (get_user_type() == 'Super Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/user_detail" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/search.png" />
                        <span class="font-weight-200 font-size-26">Search User</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/admin" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/admin.png" />
                        <span class="font-weight-200 font-size-26">Super Admin</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/hypersupermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/master_ajent.png" />
                        <span class="font-weight-200 font-size-26">Admin</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/supermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/super_ajent.png" />
                        <span class="font-weight-200 font-size-26">Super Master</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ajent.png" />
                        <span class="font-weight-200 font-size-26">Master</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/users.png" />
                        <span class="font-weight-200 font-size-26">User</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/closedusers/admin" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/close.png" />
                        <span class="font-weight-200 font-size-26">Close User</span>


                    </a>
                </div>
            </div>
        <?php } else   if (get_user_type() == 'Admin') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/hypersupermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/master_ajent.png" />
                        <span class="font-weight-200 font-size-26">Master Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/supermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/super_ajent.png" />
                        <span class="font-weight-200 font-size-26">Super Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ajent.png" />
                        <span class="font-weight-200 font-size-26">Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/users.png" />
                        <span class="font-weight-200 font-size-26">Client</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/closedusers/hypersupermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/close.png" />
                        <span class="font-weight-200 font-size-26">Close User</span>


                    </a>
                </div>
            </div>
        <?php }
         else   if (get_user_type() == 'Hyper Super Master') { ?>
           
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/supermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/super_ajent.png" />
                        <span class="font-weight-200 font-size-26">Super Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ajent.png" />
                        <span class="font-weight-200 font-size-26">Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/users.png" />
                        <span class="font-weight-200 font-size-26">Client</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/closedusers/supermaster" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/close.png" />
                        <span class="font-weight-200 font-size-26">Close User</span>


                    </a>
                </div>
            </div>
        <?php }
         else if (get_user_type() == 'Super Master') { ?>
           
         
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ajent.png" />
                        <span class="font-weight-200 font-size-26">Agent</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-warning">
                    <a href="<?php echo base_url(); ?>admin/users/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/users.png" />
                        <span class="font-weight-200 font-size-26">Client</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/closedusers/master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/close.png" />
                        <span class="font-weight-200 font-size-26">Close User</span>


                    </a>
                </div>
            </div>
        <?php }
         else if (get_user_type() == 'Master') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/users/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/users.png" />
                        <span class="font-weight-200 font-size-26">Client</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>admin/closedusers/user" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/close.png" />
                        <span class="font-weight-200 font-size-26">Close User</span>


                    </a>
                </div>
            </div>
        <?php }

        ?>

 
    </div>
</div>