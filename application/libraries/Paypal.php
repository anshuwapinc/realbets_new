<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    require_once APPPATH . "third_party/Paypal/Paypal_pro.php";
    class Paypal extends PayPal_Pro
    {

        public function __construct($dataArray)
        {
            parent::__construct($dataArray);
        }

    }
    