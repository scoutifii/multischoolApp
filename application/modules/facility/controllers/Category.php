<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Category extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Category_Model', 'category', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Academic School category List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        //$this->data['facility_categories'] = $this->category->get_list('facility_categories', array(), '','', '', 'id', 'ASC');
        $this->data['facility_categories'] = $this->category->get_category_list($school_id);
        $this->data['themes'] = $this->category->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_school_facility_category'). ' | ' . SMS);
        $this->layout->view('facility/category/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Academic School Facility Category" user interface                 
    *                    and store "Academic School category" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_school_facility_category_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_facility_category_data();

                $insert_id = $this->category->insert('facility_categories', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a category : '.$data['category_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('facility/category/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('facility/category/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['facility_categories'] = $this->category->get_list('facility_categories', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->category->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('category'). ' | ' . SMS);
        $this->layout->view('facility/category/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Academic School category" user interface                 
    *                    with populated "Academic School category" value 
    *                    and update "Academic School category" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    /*public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_school_facility_category_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_facility_category_data();
                $updated = $this->category->update('facility_categories', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                     create_log('Has been updated a school facility category : '.$data['category_name']);  
                    
                    success($this->lang->line('update_success'));
                    redirect('facility/category/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('facility/category/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['category'] = $this->category->get_single('facility_categories', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['category'] = $this->category->get_single('facility_categories', array('id' => $id));
 
                if (!$this->data['category']) {
                     redirect('facility/category/index');
                }
            }
        }

        $this->data['facility_categories'] = $this->category->get_list('facility_categories', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->category->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('manage_school_facility_category'). ' | ' . SMS);
        $this->layout->view('facility/category/index', $this->data);
    }
    */

     public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_school_facility_category_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_facility_category_data();
                $updated = $this->category->update('facility_categories', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                     create_log('Has been updated a school facility category : '.$data['category_name']);  
                    
                    success($this->lang->line('update_success'));
                    redirect('facility/category/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('facility/category/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['category'] = $this->category->get_single('facility_categories', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['category'] = $this->category->get_single('facility_categories', array('id' => $id));
 
                if (!$this->data['category']) {
                     redirect('facility/category/index');
                }
            }
        }

        $this->data['facility_categories'] = $this->category->get_list('facility_categories', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->category->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('manage_school_facility_category'). ' | ' . SMS);
        $this->layout->view('facility/category/index', $this->data);
    }
    
    
    
        
        
    /*****************Function get_single_school_facility_category**********************************
     * @type            : Function
     * @function name   : get_single_school_facility_category
     * @description     : "Load single school information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_school_facility_category(){
        
       $category_id = $this->input->post('category_id');
       
       $this->data['categories'] = $this->category->get_single_category($category_id);
       echo $this->load->view('facility/category/get-single-category', $this->data);
    }

    
    /*****************Function _prepare_school_facility_category_validation**********************************
    * @type            : Function
    * @function name   : _prepare_school_facility_category_validation
    * @description     : Process "Academic School category" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_school_facility_category_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        /*$this->form_validation->set_rules('school_id', $this->lang->line('school') . ' ' . $this->lang->line('name'), 'trim|required|callback_school_id');
        $this->form_validation->set_rules('category_name', $this->lang->line('category') . ' ' . $this->lang->line('name'), 'trim|required|callback_category_name');*/
        $this->form_validation->set_rules('category_type', $this->lang->line('category_type'), 'trim|required');
        $this->form_validation->set_rules('footer', $this->lang->line('footer'), 'trim');
    }

            
    /*****************Function session_school**********************************
    * @type            : Function
    * @function name   : session_school
    * @description     : Unique check for "academic school" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** * 
    public function category_name() {
        if ($this->input->post('id') == '') {
            $category = $this->category->duplicate_check($this->input->post('category_name'));
            if ($category) {
                $this->form_validation->set_message('category_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $category = $this->category->duplicate_check($this->input->post('category_name'), $this->input->post('id'));
            if ($category) {
                $this->form_validation->set_message('category_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    /*****************Function _get_posted_school_facility_category_data**********************************
     * @type            : Function
     * @function name   : _get_posted_school_facility_category_data
     * @description     : Prepare "Academic School category" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_school_facility_category_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'category_name';
        $items[] = 'category_type';
        
        $data = elements($items, $_POST);     
       
        
        if ($this->input->post('id')) {
            $data['status'] = $this->input->post('status');
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
   * @description     : delete "Academic School Facility Category" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {
        
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('facility/category/index');              
        }
        
        // need to find all child data from database
        if(!true){
            error($this->lang->line('pls_remove_child_data'));
            redirect('facility/category/index');
        }
        
        $category = $this->category->get_single('facility_categories', array('id' => $id));
        
        if ($this->category->delete('facility_categories', array('id' => $id))) {

            create_log('Has been deleted a school facility category : '.$category->category_name);  
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('facility/category/index');
    }

}
