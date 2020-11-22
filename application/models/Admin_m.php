<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_m extends CI_Model
{
    // FOR DASHBOARDS
    public function getOrdersData()
    {
        $this->db->select('SUM(gross_amount) AS order_gross_amount, SUM(service_charge) AS order_service_charge, SUM(vat_charge) AS order_vat_charge, SUM(after_discount) AS order_after_discount, SUM(ship_amount) AS order_ship_amount');

        $this->db->where('paid_status = "LUNAS"');
        $this->db->where('YEAR(order_date) = YEAR(CURRENT_DATE())');


        $query = $this->db->get('orders');
        return $query->row_array();
    }

    public function getOrderReturnsData()
    {
        $this->db->select('SUM(net_amount) AS order_return_net_amount');

        $this->db->where('YEAR(retur_date) = YEAR(CURRENT_DATE())');

        $query = $this->db->get('order_returns');
        return $query->row_array();
    }

    public function getPurchasesData()
    {
        $this->db->select('SUM(gross_amount) AS purchase_gross_amount, SUM(after_discount) AS purchase_after_discount, SUM(ship_amount) AS purchase_ship_amount');

        $this->db->where('paid_status = "LUNAS"');
        $this->db->where('YEAR(purchase_date) = YEAR(CURRENT_DATE())');

        $query = $this->db->get('purchase');
        return $query->row_array();
    }

    public function getPurchaseReturnsData()
    {
        $this->db->select('SUM(net_amount) AS purchase_return_net_amount');

        $this->db->where('YEAR(retur_date) = YEAR(CURRENT_DATE())');

        $query = $this->db->get('purchase_returns');
        return $query->row_array();
    }

    public function getSumProductsPriceCurrentYear()
    {
        // $this->db->select("SUM(price) AS product_price");
        $this->db->select("SUM(qty * price) AS product_subtot");

        $query = $this->db->get_where('products', 'YEAR(created_at) = YEAR(CURRENT_DATE())');
        return $query->row_array();
    }

    public function getSumProductsOrderCurrentYear()
    {
        $this->db->select("SUM(gross_amount) AS order_gross_amount");

        $query = $this->db->get_where('orders', 'YEAR(order_date) = YEAR(CURRENT_DATE())');
        return $query->row_array();
    }

    public function getSalesEarningMonthly()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        // $this->db->group_by('order_date');
        $this->db->where('paid_status = "Lunas"');
        $query = $this->db->get_where('sales_orders', 'MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())');
        return $query->row_array();
    }

    public function getSalesEarningAnnual()
    {
        $this->db->select("SUM(net_amount) AS income_total");
        $this->db->where('paid_status = "Lunas"');
        $query = $this->db->get_where('sales_orders', 'YEAR(order_date) = YEAR(CURRENT_DATE())');
        // $query = $this->db->get_where('sales_orders', 'DATE_FORMAT(NOW(),"%Y-%m-01") AND LAST_DAY(NOW())');
        return $query->row_array();
    }

    // for customers
    public function getTotalCustomer()
    {
        $this->db->select('COUNT(*)');
        $this->db->from('customers');
        return $this->db->count_all_results();
    }

    public function getUserCount()
    {
        $this->db->select('COUNT(*)');
        $this->db->from('users');
        return $this->db->count_all_results();
    }

    public function getUserOnline()
    {
        $this->db->select('COUNT(online)');
        $this->db->from('users');
        $this->db->where('online = 1');
        return $this->db->count_all_results();
    }

    public function getProductCount()
    {
        $this->db->select('COUNT(*)');
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function getProductCountInStock($setLimit)
    {
        $this->db->select('COUNT(*)');
        $this->db->from('products');

        if ($setLimit != null) {
            $this->db->where('qty >=', $setLimit);
        } else {
            $this->db->where('qty >= 1');
        }

        return $this->db->count_all_results();
    }

    public function getProductCountSold()
    {
        $this->db->select('SUM(qty) AS qty_sold');

        $query = $this->db->get('customer_purchase_order_details');
        return $query->row_array();
    }

    public function getProductCountReturn()
    {
        $this->db->select('SUM(qty) AS qty_return');

        $query = $this->db->get('customer_purchase_return_details');
        return $query->row_array();
    }

    public function getNewOrderIn()
    {
        return $this->db
            ->where('status_order_id', 2)
            ->count_all_results('customer_purchase_orders');
    }

    public function getNetSalesMonthly()
    {
        $this->db->select("SUM(customer_purchase_orders.net_amount) AS net_amount_sum_order, SUM(customer_purchase_orders.coupon_charge) AS coupon_charge_sum_order");

        $this->db->from('customer_purchase_orders');

        $this->db->where('customer_purchase_orders.status_order_id = 4');
        $this->db->where('MONTH(customer_purchase_orders.created_date) = MONTH(CURRENT_DATE()) AND YEAR(customer_purchase_orders.created_date) = YEAR(CURRENT_DATE())');


        $query = $this->db->get();
        return $query->row_array();
    }

    public function getNetSalesAnnual()
    {
        $this->db->select("SUM(customer_purchase_orders.net_amount) AS net_amount_sum_order, SUM(customer_purchase_orders.coupon_charge) AS coupon_charge_sum_order");

        $this->db->from('customer_purchase_orders');

        $this->db->where('customer_purchase_orders.status_order_id = 4');
        $this->db->where('YEAR(customer_purchase_orders.created_date) = YEAR(CURRENT_DATE())');


        $query = $this->db->get();
        return $query->row_array();
    }

    public function getNetReturnMonthly()
    {
        $this->db->select("SUM(customer_purchase_returns.net_amount) AS net_amount_sum_return");

        $this->db->from('customer_purchase_returns');

        $this->db->where('customer_purchase_returns.status_order_id = 7');
        $this->db->where('MONTH(customer_purchase_returns.created_date) = MONTH(CURRENT_DATE()) AND YEAR(customer_purchase_returns.created_date) = YEAR(CURRENT_DATE())');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function getNetReturnAnnual()
    {
        $this->db->select("SUM(customer_purchase_returns.net_amount) AS net_amount_sum_return");

        $this->db->from('customer_purchase_returns');

        $this->db->where('customer_purchase_returns.status_order_id = 7');
        $this->db->where('YEAR(customer_purchase_returns.created_date) = YEAR(CURRENT_DATE())');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function getCountTransactionMonthly()
    {
        return $this->db
            ->where_not_in('status_order_id', 1)
            ->where('MONTH(customer_purchase_orders.created_date) = MONTH(CURRENT_DATE()) AND YEAR(customer_purchase_orders.created_date) = YEAR(CURRENT_DATE())')
            ->count_all_results('customer_purchase_orders');
    }

    public function getCountTransactionAnnual()
    {
        return $this->db
            ->where_not_in('status_order_id', 1)
            ->where('YEAR(customer_purchase_orders.created_date) = YEAR(CURRENT_DATE())')
            ->count_all_results('customer_purchase_orders');
    }

    public function getCountReturnMonthly()
    {
        return $this->db
            ->where_not_in('status_order_id', 1)
            ->where('MONTH(customer_purchase_returns.created_date) = MONTH(CURRENT_DATE()) AND YEAR(customer_purchase_returns.created_date) = YEAR(CURRENT_DATE())')
            ->count_all_results('customer_purchase_returns');
    }

    public function getCountReturnAnnual()
    {
        return $this->db
            ->where_not_in('status_order_id', 1)
            ->where('YEAR(customer_purchase_returns.created_date) = YEAR(CURRENT_DATE())')
            ->count_all_results('customer_purchase_returns');
    }
    // END OF DASHBOARDS

    // FOR CALENDAR EVENTS
    public function getEvents($start, $end)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('start_date >=', $start);
        $this->db->where('end_date <=', $end);

        $this->db->order_by('start_date', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insertEvent($data)
    {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }

    public function updateEvent($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('events', $data);

        return $this->db->affected_rows();
    }

    public function dragUpdateEvent($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('events', $data);

        return $this->db->affected_rows();
    }

    public function deleteEvent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('events');
    }
    // END OF CALENDAR EVENTS
}

  /* End of file Admin_m.php */
