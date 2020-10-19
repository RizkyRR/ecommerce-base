<?php
// FOR ADMIN 
function checkSessionLog()
{
  $ci = &get_instance();

  if (!$ci->session->userdata('email')) {
    redirect('auth');
  } else {
    $id_role = $ci->session->userdata('role_id');

    $menu = $ci->uri->segment(1);

    $query = $ci->db->get_where('user_sub_menu', ['level' => $menu])->row_array();
    $id_menu = $query['menu_id'];

    $access = $ci->db->get_where('user_access_menu', [
      'role_id' => $id_role,
      'menu_id' => $id_menu
    ])->row_array();

    if (empty($access)) {
      redirect('auth/denied');
    }
  }
}

function checkAccess($role_id, $menu_id)
{
  $ci = &get_instance();

  $result = $ci->db->get_where('user_access_menu', [
    'role_id' => $role_id,
    'menu_id' => $menu_id
  ]);

  if ($result->num_rows() > 0) {
    return "checked='checked'";
  }
}

// FOR FRONTEND ACCESS
function checkCustomerSessionLog()
{
  $ci = &get_instance();

  if (!$ci->session->userdata('customer_email')) {
    redirect('sign-in');
  } else {
    redirect('profile');
  }
}
