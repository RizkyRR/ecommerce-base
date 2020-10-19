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

    $data['product'] = $this->product_m->getAllProduct();
    $data['image'] = $this->product_m->getAllProductDetails();

    renderBackTemplate('products/index', $info);

    $this->load->view('modals/modal-detail-product', $data);
    $this->load->view('modals/modal-discount-product');
    /* $this->load->view('modals/modal-add-discount-product');
    $this->load->view('modals/modal-edit-discount-product'); */
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
      $row[] = $item->qty;
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
      
      <a href="#" data-toggle="modal" data-target="#detail-modal' . $item->product_id . '" class="btn btn-info btn-xs" title="detail data"><i class="fa fa-search"></i> Detail</a>
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

  public function getProduct()
  {
    $data = $this->category_m->getAllCategory();
    echo json_encode($data);
  }

  public function getSupplier()
  {
    $data = $this->supplier_m->getSupplier();
    echo json_encode($data);
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

  /* public function create_code()
  {
    $this->db->select('RIGHT(products.id,4) as kode', FALSE);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get('products');      //cek dulu apakah ada sudah ada kode di tabel.    

    if ($query->num_rows() <> 0) {
      //jika kode ternyata sudah ada.      
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      //jika kode belum ada      
      $kode = 1;
    }

    $max_code = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $generate = "PRD" . $max_code;

    // return $generate;
    echo json_encode($generate);
  } */

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

  public function data_image_product()
  {
    $id = $this->input->post('id');
    $data = $this->product_m->getProductImageByID($id);

    if ($data > 0) {
      echo json_encode($data);
    }
  }

  public function insertImages()
  {
    $config['upload_path']   = FCPATH . 'image/product/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['overwrite'] = TRUE;
    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;
    // $config['maintain_ratio'] = TRUE;
    // $config['width']     = 550;
    // $config['height']   = 750;

    $this->upload->initialize($config);

    if ($this->upload->do_upload('image')) {
      $token = $this->input->post('token_foto');
      $nama = $this->upload->data('file_name');
      $product = $this->input->post('id');

      // $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
      // $width = $fileinfo[0];
      // $height = $fileinfo[1];

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
        $config['quality'] = '80%';
        /* $config['width'] = 1200;
        $config['height'] = 675; */
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
        redirect('addproduct', 'refresh');
      }
    } else {
      $this->session->set_flashdata('error', 'Image cannot be empty !');
      redirect('addproduct', 'refresh');
    }
  }

  public function removeImage()
  {
    //Ambil token foto
    $token = $this->input->post('token');

    $foto = $this->db->get_where('product_details', array('token' => $token));


    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/product/' . $nama_foto)) {
        @unlink($file);
      }
      $this->db->delete('product_details', array('token' => $token));
    }

    echo "{}";
  }

  public function removeUpdateImage()
  {
    $token = $this->input->post('token');
    $data = $this->input->post('dataImage');

    $foto = $this->db->get_where('product_details', array('token' => $token));


    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/product/' . $nama_foto)) {
        unlink($file);
      }
      $this->db->delete('product_details', array('token' => $token));
    }

    echo "{}";
  }

  /* public function add_product()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'name',
        'label' => 'product name',
        'rules' => 'trim|required|min_length[3]'
      ],
      [
        'field' => 'category',
        'label' => 'product category',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'supplier',
        'label' => 'product supplier',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'description',
        'label' => 'product description',
        'rules' => 'trim|required|min_length[15]'
      ],
      [
        'field' => 'price',
        'label' => 'product price',
        'rules' => 'trim|required|numeric'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name'),
        'category' => form_error('category'),
        'supplier' => form_error('supplier'),
        'image' => form_error('image'),
        'description' => form_error('description'),
        'price' => form_error('price')
      ];

      echo json_encode($data);
    } else {
      // $countfiles = count((array) $_FILES['image']['name']);

      // for ($i = 0; $i < $countfiles; $i++) {

      //   if (!empty(@$_FILES['image']['name'][$i])) {

      //     $_FILES['file']['name'] = $_FILES['image']['name'][$i];
      //     $_FILES['file']['type'] = $_FILES['image']['type'][$i];
      //     $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
      //     $_FILES['file']['error'] = $_FILES['image']['error'][$i];
      //     $_FILES['file']['size'] = $_FILES['image']['size'][$i];

      //     $config['upload_path'] = './image/product/';
      //     $config['allowed_types'] = 'jpg|jpeg|png|gif';
      //     $config['max_size'] = '5000'; // max_size in kb
      //     $config['file_name'] = $_FILES['image']['name'][$i];

      //     $this->load->library('upload', $config);

      //     if ($this->upload->do_upload('file')) {

      //       $data = $this->upload->data();
      //       $insert['image'] = $data['file_name'];
      //       $insert['product_id'] =  $this->input->post('id');
      //       $this->db->insert('product_images', $insert);
      //     }
      //   }
      // } 

      $data = [
        'id' => $this->input->post('id'),
        'product_name' => $this->input->post('name', true),
        'category_id' => $this->input->post('category', true),
        'supplier_id' => $this->input->post('supplier', true),
        'description' => $this->input->post('description', true),
        'image' => $this->_uploadSingleImage(),
        'price' => $this->input->post('price', true),
        'qty' => 0,
        'availability' => 0,
        'created_at' => date('Y-m-d H:i:s')
      ];

      $this->product_m->insert($data);

      echo json_encode('success');
    }
  } */

  public function addProduct()
  {
    $info['title'] = "Add New Product";
    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('name', 'product name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('category', 'category', 'trim|required');
    $this->form_validation->set_rules('supplier', 'supplier', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    // $this->form_validation->set_rules('image[]', 'image', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
      renderBackTemplate('products/add-product', $info);
    } else {
      $query = $this->db->get_where('products', ['product_name' => $this->input->post('name')]);

      if ($query->num_rows() > 0) {
        $this->session->set_flashdata('error', 'The product name has been used, try using a different name !');
        redirect('product', 'refresh');
      } else {
        $slug = set_slug($this->input->post('name', true));
        /* $count_slug = $this->product_m->getCheckSlug($slug);

        if ($count_slug > 0) {
          $slug_data = [
            'product_id' => $this->input->post('id'),
            'slug' => $slug . "-" . $count_slug
          ];
        } else {
          $slug_data = [
            'product_id' => $this->input->post('id'),
            'slug' => $slug
          ];
        } */

        $convertCurrency = preg_replace('/\D/', '', $this->input->post('price', true));

        $data = [
          'id' => $this->input->post('id'),
          'product_name' => $this->input->post('name', true),
          'slug' => $slug,
          'category_id' => $this->input->post('category', true),
          'supplier_id' => $this->input->post('supplier', true),
          'description' => $this->input->post('description', true),
          'price' => $convertCurrency,
          'qty' => 0,
          'availability' => 0,
          'created_at' => date('Y-m-d H:i:s')
        ];

        $this->product_m->insert($data);

        $this->session->set_flashdata('success', 'Your product has been added !');
        redirect('product', 'refresh');
      }
    }
  }

  /* public function update_product()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'name',
        'label' => 'product name',
        'rules' => 'trim|required|min_length[3]'
      ],
      [
        'field' => 'category',
        'label' => 'product category',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'supplier',
        'label' => 'product supplier',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'description',
        'label' => 'product description',
        'rules' => 'trim|required|min_length[15]'
      ],
      [
        'field' => 'price',
        'label' => 'product price',
        'rules' => 'trim|required|numeric'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name'),
        'category' => form_error('category'),
        'supplier' => form_error('supplier'),
        'description' => form_error('description'),
        'price' => form_error('price')
      ];

      echo json_encode($data);
    } else {
      if (!empty(@$_FILES["image"]["name"])) {
        $image = $this->_uploadSingleImage();

        $uploadPath = './image/product/' . $this->input->post('old_image');
        @unlink($uploadPath);
      } else {
        $image = $this->input->post('old_image');
      }

      $data = array(
        'product_name' => $this->input->post('name', true),
        'category_id' => $this->input->post('category', true),
        'supplier_id' => $this->input->post('supplier', true),
        'description' => $this->input->post('description', true),
        'image' => $image,
        'price' => $this->input->post('price', true),
        'updated_at' => date('Y-m-d H:i:s')
      );
      $this->product_m->update($this->input->post('id'), $data);
      echo json_encode('success');
    }
  } */

  public function editProduct($id)
  {
    $info['title'] = 'Edit Product';
    $info['category'] = $this->category_m->getCategory();
    $info['supplier'] = $this->supplier_m->getSupplier();

    $info[] = $this->load->view('modals/modal-delete');

    // $info['image'] = $this->product_m->getProductImageByID($id);

    $data_product = $this->product_m->getProductById($id);
    $info['data'] = $data_product;

    date_default_timezone_set('Asia/Jakarta');

    $this->form_validation->set_rules('name', 'product name', 'trim|required|min_length[5]');
    $this->form_validation->set_rules('category', 'category', 'trim|required');
    $this->form_validation->set_rules('supplier', 'supplier', 'trim|required');
    $this->form_validation->set_rules('description', 'description product', 'trim|required|min_length[10]');
    $this->form_validation->set_rules('price', 'product price', 'trim|required');

    if ($this->form_validation->run() == false) {
      renderBackTemplate('products/edit-product', $info);
    } else {
      $slug = set_slug($this->input->post('name', true));

      $convertCurrency = preg_replace('/\D/', '', $this->input->post('price', true));

      $data = [
        'product_name' => $this->input->post('name', true),
        'slug' => $slug,
        'category_id' => $this->input->post('category', true),
        'supplier_id' => $this->input->post('supplier', true),
        'description' => $this->input->post('description', true),
        'price' => $convertCurrency,
        'updated_at' => date('Y-m-d H:i:s')
      ];

      $this->product_m->update($id, $data);

      $this->session->set_flashdata('success', 'Data product has been updated !');
      redirect('product', 'refresh');
    }
  }

  public function delete_image_product()
  {
    $rows = $this->db->get_where('product_details', ['id' => $this->input->post('id')]);
    $result = $rows->result();

    foreach ($result as $row) {
      @unlink('./image/product/' . $row->image);
    }

    $this->product_m->deleteImage($this->input->post('id'));
    $this->session->set_flashdata('success', 'Data product has been deleted !');
  }

  public function delete_product()
  {
    $rows = $this->db->get_where('product_details', array('product_id' => $this->input->post('id')));
    $result = $rows->result();

    foreach ($result as $row) {
      @unlink('./image/product/' . $row->image);
    }

    $this->product_m->delete($this->input->post('id'));
    $this->session->set_flashdata('success', 'Data product has been deleted !');
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
    $data = $this->product_m->getAllSelectProduct();
    echo json_encode($data);
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
