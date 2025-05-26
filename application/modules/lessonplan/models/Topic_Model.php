<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topic_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_topic_list($school_id, $class_id = null, $subject_id = null, $academic_year_id = null){
          
        $this->db->select('T.*,  SC.school_name, LD.title, C.name AS class_name, S.name AS subject, S.teacher_id, AY.session_year');
        $this->db->from('lp_topics AS T');   
        $this->db->join('lp_lesson_details AS LD', 'LD.id = T.lesson_detail_id', 'left');
        $this->db->join('classes AS C', 'C.id = T.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = T.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = T.school_id', 'left');
        
        if($school_id){
           $this->db->where('T.school_id', $school_id); 
        }        
        if($class_id > 0){
             $this->db->where('T.class_id', $class_id);
        }        
        if($academic_year_id){
            $this->db->where('T.academic_year_id', $academic_year_id);
        }
        
        if($subject_id){
            $this->db->where('T.subject_id', $subject_id);
        } 
          
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();        
        
    }
    
    
     public function get_single_topic($id){
         
         $this->db->select('T.*,  SC.school_name, LD.title, C.name AS class_name, S.name AS subject, S.teacher_id, AY.session_year');
        $this->db->from('lp_topics AS T');   
        $this->db->join('lp_lesson_details AS LD', 'LD.id = T.lesson_detail_id', 'left');
        $this->db->join('classes AS C', 'C.id = T.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = T.subject_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = T.school_id', 'left');
        $this->db->where('T.id', $id);
        return $this->db->get()->row();
        
    }

   
}