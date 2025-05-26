<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Approve extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Application_Model', 'approve', true);        
    }

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Approve Leave List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ***********************************************************/
    public function index($school_id = null) {

        check_permission(VIEW);
                         
        $this->data['applications'] = $this->approve->get_application_list($school_id, $approve = 2);          
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_approved_application') .' | ' . SMS);
        $this->layout->view('approve/index', $this->data);        
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
            redirect('leave/approve/index');
        }
       
        if ($_POST) {
            $this->_prepare_approve_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_approve_data();
                $updated = $this->approve->update('leave_applications', $data, array('id' => $this->input->post('id')));

                if ($updated) {                    
                    create_log('Has been updated a approve leave');                    
                    success($this->lang->line('update_success'));
                    redirect('leave/approve/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('leave/approve/update/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['application'] = $this->approve->get_single_application( $this->input->post('id'));
            }
        }

        if ($id) {
            
            $this->data['application'] = $this->approve->get_single_application($id);
            if (!$this->data['application']) {
                redirect('leave/approve/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['classes'] = $this->approve->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['applications'] = $this->approve->get_application_list( $this->data['application']->school_id);      
        $this->data['roles'] = $this->approve->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['application']->school_id;  
        $this->data['filter_school_id'] = $this->data['application']->school_id;
        $this->data['schools'] = $this->schools; 
        
        //print_r($this->data['application']);
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('update') . ' | ' . SMS);
        $this->layout->view('approve/index', $this->data);
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
       
       $this->data['application'] = $this->approve->get_single_application($application_id);
       $this->data['school'] = $this->approve->get_school_by_id($this->data['application']->school_id);
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
    private function _prepare_approve_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('leave_from', $this->lang->line('leave_from'), 'trim|required');
        $this->form_validation->set_rules('leave_to', $this->lang->line('leave_to'), 'trim|required|callback_leave_to');
        $this->form_validation->set_rules('leave_note', $this->lang->line('note'), 'trim|required');
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
    
    /*****************Function _get_posted_leave_data**********************************
    * @type            : Function
    * @function name   : _get_posted_leave_data
    * @description     : Prepare "Leave" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_approve_data() {

        $items = array();     
        $items[] = 'leave_note';   
        
        $data = elements($items, $_POST);
        
        $data['leave_date'] = date('Y-m-d', strtotime($this->input->post('leave_date')));
        $data['leave_from'] = date('Y-m-d', strtotime($this->input->post('leave_from')));
        $data['leave_to']   = date('Y-m-d', strtotime($this->input->post('leave_to')));
        
        $start = strtotime($data['leave_from']);
        $end   = strtotime($data['leave_to']);
        $days = ceil(abs($end - $start) / 86400);
        $data['leave_day'] = $days+1;
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id(); 
        $data['leave_status'] = 2;           
   
        $school_id = $this->input->post('school_id');
        $role_id = $this->input->post('role_id');
        $leave_type_id = $this->input->post('type_id');
        $user_id = $this->input->post('user_id');
        $user_id = $this->input->post('user_id');
        $school = $this->approve->get_school_by_id($school_id);
        $used = get_total_used_leave($school->academic_year_id, $role_id, $leave_type_id, $user_id);
        $leave_type = $this->approve->get_single('leave_types', array('id'=>$leave_type_id, 'role_id'=>$role_id, 'school_id'=>$school_id));  
        
        $total_need_leave = $used + $data['leave_day'];
        if( $leave_type->total_leave < $total_need_leave ){
            error($this->lang->line('you_have_remain_leave').' : '. ($leave_type->total_leave - $used));
            redirect('leave/approve/update/' . $this->input->post('id'));
        }else{
            return $data;
        }
        
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
             redirect('leave/approve/index');
        }
        
        $application = $this->approve->get_single_application($id);
        
        if ($this->approve->delete('leave_applications', array('id' => $id))) {
            
             // delete teacher resume and image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/leave/' . $application->attachment)) {
                @unlink($destination . '/leave/' . $application->attachment);
            }            
            
            create_log('Has been deleted a approve application');
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
         redirect('leave/approve/index/'.$application->school_id);
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
            redirect('leave/approve/index');     
        }
        
        $leave = $this->approve->get_single('leave_applications', array('id'=>$application_id));               
        $status = $this->approve->update('leave_applications', array('leave_status'=>1, 'modified_at'=>date('Y-m-d H:i:s') ), array('id'=>$application_id));               
        
        if($status){
            success($this->lang->line('update_success'));
            redirect('leave/approve/index/'.$leave->school_id);  
        }else{
            error($this->lang->line('update_failed'));
            redirect('leave/approve/index/'.$leave->school_id);      
        }
    }
    
}
