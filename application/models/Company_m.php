<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company_m extends CI_Model
{

  public function getCompanyById($id)
  {
    return $this->db->get_where('company_profile', ['id' => $id])->row_array();
  }

  public function getCompanyDetailById($id)
  {
    return $this->db->get_where('company_profile_detail', ['company_profile_id' => $id])->result_array();
  }

  public function getLinkCompany()
  {
    $this->db->select('*, links.id AS id_link, company_profile_detail.id AS id_profile_detail');
    $this->db->from('links');
    $this->db->join('company_profile_detail', 'company_profile_detail.link_id = links.id');

    $this->db->order_by('links.id', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }

  // public function getAllCompanyById($id)
  // {
  //   $this->db->select('*');
  //   $this->db->from('company_profile');
  //   $this->db->join('company_profile_detail', 'company_profile_detail.company_profile_id = company_profile.id');
  //   // $this->db->join('blog_image', 'blog_image.company_profile_id = company_profile.id');
  //   $this->db->where('company_profile.id', $id);

  //   $query = $this->db->get();

  //   if ($query->num_rows() != 0) {
  //     return $query->row_array();
  //   } else {
  //     return false;
  //   }
  // }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('company_profile', $data);

    return $this->db->affected_rows();
  }

  // ADDRESS 
  public function existsDataAddress()
  {
    $query = $this->db->get('company_profile_address');
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getFullAdressCustomer($id)
  {
    $this->db->select('*, company_profile.id AS id_profile, company_profile_address.id AS id_address');

    $this->db->from('company_profile_address');
    $this->db->join('company_profile', 'company_profile.id = company_profile_address.company_profile_id', 'left');

    $this->db->where('company_profile_address.company_profile_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function updateDataCompanyAddress($id, $data)
  {
    $this->db->where('company_profile_id', $id);
    $this->db->update('company_profile_address', $data);

    return $this->db->affected_rows();
  }

  // SOCIAL MEDIA
  public function getCompanySocialMedia($id)
  {
    $this->db->select('*, company_profile.id AS id_profile, links.id AS id_link, company_profile_detail.id AS id_profile_detail');

    $this->db->from('company_profile_detail');
    $this->db->join('company_profile', 'company_profile.id = company_profile_detail.company_profile_id', 'left');
    $this->db->join('links', 'links.id = company_profile_detail.link_id', 'left');

    $this->db->where('company_profile_detail.company_profile_id', $id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertCompanyDetail($data)
  {
    $this->db->insert('company_profile_detail', $data);

    return $this->db->insert_id();
  }

  public function getSocialLink()
  {
    $query = $this->db->get('links');
    return $query->result_array();
  }

  // SET CHARGE VALUE 
  public function getChargeValue($id)
  {
    $this->db->select('*, company_profile.id AS id_profile, company_profile_charge_value.id AS id_charge_value');

    $this->db->from('company_profile_charge_value');
    $this->db->join('company_profile', 'company_profile.id = company_profile_charge_value.company_profile_id', 'left');

    $this->db->where('company_profile_charge_value.company_profile_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function insertChargeValue($data)
  {
    $this->db->insert('company_profile_charge_value', $data);

    return $this->db->insert_id();
  }

  public function updateChargeValue($id, $data)
  {
    $this->db->where('company_profile_id', $id);
    $this->db->update('company_profile_charge_value', $data);

    return $this->db->affected_rows();
  }

  // BANK ACCOUNT 
  public function getCompanyBankAccount($id)
  {
    $this->db->where('company_profile_id', $id);
    $query = $this->db->get('company_profile_banks');

    return $query->result_array();
  }

  public function insertCompanyBankAccount($data)
  {
    $this->db->insert('company_profile_banks', $data);

    return $this->db->insert_id();
  }

  // SET EMAIL
  public function getEmail($id)
  {
    $this->db->select('*');

    $this->db->from('company_profile_email');

    $this->db->where('company_profile_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function insertSetEmail($data)
  {
    $this->db->insert('company_profile_email', $data);

    return $this->db->insert_id();
  }

  public function updateSetEmail($id, $data)
  {
    $this->db->where('company_profile_id', $id);
    $this->db->update('company_profile_email', $data);

    return $this->db->affected_rows();
  }

  // DASHBOARD
  public function getAllDash()
  {
    $query = $this->db->get('dashboards');
    return $query->result_array();
  }

  public function getFontawesome()
  {
    $query = $this->db->get('fontawesomes');
    return $query->result_array();
  }

  public function getColor()
  {
    $query = $this->db->get('colors');
    return $query->result_array();
  }

  public function getAllDashDetail()
  {
    $this->db->select('*, dashboard_details.id AS dashboard_detail_id');
    $this->db->from('dashboard_details');
    $this->db->join('dashboards', 'dashboards.id = dashboard_details.detail_dash_id');
    $this->db->join('fontawesomes', 'fontawesomes.id = dashboard_details.icon_id');
    $this->db->join('colors', 'colors.id = dashboard_details.color_id');

    $this->db->group_by('dashboard_details.id');

    $this->db->order_by('dashboard_details.id', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertDashboard($data)
  {
    $this->db->insert('dashboard_details', $data);
    return $this->db->insert_id();
  }

  public function deleteDashboard($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('dashboard_details');

    return $this->db->affected_rows();
  }

  // SET ALERT 
  public function getAlertValue($id)
  {
    $this->db->select('*, company_profile.id AS id_profile, company_profile_alerts.id AS id_profile_alert');

    $this->db->from('company_profile_alerts');
    $this->db->join('company_profile', 'company_profile.id = company_profile_alerts.company_profile_id', 'left');

    $this->db->where('company_profile_alerts.company_profile_id', $id);

    $query = $this->db->get();
    return $query->row_array();
  }

  public function insertAlertValue($data)
  {
    $this->db->insert('company_profile_alerts', $data);

    return $this->db->insert_id();
  }

  public function updateAlertValue($id, $data)
  {
    $this->db->where('company_profile_id', $id);
    $this->db->update('company_profile_alerts', $data);

    return $this->db->affected_rows();
  }
}
  
  /* End of file Company_m.php */
