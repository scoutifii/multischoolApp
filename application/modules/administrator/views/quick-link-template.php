<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>                
<?php if(has_permission(VIEW, 'administrator', 'emailtemplate')){ ?>
   <a href="<?php echo site_url('administrator/emailtemplate/index'); ?>"><?php echo $this->lang->line('email_template'); ?></a>                  
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'smstemplate')){ ?>
   | <a href="<?php echo site_url('administrator/smstemplate/index'); ?>"><?php echo $this->lang->line('sms_template'); ?></a>                  
<?php } ?>  
</div> 