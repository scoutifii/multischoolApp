<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Term_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_term_list($school_id = null){
        
        $this->db->select('ST.*, AY.session_year, S.school_name AS school');
        $this->db->from('school_term AS ST');
        $this->db->join('academic_years AS AY', 'AY.id = ST.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = ST.school_id', 'left');
               
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('ST.school_id', $school_id); 
        }   
        $this->db->where('AY.is_running', 1);
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_term($id){
        
        $this->db->select('T.*');
        $this->db->from('school_term AS T');
        $this->db->where('T.id', $id);
        return $this->db->get()->row();
        
    }
    
    function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('name', $name);
        $this->db->where('school_id', $school_id);
        return $this->db->get('school_term')->num_rows();            
    }
 
}
