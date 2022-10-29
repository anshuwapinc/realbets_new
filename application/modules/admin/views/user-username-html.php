<?php
                                  if ($user_type == 'User') { ?>
                                    <?php echo isset($user['user_name']) ? $user['user_name'] : ""; ?>
                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>admin/downline/<?php echo $user['user_id']; ?>/<?php check_user_type($user['user_type']); ?>"><?php echo isset($user['user_name']) ? $user['user_name'] : ""; ?></a>
                                <?php }
                                  ?>

                                <?php
                                  if ($user['is_betting_open'] == 'No') { ?>
                                    <i class="fa fa-lock" style="color:red"></i>
                                <?php } ?>

                                <?php
                                  if ($user['is_locked'] == 'Yes') { ?>
                                    <i class="fa fa-user" style="color:red"></i>
                                <?php } ?>