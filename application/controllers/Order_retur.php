<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order_retur extends CI_Controller
{
  private $url = "https://api.rajaongkir.com/starter/";
  private $apiKey = "9a7210468b5c06925a600b0c0404af50";

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();

    $this->load->library('pdfgenerator');
  }

  public function index()
  {
    $info['title'] = "Data Retur Order";

    $company = $this->company_m->getCompanyById(1);
    $info['company_data'] = $company;
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->load->view('back-templates/header', $info);
    $this->load->view('back-templates/topbar', $info);
    $this->load->view('back-templates/navbar', $info);
    $this->load->view('retur_orders/index', $info);
    $this->load->view('modals/modal-return-approve', $info);
    $this->load->view('modals/modal-detail-return');
    $this->load->view('back-templates/footer', $info);
  }

  // DataTables Controller Setup
  function show_ajax_retur()
  {
    $list = $this->returOrder_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_return));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_return;
      $row[] = $item->invoice_order;
      $row[] = $item->customer_email;
      $row[] = $item->customer_name;
      $row[] = date('d M Y H:i:s', strtotime($item->purchase_return_date));
      $row[] = $item->total_product;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = '<span class="label label-' . $item->status_color . '">' . $item->status_name . '</span>';

      // SHOW BUTTON APPROVE RETURN SETELAH TAMBAH RETURN
      $dataStatusPendingForApprove = $this->returOrder_m->getReturnStatusPendingForApproveByID($item->id_return); // BY ID DAN STATUS ORDER 5 (PENDING)

      if ($dataStatusPendingForApprove == true) {
        $btnApproveReturn = '<a href="javascript:void(0)" onclick="approve_return(' . $id . ')" class="btn btn-success btn-xs" id="btnApproveReturn_' . $item->id_return . '" title="approve return"><i class="fa fa-check"></i> Approve Return</a> ';
      } else {
        $btnApproveReturn = '';
      }

      // SHOW BUTTON CANCEL SETELAH TAMBAH RETURN SAMPAI DATA APPROVED
      $dataStatusPendingForCancel = $this->returOrder_m->getReturnStatusPendingForCancelByID($item->id_return); // BY ID DAN STATUS ORDER 5 (PENDING)

      if ($dataStatusPendingForCancel['status_order_id'] == 5 || $dataStatusPendingForCancel['status_order_id'] == 6) {
        $btnCancelReturn = '<a href="javascript:void(0)" onclick="cancel_return(' . $id . ')" class="btn btn-danger btn-xs" id="btnCancelReturn_' . $item->id_return . '" title="cancel return"><i class="fa fa-ban"></i> Cancel</a> ';
      } else {
        $btnCancelReturn = '';
      }

      // SHOW BUTTON UPDATE APPROVE SETELAH APPROVE RETURN SELESAI
      $dataStatusProcess = $this->returOrder_m->getReturnStatusProcessByID($item->id_return); // BY ID DAN STATUS ORDER 6 (ON PROCESS)

      if ($dataStatusProcess == true) {
        $btnUpdateApproveReturn = '<a href="javascript:void(0)" onclick="update_approved_return(' . $id . ')" class="btn btn-warning btn-xs" id="btnUpdateApproveReturn_' . $item->id_return . '" title="update approved return"><i class="fa fa-exclamation-triangle"></i> Update Approved</a> ';
      } else {
        $btnUpdateApproveReturn = '';
      }

      // SHOW BUTTON COMPLETE APPROVE SETELAH APPROVE RETURN SELESAI
      if ($dataStatusProcess == true) {
        $btnApprovedCompleteReturn = '<a href="javascript:void(0)" onclick="complete_return(' . $id . ')" class="btn btn-success btn-xs" id="btnCompleteReturn_' . $item->id_return . '" title="complete return"><i class="fa fa-check"></i> Complete Return</a> ';
      } else {
        $btnApprovedCompleteReturn = '';
      }

      // SHOW BUTTON DETAIL APPROVE SETELAH RETURN SELESAI
      $dataStatusSuccess = $this->returOrder_m->getReturnStatusSuccessByID($item->id_return); // BY ID DAN STATUS ORDER 7 (SUCCESS)

      if ($dataStatusSuccess != null && ($dataStatusSuccess['status_order_id'] == 1 || $dataStatusSuccess['status_order_id'] == 7 || $dataStatusSuccess['status_order_id'] == 10)) {
        $btnApprovedDetailReturn = '<a href="javascript:void(0)" onclick="detail_approved_return(' . $id . ')" class="btn btn-success btn-xs" title="detail approved return"><i class="fa fa-check"></i> Detail Approved</a> ';
      } else {
        $btnApprovedDetailReturn = '';
      }

      // add html for action
      $row[] = '<input type="hidden" name="email_customer" id="email_customer_' . $item->id_return . '" value="' . $item->customer_email . '" readonly><a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="detail_return(' . $id . ')" id="btnDetailReturn_' . $item->id_return . '" title="detail return"><i class="fa fa-info" aria-hidden="true"></i> Info</a> ' .

        $btnApproveReturn .

        $btnUpdateApproveReturn .

        $btnCancelReturn .

        $btnApprovedCompleteReturn .

        $btnApprovedDetailReturn .

        '<a target="__blank" href="' . base_url() . 'order_retur/printReturn/' . $item->id_return . '/' . $item->customer_email . '" rel="noreferrer noopener" id="btnPrintReturn_' . $item->id_return . '" class="btn btn-default btn-xs" title="print return"><i class="fa fa-print"></i> Print</a>';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->returOrder_m->count_all(),
      "recordsFiltered" => $this->returOrder_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

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
      $this->email->subject('Order_Return_' . $data['invoice_return'] . '_Diproses_Oleh_Admin');
      $this->email->message($this->load->view('email-templates/email-customer-return', $data, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'complete') {
      $this->email->subject('Order_Return_' . $data['invoice_return'] . '_Telah_Selesai_Oleh_Admin');
      $this->email->message($this->load->view('email-templates/email-customer-return', $data, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'cancel') {
      $this->email->subject('Pembatalan_Return_' . $data['invoice_return'] . '_Oleh_Admin');
      $this->email->message($this->load->view('email-templates/email-customer-return', $data, true));
      $this->email->set_mailtype("html");
    }

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  private function _uploadResizeImage()
  {
    $config['upload_path']    = './image/customer_return/';
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
    $config['upload_path']    = './image/customer_return/';
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

  // FOR APPROVE RETURN MODAL
  public function getPurchaseReturnForApprove()
  {
    $return_id = $this->input->post('return_id');

    $dataPurchaseReturnForApprove = $this->returOrder_m->getPurchaseReturnForApprove($return_id);
    echo json_encode($dataPurchaseReturnForApprove);
  }

  public function setPurchaseReturnForApprove()
  {
    $response = array();
    $return_id = $this->input->post('return_id');
    $email = $this->input->post('customer_email');

    $this->form_validation->set_rules('airwaybill_number', 'Airwaybill number can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $dataPurchaseReturn = [
        'status_order_id' => 6,
        'reminder_process' => 1
      ];

      $dataApproval = [
        'purchase_return_id' => $return_id,
        'approve_date' => date('Y-m-d H:i:s'),
        'image' => $this->_uploadResizeImage(),
        'responsible_admin' => $this->session->userdata('email'),
      ];

      $dataShippingReturn = [
        'delivery_receipt_number' => $this->input->post('airwaybill_number')
      ];

      $insert = $this->returOrder_m->insertPaymentApprove($dataApproval);

      if ($insert > 0) {
        // update order return
        $this->returOrder_m->updatePurchaseReturnFromApprove($return_id, $dataPurchaseReturn);

        // update order return shipping
        $this->returOrder_m->updatePurchaseReturnShipping($return_id, $dataShippingReturn);

        // DECREASE STOCK IN STOCK PRODUCT 
        $dataPurchaseReturnDetail = $this->returOrder_m->getCustomerReturnProductByID($return_id);

        if ($dataPurchaseReturnDetail != null) {
          foreach ($dataPurchaseReturnDetail as $val) {
            $getProductID = $val['id_product'];
            $getQtyOrder = $val['qty_order'];
            $getQtyProduct = $val['qty_product'];

            $qty = (int) $getQtyProduct - (int) $getQtyOrder;

            $update_product = array(
              'qty' => $qty
            );

            $this->product_m->update($getProductID, $update_product);
          }
        }

        $response['status'] = TRUE;
        $response['message'] = 'Return has been approved!';

        // email purposes
        $dataCompany = $this->company_m->getCompanyById(1);
        $info['company'] = $dataCompany;
        $info['company_name'] = $dataCompany['company_name'];
        $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
        $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

        $dataReturn = $this->customerPurchase_m->getDataPurchaseReturnByID($return_id, $email);
        $info['data_return'] = $dataReturn;
        $info['invoice_return'] = $dataReturn['invoice_return'];
        $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
        $info['customer_email'] = $dataCustomer['email'];
        $info['customer'] = $dataCustomer;
        $info['detail_return'] = $this->customerPurchase_m->getDetailPurchaseReturnByID($return_id);

        $this->_sendEmail('approve', $info);
        // email purposes
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Failed to accept return order!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function getUpdatePurchaseReturnForApprove()
  {
    $return_id = $this->input->post('return_id');

    $dataPurchaseReturnApproved = $this->returOrder_m->getPurchaseReturnApproved($return_id);
    echo json_encode($dataPurchaseReturnApproved);
  }

  public function updatePurchaseReturnForApprove()
  {
    $response = array();
    $return_id = $this->input->post('return_id');

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

        @unlink('./image/customer_return/' . $this->input->post('old_image'));
      }

      $dataShippingReturn = [
        'delivery_receipt_number' => $this->input->post('airwaybill_number')
      ];

      $updateShipping = $this->returOrder_m->updatePurchaseReturnShipping($return_id, $dataShippingReturn);

      $updateApproves = $this->returOrder_m->updatePurchaseReturnApprove($return_id, $data);

      if ($updateApproves > 0 || $updateShipping > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'Return order approve has been updated!';
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

  public function completeReturn()
  {
    $response = array();
    $email = $this->input->post('email');
    $return_id = $this->input->post('return_id');

    $data = [
      'status_order_id' => 7,
      'reminder_complete' => 1
    ];

    $updateCustomerReturn = $this->customerPurchase_m->updateDataCustomerReturnByID($return_id, $data);

    if ($updateCustomerReturn > 0) {
      $response['status'] = true;
      $response['message'] = 'Congratulations the order return ' . $return_id . ' process has been completed!';

      // email purposes
      $dataCompany = $this->company_m->getCompanyById(1);
      $info['company'] = $dataCompany;
      $info['company_name'] = $dataCompany['company_name'];
      $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
      $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

      $dataReturn = $this->customerPurchase_m->getDataPurchaseReturnByID($return_id, $email);
      $info['data_return'] = $dataReturn;
      $info['invoice_return'] = $dataReturn['invoice_return'];
      $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
      $info['customer_email'] = $dataCustomer['email'];
      $info['customer'] = $dataCustomer;
      $info['detail_return'] = $this->customerPurchase_m->getDetailPurchaseReturnByID($return_id);

      $this->_sendEmail('complete', $info);
      // email purposes
    } else {
      $response['status'] = false;
      $response['message'] = 'Sorry, there was an error regarding the complete return!';
    }

    echo json_encode($response);
  }

  public function getDetailCustomerReturn()
  {
    $response = array();
    $return_id = $this->input->post('return_id');
    $email = $this->input->post('email');

    $company = $this->company_m->getCompanyById(1);
    $company_address = $this->company_m->getFullAdressCustomer(1);
    $company_bank = $this->company_m->getCompanyBankAccount(1);

    $dataReturn = $this->customerPurchase_m->getDataPurchaseReturnByID($return_id, $email);
    $customer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $detail_return = $this->customerPurchase_m->getDetailPurchaseReturnByID($return_id);

    $html = '';

    if ($dataReturn != null) {
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
                <th>Description</th>
                <th>Weight</th>
                <th class="right">Price</th>
                <th class="center">Qty</th>
                <th class="right">Total</th>
              </tr>
            </thead>
            <tbody>';

      if ($detail_return != null && $detail_return != 0) {
        $no = 1;
        foreach ($detail_return as $val) {
          $html .= '<tr>
                    <td class="center">' . $no++ . '</td>

                    <td class="left strong">' . $val['product_name'] . '</td>
                    <td class="left strong">' . $val['information'] . '</td>

                    <td class="center">' . $val['weight_return'] . ' Gram</td>
                    <td class="right">Rp. ' . number_format($val['price'], 0, ',', '.') . '</td>
                    <td class="center">' . $val['qty_return'] . '</td>
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
                  <td class="right">Rp. ' . number_format($dataReturn['gross_amount'], 0, ',', '.') . '</td>
                </tr>';

      if ($dataReturn['ship_amount'] != null && $dataReturn['ship_amount'] != 0) {
        $html .= '<tr>
                    <td class="left">
                      <strong>Shipping cost</strong>
                    </td>
                    <td class="right">Rp. ' . number_format($dataReturn['ship_amount'], 0, ',', '.') . '  (' . $dataReturn['courier'] . ' - ' . $dataReturn['service'] . ')</td>
                  </tr>';
      }

      $html .= '<tr>
                  <td class="left">
                    <strong>Total</strong>
                  </td>
                  <td class="right">
                    <strong>Rp. ' . number_format($dataReturn['net_amount'], 0, ',', '.') . '</strong>
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
    $response['invoice'] = $dataReturn['invoice_return'];
    echo json_encode($response);
  }

  public function printReturn($return_id, $email)
  {
    $dataReturn = $this->customerPurchase_m->getDataPurchaseReturnByID($return_id, $email);


    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);


    $info['customer'] = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['detail_return'] = $this->customerPurchase_m->getDetailPurchaseReturnByID($return_id);

    if ($dataReturn != null) {
      $info['title'] = $dataReturn['invoice_return'];

      if ($dataReturn['approve_date'] != null) {
        $return_date = date('d M Y H:i:s', strtotime($dataReturn['approve_date']));
      } else {
        $return_date = date('d M Y H:i:s', strtotime($dataReturn['purchase_return_date']));
      }

      $info['return_date'] = $return_date;
      $info['data_return'] = $dataReturn;

      $this->load->view('back-prints/header', $info);
      $this->load->view('back-prints/print-customer-return', $info);
      $this->load->view('back-prints/footer', $info);
    } else {
      $this->load->view('back-prints/header', $info);
      $this->load->view('back-prints/footer', $info);
    }
  }

  public function cancelReturn()
  {
    $response = array();
    $email = $this->input->post('email');
    $return_id = $this->input->post('return_id');

    // JIKA TERDETEKSI CANCEL SUDAH MEMBAYAR MAKA ADA KONDISI DIMANA STOCK BARANG DIKEMBALIKAN
    $checkReturnApproved = $this->returOrder_m->getCheckReturnApprovedByID($return_id);

    // email purposes
    $dataCompany = $this->company_m->getCompanyById(1);
    $info['company'] = $dataCompany;
    $info['company_name'] = $dataCompany['company_name'];
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['company_bank'] = $this->company_m->getCompanyBankAccount(1);

    $dataReturn = $this->customerPurchase_m->getDataPurchaseReturnByID($return_id, $email);
    $info['data_return'] = $dataReturn;
    $info['invoice_return'] = $dataReturn['invoice_return'];
    $dataCustomer = $this->customerPurchase_m->getDataCustomerPurchaseByID($email);
    $info['customer_email'] = $dataCustomer['email'];
    $info['customer'] = $dataCustomer;
    $info['detail_return'] = $this->customerPurchase_m->getDetailPurchaseReturnByID($return_id);
    // email purposes

    if ($checkReturnApproved != null) {

      $data = [
        'status_order_id' => 10,
        'reminder_cancel' => 1
      ];

      $updateCancelReturn = $this->customerPurchase_m->updateDataCustomerReturnByID($return_id, $data); // karena memiliki table yang sama maka hiraukan nama

      if ($updateCancelReturn > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the return ' . $return_id . ' and, please confirm the refund!';

        // INCREASE STOCK IN STOCK PRODUCT 
        $dataPurchaseReturnDetail = $this->returOrder_m->getCustomerReturnProductByID($return_id);

        if ($dataPurchaseReturnDetail != null) {
          foreach ($dataPurchaseReturnDetail as $val) {
            $getProductID = $val['id_product'];
            $getQtyOrder = $val['qty_order'];
            $getQtyProduct = $val['qty_product'];

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
        $response['message'] = 'Sorry, there was an error regarding the cancel return!';
      }
    } else {
      $data = [
        'status_order_id' => 1,
        'reminder_cancel' => 1
      ];

      $updateCancelReturn = $this->customerPurchase_m->updateDataCustomerReturnByID($return_id, $data); // karena memiliki table yang sama maka hiraukan nama

      if ($updateCancelReturn > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully canceled the return ' . $return_id;

        $this->_sendEmail('cancel', $info);
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, there was an error regarding the cancel return!';
      }
    }

    echo json_encode($response);
  }
  // FOR APPROVE RETURN MODAL

  // FOR ADD ORDER RETUR
  public function create_code()
  {
    date_default_timezone_set('Asia/Jakarta');
    $generate = array();

    $generate['order_return_id'] = 'R-' . date('His');
    $generate['order_return_invoice'] = date("d") . date("m") . date('y') . '-OR-' . date('His');
    $generate['order_return_datetime'] = date('Y-m-d H:i:s');

    // return $generate;
    echo json_encode($generate);
  }

  public function getCustomerPurchaseOrder()
  {
    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->returOrder_m->getCustomerPurchaseOrder($keyword = null, $limit = 10);
    } else {
      $data = $this->returOrder_m->getCustomerPurchaseOrder($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id'],
          'text' => $val['invoice_order']
        );
      }
    }

    echo json_encode($row);
  }

  public function getCustomerPurchaseOrderByID()
  {
    $order_id = $this->input->post('invoice_order');

    $dataCustomerOrder = $this->returOrder_m->getCustomerPurchaseOrderByID($order_id);
    echo json_encode($dataCustomerOrder);
  }

  public function getCustomerOrderProduct()
  {
    $order_id = $this->input->post('invoice_order');

    $dataCustomerOrderProduct = $this->returOrder_m->getCustomerOrderProductByID($order_id);
    echo json_encode($dataCustomerOrderProduct);
  }

  public function getProductDetailValueCustomerOrder()
  {
    $product_id = $this->input->post('product_id');

    if ($product_id) {
      $data = $this->returOrder_m->getProductDetailValueCustomerOrderByID($product_id);
      echo json_encode($data);
    }
  }

  public function getOrderValidityQty()
  {
    $response = array();
    $order_id = $this->input->post('invoice_order');
    $product_id = $this->input->post('product_id');
    $qty_val = $this->input->post('qty');

    $dataProducts = $this->returOrder_m->getCheckQtyProductOrderByID($order_id, $product_id);
    $getQty = $dataProducts['qty'];

    if ($qty_val <= $getQty) {
      $response['status'] = "true";
    } else {
      $response['status'] = "false";
      $response['message'] = "Sorry, you exceeded the quantity limit from product order!";
    }

    echo json_encode($response);
  }

  private function rajaOngkirCost($origin, $destination, $weight, $courier)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: " . $this->apiKey
      ),
    ));

    $response = curl_exec($curl);

    $return = ($response === FALSE) ? curl_error($curl) : $response;
    curl_close($curl);
    return $return;
  }

  public function getCostShippingRajaOngkir()
  {
    $getOrigin = $this->input->get('origin');
    $getDestination = $this->input->get('destination');
    $getWeight = $this->input->get('weight');
    $getCourier = $this->input->get('courier');

    $data = $this->rajaOngkirCost($getOrigin, $getDestination, $getWeight, $getCourier);
    $getResult = json_decode($data)->rajaongkir->results;
    // $getData = $getResult[0]->costs;

    echo json_encode($getResult);
  }

  public function addRetur()
  {
    $info['title'] = "Add New Retur";
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->form_validation->set_rules('invoice_order', 'invoice order', 'trim|required');
    $this->form_validation->set_rules('date_return', 'return date', 'trim|required');
    $this->form_validation->set_rules('qty[]', 'quantity', 'trim|required|numeric');
    $this->form_validation->set_rules('courier', 'courier shipping', 'trim|required');
    $this->form_validation->set_rules('service', 'service shipping', 'trim|required');
    $this->form_validation->set_rules('shipping_cost', 'cost shipping', 'trim|required');
    $this->form_validation->set_rules('product[]', 'product', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('retur_orders/add-retur', $info);
    } else {
      $this->insertDataRetur();
    }
  }

  public function insertDataRetur()
  {
    date_default_timezone_set('Asia/Jakarta');

    $dataReturns = [
      'id' => $this->input->post('id_return'),
      'invoice_return' => $this->input->post('invoice_return'),
      'purchase_order_id' => $this->input->post('invoice_order_val'),
      'customer_email' => $this->input->post('c_email'),
      'purchase_return_date' => $this->input->post('date_return', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'ship_amount' => $this->input->post('shipping_cost', true),
      'net_amount' => $this->input->post('net_amount_value', true),
      'status_order_id' => 5,
      'reminder_pending' => 1,
      'created_date' => date('Y-m-d H:i:s')
    ];

    $dataReturnShipps = [
      'purchase_return_id' => $this->input->post('id_return'),
      'courier' => $this->input->post('courier'),
      'service' => $this->input->post('service_val'),
      'etd' => $this->input->post('etd_val'),
      'delivery_receipt_number' => null,
    ];

    $count_product = count($this->input->post('product'));

    for ($j = 0; $j < $count_product; $j++) {
      $getProduct = $this->returOrder_m->getCheckQtyProductOrderByID($this->input->post('invoice_order_val'), $this->input->post('product')[$j]);
      $getProductDetail = $this->returOrder_m->getProductDetailValueCustomerOrderByID($this->input->post('product')[$j]);
      $getProductInput = $this->input->post('product')[$j];
      $qtyProduct = $this->input->post('qty')[$j];
    }

    if ($qtyProduct <= $getProduct['qty']) {
      $this->returOrder_m->insertOrderRetur($dataReturns);

      $this->returOrder_m->insertOrderReturShipps($dataReturnShipps);

      // Store to sales_order_details
      for ($i = 0; $i < $count_product; $i++) {
        $dataReturnDetails = array(
          'purchase_return_id' => $this->input->post('id_return'),
          'product_id' => $this->input->post('product')[$i],
          'weight' => $this->input->post('weight_val')[$i],
          'qty' => $this->input->post('qty')[$i],
          'unit_price' => $this->input->post('price_value')[$i],
          'amount' => $this->input->post('amount_value')[$i],
          'information' => $this->input->post('description')[$i],
        );

        $this->returOrder_m->insertOrderReturDetails($dataReturnDetails);
      }

      $this->session->set_flashdata('success', 'Your retur order has been set, now You can approve the retur order!');
      redirect('order_retur', 'refresh');
    } else {
      $this->session->set_flashdata('error', 'Your quantity of ' . $getProductDetail['product_name'] . ' is limit from the previous order!');
      redirect('order_retur/addretur', 'refresh');
    }
  }
  // FOR ADD ORDER RETUR

  public function getCustomerOrder()
  {
    $data = $this->returOrder_m->getOrders();
    echo json_encode($data);
  }

  public function getOrderValueById()
  {
    $data = $this->order_m->getOrdersById($this->input->post('order_id', true));
    echo json_encode($data);
  }

  public function getTableProductRow()
  {
    $data = $this->returOrder_m->getProductOrder($this->input->post('order_id', true));
    echo json_encode($data);
  }

  public function getProduct()
  {
    $data = $this->category_m->getAllCategory();
    echo json_encode($data);
  }

  public function getProductQtyById()
  {
    $product_id = $this->input->post('product_id');
    if ($product_id) {
      $data = $this->returOrder_m->getProductDetailsQtyByID($product_id);
      echo json_encode($data);
    }
  }

  public function edit_order($id)
  {
    $data = $this->order_m->getOrdersById($id);
    echo json_encode($data);
  }

  public function detail_order($id)
  {
    // $id = $this->input->post('id');
    $data = $this->order_m->getProductById($id);
    echo json_encode($data);
  }

  public function print_retur($id)
  {
    $retur_data = $this->returOrder_m->getReturOrdersById($id);

    $retur_detail_data = $this->returOrder_m->getReturOrderDetailsById($id);

    $company_data = $this->company_m->getCompanyById(1);

    // Checking for discount exist retur_data['discount']
    if ($retur_data['retur_discount']) {
      $discount  = $retur_data['retur_discount'] . '%';
    } else {
      $discount = '-';
    }

    $html = '<!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Screen Printing | Invoice ' . $retur_data['id'] . '</title>
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
              <small class="pull-right">Date: ' . date('d M Y', strtotime($retur_data['retur_date'])) . '</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>' . $retur_data['customer_name'] . '</strong><br>
              ' . $retur_data['customer_address'] . '<br>
              Phone: ' . $retur_data['customer_phone'] . '<br>
              <!-- Email: john.doe@example.com -->
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice #' . $retur_data['retur_id'] . '</b><br>
            <br>
            <b>Order ID:</b> ' . $retur_data['id'] . '<br>
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
    foreach ($retur_detail_data as $val) {
      $product_data = $this->product_m->getProductById($val['product_id']);

      $html .= '<tr>
                  <td>' . $val['product_id'] . '</td>
                  <td>
                    ' . $product_data['product_name'] . ' <br>
                    [' . $val['description'] . ']
                  </td>
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
                  <td>Rp. ' . number_format($retur_data['retur_gross_amount'], 0, ',', '.') . '</td>
                </tr>';

    $html .= '<tr>
                  <th>Discount:</th>
                  <td>' . $discount . '</td>
                </tr>';

    $html .= '<tr>
                  <th>Net Amount:</th>
                  <td>Rp. ' . number_format($retur_data['retur_net_amount'], 0, ',', '.') . '</td>
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

/* End of file Order_retur.php */
