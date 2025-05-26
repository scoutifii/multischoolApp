<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bars"></i><small> <?php echo $this->lang->line('manage_lesson_status'); ?></small></h3>
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
                    
                    <ul  class="nav nav-tabs  nav-tab-find  bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_topic_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        
                        <li class="li-class-list">
                                                         
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <?php $teacher_access_data = get_teacher_access_data(); ?>  
                            
                            <?php echo form_open(site_url('lessonplan/status/index'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                             <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                    
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id" id="school_id" onchange="get_class_by_school(this.value, '', '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($school_id) && $school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>
                            
                                    <select  class="form-control col-md-7 col-xs-12" id="class_id" name="class_id" onchange="get_subject_by_class(this.value, '', '');" style="width:auto;">
                                         <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                         
                                    </select>   
                            
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="subject_id" style="width: auto;">                                
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                  
                                    </select>   
                            
                            <?php }else{  ?>
                            
                                <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="class_id" id="class_id" onchange="get_subject_by_class(this.value, '');" style="width: auto;">
                                    <?php if($this->session->userdata('role_id') != STUDENT){ ?>
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php } ?>  
                                    <?php foreach($classes as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT ){ ?>
                                            <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>                                            
                                                 <?php if (!in_array($obj->id, $guardian_class_data)) { continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>                                            
                                                 <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?>                                           
                                    <?php } ?>                                               
                                </select> 
                                <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="subject_id" style="width: auto;">                                
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php foreach($subjects as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT){ ?>                                       
                                            <option value="<?php $obj->id; ?>" <?php if(isset($subject_id) && $subject_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php } ?>                                                                                     
                                    <?php } ?>                                            
                                </select>
                            
                            <?php } ?>                                            
                            <input type="submit" name="find" value="<?php echo $this->lang->line('find'); ?>"  class="btn btn-success btn-sm"/>
                            
                            <?php echo form_close(); ?>
                        </li>    
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_topic_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>   
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>
                                        <th> <?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?> </th>
                                        <th><?php echo $this->lang->line('lesson'); ?>/ <?php echo $this->lang->line('start_date'); ?> - <?php echo $this->lang->line('end_date'); ?>/ <?php echo $this->lang->line('status'); ?> </th>
                                        <th><?php echo $this->lang->line('topic'); ?>/ <?php echo $this->lang->line('start_date'); ?> - <?php echo $this->lang->line('end_date'); ?>/ <?php echo $this->lang->line('status'); ?>  </th>
                                    </tr>
                                </thead>
                                <tbody>   
                                     <?php $lesson_status = get_lesson_status(); ?>       
                                    <?php $count = 1; if(isset($topics) && !empty($topics)){ ?>
                                        <?php foreach($topics as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->subject; ?></td>
                                            <td>
                                                <div  class="fn_lesson_container">
                                                    <?php echo $obj->title; ?><br/>
                                                    <input type="text" class="fn_start_date form-control col-md-7 col-xs-12" placeholder="<?php echo $this->lang->line('start_date'); ?>" value="<?php echo $obj->start_date ? date('d-m-Y', strtotime($obj->start_date)) : ''; ?>" readonly="readonly" />
                                                    <input type="text" class="fn_end_date form-control col-md-7 col-xs-12" placeholder="<?php echo $this->lang->line('end_date'); ?>" value="<?php echo $obj->end_date ? date('d-m-Y', strtotime($obj->end_date)) : ''; ?>"  readonly="readonly"/>
                                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" onchange="update_lesson_status(this.value, '<?php echo $obj->lesson_detail_id; ?>');" style="width: auto;">
                                                        <?php foreach($lesson_status AS $key=>$value){ ?>
                                                            <option value="<?php echo $key; ?>" <?php echo $obj->complete_status == $key ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line($key); ?></option>
                                                        <?php } ?>
                                                    </select> 
                                                </div>     
                                            </td>
                                           
                                            <td>                                                
                                                <?php $topic_list = get_topic_detail_by_topic_id($obj->id); ?>                                                
                                                <?php if(isset($topic_list) && !empty($topic_list)){ ?>
                                                <?php foreach($topic_list AS $td){ ?>
                                                    <div  class="fn_topic_container">
                                                         <?php echo $td->title; ?><br/>
                                                         <input type="text" class="fn_start_date form-control col-md-7 col-xs-12" placeholder="<?php echo $this->lang->line('start_date'); ?>"  value="<?php echo $td->start_date ? date('d-m-Y', strtotime($td->start_date)) : ''; ?>" readonly="readonly" />
                                                         <input type="text" class="fn_end_date form-control col-md-7 col-xs-12" placeholder="<?php echo $this->lang->line('end_date'); ?>" value="<?php echo $td->end_date ? date('d-m-Y', strtotime($td->end_date)) : ''; ?>" readonly="readonly" />
                                                         <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  onchange="update_topic_status(this.value, '<?php echo $td->id; ?>');" style="width: auto;">
                                                            <?php foreach($lesson_status AS $key=>$value){ ?>
                                                                <option value="<?php echo $key; ?>" <?php echo $td->complete_status == $key ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line($key); ?></option>
                                                            <?php } ?>
                                                        </select>  
                                                         <div class="topic-sep"></div>
                                                    </div>
                                                <?php } } ?>
                                            </td>
                                           
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>                    
                            
                        </div>
                        
                    </div>
             
                </div>
            </div>
        </div>
    </div>
</div>

 <script type="text/javascript">  

    <?php if(isset($school_id) && $school_id != '' && isset($class_id)){ ?>
        get_class_by_school('<?php echo $school_id; ?>', '<?php echo $class_id; ?>', '');
    <?php } ?>    
    
    function get_class_by_school(school_id, class_id, form){
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                     $('#'+form+'class_id').html(response);                    
               }
            }
        });
    }
    
    <?php if(isset($class_id) && isset($subject_id)){ ?>
        get_subject_by_class('<?php echo $class_id; ?>', '<?php echo $subject_id; ?>');
    <?php } ?>
        
    function get_subject_by_class(class_id, subject_id){       
           
        var school_id = $('#school_id').val();       
        if(!school_id){
            school_id = '<?php echo $school_id; ?>';
        }     
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id : subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   $('#subject_id').html(response);                  
               }
            }
        });
   }   
   
   
   function update_lesson_status(status, lesson_detail_id){
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('lessonplan/status/update_lesson_status'); ?>",
            data   : { lesson_detail_id : lesson_detail_id , status : status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   toastr.success('<?php echo $this->lang->line('update_success'); ?>');            
               }else{
                   toastr.error('<?php echo $this->lang->line('update_failed'); ?>'); 
               }
            }
        });
   }
  
    function update_topic_status(status, topic_detail_id){      
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('lessonplan/status/update_topic_status'); ?>",
            data   : { topic_detail_id : topic_detail_id , status : status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   toastr.success('<?php echo $this->lang->line('update_success'); ?>');            
               }else{
                   toastr.error('<?php echo $this->lang->line('update_failed'); ?>'); 
               }
            }
        });
   }    
 
</script> 