<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Promotion extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Promotion_Model', 'promotion', true);
    }

        
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "Promotion" user input interface and 
     *                      process/filter promotion calss
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index() {                
        
        check_permission(VIEW);
        
        $this->data['current_session_id'] = '';
        
        if($_POST){
            
            $school_id   = $this->input->post('school_id');
            $current_session_id   = $this->input->post('current_session_id');
            $next_session_id   = $this->input->post('next_session_id');
            $current_class_id = $this->input->post('current_class_id');
            $next_class_id = $this->input->post('next_class_id');  
            
            $school = $this->promotion->get_school_by_id($school_id);
            $this->data['students'] = $this->promotion->get_student_list($school_id, $current_class_id, $school->academic_year_id );
            
            $this->data['current_class'] = $this->promotion->get_single('classes', array('school_id'=>$school_id, 'id' => $current_class_id));
            $this->data['next_class'] = $this->promotion->get_single('classes', array('school_id'=>$school_id,'id' => $next_class_id));
                                              
            $this->data['school_id'] = $school_id;
            $this->data['current_session_id'] = $current_session_id;
            $this->data['next_session_id'] = $next_session_id;
            $this->data['current_class_id'] = $current_class_id;
            $this->data['next_class_id'] = $next_class_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
                        
        }
        
        $this->data['curr_session'] = array();
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->promotion->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->promotion->get_school_by_id($condition['school_id']);
            
            $this->data['curr_session'] = $this->promotion->get_single('academic_years', array('id' => $school->academic_year_id, 'school_id'=>$condition['school_id']));
            $this->data['next_session'] = $this->promotion->get_list('academic_years', array('id !=' => $school->academic_year_id, 'status'=>1, 'school_id'=>$condition['school_id']), '','', '', 'session_year', 'ASC');
        }         
     
        $this->layout->title( $this->lang->line('manage_promotion'). ' | ' . SMS);
        $this->layout->view('promotion/index', $this->data);  
    }
    
    
            
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Process "Promotion" to next/promoted class                 
     *                    and store promoted class information into database    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {                
        
        check_permission(ADD);
        if($_POST){
            
            $school_id   = $this->input->post('school_id');
            $current_session_id   = $this->input->post('current_session_id');
            $next_session_id   = $this->input->post('next_session_id');
            $current_class_id = $this->input->post('current_class_id');
            $next_class_id = $this->input->post('next_class_id');  
            $academic_year_id = $this->input->post('academic_year_id');  
                      
           
            // get next class default section
            $next_class_default_section = $this->db->get_where('sections', array('school_id'=>$school_id, 'class_id'=>$next_class_id))->row();
            if(empty($next_class_default_section)){
                error($this->lang->line('no_data_found'). ' for ' .$this->lang->line('promote_to_class'));
                redirect('academic/promotion/index');
            }
            
            
            if(!empty($_POST['students'])){
                
                foreach($_POST['students'] as $key=>$value){
                    
                        
                        $data = array();
                        $data['class_id'] = $_POST['promotion_class_id'][$value]; 
                        $data['roll_no'] = $_POST['roll_no'][$value]; 
                        
                        
                        $data['section_id'] = $next_class_default_section->id ? $next_class_default_section->id : '';
                        // no promoted student next year same class section
                        if($data['class_id'] == $current_class_id){
                            $current_section = $this->promotion->get_single('enrollments', array('school_id'=>$school_id, 'class_id'=>$current_class_id, 'student_id'=>$value, 'academic_year_id'=>$current_session_id));
                            $data['section_id'] = $current_section->section_id ? $current_section->section_id : ''; 
                        }  
                        
                       // need to check is any student already enrolled
                        $exist = $this->promotion->get_single('enrollments', array('school_id'=>$school_id, 'class_id'=>$data['class_id'], 'student_id'=>$value, 'academic_year_id'=>$next_session_id));
                        
                       if(empty($exist)){ 
                           
                            $data['school_id'] = $school_id; 
                            $data['academic_year_id'] = $next_session_id; 
                            $data['student_id'] = $value;                          
                            $data['status'] = 1;
                            $data['created_at'] = date('Y-m-d H:i:s');
                            $data['created_by'] = logged_in_user_id();                       
                            $this->promotion->insert('enrollments', $data);
                            
                       }else{
                           
                           $data['modified_at'] = date('Y-m-d H:i:s');
                           $data['modified_by'] = logged_in_user_id(); 
                           $this->promotion->update('enrollments', $data, array('school_id'=>$school_id,'student_id'=>$value, 'academic_year_id'=>$next_session_id)); 
                           
                       }
                }
            }
            
            $class = $this->promotion->get_single('classes', array('id'=>$current_class_id, 'school_id'=>$school_id));
            create_log('Has been promoted a class : '. $class->name);
            
            success($this->lang->line('insert_success'));                      
        }else{
            error($this->lang->line('insert_failed'));  
        }        
       
        redirect('academic/promotion/index');
    }
}