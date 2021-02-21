<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar', 'captcha']);
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
      $info['button'] = '<a href="' . base_url() . 'auth/activate?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="btn btn-primary">Activate Now</a>';

      $this->email->message($this->load->view('email-templates/email-user-auth', $info, true));
      $this->email->set_mailtype("html");
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');

      $info['title'] = 'Reset Password';
      $info['header'] = 'Be careful if you change your password';
      $info['body'] = 'Click this button bellow to reset your password';
      $info['button'] = '<a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="btn btn-primary">Reset Now</a>';

      $this->email->message($this->load->view('email-templates/email-user-auth', $info, true));
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
    $info['title'] = 'Log In';

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->load->view('back-templates/header_auth', $info);
    $this->load->view('auths/login', $info);
    $this->load->view('back-templates/footer_auth', $info);

    if ($this->session->userdata('email')) {
      redirect('admin', 'refresh');
    }
  }

  public function createCaptcha()
  {
    // captcha 
    $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    $original_string = implode("", $original_string);
    $captcha = substr(str_shuffle($original_string), 0, 6);

    //array untuk menampilkan gambar captcha
    $vals = array(
      'word' => $captcha, //huruf acak yang telah dibuat diatas
      'img_path' => 'back-assets/img/captcha/', //path untuk menyimpan gambar captcha
      'img_url' => base_url() . 'back-assets/img/captcha/', //url untuk menampilkan gambar captcha
      'img_width' => '200', //lebar gambar captcha
      'img_height' => 80, //tinggi gambar captcha
      'expiration' => 7200, //expired time per captcha
    );

    $cap = create_captcha($vals);

    if (file_exists("./back-assets/img/captcha/" . $this->session->userdata('image')))
      @unlink("./back-assets/img/captcha/" . $this->session->userdata('image'));
    $this->session->unset_userdata('captcha');
    $this->session->unset_userdata('image');
    $this->session->set_userdata(array('captcha' => $cap['word'], 'image' => $cap['time'] . '.jpg'));

    // $val['captcha'] = $this->session->userdata('captcha');
    // $val['image'] = $cap['image'];

    $captcha_image = $cap['image']; //variable array untuk menampilkan captcha pada view

    echo json_encode($captcha_image);
  }

  public function signIn()
  {
    $response = array();

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'password', 'trim|required');

    $email = $this->input->post('email', true);
    $pass  = $this->input->post('password', true);

    if ($this->form_validation->run() == TRUE) {
      $user = $this->auth_m->userLogin($email);

      if ($user != null) {
        if ($user['is_active'] != 0) {
          if (password_verify($pass, $user['password'])) {
            // cek captcha
            if ($this->input->post('captcha') !== $this->session->userdata('captcha')) {
              $response['status'] = FALSE;
              $response['message'] = 'Sorry, captcha is wrong!';

              if (file_exists("./back-assets/img/captcha/" . $this->session->userdata('image')))
                @unlink("./back-assets/img/captcha/" . $this->session->userdata('image'));
              $this->session->unset_userdata('captcha');
              $this->session->unset_userdata('image');
            } else {
              // setelah berhasil maka harus dihapus gambr captcha dan string yang tersimpan didalam session
              if (file_exists("./back-assets/img/captcha/" . $this->session->userdata('image')))
                @unlink("./back-assets/img/captcha/" . $this->session->userdata('image'));
              $this->session->unset_userdata('captcha');
              $this->session->unset_userdata('image');

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

              $response['status'] = TRUE;
            }
          } else {
            $response['status'] = FALSE;
            $response['message'] = 'Wrong password!';
          }
        } else {
          $response['status'] = FALSE;
          $response['message'] = 'Sorry, your account is not active. Please contact admin!';
        }
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Your email has not registered!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  // forgotPassword()
  public function forgotPassword()
  {
    $info['title'] = 'Forgot Password';

    if ($this->session->userdata('email')) {
      redirect('admin', 'refresh');
    }

    renderAuthTemplate('auths/forgot-password', $info);
  }

  public function setForgotPassword()
  {
    $response = array();

    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

    $email = $this->input->post('email', true);

    if ($this->form_validation->run() == TRUE) {
      $data = [
        'email'   => $email,
        'is_active' => 1
      ];

      if ($this->auth_m->checkUserEmail($data)) {
        $token = base64_encode(random_bytes(32));

        $user_token = [
          'email'     => $email,
          'token'     => $token,
          'created_at'  => time()
        ];

        $this->auth_m->insertChangePass($user_token);
        $this->_sendEmail($token, 'forgot');

        $response['status'] = TRUE;
        $response['message'] = 'Please check your email to reset your password, thank you!';
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

    if ($this->session->userdata('email')) {
      redirect('admin', 'refresh');
    }

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

    $file = [
      'id',
      'name',
      'email',
      'role_id',
      'is_active',
      'is_online'
    ];

    $this->session->unset_userdata($file);
    /* $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id'); */

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
