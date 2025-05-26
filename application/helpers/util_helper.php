<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('_d')) {

    function _d($data, $exit = TRUE) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($exit)
            exit;
    }
}

if (!function_exists('logged_in_user_id')) {

    function logged_in_user_id() {
        $logged_in_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('id') && $CI->session->userdata('role_id')):
            $logged_in_id = $CI->session->userdata('id');
        endif;
        return $logged_in_id;
    }

}

if (!function_exists('logged_in_role_id')) {

    function logged_in_role_id() {
        $logged_in_role_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('role_id')):
            $logged_in_role_id = $CI->session->userdata('role_id');
        endif;
        return $logged_in_role_id;
    }

}

if (!function_exists('logged_in_user_type')) {

    function logged_in_user_type() {
        $logged_in_type = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('user_type')):
            $logged_in_id = $CI->session->userdata('user_type');
        endif;
        return $logged_in_type;
    }

}

if (!function_exists('success')) {

    function success($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('success', $message);
        return true;
    }
}

if (!function_exists('error')) {

    function error($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('error', $message);
        return true;
    }

}

if (!function_exists('warning')) {

    function warning($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('warning', $message);
        return true;
    }

}

if (!function_exists('info')) {

    function info($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('info', $message);
        return true;
    }

}

if (!function_exists('get_slug')) {

    function get_slug($slug) {
        if (!$slug) {
            return;
        }

        $char = array("!", "â€™", "'", ":", ",", "_", "`", "~", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "=", "{", "}", "[", "]", "/", ";", '"', '<', '>', '?', "'\'",);
        $slug = str_replace($char, "", $slug);
        return $str = strtolower(str_replace(' ', "-", $slug));
    }

}

if (!function_exists('get_status')) {

    function get_status($status) {
        $ci = & get_instance();
        if ($status == 1) {
            return $ci->lang->line('active');
        } elseif ($status == 2) {
            return $ci->lang->line('in_active');
        } elseif ($status == 3) {
            return $ci->lang->line('trash');
        }
    }

}


if (!function_exists('verify_email_format')) {

    function verify_email_format($email) {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '';
        } else {
            return $email;
        }
    }

}


if (!function_exists('get_classes')) {

    function get_classes($school_id = null) {
        $ci = & get_instance();
        $ci->db->select('C.*');
        $ci->db->from('classes AS C');
        if($school_id){
            $ci->db->where('C.school_id', $school_id);
        }
         return $ci->db->get()->result();
    }

}

if (!function_exists('get_vehicles')) {

    function get_vehicle_by_ids($ids) {
        $str = '';
        if ($ids) {
            $ci = & get_instance();
            $sql = "SELECT * FROM `vehicles` WHERE `id` IN($ids)";
            $result = $ci->db->query($sql)->result();
            if (!empty($result)) {
                foreach ($result as $obj) {
                    $str .= $obj->number . ',';
                }
            }
        }
        return rtrim($str, ',');
    }

}

if (!function_exists('get_routines_by_day')) {

    function get_routines_by_day($day, $class_id = null, $section_id =null) {
        $ci = & get_instance();
        
        $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
        $ci->db->from('routines AS R');
        $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
        $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
        $ci->db->where('R.day', $day);
               
        if(logged_in_role_id() == TEACHER){
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id'));
        }else{
            $ci->db->where('R.class_id', $class_id);
            $ci->db->where('R.section_id', $section_id);
        }
        
        $ci->db->order_by("R.id", "ASC");
       return $ci->db->get()->result();
       
        
    }

}

if (!function_exists('get_student_attendance')) {

    function get_student_attendance($student_id, $school_id, $academic_year_id, $class_id, $section_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('SA.' . $field);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.class_id', $class_id);
        
        if($section_id){
            $ci->db->where('SA.section_id', $section_id);
        }
        
        $ci->db->where('SA.year', $year);
        $ci->db->where('SA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_teacher_attendance')) {

    function get_teacher_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('TA.' . $field);
        $ci->db->from('teacher_attendances AS TA');
        $ci->db->where('TA.teacher_id', $teacher_id);
        $ci->db->where('TA.school_id', $school_id);
        $ci->db->where('TA.academic_year_id', $academic_year_id);
        $ci->db->where('TA.year', $year);
        $ci->db->where('TA.month', $month);
       return @$ci->db->get()->row()->$field;
      // echo $ci->db->last_query();
    }

}

if (!function_exists('get_employee_attendance')) {

    function get_employee_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('EA.' . $field);
        $ci->db->from('employee_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.employee_id', $teacher_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.year', $year);
        $ci->db->where('EA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_exam_attendance')) {

    function get_exam_attendance($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('EA.is_attend');
        $ci->db->from('exam_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        //$ci->db->where('EA.term_id', $term_id);
        $ci->db->where('EA.exam_id', $exam_id);
        $ci->db->where('EA.class_id', $class_id);
        if($section_id){
            $ci->db->where('EA.section_id', $section_id);
        }
        $ci->db->where('EA.student_id', $student_id);
        $ci->db->where('EA.subject_id', $subject_id);
        return @$ci->db->get()->row()->is_attend;
        
    }

}

if (!function_exists('get_exam_mark')) {

    function get_exam_mark($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('M.*');
        $ci->db->from('marks AS M');
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.subject_id', $subject_id);
        return $ci->db->get()->row();
    }

}



if (!function_exists('get_exam_total_mark')) {

    function get_exam_total_mark($school_id, $exam_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        
        $ci = & get_instance();
        $ci->db->select('COUNT(M.id) AS total_subject, SUM(G.point) AS total_point, SUM(M.exam_total_mark) AS exam_mark, SUM(M.obtain_total_mark) AS obtain_mark');
        $ci->db->from('marks AS M');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');      
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.exam_id', $exam_id);
        if ($section_id) {
            $ci->db->where('M.section_id', $section_id);
        }
        
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_exam_result')) {

    function get_exam_result($school_id, $exam_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('ER.*, G.name');
        $ci->db->from('exam_results AS ER');  
        $ci->db->join('grades AS G', 'G.id = ER.grade_id', 'left');  
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.exam_id', $exam_id);
        $ci->db->where('ER.class_id', $class_id);
        
        if ($section_id) {
            $ci->db->where('ER.section_id', $section_id);
        }
        
        $ci->db->where('ER.student_id', $student_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_exam_final_result')) {

    function get_exam_final_result($school_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('FR.*');
        $ci->db->from('final_results AS FR');
        $ci->db->where('FR.class_id', $class_id);
        if ($section_id) {
            $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.student_id', $student_id);
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_subject_list')) {

    function get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $student_id) {
        $ci = & get_instance();
        $ci->db->select('M.*,S.name AS subject, G.point, G.name, T.initials');
        $ci->db->from('marks AS M');        
        $ci->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = S.teacher_id', 'left');
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        return  $ci->db->get()->result();     
    }

}


if (!function_exists('get_student_position')) {

    function get_student_position($school_id, $academic_year_id, $class_id, $student_id, $section_id = null) {
        
        $cond = "";
        $condition = " academic_year_id = $academic_year_id ";
        $condition .= " AND school_id = $school_id";
        $condition .= " AND class_id = $class_id";        
        if($section_id){
           $condition .= " AND section_id = $section_id";
        }
        
        $cond = $condition;
        $condition .= " AND student_id = $student_id";
        
        $ci = & get_instance();              
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point), 
                ( SELECT GROUP_CONCAT( (avg_grade_point) ORDER BY avg_grade_point DESC )
                FROM final_results WHERE $cond  )) AS rank 
                FROM final_results 
                WHERE $condition";
        
        $result =  $ci->db->query($sql)->row(); 
      
        $rank = '';
        if(!empty($result)){
            $rank = $result->rank;
        }
                       
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}



if (!function_exists('get_lowet_height_mark')) {

    function get_lowet_height_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('MIN(M.obtain_total_mark) AS lowest, MAX(M.obtain_total_mark) AS height');
        $ci->db->from('marks AS M');       
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.section_id', $section_id);
        $ci->db->where('M.subject_id', $subject_id);  
        return  $ci->db->get()->row();
     // echo $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_subject')) {

    function get_position_in_subject($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id, $mark) {
        
        
        $ci = & get_instance();
        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id"; 
        }
        
        $sql = "SELECT id, obtain_total_mark, FIND_IN_SET( obtain_total_mark,(
                SELECT GROUP_CONCAT( obtain_total_mark  ORDER BY obtain_total_mark DESC ) 
                FROM marks WHERE  
                school_id = $school_id
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id
                AND class_id = $class_id
                $sec
                AND subject_id = $subject_id))
                AS rank 
                FROM marks
                WHERE school_id = $school_id
                   AND academic_year_id = $academic_year_id  
                   AND exam_id = $exam_id
                   AND class_id = $class_id 
                   $sec 
                   AND subject_id = $subject_id 
                   AND  obtain_total_mark = $mark"; 
        
        $rank =  $ci->db->query($sql)->row()->rank; 
        
        if($mark == 0){
            return '--'; 
        }
        
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}


if (!function_exists('get_subject_list')) {

    function get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        $ci->db->select('M.*,S.name AS subject, T.initials');
        $ci->db->from('marks AS M');        
        $ci->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = M.subject_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);
        return  $ci->db->get()->result();     
    }

}



if (!function_exists('get_exam_wise_markt')) {

    function get_exam_wise_markt($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        
        $select = 'SUM(M.written_mark) AS written_mark,
                   SUM(M.written_obtain) AS written_obtain,
                   SUM(M.tutorial_mark) AS tutorial_mark,
                   SUM(M.tutorial_obtain) AS tutorial_obtain,
                   SUM(M.practical_mark) AS practical_mark,
                   SUM(M.practical_obtain) AS practical_obtain,
                   SUM(M.viva_mark) AS viva_mark,
                   SUM(M.viva_obtain) AS viva_obtain,
                   COUNT(M.id) AS total_subject,
                   SUM(G.point) AS point               
                   ';
        
        $ci->db->select($select);
        $ci->db->from('marks AS M');        
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');          
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);        
        return $ci->db->get()->row();  
        // $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_exam')) {

    function get_position_in_exam($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $mark = null) {
                
        $ci = & get_instance();
        
        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id"; 
        }
        
        $sql = "SELECT id, total_obtain_mark, FIND_IN_SET( total_obtain_mark,(
                SELECT GROUP_CONCAT( total_obtain_mark  ORDER BY total_obtain_mark DESC ) 
                FROM exam_results WHERE 
                school_id = $school_id 
                AND academic_year_id = $academic_year_id 
                AND exam_id = $exam_id 
                AND class_id = $class_id 
                $sec ))
                AS rank 
                FROM exam_results
                WHERE school_id = $school_id 
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id 
                AND class_id = $class_id 
                $sec 
                AND total_obtain_mark = $mark"; 
        
        $rank =  @$ci->db->query($sql)->row()->rank; 
        
        if($mark == 0){
            return '--'; 
        }
        
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}


if (!function_exists('get_lowet_height_result')) {

    function get_lowet_height_result($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        $ci->db->select('MIN(ER.total_obtain_mark) AS lowest, MAX(ER.total_obtain_mark) AS height');
        $ci->db->from('exam_results AS ER');       
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        $ci->db->where('ER.exam_id', $exam_id);
        $ci->db->where('ER.class_id', $class_id);
        if($section_id){
           $ci->db->where('ER.section_id', $section_id);
        }
        
        return  $ci->db->get()->row();
    }

}



if (!function_exists('get_final_result')) {
    
    function get_final_result($school_id, $academic_year_id, $class_id, $section_id, $student_id){
        
        $ci = & get_instance();
        $ci->db->select('FR.*, G.name AS grade');
        $ci->db->from('final_results AS FR');        
        $ci->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.class_id', $class_id);
        if($section_id){
          $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.student_id', $student_id);
        return $ci->db->get()->row();       
    }
}


if (!function_exists('get_position_in_class')) {

    function get_position_in_class($school_id, $academic_year_id, $class_id, $student_id) {
       
        
        $condition = " school_id = $school_id";
        $condition .= " AND academic_year_id = $academic_year_id";
        $condition .= " AND class_id = $class_id";
        $condition .= " AND student_id = $student_id";       
        
        $ci = & get_instance();              
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point+total_obtain_mark), 
                ( SELECT GROUP_CONCAT( (avg_grade_point+total_obtain_mark) ORDER BY avg_grade_point DESC )
                FROM final_results ) ) AS rank 
                FROM final_results 
                WHERE $condition";
        
        $rank =  @$ci->db->query($sql)->row()->rank; 
         
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}

if (!function_exists('get_transfer')) {

    function get_transfer($school_id = null) {
        $ci = & get_instance();
        $ci->db->select('T.*');
        $ci->db->from('teachers AS T');
        if($school_id){
            $ci->db->where('T.school_id', $school_id);
        }
        return $ci->db->get()->row();
    }

}


if (!function_exists('get_enrollment')) {

    function get_enrollment($student_id, $academic_year_id, $school_id = null) {
        $ci = & get_instance();
        $ci->db->select('E.*');
        $ci->db->from('enrollments AS E');
        $ci->db->where('E.student_id', $student_id);
        $ci->db->where('E.academic_year_id', $academic_year_id);
        if($school_id){
            $ci->db->where('E.school_id', $school_id);
        }
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_user_by_role')) {

    function get_user_by_role($role_id, $user_id, $academic_year_id = null) {

        $ci = & get_instance();

        if ($role_id == SUPER_ADMIN) {
            
            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();

        } elseif ($role_id == DEO) {
            
            $ci->db->select('DA.*, U.username, U.role_id');
            $ci->db->from('district_admin AS DA');
            $ci->db->join('users AS U', 'U.id = DA.user_id', 'left');
            $ci->db->where('DA.user_id', $user_id);
            return $ci->db->get()->row();

        } elseif ($role_id == STUDENT) {

            $ci->db->select('S.*, T.type,  D.amount, D.title AS discount, G.name AS guardian, E.roll_no, E.section_id, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('student_types AS T', 'T.id = S.type_id', 'left');
            $ci->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
            if($academic_year_id){
                $ci->db->where('E.academic_year_id', $academic_year_id);
            }
            $ci->db->where('S.user_id', $user_id);
            
            return $ci->db->get()->row();
            
        } elseif ($role_id == TEACHER) {
            
            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();
            
        } elseif ($role_id == GUARDIAN) {
            
            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();
                
        } else {
            
            $ci->db->select('E.*, SG.grade_name, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return $ci->db->get()->row();
        }

        $ci->db->last_query();
    }

}


if (!function_exists('get_user_by_id')) {

    function get_user_by_id($user_id) {

        $ci = & get_instance();

        $ci->db->select('U.id, U.role_id');
        $ci->db->from('users AS U');
        $ci->db->where('U.id', $user_id);
        $user = $ci->db->get()->row();

        if ($user->role_id == SUPER_ADMIN) {
            
            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();
            
        } elseif ($user->role_id == DEO) {
            
            $ci->db->select('DA.*, U.username, U.role_id');
            $ci->db->from('district_admin AS DA');
            $ci->db->join('users AS U', 'U.id = DA.user_id', 'left');
            $ci->db->where('DA.user_id', $user_id);
            return $ci->db->get()->row();
            
        } else if ($user->role_id == STUDENT) {

            $ci->db->select('S.*, E.roll_no, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->where('S.user_id', $user_id);            
            return $ci->db->get()->row();
            
        } elseif ($user->role_id == TEACHER) {
            
            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();
            
        } elseif ($user->role_id == GUARDIAN) {
            
            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();        
            
        } else {
            
            $ci->db->select('E.*, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return  $ci->db->get()->row();
        }

        // $ci->db->last_query();
    }

}


if (!function_exists('get_total_used_leave')) {

    function get_total_used_leave($academic_year_id, $role_id, $type_id, $user_id) {
        $ci = & get_instance();
        
        $ci->db->select('sum(A.leave_day) AS total');
        $ci->db->from('leave_applications AS A');
        $ci->db->where('A.role_id', $role_id);
        $ci->db->where('A.type_id', $type_id);
        $ci->db->where('A.user_id', $user_id);
        $ci->db->where('A.academic_year_id', $academic_year_id);
        $ci->db->where('A.leave_status', 2);
        $result = $ci->db->get()->row();
      
        if(!empty($result)){
            return $result->total;
        }else{
            return 0;
        }
    }
}


if (!function_exists('get_blood_group')) {

    function get_blood_group() {
        $ci = & get_instance();
        return array(
            'a_positive' => $ci->lang->line('a_positive'),
            'a_negative' => $ci->lang->line('a_negative'),
            'b_positive' => $ci->lang->line('b_positive'),
            'b_negative' => $ci->lang->line('b_negative'),
            'o_positive' => $ci->lang->line('o_positive'),
            'o_negative' => $ci->lang->line('o_negative'),
            'ab_positive' => $ci->lang->line('ab_positive'),
            'ab_negative' => $ci->lang->line('ab_negative')
        );
    }

}

if (!function_exists('get_subject_type')) {

    function get_subject_type() {
        $ci = & get_instance();
        return array(
            'mandatory' => $ci->lang->line('mandatory'),
            'optional' => $ci->lang->line('optional')
        );
    }

}

if (!function_exists('get_groups')) {

    function get_groups() {
        $ci = & get_instance();
        return array(
            'science' => $ci->lang->line('science'),
            'arts' => $ci->lang->line('arts'),
            'commerce' => $ci->lang->line('commerce')
        );
    }

}


if (!function_exists('get_week_days')) {

    function get_week_days() {
        $ci = & get_instance();
        return array(           
            'monday' => $ci->lang->line('monday'),
            'tuesday' => $ci->lang->line('tuesday'),
            'wednesday' => $ci->lang->line('wednesday'),
            'thursday' => $ci->lang->line('thursday'),
            'friday' => $ci->lang->line('friday'),
            'saturday' => $ci->lang->line('saturday'),
            'sunday' => $ci->lang->line('sunday')
        );
    }

}

if (!function_exists('get_months')) {

    function get_months() {
        $ci = & get_instance();
        return array(
            'january' => $ci->lang->line('january'),
            'february' => $ci->lang->line('february'),
            'march' => $ci->lang->line('march'),
            'april' => $ci->lang->line('april'),
            'may' => $ci->lang->line('may'),
            'june' => $ci->lang->line('june'),
            'july' => $ci->lang->line('july'),
            'august' => $ci->lang->line('august'),
            'september' => $ci->lang->line('september'),
            'october' => $ci->lang->line('october'),
            'november' => $ci->lang->line('november'),
            'december' => $ci->lang->line('december')
        );
    }

}

if (!function_exists('get_hostel_types')) {

    function get_hostel_types() {
        $ci = & get_instance();
        return array(
            'boys' => $ci->lang->line('boys'),
            'girls' => $ci->lang->line('girls'),
            'combine' => $ci->lang->line('combine')
        );
    }
}

if (!function_exists('get_page_location')) {

    function get_page_location() {
        $ci = & get_instance();
        return array(
            'header' => $ci->lang->line('header'),
            'footer' => $ci->lang->line('footer'),
        );
    }
}

if (!function_exists('get_room_types')) {

    function get_room_types() {
        $ci = & get_instance();
        return array(
            'ac' => $ci->lang->line('ac'),
            'non_ac' => $ci->lang->line('non_ac')
        );
    }

}


if (!function_exists('get_genders')) {

    function get_genders() {
        $ci = & get_instance();
        return array(
            'male' => $ci->lang->line('male'),
            'female' => $ci->lang->line('female')
        );
    }

}

if (!function_exists('get_paid_types')) {

    function get_paid_status($status) {
        $ci = & get_instance();
        $data = array(
            'paid' => $ci->lang->line('paid'),
            'unpaid' => $ci->lang->line('unpaid'),
            'partial' => $ci->lang->line('partial')
        );
        return $data[$status];
    }

}
/*
if (!function_exists('get_relation_types')) {

    function get_relation_types() {
        $ci = & get_instance();
        return array(
            'father' => $ci->lang->line('father'),
            'mother' => $ci->lang->line('mother'),
            'sister' => $ci->lang->line('sister'),
            'brother' => $ci->lang->line('brother'),
            'uncle' => $ci->lang->line('uncle'),
            'maternal_uncle' => $ci->lang->line('maternal_uncle'),
            'other_relative' => $ci->lang->line('other_relative')
        );
    }
}
*/


if (!function_exists('get_video_types')) {

    function get_video_types() {
        $ci = & get_instance();
        return array(
            'youtube' => $ci->lang->line('youtube'),
            'vimeo' => $ci->lang->line('vimeo'),
            'ppt' => $ci->lang->line('power_point')
        );
    }
}

if (!function_exists('get_payment_methods')) {

    function get_payment_methods($school_id = null) {
        $ci = & get_instance();

        $methods = array('cash' => $ci->lang->line('cash'), 'cheque' => $ci->lang->line('cheque'), 'receipt' => $ci->lang->line('bank_receipt'));
          
        if($ci->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $ci->session->userdata('school_id');
        }
        
        $ci->db->select('PS.*');
        $ci->db->from('payment_settings AS PS');  
        if($school_id){
            $ci->db->where('PS.school_id', $school_id);
        }
        
        $data = $ci->db->get()->row();
        if(!empty($data)){ 
            if ($data->paypal_status) {
                $methods['paypal'] = $ci->lang->line('paypal');
            }
            if ($data->payumoney_status) {
                $methods['payumoney'] = $ci->lang->line('payumoney');
            }
            /*if ($data->stripe_status) {
                $methods['stripe'] = $ci->lang->line('stripe');
            }
            if ($data->ccavenue_status) {
                $methods['ccavenue'] = $ci->lang->line('ccavenue');
            }*/
            if ($data->paytm_status) {
                $methods['paytm'] = $ci->lang->line('paytm');
            }            
            if ($data->stack_status) {
                $methods['paystack'] = $ci->lang->line('pay_stack');
            }
        }

        return $methods;
    }

}

if (!function_exists('get_sms_gateways')) {

    function get_sms_gateways( $school_id ) {
        
        $ci = & get_instance();
        $gateways = array();
       
        $ci->db->select('SS.*');
        $ci->db->from('sms_settings AS SS');
        $ci->db->where('SS.school_id', $school_id);
        $data = $ci->db->get()->row();

        if(!empty($data)){
            
            if ($data->clickatell_status) {
                $gateways['clicktell'] = $ci->lang->line('clicktell');
            }
            if ($data->twilio_status) {
                $gateways['twilio'] = $ci->lang->line('twilio');
            }
            if ($data->bulk_status) {
                $gateways['bulk'] = $ci->lang->line('bulk');
            }
            if ($data->msg91_status) {
                $gateways['msg91'] = $ci->lang->line('msg91');
            }
            if ($data->plivo_status) {
                $gateways['plivo'] = $ci->lang->line('plivo');
            }
            if ($data->textlocal_status) {
                $gateways['text_local'] = $ci->lang->line('text_local');
            }
            if ($data->smscountry_status) {
                $gateways['sms_country'] = $ci->lang->line('sms_country');
            }
            if ($data->betasms_status) {
                $gateways['beta_sms'] = $ci->lang->line('beta_sms');
            }
            if ($data->bulk_pk_status) {
                $gateways['bulk_pk'] = $ci->lang->line('bulk_pk');
            }
            if ($data->cluster_status) {
                $gateways['sms_custer'] = $ci->lang->line('sms_custer');
            }
            if ($data->alpha_status) {
                $gateways['alpha_net'] = $ci->lang->line('alpha_net');
            }
            if ($data->bdbulk_status) {
                $gateways['bd_bulk'] = $ci->lang->line('bd_bulk');
            }
            if ($data->mim_status) {
                $gateways['mim_sms'] = $ci->lang->line('mim_sms');
            }
         }
        return $gateways;
    }

}


if (!function_exists('get_group_by_type')) {

    function get_group_by_type() {
        $ci = & get_instance();
        return array(
            'daily' => $ci->lang->line('daily'),
            'monthly' => $ci->lang->line('monthly'),
            'yearly' => $ci->lang->line('yearly')
        );
    }

}


if (!function_exists('get_template_tags')) {

    function get_template_tags($role_id) {
        $tags = array();
        $tags[] = '[name]';
        $tags[] = '[email]';
        $tags[] = '[phone]';

        if($role_id == SUPER_ADMIN){
            
            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';            
        }elseif ($role_id == STUDENT) {

            $tags[] = '[class_name]';
            $tags[] = '[section]';
            $tags[] = '[roll_no]';
            $tags[] = '[dob]';
            $tags[] = '[gender]';
            $tags[] = '[religion]';
            $tags[] = '[blood_group]';
            $tags[] = '[registration_no]';
            $tags[] = '[group]';
            $tags[] = '[created_at]';
            $tags[] = '[guardian]';
            
        } else if ($role_id == GUARDIAN) {
            $tags[] = '[profession]';
        } else if ($role_id == TEACHER) {
            $tags[] = '[responsibility]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        } else {
            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        }

        $tags[] = '[present_address]';
        $tags[] = '[permanent_address]';

        return $tags;
    }

}

if (!function_exists('get_formatted_body')) {

    function get_formatted_body($body, $role_id, $user_id) {

         $ci = & get_instance();
        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);
             
        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);
            
            if($field == 'blood_group'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'gender'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'group'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'created_at'){                
                $body = str_replace($tag, date('M-d-Y', strtotime($user->created_at)), $body);                
            }else{
                $body = str_replace($tag, $user->{$field}, $body);
            } 
        }
        return $body;
    }
}

if (!function_exists('get_formatted_certificate_text')) {

    function get_formatted_certificate_text($body, $role_id, $user_id) {

        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);
              
        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);
            
            if($field == 'created_at'){                
                $body = str_replace($tag, '<span>'.date('M-d-Y', strtotime($user->created_at)).'</span>', $body);                
            }else{
                $body = str_replace($tag, '<span>'.$user->{$field}.'</span>', $body);
            }            
        }

        return $body;
    }
}



if (!function_exists('get_nice_time')) {

    function get_nice_time($date) {

        $ci = & get_instance();
        if (empty($date)) {
            return "2 months ago"; //"No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "2 months ago"; // "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

}



if (!function_exists('get_inbox_message')) {

    function get_inbox_message() {
        $ci = & get_instance();
        $ci->db->select('MR.*, M.*');
        $ci->db->from('message_relationships AS MR');
        $ci->db->join('messages AS M', 'M.id = MR.message_id', 'left');
        $ci->db->where('MR.status', 1);
        $ci->db->where('MR.is_read', 0);
        $ci->db->where('MR.owner_id', logged_in_user_id());
        $ci->db->where('MR.receiver_id', logged_in_user_id());
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_hostel_by_school')) {

    function get_hostel_by_school($school_id) {
        $ci = & get_instance();
        $ci->db->select('H.*');
        $ci->db->from('hostels AS H');
        $ci->db->where('H.school_id', $school_id);
       return $ci->db->get()->result();
    }

}

if (!function_exists('get_gallery_images')) {

    function get_gallery_images($school_id, $gallery_id) {
        $ci = & get_instance();
        $ci->db->select('GI.*');
        $ci->db->from('gallery_images AS GI');
        $ci->db->where('GI.school_id', $school_id);
        $ci->db->where('GI.gallery_id', $gallery_id);
       return $ci->db->get()->result();
    }
}


if (!function_exists('get_fee_amount')) {

    function get_fee_amount($income_head_id, $class_id) {
        $ci = & get_instance();
        return $ci->db->get_where('fees_amount', array('class_id'=>$class_id, 'income_head_id'=>$income_head_id))->row();
    }
}

if (!function_exists('get_invoice_paid_amount')) {

    function get_invoice_paid_amount($invoice_id){
        $ci = & get_instance();
        $ci->db->select('I.*, SUM(T.amount) AS paid_amount');
        $ci->db->from('invoices AS I');        
        $ci->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $ci->db->where('I.id', $invoice_id);         
        return $ci->db->get()->row(); 
    }
}

if (!function_exists('get_operation_by_module')) {

    function get_operation_by_module($module_id) {
        $ci = & get_instance();
        $ci->db->select('O.*');
        $ci->db->from('operations AS O');
        $ci->db->where('O.module_id', $module_id);
        return $ci->db->get()->result();
    }

}

if (!function_exists('get_permission_by_operation')) {

    function get_permission_by_operation($role_id, $operation_id) {
        $ci = & get_instance();
        $ci->db->select('P.*');
        $ci->db->from('privileges AS P');
        $ci->db->where('P.role_id', $role_id);
        $ci->db->where('P.operation_id', $operation_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_school_list')) {

    function get_school_list() {
        $ci = & get_instance();
        $ci->db->select('S.*, D.district_name AS district');
        $ci->db->from('schools AS S');
        $ci->db->join('district AS D','D.id=S.district_id', 'left');
        $ci->db->where('S.status', 1);
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_sub_region_list')) {

    function get_sub_region_list() {
        $ci = & get_instance();
        $ci->db->select('SR.*');
        $ci->db->from('subregion AS SR');
    
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_district_list')) {

    function get_district_list() {
        $ci = & get_instance();
        $ci->db->select('D.*');
        $ci->db->from('district AS D');
    
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_sub_county_list')) {

    function get_sub_county_list() {
        $ci = & get_instance();
        $ci->db->select('SC.*');
        $ci->db->from('subcounty AS SC');
    
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_parish_list')) {

    function get_parish_list() {
        $ci = & get_instance();
        $ci->db->select('P.*');
        $ci->db->from('parish AS P');
    
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_village_list')) {

    function get_village_list() {
        $ci = & get_instance();
        $ci->db->select('V.*');
        $ci->db->from('village AS V');
    
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_region_list')) {

    function get_region_list() {
        $ci = & get_instance();
        $ci->db->select('R.*');
        $ci->db->from('regions AS R');
        //$ci->db->where('S.status', 1);
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_lang')) {

    function get_lang() {
        $ci = & get_instance();
        $ci->lang->line('dashboard');
    }

}

if (!function_exists('get_default_lang_list')) {

    function get_default_lang_list($lang) {
        $lang_lists = array();
        $lang_lists['english'] = 'english';
        $lang_lists['bengali'] = 'bengali';
        $lang_lists['spanish'] = 'spanish';
        $lang_lists['arabic'] = 'arabic';
        $lang_lists['hindi'] = 'hindi';
        $lang_lists['urdu'] = 'urdu';
        $lang_lists['chinese'] = 'chinese';
        $lang_lists['japanese'] = 'japanese';
        $lang_lists['portuguese'] = 'portuguese';
        $lang_lists['russian'] = 'russian';
        $lang_lists['french'] = 'french';
        $lang_lists['korean'] = 'korean';
        $lang_lists['german'] = 'german';
        $lang_lists['italian'] = 'italian';
        $lang_lists['thai'] = 'thai';
        $lang_lists['hungarian'] = 'hungarian';
        $lang_lists['dutch'] = 'dutch';
        $lang_lists['latin'] = 'latin';
        $lang_lists['indonesian'] = 'indonesian';
        $lang_lists['turkish'] = 'turkish';
        $lang_lists['greek'] = 'greek';
        $lang_lists['persian'] = 'persian';
        $lang_lists['malay'] = 'malay';
        $lang_lists['telugu'] = 'telugu';
        $lang_lists['tamil'] = 'tamil';
        $lang_lists['gujarati'] = 'gujarati';
        $lang_lists['polish'] = 'polish';
        $lang_lists['ukrainian'] = 'ukrainian';
        $lang_lists['panjabi'] = 'panjabi';
        $lang_lists['romanian'] = 'romanian';
        $lang_lists['burmese'] = 'burmese';
        $lang_lists['yoruba'] = 'yoruba';
        $lang_lists['hausa'] = 'hausa';

        if (isset($lang_lists[$lang]) && !empty($lang_lists[$lang])) {
            return true;
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('get_timezones')) {
    function get_timezones() {
        $timezones = array(           
            'Pacific/Midway' => "(GMT-11:00) Midway Island",
            'US/Samoa' => "(GMT-11:00) Samoa",
            'US/Hawaii' => "(GMT-10:00) Hawaii",
            'US/Alaska' => "(GMT-09:00) Alaska",
            'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana' => "(GMT-08:00) Tijuana",
            'US/Arizona' => "(GMT-07:00) Arizona",
            'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua' => "(GMT-07:00) Chihuahua",
            'America/Mazatlan' => "(GMT-07:00) Mazatlan",
            'America/Mexico_City' => "(GMT-06:00) Mexico City",
            'America/Monterrey' => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
            'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
            'America/Bogota' => "(GMT-05:00) Bogota",
            'America/Lima' => "(GMT-05:00) Lima",
            'America/Caracas' => "(GMT-04:30) Caracas",
            'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz' => "(GMT-04:00) La Paz",
            'America/Santiago' => "(GMT-04:00) Santiago",
            'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland' => "(GMT-03:00) Greenland",
            'Atlantic/Stanley' => "(GMT-02:00) Stanley",
            'Atlantic/Azores' => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca' => "(GMT) Casablanca",
            'Europe/Dublin' => "(GMT) Dublin",
            'Europe/Lisbon' => "(GMT) Lisbon",
            'Europe/London' => "(GMT) London",
            'Africa/Monrovia' => "(GMT) Monrovia",
            'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade' => "(GMT+01:00) Belgrade",
            'Europe/Berlin' => "(GMT+01:00) Berlin",
            'Europe/Bratislava' => "(GMT+01:00) Bratislava",
            'Europe/Brussels' => "(GMT+01:00) Brussels",
            'Europe/Budapest' => "(GMT+01:00) Budapest",
            'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
            'Europe/Madrid' => "(GMT+01:00) Madrid",
            'Europe/Paris' => "(GMT+01:00) Paris",
            'Europe/Prague' => "(GMT+01:00) Prague",
            'Europe/Rome' => "(GMT+01:00) Rome",
            'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
            'Europe/Skopje' => "(GMT+01:00) Skopje",
            'Europe/Stockholm' => "(GMT+01:00) Stockholm",
            'Europe/Vienna' => "(GMT+01:00) Vienna",
            'Europe/Warsaw' => "(GMT+01:00) Warsaw",
            'Europe/Zagreb' => "(GMT+01:00) Zagreb",
            'Europe/Athens' => "(GMT+02:00) Athens",
            'Europe/Bucharest' => "(GMT+02:00) Bucharest",
            'Africa/Cairo' => "(GMT+02:00) Cairo",
            'Africa/Harare' => "(GMT+02:00) Harare",
            'Europe/Helsinki' => "(GMT+02:00) Helsinki",
            'Europe/Istanbul' => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
            'Europe/Kiev' => "(GMT+02:00) Kyiv",
            'Europe/Minsk' => "(GMT+02:00) Minsk",
            'Europe/Riga' => "(GMT+02:00) Riga",
            'Europe/Sofia' => "(GMT+02:00) Sofia",
            'Europe/Tallinn' => "(GMT+02:00) Tallinn",
            'Europe/Vilnius' => "(GMT+02:00) Vilnius",
            'Asia/Baghdad' => "(GMT+03:00) Baghdad",
            'Asia/Kuwait' => "(GMT+03:00) Kuwait",
            'Africa/Nairobi' => "(GMT+03:00) Nairobi",
            'Asia/Riyadh' => "(GMT+03:00) Riyadh",
            'Asia/Tehran' => "(GMT+03:30) Tehran",
            'Europe/Moscow' => "(GMT+04:00) Moscow",
            'Asia/Baku' => "(GMT+04:00) Baku",
            'Europe/Volgograd' => "(GMT+04:00) Volgograd",
            'Asia/Muscat' => "(GMT+04:00) Muscat",
            'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan' => "(GMT+04:00) Yerevan",
            'Asia/Kabul' => "(GMT+04:30) Kabul",
            'Asia/Karachi' => "(GMT+05:00) Karachi",
            'Asia/Tashkent' => "(GMT+05:00) Tashkent",
            'Asia/Kolkata' => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg' => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty' => "(GMT+06:00) Almaty",
            'Asia/Dhaka' => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk' => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok' => "(GMT+07:00) Bangkok",
            'Asia/Jakarta' => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk' => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing' => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth' => "(GMT+08:00) Perth",
            'Asia/Singapore' => "(GMT+08:00) Singapore",
            'Asia/Taipei' => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi' => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk' => "(GMT+09:00) Irkutsk",
            'Asia/Seoul' => "(GMT+09:00) Seoul",
            'Asia/Tokyo' => "(GMT+09:00) Tokyo",
            'Australia/Adelaide' => "(GMT+09:30) Adelaide",
            'Australia/Darwin' => "(GMT+09:30) Darwin",
            'Asia/Yakutsk' => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane' => "(GMT+10:00) Brisbane",
            'Australia/Canberra' => "(GMT+10:00) Canberra",
            'Pacific/Guam' => "(GMT+10:00) Guam",
            'Australia/Hobart' => "(GMT+10:00) Hobart",
            'Australia/Melbourne' => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney' => "(GMT+10:00) Sydney",
            'Asia/Vladivostok' => "(GMT+11:00) Vladivostok",
            'Asia/Magadan' => "(GMT+12:00) Magadan",
            'Pacific/Auckland' => "(GMT+12:00) Auckland",
            'Pacific/Fiji' => "(GMT+12:00) Fiji",
        );

        return $timezones;
    }
}


if (!function_exists('get_date_format')) {
    function get_date_format() {
        
        $date = array();
        $date['Y-m-d'] = '2001-03-15';
        $date['d-m-Y'] = '15-03-2018';
        $date['d/m/Y'] = '15/03/2018';
        $date['m/d/Y'] = '03/15/2018';
        $date['m.d.Y'] = '03.10.2018';
        $date['j, n, Y'] = '14, 7, 2018';
        $date['F j, Y'] = 'July 15, 2018';
        $date['M j, Y'] = 'Jul 13, 2018';
        $date['j M, Y'] = '13 Jul, 2018';
        
        return $date;
    }
}


if (!function_exists('get_mail_protocol')) {
    function get_mail_protocol() {
        
        $protocol = array();
        $protocol['mail'] = 'mail';
        $protocol['sendmail'] = 'sendmail';
        $protocol['smtp'] = 'smtp';        
        
        return $protocol;
    }
}

if (!function_exists('get_smtp_crypto')) {
    function get_smtp_crypto() {
        
        $smtp_crypto = array();
        $smtp_crypto['tls'] = 'tls';
        $smtp_crypto['ssl'] = 'ssl';
        
        return $smtp_crypto;
    }
}

if (!function_exists('get_mail_type')) {
    function get_mail_type() {
        
        $mail_type = array();
        $mail_type['text'] = 'text';
        $mail_type['html'] = 'html';
        
        return $mail_type;
    }
}

if (!function_exists('get_char_set')) {
    function get_char_set() {
        
        $char_set = array();
        $char_set['utf-8'] = 'utf-8';
        $char_set['iso-8859-1'] = 'iso-8859-1';
        
        return $char_set;
    }
}

if (!function_exists('get_email_priority')) {
    function get_email_priority() {
        
        $priority = array();
        $priority['1'] = 'highest';
        $priority['3'] = 'normal';
        $priority['5'] = 'lowest';       
        
        return $priority;
    }
}

if (!function_exists('get_random_tring')) {

    function get_random_tring($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}


if (!function_exists('get_card_bottom_text_align')) {
    function get_card_bottom_text_align() {
        
        $text_align = array();
        $text_align['center'] = 'center';
        $text_align['left'] = 'left';
        $text_align['right'] = 'right';       
        
        return $text_align;
    }
}

if (!function_exists('get_evaluation_status')) {
    function get_evaluation_status( $status = null) {
        
         $ci = & get_instance();
   
        $evaluate = array();
        $evaluate['submitted'] = $ci->lang->line('submitted');
        $evaluate['completed'] = $ci->lang->line('completed');
        $evaluate['incomplete'] = $ci->lang->line('incomplete');       
        $evaluate['resubmitted'] = $ci->lang->line('resubmitted');           
        
        if($status){
            return $evaluate[$status];
        }else{
            return $evaluate;
        }
    }
}


if (!function_exists('get_teacher_rating')) {
    function get_teacher_rating($techer_id) {
        
        $ci = & get_instance();
        $ci->db->select('R.*, S.name AS student_name');
        $ci->db->from('ratings AS R');
        $ci->db->join('students AS S', 'S.id = R.student_id', 'left');
        $ci->db->where('R.teacher_id', $techer_id);
        $ci->db->where('R.student_id', $ci->session->userdata('profile_id'));
        $ci->db->where('R.class_id', $ci->session->userdata('class_id'));
        $ci->db->where('R.section_id', $ci->session->userdata('section_id'));
        $ci->db->where('R.academic_year_id', $ci->session->academic_year_id);    
        return $ci->db->get()->row();     
    }
}


if (!function_exists('get_teacher_avg_rating')) {
    function get_teacher_avg_rating($academic_year_id, $techer_id) {
        
        $ci = & get_instance();
        $ci->db->select('SUM(R.rating) AS total_rating, COUNT(R.id) AS rating_count');
        $ci->db->from('ratings AS R');
        $ci->db->where('R.teacher_id', $techer_id);       
        $ci->db->where('R.rating_status', 'approved');       
        $ci->db->where('R.academic_year_id', $academic_year_id);       
        $rating = $ci->db->get()->row();
        if($rating->total_rating > 0 && $rating->rating_count > 0) {
            return $rating->total_rating/$rating->rating_count;
        }else{
            return '';
        }       
    }
}


if (!function_exists('get_donar_types')) {

    function get_donar_types() {
        $ci = & get_instance();
        return array(
            'individual' => $ci->lang->line('individual'),
            'organization' => $ci->lang->line('organization')
        );
    }

}


if (!function_exists('get_lesson_detail_by_lesson_id')) {
    function get_lesson_detail_by_lesson_id($lesson_id) {
        
        $ci = & get_instance();
        $ci->db->select('LD.*');
        $ci->db->from('lp_lesson_details AS LD');
        $ci->db->where('LD.lesson_id', $lesson_id); 
        $ci->db->order_by('LD.id', 'ASC'); 
        return $ci->db->get()->result();     
        
    }
}



if (!function_exists('get_topic_detail_by_topic_id')) {
    function get_topic_detail_by_topic_id($topic_id) {
        
        $ci = & get_instance();
        $ci->db->select('TD.*');
        $ci->db->from('lp_topic_details AS TD');
        $ci->db->where('TD.topic_id', $topic_id); 
        $ci->db->order_by('TD.id', 'ASC'); 
        return $ci->db->get()->result();     
        
    }
}


if (!function_exists('get_lesson_status')) {
    function get_lesson_status( $status = null) {
        
         $ci = & get_instance();
   
        $lesson = array();
        $lesson['completed'] = $ci->lang->line('completed');
        $lesson['incomplete'] = $ci->lang->line('incomplete');       
        
        if($status){
            return $lesson[$status];
        }else{
            return $lesson;
        }
    }
}



if (!function_exists('get_question_label')) {
    function get_question_label() {
        
         $ci = & get_instance();
   
        $type = array();
        $type['easy'] = $ci->lang->line('easy');
        $type['medium'] = $ci->lang->line('medium');
        $type['hard'] = $ci->lang->line('hard');
        
        return $type;
    }
}


if (!function_exists('get_question_type')) {
    function get_question_type($index = null) {
        
         $ci = & get_instance();
   
        $type = array();
        $type['single'] = $ci->lang->line('single_answer');
        $type['multi'] = $ci->lang->line('multi_answer');
        $type['blank'] = $ci->lang->line('fill_in_blank');
        $type['boolean'] = $ci->lang->line('true_false');
        
        if($index){
            return $type[$index];
        }else{
            return $type;
        }
    }
}


if (!function_exists('get_mark_type')) {
    function get_mark_type() {
        
         $ci = & get_instance();
   
        $type = array();
        $type['percentage'] = $ci->lang->line('percentage');
        $type['fixed'] = $ci->lang->line('fixed');       
        
        return $type;
    }
}



if (!function_exists('get_option_by_questoin_id')) {
    function get_option_by_questoin_id($question_id) {
        
        $ci = & get_instance();
        
        $ci->db->select('QA.*');
        $ci->db->from('exam_answers AS QA');       
        $ci->db->where('QA.question_id', $question_id);         
        $options = $ci->db->get()->result();          
        return $options;        
    }
}

if (!function_exists('get_exam_to_question')) {
    function get_exam_to_question($online_exam_id) {
        
        $ci = & get_instance();
        
        $ci->db->select('EQ.*');
        $ci->db->from('exam_to_questions AS EQ');       
        $ci->db->where('EQ.online_exam_id', $online_exam_id);         
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_total_question_by_exam')) {
    function get_total_question_by_exam($online_exam_id) {
        
        $ci = & get_instance();
        
        $ci->db->select('EQ.*');
        $ci->db->from('exam_to_questions AS EQ');       
        $ci->db->where('EQ.online_exam_id', $online_exam_id);         
        return $ci->db->count_all_results();
    }
}


if (!function_exists('get_question_detail')) {
    function get_question_detail($online_exam_id, $question_id, $counter = null) {
        
        $ci = & get_instance(); 
        
        $ci->db->select('EQ.*');
        $ci->db->from('exam_questions AS EQ');       
        $ci->db->where('EQ.id', $question_id);         
        $question = $ci->db->get()->row(); 
        
        
        $ci->db->select('QA.*');
        $ci->db->from('exam_answers AS QA');       
        $ci->db->where('QA.question_id', $question_id);         
        $options = $ci->db->get()->result(); 
          
        $str = '<div class="question-container">'; 
            $str .= '<div class="row question-title">';                
                $str .= '<div class="col-md-9 col-sm-9 col-xs-9"> '. $counter.'. '.$question->question.'</div>';
                $str .= '<div class="col-md-3 col-sm-3 col-xs-3 text-right">'.$ci->lang->line('mark').': '.$question->mark.'</div>';
            $str .= '</div>';
            
            if ($question->image) {
                $str .= '<div class="row question-title">';                
                    $str .= '<div class="col-md-12 col-sm-12 col-xs-12"><img src="'. UPLOAD_PATH.'/question/'. $question->image.'" alt="" style="width: auto;" /></div>';               
                $str .= '</div>';
            }
            
            $str .= '<div class="row">'; 
            if($question->question_type == 'single'){

                foreach($options AS $obj){                       

                    $answer = $obj->is_correct ? 'checked="checked"' : '';

                    $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                           <input id="'.$obj->id.'" type="radio" name="singleans'.$obj->id.'[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option.' 
                        </div>';   
                }
            }else if($question->question_type == 'multi'){

                foreach($options AS $obj){                       

                    $answer = $obj->is_correct ? 'checked="checked"' : '';

                    $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                           <input type="checkbox" name="ans'.$obj->id.'[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option.' 
                        </div>';   
                }

            }else if($question->question_type == 'boolean'){

                foreach($options AS $obj){                       

                    $answer = $obj->is_correct ? 'checked="checked"' : '';                        
                    $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                           <input type="radio" name="ans[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option .' 
                        </div>';   
                }
            }else if($question->question_type == 'blank'){

                foreach($options AS $key=>$obj){                       

                    $answer = $obj->is_correct ? 'checked="checked"' : '';

                    $str .= '<div class="col-md-12" style="display:inline-table">
                           '. ($key+1) . '.  ' .$obj->option.' 
                            </div>';   
                }
            }

            $str .= '<div class="col-md-12 text-right"><button onclick="javascript:void(0);remove_exam_question('.$online_exam_id.', '.$question_id.' , this)" class="btn btn-danger btn-xs "><i class="fa fa-trash-o"></i> '.$ci->lang->line('remove').' : <span> '.$counter.' </span></button></div>';        
            $str .= '<div class="col-md-12"><hr/></div>';        
            $str .= '</div>';
            
        $str .= '</div>';
            

        return $str;    
    }
}


if (!function_exists('get_item_type')) {
    function get_item_type() {
        
         $ci = & get_instance();
   
        $type = array();
        $type['new'] = $ci->lang->line('new');
        $type['used'] = $ci->lang->line('used');
        
        return $type;
    }
}


if (!function_exists('get_unit_types')) {

    function get_unit_types() {
        $ci = & get_instance();
        return array(
            'unit' => $ci->lang->line('unit'),
            'kg' => $ci->lang->line('kg'),
            'piece' => $ci->lang->line('piece'),
            'other' => $ci->lang->line('other')
        );
    }

}

// END

if (!function_exists('check_saas_status')) {

    function check_saas_status($school_id, $feature = null) {

        $ci = & get_instance();
        $ci->db->select('SP.*, SS.subscription_status, SS.end_date, SS.start_date, S.school_name, S.subscription_id');
        $ci->db->from('schools AS S');
        $ci->db->join('saas_subscriptions AS SS', 'SS.id = S.subscription_id', 'left');  
        $ci->db->join('saas_plans AS SP', 'SP.id = SS.subscription_plan_id', 'left');  
        $ci->db->where('S.id', $school_id);
        $subs = $ci->db->get()->row(); 

       
        if (empty($subs)) {            
            error($ci->lang->line('permission_denied'));
            return FALSE;
           
        } else {
           
            if(!$subs->subscription_id){              
                error($ci->lang->line('not_yet_subscribed')); // not yet subscribed
                return FALSE;
            }elseif($subs->subscription_status == 'pending'){ // pending
                
                error($ci->lang->line('subscription_pending'));
                return FALSE;
                
            }elseif($subs->subscription_status == 'suspend'){ // suspended
                
                error($ci->lang->line('subscription_suspended'));
                return FALSE;
                
            }elseif($subs->subscription_status == 'expired'){ // expired
                
                error($ci->lang->line('subscription_expired'));
                return FALSE;
                
            }elseif(strtotime($subs->end_date) < time()){ // expired
               
                error($ci->lang->line('subscription_expired'));
                return FALSE;                
                
            }elseif($feature == 'auth' ){ // pass for just login                   
                
                return TRUE;
                
            }elseif($feature == 'student' ){ // for student limit                  
                               
                $ci->db->where('school_id', $school_id);       
                $total_student = $ci->db->count_all_results('students');
        
                if($total_student > $subs->student_limit ){
                    error($ci->lang->line('upgrade_your_plan'));
                    return FALSE;   
                }else{                    
                    return TRUE;
                }
                
            }elseif($feature == 'guardian' ){ // for guardian limit                  
                
                $ci->db->where('school_id', $school_id);       
                $total_guardian = $ci->db->count_all_results('guardians'); 
                
                if($total_guardian > $subs->guardian_limit ){
                    error($ci->lang->line('upgrade_your_plan'));
                    return FALSE;   
                }else{                    
                    return TRUE;
                }
                
            }elseif($feature == 'teacher' ){ // for teacher limit                  
                
                $ci->db->where('school_id', $school_id);       
                $total_teacher = $ci->db->count_all_results('teachers'); 
                
                if($total_teacher > $subs->teacher_limit ){
                    error($ci->lang->line('upgrade_your_plan'));
                    return FALSE;   
                }else{                    
                    return TRUE;
                }
                
            }elseif($feature == 'employee' ){ // for employee limit                  
                
                $ci->db->where('school_id', $school_id);       
                $total_employee = $ci->db->count_all_results('employees'); 
                
                if($total_employee > $subs->employee_limit ){
                    error($ci->lang->line('upgrade_your_plan'));
                    return FALSE;   
                }else{                    
                    return TRUE;
                }
                
            }elseif($feature != '' && !$subs->{$feature}){ // upgrade your plan   
                
                error($ci->lang->line('upgrade_your_plan'));
                return FALSE;                
                
            }else{
                
                 return TRUE;
            }            
        }

        return TRUE;       
        
    }

}



if (!function_exists('check_permission')) {

    function check_permission($action) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');
        $operation_slug = $ci->router->fetch_class();
        $module_slug = $ci->router->fetch_module();

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);

        $result = $data[$role_id];
        if (!empty($result)) {
            $array = explode('|', $result);
            if (!$array[$action]) {
                error($ci->lang->line('permission_denied'));
                redirect('dashboard');
            }
        } else {
            error($ci->lang->line('permission_denied'));
            redirect('dashboard');
        }

        return TRUE;
    }

}

if (!function_exists('has_permission')) {

    function has_permission($action, $module_slug = null, $operation_slug = null) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);

        $result = @$data[$role_id];

        if (!empty($result)) {
            $array = explode('|', $result);
            return $array[$action];
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('create_log')) {

    function create_log($activity = null) {

        $ci = & get_instance();
        $data = array();
        
        if($ci->session->userdata('role_id') == SUPER_ADMIN){
            $data['school_id'] = 0;
        }else{
            $data['school_id'] = $ci->session->userdata('school_id');            
        }
        
        if(!$data['school_id']){ return;}
        
        $data['user_id'] = logged_in_user_id();
        $data['role_id'] = logged_in_role_id(); 
        $user = get_user_by_id($data['user_id']);
        
        $data['name'] = $user->name;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['activity'] = $activity;
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $ci->db->insert('activity_logs', $data);
    }
}




/* STRICT DATA ACCESS START*/


if (!function_exists('get_guardian_access_data')) {
    
 function get_guardian_access_data($type = NULL){
       
        
        $ci = & get_instance();
        
         if($ci->session->userdata('role_id') != GUARDIAN){
             return FALSE;
         }
        
        $school_id = $ci->session->userdata('school_id'); 
        $guardian_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
        
        $ci->db->select('E.student_id, E.roll_no, E.class_id, E.section_id, C.name AS class_name, SE.name AS section');
        $ci->db->from('enrollments AS E');
        $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
        $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $ci->db->where('E.academic_year_id', $school->academic_year_id);
        $ci->db->where('S.guardian_id', $guardian_id);
        $ci->db->where('S.school_id', $school_id);
        $result = $ci->db->get()->result();   
        $data = array();
        
       if(!empty($result )){
            if($type == 'class'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }
                
            }elseif($type == 'section'){

                foreach($result as $obj){
                    $data[] = $obj->section_id;
                }
            
            }elseif($type == 'student'){

                foreach($result as $obj){
                    $data[] = $obj->student_id;
                }
            }elseif($type == 'subject'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }  
                
                // Getting subject ids by classes
                $ci->db->select('S.*');
                $ci->db->from('subjects AS S');            
                $ci->db->where_in('S.class_id', implode(',', $data)); 
                $ci->db->order_by("S.id", "ASC");
                $subjects= $ci->db->get()->result();

                foreach($subjects as $obj){
                    $data[] = $obj->teacher_id;
                } 
                
            }
       }
       
       return $data;        
   }   
}


if (!function_exists('get_teacher_access_data')) {
    
 function get_teacher_access_data($type = NULL){
       
        $ci = & get_instance();
        
        if($ci->session->userdata('role_id') != TEACHER){
            return FALSE;
        }
        
        $school_id = $ci->session->userdata('school_id'); 
        $teacher_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
               
        $data = array();                 

        // checking in routine is there a teacher
        $ci->db->select('R.class_id');
        $ci->db->from('routines AS R');            
        $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('R.school_id', $school_id); 
        $ci->db->order_by("R.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }

        // checking in subject is there a teacher
        $ci->db->select('S.class_id');
        $ci->db->from('subjects AS S');                
        $ci->db->where('S.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('S.school_id', $school_id); 
        $ci->db->order_by("S.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }


        // checking in section is there a teacher
        $ci->db->select('S.class_id');
        $ci->db->from('sections AS S');                
        $ci->db->where('S.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('S.school_id', $school_id); 
        $ci->db->order_by("S.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }

        // checking in class is there a teacher
        $ci->db->select('C.id AS class_id');
        $ci->db->from('classes AS C');                
        $ci->db->where('C.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('C.school_id', $school_id); 
        $ci->db->order_by("C.id", "ASC");
        $result = $ci->db->get()->result();


        foreach($result as $obj){
            $data[] = $obj->class_id;
        }     
        
       
       return array_unique($data);        
   }   
}


if (!function_exists('get_student_access_data')) {
    
 function get_student_access_data($type = NULL){
       
        $ci = & get_instance();
         if($ci->session->userdata('role_id') != STUDENT){
             return FALSE;
         }
        
        $school_id = $ci->session->userdata('school_id'); 
        $student_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
               
        $data = array();
        
        if($type == 'student'){                

            $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
            $ci->db->from('routines AS R');
            $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
            $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
            $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id')); 
            $ci->db->order_by("R.id", "ASC");
            $result = $ci->db->get()->result();
            
            foreach($result as $obj){
                $data[] = $obj->class_id;
            }
        }elseif($type == 'subject'){
            
            $ci->db->select('S.*');
            $ci->db->from('subjects AS S');            
            $ci->db->where('S.class_id', $ci->session->userdata('class_id')); 
            $ci->db->order_by("S.id", "ASC");
            $result = $ci->db->get()->result();
            
            foreach($result as $obj){
                $data[] = $obj->teacher_id;
            }            
        }

       
       return $data;        
   } 

   if (!function_exists('get_type_of_school')) {

    function get_type_of_school() {
        $ci = & get_instance();
        return array(
            'nursery school' => $ci->lang->line('nursery_school'),
            'primary school' => $ci->lang->line('primary_school'),
            'secondary school' => $ci->lang->line('secondary_school'),
            'tertairy school' => $ci->lang->line('tertairy'),
            'university' => $ci->lang->line('university'),
            'kindergarten primary school' => $ci->lang->line('kindergarten_primary_school')
        );
    }

}

if (!function_exists('get_sponsorship_mode')) {

    function get_sponsorship_mode() {
        $ci = & get_instance();
        return array(
            'upe' => $ci->lang->line('upe'),
            'use' => $ci->lang->line('use'),
            'private' => $ci->lang->line('private')
        );
    }

}

if (!function_exists('get_form_of_school')) {

    function get_form_of_school() {
        $ci = & get_instance();
        return array(
            'single school' => $ci->lang->line('single_school'),
            'mixed school' => $ci->lang->line('mixed_school')
        );
    }

}

if (!function_exists('get_category_of_school')) {

    function get_category_of_school() {
        $ci = & get_instance();
        return array(
            'government aided' => $ci->lang->line('government_aided'),
            'private school' => $ci->lang->line('private_school'),
            'community school' => $ci->lang->line('community_school')
        );
    }

}

if (!function_exists('get_nature_of_school')) {

    function get_nature_of_school() {
        $ci = & get_instance();
        return array(
            'day school' => $ci->lang->line('day_school'),
            'boarding school' => $ci->lang->line('boarding_school'),
            'day and boarding' => $ci->lang->line('day_and_boarding')
        );
    }

}

if (!function_exists('get_school_facility_category')) {

    function get_school_facility_category() {
        $ci = & get_instance();
        return array(
            'healthy facility' => $ci->lang->line('healthy_facility'),
            'class room ' => $ci->lang->line('class_room'),
            'sports ground' => $ci->lang->line('sports_ground'),
            'houses' => $ci->lang->line('houses'),
            'furniture' => $ci->lang->line('furniture'),
            'kitchen' => $ci->lang->line('kitchen'),
            'school gardens' => $ci->lang->line('school_gardens'),
            'toilets' => $ci->lang->line('toilets'),
            'class room blocks' => $ci->lang->line('class_room_blocks')
        );
    }

}

if (!function_exists('get_school_facility_category_name')) {

    function get_school_facility_category_name() {
        $ci = & get_instance();
        return array(
            'sick bay' => $ci->lang->line('sick_bay'),
            'class room' => $ci->lang->line('class_room'),
            'pitches' => $ci->lang->line('pitches'),
            'houses' => $ci->lang->line('houses'),
            'furniture' => $ci->lang->line('furniture'),
            'kitchen' => $ci->lang->line('kitchen'),
            'school gardens' => $ci->lang->line('school_gardens'),
            'toilets' => $ci->lang->line('toilets'),
            'class room blocks' => $ci->lang->line('class_room_blocks')
        );
    }
}  

	if (!function_exists('get_relation_types')) {

    function get_relation_types() {
        $ci = & get_instance();
        return array(
            'father' => $ci->lang->line('father'),
            'mother' => $ci->lang->line('mother'),
            'sister' => $ci->lang->line('sister'),
            'brother' => $ci->lang->line('brother'),
            'uncle' => $ci->lang->line('uncle'),
            'maternal_uncle' => $ci->lang->line('maternal_uncle'),
            'other_relative' => $ci->lang->line('other_relative')
        );
    }

}

    if (!function_exists('get_toilet_type')) {

    function get_toilet_type() {
        $ci = & get_instance();
        $types = array('toilets' => $ci->lang->line('toilets'));
        return array(
            'boys toilets' => $ci->lang->line('boys_toilets'),
            'girls toilets' => $ci->lang->line('girls_toilets'),
            'teachers toilets' => $ci->lang->line('teachers_toilets'),
            'types' => $types
        );
    }

    }

    if (!function_exists('get_religion')) {

    function get_religion() {
        $ci = & get_instance();
        return array(
            'anglican' => $ci->lang->line('anglican'),
            'catholic' => $ci->lang->line('catholic'),
            'born again' => $ci->lang->line('born_again'),
            'muslim' => $ci->lang->line('muslim'),
            'seventh_day' => $ci->lang->line('seventh_day'),
            'others' => $ci->lang->line('others')
            );
        }
    }
}

/*STRICT DATA ACCESS END*/