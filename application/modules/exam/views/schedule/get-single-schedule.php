<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $schedule->school_name; ?></td>
        </tr>     
        <tr>
            <th><?php echo $this->lang->line('exam_term'); ?> </th>
            <td><?php echo $schedule->title; ?></td>
        </tr>     
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $schedule->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $schedule->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('exam_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($schedule->exam_date)); ?></td>
        </tr>
               
        <tr>
            <th><?php echo $this->lang->line('start_time'); ?></th>
            <td><?php echo $schedule->start_time; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('end_time'); ?></th>
            <td><?php echo $schedule->end_time; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('room_no'); ?></th>
            <td><?php echo $schedule->room_no; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $schedule->note; ?>   </td>
        </tr>
    </tbody>
</table>