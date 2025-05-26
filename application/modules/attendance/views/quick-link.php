<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'attendance', 'student')){ ?>
    <a href="<?php echo site_url('attendance/student/index'); ?>"><?php echo $this->lang->line('student_attendance'); ?></a>
<?php } ?>
 <?php if(has_permission(VIEW, 'attendance', 'teacher')){ ?>
   | <a href="<?php echo site_url('attendance/teacher/index'); ?>"><?php echo $this->lang->line('teacher_attendance'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'attendance', 'employee')){ ?>
   | <a href="<?php echo site_url('attendance/employee/index'); ?>"><?php echo $this->lang->line('employee_attendance'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'attendance', 'absentemail')){ ?>
   | <a href="<?php echo site_url('attendance/absentemail/index'); ?>"><?php echo $this->lang->line('absent_email'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'attendance', 'absentsms')){ ?>
   | <a href="<?php echo site_url('attendance/absentsms/index'); ?>"><?php echo $this->lang->line('absent_sms'); ?></a>                    
<?php } ?>
</div>