<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ReturPurchase_m extends CI_Model
{

  // DataTables Model Setup
  var $column_order = array(null, 'id', 'retur_date', 'purchase_id', null, 'discount', 'net_amount', null); //set column field database for datatable orderable 

  var $column_search = array('id', 'retur_date', 'purchase_id', 'user_create'); //set column field database for datatable searchable

  var $order = array('retur_date' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, COUNT(retur_id) AS total');
    $this->db->from('purchase_returns');
    $this->db->join('purchase_return_details', 'purchase_return_details.retur_id = purchase_returns.id');
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
    $this->db->from('purchase_returns');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getProductPurchase($id)
  {
    $this->db->select('*');
    $this->db->from('purchase_details');
    // $this->db->join('purchase_details', 'purchase_details.purchase_id = purchase.id');
    $this->db->join('products', 'products.id = purchase_details.product_id');

    $this->db->where('purchase_id', $id);

    $query = $this->db->get();
    return $query->result_array();

    // return $this->db->get_where('purchase_details', ['purchase_id' => $id])->result_array();
  }

  public function getProductDetailsQtyByID($id)
  {
    $this->db->where('product_id', $id);
    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get('purchase_details');
    return $query->row_array();
  }

  public function getProductDetailsByID($id)
  {
    $this->db->select('*, purchase_details.qty AS order_qty');
    $this->db->from('purchase_details');
    $this->db->join('products', 'products.id = purchase_details.product_id');

    $this->db->where('product_id', $id);

    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get();
    return $query->row_array();

    /* $this->db->where('product_id', $id);
    $this->db->order_by('product_id', 'ASC');

    $query = $this->db->get('purchase_details');
    return $query->row_array();*/
  }

  public function getPurchase()
  {
    $this->db->where('paid_status', "LUNAS");

    $query = $this->db->get('purchase');
    return $query->result_array();
  }

  public function insertPurchaseRetur($data)
  {
    $this->db->insert('purchase_returns', $data);
  }

  public function insertPurchaseReturDetails($data)
  {
    $this->db->insert('purchase_return_details', $data);
  }

  public function getReturPurchaseById($id)
  {
    $this->db->select('*, purchase_returns.id AS retur_id, purchase_returns.discount AS retur_discount, purchase_returns.gross_amount AS retur_gross_amount, purchase_returns.net_amount AS retur_net_amount');
    $this->db->from('purchase_returns');
    $this->db->join('purchase', 'purchase.id = purchase_returns.purchase_id');

    $this->db->where('purchase_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getReturPurchaseDetailsById($id)
  {
    $this->db->select('*');
    $this->db->from('purchase_return_details');
    $this->db->join('purchase_returns', 'purchase_returns.id = purchase_return_details.retur_id');

    $this->db->where('purchase_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSimplePurchaseById($id)
  {
    return $this->db->get_where('purchase', ['id' => $id])->row_array();
  }

  public function getPurchaseById($id)
  {
    $this->db->select('*');
    $this->db->from('purchase');
    $this->db->join('purchase_details', 'purchase_details.purchase_id = purchase.id');

    $this->db->where('id', $this->input->post('purchase_id'));
    $this->db->where('product_id', $id);

    // $this->db->group_by('purchase_id');
    // $this->db->join('purchase_hutang', 'purchase_hutang.purchase_id = purchase.id');

    $query = $this->db->get();
    return $query->row_array();

    // return $this->db->get_where('purchase', ['id' => $id])->row_array();
  }

  public function getPurchaseDetailsById($id)
  {
    return $this->db->get_where('purchase_details', ['purchase_id' => $id])->result_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('purchase', $data);
  }

  public function updatePurchaseDetail($id, $data)
  {
    $this->db->where('purchase_id', $this->input->post('purchase_id'));
    $this->db->where('product_id', $id);
    $this->db->update('purchase_details', $data);
  }

  public function deletePurchase($id)
  {
    $sql = "DELETE purchase,purchase_details,purchase_hutang 
        FROM purchase,purchase_details,purchase_hutang 
        WHERE purchase_details.purchase_id=purchase.id 
        AND purchase.id=purchase_hutang.purchase_id 
        AND purchase.id= ?";

    $this->db->query($sql, array($id));
  }
}
  
  /* End of file ReturPurchase_m.php */
