<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['custom']["pages"] = array(
    'superjackpot' => 'Super Jackpot',
    'lottoclub' => 'Lottery Club',
    'kontakt' => 'Contact',
    'gifts' => 'Gifts',
    'supportassocian' => 'Association Support'
);

$config['custom']['user_accountstatus'] = array(
    "" => "",
    "Activated" => "Activated",
    "Blocked" => "Blocked"
);
$config['custom']['google_map_enabled'] = array(
    "yes" => "Yes",
    "no" => "No"
);
$config['custom']['bregister_option'] = array(
    "yes" => "Yes",
    "no" => "No"
);
$config['custom']['default_location'] = "Dingwall";
$config['custom']['package_status'] = array(
    "Yes" => "Yes",
    "No" => "No",
);
$config['custom']['jobpost_uploadimage'] = array(
    'jobpost_uploadimage' => "assets/images/",
);

$config['custom']['admin_url_array'] = array(
    'dashboard' => 'dashboard',
    'useraccount' => 'useraccount'
);
$config['custom']["emailtemplates"] = array(
    'Signup Email' => 'Signup Email',
    'Forgot Password Email' => 'Forgot Password Email',
    'Quotation Email' => 'Quotation Email',
    'Bid Email' => 'Bid Email',
    'Bid Email to User' => 'Bid Email to User',
    'User Request Withdrawal' => 'User Request Withdrawal',
    'Book Ticket' => 'Book Ticket'
);
$config['custom']["pagetemplates"] = array(
    'About Us' => 'About Us',
    'Contact Us' => 'Contact Us',
    'Terms of Service' => 'Terms of Service',
);
$config['custom']["footercmss"] = array(
    'Company About' => 'Company About',
    'Contact Us' => 'Contact Us'
);
$config['custom']["sort_review"] = array(
    'new' => 'Newest First',
    'highest' => 'Highest Rate',
    'lowest' => 'Lowest Rate',
);
$config['custom']["user_accountstatus"] = array(
    "Activated" => "Activated",
    "Blocked" => "Blocked"
);

$config['custom']["useraccountstatus"] = array(
    "Activated" => "Activated",
    "Deleted" => "Deactivated",
    "All" => "All",
);

$config['custom']["gender"] = array(
    "male" => "male",
    "female" => "female",
);
$config['custom']["gender"] = array(
    "male" => "male",
    "female" => "female",
);
$config['custom']["lottery_type_draw"] = array(
    "weekly" => "Weekly",
    "monthly" => "Monthly",
    "yearly" => "Yearly"
);
$config['custom']["week_day"] = array(
    "Sunday" => "Sunday",
    "Monday" => "Monday",
    "Tuesday" => "Tuesday",
    "Wednesday" => "Wednesday",
    "Thursday" => "Thursday",
    "Friday" => "Friday",
    "Saturday" => "Saturday",
);

$config['custom']['categoryindexlimit'] = 6;

/*     * ************************** Pagination config ********************** */
$config['custom']['pagination_config'] = array(
    'use_page_numbers' => true,
    'num_links' => 2,
    'full_tag_open' => '<ul class="pagination-custom list-unstyled list-inline" >',
    'full_tag_close' => '</ul>',
    'first_tag_open' => '<li>',
    'first_tag_close' => '</li>',
    'last_tag_open' => '<li>',
    'last_tag_close' => '</li>',
    'next_tag_open' => '<li>',
    'next_tag_close' => '</li>',
    'prev_tag_open' => '<li>',
    'prev_tag_close' => '</li>',
    'num_tag_open' => '<li>',
    'num_tag_close' => '</li>',
    'cur_tag_open' => '<li><a  class="btn btn-sm btn-primary" style="border-radius: 0px !important;">',
    'cur_tag_close' => '</a></li>',
    'next_link' => '&raquo;',
    'prev_link' => '&laquo;',
);
$config['custom']['category_per_page'] = 2;

$config['custom']['owner-category_per_page'] = 1;
$config['custom']['searchitemperpage'] = 1;
$config['custom']['owner-review_per_page'] = 1;
$config['custom']['our-job_per_page'] = 4;
$config['custom']['job-list_per_page'] = 1;
$config['custom']['rating_limit'] = 1;
$config['custom']['fav_limit'] = 2;




$config['custom']['default_language'] = 'english';

$config['custom']['language'] = array(
    'english' => 'English',
    'swedish' => 'Swedish'
);

$config['custom']['admin_language'] = array(
    'EN' => 'English',
    'SW' => 'Swedish'

);

//online Lott­o­k­l­u­bben

$config['custom']['fb_app_id'] = "347123355672793";
$config['custom']['fb_app_secret'] = "7de265af2435e273e1b6a7e2eb554b99";

$config['custom']['fb__association_app_id'] = "347123355672793";
$config['custom']['fb_association_app_secret'] = "7de265af2435e273e1b6a7e2eb554b99";

//it's work fine lottery
/*$config['custom']['fb_app_id'] = "737039506455480";
    $config['custom']['fb_app_secret'] = "4a846f44e8850cd5b3ee73969bc0b09d";*/

/*$config['custom']['fb__association_app_id'] = "1657670817874155";
    $config['custom']['fb_association_app_secret'] = "0bfd5d92b9a0cd9d4abd218cb46d19ba";*/



//localhost
//    $config['custom']['fb_app_id'] = "1803285733257850";
//    $config['custom']['fb_app_secret'] = "96294b316df29a442ab19db9a7fde98b";

$config['custom']["user_profile"] = array(
    'upload_path' => 'assets/user_image/',
    'allowed_types' => 'jpg|jpeg|png',
    'default_image' => 'default.png',
    'overwrite' => true
);

$config['custom']["product_image"] = array(
    'upload_path' => 'assets/product_image/',
    'allowed_types' => 'jpg|jpeg|png',
    'default_image' => 'default.png',
    'overwrite' => true
);

$config['custom']["admin_image"] = array(
    'upload_path' => 'assets/admin_image/',
    'allowed_types' => 'jpg|jpeg|png',
    'default_image' => 'default.png',
    'overwrite' => true
);

$config['custom']['jackpot_lottery_start'] = 1;
$config['custom']['jackpot_lottery_tickets_number'] = 100000;


$config['custom']['lottery_tickets_number'] = 1000;
$config['custom']['resultsPerPage'] = 10;
$config['custom']['lottery_each_ticket_price'] = 35;
$config['custom']['lottery_sold'] = 50;
$config['custom']['lottery_start'] = 1;
$config['custom']['months_arr'] = array(
    "01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec"
);

$day_arr = array();
for ($i = 1; $i <= 31; $i++) {
    if ($i < 10) {
        $i = "0" . $i;
    }
    $day_arr[$i] = $i;
}
$config['custom']['days_arr'] = $day_arr;

$config['custom']['paypal_fixed'] = "0.30";
$config['custom']['paypal_variable'] = "2.9";

$config['custom']['paypal'] = array(
    "url" => "https://www.paypal.com/cgi-bin/webscr",
    "id" => "payments@fl-net.se",
    "test_mode" => "off",
);
$config['custom']['currency_symbol'] = 'Â£';
$config['custom']['currency_code'] = 'SEK';

$config['custom']['payment_methods'] = array("paypal" => "Paypal", "payson" => "Bank/Kreditkort");



$config['custom']["payson_agentID"] = "4";
$config['custom']["payson_md5Key"] = "2acab30d-fe50-426f-90d7-8c60a7eb31d4";

/*$config['custom']["payson_agentID"] = "33277";
    $config['custom']["payson_md5Key"] = "9b5022b4-ad06-49ef-ad6d-2924ef7aaee6";*/



$config['custom']["payson_receiverEmail"] = "testagent-1@payson.se";
$config['custom']["payson_senderEmail"] = "test-shopper@payson.se";
$config['custom']["payson_senderFirstname"] = "Test";
$config['custom']["payson_senderLastname"] = "Person";

/*$config['custom']["payson_receiverEmail"] = "payments@fl-net.se";
    $config['custom']["payson_senderEmail"] = "'Signup Email'";
    $config['custom']["payson_senderFirstname"] = "";
    $config['custom']["payson_senderLastname"] = "";*/




$config['custom']['payson_fixed'] = "0.30";
$config['custom']['payson_variable'] = "2.9";

$config['custom']['withdrawalamount'] = 100;
$config['custom']['adminemail'] = 'michael@fl-net.se';

$config['custom']["association_logo"] = array(
    'upload_path' => 'assets/association_logo/',
    'allowed_types' => 'jpg|jpeg|png',
    'default_image' => 'default.png',
    'overwrite' => true
);

$config['custom']['tmp_record_delete_min'] = 10;
