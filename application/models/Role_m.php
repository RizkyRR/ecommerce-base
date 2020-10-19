<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Role_m extends CI_Model
{
  // DataTables Model Setup

  var $column_order = array(null, 'role'); //set column field database for datatable orderable 

  var $column_search = array('role'); //set column field database for datatable searchable

  var $order = array('id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*');
    $this->db->from('user_role');

    $i = 0;
    foreach ($this->column_search as $role) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($role, $_POST['search']['value']);
        } else {
          $this->db->or_like($role, $_POST['search']['value']);
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
    $this->db->from('user_role');
    return $this->db->count_all_results();
  }

  // DataTables Model End Setup

  public function getSearchRole($limit, $offset)
  {
    $keyword = $this->input->post('search', true);
    $this->db->or_like('role', $keyword);

    return $this->db->get('user_role', $limit, $offset)->result_array();
  }

  public function getUserSession()
  {
    return $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
  }

  public function getAllMenu()
  {
    $this->db->where('id !=', 1);
    $query = $this->db->get('user_menu');
    return $query->result_array();
  }

  /* public function getAllRole($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('id', $keyword);
      $this->db->or_like('role', $keyword);
    }

    $this->db->order_by('id', 'DESC');

    $query = $this->db->get('user_role', $limit, $offset);
    return $query->result_array();
  } */

  public function getAllRole()
  {

    $this->db->order_by('id', 'ASC');

    $query = $this->db->get('user_role');
    return $query->result_array();
  }

  public function getCheckRoleName($data)
  {
    $this->db->select('role');
    $this->db->where('role', $data);

    $query = $this->db->get('user_role');

    if ($query->num_rows() > 0) {
      //Value exists in database
      return TRUE;
    } else {
      //Value doesn't exist in database
      return FALSE;
    }
  }

  public function insertRole($data)
  {
    $this->db->insert('user_role', $data);
  }

  public function updateRole($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('user_role', $data);
  }

  public function getAccessById($id)
  {
    return $this->db->get_where('user_role', ['id' => $id])->row_array();
  }

  public function updateAccessRole($data)
  {
    $query = $this->db->get_where('user_access_menu', $data);

    if ($query->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }
  }

  public function deleteRole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
  }
}
  
  /* End of file Role_m.php */
