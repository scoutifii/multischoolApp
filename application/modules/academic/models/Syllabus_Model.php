<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Syllabus_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_syllabus_list($class_id = null, $school_id = null){
        
        if(!$class_id){
           $class_id = $this->session->userdata('class_id');
        }
         
        $this->db->select('SY.*, SC.school_name, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('syllabuses AS SY');
        $this->db->join('classes AS C', 'C.id = SY.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = SY.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SY.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = SY.school_id', 'left');
        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }
        
        if($class_id){
            $this->db->where('SY.class_id', $class_id);
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('SY.school_id', $school_id); 
        } 
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('SY.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('SC.status', 1);
        $this->db->order_by('SY.id', 'DESC');
       
        return $this->db->get()->result();
        
    }
    
    public function get_single_syllabus($id){
        
        $this->db->select('SY.*, SC.school_name, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('syllabuses AS SY');
        $this->db->join('classes AS C', 'C.id = SY.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = SY.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SY.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = SY.school_id', 'left');
        $this->db->where('SY.id', $id);
        return $this->db->get()->row();
        
    } 
}
