<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Region_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($region_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('region_name', $region_name);
        return $this->db->get('regions')->num_rows();            
    }
}
