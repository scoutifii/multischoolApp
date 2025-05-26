<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Betasms {

    public $username = "";
    public $password = "";
    public $senderId = "";
    public $url = "http://login.betasms.com/api/";   

    function __construct() {

        $ci = & get_instance();
        $school_id = '';
        if ($ci->session->userdata('school_id')) {
            $school_id = $ci->session->userdata('school_id');
        } else {
            $school_id = $ci->input->post('school_id');
        }

        $ci->db->select('S.*');
        $ci->db->from('sms_settings AS S');
        $ci->db->where('S.school_id', $school_id);
        $setting = $ci->db->get()->row();

        $this->username = $setting->betasms_username;
        $this->password = $setting->betasms_password;
        $this->senderId = $setting->betasms_sender_id;
    }

    function sendSMS($numbers, $message) {
        
        $message = urlencode($message);
        $numbers = implode(',', $numbers);
        
        //allow remote access to this script, replace the * to your domain e.g http://www.example.com if you wish to recieve requests only from your server
        header("Access-Control-Allow-Origin: *");
        //rebuild form data
        $postdata = http_build_query(
            array(
                'username' => $this->username,
                'password' => $this->password,
                'message' => $message,
                'mobiles' => $numbers,
                'sender' => $this->senderId,
            )
        );
        //prepare a http post request
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        //craete a stream to communicate with betasms api
        $context  = stream_context_create($opts);
        //get result from communication
        $result = file_get_contents($this->url, false, $context);
        //return result to client, this will return the appropriate respond code
      // print_r($result);
      // die();
        if($result == '1701'){
            return TRUE;
        }else{
            return FALSE;
        }    
    }
}

?>