<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $assignment->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $assignment->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $assignment->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $assignment->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('deadline'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($assignment->deadline)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('assignment'); ?></th>
            <td>
                <?php if($assignment->assignment){ ?>
                <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/assignment/<?php echo $assignment->assignment; ?>"  class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php } ?>
            </td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $assignment->note; ?>   </td>
        </tr>
    </tbody>
</table>
