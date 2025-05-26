<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smscluster {

    public $auth_key = "";
    public $router = "";
    public $senderId = "";
    public $url = "msg.msgclub.net";

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

        $this->auth_key = $setting->cluster_auth_key;
        $this->router = $setting->cluster_router;
        $this->senderId = $setting->cluster_sender_id;
    }

    function sendSMS($mobile, $message) {

        //Prepare you post parameters
        $postData = array(
            'authkey' => $this->auth_key,
            'mobileNumbers' => $mobile,
            "groupId" => "0",
            'smsContent' => $message,
            'senderId' => $this->senderId,
            'route' => $this->router,
            "smsContentType" => 'english'
        );


        $data_json = json_encode($postData);
        $url = "http://" . $this->url . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . $this->auth_key;

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }

}

?>