<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Transfer extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Transfer_Model', 'transfer', true);
    }

        
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "Transfer" user input interface and 
     *                      process/filter transfer teacher
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index() {                
        
        check_permission(VIEW);
        
        $this->data['current_session_id'] = '';
        
        if($_POST){
            
            $school_id   = $this->input->post('school_id');
            $next_school_id = $this->input->post('next_school_id');
            $teacher_id = $this->input->post('teacher_id'); 

            $teacher = $this->transfer->get_single('teachers', array('id'=>$teacher_id));
            $this->data['teachers'] = get_user_by_role(TEACHER, $teacher->user_id);
            $this->data['current_school'] = $this->transfer->get_single('schools', array('id' => $school_id));
            $this->data['next_school'] = $this->transfer->get_single('schools', array('id' => $next_school_id));
                                              
            $this->data['school_id'] = $school_id;
            $this->data['teacher_id'] = $teacher_id;
            $this->data['next_school_id'] = $next_school_id;
        }
                 
     
        $this->layout->title( $this->lang->line('manage_transfer'). ' | ' . SMS);
        $this->layout->view('transfer/index', $this->data);  
    }
    
    
            
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Process "transfer" to next school                 
     *                    and store transfered school information into database    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {                
        
        check_permission(ADD);
        if($_POST){
            
            $school_id   = $this->input->post('school_id');
            $next_school_id   = $this->input->post('next_school_id');
            $teacher_id   = $this->input->post('teacher_id');
            $next_session_id   = $this->input->post('next_session_id');
            $academic_year_id = $this->input->post('academic_year_id'); 
            
            if(!empty($_POST['teachers'])){
                
                foreach($_POST['teachers'] as $key=>$value){                    
                        
                        $data = array();
                        $data['school_id'] = $_POST['transfer_school_id'][$value]; 
                        /*$data['file_no'] = $_POST['file_no'][$value];
                        $data['teacher_no'] = $_POST['teacher_no'][$value];*/ 
                        
                       // need to check is any teacher already enrolled
                        $exist = $this->transfer->get_single('teachers', array('school_id'=>$school_id));
                        
                       if(empty($exist)){ 
                           
                            $data['school_id'] = $school_id; 
                            $data['id'] = $value;                          
                            $data['status'] = 1;
                            $data['created_at'] = date('Y-m-d H:i:s');
                            $data['created_by'] = logged_in_user_id();                       
                            $this->transfer->insert('teachers', $data);
                            
                       }else{
                           $data['is_transferable'] = 1 ;
                           $data['modified_at'] = date('Y-m-d H:i:s');
                           $data['modified_by'] = logged_in_user_id(); 
                           $this->transfer->update('teachers', $data, array('school_id'=>$school_id,'id'=>$value));
                           
                       }
                }
            }
            
            $school = $this->transfer->get_single('schools', array('id'=>$school_id));
            create_log('Has been transfered teacher to a school : '. $school->name);
            
            success($this->lang->line('insert_success'));                      
        }else{
            error($this->lang->line('insert_failed'));  
        }        
       
        redirect('academic/transfer/index');
    }
}