<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-comments-o"></i><small> <?php echo $this->lang->line('manage_message'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <?php $this->load->view('message-nav'); ?>   
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $this->lang->line('compose'); ?></h3>              
                            </div>
                            <div class="box box-primary">
                                <?php echo form_open_multipart(site_url('message/compose'), array('name' => 'compose', 'id' => 'compose', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="box-body">
                                 <?php $teacher_access_data = get_teacher_access_data('student'); ?> 
                                 <?php $guardian_access_data = get_guardian_access_data('class'); ?>   
                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                <?php $schools = get_school_list(); ?>
                                    <div class="item form-group">                                    
                                        <select  class="form-control col-md-7 col-xs-12 fn_school_id" name="school_id" id="school_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option>
                                            <?php foreach($schools as $obj){ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if(isset($school_id) && $school_id == $obj->id){echo 'selected="selected"';} ?>><?php echo $obj->school_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('school_id'); ?></div>                                   
                                    </div>
                                <?php }else{ ?>
                                    <div class="item form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="hidden" name="school_id" id="school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                                        </div>
                                    </div>
                                <?php } ?>
                                    
                                <div class="item form-group">                                    
                                    <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                        <option value="">--<?php echo $this->lang->line('receiver_type'); ?> *--</option> 
                                        <?php if(isset($roles) && !empty($roles)){ ?>
                                            <?php foreach($roles as $obj ){ ?>
                                        
                                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                     <?php if(in_array($obj->id, array())){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }elseif($this->session->userdata('role_id') == ADMIN){ ?>
                                                     <?php if(in_array($obj->id, array(SUPER_ADMIN))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        
                                                <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>
                                                     <?php if(!in_array($obj->id, array(ADMIN, GUARDIAN, STUDENT, TEACHER, ACCOUNTANT, LIBRARIN, RECEPTIONIST))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        
                                                <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>
                                                     <?php if(!in_array($obj->id, array(ADMIN, TEACHER, LIBRARIN, ACCOUNTANT, RECEPTIONIST))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                     
                                                <?php }elseif($this->session->userdata('role_id') == STUDENT){ ?>
                                                     <?php if(!in_array($obj->id, array(ADMIN, TEACHER, STUDENT, LIBRARIN, ACCOUNTANT, RECEPTIONIST))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                               
                                                <?php }elseif($this->session->userdata('role_id') == ACCOUNTANT){ ?>
                                                     <?php if(in_array($obj->id, array(SUPER_ADMIN))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                
                                                <?php }elseif($this->session->userdata('role_id') == LIBRARIN){ ?>
                                                     <?php if(!in_array($obj->id, array(ADMIN, GUARDIAN, STUDENT, TEACHER))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                
                                               <?php }else{ ?>
                                                     <?php if(!in_array($obj->id, array(ADMIN, ACCOUNTANT))){ continue;} ?>
                                                     <option value="<?php echo $obj->id; ?>" <?php if(isset($message) && $message->role_id == $obj->id ){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                                     
                                            <?php } ?>                                            
                                        <?php } ?>                                            
                                    </select>
                                    <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                </div>
                                    
                                <div class="item form-group display">                                 
                                    <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="class_id"  onchange="get_user('', this.value,'');">
                                        <option value="">--<?php echo $this->lang->line('class'); ?> *--</option>  
                                        <?php if(isset($classes) && !empty($classes)){ ?>
                                            <?php foreach($classes as $obj ){ ?>
                                                   <?php
                                                    if($this->session->userdata('role_id') == TEACHER){
                                                       if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                    }elseif($this->session->userdata('role_id') == GUARDIAN){
                                                       if (!in_array($obj->id, $guardian_access_data)) {continue; }
                                                    }elseif($this->session->userdata('role_id') == STUDENT){
                                                       if ($obj->id != $this->session->userdata('class_id')){ continue; }
                                                    } 
                                                    ?>
                                              <option value="<?php echo $obj->id; ?>" ><?php echo $obj->name; ?></option>
                                            <?php } ?> 
                                        <?php } ?> 
                                    </select>
                                    <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                </div>
                                    
                                    <div class="item form-group">                                 
                                        <select  class="form-control col-md-12 col-xs-12"  name="receiver_id"  id="receiver_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('receiver'); ?> *--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('receiver_id'); ?></div>
                                    </div>
                                    
                                   
                                    <div class="form-group">                                     
                                        <input  class="form-control col-md-7 col-xs-12"  name="subject"  id="subject" value="<?php if(isset($message)){ echo $message->subject;} ?>" placeholder="<?php echo $this->lang->line('subject'); ?> *" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('subject'); ?></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea  class="form-control" name="body" id="body" required="required" placeholder="<?php echo $this->lang->line('message'); ?> *"><?php if(isset($message)){ echo $message->body;} ?></textarea>
                                        <div class="help-block"><?php echo form_error('body'); ?></div>
                                    </div>                                    
                                </div>
                                <!-- /.box-body -->
                                 <div class="ln_solid"></div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <?php if(isset($message)){  ?>
                                            <input type="hidden" name="message_id" id="message_id" value="<?php echo $message->message_id; ?>" />
                                        <?php } ?>
                                            
                                        <button type="submit" name="draft" class="btn btn-default"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('draft'); ?></button>
                                        <button type="submit" name="send" class="btn btn-primary"><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('send'); ?></button>
                                    </div>
                                    <a href="<?php echo site_url('message/compose'); ?>" ><button type="reset" class="btn btn-default"><i class="fa fa-times"></i> <?php echo $this->lang->line('discard'); ?></button></a>
                                </div>
                                  <?php echo form_close(); ?>
                            </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
     
     
    $('#school_id').on('change', function(){
        $('#class_id').prop('selectedIndex',0);
        $('#role_id').prop('selectedIndex',0);
        $('#receiver_id').prop('selectedIndex',0);
                
        var school_id = $(this).val(); 
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                  $('#class_id').html(response);  
               }
            }
        });   
        
    });
     
  <?php if(isset($message)){ ?>
        get_user_by_role('<?php echo $message->role_id; ?>', '<?php echo $message->receiver_id; ?>');
        
    <?php } ?>
    
    function get_user_by_role(role_id, user_id){       
       
       
       
       if(role_id == <?php echo STUDENT; ?>){
           $('.display').show();
           $('#class_id').attr("required");
           $('#receiver_id').html('<option value="">--<?php echo $this->lang->line('receiver'); ?>--</option>'); 
       }else{
           get_user(role_id, '', user_id);
           $('#class_id').removeAttr("required");
           $('.display').hide();
       }         
   }
   
   function get_user(role_id, class_id, user_id){
       
       var school_id = $('#school_id').val();
       
       if(role_id == ''){
           role_id = $('#role_id').val();
       }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_by_role'); ?>",
            data   : {school_id:school_id, role_id : role_id , class_id: class_id, user_id:user_id, message:true},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#receiver_id').html(response); 
               }
            }
        }); 
   }
    $("#compose").validate();
</script> 
