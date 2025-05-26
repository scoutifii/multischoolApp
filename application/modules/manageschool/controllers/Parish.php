<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Parish extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('Parish_Model', 'parish', true);         
    }

     
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Parish List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['parishs'] = $this->parish->get_list('parish', array(), '','', '', 'id', 'ASC');
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_parish'). ' | ' . SMS);
        $this->layout->view('parish/index', $this->data);            
       
    }


    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new parish" user interface                 
    *                    and process to store "parish" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_parish_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_parish_data();

                $insert_id = $this->parish->insert('parish', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a parish : '.$data['parish_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/parish');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/parish/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['parishs'] = $this->parish->get_list('parish', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->parish->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('parish'). ' | ' . SMS);
        $this->layout->view('parish/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "parish" user interface                 
    *                    with populate "parish" value 
    *                    and process to update "parish" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/parish/index/');     
        }
        
        if ($_POST) {
            $this->_prepare_parish_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_parish_data();
                $updated = $this->parish->update('parish', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $parish = $this->parish->get_single('parish', array('id'=>$data['id']));
                    create_log('Has been updated a parish : '. $data['parish_name'].' for parish : '. $parish->parish_name);
                    
                    success($this->lang->line('update_success'));
                    redirect('manageschool/parish/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/parish/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['parish'] = $this->parish->get_single('parish', array('id' =>  $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['parish'] = $this->parish->get_single('parish', array('id' => $id));

            if (!$this->data['parish']) {
                 redirect('manageschool/parish/index/');      
            }
        }
        
        
        /*$this->data['parishs'] = $this->parish->get_parish_list($class_id);        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->subject->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['teachers'] = $this->subject->get_list('teachers', $condition, '','', '', 'id', 'ASC');
        }*/
        
        $this->data['parishs'] = $this->parishs;
        $this->data['edit'] = TRUE; 
        $this->data['parish_id'] = $this->data['parish']->parish_id;
        
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('parish'). ' | ' . SMS);
        $this->layout->view('parish/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific parish data                 
    *                       
    * @param           : $parish_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($parish_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($parish_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/parish/index/');    
        }
        
        $this->data['parish'] = $this->parish->get_single_parish($parish_id);
        
        //$this->data['parishs'] = $this->parish->get_subject_list($class_id);        
        
        $condition = array();
        //$condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['parish_id'] = $this->session->userdata('parish_id');
        }
       
        $this->data['parishs'] = $this->parishs; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('parish'). ' | ' . SMS);
        $this->layout->view('parish/index', $this->data);
    }

    
    
    
     /*****************Function get_single_parish**********************************
     * @type            : Function
     * @function name   : get_single_parish
     * @description     : "Load single parish information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_parish(){
        
       $parish_id = $this->input->post('parish_id');
       
       $this->data['parish'] = $this->parish->get_single_parish($parish_id);
       echo $this->load->view('parish/get-single-parish', $this->data);
    }
    
    
    /*****************Function _prepare_parish_validation**********************************
    * @type            : Function
    * @function name   : _prepare_parish_validation
    * @description     : Process "parish" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_parish_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('region_id', $this->lang->line('region_id'), 'trim|required'); 
        $this->form_validation->set_rules('sub_region_id', $this->lang->line('sub_region_id'), 'trim|required');
        $this->form_validation->set_rules('district_id', $this->lang->line('district_id'), 'trim|required');
        $this->form_validation->set_rules('sub_county_id', $this->lang->line('sub_county_id'), 'trim|required'); 
        //$this->form_validation->set_rules('parish_id', $this->lang->line('parish_id'), 'trim|required'); 
        $this->form_validation->set_rules('parish_name', $this->lang->line('parish_name'), 'trim|required');   
        $this->form_validation->set_rules('parish_code', $this->lang->line('parish_code'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "parish name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function parish_name()
   {             
      if($this->input->post('id') == '')
      {   
          $parish = $this->parish->duplicate_check($this->input->post('id')); 
          if($parish){
                $this->form_validation->set_message('parish_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $parish = $this->parish->duplicate_check($this->input->post('id'), $this->input->post('parish_name')); 
          if($parish){
                $this->form_validation->set_message('parish_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
   
   
    /*****************Function _get_posted_parish_data**********************************
    * @type            : Function
    * @function name   : _get_posted_parish_data
    * @description     : Prepare "parish" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_parish_data() {

        $items = array();
        $items[] = 'region_id';
        $items[] = 'sub_region_id';
        $items[] = 'district_id';
        $items[] = 'sub_county_id';
        $items[] = 'parish_name';
        $items[] = 'parish_code';
    
        $data = elements($items, $_POST);        
        
       if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();                       
        }

        return $data;
    }

    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "parish" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * **********************************************************/ 
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/parish/index/');    
        }
        
        $parish = $this->parish->get_single('parish', array('id' => $id));
        
        if ($this->parish->delete('parish', array('id' => $id))) { 
            
            //$class = $this->subject->get_single('classes', array('id' => $subject->class_id, 'school_id'=>$subject->school_id));
            create_log('Has been deleted a parish : '. $parish->parish_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/parish/index/');
        
    }
}
