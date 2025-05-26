<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Exam.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Exam
 * @description     : Manage exam term.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Testing extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Exam_Model', 'exam', true);
    }

    /*     * ***************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Exam term List" user interface                
     *                    
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    public function index($value) {

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');

            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;

            $school = $this->exam->get_school_by_id($school_id);
            if (!$school->academic_year_id) {
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/meritlist');
            }


            $this->data['class'] = $this->db->get_where('classes', array('id' => $class_id))->row()->name;
            if ($section_id) {
                $this->data['section'] = $this->db->get_where('sections', array('id' => $section_id))->row()->name;
            }

            $this->data['academic_year'] = $this->db->get_where('academic_years', array('id' => $academic_year_id))->row()->session_year;
            $this->data['school'] = $this->exam->get_school_by_id($school_id);
        }

        $this->session->unset_userdata($value);
      
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/index', $this->data);
    }

}
