<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
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
