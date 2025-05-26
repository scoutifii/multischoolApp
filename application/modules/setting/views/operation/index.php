<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-cubes"></i><small> Manage Operation</small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_operation_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> Operation List</a> </li>
                        
                        <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_operation"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> Add Operation</a> </li>                          
                            
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_operation"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> Edit Operation</a> </li>                          
                        <?php } ?>                
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_operation_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Module Name</th>
                                        <th>Operation Name</th>
                                        <th>Operation Slug</th>
                                        <th>Is View</th>
                                        <th>Is Add</th>
                                        <th>Is Edit</th>
                                        <th>Is Delete</th>
                                        <th>Actions</th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($operations) && !empty($operations)){ ?>
                                        <?php foreach($operations as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $obj->module_name; ?></td>
                                            <td><?php echo $obj->operation_name; ?></td>
                                            <td><?php echo $obj->operation_slug; ?></td>
                                            <td><?php echo $obj->is_view_vissible == 1 ? 'Y' :'--'; ?></td>
                                            <td><?php echo $obj->is_add_vissible == 1 ? 'Y' :'--'; ?></td>
                                            <td><?php echo $obj->is_edit_vissible == 1 ? 'Y' :'--'; ?></td>
                                            <td><?php echo $obj->is_delete_vissible == 1 ? 'Y' :'--'; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('setting/operation/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Edit </a>
                                                <a href="<?php echo site_url('setting/operation/delete/'.$obj->id); ?>" onclick="javascript: return confirm('Are you sure you want to delete this Session?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_operation">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('setting/operation/add'), array('name' => 'operation', 'id' => 'operation', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_id">Module Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="module_id" id="module_id">
                                            <?php foreach($modules as $obj){ ?>
                                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->module_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('module_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="operation_name">operation_name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="operation_name"  id="operation_name" value="" placeholder="operation_name" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('operation_name'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="operation_slug">operation_slug <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="operation_slug"  id="operation_slug" value="" placeholder="operation_slug" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('operation_slug'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_view_vissible">is_view_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_view_vissible" value="1"   type="checkbox" > 
                                        <div class="help-block"><?php echo form_error('is_view_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_add_vissible">is_add_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_add_vissible" value="1"   type="checkbox" > 
                                        <div class="help-block"><?php echo form_error('is_add_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_edit_vissible">is_edit_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_edit_vissible" value="1"   type="checkbox" > 
                                        <div class="help-block"><?php echo form_error('is_edit_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_delete_vissible">is_delete_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_delete_vissible" value="1"   type="checkbox" > 
                                        <div class="help-block"><?php echo form_error('is_delete_vissible'); ?></div>
                                    </div>
                                </div>
                              
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a type="submit" class="btn btn-primary">Cancel</a>
                                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_operation">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('setting/operation/edit'), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_id">Module Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12" name="module_id" id="module_id">
                                            <?php foreach($modules as $obj){ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if($operation->module_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->module_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('module_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="operation_name">operation_name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="operation_name" value="<?php echo isset($operation) ? $operation->operation_name : $post['operation_name']; ?>"  placeholder="operation_name" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('operation_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="operation_slug">operation_slug <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="operation_slug" value="<?php echo isset($operation) ? $operation->operation_slug : $post['operation_slug']; ?>"  placeholder="operation_slug" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('operation_slug'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_view_vissible">is_view_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_view_vissible" value="1"   type="checkbox" <?php echo isset($operation->is_view_vissible) && $operation->is_view_vissible == 1  ? 'checked="checked"' :'' ?>> 
                                        <div class="help-block"><?php echo form_error('is_view_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_add_vissible">is_add_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_add_vissible" value="1"   type="checkbox" <?php echo isset($operation->is_add_vissible) && $operation->is_add_vissible == 1  ? 'checked="checked"' :'' ?>> 
                                        <div class="help-block"><?php echo form_error('is_add_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_edit_vissible">is_edit_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_edit_vissible" value="1"   type="checkbox" <?php echo isset($operation->is_edit_vissible) && $operation->is_edit_vissible == 1  ? 'checked="checked"' :'' ?>> 
                                        <div class="help-block"><?php echo form_error('is_edit_vissible'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_delete_vissible">is_delete_vissible <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="is_delete_vissible" value="1"   type="checkbox" <?php echo isset($operation->is_delete_vissible) && $operation->is_delete_vissible == 1 ? 'checked="checked"' :'' ?>> 
                                        <div class="help-block"><?php echo form_error('is_delete_vissible'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($operation) ? $operation->id : $id; ?>" name="id" />
                                        <a type="submit" class="btn btn-primary">Cancel</a>
                                        <button id="send" type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
