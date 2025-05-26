<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<?php $regions = get_region_list(); ?>
<div class="item form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="well" style="">
    <label class="" for="region_id" style="font-size: 16px"><?php echo $this->lang->line('region'); ?> <span class="required" >*</span></label>
        <select  class="form-control fn_sub_region_id" name="sub_region_id" id="sub_region_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php foreach($sub_region as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if(isset($sub_region_id) && $sub_region_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->sub_region_name; ?></option>
            <?php } ?>
        </select>
        <div class="help-block"><?php echo form_error('sub_region_id'); ?></div>
    </div>
</div>
</div>
<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="region_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_sub_region_id" type="hidden" name="sub_region_id" id="add_sub_region_id" value="<?php echo $this->session->userdata('region_id'); ?>" />
        </div>
    </div>
<?php } ?>
