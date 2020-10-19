<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    if (!$this->session->userdata('email')) {
      redirect('auth', 'refresh');
    }
  }

  public function index()
  {
    $info['title'] = 'User Page';

    renderBackTemplate('users/index', $info);
  }

  private function _uploadImage()
  {
    $config['upload_path']    = './image/profile/';
    $config['allowed_types']  = 'gif|jpg|png';
    $config['max_size']       = '2048';
    $config['maintain_ratio'] = TRUE;
    $config['quality'] = '60%';
    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
      return $this->upload->data('file_name');
    } else {
      $this->session->set_flashdata('error', $this->upload->display_errors());
    }
  }

  public function edit()
  {
    $info['title']     = "Edit User Page";
    $get_data = $this->auth_m->getUserSession();

    $this->form_validation->set_rules('name', 'full name', 'trim|required|min_length[5]');

    if (empty($_FILES['image']['name'])) {
      $data = [
        'name' => $this->input->post('name', true)
      ];
    } else {
      $data = [
        'name' => $this->input->post('name', true),
        'image' => $this->_uploadImage()
      ];

      @unlink('./image/profile/' . $this->input->post('old_image'));
    }

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('users/edit-user', $info);
    } else {
      $this->user_m->updateUser($data);
      $this->session->set_flashdata('success', 'Updated !');
      redirect('user', 'refresh');
    }
  }

  public function changePassword()
  {
    $info['title']     = "Change Password";
    $get_data = $this->auth_m->getUserSession();

    $this->form_validation->set_rules('oldpass', 'current password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('newpass', 'new password', 'trim|required|min_length[6]|matches[repass]');
    $this->form_validation->set_rules('repass', 'confirm new password', 'trim|required|min_length[6]|matches[newpass]');

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('users/edit-password', $info);
    } else {
      $old_pass     = $this->input->post('oldpass', true);
      $newpass    = $this->input->post('newpass', true);

      if (!password_verify($old_pass, $get_data['password'])) {
        $this->session->set_flashdata('error', 'Wrong current password !');
        redirect('user/changepassword', 'refresh');
      } else {
        if ($old_pass == $newpass) {
          $this->session->set_flashdata('error', 'New password cannot be the same as current password !');
          redirect('user/changepassword', 'refresh');
        } else {
          $hash_pass = password_hash($newpass, PASSWORD_DEFAULT);

          $data = [
            'password' => $hash_pass
          ];

          $this->user_m->updatePassword($data);
          $this->session->set_flashdata('success', 'Your password has been changed !');
          redirect('user/changepassword', 'refresh');
        }
      }
    }
  }
}
  
  /* End of file User.php */
