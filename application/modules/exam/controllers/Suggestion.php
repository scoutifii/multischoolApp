<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Suggestion extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Suggestion_Model', 'suggestion', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam Suggestion List" user interface                 
    *                    with class wise listing    
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);

        $school_id = '';    
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }  
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }  
        
        
        // for super admin      
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
            $term_id  = $this->input->post('term_id');           
        }
        
        $school = $this->suggestion->get_school_by_id($school_id);  
        
        $this->data['suggestions'] = $this->suggestion->get_suggestion_list($class_id, $school_id, @$school->academic_year_id, $term_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        $this->data['class_list'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
        if($school){
            $condition['academic_year_id'] = $school->academic_year_id;  
            $this->data['exams'] = $this->suggestion->get_list('exams', $condition, '', '', '', 'id', 'ASC');
            $this->data['terms'] = $this->suggestion->get_list('school_term', $condition, '', '', '', 'id', 'ASC');
        }
        
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_suggestion') . ' | ' . SMS);
        $this->layout->view('suggestion/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Exam Suggestion" user interface                 
    *                    and process to store "Exam Suggestion" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_suggestion_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_suggestion_data();

                $insert_id = $this->suggestion->insert('suggestions', $data);
                if ($insert_id) {
                    
                    create_log('Has been created exam suggestion : '.$data['title']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('exam/suggestion/index/' . $data['class_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('exam/suggestion/add/' . $data['class_id']);
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
        $this->data['suggestions'] = $this->suggestion->get_suggestion_list($class_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->suggestion->get_school_by_id($condition['school_id']); 
            
            $condition['academic_year_id'] = $school->academic_year_id;   
            $this->data['exams'] = $this->suggestion->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }
        
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('suggestion/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Exam Suggestion" user interface                 
    *                    with populate "Exam Suggestion" value 
    *                    and process to update "Exam Suggestion" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
           error($this->lang->line('unexpected_error'));
           redirect('exam/suggestion/index');  
        }
        
        if ($_POST) {
            $this->_prepare_suggestion_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_suggestion_data();
                $updated = $this->suggestion->update('suggestions', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated exam suggestion : '.$data['title']);
                    
                    success($this->lang->line('update_success'));
                    redirect('exam/suggestion/index/'.$data['class_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('exam/suggestion/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['suggestion'] = $this->suggestion->get_single('suggestions', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['suggestion'] = $this->suggestion->get_single('suggestions', array('id' => $id));

            if (!$this->data['suggestion']) {
                redirect('exam/suggestion/index');
            }
        }
          
        $class_id = $this->data['suggestion']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
        
       
        $this->data['suggestions'] = $this->suggestion->get_suggestion_list($class_id, $this->data['suggestion']->school_id, $this->data['suggestion']->academic_year_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');        
            $this->data['class_list'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');            
            $school = $this->suggestion->get_school_by_id($condition['school_id']);             
            $condition['academic_year_id'] = $school->academic_year_id;   
            $this->data['exams'] = $this->suggestion->get_list('exams', $condition, '', '', '', 'id', 'ASC');
            $this->data['terms'] = $this->suggestion->get_list('school_term', $condition, '', '', '', 'id', 'ASC');
        }
        
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $this->data['suggestion']->school_id;        
        $this->data['school_id'] = $this->data['suggestion']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('suggestion/index', $this->data);
    }

    
        
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific exam suggestion data                 
    *                       
    * @param           : $suggestion_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view( $suggestion_id = null) {

        check_permission(VIEW);

        if(!is_numeric($suggestion_id)){
             error($this->lang->line('unexpected_error'));
            redirect('exam/suggestion/index');  
        }
          
        $this->data['suggestion'] = $this->suggestion->get_single_suggestion($suggestion_id);
        $class_id = $this->data['suggestion']->class_id;
        
        $this->data['suggestions'] = $this->suggestion->get_suggestion_list($class_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $this->data['class_list'] = $this->suggestion->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->suggestion->get_school_by_id($condition['school_id']); 
            
            $condition['academic_year_id'] = $school->academic_year_id;   
            $this->data['exams'] = $this->suggestion->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['schools'] = $this->schools;
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('suggestion') . ' | ' . SMS);
        $this->layout->view('suggestion/index', $this->data);
    }

            
           
     /*****************Function get_single_suggestion**********************************
     * @type            : Function
     * @function name   : get_single_suggestion
     * @description     : "Load single suggestion information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_suggestion(){
        
       $suggestion_id = $this->input->post('suggestion_id');
       
        $this->data['suggestion'] = $this->suggestion->get_single_suggestion($suggestion_id);
       echo $this->load->view('suggestion/get-single-suggestion', $this->data);
    }
    
    
    /*****************Function _prepare_suggestion_validation**********************************
    * @type            : Function
    * @function name   : _prepare_suggestion_validation
    * @description     : Process "Exam suggestion" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_suggestion_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
        $this->form_validation->set_rules('term_id', $this->lang->line('term'), 'trim|required');
        $this->form_validation->set_rules('exam_id', $this->lang->line('exam_term'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required|callback_subject_id');
        $this->form_validation->set_rules('suggestion', $this->lang->line('suggestion'), 'trim|callback_suggestion');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
        
    /*****************Function subject_id**********************************
    * @type            : Function
    * @function name   : subject_id
    * @description     : Unique check for "subject_id" in document data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function subject_id() {
        
        $school_id = $this->input->post('school_id');
        $term_id = $this->input->post('term_id');
        $exam_id = $this->input->post('exam_id');
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $school = $this->suggestion->get_school_by_id($school_id); 
         
        if ($this->input->post('id') == '') {
            $suggestion = $this->suggestion->duplicate_check($school_id, $school->academic_year_id, $exam_id, $class_id, $subject_id, $term_id);
            if ($suggestion) {
                $this->form_validation->set_message('subject_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $suggestion = $this->suggestion->duplicate_check($school_id, $school->academic_year_id, $exam_id, $class_id, $subject_id, $term_id, $this->input->post('id'));
            if ($suggestion) {
                $this->form_validation->set_message('subject_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
       
    /*****************Function suggestion**********************************
    * @type            : Function
    * @function name   : suggestion
    * @description     : Check suggestion document file format and validate document                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function suggestion() {

        if ($_FILES['suggestion']['name']) {

            $name = $_FILES['suggestion']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'txt' || $ext == 'ppt' || $ext == 'pptx') {
                return TRUE;
            } else {
                $this->form_validation->set_message('suggestion', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }

    
    /*****************Function _get_posted_suggestion_data**********************************
    * @type            : Function
    * @function name   : _get_posted_suggestion_data
    * @description     : Prepare "Exam Suggestion" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_suggestion_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'term_id';
        $items[] = 'exam_id';
        $items[] = 'class_id';
        $items[] = 'subject_id';
        $items[] = 'title';
        $items[] = 'note';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $school = $this->suggestion->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/suggestion/index');
            }
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        if (isset($_FILES['suggestion']['name'])) {
            $data['suggestion'] = $this->_upload_suggestion();
        }

        return $data;
    }

    
    
    /*****************Function _upload_suggestion**********************************
    * @type            : Function
    * @function name   : _upload_suggestion
    * @description     : Process to upload exam suggestion document into server                 
    *                    and return document name   
    * @param           : null
    * @return          : $return_suggestion string value 
    * ********************************************************** */
    private function _upload_suggestion() {

        $prev_suggestion = $this->input->post('prev_suggestion');
        $suggestion = $_FILES['suggestion']['name'];
        $suggestion_type = $_FILES['suggestion']['type'];
        $return_suggestion = '';

        if ($suggestion != "") {
            if ($suggestion_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $suggestion_type == 'application/msword' || $suggestion_type == 'text/plain' ||
                    $suggestion_type == 'application/vnd.ms-office' || $suggestion_type == 'application/pdf') {

                $destination = 'assets/uploads/suggestion/';

                $file_type = explode(".", $suggestion);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $suggestion_path = 'suggestion-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['suggestion']['tmp_name'], $destination . $suggestion_path);

                // need to unlink previous suggestion
                if ($prev_suggestion != "") {
                    if (file_exists($destination . $prev_suggestion)) {
                        @unlink($destination . $prev_suggestion);
                    }
                }

                $return_suggestion = $suggestion_path;
            }
        } else {
            $return_suggestion = $prev_suggestion;
        }

        return $return_suggestion;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Exam Suggestion" from database                  
    *                    and unlink suggestion document from server    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/suggestion/index');    
        }
        
        $suggestion = $this->suggestion->get_single('suggestions', array('id' => $id));
        
        if ($this->suggestion->delete('suggestions', array('id' => $id))) {

            // delete suggestion
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/suggestion/' . $suggestion->suggestion)) {
                @unlink($destination . '/suggestion/' . $suggestion->suggestion);
            }
            
            create_log('Has been deleted exam suggestion : '.$suggestion->title);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('exam/suggestion/index/' . $suggestion->class_id);
    }

}
