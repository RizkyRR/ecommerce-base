<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();

    $this->load->library('pdfgenerator');
  }

  public function index()
  {
    $info['title'] = "Data Order";

    $company = $this->company_m->getCompanyById(1);
    $info['company_data'] = $company;

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->load->view('back-templates/header', $info);
    $this->load->view('back-templates/topbar', $info);
    $this->load->view('back-templates/navbar', $info);
    $this->load->view('orders/index', $info);
    $this->load->view('modals/modal-payment-approve', $info);
    $this->load->view('modals/modal-delete');
    $this->load->view('back-templates/footer', $info);
  }

  // DataTables Controller Setup
  function show_ajax_order()
  {
    $list = $this->order_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_order));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_order;
      $row[] = $item->customer_email;
      $row[] = $item->customer_name;
      $row[] = date('d M Y H:i:s', strtotime($item->created_date));
      $row[] = $item->total_product;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = '<span class="label label-' . $item->status_color . '">' . $item->status_name . '</span>';

      // CHECKING ORDER APPROVE
      $checkOrderPending = $this->order_m->getCheckPurchaseOrderPending($item->id_order);

      if ($checkOrderPending == true) {
        $btnApprovePayment = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="payment_approve(' . $id . ')" title="approve payment"><i class="fa fa-check" aria-hidden="true"></i> Approve Payment</a> ';
      } else {
        $btnApprovePayment = '';
      }

      // CONDITION FOR SHOW UPDATE BUTTON 
      $checkOrderApproved = $this->order_m->getCheckPurchaseOrderApproved($item->id_order);

      if ($checkOrderApproved == true) {
        $btnUpdatePayment = '<a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="update_approve(' . $id . ')" title="update approvement"><i class="fa fa-check" aria-hidden="true"></i> Update Approvement</a> ';
      } else {
        $btnUpdatePayment = '';
      }

      // CONDITION FOR SHOW CANCEL BUTTON 
      $checkStatusOrer = $this->order_m->getCheckPurchaseOrderCancel($item->id_order);

      if ($checkStatusOrer == true) {
        $btnOrerCancel = '<a href="javascript:void(0)" onclick="cancel_order(' . $id . ')" class="btn btn-danger btn-xs" id="btnCancelOrder" title="cancel order"><i class="fa fa-trash-o"></i> Cancel Order</a> ';
      } else {
        $btnOrerCancel = '';
      }

      // CONDITION FOR COMPLETE THE ORDER 
      $checkStatusOrer = $this->order_m->getCheckPurchaseOrderOnProcess($item->id_order);

      if ($checkStatusOrer == true) {
        $btnOrerComplete = '<a href="javascript:void(0)" onclick="complete_order(' . $id . ')" class="btn btn-success btn-xs" id="btnCompleteOrder" title="complete order"><i class="fa fa-cart-arrow-down"></i> Complete Order</a> ';
      } else {
        $btnOrerComplete = '';
      }

      // add html for action
      $row[] = '<input type="hidden" name="email_customer" id="email_customer" value="' . $item->customer_email . '" readonly><a href="" class="btn btn-info btn-xs" title="detail order"><i class="fa fa-info" aria-hidden="true"></i> Info</a> ' .

        $btnApprovePayment .

        $btnUpdatePayment .

        $btnOrerCancel .

        $btnOrerComplete .

        '<a target="__blank" href="' . base_url('order/print_order/' . $item->id) . '" class="btn btn-default btn-xs" title="print order"><i class="fa fa-print"></i> Print</a>';

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->order_m->count_all(),
      "recordsFiltered" => $this->order_m->count_filtered(),
      "data" => $data,
    );

    // output to json format
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

  // FOR PAYMENT APPROVAL 
  public function getPurchaseOrderForApprove()
  {
    $order_id = $this->input->post('order_id');

    $dataPurchaseOrderForApprove = $this->order_m->getPurchaseOrderForApprove($order_id);
    echo json_encode($dataPurchaseOrderForApprove);
  }

  public function getUpdatePurchaseOrderForApprove()
  {
    $order_id = $this->input->post('order_id');

    $dataPurchaseOrderApproved = $this->order_m->getPurchaseOrderApproved($order_id);
    echo json_encode($dataPurchaseOrderApproved);
  }

  private function _uploadResizeImage()
  {
    $config['upload_path']    = './image/customer_payment/';
    $config['allowed_types']  = 'gif|jpg|png';
    $config['max_size']       = '1024';
    $config['maintain_ratio'] = TRUE;
    $config['quality'] = '90%';
    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
      return $this->upload->data('file_name');
    } else {
      return $this->upload->display_errors();
    }
  }

  private function _uploadUpdateResizeImage()
  {
    $config['upload_path']    = './image/customer_payment/';
    $config['allowed_types']  = 'gif|jpg|png';
    $config['max_size']       = '1024';
    $config['maintain_ratio'] = TRUE;
    $config['quality'] = '90%';
    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image_new')) {
      return $this->upload->data('file_name');
    } else {
      return $this->upload->display_errors();
    }
  }

  private function _setDecreaseStockProduct($order_id)
  {
    $dataPurchaseOrderDetail = $this->order_m->getPurchaseOrderDetail($order_id);

    if ($dataPurchaseOrderDetail != null) {
      foreach ($dataPurchaseOrderDetail as $val) {
        $getProductID = $val['id_product'];
        $getQtyOrder = $val['qty_order_detail'];
        $getQtyProduct = $val['qty_product'];

        // $data_product = $this->product_m->getProductById($this->input->post('product_id')[$i]);
        // $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];
        $qty = (int) $getQtyProduct - (int) $getQtyOrder;

        $update_product = array(
          'qty' => $qty
        );

        $this->product_m->update($getProductID, $update_product);
      }
    }
  }

  public function setPurchaseOrderForApprove()
  {
    $response = array();
    $order_id = $this->input->post('order_id');

    $this->form_validation->set_rules('airwaybill_number', 'Airwaybill number can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $dataPurchaseOrder = [
        'status_order_id' => 3,
        'reminder_cancel' => 1
      ];

      $dataApproval = [
        'purchase_order_id' => $order_id,
        'approve_date' => date('Y-m-d H:i:s'),
        'image' => $this->_uploadResizeImage(),
        'responsible_admin' => $this->session->userdata('email'),
      ];

      $dataShippingOrder = [
        'delivery_receipt_number' => $this->input->post('airwaybill_number')
      ];

      $insert = $this->order_m->insertPaymentApprove($dataApproval);

      if ($insert > 0) {
        // update purchase order
        $this->order_m->updatePurchaseOrderFromApprove($order_id, $dataPurchaseOrder);

        // update purchase order shipping
        $this->order_m->updatePurchaseOrderShipping($order_id, $dataShippingOrder);

        // space for decrease stock from product stock
        $this->_setDecreaseStockProduct($order_id);

        $response['status'] = TRUE;
        $response['message'] = 'Payment has been approved!';
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Failed to accept payment!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function updatePurchaseOrderForApprove()
  {
    $response = array();
    $order_id = $this->input->post('order_id');

    $this->form_validation->set_rules('airwaybill_number', 'Airwaybill number can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      if (empty($_FILES['image_new']['name'])) {
        $data = [
          'responsible_admin' => $this->session->userdata('email')
        ];
      } else {
        $data = [
          'image' => $this->_uploadUpdateResizeImage(),
          'responsible_admin' => $this->session->userdata('email')
        ];

        @unlink('./image/customer_payment/' . $this->input->post('old_image'));
      }

      $dataShippingOrder = [
        'delivery_receipt_number' => $this->input->post('airwaybill_number')
      ];

      $updateShipping = $this->order_m->updatePurchaseOrderShipping($order_id, $dataShippingOrder);

      $updateApproves = $this->order_m->updatePurchaseOrderApprove($order_id, $data);

      if ($updateApproves > 0 || $updateShipping > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'Payment approve has been updated!';
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'There is something wrong, please update again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }
  // FOR PAYMENT APPROVAL 

  // FOR CANCEL PAYMENT BY ADMIN
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

    if ($type == 'complete') {
      $this->email->subject('Pembayaran_' . $data['invoice_order'] . '_Telah_Selesai_Oleh_Admin');
      $this->email->message($this->load->view('front-email-template/email-customer-order', $data, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'cancel') {
      $this->email->subject('Pembatalan_Pesanan_' . $data['invoice_order'] . '_Oleh_Admin');
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
    $email = $this->input->post('email');
    $order_id = $this->input->post('order_id');

    // JIKA TERDETEKSI CANCEL SUDAH MEMBAYAR MAKA ADA KONDISI DIMANA STOCK BARANG DIKEMBALIKAN
    $checkPaymentApproved = $this->order_m->getCheckPaymentApprovedByID($order_id);

    if ($checkPaymentApproved != null) {
      $data = [
        'status_order_id' => 10,
        'reminder_cancel' => 1
      ];

      $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data);

      if ($updatePaymentDue > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the order ' . $order_id . ' and, please confirm the refund!';
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, there was an error regarding the cancel order!';
      }

      $dataPurchaseOrderDetail = $this->order_m->getPurchaseOrderDetail($order_id);

      if ($dataPurchaseOrderDetail != null) {
        foreach ($dataPurchaseOrderDetail as $val) {
          $getProductID = $val['id_product'];
          $getQtyOrder = $val['qty_order_detail'];
          $getQtyProduct = $val['qty_product'];

          // $data_product = $this->product_m->getProductById($this->input->post('product_id')[$i]);
          // $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];
          $qty = (int) $getQtyProduct + (int) $getQtyOrder;

          $update_product = array(
            'qty' => $qty
          );

          $this->product_m->update($getProductID, $update_product);
        }
      }
    } else {
      $data = [
        'status_order_id' => 1,
        'reminder_cancel' => 1
      ];

      $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data);

      if ($updatePaymentDue > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the order ' . $order_id;
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, there was an error regarding the cancel order!';
      }
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
  // FOR CANCEL PAYMENT BY ADMIN

  public function detail_order($id)
  {
    // $id = $this->input->post('id');
    $data = $this->order_m->getProductById($id);
    echo json_encode($data);
  }

  public function update_order()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'order_date',
        'label' => 'order date',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'c_name',
        'label' => 'customer name',
        'rules' => 'trim|required|min_length[5]'
      ],
      [
        'field' => 'c_phone',
        'label' => 'customer phone',
        'rules' => 'trim|required|min_length[7]|max_length[12]|numeric'
      ],
      [
        'field' => 'c_bankname',
        'label' => 'customer bank name',
        'rules' => 'trim|min_length[2]'
      ],
      [
        'field' => 'c_norek',
        'label' => 'customer no. rek',
        'rules' => 'trim|numeric|min_length[5]'
      ],
      [
        'field' => 'c_address',
        'label' => 'customer address',
        'rules' => 'trim|required|min_length[5]'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'order_date' => form_error('order_date'),
        'c_name' => form_error('c_name'),
        'c_phone' => form_error('c_phone'),
        'c_bankname' => form_error('c_bankname'),
        'c_norek' => form_error('c_norek'),
        'c_address' => form_error('c_address')
      ];

      echo json_encode($data);
    } else {

      $data = array(
        'customer_name' => $this->input->post('c_name', true),
        'customer_phone' => $this->input->post('c_phone', true),
        'bank_name' => $this->input->post('c_bankname', true),
        'no_rek' => $this->input->post('c_norek', true),
        'customer_address' => $this->input->post('c_address', true),
        'order_date' => $this->input->post('order_date', true),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_update' => $this->session->userdata('email')
      );
      $this->order_m->update($this->input->post('id'), $data);
      echo json_encode('success');
    }
  }

  public function delete_order()
  {
    // Update to order_details
    $get_order_details = $this->order_m->getOrderDetailsById($this->input->post('id'));
    foreach ($get_order_details as $v) {
      $product_id = $v['product_id'];
      $qty = $v['qty'];

      // get the product
      $product_data = $this->product_m->getProductById($product_id);
      $update_qty = $qty + $product_data['qty'];
      $update_product_data = array('qty' => $update_qty);

      // update product quantity
      $this->product_m->update($product_id, $update_product_data);
    }

    $this->order_m->deleteOrder($this->input->post('id'));
    $this->session->set_flashdata('success', 'Deleted !');
  }

  // public function print_order($id)
  // {
  //   $result = array();
  //   $order_data = $this->order_m->getOrdersById($id);
  //   $data['order'] = $order_data;

  //   /* $getIdProduct = $this->order_m->getOrderDetailsById($order_data['product_id']);

  //   foreach ($getIdProduct as $val) {
  //     $result['order_detail'][] = $val;
  //   }
  //   // foreach ($data_detail['order_detail'] as $val) : 
  //   $data['data_detail'] = $result; */

  //   $data['order_detail'] = $this->order_m->getOrderDetailsById($order_data['product_id']);

  //   $company_info = $this->company_m->getCompanyById(1);
  //   $data['company_data'] = $company_info;
  //   $data['is_vat_enabled'] = ($company_info['vat_charge_value'] > 0) ? true : false;
  //   $data['is_service_enabled'] = ($company_info['service_charge_value'] > 0) ? true : false;

  //   $html = $this->load->view('orders/report-order', $data, true);

  //   $this->pdfgenerator->generate($html, 'report_order_' . $id);
  // }

  public function print_order($id)
  {
    $order_data = $this->order_m->getOrdersById($id);

    $order_detail_data = $this->order_m->getOrderDetailsById($id);

    $company_data = $this->company_m->getCompanyById(1);

    // Checking for discount exist order_data['discount']
    if ($order_data['discount']) {
      $discount  = $order_data['discount'] . '%';
    } else {
      $discount = '-';
    }

    $html = '<!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Screen Printing | Invoice ' . $order_data['id'] . '</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="' . base_url() . 'back-assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="' . base_url() . 'back-assets/bower_components/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="' . base_url() . 'back-assets/bower_components/Ionicons/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="' . base_url() . 'back-assets/dist/css/AdminLTE.min.css">
    
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-globe"></i> ' . $company_data['company_name'] . '.
              <small class="pull-right">Date: ' . date('d M Y', strtotime($order_data['order_date'])) . '</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>' . $company_data['company_name'] . '.</strong><br>
              ' . $company_data['address'] . '<br>
              Phone: ' . $company_data['phone'] . '<br>
              Email: ' . $company_data['business_email'] . '
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            To
            <address>
              <strong>' . $order_data['customer_name'] . '</strong><br>
              ' . $order_data['customer_address'] . '<br>
              Phone: ' . $order_data['customer_phone'] . '<br>
              <!-- Email: john.doe@example.com -->
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice #' . substr($order_data['id'], 5, 8) . '</b><br>
            <br>
            <b>Order ID:</b> ' . $order_data['id'] . '<br>
            <!-- <b>Payment Due:</b> 2/22/2014<br> -->
            <b>Account:</b> 968-34567
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    
        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
              </tr>
              </thead>
              <tbody>';
    foreach ($order_detail_data as $val) {
      $product_data = $this->product_m->getProductById($val['product_id']);

      $html .= '<tr>
                  <td>' . $val['product_id'] . '</td>
                  <td>' . $product_data['product_name'] . '</td>
                  <td>Rp. ' . number_format($val['unit_price'], 0, ',', '.') . '</td>
                  <td>' . $val['qty'] . '</td>
                  <td>Rp. ' . number_format($val['amount'], 0, ',', '.') . '</td>
                </tr>';
    }

    $html .= '</tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>
            <img src="' . base_url() . 'back-assets/dist/img/credit/visa.png" alt="Visa">
            <img src="' . base_url() . 'back-assets/dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="' . base_url() . 'back-assets/dist/img/credit/american-express.png" alt="American Express">
            <img src="' . base_url() . 'back-assets/dist/img/credit/paypal2.png" alt="Paypal">
    
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
              jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p>
          </div>
          <!-- /.col -->
          <div class="col-xs-6">
            <!-- <p class="lead">Amount Due 2/22/2014</p> -->
    
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Gross Amount:</th>
                  <td>Rp. ' . number_format($order_data['gross_amount'], 0, ',', '.') . '</td>
                </tr>';

    if ($order_data['service_charge'] > 0) {
      $html .= '<tr>
                  <th>Service Charge (' . $order_data['service_charge_rate'] . '%):</th>
                  <td>Rp. ' . number_format($order_data['service_charge'], 0, ',', '.') . '</td>
                </tr>';
    }

    if ($order_data['vat_charge'] > 0) {
      $html .= '<tr>
                  <th>Vat Charge (' . $order_data['vat_charge_rate'] . '%):</th>
                  <td>Rp. ' . number_format($order_data['vat_charge'], 0, ',', '.') . '</td>
                </tr>';
    }

    $html .= '<tr>
                  <th>Discount:</th>
                  <td>' . $discount . '</td>
                </tr>';

    $html .= '<tr>
                  <th>Net Amount:</th>
                  <td>Rp. ' . number_format($order_data['net_amount'], 0, ',', '.') . '</td>
                </tr>

                <tr>
                  <th>Paid Status:</th>
                  <td>' . $order_data['paid_status'] . '</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    </body>
    </html>';
    echo $html;
  }
}
  
  /* End of file Order.php */
