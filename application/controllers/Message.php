<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Message extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();

    $this->load->library('pdfgenerator');
  }

  public function index()
  {
    $info['title'] = "Data Message Pay Report";

    $company = $this->company_m->getCompanyById(1);
    $info['company_data'] = $company;

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $this->load->view('back-templates/header', $info);
    $this->load->view('back-templates/topbar', $info);
    $this->load->view('back-templates/navbar', $info);
    $this->load->view('messages/index', $info);
    $this->load->view('messages/modal-detail-message');
    $this->load->view('back-templates/footer', $info);
  }

  // DataTables Controller Setup
  function show_ajax_message()
  {
    $list = $this->message_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->id_message));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_order;
      $row[] = $item->customer_email;
      $row[] = $item->customer_name;

      if (strlen($item->message) >= 50) {
        $message = substr($item->message, 0, 50) . '...';
      } else {
        $message = $item->message;
      }

      $row[] = $message;

      if ($item->read_status == "READ") {
        $read_status = '<span class="label label-success">' . $item->read_status . '</span>';
      } else {
        $read_status = '<span class="label label-danger">' . $item->read_status . '</span>';
      }

      $row[] = $read_status;
      $row[] = date('d M Y H:i:s', strtotime($item->message_datetime));

      // CHECK FOR ATTACH FILE TO SHOW BUTTON DOWNLOAD
      $checkDataImage = $this->db->get_where('customer_messages', ['id' => $item->id_message]);
      $getResultCheckImage = $checkDataImage->row_array();

      if ($getResultCheckImage['image'] != null) {
        $buttonDownload = '<a href="' . base_url() . 'message/downloadFile/' . $item->id_message . '" class="btn btn-success btn-xs" id="btnDownloadFile_' . $item->id_message . '" title="download file"><i class="fa fa-download" aria-hidden="true"></i> Download</a> ';
      } else {
        $buttonDownload = '';
      }

      // ADD HTML BUTTON ACTION
      $row[] = '<input type="hidden" name="email_customer" id="email_customer_' . $item->id_message . '" value="' . $item->customer_email . '" readonly><a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="detail_message(' . $id . ')" id="btnDetailMessage_' . $item->id_message . '" title="detail message"><i class="fa fa-info" aria-hidden="true"></i> Info</a> '
        . $buttonDownload;

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->message_m->count_all(),
      "recordsFiltered" => $this->message_m->count_filtered(),
      "data" => $data,
    );

    // OUTPUT TO JSON FORMAT
    echo json_encode($output);
  }
  // DataTables Cntroller End Setup

  public function getDetailMessagePayReport()
  {
    $message_id = $this->input->post('message_id');

    $data = [
      'read_status' => 'READ'
    ];

    $this->message_m->updateStatusReadMessage($message_id, $data);

    $dataMessageDetail = $this->message_m->getDetailMessagePayReportByID($message_id);
    echo json_encode($dataMessageDetail);
  }

  public function downloadFile($message_id)
  {
    $checkDataImage = $this->db->get_where('customer_messages', ['id' => $message_id]);
    $getResultCheckImage = $checkDataImage->row_array();

    $this->load->helper('download');

    if ($getResultCheckImage['image'] != null) {
      $name = $getResultCheckImage['image'];
      $data = file_get_contents(base_url() . 'image/pay_report/' . $getResultCheckImage['image']);
      force_download($name, $data);
    } else {
      return false;
    }
  }

  public function getCountIncomingUnreadMessage()
  {
    // return number data message
    $dataMessage = $this->message_m->getCountIncomingUnreadMessage();

    echo json_encode($dataMessage);
  }

  public function getCountIncomingUnreadReview()
  {
    // return number data review 
    $dataReview = $this->message_m->getCountIncomingUnreadReview();

    echo json_encode($dataReview);
  }
}
  
  /* End of file Message.php */
