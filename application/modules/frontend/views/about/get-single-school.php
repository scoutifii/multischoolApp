<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_school'); ?></th>
            <td><?php echo $school->school_name; ?></td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('about_school'); ?></th>
            <td><?php echo $school->about_text; ?></td>
        </tr>
        <?php if($school->about_image){ ?>
        <tr>
            <th><?php echo $this->lang->line('image'); ?></th>
            <td>                
                <img src="<?php echo UPLOAD_PATH; ?>/about/<?php echo $school->about_image; ?>" alt=""  class="img-responsive" /><br/><br/>
            </td>
        </tr>
         <?php } ?>
        <tr>
            <th><?php echo $this->lang->line('modified'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($school->modified_at)); ?></td>
        </tr>        
    </tbody>
</table>
