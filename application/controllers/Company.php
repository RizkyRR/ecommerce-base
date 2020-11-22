<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{
  private $url = "https://api.rajaongkir.com/starter/";
  private $apiKey = "9a7210468b5c06925a600b0c0404af50";

  public function __construct()
  {
    parent::__construct();

    $this->load->library(['upload']);

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Manage Company";

    renderBackTemplate('admins/manage-company', $info);
    $this->load->view('modals/modal-dash-control', $info);
    $this->load->view('modals/modal-delete');
  }

  // SOCIAL MEDIA
  public function getCompanySocialMedia()
  {
    $response = array();

    $html = '';
    $i = 0;

    $dataSocialMedia = $this->company_m->getCompanySocialMedia(1);
    $dataSocialLink = $this->company_m->getSocialLink();

    if ($dataSocialMedia != null) {
      $option = '';
      foreach ($dataSocialMedia as $val) {
        $id = htmlspecialchars(json_encode($val['company_profile_id']));
        $i++;

        if ($dataSocialLink != null) {
          foreach ($dataSocialLink as $key) {
            if ($val['link_id'] == $key['id']) {
              $option .= '<option value="' . $key['id'] . '" selected>' . $key['link_name'] . '</option>';
            } else {
              $option .= '<option value="' . $key['id'] . '">' . $key['link_name'] . '</option>';
            }
          }
        }

        $html .= '<tr id="row_' . $i . '">' .
          '<td>' .
          '<select name="link[]" id="link_' . $i . '" class="form-control select_group link" data-row-id="row_' . $i . '" style="width: 100%;">' .
          $option .
          '</select>' .
          '</td>' .

          '<td>' .
          '<input type="text" name="url[]" id="url_' . $i . '" class="form-control" required value="' .   $val['url'] . '">' .
          '</td>' .

          '<td>' .
          '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(' . $i . ')"><i class="fa fa-close"></i></button>' .
          '</td>' .
          '</tr>';
      }
    }

    $response['html'] = $html;

    echo json_encode($response);
  }

  public function actionCompanySocialMedia()
  {
    $response = array();

    $this->form_validation->set_rules('link[]', 'Link can not be empty', 'trim|required');
    $this->form_validation->set_rules('url[]', 'URL can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      // remove the blog profile detail
      $this->db->where('company_profile_id', 1);
      $this->db->delete('company_profile_detail');

      // Store to company_profile_detail
      $count_link = count($this->input->post('link'));
      for ($i = 0; $i < $count_link; $i++) {
        $links = [
          'company_profile_id' => 1,
          'link_id' => $this->input->post('link')[$i],
          'url' => $this->input->post('url')[$i]
        ];

        $insert = $this->company_m->insertCompanyDetail($links);
      }

      if ($insert > 0) {
        $response['status'] = TRUE;
        $response['notif'] = 'Social media link has been set!';
        $response['id'] = $insert;
      } else {
        $response['status'] = FALSE;
        $response['notif'] = 'There is something wrong, please submit again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function getTableLinkRow()
  {
    $data = $this->company_m->getSocialLink();
    echo json_encode($data);
  }

  // ADDRESS PURPOSES
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

  public function getAddressDetailProvinceCity()
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

  public function updateDataCompanyAddress()
  {
    $response = array();

    $data = [
      'province_id' => $this->input->post('province', true),
      'province' => $this->input->post('province_name', true),
      'city_id' => $this->input->post('regency', true),
      'city_name' => $this->input->post('regency_name', true),
      'street_name' => $this->input->post('street_name', true)
    ];

    $checkDataExist = $this->company_m->existsDataAddress();

    if ($checkDataExist == true) {
      $update = $this->company_m->updateDataCompanyAddress(1, $data);

      if ($update > 0) {
        $response['status'] = "true";
        $response['notif'] = 'Your address has been updated!';
      } else {
        $response['status'] = "false";
        $response['notif'] = 'Your address was saved unsuccessfully, please try again!';
      }
    } else {
      $this->db->insert('company_profile_address', ['company_profile_id' => 1, 'province_id' => $this->input->post('province', true), 'province' => $this->input->post('province_name', true), 'city_id' => $this->input->post('regency', true), 'city_name' => $this->input->post('regency_name', true), 'street_name' => $this->input->post('street_name', true)]);

      $response['status'] = "true";
      $response['notif'] = 'Your address was saved successfully!';
    }

    echo json_encode($response);
  }

  // BASE PROFILE
  private function _uploadResizeImage()
  {
    $config['upload_path'] = './image/logo/';
    $config['allowed_types'] = 'jpg|png|jpeg|JPG';
    // $config['max_size'] = 2048;
    $config['encrypt_name'] = TRUE;

    $this->upload->initialize($config);
    $this->upload->do_upload('logo');

    $image_data = $this->upload->data();

    $config['image_library'] = 'gd2';
    $config['source_image'] = './image/logo/' . $image_data['file_name'];
    $config['maintain_ratio'] = TRUE;
    $config['width'] = 128;
    $config['height'] = 64;
    $config['quality'] = '80%';

    $this->load->library('image_lib', $config);
    $this->image_lib->resize();

    return $this->upload->data('file_name');
  }

  public function getDataBaseProfile()
  {
    $data = $this->company_m->getCompanyById(1);

    if ($data != null) {
      $getResult = $data;
    } else {
      $getResult = '';
    }

    echo json_encode($getResult);
  }

  public function updateDataBaseProfile()
  {
    $response = array();

    $this->form_validation->set_rules('name', 'Company name can not be empty', 'trim|required');
    $this->form_validation->set_rules('email', 'Email can not be empty', 'trim|required|valid_email');
    $this->form_validation->set_rules('phone', 'Phone can not be empty', 'trim|required|numeric');
    $this->form_validation->set_rules('about', 'About can not be empty', 'trim|required|min_length[50]');

    if ($this->form_validation->run() == TRUE) {
      if (empty($_FILES['logo']['name'])) {
        $data = [
          'company_name' => $this->input->post('name'),
          'business_email' => $this->input->post('email'),
          'phone' => $this->input->post('phone'),
          'about' => $this->input->post('about'),
        ];
      } else {
        $data = [
          'company_name' => $this->input->post('name'),
          'business_email' => $this->input->post('email'),
          'phone' => $this->input->post('phone'),
          'image' => $this->_uploadResizeImage(),
          'about' => $this->input->post('about'),
        ];

        @unlink('./image/logo/' . $this->input->post('old_logo'));
      }

      $update = $this->company_m->update(1, $data);

      if ($update > 0) {
        $response['status'] = TRUE;
        $response['notif'] = 'Base profile has been updated!';
      } else {
        $response['status'] = FALSE;
        $response['notif'] = 'There is something wrong, please update again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  }

  // SET CHARGE VALUE 
  public function getChargeValue()
  {
    $dataChargeValue = $this->company_m->getChargeValue(1);

    if ($dataChargeValue != null) {
      // update
      $data = $dataChargeValue;
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function actionChargeValue()
  {
    $response = array();
    $dataChargeValue = $this->company_m->getChargeValue(1);

    if ($dataChargeValue != null) {
      // update
      $update = $this->company_m->updateChargeValue(1, ['service_charge_value' => $this->input->post('service_charge_value'), 'vat_charge_value' => $this->input->post('vat_charge_value')]);

      if ($update > 0) {
        $response['status'] = 'update';
      }
    } else {
      // insert
      $insert = $this->company_m->insertChargeValue(['company_profile_id' => 1, 'service_charge_value' => $this->input->post('service_charge_value'), 'vat_charge_value' => $this->input->post('vat_charge_value')]);

      if ($insert > 0) {
        $response['status'] = 'insert';
      }
    }

    echo json_encode($response);
  }

  // BANK ACCOUNT
  public function getCompanyBankAccount()
  {
    $response = array();

    $html = '';
    $i = 0;

    $dataBankAccount = $this->company_m->getCompanyBankAccount(1);

    if ($dataBankAccount != null) {
      foreach ($dataBankAccount as $val) {
        $id = htmlspecialchars(json_encode($val['company_profile_id']));
        $i++;

        $html .= '<tr id="row_' . $i . '">' .
          '<td>' .
          '<input type="text" name="bank_name[]" id="bank_name_' . $i . '" class="form-control" required value="' .   $val['bank_name'] . '">' .
          '</td>' .

          '<td>' .
          '<input type="text" name="account[]" id="account_' . $i . '" class="form-control" required value="' .   $val['account'] . '">' .
          '</td>' .

          '<td>' .
          '<input type="text" name="bank_account_holder[]" id="bank_account_holder_' . $i . '" class="form-control" required value="' .   $val['account_holder_name'] . '">' .
          '</td>' .

          '<td>' .
          '<button type="button" class="btn btn-danger btn-sm" onclick="removeBankAccountRow(' . $i . ')"><i class="fa fa-close"></i></button>' .
          '</td>' .
          '</tr>';
      }
    }

    $response['html'] = $html;

    echo json_encode($response);
  }

  public function actionCompanyBankAccount()
  {
    $response = array();

    $this->form_validation->set_rules('bank_name[]', 'Bank name can not be empty', 'trim|required');
    $this->form_validation->set_rules('account[]', 'Bank account can not be empty', 'trim|required');
    $this->form_validation->set_rules('bank_account_holder[]', 'Bank account holder can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      // remove the company profile bank
      $this->db->where('company_profile_id', 1);
      $this->db->delete('company_profile_banks');

      // Store to company_profile_banks
      $count_bankaccount = count($this->input->post('bank_name'));
      for ($i = 0; $i < $count_bankaccount; $i++) {
        $bankaccounts = [
          'company_profile_id' => 1,
          'bank_name' => $this->input->post('bank_name')[$i],
          'account' => $this->input->post('account')[$i],
          'account_holder_name' => $this->input->post('bank_account_holder')[$i]
        ];

        $insert = $this->company_m->insertCompanyBankAccount($bankaccounts);
      }

      if ($insert > 0) {
        $response['status'] = TRUE;
        $response['notif'] = 'Bank account has been set!';
        $response['id'] = $insert;
      } else {
        $response['status'] = FALSE;
        $response['notif'] = 'There is something wrong, please submit again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  }

  // EMAIL PURPOSES 
  public function getEmail()
  {
    $dataEmail = $this->company_m->getEmail(1);

    if ($dataEmail != null) {
      $data = $dataEmail;
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function actionSetEmail()
  {
    $response = array();
    $dataEmail = $this->company_m->getEmail(1);

    if ($dataEmail != null) {
      // update
      $update = $this->company_m->updateSetEmail(1, ['email' => $this->input->post('email_registry'), 'password' => $this->input->post('password_registry')]);

      if ($update > 0) {
        $response['status'] = 'update';
      }
    } else {
      // insert
      $insert = $this->company_m->insertSetEmail(['company_profile_id' => 1, 'email' => $this->input->post('email_registry'), 'password' => $this->input->post('password_registry')]);

      if ($insert > 0) {
        $response['status'] = 'insert';
      }
    }

    echo json_encode($response);
  }

  // SET ALERT VALUE 
  public function getAlertValue()
  {
    $dataAlertValue = $this->company_m->getAlertValue(1);

    if ($dataAlertValue != null) {
      $data = $dataAlertValue;
    } else {
      $data = [];
    }

    echo json_encode($data);
  }

  public function actionAlertValue()
  {
    $response = array();
    $dataAlertValue = $this->company_m->getAlertValue(1);

    if ($dataAlertValue != null) {
      // update
      $update = $this->company_m->updateAlertValue(1, ['minimum_stock_value' => $this->input->post('min_stock_product_val')]);

      if ($update > 0) {
        $response['status'] = 'update';
      }
    } else {
      // insert
      $insert = $this->company_m->insertAlertValue(['company_profile_id' => 1, 'minimum_stock_value' => $this->input->post('min_stock_product_val')]);

      if ($insert > 0) {
        $response['status'] = 'insert';
      }
    }

    echo json_encode($response);
  }
}
  
  /* End of file Company.php */
