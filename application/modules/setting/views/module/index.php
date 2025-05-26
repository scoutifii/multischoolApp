<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-cubes"></i><small> Manage Module</small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_module_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> Module List</a> </li>
                        
                        <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_module"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> Add Module</a> </li>                          
                            
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_module"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> Edit Module</a> </li>                          
                        <?php } ?>                
                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_module_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Module Name</th>
                                        <th>Module Slug</th>
                                        <th>Status</th>
                                        <th>Actions</th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($modules) && !empty($modules)){ ?>
                                        <?php foreach($modules as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $obj->module_name; ?></td>
                                            <td><?php echo $obj->module_slug; ?></td>
                                            <td><?php echo $obj->status ? 'Active' : 'Inctive'; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('setting/module/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Edit </a>
                                                <a href="<?php echo site_url('setting/module/delete/'.$obj->id); ?>" onclick="javascript: return confirm('Are you sure you want to delete this Session?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_module">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('setting/module/add'), array('name' => 'module', 'id' => 'module', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_name">module_name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="module_name"  id="module_name" value="" placeholder="module_name" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('module_name'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_slug">module_slug <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="module_slug"  id="module_slug" value="" placeholder="module_slug" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('module_slug'); ?></div>
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
                        <div class="tab-pane fade in active" id="tab_edit_module">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('setting/module/edit'), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_name">module_name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="module_name" value="<?php echo isset($module) ? $module->module_name : $post['module_name']; ?>"  placeholder="module_name" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('module_name'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_slug">module_slug <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="module_slug" value="<?php echo isset($module) ? $module->module_slug : $post['module_slug']; ?>"  placeholder="module_slug" required="required" type="text">
                                        <div class="help-block"><?php echo form_error('module_slug'); ?></div>
                                    </div>
                                </div>
                          
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($module) ? $module->id : $id; ?>" name="id" />
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
