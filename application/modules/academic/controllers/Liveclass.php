<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Liveclass extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Liveclass_Model', 'liveclass', true);
        
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
    * @description     : Load "Live class List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null ) {

        check_permission(VIEW);

        $school_id = '';        
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }
        
        // for super admin      
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }
        
        if(!$school_id && $class_id){
            $class = $this->liveclass->get_single('classes', array('id'=>$class_id));
            $school_id = $class->school_id;
        }          
        
        $school = $this->liveclass->get_school_by_id($school_id);                
        $this->data['live_classes'] = $this->liveclass->get_live_class_list($class_id, $school_id, @$school->academic_year_id);
       
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->liveclass->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['class_list'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');
          
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id; 
        $this->data['schools'] = $this->schools; 
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_live_class') . ' | ' . SMS);
        $this->layout->view('live_class/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Liveclass" user interface                 
    *                    and process to store "Liveclass" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add($class_id = null) {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_live_class_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_live_class_data();

                $insert_id = $this->liveclass->insert('live_classes', $data);
                if ($insert_id) { 
                    $data['id'] = $insert_id;
                    // send student and guardian notification
                    if($data['send_notification']){
                        $this->_send_email_notification($data);
                        $this->_send_sms_notification($data);
                    }
                    
                    success($this->lang->line('insert_success'));
                    redirect('academic/liveclass/index/' . $data['class_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('academic/liveclass/add/' . $data['class_id']);
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
        
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
                
        $this->data['live_classes'] = $this->liveclass->get_live_class_list($class_id);
        //$school = $this->liveclass->get_school_by_id($condition['school_id']); 
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition['school_id'] = $this->session->userdata('school_id');            
            $this->data['classes'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->liveclass->get_list('teachers', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['class_list'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');       
        $this->data['class_id'] = $class_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('live_class/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Liveclass" user interface                 
    *                    with populate "Exam Liveclass" value 
    *                    and process to update "Exa Liveclass" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/liveclass/index');  
        }
        
        if ($_POST) {
            $this->_prepare_live_class_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_live_class_data();
                $updated = $this->liveclass->update('live_classes', $data, array('id' => $this->input->post('id')));

                if ($updated) {              
                    success($this->lang->line('update_success'));
                    redirect('academic/liveclass/index/'.$data['class_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('academic/liveclass/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['live_class'] = $this->liveclass->get_single('live_classes', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['live_class'] = $this->liveclass->get_single('live_classes', array('id' => $id));

            if (!$this->data['live_class']) {
                redirect('academic/liveclass/index');
            }
        }
        
        $class_id = $this->data['live_class']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
                
        $this->data['live_classes'] = $this->liveclass->get_live_class_list($class_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');            
            $this->data['teachers'] = $this->liveclass->get_list('teachers', $condition, '', '', '', 'id', 'ASC');
        }        
        
        $this->data['class_list'] = $this->liveclass->get_list('classes', $condition, '','', '', 'id', 'ASC');
       
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $this->data['live_class']->school_id;
        $this->data['school_id'] = $this->data['live_class']->school_id;
        
        $this->data['schools'] = $this->schools; 
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('live_class/index', $this->data);
    }

   
               
    /*****************Function get_single_live_class**********************************
     * @type            : Function
     * @function name   : get_single_live_class
     * @description     : "Load single live class information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_live_class(){
        
       $live_class_id = $this->input->post('live_class_id');
       
      $this->data['live_class'] = $this->liveclass->get_single_live_class($live_class_id);   
       echo $this->load->view('live_class/get-single-live-class', $this->data);
    }
    
    
    /*****************Function _prepare_live_class_validation**********************************
    * @type            : Function
    * @function name   : _prepare_live_class_validation
    * @description     : Process "Exam Liveclass" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_live_class_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('teacher_id', $this->lang->line('teacher'), 'trim|required|callback_teacher_id');
       
        $this->form_validation->set_rules('class_type', $this->lang->line('live_class_type'), 'trim|required');
        if($this->input->post('class_type') == 'zoom'){
            $this->form_validation->set_rules('meeting_id', $this->lang->line('meeting_id'), 'trim|required');
            $this->form_validation->set_rules('meeting_password', $this->lang->line('meeting_password'), 'trim|required');
        }
        
        $this->form_validation->set_rules('class_date', $this->lang->line('class_date'), 'trim|required');
        $this->form_validation->set_rules('start_time', $this->lang->line('start_time'), 'trim|required');
        $this->form_validation->set_rules('end_time', $this->lang->line('end_time'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function teacher_id**********************************
    * @type            : Function
    * @function name   : teacher_id
    * @description     : Unique check for "teacher" in live class data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function teacher_id() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $teacher_id = $this->input->post('teacher_id');
        $class_date = $this->input->post('class_date');
        $start_time = $this->input->post('start_time');
        
        if ($this->input->post('id') == '') {
            $schedule = $this->liveclass->duplicate_check($school_id, $class_id, $section_id, $subject_id, $teacher_id, $class_date, $start_time);
            if ($schedule) {
                $this->form_validation->set_message('teacher_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $schedule = $this->liveclass->duplicate_check($school_id, $class_id, $section_id, $subject_id, $teacher_id, $class_date, $start_time, $this->input->post('id'));
            if ($schedule) {
                $this->form_validation->set_message('teacher_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }


    
    /*****************Function _get_posted_live_class_data**********************************
    * @type            : Function
    * @function name   : _get_posted_live_class_data
    * @description     : Prepare "Exam Liveclass" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_live_class_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'subject_id';
        $items[] = 'teacher_id';
        $items[] = 'class_type';
        $items[] = 'meeting_id';
        $items[] = 'meeting_password';
        $items[] = 'start_time';
        $items[] = 'end_time';
        $items[] = 'send_notification';
        $items[] = 'note';
        
        $data = elements($items, $_POST);
        $data['class_date'] = date('Y-m-d', strtotime($this->input->post('class_date')));

        if($data['class_type'] == 'jitsi'){
            $data['meeting_id'] = '';
            $data['meeting_password'] = '';
        }
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $school = $this->liveclass->get_school_by_id($data['school_id']);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('academic/liveclass/index');   
            }            
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }

    
    
   public function _send_email_notification($data = null) { 
          
            $school_id = $data['school_id'];
            $email_setting = $this->db->get_where('email_settings', array('status' => 1, 'school_id'=>$school_id))->row(); 
                    
            if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = $email_setting->smtp_host;
                $config['smtp_port']    = $email_setting->smtp_port;
                $config['smtp_timeout'] = $email_setting->smtp_timeout ? $email_setting->smtp_timeout  : 5;
                $config['smtp_user']    = $email_setting->smtp_user;
                $config['smtp_pass']    = $email_setting->smtp_pass;
                $config['smtp_crypto']  = $email_setting->smtp_crypto ? $email_setting->smtp_crypto  : 'tls';
                $config['mailtype'] = $email_setting->mail_type ? $email_setting->mail_type  : 'html';
                $config['charset']  = $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
                $config['priority']  = $email_setting->priority ? $email_setting->priority  : '3';

            }elseif(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                $config['protocol'] = $email_setting->mail_protocol;
                $config['mailpath'] = '/usr/sbin/'.$email_setting->mail_protocol; 
                $config['mailtype'] = $email_setting->mail_type ? $email_setting->mail_type  : 'html';
                $config['charset']  = $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
                $config['priority']  = $email_setting->priority ? $email_setting->priority  : '3';

            }else{// default    
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail'; 
            }                            

            $config['wordwrap'] = TRUE;            
            $config['newline']  = "\r\n";            

            $this->load->library('email');             
            $this->email->initialize($config);

            $from_email = FROM_EMAIL;
            $from_name  = FROM_NAME;                      
            $school = $this->db->get_where('schools', array('status' => 1, 'id'=>$school_id))->row();
            $school_name = $school->school_name;
                        
            if(!empty($email_setting)){
                $from_email = $email_setting->from_address;
                $from_name  = $email_setting->from_name;  
            }elseif(!empty($school)){
                $from_email = $school->email;
                $from_name  = $school->school_name;  
            }
            
            $students = $this->liveclass->get_student_list($data['school_id'], $data['class_id'], $data['section_id'], $data['academic_year_id'] );
            $live_class = $this->liveclass->get_single_live_class($data['id']);  
            
            foreach ($students as $obj) {                
           
                if($obj->email != ''){
                    
                    $this->email->from($from_email, $from_name);
                    $this->email->to($obj->email);
                    $subject = $this->lang->line('live_class'). ' '. $this->lang->line('for') . ' ' .$school_name;
                    $this->email->subject($subject);       

                    $message = $this->lang->line('hi'). ' '. $obj->name.',';
                    $message .= '<br/>';
                    $message .= $this->lang->line('following_is_your_live_class_schedule');
                    $message .= '<br/><br/>';
                    $message .= $this->lang->line('class').': ' . $live_class->class_name;
                    $message .= '<br/>';
                    $message .= $this->lang->line('section'). ': ' . $live_class->section;
                    $message .= '<br/>';
                    $message .= $this->lang->line('subject'). ': ' . $live_class->subject;
                    $message .= '<br/>';
                    $message .= $this->lang->line('teacher'). ': ' . $live_class->teacher;
                    $message .= '<br/>';
                    $message .= $this->lang->line('class_date'). ': ' . $live_class->class_date;
                    $message .= '<br/>';
                    $message .= $this->lang->line('time'). ': ' . $live_class->start_time .' to '.  $live_class->end_time;
                    $message .= '<br/>';
                    $message .= $this->lang->line('note'). ': ' . $live_class->note;
                    $message .= '<br/>';
                    $message .= $this->lang->line('login').' : <a href="'.site_url('login').'"> '.$this->lang->line('login_to_school').' </a><br/>';      
                    $message .= 'OR: '.site_url('login');      
                    $message .= '<br/><br/>';

                    $message .= $this->lang->line('thank_you').'<br/>';
                    $message .= $from_name;

                    $this->email->message($message);           

                    if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                        $this->email->send(); 
                    }else if(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                        $this->email->send();
                    }else{
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                        $headers .= "From:  $from_name < $from_email >\r\n";
                        $headers .= "Reply-To:  $from_name < $from_email >\r\n"; 
                        mail($obj->email, $subject, $message, $headers);
                    } 
                
                }
                
                if($obj->g_email != ''){
                    
                    $this->email->from($from_email, $from_name);
                    $this->email->to($obj->g_email);
                    $subject = $this->lang->line('live_class'). ' '. $this->lang->line('for') . ' ' .$school_name;
                    $this->email->subject($subject);       

                    $message = $this->lang->line('hi'). ' '. $obj->name.',';
                    $message .= '<br/>';
                    $message .= $this->lang->line('following_is_your_child_live_class_schedule');
                    $message .= '<br/><br/>';
                    $message .= $this->lang->line('class').': ' . $live_class->class_name;
                    $message .= '<br/>';
                    $message .= $this->lang->line('section'). ': ' . $live_class->section;
                    $message .= '<br/>';
                    $message .= $this->lang->line('subject'). ': ' . $live_class->subject;
                    $message .= '<br/>';
                    $message .= $this->lang->line('teacher'). ': ' . $live_class->teacher;
                    $message .= '<br/>';
                    $message .= $this->lang->line('class_date'). ': ' . $live_class->class_date;
                    $message .= '<br/>';
                    $message .= $this->lang->line('time'). ': ' . $live_class->start_time .' to '.  $live_class->end_time;
                    $message .= '<br/>';
                    $message .= $this->lang->line('note'). ': ' . $live_class->note;
                    $message .= '<br/>';
                    $message .= $this->lang->line('login').' : <a href="'.site_url('login').'"> '.$this->lang->line('login_to_school').' </a><br/>';      
                    $message .= 'OR: '.site_url('login');      
                    $message .= '<br/><br/>';

                    $message .= $this->lang->line('thank_you').'<br/>';
                    $message .= $from_name;

                    $this->email->message($message);           

                    if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                        $this->email->send(); 
                    }else if(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                        $this->email->send();
                    }else{
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                        $headers .= "From:  $from_name < $from_email >\r\n";
                        $headers .= "Reply-To:  $from_name < $from_email >\r\n"; 
                        mail($obj->g_email, $subject, $message, $headers);
                    } 
                
                }
            }
    }
    
        
    /*****************Function _send_sms_notification**********************************
    * @type            : Function
    * @function name   : _send_sms_notification
    * @description     : Process to send SMS to the users                  
    *                    
    * @param           : $data array() value
    * @return          : null 
    * ********************************************************** */
    private function _send_sms_notification($data) {
       
        
        $students = $this->liveclass->get_student_list($data['school_id'], $data['class_id'], $data['section_id'], $data['academic_year_id'] );
        $live_class = $this->liveclass->get_single_live_class($data['id']);   
        
        // get active sms gateway for the school
        $sms_gateway = $this->db->get_where('sms_settings', array('status' => 1, 'school_id'=>$data['school_id']))->row(); 
        $gateway = '';

        if ($sms_gateway->clickatell_status) {
            $gateway = 'clicktell';
        }elseif ($sms_gateway->twilio_status) {
            $gateway = 'twilio';
        }elseif ($sms_gateway->bulk_status) {
            $gateway = 'bulk';
        }elseif ($sms_gateway->msg91_status) {
            $gateway = 'msg91';
        }elseif ($sms_gateway->plivo_status) {
            $gateway = 'plivo';
        }elseif ($sms_gateway->textlocal_status) {
            $gateway = 'text_local';
        }elseif ($sms_gateway->smscountry_status) {
            $gateway = 'sms_country';
        }elseif ($sms_gateway->betamsm_status) {
            $gateway = 'beta_sms';
        }elseif ($sms_gateway->bulk_pk_status) {
            $gateway = 'bulk_pk';
        }elseif ($sms_gateway->cluster_status) {
            $gateway = 'sms_custer';
        }elseif ($sms_gateway->alpha_status) {
            $gateway = 'alpha_net';
        }elseif ($sms_gateway->bdbulk_status) {
            $gateway = 'bd_bulk';
        }elseif ($sms_gateway->mim_status) {
            $gateway = 'mim_sms';
        }
        
        if($this->sms_gateway($gateway)){

            foreach ($students as $obj) {

                // student sms
                if($obj->phone != ''){                    
                    $message = $this->lang->line('hi').' '. $obj->name. ', ';
                    $message .= $this->lang->line('following_is_your_live_class_schedule'). '. ';
                    $message .= $this->lang->line('class').': '.$$live_class->class_name. ', ';
                    $message .= $this->lang->line('section').': '.$live_class->section. ', ';
                    $message .= $this->lang->line('subject').': '.$live_class->subject. ', ';
                    $message .= $this->lang->line('class_date').': '.$live_class->class_date. ', ';
                    $message .= $this->lang->line('time').': '.$live_class->start_time. ' to '.$live_class->end_time. ',';
                    $message .= $this->lang->line('thank_you').' '.$live_class->school_name;
                    $this->_send($gateway, $obj->phone, $message);           
                }
                // guardian phone
                if($obj->g_phone != ''){ 
                    $message = $this->lang->line('hi').' '. $obj->g_name. ', ';
                    $message .= $this->lang->line('following_is_your_child_live_class_schedule'). '. ';
                    $message .= $this->lang->line('class').': '.$$live_class->class_name. ', ';
                    $message .= $this->lang->line('section').': '.$live_class->section. ', ';
                    $message .= $this->lang->line('subject').': '.$live_class->subject. ', ';
                    $message .= $this->lang->line('class_date').': '.$live_class->class_date. ', ';
                    $message .= $this->lang->line('time').': '.$live_class->start_time. ' to '.$live_class->end_time. ',';
                    $message .= $this->lang->line('thank_you').' '.$live_class->school_name;
                    $this->_send($gateway, $obj->g_phone, $message);             
                }
            }

        }      
    }
    
    public function sms_gateway($getway) {

        if ($getway == "clicktell") {
            if ($this->clickatell->ping() == TRUE) {
                return TRUE;
            } else {
                return FALSE;
            }
        } elseif ($getway == 'twilio') {            
            $get = $this->twilio->get_twilio();
            $ApiVersion = $get['version'];
            $AccountSid = $get['accountSID'];
            $check = $this->twilio->request("/$ApiVersion/Accounts/$AccountSid/Calls");

            if ($check->IsError) {
                return FALSE;
            }
            return TRUE;
        } elseif ($getway == 'bulk') {
            if ($this->bulk->ping() == TRUE) {
                return TRUE;
            } else {
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
            
            $response = $this->twilio->send($phone, $message);
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
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Liveclass" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('academic/liveclass/index');    
        }
        
        $live_class = $this->liveclass->get_single('live_classes', array('id' => $id));
        
        if ($this->liveclass->delete('live_classes', array('id' => $id))) {      
            success($this->lang->line('delete_success'));            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('academic/liveclass/index/'.$live_class->class_id);
    }
    
    
        
    
    /*****************Function start**********************************
    * @type            : Function
    * @function name   : start
    * @description     : start "Liveclass" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function start($id = null) {

        check_permission(VIEW);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('academic/liveclass/index');    
        } 
        
        $this->data['live_class'] = $this->liveclass->get_single_live_class($id); 
                     
        if (strtotime($this->data['live_class']->class_date) == strtotime(date('Y-m-d')) && (strtotime(date('Y-m-d') .' '. $this->data['live_class']->start_time)) <= (strtotime(date('Y-m-d g:i A'))) && (strtotime(date('Y-m-d') .' '. $this->data['live_class']->end_time)) >= (strtotime(date('Y-m-d g:i A')))) {
           
            $this->data['title_for_layout'] = $this->lang->line('live_class');
            $this->data['zoom_info'] = $this->liveclass->get_single('schools', array('id' => $this->data['live_class']->school_id));                
           
           
            if($this->data['live_class']->class_type == 'zoom'){ 
                
                $this->load->view('live_class/zoom_class', $this->data);
                
            }else if($this->data['live_class']->class_type == 'jitsi'){
                
                $this->layout->view('live_class/jitsi_class', $this->data);
                
            }
            
        }else if (strtotime($this->data['live_class']->class_date) < strtotime(date('Y-m-d')) || (strtotime(date('Y-m-d') .' '. $this->data['live_class']->end_time)) < (strtotime(date('Y-m-d g:i A')))) {
             error($this->lang->line('expire'));
             redirect('academic/liveclass/index/'.$this->data['live_class']->class_id);    
            
        }else{
            error($this->lang->line('waiting'));
            redirect('academic/liveclass/index/'.$this->data['live_class']->class_id);  
        }
        
    }    

}