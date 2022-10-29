<div class="right_col" role="main">
    <div class="fullrow tile_count">
        <?php

        if (get_user_type() == 'Super Admin') { ?>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(C)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-agent" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(A)</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(SA)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(MA)</span>


                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-sba" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(SBA)</span>


                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Admin') { ?>



            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(C)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-agent" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(A)</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(SA)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-master" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(MA)</span>


                    </a>
                </div>
            </div>



        <?php } else if (get_user_type() == 'Hyper Super Master') { ?>




            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(C)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-agent" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(A)</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-super" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(SA)</span>


                    </a>
                </div>
            </div>




        <?php } else if (get_user_type() == 'Super Master') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-client" style="width:100%; height:100%">

                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(C)</span>


                    </a>
                </div>
            </div>

            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-agent" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(A)</span>
                    </a>
                </div>
            </div>


        <?php } else if (get_user_type() == 'Master') { ?>
            <div class="col-md-3 col-6 col-xs-6 home-page-tiles">
                <div class="bg-white">
                    <a href="<?php echo base_url(); ?>client/txn-client" style="width:100%; height:100%">
                        <img src="<?php echo base_url(); ?>assets/images/ledger.png" />
                        <span class="font-weight-200 font-size-26">Debit/Credit Entry(C)</span>
                    </a>
                </div>
            </div>
        <?php }
        ?>

            
    </div>
</div>