<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Emailsetting extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Emailsetting_Model', 'emailsetting', true);

        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "School Email Setting Listing" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['email_settings'] = $this->emailsetting->get_email_setting_list();
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_email_setting') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Email Setting" user interface                 
    *                    and store "Sms Setting" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_email_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_email_setting_data();

                $insert_id = $this->emailsetting->insert('email_settings', $data);
                if ($insert_id) {
                    
                    $school = $this->emailsetting->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been created email setting for : '.$school->school_name); 
                    
                    success($this->lang->line('insert_success'));
                    redirect('administrator/emailsetting');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/emailsetting/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['email_settings'] = $this->emailsetting->get_email_setting_list();
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Email Setting" user interface                 
    *                    with populated "Email Setting" value 
    *                    and update "Email Setting" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_email_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_email_setting_data();
                $updated = $this->emailsetting->update('email_settings', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $school = $this->emailsetting->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been updated email setting for : '.$school->school_name); 
                    
                    success($this->lang->line('update_success'));
                    redirect('administrator/emailsetting');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/emailsetting/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['email_setting'] = $this->emailsetting->get_single('email_settings', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['email_setting'] = $this->emailsetting->get_single('email_settings', array('id' => $id));
 
                if (!$this->data['email_setting']) {
                     redirect('administrator/emailsetting');
                }
            }
        }

        $this->data['email_settings'] = $this->emailsetting->get_email_setting_list();
        $this->data['school_id'] = $this->data['email_setting']->school_id;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('email_setting/index', $this->data);
    }

            
        
    /*****************Function get_single_email**********************************
     * @type            : Function
     * @function name   : get_single_email
     * @description     : "Load single email setting information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_email_setting(){
        
       $settingl_id = $this->input->post('setting_id');       
       $this->data['email_setting'] = $this->emailsetting->get_single_email_setting($settingl_id);
       echo $this->load->view('email_setting/get-single-email-setting', $this->data);
    }

    
    /*****************Function _prepare_email_setting_validation**********************************
    * @type            : Function
    * @function name   : _prepare_email_setting_validation
    * @description     : Process "Email setting" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_email_setting_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
      
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required|callback_school_id');
        $this->form_validation->set_rules('mail_protocol', $this->lang->line('email_protocol'), 'trim|required');
        
        if($this->input->post('mail_protocol') == 'smtp'){
            $this->form_validation->set_rules('smtp_host', $this->lang->line('smtp_host'), 'trim|required');
            $this->form_validation->set_rules('smtp_port', $this->lang->line('smtp_port'), 'trim|required');
            $this->form_validation->set_rules('smtp_user', $this->lang->line('smtp_username'), 'trim|required');
            $this->form_validation->set_rules('smtp_pass', $this->lang->line('smtp_password'), 'trim|required');        
        }
        
        $this->form_validation->set_rules('smtp_timeout', $this->lang->line('smtp_timeout'), 'trim');
        $this->form_validation->set_rules('smtp_crypto',  $this->lang->line('smtp_security'), 'trim');
        $this->form_validation->set_rules('mail_type', $this->lang->line('email_type'), 'trim');
        $this->form_validation->set_rules('char_set',  $this->lang->line('char_set'), 'trim');
        $this->form_validation->set_rules('priority', $this->lang->line('priority'), 'trim');        
        $this->form_validation->set_rules('from_name',  $this->lang->line('from_name'), 'trim');
        $this->form_validation->set_rules('from_address', $this->lang->line('from_email'), 'trim');
        
    }

        /*****************Function school_id**********************************
    * @type            : Function
    * @function name   : school_id
    * @description     : Unique check for "school_id" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function school_id() {
        if ($this->input->post('id') == '') {
            $emailsetting = $this->emailsetting->duplicate_check($this->input->post('school_id'));
            if ($emailsetting) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $emailsetting = $this->emailsetting->duplicate_check($this->input->post('school_id'), $this->input->post('id'));
            if ($emailsetting) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    
    /*****************Function _get_posted_email_setting_data**********************************
     * @type            : Function
     * @function name   : _get_posted_email_setting_data
     * @description     : Prepare "School email setting" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_email_setting_data() {

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
        $items[] = 'school_id';
        
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
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }       

        return $data;
    }
    
     
    /*****************Function delete**********************************
   * @type            : Function
   * @function name   : delete
   * @description     : delete "School Email Settings" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {
        
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/emailsetting');              
        }
        
        $email = $this->emailsetting->get_single('email_settings', array('id' => $id));
        
        if ($this->emailsetting->delete('email_settings', array('id' => $id))) {  
            
            $school = $this->emailsetting->get_single('schools', array('id' => $email->school_id));
            create_log('Has been deleted a smtp setting for : '.$school->school_name); 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('administrator/emailsetting');
    }
}