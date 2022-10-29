<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Profit Loss Listing
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class='row'>
                <div class="col-md-12">
                    <div class="filter_page data-background">
                        <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="profitloss">

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="overflow:auto;">
                    <div id="divLoading"> </div>
                    <!--Loading class -->

                    <?php
                    if (empty($profit_loss)) { ?>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="">S.No. </th>
                                    <th class="">Event Name </th>
                                    <th class="">Market </th>
                                    <th class="">P_L </th>
                                    <th class="">Commission </th>
                                    <th class="">Created On </th>
                                    <th class="">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="8">No record found</th>
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
        format: 'YYYY-MM-DD'
    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD'
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