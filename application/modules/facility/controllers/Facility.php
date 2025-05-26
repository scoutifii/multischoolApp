<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Facility extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Facility_Model', 'facility', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Academic School Facility List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        //$this->data['school_facilitie'] = $this->facility->get_list('school_facilities', array(), '','', '', 'id', 'ASC');
        $this->data['school_facilities'] = $this->facility->get_facility_list($school_id);
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $condition = array();
            $condition['status'] = 1;
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['categories'] = $this->facility->get_list('facility_categories', $condition, '','', '', 'id', 'ASC');
            $this->data['facility_list'] = $this->facility->get_list('facility_categories', $condition, '','', '', 'id', 'ASC');
        }

        $this->data['schools'] = $this->schools;
        $this->data['themes'] = $this->facility->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_school_facility'). ' | ' . SMS);
        $this->layout->view('facility/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Academic School Facility" user interface                 
    *                    and store "Academic School Facility" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_school_facility_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_facility_data();

                $insert_id = $this->facility->insert('school_facilities', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a facility : '.$data['facility_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('facility/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('facility/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['school_facilities'] = $this->facility->get_list('school_facilities', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->facility->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('facility'). ' | ' . SMS);
        $this->layout->view('facility/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Academic School Facility" user interface                 
    *                    with populated "Academic School Facility" value 
    *                    and update "Academic School Facility" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);
       
        if ($_POST) {
            $this->_prepare_school_facility_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_school_facility_data();
                $updated = $this->facility->update('school_facilities', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                     create_log('Has been updated a school facility : '.$data['facility_name']);  
                    
                    success($this->lang->line('update_success'));
                    redirect('facility/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('facility/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['facility'] = $this->facility->get_single('school_facilities', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['facility'] = $this->facility->get_single('school_facilities', array('id' => $id));
 
                if (!$this->data['facility']) {
                     redirect('facility/index');
                }
            }
        }

        $this->data['school_facilities'] = $this->facility->get_list('school_facilities', array('status' => 1), '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->facility->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('manage_school_facility'). ' | ' . SMS);
        $this->layout->view('facility/index', $this->data);
    }
    
    
        
        
    /*****************Function get_single_school_facility**********************************
     * @type            : Function
     * @function name   : get_single_school_facility
     * @description     : "Load single school information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_facility(){
        
       $facility_id = $this->input->post('facility_id');
       
       $this->data['facilities'] = $this->facility->get_single_facility($facility_id);
       echo $this->load->view('facility/get-single-facility', $this->data);
    }

    
    /*****************Function _prepare_school_facility_validation**********************************
    * @type            : Function
    * @function name   : _prepare_school_facility_validation
    * @description     : Process "Academic School Facility" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_school_facility_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
      
        //$this->form_validation->set_rules('facility_name', $this->lang->line('facility') . ' ' . $this->lang->line('name'), 'trim|required|callback_facility_name');
        //$this->form_validation->set_rules('school_id', $this->lang->line('school_id'), 'trim|required');
        $this->form_validation->set_rules('facility_no', $this->lang->line('facility_no'), 'trim|required');
        //$this->form_validation->set_rules('category_id', $this->lang->line('category_id'), 'trim|required');
        $this->form_validation->set_rules('footer', $this->lang->line('footer'), 'trim');
    }

            
    /*****************Function session_school**********************************
    * @type            : Function
    * @function name   : session_school
    * @description     : Unique check for "academic school" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function facility_name() {
        if ($this->input->post('id') == '') {
            $facility = $this->facility->duplicate_check($this->input->post('facility_name'));
            if ($facility) {
                $this->form_validation->set_message('facility_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $facility = $this->facility->duplicate_check($this->input->post('facility_name'), $this->input->post('id'));
            if ($facility) {
                $this->form_validation->set_message('facility_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    /*****************Function _get_posted_school_facility_data**********************************
     * @type            : Function
     * @function name   : _get_posted_school_facility_data
     * @description     : Prepare "Academic School Facility" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_school_facility_data() {

        $items = array();
        
        $items[] = 'school_id';
        $items[] = 'facility_name';
        $items[] = 'facility_no';
        $items[] = 'category_id';
        
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
   * @description     : delete "Academic School Facility" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {
        
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('facility/index');              
        }
        
        // need to find all child data from database
        if(!true){
            error($this->lang->line('pls_remove_child_data'));
            redirect('facility/index');
        }
        
        $facility = $this->facility->get_single('school_facilities', array('id' => $id));
        
        if ($this->facility->delete('school_facilities', array('id' => $id))) {

            create_log('Has been deleted a school facility : '.$facility->facility_name);  
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('facility/index');
    }

}
