<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assignment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_assignment_list($class_id = null , $school_id = null, $academic_year_id = null){
         
        $this->db->select('A.*, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year');
        $this->db->from('assignments AS A');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = A.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('A.academic_year_id', $academic_year_id);
        }
        if($class_id > 0){
             $this->db->where('A.class_id', $class_id);
        }  
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('A.school_id', $school_id); 
        }        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('A.school_id', $this->session->userdata('school_id'));
        }
	
	if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('C.teacher_id', $this->session->userdata('profile_id'));
        }
		 
	if($this->session->userdata('role_id') == STUDENT){
            $this->db->where('A.section_id', $this->session->userdata('section_id'));
        }	 
	$this->db->where('SC.status', 1);	 
        $this->db->order_by('A.id', 'DESC');
        
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_assignment($id){
        
        $this->db->select('A.*, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject');
        $this->db->from('assignments AS A');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = A.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = A.subject_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = A.school_id', 'left');
        $this->db->where('A.id', $id);
        return $this->db->get()->row();        
    }
    
    
    public function get_user_list($school_id, $class_id, $section_id, $academic_year_id){
        
        $this->db->select('E.student_id, S.email, S.phone, S.name, S.guardian_id, U.username, U.role_id, U.id,  C.name AS class_name, G.name AS g_name, G.email AS g_email, G.phone AS g_phone');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);
        $this->db->where('E.class_id', $class_id);
        $this->db->where('E.section_id', $section_id);
        $this->db->where('E.school_id', $school_id);
        
        return $this->db->get()->result();
    }
    
}
