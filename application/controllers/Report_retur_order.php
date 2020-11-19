<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_retur_order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $info['title'] = "Report Retur Order";

    renderBackTemplate('reports/report-retur-order', $info);
  }

  public function showAjaxReportOrderReturn()
  {
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');

    $start_date = $start_date . ' 00:00:00';
    $end_date = $end_date . ' 23:59:59';

    $list = $this->report_m->get_datatables_order_return($start_date, $end_date);

    $data = array();
    $no = @$_POST['start'];

    foreach ($list as $item) {
      $no++;
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->invoice_return;
      $row[] = $item->invoice_order;
      $row[] = $item->customer_email;
      $row[] = $item->customer_name;
      $row[] = date('d M Y H:i:s', strtotime($item->purchase_return_date));
      $row[] = $item->total_product;
      $row[] = "Rp " . number_format($item->net_amount, 0, ',', '.');
      $row[] = $item->status_name;

      $data[] = $row;
    }

    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->report_m->count_all_order_return($start_date, $end_date),
      "recordsFiltered" => $this->report_m->count_filtered_order_return($start_date, $end_date),
      "data" => $data,
    );

    // OUTPUT TO JSON FORMAT
    echo json_encode($output);
  }

  public function getOrderReturnDatePrint()
  {
    $start_date = $this->input->post('startDate');
    $end_date = $this->input->post('endDate');
    $search = $this->input->post('search');

    $start_date = $start_date . ' 00:00:00';
    $end_date = $end_date . ' 23:59:59';

    $response = array();

    $data = $this->report_m->dateRangeFilterOrderReturn($start_date, $end_date, $search);

    if ($data != null) {
      $response['url'] = base_url() . 'report_retur_order/print_retur_order?startdate=' . $start_date . '&enddate=' . $end_date . '&search=' . $search;
    } else {
      $response['url'] = '';
    }

    echo json_encode($response);
  }

  public function print_retur_order()
  {
    $info['title'] = 'Print Report Retur Order';

    $info['user'] = $this->auth_m->getUserSession();
    $info['company'] = $this->company_m->getCompanyById(1);
    $info['company_address'] = $this->company_m->getFullAdressCustomer(1);

    $info['startdate'] = $this->input->get('startdate');
    $info['enddate'] = $this->input->get('enddate');
    $info['search'] = $this->input->get('search');

    $info['data'] = $this->report_m->dateRangeFilterOrderReturn($info['startdate'], $info['enddate'], $info['search']);

    $this->load->view('reports/print-report-retur-order', $info);
  }
}

/* End of file Report_retur_order.php */
