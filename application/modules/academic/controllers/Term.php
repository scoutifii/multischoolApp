<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Term extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
                 
         $this->load->model('Term_Model', 'term', true);
    }

    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Class section list" user interface                 
     *                    with class wise section list   
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function index($school_id = null){
        $this->output->delete_cache();
        check_permission(VIEW); 
        
        // for super admin 
        $school_id = '';

        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id'); 
        }  
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['terms'] = $this->term->get_term_list($school_id); 

        $this->data['list'] = TRUE;
        $this->data['schools'] = $this->schools;
        $this->layout->title($this->lang->line('manage_term'). ' | ' . SMS);
        $this->layout->view('term/index', $this->data); 
    }

    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new School Term" user interface                 
     *                    and store "School Term" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    public function add(){
        
        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_term_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_term_data();

                $insert_id = $this->term->insert('school_term', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a school_term : '.$data['name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('academic/term/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('academic/term/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
            
        } 
        

        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('term/index', $this->data);
    }

    /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "School Term" user interface                 
     *                    with populated "School Term" value 
     *                    and update "School Term" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null){
        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/term/index/');
        }

        if ($_POST) {
            $this->_prepare_term_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_term_data();
                $updated = $this->term->update('school_term', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    create_log('Has been updated a school term : '. $data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('academic/term/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('academic/term/edit/' . $this->input->post('id'));
                }
            } else {    
                error($this->lang->line('update_failed'));
                $this->data['term'] = $this->term->get_single('school_term', array('id' => $this->input->post('id')));
            }
            
        }

        if ($id) {
            $this->data['term'] = $this->term->get_single('school_term', array('id' => $id));

            if (!$this->data['term']) {
                 redirect('academic/term/index/');      
            }
        } 
        
        $this->data['school_id'] = $this->school_id;
        $this->data['filter_school_id'] = $this->school_id;
        
        $this->data['schools'] = $this->schools;
        $this->data['terms'] = $this->terms;
        $this->data['edit'] = TRUE; 
        $this->data['term_id'] = $this->data['term']->term_id;
        
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('academic/term/index', $this->data);
    }


    /*****************Function _prepare_term_validation**********************************
     * @type            : Function
     * @function name   : _prepare_term_validation
     * @description     : Process "School Term" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_term_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('term_start', $this->lang->line('term_start'), 'trim|required');
        $this->form_validation->set_rules('term_end', $this->lang->line('term_end'), 'trim|required'); 
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required');
    }

    /*****************Function _get_posted_term_data**********************************
     * @type            : Function
     * @function name   : _get_posted_term_data
     * @description     : Prepare "School Term" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */ 
    private function _get_posted_term_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'note';
        
        $data = elements($items, $_POST);
        
        $school = $this->term->get_school_by_id($this->input->post('school_id'));
        $data['term_start'] = date('Y-m-d', strtotime($this->input->post('term_start')));
        $data['term_end'] = date('Y-m-d', strtotime($this->input->post('term_end')));
        $data['duration'] = floor((strtotime($data['term_end']) - strtotime($data['term_start']))/86400);
        $data['academic_year_id'] = $school->academic_year_id;
        
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
     * @description     : delete "School Term" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/term/index/');
        }
        
        $term = $this->term->get_single('school_term', array('id' => $id));
        if ($this->term->delete('school_term', array('id' => $id))) {  
            
            create_log('Has been deleted a school term : '. $term->name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('academic/term/index/');
    }
}