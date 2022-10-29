<div class="right_col" role="main" style="min-height: 435px;">
    <div class="col-md-12">
        <div class="title_new_at">Market PL
            <div class="pull-right">
                <button type="button" onclick="window.history.back()" class="btn_common" id="backbutton">Back</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="clearfix data-background">
            <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="report/fancystack">
            <form method="get" class="form-horizontal form-label-left input_mask" id="formSubmit">
                <input type="hidden" name="typeRE" id="typeRE" value="">
                <input type="hidden" name="parentId" id="parentId" value="47969">
                <div class="popup_col_2">
                    <input type="text" name="from_date" value="<?php echo date('Y-m-d h:m:s') ?>" id="from-date"
                           class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker"
                           placeholder="From date" autocomplete="off">
                </div>
                <div class="popup_col_2">
                    <input type="text" name="to_date" value="<?php echo date('Y-m-d h:m:s') ?>" id="to-date"
                           class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker"
                           placeholder="To date" autocomplete="off">
                </div>
                <div class="block_4 buttonacount">
                    <button type="button" class="blue_button" id="submit_form_button" value="filter"
                            onclick="filterdata()"><i class="fa fa-filter"></i> Filter
                    </button>
                    <a onclick="location.reload()" class="red_button"><i class="fa fa-eraser"></i> Clear</a>
                </div>
            </form>
            <div id="divLoading"></div>
            <!--Loading class -->
            <div class="col-md-12" id="stack">
                <?php echo $fancy ?>
            </div>
        </div>
    </div>
</div>
<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>

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
        $.blockUI({message: ' <img src="<?php echo base_url() ?>spinner.gif" />'});
    }

    function filterdata() {


        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filter_market_pl',
            data: {

                tdate: tdate,
                fdate: fdate,

            },
            type: "POST",
            dataType: 'json',
            beforeSend: function () {
                blockUI();
            },
            complete: function () {
                $.unblockUI();
            },
            success: function (res) {
                $('#stack').html('');
                $('#stack').html(res);
            }
        });
    }

</script>