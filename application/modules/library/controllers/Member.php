<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Member extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Book_Model', 'book', true);        
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Library Member List" user interface                 
    *                        
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        
        $academic_year_id = '';
        $school_id = '';
        $class_id = '';
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }
        
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $this->session->userdata('school_id');
            $academic_year_id =  $this->session->userdata('academic_year_id'); 
        }else{         
            
            $school = $this->book->get_school_by_id($school_id);
            $academic_year_id = @$school->academic_year_id;
        }
                      
        $this->data['members'] = $this->book->get_library_member_list($is_library_member = 1, $school_id, $class_id, $academic_year_id); 
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['class_list'] = $this->book->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('library_member') . ' | ' . SMS);
        $this->layout->view('member/member', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Library Member" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        $academic_year_id = '';
        $school_id = '';
        $class_id = '';
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }
        
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $this->session->userdata('school_id');
            $academic_year_id =  $this->session->userdata('academic_year_id'); 
        }else{         
            
            $school = $this->book->get_school_by_id($school_id);
            $academic_year_id = @$school->academic_year_id;
        }
        
        $this->data['non_members'] = $this->book->get_library_member_list($is_library_member = 0, $school_id, $class_id, $academic_year_id);       
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['class_list'] = $this->book->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['non_list'] = TRUE;
        $this->layout->title($this->lang->line('non_member') . ' | ' . SMS);
        $this->layout->view('member/non_member', $this->data);
        
    }

        
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Library member" data from library member list                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('library/member/index');
        }
        
        $member = $this->book->get_single('library_members', array('id' => $id));
        if ($this->book->delete('library_members', array('id' => $id))) {
            $this->book->update('students', array('is_library_member' => 0), array('user_id' => $member->user_id));
            
            $student = $this->book->get_single('students', array('user_id' => $member->user_id));
            create_log('Has been deleted a Library Member : '.$student->name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('library/member/index');
    }


    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : Process to add/store "Library Member" into database                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function add_to_library() {

        $user_id = $this->input->post('user_id');

        if ($user_id) {
            
            $user   = $this->book->get_single('users', array('id' => $user_id));
            $member = $this->book->get_single('library_members', array('user_id' => $user_id));
            
            if (empty($member)) {

                $data['school_id'] = $user->school_id;
                $data['user_id'] = $user_id;
                $data['custom_member_id'] = $this->book->get_custom_id('library_members', 'LM');
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();

                $insert_id = $this->book->insert('library_members', $data);
                $this->book->update('students', array('is_library_member' => 1), array('user_id' => $user_id));
                echo TRUE;
            } else {
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
