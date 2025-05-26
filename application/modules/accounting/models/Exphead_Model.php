<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exphead_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
     public function get_exphead_list($school_id = null){
        
        $this->db->select('H.*, S.school_name');
        $this->db->from('expenditure_heads AS H');
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
     function duplicate_check($school_id, $title, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        return $this->db->get('expenditure_heads')->num_rows();            
    }

}
