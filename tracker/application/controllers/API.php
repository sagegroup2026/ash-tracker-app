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
       // Step 1: Read raw JSON from request body
                $raw = file_get_contents("php://input");
                
                // Step 2: Decode JSON into an associative array
                $data = json_decode($raw, true);
                
                // Step 3: Access your values safely
                $accessToken = $data['access-token'] ?? '';
                
                $email = $data['email'] ?? '';
                $latitude   = $data['latitude']   ?? '';
                $longitude   = $data['longitude']   ?? '';
                $created_by = $data['agent_id'] ?? '';
                $created_at   = date('Y-m-d H:i:s');

                if ($accessToken === '9074809402') {
                   echo "sanjay done";
                } else {
            
                $statusCode = '402';
                $msg = 'Permission denied - Access token not matched';
            }
	}

    /*END*/
}    