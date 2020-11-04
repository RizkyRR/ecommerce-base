<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_reminder extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  private function _sendEmail($type, $data)
  {
    $dataEmail = $this->company_m->getEmail(1);

    $config = [
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => $dataEmail['email'],
      'smtp_pass' => $dataEmail['password'],
      'smtp_port' => 465,
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    ];

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from($dataEmail['email'], $data['company_name']);
    $this->email->to($data['customer_email']);

    if ($type == 'payment') {
      $this->email->subject('Selesaikan_Pembayaran_' . $data['invoice_order']);
      $this->email->message($this->load->view('email-templates/email-customer-order', $data, true));
      $this->email->set_header('Content-Type', 'text/html');
      $this->email->set_mailtype("html");
    } else if ($type == 'cancel') {
      $this->email->subject('Pembatalan_Pesanan_' . $data['invoice_order']);
      $this->email->message($this->load->view('email-templates/email-customer-order', $data, true));
      $this->email->set_header('Content-Type', 'text/html');
      $this->email->set_mailtype("html");
    }

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function getPaymentDue()
  {
    $response = array();

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnpaid();

    if ($dataPayment != null) {
      foreach ($dataPayment as $val) {
        $getOrderID = $val['id_order'];
        $getPurchaseTime = $val['purchase_order_date'];

        if (time() - $getPurchaseTime > (60 * 60 * 24)) {
          $data = [
            'status_order_id' => 1,
          ];

          $this->customerPurchase_m->updateDataPaymentUnpaidByID($getOrderID, $data);
        }
      }

      return $dataPayment;
    }

    echo json_encode($response);
  }

  public function getReminderCancelFromPaymentDue()
  {
    $response = array();

    $dataPayment = $this->customerPurchase_m->getDataPaymentCancel();

    if ($dataPayment != null) {
      foreach ($dataPayment as $val) {
        $getOrderID = $val['id'];
        $email = $val['customer_email'];

        $data = [
          'reminder_cancel' => 1
        ];

        $updatePaymentEmailSend = $this->customerPurchase_m->updateDataPaymentCancelByID($getOrderID, $data);

        // email purposes
        $dataCompany = $this->company_m->getCompanyById(1);
        $info['company'] = $dataCompany;
        $info['company_name'] = $dataCompany['company_name'];
        $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
        $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

        $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($getOrderID, $email);
        $info['data_order'] = $dataOrder;
        $info['invoice_order'] = $dataOrder['invoice_order'];
        $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
        $info['customer_email'] = $dataCustomer['email'];
        $info['customer'] = $dataCustomer;
        $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($getOrderID);

        $this->_sendEmail('cancel', $info);
        // email purposes
      }

      return $dataPayment;
    }

    echo json_encode($response);
  }

  public function getReminderPayment()
  {
    $response = array();

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnsend();

    if ($dataPayment != null) {
      foreach ($dataPayment as $val) {
        $getOrderID = $val['id'];
        $email = $val['customer_email'];

        $data = [
          'reminder_payment' => 1
        ];

        $updatePaymentEmailSend = $this->customerPurchase_m->updateDataPaymentUnsendByID($getOrderID, $data);

        // email purposes
        $dataCompany = $this->company_m->getCompanyById(1);
        $info['company'] = $dataCompany;
        $info['company_name'] = $dataCompany['company_name'];
        $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
        $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

        $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($getOrderID, $email);
        $info['data_order'] = $dataOrder;
        $info['invoice_order'] = $dataOrder['invoice_order'];
        $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
        $info['customer_email'] = $dataCustomer['email'];
        $info['customer'] = $dataCustomer;
        $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($getOrderID);

        $this->_sendEmail('payment', $info);
        // email purposes
      }

      return $dataPayment;
    }

    echo json_encode($response);
  }
}
  
  /* End of file Customer_reminder.php */
