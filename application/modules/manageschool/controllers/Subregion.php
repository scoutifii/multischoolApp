<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Subregion extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('Subregion_Model', 'subregion', true);         
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
        
        $this->data['subregion'] = $this->subregion->get_list('subregion', array(), '','', '', 'id', 'ASC');
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_sub_region'). ' | ' . SMS);
        $this->layout->view('subregion/index', $this->data);            
       
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
            $this->_prepare_sub_region_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_sub_region_data();

                $insert_id = $this->subregion->insert('subregion', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a subregion : '.$data['sub_region_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/subregion/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/subregion/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['subregions'] = $this->subregion->get_list('subregion', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->subregion->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('subregion'). ' | ' . SMS);
        $this->layout->view('subregion/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Subregion" user interface                 
    *                    with populate "Subregion" value 
    *                    and process to update "Subregion" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
   
    
    
    public function edit($id = null)
    {
       check_permission(EDIT);

       if ($_POST) {
            $this->_prepare_sub_region_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_sub_region_data();
                $updated = $this->subregion->update('subregion', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a subregion : '.$data['sub_region_name']);
                    success($this->lang->line('update_success'));
                    redirect('manageschool/subregion');    
                    
                } else {
                    
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/subregion/edit/' . $this->input->post('id'));
                    
                }
            } else {
                 error($this->lang->line('update_failed'));
                 $this->data['subregion'] = $this->subregion->get_single('subregion', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['subregion'] = $this->subregion->get_single('subregion', array('id' => $id));
 
                if (!$this->data['subregion']) {
                     redirect('manageschool/subregion');
                }
            }
        }
       
       $this->data['edit'] = TRUE;
       $this->layout->view('subregion/index', $this->data);  
    }
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load subregion interface with specific subject data                 
    *                       
    * @param           : $sub_region_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($sub_region_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($sub_region_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/subregion/index/');    
        }
        
        $this->data['subregion'] = $this->subregion->get_single_sub_region($sub_region_id);       
        
        $condition = array();
        //$condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['sub_region_id'] = $this->session->userdata('sub_region_id');
        }
       
        $this->data['subregions'] = $this->subregions; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('subregion'). ' | ' . SMS);
        $this->layout->view('subregion/index', $this->data);
    }

    
    
    
     /*****************Function get_single_region**********************************
     * @type            : Function
     * @function name   : get_single_region
     * @description     : "Load single region information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_sub_region(){
        
       $sub_region_id = $this->input->post('sub_region_id');
       
       $this->data['subregion'] = $this->subregion->get_single_sub_region($sub_region_id);
       echo $this->load->view('subregion/get-single-subregion', $this->data);
    }
    
    
    /*****************Function _prepare_region_validation**********************************
    * @type            : Function
    * @function name   : _prepare_subject_validation
    * @description     : Process "region" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_sub_region_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        //$this->form_validation->set_rules('region_id', $this->lang->line('region_id'), 'trim|required');   
        $this->form_validation->set_rules('sub_region_name', $this->lang->line('name'), 'trim|required');   
        $this->form_validation->set_rules('sub_region_code', $this->lang->line('code'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "region name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function sub_region_name()
   {             
      if($this->input->post('id') == '')
      {   
          $subregion = $this->subregion->duplicate_check($this->input->post('id')); 
          if($subregion){
                $this->form_validation->set_message('sub_region_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $subregion = $this->subregion->duplicate_check($this->input->post('id'), $this->input->post('sub_region_name')); 
          if($subregion){
                $this->form_validation->set_message('sub_region_name', $this->lang->line('already_exist'));         
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
    private function _get_posted_sub_region_data() {

        $items = array();
        $items[] = 'region_id';
        $items[] = 'sub_region_name';
        $items[] = 'sub_region_code';
    
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
             redirect('manageschool/subregion/index/');    
        }
        
        $subregion = $this->subregion->get_single('subregion', array('id' => $id));
        
        if ($this->subregion->delete('subregion', array('id' => $id))) { 
            
            //$class = $this->subject->get_single('classes', array('id' => $subject->class_id, 'school_id'=>$subject->school_id));
            create_log('Has been deleted a sub region : '. $subregion->sub_region_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/subregion/index/');
        
    }
}
