<main id="main" class="main-content">
    <div class="container-fluid listing-grid">
        <div class="detail-row">
            <div class="heading-container">
                <h2 class="heading">Header Banner</h2>

                <a href="<?php echo base_url(); ?>add-header-banner" class="btn btn-success btn-sm add-new-btn">Add Banner</a>

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
                            <th style="width: 126px;">S.No</th>
                            <th style="width: 126px;">Header Preview</th>                            
                            <th style="width: 192px;">Status</th>
                            <th style="width: 192px;">Action</th>

                        </tr>
                    </thead>
                    <tbody id="filterdata">
                        <?php
                        if (!empty($header_banners)) {
                            $i = 1;
                            foreach ($header_banners as $banner) {
                                // p($payment_method);                                
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                    <img src="<?php echo base_url('assets/banner/' . $banner->header_banner_name) ?>" style="    height: 50px; width: -webkit-fill-available;">                           
                                    </td>
                                    <td><?php echo $banner->status ?></td>
                                    
                                    <td class="d-flex action_icon">
                                        <a href="add-header-banner/<?php echo $banner->id ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="delete-header-banner/<?php echo $banner->id ?> " onclick="return confirm('are you sure you want to delete header banner ')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                        <?php
                                        if ($banner->status == "Active") {
                                        ?>
                                            <a href="change-header-banner-status/Inactive/<?php echo $banner->id ?>" onclick="return confirm('Are you sure you want to make inactive')" data-toggle="tooltip" title="Deactivate"><i class="fa fa-toggle-on"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="change-header-banner-status/Active/<?php echo $banner->id ?>" onclick="return confirm('Are you sure you want to make active')" data-toggle="tooltip" title="Activate"><i class="fa fa-toggle-off"></i></a>
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

