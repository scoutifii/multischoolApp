<?php

/**
 * Textlocal API2 Wrapper Class
 *
 * This class is used to interface with the Textlocal API2 to send messages, manage contacts, retrieve messages from
 * inboxes, track message delivery statuses, access history reports
 *
 * @package    Textlocal
 * @subpackage API
 * @author     Andy Dixon <andy.dixon@tetxlocal.com>
 * @version    1.4-IN
 * @const      REQUEST_URL       URL to make the request to
 * @const      REQUEST_TIMEOUT   Timeout in seconds for the HTTP request
 * @const      REQUEST_HANDLER   Handler to use when making the HTTP request (for future use)
 */
class Textlocalsms {

    const REQUEST_URL = 'https://api.textlocal.in/';
    const REQUEST_TIMEOUT = 60;
    const REQUEST_HANDLER = 'curl';

    private $username;
    private $hash;
    private $apiKey;
    public $sender_id;
    public $errors = array();
    public $warnings = array();
    public $lastRequest = array();

    /**
     * Instantiate the object
     * @param $username
     * @param $hash
     */
    function __construct($apiKey = false) {

        if ($apiKey) {
            $this->apiKey = $apiKey;
        }

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

        $this->username = $setting->textlocal_username;
        $this->hash = $setting->textlocal_hash_key;
        $this->sender_id = $setting->textlocal_sender_id;
    }

    public function sendSms($numbers, $message) {
        //https://api.txtlocal.com/docs/sendsms
        // Authorisation details.             
        // Account details
        $apiKey = urlencode($this->hash);

        // Message details
        $numbers = implode(',', $numbers);
        $sender = urlencode($this->sender_id);
        $message = rawurlencode($message);


        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://api.txtlocal.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        echo $response;
        die('end');
        /*
          $message = urlencode($message);
          $numbers = implode(',', $numbers);
          $data = "username=".$this->username."&hash=".$this->hash."&message=".$message."&sender=".$this->sender_id."&numbers=".$numbers."&test=".$test;
          $ch = curl_init('http://api.textlocal.in/send/?');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch); // This is the result from the API
          curl_close($ch);
        */        
    }

}
