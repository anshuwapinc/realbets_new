<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                User Details
            </span>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>

                 <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>User Name </th>
                            <th>Role</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($users_arr)) {
                            $i = 1;
                            foreach ($users_arr as $user) {


                        ?>
                                <tr>

                                    <td><?php echo $user['user_name']; ?></td>




                                    <td><?php echo $user['type']; ?> </td>


                                </tr>
                            <?php   }
                        } else { ?>
                            <tr>
                                <td colspan="2" style="text-align:center;color:red;font-weight:bold;">User not found!!</td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>

         </div>
    </div>
</div>