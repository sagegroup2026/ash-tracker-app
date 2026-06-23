<?php
defined("BASEPATH") or exit("No direct script access allowed");
date_default_timezone_set("Asia/Kolkata");

class Auth extends CI_Controller
{
//   function __construct()
// {
//     parent::__construct();

//     $this->load->helper(['url']);
//     $this->load->model('Common_model');

//     // Skip check for login pages
//     $current_method = $this->router->fetch_method();
//     $skip_methods = ['index','login','check_login','register','save_register'];

//     if(in_array($current_method, $skip_methods)){
//         return;
//     }

//     // If not logged 
//     if(!$this->session->userdata('login_id')){
//         redirect('login');
//     }

//     // Device check
//     $login_id = $this->session->userdata('login_id');
//     $session_token = $this->session->userdata('device_token');

//     $db_token = $this->db->select('device_token')
//                          ->where('id', $login_id)
//                          ->get('tracker_login')
//                          ->row();

//     if($db_token && $db_token->device_token !== $session_token){

//         $this->session->sess_destroy();
    
//         echo "<script>
//                 alert('You have logged in to another device');
//                 window.location.href = '".base_url('login')."';
//               </script>";
//               exit;
//         redirect('login');
//     }
// }

 public function __construct()
    {
        parent::__construct();

        $this->load->helper(['url', 'cookie']);
        $this->load->model('Common_model');

        /* =====================================================
           AUTO LOGIN USING DEVICE TOKEN (COOKIE)
        ===================================================== */
        if (
            !$this->session->userdata('login_id') &&
            isset($_COOKIE['device_token'])
        ) {

            $device_token = $_COOKIE['device_token'];

            $user = $this->db
                ->where('device_token', $device_token)
                ->get('tracker_login')
                ->row();

            if ($user) {
                $this->session->set_userdata([
                    'login_id'     => $user->id,
                    'user_name'    => $user->name,
                    'device_token' => $device_token
                ]);
            }
        }

        /* =====================================================
           PUBLIC PAGES (NO LOGIN REQUIRED)
        ===================================================== */
        $current_method = $this->router->fetch_method();

        $skip_methods = [
            'index',
            'login',
            'check_login',
            'register',
            'save_register',
            'forgot_password',
            'verify_otp'
        ];

        if (in_array($current_method, $skip_methods)) {
            return;
        }

        /* =====================================================
           SESSION CHECK
        ===================================================== */
        if (!$this->session->userdata('login_id')) {
            redirect('login');
            exit;
        }

        /* =====================================================
           DEVICE VALIDATION (SINGLE DEVICE LOGIN)
        ===================================================== */
        $login_id      = $this->session->userdata('login_id');
        $session_token = $this->session->userdata('device_token');

        $db_token = $this->db
            ->select('device_token')
            ->where('id', $login_id)
            ->get('tracker_login')
            ->row();

        if ($db_token && $db_token->device_token !== $session_token) {

            $this->session->sess_destroy();

            echo "<script>
                    alert('You have logged in on another device');
                    window.location.href = '" . base_url('login') . "';
                  </script>";
            exit;
        }
    }

    

    public function index(){
        if($this->session->userdata('login_id')){
            redirect('dashboard');
        }else{
            $this->load->view('common/header');
            $this->load->view('auth/welcome');
        }
    }
    
    public function login(){
        if ($this->session->userdata('login_id')) {
            redirect('dashboard');
            exit;
        }
            $this->load->view('common/header');
            $this->load->view('Login');        
    }
    

    
    // public function check_login(){
    //     $email = $this->input->post('email');
    //     $password = encrypt_decrypt('encrypt', $this->input->post('password'));
        
    //   $check_email=check_email($email);
	   // if($check_email){
	   //     $check_password = check_email_password($email,$password);
	       
	   //     if($check_password){
	            
	   //         $data = get_user_data($email);
	   //         $this->session->set_userdata('login_id',$data->id);
	   //         $this->session->set_userdata('user_name',$data->name);
	   //        //$redirect_url = 'https://admin.apollosage.in/tracker/doctor-profile';
    //         //     echo " <script> window.location.href = '" . $redirect_url . "';</script>";
    //         redirect('dashboard');
	   //     }
	   // else{
	   //        $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> Password is incorrect. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //             redirect(base_url('login')); 
	   // }
	        
	   // }else{
	   //	      $this->session->set_flashdata('login-message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> Email is incorrect. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //             redirect(base_url('login')); 
	   // }
    // }
    
    
    public function check_login(){

    $email    = $this->input->post('email');
    $password = encrypt_decrypt('encrypt', $this->input->post('password'));
    $device_token = get_device_token();

    $user = $this->db->where('email', $email)->get('tracker_login')->row();

    if(!$user){
        $this->session->set_flashdata('login-message',
            '<div class="alert alert-danger">Email is incorrect</div>');
        redirect('login');
    }

    if($user->password != $password){
        $this->session->set_flashdata('login-message',
            '<div class="alert alert-danger">Password is incorrect</div>');
        redirect('login');
    }

    /* If user logged in on another device */
    if(!empty($user->device_token) && $user->device_token != $device_token){

        // Update new device token (logout old device)
        $this->db->where('id', $user->id)->update('tracker_login', [
            'device_token' => $device_token,
            'last_login'   => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('login-message',
            '<div class="alert alert-warning">
                You were logged out from previous device.
            </div>');
    }else{
        // Normal login
        $this->db->where('id', $user->id)->update('tracker_login', [
            'device_token' => $device_token,
            'last_login'   => date('Y-m-d H:i:s')
        ]);
    }

    // Create session
    $this->session->set_userdata(['login_id' => $user->id,'user_name'=> $user->name,'device_token' => $device_token
    ]);

    redirect('dashboard');
}

    
    /*---------------- SIGN IN -------------------*/
    
      public function register(){
        if($this->session->userdata('login_id')){
            redirect('dashboard');
        }else{
           $this->load->view('common/header');
           $this->load->view('auth/register'); 
        }
      }
      
    public function save_register()
{
    // Sanitize inputs
    $email   = trim($this->input->post('email'));
    $contact = trim($this->input->post('contact'));

    /* ================= CHECK DUPLICATE ================= */

    // Email already exists
    if (is_value_exists('tracker_login', 'email', $email)) {
        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Email already registered.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        redirect('register');
        exit;
    }

    // Mobile already exists
    if (is_value_exists('tracker_login', 'contact', $contact)) {
        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Mobile number already registered.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        redirect('register');
        exit;
    }

    /* ================= SAVE DATA ================= */

    $password = encrypt_decrypt("encrypt", $this->input->post('password'));

    $data = [
        'email'     => $email,
        'name'      => $this->input->post('name'),
        'contact'   => $contact,
        'password'  => $password,
        'team_type' => $this->input->post('team_type'),
        'farm_name' => $this->input->post('farm_name'),
        'role_id'   => 2
    ];

    $insert_id = create_data('tracker_login', $data);

    if ($insert_id) {

        // Set session
        $this->session->set_userdata('login_id', $insert_id);
        $this->session->set_userdata('user_name', $this->input->post('name'));

        $this->session->set_flashdata(
            'register-message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> User Registered Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );

        redirect('dashboard');
        exit;
    }

    /* ================= ERROR ================= */

    $this->session->set_flashdata(
        'register-message',
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Something went wrong.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>'
    );

    redirect('register');
    exit;
}
/*---------------- SIGN IN -------------------*/
    /*---------------- LOGOUT -------------------*/
public function logout(){
    $this->db->where('id', $this->session->userdata('login_id'))
             ->update('tracker_login', ['device_token' => NULL]);

    $this->session->sess_destroy();
    redirect('login');
}

public function forgot_password() {
			    $this->load->view('common/header');
				$this->load->view('auth/forgot_password');
}
			
public function verify_otp() {
	    $email = $this->input->post('email');
			    $otp = rand(1111,9999);
			    
			    $this->load->view('common/header');
				$this->load->view('auth/verify_otp');
				$this->load->view('common/footer');
				$this->load->view('common/footer-new');
}

/* ================= Punch In/Out Process ================= */
public function check_punch()
{
    $login_id = $this->session->userdata('login_id');

    if(!$login_id){
        redirect('login');
    }

    $exists = $this->Common_model->checkTodayPunch($login_id);
    // echo $this->db->last_query(); exit;
    // already punched
    if($exists){
        redirect('dashboard');
    }
    $this->load->view('common/header');
    $this->load->view('common/main_header');
    $this->load->view('attendance/punch_in');
    // $this->load->view('common/footer-new');
}

public function save_punch_in()
{
    $login_id = $this->session->userdata('login_id');
    if(!$login_id){
        redirect('login');
        exit;
    }

    $location = $this->input->post('location');

    // location mandatory
//   if(empty($location) || $location == '{"latitude":null,"longitude":null,"source":"unavailable"}'){
    
//         echo "
//         <script>
//             alert('Please turn on your location First');
//             window.history.back();
//         </script>
//         ";
    
//         exit;
//     }
    $exists = $this->Common_model->checkTodayPunch($login_id);

    if(!$exists){

        $data = [
            'in_time'      => date('Y-m-d H:i:s'),
            'created_by'   => $login_id,
            'created_at'   => date('Y-m-d H:i:s'),
            'in_lat_long'  => $location,
        ];
        // print_r($data);
        // exit;

        $this->db->insert('tracker_attendance', $data);
    }

    echo "
    <script>
        alert('Attendance Saved Successfully.');
        window.location.href='".base_url('dashboard')."';
    </script>
    ";
    exit;
}

public function save_punch_out()
{
    $login_id = $this->session->userdata('login_id');

    if(!$login_id){
        redirect('login');
        exit;
    }

    /* ---------- LOCATION ---------- */

    // $location = $this->input->post('location');

    // if(
    //     empty($location) ||
    //     strpos($location, '"latitude":null') !== false ||
    //     strpos($location, '"longitude":null') !== false
    // ){
    //     echo "
    //     <script>
    //         alert('Location is required.');
    //         window.history.back();
    //     </script>
    //     ";
    //     exit;
    // }

    /* =========================================
       GET TODAY PUNCH-IN ROW
    ========================================= */

    $today = date('Y-m-d');

    $attendance = $this->db
        ->where('created_by', $login_id)
        ->like('created_at', $today, 'after')
        ->get('tracker_attendance')
        ->row();

    /* =========================================
       NO PUNCH IN
    ========================================= */

    if(!$attendance){
    
        echo "
        <script>
            alert('Please Punch In First.');
            window.location.href='".base_url('dashboard')."';
        </script>
        ";
        exit;
    }

    /* =========================================
       ALREADY PUNCHED OUT
    ========================================= */

    if(!empty($attendance->out_time)){

        echo "
        <script>
            alert('You have already punched out today');
            window.location.href='".base_url('dashboard')."';
        </script>
        ";
        exit;
    }

    /* =========================================
       UPDATE SAME ROW
    ========================================= */

    $updateData = [
        'out_time'     => date('Y-m-d H:i:s'),
        'out_lat_long' => $location,
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    $this->db->where('id', $attendance->id);
    $this->db->update('tracker_attendance', $updateData);

    /* =========================================
       SUCCESS MESSAGE
    ========================================= */

    echo "
    <script>
        alert('Punch Out Saved. Successfully!');
        window.location.href='".base_url('dashboard')."';
    </script>
    ";
    exit;
}
/* ================= Punch In/Out Process ================= */
}
?>