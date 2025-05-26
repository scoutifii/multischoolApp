<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Timeline.php**********************************
 * @topic           : Global - Multi School Management System Express
 * @type            : Class
 * @class name      : timeline
 * @description     : Manage :timeline
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Timeline extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Lessonplan_Model', 'lesson_plan', true);
                 
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->lesson_plan->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
        }
        
         // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_lesson_plan')){                        
              redirect('dashboard/index');
            }
        }
        
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "topic List" user interface                 
    *                       
    * @param           : $class_id & $subject_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);        
       if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/topic/index');
        }
                
        //for super admin        
        $school_id = '';
        $subject_id = '';        
        if($_POST){   
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
            $subject_id  = $this->input->post('subject_id');           
        }
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }               
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }  
        
        $school = $this->lesson_plan->get_school_by_id($school_id);
        $this->data['topics'] = $this->lesson_plan->get_topic_list($school, $class_id, $subject_id, @$school->academic_year_id);               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->lesson_plan->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;           
        
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_lesson_time_line'). ' | ' . SMS);
        $this->layout->view('lesson_plan/time_line', $this->data);
     
    }

 
    public function update_lesson(){
        
        $lesson_detail_id = $this->input->post('lesson_detail_id');
        $lesson_start = $this->input->post('lesson_start');
        $lesson_end = $this->input->post('lesson_end');
        
        if($lesson_start != '' && $lesson_end != ''){
            
            if(strtotime($lesson_end) > strtotime($lesson_start) ){
                $data = array(
                    'start_date'=>date('Y-m-d', strtotime($lesson_start)), 
                    'end_date'=>date('Y-m-d', strtotime($lesson_end)),
                    'modified_at'=>date('Y-m-d H:i:s'),
                    'modified_by'=>logged_in_user_id()
                );
                $this->lesson_plan->update('lp_lesson_details', $data, array('id' => $lesson_detail_id));
                
                echo TRUE;
                
            }else{
                 echo $this->lang->line('end_date_must_be_greater_than_start_date');;
            }
            
        }else{
            echo $this->lang->line('date_field_should_not_be_empty');
        }
    }
   
 
    public function update_topic(){
        
        $topic_detail_id = $this->input->post('topic_detail_id');
        $topic_start = $this->input->post('topic_start');
        $topic_end = $this->input->post('topic_end');
        
        if($topic_start != '' && $topic_end != ''){
            
            if(strtotime($topic_end) > strtotime($topic_start) ){
                $data = array(
                    'start_date'=>date('Y-m-d', strtotime($topic_start)), 
                    'end_date'=>date('Y-m-d', strtotime($topic_end)),
                    'modified_at'=>date('Y-m-d H:i:s'),
                    'modified_by'=>logged_in_user_id()
                );
                
                $this->lesson_plan->update('lp_topic_details', $data, array('id' => $topic_detail_id));                
                echo TRUE;
                
            }else{
                 echo $this->lang->line('end_date_must_be_greater_than_start_date');;
            }
            
        }else{
            echo $this->lang->line('date_field_should_not_be_empty');
        }
    }

    
}