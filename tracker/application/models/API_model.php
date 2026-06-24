<?php

    class API_model extends CI_Model
    {
        function __construct()
        {
            parent:: __construct();
        }
     
     function insertLatLong($email, $latitude, $longitude, $created_by, $created_at){
           $data = array(
                        'email_id'   => $email,
                        'latitude'   => $latitude,
                        'longitude'  => $longitude,
                        //'address'    => $address,
                        'created_by' => $created_by,
                        'created_at' => $created_at
                    );

                    $this->db->insert('tracker_lat_long', $data);

                    return $this->db->insert_id(); // inserted row id return karega
      }
     
    
     
 /*End*/       
}    