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
    $info['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    $info['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    // $info['product'] = $this->product_m->getActiveProduct();


    // $info[] = $this->load->view('modals/modal-order', $info);
    renderBackTemplate('orders/index', $info);

    $this->load->view('modals/modal-order-edit', $info);
    $this->load->view('modals/modal-repayment-order');
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_order()
  {
    $list = $this->order_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->id;
      $row[] = $item->customer_name;
      $row[] = $item->customer_phone;
      $row[] = date('d M Y', strtotime($item->order_date));
      $row[] = $item->total;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = $item->paid_status;
      if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') {
        $row[] = $item->user_create;
      }

      if ($item->paid_status == "Belum Lunas") {
        $paid_status = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="repayment_order(' . $id . ')" title="repayment data"><i class="fa fa-usd"></i> Repayment</a>';
      } else {
        $paid_status = '';
      }

      // add html for action
      $row[] =
        '' . $paid_status . '
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_order(' . $id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a>
        <a href="javascript:void(0)" onclick="delete_order(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
        <a target="__blank" href="' . base_url('order/print_order/' . $item->id) . '" class="btn btn-default btn-xs" title="print data"><i class="fa fa-print"></i> Print</a>
      ';
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

  public function getTableProductRow()
  {
    $data = $this->product_m->getActiveProduct();
    echo json_encode($data);
  }

  public function getProduct()
  {
    $data = $this->category_m->getAllCategory();
    echo json_encode($data);
  }

  public function getProductValueById()
  {
    $product_id = $this->input->post('product_id');
    if ($product_id) {
      $data = $this->product_m->getActiveProductByID($product_id);
      echo json_encode($data);
    }
  }

  public function create_code()
  {
    $this->db->select('RIGHT(orders.id,4) as kode', FALSE);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get('orders');      //cek dulu apakah ada sudah ada kode di tabel.    

    if ($query->num_rows() <> 0) {
      //jika kode ternyata sudah ada.      
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      //jika kode belum ada      
      $kode = 1;
    }

    $max_code = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $generate = "ORDER" . $max_code;

    // return $generate;
    echo json_encode($generate);
  }

  public function addOrder()
  {
    $info['title'] = "Add New Order";

    date_default_timezone_set('Asia/Jakarta');

    $company = $this->company_m->getCompanyById(1);
    $info['company_data'] = $company;
    $info['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    $info['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

    $order_date = $this->input->post('order_date', true);

    $this->form_validation->set_rules('c_name', 'customer name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('c_phone', 'phone number', 'trim|required|min_length[7]|max_length[12]|numeric');
    $this->form_validation->set_rules('c_bankname', 'bank name', 'trim|min_length[2]');
    $this->form_validation->set_rules('c_norek', 'nomor rekening', 'trim|numeric|min_length[5]');

    $this->form_validation->set_rules('c_address', 'address', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('order_date', 'order date', 'required');

    $this->form_validation->set_rules('product[]', 'product', 'trim|required');

    // PIUTANG ORDER LOGIC
    if ($this->input->post('net_amount_value', true) > $this->input->post('amount_paid', true)) {
      $paid_info = "Belum Lunas";

      $piutang_id = "PIUTANG" . "-";
      $custom_piutang_id = $piutang_id . date('His') . date("m") . date('y');

      $remaining_paid = abs((int) $this->input->post('net_amount_value', true) - (int) $this->input->post('amount_paid', true));

      $data_piutang = [
        'piutang_id' => $custom_piutang_id,
        'order_id' => $this->input->post('id'),
        'piutang_paid_history' => $order_date,
        'amount_paid' => $this->input->post('amount_paid', true),
        'remaining_paid' => $remaining_paid,
        'user_create' => $this->session->userdata('email'),
      ];

      $this->order_m->insertPiutang($data_piutang);
    } else {
      $paid_info = "Lunas";
    }

    $file = [
      'id' => $this->input->post('id'),
      'customer_name' => $this->input->post('c_name', true),
      'customer_phone' => $this->input->post('c_phone', true),
      'bank_name' => $this->input->post('c_bankname', true),
      'no_rek' => $this->input->post('c_norek', true),
      'customer_address' => $this->input->post('c_address', true),
      'order_date' => $order_date,
      'gross_amount' => $this->input->post('gross_amount_value', true),
      'ship_amount' => $this->input->post('ship_amount', true),
      'service_charge_rate' => $this->input->post('service_charge_rate', true),
      'service_charge' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
      'vat_charge_rate' => $this->input->post('vat_charge_rate', true),
      'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
      'net_amount' => $this->input->post('net_amount_value', true),
      'discount' => $this->input->post('discount', true),
      'after_discount' => $this->input->post('after_discount', true),
      'paid_status' => $paid_info,
      'created_at' => date('Y-m-d H:i:s'),
      'user_create' => $this->session->userdata('email')
    ];

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('orders/add-order', $info);
    } else {
      $count_product = count($this->input->post('product'));
      for ($j = 0; $j < $count_product; $j++) {
        $getProduct = $this->product_m->getProductById($this->input->post('product')[$j]);
        $qtyProduct = $this->input->post('qty')[$j];
      }

      if ($getProduct['qty'] >= $qtyProduct) {
        $this->order_m->insertOrders($file);

        // Store to sales_order_details
        for ($i = 0; $i < $count_product; $i++) {
          $products = array(
            'order_id' => $this->input->post('id'),
            'product_id' => $this->input->post('product')[$i],
            'qty' => $this->input->post('qty')[$i],
            'unit_price' => $this->input->post('price_value')[$i],
            'amount' => $this->input->post('amount_value')[$i]
          );

          $this->order_m->insertOrderDetails($products);

          // Update product to decrease stock after doing new order 
          $data_product = $this->product_m->getProductById($this->input->post('product')[$i]);
          $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];

          $update_product = array(
            'qty' => $qty
          );

          $this->product_m->update($this->input->post('product')[$i], $update_product);
        }

        $this->session->set_flashdata('success', 'Your order has been added !');
        redirect('order', 'refresh');
      } else {
        $this->session->set_flashdata('error', 'Your quantity of ' . $getProduct['product_name'] . ' is limited !');
        redirect('orders/addorder', 'refresh');
      }
    }
  }

  /* public function add_order()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'name',
        'label' => 'product name',
        'rules' => 'trim|required|min_length[3]'
      ],
      [
        'field' => 'category',
        'label' => 'product category',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'supplier',
        'label' => 'product supplier',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'description',
        'label' => 'product description',
        'rules' => 'trim|required|min_length[15]'
      ],
      [
        'field' => 'price',
        'label' => 'product price',
        'rules' => 'trim|required|numeric'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name'),
        'category' => form_error('category'),
        'supplier' => form_error('supplier'),
        'image' => form_error('image'),
        'description' => form_error('description'),
        'price' => form_error('price')
      ];

      echo json_encode($data);
    } else {

      $data = [
        'id' => $this->input->post('id'),
        'product_name' => $this->input->post('name', true),
        'category_id' => $this->input->post('category', true),
        'supplier_id' => $this->input->post('supplier', true),
        'description' => $this->input->post('description', true),
        'price' => $this->input->post('price', true),
        'qty' => 0,
        'availability' => 0,
        'created_at' => date('Y-m-d H:i:s')
      ];

      $this->order_m->insert($data);

      echo json_encode('success');
    }
  } */

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
