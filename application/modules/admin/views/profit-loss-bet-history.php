<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Profit Loss Bet History
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class='row'>
                <div class="col-md-12 ">
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                    <div class="clearfix data-background">
                        <input type="hidden" name="ajaxUrl" id="ajaxUrl" value="bethistory">
                        <form method="post" id="formSubmit" class="form-horizontal form-label-left input_mask"><input type="hidden" name="compute" value="3d52c13ced1cebb6db5450515eee8422">
                            <input type="hidden" name="sportId" id="sportId" value="4">
                            <input type="hidden" name="perpage" id="perpage" value="10">

                            <div class="popup_col_1">
                                <input type="text" name="searchTerm" value="" id="mstruserid" maxlength="100" size="50" class="form-control" placeholder="Search">
                            </div>

                            <div class="popup_col_3">
                                <button type="button" onclick="filterdata()" name="submit" class="blue_button" id="submit_form_button" value="filter" data-attr="submit"><i class="fa fa-filter"></i> Filter
                                </button>
                                <a onclick="location.reload()" class="red_button"><i class="fa fa-eraser"></i>
                                    Clear</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;" >
                    <div id="divLoading"></div>
                    <!--Loading class -->
                    <div class="col-md-12" id="stack" style="padding:0px;" >
                        <?php echo $betting ?>
                    </div>



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

        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var searchterm = $("#mstruserid").val();
        var bstatus = $("#betStatus").val();
        var pstatus = 'Settled';


        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/profitLossfilterbethistory',
            data: {
                tdate: tdate,
                fdate: fdate,
                searchterm: searchterm,
                bstatus: bstatus,
                pstatus: pstatus,
                user_id: <?php echo $user_id; ?>,
                market_id: '<?php echo $market_id; ?>',
                match_id: '<?php echo $match_id; ?>',
                is_fancy: '<?php echo $is_fancy; ?>',

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
                $('#example').DataTable({
                    "searching": false,
                    "paging": false,
                });
            }
        });
    }

    function customGap(stype) {
        $("#betsalltab>li.active").removeClass("active");

        $("#sport-" + stype).parent().addClass('active');
        var tdate = $("#to-date").val();
        var fdate = $("#from-date").val();
        var sportstype = stype;
        var searchterm = $("#mstruserid").val();
        var bstatus = $("#betStatus").val();
        var pstatus = $("#pStatus").val();

        $.ajax({
            url: '<?php echo base_url(); ?>admin/Reports/filterbethistory',
            data: {

                tdate: tdate,
                fdate: fdate,
                sportstype: sportstype,
                searchterm: searchterm,
                bstatus: bstatus,
                pstatus: pstatus,
                user_id: <?php echo $user_id; ?>,




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


    $(document).ready(function() {
        $('#example').DataTable({
            "searching": false,
            "paging": false,
        });
    });
</script>