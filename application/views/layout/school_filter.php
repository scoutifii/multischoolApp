<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<?php $schools = get_school_list(); ?>
<div class="col-md-3 col-sm-3 col-xs-12">
    <div class="item form-group"> 
        <div><?php echo $this->lang->line('transfer_to_next_school'); ?> <span class="required"> *</span></div>
        <select  class="form-control col-md-7 col-xs-12 fn_school_id" name="next_school_id" id="next_school_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php foreach($schools as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if(isset($next_school_id) && $next_school_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->school_name; ?>[<?php echo $obj->district; ?>]</option>
            <?php } ?>
        </select>       
    </div>
</div>
<?php }else{ ?>  
<input type="hidden" class="fn_school_id" name="next_school_id" id="next_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
<?php } ?>