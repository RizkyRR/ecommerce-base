<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CheckOut_m extends CI_Model
{
  public function getCheckOutBilling($email)
  {
    $this->db->select('*');

    $this->db->from('customer_address');
    $this->db->join('customers', 'customers.customer_email = customer_address.email', 'left');

    $this->db->where('customer_address.email', $email);

    /* $this->db->from('customers');

    $this->db->where('customer_email', $email); */

    $query = $this->db->get();
    return $query->row_array();
  }
}
  
  /* End of file CheckOut_m.php */
