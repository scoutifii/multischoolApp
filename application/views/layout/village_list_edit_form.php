
<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="village_id"><?php echo $this->lang->line('village'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_village_id" name="village_id" id="edit_village_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $villages = get_village_list(); ?>
            <?php foreach($villages as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($school->village_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->village_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="village_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_village_id" type="hidden" name="village_id" id="edit_village_id" value="<?php echo $this->session->userdata('village_id'); ?>" />
        </div>
    </div>
<?php } ?>
