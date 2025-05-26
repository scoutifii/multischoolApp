<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'accounting', 'discount')){ ?>
     <a href="<?php echo site_url('accounting/discount/index'); ?>"><?php echo $this->lang->line('discount'); ?></a>                  
 <?php } ?> 

<?php if(has_permission(VIEW, 'accounting', 'feetype')){ ?>
   | <a href="<?php echo site_url('accounting/feetype/index'); ?>"><?php echo $this->lang->line('fee_type'); ?></a>                  
 <?php } ?> 

 <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>

    <?php if($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN){ ?>
         | <a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a>                    
    <?php }else{ ?>
         | <a href="<?php echo site_url('accounting/invoice/add'); ?>"><?php echo $this->lang->line('fee_collection'); ?></a>
         | <a href="<?php echo site_url('accounting/invoice/index'); ?>"><?php echo $this->lang->line('manage_invoice'); ?></a>
         | <a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a>    
     <?php } ?> 
 <?php } ?> 

<?php if(has_permission(VIEW, 'accounting', 'receipt')){ ?>   
       | <a href="<?php echo site_url('accounting/receipt/duereceipt'); ?>"><?php echo $this->lang->line('due_receipt'); ?></a>
       | <a href="<?php echo site_url('accounting/receipt/paidreceipt'); ?>"><?php echo $this->lang->line('paid_receipt'); ?></a>
<?php } ?>   
 <?php if(has_permission(VIEW, 'accounting', 'duefeeemail')){ ?>
    | <a href="<?php echo site_url('accounting/duefeeemail/index'); ?>"><?php echo $this->lang->line('due_fee_email'); ?></a>                  
 <?php } ?>
  <?php if(has_permission(VIEW, 'accounting', 'duefeesms')){ ?>
    | <a href="<?php echo site_url('accounting/duefeesms/index'); ?>"><?php echo $this->lang->line('due_fee_sms'); ?></a>                  
 <?php } ?>         

  <?php if(has_permission(VIEW, 'accounting', 'incomehead')){ ?>
   | <a href="<?php echo site_url('accounting/incomehead/index'); ?>"><?php echo $this->lang->line('income_head'); ?></a>                  
 <?php } ?> 
  <?php if(has_permission(VIEW, 'accounting', 'income')){ ?>
    | <a href="<?php echo site_url('accounting/income/index'); ?>"><?php echo $this->lang->line('income'); ?></a>                     
 <?php } ?>  
 <?php if(has_permission(VIEW, 'accounting', 'exphead')){ ?>
    | <a href="<?php echo site_url('accounting/exphead/index'); ?>"><?php echo $this->lang->line('expenditure_head'); ?></a>                  
 <?php } ?> 
 <?php if(has_permission(VIEW, 'accounting', 'expenditure')){ ?>
    | <a href="<?php echo site_url('accounting/expenditure/index'); ?>"><?php echo $this->lang->line('expenditure'); ?></a>                  
 <?php } ?>       
</div>
