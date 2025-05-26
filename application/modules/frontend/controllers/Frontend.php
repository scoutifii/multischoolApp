<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Frontend.php**********************************
 * @product name    : Global School Management System Pro
 * @type            : Class
 * @class name      : Frontend
 * @description     : Manage school Frontend Pages for guardian, student, teacher and employee.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Frontend extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Frontend_Model', 'frontend', true);       
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Frontend Page List" user interface                 
    *                      
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['pages'] = $this->frontend->get_page_list($school_id); 
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_frontend_page') . ' | ' . SMS);
        $this->layout->view('frontend/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Frontend Page" user interface                 
    *                    and process to store "Frontend Page" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            
            $this->_prepare_frontend_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_frontend_data();

                $insert_id = $this->frontend->insert('pages', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a frontend page : '.$data['page_title']);                    
                    success($this->lang->line('insert_success'));
                    redirect('frontend/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontend/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['pages'] = $this->frontend->get_page_list(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('frontend/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Frontend Page" user interface                 
    *                    with populated "Frontend Page" value 
    *                    and process to update "Frontend Page" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('frontend/index');
        }
        
        if ($_POST) {
            $this->_prepare_frontend_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_frontend_data();
                $updated = $this->frontend->update('pages', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a frontend page : '.$data['page_title']);                    
                    success($this->lang->line('update_success'));
                    redirect('frontend/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontend/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['page'] = $this->frontend->get_single('pages', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['page'] = $this->frontend->get_single('pages', array('id' => $id));

            if (!$this->data['page']) {
                redirect('frontend/index');
            }
        }

        $this->data['pages'] = $this->frontend->get_page_list($this->data['page']->school_id); 
        $this->data['school_id'] = $this->data['page']->school_id;
        $this->data['filter_school_id'] = $this->data['page']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('frontend/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific frontend page data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id) {

        check_permission(VIEW);

        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('frontend/index');
        }
        
        $this->data['pages'] = $this->frontend->get_list('pages', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['page'] = $this->frontend->get_single('pages', array('id' => $id));        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('frontend') . ' ' . $this->lang->line('page') . ' | ' . SMS);
        $this->layout->view('frontend/index', $this->data);
    }
    
    
               
     /*****************Function get_single_frontend**********************************
     * @type            : Function
     * @function name   : get_single_frontend
     * @description     : "Load single frontend information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_frontend(){
        
       $frontend_id = $this->input->post('frontend_id');
       
       $this->data['frontend'] = $this->frontend->get_single_page($frontend_id);
       echo $this->load->view('get-single-frontend', $this->data);
    }

    
    /*****************Function _prepare_frontend_validation**********************************
    * @type            : Function
    * @function name   : _prepare_frontend_validation
    * @description     : Process "frontend page" user input data validation                 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_frontend_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school') . ' ' . $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('page_location', $this->lang->line('page') . ' '. $this->lang->line('location'), 'trim|required');
        $this->form_validation->set_rules('page_title', $this->lang->line('page_title'), 'trim|required|callback_page_title');
        $this->form_validation->set_rules('page_image', $this->lang->line('image'), 'trim|callback_page_image');
        $this->form_validation->set_rules('page_description', $this->lang->line('page_description'), 'trim|required');
    }

    
    /*****************Function page_name**********************************
    * @type            : Function
    * @function name   : title_name
    * @description     : Unique check for "frontend page name" data/value                  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function page_title() {
        if ($this->input->post('id') == '') {
            $frontend = $this->frontend->duplicate_check($this->input->post('school_id'), $this->input->post('page_title'));
            if ($frontend) {
                $this->form_validation->set_message('page_title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $frontend = $this->frontend->duplicate_check($this->input->post('school_id'), $this->input->post('page_title'), $this->input->post('id'));
            if ($frontend) {
                $this->form_validation->set_message('page_title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function page_image**********************************
    * @type            : Function
    * @function name   : page_image
    * @description     : validate frontend image type/format                  
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function page_image() {
        if ($_FILES['image']['name']) {
            $name = $_FILES['image']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('page_image', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }

    
    /*****************Function _get_posted_frontend_data**********************************
    * @type            : Function
    * @function name   : _get_posted_frontend_data
    * @description     : Prepare "frontend page" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_frontend_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'page_location';
        $items[] = 'page_title';
        $items[] = 'page_description';

        $data = elements($items, $_POST);        

        if($this->input->post('page_slug')){
            $data['page_slug'] = $this->input->post('page_slug');      
        }else{
            $data['page_slug'] = get_slug($data['page_title']);            
        }
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {            
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        if (isset($_FILES['image']['name'])) {
            $data['page_image'] = $this->_upload_image();
        }

        return $data;
    }

    
    /*****************Function _upload_image**********************************
    * @type            : Function
    * @function name   : _upload_image
    * @description     : Process to to upload frontend image in the server
    *                    and return image name                   
    *                       
    * @param           : null
    * @return          : $return_image string value 
    * ********************************************************** */
    private function _upload_image() {

        $prev_image = $this->input->post('prev_image');
        $image = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $return_image = '';
        if ($image != "") {
            if ($image_type == 'image/jpeg' || $image_type == 'image/pjpeg' ||
                    $image_type == 'image/jpg' || $image_type == 'image/png' ||
                    $image_type == 'image/x-png' || $image_type == 'image/gif') {

                $destination = 'assets/uploads/page/';

                $file_type = explode(".", $image);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $image_path = 'frontend-page-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['image']['tmp_name'], $destination . $image_path);

                // need to unlink previous image
                if ($prev_image != "") {
                    if (file_exists($destination . $prev_image)) {
                        @unlink($destination . $prev_image);
                    }
                }

                $return_image = $image_path;
            }
        } else {
            $return_image = $prev_image;
        }

        return $return_image;
    }

      
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "frontend image" from database                  
    *                    and unlink frontend image from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('frontend/index');
        }
        
        $frontend = $this->frontend->get_single('pages', array('id' => $id));
        if ($this->frontend->delete('pages', array('id' => $id))) {

            // delete teacher resume and image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/page/' . $frontend->page_image)) {
                @unlink($destination . '/page/' . $frontend->page_image);
            }
            
            create_log('Has been deleted a frontend page : '.$frontend->page_title);
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontend/index/'.$frontend->school_id);
    }
    
    
    

}
