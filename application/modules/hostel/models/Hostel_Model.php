<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostel_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_hostel_list($school_id = null){
        
        $this->db->select('H.*, S.school_name');
        $this->db->from('hostels AS H');
        $this->db->join('schools AS S', 'S.id = H.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('H.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('H.school_id', $school_id);
        }   
        $this->db->where('S.status', 1);
        $this->db->order_by('H.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_hostel($hostel_id){
        
        $this->db->select('H.*, S.school_name');
        $this->db->from('hostels AS H');
        $this->db->join('schools AS S', 'S.id = H.school_id', 'left');
        $this->db->where('H.id', $hostel_id);
        return $this->db->get()->row();
        
    }
    
    function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('hostels')->num_rows();            
    }
}
