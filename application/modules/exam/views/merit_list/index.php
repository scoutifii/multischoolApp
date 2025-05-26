<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_merit_list'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
                            
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      
                        
            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('exam/meritlist/index'), array('name' => 'result', 'id' => 'result', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">  
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('term'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="term_id" id="term_id"  required="required" onchange="get_exam_by_term(this.value,'');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($terms as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($term_id) && $term_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('term_id'); ?></div>
                        </div>
                    </div>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group">
                            <div><?php echo $this->lang->line('exam'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>

                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
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
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">             
                <div class="row">                                                      
                    <div class="col-sm-6  col-xs-6 col-sm-offset-3 col-xs-offset-3 layout-box">
                        <p> &nbsp;
                            <?php if(isset($school)){ ?>
                            <div><img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="70"/></div>
                            <h4><p><?php echo $school->school_name; ?></p></h4>
                            <p> <?php echo $school->address; ?></p>
                            <?php } ?>
                            <h4 class="head-title_ ptint-title"><small> <?php echo $this->lang->line('merit_list'); ?> </small></h4>                
                            <?php if(isset($academic_year)){ ?>
                            <div> &nbsp;
                            <?php echo $this->lang->line('academic_year'); ?>: <?php echo $academic_year; ?>
                            </div>
                            <?php } ?>
                            <div>
                            <?php if(isset($class)){ ?>
                            <p><?php echo $this->lang->line('class'); ?>: <?php echo $class; ?>
                            <?php } ?>
                            <?php if(isset($section)){ ?>
                            , <?php echo $this->lang->line('section'); ?>: <?php echo $section; ?>
                            <?php } ?>
                            <?php if(isset($term)){ ?>
                            , <?php echo $this->lang->line('term'); ?>: <?php echo $term; ?>
                            <?php } ?>                            
                            <?php if(isset($exam)){ ?>
                            , <?php echo $this->lang->line('exam'); ?>: <?php echo $exam; ?></p>
                            <?php } ?>
                            </div>
                         </p>
                    </div>
                </div>            
            </div>
            
            <?php  if (isset($examresult) && !empty($examresult)) { ?>
            <div class="x_content">
                <table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <?php  foreach($examresult as $exam) { ?>
                            <tbody>
                                <?php

                            $exam_subjects = get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $exam->section_id, $exam->id);
                            $count = 1;
                             ?>                            
                        <tr>
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                            <th><?php echo $this->lang->line('registration_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <?php foreach ($exam_subjects as $obj) { ?>
                            <td><?php echo ucfirst($obj->subject); ?></td><td></td>
                            <?php } ?>                            
                            
                            <th><?php echo $this->lang->line('full_mark'); ?></th>
                            <th><?php echo $this->lang->line('point'); ?></th>
                            <th><?php echo $this->lang->line('grade'); ?></th>                              
                            <th><?php echo $this->lang->line('remark'); ?></th> 
                        </tr>
                        <?php break; } ?>

                                <?php foreach($examresult as $obj){ ?>
                                <?php $exam_subjects = get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $obj->section_id, $obj->id); 
                                 $exam = get_exam_result($school_id, $exam_id, $obj->id, $academic_year_id, $class_id, $obj->section_id); 
                                 ?> 
                                <tr>
                                    <td width='5%'><?php echo $obj->roll_no; ?></td>
                                    <td width='10%'><?php echo $obj->admission_no; ?></td>
                                    <td width='20%'><?php echo $obj->name; ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="45" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                        <?php } ?>
                                        <input type="hidden" value="<?php echo $obj->id; ?>"  name="students[]" />   
                                    </td>
                                    <?php foreach ($exam_subjects as $obj) { ?>
                                        <td width='5%'><?php echo $obj->written_obtain; ?><td width='2%'><?php echo $obj->grade_id; ?></td></td>
                                    <?php } ?>
                                    
                                    <td width='5%'><?php echo $exam->total_obtain_mark; ?></td>
                                    <td width='5%'><?php echo $exam->avg_grade_point; ?></td>
                                    <td width='5%'><?php echo $exam->grade_id; ?></td>
                                    <td width="5%"><?php echo $obj->remark; ?></td>
                                </tr>
                                <?php } ?>
                        </tbody>
                </table>                
            </div>  
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
         <?php if(isset($school_id) && !empty($school_id) && $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var academic_year_id = '';
        var class_id = '';
        var term_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            academic_year_id =  '<?php echo $academic_year_id; ?>';     
            class_id =  '<?php echo $class_id; ?>';
            term_id = '<?php echo $term_id; ?>';           
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
                    $('#term_id').html(response);  
                    get_class_by_school(school_id,class_id);
                    get_term_by_school(school_id, term_id); 
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

   function get_term_by_school(school_id, term_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_term_by_school'); ?>",
            data   : { school_id:school_id, term_id:term_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#term_id').html(response); 
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
            data   : {school_id : school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        });         
    } 

    <?php if(isset($term_id)){ ?>
        get_exam_by_term('<?php echo $term_id; ?>', '<?php echo $exam_id; ?>');
    <?php } ?>  
    function get_exam_by_term(term_id, exam_id){       
         
        var school_id = $('#school_id').val();
    
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_term'); ?>",
            data   : {school_id:school_id, term_id : term_id,  exam_id : exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response){
                  $('#exam_id').html(response); 
                }
            }
        }); 
   }

    $("#result").validate(); 
 
</script>
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
              search: true
          });
        });
</script>