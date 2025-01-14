<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    var $netPurchase;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(['template', 'authaccess', 'sidebar']);
        checkSessionLog();
    }

    public function index()
    {
        $info['title']  = "Dashboard";

        // GET EARNINGS MONTHLY https://stackoverflow.com/questions/16717274/calculate-monthly-totals-using-php
        // All about customer
        $info['totalCustomer'] = $this->admin_m->getTotalCustomer();

        // All about product 
        $getLimit = $this->company_m->getAlertValue(1);
        $setLimit = $getLimit['minimum_stock_value'];
        $info['totalProductCountInStock'] = $this->admin_m->getProductCountInStock($setLimit);

        $theNumberOfItemSold = $this->admin_m->getProductCountSold();
        $info['theNumberOfItemSold'] = $theNumberOfItemSold['qty_sold'];

        $theNumberOfItemReturn = $this->admin_m->getProductCountReturn();
        $info['theNumberOfItemReturn'] = $theNumberOfItemReturn['qty_return'];

        $info['newOrderIn'] = $this->admin_m->getNewOrderIn();

        // By Monthly
        $netSalesMonthly = $this->admin_m->getNetSalesMonthly();
        $netReturnMonthly = $this->admin_m->getNetReturnMonthly();
        $getGrossSalesMonthly = $netSalesMonthly['net_amount_sum_order'];
        $getDiscountSalesMonthly = $netSalesMonthly['coupon_charge_sum_order'];
        $info['netSalesMonthly'] = $getGrossSalesMonthly - $getDiscountSalesMonthly - $netReturnMonthly['net_amount_sum_return'];

        // By Annual
        $netSalesAnnual = $this->admin_m->getNetSalesAnnual();
        $netReturnAnnual = $this->admin_m->getNetReturnAnnual();
        $getGrossSalesAnnual = $netSalesAnnual['net_amount_sum_order'];
        $getDiscountSalesAnnual = $netSalesAnnual['coupon_charge_sum_order'];
        $info['netSalesAnnual'] = $getGrossSalesAnnual - $getDiscountSalesAnnual - $netReturnAnnual['net_amount_sum_return'];

        // Hasil penjualan perbulan
        $info['resultSalesMonthly'] = $netSalesMonthly['net_amount_sum_order'];

        // Hasil penjualan pertahun
        $info['resultSalesAnnual'] = $netSalesAnnual['net_amount_sum_order'];

        // Count transaction monthly
        $info['countTransactionMonthly'] = $this->admin_m->getCountTransactionMonthly();

        // Count transaction annual
        $info['countTransactionAnnual'] = $this->admin_m->getCountTransactionAnnual();

        // Count return monthly
        $info['countReturnMonthly'] = $this->admin_m->getCountReturnMonthly();

        // Count return annual
        $info['countReturnAnnual'] = $this->admin_m->getCountReturnAnnual();

        renderBackTemplate('admins/index', $info);
        $this->load->view('modals/modal-event');
    }

    public function getNetSalesCharts()
    {
        $list = array();
        $dataSales = $this->admin_m->getNetSalesMonthlyCharts();

        $month = '';
        $getNetSales = 0;

        foreach ($dataSales as $val_s) {
            $data = array();
            $getSales = $val_s['net_amount_sum_order'];
            $getDiscount = $val_s['coupon_charge_sum_order'];

            $getSalesCount = $getSales - $getDiscount;
            $month = date('Y-m', strtotime($val_s['order_date']));

            $dataReturn = $this->admin_m->getNetReturnMonthlyCharts($month);

            $getReturn = $dataReturn['net_amount_sum_return'];
            $getNetSales = $getSalesCount - $getReturn;

            $data['getNetSales'] = $getNetSales;
            $data['month'] = $month;

            $list[] = $data;
        }

        echo json_encode($list);
    }

    public function getTransactionSuccessCharts()
    {
        $list = array();
        $dataTransaction = $this->admin_m->getCountTransactionSuccessMonthlyCharts();

        $month = '';
        $getCountTransaction = 0;

        foreach ($dataTransaction as $val) {
            $data = array();
            $getCountTransaction = $val['count_transaction'];

            $month = date('Y-m', strtotime($val['created_date']));

            $data['getCountTransaction'] = $getCountTransaction;
            $data['month'] = $month;

            $list[] = $data;
        }

        echo json_encode($list);
    }

    /* public function getNetSalesCharts()
    {
        $list = array();
        $dataSales = $this->admin_m->_getNetSalesMonthlyCharts();

        echo json_encode($dataSales);
    } */

    public function getEvents()
    {
        // Get start date and end date
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $startDate = new DateTime('now'); // setup local DateTime
        $startDate->setTimestamp($start); // Set the date based on timestamp
        $start_format = $startDate->format('Y-m-d H:i:s');

        $endDate = new DateTime('now'); // setup local DateTime
        $endDate->setTimestamp($end); // Set the date based on timestamp
        $end_format = $endDate->format('Y-m-d H:i:s');

        $events = $this->admin_m->getEvents($start_format, $end_format);

        $data_events = array();

        foreach ($events as $val) {
            $data_events[] = array(
                "id" => $val['id'],
                "title" => $val['title'],
                "description" => $val['description'],
                "end" => $val['end_date'],
                "start" => $val['start_date'],
                "color" => $val['color']
            );
        }

        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function saveEvent()
    {
        $response = array();

        $this->form_validation->set_rules('title', 'Title can not be empty', 'trim|required');

        if ($this->form_validation->run() == true) {
            $data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'color' => $this->input->post('color'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
            ];

            $insert = $this->admin_m->insertEvent($data);

            if ($insert > 0) {
                $response['status'] = true;
                $response['notif'] = 'New event has been added to the calendar!';
                $response['id'] = $insert;
            } else {
                $response['status'] = false;
                $response['notif'] = 'There is something wrong, please save again!';
            }
        } else {
            $response['status'] = false;
            $response['notif'] = validation_errors();
        }

        echo json_encode($response);
    }

    public function dragUpdateEvent()
    {
        $id = $this->input->post('id');
        $response = array();

        $eventDate = [
            'title' => $this->input->post('title'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date')
        ];

        $update = $this->admin_m->dragUpdateEvent($id, $eventDate);

        if ($update > 0) {
            $response['status'] = true;
            $response['notif'] = 'Event has been successfully updated!';
            $response['id'] = $id;
        } else {
            $response['status'] = false;
            $response['notif'] = 'There is something wrong, please try again!';
        }

        echo json_encode($response);
    }

    public function updateEvent()
    {
        $response = array();

        $this->form_validation->set_rules('title', 'Title can not be empty', 'trim|required');

        if ($this->form_validation->run() == true) {
            $data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'color' => $this->input->post('color'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
            ];

            $calenderID = $this->input->post('id');

            $update = $this->admin_m->updateEvent($calenderID, $data);

            if ($update > 0) {
                $response['status'] = true;
                $response['notif'] = 'Event has been successfully updated!';
            } else {
                $response['status'] = false;
                $response['notif'] = 'There is something wrong, please update again!';
            }
        } else {
            $response['status'] = false;
            $response['notif'] = validation_errors();
        }

        echo json_encode($response);
    }

    public function deleteEvent()
    {
        // $response = array();
        $id = $this->input->post('id');

        $data = $this->admin_m->deleteEvent($id);

        echo json_encode($data);
    }
}

/* End of file Admin.php */
