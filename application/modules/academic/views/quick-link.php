<div  class="well">
<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
 	<a href="<?php echo site_url('teacher'); ?>"><?php echo $this->lang->line('teacher'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'teacher', 'lecture')){ ?>
| <a href="<?php echo site_url('teacher/lecture'); ?>"><?php echo $this->lang->line('class_lecture'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'classes')){ ?>
| <a href="<?php echo site_url('academic/classes'); ?>"><?php echo $this->lang->line('class'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'liveclass')){ ?>
| <a href="<?php echo site_url('academic/liveclass'); ?>"><?php echo $this->lang->line('live_class'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'material')){ ?>
| <a href="<?php echo site_url('academic/material'); ?>"><?php echo $this->lang->line('material'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'promotion')){ ?>
| <a href="<?php echo site_url('academic/promotion'); ?>"><?php echo $this->lang->line('promotion'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'routine')){ ?>
| <a href="<?php echo site_url('academic/routine'); ?>"><?php echo $this->lang->line('routine'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'section')){ ?>
| <a href="<?php echo site_url('academic/section'); ?>"><?php echo $this->lang->line('section'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'subject')){ ?>
| <a href="<?php echo site_url('academic/subject'); ?>"><?php echo $this->lang->line('subject'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'syllabus')){ ?>
| <a href="<?php echo site_url('academic/syllabus'); ?>"><?php echo $this->lang->line('syllabus'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'lessonplan')){ ?>
| <a href="<?php echo site_url('academic/lessonplan'); ?>"><?php echo $this->lang->line('lesson_plan'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'term')){ ?>
| <a href="<?php echo site_url('academic/term'); ?>"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('term'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'transfer')){ ?>
| <a href="<?php echo site_url('academic/transfer'); ?>"><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('transfer'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'studenttransfer')){ ?>
| <a href="<?php echo site_url('academic/studenttransfer'); ?>"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('transfer'); ?></a>
<?php } ?>
</div>