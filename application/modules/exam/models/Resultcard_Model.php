<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resultcard_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_final_result($school_id, $academic_year_id, $class_id, $section_id, $student_id){
        $this->db->select('FR.*, G.name AS grade');
        $this->db->from('final_results AS FR');        
        $this->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
        $this->db->where('FR.academic_year_id', $academic_year_id);
        $this->db->where('FR.school_id', $school_id);
        $this->db->where('FR.class_id', $class_id);
        $this->db->where('FR.section_id', $section_id);
        $this->db->where('FR.student_id', $student_id);
        return $this->db->get()->row();   
        //echo $this->db->last_query();   
    }
    
    public function get_student_list($school_id = null, $class_id = null, $section_id = null, $academic_year_id = null){
        
            $this->db->select('S.*, D.amount, D.title AS discount, G.name AS guardian, E.roll_no, E.section_id, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $this->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
            $this->db->where('S.school_id', $school_id);            
            $this->db->where('E.class_id', $class_id);            
            $this->db->where('E.academic_year_id', $academic_year_id);      
            
            if($section_id){
                $this->db->where('E.section_id', $section_id);
            }     
            
            if($this->session->userdata('role_id') == GUARDIAN){
                $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));  
            }
            $this->db->where('S.status_type', 'regular');
            $this->db->order_by('E.roll_no', 'ASC');
            
            return $this->db->get()->result();
    }

    public function get_term_list($school_id = null, $academic_year_id = null){
        $this->db->select('ST.*');
        $this->db->from('school_term AS ST'); 
        //$this->db->where('ST.id', $term_id);
        $this->db->where('ST.school_id', $school_id);           
        $this->db->where('ST.academic_year_id', $academic_year_id);
         return $this->db->get()->result(); 
    }
}