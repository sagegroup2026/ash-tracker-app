<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

// SimpleXLSX library ko include karein
require_once APPPATH . 'third_party/SimpleXLSX.php';
use Shuchkin\SimpleXLSX;

class API extends CI_Controller {
    function __construct(){
	    parent::__construct();
	    $this->load->database();
        $this->load->library('session');
	    //S$this->load->model('API_model'); 
        $this->load->helper('url');
      
	}

	public function get_lat_long_user()
	{
      echo "sanjay";
	}