<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    } 
    
     public function get_page_list($school_id = null){
        
        $this->db->select('P.*, S.school_name');
        $this->db->from('pages AS P');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('P.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('P.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('P.id', 'DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function get_single_page($news_id){
        
        $this->db->select('P.*, S.school_name');
        $this->db->from('pages AS P');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        $this->db->where('P.id', $news_id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($school_id, $page_title, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);      
        $this->db->where('page_title', $page_title);      
        return $this->db->get('pages')->num_rows();            
    }

}
