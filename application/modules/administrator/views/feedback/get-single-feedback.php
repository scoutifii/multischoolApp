<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $feedback->school_name; ?></td>
        </tr>         
        <tr>
            <th><?php echo $this->lang->line('is_publish'); ?></th>
            <td><?php echo $feedback->is_publish ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('feedback'); ?></th>
            <td><?php echo $feedback->feedback; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($feedback->created_at)); ?></td>
        </tr>
    </tbody>
</table>