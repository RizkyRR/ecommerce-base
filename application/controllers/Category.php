<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Category";

    renderBackTemplate('categories/index', $info);
    $this->load->view('modals/modal-category', $info);
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup
  function show_ajax_category()
  {
    $list = $this->category_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->category_name;
      // add html for action
      $row[] =
        '
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_category(' . $item->id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a>
        <a href="javascript:void(0)" onclick="delete_category(' . $item->id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->category_m->count_all(),
      "recordsFiltered" => $this->category_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  public function getAllCategory()
  {
    $data = $this->category_m->getAllCategory();
    echo json_encode($data);
  }

  public function add_category()
  {
    $rules = [
      [
        'field' => 'name',
        'label' => 'category name',
        'rules' => 'trim|required|min_length[3]'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name')
      ];

      echo json_encode($data);
    } else {
      $data = array(
        'category_name' => $this->input->post('name')
      );
      $this->category_m->insert($data);
      echo json_encode('success');
    }
  }

  public function edit_category($id)
  {
    $data = $this->category_m->getCategoryById($id);
    echo json_encode($data);
  }

  public function update_category()
  {
    $rules = [
      [
        'field' => 'name',
        'label' => 'category name',
        'rules' => 'trim|required|min_length[3]'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name')
      ];

      echo json_encode($data);
    } else {
      $data = array(
        'category_name' => $this->input->post('name', true)
      );
      $this->category_m->update($this->input->post('id'), $data);
      echo json_encode('success');
    }
  }

  public function delete_category()
  {
    $this->category_m->delete($this->input->post('id'));

    $this->session->set_flashdata('success', 'Deleted !');
  }
}
  
  /* End of file Category.php */
