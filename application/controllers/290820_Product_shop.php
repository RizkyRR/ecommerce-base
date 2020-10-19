<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_shop extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template']);
  }

  /* PAGINATION CODEIGNITER WITH JAVASCRIPT */
  // https://makitweb.com/how-to-create-ajax-pagination-in-codeigniter/ //*
  // https://stackoverflow.com/questions/6402714/codeigniter-jquery-ajax-pagination
  // https://stackoverflow.com/questions/45561152/how-to-implement-ajax-pagination-in-codeigniter
  // https://www.webslesson.info/2017/03/ajax-jquery-pagination-in-codeigniter-using-bootstrap.html
  // https://pagination.js.org/

  /* public function index()
  {
    $info['title'] = 'Shop Product Page';

    renderFrontTemplate('front-container/product-shop-area-section', $info);
  }

  public function getLoadAllRecordProduct($rowno = 0)
  {
    // ROW PER PAGE 
    $rowperpage = 12;

    // ROW POSITION
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // COUNT ALL RECORD 
    $countRecord = $this->product_m->getCountPageProductShop();

    // GET RECORD 
    $users_record = $this->product_m->getAllProductShop($rowno, $rowperpage);

    // GET RECORD WISHLIST 
    $email = $this->session->userdata('customer_email');
    $wishlists = $this->product_m->getWishlistSet($email);

    // PAGINATION
    $config['base_url']     = base_url() . 'product_shop/getLoadAllRecordProduct';
    $config['total_rows']   = $countRecord;
    $config['per_page']     = $rowperpage;
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

    // Initialize $data Array
    $data['pagination'] = $this->pagination->create_links();

    // $data['result'] = $users_record;
    $html = '';
    $wishlist = '';

    // https://makitweb.com/how-to-create-ajax-pagination-in-codeigniter/#:~:text=Create%20a%20new%20user_view.,postsList'%3E%20.

    if ($users_record != null) {
      foreach ($users_record as $val) {
        // wishlist info 
        if ($wishlists != null) {
          foreach ($wishlists as $w) {
            if ($w['product_id'] == $val['id_product']) {
              $wishlist .= '<div class="icon">
              <a href="javascript:void(0)" title="wishlist" id="set-shopping-wishlist" data-data="' . $val['id_product'] . '" onclick="setShoppingWishlist(\'' . $val['id_product'] . '\')">
                <i class="fa fa-heart wishstate"></i>
              </a>   
            </div>';
            } else {
              $wishlist .= '<div class="icon">
              <a href="javascript:void(0)" title="wishlist" id="set-shopping-wishlist" data-data="' . $val['id_product'] . '" onclick="setShoppingWishlist(\'' . $val['id_product'] . '\')">
                <i class="fa fa-heart-o wishstate"></i>
              </a>   
            </div>';
            }
          }
        } else {
          $wishlist .= '<div class="icon">
              <a href="javascript:void(0)" title="wishlist" id="set-shopping-wishlist" data-data="' . $val['id_product'] . '" onclick="setShoppingWishlist(\'' . $val['id_product'] . '\')">
                <i class="fa fa-heart-o wishstate"></i>
              </a>   
            </div>';
        }

        // sale status
        if ($val['discount_charge_rate'] != null) {
          $sale = '<div class="sale pp-sale">Sale -' . $val['discount_charge_rate'] . '%</div>';

          $price = 'Rp. ' . number_format($val['price'], 0, ',', '.') . '
  <span>Rp. ' . number_format($val['before_discount'], 0, ',', '.') . '
  </span>';
        } else {
          $sale = '';
          $price = 'Rp.' . number_format($val['price'], 0, ',', '.') . '';
        }

        // https://www.google.com/search?q=wishlist+with+ajax+in+codeigniter&oq=wishlist+with+ajax+in+codeigniter&aqs=chrome..69i57j33.9830j0j7&sourceid=chrome&ie=UTF-8

        $html .= '<div class="col-lg-4 col-sm-6">
        <div class="product-item">
          <div class="pi-pic">
            <img style="height: 404px; width: 360px;" src="' . base_url() . 'image/product/' . $val['image'] . '" alt="" />

            ' . $sale . ' 
          
            ' . $wishlist . '

            <ul>
              <li id="cart-icon" class="w-icon active">
                <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart(\'' . $val['id_product'] . '\')">

                  <i class="fa fa-cart-plus" aria-hidden="true"></i>

                </a>
              </li>

              <li class="quick-view"><a href="<?php echo base_url(); ?>product-detail/' . $val['id_product'] . '">+ See Details</a></li>
            </ul>
          </div>

          <div class="pi-text">
            <div class="catagory-name">' . $val['category_name'] . '</div>

            <a href="' . base_url() . 'product-detail/' . $val['id_product'] . '">
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
      $html .= '<h3>Sorry, data not found!</h3>';
    }

    $data['html'] = $html;
    $data['row'] = $rowno;

    echo json_encode($data);
  } */

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
      $this->session->set_userdata('sort', $info['sort']);
    } else {
      $info['sort'] = 'created_at';
    }

    // DB PAGINATION FOR SEARCHING
    $this->db->like('products.id', $info['keyword']);
    $this->db->or_like('category_name', $info['keyword']);
    $this->db->or_like('product_name', $info['keyword']);

    $this->db->order_by($info['sort'], 'DESC');

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
    $info['products'] = $this->product_m->getAllProductShop($config['per_page'], $info['start'], $info['keyword'], $info['sort']);

    $email = $this->session->userdata('customer_email');
    $info['wishlist'] = $this->product_m->getWishlistSet($email);
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
    $info['wishlist'] = $this->product_m->getWishlistSet($email);
    $info['carts'] = $this->product_m->getShoppingCartDetail($email);

    $info['pagination'] = $this->pagination->create_links();

    renderFrontTemplate('front-container/product-shop-area-section', $info);
  }

  public function detailModalProduct($id)
  {
    $detail = $this->product_m->getDetailProductShop($id);
    $image = $this->product_m->getImageProductShop($id);

    if (date('m-Y') == date('m-Y', strtotime($detail['created_at'])) && $detail['discount_charge_rate'] > 0) {
      $productLabel = '<div class="product-label">' .
        '<span>New</span>' .
        '<span class="sale">-' . $detail['discount_charge_rate'] . '%</span>' .
        '</div>';
    } else if (date("m-Y") == date('m-Y', strtotime($detail['created_at']))) {
      $productLabel = '<div class="product-label">' .
        '<span>New</span>' .
        '</div>';
    } else if ($detail['discount_charge_rate'] > 0) {
      $productLabel = '<div class="product-label">' .
        '<span class="sale">-' . $detail['discount_charge_rate'] . '%</span>' .
        '</div>';
    } else {
      $productLabel = '<div class="product-label">' .

        '</div>';
    }

    if ($detail['discount_charge_rate'] > 0) {
      $productPrice = '<h3 class="product-price">Rp. ' . number_format($detail['price'], 0, ',', '.') . '.
      <del class="product-old-price">Rp. ' . number_format($detail['before_discount'], 0, ',', '.') .
        '</del>' .
        '</h3>';
    } else {
      $productPrice = '<h3 class="product-price">Rp. ' . number_format($detail['price'], 0, ',', '.') . '</h3>';
    }

    $view = '';
    foreach ($image as $val) {
      $view .= '<div class="product-view">' .
        '<img src="' . base_url() . 'image/product/' . $val['product_image'] . '" alt="">' .
        '</div>';
    }

    $data['product_name'] = $detail['product_name'];
    $data['category'] = $detail['category_name'];
    $data['description'] = $detail['description'];

    $data['data_image'] = $image;
    $data['product_label'] = $productLabel;
    $data['product_price'] = $productPrice;

    echo json_encode($data);
  }

  public function getDetailImage($id)
  {
    $image = $this->product_m->getImageProductShop($id);
    echo json_encode($image);
  }

  public function detailPageProduct($id)
  {
    $info['title'] = 'detail product shop';

    $info['detail'] = $this->product_m->getDetailProductShop($id);
    $info['images'] = $this->product_m->getImageProductShop($id);

    renderFrontTemplate('front-container/product-shop-detail-section', $info);
  }

  public function loadScrollDataProductShop()
  {
    $limit = $_GET['limit']; // $this-input->post('limit');
    $start = $_GET['start']; // $this-input->post('start');

    // GET SEARCH VAL 
    $search = $this->input->post('search', true);

    if ($search) {
      $keyword = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $keyword);
    } else {
      $keyword = $this->session->set_userdata('keyword');
    }

    // GET SORT VAL
    $sort = $this->input->post('sort');

    // GET COUNT RECORDS 
    $countProduct = $this->product_m->getCountRecordProductShop();

    // GET RECORDS 
    $productRecord = $this->product_m->getScrollDataProductShop($limit, $start);

    $html = '';
    $productStatus = '';
    $productPrice = '';
    if ($productRecord > 0) {
      foreach ($productRecord as $val) {
        if ($val['discount_charge_rate'] > 0) {
          $productStatus = '<div class="sale">Sale-' . $val['discount_charge_rate'] . '%</div>';
        } else {
          $productStatus = '';
        }

        if ($val['discount_charge_rate'] > 0) {
          $productPrice = 'Rp. ' . number_format($val['price'], 0, ',', '.') . '
          <span>"Rp. ' . number_format($val['before_discount'], 0, ',', '.') . '
          </span>';
        } else {
          $productPrice = 'Rp. ' . number_format($val['price'], 0, ',', '.');
        }

        $html .= '<div class="col-lg-4 col-sm-6">
        <div class="product-item">
          <div class="pi-pic">
            <img style="height: 404px; width: 360px;"  src="' . base_url() . 'image/product/' . $val['image'] . '" alt="" />
            ' . $productStatus . '
            <div class="icon">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
            </div>
            <ul>
              <li class="w-icon active">
                <a href="#"><i class="icon_bag_alt"></i></a>
              </li>
              <li class="quick-view"><a href="' . base_url() . 'product-detail/' . $val['id_product'] . '">+ See Details</a></li>
            </ul>
          </div>
          <div class="pi-text">
            <div class="catagory-name">' . $val['category_name'] . '</div>
            <a href="' . base_url() . 'product-detail/' . $val['id_product'] . '">
              <h5>' . $val['product_name'] . '</h5>
            </a>
            <div class="product-price">
              ' . $productPrice . '
            </div>
          </div>
        </div>
      </div>';
      }
    }

    // Initialize $data Array
    $data['result'] = $html;

    echo json_encode($data);
  }

  public function loadButtonDataProductShop()
  {
    $page   =  $_GET['page'];

    $offset = 6 * $page;
    $limit  = 6;

    // GET RECORDS 
    $productRecord = $this->product_m->getButtonDataProductShop($offset, $limit);

    $html = '';
    if ($productRecord > 0) {
      foreach ($productRecord as $val) {
        if ($val['discount_charge_rate'] > 0) {
          $productStatus = '<div class="sale">Sale-' . $val['discount_charge_rate'] . '%</div>';
        } else {
          $productStatus = '';
        }

        if ($val['discount_charge_rate'] > 0) {
          $productPrice = 'Rp. ' . number_format($val['price'], 0, ',', '.') . '
          <span>"Rp. ' . number_format($val['before_discount'], 0, ',', '.') . '
          </span>';
        } else {
          $productPrice = 'Rp. ' . number_format($val['price'], 0, ',', '.');
        }

        $html .= '<div class="col-lg-4 col-sm-6">
        <div class="product-item">
          <div class="pi-pic">
            <img style="height: 404px; width: 360px;"  src="' . base_url() . 'image/product/' . $val['image'] . '" alt="" />
            ' . $productStatus . '
            <div class="icon">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
            </div>
            <ul>
              <li class="w-icon active">
                <a href="#"><i class="icon_bag_alt"></i></a>
              </li>
              <li class="quick-view"><a href="' . base_url() . 'product-detail/' . $val['id_product'] . '">+ See Details</a></li>
            </ul>
          </div>
          <div class="pi-text">
            <div class="catagory-name">' . $val['category_name'] . '</div>
            <a href="' . base_url() . 'product-detail/' . $val['id_product'] . '">
              <h5>' . $val['product_name'] . '</h5>
            </a>
            <div class="product-price">
              ' . $productPrice . '
            </div>
          </div>
        </div>
      </div>';
      }
    }

    // Initialize $data Array
    $data['result'] = $html;

    echo json_encode($data);
  }

  public function setWishlistInfo()
  {
    $response = array();

    $email = $this->session->userdata('customer_email');
    $id = $this->input->post('product_id');

    // data store info
    $data = [
      'customer_email' => $email,
      'product_id' => $id,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // check wishlist set or not
    $checkWishlist = $this->product_m->checkSetWishlist($email, $id);

    // check session before click button
    if (!$email) {
      $response['message'] = 'You have to sign in first!';
      $response['status'] = 'auth';
    } else {
      // check wishlist set or not
      $checkWishlist = $this->product_m->checkSetWishlist($email, $id);

      if ($checkWishlist > 0) {
        // delete data in wishlist table
        $this->product_m->deleteWishlist($email, $id);

        $response['message'] = 'Successfully removed from your wishlist!';
        $response['status'] = 'delete';
      } else {
        // insert data in wishlist table
        $this->product_m->insertWishlist($data);

        $response['message'] = 'Product was added to the wishlist!';
        $response['status'] = 'insert';
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
    // $productId = '';
    $getShoppingCart = $this->product_m->getShoppingCart($email);

    foreach ($getShoppingCart as $val) {
      $id = htmlspecialchars(json_encode($val['id_cart']));

      $html .= '<tr>' .
        '<td class="si-pic"><img style="height: 100px; width: 100px" src="' . base_url() . 'image/product/' . $val['image'] . '" title="' . $val['image'] . '"></td>' .
        '<td class="si-text">' .
        '<div class="product-selected">' .
        '<p>Rp. ' . number_format($val['price'], 0, ',', '.') . ' x ' . $val['cart_qty'] . '</p>' .
        '<h6>' . $val['product_name'] . '</h6>' .
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
    } else {
      $response['status'] = true;

      $data = [
        'quantity' => $qty,
        'amount_price' => $amountPrice
      ];

      $this->product_m->updateDetailShoppingCart($email, $product_id, $data);
    }

    echo json_encode($response);
  }

  public function deleteShoppingCart($id)
  {
    $response = array();

    // get session
    $email = $this->session->userdata('customer_email');

    // check session before click button
    if (!$email) {
      $response['auth_status'] = true;
    } else {
      // insert data in wishlist table
      $delete = $this->customerCart_m->deleteCart($email, $id);

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
