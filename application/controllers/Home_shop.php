<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home_shop extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template']);
  }

  public function index()
  {
    $info['title'] = "Shop Home Page";
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();

    // Show store banner for give them info about dicount and anything else 
    $info['store_banner'] = $this->storeBanner_m->getAllStoreBanner();

    // Show Deals of The Day from Server (Deals of The Day means items that get a discounted price)
    $info['check_discount'] = $this->db->get('product_discounts');
    $info['discount_items'] = $this->product_m->getShowDiscountProducts();

    // Show Hot Products from Server (Hot product means that items are in high demand and sold a lot)
    $check_hot = $this->db->get('order_details');
    $info['check_hot'] = $check_hot;
    $info['hot_items'] = $this->product_m->setHotProducts();

    $email = $this->session->userdata('customer_email');
    $info['wishlist'] = $this->product_m->getWishlistSet($email, $id = null);

    renderFrontTemplate('front-container/home-page-section', $info);
    // $this->load->view('modals/modal-product-shop-quick-view');
  }

  public function getCheckHotProduct()
  {
    $response = array();
    $data = $this->product_m->getCheckHotProduct();

    /* $query = $this->db->get('product_discounts');
    
    if ($query->num_rows > 0) {
      $response['status'] = true;
    } else {
      $response['status'] = false;
    }

    echo json_encode($response); */

    echo json_encode($data);
  }

  public function setHotProducts()
  {
    $data = $this->product_m->setHotProducts();
    echo json_encode($data);
  }

  public function getHotProductSale()
  {
    $id = $this->input->post('product_id');

    $data = $this->product_m->getHotProductSale($id);
    echo json_encode($data);
  }

  public function getHotProductPrice()
  {
    $response = array();
    $product_id = $this->input->post('product_id');

    $getPrice = $this->product_m->getHotProductPrice($product_id);

    if ($getPrice > 0) {
      $response['status'] = true;
      $response['data'] = $getPrice;
    } else {
      $response['status'] = false;
      $response['data'] = $getPrice;
    }

    echo json_encode($response);
  }

  public function setWishlist($id)
  {
    $response = array();

    $email = $this->session->userdata('customer_email');

    $data = [
      'customer_email' => $email,
      'product_id' => $id,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // check session before click button
    if (!$email) {
      $this->session->set_flashdata('error', 'You have to sign in first!');
      redirect('sign-in', 'refresh');
    } else {
      // check wishlist set or not
      $checkWishlist = $this->product_m->checkSetWishlist($email, $id);

      if ($checkWishlist > 0) {
        // delete data in wishlist table
        $delete = $this->product_m->deleteWishlist($email, $id);

        if ($delete > 0) {
          $this->session->set_flashdata('success', 'Successfully removed from your wishlist!');
          redirect('home', 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Unsuccessfully removed from your wishlist!');
          redirect('home', 'refresh');
        }
      } else {
        // insert data in wishlist table
        $insert = $this->product_m->insertWishlist($data);

        if ($insert > 0) {
          $this->session->set_flashdata('success', 'Product was added to the wishlist!');
          redirect('home', 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Wishlist did not add successfully!');
          redirect('home', 'refresh');
        }
      }
    }
  }

  public function aboutCompany()
  {
    $info['title'] = "About Us Page";
    renderFrontTemplate('front-container/about-page-section', $info);
  }

  public function contactCompany()
  {
    $info['title'] = "Contact Us Page";
    renderFrontTemplate('front-container/contact-page-section', $info);
  }

  private function _sendEmail($data)
  {
    $dataEmail = $this->company_m->getEmail(1);
    $dataCompany = $this->company_m->getCompanyById(1);

    $config = [
      'protocol'   => 'smtp',
      'smtp_host'  => 'ssl://smtp.googlemail.com',
      'smtp_user'  => $dataEmail['email'],
      'smtp_pass'  => $dataEmail['password'],
      'smtp_port'  => 465,
      'mailtype'  => 'html',
      'charset'  => 'utf-8',
      'newline'  => "\r\n"
    ];

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from($data['email'], 'Customer ' . $dataCompany['company_name'] . ' ' .  $data['name']);
    $this->email->to($dataEmail['email']);
    /*$this->email->cc('another@example.com');
      $this->email->bcc('and@another.com');*/

    $this->email->subject('Message from ' . $data['name'] . ' customer ' . $dataCompany['company_name']);

    $this->email->message($data['message']);
    $this->email->set_mailtype("html");

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function sendMessage()
  {
    $response = array();

    $this->form_validation->set_rules('g_name', 'Your name', 'trim|required');
    $this->form_validation->set_rules('g_email', 'Your email', 'trim|required|valid_email');
    $this->form_validation->set_rules('g_message', 'Your message', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $data = array();

      $data['name'] = $this->input->post('g_name');
      $data['email'] = $this->input->post('g_email');
      $data['message'] = $this->input->post('g_message');

      $this->_sendEmail($data);

      $response['status'] = TRUE;
      $response['message'] = 'Your message has been successfully sent. Please be patient waiting for our answer. Thank you!';
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }
}
  
  /* End of file Home_shop.php */
