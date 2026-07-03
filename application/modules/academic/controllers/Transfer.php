<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Transfer extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Transfer_Model', 'transfer', true);
    }

        
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "Transfer" user input interface and 
     *                      process/filter transfer teacher
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index() {                
        
        check_permission(VIEW);
                         
        $this->data['transfers'] = $this->transfer->get_teacher_transfer_list();
        $this->layout->title( $this->lang->line('manage_transfer'). ' | ' . SMS);
        $this->layout->view('transfer/index', $this->data);  
    }
    
    
            
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Process "transfer" to next school                 
     *                    and store transfered school information into database    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {                
        
        check_permission(ADD);

        if (!$this->input->post()) {
            error($this->lang->line('insert_failed'));
            redirect('academic/transfer/index');
        }

        $school_id          = $this->input->post('school_id');
        $next_school_id     = $this->input->post('next_school_id');
        $teacher_id         = $this->input->post('teacher_id');
        $next_session_id    = $this->input->post('next_session_id');
        $academic_year_id   = $this->input->post('academic_year_id'); 

        // Get Teacher information
        $teacher = $this->transfer->get_single('teachers', array('id' => $teacher_id));

        // start transaction
        $this->db->trans_begin();

        try {
            $data = array(
                'school_id'          => $school_id,
                'next_school_id'     => $next_school_id,
                'teacher_id'         => $teacher_id,
                'created_at'         => date('Y-m-d H:i:s'),
                'created_by'         => logged_in_user_id()
            );

            $this->transfer->insert('teacher_transfers', $data);

            // update teachers current school
            $teacherData = array(
                'school_id'          => $school_id,
                'is_transferable'    => 1,
                'modified_at'        => date('Y-m-d H:i:s'),
                'modified_by'        => logged_in_user_id()
            );

            $this->transfer->update('teachers', $teacherData, array('id' => $teacher_id));

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Transfer failed");
            }
            
            $this->db->trans_commit();
            
            $school = $this->transfer->get_single('schools', array('id' => $next_school_id));
            create_log('Has been transfered teacher to a school : '. $school->name);
            
            success($this->lang->line('insert_success'));

            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            error($e->getMessage());
        }

        redirect('academic/transfer/index');

    }
}