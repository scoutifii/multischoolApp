<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school'); ?></th>
            <td><?php echo $syllabus->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('session_year'); ?> </th>
            <td><?php echo $syllabus->session_year; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $syllabus->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $syllabus->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $syllabus->subject; ?></td>
        </tr>
        <?php if($syllabus->syllabus){ ?>
            <tr>
                <th><?php echo $this->lang->line('syllabus'); ?></th>
                <td>
                    <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/syllabus/<?php echo $syllabus->syllabus; ?>" class="btn btn-success btn-xs"> <i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/>
                </td>
            </tr>        
        <?php } ?> 
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $syllabus->note; ?>   </td>
        </tr>
    </tbody>
</table>
