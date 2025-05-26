<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Assignment extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Assignment_Model', 'assignment', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Assignment List" user interface                 
    *                    with class wise listing    
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);
        
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
             redirect('assignment/index');
        }
        
        // for super admin 
        $school_id = '';
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }
        
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }
                
        $school = $this->assignment->get_school_by_id($school_id);         
        $this->data['assignments'] = $this->assignment->get_assignment_list($class_id, $school_id, @$school->academic_year_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['terms'] = $this->assignment->get_list('school_term', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['class_list'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_assignment') . ' | ' . SMS);
        $this->layout->view('assignment/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Asignment" user interface                 
    *                    and process to store "Assignment" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_assignment_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_assignment_data();

                $insert_id = $this->assignment->insert('assignments', $data);
                if ($insert_id) {
                    
                    create_log('Has been created an assignment : '.$data['title']); 
                    
                    success($this->lang->line('insert_success'));
                    redirect('assignment/index/'.$data['class_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('assignment/add/'.$data['class_id']);
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
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $school = $this->assignment->get_school_by_id($this->session->userdata('school_id'));
            $student_id = $this->session->userdata('profile_id');        
            $enroll_student = $this->assignment->get_single('enrollments', array('student_id' => $student_id, 'academic_year_id' => $school->academic_year_id));
            $class_id = $enroll_student->class_id;            
        }

        $this->data['assignments'] = $this->assignment->get_assignment_list($class_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['terms'] = $this->assignment->get_list('school_term', $condition, '','', '', 'id', 'ASC');
        }
        $this->data['class_list'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
                
        $this->data['class_id'] = $class_id;       
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('assignment/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Assignment" user interface                 
    *                    with populated "Assignment" value 
    *                    and process to update "Assignment" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('assignment/index');
        }
        
        if ($_POST) {
            $this->_prepare_assignment_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_assignment_data();
                $updated = $this->assignment->update('assignments', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated an assignment : '.$data['title']);
                    
                    success($this->lang->line('update_success'));
                    redirect('assignment/index/'.$data['class_id'].'/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('assignment/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['assignment'] = $this->assignment->get_single('assignments', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['assignment'] = $this->assignment->get_single('assignments', array('id' => $id));

            if (!$this->data['assignment']) {
                redirect('assignment/index');
            }
        }

        $class_id = $this->data['assignment']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        } 

        if ($this->session->userdata('role_id') == STUDENT) {
            $student_id = $this->session->userdata('profile_id');        
            $enroll_student = $this->assignment->get_single('enrollments', array('student_id' => $student_id, 'academic_year_id' => $this->data['assignment']->academic_year_id));
            $class_id = $enroll_student->class_id;
        }
        
        $this->data['assignments'] = $this->assignment->get_assignment_list($class_id, $this->data['assignment']->school_id, $this->data['assignment']->academic_year_id);
        
        $condition = array();
        $condition['status'] = 1;        
        $condition['school_id'] = $this->data['assignment']->school_id;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['terms'] = $this->assignment->get_list('school_term', $condition, '','', '', 'id', 'ASC');
        }
        $this->data['class_list'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['assignment']->school_id;        
        $this->data['filter_school_id'] = $this->data['assignment']->school_id;        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('assignment/index', $this->data);
    }

    
    /*****************Function view omit **********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific assignment data                 
    *                       
    * @param           : $assignment_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($assignment_id = null) {

        check_permission(VIEW);

        if(!is_numeric($assignment_id)){
             error($this->lang->line('unexpected_error'));
             redirect('assignment/index');
        }
        
        $this->data['assignment'] = $this->assignment->get_single_assignment($assignment_id);
        $class_id = $this->data['assignment']->class_id;
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $school = $this->assignment->get_school_by_id($this->session->userdata('school_id'));
            $student_id = $this->session->userdata('profile_id');        
            $enroll_student = $this->assignment->get_single('enrollments', array('student_id' => $student_id, 'academic_year_id' => $school->academic_year_id));
            $class_id = $enroll_student->class_id;
        }
        
        $this->data['assignments'] = $this->assignment->get_assignment_list($class_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['terms'] = $this->assignment->get_list('school_term', $condition, '','', '', 'id', 'ASC');
        }
        $this->data['class_list'] = $this->assignment->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        
        $this->data['class_id'] = $class_id;
        $this->data['schools'] = $this->schools;
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('assignment') . ' | ' . SMS);
        $this->layout->view('assignment/index', $this->data);
    }

    
           
     /*****************Function get_single_assignment**********************************
     * @type            : Function
     * @function name   : get_single_assignment
     * @description     : "Load single assignment information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_assignment(){
        
       $assignment_id = $this->input->post('assignment_id');
       
       $this->data['assignment'] = $this->assignment->get_single_assignment($assignment_id);
       echo $this->load->view('get-single-assignment', $this->data);
    }

    
    /*****************Function _prepare_assignment_validation**********************************
    * @type            : Function
    * @function name   : _prepare_assignment_validation
    * @description     : Process "assignment" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_assignment_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('term_id', $this->lang->line('term'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('deadline', $this->lang->line('deadline'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        $this->form_validation->set_rules('assignment', $this->lang->line('assignment'), 'trim|callback_assignment');
    }

    
    
    /*****************Function assignment**********************************
    * @type            : Function
    * @function name   : assignment
    * @description     : Process/check assignment document validation                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function assignment() {

        if ($_FILES['assignment']['name']) {                

            $name = $_FILES['assignment']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'txt' || $ext == 'ppt' || $ext == 'pptx') {
                return TRUE;
            } else {
                $this->form_validation->set_message('assignment', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }        
    }

    
    /*****************Function _get_posted_assignment_data**********************************
    * @type            : Function
    * @function name   : _get_posted_assignment_data
    * @description     : Prepare "Assignment" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_assignment_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'term_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'subject_id';
        $items[] = 'title';
        $items[] = 'note';

        $data = elements($items, $_POST);

        $data['deadline'] = date('Y-m-d', strtotime($this->input->post('deadline')));

        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $school = $this->assignment->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('assignment/index');
            }
            
            $data['academic_year_id'] = $school->academic_year_id;
            
        }


        if ($_FILES['assignment']['name']) {
            $data['assignment'] = $this->_upload_assignment();
        }

        return $data;
    }

    
    
    /*****************Function _upload_assignment**********************************
    * @type            : Function
    * @function name   : _upload_assignment
    * @description     : Process upload assignment document into server                  
    *                    and return document name   
    * @param           : $return_assignment string value
    * @return          : null 
    * ********************************************************** */
    private function _upload_assignment() {

        $prev_assignment = $this->input->post('prev_assignment');
        $assignment = $_FILES['assignment']['name'];
        $assignment_type = $_FILES['assignment']['type'];
        $return_assignment = '';

        if ($assignment != "") {
            if ($assignment_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $assignment_type == 'application/msword' || $assignment_type == 'text/plain' ||
                    $assignment_type == 'application/vnd.ms-office' || $assignment_type == 'application/pdf') {

                $destination = 'assets/uploads/assignment/';

                $assignment_type = explode(".", $assignment);
                $extension = strtolower($assignment_type[count($assignment_type) - 1]);
                $assignment_path = 'assignment-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['assignment']['tmp_name'], $destination . $assignment_path);

                // need to unlink previous assignment
                if ($prev_assignment != "") {
                    if (file_exists($destination . $prev_assignment)) {
                        @unlink($destination . $prev_assignment);
                    }
                }

                $return_assignment = $assignment_path;
            }
        } else {
            $return_assignment = $prev_assignment;
        }

        return $return_assignment;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Assignment" from database                  
    *                    and unlink assignment document from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('assignment/index');
        }
        
        $assignment = $this->assignment->get_single('assignments', array('id' => $id));
        
        if ($this->assignment->delete('assignments', array('id' => $id))) {

            // delete assignment assignment
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/assignment/' . $assignment->assignment)) {
                @unlink($destination . '/assignment/' . $assignment->assignment);
            }
            
            create_log('Has been deleted an assignment : '.$assignment->title);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('assignment/index/' . $assignment->class_id.'/'.$assignment->school_id);
    }
    
    
    /***************Function get_assignment_by_section**********************************
     * @type            : Function
     * @function name   : get_assignment_by_section
     * @description     : this function used to populate assignment list by section 
       for user interface
     * @param           : null 
     * @return          : $str string  value with student list
     * ********************************************************** */

    public function get_assignment_by_section() {

        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $school_id = $this->input->post('school_id');
        $assignment_id = $this->input->post('assignment_id');
        
        $school = $this->assignment->get_school_by_id($school_id); 
        $assignments = $this->assignment->get_list('assignments', array('class_id'=>$class_id, 'section_id'=>$section_id, 'academic_year_id'=>$school->academic_year_id), '','', '', 'id', 'ASC');
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
                
        $select = 'selected="selected"';
        if (!empty($assignments)) {
            foreach ($assignments as $obj) {
                $selected = $assignment_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
            }
        }

        echo $str;
    }

}