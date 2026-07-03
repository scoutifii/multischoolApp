<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Districtadmin_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_districtadmin_list(){
        
        $this->db->select('DA.*, U.username, U.role_id, R.name AS role, D.district_name');
        $this->db->from('district_admin AS DA');
        $this->db->join('users AS U', 'U.id = DA.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('district AS D', 'D.id = DA.district_id', 'left');
     
        return $this->db->get()->result();
        
    }
    
    public function get_single_districtadmin($id){
        
        $this->db->select('DA.*, U.username, U.role_id, R.name AS role, D.district_name');
        $this->db->from('district_admin AS DA');
        $this->db->join('users AS U', 'U.id = DA.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('district AS D', 'D.id = DA.district_id', 'left');
        $this->db->where('DA.id', $id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($username, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('username', $username);
        return $this->db->get('users')->num_rows();            
    }
}
