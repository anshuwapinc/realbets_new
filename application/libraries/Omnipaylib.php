<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//require_once APPPATH . '../vendor/autoload.php';

//use Omnipay\Omnipay;
//use Omnipay\Common\CreditCard;

class Omnipaylib {

    public function __construct() {
        $this->_CI = &get_instance();
    }

    public function sendpayment_request($input_arr) {

        $this->lib_config = getCustomConfigItem("Swish");
        define('CONTENT_TYPE', 'application/json');
        $options = array(
          'Content-Type: '. CONTENT_TYPE .'',
         );
        
        
        $data_string = json_encode($input_arr);
        $soap = curl_init();
        curl_setopt($soap, CURLOPT_HTTPHEADER, $options);
        curl_setopt($soap, CURLOPT_URL, $this->lib_config['curl_url']);
        curl_setopt($soap, CURLOPT_CAPATH, "/etc/ssl/certs");
        curl_setopt($soap, CURLOPT_SSLCERT, $this->lib_config['cert_path']);
        curl_setopt($soap, CURLOPT_SSLKEY, $this->lib_config['privateKey_path']);
        curl_setopt($soap, CURLOPT_SSLKEYPASSWD, "FilleFjonken");
        curl_setopt($soap, CURLOPT_POSTFIELDS, $data_string);
        // Added for getting the paymenttokens
        curl_setopt($soap, CURLOPT_HEADER, true);
        curl_setopt($soap, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($soap);

         // Saving the result
       $fp = fopen('incomingswish.txt', 'a');
        fwrite($fp, $curlResponse);
        fclose($fp);

         // Get paymenttoken to use for opening swishapp
         $parts = explode("\n", $curlResponse);
         $paymenttoken=explode(":", $parts[6]);
	 
       //  $paymenttokenclean=trim($paymenttoken[1]);
          if(isset($paymenttoken[1]))
         {
              $paymenttokenclean=trim($paymenttoken[1]);
         }
         else
         {
              $paymenttokenclean=0;
         }

         // Get payment ID to use for check if paid/failed before return to lottoklubben
         $paymentidclean=substr($parts[5], -33);

        if (curl_errno($soap) > 0) {  
            $result = array('status' => "fail", 'error_msg' => curl_error($soap));
        } else {
             $result = array('status' => "success", 'error_msg' => $curlResponse, 'paymenttoken' => $paymenttokenclean, 'id' => $paymentidclean);
        }
        
        curl_close($soap);
        log_message("MY_INFO", $curlResponse);
        return $result;
    }

}
