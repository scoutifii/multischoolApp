<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grade_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function get_garde_list($school_id = null){
        
        $this->db->select('G.*, S.school_name');
        $this->db->from('grades AS G');
        $this->db->join('schools AS S', 'S.id = G.school_id', 'left');
        
        if($school_id){
            $this->db->where('G.school_id', $school_id);
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('G.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('S.status', 1);
        
        return $this->db->get()->result();
    }
   
    
    function duplicate_check($field, $school_id, $value, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where($field, $value);
        $this->db->where('school_id', $school_id);
        return $this->db->get('grades')->num_rows();            
    }

}
