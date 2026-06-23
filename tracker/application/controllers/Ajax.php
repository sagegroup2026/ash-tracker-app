<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");
 
class Ajax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    
        $this->load->helper(['url']);
        $this->load->model('Common_model');
    }
    
    public function get_profilename_by_type()
    {
        $type = $this->input->post('profile_type');
        $login_id = $this->session->userdata('login_id'); 
        if(empty($type)){
            echo json_encode([]);
            return;
        }
    
            $profiles = $this->Common_model->getProfilesByType($type, $login_id); 
    
        echo json_encode($profiles);
    }
    
    public function get_pocname_by_profile()
    {
        $profile_id = $this->input->post('profile_id');
        $login_id = $this->session->userdata('login_id'); 
        
        if(empty($profile_id)){
            echo json_encode([]);
            return;
        }
            $pocs = $this->Common_model->getPocByProfile($profile_id, $login_id);
       echo json_encode($pocs);
    }

    public function get_patient_data()
    {
        $draw   = $this->input->post('draw');
        $start  = $this->input->post('start');
        $length = $this->input->post('length');
    
        $data = $this->Common_model->get_patient_ajax($start, $length);
        $total = $this->Common_model->count_all_patient();
    
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];
    
        echo json_encode($response);
    }
}