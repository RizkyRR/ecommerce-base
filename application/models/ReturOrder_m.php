<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ReturOrder_m extends CI_Model
{
  // DataTables Model Setup

  var $column_order = array(null, 'id', 'retur_date', 'order_id', null, 'discount', 'net_amount'); //set column field database for datatable orderable 

  var $column_search = array('id', 'retur_date', 'order_id'); //set column field database for datatable searchable

  var $order = array('retur_date' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, COUNT(retur_id) as total');
    $this->db->from('order_returns');
    $this->db->join('order_return_details', 'order_return_details.retur_id = order_returns.id');
    $this->db->group_by('retur_id');

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
    $this->db->from('order_returns');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

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

  public function insertOrderRetur($data)
  {
    $this->db->insert('order_returns', $data);
  }

  public function insertOrderReturDetails($data)
  {
    $this->db->insert('order_return_details', $data);
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
