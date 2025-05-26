<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('School_Model', 'school', true);
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        } 
        $this->data['fields'] = $this->school->get_table_fields('languages');
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Academic School List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['schools'] = $this->school->get_list('schools', array(), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->school->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_school'). ' | ' . SMS);
        $this->layout->view('school/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Academic School" user interface                 
    *                    and store "Academic School" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_school_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_data();

                $insert_id = $this->school->insert('schools', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a school : '.$data['school_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('administrator/school');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/school/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['schools'] = $this->school->get_list('schools', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->school->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('school/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Academic School" user interface                 
    *                    with populated "Academic School" value 
    *                    and update "Academic School" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_school_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_data();
                $updated = $this->school->update('schools', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a school : '.$data['school_name']);
                    success($this->lang->line('update_success'));
                    redirect('administrator/school');    
                    
                } else {
                    
                    error($this->lang->line('update_failed'));
                    redirect('administrator/school/edit/' . $this->input->post('id'));
                    
                }
            } else {
                 error($this->lang->line('update_failed'));
                 $this->data['school'] = $this->school->get_single('schools', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['school'] = $this->school->get_single('schools', array('id' => $id));
 
                if (!$this->data['school']) {
                     redirect('administrator/school');
                }
            }
        }

        $this->data['schools'] = $this->school->get_list('schools', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->school->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('school/index', $this->data);
    }
    
       
    /*****************Function get_single_school**********************************
     * @type            : Function
     * @function name   : get_single_school
     * @description     : "Load single school information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_school(){
        
       $school_id = $this->input->post('school_id');       
       $this->data['school'] = $this->school->get_single('schools', array('id' => $school_id));
       echo $this->load->view('school/get-single-school', $this->data);
    }

    
    /*****************Function _prepare_school_validation**********************************
    * @type            : Function
    * @function name   : _prepare_school_validation
    * @description     : Process "Academic School" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_school_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_name', $this->lang->line('school_name'), 'trim|required|callback_school_name');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required');
        $this->form_validation->set_rules('currency', $this->lang->line('currency'), 'trim');
        $this->form_validation->set_rules('currency_symbol', $this->lang->line('currency_symbol'), 'trim|required');
        $this->form_validation->set_rules('language', $this->lang->line('language'), 'trim|required');
        $this->form_validation->set_rules('theme_name', $this->lang->line('theme'), 'trim|required');
        $this->form_validation->set_rules('footer', $this->lang->line('footer'), 'trim');
        $this->form_validation->set_rules('logo', $this->lang->line('admin_logo'), 'trim|callback_logo'); 
        $this->form_validation->set_rules('frontend_logo', $this->lang->line('frontend_logo'), 'trim|callback_frontend_logo'); 
    }

            
    /*****************Function session_school**********************************
    * @type            : Function
    * @function name   : session_school
    * @description     : Unique check for "academic school" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function school_name() {
        if ($this->input->post('id') == '') {
            $school = $this->school->duplicate_check($this->input->post('school_name'));
            if ($school) {
                $this->form_validation->set_message('school_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $school = $this->school->duplicate_check($this->input->post('school_name'), $this->input->post('id'));
            if ($school) {
                $this->form_validation->set_message('school_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    
    /*****************Function logo**********************************
    * @type            : Function
    * @function name   : logo
    * @description     : validate school admin logo                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function logo() {
        if ($_FILES['logo']['name']) {
            $name = $_FILES['logo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('logo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    /*****************Function frontend_logo**********************************
    * @type            : Function
    * @function name   : frontend_logo
    * @description     : validate school  frontend_logo                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function frontend_logo() {
        if ($_FILES['frontend_logo']['name']) {
            $name = $_FILES['frontend_logo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);           
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('frontend_logo', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }
    
    
    
    /*****************Function _get_posted_school_data**********************************
     * @type            : Function
     * @function name   : _get_posted_school_data
     * @description     : Prepare "Academic School" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_school_data() {

        $items = array();
        
        $items[] = 'region_id';
        $items[] = 'sub_region_id';
        $items[] = 'district_id';
        $items[] = 'sub_county_id';
        $items[] = 'parish_id';
        $items[] = 'village_id';
        $items[] = 'school_code';
        $items[] = 'school_name';
        $items[] = 'address';
        $items[] = 'phone';
        $items[] = 'email';
        $items[] = 'school_nature';
        $items[] = 'form_of_school';
        $items[] = 'category_of_school';
        $items[] = 'type_of_school';
        $items[] = 'currency';
        $items[] = 'currency_symbol';
        $items[] = 'school_fax';
        $items[] = 'school_lat'; 
        $items[] = 'school_lng'; 
        $items[] = 'map_api_key'; 
        $items[] = 'zoom_api_key'; 
        $items[] = 'zoom_secret'; 
        $items[] = 'enable_frontend';
        $items[] = 'final_result_type';
        $items[] = 'registration_date';
        $items[] = 'footer';
        $items[] = 'theme_name';
        $items[] = 'language';
        $items[] = 'enable_online_admission';
        $items[] = 'enable_rtl';
        $items[] = 'facebook_url';
        $items[] = 'twitter_url';
        $items[] = 'linkedin_url';
        $items[] = 'google_plus_url';
        $items[] = 'youtube_url';
        $items[] = 'instagram_url';
        $items[] = 'pinterest_url';
        
        $data = elements($items, $_POST); 
        
        if ($this->input->post('id')) {
            $data['status'] = $this->input->post('status');
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $data['about_text'] = '';
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }
        
        if ($_FILES['logo']['name']) {
            $data['logo'] = $this->_upload_logo();
        }
        if ($_FILES['frontend_logo']['name']) {
            $data['frontend_logo'] = $this->_upload_frontend_logo();
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
                $logo_path = time().'-school-admin-logo.' . $extension;

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
            
    /*****************Function _upload_frontend_logo**********************************
    * @type            : Function
    * @function name   : _upload_frontend_logo
    * @description     : Process to upload school front end logo in the server                  
    *                     and return logo name   
    * @param           : null
    * @return          : $logo string value 
    * ********************************************************** */
    private function _upload_frontend_logo() {

        $prevoius_logo = @$_POST['frontend_logo_prev'];
        $logo_name = $_FILES['frontend_logo']['name'];
        $logo_type = $_FILES['frontend_logo']['type'];
        $logo = '';


        if ($logo_name != "") {
            if ($logo_type == 'image/jpeg' || $logo_type == 'image/pjpeg' ||
                    $logo_type == 'image/jpg' || $logo_type == 'image/png' ||
                    $logo_type == 'image/x-png' || $logo_type == 'image/gif') {

                $destination = 'assets/uploads/logo/';

                $file_type = explode(".", $logo_name);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $logo_path = time().'-school-front-logo.' . $extension;

                copy($_FILES['frontend_logo']['tmp_name'], $destination . $logo_path);

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

    
    
    /*****************Function delete**********************************
   * @type            : Function
   * @function name   : delete
   * @description     : delete "Academic School" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {        
        
        check_permission(DELETE);        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('administrator/school/index');              
        }
        
        // need to find all child data from database 
        $skips = array('global_setting', 'gmsms_sessions', 'languages', 'modules', 'operations', 'privileges', 'purchase', 'replies', 'roles', 'schools', 'system_admin', 'themes');
        $tables = $this->db->list_tables();
        
         foreach ($tables as $table) {
             
            if(in_array($table, $skips)){continue;}             
            
           // $child_exist =$this->school->get_list($table, array('school_id'=>$id), '','', '', 'id', 'ASC');
            $child_exist =$this->school->delete($table, array('school_id'=>$id));
            /*if(!empty($child_exist)){
                 error($this->lang->line('pls_remove_child_data'));
                 redirect('administrator/school/index');
            }*/
        }    
     
        
        $school = $this->school->get_single('schools', array('id' => $id));
        
        if ($this->school->delete('schools', array('id' => $id))) {

             // delete syllabus file
            $destination = 'assets/uploads/logo/';
            if (file_exists( $destination.$school->frontend_logo)) {
                @unlink($destination.$school->frontend_logo);
            }
            if (file_exists( $destination.$school->logo)) {
                @unlink($destination.$school->logo);
            }
            
            create_log('Has been deleted a school : '.$school->school_name);  
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('administrator/school/index');
    }

}
