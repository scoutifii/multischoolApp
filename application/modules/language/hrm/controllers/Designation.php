<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Designation.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Designation
 * @description     : Manage employee designation.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Designation extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Designation_Model', 'designation', true);
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Designation List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $this->data['designations'] = $this->designation->get_designation($school_id); 
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_designation'). ' | ' . SMS);
        $this->layout->view('designation/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Designation" user interface                 
    *                    and process to store "Designation" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_designation_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_designation_data();

                $insert_id = $this->designation->insert('designations', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a Designation : '.$data['name']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('hrm/designation/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('hrm/designation/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['designations'] = $this->designation->get_designation(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('designation/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Designation" user interface                 
    *                    with populate "Designation" value 
    *                    and process to update "Designation" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_designation_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_designation_data();
                $updated = $this->designation->update('designations', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a Designation : '.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('hrm/designation/index/'.$data['school_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('hrm/designation/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['designation'] = $this->designation->get_single('designations', array('id' => $this->input->post('id')));
            }
        } 
        
        if ($id) {
            $this->data['designation'] = $this->designation->get_single('designations', array('id' => $id));

            if (!$this->data['designation']) {
                 redirect('hrm/designation/index');
            }
        }
       

        $this->data['school_id'] = $this->data['designation']->school_id;
        $this->data['filter_school_id'] = $this->data['designation']->school_id;
        $this->data['schools'] = $this->schools;
        $this->data['designations'] = $this->designation->get_designation($this->data['designation']->school_id); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('designation/index', $this->data);
    }

        
    /*****************Function _prepare_designation_validation**********************************
    * @type            : Function
    * @function name   : _prepare_designation_validation
    * @description     : Process "Designation" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_designation_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('designation'), 'trim|required|callback_name');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

                    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "Designation Name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $designation = $this->designation->duplicate_check($this->input->post('school_id'), $this->input->post('name'));
            if ($designation) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $designation = $this->designation->duplicate_check($this->input->post('school_id'), $this->input->post('name'), $this->input->post('id'));
            if ($designation) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    /*****************Function _get_posted_designation_data**********************************
    * @type            : Function
    * @function name   : _get_posted_designation_data
    * @description     : Prepare "Designation" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_designation_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $data = elements($items, $_POST);        
        $data['note'] = $this->input->post('note');
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
        }

        return $data;
    }

    
        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Designation" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('hrm/designation/index');        
        }
        
        $designation = $this->designation->get_single('designations', array('id' => $id));
        
        if ($this->designation->delete('designations', array('id' => $id))) { 
            
            create_log('Has been deleted a Designation : '.$designation->name);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('hrm/designation/index/'.$designation->school_id);
    }

}
