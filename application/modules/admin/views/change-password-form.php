<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle">
                <span class="lable-user-name">
                    Change Password
                </span>
                <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            </div>
            <form id="change-password-global-form" class="form-horizontal form-label-left" method="post" accept-charset="utf-8"><input type="hidden" name="compute" value="92bea8fcbc970abbf0f58e7a6725b42e">
                <input type="hidden" name="current_user_id" id="current_user_id" value="<?php echo get_user_id(); ?>">
                <div class="">
                    <div class="col-md-4 col-xs-12">
                        <label for="firstname">Old Password <span class="required">*</span>
                        </label>

                        <input type="password" name="old_password" value="" class="form-control col-md-7 col-xs-12" placeholder="Old Password" label="" required="required">

                    </div>

                    <div class="col-md-4 col-xs-12">
                        <label for="firstname">New Password <span class="required">*</span>
                        </label>
                        <input type="password" name="new_password" id="new_password" value="" class="form-control col-md-7 col-xs-12" placeholder="New Password" label="" required="required">
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <label for="firstname">Retype New Password <span class="required">*</span>
                        </label>
                        <input type="password" name="confirm_new_password" id="confirm_new_password" value="" class="form-control col-md-7 col-xs-12" placeholder="Retype Password" label="" required="required">
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin:5px 0px;">
                        <button type="reset" class="btn btn-primary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>


        </section>
    </div>
</div>