<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'leave', 'type')){ ?>
    <a href="<?php echo site_url('leave/type/index'); ?>"> <?php echo $this->lang->line('leave_type'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'leave', 'application')){ ?>
   | <a href="<?php echo site_url('leave/application/index'); ?>">  <?php echo $this->lang->line('leave_application'); ?></a>
<?php } ?>               
<?php if(has_permission(VIEW, 'leave', 'approve')){ ?>
   | <a href="<?php echo site_url('leave/approve/index'); ?>"> <?php echo $this->lang->line('approved_application'); ?> </a>
<?php } ?>               
<?php if(has_permission(VIEW, 'leave', 'waiting')){ ?>
   | <a href="<?php echo site_url('leave/waiting/index'); ?>"> <?php echo $this->lang->line('waiting_application'); ?> </a>
<?php } ?>               
<?php if(has_permission(VIEW, 'leave', 'decline')){ ?>
   | <a href="<?php echo site_url('leave/decline/index'); ?>"> <?php echo $this->lang->line('declined_application'); ?> </a>
<?php } ?> 
</div>   