<?php if (!empty($user_data)) {

if ($user_data->user_type == 'User') {
    $winnings = get_masters_winnings($user_data->user_id, $user_data->user_type);
?>
    <span id="ContentPlaceHolder1_dataTable_lblcradit_0" dataformatstring="{0:N2}" data-value="<?php echo $winnings; ?>"><?php echo  number_format($winnings, 2); ?></span>
<?php } else {

    $winnings = get_masters_winnings($user_data->user_id, $user_data->user_type);
?>
    <span id="ContentPlaceHolder1_dataTable_lblcradit_0" dataformatstring="{0:N2}" data-value="<?php echo $winnings; ?>"><?php echo  number_format($winnings, 2); ?></span>
<?php      }
}
