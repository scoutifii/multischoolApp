<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Receive.php**********************************
 * @product name    : Global Multi School Management System Express
 * @Receive            : Class
 * @class name      : Receive
 * @description     : Manage Postal receive.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Receive extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Receive_Model', 'receive', true);        
    }

    
    /*****************Function index**********************************
    * @Receive            : Function
    * @function name   : index
    * @description     : Load "Receive List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);        
        $this->data['receives'] = $this->receive->get_receive($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_postal_receive').' | ' . SMS);
        $this->layout->view('receive/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Receive            : Function
    * @function name   : add
    * @description     : Load "Add new postal Receive" user interface                 
    *                    and process to store "postal Receive" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

         check_permission(ADD);
        if ($_POST) {
            $this->_prepare_receive_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_receive_data();

                $insert_id = $this->receive->insert('postal_receives', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('frontoffice/receive/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('frontoffice/receive/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }

        $this->data['receives'] = $this->receive->get_receive(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('receive/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Receive            : Function
    * @function name   : edit
    * @description     : Load Update "postal Receive" user interface                 
    *                    with populate "postal Receive" value 
    *                    and process to update "postal Receive" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

         check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_receive_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_receive_data();
                $updated = $this->receive->update('postal_receives', $data, array('id' => $this->input->post('id')));

                if ($updated) {                   
                    
                    success($this->lang->line('update_success'));
                    redirect('frontoffice/receive/index/'.$data['school_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('frontoffice/receive/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['receive'] = $this->receive->get_single('postal_receives', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['receive'] = $this->receive->get_single('postal_receives', array('id' => $id));

                if (!$this->data['receive']) {
                     redirect('frontoffice/receive/index');
                }
            }
        }

        $this->data['school_id'] = $this->data['receive']->school_id;
        $this->data['filter_school_id'] = $this->data['receive']->school_id;;
        $this->data['schools'] = $this->schools;
        $this->data['receives'] = $this->receive->get_receive($this->data['school_id']); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('receive/index', $this->data);
    }

   
               
     /*****************Function get_single_receive**********************************
     * @type            : Function
     * @function name   : get_single_receive
     * @description     : "Load single receive information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_receive(){
        
       $receive_id = $this->input->post('receive_id');
       
       $this->data['receive'] = $this->receive->get_single_receive($receive_id);
       echo $this->load->view('receive/get-single-receive', $this->data);
    }
    
    /*****************Function _prepare_receive_validation**********************************
    * @Receive            : Function
    * @function name   : _prepare_receive_validation
    * @description     : Process "postal Receive" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_receive_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('from_title', $this->lang->line('from_title'), 'trim|required');
        $this->form_validation->set_rules('reference', $this->lang->line('reference'), 'trim');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim|required');
        $this->form_validation->set_rules('to_title', $this->lang->line('to_title'), 'trim|required');
        $this->form_validation->set_rules('receive_date', $this->lang->line('receive_date'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        
        $this->form_validation->set_rules('attachment', $this->lang->line('attachment'), 'trim|callback_attachment'); 
    }

    
    
    /*****************Function attachment**********************************
    * @type            : Function
    * @function name   : attachment
    * @description     : validate attachment                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */
    public function attachment() {
        if ($_FILES['attachment']['name']) {
            $name = $_FILES['attachment']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'ppt' || $ext == 'pptx' || $ext == 'txt'|| $ext == 'xls' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('attachment', $this->lang->line('select_valid_file_format').' Ex: jpg, jpeg, png, gif, doc, docx, pdf, ppt, pptx, xls, txt');
                return FALSE;
            }
        }
    }
    
    
    /*****************Function _get_posted_receive_data**********************************
    * @Receive            : Function
    * @function name   : _get_posted_receive_data
    * @description     : Prepare "Receive" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_receive_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'from_title';
        $items[] = 'reference';
        $items[] = 'address';
        $items[] = 'to_title';
        $items[] = 'note';
        $data = elements($items, $_POST);        
        
        $data['receive_date'] = date('Y-m-d', strtotime($this->input->post('receive_date')));
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
        }
        
        
        if (isset($_FILES['attachment']['name'])) {
            $data['attachment'] = $this->_upload_attachment();
        }
        return $data;
    }    
        
    
            
    /*****************Function _upload_attachment**********************************
    * @type            : Function
    * @function name   : _upload_attachment
    * @description     : Process to to upload attachment in the server
    *                    and return image name                   
    *                       
    * @param           : null
    * @return          : $return_image string value 
    * ********************************************************** */
    private function _upload_attachment() {

        $prev_attachment = $this->input->post('prev_attachment');
        $attachment = $_FILES['attachment']['name'];
        $return_attachment = '';
        if ($attachment != "") {

                $destination = 'assets/uploads/postal/';

                $file_type = explode(".", $attachment);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $attachment_path = 'receive-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['attachment']['tmp_name'], $destination . $attachment_path);
                // need to unlink previous image
                if ($prev_attachment != "") {
                    if (file_exists($destination . $prev_attachment)) {
                        @unlink($destination . $prev_attachment);
                    }
                }

                $return_attachment = $attachment_path;
          
        } else {
            $return_attachment = $prev_attachment;
        }

        return $return_attachment;
    }

     
    
    
    /*****************Function delete**********************************
    * @Receive            : Function
    * @function name   : delete
    * @description     : delete "postal Receive" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('frontoffice/receive/index');        
        }
        
        $receive = $this->receive->get_single('postal_receives', array('id' => $id));        
        if ($this->receive->delete('postal_receives', array('id' => $id))) { 
            
             // delete attachments
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/postal/' . $receive->attachment)) {
                @unlink($destination . '/postal/' . $receive->attachment);
            }  
            
            success($this->lang->line('delete_success'));
            redirect('frontoffice/receive/index/'.$receive->school_id);
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('frontoffice/receive/index');
    }
}
