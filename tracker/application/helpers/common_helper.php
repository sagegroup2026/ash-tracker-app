<?php  
defined('BASEPATH') or exit('No direct script access allowed');

function encrypt_decrypt($action, $string) {
   
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'e9b8b1596fbb58954dfae1fd6baa8dea';
    $secret_iv = 'e9b8b1596fbb58954dfae1fd6baa8dea';
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output; 
}

function check_email($email){
   
        	$CI =& get_instance();
			$query = $CI->db->query("select * from tracker_login where email='$email'");  
		    return	$query->num_rows();
			
}

function check_mobile_exists($tablename,$columnname,$mobile)
{
    $CI =& get_instance();

    $CI->db->where($columnname, $mobile);
    $query = $CI->db->get($tablename);

    return $query->num_rows() > 0; 
}


function check_email_password($email,$password){
         	$CI =& get_instance();
			$query = $CI->db->query("select * from tracker_login where email='$email' && password='$password'");  
		    return	$query->num_rows();
}

function get_user_data($email){
    $CI =& get_instance();
			$query = $CI->db->query("select * from tracker_login where email='$email'");
		    return $query->row();
}

function getCountriesById(){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT id, name FROM countries ORDER BY name ASC");
    return $query->result();
}

function getStateByCountry($country_id){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT id, state_name FROM states WHERE country_id = '$country_id' ORDER BY state_name ASC");
    return $query->result();
}

function getCityByState($state_id){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT id, city_name FROM tb_cities WHERE state_id = '$state_id' ORDER BY city_name ASC");
    return $query->result();
}

function getProfileId($login_id){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT * FROM tracker_profile_form WHERE created_by = '$login_id' ");
    return $query->result();
}

function getProfileIdByContact($tableName,$where,$select){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT $select FROM $tableName WHERE $where");
    return $query->result();
}

function create_data($table, $data){
    $CI =& get_instance();
    
    $query = $CI->db->insert($table,$data); 
    return $CI->db->insert_id();
}

    // function getTargetById($loginId){
    //     $CI =& get_instance();
    //     $query = $CI->db->query("SELECT * FROM tracker_target WHERE created_by = '$loginId' AND month(created_at)=month(current_date())");
    //     return $query->row();
    // }
    function getTargetById($loginId, $start_date, $end_date){
        $CI =& get_instance();
    
        $CI->db->where('created_by', $loginId);
        $CI->db->where('created_at >=', $start_date . ' 00:00:00');
        $CI->db->where('created_at <=', $end_date . ' 23:59:59');
    
        return $CI->db->get('tracker_target')->row();
    }
    
    function getAchievedTargetById($tablename, $loginId, $start_date, $end_date, $category = null){
        $CI =& get_instance();
    
        if(empty($start_date) || empty($end_date)){
            return 0; // prevent SQL error
        }
    
        $CI->db->where('created_by', $loginId);
        $CI->db->where('created_at >=', $start_date . ' 00:00:00');
        $CI->db->where('created_at <=', $end_date . ' 23:59:59');
    
        if ($category && $CI->db->field_exists('type', $tablename)) {
            $CI->db->where('type', $category);
        }
    
        return $CI->db->get($tablename)->num_rows();
    }


    

    // function getAchievedTargetById($tablename,$loginId,$category = null){
    //     $CI =& get_instance();
    //     if($category) $query = $CI->db->query("SELECT *FROM $tablename WHERE created_by = '$loginId' AND type ='$category' AND month(created_at)=month(current_date())");
    //     else $query = $CI->db->query("SELECT * FROM $tablename WHERE created_by = '$loginId' AND month(created_at)=month(current_date())");
    //     return $query->num_rows();
    // }
    
    function getTotalTargetById($tablename,$loginId,$category = null){
        $CI =& get_instance();
        if($category) $query = $CI->db->query("SELECT *FROM $tablename WHERE created_by = '$loginId' AND type ='$category'");
        else $query = $CI->db->query("SELECT * FROM $tablename WHERE created_by = '$loginId'");
        return $query->num_rows();
    }
    
    
    /* */ 
    function checkTargetAlreadyExistsInAMonth($login_id)
    {
        $CI =& get_instance();
    
        $CI->db->where('created_by', $login_id);
        $CI->db->where('MONTH(created_at)', date('m'));
        $CI->db->where('YEAR(created_at)', date('Y'));
    
        $query = $CI->db->get('tracker_target');
    
        return $query->num_rows() > 0;
    }
    
    
/*=============== Common function to check uniqueness =================*/
    
    function is_value_exists($table, $column, $value, $ignore_id = null)
{
    $CI =& get_instance();

    $CI->db->where($column, $value);

    // Edit case ke liye (current record ko ignore kare)
    if (!empty($ignore_id)) {
        $CI->db->where('id !=', $ignore_id);
    }

    $query = $CI->db->get($table);

    return ($query->num_rows() > 0);
}


/*=============== get device token =================*/
function get_device_token(){
    if(!isset($_COOKIE['device_token'])){
        $token = bin2hex(random_bytes(32));
        setcookie('device_token', $token, time() + (86400 * 365), "/");
        return $token;
    }
    return $_COOKIE['device_token'];
}

/*=============== get all data by login Id  =================*/ 
function getAllDataById($tablename, $login_id){
    $CI =& get_instance();

    return $CI->db
        ->select('*')
        ->where('created_by', $login_id)
        ->where('MONTH(created_at)', date('m'))
        ->where('YEAR(created_at)', date('Y'))
        ->order_by('id', 'DESC')
        ->get($tablename)
        ->result();
}

/*=============== Get events created by agent & other Agents Involved=================*/
// function getEventCreatedData($login_id, $from, $to){
//     $CI =& get_instance();
//     $CI->db->select('*');
//     $CI->db->from('tracker_event');
//     // created by OR person involved
//     $CI->db->group_start();
//     $CI->db->where('created_by', $login_id);
//     // find id inside comma separated values
//     $CI->db->or_where("FIND_IN_SET('".$login_id."', person_involved) !=", 0, false);
//     $CI->db->group_end();
//     // date filter
//     $CI->db->where('DATE(created_at) >=', $from);
//     $CI->db->where('DATE(created_at) <=', $to);
//     return $CI->db
//               ->order_by('id', 'DESC')
//               ->get()
//               ->result();
// }

function getEventCreatedData($login_id, $from, $to)
{
    $CI =& get_instance();

    $CI->db->select("
        te.*,
        tl.name AS created_by_name,
        GROUP_CONCAT(DISTINCT pi.name ORDER BY pi.name SEPARATOR ', ') AS person_involved_names
    ", false);

    $CI->db->from('tracker_event te');

    // Created By Name
    $CI->db->join('tracker_login tl', 'tl.id = te.created_by', 'left');

    // Person Involved Names
    $CI->db->join(
        'tracker_login pi',
        'FIND_IN_SET(pi.id, te.person_involved) > 0',
        'left'
    );

    // Created by OR Person involved
    $CI->db->group_start();
        $CI->db->where('te.created_by', $login_id);
        $CI->db->or_where("FIND_IN_SET('".$login_id."', te.person_involved) !=", 0, false);
    $CI->db->group_end();

    // Date Filter
    $CI->db->where('DATE(te.created_at) >=', $from);
    $CI->db->where('DATE(te.created_at) <=', $to);

    $CI->db->group_by('te.id');

    return $CI->db
              ->order_by('te.id', 'DESC')
              ->get()
              ->result();
}

function getAllDataByIdNew($tablename, $login_id, $from, $to, $type = null)
{
    $CI =& get_instance();

    $CI->db->select('*')
        ->from($tablename)
        ->where('created_by', $login_id)
        ->where('DATE(created_at) >=', $from)
        ->where('DATE(created_at) <=', $to);

    // type condition only if provided
    if (!empty($type)) {
        $CI->db->where('type', $type);
    }

    return $CI->db
        ->order_by('id', 'DESC')
        ->get()
        ->result();
}

/*=============== get all data by login Id (Current Month) =================*/ 
function getVisitDataById($login_id,$from, $to){
    $CI =& get_instance();

    // $start = date('Y-m-01'); // month start
    // $end   = date('Y-m-t');  // month end

return $CI->db
    ->select('t1.*, t2.name, t2.profile_type')
    ->from('tracker_visit_form AS t1')
    ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'inner')
    ->where('t1.created_by', $login_id)
    ->where('DATE(t1.created_at) >=', $from)
    ->where('DATE(t1.created_at) <=', $to)
    ->order_by('t1.id', 'DESC')
    ->get()
    ->result();

}

function getTodayVisitDataById($login_id){
    $CI =& get_instance();

    return $CI->db
        ->select('t1.*, t2.name, t2.profile_type')
        ->from('tracker_visit_form AS t1')
        ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'inner')
        ->where('t1.created_by', $login_id)
        ->where('DATE(t1.created_at)', date('Y-m-d')) // ONLY TODAY
        ->order_by('t1.id', 'DESC')
        ->get()
        ->result();
}


function getTodayDataById($login_id){
    $CI =& get_instance();

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

   return $CI->db
    ->select('t1.*, t2.name, t2.profile_type')
    ->from('tracker_visit_form AS t1')
    ->join('tracker_profile_form AS t2', 't2.created_by = t1.created_by', 'inner')
    ->where('t1.created_by', $login_id)
    ->where('t1.created_at >=', $start)
    ->where('t1.created_at <=', $end)
    ->group_by('t1.id')  
    ->order_by('t1.id', 'DESC')
    ->get()
    ->result();

}
/*=============== get today data by login Id  =================*/ 
function getTodayProfiles($tablename, $login_id, $type = null)
{
    $CI =& get_instance();

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $CI->db->select('*')
        ->from($tablename)
        ->where('created_by', $login_id)
        ->where('created_at >=', $start)
        ->where('created_at <=', $end);

    // type condition only if provided
    if (!empty($type)) {
        $CI->db->where('type', $type);
    }

    return $CI->db
        ->order_by('id', 'DESC')
        ->get()
        ->result();
}

/*=============== get POC data by login Id & Doctor Id =================*/ 
function getPocDataById($login_id, $doctor_id){
    $CI =& get_instance();
    return $CI->db
        ->select('*')
        ->from('tracker_target')
        ->where('created_by', $login_id)
        ->where('profile_id', $profile_id)
        ->order_by('id', 'DESC')
        ->get()
        ->result();
}

/*=============== get Today Plan  =================*/ 
function getDailyPlanId($login_id){

    $CI =& get_instance();
    $CI->db->select('tracker_daily_plan.*, tracker_profile_form.name');
    $CI->db->from('tracker_daily_plan');
    $CI->db->join(
        'tracker_profile_form',
        'tracker_profile_form.id = tracker_daily_plan.profile_id',
        'left'
    );
    $CI->db->where('tracker_daily_plan.created_by', $login_id);
    // today plan only
    $CI->db->where('DATE(tracker_daily_plan.created_at)', date('Y-m-d'));
    $CI->db->order_by('tracker_daily_plan.id','DESC');
    return $CI->db->get()->result();
}


/*=============== get Today Followups  =================*/ 

/*function getTodayfollowups($login_id){
    $CI =& get_instance();
    return $CI->db
              ->select('t1.*, t2.id AS pid ,t2.name AS profile_name ,t2.doctor_address AS profile_add, t3.name AS poc_name, t3.contact AS poc_contact, CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM tracker_visit_form 
                    WHERE profile_id = t1.profile_id 
                    AND DATE(created_at) = t1.follow_up_date
                    AND created_by = t1.created_by )
                THEN 1 
                ELSE 0 
                END AS visit_done')
              ->from('tracker_visit_form AS t1')
              ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'left')
              ->join('tracker_poc AS t3', 't3.id = t1.poc_id', 'left')
              ->where('t1.created_by', $login_id)
              ->group_start()
                  ->where('t1.follow_up_date', date('Y-m-d'))
                  ->or_where('DATE(t1.created_at) =', date('Y-m-d'), true)
              ->group_end() 
              ->order_by('t1.id', 'DESC')
              ->get()
              ->result();
}*/
function getTodayfollowups($login_id)
{
    $CI =& get_instance();
    $today = date('Y-m-d');

    return $CI->db
        ->select("
            t1.*,
            t2.id AS pid,
            t2.name AS profile_name,
            t2.doctor_address AS profile_add,
            t3.name AS poc_name,
            t3.contact AS poc_contact
        ", false)
        ->from('tracker_visit_form AS t1')
        ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'left')
        ->join('tracker_poc AS t3', 't3.id = t1.poc_id', 'left')
        ->where('t1.created_by', $login_id)
        ->group_start()
            ->where("DATE(t1.created_at) = ".$CI->db->escape($today), null, false)
            ->or_group_start()
                ->where('t1.follow_up_date', $today)
                ->where("
                    NOT EXISTS (
                        SELECT 1
                        FROM tracker_visit_form AS tvf2
                        WHERE tvf2.profile_id = t1.profile_id
                        AND DATE(tvf2.created_at) = ".$CI->db->escape($today)."
                        AND tvf2.created_by = t1.created_by
                        AND tvf2.id != t1.id
                    )
                ", null, false)
            ->group_end()
        ->group_end()
        ->order_by('t1.id', 'DESC')
        ->get()
        ->result();
}

function getPendingfollowups($login_id)
{
/*    $CI =& get_instance();
$today = date('Y-m-d');

return $CI->db
    ->select("
        t1.*,
        t2.id AS pid,
        t2.name AS profile_name,
        t2.doctor_address AS profile_add,
        t3.name AS poc_name,
        t3.contact AS poc_contact
    ", false)
    ->from('tracker_visit_form AS t1')
    ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'left')
    ->join('tracker_poc AS t3', 't3.id = t1.poc_id', 'left')
    ->where('t1.created_by', $login_id)

    // Pending follow-up (past date)
    ->where('t1.follow_up_date <', $today)

    // No visit on follow-up date
    ->where("
        NOT EXISTS (
            SELECT 1
            FROM tracker_visit_form AS tvf2
            WHERE tvf2.profile_id = t1.profile_id
            AND DATE(tvf2.created_at) = t1.follow_up_date
            AND tvf2.created_by = t1.created_by
        )
    ", null, false)

    // 🔥 NEW: No visit today for same profile
    ->where("
        NOT EXISTS (
            SELECT 1
            FROM tracker_visit_form AS tvf3
            WHERE tvf3.profile_id = t1.profile_id
            AND DATE(tvf3.created_at) = ".$CI->db->escape($today)."
            AND tvf3.created_by = t1.created_by
        )
    ", null, false)

    ->order_by('t1.follow_up_date', 'ASC')
    ->get()
    ->result();*/
    $CI =& get_instance();
$today = date('Y-m-d');

return $CI->db
    ->select("
        t1.*,
        t2.id AS pid,
        t2.name AS profile_name,
        t2.doctor_address AS profile_add,
        t3.name AS poc_name,
        t3.contact AS poc_contact
    ", false)
    ->from('tracker_visit_form AS t1')

    // 🔥 ONLY latest visit per profile
    ->where("
        t1.created_at = (
            SELECT MAX(tvf.created_at)
            FROM tracker_visit_form AS tvf
            WHERE tvf.profile_id = t1.profile_id
            AND tvf.created_by = t1.created_by
        )
    ", null, false)

    ->join('tracker_profile_form AS t2', 't2.profile_id = t1.profile_id', 'left')
    ->join('tracker_poc AS t3', 't3.id = t1.poc_id', 'left')

    ->where('t1.created_by', $login_id)

    // Pending condition
    ->where('t1.follow_up_date <', $today)

    // No visit on follow-up date
    ->where("
        NOT EXISTS (
            SELECT 1
            FROM tracker_visit_form AS tvf2
            WHERE tvf2.profile_id = t1.profile_id
            AND DATE(tvf2.created_at) = t1.follow_up_date
            AND tvf2.created_by = t1.created_by
        )
    ", null, false)

    // No visit today
    ->where("
        NOT EXISTS (
            SELECT 1
            FROM tracker_visit_form AS tvf3
            WHERE tvf3.profile_id = t1.profile_id
            AND DATE(tvf3.created_at) = ".$CI->db->escape($today)."
            AND tvf3.created_by = t1.created_by
        )
    ", null, false)

    ->order_by('t1.follow_up_date', 'ASC')
    ->get()
    ->result();
}

// get today's active meetings
function get_today_active_meeting($profile_id, $login_id)
    {
        $CI =& get_instance();

        $today = date('Y-m-d');

        $CI->db->where('profile_id', $profile_id);
        $CI->db->where('created_by', $login_id);
        $CI->db->where('DATE(plan_date)', $today);
        $CI->db->where('out_time IS NULL', NULL, FALSE);
        $CI->db->order_by('id', 'DESC');
        $CI->db->limit(1);
        return $CI->db->get('tracker_visit_form')->row();
    }
    
    // Get Last Visit data 
    function get_last_inserted_visit($profile_id){
        $CI =& get_instance();
        return $CI->db
                ->where('profile_id',$profile_id)
                ->order_by('id','DESC')
                ->limit(1)
                ->get('tracker_visit_form')
                ->row();
    } 
    
    
function get_profile_details($profile_id)
    {
        $CI =& get_instance(); 

        $CI->db->select('name, contact');
        $CI->db->where('profile_id', $profile_id);

        return $CI->db->get('tracker_profile_form')->row();
    }

/*=============== get Today Updates  =================*/ 
function getRecentUpdate(){
    $CI =& get_instance();
    return $CI->db
        ->select('*')
        ->from('tracker_updates')
        ->where('status', '1')
        ->where('DATE(created_at)', date('Y-m-d'))
        ->order_by('id', 'DESC')
        ->get()
        ->result();
}
function getUpdates($type = 'all')
{
    $CI =& get_instance();

    $CI->db
        ->select('*')
        ->from('tracker_updates')
        ->where('status', '1')
        ->where('DATE(created_at) <', date('Y-m-d'));

    // FILTERS
    if($type == 'healthcare'){

        // HEALTHCARE
        $CI->db->where('vertical', 'ASH');

    }
    else if($type == 'realstate'){

        // REALSTATE
        $CI->db->where('vertical', 'SR');

    }
    else if($type == 'education'){

        // EDUCATION
        $CI->db->where_not_in('vertical', ['ASH','SR']);

    }

    return $CI->db
        ->order_by('id', 'DESC')
        ->get()
        ->result();
}

function isFavourite($update_id)
{
    $CI =& get_instance();

    $login_id = $CI->session->userdata('login_id');

    return $CI->db
        ->where('update_id',$update_id)
        ->where('created_by',$login_id)
        ->count_all_results('tracker_favourites');
}

function getFavouriteUpdates()
{
    $CI =& get_instance();

    $login_id = $CI->session->userdata('login_id');

    return $CI->db
        ->select('tracker_updates.*')
        ->from('tracker_favourites')
        ->join(
            'tracker_updates',
            'tracker_updates.id = tracker_favourites.update_id'
        )
        ->where('tracker_favourites.created_by',$login_id)
        ->order_by('tracker_favourites.id','DESC')
        ->get()
        ->result();
}

function getAgents(){
    $CI= & get_instance();
    // Logged in user id
    $login_id = $CI->session->userdata('login_id');

    $CI->db->where('id !=', $login_id); // loggedin user hide
    $CI->db->where('role_id !=', 1);    // role_id = 1 hide

    $query = $CI->db->get('tracker_login');

    return $query->result();
}

/*=============== Get Attendance Data  =================*/ 
function getAttendanceDataById($login_id, $from, $to, $type = null)
{
    $CI =& get_instance();

    $CI->db->select('*')
        ->from('tracker_attendance')
        ->where('created_by', $login_id)
        ->where('DATE(created_at) >=', $from)
        ->where('DATE(created_at) <=', $to);
    return $CI->db
        ->order_by('DATE(created_at)', 'ASC')
        ->get()
        ->result();
}

function get_all_states(){

    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->where('country_id','101');
    $CI->db->from('states');
    return $CI->db
              ->order_by('state_name', 'ASC')
              ->get()
              ->result();
}

/*=============== get all Events Created by agents =================*/
function getAllEvent(){
    $CI =& get_instance();
    $CI->db->select('tracker_event.*, states.state_name, tb_cities.city_name, tracker_login.name as agent_name');
    $CI->db->from('tracker_event');
    $CI->db->join('states','states.id = tracker_event.state','left');
    $CI->db->join('tb_cities','tb_cities.id = tracker_event.city','left');
    $CI->db->join('tracker_login','tracker_login.id = tracker_event.created_by','left');
    $CI->db->where('tracker_event.status', '1');
    $CI->db->order_by('tracker_event.event_date', 'DESC');
    $CI->db->limit(10);
    return $CI->db->get()->result();
}

?>

