<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_payment_setting_list(){
        
        $this->db->select('PS.*, S.school_name');
        $this->db->from('payment_settings AS PS');
        $this->db->join('schools AS S', 'S.id = PS.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('PS.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->where('S.status', 1);
        return $this->db->get()->result();
        
    }
    
     public function get_single_payment_setting($setting_id){
        
        $this->db->select('PS.*, S.school_name');
        $this->db->from('payment_settings AS PS');
        $this->db->join('schools AS S', 'S.id = PS.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('PS.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('PS.id', $setting_id);
        return $this->db->get()->row();
        
    }
    
    
    function duplicate_check($school_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        return $this->db->get('payment_settings')->num_rows();            
    }

}
