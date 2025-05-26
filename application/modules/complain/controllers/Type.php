<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Type.php**********************************
 * @product name    : Global Multi School Management System Express
 * @Type            : Class
 * @class name      : Type
 * @description     : Manage complain type.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Type extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Type_Model', 'type', true);        
    }

    
    /*****************Function index**********************************
    * @Type            : Function
    * @function name   : index
    * @description     : Load "Type List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);        
        $this->data['types'] = $this->type->get_type($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_complain_type').' | ' . SMS);
        $this->layout->view('type/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Type            : Function
    * @function name   : add
    * @description     : Load "Add new complain Type" user interface                 
    *                    and process to store "complain Type" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_type_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_type_data();

                $insert_id = $this->type->insert('complain_types', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a complain Type : '.$data['type']);                    
                    success($this->lang->line('insert_success'));
                    redirect('complain/type/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('complain/type/add');
                }
            } else {
                success($this->lang->line('insert_success'));
                $this->data = $_POST;
            }
        }

        $this->data['types'] = $this->type->get_type(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('type/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Type            : Function
    * @function name   : edit
    * @description     : Load Update "complain Type" user interface                 
    *                    with populate "complain Type" value 
    *                    and process to update "complain Type" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_type_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_type_data();
                $updated = $this->type->update('complain_types', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a complain Type : '.$data['type']);                    
                    success($this->lang->line('update_success'));
                    redirect('complain/type/index/'.$data['school_id']); 
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('complain/type/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['type'] = $this->type->get_single('complain_types', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['type'] = $this->type->get_single('complain_types', array('id' => $id));

                if (!$this->data['type']) {
                     redirect('complain/type/index');
                }
            }
        }

        $this->data['types'] = $this->type->get_type($this->data['type']->school_id); 
        $this->data['school_id'] = $this->data['type']->school_id;
        $this->data['filter_school_id'] = $this->data['type']->school_id;;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('type/index', $this->data);
    }

        
    /*****************Function _prepare_type_validation**********************************
    * @Type            : Function
    * @function name   : _prepare_type_validation
    * @description     : Process "complain Type" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_type_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('type', $this->lang->line('complain_type'), 'trim|required|callback_type');
    }

                    
    /*****************Function type**********************************
    * @Type            : Function
    * @function name   : type
    * @description     : Unique check for "complain Type " data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function type() {
        if ($this->input->post('id') == '') {
            $type = $this->type->duplicate_check($this->input->post('school_id'), $this->input->post('type'));
            if ($type) {
                $this->form_validation->set_message('type', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $type = $this->type->duplicate_check($this->input->post('school_id'), $this->input->post('type'), $this->input->post('id'));
            if ($type) {
                $this->form_validation->set_message('type', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    /*****************Function _get_posted_type_data**********************************
    * @Type            : Function
    * @function name   : _get_posted_type_data
    * @description     : Prepare "Type" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_type_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'type';
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
    * @Type            : Function
    * @function name   : delete
    * @description     : delete "complain Type" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('complain/type/index');        
        }
        
        $type = $this->type->get_single('complain_types', array('id' => $id));        
        if ($this->type->delete('complain_types', array('id' => $id))) { 
            
            create_log('Has been deleted a complain Type : '.$type->type);
            success($this->lang->line('delete_success'));
            redirect('complain/type/index/'.$type->school_id);
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('complain/type/index');
    }
}
