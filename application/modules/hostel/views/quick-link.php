 <div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'hostel', 'hostel')){ ?>
    <a href="<?php echo site_url('hostel/index'); ?>"><?php echo $this->lang->line('manage_hostel'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'hostel', 'room')){ ?>
   | <a href="<?php echo site_url('hostel/room/index'); ?>"><?php echo $this->lang->line('manage_room'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'hostel', 'member')){ ?>
   | <a href="<?php echo site_url('hostel/member/index'); ?>"><?php echo $this->lang->line('hostel_member'); ?></a>                    
<?php } ?>
</div>