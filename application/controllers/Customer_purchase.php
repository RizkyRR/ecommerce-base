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
      $row[] = $item->status_name;

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
}
  
  /* End of file Customer_purchase.php */
