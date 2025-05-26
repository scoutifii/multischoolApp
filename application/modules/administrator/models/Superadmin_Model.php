<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Superadmin_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_superadmin_list(){
        
        $this->db->select('SA.*, U.username, U.role_id, R.name AS role');
        $this->db->from('system_admin AS SA');
        $this->db->join('users AS U', 'U.id = SA.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
     
        return $this->db->get()->result();
        
    }
    
    public function get_single_superadmin($id){
        
        $this->db->select('SA.*, U.username, U.role_id, R.name AS role');
        $this->db->from('system_admin AS SA');
        $this->db->join('users AS U', 'U.id = SA.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('SA.id', $id);
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
