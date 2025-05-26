<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'payroll', 'grade')){ ?>
    <a href="<?php echo site_url('payroll/grade/index'); ?>"><?php echo $this->lang->line('salary_grade'); ?></a>                   
<?php } ?>              
<?php if(has_permission(VIEW, 'payroll', 'payment')){ ?>
  | <a href="<?php echo site_url('payroll/payment/index'); ?>"><?php echo $this->lang->line('salary_payment'); ?></a>                  
<?php } ?> 
<?php if(has_permission(VIEW, 'payroll', 'history')){ ?>
  | <a href="<?php echo site_url('payroll/history/index'); ?>"><?php echo $this->lang->line('salary_history'); ?></a>                  
<?php } ?> 
</div>