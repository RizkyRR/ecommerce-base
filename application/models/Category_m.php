<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category_m extends CI_Model
{

  // DataTables Model Setup

  var $column_order = array(null, 'category_name'); //set column field database for datatable orderable 

  var $column_search = array('category_name'); //set column field database for datatable searchable

  var $order = array('id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('product_categories');

    $i = 0;
    foreach ($this->column_search as $category) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($category, $_POST['search']['value']);
        } else {
          $this->db->or_like($category, $_POST['search']['value']);
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
    $this->db->from('product_categories');
    return $this->db->count_all_results();
  }

  // DataTables Model End Setup

  public function getAllCategory($keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('product_categories');

    if ($keyword != null) {
      $this->db->like('id', $keyword);
      $this->db->or_like('category_name', $keyword);
    }

    $this->db->order_by('category_name', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getCategory()
  {
    $this->db->order_by('category_name', 'ASC');

    $query = $this->db->get('product_categories');
    return $query->result_array();
  }

  public function insert($data)
  {
    $this->db->insert('product_categories', $data);
  }

  public function getCategoryById($id)
  {
    return $this->db->get_where('product_categories', ['id' => $id])->row_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('product_categories', $data);
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('product_categories');
  }
}
  
  /* End of file Category_m.php */
