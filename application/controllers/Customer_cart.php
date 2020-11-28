<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_cart extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);
    $this->load->helper(['template', 'authaccess']);

    if (!$this->session->userdata('customer_email')) {
      redirect('sign-in', 'refresh');
    }
  }

  public function index()
  {
    $info['title'] = 'Shopping Cart Page';

    /* $email = $this->session->userdata('customer_email');
    $info['carts'] = $this->customerCart_m->getDetailShoppingCart($email); */

    renderFrontTemplate('front-container/shopping-cart-page-section', $info);
  }

  public function getDetailShoppingCart()
  {
    $email = $this->session->userdata('customer_email');
    $data = $this->customerCart_m->getDetailShoppingCart($email);

    $response = array();

    $html = '';
    $i = 0;

    // sub price price dikali qty per row 
    // total price jumlah total sub price
    if ($data != null) {
      foreach ($data as $val) {
        $id = htmlspecialchars(json_encode($val['id_cart']));

        $i++;

        $html .= '<tr id="row_' . $i . '">' .
          '<td class="cart-pic">
              <a href="' . base_url() . 'product-detail/' . $val['slug'] . '"><img style="width: 170px; height: 170px" src="' . base_url() . 'image/product/' . $val['image'] . '" alt=""></a>' .
          '<input type="hidden" name="id_product[]" id="id_product_' . $i . '" value="' . $val['id_product'] . '" readonly>' .
          '</td>' .

          '<td class="cart-title">' .
          '<a href="' . base_url() . 'product-detail/' . $val['slug'] . '"><h5>' . $val['product_name'] . '</h5></a>' .
          '</td>' .

          '<td class="p-price">' . $val['price'] .
          '<input type="hidden" name="price_val[]" id="price_val_' . $i . '" value="' . $val['price'] . '" readonly>' .
          '</td>' .

          '<td class="qua-col">' .
          '<div class="quantity">' .
          '<div class="pro-qty">' .
          '<input type="number" name="qty_val[]" id="qty_val_' . $i . '" value="' .  $val['cart_qty'] . '" min="1" onchange="numberFormat(this); getCartValidateQty(' . $i . '); getTotal(' . $i . ')">' .
          '</div>' .
          '</div>' .
          '</td>';

        $qty_price = $val['price'] * $val['cart_qty'];

        $html .= '<td class="total-price" id="amount_' . $i . '">' . $qty_price .
          '</td>' .
          '<input type="hidden" name="amount_val[]" id="amount_val_' . $i . '" value="' .   $qty_price . '" readonly>' .

          '<td class="close-td"><i class="ti-close" onclick="deleteShoppingCart(' . $id . '); removeRow(\'' . $i . '\')"></i></td>' .
          '</tr>';
      }
    } else {
      $html .= '<tr><td colspan="10" style="text-align: center">Data not found !</td></tr>';
    }

    // $response['total_price'] = $total_price;
    $response['html'] = $html;

    echo json_encode($response);
  }

  /* public function getDetailShoppingCart()
  {
    $email = $this->session->userdata('customer_email');
    $data = $this->customerCart_m->getDetailShoppingCart($email);

    $response = array();

    $html = '';

    // sub price price dikali qty per row 
    // total price jumlah total sub price 
    foreach ($data as $val) {
      $id = htmlspecialchars(json_encode($val['id_cart']));

      $html .= '<tr>' .
        '<td class="cart-pic"><img style="width: 170px; height: 170px" src="' . base_url() . 'image/product/' . $val['image'] . '" alt=""></td>' .
        '<td class="cart-title">' .
        '<h5>' . $val['product_name'] . '</h5>' .
        '</td>' .
        '<td class="p-price">Rp. ' . number_format($val['price'], 0, ',', '.') . '</td>' .
        '<td class="qua-col">' .
        '<div class="quantity">' .
        '<div class="pro-qty">' .
        '<input type="text" id="qty_val" value="' . $val['cart_qty'] . '" onkeyup="numberFormat(this); subAmount()">' .
        '<input type="hidden" id="qty_val_hide" value="' . $val['cart_qty'] . '" readonly>' .
        '</div>' .
        '</div>' .
        '</td>' .
        '<td class="total-price">Rp. ' . number_format($val['amount_price'], 0, ',', '.') . '</td>' .
        '<td class="close-td"><i class="ti-close" onclick="deleteShoppingCart(' . $id . ')"></i></td>' .
        '</tr>';

      $total_price = $val['total_price'];
    }

    $response['total_price'] = $total_price;
    $response['html'] = $html;

    echo json_encode($response);
  } */

  /* public function getDetailShoppingCart()
  {
    $email = $this->session->userdata('customer_email');
    $data = $this->customerCart_m->getDetailShoppingCart($email);

    echo json_encode($data);
  } */
}
  
  /* End of file Customer_cart.php */
