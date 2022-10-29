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

    .heading {
        display: inline-block;
    }

    .add-new-btn {
        display: inline-block;
        float: right;
    }

    .heading-container {
        padding: 0px;

        border-bottom: 1px solid #efefef;
    }
</style>
<main id="main" class="main-content">
    <div class="container-fluid listing-grid">
        <div class="detail-row">
            <div class=" heading-container">
                <h2 class="heading">Deposit Requests</h2>

            </div>

            <div id="divLoading" class="">
            </div>
            <?php
            if (!empty($this->session->flashdata('operation_msg'))) {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('operation_msg'); ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="" style="overflow: scroll;">
                <table class="table table-striped table-bordered " style="width:100%" role="grid" aria-describedby="example_info" id="example" style="width:100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>User Name</th>
                            <th>Type</th>

                            <th>Amount</th>
                            <th>Reference Code</th>
                            <th>Check Screenshot</th>
                            <th>Balance</th>


                            <th>Avalable Balance</th>
                            <th>Remark</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="filterdata">
                        <?php
                        if (!empty($deposit_requests)) {
                            $i = 0;
                            foreach ($deposit_requests as $deposit_request) {
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo !empty($deposit_request['user_name']) ? $deposit_request['user_name'] : '-'; ?></td>
                                    <td><?php echo !empty($deposit_request['type']) ? $deposit_request['type'] : '-'; ?></td>
                                    <td><?php echo !empty($deposit_request['amount']) ? $deposit_request['amount'] : '-'; ?></td>
                                    <td><?php echo !empty($deposit_request['reference_code']) ? $deposit_request['reference_code'] : '-'; ?></td>
                                    <td><a href="<?php echo base_url('../assets/deposit_screenshot/' . $deposit_request['screenshot_name']) ?>" target="_blank">view</a></td>
                                    <td><?php echo count_total_balance_without_exposure($deposit_request['user_id']) ?></td>
                                    <td><?php echo (float)(count_total_balance($deposit_request['user_id'])); ?></td>
                                    <td><input value="<?php echo !empty($deposit_request['remark']) ? $deposit_request['remark'] : ''; ?>" name="remarks" id="remarks_<?php echo $i ?>" onchange="addremark($(this).val(),'remarks_link<?php echo $i ?>')"></td>

                                    <td class="d-flex action_icon">

                                        <a class="btn btn-success" onclick="return confirm('Are you sure you want to confirm the Deposit request')" href="confirm-deposit/<?php echo $deposit_request['id'] ?>/<?php echo $deposit_request['user_id'] ?>/<?php echo abs($deposit_request['amount']) ?>" title="Success">Confirm</a>

                                        <a class="btn btn-danger" href="change-deposit-request-status/Reject/<?php echo $deposit_request['id'] ?>" id="remarks_link<?php echo $i ?>" onclick='return validate_reject_btn("remarks_<?php echo $i ?>")' title="Reject">Reject</a>


                                    </td>


                                </tr>
                        <?php }
                        }else{
                            ?>
                               <tr>                                        
                                            <td colspan="11">
                                              No Request Found!
                                            </td>
                                        </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>


            </div>
            <div class="row" style="background:#fff;padding-top:10px">
                <div class=" col-sm-12">
                    <h3>Transaction History</h3>
                    <div class="table-responsive data-table" id="transaction_history">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentMethodModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</main>


<script>
    $(document).ready(function() {
        get_direct_transaction_history();

    });
    function get_direct_transaction_history() {
        var payment_type = 'Deposit';

        // showLoading();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/Transactions/get_direct_transaction_history_admins',
            data: {
                payment_type: payment_type,
            },
            type: "POST",
            success: function(res) {
                console.log(res);
                $('#transaction_history').html(res);
            }
        });
    }

    function openPaymentModel() {
        $('#paymentMethodModal').modal('show');
    }

    function addremark(val, id) {
        var link = $(`#${id}`).attr("href");
        if (val.trim() != "") {
            var newlink = $(`#${id}`).attr("href") + "/" + val.replaceAll(" ", "-");
            $(`#${id}`).attr("href", newlink);
        }
    }

    function validate_reject_btn(remarks_textbox_id) {

        if ($("#" + remarks_textbox_id).val() == "") {
            alert('please Enter The Remarks field');
            $("#" + remarks_textbox_id).focus()

            return false;
        } else {
            return true;
        }
    }
</script>