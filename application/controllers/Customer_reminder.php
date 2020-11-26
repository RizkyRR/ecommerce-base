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
      $this->email->set_mailtype("html");
    } else if ($type == 'cancel') {
      $this->email->subject('Pembatalan_Pesanan_' . $data['invoice_order']);
      $this->email->message($this->load->view('email-templates/email-customer-order', $data, true));
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

    $dataPaymentRows = $this->customerPurchase_m->getDataPaymentUnpaidByRows();

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnpaid();

    /* $countRow = count($dataPayment);

    for ($i = 0; $i < $countRow; $i++) {

      if ($dataPayment != null) {
        foreach ($dataPayment as $val) {
          $getOrderID = $val['id'];
          $email = $val['customer_email'];
          $getPurchaseTime = $val['purchase_order_date'];

          if (time() - $getPurchaseTime[$i] > (60 * 60 * 24)) {
            $data = [
              'status_order_id' => 1,
            ];

            $this->customerPurchase_m->updateDataPaymentUnpaidByID($getOrderID, $data);
          }
        }
      }
    } */

    /* if(time() - strtotime("2010-06-19 09:39:23") > 60*60*24) {
      // timestamp is older than one day
    } */


    if ($dataPayment != null) {
      foreach ($dataPayment as $val) {
        $getOrderID = $val['id'];

        $order = $this->db->get_where('customer_purchase_orders', ['id' => $getOrderID])->row_array();

        if (time() - $order['purchase_order_date'] > (60 * 60 * 24)) { // SELECT * FROM my_table WHERE timestamp < NOW() - INTERVAL 1 DAY;
          $data = [
            'status_order_id' => 1,
          ];

          $this->customerPurchase_m->updateDataPaymentUnpaidByID($getOrderID, $data);
        }
      }
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
        $info['company_bank'] = '';

        $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($getOrderID, $email);
        $info['data_order'] = $dataOrder;
        $info['invoice_order'] = $dataOrder['invoice_order'];
        $info['purchase_due'] = date('d M Y H:i:s', strtotime($dataOrder['created_date'] . ' +1 day'));
        $info['purchase_date'] = date('d M Y H:i:s', strtotime($dataOrder['created_date']));

        $info['message'] = 'Your payment has been canceled. Please do not pay for this order!';

        $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
        $info['customer_email'] = $dataCustomer['email'];
        $info['customer'] = $dataCustomer;
        $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($getOrderID);

        $this->_sendEmail('cancel', $info);
        // email purposes
      }
    }

    echo json_encode($response);
  }

  public function getReminderPayment()
  {
    $response = array();

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnsend();
    $dataPaymentRows = $this->customerPurchase_m->getDataPaymentUnsendByRows();

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
        $info['purchase_due'] = date('d M Y H:i:s', strtotime($dataOrder['created_date'] . ' +1 day'));
        $info['purchase_date'] = date('d M Y H:i:s', strtotime($dataOrder['created_date']));

        $info['message'] = 'Waiting for payment before ' . date('d M Y H:i:s', strtotime($dataOrder['created_date'] . ' +1 day'));

        $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
        $info['customer_email'] = $dataCustomer['email'];
        $info['customer'] = $dataCustomer;
        $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($getOrderID);

        $this->_sendEmail('payment', $info);
        // email purposes
      }
    }

    echo json_encode($response);
  }
}
  
  /* End of file Customer_reminder.php */
