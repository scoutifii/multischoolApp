<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parish_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($parish_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('parish_name', $parish_name);
        return $this->db->get('parish')->num_rows();            
    }

    public function get_single_parish($id){
        
        $this->db->select('P.`parish_code`, P.`parish_name`, sc.`sub_county_name`, d.`district_name`, SR.`sub_region_name`, r.`region_name`');
        $this->db->from('parish AS P');
        $this->db->join('subcounty AS SC', 'sc.`id`=P.`sub_county_id`', 'left');
        $this->db->join('district AS D', 'd.`id`=P.`district_id`', 'left');
        $this->db->join('subregion AS SR', 'sr.`id`=P.`sub_region_id`', 'left');
        $this->db->join('regions AS R', 'r.`id`=P.`region_id`', 'left');
        $this->db->where('P.id', $id);
        return $this->db->get()->row();
        
    }
}
