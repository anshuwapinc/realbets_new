<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function getchannel($dataValues = array())
{
    $curl = curl_init();

    // p("http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id);
    curl_setopt_array($curl, array(
        // CURLOPT_URL => "http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id,
        CURLOPT_URL => "http://139.59.41.232/9e79154e7f6aa8160b6c77944135e8ca/streaminfo.php",

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
    return json_decode($response, true);
}

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
        $obj = (array)$obj;
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


function GetLoggedinUserData()
{
    $CI = &get_instance();
    //$userdata = (array) $CI->session->userdata;
    if (!empty($CI->session->userdata['my_userdata'])) {
        $userdata = (array)$CI->session->userdata["my_userdata"];
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
        $userdata = (array)$CI->session->userdata["my_associationdata"];
    } else {
        $userdata = array();
    }

    return $userdata;
}


function getsessionid()
{
    $sessionid = PHPSESSID;  //$CI->session->userdata('sessionid');
    return $sessionid;
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


function floatnumber($number)
{
    $result = number_format((float)$number, 2, '.', '');
    return $result;
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
        $userdata = (array)$CI->session->userdata["sponsor_data"];
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
    $return = str_replace("_", " ", urldecode($association_name));
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
        $userdata = (array)$CI->session->userdata["my_userdata"];
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
    echo $result . "Rupees  " . (empty($points) ? " Zero" : $points) . " Paise Only";
}

function get_quotation_number()
{
    $CI = &get_instance();
    $CI->load->model("Order_model");
    $sessionDetails = $CI->Order_model->get_session();

    $quotation_no = "";

    $currentDate = date('Y-m-d');


    if (!empty($sessionDetails)) {
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
    $InitializationVector = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));
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
    $valid = TRUE;
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
            $valid = FALSE;
            $arr_errors[] = "Missing Name for row no " . $row;
        }

        if ($contact_no == "") {
            $valid = FALSE;
            $arr_errors[] = "Missing Contact No. for row no " . $row;
        }

        if ($whatsapp_no == "") {
            $valid = FALSE;
            $arr_errors[] = "Missing Whatsapp No. for row no " . $row;
        }

        if ($address == "") {
            $valid = FALSE;
            $arr_errors[] = "Missing Address for row no " . $row;
        }

        if ($username == "") {
            $valid = FALSE;
            $arr_errors[] = "Missing Username for row no " . $row;
        }

        if ($password == "") {
            $valid = FALSE;
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
    return  isset($_SESSION['my_userdata']['user_name']) ? $_SESSION['my_userdata']['user_name'] : "";
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
    $manual_events = $CI->Betting_model->get_manual_bettings_markets($user_id);
    $events = array_merge($events, $manual_events);


    $totalRiskAmt = 0;
    if (!empty($events)) {
        foreach ($events as $key => $event) {
            $exposures = get_user_market_exposure_by_marketid($event->market_id, $user_id);



            //    p($exposures);
            $totalRiskAmt +=  min($exposures) < 0 ? min($exposures) : 0;
        }
    }



    $unmatch_exposure = $CI->Betting_model->count_total_unmatch_exposure($user_id);


    if (!empty($unmatch_exposure)) {
        $totalRiskAmt += $unmatch_exposure->total_exposure;
    }

    /**********************Markets******************** */

    /**********************Fancy********************** */
    // p($totalRiskAmt);

    $bettingsData = $CI->Betting_model->get_fancy_group_list(array('user_id' => $user_id));

    // p($bettingsData);
    if (!empty($bettingsData)) {
        foreach ($bettingsData as $bettingData) {

            if ($bettingData['betting_type'] == 'Fancy') {
                $fancy_id = $bettingData['selection_id'];
                $dataArray = array(
                    'selection_id' => $fancy_id,
                    'user_id' => $user_id,
                    'match_id' => $bettingData['match_id'],
                    'status' => 'Open'
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

                $totalRiskAmt +=  min($tmp_array) < 0 ? min($tmp_array) : 0;
            }
        }
    }

    // p($totalRiskAmt);
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
    $url = get_ws_endpoint() . '/fancyupdate';
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


function betting_ledger_maintain($user_id = null, $transaction_type = null, $amt = null, $partner_ship = null, $remarks = null, $user_type, $betting_id = null, $selection_id = null, $is_commission = 'No')
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


    if ($transaction_type == 'Credit') {
        $dataArray = array(
            'user_id' => $user_id,
            'remarks' => $remarks,
            'transaction_type' => $transaction_type,
            'amount' => $entry_amt,
            'balance' => count_total_balance_without_exposure($user_id) + $entry_amt,
            'type' => 'Betting',
            'betting_id' => $betting_id,
            'selection_id' => $selection_id,
            'is_commission' => $is_commission
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
            'selection_id' => $selection_id,
            'is_commission' => $is_commission
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
    $CI->load->model("Masters_betting_settings_model");
    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $bettings = $CI->Masters_betting_settings_model->get_event_open_bettings_list(array(
        'user_id' => $user_id,
        'match_id' => $match_id
    ));
    return $bettings;
}

function get_commission($master_id, $user_type)
{

    $CI = &get_instance();
    $CI->load->model("Report_model");
    $data = $CI->Report_model->get_commission($master_id, $user_type);
    return $data;
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

function get_admin_betting_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");

    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $totalBets = array();

    $hyper_super_users = $CI->User_model->getInnerUserById($user_id);

    if (!empty($hyper_super_users)) {
        foreach ($hyper_super_users as $hyper_super_user) {

            $super_master_users = $CI->User_model->getInnerUserById($hyper_super_user->user_id);

            if (!empty($super_master_users)) {
                foreach ($super_master_users as $super_master_user) {
                    $masterusers = $CI->User_model->getInnerUserById($super_master_user->user_id);

                    if (!empty($masterusers)) {
                        foreach ($masterusers as $masteruser) {

                            $users = $CI->User_model->getInnerUserById($masteruser->user_id);

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
    return isset($_SESSION['my_userdata']['user_type']) ? $_SESSION['my_userdata']['user_type'] : "";
}

function get_user_type_by_id($user_id)
{
    $CI = &get_instance();
    $CI->load->model("User_model");
    $data = $CI->User_model->getUserById($user_id);
    return $data->user_type;
}

function get_master_id()
{
    return isset($_SESSION['my_userdata']['master_id']) ? $_SESSION['my_userdata']['master_id'] : "";
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

    $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);


    $adminuser = $CI->User_model->getUserById($master_id);
    if (!empty($adminuser)) {
        $master_id = $adminuser->master_id;
        $super_admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $super_admin_block_markets);
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

    $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);

    $hmaster_user = $CI->User_model->getUserById($hyper_master_id);

    if (!empty($hmaster_user)) {
        $hmaster_master_id = $hmaster_user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $hmaster_master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);

        $super_admin_user = $CI->User_model->getUserById($hmaster_master_id);

        if (!empty($super_admin_user)) {
            $hmaster_master_id = $super_admin_user->master_id;
            $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $hmaster_master_id, 'type' => $type));
            $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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
    $tmpBlockMarket = array_merge($tmpBlockMarket, $block_markets);
    /**********Super Master */

    /**********Hyper Super Master */
    $user = $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Super Master */

    /**********Admin Master */
    $user = $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user = $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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
    $tmpBlockMarket = array_merge($tmpBlockMarket, $block_markets);
    /********** Master */


    /********** Super Master */
    $user = $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Master */


    /**********Hyper Super Master */
    $user = $CI->User_model->getUserById($master_id);
    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Super Master */

    /**********Admin Master */
    $user = $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user = $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $master_id = $user->master_id;
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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
    $user = $CI->User_model->getUserById($user_id);

    if (!empty($user)) {
        $master_id = $user->master_id;

        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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

    $user = $CI->User_model->getUserById($user_id);
    $master_id = $user->master_id;

    /**********Admin Master */
    $user = $CI->User_model->getUserById($master_id);


    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
        $master_id = $user->master_id;
    }
    /**********Admin Master */


    /**********Super Admin Master */
    $user = $CI->User_model->getUserById($master_id);
    // $master_id = $user->master_id;


    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));

        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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

    $user = $CI->User_model->getUserById($user_id);
    $master_id = $user->master_id;

    /**********Hyper Master */
    $user = $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Hyper Master */

    /**********Admin Master */
    $user = $CI->User_model->getUserById($master_id);
    $master_id = $user->master_id;
    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Admin Master */

    /**********Super Admin Master */
    $user = $CI->User_model->getUserById($master_id);

    if (!empty($user)) {
        $admin_block_markets = $CI->Block_market_model->getBlockMarketsByUserId(array('user_id' => $master_id, 'type' => $type));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
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
    $user = $CI->User_model->getUserById($user_id);

    $open_markets = $CI->Betting_model->get_open_markets_new(array('user_id' => $user_id));




    // $manual_open_markets = $CI->Betting_model->get_manual_open_markets(array());

    // $open_markets = array_merge($open_markets, $manual_open_markets);


    // p($open_markets);
    $x = 0;

    if (!empty($open_markets)) {
        foreach ($open_markets as $openMarketskey => $open_market) {


            if ($open_market->event_type == 7) {
                continue;
                // $all_bettings = array();
                // $market_id = $open_market->market_id;
                // $CI->load->model("Masters_betting_settings_model");

                // $total_exposure = array();


                // $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));

                // $manual_runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));

                // $runners = array_merge($runners, $manual_runners);


                // if (!empty($runners)) {
                //     foreach ($runners as $runner) {
                //         $selection_id = $runner['selection_id'];
                //         $total_exposure[$selection_id] = 0;
                //     }
                // }


                // if (get_user_type() == 'User') {
                //     if (!empty($bettings)) {
                //         $newexposure = get_user_market_exposure_by_marketid($market_id);
                //     }
                // } else {
                //     $newexposure = get_master_market_exposure_by_marketid($market_id);
                // }
                // $total_exposure = $newexposure;

                // $i = 0;


                // foreach ($total_exposure as $exposure) {
                //     $i++;
                //     $k = 'exposure_' . $i;
                //     $open_markets[$openMarketskey]->exposure[] = $exposure;
                // }
            } else {
                $all_bettings = array();
                $market_id = $open_market->market_id;
                $CI->load->model("Masters_betting_settings_model");




                // $total_exposure = array();


                // $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));

                // $manual_runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));

                // $runners = array_merge($runners, $manual_runners);


                // if (!empty($runners)) {
                //     foreach ($runners as $runner) {
                //         $selection_id = $runner['selection_id'];
                //         $total_exposure[$selection_id] = 0;
                //     }
                // }


                // if (get_user_type() == 'User') {
                //     if (!empty($bettings)) {
                //         $newexposure = get_user_market_exposure_by_marketid($market_id);
                //     }
                // } else {
                //     $newexposure = get_master_market_exposure_by_marketid($market_id);
                // }
                // $total_exposure = $newexposure;

                $i = 0;

                $total_exposure_new = get_redis_market_exposure(array(
                    'user_id' => $user_id,
                    'match_id' => $open_market->match_id,
                    'market_id' => $open_market->market_id,

                ));

                // p($total_exposure_new,0);

                // p($total_exposure);

                // foreach ($total_exposure as $exposure) {
                //     $i++;
                //     $k = 'exposure_' . $i;
                //     $open_markets[$openMarketskey]->exposure[] = $exposure;
                // }


                foreach ($total_exposure_new as $exposure) {
                    $i++;
                    $k = 'exposure_' . $i;
                    $open_markets[$openMarketskey]->exposure[] = $exposure['exposure'];
                }
            }
        }
    }


    return $open_markets;
}

function get_running_markets_user()
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("Event_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = get_user_id();
    $user = $CI->User_model->getUserById($user_id);
    $open_markets = $CI->Betting_model->get_open_markets(array());
    $x = 0;

    if (!empty($open_markets)) {
        foreach ($open_markets as $openMarketskey => $open_market) {
            $all_bettings = array();
            $market_id = $open_market->market_id;
            $CI->load->model("Masters_betting_settings_model");


            $bettings = $CI->Masters_betting_settings_model->get_open_bettings_list(array(
                'market_id' => $open_market->market_id,
                'user_id' => $user_id,
                'match_id' => $open_market->match_id
            ));

            if (!empty($bettings)) {
                $total_exposure = array();
                $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));

                if (!empty($runners)) {
                    foreach ($runners as $runner) {
                        $selection_id = $runner['selection_id'];
                        $total_exposure[$selection_id] = 0;
                    }
                }


                if (!empty($bettings)) {
                    foreach ($bettings as $betting) {


                        foreach ($total_exposure as $runnerKey => $exposure) {

                            if ($betting->is_back == 1) {
                                $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;


                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey] += ($price);
                                } else {
                                    $total_exposure[$runnerKey] -= ($betting->stake);
                                }
                            } else {
                                $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;

                                if ($betting->selection_id == $runnerKey) {
                                    $total_exposure[$runnerKey] -= ($price);
                                } else {
                                    $total_exposure[$runnerKey] += ($betting->stake);
                                }
                            }
                        }
                    }
                }
                $exposure = $total_exposure;


                $i = 0;
                foreach ($total_exposure as $exposure) {
                    $i++;
                    $k = 'exposure_' . $i;
                    $open_markets[$openMarketskey]->exposure[] = $exposure;
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
        foreach ($markets as $key => $market) {
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
                                $tmp_betting[$betting->selection_id]['profit'] += ($betting->stake);
                                $tmp_betting[$betting->selection_id]['loss'] += ($price);
                            } else {
                                $price = ($betting->price_val * $betting->stake * -1) + $betting->stake;;
                                $tmp_betting[$betting->selection_id]['profit'] -= ($betting->stake);
                                $tmp_betting[$betting->selection_id]['loss'] -= ($price);
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


function get_news()
{
    $CI = &get_instance();
    $CI->load->model("News_model");

    $site_code = getCustomConfigItem('site_code');

    $news = $CI->News_model->get_latest_news($site_code);

    $html = ' ';
    if (!empty($news)) {
        foreach ($news as $value) {
            $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $value['description'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
    }

    echo '<marquee direction="left" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">' . $html . '</Marquee>';
}


function get_master_market_exposure_by_marketid($market_id = null, $user_id = null, $unmatch_bet_include = 'No')
{
    $CI = &get_instance();
    $CI->load->model("Masters_betting_settings_model");

    if (!$user_id) {
        $user_id = get_user_id();
    }

    $bettings = $CI->Masters_betting_settings_model->get_open_bettings_list(array(
        'market_id' => $market_id,
        'user_id' => $user_id
    ));


    // p($bettings);

    $tmpExposure = array();
    // p($bettings);
    if (!empty($bettings)) {
        $exposure = count_market_exposure2($bettings, $unmatch_bet_include);
        // p($exposure);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }

    return $tmpExposure;
}


function count_market_exposure2($all_bettings, $unmatch_bet_include = 'No')
{

    $CI = &get_instance();
    $CI->load->model("Event_model");

    $markets = array();
    // p(get_user_name());

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            // $market_id = str_replace('.', '_', $betting->market_id);
            $market_id = str_replace('.', '___', $betting->market_id);
            $markets[$market_id] = array();
        }
    }


    // p($markets);
    if (!empty($markets)) {
        foreach ($markets as $key => $market) {
            // $market_id = str_replace('_', '.', $key);
            $market_id = str_replace('___', '.', $key);
            // $market_id = str_replace('.BM', '_BM', $market_id);
            // p($market_id,0);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));


            $manual_runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));

            $runners = array_merge($runners, $manual_runners);


            if (!empty($runners)) {
                foreach ($runners as $runner) {

                    $selection_id = $runner['selection_id'];
                    $total_exposure[$selection_id] = 0;
                }
            }

            if (!empty($all_bettings)) {


                foreach ($all_bettings as $betting) {

                    if ($unmatch_bet_include == 'No') {
                        if ($betting->unmatch_bet == 'Yes') {
                            continue;
                        }
                    }
                    foreach ($total_exposure as $runnerKey => $exposure) {

                        if ($betting->is_back == 1) {
                            $profit = $betting->loss;
                            $loss = $betting->profit;


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] -= ($profit);
                            } else {
                                $total_exposure[$runnerKey] += ($loss);
                            }
                        } else {
                            $profit = $betting->loss;
                            $loss = $betting->profit;


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] += ($loss);
                            } else {
                                $total_exposure[$runnerKey] -= ($profit);
                            }
                        }

                        // p($total_exposure,0);
                    }
                }
            }
        }
    }



    // p($total_exposure);


    return $total_exposure;
}


function get_user_market_exposure_by_marketid($market_id = null, $user_id = null, $unmatch_bet_include = 'No')
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
    $user = $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;


    // echo $user->user_id;
    $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user_id, 'market_id' => $market_id, 'betting_type' => 'Match', 'status' => 'Open'));

    // p($bettings);
    if (!empty($bettings)) {
        $all_bettings = array_merge($all_bettings, $bettings);
        $exposure = count_market_exposure_for_user($bettings, $unmatch_bet_include);
        // p($exposure);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }


    return $tmpExposure;
}

function count_market_exposure_for_user($all_bettings, $unmatch_bet_include = 'No')
{



    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();


    // p("hello");
    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '___', $betting->market_id);

            $markets[$market_id] = array();
        }
    }



    // p("here");


    if (!empty($markets)) {
        foreach ($markets as $key =>  $market) {
            $market_id = str_replace('___', '.', $key);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));


            if (empty($runners)) {
                $runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));
            }
            // p($runners);

            if (!empty($runners)) {

                foreach ($runners as $runner) {

                    $selection_id = $runner['selection_id'];
                    $total_exposure[$selection_id] = 0;
                }
            }


            if ($_SESSION['my_userdata']['user_name'] == 'TA04') {

                // if($market_id == '9.220301184116_match_odds')
                // {

                // p($market_id);
                // }
            }


            if (!empty($all_bettings)) {
                foreach ($all_bettings as $betting) {

                    if ($unmatch_bet_include == 'No') {
                        if ($betting->unmatch_bet == 'Yes') {
                            continue;
                        }
                    }


                    foreach ($total_exposure as $runnerKey => $exposure) {

                        if ($betting->is_back == 1) {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   += ($price);
                            } else {
                                $total_exposure[$runnerKey]   -= ($betting->stake);
                            }
                        } else {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   -= ($price);
                            } else {
                                $total_exposure[$runnerKey]   += ($betting->stake);
                            }
                        }

                        // p($total_exposure,0);
                    }
                }
            }
        }
    }


    // p($total_exposure);

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
    $url = getCustomConfigItem('ws_endpoint');
    return $url;
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
    } else if ($user_type == 'Master') {

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
    } else if ($user_type == 'Super Master') {


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
    } else if ($user_type == 'Hyper Super Master') {


        $hmaster = $CI->User_model->getUserById($user_id);
        $admin_id = $hmaster->master_id;
        $superrior_arr[] = $admin_id;

        if (!empty($admin_id)) {
            $admin = $CI->User_model->getUserById($admin_id);
            $sadmin_id = $admin->master_id;
            $superrior_arr[] = $sadmin_id;
        }
    } else if ($user_type == 'Admin') {
        $admin = $CI->User_model->getUserById($user_id);
        $sadmin_id = $admin->master_id;
        $superrior_arr[] = $sadmin_id;
    }

    return $superrior_arr;
}

function getCasinoData($type)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://45.56.112.18:3000/getcards/" . $type,
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
        CURLOPT_URL => "http://45.56.112.18:3000/getcards/" . $type,
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


function total_bets_cmp($a, $b)
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
    $balance = "";
    if (!empty($user_id)) {
        $balance = $CI->Ledger_model->count_total_credit_limit($user_id);
    }
    return isset($balance) ? $balance : 0;
}


function count_total_winnings($user_id)
{

    $CI = &get_instance();

    $CI->load->model("Ledger_model");
    $balance = "";
    if (!empty($user_id)) {
        $ledger = $CI->Ledger_model->count_total_winnings($user_id);
    }
    return isset($balance) ? $balance : 0;
}


function get_super_admin_pre_block_markets($data)
{
    $CI = &get_instance();
    $CI->load->model("Block_market_model");
    $CI->load->model("User_model");

    $type = $data['type'];
    $tmpBlockMarket = array();

    $user_id = $data['user_id'];
    $event_id = $data['event_id'];


    /**********Super Admin Master */
    $user = $CI->User_model->getUserById($user_id);

    if (!empty($user)) {


        $admin_block_markets = $CI->Block_market_model->getSingleBlockMarketsByUserId(array('user_id' => $user_id, 'type' => $type, 'event_id' => $event_id));
        $tmpBlockMarket = array_merge($tmpBlockMarket, $admin_block_markets);
    }
    /**********Super Admin Master */

    return $tmpBlockMarket;
}

function listBookmakerMarket($EventID = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://46.101.9.108/api/v1/fetch_data?Action=listBookmakerMarket&EventID=" . $EventID,

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

function listBookmakerMarketOdds($market_id = null)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://46.101.9.108/api/v1/listBookmakerMarketOdds?market_id=" . $market_id,

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

function listBookmakerMarketRunner($market_id = null)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://46.101.9.108/api/v1/fetch_data?Action=listBookmakerMarketRunner&MarketID=" . $market_id,

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

function matchesList()
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://167.99.198.2/api/matches/list",

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


function matchScore($match_id)
{

    // p("http://marketsarket.in:3002/animurl/" . $match_id);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://marketsarket.in:3002/animurl/" . $match_id,

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


function check_password_change()
{
    $CI = &get_instance();
    $CI->load->model("User_model");

    $user_id = get_user_id();

    $user_detail = $CI->User_model->getUserById($user_id);

    if (isset($_SESSION['my_userdata'])) {
        $password = $user_detail->password;
        $old_password = $_SESSION['my_userdata']['password'];
        if ($password != $old_password) {
            $CI->session->unset_userdata('my_userdata');
            redirect('/');
        }
    }
}


function count_total_settling($user_id)
{
    $CI = &get_instance();

    $CI->load->model("Ledger_model");

    $user_data = $CI->User_model->getUserById($user_id);

    if (!empty($user_data)) {
        $user_type = isset($user_data->user_type) ? $user_data->user_type : '';

        if ($user_type == 'User') {
            $CI = &get_instance();
            $return = "";
            if (!empty($user_id)) {
                $balance = $CI->Ledger_model->count_total_settling($user_id);
            }

            return isset($balance) ? $balance : 0;
        } else {
            return 0;
        }
    }
}

function get_user_winnings($user_id)
{
    return count_total_winnings($user_id);
}

function get_user_credit_limit($user_id)
{
    return number_format(count_total_credit_limit($user_id), 2);
}

function get_user_exposure($user_id)
{

    $CI = &get_instance();

    $user = (array)$CI->User_model->getUserById($user_id);

    $dataArray['user_type'] = $user['user_type'];
    $dataArray['user'] = $user;
    $dataArray['total_exposure'] = count_total_exposure($user_id);

    $content = $CI->load->viewPartial('user-exposure-html', $dataArray, TRUE);

    return $content;
}

function get_user_balance($user_id)
{
    return number_format(count_total_balance($user_id), 2);
}

function get_view_more_option($user_id)
{
    $CI = &get_instance();

    $user = (array)$CI->User_model->getUserById($user_id);

    $dataArray['user_type'] = $user['user_type'];
    $dataArray['user'] = $user;


    $content = $CI->load->viewPartial('view-more-options', $dataArray, TRUE);

    return $content;
}


function get_user_partnership($partner_ship)
{
    return $partner_ship . '%';
}

function get_user_checkbox($user_id)
{
    $CI = &get_instance();

    $user = (array)$CI->User_model->getUserById($user_id);

    $dataArray['user_type'] = $user['user_type'];
    $dataArray['user'] = $user;


    $content = $CI->load->viewPartial('user-checkbox', $dataArray, TRUE);

    return $content;
}

function get_user_name_html($user_id)
{

    $CI = &get_instance();

    $user = (array)$CI->User_model->getUserById($user_id);

    $dataArray['user_type'] = $user['user_type'];
    $dataArray['user'] = $user;


    $content = $CI->load->viewPartial('user-username-html', $dataArray, TRUE);

    return $content;
}

function get_betting_check_box($betting_id)
{
    return '<input type="checkbox" name="betting_id[]" class="betting_ids" value="' . $betting_id . '"  />';
}

function get_betting_delete_link($betting_id, $event_id)
{
    //    p([$betting_id,$event_id->event_id],1);
    return '<a href="javascript:void(0);' . base_url() . 'admin/bettings/deletebet/' . $event_id->list_event_id . '/' . $betting_id . '" onclick="deleteSingleBetting(' . $betting_id . ')"><i class="fa fa-trash" style="font-size:15px;"></i></a>';
}

function count_user_balance($user_id)
{
    $CI = &get_instance();
    $CI->load->model("User_model");
    $return = "";
    if (!empty($user_id)) {
        $user_data = $CI->User_model->getUserById($user_id);

        if (!empty($user_data)) {
            $balance = count_total_balance($user_id);
        }
    }


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

function count_user_exposure($user_id = null)
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

            $totalRiskAmt += min($exposures) < 0 ? min($exposures) : 0;
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
                    'user_id' => $user_id,
                    'match_id' => $bettingData['match_id'],
                    'status' => 'Open'
                );

                $max = $CI->Betting_model->get_max_fancy_bettings($dataArray);
                $min = $CI->Betting_model->get_min_fancy_bettings($dataArray);

                $max_p = $max + 5;
                $min_p = $min - 5;

                $scores = array_reverse(range($min_p, $max_p));

                $bettings = $CI->Betting_model->get_fancy_bettings($dataArray);

                $tmp_array = array();

                foreach ($bettings as $betting) {
                    $price_val = $betting->price_val;
                    $stake = $betting->stake;
                    $profit = $betting->profit;
                    $loss = $betting->loss;


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


                $totalRiskAmt += min($tmp_array) < 0 ? min($tmp_array) : 0;
            }
        }
    }


    /**********************Fancy********************** */

    return $totalRiskAmt >= 0 ? 0 : $totalRiskAmt;
}

function count_user_winnings($user_id)
{

    $CI = &get_instance();

    $CI->load->model("Ledger_model");
    $balance = "";
    if (!empty($user_id)) {
        $ledger = $CI->Ledger_model->count_total_winnings($user_id);
    }
    return isset($balance) ? $balance : 0;

    //  $CI = &get_instance();

    // $CI->load->model("Betting_model");

    // $user_data = $CI->User_model->getUserById($user_id);

    // if (!empty($user_data)) {
    //     $user_type = isset($user_data->user_type) ? $user_data->user_type : '';

    //     if ($user_type == 'User') {
    //         $CI = &get_instance();
    //         $return = "";
    //         if (!empty($user_id)) {
    //             $user_data = $CI->User_model->getUserById($user_id);

    //             if (!empty($user_data)) {
    //                 $balance = $user_data->winings;
    //             }
    //         }

    //         return isset($balance) ? $balance : 0;
    //     } else {
    //         return 0;
    //     }
    // }
}

function count_user_credit_limit($user_id)
{
    $CI = &get_instance();

    $CI->load->model("User_model");
    $balance = "";
    if (!empty($user_id)) {
        $user_data = $CI->User_model->getUserById($user_id);

        if (!empty($user_data)) {
            $balance = $user_data->credit_limit;
        }
    }
    return isset($balance) ? $balance : 0;
}



function get_user_position_by_marketid($market_id = null, $user_id = null)
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
    $user = $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;


    // echo $user->user_id;
    // $bettings = $CI->Betting_model->get_bettings_by_market_id(array('user_id' => $user_id, 'market_id' => $market_id, 'betting_type' => 'Match', 'status' => 'Open'));

    $bettings =   $CI->Masters_betting_settings_model->get_user_position_open_bettings_list(array(
        'market_id' => $market_id,
        'user_id' => $user_id
    ));

    if (!empty($bettings)) {
        $all_bettings = array_merge($all_bettings, $bettings);
        $exposure = count_market_position_for_user($bettings);
        // p($exposure);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }


    return $tmpExposure;
}


function count_market_position_for_user($all_bettings)
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
        foreach ($markets as $key => $market) {
            $market_id = str_replace('_', '.', $key);

            $market_id = str_replace('.BM', '_BM', $market_id);
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
                            $price = ((($betting->price_val * $betting->stake * 1) - $betting->stake));


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] -= ($price);
                            } else {
                                $total_exposure[$runnerKey] += (($betting->stake));
                            }
                        } else {
                            $price = ((($betting->price_val * $betting->stake * 1) - $betting->stake));

                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] += ($price);
                            } else {
                                $total_exposure[$runnerKey] -= (($betting->stake));
                            }
                        }
                    }
                }
            }
        }
    }



    return $total_exposure;
}

function get_master_market_position_by_marketid($market_id = null, $user_id = null)
{
    $CI = &get_instance();
    $CI->load->model("Masters_betting_settings_model");
    $CI->load->model("User_model");


    if (!$user_id) {
        $user_id = get_user_id();
    }

    $user_data = $CI->User_model->getUserById($user_id);

    $user_type = $user_data->user_type;
    $bettings = $CI->Masters_betting_settings_model->get_master_position_open_bettings_list(array(
        'market_id' => $market_id,
        'user_id' => $user_id,
        'user_type' => $user_type
    ));






    $tmpExposure = array();
    // p($bettings);
    if (!empty($bettings)) {
        $exposure = count_market_position_for_master($bettings);
        // p($exposure,0);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }

    return $tmpExposure;
}


function count_market_position_for_master($all_bettings)
{

    $CI = &get_instance();
    $CI->load->model("Event_model");

    $markets = array();
    // p(get_user_name());

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '_', $betting->market_id);
            $markets[$market_id] = array();
        }
    }




    // p($markets);
    if (!empty($markets)) {
        foreach ($markets as $key => $market) {
            $market_id = str_replace('_', '.', $key);
            $market_id = str_replace('.BM', '_BM', $market_id);
            // p($market_id,0);
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
                            $profit = $betting->client_profit * (100 - $betting->partnership) / 100;
                            $loss = $betting->client_loss  * (100 - $betting->partnership) / 100;


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] -= ($profit);
                            } else {
                                $total_exposure[$runnerKey] += ($loss);
                            }
                        } else {
                            $profit = $betting->client_profit * (100 - $betting->partnership) / 100;
                            $loss = $betting->client_loss  * (100 - $betting->partnership) / 100;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] += ($loss);
                            } else {
                                $total_exposure[$runnerKey] -= ($profit);
                            }
                        }

                        // p($total_exposure,0);
                    }
                }
            }
        }
    }





    return $total_exposure;
}



function write_chipsummary_data($file_name, $data)
{
    $CI = &get_instance();
    $CI->load->helper('file');

    $output = array();


    write_file($file_name, $data);
}



function read_chipsummary_data($file_name)
{
    $CI = &get_instance();
    $CI->load->helper('file');

    $output = array();

    $generate_file = TRUE;
    if (is_file($file_name)) {
        $fh = fopen($file_name, "r");
        $data = fread($fh, 100024);
        // $data;
        return  $data;
    } else {
        return (object) [];
    }
}


function get_winnings_amt_17_feb($user_id)
{
    $CI = &get_instance();

    $user_data = $CI->User_model->getUserById($user_id);

    if (!empty($user_data)) {
        if ($user_data->user_type == 'User') {
            $total_settle_amount = $CI->Ledger_model->get_total_settlement_new($user_data->user_id, 'N', $user_data->user_type);

            if ($total_settle_amount >= 0) {
                return '<span class="minus">' . number_format(abs($total_settle_amount), 2) . '</plus>';
            } else {
                return '<span class="blue">' . number_format(abs($total_settle_amount), 2) . '</plus>';
            }
        }
    }


    // if($amt >= 0)
    // {
    //     return '<span class="minus">'.abs($amt).'</plus>';
    // }
    // else
    // {
    //     return '<span class="blue">'.abs($amt).'</plus>';

    // }
}

function get_winnings_amt($user_id)
{

    $CI = &get_instance();

    $user_data = $CI->User_model->getUserById($user_id);


    $dataArray["user_data"] = $user_data;

    $content = $CI->load->viewPartial('user-winnings-html', $dataArray, TRUE);

    return $content;

    // echo $html;
}


function get_sidebar_content()
{
    $CI = &get_instance();
    $content = $CI->load->viewPartial('sidebar');
    return $content;
}

function getTheme()
{
    $CI = &get_instance();
    $CI->load->model("User_model");

    $user_id = get_user_id();

    $user_detail = $CI->User_model->getUserById($user_id);

    if (!empty($user_detail)) {
        $theme_id = $user_detail->theme_id;
        return $theme_id;
    }
}
function getDiamondCasinoResult($link)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
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
function showCardOfResult($link)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
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
function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}



function getUserChips()
{
    $CI = &get_instance();
    $CI->load->model("User_chip_model");
    $user_id = get_user_id();
    $chips = $CI->User_chip_model->getUserChips($user_id);
    return $chips;
}


function get_master_upline_market_exposure_by_marketid($market_id = null, $user_id = null)
{
    $CI = &get_instance();
    $CI->load->model("Masters_betting_settings_model");

    if (!$user_id) {
        $user_id = get_user_id();
    }

    $bettings = $CI->Masters_betting_settings_model->get_open_bettings_list(array(
        'market_id' => $market_id,
        'user_id' => $user_id
    ));


    $tmpExposure = array();
    // p($bettings);
    if (!empty($bettings)) {
        $exposure = count_market_exposure3($bettings);
        // p($exposure,0);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }

    return $tmpExposure;
}


function count_market_exposure3($all_bettings)
{

    $CI = &get_instance();
    $CI->load->model("Event_model");

    $markets = array();
    // p(get_user_name());

    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '_', $betting->market_id);
            $markets[$market_id] = array();
        }
    }


    // p($markets);
    if (!empty($markets)) {
        foreach ($markets as $key => $market) {
            $market_id = str_replace('_', '.', $key);
            $market_id = str_replace('.BM', '_BM', $market_id);
            // p($market_id,0);
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
                            $profit = $betting->client_profit * (100 - $betting->partnership)  / 100;


                            $loss = $betting->client_loss * (100 - $betting->partnership)  / 100;


                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] -= ($profit);
                            } else {
                                $total_exposure[$runnerKey] += ($loss);
                            }
                        } else {
                            $profit = $betting->client_profit * (100 - $betting->partnership)  / 100;

                            $loss = $betting->client_loss * (100 - $betting->partnership)  / 100;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey] += ($loss);
                            } else {
                                $total_exposure[$runnerKey] -= ($profit);
                            }
                        }

                        // p($total_exposure,0);
                    }
                }
            }
        }
    }

    return $total_exposure;
}

function get_live_tv($event_id)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://marketsarket.in:3002/livetvurl/' . $event_id,
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


function get_casino_timer($event_id)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://178.79.189.86:8001/getCasinoEvents/' . $event_id,
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



function get_master_open_bets_list($dataArray)
{
    $CI = &get_instance();
    $CI->load->model("Betting_model");
    $CI->load->model("User_model");
    $CI->load->model("Masters_betting_settings_model");
    $user_id = $dataArray['user_id'];
    $match_id = $dataArray['match_id'];
    $type = $dataArray['type'];
    $selection_id = $dataArray['selection_id'];

    $bettings = $CI->Masters_betting_settings_model->get_event_open_bettings_list1(array(
        'user_id' => $user_id,
        'match_id' => $match_id,
        'unmatch_bet' => $dataArray['unmatch_bet']
        // 'type' => $type,
        // 'selection_id' => $selection_id

    ));
    return $bettings;
}


function generateRandomEventId($length = 10)
{
    $characters = '0123456789' . strtotime("now");
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function check_is_casino($type = null)
{
    $casinotypes = getCustomConfigItem('casino_event_type');
    if (in_array($type, $casinotypes)) {
        return true;
    } else {
        return false;
    }
}


function get_fancy_odds($dataValues = array())
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://178.79.189.86:8001/checkFancyCurrentOdds/" . $dataValues['match_id'] . '/' . $dataValues['selection_id'],

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


    return json_decode($response, true);
}

function get_match_odds($dataValues = array())
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://178.79.189.86:8001/checkCurrentOdds/" . $dataValues['market_id'] . '/' . $dataValues['selection_id'],

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


    return json_decode($response, true);
}



function get_masters_winnings($user_id, $user_type)
{
    $CI = &get_instance();
    $CI->load->model("Ledger_model");

    $user_details = $CI->User_model->getUserById($user_id);



    if ($user_details->user_type == 'User') {

        $total_settle_amount = $CI->Ledger_model->get_total_settlement_for_user($user_id, 'N', $user_type);
    } else {
        // $total_settle_amount = $CI->Ledger_model->get_total_settlement($user_id, 'N', $user_type);
        $total_settle_amount = $CI->Ledger_model->count_supers_total_settlement($user_id);
    }

    return $total_settle_amount;
}

function checkFancyCurrentOdds($match_id, $selection_id)
{
    $curl = curl_init();

    // p("http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id);
    curl_setopt_array($curl, array(
        // CURLOPT_URL => "http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id,
        CURLOPT_URL => "http://178.79.189.86:8001/checkFancyCurrentOdds/" . $match_id . "/" . $selection_id,

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



function get_redis_market_exposure($dataValues = array())
{
    $curl = curl_init();

    // p("http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id);
    curl_setopt_array($curl, array(
        // CURLOPT_URL => "http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id,
        CURLOPT_URL => "http://178.79.189.86:8001/countMarketExposure/" . $dataValues['user_id'] . "/" . $dataValues['match_id'] . "/" . $dataValues['market_id'],

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
    return json_decode($response, true);
}


function get_anim_url($dataValues = array())
{
    $curl = curl_init();

    // p("http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id);
    curl_setopt_array($curl, array(
        // CURLOPT_URL => "http://88.80.186.39/sgbet/api/Exchange_api/getMarketData/".$market_id,
        CURLOPT_URL => "http://178.79.189.86:4050/demo-2056818290/animurl?event_id=31245954",

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

function isIosDevice()
{
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $iosDevice = array('iphone', 'ipod', 'ipad');
    $isIos = false;

    foreach ($iosDevice as $val) {
        if (stripos($userAgent, $val) !== false) {
            $isIos = true;
            break;
        }
    }

    return $isIos;
}



function getTodayAllEvents()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://178.79.189.86:8001/getTodayAllEvents",
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
    return json_decode($response, true);
}


function get_yesterday_datetime()
{
    return  date('Y-m-d H:i:s', strtotime("midnight", strtotime(date('Y-m-d H:i:s', strtotime('-1 days')))));
}

function get_today_end_datetime()
{
    $timestamp = strtotime("today 23:59:59");
    return  date('Y-m-d H:i:s', $timestamp);;
}

function add_openning_bal_row($newopen_bal, $report_arr)
{
    $tempArray = array(
        'user_id' => 0,
        'remarks' => 'Opening balance',
        'transaction_type' => 'Credit',
        'type' => 'Free Chip',
        'amount' => (float)$newopen_bal,
        'created_at' => '2002-02-25 00:22:05',
        'betting_type' => '',
        'selection_id' => '',
        'market_id' => '',
        'match_id' => '',
        'event_name' => '',
        'market_name' => '',
        'available_balance' => (float)$newopen_bal,
        'is_opening' => 'Yes'
    );
    $report_arr[count($report_arr) + 1] = $tempArray;
    return $report_arr;
}


function get_market_runners($market_id)
{
    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();

    $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));


    if (empty($runners)) {
        $runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));
    }
    // p($runners);

    if (!empty($runners)) {

        foreach ($runners as $runner) {

            $selection_id = $runner['selection_id'];
            $total_exposure[$selection_id] = 0;
        }
    }

    // p($total_exposure);

    return $total_exposure;
}



function get_user_max_profit_by_marketid($market_id = null, $user_id = null, $unmatch_bet_include = 'No')
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
    $user = $CI->User_model->getUserById($user_id);
    $partner_ship = $user->partnership;


    // echo $user->user_id;
    $bettings = $CI->Betting_model->get_unmatch_bettings_by_market_id(array('user_id' => $user_id, 'market_id' => $market_id, 'betting_type' => 'Match', 'status' => 'Open'));

    if (!empty($bettings)) {
        $all_bettings = array_merge($all_bettings, $bettings);
        $exposure = count_market_max_profit_for_user($bettings, $unmatch_bet_include);
        // p($exposure);
        if (!empty($exposure)) {
            foreach ($exposure as $key => $exp) {
                $exposure_1 = $exp;

                if (isset($tmpExposure[$key])) {
                    $tmpExposure[$key] += ($exposure_1);
                } else {
                    $tmpExposure[$key] = ($exposure_1);
                }
            }
        }
    }


    return $tmpExposure;
}


function count_market_max_profit_for_user($all_bettings, $unmatch_bet_include = 'No')
{



    $CI = &get_instance();
    $CI->load->model("Event_model");
    $CI->load->model("Betting_model");

    $markets = array();


    // p("hello");
    if (!empty($all_bettings)) {
        foreach ($all_bettings as $betting) {
            $market_id = str_replace('.', '___', $betting->market_id);

            $markets[$market_id] = array();
        }
    }



    // p("here");


    if (!empty($markets)) {
        foreach ($markets as $key =>  $market) {
            $market_id = str_replace('___', '.', $key);
            $runners = $CI->Event_model->get_market_book_odds_runner(array('market_id' => $market_id));


            if (empty($runners)) {
                $runners = $CI->Event_model->get_manual_market_book_odds_runner(array('market_id' => $market_id));
            }
            // p($runners);

            if (!empty($runners)) {

                foreach ($runners as $runner) {

                    $selection_id = $runner['selection_id'];
                    $total_exposure[$selection_id] = 0;
                }
            }


            if ($_SESSION['my_userdata']['user_name'] == 'TA04') {

                // if($market_id == '9.220301184116_match_odds')
                // {

                // p($market_id);
                // }
            }


            if (!empty($all_bettings)) {
                foreach ($all_bettings as $betting) {

                    if ($unmatch_bet_include == 'No') {
                        if ($betting->unmatch_bet == 'Yes') {
                            continue;
                        }
                    }


                    foreach ($total_exposure as $runnerKey => $exposure) {

                        if ($betting->is_back == 1) {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;



                            if ($betting->selection_id == $runnerKey) {
                                $total_exposure[$runnerKey]   += ($price);
                            } else {
                                // $total_exposure[$runnerKey]   -= ($betting->stake);
                            }
                        } else {
                            $price = ($betting->price_val * $betting->stake * 1) - $betting->stake;



                            if ($betting->selection_id == $runnerKey) {
                                // $total_exposure[$runnerKey]   -= ($price);
                            } else {
                                $total_exposure[$runnerKey]   += ($betting->stake);
                            }
                        }

                        // p($total_exposure,0);
                    }
                }
            }
        }
    }


    // p($total_exposure);

    return $total_exposure;
}

function get_casino_odds($type = null)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://178.79.189.86:8001/" . $type,

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


    return json_decode($response, true);
}


function get_market_type_by_market_id($dataArray = array())
{
    $event_id = $dataArray['event_id'];
    $market_id = $dataArray['market_id'];
    $selection_id = $dataArray['selection_id'];



    if ($event_id == '56767') {
        $data = get_casino_odds('getODTP');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sectionId']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sectionId'],
                            'runner_name' => $market_type_detail['nation'],
                            'sort_priority' => $market_type_detail['Srno'],
                            'status' => $market_type_detail['gstatus'],
                            'back_1_price' => $market_type_detail['b1'],
                            'lay_1_price' => $market_type_detail['l1'],
                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    } else if ($event_id == '56768') {
        $data = get_casino_odds('getTEEN20');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sid']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sid'],
                            'runner_name' => $market_type_detail['nation'],
                            'sort_priority' => $market_type_detail['sid'],
                            'status' => $market_type_detail['gstatus'],
                            'back_1_price' => $market_type_detail['rate'],
                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    } else if ($event_id == '98789') {
        $data = get_casino_odds('getLucky7A');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sid']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sid'],
                            'runner_name' => $market_type_detail['nation'],
                            'sort_priority' => $market_type_detail['sid'],
                            'status' => $market_type_detail['gstatus'] == 1 ? 'ACTIVE' : 'SUSPENDED',
                            'back_1_price' => $market_type_detail['rate'],
                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    } else if ($event_id == '56967') {
        $data = get_casino_odds('get32B');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sid']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sid'],
                            'runner_name' => $market_type_detail['nation'],
                            'sort_priority' => $market_type_detail['sid'],
                            'status' => $market_type_detail['gstatus'] == 'ACTIVE' ? 'ACTIVE' : 'SUSPENDED',
                            'back_1_price' => $market_type_detail['b1'],
                            'lay_1_price' => $market_type_detail['l1'],

                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    } else if ($event_id == '98790') {
        $data = get_casino_odds('getDT20');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sid']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sid'],
                            'runner_name' => $market_type_detail['nat'],
                            'sort_priority' => $market_type_detail['sid'],
                            'status' => $market_type_detail['gstatus'] == 1 ? 'ACTIVE' : 'SUSPENDED',
                            'back_1_price' => $market_type_detail['rate'],

                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    } else if ($event_id == '98791') {
        $data = get_casino_odds('getAAA');


        if (!empty($data)) {
            $orginal_market_id = $data['additional_info']['mid'];

            $round_id  = explode('.', $orginal_market_id);
            $orginal_market_id = str_replace('.', '__', $orginal_market_id);
            $markets = $data['markets'];


            $tmp_market_type = str_replace($orginal_market_id . '_', '', $market_id);

            $market_name = '';



            if ($tmp_market_type == 'match_odds') {
                $market_name = 'Match Odds';
            }

            $market_type_details = $markets[$tmp_market_type];

            $market_detail = array(
                'event_id' => $event_id,
                'round_id' => $round_id[1],
                'market_name' => $market_name,
                'market_id' => $market_id,
            );

            $runner_details = array();

            if (!empty($market_type_details)) {
                foreach ($market_type_details as $market_type_detail) {

                    if ($selection_id == $market_type_detail['sid']) {
                        $runner_details[]  = array(
                            'market_book_odd_id' => $market_id,
                            'market_id' => $market_id,
                            'event_id' => $event_id,
                            'selection_id' => $market_type_detail['sid'],
                            'runner_name' => $market_type_detail['nat'],
                            'sort_priority' => $market_type_detail['sid'],
                            'status' => $market_type_detail['gstatus'] == "ACTIVE" ? 'ACTIVE' : 'SUSPENDED',
                            'back_1_price' => $market_type_detail['b1'],
                            'lay_1_price' => $market_type_detail['l1'],


                        );
                    }
                }
            }
        }

        $responseData = array(
            'runner_details' => $runner_details,
            'market_detail' => $market_detail
        );

        return $responseData;
    }
}


function sendOtp($dataArray)
{
    $smsConfig = getCustomConfigItem('sms');
    $smsConfig['message'] = $dataArray['message'];
    $smsConfig['numbers'] = $dataArray['number'];

    $query = http_build_query($smsConfig);
    // p($query);

    $url = "http://sms.hspsms.com/sendSMS?" . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $arr = json_decode($data);
    return $arr;
}


function get_jwt_casino_token($data)
{

    $postdata = json_encode($data);
    $url = get_ws_endpoint() . 'gettoken';
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

    $result = json_decode($result, true);

    return $result['token'] ? $result['token'] : '';
}




function generateNumericOTP()
{
    $n = 5;
    $generator = "1357902468";

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }
    return $result;
}


function sendNotification($dataArray)
{
    $smsConfig = getCustomConfigItem('sms');
    $smsConfig['message'] = $dataArray['message'];
    $smsConfig['numbers'] = $dataArray['number'];

    $query = http_build_query($smsConfig);
    // p($query);
    $url = "http://sms.hspsms.com/sendSMS?" . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $arr = json_decode($data);

    return $arr;
}


function count_total_bonus($user_id = null)
{

    $CI = &get_instance();
    $CI->load->model("Bonus_model");

    if (!$user_id) {
        $user_id = get_user_id();
    }

    $total_bonus_amount = $CI->Bonus_model->count_total_bonus($user_id);
    return $total_bonus_amount;
}



function get_total_settlement($user_id)
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://109.74.204.187:9090/getWinnings/" . $user_id,
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
    return json_decode($response, true);
}


function get_my_sharing($user_id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://109.74.204.187:9090/getMySharing/" . $user_id,
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
    return json_decode($response, true);
}



function get_upline_sharing($user_id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://109.74.204.187:9090/getUplineSharing/" . $user_id,
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
    return json_decode($response, true);
}
