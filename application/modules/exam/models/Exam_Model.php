<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_exam_list($school_id = null, $academic_year_id = null){
        
        $this->db->select('E.*, S.school_name, AY.session_year');
        $this->db->from('exams AS E');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
                
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
        }
        
        if($school_id){
            $this->db->where('E.school_id', $school_id);
        }
        
        if($academic_year_id){        
            $this->db->where('E.academic_year_id', $academic_year_id);
        } 
        $this->db->where('S.status', 1);
        
        return $this->db->get()->result();
        
    }
    
     public function get_single_exam($id){
        
        $this->db->select('E.*, AY.session_year');
        $this->db->from('exams AS E');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');        
        $this->db->where('E.id', $id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($school_id, $academic_year_id, $title, $id = null ){           
                 
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        $this->db->where('academic_year_id', $academic_year_id);
                
        return $this->db->get('exams')->num_rows();            
    }

}
