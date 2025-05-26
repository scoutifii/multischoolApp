<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_decline_application'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_application_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_application"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a> </li>                          
                        <?php } ?>                        
                        <li class="li-class-list">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                  
                                <select  class="form-control col-md-7 col-xs-12 auto-width" name="school_id_filter" id="school_id_filter" onchange="get_application_by_school_filter(this.value)">
                                    <option value="<?php echo site_url('leave/decline/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('leave/decline/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>
                        </li> 
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_application_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>
                                        <th><?php echo $this->lang->line('applicant_type'); ?></th>
                                        <th><?php echo $this->lang->line('leave_type'); ?></th>
                                        <th><?php echo $this->lang->line('applicant'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php $count = 1; if(isset($applications) && !empty($applications)){ ?>
                                        <?php foreach($applications as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->role_name; ?></td>
                                            <td><?php echo $obj->type; ?></td>
                                            <td>
                                                <?php
                                                    $user = get_user_by_role($obj->role_id, $obj->user_id);
                                                    echo $user->name;
                                                    if($obj->role_id == STUDENT){
                                                        echo '<br/>'.$user->class_name.', '. $user->section.', '.$user->roll_no;
                                                    }
                                                ?>
                                            </td>                                
                                            <td>                                                
                                                <?php if(has_permission(EDIT, 'leave', 'approve')){ ?>
                                                    <a href="<?php echo site_url('leave/approve/update/'.$obj->id); ?>" title="<?php echo $this->lang->line('approve'); ?>" class="btn btn-success btn-xs"><i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('approve'); ?> </a>
                                                <?php } ?>                               
                                                <?php if(has_permission(EDIT, 'leave', 'decline')){ ?>
                                                    <a href="<?php echo site_url('leave/decline/waiting/'.$obj->id); ?>" title="<?php echo $this->lang->line('waiting'); ?>" class="btn btn-info btn-xs"><i class="fa fa-spinner"></i> <?php echo $this->lang->line('waiting'); ?> </a>
                                                <?php } ?>                                                    
                                                
                                                <?php if(has_permission(VIEW, 'leave', 'waiting')){ ?>
                                                    <a  onclick="get_application_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-application-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'leave', 'decline')){ ?>    
                                                    <a href="<?php echo site_url('leave/decline/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_application">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('leave/decline/update/'.$application->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_edit_form'); ?>  
                                
                                    <div class="item form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id"><?php echo $this->lang->line('applicant_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12" name="role_id"  id="role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                                <?php foreach($roles as $obj ){  ?>
                                                     <?php if(in_array($obj->id, array(SUPER_ADMIN, GUARDIAN))){ continue;} ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($application) && $application->role_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group display"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="class_id"  onchange="get_user('', this.value,'');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php foreach($classes as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($application) && $application->class_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('applicant'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12" name="user_id"  id="user_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type_id"><?php echo $this->lang->line('leave_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="type_id"  id="type_id" required="required" onchange="get_type(this.value)">
                                                <option itemid="" value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                        </div>
                                    </div>                                    

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_date"><?php echo $this->lang->line('application_date'); ?> <span class="required"> *</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12" name="leave_date"  id="leave_date" value="<?php echo isset($application->leave_date) ?  date('d-m-Y', strtotime($application->leave_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('application_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_date'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_from"><?php echo $this->lang->line('leave_from'); ?> <span class="required"> *</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12" name="leave_from"  id="leave_from" value="<?php echo isset($application->leave_from) ?  date('d-m-Y', strtotime($application->leave_from)) : ''; ?>" placeholder="<?php echo $this->lang->line('leave_from'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_from'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_to"><?php echo $this->lang->line('leave_to'); ?> <span class="required"> *</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12" name="leave_to"  id="leave_to" value="<?php echo isset($application->leave_to) ?  date('d-m-Y', strtotime($application->leave_to)) : ''; ?>" placeholder="<?php echo $this->lang->line('leave_to'); ?> " required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('leave_to'); ?></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_reason"><?php echo $this->lang->line('leave_reason'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea  class="form-control" name="leave_reason" id="leave_reason" required="required" placeholder="<?php echo $this->lang->line('leave_reason'); ?>"><?php echo isset($application->leave_reason) ?  $application->leave_reason : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('leave_reason'); ?></div>
                                        </div>
                                    </div> 
                                
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leave_note"><?php echo $this->lang->line('note'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea  class="form-control" name="leave_note" id="leave_note" required="required" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($application->leave_note) ?  $application->leave_note : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('leave_note'); ?></div>
                                        </div>
                                    </div> 

                                    <?php if($application->attachment){ ?>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('attachment'); ?></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/leave/<?php echo $application->attachment; ?>"><?php echo $application->attachment; ?></a> <br/><br/>
                                            </div>
                                        </div>
                                    <?php } ?>                                            
                                
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($application) ? $application->id : $id; ?>" name="id" />
                                            <a  href="<?php echo site_url('leave/decline/index/'.$application->school_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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
          url    : "<?php echo site_url('leave/decline/get_single_application'); ?>",
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

 <script type="text/javascript">

    $('.fn_school_id').on('change', function(){      
         
        var school_id = $(this).val(); 
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                  $('#class_id').html(response);  
               }
            }
        });     
    });
        
    <?php if(isset($application)){ ?>  
         get_user_by_role('<?php echo $application->role_id; ?>', '<?php echo $application->user_id; ?>');
    <?php } ?>
      
    function get_user_by_role(role_id, user_id){       
      
        var school_id = $('.fn_school_id ').val();
        if( !school_id){            
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           $('select#role_id').prop('selectedIndex', 0);
           return false;
        } 
      
       if(role_id == <?php echo STUDENT; ?>){
           $('.display').show();
           $('#class_id').prop('required', true);
           //$('select#class_id').prop('selectedIndex', 0);
           $('#user_id').html('<option value="">--<?php echo $this->lang->line('select'); ?>--</option>'); 
       }else{
           get_user(role_id, '', user_id);
           $('#class_id').prop('required', false);
           $('.display').hide();
       }
       
       
       var type_id = '';
       
       <?php if(isset($application)){ ?> 
          type_id = '<?php echo $application->type_id; ?>';
       <?php } ?>
       get_leave_type_by_school(school_id, type_id);
   }
   
    <?php if(isset($application)){ ?> 
          get_user('', '<?php echo $application->class_id; ?>', '<?php echo $application->user_id; ?>');
    <?php } ?>
   function get_user(role_id, class_id, user_id){
       
        if(role_id == ''){
            role_id = $('#role_id').val();
        }
       
        var school_id = $('.fn_school_id ').val();
        if( !school_id){            
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }       
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_by_role'); ?>",
            data   : { school_id : school_id, role_id : role_id , class_id: class_id, user_id : user_id, message:true},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#user_id').html(response); 
               }
            }
        }); 
   }
   
   
   function get_leave_type_by_school(school_id, type_id){
   
        var role_id = $('#role_id').val();
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_leave_type_by_school'); ?>",
            data   : { school_id: school_id, role_id:role_id, type_id:type_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#type_id').html(response); 
               }
            }
        }); 
   }   

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
    
    
       /* Menu Filter Start */   
    function get_application_by_school_filter(url){          
       if(url){
           window.location.href = url; 
       }
    } 
    
</script> 
