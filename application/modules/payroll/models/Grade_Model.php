<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grade_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
        
     public function get_grade_list($school_id = null){
        
        $this->db->select('G.*, S.school_name');
        $this->db->from('salary_grades AS G');
        $this->db->join('schools AS S', 'S.id = G.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('G.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('G.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('G.id', 'DESC');
        
        return $this->db->get()->result();        
    }
    
     public function get_single_grade($grade_id){
        
        $this->db->select('G.*, S.school_name');
        $this->db->from('salary_grades AS G');
        $this->db->join('schools AS S', 'S.id = G.school_id', 'left');
        $this->db->where('G.id', $grade_id);
         return $this->db->get()->row();  
        
    }
    
    
     function duplicate_check($school_id, $grade_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('grade_name', $grade_name);
        return $this->db->get('salary_grades')->num_rows();            
    }

}
