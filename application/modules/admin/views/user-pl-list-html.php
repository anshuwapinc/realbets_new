<style>

    .user {
        color: #4083A9;
    }
    .postive{
        color: #3c763d;
    }
    .negative{
        color: #a94442;
    }
</style>
<div class="custom-scroll appendAjaxTbl">
    <h5>Filter criteria : From <span
                class="span-from"><?php echo empty($fromDate) ? date('Y-m-d h:m:s') : $fromDate ?></span> To <span
                class="span-to"><?php echo empty($toDate) ? date('Y-m-d h:m:s') : $toDate ?></span>, <?php echo $row_no ?>
        records in order of cricket desc</h5>
    <table class="table table-striped jambo_table bulk_action" id="datatables">
        <thead>
        <tr class="headings">
            <th width="5%">S.No.</th>
            <th>Username</th>
            <th>Cricket</th>
            <th>Tennis</th>
            <th>Soccer</th>
            <th>Teenpatti</th>
            <th>Fancy</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        if (!empty($reports[0]['betting_id'])) {

            foreach ($reports as $fan) {

                $cricket= get_user_pl_by_events($fan['user_id'],3);
                $tenis= get_user_pl_by_events($fan['user_id'],2);
                $soccer=get_user_pl_by_events($fan['user_id'],1);
                $fancy= get_fancy_pl($fan['user_id']);
                $live_game= get_user_pl_by_events($fan['user_id'],6);
                $live_teenpatti= get_user_pl_by_events($fan['user_id'],7);
                $casino= get_user_pl_by_events($fan['user_id'],8);

                ?>

                <tr class=" content_user_table ">
                    <td><?php echo $i ?></td>
                    <td class=" ">
                       <span class="user"> <?php echo $fan['name'] . '-' . $fan['user_name'] ?></span></td>
                    <td class=" ">
                        <span class="<?php echo check_if_negative($cricket)?>"><?php echo $cricket  ?> </span></td>
                    <td class=" ">
                        <span class="<?php echo check_if_negative($tenis)?>"><?php echo $tenis ?> </span></td>
                    <td class=" "> <span class="<?php echo check_if_negative($soccer)?>"><?php echo $soccer ?> </span></td>
                    <td class=" "> <span class="<?php echo check_if_negative($live_teenpatti)?>"><?php echo $live_teenpatti?></span> </td>
                    <td class=" "> <span class="<?php echo check_if_negative($fancy)?>"><?php echo $fancy ?></span> </td>
                </tr>

                <?php
                $i++;
            }
        } else {
            ?>

            <tr>
                <th colspan="7">No record found</th>
            </tr>

        <?php } ?>
        </tbody>
    </table>
    <p>Showing <?php echo $i - 1 ?> of <?php echo $i - 1 ?> entries </p>
    <p id="paginateClick" class="pagination-row dataTables_paginate paging_simple_numbers"></p>
</div>

<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>
