<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Mail.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Mail
 * @description     : Manage email which are sent to student and guardian with student exam mark.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Mail extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mark_Model', 'mark', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Email List" user interface                 
    *                      
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);


        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->mark->get_school_by_id($this->session->userdata('school_id'));            
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['mark_emails'] = $this->mark->get_mark_emails($school_id);
        $this->data['roles'] = $this->mark->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('mark_send_by_email') . ' | ' . SMS);
        $this->layout->view('email/index', $this->data);
        
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific email data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $school = $this->mark->get_school_by_id($this->session->userdata('school_id')); 
            
            $condition['school_id'] = $this->session->userdata('school_id');            
            $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        } 
        $this->data['mark_emails'] = $this->mark->get_mark_emails();
        $this->data['roles'] = $this->mark->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

        $this->data['mail'] = $this->mark->get_single_email($id);
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('mark_send_by_email') . ' | ' . SMS);
        $this->layout->view('email/index', $this->data);
    }

                
    /*****************Function get_single_email**********************************
     * @type            : Function
     * @function name   : get_single_email
     * @description     : "Load single email information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_email(){
        
       $email_id = $this->input->post('email_id');
       
       $this->data['email'] = $this->mark->get_single_email($email_id);
       echo $this->load->view('email/get-single-email', $this->data);
    }

    
    
    /*****************Function send**********************************
    * @type            : Function
    * @function name   : send
    * @description     : Process to sent email with student exam marks 
    *                    to the student/guardian                  
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function send() {

        check_permission(ADD);

        
        if ($_POST) {
            $this->_prepare_email_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_email_data();

                $insert_id = $this->mark->insert('mark_emails', $data);
                if ($insert_id) {
                    $data['email_id'] = $insert_id;
                    $this->_send_email($data);
                    
                     create_log('Has been send an Mark Email : '.$data['subject']);
                    
                    success($this->lang->line('email_send_success'));
                    redirect('exam/mail/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('email_send_failed'));
                    redirect('exam/mail/index');
                }
            } else {
                error($this->lang->line('fill_out_all_data'));
                redirect('exam/mail/index');
            }
        } else {
            error($this->lang->line('unexpected_error'));
            redirect('exam/mail/index');
        }
    }

    
    /*****************Function _prepare_email_validation**********************************
    * @type            : Function
    * @function name   : _prepare_email_validation
    * @description     : Process "email" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_email_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('exam_id', $this->lang->line('exam_term'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('receiver_type'), 'trim|required');
        $this->form_validation->set_rules('receiver_id', $this->lang->line('receiver'), 'trim|required');
        $this->form_validation->set_rules('subject', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('body', $this->lang->line('email_body'), 'trim|required');
    }

    
    /*****************Function _get_posted_email_data**********************************
    * @type            : Function
    * @function name   : _get_posted_email_data
    * @description     : Prepare "email" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_email_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'exam_id';
        $items[] = 'class_id';
        $items[] = 'role_id';
        $items[] = 'subject';
        $items[] = 'body';
        
        $data = elements($items, $_POST);

        $school = $this->mark->get_school_by_id($data['school_id']);
        
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('exam/mail');
        }
        
        $data['academic_year_id'] = $school->academic_year_id;
        $data['sender_role_id'] = $this->session->userdata('role_id');
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();

        return $data;
    }

    
    /*****************Function _send_email**********************************
    * @type            : Function
    * @function name   : _send_email
    * @description     : process to sent email with exam mark to the student/guardian                  
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    private function _send_email($data) {
        
        $school = $this->mark->get_school_by_id($data['school_id']);
        $students = $this->mark->get_student_list_by_class($data['school_id'], $data['exam_id'], $data['class_id'], $this->input->post('receiver_id'), $school->academic_year_id);

        
        $school_id     = $data['school_id'];        
        $email_setting = $this->mark->get_single('email_settings', array('status' => 1, 'school_id'=>$school_id)); 

        if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
            $config['protocol']     = 'smtp';
            $config['smtp_host']    = $email_setting->smtp_host;
            $config['smtp_port']    = $email_setting->smtp_port;
            $config['smtp_timeout'] = $email_setting->smtp_timeout ? $email_setting->smtp_timeout  : 5;
            $config['smtp_user']    = $email_setting->smtp_user;
            $config['smtp_pass']    = $email_setting->smtp_pass;
            $config['smtp_crypto']  = $email_setting->smtp_crypto ? $email_setting->smtp_crypto  : 'tls';
            $config['mailtype'] = isset($email_setting) && $email_setting->mail_type ? $email_setting->mail_type  : 'html';
            $config['charset']  = isset($email_setting) && $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
            $config['priority']  = isset($email_setting) && $email_setting->priority ? $email_setting->priority  : '3';

        }elseif(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
            $config['protocol'] = $email_setting->mail_protocol;
            $config['mailpath'] = '/usr/sbin/'.$email_setting->mail_protocol;
            $config['mailtype'] = isset($email_setting) && $email_setting->mail_type ? $email_setting->mail_type  : 'html';
            $config['charset']  = isset($email_setting) && $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
            $config['priority']  = isset($email_setting) && $email_setting->priority ? $email_setting->priority  : '3';

        }else{// default    
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail'; 
        }                              

        $config['wordwrap'] = TRUE;            
        $config['newline']  = "\r\n";            

        $this->load->library('email');
        $this->email->initialize($config);
        
        $from_email = FROM_EMAIL;
        $from_name = FROM_NAME;
        if(!empty($email_setting)){
            $from_email = $email_setting->from_address;
            $from_name  = $email_setting->from_name;  
        }elseif(!empty($school)){
            $from_email = $school->email;
            $from_name  = $school->school_name;  
        }

        $receivers = '';
        
        if (!empty($students)) {

            foreach ($students AS $obj) {

                $message = '<br/>';
                
                $receiver = $this->mark->get_receiver($data['school_id'], $data['role_id'], $obj->student_id, $obj->guardian_id);

                // message marks parts
                $marks = $this->mark->get_marks_list_by_student($data['school_id'], $data['exam_id'], $data['class_id'], $obj->student_id, $school->academic_year_id);
                
                
                if(!empty($marks) && $receiver->email != ''){
                    
                    foreach ($marks as $mark) {
                        $message .= '<strong>' . $mark->subject . ':</strong> <strong>' . $mark->obtain_total_mark . '</strong> out of <strong>' . $mark->exam_total_mark . '</strong><br/>';
                    }

                    
                    $body = get_formatted_body($data['body'], $data['role_id'], $receiver->id);
                    if (strpos($body, '[exam_mark]') !== false) {
                        $body = str_replace('[exam_mark]', $message, $body);
                    }else{
                        $body = $body . ' ' . $message;
                    }  

                    $this->email->from($from_email, $from_name);
                    $this->email->reply_to($from_email, $from_name);
                    $this->email->to($receiver->email);
                    $this->email->subject($data['subject']);
                    $this->email->message($body);
                    
                    if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                        $this->email->send(); 
                    }else if(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                        $this->email->send(); 
                    }else{
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                        $headers .= "From:  $from_name < $from_email >\r\n";
                        $headers .= "Reply-To:  $from_name < $from_email >\r\n"; 
                        mail($receiver->email, $data['subject'], $body, $headers);
                    }

                    $receivers .= $receiver->name.',';  
                  
                }                 
            }
            
            // update emails table 
            $this->mark->update('mark_emails', array('receivers' => $receivers), array('id' => $data['email_id'])); 
           
        }
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Email" content from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $email = $this->mark->get_single('mark_emails', array('id' => $id));
        
        if ($this->mark->delete('mark_emails', array('id' => $id))) {
            
             create_log('Has been deleted an mark Email : '.$email->subject);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('exam/mail/index/'.$email->school_id);
    }
}
