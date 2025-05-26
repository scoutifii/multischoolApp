<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Activity.php**********************************
 * @product name    : Global School Management System Pro
 * @type            : Class
 * @class name      : Activity
 * @description     : Manage student activity.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Activity extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();        
        
        $this->load->model('Activity_Model', 'activity', true);        
        
    }

    
    
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Activity List" user interface                 
     *                    with class wise listing    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function index($class_id = null) {
        
        check_permission(VIEW);
        
         if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/classes/index');
        }
        
        // for super admin 
        $school_id = '';
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        
        $this->data['activities'] = $this->activity->get_activity_list($class_id, $school_id );            
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->activity->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->activity->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_activity'). ' | ' . SMS);
        $this->layout->view('activity/index', $this->data);            
       
    }

    
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Activity" user interface                 
     *                    and store "Activity" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {
        
        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_activity_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_activity_data();

                $insert_id = $this->activity->insert('student_activities', $data);
                if ($insert_id) {
                    
                    $student = $this->activity->get_single('students', array('id' => $data['student_id']));
                    create_log('Has been added activity for studdent : '. $student->name);                    
                    success($this->lang->line('insert_success'));
                    redirect('student/activity/index/'.$data['class_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('student/activity/add/'.$data['class_id']);
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $class_id = $this->uri->segment(4);
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['activities'] = $this->activity->get_activity_list($class_id);  
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->activity->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->activity->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('activity/index', $this->data);
    }

    
    /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Activity" user interface                 
     *                    with populated "Activity" value 
     *                    and update "Activity" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('student/activity/index'); 
        }
        
        if ($_POST) {
            $this->_prepare_activity_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_activity_data();
                $updated = $this->activity->update('student_activities', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $student = $this->activity->get_single('students', array('id' => $data['student_id']));
                    create_log('Has been updated activity  for student : '. $student->name);
                    
                    success($this->lang->line('update_success'));
                    redirect('student/activity/index/'.$data['class_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('student/activity/edit/' . $this->input->post('id'));
                }
            } else {
                 error($this->lang->line('update_failed'));
                 $this->data['activity'] = $this->activity->get_single_activity($this->input->post('id'));
            }
        }
        
        if ($id) {
            $this->data['activity'] = $this->activity->get_single_activity($id);

            if (!$this->data['activity']) {
               redirect('student/activity/index');
            }
        }
        
        $class_id = $this->data['activity']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        } 
        
        $school = $this->activity->get_school_by_id($this->data['activity']->school_id);
        
        $this->data['class_id'] = $class_id;
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->activity->get_list('classes', array('status' => 1), '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->activity->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['activities'] = $this->activity->get_activity_list($class_id, $school->id, $school->academic_year_id);            
        $this->data['school_id'] = $this->data['activity']->school_id;        
        $this->data['filter_school_id'] = $this->data['activity']->school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('activity/index', $this->data);
    }
    
 
     /*****************Function get_single_activity**********************************
     * @type            : Function
     * @function name   : get_single_activity
     * @description     : "Load single activity information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_activity(){
        
       $activity_id = $this->input->post('activity_id');
       
       $this->data['activity'] = $this->activity->get_single_activity( $activity_id);
       echo $this->load->view('activity/get-single-activity', $this->data);
    }
    
    
    /*****************Function _prepare_activity_validation**********************************
     * @type            : Function
     * @function name   : _prepare_activity_validation
     * @description     : Process "activity" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_activity_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('student_id', $this->lang->line('student'), 'trim|required');   
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');   
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');   
        $this->form_validation->set_rules('activity', $this->lang->line('activity'), 'trim|required');   
    }
    
   
    /*****************Function _get_posted_activity_data**********************************
     * @type            : Function
     * @function name   : _get_posted_activity_data
     * @description     : Prepare "Activity" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_activity_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'student_id';
        $items[] = 'section_id';
        $items[] = 'activity';
        
        $data = elements($items, $_POST);  
        
        $data['activity_date'] = date('Y-m-d', strtotime($this->input->post('activity_date')));
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $school = $this->activity->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('student/activity/index');
            }
            
            $data['academic_year_id'] = $school->academic_year_id;
            
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 
        }
             
        return $data;
    }

    
    /*****************Function delete**********************************
     * @type            : Function
     * @function name   : delete
     * @description     : delete "Activity" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('student/activity/index');
        }
        
        $activity = $this->activity->get_single('student_activities', array('id' => $id));
        if ($this->activity->delete('student_activities', array('id' => $id))) {   
            
            $class = $this->activity->get_single('classes', array('id' => $activity->class_id));
            create_log('Has been deleted a activity :'. $activity->activity);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('student/activity/index/'.$activity->class_id);
    }
    

}
