<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_m extends CI_Model
{

  public function dateRangeFilterHutang($start, $end)
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(hutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('purchase');
    $this->db->join('purchase_hutang', 'purchase_hutang.purchase_id = purchase.id');
    $this->db->where('hutang_paid_history >=', $start);
    $this->db->where('hutang_paid_history <=', $end);
    $this->db->group_by('purchase_id');

    $this->db->order_by('hutang_paid_history', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function dateRangeFilterOrder($start, $end)
  {
    $this->db->select('*, COUNT(order_id) as jumlah');
    $this->db->from('orders');
    $this->db->join('order_details', 'order_details.order_id = orders.id');
    $this->db->where('order_date >=', $start);
    $this->db->where('order_date <=', $end);
    $this->db->where('paid_status = "Lunas"');

    $this->db->group_by('order_id');

    $this->db->order_by('order_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function dateRangeFilterPiutang($start, $end)
  {
    $this->db->select('*, SUM(amount_paid) as total, MAX(piutang_paid_history) as lastupdate, MIN(remaining_paid) as remaining');
    $this->db->from('orders');
    $this->db->join('order_piutang', 'order_piutang.order_id = orders.id');
    $this->db->where('piutang_paid_history >=', $start);
    $this->db->where('piutang_paid_history <=', $end);
    $this->db->group_by('order_id');

    $this->db->order_by('piutang_paid_history', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function dateRangeFilterPurchase($start, $end)
  {
    $this->db->select('*, COUNT(purchase_id) AS jumlah');
    $this->db->from('purchase');
    $this->db->join('purchase_details', 'purchase_details.purchase_id = purchase.id');
    $this->db->join('suppliers', 'suppliers.id = purchase.supplier_id');
    $this->db->where('purchase_date >=', $start);
    $this->db->where('purchase_date <=', $end);

    $this->db->where('paid_status = "Lunas"');
    $this->db->group_by('purchase_id');

    $this->db->order_by('purchase_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function dateRangeFilterReturOrder($start, $end)
  {
    $this->db->select('*, COUNT(retur_id) AS jumlah');
    $this->db->from('order_returns');
    $this->db->join('order_return_details', 'order_return_details.retur_id = order_returns.id');
    $this->db->join('orders', 'orders.id = order_returns.order_id');

    $this->db->where('retur_date >=', $start);
    $this->db->where('retur_date <=', $end);

    $this->db->group_by('retur_id');

    $this->db->order_by('retur_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function dateRangeFilterReturPurchase($start, $end)
  {
    $this->db->select('*, COUNT(retur_id) AS jumlah, purchase_returns.net_amount AS return_net_amount');
    /*$this->db->from('purchase_returns');
    $this->db->join('purchase_return_details', 'purchase_return_details.retur_id = purchase_returns.id');
    $this->db->join('orders', 'orders.id = purchase_returns.order_id');*/
    $this->db->from('purchase');
    $this->db->join('suppliers', 'suppliers.id = purchase.supplier_id');
    $this->db->join('purchase_returns', 'purchase_returns.purchase_id = purchase.id');
    $this->db->join('purchase_return_details', 'purchase_return_details.retur_id = purchase_returns.id');

    $this->db->where('retur_date >=', $start);
    $this->db->where('retur_date <=', $end);

    $this->db->group_by('retur_id');

    $this->db->order_by('retur_date', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
  }
}

/* End of file Report_m.php */
