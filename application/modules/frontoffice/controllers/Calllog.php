<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Calllog.php**********************************
 * @product name    : Global Multi School Management System Express
 * @Calllog            : Class
 * @class name      : Calllog
 * @description     : Manage phonr call log.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Calllog extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Calllog_Model', 'calllog', true);        
    }

    
    /*****************Function index**********************************
    * @Calllog            : Function
    * @function name   : index
    * @description     : Load "Call log List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);        
        $this->data['calllogs'] = $this->calllog->get_calllog($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_call_log').' | ' . SMS);
        $this->layout->view('calllog/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Calllog            : Function
    * @function name   : add
    * @description     : Load "Add new phone Calllog" user interface                 
    *                    and process to store "phonr Calllog" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_calllog_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_calllog_data();

                $insert_id = $this->calllog->insert('phone_call_logs', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('frontoffice/calllog/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontoffice/calllog/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['calllogs'] = $this->calllog->get_calllog(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('calllog/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Calllog            : Function
    * @function name   : edit
    * @description     : Load Update "phone Calllog" user interface                 
    *                    with populate "phone Calllog" value 
    *                    and process to update "phone Calllog" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_calllog_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_calllog_data();
                $updated = $this->calllog->update('phone_call_logs', $data, array('id' => $this->input->post('id')));

                if ($updated) {                   
                    
                    success($this->lang->line('update_success'));
                    redirect('frontoffice/calllog/index/'.$data['school_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontoffice/calllog/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['calllog'] = $this->calllog->get_single('phone_call_logs', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['calllog'] = $this->calllog->get_single('phone_call_logs', array('id' => $id));

                if (!$this->data['calllog']) {
                     redirect('frontoffice/calllog/index');
                }
            }
        }

        $this->data['school_id'] = $this->data['calllog']->school_id;
        $this->data['filter_school_id'] = $this->data['calllog']->school_id;;
        $this->data['schools'] = $this->schools;
        $this->data['calllogs'] = $this->calllog->get_calllog($this->data['school_id']); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('calllog/index', $this->data);
    }

                
           
     /*****************Function get_single_calllog**********************************
     * @type            : Function
     * @function name   : get_single_calllog
     * @description     : "Load single calllog information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_calllog(){
        
       $calllog_id = $this->input->post('calllog_id');
       
       $this->data['calllog'] = $this->calllog->get_single_calllog($calllog_id);
       echo $this->load->view('calllog/get-single-calllog', $this->data);
    }
    
        
    /*****************Function _prepare_calllog_validation**********************************
    * @Calllog            : Function
    * @function name   : _prepare_calllog_validation
    * @description     : Process "phone Calllog" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_calllog_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('call_type', $this->lang->line('call_type'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('call_duration', $this->lang->line('call_duration'), 'trim');
        $this->form_validation->set_rules('call_date', $this->lang->line('call_date'), 'trim|required');
        $this->form_validation->set_rules('next_follow_up', $this->lang->line('follow_up'), 'trim');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function _get_posted_calllog_data**********************************
    * @Calllog            : Function
    * @function name   : _get_posted_calllog_data
    * @description     : Prepare "Calllog" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_calllog_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'call_type';
        $items[] = 'name';
        $items[] = 'phone';
        $items[] = 'call_duration';
        $items[] = 'note';
        $data = elements($items, $_POST);        
        
        $data['call_date'] = date('Y-m-d', strtotime($this->input->post('call_date')));
        $data['next_follow_up'] = date('Y-m-d', strtotime($this->input->post('next_follow_up')));
        
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
    * @Calllog            : Function
    * @function name   : delete
    * @description     : delete "phone Calllog" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('frontoffice/calllog/index');        
        }
        
        $calllog = $this->calllog->get_single('phone_call_logs', array('id' => $id));        
        if ($this->calllog->delete('phone_call_logs', array('id' => $id))) { 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontoffice/calllog/index/'.$calllog->school_id);
    }
}
