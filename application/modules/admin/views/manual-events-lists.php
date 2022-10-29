<style>
    .runner-status {
        display: inline-block;
        font-weight: bold;
        font-size: 15px;
        text-align: center;
    }
</style>
<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Manual Events Lists
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


                                        <th scope="col" colspan="3">Action</th>
                                        <th style="test-align:center;">Status</th>
                                        <!-- <th style="test-align:center;">Show Bets</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    if (!empty($list_events)) {
                                        $i = 1;
                                        foreach ($list_events as $list_event) {

                                            // p($list_event);
                                    ?>

                                            <tr>
                                                <td style="font-size:15px;" scope="row"><?php echo $i++; ?></td>
                                                <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/manual/market-types/<?php echo $list_event['list_event_id']; ?>/<?php echo $list_event['event_id']; ?>"><?php echo $list_event['event_name']; ?></a></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $list_event['status']; ?></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $list_event['data_type']; ?></td>
                                                <td style="font-size:15px;" scope="row"><?php echo $list_event['created_at']; ?></td>

                                                <td style="font-size:15px;" scope="row"><?php

                                                                                        if ($list_event['data_type'] == 'MANUAL_MATCH') { ?>
                                                        <a class="edit-event" data-list-event-id="<?php echo $list_event['list_event_id']; ?>" data-event-name="<?php echo $list_event['event_name']; ?>" data-open-date="<?php echo $list_event['open_date']; ?>" href="javascript:void(0);"><i class="fa fa-edit"></i></a>
                                                    <?php }
                                                    ?>

                                                    <button type="button" class="btn btn-primary btn-xs" onclick="unlistEvent('<?php echo $list_event['list_event_id']; ?>')">
                                                        Unlist
                                                    </button>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td style="">
                                                    <!-- <label class="toggle-label"> -->

                                                    <?php

                                                    if ($list_event['data_type'] == 'MANUAL_MATCH') { ?>
                                                        <label class="toggle-label">
                                                            <input type="checkbox" onclick="statusChange(`<?php echo $list_event['list_event_id']; ?>`,<?php echo isset($list_event['event_id']) ? $list_event['event_id'] : 0; ?>, `<?php echo $list_event['status'] == 'Open' ? 'Closed' : 'Open';  ?>`);" class="ng-pristine ng-valid ng-touched" <?php

                                                                                                                                                                                                                                                                                                                                                        if ($list_event['status'] == 'Open') {
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

                                                <!-- <td style="">

                                                    <a class="btn btn-primary btn-xs" href="<?php echo base_url() ?>admin/manual/eventbets/<?php echo $list_event['event_id']; ?>">
                                                        Bettings
                                                    </a>
                                                </td> -->
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
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Name</label>
                                <input type="hidden" name="list_event_id" id="list_event_id" class="form-control" />
                                <input type="text" class="form-control" name="event_name" id="event_name" />

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
    $(document).ready(function() {
        $(".tabelborder").DataTable();
    })
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
            var event_name = $("#event_name").val().trim();
            var open_date = $("#open_date").val().trim();
            var list_event_id = $("#list_event_id").val().trim();
            var event_type = '<?php echo $event_type; ?>';



            $("#exampleModal").modal("hide");
            $("#manual-event-types-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            $.ajax({
                url: base_url + "admin/Manual/addEvents",
                method: "POST",
                data: {
                    event_name: event_name,
                    open_date: open_date,
                    list_event_id: list_event_id,
                    event_type: event_type
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        if (list_event_id != "") {
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
            return false;
        },
    });

    $(document).on("click", ".edit-event", function() {

        var list_event_id = $(this).data("list-event-id");

        var event_name = $(this).data("event-name");
        var open_date = $(this).data("open-date");

        $("#list_event_id").val(list_event_id);
        $("#event_name").val(event_name);
        $("#open_date").val(open_date);

        $("#exampleModal").modal("show");
    });

    function statusChange(list_event_id, event_id, status) {
        $.ajax({
            url: base_url + "admin/Manual/eventStatusChange",
            method: "POST",
            data: {
                list_event_id: list_event_id,
                event_id: event_id,
                status: status
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    if (list_event_id != "") {
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
                    // setTimeout(function() {
                    //     window.location.reload(1);
                    // }, 1000);
                } else {
                    new PNotify({
                        title: "Error",
                        text: "Something went wrong please try againe later",
                        styling: "bootstrap3",
                        type: "error",

                        delay: 3000,
                    });
                    // setTimeout(function() {
                    //     window.location.reload(1);
                    // }, 1000);
                }
            },
        });
    }

    function unlistEvent(list_event_id) {
        let result = window.confirm('Are You Sure');
        if (result) {
            $.ajax({
                url: base_url + "admin/Manual/unlistManualEvent",
                method: "POST",
                data: {
                    list_event_id: list_event_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {

                        new PNotify({
                            title: "Success",
                            text: data.message,
                            type: 'success',
                            styling: "bootstrap3",
                            type: "success",

                            delay: 3000,
                        });
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

    }
</script>