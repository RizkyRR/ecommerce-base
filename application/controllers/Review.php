<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Review extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $data['title'] = 'Data Review';
    $data['user'] = $this->auth_m->getUserSession();
    $data['company'] = $this->company_m->getCompanyById(1);
    $data['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->load->view('back-templates/header', $data);
    $this->load->view('back-templates/topbar', $data);
    $this->load->view('back-templates/navbar', $data);
    $this->load->view('reviews/index', $data);
    $this->load->view('reviews/modal-detail-review');
    $this->load->view('back-templates/footer', $data);
  }

  public function showAjaxReview()
  {
    $list = $this->review_m->getReviewDatatables();

    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_comment));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->product_name;
      $row[] = $item->customer_name;
      $row[] = $item->email;

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

      if (strlen($item->message) >= 50) {
        $message = substr($item->message, 0, 50) . '...';
      } else {
        $message = $item->message;
      }

      $row[] = $message;

      if ($item->read_status == "READ") {
        $read_status = '<span class="label label-success">' . $item->read_status . '</span>';
      } else {
        $read_status = '<span class="label label-danger">' . $item->read_status . '</span>';
      }

      $row[] = $read_status;
      $row[] = $item->comment_date;

      // get data reply_id
      $getDataReviewReply = $this->review_m->getReviewReplyDataByID($item->id_comment);
      $id_reply = htmlspecialchars(json_encode($getDataReviewReply['id_comment_reply']));

      $query = $this->db->get_where('customer_comment_replies ', ['comment_id' => $item->id_comment]);

      if ($query->num_rows() > 0) {
        $reply_status = '<a href="' . base_url() . 'review/editReplyReview/' . $item->id_comment . '" class="btn btn-warning btn-xs" title="update review reply"><i class="fa fa-pencil" aria-hidden="true"></i> Update</a> ';

        $delete_reply = '<a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="delete_reply(' . $id_reply . ')" title="delete review reply"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Reply</a> ';
      } else {
        $reply_status = '<a href="' . base_url() . 'review/replyReview/' . $item->id_comment . '" class="btn btn-success btn-xs" title="reply review"><i class="fa fa-reply" aria-hidden="true"></i> Reply</a> ';

        $delete_reply = '';
      }

      // add html for action
      $row[] = '<a href="javascript:void(0)" onclick="detail_review(' . $id . ')" class="btn btn-info btn-xs" title="detail review"><i class="fa fa-search"></i> Detail</a>
      
      <a href="javascript:void(0)" onclick="delete_review(' . $id . ')" class="btn btn-danger btn-xs" title="delete review"><i class="fa fa-trash-o"></i> Delete Review</a>
      ' . $reply_status . $delete_reply;

      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->review_m->count_all(),
      "recordsFiltered" => $this->review_m->count_filtered(),
      "data" => $data,
    );

    // output to json format
    echo json_encode($output);
  }

  public function createCodeCommentReply()
  {
    $id = "RPLY" . "-";
    $generate = date("m") . date('y') . '-' . $id . date('His');

    // return $generate;
    echo json_encode($generate);
  }

  public function insertImageReply()
  {
    $config['upload_path'] = FCPATH . '/image/comment_review/';
    $config['allowed_types'] = 'gif|jpg|png';

    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->upload->initialize($config);

    if ($this->upload->do_upload('image')) {
      $gbr = $this->upload->data();
      //Compress Image
      $config['image_library'] = 'gd2';
      $config['source_image'] = FCPATH . '/image/comment_review/' . $gbr['file_name'];
      $config['create_thumb'] = FALSE;
      $config['maintain_ratio'] = TRUE;
      $config['quality'] = '80%';
      /* $config['width'] = 1200;
        $config['height'] = 675; */
      $config['new_image'] = FCPATH . '/image/comment_review/' . $gbr['file_name'];
      $this->load->library('image_lib', $config);
      $this->image_lib->resize();

      $gambar = $gbr['file_name'];

      $token = $this->input->post('token_foto');
      $nama = $this->upload->data('file_name');
      $comment = $this->input->post('id');

      $fileinfo = $_FILES['image']['size'];

      $data = [
        'comment_reply_id' => $comment,
        'image' => $gambar,
        'info' => $fileinfo,
        'token' => $token
      ];
      $this->review_m->insertImageReply($data);
    } else {
      return false;
    }
  }

  public function removeImageReply()
  {
    //Ambil token foto
    $token = $this->input->post('name');

    $foto = $this->db->get_where('customer_comment_reply_details', array('image' => $token));

    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/comment_review/' . $nama_foto)) {
        @unlink($file);
      }
      $this->db->delete('customer_comment_reply_details', array('image' => $token));
    }

    echo "{}";
  }

  public function getDataImageReply()
  {
    $response = array();
    $file_list = array();

    $target_dir = FCPATH . "image/comment_review/";
    $reply_id = $this->input->post('reply_id');

    $data = $this->review_m->getReplyReviewDetailsDataByID($reply_id);

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

  public function getReviewData()
  {
    $comment_id = $this->input->post('comment_id');

    $getDataReview = $this->review_m->getReviewDataByID($comment_id);

    if ($getDataReview != null) {
      $data = $getDataReview;
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function getReviewImageData()
  {
    $comment_id = $this->input->post('comment_id');

    $getDataReviewImage = $this->review_m->getReviewDetailsDataByID($comment_id);

    $data = '';

    if ($getDataReviewImage != null) {
      foreach ($getDataReviewImage as $val) {
        $data .= '<img class="img-fluid image-review mb-4" data-action="zoom" style="margin-right: 4px; margin-top: 3px; width: 223px; height: 264px;" src="' . base_url() . 'image/comment_review/' . $val['image'] . '" title="Review Image">';
      }
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function replyReview($id)
  {
    $info['title'] = "Reply Customer Review";

    $getDataReview = $this->review_m->getReviewDataByID($id);

    // update read status to read 
    $data = [
      'read_status' => 'READ'
    ];

    $this->review_m->updateStatusReadReview($id, $data);

    if ($getDataReview != null) {
      $info['review_data'] = $getDataReview;

      $this->form_validation->set_rules('reply_message', 'Reply message can not be empty', 'trim|required');

      if ($this->form_validation->run() == FALSE) {
        renderBackTemplate('reviews/reply-review', $info);
      } else {
        $this->setReplyReviewMessage();
      }
    } else {
      redirect('error_404', 'refresh');
    }
  }

  public function setReplyReviewMessage()
  {
    date_default_timezone_set('Asia/Jakarta');

    $comment_id = $this->input->post('comment_id');

    $getDataReview = $this->review_m->getReviewDataByID($comment_id);

    $dataReplyReview = [
      'id' => $this->input->post('reply_id'),
      'comment_id' => $comment_id,
      'message' => $this->input->post('reply_message'),
      'reply_date' => date('Y-m-d H:i:s')
    ];

    $insert = $this->review_m->insertReplyReviewMessage($dataReplyReview);

    if ($insert > 0) {
      $this->session->set_flashdata('success', 'Reply message from ' . $getDataReview['customer_name'] . ' has been successful!');
      redirect('review', 'refresh');
    } else {
      $this->session->set_flashdata('error', 'Failed to reply review, please try again or check your connection!');
      redirect('review', 'refresh');
    }
  }

  public function getReviewReplyData()
  {
    $comment_id = $this->input->post('comment_id');

    $getDataReviewReply = $this->review_m->getReviewReplyDataByID($comment_id);

    if ($getDataReviewReply != null) {
      $data = $getDataReviewReply;
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function editReplyReview($id)
  {
    $info['title'] = "Edit Reply Customer Review";

    $getDataReviewReply = $this->review_m->getReviewReplyDataByID($id);

    if ($getDataReviewReply != null) {
      $info['review_reply_data'] = $getDataReviewReply;

      $this->form_validation->set_rules('reply_message', 'Reply message can not be empty', 'trim|required');

      if ($this->form_validation->run() == FALSE) {
        renderBackTemplate('reviews/edit-reply-review', $info);
      } else {
        $this->updateReplyReviewMessage();
      }
    } else {
      redirect('error_404', 'refresh');
    }
  }

  public function updateReplyReviewMessage()
  {
    date_default_timezone_set('Asia/Jakarta');

    $comment_id = $this->input->post('comment_id');

    $getDataReview = $this->review_m->getReviewDataByID($comment_id);

    $dataReplyReview = [
      'message' => $this->input->post('reply_message'),
    ];

    $this->review_m->updateReplyReviewMessage($comment_id, $dataReplyReview);

    $this->session->set_flashdata('success', 'Reply message from ' . $getDataReview['customer_name'] . ' has been updated!');
    redirect('review', 'refresh');
  }

  public function getDetailCustomerReview()
  {
    $response = array();
    $comment_id = $this->input->post('comment_id');

    $dataReviewCustomer = $this->review_m->getReviewWithProductDataByID($comment_id);
    $dataReviewImageCustomer = $this->review_m->getReviewDetailsDataByID($comment_id);
    $dataReviewReply = $this->review_m->getReviewReplyByID($comment_id);

    // update read status to read 
    $data = [
      'read_status' => 'READ'
    ];

    $this->review_m->updateStatusReadReview($comment_id, $data);

    if ($dataReviewCustomer != null) {
      $dataReviewImage = '';

      if ($dataReviewImageCustomer != null) {
        $dataReviewImage .= '<div class="form-group">' .
          '<label for="image_review">Image review</label>' .
          '<div class="col-sm">';

        foreach ($dataReviewImageCustomer as $val) {
          $dataReviewImage .= '<img class="img-fluid image-review mb-4" data-action="zoom" style="margin-right: 4px; margin-top: 3px; width: 223px; height: 264px;" src="' . base_url() . 'image/comment_review/' . $val['image'] . '" title="Review Image">';
        }

        $dataReviewImage .= '</div>' .
          '</div>';
      } else {
        $dataReviewImage .= '';
      }

      $response['review_image'] = $dataReviewImage;

      $response['customer_name'] = $dataReviewCustomer['customer_name'];
      $response['product_name'] = $dataReviewCustomer['product_name'];

      $response['review_message'] = '<div class="form-group">' .
        '<label for="review_message">Review message</label>' .
        '<textarea class="form-control" name="review_message" id="review_message" rows="10" readonly>' . $dataReviewCustomer['message'] . '</textarea>' .
        '<input type="hidden" class="form-control" name="comment_id" id="comment_id" readonly>' .
        '</div>';

      if ($dataReviewReply != null) {
        $response['reply_message'] = '<div class="form-group">' .
          '<label for="reply_message">Reply message</label>' .
          '<textarea class="form-control" name="reply_message" id="reply_message" rows="10" readonly>' . $dataReviewReply['message'] . '</textarea>' .
          '<input type="hidden" class="form-control" name="reply_id" id="reply_id" readonly>' .
          '</div>';

        $dataReviewReplyImage = $this->review_m->getReplyReviewDetailsDataByID($dataReviewReply['id']);

        $dataReplyImage = '';

        if ($dataReviewReplyImage != null) {
          $dataReplyImage .= '<div class="form-group">' .
            '<label for="image_review_reply">Image review reply</label>' .
            '<div class="col-sm">';

          foreach ($dataReviewReplyImage as $val) {
            $dataReplyImage .= '<img class="img-fluid image-review-reply mb-4" data-action="zoom" style="margin-right: 4px; margin-top: 3px; width: 223px; height: 264px;" src="' . base_url() . 'image/comment_review/' . $val['image'] . '" title="Review Reply Image">';
          }

          $dataReplyImage .= '</div>' .
            '</div>';
        } else {
          $dataReplyImage .= '';
        }

        $response['reply_image'] = $dataReplyImage;
      }
    }

    echo json_encode($response);
  }

  public function deleteReviewData()
  {
    $response = array();
    $comment_id = $this->input->post('comment_id');
    $getDataReviewReply = $this->review_m->getReviewReplyDataByID($comment_id);

    // comment review details
    $dataImagesReview = $this->db->get_where('customer_comment_details', array('comment_id' => $comment_id));
    $imageReviewResult = $dataImagesReview->result();

    // comment review reply details
    $dataImagesReviewReply = $this->db->get_where('customer_comment_reply_details', array('comment_reply_id' => $getDataReviewReply['id_comment_reply']));
    $imageReviewReplyResult = $dataImagesReviewReply->result();

    // check apakah ada reply atau belum
    $checkAvailableReply = $this->db->get_where('customer_comment_replies ', ['comment_id' => $comment_id]);

    if ($checkAvailableReply->num_rows() > 0) {
      if ($imageReviewResult != null && $imageReviewReplyResult != null) {
        // comment review details
        foreach ($imageReviewResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        // comment review reply details
        foreach ($imageReviewReplyResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteDataWithReviewDetailAndReplyDetail($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      } else if ($imageReviewResult != null) {
        // comment review details
        foreach ($imageReviewResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteDataWithReviewDetail($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      } else if ($imageReviewReplyResult != null) {
        // comment review reply details
        foreach ($imageReviewReplyResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteDataWithReplyDetail($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      } else {
        $delete = $this->review_m->deleteDataReview($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      }
    } else {
      if ($imageReviewResult != null) {
        foreach ($imageReviewResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteCommentReviewWithDetail($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      } else {
        $delete = $this->review_m->deleteCommentReview($comment_id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully delete review data!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, data review cannot be deleted, please try again or check your connection!';
        }
      }
    }

    echo json_encode($response);
  }

  public function deleteReviewReplyData()
  {
    $response = array();
    $reply_id = $this->input->post('reply_id');

    $dataImagesReviewReply = $this->db->get_where('customer_comment_reply_details', array('comment_reply_id' => $reply_id));
    $imageReviewReplyResult = $dataImagesReviewReply->result();

    if ($imageReviewReplyResult != null) {
      foreach ($imageReviewReplyResult as $row) {
        @unlink('./image/comment_review/' . $row->image);
      }

      $delete = $this->review_m->deleteDataReviewReplyWithDetail($reply_id);

      if ($delete > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully delete review reply data!';
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, data review reply cannot be deleted, please try again or check your connection!';
      }
    } else {
      $delete = $this->review_m->deleteDataReviewReply($reply_id);

      if ($delete > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully delete review data!';
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, data review reply cannot be deleted, please try again or check your connection!';
      }
    }

    echo json_encode($response);
  }
}
  
  /* End of file Review.php */
