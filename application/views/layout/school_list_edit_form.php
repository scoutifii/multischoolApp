<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
<div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="school_id"></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $school_id; ?>" />
    </div>
</div>
<?php }else{ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="school_id"></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="fn_school_id" type="hidden" name="school_id" id="edit_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
        </div>
    </div>
<?php } ?>
