<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Student extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();      
        
        $this->load->model('Student_Model', 'student', true);            
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Student List" user interface                 
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
              
        if(!$school_id && $this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
        }
        
        if($class_id && !$school_id){
            $class = $this->student->get_single('classes', array('id'=>$class_id));
            $school_id = $class->school_id;
        }
        
        $school = $this->student->get_school_by_id($school_id);
        
        if($this->session->userdata('role_id') == STUDENT){
          $class_id =  $this->session->userdata('class_id');
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        
        
        if($school_id){
            $this->data['students'] = $this->student->get_student_list($class_id, $school_id, $school->academic_year_id);
            $this->data['custom_id'] = $this->generator(10);
            $this->data['password'] = $this->spassgenerator(8); 
        }
                
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC');
            
        }
        
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_student') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Student" user interface                 
    *                    and process to store "Student" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_student_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_student_data();

                $insert_id = $this->student->insert('students', $data);

                if ($insert_id) {
                    $this->__insert_enrollment($insert_id);
                    create_log('Has been added a srtudent studdent : '. $data['name']);    
                    success($this->lang->line('insert_success'));
                    redirect('student/index/'.$this->input->post('class_id'));
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('student/add/'.$this->input->post('class_id'));
                }
            } else {

                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
                $this->data['school_id'] = $_POST['school_id'];
            }
        }
        
        $class_id = $this->uri->segment(4);
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }

        $this->data['class_id'] = $class_id;
        $this->data['students'] = $this->student->get_student_list($class_id);
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
         
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['discounts'] = $this->student->get_list('discounts', $condition, '','', '', 'id', 'ASC');
            $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
            $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Student" user interface                 
    *                    with populate "Student" value 
    *                    and process to update "Student" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('student/index');     
        }
        
        $student = $this->student->get_single('students', array('id'=>$id));        
        $school = $this->student->get_school_by_id($student->school_id);
        
        if ($_POST) {
            $this->_prepare_student_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_student_data();
                $updated = $this->student->update('students', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    $this->__update_enrollment();
                    create_log('Has been updated a student studdent : '. $data['name']);  
                    success($this->lang->line('update_success'));
                    redirect('student/index/'.$this->input->post('class_id'));
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('student/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['student'] = $this->student->get_single_student($this->input->post('id'), $school->academic_year_id);
            }
        }

        if ($id) {            
            
            $this->data['student'] = $this->student->get_single_student($id, $school->academic_year_id);

            if (!$this->data['student']) {
                redirect('student/index');
            }
        }
        
        $class_id = $this->data['student']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        } 

        $school = $this->student->get_school_by_id($this->data['student']->school_id);
        
        $this->data['class_id'] = $class_id;
        $this->data['students'] = $this->student->get_student_list($class_id, $school->id, $school->academic_year_id);
        $this->data['roles'] = $this->student->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
          
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }else{
            $condition['school_id'] = $this->data['student']->school_id;
            
        }
        
        $this->data['discounts'] = $this->student->get_list('discounts', $condition, '','', '', 'id', 'ASC');
        $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['guardians'] = $this->student->get_list('guardians', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['types']      = $this->student->get_list('student_types', $condition, '','', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['student']->school_id;
        $this->data['filter_school_id'] = $this->data['student']->school_id;
        
        $this->data['schools'] = $this->schools;
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

    
     /*****************Function get_single_student**********************************
     * @type            : Function
     * @function name   : get_single_student
     * @description     : "Load single student information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_student(){
        
        $this->load->helper('report');
        $student_id = $this->input->post('student_id');
        
        $student = $this->student->get_single('students', array('id'=>$student_id));
               
        $school = $this->student->get_school_by_id($student->school_id);
        
        $this->data['student'] = $this->student->get_single_student($student_id, $school->academic_year_id);                       
        $this->data['guardian'] = $this->student->get_single_guardian($this->data['student']->guardian_id);
        
        $this->data['days'] = 31;
        $this->data['academic_year_id'] = $school->academic_year_id;
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['section_id'] = $this->data['student']->section_id;
        $this->data['student_id'] = $student_id;
        $this->data['school_id'] = $student->school_id;
        
        $this->data['exams'] = $this->student->get_list('exams', array('status' => 1, 'school_id'=>$student->school_id, 'academic_year_id' => $school->academic_year_id), '', '', '', 'id', 'ASC');
        $this->data['invoices'] = $this->student->get_invoice_list($student->school_id, $student_id);  
        $this->data['activity'] = $this->student->get_activity_list($student_id);  
        
        echo $this->load->view('get-single-student', $this->data);
    }
    
    
        
    /*****************Function _prepare_student_validation**********************************
    * @type            : Function
    * @function name   : _prepare_student_validation
    * @description     : Process "Student" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_student_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('custom_id', $this->lang->line('custom_id'), 'trim|required');
        $this->form_validation->set_rules('admission_no', $this->lang->line('admission_no'), 'trim|required');
        $this->form_validation->set_rules('admission_date', $this->lang->line('admission_date'), 'trim|required');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required');
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood_group'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');        
        $this->form_validation->set_rules('child_with_disabilities', $this->lang->line('child_with_disabilities'), 'trim');
        $this->form_validation->set_rules('type_id', $this->lang->line('student_type'), 'trim');
        $this->form_validation->set_rules('dob', $this->lang->line('birth_date'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('group', $this->lang->line('group'), 'trim');
        $this->form_validation->set_rules('registration_no', $this->lang->line('registration_no'), 'trim');

        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
         
        $this->form_validation->set_rules('national_id', $this->lang->line('national_id'), 'trim');       
        
        
        $this->form_validation->set_rules('father_photo', $this->lang->line('father_photo'), 'trim|callback_father_photo');
        $this->form_validation->set_rules('mother_photo', $this->lang->line('mother_photo'), 'trim|callback_mother_photo');

        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
            $this->form_validation->set_rules('roll_no', $this->lang->line('roll_no'), 'trim|required');
        }

        if ($this->input->post('is_guardian') == 'exist_guardian') {
            $this->form_validation->set_rules('guardian_id',  $this->lang->line('guardian_name'), 'trim|required');
        } 

        $this->form_validation->set_rules('transfer_certificate', $this->lang->line('transfer_certificate'), 'trim|callback_transfer_certificate');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
        $this->form_validation->set_rules('photo', $this->lang->line('photo'), 'trim|callback_photo');
        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[30]');
    
        
        $this->form_validation->set_rules('present_address', $this->lang->line('present_address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent_address'), 'trim');
        
        if ($this->input->post('is_guardian') != 'exist_guardian' && !$this->input->post('id')) {
            $this->form_validation->set_rules('gud_username',   $this->lang->line('username'), 'trim|required');
            $this->form_validation->set_rules('gud_name',   $this->lang->line('name'), 'trim|required');
            $this->form_validation->set_rules('gud_phone',  $this->lang->line('phone'), 'trim|required');
        } 
        
}
                        
    /*****************Function username**********************************
    * @type            : Function
    * @function name   : username
    * @description     : Unique check for "Student username" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->student->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->student->duplicate_check($this->input->post('username'), $this->input->post('id'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    
    /*****************Function photo**********************************
    * @type            : Function
    * @function name   : photo
    * @description     : validate student profile photo                 
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function photo() {
        if ($_FILES['photo']['name']) {
            $name = $_FILES['photo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('photo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    /*****************Function transfer_certificate**********************************
    * @type            : Function
    * @function name   : transfer_certificate
    * @description     : validate student transfer_certificate                
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function transfer_certificate() {
        if ($_FILES['transfer_certificate']['name']) {
            $name = $_FILES['transfer_certificate']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('transfer_certificate', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    /*****************Function father_photo**********************************
    * @type            : Function
    * @function name   : father_photo
    * @description     : validate student father_photo               
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function father_photo() {
        if ($_FILES['father_photo']['name']) {
            $name = $_FILES['father_photo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('father_photo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    /*****************Function mother_photo**********************************
    * @type            : Function
    * @function name   : mother_photo
    * @description     : validate student mother_photo               
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function mother_photo() {
        if ($_FILES['mother_photo']['name']) {
            $name = $_FILES['mother_photo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('mother_photo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }

       
    /*****************Function _get_posted_student_data**********************************
    * @type            : Function
    * @function name   : _get_posted_student_data
    * @description     : Prepare "Student" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_student_data() {
        $items = array();

        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'custom_id';
        $items[] = 'admission_no';
        $items[] = 'admission_date';
        $items[] = 'gender';
        $items[] = 'blood_group'; 
        $items[] = 'religion';
        $items[] = 'child_with_disabilities';
        $items[] = 'phone';
        $items[] = 'email';
        $items[] = 'national_id';
        $items[] = 'type_id'; 
        $items[] = 'class_id'; 
        $items[] = 'section_id';        
        $items[] = 'registration_no';
        $items[] = 'group';
        $items[] = 'roll_no';
        $items[] = 'discount_id';
        $items[] = 'second_language';
        $items[] = 'previous_school';
        $items[] = 'previous_class';
        $items[] = 'health_condition';
        $items[] = 'other_info';
        /*$items[] = 'father_name';
        $items[] = 'father_phone';
        $items[] = 'father_education';
        $items[] = 'father_profession';
        $items[] = 'father_designation';
        $items[] = 'mother_name';
        $items[] = 'mother_phone';
        $items[] = 'mother_education';
        $items[] = 'mother_profession';
        $items[] = 'mother_designation'; *      
        

        /*$items[] = 'caste';*/
        
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        
        $items[] = 'is_guardian';
        $items[] = 'relation_with';
    

        $data = elements($items, $_POST);

        $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
        $data['admission_date'] = date('Y-m-d', strtotime($this->input->post('admission_date')));
        $data['age'] = floor((time() - strtotime($data['dob'])) / 31556926);
        
        $school = $this->student->get_school_by_id($data['school_id']);

        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('student/index');
        }

        if ($this->input->post('id')) {
            
            $data['guardian_id'] = $this->input->post('guardian_id');
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            $data['status_type'] = $this->input->post('status_type');
            
        } else {    
            
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            $data['status'] = 1;
            $data['status_type'] = 'regular';
            
             // create guardian and guardian user if not exist
            if($this->input->post('is_guardian') == 'exist_guardian'){
                
                $data['guardian_id'] = $this->input->post('guardian_id');
                
            }else{

                $info = array();
                $guardian = array();    

                $info['role_id']  = GUARDIAN;
                $info['name']     =  $this->input->post('gud_name');
                $info['phone'] = $this->input->post('gud_phone'); 
                $info['email'] = $this->input->post('gud_email'); 
                $info['username'] = $this->input->post('gud_username'); 
                $info['password'] = rand(5);
                
                // now creating guardian user
                $guardian['user_id'] = $this->student->create_custom_user($info);     

                // create guardian....                
                $guardian['school_id']    = $data['school_id'];
                $guardian['name']    = $this->input->post('gud_name');
                $guardian['phone']   = $this->input->post('gud_phone');
                $guardian['email']   = $this->input->post('gud_email');
                $guardian['profession']   = $this->input->post('gud_profession');
                $guardian['religion']   = $this->input->post('gud_religion');
                $guardian['national_id'] = $this->input->post('gud_national_id');
                $guardian['present_address']   = $this->input->post('gud_present_address');
                $guardian['permanent_address']   = $this->input->post('gud_permanent_address');
                $guardian['other_info']   = $this->input->post('gud_other_info');
                $guardian['created_at'] = date('Y-m-d H:i:s');
                $guardian['created_by'] = logged_in_user_id();
                $guardian['modified_at'] = date('Y-m-d H:i:s');
                $guardian['modified_by'] = logged_in_user_id();
                $guardian['status'] = 1;
                
                $data['guardian_id'] = $this->student->insert('guardians', $guardian);
            }
            
            
            // create user 
            $data['user_id'] = $this->student->create_user();
        }

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }
        if ($_FILES['transfer_certificate']['name']) {
            $data['transfer_certificate'] = $this->_upload_transfer_certificate();
        }
        if ($_FILES['father_photo']['name']) {
            $data['father_photo'] = $this->_upload_father_photo();
        }
        if ($_FILES['mother_photo']['name']) {
            $data['mother_photo'] = $this->_upload_mother_photo();
        }

        return $data;
    }

           
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : process to upload student profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_photo string value 
    * ********************************************************** */
    private function _upload_photo() {

        $prev_photo = $this->input->post('prev_photo');
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                $destination = 'assets/uploads/student-photo/';

                $file_type = explode(".", $photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['photo']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }
    
        /*****************Function _upload_transfer_certificate**********************************
    * @type            : Function
    * @function name   : _upload_transfer_certificate
    * @description     : process to upload student transfer_certificate in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_photo string value 
    * ********************************************************** */
    private function _upload_transfer_certificate() {

        $prev_transfer_certificate = $this->input->post('prev_transfer_certificate');
        $transfer_certificate = $_FILES['transfer_certificate']['name'];
        $transfer_certificate_type = $_FILES['transfer_certificate']['type'];
        $return_transfer_certificate = '';
        if ($transfer_certificate != "") {
            if ($transfer_certificate_type == 'image/jpeg' || $transfer_certificate_type == 'image/pjpeg' ||
                    $transfer_certificate_type == 'image/jpg' || $transfer_certificate_type == 'image/png' ||
                    $transfer_certificate_type == 'image/x-png' || $transfer_certificate_type == 'image/gif') {

                $destination = 'assets/uploads/transfer-certificate/';

                $file_type = explode(".", $transfer_certificate);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $transfer_certificate_path = 'tc-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['transfer_certificate']['tmp_name'], $destination . $transfer_certificate_path);

                // need to unlink previous transfer_certificate
                if ($prev_transfer_certificate != "") {
                    if (file_exists($destination . $prev_transfer_certificate)) {
                        @unlink($destination . $prev_transfer_certificate);
                    }
                }

                $return_transfer_certificate = $transfer_certificate_path;
            }
        } else {
            $return_transfer_certificate = $prev_transfer_certificate;
        }

        return $return_transfer_certificate;
    }

    
               
    /*****************Function _upload_father_photo**********************************
    * @type            : Function
    * @function name   : _upload_father_photo
    * @description     : process to upload student profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_father_photo string value 
    * ********************************************************** */
    private function _upload_father_photo() {

        $prev_father_photo = $this->input->post('prev_father_photo');
        $father_photo = $_FILES['father_photo']['name'];
        $father_photo_type = $_FILES['father_photo']['type'];
        $return_father_photo = '';
        if ($father_photo != "") {
            if ($father_photo_type == 'image/jpeg' || $father_photo_type == 'image/pjpeg' ||
                    $father_photo_type == 'image/jpg' || $father_photo_type == 'image/png' ||
                    $father_photo_type == 'image/x-png' || $father_photo_type == 'image/gif') {

                $destination = 'assets/uploads/father-photo/';

                $file_type = explode(".", $father_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $father_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['father_photo']['tmp_name'], $destination . $father_photo_path);

                // need to unlink previous father_photo
                if ($prev_father_photo != "") {
                    if (file_exists($destination . $prev_father_photo)) {
                        @unlink($destination . $prev_father_photo);
                    }
                }

                $return_father_photo = $father_photo_path;
            }
        } else {
            $return_father_photo = $prev_father_photo;
        }

        return $return_father_photo;
    }
    
    
    
               
    /*****************Function _upload_mother_photo**********************************
    * @type            : Function
    * @function name   : _upload_mother_photo
    * @description     : process to upload mother profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_mother_photo string value 
    * ********************************************************** */
    private function _upload_mother_photo() {

        $prev_mother_photo = $this->input->post('prev_mother_photo');
        $mother_photo = $_FILES['mother_photo']['name'];
        $mother_photo_type = $_FILES['mother_photo']['type'];
        $return_mother_photo = '';
        if ($mother_photo != "") {
            if ($mother_photo_type == 'image/jpeg' || $mother_photo_type == 'image/pjpeg' ||
                    $mother_photo_type == 'image/jpg' || $mother_photo_type == 'image/png' ||
                    $mother_photo_type == 'image/x-png' || $mother_photo_type == 'image/gif') {

                $destination = 'assets/uploads/mother-photo/';

                $file_type = explode(".", $mother_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $mother_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['mother_photo']['tmp_name'], $destination . $mother_photo_path);

                // need to unlink previous mother_photo
                if ($prev_mother_photo != "") {
                    if (file_exists($destination . $prev_mother_photo)) {
                        @unlink($destination . $prev_mother_photo);
                    }
                }

                $return_mother_photo = $mother_photo_path;
            }
        } else {
            $return_mother_photo = $prev_mother_photo;
        }

        return $return_mother_photo;
    }
    

        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Student" data from database                  
    *                     also delete all relational data
    *                     and unlink student photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('student/index');
        }
        
        $student = $this->student->get_single('students', array('id' => $id));
        
        // get invoices
        $invoices = $this->student->get_invoice_list($student->school_id, $id); 
        if(!empty($invoices)){
            error($this->lang->line('this_student_have_unpaid_invoice'));
            redirect('student/index');
        }        
        
        $school = $this->student->get_school_by_id($student->school_id);
        $enroll = $this->student->get_single('enrollments', array('student_id' => $student->id, 'academic_year_id'=>$school->academic_year_id));
               
            // delete student data
        if ($this->student->delete('students', array('id' => $id))) {

            // delete student login data
            $this->student->delete('users', array('id' => $student->user_id));

            // delete student enrollments
            $this->student->delete('enrollments', array('student_id' => $student->id));

            // delete student hostel_members
            $this->student->delete('hostel_members', array('user_id' => $student->user_id));

            // delete student transport_members
            $this->student->delete('transport_members', array('user_id' => $student->user_id));

            // delete student library_members
            $this->student->delete('library_members', array('user_id' => $student->user_id));

            // delete student resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/student-photo/' . $student->photo)) {
                @unlink($destination . '/student-photo/' . $student->photo);
            }

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('student/index/'.$enroll->class_id);
    }

        
    /*****************Function __insert_enrollment**********************************
    * @type            : Function
    * @function name   : __insert_enrollment
    * @description     : save student info to enrollment while create a new student                  
    * @param           : $insert_id integer value
    * @return          : null 
    * ********************************************************** */
    private function __insert_enrollment($insert_id) {
        $data = array();
        
        $school = $this->student->get_school_by_id($this->input->post('school_id'));
        
        $data['student_id'] = $insert_id;
        $data['school_id'] = $this->input->post('school_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['academic_year_id'] = $school->academic_year_id;
        $data['roll_no'] = $this->input->post('roll_no');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status'] = 1;
        $this->db->insert('enrollments', $data);
    }

    /*****************Function __update_enrollment**********************************
    * @type            : Function
    * @function name   : __update_enrollment
    * @description     : update student info to enrollment while update a student                  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function __update_enrollment() {

        $school = $this->student->get_school_by_id($this->input->post('school_id'));
         
        $data = array();
        $data['school_id'] = $this->input->post('school_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        //$this->db->where('student_id', $this->input->post('id'));
        //$this->db->where('academic_year_id', $school->academic_year_id);
        
        $condition = array();
        $condition['student_id'] = $this->input->post('id');
        $condition['academic_year_id'] = $school->academic_year_id;
        $this->db->update('enrollments', $data, $condition);
               
    }
    
    
    
        
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Student view" user interface                 
    *                    with class wise listing    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);
        
       
        $this->load->helper('report');
        
        $student = $this->student->get_single('students', array('id'=>$id));
               
        $school = $this->student->get_school_by_id($student->school_id);
        
        $this->data['student'] = $this->student->get_single_student($id, $school->academic_year_id);                       
        $this->data['guardian'] = $this->student->get_single_guardian($this->data['student']->guardian_id);
        
        $this->data['days'] = 31;
        $this->data['academic_year_id'] = $school->academic_year_id;
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['section_id'] = $this->data['student']->section_id;
        $this->data['student_id'] = $id;
        $this->data['school_id'] = $student->school_id;
        
        $this->data['exams'] = $this->student->get_list('exams', array('status' => 1, 'school_id'=>$student->school_id, 'academic_year_id' => $school->academic_year_id), '', '', '', 'id', 'ASC');
        $this->data['invoices'] = $this->student->get_invoice_list($student->school_id, $id);  
        $this->data['activity'] = $this->student->get_activity_list($id);
        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }else{
            $condition['school_id'] = $this->data['student']->school_id;            
        }
        $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $this->data['student']->class_id;
        $this->data['filter_class_id'] = $this->data['student']->class_id;
        $this->data['filter_school_id'] = $student->school_id;
        
        
        $this->data['schools'] = $this->schools;
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('manage_student') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

    public function generator($length)
    {
        $number=array("1","2","3","4","5","6","7","8","9","0");
    
        for($i=0; $i<$length; $i++)
        {
            $rand_value=rand(0,8);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }

    public function spassgenerator($length)
    {
        $number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0","@","#","$","%","&","*","_");
    
        for($i=0; $i<$length; $i++)
        {
            $rand_value=rand(0,68);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }

}