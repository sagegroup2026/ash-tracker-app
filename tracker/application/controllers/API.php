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
	    $this->load->model('API_model'); 
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
                   
                $address = getAddressFromLatLong($latitude, $longitude);
                $dataSubmit = $this->API_model->insertLatLong($email, $latitude, $longitude, $created_by, $created_at,$address);
                $statusCode = '200';
                $msg = 'Location Added Successfully';



                } else {
            
                $statusCode = '402';
                $msg = 'Permission denied - Access token not matched';
            }

            $return = array ('statusCode'=>$statusCode,'Msg'=>$msg);
       
             echo json_encode($return);


	}

/* ==== GET ADDRESS FROM LAT LONG ==== */
function getAddressFromLatLong($lat, $lng)
{
    // INVALID LAT LNG CHECK
    if(empty($lat) || empty($lng)){
        return '';
    }

    $url = "https://nominatim.openstreetmap.org/reverse?lat=".$lat."&lon=".$lng."&format=json";

    $ch = curl_init();

    curl_setopt_array($ch, [

        CURLOPT_URL => $url,

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_SSL_VERIFYPEER => false,

        CURLOPT_TIMEOUT => 20,

        CURLOPT_HTTPHEADER => [
            "User-Agent: MyTrackerApp/1.0 (developeradmin@gmail.com)"
        ]

    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    if($response){

        $result = json_decode($response, true);

        // FULL ADDRESS
        if(isset($result['display_name'])){

            return $result['display_name'];
        }
    }

    return '';
}



    /*END*/
}    