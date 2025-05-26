<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bdbulk {

    public $type = "";
    public $hash = "";
    public $url = "http://api.greenweb.com.bd/api.php";

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

        $this->type = $setting->bdbulk_type;
        $this->hash = $setting->bdbulk_hash;
    }

    function sendSMS($to, $message) {

        $data = array(
            'to' => "$to",
            'message' => "$message",
            'token' => "$this->hash"
        ); // Add parameters in key value
        
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        if(curl_error($ch)){
            echo FALSE;
        }else{
            echo TRUE;
        }
       // echo $smsresult;
        
    }

}

?>