<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class District_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($district_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('district_name', $district_name);
        return $this->db->get('district')->num_rows();            
    }
}
