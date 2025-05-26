<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Topic extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Topic_Model', 'topic', true);           
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->topic->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
        }
        
         // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_lesson_plan')){                        
              redirect('dashboard/index');
            }
        }
        
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "topic List" user interface                 
    *                       
    * @param           : $class_id integer value
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        
        check_permission(VIEW);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('lessonplan/topic/index');
        }
        
        //for super admin        
        $school_id = '';
        $subject_id = '';        
        if($_POST){   
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
            $subject_id  = $this->input->post('subject_id');           
        }
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }               
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }  
                
        $school = $this->topic->get_school_by_id($school_id);
        $this->data['topics'] = $this->topic->get_topic_list($school_id, $class_id, $subject_id, @$school->academic_year_id);               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->topic->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
        
         
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_topic'). ' | ' . SMS);
        $this->layout->view('topic/index', $this->data);
     
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Topic" user interface                 
    *                    and process to store "Topic" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

          check_permission(ADD);

        if ($_POST) {
            $this->_prepare_topic_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_topic_data();

                // check is subject is exist in topic table
                $school = $this->topic->get_school_by_id($data['school_id']);
                $exist = $this->topic->get_single('lp_topics', array('class_id' => $data['class_id'], 'subject_id'=>$data['subject_id'], 'lesson_detail_id'=>$data['lesson_detail_id'], 'academic_year_id'=> $school->academic_year_id));
                if($exist){
                    $this->topic->update('lp_topics', $data, array('id' => $exist->id));
                    $insert_id = $exist->id;
                }else{
                    $insert_id = $this->topic->insert('lp_topics', $data);
                }
                
                if ($insert_id) {
                    
                    $this->_save_topic($insert_id);                    
                    success($this->lang->line('insert_success'));
                    redirect('lessonplan/topic/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('lessonplan/topic/add');
                }
            } else {
                $this->data['post'] = $_POST;                
            }
        }
        
        
         //$school = $this->topic->get_school_by_id($school_id);
        //$this->data['lessons'] = $this->topic->get_topic_list($school_id, $class_id, $subject_id, @$school->academic_year_id); 
        
        $this->data['topics'] = $this->topic->get_topic_list();     
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->topic->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['add'] = TRUE;  
        $this->layout->title($this->lang->line('add') .' | '. SMS);
        $this->layout->view('topic/index', $this->data);
    }

    
    /*****************Function edit*
     * *********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Topic" user interface                 
    *                    with populate " topic" value 
    *                    and process to update "Tppic" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

       if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('lessonplan/topic/index');
        }
       
        if ($_POST) {
            $this->_prepare_topic_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_topic_data();
                $updated = $this->topic->update('lp_topics', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $this->_save_topic($this->input->post('id'));
                    success($this->lang->line('update_success'));
                    redirect('lessonplan/topic/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('lessonplan/topic/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['topic'] = $this->topic->get_single_topic($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['topic'] = $this->topic->get_single_topic($id);
            if (!$this->data['topic']) {
                redirect('lessonplan/topic/index');
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->topic->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }        
        
        $school_id = $this->data['topic']->school_id;
        $class_id = $this->data['topic']->class_id;
        $subject_id = $this->data['topic']->subject_id;
        $school = $this->topic->get_school_by_id($school_id);
        
        $this->data['topics'] = $this->topic->get_topic_list($school_id, $class_id, $subject_id, $school->academic_year_id); 
        $this->data['topic_details'] = get_topic_detail_by_topic_id($this->data['topic']->id); 
        
        $this->data['schools'] = $this->schools;
        $this->data['class_id'] = $class_id;
        $this->data['school_id'] = $school_id;       
        $this->data['subject_id'] = $subject_id;
               
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('lessonplan/topic/index', $this->data);
    }

   
    /*****************Function get_single_topic**********************************
     * @type            : Function
     * @function name   : get_single_topic
     * @description     : "Load single topic information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_topic(){
        
       $topic_id = $this->input->post('topic_id');
       $this->data['topic'] = $this->topic->get_single_topic($topic_id);  
       $this->data['topic_details'] = get_topic_detail_by_topic_id($topic_id);       
       echo $this->load->view('topic/get-single-topic', $this->data);
    }
    
    
    /*****************Function _prepare_topic_validation**********************************
    * @type            : Function
    * @function name   : _prepare_topic_validation
    * @description     : Process "topic" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_topic_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('lesson_detail_id', $this->lang->line('lesson'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }    

    
    /*****************Function _get_posted_topic_data**********************************
    * @type            : Function
    * @function name   : _get_posted_topic_data
    * @description     : Prepare "topic" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_topic_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'subject_id';
        $items[] = 'lesson_detail_id';
        $items[] = 'note';
        
        $data = elements($items, $_POST);
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
            $data['status'] = 1; //  will be from post
        } else {
            
            $school = $this->topic->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('lessonplan/topic/index');  
            }
            
            $data['academic_year_id'] = $school->academic_year_id;  
                        
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }
        
        return $data;
    }

    
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Topic" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('lessonplan/topic/index');    
        }
                
        if ($this->topic->delete('lp_topics', array('id' => $id))) { 
            
            $this->topic->delete('lp_topic_details', array('topic_id' => $id));
            success($this->lang->line('delete_success')); 
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('lessonplan/topic/index');
    }
    
    
  
    /*****************Function save_topic**********************************
    * @type            : Function
    * @function name   : save
    * @description     : delete "Topic" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    private function _save_topic($topic_id){
        
        $school_id = $this->input->post('school_id'); 
        $school = $this->topic->get_school_by_id($school_id);
        
        foreach($this->input->post('title') as $key=>$value){
           
           if($value){
               
              $data = array();
              $data['school_id'] = $school_id;
              $exist = '';
              $topic_detail_id = @$_POST['topic_detail_id'][$key];
              
                if($topic_detail_id){
                   $exist = $this->topic->get_single('lp_topic_details', array('topic_id'=>$topic_id, 'id'=>$topic_detail_id));
                } 

                $data['title'] = $value;

                if ($this->input->post('id') && $exist) {                

                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();                
                    $this->topic->update('lp_topic_details', $data, array('id'=>$exist->id));

                 } else {

                    $data['topic_id'] = $topic_id; 
                    $data['academic_year_id'] = $school->academic_year_id;
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id(); 
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();
                    $this->topic->insert('lp_topic_details', $data);
                }
            }
       }
    }
     

     public function remove(){
        
        $topic_detail_id = $this->input->post('topic_detail_id');
        echo $this->topic->delete('lp_topic_details', array('id' => $topic_detail_id));
    }    
    
}