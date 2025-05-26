<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Income.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Income
 * @description     : Manage all kind of income like student fee, admission, fine and other income.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */
class Income extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Income_Model', 'income', true);                 
    }

            
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Income List" user interface                 
     *                      
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        $condition['head_type'] = 'income';    
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['income_heads'] = $this->income->get_list('income_heads', $condition); 
            $this->data['payments'] = get_payment_methods($condition['school_id']);
        }        
        $this->data['incomes'] = $this->income->get_income_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
         
        $this->data['list'] = TRUE;
        $this->layout->title( $this->lang->line('manage_income'). ' | ' . SMS);
        $this->layout->view('income/index', $this->data);            
       
    }

    
     /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Income" user interface                 
     *                    and store "Income" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_income_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_income_data();

                $insert_id = $this->income->insert('invoices', $data);
                if ($insert_id) {
                    
                    // save invoice detail data
                    $this->_save_invoice_detail($insert_id);
                    
                    create_log('Has been created a income : '. $data['net_amount']);
                    // save transction table data
                    $data['invoice_id'] = $insert_id;
                    $this->_save_transaction($data);                                             
                    success($this->lang->line('insert_success'));
                    redirect('accounting/income/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('accounting/income/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        $condition['head_type'] = 'income';       
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['income_heads'] = $this->income->get_list('income_heads', $condition);
            $this->data['payments'] = get_payment_methods($condition['school_id']);
        }        
        $this->data['incomes'] = $this->income->get_income_list();
        $this->data['schools'] = $this->schools;
         
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('income/index', $this->data);
    }

    
     /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Income" user interface                 
     *                    with populated "Income" value 
     *                    and update "Income" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/income/index'); 
        }
        
        if ($_POST) {
            $this->_prepare_income_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_income_data();
                $updated = $this->income->update('invoices', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    // save invoice detail data
                    $this->_save_invoice_detail($this->input->post('id'));
                    
                    create_log('Has been updated a income : '. $data['net_amount']);                    
                    $this->_save_transaction($data);
                    success($this->lang->line('update_success'));
                    redirect('accounting/income/index/'.$data['school_id']);     
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('accounting/income/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['income'] = $this->income->get_single_income($this->input->post('id'));
            }
        }
        
        if ($id) {
            $this->data['income'] = $this->income->get_single_income($id);

            if (!$this->data['income']) {
                 redirect('accounting/income/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        $condition['head_type'] = 'income';     
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['income_heads'] = $this->income->get_list('income_heads', $condition);  
            $this->data['payments'] = get_payment_methods($condition['school_id']);
        }  
        
        $this->data['incomes'] = $this->income->get_income_list($this->data['income']->school_id);
        $this->data['school_id'] = $this->data['income']->school_id;
        $this->data['filter_school_id'] = $this->data['income']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('income/index', $this->data);
    }
    
    
     /*****************Function view**********************************
     * @type            : Function
     * @function name   : view
     * @description     : Load user interface with specific Income data                 
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function view($id = null){
        
        check_permission(VIEW);
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/income/index'); 
        }
        
        
        $condition = array();
        $condition['status'] = 1;        
        $condition['head_type'] = 'income';        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['income_heads'] = $this->income->get_list('income_heads', $condition);  
        }        
        $this->data['incomes'] = $this->income->get_income_list(); 
        $this->data['income'] = $this->income->get_single_income($id);
        
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' | ' . SMS);
        $this->layout->view('income/index', $this->data);
    }
    
    
               
    /*****************Function get_single_income*********************************
     * @type            : Function
     * @function name   : get_single_income
     * @description     : "Load single income information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_income(){
        
       $income_id = $this->input->post('income_id');       
       $this->data['income'] = $this->income->get_single_income($income_id);
       echo $this->load->view('income/get-single-income', $this->data);
    }


    
    /*****************Function _prepare_income_validation**********************************
     * @type            : Function
     * @function name   : _prepare_income_validation
     * @description     : Process "Income" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_income_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('income_head_id', $this->lang->line('income_head'), 'trim|required');   
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|numeric');   
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');   
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');   
    }


           
    /*****************Function _get_posted_income_data**********************************
     * @type            : Function
     * @function name   : _get_posted_income_data
     * @description     : Prepare "Income" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_income_data() {
     
        $data = array();
        $data['school_id'] = $this->input->post('school_id');
        $data['note'] = $this->input->post('note');
        $data['gross_amount'] = $this->input->post('amount');
        $data['net_amount'] = $this->input->post('amount');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
        
              
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['custom_invoice_id'] = $this->income->get_custom_id('invoices', 'INV');
            $data['class_id'] = 0;
            $data['student_id'] = 0;
            $data['discount'] = 0;
            $data['invoice_type'] = 'income';
            $data['paid_status'] = 'paid';
            $data['status'] = 1;
            
            $school = $this->income->get_school_by_id($data['school_id']);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('accounting/income/index'); 
            } 
            
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
           
        }
               

        return $data;
    }

    
    /*****************Function delete**********************************
     * @type            : Function
     * @function name   : delete
     * @description     : delete "Income" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/income/index'); 
        }
        
        $income = $this->income->get_single('invoices', array('id' => $id));
        
        if ($this->income->delete('invoices', array('id' => $id))) {  
            
             // need to delete transation data
            $this->income->delete('transactions', array('invoice_id' => $id));
            create_log('Has been deleted a income : '. $income->net_amount);            
            success($this->lang->line('delete_success'));
             
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('accounting/income/index/'.$income->school_id);
    } 
    
    
    /*****************Function _save_invoice_detail**********************************
     * @type            : Function
     * @function name   : _save_invoice_detail
     * @description     : invoice detail data save/update into database 
     *                    while add/update income data into database                
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    private function _save_invoice_detail($invoice_id){
        
        $inv_detail = array();        
        $inv_detail['school_id'] = $this->input->post('school_id');
        $inv_detail['income_head_id'] = $this->input->post('income_head_id');
        $inv_detail['invoice_type'] = 'income';
        $inv_detail['gross_amount'] =  $this->input->post('amount');
        $inv_detail['discount'] = 0.00;
        $inv_detail['net_amount'] =  $this->input->post('amount');
        
        if ($this->input->post('id')) {
            $inv_detail['modified_at'] = date('Y-m-d H:i:s');
            $inv_detail['modified_by'] = logged_in_user_id();
            $this->income->update('invoice_detail', $inv_detail, array('invoice_id'=>$invoice_id));
        }else{
            
            $inv_detail['invoice_id'] = $invoice_id;
            $inv_detail['status'] = 1;
            $inv_detail['created_at'] = date('Y-m-d H:i:s');
            $inv_detail['created_by'] = logged_in_user_id();   
            $inv_detail['modified_at'] = date('Y-m-d H:i:s');
            $inv_detail['modified_by'] = logged_in_user_id();
            $this->income->insert('invoice_detail', $inv_detail);
        }
    }
    
    
    /*****************Function _save_transaction**********************************
     * @type            : Function
     * @function name   : _save_transaction
     * @description     : transaction data save/update into database 
     *                    while add/update income data into database                
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    private function _save_transaction($data){
        
        $txn = array();
        $txn['school_id'] = $data['school_id'];  
        $txn['amount'] = $data['net_amount'];  
        $txn['note'] = $data['note'];
        $txn['payment_date'] = $data['date'];
        $txn['payment_method'] = $this->input->post('payment_method');
        $txn['bank_name'] = $this->input->post('bank_name');
        $txn['cheque_no'] = $this->input->post('cheque_no');
      
        if ($this->input->post('id')) {
            
            $txn['modified_at'] = date('Y-m-d H:i:s');
            $txn['modified_by'] = logged_in_user_id();
            $this->income->update('transactions', $txn, array('invoice_id'=>$this->input->post('id')));
            
        } else {            
           
            $txn['invoice_id'] = $data['invoice_id'];
            $txn['status'] = 1;
            $txn['academic_year_id'] = $data['academic_year_id'];            
            $txn['created_at'] = $data['created_at'];
            $txn['created_by'] = $data['created_by'];
            $this->income->insert('transactions', $txn);
        }
    }
    
    

    /*****************Function get_income_head_by_school**********************************
     * @type            : Function
     * @function name   : get_income_head_by_school
     * @description     : Load "Income Head Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_income_head_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $income_head_id  = $this->input->post('income_head_id');
         
        $income_heads = $this->income->get_list('income_heads', array('school_id'=>$school_id, 'head_type'=>'income'));  
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($income_heads)) {
            foreach ($income_heads as $obj) {   
                
                $selected = $income_head_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    public function get_payment_method_by_school(){
        
        $school_id  = $this->input->post('school_id');
        $payment_method  = $this->input->post('payment_method');
        $payments = get_payment_methods($school_id);
        
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        
        if (!empty($payments)) {
            foreach ($payments as $key=>$value) {   
                
                $selected = $key == $payment_method ? $select : '';
                if(in_array($key, array('cheque', 'cash'))){
                    $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                }
            }
        }
        echo $str;
        
    }
       
}
