<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Customer";

    renderBackTemplate('customers/index', $info);
    $this->load->view('customers/modal-customer');
  }

  function show_ajax_customer()
  {
    $list = $this->customer_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $row = array();
      $id = htmlspecialchars(json_encode($item->id_customer));

      $row[] = $no . ".";
      $row[] = $item->id_customer;
      $row[] = $item->customer_name;
      $row[] = date('d M Y', strtotime($item->customer_birth_date));
      $row[] = $item->customer_email;
      $row[] = $item->customer_phone;
      $row[] = date('d M Y H:i:s', strtotime($item->created_at));

      // add html for action
      $row[] =
        '<a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="detailCustomer(' . $id . ')" title="detail data"><i class="fa fa-info"></i> Detail</a>
        <!-- <a href="javascript:void(0)" onclick="deleteCustomer(' . $id . ')" class="btn btn-danger btn-xs" title="delete data" style="display: none"><i class="fa fa-trash-o"></i> Delete</a> --> ';

      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->customer_m->count_all(),
      "recordsFiltered" => $this->customer_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  public function getDetailCustomer()
  {
    $customer_id = $this->input->post('customer_id');

    $data = $this->customer_m->getDataCustomerByID($customer_id);

    if ($data != null) {
      $dataCustomer = $data;
    } else {
      $dataCustomer = '';
    }

    echo json_encode($dataCustomer);
  }

  public function deleteCustomer()
  {
    $respoonse = array();
    $customer_id = $this->input->post('customer_id');

    $delete = $this->customer_m->deleteCustomer($customer_id);

    // customers
    // customer address 
    // customer carts
    // customer comments 
    // customer comment details
    // customer comment replies
    // customer comment replies details
    // customer messages
    // customer message details
    // customer wishlist

    if ($delete > 0) {
      $respoonse['status'] = TRUE;
      $respoonse['message'] = 'Customer data has been successfully deleted!';
    } else {
      $respoonse['status'] = FALSE;
      $respoonse['message'] = 'Customer data was not successfully deleted, please try again or refresh your page!';
    }

    echo json_encode($respoonse);
  }
}

/* End of file Customer.php */
