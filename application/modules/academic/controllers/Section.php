<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Section extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
                 
         $this->load->model('Section_Model', 'section', true);
    }

    
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Class section list" user interface                 
     *                    with class wise section list   
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function index($class_id = null) {
        
        check_permission(VIEW); 
        
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/section/index');
        }
        
        // for super admin 
        $school_id = '';
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');;
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['sections'] = $this->section->get_section_list($class_id, $school_id); 
               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->section->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->section->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['list'] = TRUE;
        $this->data['schools'] = $this->schools;
        $this->layout->title($this->lang->line('manage_section'). ' | ' . SMS);
        $this->layout->view('section/index', $this->data);            
       
    }

    
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Class Section" user interface                 
     *                    and store "Class Section" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {
        
        check_permission(ADD);
        
        if ($_POST) {
            
            $this->_prepare_section_validation();
         
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_section_data();

                $insert_id = $this->section->insert('sections', $data);
                if ($insert_id) {
                    
                    $class = $this->section->get_single('classes', array('id' => $data['class_id'], 'school_id'=>$data['school_id']));
                    create_log('Has been created a section : '. $data['name'].' for class : '. $class->name);
                    
                    success($this->lang->line('insert_success'));
                    redirect('academic/section/index/'.$data['class_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('academic/section/add/'.$data['class_id']);
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $class_id = $this->uri->segment(4);
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
                
        
        $this->data['class_id'] = $class_id;
        $this->data['sections'] = $this->section->get_section_list($class_id); 
        
       
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->section->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->section->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        }
        
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('section/index', $this->data);
    }

    
     /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Class Section" user interface                 
     *                    with populated "class section" value 
     *                    and update "Class section" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/section/index/');
        }
        
        if ($_POST) {
            $this->_prepare_section_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_section_data();
                $updated = $this->section->update('sections', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $class = $this->section->get_single('classes', array('id' => $data['class_id'], 'school_id'=>$data['school_id']));
                    create_log('Has been updated a section : '. $data['name'].' for class : '. $class->name);
                    
                    success($this->lang->line('update_success'));
                    redirect('academic/section/index/'.$data['class_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('academic/section/edit/' . $this->input->post('id'));
                }
            } else {
                 error($this->lang->line('update_failed'));
                 $this->data['section'] = $this->section->get_single('sections', array('id' => $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['section'] = $this->section->get_single('sections', array('id' => $id));

            if (!$this->data['section']) {
                redirect('academic/section/index/');
            }
        }

        $class_id = $this->data['section']->class_id;
        if(!$class_id){
          $class_id = $this->input->post('class_id');
        }
       
        $this->data['sections'] = $this->section->get_section_list($class_id, $this->data['section']->school_id);        
      
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->section->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->section->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['school_id'] = $this->data['section']->school_id;
        $this->data['filter_school_id'] = $this->data['section']->school_id;
        $this->data['edit'] = TRUE;   
        $this->data['schools'] = $this->schools;
        
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('section/index', $this->data);
    }

    
    /*****************Function _prepare_section_validation**********************************
     * @type            : Function
     * @function name   : _prepare_section_validation
     * @description     : Process "Class Section" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_section_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('teacher_id', $this->lang->line('teacher'), 'trim|required');   
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');   
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'required|trim|callback_name');
    }
    
  
    /*****************Function name**********************************
     * @type            : Function
     * @function name   : name
     * @description     : Unique check for "name" data/value                  
     *                       
     * @param           : null
     * @return          : boolean true/false 
     * ********************************************************** */  
   public function name()
   {             
      if($this->input->post('id') == '')
      {   
          $section = $this->section->duplicate_check($this->input->post('school_id'), $this->input->post('class_id'),$this->input->post('name')); 
          if($section){
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $section = $this->section->duplicate_check($this->input->post('school_id'), $this->input->post('class_id'),$this->input->post('name'), $this->input->post('id')); 
          if($section){
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }

   
    /*****************Function _get_posted_section_data**********************************
     * @type            : Function
     * @function name   : _get_posted_section_data
     * @description     : Prepare "Class Section" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */ 
    private function _get_posted_section_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'teacher_id';
        $items[] = 'name';
        $data = elements($items, $_POST);        
        $data['note'] = $this->input->post('note');
        
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
     * @description     : delete "Class Section" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('academic/section/index/');
        }
        
        $section = $this->section->get_single('sections', array('id' => $id));
        if ($this->section->delete('sections', array('id' => $id))) {  
            
            $class = $this->section->get_single('classes', array('id' => $section->class_id, 'school_id'=>$section->school_id));
            create_log('Has been deleted a section : '. $section->name.' for class : '. $class->name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('academic/section/index/'.$section->class_id);
    }

}
