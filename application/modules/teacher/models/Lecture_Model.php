<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lecture_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_lecture_list($school_id = null, $academic_year_id = null, $class_id = null, $section_id = null){
         
        $this->db->select('L.*, T.name AS teacher, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year');
        $this->db->from('video_lectures AS L');
        $this->db->join('teachers AS T', 'T.id = L.teacher_id', 'left');
        $this->db->join('classes AS C', 'C.id = L.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = L.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = L.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = L.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = L.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('L.academic_year_id', $academic_year_id);
        }
        
        if($class_id){
             $this->db->where('L.class_id', $class_id);
        } 
        if($section_id){
             $this->db->where('L.section_id', $section_id);
        } 
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('L.school_id', $school_id); 
        }        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('L.school_id', $this->session->userdata('school_id'));
        }
	
	if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('L.teacher_id', $this->session->userdata('profile_id'));
        }
		 
	if($this->session->userdata('role_id') == STUDENT){
            $this->db->where('L.section_id', $this->session->userdata('section_id'));
        }	 
	$this->db->where('SC.status', 1);	 
        $this->db->order_by('L.id', 'DESC');
        
        
        return $this->db->get()->result();
        
    }
    
    
    public function get_single_lecture($id){
        
        $this->db->select('L.*, T.name AS teacher, SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year');
        $this->db->from('video_lectures AS L');
        $this->db->join('teachers AS T', 'T.id = L.teacher_id', 'left');
        $this->db->join('classes AS C', 'C.id = L.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = L.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = L.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = L.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = L.school_id', 'left');
        $this->db->where('L.id', $id);
        return $this->db->get()->row();    
        
    } 
    
    public function get_teacher_by_subject($school_id = null, $class_id = null){
        
        $this->db->select('T.*');
        $this->db->join('subjects AS S', 'S.teacher_id = T.id', 'left');
        $this->db->join('schools AS SC', 'SC.id = T.school_id', 'left');
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('T.school_id', $school_id); 
        }        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }
        
        if($class_id){
            $this->db->where('S.class_id', $class_id);
        }
        
        $this->db->order_by('T.id', 'DESC');        
        
        return $this->db->get()->result();
    }
}
