<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");

class Home extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url']);
    $this->load->model('Common_model');
    $this->config->load('custom_config');

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
 
   
     public function loader(){
      $this->load->view('common/header');
        $this->load->view('common/main_header');
        $this->load->view('common/loader');  
    }
    
    public function doctor_profile(){
    //if session Id empty then it will redirect to login page 
    if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
     }else{
        $data['username']=$this->session->userdata('user_name');
        // $data['countries'] = getCountriesById();
        // $data['state']=getStateByCountry('101');
        $this->load->view('common/header');
        $this->load->view('common/main_header',$data);
        $this->load->view('doctor_profile',$data);
        $this->load->view('common/footer-new');
     }
    }
    
    /*----------AJAX----------*/
    public function get_state_city_ajax() {
    
        $type = $this->input->post('type');  
    
        // Load States
        if ($type == "getStates") {
    
            $country_id = $this->input->post('country_id');
            $states = getStateByCountry($country_id);
    
            echo json_encode($states);
            return;
        }
    
        // Load Cities
        if ($type == "getCities") {
    
            $state_id = $this->input->post('state_id');
            $cities = getCityByState($state_id);
    
            echo json_encode($cities);
            return;
        }
    }
    
    public function save_profile()
{
    date_default_timezone_set("Asia/Kolkata");

    /* ---------- AUTH ---------- */
    $login_id = $this->session->userdata('login_id');
    if (!$login_id) {
        redirect(base_url());
    }

    /* ---------- BASIC INPUT ---------- */
    $profile_type = strtolower($this->input->post('profile_type'));
    $contact      = trim($this->input->post('contact'));
    $name         = trim($this->input->post('name'));
    $visit        = $this->input->post('visit_known');

    /* ---------- LOCATION (JSON STRING) ---------- */
    $location = $this->input->post('location');

    /* ---------- SOCIAL MEDIA ---------- */
    $social_media = [
        'whatsapp'   => $this->input->post('whatsapp'),
        'facebook'   => $this->input->post('facebook'),
        'instagram'  => $this->input->post('instagram'),
        'linkedinId' => $this->input->post('linkedin'),
    ];

    /* ---------- REF DOCTORS ---------- */
    $ref_doctor = [
        'doctor_1' => $this->input->post('doctor_1'),
        'doctor_2' => $this->input->post('doctor_2'),
        'doctor_3' => $this->input->post('doctor_3'),
        'doctor_4' => $this->input->post('doctor_4'),
    ];

    /* ---------- PROFILE ID GENERATION ---------- */
    $profile_code = 'OT';
    if ($profile_type == 'doctor') $profile_code = 'DR';
    elseif ($profile_type == 'hr') $profile_code = 'HR';
    elseif ($profile_type == 'pharmacy') $profile_code = 'PH';
    elseif ($profile_type == 'lab') $profile_code = 'LB';

    $year        = date('Y');
    $name_code   = strtoupper(substr(preg_replace('/\s+/', '', $name), 0, 2));
    $mobile_code = substr(preg_replace('/\D/', '', $contact), -2);
    $random      = rand(100000, 999999);

    $profile_id = $profile_code . $year . $name_code . $mobile_code . $random;

    /* ---------- COMMON PROFILE DATA ---------- */
    $data = [
        'created_by'   => $login_id,
        'profile_type' => $profile_type,
        'profile_id'   => $profile_id,
        'name'         => $name,
        'contact'      => $contact,
        'location'     => $location,
        'visit_done'   => $visit,
        'created_at'   => date('Y-m-d H:i:s')
    ];

    /* ---------- DOCTOR EXTRA DATA ---------- */
    if ($profile_type == 'doctor') {
        $data += [
            'degree'               => $this->input->post('degree'),
            'specialty'            => $this->input->post('specialty'),
            'experience'           => $this->input->post('experience'),
            'dob'                  => $this->input->post('dob'),
            'doa'                  => $this->input->post('doa'),
            'doctor_address'       => $this->input->post('doctor_address'),
            'pincode'              => $this->input->post('pincode'),
            'first_follow_up_date' => $this->input->post('first_follow_up_date'),
            'other_detail'         => $this->input->post('other_detail'),
            'opd'                  => $this->input->post('opd'),
            'ipd'                  => $this->input->post('ipd'),
            'dr_grade'             => $this->input->post('dr_grade'),
            'ref_doctor'           => json_encode($ref_doctor),
            'social_media'         => json_encode($social_media),
        ];
    }

    /* ---------- HR EXTRA DATA ---------- */
    if ($profile_type == 'hr') {
        $data['company_name'] = $this->input->post('company_name');
    }

    /* ---------- DB TRANSACTION ---------- */
    $this->db->trans_start();

    // Insert profile
    $this->Common_model->tableInsert('tracker_profile_form', $data);

    /* ---------- VISIT DATA ---------- */
    if ($visit == 'yes') {

        $visit_date     = $this->input->post('visit_date');
        $follow_up_date = $this->input->post('follow_up_date');

        $visit_data = [
            'profile_id'         => $profile_id,
            'name'               => $name,
            'contact'            => $contact,
            'date'               => !empty($visit_date) ? date('Y-m-d', strtotime($visit_date)) : NULL,
            'visit_time'         => $this->input->post('visit_time'),
            'discussion'         => $this->input->post('discussion'),
            'discussion_pointer' => $this->input->post('discussion_pointer'),
            'follow_up_date'     => !empty($follow_up_date) ? date('Y-m-d', strtotime($follow_up_date)) : NULL,
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $this->Common_model->tableInsert('tracker_visit_form', $visit_data);
    }

    $this->db->trans_complete();

    /* ---------- RESPONSE ---------- */
    if ($this->db->trans_status() === TRUE) {
        $this->session->set_flashdata('success', 'Profile & Visit saved successfully');
    } else {
        $this->session->set_flashdata('error', 'Something went wrong');
    }

    redirect('tracker/doctor-profile');
}

    
    public function visit(){
        if(empty($this->session->userdata('login_id'))){
            redirect(base_url().'tracker'); 
         }else{
            $login_id = $this->session->userdata('login_id');
            $data['profile_id']=getProfileId($login_id);
            // print_r($data); 
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('visit',$data);
            $this->load->view('common/footer-new');
         }
    }
    
      public function visitDemo(){
        if(empty($this->session->userdata('login_id'))){
            redirect(base_url().'tracker'); 
         }else{
            $login_id = $this->session->userdata('login_id');
            $data['profile_id']=getProfileId($login_id);
            // print_r($data); 
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('visit_demo',$data);
            $this->load->view('common/footer-new');
         }
    }
    
    public function save_visit_demo(){
         $login_id = $this->session->userdata('login_id');
    
        /* ---------- LOCATION ---------- */
        // JSON string from hidden input
        $location = $this->input->post('location');
    
        // Safety fallback
        if (empty($location)) {
            $location = NULL;
        }
    
        // ---------- IMAGE ----------
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
    
        /* ---------- DATE FORMATTING ---------- */
        $date = $this->input->post('date');
        $follow_up_date = $this->input->post('follow_up_date');
    
        $date = !empty($date) ? date('Y-m-d', strtotime($date)) : NULL;
        $follow_up_date = !empty($follow_up_date) ? date('Y-m-d', strtotime($follow_up_date)) : NULL;
    
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
        }
       
       
       
       
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'         => $login_id,
            'profile_id'         => $this->input->post('profile_id'),
            'contact'            => $this->input->post('contact'),
            'poc_id'            =>  $pocId,
            'date'               => $date,
            'visit_time'         => $this->input->post('visit_time'),
            'discussion'         => $this->input->post('discussion'),
            'discussion_pointer' => $this->input->post('discussion_pointer'),
            'follow_up_date'     => $follow_up_date,
            'image'              => $img_name,
            'location'           => $location,
            'created_at'         => date('Y-m-d H:i:s'),
            'status'=>'1',
        ];
        
    
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_visit_form', $data)) {
           
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Visit saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
            redirect('visit');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Something went wrong.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
              redirect('visit');
        }
    }
    
    
    public function save_visit()
    {
        
        // echo "<pre>";
        // print_r($_FILES);
        // print_r($_POST);
        // exit;
        $login_id = $this->session->userdata('login_id');
    
        /* ---------- LOCATION ---------- */
        // JSON string from hidden input
        $location = $this->input->post('location');
    
        // Safety fallback
        if (empty($location)) {
            $location = NULL;
        }
    
        // ---------- IMAGE ----------
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
    
        /* ---------- DATE FORMATTING ---------- */
        $date = $this->input->post('date');
        $follow_up_date = $this->input->post('follow_up_date');
    
        $date = !empty($date) ? date('Y-m-d', strtotime($date)) : NULL;
        $follow_up_date = !empty($follow_up_date) ? date('Y-m-d', strtotime($follow_up_date)) : NULL;
    
        /* ---------- DATA ARRAY ---------- */
        $data = [
            'created_by'         => $login_id,
            'profile_id'         => $this->input->post('profile_id'),
            'contact'            => $this->input->post('contact'),
            'poc_id'            => $this->input->post('poc_select'),
            'date'               => $date,
            'visit_time'         => $this->input->post('visit_time'),
            'discussion'         => $this->input->post('discussion'),
            'discussion_pointer' => $this->input->post('discussion_pointer'),
            'follow_up_date'     => $follow_up_date,
            'image'              => $img_name,
            'location'           => $location,
            'created_at'         => date('Y-m-d H:i:s'),
        ];
        
    
        /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_visit_form', $data)) {
           
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> Visit saved successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
            redirect('visit');
        } else {
            $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Something went wrong.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            );
              redirect('visit');
        }
    
    }
    
    
    
    public function get_contact_by_profileid()
    {
        $login_id = $this->session->userdata('login_id');
        $type = $this->input->post('type');
        $tablename = $this->input->post('tableName');

        // PROFILE ID -> CONTACT
        if ($type === "getContact") {

            $profile_id = $this->input->post('profile_id');

            $row = $this->db->select('contact')
                            ->from($tablename)
                            ->where('profile_id', $profile_id)
                            ->where('created_by', $login_id)
                            ->get()
                            ->row();

            echo json_encode([
                'contact' => $row->contact ?? ''
            ]);
            return;
        }

        // CONTACT -> PROFILE ID
        if ($type === "getProfile") {

            $contact = $this->input->post('contact');

            $row = $this->db->select('profile_id')
                            ->from($tablename)
                            ->where('contact', $contact)
                            ->where('created_by', $login_id)
                            ->get()
                            ->row();

            echo json_encode([
                'profile_id' => $row->profile_id ?? ''
            ]);
            return;
        }
    }
    
     /*------------Dashboard Creation -------------*/ 
    // public function dashboard()
    // {
    //     if (empty($this->session->userdata('login_id'))) {
    //         redirect(base_url());
    //     }else{
    //         $login_id = $this->session->userdata('login_id');
    //         // dates from url
    //         $from = $this->input->get('from');
    //         $to   = $this->input->get('to');
        
           
    //         if (empty($from) || empty($to)) {
    //             $from = date('Y-m-01');   
    //             $to   = date('Y-m-d');   
    //         }
        
    //         $data['from'] = $from;
    //         $data['to']   = $to;
        
    //         $data['target'] = getTargetById($login_id, $start_date, $end_date);
    //         $this->load->view('common/header');
    //         $this->load->view('common/main_header');
    //         $this->load->view('dashboard', $data);
    //         $this->load->view('common/footer-new');
    //     }
    // }

    public function dashboard()
    {
        if (empty($this->session->userdata('login_id'))) {

            redirect(base_url());
            exit;
        }
    
        $login_id = $this->session->userdata('login_id');
    
        /* ================= PUNCH CHECK ================= */
    
        $exists = $this->Common_model->checkTodayPunch($login_id);
    
        // if not punch in today
        if(!$exists){
    
            redirect('check-punch');
            exit;
        }
        /* ================= DATE FILTER ================= */
        
        // Get dates from URL
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
        // Default: 1st of current month → today
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');
            $to   = date('Y-m-d');
        }
    
        $data['login_id'] = $login_id;
        $data['from']     = $from;
        $data['to']       = $to;
    
        // IMPORTANT — pass from/to here
        $data['target'] = getTargetById($login_id, $from, $to);
    
        $this->load->view('common/header');
        $this->load->view('common/main_header');
        $this->load->view('dashboard', $data);
        $this->load->view('common/footer-new');
    }


    /*------------Profile Creation -------------*/ 
    public function profile(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $data['state'] = get_all_states();
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/profile',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------Profile Creation -------------*/ 
    public function edit_profile()
    {
        // $login_id = $this->session->userdata('login_id');
        // if (!$login_id) redirect(base_url());
    
        $profile = $this->db
            ->where('profile_id', $id)
            ->where('created_by', $login_id)
            ->get('tracker_profile_form')
            ->row();
    
        if (!$profile) {
            show_404();
        }
    
        // Decode JSON
        $profile->poc       = json_decode($profile->poc, true);
        $profile->hospital  = json_decode($profile->hospital, true);
        $profile->social    = json_decode($profile->social_media, true);
    
        $data['profile'] = $profile;
    
        $this->load->view('forms/edit_profile', $data);
    }

    
     /*------------Profile Creation -------------*/ 
    public function poc(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            // $data['profile_id']=getProfileId();
            $login_id = $this->session->userdata('login_id');
            $data['profile_id']=getProfileId($login_id);
            
            
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/poc',$data);
            $this->load->view('common/footer-new');
        }    
    }

    /*------------Patient Creation -------------*/ 
    public function patient(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
             $login_id = $this->session->userdata('login_id');
            $data['poc'] = $this->Common_model->getAllwhere('tracker_poc',array('status'=>'1', 'created_by' => $login_id),'all','','', '', '', null,null);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/patient',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------Target Creation -------------*/ 
    public function target(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/target');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------Time with senior Creation -------------*/ 
    public function senior_time(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/senior_time');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Operation Creation -------------*/ 
    public function operation(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/operation');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ IN house Working Creation -------------*/ 
    public function in_house(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/in_house');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ IN house Working Creation testing -------------*/ 
    public function in_house_test(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/in_house_test');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*----------- Target Achieved -------------*/ 
    public function target_achieved(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('target/target_achieved');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Booking -------------*/ 
    public function booking(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('target/booking');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Admission -------------*/ 
    public function admission(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('target/admission');
            $this->load->view('common/footer-new');
        }    
    }
    
     /*------------ Upcountry -------------*/ 
    public function upcountry(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/upcountry');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Event -------------*/ 
    public function event(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $data['event_types'] = $this->config->item('event_types');
            $data['state'] = get_all_states();
            $data['getAgentInvolved'] = $this->Common_model->getAgentInvolved($login_id);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/event',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Edit Event -------------*/ 
    public function edit_event($id){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id'); 
            // Event Details
            $data['event'] = $this->db->where('id', $id)->get('tracker_event')->row();
            // States
            $data['state'] = $this->db->get('states')->result();
            // Cities
            $data['cities'] = $this->db->where('state_id', $data['event']->state)->get('tb_cities')->result();
            // Event Types
            $data['event_types'] = $this->config->item('event_types');
            // Agents
            $data['getAgentInvolved'] = $this->Common_model->getAgentInvolved($login_id);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/edit_event',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Daily Plan -------------*/ 
    public function daily_plan(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id'); 
            $data['profile']=getProfileId($login_id);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/daily_plan',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ FollowUp Notification -------------*/ 
    public function followup_notification(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('today-pending-followup');
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Test Patient -------------*/ 
    public function test(){
        // if(empty($this->session->userdata('login_id'))){
        // redirect(base_url()); 
        // }else{
        $data['poc'] = $this->Common_model->getAllwhere('tracker_poc',array('status'=>'1'),'all','','', '', '', null,null);
        // print_r($data);exit;
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('forms/test-patient',$data);
            $this->load->view('common/footer-new');
        // }    
    }
    
    public function save_test(){
    
    $data_poc = [];
    $poc_types = $this->input->post('poc_type');
    $poc_names = $this->input->post('poc_name');
    $poc_contacts = $this->input->post('poc_contact');
    $poc_comment = $this->input->post('poc_comment');
    
    foreach ($poc_names as $key => $poc_name) {
            if (!empty($poc_name)) {
                $data_poc[] = [
                    'name'        => trim($poc_name),
                    'poc_type' => $poc_types[$key] ?? '',
                    'contact'     => $poc_contacts[$key] ?? '',
                    'comment'  => $poc_comment[$key] ?? ''
                ];
            }
        }
    // ================= MAIN DATA =================
    $data = [
        'created_by'       => $login_id,
        'team_name' =>$this->input->post('t_name'),
        'patient_name'         => $this->input->post('p_name'),
        'patient_contact'    => $this->input->post('p_contact'),
        'ref_by'    => $this->input->post('ref_by'),
        'name'              => json_encode($data_poc, JSON_UNESCAPED_UNICODE),
        'created_at'       => date('Y-m-d H:i:s')
    ];
    
    // echo "<pre>";
    // print_r($data); exit;
    
    /* ---------- INSERT ---------- */
        if ($this->db->insert('tracker_patient', $data)) {
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
    
    /*------------ Test Visit -------------*/ 
    
    public function test_visit(){

        if(empty($this->session->userdata('login_id'))){
            redirect(base_url().'tracker'); 
        }
    
        $profile_id = $this->input->get('profile_id');
    
        if($profile_id){
    
            $this->db->where('profile_id',$profile_id);
            $this->db->order_by('id','DESC');
            $this->db->limit(1);
    
            $data['visit'] = $this->db->get('tracker_visit_form')->row();
        }
    
        $this->load->view('common/header');
        $this->load->view('common/main_header');
        $this->load->view('test-visit',$data);
        $this->load->view('common/footer-new');
    }
    
     public function searchContact()
  {
    $login_id = $this->session->userdata('login_id');
    $keyword  = $this->input->post('keyword');

    $this->db->select('profile_id, name, contact');
    $this->db->from('tracker_profile_form');
    $this->db->where('created_by', $login_id);
    $this->db->like('contact', $keyword);
    $this->db->limit(10);

    echo json_encode($this->db->get()->result());
  }

  public function searchProfileName()
  {
    $login_id = $this->session->userdata('login_id');
    $keyword  = $this->input->post('keyword');

    $this->db->select('profile_id, name, contact');
    $this->db->from('tracker_profile_form');
    $this->db->where('created_by', $login_id);
    $this->db->like('name', $keyword);
    $this->db->limit(10);

    echo json_encode($this->db->get()->result());
  }
    
    
    /*============= AJAX MOBILE EXISTS OR NOT ON INPUT ===============*/ 
    
    public function check_mobile_exists()
    {
        $mobile = $this->input->post('mobile');

        if (!$mobile) {
            echo json_encode(['exists' => false]);
            return;
        }

        // Check tracker_profile_form
        $profile = $this->db
            ->where('contact', $mobile)
            ->get('tracker_profile_form')
            ->num_rows();

        // Check tracker_poc
        $poc = $this->db
            ->where('contact', $mobile)
            ->get('tracker_poc')
            ->num_rows();

        if ($profile > 0 || $poc > 0) {
            
                   if($profile){
                        //$profile_data = $this->db->where('contact', $mobile)->get('tracker_profile_form');
                        
                        $profile_data = $this->db
                                            ->select('tracker_profile_form.created_by, tracker_login.name')
                                            ->from('tracker_profile_form')
                                            ->join(
                                                'tracker_login',
                                                'tracker_login.id = tracker_profile_form.created_by',
                                                'left'
                                            )
                                            ->where('tracker_profile_form.contact', $mobile)
                                            ->get();
                
                            $row = $profile_data->row();
                            $name = $row->name;
                       } else if($poc){
                               //$poc_data = $this->db->where('contact', $mobile)->get('tracker_poc');
                               
                               $poc_data = $this->db
                                    ->select('tracker_poc.created_by, tracker_login.name')
                                    ->from('tracker_poc')
                                    ->join(
                                        'tracker_login',
                                        'tracker_login.id = tracker_poc.created_by',
                                        'left'
                                    )
                                    ->where('tracker_poc.contact', $mobile)
                                    ->get();
                               
                               $row = $poc_data->row();
                               $name = $row->name;
                       } else {
                           $name = 'No Name Found'; 
                       } 
            
            
            echo json_encode([
                'exists'  => true,
                'message' => 'Mobile number already exists with Ex. '.$name
            ]);
        } else {
            echo json_encode(['exists' => false]);
        }
    }
    
    public function getAllFilteredData()
    {
        $login_id = $this->session->userdata('login_id');
        $search   = $this->input->post('search');
        $from     = $this->input->post('from');
        $to       = $this->input->post('to');
    
        $this->db->from('tracker_patient')
                 ->where('created_by', $login_id);
    
        if ($search) {
            $this->db->group_start()
                     ->like('patient_name', $search)
                     ->or_like('patient_contact', $search)
                     ->or_like('team_name', $search)
                     ->group_end();
        }
    
        if ($from && $to) {
            $this->db->where('DATE(created_at) >=', $from);
            $this->db->where('DATE(created_at) <=', $to);
        }
    
        $data = $this->db->order_by('id','DESC')->get()->result();
    
        $this->load->view('ajax/all_table_rows', ['data'=>$data]);
    }
    
    public function getTodayFilteredData()
    {
        $login_id = $this->session->userdata('login_id');
        $search   = $this->input->post('search');
    
        $this->db->from('tracker_patient')
                 ->where('created_by', $login_id)
                 ->where('DATE(created_at)', date('Y-m-d'));
    
        if ($search) {
            $this->db->group_start()
                     ->like('patient_name', $search)
                     ->or_like('patient_contact', $search)
                     ->or_like('team_name', $search)
                     ->group_end();
        }
    
        $data = $this->db->order_by('id','DESC')->get()->result();
    
        $this->load->view('ajax/today_table_rows', ['data'=>$data]);
    }


}
?>