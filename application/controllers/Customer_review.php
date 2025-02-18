<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_review extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);
    $this->load->helper(['template', 'authaccess']);

    if (!$this->session->userdata('customer_email')) {
      redirect('sign-in');
    }
  }

  public function index()
  {
    $info['title'] = "Customer Review Page";

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($this->session->userdata('customer_email'));

    $this->load->view('front-templates/header', $info);
    $this->load->view('front-container/side-menu-customer-section', $info);
    $this->load->view('front-container/customer-review-page-section', $info);
    $this->load->view('front-templates/footer', $info);
  }

  public function showDataReview()
  {
    $email = $this->session->userdata('customer_email');

    $list = $this->customerReview_m->getReviewDatatables($email);
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_comment));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->product_name;

      $rating = '';

      for ($x = 1; $x <= round($item->rating, 0, PHP_ROUND_HALF_DOWN); $x++) {
        $rating .= '<i class="fa fa-star" style="color: rgb(254, 191, 53);"></i>';
      }
      if (strpos(round($item->rating, 0, PHP_ROUND_HALF_DOWN), '.')) {
        $rating .= '<i class="fa fa-star-half-o" style="color: rgb(254, 191, 53);"></i>';
        $x++;
      }
      while ($x <= 5) {
        $rating .= '<i class="fa fa-star-o" style="color: rgb(254, 191, 53);"></i>';
        $x++;
      }

      $row[] = $rating;
      $row[] = $item->comment_date;

      /* $query = $this->db->get_where('product_discounts', ['product_id' => $item->product_id]);

      if ($query->num_rows() > 0) {
        $discount_status = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="edit_discount(' . $id . ')" title="discount product"><i class="fa fa-percent"></i> Discount</a>';
      } else {
        $discount_status = '';
      } */

      // add html for action
      $row[] = '<a href="' . base_url('edit-comment-review/' . $item->id_comment) . '" class="btn btn-warning btn-sm" title="edit review"><i class="fa fa-pencil"></i> Update</a>

      <a href="javascript:void(0)" onclick="deleteReview(' . $id . ')" class="btn btn-danger btn-sm" title="delete review"><i class="fa fa-trash-o"></i> Delete</a>';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->customerReview_m->count_all($email),
      "recordsFiltered" => $this->customerReview_m->count_filtered($email),
      "data" => $data,
    );

    // output to json format
    echo json_encode($output);
  }

  public function editCommentReview($id)
  {
    $info['title'] = "Customer Review Edit Page";

    $email = $this->session->userdata('customer_email');

    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);
    $info['detail_company'] = $this->company_m->getLinkCompany();
    $info['count_wishlist'] = $this->product_m->getCountWishlist($email);
    $detailComment = $this->customerReview_m->getCommentReviewByID($id, $email);
    $info['data'] = $detailComment;

    if ($detailComment != null) {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/customer-review-edit-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    } else {
      $this->load->view('front-templates/header', $info);
      $this->load->view('front-container/side-menu-customer-section', $info);
      $this->load->view('front-container/error-page-section', $info);
      $this->load->view('front-templates/footer', $info);
    }
  }

  public function getCommentReviewByID()
  {
    $email = $this->session->userdata('customer_email');
    $comment_id = $this->input->post('comment_id');
    $detailComment = $this->customerReview_m->getCommentReviewByID($comment_id, $email);

    $response = array();

    if ($detailComment != null) {
      $response['status'] = true;

      // rating
      $rating = '';

      for ($x = 1; $x <= round($detailComment['rating'], 0, PHP_ROUND_HALF_DOWN); $x++) {
        $rating .= '<i class="fa fa-star" style="color: rgb(254, 191, 53);"></i>';
      }

      if (strpos(round($detailComment['rating'], 0, PHP_ROUND_HALF_DOWN), '.')) {
        $rating .= '<i class="fa fa-star-half-o" style="color: rgb(254, 191, 53);"></i>';
        $x++;
      }

      while ($x <= 5) {
        $rating .= '<i class="fa fa-star-o" style="color: rgb(254, 191, 53);"></i>';
        $x++;
      }

      // date 
      $review_date = '';

      if ($detailComment['comment_update_date'] == null) {
        $review_date .= 'Reviewed on ' . date('d M Y H:i:s', strtotime($detailComment['comment_date']));
      } else {
        $review_date .=  'Reviewed on ' . date('d M Y H:i:s', strtotime($detailComment['comment_update_date'])) . ' (edited)';
      }

      $response['rating_detail'] = $rating;
      $response['review_date'] = $review_date;
      $response['rating'] = $detailComment['rating'];
      $response['message'] = $detailComment['message'];
    } else {
      $response['status'] = false;
    }

    echo json_encode($response);
  }

  public function getCommentDetailReviewByID()
  {
    $response = array();
    $file_list = array();

    $target_dir = FCPATH . "image/comment_review/";
    $email = $this->session->userdata('customer_email');
    $comment_id = $this->input->post('comment_id');

    $data = $this->customerReview_m->getCommentDetailReviewByID($comment_id, $email);

    if (is_dir($target_dir)) {

      if ($dh = opendir($target_dir)) {

        // Read files
        if ((readdir($dh)) !== false) {

          if ($data != '' && $data != '.' && $data != '..') {

            foreach ($data as $val) {
              // File path
              $file_path = $target_dir . $val['image'];

              // Check its not folder
              if (!is_dir($file_path)) {

                $size = filesize($file_path);

                $file_list[] = array('name' => $val['image'], 'size' => $size, 'path' => $file_path);
              }
            }
          }
        }
        closedir($dh);
      }
    }

    echo json_encode($file_list);
    exit;
  }

  public function updateCommentReview()
  {
    $response = array();
    $comment_id = $this->input->post('comment_id');
    $rating_rate = $this->input->post('rate');
    $message = $this->input->post('message');
    $email = $this->session->userdata('customer_email');

    $data = [
      'rating' => $rating_rate,
      'message' => $message,
      'comment_update_date' => date('Y-m-d H:i:s')
    ];

    $update = $this->customerReview_m->updateCommentReview($comment_id, $email, $data);

    if ($update > 0) {
      $response['status'] = true;
    } else {
      $response['status'] = false;
    }

    echo json_encode($response);
  }

  public function deleteCommentDetailReview()
  {
    //Ambil token foto
    $token = $this->input->post('name');

    $foto = $this->db->get_where('customer_comment_details', array('image' => $token));

    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/comment_review/' . $nama_foto)) {
        @unlink($file);
      }
      $this->db->delete('customer_comment_details', array('image' => $token));
    }

    echo "{}";
  }
}
  
  /* End of file Customer_review.php */
