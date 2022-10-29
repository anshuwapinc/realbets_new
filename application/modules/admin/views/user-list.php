<div class="main-content" role="main">
      <div class="main-inner">

          <section class="match-content">
              <div class="table_tittle">
                  <span class="lable-user-name">
                      <?php

                        if ($user_type == 'Super Admin') {
                            echo 'SBA';
                        } else if ($user_type == 'Admin') {
                            echo 'Super Admin';
                        } else if ($user_type == 'Hyper Super Master') {
                            echo 'Admin';
                        } else if ($user_type == 'Super Master') {
                            echo 'Super Master';
                        } else if ($user_type == 'Master') {
                            echo 'Master';
                        } else if ($user_type == 'User') {
                            echo 'User';
                        }

                        ?> Listing
                  </span>


                  <a href="javascript:void(0)" class="btn btn-xs btn-primary pull-right" onclick="setAction()" style="margin-left:5px;">
                      ACTION
                  </a>
                  <select class="user-mobile custom-user-select pull-right" id="useraction" style="color:black">
                      <option value="">Select Action</option>
                      <option value="lock_betting">Lock Betting</option>
                      <option value="open_betting">Open Betting</option>
                      <option value="lock_user">Lock User</option>
                      <option value="unlock_user">Unlock User</option>
                      <option value="close_user">Close User Account</option>
                  </select>
              </div>




              <div class="table_tittle lastdetail">
                  <!-- <span class="detailinfo"><b class="">S</b> Statement</span>
                  <span class="detailinfo"><b class="">PL</b> Profit Loss</span>
                  <span class="detailinfo"><b class="">P-R</b> : Partnerhsip</span>
                  <span class="detailinfo"><b class="">P</b> : Change Password</span>
                  <span class="detailinfo"><b class="">D-W</b> : Free Chip In Out</span>
                  <span class="detailinfo"><b class="">S-E</b> : Settlement</span> -->
                  <span class="detailinfo">&nbsp;</span>

                  <span class="detailinfo pull-right"><a class="btn btn-xs btn-primary pull-right" onclick="showAddUserModel(<?php echo $user_type == 'User' ? true : false; ?>)" href="javascript:void(0)"> Add New</a></span>

              </div>

              <div class="card-body" style="overflow-x: scroll;min-height:500px;">
                  <?php echo $table; ?>
              </div>
          </section>
      </div>
  </div>

  <?php

    ?>

  <!-- Modal -->
  <div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="add-user-form" name="add-user-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content  ">
                  <div class="table_tittle modal-header">
                      <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Add User &nbsp;<span id="upper-user"></span></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <?php
                            if (!empty($masters)) { ?>
                              <input type="hidden" name="master_id_tmp" id="master_id_tmp" value="<?php echo $master_id; ?>" class="form-control" />
                              <div class="col-md-12" id="uplinecontainer">
                                  <div class="form-group">
                                      <label>Select Upline</label>

                                      <div>
                                          <select class="form-control select2" onchange="setUserLimit(this.value)" id="master_id" name="master_id">
                                              <option value="">--Select Upline--</option>
                                              <?php
                                                if (!empty($masters)) {
                                                    foreach ($masters as $master) { ?>
                                                      <option value="<?php echo $master['user_id']; ?>"><?php echo $master['user_name']; ?></option>
                                              <?php }
                                                }
                                                ?>
                                          </select>
                                      </div>

                                  </div>
                              </div>
                          <?php } else {

                            ?>
                              <input type="hidden" name="master_id_tmp" id="master_id_tmp" value="<?php echo $master_id; ?>" class="form-control" />
                              <input type="hidden" name="master_id" id="master_id" value="<?php echo $master_id; ?>" class="form-control" />
                          <?php }
                            ?>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Name</label>
                                  <input type="hidden" name="user_id" id="user_id" class="form-control" />

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

                                  <div>
                                      <input type="text" name="user_name" id="user_name" class="form-control" style="width:55%;display:inline-block;" />
                                      <button type="button" class="btn btn-info btn-sm" onclick="newUserNameGenerate()" style="display:inline-block;margin-left:10px;">Generate New</button>
                                  </div>

                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Password</label>

                                  <input type="password" name="password" id="password" class="form-control" title="Min 4 character needed" required />

                              </div>
                          </div>
                      </div>
                      <div class="row">

                          <div class="col-md-6" style="display:none;">
                              <div class="form-group">
                                  <label>User Type</label>
                                  <input type="text" name="user_type" class="form-control" id="user_type" value="<?php echo $user_type; ?>" readonly />
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Match Commission</label>


                                  <input type="number" name="master_commision" id="master_commision" max="<?php
                                    if(get_user_type() == 'Admin')
                                    {
                                        echo "5";
                                    }
                                    else
                                    {
                                        echo $master_user_detail->master_commision;
                                    }
                                  ?>" min="<?php echo $master_user_detail->master_commision; ?>" class="form-control" />

                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Session Commission</label>

                                  <input type="number" name="session_commision" id="session_commision" max="<?php
                                    if(get_user_type() == 'Admin')
                                    {
                                        echo "5";
                                    }
                                    else
                                    {
                                        echo $master_user_detail->sessional_commision;
                                    }
                                  ?>" min="<?php echo $master_user_detail->sessional_commision; ?>" class="form-control" />

                              </div>
                          </div>
                      </div>

                      <div >
                          <div class="row">

                              <div class="col-md-6" id="partnership-content">
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
                                      <label>Opening Balance <span id="master-partnership"></label>

                                      <input type="number" name="deposite_bal" min="0" max="<?php echo !empty($master_user_detail->user_id)?count_total_balance($master_user_detail->user_id): count_total_balance($_SESSION['my_userdata']['user_id']); ?>" id="deposite_bal" class="form-control" />

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

  <!-- <div class="modal fade" id="edit" role="dialog" aria-labelledby="</div>
Label" aria-hidden="true">
      <form id="user-change-password-form" method="POST" name="user-change-password-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content ">
                  <div class="table_tittle modal-header">
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
                                  <input type="text" readonly name="edit_detail_user_name" id="edit_detail_user_name" class="form-control" />


                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" name="edit_password" id="edit_password" class="form-control" title="Min 4 character needed" required />

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
  </div> -->
  <!-----------Change Password Model---------------------------->


  <!-----------Change Deposit Model---------------------------->

  <div class="modal fade" id="changePasswordModel1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="chip-in-out-form" method="POST" name="chip-in-out-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content  ">
                  <div class="table_tittle table_tittle modal-header">
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

                          <div class="col-md-4 form-group">
                              <label> Free Chips : </label>
                              <input type="number" name="Chips" class="form-control" id="ChipsValue" required="" onkeyup="chip_calculate()">
                              <span id="ChipsN" class="errmsg"></span>
                          </div>
                          <div class="col-md-4 form-group">
                              <label> Remarks : </label>
                              <input type="text" name="remarks" class="form-control" id="remarks">
                              <span id="remarksN" class="errmsg"></span>
                          </div>
                          <div class="col-md-12">
                              <div class="tabel_content ">
                                  <table class="table table-bordered table-hover">
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

  <div class="modal fade" id="userChangePasswordModel" role="dialog" aria-labelledby="</div>
Label" aria-hidden="true">
      <form id="user-change-password-form" name="user-change-password-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content ">
                  <div class="table_tittle modal-header">
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
                                  <input type="password" name="edit_password" id="edit_password" class="form-control" title="Min 4 character needed" required />

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

  <!-----------Edit Details Model---------------------------->

  <div class="modal fade" id="editUserModel" role="dialog" aria-labelledby="</div>
Label" aria-hidden="true">
      <form id="update-user-form" name="update-user-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content ">
                  <div class="table_tittle modal-header">
                      <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;"><span id="ch-pw-user"></span> Edit Details</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>User ID</label>
                                  <input type="hidden" name="edit_detail_user_id" id="edit_detail_user_id" class="form-control" />
                                  <input type="text" readonly name="edit_detail_user_name" id="edit_detail_user_name" class="form-control" />


                              </div>
                          </div>
                          <div class="col-md-4 edit_partnership_div">
                              <div class="form-group">
                                  <label>Partership <?php
                                                    if ($master_user_detail->partnership) {
                                                    ?><span id="edit-master-partnership">
                                              (<?php echo $master_user_detail->partnership; ?>)</span> <?php } ?></label>



                                  <input type="number" min="0" max="<?php echo $master_user_detail->partnership; ?>" name="edit_partnership" id="edit_partnership" class="form-control" />

                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Match Commission <span id="edit-match-commission"></span></label>
                                  <input type="number" max="<?php
                                    if(get_user_type() == 'Admin')
                                    {
                                        echo "5";
                                    }
                                    else
                                    {
                                        echo $master_user_detail->master_commision;
                                    }
                                  ?>" min="<?php echo $master_user_detail->master_commision; ?>" name="edit_match_commission" id="edit_match_commission" class="form-control" required />

                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Session Commission <span id="edit-session-commission"></span></label>

                                  <input type="number" max="<?php
                                    if(get_user_type() == 'Admin')
                                    {
                                        echo "5";
                                    }
                                    else
                                    {
                                        echo $master_user_detail->sessional_commision;
                                    }
                                  ?>" min="<?php echo $master_user_detail->sessional_commision; ?>" name="edit_session_commission" id="edit_session_commission" class="form-control" />

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
  <!-----------Edit Details Model---------------------------->




  <!-----------Change Password Model---------------------------->

  <div class="modal fade" id="masterPasswordModal" role="dialog" aria-labelledby="</div>
Label" aria-hidden="true">
      <form id="master-password-form" name="master-password-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content ">
                  <div class="table_tittle modal-header">
                      <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;"><span id="ch-pw-user"></span> Change Master Password</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>User ID</label>
                                  <input type="hidden" name="master_user_id_1" id="master_user_id_1" class="form-control" />
                                  <input type="text" readonly name="master_user_name" id="master_user_name" class="form-control" />


                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" name="master_password" id="master_password" class="form-control" title="Min 4 character needed" required />

                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Confirm Password</label>

                                  <input type="password" name="master_confirm_password" id="master_confirm_password" class="form-control" />

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



  <script>
      function free_chips_in_outs(user_id, master_id, user_name, type) {
        document.getElementById("chip-in-out-form").reset();
        //   $('#chip-in-out-form').trigger('reset');
          $("#chip_master_id").val(master_id);
          $.ajax({
              url: "<?php echo base_url(); ?>admin/User/free_chip_in_out",
              method: "POST",
              data: {
                  user_id: user_id,
                  type: type,
                  master_id: master_id
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
          var ChipsValue = $('#ChipsValue').val();
          var type = $('#type').val();
          var user_id_chip = $('#user_id_chip').val();

          if (ChipsValue == "") {
              alert("Please enter valid Chip Value");
              return false;
          } else {
              $.ajax({
                  url: "<?php echo base_url(); ?>admin/User/chip_update",
                  method: "POST",
                  data: {
                      user_id: user_id_chip,
                      type: type,
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
          $('#uplinecontainer').show();
          $('#master_id_tmp').val('');
          $('#master_id').val(<?php echo $master_id; ?>);

          $('#add-user-form').trigger('reset');
          $('#upper-user').text('');
          if (is_user) {
              $('#partnership-content').hide();
          } else {
              $('#partnership-content').show();

          }
          $('#userModel').modal('show');

          newUserNameGenerate();

      }

      function addInnerUser(master_id, upperuser, is_user) {

          $('#master_id_tmp').val('');
          $('#master_id').val('');


          $('#add-user-form').trigger('reset');
          //   $('#master_id').val(master_id);
          $('#master_id_tmp').val(master_id);


          $('#uplinecontainer').hide();

          if (is_user) {
              $('#partnership-content').hide();
          }


          var partnership = $('#partnership_' + master_id).val();
          var teenpati_partnership = $('#teenpati_partnership_' + master_id).val();
          var casino_partnership = $('#casino_partnership_' + master_id).val();
          var master_commision = $('#master_commision_' + master_id).val();
          var sessional_commision = $('#sessional_commision_' + master_id).val();


          $('#master-partnership').text('(' + partnership + ')');
          $('#master-teenpati_partnership').text('(' + teenpati_partnership + ')');
          $('#master-casino_partnership').text('(' + casino_partnership + ')');

          $('#partnership').attr('max', partnership);
          $('#casino_partnership').attr('max', casino_partnership);
          $('#teenpati_partnership').attr('max', teenpati_partnership);
          $('#master_commision').attr('min', master_commision);
          $('#session_commision').attr('min', sessional_commision);



          $('#upper-user').text('/ ' + upperuser);
          $('#user_type').val('<?php echo $next_user; ?>');
          $('#userModel').modal('show');

          newUserNameGenerate();

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

                      //   alert("User action applied successfully");
                      //   window.location.reload();
                  }
              }

          })
      }

      function editUser(user_id) {

          if ($("#user_type").val() == "User") {
              $(".edit_partnership_div").hide();
          }

          $.ajax({
              url: "<?php echo base_url(); ?>admin/User/get_user",
              method: "POST",
              dataType: "json",
              data: {
                  user_id: user_id,
              },
              success: function(data) {


                  console.log('userDetail', data.partnership);

                  $('#edit_partnership').val(data.partnership);
                  $('#edit_match_commission').val(data.master_commision);
                  $('#edit_session_commission').val(data.sessional_commision);
                  $('#edit_detail_user_name').val(data.user_name);
                  $('#edit_detail_user_id').val(data.user_id);


                  $('#editUserModel').modal('show');


              }

          })

      }

      function newUserNameGenerate() {
          let user_name = '';

          var rString = randomString(4, '0123456789');

          var user_type = $('#user_type').val();
          var user_prefix = '';
          if (user_type == 'Hyper Super Master') {
              user_prefix = 'MA';
          } else if (user_type == 'Super Master') {
              user_prefix = 'SA';
          } else if (user_type == 'Master') {
              user_prefix = 'A';
          } else if (user_type == 'User') {
              user_prefix = 'C';
          } else if (user_type == 'Admin') {
              user_prefix = 'SBA';
          } else if (user_type == 'Super Admin') {
              user_prefix = 'ADMIN';
          }

          user_name = user_prefix + '' + rString;
          $('#user_name').val(user_name);
      }


      function randomString(length, chars) {
          var result = '';

          for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
          return result;
      }

      function setUserLimit(user_id)
      {
          console.log(user_id);

          $.ajax({
         url: "<?php echo base_url('getUserBalance'); ?>",
         type: "post",
         data:{
             user_id : user_id,
         },
         success: function(response) {
            console.log(response);
            $("#deposite_bal").attr('max',response);
         }
      });
      }
  </script>