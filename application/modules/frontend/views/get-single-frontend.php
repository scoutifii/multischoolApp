<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $frontend->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $frontend->page_title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('description'); ?></th>
            <td><?php echo $frontend->page_description; ?></td>
        </tr>
        <?php if($frontend->page_image){ ?>
        <tr>
            <th><?php echo $this->lang->line('image'); ?></th>
            <td>                
                <img src="<?php echo UPLOAD_PATH; ?>/page/<?php echo $frontend->page_image; ?>" alt=""  class="img-responsive" /><br/><br/>
            </td>
        </tr>
         <?php } ?>
        <tr>
            <th><?php echo $this->lang->line('modified'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($frontend->created_at)); ?></td>
        </tr>        
    </tbody>
</table>
