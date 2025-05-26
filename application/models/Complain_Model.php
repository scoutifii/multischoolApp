<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Complain_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_complain_list(){
         
        $this->db->select('C.*, T.type, S.school_name, AY.session_year');
        $this->db->from('complains AS C');
        $this->db->join('complain_types AS T', 'T.id = C.type_id', 'left'); 
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = C.academic_year_id', 'left');
              
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('C.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('C.user_id', logged_in_user_id());
        $this->db->order_by('C.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    public function get_single_complain($id){
        
        $this->db->select('C.*, T.type, S.school_name, AY.session_year');
        $this->db->from('complains AS C');
        $this->db->join('complain_types AS T', 'T.id = C.type_id', 'left'); 
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = C.academic_year_id', 'left');
        $this->db->where('C.id', $id);
       
        
        return $this->db->get()->row();        
    } 
}
