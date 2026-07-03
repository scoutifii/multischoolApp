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

    public function get_teacher_transfer_list(){

        $this->db->select('T.name AS teacher, T.photo, T.phone, S1.school_name AS original_school, S2.school_name AS current_school');
        $this->db->from('teacher_transfers AS TT');
        $this->db->join('teachers AS T', 'T.id = TT.teacher_id', 'inner');
        $this->db->join('schools AS S1', 'S1.id = TT.school_id', 'inner');
        $this->db->join('schools AS S2', 'S2.id = TT.next_school_id', 'inner');

        return $this->db->get()->result();
    }

}
