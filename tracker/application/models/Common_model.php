<?php
class Common_model extends CI_Model
{
  function __construct()
  {
     parent:: __construct();
  }
  	function tableInsert($tablename,$val)
    {
    	
        $this->db->insert($tablename, $val);
        if($this->db->affected_rows() == 1){
         return True;
            }
        else
        {
         return False;
        }
    }
    
    public function getTargetById($login_id){
        
        $this->db->select("*");

        $this->db->from("tracker_target");
        $this->db->where('course_type',"2024");
        $this->db->where('created_by',$cor_id);
        $this->db->order_by('id','desc');
        $qry = $this->db->get();

        return $qry->result_array();
    }
    
      public function getAllwhere($table, $where = '', $select = 'all', $order_fld = '', $order_type = '', $limit = '', $offset = '', $or_where = null,$group_by = null)
    {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }

        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if ($or_where != '') {
            $this->db->or_where($or_where); 
        }
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        $q        = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }
    
         //forgot Password Model
        public function get_user_by_email($email)
    {
        return $this->db->where('email', $email)
                        ->where('status', 1) // only active users
                        ->get('tracker_login')
                        ->row();
    }

    // Save OTP in DB
    public function save_otp($user_id, $otp)
    {
        return $this->db->where('id', $user_id)
                        ->update('tracker_login', ['forgot_pass_otp' => $otp]);
    }
    
     public function check_otp($otp)
    {
        // Only active users with this OTP
        $this->db->where('forgot_pass_otp', $otp);
        $this->db->where('status', 1);
        $query = $this->db->get('tracker_login');

        // Return a single row or null
        return $query->row();
    }
    
    public function save_log($data){
        $this->db->insert('tracker_activity_logs', $data); 
    }
    
    // Get POC BY PROFILE ID 
    public function getPocByProfileId($profile_id)
    {
        return $this->db
            ->select('id, name AS poc_name')
            ->from('tracker_poc')
            ->where('profile_id', $profile_id)
            ->get()
            ->result_array();
    }
    
    public function pocCreationRefVisit($data){
        
         $this->db->insert('tracker_poc', $data);
         
         return $this->db->insert_id(); // last inserted id
         
         
    }
    
     /* -------- GET PROFILES BY TYPE -------- */
    public function getProfilesByType($type,$login_id)
    {
        return $this->db
            ->select('id, name,profile_id')
            ->from('tracker_profile_form')
            ->where('profile_type', $type) 
            ->where('created_by', $login_id)
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }


    /* -------- GET POC BY PROFILE -------- */
    public function getPocByProfile($profile_id,$login_id)
    {
        return $this->db
            ->select('id, name as poc_name')
            ->from('tracker_poc') 
            ->where('profile_id', $profile_id)
            ->where('created_by', $login_id)
            ->order_by('name', 'ASC')
            ->get()
            ->result(); 
    }
    
    public function getPocDataInJson($poc_id){
        return $this->db
                ->select('name, contact')
                ->from('tracker_poc')
                ->where('id', $poc_id)
                ->get()
                ->row_array();
    }
    
    function get_allIPDOPDdata(){
    return $this->db
        ->select('t1.*, t2.name as agent_name, t2.contact as agent_contact')
        ->from('tracker_patient as t1')
        ->join('tracker_login as t2', 't2.id = t1.created_by', 'left') 
        ->where('t1.status', 1)
        ->order_by('t1.id', 'DESC')
        ->get()
        ->result();
    }
    
    function get_patient_ajax($start, $length)
    { 
        return $this->db
            ->select('t1.*, t2.name as agent_name, t2.contact as agent_contact')
            ->from('tracker_patient as t1')
            ->join('tracker_login as t2', 't2.id = t1.created_by', 'left')
            ->where('t1.status', 1)
            ->limit($length, $start)
            ->order_by('t1.id', 'DESC')
            ->get()
            ->result();
    }
    
    function count_all_patient()
    {
        return $this->db
            ->where('status', 1)
            ->count_all_results('tracker_patient');
    }

    function get_todayIPDOPDdata(){
    return $this->db
        ->select('t1.*, t2.name as agent_name, t2.contact as agent_contact')
        ->from('tracker_patient as t1')
        ->join('tracker_login as t2', 't2.id = t1.created_by', 'left') 
        ->where('DATE(t1.created_at)',date('Y-m-d'))
        ->where('t1.status', 1)
        ->order_by('t1.id', 'DESC')
        ->get()
        ->result();
    }
    
        public function checkTodayPunch($login_id)
    {
        $today = date('Y-m-d');
    
        return $this->db
            ->where('created_by', $login_id)
            ->where('DATE(created_at)', $today)
            ->get('tracker_attendance')
            ->row();
    }
    
    public function getAgentInvolved($login_id)
    {
        return $this->db
                    ->select('id, name')
                    ->from('tracker_login')
                    ->where('status', '1')
                    ->where('id !=', $login_id)
                    ->order_by('name', 'ASC')
                    ->get()
                    ->result();
    }
 } ?>