<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ebook_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_ebook_list($class_id = null, $school_id = null ){
        
        if(!$class_id){
           $class_id = $this->session->userdata('class_id');
        }
         
        $this->db->select('B.*, SC.school_name, C.name AS class_name, S.name AS subject');
        $this->db->from('ebooks AS B');
        $this->db->join('classes AS C', 'C.id = B .class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = B.subject_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = B.school_id', 'left');
        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }
        
        if($class_id){
            $this->db->where('B.class_id', $class_id);
        }
        if($school_id){
            $this->db->where('B.school_id', $school_id);
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('B.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('SC.status', 1);
        return $this->db->get()->result();
        
    }
    
    public function get_single_ebook($id){
        
        $this->db->select('B.*, SC.school_name, C.name AS class_name, S.name AS subject');
        $this->db->from('ebooks AS B');
        $this->db->join('classes AS C', 'C.id = B .class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = B.subject_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = B.school_id', 'left');
        $this->db->where('B.id', $id);
        return $this->db->get()->row();
        
    } 
}
