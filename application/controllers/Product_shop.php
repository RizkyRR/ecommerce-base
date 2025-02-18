<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_shop extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template']);

    $this->load->library(['upload']);
  }

  /* PAGINATION CODEIGNITER WITH JAVASCRIPT */
  // https://makitweb.com/how-to-create-ajax-pagination-in-codeigniter/ //*
  // https://stackoverflow.com/questions/6402714/codeigniter-jquery-ajax-pagination
  // https://stackoverflow.com/questions/45561152/how-to-implement-ajax-pagination-in-codeigniter
  // https://www.webslesson.info/2017/03/ajax-jquery-pagination-in-codeigniter-using-bootstrap.html
  // https://pagination.js.org/

  public function index()
  {
    $info['title'] = "Shop Product Page";

    // SEARCHING
    if ($this->input->post('search')) {
      $info['keyword'] = $this->input->post('search');
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }

    // SORTING
    if ($this->input->post('input_sort')) {
      $info['sort'] = $this->input->post('input_sort');
      $info['sort_type'] = $this->input->post('type_sort');

      $this->session->set_userdata(['sort' => $info['sort'], 'type_sort' => $info['sort_type']]);
    } else {
      $info['sort'] = 'created_at';
      $info['sort_type'] = 'DESC';
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->like('products.id', $info['keyword']);
    $this->db->or_like('category_name', $info['keyword']);
    $this->db->or_like('product_name', $info['keyword']);

    $this->db->order_by($info['sort'], $info['sort_type']);

    // PAGINATION
    $config['base_url']     = base_url() . 'product-section/index';
    $config['total_rows']   = $this->product_m->getCountPageProductShop();
    $config['per_page']     = 12;
    $config['num_links']    = 5;

    $config['use_page_numbers'] = TRUE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    // STYLING
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '<i class="fa fa-caret-right"></i>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '<i class="fa fa-caret-left"></i>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    // GENERATE PAGE
    $this->pagination->initialize($config);

    $info['start'] = $this->uri->segment(3);

    // THIS ONE MAKES YOUR DATA NOT MULTIPLE IN NEXT PAGE NOT LIKE 1[1,2,3,4] 2[3,4,5,6] BUT 1[1,2,3,4] 2[5,6,7,8]
    if ($info['start'] != 0) {
      $info['start'] = ($info['start'] - 1) * $config['per_page'];
    }

    $info['total_rows'] = $config['total_rows'];
    $info['products'] = $this->product_m->getAllProductShop($config['per_page'], $info['start'], $info['keyword'], $info['sort'], $info['sort_type']);

    $email = $this->session->userdata('customer_email');
    $info['wishlist'] = $this->product_m->getWishlistSet($email, $id = null);
    $info['carts'] = $this->product_m->getShoppingCartDetail($email);

    $info['pagination'] = $this->pagination->create_links();

    renderFrontTemplate('front-container/product-shop-area-section', $info);
  }

  public function getAllProductCategory($category)
  {
    $info['title'] = "Shop Product Page";
    $category = urldecode($category);

    // SORTING
    if ($this->input->post('input_sort')) {
      $info['sort'] = $this->input->post('input_sort');
      $this->session->set_userdata('sort', $info['sort']);
    } else {
      $info['sort'] = 'created_at';
    }

    // PAGINATION
    $config['base_url']     = base_url() . 'product-section-category/' . $category;
    $config['total_rows']   = $this->product_m->getCountPageProductCategoryShop($category);
    $config['per_page']     = 12;
    $config['num_links']    = 5;

    $config['use_page_numbers'] = TRUE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    // STYLING
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '<i class="fa fa-caret-right"></i>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '<i class="fa fa-caret-left"></i>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    // GENERATE PAGE
    $this->pagination->initialize($config);

    $info['start'] = $this->uri->segment(3);

    // THIS ONE MAKES YOUR DATA NOT MULTIPLE IN NEXT PAGE NOT LIKE 1[1,2,3,4] 2[3,4,5,6] BUT 1[1,2,3,4] 2[5,6,7,8]
    if ($info['start'] != 0) {
      $info['start'] = ($info['start'] - 1) * $config['per_page'];
    }

    $info['total_rows'] = $config['total_rows'];
    $info['products'] = $this->product_m->getAllProductCategoryShop($config['per_page'], $info['start'], $category, $info['sort']);

    $email = $this->session->userdata('customer_email');
    $info['wishlist'] = $this->product_m->getWishlistSet($email, $id = null);
    $info['carts'] = $this->product_m->getShoppingCartDetail($email);

    $info['pagination'] = $this->pagination->create_links();

    renderFrontTemplate('front-container/product-shop-area-section', $info);
  }

  // ALL DETAIL PRODUCTS
  public function detailPageProduct($slug)
  {
    $info['title'] = 'detail product shop';

    // get session
    $email = $this->session->userdata('customer_email');

    // filter slug to id product 
    $getProductId = $this->product_m->getSlugToProductID($slug);

    if ($getProductId != null) {
      $getProductId = $getProductId['id'];

      // COUNT ROWS COMMENT and COMMENTS
      $info['get_count'] = $this->customerProfile_m->getCountRowsComment($getProductId);

      $getCommentRating = $this->customerProfile_m->getAverageCommentByProduct($getProductId);

      /* $getSumRating = 0;
      
      foreach ($getCommentRating as $val) {
        $getSumRating = $val['rating_comment'];
        // $getSumRating += $val['rating'];
      } */

      $getSumRatingx = $getCommentRating->rating_comment;

      $count = 0;
      // $countRating = round($getSumRatingx / 5, 0, PHP_ROUND_HALF_UP);
      // $countRating = 30 / 5;
      $rating = '';

      /* for ($i = 0; $i < 5; $i++) {
        if ($getSumRatingx > $count) {
          $rating .= '<i class="fa fa-star"></i>';
        } else {
          $rating .= '<i class="fa fa-star-o"></i>';
        }
        $count++;
      } */

      for ($x = 1; $x <= round($getSumRatingx, 0, PHP_ROUND_HALF_DOWN); $x++) {
        $rating .= '<i class="fa fa-star"></i>';
      }
      if (strpos(round($getSumRatingx, 0, PHP_ROUND_HALF_DOWN), '.')) {
        $rating .= '<i class="fa fa-star-half-o"></i>';
        $x++;
      }
      while ($x <= 5) {
        $rating .= '<i class="fa fa-star-o"></i>';
        $x++;
      }

      $info['avg_rating'] = number_format($getSumRatingx, 1);
      $info['rating_comment'] = $rating;

      $info['detail'] = $this->product_m->getDetailProductShop($getProductId);
      $info['images'] = $this->product_m->getImageProductShop($getProductId);

      $info['wishlist'] = $this->product_m->getWishlistSet($email, $getProductId);

      $getDetail = $this->product_m->getProductById($getProductId);
      $getCategory = $getDetail['id_category'];

      $info['relatedWishlist'] = $this->product_m->getWishlistSet($email, $getProductId);
      $info['relatedProducts'] = $this->product_m->getRelatedProduct($getCategory);

      renderFrontTemplate('front-container/product-shop-detail-section', $info);
    } else {
      redirect('error_404', 'refresh');
    }
  }

  public function getLoadAllComment($rowno = 0)
  {
    $product_id = $this->input->post('product_id');

    // ROW PER PAGE 
    $rowperpage = 5;

    // ROW POSITION
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // COUNT ROWS COMMENT 
    $getRow = $this->customerProfile_m->getCountRowsComment($product_id);

    if ($getRow > 0) {
      $countRow = '(' . $getRow . ')';
    } else {
      $countRow = '(0)';
    }

    // COUNT ALL RECORD 
    $countRecord = $this->customerProfile_m->getCountPageComment($product_id);

    // GET RECORD COMMENT
    $comments_record = $this->customerProfile_m->getAllComment($rowno, $rowperpage, $product_id);

    // GET RECORD COMMENT IMAGE
    $image_record = $this->customerProfile_m->getAllCommentImage();

    // PAGINATION
    $config['base_url']     = base_url() . 'get-load-comment';
    $config['total_rows']   = $countRecord;
    $config['per_page']     = $rowperpage;
    $config['num_links']    = 5;

    $config['use_page_numbers'] = TRUE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    // STYLING
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-end">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '<i class="fa fa-caret-right"></i>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '<i class="fa fa-caret-left"></i>';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    // GENERATE PAGE
    $this->pagination->initialize($config);

    // Initialize $data Array
    $data['pagination'] = $this->pagination->create_links();

    // $data['result'] = $comments_record;
    $html = '';

    // https://makitweb.com/how-to-create-ajax-pagination-in-codeigniter/#:~:text=Create%20a%20new%20user_view.,postsList'%3E%20.

    if ($getRow != null) {
      foreach ($comments_record as $val) {
        // https://www.google.com/search?q=wishlist+with+ajax+in+codeigniter&oq=wishlist+with+ajax+in+codeigniter&aqs=chrome..69i57j33.9830j0j7&sourceid=chrome&ie=UTF-8

        $rating = '';
        /* $count = 0;

        for ($i = 0; $i < 5; $i++) {
          if ($val['rating'] > $count) {
            $rating .= '<i class="fa fa-star"></i>';
          } else {
            $rating .= '<i class="fa fa-star-o"></i>';
          }
          $count++;
        } */

        for ($x = 1; $x <= round($val['rating'], 0, PHP_ROUND_HALF_DOWN); $x++) {
          $rating .= '<i class="fa fa-star"></i>';
        }
        if (strpos(round($val['rating'], 0, PHP_ROUND_HALF_DOWN), '.')) {
          $rating .= '<i class="fa fa-star-half-o"></i>';
          $x++;
        }
        while ($x <= 5) {
          $rating .= '<i class="fa fa-star-o"></i>';
          $x++;
        }

        $image = '';

        if ($image_record != null) {
          foreach ($image_record as $record) {
            if ($record['comment_id'] == $val['id_comment']) {
              $image .= '<img style="margin-right: 4px; margin-top: 3px; width: 223px; height: 264px;" data-action="zoom" src="' . base_url() . 'image/comment_review/' . $record['image'] . '" alt="" />';
            } else {
              $image .= '';
            }
          }
        } else {
          $image .= '';
        }

        $id = htmlspecialchars(json_encode($val['id_comment']));

        if ($this->session->userdata('customer_email') == $val['email']) {
          $button = '<a href="javascript:void(0)" class="btn btn-danger btn-xs" id="btnDeleteComment" onclick="delete_comment(' . $id . ')" title="delete comment"><i class="fa fa-trash"></i></a>';
        } else {
          $button = '';
        }

        // check review reply 
        $dataReviewReply = $this->customerProfile_m->getDataReviewReplyByID($val['id_comment']);

        if ($dataReviewReply != null) {
          $dataReviewReplyImage = $this->customerProfile_m->getDataReviewReplyImageByID($dataReviewReply['id_comment_reply']);

          $image_reply = '';

          if ($dataReviewReplyImage != null) {
            foreach ($dataReviewReplyImage as $valImage) {
              $image_reply .= '<img style="margin-right: 4px; margin-top: 3px; width: 223px; height: 264px;" data-action="zoom" src="' . base_url() . 'image/comment_review/' . $valImage['image'] . '" alt="" />';
            }
          } else {
            $image_reply .= '';
          }

          $getReviewReply = '<div class="mb-3"></div>
          <div class="avatar-text" style="margin-top: 3px;">
          <h5>Admin <span>' . date('d M Y H:i:s', strtotime($dataReviewReply['reply_date'])) . '</span></h5>
          <div class="at-reply">' . $dataReviewReply['message_reply'] . '</div>' .

            $image_reply .

            '</div>';
        } else {
          $getReviewReply = '';
        }

        $html .= '<div class="co-item">
        <div class="avatar-pic">
          <img src="' . base_url() . 'image/customer_profile/' . $val['customer_image'] . '" alt="">
        </div>

        <div class="row">
          <div class="col-lg-10">
            <div class="avatar-text">
              <div class="at-rating">
              ' . $rating . '
              </div>
              <h5>' . $val['customer_name'] . ' <span>' . date('d M Y H:i:s', strtotime($val['comment_date'])) . '</span></h5>
              <div class="at-reply">' . $val['message'] . '</div>
              ' . $image . '

              <!-- START COMMENT REVIEW -->
              ' . $getReviewReply . '
              <!-- END COMMENT REVIEW -->
            </div>
          </div>

          <div class="col-lg-2">' . $button . '</div>
        </div>
      </div>';
      }
    } else {
      $html .= '<span>Sorry, no review/s yet!</span>';
    }

    $data['html'] = $html;
    $data['row'] = $rowno;
    $data['count_row_comment'] = $countRow;

    echo json_encode($data);
  }

  public function checkCustomerComment()
  {
    $email = $this->session->userdata('customer_email');
    $product_id = $this->input->post('product_id');

    $response = array();

    $dataComment = $this->db->get_where('customer_comments', array('email' => $email, 'product_id' => $product_id));
    $result = $dataComment->result();

    if ($email) {
      // $response['status'] = true;
      if ($result == null) {
        $response['status'] = true;
      } else {
        $response['status'] = false;
      }
    } else {
      $response['status'] = false;
    }

    echo json_encode($response);
  }

  public function createCommentCode()
  {
    $id = "CMNT" . "-";
    $generate = date("m") . date('y') . '-' . $id . date('His');

    // return $generate;
    echo json_encode($generate);
  }

  public function insertResizeImages()
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
        'comment_id' => $comment,
        'image' => $gambar,
        'info' => $fileinfo,
        'token' => $token
      ];
      $this->customerProfile_m->insertCommentImage($data);
    } else {
      return false;
    }
  }

  public function removeImage()
  {
    //Ambil token foto
    $token = $this->input->post('token');

    $foto = $this->db->get_where('customer_comment_details', array('token' => $token));


    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/comment_review/' . $nama_foto)) {
        @unlink($file);
      }
      $this->db->delete('customer_comment_details', array('token' => $token));
    }

    echo "{}";
  }

  public function insertCommentReview()
  {
    $response = array();

    $email = $this->session->userdata('customer_email');

    $data = [
      'id' => $this->input->post('comment_id'),
      'product_id' => $this->input->post('product_id'),
      'email' => $email,
      'rating' => $this->input->post('rate'),
      'message' => $this->input->post('message'),
      'comment_date' => date('Y-m-d H:i:s')
    ];

    $this->customerProfile_m->insertComment($data);
    $response['status'] = true;

    /* $insert = $this->customerProfile_m->insertComment($data);

    if ($insert > 0) {
      $response['status'] = true;
    } else {
      $response['status'] = false;
    } */

    echo json_encode($response);
  }

  public function deleteCommentReview($id)
  {
    // $id = $this->input->post('id');

    $response = array();

    $getDataReviewReply = $this->review_m->getReviewReplyDataByID($id);

    // comment review details
    $dataImagesReview = $this->db->get_where('customer_comment_details', array('comment_id' => $id));
    $imageReviewResult = $dataImagesReview->result();

    // comment review reply details
    $dataImagesReviewReply = $this->db->get_where('customer_comment_reply_details', array('comment_reply_id' => $getDataReviewReply['id_comment_reply']));
    $imageReviewReplyResult = $dataImagesReviewReply->result();

    // check apakah ada reply atau belum
    $checkAvailableReply = $this->db->get_where('customer_comment_replies ', ['comment_id' => $id]);

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

        $delete = $this->review_m->deleteDataWithReviewDetailAndReplyDetail($id);
      } else if ($imageReviewResult != null) {
        // comment review details
        foreach ($imageReviewResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteDataWithReviewDetail($id);
      } else if ($imageReviewReplyResult != null) {
        // comment review reply details
        foreach ($imageReviewReplyResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteDataWithReplyDetail($id);
      } else {
        $delete = $this->review_m->deleteDataReview($id);
      }
    } else {
      if ($imageReviewResult != null) {
        foreach ($imageReviewResult as $row) {
          @unlink('./image/comment_review/' . $row->image);
        }

        $delete = $this->review_m->deleteCommentReviewWithDetail($id);
      } else {
        $delete = $this->review_m->deleteCommentReview($id);
      }
    }

    if ($delete > 0) {
      $response['status'] = true;
    } else {
      $response['status'] = false;
    }

    echo json_encode($response);
  }

  public function getAvailableStockProductByID()
  {
    $response = array();
    $product_id = $this->input->post('product_id');

    $dataProducts = $this->product_m->getCheckQtyProductByID($product_id);

    if ($dataProducts != null) {
      $getQty = $dataProducts['qty'];

      $response['status'] = true;
      $response['qty'] = $getQty;
    } else {
      $response['status'] = false;
      $response['qty'] = 0;
    }

    echo json_encode($response);
  }

  public function getCheckQtyProductByID()
  {
    $response = array();
    $product_id = $this->input->post('product_id');
    $qty = $this->input->post('qty');

    $dataProducts = $this->product_m->getCheckQtyProductByID($product_id);
    $getQty = $dataProducts['qty'];

    if ($qty <= $getQty) {
      $response['status'] = "true";
    } else {
      $response['status'] = "false";
      $response['message'] = "Sorry, you exceeded the quantity limit for this product!";
    }

    echo json_encode($response);
  }

  public function getRelatedProduct()
  {
    $response = array();

    $product_id = $this->input->post('product_id');
    $getDetail = $this->product_m->getProductById($product_id);

    $getCategory = $getDetail['id_category'];

    $products = $this->product_m->getRelatedProduct($getCategory);

    // GET RECORD WISHLIST 
    $email = $this->session->userdata('customer_email');
    $wishlists = $this->product_m->getWishlistSet($email, $product_id);

    $html = '';
    $wishlist = '';

    if ($products != null) {
      foreach ($products as $val) {
        // wishlist info

        if ($wishlists != null) {
          foreach ($wishlists as $w) {

            if ($w['product_id'] == $val['id_product']) {
              $wishlist .= '<div class="icon">
                <a href="' . base_url() . 'set-wishlist/' . $val['id_product'] . '"><i class="fa fa-heart"></i></a>   
              </div>';
            } else {
              $wishlist .= '<div class="icon">
                <a href="' . base_url() . 'set-wishlist/' . $val['id_product'] . '"><i class="fa fa-heart-o"></i></a>   
              </div>';
            }
          }
        } else {
          $wishlist .= '<div class="icon">
            <a href="' . base_url() . 'set-wishlist/' . $val['id_product'] . '"><i class="fa fa-heart-o"></i></a>   
          </div>';
        }

        // sale status
        if ($val['discount_charge_rate'] != null) {
          $sale = '<div class="sale pp-sale">Sale-' . $val['discount_charge_rate'] . '%</div>';

          $price = 'Rp. ' . number_format($val['price'], 0, ',', '.') . '
          <span>Rp. ' . number_format($val['before_discount'], 0, ',', '.') . '
          </span>';
        } else {
          $sale = '';
          $price = 'Rp.' . number_format($val['price'], 0, ',', '.') . '';
        }

        $html .= '<div class="col-lg-3 col-sm-6">
        <div class="product-item">
          <div class="pi-pic">
            <img src="' . base_url() . 'image/product/' . $val['image'] . '" alt="" />

            ' . $sale . ' 
          
            ' . $wishlist . '

            <ul>
              <!-- <li id="cart-icon" class="w-icon active">
                <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart(\'' . $val['id_product'] . '\')">

                  <i class="fa fa-cart-plus" aria-hidden="true"></i>

                </a>
              </li> -->

              <li class="quick-view"><a href="' . base_url() . 'product-detail/' . $val['slug'] . '">+ See Details</a></li>
            </ul>
          </div>

          <div class="pi-text">
            <div class="catagory-name">' . $val['category_name'] . '</div>

            <a href="' . base_url() . 'product-detail/' . $val['slug'] . '">
              <h5>' . $val['product_name'] . '</h5>
            </a>

            <div class="product-price">
              ' . $price . '
            </div>

          </div>
        </div>
      </div>';
      }
    } else {
      $html .= '';
    }

    $response['html'] = $html;

    echo json_encode($response);
  }

  public function setCartProductDetail()
  {
    $response = array();

    // set id product and variant and price
    $product_id = $this->input->post('product_id');

    // get session
    $email = $this->session->userdata('customer_email');

    // set custom id customer cart 
    $code = "CART" . "-";
    $generate = date("m") . date('y') . '-' . $code  .  date('His');

    // set quantity
    $quantity = $this->input->post('qty');
    // $subAmount = $quantity * $product_price; // set instanly for get price by hidden input field 

    $data = [
      'id' => $generate,
      'customer_email' => $email,
      'product_id' => $product_id,
      'quantity' => $quantity,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // check for product 
    $dataProducts = $this->product_m->getCheckQtyProductByID($product_id);

    // check wishlist set or not
    $checkCart = $this->customerCart_m->checkSetCart($email, $product_id);

    // check session before click button
    if (!$email) {
      $response['status'] = 'auth';
    } else {
      // jika memiliki atau terdaftar dalam product
      $getQty = $dataProducts['qty'];

      if ($quantity <= $getQty) {
        $response['quantity'] = "true";

        if ($checkCart != null) {
          $getQty = $checkCart['quantity'];
          // delete data in wishlist table
          $getQty = $getQty + $quantity;
          // $amountPrice = $getQty * $product_price;

          $dataQty = [
            'quantity' => $getQty
          ];

          $this->customerCart_m->updateCart($email, $product_id, $dataQty);

          $response['status'] = 'update';
        } else {
          // insert data in wishlist table
          $this->customerCart_m->insertCart($data);

          $response['status'] = 'insert';
        }
      } else {
        $response['quantity'] = "false";
        $response['message'] = "Sorry, you exceeded the quantity limit for this product!";
      }
    }

    echo json_encode($response);
  }


  public function setWishlist($id)
  {
    $response = array();

    $email = $this->session->userdata('customer_email');

    $data = [
      'customer_email' => $email,
      'product_id' => $id,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // check session before click button
    if (!$email) {
      $this->session->set_flashdata('error', 'You have to sign in first!');
      redirect('sign-in', 'refresh');
    } else {
      // check wishlist set or not
      $checkWishlist = $this->product_m->checkSetWishlist($email, $id);

      if ($checkWishlist > 0) {
        // delete data in wishlist table
        $delete = $this->product_m->deleteWishlist($email, $id);

        if ($delete > 0) {
          $this->session->set_flashdata('success', 'Successfully removed from your wishlist!');
          redirect($this->agent->referrer(), 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Unsuccessfully removed from your wishlist!');
          redirect($this->agent->referrer(), 'refresh');
        }
      } else {
        // insert data in wishlist table
        $insert = $this->product_m->insertWishlist($data);

        if ($insert > 0) {
          $this->session->set_flashdata('success', 'Product was added to the wishlist!');
          redirect($this->agent->referrer(), 'refresh');
        } else {
          $this->session->set_flashdata('error', 'Wishlist did not add successfully!');
          redirect($this->agent->referrer(), 'refresh');
        }
      }
    }
  }

  public function setShoppingWishlist()
  {
    $response = array();

    // get session
    $email = $this->session->userdata('customer_email');
    $product_id = $this->input->post('product_id');

    $checkWishlist = $this->product_m->checkSetWishlist($email, $product_id);

    $data = [
      'customer_email' => $email,
      'product_id' => $product_id,
      'created_at' => date('Y-m-d H:i:s')
    ];

    if (!$email) {
      $response['status'] = "auth";
    } else {
      if ($checkWishlist > 0) {
        // delete data in wishlist table
        $delete = $this->product_m->deleteWishlist($email, $product_id);

        $response['status'] = "delete";
      } else {
        // insert data in wishlist table
        $insert = $this->product_m->insertWishlist($data);

        $response['status'] = "insert";
      }
    }

    echo json_encode($response);
  }

  // set up a shopping cart instantly
  public function setShoppingCart($id)
  {
    $response = array();

    // get session
    $email = $this->session->userdata('customer_email');

    //get product price 
    $product = $this->product_m->getProductShopByID($id);
    $productPrice = $product['price'];

    // set custom id customer cart 
    $code = "CART" . "-";
    $generate = date("m") . date('y') . '-' . $code  .  date('His');

    // set quantity
    $quantity = $this->input->post('qty');

    $subAmount = $quantity * $productPrice;

    /* if ($quantity == null) {
      $quantity = 1;
    } else {
      $quantity;
    } */

    $data = [
      'id' => $generate,
      'customer_email' => $email,
      'product_id' => $id,
      'quantity' => $quantity,
      'amount_price' => $subAmount,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // check session before click button
    if (!$email) {
      $response['auth_status'] = true;
    } else {
      // check wishlist set or not
      $checkWishlist = $this->customerCart_m->checkSetCart($email, $id);
      $getQty = $checkWishlist['quantity'];

      if ($checkWishlist > 0) {
        // delete data in wishlist table
        $getQty += 1;
        $amountPrice = $getQty * $productPrice;

        $dataQty = [
          'quantity' => $getQty,
          'amount_price' => $amountPrice
        ];

        $update = $this->customerCart_m->updateCart($email, $id, $dataQty);

        $response['update_status'] = true;

        /* if ($delete > 0) {
          $response['delete_status'] = true;
        } else {
          $response['delete_status'] = false;
        } */
      } else {
        // insert data in wishlist table
        $insert = $this->customerCart_m->insertCart($data);

        $response['insert_status'] = true;

        /* if ($insert > 0) {
          $response['insert_status'] = true;
          $response['id'] = $insert;
        } else {
          $response['insert_status'] = false;
        } */
      }
    }

    echo json_encode($response);
  }

  public function getShoppingCart()
  {
    // get session
    $email = $this->session->userdata('customer_email');

    $response = array();

    // get count rows 
    $countRows = $this->product_m->countShoppingCartByQty($email);

    foreach ($countRows as $val) {
      $countRows = $val['total_qty'];
    }

    if ($countRows != null) {
      $response['count_rows'] = $countRows;
    } else {
      $response['count_rows'] = 0;
    }

    // get result product cart 
    $html = '';
    $getShoppingCart = $this->product_m->getShoppingCart($email);

    foreach ($getShoppingCart as $val) {
      $id = htmlspecialchars(json_encode($val['id_cart']));

      $html .= '<tr>' .
        '<td class="si-pic"><a href="' . base_url() . 'product-detail/' . $val['slug'] . '"><img style="height: 100px; width: 100px" src="' . base_url() . 'image/product/' . $val['image'] . '"></a></td>' .
        '<td class="si-text">' .
        '<div class="product-selected">' .
        '<p>Rp. ' . number_format($val['price'], 0, ',', '.') . ' x ' . $val['cart_qty'] . '</p>' .
        '<a href="' . base_url() . 'product-detail/' . $val['slug'] . '"><h6>' . $val['product_name'] . '</h6></a>' .
        '</div>' .
        '</td>' .
        '<td class="si-close">' .
        '<a href="javascript:void(0)" id="delete-cart" onclick="deleteShoppingCart(' . $id . ')"><i class="ti-close"></i></a>' .
        '</td>' .
        '</tr>';

      // $productId .= $val['id_product'];
    }

    $response['shopping_cart'] = $html;
    // $response['product_id'] = $productId;

    // get sum of quantity and price
    $sumPrice = $this->product_m->sumShoppingCart($email);

    foreach ($sumPrice as $val) {
      $sumPrice = 'Rp. ' . number_format($val['total_price'], 0, ',', '.') . '';
    }

    $response['price'] = $sumPrice;

    echo json_encode($response);
  }

  public function updateDetailShoppingCart()
  {
    $email = $this->session->userdata('customer_email');
    $product_id = $this->input->post('product_id');
    $qty = $this->input->post('qty');
    $amountPrice = $this->input->post('amount');

    $response = array();

    if ($qty == 0 || $qty == null) {
      $response['status'] = false;

      $data = [
        'quantity' => 1,
        // 'amount_price' => $amountPrice
      ];

      $this->product_m->updateDetailShoppingCart($email, $product_id, $data);
    } else {
      $response['status'] = true;

      $data = [
        'quantity' => $qty,
        // 'amount_price' => $amountPrice
      ];

      $this->product_m->updateDetailShoppingCart($email, $product_id, $data);
    }

    echo json_encode($response);
  }

  public function deleteShoppingCart($cart_id)
  {
    $response = array();

    // get session
    $email = $this->session->userdata('customer_email');

    // check session before click button
    if (!$email) {
      $response['auth_status'] = true;
    } else {
      // insert data in wishlist table
      $delete = $this->customerCart_m->deleteCart($email, $cart_id);

      if ($delete > 0) {
        $response['status'] = true;
      } else {
        $response['status'] = false;
      }
    }

    echo json_encode($response);
  }
}
  
  /* End of file Product_shop.php */
