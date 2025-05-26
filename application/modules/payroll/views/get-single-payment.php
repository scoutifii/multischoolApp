<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="20%"><?php echo $this->lang->line('school_name'); ?></th>
            <td ><?php echo $payment->school_name; ?></td>        
            <th><?php echo $this->lang->line('month'); ?></th>
            <td ><?php echo date('M Y', strtotime('1-'.$payment->salary_month)); ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('grade_name'); ?></th>
            <td ><?php echo $payment->grade_name; ?></td>       
            <th><?php echo $this->lang->line('salary_type'); ?></th>
            <td ><?php echo $this->lang->line(strtolower($payment->salary_type)); ?></td>
        </tr>
        
        <?php if(strtolower($payment->salary_type) == 'monthly'){ ?>
            <tr>
                <th><?php echo $this->lang->line('basic_salary'); ?></th>
                <td ><?php echo $payment->basic_salary; ?></td>            
                <th><?php echo $this->lang->line('house_rent'); ?></th>
                <td ><?php echo $payment->house_rent; ?></td>
            </tr>
            
            <tr>
                <th><?php echo $this->lang->line('transport_allowance'); ?></th>
                <td ><?php echo $payment->transport; ?></td>           
                <th><?php echo $this->lang->line('medical_allowance'); ?></th>
                <td ><?php echo $payment->medical; ?></td>
            </tr>
            
            <tr>                       
                <th><?php echo $this->lang->line('over_time_hourly_rate'); ?></th>
                <td colspan="3"><?php echo $payment->over_time_hourly_rate; ?></td>
            </tr>
            
            <tr>
                <th><?php echo $this->lang->line('over_time_total_hour'); ?></th>
                <td ><?php echo $payment->over_time_total_hour; ?></td>            
                <th><?php echo $this->lang->line('over_time_amount'); ?></th>
                <td ><?php echo $payment->over_time_amount; ?></td>
            </tr>
            
            <tr>
                <th><?php echo $this->lang->line('provident_fund'); ?></th>
                <td colspan="3"><?php echo $payment->provident_fund; ?></td>
            </tr>
        <?php } ?>
        
        <?php if(strtolower($payment->salary_type) == 'hourly'){ ?>
            <tr>
                <th><?php echo $this->lang->line('hourly_rate'); ?></th>
                <td ><?php echo $payment->hourly_rate; ?></td>            
                <th><?php echo $this->lang->line('total_hour'); ?></th>
                <td ><?php echo $payment->total_hour; ?></td>
            </tr>
         <?php } ?>
        
        <tr>
            <th><?php echo $this->lang->line('bonus'); ?></th>
            <td ><?php echo $payment->bonus; ?></td>       
            <th><?php echo $this->lang->line('penalty'); ?></th>
            <td ><?php echo $payment->penalty; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('total_allowance'); ?></th>
            <td ><?php echo $payment->total_allowance; ?></td>        
            <th><?php echo $this->lang->line('total_deduction'); ?></th>
            <td ><?php echo $payment->total_deduction; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('gross_salary'); ?></th>
            <td ><?php echo $payment->gross_salary; ?></td>       
            <th><?php echo $this->lang->line('net_salary'); ?></th>
            <td ><?php echo $payment->net_salary; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('payment_method'); ?></th>
            <td colspan="3"><?php echo $this->lang->line($payment->payment_method); ?></td>
        </tr>
        
        <?php if($payment->payment_method == 'cheque'){ ?>
            <tr>
                <th><?php echo $this->lang->line('bank_name'); ?></th>
                <td ><?php echo $payment->bank_name; ?></td>            
                <th><?php echo $this->lang->line('cheque_number'); ?></th>
                <td ><?php echo $payment->cheque_no; ?></td>
            </tr>
        <?php } ?> 
            
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td colspan="3"><?php echo $payment->note; ?></td>
        </tr>
            
    </tbody>
</table>