<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_return extends CI_Controller
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
    $info['title'] = "History Customer Return Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    $this->load->view('front-templates/header', $info);
    $this->load->view('front-container/side-menu-customer-section', $info);
    $this->load->view('front-container/customer-history-return-page-section', $info);
    $this->load->view('front-templates/footer', $info);
  }

  public function showPurchaseReturn()
  {
    $email = $this->session->userdata('customer_email');

    $list = $this->customerReturn_m->getPurchaseReturnDatatables($email);
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_return));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_return;
      $row[] = date('d M Y H:i:s', strtotime($item->created_date));
      $row[] = $item->total_product;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = $item->status_name;

      // add html for action
      $row[] = '<a href="' . base_url() . 'get-detail-customer-return/' . $item->id_return . '" class="btn btn-info btn-sm" title="detail return"><i class="fa fa-info" aria-hidden="true"></i> Info</a>';

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->customerReturn_m->count_all($email),
      "recordsFiltered" => $this->customerReturn_m->count_filtered($email),
      "data" => $data,
    );

    // output to json format
    echo json_encode($output);
  }

  public function detailPurchaseReturn($id)
  {
    $info['title'] = "Detail Customer Return Page";

    $email = $this->session->userdata('customer_email');

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($email);

    $dataReturn = $this->customerReturn_m->getDataPurchaseReturnByID($id, $email);
    $info['data_return'] = $dataReturn;
    $info['customer'] = $this->customerReturn_m->getDataCustomerPurchaseByID($email);
    $info['detail_return'] = $this->customerReturn_m->getDetailPurchaseReturnByID($id);

    if ($dataReturn != null) {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/customer-history-return-detail-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    } else {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/error-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    }
  }

  public function printPurchaseReturn($id)
  {
    $info['title'] = "Detail Customer Return Page";

    $email = $this->session->userdata('customer_email');

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($email);

    $dataReturn = $this->customerReturn_m->getDataPurchaseReturnByID($id, $email);
    $info['data_return'] = $dataReturn;
    $info['customer'] = $this->customerReturn_m->getDataCustomerPurchaseByID($email);
    $info['detail_return'] = $this->customerReturn_m->getDetailPurchaseReturnByID($id);

    if ($dataReturn != null) {
      $this->load->view('front-prints/header', $info);
      $this->load->view('front-prints/print-customer-return', $info);
      $this->load->view('front-prints/footer', $info);
    } else {
      $this->load->view('front-prints/header', $info);
      $this->load->view('front-prints/footer', $info);
    }
  }
}
  
  /* End of file Customer_return.php */
