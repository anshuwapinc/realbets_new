<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                <?php echo $event_name; ?> Bettings
            </span>

            <button class="btn btn-danger btn-xs pull-right" onclick="deleteBettings()" style="padding:4px 5px; margin-right:5px;">
                Delete
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>

            <div class="card-body" style="overflow-x: scroll;min-height:500px;">
                <table class="table table-striped jambo_table bulk_action" id="example">
                    <thead>
                        <tr class="headings">
                            <th></th>
                            <th>S.No.</th>
                            <th>Place Name</th>
                            <th>User Name</th>
                            <th>Status</th>

                            <th>Stake</th>
                            <th>Price</th>
                            <th>Bet Result</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($bettings)) {
                            $i = 1;
                            foreach ($bettings as $betting) {

                                // p($betting);
                        ?>
                                <tr>
                                    <td><input type="checkbox" name="betting_id[]" value="<?php echo $betting['betting_id']; ?>" />
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $betting['place_name']; ?></td>
                                    <td><?php echo $betting['user_name']; ?></td>

                                    <td><span class="badge badge-success" style="background-color:forestgreen;"><?php echo $betting['status']; ?></span></td>
                                    <td><?php echo $betting['stake']; ?></td>
                                    <td><?php echo $betting['price_val']; ?></td>
                                    <td><?php echo $betting['bet_result']; ?></td>


                                    <td align="center"><a href="<?php echo base_url(); ?>admin/bettings/deletebet/<?php echo $betting['list_event_id']; ?>/<?php echo $betting['betting_id']; ?>"><i class="fa fa-trash" style="font-size:15px;"></i></a></td>

                                </tr>
                        <?php  }
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "searching": true,
            "paging": true,
        });
    });

    function deleteBettings() {
        var bettings = new Array();

        $("input[name='betting_id[]").each(function(index, obj) {
            // loop all checked items
            if (this.checked) {
                bettings.push(obj.value);
            }
        });

        if (bettings.length <= 0) {
            bootbox.alert("Please select atleast one bet");
            return false;
        }
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);


        $.ajax({
            url: "<?php echo base_url(); ?>admin/bettings/ajxdeletebet",
            method: "POST",
            dataType: "json",
            data: {
                bettings: bettings
            },
            success: function(data) {
                $.unblockUI
                if (data.success) {

                    new PNotify({
                        title: "Success",
                        text: data.message,
                        styling: "bootstrap3",
                        type: "success",
                        delay: 3000,
                    });

                    setTimeout(function() {
                        window.location.reload(1);
                    }, 2000);
                }
            }

        })
    }
</script>