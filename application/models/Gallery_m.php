<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'image', 'info', null); //set column field database for datatable orderable 

  var $column_search = array('image', 'info'); //set column field database for datatable searchable

  var $order = array('id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('gallery');

    $i = 0;
    foreach ($this->column_search as $gallery) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($gallery, $_POST['search']['value']);
        } else {
          $this->db->or_like($gallery, $_POST['search']['value']);
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
    $this->db->from('gallery');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getAllImage()
  {
    $query = $this->db->get('gallery');
    return $query->result_array();
  }

  public function getImageByID($id)
  {
    return $this->db->get_where('gallery', ['id' => $id])->row_array();
  }

  public function insertImages($data)
  {
    $this->db->insert('gallery', $data);
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('gallery');
  }
}
  
  /* End of file Gallery_m.php */
