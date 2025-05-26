<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Discount_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
     public function get_discount_list($school_id = null){
        
        $this->db->select('D.*, S.school_name');
        $this->db->from('discounts AS D');        
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('D.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('D.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('D.id', 'ASC');
        return $this->db->get()->result();        
    }
    
    public function get_single_discount($id){
        
        $this->db->select('D.*, S.school_name');
        $this->db->from('discounts AS D');        
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
        $this->db->where('D.id', $id);
        return $this->db->get()->row();        
    }
    
     function duplicate_check($school_id, $title, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        return $this->db->get('discounts')->num_rows();            
    }

}
