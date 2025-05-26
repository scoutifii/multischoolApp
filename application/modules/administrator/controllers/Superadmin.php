<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Superadmin extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Superadmin_Model', 'superadmin', true);   
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Superadmin List" user interface                 
    *                      
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        
        $this->data['superadmins'] = $this->superadmin->get_superadmin_list();
        $this->data['roles'] = $this->superadmin->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
              
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_super_admin') . ' | ' . SMS);
        $this->layout->view('super_admin/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Super admin" user interface                 
    *                    and process to store "Super admin" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_superadmin_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_superadmin_data();

                $insert_id = $this->superadmin->insert('system_admin', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a super admin : '.$data['name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('administrator/superadmin/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/superadmin/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['superadmins'] = $this->superadmin->get_superadmin_list();
        $this->data['roles'] = $this->superadmin->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
             
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('super_admin/index', $this->data);
    }

    
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Super Admin" user interface                 
    *                    with populate "Super Admin" value 
    *                    and process to update "Super Admin" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_superadmin_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_superadmin_data();
                $updated = $this->superadmin->update('system_admin', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a super admin : '.$data['name']); 
                    
                    success($this->lang->line('update_success'));
                    redirect('administrator/superadmin/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/superadmin/edit/' . $this->input->post('id'));
                }
            } else {  
                error($this->lang->line('update_failed'));
                $this->data['superadmin'] = $this->superadmin->get_single_superadmin($this->input->post('id'));
            }
        } else {
            if ($id) {
                $this->data['superadmin'] = $this->superadmin->get_single_superadmin($id);

                if (!$this->data['superadmin']) {
                    redirect('administrator/superadmin/index');
                }
            }
        }

        $this->data['superadmins'] = $this->superadmin->get_superadmin_list();
        $this->data['roles'] = $this->superadmin->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
       
       
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('super_admin/index', $this->data);
    }

    
     /*****************Function get_single_superadmin**********************************
     * @type            : Function
     * @function name   : get_single_superadmin
     * @description     : "Load single superadmin information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_super_admin(){
        
       $super_admin_id = $this->input->post('super_admin_id');
       
       $this->data['superadmin'] = $this->superadmin->get_single_superadmin($super_admin_id);
       echo $this->load->view('super_admin/get-single-super-admin', $this->data);
    }
    
    /*****************Function _prepare_superadmin_validation**********************************
    * @type            : Function
    * @function name   : _prepare_superadmin_validation
    * @description     : Process "Super Admin" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_superadmin_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        if (!$this->input->post('id')) {       
            
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        }
        
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
        $this->form_validation->set_rules('role_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim');
        $this->form_validation->set_rules('present_address', $this->lang->line('present_address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent_address'), 'trim');
        $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required');
        $this->form_validation->set_rules('blood_group', $this->lang->line('blood_group'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');
        $this->form_validation->set_rules('dob', $this->lang->line('birth_date'), 'trim|required');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
        
        $this->form_validation->set_rules('resume', $this->lang->line('resume'), 'trim|callback_resume'); 
        $this->form_validation->set_rules('photo', $this->lang->line('photo'), 'trim|callback_photo'); 
    }
   
    
                    
    /*****************Function email**********************************
    * @type            : Function
    * @function name   : email
    * @description     : Unique check for "Super Admin Email" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->superadmin->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->superadmin->duplicate_check($this->input->post('username'), $this->input->post('id'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    
    /*****************Function resume**********************************
    * @type            : Function
    * @function name   : resume
    * @description     : validate resume                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function resume() {
        if ($_FILES['resume']['name']) {
            $name = $_FILES['resume']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'ppt' || $ext == 'pptx' || $ext == 'txt') {
                return TRUE;
            } else {
                $this->form_validation->set_message('resume', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    /*****************Function photo**********************************
    * @type            : Function
    * @function name   : photo
    * @description     : validate photo                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function photo() {
        if ($_FILES['photo']['name']) {
            $name = $_FILES['photo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('photo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
        
   
    /*****************Function _get_posted_superadmin_data**********************************
    * @type            : Function
    * @function name   : _get_posted_superadmin_data
    * @description     : Prepare "Super Admin" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */ 
    private function _get_posted_superadmin_data() {

        $items = array();
        $items[] = 'national_id';
        $items[] = 'name';
        $items[] = 'email';
        $items[] = 'phone';
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        $items[] = 'gender';
        $items[] = 'blood_group';
        $items[] = 'religion';
        $items[] = 'other_info';            
        
        $data = elements($items, $_POST);

        $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->superadmin->create_user();
        }

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }
        if ($_FILES['resume']['name']) {
            $data['resume'] = $this->_upload_resume();
        }
        return $data;
    }

    
       
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : Process to upload superadmin photo into server                  
    *                     and return photo name  
    * @param           : null
    * @return          : $return_photo string value 
    * ********************************************************** */ 
    private function _upload_photo() {

        $prev_photo = $this->input->post('prev_photo');
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                // super admin photo folder is same as employee
                $destination = 'assets/uploads/employee-photo/';

                $file_type = explode(".", $photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['photo']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }

           
    /*****************Function _upload_resume**********************************
    * @type            : Function
    * @function name   : _upload_resume
    * @description     : Process to upload superadmin resume into server                  
    *                     and return resume file name  
    * @param           : null
    * @return          : $return_resume string value 
    * ********************************************************** */ 
    private function _upload_resume() {
        
        $prev_resume = $this->input->post('prev_resume');
        $resume = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $return_resume = '';

        if ($resume != "") {
            if ($resume_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $resume_type == 'application/powerpoint' || $resume_type == 'application/vnd.ms-powerpoint' ||
                    $resume_type == 'application/mspowerpoint' || $resume_type == 'application/x-mspowerpoint' ||
                    $resume_type == 'application/msword' || $resume_type == 'text/plain' ||
                    $resume_type == 'application/vnd.ms-office' || $resume_type == 'application/pdf') {

                // super admin resume folder is same as employee
                $destination = 'assets/uploads/employee-resume/';

                $file_type = explode(".", $resume);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $resume_path = 'resume-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['resume']['tmp_name'], $destination . $resume_path);

                // need to unlink previous photo
                if ($prev_resume != "") {
                    if (file_exists($destination . $prev_resume)) {
                        @unlink($destination . $prev_resume);
                    }
                }

                $return_resume = $resume_path;
            }
        } else {
            $return_resume = $prev_resume;
        }

        return $return_resume;
    }

        
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Employee" data from database                  
    *                     and unlink superadmin photo and Resume from server  
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/superadmin');       
        }
        
        $superadmin = $this->superadmin->get_single('system_admin', array('id' => $id));
        if (!empty($superadmin)) {
            
            create_log('Has been deleted a super admin : '.$superadmin->name); 

            // delete superadmin data
            $this->superadmin->delete('system_admin', array('id' => $id));
            // delete superadmin login data
            $this->superadmin->delete('users', array('id' => $superadmin->user_id));

            // delete superadmin resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/employee-resume/' . $superadmin->resume)) {
                @unlink($destination . '/employee-resume/' . $superadmin->resume);
            }
            if (file_exists($destination . '/employee-photo/' . $superadmin->photo)) {
                @unlink($destination . '/employee-photo/' . $superadmin->photo);
            }

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('administrator/superadmin/index');
    }

}
