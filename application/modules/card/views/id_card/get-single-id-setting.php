<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="30%"><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $setting->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('border_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->border_color; ?>"></span></td>        
            <th><?php echo $this->lang->line('top_background'); ?> </th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->top_bg; ?>"></span></td>
        </tr>
         
        <tr>
            <th><?php echo $this->lang->line('card_school_name'); ?></th>
            <td><?php echo $setting->school_name; ?></td>        
            <th><?php echo $this->lang->line('card_logo'); ?></th>
            <td>
                <?php if($setting->school_logo){ ?>
                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->school_logo; ?>" alt=""  width="80" /><br/><br/>
                <?php } ?>
            </td>
        </tr> 
        
        <tr>
            <th><?php echo $this->lang->line('school_name_font_size'); ?></th>
            <td><?php echo $setting->school_name_font_size; ?></td>        
            <th><?php echo $this->lang->line('school_name_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->school_name_color; ?>"></span></td>
        </tr> 
        
        <tr>
            <th><?php echo $this->lang->line('school_address'); ?></th>
            <td><?php echo $setting->school_address; ?></td>
            <th><?php echo $this->lang->line('school_address_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->school_address_color; ?>"></span></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('id_no_font_size'); ?></th>
            <td><?php echo $setting->id_no_font_size; ?></td>
            <th><?php echo $this->lang->line('id_no_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->id_no_color; ?>"></span></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('id_no_title_background'); ?></th>
            <td colspan="3"><span style="padding: 4px 10px; background-color:<?php echo $setting->id_no_bg; ?>"></span></td>
        </tr> 
        
        <tr>
            <th><?php echo $this->lang->line('title_font_size'); ?></th>
            <td><?php echo $setting->title_font_size; ?></td>
            <th><?php echo $this->lang->line('title_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->title_color; ?>"></span></td>
        </tr> 
        
        <tr>
            <th><?php echo $this->lang->line('value_font_size'); ?></th>
            <td><?php echo $setting->value_font_size; ?></td>
            <th><?php echo $this->lang->line('value_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->value_color; ?>"></span></td>
        </tr> 
        
        <tr>                   
            <th><?php echo $this->lang->line('bottom_signature'); ?></th>
            <td><?php echo $setting->bottom_text; ?></td>
            <th><?php echo $this->lang->line('signature_background'); ?> </th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->bottom_bg; ?>"></span></td>        
        </tr> 
        <tr >
            <th><?php echo $this->lang->line('signature_color'); ?></th>
            <td><span style="padding: 4px 10px; background-color:<?php echo $setting->bottom_text_color; ?>"></span></td> 
            <th><?php echo $this->lang->line('signature_align'); ?></th>
            <td><?php echo $setting->bottom_text_align; ?></td>
        </tr> 
        
    </tbody>
</table>
