<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

  public function getUserById($id)
  {
    return $this->db->get_where('users', ['id' => $id])->row_array();
  }

  public function updateUser($data)
  {
    $this->db->where('email', $this->input->post('email'));
    $this->db->update('users', $data);
  }

  public function updatePassword($data)
  {
    $this->db->where('email', $this->session->userdata('email'));
    $this->db->update('users', $data);
  }
}
  
  /* End of file User_m.php */
