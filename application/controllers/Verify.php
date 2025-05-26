<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Verify extends CI_Controller {
    
     public $global_setting = array();
    
    function __construct() {       
        parent::__construct();  
        $this->load->model('Verify_Model', 'verify', true);
        $this->global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();
    }


    public function index() {
         
        if($_POST){
            
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('purchase_code', $this->lang->line('purchase_code'), 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                                                
                $data['purchase_code'] = $this->input->post('purchase_code');
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = 1;
                $data['status'] = 1;                
                
                if($this->db->table_exists('purchase')){
                    $this->db->empty_table('purchase');                   
                    if($this->db->insert('purchase', $data)){                   
                        $this->session->set_flashdata('success', $this->lang->line('update_success'));
                    }else{
                        $this->session->set_flashdata('error', $this->lang->line('update_failed'));
                    }                 
                }
               
                $this->verify->verify($data['purchase_code']);                
                /*sleep(5);                
                redirect('login'); */
                redirect('dashboard');        
                
            }else{
                $this->session->set_flashdata('error', $this->lang->line('insert_failed'));
                redirect();
            }
        }
        $this->lang->load('english', 'english');      
        $this->load->view('verify');
    }       
}