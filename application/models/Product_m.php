<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_m extends CI_Model
{
  // DataTables Model Setup

  var $column_order = array(null, 'product_name', 'category_name', 'supplier_name', 'weight', 'qty', 'price'); //set column field database for datatable orderable 

  var $column_search = array('products.id', 'product_name', 'category_name', 'supplier_name', 'weight', 'qty', 'price'); //set column field database for datatable searchable

  var $order = array('products.created_at' => 'desc');  // default order

  private function _get_datatables_query()
  {
    $this->db->select('*, products.id AS product_id');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');

    $i = 0;
    foreach ($this->column_search as $product) { // loop column
      if (@$_POST['search']['value']) { // if datatable send POST for search
        if ($i === 0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($product, $_POST['search']['value']);
        } else {
          $this->db->or_like($product, $_POST['search']['value']);
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

  function get_datatables()
  {
    $this->_get_datatables_query();
    if (@$_POST['length'] != -1)
      $this->db->limit(@$_POST['length'], @$_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function count_all()
  {
    $this->db->from('products');
    return $this->db->count_all_results();
  }

  // DataTables Model End Setup

  public function getProductCountPage()
  {
    $this->db->select('*');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');

    $query = $this->db->get();
    return $query->num_rows();
  }

  public function getAllProduct()
  {
    $this->db->select('*, products.id AS product_id, product_details.image AS product_image');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');
    $this->db->join('product_details', 'product_details.product_id = products.id');

    $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAllProductByID($id)
  {
    $this->db->select('*, products.id AS id_product, product_categories.id AS id_category, suppliers.id AS id_supplier, product_details.id AS id_detail, product_details.image AS product_image');

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');
    $this->db->join('product_details', 'product_details.product_id = products.id', 'left');

    $this->db->where('products.id', $id);
    $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getProduct()
  {
    $this->db->order_by('product_name', 'ASC');
    $query = $this->db->get('products');
    return $query->result_array();
  }

  public function getActiveProduct()
  {
    $this->db->where('qty > 0');
    $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get('products');
    return $query->result_array();
  }

  public function getActiveProductByID($id)
  {
    $this->db->where('id', $id);
    $this->db->where('qty > 0');
    $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get('products');
    return $query->row_array();
  }

  public function getProductSupplier($data)
  {
    $this->db->where('supplier_id', $data);
    $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get('products');
    return $query->result_array();
  }

  public function getCheckSlug($slug)
  {
    $this->db->select('count(*) as slugcount');
    $this->db->from('product_slugs');
    $this->db->where('slug', $slug);
    $query = $this->db->get();
    return $query->row(0)->slugcount;
  }

  public function insertSlug($data)
  {
    $this->db->insert('product_slugs', $data);
  }

  public function updateSlug($id, $data)
  {
    $this->db->where('product_id', $id);
    $this->db->update('slug', $data);
  }

  public function deleteSlug($id)
  {
    $this->db->where('product_id', $id);
    $this->db->delete('product_slugs');
  }

  public function insert($data)
  {
    $this->db->insert('products', $data);
  }

  public function insertProductVariant($data)
  {
    $this->db->insert('product_variants', $data);
  }

  public function updateProductVariant($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('product_variants', $data);
  }

  public function insert_image($data)
  {
    // $this->db->insert('product_images', $data);
    $this->db->insert('product_details', $data);
  }

  public function getProductById($id)
  {
    // $this->db->select('*, products.id AS product_id, gallery.image AS product_image');
    $this->db->select('*, products.id AS id_product, product_categories.id AS id_category, product_details.image AS product_image');

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('suppliers', 'suppliers.id = products.supplier_id');
    $this->db->join('product_details', 'product_details.product_id = products.id', 'left');

    // $this->db->group_by('products.id');

    $this->db->where('products.id', $id);

    // $this->db->order_by('product_name', 'ASC');

    $query = $this->db->get();
    return $query->row_array();
    // return $this->db->get_where('products', ['product_id' => $id])->row_array();
  }

  public function getAllProductDetails()
  {
    $query = $this->db->get('product_details');
    return $query->result_array();
  }

  public function getAllProductDetailByID($id)
  {
    $this->db->where('product_id', $id);

    $query = $this->db->get('product_details');
    return $query->result_array();
  }

  public function getProductImageByID($id)
  {
    /* $this->db->select('*, product_details.image AS product_image, product_details.id AS product_id');
    $this->db->from('products');
    // $this->db->join('product_images', 'product_images.gallery_id = gallery.id');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->order_by('product_details.product_id', 'DESC');


    $this->db->where('product_details.product_id', $id);

    $query = $this->db->get();
    return $query->result_array(); */

    return $this->db->get_where('product_details', ['product_id' => $id])->result_array();
  }

  public function getProductDetailsByID($id)
  {
    return $this->db->get_where('product_details', ['id' => $id])->row_array();
  }

  public function getLimitStockInfo()
  {
    // Untuk ambil info
    $this->db->order_by('qty', 'asc');
    $this->db->limit(5);

    $query = $this->db->get_where('products', 'qty <= 10');
    return $query->result_array();
  }

  public function getLimitStockCount()
  {
    // Untuk ambil jumlah
    $this->db->select('COUNT(*)');
    $this->db->from('products');
    $this->db->where('qty <= 10');
    return $this->db->count_all_results();
  }

  public function load_image($id)
  {
    $this->db->select('product_images.image AS image_product');
    $this->db->from('products');
    $this->db->join('product_images', 'product_images.product_id = products.id');

    $this->db->where('product_images.product_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function variantData($id)
  {
    $this->db->select('*, products.id AS id_product, product_variants.id AS id_variant');

    $this->db->from('product_variants');
    $this->db->join('products', 'products.id = product_variants.product_id', 'left');

    $this->db->where('product_variants.product_id', $id);
    $this->db->order_by('product_variants.variant_name', 'desc');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function variantDataByID($variant_id)
  {
    $this->db->select('*, products.id AS id_product, product_variants.id AS id_variant');

    $this->db->from('product_variants');
    $this->db->join('products', 'products.id = product_variants.product_id', 'left');

    $this->db->where('product_variants.id', $variant_id);
    // $this->db->where('product_variants.product_id', $product_id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('products', $data);
  }

  public function updateImage($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('product_details', $data);
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('products');

    return $this->db->affected_rows();
  }

  public function deleteWithImageDiscounts($id)
  {
    $sql = "DELETE products,product_details,product_discounts 
    FROM products,product_details,product_discounts 
    WHERE product_details.product_id=products.id 
    AND products.id=product_discounts.product_id 
    AND products.id= ?";

    $this->db->query($sql, array($id));

    return $this->db->affected_rows();
  }

  public function deleteWithImage($id)
  {
    $sql = "DELETE products,product_details 
        FROM products,product_details 
        WHERE product_details.product_id=products.id
        AND products.id= ?";

    $this->db->query($sql, array($id));

    return $this->db->affected_rows();

    /* $this->db->where('id', $id);
    $this->db->delete('products'); */
  }

  public function deleteWithDiscount($id)
  {
    $sql = "DELETE products,product_discounts 
        FROM products,product_discounts 
        WHERE product_discounts.product_id=products.id
        AND products.id= ?";

    $this->db->query($sql, array($id));

    return $this->db->affected_rows();

    /* $this->db->where('id', $id);
    $this->db->delete('products'); */
  }

  public function deleteImage($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('product_details');
  }

  // FOR PRODUCT SHOP FRONT END PURPOSE

  public function getAllProductSetDiscount($keyword, $limit)
  {
    $this->db->select('*, products.id AS id_product');
    $this->db->from('products');

    $this->db->where('qty > 0');

    if ($keyword != null) {
      $this->db->like('products.id', $keyword);
      $this->db->or_like('product_name', $keyword);
    }

    $this->db->order_by('category_id', 'ASC');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAllSelectProduct($keyword, $limit)
  {
    /* $this->db->select('*, products.id AS id_product');
    $this->db->from('products');

    $this->db->where('qty > 0');

    $this->db->order_by('category_id', 'ASC');
    $this->db->limit(10);

    $query = $this->db->get();
    return $query->result_array(); */

    $this->db->select('*, products.id AS id_product');
    $this->db->from('products');

    $this->db->where('qty > 0');

    if ($keyword != null) {
      $this->db->like('product_name', $keyword);
      $this->db->or_like('id', $keyword);
    }

    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getDetailSetDiscount($id)
  {
    $this->db->select('*, product_discounts.id AS discount_id');
    $this->db->from('products');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id');

    $this->db->where('product_discounts.product_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getDetailNameProductDiscounts($id)
  {
    $this->db->select('*');
    $this->db->from('products');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id');

    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getLatestProductPrice($id)
  {
    return $this->db->get_where('products', ['id' => $id])->row_array();
  }

  public function getShowDiscountProducts()
  {
    $this->db->select('*, products.id AS id_product, product_categories.id AS id_category, product_details.id AS id_detail, product_discounts.id AS id_discount');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id');

    $this->db->group_by('product_details.product_id');


    // This condition supposed to be new products
    /* $this->db->where('products.created_at', 'MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())'); */

    // Kondisi mirip dengan mncari report

    $this->db->order_by('category_id', 'ASC');
    $this->db->limit(6);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getCheckHotProduct()
  {
    $query = $this->db->get('product_discounts');
    return $query->result_array();
  }

  public function getHotProductPrice($id)
  {
    $this->db->select('*');
    $this->db->from('products');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id');

    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getHotProductSale($id)
  {
    $this->db->select('*, products.id AS id_product, product_discounts.id AS id_discount');
    $this->db->from('products');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id');

    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getCheckQtyProductByID($id)
  {
    $this->db->select('*, products.id AS id_product'); //*

    $this->db->from('products');
    $this->db->where('products.qty > 0');
    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getCheckQtyVariantByID($id, $variant)
  {
    $this->db->select('*, products.id AS id_product, product_variants.id AS id_variant'); //*

    $this->db->from('products');
    $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');

    $this->db->where('products.qty > 0 OR product_variants.variant_qty > 0');
    $this->db->where('products.id', $id);
    $this->db->where('product_variants.id', $variant);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function existsDataVariant($product_id)
  {
    // $this->db->where('id', $variant_id);
    $this->db->where('product_id', $product_id);

    $query = $this->db->get('product_variants');
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getRelatedProduct($category_id)
  {
    $this->db->select('*, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    // $this->db->select('*, products.id AS id_product, product_details.id AS id_detail'); 
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('order_details', 'order_details.product_id = products.id', 'left');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('order_details.product_id');
    $this->db->group_by('product_details.product_id');

    $this->db->where_not_in('product_discounts.product_id, order_details.product_id'); //*
    // $this->db->where('order_details.qty >= 5');
    $this->db->where('products.category_id', $category_id);

    $this->db->limit(4);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function setHotProducts()
  {
    $this->db->select('*, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    // $this->db->select('*, products.id AS id_product, product_details.id AS id_detail'); 
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*
    $this->db->join('order_details', 'order_details.product_id = products.id');

    $this->db->group_by('order_details.product_id');
    $this->db->group_by('product_details.product_id');

    // where in sql item repeat more than 2
    // $this->db->having('COUNT(order_details.product_id) > 1');
    $this->db->where_not_in('product_discounts.product_id, order_details.product_id'); //*
    $this->db->where('order_details.qty >= 5');
    // $this->db->where('products.qty > 0');

    // This condition supposed to be new products
    /* $this->db->where('products.created_at', 'MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())'); */

    $this->db->order_by('category_id', 'ASC');
    $this->db->limit(12);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function addNewDiscount($data)
  {
    $this->db->insert('product_discounts', $data);
    return $this->db->insert_id();
  }

  public function updateDiscount($id, $data)
  {
    $this->db->where('product_id', $id);
    $this->db->update('product_discounts', $data);
    return $this->db->affected_rows();
  }

  public function updatePriceProductDiskon($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('products', $data);

    return $this->db->affected_rows();
  }

  public function deleteDiscount($id)
  {
    $this->db->where('product_id', $id);
    $this->db->delete('product_discounts');

    return $this->db->affected_rows();
  }

  // ONLY SERVER PURPOSES FOR PRODUCT SHOP
  public function getCountPageProductShop()
  {
    $this->db->select('count(*) as allcount');

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');

    $this->db->where('products.qty > 0');

    $query = $this->db->get();
    $result = $query->result_array();

    return $result[0]['allcount'];

    /* $this->db->select('COUNT(*) as total, products.id AS id_product, product_categories.id As id_category'); //*

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');

    $this->db->where('products.qty > 0');

    $query = $this->db->get();
    return $query->num_rows(); */
  }

  public function getCountPageProductCategoryShop($category)
  {
    $this->db->select('count(*) as allcount');

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');

    $this->db->where('product_categories.category_name', $category);
    $this->db->where('products.qty > 0');

    $query = $this->db->get();
    $result = $query->result_array();

    return $result[0]['allcount'];

    /* $this->db->select('COUNT(product_categories.*)');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');

    $this->db->where('product_categories.category_name', $category);
    $this->db->where('products.qty > 0');

    $query = $this->db->get();
    return $query->num_rows(); */
  }

  // FOR PAGINATION WITH AJAX N SUCCESS
  /* public function getAllProductShop($rowno, $rowperpage)
  {
    $this->db->select('*, COUNT(*) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('product_details.product_id');

    $this->db->where('products.qty > 0');

    $this->db->limit($rowperpage, $rowno);

    $query = $this->db->get();
    return $query->result_array();
  } */

  public function getAllProductShop($limit, $offset, $keyword, $sort)
  {
    $this->db->select('*, COUNT(*) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount, product_variants.id AS id_variant'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*
    $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');

    $this->db->group_by('product_details.product_id');

    if ($keyword) {
      $this->db->like('products.id', $keyword);
      $this->db->or_like('category_name', $keyword);
      $this->db->or_like('product_name', $keyword);
    }

    $this->db->order_by('products.' . $sort, 'DESC');

    $this->db->where('products.qty > 0 OR product_variants.variant_qty > 0');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getProductShopByID($id)
  {
    $this->db->select('*, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount, product_variants.id AS id_variant'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*
    $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');

    $this->db->group_by('product_details.product_id');

    $this->db->where('products.qty > 0 OR product_variants.variant_qty > 0');
    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getAllProductCategoryShop($limit, $offset, $category, $sorting)
  {
    $this->db->select('*, COUNT(*) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('product_details.product_id');

    $this->db->where('products.qty > 0');
    $this->db->where('product_categories.category_name', $category);
    $this->db->order_by('products.' . $sorting, 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getDetailProductShop($id)
  {
    $this->db->select('*, products.id AS id_product, product_categories.id As id_category, product_discounts.id AS id_discount, product_details.id AS id_detail'); //*

    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*
    $this->db->join('product_details', 'product_details.product_id = products.id');

    $this->db->group_by('product_details.product_id');
    $this->db->where('products.id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function getImageProductShop($id)
  {
    $this->db->select('product_details.image AS product_image, products.id AS id_product, product_details.id AS id_detail'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');

    // $this->db->group_by('product_details.product_id');
    $this->db->where('product_details.product_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }
  // ONLY SERVER PURPOSES FOR PRODUCT SHOP

  // ONLY AJAX PURPOSES
  public function getScrollDataProductShop($limit, $start)
  {
    $this->db->select('*, COUNT(products.id) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    // $this->db->select('*, products.id AS id_product, product_details.id AS id_detail'); 
    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('product_details.product_id');

    /* if ($search != null) {
      $this->db->like('products.id', $search);
      $this->db->or_like('category_name', $search);
      $this->db->or_like('product_name', $search);
    } */

    $this->db->where('products.qty > 0');

    $this->db->order_by('created_at', 'ASC');

    $this->db->limit($limit, $start);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getButtonDataProductShop($offset, $limit)
  {
    $this->db->select('*, COUNT(products.id) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, product_discounts.id AS id_discount'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('product_details.product_id');
    $this->db->where('products.qty > 0');
    $this->db->order_by('created_at', 'ASC');
    $this->db->limit($offset, $limit);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getCountRecordProductShop()
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('products');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');

    $query = $this->db->get();
    $result = $query->result_array();

    return $result[0]['allcount'];
  }

  public function checkSetWishlist($email, $id)
  {
    return $this->db->get_where('customer_wishlists', ['customer_email' => $email, 'product_id' => $id])->row_array();
  }

  public function insertWishlist($data)
  {
    $this->db->insert('customer_wishlists', $data);
    return $this->db->insert_id();
  }

  public function deleteWishlist($email, $id)
  {
    $this->db->where('product_id', $id);
    $this->db->where('customer_email', $email);
    $this->db->delete('customer_wishlists');

    return $this->db->affected_rows();
  }

  public function getWishlistSet($email, $product_id)
  {
    if ($product_id != null) {
      $this->db->where('customer_email', $email);
      $this->db->where('product_id', $product_id);
    } else {
      $this->db->where('customer_email', $email);
    }

    $query = $this->db->get('customer_wishlists');
    return $query->result_array();
  }

  public function getCountWishlist($email)
  {
    $this->db->where('customer_email', $email);
    $query = $this->db->get('customer_wishlists');
    return $query->num_rows();
  }

  public function getCountPageWishlistProductShop($email)
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('customer_wishlists');
    $this->db->where('customer_wishlists.customer_email', $email);

    $query = $this->db->get();
    $result = $query->result_array();

    return $result[0]['allcount'];
  }

  public function getAllWishlistProductShop($limit, $offset, $email)
  {
    $this->db->select('*, COUNT(*) as total, products.id AS id_product, product_categories.id As id_category, product_details.id AS id_detail, customer_wishlists.id AS id_wishlist, product_discounts.id AS id_discount'); //*

    $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('customer_wishlists', 'customer_wishlists.product_id = products.id');
    $this->db->join('product_categories', 'product_categories.id = products.category_id');
    $this->db->join('product_discounts', 'product_discounts.product_id = products.id', 'left'); //*

    $this->db->group_by('product_details.product_id');

    $this->db->where('customer_wishlists.customer_email', $email);
    $this->db->order_by('customer_wishlists.created_at', 'DESC');

    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result_array();
  }
  // ONLY AJAX PURPOSES

  public function countShoppingCartByEmail($email)
  {
    // $this->db->select('*, SUM(quantity) as total_qty');
    $this->db->where('customer_email', $email);

    $query = $this->db->get('customer_carts');
    return $query->num_rows();
  }

  public function countShoppingCartByQty($email)
  {
    $this->db->select('*, SUM(quantity) as total_qty');
    $this->db->from('customer_carts');
    $this->db->where('customer_email', $email);
    // $this->db->group_by('customer_email');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getShoppingCart($email)
  {
    $this->db->select('*, SUM(quantity) as total_qty, products.id AS id_product, product_details.id AS id_detail, customer_carts.id AS id_cart, products.qty AS product_qty, customer_carts.quantity AS cart_qty, product_variants.id AS id_variant'); //*

    /* $this->db->from('products');
    $this->db->join('product_details', 'product_details.product_id = products.id');
    $this->db->join('customer_carts', 'customer_carts.product_id = products.id'); */

    $this->db->from('customer_carts');
    $this->db->join('product_details', 'product_details.product_id = customer_carts.product_id');
    $this->db->join('product_variants', 'product_variants.id = customer_carts.variant_id', 'left');
    $this->db->join('products', 'customer_carts.product_id = products.id');

    $this->db->group_by('product_details.product_id');
    // $this->db->group_by('customer_carts.customer_email');
    $this->db->group_by('customer_carts.variant_id');

    $this->db->where('customer_carts.customer_email', $email);
    $this->db->order_by('customer_carts.created_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function getShoppingCartDetail($email)
  {
    $this->db->from('customer_carts');

    $this->db->where('customer_email', $email);
    // $this->db->group_by('customer_email');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function sumShoppingCart($email)
  {
    // $this->db->select('*, SUM(amount_price * quantity) as total_price');
    $this->db->select('*, SUM(customer_carts.quantity * products.price) as total_price, SUM(customer_carts.quantity * products.weight) as total_weight');
    $this->db->from('customer_carts');
    $this->db->join('products', 'products.id = customer_carts.product_id', 'left');

    $this->db->where('customer_email', $email);
    // $this->db->group_by('customer_email');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function updateDetailShoppingCart($email, $prod_id, $variant_id, $data)
  {
    if ($variant_id != null) {
      $this->db->where('customer_email', $email);
      $this->db->where('product_id', $prod_id);
      $this->db->where('variant_id', $variant_id);
    } else {
      $this->db->where('customer_email', $email);
      $this->db->where('product_id', $prod_id);
    }

    $this->db->update('customer_carts', $data);
  }
}
  
  /* End of file Product_m.php */
