<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-users"></i><small> <?php echo $this->lang->line('manage_bulk_admission'); ?></small></h3>
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
                        <?php if(has_permission(ADD, 'student', 'student')){ ?>
                            <li  class="active"><a href="#tab_add_bulk_student"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                        <?php } ?>                        
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                       
                        <div  class="tab-pane fade in active" id="tab_add_bulk_student">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('student/bulk/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                       
                                <div class="row">                                      
                                
                                    <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                        <?php $schools = get_school_list(); ?>                                        
                                       <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="school_id"><?php echo $this->lang->line('school'); ?> <span class="required">*</span></label>
                                             <select  class="form-control col-md-7 col-xs-12 fn_school_id" name="school_id" id="school_id" required="required" onchange="get_ay_and_class_by_school(this.value);">
                                                    <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option>
                                                    <?php foreach($schools as $obj){ ?>
                                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($school_id) && $school_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->school_name; ?></option>
                                                    <?php } ?>
                                             </select>
                                            <div class="help-block"><?php echo form_error('school_id'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                      <div class="item form-group">
                                          <label for="academic_year_id"><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></label>
                                          <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                             <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                         </select>
                                         <div class="help-block"><?php echo form_error('academic_year_id'); ?></div>
                                      </div>
                                    </div>
                                    <?php }else{ ?>                                       
                                        <input class="fn_school_id" type="hidden" name="school_id" id="school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="academic_year_id"><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></label>
                                             <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($academic_years as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($post['academic_year_id']) && $post['academic_year_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->session_year; if($obj->is_running){ echo ' ['.$this->lang->line('running_year').']'; } ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('academic_year_id'); ?></div>
                                         </div>
                                     </div>
                                    <?php } ?>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                             <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id" required="required" onchange="get_section_by_class(this.value);">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($classes as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="section_id"><?php echo $this->lang->line('section'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                         </div>
                                     </div> 
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                             <label for="">&nbsp;</label>
                                            <a href="<?php echo ASSET_URL; ?>csv/bulk_student.csv"  class="btn btn-success btn-md"><?php echo $this->lang->line('generate_csv'); ?></a>
                                         </div>
                                     </div> 
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                             <label ><?php echo $this->lang->line('csv_file'); ?>&nbsp;</label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="bulk_student"  id="bulk_student" type="file">
                                            </div>
                                         </div>
                                     </div>
                                </div>
                                
                                                            
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a  href="<?php echo site_url('student'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> 
                                        <ol>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <li><?php echo $this->lang->line('bulk_student_instruction_1'); ?></li>
                                            <?php }else{ ?>
                                                <li><?php echo $this->lang->line('bulk_student_instruction_2'); ?></li>
                                            <?php } ?>
                                            <li><?php echo $this->lang->line('bulk_student_instruction_3'); ?></li>
                                            <li><?php echo $this->lang->line('bulk_student_instruction_4'); ?> </li>
                                            <li><?php echo $this->lang->line('gender'); ?>: [ male, female ] <span class="required">*</span></li>
                                            <li><?php echo $this->lang->line('academic_group'); ?>: [ science, arts, commerce ]</li>
                                            <li><?php echo $this->lang->line('blood_group'); ?>: [ a_positive, a_negative, b_positive, b_negative, o_positive, o_negative, ab_positive, ab_negative ]</li>
                                            <li>
                                                <?php echo $this->lang->line('bulk_student_instruction_7'); ?>
                                                <a target="_blank" href="<?php echo site_url('student/type/index'); ?>"><?php echo $this->lang->line('student_type'); ?></a>
                                            </li>
                                            <li>
                                                <?php echo $this->lang->line('bulk_student_instruction_8'); ?>
                                                <a target="_blank" href="<?php echo site_url('accounting/discount'); ?>"><?php echo $this->lang->line('discount'); ?></a>
                                            </li>
                                            <li><?php echo $this->lang->line('bulk_student_instruction_5'); ?></li>
                                            <li><?php echo $this->lang->line('bulk_student_instruction_6'); ?></li>
                                        </ol>
                                    </div>
                                </div>
                                
                            </div>
                        </div>  
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- datatable with buttons -->
 <script type="text/javascript">
  
      function get_ay_and_class_by_school(school_id){
          
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                     
                  $('#academic_year_id').html(response); 
               }
            }
        });
        
        
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
        
    }
    
    function get_section_by_class(class_id){       
       
        var school_id = $('#school_id').val();
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { class_id : class_id, school_id : school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);                  
               }
            }
        }); 
   }
  </script>
  
 <script type="text/javascript">      
    $("#add").validate();     
</script>