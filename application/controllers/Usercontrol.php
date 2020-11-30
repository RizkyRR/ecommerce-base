<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usercontrol extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  /* public function index()
  {
    $info['title']  = 'User Control';

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }
    // SEARCHING

    // DB PAGINATION FOR SEARCHING
    $this->db->like('role_id', $info['keyword']);
    $this->db->or_like('role', $info['keyword']);
    $this->db->or_like('name', $info['keyword']);
    $this->db->or_like('email', $info['keyword']);
    // DB PAGINATION FOR SEARCHING

    $config['base_url']     = base_url() . 'usercontrol/index';
    $config['total_rows']   = $this->usercontrol_m->getCountPage();
    $config['per_page']     = 5;
    $config['num_links']    = 5;

    // STYLING
    $config['full_tag_open'] = false;
    $config['full_tag_close'] = false;

    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['next_link']        = '&raquo';
    $config['next_tag_open']    = '<li>';
    $config['next_tag_close']   = '</li>';

    $config['prev_link']        = '&laquo';
    $config['prev_tag_open']    = '<li>';
    $config['prev_tag_close']   = '</li>';

    $config['cur_tag_open']     = '<li class="active"><a>';
    $config['cur_tag_close']    = '</a></li>';

    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['attributes']       = array('class' => 'data-ci-pagination-page');
    // STYLING

    $this->pagination->initialize($config);

    $info['start'] = $this->uri->segment(3);
    $info['usercontrol'] = $this->usercontrol_m->getAllUser($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();


    renderBackTemplate('user-controls/index', $info);
  } */

  public function index()
  {
    $info['title']  = "User Control";
    $info['userrole'] = $this->usercontrol_m->_getAllRole();

    renderBackTemplate('user-controls/index', $info);
    $this->load->view('modals/modal-usercontrol', $info);
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_user()
  {
    $list = $this->usercontrol_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $id = htmlspecialchars(json_encode($item->user_id));

      $no++;
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->name;
      $row[] = $item->email;
      $row[] = $item->role;
      $row[] = ($item->is_active == 1) ? '<p class="label label-success">Active</p>' : '<p class="label label-danger">Inactive</p>';
      $row[] = date("d M Y", strtotime($item->created_at));
      // add html for action
      $row[] =
        '
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_user(' . $id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a>
        <a href="javascript:void(0)" onclick="delete_user(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->usercontrol_m->count_all(),
      "recordsFiltered" => $this->usercontrol_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  // public function data_user()
  // {
  //   $data = $this->usercontrol_m->getAllUser();
  //   echo json_encode($data);
  // }

  public function createCode()
  {
    $id = "USER" . "-";
    $generate = $id  . date("m") . date('y')  . date('His');

    // return $generate;
    echo json_encode($generate);
  }

  public function getRoleSelect()
  {
    $data = $this->usercontrol_m->_getAllRole();

    echo json_encode($data);
  }

  public function getRoleSelect2()
  {
    $getInput = $this->input->post('searchTerm', true);

    if (!isset($getInput)) {
      $data = $this->usercontrol_m->getAllRoleBySelect($keyword = null, $limit = 10);
    } else {
      $data = $this->usercontrol_m->getAllRoleBySelect($keyword = $getInput, $limit = 10);
    }

    $row = array();
    if ($data > 0) {
      foreach ($data as $val) {
        $row[] = array(
          'id' => $val['id'],
          'text' => $val['role']
        );
      }
    }

    echo json_encode($row);
  }

  public function getSelectedOptionRole()
  {
    $user_id = $this->input->post('user_id');

    $data = $this->usercontrol_m->getUserControlById($user_id);

    if ($data != null) {
      $dataRole = $data;
    } else {
      $dataRole = $this->usercontrol_m->getAllRoleBySelect($keyword = null, $limit = 10);
    }

    echo json_encode($dataRole);
  }

  // public function editUserControl($id)
  // {
  //   $info['title']          = 'Edit User Control';
  //   $info['userrole']       = $this->usercontrol_m->_getAllRole();
  //   $info['usercontrol']   = $this->usercontrol_m->getUserControlById($id);

  //   renderBackTemplate('user-controls/edit-user-control', $info);
  // }

  // public function updateUserControl()
  // {
  //   $status = 0; // set default if 0 status = unchecked

  //   if ($this->input->post('status') != null) {
  //     $status = 1; // if condition not null it means checked
  //   }

  //   $data = [
  //     'role_id' => $this->input->post('role', true),
  //     'is_active' => $status
  //   ];

  //   $this->usercontrol_m->updateUserControl($data);
  //   $this->session->set_flashdata('success', 'User has been updated !');
  //   redirect('usercontrol', 'refresh');
  // }

  public function add_user()
  {
    $response = array();

    $this->form_validation->set_rules('name', 'User name', 'trim|required');
    $this->form_validation->set_rules('email', 'User email', 'trim|required|valid_email');
    $this->form_validation->set_rules('role', 'User role', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $status = 0;

      if ($this->input->post('status') != null) {
        $status = 1; // if condition not null it means checked
      }

      $data = [
        'id' => $this->input->post('user_id', true),
        'name' => $this->input->post('name', true),
        'email' => $this->input->post('email', true),
        'image' => 'default.png',
        'password' => '$2y$10$ojVg/Mvr9wpLnHNd.9AxXOlpSEWuivT9dQDbnoZx5Hw9MLaCFjmWK',
        'role_id' => $this->input->post('role', true),
        'is_active' => $status,
        'created_at' => date('Y-m-d H:i:s'),
      ];

      $insert = $this->usercontrol_m->insertUserControl($data);

      if ($insert > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'New user has been successfully created!';
      } else {
        $response['status'] = False;
        $response['message'] = 'New user not saved successfully!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function edit_user()
  {
    $user_id = $this->input->post('user_id');

    $data = $this->usercontrol_m->getUserControlById($user_id);
    echo json_encode($data);
  }

  public function update_user()
  {
    $response = array();
    $user_id = $this->input->post('user_id');

    $this->form_validation->set_rules('role', 'User role', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      $status = 0;

      if ($this->input->post('status') != null) {
        $status = 1; // if condition not null it means checked
      }

      $data = [
        'role_id' => $this->input->post('role', true),
        'is_active' => $status,
      ];

      $update = $this->usercontrol_m->updateUserControl($user_id, $data);

      if ($update > 0) {
        $response['status'] = TRUE;
        $response['message'] = 'User has been successfully updated!';
      } else {
        $response['status'] = False;
        $response['message'] = 'User not updated successfully!';
      }
    } else {
      $response['status'] = FALSE;
      $response['message'] = validation_errors();
    }

    echo json_encode($response);
  }

  public function deleteUserControl()
  {
    $user_id = $this->input->post('user_id');
    $response = array();

    $delete = $this->usercontrol_m->deleteUserControl($user_id);

    if ($delete > 0) {
      $response['status'] = TRUE;
      $response['message'] = 'User has been successfully deleted!';
    } else {
      $response['status'] = False;
      $response['message'] = 'User was not successfully deleted!';
    }

    echo json_encode($response);
  }
}

/* End of file Usercontrol.php */
