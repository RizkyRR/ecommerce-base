<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_m extends CI_Model
{

  // DataTables Model Setup

  var $column_order = array(null, 'id_customer', 'customer_name', 'customer_birth_date', 'customer_email', 'customer_phone', 'created_at', null); //set column field database for datatable orderable 

  var $column_search = array('id_customer', 'customer_name', 'customer_birth_date', 'customer_email', 'customer_phone', 'created_at'); //set column field database for datatable searchable

  var $order = array('customer_name' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('customers');

    $i = 0;
    foreach ($this->column_search as $customer) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($customer, $_POST['search']['value']);
        } else {
          $this->db->or_like($customer, $_POST['search']['value']);
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

  function get_datatables()
  {
    $this->_get_datatables_query();
    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all()
  {
    $this->db->from('customers');
    return $this->db->count_all_results();
  }

  public function getDataCustomerByID($id)
  {
    $this->db->select('*, customer_address.id AS id_address, genders.id AS id_gender');

    $this->db->from('customers');
    $this->db->join('customer_address', 'customer_address.email = customers.customer_email', 'left');
    $this->db->join('genders', 'genders.id = customers.gender_id', 'left');

    $this->db->where('id_customer', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function deleteCustomer($id)
  {
    $this->db->where('id_customer', $id);
    $this->db->delete('customers');

    return $this->db->affected_rows();
  }
}
  
  /* End of file Customer_m.php */
