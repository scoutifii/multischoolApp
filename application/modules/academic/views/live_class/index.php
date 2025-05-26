<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-headphones"></i><small> <?php echo $this->lang->line('manage_live_class'); ?></small></h3>
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
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_liveclass_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'academic', 'liveclass')){ ?>                        
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('academic/liveclass/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('live_class'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_liveclass"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('live_class'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_liveclass"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('live_class'); ?></a> </li>                          
                        <?php } ?>               
                        
                         
                            <li class="li-class-list">
                                
                            <?php $teacher_access_data = get_teacher_access_data('student'); ?> 
                            <?php $guardian_access_data = get_guardian_access_data('class'); ?>    
                                
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                
                                <?php echo form_open(site_url('academic/liveclass/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
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
                                
                                    <select  class="form-control col-md-7 col-xs-12" onchange="get_live_class_list_by_class(this.value);">
                                        <option value="<?php echo site_url('academic/liveclass/index'); ?>">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php foreach($class_list as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                                <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?> 
                                                <option value="<?php echo site_url('academic/liveclass/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>
                                                <?php if (!in_array($obj->id, $guardian_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('academic/liveclass/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>
                                                <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                <option value="<?php echo site_url('academic/liveclass/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo site_url('academic/liveclass/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?> 

                                        <?php } ?>                                            
                                    </select>                                      
                                <?php } ?>
                            </li>    
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_liveclass_list" >                            
                            <div class="x_content">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <th><?php echo $this->lang->line('school'); ?></th>
                                            <?php } ?>
                                            <th><?php echo $this->lang->line('class'); ?></th>                                       
                                            <th><?php echo $this->lang->line('section'); ?></th>                                       
                                            <th><?php echo $this->lang->line('subject'); ?></th>                                       
                                            <th><?php echo $this->lang->line('teacher'); ?></th>                                       
                                            <th><?php echo $this->lang->line('class_date'); ?></th>
                                            <th><?php echo $this->lang->line('start_time'); ?></th>
                                            <th><?php echo $this->lang->line('end_time'); ?></th>
                                            <th><?php echo $this->lang->line('status'); ?></th>                                            
                                            <th><?php echo $this->lang->line('action'); ?></th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>   
                                                                                
                                        <?php $count = 1; if(isset($live_classes) && !empty($live_classes)){ ?>
                                            <?php foreach($live_classes as $obj){ ?>                                        
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
                                                <td><?php echo $obj->class_name; ?></td>
                                                <td><?php echo $obj->section; ?></td>
                                                <td><?php echo $obj->subject; ?></td>
                                                <td><?php echo $obj->teacher; ?></td>
                                                <td><?php echo date($this->global_setting->date_format, strtotime($obj->class_date)); ?></td>
                                                 <td><?php echo $obj->start_time; ?></td>
                                                <td><?php echo $obj->end_time; ?></td>
                                                <td>
                                                    
                                                    <?php  
                                                        $class_type = $obj->class_type == 'zoom' ? 'Zoom' : 'Jitsi';
                                                        $flag = 1;;
                                                        $status = '<i class="fa fa-spinner"></i> ' . $this->lang->line('waiting');
                                                        $button = 'btn btn-info btn-xs';
                                                        if (strtotime($obj->class_date) == strtotime(date('Y-m-d')) && (strtotime(date('Y-m-d') .' '. $obj->start_time)) <= (strtotime(date('Y-m-d g:i A'))) && (strtotime(date('Y-m-d') .' '. $obj->end_time)) >= (strtotime(date('Y-m-d g:i A')))) {
                                                            $status = '<i class="fa fa-video-camera"></i> Live ' . $this->lang->line('live');
                                                            $button = 'btn btn-success btn-xs';
                                                            $flag = 2;
                                                        }else if (strtotime($obj->class_date) < strtotime(date('Y-m-d')) || (strtotime(date('Y-m-d') .' '. $obj->end_time)) < (strtotime(date('Y-m-d g:i A')))) {
                                                            $status = '<i class="fa fa-check-square"></i> ' . $this->lang->line('expire');
                                                            $button = 'btn btn-danger btn-xs';
                                                            $flag = 3;
                                                        }
                                                        echo "<span class=' " . $button . " '>" . $status . "</span>";
                                                        ?>
                                                </td>
                                                <td>                                                    
                                                    <?php if(has_permission(VIEW, 'academic', 'liveclass') && ($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN)){ ?>
                                                        
                                                        <?php if($flag == 2){ ?>
                                                                <a  href="<?php echo site_url('academic/liveclass/start/'.$obj->id); ?>"   class="btn btn-success btn-xs"><i class="fa fa-sitemap"></i> <?php echo $this->lang->line('join_class'); ?> </a>
                                                        <?php }elseif($flag == 1){ ?>
                                                                <a  onclick="javascript: return confirm('<?php echo $this->lang->line('waiting'); ?>');"   class="btn btn-info btn-xs"><i class="fa fa-hand-o-up"></i> <?php echo $this->lang->line('join_class'); ?> [ <?php echo $class_type; ?> ]</a>
                                                        <?php }else{ ?>
                                                                <a  onclick="javascript: return confirm('<?php echo $this->lang->line('expire'); ?>');"   class="btn btn-danger btn-xs"><i class="fa fa-hand-o-up"></i> <?php echo $this->lang->line('join_class'); ?> [ <?php echo $class_type; ?> ]</a>
                                                        <?php } ?>
                                                                
                                                    <?php }else{ ?>
                                                                
                                                        <?php if($flag == 2){ ?>
                                                                <a  href="<?php echo site_url('academic/liveclass/start/'.$obj->id); ?>"   class="btn btn-success btn-xs"><i class="fa fa-sitemap"></i> <?php echo $this->lang->line('host_class'); ?> </a>
                                                        <?php }elseif($flag == 1){ ?>
                                                                <a  onclick="javascript: return confirm('<?php echo $this->lang->line('waiting'); ?>');"   class="btn btn-info btn-xs"><i class="fa fa-hand-o-up"></i> <?php echo $this->lang->line('host_class'); ?> [ <?php echo $class_type; ?> ]</a>
                                                        <?php }else{ ?>
                                                                <a  onclick="javascript: return confirm('<?php echo $this->lang->line('expire'); ?>');"   class="btn btn-danger btn-xs"><i class="fa fa-hand-o-up"></i> <?php echo $this->lang->line('host_class'); ?> [ <?php echo $class_type; ?> ]</a>
                                                        <?php } ?>
                                                                
                                                    <?php } ?>  
                                                        
                                                    <?php if(has_permission(EDIT, 'academic', 'liveclass')){ ?>
                                                        <a href="<?php echo site_url('academic/liveclass/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                    <?php } ?>                                                    
                                                    <?php if(has_permission(DELETE, 'academic', 'liveclass')){ ?>
                                                        <a href="<?php echo site_url('academic/liveclass/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('conirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- End first tab -->
                        
                        

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_liveclass">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('academic/liveclass/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>  
                                                               
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_type"><?php echo $this->lang->line('live_class_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 data_subject"  name="class_type" id="add_class_type" required="required" onchange="set_live_class_type(this.value, 'add');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            <option value="zoom">Zoom Meet</option>                                                                                         
                                            <option value="jitsi">Jitsi Meet</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="fn_add_zoom_setting display">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meeting_id"><?php echo $this->lang->line('meeting_id'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="meeting_id"  id="add_meeting_id" value="<?php echo isset($post['meeting_id']) ?  $post['meeting_id'] : ''; ?>" placeholder="<?php echo $this->lang->line('meeting_id'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('meeting_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meeting_password"><?php echo $this->lang->line('meeting_password'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="meeting_password"  id="add_meeting_password" value="<?php echo isset($post['meeting_password']) ?  $post['meeting_password'] : ''; ?>" placeholder="<?php echo $this->lang->line('meeting_password'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('meeting_password'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_date"><?php echo $this->lang->line('class_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="class_date"  id="add_class_date" value="<?php echo isset($post['class_date']) ?  $post['class_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('class_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('class_date'); ?></div>
                                    </div>
                                </div>
                                                               
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_time"><?php echo $this->lang->line('start_time'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="start_time"  id="add_start_time" value="<?php echo isset($post['start_time']) ?  $post['start_time'] : ''; ?>" placeholder="<?php echo $this->lang->line('start_time'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('start_time'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_time"><?php echo $this->lang->line('end_time'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="end_time"  id="add_end_time" value="<?php echo isset($post['end_time']) ?  $post['end_time'] : ''; ?>" placeholder="<?php echo $this->lang->line('end_time'); ?>" required="required" type="text"  autocomplete="off">
                                        <div class="help-block"><?php echo form_error('end_time'); ?></div>
                                    </div>
                                </div>
                                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="send_notification"><?php echo $this->lang->line('send_notification'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" value="1" name="send_notification" id="add_send_notification" />
                                        <div class="help-block"><?php echo form_error('send_notification'); ?></div>
                                    </div>
                                </div>
                               
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('academic/liveclass/index/'.$class_id); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>                              
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_liveclass">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('academic/liveclass/edit/'.$live_class->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                 
                                <?php $this->load->view('layout/school_list_edit_form'); ?> 
                                
                                
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
                                                    <option value="<?php echo $obj->id; ?>" <?php if($obj->id == $live_class->class_id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
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
                                                       <option value="<?php echo $obj->id; ?>" <?php echo isset($live_class->teacher_id) && $live_class->teacher_id == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_type"><?php echo $this->lang->line('live_class_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 data_subject"  name="class_type" id="add_class_type" required="required" onchange="set_live_class_type(this.value, 'edit');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            <option value="zoom" <?php echo isset($live_class->class_type) && $live_class->class_type == 'zoom' ?  'selected="selected"' : ''; ?>>Zoom Meet</option>                                                                                         
                                            <option value="jitsi" <?php echo isset($live_class->class_type) && $live_class->class_type == 'jitsi' ?  'selected="selected"' : ''; ?>>Jitsi Meet</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="fn_edit_zoom_setting <?php echo isset($live_class->class_type) && $live_class->class_type == 'zoom' ? '' : 'display'; ?>">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meeting_id"><?php echo $this->lang->line('meeting_id'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="meeting_id"  id="edit_meeting_id" value="<?php echo isset($live_class->meeting_id) ?  $live_class->meeting_id : ''; ?>" placeholder="<?php echo $this->lang->line('meeting_id'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('meeting_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meeting_password"><?php echo $this->lang->line('meeting_password'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="meeting_password"  id="edit_meeting_password" value="<?php echo isset($live_class->meeting_password) ?  $live_class->meeting_password : ''; ?>" placeholder="<?php echo $this->lang->line('meeting_password'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('meeting_password'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_date"><?php echo $this->lang->line('class_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="class_date"  id="edit_class_date" value="<?php echo isset($live_class->class_date) ?  date('d-m-Y', strtotime($live_class->class_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('class_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('class_date'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_time"><?php echo $this->lang->line('start_time'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="start_time"  id="edit_start_time" value="<?php echo isset($live_class->start_time) ?  $live_class->start_time : ''; ?>" placeholder="<?php echo $this->lang->line('start_time'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('start_time'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_time"><?php echo $this->lang->line('end_time'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="end_time"  id="edit_end_time" value="<?php echo isset($live_class->end_time) ?  $live_class->end_time : ''; ?>" placeholder="<?php echo $this->lang->line('end_time'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('end_time'); ?></div>
                                    </div>
                                </div>
                                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($live_class->note) ?  $live_class->note : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="send_notification"><?php echo $this->lang->line('send_notification'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" value="1" name="send_notification" id="add_send_notification" <?php echo isset($live_class->send_notification) && $live_class->send_notification == 1 ?  'checked="checked"' : ''; ?>/>
                                        <div class="help-block"><?php echo form_error('send_notification'); ?></div>
                                    </div>
                                </div>
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($live_class) ? $live_class->id : $id; ?>" name="id" />
                                        <a  href="<?php echo site_url('academic/liveclass/index/'.$class_id); ?>"  class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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
  
    function set_live_class_type(class_type, form_mode){
        
        if(class_type == 'zoom'){
            $('.fn_'+form_mode+'_zoom_setting').show();
            $('#'+form_mode+'_meeting_id').prop('required', true);  
            $('#'+form_mode+'_meeting_password').prop('required', true);  
        }else{
            $('.fn_'+form_mode+'_zoom_setting').hide();
            $('#'+form_mode+'_meeting_id').prop('required', false);  
            $('#'+form_mode+'_meeting_password').prop('required', false);
        }
    }
  
    <?php if(isset($edit)){ ?>
        edit = true;
        get_subject_by_class('<?php echo $live_class->class_id; ?>', '<?php echo $live_class->subject_id; ?>');
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
        get_section_by_class('<?php echo $live_class->class_id; ?>', '<?php echo $live_class->section_id; ?>');
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
    
    function get_live_class_list_by_class(url){          
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