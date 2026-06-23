<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

// SimpleXLSX library ko include karein
require_once APPPATH . 'third_party/SimpleXLSX.php';
use Shuchkin\SimpleXLSX;

class BulkUpload extends CI_Controller {
    function __construct(){
	    parent::__construct();
	    $this->load->database();
        $this->load->library('session');
	    $this->load->model('BulkUpload_model'); 
        $this->load->helper('url');
      
	}

	public function bulkprofileUpload()
	{
    //if session Id empty then it will redirect to login page 
    if(empty($this->session->userdata('login_id'))){
        redirect(base_url()); 
     }else{
        $data['username']=$this->session->userdata('user_name');
        // $data['countries'] = getCountriesById();
        // $data['state']=getStateByCountry('101');
        $this->load->view('common/header');
        $this->load->view('common/main_header',$data);
        $this->load->view('bulkupload/profileList', $data);
        $this->load->view('common/footer-new');
	}
	}
	
	
// 	public function import_excel_ajax()
//     {
//         header('Content-Type: application/json');

// //  print_r("Ishu Thakur"); exit;
//         if (empty($_FILES['excel_file']['name'])) {
//             echo json_encode(['status' => 'error', 'message' => 'Please select a file.']);
//             return;
//         }

//         // File upload configuration
//         $config['upload_path']   = './uploads/';
//         $config['allowed_types'] = 'xlsx'; // SimpleXLSX mainly xlsx ke liye hai
//         $config['encrypt_name']  = true;

//         if (!is_dir('./uploads/')) {
//             mkdir('./uploads/', 0777, true);
//         }

//         $this->load->library('upload', $config);

//         if (!$this->upload->do_upload('excel_file')) {
//             echo json_encode([
//                 'status' => 'error',
//                 'message' => strip_tags($this->upload->display_errors())
//             ]);
//             return;
//         }

//         $uploadData = $this->upload->data();
//         $filePath   = $uploadData['full_path'];
//         // SimpleXLSX Logic Shuru
//         if ($xlsx = SimpleXLSX::parse($filePath)) {
//             $insertData = [];
//             $rows = $xlsx->rows(); // Saara data array mein mil jayega

//             foreach ($rows as $index => $row) {
//                 $excelRow = $index + 1;

//                 // Row 1,2 notes aur row 3 heading hai, isliye skip karein
//                 if ($excelRow <= 3) continue;

//                 // Agar puri row khali hai to skip karein
//                 if (empty(array_filter($row))) continue;

//                 $profile_type      = trim($row[0] ?? '');
//                 $name              = trim($row[1] ?? '');
//                 $contact           = trim($row[2] ?? '');
//                 $company_name      = trim($row[3] ?? '');
//                 $degree            = trim($row[4] ?? '');
//                 $speciality        = trim($row[5] ?? '');
//                 $experience        = trim($row[6] ?? '');
//                 $doctor_address    = trim($row[7] ?? '');
//                 $pincode           = trim($row[8] ?? '');
//                 $first_meetup_date = trim($row[9] ?? '');
//                 $opd               = trim($row[10] ?? '');
//                 $ipd               = trim($row[11] ?? '');
//                 $doctor_grade      = trim($row[12] ?? '');
//                 $reference_doctor  = trim($row[13] ?? '');
//                 $employee_no       = trim($row[14] ?? '');
//                 $executive_id      = trim($row[15] ?? '');

//                 // NULL handling logic
//                 $cols_to_check = ['degree', 'speciality', 'experience', 'doctor_address', 'first_meetup_date', 'opd', 'ipd', 'doctor_grade', 'reference_doctor'];
//                 foreach ($cols_to_check as $col) {
//                     if (strtoupper($$col) === 'NULL') {
//                         $$col = '';
//                     }
//                 }

//                 // Validation
//                 if ($profile_type === '' && $name === '' && $contact === '') continue;

//                 $insertData[] = [
//                     'profile_type'      => $profile_type,
//                     'name'              => $name,
//                     'contact'           => $contact,
//                     'company_name'      => $company_name,
//                     'degree'            => $degree,
//                     'speciality'        => $speciality,
//                     'experience'        => $experience,
//                     'doctor_address'    => $doctor_address,
//                     'pincode'           => $pincode,
//                     'first_meetup_date' => $this->formatSimpleDate($first_meetup_date),
//                     'opd'               => is_numeric($opd) ? $opd : 0,
//                     'ipd'               => is_numeric($ipd) ? $ipd : 0,
//                     'doctor_grade'      => $doctor_grade,
//                     'reference_doctor'  => $reference_doctor,
//                     'employee_no'       => $employee_no,
//                     'executive_id'      => is_numeric($executive_id) ? $executive_id : 0,
//                     'created_at'        => date('Y-m-d H:i:s')
//                 ];
//             }
//             print_r($insertData);exit;
           
//             @unlink($filePath); // File delete karein

//             if (!empty($insertData)) {
//                 $this->BulkUpload_model->insert_batch_data($insertData);
//                 echo json_encode(['status' => 'success', 'message' => count($insertData) . ' rows imported.']);
//             } else {
//                 echo json_encode(['status' => 'error', 'message' => 'No valid data found.']);
//             }

//         } else {
//             @unlink($filePath);
//             echo json_encode(['status' => 'error', 'message' => SimpleXLSX::parseError()]);
//         }
//     }
// Working Code
// public function import_excel_ajax()
// {
//     ob_clean();
//     header('Content-Type: application/json');

//     // File check
//     if (empty($_FILES['excel_file']['name'])) {
//         echo json_encode(['status' => 'error', 'message' => 'Please select a file.']);
//         return;
//     }

//     // Upload config
//     $config['upload_path']   = './uploads/';
//     $config['allowed_types'] = 'xlsx';
//     $config['encrypt_name']  = true;

//     if (!is_dir('./uploads/')) {
//         mkdir('./uploads/', 0777, true);
//     }

//     $this->load->library('upload', $config);

//     if (!$this->upload->do_upload('excel_file')) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => strip_tags($this->upload->display_errors())
//         ]);
//         return;
//     }

//     $uploadData = $this->upload->data();
//     $filePath   = $uploadData['full_path'];

//     try {

//         // 🔥 Namespace fix
//         if ($xlsx = \Shuchkin\SimpleXLSX::parse($filePath)) {

//             $rows = $xlsx->rows();
//             $insertData = [];

//             foreach ($rows as $index => $row) {

//                 // Skip first 3 rows
//                 if ($index < 3) continue;

//                 // Skip empty rows
//                 if (empty(array_filter($row))) continue;

//                 $profile_type      = trim($row[0] ?? '');
//                 $name              = trim($row[1] ?? '');
//                 $contact           = trim($row[2] ?? '');
//                 $company_name      = trim($row[3] ?? '');
//                 $degree            = trim($row[4] ?? '');
//                 $speciality        = trim($row[5] ?? '');
//                 $experience        = trim($row[6] ?? '');
//                 $doctor_address    = trim($row[7] ?? '');
//                 $pincode           = trim($row[8] ?? '');
//                 $first_meetup_date = trim($row[9] ?? '');
//                 $opd               = trim($row[10] ?? '');
//                 $ipd               = trim($row[11] ?? '');
//                 $doctor_grade      = trim($row[12] ?? '');
//                 $reference_doctor  = trim($row[13] ?? '');
//                 $employee_no       = trim($row[14] ?? '');
//                 $executive_id      = trim($row[15] ?? '');

//                 // NULL handling
//                 $cols_to_check = ['degree', 'speciality', 'experience', 'doctor_address', 'first_meetup_date', 'opd', 'ipd', 'doctor_grade', 'reference_doctor'];

//                 foreach ($cols_to_check as $col) {
//                     if (strtoupper($$col) === 'NULL') {
//                         $$col = '';
//                     }
//                 }

//                 // Basic validation
//                 if ($profile_type === '' && $name === '' && $contact === '') continue;

//                 $insertData[] = [
//                     'profile_type'      => $profile_type,
//                     'name'              => $name,
//                     'contact'           => $contact,
//                     'company_name'      => $company_name,
//                     'degree'            => $degree,
//                     'specialty'        => $speciality,
//                     'experience'        => $experience,
//                     'doctor_address'    => $doctor_address,
//                     'pincode'           => $pincode,
//                     'firs_follow_up_date' => $first_meetup_date,
//                     'opd'               => is_numeric($opd) ? $opd : 0,
//                     'ipd'               => is_numeric($ipd) ? $ipd : 0,
//                     'dr_grade'      => $doctor_grade,
//                     'ref_doctor'  => $reference_doctor,
//                     'emp_no'       => $employee_no,
//                     'created_by'      => $executive_id,
//                     'created_at'        => date('Y-m-d H:i:s')
//                 ];
//             }

//             // ❌ FILE DELETE hata diya (as per your requirement)
//             // @unlink($filePath);

//             if (!empty($insertData)) {

//                 // 🔥 Transaction safe insert
//                 $this->db->trans_start();
//                 $this->BulkUpload_model->insert_batch_data($insertData);
//                 $this->db->trans_complete();

//                 if ($this->db->trans_status() === FALSE) {
//                     echo json_encode([
//                         'status' => 'error',
//                         'message' => 'Database insert failed'
//                     ]);
//                 } else {
//                     echo json_encode([
//                         'status' => 'success',
//                         'message' => count($insertData) . ' rows imported successfully'
//                     ]);
//                 }

//             } else {
//                 echo json_encode([
//                     'status' => 'error',
//                     'message' => 'No valid data found in Excel'
//                 ]);
//             }

//         } else {
//             echo json_encode([
//                 'status' => 'error',
//                 'message' => \Shuchkin\SimpleXLSX::parseError()
//             ]);
//         }

//     } catch (Throwable $e) {

//         echo json_encode([
//             'status' => 'error',
//             'message' => $e->getMessage()
//         ]);
//     }
// }

public function import_excel_ajax()
{
    ob_clean();
    header('Content-Type: application/json');

    //  File validation
    if (empty($_FILES['excel_file']['name'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a file.']);
        return;
    }

    //   Upload config
    $config['upload_path']   = './uploads/';
    $config['allowed_types'] = 'xlsx';
    $config['encrypt_name']  = true;

    // Upload folder create if not exists
    if (!is_dir('./uploads/')) {
        mkdir('./uploads/', 0777, true);
    }

    // Upload library load
    $this->load->library('upload', $config);

    //   File upload attempt
    if (!$this->upload->do_upload('excel_file')) {

        // IF upload fail (wrong format etc.)
        $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));

        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid file format. Please upload correct Excel file.'
        ]);
        return;
    }

    // Uploaded file data
    $uploadData = $this->upload->data();
    $filePath   = $uploadData['full_path'];

    try {

        //  Excel parse using SimpleXLSX
        if ($xlsx = \Shuchkin\SimpleXLSX::parse($filePath)) {

            $rows = $xlsx->rows();
            // REQUIRED HEADER FORMAT
            $expectedHeader = ['Profile Type','Name','Contact','Company Name','Degree','Specialty','Experience','Doctor Address','Pincode','First Meet up Date','OPD','IPD','Doctor Grade','Reference Doctor','Employee No.','Valid From','Valid To','Executive Id']; 
            
            // Excel ka actual header (first row)
            $excelHeader = array_map('trim', $rows[2]);

            // Header mismatch check
            if ($excelHeader !== $expectedHeader) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid Excel format. Please use correct template.'
                ]);
                return;
            }
            
            $insertData = [];
            $skippedDuplicates = 0; // duplicate counter

            foreach ($rows as $index => $row) {

                // Skip header rows
                if ($index < 3) continue;

                // Skip empty rows
                if (empty(array_filter($row))) continue;

                //  Data mapping
                $profile_type      = trim($row[0] ?? '');
                $name              = trim($row[1] ?? '');
                $contact           = trim($row[2] ?? '');
                $company_name      = trim($row[3] ?? '');
                $degree            = trim($row[4] ?? '');
                $speciality        = trim($row[5] ?? '');
                $experience        = trim($row[6] ?? '');
                $doctor_address    = trim($row[7] ?? '');
                $pincode           = trim($row[8] ?? '');
                $first_meetup_date = trim($row[9] ?? '');
                $opd               = trim($row[10] ?? '');
                $ipd               = trim($row[11] ?? '');
                $doctor_grade      = trim($row[12] ?? '');
                $reference_doctor  = trim($row[13] ?? '');
                $employee_no       = trim($row[14] ?? '');
                $valid_from        = trim($row[15] ?? '');
                $valid_to          = trim($row[16] ?? '');
                $executive_id      = trim($row[17] ?? '');

                // NULL handling (Excel me "NULL" aaye to empty karo)
                $cols_to_check = ['degree', 'speciality', 'experience', 'doctor_address', 'first_meetup_date', 'opd', 'ipd', 'doctor_grade', 'reference_doctor'];

                foreach ($cols_to_check as $col) {
                    if (strtoupper($$col) === 'NULL') {
                        $$col = '';
                    }
                }

                // Basic validation
                if ($profile_type === '' && $name === '' && $contact === '') continue;

                //  Duplicate check
                $exists = $this->db
                    ->where('contact', $contact)
                    ->count_all_results('tracker_profile_form'); 
                if ($exists > 0) {
                    $skippedDuplicates++;
                    continue; // Skip duplicate
                }
                
               // -------------- PROFILE ID GENERATION ------------------
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
                
                // Normalize profile type
                $profile_type_lower = strtolower(trim($profile_type));
                $profile_code = $codes[$profile_type_lower] ?? 'OT';
                
                // Current year
                $year = date('Y');
                
                // Name (first 2 chars safe)
                $name_clean = preg_replace('/\s+/', '', $name);
                $name_code  = strtoupper(substr($name_clean . 'XX', 0, 2)); // safe for short names
                
                // Mobile (last 2 digits safe)
                $mobile_clean = preg_replace('/\D/', '', $contact);
                $mobile_code  = substr(str_pad($mobile_clean, 2, '0', STR_PAD_LEFT), -2);
                
                // Unique random (avoid collision)
                do {
                    $random = rand(100000, 999999);
                    $profile_id = $profile_code . $year . $name_code . $mobile_code . $random;
                
                    $existsId = $this->db
                        ->where('profile_id', $profile_id)
                        ->count_all_results('tracker_profile_form');
                
                } while ($existsId > 0);

                //  Insert data prepare
                $insertData[] = [
                    'profile_id'   => $profile_id,
                    'profile_type'      => $profile_type,
                    'name'              => $name,
                    'contact'           => $contact,
                    'company_name'      => $company_name,
                    'degree'            => $degree,
                    'specialty'         => $speciality,
                    'experience'        => $experience,
                    'doctor_address'    => $doctor_address,
                    'pincode'           => $pincode,
                    'first_follow_up_date' => $first_meetup_date,
                    'opd'               => is_numeric($opd) ? $opd : 0,
                    'ipd'               => is_numeric($ipd) ? $ipd : 0,
                    'dr_grade'          => $doctor_grade,
                    'ref_doctor'        => $reference_doctor,
                    'emp_no'            => $employee_no, 
                    'valid_from'        => $valid_from,
                    'valid_to'          => $valid_to, 
                    'created_by'        => $executive_id,
                    'created_at'        => date('Y-m-d H:i:s')
                ];
            }

            //  Insert into DB
            if (!empty($insertData)) {

                $this->db->trans_start();
                $this->BulkUpload_model->insert_batch_data($insertData);
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Database insert failed'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'success',
                        'message' => count($insertData) . ' rows inserted, ' . $skippedDuplicates . ' duplicates skipped'
                    ]);
                }

            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No valid data found or records were duplicates'
                ]);
            }

        } else {
            // Excel parse fail (wrong format)
            $this->session->set_flashdata('error', \Shuchkin\SimpleXLSX::parseError());

            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid Excel format'
            ]);
        }

    } catch (Throwable $e) {

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
	private function formatExcelDate($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        $time = strtotime($value);
        return $time ? date('Y-m-d', $time) : null;
    }
/*End*/	
}	