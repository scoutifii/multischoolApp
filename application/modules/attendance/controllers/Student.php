<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Student extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        
        $this->load->helper('report');
        $this->load->model('Student_Model', 'student', true);
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Student Attendance" user interface                 
    *                    and Process to manage daily Student attendance    
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function index() {

        check_permission(VIEW);
        if ($_POST) {

            $school_id  = $this->input->post('school_id');
            $term_id  = $this->input->post('term_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $date = $this->input->post('date');
            
            $month = date('m', strtotime($this->input->post('date')));
            $year = date('Y', strtotime($this->input->post('date')));
            
            $school = $this->student->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('attendance/student/index');
            }

            $this->data['students'] = $this->student->get_student_list($school_id, $class_id, $section_id, $school->academic_year_id, 'regular');

            $condition = array(
                'school_id' => $school_id,
                'term_id' => $term_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'month' => $month,
                'year' => $year
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->id;
                    $attendance = $this->student->get_single('student_attendances', $condition);

                    if (empty($attendance)) {  
                        
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->student->insert('student_attendances', $data);
                    }
                }
            }

            $this->data['academic_year_id'] = $school->academic_year_id;
            $this->data['day'] = date('d', strtotime($this->input->post('date')));
            $this->data['month'] = date('m', strtotime($this->input->post('date')));
            $this->data['year'] = date('Y', strtotime($this->input->post('date')));
            $this->data['school_id'] = $school_id;
            $this->data['term_id'] = $term_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['date'] = $date;
            
            create_log('Has been process student attendance'); 
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['terms'] = $this->student->get_list('school_term', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->layout->title($this->lang->line('student_attendance') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

   
        
    /*****************Function guardian**********************************
    * @type            : Function
    * @function name   : guardian
    * @description     : Load "Student Attendance for guardian" user interface                 
    *                    and Process to manage daily Student attendance    
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function guardian() {

        check_permission(VIEW);

        $this->data['month_number'] = 1;
        $this->data['days'] = 31;
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $term_id = $this->input->post('term_id');
            $month = $this->input->post('month');


            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['term_id'] = $term_id;
            $this->data['month'] = $month;
            $this->data['month_number'] = date('m', strtotime($this->data['month']));
            $session = $this->student->get_single('academic_years', array('id' => $academic_year_id));
            $this->data['students'] = $this->student->get_student_attendance_list($school_id, $academic_year_id, $class_id, $section_id);
           
            $this->data['year'] = substr($session->session_year, -4);
            //echo date('t', mktime(0, 0, 0, $month, 1, $year)); die();
            //$this->data['days'] = cal_days_in_month(CAL_GREGORIAN, $this->data['month_number'], $this->data['year']);
            $this->data['days'] =  date('t', mktime(0, 0, 0, $this->data['month_number'], 1, $this->data['year'])); 
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['academic_years'] = $this->student->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('student') . ' ' . $this->lang->line('attendance') . ' ' . $this->lang->line('report') . ' | ' . SMS);
        $this->layout->view('student/attendance', $this->data);
    }


    /*****************Function update_single_attendance**********************************
    * @type            : Function
    * @function name   : update_single_attendance
    * @description     : Process to update single student attendance status               
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function update_single_attendance() {

        
        $status = $this->input->post('status');
        $condition['school_id'] = $this->input->post('school_id');
        $condition['term_id'] = $this->input->post('term_id');
        $condition['student_id'] = $this->input->post('student_id');
        $condition['class_id'] = $this->input->post('class_id');
        
        if($this->input->post('section_id')){
           $condition['section_id'] = $this->input->post('section_id');
        }
        
        $condition['month'] = date('m', strtotime($this->input->post('date')));
        $condition['year'] = date('Y', strtotime($this->input->post('date')));
        
        $school = $this->student->get_school_by_id($condition['school_id']); 
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $field = 'day_' . abs(date('d', strtotime($this->input->post('date'))));
        if ($this->student->update('student_attendances', array($field => $status, 'modified_at'=>date('Y-m-d H:i:s')), $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    
    /*****************Function update_all_attendance**********************************
    * @type            : Function
    * @function name   : update_all_attendance
    * @description     : Process to update all student attendance status                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function update_all_attendance() {

        $status = $this->input->post('status');

        $condition['school_id'] = $this->input->post('school_id');
        $condition['class_id'] = $this->input->post('class_id');
        $condition['term_id'] = $this->input->post('term_id');

        if($this->input->post('section_id')){
           $condition['section_id'] = $this->input->post('section_id');
        }
        
        $condition['month'] = date('m', strtotime($this->input->post('date')));
        $condition['year'] = date('Y', strtotime($this->input->post('date')));
        
        $school = $this->student->get_school_by_id($condition['school_id']);   
        if(!$school->academic_year_id){
           echo 'ay';
           die();
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $field = 'day_' . abs(date('d', strtotime($this->input->post('date'))));
        if ($this->student->update('student_attendances', array($field => $status, 'modified_at'=>date('Y-m-d H:i:s')), $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

}
