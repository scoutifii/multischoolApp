<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $dispatch->school_name; ?></td> 
        </tr>
        <tr>
            <th><?php echo $this->lang->line('to_title'); ?></th>
            <td><?php echo $dispatch->to_title; ?></td> 
        </tr>
        <tr>
            <th><?php echo $this->lang->line('reference'); ?></th>
            <td><?php echo $dispatch->reference; ?></td> 
        </tr>
        <tr>
            <th><?php echo $this->lang->line('address'); ?></th>
            <td><?php echo $dispatch->address; ?></td> 
        </tr>             
        <tr>
            <th><?php echo $this->lang->line('from_title'); ?> </th>
            <td><?php echo $dispatch->from_title; ?></td> 
        </tr>        
        <tr>      
            <th><?php echo $this->lang->line('dispatch_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($dispatch->dispatch_date)); ?></td>
        </tr>          
       
        <tr>              
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $dispatch->note; ?></td>
        </tr>
        
        <tr>                
            <th><?php echo $this->lang->line('attachment'); ?></th>
            <td>
                <?php if($dispatch->attachment){ ?>
                <a href="<?php echo UPLOAD_PATH; ?>/postal/<?php echo $dispatch->attachment; ?>"  target="_blank" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php } ?>
            </td>
        </tr>    
    </tbody>
</table>
