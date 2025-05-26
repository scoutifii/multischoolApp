<?php

error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Text.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Text
 * @description     : Manage sms which are send to students and guardian with student exam mark.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ***********************************************************/

ini_set('max_execution_time', 9000);
ini_set('memory_limit', '960M');

class Text extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mark_Model', 'mark', true);  
        
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
    * @description     : Load "SMS List" user interface                 
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
            $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->mark->get_school_by_id($condition['school_id']); 
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        } 
        
        $this->data['roles'] = $this->mark->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['mark_smses'] = $this->mark->get_mark_sms_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('mark_send_by_sms') . ' | ' . SMS);
        $this->layout->view('sms/index', $this->data);
    }

    
    /*****************Function send**********************************
    * @type            : Function
    * @function name   : send
    * @description     : Process to sent SMS with student exam marks 
    *                    to the student/guardian                  
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function send() {

        check_permission(ADD);

        if ($_POST) {
            
            $this->_prepare_sms_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_sms_data();

                $insert_id = $this->mark->insert('mark_smses', $data);
                if ($insert_id) {
                    
                    $data['sms_id'] = $insert_id;                    
                    $this->_send_sms($data);
                    
                    create_log('Has been send Mark SMS :'. $data['sms_gateway']);                    
                    success($this->lang->line('sms_send_success'));
                    redirect('exam/text/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('sms_send_failed'));
                    redirect('exam/text/index');
                }
            } else {
                error($this->lang->line('fill_out_all_data'));
                redirect('exam/text/index');
            }
        } else {
            error($this->lang->line('unexpected_error'));
            redirect('exam/text/index');
        }
    }
    
    
            
    /*****************Function get_single_sms**********************************
     * @type            : Function
     * @function name   : get_single_sms
     * @description     : "Load single email information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_sms(){
        
       $sms_id = $this->input->post('sms_id');
       
       $this->data['sms'] = $this->mark->get_single_sms($sms_id);
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
    private function _prepare_sms_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('exam_id', $this->lang->line('exam_term'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('receiver_type'), 'trim|required');
        $this->form_validation->set_rules('receiver_id', $this->lang->line('receiver'), 'trim|required');
        $this->form_validation->set_rules('sms_gateway', $this->lang->line('gateway'), 'trim|required|callback_sms_gateway');
        $this->form_validation->set_rules('body', $this->lang->line('sms'), 'trim|required');
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Process to validate SMS gateway                 
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
        $items[] = 'exam_id';
        $items[] = 'class_id';
        $items[] = 'role_id';
        $items[] = 'sms_gateway';
        $items[] = 'body';
        
        $data = elements($items, $_POST);

        $school = $this->mark->get_school_by_id($data['school_id']);
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('exam/text');
        }
            
        $data['academic_year_id'] = $school->academic_year_id;
        
        $data['sender_role_id'] = $this->session->userdata('role_id');
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();

        return $data;
    }

    
    /*****************Function _send_sms**********************************
    * @type            : Function
    * @function name   : _send_sms
    * @description     : process to sent SMS with exam mark to the student/guardian                  
    *                       
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    private function _send_sms($data) {

        $school = $this->mark->get_school_by_id($data['school_id']);
        $students = $this->mark->get_student_list_by_class($data['school_id'], $data['exam_id'], $data['class_id'], $this->input->post('receiver_id'), $school->academic_year_id);

        $receivers = '';
         
        if (!empty($students)) {

            foreach ($students AS $obj) {

                $message = '';
                $receiver_mobile = '';                
                $user_id = '';
                
                $receiver = $this->mark->get_receiver($data['school_id'], $data['role_id'], $obj->student_id, $obj->guardian_id);
              
                $receiver_mobile = $receiver->phone;
                $user_id = $receiver->id;
                $receivers .= $receiver->name.',';
                

                // message marks parts
                $marks = $this->mark->get_marks_list_by_student($data['school_id'], $data['exam_id'], $data['class_id'], $obj->student_id, $school->academic_year_id);
                foreach ($marks as $mark) {
                    $message .= strtoupper(substr($mark->subject, 0,2)) . ':' . $mark->obtain_total_mark . ' of ' . $mark->exam_total_mark . ', ';
                }

                $body = get_formatted_body($data['body'], $data['role_id'], $user_id);
                if (strpos($body, '[exam_mark]') !== false) {
                    $body = str_replace('[exam_mark]', $message, $body);
                }else{
                    $body = $body . ' ' . $message;
                }   
                
                if ($receiver_mobile != '') {
                    $phone = '+' . $receiver_mobile;
                    $this->_send($data['sms_gateway'], $phone, $body);
                }
            }           
             
            // update sms table 
            $this->mark->update('mark_smses', array('receivers' => $receivers), array('id' => $data['sms_id'])); 
        }
        
    }

    
    /*****************Function _send**********************************
    * @type            : Function
    * @function name   : _send
    * @description     : Sent SMS using conigured Gateway                  
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

            $this->load->library('plivo');
            $response = $this->twilio->send($phone, $message);
            
        } elseif ($sms_gateway == 'sms_country') {
           
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

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "SMS" content from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $sms = $this->mark->get_single('mark_smses', array('id' => $id));
        
        if ($this->mark->delete('mark_smses', array('id' => $id))) {
            
             create_log('Has been send Mark SMS :'. $sms->sms_gateway);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('exam/text/index/'.$sms->school_id);
    }

}
