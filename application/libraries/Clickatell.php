<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(0);
/**
 * Clickatell Class
 *
 * @package	Clickatell
 * @subpackage	Libraries
 * @category	SMS Gateway
 * @author	Zachie du Bruyn
 */
class Clickatell {

    public $error_done = 0;
    public $error_auth_all  = 1;
    const ERR_SEND_MESSAGE_FAIL = 2;
    const ERR_SESSION_EXPIRED = 3;
    const ERR_PING_FAIL = 4;
    const ERR_CALL_FAIL = 5;

    // public vars
    public $error = 0;
    public $error_message = '';
    // private vars
    private $ci;
    private $session_id = FALSE;

   
    public $base_url  = "http://api.clickatell.com";

    public function __construct() {
                  
       
         $ci = & get_instance();   
         $school_id = '';
         if($ci->session->userdata('school_id')){
             $school_id = $ci->session->userdata('school_id');
         }else{
             $school_id = $ci->input->post('school_id');
         }
         
         $ci->db->select('S.*');
         $ci->db->from('sms_settings AS S');     
         $ci->db->where('S.school_id', $school_id);     
         $setting = $ci->db->get()->row();
         
        $this->username = $setting->clickatell_username;
        $this->password = $setting->clickatell_password;
        $this->api_id   = $setting->clickatell_api_key;
        $this->from_no  = $setting->clickatell_from_number;
    }

    /**
     * Method for Authentication with Clickatell
     *
     * @return string $session_id
     */
    public function authenticate() {
        $url = $this->base_url . '/http/auth?user=' . $this->username
                . '&password=' . $this->password . '&api_id=' . $this->api_id;

        $result = $this->_do_api_call($url);
        $result = explode(':', $result);

        if ($result[0] == 'OK') {
            $this->session_id = trim($result[1]);
            return $this->session_id;
        } else {
            $this->error = $this->error_auth_all;
            $this->error_message = $result[0];
            return FALSE;
        }
    }

    /**
     * Method to send a text message to number
     *
     * @access  public
     * @param   string $to
     * @param   string $message
     * @return  message_id
     */
    public function send_message($to, $message) {
        if ($this->session_id == FALSE) {
            $this->authenticate();
        }
        
        if ($this->error == $this->error_done) {
            $message = urlencode($message);
            $url = $this->base_url . '/http/sendmsg?session_id=' . $this->session_id
                    . '&to=' . $to . '&text=' . $message . '&from=' . $this->from_no . '&MO=1';

            $result = $this->_do_api_call($url);
            $result = explode(':', $result);           
            if ($result[0] == 'ID') {
                $api_message_id = $result[1];
                return $api_message_id;
            } else {
                $this->error = self::ERR_SEND_MESSAGE_FAIL;
                $this->error_message = $result[0];
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_balance() {
        if ($this->session_id == FALSE) {
            $this->authenticate();
        }

        if ($this->error == $this->error_done) {
            $url = $this->base_url . '/http/getbalance?session_id=' . $this->session_id;

            $result = $this->_do_api_call($url);
            $result = explode(':', $result);

            if ($result[0] == 'Credit') {
                return (float) $result[1];
            } else {
                $this->error = self::ERR_CALL_FAIL;
                $this->error_message = $result[0];
                return FALSE;
            }
        }
    }

    /**
     * Method to send a ping to keep session live
     *
     * @access  public
     * @return  bool $success
     */
    public function ping() {
        if ($this->session_id == FALSE) {
            $this->authenticate();
        }

        if ($this->error == $this->error_done) {
            $url = $this->base_url . '/http/ping?session_id=' . $this->session_id;

            $result = $this->_do_api_call($url);
            $result = explode(':', $result);

            if ($result[0] == 'OK') {
                return TRUE;
            } else {
                $this->error = self::ERR_PING_FAIL;
                $this->error_message = $result[0];
                return FALSE;
            }
        }
    }

    /**
     * Method to call HTTP url - to be expanded
     *
     * @param   string $url
     * @return  string response
     */
    private function _do_api_call($url) {
        $result = file($url);
        $result = implode("\n", $result);
        return $result;
    }

}
/* End of file Clickatell.php */
/* Location: ./application/libraries/Clickatell.php */