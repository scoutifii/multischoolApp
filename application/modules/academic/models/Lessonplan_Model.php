<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lessonplan_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_lesson_plan_list($class_id = null, $school_id = null, $academic_year_id = null ){
        
        if(!$class_id){
           $class_id = $this->session->userdata('class_id');
        } 
       
        $this->db->select('LP.*, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year, T.name AS teacher');
        $this->db->from('lessons AS LP');
        $this->db->join('classes AS C', 'C.id = LP.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = LP.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = LP.subject_id', 'left');
        $this->db->join('teachers AS T', 'T.id = LP.teacher_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = LP.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = LP.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('LP.academic_year_id', $academic_year_id);
        }        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('LP.teacher_id', $this->session->userdata('profile_id'));
        }        
        if($class_id > 0){
            $this->db->where('LP.class_id', $class_id);            
        }
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('LP.school_id', $school_id); 
        }         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('LP.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('LP.status', 1);
        
        $this->db->order_by('LP.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    
     public function get_single_lesson_plan($id){
         
        $this->db->select('LP.*, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year, T.name AS teacher');
        $this->db->from('lessons AS LP');
        $this->db->join('classes AS C', 'C.id = LP.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = LP.subject_id', 'left');
        $this->db->join('teachers AS T', 'T.id = LP.teacher_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = LP.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = LP.school_id', 'left');
        $this->db->where('LP.id', $id);
        return $this->db->get()->row();
        
    }

    
    function duplicate_check($school_id, $class_id, $section_id = null, $subject_id = null, $teacher_id = null, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);              
        $this->db->where('subject_id', $subject_id);              
        $this->db->where('teacher_id', $teacher_id);              
        $this->db->where('class_date', $class_date);              
        $this->db->where('start_time', $start_time);              
        
        return $this->db->get('lessons')->num_rows();            
    }
    
    
    public function get_student_list($school_id, $class_id, $section_id, $academic_year_id = null ){
        
        $this->db->select('S.email, S.phone, S.name, G.name AS g_name, G.email AS g_email, G.phone AS g_phone');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);
        $this->db->where('E.class_id', $class_id);
        $this->db->where('E.section_id', $class_id);
        $this->db->where('E.school_id', $school_id);
        $this->db->where('S.status_type', 'regular');        
        return $this->db->get()->result();
        
    }
}