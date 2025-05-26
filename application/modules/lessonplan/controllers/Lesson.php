<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Lesson extends MY_Controller {

    public $data = array();

    function __construct() {
        
        parent::__construct();
        $this->load->model('Lesson_Model', 'lesson', true);
               
       if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->lesson->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
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
    * @description     : Load "Lesson List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null ) {

        check_permission(VIEW);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/lesson/index');
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
        
        $school = $this->lesson->get_school_by_id($school_id);
        $this->data['lessons'] = $this->lesson->get_lesson_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->lesson->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_lesson'). ' | ' . SMS);
        $this->layout->view('lesson/index', $this->data);
     
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Lesson" user interface                 
    *                    and process to store "Lesson" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        //$school_id = '';
         
        if ($_POST) {
            $this->_prepare_lesson_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_lesson_data();

                // check is subject is exist in lesson table
                $school = $this->lesson->get_school_by_id($data['school_id']);
                $exist = $this->lesson->get_single('lp_lessons', array('class_id' => $data['class_id'], 'subject_id'=>$data['subject_id'], 'academic_year_id'=> $school->academic_year_id));
                if($exist){
                    $this->lesson->update('lp_lessons', $data, array('id' => $exist->id));
                    $insert_id = $exist->id;
                }else{
                    $insert_id = $this->lesson->insert('lp_lessons', $data);
                }                
                
                if ($insert_id) {                    
                    // insert lesson list in database
                    $this->_save_lesson($insert_id);                    
                    create_log('Has been added lesson');                     
                    success($this->lang->line('insert_success'));
                    redirect('lessonplan/lesson/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('lessonplan/lesson/add');
                }
            } else {
                $this->data['post'] = $_POST;                
            }
        }
        
        
        $this->data['lessons'] = $this->lesson->get_lesson_list();   
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->lesson->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = '';
        $this->data['school_id'] = '';       
        $this->data['subject_id'] = '';
        
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') .' | '. SMS);
        $this->layout->view('lesson/index', $this->data);
        
    }

    
    /*****************Function edit* * *********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Lesson" user interface                 
    *                    with populate "Exam Liveclass" value 
    *                    and process to update "Exa Lesson" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

       if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('lessonplan/lesson/index');
        }
       
        if ($_POST) {
            $this->_prepare_lesson_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_lesson_data();
                $updated = $this->lesson->update('lp_lessons', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $this->_save_lesson($this->input->post('id'));
                    create_log('Has been updated lesson');                    
                    success($this->lang->line('update_success'));
                    redirect('lessonplan/lesson/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('lessonplan/lesson/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['lesson'] = $this->lesson->get_single_lesson($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['lesson'] = $this->lesson->get_single_lesson($id);
            if (!$this->data['lesson']) {
            redirect('lessonplan/lesson/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->lesson->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $school_id = $this->data['lesson']->school_id;
        $class_id = $this->data['lesson']->class_id;
        $subject_id = $this->data['lesson']->subject_id;
        $school = $this->lesson->get_school_by_id($school_id);
        
        $this->data['lessons'] = $this->lesson->get_lesson_list($school_id, $class_id, $subject_id, $school->academic_year_id);               
        $this->data['lesson_detail'] = get_lesson_detail_by_lesson_id($this->data['lesson']->id);
              
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('lesson/index', $this->data);
    }

   
    /*****************Function get_single_Lesson**********************************
     * @type            : Function
     * @function name   : get_single_Lesson
     * @description     : "Load single Lesson information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_lesson(){
        
       $lesson_id = $this->input->post('lesson_id');
       $this->data['lesson'] = $this->lesson->get_single_lesson($lesson_id);   
       $this->data['lesson_details'] = get_lesson_detail_by_lesson_id($lesson_id);  
       echo $this->load->view('lesson/get-single-lesson', $this->data);
    }
    
    
    /*****************Function _prepare_lesson_validation**********************************
    * @type            : Function
    * @function name   : _prepare_lesson_validation
    * @description     : Process "Lesson plan" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_lesson_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');       
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    

    
    /*****************Function _get_posted_lesson_data**********************************
    * @type            : Function
    * @function name   : _get_posted_lesson_data
    * @description     : Prepare "Lesson Plan" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_lesson_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'subject_id';
        $items[] = 'note';
        
        $data = elements($items, $_POST);

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
            $data['status'] = 1; //  will be from post
        } else {
                        
            $school = $this->lesson->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('lessonplan/lesson/index');  
            }
            
            $data['academic_year_id'] = $school->academic_year_id;                    
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();           
        }
        
        return $data;
    }
    

    /*****************Function _save_lesson**********************************
    * @type            : Function
    * @function name   : _save_lesson
    * @description     : delete "Save Lesson" into database                  
    *                       
    * @param           : $lesson_id integer value
    * @return          : null 
    * ********************************************************** */
    private function _save_lesson($lesson_id){
        
        $school_id = $this->input->post('school_id');
        $school = $this->lesson->get_school_by_id($school_id);
        foreach($this->input->post('title') as $key=>$value){
            
            if($value){
                
                $data = array();
                $data['school_id'] = $school_id;
                $exist = '';               
                $lesson_detail_id = @$_POST['lesson_detail_id'][$key];

                if($lesson_detail_id){
                   $exist = $this->lesson->get_single('lp_lesson_details', array('lesson_id'=>$lesson_id, 'id'=>$lesson_detail_id));
                }         


                $data['title'] = $value;               
               
                if ($this->input->post('id') && $exist) {                

                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();                
                    $this->lesson->update('lp_lesson_details', $data, array('id'=>$exist->id));

                } else {

                    $data['lesson_id'] = $lesson_id;                                   
                    $data['status'] = 1;
                    $data['academic_year_id'] = $school->academic_year_id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id(); 
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();
                    $this->lesson->insert('lp_lesson_details', $data);
                }
            }
        }
    }
    


    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Lesson" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
   public function delete($id = null) {

        check_permission(DELETE);

        if (!is_numeric($id)) {
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/lesson/index');
        }

        if ($this->lesson->delete('lp_lessons', array('id' => $id))) {
            // delete lesson list
            $this->lesson->delete('lp_lesson_details', array('lesson_id' => $id));
            success($this->lang->line('delete_success'));
        } else {

            error($this->lang->line('delete_failed'));
        }

        redirect('lessonplan/lesson/index');
    }
    
    
    public function remove(){
        
        $lesson_detail_id = $this->input->post('lesson_detail_id');
        echo $this->lesson->delete('lp_lesson_details', array('id' => $lesson_detail_id));
    }   

}