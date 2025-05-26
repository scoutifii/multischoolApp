<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absentemailsms_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    } 
    
    public function get_email_list($school_id = null){
        
        $this->db->select('E.*, SC.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('emails AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = E.school_id', 'left');
         
        $this->db->where('E.email_type', 'absent');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('E.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('E.school_id', $school_id);
        }
        $this->db->where('SC.status', 1);
        $this->db->order_by('E.id', 'DESC');
        
        return $this->db->get()->result();    
    }
    
     public function get_sms_list($school_id = null){
         
        $this->db->select('TM.*, SC.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('text_messages AS TM');
        $this->db->join('roles AS R', 'R.id = TM.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TM.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = TM.school_id', 'left');
        $this->db->where('TM.sms_type', 'absent');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('TM.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('TM.school_id', $school_id);
        }
        $this->db->where('SC.status', 1);
        $this->db->order_by('TM.id', 'DESC');
        
        return $this->db->get()->result();    
    }
    
    public function get_single_email($id){
        $this->db->select('E.*,  SC.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('emails AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = E.school_id', 'left');
        $this->db->where('E.id', $id);
        return $this->db->get()->row();    
    }
    
    public function get_single_sms($id){
        $this->db->select('TM.*, SC.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('text_messages AS TM');
        $this->db->join('roles AS R', 'R.id = TM.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TM.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = TM.school_id', 'left');
        $this->db->where('TM.id', $id);
        return $this->db->get()->row();    
    }

    public function get_user_list( $school_id, $role_id, $receiver_id, $class_id = null, $academic_year_id = null){
        
        if($role_id == STUDENT OR $role_id == GUARDIAN ){
            
            $this->db->select('E.student_id, S.guardian_id, S.phone, S.name, S.email, U.role_id, U.id,  C.name AS class_name');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
            
            if($academic_year_id){
                $this->db->where('E.academic_year_id', $academic_year_id);
            }            
            if($class_id){
                $this->db->where('E.class_id', $class_id);
            }
            if($receiver_id > 0){                
                $this->db->where('S.user_id', $receiver_id);
            }
            if($school_id){
                $this->db->where('E.school_id', $school_id);
            }
            $this->db->where('S.status_type', 'regular');
             
            return $this->db->get()->result(); 
            
        }elseif($role_id == TEACHER){
            
            $this->db->select('T.id AS teacher_id, T.phone, T.name, T.email, U.role_id,  U.id');
            $this->db->from('teachers AS T');
            $this->db->join('users AS U', 'U.id = T.user_id', 'left');
            if($receiver_id > 0){
                $this->db->where('T.user_id', $receiver_id);
            }
            if($school_id){
                $this->db->where('T.school_id', $school_id);
            }
            return $this->db->get()->result();            
            
        }else{
            
            $this->db->select('E.id AS employee_id, E.phone, E.name, E.email, U.role_id,  U.id');
            $this->db->from('employees AS E');
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            if($receiver_id > 0){
                $this->db->where('E.user_id', $receiver_id);
            }
            if($school_id){
                $this->db->where('E.school_id', $school_id);
            }
            
            return $this->db->get()->result();
        }  
    }
    
    public function get_single_student($guardian_id, $class_id, $school_id){
        
        $this->db->select('S.id');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');      
        $this->db->where('E.class_id', $class_id);
        $this->db->where('S.guardian_id', $guardian_id);
        $this->db->where('S.school_id', $school_id);
        return $this->db->get()->row();        
    }

}
