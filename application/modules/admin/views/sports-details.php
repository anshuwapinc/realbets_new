<div class="right_col" role="main">
    <div class="col-md-12" >
        <div class="title_new_at" > Sport Details <small>Display Sport Details Like Match & Session Position etc.</small>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="divLoading"> </div>
        <!--Loading class -->

        <?php if (empty($profit_loss)) { ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                    <th class=""> </th>
                        <th class="">Code </th>
                        <th class="">Date </th>
                        <th class="">Name </th>

                        <th class="">Time </th>
                        <th class="">Declare </th>
                        <th class="">Won By </th>
                        <th class="">Profit & Loss </th>
                        <th class="">Plus Minus </th>
                        <th class="">SNo </th>
                        <th class="">Code </th>
                        <th class="">Date </th>
                        <th class="">Name </th>

                        <th class="">Time </th>
                        <th class="">Declare </th>
                        <th class="">Won By </th>
                        <th class="">Profit & Loss </th>
                        <th class="">Plus Minus </th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="10">No record found</th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class=" ">
                        <th colspan="9"> </th>
                        <th class="">0</th>
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