<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userleave_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_type(){        
        
        $this->db->select('T.*');
        $this->db->from('leave_types AS T');
        
        
        if(logged_in_role_id() == GUARDIAN){
            $this->db->where('T.role_id', STUDENT);
        }else{
            $this->db->where('T.role_id', logged_in_role_id());
        }
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }  
               
        $this->db->order_by('T.id', 'ASC');
        
        return $this->db->get()->result();
    }
    
     public function get_application_list(){
         
        $this->db->select('A.*, T.type, T.total_leave, R.name AS role_name, S.school_name, AY.session_year');
        $this->db->from('leave_applications AS A');
        $this->db->join('leave_types AS T', 'T.id = A.type_id', 'left'); 
        $this->db->join('roles AS R', 'R.id = A.role_id', 'left');
        $this->db->join('schools AS S', 'S.id = A.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('A.school_id', $this->session->userdata('school_id'));
        }
        
         if(logged_in_role_id() == GUARDIAN){
            $this->db->where('A.created_by', logged_in_user_id());
        }else{
            $this->db->where('A.user_id', logged_in_user_id());
        }
        
        
        $this->db->order_by('A.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_application($id){
        
        $this->db->select('A.*, T.type, T.total_leave,  R.name AS role_name, S.school_name, AY.session_year');
        $this->db->from('leave_applications AS A');
        $this->db->join('leave_types AS T', 'T.id = A.type_id', 'left'); 
        $this->db->join('roles AS R', 'R.id = A.role_id', 'left');
        $this->db->join('schools AS S', 'S.id = A.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        $this->db->where('A.id', $id);
        return $this->db->get()->row();        
    } 
}
