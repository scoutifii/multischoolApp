<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Division_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($division_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('division_name', $division_name);
        return $this->db->get('divisions')->num_rows();            
    }
}