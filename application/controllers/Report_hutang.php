<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_hutang extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Hutang";

    renderBackTemplate('reports/report-hutang', $info);
  }

  public function getDataHutang()
  {
    $startdate = $this->input->post('startDate');
    $enddate = $this->input->post('endDate');

    $list = $this->report_m->dateRangeFilterHutang($startdate, $enddate);
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
            <td>' . $item['hutang_id'] . '</td>
            <td>' . $item['purchase_id'] . '</td>
            <td>' . date('d M Y', strtotime($item['lastupdate'])) . '</td>
            <td>' . "Rp. " . number_format($item['total'], 0, ',', '.') . '</td>
            <td>' . "Rp. " . number_format($item['remaining'], 0, ',', '.') . '</td>
          </tr>
        ';
      }

      $cetak = 'report_hutang/print_hutang?startdate=' . $startdate . '&enddate=' . $enddate . '';

      $output = array(
        "cetak" => $cetak,
        "data" => $data
      );
    }
    echo json_encode($output);
  }

  public function print_hutang()
  {
    $info['title'] = 'Print Report Hutang';
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->report_m->dateRangeFilterHutang($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-report-hutang', $info);
  }
}
  
  /* End of file Report_hutang.php */
