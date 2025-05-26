<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resultemailsms_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_email_list($school_id = null) {
        $this->db->select('E.*, S.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('emails AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');

        $this->db->where('E.email_type', 'result');

        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $this->db->where('E.school_id', $this->session->userdata('school_id'));
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('E.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('E.id', 'DESC');

        return $this->db->get()->result();
    }

    public function get_sms_list($school_id = null) {
        $this->db->select('TM.*, S.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('text_messages AS TM');
        $this->db->join('roles AS R', 'R.id = TM.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TM.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = TM.school_id', 'left');
        $this->db->where('TM.sms_type', 'result');
        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $this->db->where('TM.school_id', $this->session->userdata('school_id'));
        }
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('TM.school_id', $school_id);
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('TM.id', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_single_email($id) {
        $this->db->select('E.*, S.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('emails AS E');
        $this->db->join('roles AS R', 'R.id = E.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
        $this->db->where('E.id', $id);
        return $this->db->get()->row();
    }

    public function get_single_sms($sms_id) {
        $this->db->select('TM.*, S.school_name, R.name AS receiver_type, AY.session_year ');
        $this->db->from('text_messages AS TM');
        $this->db->join('roles AS R', 'R.id = TM.role_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TM.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = TM.school_id', 'left');
        $this->db->where('TM.id', $sms_id);
        return $this->db->get()->row();
    }

    public function get_user_list_bk($school_id, $role_id, $receiver_id, $class_id = null, $academic_year_id = null) {

        if ($role_id == STUDENT) {

            $this->db->select('E.student_id, E.section_id, S.phone, S.name, S.email, U.username, U.role_id,  U.id,  C.name AS class_name');
            $this->db->from('enrollments AS E');
            $this->db->join('students AS S', 'S.id = E.student_id', 'left');
            $this->db->join('users AS U', 'U.id = S.user_id', 'left');
            $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $this->db->where('E.academic_year_id', $academic_year_id);
            $this->db->where('E.school_id', $school_id);
            $this->db->where('E.class_id', $class_id);

            if ($receiver_id > 0) {
                $this->db->where('S.user_id', $receiver_id);
            }
            return $this->db->get()->result();
        } elseif ($role_id == GUARDIAN) {

            $this->db->select('G.id AS guardian_id, G.phone, G.name, G.email, U.username, U.role_id,  U.id');
            $this->db->from('guardians AS G');
            $this->db->join('users AS U', 'U.id = G.user_id', 'left');
            if ($receiver_id > 0) {
                $this->db->where('G.user_id', $receiver_id);
            }
            return $this->db->get()->result();
        }
    }

    
    public function get_student_list($school_id, $receiver_id, $class_id = null, $academic_year_id = null) {

        $this->db->select('E.student_id, E.section_id, S.phone, S.name, S.email, S.guardian_id, U.username, U.role_id,  U.id,  C.name AS class_name');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->where('E.academic_year_id', $academic_year_id);
        $this->db->where('E.school_id', $school_id);
        $this->db->where('E.class_id', $class_id);
        $this->db->where('S.status_type', 'regular');

        if ($receiver_id > 0) {
            $this->db->where('S.user_id', $receiver_id);
        }
        return $this->db->get()->result();
    }

    public function get_single_student($school_id, $guardian_id, $class_id) {

        $this->db->select('S.id, E.section_id');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->where('E.school_id', $school_id);
        $this->db->where('E.class_id', $class_id);
        $this->db->where('S.guardian_id', $guardian_id);
        return $this->db->get()->row();
    }

    public function get_single_guardian($school_id, $guardian_id) {

        $this->db->select('U.id, G.email, U.role_id, G.name, G.phone');
        $this->db->from('users AS U');
        $this->db->join('guardians AS G', 'G.user_id = U.id', 'left');
        $this->db->where('G.school_id', $school_id);
        $this->db->where('G.id', $guardian_id);

        return $this->db->get()->row();
    }

}
