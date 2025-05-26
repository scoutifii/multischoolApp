<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mail-forward"></i><small> <?php echo $this->lang->line('manage_teacher_transfer'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
              <div  class="well">
                 <?php $this->load->view('quick-link'); ?>
            </div>
            </div>
           
            <div class="x_content">                 
                <?php echo form_open_multipart(site_url('academic/transfer/index'), array('name' => 'transfer', 'id' => 'transfer', 'class' => 'form-horizontal form-label-left'), ''); ?>
                
                <div class="row">                    
               
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('teacher'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="teacher_id" id="teacher_id"  required="required" >
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($teachers) && !empty($teachers)) { ?>
                                    <?php foreach ($teachers as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($teacher_id) && $teacher_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('teacher_id'); ?></div>
                        </div>
                    </div>
                    <?php $this->load->view('layout/school_filter'); ?> 
                    
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

           <?php  if (isset($teachers) && !empty($teachers)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('teacher_transfer'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('academic/transfer/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <th><?php echo $this->lang->line('phone'); ?></th>                         
                            <th><?php echo $this->lang->line('teacher_no'); ?></th>
                            <th><?php echo $this->lang->line('file_no'); ?></th>                                  <th><?php echo $this->lang->line('school_option'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="fn_mark">   
                        <?php
                        $count = 1;
                        if (isset($teachers) && !empty($teachers)) {
                            ?>
                            
                                <?php  $transfer = get_transfer($school_id); ?>
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php echo ucfirst($teachers->name); ?></td>
                                    <td>
                                        <?php if ($teachers->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/teacher-photo/<?php echo $teachers->photo; ?>" alt="" width="50" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="50" /> 
                                        <?php } ?>
                                        <input type="hidden" value="<?php echo $teachers->id; ?>"  name="teachers[]" />
                                    </td>
                                    <td><?php echo $teachers->phone; ?></td>                                
                                    <td><?php echo $teachers->certificate_no; ?></td>
                                    <td><?php echo $teachers->file_no; ?></td>
                                    <td>
                                        <select  class="form-control col-md-7 col-xs-12" name="transfer_school_id[<?php echo $teachers->id; ?>]"  required="required">                                
                                            <option value="<?php echo $next_school->id; ?>" <?php if(isset($transfer) && $transfer->school_id == $next_school->id){ echo 'selected="selected"';} ?>><?php echo $next_school->school_name; ?></option>
                                            <option value="<?php echo $current_school->id; ?>" <?php if(isset($transfer) && $transfer->school_id == $current_school->id){ echo 'selected="selected"';} ?>><?php echo $current_school->school_name; ?></option>
                                        </select>
                                    </td>
                                </tr>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="12" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <?php  if (isset($teachers) && !empty($teachers)) { ?>
                         <input type="hidden" value="<?php echo $school_id; ?>"  name="school_id" />
                         <input type="hidden" value="<?php echo $next_school_id; ?>"  name="next_school_id" />
                         <!--input type="hidden" value="<?php echo $academic_year_id; ?>"  name="academic_year_id" /-->
                         <a href="<?php echo site_url('academic/transfer'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                         <?php if(has_permission(ADD, 'academic', 'transfer')){ ?>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('transfer'); ?></button>
                         <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                
            </div>             
        </div>
    </div>
</div>


 
<!-- Super admin js START  -->
 <script type="text/javascript">
        
     $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>               
            $("#school_id").trigger('change');
         <?php } ?>
    });
    
    $('#school_id').on('change', function(){
      
        var school_id = $(this).val();
        var current_class_id = '';
        var next_class_id = '';
        var current_session_id = '';
        var next_session_id = '';
        var teacher_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            current_class_id =  '<?php echo $current_class_id; ?>';           
            next_class_id =  '<?php echo $next_class_id; ?>';           
            current_session_id =  '<?php echo $current_session_id; ?>';           
            next_session_id =  '<?php echo $next_session_id; ?>'; 
            teacher_id = '<?php echo $teacher_id; ?>';          
        <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
        get_current_class_by_school(school_id, current_class_id); 
        get_next_class_by_school(school_id, next_class_id); 
        
        get_current_session_by_school(school_id, current_session_id); 
        get_next_session_by_school(school_id, next_session_id);
        get_teacher_by_school(school_id, teacher_id); 
        
    }); 

    function get_teacher_by_school(school_id, teacher_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_teacher_by_school'); ?>",
            data   : { school_id : school_id, teacher_id : teacher_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#teacher_id').html(response); 
               }
            }
        }); 
   }
   function get_current_class_by_school(school_id, current_class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : current_class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#current_class_id').html(response); 
               }
            }
        }); 
   }
  
   function get_next_class_by_school(school_id, next_class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : next_class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#next_class_id').html(response); 
               }
            }
        }); 
   }
  
   function get_current_session_by_school(school_id, current_session_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_current_session_by_school'); ?>",
            data   : { school_id : school_id, current_session_id : current_session_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#current_session_id').html(response); 
               }
            }
        }); 
   }
  
   function get_next_session_by_school(school_id, next_session_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_next_session_by_school'); ?>",
            data   : { school_id : school_id, academic_year_id : next_session_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#next_session_id').html(response); 
               }
            }
        }); 
   }
  
   
  </script>
<!-- Super admin js end -->

<script type="text/javascript">
    $("#promotion").validate();  
    $("#add").validate();  
</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>

