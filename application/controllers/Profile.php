<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends My_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Profile_Model', 'profile', true);        
    }

    public $data = array();

    /**     * *************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : this function used to load logged in user profile information            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    public function index() {

        $this->layout->title($this->lang->line('my_profile') . ' | ' . SMS);

        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        $profile_id = $this->session->userdata('profile_id');
        $district_id = $this->session->userdata('district_id');
        $academic_year_id = '';
        if ($role_id != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');
            $school = $this->profile->get_school_by_id($school_id);
            $academic_year_id = $school->academic_year_id;
        }

        $this->data['profile'] = get_user_by_role($role_id, $user_id, $academic_year_id);
        
        $this->data['info'] = TRUE;
        $this->data['roles'] = $this->profile->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');

         if ($role_id == SUPER_ADMIN) {
             
            $this->layout->view('profile/system_admin', $this->data);
            
         } else if ($role_id == DISTRICT_ADMIN) {
             
            $district = $this->profile->get_district_by_id($this->data['profile']->district_id);            
            $this->data['districts'] = $this->profile->get_school_list($district->district_id);
            $this->layout->view('profile/district_admin', $this->data);
            
         } else if ($role_id == STUDENT) {
            
            $this->load->helper('report');
                       
            $class_id = $this->session->userdata('class_id');           
            $this->data['guardian'] = $this->profile->get_single_guardian($this->data['profile']->guardian_id);
            
            $this->data['guardians'] = $this->profile->get_list('guardians', array('status' => 1), '', '', '', 'id', 'ASC');
            $this->data['classes'] = $this->profile->get_list('classes', array('status' => 1, 'school_id'=>$school_id, 'id'=>$class_id), '', '', '', 'id', 'ASC');
            
            $this->data['days'] = 31;
            $this->data['academic_year_id'] = $school->academic_year_id;
            $this->data['class_id'] = $this->data['profile']->class_id;
            $this->data['section_id'] = $this->data['profile']->section_id;
            $this->data['student_id'] = $profile_id;
            $this->data['school_id'] = $this->data['profile']->school_id;

            $this->data['exams'] = $this->profile->get_list('exams', array('status' => 1, 'school_id'=>$this->data['profile']->school_id, 'academic_year_id' => $school->academic_year_id), '', '', '', 'id', 'ASC');
            $this->data['types'] = $this->profile->get_list('student_types', array('status' => 1, 'school_id'=>$this->data['profile']->school_id), '', '', '', 'id', 'ASC');
            $this->data['invoices'] = $this->profile->get_invoice_list($profile_id);  
            $this->data['activity'] = $this->profile->get_activity_list($profile_id); 
            
            
            $this->layout->view('profile/student', $this->data);
            
        } elseif ($role_id == GUARDIAN) {
            
            
            $school = $this->profile->get_school_by_id($this->data['profile']->school_id);            
            $this->data['students'] = $this->profile->get_student_list($profile_id, $school->academic_year_id);
            $this->layout->view('profile/guardian', $this->data);
            
        } elseif ($role_id == TEACHER) {
            
            $this->layout->view('profile/teacher', $this->data);
            
        } else {
            
            $this->layout->view('profile/employee', $this->data);
            
        }
    }

    
    /***************Function update**********************************
     * @type            : Function
     * @function name   : update
     * @description     : this function used to update logged user profile inormation            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    public function update() {

        if ($_POST) {

            $data = $this->_get_posted_data();
            
            if ($this->input->post('user_type') == 'system_admin') {
                $updated = $this->profile->update('system_admin', $data, array('id' => $this->input->post('id')));
            }

            if ($this->input->post('user_type') == 'district_admin') {
                $updated = $this->profile->update('district_admin', $data, array('id' => $this->input->post('id')));
            }
            
            if ($this->input->post('user_type') == 'employee') {
                $updated = $this->profile->update('employees', $data, array('id' => $this->input->post('id')));
            }
            
            if ($this->input->post('user_type') == 'teacher') {
                $updated = $this->profile->update('teachers', $data, array('id' => $this->input->post('id')));
            }
            if ($this->input->post('user_type') == 'guardian') {
                $updated = $this->profile->update('guardians', $data, array('id' => $this->input->post('id')));
            }
            if ($this->input->post('user_type') == 'student') {
                $updated = $this->profile->update('students', $data, array('id' => $this->input->post('id')));
            }
        }

        success($this->lang->line('update_success'));
        create_log('Update Profile');
        redirect('profile');
    }

    /**     * *************Function password**********************************
     * @type            : Function
     * @function name   : password
     * @description     : this function used to reset logged user password            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    public function password() {

        if ($_POST) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[30]');
            $this->form_validation->set_rules('conf_password', $this->lang->line('conf_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                $data['password'] = md5($this->input->post('password'));
                $data['temp_password'] = base64_encode($this->input->post('password'));
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                $this->profile->update('users', $data, array('id' => logged_in_user_id()));
                
                success($this->lang->line('update_success'));                
                $profile = $this->profile->get_single('users', array('id' => logged_in_user_id()));
                
                create_log('Update Password');
                redirect('profile');
               
            }
        }

        $this->layout->title($this->lang->line('reset_password') . ' | ' . SMS);
        $this->layout->view('profile/password', $this->data);
    }

    /**     * *************Function _get_posted_data**********************************
     * @type            : Function
     * @function name   : _get_posted_data
     * @description     : this private function used to maintain/prepare user post data/value            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    private function _get_posted_data() {

        $items = array();
        // only for employee and teacher
        
        if ($this->input->post('user_type') == 'system_admin') {
            $items[] = 'gender';
            $items[] = 'blood_group';
            $items[] = 'name';
            $items[] = 'national_id';
            $items[] = 'phone';
            $items[] = 'email';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'religion';          
            $items[] = 'other_info';
        }

        if ($this->input->post('user_type') == 'district_admin') {
            $items[] = 'gender';
            $items[] = 'blood_group';
            $items[] = 'name';
            $items[] = 'national_id';
            $items[] = 'phone';
            $items[] = 'email';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'religion';          
            $items[] = 'other_info';
        }
        
        if ($this->input->post('user_type') == 'teacher') {
            $items[] = 'gender';
            $items[] = 'blood_group';
            $items[] = 'name';
            $items[] = 'national_id';
            $items[] = 'phone';
            $items[] = 'email';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'religion';
            $items[] = 'other_info';
        }
        
        if ($this->input->post('user_type') == 'employee') {
            $items[] = 'name';
            $items[] = 'national_id';
            $items[] = 'gender';
            $items[] = 'blood_group';
            $items[] = 'phone';
            $items[] = 'email';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'religion';
            $items[] = 'other_info';
        }
        
        if ($this->input->post('user_type') == 'guardian') {
            $items[] = 'national_id';
            $items[] = 'name';       
            $items[] = 'email';       
            $items[] = 'phone';
            $items[] = 'profession';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'religion';
            $items[] = 'other_info';
        }
        
        if ( $this->input->post('user_type') == 'student') {
            $items[] = 'name';
            $items[] = 'gender';
            $items[] = 'blood_group';
            $items[] = 'religion';
            $items[] = 'caste';
            $items[] = 'relation_with';
            $items[] = 'phone';
            $items[] = 'email';
            $items[] = 'national_id';
            $items[] = 'present_address';
            $items[] = 'permanent_address';
            $items[] = 'second_language';
            $items[] = 'father_name';
            $items[] = 'father_phone';
            $items[] = 'father_education';
            $items[] = 'father_profession';
            $items[] = 'father_designation';
            $items[] = 'mother_name';
            $items[] = 'mother_phone';
            $items[] = 'mother_education';
            $items[] = 'mother_profession';
            $items[] = 'mother_designation';
            $items[] = 'other_info';
            $items[] = 'health_condition';
        }

      
        
        // only for employee and teacher
        if ( $this->input->post('user_type') == 'employee' || $this->input->post('user_type') == 'teacher') {
            $items[] = 'is_view_on_web';
            $items[] = 'facebook_url';
            $items[] = 'linkedin_url';
            $items[] = 'twitter_url';
            $items[] = 'google_plus_url';
            $items[] = 'instagram_url';
            $items[] = 'youtube_url';
            $items[] = 'pinterest_url';
        }        
        
        $data = elements($items, $_POST);
        
        if ($this->input->post('user_type') == 'system_admin' || $this->input->post('user_type') == 'district_admin' || $this->input->post('user_type') == 'employee' || $this->input->post('user_type') == 'teacher') {

            $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));           

            if ($_FILES['resume']['name']) {
                $data['resume'] = $this->_upload_resume();
            }
        }        

        if ($this->input->post('user_type') == 'student') {
            
            $data['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
            
            if ($_FILES['father_photo']['name']) {
                $data['father_photo'] = $this->_upload_father_photo();
            }
            if ($_FILES['mother_photo']['name']) {
                $data['mother_photo'] = $this->_upload_mother_photo();
            }
        }        

        if ($_FILES['photo']['name']) {
            $data['photo'] = $this->_upload_photo();
        }

        // common data 
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        return $data;
    }

    /**     * *************Function _upload_photo**********************************
     * @type            : Function
     * @function name   : _upload_photo
     * @description     : this private function used to upload user profile photo            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */
    private function _upload_photo() {

        $prev_photo = $this->input->post('prev_photo');
        
        $user_type  =  $this->input->post('user_type');
        
        // system admin and district admin photo folder also same as employee
        if($this->input->post('user_type') == 'system_admin' || 'district_admin'){
            $user_type = 'employee';
        }
        
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                $destination = 'assets/uploads/' . $user_type . '-photo/';

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

    
    
    /*     * **************Function _upload_photo**********************************
     * @type            : Function
     * @function name   : _upload_photo
     * @description     : this private function used to upload user profile resume            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    private function _upload_resume() {

        $prev_resume = $this->input->post('prev_resume');
        
        $user_type  =  $this->input->post('user_type');        
        // system admin and district admin resume folder also same as employee
        if($this->input->post('user_type') == 'system_admin' || 'district_admin'){
            $user_type = 'employee';
        }
        
        $resume = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $return_resume = '';

        if ($resume != "") {
            if ($resume_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $resume_type == 'application/msword' || $resume_type == 'text/plain' ||
                    $resume_type == 'application/vnd.ms-office' || $resume_type == 'application/pdf') {

                $destination = 'assets/uploads/' . $user_type . '-resume/';

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
    
    
    
    
               
    /*****************Function _upload_father_photo**********************************
    * @type            : Function
    * @function name   : _upload_father_photo
    * @description     : process to upload student profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_father_photo string value 
    * ********************************************************** */
    private function _upload_father_photo() {

        $prev_father_photo = $this->input->post('prev_father_photo');
        $father_photo = $_FILES['father_photo']['name'];
        $father_photo_type = $_FILES['father_photo']['type'];
        $return_father_photo = '';
        if ($father_photo != "") {
            if ($father_photo_type == 'image/jpeg' || $father_photo_type == 'image/pjpeg' ||
                    $father_photo_type == 'image/jpg' || $father_photo_type == 'image/png' ||
                    $father_photo_type == 'image/x-png' || $father_photo_type == 'image/gif') {

                $destination = 'assets/uploads/father-photo/';

                $file_type = explode(".", $father_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $father_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['father_photo']['tmp_name'], $destination . $father_photo_path);

                // need to unlink previous father_photo
                if ($prev_father_photo != "") {
                    if (file_exists($destination . $prev_father_photo)) {
                        @unlink($destination . $prev_father_photo);
                    }
                }

                $return_father_photo = $father_photo_path;
            }
        } else {
            $return_father_photo = $prev_father_photo;
        }

        return $return_father_photo;
    }
    
    
    
               
    /*****************Function _upload_mother_photo**********************************
    * @type            : Function
    * @function name   : _upload_mother_photo
    * @description     : process to upload mother profile photo in the server                  
    *                     and return photo file name  
    * @param           : null
    * @return          : $return_mother_photo string value 
    * ********************************************************** */
    private function _upload_mother_photo() {

        $prev_mother_photo = $this->input->post('prev_mother_photo');
        $mother_photo = $_FILES['mother_photo']['name'];
        $mother_photo_type = $_FILES['mother_photo']['type'];
        $return_mother_photo = '';
        if ($mother_photo != "") {
            if ($mother_photo_type == 'image/jpeg' || $mother_photo_type == 'image/pjpeg' ||
                    $mother_photo_type == 'image/jpg' || $mother_photo_type == 'image/png' ||
                    $mother_photo_type == 'image/x-png' || $mother_photo_type == 'image/gif') {

                $destination = 'assets/uploads/mother-photo/';

                $file_type = explode(".", $mother_photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $mother_photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['mother_photo']['tmp_name'], $destination . $mother_photo_path);

                // need to unlink previous mother_photo
                if ($prev_mother_photo != "") {
                    if (file_exists($destination . $prev_mother_photo)) {
                        @unlink($destination . $prev_mother_photo);
                    }
                }

                $return_mother_photo = $mother_photo_path;
            }
        } else {
            $return_mother_photo = $prev_mother_photo;
        }

        return $return_mother_photo;
    }
}