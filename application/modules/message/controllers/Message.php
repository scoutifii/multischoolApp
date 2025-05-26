<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Message extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Message_Model', 'message', true);

        $this->data['sents'] = $this->message->get_message_list($type = 'sent');
        $this->data['drafts'] = $this->message->get_message_list($type = 'draft');
        $this->data['trashs'] = $this->message->get_message_list($type = 'trash');
        $this->data['inboxs'] = $this->message->get_message_list($type = 'inbox');
        $this->data['new'] = $this->message->get_message_list($type = 'new');
        
        error_reporting(0);
    }

                    
    /*****************Function inbox**********************************
    * @type            : Function
    * @function name   : inbox
    * @description     : Load "Private Inbox Message List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function inbox() {

        check_permission(VIEW);

        $this->data['inbox'] = TRUE;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('inbox') . ' | ' . SMS);
        $this->layout->view('message/inbox', $this->data);
    }

                
    /*****************Function sent**********************************
    * @type            : Function
    * @function name   : sent
    * @description     : Load "Private Sent Message List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function sent() {

        check_permission(VIEW);

        $this->data['sent'] = TRUE;
        $this->layout->title($this->lang->line('send'). ' | ' . SMS);
        $this->layout->view('message/sent', $this->data);
    }

            
    /*****************Function draft**********************************
    * @type            : Function
    * @function name   : draft
    * @description     : Load "Private Draft Message List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function draft() {

        check_permission(VIEW);

        $this->data['draft'] = TRUE;
        $this->layout->title($this->lang->line('draft') . ' | ' . SMS);
        $this->layout->view('message/draft', $this->data);
    }

        
    /*****************Function trash**********************************
    * @type            : Function
    * @function name   : trash
    * @description     : Load "Private Trash Message List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function trash() {

        check_permission(VIEW);

        $this->data['trash'] = TRUE;
        $this->layout->title($this->lang->line('trash') . ' | ' . SMS);
        $this->layout->view('message/trash', $this->data);
    }

    
        
    /*****************Function compose**********************************
    * @type            : Function
    * @function name   : compose
    * @description     : Load "Compose a New Message" user interface                 
    *                    and process to store "Message" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function compose($id = null) {

        check_permission(ADD);

        if ($_POST) {

            $data = array();
            
            
            $data['school_id'] = $this->input->post('school_id');
            $data['subject'] = $this->input->post('subject');
            $data['body'] = nl2br($this->input->post('body'));
                   
            $school = $this->message->get_school_by_id($data['school_id']);
                             
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('message/inbox');
            }
            
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['attachment'] = '';

            if ($this->input->post('message_id')) {
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                $this->message->update('messages', $data, array('id' => $this->input->post('message_id')));
            } else {
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                $insert_id = $this->message->insert('messages', $data);
            }

            // default value for relation table
            $relation_data = array();

            $relation_data['school_id'] = $data['school_id'] ;
            $relation_data['sender_id'] = logged_in_user_id();
            $relation_data['receiver_id'] = $this->input->post('receiver_id');
            $relation_data['is_trash'] = 0;
            $relation_data['is_draft'] = 0;
            $relation_data['is_favorite'] = 0;
            $relation_data['is_read'] = 0;
            $relation_data['status'] = 1;

            if ($this->input->post('message_id')) {
                $relation_data['message_id'] = $this->input->post('message_id');
                $relation_data['modified_at'] = date('Y-m-d H:i:s');
                $relation_data['modified_by'] = logged_in_user_id();
            } else {
                $relation_data['message_id'] = $insert_id;
                $relation_data['created_at'] = date('Y-m-d H:i:s');
                $relation_data['created_by'] = logged_in_user_id();
            }


            if (isset($_POST['draft'])) { // if draft
                $relation_data['role_id'] = $this->input->post('role_id'); // opposite
                if ($this->input->post('message_id')) {
                    $condition = array('message_id' => $this->input->post('message_id'), 'owner_id' => logged_in_user_id());
                    $this->message->update('message_relationships', $relation_data, $condition);
                } else {
                    $relation_data['owner_id'] = logged_in_user_id();
                    $relation_data['is_draft'] = 1;
                    $this->message->insert('message_relationships', $relation_data);
                }

                success($this->lang->line('insert_success'));
                redirect('message/draft');
            } else { // if sent
                $relation_data['is_draft'] = 0;

                if ($this->input->post('message_id')) {

                    // save message relationships  for sender
                    $condition = array('message_id' => $this->input->post('message_id'), 'owner_id' => logged_in_user_id());
                    $relation_data['role_id'] = $this->input->post('role_id'); // opposite  
                    $this->message->update('message_relationships', $relation_data, $condition);
                } else {
                    // save message relationships  for sender
                    $relation_data['owner_id'] = logged_in_user_id();
                    $relation_data['role_id'] = $this->session->userdata('role_id'); // opposite                 
                    $this->message->insert('message_relationships', $relation_data);
                }

                // save message relationships  for receiver
                $relation_data['owner_id'] = $this->input->post('receiver_id');
                $relation_data['role_id'] = $this->input->post('role_id'); // opposite  
                $this->message->insert('message_relationships', $relation_data);
                success($this->lang->line('insert_success'));
                redirect('message/sent');
            }
        }

        if ($id) {
            $this->data['message'] = $this->message->get_single_message($id);
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['classes'] = $this->message->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 

        $this->data['roles'] = $this->message->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->layout->title($this->lang->line('compose') . ' | ' . SMS);
        $this->layout->view('message/compose', $this->data);
    }

        
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific Private Message & Reply data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);

        if ($id) {
            $this->data['message'] = $this->message->get_single_message($id);            
            $this->message->update('message_relationships', array('is_read' => 1), array('message_id' => $id, 'owner_id'=> logged_in_user_id()));
            
            $this->data['replies'] = $this->message->get_list('replies', array('message_id' => $id), '', '', '', 'id', 'ASC');

            if (!$this->data['message']) {
                redirect('message/inbox');
            }
        }

        $this->data['view'] = TRUE;
        $this->layout->title($this->lang->line('read_message') . ' | ' . SMS);
        $this->layout->view('message/view', $this->data);
    }
   
       
        
    /*****************Function reply**********************************
    * @type            : Function
    * @function name   : reply
    * @description     : process to reply a Private message and store into database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */ 
    public function reply($id = null) {

        check_permission(ADD);

        if ($_POST) {

            $data = array();

            $data['message_id'] = $this->input->post('message_id');
            $data['sender_id'] = logged_in_user_id();
            $data['receiver_id'] = $this->input->post('receiver_id');
            $data['body'] = nl2br($this->input->post('body'));
            $data['attachment'] = '';
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            if ($this->message->insert('replies', $data)) {
                success($this->lang->line('insert_success'));
            } else {
                success($this->lang->line('insert_failed'));
            }

            redirect('message/view/' . $id);
        }

        redirect('message/view/' . $this->input->post('message_id'));
    }

    
        
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Private Message" with reply from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        $exist = $this->message->get_list('message_relationships', array('status' => 1, 'message_id' => $id, 'owner_id !=' => logged_in_user_id()));

        if (!empty($exist)) {
            $data = array('status' => 0);
            $condition = array('message_id' => $id, 'owner_id' => logged_in_user_id());
            $this->message->update('message_relationships', $data, $condition);
            success($this->lang->line('delete_success'));
        } else {
            $this->message->delete('message_relationships', array('message_id' => $id));
            $this->message->delete('messages', array('id' => $id));
            $this->message->delete('replies', array('message_id' => $id));
            success($this->lang->line('delete_success'));
        }

        redirect('message/inbox');
    }    
        
        
    /*****************Function set_fvourite_status**********************************
    * @type            : Function
    * @function name   : set_fvourite_status
    * @description     : set favorite status of a System Private Message                
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function set_fvourite_status() {
        $star = $this->input->post('star');
        $message_id = $this->input->post('message_id');
        if ($star == FALSE) {
            $data = array('is_favorite' => 0);
        } else {
            $data = array('is_favorite' => 1);
        }
        $condition = array('message_id' => $message_id, 'owner_id' => logged_in_user_id());
        $this->message->update('message_relationships', $data, $condition);
        echo TRUE;
    }

        
        
    /*****************Function set_trash_status**********************************
    * @type            : Function
    * @function name   : set_trash_status
    * @description     : set trash status of a System Private Message                
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function set_trash_status() {

        $message_ids = $this->input->post('message_ids');
        $data = array('is_trash' => 1);

        if (!empty($message_ids)) {
            foreach ($message_ids as $value) {
                $condition = array('message_id' => $value, 'owner_id' => logged_in_user_id());
                $this->message->update('message_relationships', $data, $condition);
            }
        }

        echo TRUE;
    }

    
        
    /*****************Function set_delete_status**********************************
    * @type            : Function
    * @function name   : set_delete_status
    * @description     : set delete status of a System Private Message                
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function set_delete_status() {

        $message_ids = $this->input->post('message_ids');
        $data = array('status' => 0);

        if (!empty($message_ids)) {
            foreach ($message_ids as $value) {
                // check
                // $exist = $this->message->get_list('message_relationships', array('status' => 1, 'message_id'=>$value, 'owner_id !='=> logged_in_user_id()));
                $condition = array('message_id' => $value, 'owner_id' => logged_in_user_id());
                $this->message->update('message_relationships', $data, $condition);
            }
        }

        echo TRUE;
    }

}
