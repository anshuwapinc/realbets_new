<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    CLIENT LIVE BETS REPORT
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>

            <div class="clearfix data-background" style="display:none;">
                <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="gameclientbet">
                <form method="get" class="form-horizontal form-label-left input_mask" id="formSubmit">
                    <input type="hidden" name="user_id" id="user_id" value="47978">
                    <input type="hidden" name="event_id" id="event_id" value="">
                    <div class="col-md-2 col-xs-6">
                        <input type="text" name="from_date" value="" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="From date" autocomplete="off">
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <input type="text" name="to_date" value="" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="To date" autocomplete="off">
                    </div>

                    <div class="col-md-2 col-xs-6">
                        <input type="text" name="roundid" value="" id="roundid" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="Round Id" autocomplete="off">
                    </div>
                    <?php
                    if (get_user_type() !== 'User') { ?>
                        <div class="col-md-2 col-xs-6">
                            <input type="text" name="userName" value="" id="userName" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="Search" autocomplete="off">
                        </div>
                    <?php } ?>



                    <div class="col-md-2 col-xs-6">
                        <select style="color:black" name="searchType" id="searchType" class="form-control">
                            <option value="" selected="">All Game</option>


                            <?php
                            if (!empty($event_types)) {
                                foreach ($event_types as $event_type) { ?>
                                    <option value="<?php echo $event_type['event_type']; ?>"><?php echo $event_type['name']; ?></option>

                            <?php }
                            }

                            ?>


                        </select>
                    </div>

                    <div class="col-md-2 col-xs-6">
                    <button type="button" id="submit_form_button" style="width:100%;" class="btn btn-success" data-attr="submit" onclick="filterdata()"><i class="fa fa-filter"></i> Filter</button>
                       
                    </div>
                    <!-- <div class="col-md-2 col-xs-12">
                        <button type="button" id="submit_form_button" class="btn btn-success" data-attr="submit" onclick="filterdata()"><i class="fa fa-filter"></i> Filter</button>

                    </div> -->
                </form>
            </div>
            <div class="">
                <div id="divLoading"> </div>
                <!--Loading class -->
                <div class="custom-scroll data-background appendAjaxTbl" style="overflow:auto;">


                    <table class="table table-striped jambo_table bulk_action full-table-clint" id="example">
                        <thead>
                            <tr class="headings">
                                <th>Datetimes </th>
                                <?php
                                if (get_user_type() !== 'User') { ?>

                                    <th>User </th>

                                <?php } ?>
                                <th>Game</th>
                                <th>Round id</th>
                                <th>Bet details</th>
                                <th>Selection</th>
                                <th>Bet Type</th>
                                <th>Type</th>
                                <th>Match Odds</th>

                                <th>Stake</th>

                                <th>P&amp;L</th>


                            </tr>
                        </thead>
                        <tbody id="liveBetHistoryBody">
                            <?php
                            if (!empty($reports)) {
                                foreach ($reports as $report) {

                            ?>
                                    <tr>
                                        <td><?php echo date('d M Y H:i:s', strtotime($report['created_at'])); ?></td>
                                        <?php
                                        if (get_user_type() !== 'User') { ?>

                                            <td><?php echo $report['client_name']; ?> (<?php echo $report['client_user_name']; ?>)</td>

                                        <?php } ?>
                                        <td><?php echo $report['game']; ?></td>
                                        <td><?php echo $report['betting_id']; ?></td>
                                        <td><?php echo $report['event_name']; ?>
                                            <?php
                                            if ($report['betting_type'] != 'Fancy') {
                                                echo '/' . $report['market_name'];
                                            } ?>
                                            /<?php echo $report['place_name']; ?></td>
                                        <td class=""><?php
                                                        if ($report['betting_type'] == 'Fancy') {
                                                        } else {
                                                            echo $report['place_name'];
                                                        }

                                                        ?></td>
                                        <td><?php
                                            if ($report['is_back'] == 1) {
                                                echo "Back";
                                            } else {
                                                echo "Lay";
                                            }
                                            ?></td>
                                        <td><?php echo $report['betting_type']; ?></td>
                                        <td><?php echo $report['price_val']; ?></td>

                                        <td><?php
                                            if (get_user_type() == 'User') {
                                                echo $report['loss'];
                                            } else {
                                                echo $report['loss'];
                                            }
                                            ?></td>
                                        <td><?php
                                            if (get_user_type() == 'User') {
                                                echo $report['profit'];
                                            } else {
                                                echo $report['profit'];
                                            }
                                            ?></td>


                                    </tr>
                                <?php   }
                            } else { ?>
                                <tr>
                                    <td colspan="9">No record found.</td>
                                </tr>
                            <?php }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    </div>
</div>


<script>
    $(document).ready(function() {


        $('#example').DataTable({
            "searching": false,
            "paging": false,
            "order": []

        });
    });

    $('#from-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD',
        // timePicker: true,

    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD',
        // timePicker: true,
    });

    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {

        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var roundid = $("#roundid").val();
        var searchType = $("#searchType").val();
        var betStatus = 'Open';
        var userName = $("#userName").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterlivebethistory',
            data: {
                tdate: tdate,
                fdate: fdate,
                roundid: roundid,
                searchType: searchType,
                betStatus: betStatus,
                user_id: <?php echo $user_id; ?>,
                user_type: '<?php echo $user_type; ?>',

                userName: userName
            },
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            complete: function() {
                $.unblockUI();
            },
            success: function(res) {
                $('#liveBetHistoryBody').html(res);
                $('#example').DataTable();

            }
        });
    }
</script>