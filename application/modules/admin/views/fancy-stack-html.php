<div class="custom-scroll appendAjaxTbl table-responsive">
    <table class="table  jambo_table bulk_action" id="datatables">
        <thead>
            <tr class="headings">
                <th class="" width="5%">S.No. </th>
                <th width="70%">
                    Users </th>
                <th class="">Total Bet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;

             if (!empty($reports)) {
                foreach ($reports as $fan) {
                    ?>

                    <tr class=" content_user_table ">
                        <td><?php echo $i ?></td>
                        <td class=" ">
                            <?php echo $fan['name'] ?></td>
                        <td class=" "><?php echo $fan['total_stake'] ?> </td>
                    </tr>

                    <?php
                    $i++;
                }
            } else {
                ?>

                <tr>
                    <th colspan="3">No record found</th>
                </tr>

            <?php } ?>
        </tbody>
    </table>
    <p>Showing <?php echo $i - 1 ?> of <?php echo $i - 1 ?> entries </p>
    <p id="paginateClick" class="pagination-row dataTables_paginate paging_simple_numbers"></p>
</div>

<script src="https://www.365exch.vip/assets/js/serialize_json.js"></script>
