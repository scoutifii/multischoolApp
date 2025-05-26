<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_message_list($type){
        
        $this->db->select('MR.*, M.*, S.school_name');
        $this->db->from('message_relationships AS MR');
        $this->db->join('messages AS M', 'M.id = MR.message_id', 'left');
        $this->db->join('schools AS S', 'S.id = MR.school_id', 'left');
        
        if($type == 'draft'){
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_draft', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.sender_id', logged_in_user_id());
        }
        if($type == 'inbox'){
            
            $this->db->where('MR.is_trash', 0);
            $this->db->where('MR.status', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.receiver_id', logged_in_user_id());
            
        }
        if($type == 'new'){
            $this->db->where('MR.status', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.is_read', 0);
            $this->db->where('MR.receiver_id', logged_in_user_id());
        }
        if($type == 'trash'){
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_trash', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
        }
        if($type == 'sent'){
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_draft', 0);
            $this->db->where('MR.is_trash', 0);
            $this->db->where('MR.sender_id', logged_in_user_id());
            $this->db->where('MR.owner_id', logged_in_user_id());
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('MR.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('S.status', 1);
        return $this->db->get()->result();
        
    }
    
    public function get_single_message($id){
        $this->db->select('MR.*, M.*, S.school_name');
        $this->db->from('message_relationships AS MR');
        $this->db->join('messages AS M', 'M.id = MR.message_id', 'left');
        $this->db->join('schools AS S', 'S.id = MR.school_id', 'left');
        $this->db->where('MR.message_id', $id);
        $this->db->where('MR.owner_id', logged_in_user_id());
        return $this->db->get()->row();
    }

}
