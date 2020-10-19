<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_retur_purchase extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Retur Purchase";

    renderBackTemplate('reports/report-retur-purchase', $info);
  }

  public function getDataReturPurchase()
  {
    $startdate = $this->input->post('startDate');
    $enddate = $this->input->post('endDate');

    $list = $this->report_m->dateRangeFilterReturPurchase($startdate, $enddate);
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
        <td>' . $item['retur_id'] . '</td>
        <td>' . date('d M Y', strtotime($item['retur_date'])) . '</td>
        <td>' . $item['purchase_id'] . '</td>
        <td>' . $item['supplier_name'] . '</td>
        <td>' . $item['jumlah'] . '</td>
        <td>' . "Rp. " . number_format($item['return_net_amount'], 0, ',', '.') . '</td>
        </tr>
        ';
      }

      $cetak = 'report_retur_purchase/print_retur_purchase?startdate=' . $startdate . '&enddate=' . $enddate . '';

      $output = array(
        "cetak" => $cetak,
        "data" => $data
      );
    }
    echo json_encode($output);
  }

  public function print_retur_purchase()
  {
    $info['title'] = 'Print Report Retur Purchase';
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->report_m->dateRangeFilterReturPurchase($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-report-retur-purchase', $info);
  }
}

/* End of file Report_retur_purchase.php */
