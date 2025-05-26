<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Operation.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Opration
 * @description     : Manage application controller.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Operation extends CI_Controller {

    public $data = array();
    public $config_path = 'application/config/custom.php';
    
    public $schools = array();
    public $global_setting = array();
    public $school_setting = array();
    
    function __construct() {
        parent::__construct();
         $this->load->model('Setting_Model', 'setting', true);
         $this->data['modules'] = $this->setting->get_list('modules', array('status'=>1), '','', '', 'id', 'ASC'); 
         $this->data['operations'] = $this->setting->get_operation_list();
         
        $this->schools = $this->db->get_where('schools', array('status'=>1))->result();
        $this->global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();       
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->school_setting = $this->db->get_where('schools', array('status'=>1, 'id'=>$this->session->userdata('school_id')))->row();
        }
        $this->config->load('custom');
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && !empty($this->global_setting)){  
           
             $this->lang->load($this->global_setting->language);
             
        }else if($this->session->userdata('role_id') != SUPER_ADMIN && !empty($this->school_setting)){
            
            $this->lang->load($this->school_setting->language);
        }
    }
 
    public function index() {
          $this->update_conf();
        $this->data['list'] = TRUE;
        $this->layout->title('SMS | Operation');
        $this->layout->view('operation/index', $this->data);            
       
    }

    public function add() {

        if ($_POST) {
            $this->_prepare_operation_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_operation_data();

                $insert_id = $this->setting->insert('operations', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('setting/operation/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('setting/operation/add');
                }
            } else {
                $this->data = $_POST;
            }
        }

        $this->data['add'] = TRUE;
        $this->layout->title('SMS | Operation Add');
        $this->layout->view('operation/index', $this->data);
    }

    public function edit($id = null) {       
       
        if ($_POST) {
            $this->_prepare_operation_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_operation_data();
                $updated = $this->setting->update('operations', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('setting/operation/index');                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('setting/operation/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data = $_POST;
            }
        } else {
            if ($id) {
                $this->data['operation'] = $this->setting->get_single('operations', array('id' => $id));
 
                if (!$this->data['operation']) {
                     redirect('setting/operation/index');
                }
            }
        }

        $this->data['edit'] = TRUE;       
        $this->layout->title('SMS | Operation Edit');
        $this->layout->view('operation/index', $this->data);
    }
    
    private function _prepare_operation_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('module_id', 'module_id', 'trim|required');
        $this->form_validation->set_rules('operation_name', 'operation_name', 'trim|required');
        $this->form_validation->set_rules('operation_slug', 'operation_slug', 'trim|required');       
    }

    private function _get_posted_operation_data() {

        $items = array();
        $items[] = 'module_id';
        $items[] = 'operation_name';
        $items[] = 'operation_slug';
        $items[] = 'is_view_vissible';
        $items[] = 'is_add_vissible';
        $items[] = 'is_edit_vissible';
        $items[] = 'is_delete_vissible';
        
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
        if ($this->setting->delete('operations', array('id' => $id))) {            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        $this->update_conf();
        redirect('setting/operation');
    }
    
    
    
    public function update_conf() {

        $data = array();

        $this->db->select('P.*, M.module_slug, O.operation_slug');
        $this->db->from('privileges AS P');
        $this->db->join('operations AS O', 'O.id = P.operation_id', 'left');
        $this->db->join('modules AS M', 'M.id = O.module_id', 'left');
        $results = $this->db->get()->result();


        foreach ($results as $obj) {
            // $data[][$obj->operation_slug][$obj->role_id] = $obj->is_add .'|'.$obj->is_edit.'|'.$obj->is_view.'|'.$obj->is_delete;
            $data[] = $obj;
        }
        if (!is_array($data) && count($data) == 0) {
            return FALSE;
        }

        @chmod($this->config_path, FILE_WRITE_MODE);

        // Is the config file writable?
        if (!is_really_writable($this->config_path)) {
            show_error($this->config_path . ' does not appear to have the proper file permissions.  Please make the file writeable.');
        }
        // Read the config file as PHP
        require $this->config_path;

        // load the file helper
        $this->CI = & get_instance();
        $this->CI->load->helper('file');

        // Read the config data as a string
        //$lang_file = read_file($this->lang_path);
        // Trim it
        //$lang_file = trim($lang_file);

        $config_file = '<?php ';

        // Do we need to add totally new items to the config file?
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if($val->operation_slug){
                    //$pattern = '/\$lang\[\\\'' . $key . '\\\'\]\s+=\s+[^\;]+/';  
                    $config_file .= "\n";
                    $config_file .= "\$config['my_$val->module_slug']['$val->operation_slug']['$val->role_id'] = '" . $val->is_add . "|" . $val->is_edit . "|" . $val->is_view . "|" . $val->is_delete . "';";
                    //$config_file = preg_replace($pattern, $replace, $config_file);
                }
            }
        }

        if (!$fp = fopen($this->config_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
            return FALSE;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $config_file, strlen($config_file));
        flock($fp, LOCK_UN);
        fclose($fp);


        @chmod($this->config_path, FILE_READ_MODE);

        return TRUE;
    }
 

}
