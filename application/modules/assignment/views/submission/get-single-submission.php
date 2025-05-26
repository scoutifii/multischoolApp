<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $submit->school_name; ?></td>        
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $submit->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $submit->class_name; ?></td>        
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $submit->section; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $submit->subject; ?></td>
            <th><?php echo $this->lang->line('submitted_by'); ?></th>
            <td><?php echo $submit->name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('deadline'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->deadline)); ?></td>
            <th><?php echo $this->lang->line('submitted_at'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->submitted_at)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('submission'); ?></th>
            <td colspan="3">
                <?php                
                    $submit_type = explode(".", $submit->submission);
                    $extension = strtolower($submit_type[count($submit_type) - 1]);                
                ?>
                <?php if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif'){ ?>                
                    <a target="_blank" href="<?php echo UPLOAD_PATH; ?>assignment-submission/<?php echo $submit->submission; ?>"  class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php }else{ ?>
                    <iframe src="http://docs.google.com/gview?url='<?php echo UPLOAD_PATH.'assignment-submission/'.$submit->submission; ?>'&embedded=true" style="width:100%; height:350px;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <?php } ?> 
            </td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td colspan="3"><?php echo $submit->note; ?>   </td>
        </tr>
    </tbody>
</table>
