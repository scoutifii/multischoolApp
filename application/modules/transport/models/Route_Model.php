<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Route_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_route_list($school_id = null){
        
        $this->db->select('R.*, S.school_name');
        $this->db->from('routes AS R');
        $this->db->join('schools AS S', 'S.id = R.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('R.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('R.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('R.id', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_single_route($route_id){
        
        $this->db->select('R.*, S.school_name');
        $this->db->from('routes AS R');
        $this->db->join('schools AS S', 'S.id = R.school_id', 'left');
        $this->db->where('R.id', $route_id);
        return $this->db->get()->row();
    }
    
    
     public function get_vehicle_list($school_id = null, $route_id = null ){
         
        $route = $this->route->get_single('routes', array('id' => $route_id, 'school_id'=>$school_id));
        
        if(isset($route->vehicle_ids) && $route->vehicle_ids != '' && $route_id){
            $sql = "SELECT * FROM `vehicles` WHERE `id` IN($route->vehicle_ids) OR status = 1 AND school_id = $school_id";
        } else {
            $sql = "SELECT * FROM `vehicles` WHERE status = 1 AND school_id = $school_id";
        }
        
        return $this->db->query($sql)->result();
    }

    function duplicate_check($school_id, $number, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $number);
        return $this->db->get('routes')->num_rows();            
    }

}
