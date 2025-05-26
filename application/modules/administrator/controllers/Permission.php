<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Permission extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Role_Model', 'role', true);
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
         
         $this->data['roles'] = $this->role->get_list('roles', array('status' => 1), '','', '', 'id', 'ASC');
         $this->data['modules'] = $this->role->get_list('modules', array('status' => 1), '','', '', 'id', 'ASC');
    }
    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "permission setting" user interface                 
    *                    and setting user role permission    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index(){
        
        check_permission(EDIT);
        
        // now we need to add new permission
         if($_POST)
         {            
            if(count($this->input->post('operation')) > 0)
            {
              
                $role_id = $this->input->post('role_id');
                //$this->role->delete('privileges', array('role_id' => $role_id));  
                
               foreach($this->input->post('operation') AS $key => $value)
               {
                  $data = array();

                  $data['role_id']      = $role_id;
                  $data['operation_id'] = $key;
                  $data['is_add']          = isset($_POST['is_add'][$key]) && !empty($_POST['is_add'][$key]) ? $_POST['is_add'][$key] : 0;
                  $data['is_edit']         = isset($_POST['is_edit'][$key]) && !empty($_POST['is_edit'][$key]) ? $_POST['is_edit'][$key] : 0;
                  $data['is_delete']       = isset($_POST['is_delete'][$key]) && !empty($_POST['is_delete'][$key]) ? $_POST['is_delete'][$key] : 0;
                  $data['is_view']         = isset($_POST['is_view'][$key]) && !empty($_POST['is_view'][$key]) ? $_POST['is_view'][$key] : 0;
                  $data['status']       = 1;
                  $data['created_at']   = date('Y-m-d H:i:s');
                  $data['created_by']   = logged_in_user_id();
                  
                  $exist = $this->role->get_single('privileges', array('role_id' => $role_id, 'operation_id'=>$key));
                  if($exist){
                        $this->role->update('privileges', $data, array('role_id' => $role_id, 'operation_id'=>$key));  
                  }else{
                        $this->role->insert('privileges', $data);                      
                  }                  
               }
               
               // update config file
                $this->update_config();
                
                $role = $this->role->get_single('roles', array('id' => $role_id));
                create_log('Has been setting permission for the role : '.$role->name);
                
                success($this->lang->line('update_success'));
                redirect('administrator/permission/index/'.$role_id);
            }
         }
         
        $this->data['role_id'] = $this->uri->segment(4);
        $this->data['filter_role_id'] = $this->uri->segment(4);
        
        if(!$this->data['role_id']){
            $this->data['list'] = TRUE;
        }else{
            
            $this->data['role']     = $this->role->get_single('roles', array('id' => $this->data['role_id']));
            $this->data['permission'] = TRUE;
        }        
        
        $this->layout->title($this->lang->line('manage_role_permission'). ' | ' . SMS);
        $this->layout->view('role/permission', $this->data);  
    }

}
