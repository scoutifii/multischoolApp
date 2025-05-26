<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $income->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('session_year'); ?></th>
            <td><?php echo $income->session_year; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('income_head'); ?></th>
            <td><?php echo $income->head; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('income_method'); ?></th>
            <td><?php echo $this->lang->line($income->payment_method); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('amount'); ?></th>
            <td><?php echo $income->net_amount; ?></td>
        </tr>
        <?php if($income->payment_method == 'cheque'){ ?>
         <tr>
            <th><?php echo $this->lang->line('bank_name'); ?></th>
            <td><?php echo $income->bank_name; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('cheque_number'); ?></th>
            <td><?php echo $income->cheque_no; ?></td>
        </tr> 
        <?php } ?>
        <tr>
            <th><?php echo $this->lang->line('date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($income->date)); ?></td>
        </tr> 
       
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $income->note; ?></td>
        </tr> 
    </tbody>
</table>
