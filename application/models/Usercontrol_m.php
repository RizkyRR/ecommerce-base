<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usercontrol_m extends CI_Model
{
  // DataTables Model Setup

  var $column_order = array(null, 'name', 'email', 'role', 'is_active', 'created_at'); //set column field database for datatable orderable 

  var $column_search = array('name', 'email', 'role', 'is_active', 'created_at'); //set column field database for datatable searchable

  var $order = array('users.id' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('users.*, users.id AS user_id, user_role.role');
    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id');

    $i = 0;
    foreach ($this->column_search as $user) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($user, $_POST['search']['value']);
        } else {
          $this->db->or_like($user, $_POST['search']['value']);
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
    $this->db->from('users');
    return $this->db->count_all_results();
  }

  // DataTables Model End Setup

  public function getCountPage()
  {
    $this->db->select('users.*, users.id AS user_id, user_role.role');
    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id');

    $query = $this->db->get();
    return $query->num_rows();
  }

  /* public function getAllUser($limit, $offset, $keyword)
  {
    if ($keyword) {
      $this->db->like('users.role_id', $keyword);
      $this->db->or_like('name', $keyword);
      $this->db->or_like('email', $keyword);
      $this->db->or_like('user_role.role', $keyword); // yang dimaksud bukan integernya tapi stringnya dari table user_role
    }

    $this->db->select('users.*, users.id AS user_id, user_role.role');
    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id');

    $this->db->order_by('name', 'ASC'); // must be specify which the part of table

    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result_array();
  } */

  public function getAllUser()
  {
    $this->db->select('users.*, users.id AS user_id, user_role.role');
    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id');

    $this->db->order_by('name', 'ASC'); // must be specify which the part of table 

    $query = $this->db->get();
    return $query->result_array();
  }

  public function _getAllRole()
  {
    $query = $this->db->get('user_role');
    return $query->result_array();
  }

  public function getAllRoleBySelect($keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('user_role');

    if ($keyword != null) {
      $this->db->like('id', $keyword);
      $this->db->or_like('role', $keyword);
    }

    $this->db->order_by('role', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getUserRoleByID($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('user_role');

    return $query->row_array();
  }

  public function getUserControlById($id)
  {
    $this->db->select('*, users.id AS user_id, user_role.id AS id_role');

    $this->db->from('users');
    $this->db->join('user_role', 'users.role_id = user_role.id', 'left');

    $this->db->where('users.id', $id);

    // $this->db->order_by('name', 'ASC'); // must be specify which the part of table 

    $query = $this->db->get();
    return $query->row_array();
    // return $this->db->get_where('users', ['id' => $id])->row_array();
  }

  public function insertUserControl($data)
  {
    $this->db->insert('users', $data);

    return $this->db->affected_rows();
  }

  public function updateUserControl($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('users', $data);

    return $this->db->affected_rows();
  }

  public function deleteUserControl($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('users');

    return $this->db->affected_rows();
  }
}
  
  /* End of file Usercontrol_m.php */
