<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Purpose.php**********************************
 * @product name    : Global Multi School Management System Express
 * @Purpose            : Class
 * @class name      : Purpose
 * @description     : Manage visitor purpose.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Purpose extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Purpose_Model', 'purpose', true);        
    }

    
    /*****************Function index**********************************
    * @Purpose            : Function
    * @function name   : index
    * @description     : Load "Purpose List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);        
        $this->data['purposes'] = $this->purpose->get_purpose($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_visitor_purpose').' | ' . SMS);
        $this->layout->view('purpose/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Purpose            : Function
    * @function name   : add
    * @description     : Load "Add new visitor Purpose" user interface                 
    *                    and process to store "visitor Purpose" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_purpose_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_purpose_data();

                $insert_id = $this->purpose->insert('visitor_purposes', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a visitor Purpose : '.$data['purpose']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('frontoffice/purpose/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontoffice/purpose/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['purposes'] = $this->purpose->get_purpose(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('purpose/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Purpose            : Function
    * @function name   : edit
    * @description     : Load Update "visitor Purpose" user interface                 
    *                    with populate "visitor Purpose" value 
    *                    and process to update "visitor Purpose" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_purpose_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_purpose_data();
                $updated = $this->purpose->update('visitor_purposes', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a visitor Purpose : '.$data['purpose']);
                    
                    success($this->lang->line('update_success'));
                    redirect('frontoffice/purpose/index/'.$data['school_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontoffice/purpose/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['purpose'] = $this->purpose->get_single('visitor_purposes', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['purpose'] = $this->purpose->get_single('visitor_purposes', array('id' => $id));

                if (!$this->data['purpose']) {
                     redirect('frontoffice/purpose/index');
                }
            }
        }

        $this->data['school_id'] = $this->data['purpose']->school_id;
        $this->data['filter_school_id'] = $this->data['purpose']->school_id;;
        $this->data['schools'] = $this->schools;
        $this->data['purposes'] = $this->purpose->get_purpose($this->data['school_id']); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('purpose/index', $this->data);
    }

        
    /*****************Function _prepare_purpose_validation**********************************
    * @Purpose            : Function
    * @function name   : _prepare_purpose_validation
    * @description     : Process "visitor Purpose" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_purpose_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_school'), 'trim|required');
        $this->form_validation->set_rules('purpose', $this->lang->line('visitor_purpose'), 'trim|required|callback_purpose');
    }

                    
    /*****************Function purpose**********************************
    * @Purpose            : Function
    * @function name   : purpose
    * @description     : Unique check for "visitor Purpose " data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function purpose() {
        if ($this->input->post('id') == '') {
            $purpose = $this->purpose->duplicate_check($this->input->post('school_id'), $this->input->post('purpose'));
            if ($purpose) {
                $this->form_validation->set_message('purpose', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $purpose = $this->purpose->duplicate_check($this->input->post('school_id'), $this->input->post('purpose'), $this->input->post('id'));
            if ($purpose) {
                $this->form_validation->set_message('purpose', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    /*****************Function _get_posted_purpose_data**********************************
    * @Purpose            : Function
    * @function name   : _get_posted_purpose_data
    * @description     : Prepare "Purpose" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_purpose_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'purpose';
        $data = elements($items, $_POST);        
        
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
    * @Purpose            : Function
    * @function name   : delete
    * @description     : delete "visitor Purpose" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('frontoffice/purpose/index');        
        }
        
        $purpose = $this->purpose->get_single('visitor_purposes', array('id' => $id));        
        if ($this->purpose->delete('visitor_purposes', array('id' => $id))) { 
            
            create_log('Has been deleted a visitor Purpose : '.$purpose->purpose);
            success($this->lang->line('delete_success'));
            redirect('frontoffice/purpose/index/'.$purpose->school_id);
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontoffice/purpose/index');
    }
}
