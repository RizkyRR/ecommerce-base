<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Review_m extends CI_Model
{

  var $column_order = array(null, 'product_name', 'customer_name', 'email', 'rating', 'message', 'read_status', 'comment_date'); //set column field database for datatable orderable 
  var $column_search = array('product_name', 'customer_name', 'email', 'rating', 'message', 'read_status', 'comment_date'); //set column field database for datatable searchable
  var $order = array('customer_comments.comment_date' => 'desc');  // default order

  private function _getReviewDatatablesQuery()
  {
    $this->db->select('*, customer_comments.id AS id_comment, products.id AS id_product');

    $this->db->from('customer_comments');
    $this->db->join('customers', 'customers.customer_email = customer_comments.email', 'left');
    $this->db->join('products', 'products.id = customer_comments.product_id', 'left');

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

  function getReviewDatatables()
  {
    $this->_getReviewDatatablesQuery();
    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_getReviewDatatablesQuery();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all()
  {
    $this->db->from('customer_comments');

    return $this->db->count_all_results();
  }

  public function getReviewWithProductDataByID($id)
  {
    $this->db->select('*, customer_comments.id AS id_comment, products.id AS id_product');

    $this->db->from('customer_comments');
    $this->db->join('customers', 'customers.customer_email = customer_comments.email', 'left');
    $this->db->join('products', 'products.id = customer_comments.product_id', 'left');

    $this->db->where('customer_comments.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getReviewDataByID($id)
  {
    $this->db->select('*, customer_comments.id AS id_comment');

    $this->db->from('customer_comments');
    $this->db->join('customers', 'customers.customer_email = customer_comments.email', 'left');

    $this->db->where('customer_comments.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getReviewReplyByID($id)
  {
    $this->db->where('comment_id', $id);

    $query = $this->db->get('customer_comment_replies');
    return $query->row_array();
  }

  public function getReviewReplyDataByID($id)
  {
    $this->db->select('*, customer_comments.id AS id_comment, customer_comments.message AS message_review, customer_comment_replies.id AS id_comment_reply, customer_comment_replies.message AS message_reply');

    $this->db->from('customer_comments');
    $this->db->join('customer_comment_replies', 'customer_comment_replies.comment_id = customer_comments.id', 'left');
    $this->db->join('customers', 'customers.customer_email = customer_comments.email', 'left');

    $this->db->where('customer_comments.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getReviewDetailsDataByID($id)
  {
    $this->db->select('*, customer_comments.id AS id_comment, customer_comment_details.id AS id_comment_detail');

    $this->db->from('customer_comment_details');
    $this->db->join('customer_comments', 'customer_comments.id = customer_comment_details.comment_id', 'left');

    $this->db->where('comment_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getReplyReviewDetailsDataByID($id)
  {
    $this->db->where('comment_reply_id', $id);

    $query = $this->db->get('customer_comment_reply_details');
    return $query->result_array();
  }

  public function insertImageReply($data)
  {
    $this->db->insert('customer_comment_reply_details', $data);
    return $this->db->affected_rows();
  }

  public function insertReplyReviewMessage($data)
  {
    $this->db->insert('customer_comment_replies', $data);
    return $this->db->affected_rows();
  }

  public function updateReplyReviewMessage($id, $data)
  {
    $this->db->where('comment_id', $id);
    $this->db->update('customer_comment_replies', $data);

    return $this->db->affected_rows();
  }

  public function updateStatusReadReview($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('customer_comments', $data);

    return $this->db->affected_rows();
  }

  // YANG PUNYA REVIEW IMAGE DAN REPLY IMAGE 
  public function deleteDataWithReviewDetailAndReplyDetail($comment_id)
  {
    $sql = "DELETE customer_comments, customer_comment_details, customer_comment_replies, customer_comment_reply_details
    FROM customer_comments, customer_comment_details, customer_comment_replies, customer_comment_reply_details
    WHERE customer_comment_details.comment_id = customer_comments.id 
    AND customer_comments.id = customer_comment_replies.comment_id 
    AND customer_comment_replies.id = customer_comment_reply_details.comment_reply_id
    AND customer_comments.id = ?";

    $this->db->query($sql, array($comment_id));

    return $this->db->affected_rows();
  }

  // YANG PUNYA REVIEW IMAGE SAJA 
  public function deleteDataWithReviewDetail($comment_id)
  {
    $sql = "DELETE customer_comments, customer_comment_details, customer_comment_replies 
    FROM customer_comments, customer_comment_details, customer_comment_replies 
    WHERE customer_comment_details.comment_id = customer_comments.id 
    AND customer_comments.id = customer_comment_replies.comment_id 
    AND customer_comments.id = ?";

    $this->db->query($sql, array($comment_id));

    return $this->db->affected_rows();
  }

  // YANG PUNYA REPLY IMAGE SAJA 
  public function deleteDataWithReplyDetail($comment_id)
  {
    $sql = "DELETE customer_comments, customer_comment_replies, customer_comment_reply_details 
    FROM customer_comments, customer_comment_replies, customer_comment_reply_details 
    WHERE customer_comment_replies.id = customer_comment_reply_details.comment_reply_id 
    AND customer_comments.id = customer_comment_replies.comment_id 
    AND customer_comments.id = ?";

    $this->db->query($sql, array($comment_id));

    return $this->db->affected_rows();
  }

  // YANG TIDAK MENYANTUMKAN IMAGE SAMA SEKALI
  public function deleteDataReview($comment_id)
  {
    $sql = "DELETE customer_comments, customer_comment_replies
    FROM customer_comments, customer_comment_replies
    WHERE customer_comment_replies.comment_id = customer_comments.id 
    AND customer_comments.id = ?";

    $this->db->query($sql, array($comment_id));

    return $this->db->affected_rows();
  }

  public function deleteCommentReviewWithDetail($comment_id)
  {
    $sql = "DELETE customer_comments, customer_comment_details
    FROM customer_comments, customer_comment_details
    WHERE customer_comment_details.comment_id = customer_comments.id 
    AND customer_comments.id = ?";

    $this->db->query($sql, array($comment_id));

    return $this->db->affected_rows();
  }

  public function deleteCommentReview($comment_id)
  {
    $this->db->where('id', $comment_id);
    $this->db->delete('customer_comments');

    return $this->db->affected_rows();
  }

  public function deleteDataReviewReplyWithDetail($reply_id)
  {
    $sql = "DELETE customer_comment_replies, customer_comment_reply_details
    FROM customer_comment_replies, customer_comment_reply_details
    WHERE customer_comment_reply_details.comment_reply_id = customer_comment_replies.id 
    AND customer_comment_replies.id = ?";

    $this->db->query($sql, array($reply_id));

    return $this->db->affected_rows();
  }

  public function deleteDataReviewReply($reply_id)
  {
    $this->db->where('id', $reply_id);
    $this->db->delete('customer_comment_replies');

    return $this->db->affected_rows();
  }
}
  
  /* End of file Review_m.php */
