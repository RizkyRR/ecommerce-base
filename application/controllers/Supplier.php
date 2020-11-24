<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Supplier";

    renderBackTemplate('suppliers/index', $info);
    $this->load->view('modals/modal-supplier', $info);
    $this->load->view('modals/modal-delete');
  }

  // DataTables Controller Setup

  function show_ajax_supplier()
  {
    $list = $this->supplier_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->supplier_name;
      $row[] = $item->supplier_phone;

      if (strlen($item->supplier_address) >= 50) {
        $address = substr($item->supplier_address, 0, 50) . '...';
      } else {
        $address = $item->supplier_address;
      }

      $row[] = $address;
      $row[] = $item->credit_card_type;
      $row[] = $item->credit_card_number;
      // add html for action
      $row[] =
        '
        <a href="javascript:void(0)" class="btn btn-warning btn-xs" onclick="edit_supplier(' . $id . ')" title="edit data"><i class="fa fa-pencil"></i> Update</a>
        <a href="javascript:void(0)" onclick="delete_supplier(' . $id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->supplier_m->count_all(),
      "recordsFiltered" => $this->supplier_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  // public function data_supplier()
  // {
  //   $data = $this->supplier_m->getSupplier();
  //   echo json_encode($data);
  // }

  public function create_code()
  {
    $this->db->select('RIGHT(suppliers.id,4) as kode', FALSE);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);

    $query = $this->db->get('suppliers');      //cek dulu apakah ada sudah ada kode di tabel.    

    if ($query->num_rows() <> 0) {
      //jika kode ternyata sudah ada.      
      $data = $query->row();
      $kode = intval($data->kode) + 1;
    } else {
      //jika kode belum ada      
      $kode = 1;
    }

    $max_code = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $generate = "SPL" . $max_code;

    // return $generate;
    echo json_encode($generate);
  }

  public function add_supplier()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'name',
        'label' => 'supplier name',
        'rules' => 'trim|required|min_length[3]'
      ],
      [
        'field' => 'phone',
        'label' => 'supplier phone',
        'rules' => 'trim|required|min_length[10]|max_length[12]|numeric'
      ],
      [
        'field' => 'address',
        'label' => 'supplier address',
        'rules' => 'trim|required|min_length[10]'
      ],
      [
        'field' => 'cc_type',
        'label' => 'credit card type',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'cc_number',
        'label' => 'credit card number',
        'rules' => 'trim|required'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name'),
        'phone' => form_error('phone'),
        'address' => form_error('address'),
        'cc_type' => form_error('cc_type'),
        'cc_number' => form_error('cc_number')
      ];

      echo json_encode($data);
    } else {
      $data = array(
        'id' => $this->input->post('id'),
        'supplier_name' => $this->input->post('name', true),
        'supplier_phone' => $this->input->post('phone', true),
        'supplier_address' => $this->input->post('address', true),
        'credit_card_type' => $this->input->post('cc_type', true),
        'credit_card_number' => $this->input->post('cc_number', true),
        'created_at' => date('Y-m-d H:i:s')
      );
      $this->supplier_m->insert($data);
      echo json_encode('success');
    }
  }

  public function edit_supplier($id)
  {
    // $id = $this->input->post('id');
    $data = $this->supplier_m->getSupplierById($id);
    echo json_encode($data);
  }

  public function update_supplier()
  {
    date_default_timezone_set('Asia/Jakarta');

    $rules = [
      [
        'field' => 'name',
        'label' => 'supplier name',
        'rules' => 'trim|required|min_length[3]'
      ],
      [
        'field' => 'phone',
        'label' => 'supplier phone',
        'rules' => 'trim|required|min_length[10]|max_length[12]|numeric'
      ],
      [
        'field' => 'address',
        'label' => 'supplier address',
        'rules' => 'trim|required|min_length[10]'
      ],
      [
        'field' => 'cc_type',
        'label' => 'credit card type',
        'rules' => 'trim|required'
      ],
      [
        'field' => 'cc_number',
        'label' => 'credit card number',
        'rules' => 'trim|required'
      ]
    ];
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message('required', '{field} tidak boleh kosong');

    if ($this->form_validation->run() == FALSE) {
      $data = [
        'name' => form_error('name'),
        'phone' => form_error('phone'),
        'address' => form_error('address'),
        'cc_type' => form_error('cc_type'),
        'cc_number' => form_error('cc_number')
      ];

      echo json_encode($data);
    } else {
      $data = array(
        'supplier_name' => $this->input->post('name', true),
        'supplier_phone' => $this->input->post('phone', true),
        'supplier_address' => $this->input->post('address', true),
        'credit_card_type' => $this->input->post('cc_type', true),
        'credit_card_number' => $this->input->post('cc_number', true),
        'updated_at' => date('Y-m-d H:i:s')
      );
      $this->supplier_m->update($this->input->post('id'), $data);
      echo json_encode('success');
    }
  }

  public function delete_supplier()
  {
    $this->supplier_m->delete($this->input->post('id'));

    $this->session->set_flashdata('success', 'Deleted !');
  }
}
  
  /* End of file Supplier.php */
