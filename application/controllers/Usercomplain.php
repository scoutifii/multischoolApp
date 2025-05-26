<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Usercomplain.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Complain
 * @description     : Manage complain.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Usercomplain extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Complain_Model', 'complain', true);  
        
        if($this->session->userdata('role_id') == SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard');
        }
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Complain List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
                         
        $this->data['complains'] = $this->complain->get_complain_list();
        $condition['status'] = 1;       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $condition['school_id']  = $this->session->userdata('school_id');           
        }
        $this->data['complain_types'] = $this->complain->get_list('complain_types', $condition, '','', '', 'id', 'ASC');
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_complain'). ' | ' . SMS);
        $this->layout->view('profile/complain', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Complain" user interface                 
    *                    and process to store "Complain" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_complain_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_complain_data();

                $insert_id = $this->complain->insert('complains', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a complain');                     
                    success($this->lang->line('insert_success'));
                    redirect('usercomplain/index/');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('usercomplain/add/');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
            
        $condition['status'] = 1;       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $condition['school_id']  = $this->session->userdata('school_id');
        }
        
        $this->data['complain_types'] = $this->complain->get_list('complain_types', $condition, '','', '', 'id', 'ASC');
        $this->data['complains'] = $this->complain->get_complain_list();  
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('profile/complain', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Complain" user interface                 
    *                    with populated "Complain" value 
    *                    and process to update "Complain" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('usercomplain/index');
        }
        
        if ($_POST) {
            $this->_prepare_complain_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_complain_data();
                $updated = $this->complain->update('complains', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a complain');                    
                    success($this->lang->line('update_success'));
                    redirect('usercomplain/index/');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('usercomplain/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['complain'] = $this->complain->get_single_complain('complains', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['complain'] = $this->complain->get_single_complain($id);

            if (!$this->data['complain']) {
                redirect('usercomplain/index');
            }
        }
        
     
        $condition['status'] = 1;       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $condition['school_id']  = $this->session->userdata('school_id');
        }        
        $this->data['complain_types'] = $this->complain->get_list('complain_types', $condition, '','', '', 'id', 'ASC');
        $this->data['complains'] = $this->complain->get_complain_list();  
        
      
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('profile/complain', $this->data);
    }

       
           
     /*****************Function get_single_complain**********************************
     * @type            : Function
     * @function name   : get_single_complain
     * @description     : "Load single complain information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_complain(){
        
       $complain_id = $this->input->post('complain_id');
       
       $this->data['complain'] = $this->complain->get_single_complain($complain_id);     
       echo $this->load->view('profile/get-single-complain', $this->data);
    }

    
    /*****************Function _prepare_complain_validation**********************************
    * @type            : Function
    * @function name   : _prepare_complain_validation
    * @description     : Process "complain" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_complain_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('type_id', $this->lang->line('complain_type'), 'trim|required');
        $this->form_validation->set_rules('complain_date', $this->lang->line('date'), 'trim|required');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'trim|required');
        
    }

    
    /*****************Function _get_posted_complain_data**********************************
    * @type            : Function
    * @function name   : _get_posted_complain_data
    * @description     : Prepare "Complain" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_complain_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'type_id';
        $items[] = 'description';

        $data = elements($items, $_POST);

        $data['complain_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('complain_date')));
        
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
        } else {
            
            $data['user_id']  = logged_in_user_id();
            $data['role_id']  = logged_in_role_id();
            $data['class_id'] = $this->session->userdata('class_id');
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->complain->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('usercomplain/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
            
        }


        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Complain" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('usercomplain/index');
        }
        
        $complain = $this->complain->get_single('complains', array('id' => $id));
        
        if ($this->complain->delete('complains', array('id' => $id))) {
            
            create_log('Has been deleted a complain : '.$complain->title);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('usercomplain/index/');
    }

}
