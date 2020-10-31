<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'customer_purchase_orders.id', 'customer_purchase_orders.invoice_order', 'customer_purchase_orders.created_date', null, null, 'status_orders.status_name', null); //set column field database for datatable orderable 
  var $column_search = array('customer_purchase_orders.id', 'customer_purchase_orders.invoice_order', 'customer_purchase_orders.created_date', 'status_orders.status_name'); //set column field database for datatable searchable
  var $order = array('customer_purchase_orders.created_date' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, SUM(customer_purchase_order_details.qty) as total_product, customer_purchase_orders.id AS id_order, customer_purchase_order_details.id AS id_order_detail, status_orders.id AS id_status, customer_purchase_orders.status_order_id AS status_order, customer_purchase_order_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customer_purchase_order_details', 'customer_purchase_order_details.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_orders.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');

    $this->db->group_by('customer_purchase_order_details.purchase_order_id');

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
    $this->db->from('customer_purchase_orders');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  // Check order in order_approve AND FOR APPROVAL PURPOSES
  public function getCheckPurchaseOrderPending($order_id)
  {
    $this->db->select('*');
    $this->db->from('customer_purchase_orders');

    $this->db->where('id', $order_id);
    $this->db->where('status_order_id', 2);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getCheckPurchaseOrderApproved($order_id)
  {
    $this->db->select('*');
    $this->db->from('customer_purchase_orders');

    $this->db->where('id', $order_id);
    $this->db->where('status_order_id = 3');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getCheckPurchaseOrderComplete($order_id)
  {
    $this->db->select('*');
    $this->db->from('customer_purchase_orders');

    $this->db->where('id', $order_id);
    $this->db->where('status_order_id = 4');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getCheckPurchaseOrderCancel($order_id)
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, status_orders.id AS id_status');

    $this->db->from('customer_purchase_orders');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_orders.status_order_id', 'left');

    $this->db->where('customer_purchase_orders.id', $order_id);
    $this->db->where('status_order_id = 2 OR status_order_id = 3');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getCheckPurchaseOrderOnProcess($order_id)
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, status_orders.id AS id_status');

    $this->db->from('customer_purchase_orders');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_orders.status_order_id', 'left');

    $this->db->where('customer_purchase_orders.id', $order_id);
    $this->db->where('status_order_id', 3);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getPurchaseOrderForApprove($order_id)
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, customer_purchase_order_shipping.id AS id_order_shipping, customers.customer_email AS email');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customer_purchase_order_shipping', 'customer_purchase_order_shipping.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');

    $this->db->where('customer_purchase_orders.id', $order_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getPurchaseOrderApproved($order_id)
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, customer_purchase_order_shipping.id AS id_order_shipping, customer_purchase_order_approves.id AS id_order_approves, customers.customer_email AS email');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customer_purchase_order_shipping', 'customer_purchase_order_shipping.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('customer_purchase_order_approves', 'customer_purchase_order_approves.purchase_order_id = customer_purchase_orders.id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');

    $this->db->where('customer_purchase_orders.id', $order_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function insertPaymentApprove($data)
  {
    $this->db->insert('customer_purchase_order_approves', $data);
    return $this->db->insert_id();
  }

  public function updatePurchaseOrderApprove($order_id, $data)
  {
    $this->db->where('purchase_order_id', $order_id);
    $this->db->update('customer_purchase_order_approves', $data);

    return $this->db->affected_rows();
  }

  public function updatePurchaseOrderFromApprove($order_id, $data)
  {
    $this->db->where('id', $order_id);
    $this->db->update('customer_purchase_orders', $data);

    return $this->db->affected_rows();
  }

  public function updatePurchaseOrderShipping($order_id, $data)
  {
    $this->db->where('purchase_order_id', $order_id);
    $this->db->update('customer_purchase_order_shipping', $data);

    return $this->db->affected_rows();
  }

  public function getPurchaseOrderDetail($order_id)
  {
    $this->db->select('*, customer_purchase_order_details.id AS id_order_detail, products.id AS id_product, customer_purchase_order_details.qty AS qty_order_detail, products.qty AS qty_product');

    $this->db->from('customer_purchase_order_details');
    $this->db->join('products', 'products.id = customer_purchase_order_details.product_id', 'left');

    $this->db->where('customer_purchase_order_details.purchase_order_id', $order_id);

    $query = $this->db->get();
    return $query->result_array();
  }
  // Check order in order_approve AND FOR APPROVAL PURPOSES

  // CANCEL PAYMENT 
  public function getCheckPaymentApprovedByID($order_id)
  {
    $this->db->select('*');

    $this->db->from('customer_purchase_order_approves');

    $this->db->where('purchase_order_id', $order_id);

    $query = $this->db->get();
    return $query->row_array();
  }
  // CANCEL PAYMENT

  public function getPiutangCountPage()
  {
    $this->db->select('*');
    $this->db->from('orders');
    $this->db->join('order_piutang', 'order_piutang.order_id = orders.id', 'inner');
    $this->db->group_by('order_id');

    $query = $this->db->get();
    return $query->num_rows();
  }

  public function getOrdersCountPages()
  {
    $this->db->select('*, COUNT(order_id) as total');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');
    $this->db->group_by('order_id');

    $query = $this->db->get();
    return $query->num_rows();
  }

  public function getAllOrders($limit, $offset, $keyword)
  {
    $this->db->select('*, COUNT(order_id) as total');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');
    $this->db->group_by('order_id');
    // $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');


    if ($keyword) {
      $this->db->like('id', $keyword);
      $this->db->or_like('customer_name', $keyword);
      $this->db->or_like('customer_phone', $keyword);
      $this->db->or_like('customer_address', $keyword);
    }

    $this->db->order_by('order_date', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getOrders()
  {
    $query = $this->db->get('orders');
    return $query->result_array();
  }

  public function insertOrders($data)
  {
    $this->db->insert('orders', $data);
  }

  public function insertOrderDetails($data)
  {
    $this->db->insert('order_details', $data);
  }

  public function getOrdersById($id)
  {
    /* $this->db->select('*, COUNT(order_id) as total');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');

    $this->db->where('id', $id);

    // $this->db->group_by('order_id');
    // $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');

    $query = $this->db->get();
    return $query->row_array(); */

    return $this->db->get_where('orders', ['id' => $id])->row_array();
  }

  public function getOrderDetailsById($id)
  {
    return $this->db->get_where('order_details', ['order_id' => $id])->result_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('orders', $data);
  }

  public function deleteOrder($id)
  {
    $sql = "DELETE orders,order_details,order_piutang 
        FROM orders,order_details,order_piutang 
        WHERE order_details.order_id=orders.id 
        AND orders.id=order_piutang.order_id 
        AND orders.id= ?";

    $this->db->query($sql, array($id));
  }

  // Searching Filter
  public function dateRangeFilter($startdate, $enddate)
  {
    $this->db->select('*, COUNT(order_id) as jumlah');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');
    $this->db->where('order_date >=', $startdate);
    $this->db->where('order_date <=', $enddate);
    $this->db->where('paid_status = "Lunas"');
    $this->db->group_by('order_id');

    $this->db->order_by('order_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  //  ACCOUNTS RECEIVABLE MODEL
  public function dateRangeFilterPiutang($startdate, $enddate)
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(piutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('orders');
    $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');
    $this->db->where('piutang_paid_history >=', $startdate);
    $this->db->where('piutang_paid_history <=', $enddate);
    $this->db->group_by('order_id');

    $this->db->order_by('piutang_paid_history', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertPiutang($data)
  {
    $this->db->insert('order_piutang', $data);
  }

  public function deletePiutang($id)
  {
    $this->db->where('order_id', $id);
    $this->db->delete('order_piutang');
  }

  public function getAllPiutang($limit, $offset, $keyword)
  {
    // https://www.google.com/search?q=pick+the+last+date+insert+with+same+id&oq=pick+the+last+date+insert+with+same+id&aqs=chrome..69i57j33.12023j0j7&sourceid=chrome&ie=UTF-8
    $this->db->select('*, SUM(amount_paid) as total, MAX(piutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('orders');
    $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');
    $this->db->group_by('order_id');

    if ($keyword) {
      $this->db->like('order_id', $keyword);
      $this->db->or_like('piutang_id', $keyword);
    }

    $this->db->order_by('piutang_paid_history', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getPiutangById($id)
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(piutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('orders');
    $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');
    $this->db->where('order_piutang.order_id', $id);
    $this->db->group_by('order_id');


    $query = $this->db->get();
    return $query->row_array();
    // return $this->db->get_where('order_piutang', ['order_id' => $id])->row_array();
  }

  public function getPiutangAllById($id)
  {
    return $this->db->get_where('order_piutang', ['order_id' => $id])->result_array();
  }
}
  
  /* End of file Order_m.php */
