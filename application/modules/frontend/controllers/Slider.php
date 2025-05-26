<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Slider.php**********************************
 * @product name    : Global - Multi School Management System Pro
 * @type            : Class
 * @class name      : Slider
 * @description     : Manage school Slider frontend website.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Slider extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Slider_Model', 'slider', true);       
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Home Slider List" user interface                 
    *                      
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['sliders'] = $this->slider->get_slider_list($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_slider') . ' | ' . SMS);
        $this->layout->view('slider/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Slider Image" user interface                 
    *                    and process to store "Slider" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_slider_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_slider_data();

                $insert_id = $this->slider->insert('sliders', $data);
                if ($insert_id) {
                    
                    create_log('Has been upload slider image : '. $data['title']);                    
                    success($this->lang->line('insert_success'));
                    redirect('frontend/slider/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontend/slider/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['sliders'] = $this->slider->get_slider_list(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('slider/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Home Slider" user interface                 
    *                    with populated "Home Slider" value 
    *                    and process to update "Home Slider" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('frontend/slider/index');
        }
        
        if ($_POST) {
            $this->_prepare_slider_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_slider_data();
                $updated = $this->slider->update('sliders', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated uploaded slider image : '. $data['title']);                    
                    success($this->lang->line('update_success'));
                    redirect('frontend/slider/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontend/slider/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['slider'] = $this->slider->get_single('sliders', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['slider'] = $this->slider->get_single('sliders', array('id' => $id));

            if (!$this->data['slider']) {
                redirect('frontend/slider/index');
            }
        }

        $this->data['sliders'] = $this->slider->get_slider_list($this->data['slider']->school_id); 
        $this->data['school_id'] = $this->data['slider']->school_id;
        $this->data['filter_school_id'] = $this->data['slider']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('slider/index', $this->data);
    }

        
           
     /*****************Function get_single_slider**********************************
     * @type            : Function
     * @function name   : get_single_slider
     * @description     : "Load single assignment information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_slider(){
        
       $slider_id = $this->input->post('slider_id');
       
       $this->data['slider'] = $this->slider->get_single_slider($slider_id);
       echo $this->load->view('slider/get-single-slider', $this->data);
    }

    
    /*****************Function _prepare_slider_validation**********************************
    * @type            : Function
    * @function name   : _prepare_slider_validation
    * @description     : Process "gallery slider" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_slider_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');  
        $this->form_validation->set_rules('image', $this->lang->line('image'), 'trim|callback_image');
    }
    
    /*****************Function image**********************************
    * @type            : Function
    * @function name   : image
    * @description     : validate  slider  image type/format                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function image() {
        
        if ($this->input->post('id')) {
            if (!empty($_FILES['image']['name'])) {
                $name = $_FILES['image']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('image', $this->lang->line('select_valid_file_format'));
                    return FALSE;
                }
            }
        }else{
            if (isset($_FILES['image']['name'])) {
                $name = $_FILES['image']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('image', $this->lang->line('select_valid_file_format'));
                    return FALSE;
                }
            } else {
                $this->form_validation->set_message('image', $this->lang->line('required_field'));
                return FALSE;
            }
        }
    }

    
    /*****************Function _get_posted_slider_data**********************************
    * @type            : Function
    * @function name   : _get_posted_slider_data
    * @description     : Prepare "Home slider" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_slider_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        if (isset($_FILES['image']['name'])) {
            $data['image'] = $this->_upload_image();
        }

        return $data;
    }

    
    /*****************Function _upload_slider**********************************
    * @type            : Function
    * @function name   : _upload_slider
    * @description     : Process to to upload gallery slider in the server
    *                    and return slider name                   
    *                       
    * @param           : null
    * @return          : $return_slider string value 
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

                $destination = 'assets/uploads/slider/';

                $file_type = explode(".", $image);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $image_path = 'home-slider-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['image']['tmp_name'], $destination . $image_path);

                // need to unlink previous slider
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
    * @description     : delete "Home slider" from database                  
    *                    and unlink Home slider from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('frontend/slider/index');
        }
        
        $slider = $this->slider->get_single('sliders', array('id' => $id));
        if ($this->slider->delete('sliders', array('id' => $id))) {

            // delete gallery slider
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/slider/' . $slider->image)) {
                @unlink($destination . '/slider/' . $slider->image);
            }

            create_log('Has been deletd a slider image : ' . $slider->title);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontend/slider/index/'.$slider->school_id);
    }

}