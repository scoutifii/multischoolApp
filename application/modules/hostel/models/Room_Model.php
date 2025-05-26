<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Room_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_room_list($school_id = null){
        
        $this->db->select('R.*, S.school_name, H.name AS hostel_name');
        $this->db->from('rooms AS R');
        $this->db->join('hostels AS H', 'H.id = R.hostel_id', 'left');
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
    
    public function get_single_room($id){
        
        $this->db->select('R.*, S.school_name, H.name AS hostel_name');
        $this->db->from('rooms AS R');
        $this->db->join('hostels AS H', 'H.id = R.hostel_id', 'left');
        $this->db->join('schools AS S', 'S.id = R.school_id', 'left');
        $this->db->where('R.id', $id);
        return $this->db->get()->row();        
    }
    
   function duplicate_check($school_id, $hostel_id, $room_no, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('hostel_id', $hostel_id);
        $this->db->where('room_no', $room_no);
        return $this->db->get('rooms')->num_rows();            
    }

}
