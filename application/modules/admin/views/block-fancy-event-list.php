<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Fancy Listing
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <div class="table-responsive sports-tabel" id="contentreplace">
                <table class="table tabelcolor tabelborder" id="example">
                    <thead>
                        <tr>
                            <th scope="col">S.No. </th>
                            <th scope="col">Fancy Name</th>
                            <th scope="col">ON/OFF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($fancy_results)) {
                            $i = 1;
                            foreach ($fancy_results as $fancy_result) {
                                $fancy_result = (array) $fancy_result;

                                $style = '';
                                if ($fancy_result['game_status'] == 'SUSPENDED') {
                                    $style = 'style="color:blue"';
                                }
                        ?>
                                <tr>
                                    <td <?php echo $style; ?>><?php echo $i++; ?>.</td>
                                    <td <?php echo $style; ?> class=" " <?php

                                                                        if (isset($fancy_result['block_status'])) {
                                                                            echo 'style="color:red;"';
                                                                        } else {
                                                                            echo 'style="color:green;"';
                                                                        }
                                                                        ?>>
                                        <?php echo $fancy_result['runner_name']; ?>
                                    </td>
                                    <td <?php echo $style; ?>>
                                        <img src="<?php echo base_url(); ?>assets/images/<?php echo isset($fancy_result['block_status']) ? 'resume_icon.png' : 'pause_icon.png'; ?>" style="margin-top:0px;" onclick="blockMarket(<?php echo isset($fancy_result['match_id']) ? $fancy_result['match_id'] : 0; ?>, <?php echo get_user_id(); ?>,  <?php echo isset($fancy_result['match_id']) ? $fancy_result['match_id'] : 0; ?>,  <?php echo isset($fancy_result['market_id']) ? $fancy_result['market_id'] : 0; ?>,  <?php echo isset($fancy_result['selection_id']) ? $fancy_result['selection_id'] : 0; ?>,<?php echo isset($fancy_result['user_type']) ? $fancy_result['user_type'] : 0; ?>, <?php echo isset($fancy_result['block_status']) ? 1 : 0; ?> ,'Fancy');" height="25">
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
                    </section>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "searching": true,
            "paging": true,
        });
    });

    function blockAllFancy() {
        var con = confirm("Are you sure you want to block all fancy?");
        if (con) {


            var request = {
                sportId: '<?php echo $event_type; ?>',
                userId: userId,
                matchId: '<?php echo $event_id; ?>',
                marketId: 0,
                fancyId: 0,
                usertype: usertype,
                IsPlay: IsPlay,
                Type: Type,
            };
            jQuery.ajax({
                url: base_url + "admin/BlockMarket/block_market_update",
                data: request,
                type: "post",
                dataType: "json",
                success: function success(data) {
                    if (data.success) {
                        socket.emit("block_markets", {
                            data: request,
                        });

                        new PNotify({
                            title: "Success",
                            text: data.message,
                            type: "success",
                            styling: "bootstrap3",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                        /*if (marketId == 0) {
                          	//Sport Match
                          	setTimeout(function () { location.reload();}, 3000);
                          } else if (marketId.search(".") > -1) {
                          	//Market
                          	if (IsPlay == 1) {
                          		document.getElementById('play-' + marketId).style.display = 'none';
                          		document.getElementById('pause-' + marketId).style.display = 'block';
                          	}
                          	else {
                          		document.getElementById('pause-' + marketId).style.display = 'none';
                          		document.getElementById('play-' + marketId).style.display = 'block';
                          	}
                          }*/
                    } else {
                        new PNotify({
                            title: "403 Error",
                            text: data.message,
                            type: "error",
                            styling: "bootstrap3",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                },
            });
        }
    }

    function preBlockAllFancy() {
        var con = confirm("Are you sure you want to block all pre fancy?");
        if (con) {


            var request = {
                matchId: '<?php echo $event_id; ?>',
                sportId: '<?php echo $event_type; ?>',

            };
 
            jQuery.ajax({
                url: base_url + "admin/BlockMarket/pre_block_fancy",
                data: request,
                type: "post",
                dataType: "json",
                success: function success(data) {
                    if (data.success) {
                        socket.emit("block_markets", {
                            data: request,
                        });

                        new PNotify({
                            title: "Success",
                            text: data.message,
                            type: "success",
                            styling: "bootstrap3",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                        /*if (marketId == 0) {
                          	//Sport Match
                          	setTimeout(function () { location.reload();}, 3000);
                          } else if (marketId.search(".") > -1) {
                          	//Market
                          	if (IsPlay == 1) {
                          		document.getElementById('play-' + marketId).style.display = 'none';
                          		document.getElementById('pause-' + marketId).style.display = 'block';
                          	}
                          	else {
                          		document.getElementById('pause-' + marketId).style.display = 'none';
                          		document.getElementById('play-' + marketId).style.display = 'block';
                          	}
                          }*/
                    } else {
                        new PNotify({
                            title: "403 Error",
                            text: data.message,
                            type: "error",
                            styling: "bootstrap3",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                },
            });
        }
    }
</script>