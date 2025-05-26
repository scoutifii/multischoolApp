<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smstemplate_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_template_list($school_id = null){
        $this->db->select('T.*, R.name AS receiver_type , S.school_name');
        $this->db->from('sms_templates AS T');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
        $this->db->join('roles AS R', 'R.id = T.role_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }
         if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('T.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('T.id', 'ASC');
        
        return $this->db->get()->result();    
    }
        
    function duplicate_check($school_id, $title, $role_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        $this->db->where('role_id', $role_id);
        return $this->db->get('sms_templates')->num_rows();            
    }
}
