<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Guardian extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Guardian_Model', 'guardian', true);        
    }

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Guardian List" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);
        
        $this->data['guardians'] = $this->guardian->get_guardian_list($school_id);
               
        $this->data['roles'] = $this->guardian->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['password'] = $this->gpassgenerator(8);
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_guardian') . ' | ' . SMS);
        $this->layout->view('guardian/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Guardian" user interface                 
    *                    and process to store "Guardian" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_guardian_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_guardian_data();

                $insert_id = $this->guardian->insert('guardians', $data);
                if ($insert_id) {
                    
                    create_log('Has been added a Guardian : '.$data['name']);                    
                    success($this->lang->line('insert_success'));
                    redirect('guardian/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('guardian/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['guardians'] = $this->guardian->get_guardian_list();
        $this->data['roles'] = $this->guardian->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('guardian/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Guardian" user interface                 
    *                    with populate "Guardian" value 
    *                    and process to update "Guardian" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('guardian/index');
        }
        
        if ($_POST) {
            $this->_prepare_guardian_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_guardian_data();
                $updated = $this->guardian->update('guardians', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a Guardian : '.$data['name']);                    
                    success($this->lang->line('update_success'));
                    redirect('guardian/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('guardian/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['guardian'] = $this->guardian->get_single_guardian($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['guardian'] = $this->guardian->get_single_guardian($id);

            if (!$this->data['guardian']) {
                redirect('guardian/index');
            }
        }

        $this->data['guardians'] = $this->guardian->get_guardian_list($this->data['guardian']->school_id);
        $this->data['roles'] = $this->guardian->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['school_id'] = $this->data['guardian']->school_id;
        
        $this->data['filter_school_id'] = $this->data['guardian']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('guardian/index', $this->data);
    }

   
    
    
    /*****************Function get_single_guardian**********************************
     * @type            : Function
     * @function name   : get_single_guardian
     * @description     : "Load single guardian information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_guardian(){
        
       $guardian_id = $this->input->post('guardian_id');
       
       $this->data['guardian'] = $this->guardian->get_single_guardian($guardian_id);
       $school = $this->guardian->get_school_by_id($this->data['guardian']->school_id);
       $this->data['students'] = $this->guardian->get_student_list($guardian_id, $school->academic_year_id);
       $this->data['invoices'] = $this->guardian->get_invoice_list($this->data['guardian']->school_id, $guardian_id);  
       
       echo $this->load->view('get-single-guardian', $this->data);
    }
        
    /*****************Function _prepare_guardian_validation**********************************
    * @type            : Function
    * @function name   : _prepare_guardian_validation
    * @description     : Process "Guardian" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_guardian_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|callback_username');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[30]');
        }
        
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|valid_email');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('role'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');        
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('profession', $this->lang->line('profession'), 'trim');
        $this->form_validation->set_rules('present_address', $this->lang->line('present_address'), 'trim');
        $this->form_validation->set_rules('permanent_address', $this->lang->line('permanent_address'), 'trim');
        $this->form_validation->set_rules('religion', $this->lang->line('religion'), 'trim');
        $this->form_validation->set_rules('other_info', $this->lang->line('other_info'), 'trim');
        
        $this->form_validation->set_rules('photo', $this->lang->line('photo'), 'trim|callback_photo'); 
    }

                        
    /*****************Function username**********************************
    * @type            : Function
    * @function name   : username
    * @description     : Unique check for "Guardian username" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->guardian->duplicate_check($this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->guardian->duplicate_check($this->input->post('username'), $this->input->post('id'));
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
    
       
    /*****************Function _get_posted_guardian_data**********************************
    * @type            : Function
    * @function name   : _get_posted_guardian_data
    * @description     : Prepare "Guardian" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_guardian_data() {

        $items = array();

        $items[] = 'school_id';
        $items[] = 'national_id';
        $items[] = 'name';       
        $items[] = 'phone';
        $items[] = 'email';
        $items[] = 'profession';
        $items[] = 'present_address';
        $items[] = 'permanent_address';
        $items[] = 'religion';
        $items[] = 'other_info';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->guardian->create_user();
        }

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }

        return $data;
    }

    
          
    /*****************Function _upload_photo**********************************
    * @type            : Function
    * @function name   : _upload_photo
    * @description     : Process to upload "Guardian" photo in the server                  
    *                    and return photo name    
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

                $destination = 'assets/uploads/guardian-photo/';

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

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Guardian" data from database                  
    *                    and unlink guardian photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('guardian/index');
        }
                       
       
        $guardian = $this->guardian->get_single('guardians', array('id' => $id));          
        $students = $this->guardian->get_list('students', array('guardian_id' => $id), '', '', '', 'id', 'ASC');
        
        if(!empty($students)){
            
            error($this->lang->line('delete_student_of_this_guardian'));
            redirect('guardian/index/'.$guardian->school_id);
        }
       
        if ($this->guardian->delete('guardians', array('id' => $id))) {

            // delete guardian login data
            $this->guardian->delete('users', array('id' => $guardian->user_id));

            // delete guardian resume and photo
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/guardian-photo/' . $guardian->photo)) {
                @unlink($destination . '/guardian-photo/' . $guardian->photo);
            }
            
            create_log('Has been deleted a Guardian : '.$guardian->name);
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
       redirect('guardian/index/'.$guardian->school_id);
       
    }

    /*****************Function due**********************************
    * @type            : Function
    * @function name   : due
    * @description     : Load "Due Invoice List" user interface                 
    *                        
    * @param           : null
    * @return          : null 
    * ***********************************************************/
    public function invoice() {    
        
        if(GUARDIAN != logged_in_role_id()){
             error($this->lang->line('unexpected_error'));
             redirect('dashboard');
        }
         
        $this->data['invoices'] = $this->guardian->get_invoice_list($this->session->userdata('school_id'), $this->session->userdata('profile_id'));  
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('invoice'). ' | ' . SMS);
        $this->layout->view('invoice/invoice', $this->data);            
       
    }
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load "Guardian view" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);
        
        $this->data['guardian'] = $this->guardian->get_single_guardian($id);
        $school = $this->guardian->get_school_by_id($this->data['guardian']->school_id);
        $this->data['students'] = $this->guardian->get_student_list($id, $school->academic_year_id);
        $this->data['invoices'] = $this->guardian->get_invoice_list($this->data['guardian']->school_id, $id);  
        
        
        $this->data['guardians'] = $this->guardian->get_guardian_list($this->data['guardian']->school_id);               
        $this->data['roles'] = $this->guardian->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['filter_school_id'] = $this->data['guardian']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('manage_guardian') . ' | ' . SMS);
        $this->layout->view('guardian/index', $this->data);
    }

     public function gpassgenerator($length)
    {
        $number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0","@","#","$","%","&","*","_");
    
        for($i=0; $i<$length; $i++)
        {
            $rand_value=rand(0,8);
            $rand_number=$number["$rand_value"];
        
            if(empty($con))
            { 
            $con=$rand_number;
            }
            else
            {
            $con="$con"."$rand_number";}
        }
        return $con;
    }
    
}
