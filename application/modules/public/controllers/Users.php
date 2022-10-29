<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->setTemplate('blank');
        $this->load->model('useraccount_model');

        $this->load->library('commonlib');
        $this->load->library('session');
    }
}

    /* End of file users.php */
