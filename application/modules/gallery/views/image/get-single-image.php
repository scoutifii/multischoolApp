<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $image->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $image->title; ?></td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('caption'); ?></th>
            <td><?php echo $image->caption; ?></td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('image'); ?></th>
            <td>
                <?php if($image->image){ ?>
                <img src="<?php echo UPLOAD_PATH; ?>/gallery/<?php echo $image->image; ?>" alt="" style="width: 100%;"/><br/><br/>
                <?php } ?>
            </td>
        </tr>         
    </tbody>
</table>
