<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_single_employee($id){
        
        $this->db->select('E.*, U.username, U.role_id, D.name AS designtion');
        $this->db->from('employees AS E');
        $this->db->join('users AS U', 'U.id = E.user_id', 'left');
        $this->db->join('designations AS D', 'D.id = E.designation_id', 'left');
        $this->db->where('E.user_id', $id);
        return $this->db->get()->row();        
    }
    
    
    public function get_student_list($guardian_id, $academic_year_id){
        
        $this->db->select('S.*, E.roll_no, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);
        $this->db->where('S.guardian_id', $guardian_id);
        return $this->db->get()->result();
   }
   
   
   public function get_single_guardian($id){
        
        $this->db->select('G.*, U.username, U.role_id, R.name as role');
        $this->db->from('guardians AS G');
        $this->db->join('users AS U', 'U.id = G.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('G.id', $id);
        return $this->db->get()->row();
        
    }
    
    public function get_invoice_list($student_id){

        $this->db->select('I.*, S.name AS student_name, AY.session_year, C.name AS class_name');
        $this->db->from('invoices AS I');        
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.student_id', 'left');        
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');        
        $this->db->where('I.invoice_type !=', 'income'); 
        $this->db->where('I.student_id', $student_id);        
        $this->db->where('I.paid_status !=', 'paid');                
        $this->db->order_by('I.id', 'DESC');  
        return $this->db->get()->result();  

    }

    public function get_activity_list($student_id){
        
        $this->db->select('SA.*, ST.name AS student, ST.phone, C.name AS class_name, S.name as section, AY.session_year');
        $this->db->from('student_activities AS SA');
        $this->db->join('students AS ST', 'ST.id = SA.student_id', 'left');
        $this->db->join('classes AS C', 'C.id = SA.class_id', 'left');
        $this->db->join('sections AS S', 'S.id = SA.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = SA.academic_year_id', 'left');
        $this->db->where('SA.student_id', $student_id);
        return $this->db->get()->result();
    } 

    public function get_school_list($district_id){
        
        $this->db->select('D.district_name AS district, S.school_name AS school');
        $this->db->from('district AS D');
        $this->db->join('schools AS S', 'S.district_id = D.id', 'left');
        $this->db->where('S.district_id', $district_id);
        return $this->db->get()->result();
    } 
}