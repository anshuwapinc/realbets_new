<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Language extends MY_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
        }

        function switchlanguage($language = "")
        {
          
            $language = ($language != "") ? $language : "english";
            $this->session->set_userdata('site_lang', $language);
           // redirect(base_url());
            echo $language;
        }

    }
