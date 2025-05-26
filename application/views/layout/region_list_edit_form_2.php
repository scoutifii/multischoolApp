
<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="region_id"><?php echo $this->lang->line('region'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_region_id" name="region_id" id="edit_region_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $regions = get_region_list(); ?>
            <?php foreach($regions as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($village->region_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->region_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="region_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_region_id" type="hidden" name="region_id" id="edit_region_id" value="<?php echo $this->session->userdata('region_id'); ?>" />
        </div>
    </div>
<?php } ?>
