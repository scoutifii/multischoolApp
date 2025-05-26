<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Attendance extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Attendance_Model', 'attendance', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam Attendance" user interface                 
    *                    and Process to manage Student exam attendance    
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function index() {

        check_permission(VIEW);

        $school_id = '';
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
            $term_id = $this->input->post('term_id');

            $school = $this->attendance->get_school_by_id($school_id);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/attendance/index');
            }
            
            
            $this->data['students'] = $this->attendance->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id, $school->academic_year_id, $term_id);

                      
            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id,
                'term_id' => $term_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->student_id;
                    $attendance = $this->attendance->get_single('exam_attendances', $condition);
                    
                    if (empty($attendance)) {
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->student_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->attendance->insert('exam_attendances', $data);
                    }
                }
            }

            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['subject_id'] = $subject_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
            $this->data['term_id'] = $term_id;
            
           $exam = $this->attendance->get_single('exams', array('id'=>$exam_id));
           $class = $this->attendance->get_single('classes', array('id'=>$class_id));
           $subject = $this->attendance->get_single('subjects', array('id'=>$subject_id));
           $term = $this->attendance->get_single('school_term', array('id'=>$term_id));            
           create_log('Has been process exam attendance for : '.$exam->title. ', '. $class->name.', '. $subject->name.', '.$term->name);
        }
        
        
        
        $condition = array();
        $condition['status'] = 1; 
        if($school_id){
            $condition['school_id'] = $school_id;
        }else{
            $condition['school_id'] = $this->session->userdata('school_id');
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $school = $this->attendance->get_school_by_id($this->session->userdata('school_id'));
            
            $this->data['classes'] = $this->attendance->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->attendance->get_list('exams', $condition, '', '', '', 'id', 'ASC');
            $this->data['terms'] = $this->attendance->get_list('school_term', array('status' => 1), '', '', '', 'id', 'ASC');
        }           
       
        $this->layout->title($this->lang->line('exam_attendance') . ' | ' . SMS);
        $this->layout->view('attendance/index', $this->data);        
    }



    /*****************Function update_single**********************************
    * @type            : Function
    * @function name   : update_single
    * @description     : Process to update single student exam attendance status               
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function update_single() {

        $status = $this->input->post('status');
        $condition['school_id'] = $this->input->post('school_id');
        $condition['student_id'] = $this->input->post('student_id');
        $condition['exam_id'] = $this->input->post('exam_id');
        $condition['class_id'] = $this->input->post('class_id');
        //$condition['term_id'] = $this->input->post('term_id');
        if($this->input->post('section_id')){
            $condition['section_id'] = $this->input->post('section_id');
        }
        $condition['subject_id'] = $this->input->post('subject_id');
        
        $school = $this->attendance->get_school_by_id($condition['school_id']);  
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $data['is_attend'] = $status ? 1 : 0;
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->attendance->update('exam_attendances', $data, $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    
    /*****************Function update_all**********************************
    * @type            : Function
    * @function name   : update_all
    * @description     : Process to update all student exam attendance status                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function update_all() {

        $status = $this->input->post('status');

        $condition['school_id'] = $this->input->post('school_id');
        $condition['exam_id'] = $this->input->post('exam_id');
        $condition['class_id'] = $this->input->post('class_id');
        if($this->input->post('section_id')){
            $condition['section_id'] = $this->input->post('section_id');
        }
        $condition['subject_id'] = $this->input->post('subject_id');
        //$condition['term_id'] = $this->input->post('term_id');
        
        $school = $this->attendance->get_school_by_id($condition['school_id']); 
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $data['is_attend'] = $status ? 1 : 0;
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->attendance->update('exam_attendances', $data, $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }
}