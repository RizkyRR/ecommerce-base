<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerReview_m extends CI_Model
{

  // DataTables Model Setup
  var $column_order = array(null, 'product_name', 'rating', 'comment_date'); //set column field database for datatable orderable 
  var $column_search = array('product_id', 'product_name', 'rating'); //set column field database for datatable searchable
  var $order = array('customer_comments.comment_date' => 'desc');  // default order

  private function _getReviewDatatablesQuery($email)
  {
    $this->db->select('*, customer_comments.id AS id_comment, products.id AS id_product');

    $this->db->from('customer_comments');
    $this->db->join('products', 'products.id = customer_comments.product_id', 'left');

    $this->db->where('customer_comments.email', $email);

    $i = 0;
    foreach ($this->column_search as $review) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($review, $_POST['search']['value']);
        } else {
          $this->db->or_like($review, $_POST['search']['value']);
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

  function getReviewDatatables($email)
  {
    $this->_getReviewDatatablesQuery($email);
    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered($email)
  {
    $this->_getReviewDatatablesQuery($email);
    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all($email)
  {
    $this->db->from('customer_comments');
    $this->db->where('customer_comments.email', $email);

    return $this->db->count_all_results();
  }
  // DataTables Model Setup

  public function getCommentReviewByID($comment_id, $email)
  {
    /* $this->db->select('*, customer_comments.id AS id_comment, customer_comment_details.id AS id_detail_comment, products.id AS id_product, product_details.id AS id_detail_product'); */
    $this->db->select('*, customer_comments.id AS id_comment, products.id AS id_product, product_details.id AS id_detail_product');

    $this->db->from('customer_comments');
    $this->db->join('products', 'products.id = customer_comments.product_id', 'left');
    $this->db->join('product_details', 'product_details.product_id = customer_comments.product_id', 'left');

    $this->db->group_by('product_details.product_id');
    $this->db->group_by('customer_comments.email');

    $this->db->where('customer_comments.id', $comment_id);
    $this->db->where_in('customer_comments.email', $email);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCommentDetailReviewByID($comment_id, $email)
  {
    $this->db->select('*, customer_comments.id AS id_comment, customer_comment_details.id AS id_detail_comment');

    $this->db->from('customer_comments');
    $this->db->join('customer_comment_details', 'customer_comment_details.comment_id = customer_comments.id');

    $this->db->where('customer_comments.id', $comment_id);
    $this->db->where('customer_comments.email', $email);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function updateCommentReview($id, $email, $data)
  {
    $this->db->where('id', $id);
    $this->db->where('email', $email);
    $this->db->update('customer_comments', $data);

    return $this->db->affected_rows();
  }

  public function deleteCommentDetailReview($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('customer_comment_details');

    return $this->db->affected_rows();
  }
}
  
  /* End of file CustomerReview_m.php */
