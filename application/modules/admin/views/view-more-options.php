<span class="dropdown">
    <a href="#" style="color: #fff;
    background-color: #D3E89C;
    border-color: #D3E89C;" class="dropdown-toggle btn btn-xs btn-success" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View More <span class="caret"></span></a>
    <ul class="dropdown-menu">

        <li>
            <a class="" href="javascript:;" title="Free Chip In Out" onclick="free_chips_in_outs(<?php echo $user['user_id']; ?>,<?php echo $user['master_id']; ?>,'<?php echo $user['name']; ?>','W');"><span>Free Chip Withdrawal</span></a>
        </li>

        <li> <a class="" href="javascript:;" title="Free Chip In Out" onclick="free_chips_in_outs(<?php echo $user['user_id']; ?>,<?php echo $user['master_id']; ?>,'<?php echo $user['name']; ?>','D');"><span>Free Chip Deposit</span></a></li>

        <li> <a class="" href="javascript:;" title="Change Password" onclick="changePasswordModel(<?php echo $user['user_id']; ?>,'<?php echo $user['user_name']; ?>' );"><span>Change Password</span></a></li>


        <li>
            <a class="" href="javascript:;" title="Update Master Password" onclick="changeMasterPassword(<?php echo $user['user_id']; ?>,'<?php echo $user['user_name']; ?>');"><span>Change M. Password</span></a>
        </li>


        <?php
        if (get_user_type() == 'Admin' || get_user_type() == 'Super Admin') { ?>
            <li>

                <a class="" href="<?php echo base_url(); ?>admin/viewinfo/<?php echo $user['user_id']; ?>" title="View Account Info" onclick="view_account('47978');"><span>View Info</span></a>

            </li>
        <?php }
        ?>


        <li><a class="" target="_blank" href="<?php echo base_url(); ?>admin/profitloss/5/<?php echo $user['user_id']; ?>">
                <span>Profit Loss</span> </a></li>

        <li> <a class="" target="_blank" href="<?php echo base_url(); ?>admin/acStatement/0/<?php echo $user['user_id']; ?>">

                <span>Statement</span> </a></li>

        <li>
            <a class="" href="javascript:;" title="Update Detail" onclick="editUser(<?php echo $user['user_id']; ?>);"><span>Edit Details</span></a>
        </li>



        <?php
        if ($user_type != 'User') {  ?>
            <li> <a href="javascript:void(0);" onclick="addInnerUser(
                                           
                                           <?php echo $user['user_id']; ?>,'<?php echo $user['user_name'] . '(' . $user['name'] . ')'; ?>',<?php echo $user_type == 'Master' ? true : false; ?>)">

                    <span>Add User</span> </a></li>
        <?php } ?>

        <?php
        if ($user_type == 'User') {
        ?>
            <li> <a class="" target="_blank" href="<?php echo base_url(); ?>user-detail/<?php echo $user['user_id']; ?>"> <span>User Detail</span> </a></li>
        <?php
        }  ?>
    </ul>
</span>