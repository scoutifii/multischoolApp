<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Payment extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Payment_Model', 'payment', true);
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "School Payment Setting Listing" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['payment_settings'] = $this->payment->get_payment_setting_list();
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_payment_setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Payment Setting" user interface                 
    *                    and store "Payment Setting" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_payment_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_payment_setting_data();

                $insert_id = $this->payment->insert('payment_settings', $data);
                if ($insert_id) {
                    
                    $school = $this->payment->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been created payment setting for : '.$school->school_name); 
                    
                    success($this->lang->line('insert_success'));
                    redirect('administrator/payment/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/payment/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['payment_settings'] = $this->payment->get_payment_setting_list();
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "SMS Setting" user interface                 
    *                    with populated "SMS Setting" value 
    *                    and update "SMS Setting" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_payment_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_payment_setting_data();
                $updated = $this->payment->update('payment_settings', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $school = $this->payment->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been updated payment setting for : '.$school->school_name); 
                    
                    success($this->lang->line('update_success'));
                    redirect('administrator/payment/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/payment/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['payment_setting'] = $this->payment->get_single('payment_settings', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['payment_setting'] = $this->payment->get_single('payment_settings', array('id' => $id));
 
                if (!$this->data['payment_setting']) {
                     redirect('administrator/payment/index');
                }
            }
        }

        $this->data['payment_settings'] = $this->payment->get_payment_setting_list();
        $this->data['school_id'] = $this->data['payment_setting']->school_id;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }

    
        
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific payment setting data                 
    *                       
    * @param           : $assignment_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($setting_id = null) {

        check_permission(VIEW);

        if(!is_numeric($setting_id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/payment/index');
        }
        
        $this->data['payment_settings'] = $this->payment->get_payment_setting_list();
        $this->data['payment_setting'] = $this->payment->get_single_payment_setting($setting_id);
           
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('payment') . ' ' . $this->lang->line('setting') . ' | ' . SMS);
        $this->layout->view('payment/index', $this->data);
    }
    
    
            
    /*****************Function get_single_payment**********************************
     * @type            : Function
     * @function name   : get_single_payment
     * @description     : "Load single payment information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_payment(){
        
       $payment_id = $this->input->post('payment_id');       
       $this->data['payment_setting'] = $this->payment->get_single_payment_setting($payment_id);
       echo $this->load->view('payment/get-single-payment', $this->data);
    }

    
    /*****************Function _prepare_payment_setting_validation**********************************
    * @type            : Function
    * @function name   : _prepare_payment_setting_validation
    * @description     : Process "Academic School" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_payment_setting_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
      
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required|callback_school_id');
        $this->form_validation->set_rules('paypal_email', $this->lang->line('paypal_email'), 'trim');
        $this->form_validation->set_rules('paypal_demo', $this->lang->line('is_demo'), 'trim');
        $this->form_validation->set_rules('paypal_status', $this->lang->line('is_active'), 'trim');
        
        //$this->form_validation->set_rules('stripe_secret', $this->lang->line('secret_key'), 'trim');
        //$this->form_validation->set_rules('stripe_demo', $this->lang->line('is_demo'), 'trim');
        //$this->form_validation->set_rules('stripe_status', $this->lang->line('is_active'), 'trim');
        
        $this->form_validation->set_rules('payumoney_key', $this->lang->line('payumoney_key'), 'trim');
        $this->form_validation->set_rules('payumoney_salt', $this->lang->line('key_salt'), 'trim');
        $this->form_validation->set_rules('payumoney_demo', $this->lang->line('is_demo'), 'trim');
        $this->form_validation->set_rules('payumoney_status', $this->lang->line('is_active'), 'trim');
        
        //$this->form_validation->set_rules('ccavenue_key', $this->lang->line('ccavenue_key'), 'trim');
        //$this->form_validation->set_rules('ccavenue_salt', $this->lang->line('key_salt'), 'trim');
        //$this->form_validation->set_rules('ccavenue_demo', $this->lang->line('is_demo'), 'trim');
        //$this->form_validation->set_rules('ccavenue_status', $this->lang->line('is_active'), 'trim');
        
        $this->form_validation->set_rules('paytm_merchant_key', $this->lang->line('merchant_key'), 'trim');
        $this->form_validation->set_rules('paytm_merchant_mid', $this->lang->line('merchant_mid'), 'trim');
        $this->form_validation->set_rules('paytm_merchant_website', $this->lang->line('website'), 'trim');
        $this->form_validation->set_rules('paytm_industry_type', $this->lang->line('industry_type'), 'trim');
        $this->form_validation->set_rules('paytm_demo', $this->lang->line('is_demo'), 'trim');
        $this->form_validation->set_rules('paytm_status', $this->lang->line('is_active'), 'trim');
        
        $this->form_validation->set_rules('stack_secret_key', $this->lang->line('secret_key'), 'trim');
        $this->form_validation->set_rules('stack_public_key', $this->lang->line('public_key'), 'trim');
        $this->form_validation->set_rules('stack_demo', $this->lang->line('is_demo'), 'trim');
        $this->form_validation->set_rules('stack_status', $this->lang->line('is_active'), 'trim');
        
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
            $school = $this->payment->duplicate_check($this->input->post('school_id'));
            if ($school) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $school = $this->payment->duplicate_check($this->input->post('school_id'), $this->input->post('id'));
            if ($school) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    
    
    
    /*****************Function _get_posted_payment_setting_data**********************************
     * @type            : Function
     * @function name   : _get_posted_payment_setting_data
     * @description     : Prepare "School SMS setting" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_payment_setting_data() {

        $items = array();
       
        //$items[] = 'paypal_api_username';
        //$items[] = 'paypal_api_password';
        //$items[] = 'paypal_api_signature';
        
        
        $items[] = 'paypal_email';
        $items[] = 'paypal_status';
        $items[] = 'paypal_extra_charge';      
        $items[] = 'paypal_demo';
        
        
        //$items[] = 'stripe_secret';
        //$items[] = 'stripe_status';
        //$items[] = 'stripe_extra_charge';      
        //$items[] = 'stripe_demo';
        
       
        $items[] = 'payumoney_key';
        $items[] = 'payumoney_salt';
        $items[] = 'payumoney_status';
        $items[] = 'payu_extra_charge';       
        $items[] = 'payumoney_demo';
        

        //$items[] = 'ccavenue_key';
        //$items[] = 'ccavenue_salt';
        //$items[] = 'ccavenue_status';
        //$items[] = 'ccavenue_extra_charge';       
        //$items[] = 'ccavenue_demo';        
        
       
        $items[] = 'paytm_merchant_key';
        $items[] = 'paytm_merchant_mid';
        $items[] = 'paytm_merchant_website';
        $items[] = 'paytm_industry_type';       
        $items[] = 'paytm_extra_charge';       
        $items[] = 'paytm_status';
        $items[] = 'paytm_demo';
        
        $items[] = 'stack_secret_key';
        $items[] = 'stack_public_key';
        $items[] = 'stack_demo';
        $items[] = 'stack_extra_charge';
        $items[] = 'stack_status'; 
        
        $items[] = 'school_id';
        
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
   * @description     : delete "School Payment Settings" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {
        
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/payment');              
        }
        
        $payment = $this->payment->get_single('payment_settings', array('id' => $id));
        
        if ($this->payment->delete('payment_settings', array('id' => $id))) { 
            
            $school = $this->payment->get_single('schools', array('id' => $payment->school_id));
            create_log('Has been deleted payment setting for : '.$school->school_name); 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('administrator/payment');
    }

}