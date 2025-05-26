<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     function get_single_category($id = null)
      {
        $this->db->select('fc.`category_name`, s.`school_name`');
        $this->db->from('facility_categories AS FC');
        $this->db->join('schools AS S', 's.`id`=FC.`school_id`', 'left');
        $this->db->where('FC.id', $id);
        return $this->db->get()->row();
      } 
       
    public function get_category_list($school_id = null){
        
        $this->db->select('FC.*, S.school_name');
        $this->db->from('facility_categories AS FC');
        $this->db->join('schools AS S', 'S.id = FC.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('FC.school_id', $this->session->userdata('school_id'));
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('FC.school_id', $school_id);
        }
        
        $this->db->where('S.status', 1);
        $this->db->order_by('FC.id', 'ASC');
        return $this->db->get()->result();
        
    }
}
