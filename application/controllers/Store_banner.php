<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Store_banner extends CI_Controller
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
    $info['title']  = "Store Banner";

    renderBackTemplate('store-settings/store-banner', $info);
    $this->load->view('modals/modal-store-banner');
    $this->load->view('modals/modal-delete');
  }

  public function getAllStoreBanner()
  {
    $data = $this->storeBanner_m->getAllStoreBanner();
    echo json_encode($data);
  }

  private function _uploadImage()
  {
    $config['upload_path'] = './image/gallery/';
    $config['allowed_types'] = 'gif|jpg|png';
    // $config['max_size'] = 2048;

    // $config['maintain_ratio'] = TRUE;
    // $config['width'] = 1200;
    // $config['height'] = 675;
    // $config['quality'] = '60%';

    $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
      return $this->upload->data('file_name');
    } else {
      $this->session->set_flashdata('error', $this->upload->display_errors());
    }
  }

  private function _uploadResizeImage()
  {
    $config['upload_path'] = './image/gallery/';
    $config['allowed_types'] = 'jpg|png|jpeg|JPG';
    // $config['max_size'] = 2048;
    $config['encrypt_name'] = TRUE;

    $this->upload->initialize($config);
    $this->upload->do_upload('image');

    $image_data = $this->upload->data();

    $config['image_library'] = 'gd2';
    $config['source_image'] = './image/gallery/' . $image_data['file_name'];
    $config['maintain_ratio'] = TRUE;
    $config['width'] = 1200;
    $config['height'] = 675;
    $config['quality'] = '80%';

    $this->load->library('image_lib', $config);
    $this->image_lib->resize();

    return $this->upload->data('file_name');
  }

  public function insertStoreBanner()
  {
    $response = array();

    $data = [
      'title' => $this->input->post('title', true),
      'sub_title' => $this->input->post('sub_title', true),
      'image' => $this->_uploadResizeImage(),
      'button_link_title' => $this->input->post('link_title', true),
      'button_link_url' => $this->input->post('link', true)
    ];

    $getTitleBanner = $this->storeBanner_m->getDetailTitleBanner($this->input->post('title'));
    $query = $this->db->get_where('store_banner', ['title' => $this->input->post('title')]);

    if ($query->num_rows() > 0) {
      $response['status'] = false;
      $response['notif'] = "Sorry, for the " . $getTitleBanner['title'] . " is already set in the banner.";
    } else {
      $insert = $this->storeBanner_m->insertStoreBanner($data);

      if ($insert > 0) {
        $response['status'] = true;
        $response['notif'] = 'Banner has been set!';
      } else {
        $response['status'] = false;
        $response['notif'] = 'There is something wrong, please save again!';
      }
    }

    echo json_encode($response);
  }


  /* public function insertStoreBanner()
  {
    $response = array();

    $this->form_validation->set_rules('title', 'Title can not be empty', 'trim|required');

    if ($this->form_validation->run() == true) {

      $config['upload_path'] = './image/gallery/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = 2048;

      $config['encrypt_name'] = TRUE; // md5(uniqid(mt_rand())).$this->file_ext;

      $this->upload->initialize($config);

      if (!empty($_FILES['image']['name'])) {

        if ($this->upload->do_upload('image')) {
          $gbr = $this->upload->data();
          //Compress Image
          $config['image_library'] = 'gd2';
          $config['source_image'] = './image/gallery/' . $gbr['file_name'];
          $config['create_thumb'] = FALSE;
          $config['maintain_ratio'] = FALSE;
          $config['quality'] = '70%';
          $config['width'] = 1200;
          $config['height'] = 675;
          $config['new_image'] = './image/gallery/' . $gbr['file_name'];
          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          $gambar = $gbr['file_name'];

          $data = [
            'title' => $this->input->post('title', true),
            'sub_title' => $this->input->post('sub_title', true),
            'image' => $gambar,
            'button_link_url' => $this->input->post('link', true)
          ];

          $getTitleBanner = $this->storeBanner_m->getDetailTitleBanner($this->input->post('title'));
          $query = $this->db->get_where('store_banner', ['title' => $this->input->post('title')]);

          if ($query->num_rows() > 0) {
            $response['status'] = false;
            $response['notif'] = "Sorry, for the " . $getTitleBanner['title'] . " is already set in the banner.";
          } else {
            $insert = $this->storeBanner_m->insertStoreBanner($data);

            if ($insert > 0) {
              $response['status'] = true;
              $response['notif'] = 'Banner has been set!';
            } else {
              $response['status'] = false;
              $response['notif'] = 'There is something wrong, please save again!';
            }
          }
        } else {
          $response['status'] = false;
          $response['notif'] = "Please upload the image in accordance with the recommendations!";
        }
      } else {
        $response['status'] = false;
        $response['notif'] = 'Banner image cannot be empty!';
      }
    } else {
      $response['status'] = false;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  } */

  public function getDataStoreBanner($id)
  {
    $data = $this->storeBanner_m->getDataStoreBanner($id);
    echo json_encode($data);
  }

  public function updateStoreBanner()
  {
    $response = array();

    $this->form_validation->set_rules('title', 'Title can not be empty', 'trim|required');

    if ($this->form_validation->run() == true) {

      if (empty($_FILES['image']['name'])) {
        $data = [
          'title' => $this->input->post('title', true),
          'sub_title' => $this->input->post('sub_title', true),
          'button_link_title' => $this->input->post('link_title', true),
          'button_link_url' => $this->input->post('link', true)
        ];
      } else {
        $data = [
          'title' => $this->input->post('title', true),
          'sub_title' => $this->input->post('sub_title', true),
          'image' => $this->_uploadResizeImage(),
          'button_link_title' => $this->input->post('link_title', true),
          'button_link_url' => $this->input->post('link', true)
        ];

        @unlink('./image/gallery/' . $this->input->post('old_image'));
      }

      $id = $this->input->post('id');
      $update = $this->storeBanner_m->updateStoreBanner($id, $data);

      if ($update > 0) {
        $response['status'] = true;
        $response['notif'] = 'Banner has been updated!';
      } else {
        $response['status'] = false;
        $response['notif'] = 'There is something wrong, please update again!';
      }
    } else {
      $response['status'] = false;
      $response['notif'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function deleteStoreBanner()
  {
    $id = $this->input->post('id');

    $rows = $this->db->get_where('store_banner', array('id' => $id));
    $result = $rows->result();

    foreach ($result as $row) {
      @unlink('./image/gallery/' . $row->image);
    }

    $data = $this->storeBanner_m->deleteStoreBanner($id);

    echo json_encode($data);
  }
}
  
  /* End of file Store_banner.php */
