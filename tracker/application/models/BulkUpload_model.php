<?php

    class BulkUpload_model extends CI_Model
    {
        function __construct()
        {
            parent:: __construct();
        }
     
     function getallprofiledata(){
          $sql = "SELECT 
                tpf.*,
                tl.name AS created_by_name
            FROM tracker_profile_form tpf
            LEFT JOIN tracker_login tl 
                ON tl.id = tpf.created_by  ORDER BY tpf.id DESC";
            
            $query = $this->db->query($sql, array($id));
            return $query->result_array();
      }
     
     public function insert_batch_data($data)
    {
        if (!empty($data)) {
            return $this->db->insert_batch('tracker_profile_form', $data);
        }
        return false;
    }
     
 /*End*/       
}    