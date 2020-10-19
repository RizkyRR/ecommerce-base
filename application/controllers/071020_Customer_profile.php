<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_profile extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);
    $this->load->helper(['template', 'authaccess']);

    if (!$this->session->userdata('customer_email')) {
      redirect('sign-in');
    }
  }

  private function _uploadResizeImage()
  {
    $config['upload_path'] = './image/customer_profile/';
    $config['allowed_types'] = 'jpg|png|jpeg|JPG';
    // $config['max_size'] = 2048;
    $config['encrypt_name'] = TRUE;

    $this->upload->initialize($config);
    $this->upload->do_upload('photo');

    $image_data = $this->upload->data();

    $config['image_library'] = 'gd2';
    $config['source_image'] = './image/customer_profile/' . $image_data['file_name'];
    $config['maintain_ratio'] = TRUE;
    $config['quality'] = '80%';

    $this->load->library('image_lib', $config);
    $this->image_lib->resize();

    return $this->upload->data('file_name');
  }

  public function index()
  {
    $info['title'] = 'Customer Profile Page';

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();

    $info['gender'] = $this->customerProfile_m->getGenders();
    $email = $this->session->userdata('customer_email');
    $info['customer'] = $this->customerProfile_m->getCustomerData($email);

    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    /* VALIDATION */
    $this->form_validation->set_rules('name', 'customer name', 'trim|required|xss_clean|min_length[3]');
    $this->form_validation->set_rules('phone', 'customer phone number', 'trim|required|min_length[5]|max_length[12]|numeric');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/customer-home-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    } else {
      if (empty($_FILES['photo']['name'])) {
        $data = [
          'customer_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
          'customer_birth_date' => $this->security->xss_clean(html_escape($this->input->post('birthdate', true))),
          'gender_id' => $this->security->xss_clean(html_escape($this->input->post('gender', true))),
          'customer_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true)))
        ];
      } else {
        $data = [
          'customer_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
          'customer_birth_date' => $this->security->xss_clean(html_escape($this->input->post('birthdate', true))),
          'gender_id' => $this->security->xss_clean(html_escape($this->input->post('gender', true))),
          'customer_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
          'customer_image' => $this->_uploadResizeImage()
        ];

        if ($this->input->post('old_photo') != "default.png") {
          @unlink('./image/customer_profile/' . $this->input->post('old_photo'));
        }
      }

      $this->customerProfile_m->updateCustomer($this->input->post('email'), $data);

      $this->session->set_flashdata('success', 'Your account has been updated!');
      redirect('profile', 'refresh');
    }
  }

  public function getProvinceData()
  {
    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->customerProfile_m->getProvinceData($keyword = null, $limit = 10);
    } else {
      $data = $this->customerProfile_m->getProvinceData($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_prov'],
          'text' => $val['nama']
        );
      }
    }
    echo json_encode($row);

    /* $data = $this->customerProfile_m->getProvinceData();
    echo json_encode($data); */
  }

  public function getRegencyData()
  {
    $id = $this->input->post('province_id');

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->customerProfile_m->getRegencyData($id, $keyword = null, $limit = 10);
    } else {
      $data = $this->customerProfile_m->getRegencyData($id, $keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_kab'],
          'text' => $val['nama']
        );
      }
    }
    echo json_encode($row);

    /* $data = $this->customerProfile_m->getRegencyData($id);
    echo json_encode($data); */
  }

  public function getDistrictData()
  {
    $id = $this->input->post('regency_id');

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->customerProfile_m->getDistrictData($id, $keyword = null, $limit = 10);
    } else {
      $data = $this->customerProfile_m->getDistrictData($id, $keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_kec'],
          'text' => $val['nama']
        );
      }
    }
    echo json_encode($row);

    /*  $data = $this->customerProfile_m->getDistrictData($id);
    echo json_encode($data); */
  }

  public function getSubDistrictData()
  {
    $id = $this->input->post('district_id');

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->customerProfile_m->getSubDistrictData($id, $keyword = null, $limit = 10);
    } else {
      $data = $this->customerProfile_m->getSubDistrictData($id, $keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_kel'],
          'text' => $val['nama']
        );
      }
    }
    echo json_encode($row);

    /* $data = $this->customerProfile_m->getSubDistrictData($id);
    echo json_encode($data); */
  }

  public function getDataAddress()
  {
    $email = $this->session->userdata('customer_email');
    $data = $this->customerProfile_m->getCustomerAddress($email);

    echo json_encode($data);
  }

  public function getFullAdressCustomer()
  {
    $email = $this->session->userdata('customer_email');
    $data = $this->customerProfile_m->getFullAdressCustomer($email);

    if ($data['street_name'] != null || $data['provinsi_id'] != null) {
      $html = '<label class = "col-sm-2 col-form-label">Your address </label>' .
        '<div class="col-sm-10">' .
        '<textarea class="form-control" name="full_address" id="full_address" cols="5" rows="5" readonly>' . $data['street_name'] . ', ' . $data['nama_kelurahan'] . ', ' . $data['nama_kecamatan'] . ', ' . $data['nama_kabupaten'] . ', ' . $data['nama_provinsi'] . '</textarea>' . '</div>';
    } else {
      $html = '';
    }

    echo json_encode($html);
  }

  public function updateAddress()
  {
    $response = array();

    $id = $this->session->userdata('customer_email');
    $data = [
      'provinsi_id' => $this->input->post('province', true),
      'kabupaten_id' => $this->input->post('regency', true),
      'kecamatan_id' => $this->input->post('district', true),
      'kelurahan_id' => $this->input->post('subdistrict', true),
      'street_name' => $this->input->post('street_name', true)
    ];

    $update = $this->customerProfile_m->updateAddress($id, $data);

    if ($update > 0) {
      $response['status'] = true;
      $response['notif'] = 'Your address has been updated!';
    } else {
      $response['status'] = false;
      $response['notif'] = 'Your address was not saved successfully, please try again!';
    }

    echo json_encode($response);
  }

  public function addressList()
  {
    $info['title'] = "Customer Address Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();

    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    $this->load->view('front-templates/header', $info);
    $this->load->view('front-container/side-menu-customer-section', $info);
    $this->load->view('front-container/customer-address-list-page-section', $info);
    $this->load->view('front-templates/footer', $info);
  }

  public function changePassword()
  {
    $info['title'] = "Customer Change Password Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();

    $getDataSession = $this->authShop_m->getCustomerSession();
    $email = $this->session->userdata('customer_email');

    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    // validation 
    $this->form_validation->set_rules('old_password', 'current password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[6]|matches[confirm_password]');
    $this->form_validation->set_rules('confirm_password', 'confirm new password', 'trim|required|min_length[6]|matches[new_password]');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/customer-change-password-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    } else {
      $old_pass = $this->input->post('old_password', true);
      $new_pass = $this->input->post('new_password', true);

      if (!password_verify($old_pass, $getDataSession['customer_password'])) {
        $this->session->set_flashdata('error', 'Wrong current password !');
        redirect('change-password', 'refresh');
      } else {
        if ($old_pass == $new_pass) {
          $this->session->set_flashdata('error', 'New password cannot be the same as current password!');
          redirect('change-password', 'refresh');
        } else {
          $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);

          $data = [
            'customer_password' => $hash_pass
          ];

          $update = $this->authShop_m->changePasswordCustomer($email, $data);

          if ($update > 0) {
            $this->session->set_flashdata('success', 'Your password has been changed!');
            redirect('change-password', 'refresh');
          } else {
            $this->session->set_flashdata('error', 'Sorry, something wrong please try again!');
            redirect('change-password', 'refresh');
          }
        }
      }
    }
  }

  public function getWishlist()
  {
    $info['title'] = "Product Wishlist Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();

    $email = $this->session->userdata('customer_email');
    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    // PAGINATION
    $config['base_url']     = base_url() . 'get-wishlist/index';
    $config['total_rows']   = $this->product_m->getCountPageWishlistProductShop($email);
    $config['per_page']     = 12;
    $config['num_links']    = 5;

    $config['use_page_numbers'] = TRUE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    // STYLING
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '<i class="fa fa-caret-right"></i>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '<i class="fa fa-caret-left"></i>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    // GENERATE PAGE
    $this->pagination->initialize($config);

    $info['start'] = $this->uri->segment(3);

    // THIS ONE MAKES YOUR DATA NOT MULTIPLE IN NEXT PAGE NOT LIKE 1[1,2,3,4] 2[3,4,5,6] BUT 1[1,2,3,4] 2[5,6,7,8]
    if ($info['start'] != 0) {
      $info['start'] = ($info['start'] - 1) * $config['per_page'];
    }

    $info['total_rows'] = $config['total_rows'];
    $info['products'] = $this->product_m->getAllWishlistProductShop($config['per_page'], $info['start'], $email);

    $email = $this->session->userdata('customer_email');
    $info['wishlist'] = $this->product_m->getWishlistSet($email, $id = null);

    $info['pagination'] = $this->pagination->create_links();

    $this->load->view('front-templates/header', $info);
    $this->load->view('front-container/side-menu-customer-section', $info);
    $this->load->view('front-container/customer-wishlist-page-section', $info);
    $this->load->view('front-templates/footer', $info);
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
          redirect($this->agent->referrer(), 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Unsuccessfully removed from your wishlist!');
          redirect($this->agent->referrer(), 'refresh');
        }
      } else {
        // insert data in wishlist table
        $insert = $this->product_m->insertWishlist($data);

        if ($insert > 0) {
          $this->session->set_flashdata('success', 'Product was added to the wishlist!');
          redirect($this->agent->referrer(), 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Wishlist did not add successfully!');
          redirect($this->agent->referrer(), 'refresh');
        }
      }
    }
  }
}
  
  /* End of file Customer_profile.php */
