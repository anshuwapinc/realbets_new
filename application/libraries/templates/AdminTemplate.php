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
    class AdminTemplate extends Template
    {

        public function __construct()
        {
            parent::__construct();

            $this->_CI = & get_instance();
        }

        public function render($view, array $data = array())
        {
            $return_val = $this->CI->load->viewPartial($view, $data);

            $data['template_content'] = $return_val;
          
            $css_tags = $this->collectCss("admin", isset($data['local_css']) ? $data['local_css'] : array());
            $data['template_css'] = implode("", $css_tags);
            $script_tags = $this->collectJs("admin", isset($data['local_js']) ? $data['local_js'] : array());

            $data['template_js'] = implode("", $script_tags);


            $data['template_title'] = '';
            $this->CI->load->library('session');
            $this->CI->load->library('commonlib');
            $this->CI->load->helper('url');
            // $data['count_users'] = $this->CI->commonlib->get_total_users();
            // // $data['count_city'] = $this->CI->commonlib->get_total_city();
            // $data['count_state'] = $this->CI->commonlib->get_total_state();
            // $data['count_area'] = $this->CI->commonlib->get_total_area();
            // $data['count_emailtemplate'] = $this->CI->commonlib->get_total_emailtemplate();
            // $data['count_category'] = $this->CI->commonlib->get_total_category();
            // $data['count_owner'] = $this->CI->commonlib->get_total_businessowner();
            // $data['count_subcategory'] = $this->CI->commonlib->get_total_subcategory();
            // $data['count_package'] = $this->CI->commonlib->get_total_package();
            // $data['count_rating'] = $this->CI->commonlib->get_total_rating();
            // $data['count_rating'] = $this->CI->commonlib->get_total_rating();
            // $data['count_jobpost'] = $this->CI->commonlib->get_total_jobpost();
            // $data['count_skill'] = $this->CI->commonlib->get_total_skill();
            // $data['count_country'] = $this->CI->commonlib->get_total_country();
            $this->_CI->load->model('PaymentMethods_model');
            $master_id = get_user_id();
            
            $data['request_counts']=$this->_CI->PaymentMethods_model->get_request_counts($master_id);
            $data['uri_segment_2'] = $this->CI->uri->segment(2);
            $data['uri_segment_3'] = $this->CI->uri->segment(3);
            $data["sidebar"] = $this->CI->load->viewPartial($this->viewPath . 'sidebar', $data);
            $data['template_header'] = $this->CI->load->viewPartial($this->viewPath . 'header', $data);
            $data['template_footer'] = $this->CI->load->viewPartial($this->viewPath . 'footer', $data);

            $return_val = $this->CI->load->viewPartial($this->viewPath . $this->masterTemplate, $data);
            return $return_val;
        }

    }
    