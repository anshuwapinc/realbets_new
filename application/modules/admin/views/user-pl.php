<div class="right_col" role="main" style="min-height: 435px;">
    <div class="col-md-12">
        <div class="title_new_at">User PL
            <div class="pull-right"><button type="button" class="btn_common" id="backbutton">Back</button> </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="clearfix data-background">
            <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="report/fancystack">
            <form method="get" class="form-horizontal form-label-left input_mask" id="formSubmit">
                <input type="hidden" name="typeRE" id="typeRE" value="">
                <input type="hidden" name="parentId" id="parentId" value="47969">
                <div class="popup_col_2">
                    <input type="text" name="from_date" value="<?php echo date('Y-m-d h:i:s') ?>" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="From date" autocomplete="off">
                </div>
                <div class="popup_col_2">
                    <input type="text" name="to_date" value="<?php echo date('Y-m-d h:i:s')?>" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="To date" autocomplete="off">
                </div>
                <div class="popup_col_1">
                    <select name="filter_sport" class="form-control" id="event_type">
                        <option value="3" cricket="">Cricket</option>
                        <option value="2">Tennis</option>
                        <option value="1">Soccer</option>
                        <option value="6">Teenpatti</option>
                        <option value="7">Fancy</option>
                    </select>
                </div>
                <div class="popup_col_1">
                    <select name="filter_order" class="form-control" id="order_by">
                        <option value="desc">Top</option>
                        <option value="asc">Bottom</option>
                    </select>
                </div>
                <div class="popup_col_1">
                    <select name="filter_value" class="form-control" id="rowNo">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="block_4 buttonacount">
                    <button type="button" class="blue_button" id="submit_form_button" value="filter" onclick="filterdata()"><i class="fa fa-filter"></i> Filter</button>
                    <a onclick="location.reload()" class="red_button"><i class="fa fa-eraser"></i> Clear</a>
                <div class="popup_col_12">
                    <div id="betsalltab" class="tab_bets">
                        <div class="nav nav-pills match-lists">
                            <li class=""><a onclick="customGap('lm')">Last Month</a></li>
                            <li class="active"><a onclick="customGap('lw')">Last Week</a></li>
                            <li class=""><a onclick="customGap('y')">Yesterday</a></li>
                            <li><a onclick="filterdata()">Today</a></li>
                            <input type="hidden" id="inputFilterDate" name="Filterdate" value="w">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    <div id="divLoading"> </div>
    <!--Loading class -->
    <div class="col-md-12" id="stack">
        <?php echo $fancy ?>
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
        var orderBy = $("#order_by").val();
        var eventType = $("#event_type").val();
        var rowNo = $("#rowNo").val();


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filter_userpl',
            data: {

                tdate: tdate,
                fdate: fdate,
                orderBy:orderBy,
                eventType:eventType,
                rowNo:rowNo
                
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

    function customGap(type) {

        var tdate = '<?php  echo date('Y-m-d h:i:s')?>';
        if(type=='lm'){
            var fdate = '<?php  echo date('Y-m-d h:i:s',strtotime("-1 months"))?>';
        }
        if(type=='lw'){
            var fdate = '<?php  echo date('Y-m-d h:i:s',strtotime("-1 weeks"))?>';
        }
        if(type=='y'){
            var fdate = '<?php  echo date('Y-m-d h:i:s',strtotime("-1 days"))?>';
        }
        var orderBy = $("#order_by").val();
        var eventType = $("#event_type").val();
        var rowNo = $("#rowNo").val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filter_userpl',
            data: {

                tdate: tdate,
                fdate: fdate,
                orderBy:orderBy,
                eventType:eventType,
                rowNo:rowNo
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