<div class="right_col" role="main">


    <div class="card" style="background:#fff;">
        <div class="card-header row" style="border-bottom:1px solid #efefef; padding:10px;">
            <div class="col-md-6">
                <h4 style="display:inline-block;">Closed <?php echo $user_type != 'Admin' ? $user_type : 'Users'; ?></h4>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary pull-right  btn-xs " onclick="showAddUserModel(<?php echo $user_type == 'User' ? true : false; ?>)" style="padding:4px 5px;">
                    Add User
                </button>
                <button class="btn btn-warning btn-xs pull-right" onclick="setAction()" style="padding:4px 5px; margin-right:5px;">
                    ACTION
                </button>
                <select class="user-mobile custom-user-select pull-right" id="useraction" style="color:black">
                    <option value="">Select Action</option>
                    <option value="open_user">Open User Account</option>
                    <option value="delete_user">Delete User Account</option>

                </select>
            </div>

        </div>
        <div class="card-body" style="overflow-x: scroll;min-height:500px;">
            <table class="table table-bordered" id="example" style="width:100%;">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="user_select_all" id="user_select_all" /></th>
                        <th>S. No.</th>
                        <th>User ID</th>
                        <?php
                        if ($user_type == 'Admin') { ?>
                            <th>User Type</th>
                        <?php } ?>

                        <!-- <th>Winings</th>
                        <th>Credit Limits</th> -->
                        <th>Exposure</th>
                        <th>Balance</th>

                        <?php
                        if ($user_type != 'User') { ?>
                            <th>Partnership</th>
                            <th>Partnership Cacino</th>
                            <th>Partnership Teenpati</th>
                        <?php } ?>

                        <th>M. Comm.</th>
                        <th>S. Comm.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($users) && !empty($users)) {
                        $i = 1;
                        foreach ($users as $user) {
                            $total_exposure = count_total_exposure($user['user_id']);
                            $total_balance = count_total_balance($user['user_id']);

                    ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="user_ids" name="user_id[]" value="<?php echo $user['user_id']; ?>" />
                                </td>
                                <td><?php echo $i++; ?>

                                    <input type="hidden" name="partnership_<?php echo $user['user_id']; ?>" id="partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['partnership']; ?>" />
                                    <input type="hidden" name="teenpati_partnership_<?php echo $user['user_id']; ?>" id="teenpati_partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['teenpati_partnership']; ?>" />
                                    <input type="hidden" name="casino_partnership_<?php echo $user['user_id']; ?>" id="casino_partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['casino_partnership']; ?>" />
                                </td>
                                <td>
                                    <?php
                                    //   if ($user_type == 'User') { 
                                    ?>
                                    <?php echo isset($user['user_name']) ? $user['user_name'] : ""; ?>(<?php echo isset($user['name']) ? $user['name'] : ""; ?>)

                                    <?php
                                    if ($user['is_betting_open'] == 'No') { ?>
                                        <i class="fa fa-lock" style="color:red"></i>
                                    <?php } ?>

                                    <?php
                                    if ($user['is_locked'] == 'Yes') { ?>
                                        <i class="fa fa-user" style="color:red"></i>
                                    <?php } ?>
                                </td>

                                <?php
                                if ($user_type == 'Admin') { ?>
                                    <td><?php echo isset($user['user_type']) ? $user['user_type'] : null; ?></td>

                                <?php } ?>

                                <!-- <td><?php echo isset($user['winings']) ? $user['winings'] : number_format(0.00, 2); ?></td>
                                <td><?php echo isset($user['credit_limit']) ? $user['credit_limit'] : number_format(0.00, 2); ?></td> -->
                                <td><?php echo isset($total_exposure) ? $total_exposure : number_format(0.00, 2); ?></td>
                                <td><?php echo isset($total_balance) ? $total_balance : number_format(0.00, 2); ?></td>

                                <?php
                                if ($user_type != 'User') { ?>
                                    <td><?php echo isset($user['partnership']) ? $user['partnership'] : 0; ?>%</td>
                                    <td><?php echo isset($user['casino_partnership']) ? $user['casino_partnership'] : 0; ?>%</td>
                                    <td><?php echo isset($user['teenpati_partnership']) ? $user['teenpati_partnership'] : 0; ?>%</td>
                                <?php }
                                ?>


                                <td><?php echo isset($user['master_commision']) ? $user['master_commision'] : number_format(0.00, 2); ?></td>
                                <td><?php echo isset($user['sessional_cmmision']) ? $user['sessional_cmmision'] : number_format(0.00, 2); ?></td>



                                <!-- <td class="last">
                                <span class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-xs btn-success" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View More <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        if ($user_type != 'User') {  ?>
                                            <li> <a href="javascript:void(0);" onclick="addInnerUser(
                                           
                                           <?php echo $user['user_id']; ?>,'<?php echo $user['user_name'] . '(' . $user['name'] . ')'; ?>',<?php echo $user_type == 'Master' ? true : false; ?>)">

                                                    <span>Add User</span> </a></li>
                                        <?php } ?>

                                        <li> <a class="" target="_blank" href="<?php echo base_url(); ?>admin/acStatement/<?php echo $user['user_id']; ?>">

                                                <span>Statement</span> </a></li>
                                        <li><a class="" target="_blank" href="<?php echo base_url(); ?>admin/profitloss/<?php echo $user['user_id']; ?>">
                                                <span>Profit Loss</span> </a></li>
                                        <li>

                                            <a class="" href="<?php echo base_url(); ?>admin/viewinfo/<?php echo $user['user_id']; ?>" title="View Account Info" onclick="view_account('47978');"><span>View Info</span></a>

                                        </li>
                                        <li> <a class="" href="javascript:;" title="Change Password" onclick="changePasswordModel(<?php echo $user['user_id']; ?>,'<?php echo $user['user_name']; ?>' );"><span>Change Password</span></a></li>
                                        <li> <a class="" href="javascript:;" title="Free Chip In Out" onclick="free_chips_in_outs(<?php echo $user['user_id']; ?>,'<?php echo $user['name']; ?>','D');"><span>Free Chip Deposit</span></a></li>
                                        <li>
                                            <a class="" href="javascript:;" title="Free Chip In Out" onclick="free_chips_in_outs(<?php echo $user['user_id']; ?>,'<?php echo $user['name']; ?>','W');"><span>Free Chip Withdrawal</span></a>
                                        </li>
                                    </ul>
                                </span>
                            </td> -->


                            </tr>

                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="add-user-form" name="add-user-form">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content  ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Add User &nbsp;<span id="upper-user"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="user_id" id="user_id" class="form-control" />
                                <input type="hidden" name="master_id" id="master_id" value="<?php echo $master_id; ?>" class="form-control" />
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Registration Date</label>

                                <input type="text" name="registration_date" id="registration_date" class="form-control" readonly value="<?php echo date('d-M-Y'); ?>" />

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User ID</label>

                                <input type="text" name="user_name" id="user_name" class="form-control" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>

                                <input type="password" name="password" id="password" class="form-control"  title="Min 4 character needed" required />

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Type</label>
                                <input type="text" name="user_type" class="form-control" id="user_type" value="<?php echo $user_type; ?>" readonly />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Commision</label>

                                <input type="number" name="master_commision" id="master_commision" class="form-control" />

                            </div>
                        </div>
                    </div>
                    <div id="partnership-content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Partership <span id="master-partnership"><?php
                                                                                    if ($master_user_detail->partnership) {
                                                                                    ?>
                                                (<?php echo $master_user_detail->partnership; ?>)</label>
                                <?php
                                                                                    }
                                ?></span></label>

                                <input type="number" name="partnership" min="0" max="<?php echo $master_user_detail->partnership; ?>" id="partnership" class="form-control" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teenpati Partnership<span id="master-teenpati_partnership"> <?php
                                                                                                        if ($master_user_detail->teenpati_partnership) {
                                                                                                        ?>
                                                (<?php echo $master_user_detail->teenpati_partnership; ?>)</span></label>
                                <?php
                                                                                                        }
                                ?></label>

                                <input type="number" name="teenpati_partnership" id="teenpati_partnership" max="<?php echo $master_user_detail->teenpati_partnership; ?>" class="form-control" />

                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Casino Partnership<span id="master-casino_partnership">
                                            <?php
                                            if ($master_user_detail->casino_partnership) {
                                            ?>
                                                (<?php echo $master_user_detail->casino_partnership; ?>)
                                            <?php
                                            }
                                            ?></span>
                                    </label>


                                    <input type="number" name="casino_partnership" id="casino_partnership" max="<?php echo $master_user_detail->casino_partnership; ?>" class="form-control" />

                                </div>
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





<!-----------Change Password Model---------------------------->

<div class="modal fade" id="userChangePasswordModel" role="dialog" aria-labelledby="</div>
Label" aria-hidden="true">
    <form id="user-change-password-form" name="user-change-password-form">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;"><span id="ch-pw-user"></span> Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="hidden" name="edit_user_id" id="edit_user_id" class="form-control" />
                                <input type="text" readonly name="edit_user_name" id="edit_user_name" class="form-control" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="edit_password" id="edit_password" class="form-control"   title="Min 4 character needed" required />

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Confirm Password</label>

                                <input type="password" name="edit_confirm_password" id="edit_confirm_password" class="form-control" />

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-----------Change Password Model---------------------------->


<!-----------Change Deposit Model---------------------------->

<div class="modal fade" id="changePasswordModel1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="chip-in-out-form" name="chip-in-out-form">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content  ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Chip In/Out <span id="chip_in_out_user"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="UpdateChipsMsg"></div>
                        <span id="msg_error"></span><span id="errmsg"></span>
                        <!-- <input type="hidden" name="UserID" id="UserID" value="47978"> -->
                        <!-- <input type="hidden" name="userType" id="userType" value="4">
                    <input type="hidden" value="500.00" id="ParentUserbal">
                    <input type="hidden" value="310.00" id="UserCurrentbal"> -->
                        <input type="hidden" value="<?php echo $master_id; ?>" id="chip_master_id">

                        <div class="col-md-6">
                            <label> Free Chips : </label>
                            <input type="number" name="Chips" class="form-control" id="ChipsValue" required="" onkeyup="chip_calculate()">
                            <span id="ChipsN" class="errmsg"></span>
                        </div>
                        <div class="col-md-6">
                            <label> Password : </label>
                            <input type="password" name="passwordChips" class="form-control" id="passwordChips" required="">
                            <span id="ChipsN" class="errmsg"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="tabel_content ">
                                <table class="table-bordered" id="example">
                                    <tbody>
                                        <tr>
                                            <td>Parant Free Chips</td>
                                            <td class="font-bold">
                                                <span id="admin_chip">00.00</span>
                                                <input type="hidden" name="admin_chip_val" id="admin_chip_val" />
                                            </td>
                                        </tr>
                                        <!--tr>
                              <td>User Free Chips </td>
                              <td class="font-bold">  500.00 </td>
                              </tr-->
                                        <tr>
                                            <td>User Balance </td>
                                            <td class="font-bold">
                                                <span id="user_chip">00.00</span>
                                                <input type="hidden" name="user_chip_val" id="user_chip_val" />
                                                <input type="hidden" name="type" id="type" />
                                                <input type="hidden" name="user_id_chip" id="user_id_chip" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Parant New Free Chips</td>
                                            <td><span id="ParantNewFreeChips"></span> </td>
                                        </tr>
                                        <tr>
                                            <td><span id="chip_up_user_name"></span> New Free Chips</td>
                                            <td><span id="myNewFreeChips"></span> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 modal-footer">
                            <input type="hidden" class="form-control" id="action" value="D">
                            <input type="hidden" class="form-control" id="FreeChip" value="310.00">
                            <button type="submit" class="btn btn-success pull-right " id="deposit_button">
                                <!-- onclick="save_admin();" -->Deposit
                            </button>

                            <button type="submit" class="btn btn-danger pull-right " id="withdrawl_button">
                                <!-- onclick="save_admin();" -->Withdrawl
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="handeChangePasswordSubmit()">Save</button>
          </div> -->
            </div>
        </div>
    </form>
</div>



<!-----------Chip Deposit Model---------------------------->
<script>
    $(document).ready(function() {


        $('#example').DataTable({
            "searching": false,
            "paging": true,
            'columnDefs': [{

                'targets': [0],
                /* column index */

                'orderable': false,
                /* true or false */

            }],
        });


        $('#user_select_all').on('click', function() {
            var numberOfChecked = 0;
            
            if (this.checked) {
                $('.user_ids').each(function() {
                    this.checked = true;
                });
                numberOfChecked = $('input[name="user_id[]"]:checkbox:checked').length;

            } else {
                $('.user_ids').each(function() {
                    this.checked = false;
                });
                numberOfChecked = $('input[name="user_id[]"]:checkbox:checked').length;


            }


        });
    });

    function free_chips_in_outs(user_id, user_name, type) {
        $('#chip-in-out-form').trigger('reset');

        $.ajax({
            url: "<?php echo base_url(); ?>admin/User/free_chip_in_out",
            method: "POST",
            data: {
                user_id: user_id,
                type: type,
                master_id: "<?php echo $master_id; ?>"
            },
            dataType: "json",
            success: function(response) {
                $('#chip_in_out_user').text(user_name);
                $('#chip_in_out_user').text(user_name);
                $('#chip_up_user_name').text(user_name);
                $('#admin_chip').text(response.admin_chip);
                $('#user_chip').text(response.user_chip);
                $('#admin_chip_val').val(response.admin_chip);
                $('#user_chip_val').val(response.user_chip);
                $('#user_id_chip').val(user_id);
                $('#type').val(type);

                if (type == 'D') {
                    $('#withdrawl_button').hide();
                    $('#deposit_button').show();
                    $('#ChipsValue').attr('max', response.admin_chip);

                } else {
                    $('#withdrawl_button').show();
                    $('#deposit_button').hide();
                    $('#ChipsValue').attr('max', response.user_chip);

                }

                $('#changePasswordModel1').modal('show');

            }
        })

    }

    function chip_calculate() {
        var admin_chip = $('#admin_chip_val').val();
        var user_chip = $('#user_chip_val').val();
        var type = $('#type').val();

        var ChipsValue = $('#ChipsValue').val();

        if (type == 'D') {
            $('#ParantNewFreeChips').text(parseFloat(admin_chip) - parseFloat(ChipsValue));
            $('#myNewFreeChips').text(parseFloat(user_chip) + parseFloat(ChipsValue));
        } else {
            $('#ParantNewFreeChips').text(parseFloat(admin_chip) + parseFloat(ChipsValue));
            $('#myNewFreeChips').text(parseFloat(user_chip) - parseFloat(ChipsValue));
        }
    }

    function update_free_chip() {
        var passwordChips = $('#passwordChips').val();
        var ChipsValue = $('#ChipsValue').val();
        var type = $('#type').val();
        var user_id_chip = $('#user_id_chip').val();

        if (ChipsValue == "") {
            alert("Please enter valid Chip Value");
            return false;
        } else if (passwordChips == "") {
            alert("Please enter valid password");
            return false;
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>admin/User/chip_update",
                method: "POST",
                data: {
                    user_id: user_id_chip,
                    type: type,
                    passwordChips: passwordChips,
                    ChipsValue: ChipsValue
                },
                dataType: "json",
                success: function(response) {

                    if (response.success) {
                        window.location.reload();
                    } else {
                        alert(response.error);
                    }
                }
            })
        }

    }

    function showAddUserModel(is_user) {
        $('#add-user-form').trigger('reset');
        $('#upper-user').text('');
        if (is_user) {
            $('#partnership-content').hide();
        } else {
            $('#partnership-content').show();

        }
        $('#userModel').modal('show');

    }

    function addInnerUser(master_id, upperuser, is_user) {

        $('#add-user-form').trigger('reset');
        $('#master_id').val(master_id);

        if (is_user) {
            $('#partnership-content').hide();
        }


        var partnership = $('#partnership_' + master_id).val();
        var teenpati_partnership = $('#teenpati_partnership_' + master_id).val();
        var casino_partnership = $('#casino_partnership_' + master_id).val();

        $('#master-partnership').text('(' + partnership + ')');
        $('#master-teenpati_partnership').text('(' + teenpati_partnership + ')');
        $('#master-casino_partnership').text('(' + casino_partnership + ')');

        $('#partnership').attr('max', partnership);
        $('#casino_partnership').attr('max', casino_partnership);
        $('#teenpati_partnership').attr('max', teenpati_partnership);


        $('#upper-user').text('/ ' + upperuser);
        $('#user_type').val('<?php echo $next_user; ?>');
        $('#userModel').modal('show');

    }

    function setAction() {
        var useraction = $('#useraction').val();
        var users = new Array();

        $("input[name='user_id[]").each(function(index, obj) {
            // loop all checked items
            if (this.checked) {
                users.push(obj.value);
            }
        });

        if (users.length <= 0) {
            bootbox.alert("Please select atleast one user");
            return false;
        }
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);


        $.ajax({
            url: "<?php echo base_url(); ?>admin/User/set_action",
            method: "POST",
            dataType: "json",
            data: {
                useraction: useraction,
                users: users
            },
            success: function(data) {
                $.unblockUI
                if (data.success) {

                    alert("User action applied successfully");
                    window.location.reload();
                }
            }

        })
    }
</script>