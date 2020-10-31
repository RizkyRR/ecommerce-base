<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hutang extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Hutang";

    // $info['product'] = $this->product_m->getActiveProduct();


    renderBackTemplate('hutangs/index', $info);

    $this->load->view('modals/modal-repayment-hutang');
  }

  // DataTables Controller Setup

  function show_ajax_hutang()
  {
    $list = $this->hutang_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->purchase_id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->hutang_id;
      $row[] = $item->purchase_id;
      $row[] = date('d M Y', strtotime($item->lastupdate));
      $row[] = "Rp " . number_format($item->total, 0, ',', '.');
      $row[] = "Rp " . number_format($item->remaining, 0, ',', '.');
      if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') {
        $row[] = $item->user_create;
      }

      // add html for action
      $row[] =
        '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="repayment_purchase(' . $id . ')" title="repayment data"><i class="fa fa-usd"></i> Repayment</a>

        <!-- <a href="javascript:void(0)" onclick="print_purchase(' . $id . ')" class="btn btn-default btn-xs" title="print data"><i class="fa fa-print"></i> Print</a> -->

        <a target="__blank" href="' . base_url('hutang/print_hutang/' . $item->purchase_id) . '" rel="noreferrer noopener" class="btn btn-default btn-xs" title="print data"><i class="fa fa-print"></i> Print</a>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->hutang_m->count_all(),
      "recordsFiltered" => $this->hutang_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  public function get_repayment($id)
  {
    // $id = $this->input->post('id');
    $data = $this->hutang_m->getDebtById($id);
    echo json_encode($data);
  }

  public function repayment()
  {
    $rules = [
      [
        'field' => 'repayment_date',
        'label' => 'repayment date',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'amount_paid',
        'label' => 'amount paid',
        'rules' => 'trim|required'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'repayment_date' => form_error('repayment_date'),
        'amount_paid' => form_error('amount_paid')
      ];

      echo json_encode($data);
    } else {
      $getAmountPaid = $this->input->post('amount_paid_value', true);

      if ($getAmountPaid != 0) {
        $data = array(
          'hutang_id' => $this->input->post('hutang_id', true),
          'purchase_id' => $this->input->post('purchase_id', true),
          'hutang_paid_history' => $this->input->post('repayment_date', true),
          'amount_paid' => $this->input->post('amount_paid', true),
          'remaining_paid' => $getAmountPaid,
          'user_create' => $this->session->userdata('email')
        );

        $this->hutang_m->insertHutang($data);
        echo json_encode('success');
      } else if ($getAmountPaid == 0) {
        $data = array(
          'paid_status' => "Lunas"
        );

        $this->purchase_m->update($this->input->post('purchase_id', true), $data);
        $this->hutang_m->deleteHutang($this->input->post('purchase_id', true));
        echo json_encode('success');
      }
    }
  }

  public function print_hutang($id)
  {
    $purchase_data = $this->purchase_m->getPurchaseByID($id);

    $company_data = $this->company_m->getCompanyById(1);
    $hutang_data = $this->hutang_m->getDebtAllById($id);

    $html = '<!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Screen Printing | Hutang ' . $purchase_data['purchase_id'] . '</title>
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
              Hutang Repayment History.
              <!-- <small class="pull-right">Hutang ID: ' . $purchase_data['purchase_id'] . '</small> -->
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>' . $purchase_data['supplier_name'] . '</strong><br>
              ' . $purchase_data['supplier_address'] . '<br>
              Phone: ' . $purchase_data['supplier_phone'] . '<br>
              <!-- Email: john.doe@example.com -->
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            To
            <address>
              <strong>' . $company_data['company_name'] . '.</strong><br>
              ' . $company_data['address'] . '<br>
              Phone: ' . $company_data['phone'] . '<br>
              Email: ' . $company_data['business_email'] . '
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Purchase ID:</b> ' . $purchase_data['purchase_id'] . '<br>
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
                <th>Hutang Paid History</th>
                <th>Amount Paid</th>
                <th>Remaining Paid</th>
              </tr>
              </thead>
              <tbody>';
    foreach ($hutang_data as $val) {
      $html .= '<tr>
                  <td>' . date('d M Y', strtotime($val['hutang_paid_history'])) . '</td>
                  <td>Rp. ' . number_format($val['amount_paid'], 0, ',', '.') . '</td>
                  <td>Rp. ' . number_format($val['remaining_paid'], 0, ',', '.') . '</td>
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
                  <th style="width:50%">Total:</th>
                  <td>Rp. ' . number_format($purchase_data['net_amount'], 0, ',', '.') . '</td>
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
  
  /* End of file Hutang.php */
