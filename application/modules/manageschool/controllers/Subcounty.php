<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subcounty extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
  
         $this->load->model('Subcounty_Model', 'subcounty', true);         
    }

     
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Subcounty List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['subcounties'] = $this->subcounty->get_list('subcounty', array(), '','', '', 'id', 'ASC');
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_sub_county'). ' | ' . SMS);
        $this->layout->view('subcounty/index', $this->data);            
       
    }


    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new subcounty" user interface                 
    *                    and process to store "subcounty" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_subcounty_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_subcounty_data();

                $insert_id = $this->subcounty->insert('subcounty', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a subcounty : '.$data['sub_county_name']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('manageschool/subcounty');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('manageschool/subcounty/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['subcounty'] = $this->subcounty->get_list('subcounty', '','', '', 'id', 'ASC');
        $this->data['themes'] = $this->district->get_list('themes', array(), '','', '', 'id', 'ASC');
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('subcounty'). ' | ' . SMS);
        $this->layout->view('subcounty/index', $this->data);
    }
    
   
    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "subcounty" user interface                 
    *                    with populate "subcounty" value 
    *                    and process to update "subcounty" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/subcounty/index/');     
        }
        
        if ($_POST) {
            $this->_prepare_subcounty_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_subcounty_data();
                $updated = $this->subcounty->update('subcounty', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $subcounty = $this->subcounty->get_single('subcounty', array('id'=>$data['id']));
                    create_log('Has been updated a subcounty : '. $data['sub_county_name'].' for subcounty : '. $subcounty->sub_county_name);
                    
                    success($this->lang->line('update_success'));
                    redirect('manageschool/subcounty/index/');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('manageschool/subcounty/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['subcounty'] = $this->subcounty->get_single('subcounty', array('id' =>  $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['subcounty'] = $this->subcounty->get_single('subcounty', array('id' => $id));

            if (!$this->data['subcounty']) {
                 redirect('manageschool/subcounty/index/');      
            }
        }
        
        $this->data['subcounties'] = $this->subcounties;
        $this->data['edit'] = TRUE; 
        $this->data['sub_county_id'] = $this->data['subcounty']->sub_county_id;
        
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('subcounty'). ' | ' . SMS);
        $this->layout->view('subcounty/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific subcounty data                 
    *                       
    * @param           : $sub_county_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($sub_county_id = null){
        
        check_permission(VIEW);
        
        if(!is_numeric($sub_county_id)){
             error($this->lang->line('unexpected_error'));
             redirect('manageschool/subcounty/index/');    
        }
        
        $this->data['subcounty'] = $this->subcounty->get_single_sub_county($sub_county_id);
        
        //$this->data['districts'] = $this->district->get_subject_list($class_id);        
        
        $condition = array();
        //$condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['sub_county_id'] = $this->session->userdata('sub_county_id');
        }
       
        $this->data['subcounties'] = $this->subcounties; 
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('subcounty'). ' | ' . SMS);
        $this->layout->view('subcounty/index', $this->data);
    }

    
    
    
     /*****************Function get_single_district**********************************
     * @type            : Function
     * @function name   : get_single_district
     * @description     : "Load single district information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_sub_county(){
        
       $sub_county_id = $this->input->post('sub_county_id');
       
       $this->data['subcounty'] = $this->subcounty->get_single_sub_county($sub_county_id);
       echo $this->load->view('subcounty/get-single-subcounty', $this->data);
    }
    
    
    /*****************Function _prepare_subcounty_validation**********************************
    * @type            : Function
    * @function name   : _prepare_subcounty_validation
    * @description     : Process "subcounty" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_subcounty_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('region_id', $this->lang->line('region_id'), 'trim|required'); 
        $this->form_validation->set_rules('sub_region_id', $this->lang->line('sub_region_id'), 'trim|required'); 
         $this->form_validation->set_rules('district_id', $this->lang->line('district_id'), 'trim|required'); 
        $this->form_validation->set_rules('sub_county_name', $this->lang->line('name'), 'trim|required');   
        $this->form_validation->set_rules('sub_county_code', $this->lang->line('code'), 'trim|required');   
    }
    
    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "subcounty name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
   public function sub_county_name()
   {             
      if($this->input->post('id') == '')
      {   
          $subcounty = $this->subcounty->duplicate_check($this->input->post('id')); 
          if($subcounty){
                $this->form_validation->set_message('sub_county_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $subcounty = $this->subcounty->duplicate_check($this->input->post('id'), $this->input->post('sub_county_name')); 
          if($subcounty){
                $this->form_validation->set_message('sub_county_name', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
   
   
    /*****************Function _get_posted_subcounty_data**********************************
    * @type            : Function
    * @function name   : _get_posted_subcounty_data
    * @description     : Prepare "subcounty" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_subcounty_data() {

        $items = array();
        $items[] = 'region_id';
        $items[] = 'sub_region_id';
        $items[] = 'district_id';
        $items[] = 'sub_county_name';
        $items[] = 'sub_county_code';
    
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
             redirect('manageschool/subcounty/index/');    
        }
        
        $subcounty = $this->subcounty->get_single('subcounty', array('id' => $id));
        
        if ($this->subcounty->delete('subcounty', array('id' => $id))) { 
            
            create_log('Has been deleted a subcounty : '. $subcounty->sub_county_name);
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('manageschool/subcounty/index/');
        
    }
}
