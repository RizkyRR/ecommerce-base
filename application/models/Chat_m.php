<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Chat_m extends CI_Model
{

  // DataTables Model Chat Setup
  var $column_order = array(null, 'name', 'email', 'time', 'status', null); //set column field database for datatable orderable 

  var $column_search = array('name', 'email', 'time', 'status'); //set column field database for datatable searchable

  var $order = array('time' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, MAX(time) as lastchathistory, MAX(status) as laststatus, users.id AS user_id');
    $this->db->from('chats');
    // $this->db->join('chats', 'chats.sender_id = users.id');
    $this->db->join('users', 'users.id = chats.sender_id');

    $this->db->where_not_in('users.id', $this->session->userdata('id'));
    // $this->db->where('status', "UNREAD");

    $this->db->group_by('sender_id');

    $i = 0;
    foreach ($this->column_search as $chat) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($chat, $_POST['search']['value']);
        } else {
          $this->db->or_like($chat, $_POST['search']['value']);
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
    $this->db->from('chats');
    return $this->db->count_all_results();
  }
  // DataTables Model Chat End Setup

  public function getAllChat()
  {
    $this->db->select('*');
    $this->db->from('chats');
    // $this->db->join('chats', 'chats.sender_id = users.id');
    $this->db->join('users', 'users.id = chats.sender_id');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getChatByID($receiver_id)
  {
    $sender_id = $this->session->userdata('id');

    $this->db->select('*');
    $this->db->from('chats');
    // $this->db->join('chats', 'chats.sender_id = users.id');
    $this->db->join('users', 'users.id = chats.sender_id');

    $condition = "`sender_id`= '$sender_id' AND `receiver_id` = '$receiver_id' OR `sender_id`= '$receiver_id' AND `receiver_id` = '$sender_id'";

    $this->db->where($condition);

    $this->db->order_by('time', 'ASC');

    $query = $this->db->get();
    return $query->result_array();

    // return $this->db->get_where('chats', ['sender_id' => $id])->result_array();
  }

  public function createMessage($data)
  {
    $this->db->insert('chats', $data);
  }

  public function update($sender_id, $receiver_id, $data)
  {
    // $receiver_id = $this->session->userdata('id');

    if ($this->session->userdata('id') == $receiver_id) {
      $condition = "`sender_id`= '$sender_id' AND `receiver_id` = '$receiver_id'";

      $this->db->where($condition);
      $this->db->update('chats', $data);
    } else {
      return false;
    }
  }

  public function getUnreadMessageCount()
  {
    $this->db->select('COUNT(*)');
    $this->db->from('chats');
    $this->db->join('users', 'users.id = chats.sender_id');

    $this->db->where_not_in('users.id', $this->session->userdata('id'));
    $this->db->where('status = "UNREAD"');

    $this->db->group_by('sender_id');

    return $this->db->count_all_results();
  }
}
  
  /* End of file Chat_m.php */
