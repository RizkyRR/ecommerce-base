<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerCart_m extends CI_Model
{

  public function checkSetCart($email, $product_id)
  {
    return $this->db->get_where('customer_carts', ['customer_email' => $email, 'product_id' => $product_id])->row_array();
  }

  public function insertCart($data)
  {
    $this->db->insert('customer_carts', $data);
    return $this->db->insert_id();
  }

  public function updateCart($email, $product_id, $data)
  {
    $this->db->where('customer_email', $email);
    $this->db->where('product_id', $product_id);

    $this->db->update('customer_carts', $data);

    return $this->db->affected_rows();
  }

  public function deleteCart($email, $cart_id = null)
  {
    $this->db->where('id', $cart_id);
    $this->db->where('customer_email', $email);
    $this->db->delete('customer_carts');

    return $this->db->affected_rows();
  }

  public function getDetailShoppingCart($email)
  {
    $this->db->select('*, SUM(customer_carts.quantity) as total_qty, products.id AS id_product, product_details.id AS id_detail, customer_carts.id AS id_cart, products.qty AS product_qty, customer_carts.quantity AS cart_qty'); //*

    $this->db->from('customer_carts');
    $this->db->join('product_details', 'product_details.product_id = customer_carts.product_id');
    $this->db->join('products', 'customer_carts.product_id = products.id');

    $this->db->group_by('product_details.product_id');

    $this->db->where('customer_carts.customer_email', $email);
    $this->db->order_by('customer_carts.created_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }
}
  
  /* End of file CustomerCart_m.php */
