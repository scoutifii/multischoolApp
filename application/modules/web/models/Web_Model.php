<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_notice_list($school_id, $limit){
        
        $this->db->select('N.*, RA.name AS notice_for, R.name');
        $this->db->from('notices AS N');
        $this->db->join('roles AS RA', 'RA.id = N.role_id', 'left');
        $this->db->join('users AS U', 'U.id = N.created_by', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('N.school_id', $school_id);
         $this->db->where('N.is_view_on_web', 1);
        $this->db->order_by('N.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
        
    }
    
    public function get_single_notice($school_id, $id){
        
        $this->db->select('N.*, RA.name AS notice_for, R.name');
        $this->db->from('notices AS N');
        $this->db->join('roles AS RA', 'RA.id = N.role_id', 'left');
        $this->db->join('users AS U', 'U.id = N.created_by', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('N.school_id', $school_id);
        $this->db->where('N.is_view_on_web', 1);
        $this->db->where('N.id', $id);
        return $this->db->get()->row();        
    }
    
    public function get_event_list($school_id, $limit){
        
        $this->db->select('E.*, R.name AS event_for');
        $this->db->from('events AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->where('E.school_id', $school_id);
        $this->db->where('E.is_view_on_web', 1);
        $this->db->order_by('E.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
        
    }
       
    public function get_single_event($school_id, $id){
        
        $this->db->select('E.*, R.name AS event_for');
        $this->db->from('events AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->where('E.school_id', $school_id);
        $this->db->where('E.is_view_on_web', 1);
        $this->db->where('E.id', $id);
        return $this->db->get()->row();
        
    }
        
    public function get_news_list($school_id, $limit){
        
        $this->db->select('N.*, R.name');
        $this->db->from('news AS N');     
        $this->db->join('users AS U', 'U.id = N.created_by', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('N.school_id', $school_id);
        $this->db->where('N.is_view_on_web', 1);
        $this->db->order_by('N.id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
        
    }
       
    public function get_single_news($school_id, $id){
        
        $this->db->select('N.*, R.name');
        $this->db->from('news AS N');     
        $this->db->join('users AS U', 'U.id = N.created_by', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('N.school_id', $school_id);
        $this->db->where('N.is_view_on_web', 1);
        $this->db->where('N.id', $id);
        return $this->db->get()->row();
        
    }
    
    
    public function get_image_list($id){
        
        $this->db->select('GI.*, G.title');
        $this->db->from('gallery_images AS GI');
        $this->db->join('galleries AS G', 'G.id = GI.gallery_id', 'left');
        $this->db->where('GI.gallery_id', $id);
        return $this->db->get()->result();        
    }
    
    public function get_teacher_list($school_id){
        
        $this->db->select('T.*, U.username, U.role_id');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->where('T.school_id', $school_id);
        $this->db->where('T.is_view_on_web', 1);
        $this->db->order_by('T.display_order', 'DESC');
        return $this->db->get()->result();
        
    }
    
     public function get_employee_list($school_id){
        
        $this->db->select('E.*, U.username, U.role_id, D.name AS designation');
        $this->db->from('employees AS E');
        $this->db->join('users AS U', 'U.id = E.user_id', 'left');
        $this->db->join('designations AS D', 'D.id = E.designation_id', 'left');
        $this->db->where('E.school_id', $school_id);
        $this->db->where('E.is_view_on_web', 1);
        $this->db->order_by('E.display_order', 'DESC');
        return $this->db->get()->result();        
    }
    
    public function get_feedback_list($school_id, $limit){
        
        $this->db->select('GF.*, G.name, G.photo');
        $this->db->from('guardian_feedbacks AS GF');
        $this->db->join('guardians AS G', 'G.id = GF.guardian_id', 'left');
        $this->db->where('GF.is_publish', 1);
        $this->db->where('GF.school_id', $school_id);
        $this->db->order_by('GF.id', 'DESC');
        return $this->db->get()->result();        
    }
        
    public function get_total_teacher($school_id){
        
        $this->db->select('T.id');
        $this->db->from('teachers AS T');
        $this->db->where('T.school_id', $school_id);
        return $this->db->count_all_results();
    }
    
    public function get_total_student($school_id){
        
        $this->db->select('S.id');
        $this->db->from('students AS S');
        $this->db->where('S.school_id', $school_id);
        return $this->db->count_all_results();
    }
    
    public function get_total_staff($school_id){
        
        $this->db->select('E.id');
        $this->db->from('employees AS E');
        $this->db->where('E.school_id', $school_id);
        return $this->db->count_all_results();
    }
    
    public function get_total_user($school_id){
        
        $this->db->select('U.id');
        $this->db->from('users AS U');
        $this->db->where('U.school_id', $school_id);
        return $this->db->count_all_results();
    }
    
}