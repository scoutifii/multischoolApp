<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Meritlist extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Meritlist_Model', 'merit', true);        
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam final result sheet" user interface                 
    *                    with class/section wise filtering option    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $term_id = $this->input->post('term_id');
            $exam_id = $this->input->post('exam_id');
            $student_id = $this->input->post('student_id');
           
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;         
            $this->data['section_id'] = $section_id;
            $this->data['term_id'] = $term_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['student_id'] = $student_id; 
            
            $school = $this->merit->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/meritlist');
            }
            
            $this->data['exam'] = $this->db->get_where('exams', array('id'=>$exam_id))->row()->title;
            $this->data['term'] = $this->db->get_where('school_term', array('id'=>$term_id))->row()->name;
            $this->data['class'] = $this->db->get_where('classes', array('id'=>$class_id))->row()->name;
            if($section_id){
                $this->data['section'] = $this->db->get_where('sections', array('id'=>$section_id))->row()->name;
            }
            
            $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id))->row()->session_year;
            $this->data['examresult'] = $this->merit->get_merit_list($school_id, $academic_year_id, $section_id);
            $this->data['school'] = $this->merit->get_school_by_id($school_id);
        }
        
        
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $school = $this->merit->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['academic_years'] = $this->merit->get_list('academic_years',$condition, '', '', '', 'id', 'ASC');
            
            $this->data['classes'] = $this->merit->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->merit->get_list('exams', $condition, '', '', '', 'id', 'ASC');
            $this->data['terms'] = $this->merit->get_list('school_term', array('status' => 1), '', '', '', 'id', 'ASC');
        }
        
        $this->layout->title($this->lang->line('manage_merit_list') . ' | ' . SMS);
        $this->layout->view('merit_list/index', $this->data);
        
    }
}