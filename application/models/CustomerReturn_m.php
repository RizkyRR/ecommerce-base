<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerReturn_m extends CI_Model
{

  // DataTables Model Setup
  var $column_order = array(null, 'customer_purchase_returns.id', 'customer_purchase_returns.invoice_return', 'customer_purchase_returns.created_date', null, null, 'status_orders.status_name', null); //set column field database for datatable orderable 
  var $column_search = array('customer_purchase_returns.id', 'customer_purchase_returns.invoice_return', 'customer_purchase_returns.created_date', 'status_orders.status_name'); //set column field database for datatable searchable
  var $order = array('customer_purchase_returns.created_date' => 'desc');  // default order

  private function _getPurchaseReturnDatatablesQuery($email)
  {
    $this->db->select('*, SUM(customer_purchase_return_details.qty) as total_product, customer_purchase_returns.id AS id_return, customer_purchase_return_details.id AS id_return_detail, status_orders.id AS id_status, customer_purchase_returns.status_order_id AS status_order, customer_purchase_return_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_details', 'customer_purchase_return_details.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_returns.status_order_id', 'left');

    $this->db->group_by('customer_purchase_return_details.purchase_return_id');

    $this->db->where_not_in('customer_purchase_returns.status_order_id', 1);
    $this->db->where('customer_purchase_returns.customer_email', $email);

    $i = 0;
    foreach ($this->column_search as $purchase) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($purchase, $_POST['search']['value']);
        } else {
          $this->db->or_like($purchase, $_POST['search']['value']);
        }
        if (count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) { // here order processing
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function getPurchaseReturnDatatables($email)
  {
    $this->_getPurchaseReturnDatatablesQuery($email);
    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($email)
  {
    $this->_getPurchaseReturnDatatablesQuery($email);
    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all($email)
  {
    $this->db->from('customer_purchase_returns');
    $this->db->where('customer_purchase_returns.customer_email', $email);

    return $this->db->count_all_results();
  }
  // DataTables Model Setup

  public function getDataCustomerPurchaseByID($email)
  {
    $this->db->select('*, customer_address.id AS id_address');

    $this->db->from('customer_address');
    $this->db->join('customers', 'customers.customer_email = customer_address.email', 'left');

    $this->db->where('customer_address.email', $email);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDataPurchaseReturnByID($order_id, $email)
  {
    $this->db->select('*, customer_purchase_returns.id AS id_return, status_orders.id AS id_status');

    $this->db->from('customer_purchase_returns');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_returns.status_order_id', 'left');

    $this->db->where('customer_purchase_returns.id', $order_id);
    $this->db->where('customer_email', $email);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDetailPurchaseReturnByID($order_id)
  {
    $this->db->select('*, customer_purchase_return_details.id AS id_return_detail, products.id AS id_product, product_variants.id AS id_variant, status_orders.id AS id_status, customer_purchase_return_details.qty AS qty_return, products.qty AS qty_product, products.weight AS weight_product, customer_purchase_return_details.weight AS weight_return');

    $this->db->from('customer_purchase_return_details');
    $this->db->join('products', 'products.id = customer_purchase_return_details.product_id', 'left');
    $this->db->join('product_variants', 'product_variants.id = customer_purchase_return_details.product_variant_id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_return_details.status_order_id', 'left');

    $this->db->where_not_in('customer_purchase_return_details.status_order_id', 1);
    $this->db->where('customer_purchase_return_details.purchase_return_id', $order_id);

    $query = $this->db->get();
    return $query->result_array();
  }
}
  
  /* End of file CustomerReturn_m.php */
