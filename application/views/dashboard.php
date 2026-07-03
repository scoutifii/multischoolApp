    
<div class="content-wrapper">
    <section class="content-header">
        <h3>
            <i class="fa fa-dashboard" style="color: #000"></i> <?php echo $this->lang->line('dashboard'); ?>
        </h3>
    </section>
    <!-- top tiles -->
    <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
    <div class="row">           
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="box box-primary">            
                <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('school_statistics'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">

                        $(function () {
                           $('#school-stats').highcharts({
                                    chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: '<?php  if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>
                                                        <?php echo $this->session->userdata('school_name'); ?>
                                                    <?php }else{ ?>
                                                         <?php echo $this->global_setting->brand_name ? $this->global_setting->brand_name : SMS; ?>
                                                    <?php } ?>'
                                        },
                                        xAxis: {
                                            categories: [
                                                '<strong><?php echo $this->lang->line('school'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('class_rooms'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('class_room_blocks'); ?></strong>',
                                                '<strong><?php echo $this->lang->line('play_ground'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('toilets'); ?></strong>',
                                                '<strong><?php echo $this->lang->line('disabled_student'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('text_book'); ?></strong>',
                                                '<strong><?php echo $this->lang->line('library'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('laboratory'); ?></strong>', 
                                                '<strong><?php echo $this->lang->line('day_and_boarding'); ?></strong>',
                                                '<strong><?php echo $this->lang->line('primary_school'); ?></strong>',
                                                '<strong><?php echo $this->lang->line('teacher_quarters'); ?></strong>'
                                            ]
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: '<?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('statistics'); ?>'
                                            }
                                        },
                                        tooltip: {
                                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                            shared: true
                                        },
                                        plotOptions: {
                                            column: {
                                                stacking: 'percent'
                                            }
                                        },
                                        series: [
                                        <?php if(isset($schools) && !empty($schools)){ ?>
                                            <?php foreach($schools as $obj){ ?>
                                            {
                                                name: '<?php echo $obj->school_name; ?>',
                                                data: [<?php echo implode(',',$stats[$obj->id]); ?>]
                                            }
                                            ,                                           
                                           <?php } ?> 
                                       <?php } ?> 
                                       ],
                                    credits: {
                                        enabled: false
                                    }
                                    });
                            });
                            
                   </script>

                        <div id="school-stats" style=" width: 99%; vertical-align: top; height:450px; "></div>
                    </div>
                </div>            
            </div>  
        </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel tile overflow_hidden" style="background-color: green; color: white;">
                    <div class="x_title" style="background-color: green; color: white;">
                        <h3 class="head-title"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('calendar'); ?></h3>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="background-color: green; color: white;">
                       <div id="calendar" style="background-color: green ;color: white;"></div>
                        <link rel='stylesheet' href='<?php echo VENDOR_URL; ?>fullcalendar/lib/cupertino/jquery-ui.min.css' />
                        <link rel='stylesheet' href='<?php echo VENDOR_URL; ?>fullcalendar/fullcalendar.css' />
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/lib/jquery-ui.min.js'></script>
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/lib/moment.min.js'></script>
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/fullcalendar.min.js'></script> 
                        <script type="text/javascript">
                            $(function () {
                                $('#calendar').fullCalendar({
                                    header: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'month,agendaWeek,agendaDay'
                                    },
                                    buttonText: {
                                        today: 'today',
                                        month: 'month',
                                        week: 'week',
                                        day: 'day'
                                    },

                                    //events and holidays
                                    events: [
                                        <?php if(isset($events) && !empty($events)){ ?>
                                            <?php foreach($events as $obj){ ?>
                                            {
                                                title: "<?php echo $obj->title; ?>",
                                                start: '<?php echo date('Y-m-d', strtotime($obj->event_from)); ?>T<?php echo date('H:i:s', strtotime($obj->event_from)); ?>',
                                                end: '<?php echo date('Y-m-d', strtotime($obj->event_to)); ?>T<?php echo date('H:i:s', strtotime($obj->event_to)); ?>',
                                                backgroundColor: '<?php echo $theme->color_code; ?>', //red
                                                url: '<?php echo site_url('event/view/'.$obj->id); ?>', //red
                                                color: '#ffffff' //red
                                            },
                                            <?php } ?> 
                                        <?php } ?> 
                                        <?php if(isset($holidays) && !empty($holidays)){ ?>
                                            <?php foreach($holidays as $obj){ ?>
                                            {
                                                title: "<?php echo $obj->title; ?>",
                                                start: '<?php echo date('Y-m-d', strtotime($obj->date_from)); ?>T<?php echo date('H:i:s', strtotime($obj->date_from)); ?>',
                                                end: '<?php echo date('Y-m-d', strtotime($obj->date_to)); ?>T<?php echo date('H:i:s', strtotime($obj->date_to)); ?>',
                                                backgroundColor: '<?php echo $theme->color_code; ?>', //red
                                                url: '<?php echo site_url('announcement/holiday/view/'.$obj->id); ?>', //red
                                                color: '#ffffff' //red
                                            },
                                            <?php } ?> 
                                        <?php } ?>                                     
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        <div class="row ">
            <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-male"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL MALE STUDENTS</span>
                      <span class="info-box-number"></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 40%"></div>
                      </div>
                      <span class="progress-description">
                           Total Male Students: <?php echo $total_male_students ? $total_male_students: '0.00'; ?>
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box bg-purple">
                    <span class="info-box-icon"><i class="fa fa-female"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL FEMALE STUDENTS</span>
                      <span class="info-box-number"></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 40%"></div>
                      </div>
                      <span class="progress-description">
                           Total Female: <?php echo $total_female_students ? $total_female_students: '0.00'; ?>
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
              <!-- /.info-box -->
            </div>
        </div>
    </div> 
    <?php } ?>

    <?php if($this->session->userdata('role_id') == DISTRICT_ADMIN){ ?>
    <div class="row">           
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="box box-primary">            
                <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('school_statistics'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">

                        $(function () {
                           $('#school-stats').highcharts({
                                    chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            text: '<?php  if($this->session->userdata('role_id') != SUPER_ADMIN){ ?>
                                                        <?php echo $this->session->userdata('school_name'); ?>
                                                    <?php }else{ ?>
                                                         <?php echo $this->global_setting->brand_name ? $this->global_setting->brand_name : SMS; ?>
                                                    <?php } ?>'
                                        },
                                        xAxis: {
                                            categories: [
                                                '<strong><?php echo $this->lang->line('school_name'); ?></strong>'
                                            ]
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: '<?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('all'); ?> <?php echo $this->lang->line('statistics'); ?>'
                                            }
                                        },
                                        tooltip: {
                                            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                                            shared: true
                                        },
                                        plotOptions: {
                                            column: {
                                                stacking: 'percent'
                                            }
                                        },
                                        series: [
                                        <?php if(isset($schools_by_district) && !empty($schools_by_district)){ ?>
                                            <?php foreach($schools_by_district as $obj){ ?>
                                            {
                                                name: '<?php echo $obj->school_name; ?>',
                                                data: [<?php echo implode(',',$stats[$obj->id]); ?>]
                                            }
                                            ,                                           
                                           <?php } ?> 
                                       <?php } ?> 
                                       ],
                                    credits: {
                                        enabled: false
                                    }
                                    });
                            });
                            
                   </script>

                        <div id="school-stats" style=" width: 99%; vertical-align: top; height:450px; "></div>
                    </div>
                </div>            
            </div>  
        </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel tile overflow_hidden" style="background-color: green; color: white;">
                    <div class="x_title" style="background-color: green; color: white;">
                        <h3 class="head-title"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('calendar'); ?></h3>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="background-color: green; color: white;">
                       <div id="calendar" style="background-color: green ;color: white;"></div>
                        <link rel='stylesheet' href='<?php echo VENDOR_URL; ?>fullcalendar/lib/cupertino/jquery-ui.min.css' />
                        <link rel='stylesheet' href='<?php echo VENDOR_URL; ?>fullcalendar/fullcalendar.css' />
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/lib/jquery-ui.min.js'></script>
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/lib/moment.min.js'></script>
                        <script type="text/javascript" src='<?php echo VENDOR_URL; ?>fullcalendar/fullcalendar.min.js'></script> 
                        <script type="text/javascript">
                            $(function () {
                                $('#calendar').fullCalendar({
                                    header: {
                                        left: 'prev,next today',
                                        center: 'title',
                                        right: 'month,agendaWeek,agendaDay'
                                    },
                                    buttonText: {
                                        today: 'today',
                                        month: 'month',
                                        week: 'week',
                                        day: 'day'
                                    },

                                    //events and holidays
                                    events: [
                                        <?php if(isset($events) && !empty($events)){ ?>
                                            <?php foreach($events as $obj){ ?>
                                            {
                                                title: "<?php echo $obj->title; ?>",
                                                start: '<?php echo date('Y-m-d', strtotime($obj->event_from)); ?>T<?php echo date('H:i:s', strtotime($obj->event_from)); ?>',
                                                end: '<?php echo date('Y-m-d', strtotime($obj->event_to)); ?>T<?php echo date('H:i:s', strtotime($obj->event_to)); ?>',
                                                backgroundColor: '<?php echo $theme->color_code; ?>', //red
                                                url: '<?php echo site_url('event/view/'.$obj->id); ?>', //red
                                                color: '#ffffff' //red
                                            },
                                            <?php } ?> 
                                        <?php } ?> 
                                        <?php if(isset($holidays) && !empty($holidays)){ ?>
                                            <?php foreach($holidays as $obj){ ?>
                                            {
                                                title: "<?php echo $obj->title; ?>",
                                                start: '<?php echo date('Y-m-d', strtotime($obj->date_from)); ?>T<?php echo date('H:i:s', strtotime($obj->date_from)); ?>',
                                                end: '<?php echo date('Y-m-d', strtotime($obj->date_to)); ?>T<?php echo date('H:i:s', strtotime($obj->date_to)); ?>',
                                                backgroundColor: '<?php echo $theme->color_code; ?>', //red
                                                url: '<?php echo site_url('announcement/holiday/view/'.$obj->id); ?>', //red
                                                color: '#ffffff' //red
                                            },
                                            <?php } ?> 
                                        <?php } ?>                                     
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        <div class="row ">
            <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-male"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL MALE STUDENTS</span>
                      <span class="info-box-number"></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 40%"></div>
                      </div>
                      <span class="progress-description">
                           Male Students: <?php echo $male_student_by_district ? $male_student_by_district: '0.00'; ?>
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="info-box bg-purple">
                    <span class="info-box-icon"><i class="fa fa-female"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL FEMALE STUDENTS</span>
                      <span class="info-box-number"></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 40%"></div>
                      </div>
                      <span class="progress-description">
                           Total Female: <?php echo $female_student_by_district ? $female_student_by_district: '0.00'; ?>
                          </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
              <!-- /.info-box -->
            </div>
        </div>
    </div> 
    <?php } ?>

    <div class="row ">           
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary">            
                <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('statistics'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <?php if(isset($setting) && $setting->banner){ ?>
                     <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->banner; ?>" alt="" width="100%" height="50px"/>
                    <?php } ?>  
                    <div class="x_content">
                      <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                    <div class="row ">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <!-- Info Boxes Style 2 -->
                            <div class="info-box bg-green">
                                <a href="<?php echo site_url('administrator/school/index') ?>">
                                    <span class="info-box-icon"><i class="fa fa-university"></i></span>

                                    <div class="info-box-content"></div>
                                    <span class="info-box-text">ALL SCHOOLS: <?php echo $total_schools ? $total_schools : 0; ?>                    
                                    </span>
                                </a>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 50%"></div>
                                        <span class="info-box-text">Total students: <?php echo $total_student ? $total_student : 0; ?>                    
                                        </span>
                                    </div>
                                  
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                  
                      <!-- /.info-box -->
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-university"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">DAY SCHOOLS: <?php echo $total_day_schools ? $total_day_schools : 0; ?></span>
                              
                              <div class="progress">
                                <div class="progress-bar" style="width: 20%"></div>
                              </div>
                              <span class="">Total Students: <?php echo $total_students_day ? $total_students_day : 0; ?> </span>
                              </div>
                            <!-- /.info-box-content -->
                          </div>
                        </div>
                    <!-- /.info-box -->
                       <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-text">BOARDING SCHOOLS: <?php echo $total_boarding_schools ? $total_boarding_schools : 0; ?></span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 20%"></div>
                                  </div>
                                  <span class="">Total students: <?php echo $total_students_in_boarding_schools ? $total_students_in_boarding_schools : 0; ?> </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                      <!-- /.info-box -->
                       <div class="col-md-3 col-md-3 col-xs-12">
                          <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-university"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Day & Boarding: <?php echo $total_day_schools ? $total_day_schools : 0; ?></span>
                              
                              <div class="progress">
                                <div class="progress-bar" style="width: 20%"></div>
                              </div>
                              <span class="">Total Students: <?php echo $total_students_in_day_and_boarding_schools ? $total_students_in_day_and_boarding_schools : 0; ?></span>
                              
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                        </div>
                    </div>
                      <!-- /.info-box -->
                    <div class="row ">
                       <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-red">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-text">PUBLIC SCHOOLS: <?php echo $total_public_schools ? $total_public_schools : 0; ?></span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                  </div>
                                  <span class="">Total Students: <?php echo $total_students_in_public_schools ? $total_students_in_public_schools : 0; ?></span>                      
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                              <!-- /.info-box -->
                        </div>
                   <!-- /.info-box -->
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-university"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">PRIVATE SCHOOLS: <?php echo $total_private_schools ? $total_private_schools : 0; ?></span>
                              
                              <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                              </div>
                              <span class="">Total Students: <?php echo $total_students_in_private_schools ? $total_students_in_private_schools : 0; ?></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                              <div class="info-box bg-orange">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">SINGLE SCHOOLS: <?php echo $total_single_schools ? $total_single_schools : 0; ?></span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $total_students_in_single_schools ? $total_students_in_single_schools : 0; ?></span>
                                    
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-orange">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">MIXED SCHOOLS: <?php echo $total_mixed_schools ? $total_mixed_schools : 0; ?></span>
                                    
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $total_students_in_mixed_schools ? $total_students_in_mixed_schools : 0; ?></span>
                                    
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">PRIVATE DAY SCHOOLS:</span>
                                    <span class="info-box-number"><?php echo $private_day_schools ? $private_day_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $private_day_students ? $private_day_students : 0; ?></span>
                                    
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">PRIVATE BOARDING SCHOOLS:</span>
                                    <span class="info-box-number"><?php echo $private_boarding_schools ? $private_boarding_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $private_boarding_students ? $private_boarding_students : 0; ?></span>
                                    
                                </div>
                                    <!-- /.info-box-content -->

                                  <!-- /.info-box -->
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">PUBLIC DAY SCHOOLS: <!--?php echo $private_day_schools ? $private_day_schools : 0; ?--></span>
                                    <span class="info-box-number"><?php echo $public_day_schools ? $public_day_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $public_day_students ? $public_day_students : 0; ?></span>
                                    
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">PUBLIC BOARDING SCHOOLS:</span>
                                    <span class="info-box-number"><?php echo $public_boarding_schools ? $public_boarding_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                    <span class="">Total Students: <?php echo $public_boarding_students ? $public_boarding_students : 0; ?></span>
                                    
                                </div>
                            <!-- /.info-box-content -->

                          <!-- /.info-box -->
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-blue">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">NURSERY: <?php echo $total_nursery_schools ? $total_nursery_schools : 0; ?></span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                  <span class="">Total Students:  <?php echo $total_nursery_pupils ? $total_nursery_pupils : 0; ?></span>

                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-blue">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                 <span class="info-box-text">SECONDARY: <?php echo $total_secondary_schools ? $total_secondary_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                  <span class="">Total Students: <?php echo $total_secondary_students ? $total_secondary_students : 0; ?></span>

                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-blue">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                   <span class="info-box-text">PRIMARY: <?php echo $total_primary_schools ? $total_primary_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                   <span  class="">Total Students: <?php echo $total_primary_students ? $total_primary_students : 0; ?></span>
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-blue">
                                <span class="info-box-icon"><i class="fa fa-university"></i></span>
                                <div class="info-box-content">
                                <span class="info-box-text">TERTAIRY: <?php echo $total_tertairy_schools ? $total_tertairy_schools : 0; ?></span>

                                  <div class="progress">
                                    <div class="progress-bar" style="width: 40%"></div>
                                  </div>
                                 <span class="">Total Students: <?php echo $total_tertairy_students ? $total_tertairy_students : 0; ?></span>                            
                                </div>
                                <!-- /.info-box-content -->

                              <!-- /.info-box -->
                            </div>
                        </div>
                    </div>
                <?php } ?>   
                    <div class="row ">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-hotel"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">HOSTELS: </span>
                              <!--span class="info-box-number"></span-->

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                             <span class="">Total students: <?php echo $total_hostels ? $total_hostels : 0; ?></span>
                                   
                                  
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-university"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Class Rooms: <?php echo $total_class_rooms ? $total_class_rooms : 0; ?> </span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 20%"></div>
                              </div>
                              <span class="">Total students: <?php echo $total_student ? $total_student : 0; ?></span>
                              <span class="">Students:Class Rooms: <?php echo $total_student ? $total_student : 0; ?>:<?php echo $total_class_rooms ? $total_class_rooms : 0; ?></span>
                                  
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>          
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="info-box bg-purple">
                                <span class="info-box-icon"><i class="fa fa-building"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-text">Toilets: <?php echo $total_school_toilets ? $total_school_toilets : 0; ?></span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                  </div>
                                  <span class="">Total students: <?php echo $total_student ? $total_student : 0; ?></span>
                                  <span class="">Students:Toilets: <?php echo $total_student ? $total_student : 0; ?>:<?php echo $total_school_toilets ? $total_school_toilets : 0; ?></span> 
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <!-- Info Boxes Style 2 -->
                            <div class="info-box bg-purple">
                                <span class="info-box-icon"><i class="fa fa-blind"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-text">Disabled Students:</span>
                                  
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 50%"></div>
                                  </div>
                                  <span class="">Total students: <?php echo $total_disabled_students ? $total_disabled_students : 0; ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                          <!-- /.info-box -->
                        </div>
                    </div> 
                    <div class="row ">
                        <?php if(has_permission(VIEW, 'student', 'student')){ ?>    
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('student/index') ?>">
                                        <span class="info-box-icon bg-red"><i class="fa fa-group"></i></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?php echo $this->lang->line('total'); ?>   <?php echo $this->lang->line('student'); ?></span>
                                            <span class="info-box-number"><?php echo $total_student ? $total_student : 0; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'guardian', 'guardian')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('guardian/index/') ?>">
                                        <span class="info-box-icon bg-purple"><i class="fa fa-group"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"></i> <?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('guardian'); ?></span>
                                            <span class="info-box-number"><?php echo $total_guardian ? $total_guardian : 0; ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('teacher') ?>">
                                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"></i><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('teacher'); ?></span>
                                            <span class="info-box-number"><?php echo $total_teacher ? $total_teacher : 0; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'hrm', 'employee')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('hrm/employee') ?>">
                                        <span class="info-box-icon bg-darkblue"><i class="fa fa-group"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('employee'); ?></span>
                                            <span class="info-box-number"><?php echo $total_employee ? $total_employee :0; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'attendance', 'teacher')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('attendance/teacher/index') ?>">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-group"></i></span>
                                        <div class="info-box-content">
                                        <span class="info-box-text"><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('teacher'); ?> <?php echo $this->lang->line('absent'); ?> </span>
                                        <span class="info-box-number"><?php echo $total_teacher_absent ? $total_teacher_absent : '0.00'; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'attendance', 'student')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('attendance/student/index') ?>">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-group"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('absent'); ?> <?php echo $this->lang->line('today'); ?></span>
                                            <span class="info-box-number"><?php echo $total_student_absent ? $total_student_absent : '0.00'; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'accounting', 'income')){ ?>
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('accounting/invoice') ?>">
                                        <span class="info-box-icon bg-orange"><i class="fa fa-money"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><?php echo isset($school_setting->currency_symbol) ? $school_setting->currency_symbol : '$';  ?> 
                                            <?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('income'); ?></span>
                                            <span class="info-box-number"><?php echo $total_income ? $total_income : '0.00'; ?></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'accounting', 'expenditure')){ ?>     
                            <div class="col-md-<?php echo $widget ?> col-md-3 col-sm-3 col-xs-12">
                                <div class="info-box">
                                    <a href="<?php echo site_url('accounting/expenditure') ?>">
                                    <span class="info-box-icon bg-purple"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><?php echo isset($school_setting->currency_symbol) ? $school_setting->currency_symbol : '$';  ?> 
                                        <?php echo $this->lang->line('total'); ?> <?php echo $this->lang->line('expenditure'); ?></span>
                                        <span class="info-box-number"><?php echo $total_expenditure? $total_expenditure : '0.00'; ?></span>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>       
                    </div>  
    <!-- /top tiles -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">            
            <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                    <h4 class="head-title"><?php echo $this->lang->line('student_class_statistics'); ?></h4>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('statistics'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">

                            $(function () {
                                $('#student-stats').highcharts({
                                    chart: {
                                        type: 'pie',
                                        options3d: {
                                            enabled: true,
                                            alpha: 35,
                                            beta: 0
                                        }
                                    },
                                    title: {
                                        text: '<?php echo $this->lang->line('class'); ?> <?php echo $this->lang->line('statistics'); ?>'
                                    },
                                    tooltip: {
                                        //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            depth: 35,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.name}'
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: '<?php echo $this->lang->line('student'); ?>',
                                            data: [
                                                <?php if(isset($students) && !empty($students)){ ?>
                                                    <?php foreach($students as $obj){ ?>
                                                    ['<?php echo $this->lang->line('class'); ?> <?php echo $obj->class_name; ?>,<?php echo $obj->school_name; ?>', <?php echo $obj->total_student; ?>],
                                                    <?php } ?>
                                                <?php } ?>                                                
                                            ]
                                        }],
                                    credits: {
                                        enabled: false
                                    }
                                });
                            });
                        </script>
                        <div id="student-stats" style=" width: 100%; vertical-align: top; height:260px; "></div>
                    </div>
                </div>
            </div>
    
<?php } ?>

<?php if($this->session->userdata('role_id') == DISTRICT_ADMIN){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">            
            <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                    <h4 class="head-title"><?php echo $this->lang->line('student_class_statistics'); ?></h4>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('statistics'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">

                            $(function () {
                                $('#student-stats').highcharts({
                                    chart: {
                                        type: 'pie',
                                        options3d: {
                                            enabled: true,
                                            alpha: 35,
                                            beta: 0
                                        }
                                    },
                                    title: {
                                        text: '<?php echo $this->lang->line('class'); ?> <?php echo $this->lang->line('statistics'); ?>'
                                    },
                                    tooltip: {
                                        //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            depth: 35,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.name}'
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: '<?php echo $this->lang->line('student'); ?>',
                                            data: [
                                                <?php if(isset($studentS_by_district) && !empty($studentS_by_district)){ ?>
                                                    <?php foreach($studentS_by_district as $obj){ ?>
                                                    ['<?php echo $this->lang->line('class'); ?> <?php echo $obj->class_name; ?>,<?php echo $obj->school_name; ?>', <?php echo $obj->total_student; ?>],
                                                    <?php } ?>
                                                <?php } ?>                                                
                                            ]
                                        }],
                                    credits: {
                                        enabled: false
                                    }
                                });
                            });
                        </script>
                        <div id="student-stats" style=" width: 100%; vertical-align: top; height:260px; "></div>
                    </div>
                </div>
            </div>
    
<?php } ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4 class="head-title"><?php echo $this->lang->line('user'); ?></h4>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <script type="text/javascript">

                                        $(function () {
                                            $('#system-users').highcharts({
                                                chart: {
                                                    type: 'pie',
                                                    options3d: {
                                                        enabled: true,
                                                        alpha: 45
                                                    }
                                                },
                                                title: {
                                                    text: ''
                                                },
                                                tooltip: {
                                                    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
                                                },
                                                subtitle: {
                                                    text: ''
                                                },
                                                plotOptions: {
                                                    pie: {
                                                        allowPointSelect: true,
                                                        innerSize: 100,
                                                        depth: 30,
                                                        dataLabels: {
                                                            format: '<b>{point.name}</b>'
                                                        }
                                                    }
                                                },
                                                credits: {
                                                    enabled: false
                                                },
                                                series: [{
                                                        name: '<?php echo $this->lang->line('user'); ?>',
                                                        data: [
                                                            <?php if(isset($users) && !empty($users)){ ?>
                                                                <?php foreach($users as $obj){ ?>
                                                                ['<?php echo $obj->name; ?>', <?php echo $obj->total_user; ?>],
                                                                <?php } ?>
                                                            <?php } ?>
                                                        ]
                                                    }]
                                            });
                                        });

                                    </script>
                                    <div id="system-users" style=" width: 100%; vertical-align: top; height:260px; "></div>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">            
            <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                    <h4 class="head-title"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('google_map'); ?></h4>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">                 

         <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <!-- MAP & BOX PANE -->
                          <div class="box box-success" >
                            <div class="box-header with-border" style="background-color: green; color: white;">
                              <h3 class="box-title">Amap Showing Geo-Location of Schools in Uganda</h3>

                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">             
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="pad">
                                    <div id="kampala-map-markers" style="height: 455px; width:100%"></div>
                                  </div>
                                </div>
                              <!-- /.row -->
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                      </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <!-- Info Boxes Style 2 -->
                          <div class="info-box bg-blue">
                            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">NAKAWA DIVISION</span>
                               <span class="info-box-number">Total Schools:<?php echo $total_schools_nakawa ? $total_schools_nakawa : '0.00'; ?></span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                              <span class="progress-description">
                                    Total Students: <?php echo $total_students_nakawa ? $total_students_nakawa : '0.00'; ?>
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                          <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">CENTRAL DIVISION</span>
                              <span class="info-box-number">Total Schools:<?php echo $total_schools_central ? $total_schools_central : '0.00'; ?></span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                              <span class="progress-description">
                                    Total Students: <?php echo $total_students_central ? $total_students_central : '0.00'; ?>
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                          <div class="info-box bg-orange">
                            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text"> MAKINDYE DIVISION</span>
                               <span class="info-box-number">Total Schools:<?php echo $total_schools_makindye ? $total_schools_makindye : '0.00'; ?></span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                              <span class="progress-description">
                                    Total Students: <?php echo $total_students_makindye ? $total_students_makindye : '0.00'; ?>
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                          <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">KAWEMPE DIVISION</span>
                               <span class="info-box-number">Total Schools:<?php echo $total_schools_kawempe ? $total_schools_kawempe : '0.00'; ?></span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                              <span class="progress-description">
                                    Total Students: <?php echo $total_students_kawempe ? $total_students_kawempe : '0.00'; ?>
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                          <!-- /.info-box -->
                          <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">RUBAGA DIVISION</span>
                               <span class="info-box-number">Total Schools:<?php echo $total_schools_rubaga ? $total_schools_rubaga : '0.00'; ?></span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                              </div>
                              <span class="progress-description">
                                    Total Students: <?php echo $total_students_rubaga ? $total_students_rubaga : '0.00'; ?>
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?> 
        <div class="row">            
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel tile fixed_height_320">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('message'); ?></h4>
                        <ul class="nav navbar-left panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">
                            $(function () {
                                $('#private-message').highcharts({
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: ''
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: '<?php echo $this->lang->line('private_messaging'); ?>'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y}'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
                                    },
                                    series: [{
                                            name: '<?php echo $this->lang->line('message'); ?>',
                                            colorByPoint: true,
                                            data: [{
                                                    name: '<?php echo $this->lang->line('new'); ?>',
                                                    y: <?php echo count($new); ?>,
                                                    drilldown: null
                                                },{
                                                    name: '<?php echo $this->lang->line('inbox'); ?>',
                                                    y: <?php echo count($inboxs); ?>,
                                                    drilldown: null
                                                },{
                                                    name: '<?php echo $this->lang->line('send'); ?>',
                                                    y: <?php echo count($sents); ?>,
                                                    drilldown: null
                                                }, {
                                                    name: '<?php echo $this->lang->line('draft'); ?>',
                                                    y: <?php echo count($drafts); ?>,
                                                    drilldown: null
                                                }, {
                                                    name: '<?php echo $this->lang->line('trash'); ?>',
                                                    y: <?php echo count($trashs); ?>,
                                                    drilldown: null
                                                }]
                                        }],
                                    credits: {
                                        enabled: false
                                    }
                                });
                            });
                        </script>
                        <div id="private-message" style=" width: 100%; vertical-align: top;height: 260px;"></div>

                    </div>
                </div>
              </div>
           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?> 
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel tile fixed_height_320">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('student_status'); ?></h4>
                        <ul class="nav navbar-left panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <script type="text/javascript">
                            $(function () {
                                $('#status-type').highcharts({
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: ''
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: '<?php echo $this->lang->line('status_type'); ?>'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y}'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
                                    },
                                    series: [{
                                            name: '<?php echo $this->lang->line('student_status'); ?>',
                                            colorByPoint: true,
                                            data: [{
                                                    name: '<?php echo $this->lang->line('regular'); ?>',
                                                    y: <?php echo count($regular); ?>,
                                                    drilldown: null
                                                },{
                                                    name: '<?php echo $this->lang->line('drop_out'); ?>',
                                                    y: <?php echo count($drop_out); ?>,
                                                    drilldown: null
                                                },{
                                                    name: '<?php echo $this->lang->line('transferred'); ?>',
                                                    y: <?php echo count($transfered); ?>,
                                                    drilldown: null
                                                }, {
                                                    name: '<?php echo $this->lang->line('passed'); ?>',
                                                    y: <?php echo count($passed); ?>,
                                                    drilldown: null
                                                }]
                                        }],
                                    credits: {
                                        enabled: false
                                    }
                                });
                            });
                        </script>
                        <div id="status-type" style=" width: 100%; vertical-align: top;height: 260px;"></div>

                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('latest'); ?> <?php echo $this->lang->line('news'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul  class="list-unstyled msg_list">
                            <?php if(isset($news) && !empty($news)){ ?>
                                <?php foreach($news as $obj ){ ?>
                                <li>
                                    <a href="<?php echo site_url('announcement/news/view/'.$obj->id); ?>">
                                        <span class="image">
                                        <?php  if($obj->image != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/news/<?php echo $obj->image; ?>" alt="" width="70" />
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>default-user.png" alt="Profile Image" />
                                        <?php } ?>
                                        </span>
                                        <span><?php echo $obj->title; ?></span>                                    
                                        <span class="message">
                                        </span>
                                        <span class="time"><?php echo get_nice_time($obj->created_at); ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                        <h4 class="head-title"><?php echo $this->lang->line('latest'); ?> <?php echo $this->lang->line('notice'); ?></h4>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul  class="list-unstyled msg_list">
                            <?php if(isset($notices) && !empty($notices)){ ?>
                                <?php foreach($notices as $obj ){ ?>
                                <li>
                                    <a href="<?php echo site_url('announcement/notice/view/'.$obj->id); ?>">
                                         <span><?php echo $obj->title; ?></span>                                        
                                        <span class="message">
                                        </span>
                                        <span class="time"><?php echo get_nice_time($obj->created_at); ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>

<script src="<?php echo VENDOR_URL; ?>/chart/js/highcharts.js"></script>
<script src="<?php echo VENDOR_URL; ?>/chart/js/highcharts-3d.js"></script>
<script src="<?php echo VENDOR_URL; ?>/chart/js/modules/exporting.js"></script>
<script src="<?php echo VENDOR_URL; ?>/dist/js/moment.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>/dist/js/nprogress.js"></script>

<script src="<?php echo VENDOR_URL; ?>/dist/js/dropify.min.min.js"></script>
<script src="<?php echo VENDOR_URL; ?>/dist/js/savemode.js"></script>
<script src="<?php echo VENDOR_URL; ?>/dist/js/jquery-ui.min.js"></script>


<style type="text/css">
    .fc-time{display: none;}
</style>

<script type="text/javascript">
    var schools = [
          <?php foreach ($coordinates as $obj) {
              echo '["'.$obj->school_name.'", '.$obj->school_lat .', '.$obj->school_lng .'],';
          } 
          ?>
      ];
      
      function initAutocomplete() {
        var map;
        map = new google.maps.Map(document.getElementById('kampala-map-markers'), {
          center: {lat:0.347596, lng:32.582520}, // Kampala City Coordinates
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          mapTypeControl: false
        });
        map.setTilt(50);

        var infowindow = new google.maps.InfoWindow();
        var marker, i;

        for (i = 0; i < schools.length; i++) {  
             marker = new google.maps.Marker({
             position: new google.maps.LatLng(schools[i][1], schools[i][2]),
             map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(schools[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i))
          }
    
      }
    </script> 

    <!-- <script type="text/javascript">
        var schools = [
          <?php foreach ($coordinates as $obj) {
              echo '["'.$obj->school_name.'", '.$obj->school_lat .', '.$obj->school_lng .'],';
          } 
          ?>
        ];

        function initMapbox(){
            mapboxgl.accessToken = 'pk.eyJ1Ijoic2NvdXRpZmlpMjU2IiwiYSI6ImNtcHYzajlvZjI0MmUycnE2eml4OXU3YzgifQ.Zhx2YDkqdBQym-HuVCpD8A';

            const map = new mapboxgl.Map({
                container: 'kampala-map-markers',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [32.582520, 0.347596], // Kampala example
                zoom: 8,
                pitch: 50,  // Similar to google tilt
                bearing: 0
            });

        map.addControl(new mapboxgl.NavigationControl());

        // 4. Add markers to the map
        schools.forEach(school => {
            const name = school[0];   
            const lat = school[1];
            const lng = school[2];

            const popup = new mapboxgl.Popup({
                offset: 25,
                closeButton: true,
                closeOnClick: false
            }).setHTML(`<strong>${name}</strong>`));

            // Create marker
            new mapboxgl.Marker({
                color: '#3FB1CE'
            })
            .setLngLat([lng, lat])
            .setPopup(popup)
            .addTo(map);
        });
    }
    window.onload = initMapbox;
</script> -->