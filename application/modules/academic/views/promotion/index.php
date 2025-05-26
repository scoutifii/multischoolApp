<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mail-forward"></i><small> <?php echo $this->lang->line('manage_promotion'); ?></small></h3>
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
                <?php echo form_open_multipart(site_url('academic/promotion/index'), array('name' => 'promotion', 'id' => 'promotion', 'class' => 'form-horizontal form-label-left'), ''); ?>
                
                <div class="row">                    
               
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('running_session'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="current_session_id" id="current_session_id"  required="required">
                                 <?php if(isset($curr_session) && !empty($curr_session)){ ?>
                                    <option value="<?php echo $curr_session->id; ?>" <?php if(isset($current_session_id) && @$current_session_id == $curr_session->id){ echo 'selected="selected"';} ?>><?php echo $curr_session->session_year; ?></option>
                                <?php }else{ ?>
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('current_session_id'); ?></div>
                        </div>
                    </div>
                        
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('promote_to_session'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="next_session_id" id="next_session_id"  required="required" >
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach($next_session as $obj ){ ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($next_session_id) && @$next_session_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('next_session_id'); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('current_class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="current_class_id" id="current_class_id"  required="required" >
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php foreach ($classes as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($current_class_id) && $current_class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('current_class_id'); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('promote_to_class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="next_class_id" id="next_class_id"  required="required" >
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php foreach ($classes as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($next_class_id) && $next_class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('next_class_id'); ?></div>
                        </div>
                    </div> 
                
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('student_promotion'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('academic/promotion/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?>/ <?php echo $this->lang->line('phone'); ?></th>                           
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <th><?php echo $this->lang->line('total_mark'); ?></th>                                            
                            <th><?php echo $this->lang->line('obtain_mark'); ?></th>                                            
                            <th><?php echo $this->lang->line('average_grade_point'); ?></th>                                            
                            <th><?php echo $this->lang->line('result'); ?></th>                                            
                            <th><?php echo $this->lang->line('position'); ?></th>                                            
                            <th><?php echo $this->lang->line('class_option'); ?></th>                                            
                            <th><?php echo $this->lang->line('next_roll_no'); ?></th>                                            
                        </tr>
                    </thead>
                    <tbody id="fn_mark">   
                        <?php
                        $count = 1;
                        if (isset($students) && !empty($students)) {
                            ?>
                            <?php foreach ($students as $obj) { ?>
                        
                            <?php  $result = get_exam_final_result($school_id, $obj->id, $academic_year_id, $current_class_id); ?>
                            <?php  $enroll = get_enrollment($obj->id, $next_session_id, $school_id); ?>
                            <?php  $position = get_position_in_class($school_id, $academic_year_id, $current_class_id, $obj->id); ?>
                        
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php echo ucfirst($obj->name); ?> <br/> <?php echo $obj->phone; ?></td>                                
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="50" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="50" /> 
                                        <?php } ?>
                                        <input type="hidden" value="<?php echo $obj->id; ?>"  name="students[]" />                                       
                                    </td>  
                                    <td><?php if(isset($result) && $result->total_mark > 0 ){ echo $result->total_mark; }else{ echo ''; } ?></td>
                                    <td><?php if(isset($result) && $result->total_obtain_mark > 0 ){ echo $result->total_obtain_mark; }else{ echo ''; } ?></td>
                                    <td><?php if(isset($result) && $result->avg_grade_point > 0 ){ echo $result->avg_grade_point; }else{ echo ''; } ?></td>
                                    <td><?php if(isset($result) && $result->result_status ){ echo $this->lang->line($result->result_status); }else{ echo ''; } ?></td>
                                    <td><?php echo $position; ?></td>
                                    <td>
                                        <select  class="form-control col-md-7 col-xs-12" name="promotion_class_id[<?php echo $obj->id; ?>]"  required="required">                                
                                            <option value="<?php echo $next_class->id; ?>" <?php if(isset($enroll) && $enroll->class_id == $next_class->id){ echo 'selected="selected"';} ?>><?php echo $next_class->name; ?></option>
                                            <option value="<?php echo $current_class->id; ?>" <?php if(isset($enroll) && $enroll->class_id == $current_class->id){ echo 'selected="selected"';} ?>><?php echo $current_class->name; ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="<?php if(isset($enroll)){ echo $enroll->roll_no;} ?>"  name="roll_no[<?php echo $obj->id; ?>]"  class="form-control col-md-7 col-xs-12 small-field" required="required"  autocomplete="off"/>
                                    </td>
                                </tr>
                            <?php } ?>
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
                        <?php  if (isset($students) && !empty($students)) { ?>
                         <input type="hidden" value="<?php echo $academic_year_id; ?>" name="academic_year_id" />
                         <input type="hidden" value="<?php echo $school_id; ?>" name="school_id" />
                         <input type="hidden" value="<?php echo $current_session_id; ?>" name="current_session_id" />
                         <input type="hidden" value="<?php echo $next_session_id; ?>" name="next_session_id" />
                         <input type="hidden" value="<?php echo $current_class_id; ?>" name="current_class_id" />
                         <input type="hidden" value="<?php echo $next_class_id; ?>" name="next_class_id" />
                         <a href="<?php echo site_url('academic/promotion'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                         <?php if(has_permission(ADD, 'academic', 'promotion')){ ?>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('promote'); ?></button>
                         <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> 
                        <ol>
                            <li><?php echo $this->lang->line('promotion_instruction_1'); ?></li>
                            <li><?php echo $this->lang->line('promotion_instruction_2'); ?></li>
                            <li><?php echo $this->lang->line('promotion_instruction_3'); ?></li>
                            <li><?php echo $this->lang->line('promotion_instruction_4'); ?></li>
                            <li><?php echo $this->lang->line('promotion_instruction_5'); ?></li>
                        </ol>
                    </div>
                </div>
                
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
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            current_class_id =  '<?php echo $current_class_id; ?>';           
            next_class_id =  '<?php echo $next_class_id; ?>';           
            current_session_id =  '<?php echo $current_session_id; ?>';           
            next_session_id =  '<?php echo $next_session_id; ?>';           
        <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
        get_current_class_by_school(school_id, current_class_id); 
        get_next_class_by_school(school_id, next_class_id); 
        
        get_current_session_by_school(school_id, current_session_id); 
        get_next_session_by_school(school_id, next_session_id); 
        
    }); 

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

