<span><?php echo $this->lang->line('quick_link'); ?>:</span>                
<a href="<?php echo site_url('profile'); ?>"><?php echo $this->lang->line('my_profile'); ?></a>
| <a href="<?php echo site_url('profile/password'); ?>"><?php echo $this->lang->line('reset_password'); ?></a>

<?php if($this->session->userdata('role_id') == GUARDIAN){ ?>
| <a href="<?php echo site_url('guardian/invoice'); ?>"><?php echo $this->lang->line('invoice'); ?></a>
| <a href="<?php echo site_url('guardian/feedback'); ?>"><?php echo $this->lang->line('feedback'); ?></a>
<?php } ?>
<?php if($this->session->userdata('role_id') == STUDENT){ ?>
| <a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('invoice'); ?></a>
<?php } ?>

<?php if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>  
   <?php if(has_permission(VIEW, 'usercomplain', 'usercomplain')){ ?>
       | <a href="<?php echo site_url('usercomplain/index'); ?>"><?php echo $this->lang->line('complain'); ?></a>
   <?php } ?>
   <?php if(has_permission(VIEW, 'userleave', 'userleave')){ ?>
       | <a href="<?php echo site_url('userleave/index'); ?>"><?php echo $this->lang->line('leave_application'); ?></a>    
   <?php } ?>
<?php } ?>                
| <a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>   