<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Gateway.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Gateway
 * @description     : Process payment gateway notiication.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */
class Gateway extends CI_Controller {

    public $data = array();    
            
    function __construct() {
        parent::__construct();
         $this->load->model('Payment_Model', 'payment', true);
         $this->load->model('Invoice_Model', 'invoice', true);
         
         $this->config->load('custom');
         $this->load->library("paypal");  
    }

        
    
    /*****************Function paypal_notify**********************************
    * @type            : Function
    * @function name   : paypal_notify
    * @description     : paypal peyment processing notify url                 
    *                    internally paypal send some post data
                         which are procesing here.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function paypal_notify(){
        
       //mail('yousuf361@gmail.com', 'Paypal notify out', json_encode($_POST));
        
        if (isset($_POST['ipn_track_id']) && !empty($_POST['ipn_track_id'])) {
            
            
            // mail('yousuf361@gmail.com', 'Paypal notify in', json_encode($_POST));
            /*$ipn_response = '';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $ipn_response .= "\n$key=$value";
            }*/
            
            $invoice = $this->invoice->get_single_invoice($_POST['custom']);
            $payment = $this->payment->get_invoice_amount($_POST['custom']); 
            
            $school = $this->invoice->get_school_by_id($invoice->school_id);
            
            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $_POST['custom'];
            $data['amount'] = $invoice->temp_amount;; 
            $data['payment_method'] = 'Paypal';
            $data['transaction_id'] = $_POST['txn_id'];            
            $data['note'] = $_POST['item_name'];      
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 
            
            $this->payment->insert('transactions', $data);            
            $due_amount = $invoice->net_amount-$payment->paid_amount;
            
            if(floatval($data['amount']) < floatval($due_amount)){
                $update = array('paid_status'=> 'partial');
            }else{
               $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }                    
            $this->payment->update('invoices', $update, array('id'=>$data['invoice_id']));            
        }
    }   


}
