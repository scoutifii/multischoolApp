<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_Model extends MY_Model {

    function __construct() {
        parent::__construct();
  
    }

    public function get_message_list($type) {

        $this->db->select('MR.*, M.*');
        $this->db->from('message_relationships AS MR');
        $this->db->join('messages AS M', 'M.id = MR.message_id', 'left');

        if ($type == 'draft') {
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_draft', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.sender_id', logged_in_user_id());
        }
        if ($type == 'inbox') {
            $this->db->where('MR.status', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.receiver_id', logged_in_user_id());
        }
        if ($type == 'new') {
            $this->db->where('MR.status', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
            $this->db->where('MR.is_read', 0);
            $this->db->where('MR.receiver_id', logged_in_user_id());
        }
        if ($type == 'trash') {
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_trash', 1);
            $this->db->where('MR.owner_id', logged_in_user_id());
        }
        if ($type == 'sent') {
            $this->db->where('MR.status', 1);
            $this->db->where('MR.is_draft', 0);
            $this->db->where('MR.is_trash', 0);
            $this->db->where('MR.sender_id', logged_in_user_id());
            $this->db->where('MR.owner_id', logged_in_user_id());
        }

        return $this->db->get()->result();
    }

    public function get_student_status_type($type){
        $this->db->select('ST.*, S.*');
        $this->db->from('students AS ST');
        $this->db->join('schools AS S', 'S.id = ST.school_id', 'left');

        if ($type == 'regular') {
            $this->db->where('ST.status_type', 'regular');
            $this->db->where('ST.status', 1);
        }
        if ($type == 'drop out') {
            $this->db->where('ST.status_type', 'drop_out');
            $this->db->where('ST.status', 1);
        }
        if ($type == 'transferred') {
            $this->db->where('ST.status_type', 'transferred');
            $this->db->where('ST.status', 1);
        }
        if ($type == 'passed') {
            $this->db->where('ST.status_type', 'passed');
            $this->db->where('ST.status', 1);
        }
        
        return $this->db->get()->result();
    }

    public function get_user_by_role($school_id = null) {

        $this->db->select('COUNT(U.role_id) AS total_user, R.name, U.username');
        $this->db->from('users AS U');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->group_by('U.role_id');
        $this->db->where('U.status', 1);
        if ($school_id) {
            $this->db->where('U.school_id', $school_id);
        }
        return $this->db->get()->result();
    }

    public function get_school_by_district($school_id = null) {

        $this->db->select('S.school_name, D.district_name');
        $this->db->from('schools AS S');
        $this->db->join('district AS D', 'D.id = S.district_id', 'left');
        $this->db->group_by('S.district_id');
        $this->db->where('S.status', 1);
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->result();
    }

    /*public function get_active_user_logins($school_id = null,) {
        $time=gmdate('Y-m-d', time()-(24*60*60));
        $this->db->select('COUNT(U.role_id) AS total_user, U.username, R.name');
        $this->db->from('users AS U');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->where('U.last_logged_in', $time);
        $this->db->where('U.status', 1);
        
        if ($school_id) {
            $this->db->where('U.school_id', $school_id);
        }
        return $this->db->get()->result();
    }*/

    public function get_student_by_class($school_id = null) {

        $this->db->select('COUNT(E.student_id) AS total_student, C.name AS class_name, S.school_name');
        $this->db->from('enrollments AS E');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
        $this->db->join('students AS ST', 'ST.id = E.student_id', 'left');
        $this->db->group_by('E.class_id');
        $this->db->where('E.status', 1);
        $this->db->where('ST.status_type', 'regular');
        if ($school_id) {
            $this->db->where('E.school_id', $school_id);
        }
        return $this->db->get()->result();
    }

    public function get_total_student($school_id = null) {

        if ($this->session->userdata('role_id') == STUDENT) {
            
            $class_id = $this->session->userdata('class_id');
            $school = $this->get_single('schools', array('id' => $school_id));
            
            $this->db->select('COUNT(E.id) AS total_student');
            $this->db->from('enrollments AS E');
            if ($school_id) {
                $this->db->where('E.school_id', $school_id);
            }
            if ($class_id) {
                $this->db->where('E.class_id', $class_id);
            }
            if ($school) {
                $this->db->where('E.academic_year_id', $school->academic_year_id);
            }
            

        }else if ($this->session->userdata('role_id') == GUARDIAN) {
            
            $this->db->select('COUNT(S.id) AS total_student');
            $this->db->from('students AS S');
            $this->db->where('S.status', 1);
            if ($school_id) {
                $this->db->where('S.school_id', $school_id);
            }
            $this->db->where('S.guardian_id',  $this->session->userdata('profile_id'));
          
            
        } else {            
          
            $this->db->select('COUNT(S.id) AS total_student');
            $this->db->from('students AS S');
            $this->db->where('S.status', 1);
            if ($school_id) {
                $this->db->where('S.school_id', $school_id);
            }
        }

        return $this->db->get()->row()->total_student;
    }

    public function get_total_guardian($school_id = null) {

        if ($this->session->userdata('role_id') == STUDENT) {

            $profile_id = $this->session->userdata('profile_id');
            $student = $this->get_single('students', array('id' => $profile_id));

            $this->db->select('COUNT(G.id) AS total_guardian');
            $this->db->from('guardians AS G');
            $this->db->where('G.id', $student->guardian_id);
           
        } else {

            $this->db->select('COUNT(G.id) AS total_guardian');
            $this->db->from('guardians AS G');
        }

         $this->db->where('G.status', 1);
        if ($school_id) {
            $this->db->where('G.school_id', $school_id);
        }
        return $this->db->get()->row()->total_guardian;
    }

    public function get_total_class($school_id = null) {

        $this->db->select('COUNT(C.id) AS total_class');
        $this->db->from('classes AS C');
        $this->db->where('C.status', 1);
        if ($school_id) {
            $this->db->where('C.school_id', $school_id);
        }
        return $this->db->get()->row()->total_class;
    }

    public function get_total_teacher($school_id = null) {

        $this->db->select('COUNT(T.id) AS total_teacher');
        $this->db->from('teachers AS T');
        $this->db->where('T.status', 1);
        if ($school_id) {
            $this->db->where('T.school_id', $school_id);
        }
        return $this->db->get()->row()->total_teacher;
    }

    public function get_total_employee($school_id = null) {

        $this->db->select('COUNT(E.id) AS total_employee');
        $this->db->from('employees AS E');
        $this->db->where('E.status', 1);
        if ($school_id) {
            $this->db->where('E.school_id', $school_id);
        }
        return $this->db->get()->row()->total_employee;
    }

    public function get_total_expenditure($school_id = null) {

        $this->db->select('SUM(E.amount) AS total_expenditure');
        $this->db->from('expenditures AS E');
        if ($school_id) {
            $this->db->where('E.school_id', $school_id);
        }
        return $this->db->get()->row()->total_expenditure;
    }

    public function get_total_income($school_id = null) {
             
        $this->db->select('SUM(T.amount) AS total_income');
        $this->db->from('transactions AS T');

        if ($school_id) {
            $this->db->where('T.school_id', $school_id);
        }
        return $this->db->get()->row()->total_income;
    }
    
    public function get_total_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS total_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.status', 1);
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->total_schools;
    }

    public function get_total_boarding_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS total_boarding_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'boarding school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->total_boarding_schools;
    }

    public function get_total_mixed_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS total_mixed_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.form_of_school', 'mixed school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->total_mixed_schools;
    }

    public function get_total_day_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS total_day_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'day school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->total_day_schools;
    }

     public function get_total_public_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS total_public_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.category_of_school', 'government aided');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->total_public_schools;
    }

    public function get_total_private_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS private_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.category_of_school', 'private school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->private_schools;
    }

    public function get_total_single_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS single');
        $this->db->from('schools AS S');
        $this->db->where('S.form_of_school', 'single_school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->single;
    }

    public function get_total_private_day_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS private_day_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'day school');
        $this->db->where('S.category_of_school', 'private school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->private_day_schools;
    }

    public function get_total_private_day_students($school_id = null) {

        $this->db->select('COUNT(ST.id) AS private_day_students');
        $this->db->from('schools AS S');
        $this->db->join('students AS ST', 'S.id=ST.school_id', 'left');
        $this->db->where('S.school_nature', 'day school');
        $this->db->where('S.category_of_school', 'private school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->private_day_students;
    }

    public function get_total_private_boarding_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS private_boarding_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'boarding school');
        $this->db->where('S.category_of_school', 'private school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->private_boarding_schools;
    }

    public function get_total_private_boarding_students($school_id = null) {

        $this->db->select('COUNT(ST.id) AS private_boarding_students');
        $this->db->from('schools AS S');
        $this->db->join('students AS ST', 'S.id=ST.school_id', 'left');
        $this->db->where('S.school_nature', 'boarding school');
        $this->db->where('S.category_of_school', 'private school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->private_boarding_students;
    }

    public function get_total_public_day_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS public_day_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'day school');
        $this->db->where('S.category_of_school', 'government aided');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->public_day_schools;
    }

    public function get_total_public_day_students($school_id = null) {

        $this->db->select('COUNT(ST.id) AS public_day_students');
        $this->db->from('schools AS S');
        $this->db->join('students AS ST', 'S.id=ST.school_id', 'left');
        $this->db->where('S.school_nature', 'day school');
        $this->db->where('S.category_of_school', 'government aided');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->public_day_students;
    }

    public function get_total_public_boarding_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS public_boarding_schools');
        $this->db->from('schools AS S');
        $this->db->where('S.school_nature', 'boarding school');
        $this->db->where('S.category_of_school', 'government aided');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->public_boarding_schools;
    }

    public function get_total_public_boarding_students($school_id = null) {

        $this->db->select('COUNT(ST.id) AS public_boarding_students');
        $this->db->from('schools AS S');
        $this->db->join('students AS ST', 'S.id=ST.school_id', 'left');
        $this->db->where('S.school_nature', 'boarding school');
        $this->db->where('S.category_of_school', 'government aided');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->public_boarding_students;
    }

    public function get_total_nursery_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS nursery');
        $this->db->from('schools AS S');
        $this->db->where('S.type_of_school', 'nursery school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->nursery;
    }

    public function get_total_primary_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS primaryschool');
        $this->db->from('schools AS S');
        $this->db->where('S.type_of_school', 'primary school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->primaryschool;
    }

    public function get_total_secondary_schools($school_id = null) {

        $this->db->select('COUNT(S.id) AS secondary');
        $this->db->from('schools AS S');
        $this->db->where('S.type_of_school', 'secondary school');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->row()->secondary;
    }

     public function get_total_teacher_absent($school_id = null) {
        $sql = "SELECT COUNT(TA.id) AS total_teacher_absent FROM teacher_attendances AS TA WHERE 
                TA.`day_1`='A' OR TA.`day_2`='A' OR TA.`day_3`='A' OR TA.`day_4`='A' OR TA.`day_5`='A'
                OR TA.`day_6`='A' OR TA.`day_7`='A' OR TA.`day_8`='A' OR TA.`day_9`='A' OR TA.`day_10`='A'
                OR TA.`day_11`='A' OR TA.`day_12`='A' OR TA.`day_13`='A' OR TA.`day_14`='A' OR TA.`day_15`='A'
                OR TA.`day_16`='A' OR TA.`day_17`='A' OR TA.`day_18`='A' OR TA.`day_19`='A' OR TA.`day_19`='A'
                OR TA.`day_20`='A' OR TA.`day_21`='A' OR TA.`day_22`='A' OR TA.`day_23`='A' OR TA.`day_24`='A'
                OR TA.`day_25`='A' OR TA.`day_26`='A' OR TA.`day_27`='A' OR TA.`day_28`='A' OR TA.`day_29`='A'
                OR TA.`day_30`='A' OR TA.`day_31`='A' AND TA.`school_id`=$school_id";
      
        return $this->db->query($sql)->row()->total_teacher_absent;
    }

    public function get_total_student_absent($school_id = null) {
        $this->db->select('COUNT(SA.id) AS total_student_absent');
        $this->db->from('student_attendances AS SA');
        $this->db->join('schools AS S', 'SA.school_id=S.id', 'left');
        $this->db->where('SA.day_1', 'A');
        $this->db->or_where('SA.day_2', 'A');
        $this->db->or_where('SA.day_3', 'A');
        $this->db->or_where('SA.day_4', 'A');
        $this->db->or_where('SA.day_5', 'A');
        $this->db->or_where('SA.day_6', 'A');
        $this->db->or_where('SA.day_7', 'A');
        $this->db->or_where('SA.day_8', 'A');
        $this->db->or_where('SA.day_9', 'A');
        $this->db->or_where('SA.day_10', 'A');
        $this->db->or_where('SA.day_11', 'A');
        $this->db->or_where('SA.day_12', 'A');
        $this->db->or_where('SA.day_13', 'A');
        $this->db->or_where('SA.day_13', 'A');
        $this->db->or_where('SA.day_14', 'A');
        $this->db->or_where('SA.day_15', 'A');
        $this->db->or_where('SA.day_16', 'A');
        $this->db->or_where('SA.day_17', 'A');
        $this->db->or_where('SA.day_18', 'A');
        $this->db->or_where('SA.day_19', 'A');
        $this->db->or_where('SA.day_20', 'A');
        $this->db->or_where('SA.day_21', 'A');
        $this->db->or_where('SA.day_22', 'A');
        $this->db->or_where('SA.day_23', 'A');
        $this->db->or_where('SA.day_24', 'A');
        $this->db->or_where('SA.day_25', 'A');
        $this->db->or_where('SA.day_26', 'A');
        $this->db->or_where('SA.day_27', 'A');
        $this->db->or_where('SA.day_28', 'A');
        $this->db->or_where('SA.day_29', 'A');
        $this->db->or_where('SA.day_30', 'A');
        $this->db->or_where('SA.day_31', 'A');

        if ($school_id) {
            $this->db->where('SA.school_id', $school_id);
        }
        //$this->db->group_by('SA.created_at');
        return $this->db->get()->row()->total_student_absent;
    }

    public function get_lat_lng($school_id = null) {
        $this->db->select('school_name, school_lat, school_lng');
        $this->db->from('schools AS S');
        if ($school_id) {
            $this->db->where('S.id', $school_id);
        }
        return $this->db->get()->result();
    }

    public function get_total_disabled_students($school_id = null) {
        $this->db->select('COUNT(ST.`id`) AS disabled_students');
        $this->db->from('students AS ST');
        $this->db->where('ST.child_with_disabilities', 'YES');
        if ($school_id) {
            $this->db->where('ST.school_id', $school_id);
        }
        return $this->db->get()->row()->disabled_students;
    }

    public function get_total_nursery_pupils($school_id = null) {
        $sql = "SELECT COUNT(S.`id`) AS total_nursery_pupils 
                FROM students AS S 
                LEFT JOIN schools AS SC ON SC.`id`=S.`school_id` 
                WHERE S.`type_of_school`='nursery school'";
        
        return $this->db->query($sql)->row()->total_nursery_pupils;
    }

    public function get_total_primary_students($school_id = null) {
        $sql = "SELECT COUNT(S.`id`) AS total_primary_students 
                FROM students AS S 
                LEFT JOIN schools AS SC ON SC.`id`=S.`school_id` 
                WHERE SC.`type_of_school`='primary school'";

        return $this->db->query($sql)->row()->total_primary_students;
    }

    public function get_total_secondary_students($school_id = null) {
        $this->db->select('COUNT(S.`id`) AS total_secondary_students');
        $this->db->from('students AS S');
        $this->db->join('schools AS SC', 'S.school_id=SC.id', 'left');
        $this->db->where('SC.type_of_school', 'secondary school');
        if ($school_id) {
            $this->db->where('S.school_id', $school_id);
        }
        return $this->db->get()->row()->total_secondary_students;
    }

    public function get_total_tertairy_students($school_id = null) {
         $sql = "SELECT COUNT(S.`id`) AS total_tertairy_students 
                 FROM students AS S 
                 LEFT JOIN schools AS SC ON SC.`id`=S.`school_id` 
                 WHERE SC.`type_of_school`='tertairy'";

        return $this->db->query($sql)->row()->total_tertairy_students;
    }

    public function get_total_students_in_day_schools($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_day');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->where('SC.school_nature', 'day school');
        if ($school_id) {
            $this->db->where('ST.school_id', $school_id);
        }
        return $this->db->get()->row()->total_students_day;
    }

    public function get_total_students_in_boarding_schools($school_id = null) {
         $sql = "SELECT COUNT(S.`id`) AS total_students_in_boarding_schools 
                 FROM students AS S
                 LEFT JOIN schools AS SC ON SC.`id`=S.`school_id` 
                 WHERE S.`school_nature`='boarding' AND S.`school_id`=$school_id";

        return $this->db->query($sql)->row()->total_students_in_boarding_schools;
    }

    public function get_total_students_in_day_and_boarding_schools($school_id = null) {
         $sql = "SELECT COUNT(students.`id`) AS total_students_in_day_and_boarding_schools 
                 FROM students 
                 LEFT JOIN schools ON schools.`id`=students.`school_id` 
                 WHERE schools.`school_nature`='day_and_boarding'";

        return $this->db->query($sql)->row()->total_students_in_day_and_boarding_schools;
    }

    public function get_total_students_in_public_schools($school_id = null) {
         $sql = "SELECT COUNT(students.`id`) AS total_students_in_public_schools 
                 FROM students 
                 LEFT JOIN schools ON schools.`id`=students.`school_id` 
                 WHERE schools.`category_of_school`='government_aided'";

        return $this->db->query($sql)->row()->total_students_in_public_schools;
    }

    public function get_total_students_in_private_schools($school_id = null) {
         $sql = "SELECT COUNT(S.`id`) AS total_students_in_private_schools 
                 FROM students AS S
                 LEFT JOIN schools AS SC ON SC.`id`=S.`school_id` 
                 WHERE SC.`category_of_school`='private school'";

        return $this->db->query($sql)->row()->total_students_in_private_schools;
    }

    public function get_total_students_in_mixed_schools($school_id = null) {
         $sql = "SELECT COUNT(students.`id`) AS total_students_in_mixed_schools 
                 FROM students 
                 LEFT JOIN schools ON schools.`id`=students.`school_id` 
                 WHERE schools.`form_of_school`='mixed_school'";

        return $this->db->query($sql)->row()->total_students_in_mixed_schools;
    }

    public function get_total_students_in_single_schools($school_id = null) {
         $sql = "SELECT COUNT(students.`id`) AS total_students_in_single_schools 
                 FROM students 
                 LEFT JOIN schools ON schools.`id`=students.`school_id` 
                 WHERE schools.`form_of_school`='single_school'";

        return $this->db->query($sql)->row()->total_students_in_single_schools;
    }

    public function get_total_male_students($school_id = null) {
        $this->db->select('COUNT(S.id) AS total_male_students');
        $this->db->from('students AS S');
        $this->db->where('S.gender', 'male');
        if ($school_id) {
            $this->db->where('S.school_id', $school_id);
        }
        return $this->db->get()->row()->total_male_students;
    }

    public function get_total_female_students($school_id = null) {
        $this->db->select('COUNT(S.id) AS total_female_students');
        $this->db->from('students AS S');
        $this->db->where('S.gender', 'female');
        if ($school_id) {
            $this->db->where('S.school_id', $school_id);
        }
        return $this->db->get()->row()->total_female_students;
    }

    public function get_total_schools_nakawa($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_nakawa');
        $this->db->from('schools AS SC');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'NAKAWA');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_nakawa;
    }

    public function get_total_schools_makindye($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_makindye');
        $this->db->from('schools AS SC');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'MAKINDYE');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_MAKINDYE;
    }

    public function get_total_schools_kawempe($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_kawempe');
        $this->db->from('schools AS SC');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'KAWEMPE');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_kawempe;
    }

    public function get_total_schools_rubaga($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_rubaga');
        $this->db->from('schools AS SC');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'RUBAGA');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_rubaga;
    }

    public function get_total_schools_eastern($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_eastern');
        $this->db->from('schools AS SC');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'EASTERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_eastern;
    }

    public function get_total_students_eastern($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_eastern');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'EASTERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_eastern;
    }

    public function get_total_schools_central($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_central');
        $this->db->from('schools AS SC');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'CENTRAL');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_central;
    }


    public function get_total_students_central($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_central');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'CENTRAL');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_central;
    }

    public function get_total_students_nakawa($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_nakawa');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'NAKAWA');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_nakawa;
    }

    public function get_total_students_kawempe($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_kawempe');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'KAWEMPE');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_kawempe;
    }

    public function get_total_students_rubaga($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_rubaga');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'RUBAGA');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_rubaga;
    }

    public function get_total_students_makindye($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_makindye');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('subcounty AS SB', 'SB.id=SC.sub_county_id', 'left');
        $this->db->where('SB.sub_county_name', 'MAKINDYE');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_makindye;
    }
    public function get_total_schools_northern($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_northern');
        $this->db->from('schools AS SC');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'NORTHERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_northern;
    }

    public function get_total_students_northern($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_northern');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'NORTHERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_northern;
    }


    public function get_total_schools_western($school_id = null) {
        $this->db->select('COUNT(SC.id) AS total_schools_western');
        $this->db->from('schools AS SC');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'WESTERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_schools_western;
    }


    public function get_total_students_western($school_id = null) {
        $this->db->select('COUNT(ST.id) AS total_students_western');
        $this->db->from('students AS ST');
        $this->db->join('schools AS SC', 'ST.school_id=SC.id', 'left');
        $this->db->join('regions AS R', 'R.id=SC.region_id', 'left');
        $this->db->where('R.region_name', 'WESTERN REGION');
        if ($school_id) {
            $this->db->where('SC.id', $school_id);
        }
        return $this->db->get()->row()->total_students_western;
    }

    public function get_total_play_ground($school_id = null) {
        $this->db->select('SUM(SF.facility_no) AS total_play_grounds');
        $this->db->from('school_facilities AS SF');
        $this->db->join('facility_categories AS FC', 'FC.id=SF.category_id', 'left');
        $this->db->where('FC.category_name', 'pitches');
        if ($school_id) {
            $this->db->where('SF.school_id', $school_id);
        }
        return $this->db->get()->row()->total_play_grounds;
    }

    public function get_total_class_rooms($school_id = null) {
        $this->db->select('SUM(SF.facility_no) AS total_class_rooms');
        $this->db->from('school_facilities AS SF');
        $this->db->join('facility_categories AS FC', 'FC.id=SF.category_id', 'left');
        $this->db->where('FC.category_name', 'class room');
        if ($school_id) {
            $this->db->where('SF.school_id', $school_id);
        }
        return $this->db->get()->row()->total_class_rooms;
    }

    public function get_total_class_room_blocks($school_id = null) {
        $this->db->select('SUM(SF.facility_no) AS total_class_room_blocks');
        $this->db->from('school_facilities AS SF');
        $this->db->join('facility_categories AS FC', 'FC.id=SF.category_id', 'left');
        $this->db->where('FC.category_name', 'class room blocks');
        if ($school_id) {
            $this->db->where('SF.school_id', $school_id);
        }
        return $this->db->get()->row()->total_class_room_blocks;
    }

    public function get_total_school_toilets($school_id = null) {
        $this->db->select('SUM(SF.facility_no) AS total_school_toilets');
        $this->db->from('school_facilities AS SF');
        $this->db->join('facility_categories AS FC', 'FC.id=SF.category_id', 'left');
        $this->db->where('FC.category_name', 'toilets');
        if ($school_id) {
            $this->db->where('SF.school_id', $school_id);
        }
        return $this->db->get()->row()->total_school_toilets;
    }

    public function get_total_books($school_id = null) {
        $this->db->select('COUNT(B.id) AS total_books');
        $this->db->from('books AS B');
        $this->db->where('B.status', 1);
        if ($school_id) {
            $this->db->where('B.school_id', $school_id);
        }
        return $this->db->get()->row()->total_books;
    }

    
    public function get_search_student($school_id, $keyword){
        
        $school = $this->get_school_by_id($school_id);
      
        if(empty($school)){
            return;
        }        
        $this->db->select('S.id, S.name, S.photo, S.dob, E.roll_no, C.name AS class_name, SE.name AS section, AY.session_year');
        $this->db->from('enrollments AS E');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        
        if ($school_id) {
            $this->db->where('E.school_id', $school_id);
        }
        
        $this->db->where('E.academic_year_id', $school->academic_year_id);
        
        $this->db->like('S.name', $keyword);
        $this->db->or_like('S.email', $keyword, 'after');
        $this->db->or_like('S.phone', $keyword, 'after');
        $this->db->or_like('S.present_address', $keyword, 'after');
        $this->db->or_like('S.permanent_address', $keyword, 'after');
        $this->db->or_like('C.name', $keyword, 'after');
        $this->db->or_like('SE.name', $keyword, 'after');
        
       return $this->db->get()->result();
        
    }
    
    public function get_search_guardian($school_id, $keyword){
        
        $this->db->select('G.*');
        $this->db->from('guardians AS G');
        $this->db->where('G.status', 1);
        if ($school_id) {
            $this->db->where('G.school_id', $school_id);
        }
        
        $this->db->like('G.name', $keyword);
        $this->db->or_like('G.email', $keyword, 'after');
        $this->db->or_like('G.phone', $keyword, 'after');
        $this->db->or_like('G.profession', $keyword, 'after');
        $this->db->or_like('G.present_address', $keyword, 'after');
        $this->db->or_like('G.permanent_address', $keyword, 'after');
        
       return $this->db->get()->result();
       
    }
    
    public function get_search_teacher($school_id, $keyword){
        
        $this->db->select('T.*');
        $this->db->from('teachers AS T');
        $this->db->where('T.status', 1);
        if ($school_id) {
            $this->db->where('T.school_id', $school_id);
        }
        
        $this->db->like('T.name', $keyword);
        $this->db->or_like('T.email', $keyword, 'after');
        $this->db->or_like('T.phone', $keyword, 'after');
        $this->db->or_like('T.responsibility', $keyword);
        $this->db->or_like('T.present_address', $keyword, 'after');
        $this->db->or_like('T.permanent_address', $keyword, 'after');
        
       return $this->db->get()->result();
       
    }
    
    public function get_search_employee($school_id, $keyword){
     
        $this->db->select('E.*, D.name AS designation');
        $this->db->from('employees AS E');
        $this->db->join('designations AS D', 'D.id = E.designation_id', 'left');
        
        $this->db->where('E.status', 1);
        if ($school_id) {
            $this->db->where('E.school_id', $school_id);
        }
        
        $this->db->like('E.name', $keyword);
        $this->db->or_like('D.name', $keyword);
        $this->db->or_like('E.email', $keyword, 'after');
        $this->db->or_like('E.phone', $keyword, 'after');
        $this->db->or_like('E.present_address', $keyword, 'after');
        $this->db->or_like('E.permanent_address', $keyword, 'after');
        
       return $this->db->get()->result();
    }
}