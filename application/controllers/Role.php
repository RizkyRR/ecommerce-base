<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  /* public function index()
  {
    $info['title']  = "Role";

    // SEARCHING
    if ($this->input->post('search', true)) {
      $info['keyword'] = $this->input->post('search', true);
      $this->session->set_userdata('keyword', $info['keyword']);
    } else {
      $info['keyword'] = $this->session->set_userdata('keyword');
    }
    // SEARCHING

    // DB PAGINATION FOR SEARCHING
    $this->db->like('id', $info['keyword']);
    $this->db->or_like('role', $info['keyword']);
    $this->db->from('user_role');
    // DB PAGINATION FOR SEARCHING

    $config['base_url']     = base_url() . 'role/index';
    $config['total_rows']   = $this->db->count_all_results();
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

    $info['start']   = $this->uri->segment(3);
    $info['role']    = $this->role_m->getAllRole($config['per_page'], $info['start'], $info['keyword']);

    $info['pagination'] = $this->pagination->create_links();

    renderBackTemplate('roles/index', 'modals/modal_role', $info);
  } */

  public function index()
  {
    $info['title']  = "Role";

    renderBackTemplate('roles/index', $info);
    $this->load->view('modals/modal-role');
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_role()
  {
    $list = $this->role_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $row = array();
      $id = htmlspecialchars(json_encode($item->id));
      $row[] = $no . ".";
      $row[] = $item->role;
      // add html for action

      if ($item->id != 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') {
        $deleteAction = '<a href="javascript:void(0)" onclick="delete_role(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>';
      } else {
        $deleteAction = '';
      }

      $row[] =
        '
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_role(' . $id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a> '
        . $deleteAction .
        ' <a href="' . base_url('role/accessrole/' . $item->id) . '" class="btn btn-success btn-xs" title="access control"><i class="fa fa-user-secret"></i> Access Control</a>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->role_m->count_all(),
      "recordsFiltered" => $this->role_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  // public function data_role()
  // {
  //   $data = $this->role_m->getAllRole();
  //   echo json_encode($data);
  // }

  private function _validate()
  {
    /* $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    $this->form_validation->set_rules('name', 'role name', 'trim|required|min_length[3]');

    if ($this->form_validation->run() == FALSE) {
      if ($this->input->post('name')) {
        $data['inputerror'][] = 'name';
        $data['error_string'][] = array(
          'error'   => TRUE,
          'name_error' => form_error('name')
        );
        $data['status'] = FALSE;
      }
    }

    if ($data['status'] === FALSE) {
      echo json_encode($data);
      exit();
    } */
  }

  /* public function addRole()
  {
    $info['title']     = 'Add New Role';

    $this->form_validation->set_rules('name', 'role name', 'trim|required|min_length[3]');

    $file = [
      'role' => $this->input->post('name', true)
    ];

    if ($this->form_validation->run() == false) {
      renderBackTemplate('roles/add-role', $info);
    } else {
      $this->role_m->insertRole($file);
      $this->session->set_flashdata('success', 'New role has been added !');
      redirect('role', 'refresh');
    }
  } */

  public function add_role()
  {
    $rules = [
      [
        'field' => 'name',
        'label' => 'role name',
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
        'id' => base64_encode(random_bytes(32)),
        'role' => $this->input->post('name', true)
      );
      $insert = $this->role_m->insertRole($data);
      echo json_encode('success');
    }
  }

  /* public function editrole($id)
  {
    $info['title']     = 'Edit Role';
    $info['data']    = $this->role_m->getAccessById($id);

    $this->form_validation->set_rules('name', 'role name', 'trim|required|min_length[3]');

    $data = [
      'role' => $this->input->post('name', true)
    ];

    if ($this->form_validation->run() == false) {
      renderBackTemplate('roles/edit-role', $info);
    } else {
      $get_id = $this->input->post('id', true);

      $this->role_m->updateRole($id, $data);
      $this->session->set_flashdata('success', 'Data role has been updated !');
      redirect('role', 'refresh');
    }
  } */

  public function edit_role($id)
  {
    $data = $this->role_m->getAccessById($id);
    echo json_encode($data);
  }

  public function update_role()
  {
    $rules = [
      [
        'field' => 'name',
        'label' => 'role name',
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
        'role' => $this->input->post('name', true)
      );
      $this->role_m->updateRole($this->input->post('id'), $data);
      echo json_encode('success');
    }
  }

  public function deleteRole()
  {
    $this->role_m->deleteRole($this->input->post('id'));

    $this->session->set_flashdata('success', 'Deleted !');
  }

  public function accessRole($id)
  {
    $info['title'] = 'Access Role';
    $dataRole = $this->role_m->getAccessById($id);

    if ($dataRole != null) {
      $info['role'] = $dataRole;
      $info['menu'] = $this->role_m->getAllMenu();

      renderBackTemplate('roles/access-role', $info);
    } else {
      redirect('error_404', 'refresh');
    }
  }

  public function accessUpdate()
  {
    $menu_id  = $this->input->post('menuId', true);
    $role_id  = $this->input->post('roleId', true);
    $file = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $this->role_m->updateAccessRole($file);
    $this->session->set_flashdata('success', 'Updated !');
  }
}
  
  /* End of file Role.php */
