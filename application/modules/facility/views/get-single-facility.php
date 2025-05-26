<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="16%"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $facilities->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $facilities->facility_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('facility'); ?> <?php echo $this->lang->line('number'); ?></th>
            <td><?php echo $facilities->facility_no; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $facilities->category_name; ?></td>
        </tr>       
        
    </tbody>
</table>
