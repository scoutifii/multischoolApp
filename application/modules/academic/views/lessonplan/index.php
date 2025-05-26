<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-headphones"></i><small> <?php echo $this->lang->line('manage_lesson_plan'); ?></small></h3>
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
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_lessonplan_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'academic', 'lessonplan')){ ?>                        
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('academic/lessonplan/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('lesson_plan'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_lessonplan"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('lesson_plan'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_lessonplan"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>               
                        
                         
                            <li class="li-class-list">
                                
                            <?php $teacher_access_data = get_teacher_access_data('student'); ?> 
                            <?php $guardian_access_data = get_guardian_access_data('class'); ?>    
                                
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                
                                <?php echo form_open(site_url('academic/lessonplan/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id"  onchange="get_class_by_school_filter(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>
                                    <select  class="form-control col-md-7 col-xs-12" id="filter_class_id" name="class_id"  style="width:auto;" onchange="this.form.submit();">
                                         <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    </select>
                                   <?php echo form_close(); ?>
                                
                            <?php }else{  ?>
                                
                                    <select  class="form-control col-md-7 col-xs-12" onchange="get_lesson_plan_list_by_class(this.value);">
                                        <option value="<?php echo site_url('academic/lessonplan/index'); ?>">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php foreach($class_list as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                                <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?> 
                                                <option value="<?php echo site_url('academic/lessonplan/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>
                                                <?php if (!in_array($obj->id, $guardian_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('academic/lessonplan/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>
                                                <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('academic/lessonplan/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo site_url('academic/lessonplan/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?> 

                                        <?php } ?>                                            
                                    </select>                                      
                                <?php } ?>
                            </li>    
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_lessonplan_list" >                            
                            <div class="x_content">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <th><?php echo $this->lang->line('school'); ?></th>
                                            <?php } ?>
                                            <th><?php echo $this->lang->line('academic_year'); ?></th>
                                            <th><?php echo $this->lang->line('class'); ?></th>                                      
                                            <th><?php echo $this->lang->line('subject'); ?></th>                                       
                                            <th><?php echo $this->lang->line('teacher'); ?></th>                                       
                                            <th><?php echo $this->lang->line('lesson'); ?></th>                                          
                                            <th><?php echo $this->lang->line('action'); ?></th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>   
                                                                                
                                        <?php $count = 1; if(isset($lessons) && !empty($lessons)){ ?>
                                            <?php foreach($lessons as $obj){ ?>                                        
                                            <?php 
                                                if($this->session->userdata('role_id') == GUARDIAN){
                                                    if (!in_array($obj->class_id, $guardian_access_data)) { continue; }
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                    <td><?php echo $obj->school_name; ?></td>
                                                <?php } ?>
                                                <td><?php echo $obj->session_year; ?></td>
                                                <td><?php echo $obj->class_name; ?></td>
                                                <td><?php echo $obj->subject; ?></td>
                                                <td><?php echo $obj->teacher; ?></td>
                                                <td><?php echo $obj->lesson_title; ?></td>
                                                
                                                <td>                                                    
                                                    <?php if(has_permission(VIEW, 'academic', 'lessonplan')) {?>
                                                    <?php } ?> 
                                                        
                                                    <?php if(has_permission(EDIT, 'academic', 'lessonplan')){ ?>
                                                        <a href="<?php echo site_url('academic/lessonplan/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                    <?php } ?>                                                    
                                                    <?php if(has_permission(DELETE, 'academic', 'lessonplan')){ ?>
                                                        <a href="<?php echo site_url('academic/lessonplan/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('conirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- End first tab -->
                        
                        

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_lessonplan">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('academic/lessonplan/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>  
                                

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('lesson'); ?><span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <table style="width:100%;" class="fn_lesson_plan_container responsive">
                                            <tr>               
                                              <td>
                                                  <input  class="form-control col-md-12 col-xs-12" type="text" name="lesson_title[]" placeholder="<?php echo $this->lang->line('lesson'); ?>" value="<?php echo isset($post['lesson_title']) ?  $post['lesson_title'] : ''; ?>"/>
                                              </td>
                                              <td>
                                              </td>
                                            </tr>                                           
                                          </table>
                                        <div class="help-block">
                                            <?php echo form_error('answer'); ?>
                                            <a href="javascript:void(0);" class="btn btn-success btn-xs" onclick="add_more('fn_lesson_plan_container');"><?php echo $this->lang->line('add_more'); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id" id="add_class_id" required="required" onchange="get_subject_by_class(this.value, ''); get_section_by_class(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                   <?php
                                                    if($this->session->userdata('role_id') == TEACHER){
                                                       if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                    } 
                                                    ?>
                                                   <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="section_id"><?php echo $this->lang->line('section'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="section_id" id="add_section_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                       
                                        </select>
                                        <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                    </div>
                                </div>
                                
                                                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 data_subject"  name="subject_id" id="add_subject_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>
                                
                                <?php if($this->session->userdata('role_id') != TEACHER){ ?>  
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="teacher_id"><?php echo $this->lang->line('teacher'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-7 col-xs-12 data_subject"  name="teacher_id" id="add_teacher_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                 <?php if(isset($teachers) && !empty($teachers)){ ?>
                                                    <?php foreach($teachers as $obj ){ ?>                                                   
                                                       <option value="<?php echo $obj->id; ?>" <?php echo isset($post['teacher_id']) && $post['teacher_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                    <?php } ?>                                            
                                                <?php } ?>  
                                            </select>
                                            <div class="help-block"><?php echo form_error('teacher_id'); ?></div>
                                        </div>
                                    </div>
                                
                                <?php }else{ ?>
                                
                                    <div class="item form-group">                                       
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" name="teacher_id" id="add_teacher_id" value="<?php echo logged_in_user_id(); ?>" />
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                
                                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('academic/lessonplan/index/'.$class_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>                              
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_lessonplan">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('academic/lessonplan/edit/'.$lesson->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                 
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('lesson'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <table style="width:100%;" class="fn_edit_stop_container responsive"> 
                                             <tr>               
                                                 <td><?php echo $this->lang->line('lesson'); ?></td>
                                                 <!--td><?php echo $this->lang->line('lesson'); ?></td>
                                                 <td><?php echo $this->lang->line('lesson'); ?></td-->
                                             </tr>
                                            <?php $counter = 1; foreach($lesson_plans as $obj){ ?> 
                                            <tr>               
                                              <td>                                                  
                                                  <input type="hidden" name="lesson_id[]" value="<?php echo $obj->id; ?>" />
                                                  <input  class="form-control col-md-12 col-xs-12" type="text" name="lesson_title[]" value="<?php echo $obj->lesson_title; ?>" placeholder="<?php echo $this->lang->line('lesson'); ?>" />
                                              </td>
                                              
                                              <td>
                                                  <?php if($counter > 1){ ?>
                                                  <a  class="btn btn-danger btn-md " onclick="remove(this, <?php echo $obj->id; ?>);" style="margin-bottom: -0px;" > - </a>
                                                  <?php } ?>
                                              </td>
                                            </tr> 
                                            <?php $counter++; } ?>
                                            
                                          </table>
                                        <div class="help-block">
                                            <?php echo form_error('answer'); ?>
                                            <a href="javascript:void(0);" class="btn btn-success btn-xs" onclick="add_more('fn_edit_stop_container');"><?php echo $this->lang->line('add_more'); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id" id="edit_class_id" required="required" onchange="get_subject_by_class(this.value, ''); get_section_by_class(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php foreach($classes as $obj ){ ?>
                                                <?php
                                                if($this->session->userdata('role_id') == TEACHER){
                                                   if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                } 
                                                ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($obj->id == $lesson->class_id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="section_id"><?php echo $this->lang->line('section'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="section_id" id="edit_section_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                       
                                        </select>
                                        <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                    </div>
                                </div>
                                                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 data_subject"  name="subject_id" id="edit_subject_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>
                                
                                <?php if($this->session->userdata('role_id') != TEACHER){ ?>  
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="teacher_id"><?php echo $this->lang->line('teacher'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-7 col-xs-12 data_subject"  name="teacher_id" id="edit_teacher_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                <?php if(isset($teachers) && !empty($teachers)){ ?>
                                                    <?php foreach($teachers as $obj ){ ?>                                                   
                                                       <option value="<?php echo $obj->id; ?>" <?php echo isset($lesson->teacher_id) && $lesson->teacher_id == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                    <?php } ?>                                            
                                                <?php } ?>  
                                            </select>
                                            <div class="help-block"><?php echo form_error('teacher_id'); ?></div>
                                        </div>
                                    </div>
                                
                                <?php }else{ ?>
                                
                                    <div class="item form-group">                                       
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" name="teacher_id" id="edit_teacher_id" value="<?php echo logged_in_user_id(); ?>" />
                                        </div>
                                    </div>
                                
                                <?php } ?>
                                                                                            
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($lesson->note) ?  $lesson->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($lesson) ? $lesson->id : $id; ?>" name="id" />
                                        <a  href="<?php echo site_url('academic/lessonplan/index/'.$class_id); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div-->  
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <link href="<?php echo VENDOR_URL; ?>timepicker/timepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>timepicker/timepicker.js"></script>
 
 
<!-- Super admin js START  -->
 <script type="text/javascript">
     
    var edit = false;
    $("document").ready(function() {
         <?php if(isset($edit) && !empty($edit) && $this->session->userdata('role_id') != TEACHER){ ?>
            edit = true;       
            $("#edit_school_id").trigger('change');
         <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var teacher_id = '';
        var class_id = '';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            teacher_id =  '<?php echo $live_class->teacher_id; ?>';           
            class_id =  '<?php echo $live_class->class_id; ?>';           
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        
        get_class_by_school(school_id, class_id);  
        get_teacher_by_school(school_id, teacher_id);
        
    }); 

   function get_class_by_school(school_id, class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_class_id').html(response);   
                   }else{
                       $('#add_class_id').html(response);   
                   }                  
               }
            }
        });                  
        
   }
  
   function get_teacher_by_school(school_id, teacher_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_teacher_by_school'); ?>",
            data   : { school_id:school_id, teacher_id:teacher_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_teacher_id').html(response);   
                   }else{
                       $('#add_teacher_id').html(response);   
                   }                  
               }
            }
        });                  
        
   }
  
   
  </script>
<!-- Super admin js end -->
 
 
 <script type="text/javascript">
     
  $('#add_class_date').datepicker();  
  $('#add_start_time').timepicker();
  $('#add_end_time').timepicker();
  
  $('#edit_class_date').datepicker();
  $('#edit_start_time').timepicker();
  $('#edit_end_time').timepicker();
  
  
    <?php if(isset($edit)){ ?>
        edit = true;
        get_subject_by_class('<?php echo $lessonplan->class_id; ?>', '<?php echo $lessonplan->subject_id; ?>');
    <?php } ?>
         
    function get_subject_by_class(class_id, subject_id){       
         
        var school_id = '';
       
        <?php if(isset($edit)){ ?>                
            school_id = $('#edit_school_id').val();
         <?php }else{ ?> 
            school_id = $('#add_school_id').val();
         <?php } ?> 
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id,  subject_id : subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                        $('#edit_subject_id').html(response);
                   }else{
                      $('#add_subject_id').html(response); 
                   }
               }
            }
        }); 
   }
   
    <?php if(isset($edit)){ ?>
        edit = true;
        get_section_by_class('<?php echo $lessonplan->class_id; ?>', '<?php echo $lessonplan->section_id; ?>');
    <?php } ?>
         
    function get_section_by_class(class_id, section_id){       
         
        var school_id = '';
       
        <?php if(isset($edit)){ ?>                
            school_id = $('#edit_school_id').val();
         <?php }else{ ?> 
            school_id = $('#add_school_id').val();
         <?php } ?> 
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id,  section_id : section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                       $('#edit_section_id').html(response);
                   }else{
                       $('#add_section_id').html(response); 
                   }
               }
            }
        }); 
   }

   <?php if(isset($edit)){ ?>
        edit = true;
        get_section_by_class('<?php echo $lessonplan->class_id; ?>', '<?php echo $lessonplan->teacher_id; ?>');
    <?php } ?>
         
    function get_teacher_by_class(class_id, teacher_id){       
         
        var school_id = '';
       
        <?php if(isset($edit)){ ?>                
            school_id = $('#edit_school_id').val();
         <?php }else{ ?> 
            school_id = $('#add_school_id').val();
         <?php } ?> 
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_teacher_by_class'); ?>",
            data   : {school_id:school_id, class_id: class_id,  teacher_id: teacher_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                       $('#edit_teacher_id').html(response);
                   }else{
                       $('#add_teacher_id').html(response); 
                   }
               }
            }
        }); 
   }
  
</script>



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
        }); 
        
    /* Menu Filter Start */ 
    
    function get_lesson_plan_list_by_class(url){          
       if(url){
           window.location.href = url; 
       }
    }        
        
    <?php if(isset($filter_class_id)){ ?>
        get_class_by_school_filter('<?php echo $filter_school_id; ?>', '<?php echo $filter_class_id; ?>');
    <?php } ?>
    
    function get_class_by_school_filter(school_id, class_id){
                
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_class_id').html(response);                     
               }
            }
        });
    }    

        
    $("#add").validate();     
    $("#edit").validate(); 

  
    function add_more(fn_stop_container){
         var data = '<tr>'                
                    +'<td style="width:100%;">'                   
                    +'<input  class="form-control col-md-12 col-xs-12" type="text" name="lesson_title[]" class="answer" placeholder="<?php echo $this->lang->line('lesson'); ?>" />' 
                    +'</td>'
                    /*+'<td>'  
                    +'<input  class="form-control col-md-12 col-xs-12" style="width:auto;" type="text" name="lesson_title[]" value="" placeholder="<?php echo $this->lang->line('lesson'); ?>"/>'
                    +'</td>'
                    +'<td>'  
                    +'<input  class="form-control col-md-12 col-xs-12" style="width:auto;" type="text" name="lesson_title[]" value="" placeholder="<?php echo $this->lang->line('lesson'); ?>"/>'
                    +'</td>'*/
                    +'<td>'  
                    +'<a  class="btn btn-danger btn-md " onclick="remove(this);" style="margin-bottom: -0px;" > - </a>'
                    +'</td>'
                    +'</tr>';
            $('.'+fn_stop_container).append(data);
     }
     
     
     function remove(obj, lesson_id){ 
        
        // remove lesson from database
        if(lesson_id)
        {
            if(confirm('<?php echo $this->lang->line('confirm_alert'); ?>')){
                $.ajax({       
                    type   : "POST",
                    url    : "<?php echo site_url('academic/lessonplan/remove_lesson_plan'); ?>",
                    data   : { lesson_id : lesson_id},               
                    async  : false,
                    success: function(response){                                                   
                       if(response)
                       {
                          $(obj).parent().parent('tr').remove();   
                       }
                    }
                });   
            }            
        }else{
            
            $(obj).parent().parent('tr').remove(); 
        }
     }

</script>