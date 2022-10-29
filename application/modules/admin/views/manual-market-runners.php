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
                <span class="lable-user-name" style="width:200px;display:inline-block;">
                    Manual Market Runners Lists
                </span>

                <select id="result" name="result" class="form-control  form-control-sm" style="width:200px;display:inline-block;">
                    <option value="">--Select Result--</option>
                    <?php
                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $select = '';


                            if ($runner['selection_id'] == $market_type['winner_selection_id']) {
                                $select = 'selected';
                            }
                    ?>
                            <option <?php echo $select; ?> value="<?php echo $runner['selection_id']; ?>"><?php echo $runner['runner_name']; ?></option>

                    <?php }
                    }
                    ?>
                </select>
                <button type="button" onclick="updateResult()" class="btn btn-success btn-sm">Save</button>

                <select id="all-status" name="all-status" class="form-control  form-control-sm" style="width:200px;display:inline-block;">
                    <option value="">--Select Status--</option>
                    <option value="OPEN">OPEN</option>
                    <option value="CLOSE">CLOSE</option>
                    <option value="SUSPENDED">SUSPENDED</option>
                </select>

                <button type="button" onclick="updateRecordAll()" class="btn btn-success btn-sm">Update All</button>


            </div>
            <div class="row">


                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="tabel_content">
                        <div class="table-responsive sports-tabel" id="contentreplace">
                            <table class="table tabelcolor tabelborder">
                                <thead>
                                    <tr>

                                        <th scope="col">Team Name</th>
                                        <th scope="col" style="text-align:center;">Back Price</th>
                                        <th scope="col" style="text-align:center;">Lay Price </th>
                                        <th scope="col" style="text-align:center;">Status</th>
                                        <th scope="col" style="text-align:center;" colspan="2">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="runner-body">
                                    <?php
                                    if (!empty($runners)) {
                                        foreach ($runners as $runner) { ?>

                                            <tr>
                                                <td><input type="hidden" name="runner_id_<?php echo $runner['selection_id']; ?>" id="runner_id_<?php echo $runner['selection_id']; ?>" value="<?php echo $runner['id']; ?>" /><input type="text" placeholder="Team" name="runner_name_<?php echo $runner['selection_id']; ?>" class="form-control input-sm runner_id" id="runner_name_<?php echo $runner['selection_id']; ?>" value="<?php echo $runner['runner_name']; ?>" /></td>

                                                <td><input type="text" placeholder="Back Price" name="back_1_price_<?php echo $runner['selection_id']; ?>" id="back_1_price_<?php echo $runner['selection_id']; ?>" class="form-control input-sm" style="width:100%;display:inline-block;margin-right:10px;" value="<?php echo $runner['back_1_price']; ?>" /></td>

                                                <td><input type="text" placeholder="Lay Price" name="lay_1_price_<?php echo $runner['selection_id']; ?>" class="form-control input-sm" style="width:100%;display:inline-block;margin-right:10px;" id="lay_1_price_<?php echo $runner['selection_id']; ?>" value="<?php echo $runner['lay_1_price']; ?>" /></td>


                                                <td style="width:20%">
                                                    <div class="btn-group">
                                                        <div class="form-check runner-status">
                                                            <input type="radio" class="form-check-input" id="open_<?php echo $runner['selection_id']; ?>" name="status_<?php echo $runner['selection_id']; ?>" <?php

                                                                                                                                                                                                                if ($runner['status'] == 'OPEN') {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?> value="OPEN">
                                                            <label class="form-check-label" for="open_<?php echo $runner['selection_id']; ?>">&nbsp;Open</label>
                                                        </div>
                                                        <div class="form-check runner-status">&nbsp;&nbsp;
                                                            <input value="SUSPENDED" <?php

                                                                                        if ($runner['status'] == 'SUSPENDED') {
                                                                                            echo 'checked';
                                                                                        }
                                                                                        ?> type="radio" class="form-check-input" id="susp_<?php echo $runner['selection_id']; ?>" name="status_<?php echo $runner['selection_id']; ?>">
                                                            <label class="form-check-label" for="susp_<?php echo $runner['selection_id']; ?>">&nbsp;Susp</label>
                                                        </div>
                                                        <div class="form-check runner-status">&nbsp;&nbsp;
                                                            <input <?php

                                                                    if ($runner['status'] == 'CLOSE') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?> value="CLOSE" type="radio" name="status_<?php echo $runner['selection_id']; ?>" id="close_<?php echo $runner['selection_id']; ?>" class="form-check-input">
                                                            <label class="form-check-label" for="close_<?php echo $runner['selection_id']; ?>">&nbsp;Close</label>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs" onclick="updateRecord('<?php echo $runner['selection_id']; ?>')">Update</button>

                                                </td>
                                                <td>

                                                <?php

 
                                                                    if($runner['is_cancel'] == 'Yes')
                                                                    { ?>
 <button type="button" class="btn btn-danger btn-xs" disabled onclick="cancelBets('<?php echo $runner['selection_id']; ?>')">Bet Canceled</button>
                                                                    <?php }
                                                                    else
                                                                    { ?>
 <button type="button" class="btn btn-danger btn-xs" onclick="cancelBets('<?php echo $runner['selection_id']; ?>')">Bet Cancel</button>
                                                                   <?php } ?>
 
                                                   

                                                </td>

                                            </tr>
                                    <?php }
                                    }
                                    ?>


                                </tbody>
                            </table>

                            <div class="col-md-12">
                                <center><button onclick="addNewRow()" type="button" class="btn btn-success btn-xs">Add New</button></center>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
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

    function addNewRow() {

        var runner_length = $(".runner_id").length;

        runner_length += 1
        console.log('runner_length', runner_length);


        var html = '';
        html += `<tr>`;
        html += `<td><input type="hidden"   name="runner_id_` + runner_length + `" id="runner_id_` + runner_length + `" value="" /><input type="text" placeholder="Team" name="runner_name_` + runner_length + `" class="form-control input-sm runner_id"" id="runner_name_` + runner_length + `" value="" /></td>`

        html += `<td><input type="text" placeholder="Back Price" name="back_1_price_` + runner_length + `"  id="back_1_price_` + runner_length + `" class="form-control input-sm" style="width:100%;display:inline-block;margin-right:10px;"   /></td>`;

        html += `<td><input type="text" placeholder="Lay Price" name="lay_1_price_` + runner_length + `" class="form-control input-sm" style="width:100%;display:inline-block;margin-right:10px;" id="lay_1_price_` + runner_length + `" value="" /></td>`;


        html += `<td style="width:20%">`;
        html += `<div class="btn-group">`;
        html += `<div class="form-check runner-status">`;
        html += `<input type="radio" class="form-check-input" id="open_` + runner_length + `"   name="status_` + runner_length + `" checked value="OPEN">
                                                    <label class="form-check-label" for="open_` + runner_length + `">&nbsp;Open</label>
                                                </div>
                                                <div class="form-check runner-status" >&nbsp;&nbsp;
                                                    <input  value="SUSPENDED" type="radio" class="form-check-input" id="susp_` + runner_length + `" name="status_` + runner_length + `" >
                                                    <label class="form-check-label" for="susp_` + runner_length + `">&nbsp;Susp</label>
                                                </div>
                                                <div class="form-check runner-status">&nbsp;&nbsp;
                                                    <input value="CLOSE" type="radio" 
                                                    name="status_` + runner_length + `"  id="close_` + runner_length + `"class="form-check-input" >
                                                    <label class="form-check-label" for="close_` + runner_length + `">&nbsp;Close</label>
                                                </div>

                                            </div>
                                        </td>`;

        html += `<td>
                                            <button type="button" class="btn btn-success btn-xs" onclick="updateRecord(` + runner_length + `)">Update</button>
                                             
                                        </td>`;


        html += `</tr>`;



        $('#runner-body').append(html);
    }

    function updateRecord(runner_row_id) {
        var runner_id = $('#runner_id_' + runner_row_id).val();

        var team_name = $('#runner_name_' + runner_row_id).val();
        var back_1_price = $('#back_1_price_' + runner_row_id).val();
        var back_1_size = 5000;
        var lay_1_price = $('#lay_1_price_' + runner_row_id).val();
        var lay_1_size = 5000;
        var event_id = '<?php echo $event_id; ?>';
        var market_id = '<?php echo $market_id; ?>';
        if (team_name.trim() == "") {
            alert("Sorry Runner Name can not be blank");
            return false;
        }
        var status = $("input[name=status_" + runner_row_id + "]:checked").val();
        if (back_1_price.trim() == 0 && lay_1_price.trim() == 0 && status.trim() == 'OPEN') {
            alert("Please Add Any one Price Back or lay Or Suspend or Close it");
            return false;
        }
        var data = {
            team_name: team_name,
            back_1_price: back_1_price,
            back_1_size: back_1_size,
            lay_1_price: lay_1_price,
            lay_1_size: lay_1_size,
            status: status,
            event_id: event_id,
            market_id: market_id,
            runner_row_id: runner_id
        }


        $.ajax({
            url: base_url + "admin/Manual/addRunners",
            method: "POST",
            data: data,
            dataType: "JSON",
            success: function(data) {


                if (data.success) {
                    if (runner_id == "") {
                        new PNotify({
                            title: "Success",
                            text: 'Runner Added Successfully',
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
                            title: "Success",
                            text: 'Runner Updated Successfully',
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });


                    }

                } else {
                    new PNotify({
                        title: "Error",
                        text: "Something went wrong please try againe later",
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


        console.log('data', data);

    }

    function updateRecordAll() {
        var status = $(`#all-status`).val();

        var event_id = '<?php echo $event_id; ?>';
        var market_id = '<?php echo $market_id; ?>';

        var data = {
            event_id: event_id,
            market_id: market_id,
            status: status
        }


        $.ajax({
            url: base_url + "admin/Manual/updateStatusRecordAll",
            method: "POST",
            data: data,
            dataType: "JSON",
            success: function(data) {

                if (data.success) {

                    new PNotify({
                        title: "Success",
                        text: 'All Record Updated Successfully',
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


        console.log('data', data);

    }


    function updateResult(runner_row_id) {
        var entry = $('#result').val();
        var event_id = '<?php echo $event_id; ?>';
        var market_id = '<?php echo $market_id; ?>';


        if (entry == '') {
            alert("Please select valid result");
        } else {
            var data = {

                event_id: event_id,
                market_id: market_id,
                entry: entry
            }


            $.ajax({
                url: base_url + "admin/Manual/resultEntrySubmit",
                method: "POST",
                data: data,
                dataType: "JSON",
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
                            title: "PENDING",
                            text: data.message,
                            styling: "bootstrap3",
                            type: "info",

                            delay: 300000,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
            });

        }




    }


    function cancelBets(selection_id) {
        var event_id = '<?php echo $event_id; ?>';
        var market_id = '<?php echo $market_id; ?>';

        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        $.ajax({
            url: "<?php echo base_url(); ?>admin/bettings/ajxdeletebetby_runner",
            method: "POST",
            dataType: "json",
            data: {
                match_id: event_id,
                market_id: market_id,
                selection_id: selection_id,
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