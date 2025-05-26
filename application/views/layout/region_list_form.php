<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<?php $regions = get_region_list(); ?>
<div class="item form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
       
    <label for="region_id"><?php echo $this->lang->line('region_name'); ?> <span class="required" >*</span></label>
        <select  class="form-control fn_region_id" name="region_id" id="add_region_id" required="required" style="width: 100%;">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php foreach($regions as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if(isset($region_id) && $region_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->region_name; ?></option>
            <?php } ?>
        </select>
        <div class="help-block"><?php echo form_error('region_id'); ?></div>
    
</div>
</div>
<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="region_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_region_id" type="hidden" name="region_id" id="add_region_id" value="<?php echo $this->session->userdata('region_id'); ?>" />
        </div>
    </div>
<?php } ?>
