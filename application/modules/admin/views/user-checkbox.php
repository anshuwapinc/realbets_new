<input type="checkbox" name="user_id[]" class="user_ids" value="<?php echo $user['user_id']; ?>" />

<input type="hidden" name="partnership_<?php echo $user['user_id']; ?>" id="partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['partnership']; ?>" />
<input type="hidden" name="teenpati_partnership_<?php echo $user['user_id']; ?>" id="teenpati_partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['teenpati_partnership']; ?>" />
<input type="hidden" name="casino_partnership_<?php echo $user['user_id']; ?>" id="casino_partnership_<?php echo $user['user_id']; ?>" value="<?php echo $user['casino_partnership']; ?>" />
<input type="hidden" name="master_commision_<?php echo $user['user_id']; ?>" id="master_commision_<?php echo $user['user_id']; ?>" value="<?php echo $user['master_commision']; ?>" />
<input type="hidden" name="sessional_commision_<?php echo $user['user_id']; ?>" id="sessional_commision_<?php echo $user['user_id']; ?>" value="<?php echo $user['sessional_commision']; ?>" />
