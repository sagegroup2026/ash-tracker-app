<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class ForgotPassword extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Common_model');
		$this->load->library(array('form_validation', 'email','session'));
	}

	function forgotpasswordpage()
	{
// 	    $data['description'] = '';
// 		$data['title'] = 'LMS Forgot Password';
        $this->load->view('common/header');
        $this->load->view('auth/forgot_password');
	}
public function forgot_pass_form()
{
    // Show form on GET
    if ($this->input->method() === 'get') {
        $this->load->view('auth/forgot_password'); 
        return;
    }

    // Handle POST
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata(
            'login_msg',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> The Email field must contain a valid email address.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        redirect(base_url('forgot-password'));
        return;
    }

    // Trim spaces from email
    $email = trim($this->input->post('email', TRUE));

    $user  = $this->Common_model->get_user_by_email($email);

    if (!$user) {
        $this->session->set_flashdata(
            'login_msg',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Email not found.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        redirect(base_url('forgot-password'));
        return;
    }

    // Generate 6-digit OTP
    $otp = rand(100000, 999999);

    // Save OTP
    $this->Common_model->save_otp($user->id, $otp);

    // Send Email
    $this->_send_otp_email($email, $otp);

    $this->session->set_flashdata(
        'login_msg',
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
            OTP has been sent to your email.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>'
    );

    redirect(base_url('otp-verify'));
}


private function _send_otp_email($to_email, $otp)
{
    // Load config from application/config/email.php automatically
    $this->load->library('email');

    $this->email->from('webadmin.acc@thesage.co.in', 'THE SAGE GROUP');
    $this->email->to($to_email);
    $this->email->subject('Password Reset OTP');
//     $this->email->message(
//         '<p>Hello,<br><br>Your ASH Tracker password-reset one-time password (OTP) is<br><b> '.$otp.'.'.'</b>
// Please use this code to complete your password change request.<br>
// Thank you for choosing ASH Tracker. <b>'.$otp.'</b></p>'
//     );
$this->email->message('
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:30px;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h2 style="margin:0; color:#2c3e50;">ASH Tracker</h2>
                            <p style="margin:5px 0 0; color:#7f8c8d;">Password Reset Request</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="color:#333333; font-size:15px; line-height:1.6;">
                            <p>Hello,</p>

                            <p>
                                We received a request to reset your ASH Tracker account password.
                                Please use the following One-Time Password (OTP) to proceed:
                            </p>

                            <!-- OTP Box -->
                            <div style="text-align:center; margin:30px 0;">
                                <span style="
                                    display:inline-block;
                                    padding:15px 30px;
                                    font-size:24px;
                                    font-weight:bold;
                                    letter-spacing:4px;
                                    color:#ffffff;
                                    background-color:#1abc9c;
                                    border-radius:6px;
                                ">
                                    '.$otp.'
                                </span>
                            </div>

                            <p>
                                This OTP is valid for a limited time.  
                                Please do not share this code with anyone for security reasons.
                            </p>

                            <p>
                                If you did not request a password reset, you can safely ignore this email.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>The SAGE Group Development Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top:20px; font-size:12px; color:#999999;">
                            © '.date('Y').' The SAGE Group Development Team. All Rights Reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
');


    if ( !$this->email->send() ) {
        log_message('error', 'Email send failed: '.$this->email->print_debugger(['headers']));
    }
}


// Controller
function otp_verify()
{
   
    $data['description'] = '';
    $data['title']       = 'Forgot Password';
    // fetch flashdata set in forgot_pass_form
    $data['otp_message'] = $this->session->flashdata('login-mess');
    $this->load->view('common/header', $data);
    $this->load->view('auth/forgot_pass_otp', $data);
}
public function add_otp_form()
{
    $this->form_validation->set_rules('forgot_pass_otp', 'OTP', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('otp_msg', validation_errors());
       redirect(base_url('otp-verify'));
        return;
    }

     $otp   = $this->input->post('forgot_pass_otp', TRUE);
     $email = $this->session->userdata('reset_email'); 
     $user  = $this->Common_model->check_otp($email, $otp);


    // Check OTP in Database
    $user = $this->Common_model->check_otp($otp);
    if (!$user) {
        $this->session->set_flashdata(
            'login-message',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Invalid or expired OTP.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
        );
        // $this->session->set_flashdata('otp_msg', 'Invalid or expired OTP.');
        redirect(base_url('otp-verify'));
        return;
    }

    // OTP is correct—store user ID in session for next step
    $this->session->set_userdata('login_id', $user->id);

   
     redirect(base_url('change-password'));
}

public function changepasswordpage()
{
    $data['title'] = 'Set New Password';

    // Ensure the OTP step was completed
    if (!$this->session->userdata('login_id')) {
        redirect(base_url('forgot-password'));
        return;
    }

    $this->load->view('common/header', $data);
    $this->load->view('auth/change_pass', $data);
}

public function changepasswordform()
{
    $user_id = $this->session->userdata('login_id');
    if (!$user_id) {
        redirect('forgot-password');
        return;
    }

    // Validation
    $this->form_validation->set_rules('new_password', 'New Password', 'required');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

    if ($this->form_validation->run() === FALSE) {
        $this->changepasswordpage(); // reload view with errors
        return;
    }

 
  
    $new_password =  encrypt_decrypt("encrypt",$this->input->post('new_password'));
   

    $this->db->where('id', $user_id)
             ->update('tracker_login', [
                 'password'        => $new_password,
                 'forgot_pass_otp' => NULL
             ]);

   
    $this->session->unset_userdata('login_id');
    $this->session->set_flashdata('login-message','<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Password changed successfully. You can now log in.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'
        );
    // $this->session->set_flashdata('success', 'Password changed successfully. You can now log in.');

    redirect(base_url('login')); 
}

	
	
}