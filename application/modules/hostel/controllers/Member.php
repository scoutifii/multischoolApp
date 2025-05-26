<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Member.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Member
 * @description     : Manage hostel member from the student whose are resident in the hostel.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Member extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Member_Model', 'member', true);
        
    }

    
       
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Hostel Hostel List" user interface                 
    *                      
    * @param           : null
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
            
            $school = $this->member->get_school_by_id($school_id);
            $academic_year_id = @$school->academic_year_id;
        }
      
        $this->data['members'] = $this->member->get_hostel_member_list($is_hostel_member = 1, $school_id, $class_id, $academic_year_id);  
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['class_list'] = $this->member->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('hostel_member') . ' | ' . SMS);
        $this->layout->view('member/member', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Member" user interface                 
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
            
            $school = $this->member->get_school_by_id($school_id);
            $academic_year_id = @$school->academic_year_id;
        }        
        
        $this->data['non_members'] = $this->member->get_hostel_member_list($is_hostel_member = 0, $school_id, $class_id, $academic_year_id);       
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
        }        
        $this->data['class_list'] = $this->member->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('non_member') . ' | ' . SMS);
        $this->layout->view('member/non_member', $this->data);
    }

    
        
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Student" data from hostel member list                   
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $member = $this->member->get_single('hostel_members', array('id' => $id));
        
        if ($this->member->delete('hostel_members', array('id' => $id))) {

            $this->member->update('students', array('is_hostel_member' => 0), array('user_id' => $member->user_id));

            $student = $this->member->get_single('students', array('user_id' => $member->user_id));
            create_log('Has been deleted a Hostel Member : '.$student->name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('hostel/member/index/'.$member->school_id);
    }


    
    /*****************Function add_to_hostel**********************************
    * @type            : Function
    * @function name   : add_to_hostel
    * @description     : Add student to Hostel via ajax call from user interface                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function add_to_hostel() {

        $school_id = $this->input->post('school_id');
        $user_id = $this->input->post('user_id');
        $hostel_id = $this->input->post('hostel_id');
        $room_id = $this->input->post('room_id');

        if ($user_id) {

            $member = $this->member->get_single('hostel_members', array('user_id' => $user_id, 'school_id'=>$school_id));
            
            if (empty($member)) {

                $data['school_id'] = $school_id;
                $data['user_id'] = $user_id;
                $data['custom_member_id'] = $this->member->get_custom_id('hostel_members', 'HM');
                $data['hostel_id'] = $hostel_id;
                $data['room_id'] = $room_id;
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();

                $insert_id = $this->member->insert('hostel_members', $data);
                $this->member->update('students', array('is_hostel_member' => 1), array('user_id' => $user_id, 'school_id'=>$school_id));
                echo TRUE;
            } else {
                echo FALSE;
            }
        } else {
            echo FALSE;
        }
    }

}
