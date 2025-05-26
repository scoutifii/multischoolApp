<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'announcement', 'notice')){ ?>
    <a href="<?php echo site_url('announcement/notice/index'); ?>"><?php echo $this->lang->line('manage_notice'); ?></a>
<?php } ?>    
<?php if(has_permission(VIEW, 'announcement', 'news')){ ?>
   | <a href="<?php echo site_url('announcement/news/index'); ?>"><?php echo $this->lang->line('manage_news'); ?></a>
<?php } ?>    
<?php if(has_permission(VIEW, 'announcement', 'holiday')){ ?>
   | <a href="<?php echo site_url('announcement/holiday/index'); ?>"><?php echo $this->lang->line('manage_holiday'); ?></a>                    
<?php } ?>  
</div> 
