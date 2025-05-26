<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $slider->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $slider->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('image'); ?></th>
            <td>
                <?php if($slider->image){ ?>
                    <img src="<?php echo UPLOAD_PATH; ?>/slider/<?php echo $slider->image; ?>" alt=""  class="img-responsive" /><br/><br/>
                <?php } ?>
            </td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('created'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($slider->created_at)); ?></td>
        </tr>       
    </tbody>
</table>
