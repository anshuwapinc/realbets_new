<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payments extends My_Controller
{
    private $_user_listing_headers = 'user_listing_headers';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Event_type_model');
        $this->load->model('List_event_model');
        $this->load->model('Deposit_request_model');
        $this->load->model('Withdraw_request_model');
        $this->load->model('PaymentMethods_model');

        $this->load->model('User_model');
        $this->load->model('Admin_model');
        $this->load->model('Ledger_model');
        $this->load->model('Market_type_model');
        $this->load->model('Market_book_odds_fancy_model');
        $this->load->model('Betting_model');
        $this->load->library('commonlibrary');
        $this->load->library('commonlib');
        $this->load->library('session');


        $userdata = $_SESSION['my_userdata'];

        if (empty($userdata)) {
            redirect('/');
        }
    }




    public function addPaymentRequest($request_type = null)
    {
        $user_id = get_user_id();
        $user_detail = $this->User_model->getUserById($user_id);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim');
        if ($request_type == 'Deposit') {
            $this->form_validation->set_rules('reference_code', 'Reference Code', 'required|trim');
        }
        $type_arr =  getCustomConfigItem('account_type');
        if ($request_type == "Withdraw") {
            $type_arr =  getCustomConfigItem('account_type_withdraw');
        }


        if ($this->form_validation->run() == false) {
            // $payment_method = $this->Deposit_request_model->get_payment_method($payment_id);
            // $dataArray =  $payment_method;
            $dataArray['type_arr'] = $type_arr;
            $dataArray['request_type'] = $request_type;

            if ($request_type == 'Deposit') {
                $this->load->view('deposit-request-form', $dataArray);
            } else {
                $withdraw_type = $this->Withdraw_request_model->get_withdraw($user_id);
                $dataArray['withdraw_type'] = $withdraw_type->is_verify;
                // p($withdraw_type);
                $this->load->view('withdraw-request-form', $dataArray);
            }
        } else {
            if ($request_type == 'Withdraw') {
                if ((float)count_total_balance($_SESSION['my_userdata']['user_id']) < $this->input->post('amount')) {
                    $this->session->set_flashdata('user_add_error', 'Sorry You Have Not have Enough Balance ');
                    // $this->load->view('withdraw-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type));
                    redirect(base_url('withdrawuser'));
                    exit;
                }
            }
            if ($request_type == 'Deposit') {
                $checkReferenceIsUnique = $this->Deposit_request_model->checkReferenceIsUnique(array(
                    'reference_code' => $this->input->post('reference_code')
                ));
                if (count($checkReferenceIsUnique) > 0) {
                    $this->session->set_flashdata('user_add_error', 'This reference code is  Already Used ');
                    redirect(base_url('deposituser'));
                    // $this->load->view('deposit-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type));
                    exit;
                }
            }
            $id = $this->input->post('id');
            $request_type = $this->input->post('request_type');

            $already_req = $this->Deposit_request_model->get_pending_requests(array(
                'user_id' => $user_id,
                'type' => $request_type
            ));
            if (count($already_req) > 0) {
                $this->session->set_flashdata('user_add_error', 'Your previous request has not resolved yet!.');

                if ($request_type == 'Deposit') {
                    redirect(base_url('deposituser'));
                    // $this->load->view('deposit-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type));
                } else {
                    redirect(base_url('withdrawuser'));
                    // $this->load->view('withdraw-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type));
                }
                exit;
            }


            if ($request_type == 'Deposit') {

                $type = $this->input->post('type');
                $amount = $this->input->post('amount');
                $reference_code = $this->input->post('reference_code');

                // if ($_FILES['screenshot']['name']) {
                //     // p(APPPATH.'../assets/deposit_screenshot/');
                //     $config['upload_path']          = 'assets/deposit_screenshot/';
                //     $config['allowed_types']        = 'gif|jpg|png';
                //     $config['max_size']             = 16000;
                //     $config['file_name']           = date('d-m-Y h:i:s');

                //     $this->load->library('upload', $config);

                //     if (!$this->upload->do_upload('screenshot')) {
                //         $error = array('error' => $this->upload->display_errors());

                //         $this->load->view('deposit-request-form', array('type_arr' => $type_arr, 'request_type' => $request_type, 'errors' => $error['error']));
                //         // $this->load->view('deposit-request-form', $error['error']);
                //     }
                // }

                // p($this->input->post());
                $dataArray = array(
                    'user_id' => $user_id,
                    'user_name' => $user_detail->user_name,
                    'type' => $type,
                    // 'screenshot_name' => $this->upload->data('file_name'),
                    'amount' => $amount,
                    'reference_code' => $reference_code,
                );
                if ($type == 'Bank') {
                    $dataArray['bank_name'] = $this->input->post('bank_name');
                    $dataArray['account_no'] = $this->input->post('account_no');
                    $dataArray['ifsc_code'] = $this->input->post('ifsc');
                    $dataArray['account_holder_name'] = $this->input->post('account_holder_name');
                } else {
                    $dataArray['account_no'] = $this->input->post('other_account_no');
                    $dataArray['account_holder_name'] = $this->input->post('other_account_holder_name');
                }


                $user_id = $this->Deposit_request_model->addDepositRequest($dataArray);

                // send notification to admin
                $dataArray = array();
                $dataArray["message"] = str_replace("request_message", "Deposit request of " . $amount . " from " . $user_detail->user_name . " ", getCustomConfigItem('deposit_notification_format'));
                $dataArray["number"] = getCustomConfigItem('admin_mobile_number');
                $res = sendNotification($dataArray);
                //notification end

                $this->session->set_flashdata('user_add_msg', ' Deposit request send successfully.');
                redirect(base_url('deposituser'));
            } else  if ($request_type == 'Withdraw') {
                $amount = $this->input->post('amount');
                $number = $this->input->post('account_no');
                // $preffered_method = $this->input->post('preffered_method');
                $type = $this->input->post('type');

                $dataValue['number'] =  $number;
                $withdraw_type = $this->Withdraw_request_model->get_withdraw($user_id);
                // $dataArray['withdraw_type'] = $withdraw_type->is_verify;
                // p($withdraw_type);
                if ($withdraw_type->is_verify == "No") {
                    $otp = $this->input->post('otp');
                    $data = $this->Admin_model->getSavedOtp($dataValue);
                    if ($data->otp != $otp) {
                        $this->session->set_flashdata('user_add_error', ' Wrong Otp Please Fill Again.');
                        redirect('withdrawuser');
                    }
                }


                if ($type == 'Bank') {

                    $dataArray = array(
                        'user_id' => $user_id,
                        'user_name' => $user_detail->user_name,
                        'type' => $type,
                        'bank_name' => $this->input->post('bank_name'),
                        'account_no' => $this->input->post('bank_account_no'),
                        'ifsc_code' => $this->input->post('ifsc'),
                        'account_holder_name' => $this->input->post('bank_account_holder_name'),
                        'amount' => $amount,
                    );
                } else {
                    $update_arr = array(
                        'user_id' => $user_id,
                        'is_verify' => 'Yes'
                    );
                    $withdraw_type = $this->Withdraw_request_model->update_withdraw($update_arr);

                    $dataArray = array(
                        'user_id' => $user_id,
                        'user_name' => $user_detail->user_name,
                        'type' => $type,
                        'account_no' => $this->input->post('account_no'),
                        'account_holder_name' => $this->input->post('account_holder_name'),
                        'amount' => $amount,
                    );
                }


                $insert_id = $this->Withdraw_request_model->addWithdrawRequest($dataArray);
                $withdraw_refrence_id = 'w' . '_' . $insert_id;
                $this->confirm_withdraw($withdraw_refrence_id, $user_id, $amount);
                $this->session->set_flashdata('user_add_msg', ' Withdraw Applied.');
                // $this->session->set_flashdata('user_add_msg', ' Withdraw request send successfully.');

                // send notification to admin
                $dataArray = array();
                $dataArray["message"] = str_replace("request_message", "withdraw request of " . $amount . " from " . $user_detail->user_name . " ", getCustomConfigItem('withdraw_notification_format'));
                $dataArray["number"] = getCustomConfigItem('admin_mobile_number');
                $res = sendNotification($dataArray);
                //notification end

                redirect(base_url('withdrawuser'));
            }






            // redirect(current_url());
        }
    }

    public function online_bank_transfer()
    {
        $this->load->view('online-bank-transfer');
    }

    public function get_payment_detail()
    {

        $user_id = get_user_id();
        $master_id = get_master_id();
        $type = $this->input->post('type');
        $dataArray = array();
        $result = $this->PaymentMethods_model->get_payment_detail($master_id, $type);


        echo json_encode($result);
    }



    public function paymentMethods()
    {
        $user_id = get_user_id();
        $dataArray = array();
        $payment_methods = $this->PaymentMethods_model->get_payment_methods($user_id);
        $dataArray['payment_methods'] = $payment_methods;
        // p($payment_methods);
        // p($dataArray);
        $this->load->view('/payment-methods', $dataArray);
    }

    public function addPaymentMethod($payment_id = null)
    {
        $user_id = get_user_id();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type', 'Account Type', 'required|trim');
        // $this->form_validation->set_rules('account_number', 'account_number', 'required|trim');


        $type_arr =  getCustomConfigItem('account_type');




        if ($this->form_validation->run() == false) {
            $payment_method = $this->PaymentMethods_model->get_payment_method($payment_id);
            if ($payment_method) {
                $dataArray['id'] = $payment_method->id;
                $dataArray['type'] = $payment_method->type;
                $dataArray['user_id'] = $payment_method->user_id;
                if ($dataArray['type'] == 'Bank') {
                    $dataArray['account_holder_name'] = $payment_method->account_holder_name;
                    $dataArray['account_number'] = $payment_method->account_number;
                    $dataArray['ifsc'] = $payment_method->ifsc_code;
                    $dataArray['bank_name'] = $payment_method->vendor;
                } else {
                    $dataArray['other_account_holder_name'] = $payment_method->account_holder_name;
                    $dataArray['other_account_no'] = $payment_method->account_number;
                }
            }
            $dataArray['type_arr'] = $type_arr;

            $this->load->view('addPaymentMethod', $dataArray);
        } else {
            $id = $this->input->post('id');
            $type = $this->input->post('type');
            $account_number = $this->input->post('account_number');
            $vendor = $this->input->post('bank_name');
            $account_holder_name = $this->input->post('account_holder_name');
            $ifsc_code = $this->input->post('ifsc');

            if ($type == 'Bank') {
                $dataArray = array(
                    'user_id' => $user_id,
                    'type' => $type,
                    'account_number' => $account_number,
                    'vendor' => $vendor,
                    'account_holder_name' => $account_holder_name,
                    'ifsc_code' => $ifsc_code,

                );
            } else {
                $dataArray = array(
                    'user_id' => $user_id,
                    'type' => $type,
                    'account_number' => $this->input->post('other_account_no'),
                    'account_holder_name' => $this->input->post('other_account_holder_name'),
                );
            }

            if (!empty($id)) {
                $dataArray['id'] = $id;
            }

            $user_id = $this->PaymentMethods_model->addPaymentMethod($dataArray);
            if (empty($id)) {
                $this->session->set_flashdata('user_add_msg', ' Payment method saved successfully.');
                redirect(current_url());
            } else {
                $this->session->set_flashdata('operation_msg', ' Payment method Updated successfully.');
                redirect(base_url('payment-methods'));
            }
        }
    }

    public function deletePaymentMethod($payment_id)
    {
        $this->PaymentMethods_model->deletePaymentMethod($payment_id);
        $this->session->set_flashdata('operation_msg', ' Payment method deleted successfully.');
        redirect(base_url('payment-methods'));
    }

    public function changePaymentMethodStatus($status, $payment_id)
    {
        $dataArray = array(
            'id' => $payment_id,
            'status' => $status
        );
        $user_id = $this->PaymentMethods_model->addPaymentMethod($dataArray);
        if ($status == "Active") {
            $msg = "activated";
        } else {
            $msg = "deactivated";
        }
        $this->session->set_flashdata('operation_msg', ' Payment method ' . $msg . ' successfully.');
        redirect(base_url('payment-methods'));
    }
    public function depositRequests()
    {
        $user_id = get_user_id();
        $dataArray = array();
        $deposit_requests = $this->Deposit_request_model->get_deposit_requests($user_id);

        $dataArray['deposit_requests'] = $deposit_requests;

        $this->load->view('/deposit-requests', $dataArray);
    }

    public function withdrawRequests()
    {
        $user_id = get_user_id();
        $dataArray = array();
        $deposit_requests = $this->Withdraw_request_model->get_withdraw_requests($user_id);
        // p($deposit_requests);

        $dataArray['deposit_requests'] = $deposit_requests;
        // p($dataArray);
        $this->load->view('/withdraw-requests', $dataArray);
    }

    public function changeWithdrawRequestStatus($status, $id, $remark)
    {

        $dataArray = array(
            'id' => $id,
            'status' => $status,
            'remark' => str_replace("-", " ", $remark)
        );
        $user_id = $this->Withdraw_request_model->addWithdrawRequest($dataArray);

        if ($status == "Reject") {
            $withdraw_refrence_id = 'w' . '_' . $id;
            $this->Ledger_model->cancel_widthraw_request($withdraw_refrence_id);
        }

        $this->session->set_flashdata('operation_msg', 'Request ' . $status . ' successfully');
        redirect(base_url('withdraw-requests'));
    }


    public function changeDepositRequestStatus($status, $id, $remark)
    {
        $dataArray = array(
            'id' => $id,
            'status' => $status,
            'remark' => str_replace("-", " ", $remark)
        );
        $user_id = $this->Deposit_request_model->addDepositRequest($dataArray);

        $this->session->set_flashdata('operation_msg', 'Request ' . $status . ' successfully');
        redirect(base_url('deposit-requests'));
    }

    public function confirm_withdraw($withdraw_refrence_id, $user_id, $ChipsValue)
    {
        $user_id = $user_id;
        $user = $this->User_model->getUserById($user_id);
        $user_name = $user->name;
        $master_id = $user->master_id;
        $withdraw = $ChipsValue;

        $dataArray = array(
            'user_id' => $user_id,
            'deposit_withdraw_reference_id' => $withdraw_refrence_id,
            'transaction_type' => 'debit',
            'amount' => $withdraw,
            'sender_id' => $user_id,
            'receiver_id' => $master_id
        );
        // p($dataArray);
        $this->Ledger_model->addLedger($dataArray);

        $dataArray = array(
            'user_id' => $master_id,
            'transaction_type' => 'credit',
            'deposit_withdraw_reference_id' => $withdraw_refrence_id,
            'amount' => $withdraw,
            'sender_id' => $master_id,
            'receiver_id' => $user_id
        );
        $this->Ledger_model->addLedger($dataArray);
    }

    public function cancelWithdrawRequestStatus($id)
    {

        $dataArray = array(
            'id' => $id,
            'status' => 'Cancel',
            'remark' => 'Canceled'
        );
        // p($dataArray);
        $user_id = $this->Withdraw_request_model->addWithdrawRequest($dataArray);

        $withdraw_refrence_id = 'w' . '_' . $id;
        $this->Ledger_model->cancel_widthraw_request($withdraw_refrence_id);

        $this->session->set_flashdata('user_add_msg', 'Request Cancel successfully');
        redirect(base_url('withdrawuser'));
    }
}
