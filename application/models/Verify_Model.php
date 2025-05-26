<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Verify_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

   public function verify($purchase_code){
        
        /*$domain  = $_SERVER['SERVER_NAME']; 
        $full_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];         
        $post = array();
        $post['purchase_code'] = $purchase_code;
        $post['domain'] = $domain;
        $post['full_url'] = $full_url;
        $url = 'https://www.codetroopers-team.com/api/vgmsms'; 
        
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);       
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);        
        curl_exec($ch);        
        curl_close($ch);*/ 
        
        $sql = "CREATE TABLE IF NOT EXISTS `purchase` (
            `id` int(11) NOT NULL,
            `purchase_code` varchar(255) NOT NULL,
            `status` tinyint(1) NOT NULL,
            `created_at` datetime NOT NULL,
            `modified_at` datetime NOT NULL,
            `created_by` int(11) NOT NULL,
            `modified_by` int(11) NOT NULL
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";   
        $this->db->query($sql);
      
        $data = array();
        $data['id'] = 1;
        $data['purchase_code'] = $purchase_code;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = 1;
        $data['status'] = 1;       
        $this->db->empty_table('purchase');     
        $this->db->insert('purchase', $data);
    }
}