<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Type.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Type
 * @description     : Manage Certificate Type.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Type extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Type_Model', 'type', true);
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Certificate Type List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW); 
                  
        $this->data['certificates'] = $this->type->get_certificate_list();
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_certificate_type'). ' | ' . SMS);
        $this->layout->view('type/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Certificate Type" user interface                 
    *                    and process to store "Certificate Type" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_type_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_type_data();

                $insert_id = $this->type->insert('certificates', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a certificate type : '.$data['name']);                     
                    success($this->lang->line('insert_success'));
                    redirect('certificate/type/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('certificate/type/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

               
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $this->data['name'] = $this->session->userdata('school_name');;
        } 
        
        $this->data['certificates'] = $this->type->get_certificate_list();
        
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('type/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Certificate Type" user interface                 
    *                    with populate "Certificate Type" value 
    *                    and process to update "Certificate" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
         
        if ($_POST) {
            $this->_prepare_type_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_type_data();
                $updated = $this->type->update('certificates', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a certificate type : '.$data['name']);  
                    
                    success($this->lang->line('update_success'));
                    redirect('certificate/type/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('certificate/type/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['certificate'] = $this->type->get_single('certificates', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['certificate'] = $this->type->get_single('certificates', array('id' => $id));

                if (!$this->data['certificate']) {
                     redirect('certificate/type/index');
                }
            }
        }
 
        
        $this->data['certificates'] = $this->type->get_certificate_list();
        
        $this->data['school_id'] = $this->data['certificate']->school_id;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('type/index', $this->data);
    }

       
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Certificate data                 
    *                       
    * @param           : $certificate_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($certificate_id = null) {

        check_permission(VIEW);

        if(!is_numeric($certificate_id)){
             error($this->lang->line('unexpected_error'));
             redirect('dashboard');  
        }
        
        
        $this->data['certificate'] = $this->type->get_single('certificates', array('id' => $certificate_id));
       
        
        
        $this->data['school'] = $this->type->get_single('schools', array('id'=>$this->data['certificate']->school_id, 'status'=>1));
        
        $this->data['certificates'] = $this->type->get_certificate_list();
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view')  . ' | ' . SMS);
        $this->layout->view('type/index', $this->data);
    }     
    
    
    /*****************Function _prepare_type_validation**********************************
    * @type            : Function
    * @function name   : _prepare_type_validation
    * @description     : Process "Certificate Type" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_type_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('certificate_type') , 'trim|required|callback_name');
        $this->form_validation->set_rules('top_title', $this->lang->line('title') . '/ ' .$this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('main_text', $this->lang->line('main_certificate_text'), 'trim|required');
        $this->form_validation->set_rules('footer_left', $this->lang->line('footer_left'), 'trim');
        $this->form_validation->set_rules('footer_middle', $this->lang->line('footer_middle'), 'trim');
        $this->form_validation->set_rules('footer_right', $this->lang->line('footer_right'), 'trim');
        $this->form_validation->set_rules('background', $this->lang->line('background'), 'trim|callback_background');
    }

                    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "Certificate Name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $type = $this->type->duplicate_check($this->input->post('school_id'), $this->input->post('name'));
            if ($type) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $type = $this->type->duplicate_check($this->input->post('school_id'),$this->input->post('name'), $this->input->post('id'));
            if ($type) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    
           
    /*****************Function background**********************************
    * @type            : Function
    * @function name   : background
    * @description     : Check background                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function background() {

        if ($_FILES['background']['name']) {

            $name = $_FILES['background']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg') {
                return TRUE;
            } else {
                $this->form_validation->set_message('background', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
       
    /*****************Function _get_posted_type_data**********************************
    * @type            : Function
    * @function name   : _get_posted_type_data
    * @description     : Prepare "Certificate" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_type_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'top_title';
        $items[] = 'main_text';
        $items[] = 'footer_left';
        $items[] = 'footer_middle';
        $items[] = 'footer_right';
        $items[] = 'background';
        
        $data = elements($items, $_POST);        
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
        }

         if(isset($_FILES['background']['name'])){  
            $data['background'] = $this->_upload_background();
        }
        
        return $data;
    }

   
           
    /*****************Function _upload_background**********************************
    * @type            : Function
    * @function name   : _upload_background
    * @description     : Process to upload certificate background into server                  
    *                     and return background name  
    * @param           : null
    * @return          : $return_background string value 
    * ********************************************************** */ 
    private function _upload_background() {

        $prev_background = $this->input->post('prev_background');
        $background = $_FILES['background']['name'];
        $background_type = $_FILES['background']['type'];
        $return_background = '';
        if ($background != "") {
            if ($background_type == 'image/jpeg' || $background_type == 'image/pjpeg' ||
                    $background_type == 'image/jpg' || $background_type == 'image/png' ||
                    $background_type == 'image/x-png' || $background_type == 'image/gif') {

                $destination = 'assets/uploads/certificate/';

                $file_type = explode(".", $background);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $background_path = 'certificate-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['background']['tmp_name'], $destination . $background_path);

                // need to unlink previous background
                if ($prev_background != "") {
                    if (file_exists($destination . $prev_background)) {
                        @unlink($destination . $prev_background);
                    }
                }

                $return_background = $background_path;
            }
        } else {
            $return_background = $prev_background;
        }

        return $return_background;
    }

        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Certificate Type" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('certificate/type');        
        }
        
        $certificate = $this->type->get_single('certificates', array('id' => $id));
        
        if (!empty($certificate)) {

            // delete employee data
            $this->type->delete('certificates', array('id' => $id));          
            // delete certificate background 
             $destination = 'assets/uploads/';
            if (file_exists($destination . '/certificate/' . $certificate->background)) {
                @unlink($destination . '/certificate/' . $certificate->background);
            }
            
            create_log('Has been deleted a certificate type : '.$certificate->name);
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('certificate/type');
    }

}
