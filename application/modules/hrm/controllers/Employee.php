<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Employee.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Employee
 * @description     : Manage employee information of the school.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Employee extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Employee_Model', 'employee', true);  
       
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Employeet List" user interface                 
    *                      
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        
        $this->data['employees'] = $this->employee->get_employee_list();
        $this->data['roles'] = $this->employee->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['designations'] = $this->employee->get_list('designations', $condition, '', '', '', 'id', 'ASC');
            $this->data['grades'] = $this->employee->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_employee') . ' | ' . SMS);
        $this->layout->view('employee/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Employee" user interface                 
    *                    and process to store "Empoyee" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_employee_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_employee_data();

                $insert_id = $this->employee->insert('employees', $data);
                if ($insert_id) {
                    
                    create_log('Has been added a Employee : '.$data['name']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('hrm/employee/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('hrm/employee/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['employees'] = $this->employee->get_employee_list();
        $this->data['roles'] = $this->employee->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
         if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['designations'] = $this->employee->get_list('designations', $condition, '', '', '', 'id', 'ASC');
            $this->data['grades'] = $this->employee->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('employee') . ' | ' . SMS);
        $this->layout->view('employee/index', $this->data);
    }

    
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Employee" user interface                 
    *                    with populate "Employee" value 
    *                    and process to update "Employee" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_employee_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_employee_data();
                $updated = $this->employee->update('employees', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                     create_log('Has been updated a Employee : '.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('hrm/employee/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('hrm/employee/edit/' . $this->input->post('id'));
                }
            } else {                
                $this->data['employee'] = $this->employee->get_single_employee($this->input->post('id'));
            }
        } else {
            if ($id) {
                $this->data['employee'] = $this->employee->get_single_employee($id);

                if (!$this->data['employee']) {
                    redirect('hrm/employee/index');
                }
            }
        }

        $this->data['employees'] = $this->employee->get_employee_list();
        $this->data['roles'] = $this->employee->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition = array();
            $condition['status'] = 1;
                $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['designations'] = $this->employee->get_list('designations', $condition, '', '', '', 'id', 'ASC');
            $this->data['grades'] = $this->employee->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        }
        
       
        $this->data['school_id'] = $this->data['employee']->school_id;
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('employee') . ' | ' . SMS);
        $this->layout->view('employee/index', $this->data);
    }

        
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Employee data                 
    *                       
    * @param           : $employee_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($employee_id = null) {

        check_permission(VIEW);

        if(!is_numeric($employee_id)){
             error($this->lang->line('unexpected_error'));
             redirect('dashboard');  
        }
        
        $this->data['employees'] = $this->employee->get_employee_list();
        $this->data['roles'] = $this->employee->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['employee'] = $this->employee->get_single_employee($employee_id);
        
        
        $condition = array();
        $condition['status'] = 1;
        if($this->session->userdata('school_id') > 0){
            $condition['school_id'] = $this->session->userdata('school_id');
        }
        
        $this->data['designations'] = $this->employee->get_list('designations', $condition, '', '', '', 'id', 'ASC');
        $this->data['grades'] = $this->employee->get_list('salary_grades', $condition, '', '', '', 'id', 'ASC');
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('employee') . ' | ' . SMS);
        $this->layout->view('employee/index', $this->data);
    }

    
    
     /*****************Function get_single_employee**********************************
     * @type            : Function
     * @function name   : get_single_employee
     * @description     : "Load single employee information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_employee(){
        
       $employee_id = $this->input->post('employee_id');
       
       $this->data['employee'] = $this->employee->get_single_employee($employee_id);
       echo $this->load->view('employee/get-single-employee', $this->data);
    }
    
    /*****************Function _prepare_employee_validation**********************************
    * @type            : Function
    * @function name   : _prepare_employee_validation
    * @description     : Process "Employee" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_employee_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        if (!$this->input->post('id')) {       
            
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        }
        
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
        $this->form_validation->set_rules('school_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('designation_id', $this->lang->line('designation'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim');
        $this->form_validation->set_rules('present_address', $this->lang->line('present') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent') . ' ' . $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required');
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood_group'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');
        $this->form_validation->set_rules('dob', $this->lang->line('birth_date'), 'trim|required');
        $this->form_validation->set_rules('joining_date', $this->lang->line('join_date'), 'trim|required');
        $this->form_validation->set_rules('salary_grade_id', $this->lang->line('salary_grade'), 'trim|required');
        $this->form_validation->set_rules('salary_type', $this->lang->line('salary_type'), 'trim|required');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
    }
   
    
                    
    /*****************Function email**********************************
    * @type            : Function
    * @function name   : email
    * @description     : Unique check for "Employee Email" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->employee->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->employee->duplicate_check($this->input->post('username'), $this->input->post('id'));
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
        
   
    /*****************Function _get_posted_employee_data**********************************
    * @type            : Function
    * @function name   : _get_posted_employee_data
    * @description     : Prepare "Employee" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */ 
    private function _get_posted_employee_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'designation_id';
        $items[] = 'national_id';
        $items[] = 'name';
        $items[] = 'email';
        $items[] = 'phone';
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        $items[] = 'gender';
        $items[] = 'blood_group';
        $items[] = 'religion';
        $items[] = 'other_info';
        $items[] = 'salary_grade_id';
        $items[] = 'salary_type';
        $items[] = 'facebook_url';
        $items[] = 'linkedin_url';
        $items[] = 'google_plus_url';
        $items[] = 'instagram_url';
        $items[] = 'pinterest_url';
        $items[] = 'twitter_url';
        $items[] = 'youtube_url';      
        $items[] = 'is_view_on_web';      
        
        $data = elements($items, $_POST);  
        

        $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
        $data['joining_date'] = date('Y-m-d', strtotime($this->input->post('joining_date')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->employee->create_user();
        }

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }
        if ($_FILES['resume']['name']) {
            $data['resume'] = $this->_upload_resume();
        }
        return $data;
    }

    
       
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : Process to upload employee photo into server                  
    *                     and return photo name  
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

                $destination = 'assets/uploads/employee-photo/';

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

           
    /*****************Function _upload_resume**********************************
    * @type            : Function
    * @function name   : _upload_resume
    * @description     : Process to upload employee resume into server                  
    *                     and return resume file name  
    * @param           : null
    * @return          : $return_resume string value 
    * ********************************************************** */ 
    private function _upload_resume() {
        
        $prev_resume = $this->input->post('prev_resume');
        $resume = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $return_resume = '';

        if ($resume != "") {
            if ($resume_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $resume_type == 'application/msword' || $resume_type == 'text/plain' ||
                    $resume_type == 'application/vnd.ms-office' || $resume_type == 'application/pdf') {

                $destination = 'assets/uploads/employee-resume/';

                $file_type = explode(".", $resume);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $resume_path = 'resume-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['resume']['tmp_name'], $destination . $resume_path);

                // need to unlink previous photo
                if ($prev_resume != "") {
                    if (file_exists($destination . $prev_resume)) {
                        @unlink($destination . $prev_resume);
                    }
                }

                $return_resume = $resume_path;
            }
        } else {
            $return_resume = $prev_resume;
        }

        return $return_resume;
    }

        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Employee" data from database                  
    *                     and unlink employee photo and Resume from server  
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('hrm/employee');       
        }
        
        $employee = $this->employee->get_single('employees', array('id' => $id));
        if (!empty($employee)) {

            // delete employee data
            $this->employee->delete('employees', array('id' => $id));
            // delete employee login data
            $this->employee->delete('users', array('id' => $employee->user_id));

            // delete employee resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/employee-resume/' . $employee->resume)) {
                @unlink($destination . '/employee-resume/' . $employee->resume);
            }
            if (file_exists($destination . '/employee-photo/' . $employee->photo)) {
                @unlink($destination . '/employee-photo/' . $employee->photo);
            }
            
            create_log('Has been deleted a Employee : '.$employee->name);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('hrm/employee');
    }

}
