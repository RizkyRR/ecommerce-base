<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);

    $this->load->helper(['template', 'authaccess', 'sidebar', 'slug']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Product";

    renderBackTemplate('products/index', $info);

    $this->load->view('modals/modal-detail-product');
    $this->load->view('modals/modal-discount-product');
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_product()
  {
    $list = $this->product_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->product_id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->product_name;
      $row[] = $item->category_name;
      $row[] = $item->supplier_name;
      $row[] = $item->weight . ' Gram';
      $row[] = "Rp " . number_format($item->price, 0, ',', '.');

      $query = $this->db->get_where('product_discounts', ['product_id' => $item->product_id]);

      if ($query->num_rows() > 0) {
        $discount_status = '<a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="edit_discount(' . $id . ')" title="discount product"><i class="fa fa-percent"></i> Discount</a>';
      } else {
        $discount_status = '';
      }

      // add html for action
      $row[] =
        '
      <a href="' . base_url('product/editproduct/' . $item->product_id) . '" class="btn btn-warning btn-xs" title="edit data"><i class="fa fa-pencil"></i> Update</a>

      <a href="javascript:void(0)" onclick="delete_product(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
      
      <a href="javascript:void(0)" onclick="detail_product(' . $id . ')" class="btn btn-info btn-xs" title="detail data"><i class="fa fa-search"></i> Detail</a>
      ' . $discount_status . '';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->product_m->count_all(),
      "recordsFiltered" => $this->product_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  public function data_product()
  {
    $data = $this->product_m->getAllProduct();
    echo json_encode($data);
  }

  public function getCategory()
  {
    /* $data = $this->category_m->getAllCategory();
    echo json_encode($data); */

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->category_m->getAllCategory($keyword = null, $limit = 10);
    } else {
      $data = $this->category_m->getAllCategory($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id'],
          'text' => $val['category_name']
        );
      }
    }

    echo json_encode($row);
  }

  public function getSupplier()
  {
    /* $data = $this->supplier_m->getSupplier();
    echo json_encode($data); */

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->supplier_m->getSupplier($keyword = null, $limit = 10);
    } else {
      $data = $this->supplier_m->getSupplier($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id'],
          'text' => $val['supplier_name']
        );
      }
    }

    echo json_encode($row);
  }

  public function getTableImageRow()
  {
    $data = $this->gallery_m->getAllImage();
    echo json_encode($data);
  }

  public function getImageValueById()
  {
    $id = $this->input->post('image_id');
    $data = $this->gallery_m->getImageByID($id);
    echo json_encode($data);
  }

  public function getProductLessStockInfo()
  {
    $data = $this->product_m->getLimitStockInfo();

    echo json_encode($data);
  }

  public function getProductLessStockCount()
  {
    $data = $this->product_m->getLimitStockCount();

    echo json_encode($data);
  }

  public function create_code()
  {
    $id = "PRDCT" . "-";
    $generate = $id  . date("m") . date('y') . '-' . date('His');

    // return $generate;
    echo json_encode($generate);
  }

  public function detail_product($id)
  {
    // $id = $this->input->post('id');
    $data = $this->product_m->getProductById($id);

    echo json_encode($data);
  }

  public function showEditImages($id)
  {
    $data = $this->product_m->getProductImageByID($id);

    echo json_encode($data);
  }

  public function insertImages()
  {
    $config['upload_path']   = FCPATH . 'image/product/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['overwrite'] = TRUE;
    $config['encrypt_name'] = TRUE;

    $this->upload->initialize($config);

    if ($this->upload->do_upload('image')) {
      $token = $this->input->post('token_foto');
      $nama = $this->upload->data('file_name');
      $product = $this->input->post('id');

      $fileinfo = $_FILES['image']['size'];

      $data = [
        'product_id' => $product,
        'image' => $nama,
        'info' => $fileinfo,
        'token' => $token
      ];
      $this->product_m->insert_image($data);
    }
  }

  public function insertResizeImages()
  {
    $config['upload_path'] = FCPATH . '/image/product/';
    $config['allowed_types'] = 'gif|jpg|png';

    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->upload->initialize($config);

    if (!empty($_FILES['image']['name'])) {

      if ($this->upload->do_upload('image')) {
        $gbr = $this->upload->data();
        //Compress Image
        $config['image_library'] = 'gd2';
        $config['source_image'] = FCPATH . '/image/product/' . $gbr['file_name'];
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        // $config['quality'] = '80%'; // by default 90% makin kecil makin jelek

        $config['width'] = 360;
        $config['height'] = 404;

        $config['new_image'] = FCPATH . '/image/product/' . $gbr['file_name'];
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $gambar = $gbr['file_name'];

        $token = $this->input->post('token_foto');
        $nama = $this->upload->data('file_name');
        $product = $this->input->post('id');

        $fileinfo = $_FILES['image']['size'];

        $data = [
          'product_id' => $product,
          'image' => $gambar,
          'info' => $fileinfo,
          'token' => $token
        ];
        $this->product_m->insert_image($data);
      } else {
        $this->session->set_flashdata('error', 'Please upload the image in accordance with the recommendations!');
        redirect('product/addproduct', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'Image cannot be empty!');
      redirect('product/addproduct', 'refresh');
    }
  }

  public function removeImage()
  {
    //Ambil token foto
    $token = $this->input->post('name');

    $foto = $this->db->get_where('product_details', array('image' => $token));

    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/product/' . $nama_foto)) {
        @unlink($file);
      }
      $this->db->delete('product_details', array('image' => $token));
    }

    echo "{}";
  }

  public function addProduct()
  {
    $info['title'] = "Add New Product";
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('name', 'product name', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('category', 'category', 'trim|required');
    $this->form_validation->set_rules('supplier', 'supplier', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[20]');
    $this->form_validation->set_rules('stock', 'product stock', 'trim|required|numeric');
    $this->form_validation->set_rules('weight', 'product weight', 'trim|required|numeric');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('products/add-product', $info);
    } else {
      $this->insertProduct();
    }
  }

  public function insertProduct()
  {
    date_default_timezone_set('Asia/Jakarta');

    $slug = set_slug($this->input->post('name', true));

    $convertCurrency = preg_replace('/\D/', '', $this->input->post('price', true));

    $data = [
      'id' => $this->input->post('id'),
      'product_name' => $this->input->post('name', true),
      'slug' => $slug,
      'category_id' => $this->input->post('category', true),
      'supplier_id' => $this->input->post('supplier', true),
      'description' => $this->input->post('description', true),
      'price' => $convertCurrency,
      'qty' => $this->input->post('stock'),
      'weight' => $this->input->post('weight', true),
      'availability' => 1,
      'created_at' => date('Y-m-d H:i:s')
    ];

    $this->product_m->insert($data);

    $this->session->set_flashdata('success', 'Your product has been added!');
    redirect('product', 'refresh');
  }

  public function getDataProductImage()
  {
    $response = array();
    $file_list = array();

    $target_dir = FCPATH . "image/product/";
    $product_id = $this->input->post('product_id');

    $data = $this->product_m->getAllProductDetailByID($product_id);

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

  public function getSelectedOptionCategory()
  {
    $product_id = $this->input->post('product_id');

    $data = $this->product_m->getProductById($product_id);
    echo json_encode($data);
  }

  public function getSelectedOptionSupplier()
  {
    $product_id = $this->input->post('product_id');

    $data = $this->product_m->getProductById($product_id);
    echo json_encode($data);
  }

  public function editProduct($id)
  {
    $info['title'] = 'Edit Product';

    $data_product = $this->product_m->getProductById($id);
    $info['data'] = $data_product;

    date_default_timezone_set('Asia/Jakarta');

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $this->form_validation->set_rules('name', 'product name', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('category', 'category', 'trim|required');
    $this->form_validation->set_rules('supplier', 'supplier', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[20]');
    $this->form_validation->set_rules('stock', 'product stock', 'trim|required|numeric');
    $this->form_validation->set_rules('weight', 'product weight', 'trim|required|numeric');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    if ($this->form_validation->run() == false) {
      $this->load->view('back-templates/header', $info);
      $this->load->view('back-templates/topbar', $info);
      $this->load->view('back-templates/navbar', $info);
      $this->load->view('products/edit-product', $info);
      $this->load->view('modals/modal-delete');
      $this->load->view('back-templates/footer', $info);
    } else {
      $this->updateProduct();
    }
  }

  public function updateProduct()
  {
    $id = $this->input->post('id');
    $slug = set_slug($this->input->post('name', true));

    date_default_timezone_set('Asia/Jakarta');

    $convertCurrency = preg_replace('/\D/', '', $this->input->post('price', true));

    $data = [
      'product_name' => $this->input->post('name', true),
      'slug' => $slug,
      'category_id' => $this->input->post('category', true),
      'supplier_id' => $this->input->post('supplier', true),
      'description' => $this->input->post('description', true),
      'price' => $convertCurrency,
      'qty' => $this->input->post('stock'),
      'weight' => $this->input->post('weight', true),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    $this->product_m->update($id, $data);

    $this->session->set_flashdata('success', 'Data product has been updated!');
    redirect('product', 'refresh');
  }

  public function getDetailProduct($id)
  {
    $response = array();
    $dataProduct = $this->product_m->getAllProductByID($id);
    $dataImage = $this->product_m->getAllProductDetailByID($id);

    // $html = '';
    $image = '';

    foreach ($dataImage as $val) {
      $image .= '<div class="column-prev-img">
            <img class="img-responsive" style="width:75%" src="' . base_url() . 'image/product/' . $val['image'] . '" alt="Product Image">
          </div>';
    }

    $html = '<div class="row">
      <div class="col-lg-4">
        <div class="form-group">
          <label for="detail_id">Product ID</label>
          <input type="text" class="form-control" name="detail_id" value="' . $dataProduct['id_product'] . '" readonly>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="form-group">
          <label for="detail_name">Product name</label>
          <input type="text" class="form-control" name="detail_name" value="' . $dataProduct['product_name'] . '" readonly>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="detail_category">Product category</label>
          <input type="text" class="form-control" name="detail_category" value="' . $dataProduct['category_name'] . '" readonly>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="detail_supplier">Product supplier</label>
          <input type="text" class="form-control" name="detail_supplier" value="' . $dataProduct['supplier_name'] . '" readonly>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="detail_image">Product image</label>

      <div class="row-prev-img">
        ' . $image . '
      </div>

    </div>

    <div class="form-group">
      <label for="detail_description">Product description</label>
      <textarea class="form-control" name="detail_description" rows="10" cols="10" readonly>' . $dataProduct['description'] . '</textarea>
    </div>

    <div class="form-group">
      <label for="detail_qty">Product quantity</label>
      <input type="text" class="form-control" name="detail_qty" value="' . $dataProduct['qty'] . '" readonly>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="detail_weight">Product weight</label>
          <div class="input-group">
            <input type="text" class="form-control" name="detail_weight" id="detail_weight" value="' . $dataProduct['weight'] . '" readonly>
            <span class="input-group-addon">Gram</span>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="form-group">
          <label for="detail_price">Product price</label>
          <div class="input-group">
            <span class="input-group-addon">Rp</span>
            <input type="text" class="form-control" name="detail_price" id="detail_price" value="' . number_format($dataProduct['price'], 0, ',', '.') . '" readonly>
          </div>
        </div>
      </div>
    </div>';

    $response['detail'] = $html;

    echo json_encode($response);
  }

  public function delete_product()
  {
    $response = array();
    $id = $this->input->post('id');

    // checking for discount
    $dataDiscounts = $this->db->get_where('product_discounts', ['product_id' => $id]);
    $discountRow = $dataDiscounts->num_rows();

    // checking for image/s
    $dataImages = $this->db->get_where('product_details', array('product_id' => $id));
    $imageResult = $dataImages->result();

    // DIFFERENT DELETE BETWEEN PRODUCT WITH HAS VARIANT AND NOT
    if ($imageResult != null && $discountRow > 0) {
      foreach ($imageResult as $row) {
        @unlink('./image/product/' . $row->image);
      }

      $getLatestPrice = $dataDiscounts->row_array();
      $latestPrice = $getLatestPrice['before_discount'];

      $data = [
        'price' => $latestPrice
      ];

      $update = $this->product_m->updatePriceProductDiskon($id, $data);

      if ($update > 0) {
        $delete = $this->product_m->deleteWithImageDiscounts($id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully removed your product!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, your product cannot be deleted!';
        }
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, your product cannot be deleted. And please check your discount!';
      }
    } else if ($imageResult != null) {
      foreach ($imageResult as $row) {
        @unlink('./image/product/' . $row->image);
      }

      $delete = $this->product_m->deleteWithImage($id);

      if ($delete > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully removed your product!';
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, your product cannot be deleted!';
      }
    } else if ($discountRow > 0) {
      $getLatestPrice = $dataDiscounts->row_array();
      $latestPrice = $getLatestPrice['before_discount'];

      $data = [
        'price' => $latestPrice
      ];

      $update = $this->product_m->updatePriceProductDiskon($id, $data);

      if ($update > 0) {
        $delete = $this->product_m->deleteWithDiscount($id);

        if ($delete > 0) {
          $response['status'] = true;
          $response['message'] = 'Successfully removed your product!';
        } else {
          $response['status'] = false;
          $response['message'] = 'Sorry, your product cannot be deleted!';
        }
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, your product cannot be deleted. And please check your discount!';
      }
    } else {
      $delete = $this->product_m->delete($id);

      if ($delete > 0) {
        $response['status'] = true;
        $response['message'] = 'Successfully removed your product!';
      } else {
        $response['status'] = false;
        $response['message'] = 'Sorry, your product cannot be deleted!';
      }
    }

    echo json_encode($response);
  }

  // Set Discount 
  public function getAllProductSetDiscount()
  {
    $getInput = $this->input->post('searchTerm', true);
    // $getDetailSetDiscount = $this->product_m->getDetailSetDiscounts();
    // $getRowProduct = $this->product_m->getRowProducts();

    if (!isset($getInput)) {
      $data = $this->product_m->getAllProductSetDiscount($keyword = null, $limit = 10);
    } else {
      $data = $this->product_m->getAllProductSetDiscount($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_product'],
          'text' => $val['product_name']
        );
      }
    }
    echo json_encode($row);
  }

  public function getAllSelectProduct()
  {
    /* $data = $this->product_m->getAllSelectProduct();
    echo json_encode($data); */

    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->product_m->getAllSelectProduct($keyword = null, $limit = 10);
    } else {
      $data = $this->product_m->getAllSelectProduct($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id_product'],
          'text' => $val['product_name']
        );
      }
    }
    echo json_encode($row);
  }

  public function getLatestProductPrice()
  {
    $data = $this->product_m->getLatestProductPrice($this->input->post('product_id', true));

    if ($data > 0) {
      echo json_encode($data);
    }
  }

  public function add_discount()
  {
    $response = array();

    $this->form_validation->set_rules('product', 'Product can not be empty', 'trim|required');
    $this->form_validation->set_rules('s_discount', 'Dsicount can not be empty', 'trim|required|numeric');

    if ($this->form_validation->run() == true) {
      $data = [
        'product_id' => $this->input->post('product', true),
        'before_discount' => $this->input->post('l_price', true),
        'discount_charge_rate' => $this->input->post('s_discount', true),
        'discount_charge' => $this->input->post('s_discount_value', true),
        'after_discount' => $this->input->post('d_price', true),
        'start_time_discount' => $this->input->post('start_date', true),
        'end_time_discount' => $this->input->post('end_date', true)
      ];

      $getNameProduct = $this->product_m->getDetailNameProductDiscounts($this->input->post('product'));
      $query = $this->db->get_where('product_discounts', ['product_id' => $this->input->post('product')]);

      if ($query->num_rows() > 0) {
        $response['status'] = false;
        $response['notif'] = "Sorry, for the " . $getNameProduct['product_name'] . " (" . $this->input->post('product') . ") is already set in the discount.";
      } else {
        // ADD UPDATE CONDITION IN PRODUCTS TABLE AFTER SET DISCOUNT
        $this->product_m->updatePriceProductDiskon($this->input->post('product', true), ['price' => $this->input->post('d_price', true)]);

        $insert = $this->product_m->addNewDiscount($data);

        if ($insert > 0) {
          $response['status'] = true;
          $response['notif'] = 'Discount has been set!';
          $response['id'] = $insert;
        } else {
          $response['status'] = false;
          $response['notif'] = 'There is something wrong, please save again!';
        }
      }
    } else {
      $response['status'] = false;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function edit_discount($id)
  {
    $data = $this->product_m->getDetailSetDiscount($id);
    echo json_encode($data);
  }

  public function update_discount()
  {
    $response = array();

    $data = [
      'discount_charge_rate' => $this->input->post('s_discount', true),
      'discount_charge' => $this->input->post('s_discount_value', true),
      'after_discount' => $this->input->post('d_price', true),
      'start_time_discount' => $this->input->post('start_date', true),
      'end_time_discount' => $this->input->post('end_date', true)
    ];

    // ADD UPDATE CONDITION IN PRODUCTS TABLE AFTER SET DISCOUNT
    $this->product_m->updatePriceProductDiskon($this->input->post('product_id'), ['price' => $this->input->post('d_price', true)]);

    $update = $this->product_m->updateDiscount($this->input->post('product_id'), $data);

    if ($update > 0) {
      $response['status'] = true;
      $response['notif'] = 'Discount has been updated!';
    } else {
      $response['status'] = false;
      $response['notif'] = 'There is something wrong, please update again!';
    }

    echo json_encode($response);
  }

  public function delete_discount()
  {
    $id = $this->input->post('id');

    $query = $this->db->get_where('product_discounts', ['product_id' => $id]);

    if ($query->num_rows() > 0) {
      $getLatestPrice = $query->row_array();
      $latestPrice = $getLatestPrice['before_discount'];
    } else {
      return false;
    }

    $data = [
      'price' => $latestPrice
    ];

    $update = $this->product_m->updatePriceProductDiskon($id, $data);

    if ($update > 0) {
      $this->product_m->deleteDiscount($id);
    } else {
      return false;
    }

    echo json_encode($data);
  }
}

/* End of file Product.php */
