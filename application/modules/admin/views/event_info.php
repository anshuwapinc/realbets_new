<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                if (isset($response->results[0]) && !empty($response->results[0])) {
                ?>
                    <div class="col-md-12" style="background-color:#FFF; margin-top:10px; border:1px solid #efefef; border-radius:5px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding:12px;">
                        <h3><?php echo $response->results[0]->event->name; ?></h3>
                    </div>


                    <div class="col-md-12" style="background-color:#FFF; margin-top:10px; border:1px solid #efefef;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding:0px; margin-bottom:20px;">

                        <table class="table table-bordered" style="margin:0px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="70%">Match Odds</th>
                                    <th width="15%" style="text-align:center;font-weight:bold;">Back</th>
                                    <th width="15%" style="text-align:center;font-weight:bold;">Lay</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (sizeof($response->results[0]->markets) > 0) {

                                    foreach ($response->results[0]->markets[0]->runners as $runner) {
                                ?>
                                        <tr>
                                            <td width="70%"><?php echo $runner->description->runnerName; ?></td>
                                            <td width="15%" style="background-color:#ade2fa;text-align:center;font-weight:bold;"><?php echo $runner->exchange->availableToBack[0]->price; ?></td>
                                            <td width="15%" style="background-color:#f8c0c0; text-align:center;font-weight:bold;"><?php echo $runner->exchange->availableToLay[0]->price; ?></td>

                                        </tr>
                                <?php }
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<script>
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>