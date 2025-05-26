<header>
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 hta-left">
                    <div class="hta-box">
                        <p class="text"><?php echo $this->lang->line('have_any_question'); ?></p>
                    </div>                    
                    <?php if(isset($school->email)){ ?>
                        <div class="hta-box">
                            <span class="icon"><i class="fas fa-phone"></i></span>
                            <p class="text"><?php echo $school->phone; ?></p>
                        </div>                       
                   <?php } ?>   
                    <?php if(isset($school->email)){ ?>
                        <div class="hta-box">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                            <p class="text"><?php echo $school->email; ?></p>
                        </div>                        
                   <?php } ?>
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 hta-right text-right">
                    <?php if(isset($schools) && count($schools) > 1){ ?>
                        <div class="hta-box">
                            <?php echo form_open_multipart(site_url(), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <div class="item form-group"> 
                                <select  class="form-control col-md-7 col-xs-12"  name="role_id"  id="edit_role_id" required="required" onchange="change_school(this.value);">
                                     <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach($schools as $obj ){ ?>
                                    <option value="<?php echo site_url('school/'.$obj->id); ?>" <?php if($this->session->userdata('front_school_id') == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->school_name; ?></option>
                                    <?php } ?>                                            
                                 </select>
                                 </div>    
                            <?php echo form_close(); ?>
                        </div>
                    <?php } ?> 
                    
                    <?php if(isset($school->enable_online_admission) && $school->enable_online_admission){ ?>
                        <div class="hta-box">
                            <a class="text" href="<?php echo site_url('admission-online'); ?>"><?php echo $this->lang->line('admission'); ?></a>
                        </div>
                    <?php } ?> 
                    
                    <?php if (logged_in_user_id()) { ?>  
                    
                        <div class="hta-box">
                            <a class="text" href="<?php echo site_url('dashboard'); ?>"><?php echo $this->lang->line('dashboard'); ?></a>
                        </div>
                        <div class="hta-box">
                            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                            <a class="text" href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>
                        </div>
                    <?php }else{ ?>
                        <div class="hta-box">
                            <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                            <a class="text" href="<?php echo site_url('login'); ?>"><?php echo $this->lang->line('login'); ?></a>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 offset-lg-0 col-md-4 offset-md-3 col-sm-6 col-6">
                    <div class="logo">
                        <a href="<?php echo site_url(); ?>">
                            <?php if(isset($school->frontend_logo)){ ?>                            
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""  />
                            <?php }elseif(isset($school->logo)){ ?>                            
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt=""  />
                            <?php }else{ ?>
                                <img  width="100" height="100" src="<?php echo IMG_URL; ?>/sms-log.png">
                            <?php } ?>    
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 offset-lg-0 col-md-8 offset-md-2 col-sm-12 col-12">
                    <div class="menu">
                        <nav id="mobile_menu_active">
                            <ul id="menu">
                                <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('announcement'); ?> <span class="icon fas fa-chevron-down"></span></a>
                                    <ul class="drop">
                                        <li><a href="<?php echo site_url('news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
                                        <li><a href="<?php echo site_url('notice'); ?>"><?php echo $this->lang->line('notice'); ?></a></li>
                                        <li><a href="<?php echo site_url('holiday'); ?>"><?php echo $this->lang->line('holiday'); ?></a></li>
                                    </ul>                                
                                </li>
                                <li><a href="<?php echo site_url('events'); ?>"><?php echo $this->lang->line('event'); ?></a></li>
                                <li><a href="<?php echo site_url('galleries'); ?>"><?php echo $this->lang->line('gallery'); ?></a></li>
                                <li><a href="<?php echo site_url('teachers'); ?>"><?php echo $this->lang->line('teacher'); ?></a></li>
                                <li><a href="<?php echo site_url('staff'); ?>"><?php echo $this->lang->line('staff'); ?></a></li>
                                <li><a href="<?php echo site_url('contact'); ?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
                                <?php if(isset($header_pages) && !empty($header_pages)){ ?>
                                    <li><a href="javascript:void(0)"><?php echo $this->lang->line('page'); ?> <span class="icon fas fa-chevron-down"></span></a>
                                        <ul class="drop">
                                        <?php foreach($header_pages AS $obj ){ ?>
                                             <li><a href="<?php echo site_url('page/'.$obj->page_slug); ?>"><?php echo $obj->page_title; ?></a></li>
                                         <?php } ?> 
                                        </ul>                                
                                    </li>    
                                <?php } ?> 
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>