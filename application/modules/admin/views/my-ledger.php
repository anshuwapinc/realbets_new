<div class="right_col" role="main">
    <div class="col-md-12">
        <div class="title_new_at"> My Ledger
             <!-- <button type="button" class="btn btn-success" onclick="refresh_data()">Refresh</button> -->
            <!-- <select style="color:black" onchange="perPage(this.value)">
                <option value="10" selected="">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> -->
        </div>
    </div>
    <div class="col-md-12">
        <div class="filter_page data-background">
            <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="profitloss">
            
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="divLoading"> </div>
        <!--Loading class -->

        <?php if (empty($profit_loss)) { ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="">Date </th>
                        <th class="">Collection Name </th>
                        <th class="">Debit </th>
                        <th class="">Credit </th>
                        <th class="">Blanace </th>
                        <th class="">Payment Type </th>
                        <th class="">Remark </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="4">No record found</th>
                    </tr>
                </tbody>
            </table>
           
            <p id="paginateClick" class="pagination-row dataTables_paginate paging_simple_numbers"> </p>
        <?php } else {
            echo $profit_loss;
        }
        ?>

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


    function refresh_data() {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/myledgerdata',
            data: {
                 
             },
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                // blockUI();
            },
            complete: function() {
                // $.unblockUI();
            },
            success: function(res) {
                // $('#chip-summary-data').html(res);
            }
        });
    }
</script>