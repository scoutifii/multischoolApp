<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school'); ?></th>
            <td><?php echo $subject->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?> / <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $subject->name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject_code'); ?></th>
            <td><?php echo $subject->code; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('author'); ?></th>
            <td><?php echo $subject->author; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('type'); ?></th>
            <td><?php echo $this->lang->line($subject->type); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $subject->class_name; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('teacher'); ?></th>
            <td><?php echo $subject->teacher; ?>   </td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $subject->note; ?>   </td>
        </tr>
    </tbody>
</table>
