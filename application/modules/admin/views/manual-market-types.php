<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Manual Market Types Lists
                </span>
                <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#exampleModal">
                    Add New
                </button>
            </div>
            <div class="row">


                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="tabel_content">
                        <div class="table-responsive sports-tabel" id="contentreplace">
                            <table class="table tabelcolor tabelborder">
                                <thead>
                                    <tr>
                                        <th scope="col">So.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date</th>


                                        <th scope="col">Action</th>
                                        <th style="test-align:center;">Status</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    if (!empty($market_types)) {
                                        $i = 1;
                                        foreach ($market_types as $market_type) {
                                    ?>

                                            <tr>
                                                <td style="font-size:15px;" scope="row"><?php echo $i++; ?></td>
                                                <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/manual/market-book-runners/<?php echo $market_type['event_id']; ?>/<?php echo $market_type['market_id']; ?>"><?php echo $market_type['market_name']; ?></a></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $market_type['status']; ?></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $market_type['data_type']; ?></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $market_type['created_at']; ?></td>

                                                <td style="font-size:15px;" scope="row"><?php


                                                                                        if ($market_type['data_type'] == 'MANUAL_MARKET') { ?>
                                                        <a class="edit-event" data-id="<?php echo $market_type['id']; ?>" data-market-id="<?php echo $market_type['market_id']; ?>" data-market-name="<?php echo $market_type['market_name']; ?>" data-open-date="<?php echo $market_type['market_start_time']; ?>" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td style="">
                                                    <!-- <label class="toggle-label"> -->

                                                    <?php

                                                    // p($market_type); 
                                                    if ($market_type['data_type'] == 'MANUAL_MARKET') { ?>
                                                        <label class="toggle-label">
                                                            <input type="checkbox" onclick="statusChange(`<?php echo $market_type['market_book_odd_id']; ?>`,`<?php echo $market_type['STATUS'] == 'OPEN' ? 'CLOSED' : 'OPEN'; ?>`);" class="ng-pristine ng-valid ng-touched" <?php

                                                                                                                                                                                                                                                                                if ($market_type['STATUS'] == 'OPEN') {
                                                                                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                ?>>
                                                            <span class="back">
                                                                <span class="toggle"></span>
                                                                <span class="label off ">OFF</span>
                                                                <span class="label on">ON</span>
                                                            </span>
                                                        </label>



                                                    <?php } ?>
                                                </td>

                                            </tr>
                                    <?php     }
                                    }

                                    ?>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="manual-event-types-form" name="manual-event-types-form">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content  ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Add Market Types</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Market Name</label>
                                <input type="hidden" name="list_market_id" id="list_market_id" class="form-control" />
                                <input type="hidden" name="list_id" id="list_id" class="form-control" />
                                <input type="hidden" name="event_id" id="event_id" class="form-control" value="<?php echo $event_id; ?>" />
                                <input type="text" class="form-control" name="market_name" id="market_name" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Open Date</label>

                                <input type="datetime-local" class="form-control" name="open_date" id="open_date" />

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $("#manual-event-types-form").validate({
        rules: {
            event_name: {
                required: true,
            },
            open_date: {
                required: true,
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();
            var market_name = $("#market_name").val().trim();
            var open_date = $("#open_date").val().trim();
            var list_market_id = $("#list_market_id").val().trim();
            var list_id = $("#list_id").val().trim();

            var event_id = '<?php echo $event_id; ?>';



            $("#exampleModal").modal("hide");
            $("#manual-event-types-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            $.ajax({
                url: base_url + "admin/Manual/addMarket",
                method: "POST",
                data: {
                    market_name: market_name,
                    open_date: open_date,
                    list_market_id: list_market_id,
                    event_id: event_id,
                    list_id: list_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        if (list_market_id != "") {
                            new PNotify({
                                title: "Success",
                                text: "Market Updated Successfully!",
                                type: 'success',
                                styling: "bootstrap3",
                                type: "success",

                                delay: 3000,
                            });
                        } else {
                            new PNotify({
                                title: "Success",
                                text: "Market Added Successfully!",

                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });
                        }
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    } else {
                        new PNotify({
                            title: "Error",
                            text: data.message ? data.message : "Something went wrong please try againe later",
                            styling: "bootstrap3",
                            type: "error",

                            delay: 3000,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
            });
            return false;
        },
    });

    $(document).on("click", ".edit-event", function() {
        var ids = $(this).data("id");
        var market_id = $(this).data("market-id");
        var market_name = $(this).data("market-name");
        var open_date = $(this).data("open-date");

        $("#market_name").val(market_name);
        $("#open_date").val(open_date);
        $("#list_market_id").val(market_id);
        $("#list_id").val(ids);


        $("#exampleModal").modal("show");
    });


    function statusChange(market_book_odd_id, status) {
        $.ajax({
            url: base_url + "admin/Manual/marketStatusChange",
            method: "POST",
            data: {
                market_book_odd_id: market_book_odd_id,
                status: status
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    if (market_book_odd_id != "") {
                        new PNotify({
                            title: "Success",
                            text: data.message,
                            type: 'success',
                            styling: "bootstrap3",
                            type: "success",

                            delay: 3000,
                        });
                    } else {
                        new PNotify({
                            title: "Success",
                            text: data.message,
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });
                    }
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                } else {
                    new PNotify({
                        title: "Error",
                        text: data.message ? data.message : "Something went wrong please try againe later",
                        styling: "bootstrap3",
                        type: "error",

                        delay: 3000,
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
            },
        });
    }
</script>