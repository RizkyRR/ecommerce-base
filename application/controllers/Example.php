<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Example extends CI_Controller
{

  public function index()
  {
    $data['title'] = "Example";

    renderBackTemplate('back-examples/index', $data);
  }

  public function blank()
  {
    $data['title'] = "Blank Page";

    renderBackTemplate('back-examples/blank', $data);
  }

  public function login()
  {
    $data['title'] = "Log In";
    renderAuthTemplate('auths/login', $data);
  }

  public function forgotPassword()
  {
    $data['title'] = "Forgot Password";
    renderAuthTemplate('auths/forgot-password', $data);
  }

  public function register()
  {
    $data['title'] = "Register New User";
    renderAuthTemplate('auths/register', $data);
  }
}
  
  /* End of file Example.php */
