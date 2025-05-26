<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(0);
class Plivo {

    protected $plivo_auth_id;
    protected $plivo_auth_token;
    protected $plivo_from_number;

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

        $this->plivo_auth_id = $setting->msg91_auth_key;
        $this->plivo_auth_token = $setting->msg91_sender_id;
        $this->plivo_from_number = $setting->plivo_from_number;
        
    }

    public function send($to, $message) {
        
        //Your message to send, Add URL encoding here.
        #https://gist.github.com/tsudot/41eae953c6af09131157
        # Plivo AUTH ID
        $AUTH_ID = $this->plivo_auth_id;
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = $this->plivo_auth_token;
        # SMS sender ID.17433333080
        $src = $this->plivo_from_number;
        # SMS destination number
        $dst = $to;
        # SMS text
        $text = $message;
        
        $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Message/';
        $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);

        if ($response) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>