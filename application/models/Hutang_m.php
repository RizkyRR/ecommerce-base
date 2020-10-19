<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hutang_m extends CI_Model
{
  // DataTables Model Setup
  var $column_order = array(null, 'hutang_id', 'purchase_id', null, null, null, null, null); //set column field database for datatable orderable 

  var $column_search = array('hutang_id', 'purchase_id', 'purchase_hutang.user_create'); //set column field database for datatable searchable

  var $order = array('hutang_paid_history' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(hutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('purchase');
    $this->db->join('purchase_hutang', 'purchase_hutang.purchase_id = purchase.id');
    $this->db->group_by('purchase_id');

    $i = 0;
    foreach ($this->column_search as $hutang) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($hutang, $_POST['search']['value']);
        } else {
          $this->db->or_like($hutang, $_POST['search']['value']);
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
    $this->db->from('purchase_hutang');
    return $this->db->count_all_results();
  }
  // DataTables Model End Setup

  public function getAllDebt()
  {
    // https://www.google.com/search?q=pick+the+last+date+insert+with+same+id&oq=pick+the+last+date+insert+with+same+id&aqs=chrome..69i57j33.12023j0j7&sourceid=chrome&ie=UTF-8
    $this->db->select('*, SUM(amount_paid) as total, MAX(hutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('purchase');
    $this->db->join('purchase_hutang', 'purchase_hutang.purchase_id = purchase.id');
    $this->db->group_by('purchase_id');

    $this->db->order_by('hutang_paid_history', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getDebtById($id)
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(hutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('purchase');
    $this->db->join('purchase_hutang', 'purchase_hutang.purchase_id = purchase.id');
    $this->db->where('purchase_hutang.purchase_id', $id);
    $this->db->group_by('purchase_id');


    $query = $this->db->get();
    return $query->row_array();
    // return $this->db->get_where('purchase_hutang', ['purchase_id' => $id])->row_array();
  }

  public function getDebtAllById($id)
  {
    return $this->db->get_where('purchase_hutang', ['purchase_id' => $id])->result_array();
  }

  public function insertHutang($data)
  {
    $this->db->insert('purchase_hutang', $data);
  }

  public function deleteHutang($id)
  {
    $this->db->where('purchase_id', $id);
    $this->db->delete('purchase_hutang');
  }
}
  
  /* End of file Hutang_m.php */
