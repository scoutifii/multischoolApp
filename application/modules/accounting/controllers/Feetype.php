<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Feetype extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Feetype_Model', 'feetype', true);  
        
    }

    
    
     /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Income Head List" user interface                 
     *                     
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->feetype->get_list('classes', $condition, '', '', '', 'id', 'ASC');  
        }   
        
        $this->data['feetypes'] = $this->feetype->get_fee_type($school_id);  
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_fee_type'). ' | ' . SMS);
        $this->layout->view('fee_type/index', $this->data);            
       
    }

    
     /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Income Head" user interface                 
     *                    and store "Income Head" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_feetype_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_feetype_data();

                $insert_id = $this->feetype->insert('income_heads', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a fee type : '. $data['title']);                  
                   
                    $this->_save_fee_amount($insert_id);                    
                    success($this->lang->line('insert_success'));
                    redirect('accounting/feetype/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('accounting/feetype/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->feetype->get_list('classes', $condition, '', '', '', 'id', 'ASC');  
        } 

        $this->data['feetypes'] = $this->feetype->get_fee_type();  
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('fee_type/index', $this->data);
    }

    
     /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Income Head" user interface                 
     *                    with populated "Income Head" value 
     *                    and update "Income Head" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
          
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/feetype/index');   
        }
        
        if ($_POST) {
            $this->_prepare_feetype_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_feetype_data();
                $updated = $this->feetype->update('income_heads', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a fee type : '. $data['title']);                    
                    $this->_save_fee_amount($this->input->post('id'));
                    success($this->lang->line('update_success'));
                    redirect('accounting/feetype/index/'.$data['school_id']);  
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('accounting/feetype/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['feetype'] = $this->feetype->get_single('income_heads', array('id' => $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['feetype'] = $this->feetype->get_single('income_heads', array('id' => $id));

            if (!$this->data['feetype']) {
                 redirect('accounting/feetype/index');
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->feetype->get_list('classes', $condition, '', '', '', 'id', 'ASC');  
        } 

        $this->data['feetypes'] = $this->feetype->get_fee_type($this->data['feetype']->school_id);  
        $this->data['school_id'] = $this->data['feetype']->school_id;
        $this->data['filter_school_id'] = $this->data['feetype']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit').  ' | ' . SMS);
        $this->layout->view('fee_type/index', $this->data);
    }

               
     /*****************Function get_single_feetype**********************************
     * @type            : Function
     * @function name   : get_single_feetype
     * @description     : "Load single assignment information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_feetype(){
        
       $feetype_id = $this->input->post('feetype_id');       
        
       $this->data['feetype'] = $this->feetype->get_single_feetype($feetype_id);      
       
       $this->data['classes'] = $this->feetype->get_list('classes', array('school_id'=>$this->data['feetype']->school_id), '', '', '', 'id', 'ASC');  
       echo $this->load->view('fee_type/get-single-feetype', $this->data);
    }
    
    
    /*****************Function _prepare_feetype_validation**********************************
     * @type            : Function
     * @function name   : _prepare_feetype_validation
     * @description     : Process "Incoem Head" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_feetype_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('head_type', $this->lang->line('fee_type'), 'trim|required');   
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');   
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');   
    }
    
    
    
        
    /*****************Function title**********************************
     * @type            : Function
     * @function name   : title
     * @description     : Unique check for "Income head title" data/value                  
     *                       
     * @param           : null
     * @return          : boolean true/false 
     * ********************************************************** */ 
   public function title()
   {             
      if($this->input->post('id') == '')
      {   
          $feetype = $this->feetype->duplicate_check($this->input->post('school_id'), $this->input->post('title')); 
          if($feetype){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $feetype = $this->feetype->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('id')); 
          if($feetype){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }   
   }

   
     /*****************Function _get_posted_feetype_data**********************************
     * @type            : Function
     * @function name   : _get_posted_feetype_data
     * @description     : Prepare "Income Head" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_feetype_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'head_type';
        $items[] = 'note';
        $data = elements($items, $_POST);  
    
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
     * @description     : delete "Income head" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/feetype/index');   
        }
        
        $fee_type = $this->feetype->get_single('income_heads', array('id' => $id));
        
        if ($this->feetype->delete('income_heads', array('id' => $id))) {
            
            $this->feetype->delete('fees_amount', array('income_head_id' => $id));            
            create_log('Has been deleted a fee type : '. $fee_type->title);            
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('accounting/feetype/index/'.$fee_type->school_id);
    }
    
    
    
    private function _save_fee_amount($income_head_id){
        
        if($this->input->post('head_type') == 'fee'){
        
            foreach($this->input->post('class_id') as $key=>$value){

                $data = array();
                $exist = '';
                //$amount_id = @$this->input->post('amount_id')[$key];
                $amount_id = @$_POST['amount_id'][$key];

                if($amount_id){
                   $exist = $this->feetype->get_single('fees_amount', array('class_id'=>$key, 'id'=>$amount_id)); 

                } 

                //$data['fee_amount'] = $this->input->post('fee_amount')[$key];
                $data['fee_amount'] = @$_POST['fee_amount'][$key];
                $data['school_id'] = $this->input->post('school_id');

                if ($this->input->post('id') && $exist) {                

                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();                
                    $this->feetype->update('fees_amount', $data, array('id'=>$exist->id));

                } else {

                    $data['income_head_id'] = $income_head_id;
                    $data['class_id'] = $key;                
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id(); 
                    $this->feetype->insert('fees_amount', $data);
                }
            }

        }else{ 
            
             $this->feetype->delete('fees_amount', array('income_head_id'=>$income_head_id));
        }
    }
    
    
    /* Ajax */
    public function get_fee_head_by_school(){
       $school_id = $this->input->post('school_id');
       $this->data['fee_type_id'] = $this->input->post('fee_type_id');
       
       $this->data['classes'] = $this->feetype->get_list('classes', array('school_id'=>$school_id), '', '', '', 'id', 'ASC');  
       echo $this->load->view('fee_type/get-classes', $this->data);
    }

}