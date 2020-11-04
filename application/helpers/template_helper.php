<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function renderAuthTemplate($page = null, $data = array())
{
  $ci = &get_instance();

  $data['user'] = $ci->auth_m->getUserSession();
  $data['company'] = $ci->company_m->getCompanyById(1);
  $data['company_address'] = $ci->company_m->getFullAdressCustomer(1);

  $ci->load->view('back-templates/header_auth', $data);
  $ci->load->view($page, $data);
  $ci->load->view('back-templates/footer_auth', $data);
}

function renderBackTemplate($page = null,  $data = array())
{
  $ci = &get_instance();

  $data['user'] = $ci->auth_m->getUserSession();
  $data['company'] = $ci->company_m->getCompanyById(1);
  $data['company_address'] = $ci->company_m->getFullAdressCustomer(1);

  $ci->load->view('back-templates/header', $data);
  $ci->load->view('back-templates/topbar', $data);
  $ci->load->view('back-templates/navbar', $data);
  $ci->load->view($page, $data);
  $ci->load->view('back-templates/footer', $data);
}

function renderFrontTemplate($page = null, $data = array())
{
  $ci = &get_instance();

  $data['company'] = $ci->company_m->getCompanyById(1);
  $data['company_address'] = $ci->company_m->getFullAdressCustomer(1);
  $data['detail_company'] = $ci->company_m->getLinkCompany();
  $data['count_wishlist'] = $ci->product_m->getCountWishlist($ci->session->userdata('customer_email'));

  $ci->load->view('front-templates/header', $data);
  $ci->load->view($page, $data);
  $ci->load->view('front-templates/footer', $data);
}
