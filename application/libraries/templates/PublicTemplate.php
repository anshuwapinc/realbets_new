<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    /**
     * Default template
     */
    require_once 'template.php';

    /**
     * Default template implementation.
     * 
     * It is the default renderer of all the pages if any other renderer is not used.
     */
    class PublicTemplate extends Template
    {

        public function __construct()
        {
            parent::__construct();

            $this->_CI = & get_instance();
            $this->viewPath = "templates/public/";
        }

        public function render($view, array $data = array())
        {

            $this->CI->load->library('session');
            $this->CI->load->library('form_validation');
            $this->CI->load->helper('url');
            $this->CI->load->library('Commonlib');


            $session_data = $this->CI->session->userdata('my_userdata');

            $return_val = $this->CI->load->viewPartial($view, $data);

            $data['template_content'] = $return_val;
            $data['user_id'] = empty($session_data['user_id']) ? '' : $session_data['user_id'];
            $data['user_type'] = empty($session_data['user_type']) ? '' : $session_data['user_type'];


            /// Login User data 
            $user_data = GetLoggedinUserData();
            if (!empty($user_data))
            {
                $userid = $user_data["userid"];
                $outstanding_amount = user_outstanding_amount($userid);
                $data['outstanding_amount'] = my_currency_format($outstanding_amount);
                //$data['outstanding_amount'] = $outstanding_amount.'SEK';
            }

            $association_data = GetLoggedinAssociationData();
            if (!empty($user_data))
            {
                $data['user_data'] = $user_data;
            }
            elseif (!empty($association_data))
            {
                $data['user_data'] = $association_data; //association_outstanding_amount

                $associationId = $association_data["association_id"];
                $outstanding_amount = association_outstanding_amount($associationId);
                $outstanding_gift_amount = association_gift_outstanding_amount($associationId);
                
                $total_outstanding_amount = $outstanding_amount + $outstanding_gift_amount;
              
                $data['association_outstanding_amount'] = my_currency_format($total_outstanding_amount);
            }
            
            
            if(!empty($user_data) && $user_data['usertype']=='Admin'){
                $outstanding_amount = admin_outstanding_amount($userid);
                $data['admin_outstanding_amount'] = my_currency_format($outstanding_amount);
            }


            $css_tags = $this->collectCss("public", isset($data['local_css']) ? $data['local_css'] : array());
            $data['template_css'] = implode("", $css_tags); //implode("\n", $css_tags);
            $script_tags = $this->collectJs("public", isset($data['local_js']) ? $data['local_js'] : array());

            $data['fb_aap_id'] = getCustomConfigItem('fb_app_id');
            $data['fb_app_secret'] = getCustomConfigItem('fb_app_secret');
            if (isset($data['template_title']))
            {
                $data['template_title'] = $data['template_title'];
            }
            $data['template_js'] = implode("", $script_tags); //implode("\n", $script_tags);
            $uri_segment_1 = $this->CI->uri->segment(1);

            $data['uri_segment1'] = $uri_segment_1;

            $data['template_header'] = $this->CI->load->viewPartial($this->viewPath . 'header', $data);

            $data['template_footer'] = $this->CI->load->viewPartial($this->viewPath . 'footer', $data);

            $return_val = $this->CI->load->viewPartial($this->viewPath . $this->masterTemplate, $data);
            return $return_val;
        }

    }
    