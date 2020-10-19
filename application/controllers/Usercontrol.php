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
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_user(' . $item->user_id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a>
        <a href="javascript:void(0)" onclick="delete_user(' . $item->user_id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
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

  public function data_role()
  {
    $data = $this->usercontrol_m->_getAllRole();
    echo json_encode($data);
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

  public function edit_user($id)
  {
    $data = $this->usercontrol_m->getUserControlById($id);
    echo json_encode($data);
  }

  public function update_user()
  {
    $rules = [
      [
        'field' => 'role',
        'label' => 'role',
        'rules' => 'trim|required'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'role' => form_error('role')
      ];

      echo json_encode($data);
    } else {
      $status = 0; // set default if 0 status = unchecked

      if ($this->input->post('status') != null) {
        $status = 1; // if condition not null it means checked
      }

      $data = [
        'role_id' => $this->input->post('role', true),
        'is_active' => $status
      ];

      $this->usercontrol_m->updateUserControl($this->input->post('id'), $data);
      echo json_encode('success');
    }
  }

  public function deleteUserControl()
  {
    $this->usercontrol_m->deleteUserControl($this->input->post('id'));
    $this->session->set_flashdata('success', 'User has been deleted !');
  }
}

/* End of file Usercontrol.php */
