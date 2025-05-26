<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $room->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('hostel'); ?></th>
            <td><?php echo $room->hostel_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('room_no'); ?> </th>
            <td><?php echo $room->room_no; ?></td>
        </tr>   
        <tr>
            <th><?php echo $this->lang->line('room_type'); ?></th>
            <td><?php echo $this->lang->line($room->room_type); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('seat_total'); ?></th>
            <td><?php echo $room->total_seat; ?></td>
        </tr>
                   
        <tr>
            <th><?php echo $this->lang->line('cost_per_seat'); ?> </th>
            <td><?php echo $room->cost; ?></td>
        </tr>   
        <tr>
            <th><?php echo $this->lang->line('note'); ?> </th>
            <td><?php echo $room->note; ?></td>
        </tr>   
        <tr>
            <th><?php echo $this->lang->line('created'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($room->created_at)); ?></td>
        </tr>       
    </tbody>
</table>