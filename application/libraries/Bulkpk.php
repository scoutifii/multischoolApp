<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bulkpk {

    public $username = "";
    public $password = "";
    public $senderId = "";
    public $url = "https://sendpk.com/api/sms.php?";

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

        $this->username = $setting->bulk_pk_username;
        $this->password = $setting->bulk_pk_password;
        $this->senderId = $setting->bulk_pk_sender_id;
    }

    function sendSMS($mobile, $message) {

        $username = $this->username;
        $password = $this->password;
        $sender = $this->senderId;
       

        ////sending sms
        $post = "sender=" . urlencode($sender) . "&mobile=" . urlencode($mobile) . "&message=" . urlencode($message) . "";
        $url = $this->url."username=" . $username . "&password=" . $password . "";
        $ch = curl_init();
        $timeout = 10; // set to zero for no timeout
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch);  
         curl_close($ch);
        echo $result;
    }
}

?>