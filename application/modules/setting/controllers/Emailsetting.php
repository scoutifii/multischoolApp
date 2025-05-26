<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************EmailSetting.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Setting
 * @description     : Manage application email settings.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Emailsetting extends MY_Controller {

    public $data = array();

    function __construct() {
        
        parent::__construct();
        $this->load->model('Setting_Model', 'setting', true);  
        if($this->session->userdata('role_id') == SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
         
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['email_setting'] = $this->setting->get_single('email_settings', $condition);
        }        
        $this->data['years'] = $this->setting->get_list('academic_years', array('status' => 1), '', '', '', 'id', 'ASC');
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "email Setting" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);        
               
        
        $this->layout->title($this->lang->line('email_setting') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "email Settings" user interface                 
    *                    and process to store "email Settings" into database
    *                    for the first time settings 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();

                $insert_id = $this->setting->insert('email_settings', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('setting/emailsetting');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('setting/emailsetting/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }
       
        $this->layout->title($this->lang->line('email_setting') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);
    }

    
        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Email Settings" user interface                 
    *                    with populate "Email Settings" value 
    *                    and process to update "General Settings" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();               
                $updated = $this->setting->update('email_settings', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('setting/emailsetting');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('setting/emailsetting/edit/' . $this->input->post('id'));
                }
            }else{
                error($this->lang->line('update_failed'));
            }
        }
        
        $this->layout->title($this->lang->line('email_setting') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);
    }

        
    /*****************Function _prepare_setting_validation**********************************
    * @type            : Function
    * @function name   : _prepare_setting_validation
    * @description     : Process "email Settings" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_setting_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('mail_protocol', $this->lang->line('email') . ' ' . $this->lang->line('protocol'), 'trim|required');
        
        if($this->input->post('mail_protocol') == 'smtp'){
            $this->form_validation->set_rules('smtp_host', $this->lang->line('smtp_host'), 'trim|required');
            $this->form_validation->set_rules('smtp_port', $this->lang->line('smtp_port'), 'trim|required');
            $this->form_validation->set_rules('smtp_user', $this->lang->line('smtp_username'), 'trim|required');
            $this->form_validation->set_rules('smtp_pass', $this->lang->line('smtp_password'), 'trim|required');        
        }
        
        $this->form_validation->set_rules('smtp_timeout', $this->lang->line('smtp_timeout'), 'trim');
        $this->form_validation->set_rules('smtp_crypto', $this->lang->line('smtp_security'), 'trim');
        $this->form_validation->set_rules('mail_type', $this->lang->line('email_type'), 'trim');
        $this->form_validation->set_rules('char_set', $this->lang->line('char_set'), 'trim');
        $this->form_validation->set_rules('priority', $this->lang->line('priority'), 'trim');        
        $this->form_validation->set_rules('from_name', $this->lang->line('from_name'), 'trim');
        $this->form_validation->set_rules('from_address', $this->lang->line('from_email'), 'trim');
        
    }

     
    

    /*****************Function _get_posted_setting_data**********************************
    * @type            : Function
    * @function name   : _get_posted_setting_data
    * @description     : Prepare "Email Settings" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_setting_data() {

        $items = array();
         
        $items[] = 'mail_protocol';
        $items[] = 'smtp_host';
        $items[] = 'smtp_port';
        $items[] = 'smtp_timeout';
        $items[] = 'smtp_user';
        $items[] = 'smtp_pass'; 
        $items[] = 'smtp_crypto';
        $items[] = 'mail_type';
        $items[] = 'char_set';
        $items[] = 'priority'; 
        $items[] = 'from_name';
        $items[] = 'from_address';
        
        $data = elements($items, $_POST);

        if($data['mail_protocol'] != 'smtp'){
            $data['smtp_host'] = '';
            $data['smtp_port'] = '';
            $data['smtp_timeout'] = '';
            $data['smtp_user'] = '';
            $data['smtp_pass'] = '';
            $data['smtp_crypto'] = '';
        }

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }
        
        return $data;
    }
}
