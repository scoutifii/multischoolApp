<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'transport', 'vehicle')){ ?>
    <a href="<?php echo site_url('transport/vehicle/index'); ?>"><?php echo $this->lang->line('vehicle'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'transport', 'route')){ ?>
    | <a href="<?php echo site_url('transport/route/index'); ?>"> <?php echo $this->lang->line('transport_route'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'transport', 'member')){ ?>
    | <a href="<?php echo site_url('transport/member/index'); ?>"><?php echo $this->lang->line('transport_member'); ?></a>                    
<?php } ?>
</div>