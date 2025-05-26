<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $suggestion->school_name; ?></td>
        </tr>     
        <tr>
            <th><?php echo $this->lang->line('title'); ?> </th>
            <td><?php echo $suggestion->title; ?></td>
        </tr>     
        <tr>
            <th><?php echo $this->lang->line('exam_term'); ?> </th>
            <td><?php echo $suggestion->exam_title; ?></td>
        </tr>     
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $suggestion->class_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $suggestion->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('suggestion'); ?></th>
            <td>
                <?php if($suggestion->suggestion){ ?>
                <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/suggestion/<?php echo $suggestion->suggestion; ?>"  class="btn btn-success btn-xs"> <i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?> </a> <br/>
                <?php } ?>
            </td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $suggestion->note; ?>   </td>
        </tr>
    </tbody>
</table>