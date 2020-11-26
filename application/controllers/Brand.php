<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Brand";

    renderBackTemplate('brands/index', $info);

    $this->load->view('brands/modal-brand');
  }

  // DataTables Controller Setup
  function show_ajax_brand()
  {
    $list = $this->brand_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $row = array();
      $id = htmlspecialchars(json_encode($item->id));
      $row[] = $no . ".";
      $row[] = $item->brand_name;

      // add html for action
      $row[] = '<a href="javascript:void(0)" onclick="edit_brand(' . $id . ')" class="btn btn-warning btn-xs" title="edit data"><i class="fa fa-pencil"></i> Update</a>

      <a href="javascript:void(0)" onclick="delete_brand(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>';

      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->brand_m->count_all(),
      "recordsFiltered" => $this->brand_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

  public function setAddBrand()
  {
    $response = array();

    $this->form_validation->set_rules('name_brand', 'Brand name can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $data = [
        'brand_name' => $this->input->post('name_brand')
      ];

      $insert = $this->brand_m->insertBrand($data);

      if ($insert > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'Congratulations, data was saved successfully.';
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Sorry, data was not saved successfully. Please try again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function getEditBrand()
  {
    $brand_id = $this->input->post('brand_id');

    $data = $this->brand_m->getDetailBrandByID($brand_id);

    if ($data != null) {
      $dataBrand = $data;
    } else {
      $dataBrand = '';
    }

    echo json_encode($dataBrand);
  }

  public function setUpdateBrand()
  {
    $response = array();
    $brand_id = $this->input->post('id_brand');

    $this->form_validation->set_rules('name_brand', 'Brand name can not be empty', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $data = [
        'brand_name' => $this->input->post('name_brand')
      ];

      $update = $this->brand_m->updateBrand($brand_id, $data);

      if ($update > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'Congratulations, data was updated successfully.';
      } else {
        $response['status'] = FALSE;
        $response['message'] = 'Sorry, data was not updated successfully. Please try again!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function setDeleteBrand()
  {
    $response = array();
    $brand_id = $this->input->post('brand_id');

    $delete = $this->brand_m->deleteBrand($brand_id);

    if ($delete > 0) {
      $response['status'] = TRUE;
      $response['message'] = 'Congratulations, data was deleted successfully.';
    } else {
      $response['status'] = FALSE;
      $response['message'] = 'Sorry, data was not deleted successfully. Please try again!';
    }

    echo json_encode($response);
  }
}
  
  /* End of file Brand.php */
