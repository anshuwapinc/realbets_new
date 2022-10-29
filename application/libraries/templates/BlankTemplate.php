<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    /**
     * Blank template
     */
    require_once 'template.php';

    /**
     * Blank template for rendering the partial views
     * that do not require the other stuff like header and footer etc.
     * Normally this will be used in AJAX calls for partial rendering of pages
     */
    class BlankTemplate extends Template
    {

        public function __construct()
        {
            parent::__construct();
        }

        public function render($view, array $data = array())
        {
            return $this->CI->load->viewPartial($view, $data);
        }

    }
    