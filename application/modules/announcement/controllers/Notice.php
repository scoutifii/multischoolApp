<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Notice.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Notice
 * @description     : Manage school academic notice for student, guardian, teacer and employee.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Notice extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Notice_Model', 'notice', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Notice List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);
        
        $this->data['notices'] = $this->notice->get_notice_list($school_id);
        $this->data['roles'] = $this->notice->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_notice') . ' | ' . SMS);
        $this->layout->view('notice/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Notice" user interface                 
    *                    and process to store "Notice" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_notice_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_notice_data();

                $insert_id = $this->notice->insert('notices', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a notice : '.$data['title']);
                    success($this->lang->line('insert_success'));
                    redirect('announcement/notice/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('announcement/notice/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['notices'] = $this->notice->get_notice_list();
        $this->data['roles'] = $this->notice->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('notice/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Notice" user interface                 
    *                    with populated "Notice" value 
    *                    and process update "Notice" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('announcement/notice/index');
        }
        
        if ($_POST) {
            $this->_prepare_notice_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_notice_data();
                $updated = $this->notice->update('notices', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a notice : '.$data['title']);  
                    
                    success($this->lang->line('update_success'));
                    redirect('announcement/notice/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('announcement/notice/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['notice'] = $this->notice->get_single('notices', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['notice'] = $this->notice->get_single('notices', array('id' => $id));

            if (!$this->data['notice']) {
                redirect('announcement/notice/index');
            }
        }

        $this->data['notices'] = $this->notice->get_notice_list();
        $this->data['roles'] = $this->notice->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['school_id'] = $this->data['notice']->school_id;
        $this->data['filter_school_id'] = $this->data['notice']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('notice/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific notice data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);

         if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('announcement/notice/index');
        }
        
        $this->data['notices'] = $this->notice->get_notice_list();
        $this->data['roles'] = $this->notice->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['notice'] = $this->notice->get_single_notice($id);
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('notice') . ' | ' . SMS);
        $this->layout->view('notice/index', $this->data);
    }

    
        
           
     /*****************Function get_single_notice**********************************
     * @type            : Function
     * @function name   : get_single_notice
     * @description     : "Load single notice information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_notice(){
        
       $notice_id = $this->input->post('notice_id');
       
       $this->data['notice'] = $this->notice->get_single_notice($notice_id);
       echo $this->load->view('notice/get-single-notice', $this->data);
    }

        
    /*****************Function _prepare_notice_validation**********************************
    * @type            : Function
    * @function name   : _prepare_notice_validation
    * @description     : Process "Notice" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_notice_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('notice_for'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('notice') . ' ' . $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');
        $this->form_validation->set_rules('notice', $this->lang->line('notice'), 'trim|required');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "Notice title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function title() {
        if ($this->input->post('id') == '') {
            $notice = $this->notice->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('date'));
            if ($notice) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $notice = $this->notice->duplicate_check($this->input->post('school_id'),$this->input->post('title'), $this->input->post('date'), $this->input->post('id'));
            if ($notice) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_notice_data**********************************
    * @type            : Function
    * @function name   : _get_posted_notice_data
    * @description     : Prepare "Notice" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_notice_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'title';
        $items[] = 'notice';
        $items[] = 'is_view_on_web';
        
        $data = elements($items, $_POST);

        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));

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
    * @description     : delete "Notice" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('announcement/notice/index');
        }
        
        $notice = $this->notice->get_single('notices', array('id' => $id));
        
        if ($this->notice->delete('notices', array('id' => $id))) {
            
            create_log('Has been deleted a notice : '.$notice->title);
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('announcement/notice/index/'.$notice->school_id);
    }

}
