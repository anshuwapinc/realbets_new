<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Account Statement
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>

            <form method="post" id="formSubmit"><input type="hidden" name="compute" value="514a93b5013ae455df37263fb90956f7">

                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type; ?>">

                <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="acStatement">


                <div class="select_account">
                    <div class="radio">
                        <input id="radio-1" type="radio" name="fltrselct" value="1" <?php

                                                                                    if ($fltrselct == 1) {
                                                                                        echo "checked";
                                                                                    }
                                                                                    ?> >
                        <label for="radio-1" class="radio-label">All</label>
                    </div>
                    <div class="radio">
                        <input id="radio-2" type="radio" name="fltrselct" value="2" <?php

if ($fltrselct == 2) {
    echo "checked";
}
?> >
                        <label for="radio-2" class="radio-label">Free Chips</label>
                    </div>
                    <div class="radio">
                        <input id="radio-3" type="radio" name="fltrselct" value="7" <?php

if ($fltrselct == 7) {
    echo "checked";
}
?> >
                        <label for="radio-3" class="radio-label">Settlement</label>
                    </div>
                    <div class="radio">
                        <input id="radio-4" type="radio" name="fltrselct" value="6" <?php

if ($fltrselct == 6) {
    echo "checked";
}
?> >
                        <label for="radio-4" class="radio-label">Profit and Loss</label>
                    </div>
                    <div class="radio">
                        <input id="radio-5" type="radio" name="fltrselct" value="1" <?php

if ($fltrselct == 1) {
    echo "checked";
}
?> >
                        <label for="radio-5" class="radio-label">Account Statement</label>
                    </div>
                </div>
                <div class="row form-horizontal">
                    <div class="col-md-2 col-xs-6">
                        <input type="text" name="fdate" id="fdate" value="<?php echo get_yesterday_datetime(); ?>" class="form-control" placeholder="From Date" autocomplete="off">
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <input type="text" name="tdate" id="tdate" value="<?php echo get_today_end_datetime(); ?>" class="form-control" placeholder="To Date" autocomplete="off">
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <input type="text" name="searchTerm" id="searchTerm" value="" class="form-control" placeholder="Search" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <button type="button" class="btn btn-success" onclick="filterdata()">Filter</button>
                        <a href="javascript:void(0);" onclick="window.reload()" class="btn btn-danger">Clear</a>
                    </div>
                </div>
            </form>


            <div id="filterdata" class="table-responsive sports-tabel">
                <?php echo $accountStmt; ?>
            </div>

        </section>
    </div>
</div>


<script>
    // $(document).ready(function() {
    //     $('#example').DataTable();
    // });
    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {

        var fltrselct = $("input[name='fltrselct']:checked").val();
        var tdate = $("input[name='tdate']").val();
        var fdate = $("input[name='fdate']").val();
        var searchTerm = $("input[name='searchTerm']").val();
        var user_id = $("input[name='user_id']").val();
        var user_type = $("input[name='user_type']").val();



        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterAcStatement',
            data: {
                fltrselct: fltrselct,
                tdate: tdate,
                fdate: fdate,
                searchTerm: searchTerm,
                user_id: user_id,
                user_type: user_type,

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
                $('#filterdata').html(res);
            }            
        });
    }

    function ShowBet(userId, matchId, MarketId, type, back) {
        window.location.href = "<?php echo base_url(); ?>report/showbet/" + userId + '/' + matchId + '/' +
            MarketId + '/' + type + '/' + back;
    }
    $('#fdate').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD H:mm:ss',
        timePicker: true,
    });
    $('#tdate').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD H:mm:ss',
        timePicker: true,
    });
</script>