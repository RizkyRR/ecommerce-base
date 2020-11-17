<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Message_m extends CI_Model
{

  // DataTables Model Setup
  var $column_order = array(null, 'customer_purchase_orders.invoice_order', 'customers.customer_email', 'customers.customer_name', 'customer_messages.read_status', 'customer_messages.message_datetime', null); //set column field database for datatable orderable 
  var $column_search = array('customer_purchase_orders.invoice_order', 'customers.customer_email', 'customers.customer_name', 'customer_messages.read_status',  'customer_messages.message_datetime'); //set column field database for datatable searchable
  var $order = array('customer_messages.message_datetime' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, customer_messages.id AS id_message, customer_purchase_orders.id AS id_order');

    $this->db->from('customer_messages');
    $this->db->join('customer_purchase_orders', 'customer_purchase_orders.id = customer_messages.purchase_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_messages.customer_email', 'left');

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
    $this->db->from('customer_messages');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getDetailMessagePayReportByID($id)
  {
    $this->db->select('*, customer_messages.id AS id_message, customer_purchase_orders.id AS id_order');

    $this->db->from('customer_messages');
    $this->db->join('customer_purchase_orders', 'customer_purchase_orders.id = customer_messages.purchase_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_messages.customer_email', 'left');

    $this->db->where('customer_messages.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCountIncomingUnreadMessage()
  {
    $this->db->where('read_status', "UNREAD");
    $query = $this->db->get('customer_messages');

    return $query->num_rows();
  }

  public function getCountIncomingUnreadReview()
  {
    $this->db->where('read_status', "UNREAD");
    $query = $this->db->get('customer_comments');

    return $query->num_rows();
  }

  public function updateStatusReadMessage($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('customer_messages', $data);

    return $this->db->affected_rows();
  }
}
  
  /* End of file Message_m.php */
