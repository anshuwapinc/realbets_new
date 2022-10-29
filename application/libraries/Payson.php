<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    require_once APPPATH . "third_party/payson/lib/paysonapi.php";

    class Payson
    {

        private $_CI;

        public function __construct()
        {

            $this->_CI = & get_instance();
        }

        public function payment($data)
        {

            /*
             * Account information. Below is all the variables needed to perform a purchase with
             * payson. Replace the placeholders with your actual information 
             */

            // Your agent ID and md5 key
            $agentID = $data["agentID"]; // "4";
            $md5Key = $data["md5Key"]; //"2acab30d-fe50-426f-90d7-8c60a7eb31d4";
            // URLs used by payson for redirection after a completed/canceled purchase.

            $returnURL = $data["returnURL"]; //"http://localhost/work/payson/example/return.php";
            $cancelURL = $data["cancelURL"]; //"http://localhost/work/payson/example/cancel.php";
            // Please note that only IP/URLS accessible from the internet will work
            $ipnURL = $data["ipnURL"];   //"http://my.local/phpAPI/example/ipn-example.php";

            $customReceipt = true;

            // Account details of the receiver of money
            $receiverEmail = $data["receiverEmail"]; //"testagent-1@payson.se";
            // Amount to send to receiver
            $amountToReceive = $data["amountToReceive"]; //"10";
            // Information about the sender of money
            $senderEmail = $data["senderEmail"]; //"test-shopper@payson.se";
            $senderFirstname = $data["senderFirstname"]; //"Test";
            $senderLastname = $data["senderLastname"]; //"Person";
            $custom = $data["custom"]; //"Payment id";
            $currency = $data["currency"]; //"Payment id";


            /* Every interaction with Payson goes through the PaysonApi object which you set up as follows.  
             * For the use of our test or live environment use one following parameters:
             * TRUE: Use test environment, FALSE: use live environment */
            $credentials = new PaysonCredentials($agentID, $md5Key);
            $api = new PaysonApi($credentials, TRUE);

            /*
             * To initiate a direct payment the steps are as follows
             *  1. Set up the details for the payment
             *  2. Initiate payment with Payson
             *  3. Verify that it suceeded
             *  4. Forward the user to Payson to complete the payment
             */

            /*
             * Step 1: Set up details
             */


// Details about the receiver
            $receiver = new Receiver(
                $receiverEmail, // The email of the account to receive the money
                $amountToReceive); // The amount you want to charge the user, here in SEK (the default currency)
            $receivers = array($receiver);

// Details about the user that is the sender of the money
            $sender = new Sender($senderEmail, $senderFirstname, $senderLastname);

            $showReceiptPage = false;

            $payData = new PayData($returnURL, $cancelURL, $ipnURL, "Ticket Payment", $sender, $receivers,$customReceipt, $showReceiptPage);

//Set the list of products. For direct payment this is optional
//$orderItems = array();
//$orderItems[] = new OrderItem("Test produkt", 100, 1, 0.25, "kalle");
//$payData->setOrderItems($orderItems);
//Set the payment method
            $constraints = array(FundingConstraint::BANK, FundingConstraint::CREDITCARD); // bank and card
//$constraints = array(FundingConstraint::INVOICE); // only invoice
//$constraints = array(FundingConstraint::BANK, FundingConstraint::CREDITCARD, FundingConstraint::INVOICE); // bank, card and invoice
//$constraints = array(FundingConstraint::SMS); // only live environment. 
//$constraints = array(FundingConstraint::BANK); // only bank
            $payData->setFundingConstraints($constraints);

//Set the payer of Payson fees
//Must be PRIMARYRECEIVER if using FundingConstraint::INVOICE
            $payData->setFeesPayer(FeesPayer::PRIMARYRECEIVER);

// Set currency code
            $payData->setCurrencyCode($currency);

// Set locale code
            $payData->setLocaleCode(LocaleCode::SWEDISH);

// Set guarantee options
            $payData->setGuaranteeOffered(GuaranteeOffered::OPTIONAL);

            $payData->setCustom($custom);


            /*
             * Step 2 initiate payment
             */
            $payResponse = $api->pay($payData);



            $result = array("error" => "", "result" => "");
            $errorstr = "";
            $rediecturl = "";
            /*
             * Step 3: verify that it suceeded
             */
            if ($payResponse->getResponseEnvelope()->wasSuccessful())
            {
                /*
                 * Step 4: forward user
                 */
                $rediecturl = $api->getForwardPayUrl($payResponse);
            }
            else
            {
                $detailsErrors = $payResponse->getResponseEnvelope()->getErrors();

                foreach ($detailsErrors as $error)
                {
                    $errorstr .= $error->getMessage();
                }
            }

            $result["error"] = $errorstr;
            $result["result"] = $rediecturl;

            return $result;
        }

        public function paysonresponse($data)
        {

            $errormsg = "";
            $resultdetails = "";
            $paymentid = "";
            // Fetch the token that are returned
            $token = $data["TOKEN"];
            $agentID = $data["agentID"]; // "4";
            $md5Key = $data["md5Key"]; //"2acab30d-fe50-426f-90d7-8c60a7eb31d4";
// Initialize the API in test mode
            $credentials = new PaysonCredentials($agentID, $md5Key);
            $api = new PaysonApi($credentials, TRUE);

// Get the details about this purchase
            $detailsResponse = $api->paymentDetails(new PaymentDetailsData($token));

// First we verify that the call to payson succeeded.
            if ($detailsResponse->getResponseEnvelope()->wasSuccessful())
            {

                // Get the payment details from the response
                $details = $detailsResponse->getPaymentDetails();

                // If the call to Payson went well we also have to check the actual status 
                // of the transfer
                if ($details->getType() == "TRANSFER" && $details->getStatus() == "COMPLETED")
                {
                    $resultdetails = $details;
                    $paymentid = $details->getCustom();
                    // echo "Purchase has been completed <br /><h4>Details</h4><pre>" . $details . "</pre>";
                }
                elseif ($details->getType() == "INVOICE" && $details->getInvoiceStatus() == "ORDERCREATED")
                {
                    $resultdetails = $details;
                    $paymentid = $details->getCustom();
                    //echo "Invoice has been created <br /><h4>Details</h4><pre>" . $details . "</pre>";
                }
                else if ($details->getStatus() == "ERROR")
                {
                    $resultdetails = $details;
                    $errormsg = "error";
                    // echo "An error occured has occured <br /><h4>Details</h4><pre>" . $details . "</pre>";
                }

                /* Below are the other data that can be retreived from payment details
                  $details->getCustom();
                  $details->getShippingAddressName();
                  $details->getShippingAddressStreetAddress();
                  $details->getShippingAddressPostalCode();
                  $details->getShippingAddressCity();
                  $details->getShippingAddressCountry();
                  $details->getToken();
                  $details->getType();
                  $details->getStatus();
                  $details->getCurrencyCode();
                  $details->getTrackingId();
                  $details->getCorrelationId();
                  $details->getPurchaseId();
                  $details->getSenderEmail();
                  $details->getInvoiceStatus();
                  $details->getGuaranteeStatus();
                  $details->getReceiverFee();
                 * 
                 */
            }
            else
            {
                $detailsErrors = $detailsResponse->getResponseEnvelope()->getErrors();

                foreach ($detailsErrors as $error)
                {

                    $errormsg .=$error->getMessage();
                }
            }

            $result = array("error" => $errormsg, "result" => $resultdetails, "paymentid" => $paymentid);
            return $result;
        }

        public function ipnurl($data)
        {

            
            // Your agent ID and md5 key
            $agentID = $data["agentID"]; // "4";
            $md5Key = $data["md5Key"]; //"2acab30d-fe50-426f-90d7-8c60a7eb31d4";
            // URLs used by payson for redirection after a completed/canceled purchase.
          
// Get the POST data
            $postData = file_get_contents("php://input");

            file_put_contents("test.txt", $postData);

// Set up API
            $credentials = new PaysonCredentials($agentID, $md5Key);
            $api = new PaysonApi($credentials, TRUE);

// Validate the request
            $response = $api->validate($postData);

            if ($response->isVerified())
            {
                // IPN request is verified with Payson
                // Check details to find out what happened with the payment
                $details = $response->getPaymentDetails();

                // After we have checked that the response validated we have to check the actual status 
                // of the transfer
                if ($details->getType() == "TRANSFER" && $details->getStatus() == "COMPLETED")
                {
                    // Handle completed card & bank transfers here
                }
                elseif ($details->getType() == "INVOICE" && $details->getStatus() == "PENDING" && $details->getInvoiceStatus() == "ORDERCREATED")
                {
                    // Handle accepted invoice purchases here
                }
                else if ($details->getStatus() == "ERROR")
                {
                    // Handle errors here
                }
                /*
                  //More info
                  $response->getPaymentDetails()->getCustom();
                  $response->getPaymentDetails()->getShippingAddressName();
                  $response->getPaymentDetails()->getShippingAddressStreetAddress();
                  $response->getPaymentDetails()->getShippingAddressPostalCode();
                  $response->getPaymentDetails()->getShippingAddressCity();
                  $response->getPaymentDetails()->getShippingAddressCountry();
                  $response->getPaymentDetails()->getToken();
                  $response->getPaymentDetails()->getType();
                  $response->getPaymentDetails()->getStatus();
                  $response->getPaymentDetails()->getCurrencyCode();
                  $response->getPaymentDetails()->getTrackingId();
                  $response->getPaymentDetails()->getCorrelationId();
                  $response->getPaymentDetails()->getPurchaseId();
                  $response->getPaymentDetails()->getSenderEmail();
                  $response->getPaymentDetails()->getInvoiceStatus();
                  $response->getPaymentDetails()->getGuaranteeStatus();
                  $details->getReceiverFee();
                 */
            }
        }

    }
    