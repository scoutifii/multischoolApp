<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'manageschool', 'region')){ ?>
 	<a href="<?php echo site_url('manageschool/region'); ?>"><?php echo $this->lang->line('region'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'manageschool', 'subregion')){ ?>
| <a href="<?php echo site_url('manageschool/subregion'); ?>"><?php echo $this->lang->line('subregion'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'manageschool', 'district')){ ?>
| <a href="<?php echo site_url('manageschool/district'); ?>"><?php echo $this->lang->line('district'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'manageschool', 'subcounty')){ ?>
| <a href="<?php echo site_url('manageschool/subcounty'); ?>"><?php echo $this->lang->line('subcounty'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'manageschool', 'parish')){ ?>
| <a href="<?php echo site_url('manageschool/parish'); ?>"><?php echo $this->lang->line('parish'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'manageschool', 'village')){ ?>
| <a href="<?php echo site_url('manageschool/village'); ?>"><?php echo $this->lang->line('village'); ?></a>
<?php } ?>