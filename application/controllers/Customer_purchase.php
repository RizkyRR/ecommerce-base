<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_purchase extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess']);

    if (!$this->session->userdata('customer_email')) {
      redirect('sign-in');
    }
  }

  public function index()
  {
    $info['title'] = "History Customer Order Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    $this->load->view('front-templates/header', $info);
    $this->load->view('front-container/side-menu-customer-section', $info);
    $this->load->view('front-container/customer-history-order-page-section', $info);
    $this->load->view('front-templates/footer', $info);
  }

  public function showPurchaseOrder()
  {
    $email = $this->session->userdata('customer_email');

    $list = $this->customerPurchase_m->getPurchaseOrderDatatables($email);
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_order));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_order;
      $row[] = date('d M Y H:i:s', strtotime($item->created_date));
      $row[] = $item->total_product;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = '<span class="badge badge-' . $item->status_color . '">' . $item->status_name . '</span>';

      // add html for action
      $row[] = '<a href="' . base_url() . 'get-detail-customer-purchase/' . $item->id_order . '" class="btn btn-info btn-sm" title="detail order"><i class="fa fa-info" aria-hidden="true"></i> Info</a>';

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->customerPurchase_m->count_all($email),
      "recordsFiltered" => $this->customerPurchase_m->count_filtered($email),
      "data" => $data,
    );

    // output to json format
    echo json_encode($output);
  }

  public function detailPurchaseOrder($id)
  {
    $info['title'] = "Detail Customer Order Page";

    $email = $this->session->userdata('customer_email');

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);
    $info['count_wishlist'] = $this->product_m->getCountWishlist($email);

    $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($id, $email);
    $info['data_order'] = $dataOrder;
    $info['customer'] = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($id);

    if ($dataOrder != null) {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/customer-history-order-detail-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    } else {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/error-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    }
  }

  public function printPurchaseOrder($id)
  {
    $info['title'] = "Detail Customer Order Page";

    $email = $this->session->userdata('customer_email');

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);
    $info['count_wishlist'] = $this->product_m->getCountWishlist($email);

    $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($id, $email);
    $info['data_order'] = $dataOrder;
    $info['customer'] = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($id);

    if ($dataOrder != null) {
      $this->load->view('front-prints/header', $info);
      $this->load->view('front-prints/print-customer-order', $info);
      $this->load->view('front-prints/footer', $info);
    } else {
      $this->load->view('front-prints/header', $info);
      $this->load->view('front-prints/footer', $info);
    }
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
      $this->email->message($this->load->view('front-email-template/email-customer-order', $data, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'cancel') {
      $this->email->subject('Pembatalan_Pesanan_' . $data['invoice_order']);
      $this->email->message($this->load->view('front-email-template/email-customer-order', $data, true));
      $this->email->set_mailtype("html");
    }

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function cancelPayment()
  {
    $response = array();
    $email = $this->session->userdata('customer_email');
    $order_id = $this->input->post('order_id');

    $data = [
      'status_order_id' => 1,
      'reminder_cancel' => 1
    ];

    $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data);

    if ($updatePaymentDue > 0) {
      $response['status'] = true;
      $response['message'] = 'Sorry, we were unable to proceed with the payment ' . $order_id . ' because you canceled the payment!';
    } else {
      $response['status'] = false;
      $response['message'] = 'Sorry, there was an error regarding the cancel payment!';
    }

    // email purposes
    $dataCompany = $this->company_m->getCompanyById(1);
    $info['company'] = $dataCompany;
    $info['company_name'] = $dataCompany['company_name'];
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

    $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($order_id, $email);
    $info['data_order'] = $dataOrder;
    $info['invoice_order'] = $dataOrder['invoice_order'];
    $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['customer_email'] = $dataCustomer['email'];
    $info['customer'] = $dataCustomer;
    $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($order_id);

    $this->_sendEmail('cancel', $info);
    // email purposes

    echo json_encode($response);
  }

  public function getPaymentDue()
  {
    $response = array();
    $email = $this->session->userdata('customer_email');

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnpaidByEmail($email);

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
    }

    echo json_encode($response);
  }

  public function getReminderCancelFromPaymentDue()
  {
    $response = array();
    $email = $this->session->userdata('customer_email');

    $dataPayment = $this->customerPurchase_m->getDataPaymentCancelByEmail($email);

    if ($email) {
      if ($dataPayment != null) {
        foreach ($dataPayment as $val) {
          $getOrderID = $val['id'];

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
      }
    }

    echo json_encode($response);
  }

  public function getReminderPayment()
  {
    $response = array();
    $email = $this->session->userdata('customer_email');

    $dataPayment = $this->customerPurchase_m->getDataPaymentUnsendByEmail($email);

    if ($email) {
      if ($dataPayment != null) {
        foreach ($dataPayment as $val) {
          $getOrderID = $val['id'];

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
      }
    }

    echo json_encode($response);
  }
}
  
  /* End of file Customer_purchase.php */
