<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Smstemplate extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Smstemplate_Model', 'template', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Email Template List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $this->data['roles'] = $this->template->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['templates'] = $this->template->get_template_list($school_id);
        
        $this->data['schools'] = $this->schools;
        $this->data['filter_school_id'] = $school_id;
        $this->data['list'] = TRUE;
        
        $this->layout->title($this->lang->line('manage_sms_template'). ' | ' . SMS);
        $this->layout->view('sms_template/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new SMS template" user interface                 
    *                    and store "SMS template" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_template_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_template_data();

                $insert_id = $this->template->insert('sms_templates', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a sms Template : '.$data['title']);   
                    
                    success($this->lang->line('insert_success'));
                    redirect('administrator/smstemplate/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/smstemplate/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['roles'] = $this->template->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['templates'] = $this->template->get_template_list();
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('sms_template/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "SMS template" user interface                 
    *                    with populated "SMS template" value 
    *                    and update "Email template" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_template_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_template_data();
                $updated = $this->template->update('sms_templates', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a sms Template : '.$data['title']);
                    
                    success($this->lang->line('update_success'));
                    redirect('administrator/smstemplate/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/smstemplate/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['template'] = $this->template->get_single('sms_templates', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['template'] = $this->template->get_single('sms_templates', array('id' => $id));
 
                if (!$this->data['template']) {
                     redirect('administrator/smstemplate/index');
                }
            }
        }

        $this->data['roles'] = $this->template->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['templates'] = $this->template->get_template_list();
        $this->data['school_id'] = $this->data['template']->school_id;
         
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('sms_template/index', $this->data);
    }

    
    /*****************Function _prepare_template_validation**********************************
    * @type            : Function
    * @function name   : _prepare_template_validation
    * @description     : Process "Email template" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_template_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('title',  $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('role_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('template', $this->lang->line('template'), 'trim|required');
    }

            
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "SMS template title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function title() {
        if ($this->input->post('id') == '') {
            $template = $this->template->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('role_id'));
            if ($template) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $template = $this->template->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('role_id'), $this->input->post('id'));
            if ($template) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    /*****************Function _get_posted_template_data**********************************
     * @type            : Function
     * @function name   : _get_posted_template_data
     * @description     : Prepare "SMS template" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_template_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'role_id';
        $items[] = 'template';
        $data = elements($items, $_POST); 
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }

    
    
    /*****************Function delete**********************************
   * @type            : Function
   * @function name   : delete
   * @description     : delete "SMS template" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {
                
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/smstemplate');              
        }
        
       $template = $this->template->get_single('sms_templates', array('id' => $id));
        
        if ($this->template->delete('sms_templates', array('id' => $id))) { 
            
            create_log('Has been deleted a sms Template : '.$template->title);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('administrator/smstemplate/index');
    }

}
