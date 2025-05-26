<?php if(isset($classes) && !empty($classes)){ ?>
 <?php foreach($classes as $obj){ ?>
    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="<?php $obj->name; ?>"><?php echo $obj->name; ?> </label>
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            
            <?php $fee_amount = get_fee_amount($fee_type_id, $obj->id); ?>
            <input type="hidden" name="amount_id[<?php echo $obj->id; ?>]" value="<?php echo @$fee_amount->id; ?>" />
            <input type="hidden" name="class_id[<?php echo $obj->id; ?>]" value="<?php echo $obj->id; ?>" />
            <input type="text" class="form-control col-md-7 col-xs-12" name="fee_amount[<?php echo $obj->id; ?>]" id="<?php echo $obj->id; ?>" value="<?php echo @$fee_amount->fee_amount; ?>" />
            <div class="help-block"><?php echo form_error($obj->name); ?></div>
            
        </div>
    </div>
 <?php } ?>
<?php } ?>