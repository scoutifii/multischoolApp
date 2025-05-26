<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'administrator', 'setting')){ ?>
    <a href="<?php echo site_url('administrator/setting/index'); ?>"><?php echo $this->lang->line('general_setting'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'school')){ ?>
   | <a href="<?php echo site_url('administrator/school/index'); ?>"><?php echo $this->lang->line('manage_school'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'payment')){ ?>
    | <a href="<?php echo site_url('administrator/payment/index'); ?>"><?php echo $this->lang->line('payment_setting'); ?></a>
<?php } ?>                    
<?php if(has_permission(VIEW, 'administrator', 'sms')){ ?>
    | <a href="<?php echo site_url('administrator/sms/index'); ?>"><?php echo $this->lang->line('sms_setting'); ?></a>
<?php } ?>      
<?php if(has_permission(VIEW, 'administrator', 'emailsetting')){ ?>
    | <a href="<?php echo site_url('administrator/emailsetting/index'); ?>"><?php echo $this->lang->line('email_setting'); ?></a>
<?php } ?>      
<?php if(has_permission(VIEW, 'administrator', 'year')){ ?>
    | <a href="<?php echo site_url('administrator/year/index'); ?>"><?php echo $this->lang->line('academic_year'); ?></a>
<?php } ?>                  
<?php if(has_permission(VIEW, 'administrator', 'role')){ ?>
   | <a href="<?php echo site_url('administrator/role/index'); ?>"><?php echo $this->lang->line('user_role'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'permission')){ ?>
   | <a href="<?php echo site_url('administrator/permission/index'); ?>"><?php echo $this->lang->line('role_permission'); ?></a>                   
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'superadmin')){ ?>
   | <a href="<?php echo site_url('administrator/superadmin/index'); ?>"><?php echo $this->lang->line('super_admin'); ?></a>                
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'user')){ ?>
   | <a href="<?php echo site_url('administrator/user/index'); ?>"><?php echo $this->lang->line('manage_user'); ?></a>                
<?php } ?>
<?php if(has_permission(EDIT, 'administrator', 'password')){ ?>
   | <a href="<?php echo site_url('administrator/password/index'); ?>"><?php echo $this->lang->line('reset_user_password'); ?></a>                   
<?php } ?>                
<?php if(has_permission(EDIT, 'administrator', 'username')){ ?>
   | <a href="<?php echo site_url('administrator/username/index'); ?>"><?php echo $this->lang->line('reset_username'); ?></a>                   
<?php } ?>                
<?php if(has_permission(VIEW, 'administrator', 'usercredential')){ ?>
   | <a href="<?php echo site_url('administrator/usercredential/index'); ?>"> <?php echo $this->lang->line('user_credential'); ?></a>                   
<?php } ?>                
<?php if(has_permission(VIEW, 'administrator', 'activitylog')){ ?>
   | <a href="<?php echo site_url('administrator/activitylog/index'); ?>"><?php echo $this->lang->line('activity_log'); ?></a>                  
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'feedback')){ ?>
   | <a href="<?php echo site_url('administrator/feedback/index'); ?>"><?php echo $this->lang->line('feedback'); ?></a>                  
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'backup')){ ?>
   | <a href="<?php echo site_url('administrator/backup/index'); ?>"><?php echo $this->lang->line('backup'); ?></a>                  
<?php } ?>
<?php if(has_permission(VIEW, 'administrator', 'districtadmin')){ ?>
   | <a href="<?php echo site_url('administrator/districtadmin/index'); ?>"><?php echo $this->lang->line('district_admin'); ?></a>                  
<?php } ?>
</div>
