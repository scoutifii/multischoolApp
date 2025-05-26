<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="sub_region_id"><?php echo $this->lang->line('subregion'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_subregion_id" name="sub_region_id" id="edit_sub_region_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $subregions = get_sub_region_list(); ?>
            <?php foreach($subregions as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($village->sub_region_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->sub_region_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_region_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_subregion_id" type="hidden" name="region_id" id="edit_sub_region_id" value="<?php echo $this->session->userdata('sub_region_id'); ?>" />
        </div>
    </div>
<?php } ?>