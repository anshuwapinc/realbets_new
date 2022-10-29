<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Profit &amp; Loss
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class='row'>
                <div class="col-md-12">
                    <div class="filter_page data-background">
                        <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="profitloss">
                        <form method="get" id="formSubmit" class="form-horizontal form-label-left input_mask">
                            <div class="col-md-2 col-xs-6">
                                <input type="text" name="from_date" value="<?php echo get_yesterday_datetime(); ?>" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="From date" autocomplete="off">
                            </div>
                            <div class="col-md-2 col-xs-6">
                                <input type="text" name="to_date" value="<?php echo get_today_end_datetime(); ?>" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left" placeholder="To date" autocomplete="off">
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <input type="hidden" name="user_id" value="47978">
                                <input type="hidden" name="perpage" id="perpage" value="10">
                                <select class="form-control" name="sportid" id="sportid">
                                    <option value="5" selected="">All</option>
                                    <option value="4">Cricket</option>
                                    <option value="1">Soccer</option>
                                    <option value="2">Tennis</option>
                                    <option value="11">Live teenpatti</option>
                                    <option value="12">Live Casino</option>
                                    <option value="13">Live Game</option>
                                    <option value="0" <?php echo empty($sportid) ? null : ($sportid == 0 && $sportid != null ? 'selected' : NULL) ?>>Fancy</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-xs-6" style="display:none;">
                                <input type="text" class="form-control" placeholder="Via event name" name="searchTerm" value="">
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <button type="button" onclick="filterdata()" class="blue_button" id="submit_form_button" value="filter" data-attr="submit">Filter</button>
                                <a onclick="location.reload()" class="red_button"><i class="fa fa-eraser"></i>
                                    Clear</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 table-responsive sports-tabel">
                    <div id="divLoading"> </div>
                    <!--Loading class -->

                    <?php if (empty($profit_loss)) { ?>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="">Date </th>
                                    <th class="">Title </th>
                                    <th class="">Win </th>
                                    <th class="">Loss </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="4">No record found</th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class=" ">
                                    <th class="">(Total P &amp; L ) 0</th>
                                    <th class="">(Total Commition) 0</th>
                                </tr>

                            </thead>
                        </table>
                        <p>Showing 1 to 0 of 0 entries </p>
                        <p id="paginateClick" class="pagination-row dataTables_paginate paging_simple_numbers"> </p>
                    <?php } else {
                        echo $profit_loss;
                    }
                    ?>

                </div>
            </div>
        </section>
    </div>
</div>


<script>
     $('#from-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD H:mm:ss',
        timePicker: true,
    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD H:mm:ss',
        timePicker: true,
    });


    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {

        var sportId = $("#sportid").val();
        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var searchTerm = $("input[name='searchTerm']").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterProfiltLoss',
            data: {
                sportId: sportId,
                tdate: tdate,
                fdate: fdate,
                searchTerm: searchTerm,
                user_id: "<?php echo $user_id; ?>"
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
                $('#tablegh').html('');
                $('#tablegh').html(res);
            }
        });
    }
</script>