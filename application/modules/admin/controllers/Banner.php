<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Banner_model');

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    public function header_banners()
    {        
        $dataArray = array();
        $dataArray['header_banners'] = $this->Banner_model->get_all_banners();

        $this->load->view('/header-banner-list', $dataArray);
    }

    public function add_header_banner($id = null)
    {
        if (!empty($this->input->post())) {
          
            $id = $this->input->post('id');

            if ($_FILES['header_banner']['name']) {
                
                $config['upload_path']          = 'assets/banner/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 16000;
                $config['file_name']           = date('d-m-Y h:i:s');

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('header_banner')) {
                    $error = array('error' => $this->upload->display_errors());
                    p($error);
       
                }
            }

            if (empty($id)) {
                $dataArray = array(
                    'header_banner_name' => $this->upload->data('file_name'),
                    'status' => 'Active',
                    'site_code' => getCustomConfigItem('site_code'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'created_by' => get_user_id(),
                );
                $this->session->set_flashdata('operation_msg', 'Header Banner Added Successfuly');
                $this->Banner_model->addHeaderBanner($dataArray);
            
                redirect(base_url('add-header-banner'));
            } else {
                $dataArray = array(
                    'id' => $id,
                    'header_banner_name' => $this->upload->data('file_name'),
                    'updated_at' => date('Y-m-d h:i:s'),
                    'updated_by' => get_user_id(),
                );
                $this->session->set_flashdata('operation_msg', 'Header Banner Updated Successfuly');
                $this->Banner_model->addHeaderBanner($dataArray);
            
                redirect(base_url('header-banners'));
            }
        
        } else {

            $dataArray = array();

            if(empty($id))
            {
                $dataArray['form_heading'] = "Add Header banner ";
            }else{
                $dataArray = $this->Banner_model->get_banner_by_id($id);
                $dataArray['form_heading'] = "Edit Header banner ";
                
                
            }
            // p($dataArray);
            $this->load->view('add-banner-form',$dataArray);
        }
       
    }

    public function change_header_banner_status($status,$id)
    {
        $dataArray = array(
            'id' => $id,
            'status'=>$status ,           
            'updated_at' => date('Y-m-d h:i:s'),
            'updated_by' => get_user_id(),
        );

        $this->Banner_model->addHeaderBanner($dataArray);
        $this->session->set_flashdata('operation_msg', 'Header Banner Status Updated Successfuly');
        redirect(base_url('header-banners'));
    }

    public function delete_header_banner($id)
    {
        $this->Banner_model->delete_header_banner($id);
        $this->session->set_flashdata('operation_msg', 'Header Banner Deleted Successfuly');
        redirect(base_url('header-banners'));
    }
}
