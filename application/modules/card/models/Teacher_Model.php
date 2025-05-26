<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    
    public function get_teacher_list($school_id = null, $teacher_id = null) {

        $this->db->select('T.*, U.username, U.role_id, U.status AS login_status ');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->where('T.school_id', $school_id);

        if($teacher_id){
            $this->db->where('T.id', $teacher_id);
        }           

         $this->db->order_by('T.id', 'ASC');
        return $this->db->get()->result();
    }
   
}
