<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Meritlist_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
    public function get_merit_list($school_id, $academic_year_id, $class_id, $section_id){
        
        $this->db->select('FR.*, G.name AS grade, E.roll_no, ST.name AS student, ST.photo, C.name AS class_name, S.name AS section, AY.session_year');
        $this->db->from('final_results AS FR');   
        $this->db->join('enrollments AS E', 'E.student_id = FR.student_id', 'left');
        $this->db->join('students AS ST', 'ST.id = E.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = E.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
               
      
        $this->db->where('FR.school_id', $school_id);
             
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id);
        }       
        
        if($class_id != ''){
           $this->db->where('E.class_id', $class_id);
        } 
        if($section_id != ''){
           $this->db->where('E.section_id', $section_id);
        } 
        $this->db->where('ST.status_type', 'regular');
        //$this->db->order_by('E.roll_no', 'ASC');
        $this->db->order_by('FR.avg_grade_point', 'DESC');
        //$this->db->order_by('FR.total_obtain_mark', 'DESC');
              
        return $this->db->get()->result();   
       
    }    
  

}
