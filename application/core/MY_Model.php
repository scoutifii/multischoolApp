<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    // insert new data

    function insert($table_name, $data_array) {

        $this->db->insert($table_name, $data_array);
        return $this->db->insert_id();
    }

    // insert new data

    function insert_batch($table_name, $data_array) {

        $this->db->insert_batch($table_name, $data_array);
        return $this->db->insert_id();
    }

    // update data by index

    function update($table_name, $data_array, $index_array) {

        $this->db->update($table_name, $data_array, $index_array);
        return $this->db->affected_rows();
    }

    // delete data by index

    function delete($table_name, $index_array) {
        $this->db->delete($table_name, $index_array);
        return $this->db->affected_rows();
    }

    public function get_list($table_name, $index_array, $columns = null, $limit = null, $offset = 0, $order_field = null, $order_type = null) {

        if ($columns)
            $this->db->select($columns);

        if ($limit)
            $this->db->limit($limit, $offset);

        if ($order_type) {
            $this->db->order_by($order_field, $order_type);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        return $this->db->get_where($table_name, $index_array)->result();
    }

    // get data list by index order

    function get_list_order($table_name, $index_array, $order_array, $limit = null) {

        if ($limit) {
            $this->db->limit($limit);
        }
        if ($order_array) {
            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {
            $this->db->order_by('created', 'desc');
        }
        return $this->db->get_where($table_name, $index_array)->result();
    }

    // get single data by index

    function get_single($table_name, $index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $row = $this->db->get_where($table_name, $index_array)->row();
        return $row;
    }

    function get_single_random($table_name, $index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('rand()');
        $this->db->limit(1);
        $row = $this->db->get_where($table_name, $index_array)->row();
        return $row;
    }

    // get number of rows in database

    function count_all($table_name, $index_array = null) {

        if ($index_array) {
            $this->db->where($index_array);
        }
        return $this->db->count_all_results($table_name);
    }

    // get data with paging

    function get_paged_list($table_name, $index_array, $url, $segment, $offset = 0, $order_by = null) {

        $result = array('rows' => array(), 'total_rows' => 0);
        $this->load->library('pagination');
        $limit = $this->config->item('admin_per_page');
        $this->db->where($index_array);
        $this->db->order_by('id', 'desc');

        $result['rows'] = $this->db->get($table_name, $limit, $offset)->result();
        $this->db->where($index_array);
        $result['total_rows'] = $total_rows = $this->db->count_all_results($table_name);
        $config['uri_segment'] = $segment;
        $config['base_url'] = site_url() . $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->config->item('admin_per_page');
        $this->pagination->initialize($config);
        $result['pagination'] = $this->pagination->create_links();
        return $result;
    }

// get data with paging

    function get_paged_list_order($table_name, $index_array, $order_array, $limit = 10, $offset = 0) {

        $result = array('rows' => array(), 'total_rows' => 0);
        if ($order_array) {
            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {
            $this->db->order_by('created', 'desc');
        }

        $this->db->where($index_array);
        $result['rows'] = $this->db->get($table_name, $limit, $offset)->result();
        $this->db->where($index_array);
        $result['total_rows'] = $this->db->count_all_results($table_name);
        return $result;
    }

    public function send_email($mail_info) {

                
        $school_id     = $mail_info['school_id'];  
        $email_setting = $this->db->get_where('email_settings', array('status' => 1, 'school_id'=>$school_id)); 

        if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
            $config['protocol']     = 'smtp';
            $config['smtp_host']    = $email_setting->smtp_host;
            $config['smtp_port']    = $email_setting->smtp_port;
            $config['smtp_timeout'] = $email_setting->smtp_timeout ? $email_setting->smtp_timeout  : 5;
            $config['smtp_user']    = $email_setting->smtp_user;
            $config['smtp_pass']    = $email_setting->smtp_pass;
            $config['smtp_crypto']  = $email_setting->smtp_crypto ? $email_setting->smtp_crypto  : 'tls';

        }elseif(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
            $config['protocol'] = $email_setting->mail_protocol;
            $config['mailpath'] = '/usr/sbin/'.$email_setting->mail_protocol; 

        }else{// default    
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/'.$email_setting->mail_protocol; 
        }                              

        $config['mailtype'] = $email_setting->mail_type ? $email_setting->mail_type  : 'text';
        $config['wordwrap'] = TRUE;            
        $config['charset']  = $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
        $config['priority']  = $email_setting->priority ? $email_setting->priority  : '3';
        $config['newline']  = "\r\n";            

        $this->load->library('email');
        $this->email->initialize($config);  

        $from = $mail_info['from'] ? $mail_info['from'] : '';
        $from_name = $mail_info['from_name'] ? $mail_info['from_name'] : '';
        $to = $mail_info['to'] ? $mail_info['to'] : 'yousuf361@gmail.com';
        $cc = $mail_info['cc'] ? $mail_info['cc'] : '';
        $bcc = $mail_info['bcc'] ? $mail_info['bcc'] : '';
        $subject = $mail_info['subject'] ? $mail_info['subject'] : '';
        $message = $mail_info['message'] ? $mail_info['message'] : '';
        $this->email->from($from, $from_name);
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($message);
        return ($this->email->send()) ? TRUE : FALSE;

        //echo $this->email->print
    }

    // get single data by index

    function get_single_order($table_name, $index_array, $order_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->limit(1);
        if ($order_array) {
            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {
            $this->db->order_by('created', 'desc');
        }
        $row = $this->db->get_where($table_name, $index_array)->row();

        return $row;
    }


    public function get_table_fields($table) {

        return $this->db->list_fields($table);
    }
    
    

    public function create_user(){
        
        $data = array();
        $data['district_id']  = $this->input->post('district_id') ? $this->input->post('district_id') : 0;
        $data['school_id']  = $this->input->post('school_id') ? $this->input->post('school_id') : 0;
        $data['role_id']    = $this->input->post('role_id');
        $data['password']   = md5($this->input->post('password'));
        $data['temp_password'] = base64_encode($this->input->post('password'));
        $data['username']   = $this->input->post('username');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status']     = 1; // by default would be able to login
        $this->db->insert('users', $data);        
        $user_id = $this->db->insert_id();
        
        // Process Sending email/ sms with login info
        $data['name']  = $this->input->post('name');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['password'] = $this->input->post('password');
        $this->_send_email($data);
        if($data['school_id']){
           $this->_send_sms($data);
        }
        
        return $user_id;
    }
    
    
    public function create_custom_user($info = null){
        
        $data = array();
        $data['district_id']  = $this->input->post('district_id') ? $this->input->post('district_id') : 0;
        $data['school_id']  = $this->input->post('school_id') ? $this->input->post('school_id') : 0;
        $data['role_id']    = $info['role_id'];
        $data['password']   = md5($info['password']);
        $data['temp_password'] = base64_encode($info['password']);
        $data['username']   = $info['username'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status']     = 1; // by default would be able to login
        $this->db->insert('users', $data);        
        $user_id = $this->db->insert_id();
        
        // Process Sending email/ sms with login info
        $data['name']  = $info['name'];
        $data['email'] = $info['email'];
        $data['phone'] = $info['phone'];
        $data['password'] = $info['password'];
        $this->_send_email($data);
        if($data['school_id']){
            $this->_send_sms($data);
        }
        
        return $user_id;
    }
    
    
    public function _send_email($data = null) {

        
        if($data['email']){         
          
            $school_id = $data['school_id'] ? $data['school_id'] : 0;
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
            $school_name = SMS;
            $to         = $data['email'];
            $username   = $data['username'];
            $password   = $data['password'];
           
            if($school_id){            
                $school = $this->db->get_where('schools', array('status' => 1, 'id'=>$school_id))->row();
                $school_name = $school->school_name;
            }
            
            if(!empty($email_setting)){
                $from_email = $email_setting->from_address;
                $from_name  = $email_setting->from_name;  
            }elseif(!empty($school)){
                $from_email = $school->email;
                $from_name  = $school->school_name;  
            }
            
            $this->email->from($from_email, $from_name);
            $this->email->to($to);
            $subject = $school_name. ' '. $this->lang->line('user_credential');
            $this->email->subject($subject);       

            $message = $this->lang->line('hi'). ' '. $data['name'].',';
            $message .= '<br/>';
            $message .= $this->lang->line('following_is_your_login_credential');
            $message .= '<br/><br/>';
            $message .= $this->lang->line('username').': ' . $username;
            $message .= '<br/>';
            $message .= $this->lang->line('password'). ': ' . $password;
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
                mail($to, $subject, $message, $headers);
            }          
        }
    }
    
    public function _send_sms($data = null){
        
        if($data['phone']){ 

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
                
                $phone = '+'.$data['phone'];
                $username   = $data['username'];
                $password   = $data['password'];
                $school_id  = $data['school_id'];
                $setting = $this->db->get_where('schools', array('status' => 1, 'id'=>$school_id))->row();              
                $message = $this->lang->line('hi').' '. $data['name']. ', '.$this->lang->line('following_is_your_login_credential'). '. ' .$this->lang->line('username').': '.$username. ', '.$this->lang->line('password').': '.$password. ', '.$this->lang->line('for').' '.$setting->school_name;
                $this->_send($gateway, $phone, $message);
                
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
    

    public function get_custom_id($table, $prefix)
    {
      $max_id = '';
      $this->db->select_max('id');
      $max_id = $this->db->get($table)->row()->id;
      
      if(isset($max_id) && $max_id > 0)
      {
        $max_id = $max_id+1;
      }else{
          $max_id = 1;
      }
      
      if(!$max_id){
        $max_id = '0000'.$max_id;
      }elseif($max_id > 0 && $max_id < 10){
          $max_id = '0000'.$max_id;      
      }elseif($max_id >= 10 && $max_id < 100){
          $max_id = '000'.$max_id;
      }elseif($max_id >= 100 && $max_id < 1000){
          $max_id = '00'.$max_id;
      }elseif($max_id >= 1000 && $max_id < 10000){
          $max_id = '0'.$max_id;
      }else{
          $max_id = $max_id;
      }      
      return $prefix.$max_id;
   }
   
    public function get_school_by_id($school_id){
       
       if(!$school_id){
           return array();
       }
       return $this->db->get_where('schools', array('id'=>$school_id))->row();
   }

   public function get_region_by_id($region_id){
       
       if(!$region_id){
           return array();
       }
       return $this->db->get_where('regions', array('id'=>$region_id))->row();
   }

   public function get_district_by_id($district_id){
       
       if(!$district_id){
           return array();
       }
       return $this->db->get_where('district', array('id'=>$district_id))->row();
   }
    
}

?>