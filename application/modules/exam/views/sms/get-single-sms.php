<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $sms->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('session_year'); ?></th>
            <td><?php echo $sms->session_year; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('exam_term'); ?></th>
            <td><?php echo $sms->exam_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $sms->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('receiver_type'); ?></th>
            <td><?php echo $sms->receiver_type; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('receiver'); ?></th>
            <td><?php echo $sms->receivers; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('gateway'); ?></th>
            <td><?php echo $this->lang->line($sms->sms_gateway); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('sms'); ?></th>
            <td><?php echo $sms->body; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('send_date'); ?></th>
            <td><?php echo get_nice_time($sms->created_at); ?></td>
        </tr> 
    </tbody>
</table>
