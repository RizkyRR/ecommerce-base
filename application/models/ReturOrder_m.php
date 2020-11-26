<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ReturOrder_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'customer_purchase_returns.invoice_return', 'customer_purchase_orders.invoice_order', 'customer_purchase_returns.customer_email', 'customers.customer_name', 'customer_purchase_returns.created_date', 'SUM(customer_purchase_return_details.qty)', 'customer_purchase_returns.net_amount', 'status_orders.status_name', null); //set column field database for datatable orderable 
  var $column_search = array('customer_purchase_returns.invoice_return', 'customer_purchase_orders.invoice_order', 'customer_purchase_returns.customer_email', 'customers.customer_name', 'customer_purchase_returns.created_date', 'status_orders.status_name'); //set column field database for datatable searchable
  var $order = array('customer_purchase_returns.created_date' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, SUM(customer_purchase_return_details.qty) as total_product, customer_purchase_returns.id AS id_return, customer_purchase_return_details.id AS id_return_detail, status_orders.id AS id_status, customer_purchase_returns.status_order_id AS status_order, customer_purchase_return_details.status_order_id AS status_order_detail');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_details', 'customer_purchase_return_details.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customer_purchase_orders', 'customer_purchase_orders.id = customer_purchase_returns.purchase_order_id', 'left');
    $this->db->join('status_orders', 'status_orders.id = customer_purchase_returns.status_order_id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_returns.customer_email', 'left');

    $this->db->group_by('customer_purchase_return_details.purchase_return_id');

    $i = 0;
    foreach ($this->column_search as $retur) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($retur, $_POST['search']['value']);
        } else {
          $this->db->or_like($retur, $_POST['search']['value']);
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
    $this->db->from('customer_purchase_returns');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  // CANCEL BUTTON CONDITION
  public function getReturnStatusPendingForCancelByID($id)
  {
    $this->db->where('id', $id);

    $query = $this->db->get('customer_purchase_returns');

    return $query->row_array();
  }

  // GET RETURN APPROVE BUTTON 
  public function getReturnStatusPendingForApproveByID($id)
  {
    $this->db->where('id', $id);
    $this->db->where('status_order_id', 5);

    $query = $this->db->get('customer_purchase_returns');

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // GET RETURN STATUS ON PROCESS
  public function getReturnStatusProcessByID($id)
  {
    $this->db->where('id', $id);
    $this->db->where('status_order_id', 6);

    $query = $this->db->get('customer_purchase_returns');

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // GET RETURN STATUS ON PROCESS
  public function getReturnStatusSuccessByID($id)
  {
    $this->db->select('*, customer_purchase_returns.id AS id_return, customer_purchase_return_approves.id AS id_return_approves');

    $this->db->from('customer_purchase_return_approves');
    $this->db->join('customer_purchase_returns', 'customer_purchase_returns.id = customer_purchase_return_approves.purchase_return_id', 'left');

    $this->db->where('customer_purchase_return_approves.purchase_return_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  // FOR APPROVE RETURN MODAL
  public function getPurchaseReturnForApprove($return_id)
  {
    $this->db->select('*, customer_purchase_returns.id AS id_return, customer_purchase_return_shipping.id AS id_return_shipping, customers.customer_email AS email');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_shipping', 'customer_purchase_return_shipping.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_returns.customer_email', 'left');

    $this->db->where('customer_purchase_returns.id', $return_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getPurchaseReturnApproved($return_id)
  {
    $this->db->select('*, customer_purchase_returns.id AS id_return, customer_purchase_return_shipping.id AS id_return_shipping, customer_purchase_return_approves.id AS id_return_approves, customers.customer_email AS email');

    $this->db->from('customer_purchase_returns');
    $this->db->join('customer_purchase_return_shipping', 'customer_purchase_return_shipping.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customer_purchase_return_approves', 'customer_purchase_return_approves.purchase_return_id = customer_purchase_returns.id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_returns.customer_email', 'left');

    $this->db->where('customer_purchase_returns.id', $return_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCheckReturnApprovedByID($return_id)
  {
    $this->db->select('*');

    $this->db->from('customer_purchase_return_approves');

    $this->db->where('purchase_return_id', $return_id);

    $query = $this->db->get();
    return $query->row_array();
  }
  // FOR APPROVE RETURN MODAL

  // APPROVER PURPOSE
  public function getCustomerReturnProductByID($return_id)
  {
    $this->db->select('*, customer_purchase_return_details.id AS id_return_detail, customer_purchase_return_details.weight AS weight_order, customer_purchase_return_details.qty AS qty_order, products.id AS id_product, products.weight AS weight_product, products.qty AS qty_product');

    $this->db->from('customer_purchase_return_details');
    $this->db->join('products', 'products.id = customer_purchase_return_details.product_id', 'left');

    $this->db->where('customer_purchase_return_details.purchase_return_id', $return_id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertPaymentApprove($data)
  {
    $this->db->insert('customer_purchase_return_approves', $data);
    return $this->db->insert_id();
  }

  public function updatePurchaseReturnFromApprove($return_id, $data)
  {
    $this->db->where('id', $return_id);
    $this->db->update('customer_purchase_returns', $data);

    return $this->db->affected_rows();
  }

  public function updatePurchaseReturnApprove($return_id, $data)
  {
    $this->db->where('purchase_return_id', $return_id);
    $this->db->update('customer_purchase_return_approves', $data);

    return $this->db->affected_rows();
  }

  public function updatePurchaseReturnShipping($return_id, $data)
  {
    $this->db->where('purchase_return_id', $return_id);
    $this->db->update('customer_purchase_return_shipping', $data);

    return $this->db->affected_rows();
  }
  // APPROVER PURPOSE

  // ADD RETURN PURPOSES
  public function getCustomerPurchaseOrder($keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('customer_purchase_orders');

    $this->db->where_not_in('status_order_id', 1);
    $this->db->where_not_in('status_order_id', 2);
    $this->db->where_not_in('status_order_id', 10);
    $this->db->where_not_in('status_order_id', 11);

    if ($keyword != null) {
      $this->db->like('id', $keyword);
      $this->db->or_like('invoice_order', $keyword);
    }

    $this->db->order_by('invoice_order', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getCustomerPurchaseOrderByID($order_id)
  {
    $this->db->select('*, customer_purchase_orders.id AS id_order, customer_address.id AS id_address');

    $this->db->from('customer_purchase_orders');
    $this->db->join('customers', 'customers.customer_email = customer_purchase_orders.customer_email', 'left');
    $this->db->join('customer_address', 'customer_address.email = customer_purchase_orders.customer_email', 'left');

    $this->db->where('customer_purchase_orders.id', $order_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCustomerOrderProductByID($order_id)
  {
    $this->db->select('*, customer_purchase_order_details.id AS id_order_detail, customer_purchase_order_details.weight AS weight_order, customer_purchase_order_details.qty AS qty_order, products.id AS id_product, products.weight AS weight_product, products.qty AS qty_product');

    $this->db->from('customer_purchase_order_details');
    $this->db->join('products', 'products.id = customer_purchase_order_details.product_id', 'left');

    $this->db->where('customer_purchase_order_details.purchase_order_id', $order_id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getProductDetailValueCustomerOrderByID($product_id)
  {
    $this->db->select('*, customer_purchase_order_details.id AS id_order_detail, customer_purchase_order_details.weight AS weight_order, customer_purchase_order_details.qty AS qty_order, products.id AS id_product, products.weight AS weight_product, products.qty AS qty_product');

    $this->db->from('customer_purchase_order_details');
    $this->db->join('products', 'products.id = customer_purchase_order_details.product_id', 'left');

    $this->db->where('product_id', $product_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCheckQtyProductOrderByID($order_id, $product_id)
  {
    $this->db->where('purchase_order_id', $order_id);
    $this->db->where('product_id', $product_id);

    $query = $this->db->get('customer_purchase_order_details');
    return $query->row_array();
  }

  public function insertOrderRetur($data)
  {
    $this->db->insert('customer_purchase_returns', $data);
  }

  public function insertOrderReturDetails($data)
  {
    $this->db->insert('customer_purchase_return_details', $data);
  }

  public function insertOrderReturShipps($data)
  {
    $this->db->insert('customer_purchase_return_shipping', $data);
  }
  // ADD RETURN PURPOSES

  public function getProductOrder($id)
  {
    $this->db->select('*');
    $this->db->from('order_details');
    // $this->db->join('order_details', 'order_details.order_id = orders.id');
    $this->db->join('products', 'products.id = order_details.product_id');

    $this->db->where('order_id', $id);

    $query = $this->db->get();
    return $query->result_array();

    // return $this->db->get_where('order_details', ['order_id' => $id])->result_array();
  }

  public function getProductDetailsQtyByID($id)
  {
    $this->db->where('product_id', $id);
    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get('order_details');
    return $query->row_array();
  }

  public function getProductDetailsByID($id)
  {
    $this->db->select('*, order_details.qty AS order_qty');
    $this->db->from('order_details');
    $this->db->join('products', 'products.id = order_details.product_id');

    $this->db->where('product_id', $id);

    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get();
    return $query->row_array();

    /* $this->db->where('product_id', $id);
    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get('order_details');
    return $query->row_array();*/
  }

  public function getOrders()
  {
    $this->db->where('paid_status', "LUNAS");

    $query = $this->db->get('orders');
    return $query->result_array();
  }

  public function getReturOrdersById($id)
  {
    $this->db->select('*, order_returns.id AS retur_id, order_returns.discount AS retur_discount, order_returns.gross_amount AS retur_gross_amount, order_returns.net_amount AS retur_net_amount');
    $this->db->from('order_returns');
    $this->db->join('orders', 'orders.id = order_returns.order_id');

    $this->db->where('order_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getReturOrderDetailsById($id)
  {
    $this->db->select('*');
    $this->db->from('order_return_details');
    $this->db->join('order_returns', 'order_returns.id = order_return_details.retur_id');

    $this->db->where('order_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSimpleOrdersById($id)
  {
    return $this->db->get_where('orders', ['id' => $id])->row_array();
  }

  public function getOrdersById($id)
  {
    $this->db->select('*');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');

    $this->db->where('id', $this->input->post('order_id'));
    $this->db->where('product_id', $id);

    // $this->db->group_by('order_id');
    // $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');

    $query = $this->db->get();
    return $query->row_array();

    // return $this->db->get_where('orders', ['id' => $id])->row_array();
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

  public function updateOrderDetail($id, $data)
  {
    $this->db->where('order_id', $this->input->post('order_id'));
    $this->db->where('product_id', $id);
    $this->db->update('order_details', $data);
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
}

/* End of file ReturOrder_m.php */
