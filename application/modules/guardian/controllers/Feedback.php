<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Feedback.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Feedback
 * @description     : Manage school Guardian Feedback.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Feedback extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Feedback_Model', 'feedback', true);  
         $this->data['feedbacks'] = $this->feedback->get_feedback_list();
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Notice List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);        
               
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_feedback') . ' | ' . SMS);
        $this->layout->view('feedback/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new feedback" user interface                 
    *                    and process to store "feedback" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if(empty($this->data['feedbacks'])){
            
            if ($_POST) {
                $this->_prepare_feedback_validation();
                if ($this->form_validation->run() === TRUE) {
                    $data = $this->_get_posted_feedback_data();

                    $insert_id = $this->feedback->insert('guardian_feedbacks', $data);
                    if ($insert_id) {
                        
                         create_log('Has been added feedback');
                        success($this->lang->line('insert_success'));
                        redirect('guardian/feedback/index');
                    } else {
                        error($this->lang->line('insert_failed'));
                        redirect('guardian/feedback/add');
                    }
                } else {
                    error($this->lang->line('insert_failed'));
                    $this->data['post'] = $_POST;
                }
            }


            $this->data['add'] = TRUE;
            $this->layout->title($this->lang->line('add') . ' | ' . SMS);
            $this->layout->view('feedback/index', $this->data);
        }else{
             redirect('guardian/feedback/index');
        }
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "feedback" user interface                 
    *                    with populated "feedback" value 
    *                    and process update "feedback" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('guardian/feedback/index');
        }
        
        if ($_POST) {
            $this->_prepare_feedback_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_feedback_data();
                $updated = $this->feedback->update('guardian_feedbacks', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated feedback');
                    
                    success($this->lang->line('update_success'));
                    redirect('guardian/feedback/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('guardian/feedback/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['feedback'] = $this->feedback->get_single('guardian_feedbacks', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['feedback'] = $this->feedback->get_single('guardian_feedbacks', array('id' => $id));

            if (!$this->data['feedback']) {
                redirect('guardian/feedback/index');
            }
        }

        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('feedback/index', $this->data);
    }
        
           
     /*****************Function get_single_feedback**********************************
     * @type            : Function
     * @function name   : get_single_feedback
     * @description     : "Load single feedback information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_feedback(){
        
       $feedback_id = $this->input->post('feedback_id');
       
       $this->data['feedback'] = $this->feedback->get_single_feedback($feedback_id);
       echo $this->load->view('feedback/get-single-feedback', $this->data);
    }

        
    /*****************Function _prepare_feedback_validation**********************************
    * @type            : Function
    * @function name   : _prepare_feedback_validation
    * @description     : Process "Notice" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_feedback_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim');
        $this->form_validation->set_rules('feedback', $this->lang->line('feedback'), 'trim|required');
    }
    
    /*****************Function _get_posted_feedback_data**********************************
    * @type            : Function
    * @function name   : _get_posted_feedback_data
    * @description     : Prepare "Notice" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_feedback_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'feedback';
        $data = elements($items, $_POST);


        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['guardian_id'] = $this->session->userdata('profile_id');
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "feedback" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('guardian/feedback/index');
        }
        
        if ($this->feedback->delete('guardian_feedbacks', array('id' => $id))) {
            
            create_log('Has been deleted feedback');
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('guardian/feedback/index');
    }
}