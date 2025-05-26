 <div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'frontend', 'frontend')){ ?>
   <a href="<?php echo site_url('frontend/index'); ?>"><?php echo $this->lang->line('frontend_page'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'frontend', 'slider')){ ?>
   | <a href="<?php echo site_url('frontend/slider/index'); ?>"><?php echo $this->lang->line('manage_slider'); ?> </a>
<?php } ?>
<?php if(has_permission(VIEW, 'frontend', 'about')){ ?>
   | <a href="<?php echo site_url('frontend/about/index'); ?>"><?php echo $this->lang->line('about_school'); ?></a>
<?php } ?>

<?php if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>   
    <?php if(has_permission(VIEW, 'setting', 'setting')){ ?>                   
       | <a href="<?php echo site_url('setting/index'); ?>"><?php echo $this->lang->line('frontend_setting'); ?></a>
    <?php } ?>
<?php }else{ ?>
       <?php if(has_permission(VIEW, 'administrator', 'school')){ ?>   
          | <a href="<?php echo site_url('administrator/school/index'); ?>"> <?php echo $this->lang->line('school_setting'); ?></a>
        <?php } ?>
<?php } ?>

<?php if(has_permission(VIEW, 'announcement', 'notice')){ ?>
   | <a href="<?php echo site_url('announcement/notice/index'); ?>"><?php echo $this->lang->line('manage_notice'); ?></a>
<?php } ?>    
<?php if(has_permission(VIEW, 'announcement', 'news')){ ?>
   | <a href="<?php echo site_url('announcement/news/index'); ?>"><?php echo $this->lang->line('manage_news'); ?></a>
<?php } ?>    
<?php if(has_permission(VIEW, 'announcement', 'holiday')){ ?>
   | <a href="<?php echo site_url('announcement/holiday/index'); ?>"><?php echo $this->lang->line('manage_holiday'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
  | <a href="<?php echo site_url('teacher/index'); ?>"><?php echo $this->lang->line('manage_teacher'); ?> </a>                    
<?php } ?>   
<?php if(has_permission(VIEW, 'hrm', 'employee')){ ?>
   | <a href="<?php echo site_url('hrm/employee/index'); ?>"><?php echo $this->lang->line('manage_employee'); ?> / <?php echo $this->lang->line('staff'); ?></a>
<?php } ?>   
 </div>               