 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'certificate', 'type')){ ?>
    <a href="<?php echo site_url('certificate/type/index'); ?>"><?php echo $this->lang->line('certificate_type'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'certificate', 'certificate')){ ?>
   | <a href="<?php echo site_url('certificate/index'); ?>"><?php echo $this->lang->line('generate_certificate'); ?></a>
<?php } ?>

