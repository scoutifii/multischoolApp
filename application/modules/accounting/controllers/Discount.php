<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Discount.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Discount
 * @description     : Manage all discount type/head/title as per accounting term.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Discount extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Discount_Model', 'discount', true); 
    }

    
    
     /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Discount List" user interface                 
     *                     
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);        
        $this->data['discounts'] = $this->discount->get_discount_list($school_id); 
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_discount'). ' | ' . SMS);
        $this->layout->view('discount/index', $this->data);            
       
    }

    
     /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Discount" user interface                 
     *                    and store "Discount" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);
        
        if ($_POST) {
            $this->_prepare_discount_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_discount_data();

                $insert_id = $this->discount->insert('discounts', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a discount : '.$data['title']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('accounting/discount/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('accounting/discount/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['discounts'] = $this->discount->get_discount_list(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('discount/index', $this->data);
    }

    
     /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Discount" user interface                 
     *                    with populated "Discount" value 
     *                    and update "Discount" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        
          
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/discount/index');   
        }
        
        if ($_POST) {
            $this->_prepare_discount_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_discount_data();
                $updated = $this->discount->update('discounts', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a discount : '.$data['title']);                    
                    success($this->lang->line('update_success'));
                    redirect('accounting/discount/index/'.$data['school_id']); 
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('accounting/discount/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['discount'] = $this->discount->get_single('discounts', array('id' => $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['discount'] = $this->discount->get_single('discounts', array('id' => $id));

            if (!$this->data['discount']) {
                 redirect('accounting/discount/index');
            }
        }
        
        $this->data['discounts'] = $this->discount->get_discount_list($this->data['discount']->school_id); 
        $this->data['school_id'] = $this->data['discount']->school_id;
        $this->data['filter_school_id'] = $this->data['discount']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('discount/index', $this->data);
    }

    
    
    /*****************Function _prepare_discount_validation**********************************
     * @type            : Function
     * @function name   : _prepare_discount_validation
     * @description     : Process "Discount" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_discount_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');   
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');   
        $this->form_validation->set_rules('discount_type', $this->lang->line('discount_type'), 'trim|required');   
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required');   
    }
    
    
    
        
    /*****************Function title**********************************
     * @type            : Function
     * @function name   : title
     * @description     : Unique check for "discount title" data/value                  
     *                       
     * @param           : null
     * @return          : boolean true/false 
     * ********************************************************** */ 
   public function title()
   {             
      if($this->input->post('id') == '')
      {   
          $title = $this->discount->duplicate_check($this->input->post('school_id'), $this->input->post('title')); 
          if($title){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $title = $this->discount->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('id')); 
          if($title){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }   
   }

   
     /*****************Function _get_posted_discount_data**********************************
     * @type            : Function
     * @function name   : _get_posted_discount_data
     * @description     : Prepare "Discount" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_discount_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'discount_type';
        $items[] = 'amount';
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
     * @description     : delete "Discount" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('accounting/discount/index');   
        }
        
        $discount = $this->discount->get_single('discounts', array('id' => $id));
        
        if ($this->discount->delete('discounts', array('id' => $id))) {

            create_log('Has been deleted a discount : '.$discount->title);            
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('accounting/discount/index/'.$discount->school_id);
    }

}
