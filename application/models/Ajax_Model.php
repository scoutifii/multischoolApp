<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_student_list($class_id, $school_id, $academic_year_id){
        $this->db->select('E.roll_no,  S.id, S.user_id, S.name');
        $this->db->from('enrollments AS E');        
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id);
        }
        $this->db->where('E.class_id', $class_id);       
        $this->db->where('E.school_id', $school_id);       
        $this->db->where('S.status_type', 'regular');       
        return $this->db->get()->result();       
    }
    
    public function get_student_list_by_section($school_id = null, $section_id = null, $status_type = null){
        
        $school = $this->get_school_by_id($school_id);
        
        $this->db->select('E.roll_no, S.name, S.id');
        $this->db->from('enrollments AS E');        
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        if(!empty($school)){
             $this->db->where('E.academic_year_id', $school->academic_year_id); 
             $this->db->where('E.school_id', $school_id); 
        } 
        
        $this->db->where('E.section_id', $section_id);
       
        if($this->session->userdata('role_id') == GUARDIAN){
            $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));
        }
        if($status_type){
            $this->db->where('S.status_type', $status_type);
        }
        
        return $this->db->get()->result();        
    }
    
    public function get_user_list($school_id, $type) {
        
        if ($type == 'teacher') {
            
            $this->db->select('T.name, T.user_id, T.responsibility AS designation, SG.grade_name, U.username, U.role_id');
            $this->db->from('teachers AS T');
            $this->db->join('users AS U', 'U.id = T.user_id', 'left');  
            $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left');
            $this->db->where('T.salary_grade_id >', 0);
            $this->db->where('T.school_id', $school_id);
            $this->db->order_by('T.id', 'ASC');
            return $this->db->get()->result();
            
        } elseif ($type == 'employee') { 
            
            $this->db->select('E.name, E.user_id, SG.grade_name, U.username, U.role_id, D.name AS designation');
            $this->db->from('employees AS E');
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->join('designations AS D', 'D.id = E.designation_id', 'left'); 
            $this->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left'); 
            $this->db->where('E.salary_grade_id >', 0);
             $this->db->where('E.school_id', $school_id);
            $this->db->order_by('E.id', 'ASC');
            return $this->db->get()->result();
            
        } else {
            return array();
        }
    }
      
    public function get_subcounty_list($region_id){
        $this->db->select('R.region_name, SR.sub_region_name, D.district_name, SC.sub_county_name');
        $this->db->from('regions AS R');        
        $this->db->join('subregion AS SR', 'R.id = SR.region_id', 'left');
        $this->db->join('district AS D', 'SR.id = D.sub_region_id', 'left');
        $this->db->join('subcounty AS SC', 'SC.district_id=D.id', 'left');
        $this->db->where('SC.region_id=D.region_id');
        
        return $this->db->get()->result();       
    }


     public function get_subcounty_list_by_district($region_id = null, $district_id = null){
        $region = $this->get_region_by_id($region_id);
        $this->db->select('SC.sub_county_name, D.id');
        $this->db->from('subcounty AS SC');        
        $this->db->join('district AS D', 'D.id = SC.district_id', 'left');
        if (!empty($region)) {
            $this->db->where('SC.region_id', $region_id);
        }
        
        $this->db->where('SC.district_id', $district_id);
              
        return $this->db->get()->result();       
    }

    public function get_teacher_by_class($school_id){
        
        $this->db->select('T.name, T.responsibility');
        $this->db->from('classes AS C');        
        $this->db->join('teachers AS T', 'T.id = C.teacher_id', 'left');
        $this->db->where('C.school_id', $school_id);        
        
        return $this->db->get()->result();        
    }

    public function get_lesson_by_subject($subject_id, $academic_year_id){
                
        $this->db->select('LD.*');
        $this->db->from('lp_lesson_details AS LD');
        $this->db->join('lp_lessons AS L', 'L.id = LD.lesson_id', 'left');  
        $this->db->where('L.subject_id', $subject_id);
        $this->db->where('L.academic_year_id', $academic_year_id);
        $this->db->order_by('LD.id', 'ASC');
        return $this->db->get()->result();
        
    }

    public function get_term_list_by_academic_year($school_id){
        
        $this->db->select('ST.*');
        $this->db->from('school_term AS ST');
        $this->db->where('ST.academic_year_id', $this->academic_year_id);
        $this->db->where('ST.school_id', $school_id);

        return $this->db->get()->result();        
    }
}
