<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>                
<?php if(has_permission(VIEW, 'card', 'idsetting')){ ?>
     <a href="<?php echo site_url('card/idsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a>
<?php } ?>    
 <?php if(has_permission(VIEW, 'card', 'admitsetting')){ ?>
      |  <a href="<?php echo site_url('card/admitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a>
<?php } ?>                        
<?php if(has_permission(VIEW, 'card', 'schoolidsetting')){ ?>
    <a href="<?php echo site_url('card/schoolidsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a>
<?php } ?>       
<?php if(has_permission(VIEW, 'card', 'schooladmitsetting')){ ?>
      | <a href="<?php echo site_url('card/schooladmitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'card', 'teacher')){ ?>
    | <a href="<?php echo site_url('card/teacher/index'); ?>"><?php echo $this->lang->line('teacher_id_card'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'card', 'employee')){ ?>
   | <a href="<?php echo site_url('card/employee/index'); ?>"><?php echo $this->lang->line('employee_id_card'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'card', 'student')){ ?>  
   | <a href="<?php echo site_url('card/student/index'); ?>"><?php echo $this->lang->line('student_id_card'); ?></a>
<?php } ?>  
<?php if(has_permission(VIEW, 'card', 'admit')){ ?>  
   | <a href="<?php echo site_url('card/admit/index'); ?>"><?php echo $this->lang->line('student_admit_card'); ?></a>
<?php } ?>  
</div>
