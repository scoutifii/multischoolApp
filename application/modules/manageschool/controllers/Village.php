<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Village extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('Village_Model', 'village', true);        
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
        
        $this->data['villages'] = $this->village->get_list('village', array(), '','', '', 'id', 'ASC');
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_village'). ' | ' . SMS);
        $this->layout->view('village/index', $this->data);            
       
    }



    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new village" user interface                 
    *                    and process to store "village" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_village_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_village_data();

                $insert_id = $this->village->insert('village', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a village : '.$data['village_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/village');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/village/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['villages'] = $this->village->get_list('village', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->village->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('village'). ' | ' . SMS);
        $this->layout->view('village/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "village" user interface                 
    *                    with populate "village" value 
    *                    and process to update "village" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/village/index/');     
        }
        
        if ($_POST) {
            $this->_prepare_village_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_village_data();
                $updated = $this->village->update('village', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $village = $this->village->get_single('village', array('id'=>$data['id']));
                    create_log('Has been updated a village : '. $data['village_name'].' for village : '. $village->village_name);
                    
                    success($this->lang->line('update_success'));
                    redirect('manageschool/village/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/village/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['village'] = $this->village->get_single('village', array('id' =>  $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['village'] = $this->village->get_single('village', array('id' => $id));

            if (!$this->data['village']) {
                 redirect('manageschool/village/index/');      
            }
        }
        
        
        $this->data['villages'] = $this->villages;
        $this->data['edit'] = TRUE; 
        $this->data['village_id'] = $this->data['village']->village_id;
        
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('village'). ' | ' . SMS);
        $this->layout->view('village/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific village data                 
    *                       
    * @param           : $village_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($village_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($village_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/village/index/');    
        }
        
        $this->data['village'] = $this->village->get_single_village($village_id);        
        
        $condition = array();       
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['village_id'] = $this->session->userdata('village_id');
        }
       
        $this->data['villages'] = $this->villages; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('village'). ' | ' . SMS);
        $this->layout->view('village/index', $this->data);
    }

    
    
    
     /*****************Function get_single_village**********************************
     * @type            : Function
     * @function name   : get_single_village
     * @description     : "Load single village information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_village(){
        
       $village_id = $this->input->post('village_id');
       
       $this->data['village'] = $this->village->get_single_village($village_id);
       echo $this->load->view('village/get-single-village', $this->data);
    }
    
    
    /*****************Function _prepare_village_validation**********************************
    * @type            : Function
    * @function name   : _prepare_village_validation
    * @description     : Process "village" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_village_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('region_id', $this->lang->line('region_id'), 'trim|required'); 
        $this->form_validation->set_rules('sub_region_id', $this->lang->line('sub_region_id'), 'trim|required');
        $this->form_validation->set_rules('district_id', $this->lang->line('district_id'), 'trim|required');
        $this->form_validation->set_rules('sub_county_id', $this->lang->line('sub_county_id'), 'trim|required');
        $this->form_validation->set_rules('parish_id', $this->lang->line('parish_id'), 'trim|required'); 
        $this->form_validation->set_rules('village_name', $this->lang->line('village_name'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "village name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function village_name()
   {             
      if($this->input->post('id') == '')
      {   
          $village = $this->village->duplicate_check($this->input->post('id')); 
          if($village){
                $this->form_validation->set_message('village_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $village = $this->village->duplicate_check($this->input->post('id'), $this->input->post('village_name')); 
          if($village){
                $this->form_validation->set_message('village_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
   
   
    /*****************Function _get_posted_village_data**********************************
    * @type            : Function
    * @function name   : _get_posted_village_data
    * @description     : Prepare "village" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_village_data() {

        $items = array();
        $items[] = 'region_id';
        $items[] = 'sub_region_id';
        $items[] = 'district_id';
        $items[] = 'sub_county_id';
        $items[] = 'parish_id';
        $items[] = 'village_name';
        $items[] = 'village_code';
    
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
    * @description     : delete "village" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * **********************************************************/ 
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/village/index/');    
        }
        
        $village = $this->village->get_single('village', array('id' => $id));
        
        if ($this->village->delete('village', array('id' => $id))) { 
            
            //$class = $this->subject->get_single('classes', array('id' => $subject->class_id, 'school_id'=>$subject->school_id));
            create_log('Has been deleted a village : '. $village->village_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/village/index/');
        
    }
}
