<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                Match Unlist From Settlement List.
            </span>
            <span class="lable-user-name pull-right">
                <input type="checkbox" class="sm" id="matchUnlist" data-toggle="toggle">

            </span>
        </div>
    </div>
    <div class="clearfix"></div>
    <br />
</div>


<div class="right_col" role="main" style="min-height: 490px;">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>
            <?php if ($is_tie === 'No') { ?>
                <div class="col-md-12" style="padding:0px;">
                    <div class="title_new_at" style="padding:15px;">
                        <span class="lable-user-name">
                            <?php echo $event_name; ?> Match Tie
                        </span>
                        <span class="lable-user-name pull-right">
                            <input type="checkbox" class="sm" id="matchTie" <?php if ($is_tie === 'Yes') {
                                                                                echo "checked";
                                                                            } ?> value="<?php echo $is_tie; ?>" data-toggle="toggle">

                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br />
            <?php } ?>

            <?php

            $is_empty = 'Yes';
            if (!empty($market_types)) {
                foreach ($market_types as $market_type) {
                    if ($is_tie === 'Yes') {
                        continue;
                    }

                    if (!empty($market_type->winner_selection_id)) {
                        continue;
                    }

                    $is_empty = 'No';
            ?>



                     <div class="col-md-12" style="padding:0px;">
                        <div class="title_new_at" style="padding:15px;">
                            <span class="lable-user-name">
                                <?php echo $event_name; ?> <?php echo $market_type->market_name; ?>

                                <?php
                                if ($market_type->settlement_status == 'Pending') {
                                ?>
                                    <span id="entry_pending_status_<?php echo $market_type->market_id; ?>" class="badge badge-warning">Pending</span>
                                <?php } else { ?>
                                    <span style="display:none;" id="entry_pending_status_<?php echo $market_type->market_id; ?>" class="badge badge-warning">Pending</span>
                                <?php  } ?>

                                <span style="display:none;" id="entry_complete_status_<?php echo $market_type->market_id; ?>" class="badge badge-success">Complete</span>
                            </span>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class=" appendAjaxTbl">
                        <table class="table table-striped jambo_table bulk_action" id="datatabless">
                            <thead>
                                <tr class="headings">
                                    <th>S.No.</th>

                                    <th colspan="2">Result</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>

                                <tr>
                                    <td>1</td>
                                    <td colspan="2">


                                        <select <?php
                                                if ($market_type->settlement_status == 'Pending') {
                                                ?> disabled <?php } ?> class="form-control" id="entry_<?php echo str_replace('.', '', $market_type->market_id); ?>">
                                            <option value="">--Select Result--</option>

                                            <?php

                                            if ($market_type->runners) {
                                                $runners = $market_type->runners;

                                                foreach ($runners as $runner) {
                                            ?>
                                                    <option <?php if (!empty($market_type->winner_selection_id)) {
                                                                if ($market_type->winner_selection_id == $runner['selection_id']) {
                                                                    echo 'selected';
                                                                }
                                                            } ?> value="<?php echo $runner['selection_id']; ?>"><?php echo $runner['runner_name']; ?></option>
                                            <?php }
                                            }

                                            ?>

                                        </select>
                                    </td>
                                    <td align="center"><button 
                                    
                                    <?php
                                                if ($market_type->settlement_status == 'Pending') {
                                                ?> disabled <?php } ?>
                                                
                                    type="button" class="btn btn-success btn-sm" id="btn_<?php echo $market_type->event_id; ?>" onclick="betSettle(<?php echo $market_type->event_id; ?>,'<?php echo $market_type->market_id; ?>',null,'Match','btn_<?php echo $market_type->event_id; ?>')" <?php
                                                                                                                                                                                                                                                                                                                        // if (!empty($winner_selection_id)) {
                                                                                                                                                                                                                                                                                                                        //     echo 'disabled';
                                                                                                                                                                                                                                                                                                                        // }  
                                                                                                                                                                                                                                                                                                                        ?>>Save</button></td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
            <?php  }
            }

            ?>

        </div>



    </div>
</div>

<?php
if (!empty($market_book_odds_fancy)) { ?>
    <div class="right_col" role="main" style="min-height: 490px;">
        <div class="col-md-12">
            <div class="title_new_at" style="padding:15px;">
                <span class="lable-user-name">
                    <?php echo $event_name; ?> Fancy
                </span>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="divLoading"></div>

                <div class=" appendAjaxTbl">
                    <table class="table table-striped jambo_table bulk_action" id="datatabless">
                        <thead>
                            <tr class="headings">
                                <th>S.No.</th>
                                <th>Runner</th>
                                <th>Price</th>
                                <th style="text-align: center;">Action</th>

                                <!-- <th style="text-align: center;">Fancy Entry</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            foreach ($market_book_odds_fancy as $fancy) {
                                $is_empty = 'No';
                                $background = '';

                                if ($fancy->total_bets > 0) {
                                    if ($i % 2 == 0) {
                                        $background = 'background-color:lightpink;';
                                    } else {
                                        $background = 'background-color:pink;';
                                    }
                                }



                            ?>
                                <tr style="<?php echo $background; ?>">

                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $fancy->runner_name; ?>
                                        <?php
                                        if ($fancy->settlement_status == 'Pending') {
                                        ?>
                                            <span id="entry_pending_status_<?php echo $fancy->selection_id; ?>" class="badge badge-warning">Pending</span>
                                        <?php } else { ?>
                                            <span style="display:none;" id="entry_pending_status_<?php echo $fancy->selection_id; ?>" class="badge badge-warning">Pending</span>
                                        <?php  } ?>

                                        <span style="display:none;" id="entry_complete_status_<?php echo $fancy->selection_id; ?>" class="badge badge-success">Complete</span>

                                    </td>
                                    <td style="width:160px;">
                                        <input <?php
                                                if ($fancy->settlement_status == 'Pending') {
                                                ?> readonly <?php }
                                                            ?> type="text" id="entry_<?php echo $fancy->selection_id; ?>" class="form-control" value="<?php echo $fancy->result; ?>" />
                                    </td>
                                    <td align="center"><button <?php
                                                                if ($fancy->settlement_status == 'Pending') {
                                                                ?> disabled <?php } ?> id="btn_<?php echo $fancy->selection_id; ?>" type="button" class="btn btn-success btn-sm" onclick="betSettle(<?php echo $fancy->match_id; ?>,null,'<?php echo $fancy->selection_id; ?>','Fancy','btn_<?php echo $fancy->selection_id; ?>')">Save</button></td>
                                </tr>




                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<?php  } ?>


<!-- Modal -->
<div class="modal fade" id="settleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content  ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Bet Settled Response &nbsp;<span id="upper-user"></span></h5>
                <button type="button" class="close" onclick="location.reload();" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="settleModalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="location.reload();" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function betSettle(event_id, market_id, selection_id, bet_type, button_id) {

        console.log(event_id + '---' + market_id);

        if (bet_type == 'Match') {
            var entry = $('#entry_' + market_id.replace('.', '')).val();

        } else {
            var entry = $('#entry_' + selection_id).val();

        }
        if (entry.trim() === '') {
            alert('Please enter correct value!');
            if (bet_type == 'Match') {
                var entry = $('#entry_' + market_id.replace('.', '')).focus();

            } else {
                var entry = $('#entry_' + selection_id).focus();

            }
        } else {
            var conf = confirm('Are you sure you want to submit this entry?');


            if (conf) {
                $('#' + button_id).attr('disabled', true);
                if (bet_type == 'Match') {
                    $('#entry_' + market_id.replace('.', '')).attr('disabled', true);

                    $('#btn_' + market_id.replace('.', '')).attr("disabled", 'disabled');
                    $('#entry_pending_status_' + market_id.replace('.', '')).show();

                } else {
                    $('#entry_' + selection_id).attr('disabled', true);
                    $('#btn_' + selection_id).attr("disabled", 'disabled');
                    $('#entry_pending_status_' + selection_id).show();

                }

                // $.blockUI();
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/settlement/entrysubmit",
                    method: "POST",
                    data: {
                        event_id: event_id,
                        market_id: market_id,
                        bet_type: bet_type,
                        entry: entry,
                        selection_id: selection_id
                    },
                    dataType: "json",
                    success: function(response) {
                        // $.unblockUI();

                        // $('#settleModal').modal('show');
                        // console.log(response.htmlData);


                        $('#entry_pending_status_' +  market_id.replace('.', '')).hide();


                        if (response.success) {
                            $('#entry_complete_status_' +  market_id.replace('.', '')).show();
                        } else {
                            alert(response.message);
                        }

                        // $('#settleModalBody').html(response.htmlData);
                        // new PNotify({
                        //     title: "Success",
                        //     text: "Bet Settled successfully",
                        //     styling: "bootstrap3",
                        //     type: "success",
                        //     delay: 3000,
                        // });

                        // setTimeout(function() {
                        //     window.location.reload(1);
                        // }, 2000);
                    }
                })
            }
        }

    }
    $('#matchTie').change(function() {
        var conf = confirm('Are you sure you want to tie this match?');
        var is_tie = $(this).val();
        if (conf) {

            // $.blockUI();

            $.ajax({
                url: "<?php echo base_url(); ?>admin/settlement/eventTieToggle",
                method: "POST",
                data: {
                    event_id: <?php echo $event_id; ?>,
                    is_tie: is_tie
                },
                dataType: "json",
                success: function(response) {

                    if (response.success) {
                        // $('#entry_success_status_' + selection_id).show();
                    } else {
                        alert(response.message);
                    }


                    // $.unblockUI();
                    // new PNotify({
                    //     title: "Success",
                    //     text: "Bet Settled successfully",
                    //     styling: "bootstrap3",
                    //     type: "success",
                    //     delay: 3000,
                    // });
                    // setTimeout(function() {
                    //     window.location.reload(1);
                    // }, 2000);
                }
            })
        }
    })

    $('#matchUnlist').change(function() {

        var conf = confirm('Are you sure you want to unlist this match?');

        var is_tie = $(this).val();
        if (conf) {

            $.blockUI();

            $.ajax({
                url: "<?php echo base_url(); ?>admin/settlement/eventUnlist",
                method: "POST",
                data: {
                    event_id: <?php echo $event_id; ?>,
                    is_tie: is_tie,
                    market_id: "<?php echo $match_odds_market_id; ?>"
                },
                success: function(response) {
                    $.unblockUI();
                    new PNotify({
                        title: "Success",
                        text: "Bet Settled successfully",
                        styling: "bootstrap3",
                        type: "success",
                        delay: 3000,
                    });
                    setTimeout(function() {
                        // window.location.reload(1);
                        window.location = '<?php echo base_url(); ?>admin/settlement/events/<?php echo $event_type; ?>';
                    }, 1000);
                }
            })
        } else {
            event.preventDefault();
        }
    })
</script>