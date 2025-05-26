<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-unlock-alt"></i><small> <?php echo $this->lang->line('manage_role_permission'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?>
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">                 
                        <li  class="active"><a href="#tab_perimission" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('role_permission'); ?></a></li>                          
                        <li class="li-class-list">
                            <select  class="form-control col-md-7 col-xs-12" id="filter_class_id" name="class_id"  style="width:auto;" onchange="get_permission_setting_by_role(this.value)">
                                <option value="<?php echo site_url('administrator/permission'); ?>" >--<?php echo $this->lang->line('select'); ?>--</option> 
                                <?php if(isset($roles) && !empty($roles)){ ?>
                                    <?php foreach($roles as $obj){ ?>
                                        <option value="<?php echo site_url('administrator/permission/index/'.$obj->id); ?>" <?php if(isset($filter_role_id) && $filter_role_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option> 
                                    <?php } ?>
                                <?php } ?>
                           </select>
                        </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_role_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?>/ <?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('note'); ?></th>
                                        <th><?php echo $this->lang->line('is_default'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($roles) && !empty($roles)){ ?>
                                        <?php foreach($roles as $obj){ ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo ucfirst($obj->name); ?></td>
                                            <td><?php echo $obj->note; ?></td>
                                            <td><?php echo $obj->is_default ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'administrator', 'permission')){ ?>  
                                                    <a href="<?php echo site_url('administrator/permission/index/'.$obj->id); ?>" class="btn btn-success btn-xs"><i class="fa fa-folder-open-o"></i> <?php echo $this->lang->line('role_permission'); ?> <?php echo $this->lang->line('setting'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <?php if(isset($permission)){ ?>
                        <div class="tab-pane pade active" id="tab_perimission"> 
                            
                            <div class="x_content">
                                <div class="col-md-12">
                                    <?php echo $this->lang->line('role_permission'); ?> : <?php echo $role->name; ?>
                                </div>
                            </div>
                            <div class="x_content"  style=" overflow-y: auto; overflow-y: hidden;">
                            <?php echo form_open(site_url('administrator/permission/index/'.$role_id), array('name' => 'login', 'id' => 'login', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>           
                                        <th  class="role-text" width="10%"><?php echo $this->lang->line('module_name'); ?></th>
                                        <th  class="role-text"><?php echo $this->lang->line('function_name'); ?></th>
                                        <th><?php echo $this->lang->line('view'); ?> &nbsp; <input type="checkbox" id="fn_view" class="role-check" value="1" /> </th>                  
                                        <th><?php echo $this->lang->line('add'); ?>  &nbsp;<input type="checkbox" id="fn_add"  class="role-check" value="1" /></th>                  
                                        <th><?php echo $this->lang->line('edit'); ?>  &nbsp;<input type="checkbox" id="fn_edit" class="role-check" value="1" /></th> 
                                        <th><?php echo $this->lang->line('delete'); ?>  &nbsp; <input type="checkbox" id="fn_delete" class="role-check" value="1" /></th> 
                                     </tr>
                                </thead>
                                <tbody>
                                     <?php if(isset($modules) && !empty($modules)){ ?>
                                     <?php $module = 1; foreach( $modules AS $obj ){ ?> 
                                        
                                         <tr>           
                                            <td class="role-text" style="background: #ececec; font-weight: bold;"><?php echo $module; ?></td>
                                            <td colspan="6" class="role-text" style="background: #ececec; font-weight: bold;"><?php echo $obj->module_name; ?> &raquo;</td>                          
                                         </tr>
                                        <?php $operations = get_operation_by_module($obj->id); ?> 
                                        <?php if(isset($operations) && !empty($operations)){ ?>
                                            <?php $operaton = 1; foreach( $operations AS $op ){ ?>
                                            <?php $permission = get_permission_by_operation($role_id, $op->id); ?>
                                            <tr>           
                                                <td class="role-text"><?php echo $module; ?>.<?php echo $operaton++; ?></td>                     
                                                <td colspan="2" class="role-text" style="padding-left: 120px;">
                                                   <?php echo $op->operation_name; ?>
                                                   <input type="hidden" name="operation[<?php echo $op->id; ?>]" id="operatio[]" value="<?php echo $op->id; ?>" />
                                                </td>    
                                                <td>
                                                    <?php if($op->is_view_vissible){ ?>
                                                        <input type="checkbox" class="fn_view" name="is_view[<?php echo $op->id; ?>]" value="1" <?php if(isset($permission->is_view) && $permission->is_view == 1){ echo 'checked="checked"'; } ?> /></td>
                                                    <?php } ?>
                                                <td>
                                                    <?php if($op->is_add_vissible){ ?>
                                                        <input type="checkbox" class="fn_add"  name="is_add[<?php echo $op->id; ?>]" value="1" <?php if(isset($permission->is_add) && $permission->is_add == 1){ echo 'checked="checked"'; } ?> /></td>
                                                    <?php } ?>
                                                <td>
                                                    <?php if($op->is_edit_vissible){ ?>
                                                        <input type="checkbox" class="fn_edit" name="is_edit[<?php echo $op->id; ?>]" value="1" <?php if(isset($permission->is_edit) && $permission->is_edit == 1){ echo 'checked="checked"'; } ?> /></td>
                                                     <?php } ?>
                                                <td>
                                                    <?php if($op->is_delete_vissible){ ?>
                                                        <input type="checkbox" class="fn_delete"  name="is_delete[<?php echo $op->id; ?>]" value="1" <?php if(isset($permission->is_delete) && $permission->is_delete == 1){ echo 'checked="checked"'; } ?> /></td>                     
                                                    <?php } ?>
                                             </tr>                                            
                                         
                                            <?php } ?>
                                        <?php } ?>  
                                    
                                    <?php $module++; } ?>
                                    <?php }else{ ?>
                                    <tr><td colspan="7" class="not-found"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                    <?php } ?>
                                </tbody>
                                
                            </table>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;; ?>" />
                                    <a  href="<?php echo site_url('administrator/role'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                    
                                    <?php if(has_permission(EDIT, 'administrator', 'permission')){ ?>  
                                        <?php if($role_id == 1){ ?>
                                            <!--<button  type="button" disabled="disabled" class="btn btn-success"><?php echo $this->lang->line('update'); ?> <?php echo $this->lang->line('role_permission'); ?></button>-->
                                            <button  type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?> <?php echo $this->lang->line('role_permission'); ?></button>
                                        <?php }else{ ?>                                        
                                            <button  type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?> <?php echo $this->lang->line('role_permission'); ?></button>
                                        <?php } ?>
                                    <?php } ?>
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
<!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
          
          /* Permission */
        $('#fn_view').click(function(){
         if($(this).is(':checked')){           
             $(".fn_view").prop("checked", true);
         }else{
            $(".fn_view").prop("checked", false);
         }
        });
        $('#fn_add').click(function(){
           if($(this).is(':checked')){           
               $(".fn_add").prop("checked", true);
           }else{
              $(".fn_add").prop("checked", false);
           }
        });
        $('#fn_edit').click(function(){
           if($(this).is(':checked')){           
               $(".fn_edit").prop("checked", true);
           }else{
              $(".fn_edit").prop("checked", false);
           }
        });
        $('#fn_delete').click(function(){
           if($(this).is(':checked')){           
               $(".fn_delete").prop("checked", true);
           }else{
              $(".fn_delete").prop("checked", false);
           }
        });
          
        } );
      
      
    function get_permission_setting_by_role(url){          
        if(url){
            window.location.href = url; 
        }
    }   
</script>