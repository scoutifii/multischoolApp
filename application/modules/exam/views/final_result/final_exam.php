<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_exam_final_result'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
                         
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>  
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('exam/finalresult/index'), array('name' => 'result', 'id' => 'result', 'class' => 'form-horizontal form-label-left'), ''); ?>
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
                    <!--div class="col-md-3 col-sm-3 col-xs-12 display">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($exams as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div-->
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value,'');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
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

           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4  col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('exam_final_result'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('exam/finalresult/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                
                <?php if (isset($students) && !empty($students)) { ?>
                
                 <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>                            
                            <th><?php echo $this->lang->line('exam_title'); ?></th>                                            
                            <th><?php echo $this->lang->line('total_subject'); ?></th>                                            
                            <th><?php echo $this->lang->line('exam_mark'); ?></th>                                            
                            <th><?php echo $this->lang->line('obtain_mark'); ?></th>                                            
                            <!--th> <?php echo $this->lang->line('average_grade_point'); ?></th-->                                            
                            <th><?php echo $this->lang->line('letter_grade'); ?></th>                                            
                            <th><?php echo $this->lang->line('remark'); ?></th>                                            
                        </tr>
                    </thead>
                    <tbody id="fn_result">   
                            <?php  $count = 1; foreach ($students as $obj) { ?>                           
                            <?php  $result = get_exam_final_result($school_id, $obj->id, $academic_year_id,  $class_id, $section_id ); ?>
                                
                                <tr>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td><?php echo ucfirst($obj->name); ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="45" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                        <?php } ?>
                                        <input type="hidden" value="<?php echo $obj->id; ?>"  name="students[]" />       
                                    </td>  
                                    
                                    <?php     
                                    /*
                                    $remark = "";
                                    $exam_title = "";
                                    $subject = "";
                                    $total_subject = "";
                                    
                                    $exam_mark = "";
                                    $exam_total_mark = "";
                                    
                                    $obtain_mark = "";
                                    $obtain_total_mark = "";
                                    
                                    $grade_point = "";
                                    $total_grade_point = "";
                                    
                                    $avg_grade_point = "";
                                   
                                    $total_exam = 1;
                                     */    
                                    
                                       $ex = $exam; 
                                                                             
                                       $mark = get_exam_result($school_id, $ex->id, $obj->id, $academic_year_id,  $class_id, $section_id );
                                    
                                       if(empty($mark)){
                                           continue;
                                       } 
                                         
                                       $remark = $mark->remark ;
                                       $subject = $mark->total_subject > 0 ? $mark->total_subject : '';
                                       $total_subject = (int)$mark->total_subject;
                                       
                                       $exam_mark = $mark->total_mark.'<br/>';
                                       $exam_total_mark = $mark->total_mark;
                                       
                                       
                                       $obtain_mark = $mark->total_obtain_mark;
                                       $obtain_total_mark = $mark->total_obtain_mark;
                                       
                                       $grade_point = $mark->avg_grade_point > 0 ? $mark->avg_grade_point : '';
                                       $total_grade_point = $mark->avg_grade_point > 0 ? $mark->avg_grade_point : '';
                                       
                                                                                                         
                                    ?>                                    
                                    <td width="15%"> <?php echo $ex->title; ?></td>
                                    <td> 
                                        <?php echo $subject; ?>
                                        <input type="hidden" name="total_subject[<?php echo $obj->id; ?>]" value="<?php echo $total_subject; ?>"  autocomplete="off"/>
                                    </td>
                                    <td>
                                        <?php echo $exam_mark; ?>
                                        <input type="hidden" name="total_mark[<?php echo $obj->id; ?>]" value="<?php echo $exam_total_mark; ?>"  autocomplete="off"/>
                                    </td> 
                                    <td>
                                        <input class="form-control col-md-7 col-xs-12 " type="text" name="total_obtain_mark[<?php echo $obj->id; ?>]" value="<?php echo $obtain_total_mark; ?>" style="width: 60px;"  autocomplete="off"/>
                                    </td>                                                                   
                                    <td>
                                        <input class="form-control col-md-7 col-xs-12 " type="text" name="avg_grade_point[<?php echo $obj->id; ?>]" value="<?php echo $total_grade_point; ?>" style="width: 60px;"  autocomplete="off"/>
                                    </td>  
                                    <td>
                                        <select class="form-control col-md-7 col-xs-12" name="grade_id[<?php echo $obj->id; ?>]"  required="required">                                
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             <?php foreach ($grades as $grade) { ?>
                                            <option value="<?php echo $grade->id; ?>" <?php if(isset($result) && $result->grade_id == $grade->id){ echo 'selected="selected"';} ?>><?php echo $grade->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>                                    
                                    <td><input type="text" value="<?php if(isset($result) && $result->remark != ''){ echo $result->remark; }else{ echo $remark; } ?>"  name="remark[<?php echo $obj->id; ?>]" class="form-control col-md-7 col-xs-12"  autocomplete="off"/></td>
                                </tr>
                            <?php } ?>                       
                    </tbody>
                </table>
                
                <?php } ?>
                             
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <?php  if (isset($students) && !empty($students)) { ?>
                         <input type="hidden" value="<?php echo $school_id; ?>" name="school_id"/>
                         <input type="hidden" value="<?php echo $term_id; ?>" name="term_id"/>
                         <input type="hidden" value="<?php echo $exam_id; ?>" name="exam_id"/>
                         <input type="hidden" value="<?php echo $class_id; ?>" name="class_id"/>
                         <input type="hidden" value="<?php echo $section_id; ?>" name="section_id"/>
                         <a href="<?php echo site_url('exam/finalresult/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                         <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_result_instruction'); ?></div>
                </div>
                
            </div> 
            
        </div>
    </div>
</div>



<!-- Super admin js START  -->
 <script type="text/javascript">
        
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
        
        var school_id = $(this).val();
        var exam_id = '';
        var class_id = '';
        var term_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';           
            class_id =  '<?php echo $class_id; ?>';
            term_id = '<?php echo $term_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        
        // need to check  school result based on final exam or all exam        
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_school_info_by_id'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(response == 1){ // final_exam
                       $('.display').show();
                       $('#exam_id').prop('required', true);
                       get_exam_by_school(school_id, exam_id);
                   }else{
                       $('#exam_id').prop('required', false);
                       $('.display').hide(); 
                   }                   
                   get_class_by_school(school_id,class_id);
                   get_term_by_school(school_id, term_id); 
               }
            }
        });       
       
    }); 
    
    /*function get_exam_by_school(school_id, exam_id){
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data   : { school_id:school_id, exam_id:exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                   $('#exam_id').html(response); 
               }
            }
        });
    }*/

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
            data   : {school_id:school_id, class_id : class_id , section_id: section_id},               
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
 $("#add").validate(); 
 
</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>


