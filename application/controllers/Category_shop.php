<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category_shop extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(['template']);
  }

  public function getAllCategory()
  {
    $data = $this->category_m->getAllCategory();
    echo json_encode($data);
  }
}
  
  /* End of file Category_shop.php */
