<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Account Statement
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class="clearfix data-background">
                <div class="row">
                    <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="report/fancystack">
                    <form method="get" class="form-horizontal form-label-left input_mask" id="formSubmit">
                        <input type="hidden" name="typeRE" id="typeRE" value="">
                        <input type="hidden" name="parentId" id="parentId" value="47969">
                        <div class="col-md-5 col-xs-6">
                            <input type="text" name="from_date" value="<?php echo date('Y-m-d h:i:s a') ?>" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="From date" autocomplete="off">
                        </div>
                        <div class="col-md-5 col-xs-6">
                            <input type="text" name="to_date" value="<?php echo date('Y-m-d h:i:s a') ?>" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="To date" autocomplete="off">
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <button type="button" style="width:100%;" class="btn btn-success" id="submit_form_button" value="filter" onclick="filterdata()"><i class="fa fa-filter"></i> Filter</button>
                            <!-- <a onclick="location.reload()" class="red_button"><i class="fa fa-eraser"></i> Clear</a>
                        <a class="blue_button" href="<?php echo base_url(); ?>admin/reports/profitloss/0">View Match Bets</a> -->
                        </div>
                    </form>




                    <div id="divLoading"> </div>
                    <!--Loading class -->
                    <div class="col-md-12" id="stack">
                        <?php echo $fancy ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>

<script>
    $('#from-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD hh:mm A',
        timePicker: true,
    });
    $('#to-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'YYYY-MM-DD hh:mm A',
        timePicker: true,
    });

    function blockUI() {
        $.blockUI({
            message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
        });
    }

    function filterdata() {


        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();



        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterFanctyStack',
            data: {

                tdate: tdate,
                fdate: fdate,

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
                $('#stack').html('');
                $('#stack').html(res);
            }
        });
    }
</script>