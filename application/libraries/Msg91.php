<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(0);

class Msg91 {

    protected $authKey;
    protected $senderID;

    public function __construct() {
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

        $this->authKey = $setting->msg91_auth_key;
        $this->senderID = $setting->msg91_sender_id;
        $this->url = 'https://msg91sms.vsms.net/eapi/submission/send_sms/2/2.0';
    }

    public function send($to, $message) {
        //Your message to send, Add URL encoding here.
        $message = urlencode($message);

        //Define route
        $route = 4;
        //Prepare you post parameters
        $postData = array(
            'authkey' => $this->authKey,
            'mobiles' => $to,
            'message' => $message,
            'sender' => $this->senderID,
            'route' => $route
        );

        //API URL
        $url = "http://api.msg91.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);
        //print_r($output);
        //Print error if any
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);

        if ($output) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>