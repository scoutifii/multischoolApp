<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Resultemail.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Resultemail
 * @description     : Manage email which are send to all type of system users.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Resultemail extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Resultemailsms_Model', 'mail', true);
               
       
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Sent Resultemail List" user interface                 
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
            $this->data['classes'] = $this->mail->get_list('classes', $condition, '','', '', 'id', 'ASC');          
        }
        
        $this->data['emails'] = $this->mail->get_email_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['roles'] = $this->mail->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_result_email') . ' | ' . SMS);
        $this->layout->view('result_email/index', $this->data);
    }

    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Send new Email" user interface                 
    *                    and process to send "Email"
    *                    and store email into database
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_email_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_email_data();

                $insert_id = $this->mail->insert('emails', $data);
                if ($insert_id) {
                    
                    $data['email_id'] = $insert_id;
                    $this->_send_email($data);
                    
                     create_log('Has been sent a Result Email : '.$data['subject']);
                    
                    success($this->lang->line('email_send_success'));
                    redirect('exam/resultemail/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('email_send_failed'));
                    redirect('exam/resultemail/add');
                }
            } else {
                error($this->lang->line('email_send_failed'));
                $this->data['post'] = $_POST;
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->mail->get_list('classes', $condition, '','', '', 'id', 'ASC');          
        }
        
         
        $this->data['emails'] = $this->mail->get_email_list();
        $this->data['schools'] = $this->schools;
         $this->data['roles'] = $this->mail->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('send_email') . ' | ' . SMS);
        $this->layout->view('result_email/index', $this->data);
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

        if ($id) {
            $this->data['email'] = $this->mail->get_single_email($id);

            if (!$this->data['email']) {
                redirect('exam/resultemail/index');
            }
        }

        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('email') . ' | ' . SMS);
        $this->layout->view('result_email/view', $this->data);
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
       
       $this->data['email'] = $this->mail->get_single_email($email_id);
       echo $this->load->view('result_email/get-single-email', $this->data);
    }
        
    /*****************Function _prepare_email_validation**********************************
    * @type            : Function
    * @function name   : _prepare_email_validation
    * @description     : Process "Email" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_email_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-attendance" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('receiver_type'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('receiver_id', $this->lang->line('receiver'), 'trim|required');
        $this->form_validation->set_rules('subject', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('body', $this->lang->line('email_body'), 'trim|required');
    }

       
    /*****************Function _get_posted_email_data**********************************
    * @type            : Function
    * @function name   : _get_posted_email_data
    * @description     : Prepare "Email" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_email_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'subject';
        $items[] = 'body';
        $data = elements($items, $_POST);

        $school = $this->mail->get_school_by_id($data['school_id']);
        
        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('exam/resultemail');
        }
        
        $data['academic_year_id'] = $school->academic_year_id;
        $data['sender_role_id'] = $this->session->userdata('role_id');
        $data['status'] = 1;
        $data['email_type'] = 'result';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();

        return $data;
    }

          
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Email" data from database                  
    *                    and unlink attachmnet document form server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $mail = $this->mail->get_single('emails', array('id' => $id));
        if ($this->mail->delete('emails', array('id' => $id))) {

            create_log('Has been deleted a Result Email : '.$mail->subject);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('exam/resultemail/index');
    }

    
        
    /*****************Function _send_email**********************************
    * @type            : Function
    * @function name   : _send_email
    * @description     : Process to send email to the users                  
    *                    
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    private function _send_email($data) {
        
        $school_id     = $data['school_id'];        
        $email_setting = $this->mail->get_single('email_settings', array('status' => 1, 'school_id'=>$school_id)); 

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
                
        
        $school = $this->mail->get_school_by_id($data['school_id']);
        
        $from_email = FROM_EMAIL;
        $from_name = FROM_NAME;
        if(!empty($email_setting)){
            $from_email = $email_setting->from_address;
            $from_name  = $email_setting->from_name;  
        }elseif(!empty($school)){
            $from_email = $school->email;
            $from_name  = $school->school_name;  
        }
      

        $class_id = $this->input->post('class_id');
        $receivers = '';
        
        $students = $this->mail->get_student_list($data['school_id'], $this->input->post('receiver_id'), $class_id, $school->academic_year_id);
        
        foreach ($students as $obj) {
        
            $message = '';   
     
            if($data['role_id'] == GUARDIAN){ 
                
                $guardian = $this->mail->get_single_guardian($data['school_id'], $obj->guardian_id); 
                $obj->name = $guardian->name;
                $obj->email = $guardian->email;
                $obj->id = $guardian->id;               
            }            
            
            $result = $this->mail->get_single('final_results',array('school_id'=>$data['school_id'], 'student_id'=> $obj->student_id, 'class_id'=>$class_id, 'academic_year_id'=> $school->academic_year_id));
           
           
            if(!empty($result) && $obj->email != ''){
                
                $grade = $this->mail->get_single('grades',array('school_id'=>$data['school_id'], 'id'=> $result->grade_id));

                $class_position = get_student_position($data['school_id'], $school->academic_year_id, $class_id, $obj->student_id);
                $section_position = get_student_position($data['school_id'], $school->academic_year_id, $class_id, $obj->student_id, $obj->section_id);
                
                $message .= '<br/><b>'.$this->lang->line('exam_final_result').'</b><br/><br/>'; 
                $message .= $this->lang->line('total_subject').' : '.$result->total_subject.'<br/>'; 
                $message .= $this->lang->line('exam_mark').' : '.$result->total_mark.'<br/>'; 
                $message .= $this->lang->line('total_obtain_mark'). ' : '.$result->total_obtain_mark.'<br/>'; 
                $message .= $this->lang->line('average_grade_point'). ' : '.$result->avg_grade_point.'<br/>'; 
                $message .= $this->lang->line('letter_grade').' : '.$grade->name.'<br/>'; 
                $message .= $this->lang->line('result'). ' : '. $this->lang->line($result->result_status).'<br/>'; 
                $message .= $this->lang->line('position_in_section') .' : '. $section_position.'<br/>'; 
                $message .= $this->lang->line('position_in_class') . ' : '. $class_position.'<br/>'; 
                $message .= $this->lang->line('remark').' : '. $result->remark.'<br/>'; 

                $body = get_formatted_body($data['body'], $data['role_id'], $obj->id);
                
                if (strpos($body, '[exam_result]') !== false) {
                    $body = str_replace('[exam_result]', $message, $body);
                }else{
                    $body = $body . ' ' . $message;
                } 
                    
                $receivers .= $obj->name.',';

                $this->email->from($from_email, $from_name);
                $this->email->reply_to($from_email, $from_name);

                $this->email->to($obj->email);
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
                    mail($obj->email, $data['subject'], $body, $headers);
                }
            }        
        }

        // update emails table 
        $this->mail->update('emails', array('receivers' => $receivers), array('id' => $data['email_id']));
    }

}