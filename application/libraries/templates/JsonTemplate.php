<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    /**
     * Json template
     */
    require_once 'template.php';

    /**
     * Json Template for encoding the PHP array into JSON serialized strings
     */
    class JsonTemplate extends Template
    {

        public function __construct()
        {
            parent::__construct();
        }

        public function render($content, array $data = array())
        {
            $content = json_encode($data);
            return $content;
        }

    }
    