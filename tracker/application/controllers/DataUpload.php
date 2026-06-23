<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");
 
class DataUpload extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url']);
    $this->load->model('Common_model');
}

/*------------ FollowUp Notification -------------*/ 
    public function uploadEventData(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            
         $dataType = $this->input->post('dataType');
         
         if($dataType==='captureImage'){
             
                             if (!empty($_POST['img_base64'])) {
                
                                    $data = $_POST['img_base64'];
                                    $data = str_replace('data:image/jpeg;base64,', '', $data);
                                    $data = base64_decode($data);
                            
                                    $dataName = 'event-' . time() . '.webp';
                            
                                    $path = FCPATH . 'assets/images/eventData/';
                                    if (!is_dir($path)) {
                                        mkdir($path, 0755, true);
                                    }
                            
                                    file_put_contents($path . $dataName, $data);
                                    }
                    
                     }else if($dataType==='uploadFile'){
                         
                             if (!empty($_FILES['uploadFile']['name'])) {
                         
                                 $path = FCPATH . 'assets/images/eventData/';
                                    if (!is_dir($path)) {
                                        mkdir($path, 0755, true);
                                    }
                            
                                    $fileName = $_FILES['uploadFile']['name'];
                                    $fileTmp  = $_FILES['uploadFile']['tmp_name'];
                                    $fileSize = $_FILES['uploadFile']['size'];
                                    $fileError = $_FILES['uploadFile']['error'];
                            
                                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                    
                                    
                                    $dataName = 'event-' . time() . '-' . rand(1000,9999) . '.' . $fileExt;

                                   move_uploaded_file($fileTmp, $path . $dataName);
                                     
                                   }
                       }
         
        $data = array(
                    'eventId' => $this->input->post('eventId'),
                    'numberOfPeople' => $this->input->post('numberOfPeople'),
                    'created_by' => $this->input->post('loginId'),
                    'dataType' => $dataType,
                    'dataName' => $dataName,
                    'formType' => $this->input->post('formType'),
                    'created_at' => date('Y-m-d H:i:s')
                     ); 
         
              /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_EventData', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Event Data saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Something went wrong.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
        }
    
        redirect('event-created');
         
          
        }    
    }
    
 /*End*/   
}    