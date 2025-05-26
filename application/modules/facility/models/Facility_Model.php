<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Facility_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    function duplicate_check($facility_name, $id = null){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('facility_name', $facility_name);
        return $this->db->get('school_facilities')->num_rows();            
    }

    function get_facility_list($school_id = null){
        $this->db->select('SF.*, S.school_name');
        $this->db->from('school_facilities AS SF');
        $this->db->join('schools AS S', 'S.id = SF.school_id', 'left');
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('SF.school_id', $this->session->userdata('school_id'));
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('SF.school_id', $school_id);
        }
        
        $this->db->where('S.status', 1);
        $this->db->order_by('SF.id', 'ASC');
        return $this->db->get()->result();
    }

    function get_single_facility($id = null){
        $this->db->select('SF.facility_name, SF.facility_no, fc.`category_name`, s.`school_name`');
        $this->db->from('school_facilities AS SF');
        $this->db->join('facility_categories AS FC', 'fc.`id`=sf.`category_id`', 'left');
        $this->db->join('schools AS S', 's.`id`=sf.`school_id`', 'left');
        $this->db->where('SF.id', $id);
        return $this->db->get()->row();
    }
}
