<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text"></i><small> <?php echo $this->lang->line('manage_suggestion'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_suggestion_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'exam', 'suggestion')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('exam/suggestion/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('suggestion'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_suggestion"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('suggestion'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_suggestion"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('suggestion'); ?></a> </li>                          
                        <?php } ?>  
                           
                            <li class="li-class-list">                                
                                    
                                <?php $teacher_access_data = get_teacher_access_data('student'); ?> 
                                <?php $guardian_access_data = get_guardian_access_data('class'); ?>  
                                
                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                
                                   <?php echo form_open(site_url('exam/schedule/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
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
                                
                                    <select  class="form-control col-md-7 col-xs-12" onchange="get_suggestion_list_by_class(this.value);">
                                        <option value="<?php echo site_url('exam/suggestion/index'); ?>">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php foreach($class_list as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                                <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?> 
                                                <option value="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>
                                                <?php if (!in_array($obj->id, $guardian_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>
                                                <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?> 

                                        <?php } ?>                                            
                                    </select>                               
                                <?php } ?>
                            </li> 
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_suggestion_list" >                            
                            <div class="x_content">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <th><?php echo $this->lang->line('school'); ?></th>
                                            <?php } ?>
                                            <th><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('term'); ?></th>
                                            <th><?php echo $this->lang->line('academic_year'); ?></th>
                                            <th><?php echo $this->lang->line('title'); ?></th>
                                            <th><?php echo $this->lang->line('exam_term'); ?></th>
                                            <th><?php echo $this->lang->line('class'); ?></th>                                       
                                            <th><?php echo $this->lang->line('subject'); ?></th>                                       
                                            <th><?php echo $this->lang->line('action'); ?></th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                       
                                        <?php $count = 1; if(isset($suggestions) && !empty($suggestions)){ ?>
                                            <?php foreach($suggestions as $obj){ ?>
                                        
                                            <?php 
                                                if($this->session->userdata('role_id') == GUARDIAN){
                                                    if (!in_array($obj->class_id, $guardian_access_data)) { continue; }
                                                }elseif($this->session->userdata('role_id') == TEACHER){
                                                    if (!in_array($obj->subject_id, $teacher_access_data)){ continue; }
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                    <td><?php echo $obj->school_name; ?></td>
                                                <?php } ?>
                                                <td><?php echo $obj->term; ?></td>
                                                <td><?php echo $obj->session_year; ?></td>
                                                <td><?php echo $obj->title; ?></td>
                                                <td><?php echo $obj->exam_title; ?></td>
                                                <td><?php echo $obj->class_name; ?></td>
                                                <td><?php echo $obj->subject; ?></td>
                                                <td>
                                                    <?php if(has_permission(EDIT, 'exam', 'suggestion')){ ?>
                                                        <a href="<?php echo site_url('exam/suggestion/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                     <?php } ?>
                                                    <?php if(has_permission(VIEW, 'exam', 'suggestion')){ ?>
                                                        <a  onclick="get_suggestion_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-suggestion-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                        <?php if($obj->suggestion){ ?>
                                                        <a target="_blank" href="<?php echo UPLOAD_PATH .'/suggestion/'. $obj->suggestion; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?> </a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                   <?php if(has_permission(DELETE, 'exam', 'suggestion')){ ?>     
                                                        <a href="<?php echo site_url('exam/suggestion/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- End first tab -->
                                                

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_suggestion">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('exam/suggestion/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>   
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($post['title']) ?  $post['title'] : ''; ?>" placeholder="<?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="term_id"><?php echo $this->lang->line('term'); ?><span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 quick-field"  name="term_id"  id="add_term_id" onchange="get_exam_by_term(this.value,'');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                              <?php foreach($terms as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php echo isset($post['term_id']) && $post['term_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>           
                                        </select>
                                        <div class="help-block"><?php echo form_error('term_id'); ?></div>
                                    </div>
                                </div> 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="exam_id"><?php echo $this->lang->line('exam_term'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="exam_id" id="add_exam_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <!--?php foreach($exams as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" ><?php echo $obj->title; ?></option>
                                            <!?php } ?-->                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id" id="add_class_id" required="required" onchange="get_subject_by_class(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php foreach($classes as $obj ){ ?>
                                               <?php
                                                if($this->session->userdata('role_id') == TEACHER){
                                                   if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                } 
                                                ?>
                                                <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 data_subject"  name="subject_id" id="add_subject_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>                                
                              
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('suggestion'); ?>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                            <input  class="form-control col-md-7 col-xs-12" name="suggestion"  id="suggestion" type="file">
                                        </div>
                                        <div class="text-info"><?php echo $this->lang->line('valid_file_format_doc'); ?></div>
                                        <div class="help-block"><?php echo form_error('suggestion'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="add_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('exam/suggestion/index/'.$class_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('add_exam_suggestion_instruction'); ?></div>
                                </div>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_suggestion">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('exam/suggestion/edit/'.$suggestion->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                 
                                 <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('title'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="title"  id="title" value="<?php echo isset($suggestion->title) ?  $suggestion->title : ''; ?>" placeholder="<?php echo $this->lang->line('title'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('title'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="term_id"><?php echo $this->lang->line('term'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 quick-field"  name="term_id"  id="edit_term_id" onchange="get_exam_by_term(this.value,'');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            <?php if (isset($terms) && !empty($terms)) { ?>
                                            <?php foreach($terms as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if($suggestion->term_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('term_id'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="exam_id"><?php echo $this->lang->line('exam_term'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="exam_id" id="edit_exam_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <!--?php if(isset($exams) && !empty($exams)){ ?>
                                                <!?php foreach($exams as $obj ){ ?>
                                                <option value="<!?php echo $obj->id; ?>" <!?php if($obj->id == $suggestion->exam_id){ echo 'selected="selected"'; } ?>><!?php echo $obj->title; ?></option>
                                                <!?php } ?>                                            
                                            <!?php } ?-->                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="class_id" id="edit_class_id" required="required" onchange="get_subject_by_class(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                  <?php
                                                    if($this->session->userdata('role_id') == TEACHER){
                                                       if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                    } 
                                                    ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($obj->id == $suggestion->class_id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
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
                                
                                
                             <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('suggestion'); ?>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="hidden" name="prev_suggestion" id="prev_suggestion" value="<?php echo $suggestion->suggestion; ?>" />
                                        <?php if($suggestion->suggestion){ ?>
                                        <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/suggestion/<?php echo $suggestion->suggestion; ?>"  class="btn btn-success btn-xs"> <i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?> </a> <br/><br/>
                                        <?php } ?>
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                        <input  class="form-control col-md-7 col-xs-12"  name="suggestion"  id="suggestion" type="file">
                                        </div>
                                        <div class="text-info"><?php echo $this->lang->line('valid_file_format_doc'); ?></div>
                                        <div class="help-block"><?php echo form_error('suggestion'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="edit_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($suggestion->note) ?  $suggestion->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($suggestion) ? $suggestion->id : $id; ?>" name="id" />
                                        <a href="<?php echo site_url('exam/suggestion/index/'.$class_id); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-suggestion-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_suggestion_data">            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_suggestion_modal(suggestion_id){
         
        $('.fn_suggestion_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('exam/suggestion/get_single_suggestion'); ?>",
          data   : {suggestion_id : suggestion_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_suggestion_data').html(response);
             }
          }
       });
    }
</script>

 
  <link href="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.css" rel="stylesheet">
 <script type="text/javascript" src="<?php echo VENDOR_URL; ?>editor/jquery-te-1.4.0.min.js"></script>
 <script type="text/javascript">     
  $('#add_note').jqte();
  $('#edit_note').jqte();
  
  </script>
  
<!-- Super admin js START  -->
 <script type="text/javascript">
     var edit = false;
    $("document").ready(function() {
         <?php if(isset($edit) && !empty($edit)  && $this->session->userdata('role_id') != TEACHER){ ?>
           edit = true;       
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var exam_id = '';
        var class_id = '';
        var term_id = '';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            exam_id =  '<?php echo $suggestion->exam_id; ?>';           
            class_id =  '<?php echo $suggestion->class_id; ?>';
            term_id = '<?php echo $suggestion->term_id; ?>';           
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
                   if(edit){
                       $('#edit_exam_id').html(response);   
                   }else{
                       $('#add_exam_id').html(response);   
                   }
                   
                   get_class_by_school(school_id, class_id);
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
                   if(edit){
                       $('#edit_class_id').html(response);   
                   }else{
                       $('#add_class_id').html(response);   
                   }                  
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
                   if(edit){
                       $('#edit_term_id').html(response);   
                   }else{
                       $('#add_term_id').html(response);   
                   }                  
               }
            }
        });                  
    }
  </script>
<!-- Super admin js end -->

 <script type="text/javascript">     
    <?php if(isset($edit)){ ?>
        edit = true;
        get_subject_by_class('<?php echo $suggestion->class_id; ?>', '<?php echo $suggestion->subject_id; ?>');           
    <?php } ?>

    
    function get_subject_by_class(class_id, subject_id ){       
         
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
            data   : { school_id : school_id, class_id : class_id,  subject_id : subject_id},               
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
    
       
    function get_suggestion_list_by_class(url){          
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
</script>
<script type="text/javascript">
    <?php if(isset($edit)){ ?>
        edit = true;
        get_exam_by_term('<?php echo $suggestion->term_id; ?>', '<?php echo $suggestion->exam_id; ?>');
    <?php } ?>
         
    function get_exam_by_term(term_id, exam_id){       
         
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
            url    : "<?php echo site_url('ajax/get_exam_by_term'); ?>",
            data   : {school_id:school_id, term_id : term_id,  exam_id : exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  if(edit){
                      $('#edit_exam_id').html(response);
                   }else{
                      $('#add_exam_id').html(response); 
                   }
               }
            }
        }); 
   }
</script>