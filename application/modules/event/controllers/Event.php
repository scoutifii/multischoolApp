<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Event.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Event
 * @description     : Manage school event for guardian, student, teacher and employee.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Event extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Event_Model', 'event', true);       
    }


    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Event List" user interface                 
    *                      
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null, $id = null) {

        check_permission(VIEW);

        $this->data['events'] = $this->event->get_event_list($school_id);
        $this->data['roles'] = $this->event->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_event') . ' | ' . SMS);
        $this->layout->view('event/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Event" user interface                 
    *                    and process to store "Event" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_event_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_event_data();

                $insert_id = $this->event->insert('events', $data);
                if ($insert_id) {
                    
                    create_log('Has been creted an Event : '.$data['title']);  
                    success($this->lang->line('insert_success'));
                    redirect('event/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('event/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['events'] = $this->event->get_event_list();
        $this->data['roles'] = $this->event->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('event/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Event" user interface                 
    *                    with populated "Event" value 
    *                    and process to update "Event" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);
        
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('event/index');
        }
        
        if ($_POST) {
            $this->_prepare_event_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_event_data();
                $updated = $this->event->update('events', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated an Event : '.$data['title']); 
                    
                    success($this->lang->line('update_success'));
                    redirect('event/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('event/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['event'] = $this->event->get_single('events', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['event'] = $this->event->get_single('events', array('id' => $id));

            if (!$this->data['event']) {
                redirect('event/index');
            }
        }

        $this->data['events'] = $this->event->get_event_list($this->data['event']->school_id);
        $this->data['roles'] = $this->event->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['school_id'] = $this->data['event']->school_id;
        $this->data['filter_school_id'] = $this->data['event']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('event/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific event data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id) {

        check_permission(VIEW);

        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('event/index');
        }
        
        $this->data['event'] = $this->event->get_single_event($id);
        
        $this->data['events'] = $this->event->get_event_list();
        $this->data['roles'] = $this->event->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('event') . ' | ' . SMS);
        $this->layout->view('event/index', $this->data);
    }

    
        
        
           
     /*****************Function get_single_event**********************************
     * @type            : Function
     * @function name   : get_single_event
     * @description     : "Load single event information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_event(){
        
       $event_id = $this->input->post('event_id');
       
       $this->data['event'] = $this->event->get_single_event($event_id);
       echo $this->load->view('get-single-event', $this->data);
    }
    
    /*****************Function _prepare_event_validation**********************************
    * @type            : Function
    * @function name   : _prepare_event_validation
    * @description     : Process "event" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_event_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('event_for'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('event_place', $this->lang->line('event_place'), 'trim|required');
        $this->form_validation->set_rules('event_from', $this->lang->line('from_date'), 'trim|required');
        $this->form_validation->set_rules('event_to', $this->lang->line('to_date'), 'trim|required');
        $this->form_validation->set_rules('image', $this->lang->line('image'), 'trim|callback_image');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "event title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function title() {
        if ($this->input->post('id') == '') {
            $event = $this->event->duplicate_check($this->input->post('school_id'),$this->input->post('title'), $this->input->post('event_from'));
            if ($event) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $event = $this->event->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('event_from'), $this->input->post('id'));
            if ($event) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function image**********************************
    * @type            : Function
    * @function name   : image
    * @description     : validate event image type/format                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function image() {
        if ($_FILES['image']['name']) {
            $name = $_FILES['image']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('image', $this->lang->line('select_valid_file_format'));
                return FALSE;
            }
        }
    }

    
    /*****************Function _get_posted_event_data**********************************
    * @type            : Function
    * @function name   : _get_posted_event_data
    * @description     : Prepare "event" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_event_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'title';
        $items[] = 'event_place';
        $items[] = 'note';
        $items[] = 'is_view_on_web';

        $data = elements($items, $_POST);

        $data['event_from'] = date('Y-m-d', strtotime($this->input->post('event_from')));
        $data['event_to'] = date('Y-m-d', strtotime($this->input->post('event_to')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        if (isset($_FILES['image']['name'])) {
            $data['image'] = $this->_upload_image();
        }

        return $data;
    }

    
    /*****************Function _upload_image**********************************
    * @type            : Function
    * @function name   : _upload_image
    * @description     : Process to to upload event image in the server
    *                    and return image name                   
    *                       
    * @param           : null
    * @return          : $return_image string value 
    * ********************************************************** */
    private function _upload_image() {

        $prev_image = $this->input->post('prev_image');
        $image = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $return_image = '';
        if ($image != "") {
            if ($image_type == 'image/jpeg' || $image_type == 'image/pjpeg' ||
                    $image_type == 'image/jpg' || $image_type == 'image/png' ||
                    $image_type == 'image/x-png' || $image_type == 'image/gif') {

                $destination = 'assets/uploads/event/';

                $file_type = explode(".", $image);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $image_path = 'event-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['image']['tmp_name'], $destination . $image_path);

                // need to unlink previous image
                if ($prev_image != "") {
                    if (file_exists($destination . $prev_image)) {
                        @unlink($destination . $prev_image);
                    }
                }

                $return_image = $image_path;
            }
        } else {
            $return_image = $prev_image;
        }

        return $return_image;
    }

      
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "event" from database                  
    *                    and unlink event image from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('event/index');
        }
        
        $event = $this->event->get_single('events', array('id' => $id));
        if ($this->event->delete('events', array('id' => $id))) {

            // delete teacher resume and image
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/event/' . $event->image)) {
                @unlink($destination . '/event/' . $event->image);
            }
            
            create_log('Has been deleted an Event : '.$event->title);   
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('event/index/'.$event->school_id);
    }

}
