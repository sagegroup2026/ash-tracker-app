<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");
 
class Form extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url']);
    $this->load->model('Common_model');

    // Skip check for login pages
    $current_method = $this->router->fetch_method();
    $skip_methods = ['index','login','check_login'];

    if(in_array($current_method, $skip_methods)){
        return;
    }

    // If not logged in
    if(!$this->session->userdata('login_id')){
        redirect('login');
    }

    // Device check
    $login_id = $this->session->userdata('login_id');
    $session_token = $this->session->userdata('device_token');

    $db_token = $this->db->select('device_token')
                         ->where('id', $login_id)
                         ->get('tracker_login')
                         ->row();

    if($db_token && $db_token->device_token !== $session_token){ 

        $this->session->sess_destroy();
    
        echo "<script>
                alert('You have logged in to another device');
                window.location.href = '".base_url('login')."';
              </script>";
              exit;
        redirect('login');
    }
}
 
    
    // public function save_poc()
    // {
    //      date_default_timezone_set("Asia/Kolkata");
    //     $login_id = $this->session->userdata('login_id');
    
    //     /* ---------- DATA ARRAY ---------- */
    //     $data = [
    //         'created_by'         => $login_id,
    //         'profile_id'         => $this->input->post('p_id'),
    //         'name'               => $this->input->post('poc_name'),
    //         'contact'            => $this->input->post('poc_contact'),
    //         'created_at'         => date('Y-m-d H:i:s')
    //     ];
        
    //     /* ---------- INSERT ---------- */
    //     if ($this->db->insert('tracker_poc', $data)) {
    //         $this->session->set_flashdata('login-message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success!</strong>POC Saved Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //             redirect(base_url('poc')); 
    //     } else {
    //         $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> Something went wrong. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //             redirect(base_url('login')); 
    //     }
    
    //     redirect('dashboard');
    // }
    
    /* ---------- DATA ARRAY ---------- */
    
    public function save_daily_plan()
    {
        date_default_timezone_set("Asia/Kolkata");
        $login_id = $this->session->userdata('login_id');
    
        $profiles = $this->input->post('profileName'); // checkbox array
    
        if(!empty($profiles))
        {
            foreach($profiles as $profile_id)
            {
                $data = array(
                    'profile_id' => $profile_id,
                    'status' => 0,
                    'created_by' => $login_id,
                    'created_at' => date('Y-m-d H:i:s')
                );
    
                $this->db->insert('tracker_daily_plan', $data);
            }
    
            $this->session->set_flashdata(
                'login-message',
                '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> Daily plan saved successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
    
            redirect('daily-plan-list');
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
        
    public function save_poc()
    {
        date_default_timezone_set("Asia/Kolkata");
        $login_id = $this->session->userdata('login_id');
    
        $mobile = $this->input->post('poc_contact');
        $tablename = 'tracker_poc';
    
        // Check mobile exists
        if (check_mobile_exists($tablename,'contact',$mobile)) {
            $this->session->set_flashdata(
                'login-message',
                '<div class="alert alert-warning alert-dismissible fade show">
                    <strong>Warning!</strong> Mobile number already exists.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
            // CHECK FORM SOURCE
           if ($this->input->post('through_visit_form')) {
                $profile_id   = $this->input->post('p_id');
                $profile_name = urlencode($this->input->post('profile_name'));
                echo "<script> alert('Mobile Number Exists!');
                    window.location.href='".base_url(
                        'test-visit?profile_id='.$profile_id.
                        '&profile_name='.$profile_name
                    )."';
                </script>
                ";
                exit;
            } else {
                redirect(base_url('poc'));
            }
        }
    
        $data = [
            'created_by' => $login_id,
            'profile_id' => $this->input->post('p_id'),
            'name'       => $this->input->post('poc_name'),
            'contact'    => $mobile,
            'created_at' => date('Y-m-d H:i:s')
        ];
    
        if ($this->db->insert('tracker_poc', $data)) {
            $this->session->set_flashdata(
                'login-message',
                '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> POC Saved Successfully
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
           // CHECK FORM SOURCE
           if ($this->input->post('through_visit_form')) {
                $profile_id   = $this->input->post('p_id');
                $profile_name = urlencode($this->input->post('profile_name'));
                echo "<script> alert('POC Saved Successfully');
                    window.location.href='".base_url(
                        'test-visit?profile_id='.$profile_id.
                        '&profile_name='.$profile_name
                    )."';
                </script>
                ";
                exit;
            } else {
                echo "
                <script>
                    alert('POC Saved Successfully');
                    window.location.href='".base_url('poc')."';
                </script>
                ";
                exit;
            }
        } else {
            $this->session->set_flashdata(
                'login-message',
                '<div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
            redirect(base_url('poc'));
        }
    }

    
    public function save_senior_time()
    { 
        date_default_timezone_set("Asia/Kolkata");
        $login_id = $this->session->userdata('login_id');
        if (!empty($_POST['img_base64'])) {

        $data = $_POST['img_base64'];
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $data = base64_decode($data);

        $img_name = 'senior-' . time() . '.webp';

        $path = FCPATH . 'assets/images/senior/';
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $img_name, $data);
        }
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'         => $login_id,
            'agenda'         => $this->input->post('agenda'),
            'senior_name'               => $this->input->post('senior_name'),
            'from_time'            => $this->input->post('from_time'),
            'to_time'         => $this->input->post('to_time'),
            'image'              => $img_name,
            'created_at'       => date('Y-m-d H:i:s')
        ];

        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_time_with_senior', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Time With Senior saved successfully.
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
    
        redirect('senior');
    }
    
    /*------------------ SAVE TARGET -----------------*/ 
    // public function save_target()
    // { 
       
    //     $login_id = $this->session->userdata('login_id');
    //      if(checkTargetAlreadyExistsInAMonth($login_id)){
            
    //         $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> This Month Target Already Exists. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //         redirect('target');
             
    //      }else{
    //         /* ---------- DATA ARRAY ---------- */
    //         $data = [
    //             'created_by'     => $login_id,
    //             'healthcare'         => $this->input->post('healthcare'),
    //             'opd'    => $this->input->post('opd'),
    //             'ipd'      => $this->input->post('ipd'),
    //             'booking'        => $this->input->post('booking'),
    //             'admission'    => $this->input->post('admission'),
    //             'profile_created'      => $this->input->post('profile_created'),
    //             'poc_onboard'        => $this->input->post('poc_onboard'),
    //         ];
            
    //         // print_r($data);exit;
     
    //         /* ---------- INSERT ---------- */
    //         if ($this->db->insert('tracker_target', $data)) {
            
    //         $this->session->set_flashdata('login-message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success!</strong>Target Saved Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //         redirect('target');
                
    //         } else {
    //             $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> Something went wrong. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //         }
        
    //         redirect('dashboard');
    //     }
    // }
    
    public function save_target()
    {
    date_default_timezone_set("Asia/Kolkata");
    $login_id = $this->session->userdata('login_id');

    if (checkTargetAlreadyExistsInAMonth($login_id)) {

        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> This month target already exists.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );

        redirect('target');
        return;
    }

    $data = [
        'created_by'       => $login_id,
        'healthcheckup'       => $this->input->post('healthcheckup'),
        'opd'              => $this->input->post('opd'),
        'ipd'              => $this->input->post('ipd'),
        'booking'          => $this->input->post('booking'),
        'admission'        => $this->input->post('admission'),
        'profile_created'  => $this->input->post('profile_created'),
        'poc_onboard'      => $this->input->post('poc_onboard'),
        'visit'           => $this->input->post('visit'),
        'created_at'       => date('Y-m-d H:i:s')
    ];

    if ($this->db->insert('tracker_target', $data)) {

        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Target saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );

        redirect('target');
    } else {

        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );

        redirect('target');
    }
}

    
   
    
    /*------------------ SAVE OPERATION -----------------*/ 
    public function save_operation()
    { 
        date_default_timezone_set("Asia/Kolkata");
        $login_id = $this->session->userdata('login_id');
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'operation_type'         => $this->input->post('operation_type'),
            'operation_date'    => $this->input->post('operation_date'),
            'from_time'            => $this->input->post('from_time'),
            'to_time'         => $this->input->post('to_time'),
            'created_at'       => date('Y-m-d H:i:s')
           
        ];
        
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_operation', $data)) {
           $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Agreement Preparation saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
         redirect('operation');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
          redirect('operation');
        }
    
        redirect('dashboard');
    }
    
    
    /*------------------ SAVE Booking -----------------*/ 
    public function save_booking()
    { 
        date_default_timezone_set("Asia/Kolkata");
        $login_id = $this->session->userdata('login_id');
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'lead_or_comfirmed' => $this->input->post('lead_or_comfirmed'),
            'customer_name'         => $this->input->post('customer_name'),
            'project_name'    => $this->input->post('project_name'),
            'deal_by'            => $this->input->post('deal_by'),
            'given_date'         => $this->input->post('given_date'),
            'created_at'       => date('Y-m-d H:i:s')
           
        ];
        
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_booking', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Booking saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
         redirect('booking');
        } else {
           $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
         redirect('booking');
        }
    
        redirect('dashboard');
    }
    
    /*------------------ SAVE Admission -----------------*/ 
    public function save_admission()
    { 
       
        $login_id = $this->session->userdata('login_id');
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'lead_or_comfirmed' => $this->input->post('lead_or_comfirmed'),
            'student_name'         => $this->input->post('student_name'),
            'f_name'    => $this->input->post('f_name'),
            'vertical'            => $this->input->post('vertical'),
            'branch'         => $this->input->post('branch'),
            'ref_to'         => $this->input->post('ref_to')
        ];
         
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_admission', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Admission saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
         redirect('admission');
        } else {
           $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
         redirect('admission');
         
        }
    
        redirect('dashboard');
    }
    
        /*------------------ SAVE Healthcare -----------------*/ 
    public function save_healthcare()
    { 
       
        $login_id = $this->session->userdata('login_id');
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'patient_name'         => $this->input->post('patient_name'),
            'ref_by'    => $this->input->post('ref_by'),
            'given_date'    => $this->input->post('given_date'),
            'type'         => $this->input->post('type'),
        ];
         
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_health', $data)) {
           $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Admission saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
        }
    
        redirect('dashboard');
    }
    
    /*------------------ SAVE Patient -----------------*/ 
    public function save_patient()
    { 
       
        $login_id = $this->session->userdata('login_id');
        $patient_contact = $this->input->post('p_contact');
        
        $data_poc = [];
        $poc_types = $this->input->post('poc_type');
        $poc_names = $this->input->post('poc_name');       
        //$poc_contacts = $this->input->post('poc_contact');
        $poc_comment = $this->input->post('poc_comment');
        
        foreach ($poc_names as $key => $poc_name) {
                if (!empty($poc_name)) {
                    $data_poc[] = [
                        'name'        => trim($poc_name),
                        'poc_type' => $poc_types[$key] ?? '',
                        //'contact'     => $poc_contacts[$key] ?? '',
                        'comment'  => $poc_comment[$key] ?? ''
                    ];
                }
        }
    
        // // Check mobile exists
        // if(!empty($patient_contact)) {
        //     if (check_mobile_exists('tracker_patient','patient_contact',$patient_contact)) {
        //         $this->session->set_flashdata(
        //             'register-message',
        //             '<div class="alert alert-warning alert-dismissible fade show">
        //                 <strong>Warning!</strong> Mobile number already exists.
        //                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        //             </div>'
        //         );
        //         redirect(base_url('patient'));
        //         return;
        //     }
        // }
        
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'team_name' =>$this->input->post('t_name'),
            'patient_name'         => $this->input->post('p_name'),
            'patient_contact'    =>$patient_contact,
            'ref_by'    => $this->input->post('ref_by'),
            'poc'              => json_encode($data_poc, JSON_UNESCAPED_UNICODE),
            'contact'         => $this->input->post('contact'),
            'type' => $this->input->post('type'),
        ];
         
        // print_r($data);exit;
 
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
    
    
    // public function save_profile()
    // {
    //     $login_id = $this->session->userdata('login_id');
    //     $name = $this->session->userdata('name');
        
    //         /* ---------- LOCATION ---------- */
    //         // JSON string from hidden input
    //         $location = $this->input->post('location');
            
    //     $social_media = [
    //         'whatsapp'   => $this->input->post('whatsapp'),
    //         'facebook'   => $this->input->post('facebook'),
    //         'instagram'  => $this->input->post('instagram'),
    //         'linkedinId' => $this->input->post('linkedin'),
    //     ];
        
    //     // $ref_doctor = [
    //     //     'doctor_1'   => $this->input->post('doctor_1'),
    //     //     'doctor_2'   => $this->input->post('doctor_2'),
    //     //     'doctor_3'  => $this->input->post('doctor_3'),
    //     //     'doctor_4' => $this->input->post('doctor_4'),
    //     // ];
    //     $poc_names = $this->input->post('poc_name');
    //     $poc_designations = $this->input->post('poc_designation');
    //     $poc_contacts = $this->input->post('poc_contact');
        
    //     foreach($poc_names as $key => $name){
    //         $data_poc[] = [
    //             'name' => $name,
    //             'designation' => $poc_designations[$key],
    //             'contact' => $poc_contacts[$key],
    //         ];
    //     }
        
    //     $h_names = $this->input->post('h_name');
    //     $h_cities = $this->input->post('h_city');
        
    //     foreach($h_names as $key => $name){
    //         $data_hospital[] = [
    //             'hospital_name' => $name,
    //             'city' => $h_cities[$key],
    //         ];
    //     }
        
        
    //     // ---------- PROFILE ID GENERATION ----------
    //     // profile id => profile_type + currentyear + first two letters of name + last two digits of mobile no + 6 digits of ramdom number for ex: DR2025AS01654321
        
    //     $profile_type = strtolower($this->input->post('profile_type'));
    //     if($profile_type == 'doctor') $profile_code = 'DR';
    //     else if ($profile_type == 'hr')  $profile_code = 'HR';
    //     else if ($profile_type == 'pharmacy')  $profile_code = 'PH';
    //     else if ($profile_type == 'lab')  $profile_code = 'LB';

    //     // Current year
    //     $year = date('Y');
        
    //     // Name (first two letters)
    //     $name = preg_replace('/\s+/', '', $this->input->post('name')); 
    //     $name_code = strtoupper(substr($name, 0, 2));
        
    //     // Mobile number (last two digits)
    //     $mobile = preg_replace('/\D/', '', $this->input->post('contact')); 
    //     $mobile_code = substr($mobile, -2);
        
    //     // Random 6 digit number
    //     $random_number = rand(100000, 999999);
        
    //     // Final Profile ID
    //     $profile_id = $profile_code . $year . $name_code . $mobile_code . $random_number;
        
    //     // ---------- PROFILE ID GENERATION ----------

    //     // Collect common data
    //     $data = [
    //         'created_by' => $login_id,
    //         'profile_type' => $this->input->post('profile_type'),
    //         'profile_id'  =>$profile_id,
    //         'name'         => $this->input->post('name'),
    //         'contact'      => $this->input->post('contact'),
    //         'emp_no'    => $this->input->post('emp_no'),
    //         'location'     => $location,
    //         'poc_no' =>$this->input->post('poc_no'),
    //         'hospital_onboard' =>$this->input->post('h_onboard'),
    //         // 'poc' => $data_poc,
    //         // 'hospital' => $data_hospital, 
    //         'company_name' => $this->input->post('company_name'),
    //     ];

    //     // Doctor specific data
    //     if ($data['profile_type'] == 'doctor') {
    //         $data['degree']           = $this->input->post('degree');
    //         $data['specialty']        = $this->input->post('specialty');
    //         $data['experience']       = $this->input->post('experience');
    //         $data['dob']              = $this->input->post('dob');
    //         $data['doa']              = $this->input->post('doa');
    //         $data['doctor_address']   = $this->input->post('doctor_address');
    //         $data['pincode']   = $this->input->post('pincode');
    //         $data['first_follow_up_date'] = $this->input->post('first_follow_up_date');
    //         $data['other_detail']     = $this->input->post('other_detail');
    //         $data['opd']              = $this->input->post('opd');
    //         $data['ipd']              = $this->input->post('ipd');
    //         $data['dr_grade']         = $this->input->post('dr_grade');
    //         $data['ref_doctor']       = json_encode($ref_doctor);
    //         $data['social_media']     = json_encode($social_media); 
    //     }
        
    //     // echo '<pre>';
    //     // print_r($data);exit;
        
    //     if ($this->db->insert('tracker_profile_form', $data)) {
    //         $this->session->set_flashdata('success', 'Profile saved successfully');
    //     } else {
    //         $this->session->set_flashdata('error', 'Something went wrong');
    //     }
    
    //     redirect('dashboard');
      
    // }
    

//     public function save_profile()
// {
//     // ================= AUTH =================
//     $login_id = $this->session->userdata('login_id');
//     if (!$login_id) {
//         redirect(base_url());
//     }

//     // ================= INPUT =================
//     $contact = trim($this->input->post('contact'));

//     // ================= DUPLICATE MOBILE CHECK WITH CREATOR NAME =================
//     $existing_profile = $this->db
//         ->select('l.name as creator_name')
//         ->from('tracker_profile_form p')
//         ->join('tracker_login l', 'l.id = p.created_by', 'left')
//         ->where('p.contact', $contact)
//         ->get()
//         ->row();
    
//     if ($existing_profile) {
    
//         $creatorName = $existing_profile->creator_name ?? 'Another User';
    
//         $this->session->set_flashdata(
//             'register-message',
//             '<div class="alert alert-warning alert-dismissible fade show" role="alert">
//                 <strong>Warning!</strong> Profile already created by 
//                 <strong>' . htmlspecialchars($creatorName) . '</strong>.
//                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//             </div>'
//         );
//         redirect('profile');
//     }


//     // ================= LOCATION =================
//     $location = $this->input->post('location'); // JSON

//     // ================= SOCIAL MEDIA =================
//     $social_media = [
//         'whatsapp'  => $this->input->post('whatsapp'),
//         'facebook'  => $this->input->post('facebook'),
//         'instagram' => $this->input->post('instagram'),
//         'linkedin'  => $this->input->post('linkedin'),
//     ];

//     // ================= INIT ARRAYS =================
//     $data_poc = [];
//     $data_hospital = [];

//     // ================= POC DATA =================
//     $poc_names = $this->input->post('poc_name');
//     if (!empty($poc_names)) {

//         $poc_designations = $this->input->post('poc_designation');
//         $poc_contacts     = $this->input->post('poc_contact');

//         foreach ($poc_names as $key => $poc_name) {
//             if (!empty($poc_name)) {
//                 $data_poc[] = [
//                     'name'        => trim($poc_name),
//                     'designation' => $poc_designations[$key] ?? '',
//                     'contact'     => $poc_contacts[$key] ?? ''
//                 ];
//             }
//         }
//     }

//     // ================= HOSPITAL DATA =================
//     $h_names = $this->input->post('h_name');
//     if (!empty($h_names)) {

//         $h_cities = $this->input->post('h_city');
//         foreach ($h_names as $key => $h_name) {
//             if (!empty($h_name)) {
//                 $data_hospital[] = [
//                     'hospital_name' => trim($h_name),
//                     'city'          => $h_cities[$key] ?? ''
//                 ];
//             }
//         }
//     }

//     // ================= PROFILE ID =================
//     $profile_type = strtolower($this->input->post('profile_type'));

//     if ($profile_type == 'doctor')      $profile_code = 'DR';
//     elseif ($profile_type == 'hr')      $profile_code = 'HR';
//     elseif ($profile_type == 'pharmacy')$profile_code = 'PH';
//     elseif ($profile_type == 'lab')     $profile_code = 'LB';
//     elseif ($profile_type == 'apartment')      $profile_code = 'AT';
//     elseif ($profile_type == 'clubs')$profile_code = 'CB';
//     elseif ($profile_type == 'society')     $profile_code = 'SC';
//     else                                $profile_code = 'OT';

//     $year = date('Y');

//     $name_clean = preg_replace('/\s+/', '', $this->input->post('name'));
//     $name_code  = strtoupper(substr($name_clean, 0, 2));

//     $mobile_only = preg_replace('/\D/', '', $contact);
//     $mobile_code = substr($mobile_only, -2);

//     $random = rand(100000, 999999);

//     $profile_id = $profile_code . $year . $name_code . $mobile_code . $random;

//     // ================= MAIN DATA =================
//     $data = [
//         'created_by'       => $login_id,
//         'profile_type'     => $this->input->post('profile_type'),
//         'profile_id'       => $profile_id,
//         'name'             => $this->input->post('name'),
//         'contact'          => $contact,
//         'doctor_address'   => $this->input->post('address'),
//         'pincode'          => $this->input->post('pincode'),
//         'emp_no'           => $this->input->post('emp_no'),
//         'location'         => $location,
//         'poc_no'           => $this->input->post('poc_no'),
//         'hospital_onboard' => $this->input->post('h_onboard'),
//         'poc'              => json_encode($data_poc, JSON_UNESCAPED_UNICODE),
//         'hospital'         => json_encode($data_hospital, JSON_UNESCAPED_UNICODE),
//         'company_name'     => $this->input->post('company_name'),
//         'valid_from'       => $this->input->post('valid_from'),
//         'valid_to'         => $this->input->post('valid_to'),
//         'created_at'       => date('Y-m-d H:i:s')
//     ];

//     // ================= DOCTOR EXTRA =================
//     if ($profile_type == 'doctor') {
//         $data['degree']       = $this->input->post('degree');
//         $data['specialty']    = $this->input->post('specialty');
//         $data['experience']   = $this->input->post('experience');
//         $data['dob']          = $this->input->post('dob');
//         $data['doa']          = $this->input->post('doa');
//         $data['opd']          = $this->input->post('opd');
//         $data['ipd']          = $this->input->post('ipd');
//         $data['dr_grade']     = $this->input->post('dr_grade');
//         $data['other_detail'] = $this->input->post('other_detail');
//         $data['social_media'] = json_encode($social_media);
//     }

//     // ================= TRANSACTION =================
//     $this->db->trans_start();

//     // INSERT PROFILE
//     $this->db->insert('tracker_profile_form', $data);

//     // INSERT POC TABLE
//     if (!empty($data_poc)) {
//         foreach ($data_poc as $poc) {
//             $this->db->insert('tracker_poc', [
//                 'profile_id' => $profile_id,
//                 'name'       => $poc['name'],
//                 'designation'=> $poc['designation'],
//                 'contact'    => $poc['contact'],
//                 'status'     => 1,
//                 'created_at' => date('Y-m-d H:i:s'),
//                 'created_by' => $login_id
//             ]);
//         }
//     }

//     $this->db->trans_complete();

//     // ================= RESPONSE =================
//     if ($this->db->trans_status() === TRUE) {

//         $this->session->set_flashdata(
//             'register-message',
//             '<div class="alert alert-success alert-dismissible fade show" role="alert">
//             <strong>Success!</strong> Profile & POC Saved Successfully.
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//             </div>'
//         );
//         redirect('profile');

//     } else {

//         $this->session->set_flashdata(
//             'register-message',
//             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//             <strong>Error!</strong> Something went wrong.
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//             </div>'
//         );
//         redirect('profile');
//     }
// }


public function save_profile()
{
    // ================= AUTH =================
    $login_id = $this->session->userdata('login_id');
    if (!$login_id) {
        redirect(base_url());
    }

    // ================= INPUT =================
    $contact = trim($this->input->post('contact'));

    // ================= DUPLICATE MOBILE CHECK =================
    $existing_profile = $this->db
        ->select('l.name as creator_name')
        ->from('tracker_profile_form p')
        ->join('tracker_login l', 'l.id = p.created_by', 'left')
        ->where('p.contact', $contact)
        ->get()
        ->row();

    if ($existing_profile) {

        $creatorName = $existing_profile->creator_name ?? 'Another User';

        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-warning alert-dismissible fade show">
                <strong>Warning!</strong> Profile already created by 
                <strong>' . htmlspecialchars($creatorName) . '</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        redirect('profile');
    }

    // ================= LOCATION =================
    $location = $this->input->post('location');

    // ================= SOCIAL MEDIA =================
    $social_media = [
        'whatsapp'  => $this->input->post('whatsapp'),
        'facebook'  => $this->input->post('facebook'),
        'instagram' => $this->input->post('instagram'),
        'linkedin'  => $this->input->post('linkedin'),
    ];

    // ================= POC DATA =================
    $data_poc = [];
    $is_poc = $this->input->post('is_poc');
    if ($is_poc) {
        // If checkbox is checked, automatically use profile info
        $data_poc[] = [
            'name'        => $this->input->post('name'),
            'designation' => 'Profile Owner',
            'contact'     => $contact
        ];
    } else {
        $poc_names = $this->input->post('poc_name');
        if (!empty($poc_names)) {
    
            $poc_designations = $this->input->post('poc_designation');
            $poc_contacts     = $this->input->post('poc_contact');
    
            foreach ($poc_names as $key => $poc_name) {
                
                    $poc_contact = $poc_contacts[$key] ?? '';
    
                    // ===== DUPLICATE POC CONTACT CHECK =====
                    if (!empty($poc_contact)) {
                        $exists = $this->db
                            ->where('contact', $poc_contact)
                            ->get('tracker_poc')
                            ->row();
                
                        if ($exists) {
                            $this->session->set_flashdata(
                                'register-message',
                                '<div class="alert alert-warning alert-dismissible fade show">
                                    <strong>Warning!</strong> POC mobile number already exists.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>'
                            );
                            redirect('profile');
                            return;
                        }
                    }
    
                if (!empty($poc_name)) {
                    $data_poc[] = [
                        'name'        => trim($poc_name),
                        'designation' => $poc_designations[$key] ?? '',
                        'contact'     => $poc_contact ?? ''
                    ];
                }
            }
        }
    }
    
    // ================= POC DATA =================
    $data_hospital = [];
    $h_names = $this->input->post('h_name');
    if (!empty($h_names)) {

        $h_cities = $this->input->post('h_city');
        foreach ($h_names as $key => $h_name) {
            if (!empty($h_name)) {
                $data_hospital[] = [
                    'hospital_name' => trim($h_name),
                    'city'          => $h_cities[$key] ?? ''
                ];
            }
        }
    }


    // ================= PROFILE ID =================
    $profile_type = strtolower($this->input->post('profile_type'));

    $codes = [
        'doctor' => 'DR',
        'hr' => 'HR',
        'pharmacy' => 'PH',
        'lab' => 'LB',
        'apartment' => 'AT',
        'clubs' => 'CB',
        'society' => 'SC',
        'visiting-consultant' => 'VC',
    ];

    $profile_code = $codes[$profile_type] ?? 'OT';
    $year = date('Y');

    $name_code = strtoupper(substr(preg_replace('/\s+/', '', $this->input->post('name')), 0, 2));
    $mobile_code = substr(preg_replace('/\D/', '', $contact), -2);
    $random = rand(100000, 999999);

    $profile_id = $profile_code . $year . $name_code . $mobile_code . $random;

    // ================= MAIN PROFILE DATA =================
    $data = [
        'created_by'       => $login_id,
        'profile_type'     => $this->input->post('profile_type'),
        'profile_id'       => $profile_id,
        'name'             => $this->input->post('name'),
        'contact'          => $contact,
        'doctor_address'   => $this->input->post('address'),
        'pincode'          => $this->input->post('pincode'),
        'emp_no'           => $this->input->post('emp_no'),
        'location'         => $location,
        'poc_no'           => $this->input->post('poc_no'),
        'poc'              => json_encode($data_poc, JSON_UNESCAPED_UNICODE),
        'hospital'         => json_encode($data_hospital, JSON_UNESCAPED_UNICODE),
        'company_name'     => $this->input->post('company_name'),
        'valid_from'       => $this->input->post('valid_from'),
        'valid_to'         => $this->input->post('valid_to'),
        'visit_done'      => $this->input->post('visit_known'),
        'created_at'       => date('Y-m-d H:i:s'),
        'state'             => $this->input->post('state'),
        'city'              => $this->input->post('city'),
    ];

    if ($profile_type === 'doctor' || $profile_type === 'visiting-consultant') {
        $data['degree']       = $this->input->post('degree');
        $data['specialty']    = $this->input->post('specialty');
        $data['experience']   = $this->input->post('experience');
        $data['dob']          = $this->input->post('dob');
        $data['doa']          = $this->input->post('doa');
        $data['opd']          = $this->input->post('opd');
        $data['ipd']          = $this->input->post('ipd');
        $data['dr_grade']     = $this->input->post('dr_grade');
        $data['other_detail'] = $this->input->post('other_detail');
        $data['social_media'] = json_encode($social_media);
    }

    // ================= TRANSACTION START =================
    $this->db->trans_start();

    // INSERT PROFILE
    $this->db->insert('tracker_profile_form', $data);

    // INSERT POC
    foreach ($data_poc as $poc) {
        $this->db->insert('tracker_poc', [
            'profile_id' => $profile_id,
            'name'       => $poc['name'],
            'designation'=> $poc['designation'],
            'contact'    => $poc['contact'],
            'status'     => 1,
            'created_by' => $login_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    

    // ================= VISIT INSERT =================
    if ($this->input->post('visit_known') == 'yes') {
        
       /* ---------- IMAGE UPLOAD ---------- */
       if (!empty($_POST['img_base64'])) {

        $data = $_POST['img_base64'];
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $data = base64_decode($data);

        $img_name = 'visit-' . time() . '.webp';

        $path = FCPATH . 'assets/images/visit/';
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $img_name, $data);
        }
        
        $visit_data = [
            'profile_id'         => $profile_id,
            'image'              => $img_name,
            'location'         => $location,
            // 'name'               => $this->input->post('name'),
            'contact'            => $contact,
            'date'               => date('Y-m-d', strtotime($this->input->post('visit_date'))),
            'visit_time'         => $this->input->post('visit_time'),
            'discussion'         => $this->input->post('discussion'),
            'discussion_pointer' => $this->input->post('discussion_pointer'),
            'follow_up_date'     => !empty($this->input->post('follow_up_date'))
                                    ? date('Y-m-d', strtotime($this->input->post('follow_up_date')))
                                    : NULL,
            'created_by'         => $login_id,
            'created_at'         => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tracker_visit_form', $visit_data);
    }

    // ================= TRANSACTION END =================
    $this->db->trans_complete();

    // ================= RESPONSE =================
    if ($this->db->trans_status()) {
        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Profile saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
    } else {
        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
    }

    redirect('profile');
}

    public function update_profile()
{
    $login_id = $this->session->userdata('login_id');
    if (!$login_id) redirect(base_url());

    $profile_id = $this->input->post('profile_id');

    // ================= MAIN DATA =================
    $data = [
        'name'       => $this->input->post('name'),
        'contact'    => $this->input->post('contact'),
        'emp_no'     => $this->input->post('emp_no'),
        'company_name'=> $this->input->post('company_name'),
        'valid_from' => $this->input->post('valid_from'),
        'valid_to'   => $this->input->post('valid_to'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // ================= DOCTOR EXTRA =================
    if ($this->input->post('profile_type') == 'doctor') {
        $data['degree']     = $this->input->post('degree');
        $data['specialty']  = $this->input->post('specialty');
        $data['experience'] = $this->input->post('experience');

        $data['social_media'] = json_encode([
            'whatsapp'  => $this->input->post('whatsapp'),
            'facebook'  => $this->input->post('facebook'),
            'instagram' => $this->input->post('instagram'),
            'linkedin'  => $this->input->post('linkedin')
        ]);
    }

    $this->db->trans_start();

    $this->db
        ->where('profile_id', $profile_id)
        ->where('created_by', $login_id)
        ->update('tracker_profile_form', $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        $this->session->set_flashdata('register-message',
            '<div class="alert alert-success">Profile Updated Successfully</div>');
    } else {
        $this->session->set_flashdata('register-message',
            '<div class="alert alert-danger">Update Failed</div>');
    }

    redirect('profile');
}

    
    public function save_in_house(){
        
        // echo "<pre>";
        // print_r($_FILES);
        // print_r($_POST);
        // exit;
        // I want that if the user logged in once through their mobile , so wo app band hone ke baad dusri baar open krne pr login na maange or agr user ne ek phone see login kiya he or dusre phone se bhi same id password se login kr rha he to past waale ka session out ho jaye 
        $login_id = $this->session->userdata('login_id');
        
        /*================= Image Upload Section ==================*/ 
            
    $img_name = null;

    if (!empty($_POST['img_base64'])) {

        $data = $_POST['img_base64'];
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $data = base64_decode($data);

        $img_name = 'in-house-meeting-' . time() . '.webp';

        $path = FCPATH . 'assets/images/in_house/';
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $img_name, $data);
    }
        
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'meeting'         => $this->input->post('meeting'),
            'name'    => $this->input->post('name'),
            'room_no'    => $this->input->post('room_no'),
            'uhid' =>$this->input->post('uhid'),
            'date'         => $this->input->post('date'),
            'from_time'            => $this->input->post('from_time'),
            'to_time'         => $this->input->post('to_time'),
            'image'              => $img_name,
            'mom'            => $this->input->post('mom')
        ];
         
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_in_house_working', $data)) {
            $this->session->set_flashdata('login-message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success!</strong> In House Meetings Saved Successfully. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('in-house');
        } else {
            $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> Something went wrong. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('in-house');
            
        }
    }
    
    public function search(){
        $text = $this->input->post('text');
    
        if(strlen($text) < 3){
            echo json_encode([]);
            return;
        }
    
        $this->db->like('name', $text);
        $this->db->limit(5);
        $query = $this->db->get('tracker_profile_form');
    
        $data = [];
        foreach($query->result() as $row){
            $data[] = $row->name;
        }
    
        echo json_encode($data);
    }
    
    public function search_profile_id(){
        $text = $this->input->post('text');
    
        if(strlen($text) < 3){
            echo json_encode([]);
            return;
        }
    
        $this->db->like('name', $text);
        $this->db->limit(5);
        $query = $this->db->get('tracker_profile_form');
    
        $data = [];
        foreach($query->result() as $row){
            $data[] = $row->name;
        }
    
        echo json_encode($data);
    }   

    /*------------------ Save Upcountry -----------------*/ 
    public function save_upcountry()
    { 
        $login_id = $this->session->userdata('login_id');
        
         if (!empty($_POST['img_base64'])) {

        $data = $_POST['img_base64'];
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $data = base64_decode($data);

        $img_name = 'upcountry-' . time() . '.webp';

        $path = FCPATH . 'assets/images/upcountry/';
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . $img_name, $data);
        }
        
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'     => $login_id,
            'no_of_people' =>$this->input->post('no_of_people'),
            'start_date'         => $this->input->post('start_date'),
            'end_date'    => $this->input->post('end_date'),
            'tour_city'    => $this->input->post('tour_city'),
            'tour_type'         => $this->input->post('tour_type'),
            'other_tour_type'  => $this->input->post('other_tour_type'),
            'travel_by'         => $this->input->post('travel_by'),
            'image' => $img_name,
        ];
         
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_upcountry', $data)) {
            $this->session->set_flashdata(
            'register-message', 
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Upcountry saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
          redirect('upcountry');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
            redirect('upcountry');
        }

    }
    
    /*------------------ Save Event -----------------*/ 
    public function save_event()
    { 
       
        $login_id = $this->session->userdata('login_id');
    
        // Multi Select Agents
        $person_involved = $this->input->post('person_involved');
    
        // Array to comma separated string
        $person_involved_data = !empty($person_involved) ? implode(',', $person_involved) : '';
        
        // Image upload
        $event_image = '';

        if(!empty($_FILES['event_image']['name'])){
    
            // Event title slug
            $event_title = $this->input->post('event_title');
    
            // remove spaces + special chars
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-',strtolower(trim($event_title)));
            // extension
            $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
    
            // final file name
            $file_name = $slug . '-' . time() . '.' . $ext;
    
            // upload path
            $upload_path = 'assets/images/events/';
    
            // create folder if not exists
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
    
            // move upload
            if(move_uploaded_file($_FILES['event_image']['tmp_name'], $upload_path.$file_name)){
                $event_image = $file_name;
            }
        }
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'        => $login_id,
            'event_type'        => $this->input->post('event_type'),
            'event_title'        => $this->input->post('event_title'),
            'event_purpose'     => $this->input->post('event_purpose'),
            'event_date'        => $this->input->post('event_date'),
            'end_date'          => $this->input->post('end_date'),
            'state'             => $this->input->post('state'),
            'city'              => $this->input->post('city'),
            'audience_target'   => $this->input->post('audience_target'),
            'prospect_expected' => $this->input->post('prospect_expected'),
            'person_involved'   => $person_involved_data,
            'manager_involved'  => $this->input->post('manager_involved'),
            'event_image'       => $event_image
        ];
         
        // print_r($data);exit;
 
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_event', $data)) {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Event saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
         );
          redirect('event');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
            redirect('event');
        }

    }
    
        /*------------------ Update Event -----------------*/ 
    public function update_event()
    { 
        
        $login_id = $this->session->userdata('login_id');
        $id = $this->input->post('id'); //event id
        // Multi Select Agents
        $person_involved = $this->input->post('person_involved');
        // Array to comma separated string
        $person_involved_data = !empty($person_involved) 
            ? implode(',', $person_involved) 
            : '';
        /* ---------- OLD IMAGE ---------- */
        $old_image = $this->input->post('old_event_image');
        /* ---------- IMAGE UPLOAD ---------- */
        $event_image = $old_image;
    
        if(!empty($_FILES['event_image']['name'])){
    
            // Event title slug
            $event_title = $this->input->post('event_title');
    
            // remove spaces + special chars
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(trim($event_title)));
    
            // extension
            $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
    
            // final file name
            $file_name = $slug . '-' . time() . '.' . $ext;
    
            // upload path
            $upload_path = 'assets/images/events/';
    
            // create folder if not exists
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
    
            // move upload
            if(move_uploaded_file($_FILES['event_image']['tmp_name'], $upload_path.$file_name)){
    
                // delete old image
                if(!empty($old_image) && file_exists($upload_path.$old_image)){
                    unlink($upload_path.$old_image);
                }
    
                $event_image = $file_name;
            }
        }
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'        => $login_id,
            'event_type'        => $this->input->post('event_type'),
            'event_title'       => $this->input->post('event_title'),
            'event_purpose'     => $this->input->post('event_purpose'),
            'event_date'        => $this->input->post('event_date'),
            'end_date'          => $this->input->post('end_date'),
            'state'             => $this->input->post('state'),
            'city'              => $this->input->post('city'),
            'audience_target'   => $this->input->post('audience_target'),
            'prospect_expected' => $this->input->post('prospect_expected'),
            'person_involved'   => $person_involved_data,
            'manager_involved'  => $this->input->post('manager_involved'),
            'event_image'       => $event_image
        ];
    
        /* ---------- UPDATE ---------- */
        $this->db->where('id', $id);
    
        if ($this->db->update('tracker_event', $data)) {
    
            $this->session->set_flashdata(
                'register-message',
                '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> Event updated successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
    
            redirect('event-created');
    
        } else {
    
            $this->session->set_flashdata(
                'register-message',
                '<div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
    
            redirect('event-created');
        }
    }
    
public function get_poc_by_profile()
{
    $profile_id = $_POST['profile_id'] ?? null;

    $pocs = $this->Common_model->getPocByProfileId($profile_id);

    header('Content-Type: application/json');
    echo json_encode($pocs);
    exit;
}



 
}
?>