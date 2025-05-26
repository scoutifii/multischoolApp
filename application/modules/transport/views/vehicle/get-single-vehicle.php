<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $vehicle->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('vehicle_number'); ?></th>
            <td><?php echo $vehicle->number; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('vehicle_model'); ?></th>
            <td><?php echo $vehicle->model; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('driver'); ?></th>
            <td><?php echo $vehicle->driver; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('vehicle_license'); ?></th>
            <td><?php echo $vehicle->license; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('vehicle_contact'); ?></th>
            <td><?php echo $vehicle->contact; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $vehicle->note; ?></td>
        </tr>       
        
        <tr>
            <th><?php echo $this->lang->line('created'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($vehicle->created_at)); ?></td>
        </tr>       
    </tbody>
</table>