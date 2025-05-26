<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Module.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Module
 * @description     : Manage application module.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Module extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Setting_Model', 'setting', true);
         $this->data['modules'] = $this->setting->get_list('modules', array('status'=>1), '','', '', 'id', 'ASC');
    }

    public function index() {
        
        $this->data['list'] = TRUE;
        $this->layout->title('SMS | Module');
        $this->layout->view('module/index', $this->data);            
       
    }

    public function add() {

        if ($_POST) {
            $this->_prepare_module_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_module_data();

                $insert_id = $this->setting->insert('modules', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('setting/module/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('setting/module/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['add'] = TRUE;
        $this->layout->title('SMS | Module Add');
        $this->layout->view('module/index', $this->data);
    }

    public function edit($id = null) {       
       
        if ($_POST) {
            $this->_prepare_module_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_module_data();
                $updated = $this->setting->update('modules', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('setting/module/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('setting/module/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data = $_POST;
            }
        } else {
            if ($id) {
                $this->data['module'] = $this->setting->get_single('modules', array('id' => $id));
 
                if (!$this->data['module']) {
                     redirect('setting/module/index');
                }
            }
        }

        $this->data['edit'] = TRUE;       
        $this->layout->title('SMS | Module Edit');
        $this->layout->view('module/index', $this->data);
    }

    private function _prepare_module_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('module_name', 'module_name', 'trim|required');
        $this->form_validation->set_rules('module_slug', 'module_slug', 'trim|required');       
    }

    private function _get_posted_module_data() {

        $items = array();
        $items[] = 'module_name';
        $items[] = 'module_slug';
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

    
    public function delete($id = null) {
        if ($this->setting->delete('modules', array('id' => $id))) {            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('setting/module');
    }

}
