<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_vehicle_list($school_id = null){
        
        $this->db->select('V.*, S.school_name');
        $this->db->from('vehicles AS V');
        $this->db->join('schools AS S', 'S.id = V.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('V.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('V.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('V.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    public function get_single_vehicle($vehicle_id){
        
        $this->db->select('V.*, S.school_name');
        $this->db->from('vehicles AS V');
        $this->db->join('schools AS S', 'S.id = V.school_id', 'left');
        $this->db->where('V.id', $vehicle_id);
        
        return $this->db->get()->row();
        
    }
    
    function duplicate_check($school_id, $number, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('number', $number);
        return $this->db->get('vehicles')->num_rows();            
    }

}
