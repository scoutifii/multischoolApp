<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Decline.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Decline
 * @description     : Manage Decline.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Decline extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Application_Model', 'decline', true);        
    }

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Decline Leave List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ***********************************************************/
    public function index($school_id = null) {

        check_permission(VIEW);
                         
        $this->data['applications'] = $this->decline->get_application_list($school_id, $decline = 3);          
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_decline_application') .' | ' . SMS);
        $this->layout->view('decline/index', $this->data);        
    }

    
    /*****************Function update**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Leave" user interface                 
    *                    with populated "Leave" value 
    *                    and process to update "Leave" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function update($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('leave/decline/index');
        }
       
        if ($_POST) {
            $this->_prepare_decline_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_decline_data();
                $updated = $this->decline->update('leave_applications', $data, array('id' => $this->input->post('id')));

                if ($updated) {                    
                    create_log('Has been updated a decline leave');                    
                    success($this->lang->line('update_success'));
                    redirect('leave/decline/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('leave/decline/update/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['application'] = $this->decline->get_single_application( $this->input->post('id'));
            }
        }

        if ($id) {
            
            $this->data['application'] = $this->decline->get_single_application($id);
            if (!$this->data['application']) {
                redirect('leave/decline/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['classes'] = $this->decline->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['applications'] = $this->decline->get_application_list( $this->data['application']->school_id);      
        $this->data['roles'] = $this->decline->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['application']->school_id;  
        $this->data['filter_school_id'] = $this->data['application']->school_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('update') . ' | ' . SMS);
        $this->layout->view('decline/index', $this->data);
    }

       
           
    /*****************Function get_single_application**********************************
     * @type            : Function
     * @function name   : get_single_application
     * @description     : "Load single application information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_application(){
        
       $application_id = $this->input->post('application_id');
       
       $this->data['application'] = $this->decline->get_single_application($application_id);
       $this->data['school'] = $this->decline->get_school_by_id($this->data['application']->school_id);
       echo $this->load->view('get-single-application', $this->data);
    }


        /*****************Function _prepare_application_validation**********************************
    * @type            : Function
    * @function name   : _prepare_application_validation
    * @description     : Process "application" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_decline_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('leave_note', $this->lang->line('decline').' '.$this->lang->line('decline'), 'trim|required');
    }
    
    
    /*****************Function _get_posted_leave_data**********************************
    * @type            : Function
    * @function name   : _get_posted_leave_data
    * @description     : Prepare "Leave" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_decline_data() {

        $items = array();     
        $items[] = 'leave_note';   
        
        $data = elements($items, $_POST);
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id(); 
        $data['leave_status'] = 3;           
   

        return $data;
    }


    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Leave" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('leave/decline/index');
        }
        
        $application = $this->decline->get_single_application($id);
        
        if ($this->decline->delete('leave_applications', array('id' => $id))) {
            
             // delete teacher resume and image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/leave/' . $application->attachment)) {
                @unlink($destination . '/leave/' . $application->attachment);
            }            
            
            create_log('Has been deleted a decline application');
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
         redirect('leave/decline/index/'.$application->school_id);
    }
    

        /*****************Function waiting**********************************
     * @type            : Function
     * @function name   : waiting
     * @description     : "update leave status" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function waiting($application_id){
        if(!is_numeric($application_id)){
            error($this->lang->line('unexpected_error'));
            redirect('leave/decline/index');     
        }
        
        $leave = $this->decline->get_single('leave_applications', array('id'=>$application_id));               
        $status = $this->decline->update('leave_applications', array('leave_status'=>1, 'modified_at'=>date('Y-m-d H:i:s') ), array('id'=>$application_id));               
        
        if($status){
            success($this->lang->line('update_success'));
            redirect('leave/decline/index/'.$leave->school_id);  
        }else{
            error($this->lang->line('update_failed'));
            redirect('leave/decline/index/'.$leave->school_id);      
        }
    }
    
}
