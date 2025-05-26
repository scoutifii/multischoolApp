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

class Setting_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function get_operation_list(){
        $this->db->select('O.*, M.module_name');
        $this->db->from('operations AS O');
        $this->db->join('modules AS M', 'M.id = O.module_id', 'left');
        $this->db->order_by('M.id');
        return $this->db->get()->result();
    }
    
     function duplicate_school_check($school_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_name', $school_name);
        return $this->db->get('schools')->num_rows();            
    }
}
