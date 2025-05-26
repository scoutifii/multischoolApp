<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-lock"></i><small> <?php echo $this->lang->line('my_profile'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
             <div class="x_content quick-link">
                 <?php $this->load->view('profile/quick-link'); ?>    
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($info)){ echo 'active'; }?>"><a href="#tab_profile"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-eye"></i> <?php echo $this->lang->line('profile'); ?></a> </li>
                        <li  class="<?php if(isset($update)){ echo 'active'; }?>"><a href="#tab_update"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('update'); ?></a> </li>                          
                        <li class=""><a href="#tab_guardian_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-paw"></i> <?php echo $this->lang->line('guardian'); ?></a> </li>
                        <li class=""><a href="#tab_parent_info"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-male"></i> <?php echo $this->lang->line('parent'); ?></a> </li>
                        <li  class=""><a href="#tab_attendance"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-check-circle-o"></i> <?php echo $this->lang->line('attendance'); ?></a> </li>                          
                        <li  class=""><a href="#tab_mark"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-file-archive-o"></i> <?php echo $this->lang->line('exam_mark'); ?></a> </li>                          
                        <li  class=""><a href="#tab_payment"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-dollar"></i> <?php echo $this->lang->line('payment'); ?> </a> </li>                          
                        <li  class=""><a href="#tab_activity"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-clipboard"></i> <?php echo $this->lang->line('activity'); ?> </a> </li>                          
                    </ul>
                    <br/>
                    
                    <div class="tab-content">                  

                        <div  class="tab-pane fade in <?php if(isset($info)){ echo 'active'; }?>" id="tab_profile">
                            <div class="x_content">  
                                <div class="col-md-12">
                                    <div class="profile_img">
                                        <?php if($profile->photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $profile->photo; ?>" alt="" width="100" />
                                        <?php }else{ ?>
                                            <img class="" src="<?php echo IMG_URL; ?>default-user.png" width="100" alt="Avatar" title="Avatar">
                                        <?php } ?>
                                        <h3><?php echo $profile->name; ?></h3><br/>
                                      </div>
                                  </div>
                                
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                     <tbody>
                                        <tr>                                            
                                            <th width="20%"><?php echo $this->lang->line('name'); ?></th>
                                            <td width="30%"><?php echo $profile->name; ?></td>
                                            <th  width="20%"><?php echo $this->lang->line('username'); ?></th>
                                            <td  width="30%"><?php echo $profile->username; ?></td>
                                        </tr>
                                        <tr>
                                            <th  width="20%"><?php echo $this->lang->line('admission_no'); ?></th>
                                            <td  width="30%"><?php echo $profile->admission_no; ?></td>
                                            <th  width="20%"><?php echo $this->lang->line('student_type'); ?></th>
                                            <td  width="30%"><?php echo $profile->type; ?></td>
                                            
                                        </tr>
                                        <tr> 
                                           <th><?php echo $this->lang->line('admission_date'); ?></th>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($profile->admission_date)); ?></td>
                                            <th><?php echo $this->lang->line('birth_date'); ?></th>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($profile->dob)); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('gender'); ?></th>
                                            <td><?php echo $this->lang->line($profile->gender); ?></td>
                                            <th><?php echo $this->lang->line('blood_group'); ?></th>
                                            <td><?php echo $this->lang->line($profile->blood_group); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('religion'); ?></th>
                                            <td><?php echo $profile->religion; ?></td>
                                            <th><?php echo $this->lang->line('caste'); ?></th>
                                            <td><?php echo $profile->caste; ?></td>                                            
                                        </tr>
                                        <tr>                                           
                                            <th><?php echo $this->lang->line('email'); ?></th>
                                            <td><?php echo $profile->email; ?></td>
                                            <th><?php echo $this->lang->line('phone'); ?></th>
                                            <td><?php echo $profile->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('present_address'); ?></th>
                                            <td><?php echo $profile->present_address; ?></td>
                                            <th><?php echo $this->lang->line('permanent_address'); ?></th>
                                            <td><?php echo $profile->permanent_address; ?></td>                        
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('class'); ?></th>
                                            <td><?php echo $profile->class_name; ?></td>
                                            <th><?php echo $this->lang->line('section'); ?></th>
                                            <td><?php echo $profile->section; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                                            <td><?php echo $profile->roll_no; ?></td>
                                            <th><?php echo $this->lang->line('registration_no'); ?></th>
                                            <td><?php echo $profile->registration_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('national_id'); ?></th>
                                            <td><?php echo $profile->national_id; ?></td>
                                            <th><?php echo $this->lang->line('age'); ?></th>
                                            <td><?php echo $profile->age; ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php echo $this->lang->line('discount'); ?></th>
                                            <td><?php echo $profile->discount . ' [ ' . $profile->amount . '% ]'; ?></td>
                                            <th><?php echo $this->lang->line('second_language'); ?></th>
                                            <td><?php echo $profile->second_language; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('previous_school'); ?></th>
                                            <td><?php echo $profile->previous_school; ?></td>
                                            <th><?php echo $this->lang->line('previous_class'); ?></th>
                                            <td><?php echo $profile->previous_class; ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php echo $this->lang->line('group'); ?></th>
                                            <td><?php echo $this->lang->line($profile->group); ?></td>
                                            <th><?php echo $this->lang->line('health_condition'); ?></th>
                                            <td><?php echo $profile->health_condition; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('other_info'); ?></th>
                                            <td><?php echo $profile->other_info; ?></td>
                                            <th><?php echo $this->lang->line('created'); ?></th>
                                            <td><?php echo date('M j,Y', strtotime($profile->created_at)); ?></td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div> 
                        
                        <div  class="tab-pane fade in " id="tab_guardian_info" >
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th><?php echo $this->lang->line('guardian'); ?></th>
                                        <td><?php echo $guardian->name; ?></td>
                                        <th><?php echo $this->lang->line('relation_with_guardian'); ?></th>
                                        <td><?php echo $profile->relation_with; ?></td>
                                    </tr>                                                
                                    <tr>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <td><?php echo $guardian->phone; ?></td>   
                                        <th><?php echo $this->lang->line('national_id'); ?></th>
                                        <td><?php echo $guardian->national_id; ?></td>                        

                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('present_address'); ?></th>
                                        <td><?php echo $guardian->present_address; ?></td>                        
                                        <th><?php echo $this->lang->line('permanent_address'); ?></th>
                                        <td><?php echo $guardian->permanent_address; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('religion'); ?></th>
                                        <td><?php echo $guardian->religion; ?></td>                       
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <td><?php echo $guardian->role; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <td><?php echo $guardian->email; ?></td>  
                                        <th><?php echo $this->lang->line('profession'); ?></th>
                                        <td><?php echo $guardian->profession; ?></td>

                                    </tr>        
                                    <tr>
                                        <th><?php echo $this->lang->line('photo'); ?></th>
                                        <td>
                                            <?php if ($guardian->photo) { ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/guardian-photo/<?php echo $guardian->photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>  
                                        </td>
                                         <th><?php echo $this->lang->line('other_info'); ?></th>
                                        <td ><?php echo $guardian->other_info; ?>   </td>
                                    </tr>
                                </tbody>
                            </table>  
                        </div>
                        
                        <div  class="tab-pane fade in " id="tab_parent_info" >
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <td><?php echo $profile->father_name; ?></td>                       
                                        <th><?php echo $this->lang->line('mother_name'); ?></th>
                                        <td><?php echo $profile->mother_name; ?></td>                       
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_phone'); ?></th>
                                        <td><?php echo $profile->father_phone; ?></td>                       
                                        <th><?php echo $this->lang->line('mother_phone'); ?></th>
                                        <td><?php echo $profile->mother_phone; ?></td>                       
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_education'); ?></th>
                                        <td><?php echo $profile->father_education; ?></td>                       
                                        <th><?php echo $this->lang->line('mother_education'); ?></th>
                                        <td><?php echo $profile->mother_education; ?></td>                       
                                    </tr>                                   
                                    <tr>
                                        <th><?php echo $this->lang->line('father_profession'); ?></th>
                                        <td><?php echo $profile->father_profession; ?></td>                       
                                        <th><?php echo $this->lang->line('mother_profession'); ?></th>
                                        <td><?php echo $profile->mother_profession; ?></td>                       
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_designation'); ?></th>
                                        <td><?php echo $profile->father_designation; ?></td>                       
                                        <th><?php echo $this->lang->line('mother_designation'); ?></th>
                                        <td><?php echo $profile->mother_designation; ?></td>                       
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_photo'); ?></th>
                                        <td>
                                            <?php if ($profile->father_photo) { ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/father-photo/<?php echo $profile->father_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                        </td>                       
                                        <th><?php echo $this->lang->line('mother_photo'); ?></th>
                                        <td>
                                            <?php if ($profile->mother_photo) { ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/mother-photo/<?php echo $profile->mother_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                        </td>                       
                                    </tr>
                                </tbody>
                            </table>  
                        </div>
                        
                        <div  class="tab-pane fade in " id="tab_attendance" >
                          <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <td><?php echo $this->lang->line('month'); ?> <i class="fa fa-long-arrow-down"></i> - <?php echo $this->lang->line('date'); ?> <i class="fa fa-long-arrow-right"></i></td>
                                   <?php for($i = 1; $i<=$days; $i++ ){ ?>
                                       <td><?php echo $i; ?></td>
                                   <?php } ?>
                               </tr>
                           </thead>
                           <tbody>   
                               <?php  $months = get_months(); ?>
                               <?php foreach($months as $key=>$value){ ?>
                                   <?php 
                                       $month_number = date('m',strtotime($key)); 
                                       $attendance = @get_student_monthly_attendance($school_id, $student_id, $academic_year_id, $class_id, $section_id, $month_number ,$days);
                                      ?>
                                   <?php if(!empty($attendance)){ ?>
                                    <tr>
                                        <td><?php echo $value; ?></td> 
                                        <?php foreach($attendance AS $key ){ ?>
                                            <td> <?php echo $key ? $key : '<i style="color:red;">--</i>'; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>  
                                   <?php } ?>  
                           </tbody>
                       </table>  
                   </div>
                        
                   <div  class="tab-pane fade in " id="tab_mark" >
                       <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th rowspan="2"><?php echo $this->lang->line('sl_no'); ?></th>
                                   <th rowspan="2"  width="12%"><?php echo $this->lang->line('subject'); ?></th>
                                   <th colspan="2"><?php echo $this->lang->line('written'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('tutorial'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('practical'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('viva'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('total'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('letter_grade'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('grade_point'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('lowest'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('height'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('position'); ?></th>                                            
                               </tr>
                               <tr>                           
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th> 
                               </tr>
                           </thead>
                           <tbody id="fn_mark"> 

                                 <?php if (isset($exams) && !empty($exams)) { ?>
                                 <?php foreach($exams as $ex){ ?>

                                     <tr style="background: #f9f9f9;">
                                         <th colspan="17"><?php echo $ex->title; ?></th>
                                     </tr>

                                     <?php
                                     $subjects = get_subject_list($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $student_id);
                                     $count = 1;
                                     if (isset($subjects) && !empty($subjects)) {
                                     ?>

                                     <?php foreach ($subjects as $obj) { ?>

                                     <?php $lh = get_lowet_height_mark($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $obj->subject_id ); ?>
                                     <?php $position = get_position_in_subject($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $obj->subject_id , $obj->obtain_total_mark); ?>
                                         <tr>
                                             <td><?php echo $count++;  ?></td>
                                             <td><?php echo ucfirst($obj->subject); ?></td>
                                             <td><?php echo $obj->written_mark; ?></td>
                                             <td><?php echo $obj->written_obtain; ?></td>
                                             <td><?php echo $obj->tutorial_mark; ?></td>
                                             <td><?php echo $obj->tutorial_obtain; ?></td>
                                             <td><?php echo $obj->practical_mark; ?></td>
                                             <td><?php echo $obj->practical_obtain; ?></td>
                                             <td><?php echo $obj->viva_mark; ?></td>
                                             <td><?php echo $obj->viva_obtain; ?></td>
                                             <td><?php echo $obj->exam_total_mark; ?></td>
                                             <td><?php echo $obj->obtain_total_mark; ?></td>
                                             <td><?php echo $obj->name; ?></td>
                                             <td><?php echo $obj->point; ?></td>                               
                                             <td><?php echo $lh->lowest; ?></td>                               
                                             <td><?php echo $lh->height; ?></td>                               
                                             <td><?php echo $position; ?></td>                                
                                         </tr>
                                     <?php } ?>
                                 <?php }else{ ?>
                                         <tr>
                                             <td colspan="17" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                         </tr>
                                 <?php } ?>   

                             <?php } ?>
                             <?php }else{ ?>
                                     <tr>
                                         <td colspan="17" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                      </tr>    
                              <?php } ?>            
                           </tbody>   
                       </table>  

                       <table class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th rowspan="2"><?php echo $this->lang->line('sl_no'); ?></th>
                                   <th rowspan="2" width="12%"><?php echo $this->lang->line('exam'); ?></th>
                                   <th colspan="2"><?php echo $this->lang->line('written'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('tutorial'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('practical'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('viva'); ?></th>                                            
                                   <th colspan="2"><?php echo $this->lang->line('total'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('average_grade_point'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('letter_grade'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('lowest'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('height'); ?></th>                                            
                                   <th rowspan="2"><?php echo $this->lang->line('position'); ?></th>                                            
                               </tr>
                               <tr>                           
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                                   <th><?php echo $this->lang->line('mark'); ?></th>                                            
                                   <th><?php echo $this->lang->line('obtain'); ?></th> 
                               </tr>
                           </thead>
                           <?php

                           $count = 1;
                           if (isset($exams) && !empty($exams)) {
                           ?>

                               <?php foreach ($exams as $ex) { ?>
                               <?php $mark = get_exam_wise_markt($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $student_id ); ?>
                               <?php $obtain_total_mark = $mark->written_obtain+$mark->tutorial_obtain+$mark->practical_obtain+$mark->viva_obtain; ?>
                               <?php $rank = get_position_in_exam($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $obtain_total_mark); ?>
                               <?php $exam_lh = get_lowet_height_result($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $student_id); ?>
                               <?php $exam = get_exam_result($school_id, $ex->id, $student_id, $academic_year_id, $class_id, $section_id); ?>

                               <tr>
                                   <td><?php echo $count++;  ?></td>
                                   <td><?php echo ucfirst($ex->title); ?></td>
                                   <td><?php echo $mark->written_mark; ?></td>
                                   <td><?php echo $mark->written_obtain; ?></td>
                                   <td><?php echo $mark->tutorial_mark; ?></td>
                                   <td><?php echo $mark->tutorial_obtain; ?></td>
                                   <td><?php echo $mark->practical_mark; ?></td>
                                   <td><?php echo $mark->practical_obtain; ?></td>
                                   <td><?php echo $mark->viva_mark; ?></td>
                                   <td><?php echo $mark->viva_obtain; ?></td>
                                   <td><?php echo $mark->written_mark+$mark->tutorial_mark+$mark->practical_mark+$mark->viva_mark; ?></td>
                                   <td><?php echo $obtain_total_mark; ?></td>
                                   <td><?php echo @number_format($mark->point/$mark->total_subject,2); ?></td>                               
                                   <td><?php echo @$exam->name; ?></td>
                                   <td><?php echo $exam_lh->lowest; ?></td>                               
                                   <td><?php echo $exam_lh->height; ?></td>                               
                                   <td><?php echo $rank; ?></td>                                
                               </tr>                        
                               <?php } ?>   
                           <?php } ?>   
                       </table>
                   </div>

                   <div  class="tab-pane fade in " id="tab_payment" >
                       <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th><?php echo $this->lang->line('sl_no'); ?></th>
                                   <th><?php echo $this->lang->line('invoice_number'); ?></th>
                                   <th><?php echo $this->lang->line('student'); ?></th>
                                   <th><?php echo $this->lang->line('class'); ?></th>
                                   <th><?php echo $this->lang->line('gross_amount'); ?></th>
                                   <th><?php echo $this->lang->line('discount'); ?></th>
                                   <th><?php echo $this->lang->line('net_amount'); ?></th>
                                   <th><?php echo $this->lang->line('status'); ?></th>
                                   <th><?php echo $this->lang->line('action'); ?></th>                                            
                               </tr>
                           </thead>
                            <tbody>   
                               <?php $count = 1; if(isset($invoices) && !empty($invoices)){ ?>
                                   <?php foreach($invoices as $obj){ ?>
                                   <tr>
                                       <td><?php echo $count++; ?></td>
                                       <td><?php echo $obj->custom_invoice_id; ?></td>
                                       <td><?php echo $obj->student_name; ?></td>
                                       <td><?php echo $obj->class_name; ?></td>
                                       <td><?php echo $obj->gross_amount; ?></td>
                                       <td><?php echo $obj->discount; ?></td>
                                       <td><?php echo $obj->net_amount; ?></td>
                                       <td><?php echo get_paid_status($obj->paid_status); ?></td>
                                       <td>
                                           <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                                               <a target="_blank" href="<?php echo site_url('accounting/invoice/view/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                           <?php } ?>
                                           <?php if(has_permission(DELETE, 'accounting', 'invoice')){ ?>
                                               <?php if($obj->paid_status == 'unpaid'){ ?>
                                                   <a target="_blank" href="<?php echo site_url('accounting/invoice/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                               <?php } ?>
                                           <?php } ?>
                                       </td>
                                   </tr>
                                   <?php } ?>
                               <?php } ?>
                           </tbody>                   
                       </table>  
                   </div>  

                   <div  class="tab-pane fade in " id="tab_activity" >
                       <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                           <thead>
                               <tr>
                               <th><?php echo $this->lang->line('sl_no'); ?></th>
                               <th><?php echo $this->lang->line('student'); ?></th>
                               <th><?php echo $this->lang->line('class'); ?></th>
                               <th><?php echo $this->lang->line('section'); ?></th>
                               <th><?php echo $this->lang->line('activity'); ?> </th>
                               <th><?php echo $this->lang->line('date'); ?></th>
                               <th><?php echo $this->lang->line('action'); ?></th>
                           </tr>
                           </thead>
                            <tbody>   
                               <?php $count = 1; if(isset($activity) && !empty($activity)){ ?>
                               <?php foreach($activity as $obj){ ?>
                               <tr>
                                   <td><?php echo $count++; ?></td>
                                   <td><?php echo $obj->student; ?></td>
                                   <td><?php echo $obj->class_name; ?></td>
                                   <td><?php echo $obj->section; ?></td>
                                   <td><?php echo $obj->activity; ?></td>
                                   <td><?php echo date('M j,Y', strtotime($obj->activity_date)); ?></td>  
                                   <td>
                                       <?php if(has_permission(EDIT, 'student', 'activity')){ ?>
                                       <a target="_blank" href="<?php echo site_url('student/activity/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                       <?php } ?>
                                       <?php if(has_permission(VIEW, 'student', 'activity')){ ?>
                                           <a  onclick="get_activity_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-activity-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                       <?php } ?>
                                       <?php if(has_permission(DELETE, 'student', 'activity')){ ?>
                                           <a href="<?php echo site_url('student/activity/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                       <?php } ?>
                                   </td>
                               </tr>
                               <?php } ?>
                           <?php } ?>
                           </tbody>                   
                       </table>  
                   </div>  
                       
                        <div class="tab-pane fade in" id="tab_update">
                           <div class="x_content"> 
                            <?php echo form_open_multipart(site_url('profile/update/'. $profile->id), array('name' => 'profile', 'id' => 'profile', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                               
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('basic_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($profile->name) ?  $profile->name : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('name'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_no"><?php echo $this->lang->line('admission_no'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_no"  id="admission_no" value="<?php echo isset($profile->admission_no) ?  $profile->admission_no : ''; ?>" placeholder="<?php echo $this->lang->line('admission_no'); ?>" type="text" readonly="readonly" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_no'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_date"><?php echo $this->lang->line('admission_date'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_date"  id="edit_admission_date" value="<?php echo isset($profile->admission_date) ?   date('d-m-Y', strtotime($profile->admission_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('admission_date'); ?>"  readonly="readonly" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_date'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="dob"><?php echo $this->lang->line('birth_date'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="dob"  id="edit_dob" value="<?php echo isset($profile->dob) ?  date('d-m-Y', strtotime($profile->dob)) : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>"  readonly="readonly" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('dob'); ?></div>
                                         </div>
                                    </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="gender"><?php echo $this->lang->line('gender'); ?> <span class="required">*</span></label>
                                              <select  class="form-control col-md-7 col-xs-12"  name="gender"  id="gender" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $genders = get_genders(); ?>
                                                <?php foreach($genders as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($profile->gender == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('gender'); ?></div>
                                         </div>
                                     </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="blood_group"><?php echo $this->lang->line('blood_group'); ?></label>
                                              <select  class="form-control col-md-7 col-xs-12" name="blood_group" id="blood_group">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $bloods = get_blood_group(); ?>
                                                <?php foreach($bloods as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($profile->blood_group == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                                </select>
                                            <div class="help-block"><?php echo form_error('blood_group'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="religion"><?php echo $this->lang->line('religion'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="religion"  id="add_religion" value="<?php echo isset($profile->religion) ?  $profile->religion : ''; ?>" placeholder="<?php echo $this->lang->line('religion'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('religion'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="caste"><?php echo $this->lang->line('caste'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="caste"  id="add_caste" value="<?php echo isset($profile->caste) ?  $profile->caste : ''; ?>" placeholder="<?php echo $this->lang->line('caste'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('caste'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('contact_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="guardian_id"><?php echo $this->lang->line('guardian'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="guardian_id" id="guardian_id" disabled="disabled">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($guardians as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($profile->guardian_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('guardian_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="relation_with"><?php echo $this->lang->line('relation_with_guardian'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="relation_with"  id="relation_with" value="<?php echo isset($profile->relation_with) ?  $profile->relation_with : ''; ?>" placeholder="<?php echo $this->lang->line('relation_with_guardian'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('relation_with'); ?></div>
                                        </div>
                                    </div>
                                    
                                     
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="phone"><?php echo $this->lang->line('phone'); ?></label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="add_phone" value="<?php echo isset($profile->phone) ?  $profile->phone : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('phone'); ?></div>
                                         </div>
                                     </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="national_id"><?php echo $this->lang->line('national_id'); ?> </label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="national_id"  id="national_id" value="<?php echo isset($profile->national_id) ?  $profile->national_id : ''; ?>" placeholder="<?php echo $this->lang->line('national_id'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('national_id'); ?></div>
                                         </div>
                                     </div>
                                    
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                             <label for="present_address"><?php echo $this->lang->line('present_address'); ?></label>
                                              <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="present_address"  id="add_present_address"  placeholder="<?php echo $this->lang->line('present_address'); ?>"><?php echo isset($profile->present_address) ?  $profile->present_address : ''; ?></textarea>
                                              <div class="help-block"><?php echo form_error('present_address'); ?></div>
                                         </div>
                                     </div>                                    
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                            <label for="permanent_address"><?php echo $this->lang->line('permanent_address'); ?></label>
                                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="permanent_address"  id="add_permanent_address"  placeholder="<?php echo $this->lang->line('permanent'); ?>"><?php echo isset($profile->permanent_address) ?  $profile->permanent_address : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('permanent_address'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('academic_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row">                                      
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="type_id"><?php echo $this->lang->line('student_type'); ?></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="type_id" id="type_id" disabled="disabled">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($types as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($profile->type_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->type; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="class_id"><?php echo $this->lang->line('class'); ?> </label>
                                             <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_id" id="class_id" disabled="disabled">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($classes as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($profile->class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="section_id"><?php echo $this->lang->line('section'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="section_id" id="edit_section_id" disabled="disabled">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="group"><?php echo $this->lang->line('group'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12" name="group" id="group" disabled="disabled">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $groups = get_groups(); ?>
                                                <?php foreach($groups as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($profile->group == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('group'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="roll_no"><?php echo $this->lang->line('roll_no'); ?> </label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="roll_no"  id="roll_no" readonly="readonly"  value="<?php echo isset($profile->roll_no) ?  $profile->roll_no : ''; ?>" placeholder="<?php echo $this->lang->line('roll_no'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('roll_no'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="registration_no"><?php echo $this->lang->line('registration_no'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="registration_no"  id="registration_no" value="<?php echo isset($profile->registration_no) ?  $profile->registration_no : ''; ?>" placeholder="<?php echo $this->lang->line('registration_no'); ?>" disabled="disabled" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('registration_no'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="role_id"><?php echo $this->lang->line('role'); ?> </label>
                                             <select  class="form-control col-md-7 col-xs-12" name="role_id" id="role_id" disabled="disabled">
                                                <?php foreach($roles as $obj){ ?>
                                                <?php if(in_array($obj->id, array(STUDENT))){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($profile->role_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="discount"><?php echo $this->lang->line('discount'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="discount"  id="discount" value="<?php echo isset($profile->discount) ?  $profile->amount.'% ('.$profile->discount .')' : ''; ?>" placeholder="<?php echo $this->lang->line('discount'); ?> " disabled="disabled" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('discount'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="second_language"><?php echo $this->lang->line('second_language'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="second_language"  id="second_language" value="<?php echo isset($profile->second_language) ?  $profile->second_language : ''; ?>" placeholder="<?php echo $this->lang->line('second_language'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('second_language'); ?></div>
                                         </div>
                                     </div>
                                </div>
                              
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('father_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_name"><?php echo $this->lang->line('father_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_name"  id="father_name" value="<?php echo isset($profile->father_name) ?  $profile->father_name : ''; ?>" placeholder="<?php echo $this->lang->line('father_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_phone"><?php echo $this->lang->line('father_phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_phone"  id="father_phone" value="<?php echo isset($profile->father_phone) ?  $profile->father_phone : ''; ?>" placeholder="<?php echo $this->lang->line('father_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_education"><?php echo $this->lang->line('father_education'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_education"  id="father_education" value="<?php echo isset($profile->father_education) ?  $profile->father_education : ''; ?>" placeholder="<?php echo $this->lang->line('father_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_profession"><?php echo $this->lang->line('father_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_profession"  id="father_profession" value="<?php echo isset($profile->father_profession) ?  $profile->father_profession : ''; ?>" placeholder="<?php echo $this->lang->line('father_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_designation"><?php echo $this->lang->line('father_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_designation"  id="father_designation" value="<?php echo isset($profile->father_designation) ?  $profile->father_designation : ''; ?>" placeholder="<?php echo $this->lang->line('father_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('father_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="father_photo"  id="father_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('father_photo'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_father_photo" id="prev_father_photo" value="<?php echo $profile->father_photo; ?>" />
                                            <?php if($profile->father_photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/father-photo/<?php echo $profile->father_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div> 
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('mother_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_name"><?php echo $this->lang->line('mother_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_name"  id="mother_name" value="<?php echo isset($profile->mother_name) ?  $profile->mother_name : ''; ?>" placeholder="<?php echo $this->lang->line('mother_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_phone"><?php echo $this->lang->line('mother_phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_phone"  id="mother_phone" value="<?php echo isset($profile->mother_phone) ?  $profile->mother_phone : ''; ?>" placeholder="<?php echo $this->lang->line('mother_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_education"><?php echo $this->lang->line('mother_education'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_education"  id="mother_education" value="<?php echo isset($profile->mother_education) ?  $profile->mother_education : ''; ?>" placeholder="<?php echo $this->lang->line('mother_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_profession"><?php echo $this->lang->line('mother_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_profession"  id="mother_profession" value="<?php echo isset($profile->mother_profession) ?  $profile->mother_profession : ''; ?>" placeholder="<?php echo $this->lang->line('mother_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_designation"><?php echo $this->lang->line('mother_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_designation"  id="mother_designation" value="<?php echo isset($profile->mother_designation) ?  $profile->mother_designation : ''; ?>" placeholder="<?php echo $this->lang->line('mother_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('mother_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="mother_photo"  id="mother_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('mother_photo'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_mother_photo" id="prev_mother_photo" value="<?php echo $profile->mother_photo; ?>" />
                                            <?php if($profile->mother_photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/mother-photo/<?php echo $profile->mother_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div>
                                </div>
                                
                                
                               <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('other_info'); ?>:</strong></h5>
                                    </div>
                                </div>    
                                <div class="row">                  
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="email"><?php echo $this->lang->line('email'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="email"   id="email" value="<?php echo isset($profile->email) ?  $profile->email : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" type="email" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('email'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="username"><?php echo $this->lang->line('username'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="username"  id="username" readonly="readonly" value="<?php echo isset($profile->username) ?  $profile->username : ''; ?>" placeholder="<?php echo $this->lang->line('username'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('username'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="health_condition"><?php echo $this->lang->line('health_condition'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="health_condition"  id="health_condition" value="<?php echo isset($profile->health_condition) ?  $profile->health_condition : ''; ?>" placeholder="<?php echo $this->lang->line('health_condition'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('health_condition'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                <div class="row">     
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                           <label for="other_info"><?php echo $this->lang->line('other_info'); ?></label> 
                                           <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="other_info"  id="other_info" placeholder="<?php echo $this->lang->line('other_info'); ?>"><?php echo isset($profile->other_info) ?  $profile->other_info : ''; ?></textarea>
                                           <div class="help-block"><?php echo form_error('other_info'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label ><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="photo"  id="photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('photo'); ?></div>
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_photo" id="prev_photo" value="<?php echo $profile->photo; ?>" />
                                            <?php if($profile->photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $profile->photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div>                                    
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('profile'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <input type="hidden" name="id" id="id" value="<?php echo $profile->id; ?>" />
                                        <input type="hidden" name="user_type" id="user_type" value="student" />
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-activity-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_activity_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_activity_modal(activity_id){
         
        $('.fn_activity_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('student/activity/get_single_activity'); ?>",
          data   : {activity_id : activity_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_activity_data').html(response);
             }
          }
       });
    }
</script>
  <!-- bootstrap-datetimepicker -->
 <link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
 <script type="text/javascript">
     
  $('#dob').datepicker();
  $('#joining_date').datepicker();
  $("#profile").validate(); 
  
  
    <?php if(isset($profile)){ ?>
        get_section_by_class('<?php echo $profile->school_id; ?>', '<?php echo $profile->class_id; ?>', '<?php echo $profile->section_id; ?>');
    <?php } ?>
    function get_section_by_class(school_id, class_id, section_id){       
             
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#edit_section_id').html(response);                  
               }
            }
        }); 
    }
 
  </script> 