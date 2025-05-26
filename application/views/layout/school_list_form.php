<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<?php $schools = get_school_list(); ?>

    <div class="item form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        
       
<label class="" for="school_id" style="font-size: 16px"><?php echo $this->lang->line('school'); ?> <span class="required" >*</span></label>
        <select  class="form-control fn_school_id select2" name="school_id" id="add_school_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php foreach($schools as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if(isset($school_id) && $school_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->school_name; ?></option>
            <?php } ?>
        </select>
        <div class="help-block"><?php echo form_error('school_id'); ?></div>
    </div>
 
</div>
<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="school_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_school_id" type="hidden" name="school_id" id="add_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
        </div>
    </div>
<?php } ?>
