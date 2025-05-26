<div  class="well">
  <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'hrm', 'designation')){ ?>
    <a href="<?php echo site_url('hrm/designation/index'); ?>"><?php echo $this->lang->line('manage_designation'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'hrm', 'employee')){ ?>
   | <a href="<?php echo site_url('hrm/employee/index'); ?>"><?php echo $this->lang->line('manage_employee'); ?></a>
<?php } ?> 
</div>     