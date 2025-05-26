<script type="text/javascript">  
  
  setInterval(function() {
    var currentTime = new Date();    
    var cdate = currentTime.getDate();
    var cmonth = currentTime.getMonth()+1; 
    var cyear = currentTime.getFullYear(); 
    var currentHours = currentTime.getHours();   
    var currentMinutes = currentTime.getMinutes();   
    var currentSeconds = currentTime.getSeconds();
    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;   
    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;    
    var timeOfDay = (currentHours < 12 ) ? "AM" : "PM";    
    currentHours = (currentHours > 12 ) ? currentHours - 12 : currentHours;    
    currentHours = (currentHours == 0 ) ? 12 : currentHours;    
    var currentTimeString =cdate + "/" + cmonth + "/" + cyear + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    document.getElementById("ch_date").innerHTML = currentTimeString;
}, 1000);
</script>
<div class="top_nav">
    <div class="nav_menu" >
        <nav>

            <div class="col-md-1" style="">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars" style="color: #fff"></i></a>
                </div>
            </div>
            <div class="col-md-8" style="text-align: left; font-weight: bold; text-transform: uppercase;">
                
                <div class="school-name">
                    <ul class="nav navbar-nav">
                        <li class="dropdown message-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span id="ch_date"></span>
                            </a>
                        </li>
                    </ul>
                    <?php  if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>
                        <?php echo $this->session->userdata('school_name'); ?>
                    <?php }else{ ?>
                       <?php echo $this->global_setting->brand_name ? $this->global_setting->brand_name : SMS; ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="nav navbar-nav <?php echo $this->global_setting->enable_rtl ? 'navbar-left' : 'navbar-right'; ?>">
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <?php
                                $photo = $this->session->userdata('photo');
                                $role_id = $this->session->userdata('role_id');
                                $path = '';
                                if($role_id == STUDENT){ $path = 'student'; }
                                elseif($role_id == GUARDIAN){ $path = 'guardian'; }
                                elseif($role_id == TEACHER){ $path = 'teacher'; }
                                else{ $path = 'employee'; }
                            ?>
                            <?php if ($photo != '') { ?>                                        
                                <img src="<?php echo UPLOAD_PATH; ?>/<?php echo $path; ?>-photo/<?php echo $photo; ?>" alt="" width="60" /> 
                            <?php } else { ?>
                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="60" /> 
                            <?php } ?>                            
                            <?php echo $this->session->userdata('name'); ?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="<?php echo site_url('profile/index'); ?>"> <?php echo $this->lang->line('profile'); ?></a></li>
                            <li><a href="<?php echo site_url('profile/password'); ?>"><?php echo $this->lang->line('reset_password'); ?></a></li>
                            <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> <?php echo $this->lang->line('logout'); ?></a></li>
                        </ul>
                    </li>
                    
                    <?php $messages = get_inbox_message(); ?>
                    <?php if(isset($messages) && !empty($messages)){ ?>
                    <li role="presentation" class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-red"><?php echo count($messages); ?></span>
                        </a>
                        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                            
                           <?php foreach($messages as $obj){ ?> 
                            <li>
                                <?php $user = get_user_by_id($obj->sender_id); ?>
                                <a href="<?php echo site_url('message/view/'.$obj->id); ?>">
                                    <span class="image"><img src="<?php echo IMG_URL; ?>default-user.png" alt="Profile Image" /></span>
                                    <span>
                                        <span><?php echo @$user->name; ?></span>
                                        <span class="time"><?php echo get_nice_time($obj->created_at); ?></span>
                                    </span>
                                    <span class="message">
                                        <?php echo $obj->subject; ?>
                                    </span>
                                </a>
                            </li>                    
                            <?php } ?>
                            <li>
                                <div class="text-center">
                                    <a href="<?php echo site_url('message/inbox'); ?>">
                                        <strong>See All</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>                   
                        
                    </li>
                    <?php } ?>                     
                    <?php if($this->global_setting->enable_frontend){ ?>
                        <li>
                            <?php if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>                            
                                    <?php if($this->school_setting->enable_frontend){ ?>
                                        <a href="<?php echo site_url(); ?>"><i class="fa fa-globe"></i> Web</a>
                                    <?php } ?> 
                            <?php }else{ ?>  
                                <a href="<?php echo site_url(); ?>"><i class="fa fa-globe"></i> Web</a>
                            <?php } ?>  
                        </li>
                    <?php } ?>
                    
                </ul>
            </div>
        </nav>

   
</div>
</div>
<!-- <div class="content-wrapper">
    <section class="content-header">
        <div class="col-md-12 col-sm-12 col-xs-12">
         <?php  if(UPLOAD_PATH.'logo/'.$this->global_setting->banner){ ?>
            <img  src="<?php echo UPLOAD_PATH.'logo/logo.png'.$this->global_setting->banner; ?>" style="width: 100%; height: 100px;" alt="">
                        <?php } ?>
        <hr></div>
    </section>
 </div> -->
  </div>
<!--ty3.

"p.0--<?php if(has_permission(VIEW, 'setting', 'globalsearch') || has_permission(VIEW, 'setting', 'sessionchange')){ ?> 

    <div class="<?php echo $this->enable_rtl ? 'left_col' : 'right_col'; ?> fn_header_global no-print">  
    <div class="x_panel" style="padding-bottom: 2px;margin: 0px;">             
        <div class="x_content"> 
            <div class="row">               
               <?php if(has_permission(VIEW, 'setting', 'globalsearch')){ ?> 
                <div class="col-md-5 col-sm-5 col-xs-12">        

                    <div class="row">
                        <?php if ($this->session->userdata('role_id') == SUPER_ADMIN) { ?>                
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="item form-group">        
                                    <select  class="form-control col-md-7 col-xs-12" name="search_school_id" id="search_school_id" required="required">
                                        <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option>
                                        <?php foreach ($this->schools as $obj) { ?>
                                            <option value="<?php echo $obj->id; ?>" ><?php echo $obj->school_name; ?></option>
                                        <?php } ?>
                                    </select>       
                                </div>
                            </div>
                        <?php } else { ?>  
                           <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="text-right" style="padding-top: 5px;"><?php echo $this->lang->line('global_search'); ?></label>
                                <input type="hidden" class="" name="search_school_id" id="search_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                           </div>
                        <?php } ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="item form-group">                                
                                <input type="text"  class="form-control col-md-7 col-xs-12"  name="global_search"  id="global_search" onkeyup="get_search(this.value);" placeholder="<?php echo $this->lang->line('global_search'); ?>" required="required">
                            </div>
                        </div>
                    </div>                       
                </div>
               <?php } ?>
                                
                <?php if(has_permission(VIEW, 'setting', 'sessionchange')){ ?> 
                 <div class="col-md-1 col-sm-1 col-xs-1 header-form-sep"> |</div>
                
                 <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <?php if ($this->session->userdata('role_id') == SUPER_ADMIN) { ?>                
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="item form-group">        
                                    <select  class="form-control col-md-7 col-xs-12" name="ay_school_id" id="ay_school_id" required="required" onchange="get_academic_year_by_school(this.value, '');">
                                        <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option>
                                        <?php foreach ($this->schools as $obj) { ?>
                                            <option value="<?php echo $obj->id; ?>" ><?php echo $obj->school_name; ?></option>
                                        <?php } ?>
                                    </select>       
                                </div>
                            </div>
                        <?php } else { ?>                           
                            <input type="hidden" class="" name="ay_school_id" id="ay_school_id" value="<?php echo $this->session->userdata('school_id'); ?>" />
                        <?php } ?>

                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="item form-group"> 
                                <select  class="form-control col-md-7 col-xs-12"  name="ay_academic_year_id"  id="ay_academic_year_id" required="required">
                                    <option value="">--<?php echo $this->lang->line('session_year'); ?>--</option>                                                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <button  type="submit" class="btn btn-success" onclick="update_academic_year();"><?php echo $this->lang->line('update'); ?></button>
                            </div>
                        </div>

                    </div>          
                </div> 
                <?php } ?>
                
            </div>
            
            
            <!-- ====================START ======================= ->
            <div class="search_result_container"  style="position: absolute; padding-top: 1px; z-index: 999; background: #000;width: 100%; display: none;">
                <div class="row search_result" style="background: #fff; margin:0px 25px 10px  25px;">                    
                </div>
            </div>
            <!-- ====================END ======================= ->
            
        </div>
    </div>
</div-->
 <script type="text/javascript">
    
    //================ SEARCH ======================================================
      function get_search(keyword){        
         
        var school_id = $('#search_school_id').val(); 
        if(!school_id){
           //toastr.error('<?php echo $this->lang->line('select_school'); ?>');           
           return false;
        }
        
        if(!keyword){
            $('.search_result').html(''); 
            $('.search_result_container').hide(); 
            return false;
        }
        
        $('.search_result_container').show();  
        $('.search_result').html('<p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" style="width: 40px;" /></p>');
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('dashboard/get_search'); ?>",
            data   : { school_id : school_id, keyword : keyword},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                                                      
                   $('.search_result_container').show();                                     
                   $('.search_result').html(response);                                     
               }else{
                   $('.search_result_container').hide(); 
               }
            }
        }); 
    }
    
    
    
    //======================== ACADEMIC YEAR ==================================
    <?php if ($this->session->userdata('role_id') != SUPER_ADMIN && has_permission(VIEW, 'setting', 'sessionchange')) { ?> 
         get_academic_year_by_school($('#ay_school_id').val(), '');
    <?php } ?>    
        
    function get_academic_year_by_school(ay_school_id, ay_academic_year_id){        
         
        if(!ay_school_id){
           //toastr.error('<?php echo $this->lang->line('select_school'); ?>');
            $('#ay_academic_year_id').prop('selectedIndex',0);
           return false;
        }
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id : ay_school_id, academic_year_id : ay_academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#ay_academic_year_id').html(response);                                     
               }
            }
        }); 
    }
    
    function update_academic_year(){
    
       var ay_school_id = $('#ay_school_id').val();
       var ay_academic_year_id = $('#ay_academic_year_id').val();
       
       if(!ay_school_id){
           //toastr.error('<?php echo $this->lang->line('select_school'); ?>');
            $('#ay_academic_year_id').prop('selectedIndex',0);
           return false;
        }
        
       if(!ay_academic_year_id){
           toastr.error('<?php echo $this->lang->line('session_year'); ?>');           
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('administrator/year/update_academic_year'); ?>",
            data   : { school_id : ay_school_id, academic_year_id : ay_academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   toastr.success('<?php echo $this->lang->line('update_success') ?>');                   
                   location.reload();
               }else{
                   toastr.error('<?php echo $this->lang->line('update_failed') ?>'); 
               }
            }
        });        
    } 
</script>

 <?php } ?>