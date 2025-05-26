<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Text.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Text
 * @description     : Manage text sms which are send to the users.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Text extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Sms_Model', 'sms', true);       
        $this->load->library('twilio');
        $this->load->library('clickatell');
        $this->load->library('bulk');
        $this->load->library('msg91');
        $this->load->library('plivo');
        $this->load->library('smscountry');
        $this->load->library('textlocalsms');
        $this->load->library('betasms');
        $this->load->library('bulkpk');
        $this->load->library('smscluster');
        $this->load->library('alphanet');
        $this->load->library('bdbulk');
        $this->load->library('mimsms');
    }

            
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Sent SMS List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->sms->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['texts'] = $this->sms->get_sms_list($school_id);
        $this->data['roles'] = $this->sms->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_sms') . ' | ' . SMS);
        $this->layout->view('sms/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Send new SMS" user interface                 
    *                    and process to send "SMS"
    *                    and store SMS into database
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {          
        
            $this->_prepare_sms_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_sms_data();

                $insert_id = $this->sms->insert('text_messages', $data);
                if ($insert_id) {
                    $data['text_msg_id'] = $insert_id;
                    $this->_send_sms($data);
                    
                    create_log('Has been sent a SMS using : '.$data['sms_gateway']);                    
                    success($this->lang->line('sms_send_success'));
                    redirect('message/text/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('sms_send_failed'));
                    redirect('message/text/add');
                }
            } else {
                error($this->lang->line('sms_send_failed'));
                $this->data['post'] = $_POST;
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->sms->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['texts'] = $this->sms->get_sms_list();
        $this->data['roles'] = $this->sms->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('send') . ' | ' . SMS);
        $this->layout->view('sms/index', $this->data);
    }
    
                
           
     /*****************Function get_single_sms**********************************
     * @type            : Function
     * @function name   : get_single_sms
     * @description     : "Load single sms information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_sms(){
        
       $sms_id = $this->input->post('sms_id');
       
       $this->data['sms'] = $this->sms->get_single_sms($sms_id);
       echo $this->load->view('sms/get-single-sms', $this->data);
    }

            
    /*****************Function _prepare_sms_validation**********************************
    * @type            : Function
    * @function name   : _prepare_sms_validation
    * @description     : Process "SMS" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
   public function _prepare_sms_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('receiver_type'), 'trim|required');
        if ($this->input->post('role_id') == STUDENT) {
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        $this->form_validation->set_rules('receiver_id', $this->lang->line('receiver'), 'trim|required');
        $this->form_validation->set_rules('sms_gateway', $this->lang->line('gateway'), 'trim|required|callback_sms_gateway');
        $this->form_validation->set_rules('body', $this->lang->line('sms'), 'trim|required');
    }

               
    /*****************Function sms_gateway**********************************
    * @type            : Function
    * @function name   : sms_gateway
    * @description     : Process to SMS gateway validation                
    *                       
    * @param           : null
    * @return          : boolean true/flase 
    * ********************************************************** */ 
   public function sms_gateway() {

        $getway = $this->input->post('sms_gateway');

        if ($getway == "clicktell") {
            if ($this->clickatell->ping() == TRUE) {
                return TRUE;
            } else {
                $this->form_validation->set_message("sms_gateway", $this->lang->line('setup_your_sms_gateway'));
                return FALSE;
            }
        } elseif ($getway == 'twilio') {            
            $get = $this->twilio->get_twilio();
            $ApiVersion = $get['version'];
            $AccountSid = $get['accountSID'];
            $check = $this->twilio->request("/$ApiVersion/Accounts/$AccountSid/Calls");

            if ($check->IsError) {
                $this->form_validation->set_message("sms_gateway", $this->lang->line('setup_your_sms_gateway'));
                return FALSE;
            }
            return TRUE;
        } elseif ($getway == 'bulk') {
            if ($this->bulk->ping() == TRUE) {
                return TRUE;
            } else {
                $this->form_validation->set_message("sms_gateway", $this->lang->line('setup_your_sms_gateway'));
                return FALSE;
            }
        } elseif ($getway == 'msg91') {
            return true;
        } elseif ($getway == 'plivo') {
            return true;
       } elseif ($getway == 'text_local') {
            return true;       
        } elseif ($getway == 'sms_country') {
            return true;
        }elseif ($getway == 'beta_sms') {
            return true;
        }elseif ($getway == 'bulk_pk') {
            return true;
        }elseif ($getway == 'sms_custer') {
            return true;
        }elseif ($getway == 'alpha_net') {
            return true;
        }elseif ($getway == 'bd_bulk') {
            return true;
        }elseif ($getway == 'mim_sms') {
            return true;
        }
    }

    
       
    /*****************Function _get_posted_sms_data**********************************
    * @type            : Function
    * @function name   : _get_posted_sms_data
    * @description     : Prepare "SMS" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_sms_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'sms_gateway';
        $items[] = 'body';
        $data = elements($items, $_POST);

        $school = $this->sms->get_school_by_id($data['school_id']);
        
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('message/text/index');
        }
        
        $data['academic_year_id'] = $school->academic_year_id;
        
        $data['sender_role_id'] = $this->session->userdata('role_id');
        $data['status'] = 1;
        $data['sms_type'] = 'general';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();

        return $data;
    }

            
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "SMS" data from database                  
    *                    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $sms = $this->sms->get_single('text_messages', array('id' => $id));
        
        if ($this->sms->delete('text_messages', array('id' => $id))) {
            
            create_log('Has been deleted a SMS sent by : '.$sms->sms_gateway);             
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('message/text/index/'.$sms->school_id);
    }

        
        
    /*****************Function _send_sms**********************************
    * @type            : Function
    * @function name   : _send_sms
    * @description     : Process to send SMS to the users                  
    *                    
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    private function _send_sms($data) {

        $receivers = '';
        $users = $this->sms->get_user_list($data['school_id'], $data['role_id'], $this->input->post('receiver_id'), $this->input->post('class_id'));

        foreach ($users as $obj) {

            //$message = trim($data['body']);
            $message = get_formatted_body($data['body'], $data['role_id'], $obj->id);
            $receivers .= $obj->name.',';
            if ($obj->phone != '') {
                $phone = '+' . $obj->phone;
                $this->_send($data['sms_gateway'], $phone, $message);
            }
        }
      
        // update text_messages table 
        $this->sms->update('text_messages', array('receivers' => $receivers), array('school_id'=>$data['school_id'],'id' => $data['text_msg_id']));
               
    }

            
    /*****************Function _send**********************************
    * @type            : Function
    * @function name   : _send
    * @description     : Send SMS to the users using configured SMS Gateway                 
    *                    
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    public function _send($sms_gateway, $phone, $message) {

        if ($sms_gateway == "clicktell") {
            
            $this->clickatell->send_message($phone, $message);
        } elseif ($sms_gateway == 'twilio') {
            
            $get = $this->twilio->get_twilio();
            $from = $get['number'];            
            $response = $this->twilio->sms($from, $phone, $message);          
        } elseif ($sms_gateway == 'bulk') {

            //https://github.com/anlutro/php-bulk-sms     
            
            $this->bulk->send($phone, $message);
        } elseif ($sms_gateway == 'msg91') {
            
            $response = $this->msg91->send($phone, $message);
        } elseif ($sms_gateway == 'plivo') {
            
            $response = $this->plivo->send($phone, $message);
        }elseif ($sms_gateway == 'sms_country') { 
            
            $response = $this->smscountry->sendSMS($phone, $message);            
        } elseif ($sms_gateway == 'text_local') {  
            
            $response = $this->textlocalsms->sendSms(array($phone), $message);
        } elseif ($sms_gateway == 'beta_sms') {     
            
            $response = $this->betasms->sendSms(array($phone), $message);
        } elseif ($sms_gateway == 'bulk_pk') {     
            
            $response = $this->bulkpk->sendSms($phone, $message);
        } elseif ($sms_gateway == 'sms_custer') {     
            
            $response = $this->smscuster->sendSms($phone, $message);
        } elseif ($sms_gateway == 'alpha_net') {     
            
            $response = $this->alphanet->sendSms($phone, $message);
        } elseif ($sms_gateway == 'bd_bulk') {     
            
            $response = $this->bdbulk->sendSms($phone, $message);
        } elseif ($sms_gateway == 'mim_sms') {     
            
            $response = $this->mimsms->sendSms($phone, $message);
        }
    }

}

