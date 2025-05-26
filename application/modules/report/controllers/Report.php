<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Report extends My_Controller {

    public $data = array();
    public $date_from = '';
    public $date_to = '';

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Report_Model', 'report', true);
        $this->load->helper('report');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
            $this->data['academic_years'] = $this->report->get_list('academic_years', array('status' => 1, 'school_id'=>$school_id));
        }
        
        $this->date_from = date('Y-m-01');
        $this->date_to = date('Y-m-t');
        $this->db->query("SET SESSION sql_mode = ''"); 
    }

        
    /*****************Function income**********************************
    * @type            : Function
    * @function name   : income
    * @description     : Load Income report user interface                 
    *                    with various filtering options
    *                    and process to load income report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function income() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');

            if ($group_by == 'daily') {
                $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
                $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
            } else {
                $date_from = '';
                $date_to = '';
            }

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['income'] = $this->report->get_income_report($school_id, $academic_year_id, $group_by, $date_from, $date_to);
                       
        }

        $this->data['report_url'] = site_url('report/income');
        
        $this->layout->title($this->lang->line('income_report') . ' | ' . SMS);
        $this->layout->view('income/index', $this->data);
        
    }

    
    
        
    /*****************Function expenditure**********************************
    * @type            : Function
    * @function name   : expenditure
    * @description     : Load expenditure report user interface                 
    *                    with various filtering options
    *                    and process to load expenditure report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function expenditure() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');

            if ($group_by == 'daily') {
                $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
                $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
            } else {
                $date_from = '';
                $date_to = '';
            }

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['expenditure'] = $this->report->get_expenditure_report($school_id, $academic_year_id, $group_by, $date_from, $date_to);
        }
        
        $this->data['report_url'] = site_url('report/expenditure');
        $this->layout->title($this->lang->line('expenditure_report') . ' | ' . SMS);
        $this->layout->view('expenditure/index', $this->data);
    }

    
        
        
    /*****************Function invoice**********************************
    * @type            : Function
    * @function name   : invoice
    * @description     : Load invoice report user interface                 
    *                    with various filtering options
    *                    and process to load invoice report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function invoice() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');

            if ($group_by == 'daily') {
                $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
                $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
            } else {

                $date_from = '';
                $date_to = '';
            }

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['invoice'] = $this->report->get_invoice_report($school_id, $academic_year_id, $group_by, $date_from, $date_to);
        }

        $this->data['report_url'] = site_url('report/invoice');
        $this->layout->title($this->lang->line('invoice_report') . ' | ' . SMS);
        $this->layout->view('invoice/index', $this->data);
    }

     
        
    /*****************Function duefees**********************************
    * @type            : Function
    * @function name   : duefees
    * @description     : Load duefees report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function duefee() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $student_id = $this->input->post('student_id');
                
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student_id'] = $student_id;
            $this->data['class_id'] = $class_id;  
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['sbalance'] = $this->report->get_student_due_fee_report($school_id, $academic_year_id, $class_id, $student_id);
            
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
            $this->data['classes'] = $this->report->get_list('classes', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }
        
        $this->data['report_url'] = site_url('report/duefee');
        $this->layout->title($this->lang->line('due_fee_report') . ' | ' . SMS);
        $this->layout->view('invoice/duefee', $this->data);
    }    
    
    
    /*****************Function feecollection**********************************
    * @type            : Function
    * @function name   : feecollection
    * @description     : Load fee collection report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function feecollection() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $student_id = $this->input->post('student_id');
                     
            $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : '';
            $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : '';
                  
            $this->data['school_id'] = $school_id;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;   
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student_id'] = $student_id;
            $this->data['class_id'] = $class_id; 
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['feecollection'] = $this->report->get_student_fee_collection_report($school_id, $academic_year_id, $class_id, $student_id, $date_from, $date_to);
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $school_id = $this->session->userdata('school_id');

            $this->data['classes'] = $this->report->get_list('classes', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            $this->data['fee_types'] = $this->report->get_list('income_heads', array('status' => 1, 'head_type !='=> 'income', 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }
        
        $this->data['report_url'] = site_url('report/feecollection');
        $this->layout->title($this->lang->line('fee_collection_report') . ' | ' . SMS);
        $this->layout->view('invoice/fee_collection', $this->data);
        
    }
    
        
    /*****************Function balance**********************************
    * @type            : Function
    * @function name   : balance
    * @description     : Load balance report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function balance() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');

            if ($group_by == 'daily') {
                $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
                $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
            } else {

                $date_from = '';
                $date_to = '';
            }

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;


            if ($group_by == 'daily') {
                $this->data['balance'] = $this->_get_daily_balance_data($school_id, $date_from, $date_to);
            } else {
                $this->data['expenditure'] = $this->report->get_expenditure_report($school_id,$academic_year_id, $group_by, $date_from, $date_to);
                $this->data['income'] = $this->report->get_income_report($school_id, $academic_year_id, $group_by, $date_from, $date_to);
                $this->data['balance'] = $this->_combine_balance_data($this->data['expenditure'], $this->data['income']);
            }
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
        }

        $this->data['report_url'] = site_url('report/balance');
        $this->layout->title($this->lang->line('accounting_balance_report') . ' | ' . SMS);
        $this->layout->view('balance/index', $this->data);
    }

    /*****************Function _get_daily_balance_data**********************************
    * @type            : Function
    * @function name   : _get_daily_balance_data
    * @description     : format the daily balanace report data for user friendly data presentation                
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _get_daily_balance_data($school_id, $date_from, $date_to) {

        $data = array();

        $days = date('d', strtotime($date_to));

        for ($i = 0; $i < $days; $i++) {

            $date = date('Y-m-d', strtotime($date_from . '+' . $i . ' day'));
            $data[$i]['expenditure'] = $this->report->get_expenditure_by_date($school_id, $date);
            $data[$i]['income'] = $this->report->get_income_by_date($school_id, $date);
            $data[$i]['group_by_field'] = date($this->global_setting->date_format, strtotime($date));
        }

        return $data;
    }

        
                                        
    /*****************Function _combine_balance_data**********************************
    * @type            : Function
    * @function name   : _combine_balance_data
    * @description     : combined expenditure and income report data for user friendly data presentation                
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _combine_balance_data($expenditure, $income) {
        $data = array();
        foreach ($expenditure as $obj) {
            $data[$obj->group_by_field]['expenditure'] = $obj->total_amount;
            $data[$obj->group_by_field]['group_by_field'] = $obj->group_by_field;
            if (empty($data[$obj->group_by_field]['income'])) {
                $data[$obj->group_by_field]['income'] = 0;
            }
        }
        foreach ($income as $obj) {
            $data[$obj->group_by_field]['income'] = $obj->total_amount;
            $data[$obj->group_by_field]['group_by_field'] = $obj->group_by_field;

            if (empty($data[$obj->group_by_field]['expenditure'])) {
                $data[$obj->group_by_field]['expenditure'] = 0;
            }
        }
        return $data;
    }

    
                
        
    /*****************Function library**********************************
    * @type            : Function
    * @function name   : library
    * @description     : Load library report user interface                 
    *                    with various filtering options
    *                    and process to load library report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function library() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');

            if ($group_by == 'daily') {
                $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
                $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
            } else {

                $date_from = '';
                $date_to = '';
            }

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['library'] = $this->report->get_library_report($school_id, $academic_year_id, $group_by, $date_from, $date_to);
  
        }

        $this->data['report_url'] = site_url('report/library');
        $this->layout->title($this->lang->line('library_report') . ' | ' . SMS);
        $this->layout->view('library/index', $this->data);
    }

    
            
    /*****************Function sattendance**********************************
    * @type            : Function
    * @function name   : sattendance
    * @description     : Load student attendance report user interface                 
    *                    with various filtering options
    *                    and process to load student attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function sattendance() {

        check_permission(VIEW);

        $this->data['month_number'] = 1;       
        $this->data['days'] = 31;
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $month = $this->input->post('month');


            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['month'] = $month;
            $this->data['month_number'] = date('m', strtotime($this->data['month']));
            
            $session = $this->report->get_single('academic_years', array('id' => $academic_year_id, 'school_id'=>$school_id));            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['students'] = $this->report->get_student_list($school_id, $academic_year_id, $class_id, $section_id);
            
            $this->data['year'] = substr($session->session_year, 7);
            $this->data['days'] =  @date('t', mktime(0, 0, 0, $this->data['month_number'], 1, $this->data['year']));
            //$this->data['days'] = cal_days_in_month(CAL_GREGORIAN, $this->data['month_number'], $this->data['year']);
        }



        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['classes'] = $this->report->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        

        $this->data['report_url'] = site_url('report/sattendance');
        $this->layout->title($this->lang->line('student_attendance_report') . ' | ' . SMS);
        $this->layout->view('sattendance/index', $this->data);
        
    }

                
    /*****************Function syattendance**********************************
    * @type            : Function
    * @function name   : syattendance
    * @description     : Load student yearly attendance report user interface                 
    *                    with various filtering options
    *                    and process to load student yearly attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function syattendance() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_id = $this->input->post('student_id');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['student_id'] = $student_id;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
        }


        $this->data['days'] = 31;

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){    
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['classes'] = $this->report->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }

        $this->data['report_url'] = site_url('report/syattendance');
        $this->layout->title($this->lang->line('student_yearly_attendance_report') . ' | ' . SMS);
        $this->layout->view('sattendance/yearly', $this->data);
    }

                    
    /*****************Function tattendance**********************************
    * @type            : Function
    * @function name   : tattendance
    * @description     : Load teacher attendance report user interface                 
    *                    with various filtering options
    *                    and process to load teacher attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function tattendance() {

        check_permission(VIEW);

        $this->data['month_number'] = 1;
        $this->data['days'] = 31;
                
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $month = $this->input->post('month');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['month'] = $month;
            $this->data['month_number'] = date('m', strtotime($this->data['month']));
            
            $this->data['teachers'] = $this->report->get_list('teachers', array('status' => 1, 'school_id'=>$school_id));
            $session = $this->report->get_single('academic_years', array('id' => $academic_year_id, 'school_id'=>$school_id));
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            $this->data['year'] = substr($session->session_year, 7);
            //$this->data['days'] = cal_days_in_month(CAL_GREGORIAN, $this->data['month_number'], $this->data['year']);
            $this->data['days'] =  @date('t', mktime(0, 0, 0, $this->data['month_number'], 1, $this->data['year']));
        }

        $this->data['report_url'] = site_url('report/tattendance');
        $this->layout->title($this->lang->line('teacher_attendance_report') . ' | ' . SMS);
        $this->layout->view('tattendance/index', $this->data);
    }

                        
    /*****************Function tyattendance**********************************
    * @type            : Function
    * @function name   : tyattendance
    * @description     : Load teacher yearly attendance report user interface                 
    *                    with various filtering options
    *                    and process to load teacher yearly attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function tyattendance() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $teacher_id = $this->input->post('teacher_id');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['teacher_id'] = $teacher_id;  
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['teachers'] = $this->report->get_list('teachers', $condition);
            
        } 
           
        
        $this->data['days'] = 31;
        $this->data['report_url'] = site_url('report/tyattendance');
        $this->layout->title( $this->lang->line('teacher_yearly_attendance_report') . ' | ' . SMS);
        $this->layout->view('tattendance/yearly', $this->data);
    }

                            
    /*****************Function eattendance**********************************
    * @type            : Function
    * @function name   : eattendance
    * @description     : Load Employee attendance report user interface                 
    *                    with various filtering options
    *                    and process to load Employee attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function eattendance() {

        check_permission(VIEW);

        $this->data['month_number'] = 1;
        $this->data['days'] = 31;
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $month = $this->input->post('month');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['month'] = $month;
            $this->data['month_number'] = date('m', strtotime($this->data['month']));
            
            $this->data['employees'] = $this->report->get_list('employees', array('status' => 1, 'school_id'=>$school_id));            
            $session = $this->report->get_single('academic_years', array('id' => $academic_year_id, 'school_id'=>$school_id));
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            $this->data['year'] = substr($session->session_year, 7);
            //$this->data['days'] = cal_days_in_month(CAL_GREGORIAN, $this->data['month_number'], $this->data['year']);
            $this->data['days'] =  @date('t', mktime(0, 0, 0, $this->data['month_number'], 1, $this->data['year']));
        }


        $this->data['report_url'] = site_url('report/eattendance');
        $this->layout->title( $this->lang->line('employee_attendance_report') . ' | ' . SMS);
        $this->layout->view('eattendance/index', $this->data);
    }

                                
    /*****************Function eyattendance**********************************
    * @type            : Function
    * @function name   : eyattendance
    * @description     : Load Employee yearly attendance report user interface                 
    *                    with various filtering options
    *                    and process to load Employee yearly attendance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function eyattendance() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $employee_id = $this->input->post('employee_id');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['employee_id'] = $employee_id;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
        }

        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['employees'] = $this->report->get_list('employees', $condition);
        } 
        
        $this->data['days'] = 31;

        $this->data['report_url'] = site_url('report/eyattendance');
        $this->layout->title($this->lang->line('employee_yearly_attendance_report') . ' | ' . SMS);
        $this->layout->view('eattendance/yearly', $this->data);
    }
    
    
                                    
    /*****************Function student**********************************
    * @type            : Function
    * @function name   : student
    * @description     : Load student report user interface                 
    *                    with various filtering options
    *                    and process to load student report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function student(){
        
        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by');           

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            $this->data['students'] = $this->report->get_student_report($school_id, $academic_year_id, $group_by);
            $this->data['students'] = $this->_get_pormatted_student_report($school_id, $group_by, $this->data['students']);
   
        }

        $this->data['report_url'] = site_url('report/student');
        $this->layout->title($this->lang->line('student_report') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }
    
    
                                        
    /*****************Function _get_pormatted_student_report**********************************
    * @type            : Function
    * @function name   : _get_pormatted_student_report
    * @description     : Format the student report for better representation                 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _get_pormatted_student_report($school_id, $group_by,$students = null){
        
        $data = array();
        if(!empty($students)){
            foreach($students as $obj){
                
                $male = $this->report->get_student_by_gender($school_id, $group_by, $obj->class_id, $obj->academic_year_id, 'male');
                $obj->male = $male ? $male : 0;
                $female = $this->report->get_student_by_gender($school_id, $group_by, $obj->class_id, $obj->academic_year_id, 'female');
                $obj->female = $female ? $female : 0;
                $data[] = $obj;
            }
            
        }
        
        return $data;
    }
    
    
        
    /*****************Function sbalance**********************************
    * @type            : Function
    * @function name   : sbalance
    * @description     : Load sbalance report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function sinvoice() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $student_id = $this->input->post('student_id');
                      
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student_id'] = $student_id;
            $this->data['class_id'] = $class_id;         

             if($academic_year_id){
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id))->row()->session_year;
            }
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            $this->data['sbalance'] = $this->report->get_student_invoice_report($school_id, $academic_year_id, $class_id, $student_id);
            
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['classes'] = $this->report->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 
        
        $this->data['report_url'] = site_url('report/sinvoice');
        $this->layout->title($this->lang->line('student_invoice_report') . ' | ' . SMS);
        $this->layout->view('student/sinvoice', $this->data);
        
    }    
    
            
    /*****************Function sactivity**********************************
    * @type            : Function
    * @function name   : sactivity
    * @description     : Load balance report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function sactivity() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $student_id = $this->input->post('student_id');
                      
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student_id'] = $student_id;
            $this->data['class_id'] = $class_id;   
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            if($academic_year_id){
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id))->row()->session_year;
            }
            
            $this->data['activities'] = $this->report->get_student_activity_report($school_id, $academic_year_id, $class_id, $student_id);
            
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['classes'] = $this->report->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 
        
        $this->data['report_url'] = site_url('report/sactivity');
        $this->layout->title($this->lang->line('student_activity_report') . ' | ' . SMS);
        $this->layout->view('student/activity', $this->data);
    }    
    

    
        
        
    /*****************Function payroll**********************************
    * @type            : Function
    * @function name   : payroll
    * @description     : Load payroll report user interface                 
    *                    with various filtering options
    *                    and process to load payroll report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function payroll() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $group_by = $this->input->post('group_by'); 
            $month = $this->input->post('month');
            $payment_to = $this->input->post('payment_to');
          
            
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['group_by'] = $group_by;
            $this->data['payment_to'] = $payment_to;          
            $this->data['month'] = $month;
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            if($academic_year_id){
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id, 'school_id'=>$school_id))->row()->session_year;
            }

            $this->data['payrolls'] = $this->report->get_payroll_report($school_id, $academic_year_id, $group_by, $payment_to, $month);
        }

        $this->data['report_url'] = site_url('report/payroll');
        $this->layout->title($this->lang->line('payroll_report') . ' | ' . SMS);
        $this->layout->view('payroll/index', $this->data);
    }
    
    
        
    
    
    
    
    /*****************Function statement**********************************
    * @type            : Function
    * @function name   : statement
    * @description     : Load balance report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function statement() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
            $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
                      
            $this->data['school_id'] = $school_id;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
          
            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
        
            
            $this->data['statement'] = $this->_get_daily_actbalance_data($school_id, $date_from, $date_to);
          
        }
        
        $this->data['report_url'] = site_url('report/statement');
        $this->layout->title($this->lang->line('daily_statement_report') . ' | ' . SMS);
        $this->layout->view('balance/statement', $this->data);
    }
    
    /*****************Function _get_daily_actbalance_data**********************************
    * @type            : Function
    * @function name   : _get_daily_actbalance_data
    * @description     : format the daily balanace report data for user friendly data presentation                
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _get_daily_actbalance_data($school_id, $date_from, $date_to) {

        $data = array();

        $start = strtotime($date_from);
        $end   = strtotime($date_to);
        $days  = ceil(abs($end - $start) / 86400)+1;
        $j = 0;
        for ($i = 0; $i < $days; $i++) {           

            $date = date('Y-m-d', strtotime($date_from . '+' . $i . ' day'));
            
            $expenditure = $this->report->get_debit_by_date($school_id, $date);
            if(!empty($expenditure)){
                
                foreach($expenditure as $exp){
                    $data[$j+1]['head'] = $exp->head;                       
                    $data[$j+1]['debit'] = $exp->debit;                       
                    $data[$j+1]['credit'] = 0;                       
                    $data[$j+1]['gross'] = $exp->debit;                      
                    $data[$j+1]['tax'] = 0;                      
                    $data[$j+1]['note'] = $exp->note;                       
                    $data[$j+1]['date'] = $date; 
                    
                    $j++;
                }
            }
            
            $income = $this->report->get_credit_by_date($school_id, $date);
            if(!empty($income)){
                
                foreach($income as $inc){
                    $data[$j+1]['head'] = $inc->head;                       
                    $data[$j+1]['debit'] = 0;                       
                    $data[$j+1]['credit'] = $inc->credit;                        
                    $data[$j+1]['gross'] = $inc->credit;                      
                    $data[$j+1]['tax'] = 0;                      
                    $data[$j+1]['note'] = $inc->note;                       
                    $data[$j+1]['date'] = $date; 
                    
                    $j++;
                }
            }
            
        }

        return $data;
        
    }

    
        
    /*****************Function transaction**********************************
    * @type            : Function
    * @function name   : transaction
    * @description     : Load balance report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function transaction() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
            $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
                      
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;     

            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            if($academic_year_id){
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id, 'school_id'=>$school_id))->row()->session_year;
            }
            
            $this->data['transaction'] = $this->report->get_transaction_report($school_id, $academic_year_id, $date_from, $date_to);
            
        }
        
        $this->data['report_url'] = site_url('report/transaction');
        $this->layout->title($this->lang->line('daily_transaction_report') . ' | ' . SMS);
        $this->layout->view('balance/transaction', $this->data);
    }    
    
    
     
    /*****************Function examresult**********************************
    * @type            : Function
    * @function name   : examresult
    * @description     : Load examresult report user interface                 
    *                    with various filtering options
    *                    and process to load balance report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function examresult() {

        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
           
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;         
            $this->data['section_id'] = $section_id;  
            
            $this->data['school'] = $this->report->get_school_by_id($school_id);

            $this->data['class'] = $this->db->get_where('classes', array('id'=>$class_id, 'school_id'=>$school_id))->row()->name;
            
            if($section_id){
                $this->data['section'] = $this->db->get_where('sections', array('id'=>$section_id, 'school_id'=>$school_id))->row()->name;
            }
            
            $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id, 'school_id'=>$school_id))->row()->session_year;
            $this->data['examresult'] = $this->report->get_student_examresult_report($school_id, $academic_year_id, $class_id, $section_id);
        }        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
            
            $condition['school_id'] = $this->session->userdata('school_id');  
            $this->data['classes'] = $this->report->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }        
        
        $this->data['report_url'] = site_url('report/examresult');
        $this->layout->title($this->lang->line('exam_result_report') . ' | ' . SMS);
        $this->layout->view('student/exam_result', $this->data);
        
    }
    
    /*****************Function teachertransfer**********************************
    * @type            : Function
    * @function name   : teachertransfer
    * @description     : Load teachertransfer report user interface                 
    *                    with various filtering options
    *                    and process to load teacher transfer report   
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function teachertransfer(){
        check_permission(VIEW);

        if ($_POST) {
           
            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $date_from = $this->input->post('date_from') ? date('Y-m-d', strtotime($this->input->post('date_from'))) : $this->date_from;
            $date_to = $this->input->post('date_to') ? date('Y-m-d', strtotime($this->input->post('date_to'))) : $this->date_to;
                      
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;     

            $this->data['school'] = $this->report->get_school_by_id($school_id);
            
            if($academic_year_id){
                $this->data['academic_year'] = $this->db->get_where('academic_years', array('id'=>$academic_year_id, 'school_id'=>$school_id))->row()->session_year;
            }
            
            $this->data['teachers'] = $this->report->get_teacher_transfer_report($school_id, $academic_year_id, $date_from, $date_to);
            
        }
        
        $this->data['report_url'] = site_url('report/teachertransfer');
        $this->layout->title($this->lang->line('teacher_transfer_report') . ' | ' . SMS);
        $this->layout->view('ttransfer/index', $this->data);

    }

    public function studenttransfer(){
        
    }

}
