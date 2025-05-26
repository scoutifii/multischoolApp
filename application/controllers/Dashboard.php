<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Dashboard_Model', 'dashboard', true);  
        
    }

    public $data = array();

    /*  * ***************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Default function, Load logged in user dashboard stattistics  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function index() {
            
        $this->data['school'] = array();
        $school_id = $this->session->userdata('school_id'); 
        $role_id = $this->session->userdata('role_id');  
        $theme = $this->session->userdata('theme');
        $sch_id = $this->input->post('school_id');
        
        $this->data['theme'] = $this->dashboard->get_single('themes', array('status' => 1, 'slug' => $theme));    
        
        // if($this->session->userdata('role_id') != SUPER_ADMIN){            
        //     $this->data['school']   = $this->dashboard->get_single('schools', array('status'=>1, 'id'=>$school_id));
        // }            
       
        
        $this->data['news'] = $this->dashboard->get_list('news', array('status' => 1, 'school_id'=>$school_id), '', '5', '', 'id', 'DESC');
        $this->data['notices'] = $this->dashboard->get_list('notices', array('status' => 1, 'school_id'=>$school_id), '', '5', '', 'id', 'DESC');
        $this->data['events'] = $this->dashboard->get_list('events', array('status' => 1, 'school_id'=>$school_id), '', '', '10', 'id', 'DESC');
        $this->data['holidays'] = $this->dashboard->get_list('holidays', array('status' => 1, 'school_id'=>$school_id), '', '10', '', 'id', 'DESC');
        
        $this->data['schools'] = $this->dashboard->get_school_by_district($school_id);
        $this->data['coordinates'] = $this->dashboard->get_lat_lng($school_id);
        $this->data['users'] = $this->dashboard->get_user_by_role($school_id);
        //$this->data['active_logins'] = $this->dashboard->get_active_user_logins($school_id);
        $this->data['students'] = $this->dashboard->get_student_by_class($school_id);

        $this->data['total_student'] = $this->dashboard->get_total_student($school_id);
        $this->data['total_class'] = $this->dashboard->get_total_class($school_id);
        $this->data['total_guardian'] = $this->dashboard->get_total_guardian($school_id);
        $this->data['total_teacher'] = $this->dashboard->get_total_teacher($school_id);
        $this->data['total_employee'] = $this->dashboard->get_total_employee($school_id);
        $this->data['total_expenditure'] = $this->dashboard->get_total_expenditure($school_id);
        $this->data['total_income'] = $this->dashboard->get_total_income($school_id);
        $this->data['total_teacher_absent'] = $this->dashboard->get_total_teacher_absent($school_id);
        $this->data['total_student_absent'] = $this->dashboard->get_total_student_absent($school_id);
        $this->data['total_schools'] = $this->dashboard->get_total_schools($school_id);
        $this->data['total_male_students'] = $this->dashboard->get_total_male_students($school_id);
        $this->data['total_disabled_students'] = $this->dashboard->get_total_disabled_students($school_id);
        $this->data['total_female_students'] = $this->dashboard->get_total_female_students($school_id);
        $this->data['total_primary_schools'] = $this->dashboard->get_total_primary_schools($school_id);
        $this->data['total_secondary_schools'] = $this->dashboard->get_total_secondary_schools($school_id);
        $this->data['total_schools_central'] = $this->dashboard->get_total_schools_central($school_id);
        $this->data['total_schools_nakawa'] = $this->dashboard->get_total_schools_nakawa($school_id);
        $this->data['total_schools_makindye'] = $this->dashboard->get_total_schools_makindye($school_id);
        $this->data['total_schools_kawempe'] = $this->dashboard->get_total_schools_kawempe($school_id);
        $this->data['total_schools_rubaga'] = $this->dashboard->get_total_schools_rubaga($school_id);
        $this->data['total_schools_eastern'] = $this->dashboard->get_total_schools_eastern($school_id);
        $this->data['total_schools_northern'] = $this->dashboard->get_total_schools_northern($school_id);
        $this->data['total_schools_western'] = $this->dashboard->get_total_schools_western($school_id);
        $this->data['total_students_eastern'] = $this->dashboard->get_total_students_eastern($school_id);
        $this->data['total_students_central'] = $this->dashboard->get_total_students_central($school_id);
        $this->data['total_students_northern'] = $this->dashboard->get_total_students_northern($school_id);
        $this->data['total_students_western'] = $this->dashboard->get_total_students_western($school_id);
        $this->data['total_day_schools'] = $this->dashboard->get_total_day_schools($school_id);
        $this->data['total_public_schools'] = $this->dashboard->get_total_public_schools($school_id);
        $this->data['total_mixed_schools'] = $this->dashboard->get_total_mixed_schools($school_id);
        $this->data['total_boarding_schools'] = $this->dashboard->get_total_boarding_schools($school_id);
        $this->data['total_students_day'] = $this->dashboard->get_total_students_in_day_schools($school_id);
        $this->data['total_class_rooms'] = $this->dashboard->get_total_class_rooms($school_id);
        $this->data['total_school_toilets'] = $this->dashboard->get_total_school_toilets($school_id);
        $this->data['private_day_schools'] = $this->dashboard->get_total_private_day_schools($school_id);
        $this->data['private_day_students'] = $this->dashboard->get_total_private_day_students($school_id);
        $this->data['private_boarding_schools'] = $this->dashboard->get_total_private_boarding_schools($school_id);
        $this->data['private_boarding_students'] = $this->dashboard->get_total_private_boarding_students($school_id);
        $this->data['public_day_schools'] = $this->dashboard->get_total_public_day_schools($school_id);
        $this->data['public_day_students'] = $this->dashboard->get_total_public_day_students($school_id);
        $this->data['public_boarding_schools'] = $this->dashboard->get_total_public_boarding_schools($school_id);
        $this->data['public_boarding_students'] = $this->dashboard->get_total_public_boarding_students($school_id);
        $this->data['total_books'] = $this->dashboard->get_total_books($school_id);
        $this->data['total_private_schools'] = $this->dashboard->get_total_private_schools($school_id);
        $this->data['total_students_in_private_schools'] = $this->dashboard->get_total_students_in_private_schools($school_id);
        $this->data['total_students_nakawa'] = $this->dashboard->get_total_students_nakawa($school_id);
        $this->data['total_students_kawempe'] = $this->dashboard->get_total_students_kawempe($school_id);
        $this->data['total_students_rubaga'] = $this->dashboard->get_total_students_rubaga($school_id);
        $this->data['total_students_makindye'] = $this->dashboard->get_total_students_makindye($school_id);
        $this->data['total_primary_students'] = $this->dashboard->get_total_primary_students($school_id);
        $this->data['total_secondary_students'] = $this->dashboard->get_total_secondary_students($school_id);
                 
        $this->data['sents'] = $this->dashboard->get_message_list($type = 'sent');
        $this->data['drafts'] = $this->dashboard->get_message_list($type = 'draft');
        $this->data['trashs'] = $this->dashboard->get_message_list($type = 'trash');
        $this->data['inboxs'] = $this->dashboard->get_message_list($type = 'inbox');
        $this->data['new'] = $this->dashboard->get_message_list($type = 'new');

        $this->data['regular'] = $this->dashboard->get_student_status_type($type = 'regular');
        $this->data['drop_out'] = $this->dashboard->get_student_status_type($type = 'drop out');
        $this->data['transferred'] = $this->dashboard->get_student_status_type($type = 'transferred');
        $this->data['passed'] = $this->dashboard->get_student_status_type($type = 'passed');
        
        $this->data['school_setting'] = $this->school_setting;
        $this->data['schools'] = $this->schools;
        
        $stats = array();
        
        foreach($this->data['schools'] as $obj){
            
            $arr = array();
            
            $total_class = $this->dashboard->get_total_class($obj->id);
            $total_student = $this->dashboard->get_total_student($obj->id);
            $total_teacher = $this->dashboard->get_total_teacher($obj->id);
            $total_employee = $this->dashboard->get_total_employee($obj->id);
            $total_income = $this->dashboard->get_total_income($obj->id);
            $total_expenditure = $this->dashboard->get_total_expenditure($obj->id);
            $total_student_absent = $this->dashboard->get_total_student_absent($obj->id);
            $total_teacher_absent = $this->dashboard->get_total_teacher_absent($obj->id);
            $total_schools = $this->dashboard->get_total_schools($obj->id);
            $total_primary_schools = $this->dashboard->get_total_primary_schools($obj->id);
            $total_secondary_schools = $this->dashboard->get_total_secondary_schools($obj->id);
            $total_disabled_students = $this->dashboard->get_total_disabled_students($obj->id);
            $total_female_students = $this->dashboard->get_total_female_students($obj->id);
            $total_schools_central = $this->dashboard->get_total_schools_central($obj->id);
            $total_schools_nakawa = $this->dashboard->get_total_schools_nakawa($obj->id);
            $total_schools_nakawa = $this->dashboard->get_total_schools_makindye($obj->id);
            $total_schools_nakawa = $this->dashboard->get_total_schools_kawempe($obj->id);
            $total_schools_nakawa = $this->dashboard->get_total_schools_rubaga($obj->id);
            $total_schools_eastern = $this->dashboard->get_total_schools_eastern($obj->id);
            $total_schools_northern = $this->dashboard->get_total_schools_northern($obj->id);
            $total_schools_western = $this->dashboard->get_total_schools_western($obj->id);
            $total_students_eastern = $this->dashboard->get_total_students_eastern($obj->id);
            $total_students_central = $this->dashboard->get_total_students_central($obj->id);
            $total_students_northern = $this->dashboard->get_total_students_northern($obj->id);
            $total_students_western = $this->dashboard->get_total_students_western($obj->id);
            $total_day_schools = $this->dashboard->get_total_day_schools($obj->id);
            $total_public_schools = $this->dashboard->get_total_public_schools($obj->id);
            $total_mixed_schools = $this->dashboard->get_total_mixed_schools($obj->id);
            $total_boarding_schools = $this->dashboard->get_total_boarding_schools($obj->id);
            $total_students_day = $this->dashboard->get_total_students_in_day_schools($obj->id);
            $total_play_grounds = $this->dashboard->get_total_play_ground($obj->id);
            $total_class_rooms = $this->dashboard->get_total_class_rooms($obj->id);
            $total_class_room_blocks = $this->dashboard->get_total_class_room_blocks($obj->id);
            $total_school_toilets = $this->dashboard->get_total_school_toilets($obj->id);
            $private_day_schools = $this->dashboard->get_total_private_day_schools($obj->id);
            $private_day_students = $this->dashboard->get_total_private_day_students($obj->id);
            $private_boarding_schools = $this->dashboard->get_total_private_boarding_schools($obj->id);
            $private_boarding_students = $this->dashboard->get_total_private_boarding_students($obj->id);
            $public_day_schools = $this->dashboard->get_total_public_day_schools($obj->id);
            $public_day_students = $this->dashboard->get_total_public_day_students($obj->id);
            $public_boarding_schools = $this->dashboard->get_total_public_boarding_schools($obj->id);
            $public_boarding_students = $this->dashboard->get_total_public_boarding_students($obj->id);
            $total_books = $this->dashboard->get_total_books($obj->id);
            $total_private_schools = $this->dashboard->get_total_private_schools($obj->id);
            $total_students_in_private_schools = $this->dashboard->get_total_students_in_private_schools($obj->id);
            $total_students_nakawa = $this->dashboard->get_total_students_nakawa($obj->id);
            $total_students_kawempe = $this->dashboard->get_total_students_kawempe($obj->id);
            $total_students_rubaga = $this->dashboard->get_total_students_rubaga($obj->id);
            $total_students_makindye = $this->dashboard->get_total_students_makindye($obj->id);
            $total_students_primary = $this->dashboard->get_total_primary_students($obj->id);
            $total_students_secondary = $this->dashboard->get_total_secondary_students($obj->id);
            
            $arr[] = $total_schools > 0 ? $total_schools : 0;
            $arr[] = $total_class_rooms > 0 ? $total_class_rooms : 0;
            $arr[] = $total_class_room_blocks > 0 ? $total_class_room_blocks : 0;            
            $arr[] = $total_play_grounds > 0 ? $total_play_grounds : 0;
            $arr[] = $total_school_toilets > 0 ? $total_school_toilets : 0;
            $arr[] = $total_disabled_students > 0 ? $total_disabled_students : 0;
            $arr[] = $total_books > 0 ? $total_books : 0;
            /*$arr[] = $total_primary_schools > 0 ? $total_primary_schools : 0;
            $arr[] = $total_secondary_schools > 0 ? $total_secondary_schools : 0;            
            $arr[] = $total_female_students > 0 ? $total_female_students : 0;
            $arr[] = $total_employee > 0 ? $total_employee : 0;
            $arr[] = $total_income > 0 ? $total_income : 0;
            $arr[] = $total_expenditure > 0 ? $total_expenditure : 0;
            $arr[] = $total_student > 0 ? $total_student : 0;*/

            $stats[$obj->id] = $arr;
              
        } 
        
        $this->data['stats'] = $stats;
        
        $this->layout->title($this->lang->line('dashboard') . ' | ' . SMS);
        $this->layout->view('dashboard', $this->data);
        
    }
    
    
    public function get_search(){
        
        $school_id = $this->input->post('school_id');
        $keyword = $this->input->post('keyword');
        
        if(strlen($keyword) < 3){
          echo  $blank_str = '<div class="search-message-container">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="search-message" style="padding: 6px;font-weight: bold;">'.$this->lang->line('type_atleast_3_characters').'</div>
                    </div>
                    <div class="clearfix"></div>
                </div>';
            die();
        }
        
        
        $blank_str = '<div class="search-message-container">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="search-message" style="padding: 6px;font-weight: bold;">'.$this->lang->line('no_search_result_found').'</div>
                    </div>
                    <div class="clearfix"></div>
                </div>';
        
        
        $students = $this->dashboard->get_search_student($school_id, $keyword);
        $guardians = $this->dashboard->get_search_guardian($school_id, $keyword);
        $teachers = $this->dashboard->get_search_teacher($school_id, $keyword);
        $employees = $this->dashboard->get_search_employee($school_id, $keyword);
        
        $result_str = '';
            
        
        //===================   STUDENT ===========================================
        if(has_permission(VIEW, 'student', 'student')){
            
        if(!empty($students)){
            
           $result_str .= '<div class="col-md-12 col-sm-12 col-xs-12">
                                <div style="padding: 6px;font-weight: bold;background: #ecf7fb; margin-bottom: 5px;">'.$this->lang->line('student').'</div>
                            </div>
                            <div class="clearfix"></div>';
            
            foreach($students as $obj){
               $result_str .= '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                            <div class="well profile_view">
                              <div class="col-sm-12">
                                 <div class="left col-xs-3" style="padding: 0;">';
               
                                if($obj->photo != ''){
                        $result_str .= '<img src="'.UPLOAD_PATH.'student-photo/'.$obj->photo.'" alt="" class="img-circle img-responsive">';             
                                }else{
                        $result_str .= '<img src="'.IMG_URL.'default-user.png" alt="" class="img-circle img-responsive">'; 
                                }
                                  
                                
                        $result_str .= '</div>
                                <div class="right col-xs-9">
                                  <h3>'. substr($obj->name, 0, 22).'</h3>
                                  <hr/>
                                  <p><strong>'.$obj->session_year.'</strong></p>
                                  <ul class="list-unstyled_" style="padding-left:12px;">
                                        <li>'.$this->lang->line('class').' : '.$obj->class_name.', '.$this->lang->line('section').' : '.$obj->section.'</li>
                                        <li>'.$this->lang->line('roll_no').' : '.$obj->roll_no.'</li>
                                        <li>'.$this->lang->line('birth_date').' : '.date('M j, Y', strtotime($obj->dob)).'</li>
                                    </ul>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 bottom text-center">
                                  <a href="'.site_url('student/view/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> '.$this->lang->line('view_profile').'
                                  </a>                           
                              </div>
                            </div>
                          </div>'; 
            }
        }
                
        }
        //===================   GUARDIAN ===========================================
        if(has_permission(VIEW, 'guardian', 'guardian')){
            
        if(!empty($guardians)){
            
           $result_str .= '<div class="col-md-12 col-sm-12 col-xs-12">
                                <div style="padding: 6px;font-weight: bold;background: #ecf7fb; margin-bottom: 5px;">'.$this->lang->line('guardian').'</div>
                            </div>
                            <div class="clearfix"></div>';
            
            foreach($guardians as $obj){
               $result_str .= '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                            <div class="well profile_view">
                              <div class="col-sm-12">
                                 <div class="left col-xs-3" style="padding: 0;">';
               
                                if($obj->photo != ''){
                        $result_str .= '<img src="'.UPLOAD_PATH.'guardian-photo/'.$obj->photo.'" alt="" class="img-circle img-responsive">';             
                                }else{
                        $result_str .= '<img src="'.IMG_URL.'default-user.png" alt="" class="img-circle img-responsive">'; 
                                }
                                  
                                
                        $result_str .= '</div>
                                <div class="right col-xs-9">
                                  <h3>'. substr($obj->name, 0, 22).'</h3>
                                  <hr/>
                                  <p><strong>'.$obj->profession.'</strong></p>
                                  <ul class="list-unstyled">
                                    <li><i class="fa fa-phone"></i> '.$obj->phone.'</li>
                                    <li><i class="fa fa-envelope"></i> '.$obj->email.'</li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 bottom text-center">
                                  <a href="'.site_url('guardian/view/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i>  '.$this->lang->line('view_profile').'
                                  </a>                           
                              </div>
                            </div>
                          </div>'; 
            }
        }
        
        }        
        
        //===================   TEACHER ===========================================
        if(has_permission(VIEW, 'teacher', 'teacher')){
            
        if(!empty($teachers)){
            
           $result_str .= '<div class="col-md-12 col-sm-12 col-xs-12">
                                <div style="padding: 6px;font-weight: bold;background: #ecf7fb; margin-bottom: 5px;">'.$this->lang->line('teacher').'</div>
                            </div>
                            <div class="clearfix"></div>';
            
            foreach($teachers as $obj){
               $result_str .= '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                            <div class="well profile_view">
                              <div class="col-sm-12">
                                <div class="left col-xs-3" style="padding: 0;">';
                                if($obj->photo != ''){
                        $result_str .= '<img src="'.UPLOAD_PATH.'teacher-photo/'.$obj->photo.'" alt="" class="img-circle img-responsive">';             
                                }else{
                        $result_str .= '<img src="'.IMG_URL.'default-user.png" alt="" class="img-circle img-responsive">'; 
                                }
                                  
                                
                    $result_str .= '</div>
                                <div class="right col-xs-9">
                                  <h3>'.$obj->name.'</h3>
                                  <hr/>
                                  <p><strong>'.$obj->responsibility.'</strong></p>
                                  <ul class="list-unstyled">
                                    <li><i class="fa fa-phone"></i> '.$obj->phone.'</li>
                                    <li><i class="fa fa-envelope"></i> '.$obj->email.'</li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 bottom text-center">
                                  <a href="'.site_url('teacher/view/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> '.$this->lang->line('view_profile').'
                                  </a>                           
                              </div>
                            </div>
                          </div>'; 
            }
        }
        
        }        
        
        //===================   EMPLOYEE ===========================================
        if(has_permission(VIEW, 'hrm', 'employee')){
            
        if(!empty($employees)){
            
           $result_str .= '<div class="col-md-12 col-sm-12 col-xs-12">
                                <div style="padding: 6px;font-weight: bold;background: #ecf7fb; margin-bottom: 5px;">'.$this->lang->line('employee').'</div>
                            </div>
                            <div class="clearfix"></div>';
            
            foreach($employees as $obj){
               $result_str .= '<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                            <div class="well profile_view">
                              <div class="col-sm-12">
                                <div class="left col-xs-3" style="padding: 0;">';
                                if($obj->photo != ''){
                        $result_str .= '<img src="'.UPLOAD_PATH.'employee-photo/'.$obj->photo.'" alt="" class="img-circle img-responsive">';             
                                }else{
                        $result_str .= '<img src="'.IMG_URL.'default-user.png" alt="" class="img-circle img-responsive">'; 
                                }
                                  
                                
                    $result_str .= '</div>
                                <div class="right col-xs-9">
                                  <h3>'.$obj->name.'</h3>
                                  <hr/>
                                  <p><strong>'.$obj->designation.'</strong></p>
                                  <ul class="list-unstyled">
                                    <li><i class="fa fa-phone"></i> '.$obj->phone.'</li>
                                    <li><i class="fa fa-envelope"></i> '.$obj->email.'</li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 bottom text-center">
                                  <a href="'.site_url('hrm/employee/view/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i>  '.$this->lang->line('view_profile').'
                                  </a>                           
                              </div>
                            </div>
                          </div>'; 
            }
        }
        
        }       
        
        $count_str = '<div class="search-message-container">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="search-message" style="padding: 6px;font-weight: bold;"> '.(count($students)+ count($guardians)+count($teachers)+count($employees)).' '.$this->lang->line('search_result_found').'.</div>
                    </div>
                    <div class="clearfix"></div>
                </div>';
        
        
        if($result_str){            
           echo $count_str.$result_str;
            
        }else{
           echo $blank_str;
        }
       
    }
   
}
