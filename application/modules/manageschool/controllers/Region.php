<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Region extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('Region_Model', 'region', true);         
    }

     
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Academic School List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['regions'] = $this->region->get_list('regions', array(), '','', '', 'id', 'ASC');
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_region'). ' | ' . SMS);
        $this->layout->view('region/index', $this->data);            
       
    }


    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Region" user interface                 
    *                    and process to store "Region" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_region_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_region_data();

                $insert_id = $this->region->insert('regions', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a region : '.$data['region_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/region');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/region/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['regions'] = $this->region->get_list('regions', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->region->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('region'). ' | ' . SMS);
        $this->layout->view('region/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Subject" user interface                 
    *                    with populate "Subject" value 
    *                    and process to update "Subject" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/region/index/');     
        }
        
        if ($_POST) {
            $this->_prepare_region_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_region_data();
                $updated = $this->region->update('regions', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $region = $this->region->get_single('regions', array('id'=>$data['id']));
                    create_log('Has been updated a region : '. $data['region_name'].' for region : '. $region->region_name);
                    
                    success($this->lang->line('update_success'));
                    redirect('manageschool/region/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/region/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['region'] = $this->region->get_single('regions', array('id' =>  $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['region'] = $this->region->get_single('regions', array('id' => $id));

            if (!$this->data['region']) {
                 redirect('manageschool/region/index/');      
            }
        }
        
        $this->data['regions'] = $this->regions;
        $this->data['edit'] = TRUE; 
        $this->data['region_id'] = $this->data['region']->region_id;
        
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('region'). ' | ' . SMS);
        $this->layout->view('region/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific subject data                 
    *                       
    * @param           : $region_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($region_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($region_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/region/index/');    
        }
        
        $this->data['region'] = $this->region->get_single_region($region_id);        
        
        $condition = array();
        //$condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['region_id'] = $this->session->userdata('region_id');
        }
       
        $this->data['regions'] = $this->regions; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('region'). ' | ' . SMS);
        $this->layout->view('region/index', $this->data);
    }

    
    
    
     /*****************Function get_single_region**********************************
     * @type            : Function
     * @function name   : get_single_region
     * @description     : "Load single region information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_region(){
        
       $region_id = $this->input->post('region_id');
       
       $this->data['region'] = $this->region->get_single_region($region_id);
       echo $this->load->view('region/get-single-region', $this->data);
    }
    
    
    /*****************Function _prepare_region_validation**********************************
    * @type            : Function
    * @function name   : _prepare_subject_validation
    * @description     : Process "region" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_region_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('region_name', $this->lang->line('name'), 'trim|required');   
        $this->form_validation->set_rules('region_code', $this->lang->line('code'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "region name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function region_name()
   {             
      if($this->input->post('id') == '')
      {   
          $region = $this->region->duplicate_check($this->input->post('id')); 
          if($region){
                $this->form_validation->set_message('region_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $region = $this->region->duplicate_check($this->input->post('id'), $this->input->post('region_name')); 
          if($region){
                $this->form_validation->set_message('region_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
   
   
    /*****************Function _get_posted_region_data**********************************
    * @type            : Function
    * @function name   : _get_posted_region_data
    * @description     : Prepare "Region" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_region_data() {

        $items = array();
        $items[] = 'region_name';
        $items[] = 'region_code';
    
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
    * @description     : delete "Region" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * **********************************************************/ 
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/region/index/');    
        }
        
        $region = $this->region->get_single('regions', array('id' => $id));
        
        if ($this->region->delete('regions', array('id' => $id))) { 
            
            //$class = $this->subject->get_single('classes', array('id' => $subject->class_id, 'school_id'=>$subject->school_id));
            create_log('Has been deleted a region : '. $region->region_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/region/index/');
        
    }
}
