<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subregion_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($sub_county_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('sub_county_name', $sub_county_name);
        return $this->db->get('subcounty')->num_rows();            
    }
}
