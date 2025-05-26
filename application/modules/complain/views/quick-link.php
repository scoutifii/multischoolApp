 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'complain', 'type')){ ?>
    <a href="<?php echo site_url('complain/type/index'); ?>"><?php echo $this->lang->line('complain_type'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'complain', 'complain')){ ?>
   | <a href="<?php echo site_url('complain/index'); ?>"> <?php echo $this->lang->line('manage_complain'); ?></a>
<?php } ?>  
