<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_m extends CI_Model
{
  // DataTables Model Setup

  var $column_order = array(null, 'supplier_name', 'supplier_phone', 'supplier_address', 'credit_card_type', 'credit_card_number'); //set column field database for datatable orderable 

  var $column_search = array('supplier_name', 'supplier_phone', 'supplier_address', 'credit_card_type', 'credit_card_number'); //set column field database for datatable searchable

  var $order = array('id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('suppliers');

    $i = 0;
    foreach ($this->column_search as $supplier) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($supplier, $_POST['search']['value']);
        } else {
          $this->db->or_like($supplier, $_POST['search']['value']);
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
    $this->db->from('suppliers');
    return $this->db->count_all_results();
  }

  // DataTables Model End Setup

  public function getAllSupplier($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('supplier_id', $keyword);
      $this->db->or_like('supplier_name', $keyword);
      $this->db->or_like('supplier_phone', $keyword);
      $this->db->or_like('supplier_address', $keyword);
      $this->db->or_like('credit_card_type', $keyword);
      $this->db->or_like('credit_card_number', $keyword);
    }

    $this->db->order_by('created_at', 'DESC');

    $query = $this->db->get('suppliers', $limit, $offset);
    return $query->result_array();
  }

  public function custom_code()
  {
    $this->db->select('RIGHT(suppliers.id,4) as kode', FALSE);
    $this->db->order_by('id', 'desc');
    $this->db->limit(1);

    $this->db->get('suppliers');
  }

  public function getSupplier($keyword, $limit)
  {
    /* $this->db->order_by('created_at', 'DESC');

    $query = $this->db->get('suppliers');
    return $query->result_array(); */

    $this->db->select('*');
    $this->db->from('suppliers');

    if ($keyword != null) {
      $this->db->like('id', $keyword);
      $this->db->or_like('supplier_name', $keyword);
    }

    $this->db->order_by('supplier_name', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('suppliers', $data);
  }

  public function getSupplierById($id)
  {
    return $this->db->get_where('suppliers', ['id' => $id])->row_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('suppliers', $data);
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('suppliers');
  }
}
  
  /* End of file Supplier_m.php */
