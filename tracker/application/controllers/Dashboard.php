<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Dashboard extends CI_Controller
{
    function __construct()
{
    parent::__construct();

    $this->load->helper(['url','common_helper']);
    $this->load->model('Common_model');

    // // Skip check for login pages
    // $current_method = $this->router->fetch_method();
    // $skip_methods = ['index','login','check_login'];

    // if(in_array($current_method, $skip_methods)){
    //     return;
    // }

    // // If not logged in
    // if(!$this->session->userdata('login_id')){
    //     redirect('login');
    // }

    // // Device check
    // $login_id = $this->session->userdata('login_id');
    // $session_token = $this->session->userdata('device_token');

    // $db_token = $this->db->select('device_token')
    //                      ->where('id', $login_id)
    //                      ->get('tracker_login')
    //                      ->row();
    
    // if($db_token && $db_token->device_token !== $session_token){

    // $this->session->sess_destroy();

    // echo "<script>
    //         alert('You have logged in to another device');
    //         window.location.href = '".base_url('login')."';
    //       </script>";
    //       exit;
    // redirect('login');
// }

}

    /*------------Profile Created List Agent Wise -------------*/ 
    public function profile_created(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id');
            // dates from url
            $from = $this->input->get('from');
            $to   = $this->input->get('to');
        
           
            if (empty($from) || empty($to)) {
                $from = date('Y-m-01');   
                $to   = date('Y-m-d');   
            }
        
            $data['from'] = $from;
            $data['to']   = $to;
        
            $data['get_data'] = getAllDataByIdNew('tracker_profile_form', $login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/profile_created_by_agent',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------Edit Profile List Agent Wise -------------*/ 
public function edit_profile($id)
{
    if (empty($this->session->userdata('login_id'))) {
        redirect(base_url());
    }

    // if (empty($id)) {
    //     show_404();
    // }

    $login_id = $this->session->userdata('login_id');
    $profile_id = $id;
    $profile = $this->db
        ->where('id', $id)
        ->where('created_by', $login_id)
        ->get('tracker_profile_form')
        ->row();



    // Decode JSON safely
    $profile->poc      = json_decode($profile->poc, true);
    $profile->hospital = !empty($profile->hospital) ? json_decode($profile->hospital, true) : [];
    $profile->social   = !empty($profile->social_media) ? json_decode($profile->social_media, true) : [];

    $data['profile'] = $profile;

    $this->load->view('common/header');
    $this->load->view('common/main_header');
    $this->load->view('forms/edit_profile', $data);
    $this->load->view('common/footer-new');
}

public function update_profile()
{
    $login_id   = $this->session->userdata('login_id');
    $profile_id = $this->input->post('profile_id');

    /*⃣ OLD DATA */
    $old = $this->db
        ->where('profile_id', $profile_id)
        ->get('tracker_profile_form')
        ->row_array();

    if (!$old) {
        show_404();
    }

    /* NEW DATA (Form se) */
    $new = [
        'name' => $this->input->post('name'),
        'contact' => $this->input->post('contact'),
        
    ];

    /* UPDATE QUERY */
    $this->db->where('profile_id', $profile_id)
             ->update('tracker_profile_form', $new);


    $log = [
        'table_name' => 'tracker_profile_form',
        // 'record_id'  => $profile_id,
        'action'     => 'update',
        'old_data'   => json_encode($old),
        'new_data'   => json_encode($new),
        'changed_by' => $login_id,
        'ip_address' => $this->input->ip_address()
    ];

    $this->Common_model->save_log($log);

    redirect('profile-created');
}

    /*------------Visit Created List Agent Wise -------------*/ 
    public function visit_created(){
         if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getVisitDataById($login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/visit_created_by_agent',$data);
            $this->load->view('common/footer-new');
    }
    
    /*------------POC Created List Agent Wise -------------*/ 
    public function poc_created(){
         if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_poc', $login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/poc_created_by_agent',$data);
            $this->load->view('common/footer-new');
    } 

    /*------------Healthcheckup List Agent Wise -------------*/ 
    public function healthcheckup_created(){
        if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_patient', $login_id, $from, $to, 'Healthcheckup');
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/healthcheckup_created_by_agent',$data);
            $this->load->view('common/footer-new');
        
    }
    
    /*------------ IPD List Agent Wise -------------*/ 
    public function ipd_created(){
        if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_patient', $login_id, $from, $to, 'IPD');
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/ipd_created_by_agent',$data);
            $this->load->view('common/footer-new');
        
    }
    
    /*------------ OPD List Agent Wise -------------*/ 
    public function opd_created(){
        if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_patient', $login_id, $from, $to, 'OPD');
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/opd_created_by_agent',$data);
            $this->load->view('common/footer-new');
        
    }

    public function admission_created()
    {
       if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_admission', $login_id, $from, $to);
        // print_r($data);exit;
        $this->load->view('common/header');
        $this->load->view('common/main_header');
        $this->load->view('dashboard/admission_created_by_agent', $data);
        $this->load->view('common/footer-new');
    }

    
    /*------------Bookings Created List Agent Wise -------------*/ 
    public function booking_created(){
        if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_booking', $login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/booking_created_by_agent',$data);
            $this->load->view('common/footer-new');   
    }
    
    /*------------In House Meetings Created List Agent Wise -------------*/ 
    public function inhousemeetings_created(){
         if (empty($this->session->userdata('login_id'))) { 
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_in_house_working', $login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/inHouseMeetings_created_by_agent',$data); 
            $this->load->view('common/footer-new');
    }
    
    /*------------ Agreement Preparation List Agent Wise -------------*/ 
    public function agreement_preparation_created(){
         if (empty($this->session->userdata('login_id'))) { 
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAllDataByIdNew('tracker_operation', $login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/agreement_preparation_created_by_agent',$data); 
            $this->load->view('common/footer-new');
    } 
    
    /*------------ Event List Agent Wise -------------*/  
    public function event_created(){
         if (empty($this->session->userdata('login_id'))) { 
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
        $data['state'] = get_all_states();
        $data['get_data'] = getEventCreatedData($login_id, $from, $to);
        // print_r($data['get_data']);
        // exit;
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/event_created_by_agent',$data); 
            $this->load->view('common/footer-new');
    } 
    
    /*------------ Event Customer Lead Form Save-------------*/  
    public function save_customer_lead()
    {
        $login_id = $this->session->userdata('login_id');
    
        $data = [
            'event_id'       => $this->input->post('event_id'),
            'lead_type'       => $this->input->post('lead_type'),
            'lead_for'        => $this->input->post('lead_for'),
            'customer_name'   => $this->input->post('customer_name'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'state'           => $this->input->post('state'),
            'city'            => $this->input->post('city'),
            'follow_up_date'  => $this->input->post('followup_date'),
            'remark'          => $this->input->post('remark'),
            'created_by'      => $login_id,
            'created_at'      => date('Y-m-d H:i:s'),
            'status'          => 1
        ];
    
        // print_r($data); exit;
    
        if($this->db->insert('tracker_event_customer_leads', $data))
        {
            $this->session->set_flashdata(
                'register-message',
                '<div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> Customer lead saved successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
        }
        else
        {
            $this->session->set_flashdata(
                'register-message',
                '<div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>'
            );
        }
    
        redirect('event-created');
    }
    
    /*------------ Upcountry Event List that shows all agents -------------*/  
    public function upcountry_event(){
         if (empty($this->session->userdata('login_id'))) { 
            redirect(base_url());
        }
        $data['events'] = getAllEvent();

            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/upcountry_event',$data); 
            $this->load->view('common/footer-new');
    } 
    
    /*------------ Daily Plan List -------------*/ 
    public function daily_plan_list(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id'); 
            $data['plans'] = getDailyPlanId($login_id);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/daily_plan_created_by_agent',$data);
            $this->load->view('common/footer-new');
        }    
    }
    
    /*------------ Latest News & Updates -------------*/ 
    public function latest_updates(){
        if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
        }else{
            $login_id = $this->session->userdata('login_id'); 
            // print_r($data);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/latest_updates');
            $this->load->view('common/footer-new');
        }    
    }
    
  public function toggleFavourite()
    {
    $login_id = $this->session->userdata('login_id');
    $update_id = $this->input->post('update_id');
    $check = $this->db->where('update_id',$update_id)->where('created_by',$login_id)->get('tracker_favourites')->row();

    // REMOVE
    if($check){

        $this->db->where('update_id',$update_id)->where('created_by',$login_id)->delete('tracker_favourites');
        echo json_encode([
            'status' => 'removed'
        ]);

    }else{
        // ADD
        $this->db->insert('tracker_favourites',['update_id' => $update_id,'created_by' => $login_id]);
        echo json_encode([
            'status' => 'added'
        ]);
        // redirect('latest-updates');
    }
}

/*------------ Attendance List Agent Wise -------------*/ 
    public function attendance_list(){
        if (empty($this->session->userdata('login_id'))) {
            redirect(base_url());
        }
    
        $login_id = $this->session->userdata('login_id');
    
        
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
    
       
        if (empty($from) || empty($to)) {
            $from = date('Y-m-01');   
            $to   = date('Y-m-d');   
        }
    
        $data['from'] = $from;
        $data['to']   = $to;
    
        $data['get_data'] = getAttendanceDataById($login_id, $from, $to);
            $this->load->view('common/header');
            $this->load->view('common/main_header');
            $this->load->view('dashboard/attendance_list',$data);
            $this->load->view('common/footer-new');
        
    }
    
}