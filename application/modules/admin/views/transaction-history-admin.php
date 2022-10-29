<style>
    .loaddetail {
        cursor: pointer;
        background: #444;
        padding: 5px 10px;
        text-decoration: none;
        color: #fff;
        border-radius: 3px;
        margin-right: 3px;
        text-transform: uppercase;
        display: inline-block;
    }

    /* .row {
        display: flex;
    } */

    /* .row .col-md-6 {
        width: 50%;
    } */
</style>
<main id="main" class="main-content">
<div class="listing-grid">
    <div class="detail-row">
        <h2 style="padding-left:5px">Transaction History</h2>

        <div id="divLoading" class="">
        </div>
        <div style="background-color: white;">
            <ul class="nav d-flex">
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($All) ? "" : $All ?>" href="<?php echo base_url('transaction-history-admin/All') ?>">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($Request) ? "" : $Request ?>" href="<?php echo base_url('transaction-history-admin/Request') ?>">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($Confirm) ? "" : $Confirm ?>" href="<?php echo base_url('transaction-history-admin/Confirm') ?>">Confirmed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($Reject) ? "" : $Reject ?>" href="<?php echo base_url('transaction-history-admin/Reject') ?>">Rejected</a>
                </li>
            </ul>
            <hr />
            <form>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="hidden" id="status" name="status" value="<?php echo $status ?>">
                        <label for="type">Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-control">
                            <option value="All">All</option>
                            <option value="Deposit">Deposit</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">

                        <label for="type">Client</label>
                        <select name="client_id"  id="client_id" class="form-control js-example-placeholder-single js-states">
                            <option value=""> -- Select --</option>
                            <?php
                            foreach ($clients as $client) {
                            ?>
                                <option value="<?php echo $client->user_id ?>"><?php echo $client->name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="type">From</label>
                            <input type="text" name="fdate" id="fdate" value="<?php echo date('m/d/Y', strtotime('-1 month')); ?>" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="type">To</label>
                            <input type="text" name="tdate" id="tdate" value="<?php echo date('m/d/Y'); ?>" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-1" style="padding-bottom:5px">
                        <label style="width: 100%">&nbsp;</label>
                        <center><button type="button" class="btn btn-success" onclick="filterdata()"> Load </button></center>
                    </div>
                </div>
            </form>
            <div class="table-responsive data-table" id="filterdata">
                <?php
                echo $transaction_history_table;
                ?>
            </div>
        </div>
    </div>
</div>
</main>

<script>
    $(document).ready(function() {

        $('#fdate').daterangepicker({
            drops: 'down',
            showDropdowns: false,
            singleDatePicker: true,

            locale: {
                format: 'MM/DD/YYYY'
            },

        });
        $('#tdate').daterangepicker({
            drops: 'down',
            showDropdowns: false,
            singleDatePicker: true,

            locale: {
                format: 'MM/DD/YYYY'
            },

        });


        // var h = $('#example').DataTable({
        //     "pageLength": 50,
        //     "order": [],
        //     dom: 'Bfrtip',
        //     buttons: [{
        //             extend: 'pdfHtml5',
        //             title: 'Account Statement Report',
        //             exportOptions: {
        //                 columns: "thead th:not(.noExport)"
        //             }
        //         },
        //         {
        //             extend: 'excel',
        //             title: 'Account Statement Report',
        //             exportOptions: {
        //                 columns: "thead th:not(.noExport)"
        //             }
        //         }
        //     ]
        // });
    });



    function filterdata() {
        var payment_type = $("#payment_type").val();
        var tdate = $("input[name='tdate']").val();
        var fdate = $("input[name='fdate']").val();
        var status = $("#status").val();
        var client_id = $("#client_id").val();
        // showLoading();
        $.ajax({
            url: '<?php echo base_url(); ?>transaction-history-admin',
            data: {
                payment_type: payment_type,
                tdate: tdate,
                fdate: fdate,
                status: status,
                client_id: client_id,
            },
            type: "POST",
            success: function(res) {
                console.log(res);
                $('#filterdata').html(res);
            }
        });
    }
    $(".js-example-placeholder-single").select2({
    placeholder: "Select Client",
    allowClear: true
});
</script>