<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Username extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Administrator_Model', 'administrator', true);
         $this->data['roles'] = $this->administrator->get_list('roles', array('status' => 1, 'is_super_admin'=>0), '','', '', 'id', 'ASC');
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load reset Username user interface                 
    *                    and reset user Username processing    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */ 
   public function index() {

       check_permission(EDIT);
       
        if($_POST){
            
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('role_id', $this->lang->line('user_type'), 'trim|required');
            
            if($this->input->post('role_id') == STUDENT){
                $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');  
            }
            
            $this->form_validation->set_rules('user_id', $this->lang->line('user'), 'trim|required');
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|min_length[5]|max_length[30]|is_unique[users.username]');
            
             if ($this->form_validation->run() === TRUE) {
                $data['username']      = $this->input->post('username');
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                
                $this->administrator->update('users', $data, array('id'=> $this->input->post('user_id')));
                success($this->lang->line('update_success'));
                
                $user = $this->administrator->get_single('users', array('id' => $this->input->post('user_id')));
                create_log('Has been updated username for user : '. $user->username);
                redirect('administrator/username');
             }else{
                 error($this->lang->line('update_failed'));
             }
        }
        
        $this->layout->title($this->lang->line('reset_username'). ' | ' . SMS);
        $this->layout->view('username/index', $this->data);
    }
    
    
}
