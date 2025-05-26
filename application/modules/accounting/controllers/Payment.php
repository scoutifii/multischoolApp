<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Payment extends My_Controller {

    public $data = array();

    //https://github.com/bitmash/alipay-api-php/blob/master/Alipay.php
    
    function __construct() {
        parent::__construct();
         $this->load->model('Payment_Model', 'payment', true);
         $this->load->model('Invoice_Model', 'invoice', true);
         
         $this->config->load('custom');
         $this->load->library("paypal");
         $this->load->library("CCAencrypt");
         $this->load->helper('paytm');
    }

    

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Payment" user interface                 
    *                    with specific invoice data   
    * @param           : $invoice_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($invoice_id = null) {
        
        check_permission(VIEW);
        
        if(!$invoice_id){
            redirect('accounting/invoice/due');
        }
        
        $invoice         = $this->payment->get_invoice_amount($invoice_id);      
        $due_amount      = $invoice->net_amount - $invoice->paid_amount;
        $this->data['due_amount'] = $due_amount;
        $this->data['invoice_id'] = $invoice_id;
        $this->data['school_id'] = $invoice->school_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title( $this->lang->line('payment'). ' | ' . SMS);
        $this->layout->view('payment/index', $this->data); 
    }
    

    
    /*****************Function paid**********************************
    * @type            : Function
    * @function name   : paid
    * @description     : Process invoice payment with integrated payment gateway                  
    *                      
    * @param           : $invoice_id integer value
    * @return          : null 
    * ********************************************************** */
    public function paid($invoice_id) {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_payment_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_payment_data();

                create_log('Has been proceeded a payment : '. $data['amount']. ' in :' . $this->input->post('payment_method'));
                
                if($this->input->post('payment_method') == 'cash' || $this->input->post('payment_method') == 'cheque' || $this->input->post('payment_method') == 'receipt'){
                    
                    $insert_id = $this->payment->insert('transactions', $data);
                    if($this->input->post('amount') < $this->input->post('due_amount')){
                        $update = array('paid_status'=> 'partial');
                    }else{
                        $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
                    }                    
                    $this->payment->update('invoices', $update, array('id'=>$invoice_id));
                    
                    success($this->lang->line('payment_success'));
                    redirect('accounting/invoice/view/'.$invoice_id);
                    
                }elseif($this->input->post('payment_method') == 'paypal'){
                    
                    $this->paypal($data); 
                    
                }elseif($this->input->post('payment_method') == 'stripe'){
                    
                    
                }elseif($this->input->post('payment_method') == 'payumoney'){
                    
                    $this->pay_u_money($data);  
                    
                }elseif($this->input->post('payment_method') == 'ccavenue'){
                    
                    $this->cc_avenue($data); 
                    
                }elseif($this->input->post('payment_method') == 'paytm'){
                    
                    $this->pay_tm($data);  
                    
                }elseif($this->input->post('payment_method') == 'paystack'){
                    
                    $this->pay_stack($data);  
                    
                }else{                    
                    
                }
                    
            } else {
                
                $this->data['post'] = $_POST;
                $this->data['due_amount'] = $this->input->post('amount');
                $this->data['invoice_id'] = $invoice_id;
                $this->data['list'] = TRUE;
                $this->layout->title($this->lang->line('payment').' | ' .SMS);
                $this->layout->view('payment/index', $this->data); 
                
            }
        }else{
             redirect('accounting/invoice/view/'.$invoice_id);
        }
        
    }

    /*****************Function _prepare_payment_validation**********************************
    * @type            : Function
    * @function name   : _prepare_payment_validation
    * @description     : Process "Payment" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_payment_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');   
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required|callback_amount');   
        $this->form_validation->set_rules('payment_method', $this->lang->line('payment_method'), 'trim|required|callback_payment_method');   
        
        if($this->input->post('payment_method') == 'cash'){
            
        }elseif($this->input->post('payment_method') == 'cheque'){
            
            $this->form_validation->set_rules('bank_name', $this->lang->line('bank_name'), 'trim|required');
            $this->form_validation->set_rules('cheque_no', $this->lang->line('cheque_number'), 'trim|required');
       
        }elseif($this->input->post('payment_method') == 'paypal'){
            
        }elseif($this->input->post('payment_method') == 'stripe'){
            
            $this->form_validation->set_rules('stripe_card_number', $this->lang->line('card_number'), 'trim|required');
            $this->form_validation->set_rules('card_cvv', $this->lang->line('cvv'), 'trim|required');
            $this->form_validation->set_rules('expire_month', $this->lang->line('expire_month'), 'trim|required');
            $this->form_validation->set_rules('expire_year', $this->lang->line('expire_year'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'payumoney'){
            
            $this->form_validation->set_rules('pum_first_name', $this->lang->line('first_name'), 'trim|required');
            $this->form_validation->set_rules('pum_email', $this->lang->line('email'), 'trim|required');
            $this->form_validation->set_rules('pum_phone', $this->lang->line('phone'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'ccavenue'){
            
        }elseif($this->input->post('payment_method') == 'paytm'){
            
        }elseif($this->input->post('payment_method') == 'paystack'){
            $this->form_validation->set_rules('stack_email', $this->lang->line('email'), 'trim|required');
            
        }elseif($this->input->post('payment_method') == 'receipt'){
            $this->form_validation->set_rules('bank_receipt', $this->lang->line('bank_receipt'), 'trim|required');
            
        }
        
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');   
    }
    
    
    
    /*****************Function amount**********************************
    * @type            : Function
    * @function name   : amount
    * @description     : validate payment "amount"                  
    *                     is amount is correct or not  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function amount() {
        
        $invoice_id      = $this->input->post('invoice_id');        
        $invoice         = $this->payment->get_invoice_amount($invoice_id);       
        $due_amount      = $invoice->net_amount - $invoice->paid_amount;
        
        if ($this->input->post('amount') > $due_amount) {
            $this->form_validation->set_message("amount", $this->lang->line('input_valid_amount'));
            return FALSE;
        }else{
            return TRUE;
        }
        
    }
  
    
    /*****************Function payment_method**********************************
    * @type            : Function
    * @function name   : payment_method
    * @description     : validate payment method                  
    *                   and check payment method is correct or not  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function payment_method() {
        
        $school_id = $this->input->post('school_id');
        $payment_method  = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$school_id));
      
        if ($this->input->post('payment_method') == 'cash' || $this->input->post('payment_method') == 'cheque' || $this->input->post('payment_method') == 'receipt') {
            return TRUE;
        } elseif ($this->input->post('payment_method') == 'paypal' && $payment_method->paypal_status == 1) {
            
            if ($payment_method->paypal_email  == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'stripe' && $payment_method->stripe_status == 1) {
            if ($payment_method->stripe_secret == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'payumoney' && $payment_method->payumoney_status == 1) {

            if ($payment_method->payumoney_key == "" || $payment_method->payumoney_salt == "") {
                $this->form_validation->set_message("unique_paymentmethod", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
       } elseif ($this->input->post('payment_method') == 'ccavenue' && $payment_method->ccavenue_status == 1) {

            if ($payment_method->ccavenue_key == "" || $payment_method->ccavenue_salt == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'paytm' && $payment_method->paytm_status == 1) {

            if ($payment_method->paytm_merchant_key == "" || $payment_method->paytm_merchant_mid == "" || $payment_method->paytm_merchant_website == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
            
        } elseif ($this->input->post('payment_method') == 'paystack' && $payment_method->stack_status == 1) {

            if ($payment_method->stack_public_key == "") {
                $this->form_validation->set_message("payment_method", $this->lang->line('input_valid_payment_setting'));
                return FALSE;
            }else{
                return TRUE;                
            }
        }           
    }



    
    /*****************Function _get_posted_payment_data**********************************
    * @type            : Function
    * @function name   : _get_posted_payment_data
    * @description     : Prepare "Payment" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_payment_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'amount';
        $items[] = 'invoice_id';
        $items[] = 'payment_method';       
        $items[] = 'note';
        
        $data = elements($items, $_POST); 

        if($this->input->post('payment_method') == 'cheque'){
            $data['bank_name'] = $this->input->post('bank_name');
            $data['cheque_no'] = $this->input->post('cheque_no');
            
        }else if($this->input->post('payment_method') == 'payumoney'){
            $data['pum_first_name'] = $this->input->post('pum_first_name');
            $data['pum_email'] = $this->input->post('pum_email');
            $data['pum_phone'] = $this->input->post('pum_phone');
            
        }else if($this->input->post('payment_method') == 'stripe'){
            $data['stripe_card_number'] = $this->input->post('stripe_card_number');
            $data['card_cvv'] = $this->input->post('card_cvv');
            $data['expire_month'] = $this->input->post('expire_month');
            $data['expire_year'] = $this->input->post('expire_year');
            
        }else if($this->input->post('payment_method') == 'paystack'){
            $data['stack_email'] = $this->input->post('stack_email');
            
        }else if($this->input->post('payment_method') == 'receipt'){
            $data['bank_receipt'] = $this->input->post('bank_receipt');
        } 
              
        $data['status'] = 1;
        
        $school = $this->payment->get_school_by_id($data['school_id']);
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('accounting/payment/index/'.$data['invoice_id']);
        }        
        $data['academic_year_id'] = $school->academic_year_id;  
        
        $data['payment_date'] = date('Y-m-d');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id(); 

        return $data;
    }
    
    
    /* PayUMoney Payment Start */    
    
    /*****************Function pay_u_money**********************************
    * @type            : Function
    * @function name   : pay_u_money
    * @description     : Payment processing using "Payumoney" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_u_money($data) {
        
        //https://developer.payumoney.com/general/
       
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
               
        
        if ($payment_setting->payumoney_demo == TRUE) {
            $api_link = "https://test.payu.in/_payment";
        } else {
            $api_link = "https://secure.payu.in/_payment";
        }
        

        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
        
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->payu_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->payu_extra_charge/100*$data['amount']);
        }
        
        $array['key'] = $payment_setting->payumoney_key; //'gtKFFx'; 
        $array['salt'] = $payment_setting->payumoney_salt; //'eCwWELxi'; 
        $array['payu_base_url'] = $api_link; // For Test
        $array['surl'] = base_url('accounting/payment/payumoney_success/' . $data['invoice_id']);
        $array['furl'] = base_url('accounting/payment/payumoney_failed/' . $data['invoice_id']);
        $array['txnid'] = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $array['action'] = $api_link;
        $array['amount'] = $pay_amount;
        $array['firstname'] = $data['pum_first_name'];
        $array['email'] = $data['pum_email'];
        $array['phone'] = $data['pum_phone'];
        $array['productinfo'] = 'Invoice' . ': ' .$data['note'];
        $array['hash'] = $this->_generate_hash($array);

        $this->load->view('payment/pay_u_money', $array);
    }

    
    /*****************Function _generate_hash**********************************
    * @type            : Function
    * @function name   : _generate_hash
    * @description     : generate hash id for payumoney peyment processing                  
    *                       
    * @param           : $array array() value
    * @return          : $hash string value
    * ********************************************************** */
    private function _generate_hash($array) {
        
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($array['key']) || empty($array['txnid']) || empty($array['amount']) || empty($array['firstname']) || empty($array['email']) || empty($array['phone']) || empty($array['productinfo']) || empty($array['surl']) || empty($array['furl'])) {
            return false;
        } else {
            
            /*
            $hash = '';
            $salt = $array['salt'];
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';
            foreach ($hashVarsSeq as $hash_var) {
                $hash_string .= isset($array[$hash_var]) ? $array[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $salt;
            */
            
            $retHashSeq = $array['key']."|".$array['txnid']."|".$array['amount']."|".$array['productinfo']."|".$array['firstname']."|".$array['email']."|||||||||||".$array['salt'];
            $hash = strtolower(hash('sha512', $retHashSeq));
            return $hash;
        }
    }

    
    /*****************Function payumoney_failed**********************************
    * @type            : Function
    * @function name   : payumoney_failed
    * @description     : payumoney peyment processing failed url                 
    *                    load user interface with payment failed message   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function payumoney_failed() {
        
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/view/' . $invoice_id);
        
    }

    
    /*****************Function payumoney_success**********************************
    * @type            : Function
    * @function name   : payumoney_success
    * @description     : payumoney peyment processing success url                 
    *                    load user interface with payment success message   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function payumoney_success() {
        
        // print_r($_POST); die();
        
        //mail('yousuf361@gmail.com', 'PayUMoney', json_encode($_POST));
        
        $invoice_id = $this->uri->segment(4);
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
        
        $status         = $_POST["status"];
        $firstname      = $_POST["firstname"];
        $amount         = $_POST["amount"];
        $txnid          = $_POST["txnid"];
        $posted_hash    = $_POST["hash"];
        $key            = $_POST["key"];
        $productinfo    = $_POST["productinfo"];
        $email          = $_POST["email"];
        $phone          = $_POST["phone"];
        $salt           = $payment_setting->payumoney_salt;
        
        /*
        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }*/
       
        $retHashSeq = $key."|".$txnid."|".$amount."|".$productinfo."|".$firstname."|".$email."|||||||||||".$salt;

        $hash = strtolower(hash("sha512", $retHashSeq));
       // mail('yousuf361@gmail.com', 'Hash PayUMoney', $hash);
                     
        if ($status === "success") {                
               
            $payment = $this->payment->get_invoice_amount($invoice_id);  

            $school = $this->payment->get_school_by_id($invoice->school_id);

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'PayUMoney';
            $data['transaction_id'] = $txnid;
            $data['pum_first_name'] = $firstname;
            $data['pum_email'] = $email;
            $data['pum_phone'] = $phone;
            $data['note'] = $productinfo;
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($amount) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }                    
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));

            success($this->lang->line('payment_success'));
            redirect('accounting/invoice/view/' . $invoice_id);

        } else {
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/view/' . $invoice_id);
        }
        
    }
    

    /* PayUmoney Payment End */
    
    
    /* Paypal payment start */
    
    
    /*****************Function paypal**********************************
    * @type            : Function
    * @function name   : paypal
    * @description     : Payment processing using "Paypal" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function paypal($data)
    {
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
        
         
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->paypal_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->paypal_extra_charge/100*$data['amount']);
        }
        
        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('no_note', 0);
        $this->paypal->add_field('item_name', 'Invoice');
        $this->paypal->add_field('amount', $pay_amount);
        $this->paypal->add_field('custom', $data['invoice_id']);
        $this->paypal->add_field('business', $payment_setting->paypal_email);
        $this->paypal->add_field('tax', 1);
        $this->paypal->add_field('quantity', 1);
        $this->paypal->add_field('currency_code', 'USD');

        $this->paypal->add_field('notify_url', base_url('accounting/gateway/paypal_notify'));
        $this->paypal->add_field('cancel_return', base_url('accounting/payment/paypal_cancel/' . $data['invoice_id']));
        $this->paypal->add_field('return', base_url('accounting/payment/paypal_success/' . $data['invoice_id']));
        
               
        
        if($payment_setting->paypal_demo){
            $this->paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $this->paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        }
        
        $this->paypal->submit_paypal_post();
    }

    /*****************Function paypal_cancel**********************************
    * @type            : Function
    * @function name   : paypal_cancel
    * @description     : paypal peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel paypal paymnet.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function paypal_cancel(){    
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/view/' . $invoice_id);
    }

    
    /*****************Function paypal_success**********************************
    * @type            : Function
    * @function name   : paypal_success
    * @description     : paypal peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function paypal_success(){ 
        $invoice_id = $this->uri->segment(4);
        success($this->lang->line('payment_success'));
        redirect('accounting/invoice/view/' . $invoice_id);
    }
 
    /* Paypal payment end */
    
    
    
     /* cc_avenue Payment Start */    
    
    /*****************Function cc_avenue**********************************
    * @type            : Function
    * @function name   : cc_avenue
    * @description     : Payment processing using "cc_avenue" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function cc_avenue($data) {
              
        
        //http://webprepration.com/integrate-ccavenue-payment-gateway-in-php/
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
     
        
        if ($payment_setting->ccavenue_demo == TRUE) {
            $api_link = "https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"; // demo
        } else {
            $api_link = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
        }   
        
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        
        $pay_amount = $data['amount'];
        
        if($payment_setting->ccavenue_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->ccavenue_extra_charge/100*$data['amount']);
        }
                
        $data = array(
           // 'merchant_id' => $payment_setting->ccavenue_key,
           // 'working_key' => $payment_setting->ccavenue_salt,
            'merchant_id' => '123456',
            'access_code' => 'aG4632543265ghjg',
            'working_key' => 'fdshaj131231231',
            'amount' => $pay_amount,
            'action' => $api_link,
            'order_id' => abs(crc32(uniqid())),
            'redirect_url' => base_url('accounting/payment/cc_avenue_success/' . $data['invoice_id']),
            'cancel_url' => base_url('accounting/payment/cc_avenue_cancel/' . $data['invoice_id']),
            'billing_cust_name' => "",
            'billing_cust_address' => "",
            'billing_cust_country' => "",
            'billing_cust_state' => "",
            'billing_city' => "",
            'billing_zip' => "",
            'billing_cust_tel' => "",
            'billing_cust_email' => "",
            'delivery_cust_name' => "",
            'delivery_cust_address' => "",
            'delivery_cust_country' => "",
            'delivery_cust_state' => "",
            'delivery_city' => "",
            'delivery_zip' => "",
            'delivery_cust_tel' => "",
            'delivery_cust_notes' => "",
            'delivery_cust_notes' => "",
            'name' => $invoice->head,
            'address' => "",
            'currency' => "INR",
            'tid' => time(),
        );

        $this->load->view('payment/cc_avenue', $data);
    }
    
    
     /*****************Function cc_avenue_success**********************************
    * @type            : Function
    * @function name   : cc_avenue_success
    * @description     : cc_avenue peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function cc_avenue_success(){
        
        mail('yousuf361@gmail.com', 'CC Avenue', json_encode($_POST));
        
        $invoice_id = $this->uri->segment(4);
        
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
        
        
        $workingKey  = 'fdshaj131231231'; $payment_setting->ccavenue_salt;		//Working Key should be provided here.
	$encResponse = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString  = $this->ccaencrypt->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues = explode('&', $rcvdString);        
	$dataSize = sizeof($decryptValues);
        
        mail('yousuf361@gmail.com', 'CCAVENUE Return', json_encode($rcvdString));
        
	for($i = 0; $i < $dataSize; $i++) 
	{
            $information=explode('=',$decryptValues[$i]);
            if($i==3){	$order_status=$information[1];}
	}

	if($order_status==="Success")
	{
	   
            $payment = $this->payment->get_invoice_amount($invoice_id);                
            $school = $this->payment->get_school_by_id($invoice->school_id);
             
            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'CCAvenue';
            $data['transaction_id'] = '1234567890';            
            $data['note'] = 'Note';
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($data['amount']) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }                    
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));

            success($this->lang->line('payment_success'));
            redirect('accounting/invoice/view/' . $invoice_id);
            
	}else{
            
            error($order_status .' : ' . $this->lang->line('payment_failed'));
            redirect('accounting/invoice/view/' . $invoice_id);          
	}
    }
    
    
     /*****************Function cc_avenue_cancel**********************************
    * @type            : Function
    * @function name   : cc_avenue_cancel
    * @description     : cc_avenue peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel cc_avenue paymnet 
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function cc_avenue_cancel(){
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/view/' . $invoice_id);
    }

    /* cc_avenue Payment END */  

    
        
    /* PAY TM Payment Start */    
    
    /*****************Function pay_tm**********************************
    * @type            : Function
    * @function name   : pay_tm
    * @description     : Payment processing using "pay_tm" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_tm($data) {
  
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
       
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $pay_amount = $data['amount'];
        if($payment_setting->paytm_extra_charge > 0){
            $pay_amount = $data['amount'] + ($payment_setting->paytm_extra_charge/100*$data['amount']);
        }
        
        
        if ($payment_setting->paytm_demo == TRUE) {

           // Key in your staging and production MID available in your dashboard
           define("merchantMid", "rxazcv89315285244163");
           // Key in your staging and production merchant key available in your dashboard
           define("merchantKey", "gKpu7IKaLSbkchFS");
           define("mobileNo", $this->session->userdata('phone') ? $this->session->userdata('phone') : '7777777777' );
           define("email", define("mobileNo", $this->session->userdata('email') ? $this->session->userdata('email') : 'username@emailprovider.com' )); 
           define("website", "WEBSTAGING");
           define("industryTypeId", "Retail");
           $transactionURL = "https://securegw-stage.paytm.in/theia/processTransaction";

        }else{

           // Key in your staging and production MID available in your dashboard
            define("merchantMid", $payment_setting->paytm_merchant_mid);
           // Key in your staging and production merchant key available in your dashboard
            define("merchantKey", $payment_setting->paytm_merchant_key);
            define("mobileNo", $this->session->userdata('phone') ? $this->session->userdata('phone') : '7777777777' );
            define("email", define("mobileNo", $this->session->userdata('email') ? $this->session->userdata('email') : 'username@emailprovider.com' ));
            define("website", $payment_setting->paytm_merchant_website);
            define("industryTypeId", $payment_setting->paytm_industry_type);
            $transactionURL = "https://securegw.paytm.in/theia/processTransaction"; //

        }
                
        define("orderId", "ORDS" . time().$data['invoice_id']);
        define("channelId", "WEB");
        define("custId", 'CUST'.$invoice->id);
        define("txnAmount", $pay_amount);
        define("callbackUrl", base_url('accounting/payment/pay_tm_success/' . $data['invoice_id']));
       
     
        $paytmParams = array();
        $paytmParams["MID"] = merchantMid;
        $paytmParams["ORDER_ID"] = orderId;
        $paytmParams["CUST_ID"] = custId;
        $paytmParams["MOBILE_NO"] = mobileNo;
        $paytmParams["EMAIL"] = email;
        $paytmParams["CHANNEL_ID"] = channelId;
        $paytmParams["TXN_AMOUNT"] = txnAmount;
        $paytmParams["WEBSITE"] = website;
        $paytmParams["INDUSTRY_TYPE_ID"] = industryTypeId;
        $paytmParams["CALLBACK_URL"] = callbackUrl;
        $paytmChecksum = getChecksumFromArray($paytmParams, merchantKey);
       
               
        $data['paytmParams'] = $paytmParams;
        $data['paytmChecksum'] = $paytmChecksum;
        $data['transactionURL'] = $transactionURL;
        
        $this->load->view('payment/pay_tm', $data);
    }
    
    
     /*****************Function pay_tm_success**********************************
    * @type            : Function
    * @function name   : pay_tm_success
    * @description     : pay_tm peyment processing success url                
                         load user interface with success message 
     *                   while user succesully pay.   
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_tm_success(){
        
       // mail('yousuf361@gmail.com', 'PAY TM Return', json_encode($_POST));
        
        $invoice_id = $this->uri->segment(4);
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment = $this->payment->get_invoice_amount($invoice_id);   
        $school = $this->payment->get_school_by_id($invoice->school_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
        
       
        $paytmParams = array();
        $isValidChecksum = "FALSE";        
        if ($payment_setting->paytm_demo == TRUE) {
            
            $merchantKey = "gKpu7IKaLSbkchFS";
            
        }else{
             $merchantKey = $payment_setting->paytm_merchant_key; 
        }  
       
        $paytmParams = $_POST;        
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
	
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
         $isValidChecksum = verifychecksum_e($paytmParams, $merchantKey, $paytmChecksum);
        
        if($isValidChecksum == "TRUE") {
            
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                                
                $data['school_id'] = $invoice->school_id;
                $data['invoice_id'] = $invoice_id;
                $data['amount'] = $invoice->temp_amount;
                $data['payment_method'] = 'PayTM';
                $data['transaction_id'] = $_POST["TXNID"];            
                $data['note'] = $_POST["RESPMSG"]; 
                $data['status'] = 1;
                $data['academic_year_id'] = $school->academic_year_id;
                $data['payment_date'] = date('Y-m-d');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id(); 

                $this->payment->insert('transactions', $data);                
                $due_mount = $invoice->net_amount - $payment->paid_amount;

                if(floatval($data['amount']) < floatval($due_mount)){
                    $update = array('paid_status'=> 'partial');
                }else{
                    $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
                }                    
                $this->payment->update('invoices', $update, array('id'=>$invoice_id));

                success($this->lang->line('payment_success'));
                redirect('accounting/invoice/view/' . $invoice_id);
                
            }else{
                error($this->lang->line('payment_failed'));
                redirect('accounting/invoice/view/' . $invoice_id); 
            }
        }else{
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/view/' . $invoice_id); 
        }
     
    }
    
    
     /*****************Function pay_tm_cancel**********************************
    * @type            : Function
    * @function name   : pay_tm_cancel
    * @description     : pay_tm peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel pay_tm paymnet 
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_tm_cancel(){
        $invoice_id = $this->uri->segment(4);
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/view/' . $invoice_id);
    }

    /* PAY TM Payment END */  

    
    
    
    /* PAY STACK Payment START */  
    
        /*****************Function pay_stack**********************************
    * @type            : Function
    * @function name   : pay_stack
    * @description     : Payment processing using "Pay Stack" payment gateway                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function pay_stack($data)
    {
        
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$data['school_id']));
        $invoice = $this->invoice->get_single_invoice($data['invoice_id']);
                 
        $this->invoice->update('invoices', array('temp_amount'=>$data['amount']), array('id'=>$data['invoice_id']));
        $this->data['amount'] = $data['amount'];
        
        if($payment_setting->stack_extra_charge > 0){
            $this->data['amount'] = ($data['amount'] + ($payment_setting->stack_extra_charge/100*$data['amount']))*100;
        }
        
        $this->data['stack_secret_key'] = $payment_setting->stack_secret_key;
        $this->data['public_key'] = $payment_setting->stack_public_key;
        $this->data['email'] = $data['stack_email']; // customer email
        $this->data['reference'] = uniqid().'-'.$data['invoice_id']; // unique reference 
        $this->data['invoice_id'] = $data['invoice_id'];
        $this->load->view('payment/pay_stack', $this->data);
        
    }
    

    /*****************Function stack_cancel**********************************
    * @type            : Function
    * @function name   : stack_cancel
    * @description     : stack peyment processing cancel url                
                         load user interface with some cancel message 
     *                   while user cancel stack paymnet 
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_stack_cancel(){
        
        $invoice_id = '';
        $ref_id = $this->uri->segment(4);
        
        if($ref_id){
            $ref_ids = explode('-', $ref_id);
            $invoice_id = $ref_ids[1];
        }        
        error($this->lang->line('payment_failed'));
        redirect('accounting/invoice/view/' . $invoice_id);
    }
    
    
    /*****************Function update_paystack_payment**********************************
    * @type            : Function
    * @function name   : update_paystack_payment
    * @description     : stack peyment processing success url                
                         load user interface with some success message                     
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function pay_stack_success(){
        
        $invoice_id = '';
        $ref_id = $this->uri->segment(4);
        $txn_id = $this->uri->segment(5);
        
        if($ref_id){
            $ref_ids = explode('-', $ref_id);
            $invoice_id = $ref_ids[1];
        } 
        
        $invoice = $this->invoice->get_single_invoice($invoice_id);
        $payment = $this->payment->get_invoice_amount($invoice_id);   
        $school = $this->payment->get_school_by_id($invoice->school_id);
        $payment_setting   = $this->payment->get_single('payment_settings', array('status'=>1, 'school_id'=>$invoice->school_id));
     
     
        if (!empty($invoice)) {

            $data['school_id'] = $invoice->school_id;
            $data['invoice_id'] = $invoice_id;
            $data['amount'] = $invoice->temp_amount;
            $data['payment_method'] = 'PayStack';
            $data['transaction_id'] = $txn_id;            
            $data['stack_reference'] = $ref_id;            
            $data['note'] = 'Pay Stack Payment'; 
            $data['status'] = 1;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['payment_date'] = date('Y-m-d');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 

            $this->payment->insert('transactions', $data);                
            $due_mount = $invoice->net_amount - $payment->paid_amount;

            if(floatval($data['amount']) < floatval($due_mount)){
                $update = array('paid_status'=> 'partial');
            }else{
                $update = array('paid_status'=> 'paid', 'modified_at'=>date('Y-m-d H:i:s'));
            }
            
            $this->payment->update('invoices', $update, array('id'=>$invoice_id));

           success($this->lang->line('payment_success'));
           redirect('accounting/invoice/view/' . $invoice_id);          
           
        }else{
            error($this->lang->line('payment_failed'));
            redirect('accounting/invoice/view/' . $invoice_id);
        }       
       
    }
    /* PAY STACK Payment END */  
    
    
}
