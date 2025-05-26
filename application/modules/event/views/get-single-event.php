<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $event->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $event->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('event_for'); ?> </th>
            <td><?php echo $event->name ? $event->name : $this->lang->line('all'); ?></td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('event_place'); ?> </th>
            <td><?php echo $event->event_place; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('from_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($event->event_from)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('to_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($event->event_to)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('image'); ?></th>
            <td>
                <?php if($event->image){ ?>
                <img src="<?php echo UPLOAD_PATH; ?>/event/<?php echo $event->image; ?>" alt=""  /><br/><br/>
                <?php } ?>
            </td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $event->note; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_view_on_web'); ?></th>
            <td><?php echo $event->is_view_on_web ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr> 
    </tbody>
</table>
