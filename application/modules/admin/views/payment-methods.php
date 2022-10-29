<main id="main" class="main-content">
    <div class="container-fluid listing-grid">
        <div class="detail-row">
            <div class="heading-container">
                <h2 class="heading">Payment Methods</h2>

                <a href="<?php echo base_url(); ?>add-payment-method" class="btn btn-success btn-sm add-new-btn">Add New</a>

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

            <div class="" style="
    overflow: scroll;
">
                <table class="table table-striped table-bordered " style="width:100%" role="grid" aria-describedby="example_info" id="example" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width: 126px;">S.No</th>
                            <th style="width: 126px;">Type</th>
                            <th style="width: 126px;">Vendor</th>
                            <th style="width: 592px;">UPI ID / Account Number</th>
                            <th style="width: 192px;">Acclount Holders Name</th>
                            <th style="width: 192px;">IFSC Code</th>
                            <th style="width: 192px;">Status</th>
                            <th style="width: 192px;">Action</th>

                        </tr>
                    </thead>
                    <tbody id="filterdata">
                        <?php
                        if (!empty($payment_methods)) {
                            $i = 0;
                            foreach ($payment_methods as $payment_method) {
                                // p($payment_method);
                                $i++;
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo !empty($payment_method['type']) ? $payment_method['type'] : '-'; ?></td>
                                    <td><?php echo !empty($payment_method['vendor']) ? $payment_method['vendor'] : '-'; ?></td>
                                    <td><?php echo !empty($payment_method['account_number']) ? $payment_method['account_number'] : '-'; ?></td>
                                    <td><?php echo !empty($payment_method['account_holder_name']) ? $payment_method['account_holder_name'] : '-'; ?></td>
                                    <td><?php echo !empty($payment_method['ifsc_code']) ? $payment_method['ifsc_code'] : '-'; ?></td>
                                    <td>
                                        <?php
                                        echo  $payment_method['status'];
                                        ?></td>

                                    <td class="d-flex action_icon"><a href="add-payment-method/<?php echo $payment_method['id'] ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="delete-payment-method/<?php echo $payment_method['id'] ?> " onclick="return confirm('are you sure you want to delete payment method ')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                        <?php
                                        if ($payment_method['status'] == "Active") {
                                        ?>
                                            <a href="change-payment-method-status/Inactive/<?php echo $payment_method['id'] ?>" onclick="return confirm('Are you sure you want to deactivate payment method')" data-toggle="tooltip" title="Deactivate"><i class="fa fa-toggle-on"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="change-payment-method-status/Active/<?php echo $payment_method['id'] ?>" onclick="return confirm('Are you sure you want to activate payment method')" data-toggle="tooltip" title="Activate"><i class="fa fa-toggle-off"></i></a>
                                        <?php
                                        }
                                        ?>

                                    </td>


                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>


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
        // filterdata();
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


    function openPaymentModel() {
        $('#paymentMethodModal').modal('show');
    }
</script>