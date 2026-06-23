<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");
 
class Test extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url']);
    $this->load->model('Common_model');
}

/*------------ FollowUp Notification -------------*/ 
    public function followup_notification_test(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            
           
            $login_id = $this->session->userdata('login_id'); 
            $data['profile']=getProfileId($login_id);

            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('Test/today-pending-plan',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    
    // public function visit_start_meeting(){
    
    //     date_default_timezone_set("Asia/Kolkata");
    
    //     $login_id = $this->session->userdata('login_id');
    
    //     $data = [
    //         'created_by' => $login_id,
    //         'profile_id' => $this->input->post('profile_id'),
    //         'in_time' => date('Y-m-d H:i:s'),
    //         'status' => 0
    //     ];
    
    //     if($this->db->insert('tracker_visit_form',$data)){
    //         echo json_encode(['status'=>'success']);
    //     }else{
    //         echo json_encode(['status'=>'error']);
    //     }
    
    // }
    
    public function visit_start_meeting()
    {
        date_default_timezone_set("Asia/Kolkata");
    
        $login_id  = $this->session->userdata('login_id');
        $profile_id = $this->input->post('profile_id');
    
        /* ---------- GET PROFILE DETAILS ---------- */
        $profile = get_profile_details($profile_id);
    
        $profile_name = !empty($profile->name) ? $profile->profile_name : NULL;
        $contact      = !empty($profile->contact) ? $profile->contact : NULL;
    
        /* ---------- CHECK EXISTING MEETING ---------- */
        $existing = get_today_active_meeting($profile_id, $login_id);
    
        if ($existing) {
    
            /* ---------- UPDATE ---------- */
            $updateData = [
                'in_time'      => date('Y-m-d H:i:s'),
                'status'       => 3,
                'contact'      => $contact
            ];
    
            $this->db->where('id', $existing->id);
            $result = $this->db->update('tracker_visit_form', $updateData);
    
        } else {
    
            /* ---------- INSERT ---------- */
            $insertData = [
                'created_by'   => $login_id,
                'profile_id'   => $profile_id,
                'contact'      => $contact,
                'date'  => date('Y-m-d'),
                'visit_time' => date('H:i:s'),
                'in_time'      => date('Y-m-d H:i:s'),
                'status'       => 3
            ];
    
            $result = $this->db->insert('tracker_visit_form', $insertData);
        }
    
        /* ---------- RESPONSE ---------- */
        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    

        
public function save_test_visit(){
    
    date_default_timezone_set("Asia/Kolkata");
    
    $login_id = $this->session->userdata('login_id');
    
    $profile_id = $this->input->post('profile_id');
    
    /* ---------- LAST INSERTED RECORD ---------- */
    
    $this->db->where('profile_id',$profile_id);
    $this->db->where('created_by',$login_id);
    $this->db->order_by('id','DESC');
    $this->db->limit(1);
    
    $existing = $this->db->get('tracker_visit_form')->row();

    /* ---------- IMAGE ---------- */
    $img_name = NULL;

    if(!empty($_POST['img_base64'])){

            $img = $_POST['img_base64'];
            $img = str_replace('data:image/jpeg;base64,','',$img);
            $img = base64_decode($img);
    
            $img_name = 'visit-'.time().'.webp';
    
            $path = FCPATH.'assets/images/visit/';
            if(!is_dir($path)){
                mkdir($path,0755,true);
            }
    
            file_put_contents($path.$img_name,$img);
        }
    
    $noPoc = $this->input->post('no_poc');
       
        if($noPoc==1){
            $data = array(
                        'profile_id' => $this->input->post('profile_id'),
                        'name' => $this->input->post('profile_name'),
                        'designation' => 'Through Vist',
                        'contact' => $this->input->post('contact'),
                        'status' => 1,
                        'created_by' => $login_id,
                        'created_at'         => date('Y-m-d H:i:s')
                         );
                         
         $poc_id =  $this->Common_model->pocCreationRefVisit($data);
            
        $pocId = $poc_id;    
        }else{
        $pocId = $this->input->post('poc_select');
        
            if (is_array($pocId)) {
                    $pocId = implode(',', $pocId); // comma separated
                    } else {
                        $pocId = $pocIds;
                    }
        
        
        }
    
    /* ---------- COFELLOW DATA ---------- */

    $cofellowData = [];
    
    $cofellowIds = $this->input->post('cofellow_select');
    
    if (!empty($cofellowIds) && is_array($cofellowIds)) {
    
        foreach ($cofellowIds as $id) {
    
            $this->db->where('id', $id);
            $agent = $this->db->get('tracker_login')->row();
    
            if ($agent) {
    
                $cofellowData[] = [
                    'id'   => $agent->id,
                    'name' => $agent->name
                ];
    
            }
        }
    }
    
    /* JSON FORMAT */
    $cofellowJson = !empty($cofellowData)
        ? json_encode($cofellowData)
        : NULL;
    
    /* ---------- DATA ---------- */
    
    $data = [
    'contact'            => $this->input->post('contact'),
    'poc_id'             => $pocId,
    'date'               => date('Y-m-d'),
    'visit_time'         => date('H:i:s'),
    'discussion'         => $this->input->post('discussion'),
    'discussion_pointer' => $this->input->post('discussion_pointer'),
    'follow_up_date'     => $this->input->post('follow_up_date'),
    'location'           => $this->input->post('location'),
    'image' => $img_name,
    'out_time'           => date('Y-m-d H:i:s'),
    'cofellow'           => $cofellowJson,
    'status' => 1
    ];
    
    
    /* ---------- UPDATE / INSERT ---------- */
    
    if($existing){
    
        // UPDATE LAST RECORD
    
        $this->db->where('id',$existing->id);
        $result = $this->db->update('tracker_visit_form',$data);
    
    }else{
    
        // INSERT NEW RECORD
        $data['created_by'] = $login_id;
        $data['profile_id'] = $profile_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['in_time'] = date('H:i:s');
    
        $result = $this->db->insert('tracker_visit_form',$data);
    }
    
    redirect('followup-notification');
}

    // public function save_add_plan()
    // {
    //     date_default_timezone_set("Asia/Kolkata");
    //     $login_id = $this->session->userdata('login_id');
    
    //     $profiles = $this->input->post('profileName'); // checkbox array
    
    //     if(!empty($profiles))
    //     {
    //         foreach($profiles as $profile_id)
    //         {
    //             $data = array(
    //                 'profile_id' => $profile_id,
    //                 'status' => 0,
    //                 'created_by' => $login_id,
    //                 'created_at' => date('Y-m-d H:i:s'),
    //                 'follow_up_date'=>date('Y-m-d'),
    //                 'plan_date' => date('Y-m-d')
    //             );
    
    //             $this->db->insert('tracker_visit_form', $data);
    //         }
    
    //         $this->session->set_flashdata(
    //             'login-message',
    //             '<div class="alert alert-success alert-dismissible fade show">
    //                 <strong>Success!</strong> Daily plan saved successfully.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    //             </div>'
    //         );
    
    //         redirect('followup-notification-test');
    //     }
    //     else
    //     {
    //         $this->session->set_flashdata(
    //             'login-message',
    //             '<div class="alert alert-danger alert-dismissible fade show">
    //                 <strong>Error!</strong> Please select at least one profile.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    //             </div>'
    //         );
    
    //         redirect('daily-plan-list');
    //     }
    // }
    
    public function save_add_plan()
{
    date_default_timezone_set("Asia/Kolkata");
    $login_id = $this->session->userdata('login_id');

    $profiles = $this->input->post('profileName');

    if (!empty($profiles))
    {
        foreach ($profiles as $profile_id)
        {
            // /* ---------- STEP 1: GET LAST RECORD ---------- */
            // $last = get_last_inserted_visit($profile_id, $login_id);

            // if ($last)
            // {
            //     $old_followup = $last->follow_up_date;

            //     /* ---------- STEP 2: UPDATE LAST RECORD ---------- */
            //     $updateData = [
            //         'follow_up_date' => date('Y-m-d'),
            //         'plan_date'      => !empty($old_followup) ? $old_followup : NULL
            //     ];

            //     $this->db->where('id', $last->id);
            //     $this->db->update('tracker_visit_form', $updateData);
            // }

            /* ---------- STEP 3: INSERT NEW RECORD ---------- */
            $data = array(
                'profile_id'     => $profile_id,
                'created_by'     => $login_id,
                'created_at'     => date('Y-m-d H:i:s'),
                'follow_up_date' => date('Y-m-d'),
                'plan_date'      => date('Y-m-d'),
                'status'        => '2' 
            );

            $this->db->insert('tracker_visit_form', $data);
        }

        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Daily plan saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
       
        redirect('followup-notification');
    }
    else
    {
        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Please select at least one profile.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );

        redirect('daily-plan-list');
    }
}




// IPD/OPD/HC 

    public function test_patient(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id');
            $data['poc'] = $this->Common_model->getAllwhere('tracker_poc',array('status'=>'1', 'created_by' => $login_id),'all','','', '', '', null,null);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('Test/test_patient',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    
        /*------------------ SAVE Patient -----------------*/ 
    public function save_test_patient()
    { 
       
        $login_id = $this->session->userdata('login_id');
        $poc_id = $this->input->post('poc_id');
        $ref_by = $this->input->post('ref_by');
        
        /* ---------- GET POC DATA ---------- */
        $poc_json = null;
    
        if(!empty($poc_id)){
            
            $poc = $this->Common_model->getPocDataInJson($poc_id);

            if($poc){
                $poc_json = json_encode([$poc]);
            }
        }
        else if($ref_by == 'other'){
            $poc_data = [
                "name"     => $this->input->post('other_name'),
                "poc_type" => "other",
                "contact"  => $this->input->post('other_contact'),
                "comment"  => $this->input->post('other_comment')
            ];
        
            $poc_json = json_encode([$poc_data]);
        }


        
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'team_name' =>$this->input->post('t_name'),
            'patient_name'         => $this->input->post('p_name'),
            'patient_contact'    =>$this->input->post('p_contact'),
            'ref_by'    => $this->input->post('ref_by'),
            'profile_id'    => $this->input->post('profile_id'),
            'poc'              => $poc_json ,
            'contact'         => $this->input->post('contact'),
            'type' => $this->input->post('type'),
        ];

        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_patient', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> IPD/OPD/HC saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
          redirect('patient');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
            redirect('patient');
        }
    
        // redirect('dashboard');
    }
}