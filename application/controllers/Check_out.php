<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Check_out extends CI_Controller
{
  private $url = "https://api.rajaongkir.com/starter/";
  private $apiKey = "9a7210468b5c06925a600b0c0404af50";

  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);
    $this->load->helper(['template', 'authaccess']);

    if (!$this->session->userdata('customer_email')) {
      redirect('sign-in');
    }
  }

  private function rajaOngkir($method, $id_prov = null)
  {
    $endPoint = $this->url . $method;

    if ($id_prov != null) {
      $endPoint = $endPoint . "?province=" . $id_prov;
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $endPoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: " . $this->apiKey
      ),
    ));

    $response = curl_exec($curl);

    $return = ($response === FALSE) ? curl_error($curl) : $response;
    curl_close($curl);
    return $return;
  }

  public function getProvince()
  {
    $data = $this->rajaOngkir('province');
    $getResult = json_decode($data)->rajaongkir->results;

    // echo json_encode($getResult);

    $row = array();
    if ($getResult > 0) {
      foreach ($getResult as $val) {
        $row[] = array(
          'id' => $val->province_id,
          'text' => $val->province
        );
      }
    }
    echo json_encode($row);
  }

  public function getCityRegency()
  {
    $getInput = $this->input->get('province_id');

    $data = $this->rajaOngkir('city', $getInput);
    $getResult = json_decode($data)->rajaongkir->results;

    echo json_encode($getResult);
  }

  public function getAddressDetailProvinceCity()
  {
    $getProvince = $this->input->get('province_id');
    $getCity = $this->input->get('city_id');
    $email = $this->session->userdata('customer_email');

    $response = array();

    $data = $this->customerProfile_m->getFullAdressCustomer($email);

    $dataRajaOnkir = $this->rajaOngkir('city?id=' . $data['city_id'], $data['province_id']);
    $getResult = json_decode($dataRajaOnkir, true);
    $getData = $getResult['rajaongkir']['results'];

    if ($data['street_name'] != null || $data['province_id'] != null) {
      $response['name'] = $data['customer_name'];
      $response['email'] = $data['customer_email'];
      $response['phone'] = $data['customer_phone'];
      $response['province'] = $getData['province'];
      $response['city_name'] = $getData['city_name'];
      $response['city_id'] = $getData['city_id'];
      $response['street_name'] = $data['street_name'];

      $response['html'] = '<label class = "col-sm-2 col-form-label">Your address </label>' .
        '<div class="col-sm-10">' .
        '<textarea class="form-control" name="full_address" id="full_address" cols="5" rows="5" readonly>' . $data['street_name'] . ', ' . $getData['city_name'] . ', ' . $getData['province'] . '</textarea>' . '</div>';
    } else {
      $response['name'] = '';
      $response['email'] = '';
      $response['phone'] = '';
      $response['province'] = '';
      $response['city_name'] = '';
      $response['city_id'] = '';
      $response['street_name'] = '';

      $response['html'] = '';
    }

    echo json_encode($response);
  }

  public function getCompanyAddressDetailProvinceCity()
  {
    $response = array();

    $data = $this->company_m->getFullAdressCustomer(1);

    $dataRajaOnkir = $this->rajaOngkir('city?id=' . $data['city_id'], $data['province_id']);
    $getResult = json_decode($dataRajaOnkir, true);
    $getData = $getResult['rajaongkir']['results'];

    if ($data['street_name'] != null || $data['province_id'] != null) {
      $response['name'] = $data['company_name'];
      $response['email'] = $data['business_email'];
      $response['phone'] = $data['phone'];
      $response['province'] = $getData['province'];
      $response['city_name'] = $getData['city_name'];
      $response['city_id'] = $getData['city_id'];
      $response['street_name'] = $data['street_name'];

      $response['html'] = '<textarea class="form-control" name="full_address" id="full_address" cols="5" rows="5" readonly>' . $data['street_name'] . ', ' . $getData['city_name'] . ', ' . $getData['province'] . '</textarea>' . '</div>';
    } else {
      $response['name'] = '';
      $response['email'] = '';
      $response['phone'] = '';
      $response['province'] = '';
      $response['city_name'] = '';
      $response['city_id'] = '';
      $response['street_name'] = '';

      $response['html'] = '';
    }

    echo json_encode($response);
  }

  private function rajaOngkirCost($origin, $destination, $weight, $courier)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: " . $this->apiKey
      ),
    ));

    $response = curl_exec($curl);

    $return = ($response === FALSE) ? curl_error($curl) : $response;
    curl_close($curl);
    return $return;
  }

  public function getCost()
  {
    $getOrigin = $this->input->get('origin');
    $getDestination = $this->input->get('destination');
    $getWeight = $this->input->get('weight');
    $getCourier = $this->input->get('courier');

    $data = $this->rajaOngkirCost($getOrigin, $getDestination, $getWeight, $getCourier);
    $getResult = json_decode($data)->rajaongkir->results;
    // $getData = $getResult[0]->costs;

    echo json_encode($getResult);
  }

  public function index()
  {
    $info['title'] = 'Check Out Page';

    renderFrontTemplate('front-container/shopping-checkout-page-section', $info);
  }

  public function getCheckOutBilling()
  {
    $email = $this->session->userdata('customer_email');
    $getDetailCust = $this->checkOut_m->getCheckOutBilling($email);

    if ($getDetailCust != null) {
      $data = $getDetailCust;
    } else {
      $data = '';
    }

    echo json_encode($data);
  }

  public function getCheckOutOrder()
  {
    $email = $this->session->userdata('customer_email');
    $response = array();

    $data = $this->customerCart_m->getDetailShoppingCart($email);

    $html = '';
    $i = 0;

    if ($data != null) {
      foreach ($data as $val) {
        $i++;

        $html .= '<li class="fw-normal">
        ' . $val['product_name'] . ' x ' . $val['cart_qty'];

        $qty_price = $val['cart_qty'] * $val['price'];

        $html .= '<span>Rp. ' . number_format($qty_price, 0, ',', '.') . '
        </span>

        <input type="hidden" name="product_id[]" id="product_row_' . $i . '" value="' . $val['id_product'] . '" readonly
        <input type="hidden" name="unit_price[]" id="unit_price_row_' . $i . '" value="' . $val['price'] . '" readonly>
        <input type="hidden" name="qty[]" id="qty_row_' . $i . '" value="' . $val['cart_qty'] . '" readonly>
        <input type="hidden" name="amount_price[]" id="amount_price_row_' . $i . '" value="' . $qty_price . '" readonly>
        <input type="hidden" name="weight[]" id="weight_row_' . $i . '" value="' . $val['weight'] . '" readonly>

        </li>';
      }
    } else {
      $html .= '<li class="fw-normal">Please select the item you want to buy!</li>';
    }

    // get sum of quantity and price
    $sumPrice = $this->product_m->sumShoppingCart($email);

    if ($sumPrice != null) {
      foreach ($sumPrice as $val) {
        $sumPrice = $val['total_price'];
        $sumWeight = $val['total_weight'];
      }
    } else {
      $sumPrice = 0;
      $sumWeight = 0;
    }

    $response['html'] = $html;
    $response['cart_total'] = 'Rp. ' . number_format($sumPrice, 0, ',', '.') . '';
    $response['cart_total_val'] = $sumPrice;
    $response['cart_weight_val'] = $sumWeight;

    echo json_encode($response);
  }

  public function getCheckCompanyChargeValue()
  {
    $data = $this->company_m->getChargeValue(1);

    echo json_encode($data);
  }

  public function insertCheckOut()
  {
    $rules = [
      [
        'field' => 'name',
        'label' => 'customer name',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'street',
        'label' => 'street address',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'email',
        'label' => 'email address',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'phone',
        'label' => 'phone number',
        'rules' => 'trim|required|numeric'
      ],
      [
        'field' => 'courier',
        'label' => 'shipping courier',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'service',
        'label' => 'shipping service',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'product_id[]',
        'label' => 'product',
        'rules' => 'trim|required'
      ]
    ];

    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{label} can not empty!');

    $response = array();

    $generate_id = 'O-' . date('His');
    $generate_invoice_order = date("d") . date("m") . date('y') . '-OP-' . date('His');
    $email = $this->session->userdata('customer_email');

    if ($this->form_validation->run() == FALSE) {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    } else {
      $data_order = [
        'id' => $generate_id,
        'invoice_order' => $generate_invoice_order,
        'customer_email' => $email,
        'purchase_order_date' => time(),
        'gross_amount' => $this->input->post('check_out_subtotal_val'),
        'ship_amount' => $this->input->post('cost_val'),
        'vat_charge_rate' => $this->input->post('check_out_ppn_charge_rate'),
        'vat_charge_val' => $this->input->post('check_out_ppn_charge_val'),
        'vat_charge' => $this->input->post('check_out_ppn_charge'),
        'coupon_charge_rate' => 0,
        'coupon_charge' => 0,
        'net_amount' => $this->input->post('check_out_total'),
        'created_date' => date('Y-m-d H:i:s'),
        'status_order_id' => 2,
      ];

      $data_order_shipping = [
        'purchase_order_id' => $generate_id,
        'courier' => $this->input->post('courier'),
        'service' => $this->input->post('service_val'),
        'etd' => $this->input->post('etd_val'),
        'delivery_receipt_number' => null,
      ];

      $count_product = count($this->input->post('product_id'));

      for ($j = 0; $j < $count_product; $j++) {
        $getProduct = $this->product_m->getProductById($this->input->post('product_id')[$j]);
        $getProductVariant = $this->product_m->variantDataByID($this->input->post('variant_id')[$j]);
        $qtyProduct = $this->input->post('qty')[$j];
        $vrntProduct = $this->input->post('variant_id')[$j];
        $idProduct = $this->input->post('product_id')[$j];

        // checking product has variant or not
      }

      $checkVariantExist = $this->product_m->existsDataVariant($idProduct);

      // kalo ada variant maka dikondisikan dengan qty variant
      if (($getProductVariant['variant_qty'] >= $qtyProduct) && ($getProduct['qty'] >= $qtyProduct)) {
        // store data into purchase order
        $this->customerPurchase_m->insertPurchaseOrders($data_order);

        // store data into purchase order shipping
        $this->customerPurchase_m->insertPurchaseOrderShipping($data_order_shipping);

        // Store to sales_order_details
        for ($i = 0; $i < $count_product; $i++) {
          $data_order_detail = [
            'purchase_order_id' => $generate_id,
            'product_id' => $this->input->post('product_id')[$i],
            'product_variant_id' => $this->input->post('variant_id')[$i],
            'weight' => $this->input->post('weight')[$i],
            'qty' => $this->input->post('qty')[$i],
            'unit_price' => $this->input->post('unit_price')[$i],
            'amount' => $this->input->post('amount_price')[$i],
            'status_order_id' => 2
          ];

          $this->customerPurchase_m->insertPurchaseOrderDetails($data_order_detail);

          if ($checkVariantExist == true) {
            // Update product to decrease stock after doing new order especially in product variants
            $data_product_variant = $this->product_m->variantDataByID($this->input->post('variant_id')[$i]);
            $qty_variant = ((int)$getProductVariant['variant_qty'] - (int)$this->input->post('qty')[$i]);

            $update_product_variant = array(
              'variant_qty' => $qty_variant
            );

            $this->product_m->updateProductVariant($this->input->post('variant_id')[$i], $update_product_variant);
          } else {
            // Update product to decrease stock after doing new order especially in products
            $data_product = $this->product_m->getProductById($this->input->post('product_id')[$i]);
            $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];

            $update_product = array(
              'qty' => $qty
            );

            $this->product_m->update($this->input->post('product_id')[$i], $update_product);
          }
        }

        $this->customerCart_m->deleteCart($email);

        $response['status'] = true;
        $response['qty'] = $qty_variant;
        $response['message'] = 'Your order has been added, please make a payment immediately!';
        // redirect('order', 'refresh');
      } else {
        $response['status'] = false;
        $response['message'] = 'Your quantity of ' . $getProductVariant['product_name'] . ' is limited !';
        // redirect('orders/addorder', 'refresh');
      }

      /* if ($checkVariantExist == true) {
        // kalo ada variant maka dikondisikan dengan qty variant
        if ($getProductVariant['variant_qty'] >= $qtyProduct) {
          // store data into purchase order
          $this->customerPurchase_m->insertPurchaseOrders($data_order);

          // store data into purchase order shipping
          $this->customerPurchase_m->insertPurchaseOrderShipping($data_order_shipping);

          // Store to sales_order_details
          for ($i = 0; $i < $count_product; $i++) {
            $data_order_detail = [
              'purchase_order_id' => $generate_id,
              'product_id' => $this->input->post('product_id')[$i],
              'product_variant_id' => $this->input->post('variant_id')[$i],
              'weight' => $this->input->post('weight')[$i],
              'qty' => $this->input->post('qty')[$i],
              'unit_price' => $this->input->post('unit_price')[$i],
              'amount' => $this->input->post('amount_price')[$i],
              'status_order_id' => 2
            ];

            $this->customerPurchase_m->insertPurchaseOrderDetails($data_order_detail);

            // Update product to decrease stock after doing new order especially in product variants
            $data_product_variant = $this->product_m->variantDataByID($this->input->post('variant_id')[$i]);
            $qty_variant = ((int)$getProductVariant['variant_qty'] - (int)$this->input->post('qty')[$i]);

            $update_product_variant = array(
              'variant_qty' => $qty_variant
            );

            $this->product_m->updateProductVariant($this->input->post('variant_id')[$i], $update_product_variant);
          }

          $this->customerCart_m->deleteCart($email);

          $response['status'] = true;
          $response['qty'] = $qty_variant;
          $response['message'] = 'Your order has been added, please make a payment immediately!';
          // redirect('order', 'refresh');
        } else {
          $response['status'] = false;
          $response['message'] = 'Your quantity of ' . $getProductVariant['product_name'] . ' is limited !';
          // redirect('orders/addorder', 'refresh');
        }
      } else {
        // kalo tidak ada maka dikondisikan dengan qty product
        if ($getProduct['qty'] >= $qtyProduct) {
          // store data into purchase order
          $this->customerPurchase_m->insertPurchaseOrders($data_order);

          // store data into purchase order shipping
          $this->customerPurchase_m->insertPurchaseOrderShipping($data_order_shipping);

          // Store to purchase_order_details
          for ($i = 0; $i < $count_product; $i++) {
            $data_order_detail = [
              'purchase_order_id' => $generate_id,
              'product_id' => $this->input->post('product_id')[$i],
              'product_variant_id' => 404,
              'weight' => $this->input->post('weight')[$i],
              'qty' => $this->input->post('qty')[$i],
              'unit_price' => $this->input->post('unit_price')[$i],
              'amount' => $this->input->post('amount_price')[$i],
              'status_order_id' => 2
            ];

            $this->customerPurchase_m->insertPurchaseOrderDetails($data_order_detail);

            // Update product to decrease stock after doing new order especially in products
            $data_product = $this->product_m->getProductById($this->input->post('product_id')[$i]);
            $qty = (int) $data_product['qty'] - (int) $this->input->post('qty')[$i];

            $update_product = array(
              'qty' => $qty
            );

            $this->product_m->update($this->input->post('product_id')[$i], $update_product);
          }

          $this->customerCart_m->deleteCart($email);

          $response['status'] = true;
          $response['qty'] = $qty;
          $response['message'] = 'Your order has been added, please make a payment immediately!';
          // redirect('order', 'refresh');
        } else {
          $response['status'] = false;
          $response['message'] = 'Your quantity of ' . $getProductVariant['product_name'] . ' is limited !';
          // redirect('orders/addorder', 'refresh');
        }
      } */
    }

    echo json_encode($response);
  }
}
  
  /* End of file Check_out.php */
