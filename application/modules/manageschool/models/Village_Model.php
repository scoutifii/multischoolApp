<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Village_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($village_name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('village_name', $village_name);
        return $this->db->get('village')->num_rows();            
    }

    public function get_single_village($id){
        
        $this->db->select(' V.`village_name`, V.`village_code`, P.`parish_name`, sc.`sub_county_name`, d.`district_name`, SR.`sub_region_name`, r.`region_name`');
        $this->db->from('village AS V');
        $this->db->join('parish AS P', 'p.`id`=V.`parish_id`', 'left');
        $this->db->join('subcounty AS SC', 'sc.`id`=v.`sub_county_id`', 'left');
        $this->db->join('district AS D', 'd.`id`=v.`district_id`', 'left');
        $this->db->join('subregion AS SR', 'sr.`id`=v.`sub_region_id`', 'left');
        $this->db->join('regions AS R', 'r.`id`=v.`region_id`', 'left');
        $this->db->where('V.id', $id);
        return $this->db->get()->row();
        
    }
}
