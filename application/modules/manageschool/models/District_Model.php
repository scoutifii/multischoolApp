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

    public function get_single_district($id){
        
        $this->db->select('R.region_name, SR.sub_region_name, D.district_name, D.district_code');
        $this->db->from('district AS D');
        $this->db->join('subregion AS SR', 'SR.id = D.sub_region_id', 'left');
        $this->db->join('regions AS R', 'R.id = D.region_id', 'left');
        $this->db->where('D.id', $id);
        return $this->db->get()->row();
        
    }
}
