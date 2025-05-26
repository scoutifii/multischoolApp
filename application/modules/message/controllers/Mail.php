<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Mail.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Mail
 * @description     : Manage email which are send to all type of system users.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Mail extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mail_Model', 'mail', true);       
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Sent Mail List" user interface                 
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
            $this->data['classes'] = $this->mail->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['roles'] = $this->mail->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['emails'] = $this->mail->get_email_list($school_id);

        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_email') . ' | ' . SMS);
        $this->layout->view('mail/index', $this->data);
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
                    
                    create_log('Has been sent an Email : '.$data['subject']);
                    
                    success($this->lang->line('email_send_success'));
                    redirect('message/mail/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('email_send_failed'));
                    redirect('message/mail/add');
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
            $this->data['classes'] = $this->mail->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['roles'] = $this->mail->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['emails'] = $this->mail->get_email_list();
        
        $this->data['schools'] = $this->schools;

        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('send'). ' | ' . SMS);
        $this->layout->view('mail/index', $this->data);
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
       echo $this->load->view('mail/get-single-email', $this->data);
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
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('receiver_type'), 'trim|required');
        
        if ($this->input->post('role_id') == STUDENT) {
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        
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
            redirect('message/mail/index');
        }
        $data['academic_year_id'] = $school->academic_year_id;
        
        $data['sender_role_id'] = $this->session->userdata('role_id');        
        $data['status'] = 1;
        $data['email_type'] = 'general';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();


        if ($_FILES['attachment']['name']) {
            $data['attachment'] = $this->_upload_attachment();
        }

        return $data;
    }

           
    /*****************Function _upload_attachment**********************************
    * @type            : Function
    * @function name   : _upload_attachment
    * @description     : Process to upload email atachmnet document into server                  
    *                       
    * @param           : null
    * @return          : $return_attachment string value 
    * ********************************************************** */
    private function _upload_attachment() {

        $prev_attachment = $this->input->post('prev_attachment');
        $attachment = $_FILES['attachment']['name'];
        $attachment_type = $_FILES['attachment']['type'];
        $return_attachment = '';

        if ($attachment != "") {

            $destination = 'assets/uploads/email-attachment/';

            $attachment_type = explode(".", $attachment);
            $extension = strtolower($attachment_type[count($attachment_type) - 1]);
            $attachment_path = 'attachment-' . time() . '-sms.' . $extension;

            move_uploaded_file($_FILES['attachment']['tmp_name'], $destination . $attachment_path);

            // need to unlink previous attachment
            if ($prev_attachment != "") {
                if (file_exists($destination . $prev_attachment)) {
                    @unlink($destination . $prev_attachment);
                }
            }

            $return_attachment = $attachment_path;
        } else {
            $return_attachment = $prev_attachment;
        }

        return $return_attachment;
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

            // delete ttachment image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/email-attachment/' . $mail->attachment)) {
                @unlink($destination . '/email-attachment/' . $mail->attachment);
            }
            
            create_log('Has been deleted an Email : '.$mail->subject);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('message/mail/index/'.$mail->school_id);
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

                
        $school     = $this->mail->get_school_by_id($data['school_id']); 
        $email_setting = $this->mail->get_single('email_settings', array('status' => 1, 'school_id'=> $data['school_id']));
        
        $from_email = FROM_EMAIL;
        $from_name  = FROM_NAME;
        if(!empty($email_setting)){
            $from_email = $email_setting->from_address;
            $from_name  = $email_setting->from_name;  
        }elseif(!empty($school)){
            $from_email = $school->email;
            $from_name  = $school->school_name;  
        }

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
        
        // from name and from email setting..............
      

        $receivers = '';
        $users = $this->mail->get_user_list($data['school_id'], $data['role_id'], $this->input->post('receiver_id'), $this->input->post('class_id'));

        
        foreach ($users as $obj) {            
            
                       
            if($obj->email != ''){ 
               
                $data['body'] = get_formatted_body($data['body'], $data['role_id'], $obj->id);
                $receivers .= $obj->name.',';

                $this->email->from($from_email, $from_name);
                $this->email->reply_to($from_email, $from_name);

                $this->email->to($obj->email);
                
                $this->email->subject($data['subject']);
                $this->email->message($data['body']);

                if (isset($data['attachment'])) {
                    $attachment = UPLOAD_PATH . '/email-attachment/' . $data['attachment'];
                    $this->email->attach($attachment);
                }   
                
                if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                     $this->email->send(); 
                }else if(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                     $this->email->send(); 
                }else{
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                    $headers .= "From:  $from_name < $from_email >\r\n";
                    $headers .= "Reply-To:  $from_name < $from_email >\r\n"; 
                    mail($obj->email, $data['subject'], $data['body'], $headers);
                }
            }
        }
    
        // update emails table 
        $this->mail->update('emails', array('receivers' => $receivers), array('id' => $data['email_id'], 'school_id'=>$data['school_id']));
    }

}