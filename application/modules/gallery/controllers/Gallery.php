<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Gallery.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Gallery
 * @description     : Manage school Gallery for guardian, student, teacher and employee.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Gallery extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Gallery_Model', 'gallery', true);       
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Gallery List" user interface                 
    *                      
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['galleries'] = $this->gallery->get_gallery_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_gallery') . ' | ' . SMS);
        $this->layout->view('gallery/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Gallery" user interface                 
    *                    and process to store "Gallery" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_gallery_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_gallery_data();

                $insert_id = $this->gallery->insert('galleries', $data);
                if ($insert_id) {
                    
                     create_log('Has been created a Gallery : '.$data['title']);
                     
                    success($this->lang->line('insert_success'));
                    redirect('gallery/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('gallery/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
        
        $this->data['galleries'] = $this->gallery->get_gallery_list();
        $this->data['schools'] = $this->schools;

        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('gallery/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Gallery" user interface                 
    *                    with populated "Gallery" value 
    *                    and process to update "Gallery" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/index');
        }
        
        if ($_POST) {
            $this->_prepare_gallery_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_gallery_data();
                
                // get gallery for update gallery image
                $updated = $this->gallery->update('galleries', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $this->gallery->update('gallery_images', array('school_id'=>$data['school_id']), array('gallery_id' => $this->input->post('id')));
                    
                    create_log('Has been updated a Gallery : '.$data['title']);                    
                    success($this->lang->line('update_success'));
                    redirect('gallery/index/'.$data['school_id']);
                    
                } else {
                    
                    error($this->lang->line('update_failed'));
                    redirect('gallery/edit/' . $this->input->post('id'));
                    
                }
            } else {
                $this->data['gallery'] = $this->gallery->get_single('galleries', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['gallery'] = $this->gallery->get_single('galleries', array('id' => $id));

            if (!$this->data['gallery']) {
                redirect('gallery/index');
            }
        }

        $this->data['galleries'] = $this->gallery->get_gallery_list($this->data['gallery']->school_id);
        
        $this->data['school_id'] = $this->data['gallery']->school_id;
        $this->data['filter_school_id'] = $this->data['gallery']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('gallery/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific gallery data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id) {

        check_permission(VIEW);

        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/index');
        }
        
        
       $this->data['galleries'] = $this->gallery->get_gallery_list();
        
        
        $this->data['gallery'] = $this->gallery->get_single('galleries', array('id' => $id));        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('gallery') . ' | ' . SMS);
        $this->layout->view('gallery/index', $this->data);
    }

    
    /*****************Function _prepare_gallery_validation**********************************
    * @type            : Function
    * @function name   : _prepare_gallery_validation
    * @description     : Process "gallery" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_gallery_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "gallery title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function title() {
        if ($this->input->post('id') == '') {
            $gallery = $this->gallery->duplicate_check($this->input->post('school_id'), $this->input->post('title'));
            if ($gallery) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $gallery = $this->gallery->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('id'));
            if ($gallery) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_gallery_data**********************************
    * @type            : Function
    * @function name   : _get_posted_gallery_data
    * @description     : Prepare "gallery" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_gallery_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'note';
        $items[] = 'is_view_on_web';

        $data = elements($items, $_POST);

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
                        
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "gallery" from database                  
    *                    and unlink gallery image from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('gallery/index');
        }
        
        $images = $this->gallery->get_list('gallery_images', array('gallery_id'=>$id), '', '', '', 'id', 'ASC');        
        if(!empty($images)){
            error($this->lang->line('pls_remove_child_data'));
            redirect('gallery/index');
        }
        
        $gallery = $this->gallery->get_single('galleries', array('id' => $id));
        
        if ($this->gallery->delete('galleries', array('id' => $id))) {

            create_log('Has been deleted a Gallery : '.$gallery->title);
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('gallery/index/'.$gallery->school_id);
    }

}