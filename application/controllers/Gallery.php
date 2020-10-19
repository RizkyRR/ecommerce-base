<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gallery extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Data Gallery";

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $this->load->view('back-templates/header', $info);
    $this->load->view('back-templates/topbar', $info);
    $this->load->view('back-templates/navbar', $info);
    $this->load->view('modals/modal-upload-gallery', $info);
    $this->load->view('modals/modal-detail-gallery', $info);
    $this->load->view('modals/modal-delete', $info);
    $this->load->view('gallery/index', $info);
    $this->load->view('back-templates/footer', $info);
  }

  private function formatSizeUnits($bytes)
  {
    if ($bytes >= 1073741824) {
      $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
      $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
      $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
      $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
      $bytes = $bytes . ' byte';
    } else {
      $bytes = '0 bytes';
    }

    return $bytes;
  }

  // DataTables Controller Setup
  function show_ajax_gallery()
  {
    $list = $this->gallery_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->image;
      $row[] = $this->formatSizeUnits($item->info);
      // add html for action
      $row[] =
        '<a href="javascript:void(0)" onclick="delete_image(' . $item->id . ')" class="btn btn-danger btn-xs" title="delete data"><i class="fa fa-trash-o"></i> Delete</a>

        <a href="javascript:void(0)" onclick="detail_image(' . $item->id . ')" class="btn btn-info btn-xs" title="detail data"><i class="fa fa-search"></i> Detail</a>';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->gallery_m->count_all(),
      "recordsFiltered" => $this->gallery_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

  public function image_data()
  {
    $data = $this->gallery_m->getAllImage();
    echo json_encode($data);
  }

  public function detailImage($id)
  {
    $data = $this->gallery_m->getImageByID($id);
    echo json_encode($data);
  }

  public function insertImages()
  {
    $config['upload_path']   = FCPATH . 'image/gallery/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['overwrite'] = TRUE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
      $token = $this->input->post('token_foto');
      $nama = $this->upload->data('file_name');

      // $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
      // $width = $fileinfo[0];
      // $height = $fileinfo[1];

      $fileinfo = $_FILES['image']['size'];

      $data = [
        'image' => $nama,
        'info' => $fileinfo,
        'token' => $token
      ];
      $this->gallery_m->insertImages($data);
    }
  }

  public function removeImage()
  {
    //Ambil token foto
    $token = $this->input->post('token');


    $foto = $this->db->get_where('gallery', array('token' => $token));


    if ($foto->num_rows() > 0) {
      $hasil = $foto->row();
      $nama_foto = $hasil->image;
      if (file_exists($file = FCPATH . 'image/gallery/' . $nama_foto)) {
        unlink($file);
      }
      $this->db->delete('gallery', array('token' => $token));
    }

    echo "{}";
  }

  public function deleteImage()
  {
    $id = $this->input->post('id');

    $rows = $this->db->get_where('gallery', array('id' => $id));
    $result = $rows->result();
    foreach ($result as $row) {
      unlink(FCPATH . 'image/gallery/' . $row->image);
    }

    $this->gallery_m->delete($id);
    redirect('gallery', 'refresh');
  }
}
  
  /* End of file Gallery.php */
