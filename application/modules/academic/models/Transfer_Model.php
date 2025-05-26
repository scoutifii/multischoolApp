<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
      
     public function get_teacher_list($school_id = null){
        
        $this->db->select('T.*');
        $this->db->from('teachers AS T');        
        /*$this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);       
        $this->db->where('E.class_id', $class_id);*/
        $this->db->where('T.school_id', $school_id);
        $this->db->where('T.status', 1);
        
        $this->db->order_by('T.teacher_no', 'ASC');
       
        return $this->db->get()->result();        
    }

}
