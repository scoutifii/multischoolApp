<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_sms_setting_list(){
        
        $this->db->select('SS.*, S.school_name');
        $this->db->from('sms_settings AS SS');
        $this->db->join('schools AS S', 'S.id = SS.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('SS.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('S.status', 1);
        return $this->db->get()->result();
        
    }
    
     public function get_single_sms_setting($setting_id){
        
        $this->db->select('SS.*, S.school_name');
        $this->db->from('sms_settings AS SS');
        $this->db->join('schools AS S', 'S.id = SS.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('SS.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('SS.id', $setting_id);
        return $this->db->get()->row();
        
    }
    
    
    function duplicate_check($school_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        return $this->db->get('sms_settings')->num_rows();            
    }

}
