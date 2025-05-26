<?php echo $this->lang->line('quick_link'); ?>:

<?php if(has_permission(VIEW, 'lessonplan', 'lesson')){ ?>
    <a href="<?php echo site_url('lessonplan/lesson/index'); ?>"><?php echo $this->lang->line('lesson'); ?></a>  
<?php } ?> 
<?php if(has_permission(VIEW, 'lessonplan', 'topic')){ ?>    
    | <a href="<?php echo site_url('lessonplan/topic/index'); ?>"><?php echo $this->lang->line('topic'); ?></a>  
<?php } ?> 
<?php if(has_permission(VIEW, 'lessonplan', 'timeline')){ ?>    
    | <a href="<?php echo site_url('lessonplan/timeline'); ?>"><?php echo $this->lang->line('lesson_time_line'); ?></a>  
<?php } ?>                                
 <?php if(has_permission(VIEW, 'lessonplan', 'status')){ ?>    
   | <a href="<?php echo site_url('lessonplan/status'); ?>"><?php echo $this->lang->line('lesson_status'); ?></a>  
<?php } ?>                                    
 <?php if(has_permission(VIEW, 'lessonplan', 'lessonplan')){ ?>    
    | <a href="<?php echo site_url('lessonplan/index'); ?>"><?php echo $this->lang->line('lesson_plan'); ?></a>  
<?php } ?>  