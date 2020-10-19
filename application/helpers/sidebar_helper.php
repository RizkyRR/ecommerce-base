<?php

function sidebarMenu()
{
  $ci = &get_instance();

  $user = $ci->session->userdata('role_id');

  $ci->db->select('user_menu.id, user_menu.menu, user_menu.icon');
  $ci->db->from('user_menu');
  $ci->db->join('user_access_menu', 'user_access_menu.menu_id = user_menu.id');
  $ci->db->where('user_access_menu.role_id', $ci->session->userdata('role_id'));

  $ci->db->order_by('menu_id', 'ASC');

  $query = $ci->db->get();
  return $query->result_array();
}

function sidebarSubMenu($menu_id)
{
  $ci = &get_instance();

  $ci->db->where('is_active', 1);
  $ci->db->where('menu_id', $menu_id);

  $ci->db->order_by('title', 'ASC');

  $query = $ci->db->get('user_sub_menu');
  return $query->result_array();
}
