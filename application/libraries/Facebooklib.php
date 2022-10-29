<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');




    include_once "./vendor/autoload.php";

    class Facebooklib
    {

        private $_CI;
        private $socialconfig;

        public function __construct()
        {

            $this->_CI = & get_instance();
            // $this->socialconfig = include_once "./hybridauth/config.php";  
        }

//https://www.lottoklubben.se/test_lottery/user_fbredirect/
        public function facebook_login($type='')
        {
            if(empty($type))
            {
                $appId = getCustomConfigItem('fb_app_id');
                $secret = getCustomConfigItem('fb_app_secret');
            }
            else
            {
                $appId = getCustomConfigItem('fb__association_app_id');
                $secret = getCustomConfigItem('fb_association_app_secret');
            }

            $result = array("error" => "", "result" => "");

           
//            $fb = new \Facebook\Facebook(array(
//                'appId' => $appId,
//                'secret' => $secret,
//                //, "scope" => "email,user_education_history,user_work_history"
//                 'trustForwarded' => false,
//                 'user_type' => $type
//
//            ));
            $fb = new \Facebook\Facebook(array(
                'app_id' => $appId,
                'app_secret' => $secret,
                //, "scope" => "email,user_education_history,user_work_history"
                 'trustForwarded' => false,
                 'user_type' => $type

            ));

            $helper = $fb->getRedirectLoginHelper();

            try
            {
                $accessToken = $helper->getAccessToken();
            }
            catch (Facebook\Exceptions\FacebookResponseException $e)
            {
                // When Graph returns an error
                $result["error"] = $e->getMessage();
            }
            catch (Facebook\Exceptions\FacebookSDKException $e)
            {
                // When validation fails or other local issues
                $result["error"] = $e->getMessage();
            }

            if (!isset($accessToken))
            {
                if ($helper->getError())
                {
                    header('HTTP/1.0 401 Unauthorized');
                    //echo "Error: " . $helper->getError() . "\n";
                    //echo "Error Code: " . $helper->getErrorCode() . "\n";
                    // echo "Error Reason: " . $helper->getErrorReason() . "\n";
                    // echo "Error Description: " . $helper->getErrorDescription() . "\n";
                    $result["error"] = "Error: " . $helper->getError();
                }
                else
                {
                    header('HTTP/1.0 400 Bad Request');
                    $result["error"] = 'Bad request';
                }
            }

            if (empty($result["error"]))
            {
// Logged in
                //echo '<h3>Access Token</h3>';
                //var_dump($accessToken->getValue());
// The OAuth 2.0 client handler helps us manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
                $tokenMetadata = $oAuth2Client->debugToken($accessToken);
                //echo '<h3>Metadata</h3>';
                // var_dump($tokenMetadata); 
             //  $app_id =  getCustomConfigItem('fb_app_id');
               
// Validation (these will throw FacebookSDKException's when they fail)
                $tokenMetadata->validateAppId($appId); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
                $tokenMetadata->validateExpiration();

                if (!$accessToken->isLongLived())
                {
                    // Exchanges a short-lived access token for a long-lived one
                    try
                    {
                        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                    }
                    catch (Facebook\Exceptions\FacebookSDKException $e)
                    {
                        $result["error"] = $helper->getMessage() . "</p>\n\n";
                    }

                    //  echo '<h3>Long-lived</h3>';
                    //  var_dump($accessToken->getValue());
                }

                if (empty($result["error"]))
                {
                    $_SESSION['fb_access_token'] = (string) $accessToken;



                    try
                    {
                        // Returns a `Facebook\FacebookResponse` object
                        $response = $fb->get('/me?fields=id,gender,email,name', $accessToken);
                    }
                    catch (Facebook\Exceptions\FacebookResponseException $e)
                    {
                        $result["error"] = $e->getMessage();
                    }
                    catch (Facebook\Exceptions\FacebookSDKException $e)
                    {
                        $result["error"] = $e->getMessage();
                    }

                    $user = $response->getGraphUser();

                    // OR
                    $name = $user->getName();
                    $email = $user->getEmail();
                    $gender = $user->getGender();
                    $id = $user->getId();


                    $result["result"] = array(
                        "name" => $name,
                        "email" => $email,
                        "gender" => $gender,
                        "id" => $id
                    );
                }
            }

            return $result;
        }

        public function fburl($type='')
        {
            if(empty($type))
            {
                $appId = getCustomConfigItem('fb_app_id');
                $secret = getCustomConfigItem('fb_app_secret');
                $redirect = base_url().'user_fbredirect';
            }
            else
            {
                $appId = getCustomConfigItem('fb__association_app_id');
                $secret = getCustomConfigItem('fb_association_app_secret');
                $redirect = base_url().'association_fbredirect';
            }

            $facebook = new \Facebook\Facebook(array(
                'appId' => $appId,
                'secret' => $secret,
               // "scope" => "email,user_education_history,user_work_history"
                'trustForwarded' => false,
                'user_type' => $type,
                'grant_type' => 'client_credentials'
            ));
            //  $redirectUrl = base_url() . 'user_fbredirect';
            //  $fbPermissions = 'email,user_education_history,user_work_history';   
            //$facebookloginurl =  $facebook->getLoginUrl(array('redirect_uri'=>$redirectUrl,'scope'=>$fbPermissions));

            $helper = $facebook->getRedirectLoginHelper();

            $permissions = ['email']; // Optional permissions
            $redirect_url= $redirect;
            $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);

            return $loginUrl;
        }

    }
    
