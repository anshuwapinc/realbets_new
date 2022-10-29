
<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Client PL
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="clearfix data-background">
                        <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="report/fancystack">
                        <form method="get" class="form-horizontal form-label-left input_mask" id="formSubmit">
                            <input type="hidden" name="typeRE" id="typeRE" value="">
                            <input type="hidden" name="parentId" id="parentId" value="47969">
                            <div class="col-md-2 col-xs-6">
                                <input type="text" name="from_date" value="<?php echo date('Y-m-d H:m:s', strtotime($fromDate)) ?>" id="from-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="From date" autocomplete="off">
                            </div>
                            <div class="col-md-2 col-xs-6">
                                <input type="text" name="to_date" value="<?php echo date('Y-m-d H:m:s', strtotime($toDate)) ?>" id="to-date" class="form-control col-md-7 col-xs-12 has-feedback-left datetimepicker" placeholder="To date" autocomplete="off">
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <button type="button" class="btn btn-success" id="submit_form_button" value="filter" onclick="filterdata()"><i class="fa fa-filter"></i> Filter
                                </button>
                                <a onclick="location.reload()" class="btn btn-danger"><i class="fa fa-eraser"></i> Clear</a>
                            </div>
                        </form>
                        <div id="divLoading"></div>
                        <!--Loading class -->

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="stack">
                    <?php echo $fancy ?>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

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
            url: '<?php echo base_url(); ?>admin/Reports/filter_client_pl',
            data: {

                tdate: tdate,
                fdate: fdate,
                user_id: <?php echo $userId; ?>
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