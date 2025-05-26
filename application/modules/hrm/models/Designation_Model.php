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

class Designation_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_designation(){        
        
        $this->db->select('D.*, S.school_name');
        $this->db->from('designations AS D');
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('D.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->order_by('D.id', 'ASC');
        
        return $this->db->get()->result();
    }
    
    
    function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('name', $name);
        $this->db->where('school_id', $school_id);
        return $this->db->get('designations')->num_rows();            
    }
}
