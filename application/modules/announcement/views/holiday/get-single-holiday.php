<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $holiday->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $holiday->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('from_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($holiday->date_from)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('to_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($holiday->date_to)); ?></td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $holiday->note; ?></td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('is_view_on_web'); ?></th>
            <td><?php echo $holiday->is_view_on_web ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr> 
    </tbody>
</table>
