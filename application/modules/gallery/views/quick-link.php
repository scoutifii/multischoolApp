<div  class="well">
 <span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'gallery', 'gallery')){ ?>
    <a href="<?php echo site_url('gallery/index'); ?>"><?php echo $this->lang->line('manage_gallery'); ?> </a>
<?php } ?>
<?php if(has_permission(VIEW, 'gallery', 'image')){ ?>
  |  <a href="<?php echo site_url('gallery/image/index'); ?>"><?php echo $this->lang->line('manage_gallery_image'); ?></a>
<?php } ?> 
</div>