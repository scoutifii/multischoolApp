<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lecture extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Lecture_Model', 'lecture', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Lecture List" user interface                 
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
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $school_id = $this->session->userdata('school_id');    
            $class_id = $this->session->userdata('class_id');    
            $section_id = $this->session->userdata('section_id');  
            
        }else if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');            
        }
        
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
        }
        
        
        $this->data['classes'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lecture->get_school_by_id($school_id);         
        $this->data['lectures'] = $this->lecture->get_lecture_list($school_id, @$school->academic_year_id, $class_id, $section_id );
                
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_class_lecture') . ' | ' . SMS);
        $this->layout->view('lecture/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Asignment" user interface                 
    *                    and process to store "Lecture" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_lecture_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_lecture_data();

                $insert_id = $this->lecture->insert('video_lectures', $data);
                if ($insert_id) {
                    
                    create_log('Has been uploaded an lecture : '.$data['lecture_title']);                     
                    success($this->lang->line('insert_success'));
                    redirect('teacher/lecture/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('teacher/lecture/add');
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
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
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
        
        $this->data['classes'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lecture->get_school_by_id($school_id);         
        $this->data['lectures'] = $this->lecture->get_lecture_list($school_id, @$school->academic_year_id, $class_id, $section_id );
         
                
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('lecture/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Lecture" user interface                 
    *                    with populated "Lecture" value 
    *                    and process to update "Lecture" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('teacher/lecture/index');
        }
        
        if ($_POST) {
            $this->_prepare_lecture_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_lecture_data();
                $updated = $this->lecture->update('video_lectures', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a video lecture : '.$data['lecture_title']);                    
                    success($this->lang->line('update_success'));
                    redirect('teacher/lecture/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('teacher/lecture/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['lecture'] = $this->lecture->get_single('video_lectures', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['lecture'] = $this->lecture->get_single('video_lectures', array('id' => $id));

            if (!$this->data['lecture']) {
                redirect('teacher/lecture/index');
            }
        }
         
        // for super admin 
        $school_id = '';
        $class_id = '';
        $section_id = '';
        $condition = array();
        $condition['status'] = 1; 
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
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
        
        $class_id = $class_id  ? $class_id : $this->data['lecture']->class_id;
        
        $this->data['classes'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->lecture->get_list('classes', $condition, '','', '', 'id', 'ASC');
                        
        $school = $this->lecture->get_school_by_id($school_id);         
        $this->data['lectures'] = $this->lecture->get_lecture_list($school_id, @$school->academic_year_id, $class_id, $section_id );
       
                
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
         $this->data['school_id'] = $this->data['lecture']->school_id;        
        $this->data['filter_school_id'] = $this->data['lecture']->school_id;  
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('lecture/index', $this->data);
    }

           
     /*****************Function get_single_lecture**********************************
     * @type            : Function
     * @function name   : get_single_lecture
     * @description     : "Load single lecture information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_lecture(){
        
       $lecture_id = $this->input->post('lecture_id');
       
       $this->data['lecture'] = $this->lecture->get_single_lecture($lecture_id);
       echo $this->load->view('lecture/get-single-lecture', $this->data);
       
    }

    
    /*****************Function _prepare_lecture_validation**********************************
    * @type            : Function
    * @function name   : _prepare_lecture_validation
    * @description     : Process "lecture" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_lecture_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('lecture_title', $this->lang->line('lecture_title'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('lecture_type', $this->lang->line('lecture_type'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        $this->form_validation->set_rules('lecture_ppt', $this->lang->line('lecture_ppt'), 'trim|callback_lecture_ppt');
    }

    
    
    /*****************Function lecture_ppt**********************************
    * @type            : Function
    * @function name   : lecture_ppt
    * @description     : Process/check lecture_ppt document validation                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function lecture_ppt() {

        if ($_FILES['lecture_ppt']['name']) {                

            $name = $_FILES['lecture_ppt']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'ppt' || $ext == 'pptx') {
                return TRUE;
            } else {
                $this->form_validation->set_message('lecture_ppt', $this->lang->line('valid_file_format_lecture'));
                return FALSE;
            }
        }        
    }

    
    /*****************Function _get_posted_lecture_data**********************************
    * @type            : Function
    * @function name   : _get_posted_lecture_data
    * @description     : Prepare "Lecture" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_lecture_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'subject_id';
        $items[] = 'lecture_type';
        $items[] = 'lecture_title';
        $items[] = 'video_id';
        $items[] = 'note';

        $data = elements($items, $_POST);


        $subject = $this->lecture->get_single('subjects', array('id' => $data['subject_id']));
        
        $data['teacher_id'] = $subject->teacher_id;
        
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            // need to remove old ppt file if post video id
            if($this->input->post('video_id') != '' && $this->input->post('prev_lecture_ppt') != ''){
                $destination = 'assets/uploads/video-lecture/';
                $prev_lecture_ppt = $this->input->post('prev_lecture_ppt');
                if (file_exists($destination . $prev_lecture_ppt)) {
                    @unlink($destination . $prev_lecture_ppt);
                }                
                $data['lecture_ppt'] = '';
            }
            
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $school = $this->lecture->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('teacher/lecture/index');
            }
            
            $data['academic_year_id'] = $school->academic_year_id;
            
        }


        if ($_FILES['lecture_ppt']['name']) {
             $data['video_id'] = '';
            $data['lecture_ppt'] = $this->_upload_lecture_ppt();
        }

        return $data;
    }

    
    
    /*****************Function _upload_lecture_ppt**********************************
    * @type            : Function
    * @function name   : _upload_lecture_ppt
    * @description     : Process upload lecture ppt document into server                  
    *                    and return document name   
    * @return          : null 
    * ********************************************************** */
    private function _upload_lecture_ppt() {

        $prev_lecture_ppt = $this->input->post('prev_lecture_ppt');
        $lecture_ppt = $_FILES['lecture_ppt']['name'];
        $lecture_ppt_type = $_FILES['lecture_ppt']['type'];
        $return_lecture_ppt = '';

        if ($lecture_ppt != "") {
            if ($lecture_ppt_type == 'application/powerpoint' ||
                    $lecture_ppt_type == 'application/vnd.ms-powerpoint' ||
                    $lecture_ppt_type == 'application/msword' ||
                    $lecture_ppt_type == 'application/vnd.ms-office' ||
                    $lecture_ppt_type == 'application/mspowerpoint' ||
                    $lecture_ppt_type == 'application/x-mspowerpoint' ||
                    $lecture_ppt_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                  
                    ) {

                $destination = 'assets/uploads/video-lecture/';

                $lecture_ppt_type = explode(".", $lecture_ppt);
                $extension = strtolower($lecture_ppt_type[count($lecture_ppt_type) - 1]);
                $lecture_ppt_path = 'lecture-ppt-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['lecture_ppt']['tmp_name'], $destination . $lecture_ppt_path);

                // need to unlink previous assignment
                if ($prev_lecture_ppt != "") {
                    if (file_exists($destination . $prev_lecture_ppt)) {
                        @unlink($destination . $prev_lecture_ppt);
                    }
                }

                $return_lecture_ppt = $lecture_ppt_path;
            }
        } else {
            $return_lecture_ppt = $prev_lecture_ppt;
        }

        return $return_lecture_ppt;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Lecture" from database                  
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
    
    
    
    
    public function get_teacher_by_subject() {
        
        $school_id  = $this->input->post('school_id');
        $class_id  = $this->input->post('class_id');
        $teacher_id  = $this->input->post('teacher_id');
                  
        $teachers = $this->lecture->get_teacher_by_subject($school_id, $class_id); 
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

}