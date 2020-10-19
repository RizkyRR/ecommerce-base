<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session
{

  public function __construct()
  {
    parent::__construct();
  }

  function sess_destroy()
  {

    $CI = &get_instance();

    $dataSession = $CI->session->userdata('email');

    if ($dataSession) {
      //write your update here 
      // $CI->db->update('YOUR_TABLE', array('YOUR_DATA'), array('YOUR_CONDITION'));
      $CI->auth_m->updateUserOffline($CI->session->userdata('email'));

      //call the parent 
      parent::sess_destroy();
    }
  }
}
