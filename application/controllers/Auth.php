<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
  }

  private function _login()
  {
    $email = $this->input->post('email', true);
    $pass  = $this->input->post('password', true);

    $user = $this->auth_m->userLogin($email);

    if ($user) {
      if (password_verify($pass, $user['password'])) {
        $file = [
          'id' => $user['id'],
          'name' => $user['name'],
          'email'   => $user['email'],
          'role_id'  => $user['role_id'],
          'is_active' => $user['is_active'],
          'is_online' => $user['online']
        ];

        $this->session->set_userdata($file);
        $this->auth_m->updateUserOnline($this->session->userdata('email'));
      } else {
        $this->session->set_flashdata('error', 'Wrong Password !');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('error', 'Your email has not registered !');
      redirect('auth');
    }
  }

  private function _sendEmail($token, $type)
  {
    $config = [
      'protocol'   => 'smtp',
      'smtp_host'  => 'ssl://smtp.googlemail.com',
      'smtp_user'  => 'your@email.com',
      'smtp_pass'  => 'yourpassword',
      'smtp_port'  => 465,
      'mailtype'  => 'html',
      'charset'  => 'utf-8',
      'newline'  => "\r\n"
    ];

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from('your@email.com', 'Warehouse');
    $this->email->to($this->input->post('email', true));
    /*$this->email->cc('another@example.com');
      $this->email->bcc('and@another.com');*/

    if ($type == 'activate') {
      $this->email->subject('Activate Account');
      $this->email->message('Click this link to activate your account : 
              <a href="' . base_url() . 'auth/activate?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate Now</a>');
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');
      $this->email->message('Click this link to reset your password : 
              <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Now</a>');
    }

    if ($this->email->send()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function index()
  {
    $info['title'] = 'Log In';

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'password', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      renderAuthTemplate('auths/login', $info);
    } else {
      $this->_login();
    }

    if ($this->session->userdata('email')) {
      redirect('admin', 'refresh');
    }
  }

  // forgotPassword()
  public function forgotPassword()
  {
    $info['title'] = 'Forgot Password';

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

    if ($this->form_validation->run() == FALSE) {
      renderAuthTemplate('auths/forgot-password', $info);
    } else {
      $data = [
        'email'   => $this->input->post('email', true),
        'is_active' => 1
      ];

      if ($this->auth_m->checkUserEmail($data)) {
        $token = base64_encode(random_bytes(32));

        $user_token = [
          'email'     => $this->input->post('email', true),
          'token'     => $token,
          'created_at'  => time()
        ];

        $this->auth_m->insertChangePass($user_token);
        $this->_sendEmail($token, 'forgot');

        $this->session->set_flashdata('success', 'please check your email to reset your password !');
        redirect('auth/forgotpassword', 'refresh');
      } else {
        $this->session->set_flashdata('error', 'email is not registered or activated !');
        redirect('auth/forgotpassword', 'refresh');
      }
    }
  }

  // resetPassword()
  public function resetPassword()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    if ($this->db->get_where('users', ['email' => $email])->row_array()) {
      if ($this->db->get_where('user_token', ['token' => $token])->row_array()) {
        $this->session->set_userdata('reset_email', $email);
        $this->changePassword();
      } else {
        $this->session->set_flashdata('error', 'reset password failed, wrong token.');
        redirect('auth', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'reset password failed, wrong email.');
      redirect('auth', 'refresh');
    }
  }

  // changePassword()
  public function changePassword()
  {
    if (!$this->session->userdata('reset_email')) {
      redirect('auth', 'refresh');
    }

    $info['title'] = "Change Password";

    $this->form_validation->set_rules('pass', 'new password', 'trim|required|min_length[6]|matches[repeat_pass]');
    $this->form_validation->set_rules('repeat_pass', 'repeat new password', 'trim|required|min_length[6]|matches[pass]');

    if ($this->form_validation->run() == FALSE) {
      renderAuthTemplate('auths/change-password', $info);
    } else {
      $password   = $this->input->post('pass', true);
      $hash_pass  = password_hash($password, PASSWORD_DEFAULT);
      $email     = $this->session->userdata('reset_email');

      $this->auth_m->updateUserPass($hash_pass, $email);
      $this->auth_m->deleteUserToken($email);

      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('success', $email . ' password has been changed. Please login !');
      redirect('auth', 'refresh');
    }
  }

  // logout()
  public function logout()
  {
    $this->auth_m->updateUserOffline($this->session->userdata('email'));

    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    $this->session->set_flashdata('success', 'You have been logout !');
    redirect('auth', 'refresh');
  }

  // denied()
  public function denied()
  {
    $info['title']  = "Oops! Access Denied";
    $this->load->view('auths/denied', $info);
  }
}
  
  /* End of file Auth.php */
