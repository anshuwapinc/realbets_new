<div class="right_col" role="main">
    <div class="fullrow tile_count">
    <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>myledger" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">My Ledger</span>


                    </a>
                </div>
            </div>
        <?php

        if (get_user_type() == 'Super Admin') { ?>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/sba" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">SBA Ledger</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/master" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Master Ledger</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Super Ledger</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/agent" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Agent Ledger</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Client Ledger</span>


                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Admin') { ?>



            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/master" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Master Ledger</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Super Ledger</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/agent" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Agent Ledger</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Client Ledger</span>


                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Hyper Super Master') { ?>




            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Super Ledger</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/agent" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Agent Ledger</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Client Ledger</span>


                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Super Master') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/agent" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Agent Ledger</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Client Ledger</span>


                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Master') { ?>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>new_chipsummary/client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/cash_transaction.png" />
                        <span class="font-weight-200 font-size-26">Client Ledger</span>


                    </a>
                </div>
            </div>


        <?php }
        ?>


    </div>
</div>