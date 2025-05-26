<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_leave_application'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
             <div class="x_content quick-link">
                <?php $this->load->view('profile/quick-link'); ?>                 
            </div>
            
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_application_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'userleave', 'userleave')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('userleave/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_application"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_application"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_application_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>                                       
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>
                                        <th><?php echo $this->lang->line('leave_type'); ?></th>
                                        <th><?php echo $this->lang->line('leave_from'); ?></th>
                                        <th><?php echo $this->lang->line('leave_to'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($applications) && !empty($applications)){ ?>
                                        <?php foreach($applications as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td>                                            
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->type; ?></td>                                                     
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->leave_from)); ?></td>                                                     
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->leave_to)); ?></td>                                                     
                                            <td>
                                                <?php  if($obj->leave_status == 0){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-default red btn-xs"> <?php echo $this->lang->line('new'); ?> </a>
                                                <?php  }elseif($obj->leave_status == 1){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-info btn-xs"><?php echo $this->lang->line('waiting'); ?> </a>  
                                                <?php  }elseif($obj->leave_status == 2){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-success btn-xs"><?php echo $this->lang->line('approved'); ?> </a>  
                                                <?php  }elseif($obj->leave_status == 3){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs"><?php echo $this->lang->line('declined'); ?> </a>  
                                                <?php  } ?>
                                            </td>                                           
                                            <td>   
                                                    
                                                <?php if(has_permission(EDIT, 'userleave', 'userleave') && $obj->leave_status == 0){ ?>
                                                    <a href="<?php echo site_url('userleave/edit/'.$obj->id); ?>" title="<?php echo $this->lang->line('edit'); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?> 
                                                <?php if(has_permission(VIEW, 'userleave', 'userleave')){ ?>
                                                    <a  onclick="get_application_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-application-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'userleave', 'userleave') && $obj->leave_status == 0){ ?>    
                                                    <a href="<?php echo site_url('userleave/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_application">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('userleave/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                                              
                                <div class="item form-group">  
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_id"><?php echo $this->lang->line('leave_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="type_id"  id="add_type_id" required="required" onchange="get_type(this.value)">
                                            <option itemid="" value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            <?php foreach($types as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" ><?php echo $obj->type; ?></option>
                                            <?php } ?> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                    </div>
                                </div>    
                                
                                <?php if(logged_in_role_id() == GUARDIAN){ ?>
                                    <div class="item form-group">  
                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('leave_apply_for'); ?> <span class="required">*</span></label>
                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                           <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="user_id" required="required">
                                               <option itemid="" value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                               <?php foreach($students as $obj ){ ?>
                                               <option value="<?php echo $obj->user_id; ?>|<?php echo $obj->class_id; ?>" ><?php echo $obj->name; ?></option>
                                               <?php } ?> 
                                           </select>
                                           <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                       </div>
                                   </div> 
                                <?php } ?>
                                   
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_date"><?php echo $this->lang->line('date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="leave_date"  id="add_leave_date" value="<?php echo isset($post['leave_date']) ?  $post['leave_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('leave_date'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_from"><?php echo $this->lang->line('leave_from'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="leave_from"  id="add_leave_from" value="<?php echo isset($post['leave_from']) ?  $post['leave_from'] : ''; ?>" placeholder="<?php echo $this->lang->line('leave_from'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('leave_from'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_to"><?php echo $this->lang->line('leave_to'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="leave_to"  id="add_leave_to" value="<?php echo isset($post['leave_to']) ?  $post['leave_to'] : ''; ?>" placeholder="<?php echo $this->lang->line('leave_to'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('leave_to'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_reason"><?php echo $this->lang->line('reason'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control" name="leave_reason" id="leave_reason" required="required" placeholder="<?php echo $this->lang->line('reason'); ?>"><?php echo isset($post['leave_reason']) ?  $post['leave_reason'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('leave_reason'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('attachment'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                            <input  class="form-control col-md-7 col-xs-12"  name="attachment"  id="attachment" type="file" >
                                        </div>
                                        <div class="text-info"><?php echo $this->lang->line('select_valid_file_format'); ?></div>
                                        <div class="help-block"><?php echo form_error('attachment'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('userleave/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_application">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('userleave/edit/'.$application->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                            

                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_id"><?php echo $this->lang->line('leave_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="type_id"  id="edit_type_id" required="required" onchange="get_type(this.value)">
                                                <option itemid="" value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                                <?php foreach($types as $obj ){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($application) && $application->type_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->type; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                        </div>
                                    </div> 
                                
                                    <?php if(logged_in_role_id() == GUARDIAN){ ?>
                                        <div class="item form-group">  
                                           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('leave_apply_for'); ?> <span class="required">*</span></label>
                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                               <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="user_id" required="required">
                                                   <option itemid="" value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                   <?php foreach($students as $obj ){ ?>
                                                   <option value="<?php echo $obj->user_id; ?>|<?php echo $obj->class_id; ?>" <?php echo isset($application) && $application->user_id == $obj->user_id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                   <?php } ?> 
                                               </select>
                                               <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                           </div>
                                       </div> 
                                    <?php } ?>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_date"><?php echo $this->lang->line('date'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="leave_date"  id="edit_leave_date" value="<?php echo isset($application->leave_date) ?  date('d-m-Y', strtotime($application->leave_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_date'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_from"><?php echo $this->lang->line('leave_from'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="leave_from"  id="edit_leave_from" value="<?php echo isset($application->leave_from) ?  date('d-m-Y', strtotime($application->leave_from)) : ''; ?>" placeholder="<?php echo $this->lang->line('leave_from'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_from'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_to"><?php echo $this->lang->line('leave_to'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="leave_to"  id="edit_leave_to" value="<?php echo isset($application->leave_to) ?  date('d-m-Y', strtotime($application->leave_to)) : ''; ?>" placeholder="<?php echo $this->lang->line('leave_to'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_to'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_reason"><?php echo $this->lang->line('reason'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea  class="form-control" name="leave_reason" id="leave_reason" required="required" placeholder="<?php echo $this->lang->line('reason'); ?>"><?php echo isset($application->leave_reason) ?  $application->leave_reason : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('leave_reason'); ?></div>
                                        </div>
                                    </div> 

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('attachment'); ?></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" name="prev_attachment" id="prev_attachment" value="<?php echo $application->attachment; ?>" />
                                            <?php if($application->attachment){ ?>
                                                <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/leave/<?php echo $application->attachment; ?>"  class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('attachment'); ?></a> <br/><br/>
                                            <?php } ?>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="attachment"  id="attachment" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('select_valid_file_format'); ?></div>
                                            <div class="help-block"><?php echo form_error('attachment'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($application) ? $application->id : $id; ?>" name="id" />
                                            <a  href="<?php echo site_url('leave/application/index/'.$application->school_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
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


<div class="modal fade bs-application-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_application_data">            
        </div>       
      </div>
    </div>
</div>

<script type="text/javascript">
         
    function get_application_modal(application_id){
         
        $('.fn_application_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('userleave/get_single_leave_application'); ?>",
          data   : {application_id : application_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_application_data').html(response);
             }
          }
       });
    }
</script>


<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

 <script type="text/javascript">
     
    $('#add_leave_date').datepicker();  
    $('#edit_leave_date').datepicker();  
    $('#add_leave_from').datepicker();  
    $('#edit_leave_from').datepicker();  
    $('#add_leave_to').datepicker();  
    $('#edit_leave_to').datepicker();  

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
      });
      
    $("#add").validate();   
    $("#edit").validate();   
     
    
</script> 
