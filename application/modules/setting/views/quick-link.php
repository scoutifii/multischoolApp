<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'setting', 'setting')  && $this->session->userdata('role_id') != SUPER_ADMIN){ ?>
    <a href="<?php echo site_url('setting/index'); ?>"><?php echo $this->lang->line('school_setting'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'setting', 'payment')){ ?>
   | <a href="<?php echo site_url('setting/payment/index'); ?>"><?php echo $this->lang->line('payment_setting'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'setting', 'sms')){ ?>
   | <a href="<?php echo site_url('setting/sms/index'); ?>"><?php echo $this->lang->line('sms_setting'); ?></a>                    
<?php } ?>                
<?php if(has_permission(VIEW, 'setting', 'emailsetting')){ ?>
   | <a href="<?php echo site_url('setting/emailsetting/index'); ?>"><?php echo $this->lang->line('email_setting'); ?></a>                    
<?php } ?> 
</div> 