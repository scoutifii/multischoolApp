<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smscountry {

    public $user = "";
    public $password = "";
    public $senderId = "";
    public $url = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
    public $messagetype = "N"; //Type Of Your Message
    public $DReports = "Y"; //Delivery Reports

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

        $this->user = $setting->smscountry_username;
        $this->password = $setting->smscountry_password;
        $this->senderId = $setting->smscountry_sender_id;
    }

    function sendSMS($to, $message) {
        $message = urlencode($message);
        $ch = curl_init();
        if (!$ch) {
            die("Couldn't initialize a cURL handle");
        }
        $ret = curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "User=$this->user&passwd=$this->password&mobilenumber=$to&message=$message&sid=$this->senderId&mtype=$this->messagetype&DR=$this->DReports");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
        // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
        $curlresponse = curl_exec($ch); // execute
        if (curl_errno($ch))
            echo 'curl error : ' . curl_error($ch);
        if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            //echo $curlresponse; //echo "Message Sent Succesfully" ;
            return true;
        }
    }

}

?>