<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
    public function get_certificate_list(){
        
        $this->db->select('C.*, S.school_name');
        $this->db->from('certificates AS C');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left');
   
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('C.school_id', $this->session->userdata('school_id'));
            $this->db->where('C.status', 1);
        }
       
        $this->db->where('S.status', 1);
        
        return $this->db->get()->result();
    }
    
    function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('certificates')->num_rows();            
    }
    
    public function get_student_list($school_id = null, $class_id = null , $academic_year_id = null) {

            $this->db->select('S.*, U.username, U.role_id, U.status AS login_status ');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->where('E.academic_year_id', $academic_year_id);
            $this->db->where('S.school_id', $school_id);
            
            if($class_id){
                $this->db->where('E.class_id', $class_id);
            }            
             
            return $this->db->get()->result();
    }
    
    public function get_student($student_id = null, $class_id = null, $academic_year_id = null ) {

            $this->db->select('S.*, U.username, U.role_id, U.status AS login_status ');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->where('E.academic_year_id', $academic_year_id);
            $this->db->where('S.id', $student_id);
            $this->db->where('E.class_id', $class_id);
                   
             
            return $this->db->get()->row();
    }
}
