  <div class="main-content" role="main">
      <div class="main-inner">

          <section class="match-content">
              <div class="table_tittle">
                  <h4 style="display:inline-block;">Chips</h4>
                  <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
                      Add Chip
                  </button>
                  <button type="button" class="btn btn-primary pull-right" style="margin-right:10px;" onclick="updateChipsForAll()">
                      Update Chips For All
                  </button>
              </div>

              <table class="table table-bordered" id="example" style="width:100%;">
                  <thead>
                      <tr>
                          <th>S. No.</th>
                          <th>Chip Name</th>
                          <th>Value</th>
                          <th colspan="2" style="text-align:center;">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                        if (isset($chips) && !empty($chips)) {
                            $i = 1;
                            foreach ($chips as $chip) { ?>
                              <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td><?php echo $chip['chip_name']; ?></td>
                                  <td><?php echo $chip['chip_value']; ?></td>
                                  <td>
                                      <center>
                                          <button data-chip-name="<?php echo $chip['chip_name']; ?>" data-chip-value="<?php echo $chip['chip_value']; ?>" data-chip-id="<?php echo $chip['chip_id']; ?>" type="button" class="btn btn-warning btn-sm edit-chip"><i class="fa fa-pencil"></i></button>



                                          <button type="button" style="margin-left:10px;" class="btn btn-danger btn-sm" onclick="deleteChip(<?php echo $chip['chip_id']; ?>,'<?php echo $chip['chip_name']; ?>')"><i class="fa fa-trash"></i></button>
                                      </center>
                                  </td>

                              </tr>

                      <?php }
                        }
                        ?>
                  </tbody>
              </table>
          </section>
      </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="chip-form" name="chip-form">
          <div class="modal-dialog modal-dialog-centered" role="document">

              <div class="modal-content  ">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Chip</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Chip Name</label>
                                  <input type="hidden" name="chip_id" id="chip_id" class="form-control" />
                                  <input type="text" name="chip_name" id="chip_name" class="form-control" />

                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Chip Value</label>
                                  <input type="text" name="chip_value" class="form-control" id="chip_value" />

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
      function updateChipsForAll() {



          $.ajax({
              url: base_url + "admin/Chip/upadateChipsForAll",
              method: "POST",
              data: {},
              dataType: "json",
              success: function(response) {
                  // $.unblockUI;
                  if (response.success) {
                      new PNotify({
                          title: "Success",
                          text: "Success",
                          styling: "bootstrap3",
                          type: "success",
                          delay: 3000,
                      });

                      // setTimeout(function () {
                      //   window.location.reload(1);
                      // }, 2000);
                  } else {
                      new PNotify({
                          title: "Success",
                          text: data.message?data.message:"Something went wrong please try again later",
                          styling: "bootstrap3",
                          type: "error",
                          delay: 3000,
                      });

                      setTimeout(function() {
                          window.location.reload(1);
                      }, 2000);
                  }
              },
          });

      }
  </script>