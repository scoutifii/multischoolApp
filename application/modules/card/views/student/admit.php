<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-barcode"></i><small> <?php echo $this->lang->line('generate_student_admit_card'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link no-print">
                <?php $this->load->view('quick-link'); ?>     
            </div>
            

            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('card/admit/index'), array('name' => 'generate', 'id' => 'generate', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    
                     <div class="col-md-10 col-sm-10 col-xs-12">  
                    <?php $this->load->view('layout/school_list_filter'); ?>

                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam_term'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($exams) && !empty($exams)) { ?>
                                    <?php foreach ($exams as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php foreach ($classes as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required" onchange="get_student_by_section(this.value, '');">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('student'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12"  name="student_id"  id="student_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                            </select>
                            <div class="help-block"><?php echo form_error('student_id'); ?></div>
                        </div>
                    </div>
                    </div>    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('generate'); ?></button>
                        </div>
                    </div>

                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">                    
                    <ul  class="nav nav-tabs bordered no-print">                 
                        <li  class="active"><a href="#tab_student_list" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa fa-users"></i> <?php echo $this->lang->line('student_list'); ?></a></li>                          
                    </ul>
                    <br/>
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_student_list">
                            <div class="x_content">
                                
                               <div class="row">
                                   
                                   <?php if(isset($cards) && !empty($cards)){ ?>
                                        <?php  $counter = 1; foreach($cards as $obj){ ?>  

                                            <div class="admit-card-block">
                                                <div class="admit-card-top">
                                                    <div class="admit-card-logo">
                                                        <?php  if($admit_setting->school_logo != ''){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $admit_setting->school_logo; ?>" alt="" /> 
                                                        <?php }else if($school->logo){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                                        <?php }else if($school->frontend_logo){ ?>
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                                        <?php }else{ ?>                                                        
                                                           <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                                        <?php } ?>                                                        
                                                    </div>
                                                    <div class="admit-card-school">
                                                        <h2><?php echo isset($admit_setting->school_name) ? $admit_setting->school_name : $school->school_name; ?></h2>
                                                        <p><?php echo isset($admit_setting->school_address) && $admit_setting->school_address != '' ? $admit_setting->school_address : $school->address;; ?></p>
                                                        <p><?php echo $this->lang->line('phone'); ?>: <?php echo isset($admit_setting->phone) && $admit_setting->phone != '' ? $admit_setting->phone : $school->phone;; ?></p>
                                                    </div>
                                                </div>
                                                <div class="admit-card">
                                                    <h3><span><?php echo $this->lang->line('student_admit_card'); ?></span></h3>
                                                </div>
                                                <div class="admit-card-main">                                                    
                                                    <div class="admit-card-photo">
                                                        <?php  if($obj->photo != ''){ ?>
                                                        <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" /> 
                                                        <?php }else{ ?>
                                                        <img src="<?php echo IMG_URL; ?>/default-user.png" alt=""  /> 
                                                        <?php } ?>
                                                    </div>
                                                    <div class="admit-card-info">
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('student_id'); ?></span><span class="admit-card-value">: <?php echo $obj->roll_no; ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('student_name'); ?></span><span class="admit-card-value">: <?php echo $obj->name; ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('class'); ?></span><span class="admit-card-value">: <?php echo $obj->class_name; ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('section'); ?></span><span class="admit-card-value">: <?php echo $obj->section; ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('roll_no'); ?></span><span class="admit-card-value">: <?php echo $obj->roll_no; ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('blood_group'); ?></span><span class="admit-card-value">: <?php echo $this->lang->line($obj->blood_group); ?></span></p>
                                                        <p><span class="admit-card-title"><?php echo $this->lang->line('birth_date'); ?></span><span class="admit-card-value">: <?php echo date($this->global_setting->date_format, strtotime($obj->dob)); ?></span></p>
                                                    </div>
                                                    <div class="admit-card-subject">
                                                        <div class="admit-exam"><?php echo $this->lang->line('exam_term'); ?>: <?php if(isset($exam) && !empty($exam)){ echo $exam->title; } ?></div>
                                                        <div class="subject-heading"><?php echo $this->lang->line('subject'); ?>:</div>
                                                        <div class="exam-subjects">
                                                            <?php if(isset($subjects) && !empty($subjects)){ ?>                                                             
                                                            <ol>        
                                                                <?php foreach($subjects as $sub){ ?>                                                               
                                                                    <li><?php echo $sub->name; ?></li>  
                                                                 <?php } ?> 
                                                            </ol>
                                                            <?php } ?> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="admit-card-bottom">
                                                    <p><?php echo isset($admit_setting->bottom_text) ? $admit_setting->bottom_text : ''; ?></p>
                                                </div>
                                            </div>

                                       <?php if($counter%3 == 0){ ?>                                               
                                              <div class="pagebreak">&nbsp;</div>                                              
                                        <?php } ?>

                                       <?php $counter++; } ?>
                                   <?php } ?>
                                    
                               </div>
                                
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-print"></div>
            <div class="ln_solid no-print"></div>
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<link href="<?php echo CSS_URL; ?>card.css" rel="stylesheet">
<?php $this->load->view('layout/card'); ?>   
<!-- Super admin js START  -->
<script type="text/javascript">

    $("document").ready(function () {
        <?php if (isset($school_id) && !empty($school_id)) { ?>
            $("#school_id").trigger('change');
        <?php } ?>
    });

    $('#school_id').on('change', function () {

        var school_id = $(this).val();  
        var exam_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';     
            class_id =  '<?php echo $class_id; ?>';
         <?php } ?> 

        if (!school_id) {
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
    
    
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>
        
    function get_section_by_class(class_id, section_id){ 
        
        var school_id = $('#school_id').val();        
        
       if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : {school_id:school_id,  class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        }); 
    }
  

    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_student_by_section('<?php echo $section_id; ?>', '<?php echo $student_id; ?>');
    <?php } ?>
    
    function get_student_by_section(section_id, student_id){       
        
        var school_id = $('#school_id').val();  
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
           
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_by_section'); ?>",
            data   : {school_id:school_id, section_id: section_id, student_id: student_id, is_all:true},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#student_id').html(response);
               }
            }
        });         
    }
 
</script>
<!-- Super admin js end -->


<script type="text/javascript">
    $("#generate").validate();
</script> 
