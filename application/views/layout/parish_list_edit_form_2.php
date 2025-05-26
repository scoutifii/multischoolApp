<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label" for="parish_id"><?php echo $this->lang->line('parish'); ?> <?php echo $this->lang->line('name'); ?><span class="required" >*</span></label>
    
        <select  class="form-control fn_parish_id" name="parish_id" id="edit_parish_id" required="required">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
            <?php $parishes = get_parish_list(); ?>
            <?php foreach($parishes as $obj){ ?>
                <option value="<?php echo $obj->id; ?>" <?php if($village->parish_id == $obj->id ) { echo 'selected="selected"'; } ?>><?php echo $obj->parish_name; ?></option>
            <?php } ?>
        </select>
    </div>

<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parish_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_parish_id" type="hidden" name="parish_id" id="edit_parish_id" value="<?php echo $this->session->userdata('parish_id'); ?>" />
        </div>
    </div>
<?php } ?>