<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Comment_reply extends CI_Controller
{


  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }
}
  
  /* End of file Comment_reply.php */
