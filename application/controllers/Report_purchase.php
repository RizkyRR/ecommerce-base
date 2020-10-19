<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_purchase extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Purchase";

    renderBackTemplate('reports/report-purchase', $info);
  }

  public function getDataPurchase()
  {
    $startdate = $this->input->post('startDate');
    $enddate = $this->input->post('endDate');

    $list = $this->report_m->dateRangeFilterPurchase($startdate, $enddate);
    $no = 1;

    if (empty($list)) {
      $data = '
          <tr>
          <td colspan="8" style="text-align: center">Data not found !</td>
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
            <td>' . $item['purchase_id'] . '</td>
            <td>' . $item['supplier_name'] . '</td>
            <td>' . $item['supplier_phone'] . '</td>
            <td>' . date('d M Y', strtotime($item['purchase_date'])) . '</td>
            <td>' . $item['jumlah'] . '</td>
            <td>' . "Rp. " . number_format($item['net_amount'], 0, ',', '.') . '</td>
            <td>' . $item['paid_status'] . '</td>
          </tr>
        ';
      }

      $cetak = 'report_purchase/print_purchase?startdate=' . $startdate . '&enddate=' . $enddate . '';

      $output = array(
        "cetak" => $cetak,
        "data" => $data
      );
    }
    echo json_encode($output);
  }

  public function print_purchase()
  {
    $info['title'] = 'Print Report Purchase';
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->report_m->dateRangeFilterPurchase($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-report-purchase', $info);
  }
}
  
  /* End of file Report_purchase.php */
