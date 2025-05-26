<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="district_id"><?php echo $this->lang->line('district'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_district_id" name="district_id" id="edit_district_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $districts = get_district_list(); ?>
            <?php foreach($districts as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($village->district_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->district_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="district_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_district_id" type="hidden" name="district_id" id="edit_district_id" value="<?php echo $this->session->userdata('district_id'); ?>" />
        </div>
    </div>
<?php } ?>