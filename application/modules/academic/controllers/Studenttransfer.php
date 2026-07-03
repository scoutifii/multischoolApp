<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Studenttransfer extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Studenttransfer_Model', 'transfer', true);
    }

        
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "Student transfer" user input interface and 
     *                      process/filter Student transfer class
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
            $current_class_id = $this->input->post('current_class_id');
            $next_school_id   = $this->input->post('school_id');            
            $next_session_id   = $this->input->post('next_session_id');            
            $next_class_id = $this->input->post('next_class_id');
            $student_id = $this->input->post('student_id');  
            
            $school = $this->transfer->get_school_by_id($school_id);
            $this->data['students'] = $this->transfer->get_student_list($school_id, $current_class_id, $school->academic_year_id );
            
            $this->data['current_class'] = $this->transfer->get_single('classes', array('school_id'=>$school_id, 'id' => $current_class_id));
            $this->data['next_class'] = $this->transfer->get_single('classes', array('school_id'=>$school_id,'id' => $next_class_id));
                                              
            $this->data['school_id'] = $school_id;
            $this->data['current_session_id'] = $current_session_id;
            /*$this->data['class_id'] = $class_id;*/
            $this->data['next_school_id'] = $next_school_id;            
            $this->data['next_session_id'] = $next_session_id;            
            $this->data['next_class_id'] = $next_class_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
            $this->data['student_id'] = $student_id;
            }
        
        $this->data['curr_session'] = array();
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->transfer->get_list('classes', $condition, '','', '', 'id', 'ASC');
            
            $school = $this->transfer->get_school_by_id($condition['school_id']);
            
            $this->data['curr_session'] = $this->transfer->get_single('academic_years', array('id' => $school->academic_year_id, 'school_id'=>$condition['school_id']));
            $this->data['next_session'] = $this->transfer->get_list('academic_years', array('id !=' => $school->academic_year_id, 'status'=>1, 'school_id'=>$condition['school_id']), '','', '', 'session_year', 'ASC');
        }         
     
        $this->layout->title( $this->lang->line('manage_transfer'). ' | ' . SMS);
        $this->layout->view('academic/student_transfer/index', $this->data);  
    }
    
    
            
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Process "student transfer" to next school                 
     *                    and store transferred student school information into database    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    // public function add() {                
        
    //     check_permission(ADD);
        
    //     if($_POST){
            
    //         $school_id   = $this->input->post('school_id');
    //         $next_school_id   = $this->input->post('school_id');
    //         $current_session_id   = $this->input->post('current_session_id');
    //         $next_session_id   = $this->input->post('next_session_id');
    //         $class_id = $this->input->post('class_id');
    //         $next_class_id = $this->input->post('next_class_id');  
    //         $academic_year_id = $this->input->post('academic_year_id');  
                      
           
    //         // get next class default section
    //         $next_class_default_section = $this->db->get_where('sections', array('school_id'=>$school_id, 'class_id'=>$next_class_id))->row();
    //         if(empty($next_class_default_section)){
    //             error($this->lang->line('no_data_found'). ' for ' .$this->lang->line('transferred_to_school'));
    //             redirect('academic/studenttransfer/index');
    //         }
            
            
    //         if(!empty($_POST['students'])){
                
    //             foreach($_POST['students'] as $key=>$value){                    
                        
    //                     $data = array();
    //                     $data['class_id'] = $_POST['student_transfer_class_id'][$value]; 
    //                     $data['roll_no'] = $_POST['roll_no'][$value]; 
                        
                        
    //                     $data['section_id'] = $next_class_default_section->id ? $next_class_default_section->id : '';
    //                     // no promoted student next year same class section
    //                     if($data['class_id'] == $class_id){
    //                         $current_section = $this->transfer->get_single('enrollments', array('school_id'=>$school_id, 'class_id'=>$class_id, 'student_id'=>$value, 'academic_year_id'=>$current_session_id));
    //                         $data['section_id'] = $current_section->section_id ? $current_section->section_id : ''; 
    //                     }  
                        
    //                    // need to check is any student already enrolled
    //                     $exist = $this->transfer->get_single('enrollments', array('school_id'=>$school_id, 'class_id'=>$data['class_id'], 'student_id'=>$value, 'academic_year_id'=>$next_session_id));
                        
    //                    if(empty($exist)){ 
                           
    //                         $data['school_id'] = $school_id; 
    //                         $data['academic_year_id'] = $next_session_id; 
    //                         $data['student_id'] = $value;                          
    //                         $data['status'] = 1;
    //                         $data['created_at'] = date('Y-m-d H:i:s');
    //                         $data['created_by'] = logged_in_user_id();                       
    //                         $this->transfer->insert('enrollments', $data);
                            
    //                    }else{
                           
    //                        $data['modified_at'] = date('Y-m-d H:i:s');
    //                        $data['modified_by'] = logged_in_user_id(); 
    //                        $this->transfer->update('enrollments', $data, array('school_id'=>$school_id,'student_id'=>$value, 'academic_year_id'=>$next_session_id)); 
                           
    //                    }
    //             }
    //         }
            
    //         $school = $this->transfer->get_single('schools', array('id'=>$school_id));
    //         create_log('Has been transferred to school : '. $school->school_name);
            
    //         success($this->lang->line('insert_success'));                      
    //     }else{
    //         error($this->lang->line('insert_failed'));  
    //     }        
       
    //     redirect('academic/studentransfer/index');
    // }

    public function add() {                
        
        check_permission(ADD);

        if (!$this->input->post()) {
            error($this->lang->line('insert_failed'));
            redirect('academic/studenttransfer/index');
        }

        $school_id          = $this->input->post('school_id');
        $next_school_id     = $this->input->post('next_school_id');
        $student_id         = $this->input->post('student_id');
        $next_session_id    = $this->input->post('next_session_id');
        $academic_year_id   = $this->input->post('academic_year_id'); 

        // Get Student information
        $student = $this->transfer->get_single('students', array('id' => $studen_id));

        // start transaction
        $this->db->trans_begin();

        try {
            $data = array(
                'school_id'          => $school_id,
                'next_school_id'     => $next_school_id,
                'student_id'         => $student_id,
                'created_at'         => date('Y-m-d H:i:s'),
                'created_by'         => logged_in_user_id()
            );

            $this->transfer->insert('student_transfers', $data);

            // update students current school
            $studentData = array(
                'school_id'          => $school_id,
                'is_transferable'    => 1,
                'modified_at'        => date('Y-m-d H:i:s'),
                'modified_by'        => logged_in_user_id()
            );

            $this->transfer->update('students', $studentData, array('id' => $student_id));
            $this->transfer->update('enrollments', $studentData, array('id' => $student_id));

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Transfer failed");
            }
            
            $this->db->trans_commit();
            
            $school = $this->transfer->get_single('schools', array('id' => $next_school_id));
            create_log('Has been transfered student to a school : '. $school->name);
            
            success($this->lang->line('insert_success'));
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            error($e->getMessage());
        }

        redirect('academic/studenttransfer/index');

    }
}