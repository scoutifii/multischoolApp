<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Auth extends CI_Controller {

    public $data = array();
    public $global_setting = array();
    public function __construct() {

        parent::__construct();
        $this->load->model('Auth_Model', 'auth', true);
        $this->load->helper('totp');
        $this->global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();        
        
        
        if(!empty($this->global_setting) && $this->global_setting->language){             
            $this->lang->load($this->global_setting->language);             
        }else{
           $this->lang->load('english');
        }
    }

    /****************Function login**********************************
     * @type            : Function
     * @function name   : login
     * @description     : Authenticatte when uset try lo login. 
     *                    if autheticated redirected to logged in user dashboard.
     *                    Also set some session date for logged in user.   
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function login() {

        if ($_POST) {
         
            $data['username'] = $this->input->post('username');           
            $data['password'] = md5($this->input->post('password'));

            $login = $this->auth->get_single('users', $data);
           
            if (!empty($login)) {
              
                // check school status
                
                if (!in_array($login->role_id, array(SUPER_ADMIN, DISTRICT_ADMIN))) {
                    $school = $this->auth->get_single('schools', array('status' => 1, 'id'=>$login->school_id));
                    
                    if (empty($school)) {
                        $this->session->set_flashdata('error', $this->lang->line('invalid_login'));
                        redirect('login');
                    }
                }
                
                // check user active status
                if (!$login->status) {
                    $this->session->set_flashdata('error', $this->lang->line('user_active_status'));
                    redirect('login');
                }

                // check is setting role permission by admin
                $privileges = $this->auth->get_list('privileges', array('role_id' => $login->role_id));
                if (empty($privileges)) {
                    $this->session->set_flashdata('error', $this->lang->line('privilege_not_setting'));
                    redirect('login');
                }

                if (!empty($login->two_factor_enabled) && !empty($login->two_factor_secret)) {
                    $this->session->set_userdata('pending_login_id', $login->id);
                    $this->session->set_userdata('pending_login_username', $login->username);
                    $this->session->set_flashdata('success', 'Enter the code from your authenticator app.');
                    redirect('auth/twofactor');
                }

                $this->complete_login($login);
                
            } else {
                
                $this->session->set_flashdata('error', $this->lang->line('invalid_login'));
                redirect('login');
            }
        }
        redirect();
    }

    private function complete_login($login) {
        if ($login->role_id == SUPER_ADMIN) {
            $profile = $this->auth->get_single('system_admin', array('user_id' => $login->id));
        } elseif ($login->role_id == DISTRICT_ADMIN) {
            $profile = $this->auth->get_single('district_admin', array('user_id' => $login->id));
            if (isset($profile->district_id)) {
                $this->session->set_userdata('district_id', $profile->district_id);
                $district = $this->auth->get_single('district', array('id' => $profile->district_id));
                if (isset($district->district_name)) {
                    $this->session->set_userdata('district_name', $district->district_name);
                }
            }
        } elseif ($login->role_id == STUDENT) {
            $profile = $this->auth->get_single_student($login->id);
            if (isset($profile->class_id)) {
                $this->session->set_userdata('class_id', $profile->class_id);
            }
            if (isset($profile->section_id)) {
                $this->session->set_userdata('section_id', $profile->section_id);
            }
        } elseif ($login->role_id == GUARDIAN) {
            $profile = $this->auth->get_single('guardians', array('user_id' => $login->id));
        } elseif ($login->role_id == TEACHER) {
            $profile = $this->auth->get_single('teachers', array('user_id' => $login->id));
        } else {
            $profile = $this->auth->get_single('employees', array('user_id' => $login->id));
        }

        if (isset($profile->name)) {
           $this->session->set_userdata('name', $profile->name);
        }
        if (isset($profile->phone)) {
            $this->session->set_userdata('phone', $profile->phone);
        }
        if (isset($profile->email)) {
            $this->session->set_userdata('email', $profile->email);
        }
        if (isset($profile->photo)) {
            $this->session->set_userdata('photo', $profile->photo);
        }
        if (isset($profile->user_id)) {                
            $this->session->set_userdata('user_id', $profile->user_id);
        }
        if (isset($profile->id)) {
            $this->session->set_userdata('profile_id', $profile->id);
        }

        $this->session->set_userdata('id', $login->id);
        $this->session->set_userdata('role_id', $login->role_id);
        $this->session->set_userdata('username', $login->username);
        $this->session->set_userdata('school_id', $login->school_id);

        if (!in_array($login->role_id, array(SUPER_ADMIN, DISTRICT_ADMIN))) {
            $school = $this->auth->get_single('schools', array('status' => 1, 'id'=>$login->school_id));
            if (isset($school->school_name)) {
                $this->session->set_userdata('school_name', $school->school_name);
            }
            $this->session->set_userdata('theme', isset($school->theme_name) ? $school->theme_name : '');
            $this->session->set_userdata('front_school_id', $login->school_id);
            $this->session->set_userdata('academic_year_id', isset($school->academic_year_id) ? $school->academic_year_id : '');
        } elseif ($login->role_id == SUPER_ADMIN) {
            $global_setting = $this->auth->get_single('global_setting', array());
            $this->session->set_userdata('theme', isset($global_setting->theme_name) ? $global_setting->theme_name : '');
        }

        $this->auth->update('users', array('last_logged_in' => date('Y-m-d H:i:s')), array('id' => $login->id));
        success($this->lang->line('login_success'));
        create_log('Has been logged in');
        redirect('dashboard/index');
    }

    public function twofactor() {
        $pendingId = $this->session->userdata('pending_login_id');
        if (empty($pendingId)) {
            redirect('login');
        }

        if ($_POST) {
            $code = trim($this->input->post('code'));
            $login = $this->auth->get_single('users', array('id' => $pendingId));

            if (empty($login) || empty($login->two_factor_enabled) || empty($login->two_factor_secret)) {
                $this->session->unset_userdata('pending_login_id');
                redirect('login');
            }

            if (verify_totp_code($login->two_factor_secret, $code)) {
                $this->session->unset_userdata('pending_login_id');
                $this->complete_login($login);
            }

            $this->session->set_flashdata('error', 'Invalid authentication code. Please try again.');
            redirect('auth/twofactor');
        }

        $data = array();
        $data['username'] = $this->session->userdata('pending_login_username');
        $this->load->view('twofactor', $data);
    }

    public function setup_totp() {
        if (!logged_in_user_id()) {
            redirect('login');
        }

        $user = $this->auth->get_single('users', array('id' => logged_in_user_id()));
        if (empty($user)) {
            redirect('dashboard/index');
        }

        $data = array();
        $secret = $user->two_factor_secret;
        if (empty($secret)) {
            $secret = totp_generate_secret();
            $this->session->set_userdata('totp_setup_secret', $secret);
        } else {
            $this->session->set_userdata('totp_setup_secret', $secret);
        }

        if ($_POST) {
            $code = trim($this->input->post('code'));
            $setupSecret = $this->session->userdata('totp_setup_secret');

            if (!empty($setupSecret) && verify_totp_code($setupSecret, $code)) {
                $this->auth->update('users', array('two_factor_secret' => $setupSecret, 'two_factor_enabled' => 1), array('id' => $user->id));
                $this->session->unset_userdata('totp_setup_secret');
                $this->session->set_flashdata('success', 'Two-factor authentication has been enabled.');
                redirect('auth/setup_totp');
            }

            $this->session->set_flashdata('error', 'The code is invalid. Please try again.');
            redirect('auth/setup_totp');
        }

        $label = !empty($user->username) ? $user->username : 'user';
        $issuer = !empty($this->global_setting->brand_name) ? $this->global_setting->brand_name : 'School';

        $data['secret'] = $secret;
        $data['qr_url'] = totp_qr_url($label, $issuer, $secret);
        $data['enabled'] = !empty($user->two_factor_enabled);
        $this->load->view('setup_totp', $data);
    }

    public function disable_totp() {
        if (!logged_in_user_id()) {
            redirect('login');
        }

        $this->auth->update('users', array('two_factor_enabled' => 0, 'two_factor_secret' => null), array('id' => logged_in_user_id()));
        $this->session->set_flashdata('success', 'Two-factor authentication has been disabled.');
        redirect('auth/setup_totp');
    }

    /*     * ***************Function logout**********************************
     * @type            : Function
     * @function name   : logout
     * @description     : Log Out the logged in user and redirected to Login page  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function logout($key = null) {
        $this->auth->update('users', array('last_logged_out' => date('Y-m-d H:i:s')), array('id' => logged_in_user_id()));
        @create_log('Has been logged out');
         
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('photo');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('profile_id');
        $this->session->unset_userdata('school_id');
        $this->session->unset_userdata($key);

        $this->session->unset_userdata('theme');
               

        $this->session->sess_destroy();
        redirect('login', 'refresh');
        //redirect('/', 'refresh');
        exit;
    }

    /*     * ***************Function forgot**********************************
     * @type            : Function
     * @function name   : forgot
     * @description     : Load recover forgot password view file  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgot() {

        $this->load->helper('form');
        $data = array();
        $this->load->view('forgot', $data);
    }

    /*     * ***************Function forgotpass**********************************
     * @type            : Function
     * @function name   : forgotpass
     * @description     : this function is used to send recover forgot password  email 
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgotpass() {

        if ($_POST) {

            $data['username'] = $this->input->post('username');
            $data['status'] = 1;
            $login = $this->auth->get_single('users', $data);
            if (!empty($login)) {
                if($this->_send_email($login)){
                    $this->session->set_flashdata('success', $this->lang->line('email_send_success').'. Please check your email inbox or spam folder.');
                }else{
                    $this->session->set_flashdata('success', $this->lang->line('unexpected_error'));
                }                
            } else {
                $this->session->set_flashdata('error', $this->lang->line('wrong_username'));
            }
        }

        redirect('forgot');
        exit;
    }

    /*     * ***************Function _send_email**********************************
     * @type            : Function
     * @function name   : _send_email
     * @description     : this function used to send recover forgot password email 
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */

    private function _send_email($data) {

        $profile = get_user_by_role($data->role_id, $data->id);
        
        if($profile->email){
            
            $from_email = FROM_EMAIL;
            $from_name  = FROM_NAME;        
                  
            $school_id     = $data->school_id ? $data->school_id : 0;             
            if($school_id){       
                $school = $this->auth->get_single('schools', array('status' => 1, 'id'=>$school_id));
            }            
            
            $email_setting = $this->auth->get_single('email_settings', array('status' => 1, 'school_id'=>$school_id)); 
            
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
            
            $this->email->from($from_email, $from_name);           
            $this->email->to($profile->email);
            $subject = $this->lang->line('reset_password'). ' : '. $from_name;
            $this->email->subject($subject);
            $key = uniqid();
            $this->auth->update('users', array('reset_key' => $key), array('id' => $data->id));

            $message = $this->lang->line('to_reset_password'). '<br/><br/>';
            $message .= site_url('reset/' . $key);
            $message .= '<br/><br/>';
            $message .= $this->lang->line('if_not_request_just_ignore') . '.<br/><br/>';
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
                mail($profile->email, $subject, $message, $headers);
            } 
            
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /*     * ***************Function reset**********************************
     * @type            : Function
     * @function name   : reset
     * @description     : this function used to load password reset view file 
     * @param           : $key string parameter; 
     * @return          : null 
     * ********************************************************** */

    public function reset($key) {

        $data = array();
        $this->load->helper('form');
        $user = $this->auth->get_single('users', array('reset_key' => $key));
        
        if (!empty($user)) {
            $data['user'] = $user;
            $data['key'] = $key;
            $this->load->view('reset', $data);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('unexpected_error'));
            redirect('login');
        }
    }

    /*     * ***************Function resetpass**********************************
     * @type            : Function
     * @function name   : resetpass
     * @description     : this function used to reset user passwrd 
     *                    after sucessfull reset password it's redirected
     *                    user to log in page            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    
    public function resetpass() {

        if ($_POST) {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[30]');
            $this->form_validation->set_rules('conf_password', $this->lang->line('conf_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                
                
                $data['password'] = md5($this->input->post('password'));
                $data['temp_password'] = base64_encode($this->input->post('password'));
                $data['reset_key'] = NULL;
                $data['modified_at'] = date('Y-m-d H:i:s');               
                $this->auth->update('users', $data, array('id' => $this->input->post('id')));
                $this->session->set_flashdata('success', $this->lang->line('update_success'));               
                redirect('login', 'refresh');
            } else {
                $this->session->set_flashdata('error', $this->lang->line('password_reset_error'));
                redirect('auth/reset/' . $this->input->post('key'));
            }
        }

        redirect();
        exit;
    }   

}