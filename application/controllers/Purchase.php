<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Purchase";


    renderBackTemplate('purchases/index', $info);
    $this->load->view('modals/modal-repayment-purchase');
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_purchase()
  {
    $list = $this->purchase_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_purchase));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->id_purchase;
      $row[] = $item->supplier_name;
      $row[] = $item->supplier_phone;
      $row[] = date('d M Y', strtotime($item->purchase_date));
      $row[] = $item->jumlah;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = $item->paid_status;
      if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') {
        $row[] = $item->user_create;
      }

      if ($item->paid_status == "Belum Lunas") {
        $paid_status = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="repayment_purchase(' . $id . ')" title="repayment data"><i class="fa fa-usd"></i> Repayment</a>';
      } else {
        $paid_status = '';
      }

      // add html for action
      $row[] =
        '' . $paid_status . '
          <!-- <a href="javascript:void(0)" onclick="delete_purchase(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a> -->
          <a target="__blank" href="' . base_url('purchase/print_purchase/' . $item->id_purchase) . '" class="btn btn-default btn-xs" title="print data"><i class="fa fa-print"></i> Print</a>
        ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->purchase_m->count_all(),
      "recordsFiltered" => $this->purchase_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

  public function getSupplier()
  {
    $data = $this->purchase_m->getSupplier();
    echo json_encode($data);
  }

  public function getSupplierValueById()
  {
    $supplier_id = $this->input->post('supplier_id');
    if ($supplier_id) {
      $supplier_data = $this->supplier_m->getSupplierById($supplier_id);
      echo json_encode($supplier_data);
    }
  }

  public function getTableProductRow()
  {
    $product = $this->purchase_m->getProduct($this->input->post('supplier_id'));
    echo json_encode($product);
  }

  public function getProductValueById()
  {
    $product_id = $this->input->post('product_id');

    $product_data = $this->product_m->getProductById($product_id);
    echo json_encode($product_data);
  }

  public function create_code()
  {
    $this->db->select('RIGHT(id,4) as kode', FALSE);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get('purchase');      //cek dulu apakah ada sudah ada kode di tabel.    

    if ($query->num_rows() <> 0) {
      //jika kode ternyata sudah ada.      
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      //jika kode belum ada      
      $kode = 1;
    }
    // https://stackoverflow.com/questions/35583733/right-substring-statement-sql
    $max_code = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $generate = "PO" . date('d') . date("m") . date('y') . '-' . $max_code;

    // return $generate;
    echo json_encode($generate);
  }

  public function addPurchase()
  {
    $info['title'] = "Add New Purchase";

    $purchase_date = $this->input->post('purchase_date', true);
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('supplier', 'supplier', 'trim|required');
    $this->form_validation->set_rules('purchase_date', 'purchase date', 'trim|required');
    $this->form_validation->set_rules('ship_amount', 'ship amount', 'trim|numeric');
    $this->form_validation->set_rules('tax_charge', 'tax charge', 'trim|numeric');
    $this->form_validation->set_rules('discount', 'discount', 'trim|numeric');
    $this->form_validation->set_rules('amount_paid', 'amount paid', 'trim|numeric');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');

    // PURCHASE DEBT LOGIC
    if ($this->input->post('net_amount_value', true) > $this->input->post('amount_paid', true)) {
      $paid_info = "Belum Lunas";

      $this->db->select('RIGHT(hutang_id,4) as kode', FALSE);
      $this->db->order_by('hutang_id', 'DESC');
      $this->db->limit(1);

      $query = $this->db->get('purchase_hutang');      //cek dulu apakah ada sudah ada kode di tabel.    

      if ($query->num_rows() <> 0) {
        //jika kode ternyata sudah ada.      
        $data = $query->row();
        $kode = intval($data->kode) + 1;
      } else {
        //jika kode belum ada      
        $kode = 1;
      }
      // https://stackoverflow.com/questions/35583733/right-substring-statement-sql
      $max_code = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
      $generate_debt_id = "DEBT" . date('d') . date("m") . date('y') . '-' . $max_code;

      $remaining_paid = abs((int) $this->input->post('net_amount_value', true) - (int) $this->input->post('amount_paid', true));

      $data_debt = [
        'hutang_id' => $generate_debt_id,
        'purchase_id' => $this->input->post('id'),
        'hutang_paid_history' => $purchase_date,
        'amount_paid' => $this->input->post('amount_paid', true),
        'remaining_paid' => $remaining_paid,
        'user_create' => $this->session->userdata('email'),
      ];

      $this->purchase_m->insertPurchaseDebt($data_debt);
    } else {
      $paid_info = "Lunas";
    }

    $file = [
      'id' => $this->input->post('id'),
      'supplier_id' => $this->input->post('supplier', true),
      'purchase_date' => $purchase_date,
      'no_ref' => $this->input->post('noref', true),
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'ship_amount' => $this->input->post('ship_amount', true),
      'tax_amount' => $this->input->post('tax_charge', true),
      'tax_amount_charge' => $this->input->post('tax_amount_charge', true),
      'discount' => $this->input->post('discount', true),
      'after_discount' => $this->input->post('after_discount', true),
      'net_amount' => $this->input->post('net_amount_value', true),
      'paid_status' => $paid_info,
      'user_create' => $this->session->userdata('email'),
      'created_at' => date('Y-m-d H:i:s')
    ];

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('purchases/add-purchase', $info);
    } else {
      $this->purchase_m->insertOrders($file);

      // Store to purchase_order_details
      $count_product = count($this->input->post('product'));
      for ($i = 0; $i < $count_product; $i++) {
        $products = array(
          'purchase_id' => $this->input->post('id'),
          'product_id' => $this->input->post('product')[$i],
          'unit_price' => $this->input->post('price')[$i],
          'qty' => $this->input->post('qty')[$i],
          'amount' => $this->input->post('amount_value')[$i]
        );

        $this->purchase_m->insertOrderDetails($products);

        // Update product to increase stock after doing new order 
        $data_product = $this->product_m->getProductById($this->input->post('product')[$i]);
        $qty = $data_product['qty'] + $this->input->post('qty')[$i];
        $price = $this->input->post('price')[$i];

        $update_product = array(
          'qty' => $qty,
          'price' => $price
        );

        $this->product_m->update($this->input->post('product')[$i], $update_product);
      }

      $this->session->set_flashdata('success', 'Your order has been added !');
      redirect('purchase', 'refresh');
    }
  }

  public function print_purchase($id)
  {
    $purchase_data = $this->purchase_m->getPurchaseByID($id);

    $purchase_detail_data = $this->purchase_m->getOrderDetailsByID($id);

    $company_data = $this->company_m->getCompanyById(1);

    // Checking for discount exist order_data['discount']
    if ($purchase_data['discount']) {
      $discount  = $purchase_data['discount'] . '%';
    } else {
      $discount = '-';
    }

    $html = '<!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Screen Printing | Invoice ' . $purchase_data['purchase_id'] . '</title>
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
              <small class="pull-right">Date: ' . date('d M Y', strtotime($purchase_data['purchase_date'])) . '</small>
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
              Phone: ' . $purchase_data['supplier_name'] . '<br>
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
            <b>Invoice #' . substr($purchase_data['purchase_id'], 5, 8) . '</b><br>
            <br>
            <b>Order ID:</b> ' . $purchase_data['purchase_id'] . '<br>
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
    foreach ($purchase_detail_data as $val) {
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
                  <td>Rp. ' . number_format($purchase_data['gross_amount'], 0, ',', '.') . '</td>
                </tr>';

    $html .= '<tr>
                  <th>Discount:</th>
                  <td>' . $discount . '</td>
                </tr>';

    $html .= '<tr>
                  <th>Net Amount:</th>
                  <td>Rp. ' . number_format($purchase_data['net_amount'], 0, ',', '.') . '</td>
                </tr>

                <tr>
                  <th>Paid Status:</th>
                  <td>' . $purchase_data['paid_status'] . '</td>
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
  
  /* End of file Purchase.php */
