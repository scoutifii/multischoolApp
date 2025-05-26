<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $notice->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $notice->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($notice->date)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('notice_for'); ?></th>
            <td><?php echo $notice->name  ? $notice->name : $this->lang->line('all'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('notice'); ?></th>
            <td><?php echo $notice->notice; ?></td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('is_view_on_web'); ?></th>
            <td><?php echo $notice->is_view_on_web ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>        
    </tbody>
</table>
