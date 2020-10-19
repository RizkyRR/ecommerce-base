<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_piutang extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Piutang";

    renderBackTemplate('reports/report-piutang', $info);
  }

  public function getDataPiutang()
  {
    $startdate = $this->input->post('startDate');
    $enddate = $this->input->post('endDate');

    $list = $this->report_m->dateRangeFilterPiutang($startdate, $enddate);
    $no = 1;

    if (empty($list)) {
      $data = '
          <tr>
          <td colspan="6" style="text-align: center">Data not found !</td>
          </tr>
        ';

      $output = array(
        "data" => $data
      );
    } else {
      foreach ($list as $item) {
        $data[] = '
          <tr>
            <td>' . $no++ . '.' . '</td>
            <td>' . $item['piutang_id'] . '</td>
            <td>' . $item['order_id'] . '</td>
            <td>' . date('d M Y', strtotime($item['lastupdate'])) . '</td>
            <td>' . "Rp. " . number_format($item['total'], 0, ',', '.') . '</td>
            <td>' . "Rp. " . number_format($item['remaining'], 0, ',', '.') . '</td>
          </tr>
        ';
      }

      $cetak = 'report_piutang/print_piutang?startdate=' . $startdate . '&enddate=' . $enddate . '';

      $output = array(
        "cetak" => $cetak,
        "data" => $data
      );
    }
    echo json_encode($output);
  }

  public function print_piutang()
  {
    $info['title'] = 'Print Report Piutang';
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->report_m->dateRangeFilterPiutang($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-report-piutang', $info);
  }
}
  
  /* End of file Report_piutang.php */
