<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function object_to_array($obj)
{
    if (is_object($obj))
        $obj = (array) $obj;
    if (is_array($obj)) {
        $new = array();
        foreach ($obj as $key => $val) {
            $new[$key] = object_to_array($val);
        }
    } else
        $new = $obj;
    return $new;
}

function addhttp($url)
{
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function add_blank_option($options, $blank_option = '')
{
    if (is_array($options) && is_string($blank_option)) {
        if (empty($blank_option)) {
            $blank_option = array('' => '');
        } else {
            $blank_option = array('' => $blank_option);
        }
        $options = $blank_option + $options;
        //p($options);
        return $options;
    } else {
        show_error("Wrong options array passed");
    }
}

function getCustomConfigItem($key)
{
    $CI = &get_instance();
    $arr_custom_config = $CI->config->item('custom');
    $config_item = $arr_custom_config[$key];
    return $config_item;
}

function linkforticket($ticktno)
{

    $url = base_url() . 'public/user/draw_page/';
    $html = '<a href="' . $url . '">' . $ticktno . '</a>';
    return $html;
}

function acitivites_rating($rating_id, $rating_details)
{
    if ($rating_details->publish === 'no') {
        $url = base_url() . 'admin/rating/ratingactivate/' . $rating_details->rating_id;
        $return = '<a href="' . $url . '"> <i class="fa fa-toggle-off  action-icon"></i></a>';
    } else {
        $url = base_url() . 'admin/rating/ratingdeactivate/' . $rating_details->rating_id;
        $return = '<a href="' . $url . '"><i style="color:green" class="fa fa-toggle-on  action-icon"></i></a>';
    }
    return $return;
}

function userwithdrawrequesstatus($status, $withdraw_detail)
{
    $select = '';
    $select1 = '';
    $disable = '';


    if ($withdraw_detail->status == "Pending") {
        $select1 = 'selected';
    } else {
        $select = 'selected';
        $disable = 'disabled';
    }

    $html = '<select ' . $disable . ' class="form-control" id="statuschange" data-myval="' . $withdraw_detail->id . '"  onchange="change_status(this)">'
        . '<option value="Pending" ' . $select1 . '>Pending</option>'
        . '<option value="Approved" ' . $select . '>Approved</option>'
        . '</select>';

    return $html;
}

function userstatuschange($id, $data)
{
    //echo $data->remove_user;
    $status = '';
    if ($data->remove_user == 'y') {
        $status = 'Activate';
    }
    if ($data->remove_user == 'n') {
        $status = 'Deactivate';
    }

    $url = base_url() . 'admin_userstatus/' . $id . '/' . $data->remove_user;
    $html = '<a href="' . $url . '">' . $status . '</a>';
    return $html;
}

function associationwithdrawrequesstatus($status, $withdraw_detail)
{
    $select = '';
    $select1 = '';
    $disable = '';

    if ($withdraw_detail->status == "Pending") {
        $select1 = 'selected';
    } else {
        $select = 'selected';
        $disable = 'disabled';
    }

    $html = '<select ' . $disable . '  class="form-control" id="statuschange" data-myvalass="' . $withdraw_detail->id . '"  onchange="change_status(this)">'
        . '<option value="Pending" ' . $select1 . '>Pending</option>'
        . '<option value="Approved" ' . $select . '>Approved</option>'
        . '</select>';
    return $html;
}

function GetLoggedinUserData()
{
    $CI = &get_instance();
    // p($_SESSION,0);
    //$userdata = (array) $CI->session->userdata;
    if (!empty($CI->session->userdata['my_userdata'])) {
        $userdata = (array) $CI->session->userdata["my_userdata"];
    } else {
        $userdata = array();
    }

    return $userdata;
}

function GetLoggedinAssociationData()
{
    $CI = &get_instance();

    //$userdata = (array) $CI->session->userdata;
    if (!empty($CI->session->userdata['my_associationdata'])) {
        $userdata = (array) $CI->session->userdata["my_associationdata"];
    } else {
        $userdata = array();
    }

    return $userdata;
}

function GetLoggedinAdminUserData()
{

    $CI = &get_instance();
    //$userdata = (array) $CI->session->userdata["my_userdata"];
    $userdata = (array) $CI->session->my_userdata;
    return $userdata;
}

function getsessionid()
{
    $sessionid = PHPSESSID;  //$CI->session->userdata('sessionid');
    return $sessionid;
}

function getlogin_referrer()
{
    $CI = &get_instance();

    if (empty($CI->session->userdata['login_referrer'])) {
        $redirectto = base_url() . 'profile';
    } else {
        $login_referrer = $CI->session->userdata['login_referrer'];

        $redirectto = $login_referrer;
        return $redirectto;
    }
}

function my_currency_format($value)
{
    //$currencty_symbol = getCustomConfigItem('currency_symbol');
    $currencty_symbol = getCustomConfigItem('currency_code');
    $symbol = empty($currencty_symbol) ? '$' : $currencty_symbol;
    $my_currency_format = number_format((float) $value, 2, '.', '') . ' ' . $symbol;
    return $my_currency_format;
}

function base64url_encode($data)
{

    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{

    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function mydateformat($date, $from_format = "d-m-Y", $to_format = "Y-m-d")
{
    if ($date == "") {
        $return_date = "0000-00-00";
    } else {
        $date = DateTime::createFromFormat($from_format, $date);
        $return_date = $date->format($to_format);
    }

    return $return_date;
}

function create_captcha_common()
{
    $CI = &get_instance();
    $CI->load->helper('captcha');

    $vals = array(
        'word' => randomPassword(6),
        'img_path' => APPPATH . 'uploads/captcha/images/',
        'img_url' => base_url() . 'application/uploads/captcha/images/',
        'font_path' => APPPATH . 'uploads/captcha/OpenSans-Regular.ttf',
        'img_width' => 150,
        'img_height' => 60,
        'expiration' => 7200
    );
    $cap = create_captcha($vals);

    $_SESSION['thetopupstore']['captcha'] = $cap;
    return $cap;
}

function randomPassword($len = 16)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $len; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function getclientip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getlocationfromip($ipAddr)
{

    //include('ip2locationlite.class.php');
    // $ipLite = new ip2location_lite;
    // $ipLite->setKey('20b96dca8b9a5d37b0355e9461c66e76eed30a2274422fa6213d9de6ffb2b34e');
    //Get errors and locations
    //  $arr = $ipLite->getCity($ipAddr);

    $url = "http://api.ipinfodb.com/v3/ip-city/?key=5cfaab6c5af420b7b0f88d289571b990763e37b66761b2f053246f9db07ca913&ip=$ipAddr&format=json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $arr = json_decode($data);
    if (!empty($arr)) {
        $array['country'] = $arr->countryName;
        $array['state'] = $arr->regionName;
        $array['city'] = $arr->cityName;
    } else {
        return null;
    }

    return $array;
}

function relativetime($timestamp)
{

    if (!is_numeric($timestamp)) {

        $timestamp = strtotime($timestamp);
        if (!is_numeric($timestamp)) {
            return "";
        }
    }

    $difference = time() - $timestamp;
    // Customize in your own language.
    $periods = array("sec", "min", "hour", "day", "week", "month", "years", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    if ($difference > 0) { // this was in the past
        $ending = "ago";
    } else { // this was in the future
        $difference = -$difference;
        $ending = "to go";
    }
    for ($j = 0; $difference >= $lengths[$j] and $j < 7; $j++)
        $difference /= $lengths[$j];
    $difference = round($difference);
    if ($difference != 1) {
        // Also change this if needed for an other language
        $periods[$j] .= "s";
    }
    $text = "$difference $periods[$j] $ending";

    return $text;
}

function get_rating_htmls($starNumber)
{
    $html = '<div class="rating-stars">';
    for ($x = 1; $x <= $starNumber; $x++) {
        $html .= '<i class="fa fa-star"></i>';
    }
    if (strpos($starNumber, '.')) {
        $html .= '<i class="fa fa-star-half-o"></i>';
        $x++;
    }
    while ($x <= 5) {
        $html .= '<i class="fa fa-star-o"></i>';
        $x++;
    }
    $html .= '</div>';
    return $html;
}

function get_user_pictureurl($user_id)
{
    $CI = &get_instance();
    $CI->load->model("Useraccount_model");
    $result = $CI->Useraccount_model->get_user_pic($user_id);

    $imagename = $result->user_profile;
    $user_image = getCustomConfigItem('user_profile');
    if (empty($imagename)) {
        $dataArray['img_path'] = $user_image['upload_path'];
        $defaultimg = $user_image['default_image'];
        $url = $dataArray['img_path'] . $defaultimg;
        $imageurl = base_url() . $url;
    } else {
        $dataArray['img_path'] = $user_image['upload_path'];
        $url = $dataArray['img_path'] . $imagename;
        $imageurl = base_url() . $url;
    }
    return $imageurl;
}

function get_sponsor_pictureurl($sponsor_id)
{
    $CI = &get_instance();
    $CI->load->model("Useraccount_model");
    $result = $CI->Useraccount_model->get_sponsor_pic($sponsor_id);

    $imagename = $result->image;
    $sponsor_image = getCustomConfigItem('user_profile');
    if (empty($imagename)) {
        $dataArray['img_path'] = $sponsor_image['upload_path'];
        $defaultimg = $sponsor_image['default_image'];
        $url = $dataArray['img_path'] . $defaultimg;
        $imageurl = base_url() . $url;
    } else {
        $dataArray['img_path'] = $sponsor_image['upload_path'];
        $url = $dataArray['img_path'] . $imagename;
        $imageurl = base_url() . $url;
    }
    return $imageurl;
}


function get_admin_pictureurl($id)
{
    $CI = &get_instance();
    $CI->load->model("Admin_model");
    $result = $CI->Admin_model->get_admin_pic($id);

    $imagename = $result->picture;
    $user_image = getCustomConfigItem('admin_image');
    if (empty($imagename)) {
        $dataArray['img_path'] = $user_image['upload_path'];
        $defaultimg = $user_image['default_image'];
        $url = $dataArray['img_path'] . $defaultimg;
        $imageurl = base_url() . $url;
    } else {
        $dataArray['img_path'] = $user_image['upload_path'];
        $url = $dataArray['img_path'] . $imagename;
        $imageurl = base_url() . $url;
    }
    return $imageurl;
}

//    function getDefaultlanguage()
//    {
//        $langauage = getCustomConfigItem('default_language');
//        return $langauage;
//    }




function getLanguage()
{
    $CI = &get_instance();
    $site_lang = $CI->session->userdata('site_lang');

    if (!empty($site_lang)) {
        $language = $site_lang;
    } else {
        $language = getCustomConfigItem('default_language');
    }
    return $language;
}

function random_ticket_number_jackpot($min, $max, $ignore_no_arr = array())
{
    $valeurs = range($min, $max);
    $tmp_values_arr = array();
    foreach ($valeurs as $getvalue) {
        $maxlength = strlen($max);
        $getvalue = str_pad($getvalue, $maxlength, '0', STR_PAD_LEFT);
        $tmp_values_arr[$getvalue] = $getvalue;
    }

    if (!empty($ignore_no_arr)) {
        $result = array_diff($tmp_values_arr, $ignore_no_arr);
    } else {
        $result = $tmp_values_arr;
    }
    $ticketnumber = array_rand($result, 1);


    return $ticketnumber;
}

function random_ticket_number($min, $max, $ignore_no_arr = array())
{
    $valeurs = range($min, $max);
    $tmp_values_arr = array();
    foreach ($valeurs as $getvalue) {
        $maxlength = strlen($max);
        $getvalue = str_pad($getvalue, $maxlength, '0', STR_PAD_LEFT);
        $tmp_values_arr[$getvalue] = $getvalue;
    }

    if (!empty($ignore_no_arr)) {
        $result = array_diff($tmp_values_arr, $ignore_no_arr);
    } else {
        $result = $tmp_values_arr;
    }

    $ticketnumber = "";
    if (!empty($result)) {
        $ticketnumber = array_rand($result, 1);
    }


    return $ticketnumber;
}

function getrandom_number($min, $max, $ignore_no_arr)
{
    $randomno = random_ticket_number($min, $max);


    var_dump($randomno);
    if (empty($randomno)) {
        $randomno = random_ticket_number($min, $max);
    }
    if (in_array($randomno, $ignore_no_arr)) {
        getrandom_number($min, $max, $ignore_no_arr);
    } else {
        return $randomno;
    }
}

function createdaterangearray($strDateFrom, $strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function getdrawdates($startdate, $enddate, $drawtype, $drawday)
{
    $dates_arr = array();
    // $drawtype="yearly";
    // $weekday = "Friday";
    //$monthday = "02";
    //$yearday = "02-14";

    $dates = createdaterangearray($startdate, $enddate);

    if (!empty($dates)) {
        switch ($drawtype) {
            case "weekly":

                foreach ($dates as $date) {
                    if ($drawday == date("l", strtotime($date))) {
                        $dates_arr[] = $date;
                    }
                }
                break;
            case "monthly":
                foreach ($dates as $date) {

                    if ($drawday == date("d", strtotime($date))) {
                        $dates_arr[] = $date;
                    }
                }
                break;
            case "yearly":
                foreach ($dates as $date) {
                    if (strpos($date, $drawday) == true) {
                        $dates_arr[] = $date;
                    }
                }
                break;
        }
    }

    return $dates_arr;
}

function admin_outstanding_amount()
{
    $CI = &get_instance();
    $CI->load->model('Useraccount_model');
    $outstanding_amount = 0;
    $outstanding_amount = $CI->Useraccount_model->adminshare();
    $donation_outstanding_amount = $CI->Useraccount_model->getdonationadminshare();
    $outstanding_amount = floatnumber($outstanding_amount + $donation_outstanding_amount);
    return $outstanding_amount;
}

function superjackpot_outstanding_amount()
{
    $CI = &get_instance();
    $CI->load->model('Useraccount_model');
    $outstanding_amount = 0;
    $outstanding_amount = $CI->Useraccount_model->superjackpot_amount();

    $outstanding_amount = floatnumber($outstanding_amount);
    return $outstanding_amount;
}




function floatnumber($number)
{
    $result = number_format((float) $number, 2, '.', '');
    return $result;
}



function pricedec($pd)
{
    $CI = &get_instance();
    $return = $pd;
    if ($pd == 1) {
        $return = '1st';
    }
    if ($pd == 2) {
        $return = '2nd';
    }
    if ($pd == 3) {
        $return = '3rd';
    }
    if ($pd == 4) {
        $return = '4th';
    }
    if ($pd == 5) {
        $return = '5th';
    }
    if ($pd == 6) {
        $return = '6th';
    }
    if ($pd == 7) {
        $return = '7th';
    }
    if ($pd == 8) {
        $return = '8th';
    }
    if ($pd == 9) {
        $return = '9th';
    }
    if ($pd == 10) {
        $return = '10th';
    }
    return $return;
}

function get_all_tickets_checkbox($id, $other)
{
    $checkbtn = "<input type='checkbox' id='$id' name='select_ticket[]' value='$id'>";
    return $checkbtn;
}

function check_association_admin_login()
{
    $association_user_data = GetLoggedinAssociationData();
    $admin_user_data = GetLoggedinAdminUserData();

    $auth_login = false;
    if (!empty($association_user_data)) {
        $auth_login = true;
    }
    if (!empty($admin_user_data)) {
        if ($admin_user_data['usertype'] == "Admin") {
            $auth_login = true;
        }
    }
    return $auth_login;
}

function updateuserbalance($id, $data)
{
    $html = "";
    $amount_status_arr = array("Plus" => "Plus", "Minus" => "Minus");
    $html .= '<div style="width:300px;"><div class="col-md-12"><div class="col-md-8">';
    $html .= '<select class="form-control" id="updateledger"  name="updatestatus[' . $id . ']" >';
    $html .= '<option value="">' . lang("selectbalance") . '</option>';
    foreach ($amount_status_arr as $key => $val) {
        $html .= '<option value="' . $key . '">' . $val . '</option>';
    }
    $html .= '</select></div><div class="col-md-4">';
    $html .= '<input type="textbox"  class="form-control" name="updateledger[' . $id . ']">';
    $html .= '</div></div></div>';
    return $html;
}

function GetLoggedinSponsorData()
{
    $CI = &get_instance();

    //$userdata = (array) $CI->session->userdata;
    if (!empty($CI->session->userdata['sponsor_data'])) {
        $userdata = (array) $CI->session->userdata["sponsor_data"];
    } else {
        $userdata = array();
    }

    return $userdata;
}

function send_sponser_ticket_mail($sponsor_id, $lottery_id, $email, $ticket_no, $username = NULL, $password = NULL)
{
    $CI = &get_instance();
    $CI->load->model('Sponsor_model');
    $CI->load->library('commonlibrary');
    $templateRecord = $CI->Sponsor_model->get_sponsor_massage($sponsor_id, $lottery_id);

    if (!empty($templateRecord)) {
        $content = $templateRecord['message'];
    }
    $subject = 'Sponsor';
    $arr_placeholders = array("{{ticket_no}}", "{{sponsor_name}}", "{{sponsor_company}}", "{{URL}}", "{{user_name}}", "{{password}}");
    $arr_placeholders_values = array($ticket_no, $templateRecord['name'], $templateRecord['companyname'], base_url(), $username, $password);
    $content = str_replace($arr_placeholders, $arr_placeholders_values, $content);
    $CI->commonlibrary->sendmail($email, null, $subject, $content, "html");
}

function check_sponsor_payment($sponsor_id)
{
    $CI = &get_instance();

    $CI->load->model('Sponsor_model');
    $CI->load->library('commonlibrary');
    $get_sponsor_detail = $CI->Sponsor_model->get_sponsor_detail($sponsor_id);
    if ($get_sponsor_detail['payment_status'] != 'Success') {
        return false;
    } else {
        return true;
    }
}




function association_name_encode($association_name)
{
    $return = str_replace(" ", "_", $association_name);
    return $return;
}

function association_name_urldecode($association_name)
{
    $return =  str_replace("_", " ", urldecode($association_name));
    return $return;
}

function add_extra_contact($dataArray)
{
    $CI = &get_instance();
    $content = $CI->load->viewPartial('extra-contact-view', $dataArray, TRUE);
    return $content;
}

function view_extra_contact($dataArray)
{
    $CI = &get_instance();
    $content = $CI->load->viewPartial('view-extra-contact-view', $dataArray, TRUE);
    return $content;
}

function add_order_items($dataArray)
{
    $CI = &get_instance();
    $content = $CI->load->viewPartial('order-items-view', $dataArray, TRUE);
    return $content;
}


function get_user_status($user_id)
{
    $CI = &get_instance();


    $user_data = $CI->User_model->getUserById($user_id);

    if ($user_data->is_active == "0") {
        $return = "<a href='' class='active-status-change' id='user_active_anchor_" . $user_id . "' data-id='" . $user_id . "' data-status='" . $user_data->is_active . "'><i style='font-size:25px;' class='fa fa-toggle-on fa-x' id='active_status_" . $user_id . "'></i></a>";
    } else {
        $return = "<a href='' class='active-status-change' id='user_active_anchor_" . $user_id . "' data-id='" . $user_id . "' data-status='" . $user_data->is_active . "'><i style='font-size:25px;' class='fa fa-toggle-off fa-x' id='active_status_" . $user_id . "'></i></a>";
    }
    return $return;
}

function get_party_status($party_id)
{

    $CI = &get_instance();
    $user_data = $CI->Party_model->getPartysById($party_id);
    $return = "";

    if (isset($_SESSION['my_userdata']) && $_SESSION['my_userdata']['usertype'] == 'admin') {
        if (!empty($user_data)) {
            if ($user_data->is_active == "0") {
                $return = "<a href='' class='active-status-change' id='user_active_anchor_" . $party_id . "' data-id='" . $party_id . "' data-status='" . $user_data->is_active . "'><i style='font-size:25px;' class='fa fa-toggle-on fa-x' id='active_status_" . $party_id . "'></i></a>";
            } else {
                $return = "<a href='' class='active-status-change' id='user_active_anchor_" . $party_id . "' data-id='" . $party_id . "' data-status='" . $user_data->is_active . "'><i style='font-size:25px;' class='fa fa-toggle-off fa-x' id='active_status_" . $party_id . "'></i></a>";
            }
        }
    } else {
        if (!empty($user_data)) {
            if ($user_data->is_active == "0") {
                $return = "<span class='badge badge-success'>Active</a>";
            } else {
                $return = "<span class='badge badge-danger'>Deactive</a>";
            }
        }
    }

    return $return;
}

function get_order_status($status)
{

    // p($status);
    $CI = &get_instance();
    // p($status);
    $return = "";
    if ($status == "Follow-ups Required") {
        $return = '<small class="badge badge-warning">' . $status . '</small>';
    } else if ($status == "Rejected") {
        $return = '<small class="badge badge-danger">' . $status . '</small>';
    } else if ($status == "Hold") {
        $return = '<small class="badge badge-info">' . $status . '</small>';
    } else if ($status == "Completed") {
        $return = '<small class="badge badge-success">' . $status . '</small>';
    }

    return $return;
}



function GetLoggedinUserName()
{
    $CI = &get_instance();
    // p($_SESSION,0);
    //$userdata = (array) $CI->session->userdata;
    if (!empty($CI->session->userdata['my_userdata'])) {
        $userdata = (array) $CI->session->userdata["my_userdata"];
    } else {
        $userdata = array();
    }

    return $userdata;
}


function number_to_words($number)
{
    // $number = 190908100.25;
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        " " . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';
    echo $result . "Rupees  " . (empty($points) ? " Zero" : $points)  . " Paise Only";
}

function get_quotation_number()
{
    $CI = &get_instance();
    $CI->load->model("Order_model");
    $sessionDetails = $CI->Order_model->get_session();

    $quotation_no = "";

    $currentDate = date('Y-m-d');
    // $currentDate = date('2021-04-01');
    // p($sessionDetails);

    if (!empty($sessionDetails)) {

        // if ($sessionDetails->to < $currentDate) {


        //     $year = date('Y');
        //     // $year = "2021";

        //     $dataValue = array(
        //         "session_id" => $sessionDetails->session_id,
        //         "is_active" => "0"
        //     );
        //     $sessionDetails = $CI->Order_model->save_session($dataValue);

        //     $dataValue = array(
        //         "session" => $year . "-" . ($year + 1),
        //         "from" => $year . "-04-01",
        //         "to" => ($year + 1) . "-03-31"
        //     );
        //     $sessionDetails = $CI->Order_model->save_session($dataValue);


        //     $session = substr($year, 2, 4) . '-' . substr(($year + 1), 2, 4);
        //     $return = "PP/" . $session . "/1";

        //     // p($return);
        // } else {
        //     $sessionArr = explode("-", $sessionDetails->session);
        //     $session = substr($sessionArr[0], 2, 4) . '-' . substr($sessionArr[1], 2, 4);

        //     $result = $CI->Order_model->get_latest_quotation_no();
        //     // p($result);
        //     if (!empty($result)) {
        //         $oldquotation_no = $result->quotation_number;
        //         $quotation_arr = explode("/", $result->quotation_number);
        //         $quotation_sn = $quotation_arr[0];
        //         $quotation_year = $quotation_arr[1];
        //         $quotation_no = $quotation_arr[2];
        //         $return = "PP/" . ($session) . "/" . ($quotation_no + 1);
        //     } else {
        //         $return = "PP/" . ($session) . "/1";
        //     }


        //     // $session_arr = explode("-", $sessionDetails->session);
        //     // $current_year =  substr($session_arr[0], 2, 3);

        //     // $return = $quotation_sn . "/" . ($current_year . '-' . ($current_year + 1)) . "/" . ($quotation_no);

        //     // $check  = $CI->Order_model->get_latest_order_no($return);

        //     // if (!empty($check)) {
        //     //     $return = $quotation_sn . "-" . ($current_year) . "-" . ($quotation_no + 1);
        //     // }

        //     // echo "Old Year";
        // }

    }
    $result = $CI->Order_model->get_latest_quotation_no();
    // p($result);
    if (!empty($result)) {
        $oldquotation_no = $result->quotation_number;
        // p($oldquotation_no);
        // $quotation_arr = explode("/", $result->quotation_number);
        // $quotation_sn = $quotation_arr[0];
        // $quotation_year = $quotation_arr[1];
        // $quotation_no = $quotation_arr[2];
        $return = $oldquotation_no + 1;
    } else {
        $return = 1;
    }
    return $return;
}



function quotation_dateformat($quotation_date)
{
    if ($quotation_date == "") {
        $return_date = "00-00-0000";
    } else {

        $return_date = date('d-M-Y', strtotime($quotation_date));
    }

    return $return_date;
}

// Other cipher methods can be used. Identified what is available on your server
// by visiting: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
// END: Define some variable(s)

// BEGIN FUNCTIONS ***************************************************************** 
function EncryptThis($ClearTextData)
{
    // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
    // The initialization vector (IV) is appended to the cipher data with 
    // the use of two colons serve to delimited between the two.
    $ENCRYPTION_KEY = 'PeShVkYp3s6v9y$B&E)H@McQfTjWnZq4';
    $ENCRYPTION_ALGORITHM = 'AES-256-CBC';
    // p($ENCRYPTION_KEY);
    $EncryptionKey = base64_decode($ENCRYPTION_KEY);
    $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));
    $EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    return base64_encode($EncryptedText . '::' . $InitializationVector);
}

function DecryptThis($CipherData)
{
    // This function decrypts the cipher data (with the IV embedded within) passed into it 
    // and returns the clear text (unencrypted) data.
    // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
    // There are two colons that serve to delimited between the cipher data and the IV.
    $ENCRYPTION_KEY = 'PeShVkYp3s6v9y$B&E)H@McQfTjWnZq4';
    $ENCRYPTION_ALGORITHM = 'AES-256-CBC';
    $EncryptionKey = base64_decode($ENCRYPTION_KEY);
    list($Encrypted_Data, $InitializationVector) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
    return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
}
function send_on_whatsapp($order_id)
{
    $CI = &get_instance();
    $CI->load->model("Order_model");
    $orderDetails = $CI->Order_model->getOrderDetails($order_id);
    $return = "";

    if (!empty($orderDetails)) {
        $whatsapp_number = $orderDetails->whatsapp_number;
        if (!empty($whatsapp_number)) {
            $order_id = EncryptThis($order_id);
            $link = 'https://api.whatsapp.com/send?phone=+91' . $whatsapp_number . '& text=' . base_url() . 'quotationdownload?documentid=' . $order_id;
            $return .= '<a target="_blank" href="' . $link . '"><i class="fab fa-whatsapp fa-2x" aria-hidden="true"></i></a>
        ';
        }
    }

    return $return;
}


function get_party_restore($party_id)
{
    $CI = &get_instance();
    if (!empty($party_id)) {
        $return = "<a href='" . base_url() . "admin/partyRestore/" . $party_id . "' class='' id='user_active_anchor_" . $party_id . "' data-id='" . $party_id . "' '><i style='font-size:25px;' class='fa fa-trash-restore fa-x' id='active_status_" . $party_id . "'></i></a>";
    }
    return $return;
}



function get_order_edit($order_id)
{
    $CI = &get_instance();
    $CI->load->model("Order_model");
    $return = "";

    $sessionDetails = $_SESSION['my_userdata'];


    if (!empty($order_id)) {
        $details = $CI->Order_model->getOrderDetails($order_id);
        if ($sessionDetails['usertype'] == 'admin') {
            $return = "<a href='" . base_url() . "admin/addorder/partydetails/" . $order_id . "' class='' id='user_active_anchor_" . $order_id . "' data-id='" . $order_id . "' '><i  class='fa fa-edit action-icon' id='active_status_" . $order_id . "'></i></a>";
        } else if (!empty($details) && $details->status != 'Completed' && $sessionDetails['usertype'] != 'admin') {
            $return = "<a href='" . base_url() . "admin/addorder/partydetails/" . $order_id . "' class='' id='user_active_anchor_" . $order_id . "' data-id='" . $order_id . "' '><i  class='fa fa-edit action-icon' id='active_status_" . $order_id . "'></i></a>";
        }
    }
    return $return;
}


function get_party_edit($party_id)
{
    $CI = &get_instance();
    $CI->load->model("Party_model");
    $return = "";
    if (!empty($party_id)) {
        if (isset($_SESSION['my_userdata']) && $_SESSION['my_userdata']['usertype'] == 'employee') {
            $details = $CI->Party_model->getPartysById($party_id);
            if (!empty($details) && $details->employee_id == $_SESSION['my_userdata']['employee_id']) {
                $return = "<a href='" . base_url() . "admin/addparty/" . $party_id . "'><i  class='fa fa-edit action-icon'></i></a>";
            } else {
                $return = "<a href='" . base_url() . "admin/addparty/" . $party_id . "'><i  class='fa fa-edit action-icon'></i></a>";
            }
        } else {

            $return .= "<a href='" . base_url() . "admin/addparty/" . $party_id . "'><i  class='fa fa-edit action-icon'></i></a>";

            // p($return);
        }
    }
    return $return;
}

function get_order_delete($order_id)
{
    $CI = &get_instance();
    $CI->load->model("Order_model");
    $return = "";
    if (!empty($order_id)) {
        $details = $CI->Order_model->getOrderDetails($order_id);

        if (!empty($details) && $details->status != 'Completed') {
            $return = "<a href='" . base_url() . "admin/deleteorder/" . $order_id . "' class='' id='user_active_anchor_" . $order_id . "' data-id='" . $order_id . "' '><i  class='fa fa-trash action-icon' id='active_status_" . $order_id . "'></i></a>";
        }
    }
    return $return;
}

function get_order_view($order_id)
{
    $return = "";
    if (!empty($order_id)) {

        $return .= "<a href='" . base_url() . "admin/orderprint/" . $order_id . "' target='_blank' class='' id='user_active_anchor_" . $order_id . "' data-id='" . $order_id . "' '  title='View Real Quotation'><i  class='fa fa-copy action-icon' id='active_status_" . $order_id . "'></i></a>";
        $return .= "&nbsp;&nbsp;&nbsp;<a href='" . base_url() . "admin/orderprint/" . $order_id . "/MRP' target='_blank' class='' id='user_active_anchor_" . $order_id . "' title='View MRP Quotation'  data-id='" . $order_id . "'  '><i  class='fa fa-copy action-icon' id='active_status_" . $order_id . "'></i></a>";
        $return .= "&nbsp;&nbsp;&nbsp;<a href='" . base_url() . "admin/orderprint/" . $order_id . "/NRP' target='_blank' class='' id='user_active_anchor_" . $order_id . "' title='View NRP Quotation' data-id='" . $order_id . "' '><i  class='fa fa-copy action-icon' id='active_status_" . $order_id . "'></i></a>";
    }
    return $return;
}

function get_team_image($team_logo)
{
    $return = "";
    if (!empty($team_logo)) {

        $return .= "<img src='" . base_url() . "assets/teams_images/" . $team_logo . "' height='75'/>";
    } else {
        $return .= "<img src='" . base_url() . "assets/teams_images/default.png' height='75'/>";
    }
    return $return;
}

function validateusertemplate($fileName)
{
    $valid      = TRUE;
    $arr_errors = array();
    $CI = &get_instance();
    $CI->load->library("excel");
    $objPHPExcel = PHPExcel_IOFactory::load($fileName);

    $excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);
    $excelObj = $excelReader->load($fileName);
    $worksheet = $excelObj->getSheet(0);


    $lastRow = $worksheet->getHighestRow();
    $title = trim($worksheet->getCellByColumnAndRow(0, 1)->getValue());

    for ($row = 2; $row <= $lastRow; $row++) {
        $name = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
        $contact_no = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
        $whatsapp_no = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
        $address = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
        $username = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
        $password = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());

        if ($name == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Name for row no " . $row;
        }

        if ($contact_no == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Contact No. for row no " . $row;
        }

        if ($whatsapp_no == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Whatsapp No. for row no " . $row;
        }

        if ($address == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Address for row no " . $row;
        }

        if ($username == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Username for row no " . $row;
        }

        if ($password == "") {
            $valid        = FALSE;
            $arr_errors[] = "Missing Password for row no " . $row;
        }
    }

    $arr = array(
        "status" => $valid,
        "errors" => $arr_errors
    );



    return $arr;
}


function inplay_games()
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.b365api.com/v1/betfair/ex/inplay?token=62456-JeWhFFVTczg5dj",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);
}

function get_exchange_event_info($event_id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.b365api.com/v1/betfair/ex/event?token=62456-JeWhFFVTczg5dj&event_id=" . $event_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);
}

function get_user_name()
{
    echo isset($_SESSION['my_userdata']['user_name']) ? $_SESSION['my_userdata']['user_name'] : "";
}


function get_events()
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.b365api.com/v1/betfair/ex/upcoming?sport_id=4&token=62456-JeWhFFVTczg5dj",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));

    $response = curl_exec($curl);


    curl_close($curl);
    return json_decode($response);
}



function get_event_by_id($event_id)
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.b365api.com/v1/betfair/ex/event?token=62456-JeWhFFVTczg5dj&event_id=" . $event_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}


// function count_total_exposure($user_id)
// {   


//     $CI = &get_instance();
//     $CI->load->model("Betting_model");
//     $return = "";
//     $matches = array();


//     $events = $CI->Betting_model->get_bettings_markets($user_id);

//     $totalRiskAmt = 0;
//     if (!empty($events)) {
//         foreach ($events as $event) {
//             $bettings = $CI->Betting_model->get_last_bet(array('user_id' => $user_id, 'market_id' => $event->market_id));

//             if (!empty($bettings)) {
//                 if ($bettings->exposure_1 < 0 && $bettings->exposure_1 < $bettings->exposure_2) {
//                     $totalRiskAmt += $bettings->exposure_1;
//                 } else if ($bettings->exposure_2 < 0 && $bettings->exposure_2 < $bettings->exposure_1) {
//                     $totalRiskAmt += $bettings->exposure_2;
//                 } else {
//                     $totalRiskAmt += $bettings->exposure_2;
//                 }
//             }
//         }
//     }





//     $events = $CI->Betting_model->get_fancy_bettings_markets($user_id);

//     $totalFancyRiskAmt = 0;
//     if (!empty($events)) {
//         foreach ($events as $event) {
//             $totalFancyRiskAmt -= $event->loss;
//         }
//     }

//     return $totalRiskAmt + $totalFancyRiskAmt;
// }

function count_total_exposure($user_id = null)
{


    $CI = &get_instance();

    $CI->load->model("Betting_model");
    $return = "";
    $matches = array();

    if (!$user_id) {
        $user_id = get_user_id();
    }



    /**********************Markets******************** */
    $events = $CI->Betting_model->get_bettings_markets($user_id);

    $totalRiskAmt = 0;
    if (!empty($events)) {
        foreach ($events as $key => $event) {
            $exposures = get_user_market_exposure_by_marketid($event->market_id, $user_id);
            $totalRiskAmt +=  min($exposures);
        }
    }
    /**********************Markets******************** */

    /**********************Fancy********************** */

    $bettingsData = $CI->Betting_model->get_fancy_group_list(array('user_id' => $user_id));


    if (!empty($bettingsData)) {
        foreach ($bettingsData as $bettingData) {

            if ($bettingData['betting_type'] == 'Fancy') {
                $fancy_id = $bettingData['selection_id'];
                $dataArray = array(
                    'selection_id' => $fancy_id,
                    'user_id' => $user_id
                );

                $max = $CI->Betting_model->get_max_fancy_bettings($dataArray);
                $min = $CI->Betting_model->get_min_fancy_bettings($dataArray);

                $max_p = $max + 5;
                $min_p = $min - 5;

                $scores = array_reverse(range($min_p, $max_p));

                $bettings = $CI->Betting_model->get_fancy_bettings($dataArray);

                $tmp_array = array();

                foreach ($bettings as $betting) {
                    $price_val  = $betting->price_val;
                    $stake  = $betting->stake;
                    $profit  = $betting->profit;
                    $loss  = $betting->loss;


                    foreach ($scores as $score) {
                        if ($betting->is_back == 0) {
                            if (isset($tmp_array[$score])) {
                                if ($score >= $price_val) {
                                    $total = $tmp_array[$score] + $loss * -1;


                                    $tmp_array[$score] = $total;
                                } else {
                                    $total = $tmp_array[$score] + $profit * 1;
                                    $tmp_array[$score] = $total;
                                }
                            } else {
                                if ($score < $price_val) {
                                    $tmp_array[$score] = $profit;
                                } else {
                                    $tmp_array[$score] = $loss * -1;
                                }
                            }
                        } else {

                            if (isset($tmp_array[$score])) {
                                if ($score >= $price_val) {
                                    $total = $tmp_array[$score] + $profit * 1;
                                    $tmp_array[$score] = $total;
                                } else {
                                    $total = $tmp_array[$score] + $loss * -1;
                                    $tmp_array[$score] = $total;
                                }
                            } else {
                                if ($score >= $price_val) {
                                    $tmp_array[$score] = $profit * 1;
                                } else {
                                    $tmp_array[$score] = $loss * -1;
                                }
                            }
                        }
                    }
                }

                $totalRiskAmt +=  min($tmp_array);
            }
        }
    }


    /**********************Fancy********************** */

    return $totalRiskAmt >= 0 ? 0 : $totalRiskAmt;
}

function count_total_balance($user_id)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");
    $return = "";
    if (!empty($user_id)) {
        $balance = $CI->Ledger_model->count_total_balance($user_id);
    }

    // p($balance);

    if (isset($balance)) {
        $exposure = count_total_exposure($user_id);

        if ($exposure < 0) {
            return ($balance + $exposure) > 0 ? $balance + $exposure : 0;
        } else {
            return $balance;
        }
    } else {
        return 0;
    }
}

function count_total_balance_without_exposure($user_id)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");
    $return = "";
    if (!empty($user_id)) {
        $balance = $CI->Ledger_model->count_total_balance($user_id);
    }

    // p($balance);


    return isset($balance) ? $balance : 0;
}


function check_user_password($user_name, $password)
{
    $CI = &get_instance();
    $CI->load->model("Admin_model");
    $return = "";
    if (!empty($user_name)) {
        $record = $CI->Admin_model->check_user_password($user_name, md5($password));

        return $record;
    }
}


function count_free_chip($user_id)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");
    $return = "";
    if (!empty($user_id)) {
        $balance = $CI->Ledger_model->count_free_chip($user_id);
    }
    return $balance;
}



function get_fancy_by_id($bfid = null)
{
    if ($bfid === null) {
        $bfid = '1.172980694';
    }


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://45.76.159.197/BetfairData/DataAPI.svc/FancyData?bfid=" . $bfid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}

// Generate token
function getToken($length)
{
    return generateRandomString($length);
}

function check_user_type($type)
{
    if ($type == 'Hyper Super Master') {
        $user_type = 'hypersupermaster';
    } else if ($type == 'Super Master') {
        $user_type = 'supermaster';
    } else if ($type == 'Master') {
        $user_type = 'master';
    } else if ($type == 'User') {
        $user_type = 'user';
    } else if ($type == 'Admin') {
        $user_type = 'admin';
    }

    echo $user_type;
}

function check_inner_user($type)
{
    if ($type == 'Hyper Super Master') {
        $user_type = 'hypersupermaster';
    } else if ($type == 'Super Master') {
        $user_type = 'supermaster';
    } else if ($type == 'Master') {
        $user_type = 'master';
    } else if ($type == 'User') {
        $user_type = 'user';
    } else if ($type == 'Admin') {
        $user_type = 'admin';
    }

    echo $user_type;
}



function listEventTypes()
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listEventTypes",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}


function listCompetitions($sport_id = null)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listCompetitions&EventTypeID=" . $sport_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}



function listEvents($EventTypeID = null, $CompetitionID = null)
{


    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listEvents&EventTypeID=" . $EventTypeID . "&CompetitionID=" . $CompetitionID,
        // CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listEvents&EventTypeID=4&CompetitionID=101480",

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);


    curl_close($curl);
    return $response;
}



function listMarketTypes($EventID = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listMarketTypes&EventID=" . $EventID,

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    // $response = '[{"marketId":"1.173378424","marketName":"Match Odds","marketStartTime":"2020-09-29T14:00:00.000Z","totalMatched":184.491,"runners":[{"selectionId":22121561,"runnerName":"Delhi Capitals","handicap":0,"sortPriority":1},{"selectionId":7671296,"runnerName":"Sunrisers Hyderabad","handicap":0,"sortPriority":2}]}]';
    curl_close($curl);
    return $response;
}


function listMarketRunner($MarketID = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listMarketRunner&MarketID=" . $MarketID,

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    // $response = '[{"marketId":"1.173378424","marketName":"Match Odds","marketStartTime":"2020-09-29T14:00:00.000Z","totalMatched":184.491,"runners":[{"selectionId":22121561,"runnerName":"Delhi Capitals","handicap":0,"sortPriority":1},{"selectionId":7671296,"runnerName":"Sunrisers Hyderabad","handicap":0,"sortPriority":2}]}]';
    curl_close($curl);
    return $response;
}


function listMarketBookOdds($market_id = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/listMarketBookOdds?market_id=" . $market_id,

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    // $response = '[{"marketId":"1.173378424","marketName":"Match Odds","marketStartTime":"2020-09-29T14:00:00.000Z","totalMatched":184.491,"runners":[{"selectionId":22121561,"runnerName":"Delhi Capitals","handicap":0,"sortPriority":1},{"selectionId":7671296,"runnerName":"Sunrisers Hyderabad","handicap":0,"sortPriority":2}]}]';
    curl_close($curl);
    return $response;
}



function listMarketBookSession($match_id = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/listMarketBookSession?match_id=" . $match_id,

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    // $response = '[{"marketId":"1.173378424","marketName":"Match Odds","marketStartTime":"2020-09-29T14:00:00.000Z","totalMatched":184.491,"runners":[{"selectionId":22121561,"runnerName":"Delhi Capitals","handicap":0,"sortPriority":1},{"selectionId":7671296,"runnerName":"Sunrisers Hyderabad","handicap":0,"sortPriority":2}]}]';
    curl_close($curl);
    return $response;
}


function sendfancyresponse($data)
{
    $postdata = json_encode($data);
    $url = 'http://365exchange.vip:3000/fancyupdate';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    print_r($result);
}


function betting_ledger_maintain($user_id = null, $transaction_type = null, $amt = null, $partner_ship = null, $remarks = null, $user_type, $betting_id = null, $selection_id = null)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");

    if ($user_type != 'User') {
        $entry_amt = $amt * ($partner_ship / 100);
        $master_amt = $amt - $entry_amt;
    } else {
        $entry_amt = $amt;
        $master_amt = $entry_amt;
    }

    // $dataArray = array(
    //     'user_id' => $user_id,
    //     'betting_id' => $betting_id
    // );


    // $check_bet_exists =  $CI->Ledger_model->disable_existing_bet($dataArray);

    if ($transaction_type == 'Credit') {
        $dataArray = array(
            'user_id' => $user_id,
            'remarks' => $remarks,
            'transaction_type' => $transaction_type,
            'amount' => $entry_amt,
            'balance' => count_total_balance_without_exposure($user_id) + $entry_amt,
            'type' => 'Betting',
            'betting_id' => $betting_id,
            'selection_id' => $selection_id
        );
    } else {
        $dataArray = array(
            'user_id' => $user_id,
            'remarks' => $remarks,
            'transaction_type' => $transaction_type,
            'amount' => $entry_amt,
            'balance' => count_total_balance_without_exposure($user_id) - $entry_amt,
            'type' => 'Betting',
            'betting_id' => $betting_id,
            'selection_id' => $selection_id
        );
    }

    $CI->Ledger_model->addLedger($dataArray);

    return $master_amt;
}

function compress_htmlcode($codedata)
{
    $searchdata = array(
        '/\>[^\S ]+/s', // remove whitespaces after tags
        '/[^\S ]+\</s', // remove whitespaces before tags
        '/(\s)+/s' // remove multiple whitespace sequences
    );
    $replacedata = array('>', '<', '\\1');
    $codedata = preg_replace($searchdata, $replacedata, $codedata);
    $codedata = minimizeCSSsimple($codedata);


    //        $codedata =  str_replace(array("\n","\r","\t"),'', $codedata);
    return $codedata;
}

function minimizeCSSsimple($css)
{
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return $css;
}


function count_operator_pl($master_id, $user_pl)
{
    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_commission($master_id, 'Operator');
    return ($user_pl * $data->partnership) / 100;
}

function count_hyper_master_pl($master_id, $user_pl)
{
    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_commission($master_id, 'Hyper Super Master');
    return ($user_pl * $data->partnership) / 100;
}


function get_master_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];

    $users =  $CI->User_model->getInnerUserById($user_id);
    $totalBets = array();


    if (!empty($users)) {
        foreach ($users as $user) {
            $dataValues = array(
                'user_id' => $user->user_id,
                'match_id' => $match_id,
                'status' => 'Open'
            );


            $bettings = $CI->Betting_model->get_bettings($dataValues);

            if (!empty($bettings)) {
                foreach ($bettings as $betting) {
                    $totalBets[] = $betting;
                }
            }
        }
    }

    return $totalBets;
}
function get_commission($master_id, $user_type)
{

    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_commission($master_id, $user_type);
    return $data;
}

function get_supermaster_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];

    $masterusers =  $CI->User_model->getInnerUserById($user_id);
    $totalBets = array();
    if (!empty($masterusers)) {
        foreach ($masterusers as $masteruser) {

            $users =  $CI->User_model->getInnerUserById($masteruser->user_id);

            if (!empty($users)) {
                foreach ($users as $user) {
                    $dataValues = array(
                        'user_id' => $user->user_id,
                        'match_id' => $match_id,
                        'status' => 'Open'

                    );
                    $bettings = $CI->Betting_model->get_bettings($dataValues);

                    if (!empty($bettings)) {
                        foreach ($bettings as $betting) {
                            $totalBets[] = $betting;
                        }
                    }
                }
            }
        }
    }
    return $totalBets;
}

function get_betting_result_chips($user_id)
{

    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_bet_result_chips($user_id);
    $pl = 0;
    foreach ($data as $chip) {
        if ($chip['bet_result'] == 'Plus') {
            $pl += $chip['profit'];
        } elseif ($chip['bet_result'] == 'Minus') {
            $pl += $chip['loss'];
        }
    }
    return $pl;
}

function get_hyper_super_master_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $totalBets = array();

    $super_master_users =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($super_master_users)) {
        foreach ($super_master_users as $super_master_user) {
            $masterusers =  $CI->User_model->getInnerUserById($super_master_user->user_id);

            if (!empty($masterusers)) {
                foreach ($masterusers as $masteruser) {

                    $users =  $CI->User_model->getInnerUserById($masteruser->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {
                            $dataValues = array(
                                'user_id' => $user->user_id,
                                'match_id' => $match_id,
                                'status' => 'Open'

                            );
                            $bettings = $CI->Betting_model->get_bettings($dataValues);

                            if (!empty($bettings)) {
                                foreach ($bettings as $betting) {
                                    $totalBets[] = $betting;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $totalBets;
}
function get_admin_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $totalBets = array();

    $hyper_super_users =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($hyper_super_users)) {
        foreach ($hyper_super_users as $hyper_super_user) {

            $super_master_users =  $CI->User_model->getInnerUserById($hyper_super_user->user_id);

            if (!empty($super_master_users)) {
                foreach ($super_master_users as $super_master_user) {
                    $masterusers =  $CI->User_model->getInnerUserById($super_master_user->user_id);

                    if (!empty($masterusers)) {
                        foreach ($masterusers as $masteruser) {

                            $users =  $CI->User_model->getInnerUserById($masteruser->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {
                                    $dataValues = array(
                                        'user_id' => $user->user_id,
                                        'match_id' => $match_id,
                                        'status' => 'Open'

                                    );
                                    $bettings = $CI->Betting_model->get_bettings($dataValues);

                                    if (!empty($bettings)) {
                                        foreach ($bettings as $betting) {
                                            $totalBets[] = $betting;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $totalBets;
}

function get_user_pl_by_events($user_id, $event_type_id)
{

    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_user_pl_by_events_type($user_id, $event_type_id);
    $pl = 0;
    foreach ($data as $chip) {
        if ($chip['bet_result'] == 'Plus') {
            $pl += $chip['profit'];
        } elseif ($chip['bet_result'] == 'Minus') {

            $pl += $chip['loss'];
        }
    }
    return $pl;
}


function get_super_admin_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $totalBets = array();

    $admin_users =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($admin_users)) {
        foreach ($admin_users as $admin_user) {
            $hyper_super_users =  $CI->User_model->getInnerUserById($admin_user->user_id);

            if (!empty($hyper_super_users)) {
                foreach ($hyper_super_users as $hyper_super_user) {

                    $super_master_users =  $CI->User_model->getInnerUserById($hyper_super_user->user_id);

                    if (!empty($super_master_users)) {
                        foreach ($super_master_users as $super_master_user) {
                            $masterusers =  $CI->User_model->getInnerUserById($super_master_user->user_id);

                            if (!empty($masterusers)) {
                                foreach ($masterusers as $masteruser) {

                                    $users =  $CI->User_model->getInnerUserById($masteruser->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {
                                            $dataValues = array(
                                                'user_id' => $user->user_id,
                                                'match_id' => $match_id,
                                                'status' => 'Open'

                                            );
                                            $bettings = $CI->Betting_model->get_bettings($dataValues);

                                            if (!empty($bettings)) {
                                                foreach ($bettings as $betting) {
                                                    $totalBets[] = $betting;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $totalBets;
}

function get_fancy_pl($user_id)
{

    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_fancy($user_id);
    $pl = 0;
    foreach ($data as $chip) {
        if ($chip['bet_result'] == 'Plus') {
            $pl += $chip['profit'];
        } elseif ($chip['bet_result'] == 'Minus') {

            $pl += $chip['loss'];
        }
    }
    return $pl;
}
function remove_dashboard_betting($betting_id)
{
    // p($betting_id);
    $postdata = array(
        'betting_id' => $betting_id,
    );
    $postdata = json_encode($postdata);

    $url = get_ws_endpoint() . 'betting_settle';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
}

function get_user_id()
{
    return isset($_SESSION['my_userdata']['user_id']) ? $_SESSION['my_userdata']['user_id'] : '';
}

function get_total_winnings()
{
    $CI = &get_instance();
    $user_id = get_user_id();;
    $CI->load->model("Ledger_model");
    $data = $CI->Ledger_model->get_total_winnings($user_id);
    echo $data->winning_amount;
}



function get_running_markets()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $return = "";
    $matches = array();

    $user_id = get_user_id();

    $events = $CI->Betting_model->get_bettings_markets($user_id);
    $totalRiskAmt = 0;
    if (!empty($events)) {
        foreach ($events as $key => $event) {

            if ($event->market_name != 'Match Odds') {


                unset($events[$key]);
                continue;
            }
            $exposures = get_user_market_exposure_by_marketid($event->market_id);


            $i = 0;
            foreach ($exposures as $exposure) {
                $i++;
                $k = 'exposure_' . $i;
                $events[$key]->$k = $exposure;
            }
        }
    }

    return $events;
}


function check_current_odds($data1, $data2)
{
    $CI = &get_instance();
    $CI->load->model("Event_model");
    $events = $CI->Event_model->check_current_odds($data1, $data2);
    return $events;
}

function get_user_type()
{
    return  isset($_SESSION['my_userdata']['user_type']) ? $_SESSION['my_userdata']['user_type'] : "";
}

function get_master_id()
{
    return  isset($_SESSION['my_userdata']['master_id']) ? $_SESSION['my_userdata']['master_id'] : "";
}

function get_hmaster_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $master_id = get_master_id();
    $tmpBlockMarket = array();
    $type = $data['type'];

    $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));

    $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);



    $adminuser =  $CI->User_model->getUserById($master_id);
    if (!empty($adminuser)) {
        $master_id = $adminuser->master_id;
        $super_admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $super_admin_block_markets);
    }
    return $tmpBlockMarket;
}

function get_smaster_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $hyper_master_id = get_master_id();
    $type = $data['type'];

    $tmpBlockMarket = array();

    $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $hyper_master_id, 'type' => $type));

    $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);

    $hmaster_user =  $CI->User_model->getUserById($hyper_master_id);

    if (!empty($hmaster_user)) {
        $hmaster_master_id = $hmaster_user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $hmaster_master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);

        $super_admin_user =  $CI->User_model->getUserById($hmaster_master_id);

        if (!empty($super_admin_user)) {
            $hmaster_master_id = $super_admin_user->master_id;
            $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $hmaster_master_id, 'type' => $type));
            $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
        }
    }
    return $tmpBlockMarket;
}

function get_master_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $master_id = get_master_id();
    $type = $data['type'];

    $tmpBlockMarket = array();

    /**********Super Master */
    $block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
    $tmpBlockMarket =  array_merge($tmpBlockMarket, $block_markets);
    /**********Super Master */

    /**********Hyper Super Master */
    $user =  $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Super Master */

    /**********Admin Master */
    $user =  $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user =  $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */
    return $tmpBlockMarket;
}



function get_users_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $master_id = get_master_id();
    $type = $data['type'];

    $tmpBlockMarket = array();

    /********** Master */
    $block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
    $tmpBlockMarket =  array_merge($tmpBlockMarket, $block_markets);
    /********** Master */




    /********** Super Master */
    $user =  $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Master */


    /**********Hyper Super Master */
    $user =  $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Super Master */

    /**********Admin Master */
    $user =  $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user =  $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */

    return $tmpBlockMarket;
}


function get_admin_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $type = $data['type'];
    $tmpBlockMarket = array();

    $user_id = $data['user_id'];

    /**********Super Admin Master */
    $user =  $CI->User_model->getUserById($user_id);

    if (!empty($user)) {
        $master_id = $user->master_id;

        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */

    return $tmpBlockMarket;
}

function get_hyper_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");



    $type = $data['type'];
    $tmpBlockMarket = array();

    $user_id = $data['user_id'];

    $user =  $CI->User_model->getUserById($user_id);
    $master_id = $user->master_id;

    /**********Admin Master */
    $user =  $CI->User_model->getUserById($master_id);


    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
        $master_id = $user->master_id;
    }
    /**********Admin Master */


    /**********Super Admin Master */
    $user =  $CI->User_model->getUserById($master_id);
    // $master_id = $user->master_id;


    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));

        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */


    // p($tmpBlockMarket);
    return $tmpBlockMarket;
}

function get_super_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $type = $data['type'];
    $tmpBlockMarket = array();

    $user_id = $data['user_id'];

    $user =  $CI->User_model->getUserById($user_id);
    $master_id = $user->master_id;

    /**********Hyper Master */
    $user =  $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Master */

    /**********Admin Master */
    $user =  $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user =  $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket =  array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */

    return $tmpBlockMarket;
}



function get_running_markets_masters()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $users =  $CI->User_model->getInnerUserById($user_id);
    if (!empty($users)) {
        $open_markets  = $CI->Betting_model->get_open_markets(array());

        $x = 0;
        if (!empty($open_markets)) {
            foreach ($open_markets as $openMarketskey => $open_market) {
                $all_bettings = array();


                if ($open_market->market_name != 'Match Odds') {
                    unset($open_markets[$openMarketskey]);
                    continue;
                }


                $market_id = $open_market->market_id;

                foreach ($users as $user) {
                    $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $open_market->market_id, 'betting_type' => 'Match'));
                    $all_bettings = array_merge($all_bettings, $bettings);
                }


                if (!empty($all_bettings)) {
                    $total_exposure = array();
                    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $selection_id = $runner['selection_id'];
                            $total_exposure[$selection_id] = 0;
                        }
                    }

                    foreach ($all_bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {
                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Master');

                            $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $partner_ship = $bettingSetting->partnership;



                            if ($betting->is_back == 1) {
                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);


                                $stake = $betting->stake * ($partner_ship / 100);
                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   -= ($price);
                                } else {
                                    $total_exposure[$runnerKey]   += ($stake);
                                }
                            } else {


                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $stake = $betting->stake * ($partner_ship / 100);

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   += ($price);
                                } else {
                                    $total_exposure[$runnerKey]   -= ($stake);
                                }
                            }
                        }
                    }
                    $exposure = $total_exposure;

                    $i = 0;
                    foreach ($total_exposure as $exposure) {
                        $i++;
                        $k = 'exposure_' . $i;
                        $open_markets[$openMarketskey]->$k = $exposure;
                    }
                }
            }
        }
    }


    return $open_markets;
}


function count_market_exposure($all_bettings)
{

    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '_', $betting->market_id);

            $markets[$market_id] = array();
        }
    }

    if (!empty($markets)) {
        foreach ($markets as $key =>  $market) {
            $market_id = str_replace('_', '.', $key);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));
            if (!empty($runners)) {
                $selection_id_1 = $runners['0']['selection_id'];
                $selection_id_2 = $runners['1']['selection_id'];
                $tmp_betting = array(
                    $selection_id_1 => array(
                        'profit' => 0,
                        'loss' => 0,

                    ),
                    $selection_id_2 => array(
                        'profit' => 0,
                        'loss' => 0,

                    ),
                );
            }

            if (!empty($all_bettings)) {

                // p($all_bettings);

                foreach ($all_bettings as $betting) {
                    if ($betting->market_id == $market_id) {
                        if (isset($tmp_betting[$betting->selection_id])) {
                            if ($betting->is_back == 1) {
                                $price = ($betting->price_val * $betting->stake * -1) + $betting->stake;
                                $tmp_betting[$betting->selection_id]['profit']   += round($betting->stake);
                                $tmp_betting[$betting->selection_id]['loss']   += round($price);
                            } else {
                                $price = ($betting->price_val * $betting->stake * -1) + $betting->stake;;

                                // p($betting->price_val,0);
                                // p($betting->stake,0);
                                // p($price,0);
                                // p($tmp_betting,0);

                                $tmp_betting[$betting->selection_id]['profit']   -= round($betting->stake);
                                $tmp_betting[$betting->selection_id]['loss']   -= round($price);

                                // p($tmp_betting);
                            }
                        } else {
                            if ($betting->is_back == 1) {
                                $price = $betting->price_val * $betting->stake * -1;
                                $tmp_betting[$betting->selection_id] = $price;
                            } else {
                                $price = $betting->price_val * $betting->stake * 1;
                                $tmp_betting[$betting->selection_id] = $price;
                            }
                        }
                    }
                }


                $selection_id_1 = $runners['0']['selection_id'];
                $selection_id_2 = $runners['1']['selection_id'];

                $total_exposure = array(
                    0 => 0,
                    1 => 0,

                );

                $i = 0;


                foreach ($tmp_betting as $key => $tmp_bett) {

                    // if ($i == 0) {
                    //     $total_exposure[0] += $tmp_bett['loss'] * -1;
                    //     $total_exposure[1] += $tmp_bett['profit'] * -1;
                    // } else {
                    //     $total_exposure[0] += $tmp_bett['profit'] * -1;
                    //     $total_exposure[1] += $tmp_bett['loss'] * -1;
                    // }

                    if ($i == 0) {
                        $total_exposure[0] += $tmp_bett['profit'] * 1;
                        $total_exposure[1] += $tmp_bett['loss'] * 1;
                    } else {
                        $total_exposure[0] += $tmp_bett['loss'] * 1;
                        $total_exposure[1] += $tmp_bett['profit'] * 1;
                    }
                    $i++;
                }
            }
        }
    }
    return $total_exposure;
}


function get_running_markets_super_masters()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $masters =  $CI->User_model->getInnerUserById($user_id);


    if (!empty($masters)) {
        $open_markets  = $CI->Betting_model->get_open_markets(array());

        $x = 0;
        if (!empty($open_markets)) {
            foreach ($open_markets as $openMarketskey => $open_market) {
                $all_bettings = array();


                if ($open_market->market_name != 'Match Odds') {
                    unset($open_markets[$openMarketskey]);
                    continue;
                }


                $market_id = $open_market->market_id;

                foreach ($masters as $master) {


                    $users =  $CI->User_model->getInnerUserById($master->user_id);

                    foreach ($users as $user) {
                        $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $open_market->market_id, 'betting_type' => 'Match'));
                        $all_bettings = array_merge($all_bettings, $bettings);
                    }
                }


                if (!empty($all_bettings)) {
                    $total_exposure = array();
                    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $selection_id = $runner['selection_id'];
                            $total_exposure[$selection_id] = 0;
                        }
                    }

                    foreach ($all_bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {
                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Master');

                            $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $partner_ship = $bettingSetting->partnership;



                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Super Master');

                            $superBettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $super_partner_ship = $superBettingSetting->partnership;



                            if ($betting->is_back == 1) {
                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);


                                $stake = $betting->stake * ($partner_ship / 100);
                                $super_stake = $betting->stake * ($super_partner_ship / 100);

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   -= ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   += ($super_stake - $stake);
                                }
                            } else {


                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);

                                $stake = $betting->stake * ($partner_ship / 100);

                                $super_stake = $betting->stake * ($super_partner_ship / 100);


                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   += ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   -= ($super_stake - $stake);
                                }
                            }
                        }
                    }
                    $exposure = $total_exposure;

                    $i = 0;
                    foreach ($total_exposure as $exposure) {
                        $i++;
                        $k = 'exposure_' . $i;
                        $open_markets[$openMarketskey]->$k = $exposure;
                    }
                }
            }
        }
    }


    return $open_markets;
}

function get_running_markets_hyper_super_masters()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $super_masters =  $CI->User_model->getInnerUserById($user_id);


    if (!empty($super_masters)) {
        $open_markets  = $CI->Betting_model->get_open_markets(array());

        $x = 0;
        if (!empty($open_markets)) {
            foreach ($open_markets as $openMarketskey => $open_market) {
                $all_bettings = array();


                if ($open_market->market_name != 'Match Odds') {
                    unset($open_markets[$openMarketskey]);
                    continue;
                }


                $market_id = $open_market->market_id;


                foreach ($super_masters as $super_master) {
                    $masters =  $CI->User_model->getInnerUserById($super_master->user_id);

                    foreach ($masters as $master) {
                        $users =  $CI->User_model->getInnerUserById($master->user_id);

                        foreach ($users as $user) {
                            $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $open_market->market_id, 'betting_type' => 'Match'));
                            $all_bettings = array_merge($all_bettings, $bettings);
                        }
                    }
                }


                if (!empty($all_bettings)) {
                    $total_exposure = array();
                    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $selection_id = $runner['selection_id'];
                            $total_exposure[$selection_id] = 0;
                        }
                    }

                    foreach ($all_bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {
                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Super Master');

                            $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $partner_ship = $bettingSetting->partnership;



                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Hyper Super Master');

                            $superBettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $super_partner_ship = $superBettingSetting->partnership;



                            if ($betting->is_back == 1) {
                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);


                                $stake = $betting->stake * ($partner_ship / 100);
                                $super_stake = $betting->stake * ($super_partner_ship / 100);

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   -= ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   += ($super_stake - $stake);
                                }
                            } else {


                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);

                                $stake = $betting->stake * ($partner_ship / 100);

                                $super_stake = $betting->stake * ($super_partner_ship / 100);


                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   += ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   -= ($super_stake - $stake);
                                }
                            }
                        }
                    }
                    $exposure = $total_exposure;

                    $i = 0;
                    foreach ($total_exposure as $exposure) {
                        $i++;
                        $k = 'exposure_' . $i;
                        $open_markets[$openMarketskey]->$k = $exposure;
                    }
                }
            }
        }
    }


    return $open_markets;
}



function get_running_markets_admin()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $hyper_super_masters =  $CI->User_model->getInnerUserById($user_id);


    if (!empty($hyper_super_masters)) {
        $open_markets  = $CI->Betting_model->get_open_markets(array());

        $x = 0;
        if (!empty($open_markets)) {
            foreach ($open_markets as $openMarketskey => $open_market) {
                $all_bettings = array();


                if ($open_market->market_name != 'Match Odds') {
                    unset($open_markets[$openMarketskey]);
                    continue;
                }


                $market_id = $open_market->market_id;

                foreach ($hyper_super_masters as $hyper_super_master) {
                    $super_masters =  $CI->User_model->getInnerUserById($hyper_super_master->user_id);

                    foreach ($super_masters as $super_master) {
                        $masters =  $CI->User_model->getInnerUserById($super_master->user_id);

                        foreach ($masters as $master) {
                            $users =  $CI->User_model->getInnerUserById($master->user_id);

                            foreach ($users as $user) {
                                $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $open_market->market_id, 'betting_type' => 'Match'));
                                $all_bettings = array_merge($all_bettings, $bettings);
                            }
                        }
                    }
                }


                if (!empty($all_bettings)) {
                    $total_exposure = array();
                    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $selection_id = $runner['selection_id'];
                            $total_exposure[$selection_id] = 0;
                        }
                    }

                    foreach ($all_bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {
                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Hyper Super Master');

                            $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $partner_ship = $bettingSetting->partnership;



                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Admin');

                            $superBettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $super_partner_ship = $superBettingSetting->partnership;



                            if ($betting->is_back == 1) {
                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);


                                $stake = $betting->stake * ($partner_ship / 100);
                                $super_stake = $betting->stake * ($super_partner_ship / 100);

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   -= ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   += ($super_stake - $stake);
                                }
                            } else {


                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);

                                $stake = $betting->stake * ($partner_ship / 100);

                                $super_stake = $betting->stake * ($super_partner_ship / 100);


                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   += ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   -= ($super_stake - $stake);
                                }
                            }
                        }
                    }
                    $exposure = $total_exposure;

                    $i = 0;
                    foreach ($total_exposure as $exposure) {
                        $i++;
                        $k = 'exposure_' . $i;
                        $open_markets[$openMarketskey]->$k = $exposure;
                    }
                }
            }
        }
    }


    return $open_markets;
}






// function get_running_markets_super_admin()
// {
//     $CI = &get_instance();
//     $CI->load->model("Betting_model");
//     $CI->load->model("Event_model");
//     $CI->load->model("Masters_betting_settings_model");
//     $user_id = get_user_id();
//     $user =  $CI->User_model->getUserById($user_id);
//     $admin_masters =  $CI->User_model->getInnerUserById($user_id);


//     if (!empty($admin_masters)) {
//         $open_markets  = $CI->Betting_model->get_open_markets(array());

//         $x = 0;
//         if (!empty($open_markets)) {
//             foreach ($open_markets as $openMarketskey => $open_market) {
//                 $all_bettings = array();


//                 if ($open_market->market_name != 'Match Odds') {
//                     unset($open_markets[$openMarketskey]);
//                     continue;
//                 }


//                 $market_id = $open_market->market_id;
//                 foreach ($admin_masters as $admin_master) {
//                     $hyper_super_masters =  $CI->User_model->getInnerUserById($admin_master->user_id);
//                     foreach ($hyper_super_masters as $hyper_super_master) {
//                         $super_masters =  $CI->User_model->getInnerUserById($hyper_super_master->user_id);

//                         foreach ($super_masters as $super_master) {
//                             $masters =  $CI->User_model->getInnerUserById($super_master->user_id);

//                             foreach ($masters as $master) {
//                                 $users =  $CI->User_model->getInnerUserById($master->user_id);

//                                 foreach ($users as $user) {
//                                     $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $open_market->market_id, 'betting_type' => 'Match'));
//                                     $all_bettings = array_merge($all_bettings, $bettings);
//                                 }
//                             }
//                         }
//                     }
//                 }


//                 if (!empty($all_bettings)) {
//                     $total_exposure = array();
//                     $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



//                     if (!empty($runners)) {
//                         foreach ($runners as $runner) {
//                             $selection_id = $runner['selection_id'];
//                             $total_exposure[$selection_id] = 0;
//                         }
//                     }

//                     foreach ($all_bettings as $betting) {


//                         foreach ($total_exposure as $runnerKey => $exposure) {
//                             $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Admin');

//                             $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

//                             $partner_ship = $bettingSetting->partnership;



//                             $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Super Admin');

//                             $superBettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

//                             $super_partner_ship = $superBettingSetting->partnership;



//                             if ($betting->is_back == 1) {
//                                 $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

//                                 $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);


//                                 $stake = $betting->stake * ($partner_ship / 100);
//                                 $super_stake = $betting->stake * ($super_partner_ship / 100);

//                                 if ($betting->selection_id == $runnerKey) {
//                                     $total_exposure[$runnerKey]   -= ($super_price - $price);
//                                 } else {
//                                     $total_exposure[$runnerKey]   += ($super_stake - $stake);
//                                 }
//                             } else {


//                                 $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

//                                 $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);

//                                 $stake = $betting->stake * ($partner_ship / 100);

//                                 $super_stake = $betting->stake * ($super_partner_ship / 100);


//                                 if ($betting->selection_id == $runnerKey) {
//                                     $total_exposure[$runnerKey]   += ($super_price - $price);
//                                 } else {
//                                     $total_exposure[$runnerKey]   -= ($super_stake - $stake);
//                                 }
//                             }
//                         }
//                     }
//                     $exposure = $total_exposure;

//                     $i = 0;
//                     foreach ($total_exposure as $exposure) {
//                         $i++;
//                         $k = 'exposure_' . $i;
//                         $open_markets[$openMarketskey]->$k = $exposure;
//                     }
//                 }
//             }
//         }
//     }


//     return $open_markets;
// }

function get_running_markets_super_admin()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $admin_masters =  $CI->User_model->getInnerUserById($user_id);


    if (!empty($admin_masters)) {
        $open_markets  = $CI->Betting_model->get_open_markets(array());

        $x = 0;
        if (!empty($open_markets)) {
            foreach ($open_markets as $openMarketskey => $open_market) {
                $all_bettings = array();


                if ($open_market->market_name != 'Match Odds') {
                    unset($open_markets[$openMarketskey]);
                    continue;
                }


                $market_id = $open_market->market_id;
                // foreach ($admin_masters as $admin_master) {
                //     $hyper_super_masters =  $CI->User_model->getInnerUserById($admin_master->user_id);
                //     foreach ($hyper_super_masters as $hyper_super_master) {
                //         $super_masters =  $CI->User_model->getInnerUserById($hyper_super_master->user_id);

                //         foreach ($super_masters as $super_master) {
                //             $masters =  $CI->User_model->getInnerUserById($super_master->user_id);

                //             foreach ($masters as $master) {
                //                 $users =  $CI->User_model->getInnerUserById($master->user_id);

                //                 foreach ($users as $user) {
                $bettings = $CI->Betting_model->get_bettings_by_market_id(array('market_id' => $open_market->market_id, 'betting_type' => 'Match', 'status' => 'Open'));

                $all_bettings = array_merge($all_bettings, $bettings);
                //                 }
                //             }
                //         }
                //     }
                // }


                if (!empty($all_bettings)) {
                    $total_exposure = array();
                    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));



                    if (!empty($runners)) {
                        foreach ($runners as $runner) {
                            $selection_id = $runner['selection_id'];
                            $total_exposure[$selection_id] = 0;
                        }
                    }

                    foreach ($all_bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {
                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Admin');

                            $bettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $partner_ship = $bettingSetting->partnership;



                            $getSettingData = array('betting_id' => $betting->betting_id, 'user_type' => 'Super Admin');


                            $superBettingSetting = $CI->Masters_betting_settings_model->get_betting_setting($getSettingData);

                            $super_partner_ship = $superBettingSetting->partnership;



                            if ($betting->is_back == 1) {
                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);


                                $stake = $betting->stake * ($partner_ship / 100);
                                $super_stake = $betting->stake * ($super_partner_ship / 100);

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   -= ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   += ($super_stake - $stake);
                                }
                            } else {


                                $price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($partner_ship / 100);

                                $super_price = (($betting->price_val * $betting->stake * 1) - $betting->stake) * ($super_partner_ship / 100);

                                $stake = $betting->stake * ($partner_ship / 100);

                                $super_stake = $betting->stake * ($super_partner_ship / 100);


                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey]   += ($super_price - $price);
                                } else {
                                    $total_exposure[$runnerKey]   -= ($super_stake - $stake);
                                }
                            }
                        }
                    }
                    $exposure = $total_exposure;

                    $i = 0;
                    foreach ($total_exposure as $exposure) {
                        $i++;
                        $k = 'exposure_' . $i;
                        $open_markets[$openMarketskey]->$k = $exposure;
                    }
                }
            }
        }
    }


    return $open_markets;
}




function get_news()
{
    $CI = &get_instance();
    $CI->load->model("News_model");

    $news = $CI->News_model->get_latest_news();

    $html = '';
    if (!empty($news)) {
        foreach ($news as $value) {
            $html .= '<Marquee>' . $value['description'] . '</Marquee>';
        }
    }
    echo $html;
}


function get_master_market_exposure_by_marketid($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();


    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;




    $users =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($users)) {
        foreach ($users as $user) {

            // echo $user->user_id;
            $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

            if (!empty($bettings)) {
                $all_bettings = array_merge($all_bettings, $bettings);
                $exposure = count_market_exposure2($bettings);


                if (!empty($exposure)) {
                    foreach ($exposure as $key => $exp) {
                        $exposure_1 =  $exp * ($partner_ship / 100);

                        if (isset($tmpExposure[$key])) {
                            $tmpExposure[$key] +=  ($exposure_1);
                        } else {
                            $tmpExposure[$key] =  ($exposure_1);
                        }
                    }
                }
            }
        }
    }
    return $tmpExposure;
}


function get_super_master_market_exposure_by_marketid($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();


    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;

    $masters =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($masters)) {

        foreach ($masters as $master) {
            $master_partnership  = $master->partnership;



            $users =  $CI->User_model->getInnerUserById($master->user_id);

            if (!empty($users)) {
                foreach ($users as $user) {

                    // echo $user->user_id;
                    $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

                    if (!empty($bettings)) {
                        $all_bettings = array_merge($all_bettings, $bettings);
                        $exposure = count_market_exposure2($bettings);
                        if (!empty($exposure)) {
                            foreach ($exposure as $key => $exp) {

                                $master_partnership_exposure_1 = $exp * ($master_partnership / 100);

                                $exposure_1 =  $exp * ($partner_ship / 100);

                                if (isset($tmpExposure[$key])) {
                                    $tmpExposure[$key] +=  ($exposure_1 - $master_partnership_exposure_1);
                                } else {
                                    $tmpExposure[$key] =  ($exposure_1 - $master_partnership_exposure_1);
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    return $tmpExposure;
}


function get_hyper_super_master_market_exposure_by_marketid($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();


    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;

    $superMasters =  $CI->User_model->getInnerUserById($user_id);



    if (!empty($superMasters)) {
        foreach ($superMasters as $superMaster) {
            $master_partnership  = $superMaster->partnership;

            $masters =  $CI->User_model->getInnerUserById($superMaster->user_id);

            if (!empty($masters)) {

                foreach ($masters as $master) {

                    $users =  $CI->User_model->getInnerUserById($master->user_id);

                    if (!empty($users)) {
                        foreach ($users as $user) {

                            // echo $user->user_id;
                            $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

                            if (!empty($bettings)) {
                                $all_bettings = array_merge($all_bettings, $bettings);
                                $exposure = count_market_exposure2($bettings);
                                if (!empty($exposure)) {
                                    foreach ($exposure as $key => $exp) {

                                        $master_partnership_exposure_1 = $exp * ($master_partnership / 100);

                                        $exposure_1 =  $exp * ($partner_ship / 100);

                                        if (isset($tmpExposure[$key])) {
                                            $tmpExposure[$key] +=  ($exposure_1 - $master_partnership_exposure_1);
                                        } else {
                                            $tmpExposure[$key] =  ($exposure_1 - $master_partnership_exposure_1);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $tmpExposure;
}



function get_admin_market_exposure_by_marketid($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();


    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;

    $hyperSuperMasterUsers =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($hyperSuperMasterUsers)) {
        foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
            $superMasters =  $CI->User_model->getInnerUserById($hyperSuperMasterUser->user_id);
            $master_partnership  = $hyperSuperMasterUser->partnership;

            if (!empty($superMasters)) {
                foreach ($superMasters as $superMaster) {
                    $masters =  $CI->User_model->getInnerUserById($superMaster->user_id);

                    if (!empty($masters)) {

                        foreach ($masters as $master) {

                            $users =  $CI->User_model->getInnerUserById($master->user_id);

                            if (!empty($users)) {
                                foreach ($users as $user) {

                                    // echo $user->user_id;
                                    $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

                                    if (!empty($bettings)) {
                                        $all_bettings = array_merge($all_bettings, $bettings);
                                        $exposure = count_market_exposure2($bettings);
                                        if (!empty($exposure)) {
                                            foreach ($exposure as $key => $exp) {

                                                $master_partnership_exposure_1 = $exp * ($master_partnership / 100);

                                                $exposure_1 =  $exp * ($partner_ship / 100);

                                                if (isset($tmpExposure[$key])) {
                                                    $tmpExposure[$key] +=  ($exposure_1 - $master_partnership_exposure_1);
                                                } else {
                                                    $tmpExposure[$key] =  ($exposure_1 - $master_partnership_exposure_1);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $tmpExposure;
}



function get_super_admin_market_exposure_by_marketid($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();

    $user_id = get_user_id();
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;

    $adminUsers =  $CI->User_model->getInnerUserById($user_id);

    if (!empty($adminUsers)) {
        foreach ($adminUsers as $adminUser) {
            $master_partnership  = $adminUser->partnership;
            $hyperSuperMasterUsers =  $CI->User_model->getInnerUserById($adminUser->user_id);

            if (!empty($hyperSuperMasterUsers)) {
                foreach ($hyperSuperMasterUsers as $hyperSuperMasterUser) {
                    $superMasters =  $CI->User_model->getInnerUserById($hyperSuperMasterUser->user_id);

                    if (!empty($superMasters)) {
                        foreach ($superMasters as $superMaster) {
                            $masters =  $CI->User_model->getInnerUserById($superMaster->user_id);

                            if (!empty($masters)) {

                                foreach ($masters as $master) {

                                    $users =  $CI->User_model->getInnerUserById($master->user_id);

                                    if (!empty($users)) {
                                        foreach ($users as $user) {

                                            // echo $user->user_id;
                                            $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user->user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

                                            if (!empty($bettings)) {
                                                $all_bettings = array_merge($all_bettings, $bettings);
                                                $exposure = count_market_exposure2($bettings);
                                                if (!empty($exposure)) {
                                                    foreach ($exposure as $key => $exp) {

                                                        $master_partnership_exposure_1 = $exp * ($master_partnership / 100);

                                                        $exposure_1 =  $exp * ($partner_ship / 100);

                                                        if (isset($tmpExposure[$key])) {
                                                            $tmpExposure[$key] +=  ($exposure_1 - $master_partnership_exposure_1);
                                                        } else {
                                                            $tmpExposure[$key] =  ($exposure_1 - $master_partnership_exposure_1);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    return $tmpExposure;
}

function count_market_exposure2($all_bettings)
{

    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '_', $betting->market_id);

            $markets[$market_id] = array();
        }
    }


    if (!empty($markets)) {
        foreach ($markets as $key =>  $market) {
            $market_id = str_replace('_', '.', $key);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));
            if (!empty($runners)) {
                foreach ($runners as $runner) {

                    $selection_id = $runner['selection_id'];
                    $total_exposure[$selection_id] = 0;
                }
            }

            if (!empty($all_bettings)) {


                foreach ($all_bettings as $betting) {


                    foreach ($total_exposure as $runnerKey => $exposure) {

                        if ($betting->is_back == 1) {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   -= round($price);
                            } else {
                                $total_exposure[$runnerKey]   += round($betting->stake);
                            }
                        } else {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;

                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   += round($price);
                            } else {
                                $total_exposure[$runnerKey]   -= round($betting->stake);
                            }
                        }
                    }
                }
            }
        }
    }




    return $total_exposure;
}


function get_user_market_exposure_by_marketid($market_id = null, $user_id = null)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $return = "";
    $matches = array();
    $all_bettings = array();
    // $exposure = array();
    $tmpExposure = array();


    if (!$user_id) {
        $user_id = get_user_id();
    }
    $user =  $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;



    // echo $user->user_id;
    $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user_id, 'market_id' => $market_id, 'betting_type' => 'Match'));

    if (!empty($bettings)) {
        $all_bettings = array_merge($all_bettings, $bettings);
        $exposure = count_market_exposure_for_user($bettings);

        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 =  $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] +=  ($exposure_1);
                } else {
                    $tmpExposure[$key] =  ($exposure_1);
                }
            }
        }
    }


    return $tmpExposure;
}

function count_market_exposure_for_user($all_bettings)
{

    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '_', $betting->market_id);

            $markets[$market_id] = array();
        }
    }


    if (!empty($markets)) {
        foreach ($markets as $key =>  $market) {
            $market_id = str_replace('_', '.', $key);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));

            if (!empty($runners)) {

                foreach ($runners as $runner) {

                    $selection_id = $runner['selection_id'];
                    $total_exposure[$selection_id] = 0;
                }
            }




            if (!empty($all_bettings)) {
                foreach ($all_bettings as $betting) {

                    foreach ($total_exposure as $runnerKey => $exposure) {

                        if ($betting->is_back == 1) {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   += round($price);
                            } else {
                                $total_exposure[$runnerKey]   -= round($betting->stake);
                            }
                        } else {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;

                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   -= round($price);
                            } else {
                                $total_exposure[$runnerKey]   += round($betting->stake);
                            }
                        }
                    }
                }
            }
        }
    }



    return $total_exposure;
}


function get_user_general_setting($user_id)
{
    $CI = &get_instance();
    $CI->load->model("View_info_model");
    $return = "";
    if (!empty($user_id)) {
        $setting = $CI->View_info_model->getViewInfoByUserId($user_id);
    }

    return $setting;
}

function date_compare($a, $b)
{
    $t1 = strtotime($a['created_at']);
    $t2 = strtotime($b['created_at']);
    return $t1 - $t2;
}



function listEventTypesBetfair()
{
    $api_key = getCustomConfigItem('api_key');
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.appery.io/rest/1/apiexpress/api/betfair/?apiKey=" . $api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}


function listMarketRunners($market_id = null)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://142.93.36.1/api/v1/fetch_data?Action=listMarketRunner&MarketID=" . $market_id,

        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    // $response = '[{"marketId":"1.173378424","marketName":"Match Odds","marketStartTime":"2020-09-29T14:00:00.000Z","totalMatched":184.491,"runners":[{"selectionId":22121561,"runnerName":"Delhi Capitals","handicap":0,"sortPriority":1},{"selectionId":7671296,"runnerName":"Sunrisers Hyderabad","handicap":0,"sortPriority":2}]}]';
    curl_close($curl);


    return $response;
}


function getSuperAdminID()
{
    $CI = &get_instance();
    $CI->load->model("User_model");
    $return = "";
    $result = $CI->User_model->getSuperAdmin();
    return $result->user_id;
}


function get_ws_endpoint()
{
    // return 'http://localhost:3000/';

    return 'http://365exchange.vip:3000/';
}


function get_superior_arr($user_id, $user_type)
{
    $superrior_arr = array();
    $CI = &get_instance();
    $CI->load->model("User_model");


    if ($user_type == 'User') {
        $user = $CI->User_model->getUserById($user_id);
        $master_id = $user->master_id;
        $superrior_arr[] = $master_id;


        if (!empty($master_id)) {
            $master = $CI->User_model->getUserById($master_id);
            $smaster_id = $master->master_id;
            $superrior_arr[] = $smaster_id;

            if (!empty($smaster_id)) {
                $smaster = $CI->User_model->getUserById($smaster_id);
                $hmaster_id = $smaster->master_id;
                $superrior_arr[] = $hmaster_id;

                if (!empty($hmaster_id)) {
                    $hmaster = $CI->User_model->getUserById($hmaster_id);
                    $admin_id = $hmaster->master_id;
                    $superrior_arr[] = $admin_id;

                    if (!empty($admin_id)) {
                        $admin = $CI->User_model->getUserById($admin_id);
                        $sadmin_id = $admin->master_id;
                        $superrior_arr[] = $sadmin_id;
                    }
                }
            }
        }
    } else  if ($user_type == 'Master') {

        $master = $CI->User_model->getUserById($user_id);
        $smaster_id = $master->master_id;
        $superrior_arr[] = $smaster_id;

        if (!empty($smaster_id)) {
            $smaster = $CI->User_model->getUserById($smaster_id);
            $hmaster_id = $smaster->master_id;
            $superrior_arr[] = $hmaster_id;

            if (!empty($hmaster_id)) {
                $hmaster = $CI->User_model->getUserById($hmaster_id);
                $admin_id = $hmaster->master_id;
                $superrior_arr[] = $admin_id;

                if (!empty($admin_id)) {
                    $admin = $CI->User_model->getUserById($admin_id);
                    $sadmin_id = $admin->master_id;
                    $superrior_arr[] = $sadmin_id;
                }
            }
        }
    } else  if ($user_type == 'Super Master') {


        $smaster = $CI->User_model->getUserById($user_id);
        $hmaster_id = $smaster->master_id;
        $superrior_arr[] = $hmaster_id;

        if (!empty($hmaster_id)) {
            $hmaster = $CI->User_model->getUserById($hmaster_id);
            $admin_id = $hmaster->master_id;
            $superrior_arr[] = $admin_id;

            if (!empty($admin_id)) {
                $admin = $CI->User_model->getUserById($admin_id);
                $sadmin_id = $admin->master_id;
                $superrior_arr[] = $sadmin_id;
            }
        }
    } else  if ($user_type == 'Hyper Super Master') {



        $hmaster = $CI->User_model->getUserById($user_id);
        $admin_id = $hmaster->master_id;
        $superrior_arr[] = $admin_id;

        if (!empty($admin_id)) {
            $admin = $CI->User_model->getUserById($admin_id);
            $sadmin_id = $admin->master_id;
            $superrior_arr[] = $sadmin_id;
        }
    } else  if ($user_type == 'Admin') {
        $admin = $CI->User_model->getUserById($user_id);
        $sadmin_id = $admin->master_id;
        $superrior_arr[] = $sadmin_id;
    }

    return $superrior_arr;
}

function total_bets_cmp($a,  $b)
{
    if ($a->total_bets < $b->total_bets) {
        return 1;
    } else if ($a->total_bets > $b->total_bets) {
        return -1;
    } else {
        return 0;
    }
}


function count_total_credit_limit($user_id)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");
    $return = "";
    if (!empty($user_id)) {
        $balance = $CI->Ledger_model->count_total_credit_limit($user_id);
    }

    // p($balance);


    return isset($balance) ? $balance : 0;
}


// function count_total_winnings($user_id)
// {
//     $CI = &get_instance();
//     $CI->load->model("Ledger_model");
//     $return = "";
//     if (!empty($user_id)) {
//         $balance = $CI->Ledger_model->count_total_winnings($user_id);
//     }

//     // p($balance);


//     return isset($balance) ? $balance : 0;
// }

function count_total_winnings($user_id)
{
    $CI = &get_instance();

    $CI->load->model("Betting_model");

    $user_data = $CI->User_model->getUserById($user_id);

    if (!empty($user_data)) {
        $user_type = isset($user_data->user_type) ? $user_data->user_type : '';

        if ($user_type == 'User') {
            $CI = &get_instance();
            $return = "";
            if (!empty($user_id)) {
                $balance = $CI->Betting_model->count_total_winnings($user_id);
            }

            return isset($balance) ? $balance : 0;
        } else {
            return 0;
        }
    }
}

function getCasinoData($type)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://128.199.232.246:3000/v1-api/demo/getCasino/" . $type,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}

function getCasinoResultData($type)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://128.199.232.246:3000/v1-api/demo/getCasinoResult/" . $type,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=d5dbee86719a0b4f706c9bb85dfb833851599671724"
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}