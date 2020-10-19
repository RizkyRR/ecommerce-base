<?php

defined('BASEPATH') or exit('No direct script access allowed');

class StoreBanner_m extends CI_Model
{

  public function getAllStoreBanner()
  {
    $query = $this->db->get('store_banner');
    return $query->result_array();
  }

  public function getDetailTitleBanner($id)
  {
    $query = $this->db->get_where('store_banner', ['title' => $id]);
    return $query->row_array();
  }

  public function insertStoreBanner($data)
  {
    $this->db->insert('store_banner', $data);
    return $this->db->insert_id();
  }

  public function getDataStoreBanner($id)
  {
    $query = $this->db->get_where('store_banner', ['id' => $id]);
    return $query->row_array();
  }

  public function updateStoreBanner($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('store_banner', $data);
    return $this->db->affected_rows();
  }

  public function deleteStoreBanner($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('store_banner');
    return $this->db->affected_rows();
  }
}

/* End of file StoreBanner_m.php */
