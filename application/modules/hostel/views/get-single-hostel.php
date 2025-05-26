<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_school'); ?></th>
            <td><?php echo $hostel->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('hostel'); ?></th>
            <td><?php echo $hostel->name; ?></td>
        </tr>   
        <tr>
            <th><?php echo $this->lang->line('hostel_type'); ?></th>
            <td><?php echo $this->lang->line($hostel->type); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('address'); ?></th>
            <td><?php echo $hostel->address; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $hostel->note; ?></td>
        </tr>      
        <tr>
            <th><?php echo $this->lang->line('created'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($hostel->created_at)); ?></td>
        </tr>       
    </tbody>
</table>