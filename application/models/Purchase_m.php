<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_m extends CI_Model
{

  // DataTables Model Setup
  var $column_order = array(null, 'purchase_id', 'supplier_name', 'supplier_phone', 'purchase_date', null, 'net_amount', 'paid_status', null); //set column field database for datatable orderable 

  var $column_search = array('purchase_id', 'supplier_name', 'supplier_phone', 'purchase_date', 'net_amount', 'paid_status', 'user_create'); //set column field database for datatable searchable

  var $order = array('purchase.id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    // https://stackoverflow.com/questions/34385680/datatables-joining-tables-search-and-order-stuck-with-codeigniter

    // https://stackoverflow.com/questions/26484211/error-in-your-sql-syntax-check-the-manual-that-corresponds-to-your-mysql-server

    // https://stackoverflow.com/questions/9870154/datatables-server-side-processing-inner-join-or-multiple-tables

    // https://stackoverflow.com/questions/21479079/how-to-join-three-tables-in-codeigniter

    // https://stackoverflow.com/questions/55318335/how-to-post-multiple-select-value-into-datatables-in-codeigniter

    // https://www.patchesoft.com/datatables-with-codeigniter-server-side-part-2

    // https://newcodingera.com/datatable-using-codeigniter-part-1/

    $this->db->select('*, COUNT(purchase_id) AS jumlah, purchase.id AS id_purchase');
    $this->db->from('purchase');
    $this->db->join('purchase_details', 'purchase_details.purchase_id = purchase.id', 'left');
    $this->db->join('suppliers', 'suppliers.id = purchase.supplier_id', 'left');

    $this->db->group_by('purchase.id');

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
    $this->db->get('purchase');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getPurchaseByID($id)
  {
    $this->db->select('*, purchase.id AS purchase_id');
    $this->db->from('purchase');
    $this->db->join('suppliers', 'suppliers.id = purchase.supplier_id');
    $this->db->where('purchase.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getOrderDetailsByID($id)
  {
    return $this->db->get_where('purchase_details', ['purchase_id' => $id])->result_array();
  }

  public function getProduct($id)
  {
    $this->db->select('*, products.id AS product_id, suppliers.id AS supplier_id');
    $this->db->from('products');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');

    $this->db->where('supplier_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSupplier()
  {
    $this->db->order_by('supplier_name', 'ASC');

    $query = $this->db->get('suppliers');
    return $query->result_array();
  }

  public function insertOrders($data)
  {
    $this->db->insert('purchase', $data);
  }

  public function insertOrderDetails($data)
  {
    $this->db->insert('purchase_details', $data);
  }

  public function insertPurchaseDebt($data)
  {
    $this->db->insert('purchase_hutang', $data);
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('purchase', $data);
  }
}

/* End of file Purchase_m.php */
