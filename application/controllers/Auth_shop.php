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
    $config = [
      'protocol'   => 'smtp',
      'smtp_host'  => 'ssl://smtp.googlemail.com',
      'smtp_user'  => '111201408226@mhs.dinus.ac.id',
      'smtp_pass'  => 'number68',
      'smtp_port'  => 465,
      'mailtype'  => 'html',
      'charset'  => 'utf-8',
      'newline'  => "\r\n"
    ];

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from('111201408226@mhs.dinus.ac.id', 'Sandang Store');
    $this->email->to($this->input->post('email', true));
    /*$this->email->cc('another@example.com');
		$this->email->bcc('and@another.com');*/

    if ($type == 'activate') {
      $this->email->subject('Activate Account');
      $this->email->message('Click this link to activate your account : 
						<a href="' . base_url() . 'activate-account?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate Now</a>');
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');
      $this->email->message('Click this link to reset your password : 
						<a href="' . base_url() . 'reset-password?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Now</a>');
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

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
    $this->form_validation->set_rules('pass', 'password', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      renderFrontTemplate('front-container/signin-page-section', $info);
    } else {
      $this->_login();
    }

    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }
  }


  public function activate()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user  = $this->db->get_where('customers', ['customer_email' => $email])->row_array();

    if ($user) {
      $user_token = $this->db->get_where('customer_token', ['token' => $token])->row_array();

      if ($user_token) {
        if (time() - $user_token['created_at'] < (60 * 60 + 24)) {
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

    $this->form_validation->set_rules('name', 'customer name', 'trim|required|xss_clean|min_length[3]');
    $this->form_validation->set_rules('phone', 'customer phone', 'trim|required|xss_clean|numeric|min_length[5]|max_length[12]');

    $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email|is_unique[customers.customer_email]', ['is_unique' => 'This email has already registered !']);
    $this->form_validation->set_rules('pass', 'password', 'trim|xss_clean|required|min_length[6]|matches[con_pass]');
    $this->form_validation->set_rules('con_pass', 'confirm password', 'trim|xss_clean|required|min_length[6]|matches[pass]');

    if ($this->form_validation->run() == FALSE) {
      renderFrontTemplate('front-container/signup-page-section', $info);
    } else {
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

      $this->authShop_m->insertRegister($file);
      $this->authShop_m->insertToken($user_token);

      $this->_sendEmail($token, 'activate');

      $this->session->set_flashdata('success', 'Your account has been created!. Please check your email and activate your account!');
      redirect('sign-up', 'refresh');
    }

    if ($this->session->userdata('customer_email')) {
      redirect('profile', 'refresh');
    }
  }

  public function forgotPassword()
  {
    $info['title'] = 'Forgot Password Page';

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');

    if ($this->form_validation->run() == FALSE) {
      renderFrontTemplate('front-container/forgotpassword-page-section', $info);
    } else {
      $data = [
        'customer_email'   => $this->security->xss_clean(html_escape($this->input->post('email', true))),
        'is_active' => 1
      ];

      if ($this->authShop_m->checkCustomerEmail($data)) {
        $token = base64_encode(random_bytes(32));

        $user_token = [
          'email' => $this->security->xss_clean(html_escape($this->input->post('email', true))),
          'token' => $token,
          'created_at' => time()
        ];

        $this->authShop_m->insertChangePass($user_token);
        $this->_sendEmail($token, 'forgot');

        $this->session->set_flashdata('success', 'Please check your email to reset your password!');
        redirect('forgot-password', 'refresh');
      } else {
        $this->session->set_flashdata('error', 'Email is not registered or activated!');
        redirect('forgot-password', 'refresh');
      }
    }
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
