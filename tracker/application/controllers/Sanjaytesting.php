<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");

class Sanjaytesting extends CI_Controller
{
        function __construct()
    {
        parent::__construct();
    
        $this->load->helper(['url']);
        $this->load->model('Common_model');
        $this->config->load('custom_config');
    }

     public function cameratest(){
    //if session Id empty then it will redirect to login page 
    if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
     }else{
        $data['username']=$this->session->userdata('user_name');
        // $data['countries'] = getCountriesById();
        // $data['state']=getStateByCountry('101');
        $this->load->view('common/header');
        $this->load->view('common/main_header',$data);
        $this->load->view('Test/sanjayTest',$data);
        $this->load->view('common/footer-new');
     }
    }

       public function AllIPDOPDHC_DataShow(){
           
          if(empty($this->session->userdata('login_id'))){
                redirect(base_url()); 
             }else{
                 $data['get_allIPDOPDdata'] = $this->Common_model->get_allIPDOPDdata();
                 $data['get_todayIPDOPDdata'] = $this->Common_model->get_todayIPDOPDdata();
                    $this->load->view('common/header');
                    $this->load->view('common/main_header',$data);
                    $this->load->view('Test/AllIPDOPDHC_DataShowlIST',$data);
                    $this->load->view('common/footer-new');
                 
             }
       }


/*End*/
}