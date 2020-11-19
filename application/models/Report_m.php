<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'customer_purchase_orders.invoice_order', 'customer_purchase_orders.customer_email', 'customers.customer_name', 'customer_purchase_orders.created_date', 'SUM(customer_purchase_order_details.qty)', 'customer_purchase_orders.net_amount', 'status_orders.status_name', null); //set column field database for datatable orderable 
  var $column_search = array('customer_purchase_orders.id', 'customer_purchase_orders.invoice_order', 'customer_purchase_orders.created_date', 'status_orders.status_name'); //set column field database for datatable searchable
  var $order = array('customer_purchase_orders.created_date' => 'desc');  // default order

  private function _get_datatables_query_order($start_date, $end_date)
  {
    $this->db->select('*, COUNT(purchase_order_id) AS jumlah, SUM(customer_purchase_order_details.qty) as total_product, customer_purchase_orders.id AS id_order, customer_purchase_order_details.id AS id_order_detail, status_orders.id AS id_status, customer_purchase_orders.status_order_id AS status_order, customer_purchase_order_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customer_purchase_order_details', 'customer_purchase_order_details.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_orders.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');

    $this->db->where('created_date >=', $start_date);
    $this->db->where('created_date <=', $end_date);

    $this->db->group_by('customer_purchase_order_details.purchase_order_id');

    $i = 0;
    foreach ($this->column_search as $order) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($order, $_POST['search']['value']);
        } else {
          $this->db->or_like($order, $_POST['search']['value']);
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

  function get_datatables_order($start_date, $end_date)
  {
    $this->_get_datatables_query_order($start_date, $end_date);

    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_order($start_date, $end_date)
  {
    $this->_get_datatables_query_order($start_date, $end_date);

    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all_order($start_date, $end_date)
  {
    $this->db->where('created_date >=', $start_date);
    $this->db->where('created_date <=', $end_date);

    $this->db->from('customer_purchase_orders');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function dateRangeFilterOrder($start_date, $end_date, $search)
  {
    $this->db->select('*, COUNT(customer_purchase_order_details.purchase_order_id) AS jumlah, SUM(customer_purchase_order_details.qty) as total_product, customer_purchase_orders.id AS id_order, customer_purchase_order_details.id AS id_order_detail, status_orders.id AS id_status, customer_purchase_orders.status_order_id AS status_order, customer_purchase_order_details.status_order_id AS status_order_detail, customer_purchase_orders.created_date AS created_date_order, customers.created_at AS created_date_customer');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customer_purchase_order_details', 'customer_purchase_order_details.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_orders.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');

    if ($search != null) {
      $this->db->like('customer_purchase_orders.id', $search);
      $this->db->or_like('customer_purchase_orders.invoice_order', $search);
      $this->db->or_like('status_orders.status_name', $search);
    }

    $this->db->where('created_date >=', $start_date);
    $this->db->where('created_date <=', $end_date);

    $this->db->group_by('customer_purchase_order_details.purchase_order_id');

    $this->db->order_by('customer_purchase_orders.created_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  // DataTables Model Setup
  var $column_order_orderreturn = array(null, 'customer_purchase_returns.invoice_return', 'customer_purchase_orders.invoice_order', 'customer_purchase_returns.customer_email', 'customers.customer_name', 'customer_purchase_returns.created_date', 'SUM(customer_purchase_return_details.qty)', 'customer_purchase_returns.net_amount', 'status_orders.status_name', null); //set column field database for datatable orderable 
  var $column_search_orderreturn = array('customer_purchase_returns.invoice_return', 'customer_purchase_orders.invoice_order', 'customer_purchase_returns.customer_email', 'customers.customer_name', 'customer_purchase_returns.created_date', 'status_orders.status_name'); //set column field database for datatable searchable
  var $order_orderreturn = array('customer_purchase_returns.created_date' => 'desc');  // default order

  private function _get_datatables_query_order_return($start_date, $end_date)
  {
    $this->db->select('*, COUNT(purchase_return_id) AS jumlah, customer_purchase_orders.id AS id_order, SUM(customer_purchase_return_details.qty) as total_product, customer_purchase_returns.id AS id_return, customer_purchase_return_details.id AS id_return_detail, status_orders.id AS id_status, customer_purchase_returns.status_order_id AS status_order, customer_purchase_return_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_details', 'customer_purchase_return_details.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customer_purchase_orders', 'customer_purchase_orders.id = customer_purchase_returns.purchase_order_id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_returns.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_returns.customer_email', 'left');

    $this->db->where('customer_purchase_returns.created_date >=', $start_date);
    $this->db->where('customer_purchase_returns.created_date <=', $end_date);

    $this->db->group_by('customer_purchase_return_details.purchase_return_id');

    $i = 0;
    foreach ($this->column_search_orderreturn as $order_return) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($order_return, $_POST['search']['value']);
        } else {
          $this->db->or_like($order_return, $_POST['search']['value']);
        }
        if (count($this->column_search_orderreturn) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) { // here order processing
      $this->db->order_by($this->column_order_orderreturn[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order_orderreturn)) {
      $order = $this->order_orderreturn;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables_order_return($start_date, $end_date)
  {
    $this->_get_datatables_query_order_return($start_date, $end_date);

    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered_order_return($start_date, $end_date)
  {
    $this->_get_datatables_query_order_return($start_date, $end_date);

    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all_order_return($start_date, $end_date)
  {
    $this->db->where('created_date >=', $start_date);
    $this->db->where('created_date <=', $end_date);

    $this->db->from('customer_purchase_returns');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function dateRangeFilterOrderReturn($start_date, $end_date, $search)
  {
    $this->db->select('*, COUNT(customer_purchase_return_details.purchase_return_id) AS jumlah, customer_purchase_orders.id AS id_order, SUM(customer_purchase_return_details.qty) as total_product, customer_purchase_returns.id AS id_return, customer_purchase_return_details.id AS id_return_detail, status_orders.id AS id_status, customer_purchase_returns.status_order_id AS status_order, customer_purchase_return_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_details', 'customer_purchase_return_details.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customer_purchase_orders', 'customer_purchase_orders.id = customer_purchase_returns.purchase_order_id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_returns.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_returns.customer_email', 'left');

    if ($search != null) {
      $this->db->like('customer_purchase_returns.id', $search);
      $this->db->or_like('customer_purchase_returns.invoice_return', $search);
      $this->db->or_like('status_orders.status_name', $search);
    }

    $this->db->where('customer_purchase_returns.created_date >=', $start_date);
    $this->db->where('customer_purchase_returns.created_date <=', $end_date);

    $this->db->group_by('customer_purchase_return_details.purchase_return_id');

    $this->db->order_by('customer_purchase_returns.created_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }
}

/* End of file Report_m.php */
