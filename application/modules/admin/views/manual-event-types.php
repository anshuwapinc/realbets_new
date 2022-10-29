<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Manual Sport Types
                </span>

                <!-- <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#exampleModal">
                    Add New
                </button> -->
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
                                        <!-- <th scope="col">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    if (!empty($event_types)) {
                                        $i = 1;
                                        foreach ($event_types as $event_type) { ?>

                                            <tr>
                                                <td style="font-size:15px;" scope="row"><?php echo $i++; ?></td>
                                                <td style="font-size:15px; font-weight:bold;"><a href="<?php echo base_url(); ?>admin/manual/events/<?php echo $event_type['event_type']; ?>"><?php echo $event_type['name']; ?></a></td>

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
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Sport Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sport Type</label>
                                <input type="hidden" name="sport_type_id" id="sport_type_id" class="form-control" />
                                <input type="text" class="form-control" name="sport_type_name" id="sport_type_name" />

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
            sport_type_name: {
                required: true,
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();
            var sport_type_name = $("#sport_type_name").val().trim();
            var sport_type_id = $("#sport_type_id").val().trim();

            $("#exampleModal").modal("hide");
            $("#manual-event-types-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            $.ajax({
                url: base_url + "admin/Manual/addEventTypes",
                method: "POST",
                data: {
                    sport_type_id: sport_type_id,
                    sport_type_name: sport_type_name,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        if (news_id != "") {
                            new PNotify({
                                title: "Success",
                                text: "News Updated successfully",
                                type: data.notifytype,
                                styling: "bootstrap3",
                                type: "success",

                                delay: 3000,
                            });
                        } else {
                            new PNotify({
                                title: "Success",
                                text: "News Created successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });
                        }
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Error",
                            text: "Something went wrong please try againe later",
                            styling: "bootstrap3",
                            type: "error",

                            delay: 3000,
                        });
                    }
                },
            });
            return false;
        },
    });
</script>