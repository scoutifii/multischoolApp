<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Schooladmitsetting.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Schooladmitsetting
 * @description     : Manage school id Card setting.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Schooladmitsetting extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Admitsetting_Model', 'setting', true);
         
        if($this->session->userdata('role_id') == SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "School admit Card Setting Listing" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['setting'] = $this->setting->get_single('admit_card_settings', $condition);
        }  
        $this->layout->title($this->lang->line('manage_admit_card_setting') . ' | ' . SMS);
        $this->layout->view('admit_card/school', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new admit card Setting" user interface                 
    *                    and store "admit Card Setting" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();

                $insert_id = $this->setting->insert('admit_card_settings', $data);
                if ($insert_id) {
                    
                    $school = $this->setting->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been added admit card setting for : '.$school->school_name); 
                    
                    success($this->lang->line('insert_success'));
                    redirect('card/schooladmitsetting/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('card/schooladmitsetting/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['setting'] = $this->setting->get_single('admit_card_settings', $condition);
        } 
        
        $this->layout->title($this->lang->line('add')  . ' | ' . SMS);
        $this->layout->view('admit_card/school', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "admit Card Setting" user interface                 
    *                    with populated "admit card Setting" value 
    *                    and update "admit Card Setting" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();
                $updated = $this->setting->update('admit_card_settings', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $school = $this->setting->get_single('schools', array('id' => $data['school_id']));
                    create_log('Has been updated admit card setting for : '.$school->school_name); 
                    
                    success($this->lang->line('update_success'));
                    redirect('card/schooladmitsetting/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('card/schooladmitsetting/edit/' . $this->input->post('id'));
                }
            }else{
                error($this->lang->line('update_failed'));
            }
        } 
               
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['setting'] = $this->setting->get_single('admit_card_settings', $condition);
        } 
        
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('admit_card/school', $this->data);
    }

            
        
    /*****************Function get_single_admit_setting**********************************
     * @type            : Function
     * @function name   : get_single_admit_setting
     * @description     : "Load single admit card setting information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_admit_setting(){
        
       $setting_id = $this->input->post('setting_id');       
       $this->data['setting'] = $this->setting->get_single_admit_setting($setting_id);
       echo $this->load->view('admit_card/get-single-admit-setting', $this->data);
    }

    
    /*****************Function _prepare_setting_validation**********************************
    * @type            : Function
    * @function name   : _prepare_setting_validation
    * @description     : Process "Card setting" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_setting_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
      
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required|callback_school_id');  
        $this->form_validation->set_rules('bottom_text', $this->lang->line('bottom_signature'), 'trim|required');    
    }

    
        /*****************Function school_id**********************************
    * @type            : Function
    * @function name   : school_id
    * @description     : Unique check for "school_id" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function school_id() {
        if ($this->input->post('id') == '') {
            $event = $this->setting->duplicate_check($this->input->post('school_id'));
            if ($event) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $event = $this->setting->duplicate_check($this->input->post('school_id'), $this->input->post('id'));
            if ($event) {
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_setting_data**********************************
     * @type            : Function
     * @function name   : _get_posted_setting_data
     * @description     : Prepare "School card setting" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_setting_data() {

        $items = array();
       
        $items[] = 'school_id';
        $items[] = 'border_color';
        $items[] = 'top_bg';
        $items[] = 'bottom_bg';       
        $items[] = 'school_name'; 
        $items[] = 'school_name_font_size';
        $items[] = 'school_name_color';
        $items[] = 'school_address';
        $items[] = 'school_address_color';
        $items[] = 'admit_font_size'; 
        $items[] = 'admit_color';
        $items[] = 'admit_bg';
        $items[] = 'title_font_size';
        $items[] = 'title_color';
        $items[] = 'value_font_size';
        $items[] = 'value_color';
        $items[] = 'exam_font_size';
        $items[] = 'exam_color';
        $items[] = 'subject_font_size';
        $items[] = 'subject_color';
        $items[] = 'bottom_text';
        $items[] = 'bottom_text_color';
        $items[] = 'bottom_text_align';
        
        $data = elements($items, $_POST);  
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }    
        
        
        if ($_FILES['logo']['name']) {
            $data['school_logo'] = $this->_upload_logo();
        }

        return $data;
    }
        
            
    /*****************Function _upload_logo**********************************
    * @type            : Function
    * @function name   : _upload_logo
    * @description     : Process to upload institute logo in the server                  
    *                     and return logo name   
    * @param           : null
    * @return          : $logo string value 
    * ********************************************************** */
    private function _upload_logo() {

        $prevoius_logo = @$_POST['logo_prev'];
        $logo_name = $_FILES['logo']['name'];
        $logo_type = $_FILES['logo']['type'];
        $logo = '';


        if ($logo_name != "") {
            if ($logo_type == 'image/jpeg' || $logo_type == 'image/pjpeg' ||
                    $logo_type == 'image/jpg' || $logo_type == 'image/png' ||
                    $logo_type == 'image/x-png' || $logo_type == 'image/gif') {

                $destination = 'assets/uploads/logo/';

                $file_type = explode(".", $logo_name);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $logo_path = time().'-admit-logo.' . $extension;

                copy($_FILES['logo']['tmp_name'], $destination . $logo_path);

                if ($prevoius_logo != "") {
                    // need to unlink previous image
                    if (file_exists($destination . $prevoius_logo)) {
                        @unlink($destination . $prevoius_logo);
                    }
                }

                $logo = $logo_path;
            }
        } else {
            $logo = $prevoius_logo;
        }

        return $logo;
    }    
}