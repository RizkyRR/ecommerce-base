<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_shop extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template', 'authaccess']);
  }

  private function _login()
  {
    $email = $this->security->xss_clean(html_escape($this->input->post('email', true)));
    $pass  = $this->security->xss_clean(html_escape($this->input->post('pass', true)));

    $user = $this->authShop_m->customerLogin($email);

    if ($user) {
      if (password_verify($pass, $user['customer_password'])) {
        $file = [
          'customer_id' => $user['id_customer'],
          'customer_name' => $user['customer_name'],
          'customer_email'   => $user['customer_email'],
          'customer_is_active' => $user['is_active'],
          'customer_is_online' => $user['is_online']
        ];

        $this->session->set_userdata($file);
        $this->authShop_m->updateCustomerOnline($this->session->userdata('customer_email'));
      } else {
        $this->session->set_flashdata('error', 'Wrong Password !');
        redirect('sign-in');
      }
    } else {
      $this->session->set_flashdata('error', 'Your email has not registered !');
      redirect('sign-in');
    }
  }

  private function _sendEmail($token, $type)
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

    $this->email->from($dataEmail['email'], $dataCompany['company_name']);
    $this->email->to($this->input->post('email', true));
    /*$this->email->cc('another@example.com');
		$this->email->bcc('and@another.com');*/

    if ($type == 'activate') {
      $this->email->subject('Activate Account');

      $info['title'] = 'Activate Account';
      $info['header'] = 'Please activate your account';
      $info['body'] = 'Click this button bellow to activate your account';
      $info['button'] = '<a href="' . base_url() . 'activate-account?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="btn btn-primary">Activate Now</a>';

      $this->email->message($this->load->view('email-templates/email-customer-auth', $info, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');

      $info['title'] = 'Reset Password';
      $info['header'] = 'Be careful if you change your password';
      $info['body'] = 'Click this button bellow to reset your password';
      $info['button'] = '<a href="' . base_url() . 'reset-password?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="btn btn-primary">Reset Now</a>';

      $this->email->message($this->load->view('email-templates/email-customer-auth', $info, true));
      $this->email->set_mailtype("html");
    }

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function index()
  {
    $info['title'] = 'Sign In Page';

    renderFrontTemplate('front-container/signin-page-section', $info);

    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }
  }

  public function signIn()
  {
    $response = array();

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'password', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $email = $this->security->xss_clean(html_escape($this->input->post('email', true)));
      $password  = $this->security->xss_clean(html_escape($this->input->post('password', true)));

      $user = $this->authShop_m->customerLogin($email);

      if ($user) {
        if (password_verify($password, $user['customer_password'])) {
          $file = [
            'customer_id' => $user['id_customer'],
            'customer_name' => $user['customer_name'],
            'customer_email'   => $user['customer_email'],
            'customer_is_active' => $user['is_active'],
            'customer_is_online' => $user['is_online']
          ];

          $this->session->set_userdata($file);
          $this->authShop_m->updateCustomerOnline($this->session->userdata('customer_email'));

          $response['status'] = TRUE;
        } else {
          $response['status'] = FALSE;
          $response['message'] = 'Sorry, wrong password. Please try agian!';
        }
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Sorry, your email has not registered!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function activate()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user  = $this->db->get_where('customers', ['customer_email' => $email])->row_array();

    if ($user) {
      $user_token = $this->db->get_where('customer_token', ['token' => $token])->row_array();

      if ($user_token) {
        if (time() - $user_token['created_at'] < (60 * 60 * 24)) {
          $this->authShop_m->updateCustomer($email);
          $this->authShop_m->insertAddress($email);
          $this->authShop_m->deleteCustomerToken($email);
          $this->session->set_flashdata('success', $email . ' has been activated. Please login!');
          redirect('sign-in', 'refresh');
        } else {
          $this->authShop_m->deleteCustomerToken($email);
          $this->authShop_m->deleteCustomer($email);
          $this->session->set_flashdata('error', 'Account activation failed, token expired!');
          redirect('sign-in', 'refresh');
        }
      } else {
        $this->session->set_flashdata('error', 'Account activation failed, wrong token!');
        redirect('sign-in', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'Account activation failed, wrong email!');
      redirect('sign-in', 'refresh');
    }
  }

  public function signup()
  {
    $info['title'] = 'Sign Up Page';

    renderFrontTemplate('front-container/signup-page-section', $info);

    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }
  }

  public function setRegister()
  {
    $response = array();

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|xss_clean|min_length[3]');
    $this->form_validation->set_rules('phone', 'customer phone', 'trim|required|xss_clean|numeric|min_length[5]|max_length[12]');

    $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email|is_unique[customers.customer_email]', ['is_unique' => 'This email has already registered !']);
    $this->form_validation->set_rules('pass', 'password', 'trim|xss_clean|required|min_length[6]|matches[con_pass]');
    $this->form_validation->set_rules('con_pass', 'confirm password', 'trim|xss_clean|required|min_length[6]|matches[pass]');

    if ($this->form_validation->run() == TRUE) {
      $email   = $this->input->post('email', true);

      $id = "CUST" . "-";
      $generate = $id  . date("m") . date('y') . '-' . date('His');

      $file   = [
        'id_customer' => $generate,
        'customer_name' => $this->security->xss_clean(html_escape($this->input->post('name', true))),
        'customer_phone' => $this->security->xss_clean(html_escape($this->input->post('phone', true))),
        'customer_email' => htmlspecialchars($email),
        'customer_image' => 'default.png',
        'customer_password' => password_hash($this->security->xss_clean(html_escape($this->input->post('pass', true))), PASSWORD_DEFAULT),
        'is_active' => 0,
        'created_at' => date('Y-m-d H:i:s')
      ];

      // Token
      $token     = base64_encode(random_bytes(32));

      $user_token  = [
        'email' => $email,
        'token' => $token,
        'created_at' => time()
      ];

      $insertRegister = $this->authShop_m->insertRegister($file);
      $insertToken = $this->authShop_m->insertToken($user_token);

      if ($insertRegister > 0 && $insertToken > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'Your account has been created, please check your email and activate your account!';
        $this->_sendEmail($token, 'activate');
      } else {
        $response['status'] = FALSE;
        $response['message'] = "Sorry to register your account did not work, please refresh the page and try again!";
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function forgotPassword()
  {
    $info['title'] = 'Forgot Password Page';

    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }

    renderFrontTemplate('front-container/forgotpassword-page-section', $info);
  }

  public function setForgotPassword()
  {
    $response = array();

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');

    if ($this->form_validation->run() == TRUE) {
      $data = [
        'customer_email' => $this->security->xss_clean(html_escape($this->input->post('email', true))),
        'is_active' => 1
      ];

      if ($this->authShop_m->checkCustomerEmail($data)) {
        $token = base64_encode(random_bytes(32));

        $user_token = [
          'email' => $this->security->xss_clean(html_escape($this->input->post('email', true))),
          'token' => $token,
          'created_at' => time()
        ];

        $insert = $this->authShop_m->insertChangePass($user_token);

        if ($insert > 0) {
          $response['status'] = TRUE;
          $response['message'] = 'Please check your email to reset your password!';

          $this->_sendEmail($token, 'forgot');
        } else {
          $response['status'] = FALSE;
          $response['message'] = 'Sorry, there was an error when you reset your password. Please try again later, thank you!';
        }
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Email is not registered or activated!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  // resetPassword()
  public function resetPassword()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    if ($this->db->get_where('customers', ['customer_email' => $email])->row_array()) {
      if ($this->db->get_where('customer_token', ['token' => $token])->row_array()) {
        $this->session->set_userdata('reset_email', $email);
        $this->changePassword();
      } else {
        $this->session->set_flashdata('error', 'Reset password failed, wrong token!');
        redirect('sign-in', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'Reset password failed, wrong email!');
      redirect('sign-in', 'refresh');
    }
  }

  // changePassword()
  public function changePassword()
  {
    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }

    if (!$this->session->userdata('reset_email')) {
      redirect('sign-in', 'refresh');
    }

    $info['title'] = "Change Password";

    $this->form_validation->set_rules('pass', 'new password', 'trim|required|xss_clean|min_length[6]|matches[con_pass]');
    $this->form_validation->set_rules('con_pass', 'repeat new password', 'trim|required|xss_clean|min_length[6]|matches[pass]');

    if ($this->form_validation->run() == FALSE) {
      renderFrontTemplate('front-container/change-password-page-section', $info);
    } else {
      $password   = $this->security->xss_clean(html_escape($this->input->post('pass', true)));
      $hash_pass  = password_hash($password, PASSWORD_DEFAULT);
      $email     = $this->session->userdata('reset_email');

      $this->authShop_m->updateCustomerPass($hash_pass, $email);
      $this->authShop_m->deleteCustomerToken($email);

      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('success', $email . ' password has been changed. Please login!');
      redirect('sign-in', 'refresh');
    }
  }

  public function logout()
  {
    $this->authShop_m->updateCustomerOffline($this->session->userdata('customer_email'));

    $this->session->unset_userdata(['customer_id', 'customer_name', 'customer_email', 'customer_is_active', 'customer_is_online']);

    $this->session->set_flashdata('success', 'You have been sign-out!');
    redirect('sign-in', 'refresh');
  }
}

/* End of file Auth_shop.php */
