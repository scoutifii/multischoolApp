<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_event_list($school_id = null){
        
        $this->db->select('E.*, S.school_name, R.name');
        $this->db->from('events AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('E.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('E.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('E.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_event($id){
        
        $this->db->select('E.*, S.school_name, R.name');
        $this->db->from('events AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
        $this->db->where('E.id', $id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($school_id, $title, $event_from, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        $this->db->where('event_from', date('Y-m-d', strtotime($event_from)));
        return $this->db->get('events')->num_rows();            
    }

}
