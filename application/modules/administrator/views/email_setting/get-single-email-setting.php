<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="30%"><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $email_setting->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('email_protocol'); ?></th>
            <td><?php echo $email_setting->mail_protocol; ?></td>
        </tr>
         
        <?php if($email_setting->mail_protocol == 'smtp'){ ?>
            <tr>
                <th><?php echo $this->lang->line('smtp_host'); ?></th>
                <td><?php echo $email_setting->smtp_host; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp_port'); ?></th>
                <td><?php echo $email_setting->smtp_port; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp_username'); ?></th>
                <td><?php echo $email_setting->smtp_user; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp_password'); ?></th>
                <td><?php echo $email_setting->smtp_pass; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp_security'); ?></th>
                <td><?php echo $email_setting->smtp_crypto; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp_timeout'); ?></th>
                <td><?php echo $email_setting->smtp_timeout; ?></td>
            </tr>            
        <?php } ?>
        <tr>
            <th><?php echo $this->lang->line('email_type'); ?></th>
            <td><?php echo $email_setting->mail_type; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('char_set'); ?></th>
            <td><?php echo $email_setting->char_set; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('priority'); ?></th>
            <td><?php echo $email_setting->priority; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('from_name'); ?></th>
            <td><?php echo $email_setting->from_name; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('from_email'); ?></th>
            <td><?php echo $email_setting->from_address; ?></td>
        </tr> 
        
    </tbody>
</table>
