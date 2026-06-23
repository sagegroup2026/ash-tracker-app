<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['loader'] = 'Home/loader';

$route['login'] ='auth/login';
$route['register'] ='auth/register';
$route['save-register'] ='auth/save_register';

$route['check-login'] = 'auth/check_login';
$route['logout'] ='auth/logout';
/* Forgot Password */

$route['forgot-password'] = 'ForgotPassword/forgotpasswordpage';
$route['forgot-password-form'] = 'ForgotPassword/forgot_pass_form';

$route['otp-verify'] = 'ForgotPassword/otp_verify';
$route['add-otp-form'] = 'ForgotPassword/add_otp_form';

$route['change-password'] = 'ForgotPassword/changepasswordpage';
$route['password-change-form'] = 'ForgotPassword/changepasswordform';

/* Forgot Password */


$route['get-state-city-ajax'] = 'Home/get_state_city_ajax'; 

/*------------- Dashboard ---------------*/ 
$route['dashboard'] = 'Home/dashboard';

/*-------------Direct Login-----------*/
$route['direct-login/(:any)/(:any)'] = 'Direct/directLogin/$1/$1';

/*------------- Doctor Profile ---------------*/ 
$route['doctor-profile'] = 'Home/doctor_profile';
// $route['save-profile'] = 'Home/save_profile';

/*------------- Visit ---------------*/ 
$route['visit'] = 'Home/visitDemo';
//$route['visitDemo'] = 'Home/visitDemo';

$route['get-contact-by-profileid'] = 'Home/get_contact_by_profileid';
$route['save-visit'] = 'Home/save_visit';
$route['save-visit-demo'] = 'Home/save_visit_demo';
$route['test-visit']='Home/test_visit';
$route['save-test-visit'] = 'Test/save_test_visit';

/*------------- Daily plan --------------*/ 
$route['daily-plan'] = 'Home/daily_plan';
$route['save-daily-plan'] = 'Form/save_daily_plan';

/*------------- Daily plan List --------------*/ 
$route['daily-plan-list'] = 'Dashboard/daily_plan_list';

/*------------- Profile ---------------*/ 
$route['profile'] = 'Home/profile';
$route['save-profile'] = 'Form/save_profile';
$route['ajax/check-mobile-exists'] = 'Home/check_mobile_exists';
// $route['edit-profile'] = 'Home/edit_profile';
// $route['update-profile'] = 'Form/update_profile';
/*------------- Poc ---------------*/ 
$route['poc'] = 'Home/poc';
$route['save-poc'] ='Form/save_poc'; 

/*------------- Patient ---------------*/ 
$route['patient'] = 'Home/patient';
$route['save-patient'] ='Form/save_patient'; 

$route['test-patient'] = 'Test/test_patient';
$route['test-save-patient'] ='Test/save_test_patient'; 
$route['get-profilename-by-type'] = 'Ajax/get_profilename_by_type';
$route['get-pocname-by-profile'] = 'Ajax/get_pocname_by_profile';

/*------------- Target ---------------*/ 
$route['target'] = 'Home/target';
$route['save-target'] = 'Form/save_target';

/*------------- Senior Time ---------------*/ 
$route['senior'] = 'Home/senior_time';
$route['save-senior'] = 'Form/save_senior_time';  

$route['sanjay-testing'] = "Sanjaytesting/cameratest";

/*------------- Senior Time ---------------*/ 
$route['operation'] = 'Home/operation';
$route['save-operation'] = 'Form/save_operation';  

/*------------- In house Working ---------------*/ 
$route['in-house'] = 'Home/in_house';
$route['save-in-house'] = 'Form/save_in_house';

$route['in-house-test'] = 'Home/in_house_test';
/*------------- Target Achieved ---------------*/ 
$route['target-achieved'] = 'Home/target_achieved';
$route['save-healthcare'] = 'Form/save_healthcare'; 

/*------------- Booking ---------------*/ 
$route['booking'] = 'Home/booking';
$route['save-booking'] = 'Form/save_booking'; 

/*------------- Admission ---------------*/ 
$route['admission'] = 'Home/admission';
$route['save-admission'] = 'Form/save_admission'; 

/*------------- upcountry ---------------*/ 
$route['upcountry'] = 'Home/upcountry';
$route['save-upcountry'] = 'Form/save_upcountry';

/*------------- Event ---------------*/ 
$route['event'] = 'Home/event';
$route['save-event'] = 'Form/save_event'; 
/*---- Edit Event ----*/ 
$route['edit-event/(:any)'] = 'Home/edit_event/$1';
$route['update-event'] = 'Form/update_event';

/*------------- Search name --------------*/ 
$route['search'] = 'Form/search';

/*------------- Search Profile Id --------------*/ 
$route['search-profile-id'] = 'Form/search_profile_id';

/*------------- Attendance Punch in  --------------*/ 
$route['check-punch'] = 'Auth/check_punch';
$route['save-punch-in'] = 'Auth/save_punch_in';
$route['save-punch-out'] = 'Auth/save_punch_out';

/*------------- Dashboard Attendance List --------------*/ 
$route['attendance-list'] = 'Dashboard/attendance_list';  

/*------------- Dashboard Attendance List --------------*/ 
$route['attendance-list'] = 'Dashboard/attendance_list';  

/*------------- Dashboard Profile Created List --------------*/ 
$route['profile-created'] = 'Dashboard/profile_created';
$route['edit-profile/(:any)'] = 'Dashboard/edit_profile/$1';
$route['update-profile'] = 'Dashboard/update_profile';

/*------------- Dashboard Visit List --------------*/ 
$route['visit-created'] = 'Dashboard/visit_created';

/*------------- Dashboard poc List --------------*/ 
$route['poc-created'] = 'Dashboard/poc_created';

/*------------- Dashboard HealthCheckup List --------------*/ 
$route['healthcheckup-created'] = 'Dashboard/healthcheckup_created';

/*------------- Dashboard Admission List --------------*/ 
$route['admission-created'] = 'Dashboard/admission_created'; 

/*------------- Dashboard Bookings List --------------*/ 
$route['booking-created'] = 'Dashboard/booking_created';

/*------------- Dashboard IPD List --------------*/ 
$route['ipd-created'] = 'Dashboard/ipd_created';

/*------------- Dashboard OPD List --------------*/ 
$route['opd-created'] = 'Dashboard/opd_created';

/*------------- Dashboard In House Working List --------------*/ 
$route['inhousemeetings-created'] = 'Dashboard/inhousemeetings_created';   

/*------------- Dashboard Agreement Preparation List --------------*/ 
$route['agreement-preparation-created'] = 'Dashboard/agreement_preparation_created';   

/*------------- Dashboard Event List --------------*/ 
$route['event-created'] = 'Dashboard/event_created';   
$route['save-event-customer-lead'] = 'Dashboard/save_customer_lead';
$route['save-event-data-upload'] = 'DataUpload/uploadEventData';
/*------------- Dashboard Upcountry/Other Event List --------------*/ 
$route['upcountry-event'] = 'Dashboard/upcountry_event';

/*------------- Followups Pending/Today's List --------------*/ 
$route['followup-notification-old'] = 'Home/followup_notification';

/*------------- Followups Pending/Today's Testing List --------------*/ 
$route['followup-notification'] = 'Test/followup_notification_test';
$route['visit-start-meeting'] = 'Test/visit_start_meeting'; 

/*------------- Latest News & Updates  --------------*/ 
$route['latest-updates'] = 'Dashboard/latest_updates';
$route['toggle-favourite'] = 'Dashboard/toggleFavourite';

/*------------- All IPD/OPD/HC Data Show  --------------*/ 
$route['AllIPDOPDHC_DataShow'] = 'Sanjaytesting/AllIPDOPDHC_DataShow';

/*------------- Bulk Upload  --------------*/
$route['bulk-profile-upload'] = 'BulkUpload/bulkprofileUpload';
$route['bulkprofileUpload/import_excel_ajax'] = 'BulkUpload/import_excel_ajax';
