<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth_Model
 *
 * @author Nafeesa
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Type_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_type($schol_id = null){        
        
        $this->db->select('T.*, S.school_name');
        $this->db->from('complain_types AS T');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $schol_id){
            $this->db->where('T.school_id', $schol_id);
        }
        $this->db->where('S.status', 1);       
        $this->db->order_by('T.id', 'DESC');
        
        return $this->db->get()->result();
    }
    
    
    function duplicate_check($school_id, $type, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('type', $type);
        $this->db->where('school_id', $school_id);
        return $this->db->get('complain_types')->num_rows();            
    }
}
