<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suggestion_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_suggestion_list($class_id = null, $school_id = null, $academic_year_id = null, $term_id = null){
         
        if(!$class_id){
           $class_id = $this->session->userdata('class_id');
        } 
        
        $this->db->select('SU.*, SC.school_name, E.title AS exam_title, C.name AS class_name, S.name AS subject, AY.session_year, ST.name AS term');
        $this->db->from('suggestions AS SU');
        $this->db->join('classes AS C', 'C.id = SU.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = SU.subject_id', 'left');
        $this->db->join('exams AS E', 'E.id = SU.exam_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SU.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = SU.school_id', 'left');
        $this->db->join('school_term AS ST', 'ST.id = SU.term_id', 'left');
        
        if($academic_year_id){
          $this->db->where('SU.academic_year_id', $academic_year_id);
        }

        if($term_id){
          $this->db->where('SU.term_id', $term_id);
        }
        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }        
        
        if($class_id > 0){
            $this->db->where('SU.class_id', $class_id);
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('SU.school_id', $school_id); 
        } 
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('SU.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('SC.status', 1);
        $this->db->order_by('SU.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
     public function get_single_suggestion($id){
        
        $this->db->select('SU.*, SC.school_name, E.title AS exam_title, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('suggestions AS SU');
        $this->db->join('classes AS C', 'C.id = SU.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = SU.subject_id', 'left');
        $this->db->join('exams AS E', 'E.id = SU.exam_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SU.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = SU.school_id', 'left');
        $this->db->where('SU.id', $id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($school_id, $academic_year_id, $exam_id, $class_id, $subject_id, $term_id, $id = null ){
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('academic_year_id', $school_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id); 
        $this->db->where('term_id', $term_id);        
        return $this->db->get('suggestions')->num_rows();            
    }
 
}
