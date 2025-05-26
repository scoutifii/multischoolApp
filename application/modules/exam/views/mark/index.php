<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_mark'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
               
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>               
            
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('exam/mark/index'), array('name' => 'mark', 'id' => 'mark', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    
                    <div class="col-md-10 col-sm-10 col-xs-12">
                    
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
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_subject_by_class(this.value,'','');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue; } ?>   
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
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
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('subject'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="subject_id" id="subject_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                        </div>
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
                            <h4><?php echo $this->lang->line('exam_mark'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('exam/mark/add'), array('name' => 'addmark', 'id' => 'addmark', 'class'=>'form-horizontal form-label-left'), ''); ?>
               
                
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2"><?php echo $this->lang->line('roll_no'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('name'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('photo'); ?></th>
                            <th colspan="15"><?php echo $this->lang->line('exam_mark'); ?></th>                                           
                        </tr>
                        <tr>                           
                            <th><?php echo $this->lang->line('ca1'); ?></th>
                            <th><?php echo $this->lang->line('ca2'); ?></th>
                            <th><?php echo $this->lang->line('ca3'); ?></th>
                            <th><?php echo $this->lang->line('ca4'); ?></th>
                            <th><?php echo $this->lang->line('ca5'); ?></th>
                            <th><?php echo $this->lang->line('ca6'); ?></th>
                            <th><?php echo $this->lang->line('total'); ?></th>
                            <th><?php echo $this->lang->line('eot_80'); ?></th>
                            <th><?php echo $this->lang->line('total_100'); ?></th>
                            <th><?php echo $this->lang->line('grade'); ?></th>
                            <!-- <th><?php echo $this->lang->line('avg_score'); ?></th> -->
                            <th><?php echo $this->lang->line('out_of_20'); ?></th>
                            <th><?php echo $this->lang->line('identifier'); ?></th>
                            <th><?php echo $this->lang->line('descriptor'); ?></th>
                            <th><?php echo $this->lang->line('remark'); ?></th>
                                                                      
                        </tr>
                    </thead>
                    <tbody id="fn_mark">   
                        <?php
                        $count = 1;
                        if (isset($students) && !empty($students)) {
                            ?>
                            <?php foreach ($students as $obj) { ?>
                            <?php  $mark = get_exam_mark($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                            <?php  $attendance = get_exam_attendance($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                                <tr>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td><?php echo ucfirst($obj->student_name); ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="40" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="40" /> 
                                        <?php } ?>
                                    </td>  
                                    <td>
                                        <input type="hidden" value="<?php echo $obj->student_id; ?>"  name="students[]" />                                       
                                        <input type="number" id="written_mark_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->written_mark > 0){ echo $mark->written_mark; }else{ echo '';} ?>"  name="written_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" required="required"  autocomplete="off"/>
                                        <input type="number" name="cummulative_mark1[<?php echo $obj->student_id; ?>]" value="<?php if(!empty($mark) && $mark->cummulative_mark1 > 0){ echo $mark->cummulative_mark1; }else{ echo '';} ?>" id="cummulative_1_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <span class="error"></span>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="written_obtain_<?php echo $obj->student_id; ?>"  itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark) && $mark->written_obtain > 0 ){ echo $mark->written_obtain; }else{ echo ''; } ?>"  name="written_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off" />
                                            <input type="number" name="cummulative_mark2[<?php echo $obj->student_id; ?>]" value="<?php if(!empty($mark) && $mark->cummulative_mark2 > 0){ echo $mark->cummulative_mark2; }else{ echo '';} ?>" id="cummulative_2_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0" id="written_obtain_" name="written_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"/>
                                        <?php } ?>
                                    </td>
                                    
                                    <td>
                                        <input type="number"  id="tutorial_mark_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark) && $mark->tutorial_mark > 0){ echo $mark->tutorial_mark; }else{ echo '';} ?>"  name="tutorial_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                        <input type="number" name="cummulative_mark3[<?php echo $obj->student_id; ?>]"  value="<?php if(!empty($mark) && $mark->cummulative_mark3 > 0){ echo $mark->cummulative_mark3; }else{ echo '';} ?>" id="cummulative_3_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <span class="error"></span>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                        <input type="number"  id="tutorial_obtain_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"   value="<?php if(!empty($mark) && $mark->tutorial_obtain > 0 ){ echo $mark->tutorial_obtain; }else{ echo ''; } ?>"  name="tutorial_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"  autocomplete="off"/>
                                        <input type="number" name="cummulative_mark4[<?php echo $obj->student_id; ?>]" value="<?php if(!empty($mark) && $mark->cummulative_mark4 > 0){ echo $mark->cummulative_mark4; }else{ echo '';} ?>" id="cummulative_4_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <span class="error"></span>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="tutorial_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>
                                    
                                    <td>
                                        <input type="number"  id="practical_mark_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark) && $mark->practical_mark > 0){ echo $mark->practical_mark; }else{ echo '';} ?>"  name="practical_mark[<?php echo $obj->student_id; ?>]" class="form-control col-md-7 form-mark col-xs-12 fn_mark_total"   autocomplete="off"/>
                                        <input type="number" name="cummulative_mark5[<?php echo $obj->student_id; ?>]" value="<?php if(!empty($mark) && $mark->cummulative_mark5 > 0){ echo $mark->cummulative_mark5; }else{ echo '';} ?>" id="cummulative_5_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <span class="error"></span>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="practical_obtain_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"   value="<?php if(!empty($mark) && $mark->practical_obtain > 0 ){ echo $mark->practical_obtain; }else{ echo ''; } ?>"  name="practical_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                            <input type="number" name="cummulative_mark6[<?php echo $obj->student_id; ?>]" value="<?php if(!empty($mark) && $mark->cummulative_mark6 > 0){ echo $mark->cummulative_mark6; }else{ echo '';} ?>" id="cummulative_6_<?php echo $obj->student_id; ?>" class="form-control form-mark col-md-7 col-xs-12">
                                        <span class="error"></span>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="practical_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off"/>
                                        <?php } ?>
                                    </td>
                                    
                                    <td>
                                        <input type="number"  id="obtain_total_mark_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark) && $mark->obtain_total_mark > 0){ echo $mark->obtain_total_mark; }else{ echo '';} ?>"  name="obtain_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"  autocomplete="off"/>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="eot_80_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark) && $mark->eot_80 > 0 ){ echo $mark->eot_80; }else{ echo ''; } ?>"  name="eot_80[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="eot_80[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"   autocomplete="off"/>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="exam_total_mark_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->exam_total_mark > 0){ echo $mark->exam_total_mark; }else{ echo '';} ?>"  name="exam_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value=""  name="exam_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>                         
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="text"  id="grade_id_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->grade_id){ echo $mark->grade_id; }else{ echo '';} ?>"  name="grade_id[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value=""  name="grade_id[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>                                    
                                    <!-- <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="avg_score_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->avg_score > 0 ){ echo $mark->avg_score; }else{ echo ''; } ?>"  name="avg_score[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="avg_score[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" required="required" />
                                        <?php } ?>
                                    </td> -->
                                    
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="out_of_20_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->out_of_20 > 0 ){ echo $mark->out_of_20; }else{ echo ''; } ?>"  name="out_of_20[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value=""  name="out_of_20[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="identifier_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->identifier > 0 ){ echo $mark->identifier; }else{ echo ''; } ?>"  name="identifier[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value=""  name="identifier[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>
                                    
                                     <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="text"  id="descriptor_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->descriptor != '' ){ echo $mark->descriptor; }else{ echo ''; } ?>"  name="descriptor[<?php echo $obj->student_id; ?>]" class="form-control form-descriptor col-md-7 col-xs-12 descriptor" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="text" value=""  name="descriptor[<?php echo $obj->student_id; ?>]" class="form-control form-descriptor col-md-7 col-xs-12 descriptor"  />
                                        <?php } ?>
                                    </td>
                                     <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="text"  id="remarks_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->remark != '' ){ echo $mark->remark; }else{ echo ''; } ?>"  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-remarks col-md-7 col-xs-12 remarks" />
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="text" value=""  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-remarks col-md-7 col-xs-12 remarks"  />
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="18" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <?php  if (isset($students) && !empty($students)) { ?>
                            <input type="hidden" value="<?php echo $school_id; ?>"  name="school_id" />
                            <input type="hidden" value="<?php echo $term_id; ?>"  name="term_id" />
                            <input type="hidden" value="<?php echo $exam_id; ?>"  name="exam_id" />
                            <input type="hidden" value="<?php echo $class_id; ?>"  name="class_id" />
                            <input type="hidden" value="<?php echo $section_id; ?>"  name="section_id" />
                            <input type="hidden" value="<?php echo $subject_id; ?>"  name="subject_id" />                        
                            <a href="<?php echo site_url('exam/mark/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                           <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_mark_instruction'); ?></div>
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
            term_id =  '<?php echo $term_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data   : { school_id:school_id, exam_id:exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#exam_id').html(response);  
                   get_class_by_school(school_id,class_id);
                   get_term_by_school(school_id, term_id) 
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
        get_section_subject_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>', '<?php echo $subject_id; ?>');
    <?php } ?>
    
    function get_section_subject_by_class(class_id, section_id, subject_id){       
        
        var school_id = $('#school_id').val();      
             
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
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id: subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#subject_id').html(response);
               }
            }
        });         
    }
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
  
       $('.fn_mark_total').keyup(function(){         
          var student_id = $(this).attr('itemid');
          var written_mark       = $('#written_mark_'+student_id).val() ?  parseFloat($('#written_mark_'+student_id).val()) : 0;
          var written_obtain     = $('#written_obtain_'+student_id).val() ? parseFloat($('#written_obtain_'+student_id).val()) : 0;
          var tutorial_mark      = $('#tutorial_mark_'+student_id).val() ? parseFloat($('#tutorial_mark_'+student_id).val()) : 0;
          var tutorial_obtain    = $('#tutorial_obtain_'+student_id).val() ? parseFloat($('#tutorial_obtain_'+student_id).val()) : 0;
          var practical_mark     = $('#practical_mark_'+student_id).val() ? parseFloat($('#practical_mark_'+student_id).val()) : 0;
          var practical_obtain   = $('#practical_obtain_'+student_id).val() ? parseFloat($('#practical_obtain_'+student_id).val()) : 0;
          var viva_mark          = $('#viva_mark_'+student_id).val() ? parseFloat($('#viva_mark_'+student_id).val()) : 0;
          var viva_obtain        = $('#viva_obtain_'+student_id).val() ? parseFloat($('#viva_obtain_'+student_id).val()) : 0;

          const marks1 = (written_mark/20)*3;
          var cm1 = $('#cummulative_1_'+student_id).val(marks1) ? parseFloat($('#cummulative_1_'+student_id).val()) : 0.0;
          const marks2 = (written_obtain/20)*3;
          var cm1 = $('#cummulative_2_'+student_id).val(marks2) ? parseFloat($('#cummulative_2_'+student_id).val()) : 0.0;
          const marks3 = (tutorial_mark/20)*3;
          var cm1 = $('#cummulative_3_'+student_id).val(marks3) ? parseFloat($('#cummulative_3_'+student_id).val()) : 0.0;
          const marks4 = (tutorial_obtain/20)*3;
          var cm1 = $('#cummulative_4_'+student_id).val(marks4) ? parseFloat($('#cummulative_4_'+student_id).val()) : 0.0;
          const marks5 = (practical_mark/20)*3;
          var cm1 = $('#cummulative_5_'+student_id).val(marks5) ? parseFloat($('#cummulative_5_'+student_id).val()) : 0.0;
          const marks6 = (practical_obtain/20)*3;
          var cm1 = $('#cummulative_6_'+student_id).val(marks5) ? parseFloat($('#cummulative_6_'+student_id).val()) : 0.0;
          
          // $('#exam_total_mark_'+student_id).val(written_mark+tutorial_mark+practical_mark+viva_mark);
          // $('#obtain_total_mark_'+student_id).val(written_obtain+tutorial_obtain+practical_obtain+viva_obtain);
          var eot_80        = $('#eot_80_'+student_id).val() ? parseFloat($('#eot_80_'+student_id).val()) : 0.00;
          
          var total_mark = $('#obtain_total_mark_'+student_id).val(written_mark+written_obtain+tutorial_mark+tutorial_obtain+practical_mark+practical_obtain) ? parseInt($('#obtain_total_mark_'+student_id).val()) : 0;
          
          // const avgMark = array => array.reduce((a, b) => a + b, 0) / array.length;
          // const avg = $('#avg_score_'+student_id).val(avgMark([written_mark,written_obtain,tutorial_mark,tutorial_obtain,practical_mark,practical_obtain]).toFixed(1)) ? parseFloat($('#avg_score_'+student_id).val()) : 0;
          // const grade = (avg/3*20).toFixed(1);
          
          var out_of_20 = $('#out_of_20_'+student_id).val(marks1+marks2+marks3+marks4+marks5+marks6) ? parseInt($('#out_of_20_'+student_id).val()) : 0;
          var exam_total_mark = $('#exam_total_mark_'+student_id).val(eot_80+out_of_20) ? parseFloat($('#exam_total_mark_'+student_id).val()) : 0;
          const descriptor = ["Absent", "Basic", "Moderate", "Accomplished"];
          var gradeMark = ["A+", "A","B+","B","C+","C","D+","D","E+","E-","F"];
          var gradeVal = [1, 2, 3];

          if (out_of_20 >= 15 && out_of_20 <=20){
            $('#identifier_'+student_id).val(3);
            $('#descriptor_'+student_id).val(descriptor[3]);
          } else if(out_of_20 >= 10 && out_of_20 <= 14.9){
            $('#identifier_'+student_id).val(2);
            $('#descriptor_'+student_id).val(descriptor[2]);
          } else if(out_of_20 >= 5 && out_of_20 <= 9.9){
            $('#identifier_'+student_id).val(1);
            $('#descriptor_'+student_id).val(descriptor[1]);
          } else {
            $('#identifier_'+student_id).val(0);
            $('#descriptor_'+student_id).val(descriptor[0]);
          }

          if (exam_total_mark >=90 && exam_total_mark <=100){
            $('#grade_id_'+student_id).val(gradeMark[0]);
          } else if (exam_total_mark >=85 && exam_total_mark <=89){
            $('#grade_id_'+student_id).val(gradeMark[1]);
          } else if (exam_total_mark >=80 && exam_total_mark <=84){
            $('#grade_id_'+student_id).val(gradeMark[2]);
          } else if (exam_total_mark >=75 && exam_total_mark <=79){
            $('#grade_id_'+student_id).val(gradeMark[3]);
          } else if (exam_total_mark >=70 && exam_total_mark <=74){
            $('#grade_id_'+student_id).val(gradeMark[4]);
          } else if (exam_total_mark >=65 && exam_total_mark <=69){
            $('#grade_id_'+student_id).val(gradeMark[5]);
          } else if (exam_total_mark >=60 && exam_total_mark <=64){
            $('#grade_id_'+student_id).val(gradeMark[6]);
          } else if (exam_total_mark >=55 && exam_total_mark <=59){
            $('#grade_id_'+student_id).val(gradeMark[7]);
          } else if (exam_total_mark >=50 && exam_total_mark <=54){
            $('#grade_id_'+student_id).val(gradeMark[8]);
          } else if (exam_total_mark >=45 && exam_total_mark <=49){
            $('#grade_id_'+student_id).val(gradeMark[9]);
          } else if (exam_total_mark >=40 && exam_total_mark <=44){
            $('#grade_id_'+student_id).val(gradeMark[10]);
          } else {
            $('#grade_id_'+student_id).val(gradeMark[11]);
          }
          
          if ($('#eot_80_'+student_id).val() > 80) {
            alert("Please enter a value less than 80");
          }

          if(written_mark < 0.9 ){
            alert('Please a value between 0.9 to 3.0');
          }
          // if(written_obtain < 0.9 ){
          //   alert('Please a value between 0.9 to 3.0');
          // }
          // if(tutorial_mark < 0.9 ){
          //   alert('Please a value between 0.9 to 3.0');
          // }
          // if(tutorial_obtain < 0.9 ){
          //   alert('Please a value between 0.9 to 3.0');
          // }
          // if(practical_mark < 0.9 || practical_mark > 3.0){
          //   alert('Please a value between 0.9 to 3.0');
          // }
          // if(practical_obtain < 0.9 || practical_obtain > 3.0){
          //   alert('Please a value between 0.9 to 3.0');
          // }
                              
       }); 
      
  }); 
  
 $("#mark").validate();  
 $("#addmark").validate(); 

</script>
<script type="text/javascript">
    
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
</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>