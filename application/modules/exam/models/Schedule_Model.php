<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schedule_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_schedule_list($class_id = null, $school_id = null, $academic_year_id = null, $term_id = null ){
        
        if(!$class_id){
           $class_id = $this->session->userdata('class_id');
        } 
       
        $this->db->select('ES.*, SC.school_name, E.title, C.name AS class_name, S.name AS subject, AY.session_year, ST.name AS term');
        $this->db->from('exam_schedules AS ES');
        $this->db->join('classes AS C', 'C.id = ES.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = ES.subject_id', 'left');
        $this->db->join('exams AS E', 'E.id = ES.exam_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = ES.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = ES.school_id', 'left');
        $this->db->join('school_term AS ST', 'ST.id = ES.term_id', 'left');
        
        if($academic_year_id){
            $this->db->where('ES.academic_year_id', $academic_year_id);
        }
        if($term_id){
          $this->db->where('ES.term_id', $term_id);
        }       
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }        
        if($class_id > 0){
            $this->db->where('ES.class_id', $class_id);            
        }
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('ES.school_id', $school_id); 
        }         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('ES.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('SC.status', 1);
        
        $this->db->order_by('ES.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    
     public function get_single_schedule($id){
         
        $this->db->select('ES.*,  SC.school_name, E.title, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('exam_schedules AS ES');
        $this->db->join('classes AS C', 'C.id = ES.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = ES.subject_id', 'left');
        $this->db->join('exams AS E', 'E.id = ES.exam_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = ES.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = ES.school_id', 'left');
        $this->db->where('ES.id', $id);
        return $this->db->get()->row();
        
    }

    
     function duplicate_check($school_id, $academic_year_id, $exam_id, $class_id, $subject_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);              
        $this->db->where('academic_year_id', $academic_year_id);     
        
        return $this->db->get('exam_schedules')->num_rows();            
    }
    
     function duplicate_room_check($school_id, $academic_year_id, $room_no, $exam_date, $start_time, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('room_no', $room_no);
        $this->db->where('exam_date', $exam_date);
        $this->db->where('start_time', $start_time);      
        $this->db->where('academic_year_id', $academic_year_id);           
        
        return $this->db->get('exam_schedules')->num_rows();            
    }

}
