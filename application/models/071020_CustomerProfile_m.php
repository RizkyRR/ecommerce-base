<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerProfile_m extends CI_Model
{

  public function getCustomerData($id)
  {
    $this->db->where('customer_email', $id);
    $query = $this->db->get('customers');

    return $query->row_array();
  }

  public function getGenders()
  {
    $query = $this->db->get('genders');

    return $query->result_array();
  }

  public function updateCustomer($id, $data)
  {
    $this->db->where('customer_email', $id);
    $this->db->update('customers', $data);
  }

  public function getProvinceData($keyword, $limit)
  {
    if ($keyword != null) {
      $this->db->like('nama', $keyword);
    }

    $this->db->limit($limit);

    $query = $this->db->get('provinsi');
    return $query->result_array();

    /* $query = $this->db->get('provinsi');
    return $query->result_array(); */
  }

  public function getRegencyData($id, $keyword, $limit)
  {
    $this->db->select('*, kabupaten.id_prov AS id_prov_kabupaten, kabupaten.nama AS nama_kabupaten');
    $this->db->from('kabupaten');

    $this->db->where('id_prov', $id);

    if ($keyword != null) {
      $this->db->like('nama', $keyword);
    }

    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();

    /* $this->db->where('id_prov', $id);

    $query = $this->db->get('kabupaten');
    return $query->result_array(); */
  }

  public function getDistrictData($id, $keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('kecamatan');

    $this->db->where('id_kab', $id);

    if ($keyword != null) {
      $this->db->like('nama', $keyword);
    }

    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();

    /* $query = $this->db->get('kecamatan');
    return $query->result_array(); */
  }

  public function getSubDistrictData($id, $keyword, $limit)
  {
    $this->db->select('*');
    $this->db->from('kelurahan');

    $this->db->where('id_kec', $id);

    if ($keyword != null) {
      $this->db->like('nama', $keyword);
    }

    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();

    /* $this->db->where('id_kec', $id);

    $query = $this->db->get('kelurahan');
    return $query->result_array(); */
  }

  public function getCustomerAddress($id)
  {
    return $this->db->get_where('customer_address', ['email' => $id])->row_array();
  }

  public function getFullAdressCustomer($email)
  {
    $this->db->select('*, provinsi.id_prov AS id_provinsi, provinsi.nama AS nama_provinsi, kabupaten.id_kab AS id_kabupaten, kabupaten.nama AS nama_kabupaten, kecamatan.id_kec AS id_kecamatan, kecamatan.nama AS nama_kecamatan, kelurahan.id_kel AS id_kelurahan, kelurahan.nama AS nama_kelurahan');

    $this->db->from('customer_address');
    $this->db->join('provinsi', 'provinsi.id_prov = customer_address.provinsi_id', 'left');
    $this->db->join('kabupaten', 'kabupaten.id_kab = customer_address.kabupaten_id', 'left');
    $this->db->join('kecamatan', 'kecamatan.id_kec = customer_address.kecamatan_id', 'left');
    $this->db->join('kelurahan', 'kelurahan.id_kel = customer_address.kelurahan_id', 'left');

    $this->db->where('customer_address.email', $email);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function updateAddress($id, $data)
  {
    $this->db->where('email', $id);
    $this->db->update('customer_address', $data);

    return $this->db->affected_rows();
  }

  // COMMENTS 
  public function getCountRowsComment($id)
  {
    $this->db->where('product_id', $id);
    $query = $this->db->get('customer_comments');

    // return $query->count_all_results();
    return $query->num_rows();
  }

  public function getCountPageComment($id)
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('customer_comments');
    $this->db->where('product_id', $id);

    $query = $this->db->get();
    $result = $query->result_array();

    return $result[0]['allcount'];
  }

  public function getAllComment($rowno, $rowperpage, $id)
  {
    $this->db->select('*, customer_comments.id AS id_comment, customers.id_customer AS id_customer'); //*

    $this->db->from('customer_comments');
    $this->db->join('customers', 'customers.customer_email = customer_comments.email');

    $this->db->order_by('comment_date', 'desc');
    $this->db->where('product_id', $id);

    $this->db->limit($rowperpage, $rowno);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAllCommentImage()
  {
    $query = $this->db->get('customer_comment_details');
    return $query->result_array();
  }

  public function getAllCommentByProduct($id)
  {
    $this->db->select('*'); //*
    $this->db->from('customer_comments');
    $this->db->where('product_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAverageCommentByProduct($id)
  {
    /* $this->db->select('AVG(customer_comments.rating) AS rating_comment, customer_comments.id AS id_comment, products.id AS id_product'); //*

    $this->db->from('customer_comments');
    // $this->db->join('customers', 'customers.customer_email = customer_comments.email');
    $this->db->join('products', 'products.id = customer_comments.product_id'); */

    $this->db->select('AVG(rating) AS rating_comment');
    $this->db->where('product_id', $id);

    $query = $this->db->get('customer_comments');
    // return $query->result_array();
    return $query->row();
  }

  public function insertComment($data)
  {
    $this->db->insert('customer_comments', $data);

    // return $this->db->insert_id();
  }

  public function insertCommentImage($data)
  {
    $this->db->insert('customer_comment_details', $data);
  }

  public function deleteCommentReview($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('customer_comments');

    return $this->db->affected_rows();
  }

  public function deleteCommentReviewDetail($id)
  {
    $sql = "DELETE customer_comments,customer_comment_details 
        FROM customer_comments,customer_comment_details 
        WHERE customer_comment_details.comment_id=customer_comments.id
        AND customer_comments.id= ?";

    $this->db->query($sql, array($id));
    return $this->db->affected_rows();
  }
}

/* End of file CustomerProfile_m.php */
