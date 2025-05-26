<div class="col-md-3 <?php echo $this->global_setting->enable_rtl ? 'right_col' : 'left_col'; ?>">
    <div class="<?php echo $this->global_setting->enable_rtl ? 'right_col' : 'left_col'; ?> scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo site_url('dashboard'); ?>">
               <?php if($this->global_setting->brand_name){ ?>
                    <span <?php if(str_word_count($this->global_setting->brand_name) == 1 ){ echo 'style="margin-top: 10px;color:red;"'; }  ?>>
                        <?php  echo $this->global_setting->brand_name; ?>
                    </span>
                <?php }else{ ?>
                     <!--span>Olify School</span-->    
                <?php } ?> 
                
                <?php if($this->school_setting->frontend_logo){ ?>
                     <img class="" src="<?php echo UPLOAD_PATH.'logo/'.$this->school_setting->frontend_logo; ?>" style="width: 50px; vertical-align: center;" alt="">
                <?php }else{ ?>
                     <img class="logo" src="<?php echo IMG_URL; ?>/olify.png"  style="width: 50px; height: 60px; vertical-align: center;" alt="">
                <?php } ?>
            </a>
        </div>
   <br>
   <!--br>
   <br>
   <br>
   <br>
        <hr>
       
        <div class="clearfix">
           <span style="font-size: 12px; font-weight: bold;max-width:100%; color: white;">
                     <?php echo $this->global_setting->brand_name ? $this->global_setting->brand_name : SMS; ?>
                </span>
<hr> 
        </div> 
              
        sidebar menu 
         <ul class="sessionul fixedmenu">
            
        </ul-->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <?php 
                    if($this->session->userdata('role_id') != SUPER_ADMIN){                  
                        $classes = get_classes($this->session->userdata('school_id'));
                    } 
                    if($this->session->userdata('role_id') == GUARDIAN){                  
                        $guardian_class_data = get_guardian_access_data('class'); 
                    }               
                ?>

                <ul class="nav side-menu">                    
                    <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('dashboard'); ?></a>  </li>
                    
                    
                    <?php if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>
                        <?php if(has_permission(VIEW, 'setting', 'setting') || has_permission(VIEW, 'setting', 'payment')  || has_permission(VIEW, 'setting', 'osms')){ ?> 
                            <li><a><i class="fa fa-gears"></i> <?php echo $this->lang->line('setting'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                            
                                    <?php if(has_permission(VIEW, 'setting', 'setting')){ ?>
                                        <li><a href="<?php echo site_url('setting'); ?>"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if(has_permission(VIEW, 'setting', 'payment')){ ?> 
                                        <li><a href="<?php echo site_url('setting/payment'); ?>"><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if(has_permission(VIEW, 'setting', 'sms')){ ?>
                                        <li><a href="<?php echo site_url('setting/sms'); ?>"><?php echo $this->lang->line('sms'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>                        
                        <?php } ?>
                          
                    <?php } ?>
                    <li><a><i class="fa fa-lock"></i><?php echo $this->lang->line('profile'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo site_url('profile'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('my_profile'); ?></a></li>
                            <li><a href="<?php echo site_url('profile/password'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('reset_password'); ?></a></li>
                            <?php if($this->session->userdata('role_id') == GUARDIAN){ ?>
                                <li><a href="<?php echo site_url('guardian/invoice'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('invoice'); ?></a></li>
                                <li><a href="<?php echo site_url('guardian/feedback'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('feedback'); ?></a></li>
                            <?php } ?>
                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('invoice'); ?></a></li>
                            <?php } ?>
                            <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('logout'); ?></a></li>
                        </ul>
                    </li>  
                    <?php if(has_permission(VIEW, 'card', 'idsetting') || 
                            has_permission(VIEW, 'card', 'schoolidsetting') ||
                            has_permission(VIEW, 'card', 'admitsetting') ||
                            has_permission(VIEW, 'card', 'schooladmitsetting') ||
                            has_permission(VIEW, 'card', 'teacher') ||
                            has_permission(VIEW, 'card', 'employee') ||
                            has_permission(VIEW, 'card', 'student') ||
                            has_permission(VIEW, 'card', 'admit')){ ?>
                            
                        <li><a><i class="fa fa-barcode"></i> <?php echo $this->lang->line('generate_card'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">                                
                                <?php if(has_permission(VIEW, 'card', 'idsetting')){ ?>
                                    <li><a href="<?php echo site_url('card/idsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'card', 'admitsetting')){ ?>
                                     <li><a href="<?php echo site_url('card/admitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a></li>
                                <?php } ?>
                                        
                                <?php if(has_permission(VIEW, 'card', 'schoolidsetting')){ ?>
                                    <li><a href="<?php echo site_url('card/schoolidsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a></li>
                                <?php } ?>     
                                <?php if(has_permission(VIEW, 'card', 'schooladmitsetting')){ ?>
                                     <li><a href="<?php echo site_url('card/schooladmitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a></li>
                                <?php } ?>
                                        
                                <?php if(has_permission(VIEW, 'card', 'teacher')){ ?>
                                    <li><a href="<?php echo site_url('card/teacher/index'); ?>"><?php echo $this->lang->line('teacher_id_card'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'card', 'employee')){ ?>
                                    <li><a href="<?php echo site_url('card/employee/index'); ?>"><?php echo $this->lang->line('employee_id_card'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'card', 'student')){ ?>  
                                    <li><a href="<?php echo site_url('card/student/index'); ?>"><?php echo $this->lang->line('student_id_card'); ?></a></li>
                                <?php } ?>                                  
                                <?php if(has_permission(VIEW, 'card', 'admit')){ ?>  
                                    <li><a href="<?php echo site_url('card/admit/index'); ?>"><?php echo $this->lang->line('student_admit_card'); ?></a></li>
                                <?php } ?>                                  
                            </ul>
                        </li> 
                    <?php } ?> 
                   
                    <?php if(has_permission(VIEW, 'language', 'language')){ ?>
                        <li><a  href="<?php echo site_url('language'); ?>"><i class="fa fa-language"></i> <?php echo $this->lang->line('language'); ?></a></li>
                    <?php } ?>
                    <?php 
                    if(has_permission(VIEW, 'administrator', 'setting') ||
                            has_permission(VIEW, 'administrator', 'school') || 
                            has_permission(VIEW, 'administrator', 'payment') || 
                            has_permission(VIEW, 'administrator', 'sms') || 
                            has_permission(VIEW, 'administrator', 'year') || 
                            has_permission(VIEW, 'administrator', 'role') ||
                            has_permission(VIEW, 'administrator', 'manage_school') ||  
                            has_permission(VIEW, 'administrator', 'permission') || 
                            has_permission(VIEW, 'administrator', 'user') || 
                            has_permission(VIEW, 'administrator', 'usercredential') ||
                            has_permission(VIEW, 'administrator', 'superadmin') || 
                            has_permission(VIEW, 'administrator', 'districtadmin') ||
                            has_permission(EDIT, 'administrator', 'password') || 
                            has_permission(VIEW, 'administrator', 'backup') ||
                            has_permission(VIEW, 'administrator', 'emailtemplate') ||
                            has_permission(VIEW, 'administrator', 'smstemplate') ||
                            has_permission(VIEW, 'administrator', 'activitylog') ||
                            has_permission(VIEW, 'administrator', 'feedback')){ ?>    
                        <li><a><i class="fa fa-user"></i> <?php echo $this->lang->line('administrator'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'administrator', 'setting')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/setting'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('general'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'school')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/school'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('manage_school'); ?></a></li>
                                <?php } ?>
                                 <?php if(has_permission(VIEW, 'manageschool', 'region') || 
                                        has_permission(ADD, 'manageschool', 'sub_region') ||
                                        has_permission(ADD, 'manageschool', 'district') ||
                                        has_permission(ADD, 'manageschool', 'subcounty') ||
                                        has_permission(ADD, 'manageschool', 'parish') ||
                                        has_permission(ADD, 'manageschool', 'village')){ ?> 
                        
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>

                        <li><a><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('register_location'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'manageschool', 'region')){ ?>
                            <li><a  href="<?php echo site_url('manageschool/region/index/'); ?>"><i class="fa fa-map-marker"></i><?php echo $this->lang->line('region'); ?> </a></li>
                        <?php } ?>
                     
                            <?php if(has_permission(ADD, 'manageschool', 'subregion')){ ?>
                            <li> <a  href="<?php echo site_url('manageschool/subregion/index/'); ?>"> <i class="fa fa-map-marker"></i><?php echo $this->lang->line('subregion'); ?></a></li>
                      <?php } ?>

                            <?php if(has_permission(ADD, 'manageschool', 'district')){ ?>
                            <li> <a  href="<?php echo site_url('manageschool/district/index/'); ?>"><i class="fa fa-map-marker"></i> <?php echo $this->lang->line('district'); ?></a></li>
                      <?php } ?>

                            <?php if(has_permission(ADD, 'manageschool', 'subcounty')){ ?>
                            <li> <a  href="<?php echo site_url('manageschool/subcounty/index/'); ?>"> <i class="fa fa-map-marker"></i><?php echo $this->lang->line('subcounty'); ?></a></li>
                      <?php } ?>
                            <?php if(has_permission(ADD, 'manageschool', 'parish')){ ?>
                            <li> <a  href="<?php echo site_url('manageschool/parish/index/'); ?>"><i class="fa fa-map-marker"></i> <?php echo $this->lang->line('parish'); ?></a></li>
                      <?php } ?>
                            <?php if(has_permission(ADD, 'manageschool', 'village')){ ?>
                            <li> <a  href="<?php echo site_url('manageschool/village/index/'); ?>"><i class="fa fa-map-marker"></i><?php echo $this->lang->line('village'); ?></a></li>
                      <?php } ?>
                            </ul>                    
                        </li>
                    <?php } ?>
                    <?php } ?>



                                <?php if(has_permission(VIEW, 'administrator', 'payment')){ ?> 
                                <li class="treeview "><a href="<?php echo site_url('administrator/payment'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'sms')){ ?>
                                   <li class="treeview "><a href="<?php echo site_url('administrator/sms'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('sms'); ?> <?php echo $this->lang->line('setting'); ?></a></li>
                                <?php } ?>    
                                <?php if(has_permission(VIEW, 'administrator', 'year')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/year'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('academic_year'); ?></a></li>
                                 <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'role')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/role'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('user_role'); ?> (ACL)</a></li> 
                                <?php } ?>
                                 <?php if(has_permission(VIEW, 'administrator', 'manage_assets')){ ?>   
                                <li class="treeview "><a href="<?php echo site_url('assets/assets/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_assets'); ?></a></li>
                            <?php } ?>
                              <?php if(has_permission(VIEW, 'facility', 'facility') || 
                            has_permission(VIEW, 'facility', 'category')){ ?>            
                            <li><a><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('facility'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                            <?php if(has_permission(VIEW, 'facility', 'category')){ ?> 
                                <li><a href="<?php echo site_url('facility/category/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('school_facility_category'); ?></a></li>
                            <?php } ?> 
                            <?php if(has_permission(VIEW, 'facility', 'facility')){ ?> 
                                <li><a href="<?php echo site_url('facility/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('school_facility'); ?></a></li>
                            <?php } ?> 
                            
                            </ul>                  
                            <?php } ?>  
                                <?php if(has_permission(VIEW, 'administrator', 'permission')){ ?> 
                                    <li class="treeview "><a href="<?php echo site_url('administrator/permission'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('role_permission'); ?> (ACL)</a></li> 
                                 <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'user')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/user'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_user'); ?></a></li> 
                                <?php } ?>
                                <?php if(has_permission(EDIT, 'administrator', 'username')){ ?>   
                                    <li><a href="<?php echo site_url('administrator/username/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('reset_username'); ?></a></li> 
                                 <?php } ?> 
                                <?php if(has_permission(VIEW, 'administrator', 'usercredential')){ ?>   
                                    <li><a href="<?php echo site_url('administrator/usercredential/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('user_credential'); ?></a></li> 
                                 <?php } ?> 
                                <?php if(has_permission(VIEW, 'administrator', 'superadmin')){ ?>   
                                   <li class="treeview "><a href="<?php echo site_url('administrator/superadmin'); ?>"> <i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('super_admin'); ?></a></li> 
                                 <?php } ?>
                                 <?php if(has_permission(VIEW, 'administrator', 'districtadmin')){ ?>   
                                   <li class="treeview "><a href="<?php echo site_url('administrator/districtadmin'); ?>"> <i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('district_admin'); ?></a></li> 
                                 <?php } ?>
                                <?php if(has_permission(EDIT, 'administrator', 'password')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/password'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('reset_user_password'); ?></a></li> 
                                 <?php } ?>                               
                                <?php if(has_permission(VIEW, 'administrator', 'emailtemplate')){ ?>   
                                   <li class="treeview "><a href="<?php echo site_url('administrator/emailtemplate'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('template'); ?></a></li>                         
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'smstemplate')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/smstemplate'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('sms'); ?> <?php echo $this->lang->line('template'); ?></a></li>                         
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'administrator', 'activitylog')){ ?>   
                                   <li class="treeview "><a href="<?php echo site_url('administrator/activitylog'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('activity_log'); ?></a></li>                         
                                <?php } ?>    
                                <?php if(has_permission(VIEW, 'administrator', 'feedback')){ ?>   
                                   <li class="treeview "><a href="<?php echo site_url('administrator/feedback'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('publish'); ?> <?php echo $this->lang->line('guardian'); ?><!-- <?php //echo $this->lang->line('feedback'); ?>--></a></li>                         
                                <?php } ?> 
                                <?php if(has_permission(VIEW, 'administrator', 'backup')){ ?>   
                                    <li class="treeview "><a href="<?php echo site_url('administrator/backup'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('backup'); ?> <?php echo $this->lang->line('database'); ?></a></li>                         
                                <?php } ?>   


                            </ul>

                        </li>
                    <?php } ?>



                    <?php if(has_permission(VIEW, 'frontoffice', 'purpose') ||
                             has_permission(VIEW, 'frontoffice', 'visitor') ||
                             has_permission(VIEW, 'frontoffice', 'calllog') ||
                             has_permission(VIEW, 'frontoffice', 'dispatch') ||
                             has_permission(VIEW, 'frontoffice', 'receive') ||
                             has_permission(VIEW, 'administrator', 'frontoffice')){ ?> 
                        <li><a><i class="fa fa-tty"></i> <?php echo $this->lang->line('front_office'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">                            
                                 <?php if(has_permission(VIEW, 'frontoffice', 'purpose')){ ?>   
                                    <li><a href="<?php echo site_url('frontoffice/purpose/index'); ?>"><?php echo $this->lang->line('visitor_purpose'); ?></a></li>                         
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'frontoffice', 'visitor')){ ?>   
                                    <li><a href="<?php echo site_url('frontoffice/visitor/index'); ?>"><?php echo $this->lang->line('visitor_info'); ?></a></li>                         
                                <?php } ?>                                 
                                <?php if(has_permission(VIEW, 'frontoffice', 'calllog')){ ?>   
                                    <li><a href="<?php echo site_url('frontoffice/calllog/index'); ?>"><?php echo $this->lang->line('call_log'); ?></a></li>                         
                                <?php } ?>                                 
                                <?php if(has_permission(VIEW, 'frontoffice', 'dispatch')){ ?>   
                                    <li><a href="<?php echo site_url('frontoffice/dispatch/index'); ?>"><?php echo $this->lang->line('postal_dispatch'); ?></a></li>                         
                                <?php } ?>                                 
                                <?php if(has_permission(VIEW, 'frontoffice', 'receive')){ ?>   
                                    <li><a href="<?php echo site_url('frontoffice/receive/index'); ?>"><?php echo $this->lang->line('postal_receive'); ?></a></li>                         
                                <?php } ?>                                 
                            </ul>
                        </li>                        
                    <?php } ?> 
                    
                    <?php if(has_permission(VIEW, 'hrm', 'designation') || has_permission(VIEW, 'hrm', 'employee')){ ?>    
                    <li><a><i class="fa fa-user-md"></i> <?php echo $this->lang->line('human_resource'); ?><span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php if(has_permission(VIEW, 'hrm', 'designation')){ ?>   
                                <li><a href="<?php echo site_url('hrm/designation'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_designation'); ?></a></li>
                            <?php } ?>
                            <?php if(has_permission(VIEW, 'hrm', 'employee')){ ?>   
                                <li><a href="<?php echo site_url('hrm/employee'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_employee'); ?>
                                    
                                </a>
                            </li>                            
                            <?php } ?>

                            <?php if(has_permission(VIEW, 'payroll', 'grade') || has_permission(VIEW, 'payroll', 'payment')){ ?>
                        <li><a><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('payroll'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'payroll', 'grade')){ ?>  
                                    <li><a href="<?php echo site_url('payroll/grade/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('salary_grade'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'payroll', 'payment')){ ?>  
                                    <li><a href="<?php echo site_url('payroll/payment/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('salary'); ?> <?php echo $this->lang->line('payment'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'payroll', 'payment')){ ?>  
                                    <li><a href="<?php echo site_url('payroll/history/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('payment'); ?> <?php echo $this->lang->line('history'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>   
                    <?php } ?>  

                    <?php if(has_permission(VIEW, 'leave', 'leave') || has_permission(VIEW, 'leave', 'type')){ ?>
                        <li><a><i class="fa fa-bell-o"></i> <?php echo $this->lang->line('manage_leave'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'leave', 'type')){ ?>  
                                    <li><a href="<?php echo site_url('leave/type/index'); ?>"><?php echo $this->lang->line('leave_type'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'leave', 'application')){ ?>  
                                    <li><a href="<?php echo site_url('leave/application/index'); ?>"><?php echo $this->lang->line('leave_application'); ?> </a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'leave', 'waiting')){ ?>  
                                    <li><a href="<?php echo site_url('leave/waiting/index'); ?>"><?php echo $this->lang->line('waiting_application'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'leave', 'approve')){ ?>  
                                    <li><a href="<?php echo site_url('leave/approve/index'); ?>"><?php echo $this->lang->line('approved_application'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'leave', 'decline')){ ?>  
                                    <li><a href="<?php echo site_url('leave/decline/index'); ?>"><?php echo $this->lang->line('declined_application'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>   
                    <?php } ?>    
                    
                           
                        </ul>
                    </li> 
                    <?php } ?>

                    
                        <?php if(has_permission(VIEW, 'accounting', 'discount') || 
                            has_permission(VIEW, 'accounting', 'feetype') || 
                            has_permission(VIEW, 'accounting', 'invoice') || 
                            has_permission(VIEW, 'accounting', 'duefeeemail')  || 
                            has_permission(VIEW, 'accounting', 'duefeesms') || 
                            has_permission(VIEW, 'accounting', 'exphead') || 
                            has_permission(VIEW, 'accounting', 'expenditure') || 
                            has_permission(VIEW, 'accounting', 'incomehead') || 
                            has_permission(VIEW, 'accounting', 'income')){ ?>                
                        <li><a><i class="fa fa-calculator"></i> <?php echo $this->lang->line('accounting'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                               <?php if(has_permission(VIEW, 'accounting', 'discount')){ ?>
                                    <li><a href="<?php echo site_url('accounting/discount'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('discount'); ?></a></li> 
                                <?php } ?>
                               <?php if(has_permission(VIEW, 'accounting', 'feetype')){ ?>
                                    <li><a href="<?php echo site_url('accounting/feetype'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('fee_type'); ?></a></li> 
                                <?php } ?>
                               
                                <?php if(has_permission(VIEW, 'accounting', 'invoice')){ ?>
                                    
                                    <?php if($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN){ ?>
                                        <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('due_invoice'); ?></a></li>
                                    <?php }else{ ?>
                                        <li><a href="<?php echo site_url('accounting/invoice/add'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('fee'); ?> <?php echo $this->lang->line('collection'); ?></a></li>                            
                                        <li><a href="<?php echo site_url('accounting/invoice/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_invoice'); ?></a></li>                            
                                        <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('due_fee'); ?></a></li>
                                    <?php } ?>                                    
                                <?php } ?>
                                        
                                <?php if(has_permission(VIEW, 'accounting', 'duefeeemail')){ ?>  
                                    <li><a href="<?php echo site_url('accounting/duefeeemail/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('due_fee'); ?> <?php echo $this->lang->line('email'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'accounting', 'duefeesms')){ ?>  
                                    <li><a href="<?php echo site_url('accounting/duefeesms/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('due_fee'); ?> <?php echo $this->lang->line('sms'); ?></a></li>
                                <?php } ?>
                                    
                                <?php if(has_permission(VIEW, 'accounting', 'incomehead')){ ?>
                                    <li><a href="<?php echo site_url('accounting/incomehead'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('income_head'); ?></a></li> 
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'accounting', 'income')){ ?>
                                    <li><a href="<?php echo site_url('accounting/income'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('income'); ?></a></li> 
                                <?php } ?>        
                                <?php if(has_permission(VIEW, 'accounting', 'exphead')){ ?>
                                    <li><a href="<?php echo site_url('accounting/exphead'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('expenditure_head'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'accounting', 'expenditure')){ ?>
                                    <li><a href="<?php echo site_url('accounting/expenditure'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('expenditure'); ?></a></li>
                                <?php } ?>                                
                            </ul>
                        </li> 
                    <?php } ?>



                    <?php if(has_permission(VIEW, 'hrm', 'designation') || has_permission(VIEW, 'hrm', 'employee')){ ?>    
                    <li><a><i class="fa fa-user-md"></i> <?php echo $this->lang->line('academic'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            
                            <?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
                        <li><a href="<?php echo site_url('teacher'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('teacher'); ?></a> </li>  
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'teacher', 'lecture')){ ?>
                        <li><a  href="<?php echo site_url('teacher/lecture/index/'); ?>"><i class="fa fa-file-video-o"></i> <?php echo $this->lang->line('class_lecture'); ?></a> </li>
                    <?php } ?> 
                    

                    <?php if(has_permission(VIEW, 'academic', 'classes')){ ?>
                        <li><a href="<?php echo site_url('academic/classes/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('class'); ?></a> </li> 
                    <?php } ?>

                    <?php if(has_permission(VIEW, 'academic', 'liveclass')){ ?>
                        <li><a  href="<?php echo site_url('academic/liveclass/index'); ?>"><i class="fa fa-headphones"></i> <?php echo $this->lang->line('live_class'); ?></a> </li> 
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'academic', 'lessonplan')){ ?>
                        <li><a  href="<?php echo site_url('academic/lessonplan/index'); ?>"><i class="fa fa-bars"></i> <?php echo $this->lang->line('lesson_plan'); ?></a> </li> 
                    <?php } ?>
                     
                    <?php if(has_permission(VIEW, 'academic', 'section')){ ?>
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li><a  href="<?php echo site_url('academic/section/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('section'); ?> </a></li>
                        <?php }else{ ?>                         
                            <li><a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><i class="fa fa-angle-double-right"></i></i> <?php echo $this->lang->line('section'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                            
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('academic/section/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('academic/section/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>
                                    <?php } ?>
                                </ul>                    
                            </li> 
                        <?php } ?> 
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'academic', 'subject')){ ?>                            
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li><a  href="<?php echo site_url('academic/subject/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('subject'); ?> </a></li>
                        <?php }else{ ?>      
                            <li><a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('subject'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                            
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('academic/subject/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('academic/subject/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>
                                    <?php } ?>
                                </ul>                    
                            </li>  
                        <?php } ?>
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'scheme', 'scheme')){ ?>
                         
                        <li><a href="<?php echo site_url('scheme/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('scheme'); ?></a> </li>
                         
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'academic', 'syllabus')){ ?>                        
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li><a  href="<?php echo site_url('academic/syllabus/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('syllabus'); ?></a> </li>
                        <?php }else{ ?>      
                            <li><a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('syllabus'); ?> <span class="fa fa-chevron-down"></span></a> 
                                <ul class="nav child_menu">
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('academic/syllabus/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('academic/syllabus/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>
                                    <?php } ?>
                                </ul>                    
                            </li> 
                        <?php } ?>
                    <?php } ?>

                    <?php if(has_permission(VIEW, 'academic', 'material')){ ?> 
                       <li><a  href="<?php echo site_url('academic/material/index'); ?>"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('material'); ?></a> </li> 
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'academic', 'routine')){ ?>
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li> <a  href="<?php echo site_url('academic/routine/index/'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('class'); ?> <?php echo $this->lang->line('routine'); ?></a></li>
                        <?php }else{ ?>    
                            <li> <a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>> <i class="fa fa-clock-o"></i> <?php echo $this->lang->line('class'); ?> <?php echo $this->lang->line('routine'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('academic/routine/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('academic/routine/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'academic', 'term')){ ?>
                        <li><a href="<?php echo site_url('academic/term'); ?>"><i class="fa fa-slideshare"></i> <?php echo $this->lang->line('term'); ?></a> </li> 
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'academic', 'promotion')){ ?>
                        <li><a href="<?php echo site_url('academic/promotion'); ?>"><i class="fa fa-mail-forward"></i><?php echo $this->lang->line('promotion'); ?></a></li>                   
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'academic', 'transfer')){ ?>
                        <li><a href="<?php echo site_url('academic/transfer'); ?>"><i class="fa fa-mail-forward"></i><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('transfer'); ?></a></li>                   
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'academic', 'studenttransfer')){ ?>
                        <li><a href="<?php echo site_url('academic/studenttransfer'); ?>"><i class="fa fa-mail-forward"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('transfer'); ?></a></li>                   
                    <?php } ?>
                        </ul>
                    </li> 
                    <?php } ?>
                   

                   <?php if(has_permission(VIEW, 'lessonplan', 'lessonplan') || 
                            has_permission(VIEW, 'lessonplan', 'lesson') || 
                            has_permission(VIEW, 'lessonplan', 'status') || 
                            has_permission(VIEW, 'lessonplan', 'topic')){ ?>                    
                        <li><a ><i class="fa fa-bars"></i> <?php echo $this->lang->line('lesson_plan'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu"> 
                                <?php if(has_permission(VIEW, 'lessonplan', 'lesson')){ ?>
                                    <li><a href="<?php echo site_url('lessonplan/lesson/index'); ?>"><?php echo $this->lang->line('lesson'); ?></a></li>  
                                <?php } ?> 
                                <?php if(has_permission(VIEW, 'lessonplan', 'topic')){ ?>    
                                    <li><a href="<?php echo site_url('lessonplan/topic/index'); ?>"><?php echo $this->lang->line('topic'); ?></a></li>  
                                <?php } ?> 
                                    
                                <?php if(has_permission(VIEW, 'lessonplan', 'timeline')){ ?>    
                                    <li><a href="<?php echo site_url('lessonplan/timeline'); ?>"><?php echo $this->lang->line('lesson_time_line'); ?></a></li>  
                                <?php } ?>                                
                                 <?php if(has_permission(VIEW, 'lessonplan', 'status')){ ?>    
                                    <li><a href="<?php echo site_url('lessonplan/status'); ?>"><?php echo $this->lang->line('lesson_status'); ?></a></li>  
                                <?php } ?>                                    
                                 <?php if(has_permission(VIEW, 'lessonplan', 'lessonplan')){ ?>    
                                    <li><a href="<?php echo site_url('lessonplan/index'); ?>"><?php echo $this->lang->line('lesson_plan'); ?></a></li>  
                                <?php } ?>  
                                    
                            </ul>                    
                        </li>         
                    <?php } ?> 
                   
                     <?php if(has_permission(VIEW, 'student', 'type') || 
                            has_permission(ADD, 'student', 'guardian') || 
                            has_permission(ADD, 'student', 'student') ||
                            has_permission(ADD, 'student', 'bulk') ||
                            has_permission(ADD, 'student', 'admission') ||
                            has_permission(ADD, 'student', 'activity')){ ?> 
                        
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN || $this->session->userdata('role_id') == ADMIN){ ?>
                        
                           <li><a><i class="fa fa-group"></i> <?php echo $this->lang->line('manage_student'); ?> <span class="fa fa-chevron-down"></span></a>
                               <ul class="nav child_menu">

                                    <?php if(has_permission(VIEW, 'student', 'type')){ ?>
                                        <li><a href="<?php echo site_url('student/type/index'); ?>"> <i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student_type'); ?></a></li>
                                     <?php } ?>

                                    <?php if(has_permission(VIEW, 'guardian', 'guardian')){ ?>    
                                        <li><a href="<?php echo site_url('guardian/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('guardian'); ?></a> </li>
                                    <?php } ?>
                                    <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                        <li><a href="<?php echo site_url('student/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('student'); ?></a></li>
                                     <?php } ?> 
                                    <!--<?php if(has_permission(ADD, 'student', 'student')){ ?>
                                        <li><a href="<?php echo site_url('student/add/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('student'); ?></a></li>
                                     <?php } ?> -->

                                    <?php if(has_permission(ADD, 'student', 'bulk')){ ?>
                                         <li><a href="<?php echo site_url('student/bulk/add'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('bulk'); ?> <?php echo $this->lang->line('admission'); ?></a></li>
                                    <?php } ?> 
                                    <!--<?php if(has_permission(VIEW, 'student', 'admission')){ ?>
                                         <li><a href="<?php echo site_url('student/admission/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('online'); ?> <?php echo $this->lang->line('admission'); ?></a></li>
                                    <?php } ?> -->
                                    <?php if(has_permission(VIEW, 'student', 'activity')){ ?>
                                      <li><a href="<?php echo site_url('student/activity/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('activity'); ?></a></li>
                                    <?php } ?>
                               </ul>
                           </li>   
                               
                        <?php }else{ ?>    
                            <li><a><i class="fa fa-group"></i> <?php echo $this->lang->line('student'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <?php if(has_permission(ADD, 'student', 'student')){ ?>
                                        <li><a href="<?php echo site_url('student/add/'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('admit'); ?> <?php echo $this->lang->line('student'); ?></a></li>
                                    <?php } ?>
                                    <?php if(has_permission(ADD, 'student', 'bulk')){ ?>
                                         <li><a href="<?php echo site_url('student/bulk/add'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('bulk'); ?> <?php echo $this->lang->line('admission'); ?></a></li>
                                    <?php } ?>     
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                           <li><a href="<?php echo site_url('student/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                           <li><a href="<?php echo site_url('student/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>
                                    <?php } ?> 
                                           
                                    <?php if(has_permission(ADD, 'student', 'activity')){ ?>
                                    <li><a href="<?php echo site_url('student/activity/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('activity'); ?></a></li>
                                    <?php } ?>       
                                           
                                </ul>
                            </li> 
                        <?php } ?>
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'attendance', 'student') || 
                            has_permission(VIEW, 'attendance', 'teacher') || 
                            has_permission(VIEW, 'attendance', 'employee') || 
                            has_permission(VIEW, 'attendance', 'absentemail') || 
                            has_permission(VIEW, 'attendance', 'absentsms')){ ?>
                            <li><a><i class="fa fa-check-circle-o"></i> <?php echo $this->lang->line('attendance'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'attendance', 'student')){ ?>                                    
                                    <?php if($this->session->userdata('role_id') == GUARDIAN){ ?>
                                        <li><a href="<?php echo site_url('attendance/student/guardian'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                     <?php }else{ ?>   
                                        <li><a href="<?php echo site_url('attendance/student'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                     <?php } ?>   
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'attendance', 'teacher')){ ?>
                                    <li><a href="<?php echo site_url('attendance/teacher'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'attendance', 'employee')){ ?>
                                    <li><a href="<?php echo site_url('attendance/employee'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('employee'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'attendance', 'absentemail')){ ?>  
                                    <li><a href="<?php echo site_url('attendance/absentemail/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('absent'); ?> <?php echo $this->lang->line('email'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'attendance', 'absentsms')){ ?>  
                                    <li><a href="<?php echo site_url('attendance/absentsms/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('absent'); ?> <?php echo $this->lang->line('sms'); ?></a></li>
                                <?php } ?>     
                            </ul>
                        </li> 
                    <?php } ?>
                    
                   
                    
                    <?php if(has_permission(VIEW, 'exam', 'grade') || has_permission(VIEW, 'exam', 'exam')){ ?>    
                        <li><a><i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('exam'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'exam', 'grade')){ ?>
                                    <li><a href="<?php echo site_url('exam/grade/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam_grade'); ?></a></li>                         
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'exam')){ ?>
                                    <li><a href="<?php echo site_url('exam/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam_term'); ?></a></li>                         
                                <?php } ?>

                                <?php if(has_permission(VIEW, 'exam', 'schedule')){ ?>                        
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li><a href="<?php echo site_url('exam/schedule/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('schedule'); ?></a></li>
                        <?php }else{ ?>
                            <li><a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><?php echo $this->lang->line('exam'); ?><?php echo $this->lang->line('schedule'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                                                          
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('exam/schedule/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('exam/schedule/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>                            
                                    <?php } ?>                            
                                </ul>
                            </li> 
                        <?php } ?>   
                    <?php } ?> 
                    <?php if(has_permission(VIEW, 'exam', 'suggestion')){ ?>                            
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li><a href="<?php echo site_url('exam/suggestion/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('suggestion'); ?></a></li>
                        <?php }else{ ?>    
                            <li><a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('suggestion'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                                                          
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('exam/suggestion/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?>                              
                                    <?php } ?>                              
                                </ul>
                            </li> 
                        <?php } ?> 
                    <?php } ?> 
                        
                    <?php if(has_permission(VIEW, 'exam', 'attendance')){ ?>
                        <li><a  href="<?php echo site_url('exam/attendance/'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                    <?php } ?> 
                     <?php if(has_permission(VIEW, 'assignment', 'assignment')){ ?>                        
                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                            <li>  <a href="<?php echo site_url('assignment/index/'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('assignment'); ?></a></li>
                        <?php }else{ ?>
                            <li>  <a <?php if(empty($classes)){ ?> onclick="toastr.error('<?php echo $this->lang->line('class_add_alert'); ?>');" <?php } ?>><?php echo $this->lang->line('assignment'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">                                                                                                                   
                                    <?php foreach($classes as $obj){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT && $this->session->userdata('class_id') == $obj->id){ ?>
                                            <li><a href="<?php echo site_url('assignment/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php }elseif($this->session->userdata('role_id') != STUDENT){ ?>
                                            <li><a href="<?php echo site_url('assignment/index/'.$obj->id); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('class'); ?> <?php echo $obj->name; ?></a></li>  
                                        <?php } ?> 
                                    <?php } ?> 
                                </ul>
                            </li> 
                        <?php } ?>
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'exam', 'mark') || 
                               has_permission(VIEW, 'exam', 'examresult') || 
                               has_permission(VIEW, 'exam', 'finalresult') || 
                               has_permission(VIEW, 'exam', 'meritlist') || 
                               has_permission(VIEW, 'exam', 'marksheet') || 
                               has_permission(VIEW, 'exam', 'resultcard') || 
                               has_permission(VIEW, 'exam', 'text') || 
                               has_permission(VIEW, 'exam', 'mail') || 
                               has_permission(VIEW, 'exam', 'resultemail') || 
                               has_permission(VIEW, 'exam', 'resultsms')){ ?>    
                        <li><a><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam_mark'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'exam', 'mark')){ ?>
                                    <li><a href="<?php echo site_url('exam/mark'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_mark'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'examresult')){ ?>
                                    <li><a href="<?php echo site_url('exam/examresult'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam_term'); ?> <?php echo $this->lang->line('result'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'finalresult')){ ?>
                                    <li><a href="<?php echo site_url('exam/finalresult'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam_final_result'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'meritlist')){ ?>
                                    <li><a href="<?php echo site_url('exam/meritlist'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('merit_list'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'marksheet')){ ?>
                                    <li><a href="<?php echo site_url('exam/marksheet'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('mark_sheet'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
                                    <li><a href="<?php echo site_url('exam/resultcard'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('result_card'); ?></a></li>
                                <?php } ?>                               
                                <?php if(has_permission(VIEW, 'exam', 'mail')){ ?>
                                    <li><a href="<?php echo site_url('exam/mail'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('mark_send_by_email'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'text')){ ?>
                                    <li><a href="<?php echo site_url('exam/text'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('mark_send_by_sms'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'resultemail')){ ?>  
                                    <li><a href="<?php echo site_url('exam/resultemail/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('email'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'exam', 'resultsms')){ ?>  
                                    <li><a href="<?php echo site_url('exam/resultsms/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('sms'); ?></a></li>
                                <?php } ?> 

                            </ul>
                        </li>
                    <?php } ?>   
                            </ul>
                        </li> 
                    <?php } ?>
                        
                    
                        
                       
                        
                       
                   
                        
                    <?php if(has_permission(VIEW, 'certificate', 'certificate') || has_permission(VIEW, 'certificate', 'type')){ ?>
                    <li><a><i class="fa fa-certificate"></i> <?php echo $this->lang->line('certificate'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php if(has_permission(VIEW, 'certificate', 'type')){ ?>
                                <li><a href="<?php echo site_url('certificate/type'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('certificate'); ?> <?php echo $this->lang->line('type'); ?></a></li>
                            <?php } ?>
                            <?php if(has_permission(VIEW, 'certificate', 'certificate')){ ?>
                                <li><a href="<?php echo site_url('certificate/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('generate'); ?> <?php echo $this->lang->line('certificate'); ?></a></li>
                            <?php } ?>                                
                        </ul>
                    </li>
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'library', 'book') || 
                            has_permission(VIEW, 'library', 'member') || 
                            has_permission(VIEW, 'library', 'issue')){ ?>    
                        <li><a><i class="fa fa-book"></i> <?php echo $this->lang->line('library'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'library', 'book')){ ?>
                                    <li><a href="<?php echo site_url('library/book/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('book'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'library', 'member')){ ?>
                                    <li><a href="<?php echo site_url('library/member/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('library'); ?> <?php echo $this->lang->line('member'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'library', 'issue')){ ?>
                                    <li><a href="<?php echo site_url('library/issue/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('issue_and_return'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li> 
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'transport', 'vehicle') || 
                            has_permission(VIEW, 'transport', 'route') || 
                            has_permission(VIEW, 'transport', 'member')){ ?>        
                        <li><a><i class="fa fa-bus"></i> <?php echo $this->lang->line('transport'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'transport', 'vehicle')){ ?>
                                    <li><a href="<?php echo site_url('transport/vehicle/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('vehicle'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'transport', 'route')){ ?>
                                    <li><a href="<?php echo site_url('transport/route/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_route'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'transport', 'member')){ ?>
                                    <li><a href="<?php echo site_url('transport/member/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('transport'); ?> <?php echo $this->lang->line('member'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>  
                    <?php } ?>
                        
                    <?php if(has_permission(VIEW, 'hostel', 'hostel') || 
                            has_permission(VIEW, 'hostel', 'room') || 
                            has_permission(VIEW, 'hostel', 'member')){ ?>        
                        <li><a><i class="fa fa-hotel"></i> <?php echo $this->lang->line('hostel'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'hostel', 'hostel')){ ?>
                                    <li><a href="<?php echo site_url('hostel/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_hostel'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'hostel', 'room')){ ?>
                                    <li><a href="<?php echo site_url('hostel/room/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_room'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'hostel', 'member')){ ?>
                                    <li><a href="<?php echo site_url('hostel/member/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('hostel'); ?> <?php echo $this->lang->line('member'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                   <?php } ?>
                    
                    
                    
                    <?php if(has_permission(VIEW, 'message', 'mail') || has_permission(VIEW, 'message', 'text')){ ?>
                        <li><a><i class="fa fa-envelope-o"></i> <?php echo $this->lang->line('mail_and_sms'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'message', 'message')){ ?>    
                        <li><a href="<?php echo site_url('message/inbox'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('message'); ?></a></li>                   
                    <?php } ?>
                                <?php if(has_permission(VIEW, 'message', 'mail')){ ?>  
                                    <li><a href="<?php echo site_url('message/mail/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('general'); ?> <?php echo $this->lang->line('email'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'message', 'text')){ ?>  
                                    <li><a href="<?php echo site_url('message/text/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('general'); ?> <?php echo $this->lang->line('sms'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>   
                    <?php } ?>
                    
                    <?php if(has_permission(VIEW, 'announcement', 'notice') || 
                            has_permission(VIEW, 'announcement', 'news') || 
                            has_permission(VIEW, 'announcement', 'holiday')){ ?>            
                        <li><a><i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('announcement'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if(has_permission(VIEW, 'event', 'event')){ ?>    
                                 <li><a href="<?php echo site_url('event/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('event'); ?></a></li>
                                  <?php } ?>
                    
                              <?php if(has_permission(VIEW, 'visitor', 'visitor')){ ?> 
                               <li><a href="<?php echo site_url('visitor/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('visitor_info'); ?></a></li>
                               <?php } ?>
                                <?php if(has_permission(VIEW, 'announcement', 'notice')){ ?>
                                    <li><a href="<?php echo site_url('announcement/notice/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('notice'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'announcement', 'news')){ ?>
                                    <li><a href="<?php echo site_url('announcement/news/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('news'); ?></a></li>
                                <?php } ?>
                                <?php if(has_permission(VIEW, 'announcement', 'holiday')){ ?>
                                    <li><a href="<?php echo site_url('announcement/holiday/index/'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('holiday'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>  
                    <?php } ?>
                   
                    
                    
                    
                    
                    <?php if(has_permission(VIEW, 'report', 'report')){ ?>
                        <li><a><i class="fa fa-bar-chart"></i> <?php echo $this->lang->line('report'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="<?php echo site_url('report/income'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('income'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/expenditure'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('expenditure'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/invoice'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('invoice'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/duefee'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('due_fee'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/feecollection'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('fee'); ?> <?php echo $this->lang->line('collection'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/balance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('accounting'); ?> <?php echo $this->lang->line('balance'); ?> <?php echo $this->lang->line('report'); ?></a></li> 
                                <li><a href="<?php echo site_url('report/library'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('library'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/sattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/syattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('yearly'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/tattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/tyattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('yearly'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/eattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('employee'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/eyattendance'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('employee'); ?> <?php echo $this->lang->line('yearly'); ?> <?php echo $this->lang->line('attendance'); ?></a></li>
                                <li><a href="<?php echo site_url('report/student'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/sinvoice'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('invoice'); ?> <?php echo $this->lang->line('report'); ?></a></li> 
                                <li><a href="<?php echo site_url('report/sactivity'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('activity'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/payroll'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('payroll'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/transaction'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('daily'); ?> <?php echo $this->lang->line('transaction'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/statement'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('daily'); ?> <?php echo $this->lang->line('statement'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/examresult'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('exam'); ?> <?php echo $this->lang->line('result'); ?> <?php echo $this->lang->line('report'); ?></a></li>
                            </ul>
                        </li> 
                    <?php } ?>
                   


                   <?php if(has_permission(VIEW, 'gallery', 'gallery') || has_permission(VIEW, 'gallery', 'image')){ ?>     
                    <li><a><i class="fa fa-image"></i><?php echo $this->lang->line('media_gallery'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php if(has_permission(VIEW, 'gallery', 'gallery')){ ?>
                                <li><a href="<?php echo site_url('gallery/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_gallery'); ?></a></li>
                           <?php } ?>
                           <?php if(has_permission(VIEW, 'gallery', 'image')){ ?>      
                                <li><a href="<?php echo site_url('gallery/image/index'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('manage_gallery_image'); ?></a></li>
                           <?php } ?>
                        </ul>
                    </li> 
                    <?php } ?> 
                    
                    <?php if(has_permission(VIEW, 'frontend', 'frontend') || has_permission(VIEW, 'frontend', 'slider')){ ?>
                    <li><a><i class="fa fa-desktop"></i><?php echo $this->lang->line('frontend'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <?php if(has_permission(VIEW, 'frontend', 'frontend')){ ?>
                            <li><a href="<?php echo site_url('frontend/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('manage'); ?> <?php echo $this->lang->line('page'); ?></a></li>
                            <?php } ?>
                            <?php if(has_permission(VIEW, 'frontend', 'slider')){ ?>
                                <li><a href="<?php echo site_url('frontend/slider/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('manage_slider'); ?></a></li>
                            <?php } ?>                            
                            <?php if(has_permission(VIEW, 'frontend', 'about')){ ?>
                                <li><a href="<?php echo site_url('frontend/about/index'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('frontend'); ?> <?php echo $this->lang->line('about'); ?></a></li>
                            <?php } ?> 
                            <?php if(has_permission(VIEW, 'theme', 'theme')){ ?>
                            <li><a  href="<?php echo site_url('theme'); ?>"><i class="fa fa-angle-double-right"></i><?php echo $this->lang->line('theme'); ?></a></li> 
                    <?php } ?>  
                    
                    <?php if(has_permission(VIEW, 'language', 'language')){ ?>
                        <li><a  href="<?php echo site_url('language'); ?>"><i class="fa fa-angle-double-right"></i> <?php echo $this->lang->line('language'); ?></a></li>
                    <?php } ?>                           
                        </ul>
                    </li>  
                    <?php } ?>
                     
                                   
                    
                </ul>
            </div>     
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
