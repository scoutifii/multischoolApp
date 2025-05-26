<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Image.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Image
 * @description     : Manage school Image for guardian, student, teacher and employee.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Image extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Image_Model', 'image', true);       
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Gallery Image List" user interface                 
    *                      
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['galleries'] = $this->image->get_list('galleries', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['images'] = $this->image->get_image_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_gallery_image') . ' | ' . SMS);
        $this->layout->view('image/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Gallery Image" user interface                 
    *                    and process to store "Image" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_image_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_image_data();

                $insert_id = $this->image->insert('gallery_images', $data);
                if ($insert_id) {
                    
                    create_log('Has been uploaded a gallery image : '.$data['caption']);                    
                    success($this->lang->line('insert_success'));
                    redirect('gallery/image/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('gallery/image/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['galleries'] = $this->image->get_list('galleries', $condition, '', '', '', 'id', 'ASC');
        }
        $this->data['images'] = $this->image->get_image_list();
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('image/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Gallery Image" user interface                 
    *                    with populated "Gallery Image" value 
    *                    and process to update "Gallery Image" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/image/index');
        }
        
        if ($_POST) {
            $this->_prepare_image_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_image_data();
                $updated = $this->image->update('gallery_images', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated gallery image : '.$data['caption']);                    
                    success($this->lang->line('update_success'));
                    redirect('gallery/image/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('gallery/image/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['image'] = $this->image->get_single('gallery_images', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['image'] = $this->image->get_single('gallery_images', array('id' => $id));

            if (!$this->data['image']) {
                redirect('gallery/image/index');
            }
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['galleries'] = $this->image->get_list('galleries', $condition, '', '', '', 'id', 'ASC');
        }
        $this->data['images'] = $this->image->get_image_list($this->data['image']->school_id);
        $this->data['school_id'] = $this->data['image']->school_id;
        $this->data['filter_school_id'] = $this->data['image']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('image/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific gallery image data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id) {

        check_permission(VIEW);

        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/image/index');
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['galleries'] = $this->image->get_list('galleries', $condition, '', '', '', 'id', 'ASC');
        }
        
        $this->data['image'] = $this->image->get_single_image($id);        
        $this->data['images'] = $this->image->get_image_list();
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('gallery')  . ' ' . $this->lang->line('image'). ' | ' . SMS);
        $this->layout->view('image/index', $this->data);
    }
    
    
                       
     /*****************Function get_single_news**********************************
     * @type            : Function
     * @function name   : get_single_news
     * @description     : "Load single news information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_image(){
        
       $image_id = $this->input->post('image_id');
       
       $this->data['image'] = $this->image->get_single_image($image_id);  
       echo $this->load->view('image/get-single-image', $this->data);
    }

    
    /*****************Function _prepare_image_validation**********************************
    * @type            : Function
    * @function name   : _prepare_image_validation
    * @description     : Process "gallery image" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_image_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('gallery_id', $this->lang->line('gallery'), 'trim|required');
        $this->form_validation->set_rules('image', $this->lang->line('image'), 'trim|callback_image');
    }
    
    /*****************Function image**********************************
    * @type            : Function
    * @function name   : image
    * @description     : validate gallery image type/format                  
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

    
    /*****************Function _get_posted_image_data**********************************
    * @type            : Function
    * @function name   : _get_posted_image_data
    * @description     : Prepare "gallery image" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_image_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'gallery_id';
        $items[] = 'caption';

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

    
    /*****************Function _upload_image**********************************
    * @type            : Function
    * @function name   : _upload_image
    * @description     : Process to to upload gallery image in the server
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

                $destination = 'assets/uploads/gallery/';

                $file_type = explode(".", $image);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $image_path = $this->input->post('gallery_id').'-image-' . time() . '-sms.' . $extension;

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
    * @description     : delete "Gallery image" from database                  
    *                    and unlink gallery image from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/image/index');
        }
        
        $image = $this->image->get_single('gallery_images', array('id' => $id));
        if ($this->image->delete('gallery_images', array('id' => $id))) {

            // delete gallery image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/gallery/' . $image->image)) {
                @unlink($destination . '/gallery/' . $image->image);
            }

            create_log('Has been deleted a gallery image : '.$image->caption);            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('gallery/image/index/'.$image->school_id);
        
    }
}