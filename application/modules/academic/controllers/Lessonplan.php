<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lessonplan extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Lessonplan_Model', 'lessonplan', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Lesson Plan List" user interface                 
    *                    with class wise listing    
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);
                
        // for super admin 
        $school_id = '';       
        $section_id = '';
        $condition = array();
        $condition['status'] = 1; 
        
        if ($this->session->userdata('role_id') == TEACHER) {
            
            $school_id = $this->session->userdata('school_id');    
            $class_id = $this->session->userdata('class_id');    
            $section_id = $this->session->userdata('section_id');  
            
        }else if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['teachers'] = $this->lessonplan->get_list('teachers', $condition, '','', '', 'id', 'ASC');            
        }
        
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
        }
        
        
        $this->data['classes'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lessonplan->get_school_by_id($school_id);         
        $this->data['lessons'] = $this->lessonplan->get_lesson_plan_list($school_id, @$school->academic_year_id, $class_id, $section_id );
                
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_class_lesson_plan') . ' | ' . SMS);
        $this->layout->view('academic/lessonplan/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Lesson Plan" user interface                 
    *                    and process to store "Lesson Plan" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_lesson_plan_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_lesson_plan_data();

                $insert_id = $this->lessonplan->insert('lessons', $data);
                if ($insert_id) {
                    $this->_save_lesson($insert_id);
                    create_log('Has been created a lesson plan : '.$data['lession_title']);                     
                    success($this->lang->line('insert_success'));
                    redirect('academic/lessonplan/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('academic/lessonplan/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
               
        
        // for super admin 
        $school_id = '';
        $class_id = '';
        $section_id = '';
        $condition = array();
        $condition['status'] = 1; 
        
        if ($this->session->userdata('role_id') == TEACHER) {
            
            $school_id = $this->session->userdata('school_id');    
            $class_id = $this->session->userdata('class_id');    
            $section_id = $this->session->userdata('section_id');  
            
        }else if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');            
        }        
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
            $section_id  = $this->input->post('section_id');
        }
        
        $this->data['classes'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lessonplan->get_school_by_id($school_id);         
        $this->data['lessons'] = $this->lessonplan->get_lesson_plan_list($school_id, @$school->academic_year_id, $class_id, $section_id );
         
                
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('lessonplan/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Lesson Plan" user interface                 
    *                    with populated "Lesson Plan" value 
    *                    and process to update "Lesson Plan" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('academic/lessonplan/index');
        }
        
        if ($_POST) {
            $this->_prepare_lesson_plan_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_lesson_plan_data();
                $updated = $this->lessonplan->update('lessons', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    $this->_save_lesson($this->input->post('id'));
                    create_log('Has been created a lesson plan : '.$data['lesson_title']);                    
                    success($this->lang->line('update_success'));
                    redirect('academic/lessonplan/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('academic/lessonplan/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['lesson'] = $this->lessonplan->get_single('lessons', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['lesson'] = $this->lessonplan->get_single('lessons', array('id' => $id));

            if (!$this->data['lesson']) {
                redirect('academic/lessonplan/index');
            }
        }
         
        // for super admin 
        $school_id = '';
        $class_id = '';
        $section_id = '';
        $condition = array();
        $condition['status'] = 1; 
        
        if ($this->session->userdata('role_id') == TEACHER) {
            
            $school_id = $this->session->userdata('school_id');    
            $class_id = $this->session->userdata('class_id');    
            $section_id = $this->session->userdata('section_id');  
            
        }else if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id'); 
            $this->data['classes'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');            
            $this->data['teachers'] = $this->lessonplan->get_list('teachers', $condition, '', '', '', 'id', 'ASC');           
        }        
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
            $section_id  = $this->input->post('section_id');
        }
        
        $class_id = $class_id  ? $class_id : $this->data['lesson']->class_id;
        
        /*$this->data['classes'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');*/
        $this->data['class_list'] = $this->lessonplan->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lessonplan->get_school_by_id($school_id);         
        $this->data['lessons'] = $this->lessonplan->get_lesson_plan_list($school_id, @$school->academic_year_id, $class_id, $section_id );
        $this->data['lesson_plans'] = $this->lessonplan->get_list('lesson_plans', array('status' => 1), '','', '','','id','ASC');
        
                
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
         $this->data['school_id'] = $this->data['lesson']->school_id;        
        $this->data['filter_school_id'] = $this->data['lesson']->school_id;  
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('lessonplan/index', $this->data);
    }

           
     /*****************Function get_single_lesson**********************************
     * @type            : Function
     * @function name   : get_single_lesson
     * @description     : "Load single lesson plan information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_lesson_plan(){
        
       $lesson_id = $this->input->post('lesson_id');
       
       $this->data['lesson'] = $this->lessonplan->get_single_lesson_plan($lesson_id);
       echo $this->load->view('lessonplan/get-single-lesson-plan', $this->data);
       
    }

    
    /*****************Function _prepare_lesson_plan_validation**********************************
    * @type            : Function
    * @function name   : _prepare_lesson_plan_validation
    * @description     : Process "lesson plan" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_lesson_plan_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('lesson_title', $this->lang->line('lesson_title'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('teacher_id', $this->lang->line('teacher'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function _get_posted_lesson_plan_data**********************************
    * @type            : Function
    * @function name   : _get_posted_lesson_plan_data
    * @description     : Prepare "Lesson Plan" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_lesson_plan_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'subject_id';
        $items[] = 'lesson_title';
        $items[] = 'note';

        $data = elements($items, $_POST);


        $subject = $this->lessonplan->get_single('subjects', array('id' => $data['subject_id']));
        
        $data['teacher_id'] = $subject->teacher_id;
        
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();            
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $school = $this->lessonplan->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('academic/lessonplan/index');
            }
            
            $data['academic_year_id'] = $school->academic_year_id;
            
        }



        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Lesson Plan" from database                  
    *                    and unlink assignment document from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('academic/lessonplan/index');
        }
        
        $lesson = $this->lessonplan->get_single('lesson_plans', array('id' => $id));
        
        if ($this->lessonplan->delete('lesson_plans', array('id' => $id))) {

            // delete assignment assignment
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/assignment/' . $assignment->assignment)) {
                @unlink($destination . '/assignment/' . $assignment->assignment);
            }
            
            create_log('Has been deleted a lesson plan : '.$lesson->lesson_title);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('academic/lessonplan/index/' . $lesson->class_id.'/'.$lesson->school_id);
    }
    
    
    public function get_teacher_by_subject() {
        
        $school_id  = $this->input->post('school_id');
        $class_id  = $this->input->post('class_id');
        $teacher_id  = $this->input->post('teacher_id');
                  
        $teachers = $this->lessonplan->get_teacher_by_subject($school_id, $class_id); 
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
        
        
        $select = 'selected="selected"';
        if (!empty($teachers)) {
            foreach ($teachers as $obj) {   
                
                $selected = $teacher_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name .' [ '. $obj->responsibility . ' ]</option>';
                
            }
        }

        echo $str;
    }

    /*****************Function _save_lesson**********************************
    * @type            : Function
    * @function name   : _save_lesson
    * @description     : delete "Save lesson " into database                  
    *                       
    * @param           : $lesson_id integer value
    * @return          : null 
    * ********************************************************** */
    private function _save_lesson($lesson_id){
        
        $school_id = $this->input->post('school_id');
        
        foreach($this->input->post('title') as $key=>$value){
            
            if($value){
                
                $data = array();
                $exist = '';
                
                $plan_id = @$_POST['plan_id'][$key];

                if($lesson_id){
                   $exist = $this->lessonplan->get_single('lesson_plans', array('lesson_id'=>$lesson_id, 'id'=>$plan_id));
                }  

                $data['school_id'] = $school_id;
                $data['title'] = $value;
                

                if ($this->input->post('id') && $exist) {                

                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();                
                    $this->lessonplan->update('lesson_plans', $data, array('id'=>$exist->id));

                } else {
                    
                    $data['lesson_id']   = $lesson_id;                                   
                    $data['status']     = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id(); 
                    $this->lessonplan->insert('lesson_plans', $data);
                }
            }
        }
    }
     public function remove_lesson_plan(){
        
        $lesson_id = $this->input->post('lesson_id');
        echo $this->lessonplan->delete('lesson_plans', array('id' => $lesson_id));
    } 

}