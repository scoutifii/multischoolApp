<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class District extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('District_Model', 'district', true);           
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
        
        $this->data['districts'] = $this->district->get_list('district', array(), '','', '', 'id', 'ASC');
        //$this->data['districts'] = $this->district->get_district_list();
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_district'). ' | ' . SMS);
        $this->layout->view('district/index', $this->data);            
       
    }



    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new District" user interface                 
    *                    and process to store "district" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_district_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_district_data();

                $insert_id = $this->district->insert('district', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a district : '.$data['district_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/district');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/district/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['districts'] = $this->district->get_list('district', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->district->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('district'). ' | ' . SMS);
        $this->layout->view('district/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "District" user interface                 
    *                    with populate "District" value 
    *                    and process to update "District" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
        if ($_POST) {
            $this->_prepare_district_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_district_data();
                $updated = $this->district->update('district', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $district = $this->district->get_single('district', array('id'=>$data['id']));
                    create_log('Has been updated a district : '. $data['district_name'].' for district : '. $district->district_name);
                    
                    success($this->lang->line('update_success'));
                    redirect('manageschool/district/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/district/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['district'] = $this->district->get_single('district', array('id' =>  $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['district'] = $this->district->get_single('district', array('id' => $id));

            if (!$this->data['district']) {
                 redirect('manageschool/district/index/');      
            }
        }
                
        $this->data['districts'] = $this->districts;
        $this->data['edit'] = TRUE; 
        $this->data['district_id'] = $this->data['district']->district_id;
        
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('district'). ' | ' . SMS);
        $this->layout->view('district/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific District data                 
    *                       
    * @param           : $district_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($district_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($district_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/district/index/');    
        }
        
        $this->data['district'] = $this->district->get_single_district($district_id);
        
        //$this->data['districts'] = $this->district->get_subject_list($class_id);        
        
        $condition = array();
        //$condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['district_id'] = $this->session->userdata('district_id');
        }
       
        $this->data['districts'] = $this->districts; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('district'). ' | ' . SMS);
        $this->layout->view('district/index', $this->data);
    }

    
    
    
     /*****************Function get_single_district**********************************
     * @type            : Function
     * @function name   : get_single_district
     * @description     : "Load single district information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_district(){
        
       $district_id = $this->input->post('district_id');
       
       $this->data['district'] = $this->district->get_single_district($district_id);
       echo $this->load->view('district/get-single-district', $this->data);
    }
    
    
    /*****************Function _prepare_district_validation**********************************
    * @type            : Function
    * @function name   : _prepare_district_validation
    * @description     : Process "district" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_district_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('region_id', $this->lang->line('region_id'), 'trim|required'); 
        $this->form_validation->set_rules('sub_region_id', $this->lang->line('sub_region_id'), 'trim|required'); 
        $this->form_validation->set_rules('district_name', $this->lang->line('district_name'), 'trim|required');   
        $this->form_validation->set_rules('district_code', $this->lang->line('district_code'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "district name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function district_name()
   {             
      if($this->input->post('id') == '')
      {   
          $district = $this->district->duplicate_check($this->input->post('id')); 
          if($district){
                $this->form_validation->set_message('district_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $district = $this->district->duplicate_check($this->input->post('id'), $this->input->post('district_name')); 
          if($district){
                $this->form_validation->set_message('district_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
   
   
    /*****************Function _get_posted_district_data**********************************
    * @type            : Function
    * @function name   : _get_posted_district_data
    * @description     : Prepare "district" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_district_data() {

        $items = array();
        $items[] = 'region_id';
        $items[] = 'sub_region_id';
        $items[] = 'district_name';
        $items[] = 'district_code';
    
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
    * @description     : delete "district" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * **********************************************************/ 
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/district/index/');    
        }
        
        $district = $this->district->get_single('district', array('id' => $id));
        
        if ($this->district->delete('district', array('id' => $id))) { 
            
            //$class = $this->subject->get_single('classes', array('id' => $subject->class_id, 'school_id'=>$subject->school_id));
            create_log('Has been deleted a district : '. $district->district_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/district/index/');
        
    }
}
