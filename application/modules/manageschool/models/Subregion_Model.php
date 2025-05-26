<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subregion_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($sub_region_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('sub_region_name', $sub_region_name);
        return $this->db->get('subregion')->num_rows();            
    }

    public function get_single_sub_region($id){
        
        $this->db->select('SR.*, R.region_name');
        $this->db->from('subregion AS SR');
        $this->db->join('regions AS R', 'R.id=SR.region_id', 'left');
        $this->db->where('SR.id', $id);
        return $this->db->get()->row();
    }

}
