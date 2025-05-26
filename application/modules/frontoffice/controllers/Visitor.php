<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Visitor.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Visitor
 * @description     : Manage visitor information/logs.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Visitor extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Visitor_Model', 'visitor', true);        
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Visitor List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['visitors'] = $this->visitor->get_visitor_list($school_id);
        $this->data['roles'] = $this->visitor->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['purposes'] = $this->visitor->get_list('visitor_purposes', array('status' => 1), '', '', '', 'id', 'ASC');
            $this->data['classes'] = $this->visitor->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }  
        
        //$this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_visitor') . ' | ' . SMS);
        $this->layout->view('visitor/index', $this->data);
    }

    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Visitor Info" user interface                 
    *                    and process to store "Visitor Info" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_visitor_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_visitor_data();

                $insert_id = $this->visitor->insert('visitors', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('frontoffice/visitor/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontoffice/visitor/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['visitors'] = $this->visitor->get_visitor_list();
        $this->data['roles'] = $this->visitor->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['purposes'] = $this->visitor->get_list('visitor_purposes', array('status' => 1), '', '', '', 'id', 'ASC');
            $this->data['classes'] = $this->visitor->get_list('classes', array('status' => 1), '', '', '', 'id', 'ASC');
        }  
        
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('visitor/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Visitor Info" user interface                 
    *                    with populate "Visitor Info" value 
    *                    and process to update "Visitor Info" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_visitor_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_visitor_data();
                $updated = $this->visitor->update('visitors', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('frontoffice/visitor/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontoffice/visitor/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['visitor'] = $this->visitor->get_single('visitors', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['visitor'] = $this->visitor->get_single('visitors', array('id' => $id));

            if (!$this->data['visitor']) {
                redirect('frontoffice/visitor/index');
            }
        }
        
        $this->data['visitors'] = $this->visitor->get_visitor_list();
        $this->data['roles'] = $this->visitor->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['visitor']->school_id;
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['purposes'] = $this->visitor->get_list('visitor_purposes', array('status' => 1), '', '', '', 'id', 'ASC');
            $this->data['classes'] = $this->visitor->get_list('classes', array('status' => 1), '', '', '', 'id', 'ASC');
        }  
        
        $this->data['schools'] = $this->schools; 

        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('visitor/index', $this->data);
    }

        
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Visitor Info data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);

        $this->data['visitor'] = $this->visitor->get_single_visitor($id);
        
        $this->data['visitors'] = $this->visitor->get_visitor_list();
        $this->data['roles'] = $this->visitor->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('visitor_info') . ' | ' . SMS);
        $this->layout->view('visitor/index', $this->data);
    }
    
            
           
     /*****************Function get_single_visitor**********************************
     * @type            : Function
     * @function name   : get_single_visitor
     * @description     : "Load single visitor information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_visitor(){
        
       $visitor_id = $this->input->post('visitor_id');
       
       $this->data['visitor'] = $this->visitor->get_single_visitor($visitor_id);
       echo $this->load->view('visitor/get-single-visitor', $this->data);
    }

    
    
    /*****************Function _prepare_visitor_validation**********************************
    * @type            : Function
    * @function name   : _prepare_visitor_validation
    * @description     : Process "Visitor Info" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_visitor_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_school'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('user_type'), 'trim|required');
        
        if($this->input->post('role_id') == STUDENT){
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        
        $this->form_validation->set_rules('purpose_id', $this->lang->line('visitor_purpose'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('user_id', $this->lang->line('to_meet'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

       
   
    /*****************Function _get_posted_visitor_data**********************************
    * @type            : Function
    * @function name   : _get_posted_visitor_data
    * @description     : Prepare "Visitor Info" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_visitor_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'purpose_id';
        $items[] = 'user_id';
        $items[] = 'name';
        $items[] = 'phone';
        $items[] = 'note';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            
            $school = $this->visitor->get_school_by_id($data['school_id']);
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['check_in'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Visitor Info" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $visitor = $this->visitor->get_single('visitors', array('id' => $id));  
        if ($this->visitor->delete('visitors', array('id' => $id))) {

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontoffice/visitor/index/'.$visitor->school_id);
    }

        
    
    /*****************Function visitor_check_out**********************************
    * @type            : Function
    * @function name   : visitor_check_out
    * @description     : Process to ceckout a visitor                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function visitor_check_out() {
        $visitor_id = $this->input->post('visitor_id');

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        $data['check_out'] = date('Y-m-d H:i:s');

        if($this->visitor->update('visitors', $data, array('id' => $visitor_id))){
            echo TRUE;
        }else{
            echo FALSE;  
        }
    }

}
