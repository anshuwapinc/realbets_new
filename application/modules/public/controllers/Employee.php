<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends My_Controller
{
    private $_employee_listing_headers = 'employee_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Employee_model');
        $this->load->model('Admin_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');
        $this->load->library("Upload");

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }

    public function addemployee($employee_id = null)
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] !== 'admin') {
            redirect('/');
        }


        $this->load->library('form_validation');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('father_name', 'Father Name', 'required|trim');
        $this->form_validation->set_rules('contact_no', 'Contact No.', 'required|trim');
        $this->form_validation->set_rules('guardian_contact_no', 'Guardian Contact No.', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim');
        $this->form_validation->set_rules('experience', 'Working Experience', 'required|trim');
        // $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');


        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'Add Employee';
            $dataArray['form_action'] = current_url();
            if (!empty($employee_id)) {
                $employeeRecord = $this->Employee_model->getEmployeeById($employee_id);
                if (!empty($employeeRecord)) {
                    $dataArray['form_caption'] = 'Edit Employee';
                    $dataArray['employee_id'] = $employeeRecord->employee_id;
                    $dataArray['employee_name'] = $employeeRecord->employee_name;
                    $dataArray['father_name'] = $employeeRecord->father_name;
                    $dataArray['contact_no'] = $employeeRecord->contact_no;
                    $dataArray['whatsapp_no'] = $employeeRecord->whatsapp_no;
                    $dataArray['guardian_contact_no'] = $employeeRecord->guardian_contact_no;
                    $dataArray['email'] = $employeeRecord->email;
                    $dataArray['experience'] = $employeeRecord->experience;
                    $dataArray['last_company'] = $employeeRecord->last_company;
                    $dataArray['monthly_salary'] = $employeeRecord->monthly_salary;
                    $dataArray['address'] = $employeeRecord->address;
                    $dataArray['username'] = $employeeRecord->username;
                }
            } else {
                $postdata = $this->input->post();
                if (!empty($postdata)) {
                    $dataArray = $postdata;
                }
            }

            $dataArray['local_js'] = array(
                'jquery.validate',
                // 'moment',
                // 'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );


            $this->load->view('/employee-form', $dataArray);
        } else {

            $dataValues = array(
                'employee_name' => $this->input->post('employee_name'),
                'father_name' => $this->input->post('father_name'),
                'contact_no' => $this->input->post('contact_no'),
                'whatsapp_no' => $this->input->post('whatsapp_no'),
                'guardian_contact_no' => $this->input->post('guardian_contact_no'),
                'email' => $this->input->post('email'),
                'experience' => $this->input->post('experience'),
                'last_company' => $this->input->post('last_company'),
                'monthly_salary' => $this->input->post('monthly_salary'),
                'address' => $this->input->post('address'),
            );

            if (!empty($this->input->post('employee_id'))) {
                $dataValues['employee_id'] = $this->input->post('employee_id');
            }

            $employee_picture_config = getCustomConfigItem('employee_image');

            if (!empty($_FILES['employee_image']['name'])) {
                if ($this->commonlibrary->is_file_uploaded('employee_image')) {
                    $new_client_image = $this->upload->upload_file("employee_image", $employee_picture_config['upload_path'], $employee_picture_config);
                    $dataValues['employee_image'] = $new_client_image;
                }
            }

            $employee_id = $this->Employee_model->saveEmployee($dataValues);


            if (!empty($employee_id) && !empty($this->input->post('username')) && !empty($this->input->post('password'))) {
                $userDataValues = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'employee_id' => $employee_id,
                    'type' => 'employee',
                    'status' => 'active',
                );


                if (!empty($new_client_image) && isset($new_client_image)) {
                    $userDataValues['image'] = $new_client_image;
                }

                $userDetails = $this->Admin_model->getadminbyusername($this->input->post('username'));

                if (isset($userDetails) && !empty($userDetails)) {
                    $userDataValues['userid'] = $userDetails->userid;
                }
                $user_id = $this->Admin_model->saveadmin($userDataValues);
            }


            if (!empty($dataValues['employee_id'])) {
                $this->session->set_flashdata('message', 'Employee Updated successfully.');
            } else {
                $this->session->set_flashdata('message', 'Employee saved successfully.');
            }
            redirect('admin/employees');
        }
    }



    public function listEmployeedata()
    {
        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_employee_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);

        $resultdata = $this->Employee_model->getAllEmployees($pagingParams);
        $json_output = $this->datatable->get_json_output($resultdata, $this->_employee_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }

    public function listEmployees()
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] !== 'admin') {
            redirect('/');
        }


        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');

        $table_config = array(
            'source' => site_url('admin/Employee/listEmployeedata'),
            'datatable_class' => $this->config->config["datatable_class"],
        );

        $dataArray = array(
            'table' => $this->datatable->make_table($this->_employee_listing_headers, $table_config),
            'message' => $message
        );


        $dataArray['template_title'] = 'List Employee' . ' | ' . $this->lang->line('SITENAME');

        $dataArray['local_css'] = array(
            'dataTables.bootstrap4',
            'responsive.bootstrap4'
        );

        $dataArray['local_js'] = array(
            'dataTables.min',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'dataTables.bootstrap4',
            'dataTables.responsive',
            'responsive.bootstrap4'
        );

        $dataArray['table_heading'] = 'List Employees';
        $dataArray['new_entry_link'] = base_url() . 'admin/addemployee';
        $dataArray['new_entry_caption'] = 'Add Employee';
        // p($dataArray);
        $this->load->view('/employee-list', $dataArray);
    }

    public function deleteEmployee($employee_id)
    {
        $this->Employee_model->deleteEmployeebyid($employee_id);
        $this->Admin_model->deleteadminbyemployeeid($employee_id);

        $this->session->set_flashdata('message', 'Employee delete successfully');
        redirect('admin/employees');
    }





    public function change_employee_status()
    {
        $dataValues = array();
        $id = $this->input->post("id");
        $status = $this->input->post("status");
        $reason = $this->input->post("reason");

        $dataArray = array(
            "employee_id" => $id,
            "is_active" => $status == "1" ? "0" : "1",
            "disable_reason" => $reason,
            "status_update_date" => date('Y-m-d')
        );

        $employee_id = $this->Employee_model->saveEmployee($dataArray);

        if ($status == 1) {
            $dataValues = array(
                "status" => "active",
                "employee_id" => $id
            );
            $this->Admin_model->changeStatusbyemployeeid($dataValues);
        } else {
            $dataValues = array(
                "status" => "deactive",
                "employee_id" => $id
            );
            $this->Admin_model->changeStatusbyemployeeid($dataValues);
        }
        $dataValues['active_id'] = "active_status_" . $employee_id;
        $dataValues['add_class_name'] = $status == "active" ? "fa-toggle-off" : "fa-toggle-on";
        $dataValues['remove_class_name'] = $status == "active" ? "fa-toggle-on" : "fa-toggle-off";
        $dataValues['data_attr'] = ($status == "active") ? "disabled" : "active";
        if (!empty($employee_id)) {
            $dataValues['message'] = "<div class='alert alert-success'>Update Successfully</div>";
        } else {
            $dataValues['message'] = "<div class='alert alert-danger'>Cannot update please try again later</div>";
        }
        echo json_encode($dataValues);
    }

    public function check_username_exists()
    {
        $username = $this->input->post('username');
        return $this->Admin_model->check_party_code_exists($username);
    }


    public function listDeleteEmployeedata()
    {
        $this->load->library('Datatable');
        $arr = $this->config->config[$this->_employee_listing_headers];
        $cols = array_keys($arr);
        $pagingParams = $this->datatable->get_paging_params($cols);

        $resultdata = $this->Employee_model->getAllEmployees($pagingParams);
        $json_output = $this->datatable->get_json_output($resultdata, $this->_employee_listing_headers);
        $this->load->setTemplate('json');
        $this->load->view('json', $json_output);
    }

    public function listDeleteEmployees()
    {
        $this->load->library('Datatable');
        $message = $this->session->flashdata('message');

        $table_config = array(
            'source' => site_url('admin/Employee/listDeleteEmployeedata'),
            'datatable_class' => $this->config->config["datatable_class"],
        );

        $dataArray = array(
            'table' => $this->datatable->make_table($this->_employee_listing_headers, $table_config),
            'message' => $message
        );


        $dataArray['template_title'] = 'List Employee' . ' | ' . $this->lang->line('SITENAME');

        $dataArray['local_css'] = array(
            'dataTables.bootstrap4',
            'responsive.bootstrap4'
        );

        $dataArray['local_js'] = array(
            'dataTables.min',
            'jquery.dataTables.bootstrap',
            'dataTables.fnFilterOnReturn',
            'dataTables.bootstrap4',
            'dataTables.responsive',
            'responsive.bootstrap4'
        );

        $dataArray['table_heading'] = 'List Delete Employees';

        // p($dataArray);
        $this->load->view('/employee-list', $dataArray);
    }

    public function viewemployee($employee_id = null)
    {

        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata) || $userdata['usertype'] !== 'admin') {
            redirect('/');
        }


        $this->load->library('form_validation');
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required|trim');
        $this->form_validation->set_rules('father_name', 'Father Name', 'required|trim');
        $this->form_validation->set_rules('contact_no', 'Contact No.', 'required|trim');
        $this->form_validation->set_rules('guardian_contact_no', 'Guardian Contact No.', 'required|trim');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim');
        $this->form_validation->set_rules('experience', 'Working Experience', 'required|trim');
        // $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');


        $dataArray = array();

        if ($this->form_validation->run() == FALSE) {
            $dataArray['form_caption'] = 'View Employee';
            $dataArray['form_action'] = current_url();
            if (!empty($employee_id)) {
                $employeeRecord = $this->Employee_model->getEmployeeById($employee_id);
                if (!empty($employeeRecord)) {
                    $dataArray['form_caption'] = 'View Employee';
                    $dataArray['employee_id'] = $employeeRecord->employee_id;
                    $dataArray['employee_name'] = $employeeRecord->employee_name;
                    $dataArray['father_name'] = $employeeRecord->father_name;
                    $dataArray['employee_image'] = $employeeRecord->employee_image;

                    $dataArray['contact_no'] = $employeeRecord->contact_no;
                    $dataArray['whatsapp_no'] = $employeeRecord->whatsapp_no;
                    $dataArray['guardian_contact_no'] = $employeeRecord->guardian_contact_no;
                    $dataArray['email'] = $employeeRecord->email;
                    $dataArray['experience'] = $employeeRecord->experience;
                    $dataArray['last_company'] = $employeeRecord->last_company;
                    $dataArray['monthly_salary'] = $employeeRecord->monthly_salary;
                    $dataArray['address'] = $employeeRecord->address;
                    $dataArray['username'] = $employeeRecord->username;
                }
            } else {
                $postdata = $this->input->post();
                if (!empty($postdata)) {
                    $dataArray = $postdata;
                }
            }

            $dataArray['local_js'] = array(
                'jquery.validate',
                // 'moment',
                // 'jquery-ui',
                'select2'
            );
            $dataArray['local_css'] = array(
                'jquery-ui',
                'customstylesheet',
                'select2-bootstrap4-theme',
                'select2'
            );


            $this->load->view('/view-employee-form', $dataArray);
        } else {

            $dataValues = array(
                'employee_name' => $this->input->post('employee_name'),
                'father_name' => $this->input->post('father_name'),
                'contact_no' => $this->input->post('contact_no'),
                'whatsapp_no' => $this->input->post('whatsapp_no'),
                'guardian_contact_no' => $this->input->post('guardian_contact_no'),
                'email' => $this->input->post('email'),
                'experience' => $this->input->post('experience'),
                'last_company' => $this->input->post('last_company'),
                'monthly_salary' => $this->input->post('monthly_salary'),
                'address' => $this->input->post('address'),
            );

            if (!empty($this->input->post('employee_id'))) {
                $dataValues['employee_id'] = $this->input->post('employee_id');
            }

            $employee_picture_config = getCustomConfigItem('employee_image');

            if (!empty($_FILES['employee_image']['name'])) {
                if ($this->commonlibrary->is_file_uploaded('employee_image')) {
                    $new_client_image = $this->upload->upload_file("employee_image", $employee_picture_config['upload_path'], $employee_picture_config);
                    $dataValues['employee_image'] = $new_client_image;
                }
            }

            $employee_id = $this->Employee_model->saveEmployee($dataValues);


            if (!empty($employee_id) && !empty($this->input->post('username')) && !empty($this->input->post('password'))) {
                $userDataValues = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'email' => $this->input->post('email'),
                    'employee_id' => $employee_id,
                    'type' => 'employee',
                    'status' => 'active',
                );


                if (!empty($new_client_image) && isset($new_client_image)) {
                    $userDataValues['image'] = $new_client_image;
                }

                $userDetails = $this->Admin_model->getadminbyusername($this->input->post('username'));

                if (isset($userDetails) && !empty($userDetails)) {
                    $userDataValues['userid'] = $userDetails->userid;
                }
                $user_id = $this->Admin_model->saveadmin($userDataValues);
            }


            if (!empty($dataValues['employee_id'])) {
                $this->session->set_flashdata('message', 'Employee Updated successfully.');
            } else {
                $this->session->set_flashdata('message', 'Employee saved successfully.');
            }
            redirect('admin/employees');
        }
    }
}
