<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
         <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td><?php echo $topic->school_name; ?></td>
        </tr> 
         <tr>
            <th width="20%"> <?php echo $this->lang->line('academic_year'); ?> </th>
            <td><?php echo $topic->session_year; ?></td>
        </tr> 
        <tr>
            <th width="20%"> <?php echo $this->lang->line('class'); ?> </th>
            <td><?php echo $topic->class_name; ?></td>
        </tr>       
     
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $topic->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('lesson'); ?></th>
            <td><?php echo $topic->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('topic'); ?></th>
            <td>
               <?php foreach($topic_details as $obj){ ?>
                       <?php echo $obj->title; ?><br/>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $topic->note; ?></td>
        </tr>             
    </tbody>
</table>