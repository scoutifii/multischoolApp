<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small><?php echo $this->lang->line('manage_result_card'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>               
                             
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div> 

            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('exam/resultcard/all'), array('name' => 'resultcard', 'id' => 'resultcard', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">  
                    
                    <?php $this->load->view('layout/school_list_filter'); ?> 
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required" onchange="get_term_by_academic_year(this.value,'');">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php foreach ($academic_years as $obj) { ?>
                                <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('term'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="term_id" id="term_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                
                            </select>
                            <div class="help-block"><?php echo form_error('term_id'); ?></div>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('role_id') != STUDENT ){ ?>    
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value,'');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue;  ?>
                                    <?php }elseif($this->session->userdata('role_id') == GUARDIAN && !in_array($obj->id, $guardian_class_data)){ continue; } ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>                    
                    <?php } ?>    
                
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            
            <?php  if (isset($students) && !empty($students)) { ?>
            <?php  foreach($students as $std) { ?>
                <div class="x_content print_area"> 
                    <div class="profile_img">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 col-12">
                                    <div class="row justify-content-md-center">
                                    <?php if (isset($school->school_name) && !empty($school->school_name)) { ?>
                                        <div class="text-center">
                                            <h1 class="text-uppercase" style="color: #000000;font-size: 48px;font-weight: bold;"><?php echo $school->school_name; ?></h1>
                                            <?php echo $school->address; ?><br>
                                            <?php echo $school->box_no; ?> Tel. no: <?php echo $school->phone; ?> /<?php echo $school->phone2; ?> /<?php echo $school->phone3; ?><br>
                                            Email Address: <?php echo $school->email; ?>, Web Address: <?php echo $school->web_address; ?>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="row">     
                                <div class="col-sm-3">
                                    <div class="col-padding">        
                                        <div class="text-center">
                                            <div class="profile-pic2">
                                                <?php if ($school->logo != '') { ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="100px;" hight="110px;"/> 
                                                <?php } else { ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>   
                                </div><br><br>
                                <div class="col-sm-6">
                                      <div class="col-padding">
                                        <h3 class="text-uppercase" style="color: #000000; text-align: center;">Termly Assessment Report</h3>
                                        <div class="text-center">
                                            <div class="row"><?php echo $this->lang->line('name'); ?> : <?php echo $std->name; ?></div>
                                            <div class="row">
                                                <br/>
                                                <?php echo $this->lang->line('class'); ?> : <?php echo $std->class_name; ?>,
                                                <?php echo $this->lang->line('section'); ?> : <?php echo $std->section; ?>,
                                                <?php echo $this->lang->line('admission_no'); ?> : <?php echo $std->admission_no; ?>,
                                                <?php echo $this->lang->line('gender'); ?> : <?php echo $std->gender; ?><br>
                                                <?php echo $this->lang->line('academic_year'); ?> :  <?php echo $school->academic_year; ?>, <?php echo $this->lang->line('term'); ?> : <?php echo $term; ?>, <?php echo $this->lang->line('date'); ?>: <?php echo date('Y-m-d'); ?>
                                            </div>   
                                        </div>
                                     </div>
                                </div>                        
              
                                <div class="col-sm-2">
                                  <div class="col-padding">
                                    <div class="text-right">         
                                        <div class="profile-pic2" style="padding-left: 20px;">
                                           
                                            <?php if ($std->photo != '') { ?>
                                               <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $std->photo; ?>" alt="" width="80" /> 
                                            <?php } else { ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                            <?php } ?>
                                        </div>
                                     </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="x_content">
                <table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>                           
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('subject'); ?></th>
                            <th><?php echo $this->lang->line('ca1'); ?></th>
                            <th><?php echo $this->lang->line('ca2'); ?></th>
                            <th><?php echo $this->lang->line('ca3'); ?></th>
                            <th><?php echo $this->lang->line('ca4'); ?></th>
                            <th><?php echo $this->lang->line('ca5'); ?></th>
                            <th><?php echo $this->lang->line('ca6'); ?></th>
                            <th><?php echo $this->lang->line('total'); ?></th>
                            <th><?php echo $this->lang->line('avg_score'); ?></th>
                            <th><?php echo $this->lang->line('out_of_20'); ?></th>
                            <th><?php echo $this->lang->line('eot_80'); ?></th>
                            <th><?php echo $this->lang->line('total_100'); ?></th>
                            <th><?php echo $this->lang->line('grade'); ?></th>                
                            <th><?php echo $this->lang->line('identifier'); ?></th>
                            <th><?php echo $this->lang->line('descriptor'); ?></th>
                            <th><?php echo $this->lang->line('initials'); ?></th>
                            <th><?php echo $this->lang->line('remark'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="fn_mark"> 
                       
                        <?php if (isset($exams) && !empty($exams)) { ?>
                        <?php foreach($exams as $ex){ ?>
                        
                            <!-- <tr style="background: #f9f9f9;">
                                <th colspan="17"><?php echo $ex->title; ?></th>
                            </tr> -->
                        
                            <?php
                            $exam_subjects = get_subject_list($school_id, $academic_year_id, $ex->id, $class_id, $std->section_id, $std->id);
                            $count = 1;
                            if (isset($exam_subjects) && !empty($exam_subjects)) {
                            ?>
                        
                            <?php foreach ($exam_subjects as $obj) { ?>
                                
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php echo ucfirst($obj->subject); ?></td>
                                    <td><?php echo $obj->written_mark; ?></td>
                                    <td><?php echo $obj->written_obtain; ?></td>
                                    <td><?php echo $obj->tutorial_mark; ?></td>
                                    <td><?php echo $obj->tutorial_obtain; ?></td>
                                    <td><?php echo $obj->practical_mark; ?></td>
                                    <td><?php echo $obj->practical_obtain; ?></td>
                                    <td><?php echo $obj->obtain_total_mark; ?></td>
                                    <td><?php echo $obj->avg_score; ?></td>
                                    <td><?php echo $obj->out_of_20; ?></td>
                                    <td><?php echo $obj->eot_80; ?></td>
                                    <td><?php echo $obj->exam_total_mark; ?></td>
                                    <td><?php echo $obj->grade_id; ?></td>                   
                                    <td><?php echo $obj->identifier; ?></td>
                                    <td><?php echo $obj->descriptor; ?></td>
                                    <td><?php echo $obj->initials; ?></td>
                                    <td><?php echo $obj->remarks; ?></td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="18" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>   
                                
                    <?php } ?>
                    <?php }else{ ?>
                            <tr>
                                <td colspan="18" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                             </tr>    
                     <?php } ?>            
                    </tbody>
                </table>                               
            </div>           
            
            
            <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
            <div class="rowt">
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('principal'); ?>
                </div>
                <div class="col-xs-2 text-center">
                    &nbsp;
                </div>
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('class_teacher'); ?>
                </div>
            </div>&emsp;
            <div class="rowt">
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('signature'); ?>
                </div>
                <div class="col-xs-2 text-center">
                    &nbsp;
                </div>
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('signature'); ?>
                </div>
            </div>
            <div style="float: none; padding-top: 20px;margin-top: 20px;">&nbsp;</div>
            <div class="page-break" style="page-break-after: always !important;"></div>
            <?php } ?>
            <?php } ?>
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 no-print">
                <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('mark_sheet_instruction'); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Super admin js START  -->
 <script type="text/javascript">
        
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)   && $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var academic_year_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            academic_year_id =  '<?php echo $academic_year_id; ?>';     
            class_id =  '<?php echo $class_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id:academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response);  
                    get_class_by_school(school_id,class_id); 
               }
            }
        });
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
                    $('#class_id').html(response); 
               }
            }
        }); 
   }  
   
  </script>
<!-- Super admin js end -->

 <script type="text/javascript">     
  
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){       
       
        var school_id = $('.fn_school_id').val();     
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        });         
    }

    <?php if(isset($academic_year_id)){ ?>
        get_term_by_academic_year('<?php echo $academic_year_id; ?>', '<?php echo $term_id; ?>');
    <?php } ?>
    
    function get_term_by_academic_year(academic_year_id, term_id){
        var school_id = $('#school_id').val();       
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_term_by_academic_year'); ?>",
            data   : {school_id:school_id, academic_year_id: academic_year_id, term_id: term_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#term_id').html(response);
               }
            }
        });         
    }
  $("#marksheet").validate(); 
</script>
<style>
.table>thead>tr>th,.table>tbody>tr>td {
    padding: 2px;
}
</style>