<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Incomehead.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Incomehead
 * @description     : Manage all income type/head/title as per accounting term.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Incomehead extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Incomehead_Model', 'incomehead', true);               
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
            
        $this->data['incomeheads'] = $this->incomehead->get_incomehead_list($school_id);  
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_income_head'). ' | ' . SMS);
        $this->layout->view('income_head/index', $this->data);
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
            $this->_prepare_incomehead_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_incomehead_data();

                $insert_id = $this->incomehead->insert('income_heads', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a income head : '. $data['title']);                    
                    success($this->lang->line('insert_success'));
                    redirect('accounting/incomehead/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('accounting/incomehead/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['incomeheads'] = $this->incomehead->get_incomehead_list();  
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('income_head/index', $this->data);
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
            redirect('accounting/incomehead/index');   
        }
        
        if ($_POST) {
            $this->_prepare_incomehead_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_incomehead_data();
                $updated = $this->incomehead->update('income_heads', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a income head : '. $data['title']);                    
                    success($this->lang->line('update_success'));
                    redirect('accounting/incomehead/index/'.$data['school_id']);      
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('accounting/incomehead/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['incomehead'] = $this->incomehead->get_single('income_heads', array('id' => $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['incomehead'] = $this->incomehead->get_single('income_heads', array('id' => $id));

            if (!$this->data['incomehead']) {
                 redirect('accounting/incomehead/index');
            }
        }

        $this->data['incomeheads'] = $this->incomehead->get_incomehead_list($this->data['incomehead']->school_id);  
        $this->data['school_id'] = $this->data['incomehead']->school_id;
        $this->data['filter_school_id'] = $this->data['incomehead']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('income_head/index', $this->data);
    }

    
    
    /*****************Function _prepare_incomehead_validation**********************************
     * @type            : Function
     * @function name   : _prepare_incomehead_validation
     * @description     : Process "Incoem Head" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_incomehead_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('title', $this->lang->line('income_head'), 'trim|required|callback_title');   
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
          $incomehead = $this->incomehead->duplicate_check($this->input->post('school_id'), $this->input->post('title')); 
          if($incomehead){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $incomehead = $this->incomehead->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('id')); 
          if($incomehead){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }   
   }

   
     /*****************Function _get_posted_incomehead_data**********************************
     * @type            : Function
     * @function name   : _get_posted_incomehead_data
     * @description     : Prepare "Income Head" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_incomehead_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'note';
        $data = elements($items, $_POST);  
    
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['head_type'] = 'income';
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
            redirect('accounting/incomehead/index');   
        }
        
        $income_head = $this->incomehead->get_single('income_heads', array('id' => $id));
        
        if ($this->incomehead->delete('income_heads', array('id' => $id))) { 
            
            create_log('Has been deleted a income head : '. $income_head->title);
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('accounting/incomehead/index/'.$income_head->school_id);
    }

}
