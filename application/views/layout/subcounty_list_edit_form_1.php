
<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="sub_county_id"><?php echo $this->lang->line('subcounty'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_subcounty_id" name="sub_county_id" id="edit_sub_county_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $subcounties = get_sub_county_list(); ?>
            <?php foreach($subcounties as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($village->sub_county_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->sub_county_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sub_county_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_subcounty_id" type="hidden" name="subcounty_id" id="edit_sub_county_id" value="<?php echo $this->session->userdata('sub_county_id'); ?>" />
        </div>
    </div>
<?php } ?>
