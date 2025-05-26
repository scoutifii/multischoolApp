<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $feetype->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('fee_type'); ?> / <?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $feetype->title; ?></td>
        </tr>
        <?php if($feetype->head_type == 'fee'){ ?>
            <tr style="background-color: lightgray;">
                <th><?php echo $this->lang->line('class'); ?></th>             
                <th><?php echo $this->lang->line('amount'); ?></th>             
            </tr>
            <?php foreach($classes as $obj){ ?>
            <?php $fee_amount = get_fee_amount($feetype->id, $obj->id); ?>
                <tr>
                    <th><?php echo $obj->name; ?></th>
                    <td><?php echo @$fee_amount->fee_amount; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
            
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $feetype->note; ?>   </td>
        </tr>
    </tbody>
</table>
