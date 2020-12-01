<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AuthShop_m extends CI_Model
{
  public function getCustomerSession()
  {
    $this->db->where('customer_email', $this->session->userdata('customer_email'));

    $query = $this->db->get('customers');
    return $query->row_array();
  }

  public function customerLogin($data)
  {
    return $this->db->get_where('customers', ['customer_email' => $data])->row_array();
  }

  public function updateCustomerOnline($data)
  {
    $this->db->set('is_online', 1);
    $this->db->where('customer_email', $data);
    $this->db->update('customers');
  }

  public function updateUserOffline($data)
  {
    $this->db->set('is_online', 0);
    $this->db->where('customer_email', $data);
    $this->db->update('customers');
  }

  public function insertRegister($data)
  {
    $this->db->insert('customers', $data);
    return $this->db->affected_rows();
  }

  public function insertToken($data)
  {
    $this->db->insert('customer_token', $data);
    return $this->db->affected_rows();
  }

  public function updateCustomer($data)
  {
    $this->db->set('is_active', 1);
    $this->db->where('customer_email', $data);
    $this->db->update('customers');
  }

  public function deleteCustomerToken($email)
  {
    $this->db->where('email', $email);
    $this->db->delete('customer_token');
  }

  public function deleteCustomer($email)
  {
    $this->db->where('customer_email', $email);
    $this->db->delete('customers');
  }

  public function checkCustomerEmail($data)
  {
    return $this->db->get_where('customers', $data)->row_array();
  }

  public function insertChangePass($data)
  {
    $this->db->insert('customer_token', $data);

    return $this->db->affected_rows();
  }

  public function updateCustomerPass($data, $value)
  {
    $this->db->set('customer_password', $data);
    $this->db->where('customer_email', $value);
    $this->db->update('customers');
  }

  public function changePasswordCustomer($email, $data)
  {
    $this->db->where('customer_email', $email);
    $this->db->update('customers', $data);

    return $this->db->affected_rows();
  }

  public function updateCustomerOffline($data)
  {
    $this->db->set('is_online', 0);
    $this->db->where('customer_email', $data);
    $this->db->update('customers');
  }

  public function insertAddress($data)
  {
    $this->db->insert('customer_address', ['email' => $data]);
  }
}
  
  /* End of file AuthShop_m.php */
