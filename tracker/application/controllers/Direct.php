<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");

class Direct extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url']);
    $this->load->model('Common_model');
}
    
    public function directLogin($loginId,$username){
       $this->session->set_userdata('login_id', $loginId);
       $this->session->set_userdata('user_name', $username);
       redirect('dashboard');
   }
    
/*End*/    
}    