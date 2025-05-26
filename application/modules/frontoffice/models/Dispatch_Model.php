<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dispatch_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_dispatch($schol_id = null){        
        
        $this->db->select('D.*, S.school_name');
        $this->db->from('postal_dispatches AS D');
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('D.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $schol_id){
            $this->db->where('D.school_id', $schol_id);
        }
        $this->db->where('S.status', 1);
        
        $this->db->order_by('D.id', 'DESC');
        
        return $this->db->get()->result();
    } 
    
    public function get_single_dispatch($dispatch_id){        
        
        $this->db->select('D.*, S.school_name');
        $this->db->from('postal_dispatches AS D');
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');      
        $this->db->where('D.id', $dispatch_id);  
        
        return $this->db->get()->row();
    } 
}
