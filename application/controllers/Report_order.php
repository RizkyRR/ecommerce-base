<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_order extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Order";

    renderBackTemplate('reports/report-order', $info);
  }

  public function getDataOrder()
  {
    $startdate = $this->input->post('startDate');
    $enddate = $this->input->post('endDate');

    $list = $this->report_m->dateRangeFilterOrder($startdate, $enddate);
    $no = 1;

    if (empty($list)) {
      $data = '
          <tr>
          <td colspan="7" style="text-align: center">Data not found !</td>
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
            <td>' . $item['id'] . '</td>
            <td>' . $item['customer_name'] . '</td>
            <td>' . date('d M Y', strtotime($item['order_date'])) . '</td>
            <td>' . $item['jumlah'] . '</td>
            <td>' . "Rp. " . number_format($item['net_amount'], 0, ',', '.') . '</td>
            <td>' . $item['paid_status'] . '</td>
          </tr>
        ';
      }

      $cetak = 'report_order/print_order?startdate=' . $startdate . '&enddate=' . $enddate . '';

      $output = array(
        "cetak" => $cetak,
        "data" => $data
      );
    }

    echo json_encode($output);
  }

  public function print_order()
  {
    $info['title'] = 'Print Report Order';
    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');

    $info['data'] = $this->report_m->dateRangeFilterOrder($info['startdate'], $info['enddate']);

    $this->load->view('reports/print-report-order', $info);
  }
}
  
  /* End of file Report_order.php */
