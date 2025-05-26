<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subcounty_Model extends MY_Model {
    
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

    public function get_single_sub_county($id){
        
        $this->db->select('R.region_name, SR.sub_region_name, D.district_name, SC.sub_county_code, SC.sub_county_name');
        $this->db->from('subcounty AS SC');
        $this->db->join('district AS D', 'D.id = SC.district_id', 'left');
        $this->db->join('subregion AS SR', 'SR.id = SC.sub_region_id');
        $this->db->join('regions AS R', 'R.id = SC.region_id');
        $this->db->where('SC.id', $id);
        return $this->db->get()->row();
        
    }
}
