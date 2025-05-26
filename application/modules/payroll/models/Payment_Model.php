<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
 
    public function get_single_payment_user($role_id, $user_id) {
        
        if ($role_id == TEACHER) {
            
            $this->db->select('T.*, T.responsibility AS designation, SG.*, U.username, U.role_id, U.status AS login_status ');
            $this->db->from('teachers AS T');
            $this->db->join('users AS U', 'U.id = T.user_id', 'left');  
            $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left'); 
            $this->db->where('T.user_id', $user_id);
            return $this->db->get()->row();
            
        } else { 
            
            $this->db->select('E.*, SG.*, U.username, U.role_id, D.name AS designation, U.status AS login_status ');
            $this->db->from('employees AS E');
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->join('designations AS D', 'D.id = E.designation_id', 'left'); 
            $this->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left'); 
            $this->db->where('E.user_id', $user_id);
            return $this->db->get()->row();
            
        } 
    }
    
    function duplicate_check($salary_month, $user_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('salary_month', $salary_month);
        $this->db->where('user_id', $user_id);
        return $this->db->get('salary_payments')->num_rows();            
    }
    
    public function get_payment_list($school_id, $user_id, $payment_to){
        
         if ($payment_to == 'employee') {
             
            $this->db->select('SP.*, SG.grade_name, E.name, E.photo,  U.username, U.role_id, D.name AS designation, U.status AS login_status ');
            $this->db->from('salary_payments AS SP');
            $this->db->join('employees AS E', 'E.user_id = SP.user_id', 'left'); 
            $this->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left');            
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->join('designations AS D', 'D.id = E.designation_id', 'left'); 
            if($user_id){
                $this->db->where('SP.user_id', $user_id);
            }
            
            $this->db->where('SP.school_id', $school_id);
            
            $this->db->where('SP.payment_to', 'employee');
            $this->db->order_by('SP.salary_month', 'ASC');
           
            return $this->db->get()->result();
            
         }else{
           
            $this->db->select('SP.*, SG.grade_name, T.name, T.photo,  T.responsibility AS designation, U.username, U.role_id, U.status AS login_status ');
            $this->db->from('salary_payments AS SP');
            $this->db->join('teachers AS T', 'T.user_id = SP.user_id', 'left'); 
            $this->db->join('users AS U', 'U.id = T.user_id', 'left');  
            $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left'); 
             if($user_id){
                $this->db->where('SP.user_id', $user_id);
             }
             
             $this->db->where('SP.payment_to', 'teacher'); 
             $this->db->order_by('SP.salary_month', 'ASC');
            return $this->db->get()->result();
             
         }
    }
    
    public function get_single_payment($payment_id, $payment_to) {
        
        if ($payment_to == 'employee') {
             
            $this->db->select('SP.*, S.school_name, SG.grade_name, E.name, E.photo,  U.username, U.role_id, D.name AS designation, U.status AS login_status ');
            $this->db->from('salary_payments AS SP');
            $this->db->join('employees AS E', 'E.user_id = SP.user_id', 'left'); 
            $this->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left');            
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->join('designations AS D', 'D.id = E.designation_id', 'left');  
            $this->db->join('schools AS S', 'S.id = SP.school_id', 'left');
            $this->db->where('SP.id', $payment_id);
            $this->db->where('SP.payment_to', 'employee');
           
            return $this->db->get()->row();
            
         }else{
           
            $this->db->select('SP.*, S.school_name, SG.grade_name, T.name, T.photo,  T.responsibility AS designation, U.username, U.role_id, U.status AS login_status ');
            $this->db->from('salary_payments AS SP');
            $this->db->join('teachers AS T', 'T.user_id = SP.user_id', 'left'); 
            $this->db->join('users AS U', 'U.id = T.user_id', 'left');  
            $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left'); 
            $this->db->join('schools AS S', 'S.id = SP.school_id', 'left');
            $this->db->where('SP.id', $payment_id);             
            $this->db->where('SP.payment_to', 'teacher'); 
            return $this->db->get()->row();
             
         }
    }
}
