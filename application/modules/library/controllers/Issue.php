<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Issue extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Book_Model', 'book', true);
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Issued Book List" user interface                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $condition = array();
        $condition['status'] = 1;       
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            
            $condition['school_id'] = $this->session->userdata('school_id');        
            $this->data['books'] = $this->book->get_list('books', $condition);
            $school_id = $condition['school_id'];
            $this->data['members'] = $this->book->get_library_member_list($is_library_member = 1, $condition['school_id']);
        } 
        
        $school = $this->book->get_school_by_id($school_id);    
        
        $this->data['issue_books'] = $this->book->get_book_issued_list($school_id, @$school->academic_year_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('issue_and_return') . ' | ' . SMS);
        $this->layout->view('issue/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Issue Book" user interface                 
    *                    and process to store "Issued List" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_issue_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_issue_data();

                $insert_id = $this->book->insert('book_issues', $data);
                if ($insert_id) {
                    
                    $book = $this->book->get_single('books', array('id' => $data['book_id']));
                    create_log('Has been issued a Book : '.$book->title);
                    
                    $this->book->update_qty($data['book_id'], 'issue');
                    success($this->lang->line('insert_success'));
                } else {
                    error($this->lang->line('insert_failed'));
                }
                redirect('library/issue');
            }else{
                error($this->lang->line('insert_failed'));
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id'); 
            $this->data['books'] = $this->book->get_list('books', $condition);
            $this->data['members'] = $this->book->get_library_member_list($is_library_member = 1, $condition['school_id']);
        } 
        
        
        $this->data['schools'] = $this->schools;
        $this->data['issue_books'] = $this->book->get_book_issued_list();
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('issue_and_return') . ' | ' . SMS);
        $this->layout->view('issue/index', $this->data);
    }

        
    /*****************Function _prepare_issue_validation**********************************
    * @type            : Function
    * @function name   : _prepare_issue_validation
    * @description     : Process "Issue Book" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_issue_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="text-align: center;color: red;">', '</div>');

        $this->form_validation->set_rules('library_member_id', $this->lang->line('library_member'), 'trim|required');
        $this->form_validation->set_rules('book_id', $this->lang->line('book'), 'trim|required');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
    }

       
    /*****************Function _get_posted_issue_data**********************************
    * @type            : Function
    * @function name   : _get_posted_issue_data
    * @description     : Prepare "Issue Book" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_issue_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'library_member_id';
        $items[] = 'book_id';

        $data = elements($items, $_POST);

        $data['due_date'] = date('Y-m-d', strtotime($this->input->post('due_date')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $school = $this->book->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('library/issue');
            }
        
            $data['academic_year_id'] = $school->academic_year_id;
        
            $data['is_returned'] = 0;
            $data['status'] = 1;
            $data['issue_date'] = date('Y-m-d');

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }
        return $data;
    }


       
    /*****************Function get_book_by_id**********************************
    * @type            : Function
    * @function name   : get_book_by_id
    * @description     : get a Book data/information as per Ajax request                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function get_book_by_id() {

        $book_id = $this->input->post('book_id');
        $book = $this->book->get_single('books', array('id' => $book_id));
        echo json_encode($book);
    }

           
    /*****************Function return_book_by_id**********************************
    * @type            : Function
    * @function name   : return_book_by_id
    * @description     : process to return a issued book to the library               
    *                       
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function return_book_by_id() {

        $issue_id = $this->input->post('issue_id');
        $book_id = $this->input->post('book_id');
        $return_date = date('Y-m-d');      
        $this->book->update('book_issues', array('is_returned' => 1, 'return_date' => $return_date), array('id' => $issue_id));
        $this->book->update_qty($book_id, 'return');
        echo TRUE;
    }
    
        
    /*****************Function get_book_by_school**********************************
     * @type            : Function
     * @function name   : get_book_by_school
     * @description     : Load "Book Listing" by ajax call                
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_book_by_school() {
        
        $school_id  = $this->input->post('school_id');
         
        $books = $this->book->get_list('books', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if (!empty($books)) {
            foreach ($books as $obj) { 
               
                $str .= '<option value="' . $obj->id . '" >' . $obj->title . '</option>';                
            }
        }

        echo $str;
    }
    
    /*****************Function get_library_member_by_school**********************************
     * @type            : Function
     * @function name   : get_library_member_by_school
     * @description     : Load "Library Member Listing" by ajax call  
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_library_member_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $membrs =  $this->book->get_library_member_list($is_library_member = 1, $school_id);
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if (!empty($membrs)) {
            foreach ($membrs as $obj) { 
               
                $str .= '<option value="' . $obj->lm_id . '" >' . $obj->name . '</option>';                
            }
        }

        echo $str;
    }   

}