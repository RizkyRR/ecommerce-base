<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'brand_name', null); //set column field database for datatable orderable 
  var $column_search = array('brand_name'); //set column field database for datatable searchable
  var $order = array('brand_name' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('product_brands');

    $i = 0;
    foreach ($this->column_search as $brand) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($brand, $_POST['search']['value']);
        } else {
          $this->db->or_like($brand, $_POST['search']['value']);
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
    $this->db->from('product_brands');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getAllBrandBySelect($keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('product_brands');

    if ($keyword != null) {
      $this->db->like('id', $keyword);
      $this->db->or_like('brand_name', $keyword);
    }

    $this->db->order_by('brand_name', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertBrand($data)
  {
    $this->db->insert('product_brands', $data);
    return $this->db->affected_rows();
  }

  public function getDetailBrandByID($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('product_brands');

    return $query->row_array();
  }

  public function updateBrand($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('product_brands', $data);

    return $this->db->affected_rows();
  }

  public function deleteBrand($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('product_brands');

    return $this->db->affected_rows();
  }
}
  
  /* End of file Brand_m.php */
