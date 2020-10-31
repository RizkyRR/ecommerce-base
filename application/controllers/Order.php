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
    $this->load->view('modals/modal-detail-order');
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
        $btnApprovePayment = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="payment_approve(' . $id . ')" id="btnModalPaymentApprove" title="approve payment"><i class="fa fa-check" aria-hidden="true"></i> Approve Payment</a> ';
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

      // CONDITION FOR SHOW APPROVED DETAIL AFTER COMPLETE ORDER 
      $checkOrderComplete = $this->order_m->getCheckPurchaseOrderComplete($item->id_order);

      if ($checkOrderComplete == true) {
        $btnDetailApproved = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="detail_approve(' . $id . ')" title="approved detail"><i class="fa fa-check" aria-hidden="true"></i> Approved Detail</a> ';
      } else {
        $btnDetailApproved = '';
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

      // ADD HTML BUTTON ACTION
      $row[] = '<input type="hidden" name="email_customer" id="email_customer_' . $item->id_order . '" value="' . $item->customer_email . '" readonly><a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="detail_order(' . $id . ')" id="btnDetailOrder" title="detail order"><i class="fa fa-info" aria-hidden="true"></i> Info</a> ' .

        $btnApprovePayment .

        $btnUpdatePayment .

        $btnDetailApproved .

        $btnOrerCancel .

        $btnOrerComplete .

        '<a href=" ' . base_url() . 'order/printOrder/' . $item->id_order . '/' . $item->customer_email . '" target="__blank" class="btn btn-default btn-xs" id="btnPrintOrder" title="print order"><i class="fa fa-print"></i> Print Order</a>';

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->order_m->count_all(),
      "recordsFiltered" => $this->order_m->count_filtered(),
      "data" => $data,
    );

    // OUTPUT TO JSON FORMAT
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

    if ($type == 'approve') {
      $this->email->subject('Pembayaran_' . $data['invoice_order'] . '_Telah_Selesai_Oleh_Admin');
      $this->email->message($this->load->view('front-email-template/email-customer-order', $data, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'complete') {
      $this->email->subject('Pesanan_' . $data['invoice_order'] . '_Telah_Selesai_Oleh_Admin');
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

  public function setPurchaseOrderForApprove()
  {
    $response = array();
    $order_id = $this->input->post('order_id');
    $email = $this->input->post('customer_email');

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

        $this->_sendEmail('approve', $info);
        // email purposes
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
  public function cancelPayment()
  {
    $response = array();
    $email = $this->input->post('email');
    $order_id = $this->input->post('order_id');

    // JIKA TERDETEKSI CANCEL SUDAH MEMBAYAR MAKA ADA KONDISI DIMANA STOCK BARANG DIKEMBALIKAN
    $checkPaymentApproved = $this->order_m->getCheckPaymentApprovedByID($order_id);

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
    // email purposes

    if ($checkPaymentApproved != null) {

      $data = [
        'status_order_id' => 10,
        'reminder_cancel' => 1
      ];

      $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data); // karena memiliki table yang sama maka hiraukan nama

      if ($updatePaymentDue > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the order ' . $order_id . ' and, please confirm the refund!';

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

        $this->_sendEmail('cancel', $info);
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, there was an error regarding the cancel order!';
      }
    } else {
      $data = [
        'status_order_id' => 1,
        'reminder_cancel' => 1
      ];

      $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data); // karena memiliki table yang sama maka hiraukan nama

      if ($updatePaymentDue > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the order ' . $order_id;

        $this->_sendEmail('cancel', $info);
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, there was an error regarding the cancel order!';
      }
    }

    echo json_encode($response);
  }
  // FOR CANCEL PAYMENT BY ADMIN

  // COMPLETE ORDER
  public function completeOrder()
  {
    $response = array();
    $email = $this->input->post('email');
    $order_id = $this->input->post('order_id');

    $data = [
      'status_order_id' => 4
    ];

    $updatePaymentDue = $this->customerPurchase_m->updateDataPaymentUnpaidByID($order_id, $data);

    if ($updatePaymentDue > 0) {
      $response['status'] = true;
      $response['message'] = 'Congratulations the order ' . $order_id . ' process has been completed!';

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

      $this->_sendEmail('complete', $info);
      // email purposes
    } else {
      $response['status'] = false;
      $response['message'] = 'Sorry, there was an error regarding the complete order!';
    }

    echo json_encode($response);
  }
  // COMPLETE ORDER

  // DETAIL ORDER
  public function getDetailCustomerOrder()
  {
    $response = array();
    $order_id = $this->input->post('order_id');
    $email = $this->input->post('email');

    $company = $this->company_m->getCompanyById(1);
    $company_address = $this->company_m->getFullAdressCustomer(1);
    $company_bank = $this->company_m->getCompanyBankAccount(1);

    $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($order_id, $email);
    $customer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $detail_order = $this->customerPurchase_m->getDetailPurchaseOrderByID($order_id);

    $html = '';

    if ($dataOrder != null) {
      $html .= '
      <div class="box-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <h6 class="mb-3">From:</h6>
            <div>
              <strong>' . $company['company_name'] . '</strong>
            </div>
            <div>' . $company_address['street_name'] . ', ' . $company_address['city_name'] . ', ' . $company_address['province'] . '</div>
            <div>Email: ' . $company['business_email'] . '</div>
            <div>Phone: ' . $company['phone'] . '</div>';

      if ($company_bank != null) {
        foreach ($company_bank as $val) {
          $html .= '<div><strong>' . $val['bank_name'] . ': ' . $val['account'] . ' (' . $val['account_holder_name'] . ')</strong></div>';
        }
      }
      $html .= '</div>

          <div class="col-sm-6">
            <h6 class="mb-3">To:</h6>
            <div>
              <strong>' . $customer['customer_name'] . '</strong>
            </div>
            <div>' . $customer['street_name'] . ', ' . $customer['city_name'] . ', ' . $customer['province'] . '</div>
            <div>Email: ' . $customer['email'] . '</div>
            <div>Phone: ' . $customer['customer_phone'] . '</div>
          </div>
        </div>

        <div class="table-responsive-sm">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="center">#</th>
                <th>Item Name</th>
                <th>Weight</th>
                <th class="right">Price</th>
                <th class="center">Qty</th>
                <th class="right">Total</th>
              </tr>
            </thead>
            <tbody>';

      if ($detail_order != null && $detail_order != 0) {
        $no = 1;
        foreach ($detail_order as $val) {
          $html .= '<tr>
                    <td class="center">' . $no++ . '</td>

                    <td class="left strong">' . $val['product_name'] . '</td>

                    <td class="center">' . $val['weight_order'] . ' Gram</td>
                    <td class="right">Rp. ' . number_format($val['price'], 0, ',', '.') . '</td>
                    <td class="center">' . $val['qty_order'] . '</td>
                    <td class="right">Rp. ' . number_format($val['amount'], 0, ',', '.') . '</td>
                  </tr>';
        }
      }

      $html .= '</tbody>
          </table>
        </div>
        <div class="row">
        <div class="col-xs-6 ml-auto"></div>

          <div class="col-xs-6 ml-auto">
            <table class="table table-clear">
              <tbody>
                <tr>
                  <td class="left">
                    <strong>Sub-total</strong>
                  </td>
                  <td class="right">Rp. ' . number_format($dataOrder['gross_amount'], 0, ',', '.') . '</td>
                </tr>';

      if ($dataOrder['ship_amount'] != null && $dataOrder['ship_amount'] != 0) {
        $html .= '<tr>
                    <td class="left">
                      <strong>Shipping cost</strong>
                    </td>
                    <td class="right">Rp. ' . number_format($dataOrder['ship_amount'], 0, ',', '.') . '  (' . $dataOrder['courier'] . ' - ' . $dataOrder['service'] . ')</td>
                  </tr>';
      }

      $html .= '<tr>
                  <td class="left">
                    <strong>VAT (' . $dataOrder['vat_charge_rate'] . '%)</strong>
                  </td>
                  <td class="right">Rp. ' . number_format($dataOrder['vat_charge_val'], 0, ',', '.') . '</td>
                </tr>';

      if ($dataOrder['coupon_charge_rate'] != null && $dataOrder['coupon_charge_rate'] != 0) {
        $html .= '<tr>
                    <td class="left">
                      <strong>Coupon (' . $dataOrder['coupon_charge_rate'] . '%)</strong>
                    </td>
                    <td class="right">Rp. ' . number_format($dataOrder['coupon_charge'], 0, ',', '.') . '</td>
                  </tr>';
      }

      $html .= '<tr>
                  <td class="left">
                    <strong>Total</strong>
                  </td>
                  <td class="right">
                    <strong>Rp. ' . number_format($dataOrder['net_amount'], 0, ',', '.') . '</strong>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>

      </div>';
    } else {
      $response['html'] = [];
    }

    $response['html'] = $html;
    $response['invoice'] = $dataOrder['invoice_order'];
    echo json_encode($response);
  }
  // DETAIL ORDER

  public function printOrder($order_id, $email)
  {
    $info['title'] = "Print Customer Order Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

    $dataOrder = $this->customerPurchase_m->getDataPurchaseOrderByID($order_id, $email);
    $getUnixTime = $dataOrder['purchase_order_date'] + 86400;
    $info['order_date'] = date('d M Y H:i:s', $dataOrder['purchase_order_date']);
    $info['order_date_due'] = date('d M Y H:i:s', $getUnixTime);
    $info['data_order'] = $dataOrder;
    $info['customer'] = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['detail_order'] = $this->customerPurchase_m->getDetailPurchaseOrderByID($order_id);

    if ($dataOrder != null) {
      $this->load->view('back-prints/header', $info);
      $this->load->view('back-prints/print-customer-order', $info);
      $this->load->view('back-prints/footer', $info);
    } else {
      $this->load->view('back-prints/header', $info);
      $this->load->view('back-prints/footer', $info);
    }
  }
}
  
  /* End of file Order.php */
