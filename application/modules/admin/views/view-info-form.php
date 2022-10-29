<style>
    label {
        color: #777777;
    }

    .tital_change{
        font-size: 15px;
        font-weight: bold;
        margin-left: 5px;
        color: #777777;

    }
</style>
<div class="right_col" role="main">

    <div class="main-content" role="main">
        <div class="main-inner">

            <section class="match-content">
                <div class="table_tittle">
                    <span class="lable-user-name">
                        User General Setting
                    </span>
                    <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
                </div>
               
                    <div class="sub_heading"><span id="tital_change" class="tital_change">User </span> </div>
                    <div class="row">
                        <form id="update_user" name="update_user">

                            <div class="col-md-4 col-xs-6">
                                <label>User ID</label>
                                <input type="text" name="userId" class="form-control" id="master_name" readonly="" value="<?php echo $viewUserRecords->user_name; ?>">
                                <span id="master_nameN" class="errmsg"></span>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <label> User Name </label>
                                <input type="text" name="Name" class="form-control" id="FromDate" value="<?php echo $viewUserRecords->name; ?>" readonly="">
                                <span id="FromDateN" class="errmsg"></span>
                            </div>
                            <input type="hidden" name="uid" value="50508">
                            <div class="col-md-4 col-xs-12">
                                <label>Update From General Setting</label>
                                <input type="checkbox" name="user[is_update_from_gen]" value="1" checked=""> <br>
                                <span id="is_update_from_genN" class="errmsg"></span>
                            </div>
                            <div class="col-md-12 col-xs-12 modal-footer">
                                <button type="button" class="blue_button submit_user_setting" onclick="update_gen_setting();">Update</button>
                            </div>
                        </form>
                    </div>

                    <?php

                    if (isset($viewInfoRecords) && !empty($viewInfoRecords)) {

                        foreach ($viewInfoRecords as $info) {
                            $sport_id = $info['sport_id'];

                            $findMasterSetting = array();

                            foreach ($viewInfoMasterRecords as $viewInfoMasterRecord) {
                                if ($viewInfoMasterRecord['sport_id'] == $sport_id) {
                                    $findMasterSetting = $viewInfoMasterRecord;
                                }
                            }

                             if (get_user_type() == 'Super Admin' || get_user_type($user_id) == 'Admin') {
                                
                                if ($info['sport_id'] == 999) { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                                            <div class="col-md-4 col-xs-4">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <label> Max STAKE </label>
                                                <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                            </div>

                                            <div class="col-md-4 col-xs-4">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>

                                            <div class="col-md-4 col-xs-6">
                                                <label> Fancy</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="is_fancy_active" value="Yes" <?php if ($info['is_fancy_active'] == 'Yes') {
                                                                                                                echo "checked";
                                                                                                            } ?>> <br>
                                            </div>

                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else if ($info['sport_id'] == 2000) { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <div class="col-md-4 col-xs-6">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max STAKE</label>
                                                <input type="text" name="pre_inplay_stake" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_stake" value="<?php echo $info['pre_inplay_stake']; ?>">

                                            </div>
                                            <!-- <div class="col-md-4 col-xs-6">
                                            <label> Max STAKE </label>
                                            <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>">
                                            <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <label> MAX PROFIT </label>
                                            <input type="text" name="max_profit" class="form-control" id="<?php echo $sport_id; ?>_max_profit" value="<?php echo $info['max_profit']; ?>">
                                            <span id="<?php echo $sport_id; ?>_max_profitN" class="errmsg"></span>
                                        </div> -->
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max Loss </label>
                                                <input type="text" name="max_loss" class="form-control" id="<?php echo $sport_id; ?>_max_loss" value="<?php echo $info['max_loss']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_lossN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max PROFIT</label>
                                                <input type="text" name="pre_inplay_profit" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_profit" value="<?php echo $info['pre_inplay_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_pre_innplay_profitN" class="errmsg"></span>
                                            </div>


                                            <div class="col-md-4 col-xs-6">
                                                <label> MIN ODDS</label>
                                                <input type="text" name="min_odds" class="form-control" id="<?php echo $sport_id; ?>_min_odds" min="<?php echo $findMasterSetting['min_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX ODDS</label>
                                                <input type="text" name="max_odds" class="form-control" id="<?php echo $sport_id; ?>_max_odds" value="<?php echo $info['max_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label>UNMATCH BET</label>
                                                <input type="checkbox" name="unmatch_bet" value="Yes" <?php if ($info['unmatch_bet'] == 'Yes') {
                                                                                                            echo "checked";
                                                                                                        } ?>> <br>

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> LOCK BET</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="lock_bet" value="Yes" <?php if ($info['lock_bet'] == 'Yes') {
                                                                                                        echo "checked";
                                                                                                    } ?>> <br>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Bookmaker Odds</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="is_bookmaker_active" value="Yes" <?php if ($info['is_bookmaker_active'] == 'Yes') {
                                                                                                                    echo "checked";
                                                                                                                } ?>> <br>
                                            </div>
                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button  blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <div class="col-md-4 col-xs-6">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max STAKE </label>
                                                <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX PROFIT </label>
                                                <input type="text" name="max_profit" class="form-control" id="<?php echo $sport_id; ?>_max_profit" value="<?php echo $info['max_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_profitN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max Loss </label>
                                                <input type="text" name="max_loss" class="form-control" id="<?php echo $sport_id; ?>_max_loss" value="<?php echo $info['max_loss']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_lossN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> PRE INPLAY PROFIT</label>
                                                <input type="text" name="pre_inplay_profit" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_profit" value="<?php echo $info['pre_inplay_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_pre_innplay_profitN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> PRE INPLAY STAKE</label>
                                                <input type="text" name="pre_inplay_stake" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_stake" value="<?php echo $info['pre_inplay_stake']; ?>">

                                            </div>

                                            <div class="col-md-4 col-xs-6">
                                                <label> MIN ODDS</label>
                                                <input type="text" name="min_odds" class="form-control" id="<?php echo $sport_id; ?>_min_odds" value="<?php echo $info['min_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX ODDS</label>
                                                <input type="text" name="max_odds" class="form-control" id="<?php echo $sport_id; ?>_max_odds" value="<?php echo $info['max_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label>UNMATCH BET</label>
                                                <input type="checkbox" name="unmatch_bet" value="Yes" <?php if ($info['unmatch_bet'] == 'Yes') {
                                                                                                            echo "checked";
                                                                                                        } ?>> <br>

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> LOCK BET</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="lock_bet" value="Yes" <?php if ($info['lock_bet'] == 'Yes') {
                                                                                                        echo "checked";
                                                                                                    } ?>> <br>
                                            </div>

                                            <div class="col-md-4 col-xs-6">
                                                <label>Match Odds</label>
                                                <input type="checkbox" name="is_odds_active" value="Yes" <?php if ($info['is_odds_active'] == 'Yes') {
                                                                                                                echo "checked";
                                                                                                            } ?>> <br>

                                            </div>
                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button  blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php }
                            } else {

                                if ($info['sport_id'] == 999) { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                                            <div class="col-md-4 col-xs-4">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>" min="<?php echo $findMasterSetting['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <label> Max STAKE </label>
                                                <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>" max="<?php echo $findMasterSetting['max_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                            </div>

                                            <div class="col-md-4 col-xs-4">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>" min="<?php echo $findMasterSetting['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>


                                            <div class="col-md-4 col-xs-6">
                                                <label> Fancy</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="is_fancy_active" value="Yes" <?php if ($info['is_fancy_active'] == 'Yes') {
                                                                                                                echo "checked";
                                                                                                            } ?>> <br>
                                            </div>

                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else if ($info['sport_id'] == 2000) { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <div class="col-md-4 col-xs-6">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>" min="<?php echo $findMasterSetting['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max STAKE</label>
                                                <input type="text" name="pre_inplay_stake" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_stake" value="<?php echo $info['pre_inplay_stake']; ?>" max="<?php echo $findMasterSetting['pre_inplay_stake']; ?>">

                                            </div>
                                            <!-- <div class="col-md-4 col-xs-6">
                                            <label> Max STAKE </label>
                                            <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>">
                                            <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <label> MAX PROFIT </label>
                                            <input type="text" name="max_profit" class="form-control" id="<?php echo $sport_id; ?>_max_profit" value="<?php echo $info['max_profit']; ?>">
                                            <span id="<?php echo $sport_id; ?>_max_profitN" class="errmsg"></span>
                                        </div> -->
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max Loss </label>
                                                <input type="text" name="max_loss" class="form-control" id="<?php echo $sport_id; ?>_max_loss" value="<?php echo $info['max_loss']; ?>" max="<?php echo $findMasterSetting['max_loss']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_lossN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>" min="<?php echo $findMasterSetting['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max PROFIT</label>
                                                <input type="text" name="pre_inplay_profit" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_profit" value="<?php echo $info['pre_inplay_profit']; ?>" max="<?php echo $findMasterSetting['pre_inplay_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_pre_innplay_profitN" class="errmsg"></span>
                                            </div>

                                            <div class="col-md-4 col-xs-6">
                                                <label> MIN ODDS</label>
                                                <input type="text" name="min_odds" class="form-control" id="<?php echo $sport_id; ?>_min_odds" value="<?php echo $info['min_odds']; ?>" min="<?php echo $findMasterSetting['min_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX ODDS</label>
                                                <input type="text" name="max_odds" class="form-control" id="<?php echo $sport_id; ?>_max_odds" value="<?php echo $info['max_odds']; ?>" max="<?php echo $findMasterSetting['max_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label>UNMATCH BET</label>
                                                <input type="checkbox" name="unmatch_bet" value="Yes" <?php if ($info['unmatch_bet'] == 'Yes') {
                                                                                                            echo "checked";
                                                                                                        } ?>> <br>

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> LOCK BET</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="lock_bet" value="Yes" <?php if ($info['lock_bet'] == 'Yes') {
                                                                                                        echo "checked";
                                                                                                    } ?>> <br>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Bookmaker Odds</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="is_bookmaker_active" value="Yes" <?php if ($info['is_bookmaker_active'] == 'Yes') {
                                                                                                                    echo "checked";
                                                                                                                } ?>> <br>
                                            </div>
                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button  blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="sub_heading"><span id="tital_change" class="tital_change"><?php echo $info['sport_name']; ?> </span> </div>
                                    <div class="row">
                                        <form id="<?php echo $sport_id; ?>_setting" name="<?php echo $sport_id; ?>_setting">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="setting_id" value="<?php echo $info['setting_id']; ?>">
                                            <input type="hidden" name="info_id" value="<?php echo $info['info_id']; ?>">
                                            <div class="col-md-4 col-xs-6">
                                                <input type="hidden" name="sport_id" value="<?php echo $info['sport_id']; ?>">
                                                <label> MIN STAKE</label>
                                                <input type="text" name="min_stake" class="form-control" id="<?php echo $sport_id; ?>_min_stake" value="<?php echo $info['min_stake']; ?>" min="<?php echo $findMasterSetting['min_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_min_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max STAKE </label>
                                                <input type="text" name="max_stake" class="form-control" id="<?php echo $sport_id; ?>_max_stake" value="<?php echo $info['max_stake']; ?>" max="<?php echo $findMasterSetting['max_stake']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_stakeN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX PROFIT </label>
                                                <input type="text" name="max_profit" class="form-control" id="<?php echo $sport_id; ?>_max_profit" value="<?php echo $info['max_profit']; ?>" max="<?php echo $findMasterSetting['max_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_profitN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> Max Loss </label>
                                                <input type="text" name="max_loss" class="form-control" id="<?php echo $sport_id; ?>_max_loss" value="<?php echo $info['max_loss']; ?>" max="<?php echo $findMasterSetting['max_loss']; ?>">
                                                <span id="<?php echo $sport_id; ?>_max_lossN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> BET DELAY</label>
                                                <input type="text" name="bet_delay" class="form-control" id="<?php echo $sport_id; ?>_bet_delay" value="<?php echo $info['bet_delay']; ?>" min="<?php echo $findMasterSetting['bet_delay']; ?>">
                                                <span id="<?php echo $sport_id; ?>_bet_delayN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> PRE INPLAY PROFIT</label>
                                                <input type="text" name="pre_inplay_profit" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_profit" value="<?php echo $info['pre_inplay_profit']; ?>" max="<?php echo $findMasterSetting['pre_inplay_profit']; ?>">
                                                <span id="<?php echo $sport_id; ?>_pre_innplay_profitN" class="errmsg"></span>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> PRE INPLAY STAKE</label>
                                                <input type="text" name="pre_inplay_stake" class="form-control" id="<?php echo $sport_id; ?>_pre_inplay_stake" value="<?php echo $info['pre_inplay_stake']; ?>" max="<?php echo $findMasterSetting['pre_inplay_stake']; ?>">

                                            </div>

                                            <div class="col-md-4 col-xs-6">
                                                <label> MIN ODDS</label>
                                                <input type="text" name="min_odds" class="form-control" id="<?php echo $sport_id; ?>_min_odds" value="<?php echo $info['min_odds']; ?>" min="<?php echo $findMasterSetting['min_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> MAX ODDS</label>
                                                <input type="text" name="max_odds" class="form-control" id="<?php echo $sport_id; ?>_max_odds" value="<?php echo $info['max_odds']; ?>" max="<?php echo $findMasterSetting['max_odds']; ?>">

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label>UNMATCH BET</label>
                                                <input type="checkbox" name="unmatch_bet" value="Yes" <?php if ($info['unmatch_bet'] == 'Yes') {
                                                                                                            echo "checked";
                                                                                                        } ?>> <br>

                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label> LOCK BET</label>
                                                <!--input type="text" name="sport[lock_bet]" class="form-control" id="cricket_lock_bet" value=""-->
                                                <input type="checkbox" name="lock_bet" value="Yes" <?php if ($info['lock_bet'] == 'Yes') {
                                                                                                        echo "checked";
                                                                                                    } ?>> <br>
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <label>Match Odds</label>
                                                <input type="checkbox" name="is_odds_active" value="Yes" <?php if ($info['is_odds_active'] == 'Yes') {
                                                                                                                echo "checked";
                                                                                                            } ?>> <br>

                                            </div>

                                            <div class="col-md-12 col-xs-12 modal-footer">
                                                <!--input type="checkbox" name="updateuser"/>Click to update bet & fancy delay for all users<br/-->
                                                <button type="button" class="<?php echo $sport_id; ?>_button  blue_button submit_user_setting" id="update-1-setting">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                            <?php }
                            }


                            ?>

                    <?php }
                    }
                    ?>
                    <!-- 1=>Soccer,2=>Tennis,4=>Cricket,10=>Fancy,11=>Manual Fancy,12=>Manual Match Odds,13=>Lm Fancy -->

          

            </section>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $("#4_setting").validate({
            rules: {
                min_stake: {
                    required: true,
                },
                max_stake: {
                    required: true,
                },
                max_profit: {
                    required: true,
                },
            },

            submitHandler: function(form) {
                event.preventDefault();
            },
        });

        $("#2_setting").validate({
            rules: {
                min_stake: {
                    required: true,
                },
                max_stake: {
                    required: true,
                },
                max_profit: {
                    required: true,
                },
            },

            submitHandler: function(form) {
                event.preventDefault();
            },
        });

        $("#1_setting").validate({
            rules: {
                min_stake: {
                    required: true,
                },
                max_stake: {
                    required: true,
                },
                max_profit: {
                    required: true,
                },
            },

            submitHandler: function(form) {
                event.preventDefault();
            },
        });

        $("#999_setting").validate({
            rules: {
                min_stake: {
                    required: true,
                },
                max_stake: {
                    required: true,
                },

            },

            submitHandler: function(form) {
                event.preventDefault();
            },
        });


        $("#2000_setting").validate({
            rules: {
                min_stake: {
                    required: true,
                },
                max_stake: {
                    required: true,
                },
                max_profit: {
                    required: true,
                },
            },

            submitHandler: function(form) {
                event.preventDefault();
            },
        });
    });

    $(document).on("click", ".4_button", function() {

        event.preventDefault();
        if (($("#4_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#4_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    dataType: "json",

                    success: function success(output) {


                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })

    $(document).on("click", ".2_button", function() {

        event.preventDefault();
        if (($("#2_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#2_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    dataType: "json",
                    success: function success(output) {

                        // output = $.parseJSON(output);
                        console.log(output);

                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })

    $(document).on("click", ".1_button", function() {

        event.preventDefault();
        if (($("#1_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#1_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    success: function success(output) {

                        output = $.parseJSON(output);
                        console.log(output);

                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })

    $(document).on("click", ".999_button", function() {

        event.preventDefault();
        if (($("#999_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#999_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    success: function success(output) {

                        output = $.parseJSON(output);
                        console.log(output);

                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })


    $(document).on("click", ".1000_button", function() {

        event.preventDefault();
        if (($("#1000_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#1000_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    success: function success(output) {

                        output = $.parseJSON(output);
                        console.log(output);

                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })

    $(document).on("click", ".2000_button", function() {

        event.preventDefault();
        if (($("#2000_setting").valid())) {
            i = 0;
            if (i == 0) {
                var datastring = $('#2000_setting').serializeJSON();
                console.log(datastring);
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                    data: datastring,
                    cache: false,
                    success: function success(output) {

                        output = $.parseJSON(output);
                        console.log(output);

                        if (output.success) {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Success',
                                text: output.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        } else {
                            $("#divLoading").show();
                            $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                            $("#divLoading").fadeOut(3000);
                            new PNotify({
                                title: 'Error',
                                text: output.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 2000
                            });
                        }
                    }
                });
            }
            i++;
            return false;
        }
        return false;

    })

    $(document).on("click", ".7_button", function() {

event.preventDefault();
if (($("#7_setting").valid())) {
    i = 0;
    if (i == 0) {
        var datastring = $('#7_setting').serializeJSON();
        console.log(datastring);
        $.ajax({
            type: "post",
            url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
            data: datastring,
            cache: false,
            success: function success(output) {

                output = $.parseJSON(output);
                console.log(output);

                if (output.success) {
                    $("#divLoading").show();
                    $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                    $("#divLoading").fadeOut(3000);
                    new PNotify({
                        title: 'Success',
                        text: output.message,
                        type: 'success',
                        styling: 'bootstrap3',
                        delay: 2000
                    });
                } else {
                    $("#divLoading").show();
                    $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                    $("#divLoading").fadeOut(3000);
                    new PNotify({
                        title: 'Error',
                        text: output.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 2000
                    });
                }
            }
        });
    }
    i++;
    return false;
}
return false;

})



    function submit_user_setting(id) {

        i = 0;
        if (i == 0) {
            var datastring = $("#" + id).serializeJSON();

            $.ajax({
                type: "post",
                url: '<?php echo base_url(); ?>admin/User/updateviewinfo',
                data: datastring,
                cache: false,
                success: function success(output) {

                    output = $.parseJSON(output);
                    console.log(output);

                    if (output.success) {
                        $("#divLoading").show();
                        $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                        $("#divLoading").fadeOut(3000);
                        new PNotify({
                            title: 'Success',
                            text: output.message,
                            type: 'success',
                            styling: 'bootstrap3',
                            delay: 2000
                        });
                    } else {
                        $("#divLoading").show();
                        $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                        $("#divLoading").fadeOut(3000);
                        new PNotify({
                            title: 'Error',
                            text: output.message,
                            type: 'error',
                            styling: 'bootstrap3',
                            delay: 2000
                        });
                    }
                }
            });
        }
        i++;
    }
</script>