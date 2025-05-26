<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth_Model
 *
 * @author 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purpose_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_purpose($schol_id = null){        
        
        $this->db->select('P.*, S.school_name');
        $this->db->from('visitor_purposes AS P');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('P.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $schol_id){
            $this->db->where('P.school_id', $schol_id);
        }
          
        $this->db->where('S.status', 1);
         
        $this->db->order_by('P.id', 'ASC');
        
        return $this->db->get()->result();
    }
    
    
    function duplicate_check($school_id, $purpose, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('purpose', $purpose);
        $this->db->where('school_id', $school_id);
        return $this->db->get('visitor_purposes')->num_rows();            
    }
}
