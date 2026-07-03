<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Welcome extends CI_Controller {
    /*     * **************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : this function load login view page            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    public $global_setting = array();
    public function index() {
       
        if (logged_in_user_id()) {
            redirect('dashboard');
        }
                        
        $this->global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();
        
        $this->load->helper('language');

        if(!empty($this->global_setting) && $this->global_setting->language){             
            $this->lang->load($this->global_setting->language);             
        }else{
           $this->lang->load('english');
        }
        
        $data['global_setting'] = $this->global_setting;
        $this->load->view('login', $data);
    }

}