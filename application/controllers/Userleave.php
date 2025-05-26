<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Userleave.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Userleave
 * @description     : Manage leave.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Userleave extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Userleave_Model', 'leave', true); 
        $this->load->model('Profile_Model', 'profile', true);    
        
        if($this->session->userdata('role_id') == SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Userleave List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
                         
        $this->data['types'] = $this->leave->get_type();             
        $this->data['applications'] = $this->leave->get_application_list();    
        
        if(logged_in_role_id() == GUARDIAN){
            
            $school_id = $this->session->userdata('school_id');
            $profile_id = $this->session->userdata('profile_id');
            $school = $this->profile->get_school_by_id($school_id);            
            $this->data['students'] = $this->profile->get_student_list($profile_id, $school->academic_year_id);
            
        }
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_leave_application'). ' | ' . SMS);
        $this->layout->view('profile/leave', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new leave" user interface                 
    *                    and process to store "leave" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_leave_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_leave_data();

                $insert_id = $this->leave->insert('leave_applications', $data);
                if ($insert_id) {                    
                    create_log('Has been added leave application');                     
                    success($this->lang->line('insert_success'));
                    redirect('userleave/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('userleave/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;                
            }
        }
                     
        $this->data['types'] = $this->leave->get_type(); 
        $this->data['applications'] = $this->leave->get_application_list(); 
         
        if(logged_in_role_id() == GUARDIAN){
            
            $school_id = $this->session->userdata('school_id');
            $profile_id = $this->session->userdata('profile_id');
            $school = $this->profile->get_school_by_id($school_id);            
            $this->data['students'] = $this->profile->get_student_list($profile_id, $school->academic_year_id);
            
        }
        
        $this->data['add'] = TRUE;        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('profile/leave', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "leave" user interface                 
    *                    with populated "leave" value 
    *                    and process to update "leave" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('userleave/index');
        }
       
        if ($_POST) {
            $this->_prepare_leave_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_leave_data();
                $updated = $this->leave->update('leave_applications', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a leave application');                    
                    success($this->lang->line('update_success'));
                    redirect('userleave/index/');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('userleave/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['application'] = $this->leave->get_single_application($this->input->post('id'));
            }
        }

        if ($id) {
            
            $this->data['application'] = $this->leave->get_single_application($id);
            if (!$this->data['application']) {
                redirect('userleave/index');
            }
        }

        
        $this->data['types'] = $this->leave->get_type(); 
        $this->data['applications'] = $this->leave->get_application_list(); 
                 
        if(logged_in_role_id() == GUARDIAN){
            
            $school_id = $this->session->userdata('school_id');
            $profile_id = $this->session->userdata('profile_id');
            $school = $this->profile->get_school_by_id($school_id);            
            $this->data['students'] = $this->profile->get_student_list($profile_id, $school->academic_year_id);
            
        }
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('profile/leave', $this->data);
    }

       
           
     /*****************Function get_single_application**********************************
     * @type            : Function
     * @function name   : get_single_application
     * @description     : "Load single leave information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_leave_application(){
        
       $application_id = $this->input->post('application_id');
       
       $this->data['application'] = $this->leave->get_single_application($application_id);
       echo $this->load->view('profile/get-single-leave-application', $this->data);
    }

    
    /*****************Function _prepare_leave_validation**********************************
    * @type            : Function
    * @function name   : _prepare_leave_validation
    * @description     : Process "leave" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_leave_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
         
        $this->form_validation->set_rules('type_id', $this->lang->line('leave_type'), 'trim|required');
        $this->form_validation->set_rules('leave_from', $this->lang->line('leave_from'), 'trim|required');
        $this->form_validation->set_rules('leave_to', $this->lang->line('leave_to'), 'trim|required|callback_leave_to');
        $this->form_validation->set_rules('leave_reason', $this->lang->line('reason'), 'trim');
        $this->form_validation->set_rules('attachment', $this->lang->line('attachment'), 'trim|callback_attachment');
        
    }
    
    
                        
    /*****************Function leave_to**********************************
    * @Type            : Function
    * @function name   : leave_to
    * @description     : date schedule check data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function leave_to() {
        
        $leave_from = date('Y-m-d', strtotime($this->input->post('leave_from')));
        $leave_to   = date('Y-m-d', strtotime($this->input->post('leave_to')));
            
        if ($leave_from > $leave_to ) {
            $this->form_validation->set_message('leave_to', $this->lang->line('to_date_must_be_big'));
            return FALSE;
        } else {
            return TRUE;
        }        
    }

    /*****************Function attachment**********************************
    * @type            : Function
    * @function name   : attachment
    * @description     : Process/check attachment document validation                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function attachment() {

        if ($this->input->post('id')) {

            if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {
                $name = $_FILES['attachment']['name'];
                $arr = explode('.', $name);
                $ext = end($arr);
                if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'txt' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('attachment', $this->lang->line('select_valid_file_format'));
                    return FALSE;
                }
            }
        } else {

            if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {                
           
                $name = $_FILES['attachment']['name'];
                $arr = explode('.', $name);
                $ext = end($arr);
                if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'txt' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('attachment', $this->lang->line('select_valid_file_format'));
                    return FALSE;
                }
            }
        }
    }

    
    
    /*****************Function _get_posted_leave_data**********************************
    * @type            : Function
    * @function name   : _get_posted_leave_data
    * @description     : Prepare "Userleave" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_leave_data() {

        $items = array();
        $items[] = 'type_id';
        $items[] = 'leave_reason';

        $data = elements($items, $_POST);
        
        $data['leave_date'] = date('Y-m-d', strtotime($this->input->post('leave_date')));
        $data['leave_from'] = date('Y-m-d', strtotime($this->input->post('leave_from')));
        $data['leave_to']   = date('Y-m-d', strtotime($this->input->post('leave_to')));
        
        $start = strtotime($data['leave_from']);
        $end   = strtotime($data['leave_to']);
        $days = ceil(abs($end - $start) / 86400);
        $data['leave_day'] = $days+1;
        
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();            
            
        } else {
            
            $data['leave_status'] = 0;
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->leave->get_school_by_id($this->session->userdata('school_id'));            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('userleave/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
            $data['school_id']        = $this->session->userdata('school_id');
           
            if(logged_in_role_id() == GUARDIAN){
                $arr = explode('|', $this->input->post('user_id'));
                $data['role_id']        =  STUDENT;
                $data['user_id']        = $arr[0];
                $data['class_id']        = $arr[1];
            }elseif(logged_in_role_id() == STUDENT){                
                $data['role_id']        = logged_in_role_id();
                $data['user_id']        = logged_in_user_id();
                $data['class_id']        = $this->session->userdata('class_id'); 
            }else{                
                $data['role_id']        = logged_in_role_id();
                $data['user_id']        = logged_in_user_id();
            }     
            
        }
        

        if (isset($_FILES['attachment']['name'])) {
            $data['attachment'] = $this->_upload_attachment();
        }

        return $data;
    }

        
    /*****************Function _upload_attachment**********************************
    * @type            : Function
    * @function name   : _upload_attachment
    * @description     : Process to to upload attachment in the server
    *                    and return image name                   
    *                       
    * @param           : null
    * @return          : $return_image string value 
    * ********************************************************** */
    private function _upload_attachment() {

        $prev_attachment = $this->input->post('prev_attachment');
        $attachment = $_FILES['attachment']['name'];
        $return_attachment = '';
        if ($attachment != "") {

                $destination = 'assets/uploads/leave/';

                $file_type = explode(".", $attachment);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $attachment_path = 'leave-attachment-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['attachment']['tmp_name'], $destination . $attachment_path);
                // need to unlink previous image
                if ($prev_attachment != "") {
                    if (file_exists($destination . $prev_attachment)) {
                        @unlink($destination . $prev_attachment);
                    }
                }

                $return_attachment = $attachment_path;
          
        } else {
            $return_attachment = $prev_attachment;
        }

        return $return_attachment;
    }

     
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Userleave" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('userleave/index');
        }
        
        $leave = $this->leave->get_single_application($id);
        
        if ($this->leave->delete('leave_applications', array('id' => $id))) {
            
             // delete teacher resume and image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/leave/' . $leave->attachment)) {
                @unlink($destination . '/leave/' . $leave->attachment);
            }            
            
            create_log('Has been deleted a leave application');
            success($this->lang->line('delete_success'));            
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('userleave/index/');
    }
 
}
